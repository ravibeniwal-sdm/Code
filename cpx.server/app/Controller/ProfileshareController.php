<?php
class ProfileshareController extends AppController {
	public $helpers = array('Html', 'Form');
	public $components = array('RequestHandler');



	     public function index() {
	     	$profileid = $this->params['url']['profileid'];
			
			if(!empty($this->params['url']['img']) && !empty($this->params['url']['name'])){
	     		
	     		$imgdata = $this->params['url']['img'];
	     		$namedata = $this->params['url']['name'];
	     		
	     		$detaildata = array('img'=>$imgdata,
	     							'name'=>$namedata);
	     							
	     		$this->set ( 'detaildata', $detaildata );
	     	}else{
	     		$this->redirect('/../#!/public-speaking-profiles/'.$profileid);
	     	}
	     }


	
}
?>
