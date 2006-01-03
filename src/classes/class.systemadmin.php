<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - System Admin Overview 1.0        |
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

class systemadmin {
	function systemadmin() {
		global $db;
		$this->db = $db;
	}
	
	function saveUser($_POST, $id) {
		$query = 'INSERT INTO useraccess (username, companyid, domainuser) VALUES ('.$this->db->qstr($id).', ?, ?)';
		$insert = $this->db->Prepare($query);
		if(isset($_POST['company']))unset($_POST['company']);
		if(isset($_POST['person']))unset($_POST['person']);
		$query = 'SELECT username FROM useraccess WHERE username=? AND companyid=?';
		$check = $this->db->Prepare($query);
			
		$this->db->StartTrans();
		
		$companies = '';
		
		for($i=0; $i<sizeof($_POST['companies']); $i++) {
			$companies .= $_POST['companies'][$i].',';
			
			if(isset($_POST['domainuser'])) $domainuser = 'true';
			else $domainuser = 'false';
			echo $_POST['companies'];
			if($this->db->GetOne($check, array($id, $_POST['companies'][$i])) === false) $this->db->Execute($insert, array($_POST['companies'][$i], $domainuser));
		}
		
		$this->db->Execute('UPDATE useraccess SET domainuser='.$this->db->qstr($domainuser).' WHERE username='.$this->db->qstr($id));
		
		/* If the user is a superuser for a company do not remove */
		$query = 'SELECT companyid FROM useraccess WHERE username='.$this->db->qstr($id).' AND superuser';
		
		$rs = $this->db->Execute($query);
		
		while(!$rs->EOF) {
			$companies .= $rs->fields['companyid'].',';	
			
			$rs->MoveNext();
		}
		
		/* And dont remove from their own company */
		$query = 'SELECT CASE WHEN companyid IS NULL THEN 0 ELSE companyid END AS companyid FROM person WHERE owner='.$this->db->qstr($id).' AND userdetail';
		
		$companies .= $this->db->GetOne($query).',';
		
		$companies .= 0;
		
		$this->db->Execute('DELETE FROM useraccess WHERE username='.$this->db->qstr($id).' AND companyid NOT IN ('.$companies.')');

		$this->db->CompleteTrans();
		
		return true;
	}

	function freeEmail($address, $addressType, $id=null) {
		$query = 'SELECT id FROM ticketqueue WHERE '.$addressType.'='.$this->db->qstr($address);
		
		if($id != '') $query .= ' AND id<>'.$this->db->qstr($id);

		$result = $this->db->GetOne($query);
		
		if($result === false) return true;
		else return false;
	}
	function saveCompany($_POST, $id=null) {
		global $smarty;

		if(isset($_POST['company']))unset($_POST['company']);
		if(isset($_POST['person']))unset($_POST['person']);

		unset($_POST['save']);
		unset($_POST['companyname']);
		$modules=$_POST['modules'];
		unset($_POST['modules']);
		if(isset($_POST['access']))$_POST['access']='t';
		if($id != '')
			$id = intval($id);
		if(!isset($id)) {
			$id = $_POST['companyid'];
		}
			$_POST['companyid']=$id;
			unset($_POST['id']);
		/*Array to hold errors*/
		$errors = array();
		
		
		/*validate input*/
		
		if(count($errors)==0) {
			$this->db->StartTrans();
			if(!$this->db->Replace('companydefaults',$_POST,'companyid',true))
				$errors[] = _('Error Updating Company');
				
			/*do modules*/
			$q = 'DELETE FROM companymoduleaccess WHERE companyid='.$this->db->qstr($id);
			$this->db->Execute($q);
			
			$q = 'INSERT INTO companymoduleaccess (companyid,moduleid) VALUES (?,?)';
			$stmt = $this->db->Prepare($q);
			foreach ($modules as $moduleid) {
			$this->db->Execute($stmt,array($id,$moduleid));	
				
			}
			/*cross assign the current user to the new company*/

			$q = 'INSERT INTO useraccess (companyid,username,access,superuser,domainuser,projectmanager,ticketadmin,calendaradmin,crmadmin) VALUES('.$this->db->qstr($id).','.$this->db->qstr(EGS_USERNAME).','.$this->db->qstr('t').','.$this->db->qstr('t').','.$this->db->qstr('t').','.$this->db->qstr('t').','.$this->db->qstr('t').','.$this->db->qstr('t').','.$this->db->qstr('t').')';
			if($id == '') $this->db->Execute($q);
			
			/*and add a new admin account?*/
			
			
			$this->db->CompleteTrans();
		}
		else {
			$smarty->assign('errors',$errors);
		}
	}
	function saveQueue($_POST, $id = null) {
		global $smarty;

		if ($id != '')
			$id = intval($id);

		/* Array to hold errors */
		$errors = array ();

		if(!isset($_POST['actualaddress'])) $_POST['actualaddress'] = $_POST['address'];
		
		/* Check details are valid  - starting with the name */
		if (!isset ($_POST['name']))
			$errors[] = _('No Name');
		if (!isset ($_POST['address']))
			$errors[] = _('No Email Address');
		if (!isset ($_POST['companyid']))
			$errors[] = _('No company to assign the queue to');
			
		if(!$this->freeEmail($_POST['address'], 'address', $id))
			$errors[] = _('The email address you are trying to use is already in use');
		if(!$this->freeEmail($_POST['actualaddress'], 'actualaddress', $id))
			$errors[] = _('The actual email address you are trying to use is already in use');

		/* No errors so we can save */
		if (sizeof($errors) == 0) {
			/* Set weather to insert or update */
			if ($id != null)
				$mode = 'UPDATE';
			else
				$mode = 'INSERT';

			/* If we are doing an insert set some defaults */
			if ($mode == 'INSERT') {
				$_POST['id'] = $this->db->GenID('ticketqueue_id_seq');
			}

			unset ($_POST['save']);

			/* Start a transaction */
			$this->db->StartTrans();

			/* Insert the queue */
			if (!$this->db->Replace('ticketqueue', $_POST, 'id', true))
				$errors[] = _('Error saving ticket queue');

			$this->db->completeTrans();
		}

		/* If there are no errors return true and set success message */
		if (sizeof($errors) == 0) {
			$messages = array ();
			if ($mode == 'INSERT')
				$messages[] = _('Ticket Queue Successfully Added');
			else
				$messages[] = _('Ticket Queue Successfully Updated');

			$smarty->assign('messages', $messages);
			return true;
		} else {
			$smarty->assign('errors', $errors);
			return false;
		}
	}
}
?>