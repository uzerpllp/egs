<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Save Section 1.0                 |
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
	
	/* This is set to try if the product was saved */
	$saved = false;
	$select = false;
	$id = null;
	$clicked=false;
	/* Set the id if set */
	if (isset ($_GET['id']))
		$id = intval($_GET['id']);
	if (isset ($_POST['id']))
		$id = ($_POST['id']);

	require_once (EGS_FILE_ROOT.'/src/classes/class.store.php');

	$store = new store();

	/* Do a save/delete if the form has been posted */
	if (sizeof($_POST) > 0) {
		/* Check the post array */
		$egs->checkPost();
		$clicked=true;
		if (isset ($_POST['delete']))
			$saved = $store->deleteProduct($id);
		else
			$saved = $store->saveProduct($_POST, $id);
	}

	if ($saved) {
		
		$smarty->assign('redirect', true);
		if (isset ($_POST['delete'])) {
			$smarty->assign('messages', array ('Product successfully deleted'));
			
			$smarty->assign('redirectAction', '');
		}
		else {
			$smarty->assign('messages', array ('Product successfully saved'));
		
			$smarty->assign('redirectAction', 'action=viewproduct&amp;id='.$_POST['id']);
		}
	} else {
		
		/* Set up arrays to hold form elements */
		$leftForm = array ();
		$rightForm = array ();
		$bottomForm = array ();
		
		if (isset ($id)&&!$clicked) {
			$q = 'SELECT * FROM store_product WHERE id='.$db->qstr($id);
			$_POST = $db->GetRow($q);
			
			
		}

		/* Set up the title and delete button */
		if (isset ($id)) {
			$smarty->assign('pageTitle', _('Save Changes to Product'));
			$smarty->assign('formDelete', true);
		} else
			$smarty->assign('pageTitle', _('Save New Product'));

		/* Build the form */
		$hidden = array ();
		if (isset ($id))
			$hidden['id'] = $id;

		$smarty->assign('hidden', $hidden);
		/*get the associate products*/
		if(isset($id)) {
			$query = 'SELECT a.associateproductid,p.name FROM store_associate_products a, store_product p WHERE a.associateproductid=p.id AND a.productid='.$db->qstr($id);
			$_POST['assocproducts']=array();
			$rs=$db->Execute($query);
			while(!$rs->EOF) {
				$_POST['assocproducts'][$rs->fields['associateproductid']]=$rs->fields['name'];
				$rs->MoveNext();	
			}
		}
		if(isset($_POST['supplierid'])) {
			/*get the supplier and section details*/
			$q = 'SELECT c.name FROM company c, store_suppliers s WHERE c.id=s.supplierid and  s.id='.$db->qstr($_POST['supplierid']);
			$_POST['supplier']=$db->GetOne($q);
		}	
		if(isset($_POST['productsection'])) {
			$q = 'SELECT title FROM store_section WHERE id='.$db->qstr($_POST['productsection']);
			$_POST['section']=$db->GetOne($q);
			$_POST['sectionid']=$_POST['productsection'];
		}
		/*add the fields*/
		/*leftform*/
		$item=array();
		$item['type']='title';
		$item['tag']='General';
		$leftForm[] = $item;
		
		$item=array();
		$item['type']='text';
		$item['name']='name';
		$item['tag']=_('Name');
		$item['compulsory']=true;
		if(isset($_POST['name']))
			$item['value']=$_POST['name'];
		$leftForm[]=$item;
		
		$item=array();
		$item['type']='text';
		$item['name']='productcode';
		$item['tag']=_('Product Code');
		$item['compulsory']=true;
		if(isset($_POST['productcode']))
			$item['value']=$_POST['productcode'];
		$leftForm[]=$item;
		
		$item=array();
		$item['type']='text';
		$item['name']='manufacturercode';
		$item['tag']=_('Manufacturer Code');
		
		if(isset($_POST['manufacturercode']))
			$item['value']=$_POST['manufacturercode'];
		$leftForm[]=$item;
		
		$item=array();
		$item['type']='text';
		$item['name']='shortdescription';
		$item['tag']=_('Short Description');
		$item['compulsory']=true;
		if(isset($_POST['shortdescription']))
			$item['value']=$_POST['shortdescription'];
		$leftForm[]=$item;
		
			
		$item=array();
		$item['type']='title';
		$item['tag']='Pricing';
		$leftForm[] = $item;
		
		$item=array();
		$item['type']='text';
		$item['name']='price';
		$item['compulsory']=true;
		$item['tag']=_('Price');
		if(isset($_POST['price']))
			$item['value']=$_POST['price'];
		$leftForm[]=$item;
		
		$item=array();
		$item['type']='text';
		$item['name']='normalprice';
		$item['tag']=_('Normal Price');
		if(isset($_POST['normalprice']))
			$item['value']=$_POST['normalprice'];
		$leftForm[]=$item;
		
		$item=array();
		$item['type']='text';
		$item['name']='oneoffprice';
		$item['tag']=_('One-Off Price');
		if(isset($_POST['oneoffprice']))
			$item['value']=$_POST['oneoffprice'];
		$leftForm[]=$item;
		
		$item=array();
		$item['type']='text';
		$item['name']='costprice';
		$item['tag']=_('Cost Price');
		if(isset($_POST['costprice']))
			$item['value']=$_POST['costprice'];
		$leftForm[]=$item;
		
		$item=array();
		$item['type']='space';
		$leftForm[]=$item;
		
		$item=array();
		$item['type']='space';
		$leftForm[]=$item;
		
		$item=array();
		$item['type']='title';
		$item['tag']='Ordering';
		$leftForm[] = $item;
		
		$item=array();
		$item['type']='text';
		$item['name']='minquantity';
		$item['tag']=_('Minimum Quantity');
		if(isset($_POST['minquantity']))
			$item['value']=$_POST['minquantity'];
		else
			$item['value']=0;
		$leftForm[]=$item;
		
		$item=array();
		$item['type']='text';
		$item['name']='maxquantity';
		$item['tag']=_('Maximum Quantity');
		if(isset($_POST['maxquantity']))
			$item['value']=$_POST['maxquantity'];
		else
			$item['value']=0;
		$leftForm[]=$item;
		
		$item=array();
		$item['type']='text';
		$item['name']='weight';
		$item['tag']=_('Weight');
		if(isset($_POST['weight']))
			$item['value']=$_POST['weight'];
		else
			$item['value']=0;
		$leftForm[]=$item;
		
		$item=array();
		$item['type']='checkbox';
		$item['name']='freeshipping';
		$item['tag']=_('Free Shipping');
		if(isset($_POST['freeshipping'])&&($_POST['freeshipping']=='t'||$_POST['freeshipping']=='true'))
			$item['value']='checked';
		$leftForm[]=$item;
		
		$item=array();
		$item['type']='supplier';
		$item['name']='supplier';
		$item['tag']=_('Supplier');
		if(isset($_POST['supplier']))
			$item['value']=$_POST['supplier'];
		if(isset($_POST['supplierid']))
			$item['actualvalue']=$_POST['supplierid'];
		$leftForm[]=$item;
		
		
		
		$item=array();
		$item['type']='title';
		$item['tag']='Associated Products';
		$leftForm[] = $item;
		
		$item=array();
		$item['type']='assocproducts';
		$item['name']='assocproducts';
		$item['tag']=_('Associated Products');
		if(isset($_POST['assocproducts']))
			$item['value']=$_POST['assocproducts'];
		$leftForm[]=$item;
		
		$item=array();
		$item['type']='title';
		$item['tag']='Information';
		$leftForm[] = $item;
		
		
		/*rightform*/
		$item=array();
		$item['type']='title';
		$item['tag']='Display';
		$rightForm[] = $item;
		
		

		

		$item = array ();
		$item['type'] = 'file';
		$item['tag'] = _('Thumbnail');
		$item['name'] = 'thumbnail';
		if (isset ($_POST['thumbnail'])) {
			$item['value'] = $_POST['thumbnail'];
			$item['image'] ='storeimage';
		}
		$rightForm[] = $item;
		
		$item = array ();
		$item['type'] = 'file';
		$item['tag'] = _('Image');
		$item['name'] = 'image';
		if (isset ($_POST['image'])) {
			$item['value'] = $_POST['image'];
			$item['image'] ='storeimage';
		}
		$rightForm[] = $item;
		$item = array ();
		$item['type'] = 'select';
		$item['name'] = 'template';
		$item['tag'] = _('Template');
		$item['options'] = array ();
		$item['options']['product.html'] = 'product.html';
		if (isset ($_POST['template']))
			$item['value'] = $_POST['template'];
		$rightForm[] = $item;
		
		$item=array();
		$item['type']='space';
		$rightForm[]=$item;
		
		$item=array();
		$item['type']='title';
		$item['tag']='Options';
		$rightForm[] = $item;
		
		$item=array();
		$item['type']='section';
		$item['name']='section';
		$item['tag']=_('Section');
		if(isset($_POST['section']))
			$item['value']=$_POST['section'];
		if(isset($_POST['sectionid']))
			$item['actualvalue']=$_POST['sectionid'];
		$rightForm[]=$item;
		
		$item=array();
		$item['type']='checkbox';
		$item['name']='newproduct';
		$item['tag']=_('New Product');
		if(isset($_POST['newproduct'])&&($_POST['newproduct']=='t'||$_POST['newproduct']=='true'))
			$item['value']='checked';
		$rightForm[]=$item;
		
		$item=array();
		$item['type']='checkbox';
		$item['name']='topproduct';
		$item['tag']=_('Top Product');
		if(isset($_POST['topproduct'])&&($_POST['topproduct']=='t'||$_POST['topproduct']=='true'))
			$item['value']='checked';
		$rightForm[]=$item;
		
		$item=array();
		$item['type']='checkbox';
		$item['name']='specialoffer';
		$item['tag']=_('Special Product');
		if(isset($_POST['specialoffer'])&&($_POST['specialoffer']=='t'||$_POST['specialoffer']=='true'))
			$item['value']='checked';
		$rightForm[]=$item;
		
		$item=array();
		$item['type']='checkbox';
		$item['name']='visible';
		$item['tag']=_('Visible');
		
		if(isset($_POST['visible'])&&($_POST['visible']=='t'||$_POST['visible']=='true')) {
			
			$item['value']='checked';
		}
		$rightForm[]=$item;
		
		$item=array();
		$item['type']='checkbox';
		$item['name']='forcehide';
		$item['tag']=_('Allow Direct Link');
		if(isset($_POST['forcehide'])&&($_POST['forcehide']=='t'||$_POST['forcehide']=='true'))
			$item['value']='checked';
		$rightForm[]=$item;
		
		$item=array();
		$item['type']='title';
		$item['tag']='Stock Control';
		$rightForm[] = $item;
		
		$item=array();
		$item['type']='checkbox';
		$item['name']='stockcontrolenable';
		$item['tag']=_('Stock Control Enabled');
		if(isset($_POST['stockcontrolenable'])&&($_POST['stockcontrolenable']=='t'||$_POST['stockcontrolenable']=='true'))
			$item['value']='checked';
		$rightForm[]=$item;
		
		$item=array();
		$item['type']='text';
		$item['name']='stocklevel';
		$item['tag']=_('Stock Level');
		if(isset($_POST['stocklevel']))
			$item['value']=$_POST['stocklevel'];
		else
			$item['value']=0;
		$rightForm[]=$item;
			
		$item=array();
		$item['type']='text';
		$item['name']='warninglevel';
		$item['tag']=_('Warning Level');
		if(isset($_POST['warninglevel']))
			$item['value']=$_POST['warninglevel'];
		else
			$item['value']=0;
		$rightForm[]=$item;
					
		//options array comes from the store class
		$item=array();
		$item['type']='select';
		$item['name']='actiononzero';
		$item['tag']=_('Action on Zero');
		$item['options']=$store->getActionOnZeroOptionsArray();
		
		if(isset($_POST['actiononzero']))
			$item['value']=$_POST['actiononzero'];
		$rightForm[]=$item;
		/*bottomform*/
		
		
		
		$item=array();
		$item['type']='mediumarea';
		$item['name']='searchkeywords';
		$item['tag']=_('Search Keywords');
		if(isset($_POST['searchkeywords']))
			$item['value']=$_POST['searchkeywords'];
		$bottomForm[]=$item;
		
		$item=array();
		$item['type']='mediumarea';
		$item['name']='metadescription';
		$item['tag']=_('Meta-Description');
		if(isset($_POST['metadescription']))
			$item['value']=$_POST['metadescription'];
		$bottomForm[]=$item;
		
		$item=array();
		$item['type']='mediumarea';
		$item['name']='metakeywords';
		$item['tag']=_('Meta-Keywords');
		if(isset($_POST['metakeywords']))
			$item['value']=$_POST['metakeywords'];
		$bottomForm[]=$item;
		
		$item = array();
		$item['type']='area';
		$item['name']='description';
		$item['tag']=_('Description');
		$item['compulsory']=true;
		if(isset($_POST['description']))
			$item['value']=$_POST['description'];
		$bottomForm[] = $item;
		/* Assign the form variable */
		$smarty->assign('forceSave', true);
		$smarty->assign('form', true);
		$smarty->assign('leftForm', $leftForm);
		$smarty->assign('rightForm', $rightForm);
		$smarty->assign('bottomForm', $bottomForm);
		$smarty->assign('formFile', true);
		$smarty->assign('formId', 'saveform');

	}
}
?>