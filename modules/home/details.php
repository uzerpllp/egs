<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - View Contact 1.0                 |
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
/*IMPORTANT!!!
 * This File is both home/details.php and contacts/viewperson.php
 */
/* Check user has access to this module */
if (isset ($_SESSION['modules']) && (in_array('contacts', $_SESSION['modules']) || in_array('home', $_SESSION['modules']))) {
	/* Include the person class, and initialise */
	require_once (EGS_FILE_ROOT.'/src/classes/class.person.php');
	$person = new person();

	/* Set the id to the user if in the home module */
	if($_GET['module'] != 'contacts') $_GET['id'] = EGS_PERSON_ID;
	
	/* Grab the access level for this person:
	 * 1 is restricted read
	 * 2 is read
	 * 3 is write
	 * 4 is full write
	 */
	$accessLevel = $person->accessLevel($_GET['id']);
	
	/* Set the view type */
	if (isset ($_GET['type']))
		$_SESSION['preferences']['contactsView'] = $_GET['type'];

	/* This is set to false if something is successfully saved */
	$saved = false;

	/* If the access level is correct and the correct variables set then update the logo */
	if ((sizeof($_POST) > 0) && ($accessLevel > 2) && (isset ($_GET['editdone']) && ($_GET['editdone'] == 'logo'))) {
		$person->updateLogo($_GET['id']);
	} else
		/* Update the contacts if correct access */
		
		if ((sizeof($_POST) > 0) && ($accessLevel > 3) && isset ($_POST['type'])) {
			if ($_SESSION['preferences']['contactsView'] == 'address')
				$person->updateAddress($_POST);
			else
				$person->updateContacts($_POST);
		} else
			/* Update the categories if correct access */
			if ((sizeof($_POST) > 0) && ($accessLevel > 2) && isset($_POST['values'])) {
				$person->updateCategories($_POST['values'], $_GET['id']);
			}

	/* If the access level is valid to view the person then we can display it */
	if ($accessLevel >= 0) {
		/* Get the person details from the database */
		$query = 'SELECT o.*, CASE WHEN o.cancall THEN '.$db->qstr(_('Yes')).' ELSE '.$db->qstr(_('No')).' END as cancall, CASE WHEN o.canemail THEN '.$db->qstr(_('Yes')).' ELSE '.$db->qstr(_('No')).' END AS canemail, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'o.dob').' AS dob, '.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 'o.added').' AS added, '.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 'o.updated').' AS updated, p.firstname || \' \' || p.surname AS personname FROM personoverview o LEFT OUTER JOIN person p ON (o.reportsto=p.id) WHERE o.id='.$db->qstr(intval($_GET['id']));
		$personDetails = $db->GetRow($query);

		/* Now actuall do the display if the results were successfully retrieved */
		if ($personDetails !== false) {
			/* Add to last viewed and sync the preferences */
			$_SESSION['preferences']['lastViewed'] = array_slice(array_merge(array ('module=contacts&amp;action=viewperson&amp;id='.intval($_GET['id']) => array ('person', $personDetails['firstname'].' '.$personDetails['surname'])), $_SESSION['preferences']['lastViewed']), 0, EGS_RECENTLY_VIEWED);
			$egs->syncPreferences();

			/* Set the title to the person name */
			$smarty->assign('pageTitle', $personDetails['firstname'].' '.$personDetails['surname']);

			/* If the user has write access then add the edit button */
			if ($accessLevel > 2) {
				$smarty->assign('pageEdit', 'action=saveperson&amp;id='.intval($_GET['id']));
				if($_GET['module'] == 'contacts') $smarty->assign('pageUpdateAccess', 'action=savepersonaccess&amp;id='.intval($_GET['id']));
			}

			/* Output the person details */
			$leftData = array ();
			$leftData[] = array ('tag' => _('Title'), 'data' => $personDetails['title']);
			$leftData[] = array ('tag' => _('First Name'), 'data' => $personDetails['firstname']);
			$leftData[] = array ('tag' => _('Middle Name'), 'data' => $personDetails['middlename']);
			$leftData[] = array ('tag' => _('Surname'), 'data' => $personDetails['surname']);
			$leftData[] = array ('tag' => _('Suffix'), 'data' => $personDetails['suffix']);
			$leftData[] = array ('tag' => _('Language'), 'data' => $personDetails['language']);
			$leftData[] = array ('tag' => _('Company'), 'data'=> $personDetails['company'], 'link'=>EGS_SERVER.'/?'.session_name().'='.strip_tags(session_id()).'&amp;module=contacts&amp;action=view&amp;id='.$personDetails['companyid']);
			$leftData[] = array ('span' => true);

			/* Format the address according to the users settings */
			$formattedAddress = $egs->formatAddress($personDetails);

			/* And output it */
			$leftData[] = array ('tag' => _('Address'), 'data' => $formattedAddress, 'rowspan' => 4);
			$leftData[] = array ('tag' => '', 'data' => '');
			$leftData[] = array ('tag' => '', 'data' => '');
			$leftData[] = array ('tag' => '', 'data' => '');

			/* Do the person owner/assigned details if actually in the contacts module */
			if($_GET['module'] == 'contacts') {
				$leftData[] = array ('tag' => _('Owner'), 'data' => $personDetails['owner']);
				$leftData[] = array ('tag' => _('Assigned To'), 'data' => $personDetails['assigned']);
				$leftData[] = array ('tag' => _('Added'), 'data' => $personDetails['added'].' '._('by').' '.$personDetails['owner']);
				$leftData[] = array ('tag' => _('Last Updated'), 'data' => $personDetails['updated'].' '._('by').' '.$personDetails['alteredby']);
			}

			/* Do the CRM details */
			$marital[''] = '';
		        $marital['1'] = _('Single');
        		$marital['2'] = _('Married');
        		$marital['3'] = _('Divorced');
        		$marital['4'] = _('Widowed');
        		$marital['5'] = _('Co-Habiting');

			$rightData = array ();
			$rightData[] = array ('tag' => _('Reports To'), 'data' => $personDetails['personname']);
			$rightData[] = array ('tag' => _('Can Call'), 'data' => $personDetails['cancall']);
			$rightData[] = array ('tag' => _('Can Email'), 'data' => $personDetails['canemail']);
			$rightData[] = array ('span' => true);
			
			if(($accessLevel > 1) && ($personDetails['companyid'] == EGS_COMPANY_ID) && (EGS_ACTUAL_COMPANY_ID == EGS_COMPANY_ID)) {
				$rightData[] = array ('tag' => _('Marital Status'), 'data' => $marital[$personDetails['marital']]);
				$rightData[] = array ('tag' => _('Date of Birth'), 'data' => $personDetails['dob']);
				$rightData[] = array ('tag' => _('National Insurance'), 'data' => $personDetails['ni']);
				$rightData[] = array ('span' => true);
			}
			
			$rightData[] = array ('tag' => _('Job Title'), 'data' => $personDetails['jobtitle']);
			$rightData[] = array ('tag' => _('Department'), 'data' => $personDetails['department']);

			$rightSpan = array ();

			/* User has requested to upload a new logo so show the form */
			if (isset ($_GET['edit']) && ($_GET['edit'] == 'logo') && !$saved && ($accessLevel > 3)) {
				$files = array ('type' => 'file', 'title' => _('Update Logo'), 'save' => 'action=view&amp;id='.intval($_GET['id']), 'delete' => false, 'hidenotes' => true);
				$rightSpan[] = $files;
				/* Just the normal view box for the files */
			} else {
				/* If the user does not have write access then show the logo without edit link */
				if ($accessLevel < 4)
					$rightSpan[] = array ('type' => 'image', 'id' => $_GET['id'], 'show' => 'personlogo');
				/* Else show the logo with edit link */
				else
					$rightSpan[] = array ('type' => 'image', 'id' => $_GET['id'], 'editlink' => '&amp;edit=logo', 'show' => 'personlogo');
			}

			/* Get the queries the person is assigned to */
			$query = 'SELECT c.id, c.name FROM contactcategories c, persontypexref r WHERE c.id=r.typeid AND r.personid='.$db->qstr(intval($_GET['id'])).' AND c.companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY c.name';

			$rs = $db->Execute($query);

			/* Only show categories if not attached to a company */
			if($personDetails['companyid'] == '') {
			/* Show the save link if we are editing and the access is correct */
			if (($accessLevel > 1) && isset ($_GET['edit']) && ($_GET['edit'] == 'categories'))
				$categories = array ('type' => 'data', 'title' => _('Categories'), 'save' => 'action=view&amp;id='.intval($_GET['id']));
			else
				/* If the access level is correct show the edit link */
				if ($accessLevel > 1)
					$categories = array ('type' => 'data', 'title' => _('Categories'), 'edit' => 'action=view&amp;edit=categories&amp;id='.intval($_GET['id']));
			/* Just show the title */
			else
				$categories = array ('type' => 'data', 'title' => _('Categories'));

			/* Iterate over the categories and output them */
			while (!$rs->EOF) {
				$categories['data'][$rs->fields['id']] = $rs->fields['name'];
				$categories['selected'][] = $rs->fields['id'];

				$rs->MoveNext();
			}

			/* If we are editing with the correct access then grab the existing categories so we can select them */
			if (($accessLevel > 1) && isset ($_GET['edit']) && ($_GET['edit'] == 'categories')) {
				$query = 'SELECT id, name FROM contactcategories c WHERE personid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY name';

				$rs = $db->Execute($query);

				while (!$rs->EOF) {
					$categories['values'][$rs->fields['id']] = $rs->fields['name'];
					$rs->MoveNext();
				}
			}

			$rightSpan[] = $categories;
			}

			/* Get the person notes if in the contacts module */
			if($_GET['module'] == 'contacts') {
				$query = 'SELECT id, note, '.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 'date').' AS date, '.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 'updated').' AS updated, owner, alteredby FROM personnotes WHERE personid='.$db->qstr(intval($_GET['id'])).' AND ownercompanyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY date';
	
				$rs = $db->Execute($query);
	
				/* If we are editing who the new button */
				if ($accessLevel > 2)
					$notes = array ('type' => 'data', 'title' => _('Notes'), 'new' => 'action=savenote&amp;personid='.intval($_GET['id']));
				/* Just show the title */
				else
					$notes = array ('type' => 'data', 'title' => _('Notes'));
	
				/* Iterate over the notes */
				while (!$rs->EOF) {
					$notes['data'][] = nl2br($rs->fields['note']);
					$extra = _('Added by').' '.$rs->fields['owner'].' '._('on').' '.$rs->fields['date'];
					if ($rs->fields['alteredby'] != '')
						$extra .= '<br />'._('Last updated by').' '.$rs->fields['alteredby'].' '._('on').' '.$rs->fields['updated'];
	
					$notes['extra'][] = $extra;
	
					/* Show the edit link if the permissions are correct */
					if ($accessLevel > 2)
						$notes['link'][] = 'action=savenote&amp;personid='.$_GET['id'].'&amp;noteid='.$rs->fields['id'];
	
					$rs->MoveNext();
				}
	
				$rightSpan[] = $notes;

				/* Show the open tickets assigned to the contact */
				if (($accessLevel > 1) && (isset ($_SESSION['modules']) && (in_array('ticketing', $_SESSION['modules'])))) {
					$query = 'SELECT id, queueid, subject FROM ticket WHERE personid='.$db->qstr($_GET['id']).' AND (private=\'false\' OR (private AND owner='.$db->qstr(EGS_USERNAME).')) AND (internalstatus <> \'CLO\' AND status <> \'CLO\' AND internalstatus <> \'DEL\' AND status <> \'DEL\' ) ORDER BY id ASC';
	
					$rs = $db->Execute($query);
	
					$tickets = array ('type' => 'data', 'title' => _('Open Tickets'));
	
					while (!$rs->EOF) {
						$tickets['data'][] = $rs->fields['subject'];
						$tickets['start'][] = '['.$rs->fields['queueid'].'-'.$rs->fields['id'].']';
						$tickets['link'][] = 'module=ticketing&amp;action=view&amp;id='.$rs->fields['id'];
						$rs->MoveNext();
					}
	
					$rightSpan[] = $tickets;
				}
	
				/* Show the open projects assigned to the contact */
				if (($accessLevel > 1) && (isset ($_SESSION['modules']) && (in_array('projects', $_SESSION['modules'])))) {
					$query = 'SELECT  p.id, p.jobno, p.name FROM project p, projectaccess a WHERE p.id=a.projectid AND a.companyid='.$db->qstr(EGS_COMPANY_ID).' AND p.personid='.$db->qstr($personDetails['id']).' AND a.username='.$db->qstr(EGS_USERNAME).' AND (archived='.$db->qstr('false').' ) ORDER BY p.jobno ASC';
	
					$rs = $db->Execute($query);
	
					if ($accessLevel > 2)
						$projects = array ('type' => 'data', 'title' => _('Current Projects'));
	
					while (!$rs->EOF) {
						$projects['data'][] = $rs->fields['name'];
						$projects['start'][] = $rs->fields['jobno'];
						$projects['link'][] = 'module=projects&amp;action=view&amp;id='.$rs->fields['id'];
						$rs->MoveNext();
					}
	
					if(isset($projects))$rightSpan[] = $projects;
				}
			}

			if (isset ($_SESSION['preferences']['contactsView']) && ($_SESSION['preferences']['contactsView'] != 'address')) {
				$query = 'SELECT * FROM personcontactmethod WHERE personid='.$db->qstr($_GET['id']).' AND type='.$db->qstr($_SESSION['preferences']['contactsView']).' ORDER BY name';
			} else {
				$query = 'SELECT * FROM personaddress WHERE personid='.$db->qstr($_GET['id']).' ORDER BY name';

				$_SESSION['preferences']['contactsView'] = 'address';
			}

			$rs = $db->Execute($query);

			/* Show new link if correct access */
			if ($accessLevel > 2)
				$contacts = array ('type' => 'contact', 'title' => $_SESSION['preferences']['contactsView'], 'header' => array (_('Name'), _('Contact'), _('Main'), _('Billing'), _('Shipping'), _('Payment'), _('Technical')), 'viewlink' => 'action=save'.$_SESSION['preferences']['contactsView'].'&amp;personid='.$_GET['id'].'&amp;id=', 'newlink' => 'action=save'.$_SESSION['preferences']['contactsView'].'&amp;personid='.intval($_GET['id']), 'contacttype' => array ('main', 'billing', 'shipping', 'payment', 'technical'), 'options' => array ('address' => _('Addresses'), 'T' => _('Phone'), 'F' => _('Fax'), 'M' => _('Mobile'), 'E' => _('Email')));
			/* Just show the title */
			else
				$contacts = array ('type' => 'contact', 'title' => $_SESSION['preferences']['contactsView'], 'header' => array (_('Name'), _('Contact'), _('Main'), _('Billing'), _('Shipping'), _('Payment'), _('Technical')), 'options' => array ('address' => _('Addresses'), 'T' => _('Phone'), 'F' => _('Fax'), 'M' => _('Mobile'), 'E' => _('Email')));

			/* Iterate over and show the contacts */
			while (!$rs->EOF) {
				//$contacts['data'][] = $rs->fields;
				$contact = array ();

				$contact['tag'] = urlencode($rs->fields['tag']);
				$contact['name'] = $rs->fields['name'];

				if ($_SESSION['preferences']['contactsView'] == 'address') {
					$contact['contact'] = $egs->formatAddress($rs->fields);
				} else {
					$contact['contact'] = $rs->fields['contact'];
				}

				$contact['main'] = $rs->fields['main'];
				$contact['billing'] = $rs->fields['billing'];
				$contact['shipping'] = $rs->fields['shipping'];
				$contact['payment'] = $rs->fields['payment'];
				$contact['technical'] = $rs->fields['technical'];

				$contacts['data'][] = $contact;

				$rs->MoveNext();
			}

			$contacts['icon'] = 'addresses';
			$bottomData[] = $contacts;

			if (($accessLevel > 1) && ($_GET['module'] == 'contacts')){
				/* Get the open opportunities */
				$query = 'SELECT personid, id, name, person, status, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'enddate').' AS enddate FROM opportunityoverview WHERE usercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND personid='.$db->qstr(intval($_GET['id'])).' AND open='.$db->qstr('true').' ORDER BY name';

				$rs = $db->Execute($query);

				$links = array ();

				if ($accessLevel > 2)
					$opportunities = array ('type' => 'data', 'title' => _('Open Opportunities'), 'header' => array (_('Name'), _('Type'), _('Contact'), _('Due Date')), 'viewlink' => 'action=viewopportunity&amp;id=', 'newlink' => 'action=saveopportunity&amp;personid='.intval($_GET['id']));
				else
					$opportunities = array ('type' => 'data', 'title' => _('Open Opportunities'), 'header' => array (_('Name'), _('Type'), _('Contact'), _('Due Date')), 'viewlink' => 'action=viewopportunity&amp;id=');

				while (!$rs->EOF) {
					$links[4][] = 'action=viewperson&amp;id='.$rs->fields['personid'];
					unset ($rs->fields['personid']);
					unset ($rs->fields['personid']);

					$opportunities['data'][] = $rs->fields;
					$rs->MoveNext();
				}

				$opportunities['links'] = $links;
				$bottomData[] = $opportunities;

				/* Grab the Cases */
				$query = 'SELECT personid, id, id AS num, name, person, priority, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'enddate').' AS enddate, assigned FROM crmcaseoverview WHERE usercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND personid='.$db->qstr(intval($_GET['id'])).' ORDER BY name';

				$rs = $db->Execute($query);

				$links = array ();

				if ($accessLevel > 2)
					$cases = array ('type' => 'data', 'title' => _('Open Cases'), 'header' => array (_('Num'), _('Subject'), _('Contact'), _('Priority'), _('Due Date'), _('Assigned To')), 'viewlink' => 'action=viewcase&amp;id=', 'newlink' => 'action=savecase&amp;personid='.intval($_GET['id']));
				else
					$cases = array ('type' => 'data', 'title' => _('Open Cases'), 'header' => array (_('Num'), _('Subject'), _('Contact'), _('Priority'), _('Due Date'), _('Assigned To')), 'viewlink' => 'action=viewcase&amp;id='.intval($_GET['id']).'&amp;id=');

				while (!$rs->EOF) {
					$links[4][] = 'action=viewperson&amp;id='.$rs->fields['personid'];
					unset ($rs->fields['personid']);
					unset ($rs->fields['personid']);

					$cases['data'][] = $rs->fields;
					$rs->MoveNext();
				}

				$cases['links'] = $links;
				$bottomData[] = $cases;

				$query = 'SELECT caseid, opportunityid, personid, id, name, activity, casename, opportunity, person, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'startdate').' AS startdate, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'enddate').' AS enddate, personid, personid FROM activityoverview WHERE usercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND personid='.$db->qstr(intval($_GET['id'])).' AND completed IS NULL ORDER BY name';

				$rs = $db->Execute($query);

				$links = array ();

				if ($accessLevel > 2)
					$activities = array ('type' => 'data', 'title' => _('Open Activities'), 'header' => array (_('Name'), _('Type'), _('Attached To'), _('Contact'), _('Start Date'), _('End Date')), 'viewlink' => 'action=viewactivity&amp;id=', 'newlink' => 'action=saveactivity&amp;personid='.intval($_GET['id']));
				else
					$activities = array ('type' => 'data', 'title' => _('Open ACtivities'), 'header' => array (_('Name'), _('Type'), _('Attached To'), _('Contact'), _('Start Date'), _('End Date')), 'viewlink' => 'action=viewactivity&amp;id=');

				while (!$rs->EOF) {
					$links[5][] = 'action=viewperson&amp;id='.$rs->fields['personid'];
					if ($rs->fields['opportunityid'] != '') {
						$links[4][] = 'action=viewopportuity&amp;id='.$rs->fields['opportunityid'];
						unset ($rs->fields['casename']);
					}
					if ($rs->fields['caseid'] != '') {
						$links[4][] = 'action=viewcase&amp;id='.$rs->fields['caseid'];
						unset ($rs->fields['opportunity']);
					}
					unset ($rs->fields['personid']);
					unset ($rs->fields['personid']);
					unset ($rs->fields['opportunityid']);
					unset ($rs->fields['caseid']);

					$activities['data'][] = $rs->fields;
					$rs->MoveNext();
				}

				$activities['links'] = $links;
				$bottomData[] = $activities;
			}

			/* Assign the data to the template */
			$smarty->assign('view', true);
			$smarty->assign('leftData', $leftData);
			$smarty->assign('rightData', $rightData);
			$smarty->assign('rightSpan', $rightSpan);
			$smarty->assign('bottomData', $bottomData);
			
			$smarty->assign('moduleIcon', 'person');

		} else {
			$smarty->assign('errors', array (_('There was a temporary error trying to retrieve the person details. Please try again later. If the problem persists please contact your system administrator')));
			$smarty->assign('redirect',true);
			$smarty->assign('redirectAction','action=personoverview');
		}
	} else {
		$smarty->assign('errors', array (_('You do not have the correct permissions to access this person. If you believe you should please contact your system administrator')));
		$smarty->assign('redirect',true);
		$smarty->assign('redirectAction','action=personoverview');
	}
} else {
	$smarty->assign('errors', array (_('You do not have the correct permissions to access this module. If you believe you should please contact your system administrator')));
	$smarty->assign('redirect',true);
	$smarty->assign('redirectAction','action=personoverview');
}
?>