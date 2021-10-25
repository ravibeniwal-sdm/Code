<?php 
//error_reporting(E_ALL);

class EndorsementsController extends AppController {
    
    public $helpers = array('Html', 'Form');
	public $components = array('Session','RequestHandler');
	
	
    
    
    public function beforeFilter() {
        $logedinuser = $this->Session->read('User');
       
        $allowAction = array("fetchEndorsements");
        if(!in_array($this->action,$allowAction))    
            $this->checkAdminLogin();
        
        $this->set('logedinuser',$logedinuser);
        parent::beforeFilter();
	}
    
    private function db_conn()
    {
        $serUrl = Configure::read('CONNECT_SER');
    			
		$m1 = new MongoClient($serUrl);
		
		// select a database
		$db2 = $m1->properties;
		
        $collection = $m1->$db2->endorsements;
        
        $m1->close();     
        
        return $collection;
    }
    
    public function index($page=1,$id='')
    {
        $this->layout = "admin";
        
        $collection = $this->db_conn();
        
        $newquery = array();
        
        $skipdoc = ($page-1)*20;
        
        if(!empty($id))
        {     
            $collection->remove(array('id' => $id));
        }
        
        $countrec = $collection-> count($newquery);

        $noOFPages = 0;
        if($countrec>20)
        {
            $noOFPages =  ceil($countrec/20);
            
        }
        //echo $noOFPages;exit;
        
        $cursor1 = $collection->find ($newquery)->sort(array('order'=>1));
        
		$endorsementsList = array ();
		foreach ( $cursor1 as $result ) {
		  array_push ( $endorsementsList, $result );
		} 
        
        $total_endorsements = $active_endorsements = 0;
        
        $newquery1 = array('status' => 1);
        $active_endorsements = $collection-> count($newquery1);


                
        $this->set('endorsementsList',$endorsementsList); 
        $this->set('active_endorsements',$active_endorsements);
        $this->set('total_endorsements',$countrec);
        $this->set('currentPage',$page);
        $this->set('noOFPages',$noOFPages);
        $this->set('page','endorsements');
        
        //echo "<pre>endorsements";
//        print_r($endorsementsList);
//        echo "</pre>";
//        die;


        
    }
    
    function add()
    {
        $this->layout = 'admin' ; 
        $collection = $this->db_conn();

        if(!empty($this->data))
        {
//echo "<pre>endorsements";
//print_r($this->data);
//echo "</pre>";
//die;
            
            $endorsementdata = array();
            $logos_arr = array();           
            if($this->data['logo_text'] == 'logo_val')
            {
                if(isset($this->data['AgreementDoc_name']))
                {
                    foreach($this->data['AgreementDoc_name'] as $key=>$logoname)
                    {
                        $logos_arr[] =array('name'=>$logoname,'path'=>$this->data['AgreementDoc_path'][$key],'size'=>$this->data['AgreementDoc_size'][$key],'type'=>$this->data['AgreementDoc_type'][$key],'isurl'=>$this->data['AgreementDoc_isurl'][$key]);
                    }
                }  
            }
            $endorsementdata['logo'] = $logos_arr;
                
            if($this->data['logo_text'] == 'text_val')
                $endorsementdata['text'] = $this->data['text'];
            else
                $endorsementdata['text'] = '';
            
            $endorsementdata['url'] =  $this->data['url'];
            $endorsementdata['logo_width'] =  $this->data['logo_width'];
            $endorsementdata['logo_height'] =  $this->data['logo_height'];
            $endorsementdata['status'] =  1;
             
            $foundLastRecord = $collection->find()->sort(array("_id" => -1))->limit(1);
            $lastRecordArr = array ();
            foreach ( $foundLastRecord as $result ) {
                array_push ( $lastRecordArr, $result );
            } 

            if(!empty($lastRecordArr))
                $order = $nextID = $lastRecordArr['0']['id']+1;
            else
                $order = $nextID = 1;

            $endorsementdata['id'] = "$nextID";
            $endorsementdata['order'] = "$order";

//echo "<pre>endorsements";
//print_r($endorsementdata);
//echo "</pre>";
//die;

            $res = $collection->insert ( $endorsementdata, array ("safe" => true) );
            
            if($res)
                $this->set('success_msg','New endorsement added successfully');
            else
                $this->set('error_msg','Failed to add new endorsement'); 
        }
        
        $this->set('page','endorsements');
    }
    
