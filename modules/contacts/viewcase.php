<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - View Case 1.0                    |
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

/* Check user has access to this module */
if (isset ($_SESSION['modules']) && (in_array('crm', $_SESSION['modules']))) {
	/* Include the crm/compnay/person class, and initialise */
	require_once (EGS_FILE_ROOT.'/src/classes/class.crm.php');
	$crm = new crm();

	/* Get the case details from the database */
	$query = 'SELECT *, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'enddate').' AS enddate, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'added').' AS added, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'updated').' AS updated FROM crmcaseoverview WHERE id='.$db->qstr(intval($_GET['id']));
	$caseDetails = $db->GetRow($query);

	/* Grab the access level for this company */
	$accessLevel = $crm->caseAccess(intval($_GET['id']));
	$access = $accessLevel;

	$personAccess = 0;
	$companyAccess = 0;

	if (!$accessLevel) {
		require_once (EGS_FILE_ROOT.'/src/classes/class.person.php');
		$person = new person();

		$personAccess = $person->accessLevel($caseDetails['personid']);

		if ($personAccess > 1)
			$accessLevel = true;
		else {
			require_once (EGS_FILE_ROOT.'/src/classes/class.company.php');
			$company = new company();

			$companyAccess = $company->accessLevel($caseDetails['companyid']);

			if ($companyAccess > 1)
				$accessLevel = true;
		}
	}

	/* This is set to false if something is successfully saved */
	$saved = false;

	/* If the access level is valid to view the company then we can display it */
	if ((sizeof($caseDetails) != 0) && $accessLevel) {
		/* Update the oppportunity if correct access */
		if ((sizeof($_POST) > 0) && ($accessLevel || ($personAccess > 2) || ($companyAccess > 2))) {
			$crm->saveCase($_POST, $_GET['id']);
		}

		/* Add to last viewed and sync the preferences */
		$_SESSION['preferences']['lastViewed'] = array_slice(array_merge(array ('module=contacts&amp;action=viewcase&amp;id='.intval($_GET['id']) => array ('case', $caseDetails['name'])), $_SESSION['preferences']['lastViewed']), 0, EGS_RECENTLY_VIEWED);
		$egs->syncPreferences();

		/* Set the title to the company name */
		$smarty->assign('pageTitle', _('Case'));

		/* If the user has write access then add the edit button */
		if ($access || ($companyAccess > 2) || ($personAccess > 2))
			$smarty->assign('pageEdit', 'action=savecase&amp;id='.intval($_GET['id']));

		/* Output the case details */
		$leftData = array ();
		$leftData[] = array ('tag' => _('Num'), 'data' => $caseDetails['id']);
		$leftData[] = array ('tag' => _('Type'), 'data' => $caseDetails['type']);
		$leftData[] = array ('span' => true);

		/* Do the case owner/assigned details */
		$leftData[] = array ('tag' => _('Owner'), 'data' => $caseDetails['owner']);
		$leftData[] = array ('tag' => _('Assigned To'), 'data' => $caseDetails['assigned']);
		$leftData[] = array ('tag' => _('Added'), 'data' => $caseDetails['added'].' '._('by').' '.$caseDetails['owner']);
		$leftData[] = array ('tag' => _('Last Updated'), 'data' => $caseDetails['updated'].' '._('by').' '.$caseDetails['alteredby']);

		$rightData = array ();

		$rightData[] = array ('tag' => _('Status'), 'data' => $caseDetails['status']);
		$rightData[] = array ('tag' => _('Priority'), 'data' => $caseDetails['priority']);
		$rightData[] = array ('tag' => _('Due Date'), 'data' => $caseDetails['enddate']);
		$rightData[] = array ('span' => true);

		$rightData[] = array ('tag' => _('Account'), 'data' => $caseDetails['company'], 'link' => EGS_SERVER.'/?'.session_name().'='.strip_tags(session_id()).'&amp;module=contacts&amp;action=view&amp;id='.$caseDetails['companyid']);
		$rightData[] = array ('tag' => _('Contact'), 'data' => $caseDetails['person'], 'link' => EGS_SERVER.'/?'.session_name().'='.strip_tags(session_id()).'&amp;module=contacts&amp;action=viewperson&amp;id='.$caseDetails['personid']);

		$rightSpan = array ();

		$subject = array();
		$subject['type'] = 'text';
		$subject['title'] = _('Subject');
		$subject['text'] = $caseDetails['name'];

		$rightSpan[] = $subject;

		/* Get the company notes */
		$query = 'SELECT id, note, '.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 'date').' AS date, '.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 'updated').' AS updated, owner, alteredby FROM crmnotes WHERE caseid='.$db->qstr(intval($_GET['id'])).' ORDER BY date';

		$rs = $db->Execute($query);

		/* If we are editing who the new button */
		if ($access || ($companyAccess > 2) || ($personAccess > 2))
			$notes = array ('type' => 'data', 'title' => _('Notes'), 'new' => 'action=savenote&amp;caseid='.intval($_GET['id']));
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
			if ($accessLevel || ($companyAccess > 2) || ($personAccess > 2))
				$notes['link'][] = 'action=savenote&amp;caseid='.$_GET['id'].'&amp;noteid='.$rs->fields['id'];

			$rs->MoveNext();
		}

		$rightSpan[] = $notes;

		$bottomData[] = array('type' => 'display', 'content' => $caseDetails['description'], 'title' => _('Description'));
		$bottomData[] = array('type' => 'display', 'content' => $caseDetails['resolution'], 'title' => _('Resolution'));

		$query = 'SELECT personid, id, name, activity, person, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'startdate').' AS startdate, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'enddate').' AS enddate, personid, companyid FROM activityoverview WHERE caseid='.$db->qstr($_GET['id']).' AND usercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND completed IS NULL ORDER BY name';

		$rs = $db->Execute($query);

		$links = array ();

		if ($access || ($companyAccess > 2) || ($personAccess > 2))
			$activities = array ('type' => 'data', 'title' => _('Open Activities'), 'header' => array (_('Name'), _('Type'), _('Contact'), _('Start Date'), _('End Date')), 'viewlink' => 'action=viewactivity&amp;id=', 'newlink' => 'action=saveactivity&amp;caseid='.intval($_GET['id']));
		else
			$activities = array ('type' => 'data', 'title' => _('Open Activities'), 'header' => array (_('Name'), _('Type'), _('Contact'), _('Start Date'), _('End Date')), 'viewlink' => 'action=viewactivity&amp;id=');

		while (!$rs->EOF) {
			$links[4][] = 'action=viewperson&amp;id='.$rs->fields['personid'];
			unset ($rs->fields['personid']);
			unset ($rs->fields['companyid']);

			$activities['data'][] = $rs->fields;
			$rs->MoveNext();
		}

		$activities['links'] = $links;
		$bottomData[] = $activities;

		/* Assign the data to the template */
		$smarty->assign('view', true);
		$smarty->assign('leftData', $leftData);
		$smarty->assign('rightData', $rightData);
		$smarty->assign('rightSpan', $rightSpan);
		$smarty->assign('bottomData', $bottomData);

	} else {
		$smarty->assign('errors', array (_('You do not have the correct permissions to access this case. Please try again later. If the problem persists please contact your system administrator')));
		$smarty->assign('redirect', true);
		$smarty->assign('redirectAction', '');
	}
} else {
	$smarty->assign('errors', array (_('You do not have the correct permissions to access this module. If you believe you should please contact your system administrator')));
}
?>
