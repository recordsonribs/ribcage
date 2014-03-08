<?php get_header(); ?>

	<div id="left">
		<div class="mod page">
			<div class="entry">
				<?php artist_bio(); ?>
				<p><a class="press" href="<?php artist_press_link(); ?>">Press Photos and Information &rsaquo;</a></p>
				<p class="metadata"><script type="text/javascript">SHARETHIS.addEntry({ title: "<?php artist_name();?>", url: "<?php get_option('siteurl'); ?>/<?php artist_slug(); ?>/<?php release_slug();?>" });</script></p></p>
			</div> <!-- end div.entry-->
		</div> <!-- end div.page -->
		<?php if (have_releases() ) : ?>
			<?php while ( have_releases () ) : the_release() ; ?>
			<div class="mod post release toggler artist_page">
				<div class="mod-meta artist_slug">
					<a href="<?php release_cover_large(); ?>" rel="lightbox" title="'<?php release_title(); ?>' Cover Artwork"><img src="<?php release_cover_tiny();?>" alt="<?php release_title(); ?>"/><?php if (release_physical()) : ?><img class="case" src="<?php echo get_bloginfo('stylesheet_directory'); ?>/images/case.png" alt="Available for Purchase" /><?php endif; ?></a>
				</div>
				<div class="mod-body">
					<div class="entry">
						<?php $artist = get_artist($release['release_artist']); ?>
						<div class="ribcage-release">
							<h2 class="album"><a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>"><?php release_title(); ?></a></h2>
							<p><?php release_blurb_short(); ?></p>
						</div> <!-- end div.ribcage-release -->
					</div> <!-- end div.entry -->
					<div class="menu element">
						<ul class="artist_slug_meta">
							<li class="more"><a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>">More</a></li>
							<li class="listen"><a href="javascript:popUp('<?php release_player_link (); ?>')">Listen</a></li>
						<?php if (release_physical()) : ?>
							<li class="download"><a href="<?php echo get_option('siteurl'); ?>/download/<?php release_slug(); ?>/">Free Download</a></li>
							<li class="last buy"><a href="<?php get_option('siteurl'); ?>/buy/<?php release_product_id(); ?>">Buy</a></li>
						<?php else: ?>
							<li class="last download"><a href="<?php echo get_option('siteurl'); ?>/download/<?php release_slug(); ?>/">Free Download</a></li>
						<?php endif; ?>
						</ul>
					</div> <!-- end div.menu -->
					<div class="clear"></div>
				</div> <!-- end div.mod-body -->
				<div class="clear"></div>
			</div> <!-- end div.post -->
			<?php endwhile; ?>
		<?php endif; ?>
	</div> <!-- end #left -->

<div id="right">
	<div class="mod">
		<img class="artist_picture" src="<?php artist_picture_1(); ?>" alt="<?php artist_name(); ?>" />
	</div>

	<div class="mod">
		<h3>Artist Links</h3>
		<ul>
			<?php if (artist_website_link(0)) : ?><li class="site"><a href="<?php artist_website_link(); ?>">Offical Webpage</a></li><?php endif ?>
			<?php if (artist_myspace_link(0)) : ?><li class="myspace"><a href="<?php artist_myspace_link(); ?>">MySpace</a></li><?php endif ?>
			<?php if (artist_facebook_link(0)) : ?><li class="facebook"><a href="<?php artist_facebook_link(); ?>">Facebook</a></li><?php endif ?>
			<li class="lastfm"><a href="<?php artist_lastfm_link(); ?>">Last.fm</a></li>
			<li class="music"><a href="<?php artist_musicbrainz_link(); ?>">Musicbrainz</a></li>
		</ul>
	</div>

	<div class="mod">
		<h3>Gigs</h3>
		<ul class="events">
			<?php dbem_get_events_list("limit=3&order=DESC&category=".artist_id(false)); ?>
		</ul>
	</div>

	<?php 
		$slug = artist_slug(false);
		query_posts("tag=$slug");
	?>
	<?php if ( have_posts() ) : ?>
		<div class="mod">
			<h3>Tagged Posts</h3>
			<ul>
			<?php while ( have_posts() ) : the_post(); ?>
				<li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
			<?php endwhile; ?>
			</ul>
		</div>
	<?php endif; ?>

	<?php wp_reset_query(); ?>

	<?php if (isset($wp_query->query_vars['artist_slug'])) { ?>
		<div class="mod">
			<h3>Artist Feeds</h3>
			<ul>
				<li class="rss"><a href="/<?php artist_slug (); ?>/feed/" title="RSS 2.0 Feed">Releases</a></li>
				<li class="rss"><a href="/tag/<?php artist_slug (); ?>" title="RSS 2.0 Feed">News</a></li>
				<li class="rss"><a href="/?dbem_rss=main&category=<?php artist_id (); ?>" title="RSS 2.0 Feed">Events</a></li>
			</ul>
		</div>
	<?php } ?>

</div>

<?php get_footer() ?>