    function edit($id,$page='1')
    {
        $this->layout = 'admin' ; 
        $collection = $this->db_conn();


        if(!empty($this->data))
        {
//echo "<pre>endorsements";
//print_r($this->data);
//echo "</pre>";
//die;            
            $endorsementdata = array();
            $logos_arr = array();
            if($this->data['logo_text'] == 'logo_val')
            {
                if(isset($this->data['AgreementDoc_name']))
                {
                    foreach($this->data['AgreementDoc_name'] as $key=>$logoname)
                    {
                        $logos_arr[] =array('name'=>$logoname,'path'=>$this->data['AgreementDoc_path'][$key],'size'=>$this->data['AgreementDoc_size'][$key],'type'=>$this->data['AgreementDoc_type'][$key],'isurl'=>$this->data['AgreementDoc_isurl'][$key]);
                    }
                }  
            }
            $endorsementdata['logo'] = $logos_arr;
                
            if($this->data['logo_text'] == 'text_val' && !empty($this->data['text']))
                $endorsementdata['text'] = $this->data['text'];
            else
                $endorsementdata['text'] = '';
            
            if(!empty($this->data['logo_width']))
                $endorsementdata['logo_width'] =  $this->data['logo_width'];
            else
                $endorsementdata['logo_width'] = ''; 
                
            if(!empty($this->data['logo_height']))
                $endorsementdata['logo_height'] =  $this->data['logo_height'];
            else
                $endorsementdata['logo_height'] = '';     
                               
            
            if(!empty($this->data['url']))
                $endorsementdata['url'] =  $this->data['url'];
                
//echo "<pre>endorsements";
//print_r($this->data);
//print_r($endorsementdata);
//echo "</pre>";
//die;

            $DetailsId = $id;
    		$xyz['id'] =  $DetailsId;
            $newquery = $xyz; 

            $retval = $collection->findAndModify ( $newquery, array (
											'$set' => $endorsementdata
								
									), null, array (
											"sort" => array (
													"priority" => - 1
											),
											"new" => true,
											array ("safe" => true),
												
									) );
            
            if($retval)
                $this->set('success_msg','Endorsement edited successfully');
            else
                $this->set('error_msg','Failed to edit endorsement'); 
        }
        
        if(empty($id))
            $this->redirect("/endorsements/");
        
        $newquery = array('id' =>  $id);
        
        $cursor1 = $collection->find ($newquery);
    
		$endorsementsList = array ();
		foreach ( $cursor1 as $result ) {
		  array_push ( $endorsementsList, $result );
		}  


//echo "<pre>endorsements";
//print_r($endorsementsList['0']);
//echo "</pre>";
//die;

        $this->set('endorsements',$endorsementsList['0']);        
        
        $this->set('currentPage',$page);
        $this->set('page','endorsements');
    }
    
    function toggleStatus($id)
    {
        
        if(empty($id))
        {
            echo "0";exit;
        }
        
        $this->layout = "admin";
                
        $collection = $this->db_conn();
        
        $DetailsId = $id;
		$xyz['id'] =  $DetailsId;
        $newquery = $xyz; 
        
        $cursor1 = $collection->find ($newquery);
        $endorsementInfo = array ();
		foreach ( $cursor1 as $result ) {
  		    array_push ( $endorsementInfo, $result );
		}

//echo "<pre>";
//print_r($endorsementInfo);
//echo "</pre>";     
   
        $savedvalue = $endorsementInfo[0]['status'];
        
        $value = 1;
        if($savedvalue==1)
            $value = 0;

       
        $retval = $collection->findAndModify ( $newquery, array (
											'$set' => array (
													'status' => $value,
											)
								
									), null, array (
											"sort" => array (
													"priority" => - 1
											),
											"new" => true,
											array ("safe" => true),
												
									) );

        
        $newquery1 = array('status' => 1);
        $countactive = $collection-> count($newquery1);
        
        $returnArray=array();
        $returnArray['value'] = $value;
        $returnArray['status'] = true;
        $returnArray['active_endorsements'] = $countactive;
               
        echo json_encode($returnArray);
        exit;
        
        
    }
    
    function changeorder($page)
    {
        if(isset($_POST["sort_order"])) 
        {
            $id_ary = explode(",",$_POST["sort_order"]);
            
            $collection = $this->db_conn();
            
            for($i=1;$i <= count($id_ary);$i++) 
            {
                
                $DetailsId = $id_ary[$i-1];
        		$xyz['id'] =  $DetailsId;
                $newquery = $xyz; 
                
                $retval = $collection->findAndModify ( $newquery, array (
    											'$set' => array (
    													'order' => $i,
    											)
    								
    									), null, array (
    											"sort" => array (
    													"priority" => - 1
    											),
    											"new" => true,
    											array ("safe" => true),
    												
    									) );
            }
            
            $newquery = array();
            
            $skipdoc = ($page-1)*20;
            
            $countrec = $collection-> count($newquery);
    
            $noOFPages = 0;
            if($countrec>20)
            {
                $noOFPages =  ceil($countrec/20);
                
            }
            //echo $noOFPages;exit;
            
            $cursor1 = $collection->find ($newquery)->sort(array('order'=>1));
            
    		$endorsementsList = array ();
    		foreach ( $cursor1 as $result ) {
    		  array_push ( $endorsementsList, $result );
    		} 
            
            $newquery1 = array('status' => 1);
            $countactive = $collection-> count($newquery1);
            
            $this->set('endorsementsList',$endorsementsList); 
            $this->set('currentPage',$page);
            $this->set('active_endorsements',$countactive);
            $this->set('total_endorsements',$countrec);
        }        
    }    
    
}
?>