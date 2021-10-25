<?php
/**
 * This controller is used to upload the files 
 * @author Shivprasad Dhakane
 */
//App::uses ( 'AppController', 'Controller' );
App::uses ( 'CustomUploadHandler', 'Custom' );
class UploadFilesController extends AppController {
	public $name = "UploadFiles";
	public $components = array (
			'RemoteFileUpload' 
	);
	private $MAX_FILE_SIZE_ALLOWED_IN_BYTES;
	public function beforeFilter() {
		$this->MAX_FILE_SIZE_ALLOWED_IN_BYTES = 1024 * 1024 * 5; // 5 MB
	}
	/**
	 * action for drag drop file upload from admin screen
	 */
	public function index() {
		
		$this->layout = 'ajax';
		$isAdmin = true; 
		$this->__common_file_uploader ( $this->request->data, $isAdmin );
		$this->render ( '/Layouts/admin_ajax' );
	}
	/**
	 * Common function for drag drop file upload
	 */
	private function __common_file_uploader(&$data, $isAdmin) {
		$sub_folder_path = isset ( $data ['sub_folder_path'] ) ? $data ['sub_folder_path'] : '';
		$document_type = isset ( $data ['document_type'] ) ? $data ['document_type'] : '';
		$script_url = $isAdmin ? '/admin/UploadFiles' :  '/UploadFiles';
		$script_url = isset ( $data ['script_url'] ) ? $data ['script_url'] : $script_url;
		
		$upload_dir = $this->__getUploadDirPath ( $sub_folder_path );
		// by default we accept only images
		$accept_file_types = $this->__getAcceptedDocumentTypes ( $document_type );
		$subscriberAgr = ($sub_folder_path == Configure::read('SUB_FOLDER.AGREEMENTS')) ? 'schedules_agreement' : '';
		
        
        
		$options = array (
				'upload_dir' => $upload_dir,
				'accept_file_types' => $accept_file_types,
				'upload_url' => $upload_dir,
				// 'delete_type' => 'POST',
				'script_url' => $script_url,
				'max_file_size' => $this->MAX_FILE_SIZE_ALLOWED_IN_BYTES,
				'image_versions' => array (), /*blank array here will disable thumbnail generation*/
				'document_type'=>$document_type,
				'subscriberAgr'=>$subscriberAgr
				
		);
        if(isset($data['contract_of_sale']))
                $options['contract_of_sale'] =$data['contract_of_sale']; 
        
        
      //  echo "<pre>"; print_r($options); echo "</pre>";
        
		if (isset ( $this->request->data ['tmpClientRoleID'] ) && ! empty ( $this->request->data ['tmpClientRoleID'] )) {
			$extra_options = array (
					'client_role_id' => $this->request->data ['tmpClientRoleID'] 
			);
			$options = array_merge ( $options, $extra_options );
		}
		//$this->log($this->request->data,LOG_DEBUG);
        
		$upload_handler = new CustomUploadHandler ( $options );
       // exit;
	}
	
	public function remote_file_upload() {
		
		$this->layout = 'ajax';
		$isAdmin = true;
		$this->__common_remote_file_upload ();
		$this->render ( '/Layouts/admin_ajax' );
	}
	/**
	 * common function for url file upload
	 */
	private function __common_remote_file_upload() {
		$url = $this->request->query ['url'];
		
		$sub_folder_path = $this->request->query ['sub_folder_path'];
		$document_type = isset ( $this->request->query ['document_type'] ) ? $this->request->query ['document_type'] : '';
		$url_upload_sql_no = isset ( $this->request->query ['url_upload_sql_no'] ) ? $this->request->query ['url_upload_sql_no'] : '';
		$client_role_id = isset ( $this->request->query ['client_role_id'] ) ? $this->request->query ['client_role_id'] : '';
		
		$upload_dir = $this->__getUploadDirPath ( $sub_folder_path );
		// by default we accept only images
		$accept_file_types = $this->__getAcceptedDocumentTypes ( $document_type );
		
		$options = array (
				'url' => $url,
				'upload_dir' => $upload_dir,
				'accept_file_types' => $accept_file_types,
				'upload_url' => $upload_dir,
				'client_role_id' => $client_role_id,
				'url_upload_sql_no' => $url_upload_sql_no,
				'max_file_size' => $this->MAX_FILE_SIZE_ALLOWED_IN_BYTES ,
				'document_type'=>$document_type
		);
        
        if(isset($data['contract_of_sale']))
                $options['contract_of_sale'] =$data['contract_of_sale']; 
        
		$this->RemoteFileUpload->upload_remote_file ( $options );
	}

	
	
	
	/**
	 * return accepted file types based on document type
	 *
	 * @param unknown $document_type        	
	 * @return string
	 */
	private function __getAcceptedDocumentTypes($document_type) {
		$accept_file_types = '/\.(gif|jpe?g|png|ico)$/i';
		if ($document_type == Configure::read ( 'DOCUMENT_TYPE.AGREEMENT' ) || $document_type == Configure::read ( 'DOCUMENT_TYPE.ANNEXURE' ) || $document_type == Configure::read ( 'DOCUMENT_TYPE.FORM' )) {
			$accept_file_types = '/\.(gif|jpe?g|png|docx?|pdf|rtf|txt|xlsx?)$/i';
		}
		return $accept_file_types;
	}
	/**
	 * return upload directory path
	 *
	 * @param unknown $sub_folder_path        	
	 * @return string
	 */
	private function __getUploadDirPath($sub_folder_path) {
		$upload_dir = 'uploads/';
		if (! empty ( $sub_folder_path )) {
			$upload_dir .= $sub_folder_path . '/';
		}
		return $upload_dir;
	}
}
?>