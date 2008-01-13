<?php

require_once dirname(__FILE__) . '/ribcage-includes/paypal/paypal.class.php';

function ribcage_buy_process ()
{
	global $paypal;
	
	// There should be no output at this point.  To process the POST data,
      // the submit_paypal_post() function will output all the HTML tags which
      // contains a FORM which is submited instantaneously using the BODY onload
      // attribute.  In other words, don't echo or printf anything when you're
      // going to be calling the submit_paypal_post() function.
 
      // This is where you would have your form validation  and all that jazz.
      // You would take your POST vars and load them into the class like below,
      // only using the POST values instead of constant string expressions.
 
      // For example, after ensureing all the POST variables from your custom
      // order form are valid, you might have:
      //
      // $p->add_field('first_name', $_POST['first_name']);
      // $p->add_field('last_name', $_POST['last_name']);
      
      $paypal->add_field('business', 'suppor_1200230957_biz@recordsonribs.com');
      $paypal->add_field('return', get_option('siteurl').'/buy/thanks');
      $paypal->add_field('cancel_return', get_option('siteurl').'/buy/cancel');
      $paypal->add_field('notify_url', get_option('siteurl').'/buy/ipn');
      $paypal->add_field('item_name', 'Records On Ribs test.');
      $paypal->add_field('amount', '1.99');

      $paypal->submit_paypal_post(); // submit the fields to paypal
      //$paypal->dump_fields();      // for debugging, output a table of all the fields
}

function ribcage_buy_ipn () {
	global $paypal;

	 // It's important to remember that paypal calling this script.  There
      // is no output here.  This is where you validate the IPN data and if it's
      // valid, update your database to signify that the user has payed.  If
      // you try and use an echo or printf function here it's not going to do you
      // a bit of good.  This is on the "backend".  That is why, by default, the
      // class logs all IPN data to a text file.
      
      if ($paypal->validate_ipn()) {        
         // Payment has been recieved and IPN is verified.  This is where you
         // update your database to activate or process the order, or setup
         // the database with the user's order details, email an administrator,
         // etc.  You can access a slew of information via the ipn_data() array.
  
         // Check the paypal documentation for specifics on what information
         // is available in the IPN POST variables.  Basically, all the POST vars
         // which paypal sends, which we send back for validation, are now stored
         // in the ipn_data() array.
  
         // For this example, we'll just email ourselves ALL the data.
         $subject = 'Instant Payment Notification - Recieved Payment';
         $to = 'alex@recordsonribs.com';    //  your email
         $body =  "An instant payment notification was successfully recieved\n";
         $body .= "from ".$paypal->ipn_data['payer_email']." on ".date('m/d/Y');
         $body .= " at ".date('g:i A')."\n\nDetails:\n";
         
         foreach ($paypal->ipn_data as $key => $value) { $body .= "\n$key: $value"; }

         mail ($to, $subject, $body);
      }
}
?>