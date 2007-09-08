<?php
require_once("../phpBrainz.class.php");
$mbid = "e9175559-babe-4554-9451-c2f8187f2573";

$trackIncludes = array(
	"artist",
	"releases",
	"puids"
	);

$phpBrainz = new phpBrainz();
print_r($phpBrainz->getTrack($mbid,$trackIncludes));
