<?php
/**
 *
 * @author Shiv
 *        
 */
App::uses ( 'Component', 'Controller' );
App::uses ( 'UploadFileResizer', 'Custom' );

require '../Vendor/aws/aws-autoloader.php';
use Aws\S3\S3Client;
use Aws\Credentials\Credentials;



class RemoteFileUploadComponent extends Component {
	protected $options;
	protected $file;
	protected $success;
	protected $curl_info;
	protected $curl_errors;
	protected $error;
	protected $MAX_FILE_SIZE_ALLOWED_IN_BYTES;
	protected $FILE_MODE = 0644;
	protected $DIR_MODE = 0755;
	
	var $components = array (
			'Common',
			'MimeTypeUtil' 
	);
	private $Controller;
	private $error_messages = array (
			'INVALID_FILE_TYPE' => 'Filetype not allowed',
			'INVALID_URL' => 'Invalid url',
			'ERRROR' => 'Error occured. Kindly check your url',
			'MAX_SIZE_ALLOWED' => 'File is too big',
			'NOT_FOUND_URL' => 'Filetype not allowed. Please check the URL' 
	);
	private function __initializeUpload($options) {
		$this->options = $options;
		$this->file = new stdClass ();
		$this->file->url_upload_sql_no = $this->options ['url_upload_sql_no'];
		$this->file->client_role_id = $this->options ['client_role_id'];
		$this->file->tmporary_path = $this->__get_temporary_file_path();
        $this->file->uploaded_path = $this->__get_uploaded_file_path();
		$this->MAX_FILE_SIZE_ALLOWED_IN_BYTES = $this->options ['max_file_size'];
		
	}
	
    private function __get_uploaded_file_path(){
		
        $pathinfo = pathinfo($this->options['url']);

		return $this->options['upload_dir'];
	}
    
	private function __get_temporary_file_path(){
		if (!file_exists($this->options ['upload_dir'])) {
			mkdir($this->options ['upload_dir'], $this->DIR_MODE, true);
		}
		return tempnam ( $this->options ['upload_dir'], 'tmp' );
	}
	/**
	 * upload from url
	 *
	 * @param unknown $options        	
	 */
	public function upload_remote_file($options) {
		// initialize the member variables
		$this->__initializeUpload ( $options );
		try {

//echo "<prE>options";
//print_r($this->options);
//echo "</pre>";
//die;
		  
			//$this->__download_file ();
            $this->__douploading_aws($this->options['url'],$this->options['upload_dir']);
			
			if (empty ( $this->error )) {
				// first get the file name from url
				$this->file->type = $this->curl_info ["content_type"];
				$this->log ( 'Checking for : ' . $this->file->type );
				$new_file_extension = $this->MimeTypeUtil->getExtenstionForMimeType ( $this->file->type );
				$this->log ( 'Final : ' . $new_file_extension );
				//$new_file_name = $this->__get_new_file_name ( $this->options ['upload_dir'], $new_file_extension );
                
                $pathinfo = pathinfo($this->options['url']);
                $new_file_name =$pathinfo['basename'];
                
//echo "<prE>file";
//print_r($this->file);
//echo "</pre>";
//echo "<br>file name==>".$new_file_name;
//die;
                
                
                
				$this->__validate ( $new_file_name, $new_file_extension );
				if (empty ( $this->error )) {
					$this->file->name = $new_file_name;
					$this->file->path = $this->file->uploaded_path . $new_file_name;

//echo "<prE>file2";
//print_r($this->file);
//echo "</pre>";
//
//die;

					// move tmp file to new
					//rename ( $this->file->tmporary_path, $this->file->path );
					//chmod($this->file->path, $this->FILE_MODE);
					
                    
                    
					if($this->options['document_type'] == Configure::read ( 'DOCUMENT_TYPE.LOGO' ) && 0){
						//if logo then resize the file and return the thumbnail
						$file_data = array();
						$path = 'uploads/endorsements/logos';
						$file_data['tmp_name'] = $this->file->path;
						$file_data['name'] = $this->file->name;
						$uploadFileResizer = new UploadFileResizer ();
						$fdata = $uploadFileResizer->createThumb($file_data, $path);
						$this->file->name =  $fdata['name'];
						$this->file->url =  $fdata['url'];
						$this->file->thumbnailUrl = $fdata['thumbnailUrl'];
						$this->file->deleteUrl = APPLICATIONMODE . '/UploadFiles/subscriberlogo?file=' . $this->file->name;
						$this->file->size = $this->Common->byte_convert ( $this->curl_info ["size_download"] );
					}else{
						$this->file->url = $this->options ['upload_url'] . $new_file_name;
						$this->file->deleteUrl = $this->options ['upload_url'] . '?file=' . $new_file_name;
						$this->file->size = $this->Common->byte_convert ( $this->curl_info ["size_download"] );
					}
				}
			}
		} catch ( Exception $e ) {
			$this->error = $this->error_messages ['ERROR'];
		}

//echo "<prE>file";
//print_r($this->file);
//echo "</pre>";
//echo $this->file->uploaded_path;
//
//
//die;
		
		// delete temporary file if exists
		//if (file_exists ( $this->file->path )) {
//			unlink ( $this->file->path );
//		}
        
		$this->__print_output ();
	}
	
