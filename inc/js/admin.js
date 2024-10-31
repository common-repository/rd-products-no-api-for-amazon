jQuery(document).ready(function($){

    // Style colors Pickers
    var btnColorOptions = {
        defaultColor: "#ffa500",
        palettes:true,
        change:function(event, ui){
            $('#admin-button-example').css({'background-color':ui.color})
        }
    };
    var textColorOptions = {
        defaultColor: "#ffffff",
        palettes:true,
        change:function(event, ui){
            $('#admin-button-example').css({'color':ui.color})
        }
    };
    var btnColorHoverOptions = {defaultColor: "#333333",palettes:true};
    var textColorHoverOptions = {defaultColor: "#ffffff",palettes:true};

    $('#admin-button-example').css({'background-color': $('.rd_products_no_api_for_amz_button_color').val()})
    $('#admin-button-example').css({'color': $('.rd_products_no_api_for_amz_text_color').val()})
    $('#admin-button-example').hover(function(){
        $(this).css({'background-color': $('.rd_products_no_api_for_amz_button_color_hover').val()})
    }, function(){
        $(this).css({'background-color': $('.rd_products_no_api_for_amz_button_color').val()})
    });
    $('#admin-button-example').hover(function(){
        $(this).css({'color': $('.rd_products_no_api_for_amz_text_color_hover').val()})
    }, function(){
        $(this).css({'color': $('.rd_products_no_api_for_amz_text_color').val()})
    });
    $('.rd_products_no_api_for_amz_button_color').wpColorPicker(btnColorOptions);
    $('.rd_products_no_api_for_amz_button_color_hover').wpColorPicker(btnColorHoverOptions);
    $('.rd_products_no_api_for_amz_text_color').wpColorPicker(textColorOptions);
    $('.rd_products_no_api_for_amz_text_color_hover').wpColorPicker(textColorHoverOptions);
    
    // Hide creation message
    $('#hide_btn').click(function(){
        $('.message-container').hide('slow', function(){
            $('.message-container').remove();
        });
    });

    // Check connection 
    var checkConnBtn = $('#check_conn_btn');
    var statusNone = $('.rd-status-none');
    checkConnBtn.click(function(){
        checkConnBtn.css({'display': 'none'});
        statusNone.css({'display':'inherit'});
        $.ajax({
            url: rd_products_no_api_for_amz_admin_ajax.ajax_url,
            method: 'GET',
            data:{
                action: 'test_connection'
            }
        }).done(function(data){
            $('#check_conn_container').empty().append(data);
            checkConnBtn.css({'display': 'inherit'});
        }).fail(function(xhr, status, error){
            $('#check_conn_container').empty().append("ERROR");
            checkConnBtn.css({'display': 'inherit'});
        });
    });

    // Reload content 
    $(".reload-content").click(function(){
        var self = $(this);
        var id = parseInt(self.val());
        $(".reload-content").attr('disabled', true).css({'opacity':'0.3'});
        self.css({'opacity':'1'});
        self.removeClass('has-items').addClass('loading-items');
        $.ajax({
            url: rd_products_no_api_for_amz_admin_ajax.ajax_url,
            method: 'GET',
            data:{
                action: 'reload_content',
                id: id
            }
        }).done(function(data){
            $(".reload-content").removeAttr('disabled').css({'opacity':'1'});
            self.removeClass('loading-items');
            if(data.trim() == "1"){
                self.addClass('has-items');
            }
        }).fail(function(xhr, status, error){
            $(".reload-content").removeAttr('disabled').css({'opacity':'1'});
            self.removeClass('loading-items');
        });
    });
    
    // Create shortcode
    $('.create-shortcode-btn').click(function(){
        
        // Sanitize input
        var name = sanitizeName($('#new_shortcode_name').val());
        var self = $(this);
        self.attr('disabled',true);
        self.addClass('hide-item');
        $('#loading-item').removeClass('hide-item');
        $.ajax({
            url: rd_products_no_api_for_amz_admin_ajax.ajax_url,
            method: 'GET',
            data:{
                action: 'create_shortcode',
                name: name
            }
        }).done(function(data){
            $('#new_shortcode_name').val("");
            self.removeClass('hide-item');
            $('#loading-item').addClass('hide-item');
            self.removeAttr('disabled');

            if(data.trim().length > 6){
                alert(data.trim());
                return;
            }
            var id = parseInt(data);
            var value = "[rd_products_no_api_for_amz id='" + id + "']";
            $('.message-container').css({
                'display':'inherit'
            });
            $('.message-container input.shortcode').val(value);
            $('.message-container h2 span#name_shortcode').text(name + " ");
            $.ajax({
                url: rd_products_no_api_for_amz_admin_ajax.ajax_url,
                method: 'GET',
                data:{
                    action: 'reload_content',
                    id: id
                }
            })
        });       
    });

    // Create shortcodes from TextArea
    $('.create-shortcodes-btn').click(function(){
        
        var names = $('#new_shortcodes_names').val();
        var namesList = names.split('\n');
        var self = $(this);
        self.attr('disabled',true);
        self.addClass('hide-item');
        $('#loading-item').removeClass('hide-item');
        $.ajax({
            url: rd_products_no_api_for_amz_admin_ajax.ajax_url,
            method: 'GET',
            data:{
                action: 'create_shortcodes_from_list',
                names: names
            }
        }).done(function(data){
            
            var IDs = data.split(',');

            self.removeClass('hide-item');
            $('#loading-item').addClass('hide-item');
            self.removeAttr('disabled');

            if(IDs.length <= 0){
                return;
            }
                        
            $.ajax({
                url: rd_products_no_api_for_amz_admin_ajax.ajax_url,
                method: 'GET',
                data:{
                    action: 'reload_multiple_content',
                    ids: data
                }
            }).done(function(data){
                alert(data);
            })
        });   
    });

    // Sanitize name
    function sanitizeName(name){
        return name.replace(/[^\w\s]/gi, '');
    }
});