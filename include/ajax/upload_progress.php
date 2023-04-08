<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';

function format_size( $bytes )
{
    if ( $bytes < 100 )
        return $bytes;
    if ( $bytes < 10000 )
        return sprintf("%.2fKB", $bytes/1000);
    if ( $bytes < 900000 )
        return sprintf("%dKB", $bytes/1000);
                                        
    return sprintf("%.2fMB", $bytes/1000/1000);                                        
}

$data               = array('status' => 0, 'msg' => '', 'progress' => 0, 'time' => '', 'size' => '');
if ( isset($_POST['upload_id']) ) {
    $filter     = new VFilter();
    $upload_id  = $filter->get('upload_id');
    
    if ( !$upload_id ) {
        $data['msg']    = 'Upload is not a valid upload!';
    } else {
        $progress = NULL;
        if ( function_exists('uploadprogress_get_info') ) {
            $progress       = uploadprogress_get_info($upload_id);
            $data['status']    = 1;
        } elseif ( function_exists('upload_progress_meter_get_info') ) {
            $progress       = upload_progress_meter_get_info($upload_id);
            $data['status']    = 1;
        } else {
            $data['status'] = 3;
        }
        
        if ( $progress ) {
            $meter              = sprintf("%.2f", $progress['bytes_uploaded']/$progress['bytes_total']*100);
            $speed_last         = $progress['speed_last'];
            $speed              = ( $speed_last < 10000 ) ? sprintf("%.2f", $speed_last/1000) : sprintf("%d", $speed_last/1000);
            $eta                = sprintf("%02d:%02d", $progress['est_sec'] / 60, $progress['est_sec'] % 60 );
            $uploaded           = format_size($progress['bytes_uploaded']);
            $total              = format_size($progress['bytes_total']);
            $data['progress']   = $meter;
            $data['time']       = '<span class="text-white">' .$eta. '</span> '.$lang["upload.left"].' ('.$lang["upload.at"].' ' .$speed. 'KB/sec)';
            $data['size']       = '<span class="text-white">'. $uploaded. '</span> / ' .$total. ' (' .$meter. '%)';
            if ( $progress['bytes_total'] > 1 && $progress['bytes_uploaded'] >= $progress['bytes_total'] && $progress['est_sec'] == 0 ) {
                $data['status'] = 2;
            }
        }
    }
}

echo json_encode($data);
die();
?>
