<?php
class SHTU_Model
{
    protected $wpdb = null;
    
    function __construct()
    {
        global $wpdb;

        $this->wpdb = $wpdb;
    }
}
?>