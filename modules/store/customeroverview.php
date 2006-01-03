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
	require_once (EGS_FILE_ROOT.'/src/classes/class.store.php');

	$store = new store();
	/* If the page has not been set, set it */
	if (isset ($_GET['page']))
		$_SESSION['customer_page'] = max(1, intval($_GET['page']));
	if (!isset ($_SESSION['customer_page']))
		$_SESSION['customer_page'] = 1;

	/* Set the page title */
	$smarty->assign('pageTitle', _('Store: Customers'));

	/* Setup the search box */
	$smarty->assign('searchTitle', _('Search Customers'));

	/* Set the search type */
	
	/* Set the search type */
	if(isset($_GET['search']) && ($_GET['search'] == 'adv')) $_SESSION['customerSearchType'] = 'adv';
	else if(isset($_GET['search']) && ($_GET['search'] == 'norm')) $_SESSION['customerSearchType'] = 'norm';
	else if(!isset($_SESSION['customerSearchType'])) $_SESSION['customerSearchType'] = 'norm';
	
	
	$smarty->assign('searchForm', $_SESSION['customerSearchType']);
	
	
	
	$search = array ();

/*basic search*/
	$search['p.firstname'] = array ('name' => _('Firstname'), 'type' => 'text');
	$search['p.surname'] = array ('name' => _('Surname'), 'type' => 'text');


	$smarty->assign('search', $search);

	$smarty->assign('hideSaveSearch',true);

