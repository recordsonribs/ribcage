<?php get_header(); ?>
<div id="container">
	<div id="content">
		<div id="post-17" class="hentry p1 page publish author-alex category-uncategorized tag- y2007 m07 d19 h23">
			<h2 class="entry-title">Downloading <a href="<?php get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>"><?php artist_name(); ?></a> - <a href="<?php get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>"><?php release_title(); ?></a></h2>
				<div class="entry-content">
					<img src="<?php release_cover_large (); ?>" style="margin-bottom: 20px; border: 1px solid #000;" />
					<p>Thanks for your interest in <a href="<?php get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>"><?php artist_name(); ?></a>'s record <a href="<?php get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>"><?php release_title(); ?></a>.</p>
					<p> While all our downloads are available for free and licensed under a <a href="#">Creative Commons License</a>, running this site does cost us money. Also, artists like <?php artist_name(); ?> work extremely hard on producing music for you to enjoy. So if you'd like to donate some money to them and to the up keep of this site, that would be great. </p>
					<p>
						<a href="<?php get_option('site_url');?>/download/<?php release_slug();?>/donate">Yup, Donate Now</a><br />
						<a href="<?php release_download_link (); ?>">Just Send Me Straight To The Download.</a>
					</p>
					<p><a href="#" onclick="javascript:window.open('https://www.paypal.com/us/cgi-bin/webscr?cmd=xpt/cps/popup/OLCWhatIsPayPal-outside','olcwhatispaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=400, height=350');"><img  src="https://www.paypal.com/en_US/i/logo/PayPal_mark_50x34.gif" border="0" alt="Paypal" style="float: right; margin-left:20px;"></a>When you click Donate Now you will be redirected to Paypal for secure online payment. Then we'll send you straight to your download with a warm fuzzy wuzzy feeling in your stomach that we've thrown in for free.</p>
					<p>		<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/">
							<img alt="Creative Commons License" style="border-width:0; float:right;margin-left:20px;" src="http://i.creativecommons.org/l/by-nc-sa/3.0/88x31.png" />
							</a>This release is licensed under a 
							<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Creative Commons Attribution-Noncommercial-Share Alike 3.0 Unported License</a>. Essentially, this means you can give it to your friends if you like, as long as you aren't charging for it.</p>
			</div><!-- .entry-content-->
		</div><!-- .post -->
	</div><!-- #content -->
</div><!-- #container -->
<?php get_sidebar(); ?>
<?php get_footer();?>