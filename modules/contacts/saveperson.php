<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Save Person 1.0                  |
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

/* Check user has access to this module */
if (isset ($_SESSION['modules']) && (in_array('contacts', $_SESSION['modules']))||isset($_GET['action'])&&$_GET['action']=='details') {
	
	/* This is set to try if the company was saved */
	$saved = false;
	$select = false;
	$id = null;

	/* Set the id if set */
	if(isset($_GET['id'])) $id = intval($_GET['id']);
	if(isset($_POST['id'])) $id = ($_POST['id']);
	if(isset($_GET['companyid'])) $companyId = intval($_GET['companyid']);
	if(isset($_POST['companyid']) && ($_POST['companyid'] != '')) $companyId = intval($_POST['companyid']);

	if($_GET['module'] != 'contacts' && $_GET['module']!='home' && $id!=EGS_PERSON_ID) {
		$id = EGS_PERSON_ID;
		$companyId = EGS_ACTUAL_COMPANY_ID;
	}
	
	if(isset($companyId)) {
		
		require_once(EGS_FILE_ROOT.'/src/classes/class.company.php');

		$company = new company();
		
		if($company->accessLevel($companyId) < 3) {
			$smarty->assign('errors', array(_('You do not have the correct access to add a person to this company. If you beleive you should please contact your system administrator')));
			$smarty->assign('redirect', true);
			if($_GET['module']=='contacts')
				$smarty->assign('redirectAction', 'action=viewperson&amp;id='.$_GET['id']);
			else
				$smarty->assign('redirectAction', 'action=details');
			return false;
		}
	}
	
	/* Do a save if the form has been posted */
	if(sizeof($_POST) >0) {
		/* Check the post array */
		$egs->checkPost();

		require_once(EGS_FILE_ROOT.'/src/classes/class.person.php');

		$person = new person();
		
		if(isset($_POST['delete'])) $saved = $person->deletePerson($id);
		else $saved = $person->savePerson($_POST, $id);
		
	}

	if($saved) {
		
		$smarty->assign('redirect', true);
		if(isset($_POST['delete']) && isset($_POST['companyid'])) $smarty->assign('redirectAction', 'action=view&amp;id='.$_POST['companyid']);
		else if(isset($_POST['delete'])) $smarty->assign('redirectAction', '');
		else if($_GET['module'] == 'contacts') $smarty->assign('redirectAction', 'action=viewperson&amp;id='.$_POST['id']);
		else $smarty->assign('redirectAction', 'action=details');
		
	} else {
	/* Set up arrays to hold form elements */
	$leftForm = array();
	$rightForm = array();
	$bottomForm = array();

	if(isset($id)) {
		require_once(EGS_FILE_ROOT.'/src/classes/class.person.php');

		$person = new person();
		
		if(($person->accessLevel($id) > 2) && (sizeof($_POST) == 0)) {	
			$query = 'SELECT *, reportsto AS personid FROM personoverview WHERE id='.$db->qstr($id);

			$_POST = $db->GetRow($query);
			
			if($_POST['companyid'] != '') $companyId = $_POST['companyid'];

			$select = true;
		} else {
			$smarty->assign('errors', array(_('You do not have the correct access to edit this person. If you beleive you should please contact your system administrator')));
			$smarty->assign('redirect', true);
			$smarty->assign('redirectAction', '');		
			return false;
		}
	}

	/* Set up the title */
	if(isset($id)) $smarty->assign('pageTitle',  _('Save Changes to Person'));
	else $smarty->assign('pageTitle', _('Save New Person'));
	
	if(isset($id) && ($person->accessLevel($id) > 3)) $smarty->assign('formDelete', true);	

	/* Build the form */

	$hidden = array();
	if(isset($id)) $hidden['id'] = $id;

	$smarty->assign('hidden', $hidden);
	
	/* Person's title */
	$item = array();

	$item['options'][''] = _('Please choose one ...');
	$item['options']['Mr.'] = _('Mr.');
	$item['options']['Ms.'] = _('Ms.');
	$item['options']['Mrs.'] = _('Mrs.');
	$item['options']['Dr.'] = _('Dr.');
	$item['options']['Prof.'] = _('Prof.');

	$item['type'] = 'select';
	$item['tag'] = _('Title');
	$item['name'] = 'title';
	if(isset($_POST['title'])) $item['value'] = $_POST['title'];

	$leftForm[] = $item;
	
	/* Setup the name */
	$item = array();
	$item['type'] = 'text';
	$item['tag'] = _('First Name');
	$item['name'] = 'firstname';
	if(isset($_POST['firstname'])) $item['value'] = $_POST['firstname'];
	$item['compulsory'] = true;

	$leftForm[] = $item;
	
	/* Setup the middle name */
	$item = array();
	$item['type'] = 'text';
	$item['tag'] = _('Middle Name');
	$item['name'] = 'middlename';
	if(isset($_POST['middlename'])) $item['value'] = $_POST['middlename'];

	$leftForm[] = $item;
	
	/* Setup the surname */
	$item = array();
	$item['type'] = 'text';
	$item['tag'] = _('Surname');
	$item['name'] = 'surname';
	if(isset($_POST['surname'])) $item['value'] = $_POST['surname'];
	$item['compulsory'] = true;

	$leftForm[] = $item;
	
	/* Setup the suffix */
	$item = array();
	$item['type'] = 'text';
	$item['tag'] = _('Suffix');
	$item['name'] = 'suffix';
	if(isset($_POST['suffix'])) $item['value'] = $_POST['suffix'];

	$leftForm[] = $item;

	/* Setup the language */
	$item = array();

	$query = 'SELECT code, name FROM lang ORDER BY name';

	$languages = $db->query($query);

	$item['options'] = array();

	while(!$languages->EOF) {
		$item['options'][$languages->fields['code']] = $languages->fields['name'];
		$languages->MoveNext();
	}

	$item['type'] = 'select';
	$item['tag'] = _('Language');
	$item['name'] = 'lang';
	if(isset($_POST['lang'])) $item['value'] = $_POST['lang'];
	else $item['value'] = 'EN';

	$leftForm[] = $item;
	
	if($_GET['module'] == 'contacts') {
		if(isset($companyId)) {
			$query = 'SELECT name FROM company WHERE id='.$db->qstr($companyId);
			
			$_POST['companyname'] = $db->GetOne($query);	
		}
		
		/* Setup the branch */
		$item = array();
		$item['type'] = 'company';
		$item['tag'] = _('Attach to');
		$item['name'] = 'company';
		if(isset($companyId)) $item['value'] = $_POST['companyname'];
		if(isset($companyId)) $item['actualvalue'] = $companyId;
	
		$leftForm[] = $item;
	}
	
	if(isset($_POST['personid'])) {
		$query = 'SELECT firstname || \' \' || surname AS name FROM person WHERE id='.$db->qstr($_POST['personid']);
		
		$_POST['personname'] = $db->GetOne($query);	
	}
	
	/* Setup the branch */
	$item = array();
	$item['type'] = 'person';
	$item['tag'] = _('Reports to');
	$item['name'] = 'person';
	if(isset($_POST['personname'])) $item['value'] = $_POST['personname'];
	if(isset($_POST['personid'])) $item['actualvalue'] = $_POST['personid'];

	$leftForm[] = $item;

	/* Setup the user it is assigned to */
	$item = array();

	$query = 'SELECT username FROM useraccess WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY username';

	$users = $db->query($query);

	if(!$users && EGS_DEBUG_SQL) die($db->ErrorMsg());

	$item['options'] = array();

	while(!$users->EOF) {
		$item['options'][$users->fields['username']] = $users->fields['username'];
		$users->MoveNext();
	}

	$item['type'] = 'select';
	$item['tag'] = _('Assigned To');
	$item['name'] = 'assigned';
	if(isset($_POST['assigned'])) $item['value'] = $_POST['assigned'];
	else $item['value'] = EGS_USERNAME;

	$leftForm[] = $item;
	
	$item['type'] = 'space';

	$leftForm[] = $item;
	
	if(isset($_POST['companyid']) && ($_POST['companyid'] == EGS_COMPANY_ID) && (EGS_ACTUAL_COMPANY_ID == EGS_COMPANY_ID)) {
		$item = array();
	
		$item['options'][''] = _('Please choose one ...');
		$item['options']['1'] = _('Single');
		$item['options']['2'] = _('Married');
		$item['options']['3'] = _('Divorced');
		$item['options']['4'] = _('Widowed');
		$item['options']['5'] = _('Co-Habiting');
	
		$item['type'] = 'select';
		$item['tag'] = _('Marital Status');
		$item['name'] = 'marital';
		if(isset($_POST['marital'])) $item['value'] = $_POST['marital'];
	
		$leftForm[] = $item;
		
		$item = array();
		$item['type'] = 'date';
		$item['tag'] = _('Date of Birth');
		$item['name'] = 'dob';
		$item['format'] = EGS_DATE_FORMAT;
		if(isset($_POST['dob'])) {
			 $item['actualvalue'] = $_POST['dob'];
			 $item['value'] = date(str_replace('%', '', EGS_DATE_FORMAT), mktime($_POST['dob']));
		}
	
		$leftForm[] = $item;
		
		$item = array();
		$item['type'] = 'text';
		$item['tag'] = _('National Insurance');
		$item['name'] = 'ni';
		if(isset($_POST['ni'])) $item['value'] = $_POST['ni'];
	
		$leftForm[] = $item;
	}
	
	$item = array();
	$item['type'] = 'text';
	$item['tag'] = _('Job Title');
	$item['name'] = 'jobtitle';
	if(isset($_POST['jobtitle'])) $item['value'] = $_POST['jobtitle'];

	$leftForm[] = $item;
	
	$item = array();
	$item['type'] = 'text';
	$item['tag'] = _('Department');
	$item['name'] = 'department';
	if(isset($_POST['department'])) $item['value'] = $_POST['department'];

	$leftForm[] = $item;
	
	if(isset($_POST['companyid']) && ($_POST['companyid'] != EGS_COMPANY_ID) && (EGS_ACTUAL_COMPANY_ID != EGS_COMPANY_ID)) {
		$item = array();
		$item['type'] = 'space';
	
		$leftForm[] = $item;
		$leftForm[] = $item;
		$leftForm[] = $item;
	}
	
	if($_GET['module'] != 'contacts') {
		$item = array();
		$item['type'] = 'space';
	
		$leftForm[] = $item;
	}
	
	$item = array();
	$item['type'] = 'text';
	$item['tag'] = _('Phone');
	$item['name'] = 'phone';
	if(isset($_POST['phone'])) $item['value'] = $_POST['phone'];

	$rightForm[] = $item;
	
	$item = array();
	$item['type'] = 'text';
	$item['tag'] = _('Fax');
	$item['name'] = 'fax';
	if(isset($_POST['fax'])) $item['value'] = $_POST['fax'];

	$rightForm[] = $item;
	
	$item = array();
	$item['type'] = 'text';
	$item['tag'] = _('Mobile');
	$item['name'] = 'mobile';
	if(isset($_POST['mobile'])) $item['value'] = $_POST['mobile'];

	$rightForm[] = $item;
	
	$item = array();
	$item['type'] = 'text';
	$item['tag'] = _('Email');
	$item['name'] = 'email';
	if(isset($_POST['email'])) $item['value'] = $_POST['email'];

	$rightForm[] = $item;

	$item = array();
	$item['type'] = 'space';

	$rightForm[] = $item;
	
	/* Set up the address */
	$item = array();
	$item['type'] = 'text';
	$item['tag'] = _('Street 1');
	$item['name'] = 'street1';
	if(isset($_POST['street1'])) $item['value'] = $_POST['street1'];

	$rightForm[] = $item;
	
	$item = array();
	$item['type'] = 'text';
	$item['tag'] = _('Street 2');
	$item['name'] = 'street2';
	if(isset($_POST['street2'])) $item['value'] = $_POST['street2'];

	$rightForm[] = $item;
	
	$item = array();
	$item['type'] = 'text';
	$item['tag'] = _('Street 3');
	$item['name'] = 'street3';
	if(isset($_POST['street3'])) $item['value'] = $_POST['street3'];

	$rightForm[] = $item;
	
	$item = array();
	$item['type'] = 'text';
	$item['tag'] = _('Town');
	$item['name'] = 'town';
	if(isset($_POST['town'])) $item['value'] = $_POST['town'];

	$rightForm[] = $item;
	
	$item = array();
	$item['type'] = 'text';
	$item['tag'] = _('County');
	$item['name'] = 'county';
	if(isset($_POST['county'])) $item['value'] = $_POST['county'];

	$rightForm[] = $item;
	
	$item = array();
	$item['type'] = 'text';
	$item['tag'] = _('Postcode');
	$item['name'] = 'postcode';
	
	if(defined('EGS_LICENSE_CODE')&& EGS_LICENSE_CODE!='' && defined('EGS_LICENSE_KEY')&& EGS_LICENSE_KEY!='')
		$item['lookup']=true;
	if(isset($_POST['postcode'])) $item['value'] = $_POST['postcode'];

	$rightForm[] = $item;
	
	/* Setup the countries */
	$item = array();

	$query = 'SELECT code, name FROM country ORDER BY name';

	$countries = $db->query($query);

	if(!$countries && EGS_DEBUG_SQL) die($db->ErrorMsg());

	$item['options'] = array();

	while(!$countries->EOF) {
		$item['options'][$countries->fields['code']] = $countries->fields['name'];
		$countries->MoveNext();
	}

	$item['type'] = 'select';
	$item['tag'] = _('Country');
	$item['name'] = 'countrycode';
	if(isset($_POST['countrycode'])) $item['value'] = $_POST['countrycode'];
	else $item['value']=EGS_DEFAULT_COUNTRY;
	$rightForm[] = $item;
	
	$item = array();
	$item['type'] = 'space';

	$rightForm[] = $item;
	
	$item = array();
	$item['type'] = 'checkbox';
	$item['tag'] = _('Call');
	$item['name'] = 'cancall';
	if(isset($_POST['cancall'])) $item['value'] = 'checked';
	else if(!isset($id)) $item['value'] = 'checked';

	$rightForm[] = $item;
	
	$item = array();
	$item['type'] = 'checkbox';
	$item['tag'] = _('Email');
	$item['name'] = 'canemail';
	if(isset($_POST['canemail'])) $item['value'] = 'checked';
	else if(!isset($id)) $item['value'] = 'checked';

	$rightForm[] = $item;

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
	$smarty->assign('moduleIcon', 'person');
	}
	} else {
	$smarty->assign('errors', array (_('You do not have the correct permissions to access this module. If you believe you should please contact your system administrator')));
}
?>
