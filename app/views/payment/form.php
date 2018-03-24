<form method="post" id="myForm">
    <input type="hidden" value="<?php echo $payment_id; ?>" name="payment_id" />
    <input type="hidden" value="1" name="nohtml" />
</form>
<script type="text/javascript">
    document.getElementById("myForm").submit();
</script>