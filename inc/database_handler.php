<?php

class RD_Products_No_Api_For_Amz_Database_Handler{  
    
    private $db_name = 'rd_products_no_api_for_amz_content';

    // Returns database name
    private function get_db_name(){
        global $table_prefix;
        return $table_prefix . $this->db_name;
    }
    
    // Create table on activate plugin
    function create_tables()
    {
        global $wpdb;
        $charset = $wpdb->get_charset_collate();
        $table_content = $this->get_db_name();

        $sql = "CREATE TABLE `$table_content` ( "
            . " `id` int(11) NOT NULL AUTO_INCREMENT, "
            . " `name` text NOT NULL,"
            . " `has_items` tinyint(2) NOT NULL,"
            . " `market` tinyint(2) NOT NULL,"
            . " `content` text,"
            . " PRIMARY KEY `order_id` (`id`)) $charset;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($sql);
    }

    // Remove table on delete plugin
    function drop_tables(){
        global $wpdb;
        $table_content = $this->get_db_name();
        $sql = "DROP TABLE `$table_content`";
        $wpdb->query($sql);
    }

    // Create Shortcode and return ID
    function add_shortcode($name) {
        global $wpdb;
        $table_content = $this->get_db_name();
        $wpdb->insert($table_content, array(
            'name' => sanitize_text_field($name),
            'has_items' => 0,
            'market' => 0
        ));
        return $wpdb->insert_id;
    }

    // Create Shortcodes from list and return IDs list
    function add_shortcodes_from_list($namesList){
        global $wpdb;
        $table_content = $this->get_db_name();
        $IDs = "";                
        
        foreach($namesList as $name){

            $wpdb->insert($table_content, array(
                'name' => sanitize_text_field($name),
                'has_items' => 0,
                'market' => 0
            ));
            
            $id = $wpdb->insert_id;
            $IDs = $IDs . "$id,";
        }

        return substr($IDs, 0, -1);      
    }

    // Remove Shortcode
    function remove_shortcode($id){
        global $wpdb;
        $table_content = $this->get_db_name();
        $wpdb->delete($table_content, array('id'=>$id));
    }

    // Get name by ID
    function get_name($id){
        global $wpdb;
        $table_content = $this->get_db_name();
        $sql = "SELECT `name` FROM $table_content WHERE `id` = $id";
        $result = $wpdb->get_results($sql);

        if(!empty($result))
            return sanitize_text_field($result[0]->name);
        else return "";
    }

    // Get content
    function get_content($id){
        global $wpdb;
        $table_content = $this->get_db_name();

        $sql = "SELECT `content` FROM $table_content WHERE `id` = $id";
        $result = $wpdb->get_results($sql);

        if(!empty($result))
            return wp_kses_post($result[0]->content);
    }

    // Add result if empty or not content
    function add_no_result($id){
        global $wpdb;
        $table_content = $this->get_db_name();
        $sql = "SELECT `content` FROM $table_content WHERE `id` = $id";
        $result = $wpdb->get_results($sql);
        
        if(!empty($result)){
            $has_items = 1;
            if(empty($result[0]->content))
                $has_items = 0;
            
            $data = array('has_items' => $has_items);
            $where = array('id' => $id);
            $wpdb->update($table_content,$data,$where);
            return $has_items;
        } else return 0;
                    
    }

    // Set content
    function set_content($id, $content){
        global $wpdb;
        $table_content = $this->get_db_name();
        
        $data = array('content' => wp_kses_post($content), 'has_items' => '1');
        $where = array('id' => $id);

        $wpdb->update($table_content, $data, $where);
    }

    // Get all the shortcodes
    function get_shortcodes(){
        global $wpdb;
        $table_content = $this->get_db_name();
        
        $sql = "SELECT * FROM $table_content";
        $result = $wpdb->get_results($sql);
        $count = 0;
        if(empty($result))
        echo '<tr><td colspan="4"><span class="no-shortcodes">' . __('You don\'t have any shortcode created','rd-products-no-api-for-amz') . '</span></td></tr>';
        else{
            foreach($result as $shortcode){
                $count = $count + 1;
                $id = intval($shortcode->id);
                $name = sanitize_text_field($shortcode->name);
                $has_items = intval($shortcode->has_items);
                $class = "";
                if($has_items == 1) $class = " has-items";
                elseif($has_items == 2) $class = " loading-items";
                ?>
                <tr>
                    <td><input onclick="return confirm('<?php printf(__('Do you want to delete %s','rd-products-no-api-for-amz'), esc_attr($name));?>?');" type="submit" class="remove-shortcode" name="remove_shortcode_btn" value="<?php echo esc_attr($id);?>" form="shortcodes_page_form"/></td>
                    <td><span><?php echo esc_html($name);?></span></td>
                    <td><label><input class="shortcode" type="text" onClick="this.select()" value="[rd_products_no_api_for_amz id='<?php echo esc_attr($id);?>']" readonly/></label></td>
                    <td><button class="reload-content<?php echo esc_attr($class);?>" name="reload_content_btn" value="<?php echo esc_attr($id);?>"></button></td>
                </tr>
            <?php }
            echo '<tr id="last_row"><td colspan="4"><span>('. intval($count) . ') Shortcode/s</span></td></tr>';
        }
    }
}