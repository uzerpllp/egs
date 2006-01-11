<?php   
// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - MOTD Admin 1.0                   |
// +----------------------------------------------------------------------+
// | Copyright (c) 2002-2006 Senokian Solutions                           |
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

/* Do a save if the form has been posted */
if (sizeof($_POST) > 0) {
	/* Check the post array */
	$egs->checkPost();

	require_once (EGS_FILE_ROOT.'/src/classes/class.admin.php');

	$admin = new admin();

	$saved = $admin->saveMOTD($_POST);
}

/* Redirect to the domain view if the form saved successfully */
if ($saved) {
	$smarty->assign('redirect', true);
	$smarty->assign('redirectAction', 'action=motd');
} else {
	/* Set up arrays to hold form elements */
	$bottomForm = array ();

	/* Get the current MOTD */
	$query = 'SELECT body FROM news WHERE motd AND companyid='.$db->qstr(EGS_COMPANY_ID).' AND domainid IS NULL';

	$_POST['body'] = $db->GetOne($query);

	/* Set up the title */
	$smarty->assign('pageTitle', _('Save MOTD'));

	require_once(EGS_FILE_ROOT.'/src/classes/class.fckeditor.php');
	
	/* Setup the descrption */
	$item = array ();
	$item['type'] = 'area';
	$item['tag'] = _('MOTD');
	$item['name'] = 'body';
	$item['value'] = $_POST['body'];

	$bottomForm[] = $item;

	/* Assign the form variable */
	$smarty->assign('form', true);
	$smarty->assign('bottomForm', $bottomForm);
	$smarty->assign('formId', 'saveform');
}
?>
