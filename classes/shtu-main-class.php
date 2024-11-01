<?php
/**
 * MainClass
 *
 * Main class of the plugin
 * Class encapsulates all hook handlers
 *
 */
class SHTU_MainClass
{
 /**
 * Initialize plugin environment
 */
   public static function init()
   {
       wp_enqueue_script('jq', SHTU_ASSETS_URL.'/scripts/jquery-1.7.2.min.js');
       if(is_admin())
        {
            
            // include router
            SHTU_Loader::includeRouter();
            SHTU_Router::execute();
        }
       else
       {
           wp_enqueue_style('shtu_style', SHTU_ASSETS_URL.'/css/shtu.css');
           wp_enqueue_script('shtu', SHTU_ASSETS_URL.'/js/shtu.js');
           wp_enqueue_script('fb', 'http://connect.facebook.net/en_US/all.js#xfbml=1', false);
           wp_enqueue_script('fb-custom', SHTU_ASSETS_URL.'/scripts/fb-custom.js');
           wp_enqueue_script('jq_cookie', SHTU_ASSETS_URL.'/scripts/jquery.cookie.js');
       }
   }

    public static function onActivation()
    {
        $settings_model = SHTU_Loader::getModel('settings');
        $settings_model->setActivationSettings();
        //self::prepareDB();
    }

    public static function onDeactivation()
    {
        //self::cleanDB();
        //delete_option( 'shtu_settings' );
        delete_option('shtu_message');
    }

/**
 * Prepare database of use
 */
    public static function prepareDB()
    {
        //$cd_model = SHTU_Loader::getModel('cached-data');
        //$cd_model->prepareDB();
    }

    public static function cleanDB()
    {
        //$cd_model = SHTU_Loader::getModel('cached-data');
        //$cd_model->cleanDb();
    }

/**
 * Print language texts for javascript
 */
    public static function printJsLanguage()
    {

        SHTU_Loader::includeLanguageManager();
        SHTU_LanguageManager::printJsLanguage();
    }

/**
 * Add menu items
 */
    public static function addMenuItems()
    {
        $shtu_index_slug = SHTU_PAGES_DIR.'/shtu-settings.php';
	    add_menu_page(__('Share To Unlock','share-to-unlock'),__('Share To Unlock','share-to-unlock'),'manage_options',$shtu_index_slug,'','');
        add_submenu_page($shtu_index_slug, __('<p style="color:red">Upgrade To Pro</p>','share-to-unlock'), __('<span style="color:red">Upgrade To Pro</span>','share-to-unlock'),'manage_options','http://www.wpsharetounlock.com/pro');
        if ( current_user_can('manage_options') )
        {
            global $submenu;
            //print_r($submenu);
            $submenu[SHTU_PLUGIN_FOLDER.'/pages/shtu-settings.php'][1][2]='http://www.wpsharetounlock.com/pro';
        }
    }

    public function prepareSettings($settings)
    {
       /* $settings_model = SHTU_Loader::getModel('settings');
        $user_password = $settings_model->getSetting('pass');
        */
        return $settings;

    }

    public static function shareToUnlockHandler($atts)
    {
        extract(shortcode_atts(array('redirection_url'=>''),$atts));
        if (isset($atts['redirection_url'])) {
            $redirection_url = trim($atts['redirection_url']);
        }

        if(!preg_match('/^http:\/\//i', $redirection_url) && isset($redirection_url))
        {
            $redirection_url = 'http://'.$redirection_url;
        }
        if(!isset($atts['redirection_url']) || trim($atts['redirection_url'])=='')
        {
            $redirection_url='';
        }

        return self::renderShareBlock($redirection_url);

    }