//GREGTASK: will want choice
	/*no choice in ordering for customers*/

	$_SESSION['preferences']['customerColumns'] = array ();
	$_SESSION['preferences']['customerColumns'][] = 'name';
	$_SESSION['preferences']['customerColumns'][] = 'address';
	$_SESSION['preferences']['customerColumns'][] = 'email';
	$_SESSION['preferences']['customerColumns'][] = 'phone';
	$_SESSION['preferences']['customerColumns'][] = 'hasordered';
	$_SESSION['preferences']['customerColumns'][] = 'added';
	//$_SESSION['preferences']['customerColumns'][] = 'hasimage';

	/* Array to hold the columns */
	$headings = array ();

	/* Iterate over the columns and translate */
	for ($i = 0; $i < sizeof($_SESSION['preferences']['customerColumns']); $i ++) {
		switch ($_SESSION['preferences']['customerColumns'][$i]) {
			case 'name' :
				$headings[$_SESSION['preferences']['customerColumns'][$i]] = _('Customer');
				break;
			case 'address' :
				$headings[$_SESSION['preferences']['customerColumns'][$i]] = _('Address');
				break;
			case 'email' :
				$headings[$_SESSION['preferences']['customerColumns'][$i]] = _('Email');
				break;
			case 'phone' :
				$headings[$_SESSION['preferences']['customerColumns'][$i]] = _('Phone');
				break;
			case 'hasordered' :
				$headings[$_SESSION['preferences']['customerColumns'][$i]] = _('Has Ordered');
				break;
			case 'added' :
				$headings[$_SESSION['preferences']['customerColumns'][$i]] = _('Registered');
				break;
			case 'hasimage' :
				$headings[$_SESSION['preferences']['customerColumns'][$i]] = _('Has Image');
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

				$store->deleteCustomer(intval($val));
			}

			$smarty->assign('messages', array (_('Customers deleted')));
		}

		$save = false;

		if (!isset ($_SESSION['customerSearch']) || ($_SESSION['customerSearch'] == '') || isset ($_POST['clearsearch'])) {
			if (isset ($_SESSION['preferences']['customerSearch']))
				$_SESSION['customerSearch'] = $_SESSION['preferences']['customerSearch'];
			else
				unset ($_SESSION['customerSearch']);
		}

		/* If Saving, set to search then save */
		if (isset ($_POST['savesearch'])) {
			unset ($_POST['savesearch']);
			$_SESSION['preferences']['customerSearch'] = $_POST;
			$_SESSION['customerSearch'] = $_POST;
			$egs->syncPreferences();
		}

		/* We are searching */
		if (isset ($_POST['search'])) {
			unset ($_POST['search']);
			$_SESSION['customerSearch'] = $_POST;
			$_SESSION['customer_page'] = 1;
		}
	} else
		if (!isset ($_SESSION['customerSearch']) && isset ($_SESSION['preferences']['customerSearch']))
			$_SESSION['customerSearch'] = $_SESSION['preferences']['customerSearch'];

	/* Set the search order */
	if (isset ($_GET['order']) && ($_GET['order'] == $_SESSION['customerOrder']) && in_array($_GET['order'], $_SESSION['preferences']['customerColumns'])) {
		if (isset ($_SESSION['customerSort']) && ($_SESSION['customerSort'] == 'ASC'))
			$_SESSION['customerSort'] = 'DESC';
		else
			if (isset ($_SESSION['customerSort']) && ($_SESSION['customerSort'] == 'DESC'))
				$_SESSION['customerSort'] = 'ASC';
		$_SESSION['customer_page'] = 1;
	} else
		if (isset ($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['customerColumns'])) {
			$_SESSION['customerSort'] = 'DESC';
			$_SESSION['customerOrder'] = $_GET['order'];
			$_SESSION['customer_page'] = 1;
		}

	if (!isset ($_SESSION['customerOrder']))
		$_SESSION['customerOrder'] = $_SESSION['preferences']['customerColumns'][0];
	if (!isset ($_SESSION['customerSort']))
		$_SESSION['customerSort'] = 'ASC';

	$_SESSION['order'] = $_SESSION['customerOrder'];

	/* Build the query to get the relevant columns */
	$query = 'SELECT c.id, ';

	$links = array ();

	for ($i = 0; $i < sizeof($_SESSION['preferences']['customerColumns']); $i ++) {
		if($_SESSION['preferences']['customerColumns'][$i]=='name')
			$query.='p.firstname || \' \' || p.surname AS name';
		else if($_SESSION['preferences']['customerColumns'][$i]=='address')
			$query.='p.street1 || \', \' || p.street2 || \', \' || p.street3 || \', \' || p.town || \', \' || p.county || \', \' || p.postcode || \', \' || p.countrycode AS address';
		else if($_SESSION['preferences']['customerColumns'][$i]=='hasordered')
			$query.='CASE WHEN p.id IN (SELECT personid FROM store_order) THEN '.$db->qstr(_('Yes')).' ELSE '.$db->qstr(_('No')).' END AS hasordered';
		else if($_SESSION['preferences']['customerColumns'][$i]=='added')
			$query .= $db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'p.'.$_SESSION['preferences']['customerColumns'][$i]).' AS '.$_SESSION['preferences']['customerColumns'][$i];
		else
			$query.='p.'.$_SESSION['preferences']['customerColumns'][$i];
			
		if (($i +1) != sizeof($_SESSION['preferences']['customerColumns']))
			$query .= ', ';
	}

	$query .= ' FROM personoverview p JOIN store_customer c ON (c.personid=p.id)';
	
		
	//$query.=' WHERE p.companyid='.$db->qstr(EGS_COMPANY_ID);
	
	if(isset($_SESSION['customerSearch']['section']))
		$query.=' AND p.customersection=sec.id AND sec.id='.$db->qstr($_SESSION['customerSearch']['section']);
	if(isset($_SESSION['customerSearch']['supplier']))
		$query.=' AND p.supplierid=sup.id AND sup.id='.$db->qstr($_SESSION['customerSearch']['supplier']);
	if(isset($_SESSION['customerSearch']['stock'])) {
		if($_SESSION['customerSearch']['stock']=='in')
			$query.=' AND p.stocklevel>0';
		if($_SESSION['customerSearch']['stock']=='low')
			$query.=' AND p.stocklevel<=p.warninglevel';
		if($_SESSION['customerSearch']['stock']=='out')
			$query.=' AND p.stocklevel=0';	
	}
	
	if (isset ($_SESSION['customerSearch']) && (sizeof($_SESSION['customerSearch']) > 0)) {
		/*take some things out of the search*/
		$remove=array('section','supplier','stock');
		foreach($remove as $searchterm) {
			if(isset($_SESSION['customerSearch'][$searchterm])) {
				$temp[$searchterm]=$_SESSION['customerSearch'][$searchterm];
				unset($_SESSION['customerSearch'][$searchterm]);
			}
		}
				
		
		$searchString = $egs->searchString($_SESSION['customerSearch']);

		/*then put them back in*/
		if(isset($temp)&&count($temp)>0) {
			foreach($temp as $searchterm=>$value) {
				$_SESSION['customerSearch'][$searchterm]=$value;
			}
		}
		if ($searchString != '' && $searchString != ')')
			$query .= ' AND '.$searchString;

		$_SESSION['search'] = $_SESSION['customerSearch'];
	} else
		if (isset ($_SESSION['search']))
			unset ($_SESSION['search']);

	$query .= ' ORDER BY '.$_SESSION['customerOrder'].' '.$_SESSION['customerSort'];

	$smarty->assign('viewType', 'customer');
	
	$smarty->assign('pageNew', 'action=savecustomer');
	/* Set up the pager and send the query */
	
	$egs->page($query, 'customer_page', $links);
} else {
	$smarty->assign('errors', array (_('You are trying to access a module to which you do not have access, if you beleive you should please contact your system administrator')));
	$smarty->assign('redirect', true);
	$smarty->assign('redirectAction', '');
}


?>

