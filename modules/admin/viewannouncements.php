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

if($_GET['action'] == 'viewannouncements') $announcement = true;
else $announcement = false;

require_once(EGS_FILE_ROOT.'/src/classes/class.admin.php');

$admin = new admin();
	
/* Check that the admin is enabled, and the correct permissions are valid for the admin. */
if (in_array('admin', $_SESSION['modules'])) {
	/* Set up the variables for the form */
	$saved = false;
	$select = false;
	if(!isset($id)) $id = null;

	/* Do a save if the form has been posted */
	if (sizeof($_POST) > 0) {
		/* Check the post array */
		$egs->checkPost();
		/*change the time*/
		if(isset($_POST['published'])&&isset($_POST['publishedhour'])&&isset($_POST['publishedminute']))$_POST['published'] = $_POST['published'].' '.$_POST['publishedhour'].':'.$_POST['publishedminute'];
		if(isset($_POST['showfrom'])&&isset($_POST['showfromhour'])&&isset($_POST['showfromminute']))$_POST['showfrom'] = $_POST['showfrom'].' '.$_POST['showfromhour'].':'.$_POST['showfromminute'];
		if(isset($_POST['showuntil'])&&isset($_POST['showuntilhour'])&&isset($_POST['showuntilminute']))$_POST['showuntil'] = $_POST['showuntil'].' '.$_POST['showuntilhour'].':'.$_POST['showuntilminute'];
		/* If project admin do the delete */
		if(isset($_POST['delete'])) $saved = $admin->deleteNews($id, $announcement);
		else if(!isset($_POST['delete'])) $saved = $admin->saveNews($_POST, $announcement);
	}

	/* Redirect to the admin view if the form saved successfully */
	if ($saved) {
		$smarty->assign('redirect', true);
		if($announcement) $smarty->assign('redirectAction', 'action=announcements');
		else $smarty->assign('redirectAction', 'action=news');
	} else {
		/* Set up arrays to hold form elements */
		$leftForm = array ();
		$rightForm = array ();
		$bottomForm = array ();

		/* We are editing the admin so check access and get the data */
		if (isset ($id)) {
			$query = 'SELECT * FROM news WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' AND domainid IS NULL AND motd=false AND id='.$db->qstr($id);

			if($announcement) $query .= ' AND news<>true';
			
			$_POST = $db->GetRow($query);

			$select = true;
			/* Incorrect access so notify and redirect to project view */
			if(sizeof($_POST) == 0) {
				if($announcement) $smarty->assign('errors', array (_('You do not have the correct access to edit this announcement. If you believe you should please contact your system administrator')));
				else $smarty->assign('errors', array (_('You do not have the correct access to edit this news item. If you believe you should please contact your system administrator')));
				$smarty->assign('redirect', true);
				if($announcement) $smarty->assign('redirectAction', 'action=news');
				else $smarty->assign('redirectAction', 'action=announcements');
				
				return false;
			}
		}

		/* Set up the title */
		if (isset ($id)) {
			if($announcement) $smarty->assign('pageTitle', _('Save Changes to Announcement'));
			else $smarty->assign('pageTitle', _('Save Changes to News Item'));
		}
		else {
			if($announcement) $smarty->assign('pageTitle', _('Save New Announcement'));
			else $smarty->assign('pageTitle', _('Save New News Item'));
		}

		/* Show the delete button if editing */
		if(isset($id)) $smarty->assign('formDelete', true);
		
		/* Add any hidden fields we need */
		$hidden = array ();
		if (isset ($id))
			$hidden['id'] = $id;

		$smarty->assign('hidden', $hidden);

		/* Setup the admin subject */
		$item = array ();
		$item['type'] = 'text';
		$item['tag'] = _('Headline');
		$item['name'] = 'headline';
		if (isset ($_POST['headline']))
			$item['value'] = $_POST['headline'];
		$item['compulsory'] = true;

		$leftForm[] = $item;
		
		$item = array ();
		$item['type'] = 'space';

		$leftForm[] = $item;
		
		$item = array();
        $item['type'] = 'checkbox';
        $item['tag'] = _('Visible');
        $item['name'] = 'visible';
        if(isset($_POST['visible']) && (($_POST['visible'] == 'on') || ($_POST['visible'] == 't'))) $item['value'] = true;
        if(!isset($id)) $item['value'] = true;

		$leftForm[] = $item;

		/* Setup the admin queue it is attached to */
		if (isset ($_POST['queueid'])) {
			$query = 'SELECT name FROM adminqueue WHERE id='.$db->qstr($_POST['queueid']);

			$_POST['queuename'] = $db->GetOne($query);
		}

		/* Setup the date fields */
		
		$item = array ();
		$item['type'] = 'date';
		$item['tag'] = _('Published');
		$item['name'] = 'published';
		$item['format'] = str_replace('%i', '%M', EGS_TIME_FORMAT);
		$item['compulsory'] = true;
		$item['time'] = true;
		if (isset ($_POST['published'])) {
			preg_match("/(\d{4}-\d{2}-\d{2}) (\d{2}):(\d{2})*/i",$_POST['published'],$matches);
			$_POST['published']=$matches[1];
			$_POST['publishedhour']=$matches[2];
			$_POST['publishedminute']=$matches[3];
			$item['timehourvalue'] = $_POST['publishedhour'];
			$item['timeminutevalue'] = $_POST['publishedminute'];
			$item['actualvalue'] = $_POST['published'];
			$item['value'] = date(str_replace('%', '', EGS_TIME_FORMAT), strtotime($_POST['published']));
		} else {
			$now = time();
			preg_match("/(\d{4}-\d{2}-\d{2}) (\d{2}):(\d{2})*/i",date('Y-m-d H:i'),$matches);
			$item['timehourvalue']=$matches[2];
			$item['timeminutevalue']=$matches[3];
			$item['actualvalue'] = date('Y-m-d H:i');
			$item['value'] = $matches[1];
		}

		$rightForm[] = $item;
		
		$item = array ();
		$item['type'] = 'date';
		$item['tag'] = _('Show From');
		$item['name'] = 'showfrom';
		$item['format'] = str_replace('%i', '%M', EGS_TIME_FORMAT);
		$item['time'] = true;
		if (isset ($_POST['showfrom'])) {
			preg_match("/(\d{4}-\d{2}-\d{2}) (\d{2}):(\d{2})*/i",$_POST['showfrom'],$matches);
			$_POST['showfrom']=$matches[1];
			$_POST['showfromhour']=$matches[2];
			$_POST['showfromminute']=$matches[3];
			$item['timehourvalue'] = $_POST['showfromhour'];
			$item['timeminutevalue'] = $_POST['showfromminute'];
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
			preg_match("/(\d{4}-\d{2}-\d{2}) (\d{2}):(\d{2})*/i",$_POST['showuntil'],$matches);
			$_POST['showuntil']=$matches[1];
			$_POST['showuntilhour']=$matches[2];
			$_POST['showuntilminute']=$matches[3];
			$item['timehourvalue'] = $_POST['showuntilhour'];
			$item['timeminutevalue'] = $_POST['showuntilminute'];
			$item['actualvalue'] = $_POST['showuntil'];
			$item['value'] = date(str_replace('%', '', EGS_TIME_FORMAT), strtotime($_POST['showuntil']));
		}

		$rightForm[] = $item;

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