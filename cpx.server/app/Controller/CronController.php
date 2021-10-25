<?php 
//error_reporting(E_ALL);
class CronController extends AppController {
    
    private function db_conn($preview = false,$users=false)
    {
        $serUrl = Configure::read('CONNECT_SER');
    			
		$m1 = new MongoClient($serUrl);
		
		// select a database
		$db2 = $m1->properties;
		
		if($preview)
            $collection = $m1->$db2->realprop_preview;
        elseif($users)
            $collection = $m1->$db2->users;
        else            
           $collection = $m1->$db2->realprop;     
        
        $m1->close();
        
        return $collection;
    }
    
    public function removePreviews()
    {
        $collection_preview = $this->db_conn(true);
        
        $rep = $collection_preview->remove();
        
        echo "Done";
        exit;
    }
    
    public function checkgradeStatus()
    {
        $collection = $this->db_conn();
        
        $searchQuery= array();
        $today_date = time();
        
        //$iprCompletion = array( 'iprs.completionTimeStamp' =>array ('$lte'=>$today_date) ,'iprs.iprStatus' =>'1');  
        
        $iprCompletion = array("iprs"=>array('$elemMatch'=>array('completionTimeStamp'=>array ('$lte'=>$today_date),'iprStatus' =>'1')));
        
        
        $searchQuery = $iprCompletion;    

//echo "<br>time".$today_date;
//echo "<pre>searchquery"; print_r($searchQuery); echo "</pre>";
//die;
        
        $cursor1 = $collection->find ($searchQuery)->skip(0)->limit(20);

//echo "<pre>cursor"; print_r($cursor1); echo "</pre>";
//die;
        
    	$propertyList = array();	
		foreach ( $cursor1 as $result ) 
        {
//echo "<pre>"; print_r($result); echo "</pre>";
//die;              

            $grade_status = 0;
            $iprArray = $result['iprs'];
            $grade = $result['grade'];
            $score = $result['score'];
            foreach($iprArray as &$ipr)
            {
                $publishDate = $ipr['publishedAt'];
                $tmp_datetime = explode('T', $publishDate);
                                    
                $tmp_date = explode('-',$tmp_datetime['0']);
                
                $published_date = $tmp_date['1'].'/'.$tmp_date['2'].'/'.$tmp_date['0'].' '.$tmp_datetime['1'];
                
                $published_dateTimeStamp = strtotime($published_date);
                $completion_dateTimeStamp = $published_dateTimeStamp+(95*86400);
                $completionDate = date('d/m/Y',$completion_dateTimeStamp);
                $iprStatus = "0";
                //echo "<br>".strtotime(date());
                
                if(time()<$completion_dateTimeStamp)
                {
                    $iprStatus = "1";
                    $grade_status = 2;
                }
                
                $ipr['iprStatus'] = $iprStatus;
            }
            
            
//echo "<pre>"; print_r($iprArray); echo "</pre>";
//exit;
            
            
            if($grade_status==0)
            {
                $grade=$score='';
            }
            
            
            $DetailsId = $result['id'];
    		$xyz['id'] =  $DetailsId;
            $newquery = $xyz; 

//echo "<pre>newquery";           
//print_r($newquery);
//echo "</pre>";

//echo "<br>gradestagus".$grade_status;
//echo "<br>grade".$grade;
//echo "<br>score".$score;
//exit;
           
            $retval = $collection->findAndModify ( $newquery, array (
    											'$set' => array ("iprs" => $iprArray,"gradestatus" => $grade_status,"grade" => $grade,"score" => $score)
    								
    									), null, array (
    											"sort" => array (
    													"priority" => - 1
    											),
    											"new" => true,
    											array ("safe" => true),
    												
    									) );

//echo "<br>retval==>".$retval;

		} 
            
        //echo "<pre>"; print_r($propertyList);echo "</pre>";
        echo "Done";
        exit;
    }
    
    
    function uploadimages2cpx()
    {
        
        $collection = $this->db_conn();
        
        $xyz= array();
        
        
        $serUrl = Configure::read('CONNECT_SER');
			
		$m1 = new MongoClient($serUrl);
		
        // select a database
		$db2 = $m1->properties;
		       
        $collection_pub = $m1->$db2->publishers;
        
        $deactivatepub = $deactivatepub_email = array();
        
        $deactivatepubquery = array('status' => false);
        $cursor_pub = $collection_pub->find ($deactivatepubquery);
        $deactivatePublisher_info = array();
		foreach ( $cursor_pub as $result ) {
                $deactivatePublisher_info[] = $result;
                
                if(!empty($result['agentID']))
                    $deactivatepub[] = $result['agentID'];
                
                if(!empty($result['email']))
                    $deactivatepub_email[] = $result['email'];                                
		}                      
            
    
        $xyz['$and'] = array();
	//	$xyz['$or'] = array();
		
        if(isset($deactivatepub) && count($deactivatepub))
        {
            $andSearchText =   array( 'agentID' => array('$nin'=>$deactivatepub));
            array_push($xyz['$and']  , $andSearchText);
        }
        
        if(isset($deactivatepub_email) && count($deactivatepub_email))
        {
            $andSearchText =   array( 'contact.email' => array('$nin'=>$deactivatepub_email));
            array_push($xyz['$and']  , $andSearchText);
        }

        $xyz['offline'] =  false;
        
        $imagecondition =  array( '$or' => array( array('cpximages' =>  array('$exists' => false)),array('cpximages' =>0)));
        array_push($xyz['$and']  , $imagecondition);      
            
        $noAgentCondition =  array( '$nor' =>array( array('agentID'=>array('$exists' => false)),array('agentID'=>array('$size' => 0))));
        array_push($xyz['$and']  , $noAgentCondition);      
        
        //echo "<pre>"; print_r($xyz);exit;
        
        
        $searchQuery = $xyz;
        
        
        $featured = array('featured_timestamp' => -1, 'modifiedon'=>-1) ;
        $cursor1 = $collection->find ($searchQuery)->sort($featured)->limit(5);
    	$propertyList = array();
        $propertyListURL = array();	
		foreach ( $cursor1 as $result ) 
        {
            $propertyList[] = $result;  
            $propertyListURL[] = ADMIN_PATH.'cron/updatepropertyimages/'.$result['id'];        
        
        }
       
      // echo "<pre>"; print_r($propertyListURL);echo "</pre>";
      // exit;
        
        $response = $this->multiple_threads_request_property($propertyListURL);
        
        $m1->close();     
                
        echo "<pre>"; print_r($response); echo "</pre>";exit; 
       
        
        
        
        
        
    }
    
    

    
    
    
    function updatepropertyimages($id='cpx981925')
    {
        
        $collection = $this->db_conn();
        
        $searchQuery= array();
        
        
        
        
        $searchQuery = array("id"=>$id);    

        $cursor1 = $collection->find ($searchQuery);
    	$propertyList = array();	
		foreach ( $cursor1 as $result ) 
        {
            $propertyDetail = $result;        
        
        }
        
        $images = $propertyDetail['images'];
        $imageurllist = array();
        foreach($images as $image)
        {
            $imageurllist[] = $image['url'];
        }
        $result = $this->multiple_threads_request($imageurllist,$propertyDetail['id']);
        
        
        
        $validImages = array();
       // echo "<pre>";
        foreach($result as $key=>$r)
        {            
           //print_r($r);
           $response = (array) json_decode($r['response']); 
           //echo "<pre>"; print_r($response); echo "</pre>";
           $status = $response['status']; 
           
           if($status)
           {

                $validImage = array();
                $validImage['id'] =  $key;
                $validImage['originalurl'] =  $response['originalurl'];
                $validImage['url'] =  $response['newurl']; 
                
                $validImages[] =  $validImage;
           }

        }
        
        if(count($validImages)==0)
        {
            $validImages['0']['id'] =  0;
            $validImages['0']['originalurl'] =  "http://www.centralpropertyexchange.com.au/images/nophotoavailable.png";
            $validImages['0']['url'] =  "http://www.centralpropertyexchange.com.au/images/nophotoavailable.png";
        }
        
        //$validImages = (array)$validImages;
       
		$xyz['id'] =  $propertyDetail['id'];
        $newquery = $xyz; 


       
        $retval = $collection->findAndModify ( $newquery, array (
											'$set' => array ("validImages" => $validImages,"cpximages"=>1)
								
									), null, array (
											"sort" => array (
													"priority" => - 1
											),
											"new" => true,
											array ("safe" => true),
												
									) );

        $response = array();
        $response['status'] = true;
        $response['id'] = $id;
        echo json_encode($response);
        exit;
        
        
    }
    
