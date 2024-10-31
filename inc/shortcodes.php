<?php
class RD_Products_No_Api_For_Amz_Shortcodes{
		
	private $db;
	
	function __construct(){
		$this->db = new RD_Products_No_Api_For_Amz_Database_Handler();
		add_shortcode('rd_products_no_api_for_amz', array($this,'rd_products_no_api_for_amz_fun'));
	}
	
	function rd_products_no_api_for_amz_fun($atts){
		$a = shortcode_atts(array(
			'id' => 0,
		), $atts);
		
		// Get content from db
		$id = intval($a['id']);
		if($id < 0) return;
		
		$html = $this->db->get_content($id);
		$tag = esc_attr(get_option('rd_products_no_api_for_amz_tag_field','rd-tag-21'));
		$text_button = esc_attr(get_option('rd_products_no_api_for_amz_button_text',__('Open in Amazon','rd-products-no-api-for-amz')));
		$class = esc_attr(get_option('rd_products_no_api_for_amz_class','rd-products-no-api-for-amz-third'));
		$displayLink = intval(get_option('rd_products_no_api_for_amz_help_link', 1));

		// Set the tag, class and button text to products
		$html = str_replace('rd-products-no-api-for-amz-class', $class, $html);
		$html = str_replace('%THE_TAG%', $tag, $html);
		$html = str_replace('%THE_BTN_TEXT%', $text_button, $html);
		
		if($displayLink == 1)
		 $html .= '<span class="rd-help-link"><a target="_blank" href="https://roberpena.com/plugins/no-api-amz/">' . sprintf(__('Thanks to %s','rd-products-no-api-for-amz'), 'RD products plugin') . '</a></span>';

		return wp_kses_post($html);
	}	
}

new RD_Products_No_Api_For_Amz_Shortcodes();