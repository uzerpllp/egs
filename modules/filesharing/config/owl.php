<?php
error_reporting(E_ALL ^ E_NOTICE);
/* Use a local config file if it exists */
if(file_exists('../../conf/'.$_SERVER['HTTP_HOST'].'.config.php'))
{
  require_once ('../../conf/'.$_SERVER['HTTP_HOST'].'.config.php');
  require_once ('../../src/db.php');
}
else if(file_exists(EGS_FILE_ROOT.'/conf/'.$_SERVER['HTTP_HOST'].'.config.php'))
{
  require_once (EGS_FILE_ROOT.'/conf/'.$_SERVER['HTTP_HOST'].'.config.php');
  require_once (EGS_FILE_ROOT.'/src/db.php');
}
else if(file_exists(EGS_FILE_ROOT.'/conf/'.$_SERVER['HTTP_HOST'].'.config.php'))
{
	require_once (EGS_FILE_ROOT.'/conf/config.php');
  	require_once (EGS_FILE_ROOT.'/src/db.php');	
	
}
/* Use the default config file */
else
{
	
  require_once ('../../../conf/'.$_SERVER['HTTP_HOST'].'.config.php');
  require_once ('../../../src/db.php');
}

/* Set the error reporting level, to exclude notices */
error_reporting (E_ALL & ~E_NOTICE);

unset($_GET[currentdb]);
unset($_POST[currentdb]);
$default->owl_table_prefix = 'company'.$_COOKIE['EGS_COMPANY_ID'].'.';
if(!isset($_GET['sess']))$_GET['sess']=$_COOKIE['owl_sessid'];
$userid = $db->GetOne('SELECT usid FROM company'.$_COOKIE['EGS_COMPANY_ID'].'.active_sessions WHERE sessid='.$db->qstr($_GET['sess']));
?>
