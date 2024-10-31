<?php
add_action('admin_menu', array('RD_Products_No_Api_For_Amz_Register_Menu','setup_admin_panel'));

// Register the menu and submenus to admin panel
class RD_Products_No_Api_For_Amz_Register_Menu{
    
    static function setup_admin_panel(){
        $slug = "rd-products-no-api-for-amz-menu";

        add_menu_page(
            "RD products no API for AMAZON",
            "RDNoApi (PRO)",
            "manage_options",
            $slug,
            array('RD_Products_No_Api_For_Amz_Register_Menu', "register_config_page"),
            'dashicons-feedback',
            100
        );

        add_submenu_page(
            $slug,
            __('CONFIGURATION', 'rd-products-no-api-for-amz') . ' | RD products no API for AMAZON',
            __('Configuration', 'rd-products-no-api-for-amz'),
            "manage_options",
            "rd-products-no-api-for-amz-menu",
            array('RD_Products_No_Api_For_Amz_Register_Menu', "register_config_page"),
            1
        );

        add_submenu_page(
            $slug,
            __('STYLE', 'rd-products-no-api-for-amz') . ' | RD products no API for AMAZON',
            __('Style', 'rd-products-no-api-for-amz'),
            "manage_options",
            "rd-products-no-api-for-amz-style-menu",
            array('RD_Products_No_Api_For_Amz_Register_Menu', "register_style_page"),
            2
        );

        add_submenu_page(
            $slug,
            "SHORTCODES | RD products no API for AMAZON",
            "Shortcodes",
            "manage_options",
            "rd-products-no-api-for-amz-shortcodes-menu",
            array('RD_Products_No_Api_For_Amz_Register_Menu', "register_shortcodes_page"),
            3
        );

        add_submenu_page(
            $slug,
            __('NEW SHORTCODE','rd-products-no-api-for-amz') . ' | RD products no API for AMAZON',
            __('New', 'rd-products-no-api-for-amz'),
            "manage_options",
            "rd-products-no-api-for-amz-add-menu",
            array('RD_Products_No_Api_For_Amz_Register_Menu', "register_create_shortcode_page"),
            4
        );
    }

    // Pages callbacks
    static function register_config_page(){
        require_once plugin_dir_path(__FILE__) . 'pages/config_page.php';
    }
    static function register_style_page(){
        require_once plugin_dir_path(__FILE__) . 'pages/style_page.php';
    }

    static function register_shortcodes_page(){
        require_once plugin_dir_path(__FILE__) . 'pages/shortcodes_page.php';
    }

    static function register_create_shortcode_page(){
        require_once plugin_dir_path(__FILE__) . 'pages/create_shortcode_page.php';
    }
}