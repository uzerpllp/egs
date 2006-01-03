<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Save Company Access 1.0          |
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
// |
// | 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA               |
// +----------------------------------------------------------------------+
// | Author: Jake Stride <jake.stride@senokian.com>                       |
// +----------------------------------------------------------------------+
// | Changes:                                                             |
// |                                                                      |
// | 1.0                                                                  |
// | ===                                                                  |
// | Initial Stable Release                                               |
// +----------------------------------------------------------------------+
//
/* Set the id if set */
if (isset ($_GET['id']))
	$id = intval($_GET['id']);
if (isset ($_POST['id']))
	$id = ($_POST['id']);

/* Check that the calendar is enabled, and the correct permissions are valid for the calendar. */
if (in_array('systemadmin', $_SESSION['modules'])) {
	/* Set up the variables for the form */
	$saved = false;
	$select = false;
	if(!isset($id)) $id = null;

	/* Do a save if the form has been posted */
	if (sizeof($_POST) > 0) {
		require_once(EGS_FILE_ROOT.'/src/classes/class.systemadmin.php');

		$systemadmin= new systemadmin();

		/* Check the post array */
		$egs->checkPost();

		/* If set, do the delete */
		if(isset($_POST['delete'])) $saved = $systemadmin->deleteCompany($id);
		else if(!isset($_POST['delete'])) $saved = $systemadmin->saveCompany($_POST, $id);
	}

	/* Redirect to the overview if the form saved successfully */
	if ($saved) {
		$smarty->assign('redirect', true);
		if (isset($_POST['delete'])) $smarty->assign('redirectAction', 'action=overview');
		else $smarty->assign('redirectAction', '');
	} else {
		/* Set up arrays to hold form elements */
		$leftForm = array ();
		$rightForm = array ();
		$bottomForm = array ();

		/* We are editing the calendar so check access and get the data */
		if (isset ($id)) {
			$query = 'SELECT c.name, d.* FROM company c, companydefaults d WHERE d.companyid=c.id AND c.id='.$db->qstr($id);

			$_POST = $db->GetRow($query);

			if(sizeof($_POST) > 0) $select = true;

			/* Incorrect access so notify and redirect to project view */
			if(!$select) {
				$smarty->assign('errors', array (_('You do not have the correct access to edit this company. If you believe you should please contact your system administrator')));
				$smarty->assign('redirect', true);
				$smarty->assign('redirectAction', '');

				return;
			}
		}

		/* Set up the title */
		if (isset ($id))
			$smarty->assign('pageTitle', _('Save Changes to Company Access'));
		else
			$smarty->assign('pageTitle', _('Save New Company Access'));

		/* Show the delete button if editing */
		$smarty->assign('formDelete', true);
		
		/* Add any hidden fields we need */
		$hidden = array ();
		if (isset ($id))
			$hidden['id'] = $id;

		$smarty->assign('hidden', $hidden);

		/* Setup the account it is attached to */
		if (isset ($_POST['id']) || isset($id)) {
			$query = 'SELECT name AS name FROM company WHERE id='.$db->qstr($_POST['companyid']);

			$_POST['companyname'] = $db->GetOne($query);
		}

		if(isset($id)) {
			$item = array ();
			$item['type'] = 'noedit';
			$item['tag'] = _('Company');
			$item['value'] = $_POST['companyname'];
			
			$leftForm[] = $item;
		} else {
			$item = array ();
			$item['type'] = 'company';
			$item['tag'] = _('Company');
			$item['name'] = 'company';
			$item['hide'] = 'person';
			if (isset ($_POST['companyid']))
				$item['value'] = $_POST['companyname'];
			if (isset ($_POST['companyid']))
				$item['actualvalue'] = $_POST['companyid'];
	
			$leftForm[] = $item;
		}

		$item['type'] = 'multiple';
		$item['tag'] = _('Modules');
		$item['name'] = 'modules[]';
		
		$query = 'SELECT id, name FROM module ORDER BY name';
		
		$rs = $db->Execute($query); 

		$item['options'] = array ();

		$modules = array();
		$modules['admin'] = _('Admin');
		$modules['calendar'] = _('Calendar');
		$modules['contacts'] = _('Contacts');
		$modules['crm'] = _('CRM');
		$modules['domain'] = _('Domain');
		$modules['filesharing'] = _('Files');
		$modules['hr'] = _('HR');
		$modules['projects'] = _('Projects');
		$modules['systemadmin'] = _('System Admin');
		$modules['store'] = _('Store');
		$modules['ticketing'] = _('Ticketing');
		$modules['weberp'] = _('webERP');
		$modules['webmail'] = _('Webmail');
		$modules['wiki'] = _('Wiki');
		
		while(!$rs->EOF) {
			if(isset($modules[$rs->fields['name']])) $item['options'][$rs->fields['id']] = $modules[$rs->fields['name']];
			
			$rs->MoveNext();
		}
		
		if(isset($id) && !isset($_POST['modules'])) {
			$item['value'] = array();
			
			$query = 'SELECT moduleid FROM companymoduleaccess WHERE companyid='.$db->qstr($id);
			
			$rs = $db->Execute($query);
			
			while(!$rs->EOF) {
				$item['value'][] = $rs->fields['moduleid'];
				
				$rs->MoveNext();
			}
		} else if(isset($_POST['modules'])) {
			$item['value'] = $_POST['modules'];
		}
			
		$leftForm[] = $item;

		$item['type'] = 'select';
		$item['tag'] = _('Theme');
		$item['name'] = 'theme';
		if(isset($_POST['theme'])) $item['value'] = $_POST['theme'];

		$item['options'] = array ();
		
		$themes = dir(EGS_FILE_ROOT.'/themes/');

		while(false !== ($theme = $themes->read())) {
			if(($theme{0} != '.') && ($theme != 'CVS')) $item['options'][$theme] = $theme;
		}
		
		$rightForm[] = $item;

		$item = array();
        $item['type'] = 'checkbox';
        $item['tag'] = _('Login');
        $item['name'] = 'access';
        if(isset($_POST['access']) && (($_POST['access'] == 'on') || ($_POST['access'] == 't'))) $item['value'] = true;

		$rightForm[] = $item;
		
		$item=array();
		$item['type']='text';
		$item['name']='licensekey';
		$item['tag']=_('Postcode Key');
		if(isset($_POST['licensekey']))
			$item['value']=$_POST['licensekey'];
		$rightForm[]=$item;
		
		$item=array();
		$item['type']='text';
		$item['name']='licensecode';
		$item['tag']=_('Postcode Code');
		if(isset($_POST['licensecode']))
			$item['value']=$_POST['licensecode'];
		$rightForm[]=$item;
		
		
		while(count($leftForm)<count($rightForm)) {
			$item = array();
			$item['type'] = 'space';
		
			$leftForm[] = $item;	
		}
		/* Assign the form variable */
		$smarty->assign('form', true);
		$smarty->assign('leftForm', $leftForm);
		$smarty->assign('rightForm', $rightForm);
		$smarty->assign('formId', 'saveform');
	}
} else {
	print_r($_SESSION['modules']);
	$smarty->assign('redirect', true);
	if(isset($id)) $smarty->assign('redirectAction', '');
	else $smarty->assign('redirectAction', 'action=overview');
	$smarty->assign('errors', array (_('You do not have the correct permissions to update this company. If you beleive you should please contact your system administrator.')));
}
?>
