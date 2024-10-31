<?php add_action('admin_init', array('RD_Products_No_Api_For_Amz_Setup_Sections','setup_sections'));

class RD_Products_No_Api_For_Amz_Setup_Sections{

    // Add section for config panel
    static function setup_sections(){
        add_settings_section(
            'rd_products_no_api_for_amz_section_config',
            __('Plugin Config','rd-products-no-api-for-amz'),
            false,
            'rd_products_no_api_for_amz_config_fields'
        );
        add_settings_section(
            'rd_products_no_api_for_amz_section_style',
            __('Style Options','rd-products-no-api-for-amz'),
            false,
            'rd_products_no_api_for_amz_style_fields'
        );
    }
}