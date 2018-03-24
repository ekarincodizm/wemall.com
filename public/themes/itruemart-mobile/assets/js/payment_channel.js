$(function() {
    $('.radiopayment').on('click', function() {
        $('.explainpayment').slideUp('fast', function() {
            $(this).removeClass('active');
        });
        $(this).parents('.choice').next().slideDown('fast',function(){
            $(this).addClass('active');
        });
    });
    
    $('.menu-bank li').on('click', function(event){
        event.preventDefault();
        $('.menu-bank li').removeClass('active-right');
        var id = $(this).addClass('active-right').find('a').attr('href');
        console.log(id);
        $('.howto_atm').removeClass('active');
        $('#' + id.replace('#','')).addClass('active');
    });
});