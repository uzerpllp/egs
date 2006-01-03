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
			$saved = $store->deleteOrder($id);
		else
			$saved = $store->saveOrder($_POST, $id);
	}

	if ($saved) {
		
		$smarty->assign('redirect', true);
		if (isset ($_POST['delete'])) {
			$smarty->assign('messages', array ('Order successfully deleted'));
			$smarty->assign('redirect',true);
			$smarty->assign('redirectAction', 'action=orderoverview');
		}
		else {
			$smarty->assign('messages', array ('Order successfully saved'));
			$smarty->assign('redirect',true);
			$smarty->assign('redirectAction', 'action=orderoverview');
		}
	} else {
		
		/* Set up arrays to hold form elements */
		$leftForm = array ();
		$rightForm = array ();
		$bottomForm = array ();
		
		if (isset ($id)&&!$clicked) {
			$q = 'SELECT * FROM store_order WHERE id='.$db->qstr($id);
			$_POST = $db->GetRow($q);
			
			
		}

		/* Set up the title and delete button */
		if (isset ($id)) {
			$smarty->assign('pageTitle', _('Save Changes to Order'));
			//$smarty->assign('formDelete', true);
		} else
			$smarty->assign('pageTitle', _('Save New Order'));

		/* Build the form */
		$hidden = array ();
		if (isset ($id))
			$hidden['id'] = $id;

		$smarty->assign('hidden', $hidden);
		
		
		
		$item=array();
		$item['name']='status';
		$item['type']='select';
		$item['options']=array('new'=>'new','approved'=>'approved','fraud_pending'=>'fraud_pending','technical_problem'=>'technical_problem','rejected'=>'rejected','completed'=>'completed','deleted'=>'deleted');
		$item['tag']=_('Status');
		$item['value']=trim($_POST['status']);
		
		$leftForm[]=$item;
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