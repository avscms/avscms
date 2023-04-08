<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

//-Videos Total
$sql             = "SELECT count(*) AS v_total FROM video;";
$rs              = $conn->execute($sql);
$videos['total'] = $rs->fields['v_total'];

$sql             = "SELECT count(*) AS v_active FROM video WHERE active='1';";
$rs              = $conn->execute($sql);
$videos['active'] = $rs->fields['v_active'];

$sql             = "SELECT count(*) AS v_suspended FROM video WHERE active!='1';";
$rs              = $conn->execute($sql);
$videos['suspended'] = $rs->fields['v_suspended'];

$smarty->assign('videos', $videos);

//-Albums Total
$sql             = "SELECT count(*) AS a_total FROM albums;";
$rs              = $conn->execute($sql);
$albums['total'] = $rs->fields['a_total'];

$sql             = "SELECT count(*) AS a_active FROM albums WHERE status='1';";
$rs              = $conn->execute($sql);
$albums['active'] = $rs->fields['a_active'];

$sql             = "SELECT count(*) AS a_suspended FROM albums WHERE status!='1';";
$rs              = $conn->execute($sql);
$albums['suspended'] = $rs->fields['a_suspended'];

$smarty->assign('albums', $albums);

$sql             = "SELECT count(*) AS u_total FROM signup;";
$rs              = $conn->execute($sql);
$users['total'] = $rs->fields['u_total'];

$sql             = "SELECT count(*) AS u_active FROM signup WHERE account_status='Active';";
$rs              = $conn->execute($sql);
$users['active'] = $rs->fields['u_active'];

$sql             = "SELECT count(*) AS u_suspended FROM signup WHERE account_status!='Active';";
$rs              = $conn->execute($sql);
$users['suspended'] = $rs->fields['u_suspended'];

$smarty->assign('users', $users);

//-Members Statistics
$time = strtotime(date("Y-m-d H:i:s", strtotime('-7 days')));
$sql="SELECT addtime FROM signup WHERE addtime >= '".$time."' ORDER BY addtime ASC";
$rs = $conn->execute($sql);
$members = $rs->getrows();
$m_total = $rs->recordcount();
$rs->Close();

for ($i=0; $i<7; $i++) {
	$t = date("Y-m-d", strtotime('-'.$i.' days'));
	$day_m[$t]=0;
}
foreach ($members as $member) {
	$t=date("Y-m-d",$member['addtime']);
	++$day_m[$t];
}
$m_chart='';
for ($i=6; $i>=0; $i--) {
	$t = date("Y-m-d", strtotime('-'.$i.' days'));
	$m_chart=$m_chart."{ d: '".$t."', a: ".$day_m[$t]." }";
	if ($i!=0) $m_chart=$m_chart.",";
}
$smarty->assign('m_chart',$m_chart);

//-File Uploads Statistics
$sql="SELECT addtime FROM video WHERE addtime >= '".$time."' ORDER BY addtime ASC";
$rs = $conn->execute($sql);
$videos = $rs->getrows();
$v_total = $rs->recordcount();
$rs->Close();

$sql="SELECT addtime FROM albums WHERE addtime >= '".$time."' ORDER BY addtime ASC";
$rs = $conn->execute($sql);
$albums = $rs->getrows();
$a_total = $rs->recordcount();
$rs->Close();

for ($i=0; $i<7; $i++) {
	$t = date("Y-m-d", strtotime('-'.$i.' days'));
	$day_v[$t]=0;
	$day_i[$t]=0;
	$day_a[$t]=0;
}
foreach ($videos as $video) {
	$t=date("Y-m-d",$video['addtime']);
	++$day_v[$t];
}
foreach ($albums as $album) {
	$t=date("Y-m-d",$album['addtime']);
	++$day_i[$t];
}
$f_chart='';
for ($i=6; $i>=0; $i--) {
	$t = date("Y-m-d", strtotime('-'.$i.' days'));
	$f_chart=$f_chart."{ d: '".$t."', v: ".$day_v[$t].", a: ".$day_i[$t]." }";
	if ($i!=0) $f_chart=$f_chart.",";
}

$news = @file_get_contents('http://www.adultvideoscript.com/adminnews.txt');
$version_lva = @file_get_contents('http://www.adultvideoscript.com/latestversion.txt');
$version_c = AVS_VERSION.'.'.AVS_PATCHLEVEL;
$load = sys_getloadavg();

$smarty->assign('f_chart',$f_chart);
$smarty->assign('m_total',$m_total);
$smarty->assign('v_total',$v_total);
$smarty->assign('a_total',$a_total);

$smarty->assign('news',$news);
$smarty->assign('version_lva',$version_lva);
$smarty->assign('version_c',$version_c);
$smarty->assign('load',$load);

$smarty->assign('err', $err);

?>
