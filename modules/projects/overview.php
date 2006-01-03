<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Project Overviews 1.0            |
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

if(isset($_GET['page'])) $_SESSION['project_page'] = max(1, intval($_GET['page']));
/* If the page has not been set, set it */
if (!isset ($_SESSION['project_page']))
	$_SESSION['project_page'] = 1;

/* Set the page title */
$smarty->assign('pageTitle', _('Projects'));

/* Setup the search box */
$smarty->assign('searchTitle', _('Search Projects'));

/* Set the search type */
if(isset($_GET['search']) && ($_GET['search'] == 'adv')) $_SESSION['projectSearchType'] = 'adv';
else if(isset($_GET['search']) && ($_GET['search'] == 'norm')) $_SESSION['projectSearchType'] = 'norm';
else if(!isset($_SESSION['projectSearchType'])) $_SESSION['projectSearchType'] = 'norm';

/* Set up the search fields */
$search = array ();

/* These are the standard fields */
$search['p_jobno'] = array ('name' => _('Job No.'), 'type' => 'text');
$search['p_name'] = array ('name' => _('Job Name'), 'type' => 'text');
$search['p_companyname'] = array ('name' => _('Client'), 'type' => 'text');

/* And these are the 'advanced' search fields */
if($_SESSION['projectSearchType'] == 'adv') {
$search['p_completed//boolean'] = array ('name' => _('Completed Jobs'), 'type' => 'select', 'values' => array (_('All') => '', _('Yes') => 'true', _('No') => 'false'));
$search['p_invoiced//boolean'] = array ('name' => _('Invoiced Jobs'), 'type' => 'select', 'values' => array (_('All') => '', _('Yes') => 'true', _('No') => 'false'));
$search['p_archived//boolean'] = array ('name' => _('Archived Jobs'), 'type' => 'select', 'values' => array (_('All') => '', _('Yes') => 'true', _('No') => 'false'));
}

$smarty->assign('searchForm', $_SESSION['projectSearchType']);

$smarty->assign('search', $search);

/* If no default column ordering is set for the project, setup the default */
if (!isset ($_SESSION['preferences']['projectColumns']) || !is_array($_SESSION['preferences']['projectColumns'])) {
	$_SESSION['preferences']['projectColumns'] = array ();
	$_SESSION['preferences']['projectColumns'][] = 'jobno';
	$_SESSION['preferences']['projectColumns'][] = 'name';
	$_SESSION['preferences']['projectColumns'][] = 'companyname';
	$_SESSION['preferences']['projectColumns'][] = 'personname';
	$_SESSION['preferences']['projectColumns'][] = 'enddate';
	$_SESSION['preferences']['projectColumns'][] = 'actualenddate';
	$_SESSION['preferences']['projectColumns'][] = 'hours';
	$_SESSION['preferences']['projectColumns'][] = 'completed';
	$_SESSION['preferences']['projectColumns'][] = 'invoiced';
	$_SESSION['preferences']['projectColumns'][] = 'archived';
}

/* Array to hold the columns */
$headings = array ();

/* Iterate over the columns and translate */
for ($i = 0; $i < sizeof($_SESSION['preferences']['projectColumns']); $i ++) {
	switch ($_SESSION['preferences']['projectColumns'][$i]) {
		case 'jobno' :
			$headings[$_SESSION['preferences']['projectColumns'][$i]] = _('Job Num.');
			break;
		case 'name' :
			$headings[$_SESSION['preferences']['projectColumns'][$i]] = _('Job Name');
			break;
		case 'companyname' :
			$headings[$_SESSION['preferences']['projectColumns'][$i]] = _('Client');
			break;
		case 'personname' :
			$headings[$_SESSION['preferences']['projectColumns'][$i]] = _('Contact');
			break;
		case 'enddate' :
			$headings[$_SESSION['preferences']['projectColumns'][$i]] = _('Due Date');
			break;
		case 'actualenddate' :
			$headings[$_SESSION['preferences']['projectColumns'][$i]] = _('Actual End Date');
			break;
		case 'hours' :
			$headings[$_SESSION['preferences']['projectColumns'][$i]] = _('Hours Worked');
			break;
		case 'completed' :
			$headings[$_SESSION['preferences']['projectColumns'][$i]] = _('Completed');
			break;
		case 'invoiced' :
			$headings[$_SESSION['preferences']['projectColumns'][$i]] = _('Invoiced');
			break;
		case 'archived' :
			$headings[$_SESSION['preferences']['projectColumns'][$i]] = _('Archived');
			break;
	}
}

$smarty->assign('headings', $headings);

