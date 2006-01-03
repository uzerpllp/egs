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

class todo {
	function todo() {
		/* Bring in the DB */
		global $db;
		$this->db = $db;
	}
	
	function writeAccess($user,$id='') {
		if ($user==EGS_USERNAME) return true;
		
		if ($id=='') {
			
		/*not editing*/	
			$q = 'SELECT allowusername FROM eventaccess WHERE username='.$this->db->qstr($user);
			$rs = $this->db->Execute($q);
			while (!$rs->EOF) {
				if ($rs->fields['allowusername']==EGS_USERNAME) return true;	
				$rs->MoveNext();
			}
			return $this->adminUser();
		}
		else {
		/*editing*/
			$q = 'select username from todo where id='.$this->db->qstr($id);
			$username = $this->db->GetOne($q);
			if ($username==EGS_USERNAME) return true;
			$q = 'SELECT allowusername FROM eventaccess WHERE username='.$this->db->qstr($username);
			$rs = $this->db->Execute($q);
			while (!$rs->EOF) {
				if ($rs->fields['allowusername']==EGS_USERNAME) return true;	
				$rs->MoveNext();
			}
		}
	}

	function adminUser() {
		$query = 'SELECT username FROM useraccess WHERE username='.$this->db->qstr(EGS_USERNAME).' AND calendaradmin';

		if($this->db->GetOne($query) === false) return false;
		else return true;
	}

	function saveEvent($_POST, $id = '') {
		global $smarty;
		if(isset($_POST['company']))unset($_POST['company']);
		if(isset($_POST['person']))unset($_POST['person']);
		/* An array to hold the event details */
		$event = array();

		/* An array to hold the error messages if any are produced */
		$errors = array();

		if(isset($_POST['deadline'])) $deadline = strtotime($_POST['deadline']);

		/* Check a summary has been added */
		if(!isset($_POST['summary'])) {
			$errors[] = _('Please enter a summary for the ToDo');
		}

		if ($this->writeAccess($_POST['username'],$id)==false) {
			
			$errors[] = _('You Do Not Have Access to Edit this User\'s Calendar');	
		}
		/*check deadline is in the future*/
		if ((isset($_POST['deadline']))&&strtotime($_POST['deadline'])<date()) {
			$errors[] = _('The Deadline must not have passed');
		}
		/* If there are no errors we are ok to save */
		if(sizeof($errors) == 0) {
			$this->db->StartTrans();
			
			if ($id != null)
                                $mode = 'UPDATE';
                        else
                                $mode = 'INSERT';

                        if ($mode == 'INSERT') 
                                $event['id'] = $this->db->GenID('todo_id_seq');
                        else $event['id'] = $_POST['id'];

			/*convert priorities*/
			
			
			
			$event['summary'] = $_POST['summary'];
			if(isset($_POST['description'])) $event['description'] = $_POST['description'];
			if(isset($_POST['deadline'])) $event['deadline'] = $_POST['deadline'];
			if(isset($_POST['completed'])) $event['completed'] = $_POST['completed'];
			if(isset($_POST['url'])) $event['url'] = $_POST['url'];
			if(isset($_POST['priority'])) $event['priority'] = $_POST['priority'];
			//TASK: Allow other usernames
			$event['username'] = $_POST['username'];
			
			
			if (!$this->db->Replace('todo', $event, array ('id'), true)) {
				$errors[] = _('Error saving ToDo');
           	}
            	
            $this->db->CompleteTrans();
            
			$this->outputCalendar($_POST['username'], '');
			$this->outputCalendar($_POST['username'], 'public');
			$this->outputCalendar($_POST['username'], 'private');
			
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
	
	function deleteEvent($id) {
		global $smarty;
		if($this->writeAccess('',$id)) {
			$username = $this->db->GetOne('SELECT username FROM todo WHERE id='.$this->db->qstr($id));

			$query = 'DELETE FROM todo WHERE id='.$this->db->qstr($id);
			
			$this->db->Execute($query);
			
			$smarty->assign('messages', array(_('Event successfully Deleted.')));
			
			$this->outputCalendar($username, '');
			$this->outputCalendar($username, 'public');
			$this->outputCalendar($username, 'private');
			
			return true;
		} else {
			$smarty->assign('errors', array(_('You do not have the correct permissions to delete this event. If you beleive you should please contact your system administrator.')));
			
			return true;
		}
	}
	
function outputCalendar($username, $type = 'private') {
$calendar_path = EGS_FILE_ROOT.'/modules/calendar/calendars/'.EGS_COMPANY_ID.'/';

if($type != 'group') $username = strtolower($username);
else {
	$username = 'GROUP';
	$type = '';
}

if(file_exists($calendar_path.$type.$username.'.ics')) unlink($calendar_path.$type.$username.'.ics');

	if($type != 'projects') {
		$query = "
		SELECT DISTINCT e.*, date_trunc('seconds', e.dtstamp) AS dtstamp, CASE WHEN ((date_part('day', age(e.dtend,e.dtstart)) > 0) OR e.allday) THEN (e.dtend + interval'24 hours') ELSE e.dtend END AS dtend, date_part('day', age(e.dtend,e.dtstart)) AS day, date_part('hour', age(e.dtend,e.dtstart)) AS hour, date_part('minute', age(e.dtend,e.dtstart)) AS min FROM event2 e";
		
		if($username != 'GROUP') $query .= " LEFT OUTER JOIN eventparticipants ep ON (e.id=ep.eventid) LEFT OUTER JOIN person p ON (ep.personid=p.id AND p.userdetail)";

		if(($username == 'GROUP') && ($type == '')) 
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

	if($username == 'GROUP') $usersName = _('Group Events');
	else if($type == 'projects') $usersName = _('Projects and Tasks');
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
			if($row['day'] != '0') {
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

		if($type != 'projects') {
		$query = "
		SELECT (p.firstname || ' ' || p.surname) AS name, p.email 
		FROM personoverview p, eventparticipants e
		WHERE
		(
		 p.id=e.personid AND
		 e.eventid={$row['id']}
		)";
		} else {
			if($row['id']{0} == 'P') $query = 'SELECT(p.firstname || \' \' || p.surname) AS name, p.email FROM personoverview p, projecttaskresources r, resource tr, projecttask t WHERE p.id=tr.personid AND tr.id=r.resourceid AND r.taskid=t.id AND t.projectid='.$this->db->qstr(str_replace('PROJECTS', '', $row['id']));
			else $query = 'SELECT(p.firstname || \' \' || p.surname) AS name, p.email FROM personoverview p, projecttaskresources r, resource tr, projecttask t WHERE p.id=tr.personid AND tr.id=r.resourceid AND r.taskid=t.id AND t.id='.$this->db->qstr(str_replace('TASK', '', $row['id']));
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
		if ((isset($calendarprivate))&&($calendarprivate != "") && ($row['private'] == "t"))
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

	if ($type != 'public') {

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
			if(isset($row['location']))
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

	fclose($handle);
}
}
?>
