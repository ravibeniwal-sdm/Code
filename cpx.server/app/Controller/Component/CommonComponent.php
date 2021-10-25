<?php

/**
 * Custom component
 *
 * PHP 5
 *
 * Created By         :Amit Gupta
 * Date Of Creation   : Nov  22 2013
 * 
 */
App::uses('Component', 'Controller');

/**
 * Custom component
 */
class CommonComponent extends Component {

    var $components = array('Cookie', 'Session', 'Upload', 'Easyphpthumbnail');

    /*
     * Function to generate the random password
     */

    public function getRandPass() {

        // Array Declaration
        $pass = array();

        // Variable declaration
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    /**
     * Upload Image as Original and Thumb 
     * @author       Amit Gupta
     * @copyright     smartData Enterprise Inc.
     * @method        image_upload
     * @param         $file, $path, $thumb_height, $thumb_width
     * @return        $filename or $err_type
     * @since         version 0.0.1
     * @version       0.0.1 
     */
    public function image_upload($file, $path, $thumb_height, $thumb_width) {

        // Variable containing File type
        $extType = $file['type'];
        // Variable containing extension in lowercase 
        $ext = strtolower($extType);
        // Condition checking File extension
        if ($ext == 'image/jpg' || $ext == 'image/png' || $ext == 'image/jpeg' || $ext == 'image/gif') {
            // Condition checking File size
            if ($file['size'] <= 10485760) {
                // Filename 
                $filename = time() . '_' . $file['name'];
                // Folder path
                $folder_url = WWW_ROOT . $path;
                $filename = $this->createThumb($file, $path);
                return $filename;
                // Condition checking File exist or not 
                //if (!file_exists($folder_url.'/'.$filename)){                   
                //    // create full filename
                //    $full_url = $folder_url.'/'.$filename;	
                //    // upload the file                    
                //    $success = move_uploaded_file($file['tmp_name'], $full_url);                
                //    // thumb image
                //    $dircover = str_replace(chr(92),chr(47),getcwd()).'/'.$path.'/'.$filename;
                //    $this->Easyphpthumbnail-> Thumblocation = str_replace(chr(92),chr(47),getcwd()).'/'.$path.'/thumb/';                    
                //    $this->Easyphpthumbnail-> Thumbheight = $thumb_height;
                //    $this->Easyphpthumbnail-> Thumbwidth =  $thumb_width;
                //    $this->Easyphpthumbnail-> Createthumb($dircover,'file');                     
                //    return $filename;
                //}else{
                //    return 'exist_error';
                //}
            } else {
                return 'size_mb_error';
            }
        } else if ($ext == 'application/pdf' || $ext == 'application/msword' || $ext == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
            // Filename 
            $filename = time() . '_' . $file['name'];
            // Folder path
            $folder_url = WWW_ROOT . $path;
            // Condition checking File exist or not 
            // create full filename
            $full_url = $folder_url . '/' . $filename;
            // upload the file                
            $success = move_uploaded_file($file['tmp_name'], $full_url);
            return $filename;
        } else {
            return 'type_error';
        }
    }

    /**
     * Handle image errors
     * @author       Amit Gupta
     * @copyright     smartData Enterprise Inc.
     * @method        is_image_error
     * @param         $image_name
     * @return        error msg
     * @since         version 0.0.1
     * @version       0.0.1 
     */
    public function is_image_error($image_name) {
        $errmsg = '';
        switch ($image_name) {
            case 'exist_error':
                $errmsg = 'File already exist.';
                break;

            case 'size_mb_error':
                $errmsg = 'Only mb of file is allowed to upload.';
                break;

            case 'type_error':
                $errmsg = 'Only JPG, JPEG, PNG, GIF, PDF, DOC & XML are allowed.';
                break;
        }
        return $errmsg;
    }

    /**
     * Delete image
     * @author       Amit Gupta
     * @copyright     smartData Enterprise Inc.
     * @method        delete_image
     * @param         $image_name, $path
     * @return        void
     * @since         version 0.0.1
     * @version       0.0.1 
     */
    public function delete_image($image_name, $path) {
        $full_path = WWW_ROOT . $path . '/' . $image_name;
        if (file_exists($full_path)) {
            unlink($full_path);
        }
    }

    public function phototofolder($im, $fileName, $quality = 80) {

        $this->autoRender = false;
        if (!$im || file_exists($fileName)) {
            return false;
        }

        $ext = strtolower(substr($fileName, strrpos($fileName, '.')));

        switch ($ext) {
            case '.gif':
                imagegif($im, $fileName);
                break;
            case '.jpg':
            case '.jpeg':
                imagejpeg($im, $fileName, $quality);
                break;
            case '.png':
                imagepng($im, $fileName);
                break;
            case '.bmp':
                imagewbmp($im, $fileName);
                break;
            default:
                return false;
        }

        return true;
    }

    public function createThumb($file_data, $path) {
        $this->autoRender = false;
//pr($file_data);

        $inputFileName = $file_data["tmp_name"];
        $maxSize = 90;
        //echo $width . "x" . $height;

        $info = getimagesize($inputFileName);

        $type = isset($info['type']) ? $info['type'] : $info[2];


        if (!(imagetypes() & $type)) {

            return false;
        }

        $width = isset($info['width']) ? $info['width'] : $info[0];
        $height = isset($info['height']) ? $info['height'] : $info[1];


      
        /*
         * ####################################################
         * New logic for target image size of company logo
         * ####################################################
         */
        
        $max_img_size = 300;
        $min_img_size = 90;
        
        //find out current width to height ratio and allowed width to height ratio 
        $current_WH_ratio = round(($width/$height)*1000);
        $allowed_WH_ratio = round(($max_img_size/$min_img_size)*1000);
        
        //default the new height and width to actual image size.
        $new_width = $width;
        $new_height = $height;
        
        
    	if($width>$height){
    		//case when height is more that width
			if(($current_WH_ratio < $allowed_WH_ratio) && $height>$min_img_size){
				/*
				 * if image wh ratio is less than allowed and height is more than min allowed, 
				 * then we need to set the height and recalculate width
				 */
				$new_height = $min_img_size;
				$new_width = floor($width*$min_img_size/$height);
			}else if(($current_WH_ratio > $allowed_WH_ratio) && $width>$max_img_size){
			
				$new_width=$max_img_size;
				$new_height = floor($height*$max_img_size/$width);
			}
		} else if($height>$width){
			$allowed_WH_ratio=round(($min_img_size/$max_img_size)*1000);
			if(($current_WH_ratio < $allowed_WH_ratio) && $height>$max_img_size){
				
				$new_height = $max_img_size;
				$new_width = floor($width*$max_img_size/$height);
			}else if(($current_WH_ratio > $allowed_WH_ratio) && $width>$min_img_size){
			
				$new_width = $min_img_size;
				$new_height = floor($height*$min_img_size/$width);
			}
		} else if ( ($height==$width) && ($height > $min_img_size)){
			$new_width=$min_img_size;
			$new_height = $min_img_size;
		}
		
		$tWidth = $new_width;
		$tHeight = $new_height;
		
		/*
		 * ####################################################
		* END :: New logic for target image size of company logo
		* ####################################################
		*/
		


        $sourceImage = imagecreatefromstring(file_get_contents($inputFileName));


        $tWidth = floor($tWidth);
        $tHeight = floor($tHeight);
//echo $tWidth."X".$tHeight;die;
        $thumb = imagecreatetruecolor($tWidth, $tHeight);

        if ($sourceImage === false) {

            return false;
        }


        imagecopyresampled($thumb, $sourceImage, 0, 0, 0, 0, $tWidth, $tHeight, $width, $height);
        imagedestroy($sourceImage);

        $file_name = uniqid() . $file_data["name"];
        move_uploaded_file($file_data['tmp_name'], $path . "/" . $file_name);

        $set_path = $path . "/thumb/" . $file_name;
        if ($this->phototofolder($thumb, $set_path)) {
            return $file_name;
        }

        /* $this->loadModel('TransactionSetting');
          $adminTransactionArr=$this->TransactionSetting->find("all",array("conditions"=>array('user_id'=>0)));
          $admin_Arr=array();
          foreach ($adminTransactionArr as $apval)
          {

          }
         * */
    }

    function getDisbursedSubscriber($id = null) {
        App::import('Model', 'User');
        $this->User = new User();
        //echo $id;
        $arrRet = array();
        if ($id != '') {
            $data = $this->User->find('first', array('conditions' => array('User.id' => $id)));
            if (!empty($data)) {
                if (!empty($data)) {

                    $arrRet["subscription_id"] = $data["User"]["subscription_id"];
                    $arrRet["company_name"] = $data["SubscriberCompany"]["company_name"];
                }
            }
        }
        return $arrRet;
    }

    function getCompanyName($subId) {
        App::import('Model', 'User');
        $this->User = new User();
        $data = $this->User->find('first', array('conditions' => array('User.subscription_id' => $subId), 'fields' => array('SubscriberCompany.company_name')));
        $companyName = $data['SubscriberCompany']['company_name'];
        return $companyName;
    }
    
    function getReferenceNo($refId) {
        App::import('Model', 'Transaction');
        $this->Transaction = new Transaction();
        $data = $this->Transaction->find('first', array('conditions' => array('internal_reference_number' => $refId,'type'=>Configure::read('TRANSACTION_TYPE.T')), 'fields' => array('Client.subscription_id')));        
        if(isset($data['Client']['subscription_id']) && $data['Client']['subscription_id']<>''){
            $subId = $data['Client']['subscription_id'];
        }else{
            $subId='N/A';
        }
        return $subId;
    }
    
    function getCompanyBasicInfor($subscriberId) {        
        App::import('Model', 'User');
        $this->User = new User();
        $data = $this->User->find('first', array('conditions' => array('User.subscription_id' => $subscriberId), 'fields' => array('SubscriberCompany.website','SubscriberCompany.logo')));               
        return $data;
    }
    
     function transactionHeading($preText) {
        if($preText==Configure::read('TRANSACTION_TYPE.T')){
            return 'Transaction number';
        }elseif($preText==Configure::read('TRANSACTION_TYPE.R')){
            return 'Trust account receipt';
        }elseif($preText==Configure::read('TRANSACTION_TYPE.D')){
            return 'Disbursement receipt';
        }
    }
    
    function getSubscriberCompanyName($subId) {
        App::import('Model', 'SubscriberCompany');
        $this->SubscriberCompany = new SubscriberCompany();
        $data = $this->SubscriberCompany->find('first', array('conditions' => array('user_id' => $subId), 'fields' => array('SubscriberCompany.company_name')));
        if(!empty($data)){
            $compName = $data['SubscriberCompany']['company_name'];
        }else{
             $compName = 'N/A';
        }       
       
        return $compName;
    }

    function generateUniqueCode($length = 8) {
    	$az = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    	$azr = rand(0, 51);
    	$azs = substr($az, $azr, 10);
    	$stamp = hash('sha256', time());
    	$mt = hash('sha256', mt_rand(5, 20));
    	$alpha = hash('sha256', $azs);
    	$hash = str_shuffle($stamp . $mt . $alpha);
    	$code = strtoupper(substr($hash, $azr, $length));
    	return $code;
    }
    
    /**
     * This function encrypts data using AES (128 block size) and encode it to base64 so it can be represented as string
     * java equivalent for this is AES/CFB8/NoPadding
     * @param unknown $message
     * @param unknown $initialVector
     * @param unknown $secretKey
     * @return string
     */
    function encrypt($message, $initialVector, $secretKey) {
    	return base64_encode(
    			mcrypt_encrypt(
    					MCRYPT_RIJNDAEL_128,
    					$secretKey,
    					$message,
    					MCRYPT_MODE_CFB,
    					$initialVector
    			)
    	);
    }
    function decrypt($data, $initialVector, $secretKey) {
    	return mcrypt_decrypt(
    			MCRYPT_RIJNDAEL_128,
    			$secretKey,
    			base64_decode($data),
    			MCRYPT_MODE_CFB,
    			$initialVector
    	);
    }
    
    /**
     * Byte Convert
     * Convert file size into byte, kb, mb, gb and tb
     * @param int $size
     * @return string
     */
    function byte_convert($size) {
    	$size = empty($size)? 0 : $size;
    	# size smaller then 1kb
    	if ($size < 1024) return $size . ' Byte';
    	# size smaller then 1mb
    	if ($size < 1048576) return sprintf("%4.2f KB", $size/1024);
    	# size smaller then 1gb
    	if ($size < 1073741824) return sprintf("%4.2f MB", $size/1048576);
    	# size smaller then 1tb
    	if ($size < 1099511627776) return sprintf("%4.2f GB", $size/1073741824);
    	# size larger then 1tb
    	else return sprintf("%4.2f TB", $size/1073741824);
    }
    function get_string($string, $start, $end){
    	$string = " ".$string;
    	$pos = strpos($string,$start);
    	if ($pos == 0) return "";
    	$pos += strlen($start);
    	$len = strpos($string,$end,$pos) - $pos;
    	return substr($string,$pos,$len);
    }
}
