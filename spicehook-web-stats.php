<?php
/**
 * Plugin Name: Site Statistics - Internal Web Stats 
 * Description: A complete statistics of your website. Site Statistics - Internal Web Stats Plugin gives you a glimpse of the statistics of posts, pages and comments you have in your website. Also, it shows the server information too.
 * Tags: website stats, server informations, dashboard widget, dashboard stats, website statistics, pages count, posts count
 * Version: 1.0.0 
 * Author: SpiceHook Solutiions
 * Author URI: https://www.spicehook.com
 * Text Domain: sh-language
 * Requires at least: 4.6.0
 * Tested up to: 6.0.1
 * Requires PHP: 5.6
 * PHP Version Tested up to: 8.0
 * License: GPLv2
 */


 // protection
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
define('SH_WEB_STAT_VERSION', 10);

function sh_web_stats_register_activation_hook() {
	if ( version_compare(get_bloginfo( "version" ), "4.5", "<") ) {
		wp_die( "Please update WordPress to use this plugin" );
	}
    update_option('SH_WEB_STAT_VERSION',SH_WEB_STAT_VERSION);
}

register_deactivation_hook(__FILE__, 'sh_web_stats_deactivate');

register_uninstall_hook(__FILE__, 'sh_web_stats_deactivate_uninstall');


function sh_web_stats_deactivate_uninstall() {
    delete_option('SH_WEB_STAT_VERSION');
}

function sh_web_stats_deactivate() {
    delete_option('SH_WEB_STAT_VERSION');
}

function sh_web_stats_init() {
	register_activation_hook(__FILE__, "sh_web_stats_register_activation_hook");
	
	add_action("wp_dashboard_setup", "sh_web_stats_server_informations");
    add_action("admin_enqueue_scripts", "sh_web_stats_styles");
}

sh_web_stats_init();



function sh_web_stats_server_informations(){
    global $wp_meta_boxes;
    wp_add_dashboard_widget('sh_web_stats_server_info','Server Information','sh_web_stats_server_informations_func');

    wp_add_dashboard_widget('sh_web_stats_pages_info','Blog Posts & Pages Informations','sh_web_stats_pages_informations_func');
}
function sh_web_stats_server_informations_func(){
    
    echo '<div class="sh_stats_box">';
    echo '<div class="sh_stats_title">Server Health Informations</div>';
    echo '<div class="sh_information_box">
            <p>System: <strong>'.php_uname('s').'</strong></p>
            <p>PHP Version: <strong>'.phpversion().'</strong></p>
            <p>Memory Limit: <strong>'.ini_get('memory_limit').'</strong></p>
            <p>Max Execution Time: <strong>'.ini_get('max_execution_time').' Secons</strong></p>
            <p>Upload Max Filesize: <strong>'.ini_get('upload_max_filesize').'</strong></p>
          
         </div>';
    echo '</div>';
}


function sh_web_stats_pages_informations_func()
{
    echo '<div class="sh_stats_box">';
    echo '<div class="sh_stats_title">Blog Posts & Pages Informations</div>';
    echo '<div class="sh_information_box">
            <p>All Blog Posts count: <strong>'.count(get_posts([
                'posts_per_page' => -1,
                'depth'          => -1,
                  'post_status' => 'any',
                  'post_type'   => 'post',
            ])).'</strong></p>
            <p>Published Blog Posts count: <strong>'.count(get_posts([
                'posts_per_page' => -1,
                'depth'          => -1,
                  'post_status' => 'publish',
                  'post_type'   => 'post',
            ])).'</strong></p>

            <p>Comments count: <strong>'.get_comments_number().'</strong></p>

            <p> All Pages Count: <strong>'.count(get_posts([
                'posts_per_page' => -1,
                'depth'          => -1,
                'post_status' => 'any',
                  'post_type' => 'page'
            ])).'</strong></p>
            <p> Published Pages Count: <strong>'.count(get_posts([
                'posts_per_page' => -1,
                'depth'          => -1,
                'post_status' => 'publish',
                  'post_type' => 'page'
            ])).'</strong></p>
          
         </div>';
    echo '</div>';
}

function sh_web_stats_styles()
{
    wp_register_style("sh_web_stats_admin_style", plugin_dir_url( __FILE__ ) . "sh_webstats.css");
	wp_enqueue_style("sh_web_stats_admin_style");
}


add_action('plugins_loaded', 'sh_web_stats_plugins_update');

function sh_web_stats_plugins_update() {
    include plugin_dir_path(__FILE__) . 'update.php';
}


?>