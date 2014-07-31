<?php
/**
 * Artist management
 *
 * @package Ribcage
 * @subpackage Administration
 **/

/**
 * Manages artists - adds, deletes, edits.
 *
 * @author Alex Andrews <alex@recordsonribs.com>
 * @return void
 **/
function ribcage_manage_artists () {
	global $artists;
	global $artist;

	$index = false;

	// If we aren't on an artist page then we are on the index page.
	if (isset($_REQUEST['artist'])) {
		$artist_id = (int) $_REQUEST['artist'];
	}
	elseif (isset($_REQUEST['page']) && $_REQUEST['page'] == 'add_artist' ){
		$index = false;
	}
	else {
		$index = true;
	}
			
	register_column_headers('ribcage-manage-artist',
	array (
		'cb'=>'<input type="checkbox" />',
		'artist'=>'Artist'
		)
		);
	
	if (isset($_REQUEST['ribcage_action'])) {
		global $wpdb;

		// Refactor, this is a terrible place for this to do this.
		if ($_REQUEST['ribcage_action'] !== 'add') {
			check_admin_referer('manage_artists');
		}
		else {
			check_admin_referer('add_artist');	
		}

		unset($_POST['_wpnonce']);
		unset($_POST['_wp_http_referer']);
		unset($_POST['Submit']);

		//split apart associative array into different parts to prepare for implodes
		$post_keys = array_keys($_POST);
		$post_vals = array_values($_POST);

		//construct field name list and vals to post
		$string_keys = implode($post_keys,",");
		$string_vals = "'".implode($post_vals,"','")."'";

		$wpdb->show_errors();

		switch ($_REQUEST['ribcage_action']) {
			case 'edit':
				$sql = "UPDATE ".$wpdb->prefix."ribcage_artists
						SET ";
						$i = 0;
						foreach($post_keys as $field):
							$sql .= $field ."='".$post_vals[$i]."', ";
							$i++;
						endforeach;
				$sql .= " artist_id = ".$artist_id." 
						WHERE artist_id = ".$artist_id;
				$results = $wpdb->query( $sql );
				$wpdb->hide_errors();

				$artist = get_artist($artist_id);
				$message = 'updated';
			break;
				
			case 'add':
				$sql = "INSERT INTO ".$wpdb->prefix."ribcage_artists
						($string_keys)
						VALUES
						($string_vals)";
				$results = $wpdb->query( $sql );
				$wpdb->hide_errors();
				
				$artist = get_artist_by_slug($_POST['artist_slug']);
				$message = 'added';
			break;
			
			case 'delete':
				$del_artist = get_artistname_by_id($_REQUEST['artist']);
				
				delete_artist($_REQUEST['artist']);
				$message = "$del_artist deleted";
				
				$index = 1;
			break;
		}

		echo '<div id="message" class="updated fade"><p><strong>Artist '.$message.'.</strong></p></div>';			
	}

	if (! $index) :

	if (isset($_REQUEST['artist'])){
		$artist = get_artist($_REQUEST['artist']);
	}
?>
	<div class="wrap">
			<div id="icon-options-general" class="icon32"><br /></div>
		<?php if ($_REQUEST['page']=='add_artist') : ?>
			<h2>Add Artist</h2>
			<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>&ribcage_action=add" method="post" id="ribcage_edit_artist" name="edit_artist">
			<?php wp_nonce_field('add_artist'); ?>
		<?php endif; ?>
		<?php if (isset($_REQUEST['artist'])) : ?>
			<h2>Managing <?php artist_name(); ?></h2>
			<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>&ribcage_action=edit" method="post" id="ribcage_edit_artist" name="edit_artist">
			<?php wp_nonce_field('manage_artists'); ?>
		<?php endif; ?>
					<table class="form-table">             
						<tr valign="top">
							<th scope="row"><label for="artist_name">Name</label></th> 
							<td>
								<input type="text" value="<?php artist_name(); ?>" name="artist_name" id="artist_name" class="regular-text"/>												
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row">Sort Name</th> 
							<td>
								<input type="text" value="<?php artist_name_sort(); ?>" name="artist_name_sort" id="artist_name_sort" class="regular-text" />
								<span class="description">The name of the artist to be alphabetized. For example, 'Butterfly, The'.</span>
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row">Artist Slug</th> 
							<td>
								<input type="text" style="width:320px;" class="regular-text code" value="<?php artist_slug(); ?>" name="artist_slug" id="artist_slug" /><span class="description">The URL you want for the artist - for example <a href="<?php echo home_url(); ?>/artists/artist_slug</span>
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row">Signup Date</th> 
							<td>
								<input type="text" style="width:100px;" class="regular-text code" value="<?php echo $artist['artist_signed']; ?>" name="artist_signed" id="artist_signed" maxlength="50" /><span class="description">The date the artist signed for your label</span>
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row">Creative Commons license</th> 
							<td>
								<?php echo ribcage_cc_dropdown($artist_license_val); ?>
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row">Artist's Music Brainz ID</th> 
							<td>
								<input type="text" style="width:320px;" class="regular-text code" value="<?php artist_musicbrainz (); ?>" name="artist_mbid" id="artist_mbid" maxlength="50" />
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row">Website URL</th> 
							<td>
								<input type="text" style="width:320px;" class="regular-text code" value="<?php artist_website_link(); ?>" name="artist_link_website" id="artist_link_website" maxlength="200" />
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row">MySpace URL</th> 
							<td>
								<input type="text" style="width:320px;" class="regular-text code" value="<?php artist_myspace_link(); ?>" name="artist_link_myspace" id="artist_link_myspace" maxlength="200" />
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row">Facebook URL</th> 
							<td>
								<input type="text" style="width:320px;" class="regular-text code" value="<?php artist_facebook_link(); ?>" name="artist_link_facebook" id="artist_link_facebook" maxlength="200" />
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row">Artist Biography</th> 
							<td>
								<textarea rows="5" cols="50" name="artist_bio" id="artist_bio" class="regular-text"><?php echo $artist['artist_bio']; ?></textarea>
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row">Short One Paragraph Description of Artist</th> 
							<td>
								<textarea rows="5" cols="50" name="artist_blurb_tiny" id="artist_blurb_tiny" class="regular-text"><?php echo $artist['artist_blurb_tiny']; ?></textarea>
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row">Artist Picture 1</th> 
							<td>
								<input type="text" style="width:320px;" class="regular-text code" value="<?php artist_picture_1(); ?>" name="artist_picture_1" id="artist_picture_1" maxlength="200" />
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row">Artist Picture 2</th> 
							<td>
								<input type="text" style="width:320px;" class="regular-text code" value="<?php artist_picture_2(); ?>" name="artist_picture_2" id="artist_picture_2" maxlength="200" />
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row">Artist Picture 3</th> 
							<td>
								<input type="text" style="width:320px;" class="regular-text code" value="<?php artist_picture_3(); ?>" name="artist_picture_3" id="artist_picture_3" maxlength="200" />
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row">Artist Picture HQ Zipfile URL</th> 
							<td>
								<input type="text" style="width:320px;" class="regular-text code" value="<?php echo $artist_picture_zip_val; ?>" name="artist_picture_zip" id="artist_picture_zip" maxlength="200" />
							</td> 
						</tr>
					</table>
					<p class="submit">
						<input type="submit" name="Submit" class="button-primary" value="Save Changes" />
					</p>
			</form>
	</div>
<?php else : ?>
	<?php
	$artists = list_artists_blurb();
	$alt = 0;
	?>
	<div class="wrap">
		<div id="icon-plugins" class="icon32"><br /></div>
		<h2>Manage Artists</h2>
			<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post" id="ribcage_manage_artists" name="manage_artists"> 
				<table class="widefat post fixed" cellspacing="0">
						<thead>
						<tr>
						<?php print_column_headers('ribcage-manage-artist'); ?>			
						</tr>
						</thead>
						<tfoot>
						<tr>			
						<?php print_column_headers('ribcage-manage-artist',FALSE); ?>	
						</tr>
						</tfoot>            
						<tbody>
							<?php while ( have_artists () ) : the_artist(); ?>
							<?php
							$manage_link = wp_nonce_url('?page=ribcage&artist=' . artist_id(false), 'manage_artists');
							$delete_link = wp_nonce_url('?page=ribcage&artist=' . artist_id(false) . '&ribcage_action=delete', 'manage_artists');
							?>
							<?php echo ($alt % 2) ? '<tr valign="top" class="">' : '<tr valign="top" class="alternate">'; ++$alt; ?>		
							<th scope="row" class="check-column"><input type="checkbox" name="artistcheck[]" value="2" /></th>
							<td class="column-name">
								<strong><a class="row-title" href="?page=manage_artists&artist=<?php artist_id(); ?>" title="<?php artist_name(); ?>" ><?php artist_name(); ?></strong></a><br /><div class="row-actions"><span class='edit'><a href="<?php echo $manage_link ?>">Edit</a> | </span><span class='delete'><a class='submitdelete' href='<?php echo $delete_link ?>' onclick="if ( confirm('You are about to delete \'<?php artist_name(); ?>\'\n  \'Cancel\' to stop, \'OK\' to delete.') ) { return true;}return false;">Delete</a></span></div></td>
							</tr>
							<?php endwhile; ?>
						</tbody>
					</table>
			</form>
	</div>
	<?php
	endif;
}

/**
 * Manages press articles about an artist.
 *
 * @author Alex Andrews <alex@recordsonribs.com>
 * @return void
 */
function ribcage_manage_press()
{
	?>
	<div class="wrap">
		<h2>Add Press</h2>
		
	</div>
	<?php
}
?>