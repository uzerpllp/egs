<?php


// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Calendar Class 1.0               |
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
// | 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA               |
// +----------------------------------------------------------------------+
// | Author: Jake Stride <jake.stride@senokian.com>                       |
// +----------------------------------------------------------------------+
// | 1.0                                                                  |
// | ===                                                                  |
// | First Stable Release                                                 |
// +----------------------------------------------------------------------+

class calendar {
	/**
	 * constructor
	 */
	function calendar() {
		/* Bring in the DB */
		global $db;
		$this->db = $db;
	}
	
	/**
	 * Checks to see if the current user has write-access to $user's calendar
	 * 
	 * @return boolean
	 */
	function writeAccess($user, $id = '') {

		if ($id == '') {
			//this is a new event
			if ($user == EGS_USERNAME) {
				/*users can write to their own calendar...*/
				return true;
			}
			/*if the user is an 'allowusername' then they can write to the calendar*/
			$query = 'SELECT allowusername FROM eventaccess WHERE username='.$this->db->qstr($user);
			$allowed = $this->db->GetOne($query);
			if ($allowed == EGS_USERNAME) {
				return true;
			}

		}
		/*if the event is being edited*/
		
		$query = 'SELECT username FROM event2 WHERE id='.$this->db->qstr($id);
		$username = $this->db->GetOne($query);

		if ($username == EGS_USERNAME) {
			/*users can edit their own events...*/
			return true;
		} else {
			/*noone but the owner can edit private events*/
			$q = 'SELECT private FROM event2 WHERE id='.$this->db->qstr($id);
			if ($this->db->GetOne($q) == 't')
				return false;
			
			/*if the user is an alloweduser, then can edit the event*/
			$query = 'SELECT allowusername FROM eventaccess WHERE username='.$this->db->qstr($username);
			if ($this->db->GetOne($query) == EGS_USERNAME)
				return true;
			else
				/*and finally, adminUsers can edit everything that's not private*/
				return $this->adminUser();
		}
	/*never gets here*/
		
	}
	
	/**
	 * returns the admin-status of the current user
	 * 
	 * @return boolean
	 */
	function adminUser() {
		$query = 'SELECT username FROM useraccess WHERE username='.$this->db->qstr(EGS_USERNAME).' AND calendaradmin';

		if ($this->db->GetOne($query) === false)
			return false;
		else
			return true;
	}

