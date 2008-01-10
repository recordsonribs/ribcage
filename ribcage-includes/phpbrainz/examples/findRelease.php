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
$phpBrainz = new phpBrainz();

$args = array(
    "title"=>"Ideal Forms",
    "artist"=>""
);

$releaseFilter = new phpBrainz_ReleaseFilter($args);
$releaseResults = $phpBrainz->findRelease($releaseFilter);

print "<pre>";
print_r (@$releaseResults);
print "</pre>";

$trackIncludes = array(
		"tracks",
	);
	
$mbid = '5e276aa7-4f6c-40b5-8867-9c926c8781f1';

$array = $phpBrainz->getRelease($mbid,$trackIncludes);

print "<pre>";
print_r($array);
print "</pre>";


