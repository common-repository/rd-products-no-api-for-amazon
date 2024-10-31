<?php 
add_action('admin_init', array('RD_Products_No_Api_For_Amz_Setup','setup_fields'));

register_setting('rd_products_no_api_for_amz_config_fields', 'rd_products_no_api_for_amz_tag_field', array('RD_Products_No_Api_For_Amz_Setup', 'sanitize_tag_field') );
register_setting('rd_products_no_api_for_amz_config_fields', 'rd_products_no_api_for_amz_lang', array('RD_Products_No_Api_For_Amz_Setup', 'sanitize_lang') );
register_setting('rd_products_no_api_for_amz_config_fields', 'rd_products_no_api_for_amz_max_products', array('RD_Products_No_Api_For_Amz_Setup', 'sanitize_integer') );
register_setting('rd_products_no_api_for_amz_config_fields', 'rd_products_no_api_for_amz_help_link', array('RD_Products_No_Api_For_Amz_Setup', 'sanitize_bool_opt') );
register_setting('rd_products_no_api_for_amz_config_fields', 'rd_products_no_api_for_amz_remove_data', array('RD_Products_No_Api_For_Amz_Setup', 'sanitize_bool_opt') );
register_setting('rd_products_no_api_for_amz_style_fields', 'rd_products_no_api_for_amz_button_color', array('RD_Products_No_Api_For_Amz_Setup', 'sanitize_color') );
register_setting('rd_products_no_api_for_amz_style_fields', 'rd_products_no_api_for_amz_button_color_hover', array('RD_Products_No_Api_For_Amz_Setup', 'sanitize_color') );
register_setting('rd_products_no_api_for_amz_style_fields', 'rd_products_no_api_for_amz_text_color', array('RD_Products_No_Api_For_Amz_Setup', 'sanitize_color') );
register_setting('rd_products_no_api_for_amz_style_fields', 'rd_products_no_api_for_amz_text_color_hover', array('RD_Products_No_Api_For_Amz_Setup', 'sanitize_color') );
register_setting('rd_products_no_api_for_amz_style_fields', 'rd_products_no_api_for_amz_button_text', array('RD_Products_No_Api_For_Amz_Setup', 'sanitize_button_text') );
register_setting('rd_products_no_api_for_amz_style_fields', 'rd_products_no_api_for_amz_icon', array('RD_Products_No_Api_For_Amz_Setup', 'sanitize_icon') );
register_setting('rd_products_no_api_for_amz_style_fields', 'rd_products_no_api_for_amz_class', array('RD_Products_No_Api_For_Amz_Setup', 'sanitize_container_class') );

class RD_Products_No_Api_For_Amz_Setup {

    // Sanitize Tag
    static function sanitize_tag_field($input){
        $output = sanitize_html_class($input);
        if(empty($output) || $output == "")
            return "rd-tag-21";
        else return $output;
    }

    // Sanitize lang
    static function sanitize_lang($input){
        $output = sanitize_text_field($input);
        if(empty($output) || $output == "")
            return "es";
        else return $output;
    }

    // Sanitize Boolean
    static function sanitize_bool_opt($input){
        if($input != 1 ) return 0;
        else return $input;
    } 

    // Sanitize color
    static function sanitize_color($input){
        $output = sanitize_text_field($input);
        if ( preg_match( '/^#[a-f0-9]{6}$/i', $output ) ) {
            return $output;
        } else return "#ffa500";
    }

    // Sanitize Icon
    static function sanitize_icon($input){
        if(
            $input == "amz-icon-white" ||
            $input == "amz-icon-negative" ||
            $input == "amz-icon-dark" 
        )
            return $input;
        else
            return "amz-icon";
    }

    // Sanitize Columns Class
    static function sanitize_container_class($input){
        if($input == "rd-products-no-api-for-amz-half")
            return $input;
        else
            return "rd-products-no-api-for-amz-third";
    }