    private function __douploading_aws($url,$prefixname)
    {
        
            $bucket = "images.centralpropertyexchange.com.au";    
            $credentials = new Credentials('AKIAIWMQ6ENFPZZFY62Q', 'V3/0UnrEiz3z6OH6C9JUVIK+WuNp7Eww2NMWfUP1');
            // Instantiate the S3 client with your AWS credentials
            $s3Client = S3Client::factory(array(
                'credentials' => $credentials,
                'region' => 'ap-southeast-2',
                'version' => 'latest',
            ));
            
            $pathToFile = $url;
            $pathinfo = pathinfo($pathToFile);
 
//echo "<pre>pathinfo"; print_r($pathinfo);
//echo $prefixname;
//exit;
            
            $imagecontent =$this-> __download_file_aws($pathToFile);
            $result = null;
            try {
                $result = $s3Client->putObject(array(
                    'Bucket' => $bucket,
                        'Key'    => $prefixname.$pathinfo['basename'],
                        'Body'   => $imagecontent
                ));
            } catch (S3Exception $e) {
                //print_r($e->getMessage());
                $result['error'] = "Process Field";
                $result['response'] = $e->getMessage();
            }
//echo "<pre>res"; print_r($result);        
//die;

        return $result;
    }
    
    private function __download_file_aws($imagepath)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch,CURLOPT_URL, $imagepath);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        $result=curl_exec($ch);
        
        $this->curl_info = curl_getinfo ( $ch );
        
        curl_close($ch);
        
        return $result;
    }   
    
	/**
	 * Download the file using curl.
	 * set the success and error and info in the member variable for later reference
	 */
	private function __download_file() {
		$url = str_replace ( " ", "%20", $this->options ['url'] );
		
		$fp = fopen ( $this->file->tmporary_path, "w" );
		$ch = curl_init ( $url );
		// curl_setopt ( $ch, CURLOPT_NOPROGRESS, true );
		curl_setopt ( $ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1 );
		curl_setopt ( $ch, CURLOPT_SSL_CIPHER_LIST, 'SSLv3' );
		// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
		// curl_setopt($ch, CURLOPT_HEADERFUNCTION, 'read_header');
		// curl_setopt ( $ch, CURLOPT_PROGRESSFUNCTION, 'curl_progress_callback');
		curl_setopt ( $ch, CURLOPT_FILE, $fp );
		$this->success = curl_exec ( $ch );
		$this->curl_info = curl_getinfo ( $ch );
		$this->curl_errors = curl_error ( $ch );
		curl_close ( $ch );
		fclose ( $fp );
		$this->__set_curl_errors ();
	}
	
	/**
	 * prints the output
	 */
	private function __print_output() {
		if (! empty ( $this->error )) {
			$this->file->error = $this->error;
		}
		$json = json_encode ( array (
				$this->file 
		) );
		echo $json;
	}
	
	/**
	 * set the errors got in curl call
	 */
	private function __set_curl_errors() {
		if (! $this->success) {
			
			$err = error_get_last ();
			if (! empty ( $this->curl_errors )) {
				$err = array (
						"message" => $this->curl_errors 
				);
			}
			if (! $err) {
				$err = array (
						"message" => $this->error_messages ['INVALID_URL'] 
				);
			}
			$this->error = $err ["message"];
		}
	}
	
	/**
	 * check if type of file is allowed to download.if not set the error message
	 *
	 * @param unknown $ext        	
	 */
	private function __validate($file_name, $ext) {
		if (empty ( $this->error )) {
			$type_allowed = preg_match ( $this->options ['accept_file_types'], $file_name );
			if ($type_allowed != 1) {
				//$this->log($ext);
				if ($ext == 'html') {
					$this->error = $this->error_messages ['NOT_FOUND_URL'];
				} else {
					$this->error = $this->error_messages ['INVALID_FILE_TYPE'];
				}
			}
		}
		if (empty ( $this->error )) {
			$this->log('Allowed: ' . $this->MAX_FILE_SIZE_ALLOWED_IN_BYTES . ' received: ' . $this->curl_info ["size_download"]);
			if ($this->MAX_FILE_SIZE_ALLOWED_IN_BYTES < $this->curl_info ["size_download"]) {
				$this->error = $this->error_messages ['MAX_SIZE_ALLOWED'];
			}
		}
		
		if (empty ( $this->error )) {
			
			if (empty ( $this->file->type )) {
				$this->error = $this->error_messages ['INVALID_FILE_TYPE'];
			}
		}
	}
	/**
	 * This file will give a new filename with specified extension
	 *
	 * @param unknown $path        	
	 * @param unknown $ext        	
	 */
	private function __get_new_file_name($path, $ext) {
		$file_name = 'file' . $this->__get_fixed_length_random_number ( 5 ) . '.' . $ext;
		return $this->__file_newname ( $path, $file_name );
	}
	/**
	 * Returns fixed length random string with numbers only
	 *
	 * @param unknown $length        	
	 * @return Ambigous <string, number>
	 */
	private function __get_fixed_length_random_number($length) {
		$result = '';
		
		for($i = 0; $i < $length; $i ++) {
			$result .= mt_rand ( 0, 9 );
		}
		
		return $result;
	}
	/**
	 * This function will give a unique file name in mentioned dir
	 *
	 * @param unknown $path        	
	 * @param unknown $filename        	
	 * @return Ambigous <string, unknown>
	 */
	private function __file_newname($path, $filename) {
		if ($pos = strrpos ( $filename, '.' )) {
			$name = substr ( $filename, 0, $pos );
			$ext = substr ( $filename, $pos );
		} else {
			$name = $filename;
		}
		
		$newpath = $path . '/' . $filename;
		$newname = $filename;
		$counter = 0;
		while ( file_exists ( $newpath ) ) {
			$newname = $name . '_' . $counter . $ext;
			$newpath = $path . '/' . $newname;
			$counter ++;
		}
		
		return $newname;
	}
}
//if (! Validation::url ( $this->options ['url'] )) {
	// 			// $this->error = 'Invalid url. Please enter valid url starting with http://';
	// 		}
// function read_header($ch, $header)
// {
// 	global $responseHeaders;
// 	$url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
// 	$responseHeaders[$url][] = $header;
// 	//pr($responseHeaders);
// 	return strlen($header);
// }