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
/* Set up the variables for the form */
if (EGS_CRMADMIN) {

	$saved = false;
	$select = false;
	$id = null;

	/* Set the id if set */
	if (isset ($_GET['id']))
		$letterid = intval($_GET['id']);
	if (isset ($_POST['id']))
		$letterid = ($_POST['id']);

	/* Do a save if the form has been posted */
	if (isset ($_POST['save']) || isset ($_POST['delete']) && sizeof($_POST) > 0) {
		/* Check the post array */
		$egs->checkPost();

		require_once (EGS_FILE_ROOT.'/src/classes/class.letter.php');
		$letter = new letter();

		if (!isset ($letterid))
			$letterid = null;
		if (isset ($_POST['delete']))
			$saved = $letter->deleteLetter($letterid, $letterid);
		else
			$saved = $letter->saveLetter($_POST, $letterid);
	}
	if ($saved) {
		$smarty->assign('redirect', true);
		$smarty->assign('redirectAction', 'action=templateoverview');
	} else {
		/* Set up arrays to hold form elements */
		$leftForm = array ();
		$rightForm = array ();
		$bottomForm = array ();

		/* We are editing the letter so check access and get the data */
		if (isset ($letterid)) {
			require_once (EGS_FILE_ROOT.'/src/classes/class.letter.php');

			$letter = new letter();
			$q = 'SELECT * FROM letters WHERE id='.$db->qstr($letterid);
			$_POST = $db->GetRow($q);
			/* Correct access so get the data */
		}

		/* Set up the title */
		if (isset ($letterid))
			$smarty->assign('pageTitle', _('Save Changes to Letter Template'));
		else
			$smarty->assign('pageTitle', _('Save New Letter Template'));

		/* Add any hidden fields we need */
		$hidden = array ();
		if (isset ($letterid))
			$hidden['id'] = $letterid;
		if (isset ($letterid))
			$hidden['letterid'] = $letterid;

		$smarty->assign('hidden', $hidden);

		/* Setup the letter name */
		$item = array ();
		$item['type'] = 'text';
		$item['tag'] = _('Letter Name');
		$item['name'] = 'name';
		if (isset ($_POST['name']))
			$item['value'] = $_POST['name'];
		$item['compulsory'] = true;

		$leftForm[] = $item;

		require_once (EGS_FILE_ROOT.'/src/classes/class.fckeditor.php');

		// Automatically calculates the editor base path based on the _samples directory.
		// This is usefull only for these samples. A real application should use something like this:
		// $oFCKeditor->BasePath = '/FCKeditor/' ;      // '/FCKeditor/' is the default value.
		$sBasePath = $_SERVER['PHP_SELF'];
		$sBasePath = substr($sBasePath, 0, strpos($sBasePath, "_samples"));

		$oFCKeditor = new FCKeditor('content');
		$oFCKeditor->BasePath = EGS_SERVER.'/src/fckeditor/';
		if (isset ($_POST['body']))
			$oFCKeditor->Value = $_POST['body'];
		$oFCKeditor->ToolbarSet = 'Basic';

		/* Setup the descrption */
		$item = array ();
		$item['type'] = 'fckeditor';
		$item['tag'] = _('Letter');
		$item['name'] = 'content';
		$item['fckeditor'] = $oFCKeditor->CreateHTML();
		//echo $_POST['content'];
		$bottomForm[] = $item;
		//echo '<br> fck';echo print_r($_POST);
		/* Assign the form variable */
		$smarty->assign('form', true);
		$smarty->assign('leftForm', $leftForm);
		$smarty->assign('rightForm', $rightForm);
		$smarty->assign('bottomForm', $bottomForm);
		$smarty->assign('formId', 'saveform');
		// Incorrect access
	}
} else {
	$smarty->assign('errors', array (_('You do not have the correct access to add or edit templates. If you believe you should please contact your system administrator')));
	$smarty->assign('redirect', true);
	$smarty->assign('redirectAction', '');
}

//}
?>


