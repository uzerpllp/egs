<?php


// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - MOTD Admin 1.0                   |
// +----------------------------------------------------------------------+
// | Copyright (c) 2002-2005 Jake Stride                                  |
// +----------------------------------------------------------------------+
// | This file is part of EGS.                                            |
// |                                                                      |
// | EGS is free software; you can redistribute it and/or modify it under |
// | the terms of the GNU General Public License as published by the Free |
// | Software Foundation; either version 2 of the License, or (at your    |
// | option) any later version.                                           |
// |                                                                      |
// | EGS is distributed in the hope that it will be useful, but WITHOUT   |
// | ANY WARRANTY; without even the implied warranty of MERCHANTABILITY   |
// | or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public     |
// | License for more details.                                            |
// |                                                                      |
// | You should have received a copy of the GNU General Public License    |
// | along with EGS; if not, write to the Free Software Foundation, Inc., |
// |
// | 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA               |
// +----------------------------------------------------------------------+
// | Author: Jake Stride <jake.stride@senokian.com>                       |
// +----------------------------------------------------------------------+
// | Changes:                                                             |
// |                                                                      |
// | 1.0                                                                  |
// | ===                                                                  |
// | Initial Stable Release                                               |
// +----------------------------------------------------------------------+
//

/*handle deleting messages and completing activities*/
if (isset ($_GET['do']) && ($_GET['do'] == 'deletemessage') && isset ($_GET['id']))
	$egs->DeleteMessage($_GET['id']);
else
	if (isset ($_GET['do']) && ($_GET['do'] == 'completeactivity') && isset ($_GET['id'])) {
		require_once (EGS_FILE_ROOT.'/src/classes/class.crm.php');

		$crm = new crm();
		$crm->completeActivity($_GET['id']);

	}

$smarty->assign('homePage', true);

/*always show the message of the day*/
$motd = nl2br($db->GetOne('SELECT body FROM news WHERE motd AND domainid IS NULL AND companyid='.$db->qstr(EGS_COMPANY_ID)));

if ($motd != '') {
	$smarty->assign('showMOTD', true);
	$smarty->assign('motd', $motd);
}

/*if the user hasn't chosen any panels to show, then show them all*/
if (!isset ($_SESSION['preferences']['homePreferences']) || !is_array($_SESSION['preferences']['homePreferences'])) {
	$_SESSION['preferences']['homePreferences'] = array ();
	$_SESSION['preferences']['homePreferences'][] = 'messages';
	$_SESSION['preferences']['homePreferences'][] = 'news';
	$_SESSION['preferences']['homePreferences'][] = 'announcements';
	$_SESSION['preferences']['homePreferences'][] = 'open_tickets';
	$_SESSION['preferences']['homePreferences'][] = 'projects';
	$_SESSION['preferences']['homePreferences'][] = 'domains';
	$_SESSION['preferences']['homePreferences'][] = 'pipeline';
	$_SESSION['preferences']['homePreferences'][] = 'opportunities';
	$_SESSION['preferences']['homePreferences'][] = 'activities';
	$_SESSION['preferences']['homePreferences'][] = 'events';
	$_SESSION['preferences']['homePreferences'][] = 'to_do';
}
$_SESSION['preferences']['homePreferences']=array_flip(array_flip($_SESSION['preferences']['homePreferences']));
if(in_array('announcements',$_SESSION['preferences']['homePreferences'])&&!in_array('news',$_SESSION['preferences']['homePreferences'])) {
	$_SESSION['preferences']['homePreferences'][]='news';
}
if(in_array('to_do',$_SESSION['preferences']['homePreferences'])&&!in_array('events',$_SESSION['preferences']['homePreferences'])) {
	$_SESSION['preferences']['homePreferences'][]='events';
}
/*show messages*/
if ((EGS_COMPANY_ID == EGS_ACTUAL_COMPANY_ID) && (isset ($_SESSION['preferences']['homePreferences']) && in_array('messages', $_SESSION['preferences']['homePreferences']))) {
	$rs = $db->Execute('SELECT m.id, m.message,'.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 'm.leftwhen').' AS leftwhen, m.leftby, m.personid, p.firstname || \' \' || p.surname AS personname FROM message m LEFT OUTER JOIN person p ON (m.personid=p.id) WHERE m.companyid='.$db->qstr(EGS_COMPANY_ID).' AND leftfor='.$db->qstr(EGS_USERNAME).' ORDER BY m.leftwhen ASC');

	$messages = array ();

	while (!$rs->EOF) {
		$rs->fields['message'] = nl2br(trim($rs->fields['message']));
		$messages[] = $rs->fields;

		$rs->MoveNext();
	}

	$smarty->assign('userMessages', $messages);
	$smarty->assign('showMessages', true);
}

