<?php
// Disable magic_quotes_runtime
set_magic_quotes_runtime(0);
// Slash data if it isn't slashed
if (!get_magic_quotes_gpc()) {
	// get
	if (is_array($_GET)) {
		while (list($k, $v) = each($_GET)) {
			if (is_array($_GET[$k])) {
				while (list($k2, $v2) = each($_GET[$k])) {
					$_GET[$k][$k2] = addslashes($v2);
				}
				@reset($_GET[$k]);
			} else {
				$_GET[$k] = addslashes($v);
			}
		}
		@reset($_GET);
	}
	// post
	if (is_array($_POST)) {
		while (list($k, $v) = each($_POST)) {
			if (is_array($_POST[$k])) {
				while (list($k2, $v2) = each($_POST[$k])) {
					$_POST[$k][$k2] = addslashes($v2);
				}
				@reset($_POST[$k]);
			} else {
				$_POST[$k] = addslashes($v);
			}
		}
		@reset($_POST);
	}
	// cookie
	if (is_array($_COOKIE)) {
		while (list($k, $v) = each($_COOKIE)) {
			if (is_array($_COOKIE[$k])) {
				while (list($k2, $v2) = each($_COOKIE[$k])) {
					$_COOKIE[$k][$k2] = addslashes($v2);
				}
				@reset($_COOKIE[$k]);
			} else {
				$_COOKIE[$k] = addslashes($v);
			}
		}
		@reset($_COOKIE);
	}
}
if (isset ($_GET['lang']) ? $_GET['lang'] : '') {
	if (wp_file_name_ok($_GET['lang'])) {
		$lang_include = $_GET['lang'];
	} else {
		$lang_include = DEFAULT_LANG;
	}
} else if (isset ($_POST['lang']) ? $_POST['lang'] : '') { 
	if (wp_file_name_ok($_POST['lang'])) {
		$lang_include = $_POST['lang'];
	} else {
		$lang_include = DEFAULT_LANG;
	}
} else {
	$lang_include = DEFAULT_LANG;
}
?>