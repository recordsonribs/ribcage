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
/**
 * Represents a MusicBrainz artist.
 * 
 * @author Jeff Sherlock
 * @copyright Jeff Sherlock 2007
 * @package phpBrainz
 * @name phpBrainz_Artist
 * 
 */
class phpBrainz_Artist{
    private $id;
    private $name;
    private $sortName;
    private $beginDate;
    private $endDate;
    
    function __construct(){}
    
    public function setName($name){
        $this->name = $name;
    }
    public function getName(){
        return $this->name;
    }
    
    public function setId($id){
        $this->id = $id;        
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function setSortName($sortName){
        $this->sortName = $sortName;
    }
    
    public function getSortName(){
        return $this->sortName;
    }
    
    public function setBeginDate($beginDate){
        $this->beginDate = $beginDate;
    }
    public function getBeginDate(){
        return $this->beginDate;
    }
    
    public function setEndDate($endDate){
        $this->endDate = $endDate;
    }
    public function getEndDate(){
        return $this->endDate;
    }
}