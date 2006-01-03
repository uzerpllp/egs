<?php
/* This is a hack to stop incorrect viewing of projects calendars */
if(isset($_GET['cal']) && ($_GET['cal'] != 'publicprojects')) $_GET['cal'] = str_replace('publicprojects', 'projects', $_GET['cal']);


/* Report all errors except E_NOTICE
This is the default value set in php.ini for most installations but just to be sure it is forced here
turning on NOTICES destroys things */

error_reporting (E_ALL & ~E_NOTICE);

// Define some magic strings.
$ALL_CALENDARS_COMBINED = 'all_calendars_combined971';
$default_cal = $ALL_CALENDARS_COMBINED;

/* Use a local config file if it exists */
if(file_exists(EGS_FILE_ROOT.'/conf/'.$_SERVER['HTTP_HOST'].'.config.php'))
	require_once(EGS_FILE_ROOT.'/conf/'.$_SERVER['HTTP_HOST'].'.config.php');
else if (file_exists('../../conf/'.$_SERVER['HTTP_HOST'].'.config.php')) {
	require_once ('../../conf/'.$_SERVER['HTTP_HOST'].'.config.php');
}
else if (file_exists(EGS_FILE_ROOT.'/conf/config.php')) {
	require_once EGS_FILE_ROOT.'/conf/config.php';	
	
}
else if (file_exists('../../../conf/'.$_SERVER['HTTP_HOST'].'.config.php')) {
	require_once ('../../../conf/'.$_SERVER['HTTP_HOST'].'.config.php');
}
/* Use the default config file */
else if (file_exists('../../../conf/config.php')) {
	require_once ('../../../conf/config.php');
}
else {
	require_once ('../../conf/config.php');
}

/* Report all errors except E_NOTICE
This is the default value set in php.ini for most installations but just to be sure it is forced here
turning on NOTICES destroys things */

error_reporting (E_ALL & ~E_NOTICE);

/* Include the db connection */
require_once (EGS_FILE_ROOT.'/src/db.php');

/* Include the header file, this sets up most system variables */
require_once (EGS_FILE_ROOT.'/src/header.php');

$calendar_path = EGS_FILE_ROOT.'/modules/calendar/calendars/'.EGS_COMPANY_ID;

require_once (EGS_FILE_ROOT.'/src/classes/class.calendar.php');
$calendar = new calendar();

/* IfF the tasks are not set then add them */
if (in_array('projects', $_SESSION['modules'])) {
	if(!file_exists($calendar_path.'/projects'.EGS_USERNAME.'.ics')) $calendar->outputCalendar(EGS_USERNAME, 'projects');
}

if(isset($_GET['cal']) && ($_GET['cal'] != $ALL_CALENDARS_COMBINED)) {
	$_GET['cal'] = str_replace('public', '', str_replace('private', '', $_GET['cal']));
	$calendaruser = $_GET['cal'];
	
	if (($_GET['cal'] != EGS_USERNAME) && $calendar->writeAccess($_GET['cal']))
		$_GET['cal'] = 'private'.$_GET['cal'];
	else if(($_GET['cal'] != EGS_USERNAME) && ($_GET['cal'] != 'projects'.EGS_USERNAME))
		$_GET['cal'] = 'public'.$_GET['cal'];
}

if(!file_exists($calendar_path.'/public'.EGS_USERNAME.'.ics')) $calendar->outputCalendar(EGS_USERNAME, 'public');
if(!file_exists($calendar_path.'/'.EGS_USERNAME.'.ics')) $calendar->outputCalendar(EGS_USERNAME, '');
/* Put other calendars in black list */
$dh  = opendir($calendar_path);

$blacklisted_cals = array();
/*Select users with access to calendar module*/
$q = 'SELECT gm.username FROM groupmembers gm, groupmoduleaccess gma, module m, groups g WHERE gm.groupid=gma.groupid AND gma.moduleid=m.id AND g.id=gm.groupid AND g.companyid='.$db->qstr(EGS_COMPANY_ID).' AND m.name='.$db->qstr('calendar');

$users = $db->Execute($q);
while(!$users->EOF) {
/*check if calendars exist*/
if (!file_exists($calendar_path.'/'.$users->fields['username'].'.ics')) {
	$calendar->outputCalendar($users->fields['username'],'');
	$calendar->outputCalendar($users->fields['username'],'public');
}
/*if not, create them*/
	
	/* Black list projects for other users */
	if($users->fields['username'] != EGS_USERNAME) $blacklisted_cals[] = 'projects'.$users->fields['username'];
	$users->MoveNext();
}
	

while (false !== ($tmpCalendar = readdir($dh))) {
	$tmpCalendar = explode('.ics', $tmpCalendar);

	if(($tmpCalendar{0} != '.') && ($tmpCalendar{0} != '..')) {
		$tmpUser = str_replace('projects', '', str_replace('public', '', str_replace('private', '', $tmpCalendar[0])));
		
		/*check the user has access to the calendar module for the current company*/
		$displayCal=true;
		$q = 'SELECT gm.username FROM groupmembers gm, groupmoduleaccess gma WHERE gm.groupid=gma.groupid AND gm.username='.$db->qstr($tmpUser);
		
		if(!$db->GetOne($q)) {
			
			$displayCal=false;
		}
		
		if($tmpUser != 'GROUP') {
			if(!$displayCal) {$blacklisted_cals[] = $tmpCalendar[0];}
			if(($tmpUser != EGS_USERNAME) && (substr($tmpCalendar[0],0,6) != 'public')) { $blacklisted_cals[] = $tmpCalendar[0]; }
			if(($tmpUser == EGS_USERNAME) && ((substr($tmpCalendar[0],0,7) == 'private') || (substr($tmpCalendar[0],0,6) == 'public'))) {$blacklisted_cals[] = $tmpCalendar[0];}
		}
	}
	//if((substr($tmpCalendar[0], 0, (6+strlen($calendaruser))) != 'public'.$calendaruser) && (substr($tmpCalendar[0], 0, (7+strlen($calendaruser))) != 'private'.$calendaruser) && ($tmpCalendar[0] != $calendaruser) && ($filename{0} != '.')) $blacklisted_cals[] = $tmpCalendar[0]; 
}

$blacklisted_cals = array_unique($blacklisted_cals);
sort($blacklisted_cals);

if($blacklisted_cals[0] == '') array_shift($blacklisted_cals);
if($blacklisted_cals[0] == '.svn') array_shift($blacklisted_cals);

	//$calendar->outputCalendar($calendaruser, '');
/* If the calendar file does not exist crete it */
if (isset($_GET['cal']) && ($_GET['cal'] != $ALL_CALENDARS_COMBINED) && (!file_exists($calendar_path.'/'.$_GET['cal'].'.ics'))) {
}
?>
