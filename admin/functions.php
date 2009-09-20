<?php

function ribcage_admin_index ()
{	
	?>
	<div class="wrap">
		<h2>Ribcage</h2>
	</div>	
	<?php
}

/**
 * Administration panel for adding a release.
 *
 * @return void
 * @author Alex Andrews
 */
function ribcage_add_release()
{
	global $release, $artist;
	
	?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div>
		<h2>Add Release</h2>
	<?php
	
	if ($_REQUEST['ribcage_action'] == 'add_release') { ?>
		<p>Added the release</p>
		<?php
		print_r($_POST);
		return 0;
	}
	else {
	if ($_POST['lookup'] != '') {
		if ($_POST['lookup'] == 'Lookup')	{
			$mbid = $_POST['musicbrainz_id'];		
			$result = mb_get_release($mbid);

			if (is_wp_error($result)){
				?>
				<?php
				switch ($result->get_error_code()){
					case 'mb_not_found': ?>
						<p>Ribcage could not find a release with a MBID of <?php echo $mbid; ?> in the Musicbrainz database.</p>
						<p>Please enter the release manually, but don't forget to add it to Musicbrainz afterwards.</p>
						<?php
					break;
					case 'artist_not_found': ?>
						<p><?php echo $artist; ?> is not an artist in the Ribcage database. Yet.</p>
						<p>You need to <a href="admin.php?page=add_artist">add an artist</a> before you can add their releases.</p>
						<?php
						return (1);
					break;
				}
				
				?>
				</div>
				<?php
			}
			
			$artist_slug = $artist['artist_slug'];
			
			// Guess some things about our release.
			$release = array_merge($release,array(
				'release_cover_image_tiny' => get_option('siteurl').get_option('ribcage_image_location').'covers/tiny/'.$release['release_slug'].'.jpg',
				'release_cover_image_large' => get_option('siteurl').get_option('ribcage_image_location').'covers/large/'.$release['release_slug'].'.jpg',
				'release_cover_image_huge' =>get_option('siteurl').get_option('ribcage_image_location').'covers/huge/'.$release['release_slug'].'.jpg',
				'release_mp3' => get_option('ribcage_file_location').$artist_slug.'/'.$release['release_slug'].'/download/zip/'.$release['release_slug'].'-mp3.zip',
				'release_ogg' => get_option('ribcage_file_location').$artist_slug.'/'.$release['release_slug'].'/download/zip/'.$release['release_slug'].'-ogg.zip',
				'release_flac' => get_option('ribcage_file_location').$artist_slug.'/'.$release['release_slug'].'/download/zip/'.$release['release_slug'].'-flac.zip',
			));
		}
			
		// If we haven't got an artist from Musicbrainz then we need to display a drop down of all the artists so they can choose.
		?>
		<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>&ribcage_action=add_release" method="post" id="ribcage_add_release" name="add_release">
		<table class="form-table">             
			<tr valign="top">
				<th scope="row"><label for="artist_name">Artist</label></th> 
				<td>
					<?php artist_name(); ?>												
				</td> 
			</tr>
			<tr valign="top">
				<th scope="row"><label for="release_title">Release Name</label></th> 
				<td>
					<input type="text" style="width:320px;" class="regular-text code" value="<?php release_title(); ?>" name="release_title" id="release_title" maxlength="200" />										
				</td> 
			</tr>
			<tr valign="top">
				<th scope="row"><label for="release_title">Release Slug</label></th> 
				<td>
					<input type="text" style="width:320px;" class="regular-text code" value="<?php release_slug(); ?>" name="release_slug" id="release_slug" maxlength="200" /><span class="description">The URL you want for the release after the artist name, for example <?php echo get_option('siteurl'); ?>/artist_name/release_slug</span>										
				</td> 
			</tr>
			<tr valign="top">
				<th scope="row"><label for="release_title">Release Date</label></th> 
				<td>
					<input type="text" style="width:320px;" class="regular-text code" value="<?php echo $release['release_date']; ?>" name="release_date" id="release_date" maxlength="200" /><span class="description">When is the record going to come out?</span>										
				</td> 
			</tr>
			<tr valign="top">
				<th scope="row"><label for="release_id">Catalogue Number</label></th> 
				<td>
					<?php echo get_option('ribcage_mark'); ?><input type="text" style="width:30px;" class="regular-text code" value="<?php echo $release['release_id']; ?>" name="release_id" id="release_id" maxlength="10" /><span class="description">This will be padded to be three digits</span>									
				</td> 
			</tr>
		</table>
		<input type="hidden" name="release_mbid" value="<?php echo $release['release_mbid']; ?>" />
		<input type="hidden" name="release_artist" value="<?php echo $release['release_artist']; ?>" />
		<p class="submit">
			<input type="submit" name="Submit" class="button-primary" value="Save Changes" />
		</p>
		</form>
		<pre><?php print_r($release); ?></pre>
		<?php
	}
	else {
	?>
		<form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<p>Please enter the <a href="http://musicbrainz.org">Musicbrainz</a> ID and Ribcage will lookup the release and fill in the details automtically. This should be the Musicbrainz ID of the specific release, not the release group.</p> <p>If your release does not have a Musicbrainz ID, or if you wish to enter the release entirely manually, click on Skip.</p>
		<table class="form-table">
		<tr valign="top">
		<th scope="row"><label for="musicbrainz_id">Musicbrainz ID</label></th>
		<td><input type="text" name="musicbrainz_id" value="bce40d0a-6b5f-4d75-97c7-916d67d584f6" class="regular-text code"/></td>
		</tr>
		</table>
		<p class="submit">
		<input type="submit" name="lookup" class="button-primary" value="<?php _e('Lookup') ?>" /><input type="submit" name="lookup" class="button-secondary" value="<?php _e('Skip') ?>" />
		</p>
		</form>
	<?php
	}
}
	?>
	</div>
	<?php
	
}

