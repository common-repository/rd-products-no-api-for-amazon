<?php $db = new RD_Products_No_Api_For_Amz_Database_Handler();?>

<div class="wrap rd-products-no-api-for-amz-wrap">
<h1><?php echo __('Your shortcodes','rd-products-no-api-for-amz');?></h1>
<div class="content">
    <?php 

        // Remove shortcode
        if(isset($_POST['remove_shortcode_btn'])){
            $id = intval(sanitize_key($_POST['remove_shortcode_btn']));
            if($id < 0)
                return;

            $db->remove_shortcode($id);?>
            <div class="message-container deleted"> 
                <button class="hide-btn" id="hide_btn">X</button>
                <h2><?php echo __('Shortcode Deleted','rd-products-no-api-for-amz');?></h2>
            </div>
        <?php }
        ?>

    <table id="shortcodes" cellspacing="0" cellpadding="0">
    <tr>
        <th><?php echo __('Remove', 'rd-products-no-api-for-amz');?></th>
        <th><?php echo __('Name', 'rd-products-no-api-for-amz');?></th>
        <th><?php echo __('Shortcode', 'rd-products-no-api-for-amz');?></th>
        <th><?php echo __('Reload', 'rd-products-no-api-for-amz');?></th>
    </tr>

    <?php $db->get_shortcodes();?>

    </table>
    <form id="shortcodes_page_form" method="post"></form>

    <span class="icons-references"><?php echo __('Reference and Tips', 'rd-products-no-api-for-amz');?></span>
    <ul class="icons-references">
        <li><button class="button-example"></button><span class="text-button-example"><?php echo __('The shortcode doesn\'t have products.</br>Reload the page if you just created the shortcode or click to try again.', 'rd-products-no-api-for-amz');?></span></li>
        <li><button class="button-example loading-items"></button><span class="text-button-example"><?php echo __('The shortcode is searching for new products.</br>Wait a moment until it ends.</br>You can close this tab if you want.', 'rd-products-no-api-for-amz');?></span></li>
        <li><button class="button-example has-items"></button><span class="text-button-example"><?php echo __('The shortcode has products.</br>Use the shortcode where you need.</br>You can refresh the products if you want.', 'rd-products-no-api-for-amz');?></span></li>
    </ul>

</div><!-- End content -->
</div><!-- End wrap -->
<?php include_once plugin_dir_path(__FILE__) . 'rd_footer.php';?>