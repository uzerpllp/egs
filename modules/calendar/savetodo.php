<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Save Event 1.0                   |
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

require_once(EGS_FILE_ROOT.'/src/classes/class.todo.php');

$todo = new todo();
	
/* Check that the calendar is enabled, and the correct permissions are valid for the calendar. */
if (in_array('calendar', $_SESSION['modules']) && (!isset ($id) || (isset ($id) && $todo->writeAccess('',$id)))) {
	/* Set up the variables for the form */
	
	$saved = false;
	$select = false;
	if(!isset($id)) $id = null;

	/* Do a save if the form has been posted */
	if (sizeof($_POST) > 0) {
		/* Check the post array */
		$egs->checkPost();
		if(isset($_POST['completed'])&&isset($_POST['completedhour'])&&isset($_POST['completedminute']))$_POST['completed'] = $_POST['completed'].' '.$_POST['completedhour'].':'.$_POST['completedminute'];
		if(isset($_POST['delete'])) $saved = $todo->deleteEvent($id);
		else if(!isset($_POST['delete'])) $saved = $todo->saveEvent($_POST, $id);
	}

	/* Redirect to the calendar view if the form saved successfully */
	if ($saved) {
		$smarty->assign('redirect', true);
		if (isset($_POST['delete'])) $smarty->assign('redirectAction', 'action=overview');
		else $smarty->assign('redirectAction', '');
	} else {
		/* Set up arrays to hold form elements */
		$leftForm = array ();
		$rightForm = array ();
		$bottomForm = array ();

		/* We are editing the calendar so check access and get the data */
		if (isset ($id)) {
			
			/* Correct access so get the data */
			if ($todo->writeAccess('',$id)) {
				$query = 'SELECT * FROM todo WHERE id='.$db->qstr($id);

				$_POST = $db->GetRow($query);

				if(sizeof($_POST) > 0) $select = true;
				/* Incorrect access so notify and redirect to project view */
			} 
			
			if(!$select) {
				$smarty->assign('errors', array (_('You do not have the correct access to edit this calendar. If you believe you should please contact your system administrator')));
				$smarty->assign('redirect', true);
				$smarty->assign('redirectAction', '');

				return;
			}
		}

		/* Set up the title */
		if (isset ($id))
			$smarty->assign('pageTitle', _('Save Changes to ToDo'));
		else
			$smarty->assign('pageTitle', _('Save New Todo'));

		/* Show the delete button if editing */
		if(isset($id))
			$smarty->assign('formDelete', true);
		
		/* Add any hidden fields we need */
		$hidden = array ();
		if (isset ($id))
			$hidden['id'] = $id;

		$smarty->assign('hidden', $hidden);

		/* Setup the calendar subject */
		$item = array ();
		$item['type'] = 'text';
		$item['tag'] = _('Summary');
		$item['name'] = 'summary';
		if (isset ($_POST['summary']))
			$item['value'] = $_POST['summary'];
		$item['compulsory'] = true;

		$leftForm[] = $item;
		
		/*setup web/url*/
		$item=array();
		$item['type']='text';
		$item['tag']=_('URL/Web Address');
		$item['name']='url';
		if(isset($_POST['url']))
			$item['value']=$_POST['url'];
			
		$leftForm[]=$item;
		
		$item=array();
		$item['type']='date';
		$item['tag']=_('Date Due');
		$item['name']='deadline';
		$item['time'] = true;
		$item['format'] = str_replace('%i', '%M', EGS_TIME_FORMAT);
		if(isset($_POST['deadline'])) {
			$item['actualvalue'] = $_POST['deadline'];
			$item['value']=$_POST['deadline'];
		}
		
		$leftForm[]=$item;
		
		/*Setup username select*/
		$item['type'] = 'select';
		$item['tag'] = _('Add to this user\'s calendar');
		$item['name'] = 'username';
		if(isset($_POST['username'])) $item['value'] = $_POST['username'];
		else $item['value'] = EGS_USERNAME; 
		
		$query = 'SELECT gm.username FROM groupmoduleaccess a, groupmembers gm, groups g, module m WHERE a.groupid=gm.groupid AND gm.groupid=g.id AND m.id=a.moduleid AND g.companyid='.$db->qstr(EGS_COMPANY_ID).' AND m.name='.$db->qstr('calendar');
		
		$rs = $db->Execute($query); 

		$item['options'] = array ();

		while(!$rs->EOF) {
			$item['options'][$rs->fields['username']] = $rs->fields['username'];
			
			$rs->MoveNext();
		}
			
		$leftForm[] = $item;
		
		/*asetup Priority select*/
		$priorities = array(_('None'),_('Urgent'),_('Normal'),_('Lower'));
		$item['type'] = 'select';
		$item['tag'] = _('Priority');
		$item['name'] = 'priority';
		if (isset ($_POST['priority']))
			$item['value'] = $_POST['priority'];
		$pri=array(0,1,5,9);
		$item['options'] = array ();
		for ($i=0;$i<count($priorities);$i++) {
			$j=$pri[$i];
			$priority=$priorities[$i];
			if($priority != '') $item['options'][$j] = _(ucwords(strtolower($priority)));
			else $item['options'][''] = _('None');
			
		}
		
			
		$leftForm[] = $item;
		
		
		
		/*Editing, so give the option to set a completed date*/
		if (isset($id)) {
			$item=array();
			$item['type']='date';
			$item['tag']=_('Completed');
			$item['name']='completed';
			$item['time'] = true;
			$item['format'] = str_replace('%i', '%M', EGS_TIME_FORMAT);
			if(isset($_POST['completed'])) {
				preg_match("/(\d{4}-\d{2}-\d{2}) (\d{2}):(\d{2})*/i",$_POST['completed'],$matches);
				$_POST['completed']=$matches[1];
				$_POST['completedhour']=$matches[2];
				$_POST['completedminute']=$matches[3];
				$item['timehourvalue'] = $_POST['completedhour'];
				$item['timeminutevalue'] = $_POST['completedminute'];
				$item['actualvalue'] = $_POST['completed'];
				$item['value']=date(str_replace('%', '', EGS_TIME_FORMAT), strtotime($_POST['completed']));
			}
			
			$rightForm[]=$item;
				
		}
		/* Setup the descrption */
		$item = array ();
		$item['type'] = 'area';
		$item['tag'] = _('Description');
		$item['name'] = 'description';
		if (isset ($_POST['description']))
			$item['value'] = $_POST['description'];
		$bottomForm[]=$item;

		/* Assign the form variable */
		$smarty->assign('form', true);
		$smarty->assign('leftForm', $leftForm);
		$smarty->assign('rightForm', $rightForm);
		$smarty->assign('bottomForm', $bottomForm);
		$smarty->assign('formId', 'saveform');
	}
} else {
	$smarty->assign('redirect', true);
	if(isset($id)) $smarty->assign('redirectAction', '');
	else $smarty->assign('redirectAction', 'action=overview');
	$smarty->assign('errors', array (_('You do not have the correct permissions to save a todo. If you beleive you should please contact your system administrator.')));
}
?>
