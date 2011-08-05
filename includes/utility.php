<?php
/**
 * Assorted utility function that extend the basic functions of WordPress.
 *
 * @author Alex Andrews <alex@recordsonribs.com>
 * @package Ribcage
 * @since 2.0
 * @version 1.0
 */

if (!function_exists('get_post_by_slug')) {
    /**
     * Get a post from the slug
     *
     * From http://www.thiendo.com/blog/wordpress/253-wordpress-get-post-by-slug/ - thanks.
     *
     * @param string $post_name 
     * @param string $output 
     * @return array | object Standard WordPress post object.
     * @author Alex Andrews <alex@recordsonribs.com>
     */
    function get_post_by_slug($post_name, $output = OBJECT) {
        global $wpdb;
        $post = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s", $post_name ));
        if ( $post )
            return get_post($post, $output);

        return null;
    }
}
?>

