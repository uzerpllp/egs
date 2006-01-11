<?php

/* Set up arrays to hold form elements */
	$leftForm = array();
	$rightForm = array();
	$bottomForm = array();

	/* If the form has been submitted do an update */
	if(sizeof($_POST) > 0) {
		unset($_POST['save']);
		
		/* Assign the preferences to the session */	
		while (list ($key, $val) = each($_POST)) {
			 $_SESSION['preferences'][$key] = $val;
		
		}
		$egs->syncPreferences();
	}
	
	$_POST = $_SESSION['preferences'];
	
	
	$item = array();

	$item['options'] = array();
	//$item['options']['accountnumber'] = _('Account Number');
	//$item['options']['name'] = _('Account Name');
	$item['options']['ticketid'] = _('Ticket ID');
	$item['options']['subject'] = _('subject');
	$item['options']['queue'] = _('Queue');
	$item['options']['internalqueue'] = _('Sub-Queue');
	$item['options']['updated'] = _('Updated');
	$item['options']['deadline'] = _('Deadline');
	$item['options']['private'] = _('Private');
	$item['options']['status'] = _('Status');
	$item['options']['internalstatus'] = _('Internal Status');

	$item['type'] = 'multiple';
	$item['tag'] = _('Fields Dipslayed in Ticket Overview');
	$item['name'] = 'ticketingColumns[]';
	
	if(isset($_POST['ticketingColumns'])) $item['value'] = $_POST['ticketingColumns'];

	$leftForm[] = $item;
	
	
	/* Assign the form variable */
	$smarty->assign('form', true);
	$smarty->assign('leftForm', $leftForm);
	$smarty->assign('rightForm', $rightForm);
	$smarty->assign('bottomForm', $bottomForm);
?>