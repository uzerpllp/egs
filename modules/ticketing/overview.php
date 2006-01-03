<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Ticket Overview 1.0              |
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

if (sizeof($_POST) > 0) {
	$egs->checkPost();
}
//unset($_SESSION['ticketingSearch']);
/* If the page has not been set, set it */
if (!isset ($_SESSION['ticketing_page']))
	$_SESSION['ticketing_page'] = 1;
if(isset($_GET['page'])) $_SESSION['ticketing_page'] = $_GET['page'];

/* Set the default search if not set */
if(!isset($_SESSION['ticketingSearch'])) {
	$_SESSION['ticketingSearch']['internalstatus//not'] = 'CLO';
	$_SESSION['ticketingSearch']['status//not'] = 'CLO';
	$_SESSION['ticketingSearch']['internalstatus2//not'] = 'DEL';
	$_SESSION['ticketingSearch']['status2//not'] = 'DEL';
}

/* Set the page title */
$smarty->assign('pageTitle', _('Tickets'));

/* Setup the search box */
$smarty->assign('searchTitle', _('Search Tickets'));

/* Set the search type */
if(isset($_GET['search']) && ($_GET['search'] == 'adv')) $_SESSION['ticketingSearchType'] = 'adv';
else if(isset($_GET['search']) && ($_GET['search'] == 'norm')) $_SESSION['ticketingSearchType'] = 'norm';
else if(!isset($_SESSION['ticketingSearchType'])) $_SESSION['ticketingSearchType'] = 'norm';

/* Set up the search fields */
$search = array ();

/* These are the standard fields */
$search['ticketid'] = array ('name' => _('ID'), 'type' => 'text');

/* Get the queues */
$query = 'SELECT id, name FROM ticketqueue WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY name';

$rs = $db->Execute($query);

$queues = array(_('All') => '');
while(!$rs->EOF) {
	$queues[$rs->fields['name']] = $rs->fields['id'];
	
	$rs->MoveNext();	
}

$search['queueid'] = array ('name' => _('Queue'), 'type' => 'select', 'values' => $queues);

if((isset($_SESSION['ticketingSearch']['queueid']) || isset($_POST['queueid'])) && (!isset ($_POST['clearsearch']))) {
	if(isset($_POST['queueid'])) $queueId = $_POST['queueid'];
	else $queueId = $_SESSION['ticketingSearch']['queueid'];
	
/* Get the internal queues */
$query = 'SELECT id, name FROM internalqueue WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' AND queueid='.$db->qstr($queueId).' ORDER BY name';

$rs = $db->Execute($query);

$queues = array(_('All') => '');
while(!$rs->EOF) {
	$queues[$rs->fields['name']] = $rs->fields['id'];
	
	$rs->MoveNext();	
}

$search['internalqueueid'] = array ('name' => _('Internal Queue'), 'type' => 'select', 'values' => $queues);
} else {
	if(isset($_POST['owner']) || isset($_SESSION['ticketingSearch']['owner'])) $checked = true;
	else $checked = false;
	
	$search['owner'] = array ('name' => _('Only My Tickets'), 'type' => 'checkbox', 'value' => EGS_USERNAME, 'checked' => $checked);
}

/* And these are the 'advanced' search fields */
if($_SESSION['ticketingSearchType'] == 'adv') {
$search['completed//boolean'] = array ('name' => _('Completed Jobs'), 'type' => 'select', 'values' => array (_('All') => '', _('Yes') => 'true', _('No') => 'false'));
$search['invoiced//boolean'] = array ('name' => _('Invoiced Jobs'), 'type' => 'select', 'values' => array (_('All') => '', _('Yes') => 'true', _('No') => 'false'));
$search['archived//boolean'] = array ('name' => _('Archived Jobs'), 'type' => 'select', 'values' => array (_('All') => '', _('Yes') => 'true', _('No') => 'false'));
}

$smarty->assign('searchForm', $_SESSION['ticketingSearchType']);

