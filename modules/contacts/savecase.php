<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Save Case 1.0                    |
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
	if (isset ($_GET['caseid']))
		$id = intval($_GET['cased']);
	if (isset ($_POST['caseid']))
		$id = ($_POST['case�id']);
	if (isset ($_GET['id']))
		$id = intval($_GET['id']);
	if (isset ($_POST['id']))
		$id = ($_POST['id']);
	if (isset ($_GET['companyid']))
		$companyId = intval($_GET['companyid']);
	if (isset ($_POST['companyid']) && ($_POST['companyid'] != ''))
		$companyId = intval($_POST['companyid']);
	if (isset ($_GET['personid']))
		$personId = intval($_GET['personid']);
	if (isset ($_POST['personid']))
		$personId = intval($_POST['personid']);

	if (isset ($companyId)) {
		require_once (EGS_FILE_ROOT.'/src/classes/class.company.php');

		$company = new company();

		if ($company->accessLevel($companyId) < 3) {
			$smarty->assign('errors', array (_('You do not have the correct permissions to attach a case to this company. If you beleive you should please contact your system administrator.')));
			$smarty->assign('redirect', true);
			$smarty->assign('redirectAction', 'action=view&amp;id='.$companyId);

			$access = false;
			
			return false;
		}
	}
	/* Do a save if the form has been posted */
	if (sizeof($_POST) > 0) {
		/* Check the post array */
		$egs->checkPost();

		require_once (EGS_FILE_ROOT.'/src/classes/class.crm.php');

		$crm = new crm();

		if(isset($_POST['delete'])) $saved = $crm->deleteCase($_POST['id']);
		else $saved = $crm->saveCase($_POST, $id);
	}

	if ($saved) {
		$smarty->assign('redirect', true);
		if(!isset($_POST['delete'])) $smarty->assign('redirectAction', 'action=viewcase&amp;id='.$saved);
	} else { 
		if (isset ($id)) {
			require_once (EGS_FILE_ROOT.'/src/classes/class.crm.php');

			$crm = new crm();

			$query = 'SELECT * FROM crmcaseoverview WHERE id='.$db->qstr($id);

			$_POST = $db->GetRow($query);

			if (isset ($_POST['companyid']))
				$companyId = intval($_POST['companyid']);
			if (isset ($_POST['personid']))
				$personId = intval($_POST['personid']);

			if($crm->caseAccess($_POST['id']) < 2) $access = false;
		}

		if (!$saved && $access) {

			/* Set up arrays to hold form elements */
			$leftForm = array ();
			$rightForm = array ();
			$bottomForm = array ();
			
			/* Set up the title */
			if (isset ($id))
				$smarty->assign('pageTitle', _('Save Changes to Case'));
			else
				$smarty->assign('pageTitle', _('Save New Case'));
				
			if(isset($id)) $smarty->assign('formDelete', true);

			/* Build the form */

			$hidden = array ();
			if (isset ($id))
				$hidden['id'] = $id;
			if (isset ($personid))
				$hidden['personid'] = $personid;
			if (isset ($companyid))
				$hidden['companyid'] = $companyid;

			$smarty->assign('hidden', $hidden);

			/* Set the title */
			$item = array ();
			$item['type'] = 'title';
			$item['tag'] = _('Case Details');

			$leftForm[] = $item;

			/* Set the title */
			$item = array ();
			$item['type'] = 'title';
			$item['tag'] = '';
			$rightForm[] = $item;

			/* Case type */
			$item = array ();

			$query = 'SELECT id, name FROM crmcasetype WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY name';

			$type = $db->Execute($query);

			$item['options'] = array ('' => _('None'));

			while (!$type->EOF) {
				$item['options'][$type->fields['id']] = $type->fields['name'];
				$type->MoveNext();
			}

			$item['type'] = 'select';
			$item['tag'] = _('Status');
			$item['name'] = 'casetypeid';
			if (isset ($_POST['casetypeid']))
				$item['value'] = $_POST['casetypeid'];

			$leftForm[] = $item;

			/* Setup the status */
			$item = array ();

			$query = 'SELECT id, name FROM crmcasestatus WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY id';

			$type = $db->Execute($query);

			$item['options'] = array ('' => _('None'));

			while (!$type->EOF) {
				$item['options'][$type->fields['id']] = $type->fields['name'];
				$type->MoveNext();
			}

			$item['type'] = 'select';
			$item['tag'] = _('Type');
			$item['name'] = 'casestatusid';
			if (isset ($_POST['casestatusid']))
				$item['value'] = $_POST['casestatusid'];

			$leftForm[] = $item;

			if (isset ($companyId)) {
				$query = 'SELECT name FROM company WHERE id='.$db->qstr($companyId);

				$_POST['companyname'] = $db->GetOne($query);
			}

			/* Status */
			$item = array ();

			$query = 'SELECT id, name FROM crmcasepriority WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY id';

			$priority = $db->query($query);

			if (!$priority && EGS_DEBUG_SQL)
				die($db->ErrorMsg());

			$item['options'] = array ('' => _('None'));

			while (!$priority->EOF) {
				$item['options'][$priority->fields['id']] = $priority->fields['name'];
				$priority->MoveNext();
			}

			$item['type'] = 'select';
			$item['tag'] = _('Priority');
			$item['name'] = 'casepriorityid';
			if (isset ($_POST['casepriorityid']))
				$item['value'] = $_POST['casepriorityid'];

			$leftForm[] = $item;

			$item = array ();
			$item['type'] = 'date';
			$item['tag'] = _('Due Date');
			$item['name'] = 'enddate';
			$item['format'] = EGS_DATE_FORMAT;
			if (isset ($_POST['enddate'])) {
				$item['actualvalue'] = $_POST['enddate'];
				$item['value'] = date(str_replace('%', '', EGS_DATE_FORMAT), mktime($_POST['enddate']));
			}

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
			if (isset ($personId))
				$item['actualvalue'] = $personId;

			$rightForm[] = $item;

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
			$item['tag'] = _('Assigned to');
			$item['name'] = 'assigned';
			if (isset ($_POST['assigned']))
				$item['value'] = $_POST['assigned'];

			$rightForm[] = $item;

			$item = array ();
			$item['type'] = 'smallarea';
			$item['tag'] = _('Subject');
			$item['name'] = 'name';
			if (isset ($_POST['name']))
				$item['value'] = $_POST['name'];
			$item['compulsory'] = true;

			$bottomForm[] = $item;

			$item = array ();
			$item['type'] = 'area';
			$item['tag'] = _('Description');
			$item['name'] = 'description';
			if (isset ($_POST['description']))
				$item['value'] = $_POST['description'];

			$bottomForm[] = $item;

			$item = array ();
			$item['type'] = 'mediumarea';
			$item['tag'] = _('Resolution');
			$item['name'] = 'resolution';
			if (isset ($_POST['resolution']))
				$item['value'] = $_POST['resolution'];

			$bottomForm[] = $item;

			/* Assign the form variable */
			$smarty->assign('form', true);
			$smarty->assign('leftForm', $leftForm);
			$smarty->assign('rightForm', $rightForm);
			$smarty->assign('bottomForm', $bottomForm);
			$smarty->assign('formId', 'saveform');
		}else
	if (!$saved) {
		$smarty->assign('errors', array (_('You do not have the correct access to edit this case. If you beleive you should please contact your system administrator')));
		$smarty->assign('redirect', true);
		if (isset ($companyId))
			$smarty->assign('redirectAction', 'action=view&amp;id='.$companyId);
	}
	}
}  else {
		$smarty->assign('errors', array (_('You do not have the correct permissions to access this module. If you believe you should please contact your system administrator')));
		$smarty->assign('redirect',true);
		$smarty->assign('redirectAction','');
	}
?>
