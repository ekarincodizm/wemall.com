$(function()
{
    $(document).ajaxStart(function() {
        
        NProgress.start();
        NProgress.set(0.5);
        
    });
    
    $(document).ajaxStop(function() {
        
        NProgress.done();
        
    });
});