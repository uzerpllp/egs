<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - ACtivities Overview 1.0          |
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

/* Check user has access to the contacts and crm module */
if (in_array('crm', $_SESSION['modules']) && in_array('contacts', $_SESSION['modules'])) {
	/* If the page has not been set, set it */
	if (isset ($_GET['page']))
		$_SESSION['activity_page'] = max(1, intval($_GET['page']));
	if (!isset ($_SESSION['activity_page']))
		$_SESSION['activity_page'] = 1;

	/* Set the page title */
	$smarty->assign('pageTitle', _('Contacts: Activities'));

	/* Setup the search box */
	$smarty->assign('searchTitle', _('Search Activities'));

	/* Set the search type */
	if (isset ($_GET['search']) && ($_GET['search'] == 'adv'))
		$_SESSION['activitySearchType'] = 'adv';
	else
		if (isset ($_GET['search']) && ($_GET['search'] == 'norm'))
			$_SESSION['activitySearchType'] = 'norm';
		else
			if (!isset ($_SESSION['activitySearchType']))
				$_SESSION['activitySearchType'] = 'norm';

	$smarty->assign('searchForm', $_SESSION['activitySearchType']);

	$search = array ();

	$search['name'] = array ('name' => _('Name'), 'type' => 'text');
	$search['enddate'] = array ('name' => _('End Date'), 'type' => 'text');

	/* Add the assigned */
	$query = 'SELECT username FROM useraccess WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY username';

	$rs = $db->execute($query);

	if (EGS_DEBUG_SQL && !$rs)
		die($db->errorMsg());

	$users = array (_('All') => '');

	while (!$rs->EOF) {
		$users[$rs->fields['username']] = $rs->fields['username'];
		$rs->MoveNext();
	}

	$search['assigned'] = array ('name' => _('Activity Assigned To'), 'type' => 'select', 'values' => $users);

	$smarty->assign('search', $search);

	if ($_SESSION['activitySearchType'] == 'adv') {
		$query = 'SELECT id, name FROM crmactivity WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY id';

		$rs = $db->execute($query);

		if (EGS_DEBUG_SQL && !$rs)
			die($db->errorMsg());

		$status = array (_('All') => '');

		while (!$rs->EOF) {
			$status[$rs->fields['name']] = $rs->fields['id'];
			$rs->MoveNext();
		}

		$search['crmactivityid'] = array ('name' => _('Type'), 'type' => 'select', 'values' => $status);

		$search['company'] = array ('name' => _('Account'), 'type' => 'text');
		$search['person'] = array ('name' => _('Contact'), 'type' => 'text');
	}

	$smarty->assign('search', $search);

	/* If no default column ordering is set for the company, setup the default */
	if (!isset ($_SESSION['preferences']['activityColumns']) || !is_array($_SESSION['preferences']['activityColumns'])) {
		$_SESSION['preferences']['activityColumns'] = array ();
		$_SESSION['preferences']['activityColumns'][] = 'id';
		$_SESSION['preferences']['activityColumns'][] = 'name';
		$_SESSION['preferences']['activityColumns'][] = 'opportunity';
		$_SESSION['preferences']['activityColumns'][] = 'activity';
		$_SESSION['preferences']['activityColumns'][] = 'company';
		$_SESSION['preferences']['activityColumns'][] = 'person';
		$_SESSION['preferences']['activityColumns'][] = 'startdate';
		$_SESSION['preferences']['activityColumns'][] = 'enddate';
		$_SESSION['preferences']['activityColumns'][] = 'completed';
		$_SESSION['preferences']['activityColumns'][] = 'owner';
		$_SESSION['preferences']['activityColumns'][] = 'assigned';
	}

	/* Array to hold the columns */
	$headings = array ();

	/* Iterate over the columns and translate */
	for ($i = 0; $i < sizeof($_SESSION['preferences']['activityColumns']); $i ++) {
		switch ($_SESSION['preferences']['activityColumns'][$i]) {
			case 'company' :
				$headings[$_SESSION['preferences']['activityColumns'][$i]] = _('Account');
				break;
			case 'name' :
				$headings[$_SESSION['preferences']['activityColumns'][$i]] = _('Name');
				break;
			case 'opportunity' :
				$headings[$_SESSION['preferences']['activityColumns'][$i]] = _('Attached To');
				break;
			case 'activity' :
				$headings[$_SESSION['preferences']['activityColumns'][$i]] = _('Type');
				break;
			case 'startdate' :
				$headings[$_SESSION['preferences']['activityColumns'][$i]] = _('Start Date');
				break;
			case 'enddate' :
				$headings[$_SESSION['preferences']['activityColumns'][$i]] = _('End Date');
				break;
			case 'assigned' :
				$headings[$_SESSION['preferences']['activityColumns'][$i]] = _('Assigned To');
				break;
			case 'person' :
				$headings[$_SESSION['preferences']['activityColumns'][$i]] = _('Contact');
				break;
			case 'assigned' :
				$headings[$_SESSION['preferences']['activityColumns'][$i]] = _('Assigned');
				break;
			case 'completed' :
				$headings[$_SESSION['preferences']['activityColumns'][$i]] = _('Completed');
				break;
			case 'owner' :
				$headings[$_SESSION['preferences']['activityColumns'][$i]] = _('Owner');
				break;
			case 'assigned' :
				$headings[$_SESSION['preferences']['activityColumns'][$i]] = _('Assigned');
				break;
		}
	}

	$smarty->assign('headings', $headings);

	/* Do Search */
	if (sizeof($_POST) > 0) {
		$egs->checkPost();

		/* do a delete if necessary */
		if (isset ($_POST['delete']) && sizeof($_POST['delete'])) {
			while (list ($key, $val) = each($_POST['delete'])) {
				require_once (EGS_FILE_ROOT.'/src/classes/class.crm.php');

				$crm = new crm();

				$crm->deleteActivity(intval($val));
			}

			$smarty->assign('messages', array (_('Activitys deleted')));
		}

		$save = false;

		if (!isset ($_SESSION['activitySearch']) || ($_SESSION['activitySearch'] == '') || isset ($_POST['clearsearch'])) {
			if (isset ($_SESSION['preferences']['activitySearch']))
				$_SESSION['activitySearch'] = $_SESSION['preferences']['activitySearch'];
			else
				unset ($_SESSION['activitySearch']);
		}

		/* If Saving, set to search then save */
		if (isset ($_POST['savesearch'])) {
			unset ($_POST['savesearch']);
			$_SESSION['preferences']['activitySearch'] = $_POST;
			$_SESSION['activitySearch'] = $_POST;
			$egs->syncPreferences();
		}

		/* We are searching */
		if (isset ($_POST['search'])) {
			unset ($_POST['search']);
			$_SESSION['activitySearch'] = $_POST;
			$_SESSION['activity_page'] = 1;
		}
	} else
		if (!isset ($_SESSION['activitySearch']) && isset ($_SESSION['preferences']['activitySearch']))
			$_SESSION['activitySearch'] = $_SESSION['preferences']['activitySearch'];

	/* Set the search order */
	if (isset ($_GET['order']) && ($_GET['order'] == $_SESSION['activityOrder']) && in_array($_GET['order'], $_SESSION['preferences']['activityColumns'])) {
		if (isset ($_SESSION['activitySort']) && ($_SESSION['activitySort'] == 'ASC'))
			$_SESSION['activitySort'] = 'DESC';
		else
			if (isset ($_SESSION['activitySort']) && ($_SESSION['activitySort'] == 'DESC'))
				$_SESSION['activitySort'] = 'ASC';
		$_SESSION['activity_page'] = 1;
	} else
		if (isset ($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['activityColumns'])) {
			$_SESSION['activitySort'] = 'DESC';
			$_SESSION['activityOrder'] = $_GET['order'];
			$_SESSION['activity_page'] = 1;
		}

	if (!isset ($_SESSION['activityOrder']))
		$_SESSION['activityOrder'] = $_SESSION['preferences']['activityColumns'][0];
	if (!isset ($_SESSION['activitySort']))
		$_SESSION['activitySort'] = 'ASC';

	$_SESSION['order'] = $_SESSION['activityOrder'];

	/* Build the query to get the relevant columns */
	$query = 'SELECT caseid, opportunityid, companyid, personid, id, ';

	$links = array ();

	for ($i = 0; $i < sizeof($_SESSION['preferences']['activityColumns']); $i ++) {
		if ($_SESSION['preferences']['activityColumns'][$i] == 'company')
			$links[$i+1] = '&amp;module=contacts&amp;action=view&amp;id=';
		if ($_SESSION['preferences']['activityColumns'][$i] == 'person')
			$links[$i+1] = '&amp;module=contacts&amp;action=viewperson&amp;id=';

		if (strpos($_SESSION['preferences']['activityColumns'][$i], 'date'))
			$query .= $db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), $_SESSION['preferences']['activityColumns'][$i]).' AS '.$_SESSION['preferences']['activityColumns'][$i];
		else if($_SESSION['preferences']['activityColumns'][$i] == 'completed')
			$query .= 'CASE WHEN completed IS NULL THEN '.$db->qstr(_('No')).' ELSE '.$db->qstr(_('Yes')).' END AS completed';
		else if($_SESSION['preferences']['activityColumns'][$i] == 'opportunity')
			$query .= 'CASE WHEN opportunity IS NULL THEN casename ELSE opportunity END AS attachedto';
		else
			$query .= $_SESSION['preferences']['activityColumns'][$i];
		if (($i +1) != sizeof($_SESSION['preferences']['activityColumns']))
			$query .= ', ';
	}

	$query .= ' FROM activityoverview WHERE usercompanyid='.$db->qstr(EGS_COMPANY_ID);

	if (isset ($_SESSION['activitySearch']) && (sizeof($_SESSION['activitySearch']) > 0)) {
		$searchString = $egs->searchString($_SESSION['activitySearch']);

		if ($searchString != '')
			$query .= ' AND '.$searchString;

		$_SESSION['search'] = $_SESSION['activitySearch'];
	} else
		if (isset ($_SESSION['search']))
			unset ($_SESSION['search']);

	$query .= ' ORDER BY '.$_SESSION['activityOrder'].' '.$_SESSION['activitySort'];

	$smarty->assign('viewType', 'activity');
	
	/* Set up the pager and send the query */
	$egs->page($query, 'activity_page', $links);
} else {
	$smarty->assign('errors', array (_('You are trying to access a module to which you do not have access, if you beleive you should please contact your system administrator')));
	$smarty->assign('redirect',true);
	$smarty->assign('redirectAction','');
}
?>
