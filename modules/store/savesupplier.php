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
// +-------------------------------------------------------

/*check user has access to the store module*/
if (in_array('store', $_SESSION['modules'])) {

	/* This is set to try if the supplier was saved */
	$saved = false;
	$select = false;
	$id = null;

	/* Set the id if set */
	if (isset ($_GET['id']))
		$id = intval($_GET['id']);
	//if (isset ($_POST['id']))
	//	$id = ($_POST['id']);

	require_once (EGS_FILE_ROOT.'/src/classes/class.store.php');

	$store = new store();

	/* Do a save if the form has been posted */
	if (sizeof($_POST) > 0) {
		/* Check the post array */
		$egs->checkPost();

		if (isset ($_POST['delete']))
			$saved = $store->deleteSupplier($id);
		else
			$saved = $store->saveSupplier($_POST, $id);
	}

	if ($saved) {
		$smarty->assign('redirect', true);
		if (!isset ($_POST['delete']))
			$smarty->assign('redirectAction', 'action=supplieroverview');
	} else {
		/* Set up arrays to hold form elements */
		$leftForm = array ();
		$rightForm = array ();
		$bottomForm = array ();

		if (isset ($id)) {
			/*get the details of the supplier being edited*/
			$q = 'SELECT * FROM store_suppliers WHERE id='.$db->qstr($id).' AND companyid='.$db->qstr(EGS_COMPANY_ID);
			$_POST = $db->GetRow($q);
			if (isset ($_POST['supplierid'])) {
				$q = 'SELECT name FROM company WHERE id='.$db->qstr($_POST['supplierid']);
				$_POST['company'] = $db->GetOne($q);
				$_POST['companyid']=$_POST['supplierid'];
			}
			
		}

		/* Set up the title */
		if (isset ($id))
			$smarty->assign('pageTitle', _('Save Changes to Supplier'));
		else
			$smarty->assign('pageTitle', _('Save New Supplier'));

		$smarty->assign('formDelete', true);

		/* Build the form */

		$hidden = array ();
		if (isset ($id))
			$hidden['id'] = $id;

		$smarty->assign('hidden', $hidden);

		/*add some items*/

		$item = array ();
		/*the company that the supplier is*/
		$item['type'] = 'company';
		$item['tag'] = _('Supplier');
		$item['name'] = 'company';
		$item['compulsory'] = true;
		if (isset ($_POST['company']))
			$item['value'] = $_POST['company'];
		if (isset ($_POST['companyid']))
			$item['actualvalue'] = $_POST['companyid'];
		$leftForm[] = $item;

		/*now an alternative name*/
		$item = array ();
		$item['type'] = 'text';
		$item['tag'] = _('Name');
		$item['name'] = 'name';
		if (isset ($_POST['name']))
			$item['value'] = $_POST['name'];
		//	$leftForm[] = $item;
		$item = array ();
		$item['type'] = 'space';
		$leftForm[] = $item;

		/*now the image upload */
		$item = array ();
		$item['type'] = 'file';
		$item['tag'] = _('Image');
		$item['name'] = 'image';
		if(isset($_POST['image']))
		$item['image']='storeimage';
		if (isset ($_POST['image']))
			$item['value'] = $_POST['image'];

		$rightForm[] = $item;

		/*now the thumbnail upload */
		$item = array ();
		$item['type'] = 'file';
		$item['tag'] = _('Thumbnail');
		$item['name'] = 'thumbnail';
		if(isset($_POST['thumbnail']))
			$item['image']='storeimage';
		if (isset ($_POST['thumbnail']))
			$item['value'] = $_POST['thumbnail'];

		$rightForm[] = $item;
		
		/*and a description*/
		$item = array ();
		$item['type'] = 'area';
		$item['tag'] = _('Description');
		$item['name'] = 'description';
		if (isset ($_POST['description']))
			$item['value'] = $_POST['description'];

		$bottomForm[] = $item;

		/* Assign the form variables */
		
		$smarty->assign('forceSave', true);
		$smarty->assign('form', true);
		$smarty->assign('leftForm', $leftForm);
		$smarty->assign('rightForm', $rightForm);
		$smarty->assign('bottomForm', $bottomForm);
		/*specifies it's a multipart form*/
		$smarty->assign('formFile', true);
		$smarty->assign('formId', 'saveform');

	}
}
?>