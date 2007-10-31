<?php
/*

This script scans a directory for FLAC files and then converts them to various file formats in a
specific directory tree, adding to the Ribcage database in the process.

*/

$flacpath = '';
$lamepath = '';
$oggpath = '';

ini_set('memory_limit', '18M');
system ('clear');
require_once('../ribcage-includes/getid3/getid3.php');

if ($argv[1] == null){
	$dir = getcwd();
}
else {
	$dir = $argv[1];
}

$dh  = opendir($dir);
while (false !== ($filename = readdir($dh))) {
    $files[] = $filename;
}
sort ($files);

print "Ribcage Add Release v 1.0\n";
print "Looking through $dir for FLAC files...";
$getID3 = new getID3;

array ($tracks);

foreach ($files as $filename) {
	list ($name, $ext) = explode ('.', $filename);
	
	if ($ext == 'flac'){
		$file = $getID3->analyze("$dir/$filename");
		getid3_lib::CopyTagsToComments($file);
		print_r ($file);
		$tracks [] = array (
			'path' => addslashes("$dir/$filename"),
			'filename' => addslashes($filename),
			'filename_name' => addslashes($name),
			
			'artist'=> @$file['comments']['artist'][0],
			'title' => @$file['comments']['title'][0],
			'album' => @$file['comments']['album'][0],
			'year' => @$file['comments']['date'][0],
			
			'track' => @$file['comments']['tracknumber'][0],
			'total_tracks' => @$file['comments']['tracktotal'][0]
			);
	}
}

$no_of_tracks = count($tracks);

if ($no_of_tracks == 0){
	print "nope\n";
	print "I didn't find any FLAC files\n";
	exit ('1');
}
print "found ".$no_of_tracks." files\n";

// TODO: Check they have consistant tags etc. For now we just read off the first track and make an assumption based upon it

$release = array (
		'title'=>$tracks[0]['album'],
		'artist'=>$tracks[0]['artist'],
		'year'=>$tracks[0]['year'],
		'total_tracks' => $tracks[0]['total_tracks']
	);


$storage = join ('/', array($dir, $release['artist']));

print "Making directory tree...";
mkdir ($storage);

$storage = join ('/', array($dir, $release['artist'], $release['title']));
mkdir ($storage);

mkdir (join ('/', array($storage, 'download')));
mkdir (join ('/', array($storage, 'stream')));
mkdir (join ('/', array($storage, 'download', 'flac')));
mkdir (join ('/', array($storage, 'download', 'mp3')));
mkdir (join ('/', array($storage, 'download', 'ogg')));
mkdir (join ('/', array($storage, 'zip')));

print "done\n\n";

print $release['artist'].' - '.$release['title']."\n";
print "====================================================\n\n";

$current_track = 1;

foreach ($tracks as $track) {		
	
	print "=== [".$current_track.'/'.$no_of_tracks.'] '.$track['title']."\n";
	print "Converting to wav file for processing...";
	system ("$flacpath -d -s '".$track['path']."'");
	print "done \n";
	
	$wav = join ('.',array($track['filename_name'], 'wav'));
	$mp3 = join ('.',array($track['filename_name'], 'mp3'));
	$ogg = join ('.',array($track['filename_name'], 'ogg'));

	$lametag= "--ta '".$release['artist']."' --tl '".$release['title']."' --ty '".$release['year']."' --tn '".$track['track']."' --tt '".$track['title']."'";
	
	print "Converting to high quality mp3...";
	system ("$lamepath $lametag --quiet -V 0 --vbr-new '".$dir."/".$wav."' '".join ('/', array($storage, 'download','mp3',$mp3))."'");
	print "done \n";
	
	print "Converting to streamable mp3...";
	system ("$lamepath $lametag --quiet --cbr -b 128 '".$dir."/".$wav."' '".join ('/', array($storage, 'stream',$mp3 ))."'");
	print "done\n";
	
	$oggtag= "-a '".$release['artist']."' -l '".$release['title']."' -d '".$release['year']."' -N '".$track['track']."' -t '".$track['title']."'";
	
	print "Converting to ogg file...";
	system ("$oggpath $oggtag -Q -q 5 -o '".join ('/', array($storage, 'download','ogg',$ogg ))."' '".$dir."/".$wav."'");
	print "done\n";
	
	print "Moving flac file to correct directory...";
	rename ($track['path'],join ('/', array($storage, 'download','flac',$track['filename'])));
	print "done\n";
	
	print "Cleaning up...";
	unlink ("$dir/$wav");
	print "done\n";
	
	print "Adding file to database...";
	print "done\n";
	
	$current_track++;
	print "\n";
	
}

print "Making zip release bundles...flac...";
system ("zip -9 -jqr '".$storage."/zip/".$release['artist']."_".$release['title']."_flac.zip' '".$storage."/download/flac'");
echo "mp3...";
system ("zip -9 -jqr '".$storage."/zip/".$release['artist']."_".$release['title']."_mp3.zip' '".$storage."/download/mp3'");
echo "ogg...";
system ("zip -9 -jqr '".$storage."/zip/".$release['artist']."_".$release['title']."_ogg.zip' '".$storage."/download/ogg'");
print "done \n";

print "All done!\n";
exit (0);

?>
