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
			if(($key == 'restrictedread') || ($key == 'read') || ($key == 'write')) {
				/* This unsets an lower access levels that may have been set */
				if($key == 'restrictedread') $val = array_diff($val, $_POST['read'], $_POST['write']);
				if($key == 'read') $val = array_diff($val, $_POST['write']);
				
				$_SESSION['preferences'][EGS_COMPANY_ID][$key] = $val;
			}
			else if($key == 'accountColumns') $_SESSION['preferences'][$key] = array_merge(array('accountnumber', 'name'), $val);
			else if($key == 'contactColumns') $_SESSION['preferences'][$key] = array_merge(array('name'), $val);
			else if($key=='addressformat') {
				
				switch($val) {
					case "1" : 	$_SESSION['preferences']['addressformat']='street1, street2, street3, town, county, postcode, country';break;
					case "2" : 	$_SESSION['preferences']['addressformat']='street1, street2, street3, postcode, town, county, country';break;
				}
				
				
			}
			else $_SESSION['preferences'][$key] = $val;
		
		}
		if(!isset($_POST['autocreate']))unset($_SESSION['preferences']['autocreate']);
		/* Sync the preferences to the database */
		$egs->syncPreferences();
	}
	
	$_POST = $_SESSION['preferences'];
	
	/* Set up the title */
	$smarty->assign('pageTitle',  _('My Contact Preferences'));

	/* Build the form */

