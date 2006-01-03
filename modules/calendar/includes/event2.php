<?php 
define('BASE', '../');
$getdate = $_POST['date'];

include_once(BASE.'config.inc.php');

include_once(BASE.'functions/init.inc.php'); 
include_once(BASE.'functions/ical_parser.php'); 
require_once(BASE.'functions/template.php');
	
function decode_popup ($item) {
	$item = stripslashes(rawurldecode($item));
	$item = str_replace('\\','',$item);
	return $item;
}
$temp = explode('//',$_POST['uid']);
$uid=$event_id = $temp[1];

$q = 'SELECT * FROM event2 WHERE id='.$db->qstr($uid);
$event = $db->GetRow($q);
$event2 			= $master_array[$_POST['date']][$_POST['time']][decode_popup($_POST['uid'])];

$organizer 		= unserialize($event['organizer']);
$attendee 		= unserialize($event['attendee']);

// Format event time
// All day
if ($_POST['time'] == -1) {
	$event_times = $lang['l_all_day'];
} else {
	$event_times = date($timeFormat, $event['start_unixtime']) . ' - ' .  date($timeFormat, $event['end_unixtime']); 
}

if ($event['description']) $event['description'] = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]",'<a target="_new" href="\0">\0</a>',$event['description']);

if (is_array($organizer)) {
	$i=0;
	$display .= $organizer_lang . ' - ';
	foreach ($organizer as $val) {	
		$organizers .= $organizer[$i]["name"] . ', ';
		$i++;
	}
	$organizer = substr($organizers,0,-2);
}
if (is_array($attendee)) {
	$i=0;
	$display .= $attendee_lang . ' - ';
	foreach ($attendee as $val) {	
		$attendees .= $attendee[$i]["name"] . ', ';
		$i++;
	}
	$attendee = substr($attendees,0,-2);
}

if ($event['location']) {
	if ($event['url'] != '') $event['location'] = '<a href="'.$event['url'].'" target="_blank">'.$event['location'].'</a>';
}

if (sizeof($attendee) == 0) $attendee = '';
if (sizeof($organizer) == 0) $organizer = '';

/*get the event id out of the uid*/

$edit_link = EGS_SERVER.'?'.SID.'module=calendar&action=saveevent&id='.$event_id;
$edit_text=_('Edit');
$page = new Page(BASE.'templates/'.$template.'/event.tpl');

$page->replace_tags(array(
	'cal' 				=> $event['calname'],
	'event_text' 		=> urldecode($event['summary']),
	'event_times' 		=> $event_times,
	'description' 		=> urldecode($event['description']),
	'organizer' 		=> $organizer,
	'attendee'	 		=> $attendee,
	'status'	 		=> $event['status'],
	'location' 			=> $event['location'],
	'cal_title_full'	=> $event2['calname'].' '.$lang['l_calendar'],
	'template'			=> $template,
	'l_organizer'		=> $lang['l_organizer'],
	'l_attendee'		=> $lang['l_attendee'],
	'l_status'			=> $lang['l_status'],
	'l_location'		=> $lang['l_location'],
	'edit_text'			=> $edit_text,
	'edit_link'			=> $edit_link
	));

$page->output();

?>
