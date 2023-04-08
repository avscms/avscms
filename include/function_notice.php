<?php
defined('_VALID') or die('Restricted Access!');

function get_notice_categories()
{
    global $conn;

    $sql            = "SELECT category_id, name FROM notice_categories ORDER BY name ASC";
    $rs             = $conn->execute($sql);
    
    return $rs->getrows();
}

function get_notice_arhive()
{
    global $conn;

    $arhive         = array();
    $sql            = "SELECT adddate FROM notice ORDER BY adddate ASC LIMIT 1";
    $rs             = $conn->execute($sql);
	if ($conn->Affected_Rows() > 0) {
		$start_date     = $rs->fields['adddate'];
		$start_expl     = explode('-', $start_date);
		$start_year     = intval($start_expl['0']);
		$start_month    = intval($start_expl['1']);
		$sql            = "SELECT adddate FROM notice ORDER BY adddate DESC LIMIT 1";
		$rs             = $conn->execute($sql);
		$end_date       = $rs->fields['adddate'];
		$end_expl       = explode('-', $end_date);
		$end_year       = intval($end_expl['0']);
		$end_month      = intval($end_expl['1']);

		$year = $start_year;
		if ( $start_year != $end_year ) {
			while ( $year <= $end_year ) {
				if ( $year == $start_year ) {
					for ( $month=$start_month; $month<=12; $month++ ) {
						$arhive[]   = mktime(0, 0, 0, $month, 0, $year);
					}
				} elseif ( $year == $end_year ) {
					for ( $month=1; $month<=$end_month; $mont++ ) {
						$arhive[]   = mktime(0, 0, 0, $month, 0, $year);
					}
				} else {
					for ( $month=1; $mont<=12; $month++ ) {
						$arhive[]   = mktime(0, 0, 0, $month, 0, $year);
					}
				}
				++$year;
			}
		} else {
			for ( $month=$start_month; $month<=$end_month; $month++ ) {
				$arhive[]   = mktime(0, 0, 0, $month, 1, $year);
			}
		}
    }
    return array_reverse($arhive);
}
?>
