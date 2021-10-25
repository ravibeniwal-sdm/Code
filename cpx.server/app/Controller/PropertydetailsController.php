<?php
class PropertydetailsController extends AppController {
	public $helpers = array('Html', 'Form');
	public $components = array('RequestHandler');



	     public function index() {
	     	$iddata =  $this->params['url']['id'];
	     	if(!empty($this->params['url']['img']) && !empty($this->params['url']['name']) && !empty($this->params['url']['type'])){
	     		$imgdata = $this->params['url']['img'];
	     		$namedata = $this->params['url']['name'];
	     		$typedata = $this->params['url']['type'];
	     		$detaildata = array('img'=>$imgdata,
	     							'name'=>$namedata,
	     							'type'=>$typedata);
	     		$this->set ( 'detaildata', $detaildata );
	     		
	     		
	     		print_r($detaildata);
	     	}else{
	     		$this->redirect('/../#!/details/'.$iddata);
	     	}
	     }


	
}
?>