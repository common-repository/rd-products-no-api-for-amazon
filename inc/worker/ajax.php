<?php
add_action( 'wp_ajax_reload_content', array('RD_Products_No_Api_For_Amz', 'reload_content') );
add_action( 'wp_ajax_reload_multiple_content', array('RD_Products_No_Api_For_Amz', 'reload_multiple_content') );
add_action( 'wp_ajax_create_shortcode', array('RD_Products_No_Api_For_Amz', 'create_shortcode') );
add_action( 'wp_ajax_test_connection', array('RD_Products_No_Api_For_Amz', 'test_connection') );
add_action( 'wp_ajax_create_shortcodes_from_list', array('RD_Products_No_Api_For_Amz', 'create_shortcodes_from_list') );