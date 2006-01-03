<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Save Opportunity 1.0             |
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
if (isset ($_SESSION['modules']) && (in_array('crm', $_SESSION['modules']))) {
	/* This is set to try if the company was saved */
	$saved = false;
	$access = true;
	$id = null;

	/* Set the id if set */
	if (isset ($_GET['id']))
		$id = intval($_GET['id']);
	if (isset ($_POST['id']))
		$id = ($_POST['id']);

	/* Do a save if the form has been posted */
	if (sizeof($_POST) > 0) {
		/* Check the post array */
		$egs->checkPost();

		require_once (EGS_FILE_ROOT.'/src/classes/class.crm.php');

		$crm = new crm();

		if(isset($_POST['delete'])) $saved = $crm->deleteOpportunity($_POST['id']);
		else $saved = $crm->saveOpportunity($_POST, $id);
	}
	
	if (isset ($_GET['companyid']))
		$companyId = intval($_GET['companyid']);
	if (isset ($_POST['companyid']))
		$companyId = intval($_POST['companyid']);
	if (isset ($_GET['personid']))
		$personId = intval($_GET['personid']);
	if (isset ($_POST['personid']))
		$personId = intval($_POST['personid']);

	if ($saved) {
		$smarty->assign('redirect', true);
		if(!isset($_POST['delete'])) $smarty->assign('redirectAction', 'action=viewopportunity&amp;id='.$_POST['id']);

	} else if (isset ($id)) {
			require_once (EGS_FILE_ROOT.'/src/classes/class.crm.php');

			$crm = new crm();

			$query = 'SELECT * FROM opportunityoverview WHERE id='.$db->qstr($id);

			$_POST = $db->GetRow($query);

			if (isset ($_POST['companyid']))
				$companyId = intval($_POST['companyid']);
			if (isset ($_POST['personid']))
				$personId = intval($_POST['personid']);
				
			if($crm->opportunityAccess($id) < 2) {
				$access = false;
				$smarty->assign('redirect', true);
				$smarty->assign('redirectAction', 'action=viewopportunity&amp;id='.$id);
				$smarty->assign('errors', array(_('You do not have the correct permissions to attach an opportunity to this company.')));
			}
	}
	
	if(isset($companyId)) {
		require_once (EGS_FILE_ROOT.'/src/classes/class.company.php');

		$company = new company();
		
		if($company->accessLevel($companyId) < 3) {
			$access = false;
			$smarty->assign('redirect', true);
			$smarty->assign('redirectAction', 'action=view&amp;id='.$companyId);
			$smarty->assign('errors', array(_('You do not have the correct permissions to attach an opportunity to this company.')));
		}
	}
	
	if(isset($personId)) {
		require_once (EGS_FILE_ROOT.'/src/classes/class.person.php');

		$person = new person();
		
		if($person->accessLevel($personId) < 3) {
			$access = false;
			$smarty->assign('redirect', true);
			$smarty->assign('redirectAction', 'action=viewperson&amp;id='.$personId);
			$smarty->assign('errors', array(_('You do not have the correct permissions to attach an opportunity to this person.')));
		}
	}
	
	if ($access && !$saved) {

		/* Set up arrays to hold form elements */
		$leftForm = array ();
		$rightForm = array ();
		$bottomForm = array ();
		
		/* Set up the title */
		if (isset ($id))
			$smarty->assign('pageTitle', _('Save Changes to Opportunity'));
		else
			$smarty->assign('pageTitle', _('Save New Opportunity'));

		$smarty->assign('formDelete', true);
		
		/* Build the form */

		$hidden = array ();
		if (isset ($id))
			$hidden['id'] = $id;
		if (isset ($personid))
			$hidden['personid'] = $personid;
		if (isset ($companyid))
			$hidden['companyid'] = $companyid;

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

		/* Opportunity Type */
		$item = array ();

		$item['options'][''] = _('None');
		$item['options'][1] = _('Existing Business');
		$item['options'][2] = _('New Business');

		$item['type'] = 'select';
		$item['tag'] = _('Type');
		$item['name'] = 'opportunitytype';
		if (isset ($_POST['opportunitytype']))
			$item['value'] = $_POST['opportunitytype'];

		$leftForm[] = $item;

		/* Setup the source */
		$item = array ();

		$query = 'SELECT id, name FROM crmcompanysource WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY name';

		$sources = $db->query($query);

		$item['options'] = array ('' => _('None'));

		while (!$sources->EOF) {
			$item['options'][$sources->fields['id']] = $sources->fields['name'];
			$sources->MoveNext();
		}

		$item['type'] = 'select';
		$item['tag'] = _('Source');
		$item['name'] = 'companysourceid';
		if (isset ($_POST['companysourceid']))
			$item['value'] = $_POST['companysourceid'];

		$leftForm[] = $item;

		/* Setup the Campaign */
		$item = array ('' => _('None'));

		$query = 'SELECT id, name FROM campaign WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY name';

		$campaigns = $db->query($query);

		$item['options'] = array ('' => _('None'));

		while (!$campaigns->EOF) {
			$item['options'][$campaigns->fields['id']] = $campaigns->fields['name'];
			$campaigns->MoveNext();
		}

		$item['type'] = 'select';
		$item['tag'] = _('Campaign');
		$item['name'] = 'campaignid';
		if (isset ($_POST['campaignid']))
			$item['value'] = $_POST['campaignid'];

		$leftForm[] = $item;

		/* Setup the type */
		$item = array ();

		$query = 'SELECT id, name FROM crmopportunity WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY id';

		$type = $db->query($query);

		$item['options'] = array ('' => _('None'));

		while (!$type->EOF) {
			$item['options'][$type->fields['id']] = $type->fields['name'];
			$type->MoveNext();
		}

		$item['type'] = 'select';
		$item['tag'] = _('Status');
		$item['name'] = 'crmstatusid';
		if (isset ($_POST['crmstatusid']))
			$item['value'] = $_POST['crmstatusid'];

		$leftForm[] = $item;

		if(isset($personId)) {
				$query = 'SELECT companyid FROM person WHERE id='.$db->qstr($personId);
				
				$companyId = $db->getOne($query);	
				
				if($companyId == '') unset($companyId);
		}
		
		if (isset ($companyId)) {
			$query = 'SELECT name FROM company WHERE id='.$db->qstr($companyId);

			$_POST['companyname'] = $db->GetOne($query);
		}

		/* Setup the user it is assigned to */
		$item = array ();

		$query = 'SELECT username FROM useraccess WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY username';

		$users = $db->query($query);

		if (!$users && EGS_DEBUG_SQL)
			die($db->ErrorMsg());

		$item['options'] = array ();

		while (!$users->EOF) {
			$item['options'][$users->fields['username']] = $users->fields['username'];
			$users->MoveNext();
		}

		$item['type'] = 'select';
		$item['tag'] = _('Assigned To');
		$item['name'] = 'assigned';
		if (isset ($_POST['assigned']))
			$item['value'] = $_POST['assigned'];
		else
			$item['value'] = EGS_USERNAME;

		$leftForm[] = $item;

		/* Setup the company */
		$item = array ();
		$item['type'] = 'company';
		$item['tag'] = _('Attach to Account');
		$item['name'] = 'company';
		if (isset ($companyId))
			$item['value'] = $_POST['companyname'];
		if (isset ($companyId))
			$item['actualvalue'] = $companyId;

		$rightForm[] = $item;

		if (isset ($personId)) {
			$query = 'SELECT firstname || \' \' || surname AS name FROM person WHERE id='.$db->qstr($personId);
			
			if(isset($companyId)) $query .= ' AND companyid='.$db->qstr($companyId);

			$_POST['personname'] = $db->GetOne($query);
		}

		/* Setup the branch */
		$item = array ();
		$item['type'] = 'person';
		$item['tag'] = _('Attach to Contact');
		$item['name'] = 'person';
		if (isset ($_POST['personname']))
			$item['value'] = $_POST['personname'];
		if (isset ($personId) && isset($_POST['personname']))
			$item['actualvalue'] = $personId;

		$rightForm[] = $item;

		$item = array ();
		$item['type'] = 'date';
		$item['tag'] = _('Due Date');
		$item['name'] = 'enddate';
		$item['format'] = EGS_DATE_FORMAT;
		if (isset ($_POST['enddate'])) {
			$item['actualvalue'] = $_POST['enddate'];
			$item['value'] = date(str_replace('%', '', EGS_DATE_FORMAT), strtotime($_POST['enddate']));
		}

		$rightForm[] = $item;

		$item = array ();
		$item['type'] = 'text';
		$item['tag'] = _('Ammount');
		$item['name'] = 'cost';
		if (isset ($_POST['cost']))
			$item['value'] = $_POST['cost'];

		$rightForm[] = $item;

		/* Setup the certainty */
		$item = array ();

		$item['options'] = array ();

		for ($i = 0; $i <= 100; $i += 5) {
			$item['options'][$i] = $i.'%';
		}

		$item['type'] = 'select';
		$item['tag'] = _('Certainty');
		$item['name'] = 'probability';
		if (isset ($_POST['probability']))
			$item['value'] = $_POST['probability'];

		$rightForm[] = $item;

		$item = array ();
		$item['type'] = 'text';
		$item['tag'] = _('Next Step');
		$item['name'] = 'nextstep';
		if (isset ($_POST['nextstep']))
			$item['value'] = $_POST['nextstep'];

		$rightForm[] = $item;

		$item = array ();
		$item['type'] = 'area';
		$item['tag'] = _('Description');
		$item['name'] = 'description';
		if (isset ($_POST['description']))
			$item['value'] = $_POST['description'];

		$bottomForm[] = $item;

		/* Assign the form variable */
		$smarty->assign('form', true);
		$smarty->assign('leftForm', $leftForm);
		$smarty->assign('rightForm', $rightForm);
		$smarty->assign('bottomForm', $bottomForm);
		$smarty->assign('formId', 'saveform');
	}
} else {
	$smarty->assign('errors', array (_('You do not have the correct permissions to access this module. If you believe you should please contact your system administrator')));
	$smarty->assign('redirect',true);
	$smarty->assign('redirectAction','');
}
?>
