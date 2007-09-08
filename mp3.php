<?php
require('../wp-blog-header.php');
define('WP_USE_THEMES', false);

//Speed up decoding process by increasing the PHP RAM limit.
ini_set('memory_limit', '18M');

$filename = '/Users/music/Sites/tmp/blah2.mp3';

// Did they want us to guess the properties of the track from the tags of the mp3 file? (default)
// If so, read the tags of the mp3 file and put the data in the database. If not read the form input
// then output the data to the database.

// include getID3 library
require_once('./ribcage-includes/getid3/getid3.php');

// Initialize getID3 library
$getID3 = new getID3;

$ThisFileInfo = $getID3->analyze($filename);
getid3_lib::CopyTagsToComments($ThisFileInfo);

// If we have a zip file uploaded, then unzip it and get the mp3s out and sorted.

// Check 

// Are there any 

get_header();
?>
<div id="entries">

<h3>Track Information</h3>
<p>
<?php echo @$ThisFileInfo['tags_html']['id3v2']['artist'][0]; ?> - <?php echo @$ThisFileInfo['tags_html']['id3v2']['title'][0]; ?> (<?php echo @$ThisFileInfo['playtime_string'];?>)
<br />
Track <?php echo @$ThisFileInfo['tags_html']['id3v2']['track'][0]; ?> of <?php echo @$ThisFileInfo['tags_html']['id3v2']['totaltracks'][0]; ?> from <?php echo @$ThisFileInfo['tags_html']['id3v2']['album'][0]; ?>
<br />
Released <?php echo @$ThisFileInfo['comments_html']['year'][0]; ?>
</p>
<h3>File Information</h3>
<p>
<?php echo ucwords(@$ThisFileInfo['audio']['channelmode']); ?> 
<?php echo (@$ThisFileInfo['audio']['bitrate_mode']=='vbr') ? 'variable bitrate' : 'constant bitrate'; ?> 
<?php echo  strtoupper(@$ThisFileInfo['audio']['dataformat']); ?> at 

	
<?php echo (@$ThisFileInfo['audio']['bitrate_mode']=='vbr') ? '&cong;' : ' ';?>

<?php echo round($ThisFileInfo['audio']['bitrate'] / 1000).' kbps'; ?>
<br />
<?php
if (!empty($ThisFileInfo['tags_html']['id3v2']['encoded_by'][0])){
	echo 'Encoded with '.$ThisFileInfo['tags_html']['id3v2']['encoded_by'][0].'<br />';
} 
?>
Sample Rate: <?php echo $ThisFileInfo['audio']['sample_rate']/1000; ?>kHz
</p>

<?php
// Check if this is the right encoding format. If not, error.
if (@$ThisFileInfo['audio']['dataformat'] == 'mp3' && @$ThisFileInfo['audio']['encoder_options'] != '--preset fast extreme -b32') {
	?>
	<p>
	This MP3 is encoded with an incorrect bitrate, please re-encode.
	</p>
<?php
}
?>
	
<?php

// Move the file into the correct directory.	
//rename ($filename,  $name);

// Only display a complete release on the main site. Incomplete releases show up on the back end,
// but not on the frontend. So set the "complete" bit to 0 if incomplete.

// If the release is complete, then check to see if it is in the Musicbrainz database.
// If the release is not in the Musicbrainz database, then add it.

// Output hAudio Microformat including detailed hcard pulled from artist description.

// All these things use the Musicbrainz schema.
?>
</div>
<?php
get_sidebar();
get_footer();
?>



<?php
function createHAudio (){
	?>
	<div class="haudio">
	   <img class="image-summary" src="images/sneaking_sally.jpg"/>
	   <span class="audio-title">Sneaking Sally Thru The Alley</span>
	   <span class="contributor">
	      <span class="vcard">
	         <span class="fn org">Phish</span>
	      </span>
	   </span>
	   <br/>
	   Released on:
	   <abbr class="published-date" title="20063110">October 31, 2006<abbr>
	   <br/>
	   Acquire: 
	   <a rel="sample" href="/samples/sneaking_sally.mp3">Sample</a>, 
	   <a rel="enclosure" href="/live/sneaking_sally.mp3">Live Recording</a>,
	   <a rel="payment" href="/buy/sneaking_sally">Buy High Quality Track</a>
	   Category: <span class="category">live</span>
	   Duration: <abbr class="duration" title="447">7 minutes, 27 seconds</abbr>
	   Price: <span class="money">
	             <abbr class="currency" title="USD">$</abbr>
	             <span class="amount">0.99</span>
	          </span>
	</div>
	<?php
	
}
//return $result;
?>

<?php
function create_hCard (){
	?>
	<div class="vcard">
	  <div class="fn org">Wikimedia Foundation Inc.</div>
	  <div class="adr">
	    <div class="street-address">200 2nd Ave. South #358</div>
	    <div>
	      <span class="locality">St. Petersburg</span>, 
	      <abbr class="region" title="Florida">FL</abbr> <span class="postal-code">33701-4313</span>
	    </div>
	    <div class="country-name">USA</div>
	    </div>
	  <div>Phone: <span class="tel">+1-727-231-0101</span></div>
	  <div>Email: <span class="email">info@wikimedia.org</span></div>
	  <div>
	    <span class="tel"><span class="type">Fax</span>: 
	    <span class="value">+1-727-258-0207</span></span>
	  </div>
	</div>
	<?php
//return $result;	
}
?>