/* Which fields to show*/
	$item = array();

	$item['options'] = array();
	//$item['options']['accountnumber'] = _('Account Number');
	//$item['options']['name'] = _('Account Name');
	$item['options']['address'] = _('Address');
	$item['options']['town'] = _('Town');
	$item['options']['phone'] = _('Phone');
	$item['options']['fax'] = _('Fax');
	$item['options']['email'] = _('Email');
	$item['options']['www'] = _('Website');
	$item['options']['owner'] = _('Owner');
	$item['options']['assigned'] = _('Assigned to');

	$item['type'] = 'multiple';
	$item['tag'] = _('Fields Dipslayed in Account Overview');
	$item['name'] = 'accountColumns[]';
	
	if(isset($_POST['accountColumns'])) $item['value'] = $_POST['accountColumns'];

	$leftForm[] = $item;

	/* Fields for contact overview */
	$item = array();

	$item['options'] = array();
	//$item['options']['name'] = _('Name');
	$item['options']['jobtitle'] = _('Job Title');
	$item['options']['department'] = _('Department');
	$item['options']['company'] = _('Account Name');
	$item['options']['address'] = _('Address');
	$item['options']['phone'] = _('Phone');
	$item['options']['fax'] = _('Fax');
	$item['options']['mobile'] = _('Mobile');
	$item['options']['email'] = _('Email');
	$item['options']['owner'] = _('Owner');
	$item['options']['assigned'] = _('Assigned to');

	$item['type'] = 'multiple';
	$item['tag'] = _('Fields Dipslayed in Contact Overview');
	$item['name'] = 'contactColumns[]';
	
	if(isset($_POST['contactColumns'])) $item['value'] = $_POST['contactColumns'];

	$leftForm[] = $item;

	/* Fields for labels */
	$item = array();

	$item['options'] = array();
	$item['options']['title'] = _('Title');
	$item['options']['firstname'] = _('First Name');
	$item['options']['middlename'] = _('Middle Name');
	$item['options']['surname'] = _('Surname');
	$item['options']['suffix'] = _('Suffix');
	$item['options']['jobtitle'] = _('Job Title');
	$item['options']['department'] = _('Department');
	$item['options']['companyname'] = _('Company Name');
	$item['options']['street1'] = _('Street1');
	$item['options']['street2'] = _('Street2');
	$item['options']['street3'] = _('Street3');
	$item['options']['town'] = _('Town');
	$item['options']['county'] = _('County');
	$item['options']['postcode'] = _('Postcode');
	$item['options']['country'] = _('Country');

	$item['type'] = 'multiple';
	$item['tag'] = _('Fields Displayed in Labels');
	$item['name'] = 'labelColumns[]';
		
	if(isset($_POST['labelColumns'])) $item['value'] = $_POST['labelColumns'];

	$leftForm[] = $item;

	/*Fields for opportunities*/
	$item=array();
	$item['options'] = array();
	$item['options']['name'] = _('Opportunity');
	$item['options']['company'] = _('Account');
	$item['options']['person'] = _('Contact');
	$item['options']['status'] = _('Sales Stage');
	$item['options']['cost'] = _('Amount');
	$item['options']['enddate'] = _('End Date');
	$item['options']['added'] = _('Start Date');
	$item['options']['assigned'] = _('Assigned To');
	$item['options']['owner'] = _('Owner');
	
	$item['type'] = 'multiple';
	$item['tag'] = _('Fields Displayed in Opportunities');
	$item['name'] = 'opportunityColumns[]';
	
	if(isset($_POST['opportunityColumns'])) $item['value'] = $_POST['opportunityColumns'];

	$leftForm[] = $item;
	
	/*Fields for cases*/
	$item=array();
	$item['options'] = array();
	$item['options']['id'] = _('Case Num.');
	$item['options']['name'] = _('Subject');
	$item['options']['company'] = _('Account');
	$item['options']['person'] = _('Contact');
	$item['options']['priority'] = _('Priority');
	$item['options']['status'] = _('Status');
	$item['options']['assigned'] = _('Assigned To');
	$item['options']['owner'] = _('Owner');
	$item['options']['enddate'] = _('Due Date');
	$item['options']['type'] = _('Type');
	
	
	$item['type'] = 'multiple';
	$item['tag'] = _('Fields Displayed in Cases');
	$item['name'] = 'caseColumns[]';
	
	if(isset($_POST['caseColumns'])) $item['value'] = $_POST['caseColumns'];

	$leftForm[] = $item;
	
	/*Fields for activities*/
	$item=array();
	$item['options'] = array();
	
	$item['options']['name'] = _('Name');
	$item['options']['opportunity'] = _('Attached To');
	$item['options']['activity'] = _('Type');
	$item['options']['company'] = _('Account');
	$item['options']['person'] = _('Contact');
	$item['options']['startdate'] = _('Start Date');
	$item['options']['enddate'] = _('End Date');
	$item['options']['completed'] = _('Completed');
	$item['options']['owner'] = _('Owner');
	$item['options']['assigned'] = _('Assigned To');
	
	$item['type'] = 'multiple';
	$item['tag'] = _('Fields Displayed in Activities');
	$item['name'] = 'activityColumns[]';
	
	if(isset($_POST['activityColumns'])) $item['value'] = $_POST['activityColumns'];

	$leftForm[] = $item;
	
	/* Get the groups for read/write access */
	$query = 'SELECT id, name FROM groups WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY name';

	$groups = $db->query($query);

	if(!$groups && EGS_DEBUG_SQL) die($db->ErrorMsg());

	$item['options'] = array();

	while(!$groups->EOF) {
		$item['options'][$groups->fields['id']] = $groups->fields['name'];
		$groups->moveNext();
	}

	$item['type'] = 'multiple';
	$item['tag'] = _('Default Restricted Read Access');
	$item['name'] = 'restrictedread[]';
	if(isset($_POST[EGS_COMPANY_ID]['restrictedread'])) $item['value'] = $_POST[EGS_COMPANY_ID]['restrictedread'];

	$rightForm[] = $item;
	
	/* Read Access */
	$item['tag'] = _('Default Read Access');
	$item['name'] = 'read[]';
	if(isset($_POST[EGS_COMPANY_ID]['read'])) $item['value'] = $_POST[EGS_COMPANY_ID]['read'];
	else $item['value'] = array();

	$rightForm[] = $item;
	
	/* Write Access */
	$item['tag'] = _('Default Write Access');
	$item['name'] = 'write[]';
	if(isset($_POST[EGS_COMPANY_ID]['write'])) $item['value'] = $_POST[EGS_COMPANY_ID]['write'];
	else $item['value'] = array();

	$rightForm[] = $item;
	
	/*Auto-create account numbers*/
	$item=array();
	$item['tag']=_('Auto-Create Account Numbers');
	$item['name']='autocreate';
	$item['type']='checkbox';
	
	if(isset($_POST['autocreate'])&&($_POST['autocreate']=='t'||$_POST['autocreate']=='on'))
		$item['value']='checked';
	$rightForm[]=$item;	


	/*address format*/
	// format 1 = 'street1, street2, street3, town, county, postcode, country';
	// format 2 = 'street1, street2, street3, postcode, town, county, country';
	if (isset($_SESSION['preferences']['addressformat'])&&$_SESSION['preferences']['addressformat']=='street1, street2, street3, postcode, town, county, country')
		$current=2;
	else
		$current=1;
	$item=array();
	$item['type']='radio';
	$item['name']='addressformat';
	$item['tag']=_('Address Format:');
	$item['options']=array('1'=>_('UK'),'2'=>_('Norwegian'));
	$item['value']=$current;
	$rightForm[]=$item;

	/* Assign the form variable */
	$smarty->assign('form', true);
	$smarty->assign('leftForm', $leftForm);
	$smarty->assign('rightForm', $rightForm);
	$smarty->assign('bottomForm', $bottomForm);
?>
