<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Projects 1.0                     |
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
	$id = intval($_GET['id']);
if (isset ($_POST['id']))
	$id = ($_POST['id']);

/* Check that the project is enabled, and the correct permissions are valid for the project.
 * Only project admins can add projects whilst, project admins and managers can edit
 */
if (in_array('projects', $_SESSION['modules']) && ((!isset ($id) && ($project->isAdmin())) || (isset ($id) && ($project->accessLevel($id) > 0)))) {
	/* Set up the variables for the form */
	$saved = false;
	$select = false;
	if(!isset($id)) $id = null;

	/* Do a save if the form has been posted */
	if (sizeof($_POST) > 0) {
		/* Check the post array */
		$egs->checkPost();

		/* If project admin do the delete */
		if(isset($_POST['delete']) && $project->isAdmin()) $saved = $project->deleteProject($id);
		else if(!isset($_POST['delete'])) $saved = $project->saveProject($_POST, $id);
	}

	/* Redirect to the project view if the form saved successfully */
	if ($saved) {
		$smarty->assign('redirect', true);
		if (isset($_POST['delete'])) $smarty->assign('redirectAction', 'action=overview');
		else $smarty->assign('redirectAction', 'action=view&amp;id='.$_POST['id']);
	} else {
		/* Set up arrays to hold form elements */
		$leftForm = array ();
		$rightForm = array ();
		$bottomForm = array ();

		/* We are editing the project so check access and get the data */
		if (isset ($id)) {

			/* Correct access so get the data */
			if ($project->accessLevel($id) > 0) {
				$query = 'SELECT * FROM projectoverview WHERE id='.$db->qstr($id);

				$_POST = $db->GetRow($query);

				$select = true;
				/* Incorrect access so notify and redirect to project view */
			} else {
				$smarty->assign('errors', array (_('You do not have the correct access to edit this project. If you believe you should please contact your system administrator')));
				$smarty->assign('redirect', true);
				$smarty->assign('redirectAction', 'action=view&amp;id='.$id);
			}
		} else if(isset($_GET['opportunityid'])) {
			$query = 'SELECT * FROM opportunity WHERE id='.$db->qstr($_GET['opportunityid']).' AND usercompanyid='.$db->qstr(EGS_COMPANY_ID);	
			
			$_POST = $db->GetRow($query);
		}

		/* Set up the title */
		if (isset ($id))
			$smarty->assign('pageTitle', _('Save Changes to Job'));
		else
			$smarty->assign('pageTitle', _('Save New Job'));

		/* Show the delete button if editing and project admin */
		if($project->isAdmin() && isset($id)) $smarty->assign('formDelete', true);
		
		/* Add any hidden fields we need */
		$hidden = array ();
		if (isset ($id))
			$hidden['id'] = $id;
		if (isset ($_GET['opportunityid']) && !isset($id))
			$hidden['opportunityid'] = $_GET['opportunityid'];

		$smarty->assign('hidden', $hidden);

		/* Setup the job name */
		$item = array ();
		$item['type'] = 'text';
		$item['tag'] = _('Job Name');
		$item['name'] = 'name';
		if (isset ($_POST['name']))
			$item['value'] = $_POST['name'];
		$item['compulsory'] = true;

		$leftForm[] = $item;

		/* Setup the account it is attached to */
		if (isset ($_POST['companyid'])) {
			$query = 'SELECT name AS name FROM company WHERE id='.$db->qstr($_POST['companyid']);

			$_POST['companyname'] = $db->GetOne($query);
		}

		$item = array ();
		$item['type'] = 'company';
		$item['tag'] = _('Attach to Account');
		$item['name'] = 'company';
		$item['compulsory'] = true;
		if (isset ($_POST['companyid']))
			$item['value'] = $_POST['companyname'];
		if (isset ($_POST['companyid']))
			$item['actualvalue'] = $_POST['companyid'];

		$leftForm[] = $item;

		/* Set up the contact the project is attached to */
		if (isset ($_POST['personid'])) {
			$query = 'SELECT firstname || \' \' || surname AS name FROM person WHERE id='.$db->qstr($_POST['personid']);

			$_POST['personname'] = $db->GetOne($query);
		}

		$item = array ();
		$item['type'] = 'person';
		$item['tag'] = _('Attach to Contact');
		$item['name'] = 'person';
		if (isset ($_POST['personid']))
			$item['value'] = $_POST['personname'];
		if (isset ($_POST['personid']))
			$item['actualvalue'] = $_POST['personid'];

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

		/* Setup the job categories */
		$item = array ();

		$query = 'SELECT id, name FROM jobcategories WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY name';

		$categories = $db->Execute($query);

		if (!$categories && EGS_DEBUG_SQL)
			die($db->ErrorMsg());

		$item['options'] = array ();
		$item['options'][''] = _('None');

		while (!$categories->EOF) {
			$item['options'][$categories->fields['id']] = $categories->fields['name'];

			$categories->MoveNext();
		}

		$item['type'] = 'select';
		$item['tag'] = _('Category');
		$item['name'] = 'categoryid';
		if (isset ($_POST['categoryid']))
			$item['value'] = $_POST['categoryid'];

		$rightForm[] = $item;

		/* If we are editing show the phases - there is no point for new projects as none will be set up */
		if (isset ($id)) {
			/* Setup the job phases */
			$query = 'SELECT id, name FROM phase WHERE projectid='.$db->qstr($id).' ORDER BY name';

			$phases = $db->Execute($query);

			if (!$phases && EGS_DEBUG_SQL)
				die($db->ErrorMsg());

			$item['options'] = array ();
			$item['options'][''] = _('None');

			while (!$phases->EOF) {
				$item['options'][$phases->fields['id']] = $phases->fields['name'];

				$phases->MoveNext();
			}

			$item['type'] = 'select';
			$item['tag'] = _('Phase');
			$item['name'] = 'phaseid';
			if (isset ($_POST['phaseid']))
				$item['value'] = $_POST['phaseid'];

			$rightForm[] = $item;
		}

		/* Setup the cost */
		$item = array ();
		$item['type'] = 'text';
		$item['tag'] = _('Cost');
		$item['name'] = 'cost';
		if (isset ($_POST['cost']))
			$item['value'] = $_POST['cost'];

		$rightForm[] = $item;

		/* Setup the url */
		$item = array ();
		$item['type'] = 'text';
		$item['tag'] = _('Website');
		$item['name'] = 'url';
		if (isset ($_POST['url']))
			$item['value'] = $_POST['url'];

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
	}
} else {
	$smarty->assign('redirect', true);
	if(isset($id)) $smarty->assign('redirectAction', 'action=view&amp;id='.$id);
	else $smarty->assign('redirectAction', 'action=overview');
	$smarty->assign('errors', array (_('You do not have the correct permissions to save a project. If you beleive you should please contact your system administrator.')));
}
?>
