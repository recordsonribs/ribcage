<pre>
<?php
require_once("../phpBrainz.class.php");
$mbid = "ce20794f-2aef-4b6f-8456-cb4c2ef929d5";

$trackIncludes = array(
	"artist",
	"discs",
	"tracks"
	);

$phpBrainz = new phpBrainz();
$release = $phpBrainz->getRelease($mbid,$trackIncludes);

print 'Artist: '.$release->getArtist()->getName()."\n";
print 'Sort Artist: '.$release->getArtist()->getSortName()."\n";
print 'Title: '.$release->getTitle()."\n";
print 'Musicbrainz ID: '.$release->getID()."\n\n";
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

print_r($release);

?>
</pre>