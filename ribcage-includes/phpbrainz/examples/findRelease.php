<?php
/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA

phpBrainz is a php class for querying the musicbrainz web service.
Copyright (c) 2007 Jeff Sherlock

*/

require_once("../phpBrainz.class.php");

//Create new phpBrainz object
$phpbrainz = new phpBrainz();

$mbid = '18de3678-655c-4cc6-aa94-097b1caab782';
$slug = 'itsabouttime';
$artist_slug = 'talklesssaymore';

// Downloads are a file path.
print $artist_slug.'/'.$slug.'/download';

// Streams are a URL.
print $artist_slug.'/'.$slug.'/stream';

print "<pre>";

print "Looking up Musicbrainz ID ".$mbid."...";

// Include everything, why the hell not.
$trackIncludes = array(
	"artist",
	"counts",
	"release-events",
	"discs",
	"tracks",
	"artist-rels",
	"label-rels",
	"release-rels",
	"track-rels",
	"url-rels",
	"track-level-rels",
	"labels"
	);

$brainz_release = $phpbrainz->getRelease($mbid,$trackIncludes);
print "done";
print "\n\n";

$artist = $brainz_release->getArtist(1);
print $artist->getName(1).' - '.$brainz_release->getTitle(1)."\n\n";

$tracks = $brainz_release->getTracks(1);
$track_no = 1;
$time = 0;

foreach($tracks as $track){
    print$track_no.'. '.$track->getTitle();
	//print($track->getID()."\n");
	print ' ('.$track->getDuration().") \n";
	
	// Work out downloads from the slug specified earlier.
	
	// Work out the streams in a similar manner.
	
	$time = $time + $track->getDuration();
	$track_no++;
}

print "\n";
print 'Total Time: '.$time."\n";
print "</pre>";


