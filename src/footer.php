<?php
	/* Sync the session */
	$egs->syncToSession();
	$db->close();
	
/* Get the time now so that we can work out how long the script was
 * executing for */
$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
$endtime = $mtime;
$totaltime = ($endtime - $starttime);

if(isset($_SESSION['search'])) {
	while(list($key, $val) = each($_SESSION['search'])) {
		if($key{1} == '_') {
			$newkey = $key;
			$newkey{1} = '.';
			$_SESSION['search'][$newkey] = $_SESSION['search'][$key];	
			unset($_SESSION['search'][$key]);
		}	
	}	
}

if (isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'] !== true)) {
	$smarty->display(EGS_FILE_ROOT.'/themes/'.EGS_THEME.'/templates/login.tpl');
} else if (!isset($_GET['print'])||!isset($_GET['action'])||!($_GET['action']=='labels'&&$_GET['print']==true)){
	$smarty->assign("totalTime", sprintf("%01.4f", $totaltime));
	if(EGS_MODULE != 'choose') {
		if(isset($_GET['print']) && ($_GET['print'] == 'true') && ($_GET['action']!='labels')) {
			$smarty->display(EGS_FILE_ROOT.'/themes/'.EGS_THEME.'/templates/print.tpl');
		}
		else if(isset($_GET['export']) && ($_GET['export'] == 'tab')) {
			// We'll be outputting a PDF
			header('Content-type: text/csv');
			
			// It will be called downloaded.pdf
			header('Content-Disposition: attachment; filename="export.csv"');
			
			$smarty->display(EGS_FILE_ROOT.'/themes/'.EGS_THEME.'/templates/export.tpl');
		}
		else $smarty->display(EGS_FILE_ROOT.'/themes/'.EGS_THEME.'/templates/index.tpl');
	}
	else $smarty->display(EGS_FILE_ROOT.'/themes/'.EGS_THEME.'/templates/choose.tpl');
}

?>
