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

	/* This is set to try if the section was saved */
	$saved = false;
	$select = false;
	$id = null;

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

		if (isset ($_POST['delete']))
			$saved = $store->deleteSection($id);
		else
			$saved = $store->saveSection($_POST, $id);
	}

	if ($saved) {
		$smarty->assign('redirect', true);
		$smarty->assign('redirectAction', 'action=sectionoverview');

		if (isset ($_POST['delete']))
			$smarty->assign('messages', array ('Section successfully deleted'));
		else
			$smarty->assign('messages', array ('Section successfully saved'));
	} else {
		/* Set up arrays to hold form elements */
		$leftForm = array ();
		$rightForm = array ();
		$bottomForm = array ();

		if (isset ($id)) {
			$q = 'SELECT * FROM store_section WHERE id='.$db->qstr($id);
			$_POST = $db->GetRow($q);
		}

		/* Set up the title and delete button */
		if (isset ($id)) {
			$smarty->assign('pageTitle', _('Save Changes to Section'));
			$smarty->assign('formDelete', true);
		} else
			$smarty->assign('pageTitle', _('Save New Section'));

		/* Build the form */
		$hidden = array ();
		if (isset ($id))
			$hidden['id'] = $id;

		$smarty->assign('hidden', $hidden);

		/*add some items*/
		$item = array ();
		$item['type'] = 'text';
		$item['name'] = 'title';
		$item['tag'] = _('Title');
		if (isset ($_POST['title']))
			$item['value'] = $_POST['title'];
		$leftForm[] = $item;

		$item = array ();
		$item['type'] = 'text';
		$item['name'] = 'shortdescription';
		$item['tag'] = _('Short Description');
		if (isset ($_POST['shortdescription']))
			$item['value'] = $_POST['shortdescription'];
		$leftForm[] = $item;

		$item = array ();
		$item['type'] = 'select';
		$item['tag'] = _('Parent Section');
		$item['name'] = 'parentsectionid';
		$item['options'] = array ();
		$item['options'][] = _('None');
		$sections=array();
		$store->nestSections($sections);
		$item['options']+=$sections;
//						$query = 'SELECT id, title FROM store_section WHERE';
//				
//						if (isset ($id))
//							$query .= ' id<>'.$db->qstr($id).' AND';
//				
//						$query .= ' companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY title';
//				
//						$rs = $db->Execute($query);
//						while (!$rs->EOF) {
//							$item['options'][$rs->fields['id']] = $rs->fields['title'];
//							$rs->MoveNext();
//						}
		if (isset ($_POST['parentsectionid']))
			$item['value'] = $_POST['parentsectionid'];
		$leftForm[] = $item;

		$item = array ();
		$item['type'] = 'select';
		$item['name'] = 'template';
		$item['tag'] = _('Template');
		$item['options'] = array ();
		$item['options']['section.html'] = 'section.html';
		if (isset ($_POST['template']))
			$item['value'] = $_POST['template'];
		$leftForm[] = $item;

		/*now the image upload */
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
		$item['type'] = 'file';
		$item['tag'] = _('Thumbnail');
		$item['name'] = 'thumbnail';
		if (isset ($_POST['thumbnail'])) {
			$item['value'] = $_POST['thumbnail'];
			$item['image'] ='storeimage';
		}
		$rightForm[] = $item;

		$item = array ();
		$item['type'] = 'checkbox';
		$item['name'] = 'visible';
		$item['tag'] = _('Visible');
		if ((isset ($_POST['visible']) && $_POST['visible'] == 't') || (!isset ($id)))
			$item['value'] = true;
		$rightForm[] = $item;

		$item = array ();

		$item['options'][] = _('All');
		if ($db->GetOne('SELECT tablename FROM pg_tables WHERE schemaname=\'company'.EGS_COMPANY_ID.'\' AND tablename LIKE \'erp%\''))
			$query = 'SELECT typeabbrev AS id, sales_type AS name FROM company'.EGS_COMPANY_ID.'.salestypes ORDER BY sales_type';
		else
			$query = 'SELECT id, name FROM store_customer_type WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY name';

		$rs = $db->Execute($query);
		while (!$rs->EOF) {
			$item['options'][$rs->fields['id']] = $rs->fields['name'];
			$rs->MoveNext();
		}

		$item['type'] = 'select';
		$item['tag'] = _('Customer Types');
		$item['name'] = 'customertypes';
		if (isset ($_POST['customertypes']))
			$item['value'] = $_POST['customertypes'];

		$rightForm[] = $item;

		/*and the bottom bits*/
		$item = array ();
		$item['type'] = 'mediumarea';
		$item['tag'] = _('Meta-Description');
		$item['name'] = 'metadescription';
		if (isset ($_POST['metadescription']))
			$item['value'] = $_POST['metadescription'];

		$bottomForm[] = $item;
		$item = array ();
		$item['type'] = 'mediumarea';
		$item['tag'] = _('Meta-Keywords');
		$item['name'] = 'metakeywords';
		if (isset ($_POST['metakeywords']))
			$item['value'] = $_POST['metakeywords'];

		$bottomForm[] = $item;

		$item = array ();
		$item['type'] = 'area';
		$item['tag'] = _('Description');
		$item['name'] = 'description';
		if (isset ($_POST['description']))
			$item['value'] = $_POST['description'];

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