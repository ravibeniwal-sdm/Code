<?php

use Cake\Routing\Router;
//ini_set ( 'max_execution_time', -1 );
ini_set('max_execution_time', 0);
error_reporting(0);

ignore_user_abort(true);
set_time_limit(0);
define ( "logfilesUrl", "../../datafiles/");

class UpdateimagearrayController extends AppController {
	
	public $helpers = array('Html', 'Form');
	public $components = array('RequestHandler');
	public $totalCount;
	public $foo = '';
	
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		$this->response->header('Access-Control-Allow-Origin','*');
		$this->response->header('Access-Control-Allow-Methods','*');
		$this->response->header('Access-Control-Allow-Headers','X-Requested-With');
		$this->response->header('Access-Control-Allow-Headers','Content-Type, x-xsrf-token');
		$this->response->header('Access-Control-Max-Age','172800');
		
		/* $this->response->header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0"); // // HTTP/1.1
		$this->response->header("Pragma: no-cache"); */
	}
	

	public function index($start=null,$end=null) {
		
		
		$serUrl = Configure::read('CONNECT_SER');
			
		$m1 = new MongoClient($serUrl);
		
		// select a database
		$db2 = $m1->properties;
		
		$collection = $m1->$db2->realprop;
		
		$cursor = $collection -> find();
		
		$count = $cursor->count();
		
        $m1->close();
        
		$apiurl = Configure::read('API_URL');
		$weburl = Configure::read('WEB_URL');
		
		$urls  = array();
		$limitDocs = 500;
		$limitFor = $count / $limitDocs;
		
		//echo ceil($limitFor);die;
		
       // echo "<pre>"; print_r($this->params);echo "</pre>";
        
        
        $docParams = $this->params['url'];
        
		if(isset($start) && $start!=null)
        {
         echo "<br> End =>".$limitFor = $end/$limitDocs;
        }
        $startRec = 0;
        if(isset($start) && $start !=null)
        {
         echo "<br> Start =>".$startRec = $start/$limitDocs;
        }
        
        //$limitFor = 125;
        
        
		
		
		//print_r($docParams); //die;
		

        $loghandle = fopen(logfilesUrl."cronlog.txt", "w+");

        fwrite($loghandle,"\n"." ====> cron status for ".date("Y-M-d"));
        
		
		if( !empty( $docParams['batchID'] ) )
		{
				
			$batchID = $docParams['batchID'] ;
			echo "GOT params as batchID ===" . $batchID; 
			$batch_cursor = $collection -> find(array('batchID' => $batchId));
		      
            $count = $batch_cursor->count();
            
            
            fwrite($loghandle,"\n".'count records='.$count);
            
            $limitDocs = 500;
		    $limitFor = $count / $limitDocs;
            
			
			for ($i = 0; $i < $limitFor; $i++) {
				//array_push('http://localhost/cpx/cpx.server/Search?limit=2&skip=2');
				$skipDocs = $limitDocs * $i;
				//echo "SKIP ---" . $skipDocs . " &&& "."LIMIT ---" . $limitDocs . "<br>";
				//array_push($urls , $apiurl.'/Validateimage?limit='.$limitDocs.'&skip='.$skipDocs);
					
				array_push($urls , $apiurl.'/Validateimage?limit='.$limitDocs.'&skip='.$skipDocs.'&batchID='.$batchID);
                
                fwrite($loghandle,"\n".$apiurl.'/Validateimage?limit='.$limitDocs.'&skip='.$skipDocs.'&batchID='.$batchID);
                
			}
			
			
		}
		else{
				
			$batchID = null;
			echo "NO params";
			
			for ($i = $startRec; $i < $limitFor; $i++) {
				//array_push('http://localhost/cpx/cpx.server/Search?limit=2&skip=2');
				$skipDocs = $limitDocs * $i;
				//echo "SKIP ---" . $skipDocs . " &&& "."LIMIT ---" . $limitDocs . "<br>";
				//array_push($urls , $apiurl.'/Validateimage?limit='.$limitDocs.'&skip='.$skipDocs);
					
				array_push($urls , $apiurl.'/Validateimage?limit='.$limitDocs.'&skip='.$skipDocs);
                fwrite($loghandle,"\n".$apiurl.'/Validateimage?limit='.$limitDocs.'&skip='.$skipDocs);
			}
			
			
		}
		
		fclose($loghandle);
		
		//echo "<pre>";
		//print_r($urls);
		//echo "</pre>";
		
		
		// initialize the multihandler
		$mh = curl_multi_init();
		
		$channels = array();
		foreach ($urls as $key => $url) {
			// initiate individual channel
			$channels[$key] = curl_init();
			curl_setopt_array($channels[$key], array(
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_FOLLOWLOCATION => true
					//CURLOPT_TIMEOUT_MS => 1
			));
		
			// add channel to multihandler
			curl_multi_add_handle($mh, $channels[$key]);
			
			//echo "URL => " .$url;
		}
		
		// execute - if there is an active connection then keep looping
		$active = null;
		do {
			$status = curl_multi_exec($mh, $active);
		}
		while ($active && $status == CURLM_OK);
		
		// echo the content, remove the handlers, then close them
		foreach ($channels as $chan) {
			//echo curl_multi_getcontent($chan);
			curl_multi_remove_handle($mh, $chan);
			curl_close($chan);
		}
		
		// close the multihandler
		curl_multi_close($mh);
		
		
		
	}
	
	





	
}
?>