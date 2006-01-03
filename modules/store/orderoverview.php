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
		$_SESSION['order_page'] = max(1, intval($_GET['page']));
	if (!isset ($_SESSION['order_page']))
		$_SESSION['order_page'] = 1;

	/* Set the page title */
	$smarty->assign('pageTitle', _('Store: Orders'));

	/* Setup the search box */
	$smarty->assign('searchTitle', _('Search Orders'));

	/* Set the search type */
	
	/* Set the search type */
	if(isset($_GET['search']) && ($_GET['search'] == 'adv')) $_SESSION['orderSearchType'] = 'adv';
	else if(isset($_GET['search']) && ($_GET['search'] == 'norm')) $_SESSION['orderSearchType'] = 'norm';
	else if(!isset($_SESSION['orderSearchType'])) $_SESSION['orderSearchType'] = 'norm';
	
	
	$smarty->assign('searchForm', $_SESSION['orderSearchType']);
	
	
	
	$search = array ();

/*basic search*/
	$search['p.firstname'] = array ('name' => _('Firstname'), 'type' => 'text');
	$search['p.surname'] = array ('name' => _('Surname'), 'type' => 'text');
	$values=$store->getOrderStatuses();
	unset($values['deleted']);
	$values=array('All'=>'')+$values;
	$search['status']=array('name'=>_('Status'),'type'=>'select','values'=>$values);

	$smarty->assign('search', $search);

	$smarty->assign('hideSaveSearch',true);


	/*no choice in ordering for orders*/

	$_SESSION['preferences']['orderColumns'] = array ();
	$_SESSION['preferences']['orderColumns'][] = 'id';
	$_SESSION['preferences']['orderColumns'][] = 'customer';
	$_SESSION['preferences']['orderColumns'][] = 'items';
	$_SESSION['preferences']['orderColumns'][] = 'status';
	$_SESSION['preferences']['orderColumns'][] = 'created';
	//$_SESSION['preferences']['orderColumns'][] = 'added';
	//$_SESSION['preferences']['orderColumns'][] = 'hasimage';

	/* Array to hold the columns */
	$headings = array ();

	/* Iterate over the columns and translate */
	for ($i = 0; $i < sizeof($_SESSION['preferences']['orderColumns']); $i ++) {
		switch ($_SESSION['preferences']['orderColumns'][$i]) {
			case 'id' :
				$headings[$_SESSION['preferences']['orderColumns'][$i]] = _('Order');
				break;
			case 'customer' :
				$headings[$_SESSION['preferences']['orderColumns'][$i]] = _('Customer');
				break;
			case 'items' :
				$headings[$_SESSION['preferences']['orderColumns'][$i]] = _('No. Items');
				break;
			case 'status' :
				$headings[$_SESSION['preferences']['orderColumns'][$i]] = _('Status');
				break;
			case 'created' :
				$headings[$_SESSION['preferences']['orderColumns'][$i]] = _('Created');
				break;
			case 'added' :
				$headings[$_SESSION['preferences']['orderColumns'][$i]] = _('Registered');
				break;
			case 'hasimage' :
				$headings[$_SESSION['preferences']['orderColumns'][$i]] = _('Has Image');
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

				$store->deleteOrder(intval($val));
			}

			$smarty->assign('messages', array (_('Orders deleted')));
		}

		$save = false;

		if (!isset ($_SESSION['orderSearch']) || ($_SESSION['orderSearch'] == '') || isset ($_POST['clearsearch'])) {
			if (isset ($_SESSION['preferences']['orderSearch']))
				$_SESSION['orderSearch'] = $_SESSION['preferences']['orderSearch'];
			else
				unset ($_SESSION['orderSearch']);
		}

		/* If Saving, set to search then save */
		if (isset ($_POST['savesearch'])) {
			unset ($_POST['savesearch']);
			$_SESSION['preferences']['orderSearch'] = $_POST;
			$_SESSION['orderSearch'] = $_POST;
			$egs->syncPreferences();
		}

		/* We are searching */
		if (isset ($_POST['search'])) {
			unset ($_POST['search']);
			$_SESSION['orderSearch'] = $_POST;
			$_SESSION['order_page'] = 1;
		}
	} else
		if (!isset ($_SESSION['orderSearch']) && isset ($_SESSION['preferences']['orderSearch']))
			$_SESSION['orderSearch'] = $_SESSION['preferences']['orderSearch'];

	/* Set the search order */
	if (isset ($_GET['order']) && ($_GET['order'] == $_SESSION['orderOrder']) && in_array($_GET['order'], $_SESSION['preferences']['orderColumns'])) {
		if (isset ($_SESSION['orderSort']) && ($_SESSION['orderSort'] == 'ASC'))
			$_SESSION['orderSort'] = 'DESC';
		else
			if (isset ($_SESSION['orderSort']) && ($_SESSION['orderSort'] == 'DESC'))
				$_SESSION['orderSort'] = 'ASC';
		$_SESSION['order_page'] = 1;
	} else
		if (isset ($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['orderColumns'])) {
			$_SESSION['orderSort'] = 'DESC';
			$_SESSION['orderOrder'] = $_GET['order'];
			$_SESSION['order_page'] = 1;
		}

	if (!isset ($_SESSION['orderOrder']))
		$_SESSION['orderOrder'] = $_SESSION['preferences']['orderColumns'][0];
	if (!isset ($_SESSION['orderSort']))
		$_SESSION['orderSort'] = 'ASC';

	$_SESSION['order'] = $_SESSION['orderOrder'];

	/* Build the query to get the relevant columns */
	$query = 'SELECT DISTINCT c.id, o.id,  ';
	$query = 'SELECT c.id, o.id,  ';
	$links = array ();

	for ($i = 0; $i < sizeof($_SESSION['preferences']['orderColumns']); $i ++) {
		
		if($_SESSION['preferences']['orderColumns'][$i]=='customer') {
			$query.='p.firstname || \' \' || p.surname AS customer';
			$links[$i +1] = '&amp;module=store&amp;action=viewcustomer&amp;id=';
		}
		else if($_SESSION['preferences']['orderColumns'][$i]=='address')
			$query.='p.street1 || \', \' || p.street2 || \', \' || p.street3 || \', \' || p.town || \', \' || p.county || \', \' || p.postcode || \', \' || p.countrycode AS address';
		else if($_SESSION['preferences']['orderColumns'][$i]=='items')
			$query.='(SELECT count(*) FROM store_order_items WHERE orderid=o.id) AS items';
		else if($_SESSION['preferences']['orderColumns'][$i]=='created')
			$query .= $db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'o.'.$_SESSION['preferences']['orderColumns'][$i]).' AS '.$_SESSION['preferences']['orderColumns'][$i];
		else
			$query.='o.'.$_SESSION['preferences']['orderColumns'][$i];
			
		if (($i +1) != sizeof($_SESSION['preferences']['orderColumns']))
			$query .= ', ';
	}

	$query .= ' FROM personoverview p JOIN store_order o ON (o.personid=p.id) JOIN store_customer c ON (c.personid=o.personid) ';
	
		
	//$query.=' WHERE p.companyid='.$db->qstr(EGS_COMPANY_ID);
	
	if(isset($_SESSION['orderSearch']['section']))
		$query.=' AND p.ordersection=sec.id AND sec.id='.$db->qstr($_SESSION['orderSearch']['section']);
	if(isset($_SESSION['orderSearch']['supplier']))
		$query.=' AND p.supplierid=sup.id AND sup.id='.$db->qstr($_SESSION['orderSearch']['supplier']);
	if(isset($_SESSION['orderSearch']['stock'])) {
		if($_SESSION['orderSearch']['stock']=='in')
			$query.=' AND p.stocklevel>0';
		if($_SESSION['orderSearch']['stock']=='low')
			$query.=' AND p.stocklevel<=p.warninglevel';
		if($_SESSION['orderSearch']['stock']=='out')
			$query.=' AND p.stocklevel=0';	
	}
	
	if (isset ($_SESSION['orderSearch']) && (sizeof($_SESSION['orderSearch']) > 0)) {
		/*take some things out of the search*/
		$remove=array('section','supplier','stock');
		foreach($remove as $searchterm) {
			if(isset($_SESSION['orderSearch'][$searchterm])) {
				$temp[$searchterm]=$_SESSION['orderSearch'][$searchterm];
				unset($_SESSION['orderSearch'][$searchterm]);
			}
		}
				
		
		$searchString = $egs->searchString($_SESSION['orderSearch']);

		/*then put them back in*/
		if(isset($temp)&&count($temp)>0) {
			foreach($temp as $searchterm=>$value) {
				$_SESSION['orderSearch'][$searchterm]=$value;
			}
		}
		if ($searchString != '' && $searchString != ')')
			$query .= ' AND '.$searchString;

		$_SESSION['search'] = $_SESSION['orderSearch'];
	} else
		if (isset ($_SESSION['search']))
			unset ($_SESSION['search']);

	//$query .=' GROUP BY o.id, c.id, p.firstname, p.surname, o.status, o.created ORDER BY o.'.$_SESSION['orderOrder'].' '.$_SESSION['orderSort'];
	$query.=' AND status<> '.$db->qstr('deleted').' ORDER BY';
	if($_SESSION['orderOrder']!='items')$query.=' o.'.$_SESSION['orderOrder'];
	else $query.=' '.$_SESSION['orderOrder'];
	$query.=' '.$_SESSION['orderSort'];
	$smarty->assign('viewType', 'order');
	
	$smarty->assign('pageNew', 'action=saveorder');
	/* Set up the pager and send the query */
	
	$egs->page($query, 'order_page', $links);
} else {
	$smarty->assign('errors', array (_('You are trying to access a module to which you do not have access, if you beleive you should please contact your system administrator')));
	$smarty->assign('redirect', true);
	$smarty->assign('redirectAction', '');
}


?>