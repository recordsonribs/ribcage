<?php

function ribcage_admin_index ()
{	
	?>
	<div class="wrap">
		<h2>Ribcage</h2>
	</div>	
	<?php
}

function ribcage_add_release()
{	
	?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div>
		<h2>Add Release</h2>
	<?php
	if ($_POST['musicbrainz_id'] != '' && $_POST['lookup'] == 'Lookup') {
		$mbid = $_POST['musicbrainz_id'];
		
		$releaseIncludes = array(
			"artist",
			"discs",
			"tracks"
			);

		$phpBrainz = new phpBrainz();
		$release = $phpBrainz->getRelease($mbid,$releaseIncludes);
		
		// TODO Map the variables onto the global variable $artist. If we haven't been asked to lookup stuff on Musicbrainz then display a blank.
		?>
		<form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<p>The following was retrieved from the Musicbrainz database. It should be accurate, but please check it before adding to the Ribcage database.</p>
		<table class="form-table">
		<tr valign="top">
		<th scope="row"><label for="artist_name">Artist Name</label></th>
		<td><input type="text" name="artist_name" value="<?php echo $release->getArtist()->getName(); ?>" class="regular-text"/></td>
		</tr>
		<tr valign="top">
		<th scope="row"><label for="artist_name_sort">Artist Name Sort</label></th>
		<td><input type="text" name="artist_name_sort" value="<?php echo $release->getArtist()->getSortName(); ?>" class="regular-text"/></td>
		</tr>
		<tr valign="top">
		<th scope="row"><label for="release_title">Title</label></th>
		<td><input type="text" name="release_title" value="<?php echo $release->getTitle(); ?>" class="regular-text"/></td>
		</tr>
		<tr valign="top">
		<th scope="row"><label for="release_mbid">Musicbrainz ID</label></th>
		<td><input type="text" name="release_mbid" value="<?php echo $release->getID(); ?>" class="regular-text"/></td>
		</tr>
		</table>
		<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
		</form>
		<?php
			echo '<p>';
			echo '<pre>';
		$gottracks = $release->getTracks();

		$track_no = 1;
		$total_seconds =  0;

		foreach ($gottracks as $tr) {
			$milsec = $tr->getDuration();
			$sec = (int) $milsec / 1000;
			$mins = floor ($sec / 60);
			$secs = $sec % 60;

			print $track_no.'. '.$tr->getTitle().' ('.str_pad($mins,2, "0", STR_PAD_LEFT).':'.str_pad($secs,2, "0", STR_PAD_LEFT).')'."\n";	
			print $tr->getId()."\n\n";

			$total_seconds = $total_seconds + $sec;

			++$track_no;
		}

		$hours = intval(intval($total_seconds) / 3600);
		$minutes = intval(($total_seconds / 60) % 60); 
		$seconds = intval($total_seconds % 60);

		echo "Total Time: ".str_pad($hours,2, "0", STR_PAD_LEFT).':'.str_pad($minutes,2, "0", STR_PAD_LEFT).':'.str_pad($seconds,2, "0", STR_PAD_LEFT)."\n\n";
		print_r ($release);
		echo "</pre>";
		echo '</p>';
	}
	elseif ($_POST['lookup'] == 'Skip'){
		echo "<p>Skipped Musicbrainz Lookup</p>";
	}
	else {
	?>
		<form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<p>Please enter the <a href="http://musicbrainz.org">Musicbrainz</a> ID and Ribcage will lookup the release and fill in the details automtically. This should be the Musicbrainz ID of the specific release, not the release group.</p> <p>If your release does not have a Musicbrainz ID, or if you wish to enter the release entirely manually, please click on Skip.</p>
		<table class="form-table">
		<tr valign="top">
		<th scope="row"><label for="musicbrainz_id">Musicbrainz ID</label></th>
		<td><input type="text" name="musicbrainz_id" value="18de3678-655c-4cc6-aa94-097b1caab782" class="regular-text code"/></td>
		</tr>
		</table>
		<p class="submit">
		<input type="submit" name="lookup" class="button-primary" value="<?php _e('Lookup') ?>" /><input type="submit" name="lookup" class="button-secondary" value="<?php _e('Skip') ?>" />
		</p>
		</form>
	<?php
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