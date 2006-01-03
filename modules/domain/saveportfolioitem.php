<?php
// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Save Portfolio Item 1.0          |
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
/* Check we can access this module */
if (in_array('domain', $_SESSION['modules'])) {
	/* Set up the variables for the form */
	$saved = false;
	$select = false;
	$id = null;

	/* Set the ids if set */
	if (isset ($_GET['domainid']))
		$domainId = intval($_GET['domainid']);
	if (isset ($_POST['domainid']))
		$domainId = ($_POST['domainid']);
	if (isset ($_GET['portfolioitemid']))
		$id = intval($_GET['portfolioitemid']);
	if (isset ($_POST['id']))
		$id = ($_POST['id']);

	/* Do a save if the form has been posted */
	if (sizeof($_POST) > 0) {
		/* Check the post array */
		$egs->checkPost();

		/* Initiate an instance of the domain class for a save */
		require_once (EGS_FILE_ROOT.'/src/classes/class.domain.php');

		$domain = new domain();

		/* if the delete flag is set then do a delete */
		if (isset ($_POST['delete']))
			$saved = $domain->deletePortfolioItem($_POST['id'], $_POST['domainid']);
		/* Else we need to do a save */
		else
			$saved = $domain->savePortfolioItem($_POST, $id);
	}

	/* Redirect to the domain view if the form saved successfully */
	if ($saved) {
		$smarty->assign('redirect', true);
		$smarty->assign('redirectAction', 'action=viewportfolioitem&amp;domainid='.$_POST['domainid'].'&amp;portfolioitemid='.$_POST['id']);
	} else {
		/* Set up arrays to hold form elements */
		$leftForm = array ();
		$rightForm = array ();
		$bottomForm = array ();

		/* We are editing the domain so check access and get the data */
		if (isset ($id)) {
			require_once (EGS_FILE_ROOT.'/src/classes/class.domain.php');

			$domain = new domain();

			/* Correct access so get the data */
			if (isset ($id) && ($domain->accessLevel($domainId) > 0)) {
				$query = 'SELECT * FROM portfolioitem WHERE id='.$db->qstr($id);

				$_POST = $db->GetRow($query);

				$select = true;
				/* Incorrect access so notify and redirect to domain view */
			} else {
				$smarty->assign('errors', array (_('You do not have the correct access to edit this portfolio item. If you believe you should please contact your system administrator')));
				$smarty->assign('redirect', true);
				$smarty->assign('redirectAction', 'action=view&amp;id='.$id);
			}
		}

		/* Set up the title */
		if (isset ($id))
			$smarty->assign('pageTitle', _('Save Changes to Portfolio Item'));
		else
			$smarty->assign('pageTitle', _('Save New Portfolio Item'));

		/* Add any hidden fields we need */
		$hidden = array ();
		if (isset ($id))
			$hidden['id'] = $id;
		if (isset ($domainId))
			$hidden['domainid'] = $domainId;

		$smarty->assign('hidden', $hidden);

		/* Setup the item name */
		$item = array ();
		$item['type'] = 'text';
		$item['tag'] = _('Title');
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
		$item['hide'] = 'person';
		if (isset ($_POST['companyid']))
			$item['value'] = $_POST['companyname'];
		if (isset ($_POST['companyid']))
			$item['actualvalue'] = $_POST['companyid'];

		$leftForm[] = $item;

		/* Setup the website field */
		$item = array ();
		$item['type'] = 'text';
		$item['tag'] = _('Website');
		$item['name'] = 'www';
		if (isset ($_POST['www']))
			$item['value'] = $_POST['www'];

		$leftForm[] = $item;

		/* Setup the portfolio category */
		$item = array ();

		$query = 'SELECT id, name FROM portfoliocategory WHERE domainid='.$db->qstr($domainId).' AND id<>'.intval($db->qstr($id)).' ORDER BY name';

		$parentPage = $db->Execute($query);

		if (!$parentPage && EGS_DEBUG_SQL)
			die($db->ErrorMsg());

		$item['options'] = array ();

		while (($parentPage !== false) && !$parentPage->EOF) {
			$item['options'][$parentPage->fields['id']] = $parentPage->fields['name'];

			$parentPage->MoveNext();
		}

		$item['type'] = 'select';
		$item['tag'] = _('Portfolio Category');
		$item['name'] = 'portfolioid';
		if (isset ($_POST['portfolioid']))
			$item['value'] = $_POST['portfolioid'];

		$rightForm[] = $item;

		/* Setup the orientation */
		$item = array ();

		$item['options'] = array ();
		$item['options']['S'] = _('Square');
		$item['options']['L'] = _('Landscape');
		$item['options']['P'] = _('Portrait');
		$item['options']['H'] = _('Panoramic');

		$item['type'] = 'select';
		$item['tag'] = _('Orientation');
		$item['name'] = 'orientation';
		if (isset ($_POST['orientation']))
			$item['value'] = $_POST['orientation'];

		$rightForm[] = $item;

		/* Setup the vote offset if editing an item */
		if (isset ($id)) {
			$item = array ();
			$item['type'] = 'text';
			$item['tag'] = _('Vote Offset');
			$item['name'] = 'voteoffset';
			if (isset ($_POST['voteoffset']))
				$item['value'] = $_POST['voteoffset'];

			$rightForm[] = $item;
		/* Or put the file upload for new items */
		} else {
			$item = array ();
			$item['type'] = 'file';
			$item['tag'] = _('Upload File');
			$item['name'] = 'file';

			$rightForm[] = $item;
		}

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
		$smarty->assign('formFile', true);
		$smarty->assign('formId', 'saveform');
	}
}
?>