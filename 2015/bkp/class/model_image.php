<?php
require_once('model.php');
/*
	* static is used to access constant and static content
	** constant and static content is not visible when used get_object_vars($this)
*/

class Model_Image extends Model {

	const IMG_SIZE    = '0x0';
	const HAS_THUMB   = false;
	const HAS_CROP    = false;
	const THUMB_SIZE  = '0x0';

	// array of image fields
	protected $images = array('imagem' => '');

	protected static $path = '';

	public function gravar(){
		parent::gravar();

		if (is_array($this->images)){
			$class = get_class($this);
			$path = call_user_func(array($class,'path'));
			$table = constant("$class::TABLE");

			$keys = array_keys($this->images);
			$img_ext = array('jpg','jpeg','png','gif');

			foreach ($keys as $key){
				if (isset($_FILES[$key]) && is_uploaded_file($_FILES[$key]['tmp_name'])){

					$size = constant("$class::IMG_SIZE");
					$crop = constant("$class::HAS_CROP");
					$thumb = constant("$class::HAS_THUMB");
					$tsize = constant("$class::THUMB_SIZE");

					$filename = $_FILES[$key]['name'];
					$aux = explode('.',$filename);
					$ext = array_pop($aux);
					$ext = strtolower($ext);

					if (!in_array($ext,$img_ext)){
						throw new Exception("O arquivo $filename não é uma extensão de imagem válida!");
					}

					$img = $this->images[$key];
					if (is_file($path.$img)){
						unlink($path.$img);
					}
					if ($thumb){
						if (is_file($path.'thm_'.$img)){
							unlink($path.'thm_'.$img);
						}
					}
					$filename = Functions::corrigeNome($filename);

					$file = $this->id.'_'.$filename;

					if (is_file($path.$file)){
						$i = 1;
						$file = $this->id.'_'.$i.'_'.$filename;
						while (is_file($path.$file)){
							$file = $this->id.'_'.(++$i).'_'.$filename;
						}
					}
					$this->images[$key] = $file;
					move_uploaded_file($_FILES[$key]['tmp_name'],$path.$file);

					self::$db->update($table,array($key => $file),array('id' => $this->id));
					if ($size != '0x0'){
						$this->resize($file, $crop, $size);
					}
					if ($thumb && $tsize != '0x0'){
						$this->resize($file, false, $tsize, 'thm_');
					}
				} else {
					self::$db->update($table,array($key => $this->images[$key]),array('id' => $this->id));
				}
			}
		}
		return true;
	}

	public function excluir(){
		if (!!$this->id){
			$class = get_class($this);
			$path = call_user_func(array($class,'path'));
			$table = constant("$class::TABLE");

			if (is_array($this->images)){
				$keys = array_keys($this->images);
				foreach ($keys as $key){
					$img = $this->images[$key];
					if (is_file($path.$img)){
						unlink($path.$img);
					}
					if (is_file($path.'thm_'.$img)){
						unlink($path.'thm_'.$img);
					}
				}
			}

			self::$db->delete($table,array( 'id' => $this->id ));
			return true;
		} else {
			return false;
		}
	}