/* Get news items */
if (isset ($_SESSION['preferences']['homePreferences']) && in_array('news', $_SESSION['preferences']['homePreferences'])) {
	$query = 'SELECT n.id, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'n.published').' AS publisheddate, n.headline FROM news n LEFT OUTER JOIN domain d ON (n.domainid=d.id) WHERE n.companyid='.$db->qstr(EGS_COMPANY_ID).' AND n.news=true AND n.motd=false AND ((n.domainid IS NULL) OR (d.companyid='.$db->qstr(EGS_COMPANY_ID).')) AND n.visible AND (n.showfrom<=now() OR n.showfrom IS NULL) AND (n.showuntil>=now() OR n.showuntil IS NULL) ORDER BY n.published DESC LIMIT 10';

	$rs = $db->Execute($query);

	$news = array ();

	while ($rs && !$rs->EOF) {
		$news[$rs->fields['id']]['published'] = $rs->fields['publisheddate'];
		$news[$rs->fields['id']]['headline'] = stripslashes($rs->fields['headline']);

		$rs->MoveNext();
		$smarty->assign('showNews', true);
	}

	if (sizeof($news) > 0)
		$smarty->assign('news', $news);
}

/* Get announcements */
if (isset ($_SESSION['preferences']['homePreferences']) && in_array('announcements', $_SESSION['preferences']['homePreferences'])) {
	$query = 'SELECT n.id, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'n.published').' AS publisheddate, n.headline FROM news n LEFT OUTER JOIN domain d ON (n.domainid=d.id) WHERE n.companyid='.$db->qstr(EGS_COMPANY_ID).' AND n.news=false AND n.motd=false AND n.domainid IS NULL AND n.visible=true AND (showfrom<=now() OR showfrom IS NULL) AND (n.showuntil>=now() OR n.showuntil IS NULL) ORDER BY n.published DESC LIMIT 10';

	$rs = $db->Execute($query);

	$announcements = array ();

	while ($rs && !$rs->EOF) {
		$announcements[$rs->fields['id']]['published'] = $rs->fields['publisheddate'];
		$announcements[$rs->fields['id']]['headline'] = $rs->fields['headline'];

		$rs->MoveNext();
	}

	if (sizeof($announcements) > 0)
		$smarty->assign('announcements', $announcements);
	$smarty->assign('showAnnouncements', true);
}
/*show tickets*/
if (isset ($_SESSION['preferences']['homePreferences']) && in_array('open_tickets', $_SESSION['preferences']['homePreferences'])) {
	/* If the user has access to the ticket module show all open tickets */
	if(in_array('ticketing', $_SESSION['modules'])) {
	$query ='SELECT t.id, t.queueid,  t.subject FROM ticket t , ticketqueue q WHERE'.
			'('.
				'(owner='.$db->qstr(EGS_USERNAME).' AND t.status<>'.$db->qstr('DEL').' AND t.status<>'.$db->qstr('CLO').' AND t.status<>'.$db->qstr('FIX').' AND t.status<>'.$db->qstr('WON').')'.
				' OR status='.$db->qstr('CRE').
			')'.
			' AND (t.personid<>'.$db->qstr(EGS_PERSON_ID).' OR t.personid IS NULL)'.
			' AND parentticketid IS NULL'.
			' AND t.queueid=q.id AND q.companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY t.id';
			
			
			$query = '('.
			'SELECT t.id, t.queueid,  t.subject FROM ticket t, ticketqueue q, 	queueaccess qa WHERE'.
			'('.
				'(owner='.$db->qstr(EGS_USERNAME).' AND t.status<>'.$db->qstr('DEL').' AND t.status<>'.$db->qstr('CLO').' AND t.status<>'.$db->qstr('FIX').' AND t.status<>'.$db->qstr('WON').')'.
				' OR status='.$db->qstr('CRE').
			')'.
			' AND (t.personid<>'.$db->qstr(EGS_PERSON_ID).' OR t.personid IS NULL)'.
			' AND parentticketid IS NULL AND t.internalqueueid IS NULL'.
			' AND t.queueid=q.id AND t.queueid=qa.queueid AND qa.username='.$db->qstr(EGS_USERNAME).' AND q.companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY t.id'.
			')'.
			'UNION'.
			'('.
			'SELECT t.id, t.queueid,  t.subject FROM ticket t , ticketqueue q, internalqueueaccess qa WHERE'.
			'('.
				'(owner='.$db->qstr(EGS_USERNAME).' AND t.status<>'.$db->qstr('DEL').' AND t.status<>'.$db->qstr('CLO').' AND t.status<>'.$db->qstr('FIX').' AND t.status<>'.$db->qstr('WON').')'.
				' OR status='.$db->qstr('CRE').
			')'.
			' AND (t.personid<>'.$db->qstr(EGS_PERSON_ID).' OR t.personid IS NULL)'.
			' AND parentticketid IS NULL'.
			' AND t.queueid=q.id AND t.internalqueueid=qa.id AND qa.username='.$db->qstr(EGS_USERNAME).' AND q.companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY t.id'.
			')';
			
			
	/* Else show only the users */
	}
	else {
		$query = 'SELECT t.id, t.queueid,  t.subject FROM ticket t, ticketqueue q WHERE t.status<>'.$db->qstr('DEL').' AND t.status<>'.$db->qstr('CLO').' AND t.status<>'.$db->qstr('FIX').' AND t.status<>'.$db->qstr('WON').' AND t.personid='.$db->qstr(EGS_PERSON_ID).' AND t.queueid=q.id AND q.companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY t.id';
	}
	$rs = $db->Execute($query);

	$tickets = array ();

	while ($rs && !$rs->EOF) {
		$tickets[$rs->fields['id']]['id'] = '['.$rs->fields['queueid'].'-'.$rs->fields['id'].']';
		$tickets[$rs->fields['id']]['subject'] = $rs->fields['subject'];

		$rs->MoveNext();
	}

	if (sizeof($tickets) > 0)
		$smarty->assign('tickets', $tickets);
	$smarty->assign('showOpenTickets', true);
}
/*show projects*/
if (isset ($_SESSION['preferences']['homePreferences']) && in_array('projects', $_SESSION['preferences']['homePreferences'])) {
	$query = 'SELECT DISTINCT p.id, p.jobno, p.name FROM project p, projectaccess a WHERE p.completed<>true AND p.id=a.projectid AND a.companyid='.$db->qstr(EGS_COMPANY_ID).' AND a.username='.$db->qstr(EGS_USERNAME).' ORDER BY p.jobno';

	$rs = $db->Execute($query);

	$projects = array ();

	while ($rs && !$rs->EOF) {
		$projects[$rs->fields['id']]['jobno'] = $rs->fields['jobno'];
		$projects[$rs->fields['id']]['name'] = $rs->fields['name'];

		$rs->MoveNext();
	}

	if (sizeof($projects) > 0)
		$smarty->assign('projects', $projects);
	$smarty->assign('showCurrentProjects', true);
}

