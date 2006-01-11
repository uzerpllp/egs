<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Save Ticket 1.0                  |
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

require_once(EGS_FILE_ROOT.'/src/classes/class.ticket.php');

$ticket = new ticket();
	
/* Check that the ticket is enabled, and the correct permissions are valid for the ticket. */
if (in_array('ticketing', $_SESSION['modules']) && (!isset ($id) || (isset ($id) && $ticket->ticketAccess($id)))) {
	/* Set up the variables for the form */
	$saved = false;
	$select = false;
	if(!isset($id)) $id = null;

	/* Do a save if the form has been posted */
	if (sizeof($_POST) > 0) {
		/* Check the post array */
		$egs->checkPost();

		/* If project admin do the delete */
		if(isset($_POST['delete'])) $saved = $ticket->deleteTicket($id);
		else if(isset($_POST['save'])) $saved = $ticket->saveTicket($_POST, $id);
	}

	/* Redirect to the ticket view if the form saved successfully */
	if ($saved) {
		$smarty->assign('redirect', true);
		if (isset($_POST['delete'])) $smarty->assign('redirectAction', 'action=overview');
		else $smarty->assign('redirectAction', 'action=view&amp;id='.$_POST['id']);
	} else {
		/* Set up arrays to hold form elements */
		$leftForm = array ();
		$rightForm = array ();
		$bottomForm = array ();

		/* We are editing the ticket so check access and get the data */
		if (isset ($id)) {

			/* Correct access so get the data */
			if ($ticket->ticketAccess($id) > 0) {
				$query = 'SELECT * FROM ticket WHERE id='.$db->qstr($id);

				$_POST = $db->GetRow($query);

				$select = true;
				/* Incorrect access so notify and redirect to project view */
			} else {
				$smarty->assign('errors', array (_('You do not have the correct access to edit this ticket. If you believe you should please contact your system administrator')));
				$smarty->assign('redirect', true);
				$smarty->assign('redirectAction', 'action=view&amp;id='.$id);
			}
		}

		/* Set up the title */
		if (isset ($id))
			$smarty->assign('pageTitle', _('Save Changes to Ticket'));
		else
			$smarty->assign('pageTitle', _('Save New Ticket'));

		/* Show the delete button if editing */
		$smarty->assign('formDelete', true);
		
		/* Add any hidden fields we need */
		$hidden = array ();
		if (isset ($id))
			$hidden['id'] = $id;

		$smarty->assign('hidden', $hidden);

		/* Setup the ticket subject */
		$item = array ();
		$item['type'] = 'text';
		$item['tag'] = _('Subject');
		$item['name'] = 'subject';
		if (isset ($_POST['subject']))
			$item['value'] = $_POST['subject'];
		$item['compulsory'] = true;

		$leftForm[] = $item;
		
		$item = array ();
		$item['type'] = 'space';

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
		$item['compulsory'] = true;
		if (isset ($_POST['companyid']))
			$item['value'] = $_POST['companyname'];
		if (isset ($_POST['companyid']))
			$item['actualvalue'] = $_POST['companyid'];

		$leftForm[] = $item;

		/* Set up the contact the project is attached to */
		if (isset ($_POST['personid'])) {
			$query = 'SELECT firstname || \' \' || surname AS name FROM person WHERE id='.$db->qstr($_POST['personid']);

			$_POST['personname'] = $db->GetOne($query);
		}

		$item = array ();
		$item['type'] = 'person';
		$item['tag'] = _('Attach to Contact');
		$item['name'] = 'person';
		$item['hide'] = 'email';
		
		if (isset ($_POST['personid']))
			$item['value'] = $_POST['personname'];
		if (isset ($_POST['personid']))
			$item['actualvalue'] = $_POST['personid'];

		$leftForm[] = $item;
		
		$item = array ();
		$item['type'] = 'space';

		$leftForm[] = $item;

		/* Setup the date fields */
		$item = array ();
		$item['type'] = 'date';
		$item['tag'] = _('Deadline');
		$item['name'] = 'deadline';
		$item['format'] = EGS_DATE_FORMAT;
		if (isset ($_POST['deadline'])) {
			$item['actualvalue'] = $_POST['deadline'];
			$item['value'] = date(str_replace('%', '', EGS_DATE_FORMAT), strtotime($_POST['deadline']));
		}

		$leftForm[] = $item;
		
		$item = array();
        $item['type'] = 'checkbox';
        $item['tag'] = _('Private');
        $item['name'] = 'private';
        if(isset($_POST['private']) && (($_POST['private'] == 'on') || ($_POST['private'] == 't'))) $item['value'] = true;

		$leftForm[] = $item;

		/* Setup the ticket queue it is attached to */
		if (isset ($_POST['queueid'])) {
			$query = 'SELECT name FROM ticketqueue WHERE id='.$db->qstr($_POST['queueid']);

			$_POST['queuename'] = $db->GetOne($query);
		}

		$item = array ();
		$item['type'] = 'ticketqueue';
		$item['tag'] = _('Attach to Queue');
		$item['name'] = 'queue';
		$item['compulsory'] = true;
		if (isset ($_POST['queueid']))
			$item['value'] = $_POST['queuename'];
		if (isset ($_POST['queueid']))
			$item['actualvalue'] = $_POST['queueid'];

		$rightForm[] = $item;
		
		/* Setup the ticket internal queue it is attached to */
		if (isset ($_POST['internalqueueid'])) {
			$query = 'SELECT name FROM internalqueue WHERE id='.$db->qstr($_POST['internalqueueid']);

			$_POST['internalqueuename'] = $db->GetOne($query);
		}
		
		$item = array ();
		$item['type'] = 'ticketsubqueue';
		$item['tag'] = _('Attach to Sub Queue');
		$item['name'] = 'internalqueue';
		$item['compulsory'] = true;
		if (isset ($_POST['internalqueueid']))
			$item['value'] = $_POST['internalqueuename'];
		if (isset ($_POST['internalqueueid']))
			$item['actualvalue'] = $_POST['internalqueueid'];

		$rightForm[] = $item;


		$item = array ();
		$item['type'] = 'space';

		$rightForm[] = $item;

		$statuses = array('OPN', 'LOC', 'DEL', 'MOV', 'CLO', 'FIX', 'WON', 'INV', 'CTE', 'CCL', 'WTE', 'WCL');
		
		$item['type'] = 'select';
		$item['tag'] = _('Status');
		$item['name'] = 'status';
		if (isset ($_POST['status']))
			$item['value'] = $_POST['status'];

		$item['options'] = array ();
		
		while($status = array_shift($statuses)) {
			$item['options'][$status] = $ticket->translateStatus($status);
		}
			
		$rightForm[] = $item;

		$item['tag'] = _('Internal Status');
		$item['name'] = 'internalstatus';
		if (isset ($_POST['internalstatus']))
			$item['value'] = $_POST['internalstatus'];
		else
			$item['value'] = 3;

		$rightForm[] = $item;

		$item = array();
		$item['type'] = 'select';
		$item['tag'] = _('Priority');
		$item['name'] = 'priority';
		if (isset ($_POST['priority']))
			$item['value'] = $_POST['priority'];
		else
			$item['value'] = 3;

		$item['options'] = array ();
		
		for($i=0; $i<=5; $i++) {
			$item['options'][$i] = $ticket->translatePriority($i);
		}
			
		$rightForm[] = $item;

		$item['tag'] = _('Internal Priority');
		$item['name'] = 'internalpriority';
		if (isset ($_POST['internalpriority']))
			$item['value'] = $_POST['internalpriority'];

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
} else {
	$smarty->assign('redirect', true);
	if(isset($id)) $smarty->assign('redirectAction', 'action=view&amp;id='.$id);
	else $smarty->assign('redirectAction', 'action=overview');
	$smarty->assign('errors', array (_('You do not have the correct permissions to save a project. If you beleive you should please contact your system administrator.')));
}
?>