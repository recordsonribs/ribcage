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

/**
 * Lazy way of making the labels, to keep things really DRY.
 *
 * @param string $single Single version of the term
 * @param string $plural Plural version of the term if in English there is something off going on.
 * @param string $type Either 'post-type' (by default) or 'taxonomy' - lets us work out what labels are required.
 * @return array $labels The array of labels the function needs.
 * @author Alex Andrews
 * @version 1.0
 * @since 1.0
 */
function make_labels ($single, $plural = false, $type = 'post-type') {
	if ($plural == false) {
		$plural = $single . "s";
	}
	
	if ($type == 'taxonomy') {
	    $labels = array(
        	'name' => "$plural",
    		'singular_name' => "$single",
    		'search_items' => "Search $plural",
    		'popular_items' => "Popular $plural",
    		'all_items' => "All $plural",
    		'edit_item' => "Edit $single",
    		'update_item' => "Update $single",
    		'add_new_item' => "Add $single",
    		'new_item_name' => "New $single"	
    	);
    }
    elseif ($type == 'post-type') {
        $labels = array(
            'name' => "$plural",
            'singular_name' => "$single",
            'menu_name' => "$plural",
            'add_new' => "Add $single",
            'add_new_item' => "Add New $single",
            'edit' => "Edit",
            'edit_item' => "Edit $single",
            'new_item' => "New $single",
            'view' => "View $single",
            'view_item' => "View $single",
            'search_items' => "Search $plural",
            'not_found' => "No $plural",
            'not_found_in_trash' => "No $plural in Trash",
            'parent' => "Parent $single"
        );
    }

	return $labels;
}
?>

