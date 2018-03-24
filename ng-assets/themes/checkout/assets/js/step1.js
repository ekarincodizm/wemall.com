$(function() {
    var first_type = $('[name="logintype"]:checked').val();		
    var guest_url = $('#guest').attr('data-href');
    var user_url = $('#user1').attr('data-href');
    //alert(first_type);
    if(first_type == 'user')
    {
        $('#pwd-box').slideToggle(400);
        $("#step1-username").attr("placeholder", __("user-placeholder-username"));
        $('#form-checkout').attr('action', ''+user_url);
    }else{
        $("#step1-username").attr("placeholder", __("email-placeholder-username"));
    }
    
    $('[name="logintype"]').change(function()
    {
        var type = $(this).val();
        //alert(type);
        //alert(guest_url);
        if(type == 'guest')
        {
            $("#step1-username").attr("placeholder", __("email-placeholder-username"));
            $('#form-checkout').attr('action', ''+guest_url);
        }
        else if(type == 'user')
        {
            $("#step1-username").attr("placeholder", __("user-placeholder-username"));
            $('#form-checkout').attr('action', ''+user_url);
        }
    });
});