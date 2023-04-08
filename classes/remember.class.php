<?php
defined('_VALID') or die('Restricted Access!');
class Remember
{
    public static function check()
    {    
        if (!isset($_SESSION['uid']) && isset($_COOKIE['remember'])) {
            $browser    = (isset($_SERVER['HTTP_USER_AGENT'])) ? sha1($_SERVER['HTTP_USER_AGENT']) : NULL;
            $ip         = (isset($_SERVER['REMOTE_ADDR']) && ip2long($_SERVER['REMOTE_ADDR'])) ? ip2long($_SERVER['REMOTE_ADDR']) : NULL;
            $cookie     = unserialize($_COOKIE['remember']);
            if (is_array($cookie)) {
                if ($cookie['check'] == sha1($browser . $ip)) {
                    global $conn;
                    $sql    = "SELECT UID, username, email, emailverified, photo, fname, pwd, logintime
                               FROM signup
                               WHERE username = " .$conn->qStr($cookie['username']). "
                               AND pwd = " .$conn->qStr($cookie['password']). "
                               LIMIT 1";
                    $rs     = $conn->execute($sql);
                    if ($conn->Affected_Rows() === 1) {
                        $user = $rs->getrows();
                        $yesterday  = time() - 86400;
                        $sql_add    = NULL;
                        if ( intval($user['0']['logintime']) < $yesterday ) {
                            $sql_add = ", points = points+5";
                        }
                        $sql  = "UPDATE signup SET logintime = '" .time(). "'" .$sql_add. " WHERE username = " .$conn->qStr($user['0']['username']). " LIMIT 1";
                        $conn->execute($sql);
                        $_SESSION['uid']            = intval($user['0']['UID']);
                        $_SESSION['username']       = $user['0']['username'];
                        $_SESSION['email']          = $user['0']['email'];
                        $_SESSION['emailverified']  = $user['0']['emailverified'];
                        $_SESSION['photo']          = $user['0']['photo'];
                        $_SESSION['fname']          = $user['0']['fname'];
                        $_SESSION['message']        = 'Welcome ' .$user['0']['username']. '!';
                        self::set($user['0']['username'], $user['0']['pwd']);
                    }
                }
            }
        }
    }
    
    public static function set($username, $password)
    {
        $browser    = (isset($_SERVER['HTTP_USER_AGENT'])) ? sha1($_SERVER['HTTP_USER_AGENT']) : NULL;
        $ip         = (isset($_SERVER['REMOTE_ADDR']) && ip2long($_SERVER['REMOTE_ADDR'])) ? ip2long($_SERVER['REMOTE_ADDR']) : NULL;
        $user       = array('username' => $username, 'password' => $password, 'check' => sha1($browser . $ip));
        $cookie     = serialize($user);
        setcookie('remember', $cookie, time()+60*60*24*100, '/');
    }
    
    public static function del()
    {
        setcookie('remember', '', time()-60*60*24*100, '/');
    }
}
?>