<?php 
//error_reporting(E_ALL);
require '../Vendor/aws/aws-autoloader.php';
use Aws\S3\S3Client;
use Aws\Credentials\Credentials;
class UploadimageController extends AppController {
    





    
    
    function process($id)
    {
        $response = array();
        
        if($this->isImage($_POST['imageURL']))
        {
            if( $result=$this->douploading($_POST['imageURL'],$_POST['id']))
                {
                    
                    $response['status'] = true;
                    $response['originalurl'] = $_POST['imageURL'];
                    $response['newurl'] = $result['ObjectURL'];
                   
                   
                }
                else
                {
                    $response['status'] = false;
                    $response['originalurl'] = $_POST['imageURL'];
                    
                }          
        }else
        {
            $response['status'] = false;
            $response['originalurl'] = $_POST['imageURL'];
        }
        
        
        
        
        echo json_encode($response);
        
        
        //echo "in";exit;
        exit;
    }
    
    
    function douploading($url,$prefixname)
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
            //echo "<pre>"; print_r($pathinfo);exit;
            
            $imagecontent =$this-> DownloadImageFromUrl($pathToFile);
            $result = null;
            try {
                $result = $s3Client->putObject(array(
                    'Bucket' => $bucket,
                        'Key'    => $prefixname.'/images/'.$pathinfo['basename'],
                        'Body'   => $imagecontent
                ));
            } catch (S3Exception $e) {
                //print_r($e->getMessage());
                $result['error'] = "Process Field";
                $result['response'] = $e->getMessage();
            }
        
        return $result;
    }
    
    function isImage($url){
		
		$info = get_headers($url ,1 );
        if (strpos($info['Content-Type'], 'image/') === FALSE) {
            return 0;
          }else
          {
            	return 1;
          }
		
	}
    
    
    
    function DownloadImageFromUrl($imagepath)
    {
        

        
        
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch,CURLOPT_URL, $imagepath);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        $result=curl_exec($ch);


        
        curl_close($ch);
        
        return $result;
    }   
    
   
    
}
?>