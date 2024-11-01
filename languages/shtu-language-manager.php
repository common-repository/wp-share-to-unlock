<?php
class SHTU_LanguageManager
{
    /**
     * Print javascript global array of texts
     */ 
	public static function printJsLanguage()
	{
	    SHTU_Loader::includeLanguageContainer();
        $shtuLang = SHTU_LanguageContainer::getLanguageArray();
        
        if(count($shtuLang)==0)
        {
            return false;
        }
        
        foreach($shtuLang AS $key => $value)
        {
            $lang_js[] = "'".$key."' : '".$value."'";
        } 
        $lang_js_html = implode(',',$lang_js);

        $js = "<script type=\"text/javascript\">
            var jsrLang = {
                $lang_js_html
            };
             var userSettings = {
             'url': '".SITECOOKIEPATH."'
            };
        </script>";
        
        echo $js;
	}
}
?>