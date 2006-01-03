<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Save Account Contact 1.0         |
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
	/* This is set to try if the company was saved */
	$saved = false;
	$select = false;
	$id = null;

	/* Set the id if set */
	if (isset ($_GET['id']))
		$id = $_GET['id'];
	if (isset ($_POST['id']))
		$id = $_POST['id'];
	if (isset ($_GET['companyid']))
		$companyId = intval($_GET['companyid']);
	if (isset ($_POST['companyid']))
		$companyId = ($_POST['companyid']);
	if (isset ($_GET['personid']))
		$personId = intval($_GET['personid']);
	if (isset ($_POST['personid']))
		$personId = ($_POST['personid']);
		
	if($_GET['module'] != 'contacts') {
		$personId = EGS_PERSON_ID;
	}

	if(isset($companyId)) {
		require_once (EGS_FILE_ROOT.'/src/classes/class.company.php');
	
		$company = new company();
	}
	
	if(isset($personId)) {
		require_once (EGS_FILE_ROOT.'/src/classes/class.person.php');
	
		$person = new person();
	}

	/* Do a save if the form has been posted */
	if (sizeof($_POST) > 0) {
		/* Check the post array */
		$egs->checkPost();

		if(isset($_POST['delete']) && isset($companyId)) $saved = $company->deleteContact($_POST);
		else if(isset($_POST['delete']) && isset($personId)) $saved = $person->deleteContact($_POST);
		else if(isset($companyId)) $saved = $company->saveContact($_POST, $id);
		else if(isset($personId)) $saved = $person->saveContact($_POST, $id);
	}

	if ($saved) {
		$smarty->assign('redirect', true);
		if(!isset($_POST['delete']) && isset($companyId)) $smarty->assign('redirectAction', 'action=view&amp;id='.$_POST['companyid']);
		if(!isset($_POST['delete']) && isset($personId) && ($_GET['module'] != 'contacts')) $smarty->assign('redirectAction', 'action=details');
		else if(!isset($_POST['delete']) && isset($personId) && ($_GET['module'] == 'contacts')) $smarty->assign('redirectAction', 'action=viewperson&amp;id='.$_POST['personid']);
	} else {
		/* Set up arrays to hold form elements */
		$leftForm = array ();
		$leftForm = array ();
		$bottomForm = array ();

		if (isset ($id)) {
			if (isset($companyId) && ($company->accessLevel($companyId) > 2) && (sizeof($_POST) == 0)) {
				$query = 'SELECT * FROM companycontactmethod WHERE tag='.$db->qstr($id).' AND companyid='.$db->qstr($companyId).' AND type='.$db->qstr($_SESSION['preferences']['contactsView']);

				$_POST = $db->GetRow($query);

				$select = true;
			} else if ((sizeof($_POST) == 0) && isset($companyId)) {
			$smarty->assign('errors', array (_('You do not have the correct access to edit this contact. If you beleive you should please contact your system administrator')));
			$smarty->assign('redirect', true);
			$smarty->assign('redirectAction', 'action=view&amp;id='.$companyId);
			
			return false;
		} else if (isset($personId) && ($person->accessLevel($personId) > 2) && (sizeof($_POST) == 0)) {
				$query = 'SELECT * FROM personcontactmethod WHERE tag='.$db->qstr($id).' AND personid='.$db->qstr($personId).' AND type='.$db->qstr($_SESSION['preferences']['contactsView']);

				$_POST = $db->GetRow($query);

				$select = true;
			} else if ((sizeof($_POST) == 0) && isset($personId)) {
			$smarty->assign('errors', array (_('You do not have the correct access to edit this contact. If you beleive you should please contact your system administrator')));
			$smarty->assign('redirect', true);
			$smarty->assign('redirectAction', 'action=viewperson&amp;id='.$personId);
			
			return false;
		}
		} else if(isset($companyId)) {
			if($company->accessLevel($companyId) < 3) {
				$smarty->assign('errors', array (_('You do not have the correct access to add a contact to this company. If you believe you should please contact your system administrator')));
			$smarty->assign('redirect', true);
			$smarty->assign('redirectAction', 'action=view&amp;id='.$companyId);
			
			return true;
			}
		} else if(isset($personId)) {
			if($person->accessLevel($personId) < 3) {
				$smarty->assign('errors', array (_('You do not have the correct access to add a contact to this person. If you believe you should please contact your system administrator')));
			$smarty->assign('redirect', true);
			$smarty->assign('redirectAction', 'action=viewperson&amp;id='.$personId);
			
			return true;
			}
		}

			/* Set up the title */
			if (isset ($id))
				$smarty->assign('pageTitle', _('Save Changes to Contact'));
			else
				$smarty->assign('pageTitle', _('Save New Contact'));

			if(isset($id) && isset($companyId) && ($company->accessLevel($companyId) > 2) && ($id != 'MAIN')) $smarty->assign('formDelete', true);
			if(isset($id) && isset($personId) && ($person->accessLevel($personId) > 2) && ($id != 'MAIN')) $smarty->assign('formDelete', true);
			
			/* Build the form */

			$hidden = array ();
			if (isset ($id))
				$hidden['tag'] = $id;
			
			if(isset($companyId)) $hidden['companyid'] = $companyId;
			if(isset($personId)) $hidden['personid'] = $personId;

			$smarty->assign('hidden', $hidden);

			/* Setup the name */
			$item = array ();
			$item['type'] = 'text';
			$item['tag'] = _('Name');
			$item['name'] = 'name';
			if (isset ($_POST['name']))
				$item['value'] = $_POST['name'];
			$item['compulsory'] = true;

			$leftForm[] = $item;

			/* Set up the address */
			$item = array ();
			$item['type'] = 'text';
			$item['tag'] = _('Contact');
			$item['name'] = 'contact';
			if (isset ($_POST['contact']))
				$item['value'] = $_POST['contact'];
			$item['compulsory'] = true;

			$rightForm[] = $item;
			/* Assign the form variable */
			$smarty->assign('form', true);
			$smarty->assign('leftForm', $leftForm);
			$smarty->assign('rightForm', $rightForm);
			$smarty->assign('formId', 'saveform');
	}
} else {
	$smarty->assign('errors', array (_('You are trying to access a module to which you do not have access, if you beleive you should please contact your system administrator')));
}
?>