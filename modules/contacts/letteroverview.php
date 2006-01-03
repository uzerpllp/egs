<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Save Account Access 1.0          |
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
/* If the page has not been set, set it */
if (isset ($_GET['page']))
	$_SESSION['letter_page'] = max(1, intval($_GET['page']));
if (!isset ($_SESSION['letter_page']))
	$_SESSION['letter_page'] = 1;

$smarty->assign('hideToggle', true);
$smarty->assign('queue', true);

/* Set the page title */
$smarty->assign('pageTitle', _('Letters'));

/* Setup the search box */
$smarty->assign('searchTitle', _('Search Letters'));

/* Set the search type */
if (isset ($_GET['search']) && ($_GET['search'] == 'adv'))
	$_SESSION['letterSearchType'] = 'adv';
else
	if (isset ($_GET['search']) && ($_GET['search'] == 'norm'))
		$_SESSION['letterSearchType'] = 'norm';
	else
		if (!isset ($_SESSION['letterSearchType']))
			$_SESSION['letterSearchType'] = 'norm';

$smarty->assign('searchForm', $_SESSION['letterSearchType']);

$search = array ();

$search['l.name'] = array ('name' => _('Letter Name'), 'type' => 'text');
$search['p.firstname'] = array ('name' => _('Contact First Name'), 'type' => 'text');
$search['p.surname'] = array ('name' => _('Contact Surname'), 'type' => 'text');
$search['c.name'] = array ('name' => _('Company Name'), 'type' => 'text');
$search['ref'] = array ('name' => _('Letter Reference No.'), 'type' => 'text');

if (!isset ($_SESSION['letterSearch']))
	$_SESSION['letterSearch'] = array ();

$smarty->assign('search', $search);

$_SESSION['preferences']['letterColumns'] = array ();
$_SESSION['preferences']['letterColumns'][] = 'ref';
$_SESSION['preferences']['letterColumns'][] = 'p.firstname';
$_SESSION['preferences']['letterColumns'][] = 'p.surname';
$_SESSION['preferences']['letterColumns'][] = 'c.name';
$_SESSION['preferences']['letterColumns'][] = 'lrsent';

/* Array to hold the columns */
$headings = array ();

/* Iterate over the columns and translate */
for ($i = 0; $i < sizeof($_SESSION['preferences']['letterColumns']); $i ++) {
	switch ($_SESSION['preferences']['letterColumns'][$i]) {

		case 'ref' :
			$headings[$_SESSION['preferences']['letterColumns'][$i]] = _('Letter Reference No.');
			break;
		case 'p.firstname' :
			$headings[$_SESSION['preferences']['letterColumns'][$i]] = _('First Name');
			break;
		case 'p.surname' :
			$headings[$_SESSION['preferences']['letterColumns'][$i]] = _('Surname');
			break;
		case 'c.name' :
			$headings[$_SESSION['preferences']['letterColumns'][$i]] = _('Company Name');
			break;
		case 'lrsent' :
			$headings[$_SESSION['preferences']['letterColumns'][$i]] = _('Date');
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
			require_once (EGS_FILE_ROOT.'/src/classes/class.letter.php');

			$letter = new letter();

			$letter->deleteLetter(intval($val));
		}

		$smarty->assign('messages', array (_('Letters deleted')));
	}

	$save = false;
	if (isset ($_POST['clearsearch'])) {
		$clearsearch = $_POST['clearsearch'];
		unset ($_POST['clearsearch']);
	}
	if (!isset ($_SESSION['letterSearch']) || ($_SESSION['letterSearch'] == '') || isset ($clearsearch)) {
		if (isset ($_SESSION['preferences']['letterSearch']))
			$_SESSION['letterSearch'] = $_SESSION['preferences']['letterSearch'];
		else
			unset ($_SESSION['letterSearch']);
	}

	/* If Saving, set to search then save */
	if (isset ($_POST['savesearch'])) {
		unset ($_POST['savesearch']);
		$_SESSION['preferences']['letterSearch'] = $_POST;
		$_SESSION['letterSearch'] = $_POST;
		$egs->syncPreferences();
	}

	/* We are searching */
	if (isset ($_POST['search'])) {
		unset ($_POST['search']);
		$_SESSION['letterSearch'] = $_POST;
		$_SESSION['letter_page'] = 1;
	}
} else
	if (!isset ($_SESSION['letterSearch']) && isset ($_SESSION['preferences']['letterSearch']))
		$_SESSION['letterSearch'] = $_SESSION['preferences']['letterSearch'];

/* Set the search order */
if (isset ($_GET['order']) && ($_GET['order'] == $_SESSION['letterOrder']) && in_array($_GET['order'], $_SESSION['preferences']['letterColumns'])) {
	if (isset ($_SESSION['letterSort']) && ($_SESSION['letterSort'] == 'ASC'))
		$_SESSION['letterSort'] = 'DESC';
	else
		if (isset ($_SESSION['letterSort']) && ($_SESSION['letterSort'] == 'DESC'))
			$_SESSION['letterSort'] = 'ASC';
	$_SESSION['letter_page'] = 1;
} else
	if (isset ($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['letterColumns'])) {
		$_SESSION['letterSort'] = 'DESC';
		$_SESSION['letterOrder'] = $_GET['order'];
		$_SESSION['letter_page'] = 1;
	}

if (!isset ($_SESSION['letterOrder']))
	$_SESSION['letterOrder'] = $_SESSION['preferences']['letterColumns'][0];
if (!isset ($_SESSION['letterSort']))
	$_SESSION['letterSort'] = 'ASC';

$_SESSION['order'] = $_SESSION['letterOrder'];

$ok = false;
if (isset ($_SESSION['letterSearch']['ref']) && is_numeric($_SESSION['letterSearch']['ref']))
	$ok = true;
if (isset ($_SESSION['ref']) && ($_SESSION['ref'] == ''))
	$ok = true;

//keep track of search terms
if (isset ($_SESSION['letterSearch']) && (sizeof($_SESSION['letterSearch']) > 0)) {
	$_SESSION['search'] = $_SESSION['letterSearch'];
} else
	if (isset ($_SESSION['search']))
		unset ($_SESSION['search']);
$searchString = '';
//build query

$sent = 'sent';
$query = 'SELECT lr.id, l.companyid ||'.$db->qstr('/').'|| l.id || '.$db->qstr('/').'|| lr.id AS ref, p.firstname, p.surname, c.name,';
$query .= $db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'lr.'.$sent).' AS lrsent ';
$query .= 'FROM letters l, letterrefs lr, company c, person p, companyaccess ca ';
$query .= 'WHERE ca.username='.$db->qstr(EGS_USERNAME).' AND ca.companyid='.$db->qstr(EGS_COMPANY_ID).' AND ca.type>0 AND lr.companyid = c.id AND l.id = lr.letterid AND lr.personid = p.id AND l.companyid='.$db->qstr(EGS_COMPANY_ID).' ';

if (isset ($_SESSION['letterSearch']) && (sizeof($_SESSION['letterSearch']) > 0)) {
	$searchString = $egs->searchString($_SESSION['letterSearch']);
	$searchString = str_replace('ref', "l.companyid || '/' || l.id || '/' || lr.id", $searchString);
	if ($searchString != '')
		$query .= ' AND '.$searchString;

	$_SESSION['search'] = $_SESSION['letterSearch'];
}

$query = str_replace('AND )', '', $query);
/* Set up the pager and send the query */
$query .= ' ORDER BY '.$_SESSION['order'].' '.$_SESSION['letterSort'];

$egs->page($query, 'letter_page');
$smarty->assign('viewType', 'letter');
//echo 'test';
?>