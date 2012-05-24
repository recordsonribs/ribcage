<?php
/**
 * Ribcage Widgets
 *
 * Registers all the widgets used by Ribcage.
 *
 * @package Ribcage
 * @subpackage Widgets
 **/

/**
 * Adds the Ribcage Widgets.
 *
 * @author Alex Andrews <alex@recordsonribs.com>
 */
class ribcage_widgets
{
    /**
     * Registers Ribcage sidebar widgets and their controls.
     *
     * @author Alex Andrews <alex@recordsonribs.com>
     * @return void
     */
    public function init ()
    {
        register_sidebar_widget('Forthcoming Releases', array('ribcage_widgets','forthcoming_releases'));
        register_sidebar_widget('Recent Releases', array('ribcage_widgets','recent_releases'));

        //register_sidebar_widget_control('Recent Releases', array('ribcage_widgets', 'widget_ribcage_recent_control'));
        //register_sidebar_widget_control('Forthcoming Releases', array('ribcage_widgets', 'widget_ribcage_recent_forthcoming'));
    }

    /**
     * Adds a widget for recent releases, the quantity of which is defined by an option.
     *
     * Revisions and streamlining of CSS by Bryan Klausmeyer of Ivy Street http://ivystreet.net/. Thanks very much indeed.
     *
     * @return void
     **/
    public function recent_releases ($args)
    {
        global $releases, $release, $artist;

        extract($args);
        $releases = list_recent_releases_blurb('16');
        $artists = list_artists_blurb();
    ?>
            <?php echo $before_widget; ?>
                <?php echo $before_title.'Recent Releases'.$after_title; ?>
                <div class="textwidget" align="left">
                <?php while ( have_releases () ) : the_release() ; ?>
                <?php $artist = get_artist($release['release_artist']); ?>
                <div class="artist_slug">
                    <a class="slug" href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>"><img src="<?php release_cover_tiny ();?>" alt="<?php release_title(); ?>" /></a>
                    <div class="artist_slug_info">
                        <ul class="artist_slug_main">
                            <li class="artist"><a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/"><?php artist_name(); ?></a><h2><a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>"><?php release_title(); ?></a></h2></li>
                        </ul>
                        <ul class="artist_slug_meta">
                            <li class="more"><a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>">More</a></li>
                            <li class="listen"><a href="javascript:popUp('<?php release_player_link (); ?>')">Listen</a></li>
                        <?php if (release_physical()) : ?>
                            <li class="download"><a href="<?php echo get_option('siteurl'); ?>/download/<?php release_slug(); ?>/">Download</a></li>
                            <li class="last buy"><a href="<?php get_option('siteurl'); ?>/buy/<?php release_product_id(); ?>">Buy</a></li>
                        <?php else: ?>
                            <li class="last download"><a href="<?php echo get_option('siteurl'); ?>/download/<?php release_slug(); ?>/">Download</a></li>
                        <?php endif; ?>
                        </ul>
                    </div> <!-- end div.artist_slug_info -->
                    <div class="clear"></div>
                </div> <!-- end div.artist_slug -->
                <?php endwhile; ?>
                <div class="clear"></div>
                <p class="more_link"><a href="<?php echo get_option('siteurl'); ?>/releases/">more releases &rsaquo;</a></p>
            </div>
            <?php echo $after_widget; ?>
    <?php
    }

    /**
     * Adds a widget for forthcoming releases. The quantity of which are defined by an option.
     *
     * @author Alex Andrews <alex@recordsonribs.com>
     * @return void
     */
    public function forthcoming_releases ($args)
    {
        global $releases, $release, $artist; // Probably

        extract($args);
        ?>
                <?php echo $before_widget; ?>
                    <?php echo $before_title.'Forthcoming Releases'.$after_title; ?>
                <?php echo $after_widget; ?>
        <?php
    }
}

add_action('plugins_loaded',array('ribcage_widgets','init'));
?>
