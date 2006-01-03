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
		$_SESSION['product_page'] = max(1, intval($_GET['page']));
	if (!isset ($_SESSION['product_page']))
		$_SESSION['product_page'] = 1;

	/* Set the page title */
	$smarty->assign('pageTitle', _('Store: Products'));

	/* Setup the search box */
	$smarty->assign('searchTitle', _('Search Products'));

	/* Set the search type */
	
	/* Set the search type */
	if(isset($_GET['search']) && ($_GET['search'] == 'adv')) $_SESSION['productSearchType'] = 'adv';
	else if(isset($_GET['search']) && ($_GET['search'] == 'norm')) $_SESSION['productSearchType'] = 'norm';
	else if(!isset($_SESSION['productSearchType'])) $_SESSION['productSearchType'] = 'norm';
	
	
	$smarty->assign('searchForm', $_SESSION['productSearchType']);
	
	
	
	$search = array ();

/*basic search*/
	$search['p.name'] = array ('name' => _('Name'), 'type' => 'text');
/*sections*/
	$q = 'SELECT id, title FROM store_section WHERE companyid='.$db->qstr(EGS_COMPANY_ID);
	$rs = $db->execute($q);
	$sections = array();
	$store->nestSections($sections);
	$sections=array_flip($sections);
	$sections=array(_('All')=>'')+$sections;

	$search['section'] = array('name'=>_('Section'),'type'=>'select','values'=>$sections);

/*suppliers*/
	$q = 'SELECT c.name, s.id FROM store_suppliers s, company c WHERE c.id=s.supplierid AND s.companyid='.$db->qstr(EGS_COMPANY_ID);
	$rs = $db->execute($q);
	$suppliers = array(_('All') => '');
	while(!$rs->EOF) {
		$suppliers[$rs->fields['name']] = $rs->fields['id'];
		$rs->MoveNext();
	}
	$search['supplier'] = array('name'=>_('Supplier'),'type'=>'select','values'=>$suppliers);
	
	if($_SESSION['productSearchType'] == 'adv') {
		$search['visible']=array('name'=>_('Show Visible'),'type'=>'checkbox','values'=>'checked');
		$stockvalues=array(_('All')=>'',_('In Stock')=>'in',_('Low Stock')=>'low',_('Out of Stock')=>'out');
		$search['stock']=array('name'=>_('Show Stock'),'type'=>'select','values'=>$stockvalues);
		$search['p.productcode']=array('name'=>_('Product Code'),'type'=>'text');
	}


	$smarty->assign('search', $search);

	$smarty->assign('hideSaveSearch',true);

