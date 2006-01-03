<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Save User Access 1.0             |
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
	$id = $_GET['id'];
if (isset ($_POST['id']))
	$id = $_POST['id'];

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

		$saved = $systemadmin->saveUser($_POST, $id);
	}

	/* Redirect to the calendar view if the form saved successfully */
	if ($saved) {
		$smarty->assign('redirect', true);
		$smarty->assign('redirectAction', 'action=users');
	} else {
		/* Set up arrays to hold form elements */
		$leftForm = array ();
		$rightForm = array ();
		$bottomForm = array ();

		/* We are editing the user so check access and get the data */
		if (isset ($id)) {
			$query = 'SELECT DISTINCT domainuser FROM useraccess WHERE username='.$db->qstr($id);

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
		$smarty->assign('pageTitle', _('Save Changes to User'));
		
		/* Add any hidden fields we need */
		$hidden = array ();
		if (isset ($id))
			$hidden['id'] = $id;

		$smarty->assign('hidden', $hidden);

		$item['type'] = 'multiple';
		$item['tag'] = _('Companies');
		$item['name'] = 'companies[]';
		
		$query = 'SELECT c.id, c.name FROM company c, companydefaults d WHERE c.id=d.companyid ORDER BY c.name';
		
		$rs = $db->Execute($query); 

		$item['options'] = array ();

		while(!$rs->EOF) {
			$item['options'][$rs->fields['id']] = $rs->fields['name'];
			
			$rs->MoveNext();
		}
		
		if(isset($id) && !isset($_POST['companies'])) {
			$item['value'] = array();
			
			$query = 'SELECT companyid FROM useraccess WHERE username='.$db->qstr($id);
			
			$rs = $db->Execute($query);
			
			while(!$rs->EOF) {
				$item['value'][] = $rs->fields['companyid'];
				
				$rs->MoveNext();
			}
		} else if(isset($_POST['companies'])) {
			$item['value'] = $_POST['companies'];
		}
			
		$leftForm[] = $item;

		$item = array();
        $item['type'] = 'checkbox';
        $item['tag'] = _('Domain Admin');
        $item['name'] = 'domainuser';
        if(isset($_POST['domainuser']) && (($_POST['domainuser'] == 'on') || ($_POST['domainuser'] == 't'))) $item['value'] = true;

		$rightForm[] = $item;
		

		/* Assign the form variable */
		$smarty->assign('form', true);
		$smarty->assign('leftForm', $leftForm);
		$smarty->assign('rightForm', $rightForm);
		$smarty->assign('formId', 'saveform');
	}
} else {
	$smarty->assign('redirect', true);
	if(isset($id)) $smarty->assign('redirectAction', '');
	else $smarty->assign('redirectAction', 'action=overview');
	$smarty->assign('errors', array (_('You do not have the correct permissions to update this user. If you beleive you should please contact your system administrator.')));
}
?>
