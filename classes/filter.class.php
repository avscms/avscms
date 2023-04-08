<?php
defined('_VALID') or die('Restricted Access!');
define('TIDY_CLEAN', false);


class VFilter
{
	
	
    public function get( $var, $type='STRING', $method='POST')
    {
		
        $method = strtoupper($method);
        $type   = strtoupper($type);

        switch ( $method ) {
            case 'POST':
                $input = $_POST;
                break;
            case 'GET':
                $input = $_GET;
                break;
            case 'COOKIE':
                $input = $_COOKIE;
                break;
            case 'REQUEST':
                $input = $_REQUEST;
                break;
            case 'SERVER':
                $input = $_SERVER;
                break;
            default:
                trigger_error('Invalid filter method!', E_USER_ERROR);
        }
        
        $source = ( isset($input[$var]) ) ? trim($input[$var]) : NULL;
        if ( !$source ) {
            return $source;
        }
        
        return $this->xss_filter($source);
    }
	
	function xss_filter($content){
		require_once('htmlpurifier/HTMLPurifier.auto.php');
		
		$conf_Purifier = HTMLPurifier_Config::createDefault();
		
		$conf_Purifier->set('HTML.Allowed', 'p,b,strong,i');
		$sanitiser = new HTMLPurifier($conf_Purifier);
		$output = $sanitiser->purify($content);		
		
		return $output;
	}	
    
    private function _clean( $source, $type )
    {
        $source = $this->_decode($source);
        switch ( $type ) {
            case 'INT':
            case 'INTEGER':
                $source = intval($source);
                break;
            case 'FLOAT':
            case 'DOUBLE':
                $source = floatval($source);
                break;
            case 'BOOL':
            case 'BOOLEAN':
                $source = (bool) $source;
            case 'STRING':
                $source = $this->process($source);
                break;
            case 'RAW':
                return $source;
            default:                
                $source = $this->process($source);
                break;
        }
        return $source;
    }
    
    public function process( $source, $allowedTags=array(), $allowedAttr=array() )
    {
        if ( is_array($source) ) {
            foreach ( $source as $key => $value ) {
                if ( is_string($value) ) {
                    $source[$key] = $this->_filter($value, $allowedTags, $allowedAttr);
                }
            }            
            return $source;
        } elseif ( is_string($source) ) {
            return $this->_filterTags($source, $allowedTags, $allowedAttr);
        } else {
            return $source;
        }
        
    }
    
    private function _filter( $source, $allowedTags, $allowedAttr )
    {
        $loopCounter = 0;
        while ( $source != $this->_filterTags($source, $allowedTags, $allowedAttr) ) {
            $source = $this->_filterTags($source, $allowedTags, $allowedAttr);
            $loopCounter++;
        }
        
        return $source;
    }
    
    private function _tidyClean( $source )
    {
		if (TIDY_CLEAN) {
      		if ( function_exists('tidy_parse_string') ) {
          		$source = tidy_parse_string($source);
          		tidy_clean_repair($source);
      		}
		}
        
        return trim($source);
    }
    
    private function _filterTags( $source, $allowedTags, $allowedAttr )
    {
        $source = $this->_tidyClean($source);

        $tagBlacklist   = array('applet', 'body', 'bgsound', 'base', 'basefont', 'embed', 'frame', 'frameset', 'head', 'html', 'id', 'iframe', 'ilayer', 'layer', 'link', 'meta', 'name', 'object', 'script', 'style', 'title', 'xml');
    
        $preTag         = NULL;
        $postTag        = $source;
        $currentSpace   = false;
        
        $tagOpen_start  = strpos($source, '<');
        while ( $tagOpen_start !== false ) {
            $preTag        .= substr($postTag, 0, $tagOpen_start);
            $postTag        = substr($postTag, $tagOpen_start);
            $fromTagOpen    = substr($postTag, 1);
            $tagOpen_end    = strpos($fromTagOpen, '>');
            
            if ( $tagOpen_end === false ) {
                $postTag        = substr($postTag, $tagOpen_start +1);
                $tagOpen_start  = strpos($postTag, '<');
                continue;
            }
            
            $tagOpen_nested = strpos($fromTagOpen, '<');
            if ( ($tagOpen_nested !== false) && ($tagOpen_nested < $tagOpen_start) ) {
                $preTag        .= substr($postTag, 0, ($tagOpen_nested+1));
                $postTag        = substr($postTag, ($tagOpen_nested+1));
                $tagOpen_star   = strpos($postTag, '<');
                continue;
            }
            
            $tagOpen_nested = (strpos($fromTagOpen, '<') + $tagOpen_start + 1);
            $currentTag     = substr($fromTagOpen, 0, $tagOpen_end);
            $tagLength      = strlen($currentTag);
            if ( !$tagOpen_end ) {
                $preTag        .= $postTag;
                $tagOpen_start  = strpos($postTag, '<');
            }
            
            $tagLeft        = $currentTag;
            $attrSet        = array();
            $currentSpace   = strpos($tagLeft, ' ');
            if ( substr($currentTag, 0, 1) == '/' ) {
                $isCloseTag     = TRUE;
                list($tagName)  = explode(' ', $currentTag);
                $tagName        = substr($tagName, 1);
            } else {
                $isCloseTag     = FALSE;
                list($tagName)  = explode(' ', $currentTag);
            }
            
            $tag_blacklisted = false;
            $tag_name        = strtolower($tagName);
            foreach ( $tagBlacklist as $key => $value ) {
                if ( $tag_name == $value ) {
                    $tag_blacklisted = true;
                    break;
                }
            }
            
            if ( (!preg_match("/^[a-z][a-z0-9]*$/i",$tagName)) || (!$tagName) || $tag_blacklisted ) {
                $postTag        = substr($postTag, ($tagLength + 2));
                $tagOpen_start  = strpos($postTag, '<');
                continue;
            }
            
            while ( $currentSpace !== FALSE ) {
                $fromSpace      = substr($tagLeft, ($currentSpace+1));
                $nextSpace      = strpos($fromSpace, ' ');
                $openQuotes     = strpos($fromSpace, '"');
                $closeQuotes    = strpos(substr($fromSpace, ($openQuotes+1)), '"') + $openQuotes + 1;
                if ( strpos($fromSpace, '=' ) !== FALSE) {
                    if ( ($openQuotes !== FALSE) && (strpos(substr($fromSpace, ($openQuotes+1)), '"') !== FALSE) ) {
                        $attr = substr($fromSpace, 0, ($closeQuotes+1));
                    } else {
                        $attr = substr($fromSpace, 0, $nextSpace);
                    }
                } else {
                    $attr = substr($fromSpace, 0, $nextSpace);
                }
                
                if ( !$attr ) {
                    $attr = $fromSpace;
                }
                
                $attrSet[] = $attr;
                
                $tagLeft        = substr($fromSpace, strlen($attr));
                $currentSpace   = strpos($tagLeft, ' ');
            }
            
            $tagFound   = false;
            $tag_name   = strtolower($tag_name);
            foreach ( $allowedTags as $key => $value ) {
                if ( $tag_name == $value ) {
                    $tagFound = true;
                    break;
                }
            }
            
            if ( $tagFound ) {
                if ( !$isCloseTag ) {
                    $attrSet = $this->_filterAttr($attrSet, $allowedAttr);
                    $preTag .= '<' . $tagName;
                    for ( $i = 0; $i < count($attrSet); $i++ ) {
                        $preTag .= ' ' . $attrSet[$i];
                    }
                    
                    if ( strpos($fromTagOpen, '</' . $tagName) ) {
                        $preTag .= '>';
                    } else {
                        $preTag .= ' />';
                    }
                } else {
                    $preTag .= '</' . $tagName . '>';
                }
            }
            
            $postTag = substr($postTag, ($tagLength + 2));
            $tagOpen_start = strpos($postTag, '<');
        }
        
        $preTag .= $postTag;
        
        $source = $this->_tidyClean($preTag);

        return $preTag;
    }
    
