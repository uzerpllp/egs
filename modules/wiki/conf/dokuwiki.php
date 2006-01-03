<?
/* Use a local config file if it exists */
if(file_exists('../../conf/'.$_SERVER['HTTP_HOST'].'.config.php'))
{
  require_once ('../../conf/'.$_SERVER['HTTP_HOST'].'.config.php');
}
else if(file_exists('conf/'.$_SERVER['HTTP_HOST'].'.config.php'))
{
  require_once ('conf/'.$_SERVER['HTTP_HOST'].'.config.php');
}
/* Use the default config file */
else if(file_exists('../../../conf/config.php'))
{
  require_once ('../../../conf/config.php');
}
else if(file_exists('../../conf/config.php'))
{
  require_once ('../../conf/config.php');
}
else
{
  require_once ('../conf/config.php');
}

/* Set the error reporting level, to exclude notices */
error_reporting (E_ALL & ~E_NOTICE);

$conf['datadir'] .= '/'.$_COOKIE['EGS_COMPANY_ID'];
$conf['olddir'] .= '/'.$_COOKIE['EGS_COMPANY_ID'];
$conf['mediadir'] .= '/'.$_COOKIE['EGS_COMPANY_ID'];
$conf['changelog'] .= '.'.$_COOKIE['EGS_COMPANY_ID'];

$_REQUEST['u'] = $_COOKIE['EGS_USERNAME'];
$_REQUEST['p'] = '';
$conf['auth']['pgsql']['passcheck']{(strlen($conf['auth']['pgsql']['passcheck'])-1)} = ' ';
$conf['auth']['pgsql']['passcheck'] .= $_COOKIE['EGS_COMPANY_ID'];

?>
