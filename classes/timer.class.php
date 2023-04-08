<?php
defined('_VALID') or die('Restricted Access!');

class VTimer
{
    public static function start($name)
    {
        $timers =& $GLOBALS['timers'];
        if (!isset($timers) || !is_array($timers)) {
            $timers[$name] = array(
                'start'         => microtime(true),
                'stop'          => false,
                'memory_start'  => function_exists('memory_get_usage') ? memory_get_usage() : 0,
                'memory_stop'   => false
            );
        }
    }
    
    public static function stop($name)
    {
        $timers =& $GLOBALS['timers'];
        if ( isset($timers[$name]) && $timers[$name]['stop'] === false ) {
            $timers[$name]['stop']        = microtime(true);
            $timers[$name]['memory_stop'] = function_exists('memory_get_usage') ? memory_get_usage() : 0;
        }
    }
    
    public function get($name, $decimals=4)
    {
        $timers =& $GLOBALS['timers'];
        if ( !isset($timers[$name]) ) {
            return false;
        }

        if ( $timers[$name]['stop'] === false ) {
            self::stop($name);
        }

        return array(
            'time'      => number_format($timers[$name]['stop'] - $timers[$name]['start'], $decimals),
            'memory'    => $timers[$name]['memory_stop'] - $timers[$name]['memory_start']
        );
    }
}

VTimer::start('main');
?>
