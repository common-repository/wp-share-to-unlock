<?php
define('SHTU_PLUGIN_PATH', dirname(__FILE__));
define('SHTU_PLUGIN_FOLDER', basename(SHTU_PLUGIN_PATH));

if(defined('WP_PLUGIN_URL'))
{
    define('SHTU_PLUGIN_URL',WP_PLUGIN_URL.'/'.SHTU_PLUGIN_FOLDER);
    define('SHTU_ASSETS_URL',SHTU_PLUGIN_URL.'/assets');
}
define('SHTU_ASSETS_DIR',SHTU_PLUGIN_PATH.'/assets');
define('SHTU_IMAGES_URL',SHTU_PLUGIN_URL.'/assets/images');
define('SHTU_PAGES_DIR',SHTU_PLUGIN_PATH.'/pages');
define('SHTU_TEMPLATES_DIR',SHTU_PLUGIN_PATH.'/pages/templates');

define('SHTU_CLASSES_DIR',SHTU_PLUGIN_PATH.'/classes');
define('SHTU_TABLES_DIR',SHTU_PLUGIN_PATH.'/tables');
define('SHTU_MODELS_DIR',SHTU_PLUGIN_PATH.'/models');

define('SHTU_EXPIRATION_DAYS',3);
define('SHTU_DEFAULT_TITLE_COLOR','#000000');
define('SHTU_DEFAULT_BLOCK_TITLE','Share the page to unlock the content');
define('SHTU_DEFAULT_BUTTONS_POSITION','left');


define('SHTU_DB_TABLE_CACHED_DATA', 'shtu_cached_data');

?>