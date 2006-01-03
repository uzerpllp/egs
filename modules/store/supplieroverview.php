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

/* Check user has access to the store module */
if (in_array('store', $_SESSION['modules'])) {
	/* If the page has not been set, set it */
	if (isset ($_GET['page']))
		$_SESSION['supplier_page'] = max(1, intval($_GET['page']));
	if (!isset ($_SESSION['supplier_page']))
		$_SESSION['supplier_page'] = 1;

	/* Set the page title */
	$smarty->assign('pageTitle', _('Store: Suppliers'));

	/* Setup the search box */
	$smarty->assign('searchTitle', _('Search Suppliers'));

	/* Set the search type */
	
	$smarty->assign('searchForm', 'norm');
	$smarty->assign('hideAdvancedSearch',true);
	$search = array ();

	$search['name'] = array ('name' => _('Name'), 'type' => 'text');

	$smarty->assign('search', $search);

	$smarty->assign('hideSaveSearch',true);

	/*no choice in ordering for suppliers*/

	$_SESSION['preferences']['supplierColumns'] = array ();
	$_SESSION['preferences']['supplierColumns'][] = 'name';
	$_SESSION['preferences']['supplierColumns'][] = 'description';
	$_SESSION['preferences']['supplierColumns'][] = 'created';
	$_SESSION['preferences']['supplierColumns'][] = 'owner';
	$_SESSION['preferences']['supplierColumns'][] = 'lastupdated';
	$_SESSION['preferences']['supplierColumns'][] = 'alteredby';

	/* Array to hold the columns */
	$headings = array ();

	/* Iterate over the columns and translate */
	for ($i = 0; $i < sizeof($_SESSION['preferences']['supplierColumns']); $i ++) {
		switch ($_SESSION['preferences']['supplierColumns'][$i]) {
			case 'name' :
				$headings[$_SESSION['preferences']['supplierColumns'][$i]] = _('Supplier');
				break;
			case 'description' :
				$headings[$_SESSION['preferences']['supplierColumns'][$i]] = _('Description');
				break;
			case 'created' :
				$headings[$_SESSION['preferences']['supplierColumns'][$i]] = _('Date Created');
				break;
			case 'owner' :
				$headings[$_SESSION['preferences']['supplierColumns'][$i]] = _('Owner');
				break;
			case 'lastupdated' :
				$headings[$_SESSION['preferences']['supplierColumns'][$i]] = _('Last Updated');
				break;
			case 'alteredby' :
				$headings[$_SESSION['preferences']['supplierColumns'][$i]] = _('Altered By');
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
				require_once (EGS_FILE_ROOT.'/src/classes/class.store.php');

				$store = new store();

				$store->deleteSupplier(intval($val));
			}

			$smarty->assign('messages', array (_('Suppliers deleted')));
		}

		$save = false;

		if (!isset ($_SESSION['supplierSearch']) || ($_SESSION['supplierSearch'] == '') || isset ($_POST['clearsearch'])) {
			if (isset ($_SESSION['preferences']['supplierSearch']))
				$_SESSION['supplierSearch'] = $_SESSION['preferences']['supplierSearch'];
			else
				unset ($_SESSION['supplierSearch']);
		}

		/* If Saving, set to search then save */
		if (isset ($_POST['savesearch'])) {
			unset ($_POST['savesearch']);
			$_SESSION['preferences']['supplierSearch'] = $_POST;
			$_SESSION['supplierSearch'] = $_POST;
			$egs->syncPreferences();
		}

		/* We are searching */
		if (isset ($_POST['search'])) {
			unset ($_POST['search']);
			$_SESSION['supplierSearch'] = $_POST;
			$_SESSION['supplier_page'] = 1;
		}
	} else
		if (!isset ($_SESSION['supplierSearch']) && isset ($_SESSION['preferences']['supplierSearch']))
			$_SESSION['supplierSearch'] = $_SESSION['preferences']['supplierSearch'];

	/* Set the search order */
	if (isset ($_GET['order']) && ($_GET['order'] == $_SESSION['supplierOrder']) && in_array($_GET['order'], $_SESSION['preferences']['supplierColumns'])) {
		if (isset ($_SESSION['supplierSort']) && ($_SESSION['supplierSort'] == 'ASC'))
			$_SESSION['supplierSort'] = 'DESC';
		else
			if (isset ($_SESSION['supplierSort']) && ($_SESSION['supplierSort'] == 'DESC'))
				$_SESSION['supplierSort'] = 'ASC';
		$_SESSION['supplier_page'] = 1;
	} else
		if (isset ($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['supplierColumns'])) {
			$_SESSION['supplierSort'] = 'DESC';
			$_SESSION['supplierOrder'] = $_GET['order'];
			$_SESSION['supplier_page'] = 1;
		}

	if (!isset ($_SESSION['supplierOrder']))
		$_SESSION['supplierOrder'] = $_SESSION['preferences']['supplierColumns'][0];
	if (!isset ($_SESSION['supplierSort']))
		$_SESSION['supplierSort'] = 'ASC';

	$_SESSION['order'] = $_SESSION['supplierOrder'];

	/* Build the query to get the relevant columns */
	$query = 'SELECT s.id, ';

	$links = array ();

	for ($i = 0; $i < sizeof($_SESSION['preferences']['supplierColumns']); $i ++) {
		if ($_SESSION['preferences']['supplierColumns'][$i] == 'company')
			$links[$i +1] = '&amp;module=contacts&amp;action=view&amp;id=';
		if ($_SESSION['preferences']['supplierColumns'][$i] == 'person')
			$links[$i +1] = '&amp;module=contacts&amp;action=viewperson&amp;id=';
	
		if ($_SESSION['preferences']['supplierColumns'][$i] == 'created' || $_SESSION['preferences']['supplierColumns'][$i] == 'lastupdated')
			$query .= $db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 's.'.$_SESSION['preferences']['supplierColumns'][$i]).' AS '.$_SESSION['preferences']['supplierColumns'][$i];
		else if($_SESSION['preferences']['supplierColumns'][$i] == 'name')
			$query .= 'c.'.$_SESSION['preferences']['supplierColumns'][$i];
		else
			$query .= 's.'.$_SESSION['preferences']['supplierColumns'][$i];
		if (($i +1) != sizeof($_SESSION['preferences']['supplierColumns']))
			$query .= ', ';
	}

	$query .= ' FROM store_suppliers s, company c WHERE s.supplierid=c.id AND  s.companyid='.$db->qstr(EGS_COMPANY_ID);

	if (isset ($_SESSION['supplierSearch']) && (sizeof($_SESSION['supplierSearch']) > 0)) {
		$searchString = $egs->searchString($_SESSION['supplierSearch']);

		if ($searchString != '')
			$query .= ' AND '.$searchString;

		$_SESSION['search'] = $_SESSION['supplierSearch'];
	} else
		if (isset ($_SESSION['search']))
			unset ($_SESSION['search']);

	$query .= ' ORDER BY '.$_SESSION['supplierOrder'].' '.$_SESSION['supplierSort'];

	$smarty->assign('viewType', 'supplier');
	$smarty->assign('forceSave', 'true');
	$smarty->assign('pageNew', 'action=savesupplier');
	/* Set up the pager and send the query */
	$egs->page($query, 'supplier_page', $links);
} else {
	$smarty->assign('errors', array (_('You are trying to access a module to which you do not have access, if you beleive you should please contact your system administrator')));
	$smarty->assign('redirect', true);
	$smarty->assign('redirectAction', '');
}
?>

