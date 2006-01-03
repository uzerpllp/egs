<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Save Activity 1.0                |
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
if (in_array('crm', $_SESSION['modules']) && in_array('contacts', $_SESSION['modules'])) {
	/* This is set to try if the company was saved */
	$saved = false;
	$access = true;
	$id = null;

	/* Set the id if set */
	if (isset ($_GET['id']))
		$id = intval($_GET['id']);
	if (isset ($_POST['id']))
		$id = ($_POST['id']);
	if (isset ($_GET['companyid']))
		$companyId = intval($_GET['companyid']);
	if (isset ($_POST['companyid']))
		$companyId = intval($_POST['companyid']);
	if (isset ($_GET['personid']))
		$personId = intval($_GET['personid']);
	if (isset ($_POST['personid']))
		$personId = intval($_POST['personid']);

	/* Do a save if the form has been posted */
	if (sizeof($_POST) > 0) {
		/* Check the post array */
		$egs->checkPost();

		require_once (EGS_FILE_ROOT.'/src/classes/class.crm.php');

		$crm = new crm();

		if(isset($_POST['delete'])) $saved = $crm->deleteActivity($_POST['id']);
		else $saved = $crm->saveActivity($_POST, $id);
	} else
		if (isset ($_GET['companyid']))
			$_POST['companyid'] = $_GET['companyid'];

	if ($saved) {
		$smarty->assign('redirect', true);
		if(!isset($_POST['delete'])) $smarty->assign('redirectAction', 'action=viewactivity&amp;id='.$_POST['id']);
	} else {
		/* Set up arrays to hold form elements */
		$leftForm = array ();
		$rightForm = array ();
		$bottomForm = array ();

		require_once (EGS_FILE_ROOT.'/src/classes/class.crm.php');

		$crm = new crm();
			
		if (isset ($id)) {
			$query = 'SELECT * FROM activityoverview WHERE id='.$db->qstr($id);

				$_POST = $db->GetRow($query);
				
			if (($crm->activityAccess($id) < 2) && (sizeof($_POST) == 0)) {
				$access = false;
				$smarty->assign('redirect', true);
				$smarty->assign('redirectAction', 'action=viewopportunity&amp;id='.$id);
				$smarty->assign('errors', array(_('You do not have the correct permissions to attach an opportunity to this company.')));
			} else if($_POST['companyid'] != '') $companyId = $_POST['companyid'];
		}
		
		if (isset ($_POST['opportunityid']) || isset ($_GET['opportunityid'])) {
			if (isset ($_POST['opportunityid']))
				$opportunityId = $_POST['opportunityid'];
			else
				$opportunityId = $_GET['opportunityid'];

			$query = 'SELECT id, name, personid, companyid FROM opportunity WHERE id='.$db->qstr($opportunityId);

			$opportunity = $db->GetRow($query);

			$_POST['itemid'] = $opportunity['id'];
			$_POST['itemname'] = $opportunity['name'];
			$_POST['itemtype'] = 'opportunity';
			$_POST['companyid'] = $opportunity['companyid'];
			$companyId = $opportunity['companyid'];
			$_POST['personid'] = $opportunity['personid'];
			$personId = $opportunity['personid'];
			$hidden['itemtype'] = 'opportunity';
			if(isset($_GET['opportunityid'])) $hidden['itemid'] = $_GET['opportunityid'];
			if(isset($_POST['opportunityid'])) $hidden['itemid'] = $_POST['opportunityid'];

			if($crm->opportunityAccess($opportunityId) < 2) {
				$access = false;
				$smarty->assign('redirect', true);
				$smarty->assign('redirectAction', 'action=viewopportunity&amp;id='.$id);
				$smarty->assign('errors', array(_('You do not have the correct permissions to attach an opportunity to this company.')));
			}
		}
		
		if (isset ($_GET['companyid'])) {
			$companyId = $_GET['companyid'];

			$select = false;

					require_once (EGS_FILE_ROOT.'/src/classes/class.company.php');
					$company = new company();

					$companyAccess = $company->accessLevel($companyId);

					if ($companyAccess < 3)
						$access = false;
		}

		if (isset ($_POST['caseid']) || isset ($_GET['caseid'])) {
			if (isset ($_POST['caseid']))
				$caseId = $_POST['caseid'];
			else
				$caseId = $_GET['caseid'];

			$query = 'SELECT id, name, personid, companyid FROM crmcase WHERE id='.$db->qstr($caseId);

			$case = $db->GetRow($query);

			$_POST['itemid'] = $case['id'];
			$_POST['itemname'] = $case['name'];
			$_POST['itemtype'] = 'case';
			$_POST['companyid'] = $case['companyid'];
			$_POST['personid'] = $case['personid'];
			$personId = $case['personid'];
			$companyId = $case['companyid'];
			$hidden['itemtype'] = 'case';
			$hidden['itemid'] = $_GET['id'];


			if($crm->caseAccess($caseId) < 2) {
				$access = false;
				$smarty->assign('redirect', true);
				$smarty->assign('redirectAction', 'action=viewcase&amp;id='.$caseId);
				$smarty->assign('errors', array(_('You do not have the correct permissions to attach a case to this company.')));
			}
		}

		if ($access && !$saved) {
			/* Set up the title */
			if (isset ($id))
				$smarty->assign('pageTitle', _('Save Changes to Activity'));
			else
				$smarty->assign('pageTitle', _('Save New Activity'));
				
			$smarty->assign('formDelete', true);

			/* Build the form */

			if (!isset ($hidden))
				$hidden = array ();
			if (isset ($id))
				$hidden['id'] = $id;
			if (isset ($caseId) && isset ($companyId)) {
				$hidden['companyid'] = $companyId;
				$_POST['companyid'] = $companyId;
			}
			if (isset ($opportunityId) && isset ($companyId)) {
				$hidden['companyid'] = $companyId;
				$_POST['companyid'] = $companyId;
			}

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

			/* Setup the type */
			$item = array ();

			$query = 'SELECT id, name FROM crmactivity WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY id';

			$type = $db->query($query);

			$item['options'] = array ('' => _('None'));

			while (!$type->EOF) {
				$item['options'][$type->fields['id']] = _($type->fields['name']);
				$type->MoveNext();
			}

			$item['type'] = 'select';
			$item['tag'] = _('Type');
			$item['name'] = 'crmactivityid';
			if (isset ($_POST['crmactivityid']))
				$item['value'] = $_POST['crmactivityid'];

			$leftForm[] = $item;

			/* Setup the date fields */
			$item = array ();
			$item['type'] = 'date';
			$item['tag'] = _('Start Date');
			$item['name'] = 'startdate';
			$item['format'] = EGS_DATE_FORMAT;
			if (isset ($_POST['startdate'])) {
				$item['actualvalue'] = $_POST['startdate'];
				$item['value'] = date(str_replace('%', '', EGS_DATE_FORMAT), strtotime($_POST['startdate']));
			}

			$leftForm[] = $item;

			$item = array ();
			$item['type'] = 'date';
			$item['tag'] = _('End Date');
			$item['name'] = 'enddate';
			$item['format'] = EGS_DATE_FORMAT;
			if (isset ($_POST['enddate'])) {
				$item['actualvalue'] = $_POST['enddate'];
				$item['value'] = date(str_replace('%', '', EGS_DATE_FORMAT), strtotime($_POST['enddate']));
			}

			$leftForm[] = $item;
			
			$item = array ();
			$item['type'] = 'date';
			$item['tag'] = _('Completed');
			$item['name'] = 'completed';
			$item['format'] = EGS_DATE_FORMAT;
			if (isset ($_POST['completed'])) {
				$item['actualvalue'] = $_POST['completed'];
				$item['value'] = date(str_replace('%', '', EGS_DATE_FORMAT), strtotime($_POST['completed']));
			}

			$leftForm[] = $item;

			$item = array ();
			$item['type'] = 'text';
			$item['tag'] = _('Duration');
			$item['name'] = 'duration';
			if (isset ($_POST['duration']))
				$item['value'] = $_POST['duration'];

			$leftForm[] = $item;

			if (!isset ($opportunityId) && !isset ($caseId)) {
				if(isset($personId)) {
					$query = 'SELECT companyid FROM person WHERE id='.$db->qstr($personId);
					
					$companyId = $db->getOne($query);	
					
					if($companyId == '') unset($companyId);
				}
				
				if (isset ($companyId)) {
					$query = 'SELECT name FROM company WHERE id='.$db->qstr($companyId);
		
					$_POST['companyname'] = $db->GetOne($query);
				}

				$item = array ();
				$item['type'] = 'company';
				$item['tag'] = _('Attach to company');
				$item['name'] = 'company';
				if (isset ($_POST['companyname']))
					$item['value'] = $_POST['companyname'];
				if (isset ($companyId))
					$item['actualvalue'] = $companyId;

				$rightForm[] = $item;
			}

			if (isset ($personId)) {
				$query = 'SELECT firstname || \' \' || surname AS name FROM person WHERE id='.$db->qstr($personId);
				
				if(isset($companyId)) $query .= ' AND companyid='.$db->qstr($companyId);
	
				$_POST['personname'] = $db->GetOne($query);
			}

			$item = array ();
			$item['type'] = 'person';
			$item['tag'] = _('Attach to person');
			$item['name'] = 'person';
			if (isset ($_POST['personname']))
				$item['value'] = $_POST['personname'];
			if (isset ($personId) && isset($_POST['personname']))
				$item['actualvalue'] = $personId;

			$rightForm[] = $item;

			if (!isset ($_GET['opportunityid'])) {
				$item = array ();
				$item['type'] = 'item';
				$item['tag'] = _('Attach to item');
				$item['name'] = 'item';
				$item['items'] = array ('opportunity' => _('Opportunity'), 'case' => _('Case'));
				if (isset ($_POST['itemname']))
					$item['value'] = $_POST['itemname'];
				if (isset ($_POST['itemid']))
					$item['actualvalue'] = $_POST['itemid'];
				if (isset ($_POST['itemtype']))
					$item['itemtype'] = $_POST['itemtype'];

				$rightForm[] = $item;
			}

			$item = array ();
			$item['type'] = 'space';

			$rightForm[] = $item;

			/* Setup the type */
			$item = array ();

			$query = 'SELECT username FROM useraccess WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY username';

			$type = $db->query($query);

			$item['options'] = array ();

			while (!$type->EOF) {
				$item['options'][$type->fields['username']] = _($type->fields['username']);
				$type->MoveNext();
			}

			$item['type'] = 'select';
			$item['tag'] = _('Assigned To');
			$item['name'] = 'owner';
			if (isset ($_POST['owner']))
				$item['value'] = $_POST['owner'];
			else
				$item['value'] = EGS_USERNAME;

			$rightForm[] = $item;

			/* Setup the descrption */
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
		} else {
			if (isset ($caseId))
				$smarty->assign('errors', array (_('You do not have the correct permissions to attach an activity to this case. Please try again later. If the problem persists please contact your system administrator')));
			else
				if (isset ($opportunityId))
					$smarty->assign('errors', array (_('You do not have the correct permissions to attach an activity to this opportunity. Please try again later. If the problem persists please contact your system administrator')));
			else
				if (isset ($companyId))
					$smarty->assign('errors', array (_('You do not have the correct permissions to attach an activity to this company. Please try again later. If the problem persists please contact your system administrator')));
			$smarty->assign('redirect', true);
			if (isset ($caseId))
				$smarty->assign('redirectAction', 'action=viewcase&amp;id='.$caseId);
			else
				if (isset ($opportunityId))
					$smarty->assign('redirectAction', 'action=viewopportunity&amp;id='.$opportunityId);
		}

	}
} else {
	$smarty->assign('errors', array (_('You are trying to access a module to which you do not have access, if you beleive you should please contact your system administrator')));
	$smarty->assign('redirect',true);
	$smarty->assign('redirectAction','');	
}
?>