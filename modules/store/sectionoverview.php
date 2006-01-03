<?php
// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Sections Overview 1.0            |
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

/* Check user has access to the store module */
if (in_array('store', $_SESSION['modules'])) {
	/* If the page has not been set, set it */
	if (isset ($_GET['page']))
		$_SESSION['section_page'] = max(1, intval($_GET['page']));
	if (!isset ($_SESSION['section_page']))
		$_SESSION['section_page'] = 1;
		
	/* Set the show/hide elements */
	if(!isset($_SESSION['section_page_action'])) $_SESSION['section_page_action'] = array();
	if(isset($_GET['show'])) $_SESSION['section_page_action'][$_GET['show']] = '-';
	if(isset($_GET['hide'])) $_SESSION['section_page_action'][$_GET['hide']] = '+';

	/* Set the page title */
	$smarty->assign('pageTitle', _('Store: Sections'));

	/* Setup the columns to be shown */
	$_SESSION['preferences']['sectionColumns'] = array ();
	$_SESSION['preferences']['sectionColumns'][] = 'title';
	$_SESSION['preferences']['sectionColumns'][] = 'shortdescription';
	$_SESSION['preferences']['sectionColumns'][] = 'visible';
	$_SESSION['preferences']['sectionColumns'][] = 'template';
	$_SESSION['preferences']['sectionColumns'][] = 'owner';
	$_SESSION['preferences']['sectionColumns'][] = 'created';
	$_SESSION['preferences']['sectionColumns'][] = 'lastupdated';

	/* Array to hold the columns */
	$headings = array ();

	/* Iterate over the columns and translate */
	for ($i = 0; $i < sizeof($_SESSION['preferences']['sectionColumns']); $i ++) {
		switch ($_SESSION['preferences']['sectionColumns'][$i]) {
			case 'title' :
				$headings[$_SESSION['preferences']['sectionColumns'][$i]] = _('Section');
				break;
			case 'shortdescription' :
				$headings[$_SESSION['preferences']['sectionColumns'][$i]] = _('Short Description');
				break;
			case 'visible' :
				$headings[$_SESSION['preferences']['sectionColumns'][$i]] = _('Visible');
				break;
			case 'template' :
				$headings[$_SESSION['preferences']['sectionColumns'][$i]] = _('Template');
				break;
			case 'created' :
				$headings[$_SESSION['preferences']['sectionColumns'][$i]] = _('Date Created');
				break;
			case 'owner' :
				$headings[$_SESSION['preferences']['sectionColumns'][$i]] = _('Owner');
				break;
			case 'lastupdated' :
				$headings[$_SESSION['preferences']['sectionColumns'][$i]] = _('Last Updated');
				break;
			case 'alteredby' :
				$headings[$_SESSION['preferences']['sectionColumns'][$i]] = _('Altered By');
				break;

		}
	}

	/* Put the column headings into the template */
	$smarty->assign('headings', $headings);

	/* If variables have been POSTED to the page check what we need to do */
	if (sizeof($_POST) > 0) {
		/* Cleanse the POST variables */
		$egs->checkPost();

		/* Do a delete if necessary */
		if (isset ($_POST['delete']) && sizeof($_POST['delete'])) {
			/* Setup an instance of the store so that we can do the delete */
			require_once (EGS_FILE_ROOT.'/src/classes/class.store.php');
			$store = new store();
				
			/* As this is the page view we need to iterate over as we may have more than one to delete */
			while (list ($key, $val) = each($_POST['delete'])) {
				$store->deleteSection(intval($val));
			}

			/* Send a success message to the template */
			$smarty->assign('messages', array (_('Sections deleted')));
		}

		$save = false;
	}

	/* Set the search order */
	if (isset ($_GET['order']) && ($_GET['order'] == $_SESSION['sectionOrder']) && in_array($_GET['order'], $_SESSION['preferences']['sectionColumns'])) {
		if (isset ($_SESSION['sectionSort']) && ($_SESSION['sectionSort'] == 'ASC'))
			$_SESSION['sectionSort'] = 'DESC';
		else
			if (isset ($_SESSION['sectionSort']) && ($_SESSION['sectionSort'] == 'DESC'))
				$_SESSION['sectionSort'] = 'ASC';
		$_SESSION['section_page'] = 1;
	} else
		if (isset ($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['sectionColumns'])) {
			$_SESSION['sectionSort'] = 'DESC';
			$_SESSION['sectionOrder'] = $_GET['order'];
			$_SESSION['section_page'] = 1;
		}

	if (!isset ($_SESSION['sectionOrder']))
		$_SESSION['sectionOrder'] = $_SESSION['preferences']['sectionColumns'][0];
	if (!isset ($_SESSION['sectionSort']))
		$_SESSION['sectionSort'] = 'ASC';

	$_SESSION['order'] = $_SESSION['sectionOrder'];

	/* Build the query to get the relevant columns */
	$query = 'SELECT s.id, ';

	$links = array ();

	for ($i = 0; $i < sizeof($_SESSION['preferences']['sectionColumns']); $i ++) {
		if ($_SESSION['preferences']['sectionColumns'][$i] == 'created' || $_SESSION['preferences']['sectionColumns'][$i] == 'lastupdated')
			$query .= $db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 's.'.$_SESSION['preferences']['sectionColumns'][$i]).' AS '.$_SESSION['preferences']['sectionColumns'][$i];
		else
			if ($_SESSION['preferences']['sectionColumns'][$i] == 'visible')
				$query .= "CASE WHEN s.visible='t' THEN ".$db->qstr(_('Yes'))." ELSE ".$db->qstr(_('No'))." END as visible";
			else
				$query .= 's.'.$_SESSION['preferences']['sectionColumns'][$i];
		if (($i +1) != sizeof($_SESSION['preferences']['sectionColumns']))
			$query .= ', ';
	}

	$query .= ' FROM store_section s';
	$query .= ' WHERE s.parentsectionid is null';
	$query .= ' AND s.companyid='.$db->qstr(EGS_COMPANY_ID);

	unset ($_SESSION['search']);

	// $query .= ' ORDER BY s.'.$_SESSION['sectionOrder'].' '.$_SESSION['sectionSort'];

	/* Set the variable options for the links in the table */
	$smarty->assign('viewType', 'section');
	$smarty->assign('forceSave', 'true');
	$smarty->assign('search', 'true');
	$smarty->assign('hideSearch', true);
	$smarty->assign('tree', 'true');
	$smarty->assign('pageNew', 'action=savesection');

	/* Set up the pager and send the query */
	$egs->page($query, 'section_page', $links, true);
} else {
	/* User has no access to the store so return an error message */
	$smarty->assign('errors', array (_('You are trying to access a module to which you do not have access, if you beleive you should please contact your system administrator')));
	$smarty->assign('redirect', true);
	$smarty->assign('redirectAction', '');
}


?>