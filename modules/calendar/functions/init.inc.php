<?php 

// uncomment when developing, comment for shipping version
error_reporting (E_ERROR | E_WARNING | E_PARSE);

// Older versions of PHP do not define $_SERVER. Define it here instead.
if (!isset($_SERVER) && isset($_SERVER)) {
	$_SERVER = &$_SERVER;
}

// Define some magic strings.
$ALL_CALENDARS_COMBINED = 'all_calendars_combined971';

// Pull in the configuration and some functions.
if (!defined('BASE')) define('BASE', './');
include_once(BASE.'config.inc.php');

include_once(BASE.'error.php');
include_once(BASE.'functions/calendar_functions.php');
include_once(BASE.'functions/userauth_functions.php');
if (isset($_COOKIE['phpicalendar'])) {
	
	$phpicalendar = unserialize(stripslashes($_COOKIE['phpicalendar']));
	if (isset($phpicalendar['cookie_language'])) 	$language 			= $phpicalendar['cookie_language'];
	if (isset($phpicalendar['cookie_calendar'])) 	$default_cal_check	= $phpicalendar['cookie_calendar'];
	if (isset($phpicalendar['cookie_view'])) 		$default_view 		= $phpicalendar['cookie_view'];
	if (isset($phpicalendar['cookie_style'])) 		$style_sheet 		= $phpicalendar['cookie_style'];
	if (isset($phpicalendar['cookie_startday'])) 	$week_start_day		= $phpicalendar['cookie_startday'];
	if (isset($phpicalendar['cookie_time']))		$day_start			= $phpicalendar['cookie_time'];
}

// Set the cookie URI.
if ($cookie_uri == '') {
	$cookie_uri = $_SERVER['SERVER_NAME'].substr($_SERVER['PHP_SELF'],0,strpos($_SERVER['PHP_SELF'], '/'));
}

if ($bleed_time == '') $bleed_time = -1;

// Grab the action (login or logout).
if (isset($_GET['action']))			$action = $_GET['action'];
else if (isset($_POST['action']))		$action = $_POST['action'];
else											$action = '';
	
// Login and/or logout.
list($username, $password, $invalid_login) = user_login();
if ($action != 'login') $invalid_login = false;
if ($action == 'logout' || $invalid_login) {
	list($username, $password) = user_logout();
}

// language support
$language = strtolower($language);
$lang_file = BASE.'/languages/'.$language.'.inc.php';

if (file_exists(realpath($lang_file))) {
	unset($lang);
	include($lang_file);
} else {
	exit(error('The requested language "'.$language.'" is not a supported language. Please use the configuration file to choose a supported language.'));
}

if (!isset($getdate)) {
	if (isset($_GET['getdate']) && ($_GET['getdate'] !== '')) {
		$getdate = $_GET['getdate'];
	} else {
		$getdate = date('Ymd', strtotime("now + $second_offset seconds"));
	}
}

if (ini_get('max_execution_time') < 60) {
	@ini_set('max_execution_time', '60');
}

if($_REQUEST['cpath']){
	$cpath 	= $_REQUEST['cpath'];				
	$calendar_path 	.= "/$cpath";				
	$tmp_dir 	.= "/$cpath";				
}

if ($calendar_path == '') {
	$calendar_path = BASE.'calendars';
}

$is_webcal = FALSE;
if (isset($_GET['cal']) && $_GET['cal'] != '') {
	$cal_filename = urldecode($_GET['cal']);
} else {
	
	if (isset($default_cal_check)) {
		
		if ($default_cal_check != $ALL_CALENDARS_COMBINED) {
			
			$calcheck = $calendar_path.'/'.$default_cal_check.'.ics';
			$calcheckopen = @fopen($calcheck, "r");
			if ($calcheckopen == FALSE) {
				$cal_filename = $default_cal;
			} else {
				$cal_filename = $default_cal_check;
			}
		} else {
			$cal_filename = $ALL_CALENDARS_COMBINED;
		}
	} else {
		$cal_filename = $default_cal;
	}
}

if (substr($cal_filename, 0, 7) == 'http://' || substr($cal_filename, 0, 8) == 'https://' || substr($cal_filename, 0, 9) == 'webcal://') {
	$is_webcal = TRUE;
	$cal_webcalPrefix = str_replace('http://','webcal://',$cal_filename);
	$cal_httpPrefix = str_replace('webcal://','http://',$cal_filename);
	$cal_httpsPrefix = str_replace('webcal://','https://',$cal_filename);
	$cal_httpsPrefix = str_replace('http://','https://',$cal_httpsPrefix);
	$cal_filename = $cal_httpPrefix;
}

if ($is_webcal == TRUE) {
	if ($allow_webcals == 'yes' || in_array($cal_webcalPrefix, $list_webcals) || in_array($cal_httpPrefix, $list_webcals) || in_array($cal_httpsPrefix, $list_webcals)) {
		$cal_displayname = substr(str_replace('32', ' ', basename($cal_filename)), 0, -4);
		$cal = urlencode($cal_filename);
		$filename = $cal_filename;
		$subscribe_path = $cal_webcalPrefix;
		// empty the filelist array
		$cal_filelist = array();
		array_push($cal_filelist,$filename);
	} else {
		exit(error($lang['l_error_remotecal'], $_GET['cal']));
	}
} else {
	$cal_displayname = str_replace('32', ' ', $cal_filename);
	$cal = urlencode($cal_filename);
	if (in_array($cal_filename, $blacklisted_cals)) {
		
		exit(error($lang['l_error_restrictedcal'], $cal_filename));
	} else {
		if (!isset($filename)) {
			$cal_filelist = availableCalendars($username, $password, $cal_filename);
			if (count($cal_filelist) == 1) $filename = $cal_filelist[0];
		}
		
		// Sets the download and subscribe paths from the config if present.
		if (isset($filename)) {
			if (($download_uri == '') && (preg_match('/(^\/|\.\.\/)/', $filename) == 0)) {
				$subscribe_path = 'webcal://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF']).'/'."$cpath/".$filename;
				$download_filename = $filename;
			} elseif ($download_uri != '') {
				$newurl = eregi_replace("^(http://)", "", $download_uri); 
				$subscribe_path = 'webcal://'.$newurl.'/'."$cpath/".$cal_filename.'.ics';
				$download_filename = $download_uri.'/'."$cpath/".$cal_filename.'.ics';
			} else {
				$subscribe_path = "$cpath/";
				$download_filename = "$cpath/";
			}
		}
	}
}

$rss_powered = ($enable_rss == 'yes') ? 'yes' : '';

function getmicrotime() { 
	list($usec, $sec) = explode(' ',microtime()); 
	return ((float)$usec + (float)$sec); 
}

?>
