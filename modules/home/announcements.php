<?php


// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Projects 1.0                     |
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

/*This page displays the overview of all past announcements
  Deleting/Editing/Adding are done from the admin menu*/

/* If the page has not been set, set it */
if (isset ($_GET['page']))
	$_SESSION['announcements_page'] = max(1, intval($_GET['page']));
if (!isset ($_SESSION['announcements_page']))
	$_SESSION['announcements_page'] = 1;

/* Set the page title */
$smarty->assign('pageTitle', _('Announcements Archive'));

/* Setup the search box */
$smarty->assign('searchTitle', _('Search Announcements'));

/* Set the search type */
if (isset ($_GET['search']) && ($_GET['search'] == 'adv'))
	$_SESSION['announcementsSearchType'] = 'adv';
else
	if (isset ($_GET['search']) && ($_GET['search'] == 'norm'))
		$_SESSION['announcementsSearchType'] = 'norm';
	else
		if (!isset ($_SESSION['announcementsSearchType']))
			$_SESSION['announcementsSearchType'] = 'norm';

$smarty->assign('searchForm', $_SESSION['announcementsSearchType']);

/*no choice for announcement-columns, but uses $_SESSION for consistency*/

$_SESSION['preferences']['announcementsColumns'] = array ();
$_SESSION['preferences']['announcementsColumns'][] = 'published';
$_SESSION['preferences']['announcementsColumns'][] = 'headline';
$_SESSION['preferences']['announcementsColumns'][] = 'teaser';
$_SESSION['preferences']['announcementsColumns'][] = 'url';

/* Array to hold the columns */
$headings = array ();

/* Iterate over the columns and translate */
for ($i = 0; $i < sizeof($_SESSION['preferences']['announcementsColumns']); $i ++) {
	switch ($_SESSION['preferences']['announcementsColumns'][$i]) {
		case 'headline' :
			$headings[$_SESSION['preferences']['announcementsColumns'][$i]] = _('Headline.');
			break;
		case 'teaser' :
			$headings[$_SESSION['preferences']['announcementsColumns'][$i]] = _('Teaser');
			break;
		case 'url' :
			$headings[$_SESSION['preferences']['announcementsColumns'][$i]] = _('Website');
			break;
		case 'published' :
			$headings[$_SESSION['preferences']['announcementsColumns'][$i]] = _('Date Published');
			break;

	}
}

$smarty->assign('headings', $headings);

/* Set the search order */
if (isset ($_GET['order']) && ($_GET['order'] == $_SESSION['announcementsOrder']) && in_array($_GET['order'], $_SESSION['preferences']['announcementsColumns'])) {
	if (isset ($_SESSION['announcementsSort']) && ($_SESSION['announcementsSort'] == 'ASC'))
		$_SESSION['announcementsSort'] = 'DESC';
	else
		if (isset ($_SESSION['announcementsSort']) && ($_SESSION['announcementsSort'] == 'DESC'))
			$_SESSION['announcementsSort'] = 'ASC';
	$_SESSION['announcements_page'] = 1;
} else
	if (isset ($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['announcementsColumns'])) {
		$_SESSION['announcementsSort'] = 'DESC';
		$_SESSION['announcementsOrder'] = $_GET['order'];
		$_SESSION['announcements_page'] = 1;
	}

if (!isset ($_SESSION['announcementsOrder']))
	$_SESSION['announcementsOrder'] = $_SESSION['preferences']['announcementsColumns'][3];
if (!isset ($_SESSION['announcementsSort']))
	$_SESSION['announcementsSort'] = 'DESC';

$_SESSION['order'] = $_SESSION['announcementsOrder'];

/* Build the query to get the relevant columns */
$query = 'SELECT id, ';

$category = false;

for ($i = 0; $i < sizeof($_SESSION['preferences']['announcementsColumns']); $i ++) {
	if ($_SESSION['preferences']['announcementsColumns'][$i] == 'url')
		$query .= 'CASE WHEN url IS NULL THEN '.$db->qstr('N/A').' ELSE url END AS url';
	else
		if ($_SESSION['preferences']['announcementsColumns'][$i] == 'published')
			$query .= $db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'n.'.$_SESSION['preferences']['announcementsColumns'][$i]).' AS '.$_SESSION['preferences']['announcementsColumns'][$i];
		else
			$query .= $_SESSION['preferences']['announcementsColumns'][$i];
	if (($i +1) != sizeof($_SESSION['preferences']['announcementsColumns']))
		$query .= ', ';
}

$query .= ' FROM news n ';

$query .= 'WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' AND news=false AND motd=false AND domainid IS NULL AND visible AND (showfrom<=now() OR showfrom IS NULL) AND (showuntil>=now() OR showuntil IS NULL)';

$query .= ' ORDER BY n.'.$_SESSION['announcementsOrder'].' '.$_SESSION['announcementsSort'];
$smarty->assign('hideToggle', true);
$smarty->assign('viewType', 'announcements');
/* Set up the pager and send the query */
$egs->page($query, 'announcements_page');
?>

