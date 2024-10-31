<div class="rd-products-no-api-for-amz-header">
<button class="btn button" id="check_conn_btn">
<?php 
    $wk = new RD_Products_No_Api_For_Amz_Worker(); 
    $currentMarket = $wk->get_lang_url();
    printf(__('Test connection with %s','rd-products-no-api-for-amz'), "<strong>$currentMarket</strong>");
?>
</button>
<div id="check_conn_container">
<p class="rd-status rd-status-none">
    <?php echo __('Checking connection...', 'rd-products-no-api-for-amz');?>
</p>
</div>
<p class="rd-status rd-status-not">
    <?php echo __('This plugin may not work with your server. Select your market and TEST the connection before.', 'rd-products-no-api-for-amz');?>
</p>   
</div>