    // Sanitize text
    static function sanitize_button_text($input){
        $output = sanitize_text_field($input);
        if(empty($output) || $output == "")
            return __('Open in Amazon','rd-products-no-api-for-amz');
        else return $output;
    }

    // Sanitize int
    static function sanitize_integer($input){
        $output = absint($input);
        if(empty($output) || $output < 3) return 9;
        else return $output;
    }
    
    // Add settings fields to config menu panel
    static function setup_fields(){
        $field_config = "rd_products_no_api_for_amz_config_fields";
        $field_style = "rd_products_no_api_for_amz_style_fields";
        $section_config = "rd_products_no_api_for_amz_section_config";
        $section_style = "rd_products_no_api_for_amz_section_style";

        add_settings_field(
            'rd_products_no_api_for_amz_tag_field',
            __('Affililate Tag', 'rd-products-no-api-for-amz'),
            array('RD_Products_No_Api_For_Amz_Setup', 'text_field_callback'),
            $field_config,
            $section_config,
            array(
                'name' => 'rd_products_no_api_for_amz_tag_field', 
                'message' => __('If tag field is empty a custom tag will be used','rd-products-no-api-for-amz'),
                'default' => 'rd-tag-21'
                )
        );

        add_settings_field(
            'rd_products_no_api_for_amz_lang',
            __('Select Market', 'rd-products-no-api-for-amz'),
            array('RD_Products_No_Api_For_Amz_Setup', 'lang_select_callback'),
            $field_config,
            $section_config,
            array(
                'name' => 'rd_products_no_api_for_amz_lang'
                )
        );

        add_settings_field(
            'rd_products_no_api_for_amz_max_products',
            __('Max Products', 'rd-products-no-api-for-amz'),
            array('RD_Products_No_Api_For_Amz_Setup', 'max_products_callback'),
            $field_config,
            $section_config,
            array(
                'name' => 'rd_products_no_api_for_amz_max_products', 
                'message' => __('Max number of products in each category (change before search products)','rd-products-no-api-for-amz'),
                'default' => '9'
                )
        );

        add_settings_field(
            'rd_products_no_api_for_amz_help_link',
            __('Help with a very little link below products list', 'rd-products-no-api-for-amz'),
            array('RD_Products_No_Api_For_Amz_Setup', 'help_link_callback'),
            $field_config,
            $section_config,
            array(
                'name' => 'rd_products_no_api_for_amz_help_link',
                'default' => 0
                )
        );

        add_settings_field(
            'rd_products_no_api_for_amz_remove_data',
            __('Delete data on remove plugin', 'rd-products-no-api-for-amz'),
            array('RD_Products_No_Api_For_Amz_Setup', 'remove_data_callback'),
            $field_config,
            $section_config,
            array(
                'name' => 'rd_products_no_api_for_amz_remove_data',
                'default' => 0
                )
        );

        add_settings_field(
            'rd_products_no_api_for_amz_button_color',
            __('Button Color','rd-products-no-api-for-amz'),
            array('RD_Products_No_Api_For_Amz_Setup', 'color_field_callback'),
            $field_style,
            $section_style,
            array(
                'name' => 'rd_products_no_api_for_amz_button_color',
                'color' => '#ffa500',
                'button' => true
                )
        );

        add_settings_field(
            'rd_products_no_api_for_amz_button_color_hover',
            __('Button Color Hover','rd-products-no-api-for-amz'),
            array('RD_Products_No_Api_For_Amz_Setup', 'color_field_callback'),
            $field_style,
            $section_style,
            array(
                'name' => 'rd_products_no_api_for_amz_button_color_hover',
                'color' => '#333333',
                'button' => false
                )
        );

        add_settings_field(
            'rd_products_no_api_for_amz_text_color',
            __('Text Color','rd-products-no-api-for-amz'),
            array('RD_Products_No_Api_For_Amz_Setup', 'color_field_callback'),
            $field_style,
            $section_style,
            array(
                'name' => 'rd_products_no_api_for_amz_text_color',
                'color' => '#ffffff',
                'button' => false
                )
        );

        add_settings_field(
            'rd_products_no_api_for_amz_text_color_hover',
            __('Text Color Hover','rd-products-no-api-for-amz'),
            array('RD_Products_No_Api_For_Amz_Setup', 'color_field_callback'),
            $field_style,
            $section_style,
            array(
                'name' => 'rd_products_no_api_for_amz_text_color_hover',
                'color' => '#ffffff',
                'button' => false
                )
        );
        
        add_settings_field(
            'rd_products_no_api_for_amz_button_text',
            __('Button Text','rd-products-no-api-for-amz'),
            array('RD_Products_No_Api_For_Amz_Setup', 'text_field_callback'),
            $field_style,
            $section_style,
            array(
                'name' => 'rd_products_no_api_for_amz_button_text',
                'default' => __('Open in Amazon', 'rd-products-no-api-for-amz')
                )
        );
        
        add_settings_field(
            'rd_products_no_api_for_amz_icon',
            __('Icon Color','rd-products-no-api-for-amz'),
            array('RD_Products_No_Api_For_Amz_Setup', 'select_icon_callback'),
            $field_style,
            $section_style,
            array(
                'name' => 'rd_products_no_api_for_amz_icon',
                'default' => 'amz-icon'
                )
        );
        
        add_settings_field(
            'rd_products_no_api_for_amz_class',
            __('Number of Columns','rd-products-no-api-for-amz'),
            array('RD_Products_No_Api_For_Amz_Setup', 'select_class_callback'),
            $field_style,
            $section_style,
            array(
                'name' => 'rd_products_no_api_for_amz_class',
                'default' => 'rd-products-no-api-for-amz-third'
                )
        );
    }

