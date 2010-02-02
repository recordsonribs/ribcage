<?php global $paypal; ?>
<?php echo $paypal->ipn_data['payer_email'] ?>
Details:
<?php 
foreach ($paypal->ipn_data as $key => $value) { 
	$body .= "\n$key is $value";
}
?>
