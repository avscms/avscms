<?php
defined('_VALID') or die('Restricted Access!');

function wysiwygColorToCSS ($content) {
	$content = str_replace ( 'class="wysiwyg-color-black"', 'style="color:black"' ,$content);
	$content = str_replace ( 'class="wysiwyg-color-silver"', 'style="color:silver"' ,$content);
	$content = str_replace ( 'class="wysiwyg-color-gray"', 'style="color:gray"' ,$content);
	$content = str_replace ( 'class="wysiwyg-color-maroon"', 'style="color:maroon"' ,$content);
	$content = str_replace ( 'class="wysiwyg-color-red"', 'style="color:red"' ,$content);
	$content = str_replace ( 'class="wysiwyg-color-purple"', 'style="color:purple"' ,$content);
	$content = str_replace ( 'class="wysiwyg-color-green"', 'style="color:green"' ,$content);
	$content = str_replace ( 'class="wysiwyg-color-olive"', 'style="color:olive"' ,$content);
	$content = str_replace ( 'class="wysiwyg-color-navy"', 'style="color:navy"' ,$content);
	$content = str_replace ( 'class="wysiwyg-color-blue"', 'style="color:blue"' ,$content);
	$content = str_replace ( 'class="wysiwyg-color-orange"', 'style="color:orange"' ,$content);
    return $content;
}

function wysiwygCSSToColor ($content) {
	$content = str_replace ( 'style="color:black"', 'class="wysiwyg-color-black"', $content);
	$content = str_replace ( 'style="color:silver"', 'class="wysiwyg-color-silver"' ,$content);
	$content = str_replace ( 'style="color:gray"', 'class="wysiwyg-color-gray"' ,$content);
	$content = str_replace ( 'style="color:maroon"', 'class="wysiwyg-color-maroon"' ,$content);
	$content = str_replace ( 'style="color:red"', 'class="wysiwyg-color-red"' ,$content);
	$content = str_replace ( 'style="color:purple"', 'class="wysiwyg-color-purple"' ,$content);
	$content = str_replace ( 'style="color:green"', 'class="wysiwyg-color-green"' ,$content);
	$content = str_replace ( 'style="color:olive"', 'class="wysiwyg-color-olive"' ,$content);
	$content = str_replace ( 'style="color:navy"', 'class="wysiwyg-color-navy"' ,$content);
	$content = str_replace ( 'style="color:blue"', 'class="wysiwyg-color-blue"' ,$content);
	$content = str_replace ( 'style="color:orange"', 'class="wysiwyg-color-orange"' ,$content);
    return $content;
}

?>