$smarty->assign('search', $search);

/* If no default column ordering is set for the ticketing, setup the default */
if (!isset ($_SESSION['preferences']['ticketingColumns']) || !is_array($_SESSION['preferences']['ticketingColumns'])) {
	$_SESSION['preferences']['ticketingColumns'] = array ();
	$_SESSION['preferences']['ticketingColumns'][] = 'ticketid';
	$_SESSION['preferences']['ticketingColumns'][] = 'subject';
	$_SESSION['preferences']['ticketingColumns'][] = 'queue';
	$_SESSION['preferences']['ticketingColumns'][] = 'internalqueue';
	$_SESSION['preferences']['ticketingColumns'][] = 'updated';
	$_SESSION['preferences']['ticketingColumns'][] = 'deadline';
	$_SESSION['preferences']['ticketingColumns'][] = 'private';
}

/* Array to hold the columns */
$headings = array ();

/* Iterate over the columns and translate */
for ($i = 0; $i < sizeof($_SESSION['preferences']['ticketingColumns']); $i ++) {
	switch ($_SESSION['preferences']['ticketingColumns'][$i]) {
		case 'ticketid' :
			$headings[$_SESSION['preferences']['ticketingColumns'][$i]] = _('ID');
			break;
		case 'subject' :
			$headings[$_SESSION['preferences']['ticketingColumns'][$i]] = _('Subject');
			break;
		case 'internalqueue' :
			$headings[$_SESSION['preferences']['ticketingColumns'][$i]] = _('Internal Queue');
			break;
		case 'queue' :
			$headings[$_SESSION['preferences']['ticketingColumns'][$i]] = _('Queue');
			break;
		case 'updated' :
			$headings[$_SESSION['preferences']['ticketingColumns'][$i]] = _('Updated');
			break;
		case 'deadline' :
			$headings[$_SESSION['preferences']['ticketingColumns'][$i]] = _('Deadline');
			break;
		case 'private' :
			$headings[$_SESSION['preferences']['ticketingColumns'][$i]] = _('Private');
			break;
		case 'internalstatus' :
			$headings[$_SESSION['preferences']['ticketingColumns'][$i]] = _('Internal Status');
			break;
		case 'status' :
			$headings[$_SESSION['preferences']['ticketingColumns'][$i]] = _('Status');
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
		
		require_once(EGS_FILE_ROOT.'/src/classes/class.ticket.php');

	$ticket = new ticket();
	
		while (list ($key, $val) = each($_POST['delete'])) {
			$ticket->deleteTicket(intval($val));
		}

		$smarty->assign('messages', array (_('Tickets deleted')));
	}

	$save = false;

	/* Set the search if it isn't already set or we are asking to clear it */
	if (!isset ($_SESSION['ticketingSearch']) || ($_SESSION['ticketingSearch'] == '') || isset ($_POST['clearsearch'])) {
		/* If this is set then there is a default search so use that */
		if (isset ($_SESSION['preferences']['ticketingSearch']))
			$_SESSION['ticketingSearch'] = $_SESSION['preferences']['ticketingSearch'];
		/* Otherwise just set the search to nothing */
		else
			unset ($_SESSION['ticketingSearch']);
	}

	/* If Saving, set to search then save in the session/sync to the database */
	if (isset ($_POST['savesearch'])) {
		unset ($_POST['savesearch']);
		$_SESSION['preferences']['ticketingSearch'] = $_POST;
		$_SESSION['ticketingSearch'] = $_POST;
		$egs->syncPreferences();
	}

	/* We are searching so set it */
	if (isset ($_POST['search'])) {
		unset ($_POST['search']);
		$_SESSION['ticketingSearch'] = $_POST;
		$_SESSION['ticketing_page'] = 1;
	}
} else
	if (!isset ($_SESSION['ticketingSearch']) && isset ($_SESSION['preferences']['ticketingSearch']))
		$_SESSION['ticketingSearch'] = $_SESSION['preferences']['ticketingSearch'];

