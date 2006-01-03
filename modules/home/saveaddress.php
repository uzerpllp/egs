<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Save Account Address 1.0         |
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

		if(isset($_POST['delete']) && isset($companyId)) $saved = $company->deleteAddress($_POST);
		if(isset($_POST['delete']) && isset($personId)) $saved = $person->deleteAddress($_POST);
		else if(isset($companyId)) $saved = $company->saveAddress($_POST, $id);
		else if(isset($personId)) $saved = $person->saveAddress($_POST, $id);
	}

	if ($saved) {
		$smarty->assign('redirect', true);
		if(!isset($_POST['delete']) && isset($companyId)) $smarty->assign('redirectAction', 'action=view&amp;id='.$_POST['companyid']);
		if(!isset($_POST['delete']) && isset($personId) && ($_GET['module'] != 'contacts')) $smarty->assign('redirectAction', 'action=details&amp;id='.$_POST['personid']);
		else $smarty->assign('redirectAction', 'action=viewperson&amp;id='.$_POST['personid']);
	} else {
		/* Set up arrays to hold form elements */
		$leftForm = array ();
		$leftForm = array ();
		$bottomForm = array ();

		if (isset ($id)) {
			if (isset($companyId) && ($company->accessLevel($companyId) > 2) && (sizeof($_POST) == 0)) {
				$query = 'SELECT * FROM companyaddress WHERE tag='.$db->qstr($id).' AND companyid='.$db->qstr($companyId);

				$_POST = $db->GetRow($query);

				$select = true;
			} else if (isset($companyId) && (sizeof($_POST) == 0)) {
			$smarty->assign('errors', array (_('You do not have the correct access to edit this address. If you beleive you should please contact your system administrator')));
			$smarty->assign('redirect', true);
			$smarty->assign('redirectAction', 'action=view&amp;id='.$id);
			
			return false;
		} else if (isset($personId) && ($person->accessLevel($personId) > 2) && (sizeof($_POST) == 0)) {
				$query = 'SELECT * FROM personaddress WHERE tag='.$db->qstr($id).' AND personid='.$db->qstr($personId);

				$_POST = $db->GetRow($query);

				$select = true;
			} else if (isset($personId) && (sizeof($_POST) == 0)) {
			$smarty->assign('errors', array (_('You do not have the correct access to edit this address. If you beleive you should please contact your system administrator')));
			$smarty->assign('redirect', true);
			$smarty->assign('redirectAction', 'action=viewperson&amp;id='.$personId);
			
			return false;
		}
		} else if(isset($companyId)) {
			if($company->accessLevel($companyId) < 3) {
				$smarty->assign('errors', array (_('You do not have the correct access to add an address to this company. If you believe you should please contact your system administrator')));
			$smarty->assign('redirect', true);
			$smarty->assign('redirectAction', 'action=view&amp;id='.$companyId);
			
			return false;
			}
		} else if(isset($personId)) {
			if($person->accessLevel($personId) < 3) {
				$smarty->assign('errors', array (_('You do not have the correct access to add an address to this person. If you believe you should please contact your system administrator')));
			$smarty->assign('redirect', true);
			$smarty->assign('redirectAction', 'action=viewperson&amp;id='.$personId);
			
			return false;
			}
		}

			/* Set up the title */
			if (isset ($id))
				$smarty->assign('pageTitle', _('Save Changes to Address'));
			else
				$smarty->assign('pageTitle', _('Save New Address'));

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
			$item['tag'] = _('Street 1');
			$item['name'] = 'street1';
			if (isset ($_POST['street1']))
				$item['value'] = $_POST['street1'];

			$leftForm[] = $item;

			$item = array ();
			$item['type'] = 'text';
			$item['tag'] = _('Street 2');
			$item['name'] = 'street2';
			if (isset ($_POST['street2']))
				$item['value'] = $_POST['street2'];

			$leftForm[] = $item;

			$item = array ();
			$item['type'] = 'text';
			$item['tag'] = _('Street 3');
			$item['name'] = 'street3';
			if (isset ($_POST['street3']))
				$item['value'] = $_POST['street3'];

			$leftForm[] = $item;

			$item = array ();
			$item['type'] = 'text';
			$item['tag'] = _('Town');
			$item['name'] = 'town';
			if (isset ($_POST['town']))
				$item['value'] = $_POST['town'];

			$leftForm[] = $item;

			$item = array ();
			$item['type'] = 'text';
			$item['tag'] = _('County');
			$item['name'] = 'county';
			if (isset ($_POST['county']))
				$item['value'] = $_POST['county'];

			$leftForm[] = $item;

			$item = array ();
			$item['type'] = 'text';
			$item['tag'] = _('Postcode');
			$item['name'] = 'postcode';
			if (isset ($_POST['postcode']))
				$item['value'] = $_POST['postcode'];

			$leftForm[] = $item;

			/* Setup the countries */
			$item = array ();

			$query = 'SELECT code, name FROM country ORDER BY name';

			$countries = $db->query($query);

			if (!$countries && EGS_DEBUG_SQL)
				die($db->ErrorMsg());

			$item['options'] = array ();

			while (!$countries->EOF) {
				$item['options'][$countries->fields['code']] = $countries->fields['name'];
				$countries->MoveNext();
			}

			$item['type'] = 'select';
			$item['tag'] = _('Country');
			$item['name'] = 'countrycode';
			if (isset ($_POST['countrycode']))
				$item['value'] = $_POST['countrycode'];

			$leftForm[] = $item;


			/* Assign the form variable */
			$smarty->assign('form', true);
			$smarty->assign('leftForm', $leftForm);
			$smarty->assign('formId', 'saveform');
	}
} else {
	$smarty->assign('errors', array (_('You are trying to access a module to which you do not have access, if you beleive you should please contact your system administrator')));
}
?>