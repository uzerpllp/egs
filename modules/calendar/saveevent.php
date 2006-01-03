<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Save Event 1.0                   |
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
/* Set the id if set */
if (isset ($_GET['id']))
	$id = intval($_GET['id']);
if (isset ($_POST['id']))
	$id = ($_POST['id']);
if(isset($_GET['start'])&&count($_POST)==0) {
	$tempyr = substr($_GET['start'],0,4);
	$tempmnth = substr($_GET['start'],4,2);
	$tempday = substr($_GET['start'],6,2);
	$temphour = substr($_GET['start'],8,2);
	$tempmin = substr($_GET['start'],10,2);
	$date = $tempyr.'-'.$tempmnth.'-'.$tempday;
	
	
	$enddate = $_GET['start'];
	
	preg_match("/(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})/i",$_GET['start'],$matches);
	$tempdate = date('Y-m-d',strtotime("$matches[1]-$matches[2]-$matches[3] $matches[4]:$matches[5] +1 hour"));
	$enddate=$tempdate;
	
	$endhour=sprintf("%02d",($matches[4]+1)%24);
	$endmin=sprintf("%02d",$tempmin);
	
	
}
require_once(EGS_FILE_ROOT.'/src/classes/class.calendar.php');

$calendar = new calendar();
	