	/**
	 * Saves an event
	 * This function saves the event to the database, but also calls outputs a new .ics file
	 * Returns false on any failure (and rolls back), or the event-id on success
	 * 
	 * @see outputCelandar()
	 * @return mixed
	 */
	function saveEvent($_POST, $id = '') {
		global $smarty;
		
		if (isset ($_POST['company']))
			unset ($_POST['company']);
		if (isset ($_POST['person']))
			unset ($_POST['person']);
		if (isset ($_POST['dtstart']) && isset ($_POST['dtstarthour']) && isset ($_POST['dtstartminute']))
			$_POST['dtstart'] = $_POST['dtstart'].' '.$_POST['dtstarthour'].':'.$_POST['dtstartminute'];
		if (isset ($_POST['dtend']) && isset ($_POST['dtendhour']) && isset ($_POST['dtendminute'])) {
			$_POST['dtend'] = $_POST['dtend'].' '.$_POST['dtendhour'].':'.$_POST['dtendminute'];
		}
		if (isset ($_POST['alarm']) && isset ($_POST['alarmhour']) && isset ($_POST['alarmminute']))
			$_POST['alarm'] = $_POST['alarm'].' '.$_POST['alarmhour'].':'.$_POST['alarmminute'];
		/* If no end date is set we will set it an hour after the end */
		if (!isset ($_POST['dtend']) && isset ($_POST['dtstart']) && isset ($_POST['dtstarthour']) && isset ($_POST['dtstartminute'])) {
			$_POST['dtend'] = date('Y-m-d H:i', (strtotime($_POST['dtstart']) + 3600));
			$_POST['dtendhour'] = sprintf("%02d", ($_POST['dtstarthour'] + 1) % 24);
			$_POST['dtendminute'] = $_POST['dtstartminute'];
		}
		/* An array to hold the event details */
		$event = array ();

		/* An array to hold the error messages if any are produced */
		$errors = array ();
		if (!isset ($_POST['dtstarthour']) || !isset ($_POST['dtstartminute']) || $_POST['dtstarthour'] < 0 || $_POST['dtstarthour'] > 23 || $_POST['dtstartminute'] < 0 || $_POST['dtstartminute'] > 59) {
			$errors[] = _('Please Enter a Valid Start Time');
			unset ($_POST['dtstart']);
			unset ($_POST['dtstarthour']);
			unset ($_POST['dtstartminute']);
		}
		if (isset ($_POST['dtendhour']) && ($_POST['dtendhour'] < 0 || $_POST['dtendhour'] > 23) || isset ($_POST['dtendminute']) && ($_POST['dtendminute'] < 0 || $_POST['dtendminute'] > 59)) {
			$errors[] = _('Please Enter a Valid End Time');
			unset ($_POST['dtend']);
			unset ($_POST['dtendhour']);
			unset ($_POST['dtendminute']);
		}

		if (isset ($_POST['dtstart']))
			$start = strtotime($_POST['dtstart']);
		else
			$start = -1;

		if (isset ($_POST['dtend']))
			$end = strtotime($_POST['dtend']);
		else
			$end = -1;

		if (isset ($_POST['deadline']))
			$deadline = strtotime($_POST['deadline']);

		if (isset ($_POST['company']))
			unset ($_POST['company']);

		/* Check a summary has been added */
		if (!isset ($_POST['summary'])) {
			$errors[] = _('Please enter a summary for the event');
		}

		/* Check the start date is valid */
		if (($start === -1) || !isset ($_POST['dtstart'])) {
			$errors[] = _('The start date you have entered is invalid');
		}

		/* Check the end date is valid */
		if (($end === -1) || !isset ($_POST['dtend'])) {
			$errors[] = _('The end date you have entered is invalid');
		}

		/* Check the end date is after the start date */
		if ($end <= $start) {
			$errors[] = _('The end date is before the start date');
		}
		if ($this->writeAccess($_POST['username'], $id) == false) {
			$errors[] = _('You Do Not Have Access to Edit this User\'s Calendar');
		}
		/* Check the deadline */
		if (isset ($_POST['recurrance']) && isset ($deadline) && (($deadline === -1) || ($deadline <= $end))) {
			$errors[] = _('The end date for the event recurrance is invalid');
		}
		/* If there are no errors we are ok to save */
		if (sizeof($errors) == 0) {
			$this->db->StartTrans();

			if ($id != null)
				$mode = 'UPDATE';
			else
				$mode = 'INSERT';

			if ($mode == 'INSERT')
				$event['id'] = $this->db->GenID('event2_id_seq');
			else
				$event['id'] = $_POST['id'];

			$event['dtstart'] = $_POST['dtstart'];
			$event['dtend'] = $_POST['dtend'];

			if (isset ($_POST['allday']))
				$event['allday'] = 'true';
			else
				$event['allday'] = 'false';

			$event['summary'] = $_POST['summary'];
			if (isset ($_POST['description']))
				$event['description'] = $_POST['description'];
			if (isset ($_POST['location']))
				$event['location'] = $_POST['location'];
			if (isset ($_POST['url']))
				$event['url'] = $_POST['url'];
			if (isset ($_POST['status']))
				$event['status'] = $_POST['status'];

			if (isset ($_POST['username']))
				$event['username'] = $_POST['username'];

			if (isset ($_POST['private']))
				$event['private'] = 'true';
			else
				$event['private'] = 'false';
			if (isset ($_POST['recurrance'])) {
				$event['r_freq'] = strtoupper($_POST['recurrance']);

				if (isset ($_POST['r_count']))
					$event['r_count'] = $_POST['r_count'];
				if (isset ($_POST['deadline']))
					$event['r_until'] = $_POST['deadline'];

				if ($_POST['recurrance'] == 'monthly')
					$event['r_bymonthday'] = date('j', strtotime($_POST['dtstart']));

				$event['r_interval'] = 1;
			} else
				if ($mode != 'INSERT') {
					$event['r_freq'] = '';
					//$event['r_count'] = null;
					$event['r_until'] = '';
					$event['r_bymonthday'] = '';
				}

			if (isset ($event['r_count']) && $event['r_count'] == '')
				unset ($event['r_count']);
			if (isset ($event['r_interval']) && $event['r_interval'] == '')
				unset ($event['r_interval']);
			if (isset ($event['r_until']) && $event['r_until'] == '')
				unset ($event['r_until']);
			if (isset ($_POST['r_byday']))
				$event['r_byday'] = $_POST['r_byday'];
			else
				$event['r_byday'] = '';
			if (isset ($_POST['r_wkst']))
				$event['r_wkst'] = $_POST['r_wkst'];
			else
				$event['r_wkst'] = '';
			if (isset ($_POST['r_bymonthday']))
				$event['r_bymonthday'] = $_POST['r_bymonthday'];
			else
				$event['r_bymonthday'] = '';
			if (isset ($_POST['companyid']))
				$event['companyid'] = $_POST['companyid'];
			if (isset ($_POST['usercompanyid']) && $this->adminUser())
				$event['usercompanyid'] = EGS_COMPANY_ID;

			

			if (!$this->db->Replace('event2', $event, array ('id'), true)) {
				$errors[] = _('Error saving event');

			}
			$users = array ();
			if (isset ($_POST['participants']) && sizeof($_POST['participants']) > 0) {
				if(isset($event['id'])) {
					$query='DELETE FROM eventparticipants WHERE eventid='.$event['id'];
					$rs=$this->db->Execute($query);
				}
				$query = 'INSERT INTO eventparticipants VALUES (?,?)';
				
				$stmt = $this->db->Prepare($query);

				//$users = array();

				while ($participant = array_shift($_POST['participants'])) {

					if(!$this->db->Execute($stmt, array ($event['id'], $participant)))
						$errors[]=_('Error adding particpant: ').$participant;
					$query='SELECT owner FROM person WHERE id='.$this->db->qstr($participant).' AND userdetail';
					$username=$this->db->GetOne($query);
					$query = 'SELECT username FROM useraccess WHERE companyid='.$this->db->qstr(EGS_COMPANY_ID).' AND username='.$this->db->qstr($username);
					$user = $this->db->GetOne($query);
					if ($user !== false)
						$users[] = $user;
				}
			}

			$this->db->CompleteTrans();

			if (isset ($event['usercompanyid'])) {
				$this->outputCalendar('group', 'group');
			} else {
				while ($user = array_shift($users)) {
					$this->outputCalendar($user, '');
					$this->outputCalendar($user, 'public');
					$this->outputCalendar($user, 'private');
				}

				$this->outputCalendar($_POST['username'], '');
				$this->outputCalendar($_POST['username'], 'public');
				$this->outputCalendar($_POST['username'], 'private');
			}
		}

		/* If there are no errors return true and set success message */
		if (sizeof($errors) == 0) {
			$messages = array ();
			if ($mode == 'INSERT')
				$messages[] = _('Event Successfully Added');
			else
				$messages[] = _('Event Successfully Updated');

			$smarty->assign('messages', $messages);
			return $event['id'];
		} else {
			$smarty->assign('errors', $errors);
			return false;
		}
	}
	/**
	 * Deletes an event
	 * 
	 * Also outputs the .ics file
	 * 
	 * @see outputCalendar()
	 * @return boolean
	 */
	function deleteEvent($id) {
		global $smarty;
		if ($this->writeAccess('', $id)) {
			$username = $this->db->GetOne('SELECT username FROM event2 WHERE id='.$this->db->qstr($id));

			$query = 'DELETE FROM event2 WHERE id='.$this->db->qstr($id);

			$this->db->Execute($query);

			$smarty->assign('messages', array (_('Event successfully Deleted.')));

			$this->outputCalendar($username, '');
			$this->outputCalendar($username, 'public');
			$this->outputCalendar($username, 'private');

			return true;
		} else {
			$smarty->assign('errors', array (_('You do not have the correct permissions to delete this event. If you beleive you should please contact your system administrator.')));

			return true;
		}
	}
	/**
	 * output a .ics file for a given username/type combination
	 */
	function outputCalendar($username, $type = 'private') {
		$calendar_path = EGS_FILE_ROOT.'/modules/calendar/calendars/'.EGS_COMPANY_ID.'/';

		if (!is_dir($calendar_path)) {
			mkdir($calendar_path);
		}

		if ($type != 'group')
			$username = strtolower($username);
		else {
			$username = 'GROUP';
			$type = '';
		}

		if (file_exists($calendar_path.$type.$username.'.ics'))
			unlink($calendar_path.$type.$username.'.ics');

		if ($type != 'projects') {
			$query = "
					SELECT DISTINCT e.*, date_trunc('seconds', e.dtstamp) AS dtstamp, CASE WHEN ((date_part('day', age(e.dtend,e.dtstart)) > 0) OR e.allday) THEN (e.dtend + interval'24 hours') ELSE e.dtend END AS dtend, date_part('day', age(e.dtend,e.dtstart)) AS day, date_part('hour', age(e.dtend,e.dtstart)) AS hour, date_part('minute', age(e.dtend,e.dtstart)) AS min FROM event2 e";

			if ($username != 'GROUP')
				$query .= " LEFT OUTER JOIN eventparticipants ep ON (e.id=ep.eventid) LEFT OUTER JOIN person p ON (ep.personid=p.id AND p.userdetail)";

			if (($username == 'GROUP') && ($type == ''))
				$query .= ' WHERE e.usercompanyid='.$this->db->qstr(EGS_COMPANY_ID);
			else
				$query .= ' WHERE e.username='.$this->db->quote($username).' OR (p.owner='.$this->db->quote($username).' AND p.userdetail)';

			$query .= " ORDER BY e.dtstart ASC
					";

		} else {
			$query = 'SELECT \'PROJECTS\' ||p.id AS id, p.added AS dtstamp, date_trunc(\'seconds\', p.startdate) AS dtstart, date_trunc(\'seconds\', p.enddate) + interval \'24 hours\' AS dtend, true AS allday, p.name AS summary, p.description, null AS location, p.url, null AS status, '.$this->db->qstr(EGS_USERNAME).' AS username, true AS private, null AS parentid, null AS r_freq, null AS r_interval, null AS r_count, null AS r_until, null AS r_byday, null AS r_wkst, null AS r_bymonthday, null AS companyid, '.$this->db->qstr(EGS_COMPANY_ID).' AS usercompanyid,  date_part(\'day\', age(p.enddate, p.startdate)) AS day, date_part(\'hour\', age(p.enddate,p.startdate)) AS hour, date_part(\'minute\', age(p.enddate,p.startdate)) AS min FROM project p, projectaccess a WHERE p.completed<>true AND p.id=a.projectid AND a.companyid='.$this->db->qstr(EGS_COMPANY_ID).' AND a.username='.$this->db->qstr(EGS_USERNAME);
			$query .= 'UNION SELECT \'TASK\' ||t.id AS id, t.added AS dtstamp, date_trunc(\'seconds\', t.startdate) AS dtstart, date_trunc(\'seconds\', t.enddate) + interval \'24 hours\' AS dtend, true AS allday, p.name || \' - \' || t.name AS summary, t.description, null AS location, null AS url, null AS status, '.$this->db->qstr(EGS_USERNAME).' AS username, true AS private, null AS parentid, null AS r_freq, null AS r_interval, null AS r_count, null AS r_until, null AS r_byday, null AS r_wkst, null AS r_bymonthday, null AS companyid, '.$this->db->qstr(EGS_COMPANY_ID).' AS usercompanyid,  date_part(\'day\', age(t.enddate, t.startdate)) AS day, date_part(\'hour\', age(t.enddate,t.startdate)) AS hour, date_part(\'minute\', age(t.enddate,t.startdate)) AS min FROM project p, projecttask t, projectaccess a, resource r, projecttaskresources ptr WHERE r.personid='.$this->db->qstr(EGS_PERSON_ID).' AND ptr.resourceid=r.id AND ptr.taskid=t.id AND t.projectid=p.id AND t.projectid=a.projectid AND a.companyid='.$this->db->qstr(EGS_COMPANY_ID).' AND t.progress<100 AND a.username='.$this->db->qstr(EGS_USERNAME);
		}

		$result = $this->db->Execute($query);

		if ($username == 'GROUP')
			$usersName = _('Group Events');
		else
			if ($type == 'projects')
				$usersName = _('Projects and Tasks');
			else {
				$query = 'SELECT firstname || \' \' || surname AS name FROM person WHERE owner='.$this->db->qstr($username).' AND userdetail';

				$usersName = $this->db->GetOne($query);
			}

		$egsHeader = false;
		$sequence = 1;

		$egsCal = "BEGIN:VCALENDAR
			CALSCALE:GREGORIAN
			X-WR-TIMEZONE:Europe/London
			METHOD:PUBLISH
			PRODID:-//EGS Calendar//iCal 1.0//EN
			X-WR-CALNAME:{$usersName}
			VERSION:2.0
			BEGIN:VTIMEZONE
			LAST-MODIFIED:".date("Ymd\THis\Z", time())."
			TZID:Europe/London
			BEGIN:DAYLIGHT
			DTSTART:".date("Ymd\THis", time())."
			TZOFFSETTO:+0000
			TZNAME:BST
			TZOFFSETFROM:+0000
			END:DAYLIGHT
			END:VTIMEZONE
			";

		while (!$result->EOF) {
			$row = $result->fields;
			/* Strip html/php */
			while (list ($key, $val) = each($row)) {
				$row[$key] = stripslashes(trim($row[$key]));
			}

			$egsCal .= "BEGIN:VEVENT
					SEQUENCE:".$sequence ++."
					DTSTAMP:".date("Ymd\THis\Z", strtotime($row['dtstart']))."
					SUMMARY:{$row['summary']}
					";
			if ($row['url'] != "") {
				$egsCal .= "URL;VALUE=URI:http://{$row['url']}
							";
			}

			$egsCal .= "LOCATION:{$row['location']}
					";

			if ($row['allday'] == "t") {
				$egsCal .= "DTSTART;VALUE=DATE:".date("Ymd", strtotime($row['dtstart']))."
							DTEND;VALUE=DATE:".date("Ymd", strtotime($row['dtend']));
			} else {
				$egsCal .= "DTSTART;TZID=Europe/London:".date("Ymd\THis", strtotime($row['dtstart']));
				if ($row['day'] != '0') {
					$egsCal .= "
									DTEND;TZID=Europe/London:".date("Ymd\THis", strtotime($row['dtend']));
				}
			}

			$egsCal .= "
					STATUS:{$row['status']}
					UID:".strtotime($row['dtstamp'])."//{$row['id']}//".$_SERVER['SERVER_NAME']."//".$username;
			if ($row['day'] == "0") {
				$egsCal .= "
							DURATION:PT{$row['hour']}H";

				if ($row['min'] != "00") {
					$egsCal .= "{$row['min']}M";
				}
			}

			if ($row['r_freq'] != "") {
				$egsCal .= "
							RRULE:FREQ={$row['r_freq']};INTERVAL={$row['r_interval']}";
			}

			if ($row['r_count'] != "") {
				$egsCal .= ";COUNT={$row['r_count']}";
			}

			if ($row['r_until'] != "") {
				$egsCal .= ";UNTIL=".date("Ymd\THis\Z", strtotime($row['r_until']));
			}

			if ($row['r_bymonthday']) {
				$egsCal .= ";BYMONTHDAY=".$row['r_bymonthday'];
			}

			$egsCal .= "
					";

			if ($type != 'projects') {
				$query = "
						SELECT (p.firstname || ' ' || p.surname) AS name, m.contact AS email
						FROM person p, eventparticipants e, personcontactmethod m
						WHERE
						(
						 p.id=m.personid AND
						 m.type='E' AND
						 m.main=true AND 
						 p.id=e.personid AND
						 e.eventid={$row['id']}
						)";
			} else {
				if ($row['id'] { 0 }
					== 'P')
					$query = 'SELECT(p.firstname || \' \' || p.surname) AS name, p.email FROM personoverview p, projecttaskresources r, resource tr, projecttask t WHERE p.id=tr.personid AND tr.id=r.resourceid AND r.taskid=t.id AND t.projectid='.$this->db->qstr(str_replace('PROJECTS', '', $row['id']));
				else
					$query = 'SELECT(p.firstname || \' \' || p.surname) AS name, p.email FROM personoverview p, projecttaskresources r, resource tr, projecttask t WHERE p.id=tr.personid AND tr.id=r.resourceid AND r.taskid=t.id AND t.id='.$this->db->qstr(str_replace('TASK', '', $row['id']));
			}

			$result2 = $this->db->Execute($query);

			while (!$result2->EOF) {
				$row2 = $result2->fields;

				/* Strip html/php */
				while (list ($key, $val) = each($row2)) {
					$row2[$key] = stripslashes(trim($row2[$key]));
				}

				$egsCal .= "ATTENDEE;CN=\"{$row2['name']}\":";
				if ($row2['email'] == "")
					$egsCal .= "invalid:nomail";
				else
					$egsCal .= "mailto:{$row2['email']}";

				$egsCal .= "
							";

				$result2->MoveNext();
			}
			if (isset ($calendarprivate) && ($calendarprivate != "") && ($row['private'] == "t"))
				$row['private'] = "PRIVATE";
			else
				$row['private'] = "PUBLIC";

			$egsCal .= "DESCRIPTION:{$row['description']}
					CLASS:{$row['private']}
					END:VEVENT
					";
			$result2->free();

			$result->MoveNext();
		}

		$result->free();

		if (($type != 'public') && ($type != 'projects')) {

			$query = "
					SELECT *, date_trunc('seconds', dtstamp) AS dtstamp, date_trunc('seconds', completed) AS completed FROM todo 
					WHERE username=".$this->db->qstr($username)."
					ORDER BY deadline ASC
					";

			$result = $this->db->Execute($query);

			while (!$result->EOF) {
				$row = $result->fields;
				/* Strip html/php */
				while (list ($key, $val) = each($row)) {
					$row[$key] = stripslashes(trim($row[$key]));
				}
				$egsCal .= "BEGIN:VTODO
							SEQUENCE:".$sequence ++."
							DTSTAMP:".date("Ymd\THis\Z", strtotime($row['dtstamp']))."
							SUMMARY:{$row['summary']}
							";
				if ($row['url'] != "") {
					$egsCal .= "URL;VALUE=URI:http://{$row['url']}
									";
				}
				if (isset ($row['location']))
					$egsCal .= "LOCATION:{$row['location']}";

				if ($row['deadline'] != "") {
					$egsCal .= "
									DUE;VALUE=DATE:".date("Ymd", strtotime($row['deadline']));
				}

				$egsCal .= "
							DTSTART;TZID=Europe/London:".date("Ymd\THis", strtotime($row['dtstamp']));

				if ($row['completed'] != "") {
					$egsCal .= "
									STATUS:COMPLETED
									COMPLETED:".date("Ymd\THis\Z", strtotime($row['completed']));
				}

				$egsCal .= "
							UID:".strtotime($row['dtstamp'])."//{$row['id']}//".$_SERVER['SERVER_NAME']."
							PRIORITY:".intval($row['priority'])."
							DESCRIPTION:{$row['description']}
							END:VTODO
							";

				$result->MoveNext();
			}
			$result->free();
		}

		$egsCal .= "END:VCALENDAR
			";

		$filename = $calendar_path.$type.$username.".ics";

		if (!$handle = fopen($filename, 'a')) {
			echo "Cannot open file ($filename)";
			exit;
		}

		// Write $somecontent to our opened file.
		if (fwrite($handle, $egsCal) === FALSE) {
			echo "Cannot write to file ($filename)";
			exit;
		}
		$q = 'SELECT companyid FROM useraccess WHERE username='.$this->db->qstr(EGS_USERNAME).' AND companyid<>'.$this->db->qstr(EGS_COMPANY_ID);
		if ($this->db->GetOne($q)) {
			$rs = $this->db->Execute($q);
			while (!$rs->EOF) {
				$calendar_path = EGS_FILE_ROOT.'/modules/calendar/calendars/'.$rs->fields['companyid'].'/';

				if (is_dir($calendar_path)) {
					$filename = $calendar_path.$type.$username.".ics";

					if (file_exists($filename))
						unlink($filename);
				}
				$rs->MoveNext();
			}

		}
		fclose($handle);
	}
}
?>