/*show the CRM panels*/
if (in_array('crm', $_SESSION['modules'])) {
	/*show the pipeline chart*/
	if (in_array("pipeline", $_SESSION['preferences']['homePreferences'])) {
		$smarty->assign('mypipeline', true);
	}
	/*show opportunities*/
	if (isset ($_SESSION['preferences']['homePreferences']) && in_array("opportunities", $_SESSION['preferences']['homePreferences'])) {
		$query = 'SELECT o.id, o.companyid, o.name, o.cost, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'o.enddate').' AS enddate, c.name AS companyname FROM opportunity o LEFT OUTER JOIN crmopportunity co ON (o.crmstatusid=co.id) LEFT OUTER JOIN company c ON o.companyid=c.id WHERE (o.crmstatusid IS NULL OR co.open) AND o.assigned='.$db->qstr(EGS_USERNAME).' AND o.usercompanyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY o.cost DESC LIMIT 10';

		$rs = $db->Execute($query);

		$opportunities = array ();

		while ($rs && !$rs->EOF) {
			$opportunities[$rs->fields['id']] = $rs->fields;

			$rs->MoveNext();
		}

		$smarty->assign('opportunities', $opportunities);
		$smarty->assign('showOpportunities', true);
	}
	/*show activities*/
	if (isset ($_SESSION['preferences']['homePreferences']) && in_array('activities', $_SESSION['preferences']['homePreferences'])) {
		$query = 'SELECT id, name, activity, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'startdate').' AS startdate, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'enddate').' AS enddate FROM activityoverview WHERE completed IS NULL AND assigned='.$db->qstr(EGS_USERNAME).' AND usercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND (startdate<=now() OR startdate=null)ORDER BY enddate DESC';

		$rs = $db->Execute($query);

		$activities = array ();

		while ($rs && !$rs->EOF) {
			$activities[$rs->fields['id']] = $rs->fields;

			$rs->MoveNext();
		}

		$smarty->assign('activities', $activities);
		$smarty->assign('showActivities', true);
	}
}
/*show the domains*/
if ((EGS_DOMAINADMIN) && (isset ($_SESSION['preferences']['homePreferences']) && in_array('domains', $_SESSION['preferences']['homePreferences']))) {
	$query = 'SELECT d.id, c.id AS companyid, c.name AS companyname, p.id AS personid, p.firstname || \' \' || p.surname AS personname, d.name, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'd.expires').' AS expires, CASE WHEN d.expires <= (now() + \'5 days\') THEN \'red\' WHEN d.expires <= (now() + \'15 days\') THEN \'amber\' ELSE \'green\' END AS when FROM domain d LEFT OUTER JOIN company c ON (d.companyid=c.id) LEFT OUTER JOIN person p ON (d.personid=p.id) WHERE d.expires <= (now() + \'30 days\') AND d.expires >= now() ORDER BY d.expires ASC, d.name';

	$rs = $db->Execute($query);

	$domains = array ();

	while ($rs && !$rs->EOF) {
		$domains[$rs->fields['id']] = $rs->fields;

		$rs->MoveNext();
	}

	$smarty->assign('domains', $domains);
	$smarty->assign('showDomains', true);
}
/*show to-do items*/
if (isset ($_SESSION['preferences']['homePreferences']) && in_array('to_do', $_SESSION['preferences']['homePreferences']) && file_exists(EGS_FILE_ROOT.'/modules/calendar/calendars/'.EGS_COMPANY_ID.'/'.EGS_USERNAME.'.ics')) {

	if (isset ($_COOKIE['phpicalendar'])) {
		$temp = $_COOKIE['phpicalendar'];
		unset ($_COOKIE['phpicalendar']);
	}

	define('BASE', EGS_FILE_ROOT.'/modules/calendar/');
	require_once (EGS_FILE_ROOT.'/modules/calendar/functions/ical_parser.php');
	if (isset ($temp))
		$_COOKIE['phpicalendar'] = $temp;

	global $blacklisted_cals, $template, $getdate, $master_array, $next_day, $timeFormat, $tomorrows_events_lines, $show_completed, $show_todos;
	$todo = array ();

	if (is_array($master_array['-2'])) {

		foreach ($master_array['-2'] as $vtodo_times) {

			foreach ($vtodo_times as $key => $val) {
				$temp = explode('//', $key);
				$uid = $temp[1];

				$vtodo_text = stripslashes(urldecode($val["vtodo_text"]));

				if ($vtodo_text != "") {
					if (isset ($val["description"])) {
						$description = stripslashes(urldecode($val["description"]));
					} else {
						$description = "";
					}
					$completed_date = $val['completed_date'];
					$event_calna = $val['calname'];
					$status = $val["status"];
					$priority = $val['priority'];
					$start_date = $val["start_date"];
					$due_date = $val['due_date'];
					$vtodo_array = array ('cal' => $event_calna, 'completed_date' => $completed_date, 'description' => $description, 'due_date' => $due_date, 'priority' => $priority, 'start_date' => $start_date, 'status' => $status, 'vtodo_text' => $vtodo_text, 'uid' => $uid);
					$orig_array = $vtodo_array;
					$vtodo_array = base64_encode(serialize($vtodo_array));
					$vtodo_text = word_wrap(strip_tags(str_replace('<br />', ' ', $vtodo_text), '<b><i><u>'), 21, $tomorrows_events_lines);
					$data = array ('{VTODO_TEXT}', '{VTODO_ARRAY}');
					$rep = array ($vtodo_text, $vtodo_array);

					// Reset this TODO's category.
					$temp = '';
					if ($status == 'COMPLETED' || (isset ($val['completed_date']) && isset ($val['completed_time']))) {
						if ($show_completed == 'yes') {
							$temp = $completed;
						}
					}
					elseif (isset ($val['priority']) && ($val['priority'] != 0) && ($val['priority'] < 5)) {
						$temp = _('Urgent');
					} else
						if ($val['priority'] == 5) {
							$temp = _('Normal');
						} else {
							$temp = _('Low');
						}

					// Do not include TODOs which do not have the
					// category set.
					if ($temp != '') {
						$nugget1 = str_replace($data, $rep, $temp);
						$nugget2 .= $nugget1;
					}
				}
				$link = 'javascript:openTodoInfo('.$db->qstr($vtodo_array).')';
				$due_date = preg_replace('/(\d{4})(\d{2})(\d{2})/', '$3/$2/$1', $due_date);
				if ($status != 'COMPLETED')
					$todos[] = array ('link' => $link, 'name' => $vtodo_text, 'array' => $vtodo_array, 'deadline' => $due_date, 'priority' => $temp);

			}

		}
	}

	$smarty->assign('todos', $todos);
	$smarty->assign('showTodos', true);

} //end the todos bit

/*show events*/
if (isset ($_SESSION['preferences']['homePreferences']) && in_array('events', $_SESSION['preferences']['homePreferences']) && file_exists(EGS_FILE_ROOT.'/modules/calendar/calendars/'.EGS_COMPANY_ID.'/'.EGS_USERNAME.'.ics')) {

	if (isset ($_COOKIE['phpicalendar'])) {
		$temp = $_COOKIE['phpicalendar'];
		unset ($_COOKIE['phpicalendar']);
	}

	define('BASE', EGS_FILE_ROOT.'/modules/calendar/');

	require_once (EGS_FILE_ROOT.'/modules/calendar/functions/ical_parser.php');
	require_once (EGS_FILE_ROOT.'/modules/calendar/functions/date_functions.php');

	if (isset ($temp))
		$_COOKIE['phpicalendar'] = $temp;

	global $template, $getdate, $master_array, $next_day, $timeFormat, $tomorrows_events_lines, $show_completed, $show_todos;

	/*set the default number of days to show events*/
	if (!is_numeric($_SESSION['preferences']['eventsDisplay']))
		unset ($_SESSION['preferences']['eventsDisplay']);
	if (!isset ($_SESSION['preferences']['eventsDisplay']))
		$_SESSION['preferences']['eventsDisplay'] = 14;

	/*an array to store the table-lines in*/
	$events = array ();
	$today = date('Ymd');
	$tomorrow = strtotime('tomorrow', time());
	$tomorrow = date('Ymd', $tomorrow);

	/*get the events for the next X days*/
	$x = $_SESSION['preferences']['eventsDisplay'];
	for ($i = 0; $i <= $x; $i ++) {
		$stamp = strtotime($i.' days');
		$getdate = date('Ymd', $stamp);

		/*the date_array contains everything happening on getdate, for everyone*/
		$date_array = $master_array[$getdate];
		if (is_array($date_array)) {
			foreach ($date_array as $time => $event_array) {
				/*get to the owner of the event*/
				foreach ($event_array as $event_key => $event_data) {
					$temp = explode('//', $event_key);
					$owner = $temp[3];
					$uid = $temp[1];
					/*also need events where the user is in the attendees list*/
					$attendees = unserialize($event_data['attendee']);
					$show = false;

					if (is_array($attendees) && count($attendees) > 0 && !strpos($event_key, 'PROJECT')) {
						$q = 'select firstname || \' \' || surname as name from personoverview where owner='.$db->qstr(EGS_USERNAME).' and userdetail';
						if ($db->GetOne($q) == trim($attendees[0]['name'], '"')) {
							$show = true;
						}

					}
					
					if ($owner == EGS_USERNAME || $show) {
						if ($time != '-1') {
							/*events with a time are easy*/
							$events[] = array ('getdate' => $getdate,
							 'date' => ($getdate == $today) ? 'Today' : (($getdate == $tomorrow) ? 'Tomorrow' : date('d/m/Y', $stamp)),
							 'end' => substr($event_data['event_end'], 0, 2).':'.substr($event_data['event_end'], 2, 2),
							 'start' => substr($event_data['event_start'], 0, 2).':'.substr($event_data['event_start'], 2, 2),
							 'name' => openevent($getdate, $event_key, $event_data));
						} else {
							/*don't want projects, but all day events are -1 too*/

							if (!strpos($event_key, 'PROJECT')&&!strpos($event_key, 'TASK')) {
								$events[] = array ('getdate' => $getdate,
								 'date' => ($getdate == $today) ? 'Today' : (($getdate == $tomorrow) ? 'Tomorrow' : date('d/m/Y', $stamp)),
								 'allday' => 'yes',
								 'name' => openevent($getdate, $event_key, $event_data));
							}
						}
					}
				}
			}
		}
	}
	$smarty->assign('numdays', $_SESSION['preferences']['eventsDisplay']);
	$smarty->assign('events', $events);
	$smarty->assign('showEvents', true);
} //end if show events


/*for the ordering of items on the home-page*/
$home_ordering=array();
if(!in_array('motd',$_SESSION['preferences']['homePreferences']))$home_ordering[]='motd';
//$home_ordering[]='messages';
foreach($_SESSION['preferences']['homePreferences'] as $item) {
	if(($item=='pipeline'||$item=='activities'||$item=='opportunities') && !in_array('crm', $_SESSION['modules'])) continue;
	if($item=='domains' && !(EGS_DOMAINADMIN))continue;
	if(($item=='events'||$item=='to_do')&&!file_exists(EGS_FILE_ROOT.'/modules/calendar/calendars/'.EGS_COMPANY_ID.'/'.EGS_USERNAME.'.ics'))continue;
	$home_ordering[]=$item;
}
if(in_array('news',$home_ordering)&&in_array('announcements',$home_ordering))
	unset($home_ordering[array_search('news',$home_ordering)]);
if(in_array('events',$home_ordering)&&in_array('to_do',$home_ordering))
	unset($home_ordering[array_search('events',$home_ordering)]);
$smarty->assign('homeOrdering',$home_ordering);
?>
