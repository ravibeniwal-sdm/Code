<?php 
//error_reporting(E_ALL);

class SponsorsController extends AppController {
    
    public $helpers = array('Html', 'Form');
	public $components = array('Session','RequestHandler');
	
	
    
    
    public function beforeFilter() {
        $logedinuser = $this->Session->read('User');
       
        $allowAction = array("fetchSponsors");
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
		
        $collection = $m1->$db2->sponsors;
        
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
        
		$sponsorsList = array ();
		foreach ( $cursor1 as $result ) {
		  array_push ( $sponsorsList, $result );
		} 
        
        $total_sponsors = $active_sponsors = 0;
        
        $newquery1 = array('status' => 1);
        $active_sponsors = $collection-> count($newquery1);


                
        $this->set('sponsorsList',$sponsorsList); 
        $this->set('active_sponsors',$active_sponsors);
        $this->set('total_sponsors',$countrec);
        $this->set('currentPage',$page);
        $this->set('noOFPages',$noOFPages);
        $this->set('page','sponsors');
        
        //echo "<pre>sponsors";
//        print_r($sponsorsList);
//        echo "</pre>";
//        die;


        
    }
    
    function add()
    {
        $this->layout = 'admin' ; 
        $collection = $this->db_conn();

        if(!empty($this->data))
        {

            
            $sponsordata = array();
            $logos_arr = array();           
            
            if(isset($this->data['AgreementDoc_name']))
            {
                foreach($this->data['AgreementDoc_name'] as $key=>$logoname)
                {
                    $logos_arr[] =array('name'=>$logoname,'path'=>$this->data['AgreementDoc_path'][$key],'size'=>$this->data['AgreementDoc_size'][$key],'type'=>$this->data['AgreementDoc_type'][$key],'isurl'=>$this->data['AgreementDoc_isurl'][$key]);
                }
            }  
            
            $sponsordata['logo'] = $logos_arr;
                
            
            
            $sponsordata['url'] =  $this->data['url'];
            $sponsordata['sponsor_name'] =  $this->data['sponsor_name'];
            $sponsordata['loan_type'] =  $this->data['loan_type'];
            $sponsordata['term'] =  $this->data['term'];
            $sponsordata['intrest_rate'] =  $this->data['intrest_rate'];
            $sponsordata['status'] =  1;
             
           // echo "<pre>"; print_r($sponsordata);echo "</pre>";exit; 
             
            $foundLastRecord = $collection->find()->sort(array("_id" => -1))->limit(1);
            $lastRecordArr = array ();
            foreach ( $foundLastRecord as $result ) {
                array_push ( $lastRecordArr, $result );
            } 

            if(!empty($lastRecordArr))
                $order = $nextID = $lastRecordArr['0']['id']+1;
            else
                $order = $nextID = 1;

            $sponsordata['id'] = "$nextID";
            $sponsordata['order'] = "$order";

//echo "<pre>sponsors";
//print_r($sponsordata);
//echo "</pre>";
//die;

            $res = $collection->insert ( $sponsordata, array ("safe" => true) );
            
            if($res)
                $this->set('success_msg','New sponsor added successfully');
            else
                $this->set('error_msg','Failed to add new sponsor'); 
        }
        
        $this->set('page','sponsors');
    }
    
