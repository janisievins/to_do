$(document).ready(function() {
    
    /* Hiding the input form and it's title */
    $('#form').hide();
    $('#new-task-title').hide();
    $('.dialog-delete').css('margin-right', '0px');
    $('.dialog-done').css('margin-right', '0px');
    $('dialog-info').css('margin-right', '0px')
    $('.info-box').css('display', 'block');
    
    /* Checking if there already are any tasks in the list.
    If not, showing a message */
    elems = $('.item-list').find("li:visible").length;
    if (elems != 0) {
        $('.empty').hide();
    }
    
    /* Showing he input form when (+) is clicked */
    $(".main-box-add").click(function() {
        if ($(this).hasClass("clicked-once")){
            list_elements--;
            if (list_elements == 0) {
                $('.empty').show("fade", 300 );
            }
            $('#form').hide();
            $('#new-task-title').hide();
            $('.main-box-add i').switchClass("fa-minus", "fa-plus");
            $(this).removeClass("clicked-once");
        }
        else {
            list_elements = $('.item-list').find("li:visible").length;
            list_elements++;
            $(this).addClass("clicked-once");
            $('.empty').hide();
            $('#form').show("fade", 300 );
            $('#new-task-title').show("fade", 300);
            $('.main-box-add i').switchClass("fa-plus", "fa-minus");
        }
    });
    
    /* Styling the star button and changing it's value when clicked */
    $("#star").click(function() {
        if ($(this).hasClass("star-clicked")){
            $('#form').switchClass("important-form", "normal-form");
            $( "#important" ).val(0);
            $('#star i').switchClass("fa-star", "fa-star-o");
            $('#star i').removeClass('yellow ');
            $(this).removeClass("star-clicked");
        }
        else {
            $(this).addClass("star-clicked");
            $('#form').switchClass("normal-form", "important-form");
            $( "#important" ).val(1);
            $('#star i').switchClass("fa-star-o", "fa-star");
            $('#star i').toggleClass('yellow ');
        }
    });
    
    /* Posting the input */
    $("#submit-btn").click(function() {
        //Validating the form input using jquery.validate plugin
        $("form").validate({
            rules: {
                title: {
                    required: true,
                    minlength: 5,
                },
                details: {
                    required: true,
                    minlength: 5,
                }
            },
            messages: {
                title: {
                    required: "Sorry, but we need a title for this task!",
                    minlength: "The title seems a little bit too short, doesn't it?",
                },
                details: {
                    required: "Please give me some details too!",
                    minlength: "You should give me a little bit more detailed information!",
                },
            }
        });
        
        //Posting the form using AJAX if the input is valid
        if ($('form').valid() == true) {
            var $ajax_form = $('form.ajax');              
            var that   = $($ajax_form);
                url    = that.attr('action');
                type = that.attr('method');
                data   = {};
               
            that.find('[name]').each(function(index, value) {
                var that  = $(this),
                    name  = that.attr('name');
                    value = that.val();
                    data[name] = value;
            });
            
            $.ajax({
                url: url,
                type: type,
                data: data,
                success: function(response){
                    
                    //Inserting the new data in index.php using AJAX response
                    if (response.indexOf("<li class='important'>") >= 0) {
                        $(response).hide().fadeIn(100, function(){
                            $(this).effect( "pulsate");
                        }).insertAfter($('#form'));
                    }
                    else if (response.indexOf("<li class='rest'>") >= 0) {
                        if ($('.important').length == 0) {
                            $(response).hide().fadeIn(100, function(){
                                $(this).effect( "pulsate");
                            }).insertAfter($('#form'));
                        }
                        else if ($('.important').length != 0) {
                            $(response).hide().fadeIn(100, function(){
                                $(this).effect( "pulsate");
                            }).insertAfter($('.important:last'));
                        }
                    }
                    else {
                        $(response).insertAfter($('#form'));
                    }
                    $('#new-task-title').slideUp(200);
                    $('#form').slideUp(200);
                    
                    // Resetting all the styles and values to the defaults
                    $('.main-box-add i').switchClass("fa-minus", "fa-plus");
                    $('.main-box-add').removeClass("clicked-once");
                    $('#star').removeClass("star-clicked");
                    $('#star i').switchClass("fa-star", "fa-star-o");
                    $('#star i').removeClass("yellow");
                    $('#form').switchClass('important-form', 'normal-form');
                    $('input').val('');
                    $('textarea').val('');
                    $('#important').val(0);
                    return false;
                }
            })
        }
    return false;
    });
    
    /* Opening the information message using jquery dialog */
    $(document).on("click", ".info-box", function() {
        $(".dialog-info").dialog( "open" );
    });
    
    /* Opening the dialog */
    $(function() {
        $(".dialog-info").dialog({
            autoOpen: false, 
            modal: true,
            buttons: {
                // Closing the dialog if button 'NO' is clicked
                Close: function() {
                    target = 0;
                    window.done_id = 0;
                    $(this).dialog("close");
                }
            },
        });
    });
    
    /* Opening the confirmation message using jquery dialog */
    $(document).on("click", ".done-form", function() {
        window.done_id = $(this).attr('id');
        $(".dialog-done").dialog( "open" );
    });
    
    /* Opening the dialog */
    $(function() {
        $(".dialog-done").dialog({
            autoOpen: false, 
            modal: true,
            buttons: {
                
                // Posting the new status 'done' if button 'YES' is clicked
                Yes: function() {
                    var $done_form = $('form.done-form#' + done_id);
                    var that   = $($done_form);
                        url    = that.attr('action');
                        type = that.attr('method');
                        data   = {};
                        
                    that.find('[name]').each(function(index, value) {
                    var that  = $(this),
                        name  = that.attr('name');
                        value = that.val();
                        data[name] = value;
                        if (data['done'] == "") {
                            data['done'] = done_id.substring(5);
                        }
                    });
                    
                    //Changing the appearence and location of changed data in index.php using AJAX response
                    $.ajax({
                        url: url,
                        type: type,
                        data: data,
                        success: function(response) {
                            var li = $($($('#'+response).parent()).parent());
                            $(li).removeClass('rest');
                            $(li).removeClass('important');
                            $(li).addClass('done');
                            
                            if ($('.done').length != 0) {
                                $(li).insertBefore($('.done:first'));
                            }
                            if (($('.rest').length == 0 && $('.important').length != 0 )) {
                                $(li).insertAfter($('.important:last'));
                            }
                            if (($('.rest').length != 0 && $('.important').length != 0 ) || ($('.rest').length != 0 && $('.important').length == 0 )) {
                                $(li).insertAfter($('.rest:last'));
                            }
                            return false; 
                        }
                    })
                    
                    target = 0;
                    done_id = 0;
                    $(this).dialog("close");
                    return false;
                },
                
                // Closing the dialog if button 'NO' is clicked
                No: function() {
                    target = 0;
                    window.done_id = 0;
                    $(this).dialog("close");
                }
            },
        });
    });
    
    /* Opening the attention message using jquery dialog */
    $(document).on("click",".delete-form", function() {
         window.del_id = $(this).attr('id');
         $(".dialog-delete").dialog( "open" );
    });
    
    /* Opening the dialog */
    $(function() {
        $(".dialog-delete").dialog({
           autoOpen: false, 
           modal: true,
           buttons: {
            
                // Deleting the task if button 'YES' is clicked
                Yes: function() {
                    var $delete_form = $('form.delete-form#'+del_id);
                    var that   = $($delete_form);
                        url    = that.attr('action');
                        type = that.attr('method');
                        data   = {};
                    that.find('[name]').each(function(index, value) {
                        var that  = $(this),
                            name  = that.attr('name');
                            value = that.val();
                            data[name] = value;
                            if (data['delete'] == "") {
                                console.log('not set');
                                data['delete'] = del_id.substring(4);
                            }
                    });
                    
                    //Hiding the deleted data in index.php using AJAX response
                    $.ajax({
                        url: url,
                        type: type,
                        data: data,
                        success: function(response) {
                            var li = $($($('#'+response).parent()).parent());
                            $(li).hide();
                            var el = $('.item-list').find("li:visible").length;
                            if (el == 0) {
                                $('.empty').show("fade", 300 );
                            }
                        }
                    })
                    
                    target = 0;
                    del_id = 0;
                    $(this).dialog("close");
                    return false;
                },
                
                // Closing the dialog if button 'NO' is clicked
                No: function() {
                    target = 0;
                    del_id = 0;
                    $(this).dialog("close");
                    
                }
            },
        });
    });
    
});
    