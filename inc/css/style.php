<?php

class RD_Products_No_Api_For_Amz_Do_Style{
    
    function __construct(){
        add_action( 'wp_head', array($this, 'do_style'), 99 );
    }
    
    static function do_style(){
        
        $imagesPath = plugins_url( '/images/' , dirname(__FILE__) );
        $button_color = get_option('rd_products_no_api_for_amz_button_color','#ffa500');
        $button_hover_color = get_option('rd_products_no_api_for_amz_button_color_hover', '#333333');
        $text_color = get_option('rd_products_no_api_for_amz_text_color','#ffffff');
        $text_hover_color = get_option('rd_products_no_api_for_amz_text_color_hover','#ffffff');
        $icon = get_option('rd_products_no_api_for_amz_icon','amz-icon') . '.png';

        echo '<style type="text/css">
        .rd-products-no-api-for-amz-product span{
            background-color:'. esc_attr($button_color) .';
            color:'. esc_attr($text_color) .';
            background-image:url("' . esc_url($imagesPath) . esc_attr($icon) . '");
        }
        .rd-products-no-api-for-amz-product span:hover{
            background-color:'. esc_attr($button_hover_color) .';
            color:'. esc_attr($text_hover_color) .';
        }
        </style>';
    }
}
new RD_Products_No_Api_For_Amz_Do_Style();