    function edit($id,$page='1')
    {
        $this->layout = 'admin' ; 
        $collection = $this->db_conn();


        if(!empty($this->data))
        {
//echo "<pre>sponsors";
//print_r($this->data);
//echo "</pre>";
//die;            
            $sponsordata = array();
            $logos_arr = array();
              if(isset($this->data['AgreementDoc_name']))
                {
                    foreach($this->data['AgreementDoc_name'] as $key=>$logoname)
                    {
                        $logos_arr[] =array('name'=>$logoname,'path'=>$this->data['AgreementDoc_path'][$key],'size'=>$this->data['AgreementDoc_size'][$key],'type'=>$this->data['AgreementDoc_type'][$key],'isurl'=>$this->data['AgreementDoc_isurl'][$key]);
                    }
                }  
            
            $sponsordata['logo'] = $logos_arr;
            $sponsordata['url'] =  $this->data['url'];
            $sponsordata['sponsor_name'] =  $this->data['sponsor_name'];
            $sponsordata['loan_type'] =  $this->data['loan_type'];
            $sponsordata['term'] =  $this->data['term'];
            $sponsordata['intrest_rate'] =  $this->data['intrest_rate'];    
                
                               
            
              
//echo "<pre>sponsors";
//print_r($this->data);
//print_r($sponsordata);
//echo "</pre>";
//die;

            $DetailsId = $id;
    		$xyz['id'] =  $DetailsId;
            $newquery = $xyz; 
          //  echo "<pre>"; print_r($newquery);exit;
            $retval = $collection->findAndModify ( $newquery, array (
											'$set' => $sponsordata
								
									), null, array (
											"sort" => array (
													"priority" => - 1
											),
											"new" => true,
											array ("safe" => true),
												
									) );
            
            if($retval)
                $this->set('success_msg','Sponsor edited successfully');
            else
                $this->set('error_msg','Failed to edit sponsor'); 
        }
        
        if(empty($id))
            $this->redirect("/sponsors/");
        
        $newquery = array('id' =>  $id);
        
        $cursor1 = $collection->find ($newquery);
    
		$sponsorsList = array ();
		foreach ( $cursor1 as $result ) {
		  array_push ( $sponsorsList, $result );
		}  


//echo "<pre>sponsors";
//print_r($sponsorsList['0']);
//echo "</pre>";
//die;

        $this->set('sponsors',$sponsorsList['0']);        
        
        $this->set('currentPage',$page);
        $this->set('page','sponsors');
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
        $sponsorInfo = array ();
		foreach ( $cursor1 as $result ) {
  		    array_push ( $sponsorInfo, $result );
		}

//echo "<pre>";
//print_r($sponsorInfo);
//echo "</pre>";     
   
        $savedvalue = $sponsorInfo[0]['status'];
        
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
        $returnArray['active_sponsors'] = $countactive;
               
        echo json_encode($returnArray);
        exit;
        
        
    }
    
    
    
    function toggleDefault($id)
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
        $sponsorInfo = array ();
		foreach ( $cursor1 as $result ) {
  		    array_push ( $sponsorInfo, $result );
		}

//echo "<pre>";
//print_r($sponsorInfo);
//echo "</pre>";     
   
        $savedvalue = $sponsorInfo[0]['default'];
        $value = 1;
        
        
        
        
        $loan_type = $sponsorInfo[0]['loan_type'];
        $newquery1 = array("loan_type"=>new MongoRegex('/^' .$loan_type.'$/i'),"default"=>1);
        $retval = $collection->findAndModify ( $newquery1, array (
											'$set' => array (
													'default' => 0,
											)
								
									), null, array (
											"sort" => array (
													"priority" => - 1
											),
											"new" => true,
											array ("safe" => true),
												
									) );
        
            
        
        
        
        
        
       
        $retval = $collection->findAndModify ( $newquery, array (
											'$set' => array (
													'default' => $value,
											)
								
									), null, array (
											"sort" => array (
													"priority" => - 1
											),
											"new" => true,
											array ("safe" => true),
												
									) );

        
        
        $returnArray=array();
        $returnArray['value'] = $value;
        $returnArray['status'] = true;
        
               
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
            
    		$sponsorsList = array ();
    		foreach ( $cursor1 as $result ) {
    		  array_push ( $sponsorsList, $result );
    		} 
            
            $newquery1 = array('status' => 1);
            $countactive = $collection-> count($newquery1);
            
            $this->set('sponsorsList',$sponsorsList); 
            $this->set('currentPage',$page);
            $this->set('active_sponsors',$countactive);
            $this->set('total_sponsors',$countrec);
        }        
    }    
    
}
?>