    function multiple_threads_request_property($nodes){ 
        $mh = curl_multi_init(); 
        $curl_array = array(); 
       
        foreach($nodes as $i => $url) 
        { 
            
            //echo $serverURL.urlencode($url);exit;
            $curl_array[$i] = curl_init($url); 
                                    
            curl_setopt($curl_array[$i], CURLOPT_RETURNTRANSFER, true); 
            curl_multi_add_handle($mh, $curl_array[$i]); 
        } 
            
        
        $running = NULL; 
        do { 
            usleep(10000); 
            curl_multi_exec($mh,$running); 
        } while($running > 0); 
        
        $res = array(); 
        foreach($nodes as $i => $url) 
        { 
            $res[$url] = curl_multi_getcontent($curl_array[$i]);
             
        } 
        
        foreach($nodes as $i => $url){ 
            curl_multi_remove_handle($mh, $curl_array[$i]); 
        } 
        curl_multi_close($mh);        
        return $res; 
    }
    
    
    
    function multiple_threads_request($nodes,$id){ 
        $mh = curl_multi_init(); 
        $curl_array = array(); 
        $serverURL = ADMIN_PATH."uploadimage/process/".$id."/";       
        
        
        
        foreach($nodes as $i => $url) 
        { 
            $postvars = array('id'=>$id,'imageURL'=>$url);
            //echo $serverURL.urlencode($url);exit;
            $curl_array[$i] = curl_init($serverURL); 
            
            curl_setopt($curl_array[$i],CURLOPT_POST, 1);                //0 for a get request
            curl_setopt($curl_array[$i],CURLOPT_POSTFIELDS,$postvars);
            curl_setopt($curl_array[$i],CURLOPT_TIMEOUT,120);
            curl_setopt($curl_array[$i], CURLOPT_RETURNTRANSFER, true); 
            curl_multi_add_handle($mh, $curl_array[$i]); 
        } 
        
       // echo "<pre>"; print_r($curl_array); exit;
        
        
        $running = NULL; 
        do { 
            usleep(10000); 
            curl_multi_exec($mh,$running); 
        } while($running > 0); 
        
        $res = array(); 
        foreach($nodes as $i => $url) 
        { 
            $res[$i]['response'] = curl_multi_getcontent($curl_array[$i]);
            $res[$i]['url'] = $url; 
        } 
        
        foreach($nodes as $i => $url){ 
            curl_multi_remove_handle($mh, $curl_array[$i]); 
        } 
        curl_multi_close($mh);        
        return $res; 
    }
    
    
    
                    
}
?>