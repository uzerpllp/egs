<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Save Contact Access 1.0          |
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

/* Check user has access to the contacts and crm module */
if (in_array('contacts', $_SESSION['modules'])) {
	/* This is set to try if the person was saved */
	$saved = false;
	$select = false;
	$id = null;

	/* Set the id if set */
	if (isset ($_GET['id']))
		$id = intval($_GET['id']);
	if (isset ($_POST['id']))
		$id = ($_POST['id']);
	
	require_once (EGS_FILE_ROOT.'/src/classes/class.person.php');

	$person = new person();
	
	if($person->accessLevel($id) > 2) {	
		
	/* Do a save if the form has been posted */
	if (sizeof($_POST) > 0) {
		/* Check the post array */
		$egs->checkPost();

		$saved = $person->updateAccess($_POST);
	}

	if ($saved) {
		$smarty->assign('redirect', true);
		$smarty->assign('redirectAction', 'action=viewperson&amp;id='.$_POST['id']);
	} else {
		/* Set up arrays to hold form elements */
		$leftForm = array ();
		$rightForm = array ();
		$bottomForm = array ();

		/* Set up the title */
		$smarty->assign('pageTitle', _('Save Changes to Person Access'));

		/* Build the form */

		$hidden = array ();
		if (isset ($id))
			$hidden['id'] = $id;

		$smarty->assign('hidden', $hidden);

		/* Set the groups */
		$item = array ();
		$item['type'] = 'title';
		$item['tag'] = _('Group Access Details');

		$leftForm[] = $item;

		/* Setup the Groups */
		$item = array ();

		$query = 'SELECT id, name FROM groups WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY name';

		$type = $db->query($query);

		$item['options'] = array ();

		while (!$type->EOF) {
			$item['options'][$type->fields['id']] = _($type->fields['name']);
			$type->MoveNext();
		}

		$item['type'] = 'multiple';
		$item['tag'] = _('Restricted Read');
		$item['name'] = 'restrictedreadgroups[]';
			
		$query = 'SELECT a.groupid FROM persongroupaccessxref a, groups g WHERE a.personid='.$db->qstr($id).' AND a.groupid=g.id AND a.type=0 AND g.companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY a.groupid';

		$rs = $db->Execute($query);
		
		$values = array();

		while(!$rs->EOF) {
			$values[] = $rs->fields['groupid'];
			$rs->MoveNext();
		}
				
		$item['value'] = $values;

		$leftForm[] = $item;
		
		$item['tag'] = _('Read');
		$item['name'] = 'readgroups[]';
		
		$query = 'SELECT a.groupid FROM persongroupaccessxref a, groups g WHERE a.personid='.$db->qstr($id).' AND a.groupid=g.id AND a.type=1 AND g.companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY a.groupid';

		$rs = $db->Execute($query);
		
		$values = array();

		while(!$rs->EOF) {
			$values[] = $rs->fields['groupid'];
			$rs->MoveNext();
		}
				
		$item['value'] = $values;
		
		$leftForm[] = $item;
		
		$item['tag'] = _('Write');
		$item['name'] = 'writegroups[]';
		
		$query = 'SELECT a.groupid FROM persongroupaccessxref a, groups g WHERE a.personid='.$db->qstr($id).' AND a.groupid=g.id AND a.type=4 AND g.companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY a.groupid';

		$rs = $db->Execute($query);
		
		$values = array();

		while(!$rs->EOF) {
			$values[] = $rs->fields['groupid'];
			$rs->MoveNext();
		}
				
		$item['value'] = $values;
		
		$leftForm[] = $item;

		$item = array ();
		$item['type'] = 'title';
		$item['tag'] = _('User Access Details');
	
		$rightForm[] = $item;
		/* Set the users */
		$item = array ();

		$query = 'SELECT username FROM useraccess WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY username';

		$type = $db->query($query);

		$item['options'] = array ();

		while (!$type->EOF) {
			$item['options'][$type->fields['username']] = _($type->fields['username']);
			$type->MoveNext();
		}

		$item['type'] = 'multiple';
		$item['tag'] = _('Restricted Read');
		$item['name'] = 'restrictedreadusers[]';
		
		$query = 'SELECT username FROM personuseraccessxref WHERE type=0 AND personid='.$db->qstr($id).' AND usercompanyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY username';

		$rs = $db->Execute($query);
		
		$values = array();

		while(!$rs->EOF) {
			$values[] = $rs->fields['username'];
			$rs->MoveNext();
		}
				
		$item['value'] = $values;

		$rightForm[] = $item;
		
		$item['tag'] = _('Read');
		$item['name'] = 'readusers[]';
		
		$query = 'SELECT username FROM personuseraccessxref WHERE type=1 AND personid='.$db->qstr($id).' AND usercompanyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY username';

		$rs = $db->Execute($query);
		
		$values = array();

		while(!$rs->EOF) {
			$values[] = $rs->fields['username'];
			$rs->MoveNext();
		}
				
		$item['value'] = $values;
		
		$rightForm[] = $item;
		
		$item['tag'] = _('Write');
		$item['name'] = 'writeusers[]';
		
		$query = 'SELECT username FROM personuseraccessxref WHERE type=4 AND personid='.$db->qstr($id).' AND usercompanyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY username';

		$rs = $db->Execute($query);
		
		$values = array();

		while(!$rs->EOF) {
			$values[] = $rs->fields['username'];
			$rs->MoveNext();
		}
				
		$item['value'] = $values;
		
		$rightForm[] = $item;

		/* Assign the form variable */
		$smarty->assign('form', true);
		$smarty->assign('leftForm', $leftForm);
		$smarty->assign('rightForm', $rightForm);
		$smarty->assign('formId', 'saveform');
	}
	} else {
			$smarty->assign('errors', array(_('You do not have the correct access to edit this person access. If you beleive you should please contact your system administrator')));
			$smarty->assign('redirect', true);
			$smarty->assign('redirectAction', 'action=view&amp;id='.$_GET['id']);		
		}
} else {
	$smarty->assign('errors', array (_('You are trying to access a module to which you do not have access, if you beleive you should please contact your system administrator')));
}
?>

