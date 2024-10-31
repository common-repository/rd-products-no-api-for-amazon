<?php
require_once plugin_dir_path(__FILE__) . '/library/dom.php';

class RD_Products_No_Api_For_Amz_Worker extends RD_Products_No_Api_For_Amz_Database_Handler{

    // Amazon Markets
    private $lang = array(
        'br'    =>  'amazon.com.br',
        'ca'    =>  'amazon.ca',
        'cn'    =>  'amazon.cn',
        'de'    =>  'amazon.de',
        'es'    =>  'amazon.es',
        'fr'    =>  'amazon.fr',
        'in'    =>  'amazon.in',
        'it'    =>  'amazon.it',
        'mx'    =>  'amazon.com.mx',
        'uk'    =>  'amazon.co.uk',
        'us'    =>  'amazon.com'
    );

    // Return Market
    function get_lang_url(){
        $option = sanitize_key(get_option('rd_products_no_api_for_amz_lang','es'));
        if(empty($option)) $option = "es";
        return sanitize_text_field($this->lang[$option]);
    }

    // Test Connection
    function test_connection(){
        $lang = $this->get_lang_url();
        $url = esc_url_raw("https://www.$lang/");
        $count = 15;
        $href = "";
        do{
            $count = $count - 1;
            $html = file_get_html($url);
            $logo = $html->find('a.nav-logo-link');
            if(sizeof($logo) > 0)
                $href = esc_url($logo[0]->attr['href']);
            
                if($count >= 8)
                    sleep(0.25);
                else
                    sleep(2);
        } while($count > 0 && empty($href));

        $content = "";    
        if(!empty($href)){
            $content .= '<p class="rd-status rd-status-ok">';
            $content .= sprintf(__('Connection with %s is working correctly','rd-products-no-api-for-amz'), esc_attr($lang));
            $content .= '</p>';
        }
        else{
            $content .= '<p class="rd-status rd-status-not">';
            $content .= sprintf(__('Connection with %s is NOT working. Try another market or refresh the page to try again.','rd-products-no-api-for-amz'), esc_attr($lang));
            $content .= '</p>';
        }
        
        return wp_kses_post($content);
    }

    // Call to Reload
    function generate_products_by_id($id){
        if($id < 0) return;
        $name = $this->get_name($id);
            if($name == "") return;
        return $this->generate_products($id,$name);
    }

    // Call to Reload
    function generate_multiple_products_by_id($ids){
        $IDs = explode(",", $_GET['ids']);
        $count = count($IDs);
        if($count <= 0) return;

        foreach($IDs as $id){
            $name = $this->get_name($id);
            if($name != "")
                $this->generate_products($id,$name);
        }
    }

    // Try to get the products 10 times
    function generate_products($id, $name){
        $times = 10;
        $result = 0;
        do{
            $result = $this->generate_products_loop($id,$name);
            $times = $times - 1;
            if ($times <=5) sleep(5);
            else sleep(1);
        } while($times > 0 && $result <= 0);

        if($result = 0)
            return $this->add_no_result($id);
        else return 1;
    }

    // Get the products
    function generate_products_loop($id, $name){
        $lang = $this->get_lang_url();
        $kw = $this->sanitize_kw($name);
        $url = esc_url_raw("https://www.$lang/s?k=$kw");
        $html = file_get_html($url);
        $max_products = intval(get_option('rd_products_no_api_for_amz_max_products','9'));
        $content = '<div class="rd-products-no-api-for-amz-container">';
        
        // Get All Products;
        $products = $html->find('.s-result-item');
        $count = 0;
        foreach($products as $product){
            if($count < $max_products){

                // Get product description
                $desc_container = $product->find('h2.s-line-clamp-2', 0);
                if (!empty($desc_container))
                    $desc = sanitize_textarea_field($desc_container->plaintext);
                
                // Get product image url
                $imgContainer = $product->find('img',0);
                if(!empty($imgContainer))
                    $imgUrl = sanitize_text_field($imgContainer->attr['src']);
                
                //Get product asin
                $asin = sanitize_text_field($product->attr['data-asin']);
                
                // If some data is empty -> skip the product
                if (!empty($desc) && !empty($imgUrl) && !empty($asin)){
                    $count= $count + 1;
                    // Add the product to content code
                    $content .= $this->generate_product_content($desc, $imgUrl, $asin);
                }
            }
        }

        $content .= '</div>'; // end container

        // Upload content to database by id;
        if($count > 0)
            $this->set_content($id, $content);
        
        return $count;   
    }

    // Create de HTML content for a product
    function generate_product_content($desc, $imgUrl, $asin){
        $lang = $this->get_lang_url();
        $market= esc_url_raw("https://www.$lang/dp/");
        $url = esc_url_raw($market . $asin . "/?tag=%THE_TAG%&linkCode=osi&th=1&psc=1");
        
        return '<a target="_blank" rel="external nofollow" class="rd-products-no-api-for-amz-product rd-products-no-api-for-amz-class" href="' . $url . '">' .
        '<div class="rd-products-no-api-for-amz-img-container"><img src="' . esc_url($imgUrl) . '"/></div>' .
        '<p>' . esc_html($desc) . '</p>' .
        '<span>%THE_BTN_TEXT%</span>' .
        '</a>';
    }

    // Replace white spaces with '+';
    function sanitize_kw($name){
        return str_replace(" ", "+", $name);
    }
}