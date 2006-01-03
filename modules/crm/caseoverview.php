<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Opportunities Overviews 1.0      |
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
		$_SESSION['case_page'] = max(1, intval($_GET['page']));
	if (!isset ($_SESSION['case_page']))
		$_SESSION['case_page'] = 1;

	/* Set the page title */
	$smarty->assign('pageTitle', _('Contacts: Cases'));

	/* Setup the search box */
	$smarty->assign('searchTitle', _('Search Cases'));

	/* Set the search type */
	if (isset ($_GET['search']) && ($_GET['search'] == 'adv'))
		$_SESSION['caseSearchType'] = 'adv';
	else
		if (isset ($_GET['search']) && ($_GET['search'] == 'norm'))
			$_SESSION['caseSearchType'] = 'norm';
		else
			if (!isset ($_SESSION['caseSearchType']))
				$_SESSION['caseSearchType'] = 'norm';

	$smarty->assign('searchForm', $_SESSION['caseSearchType']);

	$search = array ();

	if ($_SESSION['caseSearchType'] == 'adv')
		$search['id'] = array ('name' => _('Case Num.'), 'type' => 'text');
	$search['name'] = array ('name' => _('Subject'), 'type' => 'text');
	$search['company'] = array ('name' => _('Account'), 'type' => 'text');

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

	$search['assigned'] = array ('name' => _('Case Assigned To'), 'type' => 'select', 'values' => $users);

	$smarty->assign('search', $search);

	if ($_SESSION['caseSearchType'] == 'adv') {
		$query = 'SELECT id, name FROM crmcasestatus WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY id';

		$rs = $db->execute($query);

		if (EGS_DEBUG_SQL && !$rs)
			die($db->errorMsg());

		$status = array (_('All') => '');

		while (!$rs->EOF) {
			$status[$rs->fields['name']] = $rs->fields['id'];
			$rs->MoveNext();
		}

		$search['crmstatusid'] = array ('name' => _('Status'), 'type' => 'select', 'values' => $status);

		$query = 'SELECT id, name FROM crmcasepriority WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY id';

		$rs = $db->execute($query);

		if (EGS_DEBUG_SQL && !$rs)
			die($db->errorMsg());

		$priority = array (_('All') => '');

		while (!$rs->EOF) {
			$priority[$rs->fields['name']] = $rs->fields['id'];
			$rs->MoveNext();
		}

		$search['casepriorityid'] = array ('name' => _('Priority'), 'type' => 'select', 'values' => $priority);
	}

	$smarty->assign('search', $search);

	/* If no default column ordering is set for the company, setup the default */
	if (!isset ($_SESSION['preferences']['caseColumns']) || !is_array($_SESSION['preferences']['caseColumns'])) {
		$_SESSION['preferences']['caseColumns'] = array ();
		$_SESSION['preferences']['caseColumns'][] = 'id';
		$_SESSION['preferences']['caseColumns'][] = 'name';
		$_SESSION['preferences']['caseColumns'][] = 'company';
		$_SESSION['preferences']['caseColumns'][] = 'person';
		$_SESSION['preferences']['caseColumns'][] = 'priority';
		$_SESSION['preferences']['caseColumns'][] = 'status';
		$_SESSION['preferences']['caseColumns'][] = 'assigned';
	}

	/* Array to hold the columns */
	$headings = array ();

	/* Iterate over the columns and translate */
	for ($i = 0; $i < sizeof($_SESSION['preferences']['caseColumns']); $i ++) {
		switch ($_SESSION['preferences']['caseColumns'][$i]) {
			case 'id' :
				$headings[$_SESSION['preferences']['caseColumns'][$i]] = _('Num.');
				break;
			case 'company' :
				$headings[$_SESSION['preferences']['caseColumns'][$i]] = _('Account');
				break;
			case 'name' :
				$headings[$_SESSION['preferences']['caseColumns'][$i]] = _('Subject');
				break;
			case 'priority' :
				$headings[$_SESSION['preferences']['caseColumns'][$i]] = _('Priority');
				break;
			case 'status' :
				$headings[$_SESSION['preferences']['caseColumns'][$i]] = _('Status');
				break;
			case 'assigned' :
				$headings[$_SESSION['preferences']['caseColumns'][$i]] = _('Assigned To');
				break;
			case 'person' :
				$headings[$_SESSION['preferences']['caseColumns'][$i]] = _('Contact');
				break;
			case 'email' :
				$headings[$_SESSION['preferences']['caseColumns'][$i]] = _('Email');
				break;
			case 'owner' :
				$headings[$_SESSION['preferences']['caseColumns'][$i]] = _('Owner');
				break;
			case 'assigned' :
				$headings[$_SESSION['preferences']['caseColumns'][$i]] = _('Assigned');
				break;
			case 'enddate' :
				$headings[$_SESSION['preferences']['caseColumns'][$i]] = _('Due Date');
				break;
			case 'type' :
				$headings[$_SESSION['preferences']['caseColumns'][$i]] = _('Type');
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

				$crm->deleteCase(intval($val));
			}

			$smarty->assign('messages', array (_('Cases deleted')));
		}

		$save = false;

		if (!isset ($_SESSION['caseSearch']) || ($_SESSION['caseSearch'] == '') || isset ($_POST['clearsearch'])) {
			if (isset ($_SESSION['preferences']['caseSearch']))
				$_SESSION['caseSearch'] = $_SESSION['preferences']['caseSearch'];
			else
				unset ($_SESSION['caseSearch']);
		}

		/* If Saving, set to search then save */
		if (isset ($_POST['savesearch'])) {
			unset ($_POST['savesearch']);
			$_SESSION['preferences']['caseSearch'] = $_POST;
			$_SESSION['caseSearch'] = $_POST;
			$egs->syncPreferences();
		}

		/* We are searching */
		if (isset ($_POST['search'])) {
			unset ($_POST['search']);
			$_SESSION['caseSearch'] = $_POST;
			$_SESSION['case_page'] = 1;
		}
	} else
		if (!isset ($_SESSION['caseSearch']) && isset ($_SESSION['preferences']['caseSearch']))
			$_SESSION['caseSearch'] = $_SESSION['preferences']['caseSearch'];

	/* Set the search order */
	if (isset ($_GET['order']) && ($_GET['order'] == $_SESSION['caseOrder']) && in_array($_GET['order'], $_SESSION['preferences']['caseColumns'])) {
		if (isset ($_SESSION['caseSort']) && ($_SESSION['caseSort'] == 'ASC'))
			$_SESSION['caseSort'] = 'DESC';
		else
			if (isset ($_SESSION['caseSort']) && ($_SESSION['caseSort'] == 'DESC'))
				$_SESSION['caseSort'] = 'ASC';
		$_SESSION['case_page'] = 1;
	} else
		if (isset ($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['caseColumns'])) {
			$_SESSION['caseSort'] = 'DESC';
			$_SESSION['caseOrder'] = $_GET['order'];
			$_SESSION['case_page'] = 1;
		}

	if (!isset ($_SESSION['caseOrder']))
		$_SESSION['caseOrder'] = $_SESSION['preferences']['caseColumns'][0];
	if (!isset ($_SESSION['caseSort']))
		$_SESSION['caseSort'] = 'ASC';

	$_SESSION['order'] = $_SESSION['caseOrder'];

	/* Build the query to get the relevant columns */
	$query = 'SELECT companyid, personid, id, ';

	$links = array ();

	for ($i = 0; $i < sizeof($_SESSION['preferences']['caseColumns']); $i ++) {
		if ($_SESSION['preferences']['caseColumns'][$i] == 'company')
			$links[$i +1] = '&amp;module=contacts&amp;action=view&amp;id=';
		if ($_SESSION['preferences']['caseColumns'][$i] == 'person')
			$links[$i +1] = '&amp;module=contacts&amp;action=viewperson&amp;id=';

		if (strpos($_SESSION['preferences']['caseColumns'][$i], 'date'))
			$query .= $db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), $_SESSION['preferences']['caseColumns'][$i]).' AS '.$_SESSION['preferences']['caseColumns'][$i];
		else
			$query .= $_SESSION['preferences']['caseColumns'][$i];
		if (($i +1) != sizeof($_SESSION['preferences']['caseColumns']))
			$query .= ', ';
	}

	$query .= ' FROM crmcaseoverview WHERE usercompanyid='.$db->qstr(EGS_COMPANY_ID);

	if (isset ($_SESSION['caseSearch']) && (sizeof($_SESSION['caseSearch']) > 0)) {
		$searchString = $egs->searchString($_SESSION['caseSearch']);

		if ($searchString != '')
			$query .= ' AND '.$searchString;

		$_SESSION['search'] = $_SESSION['caseSearch'];
	} else
		if (isset ($_SESSION['search']))
			unset ($_SESSION['search']);

	$query .= ' ORDER BY '.$_SESSION['caseOrder'].' '.$_SESSION['caseSort'];

	$smarty->assign('viewType', 'case');
	
	/* Set up the pager and send the query */
	$egs->page($query, 'case_page', $links);
} else {
	$smarty->assign('errors', array (_('You are trying to access a module to which you do not have access, if you beleive you should please contact your system administrator')));
	$smarty->assign('redirect',true);
	$smarty->assign('redirectAction','');
}

?>