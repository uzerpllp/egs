<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Save Ticket Queue 1.0            |
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
	$id = $_GET['id'];
if (isset ($_POST['id']))
	$id = $_POST['id'];

/* Check that the calendar is enabled, and the correct permissions are valid for the calendar. */
if (in_array('systemadmin', $_SESSION['modules'])) {
	/* Set up the variables for the form */
	$saved = false;
	$select = false;
	if(!isset($id)) $id = null;

	/* Do a save if the form has been posted */
	if (sizeof($_POST) > 0) {
		require_once(EGS_FILE_ROOT.'/src/classes/class.systemadmin.php');

		$systemadmin= new systemadmin();

		/* Check the post array */
		$egs->checkPost();

		$saved = $systemadmin->saveQueue($_POST, $id);
	}

	/* Redirect to the calendar view if the form saved successfully */
	if ($saved) {
		$smarty->assign('redirect', true);
		$smarty->assign('redirectAction', 'action=queues');
	} else {
		/* Set up arrays to hold form elements */
		$leftForm = array ();
		$rightForm = array ();
		$bottomForm = array ();

		/* We are editing the user so check access and get the data */
		if (isset ($id)) {
			$query = 'SELECT id, companyid, name, address, actualaddress FROM ticketqueue WHERE id='.$db->qstr($id);

			$_POST = $db->GetRow($query);

			if(sizeof($_POST) > 0) $select = true;

			/* Incorrect access so notify and redirect to project view */
			if(!$select) {
				$smarty->assign('errors', array (_('You do not have the correct access to edit this queue. If you believe you should please contact your system administrator')));
				$smarty->assign('redirect', true);
				$smarty->assign('redirectAction', 'action=queues');

				return;
			}
		}

		/* Set up the title */
		if(isset($id)) $smarty->assign('pageTitle', _('Save Changes to Queue'));
		else $smarty->assign('pageTitle', _('Save New Queue'));
		
		/* Add any hidden fields we need */
		$hidden = array ();
		if (isset ($id)) {
			$hidden['id'] = $id;
			$hidden['companyid'] = $_POST['companyid'];
		}

		$smarty->assign('hidden', $hidden);

		$item = array ();
		$item['type'] = 'text';
		$item['tag'] = _('Queue Name');
		$item['name'] = 'name';
		if (isset ($_POST['name']))
			$item['value'] = $_POST['name'];
		$item['compulsory'] = true;

		$leftForm[] = $item;
		
		if(isset($id)) {
			$item = array ();
			$item['type'] = 'noedit';
			$item['tag'] = _('Company');
			$item['value'] = $db->GetOne('SELECT name FROM company WHERE id='.$_POST['companyid']);
	
			$leftForm[] = $item;
		} else {
		$item['type'] = 'select';
		$item['tag'] = _('Company');
		$item['name'] = 'companyid';
		$item['compulsory'] = true;
		
		$query = 'SELECT c.id, c.name FROM company c, companydefaults d WHERE c.id=d.companyid ORDER BY c.name';
		
		$rs = $db->Execute($query); 

		$item['options'] = array ();

		while(!$rs->EOF) {
			$item['options'][$rs->fields['id']] = $rs->fields['name'];
			
			$rs->MoveNext();
		}
		
		if(isset($_POST['companyid'])) $item['value'] = $_POST['companies'];
			
		$leftForm[] = $item;

		}
		
		$item = array ();
		$item['type'] = 'text';
		$item['tag'] = _('Email Address');
		$item['name'] = 'address';
		if (isset ($_POST['address']))
			$item['value'] = $_POST['address'];
		$item['compulsory'] = true;

		$rightForm[] = $item;
		
		$item = array ();
		$item['type'] = 'text';
		$item['tag'] = _('Actual Email Address');
		$item['name'] = 'actualaddress';
		if (isset ($_POST['actualaddress']))
			$item['value'] = $_POST['actualaddress'];

		$rightForm[] = $item;
		
		/* Assign the form variable */
		$smarty->assign('form', true);
		$smarty->assign('leftForm', $leftForm);
		$smarty->assign('rightForm', $rightForm);
		$smarty->assign('formId', 'saveform');
	}
} else {
	$smarty->assign('redirect', true);
	if(isset($id)) $smarty->assign('redirectAction', '');
	else $smarty->assign('redirectAction', 'action=overview');
	$smarty->assign('errors', array (_('You do not have the correct permissions to update this user. If you beleive you should please contact your system administrator.')));
}
?>
