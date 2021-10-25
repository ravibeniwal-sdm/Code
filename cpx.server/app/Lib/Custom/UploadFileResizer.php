<?php 

class UploadFileResizer{
	
public function createThumb($file_data, $path) {
		$this->autoRender = false;
		//pr($file_data);
		
		$inputFileName = $file_data['tmp_name'];
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
		imagealphablending( $thumb, false );
		imagesavealpha( $thumb, true );
		if ($sourceImage === false) {
			return false;
		}
	
	
		imagecopyresampled($thumb, $sourceImage, 0, 0, 0, 0, $tWidth, $tHeight, $width, $height);
		
		imagedestroy($sourceImage);
	
		$file_name = uniqid() . $file_data["name"];
		move_uploaded_file($file_data['tmp_name'], $path . "/" . $file_name);
		
		
		$set_path = $path . "/thumb/" . $file_name;
		
		$finalObj = array();
		if ($this->phototofolder($thumb, $set_path)) {
			$finalObj['name'] =  $file_name;
			$finalObj['url'] =  $set_path;
			$finalObj['thumbnailUrl'] = $set_path;
		}
		
		return $finalObj;
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
	
	
}
?>
