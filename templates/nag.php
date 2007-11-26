<?php get_header(); ?>
<div id="container">
		<div id="content">
	 
	<h2>Download</h2>
	<a href="<?php echo ARTISTS_PLUGIN; ?><?php artist_slug(); ?>"><h1><?php artist_name(); ?> - <a href="<?php get_option('siteurl').'/artists/'.$artist['artist_slug'].release_slug(); ?>"><?php release_title(); ?></a></h1></a>
	<p>Thanks for your interest in <a href="<?php echo ARTISTS_PLUGIN; ?><?php artist_slug(); ?>"><?php artist_name(); ?></a>'s record <a href="<?php get_option('siteurl').'/artists/'.$artist['artist_slug'].release_slug(); ?>"><?php release_title(); ?></a>.</p>
	<p> While all our downloads are available for free and licensed under a <a href="#">Creative Commons License</a>, running this site does cost us money. Also, artists like <?php artist_name(); ?> work extremely hard on producing music for you to enjoy. So if you'd like to donate some money to them and to the up keep of this site, that would be great. </p>
<p>
	<a href="">Sure thing, send me to Paypal to donate some cash-money and then to the download.</a><br />
	<a href="<?php release_download_link (); ?>">Not right now thanks, just send me straight to the download.</a>
</p>
</div>
</div>
<?php get_footer();?>