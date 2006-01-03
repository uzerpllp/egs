<?php 

define('BASE', '../');
include_once(BASE.'config.inc.php');
include_once(BASE.'functions/init.inc.php');
include_once(BASE.'functions/date_functions.php');
require_once(BASE.'functions/template.php');

$vtodo_array = unserialize(base64_decode($_GET['vtodo_array']));

// Set the variables from the array
$vtodo_text		= (isset($vtodo_array['vtodo_text'])) ? $vtodo_array['vtodo_text'] : ('');
$description	= (isset($vtodo_array['description'])) ? $vtodo_array['description'] : ('');
$completed_date	= (isset($vtodo_array['completed_date'])) ? localizeDate ($dateFormat_day, strtotime($vtodo_array['completed_date'])) : ('');
$status			= (isset($vtodo_array['status'])) ? $vtodo_array['status'] : ('');
$calendar_name  = (isset($vtodo_array['cal'])) ? $vtodo_array['cal'] : ('');
$start_date 	= (isset($vtodo_array['start_date'])) ? localizeDate ($dateFormat_day, strtotime($vtodo_array['start_date'])) : ('');
$due_date 		= (isset($vtodo_array['due_date'])) ? localizeDate ($dateFormat_day, strtotime($vtodo_array['due_date'])) : ('');
$priority 		= (isset($vtodo_array['priority'])) ? $vtodo_array['priority'] : ('');

/*from the calendar page, there is no access to the UID, so as a fix, try and find a matching todo in the DB*/
if(!isset($vtodo_array['uid'])||$vtodo_array['uid']=='') {
	$query = 'SELECT id FROM todo WHERE summary='.$db->qstr($vtodo_text).' AND description='.$db->qstr($description).' AND 	username='.$db->qstr(EGS_USERNAME);
	$event_id=$db->GetOne($query);
	
}

$cal_title_full = $calendar_name.' '.$lang['l_calendar'];
$description	= ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]", '<a target="_new" href="\0">\0</a>', $description);
$vtodo_text		= ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]",'<a target="_new" href="\0">\0</a>',$vtodo_text);


if ((!isset($status) || $status == "COMPLETED") && isset($completed_date)) {
	$status = $lang['l_completed_date'] . ' ' . $completed_date;
} elseif ($status == "COMPLETED") {
	$status = $completed_lang;
} else {
	$status = $unfinished_lang;
}

if ($priority >= 1 && $priority <= 4) {
	$priority = $lang['l_priority_high'];
} else if ($priority == 5) {
	$priority = $lang['l_priority_medium'];
} else if ($priority >= 6 && $priority <= 9) {
	$priority = $lang['l_priority_low'];
} else {
	$priority = $lang['l_priority_none'];
}

/*get the event id out of the uid*/

if(isset($vtodo_array['uid'])&&$vtodo_array['uid']!='')$event_id=$vtodo_array['uid'];
$edit_link = EGS_SERVER.'?'.SID.'module=calendar&action=savetodo&id='.$event_id;
$edit_text = _('Edit');
$page = new Page(BASE.'templates/'.$template.'/todo.tpl');
$completed_text = _('Mark Completed');
$completed_link='javascript:markcompleted("'.EGS_SERVER.'src/ajax/completetodo.php?uid='.$event_id.'")';
$page->replace_tags(array(
	'cal' 				=> $cal_title_full,
	'vtodo_text' 		=> $vtodo_text,
	'description' 		=> $description,
	'priority'	 		=> $priority,
	'start_date' 		=> $start_date,
	'status'	 		=> $status,
	'due_date' 		=> $due_date,
	'cal_title_full'	=> $cal_title_full,
	'template'			=> $template,
	'l_created'		=> $lang['l_created'],
	'l_priority'		=> $lang['l_priority'],
	'l_status'			=> $lang['l_status'],
	'l_due'				=> $lang['l_due'],
	'edit_text'		=> $edit_text,
	'edit_link'		=> $edit_link,
	'completed_text'	=> $completed_text,
	'completed_link'	=> $completed_link,
	'todo_id'			=> $event_id,
	'server'			=> EGS_SERVER
		
	));

$page->output();

?>
