<?php include_once plugin_dir_path(__FILE__) . 'rd_header.php';?>

<div class="wrap rd-products-no-api-for-amz-wrap">
<h1><?php echo __('Configuration','rd-products-no-api-for-amz');?></h1>
<div class="content">
    <form method="post" action="options.php">
        <?php 
            settings_fields('rd_products_no_api_for_amz_config_fields');
            do_settings_sections('rd_products_no_api_for_amz_config_fields');
            submit_button();
        ?>
    </form>
</div><!-- End content -->
</div><!-- End wrap -->
<?php include_once plugin_dir_path(__FILE__) . 'rd_footer.php';?>