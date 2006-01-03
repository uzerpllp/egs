<?php


// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Calendar Admin 1.0               |
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
// | 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA               |
// +----------------------------------------------------------------------+
// | Author: Jake Stride <jake.stride@senokian.com>                       |
// +----------------------------------------------------------------------+
// | 1.0                                                                  |
// | ===                                                                  |
// | First Stable Release                                                 |
// +----------------------------------------------------------------------+

class admin {
	/**
	 * constructor
	 * */
	function admin() {
		/* Bring in the DB */
		global $db;
		$this->db = $db;
	}

	/**
	 * save the Message of the Day to the database
	 * 
	 * @return boolean
	 * */
	function saveMOTD($_POST) {
		global $smarty;

		$motd = array ();

		$motd['headline'] = 'MOTD';
		$motd['teaser'] = 'MOTD';

		if (!isset ($_POST['body']))
			$motd['body'] = '';
		else
			$motd['body'] = $_POST['body'];

		$motd['motd'] = 'true';
		$motd['companyid'] = EGS_COMPANY_ID;

		$this->db->Replace('news', $motd, array ('companyid', 'motd'), true);

		$smarty->assign('messages', array (_('MOTD successfully updated')));

		return true;
	}

	/**
	 * function to save a newsitem/announcement to the database
	 * 
	 * @return boolean
	 * */
	function saveNews($_POST, $announcement = false) {
		global $smarty;

		$errors = array ();
		print_r($_POST);
		if (!isset ($_POST['headline']))
			$errors[] = _('Please enter a headline it is a compulsory field');
		if (!isset ($_POST['published']))
			$errors[] = _('Please enter a published date it is a compulsory field');
		if ((isset ($_POST['showfrom']) && (isset ($_POST['showuntil']))) && (strtotime($_POST['showfrom']) >= strtotime($_POST['showuntil'])))
			$errors[] = _('Please ensure that the show from time is before the show until time');
		$matches=array();
		preg_match("/(\d{4}-\d{2}-\d{2} \d{2}:\d{2})[\s|\S]*/",$_POST['published'],$matches);
		$_POST['published']=$matches[1];
		/* It is OK to do the save */
		if (sizeof($errors) == 0) {
			$article = array ();

			if (isset ($_POST['id']))
				$mode = 'UPDATE';
			else
				$mode = 'INSERT';

			if ($mode == 'INSERT')
				$article['id'] = $this->db->GenID('news_id_seq');
			else
				$article['id'] = $_POST['id'];

			$article['headline'] = $_POST['headline'];
			$article['published'] = $_POST['published'];
			$article['body'] = $_POST['body'];
			if (isset ($_POST['visible']))
				$article['visible'] = 'true';
			else
				$article['visible'] = 'false';

			if (isset ($_POST['showfrom']))
				$article['showfrom'] = $_POST['showfrom'];
			if (isset ($_POST['showuntil']))
				$article['showuntil'] = $_POST['showuntil'];

			$article['companyid'] = EGS_COMPANY_ID;
			$article['alteredby'] = EGS_USERNAME;
			$article['updated'] = date('Y-m-d H:i', time());
			$article['teaser'] = '';

			if ($announcement)
				$article['news'] = 'false';
			
			if(!$this->db->Replace('news', $article, 'id', true)) {
				$errors[]=_('Error Saving News');
				$smarty->assign('errors', $errors);
				return false;
			}
		
			if ($announcement)
				$smarty->assign('messages', array (_('Announcement Successfully Saved')));
			else
				$smarty->assign('messages', array (_('News Article Successfully Saved')));

			return true;
		} else {
			$smarty->assign('errors', $errors);

			return false;
		}
	}

	/**
	 * function to delete a news item/announcement from the database
	 * */
	function deleteNews($id, $announcement = false) {
		global $smarty;

		$query = 'DELETE FROM news WHERE id='.$this->db->qstr($id).' AND motd=false AND domainid IS NULL AND companyid='.$this->db->qstr(EGS_COMPANY_ID);

		if ($announcement)
			$query .= ' AND news=false';

		$this->db->Execute($query);

		if ($announcement)
			$smarty->assign('messages', array (_('Announcement Successfully Deleted')));
		else
			$smarty->assign('messages', array (_('News Item Successfully Deleted')));

		return true;
	}

