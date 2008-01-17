<?php
function load_ribcage_widgets () {
	

function widget_ribcage_recent ($args) {
	global $releases, $release, $artist;
	
    extract($args);
	$releases = list_recent_releases_blurb('5');
	$artists = list_artists_blurb();	
	
?>
        <?php echo $before_widget; ?>
            <?php echo $before_title.'Recent Releases'.$after_title; ?>
			<div class="textwidget" align="left">
            <?php while ( have_releases () ) : the_release() ; ?>	
			<?php $artist = get_artist($release['release_artist']); ?>
			<div style="margin-bottom:25px;font-size:12px;"><a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>"><img src="<?php release_cover_tiny ();?>" align="right" style="margin-left: 10px; border: 1px solid #000;" height="65px" width="65px" alt="<?php release_title(); ?>" /></a>		
			<a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/" style="font-size:12px;"><?php artist_name(); ?></a> - <a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>" style="font-size:12px;"><?php release_title(); ?></a><br />
			<div style="font-size:9px;">
			<a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>" style="font-size:11px;color:black;">More</a> - <a href="javascript:popUp('<?php release_player_link (); ?>')" style="font-size:11px;color:black;">Listen</a> - <a href="<?php echo get_option('siteurl'); ?>/download/<?php release_slug(); ?>/" style="font-size:11px;color:black;">Download</a><?php if (release_physical()) : ?> - <a href="<?php get_option('siteurl'); ?>/buy/<?php release_product_id(); ?>" style="font-size:11px;color:black;">Buy</a><?php endif; ?>
			</div>
			</div>
			<?php endwhile; ?>
			<p><a href="<?php echo get_option('siteurl'); ?>/releases/">More Releases...</a></p>
		</div>
        <?php echo $after_widget; ?>
<?php
}

register_sidebar_widget('Recent Releases', 'widget_ribcage_recent');
//register_sidebar_widget_control('Recent Releases', 'widget_ribcage_recent_control');
}

add_action('plugins_loaded','load_ribcage_widgets');
?>