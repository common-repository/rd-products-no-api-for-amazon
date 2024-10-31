<div class="wrap rd-products-no-api-for-amz-wrap">

<h1><?php echo __('Add new Shortcode','rd-products-no-api-for-amz');?></h1>

<div class="content">

    <!-- Message when created -->
    <div class="message-container"> 
        <button class="hide-btn" id="hide_btn">X</button>
        <h2><span id="name_shortcode"></span><?php echo __('created','rd-products-no-api-for-amz');?></h2>
        <p><?php echo __('Copy the shortcode inside your post or page','rd-products-no-api-for-amz');?></p>
        <input class="shortcode" type="text" onClick="this.select()" readonly/>
        <p class="info"><?php echo __('Your products will be ready in a few seconds. Check the shortcodes menu for more info or keep adding more categories','rd-products-no-api-for-amz');?></p>
    </div>

    <!-- Main Form -->
    <h4 class="prev-form"><?php echo __('Add here your category or keyword','rd-products-no-api-for-amz');?></h4>
    <div class="create-shortcode-container">
        <input type="text" id="new_shortcode_name" placeholder="<?php echo __('Category or keyword','rd-products-no-api-for-amz');?>">
        <button class="btn create-shortcode-btn"><?php echo __('Create shortcode','rd-products-no-api-for-amz');?></button>
        <i id="loading-item" class="hide-item"></i>
    </div>
    <p class="message-be-aware"><?php echo __('Be aware with specials chars','rd-products-no-api-for-amz');?>.</p>

</div><!-- End content -->
</div><!-- End wrap -->

<div class="wrap rd-products-no-api-for-amz-wrap">
<h1><?php echo __('Add Multiple Shortcodes','rd-products-no-api-for-amz');?></h1>

<div class="content">

    <!-- Main Form -->
    <h4 class="prev-form"><?php echo __('Add here your categories or keywords (One by line)','rd-products-no-api-for-amz');?></h4>
    <div class="create-shortcodes-container">
        <ul>
            <li><textarea id="new_shortcodes_names" cols="40" rows="10" placeholder="<?php echo __('Categories or keywords (One by line)','rd-products-no-api-for-amz');?>"></textarea></li>
            <li></li>
            <li><button class="btn create-shortcodes-btn"><?php echo __('Create shortcodes','rd-products-no-api-for-amz');?></button></li>
        </ul>
        <i id="loading-item" class="hide-item"></i>
    </div>
    <p class="message-be-aware"><?php echo __('Be aware with specials chars','rd-products-no-api-for-amz');?>.</p>

</div><!-- End content -->
</div><!-- End wrap -->

<?php include_once plugin_dir_path(__FILE__) . 'rd_footer.php';?>