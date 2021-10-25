<?php
class BlogshareController extends AppController {
	public $helpers = array('Html', 'Form');
	public $components = array('RequestHandler');



	     public function index() {
	     	$blogtypedata =  $this->params['url']['blogtype'];
	     	$subid =  $this->params['url']['subid'];
	     	if(!empty($this->params['url']['img']) && !empty($this->params['url']['name'])){
	     		$imgdata = $this->params['url']['img'];
	     		$namedata = $this->params['url']['name'];
	     		
	     		$detaildata = array('img'=>$imgdata,
	     							'name'=>$namedata);
	     							
	     		$this->set ( 'detaildata', $detaildata );
	     	}else{
	     		//$this->redirect('/../#!/blog/'.$blogtypedata.'/'.$subid);
	     		
	     		$this->redirect('http://staging.centralpropertyexchange.com.au/#!/blog/press-releases/amended-act');
	     	}
	     }


	
}
?>
