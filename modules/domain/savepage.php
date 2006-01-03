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
$saved = false;
$select = false;
$id = null;

/* Set the id if set */
if (isset ($_GET['domainid']))
	$domainId = intval($_GET['domainid']);
if (isset ($_POST['domainid']))
	$domainId = ($_POST['domainid']);

if (isset ($_GET['pageid']))
	$id = intval($_GET['pageid']);
if (isset ($_POST['id']))
	$id = ($_POST['id']);

/* Do a save if the form has been posted */
if (sizeof($_POST) > 0) {
	/* Check the post array */
	$egs->checkPost();

	require_once (EGS_FILE_ROOT.'/src/classes/class.domain.php');

	$domain = new domain();

	if(isset($_POST['delete'])) $saved = $domain->deletePage($id, $domainId);
	else $saved = $domain->savePage($_POST, $id);
}

/* Redirect to the domain view if the form saved successfully */
if ($saved) {
	$smarty->assign('redirect', true);
	$smarty->assign('redirectAction', 'action=viewpage&amp;domainid='.$_POST['domainid'].'&amp;pageid='.$_POST['id']);
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
			$query = 'SELECT * FROM webpage WHERE id='.$db->qstr($id);

			$_POST = $db->GetRow($query);

			$select = true;
			/* Incorrect access so notify and redirect to domain view */
		} else {
			$smarty->assign('errors', array (_('You do not have the correct access to edit this domain. If you believe you should please contact your system administrator')));
			$smarty->assign('redirect', true);
			$smarty->assign('redirectAction', 'action=view&amp;id='.$id);
		}
	}

	/* Set up the title */
	if (isset ($id))
		$smarty->assign('pageTitle', _('Save Changes to Page'));
	else
		$smarty->assign('pageTitle', _('Save New Page'));

	/* Add any hidden fields we need */
	$hidden = array ();
	if (isset ($id))
		$hidden['id'] = $id;
	if (isset ($domainId))
		$hidden['domainid'] = $domainId;

	$smarty->assign('hidden', $hidden);

	/* Setup the page name */
	$item = array ();
	$item['type'] = 'text';
	$item['tag'] = _('Page Name');
	$item['name'] = 'name';
	if (isset ($_POST['name']))
		$item['value'] = $_POST['name'];
	$item['compulsory'] = true;

	$leftForm[] = $item;

	$item = array ();
	$item['type'] = 'text';
	$item['tag'] = _('Page Title');
	$item['name'] = 'title';
	if (isset ($_POST['title']))
		$item['value'] = $_POST['title'];
	$item['compulsory'] = true;

	$leftForm[] = $item;

	/* Setup the parent Page */
	$item = array ();

	$query = 'SELECT id, name FROM webpage WHERE domainid='.$db->qstr($domainId).' AND id<>'.intval($db->qstr($id)).' ORDER BY name';

	$parentPage = $db->Execute($query);

	if (!$parentPage && EGS_DEBUG_SQL)
		die($db->ErrorMsg());

	$item['options'] = array ();
	$item['options'][''] = _('None');

	while (($parentPage !== false) && !$parentPage->EOF) {
		$item['options'][$parentPage->fields['id']] = $parentPage->fields['name'];

		$parentPage->MoveNext();
	}

	$item['type'] = 'select';
	$item['tag'] = _('Parent Page');
	$item['name'] = 'parentpageid';
	if (isset ($_POST['parentpageid']))
		$item['value'] = $_POST['parentpageid'];

	$rightForm[] = $item;

	/* Setup the type */
	$item = array ();

	$item['options'] = array ();
	$item['options']['S'] = _('Static');
	$item['options']['P'] = _('Portfolio');
	$item['options']['N'] = _('News');

	$item['type'] = 'select';
	$item['tag'] = _('Page Type');
	$item['name'] = 'type';
	if (isset ($_POST['type']))
		$item['value'] = $_POST['type'];

	$rightForm[] = $item;

	$item = array ();
	$item['type'] = 'smallarea';
	$item['tag'] = _('Keywords');
	$item['name'] = 'keywords';
	if (isset ($_POST['keywords']))
		$item['value'] = $_POST['keywords'];

	$bottomForm[] = $item;

	$item = array ();
	$item['type'] = 'smallarea';
	$item['tag'] = _('Description');
	$item['name'] = 'description';
	if (isset ($_POST['description']))
		$item['value'] = $_POST['description'];

	$bottomForm[] = $item;

	require_once(EGS_FILE_ROOT.'/src/classes/class.fckeditor.php');
	
	// Automatically calculates the editor base path based on the _samples directory.
	// This is usefull only for these samples. A real application should use something like this:
	// $oFCKeditor->BasePath = '/FCKeditor/' ;      // '/FCKeditor/' is the default value.
	$sBasePath = $_SERVER['PHP_SELF'] ;
	$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "_samples" ) ) ;
	
	$oFCKeditor = new FCKeditor('content') ;
	$oFCKeditor->BasePath   = EGS_SERVER.'/src/fckeditor/' ;
	if (isset ($_POST['content'])) $oFCKeditor->Value = $_POST['content'];
	//$oFCKeditor->ToolbarSet = 'Basic';
	
	/* Setup the descrption */
	$item = array ();
	$item['type'] = 'fckeditor';
	$item['tag'] = _('Page');
	$item['name'] = 'content';
	$item['fckeditor'] = $oFCKeditor->CreateHTML();

	$bottomForm[] = $item;
	/* Assign the form variable */
	$smarty->assign('form', true);
	$smarty->assign('leftForm', $leftForm);
	$smarty->assign('rightForm', $rightForm);
	$smarty->assign('bottomForm', $bottomForm);
	$smarty->assign('formId', 'saveform');
}
?>
