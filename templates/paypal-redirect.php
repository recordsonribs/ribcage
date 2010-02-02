<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
</script>
<head profile="http://gmpg.org/xfn/11" onLoad="document.paypal.submit();">
<title>Redirecting to PayPal . . .</title>
<link rel="stylesheet" href="<?php echo get_option('siteurl')."/wp-content/plugins/ribcage/templates/css/redirect.css";?>" type="text/css" media="screen" />
</head>

<body>

<div class="logo">
	<h1><span>Records on Ribs</span></h1>
</div>

<div class="loading">
	<span>Redirecting . . .</span>
</div>
<?php paypal_redirect(); ?>
</body>
</html>