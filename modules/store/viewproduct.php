<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - View Activity 1.0                |
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

/* Check user has access to this module */
if (isset($_GET['id'])&&isset ($_SESSION['modules']) && (in_array('store', $_SESSION['modules']))) {
	/* Include the crm/compnay/person class, and initialise */
	require_once (EGS_FILE_ROOT.'/src/classes/class.store.php');
	$store = new store();

	/* Get the activity details from the database */
	$query = 'SELECT p.*, c.name as supplier, c.id as supplierid, sec.title as productsectiontitle, '
	.' CASE WHEN freeshipping THEN \'Yes\' ELSE \'No\' END AS freeshipping,'
	.' CASE WHEN newproduct THEN \'Yes\' ELSE \'No\' END AS newproduct,'
	.' CASE WHEN topproduct THEN \'Yes\' ELSE \'No\' END AS topproduct,'
	.' CASE WHEN specialoffer THEN \'Yes\' ELSE \'No\' END AS specialoffer,'
	.' CASE WHEN p.visible THEN \'Yes\' ELSE \'No\' END AS visible,'
	.' CASE WHEN forcehide THEN \'Yes\' ELSE \'No\' END AS forcehide,'
	.' CASE WHEN stockcontrolenable THEN \'Yes\' ELSE \'No\' END AS stockcontrolenable,'
	.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'p.created').' AS created, '
	.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'p.lastupdate').' AS lastupdate'
	.' FROM store_product p LEFT OUTER JOIN store_section sec ON (p.productsection=sec.id) LEFT OUTER JOIN store_suppliers s ON (p.supplierid=s.id) LEFT OUTER JOIN company c ON (s.supplierid=c.id) WHERE p.id='.$db->qstr(intval($_GET['id']))
	.' AND p.companyid='.$db->qstr(EGS_COMPANY_ID);
	$productDetails = $db->GetRow($query);

	
	if(isset($productDetails)&&count($productDetails)>0) {

	/* This is set to false if something is successfully saved */
	$saved = false;

	/* If the access level is valid to view the company then we can display it */
	
		/* Update the activity if correct access */
		if ((sizeof($_POST) > 0) ) {
			if(isset($_POST['savealbum'])) {
				$store->updateAlbum($_POST,$_GET['id']);	
			}
			if(isset($_GET['editdone'])&&$_GET['editdone']=='attributes') {
				$store->updateAttributes($_POST,$_GET['id']);	
				
			}
			if(isset($_GET['editdone'])&&$_GET['editdone']=='sections') {
				$store->updateSections($_POST,$_GET['id']);	
				
			}
			
		}

		/* Add to last viewed and sync the preferences */
		$_SESSION['preferences']['lastViewed'] = array_slice(array_merge(array ('module=store&amp;action=viewproduct&amp;id='.intval($_GET['id']) => array ('product', $productDetails['name'])), $_SESSION['preferences']['lastViewed']), 0, EGS_RECENTLY_VIEWED);
		$egs->syncPreferences();

		/* Set the title to the product name */
		$smarty->assign('pageTitle', _('Product: ').$productDetails['name']);

		/*assign the edit button*/
		$smarty->assign('pageEdit', 'action=saveproduct&amp;id='.intval($_GET['id']));

		/* Output the activity details */
		$leftData = array ();
		$leftData[] = array ('tag' => _('Name'), 'data' => $productDetails['name']);
		$leftData[] = array ('tag' => _('Short Description'), 'data' => $productDetails['shortdescription']);
		$leftData[] = array ('tag' => _('Product Code'), 'data' => $productDetails['productcode']);
		$leftData[] = array ('tag' => _('Manufacturer Code'), 'data' => $productDetails['manufacturercode']);
		$leftData[] = array ('span' => true);

		$leftData[] = array ('tag' => _('Price'), 'data' => '&pound;'.number_format($productDetails['price'],2,'.',','));
		$leftData[] = array ('tag' => _('Normal Price'), 'data' => '&pound;'.number_format($productDetails['normalprice'],2,'.',','));
		$leftData[] = array ('tag' => _('One-Off Price'), 'data' => '&pound;'.number_format($productDetails['oneoffprice'],2,'.',','));
		$leftData[] = array ('tag' => _('Cost Price'), 'data' => '&pound;'.number_format($productDetails['costprice'],2,'.',','));
		
		$leftData[] = array ('span' => true);
		$leftData[] = array ('tag' => _('Minimum Quantity'), 'data' => $productDetails['minquantity']);
		$leftData[] = array ('tag' => _('Maximum Quantity'), 'data' => $productDetails['maxquantity']);
		$leftData[] = array ('tag' => _('Weight'), 'data' => $productDetails['weight']);
		$leftData[] = array ('tag' => _('Free Shipping'), 'data' => $productDetails['freeshipping']);
		$leftData[] = array ('tag' => _('Supplier'), 'data' => $productDetails['supplier'],'link' => EGS_SERVER.'/?'.session_name().'='.strip_tags(session_id()).'&amp;module=contacts&amp;action=view&amp;id='.$productDetails['supplierid']);
		
		$leftData[] = array ('span' => true);
		/* Do the activity owner/assigned details */
		$leftData[] = array ('tag' => _('Owner'), 'data' => $productDetails['owner']);
		
		$leftData[] = array ('tag' => _('Created'), 'data' => $productDetails['created'].' '._('by').' '.$productDetails['owner']);
		$leftData[] = array ('tag' => _('Last Updated'), 'data' => $productDetails['lastupdate'].' '._('by').' '.$productDetails['alteredby']);

		$rightData = array ();
		$rightData[] = array ('tag' => _('Stock Control Enabled'), 'data' => $productDetails['stockcontrolenable']);
		if($productDetails['stockcontrolenable']=='Yes' &&$productDetails['stocklevel']<=$productDetails['warninglevel']) {$flag="true";}
		else $flag="false";
		$rightData[] = array ('tag' => _('Stock Level'), 'data' => $productDetails['stocklevel'],'overdue'=>$flag);
		$rightData[] = array ('tag' => _('Warning Level'), 'data' => $productDetails['warninglevel']);
		
		
		$array=$store->getActionOnZeroOptionsArray();
		$data=$array[$productDetails['actiononzero']];
		$rightData[] = array ('tag' => _('Action on Zero'), 'data' => $data);
		
		$rightData[] = array ('span' => true);
		
		$rightData[] = array ('tag' => _('Section'), 'data' => $productDetails['productsectiontitle']);
		$rightData[] = array ('tag' => _('Visible'), 'data' => $productDetails['visible']);
		$rightData[] = array ('tag' => _('Allow Direct Link'), 'data' => $productDetails['forcehide']);
		$rightData[] = array ('tag' => _('New Product'), 'data' => $productDetails['newproduct']);
		$rightData[] = array ('tag' => _('Top Product'), 'data' => $productDetails['topproduct']);
		$rightData[] = array ('tag' => _('Special Offer'), 'data' => $productDetails['specialoffer']);

		$rightData[] = array ('span' => true);

		$rightData[] = array ('tag' => _('Template'), 'data' => $productDetails['template']);
		
	/*show the product image*/
		$rightSpan = array();
		$rightSpan[] = array ('type' => 'image', 'id' => $productDetails['image'], 'show' => 'storeimage');
		$rightSpan[] = array('type' => 'text', 'text' => nl2br($productDetails['description']), 'title' => _('Description'));
	/*show the associated products*/
	
		$assoc = array('type' => 'data', 'title' => _('Associated Products'));
		$q = 'SELECT p.id, p.name FROM store_product p, store_associate_products sa WHERE sa.productid='.intval($_GET['id']).' AND sa.associateproductid=p.id';
		$rs=$db->Execute($q);
		
		while (!$rs->EOF) {
			$assoc['data'][$rs->fields['id']] = $rs->fields['name'];
			$assoc['link'][$rs->fields['id']] = 'module=store&amp;action=viewproduct&amp;id='.$rs->fields['id'];
			$assoc['selected'][] = $rs->fields['id'];
			$rs->MoveNext();
		}
		
		$rightSpan[]=$assoc;
	/*show the attributes*/
		/* Get the attributes the product is associated with */
		$attributes=array();
			
			$query = 'SELECT a.id, a.name FROM store_product_attribute a, store_product_attributes ap WHERE a.id=ap.attributeid AND ap.productid='.intval($_GET['id']);
			$rs = $db->Execute($query);
			
		/* Show the save link if we are editing  */
			if (isset ($_GET['edit']) && ($_GET['edit'] == 'attributes'))
				$attributes = array ('type' => 'data', 'title' => _('Attributes'), 'save' => 'action=viewproduct&amp;id='.intval($_GET['id']));
			else
				$attributes = array ('type' => 'data', 'title' => _('Attributes'), 'edit' => 'action=viewproduct&amp;edit=attributes&amp;id='.intval($_GET['id']));
		/* Iterate over the attributes and output them */
			while (!$rs->EOF) {
				$attributes['data'][$rs->fields['id']] = $rs->fields['name'];
				$attributes['selected'][] = $rs->fields['id'];

				$rs->MoveNext();
			}

		/* If we are editing with the correct access then grab the existing attributes so we can select them */
			if (isset ($_GET['edit']) && ($_GET['edit'] == 'attributes')) {
				
				$query = 'SELECT id, name FROM store_product_attribute WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY name';
				$rs = $db->Execute($query);

				while (!$rs->EOF) {
					$attributes['values'][$rs->fields['id']] = $rs->fields['name'];
					$rs->MoveNext();
				}
			}

			$attributes['icon'] = 'attributes';
			$rightSpan[] = $attributes;
			
		/*end attributes*/
	/*show the additional sections*/
		/* Get the sections the product is associated with */
		$sections=array();
			
			$query = 'SELECT ss.id, ss.title FROM store_section ss, store_product_sections sps WHERE ss.id=sps.sectionid AND sps.productid='.intval($_GET['id']);
			$rs = $db->Execute($query);
			
		/* Show the save link if we are editing  */
			if (isset ($_GET['edit']) && ($_GET['edit'] == 'sections'))
				$sections = array ('type' => 'data', 'title' => _('Additional Sections'), 'save' => 'action=viewproduct&amp;id='.intval($_GET['id']));
			else
				$sections = array ('type' => 'data', 'title' => _('Additional Sections'), 'edit' => 'action=viewproduct&amp;edit=sections&amp;id='.intval($_GET['id']));
		/* Iterate over the sections and output them */
			while (!$rs->EOF) {
				$sections['data'][$rs->fields['id']] = $rs->fields['title'];
				$sections['selected'][] = $rs->fields['id'];
				$rs->MoveNext();
			}

		/* If we are editing with the correct access then grab the existing sections so we can select them */
			if (isset ($_GET['edit']) && ($_GET['edit'] == 'sections')) {
				$query = 'SELECT id, name FROM store_product_attribute WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY name';
				$query = 'SELECT id, title from store_section WHERE';
				if(isset($productDetails['productsection'])&&is_numeric($productDetails['productsection']))
					$query.= ' id<>'.intval($productDetails['productsection']).' AND';
				$query.= ' companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY title';
				$rs = $db->Execute($query);

				while (!$rs->EOF) {
					$sections['values'][$rs->fields['id']] = $rs->fields['title'];
					$rs->MoveNext();
				}
			}

			$sections['icon'] = 'sections';
			$rightSpan[] = $sections;
			
		/*end sections*/
	
	
	/*show the images*/
		$album = array('type' => 'album', 'title' => _('Image Album'));
		$q = 'SELECT f.name, p.fileid, p.displayorder FROM store_product_image_album p, file f WHERE f.id=p.fileid AND productid='.intval($_GET['id']).' ORDER BY displayorder';
		$rs=$db->Execute($q);
		$i=0;
		
		while(!$rs->EOF) {
			$album['data'][$i]['text']=$rs->fields['name'];
			$album['data'][$i]['id']=$rs->fields['fileid'];
			$album['data'][$i]['order']=$rs->fields['displayorder'];
			$album['data'][$i]['show']='storeimage';
			$rs->MoveNext();
			$i++;
		}
		$album['neworder']=($i>0)?$album['data'][$i-1]['order']+1:1;
		$rightSpan[]=$album;
		/* Assign the data to the template */
		$smarty->assign('view', true);
		$smarty->assign('leftData', $leftData);
		$smarty->assign('rightData', $rightData);
		$smarty->assign('rightSpan', $rightSpan);
	
	}
	else {
		$smarty->assign('errors', array (_('The product you requested does not exist')));
		$smarty->assign('redirect',true);
		$smarty->assign('redirectaction','');
	}
} else {
	$smarty->assign('errors', array (_('You do not have the correct permissions to access this module. If you believe you should please contact your system administrator')));
	$smarty->assign('redirect',true);
	$smarty->assign('redirectaction','');
}
?>
