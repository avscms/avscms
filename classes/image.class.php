<?php
defined('_VALID') or die('Restricted Access!');
class VImageConv
{
	private $srcWidth;
	private $srcHeight;
	private $srcType;
	private $dstWidth;
	private $dstHeight;
	private $dstType;
	private $srcImage;
	private $dstImage;
	private $imageIndentifer;
	private $newImageIdentifier;
	private $imageWidth;
	private $imageHeight;
	private $resizeType;
	private $jpgQuality;
	private $outputType;
	private $canvasWidth;
	private $canvasHeight;
	private $debug = false;
	public function __construct()
	{
		$this->checkGDSupport();
		$this->jpgQuality	= 90;
	}
	
	public function __destruct()
	{
		if( is_resource($this->imageIdentifier) )
			imagedestroy($this->imageIdentifier);
		if( is_resource($this->newImageIdentifier) )
			imagedestroy($this->newImageIdentifier);
	}
	
	public function process( $src, $dst, $type, $width, $height, $outputType = 'jpg' )
	{
		if( !file_exists($src) || !is_file($src) )
			throw new Exception('Application Error. Image source file not found!');
		if( !is_readable($src) )
			throw new Exception('Application Error. Could not read image src file!');
		$dst_dir	= dirname($dst);
		if( !file_exists($dst_dir) || !is_dir($dst_dir) )
			throw new Exception('Application Error. Destination directory could not be found!');
		if( !is_writable($dst_dir) )
			throw new Exception('Application Error. Destination directory is not writable');
		
		$this->srcImage		= $src;
		$this->dstImage		= $dst;
		$this->dstWidth		= (int)$width;
		$this->dstHeight	= (int)$height;
		$this->resizeType	= $type;
		$this->outputType	= $outputType;
		$this->getImageSize();
		$this->setImageSize();
	}
	
	private function getImageSize()
	{
		$imageData 		= getimagesize($this->srcImage);
		$this->srcWidth		= $imageData['0'];
		$this->srcHeight	= $imageData['1'];
		switch( $imageData['2'] ) {
		case 1:
			$this->srcType		= 'gif';
			$this->imageIdentifier	= imagecreatefromgif($this->srcImage);
			break;
		case 2:
			$this->srcType	= 'jpg';
			$this->imageIdentifier	= imagecreatefromjpeg($this->srcImage);
			break;			
		case 3: 
			$this->srcType	= 'png';
			$this->imageIdentifier	= imagecreatefrompng($this->srcImage);
			break;
		default:
			throw new Exception('Application Error. Invalid Image Type!');
		}
	}
	
	private function setImageSize()
	{
		switch($this->resizeType) {
		case 'MAX_WIDTH':
			$this->imageWidth	= ( $this->srcWidth > $this->dstWidth ) ? $this->dstWidth : $this->srcWidth;
			$this->imageHeight	= intval(($this->imageWidth * $this->srcHeight) / $this->srcWidth);
			break;
		case 'MAX_HEIGHT':
			$this->imageHeight	= ( $this->srcHeight > $this->dstHeight ) ? $this->dstHeight : $this->srcHeight;
			$this->imageWidth	= intval(($this->imageHeight * $this->srcWidth) / $this->srcHeight);
			break;
		case 'ASPECT_RATIO':
			if( ($this->srcHeight / $this->dstHeight) >= ($this->srcWidth / $this->dstWidth) ) {
				$this->imageHeight	= ( $this->srcHeight > $this->dstHeight ) ? $this->dstHeight : $this->srcHeight;
				$this->imageWidth	=  intval(($this->imageHeight * $this->srcWidth) / $this->srcHeight);
			} else {
				$this->imageWidth	= ( $this->srcWidth > $this->dstWidth ) ? $this->dstWidth : $this->srcWidth;
				$this->imageHeight	= intval(($this->imageWidth * $this->srcHeight) / $this->srcWidth);
			}
			break;
		case 'EXACT':
			$this->imageWidth	= $this->dstWidth;
			$this->imageHeight	= $this->dstHeight;
			break;
		case 'SAME':
			$this->imageWidth	= $this->srcWidth;
			$this->imageHeight	= $this->srcHeight;
			break;
		default:
			throw new Exception('Application Error. Invalid Resize Type!');
		}
		
		$this->newImageIdentifier = imagecreatetruecolor( $this->imageWidth, $this->imageHeight );
	}
	