/* Set the search order */
if (isset ($_GET['order']) && ($_GET['order'] == $_SESSION['ticketingOrder']) && in_array($_GET['order'], $_SESSION['preferences']['ticketingColumns'])) {
	if (isset ($_SESSION['ticketingSort']) && ($_SESSION['ticketingSort'] == 'ASC'))
		$_SESSION['ticketingSort'] = 'DESC';
	else
		if (isset ($_SESSION['ticketingSort']) && ($_SESSION['ticketingSort'] == 'DESC'))
			$_SESSION['ticketingSort'] = 'ASC';
	$_SESSION['ticketing_page'] = 1;
} else
	if (isset ($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['ticketingColumns'])) {
		$_SESSION['ticketingSort'] = 'DESC';
		$_SESSION['ticketingOrder'] = $_GET['order'];
		$_SESSION['ticketing_page'] = 1;
	}

if (!isset ($_SESSION['ticketingOrder']))
	$_SESSION['ticketingOrder'] = $_SESSION['preferences']['ticketingColumns'][0];
if (!isset ($_SESSION['ticketingSort']))
	$_SESSION['ticketingSort'] = 'ASC';

$_SESSION['order'] = $_SESSION['ticketingOrder'];

/* Build the query to get the relevant columns */
$query = 'SELECT id, ';

/* Add the columns to the search */
for ($i = 0; $i < sizeof($_SESSION['preferences']['ticketingColumns']); $i ++) {
	if ($_SESSION['preferences']['ticketingColumns'][$i] == 'id')
		$links[$i +1] = '&amp;module=contacts&amp;action=view&amp;id=';
	if ($_SESSION['preferences']['ticketingColumns'][$i] == 'queueid')
		$links[$i +1] = '&amp;module=contacts&amp;action=viewperson&amp;personid=';

	if (($_SESSION['preferences']['ticketingColumns'][$i] == 'updated') || ($_SESSION['preferences']['ticketingColumns'][$i] == 'deadline'))
		$query .= $db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), $_SESSION['preferences']['ticketingColumns'][$i]).' AS '.$_SESSION['preferences']['ticketingColumns'][$i];
	else
		if ($_SESSION['preferences']['ticketingColumns'][$i] == 'private')
			$query .= ' CASE WHEN '.$_SESSION['preferences']['ticketingColumns'][$i].' THEN '.$db->qstr(_('Yes')).' ELSE '.$db->qstr(_('No')).' END AS '.$_SESSION['preferences']['ticketingColumns'][$i];
		else
			$query .= $_SESSION['preferences']['ticketingColumns'][$i];
	if (($i +1) != sizeof($_SESSION['preferences']['ticketingColumns']))
		$query .= ', ';
}
//$query .= 'CASE WHEN ((status=\'CTE\' OR status=\'CCL\') AND (internalstatus=\'CTE\' OR status=\'CCL\')) OR sta
$query .= ' FROM ticketoverview WHERE (private='.$db->qstr('false').' OR (private AND owner='.$db->qstr(EGS_USERNAME).'))';

/* Add the search string */
if (isset ($_SESSION['ticketingSearch']) && (sizeof($_SESSION['ticketingSearch']) > 0)) {
	
	$searchString = $egs->searchString($_SESSION['ticketingSearch']);

	if ($searchString != '')
		$query .= ' AND '.$searchString;

	$_SESSION['search'] = $_SESSION['ticketingSearch'];
} else
	if (isset ($_SESSION['search']))
		unset ($_SESSION['search']);

if (!isset ($_SESSION['ticketingOrder']))
	$_SESSION['ticketingOrder'] = 'updated';
if (!isset ($_SESSION['ticketingSort']))
	$_SESSION['ticketingSort'] = 'DESC';

$query .= ' ORDER BY '.$_SESSION['ticketingOrder'].' '.$_SESSION['ticketingSort'];

/* Set up the pager and send the query */
$egs->page($query, 'ticketing_page', $links);
?>
