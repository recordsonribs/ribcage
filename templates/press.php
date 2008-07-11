<?php get_header(); ?>
<div id="container">
	<div id="content">
		<div id="post-17" class="hentry p1 page publish author-alex category-uncategorized tag- y2007 m07 d19 h23">
			<h2 class="entry-title"><a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>"><?php artist_name(); ?> - Press Resources</a></h2>
	<div class="entry-content">
	<p>If you require any further information regarding <a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>"><?php artist_name(); ?></a> or any of our other artists or releases, or wish to contact the artist directly, please do not hesitate to e-mail <a href="mailto:press@recordsonribs.com">press@recordsonribs.com</a>.</p>
	<?php if (artist_picture_zip(0)) : ?><p><a href="<?php artist_picture_zip(); ?>">High Quality Press Photos (.zip)</a>
	</p><?php endif ?>
	<?php if (have_releases() ) : ?>
	<h3>Releases</h3>
	<?php while ( have_releases () ) : the_release() ; ?>
	<div class="ribcage-release">
		<a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>"><img src="<?php release_cover_tiny ();?>" align="left" height="65px" width="65px" style="margin-right: 20px; border: 1px solid #000;" alt="<?php release_title(); ?>" /></a>
	<?php $artist = get_artist($release['release_artist']); ?>
	<p><a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>"><?php release_title(); ?></a>
	<br /><?php if (release_onesheet(0)) : ?><a href="<?php release_onesheet(); ?>">Press Information Sheet (.pdf)</a><?php endif ?><?php if (release_cover_huge(0)) : ?> - <a href="<?php release_cover_huge(); ?>">High Quality Cover Artwork</a><?php endif; ?></p>
	</div>
	<?php endwhile; ?>
	<?php endif; ?>
	<h3>Online Resources</h3><p>
<?php if (artist_website_link(0)) : ?><a href="<?php artist_website_link(); ?>">Offical Webpage</a><br /><?php endif ?>
<?php if (artist_myspace_link(0)) : ?><a href="<?php artist_myspace_link(); ?>">My Space</a><br /><?php endif ?>
<?php if (artist_facebook_link(0)) : ?><a href="<?php artist_facebook_link(); ?>">Facebook</a><br /><?php endif ?>
<a href="<?php artist_lastfm_link(); ?>">Last.fm</a>
<a href="<?php artist_musicbrainz_link(); ?>">Musicbrainz</a>
</p>					<p><a href="#" onclick="history.back();" >&larr; Back</a></p>
				</div><!-- .entry-content-->
			</div><!-- .post -->
		</div><!-- #content -->
	</div><!-- #container -->
<?php get_sidebar(); ?>
<?php get_footer();?>

	<br /><?php if (release_onesheet(0)) : ?><a href="<?php release_onesheet(); ?>">Information Sheet (.pdf)</a><?php endif ?><?php if (release_cover_huge(0)) : ?> - <a href="<?php release_cover_huge(); ?>">High Quality Cover Artwork<?php endif; ?></p>