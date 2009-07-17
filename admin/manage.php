<?php
/**
 * Manages an individual artist
 *
 * @return void
 **/
function ribcage_manage_artists () {

	global $artists;
	global $artist;

	$artist_id = (int) $_REQUEST['artist'];
	$hidden_field_name = 'ribcage_artist_edit';
	$button_name = 'Edit Artist';
			
	register_column_headers('ribcage-manage-artist',
	array (
		'cb'=>'',
		'artist'=>'Artist'
		)
		);
	
	// we are going to do something now
	if(isset($_REQUEST['ribcage_action'])) {
		global $wpdb;
		
		//slice off two variables at the end to prepare for implodes
		array_pop($_POST); // submit button var

		//split apart associative array into different parts to prepare for implodes
		$post_keys = array_keys($_POST);
		$post_vals = array_values($_POST);
		
		//construct field name list and vals to post
		$string_keys = implode($post_keys,",");
		$string_vals = "'".implode($post_vals,"','")."'";

		$wpdb->show_errors();
		
		if ($_REQUEST['ribcage_action']=='edit') {
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
			
			//display snazzy update fade thing when they are added
			echo '<div id="message" class="updated fade"><p><strong>Artist updated.</strong></p></div>';		
		}
		
		if ($_REQUEST['ribcage_action']=='add') {
			$sql = "INSERT INTO ".$wpdb->prefix."ribcage_artists
					($string_keys)
					VALUES
					($string_vals)";
			$results = $wpdb->query( $sql );
			$wpdb->hide_errors();
			
			//display snazzy update fade thing when they are added
			echo '<div id="message" class="updated fade"><p><strong>Artist added.</strong></p></div>';
		}
	}
	
	if (isset($_REQUEST['artist']) or $_REQUEST['page'] == 'add_artist') :

	if (isset($_REQUEST['artist'])){
		$artist = get_artist($_REQUEST['artist']);
	}
	if ($_REQUEST['ribcage_action'] == 'add'){
		$artist = get_artist_by_slug($_POST['artist_slug']);
	}
?>
	<div class="wrap">
			<div id="icon-options-general" class="icon32"><br /></div>
		<?php if ($_REQUEST['page']=='add_artist') : ?>
			<h2>Add Artist</h2>
			<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>&ribcage_action=add" method="post" id="ribcage_edit_artist" name="edit_artist">
		<?php endif; ?>
		<?php if ($_REQUEST['page']=='manage_artists' && $_REQUEST['artist']) : ?>
			<h2>Managing <?php artist_name(); ?></h2>
			<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>&ribcage_action=edit" method="post" id="ribcage_edit_artist" name="edit_artist">
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
								<input type="text" style="width:320px;" class="regular-text code" value="<?php artist_slug(); ?>" name="artist_slug" id="artist_slug" /><span class="description">The URL you want for the artist - for example <?php echo get_option('siteurl'); ?>/artists/artist_slug</span>
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
								<input type="text" style="width:320px;" class="regular-text code" value="<?php echo $artist_picture_2_val; ?>" name="artist_picture_2" id="artist_picture_2" maxlength="200" />
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row">Artist Picture 3</th> 
							<td>
								<input type="text" style="width:320px;" class="regular-text code" value="<?php echo $artist_picture_3_val; ?>" name="artist_picture_3" id="artist_picture_3" maxlength="200" />
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
							<?php
							$artists = list_artists_blurb();
							$alternate = 1;
							?>
							<?php while ( have_artists () ) : the_artist(); ?>
							<?php
							if ($alternate == 1){
								?><tr valign="top" class="alternate"><?php
								$alternate = 0;
							}
							else {
								?><tr valign="top" class=""> <?php
								$alternate = 1;
							}
							?>		
							<th scope="row" class="check-column"><input type="checkbox" name="artistcheck[]" value="2" /></th>
							<td class="column-name"><strong><a class="row-title" href="?page=manage_artists&artist=<?php artist_id(); ?>" title="<?php artist_name(); ?>" ><?php artist_name(); ?></strong></a><br /><div class="row-actions"><span class='edit'><a href="?page=manage_artists&artist=<?php artist_id(); ?>">Edit</a> | </span><span class='delete'><a class='submitdelete' href='#' onclick="if ( confirm('You are about to delete \'<?php artist_name(); ?>\'\n  \'Cancel\' to stop, \'OK\' to delete.') ) { return true;}return false;">Delete</a></span></div></td>
							</tr>
							<?php endwhile; ?>
						</tbody>
					</table>
			</form>
	</div>
	<?php
	endif;
}
?>