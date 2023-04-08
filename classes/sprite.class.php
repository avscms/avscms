<?php
defined('_VALID') or die('Restricted Access!');
class images_to_sprite {
 
	public function __construct($folder,$output,$x,$y) {
		$this->folder = ($folder ? $folder : 'myfolder'); // Folder name to get images from, i.e. C:\myfolder or /home/user/Desktop/folder
		$this->filetypes = array('jpg'=>true,'png'=>true,'jpeg'=>true,'gif'=>true); // Acceptable file extensions to consider
		$this->output = ($output ? $output : 'mysprite'); // Output filenames, mysprite.png and mysprite.css
		$this->x = $x; // Width of images to consider
		$this->y = $y; // Heigh of images to consider
		$this->files = array();
	}
 
	function create_sprite() {
		$resize = 1;
		$basedir = $this->folder;
		$files = array();
		// Read through the directory for suitable images
		for ($i = 1; $i<=20; $i++) {
			$this->files[$i.'.jpg'] = $i.'.jpg';
		}

		// xx is the height of the sprite to be created, basically X * number of images
		$this->xx = $this->x * count($this->files);
		$im = imagecreatetruecolor(round($this->xx*$resize),round($this->y*$resize));
 
		// Add alpha channel to image (transparency)
		imagesavealpha($im, true);
		$alpha = imagecolorallocatealpha($im, 0, 0, 0, 127);
		imagefill($im,0,0,$alpha);
 
		// Append images to sprite and generate CSS lines
		$i = $ii = 0;
			foreach($this->files as $key => $file) {
				$im2 = imagecreatefromjpeg($this->folder.'/'.$file);
				imagecopyresized($im,$im2,round(($this->x*$i)*$resize),0,0,0,round(($this->x)*$resize),round(($this->y)*$resize),$this->x,$this->y);
				$i++;
			}
		imagejpeg($im,$this->output.'.jpg'); // Save image to file
		imagedestroy($im);
	}
}
?>