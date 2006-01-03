<?php
// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Save Categories 1.0              |
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
/* Set up the variables for the form */
$saved = false;
$select = false;
$id = null;

/* Set the domain id if set */
if (isset ($_GET['domainid']))
	$domainId = intval($_GET['domainid']);
if (isset ($_POST['domainid']))
	$domainId = ($_POST['domainid']);

if (isset ($_GET['categoryid']))
	$id = intval($_GET['categoryid']);
if (isset ($_POST['id']))
	$id = ($_POST['id']);

/* Do a save/delete if the form has been posted */
if (sizeof($_POST) > 0) {
	/* Check the post array */
	$egs->checkPost();

	/* Initiate an instance of a domain for the save */
	require_once (EGS_FILE_ROOT.'/src/classes/class.domain.php');

	$domain = new domain();

	/* If the delete flag is set then delete */
	if (isset ($_POST['delete']))
		$saved = $domain->deletePortfolioCategory($_POST['id'], $_POST['domainid']);
	/* Just do a save */
	else
		$saved = $domain->savePortfolioCategory($_POST, $id);
}

/* Redirect to the domain view if the form saved successfully */
if ($saved) {
	$smarty->assign('redirect', true);
	$smarty->assign('redirectAction', 'action=view&amp;id='.$_POST['domainid']);
/* The save has failed or we are doing an add/edit */
} else {
	/* Set up arrays to hold form elements */
	$leftForm = array ();
	$rightForm = array ();

	/* We are editing the domain so check access and get the data */
	if (isset ($id)) {
		/* Initiate a domain instance so we can do the checks */
		require_once (EGS_FILE_ROOT.'/src/classes/class.domain.php');

		$domain = new domain();

		/* Correct access so get the data */
		if (isset ($id) && ($domain->accessLevel($domainId) > 0)) {
			$query = 'SELECT * FROM portfoliocategory WHERE id='.$db->qstr($id).' AND domainid='.$db->qstr($domainId);

			$_POST = $db->GetRow($query);

			$select = true;
			/* Incorrect access so notify and redirect to domain view */
		} else {
			$smarty->assign('errors', array (_('You do not have the correct access to edit this portfolio category. If you believe you should please contact your system administrator')));
			$smarty->assign('redirect', true);
			$smarty->assign('redirectAction', 'action=view&amp;id='.$id);
		}
	}

	/* Set up the title */
	if (isset ($id))
		$smarty->assign('pageTitle', _('Save Changes to Portfolio Category'));
	else
		$smarty->assign('pageTitle', _('Save New Portfolio Category'));

	/* Add any hidden fields we need */
	$hidden = array ();
	if (isset ($id))
		$hidden['id'] = $id;
	if (isset ($domainId))
		$hidden['domainid'] = $domainId;

	$smarty->assign('hidden', $hidden);

	/* Setup the name */
	$item = array ();
	$item['type'] = 'text';
	$item['tag'] = _('Category Name');
	$item['name'] = 'name';
	if (isset ($_POST['name']))
		$item['value'] = $_POST['name'];
	$item['compulsory'] = true;

	$leftForm[] = $item;

	/* Setup the parent Page */
	$item = array ();

	$query = 'SELECT id, name FROM portfoliocategory WHERE domainid='.$db->qstr($domainId).' AND id<>'.intval($db->qstr($id)).' ORDER BY name';

	$parentCategory = $db->Execute($query);

	if (!$parentCategory && EGS_DEBUG_SQL)
		die($db->ErrorMsg());

	$item['options'] = array ();
	$item['options'][''] = _('None');

	/* Get the parent pages from the database */
	while (($parentCategory !== false) && !$parentCategory->EOF) {
		$item['options'][$parentCategory->fields['id']] = $parentCategory->fields['name'];

		$parentCategory->MoveNext();
	}

	/* Send the data to the select in the template */
	$item['type'] = 'select';
	$item['tag'] = _('Parent Category');
	$item['name'] = 'parentcategoryid';
	if (isset ($_POST['parentcategoryid']))
		$item['value'] = $_POST['parentcategoryid'];

	$rightForm[] = $item;

	/* Assign the form variable */
	$smarty->assign('form', true);
	$smarty->assign('leftForm', $leftForm);
	$smarty->assign('rightForm', $rightForm);
	$smarty->assign('formId', 'saveform');
}
?>