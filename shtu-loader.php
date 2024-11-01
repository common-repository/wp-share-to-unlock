<?php
/**
 * SHTU_Loader
 * 
 * This class is responsible for including of all files and getting of instances of all objects
 *
 */
class SHTU_Loader
{
 /**
  * Include file
  * 
  * @param string file name
  */    
    private static function includeFile($file_name)
    {
        if(!file_exists($file_name))
        {
            printf(__('File "%s" doesn\'t exist!','share-to-unlock'), $file_name);
            return false;
        }

        include_once($file_name);
    }

/**
 * Include file of WP Repository Client plugin
 */     
    private static function includePluginFile($file_name)
    {
        $file_name = SHTU_PLUGIN_PATH.'/'.$file_name;
        self::includeFile($file_name);
    }

/**
 * Include plugin.php file
 */ 
    public static function includeWPPluginFile()
    {
        self::includeFile(ABSPATH.'/wp-admin/includes/plugin.php');
    }
    
    public static function includeDebug()
    {
        self::includeFile(SHTU_CLASSES_DIR.'/shtu-debug.php');
    }
    
/**
 * Include template by name
 *
 * @param string template name
 */    
    public static function includeTemplate($template_name, $template_dir='')
    {
        $template_dir_path = ($template_dir <> '') ? $template_dir.'/' : '';
        $template_path = SHTU_TEMPLATES_DIR.'/'.$template_dir_path.$template_name.'.tpl.php';
        
        self::includeFile($template_path);
    }

/**
 * Include page by name
 *
 * @param string page name
 * @param string page display mode
 */     
    public static function includePage($page_name)
    {
        $page_path = SHTU_PAGES_DIR.'/'.$page_name.'.php';
        
        self::includeFile($page_path);
    }

    /**
     * Include widget by name
     *
     * @param string widget name
     * @param string widget display mode
     */
    public static function includeWidget($widget_name)
    {
        $page_path = SHTU_WIDGET_DIR.'/shtu-widget-'.$widget_name.'.php';

        self::includeFile($page_path);
    }

    /**
     * Include template by name
     *
     * @param string template name
     */
    public static function includeWidgetTemplate($widget_template_name, $widget_template_dir='')
    {
        $widget_template_dir_path = ($widget_template_dir <> '') ? $widget_template_dir.'/' : '';
        $widget_template_path = SHTU_WIDGET_TEMPLATES_DIR.'/'.$widget_template_dir_path.$widget_template_name.'.tpl.php';

        self::includeFile($widget_template_path);
    }
 
 /**
  * Include admin panel header
  * 
  * @param bool disable admin panel menus
  */    
    public static function includeAdminTop($disable_menus = false)
    {
        $disable_menus_css = '<style type="text/css">   #adminmenuwrap, #screen-meta-links {display:none;}   </style>';
        
        self::includeFile(ABSPATH . 'wp-admin/admin-header.php');
        
        if($disable_menus)
        {
            echo $disable_menus_css;
        }
    }

/**
 * Get istance of RepositoryConnector
 * 
 */    
    public static function getRepositoryConnector()
    {
        self::includeFile(SHTU_CLASSES_DIR.'/shtu-repository-connector.php');
        return new WPMUC_RepositoryConnector();
    }
    
/**
 * IncludeWPMUC_UrlAnalyzer class
 * 
 */    
    public static function includeUrlAnalyzer()
    {
        self::includeFile(SHTU_CLASSES_DIR.'/shtu-url-analyzer.php');
    }
    
/**
 * Include RepositoryClient class
 * 
 */    
    public static function includeMainClass()
    {
        self::includeFile(SHTU_CLASSES_DIR.'/shtu-main-class.php');
    }
    
/**
 * Include wordpress http.php file
 */   
    public static function includeWordpressHttp()
    {
        self::includeFile(ABSPATH.WPINC.'/http.php');
    }
 
