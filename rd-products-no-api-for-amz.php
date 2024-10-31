<?php 
/*
Plugin Name: RD Products No API For Amazon (PRO)
Plugin URI: https://roberpena.com/plugins/no-api-amz/
Description: Get and display amazon products with no API. It will help you to start to make your first sells to obtain the API later.
Author: Rober Peña
Author URI: https://roberpena.com/
Version: 1.4
License: GPL2 or later
Text Domain: rd-products-no-api-for-amz
Domain Path: /languages
*/

if(! defined('RD_PRODUCTS_NO_API_FOR_AMAZON_VERSION')){
    define('RD_PRODUCTS_NO_API_FOR_AMAZON_VERSION', '1.4');
}

require_once plugin_dir_path(__FILE__) . 'inc/database_handler.php';
require_once plugin_dir_path(__FILE__) . 'inc/register.php';
require_once plugin_dir_path(__FILE__) . 'inc/sections.php';
require_once plugin_dir_path(__FILE__) . 'inc/setup.php';
require_once plugin_dir_path(__FILE__) . 'inc/worker/worker.php';
require_once plugin_dir_path(__FILE__) . 'inc/worker/ajax.php';
require_once plugin_dir_path(__FILE__) . 'inc/shortcodes.php';
require_once plugin_dir_path(__FILE__) . 'inc/css/style.php';

register_activation_hook(__FILE__, array('RD_Products_No_Api_For_Amz', 'activate'));
register_uninstall_hook(__FILE__, array('RD_Products_No_Api_For_Amz', 'remove'));

add_action( 'plugins_loaded', array('RD_Products_No_Api_For_Amz', 'load_internationalization'));
add_action('wp_enqueue_scripts', array('RD_Products_No_Api_For_Amz','enqueue_css'));
add_action( 'admin_enqueue_scripts', array('RD_Products_No_Api_For_Amz','enqueue_admin') ); 

class RD_Products_No_Api_For_Amz{
    
    // Create DB Table
    static function activate(){
        $db = new RD_Products_No_Api_For_Amz_Database_Handler();
        $db->create_tables();
    }
    
    // Remove DB Table
    static function remove(){
        $remove = get_option('rd_products_no_api_for_amz_remove_data', 0);
        if($remove == 1){
            $db = new RD_Products_No_Api_For_Amz_Database_Handler();
            $db->drop_tables();
        }
    }

    // Languages
    static function load_internationalization() {
        load_plugin_textdomain( 'rd-products-no-api-for-amz', false, basename(dirname(__FILE__)).'/languages/');
    }

    // Add Frontend CSS style
    static function enqueue_css(){
        $pluginURL = esc_url(plugins_url( '/inc/css/style.css' , __FILE__ ));
        wp_enqueue_style('rd_products_no_api_for_amz_style', $pluginURL, array(), RD_PRODUCTS_NO_API_FOR_AMAZON_VERSION);
    }

    // Add Admin CSS, JS, AJAX
    static function enqueue_admin(){
        $pluginCSS = esc_url(plugins_url( '/inc/css/admin.css' , __FILE__ ));
        $pluginJS = esc_url(plugins_url( '/inc/js/admin.js' , __FILE__ ));
        
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_style('rd_products_no_api_for_amz_admin_style', $pluginCSS, array(), RD_PRODUCTS_NO_API_FOR_AMAZON_VERSION);
        wp_enqueue_script('rd_products_no_api_for_amz_admin_script', $pluginJS, array('jquery', 'wp-color-picker'), RD_PRODUCTS_NO_API_FOR_AMAZON_VERSION);
        wp_localize_script('rd_products_no_api_for_amz_admin_script', 'rd_products_no_api_for_amz_admin_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    }

    // Call from AJAX
    function reload_content(){
        $id = intval($_GET['id']);
        $wk = new RD_Products_No_Api_For_Amz_Worker();
        echo $wk->generate_products_by_id($id);
        exit;
    }

    // Call from AJAX
    function reload_multiple_content(){
        $ids = sanitize_text_field($_GET['ids']);
        $wk = new RD_Products_No_Api_For_Amz_Worker();
        $wk->generate_multiple_products_by_id($ids);
        exit;
    }

    // Call from AJAX
    function create_shortcode(){
        $name = sanitize_text_field($_GET['name']);
        if(empty($name)){
            echo __('Please, add a category or keyword', 'rd-products-no-api-for-amz');
            exit;
        }
        
        $db = new RD_Products_No_Api_For_Amz_Database_Handler();
        echo $db->add_shortcode($name);
        exit;
    }

    // Call from AJAX
    function create_shortcodes_from_list(){
        $names = sanitize_textarea_field($_GET['names']);
        $nameList = preg_split("/\r\n|\n|\r/", $names);

        if(sizeof($nameList) <= 1 && strlen($nameList[0]) <= 0 ){
            echo __('Please, add categories or keywords', 'rd-products-no-api-for-amz');
            exit;
        }
        
        $db = new RD_Products_No_Api_For_Amz_Database_Handler();
        echo $db->add_shortcodes_from_list($nameList);
        exit;
    }

    // Call from AJAX
    function test_connection(){
        $wk = new RD_Products_No_Api_For_Amz_Worker();
        echo $wk->test_connection();
        exit;        
    }
}