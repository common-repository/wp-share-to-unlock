<?php
class SHTU_Controller_Settings extends SHTU_Controller
{
    /**
      * Save wprc settings
      *
      * @param array $_GET array
      * @param array $_POST array
      */
    public function save($get, $post)
    {
        $settings = array();
        $settings = $post;
        $settings_model = SHTU_Loader::getModel('settings');
        $result = $settings_model->save($settings);
        if($result===true)
        {
            $flag=1;
        }
        elseif($result==2)
        {
            $flag=2;
        }
        elseif($result===false)
        {
            $flag=0;
        }
        $this->redirectToIndex($flag);

    }
    /**
     * Redirect to the index page
     *
     * @param string result flag
     */
    public function redirectToIndex($flag)
    {
         $index_page = admin_url().'admin.php?page='.SHTU_PLUGIN_FOLDER.'/pages/shtu-settings.php&result='.$flag;
         header('location: '.$index_page);
    }
}
?>