	/**
	 * Checks if the supplied username is already used within the system
	 * 
	 * Note: Usernames must be unique within the entire system, not just within companies
	 *  
	 * @return boolean
	 * */
	function freeUsername($username) {
		$query = 'SELECT username FROM users WHERE username='.$this->db->qstr($username);

		if ($this->db->GetOne($query) !== false)
			return false;
		else
			return true;
	}
	/**
	 * Deletes a group from the database
	 * 
	 * @return boolean
	 * */
	function deleteGroup($groupid) {
		global $smarty;
		/*check group belongs to EGS_USERNAME's company*/
		$q = 'SELECT id FROM groups WHERE id='.$this->db->qstr($groupid).' AND companyid='.$this->db->qstr(EGS_COMPANY_ID);

		if (!$this->db->GetOne($q)) {
			$smarty->assign('errors', array (_('You don\'t have permission to delete groups from this company')));
			return false;
		}
		/*else...*/

		/*check access level*/
		if (in_array('admin', $_SESSION['modules'])) {
			$q = 'DELETE FROM groups WHERE id='.$this->db->qstr($groupid);

			$this->db->Execute($q);
			$smarty->assign('messages', array (_('Group deleted successfully')));
			return true;
		}
		$smarty->assign('errors', array (_('You don\'t have permission to delete groups')));
		return false;
	}
	/**
	 * Save a group
	 * 
	 * @return boolean
	 * */
	function saveGroup($_POST, $id = null) {
		global $smarty;
		$errors = array ();
		if (!isset ($_POST['name']))
			$errors[] = _('No Group name');

		if (count($errors) == 0) {
			$this->db->StartTrans();

			if (!isset ($id)) {
				$mode = "INSERT";
				$id = $this->db->GenID('groups_id_seq');

			} else
				$mode = "UPDATE";
			/*update to groups*/
			$groups = array ();

			$groups['id'] = $id;
			$groups['name'] = $_POST['name'];
			$groups['companyid'] = EGS_COMPANY_ID;
			if (!$this->db->Replace('groups', $groups, array ('name', 'companyid'), true))
				$errors[] = _('Error Updating groups');

			/*update to groupmembers*/
			/*delete all entries for the particular groupid*/
			$q = 'DELETE FROM groupmembers WHERE groupid='.$this->db->qstr($id);
			$rs = $this->db->Execute($q);
			if(isset($_POST['users']))
				$users = $_POST['users'];
			/*cycle through users adding an entry to groupmembers*/
			if(isset($users)&&is_array($users)&&count($users)>0) {
				$q = 'INSERT INTO groupmembers (groupid,username) VALUES (?,?)';
				$stmt = $this->db->Prepare($q);
				while ($username = array_pop($users)) {
	
					if (!$this->db->Execute($stmt, array ($id, $username)))
						$errors[] = _('Error Updating groupmembers');
	
				}
			}
			/*update to groupmoduleaccess*/
			/*first, delete all entries for the particular group*/
			$q = 'DELETE FROM groupmoduleaccess WHERE groupid='.$this->db->qstr($id);
			$rs = $this->db->Execute($q);
			if (isset ($_POST['modules']))
				$modules = $_POST['modules'];
			if(isset($modules)&&is_array($modules)&&count($modules)>0) {
				$q = 'INSERT INTO groupmoduleaccess (groupid,moduleid) VALUES (?,?)';
				$stmt = $this->db->Prepare($q);
				$groupmoduleaccess = array ();
				while ($moduleid = array_pop($modules)) {
	
					if (!$this->db->Execute($stmt, array ($id, $moduleid)))
						$errors[] = _('Error Updating groupmoduleaccess');
	
				}
			}
			$this->db->CompleteTrans();
		}
		if (sizeof($errors) == 0) {
			$messages = array ();
			if ($mode == 'INSERT')
				$messages[] = _('Group Successfully Added');
			else
				$messages[] = _('Group Successfully Updated');

			$smarty->assign('messages', $messages);
			return true;
		} else {
			$smarty->assign('errors', $errors);
			return false;
		}
	}
	/**
	 * Save a user
	 * 
	 * @return boolean
	 * 
	 * @todo: flyspray-specific data isn't saved at the moment (commented out)
	 * */
	function saveUser($_POST) {

		global $smarty;
		$errors = array ();
		//echo '<pre>';print_r($_POST);die();	

		/* Check details are valid  - starting with the username */
		if (!isset ($_POST['username']))
			$errors[] = _('No Username');
		else
			if (!isset ($_POST['olduser']) && !$this->freeUsername($_POST['username'])) {
				$errors[] = _('The username is already in use');
			}

		/* No errors so we can save */
		if (sizeof($errors) == 0) {

			/*Insert to */
			$this->db->StartTrans();

			$now = date("Y-m-d H:i:s");
			/*some of $_POST goes into the owlusers table,
			  setting it up here before anything in $_POST gets unset*/

			if (isset ($_POST['quota'])) {
				$owl['quota_current'] = $_POST['quota'];
			} else {
				$owl['quota_current'] = 0;
			}
			unset ($_POST['quota']);
			if (isset ($_POST['attachfile'])) {
				$owl['attachfile'] = 1;
			} else {
				$owl['attachfile'] = 0;
			}
			unset ($_POST['attachfile']);
			if (isset ($_POST['noprefaccess'])) {
				$owl['noprefaccess'] = 1;
			} else {
				$owl['noprefaccess'] = 0;
			}
			unset ($_POST['noprefaccess']);
			if (isset ($_POST['maxsessions'])) {
				$owl['maxsessions'] = $_POST['maxsessions'] - 1; /*it does this in the owl file*/
			} else {
				$owl['maxsessions'] = 0; /*i.e. 1 session*/
			}
			unset ($_POST['maxsessions']);
			$owl['curlogin'] = $now;
			$owl['lastlogin'] = $now;
			if (isset ($_POST['recnotif'])) {
				$owl['notify'] = 1;
			} else {
				$owl['notify'] = 0;
			}
			unset ($_POST['recnotif']);
			if (isset ($_POST['comment_notify'])) {
				$owl['comment_notify'] = 1;
			} else {
				$owl['comment_notify'] = 0;
			}
			unset ($_POST['comment_notify']);
			if(isset($_POST['dochome'])) {
				$owl['homedir'] = $_POST['dochome'];
				unset ($_POST['dochome']);
			}
			if(isset($_POST['docinit'])) {
				$owl['firstdir'] = $_POST['docinit'];
				unset ($_POST['docinit']);
			}
			$owl['username'] = $_POST['username'];
			
			if(isset($_POST['primgroup'])) {
				$owl['groupid'] = $_POST['primgroup'];
				unset ($_POST['primgroup']);
			}
			unset ($_POST['save']);
			if (isset ($_POST['email'])) {
				$email = $_POST['email'];
				unset ($_POST['email']);
			}
			/*no default is set, but a buttonstyle is needed for anything to work, how silly
			 * (it doesn't even seem to actually do anything...but who knows)
			 * */
			$owl['buttonstyle']='Blue';
			/*get erp data out of $_POST*/
			if (isset ($_POST['fullaccess']))
				$erp['fullaccess'] = $_POST['fullaccess'];
			unset ($_POST['fullaccess']);
			if (isset ($_POST['pagesize']))
				$erp['pagesize'] = $_POST['pagesize'];
			unset ($_POST['pagesize']);
			if (isset ($_POST['defaultlocation']))
				$erp['defaultlocation'] = $_POST['defaultlocation'];
			unset ($_POST['defaultlocation']);
			/*put the data from the checkboxes into a comma-separated string of 1s and 0s*/
			$modules = '';
			if (isset ($_POST['display_orders']))
				$modules .= '1,';
			else
				$modules .= '0,';
			if (isset ($_POST['display_receivables']))
				$modules .= '1,';
			else
				$modules .= '0,';
			if (isset ($_POST['display_payables']))
				$modules .= '1,';
			else
				$modules .= '0,';
			if (isset ($_POST['display_purchasing']))
				$modules .= '1,';
			else
				$modules .= '0,';
			if (isset ($_POST['display_inventory']))
				$modules .= '1,';
			else
				$modules .= '0,';
			if (isset ($_POST['display_manufacturing']))
				$modules .= '1,';
			else
				$modules .= '0,';
			if (isset ($_POST['display_ledger']))
				$modules .= '1,';
			else
				$modules .= '0,';
			if (isset ($_POST['display_setup']))
				$modules .= '1,';
			else
				$modules .= '0,';

			$erp['modulesallowed'] = $modules;
			unset ($_POST['display_orders']);
			unset ($_POST['display_receivables']);
			unset ($_POST['display_payables']);
			unset ($_POST['display_purchasing']);
			unset ($_POST['display_inventory']);
			unset ($_POST['display_manufacturing']);
			unset ($_POST['display_ledger']);
			unset ($_POST['display_setup']);

			$erp['userid'] = $_POST['username'];

			if (isset ($_POST['allowowl']))
				$allowowl = true;
			if (isset ($_POST['allowerp']))
				$allowerp = true;
			unset ($_POST['allowowl']);
			unset ($_POST['allowerp']);

			if (isset ($_POST['olduser'])) {
				$mode = 'UPDATE';
				unset ($_POST['olduser']);
			} else {
				$mode = 'INSERT';
				$personId = $_POST['personid'];
			}

			if ($mode == 'INSERT') {
				/*For new users, add them to the users table*/
				$password = $this->generatePassword();
				$user['password'] = md5($password);
				$user['username'] = $_POST['username'];
				$user['lastcompanylogin'] = EGS_COMPANY_ID;

				if (!$this->db->Replace('users', $user, array ('username'), true))
					$errors[] = _('Error inserting user');

				/*For new users, edit the person table to tell it the person is a user*/
				$query = 'UPDATE person SET owner='.$this->db->qstr($_POST['username']).',  userdetail=true WHERE id='.$this->db->qstr($personId);
				if (!$this->db->Execute($query))
					$errors[] = _('Error assigning user to a person');
			}
			/*change the user's email address*/

			if (isset ($_POST['personid']))
				unset ($_POST['personid']);

			if (isset ($_POST['access']))
				$_POST['access'] = 't';
			else
				$_POST['access'] = 'f';

			if (isset ($_POST['groups']))
				$groups = $_POST['groups'];
			unset ($_POST['groups']);

			$_POST['companyid'] = EGS_COMPANY_ID;

			/*useraccess insert/update*/

			if (isset ($_POST['projectmanager']))
				$_POST['projectmanager'] = 't';
			else
				$_POST['projectmanager'] = 'f';
			if (isset ($_POST['superuser']))
				$_POST['superuser'] = 't';
			else
				$_POST['superuser'] = 'f';
			if (isset ($_POST['domainuser']))
				$_POST['domainuser'] = 't';
			else
				$_POST['domainuser'] = 'f';
			if (isset ($_POST['ticketadmin']))
				$_POST['ticketadmin'] = 't';
			else
				$_POST['ticketadmin'] = 'f';
			if (isset ($_POST['crmadmin']))
				$_POST['crmadmin'] = 't';
			else
				$_POST['crmadmin'] = 'f';
			if (isset ($_POST['calendaradmin']))
				$_POST['calendaradmin'] = 't';
			else
				$_POST['calendaradmin'] = 'f';
			if (!$this->db->Replace('useraccess', $_POST, array ('username', 'companyid'), true))
				$errors[] = _('Error saving user access');

			/* If the company has access to flyspray we need to do this to ensure the user is always in
			 * the gloabl admin group when they are a project admin, otherwise it will break.
			 */
			//if($this->db->GetOne('SELECT tablename FROM pg_tables WHERE schemaname=\'company'.EGS_COMPANY_ID.'\' AND tablename LIKE \'flyspray_%\'')) {
			/* User is no longer an admin so delete them */
			//		if($_POST['projectmanager'] == 'f') {
			//			$this->db->Execute('DELETE FROM company'.EGS_COMPANY_ID.'.flyspray_users_in_groups WHERE user_id='.$this->db->qstr($this->db->GetOne('SELECT id FROM person WHERE owner='.$this->db->qstr($_POST['username']).' AND userdetail')).' AND group_id=0');
			//		} else {
			//			$this->db->Replace('company'.EGS_COMPANY_ID.'.flyspray_users_in_groups', array('user_id' => $this->db->GetOne('SELECT id FROM person WHERE owner='.$this->db->qstr($_POST['username']).' AND userdetail'), 'group_id' => 4), array('user_id', 'group_id'), true);
			//		}	
			//	}
			if (isset ($groups) && is_array($groups) && count($groups) > 0) {
				$this->db->Execute('DELETE FROM groupmembers WHERE username='.$this->db->qstr($_POST['username']).' AND groupid IN (SELECT id AS groupid FROM groups WHERE companyid='.$this->db->qstr(EGS_COMPANY_ID).')');

				$query = 'INSERT INTO groupmembers (groupid, username) VALUES (?, ?)';

				$stmt = $this->db->Prepare($query);

				while ($groupId = array_pop($groups)) {

					$this->db->Execute($stmt, array ($groupId, $_POST['username']));

				}

			}
			/*check for use of owl*/
			if (in_array('filesharing', $_SESSION['modules']) && isset($allowowl) && $allowowl) {
				/*Do Insert to Owl table*/

				if (!$this->db->Replace('company'.EGS_COMPANY_ID.'.owlusers', $owl, array ('username'), true))
					$errors[] = _('Error saving into owl table');
			}
			if ($this->db->GetOne('SELECT tablename FROM pg_tables WHERE schemaname=\'company'.EGS_COMPANY_ID.'\' AND tablename LIKE \'erpusers%\'') && in_array('weberp', $_SESSION['modules']) && isset($allowerp) && $allowerp) {
				/*Do Insert to ERP table (if it's there)*/

				if (!$this->db->Replace('company'.EGS_COMPANY_ID.'.erpusers', $erp, array ('userid'), true))
					$errors[] = _('Error saving into erp table');
			}

			/*only want to send an email for a new user*/
			if (isset ($olduser)) {
				$message = _("You have been given access to our portal available at {HOST}\r\n"."\r\n"."Your access details are:\r\n"."\r\n"."Username: {USERNAME}\r\n"."Password: {PASSWORD}");

				$to = $this->db->GetOne('SELECT email FROM personoverview WHERE id='.$this->db->qstr($personId));
				$subject = _('Portal Access');

				$message = str_replace('{HOST}', EGS_SERVER, str_replace('{PASSWORD}', $password, str_replace('{USERNAME}', $_POST['username'], $message)));

				mail($to, $subject, $message);
			}
			$this->db->CompleteTrans();
		}

		/* If there are no errors return true and set success message */
		if (sizeof($errors) == 0) {
			$messages = array ();
			if ($mode == 'INSERT')
				$messages[] = _('User Successfully Added');
			else
				$messages[] = _('User Successfully Updated');

			$smarty->assign('messages', $messages);
			return true;
		} else {

			$smarty->assign('errors', $errors);
			return false;
		}
	}
	/**
	 * Generates a random alphanumeric password of the given length
	 * 
	 * @return string
	 */
	function generatePassword($length = 8) {

			// start with a blank password
	$password = "";

		// define possible characters
		$possible = "0123456789bcdfghjkmnpqrstvwxyzABCDEFGHJKLMNPQRSTUVWXYZ";

		// set up a counter
		$i = 0;

		// add random characters to $password until $length is reached
		while ($i < $length) {

			// pick a random character from the possible ones
			$char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);

			// we don't want this character if it's already in the password
			if (!strstr($password, $char)) {
				$password .= $char;
				$i ++;
			}

		}

		// done!
		return $password;

	}
}
?>