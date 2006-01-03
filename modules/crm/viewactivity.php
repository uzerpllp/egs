<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - View Activity 1.0                |
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

	/* Get the activity details from the database */
	$query = 'SELECT *, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'startdate').' AS startdate, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'enddate').' AS enddate, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'added').' AS added, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'updated').' AS updated FROM activityoverview WHERE id='.$db->qstr(intval($_GET['id']));
	$activityDetails = $db->GetRow($query);

	/* Grab the access level for this company */
	$accessLevel = $crm->activityAccess(intval($_GET['id']));


	/* This is set to false if something is successfully saved */
	$saved = false;

	/* If the access level is valid to view the company then we can display it */
	if ((sizeof($activityDetails) != 0) && $accessLevel > 0) {
		/* Update the activity if correct access */
		if ((sizeof($_POST) > 0) && ($accessLevel || ($personAccess > 2) || ($companyAccess > 2))) {
			$crm->saveActivity($_POST, $_GET['id']);
		}

		/* Add to last viewed and sync the preferences */
		$_SESSION['preferences']['lastViewed'] = array_slice(array_merge(array ('module=contacts&amp;action=viewactivity&amp;id='.intval($_GET['id']) => array ('activity', $activityDetails['name'])), $_SESSION['preferences']['lastViewed']), 0, EGS_RECENTLY_VIEWED);
		$egs->syncPreferences();

		/* Set the title to the company name */
		$smarty->assign('pageTitle', _('Activity: ').$activityDetails['name']);

		/* If the user has write access then add the edit button */
		if ($accessLevel > 1)
			$smarty->assign('pageEdit', 'action=saveactivity&amp;id='.intval($_GET['id']));

		/* Output the activity details */
		$leftData = array ();
		$leftData[] = array ('tag' => _('Name'), 'data' => $activityDetails['name']);
		if($activityDetails['opportunityid'] != '') $leftData[] = array ('tag' => _('Attached To'), 'data' => $activityDetails['opportunity'], 'link' => EGS_SERVER.'/?'.session_name().'='.strip_tags(session_id()).'&amp;module=contacts&amp;action=viewopportunity&amp;id='.$activityDetails['opportunityid']);
		else if($activityDetails['caseid'] != ''&&isset($activityDetails['case'])) $leftData[] = array ('tag' => _('Attached To'), 'data' => $activityDetails['case'], 'link' => EGS_SERVER.'/?'.session_name().'='.strip_tags(session_id()).'&amp;module=contacts&amp;action=viewcase&amp;id='.$activityDetails['caseid']);
		$leftData[] = array ('tag' => _('Type'), 'data' => $activityDetails['activity']);
		$leftData[] = array ('span' => true);

		/* Do the activity owner/assigned details */
		$leftData[] = array ('tag' => _('Owner'), 'data' => $activityDetails['owner']);
		$leftData[] = array ('tag' => _('Assigned To'), 'data' => $activityDetails['assigned']);
		$leftData[] = array ('tag' => _('Added'), 'data' => $activityDetails['added'].' '._('by').' '.$activityDetails['owner']);
		$leftData[] = array ('tag' => _('Last Updated'), 'data' => $activityDetails['updated'].' '._('by').' '.$activityDetails['alteredby']);

		$rightData = array ();

		$rightData[] = array ('tag' => _('Start Date'), 'data' => $activityDetails['startdate']);
		$rightData[] = array ('tag' => _('End Date'), 'data' => $activityDetails['enddate']);
		$rightData[] = array ('tag' => _('Duration'), 'data' => $activityDetails['duration']);
		if($activityDetails['completed'] == '') $rightData[] = array ('tag' => _('Completed'), 'data' => _('No'));
		else $rightData[] = array ('tag' => _('Completed'), 'data' => _('Yes'));
		$rightData[] = array ('span' => true);

		$rightData[] = array ('tag' => _('Account'), 'data' => $activityDetails['company'], 'link' => EGS_SERVER.'/?'.session_name().'='.strip_tags(session_id()).'&amp;module=contacts&amp;action=view&amp;id='.$activityDetails['companyid']);
		$rightData[] = array ('tag' => _('Contact'), 'data' => $activityDetails['person'], 'link' => EGS_SERVER.'/?'.session_name().'='.strip_tags(session_id()).'&amp;module=contacts&amp;action=viewperson&amp;id='.$activityDetails['personid']);


		$rightSpan = array();
		
		$rightSpan[] = array('type' => 'text', 'text' => nl2br($activityDetails['description']), 'title' => _('Description'));

		/* Assign the data to the template */
		$smarty->assign('view', true);
		$smarty->assign('leftData', $leftData);
		$smarty->assign('rightData', $rightData);
		$smarty->assign('rightSpan', $rightSpan);

	} else {
		$smarty->assign('errors', array (_('You do not have the correct permissions to access this activity. Please try again later. If the problem persists please contact your system administrator')));
		$smarty->assign('redirect', true);
		$smarty->assign('redirectAction', key($_SESSION['preferences']['lastViewed']));

	}
} else {
	$smarty->assign('errors', array (_('You do not have the correct permissions to access this module. If you believe you should please contact your system administrator')));
}
?>
