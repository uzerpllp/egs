<?php
	global $db;
	
	/* Set up arrays to hold form elements */
	$leftForm = array();
	//$rightForm = array();
	//$bottomForm = array();
	$errors = array();
	/*Changing Password:*/
	if (isset($_POST)) {
		/*if password is being changed*/
		if((isset($_POST['newpass1'])&&$_POST['newpass1']!='')||(isset($_POST['newpass2'])&&$_POST['newpass2']!='')) {
			if(!isset($_POST['oldpass'])) {
				$errors[] = _('To change your password, you must enter your old password');
			} else
			/*Existing password needs to be correct*/
			if (!checkPassword(EGS_USERNAME,$_POST['oldpass'])) {
				$errors[] = _('Please enter the correct old password');	
			} else
			/*Check passwords match*/
			if($_POST['newpass1']!=$_POST['newpass2']) {
				$errors[] = _('The passwords you entered don\'t match');	
			}
			
			/*No errors, so Change password in database*/
			if (count($errors)==0) {
				$q = 'UPDATE users SET password='.$db->qstr(md5(strip_tags($_POST['newpass1']))).' WHERE username='.$db->qstr(EGS_USERNAME);
				$db->Execute($q);
			}
			
			if (count($errors)>0) {
				$smarty->assign('errors',$errors);	
			}
		
		}
		
		/*other changes (don't need old password entered)*/
		
	}
	
	
	$perpage_array=array(5,10,15,30,50,100);
	/* If the form has been submitted do an update */
	if(sizeof($_POST) > 0) {
		unset($_POST['save']);
		unset($_POST['oldpass']);
		unset($_POST['newpass1']);
		unset($_POST['newpass2']);
		/*process perpage array*/
		$_POST['perpage'] = $perpage_array[$_POST['perpage']];
		
		/* Assign the preferences to the session */	
		while (list ($key, $val) = each($_POST)) {
			$_SESSION['preferences'][$key] = $val;
		}

		/* Sync the preferences to the database */
		$egs->syncPreferences();
	}
	
	$_POST = $_SESSION['preferences'];
	

	/* Set up the title */
	$smarty->assign('pageTitle',  _('My Account'));


	$leftForm = array ();
	
	/* Build the form */
	
	/*old password input*/
	$item = array();
	$item['type'] = 'password';
	$item['tag']=_('Old Password');
	$item['name']='oldpass';
	if(isset($_POST['oldpass']))
		$item['value']=$_POST['oldpass'];

	$leftForm[] = $item;


	/*new password input*/
	$item = array();
	$item['type'] = 'password';
	$item['tag']=_('New Password');
	$item['name']='newpass1';
	if(isset($_POST['newpass1']))
		$item['value']=$_POST['newpass1'];

	$leftForm[] = $item;

	/*reenter password input*/
	$item = array();
	$item['type'] = 'password';
	$item['tag']=_('Reenter Password');
	$item['name']='newpass2';
	if(isset($_POST['newpass2']))
		$item['value']=$_POST['newpass2'];

	$leftForm[] = $item;
	
	/*add a space*/
	$item=array();
	$item['type']='space';
	
	$leftForm[]=$item;
	
	/*how many items per page?*/
	$item=array();
	$item['type'] = 'select';
	$item['tag']  = _('# Items Per Page');
	$item['name'] = 'perpage';
	//$item['options'] = array('5','10','15','25','50','100');
	$item['options'] = $perpage_array;
	if(isset($_POST['perpage'])) {
		$pparray=array_flip($perpage_array);
		
		$item['value'] = $pparray[$_POST['perpage']];
		
	} else {
		$item['value'] = 2;
	}
	$leftForm[]=$item;
	 
	/*what language?*/
	$item=array();
	$item['type'] = 'select';
	$item['tag']  = _('Language');
	$item['name'] = 'language';
	
	$q = "SELECT code, name FROM lang";
	$languages = $db->Execute($q);
	$item['options'] = array();
	
	while(!$languages->EOF) {
		$item['options'][$languages->fields['code']] = $languages->fields['name'];
		$languages->MoveNext();
		
	}
	$item['value'] = $_SESSION['EGS_LANG'];
	$leftForm[]=$item;
	
	/* Assign the form variable */
	$smarty->assign('form', true);
	$smarty->assign('leftForm', $leftForm);
	//$smarty->assign('rightForm', $rightForm);
	//$smarty->assign('bottomForm', $bottomForm);
	
	function checkPassword($username, $password) {
		global $db;
		$q = 'SELECT username FROM users WHERE username='.$db->qstr($username).' AND password='.$db->qstr(md5(strip_tags($password)));
		$check = $db->GetRow($q);
		if(isset($check['username'])&&$check['username']!='') {
			return true;	
		}
		return false;
	}
	
?>
