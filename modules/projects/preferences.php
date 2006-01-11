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

		/* Sync the preferences to the database */
		$egs->syncPreferences();
	}
	else $_POST = $_SESSION['preferences'];
	
	/* Set up the title */
	$smarty->assign('pageTitle',  _('My Project Preferences'));
	
	/* Which fields to show*/
	$item = array();

	$item['options'] = array();
	$item['options']['jobno'] = _('Job Num.');
	$item['options']['name'] = _('Job Name');
	$item['options']['companyname'] = _('Account');
	$item['options']['personname'] = _('Contact');
	$item['options']['categoryname'] = _('Category');
	$item['options']['startdate'] = _('Start Date');
	$item['options']['enddate'] = _('Due Date');
	$item['options']['actualenddate'] = _('Actual End Date');
	$item['options']['hours'] = _('Hours');
	$item['options']['completed'] = _('Completed');
	$item['options']['invoiced'] = _('Invoiced');
	$item['options']['archived'] = _('Archived');

	$item['type'] = 'multiple';
	$item['tag'] = _('Fields Dipslayed in Project Overview');
	$item['name'] = 'projectColumns[]';
	
	if(isset($_POST['projectColumns'])) $item['value'] = $_POST['projectColumns'];

	$leftForm[] = $item;

	/* Assign the form variable */
	$smarty->assign('form', true);
	$smarty->assign('leftForm', $leftForm);
?>