 /**
  * Include LanguageContainer
  */    
    public static function includeLanguageContainer()
    {
        self::includePluginFile('languages/shtu-language-container.php');
    }

/**
 * Include LanguageManager
 */     
    public static function includeLanguageManager()
    {
        self::includePluginFile('languages/shtu-language-manager.php');
    }

/**
 * Include plugin router
 */     
    public static function includeRouter()
    {
        self::includePluginFile('core/shtu-router.php');
    }

/**
 * Form class name from the file name
 * 
 * e.g. 'repository-reporter' => 'RepositoryReporter'
 * 
 * @access private
 * @param string file name
 * 
 * @return string class name
 */ 
    private static function getClassNameFromFileName($file_name)
    {
        if($file_name=='')
        {
            return false;
        }
        
        $name_parts = explode('-',$file_name);
        
        for($i=0; $i<count($name_parts); $i++)
        {
            $name_parts[$i] = ucfirst($name_parts[$i]);
        }
        
        return implode('',$name_parts);
    }
    

/**
 * Return instance of controller by name
 * 
 * @param string short controller name (without 'controller-' prefix)
 * 
 * @return object Controller instance
 */     
    public static function getController($short_file_name)
    {   
        $controller_class_name = 'SHTU_Controller_'.self::getClassNameFromFileName($short_file_name);

        if(!$controller_class_name)
        {
            return false;
        }
        
        $controller_file_name = 'shtu-controller-'.$short_file_name;
        $controller_path = 'controllers/'.$controller_file_name.'.php';
        
        self::includePluginFile('core/shtu-controller.php');
        self::includePluginFile($controller_path);
        
        if(!class_exists($controller_class_name))
        {
            return false;
        }
        
        return new $controller_class_name();
    }

/**
 * Include class-wp-list-table file
 */     
    public static function includeWPListTable()
    {
        if(!class_exists('WP_List_Table'))
        {
            $file_name = ABSPATH.'/wp-admin/includes/class-wp-list-table.php';
            self::includeFile($file_name);
        }
    }

/**
 * Include WPRC list table by name
 * 
 * @param string table list name
 */    
    public static function includeListTable($table_name)
    {
        self::includeFile(SHTU_TABLES_DIR.'/'.$table_name.'.php');
    }
    
    public static function getListTable($table_name)
    {
       $class_name = self::getClassNameFromFileName($table_name);
       $class_name = 'SHTU_'.$class_name.'_List_Table';
       
       $table_name = 'shtu-'.$table_name.'-list-table';
       
       self::includeWPListTable();
       self::includeListTable($table_name);
       
       return new $class_name();
    }
    
 /**
 * Include WPRC model by name
 * 
 * @param string model name
 */    
    public static function getModel($short_file_name)
    {
        $model_class_name = 'SHTU_Model_'.self::getClassNameFromFileName($short_file_name);

        if(!$model_class_name)
        {
            return false;
        }
        
        $model_file_name = 'shtu-model-'.$short_file_name;
        $model_path = SHTU_MODELS_DIR.'/'.$model_file_name.'.php';
        
        self::includePluginFile('core/shtu-model.php');
        self::includeFile($model_path);
        
        if(!class_exists($model_class_name))
        {
            return false;
        }
        
        return new $model_class_name();
    }

    public static function includeSiteEnvironment()
    {
        self::includeFile(SHTU_CLASSES_DIR.'/shtu-site-environment.php');
    }

    public static function getMonitors()
    {
        require_once(SHTU_CLASSES_DIR.'/shtu-monitors.php');
        return new  SHTU_Monitors();
    }

    public static function includeClass($file_name)
    {
        self::includeFile(SHTU_CLASSES_DIR.'/'.$file_name);
    }

    public static function getDataCacher()
    {
        self::includeClass('shtu-data-cacher.php');
        return new SHTU_DataCacher(__CLASS__);
    }

    public static function badgesBelow($id='')
    {

        $data[] = "<a href='http://monitor.us/?ref=button1'><img src='http://images.monitor.us/monbadges100-90.png' title='Monitor.us - Free website, server & network monitoring tool' border=0 /></a>";
        $data[] = "<a href='http://monitor.us/?ref=button2'><img src='http://images.monitor.us/monbadges120-40.png' title='Monitor.us - Free website, server & network monitoring tool' border=0 /></a>";
        $data[] = "<a href='http://monitor.us/?ref=button3'><img src='http://images.monitor.us/monbadgesWhiteBG100-90.png' title='Monitor.us - Free website, server & network monitoring tool' border=0 /></a>";
        $data[] = "<a href='http://monitor.us/?ref=button4'><img src='http://images.monitor.us/monbadgesWhiteBG120-40.png' title='Monitor.us - Free website, server & network monitoring tool' border=0 /></a>";
        if ($id!=='')
        {
            return $data[$id-1];
        }
        return $data;
    }


    public static function includeAssets($mode='')
    {
        if($mode == 'include-easy-ui')
        {
            wp_enqueue_style('easyui_icon',SHTU_ASSETS_URL.'/scripts/easyui/themes/icon.css');
            wp_enqueue_style('easyui_css',SHTU_ASSETS_URL.'/scripts/easyui/themes/gray/easyui.css');
		    wp_enqueue_style('minicolors_style', SHTU_ASSETS_URL.'/scripts/mini-colors/jquery.miniColors.css');
            wp_enqueue_script('minicolors_js', SHTU_ASSETS_URL.'/scripts/mini-colors/jquery.miniColors.js');

            wp_enqueue_script('jquery_easyui_min_js', SHTU_ASSETS_URL.'/scripts/easyui/jquery.easyui.min.js');
            wp_enqueue_script('jq-qtip', SHTU_ASSETS_URL.'/scripts/qtip/jquery.qtip-1.0.0-rc3.min.js');
            wp_enqueue_script('qtips', SHTU_ASSETS_URL.'/js/qtips.js');
        }
    }


}
?>