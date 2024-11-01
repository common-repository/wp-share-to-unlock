<?php
class SHTU_Model_Settings extends SHTU_Model
{
    private $settings_array_name = 'shtu_settings';
    
/**
 * Save settings
 * 
 * @param array settings array
 */ 
    public function save(array $settings)
    {
        if(trim($settings['title'])=='')
        {
            $settings['title']=SHTU_DEFAULT_BLOCK_TITLE;
        }
        if(trim($settings['exp-date'])=='')
        {
            $settings['exp-date']=SHTU_EXPIRATION_DAYS;
        }
        if(trim($settings['buttons-align'])=='')
        {
            return 2;
        }
        //$settings = apply_filters('shtu_prepare_settings',$settings);
        //$model = SHTU_Loader::getModel('cached-data');
        //$model->cleanCache();
        return update_option($this->settings_array_name, $settings);
    }

/**
 * Return associative array of wprc settings
 */     
    public function getSettings()
    {
        return get_option($this->settings_array_name);
    }

/**
 * Get setting by name
 * 
 * @param string setting name
 */     
    public function getSetting($setting_name)
    {
        $settings = $this->getSettings();
        
        if(!is_array($settings))
        {
            return false;
        }
        
        if(!array_key_exists($setting_name, $settings))
        {
            return false;
        }
        
        return $settings[$setting_name];
    }

/**
 * Return list of predefined records
 */     
    public function getPredefinedRecords()
    {
	/*
        $settings = array(
            'allow_compatibility_reporting' => 1
        );*/
      
		$settings = array();
        return $settings;
    }
/**
 * Prepare database
 */     
    public function prepareDB()
    {
        $predefined_records = $this->getPredefinedRecords();
        
        return $this->save($predefined_records);
    }

    public function setActivationSettings()
    {
        $settingsArray = array(
            'title'=>SHTU_DEFAULT_BLOCK_TITLE,
            'title-clr'=>SHTU_DEFAULT_TITLE_COLOR,
            'buttons-align'=>SHTU_DEFAULT_BUTTONS_POSITION,
            'exp-date'=>SHTU_EXPIRATION_DAYS
        );


        update_option($this->settings_array_name,$settingsArray);
    }

}
?>