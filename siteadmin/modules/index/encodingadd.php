<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$preset = array (
	'ultrafast',
	'superfast',
	'veryfast',
	'faster',
	'fast',
	'medium',
	'slow',
	'slower',
	'veryslow',
	'placebo'
);

$ios = array (
	array ('spec' => 'None', 'value' => ''),
	array ('spec' => 'All devices',	'value' => '-profile:v baseline -level 3.0'),
	array ('spec' => 'iPhone 3G and later, iPod touch 2nd generation and later', 'value' => '-profile:v baseline -level 3.1'),
	array ('spec' => 'iPad (all versions), Apple TV 2 and later, iPhone 4 and later', 'value' => '-profile:v main -level 3.1'),
	array ('spec' => 'Apple TV 3 and later, iPad 2 and later, iPhone 4s and later', 'value' => '-profile:v main -level 4.0'),
	array ('spec' => 'Apple TV 3 and later, iPad 2 and later, iPhone 4s and later', 'value' => '-profile:v high -level 4.0'),
	array ('spec' => 'iPad 2 and later, iPhone 4s and later, iPhone 5c and later', 'value' => '-profile:v high -level 4.1'),
	array ('spec' => 'iPad Air and later, iPhone 5s and later', 'value' => '-profile:v high -level 4.2')
);
$encoding = array (
	'label' 	=> '', 
	'width' 	=> '', 
	'height' 	=> '',
	'crf'		=> 23,
	'preset'	=> 'medium',
	'ios'		=> '',
	'faststart' => 0,
	'format'	=> 'mp4',
	'copyonly' 	=> 1,
	'status' 	=> 1
);
if ( isset($_POST['encoding_add']) ) {
    $encoding['label']		= trim	($_POST['label']);
    $encoding['width']		= intval($_POST['width']);
	$encoding['height']		= intval($_POST['height']);
	$encoding['crf']		= intval($_POST['crf']);
	$encoding['preset']		= trim	($_POST['preset']);
	$encoding['ios']		= trim	($_POST['ios']);
	$encoding['faststart'] 	= intval($_POST['faststart']);
	$encoding['format'] 	= 'mp4';
	$encoding['copyonly'] 	= intval($_POST['copyonly']);
	$encoding['status'] 	= intval($_POST['status']);	
    
	if (preg_match('/[^A-Za-z0-9]/', $encoding['label'])) {
        $errors[]       = 'Only letters and digits are allowed for label [A-Za-z0-9]!';
		$err['label'] = 1;
	}
	$sql        = "SELECT id FROM encoding WHERE label = " .$conn->qStr($encoding['label']). " LIMIT 1";
	$conn->execute($sql);
	if ( $conn->Affected_Rows() > 0 ) {
		$errors[]   = "Encoding label <b>" .trim($conn->qStr($encoding['label']), "'")."</b> is already used. Please choose a different label!";
		$err['label'] = 1;
	}
	if ($encoding['width'] < 100) {
        $errors[]       = 'Please use a bigger value for width!';
		$err['width'] = 1;
	}
	if ($encoding['width'] > 7680) {
        $errors[]       = 'Please use a smaller value for width!';
		$err['width'] = 1;
	}	
	if ($encoding['height'] < 100) {
        $errors[]       = 'Please use a bigger value for height!';
		$err['height'] = 1;
	}
	if ($encoding['height'] > 7680) {
        $errors[]       = 'Please use a smaller value for height!';
		$err['height'] = 1;
	}
	if ($encoding['crf'] < 0 || $encoding['crf'] > 51) {
        $errors[]       = 'CRR value is out of range. Please use a number between 0 and 51!';
		$err['crf'] = 1;
	}
	
    if ( !$errors ) {
        $sql	=	"INSERT INTO encoding SET
					label = " .$conn->qStr($encoding['label']). ", 
					width = " .$conn->qStr($encoding['width']). ", 
					height = " .$conn->qStr($encoding['height']). ", 
					crf = " .$conn->qStr($encoding['crf']). ", 
					preset = " .$conn->qStr($encoding['preset']). ", 
					ios = " .$conn->qStr($encoding['ios']). ", 
					faststart = " .$conn->qStr($encoding['faststart']). ", 
					format = " .$conn->qStr($encoding['format']). ", 
					copyonly = " .$conn->qStr($encoding['copyonly']). ", 
					status = " .$conn->qStr($encoding['status']). "
					";
        $conn->execute($sql);
        $messages[]     = 'Encoding successfully added!';
    }
}

$smarty->assign('preset', $preset);
$smarty->assign('ios', $ios);
$smarty->assign('encoding', $encoding);

?>
