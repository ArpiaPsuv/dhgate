<?php
class App_Image  {
	public $uploadPath = '/application/public/images/';
	protected $_fullPath;
	public $prefixs  = array('s' => array(100,100),'vs'=>array(70,70), 'm'=>array(200,200), 'l'=>array(1024,768));
	public $file;

	public function __construct()
	{
		$this->_fullPath = $_SERVER['DOCUMENT_ROOT'] . $this->uploadPath;
	}

	public function setUploadPath($path)
	{
		$this->uploadPath = $path;
		$this->_fullPath = $_SERVER['DOCUMENT_ROOT']. $this->uploadPath;
		return $this->uploadPath;
	}

	public function setPrefixs($prefixs)
	{
		$this->prefixs = $prefixs;
		return  $this->prefixs;
	}

	public function upload()
	{
		if($_FILES){
			$uploadfile =  time() . '.jpeg';
			$this->file = $this->_fullPath . $uploadfile;
			if($_FILES['file']['type'] == 'image/jpeg'){
				if (move_uploaded_file($_FILES['file']['tmp_name'], $this->_fullPath . $uploadfile)) {
					foreach($this->prefixs as $prefix => $size)
					{
						if(!file_exists($this->_fullPath.$prefix.'/'))
						{
							mkdir($this->_fullPath.$prefix.'/');
						}
						$this->resizeimg($this->_fullPath . $uploadfile, $this->_fullPath. $prefix . '/'. $uploadfile,$size[0],$size[1],95);
					}
					return true;
				}  else {
					return false;
				}
			} else {
				return false;
			}
		}
	}
	public  function resizeimg($image,$smallimage, $w, $h,$q)
	{
	/*	$ratio = $w/$h;
		$filename=$image;
		$size_img = getimagesize($filename);
		if (($size_img[0]<$w) && ($size_img[1]<$h)) {copy($filename, $smallimage); return true;  }
						
		$src_ratio=$size_img[0]/$size_img[1];
		if ($ratio>$src_ratio){
			$h = $w/$src_ratio;
		}
		else{
			$w = $h*$src_ratio;
		}
		$dest_img = imagecreatetruecolor($w, $h);
		$white = imagecolorallocate($dest_img, 255, 255, 255);
		if ($size_img[2]==2) {
			$src_img = imagecreatefromjpeg($filename);  }


			else if ($size_img[2]==1) $src_img = imagecreatefromgif($filename);
			else if ($size_img[2]==3) $src_img = imagecreatefrompng($filename);
			imagecopyresampled($dest_img, $src_img, 0, 0, 0, 0, $w, $h, $size_img[0], $size_img[1]);

			if ($size_img[2]==2)
			imagejpeg($dest_img, $smallimage, $q);
			else if ($size_img[2]==1) imagegif($dest_img, $smallimage);
			else if ($size_img[2]==3) imagepng($dest_img, $smallimage);
			imagedestroy($dest_img);
			imagedestroy($src_img);
			return true;*/
		$filename=$image;
		$size_img = getimagesize($filename);
			if ($size_img[2]==2) {
				$src_img = imagecreatefromjpeg($filename);  
			}
			else if ($size_img[2]==1)
			$src_img = imagecreatefromgif($filename);
			else if ($size_img[2]==3) 
			$src_img = imagecreatefrompng($filename);
		
		
		$dest_img = imagecreatetruecolor($w, $h);
		
		
		
		//$src_ratio=$size_img[0]/$size_img[1];
		$white = imagecolorallocate($dest_img, 255, 255, 255);
		imagefill ( $dest_img, 0, 0, $white );
		
		if($size_img[0]!=$size_img[1]){
			if($size_img[0] > $size_img[1]){
				$ratio =$size_img[0]/$w;
				$t_w=$size_img[0]/$ratio;
				$t_h=$size_img[1]/$ratio;
				$tmp_image=imagecreatetruecolor($t_w, $t_h);
				$y=$h/2-$t_h/2;
				imagecopyresampled($tmp_image, $src_img, 0, 0, 0, 0, $t_w, $t_h, $size_img[0], $size_img[1]);
				imagecopyresampled($dest_img, $tmp_image, 0, $y, 0, 0, $t_w, $t_h, $t_w,$t_h);
			}else{
				$ratio =$size_img[1]/$h;
				$t_w=$size_img[0]/$ratio;
				$t_h=$size_img[1]/$ratio;
				$tmp_image=imagecreatetruecolor($t_w, $t_h);
				$x=$w/2-$t_w/2;
				imagecopyresampled($tmp_image, $src_img, 0, 0, 0, 0, $t_w, $t_h, $size_img[0], $size_img[1]);
				imagecopyresampled($dest_img, $tmp_image, $x, 0, 0, 0, $t_w, $t_h, $t_w,$t_h);
			}
		}else{
			imagecopyresampled($dest_img, $src_img, 0, 0, 0, 0, $w, $h, $size_img[0], $size_img[1]);
		}
	
		imagejpeg($dest_img, $smallimage, $q);
		imagedestroy($dest_img);
		imagedestroy($src_img);
		imagedestroy($tmp_image);
		return true;
	}
	
	public function writeText($text,$text_color,$bezel_color,$font_name,$font_size,$image_from_file,$path_to,$x = 0,$y = 0)
	{
		
		$image_to_file_name= 'index.png';
		$image_to_file= $path_to.$image_to_file_name;
		
		@unlink($image_to_file);
		copy($image_from_file, $image_to_file);
		$size = getimagesize($image_to_file);
	
		if ($size[2]==1) {
			$res = imagecreatefromgif($image_to_file);
		}		
		if ($size[2]==2) {
			$res = imagecreatefromjpeg($image_to_file);  
		}
		if ($size[2]==3) {
			$res = imagecreatefrompng($image_to_file);
		}
		
		
		
		
		$font_path=$_SERVER['DOCUMENT_ROOT'].'/application/public/fonts/';
		$font_file=$font_path.$font_name;
		
		
		// создаем окантовочку
		$y+=$font_size;
	
		$image= imagecreatetruecolor($size[0],$size[1]);
		imagecopy($image,$res,0,0,0,0,$size[0],$size[1]);
		

//		//imagecolortransparent($image,$black);
//		
		imagettftext($image,$font_size,0,$x,$y - 1,$bezel_color,$font_file,$text);
		imagettftext($image,$font_size,0,$x - 1,$y,$bezel_color,$font_file,$text);
		imagettftext($image,$font_size,0,$x,$y + 1,$bezel_color,$font_file,$text);
		imagettftext($image,$font_size,0,$x + 1,$y,$bezel_color,$font_file,$text);
		
		// "рисуем" сам текст
		imagettftext($image,$font_size,0,$x,$y,$text_color,$font_file,$text);
		
		

			imagepng($image, $image_to_file);

		imagedestroy($image);
		imagedestroy($res);
		return true;
		
	}
	
}
?>