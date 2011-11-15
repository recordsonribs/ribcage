<?php
/**
 * Functions related to the artists custom post type.
 *
 * @author Alex Andrews <alex@recordsonribs.com>
 * @package Ribcage
 * @version 0.1
 * @since 2.0
 */

/**
 * Class for artists.
 *
 * @package Ribcage
 * @author Alex Andrews <alex@recordsonribs.com>
 * @version 0.1
 * @since 2.0
 */
class RibcageArtists {
    /**
     * Constructor
     *
     * @author Alex Andrews <alex@recordsonribs.com>
     * @version 0.1
     * @since 2.0
     */
    function __construct() {
        $this->artist_init();
    }
    
    /**
     * Initialise artist.
     *
     * @return void
     * @author Alex Andrews <alex@recordsonribs.com>
     * @version 0.1
     * @since 2.0
     */
    function artist_init() {
        // Register post type
        register_post_type (
            'ribcage_artists', 
            array(
                'label' => 'Artists',
                'description' => 'Artists on the label',
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'menu_position' => 20,
                'capability_type' => 'post',
                'hierarchical' => true,
                'rewrite' => array(
                    'slug' => 'artists',
                    'with_front' => false
                ),
                'query_var' => true,
                'has_archive' => true,
                'supports' => array('title','editor','excerpt', 'thumbnail','thumbnails'),
                'labels' => make_labels('Artist'),
                'register_meta_box_cb' => array(&$this, 'add_metaboxes'),
            )
        );
        
        // Adapt default labels to make it more Ribcage friendly.
        add_filter('enter_title_here', array(&$this, 'filter_title'));
        add_filter('gettext', array(&$this, 'filter_text'), 10, 4);
    }
    
    /**
     * Filter the title.
     *
     * @param string $content The string to filter.
     * @return string $content The filtered string.
     * @author Alex Andrews <alex@recordsonribs.com>
     * @version 0.1
     * @since 2.0
     * @todo Abstract this, because we will be using it a lot.
     */
    function filter_title ($content) {
       global $post;

        if ($post->post_type != 'ribcage_artists') {
            return $content;
        }
        $content = 'Artist Name';

        return $content;
    }
    
    /**
     * Filter the rest of important text.
     *
     * @author Alex Andrews <alex@recordsonribs.com>
     * @param array $translation
     * @return array $translation Translated elements.
     * @version 0.1
     * @since 2.0
     * @todo Abstract this, because we will be using it a lot.
     */
    function filter_text ($translation, $text, $domain) {
            global $post;

            if (!is_admin()) {
                return ($translation);
            }

            $translations = &get_translations_for_domain($domain);
            $translation_array = array();

            if (!$post) {
                return $translation;
            }

            if ($post->post_type != 'ribcage_artists') {
                return $translation;
            }
            
            $translation_array = array(
                'Excerpt' => "Short Description",
                'Excerpts are optional hand-crafted summaries of your content that can be used in your theme. <a href="http://codex.wordpress.org/Excerpt" target="_blank">Learn more about manual excerpts.</a>' 
                => "This short description of the artist, displayed on the artist index page (normally at <code>/artists</code>).",
                'Set featured image' => 'Set Artist Image',
                'Featured Image' => 'Artist Image',
                'Remove featured image' => 'Remove Artist Image'
            );

            if (array_key_exists($text, $translation_array)) {
                return $translations->translate($translation_array[$text]);
            }

            return $translation;
    }
    
    /**
     * Add metaboxes.
     *
     * @return void
     * @author Alex Andrews <alex@recordsonribs.com>
     */
    function add_metaboxes() {
        add_meta_box('ribcage_artist_musicbrainz_metabox', 'Musicbrainz', array(&$this, 'musicbrainz_metabox'), 'ribcage_artists', 'side', 'high');
        add_meta_box('ribcage_artist_web_links_metabox', 'Links', array(&$this, 'web_links'), 'ribcage_artists', 'side', 'high');
    }
    
    /**
     * Musicbrainz metabox.
     *
     * @return void
     * @author Alex Andrews <alex@recordsonribs.com>
     */
    function musicbrainz_metabox() {
    }
    
    /**
     * Metabox for web links for artist - links to social media and so on.
     *
     * @return void
     * @author Alex Andrews <alex@recordsonribs.com>
     * @todo Icons - nicked from Social Bartender at https://github.com/sawyerh/social-bartender/tree/
     */
    function web_links() {
        global $post;
        
        $metas = array(
            'website' => 'Website',
            'myspace' => 'MySpace',
            'twitter' => 'Twitter',
            'googleplus' => 'Google+',
            'diaspora' => 'Diaspora',
            'bandcamp' => 'Bandcamp',
            'soundcloud' => 'SoundCloud',
            'youtube' => 'YouTube'
        );
        
        foreach ($metas as $key => $value) {
    	    $metas["ribcage_artists_$key"] = $value;
    	    unset($metas[$key]);
    	}
    	
    	$c = new Immaterial_Controls_Metabox;
    	$c->start('ribcage_artist_web_links');

    	$c->table($metas);
    }
}
?>