/* Check that the calendar is enabled, and the correct permissions are valid for the calendar. */
if (in_array('calendar', $_SESSION['modules']) && (!isset ($id) || (isset ($id) && $calendar->writeAccess('',$id)))) {
	/* Set up the variables for the form */
	
	$saved = false;
	$select = false;
	if(!isset($id)) $id = null;

	/* Do a save if the form has been posted */
	if (sizeof($_POST) > 0 && (isset($_POST['save']) || isset($_POST['delete']))) {
		/* Check the post array */
		$egs->checkPost();

		/* If project admin do the delete */
		if(isset($_POST['delete'])) $saved = $calendar->deleteEvent($id);
		else if(!isset($_POST['delete'])) $saved = $calendar->saveEvent($_POST, $id);
	}

	/* Redirect to the calendar view if the form saved successfully */
	if ($saved) {
		$smarty->assign('redirect', true);
		if (isset($_POST['delete'])) $smarty->assign('redirectAction', 'action=overview');
		else $smarty->assign('redirectAction', '');
	} else {
		/* Set up arrays to hold form elements */
		$leftForm = array ();
		$rightForm = array ();
		$bottomForm = array ();

		/* We are editing the calendar so check access and get the data */
		if (isset ($id)) {
			
			/* Correct access so get the data */
			if ($calendar->writeAccess('',$id)) {
				$query = 'SELECT * FROM event2 WHERE id='.$db->qstr($id);

				$_POST = $db->GetRow($query);
				
				
				preg_match("/(\d{4}-\d{2}-\d{2}) (\d{2}):(\d{2})*/i",$_POST['dtstart'],$matches);
				
				$_POST['dtstart'] = $matches[1];
				$_POST['dtstarthour']=$matches[2];
				$_POST['dtstartminute']=$matches[3];
				
				preg_match("/(\d{4}-\d{2}-\d{2}) (\d{2}):(\d{2})*/i",$_POST['dtend'],$matches);
				
				$_POST['dtend'] = $matches[1];
				$_POST['dtendhour']=$matches[2];
				$_POST['dtendminute']=$matches[3];
				
				/* Incorrect access so notify and redirect to project view */
				if(sizeof($_POST) > 0) $select = true;
				
			} 
			
			if(!$select) {
				$smarty->assign('errors', array (_('You do not have the correct access to edit this calendar. If you believe you should please contact your system administrator')));
				$smarty->assign('redirect', true);
				$smarty->assign('redirectAction', '');

				return;
			}
		}
		if(count($_POST)==0&&isset($date)&&isset($temphour)&&isset($tempmin)) {
			$_POST['dtstart']=$date;
			$_POST['dtstarthour']=$temphour;
			$_POST['dtstartminute']=$tempmin;
			$_POST['dtend']=$enddate;
			$_POST['dtendhour']=$endhour;
			$_POST['dtendminute']=$endmin;
		}
		
		/* Set up the title */
		if (isset ($id))
			$smarty->assign('pageTitle', _('Save Changes to Event'));
		else
			$smarty->assign('pageTitle', _('Save New Event'));

		/* Show the delete button if editing */
		$smarty->assign('formDelete', true);
		
		/* Add any hidden fields we need */
		$hidden = array ();
		if (isset ($id))
			$hidden['id'] = $id;

		$smarty->assign('hidden', $hidden);

		/* Setup the calendar subject */
		$item = array ();
		$item['type'] = 'text';
		$item['tag'] = _('Summary');
		$item['name'] = 'summary';
		if (isset ($_POST['summary']))
			$item['value'] = $_POST['summary'];
		$item['compulsory'] = true;

		$leftForm[] = $item;
		
				
		$item = array();
        $item['type'] = 'space';

		$leftForm[] = $item;

		/* Setup the account it is attached to */
		if (isset ($_POST['companyid'])) {
			$query = 'SELECT name AS name FROM company WHERE id='.$db->qstr($_POST['companyid']);

			$_POST['companyname'] = $db->GetOne($query);
		}

		$item = array ();
		$item['type'] = 'company';
		$item['tag'] = _('Event with Client');
		$item['name'] = 'company';
		$item['hide'] = 'person';
		if (isset ($_POST['companyid']))
			$item['value'] = $_POST['companyname'];
		if (isset ($_POST['companyid']))
			$item['actualvalue'] = $_POST['companyid'];

		$leftForm[] = $item;

		$item = array ();
		$item['type'] = 'text';
		$item['tag'] = _('or Different Location');
		$item['name'] = 'location';
		if (isset ($_POST['location']))
			$item['value'] = $_POST['location'];

		$leftForm[] = $item;
		
		$item = array ();
		$item['type'] = 'text';
		$item['tag'] = _('URL/Web Address');
		$item['name'] = 'url';
		if (isset ($_POST['url']))
			$item['value'] = $_POST['url'];

		$leftForm[] = $item;
		
		$item = array();
        	$item['type'] = 'space';

		$leftForm[] = $item;
		
		$statuses = array('CONFIRMED', 'TENTATIVE', 'CANCELLED');
		
		$item['type'] = 'select';
		$item['tag'] = _('Status');
		$item['name'] = 'status';
		if (isset ($_POST['status']))
			$item['value'] = $_POST['status'];

		$item['options'] = array ();

		while($status = array_shift($statuses)) {
			if($status != '') $item['options'][$status] = _(ucwords(strtolower($status)));
			else $item['options'][''] = _('None');
		}
			
		$leftForm[] = $item;
		
		$item['type'] = 'select';
		$item['tag'] = _('Add to this user\'s calendar');
		$item['name'] = 'username';
		if(isset($_POST['username'])) $item['value'] = $_POST['username'];
		else $item['value'] = EGS_USERNAME; 
		
		$query = 'SELECT gm.username FROM groupmoduleaccess a, groupmembers gm, groups g, module m WHERE a.groupid=gm.groupid AND gm.groupid=g.id AND m.id=a.moduleid AND g.companyid='.$db->qstr(EGS_COMPANY_ID).' AND m.name='.$db->qstr('calendar');
		
		$rs = $db->Execute($query); 

		$item['options'] = array ();

		while(!$rs->EOF) {
			$item['options'][$rs->fields['username']] = $rs->fields['username'];
			
			$rs->MoveNext();
		}
			
		$leftForm[] = $item;

		if($calendar->adminUser()) {
		$item = array();
        $item['type'] = 'checkbox';
        $item['tag'] = _('Group Event');
        $item['name'] = 'usercompanyid';
        if(isset($_POST['usercompanyid']) && (($_POST['usercompanyid'] == 'on') || ($_POST['usercompanyid'] == 't'))) $item['value'] = true;

		$leftForm[] = $item;
	
		}
	
		$item = array();
        $item['type'] = 'checkbox';
        $item['tag'] = _('Private');
        $item['name'] = 'private';
        if(isset($_POST['private']) && (($_POST['private'] == 'on') || ($_POST['private'] == 't'))) $item['value'] = true;

		$leftForm[] = $item;
		
		$item = array();
        $item['type'] = 'space';

		$leftForm[] = $item;

		$item['type'] = 'ajaxmultiple';
		$item['tag'] = _('Participants');
		$item['name'] = 'participants[]';
		$item['inputname']='participant';
		
		$query = 'SELECT p.id, CASE WHEN c.name IS NULL THEN p.firstname || \' \' || p.surname ELSE p.firstname || \' \' || p.surname || \' (\' || c.name || \')\' END AS name FROM person p LEFT OUTER JOIN company c ON (p.companyid=c.id), personaccess a WHERE a.usercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND a.username='.$db->qstr(EGS_USERNAME).' AND a.personid=p.id ORDER BY name';
		
		$rs = $db->Execute($query); 

		$item['options'] = array ();

		while(($rs!==false) && (!$rs->EOF)) {
			$item['options'][$rs->fields['id']] = $rs->fields['name'];
			
			$rs->MoveNext();
		}
		if(isset($id)) {
			
			$query = 'SELECT ep.personid, p.firstname || \' \' || p.surname AS name FROM person p JOIN eventparticipants ep ON(p.id=ep.personid) WHERE ep.eventid='.$id;
			$rs=$db->Execute($query);
			while(!$rs->EOF) {
				$item['value'][$rs->fields['personid']]=$rs->fields['name'];
				$rs->MoveNext();	
			}
		} 
		$leftForm[] = $item;

		/* Setup the date fields */
		$item = array ();
		$item['type'] = 'date';
		$item['tag'] = _('Start');
		$item['name'] = 'dtstart';
		$item['time'] = true;
		$item['format'] = str_replace('%i', '%M', EGS_DATE_FORMAT);
		if (isset ($_POST['dtstart'])) {
			$item['actualvalue'] = $_POST['dtstart'];
			$item['value'] = date(str_replace('%', '', EGS_DATE_FORMAT), strtotime($_POST['dtstart']));
			if(isset($_POST['dtstarthour']))$item['timehourvalue']=$_POST['dtstarthour'];
			if(isset($_POST['dtstartminute']))$item['timeminutevalue']=$_POST['dtstartminute'];
		}
		
		$rightForm[] = $item;
		
		$item = array ();
		$item['type'] = 'date';
		$item['tag'] = _('End');
		$item['name'] = 'dtend';
		$item['time'] = true;
		$item['format'] = str_replace('%i', '%M', EGS_DATE_FORMAT);
		if (isset ($_POST['dtstart'])) {
			$item['actualvalue'] = $_POST['dtend'];
			$item['value'] = date(str_replace('%', '', EGS_DATE_FORMAT), strtotime($_POST['dtend']));
			if(isset($_POST['dtendhour']))$item['timehourvalue']=$_POST['dtendhour'];
			if(isset($_POST['dtendminute']))$item['timeminutevalue']=$_POST['dtendminute'];
		}

		$rightForm[] = $item;
		
		$item = array();
        $item['type'] = 'checkbox';
        $item['tag'] = _('All Day Event');
        $item['name'] = 'allday';
        if(isset($_POST['allday']) && (($_POST['allday'] == 'on') || ($_POST['allday'] == 't'))) $item['value'] = true;

		$rightForm[] = $item;
		
		$item = array ();
		$item['type'] = 'space';

		$rightForm[] = $item;
		
		
		/* No Alarms (yet?)	
		$item = array ();
		$item['type'] = 'date';
		$item['tag'] = _('Alarm');
		$item['name'] = 'alarm';
		$item['time'] = true;
		$item['format'] = str_replace('%i', '%M', EGS_TIME_FORMAT);
		if (isset ($_POST['alarm'])) {
			$item['actualvalue'] = $_POST['alarm'];
			$item['value'] = date(str_replace('%', '', EGS_TIME_FORMAT), strtotime($_POST['alarm']));
			if(isset($_POST['alarmhour']))$item['timehourvalue']=$_POST['alarmhour'];
			if(isset($_POST['alarmminute']))$item['timeminutevalue']=$_POST['alarmminute'];
		}

		$rightForm[] = $item;
		*/
		$item = array ();
		$item['type'] = 'space';

		$rightForm[] = $item;
				
		$recurrance = array('none', 'daily', 'weekly', 'monthly', 'yearly');
		
		$item['type'] = 'select';
		$item['tag'] = _('Recurrance Type');
		$item['name'] = 'recurrance';
		if (isset ($_POST['r_freq']))
			$item['value'] = strtolower($_POST['r_freq']);
		if (isset ($_POST['recurrance']))
			$item['value'] = strtolower($_POST['recurrance']);

		$item['options'] = array ();

		while($r = array_shift($recurrance)) {
			if($r != 'none') $item['options'][$r] = _(ucwords($r));
			else $item['options'][''] = _('None');
		}
			
		$rightForm[] = $item;
		
		$item = array ();
		$item['type'] = 'text';
		$item['tag'] = _('Continue Indefintely');
		$item['radio'] = true;
		
		$item['radioname'] = 'recurranceend';
		$irem['radionvalue'] = 'indefinitely';
		if (isset ($_POST['recurranceend']) && (!isset($_POST['r_count']) && !isset($_POST['deadline']) && !isset($_POST['r_until']))) {
			$item['checked'] = true;
		}

		$rightForm[] = $item;

		$item = array ();
		$item['type'] = 'text';
		$item['tag'] = _('Stop After');
		$item['name'] = 'r_count';
		$item['maxlength'] = '3';
		$item['post'] = _('times.');
		$item['radio'] = true;
		$item['radioname'] = 'recurranceend';
		$irem['radionvalue'] = 'count';
		if (isset ($_POST['r_count'])) {
			$item['value'] = $_POST['r_count'];
			$item['checked'] = true;
		}

		$rightForm[] = $item;

		$item = array ();
		$item['type'] = 'date';
		$item['tag'] = _('Continue Until');
		$item['name'] = 'deadline';
		$item['format'] = EGS_DATE_FORMAT;
		$item['radio'] = true;
		$item['radioname'] = 'recurranceend';
		$irem['radionvalue'] = 'after';
		if (isset ($_POST['deadline']) || isset($_POST['r_until'])) {
			$item['actualvalue'] = $_POST['deadline'];
			if(isset($_POST['deadline'])) $item['value'] = date(str_replace('%', '', EGS_DATE_FORMAT), strtotime($_POST['deadline']));
			else $item['value'] = date(str_replace('%', '', EGS_DATE_FORMAT), strtotime($_POST['r_until']));
			$item['checked'] = true;
		}

		$rightForm[] = $item;

		/* Setup the descrption */
		$item = array ();
		$item['type'] = 'area';
		$item['tag'] = _('Description');
		$item['name'] = 'description';
		if (isset ($_POST['description']))
			$item['value'] = $_POST['description'];

		$bottomForm[] = $item;

		/* Assign the form variable */
		$smarty->assign('form', true);
		$smarty->assign('leftForm', $leftForm);
		$smarty->assign('rightForm', $rightForm);
		$smarty->assign('bottomForm', $bottomForm);
		$smarty->assign('formId', 'saveform');
	}
} else {
	$smarty->assign('redirect', true);
	if(isset($id)) $smarty->assign('redirectAction', '');
	else $smarty->assign('redirectAction', 'action=overview');
	$smarty->assign('errors', array (_('You do not have the correct permissions to save an event. If you beleive you should please contact your system administrator.')));
}
?>
