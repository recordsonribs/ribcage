<?php get_header(); ?>
	<div id="left">
		<div class="mod page">
			<div class="entry">
				<p>Thanks very much for your order. We'll get back to you as soon as possible.</p>
				<h3>Details</h3>
				<p>
					<?php echo $_POST['quantity'] ?> x <?php echo $_POST['item_name'] ?> (<?php echo $_POST['item_number'] ?>)<br />
					Paid by <?php echo $_POST['first_name'];?> <?php echo $_POST['last_name'];?> <?php echo $_POST['payer_business_name'];?> (<?php echo $_POST['payer_email'] ?>)
				</p>
			</div> <!-- end div.entry -->
		</div> <!-- end div.page -->
		<div class="mod post paypal">
			<div class="mod-meta">
				<a href="#" onclick="javascript:window.open('https://www.paypal.com/us/cgi-bin/webscr?cmd=xpt/cps/popup/OLCWhatIsPayPal-outside','olcwhatispaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=400, height=350');"><img alt="Make a Donation!" src="<?php bloginfo('stylesheet_directory'); ?>/images/release_paypal-m.png" alt="Make a Donation!" /></a>
			</div>
			<div class="mod-body">
				<p><small>When you click Donate Now you will be redirected to Paypal for secure online payment. Then we'll send you straight to your download with a warm fuzzy wuzzy feeling in your stomach that we've thrown in for free.</small></p>
			</div>
		</div> <!-- end div.post div.paypal -->
	</div> <!-- end #left -->

<?php get_sidebar(); ?>

<?php get_footer();?>