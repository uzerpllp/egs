<?php
// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Save User 1.0                    |
// +----------------------------------------------------------------------+
// | Copyright (c) 2002-2005 Senokian Solutions                           |
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
if (isset ($_GET['id'])) {
	$username = urldecode($_GET['id']);
	$edit=true;
}
if (isset ($_POST['username']))
	$username = ($_POST['username']);

require_once(EGS_FILE_ROOT.'/src/classes/class.admin.php');

$admin = new admin();
if(isset($username))
$q = 'SELECT username FROM useraccess WHERE username='.$db->qstr($username).' AND companyid='.$db->qstr(EGS_COMPANY_ID);
//$q = 'SELECT username FROM useraccess WHERE username='.$db->qstr($username).' AND companyid=2';
if (isset($q)&&$db->GetOne($q)||(!isset($username)||!isset($_GET['id']))) {
	$allowed=true;	
}
else {
	$allowed=false;
	
}	

/* Check that the admin is enabled, and the correct permissions are valid for the admin. */

if (in_array('admin', $_SESSION['modules']) && $allowed) {
	/* Set up the variables for the form */
	$saved = false;
	$select = false;
	if(!isset($id)) $id = null;

	/* Do a save if the form has been posted */
	if (sizeof($_POST) > 0) {
		/* Check the post array */
		$egs->checkPost();

		/* If deleting, delete. otherwise save*/
		if(isset($_POST['delete'])) $saved = $admin->deleteUser($id);
		else if(!isset($_POST['delete'])) $saved = $admin->saveUser($_POST);

	}

	/* Redirect to the admin view if the form saved successfully */
	if ($saved) {
		$smarty->assign('redirect', true);
		$smarty->assign('redirectAction', '');
	} else {
		/* Set up arrays to hold form elements */
		$leftForm = array ();
		$rightForm = array ();
		$bottomForm = array ();

		/* We are editing the admin so check access and get the data */
		if (isset($username)) {
			
			//$query = 'SELECT * FROM useroverview WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' username='.$db->qstr($username);
			$query = 'SELECT * FROM company'.EGS_COMPANY_ID.'.users cu join useroverview o on o.username=cu.username,  WHERE o.username='.$db->qstr($username); 
			
			$query = 'select e.*, cu.*, o.* from useroverview o LEFT OUTER JOIN company'.EGS_COMPANY_ID.'.users cu on (o.username=cu.username) LEFT OUTER JOIN company'.EGS_COMPANY_ID.'.erpusers e on (e.userid=o.username) where o.username='.$db->qstr($username);
			$_POST = $db->GetRow($query);

			/*need to decode the modulesallowed thing for weberp*/
			
			if(isset($_POST['modulesallowed'])) $modules_array=explode(",",$_POST['modulesallowed']);
			else $modules_array = array();
			
			$temp_array = array('orders','receivables','payables','purchasing','inventory','manufacturing','ledger','setup');
			for ($i=0;$i<count($modules_array);$i++) {
				if(isset($temp_array[$i])) {
					$name=$temp_array[$i];
					$index = 'display_'.$name;
					if($modules_array[$i]==1) {
						$_POST[$index]='t';
					}
				}
				
			}
			
			/*get groups from database*/
			$q = 'SELECT groupid FROM groupmembers WHERE username='.$db->qstr($username);
			$rs=$db->Execute($q);
			while (!$rs->EOF) {
				$_POST['groups'][] = $rs->fields['groupid'];
				$rs->MoveNext();
			}
			if(isset($_POST['homedir']))$_POST['dochome']=$_POST['homedir'];
			if(isset($_POST['firstdir']))$_POST['docinit']=$_POST['firstdir'];

			$select = true;
			
		}
/*displaying the page*/
		/* Set up the title */
		if (isset ($_GET['id'])) {
			$smarty->assign('pageTitle', _('Save Changes to User'));
		}
		else {
			$smarty->assign('pageTitle', _('Save New User'));
		}

		/* Show the delete button if editing */
		/*don't, because deleting users gets messy and you can just stop them logging in*/
		//if(isset($username)) $smarty->assign('formDelete', true);

		/* Add any hidden fields we need */
		$hidden = array ();
		if (isset ($username)) {
			$hidden['olduser'] = $username;
			$hidden['username'] = $username;
		}
		
		
		
		/* Setup the admin subject */
		$item = array ();
		$item['type'] = 'text';
		$item['tag'] = _('Username');
		$item['name'] = 'username';
		if (isset($_GET['id']) ){
			$item['value'] = $username;
			$item['type'] = 'noedit';
		} else if (isset($_POST['username'])) {
			$item['value']=$_POST['username'];	
		}
			
		$item['compulsory'] = true;

		$leftForm[] = $item;
		
		/* Setup the people */
		$item = array ();
		/*don't allow this to change if you're editing*/
		if(!isset($_GET['id'])) {
			$query = 'SELECT id, firstname || \' \' || surname AS name FROM person WHERE userdetail=false AND (usercompanyid='.$db->qstr(EGS_COMPANY_ID).' OR (companyid='.$db->qstr(EGS_COMPANY_ID).')) ORDER BY name';
			$people = $db->query($query);
	
			if (!$people && EGS_DEBUG_SQL)
				die($db->ErrorMsg());
	
			$item['options'] = array ();
	
			while (!$people->EOF) {
				$item['options'][$people->fields['id']] = $people->fields['name'];
				$people->MoveNext();
			}
	
			$item['type'] = 'select';
			$item['tag'] = _('Person');
			$item['name'] = 'personid';
			if (isset ($_POST['name'])&&isset($_POST['personid'])) {
				$item['value'] = $_POST['personid'];
			}
		}
		else {
			$item['type']='noedit';
			$item['tag']=_('Person');
			if(isset($_POST['name']))$item['value'] = $_POST['name'];
			
		}
		$leftForm[] = $item;
		/*login-enabled checkbox*/
		$item = array();
        $item['type'] = 'checkbox';
        $item['tag'] = _('Login Enabled');
        $item['name'] = 'access';
        if(isset($_POST['access']) && (($_POST['access'] == 'on') || ($_POST['access'] == 'true'))) $item['value'] = true;
        if(!isset($username)) $item['value'] = true;

		$leftForm[] = $item;
		
		
		
		/*checkboxes for different admin-types*/
		$item = array();
        $item['type'] = 'space';

		$leftForm[] = $item;
		
		$item = array();
        $item['type'] = 'checkbox';
        $item['tag'] = _('SuperUser');
        $item['name'] = 'superuser';
        if(isset($_POST['superuser']) && (($_POST['superuser'] == 'on') || ($_POST['superuser'] == 'true'))) $item['value'] = true;

		$leftForm[] = $item;
		
		$item = array();
        $item['type'] = 'checkbox';
        $item['tag'] = _('Domain Admin');
        $item['name'] = 'domainuser';
        if(isset($_POST['domainuser']) && (($_POST['domainuser'] == 'on') || ($_POST['domainuser'] == 'true'))) $item['value'] = true;

		$leftForm[] = $item;
		
		$item = array();
        $item['type'] = 'checkbox';
        $item['tag'] = _('Project Manager');
        $item['name'] = 'projectmanager';
        if(isset($_POST['projectmanager']) && (($_POST['projectmanager'] == 'on') || ($_POST['projectmanager'] == 'true'))) $item['value'] = true;

		$leftForm[] = $item;
		
		$item = array();
        $item['type'] = 'checkbox';
        $item['tag'] = _('Ticket Admin');
        $item['name'] = 'ticketadmin';
        if(isset($_POST['ticketadmin']) && (($_POST['ticketadmin'] == 'on') || ($_POST['ticketadmin'] == 'true'))) $item['value'] = true;

		$leftForm[] = $item;
		
		$item = array();
        $item['type'] = 'checkbox';
        $item['tag'] = _('Calendar Admin');
        $item['name'] = 'calendaradmin';
        if(isset($_POST['calendaradmin']) && (($_POST['calendaradmin'] == 'on') || ($_POST['calendaradmin'] == 'true'))) $item['value'] = true;

		$leftForm[] = $item;
		
		$item = array();
        $item['type'] = 'checkbox';
        $item['tag'] = _('CRM Admin');
        $item['name'] = 'crmadmin';
        if(isset($_POST['crmadmin']) && (($_POST['crmadmin'] == 'on') || ($_POST['crmadmin'] == 'true'))) $item['value'] = true;

		$leftForm[] = $item;
		
		/*get options for group choices*/
		$item = array ();

		$query = 'SELECT id, name FROM groups WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY name';
		
		$groups = $db->query($query);

		if (!$groups && EGS_DEBUG_SQL)
			die($db->ErrorMsg());

		$item['options'] = array ();

		while (!$groups->EOF) {
			$item['options'][$groups->fields['id']] = $groups->fields['name'];
			$groups->MoveNext();
		}
		$grouparray=$item['options'];
		/*multiple for groups*/
		$item['type'] = 'multiple';
		$item['tag'] = _('Groups');
		$item['name'] = 'groups[]';
		if (isset ($_POST['groups']))
			$item['value'] = $_POST['groups'];

		$leftForm[] = $item;
		/* if editing a user, check the user has access to the module
		 * otherwise, there's no point displaying the module-specific options
		 *  */
		 if(!isset($edit))$edit=false;
		 $showowl=false;
		 $showerp=false;
		 if($edit) {
		 	if(isset($_POST['superuser'])&&$_POST['superuser']=='true') {
		 		$showowl=true;
		 		$showerp=true;
		 	}
		 	$q = 'select username from groupmembers gm, groupmoduleaccess gma, module m where gm.groupid=gma.groupid AND gma.moduleid=m.id AND username='.$db->qstr($username).' AND m.name='.$db->qstr('filesharing');
			if($db->GetOne($q))
			
	
			$q = 'select username from groupmembers gm, groupmoduleaccess gma, module m where gm.groupid=gma.groupid AND gma.moduleid=m.id AND username='.$db->qstr($username).' AND m.name='.$db->qstr('weberp');
		 	if($db->GetOne($q))
				$showerp=true;
		 	
		 }
		 else {
		 	
		 	$showowl=true;
		 	$showerp=true;
		 }
		if(in_array('filesharing', $_SESSION['modules'])&&$showowl) {
			
			$hidden['allowowl']='yes';
			$item=array();
			$item['type'] = 'title';
			$item['tag'] = "Filesharing";
			$leftForm[]=$item;
			/*select for primary group*/
			
			$item=array();
			$item['type'] = 'select';
			$item['tag'] = _('Primary Group');
			$item['name'] = 'primgroup';
			if (isset ($_POST['primgroup']))
				$item['value'] = $_POST['primgroup'];
			$item['options']=$grouparray;
			$leftForm[] = $item;
			
			/*select for owl folders*/
			$item = array();
			$q = 'SELECT id, name FROM '.'company'.EGS_COMPANY_ID.'.folders';
			$folders = $db->Execute($q);
			
			if (!$folders && EGS_DEBUG_SQL)
				die($db->ErrorMsg());
				
			$item['options'] = array();
			$count=0;
			while (!$folders->EOF) {
				if($folders->fields['name'] == 'Documents/company'.EGS_COMPANY_ID)
					$item['options'][$folders->fields['id']] = 'Documents';
				else if($count==0)
					$item['options'][$folders->fields['id']] = $folders->fields['name'];
				else
					$item['options'][$folders->fields['id']] = '--|'.$folders->fields['name'];	
				$folders->MoveNext();
				$count++;
			}
			$item['type']='select';
			$item['tag']= _('User\'s Home Dir');
			$item['name'] = 'dochome';
			
			if(isset($_POST['dochome']))
				$item['value']=$_POST['dochome'];
			
			$leftForm[]=$item;
			
			$item['tag'] = _('User\'s Initial Dir');
			$item['name'] = 'docinit';
			
			if(isset($_POST['docinit']))
				$item['value']=$_POST['docinit'];
			
			$leftForm[]=$item;
			
			/*quota input- owl has this*/
			$item = array ();
			$item['type'] = 'text';
			$item['tag'] = _('Quota (0=disabled)');
			$item['name'] = 'quota';
			if (isset ($_POST['quota']))
				$item['value'] = $_POST['quota'];
			else 
				$item['value'] = 0;
	
			$leftForm[] = $item;
			
			/*max sessions input- owl has this*/
			$item = array ();
			$item['type'] = 'text';
			$item['tag'] = _('Max Sessions');
			$item['name'] = 'maxsessions';
			if (isset ($_POST['maxsessions']))
				$item['value'] = $_POST['maxsessions']+1;
			else 
				$item['value'] = 1;
	
			$leftForm[] = $item;
			
			/*receive Notifications checkbox- owl has this*/
			$item = array();
	        $item['type'] = 'checkbox';
	        $item['tag'] = _('Receive Notifications');
	        $item['name'] = 'recnotif';
	        if(isset($_POST['recnotif']) && (($_POST['recnotif'] == '1') || ($_POST['recnotif'] == 't'))) $item['value'] = true;
	
			$leftForm[] = $item;
			
			/*attach file checkbox- owl has this*/
			$item = array();
	        $item['type'] = 'checkbox';
	        $item['tag'] = _('Attach File');
	        $item['name'] = 'attach';
	        if(isset($_POST['attach']) && (($_POST['attach'] == '1') || ($_POST['attach'] == 't'))) $item['value'] = true;
	
			$leftForm[] = $item;
			
			/*Attach file- owl has this*/
			$item = array();
	        $item['type'] = 'checkbox';
	        $item['tag'] = _('Attach File');
	        $item['name'] = 'attachfile';
	        if(isset($_POST['attachfile']) && (($_POST['attachfile'] == '1') || ($_POST['attachfile'] == 't'))) $item['value'] = true;
	
			$leftForm[] = $item;
			
			/*No Preference Access- owl has this*/
			$item = array();
	        $item['type'] = 'checkbox';
	        $item['tag'] = _('Disable Pref');
	        $item['name'] = 'nopreffaccess';
	        if(isset($_POST['nopreffaccess']) && (($_POST['noprefaccess'] == '1') || ($_POST['noprefaccess'] == 't'))) $item['value'] = true;
	
			$leftForm[] = $item;
			/*Comment- owl has this*/
			$item = array();
	        $item['type'] = 'checkbox';
	        $item['tag'] = _('Comment Notification');
	        $item['name'] = 'comment_notify';
	        if(isset($_POST['comment_notify']) && (($_POST['comment_notify'] == '1') || ($_POST['comment_notify'] == 't'))) $item['value'] = true;
	
			$leftForm[] = $item;
			
		}
		
		if(in_array('weberp', $_SESSION['modules'])&& $showerp) {
			
			$hidden['allowerp']='yes';
			$item=array();
			$item['type'] = 'title';
			$item['tag'] = "WebERP";
			$leftForm[]=$item;
			
			$item=array();
			$item['type'] = 'select';
			$item['name'] = 'fullaccess';
			$item['tag'] = _('Access Level');
			
			$item['options'] = array();
				$q = 'SELECT secroleid, secrolename FROM company'.EGS_COMPANY_ID.'.securityroles';
				
				$roles = $db->Execute($q);
				while(!$roles->EOF) {
					$item['options'][$roles->fields['secroleid']] = $roles->fields['secrolename'];
					$roles->MoveNext();	
					
				}
			if(isset($_POST['fullaccess']))
				$item['value']=$_POST['fullaccess'];
			$leftForm[] = $item;
			
			$item=array();
			$item['type'] = 'select';
			$item['name'] = 'pagesize';
			$item['tag'] = _('Paper Size');
			$item['options'] = array();
				$item['options']['A4']='A4';
				$item['options']['A3']='A3';
				$item['options']['A3 Landscape']='A3 Landscape';
				$item['options']['Letter']='Letter';
				$item['options']['Letter Landscape']='Letter Landscape';
				$item['options']['Legal']='Legal';
				$item['options']['Legal Landscape']='Legal Landscape';
			if(isset($_POST['pagesize']))
				$item['value']=$_POST['pagesize'];
			$leftForm[] = $item;
			
			$item=array();
			$item['type'] = 'select';
			$item['name'] = 'defaultlocation';
			$item['tag'] = _('Default Location');
			$item['options'] = array();
				$q = 'SELECT loccode, locationname FROM company'.EGS_COMPANY_ID.'.locations';
				$locations=$db->Execute($q);
				while(!$locations->EOF) {
					$item['options'][$locations->fields['loccode']]=$locations->fields['locationname'];
					$locations->MoveNext();	
				}
			if(isset($_POST['defaultlocation']))
				$item['value']=$_POST['defaultlocation'];
			$leftForm[] = $item;
			
			/*Check box for each module*/
			$item = array();
			$item['type'] = 'checkbox';
			$item['tag'] = _('Display Orders Option');
			$item['name'] = 'display_orders';
			if(isset($_POST['display_orders']))  $item['value'] = true;
			$leftForm[]=$item;
			
			$item = array();
			$item['type'] = 'checkbox';
			$item['tag'] = _('Display Receivables Option');
			$item['name'] = 'display_receivables';
			if(isset($_POST['display_receivables']))  $item['value'] = true;
			$leftForm[]=$item;
			
			$item = array();
			$item['type'] = 'checkbox';
			$item['tag'] = _('Display Payables Option');
			$item['name'] = 'display_payables';
			if(isset($_POST['display_payables']))  $item['value'] = true;
			$leftForm[]=$item;
			
			$item = array();
			$item['type'] = 'checkbox';
			$item['tag'] = _('Display Purchasing Option');
			$item['name'] = 'display_purchasing';
			if(isset($_POST['display_purchasing']))  $item['value'] = true;
			$leftForm[]=$item;
			
			$item = array();
			$item['type'] = 'checkbox';
			$item['tag'] = _('Display Inventory Option');
			$item['name'] = 'display_inventory';
			if(isset($_POST['display_inventory']))  $item['value'] = true;
			$leftForm[]=$item;
			
			$item = array();
			$item['type'] = 'checkbox';
			$item['tag'] = _('Display Manufacturing Option');
			$item['name'] = 'display_manufacturing';
			if(isset($_POST['display_manufacturing']))  $item['value'] = true;
			$leftForm[]=$item;
			
			$item = array();
			$item['type'] = 'checkbox';
			$item['tag'] = _('Display General Ledger Option');
			$item['name'] = 'display_ledger';
			if(isset($_POST['display_ledger']))  $item['value'] = true;
			$leftForm[]=$item;
			
			$item = array();
			$item['type'] = 'checkbox';
			$item['tag'] = _('Display Setup Option');
			$item['name'] = 'display_setup';
			if(isset($_POST['display_setup']))  $item['value'] = true;
			$leftForm[]=$item;
		}
		/* Assign the form variable */
		$smarty->assign('hidden', $hidden);
		$smarty->assign('form', true);
		$smarty->assign('leftForm', $leftForm);
		$smarty->assign('rightForm', $rightForm);
		$smarty->assign('formId', 'saveform');
	}
}
else {
	
	if ($allowed)$errors[] = _('You don\'t have access to edit users');
	else $errors[]= _('You don\'t have access to edit users of this company');
	$smarty->assign('errors',$errors);	
	$smarty->assign('redirect', true);
	$smarty->assign('redirectAction', '');
}

?>