function ribcage_add_review($value='')
{
	?>
	<div class="wrap">
		<h2>Add Review</h2>
		<p>Add a review of one of your releases.</p>
	</div>
	<?php
}

function ribcage_add_press($value='')
{
	?>
	<div class="wrap">
		<h2>Add Press</h2>
		
	</div>
	<?php
}

/**
 * Displays form for changing Ribcage options.
 *
 * @return void
 **/
function ribcage_options()
{
	?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div>
		<h2>Ribcage</h2>
		<form method="post" action="options.php">
		<table class="form-table">
		<tr valign="top">
		<th scope="row"><label for="ribcage_paypal_email">Paypal E-mail Address</label></th>
		<td><input type="text" name="ribcage_paypal_email" value="<?php echo get_option('ribcage_paypal_email'); ?>" class="regular-text code"/><span class="description">E-mail to send money to from donations and purchases via Paypal</span></td>
		</tr>
		<tr valign="top">
		<th scope="row"><label for="ribcage_image_location">Image Location</label></th>
		<td><input type="text" name="ribcage_image_location" value="<?php echo get_option('ribcage_image_location'); ?>" class="regular-text code"/><span class="description">The directory to begin the directory tree of images for artists and release covers</class></td>
		</tr>
		<tr valign="top">
		<th scope="row">File Location</th>
		<td><input type="text" name="ribcage_file_location" value="<?php echo get_option('ribcage_file_location'); ?>" class="regular-text code"/><span class="description">The directory to begin the directory tree of files for audio and one sheets</class></td>
		</tr>
		<tr valign="top">
		<th scope="row">Record Label Mark</th>
		<td><input type="text" name="ribcage_mark" value="<?php echo get_option('ribcage_mark'); ?>" class="regular-text code"/><span class="description">The record label mark, Records On Ribs uses ROR, for example</span></td>
		</tr>
		<tr valign="top">
		<th scope="row">Default Postage Within Your Country</th>
		<td><input type="text" name="ribcage_postage_country" value="<?php echo get_option('ribcage_postage_country'); ?>" class="regular-text"/><span class="description">The default postage for a purchased item within the country you are in</span></td>
		</tr>
		<tr valign="top">
		<th scope="row">Default Postage Worldwide</th>
		<td><input type="text" name="ribcage_postage_worldwide" value="<?php echo get_option('ribcage_postage_worldwide'); ?>" class="regular-text"/><span class="description">The default postage for a purchased item worldwide</span></td>
		</tr>
		<tr valign="top">
		<th scope="row">Press Contact</th>
		<td><input type="text" name="ribcage_press_contact" value="<?php echo get_option('ribcage_press_contact'); ?>" class="regular-text code"/><span class="description">E-mail address people should contact for press enquires</span></td>
		</tr>
		</table>
		<?php settings_fields('ribcage'); ?>
		<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
		</form>
		</div>
	</div>
	<?php
}
?>