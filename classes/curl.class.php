<?php
define('USER_AGENT', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.81 Safari/537.36');
class VCurl
{
    private $_verbose = false;
    private $_progress = true;
    function __construct()
    {
		if ( defined('_CONSOLE') ) {
			$this->_verbose 	= true;
			$this->_progress 	= false;
		}
    }
    
    function VCurl()
    {
        $this->__construct();
    }

    function saveToString( $url, $cookie=NULL )
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, $this->_verbose);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_NOPROGRESS, $this->_progress);
        curl_setopt($ch, CURLOPT_USERAGENT, USER_AGENT);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);		
        if ( $cookie ) {
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }
        $string = curl_exec($ch);
		$string = urldecode($string);
        if ( curl_errno($ch) ) {
            return false;
        }
        curl_close($ch);
        return $string;
    }
	
    function get_update_version( $url, $cookie=NULL )
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, $this->_verbose);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_NOPROGRESS, $this->_progress);
        curl_setopt($ch, CURLOPT_USERAGENT, USER_AGENT);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);		
        if ( $cookie ) {
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }
        $string = curl_exec($ch);
		$string = preg_replace('/\s+/', '', $string);
        if ( curl_errno($ch) ) {
            return false;
        }
        curl_close($ch);
        return $string;
    }
	
	function get_update_file($url, $local_path, $filename) {
		$file_url = $url;
		$destination_path = $local_path.$filename;
		$update_status = false;

		$fp = fopen($destination_path, "w+");

		$ch = curl_init($file_url);
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_exec($ch);
		$st_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		fclose($fp);

		if($st_code == 200)
		 $update_status = true;
		else
		 $update_status = false;

		return $update_status;
	}

    function getVideoFiletype($url, $cookie=NULL)
	{
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, USER_AGENT);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);		
        if ( $cookie ) {
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }
        
        $head   = curl_exec($ch);
        if ( curl_errno($ch) ) {
            return false;
        }
     
        curl_close($ch);
        preg_match_all( '@Content-Type:\s+([\w/+]+)(;\s+charset=(\S+))?@i', $head, $matches );
		return end($matches[1]);
    }

    function saveToFile( $url, $local, $cookie=NULL )
    {
        $ch = curl_init();
        $fh = fopen($local, 'w');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FILE, $fh);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, $this->_verbose);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_NOPROGRESS, $this->_progress);
        curl_setopt($ch, CURLOPT_USERAGENT, USER_AGENT);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);		
        if ( $cookie ) {
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }
        curl_exec($ch);
        if( curl_errno($ch) ) {
            return false;
        }
        curl_close($ch);
        fclose($fh);
        if( filesize($local) > 10 ) {
            return true;
        }
        return false;
    }
    
    function getRemoteSize( $url, $cookie=NULL )
    {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, USER_AGENT);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_NOBODY, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);		
		$chStore = curl_exec($ch);
		$chError = curl_error($ch);
		$chInfo = curl_getinfo($ch);
		curl_close($ch); 
		$_ch['Store'] = $chStore;
		$_ch['Error'] = $chError;
		$_ch['Info'] = $chInfo;
		
		$ret = intval($chInfo['download_content_length']);
        
        if($ret == '' || $ret <200){ 
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLOPT_NOBODY, 1);
			curl_setopt($ch, CURLOPT_VERBOSE, false);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_USERAGENT, USER_AGENT);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);			
			if ( $cookie ) {
			  curl_setopt($ch, CURLOPT_COOKIE, $cookie);
			}
			$head   = curl_exec($ch);
			if ( curl_errno($ch) ) {
			  return false;
			}
			curl_close($ch);
			$regex = '/Content-Length:\s([0-9].+?)\s/';
			$count = preg_match_all($regex, $head, $matches);
			$length = end($matches[1]);
			$ret = isset($length) ? $length : 'unknown';
			}   			
        return $this->bytes($ret);
    }
    
    function bytes($a) 
	{
		$unim = array("B","KB","MB","GB","TB","PB");
		$c = 0;
		while ( $a >= 1024 ) {
			$c++;
			$a = $a/1024;
		}
		return number_format($a,($c ? 2 : 0),",",".")." ".$unim[$c];
    }
}
?>
