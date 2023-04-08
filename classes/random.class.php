<?php
class VRandom
{
    public static function generate( $length=10, $type='password' )
    {
        $random = NULL;
        $chars  = 'abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ( $type == 'password' ) {
            $chars .= '`~!@#$%^&*()_-+={}[]|\;":,<>/?';
        }

        $index  = 1;
        while ( $index <= $length ) {
            $max        = strlen($chars)-1;
            $num        = rand(0, $max);
            $tmp        = substr($chars, $num, 1);
            $random        .= $tmp;
            ++$index;
        }
        
        return $random;
    }
}
?>
