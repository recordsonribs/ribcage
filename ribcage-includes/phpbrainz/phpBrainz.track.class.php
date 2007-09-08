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
class phpBrainz_Track{
    private $id;
    private $artist;
    private $duration;
    private $puids;
    private $releases;
    private $title;


    
    function __construct(){
        $this->releases = array();
        $this->puids    = array();
    }
    
    public function setArtist($artist){
        if(!($artist instanceof phpBrainz_Artist)){
            die(print("setArtist only takes in phpBrainz_Artist objects"));
        }
        $this->artist = $artist;
    }
    public function getArtist(){
        return $this->artist;
    }
    
    public function setDuration($duration){
        if(!is_numeric($duration)){
            die(print("Duration must be numeric."));
        }
        $this->duration = $duration;
    }
    public function getDuration(){
        return $this->duration;
    }
    
    public function setTitle($title){
        $this->title = $title;
    }
    public function getTitle(){
        return $this->title;
    }
    
    public function setId($id){
        $this->id = $id;        
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getReleases(){
        return $this->releases;
    }
    public function addRelease($release){
        if(!($release instanceof phpBrainz_Release)){
            die(print("Releases must be of type phpBrainz_Release"));
        }
        $this->releases[] = $release;
    }
    
    public function addPuid($puid){
        $this->puids[] = $puid;
    }
    public function getPuids(){
        return $this->puids;
    }
}