    /**
     * Method filters post's content based on cookie values.
     *
     * @param string post's content
     * @return string content
     */
    public function postContentFilter($content)
    {
        global $post;
        $post_info = self::generatePostDataHash($post->ID);

        if(isset($_COOKIE[$post_info['post_key']]) && $_COOKIE[$post_info['post_key']]==$post_info['post_value'])
        {

            $content = $post->post_content;
            $content = preg_replace('/\[share-to-unlock(.*?)\]/','',$post->post_content);
            $content = str_replace('[/share-to-unlock]','',$content);

        }
        elseif(preg_match('/(\[share-to-unlock(.*?)\])(.*)/',$post->post_content)  && array_key_exists(md5(site_url().'_post_'.$post->ID), $_COOKIE) && $_COOKIE[md5(site_url().'_post_'.$post->ID)]!=md5($post->ID))
        {

            preg_match_all('/(.*)(\[share-to-unlock(.*?)\])/i', $post->post_content, $result1, PREG_PATTERN_ORDER);
            //preg_match_all('/(\[\/share-to-unlock\])(.*)/i', $post->post_content, $result2, PREG_PATTERN_ORDER);
            $shtu_position = strpos($content, '[/share-to-unlock]');

            if(preg_match('/redirection_url="(.*)"$/', $result1[3][0], $redir_url))
            {
                if(!preg_match('/^http(.*?):\/\//i', $redir_url[1]))
                {
                    $redirection_url = 'http://'.$redir_url[1];
                }
                else
                {
                    $redirection_url = $redir_url[1];
                }
            }
            else
            {
                $redirection_url = '';
            }

            $position =  strpos($content, '[share-to-unlock');
            $prev_content = substr($content,0, $position);
            $begin_position = $shtu_position+18;
            $after_first_shortcode =  substr($content,$begin_position);
            $p_content = $after_first_shortcode;
            $content = '<div><div>'.$prev_content.'</div><div>'.self::renderShareBlock($redirection_url).'</div><div>'.$p_content.'</div></div>';

        }
        return $content;

    }

    /**
     * Method renders 'Share to unlock' form.
     *
     * @param void
     * @return string generated form
     */
    public static function renderShareBlock($url='')
    {
        global $post;
        $settings = array();
        $settings_model = SHTU_Loader::getModel('settings');
        $settings = $settings_model->getSettings();

        if(array_key_exists('bg-color', $settings) && isset($settings['bg-color']))
        {
            $block_style='style="background-color:'.$settings['bg-color'].';"';
        }
        if(array_key_exists('title-font', $settings) && isset($settings['title-font']))
        {
            $title_font = strtoupper(str_replace('-',' ',$settings['title-font']));
            $title_style='style="font-family:'.$title_font.';';
        }
        if(array_key_exists('title-clr', $settings) && isset($settings['title-clr']))
        {
            $title_style.='color:'.$settings['title-clr'].';"';
        }
        else
        {
            $title_style.='"';
        }
        if(array_key_exists('buttons-align', $settings) && isset($settings['buttons-align']))
        {
            $buttons_style='style="text-align:'.$settings['buttons-align'].' !important;"';
        }

        $form = '<form action="" method="post">
        <table class="shtu share_block" '.$block_style.'>
            <tr>
                <td style="text-align:center;">
                    <div id="block_title" '.$title_style.' >'.
                         __($settings['title'], 'share-to-unlock').'
                     </div>
                </td>
            </tr>
            <tr>
                <td>
                <div style="height:22px; overflow:hidden; padding: 0 5px 0;">
                <div class="panel" title="Like on Facebook" '.$buttons_style.'>
                        <fb:like href="'.get_permalink($post->ID).'" layout="button_count" post_id="'.$post->ID.'"  action="like" font="arial" send="false" show_faces="false" width="450"></fb:like>
                    </div>
                    </div>
                </td>
            </tr>
        </table>
        <input type="hidden" name="redirection_url_'.$post->ID.'" id="redirection_url_'.$post->ID.'" value="'.$url.'">
        <input type="hidden" name="shtu_admin_url" id="shtu_admin_url" value="'.admin_url().'">
    </form>';

    return $form;
    }

    /**
     * Method generates hash using post_id as hash source.
     *
     * @param integer post_id
     * @return mixed generated post data
     */
    private static function generatePostDataHash($post_id)
    {
        $post_data['post_key'] = md5(site_url().'_post_'.$post_id);
        $post_data['post_value'] = md5($post_id);
        return $post_data;
    }

