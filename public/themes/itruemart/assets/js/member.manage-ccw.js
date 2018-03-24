$(document).ready(function(){
    $(".remove-ccw-btn").on("click", function(){
        if( ! confirm("คุณต้องการลบข้อมูลบัตรเครดิตใช่หรือไม่ ?") ){
            return false;
        }
        
        ccwkey = $(this).data('key');
        if(ccwkey == undefined || ccwkey == null){
            location.reload();
        }
        
        $.ajax({
            url: "/ajax/member/remove-ccw",
            type: "POST",
            data: { key: ccwkey },
            dataType: 'json',
            success: function(res){
                if(res.code == 200){
                    $("#"+ccwkey).animate({width:"0px", border:'none'}, 200, 'linear', function(e){
                        $(this).remove();
                    });
                }else{
                    location.reload();
                }
            },
            error: function(err){
                location.reload();
            }
        });
        
    });
});