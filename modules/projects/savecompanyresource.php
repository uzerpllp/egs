<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Save Company Resource 1.0        |
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

/* This is set to try if the company was saved */
$saved = false;
$select = false;
$id = null;

/* Set the id if set */
if (isset ($_GET['projectid']))
	$projectId = intval($_GET['projectid']);
if (isset ($_POST['projectid']))
	$projectId = ($_POST['projectid']);
if (isset ($_GET['id']))
	$id = intval($_GET['id']);
if (isset ($_POST['id']))
	$id = ($_POST['id']);
if (isset ($_POST['companyid']))
	$companyId = ($_POST['companyid']);

if (in_array('projects', $_SESSION['modules']) && ((isset ($projectId) && ($project->accessLevel($projectId) > 0)))) {
	/* Do a save if the form has been posted */
	if (sizeof($_POST) > 0) {
		/* Check the post array */
		$egs->checkPost();

		if (isset ($_POST['delete']))
			$saved = $project->deleteResource($id, $projectId);
		else
			$saved = $project->saveResource($_POST, $id);
	}

	if ($saved) {
		$smarty->assign('redirect', true);
		$smarty->assign('redirectAction', 'action=view&amp;id='.$_POST['projectid']);
	} else {
		/* Set up arrays to hold form elements */
		$leftForm = array ();
		$rightForm = array ();

		if (isset ($id)) {
			if (($project->accessLevel($projectId) > 0) && (sizeof($_POST) == 0)) {

				/* Add the delete button if necessary */
				if ($project->accessLevel($projectId) > 0)
					$smarty->assign('formDelete', true);

				$query = 'SELECT * FROM resource WHERE projectid='.$db->qstr($projectId).' AND id='.$db->qstr($id);

				$_POST = $db->GetRow($query);

				$select = true;
			} else {
				$smarty->assign('error', array (_('You do not have the correct access to edit this resource. If you believe you should please contact your system administrator')));
				$smarty->assign('redirect', true);
				$smarty->assign('redirectAction', '');
			}
		}

		$hidden = array ();
		if (isset ($id))
			$hidden['id'] = $id;
		if (isset ($projectId))
			$hidden['projectid'] = $projectId;

		$smarty->assign('hidden', $hidden);

		/* Set up the title */
		if (isset ($id))
			$smarty->assign('pageTitle', _('Save Changes to Company Resource'));
		else
			$smarty->assign('pageTitle', _('Save New Company Resource'));

		/* Build the form */

		if (isset ($_POST['companyid'])) {
			$query = 'SELECT name FROM company WHERE id='.$db->qstr($_POST['companyid']);

			$_POST['companyname'] = $db->GetOne($query);
		}

		$item = array ();
		$item['type'] = 'company';
		$item['tag'] = _('Company');
		$item['name'] = 'company';
		$item['hide'] = 'person';
		if (isset ($_POST['companyid']))
			$item['value'] = $_POST['companyname'];
		if (isset ($_POST['companyid']))
			$item['actualvalue'] = $_POST['companyid'];

		$leftForm[] = $item;

		$item = array ();
		$item['type'] = 'space';

		$leftForm[] = $item;

		$item = array ();
		$item['type'] = 'text';
		$item['maxlength'] = '9';
		$item['tag'] = _('Quantity');
		$item['name'] = 'quantity';
		if (isset ($_POST['quantity']))
			$item['value'] = $_POST['quantity'];

		$rightForm[] = $item;

		$item = array ();
		$item['type'] = 'text';
		$item['maxlength'] = '9';
		$item['tag'] = _('Cost');
		$item['name'] = 'cost';
		if (isset ($_POST['cost']))
			$item['value'] = $_POST['cost'];

		$rightForm[] = $item;

		/* Assign the form variable */
		$smarty->assign('form', true);
		$smarty->assign('leftForm', $leftForm);
		$smarty->assign('rightForm', $rightForm);
		$smarty->assign('formId', 'saveform');
	}
} else {
	$smarty->assign('redirect', true);
	$smarty->assign('redirectAction', 'action=view&amp;id='.$projectId);
	$smarty->assign('errors', array (_('You do not have the correct permissions to edit the project resources. If you beleive you should please contact your system administrator.')));
}
?>

