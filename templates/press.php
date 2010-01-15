<?php get_header(); ?>

	<div id="left">
		<div class="mod page">
			<div class="entry">
				<p>If you require any further information regarding <a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>"><?php artist_name(); ?></a> or any of our other artists or releases, or wish to contact the artist directly, please do not hesitate to e-mail <a href="mailto:<?php echo get_option('ribcage_press_contact'); ?>"><?php echo get_option('ribcage_press_contact'); ?></a>.</p>
			</div> <!-- end div.entry -->
		</div> <!-- end div.page -->

	<?php if (have_releases() ) : ?>
		<?php while ( have_releases () ) : the_release() ; ?>
		<div class="mod post release artist_page">
			<div class="mod-meta artist_slug">
				<a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>"><img src="<?php release_cover_tiny ();?>" alt="<?php release_title(); ?>" /></a>
			</div> <!-- end div.mod-meta -->
			<div class="mod-body">
				<?php $artist = get_artist($release['release_artist']); ?>
				<h2 class="album"><a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>"><?php release_title(); ?></a></h2>
				<ul class="press_links">
					<?php if (release_onesheet(0)) : ?><li class="press"><a href="<?php release_onesheet(); ?>" target="_blank">Press Information Sheet (<abbr title="Portable Document Format">pdf</abbr>)</a></li><?php endif; ?>
					<?php if (release_cover_huge(0)) : ?><li class="coverart"><a href="<?php release_cover_huge(); ?>" rel="lightbox" title="High Quality Cover Artwork">High Quality Cover Artwork</a><a class="new-window" href="<?php release_cover_huge(); ?>" title="Launch in New Window" target="_blank"><span>Launch in New Window</span></a></li><?php endif; ?>
				</ul>
			</div> <!-- end div.mod-body -->
		</div> <!-- end div.post -->
		<?php endwhile; ?>
	<?php endif; ?>
	</div> <!-- end #left -->

<div id="right">
	<div class="mod">
		<img class="artist_picture" src="<?php artist_picture_1(); ?>" alt="<?php artist_name(); ?>" />
		<?php // if (artist_picture_zip(0)) : ?><ul class="press_links"><li class="artist"><a href="<?php artist_picture_zip(); ?>">High Quality Press Photos (<abbr title="Compressed ZIP File">zip</abbr>)</a></li></ul><?php // endif; ?>
	</div>
	<div class="mod">
		<h3>Online Resources</h3>
		<ul>
			<?php if (artist_website_link(0)) : ?><li><a href="<?php artist_website_link(); ?>">Offical Webpage</a></li><?php endif ?>
			<?php if (artist_myspace_link(0)) : ?><li><a href="<?php artist_myspace_link(); ?>">My Space</a></li><?php endif ?>
			<?php if (artist_facebook_link(0)) : ?><li><a href="<?php artist_facebook_link(); ?>">Facebook</a></li><?php endif ?>
			<li><a href="<?php artist_lastfm_link(); ?>">Last.fm</a></li>
			<li><a href="<?php artist_musicbrainz_link(); ?>">Musicbrainz</a></li>
		</ul>
	</div>
</div>

<?php get_footer();?>