    private function _filterAttr( $attrSet, $allowedAttr = array() )
    {
        $attrBlacklist  = array('action', 'background', 'codebase', 'dynsrc', 'lowsrc');

        $newSet         = array();
        for ( $i = 0; $i <count($attrSet); $i++ ) {
            if ( !$attrSet[$i] ) {
                continue;
            }
            
            $attrSubSet                 = explode('=', trim($attrSet[$i]));
            list($attrSubSet['0'])      = explode(' ', $attrSubSet['0']);
            
            $attr_blacklisted   = false;
            $attr               = strtolower($attrSubSet['0']);
            foreach ( $attrBlacklist as $key => $value ) {
                if ( $attr == $value ) {
                    $attr_blacklisted = true;
                    break;
                }
            }
            
            if ( !preg_match("/^[a-z]*$/i", $attrSubSet['0']) || $attr_blacklisted || substr($attrSubSet['0'], 0, 2) == 'on' ) {
                continue;            
            }
            
            if ( $attrSubSet['1'] ) {
                $attrSubSet['1'] = str_replace('&#', '', $attrSubSet['1']);
                $attrSubSet['1'] = preg_replace('/\s+/', '', $attrSubSet['1']);
                $attrSubSet['1'] = str_replace('"', '', $attrSubSet['1']);
                if ((substr($attrSubSet['1'], 0, 1) == "'") && (substr($attrSubSet['1'], (strlen($attrSubSet['1']) - 1), 1) == "'")) {
                    $attrSubSet['1'] = substr($attrSubSet['1'], 1, (strlen($attrSubSet['1']) - 2));
                }                
                $attrSubSet[1] = stripslashes($attrSubSet['1']);
            }
            
            if ( ((strpos(strtolower($attrSubSet['1']), 'expression') !== false) && (strtolower($attrSubSet['0']) == 'style')) ||
                 (strpos(strtolower($attrSubSet[1]), 'javascript:') !== false) ||
                 (strpos(strtolower($attrSubSet[1]), 'behaviour:') !== false) ||
                 (strpos(strtolower($attrSubSet[1]), 'vbscript:') !== false) ||
                 (strpos(strtolower($attrSubSet[1]), 'mocha:') !== false) ||
                 (strpos(strtolower($attrSubSet[1]), 'livescript:') !== false) ) {
                continue;
            }
            
            $attrFound  = false;
            foreach ( $allowedAttr as $key => $value ) {
                if ( $attr == $value ) {
                    $attrFound = true;
                    break;
                }
            }
            
            if ( $attrFound ) {
                if ( $attrSubSet['1'] ) {
                    $newSet[] = $attrSubSet['0'] . '="' . $attrSubSet['1'] . '"';
                } elseif ( $attrSubSet['1'] == '0' ) {
                    $newSet[] = $attrSubSet['0'] . '="0"';
                } else {
                    $newSet[] = $attrSubSet['0'] . '="' . $attrSubSet['0'] . '"';
                }                
            }
        }
        
        return $newSet;
    }
    
    private function _decode( $source )
    {
        $source = html_entity_decode($source, ENT_QUOTES, 'UTF-8');
        $source = preg_replace('/&#(\d+);/me',"chr(\\1)", $source);
        $source = preg_replace('/&#x([a-f0-9]+);/mei',"chr(0x\\1)", $source);
        
        return $source;
    }
}
?>
