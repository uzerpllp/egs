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

//echo '<pre>'; print_r(get_defined_constants());
//echo 'admin:'; echo EGS_CRMADMIN;

/* Set the id if set */
if (isset ($_GET['id']))
	$letterid = intval($_GET['id']);
if (isset ($_POST['id']))
	$letterid = ($_POST['id']);

/* Do a save if the form has been posted */
if (sizeof($_POST) > 0) {
	/* Check the post array */
	$egs->checkPost();
	require_once (EGS_FILE_ROOT.'/src/classes/class.letter.php');
	$letter = new letter();
	if(isset($_POST['delete'])) $saved = $letter->deleteLetter($letterid, $letterid);
	else $saved = $letter->saveLetter($_POST, $letterid);
}

	/* Set up arrays to hold form elements */
	$leftForm = array ();
	$rightForm = array ();
	$bottomForm = array ();

	/* We are editing the letter so check access and get the data */
	if (isset ($letterid)) {
		require_once (EGS_FILE_ROOT.'/src/classes/class.letter.php');

		$letter = new letter();

		/* Correct access so get the data */
	}

	/* Set up the title */
	if (isset ($letterid))
		$smarty->assign('pageTitle', _('Save Changes to Letter'));
	else
		$smarty->assign('pageTitle', _('Save New Letter'));

	/* Add any hidden fields we need */
	$hidden = array ();
	if (isset ($letterid))
		$hidden['id'] = $letterid;
	if (isset ($letterid))
		$hidden['letterid'] = $letterid;

	$smarty->assign('hidden', $hidden);

	$query = 'SELECT name, body FROM letters WHERE id = '.$letterid;
	$rs = $db->execute($query);
	
	
	if (EGS_DEBUG_SQL && !$rs)
	//$db->close();
	die($db->errorMsg());
	
	/* Setup the letter name */
	$item = array ();
	$item['type'] = 'text';
	$item['tag'] = _('Letter Name');
	$item['name'] = 'name';
	if (isset ($rs->fields['name']))
		$item['value'] = $rs->fields['name'];
	$item['compulsory'] = true;

	$leftForm[] = $item;

	require_once(EGS_FILE_ROOT.'/src/classes/class.fckeditor.php');
	
	// Automatically calculates the editor base path based on the _samples directory.
	// This is usefull only for these samples. A real application should use something like this:
	// $oFCKeditor->BasePath = '/FCKeditor/' ;      // '/FCKeditor/' is the default value.
	$sBasePath = $_SERVER['PHP_SELF'] ;
	$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "_samples" ) ) ;
	
	$oFCKeditor = new FCKeditor('content');
	$oFCKeditor->BasePath   = EGS_SERVER.'/src/fckeditor/' ;
	if (isset ($rs->fields['body'])) $oFCKeditor->Value = $rs->fields['body'];
	$oFCKeditor->ToolbarSet = 'Basic';
	
	/* Setup the description */
	$item = array ();
	$item['type'] = 'fckeditor';
	$item['tag'] = _('Letter');
	$item['name'] = 'content';
	$item['fckeditor'] = $oFCKeditor->CreateHTML();
	$bottomForm[] = $item;
	/* Assign the form variable */
	$smarty->assign('form', true);
	$smarty->assign('leftForm', $leftForm);
	$smarty->assign('rightForm', $rightForm);
	$smarty->assign('bottomForm', $bottomForm);
	$smarty->assign('formId', 'saveform');
		// Incorrect access
	} else {
		$smarty->assign('errors', array (_('You do not have the correct access to edit this letter. If you believe you should please contact your system administrator')));
	}
//}
?>