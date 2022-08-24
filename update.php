<?php
// protection
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $wpdb;

if(get_option('SH_WEB_STAT_VERSION')==null || get_option('SH_WEB_STAT_VERSION') < 10)
{
   update_option('SH_WEB_STAT_VERSION',SH_WEB_STAT_VERSION);
}

?>