    /**
     * Method generates hash using post_id as hash source.
     *
     * @param integer post_id
     * @return mixed generated post data
     */
    public static function removeShortcodes($post_id)
    {

        $content = $_REQUEST['content'];
        //$post_id = $_REQUEST['post_ID'];
        $shtu_position = strpos($content, '[/share-to-unlock]');
        $begin_position = $shtu_position+18;
        //echo $content.'<br>';
        $before_first_shortcode = substr($content,0, $begin_position);
        //echo $before_first_shortcode.'<br>';
        $after_first_shortcode =  substr($content,$begin_position);
        $after_first_shortcode = preg_replace('/\[share-to-unlock(.*?)\]/','',$after_first_shortcode);
        $after_first_shortcode = str_replace('[/share-to-unlock]','',$after_first_shortcode);
        //echo $after_first_shortcode;
        $p_content = $before_first_shortcode.$after_first_shortcode;
        // unhook this function so it doesn't loop infinitely
        remove_action('save_post', array(__CLASS__,'removeShortcodes'));
        // update the post, which calls save_post again
        wp_update_post(array('ID' => $post_id, 'post_content' => $p_content));
        // re-hook this function
        add_action('save_post', array(__CLASS__,'removeShortcodes'));

    }


    public static function registerShareButton() {
        // Don't bother doing this stuff if the current user lacks permissions
        if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
            return;
        }

        // Add only in Rich Editor mode
        if (get_user_option('rich_editing') == 'true') {
            add_filter("mce_external_plugins", array(__CLASS__, "addTinymcePlugin"), 5);
            add_filter('mce_buttons', array(__CLASS__, 'registerButton'));
        }
    }

    // used to insert button in wordpress 2.5x editor
    public static function registerButton($buttons) {
        //$buttons[] = 'hr';
        array_push($buttons, "|", 'wwwsharetounlock');

        return $buttons;
    }

    // Load the TinyMCE plugin : editor_plugin.js (wp2.5)
    public static function addTinymcePlugin($plugin_array) {
        $plugin_array['wwwsharetounlock'] = SHTU_ASSETS_URL.'/scripts/tinymce/editor_plugin.js';

        return $plugin_array;
    }

    public function set_update_plugin_meta_links( $links, $file ) {

        $plugin = SHTU_PLUGIN_NAME;

        // create link
        if ( $file == $plugin ) {
            return array_merge(
                $links,
                array( '<a style="font-weight: bold; color:red" href="http://www.wpsharetounlock.com/pro">Upgrade to pro</a>' )
            );
        }
        return $links;

    }

    public function onPluginLoaded()
    {
        add_action('admin_notices', array(__CLASS__,'admin_notices'));
    }

    public function admin_notices()
    {
        if(isset($_REQUEST['shtu_message']))
        {
            $show = ($_REQUEST['shtu_message'] == 'hide');
            update_option('shtu_message', $show);
        }

        if(is_admin() && current_user_can('manage_options') && !get_option('shtu_message'))
        {
        ?>
            <div class="updated" style="background-color:#F7F8FA; border-color:#444;">
                <p style="text-align:center;"><img src="http://pgimages.s3.amazonaws.com/wpsharetounlock/wpshare-to-unlock-banner-860x370.png" alt="" width="860" height="370" style="max-width:100%;" /></p>
                <p style="margin:1em 0; border-top:1px solid #ccc; padding-top:1em;">
                    <a href="http://pglikes.com/wpstursscurator" target="_blank" style="white-space:nowrap; font-size:16px!important; font-weight:bold; margin-right:1em;" class="button button-primary">Click Here To Watch Video</a>
                    <a href="<?php echo add_query_arg('shtu_message', 'hide'); ?>" class="button" style="font-style:normal;">No, I Do Not Need More Traffic</a>
                </p>
                <div class="clear"></div>
            </div>
        <?php
        }
    }

}
?>