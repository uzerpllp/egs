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
if (isset ($_SESSION['modules']) && (in_array('home', $_SESSION['modules'])) && (EGS_COMPANY_ID == EGS_ACTUAL_COMPANY_ID)) {
	/* This is set to try if the company was saved */
	$saved = false;

	/* Do a save if the form has been posted */
	if (sizeof($_POST) > 0) {
		/* Check the post array */
		$egs->checkPost();

		$saved = $egs->saveMessage($_POST);
	}

	if ($saved) {
		$smarty->assign('redirect', true);
		if(!isset($_POST['delete'])) $smarty->assign('redirectAction', '');

	}
	
	if (!$saved) {

		/* Set up arrays to hold form elements */
		$leftForm = array ();
		$rightForm = array ();
		$bottomForm = array ();
		
		$hidden = array ();
		$hidden['companyid'] = '';
		$hidden['companyname'] = '';

		$smarty->assign('hidden', $hidden);
		
		/* Set up the title */
		$smarty->assign('pageTitle', _('Send Message'));

		$smarty->assign('formDelete', false);

		/* Setup the recipient */
		$item = array ();

		$query = 'SELECT owner FROM person WHERE userdetail AND companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY owner';

		$to = $db->query($query);

		while (!$to->EOF) {
			$item['options'][$to->fields['owner']] = $to->fields['owner'];
			$to->MoveNext();
		}

		$item['type'] = 'select';
		$item['tag'] = _('To');
		$item['name'] = 'leftfor';
		if (isset ($_POST['leftfor']))
			$item['value'] = $_POST['leftfor'];

		$leftForm[] = $item;

		/* Setup the person */
		$item = array ();
		$item['type'] = 'person';
		$item['tag'] = _('Attach to Contact');
		$item['name'] = 'person';
		$item['hide'] = 'company';
		if (isset ($_POST['personname']))
			$item['value'] = $_POST['personname'];
		if (isset ($_POST['personid']) && isset($_POST['personname']))
			$item['actualvalue'] = $personId;

		$rightForm[] = $item;

		$item = array ();
		$item['type'] = 'area';
		$item['tag'] = _('Message');
		$item['name'] = 'message';
		if (isset ($_POST['message']))
			$item['value'] = $_POST['message'];

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
}
?>