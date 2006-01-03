<?php
session_start();
//print_r($_SESSION);
if (isset ($_SESSION['loggedIn']) && isset ($_SESSION['modules']) && in_array('projects', $_SESSION['modules'])) {
	
	if (file_exists('../../conf/'.$_SERVER['HTTP_HOST'].'.config.php')) {
		require_once ('../../conf/'.$_SERVER['HTTP_HOST'].'.config.php');
	}
	else if(file_exists('../../conf/config.php')) {
		require_once ('../../conf/config.php');
	}
	/* Use the default config file */
	else {
		require_once ('./conf/config.php');
	}
	require_once (EGS_FILE_ROOT.'/src/db.php');
	if (isset ($_SESSION['EGS_USERNAME']))
		define('EGS_USERNAME', $_SESSION['EGS_USERNAME']);
	if (isset ($_SESSION['EGS_COMPANY_ID']))
		define('EGS_COMPANY_ID', $_SESSION['EGS_COMPANY_ID']);
		
	$incoming = '';
	$incoming = urldecode(implode(file('php://input')));
	if (isset ($_GET['type']))
		$type = $_GET['type'];
	
	$query = 'SELECT subject FROM ticket WHERE id='.$db->qstr($incoming);
	$subject=$db->GetOne($query);
	
	echo $incoming.'/'.$incoming.'@'.$subject;	
	
}


?>