	protected function resize($image, $doCrop = true, $size = null, $prefix = '', $fillColor = "#FFFFFF") {

		$parts = explode('.',$image);
		$ext = strtolower(end($parts));

		$red   = "FF";
		$green = "FF";
		$blue  = "FF";
		if (preg_match('/^#?([0-9a-fA-F]{1,2})([0-9a-fA-F]{1,2})([0-9a-fA-F]{1,2})$/',$fillColor,$colors)){
			$red = hexdec($colors[1]);
			$green = hexdec($colors[2]);
			$blue = hexdec($colors[3]);
		}

		$class = get_class($this);
		$path = call_user_func(array($class,'path'));

		$img = null;

		if ($ext == "bmp" || $ext == "jpg" || $ext == "jpeg"){
			$img = imagecreatefromjpeg($path.$image) or die('Invalid JPG image! '.$path.$image);
		} elseif ($ext == "gif"){
			$img = imagecreatefromgif($path.$image) or die('Invalid GIF image! '.$path.$image);
		} elseif ($ext == "png"){
			$img = imagecreatefrompng($path.$image) or die('Invalid PNG image! '.$path.$image);
		}

		if (is_resource($img) === true) {
			$x = 0;
			$y = 0;
			$width = imagesx($img);
			$height = imagesy($img);
			$ratio = min($width/$height,$height/$width);
			$scale = min(($size[1]/$height),($size[0]/$width));

			/* Resize Section  */
			if (is_null($size) === true) {
				$size = array($width, $height);
			} else {
				$size = explode('x', $size);
				$aux = array_filter($size);
				if (empty($aux) === true) {
					$size = array(imagesx($img), imagesy($img));
				} else {
					if ((empty($size[0]) === true) || (is_numeric($size[0]) === false)) {

						$size[0] = round($size[1] * $ratio);
					} elseif ((empty($size[1]) === true) || (is_numeric($size[1]) === false)) {
						$size[1] = round($size[0] * $height / $width);
					}
				}
			}

			if ($size[0] == $width && $size[1] == $height){ // if the original size is equal to the new size, do nothing
				if ($prefix == ''){
					return;
				} else {
					$doCrop = false;
				}
			} elseif ($size[0]/$width == $size[1]/$height){ // if the proportion is equal, do not crop
				$doCrop = false;
			} elseif ($size[0] < $width && $size[1] < $height){ // if the original size is smaller than the new, dont crop
				$doCrop = false;
			}

			if (!$doCrop){
				$scale = min(($size[1]/$height),($size[0]/$width));

				if ($scale > 1) {
					if ($prefix == ''){
						return;
					}
					$result = ImageCreateTrueColor($width, $height);
					ImageSaveAlpha($result, true);
					ImageAlphaBlending($result, true);
					ImageFill($result, 0, 0, ImageColorAllocateAlpha($result, $red, $green, $blue,127));

					ImageCopyResampled($result, $img, 0, 0, 0, 0, $width, $height, $width, $height);
				} else {
					$w = $width * $scale;
					$h = $height * $scale;

					$result = ImageCreateTrueColor($w, $h);
					ImageSaveAlpha($result, true);
					ImageAlphaBlending($result, true);
					ImageFill($result, 0, 0, ImageColorAllocateAlpha($result, $red, $green, $blue,127));

					ImageCopyResampled($result, $img, 0, 0, 0, 0, $w, $h, $width, $height);
				}
			} else {
				if (($width < $size[0] && $height < $size[1])){
					$scale = max(($size[1]/$height),($size[0]/$width));
					$w = $width * $scale;
					$h = $height * $scale;

					if (!$doCrop){
						$result = ImageCreateTrueColor($size[0], $size[1]);
					} else {
						$result = ImageCreateTrueColor($w, $h);
					}
					ImageSaveAlpha($result, true);
					ImageAlphaBlending($result, true);
					ImageFill($result, 0, 0, ImageColorAllocateAlpha($result, $red, $green, $blue,127));

					ImageCopyResampled($result, $img, 0, 0, 0, 0, $w, $h, $width, $height);
					$img = $result;
					$width = $w;
					$height = $h;
				} elseif ($width < $size[0]){
					$h = $height * ($size[0]/$width);

					if (!$doCrop){
						$result = ImageCreateTrueColor($size[0], $size[1]);
					} else {
						$result = ImageCreateTrueColor($size[0], $h);
					}
					ImageSaveAlpha($result, true);
					ImageAlphaBlending($result, true);
					ImageFill($result, 0, 0, ImageColorAllocateAlpha($result, $red, $green, $blue,127));
					ImageCopyResampled($result, $img, 0, 0, 0, 0, $size[0], $h, $width, $height);

					$img = $result;
					$height = $h;
					$width = $size[0];
				} elseif ($height < $size[1]){
					$w = $width * ($size[1]/$height);

					if (!$doCrop){
						$result = ImageCreateTrueColor($size[0], $size[1]);
					} else {
						$result = ImageCreateTrueColor($w, $size[1]);
					}
					ImageSaveAlpha($result, true);
					ImageAlphaBlending($result, true);
					ImageFill($result, 0, 0, ImageColorAllocateAlpha($result, $red, $green, $blue,127));
					ImageCopyResampled($result, $img, 0, 0, 0, 0, $w, $size[1], $width, $height);
					$img = $result;
					$width = $w;
					$height = $size[1];
				} elseif ($width > $size[0] && $height > $size[1] && $ratio !== 1){
					$scale = max(($size[1]/$height),($size[0]/$width));
					$w = $width * $scale;
					$h = $height * $scale;

					$result = ImageCreateTrueColor($w, $h);
					ImageSaveAlpha($result, true);
					ImageAlphaBlending($result, true);
					ImageFill($result, 0, 0, ImageColorAllocateAlpha($result, $red, $green, $blue,127));

					ImageCopyResampled($result, $img, 0, 0, 0, 0, $w, $h, $width, $height);
					$img = $result;
					$width = $w;
					$height = $h;
				}
				$result = ImageCreateTrueColor($size[0], $size[1]);

				ImageSaveAlpha($result, true);
				ImageAlphaBlending($result, true);
				ImageFill($result, 0, 0, ImageColorAllocateAlpha($result, $red, $green, $blue,127));
				# CROP (Aspect Ratio) Section
				$crop = false;

				if ($width > $size[0]){
					$x = abs($width-$size[0])/2;
					$crop = true;
				}
				if ($height > $size[1]){

					$y = ($height/2) - ($size[1]/2);
					$crop = true;
				}
				if ($crop) {
					ImageCopyResampled($result, $img, 0, 0, $x, $y, $width, $height, $width, $height);
				}
			}
			# Create the result image
			if (is_resource($result)){
				ImageInterlace($result, true);
				if ($ext == 'png'){
					ImagePNG($result,$path.$prefix.$image);
				} elseif ($ext == 'gif'){
					ImageGIF($result,$path.$prefix.$image);
				} else {
					ImageJPEG($result,$path.$prefix.$image, 100);
				}
			}
		}
	}

	public static function path(){
		throw new Exception('To be implemented.');
	}
}