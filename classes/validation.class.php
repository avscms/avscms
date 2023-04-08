<?php
defined('_VALID') or die('Restricted Access!');

class VValidation
{
    public function username( $username )
    {
        if ( !preg_match('/^[a-zA-Z0-9_]*$/', $username) ) {
            return false;
        } elseif ( preg_match('/^[_]*$/', $username) ) {
            return false;
        }
        
        $users_blocked = array('edit', 'prefs', 'blocks', 'delete', 'avatar');
        if ( in_array($username, $users_blocked) ) {
            return false;
        }
        
        return true;
    }

    public static function username_( $username )
    {
        if ( !preg_match('/^[a-zA-Z0-9_]*$/', $username) ) {
            return false;
        } elseif ( preg_match('/^[_]*$/', $username) ) {
            return false;
        }
        
        $users_blocked = array('edit', 'prefs', 'blocks', 'delete', 'avatar');
        if ( in_array($username, $users_blocked) ) {
            return false;
        }
        
        return true;
    }
    
    public function usernameExists( $username )
    {
        global $conn;
        
        $sql    = "SELECT UID FROM signup WHERE username = " .$conn->qStr($username). " LIMIT 1";
        $conn->execute($sql);
        
        return $conn->Affected_Rows();
    }
	
    public static function usernameExists_( $username )
    {
        global $conn;
        
        $sql    = "SELECT UID FROM signup WHERE username = " .$conn->qStr($username). " LIMIT 1";
        $conn->execute($sql);
        
        return $conn->Affected_Rows();
    }	
    
    public function email( $email )
    {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		  return false; 
		}        
        return true;
    }

    public static function email_( $email )
    {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		  return false; 
		}        
        return true;
    }
    
    public function emailExists( $email, $uid=NULL )
    {
        global $conn;
        
        
        $sql_add    = ( isset($uid) ) ? " AND UID != " .intval($uid) : NULL;
        $sql        = "SELECT UID FROM signup WHERE email = " .$conn->qStr($email). "" .$sql_add. " LIMIT 1";
        $conn->execute($sql);

        return $conn->Affected_Rows();
    }
    
    public function date( $month, $day, $year )
    {        
        return checkdate($month, $day, $year);
    }
    
    public function age( $month, $day, $year, $years )
    {        
        $age        = mktime(0, 0, 0, $month, $day, $year);
        $real_age   = mktime(0, 0, 0, date('m'), date('d'), (date('Y')-$years));
        if ( $age <= $real_age ) {
            return true;
        }
        
        return false;
    }
    
    public function zip( $code, $country='US' ) {
        if ( !ctype_digit($code) ) {
            return false;
        }
        
        $length = VString::strlen($code);
        switch ( $country ) {
            case 'UK':
            case 'CA':
                if ( $length <> 6 ) {
                    return true;
                }
            default:
                if ( $length >= 5 && $lenght <= 9 ) {
                    return true;
                }
        }
        
        return false;
    }
    
    public function ip( $ip )
    {
        if ( !ip2long($ip) ) {
            return false;
        }
    }
}
?>
