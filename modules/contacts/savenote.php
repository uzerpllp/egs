<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Save Note 1.0                    |
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
if (isset ($_SESSION['modules']) && (in_array('contacts', $_SESSION['modules']))) {
	$saved = false;
	$deleted = false;
	$select = false;
	$id = null;

	/* Set the id if set */
	if (isset ($_GET['companyid']))
		$companyId = intval($_GET['companyid']);
	if (isset ($_POST['companyid']))
		$companyId = ($_POST['companyid']);
	if (isset ($_GET['personid']))
		$personId = intval($_GET['personid']);
	if (isset ($_POST['personid']))
		$personId = ($_POST['personid']);
	if (isset ($_GET['noteid']))
		$noteId = intval($_GET['noteid']);
	if (isset ($_POST['noteid']))
		$noteId = ($_POST['noteid']);
	if (isset ($_GET['opportunityid']))
		$opportunityId = intval($_GET['opportunityid']);
	if (isset ($_POST['opportunityid']))
		$opportunityId = ($_POST['opportunityid']);
	if (isset ($_GET['caseid']))
		$caseId = intval($_GET['caseid']);
	if (isset ($_POST['caseid']))
		$caseId = ($_POST['caseid']);

	/* Do a save if the form has been posted */
	if (sizeof($_POST) > 0) {
		/* Check the post array */
		$egs->checkPost();

		require_once (EGS_FILE_ROOT.'/src/classes/class.notes.php');

		$note = new note();

		if (isset ($_POST['delete']))
			$deleted = $note->deleteNote($_POST);
		else
			if (isset ($noteId))
				$saved = $note->savenote($_POST, $noteId);
			else
				$saved = $note->savenote($_POST, null);
	}

	if (isset ($opportunityId))
		$type = 'opportunity';
	else
		if (isset ($caseId))
			$type = 'case';
		else
			$type = '';

	if ($saved) {
		$smarty->assign('redirect', true);
		if ($type != '')
			$smarty->assign('redirectAction', 'action=view'.$type.'&amp;id='.$_POST[$type.'id']);
		else if(isset($_POST['companyid']))
			$smarty->assign('redirectAction', 'action=view&amp;id='.$_POST['companyid']);
		else if(isset($_POST['personid']))
			$smarty->assign('redirectAction', 'action=viewperson&amp;id='.$_POST['personid']);
	} else
		if ($deleted) {
			$smarty->assign('redirect', true);
			if ($type != '')
				$smarty->assign('redirectAction', 'action=view'.$type.'&amp;id='.$_POST[$type.'id']);
			else if(isset($_POST['personid']))
				$smarty->assign('redirectAction', 'action=viewperson&amp;id='.$_POST['personid']);
			else
				$smarty->assign('redirectAction', 'action=view&amp;id='.$_POST['companyid']);
		} else {
			/* Set up arrays to hold form elements */
			$bottomForm = array ();

			if (isset ($companyId)) {
				require_once (EGS_FILE_ROOT.'/src/classes/class.company.php');

				$company = new company();
			}

			if (isset ($noteId)) {
				require_once (EGS_FILE_ROOT.'/src/classes/class.notes.php');

				$note = new note();

				require_once (EGS_FILE_ROOT.'/src/classes/class.person.php');

				$person = new person();

				if (isset ($companyId) && ($company->accessLevel($companyId) > 2) && (sizeof($_POST) == 0)) {
					$query = 'SELECT id, note AS description FROM companynotes WHERE id='.$db->qstr($noteId).' AND companyid='.$db->qstr($companyId).' AND ownercompanyid='.$db->qstr(EGS_COMPANY_ID);

					$_POST = $db->GetRow($query);

					$select = true;
				} else if (isset ($personId) && ($person->accessLevel($personId) > 2) && (sizeof($_POST) == 0)) {
					$query = 'SELECT id, note AS description FROM personnotes WHERE id='.$db->qstr($noteId).' AND personid='.$db->qstr($personId).' AND ownercompanyid='.$db->qstr(EGS_COMPANY_ID);

					$_POST = $db->GetRow($query);

					$select = true;
				} else
					if (isset ($opportunityId) || isset ($caseId)) {
						require_once (EGS_FILE_ROOT.'/src/classes/class.crm.php');

						$crm = new crm();

						if (isset ($opportunityId)) {

							/* Correct access level to add */
							if ($crm->opportunityAccess($opportunityId) > 1) {
								$query = 'SELECT id, note AS description FROM crmnotes WHERE id='.$db->qstr($noteId).' AND opportunityid='.$db->qstr($opportunityId);

								$_POST = $db->GetRow($query);

								$select = true;
							} else {
								$smarty->assign('errors', array (_('You do not have the correct access to edit this note. If you beleive you should please contact your system administrator')));
								$smarty->assign('redirect', true);
								$smarty->assign('redirectAction', 'action=viewopportunity&amp;id='.$opportunityId);

								return false;
							}
						} else
							if (isset ($caseId)) {
								/* Correct access level to add */
								if ($crm->caseAccess($caseId) > 1) {
									$query = 'SELECT id, note AS description FROM crmnotes WHERE id='.$db->qstr($noteId).' AND caseid='.$db->qstr($caseId);

									$_POST = $db->GetRow($query);

									$select = true;
								} else {
									$smarty->assign('errors', array (_('You do not have the correct access to edit this note. If you beleive you should please contact your system administrator')));
									$smarty->assign('redirect', true);
									$smarty->assign('redirectAction', 'action=viewcase&amp;id='.$caseId);

									return false;
								}
							}
					} else if(isset($personId)) {
						$smarty->assign('errors', array (_('You do not have the correct access to add a note to this person. If you beleive you should please contact your system administrator')));
						$smarty->assign('redirect', true);
						$smarty->assign('redirectAction', 'action=viewperson&amp;id='.$personId);

						return false;
					} else {
						$smarty->assign('errors', array (_('You do not have the correct access to add a note to this company. If you beleive you should please contact your system administrator')));
						$smarty->assign('redirect', true);
						$smarty->assign('redirectAction', 'action=view&amp;id='.$companyId);

						return false;
					}
			} else if(isset($opportunityId)) {
				require_once (EGS_FILE_ROOT.'/src/classes/class.crm.php');
						$crm = new crm();

							/* Correct access level to add */
							if ($crm->opportunityAccess($opportunityId) < 2) {
								
								$smarty->assign('errors', array (_('You do not have the correct access to add a note to this opportunity. If you beleive you should please contact your system administrator')));
						$smarty->assign('redirect', true);
						$smarty->assign('redirectAction', 'action=viewopportunity&amp;id='.$opportunityId);

						return false;
							}
			} else if(isset($caseId)) {
				require_once (EGS_FILE_ROOT.'/src/classes/class.crm.php');
						$crm = new crm();

							/* Correct access level to add */
							if ($crm->caseAccess($caseId) < 2) {
								
								$smarty->assign('errors', array (_('You do not have the correct access to add a note to this case. If you beleive you should please contact your system administrator')));
						$smarty->assign('redirect', true);
						$smarty->assign('redirectAction', 'action=viewcase&amp;id='.$caseId);

						return false;
							}
			}

			/* Set up the title */
			if (isset ($noteId))
				$smarty->assign('pageTitle', _('Save Changes to Note'));
			else
				$smarty->assign('pageTitle', _('Save New Note'));

			/* Build the form */

			$hidden = array ();
			if (isset ($companyId))
				$hidden['companyid'] = $companyId;
			if (isset ($personId))
				$hidden['personid'] = $personId;
			if (isset ($noteId))
				$hidden['noteid'] = $noteId;
			if (isset ($opportunityId))
				$hidden['opportunityid'] = $opportunityId;
			if (isset ($caseId))
				$hidden['caseid'] = $caseId;

			$smarty->assign('hidden', $hidden);

			if(isset($noteId))$smarty->assign('formDelete', true);

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
			$smarty->assign('bottomForm', $bottomForm);
			$smarty->assign('formId', 'saveform');
		}
} else {
	$smarty->assign('errors', array (_('You do not have the correct permissions to access this module. If you believe you should please contact your system administrator')));
}
?>