	public function save()
	{
		if( $this->debug ) {
			echo 'JPG QUALITY :' .$this->jpgQuality. '<br>';
			echo 'SRC WIDTH : ' .$this->srcWidth. '<br>';
			echo 'SRC_HEIGHT : ' .$this->srcHeight. '<br>';
			echo 'DST WIDTH : ' .$this->dstWidth. '<br>';
			echo 'DST HEIGHT : ' .$this->dstHeight. '<br>';
			echo 'NEW WIDTH : ' .$this->imageWidth. '<br>';
			echo 'NEW HEIGHT : ' .$this->imageHeight. '<br>';
		}
	
		switch( $this->outputType ) {
		case 'jpg':
			imagejpeg($this->newImageIdentifier, $this->dstImage, $this->jpgQuality);
			break;
		case 'gif':
			imagegif($this->newImageIdentifier, $this->dstImage);
			break;
		case 'png':
			imagepng($this->newImageIdentifier, $this->dstImage);
			break;
		default:
			return false;
		}
	}
	
	public function resize( $save = false, $now = false )
	{
		$positionX	= 0;
		$positionY	= 0;
		if( isset($this->canvasWidth) && $this->canvasWidth > 0 && isset($this->canvasHeight) && $this->canvasHeight > 0 &&
		    $this->canvasWidth >= $this->imageWidth && $this->canvasHeight >= $this->imageHeight ) {
			$positionX	= intval(($this->canvasWidth - $this->imageWidth) / 2);
			$positionY	= intval(($this->canvasHeight - $this->imageHeight) / 2);
		}
		
		if( $this->debug ) {
			echo 'POSITION X: ' .$positionX. '<br>';
			echo 'POSITION Y: ' .$positionY. '<br>';
		}
        
        if ( $now ) {
            $this->newImageIdentifier = imagecreatetruecolor($this->imageWidth, $this->imageHeight);
        }
        
		imagecopyresampled( $this->newImageIdentifier, $this->imageIdentifier, $positionX, $positionY, 0 ,0 , $this->imageWidth, $this->imageHeight, $this->srcWidth, $this->srcHeight);
		
		if( $save ) {
			$this->save();
        }
	}
	
	public function canvas( $width, $height, $color, $save = false )
	{
		$this->canvasWidth	  	= $width;
		$this->canvasHeight		= $height;
		$this->newImageIdentifier 	= imagecreatetruecolor($this->canvasWidth, $this->canvasHeight);
		$rgb			  	= $this->hex2rgb($color);
		$color			  	= imagecolorallocate($this->newImageIdentifier, $rgb['0'], $rgb['1'], $rgb['2']);
		imagefill($this->newImageIdentifier, 0, 0, $color);
		
		$this->resize();
		
		if( $save ) {
			$this->save();
        }
	}
	
	public function crop( $x, $y, $w, $h, $save = false )
	{
        imagecopyresampled( $this->newImageIdentifier, $this->imageIdentifier, 0, 0, $x, $y, $w, $h, $w, $h);
                
        if ( $save ) {
            $this->save();
        }
	}
	
	public function watermark()
	{
	}
	
	public function rotate()
	{
	}
	
	public function flip()
	{
	}
	
	private function hex2rgb( $hex_code )
	{
		$r	= substr($hex_code, 0, 2);
		$g	= substr($hex_code, 2, 2);
		$b	= substr($hex_code, 4, 2);
		
		return array(base_convert($r, 16, 10), base_convert($g, 16, 10), base_convert($b, 16, 10));
	}
	
	private function checkGDSupport()
	{
		if( !function_exists('gd_info') )
			throw new Exception('Application Error. Support for GD is not available!');
		
		$gd_info = gd_info();


		if (strnatcmp(phpversion(),'5.3') >= 0)
		{
			if( !$gd_info['JPEG Support'] )
			throw new Exception('Application Error. Support for JPG is not available in GD!');
		}
		else
		{
			if( !$gd_info['JPG Support'] )
			throw new Exception('Application Error. Support for JPG is not available in GD!');
		} 

		if( !$gd_info['PNG Support'] )
			throw new Exception('Application Error. Support for PNG is not available in GD!');
		if( !$gd_info['GIF Read Support'] || !$gd_info['GIF Create Support'] )
			throw new Exception('Application Error. Support for GIF is not available in GD!');
	}
}
?>