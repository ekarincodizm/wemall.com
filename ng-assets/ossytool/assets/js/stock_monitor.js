$(function () {

    $("#btn-send").click(function (e, data) {
        var data_tel = $("#tel-box").val();
        if (data_tel != undefined || data_tel != "")
        {
            $.ajax({
                type: 'POST',
                url: '/lol/send-sms',
                data: {tel:data_tel},
                success: function (response) {
                    console.log(response);
                    if (response != undefined)
                    {
                        var obj = JSON.parse(response);

                        if (obj.code == 200)
                        {
                            $("#msg-alert").text(obj.message);
                            $("#msg-alert").removeClass("alert alert-danger", true);
                            $("#msg-alert").addClass("alert alert-success", true);
                        }
                        else
                        {
                            $("#msg-alert").text(obj.message);
                            $("#msg-alert").removeClass("alert alert-success", true);
                            $("#msg-alert").addClass("alert alert-danger", true);
                        }
                    }
                    else
                    {
                        $("#msg-alert").text("Can not send SMS");
                        $("#msg-alert").removeClass("alert alert-success", true);
                        $("#msg-alert").addClass("alert alert-danger", true);
                    }
                }
            });
        }
        else
        {
            $("#msg-alert").text("Can not send SMS");
            $("#msg-alert").removeClass("alert-success", true);
            $("#msg-alert").addClass("alert alert-danger", true);
        }

        $("#msg-alert").fadeIn(function(){
            $(this).delay(10000).fadeOut();
        });

    });
});
