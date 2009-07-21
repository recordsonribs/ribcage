<?php
require_once("../phpBrainz.class.php");
class mb_process{
    private $track_files;
    private $track_count;
    private $track_ids;
    private $track_objs;
    private $phpBrainz;
    function __construct($directory){
        $this->phpBrainz = new phpBrainz();
        $track_files = array();
        $dir_resource = opendir($directory);
        while (false !== ($file = readdir($dir_resource))) {
            if(substr($file,-4)==".mp3"){
                $this->track_files[] = array('file_name'=>$file);
            }
        }
        $i=4;
        $puid_count = 0;
        foreach($this->track_files as $key=>$track_file_arr){
        		if(rand(0,3) != 2){continue;}
        		
		        $cmd = escapeshellcmd("genpuid abc2b2939e969235c0110d6e5633930c $directory/{$track_file_arr['file_name']}");
		        $cmd_output = array();
		        exec($cmd,$cmd_output);
		        //var_dump($cmd_output);
		        $filename = $cmd_output[$i];
        		if(!isset($track_file_arr['puid']) && strpos($filename,$track_file_arr['file_name'])!==false){
                    $this->track_files[$key]['puid'] = substr($cmd_output[$i+1],7);
                }
        }
        /*
        //This jumps to the start of the data we want from the output
        $i=5;
        while($i<count($cmd_output)){
            $filename = $cmd_output[$i];
            foreach($this->track_files as $key=>$track_file_arr){
                if(!isset($track_file_arr['puid']) && strpos($filename,$track_file_arr['file_name'])!==false){
                    $this->track_files[$key]['puid'] = substr($cmd_output[$i+1],7);
                }
            }
            $i++;
            $i++;
        }
		*/
        $this->track_count = count($this->track_files);
        print("DONE WITH PUIDS TRACK COUNT: \n");
        //die();
        $this->findTrackReleases();
        
        $this->calculateBestMatch();
       // var_dump($cmd_output);
        //var_dump($this->track_files);


    }
    
    function findTrackReleases(){
        $phpBrainz = new phpBrainz();
        //print_r($this->track_files);

        foreach($this->track_files as $key=>$track_file){
        	if(!isset($track_file['puid'])){
        		continue;
        	}
            $puid = $track_file['puid'];
                
            $args = array(
                "puid"=>$puid,
                "count"=>$this->track_count,
                "limit"=>3
            );
            
            $trackFilter = new phpBrainz_TrackFilter($args);
            $trackResults = $phpBrainz->findTrack($trackFilter);
            //print_r($trackResults);
            if(isset($trackResults[0]) && $trackResults[0] instanceof phpBrainz_Track ){
                //print_r($trackResults);
                foreach($trackResults as $tr){
                    $this->track_files[$key] = array();
                    $this->track_files[$key][] = array(
                        'mbid'      => $tr->getId(),
                        'releases'  => $tr->getReleases(),
                        'artist'    => $tr->getArtist(),
                    	'score'		=> $tr->getScore() == 100 ? 150 : $tr->getScore()
                    );
                }
            }
           sleep(1);            
        }        
    }
    
    function calculateBestMatch(){
        $trimmed = array();
        $count = array();
        foreach($this->track_files as $track_file){
            foreach($track_file as $psRelease){
                if(!isset($psRelease['releases']) || !is_array($psRelease['releases'])){
                    continue;
                }
               // print_r($track_file['releases']);
                // print_r($psRelease);
                foreach($psRelease['releases'] as $possibleRelease){
                    //print_r($possibleRelease);
                    
                    if(count($trimmed)==0){
                        $trimmed[] = $possibleRelease;
                        $count[] = 1;
                        continue;
                    }
                    $found = false;
                    foreach($trimmed as $t_key=>$possibleMatch){
                       
                        if($possibleRelease->equals($possibleMatch)){
                            $count[$t_key]++;
                            $found = true; 
                            break;
                        }
                    }
                    if(!$found){
                        //print($possibleMatch->getTitle() ." Does not equal ".$possibleRelease->getTitle()."\n");
                        $trimmed[] = $possibleRelease;
                        $count[]    = 1;
                        break;
                    }
                           
                }
            }
        }
       print_r($trimmed);
       // print_r($count);
        $max = -1;
        $maxk = -1;
        foreach($count as $k=>$c){
            if($c > $max){
                $max = $c;
                $maxk = $k;
            }
        }
        $trackIncludes = array("artist");
        $release = $this->phpBrainz->getRelease($trimmed[$maxk]->getId(),$trackIncludes);
       // $this->track_files[0]['artist']->getName();
        print("Best Guess\n --------------- \n Artist: ".$release->getArtist()->getName()."\n Album: ".$release->getTitle()."\n");
    }
}

$mb = new mb_process("/Users/jeffsherlock/Music/Beck-Odelay-1996-iRO/");
$mb = new mb_process("/Users/jeffsherlock/Music/Lily_Allen-Alright_Still-2007-FTD");
$mb = new mb_process("/Users/jeffsherlock/Music/Timbaland-Present_Shock_Value_(Deluxe_Edition)-2CD-2007-SMO/");
$mb = new mb_process("/Users/jeffsherlock/Music/Death_Cab_For_Cutie-Plans-2005-iRO");
//$mb = new mb_process("/Users/jeffsherlock/Music/Timbaland-The_Way_I_Are_BW_Give_It_To_Me_(Remix)-(Promo_VLS)-2007-R6");
$mb = new mb_process("/Users/jeffsherlock/Music/David_Gray-White_Ladder-1999-iRO");