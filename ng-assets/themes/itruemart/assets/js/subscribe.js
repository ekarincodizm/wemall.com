
$(function() {

    $area = $("#msg_subscribe");

    $area.hide();

    function subscribe()
    {
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        var email_subscribe = $('input[name=subscribe_news]').val();

        if (!(filter.test(email_subscribe))) {
            $area.removeClass('success-box').addClass('error-box');
            $area.text(__("subscribe-email-invalid-format")).show();
            return false;
        }

        if(email_subscribe.length > 0)

            $.ajax({
                type: 'POST',
                url: '/ajax/subscribe/new',
                data: {
                    email: email_subscribe
                },
                success:function(res) {

                    console.log(res);

                    if (res.status == true) {
                        $area.removeClass('error-box').addClass('success-box');
                        $area.text(__(res.data)).show();
                    }
                    else {
                        $area.removeClass('success-box').addClass('error-box');
                        $area.text(__(res.data)).show();
                    }

                    // Hide box element.
                    // setTimeout(function() {

                    //     $area.hide();

                    // }, 5000);

                }
            });
    }

    $('#subscribe_news').keypress(function(event) {
        if ( event.keyCode == 13 ) {
             subscribe();
        }
    });

    $('.btn-subscribe-news').on('click', function(e) {
        e.preventDefault();
        subscribe();

    });

});