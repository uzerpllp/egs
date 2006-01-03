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
		$_SESSION['opportunity_page'] = max(1, intval($_GET['page']));
	if (!isset ($_SESSION['opportunity_page']))
		$_SESSION['opportunity_page'] = 1;

	/* Set the page title */
	$smarty->assign('pageTitle', _('Contacts: Opportunities'));

	/* Setup the search box */
	$smarty->assign('searchTitle', _('Search Opportunities'));

	/* Set the search type */
	if (isset ($_GET['search']) && ($_GET['search'] == 'adv'))
		$_SESSION['opportunitySearchType'] = 'adv';
	else
		if (isset ($_GET['search']) && ($_GET['search'] == 'norm'))
			$_SESSION['opportunitySearchType'] = 'norm';
		else
			if (!isset ($_SESSION['opportunitySearchType']))
				$_SESSION['opportunitySearchType'] = 'norm';

	$smarty->assign('searchForm', $_SESSION['opportunitySearchType']);

	$search = array ();

	$search['name'] = array ('name' => _('Opportunity Name'), 'type' => 'text');
	$search['company'] = array ('name' => _('Account Name'), 'type' => 'text');

	if ($_SESSION['opportunitySearchType'] == 'adv')
		$search['person'] = array ('name' => _('Contact Name'), 'type' => 'text');

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

	$search['assigned'] = array ('name' => _('Opportunity Assigned To'), 'type' => 'select', 'values' => $users);

	$smarty->assign('search', $search);

	if ($_SESSION['opportunitySearchType'] == 'adv') {
		$query = 'SELECT id, name FROM crmopportunity WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY id';

		$rs = $db->execute($query);

		if (EGS_DEBUG_SQL && !$rs)
			die($db->errorMsg());

		$stage = array (_('All') => '', _('All Open') => '//OPEN');

		while (!$rs->EOF) {
			$stage[$rs->fields['name']] = $rs->fields['id'];
			$rs->MoveNext();
		}

		$search['crmstatusid'] = array ('name' => _('Opportunity Stage'), 'type' => 'select', 'values' => $stage);

		$search['opportunitytype'] = array ('name' => _('Opportunity Type'), 'type' => 'select', 'values' => array (_('All') => '', _('Exisiting Business') => 1, _('New Business') => 2));

		$query = 'SELECT id, name FROM crmcompanysource WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY name';

		$rs = $db->execute($query);

		if (EGS_DEBUG_SQL && !$rs)
			die($db->errorMsg());

		$source = array (_('All') => '');

		while (!$rs->EOF) {
			$source[$rs->fields['name']] = $rs->fields['id'];
			$rs->MoveNext();
		}

		$search['companysourceid'] = array ('name' => _('Opportunity Source'), 'type' => 'select', 'values' => $source);

		$search['probability'] = array ('name' => _('Certainty'), 'type' => 'text');
		$search['enddate'] = array ('name' => _('End Date'), 'type' => 'text');
	}

	$smarty->assign('search', $search);

	/* If no default column ordering is set for the company, setup the default */
	if (!isset ($_SESSION['preferences']['opportunityColumns']) || !is_array($_SESSION['preferences']['opportunityColumns'])) {
		$_SESSION['preferences']['opportunityColumns'] = array ();
		$_SESSION['preferences']['opportunityColumns'][] = 'name';
		$_SESSION['preferences']['opportunityColumns'][] = 'company';
		$_SESSION['preferences']['opportunityColumns'][] = 'person';
		$_SESSION['preferences']['opportunityColumns'][] = 'status';
		$_SESSION['preferences']['opportunityColumns'][] = 'cost';
		$_SESSION['preferences']['opportunityColumns'][] = 'enddate';
		$_SESSION['preferences']['opportunityColumns'][] = 'assigned';
	}

	/* Array to hold the columns */
	$headings = array ();

	/* Iterate over the columns and translate */
	for ($i = 0; $i < sizeof($_SESSION['preferences']['opportunityColumns']); $i ++) {
		switch ($_SESSION['preferences']['opportunityColumns'][$i]) {
			case 'name' :
				$headings[$_SESSION['preferences']['opportunityColumns'][$i]] = _('Opportunity');
				break;
			case 'company' :
				$headings[$_SESSION['preferences']['opportunityColumns'][$i]] = _('Account');
				break;
			case 'status' :
				$headings[$_SESSION['preferences']['opportunityColumns'][$i]] = _('Sales Stage');
				break;
			case 'cost' :
				$headings[$_SESSION['preferences']['opportunityColumns'][$i]] = _('Amount');
				break;
			case 'added' :
				$headings[$_SESSION['preferences']['opportunityColumns'][$i]] = _('Start Date');
				break;
			case 'enddate' :
				$headings[$_SESSION['preferences']['opportunityColumns'][$i]] = _('End Date');
				break;
			case 'assigned' :
				$headings[$_SESSION['preferences']['opportunityColumns'][$i]] = _('Assigned To');
				break;
			case 'person' :
				$headings[$_SESSION['preferences']['opportunityColumns'][$i]] = _('Contact');
				break;
			case 'email' :
				$headings[$_SESSION['preferences']['opportunityColumns'][$i]] = _('Email');
				break;
			case 'owner' :
				$headings[$_SESSION['preferences']['opportunityColumns'][$i]] = _('Owner');
				break;
			case 'assigned' :
				$headings[$_SESSION['preferences']['opportunityColumns'][$i]] = _('Assigned');
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

				$crm->deleteOpportunity(intval($val));
			}

			$smarty->assign('messages', array (_('Opportunities deleted')));
		}

		$save = false;

		if (!isset ($_SESSION['opportunitySearch']) || ($_SESSION['opportunitySearch'] == '') || isset ($_POST['clearsearch'])) {
			if (isset ($_SESSION['preferences']['opportunitySearch']))
				$_SESSION['opportunitySearch'] = $_SESSION['preferences']['opportunitySearch'];
			else
				unset ($_SESSION['opportunitySearch']);
		}

		/* If Saving, set to search then save */
		if (isset ($_POST['savesearch'])) {
			unset ($_POST['savesearch']);
			$_SESSION['preferences']['opportunitySearch'] = $_POST;
			$_SESSION['opportunitySearch'] = $_POST;
			$egs->syncPreferences();
		}

		/* We are searching */
		if (isset ($_POST['search'])) {
			unset ($_POST['search']);
			$_SESSION['opportunitySearch'] = $_POST;
			$_SESSION['opportunity_page'] = 1;
		}
	} else
		if (!isset ($_SESSION['opportunitySearch']) && isset ($_SESSION['preferences']['opportunitySearch']))
			$_SESSION['opportunitySearch'] = $_SESSION['preferences']['opportunitySearch'];

	/* Set the search order */
	if (isset ($_GET['order']) && ($_GET['order'] == $_SESSION['opportunityOrder']) && in_array($_GET['order'], $_SESSION['preferences']['opportunityColumns'])) {
		if (isset ($_SESSION['opportunitySort']) && ($_SESSION['opportunitySort'] == 'ASC'))
			$_SESSION['opportunitySort'] = 'DESC';
		else
			if (isset ($_SESSION['opportunitySort']) && ($_SESSION['opportunitySort'] == 'DESC'))
				$_SESSION['opportunitySort'] = 'ASC';
		$_SESSION['opportunity_page'] = 1;
	} else
		if (isset ($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['opportunityColumns'])) {
			$_SESSION['opportunitySort'] = 'DESC';
			$_SESSION['opportunityOrder'] = $_GET['order'];
			$_SESSION['opportunity_page'] = 1;
		}

	if (!isset ($_SESSION['opportunityOrder']))
		$_SESSION['opportunityOrder'] = $_SESSION['preferences']['opportunityColumns'][0];
	if (!isset ($_SESSION['opportunitySort']))
		$_SESSION['opportunitySort'] = 'ASC';

	$_SESSION['order'] = $_SESSION['opportunityOrder'];

	/* Build the query to get the relevant columns */
	$query = 'SELECT companyid, personid, id, ';

	$links = array ();

	for ($i = 0; $i < sizeof($_SESSION['preferences']['opportunityColumns']); $i ++) {
		if ($_SESSION['preferences']['opportunityColumns'][$i] == 'company')
			$links[$i +1] = '&amp;module=contacts&amp;action=view&amp;id=';
		if ($_SESSION['preferences']['opportunityColumns'][$i] == 'person')
			$links[$i +1] = '&amp;module=contacts&amp;action=viewperson&amp;id=';

		if (strpos($_SESSION['preferences']['opportunityColumns'][$i], 'date'))
			$query .= $db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), $_SESSION['preferences']['opportunityColumns'][$i]).' AS '.$_SESSION['preferences']['opportunityColumns'][$i];
		else if ($_SESSION['preferences']['opportunityColumns'][$i]=='added')
			$query .= $db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), $_SESSION['preferences']['opportunityColumns'][$i]);
			
		else
			$query .= $_SESSION['preferences']['opportunityColumns'][$i];
		if (($i +1) != sizeof($_SESSION['preferences']['opportunityColumns']))
			$query .= ', ';
	}

	$query .= ' FROM opportunityoverview WHERE usercompanyid='.$db->qstr(EGS_COMPANY_ID);

	if (isset ($_SESSION['opportunitySearch']) && (sizeof($_SESSION['opportunitySearch']) > 0)) {
		$searchString = $egs->searchString($_SESSION['opportunitySearch']);

		if ($searchString != '')
			$query .= ' AND '.$searchString;

		$_SESSION['search'] = $_SESSION['opportunitySearch'];
	} else
		if (isset ($_SESSION['search']))
			unset ($_SESSION['search']);

	$query .= ' ORDER BY '.$_SESSION['opportunityOrder'].' '.$_SESSION['opportunitySort'];
	
	$smarty->assign('viewType', 'opportunity');
	/* Set up the pager and send the query */
	$egs->page($query, 'opportunity_page', $links);
} else {
	$smarty->assign('errors', array (_('You are trying to access a module to which you do not have access, if you beleive you should please contact your system administrator')));
	$smarty->assign('redirect',true);
	$smarty->assign('redirectAction','');
}
?>