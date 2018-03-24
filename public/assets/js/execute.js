/**
 * Not allow non-character.
 */
$('.alphanumeric').bind('keyup blur',function() {
    $(this).val( $(this).val().replace(/[`~!@#$%^&*|+=?;:'",.<>\{\}\[\]\\\/]/gi, ''));
});