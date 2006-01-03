<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Save User 1.0                    |
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
if (isset ($_GET['id'])) {
	$groupid=$_GET['id'];
	$edit=true;
} else {
	$edit = false;
}
if (isset ($_POST['username']))
	$groupid=$_GET['id'];

require_once(EGS_FILE_ROOT.'/src/classes/class.admin.php');

$admin = new admin();
/*need to do a check to see if the person viewing the page has access to see the group*/
if(isset($groupid)) {
$q = 'SELECT id FROM groups WHERE id='.$db->qstr($groupid).' AND companyid='.$db->qstr(EGS_COMPANY_ID);
//$q = 'SELECT id FROM groups WHERE id='.$db->qstr($groupid).' AND companyid=2';
if ($db->GetOne($q)||!isset($groupid)) {
	$allowed=true;	
}
else {
	$allowed=false;
	
}	
} else {
	$allowed = false;
}


/* Check that the admin is enabled, and the correct permissions are valid for the admin. */
if (in_array('admin', $_SESSION['modules'])&& ($allowed || !isset($groupid)) ) {
	/* Set up the variables for the form */
	$saved = false;
	$select = false;
	if(!isset($id)) $id = null;

	/* Do a save if the form has been posted */
	if (sizeof($_POST) > 0) {
		/* Check the post array */
		$egs->checkPost();

		/* If deleting, delete. otherwise save*/
		if(isset($_POST['delete'])) $saved = $admin->deleteGroup($groupid);
		else if(!isset($_POST['delete'])) $saved = $admin->saveGroup($_POST,$groupid);
	}

	/* Redirect to the admin view if the form saved successfully */
	if ($saved) {
		$smarty->assign('redirect', true);
		$smarty->assign('redirectAction', 'action=groups');
	} else {
		/* Set up arrays to hold form elements */
		$leftForm = array ();
		$rightForm = array ();
		$bottomForm = array ();

		/* We are editing the admin so check access and get the data */
		if ($edit) {
			$q = 'SELECT id, name FROM groups WHERE id='.$db->qstr($_GET['id']);
			$_POST = $db->GetRow($q);
			
			$q = 'SELECT gm.username FROM groups g JOIN groupmembers gm ON g.id=gm.groupid WHERE g.name='.$db->qstr($_POST['name']);	
			
			$rs = $db->Execute($q);
			$users=array();
			while (!$rs->EOF) {
				$users[]=$rs->fields['username'];
				$rs->MoveNext();	
			}
			$_POST['users']=$users;
			$q = 'select id, name from module join groupmoduleaccess on module.id=groupmoduleaccess.moduleid where groupid='.$db->qstr($_POST['id']);
			$rs = $db->query($q);
			$modules=array();
			while (!$rs->EOF) {
				$modules[$rs->fields['name']]=$rs->fields['id'];
				$rs->MoveNext();	
			}
			$_POST['modules']=$modules;
		}
/*displaying the page*/

		/* Set up the title */
		if (isset ($_GET['id'])) {
			$smarty->assign('pageTitle', _('Save Changes to Group'));
		}
		else {
			$smarty->assign('pageTitle', _('Save New User'));
		}

		/* Show the delete button if editing */
		/*don't, because deleting users gets messy and you can just stop them logging in*/
		if(isset($edit)) $smarty->assign('formDelete', true);

		/* Add any hidden fields we need */
		$hidden = array ();
		if (isset ($username)) {
			$hidden['olduser'] = $username;
			$hidden['username'] = $username;
			$hidden['groupid'] = $_POST['id'];
		}
		$smarty->assign('hidden', $hidden);
		
		$item = array();
		$item['type'] = 'text';
		$item['name'] = 'name';
		$item['tag'] = _('Group');
		if(isset($_POST['name']))
			$item['value']=$_POST['name'];
			
		$leftForm[]=$item;
		
		$item = array();
		$item['type'] = 'multiple';
		$item['name'] = 'users[]';
		$item['tag'] = _('Users');
		$item['options'] = array();

		$q = 'SELECT u.username FROM useraccess u, person p WHERE p.owner=u.username AND p.userdetail AND u.companyid='.$db->qstr(EGS_COMPANY_ID);
		$rs = $db->Execute($q);
		while(!$rs->EOF) {

			$item['options'][$rs->fields['username']]=$rs->fields['username'];
			$rs->MoveNext();	
		}
		if(isset($_POST['users']))
			$item['value']=$_POST['users'];
		$leftForm[]=$item;
		
		$item = array();
		$item['type'] = 'multiple';
		$item['name'] = 'modules[]';
		$item['tag'] = _('Modules');
		$item['options'] = array();
		$q = 'SELECT m.id, m.name FROM module m, companymoduleaccess cma WHERE m.id=cma.moduleid AND cma.companyid='.$db->qstr(EGS_COMPANY_ID);
		$rs = $db->Execute($q);
		while(!$rs->EOF) {
			$item['options'][$rs->fields['id']]=$rs->fields['name'];
			$rs->MoveNext();	
		}
		if(isset($_POST['modules']))
			$item['value']=$_POST['modules'];
		$leftForm[]=$item;
		
		/* Assign the form variable */
		$smarty->assign('form', true);
		$smarty->assign('leftForm', $leftForm);
		$smarty->assign('rightForm', $rightForm);
		$smarty->assign('formId', 'saveform');
	}
}
else {
	if ($allowed)$errors[] = _('You don\'t have access to edit groups');
	else $errors[] = _('You don\'t have access to edit groups in this company');
	$smarty->assign('errors',$errors);	
	$smarty->assign('redirect', true);
	$smarty->assign('redirectAction', 'action=groups');
}
?>