//GREGTASK: will want choice
	/*no choice in ordering for products*/

	$_SESSION['preferences']['productColumns'] = array ();
	$_SESSION['preferences']['productColumns'][] = 'name';
	$_SESSION['preferences']['productColumns'][] = 'productcode';
	$_SESSION['preferences']['productColumns'][] = 'price';
	$_SESSION['preferences']['productColumns'][] = 'stocklevel';
	$_SESSION['preferences']['productColumns'][] = 'visible';
	$_SESSION['preferences']['productColumns'][] = 'lastupdate';
	$_SESSION['preferences']['productColumns'][] = 'hasimage';

	/* Array to hold the columns */
	$headings = array ();

	/* Iterate over the columns and translate */
	for ($i = 0; $i < sizeof($_SESSION['preferences']['productColumns']); $i ++) {
		switch ($_SESSION['preferences']['productColumns'][$i]) {
			case 'name' :
				$headings[$_SESSION['preferences']['productColumns'][$i]] = _('Product');
				break;
			case 'productcode' :
				$headings[$_SESSION['preferences']['productColumns'][$i]] = _('Product Code');
				break;
			case 'price' :
				$headings[$_SESSION['preferences']['productColumns'][$i]] = _('Price');
				break;
			case 'stocklevel' :
				$headings[$_SESSION['preferences']['productColumns'][$i]] = _('Stock Level');
				break;
			case 'lastupdate' :
				$headings[$_SESSION['preferences']['productColumns'][$i]] = _('Last Updated');
				break;
			case 'visible' :
				$headings[$_SESSION['preferences']['productColumns'][$i]] = _('Visible');
				break;
			case 'hasimage' :
				$headings[$_SESSION['preferences']['productColumns'][$i]] = _('Has Image');
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

				$store->deleteProduct(intval($val));
			}

			$smarty->assign('messages', array (_('Products deleted')));
		}

		$save = false;

		if (!isset ($_SESSION['productSearch']) || ($_SESSION['productSearch'] == '') || isset ($_POST['clearsearch'])) {
			if (isset ($_SESSION['preferences']['productSearch']))
				$_SESSION['productSearch'] = $_SESSION['preferences']['productSearch'];
			else
				unset ($_SESSION['productSearch']);
		}

		/* If Saving, set to search then save */
		if (isset ($_POST['savesearch'])) {
			unset ($_POST['savesearch']);
			$_SESSION['preferences']['productSearch'] = $_POST;
			$_SESSION['productSearch'] = $_POST;
			$egs->syncPreferences();
		}

		/* We are searching */
		if (isset ($_POST['search'])) {
			unset ($_POST['search']);
			$_SESSION['productSearch'] = $_POST;
			$_SESSION['product_page'] = 1;
		}
	} else
		if (!isset ($_SESSION['productSearch']) && isset ($_SESSION['preferences']['productSearch']))
			$_SESSION['productSearch'] = $_SESSION['preferences']['productSearch'];

	/* Set the search order */
	if (isset ($_GET['order']) && ($_GET['order'] == $_SESSION['productOrder']) && in_array($_GET['order'], $_SESSION['preferences']['productColumns'])) {
		if (isset ($_SESSION['productSort']) && ($_SESSION['productSort'] == 'ASC'))
			$_SESSION['productSort'] = 'DESC';
		else
			if (isset ($_SESSION['productSort']) && ($_SESSION['productSort'] == 'DESC'))
				$_SESSION['productSort'] = 'ASC';
		$_SESSION['product_page'] = 1;
	} else
		if (isset ($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['productColumns'])) {
			$_SESSION['productSort'] = 'DESC';
			$_SESSION['productOrder'] = $_GET['order'];
			$_SESSION['product_page'] = 1;
		}

	if (!isset ($_SESSION['productOrder']))
		$_SESSION['productOrder'] = $_SESSION['preferences']['productColumns'][0];
	if (!isset ($_SESSION['productSort']))
		$_SESSION['productSort'] = 'ASC';

	$_SESSION['order'] = $_SESSION['productOrder'];

	/* Build the query to get the relevant columns */
	$query = 'SELECT p.id, ';

	$links = array ();

	for ($i = 0; $i < sizeof($_SESSION['preferences']['productColumns']); $i ++) {
		if ($_SESSION['preferences']['productColumns'][$i] == 'company')
			$links[$i +1] = '&amp;module=contacts&amp;action=view&amp;id=';
		if ($_SESSION['preferences']['productColumns'][$i] == 'hasimage')
		if ($_SESSION['preferences']['productColumns'][$i] == 'person')
			$links[$i +1] = '&amp;module=contacts&amp;action=viewperson&amp;id=';
	
		if ($_SESSION['preferences']['productColumns'][$i] == 'created' || $_SESSION['preferences']['productColumns'][$i] == 'lastupdate')
			$query .= $db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), $_SESSION['preferences']['productColumns'][$i]).' AS '.$_SESSION['preferences']['productColumns'][$i];
		else if($_SESSION['preferences']['productColumns'][$i] == 'price')
			$query .= $db->qstr('&pound;').'||'.$_SESSION['preferences']['productColumns'][$i].' AS '.$_SESSION['preferences']['productColumns'][$i];
		else if($_SESSION['preferences']['productColumns'][$i] == 'visible')
			$query.='CASE WHEN p.visible='.$db->qstr('t').' THEN '.$db->qstr('Yes').' ELSE '.$db->qstr('No').' END AS visible';
		else if ($_SESSION['preferences']['productColumns'][$i] == 'hasimage')
			$query.='CASE WHEN p.image IS NULL THEN \'No\' ELSE \'Yes\' END AS hasimage ';
		else
			$query .= "p.".$_SESSION['preferences']['productColumns'][$i];
		if (($i +1) != sizeof($_SESSION['preferences']['productColumns']))
			$query .= ', ';
	}

	$query .= ' FROM store_product p';
	if(isset($_SESSION['productSearch']['section']))
		$query.=', store_section sec';
	if(isset($_SESSION['productSearch']['supplier']))
		$query.=', store_suppliers sup';
		
	$query.=' WHERE p.companyid='.$db->qstr(EGS_COMPANY_ID);
	
	if(isset($_SESSION['productSearch']['section']))
		$query.=' AND p.productsection=sec.id AND sec.id='.$db->qstr($_SESSION['productSearch']['section']);
	if(isset($_SESSION['productSearch']['supplier']))
		$query.=' AND p.supplierid=sup.id AND sup.id='.$db->qstr($_SESSION['productSearch']['supplier']);
	if(isset($_SESSION['productSearch']['stock'])) {
		if($_SESSION['productSearch']['stock']=='in')
			$query.=' AND p.stocklevel>0';
		if($_SESSION['productSearch']['stock']=='low')
			$query.=' AND p.stocklevel<=p.warninglevel';
		if($_SESSION['productSearch']['stock']=='out')
			$query.=' AND p.stocklevel=0';	
	}
	
	if (isset ($_SESSION['productSearch']) && (sizeof($_SESSION['productSearch']) > 0)) {
		/*take some things out of the search*/
		$remove=array('section','supplier','stock');
		foreach($remove as $searchterm) {
			if(isset($_SESSION['productSearch'][$searchterm])) {
				$temp[$searchterm]=$_SESSION['productSearch'][$searchterm];
				unset($_SESSION['productSearch'][$searchterm]);
			}
		}
				
		
		$searchString = $egs->searchString($_SESSION['productSearch']);

		/*then put them back in*/
		if(isset($temp)&&count($temp)>0) {
			foreach($temp as $searchterm=>$value) {
				$_SESSION['productSearch'][$searchterm]=$value;
			}
		}
		if ($searchString != '' && $searchString != ')')
			$query .= ' AND '.$searchString;

		$_SESSION['search'] = $_SESSION['productSearch'];
	} else
		if (isset ($_SESSION['search']))
			unset ($_SESSION['search']);

	$query .= ' ORDER BY '.$_SESSION['productOrder'].' '.$_SESSION['productSort'];

	$smarty->assign('viewType', 'product');
	
	$smarty->assign('pageNew', 'action=saveproduct');
	/* Set up the pager and send the query */
	
	$egs->page($query, 'product_page', $links);
} else {
	$smarty->assign('errors', array (_('You are trying to access a module to which you do not have access, if you beleive you should please contact your system administrator')));
	$smarty->assign('redirect', true);
	$smarty->assign('redirectAction', '');
}


?>