    // Color picker
    static function color_field_callback($args){
        $name = sanitize_html_class($args['name']);
        $color = sanitize_hex_color($args['color']);
        echo '<input type="text" name="' . esc_attr($name) . '" value="' . esc_attr(get_option($name, $color)) . '" class="' . esc_attr($name) . '"/>';
        if($args['button']) { 
            $imagesPath = plugins_url( '/images/' , __FILE__ ); ?>
            <span id="admin-button-example" style="background-image: url('<?php echo $imagesPath . esc_attr(get_option('rd_products_no_api_for_amz_icon', 'amz-icon'));?>.png')"><?php echo esc_attr(get_option('rd_products_no_api_for_amz_button_text',__('Open in Amazon','rd-products-no-api-for-amz')));?></span>
        <?php }
    }

    // General text input by args
    static function text_field_callback($args){
        $name = sanitize_html_class($args['name']);
        $default = sanitize_text_field($args['default']);
        $message;
        if(array_key_exists('message', $args))
            $message = sanitize_text_field($args['message']);

        echo '<input type="text" name="' 
        . esc_attr($name) . '" id="' 
        . esc_attr($name) . '" value ="' 
        . esc_attr(get_option($name, $default)) . '"/>';

        if(!empty($message))
            echo '<label><i> ' . esc_html($message) . '</i></label>';
    }

    // Select Icon
    static function select_icon_callback($args){
        $name = sanitize_html_class($args['name']);
        $default = sanitize_html_class($args['default']);
        $option = esc_attr(get_option($name, $default));
        $imagesPath = plugins_url( '/images/' , __FILE__ );
        ?>

        <input type="radio" name="<?php echo esc_attr($name);?>" value="amz-icon" <?php checked($option, 'amz-icon');?>>
        <img id="amz_icon" src="<?php echo $imagesPath;?>amz-icon.png"/>

        <input type="radio" name="<?php echo esc_attr($name);?>" value="amz-icon-negative" <?php checked($option, 'amz-icon-negative');?>>
        <img id="amz_icon" src="<?php echo $imagesPath;?>amz-icon-negative.png"/>

        <input type="radio" name="<?php echo esc_attr($name);?>" value="amz-icon-white" <?php checked($option, 'amz-icon-white');?>>
        <img id="amz_icon" src="<?php echo $imagesPath;?>amz-icon-white.png"/>
        
        <input type="radio" name="<?php echo esc_attr($name);?>" value="amz-icon-dark" <?php checked($option, 'amz-icon-dark');?>>
        <img id="amz_icon" src="<?php echo $imagesPath;?>amz-icon-dark.png"/>
        <?php
    }