$links = array ();
/* Do Search or delete if necessary */
if (sizeof($_POST) > 0) {
	$egs->checkPost();

	/* do a delete if necessary */
	if (isset ($_POST['delete']) && sizeof($_POST['delete'])) {
		if(!isset($_POST['toggletype'])) {
			while (list ($key, $val) = each($_POST['delete'])) {
				$project->deleteProject(intval($val));
			}
	
			$smarty->assign('messages', array (_('Projects deleted')));
		} else {
			while (list ($key, $val) = each($_POST['delete'])) {
				$project->toggleProject(intval($val), $_POST['toggletype']);
			}
		}
	}

	$save = false;

	/* Set the search if it isn't already set or we are asking to clear it */
	if (!isset ($_SESSION['projectSearch']) || ($_SESSION['projectSearch'] == '') || isset ($_POST['clearsearch'])) {
		/* If this is set then there is a default search so use that */
		if (isset ($_SESSION['preferences']['projectSearch']))
			$_SESSION['projectSearch'] = $_SESSION['preferences']['projectSearch'];
		/* Otherwise just set the search to nothing */
		else
			unset ($_SESSION['projectSearch']);
	}

	/* If Saving, set to search then save in the session/sync to the database */
	if (isset ($_POST['savesearch'])) {
		unset ($_POST['savesearch']);
		$_SESSION['preferences']['projectSearch'] = $_POST;
		$_SESSION['projectSearch'] = $_POST;
		$egs->syncPreferences();
	}

	/* We are searching so set it */
	if (isset ($_POST['search'])) {
		unset ($_POST['search']);
		$_SESSION['projectSearch'] = $_POST;
		$_SESSION['project_page'] = 1;
	}
} else
	if (!isset ($_SESSION['projectSearch']) && isset ($_SESSION['preferences']['projectSearch']))
		$_SESSION['projectSearch'] = $_SESSION['preferences']['projectSearch'];

/* Set the search order */
if (isset ($_GET['order']) && ($_GET['order'] == $_SESSION['projectOrder']) && in_array($_GET['order'], $_SESSION['preferences']['projectColumns'])) {
	if (isset ($_SESSION['projectSort']) && ($_SESSION['projectSort'] == 'ASC'))
		$_SESSION['projectSort'] = 'DESC';
	else
		if (isset ($_SESSION['projectSort']) && ($_SESSION['projectSort'] == 'DESC'))
			$_SESSION['projectSort'] = 'ASC';
	$_SESSION['project_page'] = 1;
} else
	if (isset ($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['projectColumns'])) {
		$_SESSION['projectSort'] = 'DESC';
		$_SESSION['projectOrder'] = $_GET['order'];
		$_SESSION['project_page'] = 1;
	}

if (!isset ($_SESSION['projectOrder']))
	$_SESSION['projectOrder'] = $_SESSION['preferences']['projectColumns'][0];
if (!isset ($_SESSION['projectSort']))
	$_SESSION['projectSort'] = 'ASC';

$_SESSION['order'] = $_SESSION['projectOrder'];

/* Build the query to get the relevant columns */
$query = 'SELECT p.companyid, p.personid, p.id, ';

/* Add the columns to the search */
for ($i = 0; $i < sizeof($_SESSION['preferences']['projectColumns']); $i ++) {
	if ($_SESSION['preferences']['projectColumns'][$i] == 'companyname')
		$links[$i +1] = '&amp;module=contacts&amp;action=view&amp;id=';
	if ($_SESSION['preferences']['projectColumns'][$i] == 'personname')
		$links[$i +1] = '&amp;module=contacts&amp;action=viewperson&amp;id=';

	if (strpos($_SESSION['preferences']['projectColumns'][$i], 'date'))
		$query .= $db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'p.'.$_SESSION['preferences']['projectColumns'][$i]).' AS '.$_SESSION['preferences']['projectColumns'][$i];
	else
		if (($_SESSION['preferences']['projectColumns'][$i] == 'completed') || ($_SESSION['preferences']['projectColumns'][$i] == 'invoiced') || ($_SESSION['preferences']['projectColumns'][$i] == 'archived'))
			$query .= ' CASE WHEN p.'.$_SESSION['preferences']['projectColumns'][$i].' THEN '.$db->qstr(_('Yes')).' ELSE '.$db->qstr(_('No')).' END AS '.$_SESSION['preferences']['projectColumns'][$i];
		else
			$query .= 'p.'.$_SESSION['preferences']['projectColumns'][$i];
	if (($i +1) != sizeof($_SESSION['preferences']['projectColumns']))
		$query .= ', ';
}

$query .= ' FROM projectoverview p, projectaccess a WHERE p.jobno<>0 AND p.id=a.projectid AND a.companyid='.$db->qstr(EGS_COMPANY_ID).' AND a.username='.$db->qstr(EGS_USERNAME);

/* Add the search string */
if (isset ($_SESSION['projectSearch']) && (sizeof($_SESSION['projectSearch']) > 0)) {
	$searchString = $egs->searchString($_SESSION['projectSearch']);

	if ($searchString != '')
		$query .= ' AND '.$searchString;

	$_SESSION['search'] = $_SESSION['projectSearch'];
} else
	if (isset ($_SESSION['search']))
		unset ($_SESSION['search']);

if (!isset ($_SESSION['projectOrder']))
	$_SESSION['projectOrder'] = 'jobno';
if (!isset ($_SESSION['projectSort']))
	$_SESSION['projectSort'] = 'ASC';

$query .= ' ORDER BY p.'.$_SESSION['projectOrder'].' '.$_SESSION['projectSort'];

/* Set up the pager and send the query */
$egs->page($query, 'project_page', $links);
?>
