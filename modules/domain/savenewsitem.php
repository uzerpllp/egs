<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Save News 1.0                    |
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
/* Set the domain id if set */
if (isset ($_GET['domainid']))
	$domainId = intval($_GET['domainid']);
if (isset ($_POST['domainid']))
	$domainId = ($_POST['domainid']);

require_once(EGS_FILE_ROOT.'/src/classes/class.domain.php');

$domain = new domain();
	
/* Check that the domain is enabled, and the correct permissions are valid for the domain. */
if (in_array('domain', $_SESSION['modules'])) {
	/* Set up the variables for the form */
	$saved = false;
	$select = false;
	if(!isset($id)) $id = null;

	/* Do a save if the form has been posted */
	if (sizeof($_POST) > 0) {
		/* Check the post array */
		$egs->checkPost();

		/* If project domain do the delete */
		if(isset($_POST['delete'])) $saved = $domain->deleteNews($id, $domainId);
		else if(!isset($_POST['delete'])) $saved = $domain->saveNews($_POST);
	}

	/* Redirect to the domain view if the form saved successfully */
	if ($saved) {
		$smarty->assign('redirect', true);
		$smarty->assign('redirectAction', 'action=view&amp;id='.$_POST['domainid']);
	} else {
		/* Set up arrays to hold form elements */
		$leftForm = array ();
		$rightForm = array ();
		$bottomForm = array ();

		/* We are editing the domain so check access and get the data */
		if (isset ($id)) {
			$query = 'SELECT * FROM news WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' AND domainid='.$db->qstr($domainId).' AND motd=false AND id='.$db->qstr($id);
			
			$_POST = $db->GetRow($query);

			$select = true;
			/* Incorrect access so notify and redirect to project view */
			if(sizeof($_POST) == 0) {
				$smarty->assign('errors', array (_('You do not have the correct access to edit this news item. If you believe you should please contact your system domainistrator')));
				$smarty->assign('redirect', true);
				$smarty->assign('redirectAction', 'action=view&amp;id='.$domainId);
				
				return false;
			}
		}

		/* Set up the title */
		if (isset ($id)) {
			$smarty->assign('pageTitle', _('Save Changes to News Item'));
		}
		else {
			$smarty->assign('pageTitle', _('Save New News Item'));
		}

		/* Show the delete button if editing */
		if(isset($id)) $smarty->assign('formDelete', true);
		
		/* Add any hidden fields we need */
		$hidden = array ();
		if (isset ($id))
			$hidden['id'] = $id;

		$hidden['domainid'] = $domainId;
		
		$smarty->assign('hidden', $hidden);

		/* Setup the title */
		$item = array ();
		$item['type'] = 'text';
		$item['tag'] = _('Headline');
		$item['name'] = 'headline';
		if (isset ($_POST['headline']))
			$item['value'] = $_POST['headline'];
		$item['compulsory'] = true;

		$leftForm[] = $item;
		
		$item = array ();
		$item['type'] = 'text';
		$item['tag'] = _('Website');
		$item['name'] = 'url';
		if (isset ($_POST['url']))
			$item['value'] = $_POST['url'];

		$leftForm[] = $item;
		
		$item = array();
        $item['type'] = 'checkbox';
        $item['tag'] = _('Link straight to website');
        $item['name'] = 'external';
        if(isset($_POST['external']) && (($_POST['external'] == 'on') || ($_POST['external'] == 't'))) $item['value'] = true;

		$leftForm[] = $item;
		
		$item = array();
        $item['type'] = 'checkbox';
        $item['tag'] = _('Visible');
        $item['name'] = 'visible';
        if(isset($_POST['visible']) && (($_POST['visible'] == 'on') || ($_POST['visible'] == 't'))) $item['value'] = true;
        if(!isset($id)) $item['value'] = true;

		$leftForm[] = $item;
		
		$item = array();
        $item['type'] = 'checkbox';
        $item['tag'] = _('Show on Front Page');
        $item['name'] = 'frontpage';
        if(isset($_POST['frontpage']) && (($_POST['frontpage'] == 'on') || ($_POST['frontpage'] == 't'))) $item['value'] = true;

		$leftForm[] = $item;

		/* Setup the date fields */
		$item = array ();
		$item['type'] = 'date';
		$item['tag'] = _('Published');
		$item['name'] = 'published';
		$item['format'] = str_replace('%i', '%M', EGS_TIME_FORMAT);
		$item['compulsory'] = true;
		$item['time'] = true;
		if (isset ($_POST['published'])) {
			$item['actualvalue'] = $_POST['published'];
			$item['value'] = date(str_replace('%', '', EGS_TIME_FORMAT), strtotime($_POST['published']));
		} else {
			$now = time();
			$item['actualvalue'] = date('Y-m-d H:i');
			$item['value'] = date(str_replace('%', '', EGS_TIME_FORMAT), $now);
		}

		$rightForm[] = $item;
		
		$item = array ();
		$item['type'] = 'date';
		$item['tag'] = _('Show From');
		$item['name'] = 'showfrom';
		$item['format'] = str_replace('%i', '%M', EGS_TIME_FORMAT);
		$item['time'] = true;
		if (isset ($_POST['showfrom'])) {
			$item['actualvalue'] = $_POST['showfrom'];
			$item['value'] = date(str_replace('%', '', EGS_TIME_FORMAT), strtotime($_POST['showfrom']));
		}

		$rightForm[] = $item;
		
		$item = array ();
		$item['type'] = 'date';
		$item['tag'] = _('Show Until');
		$item['name'] = 'showuntil';
		$item['format'] = str_replace('%i', '%M', EGS_TIME_FORMAT);
		$item['time'] = true;
		if (isset ($_POST['showuntil'])) {
			$item['actualvalue'] = $_POST['showuntil'];
			$item['value'] = date(str_replace('%', '', EGS_TIME_FORMAT), strtotime($_POST['showuntil']));
		}

		$rightForm[] = $item;
		
		/* Setup the category */
		$item = array ();
	
		$query = 'SELECT c.id, CASE WHEN n.id IS NULL THEN c.name ELSE n.name || \'->\' || c.name END AS name FROM newscategory c LEFT OUTER JOIN newscategory n ON c.parentcategoryid =n.id WHERE c.domainid='.$db->qstr($domainId).' ORDER BY name';
	
		$category = $db->Execute($query);
	
		if (!$category && EGS_DEBUG_SQL)
			die($db->ErrorMsg());
	
		$item['options'] = array ();
		$item['options'][''] = _('None');
	
		while (($category !== false) && !$category->EOF) {
			$item['options'][$category->fields['id']] = $category->fields['name'];
	
			$category->MoveNext();
		}
	
		$item['type'] = 'select';
		$item['tag'] = _('News Category');
		$item['name'] = 'newscategoryid';
		if (isset ($_POST['newscategoryid']))
			$item['value'] = $_POST['newscategoryid'];
	
		$rightForm[] = $item;

		/* Setup the descrption */
		$item = array ();
		$item['type'] = 'smallarea';
		$item['tag'] = _('Teaser');
		$item['name'] = 'teaser';
		if (isset ($_POST['teaser']))
			$item['value'] = $_POST['teaser'];

		$bottomForm[] = $item;
		
		/* Setup the descrption */
		$item = array ();
		$item['type'] = 'area';
		$item['tag'] = _('Body');
		$item['name'] = 'body';
		if (isset ($_POST['body']))
			$item['value'] = $_POST['body'];

		$bottomForm[] = $item;

		/* Assign the form variable */
		$smarty->assign('form', true);
		$smarty->assign('leftForm', $leftForm);
		$smarty->assign('rightForm', $rightForm);
		$smarty->assign('bottomForm', $bottomForm);
		$smarty->assign('formId', 'saveform');
	}
}
?>