<?php get_header(); ?>

	<div id="left">
		<div class="mod post release">
			<div class="mod-meta artist_slug">
				<a href="<?php echo home_url(); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>"><img src="<?php release_cover_tiny (); ?>" alt="<?php release_title(); ?>" /></a>
			</div>
			<div class="mod-body">
				<div class="entry">
					<p>Thanks for your interest in <a href="<?php echo home_url(); ?>/artists/<?php artist_slug(); ?>"><?php artist_name(); ?></a>'s record <a href="<?php echo home_url(); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>"><?php release_title(); ?></a>.</p>
					<p>All proceeds from this release go to the <a href="http://www.unicef.org.uk/landing-pages/donate-syria/">UNICEF Christmas Appeal for Syrian Children</a></p>
					<p>Please give generously if you are able.</p>
					<div class="donate_links"><a class="donate" href="<?php get_option('site_url');?>/download/<?php release_slug();?>/donate">Donate To The Unicef Christmas Appeal for Syrian Children</a></div>
					<div class="donate_links"><a href="<?php release_download_link (); ?>/skip" style="color:#a9abae">Download without donating</a></div>
				</div> <!-- end div.entry -->
			</div> <!-- end div.mod-body -->
		</div> <!-- end div.post div.release -->
		<div class="mod post paypal">
			<div class="mod-meta">
				<a href="#" onclick="javascript:window.open('https://www.paypal.com/us/cgi-bin/webscr?cmd=xpt/cps/popup/OLCWhatIsPayPal-outside','olcwhatispaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=400, height=350');"><img alt="Make a Donation!" src="<?php bloginfo('stylesheet_directory'); ?>/images/release_paypal-m.png" alt="Make a Donation!" /></a>
			</div>
			<div class="mod-body">
				<p><small>When you click donate button you will be redirected to Paypal for secure online payment. Then we'll send you straight to your download.</small></p>
			</div>
		</div> <!-- end div.post div.paypal -->
			<div class="mod-meta">
				<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/"><img alt="Creative Commons License" src="<?php bloginfo('stylesheet_directory'); ?>/images/release_cc-m.png" alt="Creative Commons" /></a>
			</div>
			<div class="mod-body">
				<p><small>This release is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Creative Commons Attribution-Noncommercial-Share Alike 3.0 Unported License</a>. Essentially, this means you can give it to your friends if you like, as long as you aren't charging for it.</small></p>
			</div>
		</div> <!-- end div.post div.cc -->
	</div> <!-- end #left -->

<?php get_footer();?>