    // Select Icon
    static function select_class_callback($args){
        $name = sanitize_html_class($args['name']);
        $default = sanitize_html_class($args['default']);
        $option = esc_attr(get_option($name, $default));
        $imagesPath = plugins_url( '/images/' , __FILE__ );
        ?>

        <input type="radio" name="<?php echo esc_attr($name);?>" value="rd-products-no-api-for-amz-third" <?php checked($option, 'rd-products-no-api-for-amz-third');?>>
        <img id="columns_icon" src="<?php echo $imagesPath;?>three-columns-icon.png"/>

        <input type="radio" name="<?php echo esc_attr($name);?>" value="rd-products-no-api-for-amz-half" <?php checked($option, 'rd-products-no-api-for-amz-half');?>>
        <img id="columns_icon" src="<?php echo $imagesPath;?>two-columns-icon.png"/>
        <?php
    }

    // Display help link
    static function help_link_callback($args){
        $name = sanitize_html_class($args['name']);
        $option = esc_attr(get_option($name, $args['default']));
        echo '<input type="checkbox" value="1" 
        name="' . esc_attr($name) . '"' 
        . checked(1, $option, false )
        . '/>';
        
    }

    // Select remove Data
    static function remove_data_callback($args){
        $name = sanitize_html_class($args['name']);
        $option = esc_attr(get_option($name, $args['default']));
        echo '<input type="checkbox" value="1" 
        name="' . esc_attr($name) . '"' 
        . checked(1, $option, false )
        . '/>';
        
    }

    // Select market 'country'
    static function lang_select_callback($args){
        $name = sanitize_html_class($args['name']);
        $option = esc_attr(get_option($name, 'es'));
        ?>

        <select name="<?php echo esc_attr($name);?>">
            <option value="es" <?php selected($option, "es");?>>ES</option>
            <option value="br" <?php selected($option, "br");?>>BR</option>
            <option value="ca" <?php selected($option, "ca");?>>CA</option>
            <option value="cn" <?php selected($option, "cn");?>>CN</option>
            <option value="de" <?php selected($option, "de");?>>DE</option>
            <option value="fr" <?php selected($option, "fr");?>>FR</option>
            <option value="in" <?php selected($option, "in");?>>IN</option>
            <option value="it" <?php selected($option, "it");?>>IT</option>
            <option value="mx" <?php selected($option, "mx");?>>MX</option>
            <option value="uk" <?php selected($option, "uk");?>>UK</option>
            <option value="us" <?php selected($option, "us");?>>US</option>
        </select>

        <?php
    }

    // Select Max Products
    static function max_products_callback($args){
        $name = sanitize_html_class($args['name']);
        $option = esc_attr(get_option($name, '9'));
        $message;
        if(array_key_exists('message', $args))
            $message = sanitize_text_field($args['message']);

        ?>

        <select name="<?php echo esc_attr($name);?>">
            <option value="3" <?php selected($option, "3");?>>3</option>
            <option value="6" <?php selected($option, "6");?>>6</option>
            <option value="9" <?php selected($option, "9");?>>9</option>
            <option value="12" <?php selected($option, "12");?>>12</option>
            <option value="15" <?php selected($option, "15");?>>15</option>
            <option value="18" <?php selected($option, "18");?>>18</option>
            <option value="21" <?php selected($option, "21");?>>21</option>
            <option value="24" <?php selected($option, "24");?>>24</option>
            <option value="27" <?php selected($option, "27");?>>27</option>
            <option value="30" <?php selected($option, "30");?>>30</option>
        </select>

        <?php
        if(!empty($message))
            echo '<label><i> ' . esc_html($message) . '</i></label>';
    }
}