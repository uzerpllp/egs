<?php
class person {
	function person() {
		global $db;
		$this->db = & $db;
	}
	
	/* Get the access level the current user has for a person */
	function accessLevel($id) {
		if(!isset($access[$id])) {
			
			$query = 'SELECT type FROM personaccess WHERE personid='.$this->db->qstr($id).' AND usercompanyid='.$this->db->qstr(EGS_COMPANY_ID).' AND username='.$this->db->qstr(EGS_USERNAME);
	
			$rs = $this->db->GetOne($query);
	
			if ($rs === false)
				return -1;
			
			$this->access[$id] = $rs;
		}
		
		return $this->access[$id];
	}
	
	function deletePerson($id) {
		global $smarty;

		if($this->accessLevel($id) > 3) {
			$query = 'DELETE FROM person WHERE id='.$this->db->qstr($id);

			$this->db->execute($query);

			$smarty->assign('messages', array(_('Person successfully deleted')));
		
			return true;
		}

		$smarty->assign('errors', array(_('Error deleting person - you have the incorrect access level. If you believe you should be able to perform this operation please contact you system administrator')));

		return false;
	}
	
	function savePerson($_POST, $id = null) {
		global $egs, $smarty;
		if(isset($_POST['company']))unset($_POST['company']);
		if(isset($_POST['person']))unset($_POST['person']);
		if($id != '') $id = intval($id);

		/* Array to hold errors */
		$errors = array ();

		require_once(EGS_FILE_ROOT.'/src/classes/class.company.php');
		$company = new company();
		
		/* Check details are valid  - starting with the name */
		if (!isset ($_POST['firstname']))
			$errors[] = _('No First Name');
		if (!isset ($_POST['surname']))
			$errors[] = _('No Surname');
		/* and the address */
		if ((isset ($_POST['street1']) || isset ($_POST['town']) || isset ($_POST['county']) || isset ($_POST['postcode'])) && (!isset ($_POST['street1']) || !isset ($_POST['town']) || !isset ($_POST['county']) || !isset ($_POST['postcode'])))
			$errors[] = _('Invalid address - The address must have a street, town, county and postcode');
		/* and email address */
		if (isset ($_POST['email']) && !$egs->validEmail($_POST['email']))
			$errors[] = _('Invalid email address');
		if (isset ($_POST['companyid']) && !$company->accessLevel($_POST['companyid']))
			$errors[] = _('You do not have the correct access to attach this person to the company you have chosen.');

		/* No errors so we can save */
		if (sizeof($errors) == 0) {
			
			/* Set weather to insert or update */
			if ($id != null)
				$mode = 'UPDATE';
			else
				$mode = 'INSERT';

			/* Check company access */
			if(isset($_POST['id'])) {
				$query = 'SELECT a.type FROM companyaccess a, person p WHERE p.companyid=a.companyid AND a.usercompanyid='.$this->db->qstr(EGS_COMPANY_ID).' AND username='.$this->db->qstr(EGS_USERNAME).' AND p.id='.$this->db->qstr($_POST['id']);
			
				$companyAccess = $this->db->GetOne($query);
			} else {
				$companyAccess = -1;
			}

			if(($mode == 'UPDATE') && (($this->accessLevel($id) < 3) && ($companyAccess < 3))) {
				$smarty->assign('errors', array(_('You do not have the correct access to update this person. If you beleive you should please contact your system administrator.')));
				
				return true;
			}

			/* If we are doing an insert set some defaults */
			if ($mode == 'INSERT') {
				$_POST['id'] = $this->db->GenID('person_id_seq');
			}

			$_POST['alteredby'] = EGS_USERNAME;

			/* Start a transaction */
			$this->db->StartTrans();

			$person = array();
			$person['id'] = $_POST['id'];			
			if(isset($_POST['title'])) $person['title'] = $_POST['title'];
			if(isset($_POST['firstname'])) $person['firstname'] = $_POST['firstname'];
			if(isset($_POST['middlename'])) $person['middlename'] = $_POST['middlename'];
			if(isset($_POST['surname'])) $person['surname'] = $_POST['surname'];
			if(isset($_POST['suffix'])) $person['suffix'] = $_POST['suffix'];
			if(isset($_POST['department'])) $person['department'] = $_POST['department'];
			if(isset($_POST['jobtitle'])) $person['jobtitle'] = $_POST['jobtitle'];
			if(isset($_POST['dob'])) $person['dob'] = $_POST['dob'];
			if(isset($_POST['ni'])) $person['ni'] = $_POST['ni'];
			if(isset($_POST['marital'])) $person['marital'] = intval($_POST['marital']);
			if(isset($_POST['lang'])) $person['lang'] = $_POST['lang'];
			if(isset($_POST['companyid'])) $person['companyid'] = $_POST['companyid'];
			if(isset($_POST['personid'])) $person['reportsto'] = $_POST['personid'];
			if(isset($_POST['cancall'])) $person['cancall'] = 'true';
			else $person['cancall'] = 'false';
			if(isset($_POST['canemail'])) $person['canemail'] = 'true';
			else $person['canemail'] = 'false';
			
			if($mode == 'INSERT') {
				$person['owner'] = EGS_USERNAME;
				$person['usercompanyid'] = EGS_COMPANY_ID;
			} else {
				$person['updated'] = $this->db->DBTimeStamp(time());
			}

			$person['assigned'] = $_POST['assigned'];
			$person['alteredby'] = EGS_USERNAME;

			/* Insert the company */
			if (!$this->db->Replace('person', $person, 'id', true))
				$errors[] = _('Error saving person');

			/* Insert the address */
			if (isset ($_POST['street1'])) {
				$personAddress = array ();
				$personAddress['street1'] = $_POST['street1'];
				if (isset ($_POST['street2']))
					$personAddress['street2'] = $_POST['street2'];
				if (isset ($_POST['street3']))
					$personAddress['street3'] = $_POST['street3'];
				$personAddress['town'] = $_POST['town'];
				$personAddress['county'] = $_POST['county'];
				
				if(is_numeric($_POST['postcode']));
					$_POST['postcode']=$this->db->qstr($_POST['postcode']);
				$personAddress['postcode'] = $_POST['postcode'];
				$personAddress['countrycode'] = $_POST['countrycode'];
				$personAddress['tag'] = 'MAIN';
				$personAddress['personid'] = $_POST['id'];
				
				if(($mode == 'INSERT') || ($this->db->GetOne('SELECT tag FROM personaddress WHERE main AND personid='.$this->db->qstr($_GET['id'])) === false)){
					$personAddress['name'] = _('Main');
					$personAddress['main'] = true;
					$personAddress['billing'] = true;
					$personAddress['shipping'] = true;
					$personAddress['payment'] = true;
					$personAddress['technical'] = true;
				}

				if (!$this->db->Replace('personaddress', $personAddress, array('tag', 'personid'), true))
					$errors[] = _('Error saving person address');
			}

			/* Insert the contact details */
			$contacts = array ('phone', 'fax', 'mobile', 'email');

			/* Set an array to hold contact */
			$personContact = array ();
			$personContact['tag'] = 'MAIN';
			$personContact['personid'] = $_POST['id'];

			while ($contact = array_pop($contacts)) {
				if (isset ($_POST[$contact])) {
					if(is_numeric($_POST[$contact]));
						$_POST[$contact]=$this->db->qstr($_POST[$contact]);
					$personContact['contact'] = $_POST[$contact];
					$personContact['type'] = strtoupper($contact {0});
					/* Change to T for phone */
					if($personContact['type'] == 'P') $personContact['type'] = 'T';
					
					if(($mode == 'INSERT') || ($this->db->GetOne('SELECT tag FROM personcontactmethod WHERE main AND type='.$this->db->qstr($personContact['type']).' AND personid='.$this->db->qstr($_GET['id'])) === false)) {
						$personContact['name'] = _('Main');
						$personContact['main'] = true;
						$personContact['billing'] = true;
						$personContact['shipping'] = true;
						$personContact['payment'] = true;
						$personContact['technical'] = true;
					}
					
					
					if (!$this->db->Replace('personcontactmethod', $personContact, array('tag', 'type', 'personid'), true))
						$errors[] = _('Error saving person ')._($contact);
				}
				
				if(!isset($_POST[$contact])&&isset($_GET['id'])) {
						$type = strtoupper($contact {0});
						/* Change to T for phone */
						if($type == 'P') $type = 'T';
						
						/* If there is only one contact and it is unset we can delete it */
						$query = 'SELECT count(*) AS total FROM personcontactmethod WHERE main=true AND type='.$this->db->qstr($type).' AND personid='.$this->db->qstr($_GET['id']);
						
						$rs = $this->db->Execute($query);
						
						if($rs->fields['total'] == 1) {
							$query = 'DELETE FROM personcontactmethod WHERE main=true AND type='.$this->db->qstr($type).' AND personid='.$this->db->qstr($_GET['id']);
							
							$this->db->Execute($query);
						}
					}
			}

			$this->db->completeTrans();
		}

		/* If there are no errors return true and set success message */
		if (sizeof($errors) == 0) {
			$messages = array();
			if($mode == 'INSERT') $messages[] = _('Person Successfully Added');
			else $messages[] = _('Person Successfully Updated');
			
			$smarty->assign('messages', $messages);
			return true;
		} else {
			$smarty->assign('errors', $errors);
			return false;
		}
	}
	
	function updateLogo($personId) {
		global $smarty;

		$errors = array();
		if(!isset($_FILES['file']['name'])) $errors[] = _('Please upload a file');
		else if($this->accessLevel($personId) > 3) {

			if(isset($_FILES['file']) && ($_FILES['file']['error'] != UPLOAD_ERR_NO_FILE)) {
				$uploadedfile = EGS_FILE_ROOT.'/photos/'.$personId.'.jpg';

				if(!move_uploaded_file($_FILES['file']['tmp_name'], $uploadedfile)) $errors[] = _('Error with uploaded file');
				else chmod($uploadedfile, 0755);
			}
		} else {
			$errors[] = _('You do not have the correct permissions to upload a file. If you beleive you should please contact your system administrator');
		}

		$smarty->assign('errors', $errors);
	}
	
	function saveContact($_POST, $id = null) {
		global $egs, $smarty;

		/* Array to hold errors */
		$errors = array ();
		if(isset($_POST['company']))unset($_POST['company']);
		if(isset($_POST['person']))unset($_POST['person']);
		/* Check details are valid  - starting with the name */
		if (!isset ($_POST['name']))
			$errors[] = _('No Contact Name');
		/* and the address */
		if (!isset ($_POST['contact']))
			$errors[] = _('No Contact');
		/* and the access */
		if ($this->accessLevel($_POST['personid']) < 3)
			$errors[] = _('You do not have the correct access to add a contact to this person. If you beleive you should please contact your system administrator.');
			
		/* No errors so we can save */
		if (sizeof($errors) == 0) {	
				/* Start a transaction */
				$this->db->StartTrans();

				unset($_POST['save']);
				if(!isset($_POST['tag'])) $_POST['tag'] = $_POST['name'];
				$_POST['type'] = $_SESSION['preferences']['contactsView'];
				$_POST['contact'] = $_POST['contact']." ";
	
				if($this->db->GetOne('SELECT tag FROM personcontactmethod WHERE type='.$this->db->qstr($_POST['type']).' AND main AND personid='.$this->db->qstr($_POST['personid'])) === false) {
						$_POST['main'] = true;
						$_POST['billing'] = true;
						$_POST['shipping'] = true;
						$_POST['payment'] = true;
						$_POST['technical'] = true;
					}
					
					if (!$this->db->Replace('personcontactmethod', $_POST, array('tag', 'type', 'personid'), true))
						$errors[] = _('The Name you are trying to use is already in use.');

				$this->db->completeTrans();
		}

		/* If there are no errors return true and set success message */
		if (sizeof($errors) == 0) {
			$messages = array();
			if($id == '') $messages[] = _('Contact Successfully Added');
			else $messages[] = _('Contact Successfully Updated');
			
			$smarty->assign('messages', $messages);
			return true;
		} else {
			$smarty->assign('errors', $errors);
			return false;
		}
	}
	
	function updateCategories($categories, $personId)
	{
		if($this->accessLevel($personId) > 2) {
			$this->db->StartTrans();

			$query = 'DELETE FROM persontypexref WHERE personid='.$this->db->qstr($personId);

			$this->db->Execute($query);

			$query = 'INSERT INTO persontypexref (personid, typeid) VALUES (?, ?)';

			$stmt = $this->db->prepare($query);

			while(is_array($categories) && $type = array_pop($categories)) {
				$this->db->Execute($stmt, array($personId, $type));
			}

		 	$this->db->completeTrans();

			return true;	
		} else {
			$smarty->assign('errors', array(_('You do not have the correct access to update the categories. If you beleive you should be able to perform this operation please contact your system administrator')));
		
			return false;
		}
	}
	
	/* Function to update a person's contacts' */
	function updateContacts($_POST) {
		global $egs, $smarty;

		/* Array to hold errors */
		$errors = array ();

		if ($this->accessLevel($_POST['personid']) < 4)
			$errors[] = _('You do not have the correct access to update the contacts associated with this person. If you beleive you should please contact your system administrator.');
			
		/* No errors so we can save */
		if (sizeof($errors) == 0) {	
				/* Start a transaction */
				$this->db->StartTrans();
	
				$query = 'UPDATE personcontactmethod SET main=false, billing=false, shipping=false, payment=false, technical=false WHERE personid='.$this->db->qstr($_POST['personid']).' AND type='.$this->db->qstr($_SESSION['preferences']['contactsView']);
				
				$this->db->Execute($query);
				
				while (list($key, $val) = each($_POST['type'])) {
					$query = 'UPDATE personcontactmethod SET '.$key.'=true WHERE tag='.$this->db->qstr(urldecode($val)).' AND type='.$this->db->qstr($_SESSION['preferences']['contactsView']);
					
					$this->db->Execute($query);
				}
				
				$this->db->completeTrans();
		}
	}
	
	function deleteContact($_POST) {
		global $smarty;

		$query = 'SELECT * FROM personcontactmethod WHERE personid='.$this->db->qstr($_POST['personid']).' AND tag='.$this->db->qstr($_POST['tag']).' AND type='.$this->db->qstr($_SESSION['preferences']['contactsView']);
		
		$_POST = $this->db->GetRow($query);

		if($_POST['main'] == 't') {
			$smarty->assign('errors', array(_('You cannot delete the main contact')));
			return true;
		}
		else if($this->accessLevel($_POST['personid']) > 2) {
			$this->db->StartTrans();
			
			$query = 'DELETE FROM personcontactmethod WHERE tag='.$this->db->qstr($_POST['tag']).' AND personid='.$this->db->qstr($_POST['personid']).' AND main <> true AND type='.$this->db->qstr($_SESSION['preferences']['contactsView']);

			$this->db->execute($query);

			if($_POST['billing'] == 't') {
				$query = 'UPDATE personcontactmethod SET billing=true WHERE personid='.$this->db->qstr($_POST['personid']).' AND main AND type='.$this->db->qstr($_SESSION['preferences']['contactsView']);
				
				$this->db->Execute($query);	
			}
			
			if($_POST['shipping'] == 't') {
				$query = 'UPDATE personcontactmethod SET shipping=true WHERE personid='.$this->db->qstr($_POST['personid']).' AND main AND type='.$this->db->qstr($_SESSION['preferences']['contactsView']);
				
				$this->db->Execute($query);	
			}
			
			if($_POST['payment'] == 't') {
				$query = 'UPDATE personcontactmethod SET payment=true WHERE personid='.$this->db->qstr($_POST['personid']).' AND main AND type='.$this->db->qstr($_SESSION['preferences']['contactsView']);
				
				$this->db->Execute($query);	
			}
			
			if($_POST['technical'] == 't') {
				$query = 'UPDATE personcontactmethod SET technical=true WHERE personid='.$this->db->qstr($_POST['personid']).' AND main AND type='.$this->db->qstr($_SESSION['preferences']['contactsView']);
				
				$this->db->Execute($query);	
			}
			
			$this->db->CompleteTrans();
				
			$smarty->assign('messages', array(_('Person Contact successfully deleted')));
		
			return true;
		}

		$smarty->assign('errors', array(_('Error deleting person contact - you have the incorrect access level. If you believe you should be able to perform this operation please contact you system administrator')));

		return false;
	}
	
	function saveAddress($_POST, $id = null) {
		global $egs, $smarty;

		/* Array to hold errors */
		$errors = array ();
		if(isset($_POST['company']))unset($_POST['company']);
		if(isset($_POST['person']))unset($_POST['person']);
		/* Check details are valid  - starting with the name */
		if (!isset ($_POST['name']))
			$errors[] = _('No Address Name');
		/* and the address */
		if (!isset ($_POST['street1']) || !isset ($_POST['town']) || !isset ($_POST['county']) || !isset ($_POST['postcode']))
			$errors[] = _('Invalid address - The address must have a street, town, county and postcode');
		/* and the access */
		if ($this->accessLevel($_POST['personid']) < 3)
			$errors[] = _('You do not have the correct access to add an address to this person. If you beleive you should please contact your system administrator.');
			
		/* No errors so we can save */
		if (sizeof($errors) == 0) {	
				/* Start a transaction */
				$this->db->StartTrans();
	
				/* Insert the address */
					$personAddress = array ();
					$personAddress['street1'] = $_POST['street1'];
					if (isset ($_POST['street2']))
						$personAddress['street2'] = $_POST['street2'];
					if (isset ($_POST['street3']))
						$personAddress['street3'] = $_POST['street3'];
					$personAddress['town'] = $_POST['town'];
					$personAddress['county'] = $_POST['county'];
					if(is_numeric($_POST['postcode']))
						$personAddress['postcode'] = $this->db->qstr($_POST['postcode']);
					else
						$personAddress['postcode'] = $_POST['postcode'];
					$personAddress['countrycode'] = $_POST['countrycode'];
					if(isset($_POST['tag'])) $personAddress['tag'] = $_POST['tag'];
					else $personAddress['tag'] = $_POST['name'];
					$personAddress['name'] = $_POST['name'];
					$personAddress['personid'] = $_POST['personid'];
					
					if($this->db->GetOne('SELECT tag FROM personaddress WHERE main AND personid='.$this->db->qstr($_POST['personid'])) === false) {
						$personAddress['main'] = true;
						$personAddress['billing'] = true;
						$personAddress['shipping'] = true;
						$personAddress['payment'] = true;
						$personAddress['technical'] = true;
					}
	
					if (!$this->db->Replace('personaddress', $personAddress, array('tag', 'personid'), true))
						$errors[] = _('Error saving person address');
				
				$this->db->completeTrans();
		}

		/* If there are no errors return true and set success message */
		if (sizeof($errors) == 0) {
			$messages = array();
			if($id == '') $messages[] = _('Address Successfully Added');
			else $messages[] = _('Address Successfully Updated');
			
			$smarty->assign('messages', $messages);
			return true;
		} else {
			$smarty->assign('errors', $errors);
			return false;
		}
	}
	
	/* Function to update a person's addresses' */
	function updateAddress($_POST) {
		global $egs, $smarty;

		/* Array to hold errors */
		$errors = array ();

		if ($this->accessLevel($_POST['personid']) < 4)
			$errors[] = _('You do not have the correct access to update the addresses associated with this person. If you beleive you should please contact your system administrator.');
			
		/* No errors so we can save */
		if (sizeof($errors) == 0) {	
				/* Start a transaction */
				$this->db->StartTrans();
	
				$query = 'UPDATE personaddress SET main=false, billing=false, shipping=false, payment=false, technical=false WHERE personid='.$this->db->qstr($_POST['personid']);
				
				$this->db->Execute($query);
				
				while (list($key, $val) = each($_POST['type'])) {
					$query = 'UPDATE personaddress SET '.$key.'=true WHERE tag='.$this->db->qstr(urldecode($val));
					
					$this->db->Execute($query);
				}
				
				$this->db->completeTrans();
		}
	}
	
	function deleteAddress($_POST) {
		global $smarty;

		$query = 'SELECT * FROM personaddress WHERE personid='.$this->db->qstr($_POST['personid']).' AND tag='.$this->db->qstr($_POST['tag']);
		
		$_POST = $this->db->GetRow($query);

		if($_POST['main'] == 't') {
			$smarty->assign('errors', array(_('You cannot delete the main address')));
			return true;
		}
		else if($this->accessLevel($_POST['personid']) > 2) {
			$this->db->StartTrans();
			
			$query = 'DELETE FROM personaddress WHERE tag='.$this->db->qstr($_POST['tag']).' AND personid='.$this->db->qstr($_POST['personid']).' AND main <> true';

			$this->db->execute($query);

			if($_POST['billing'] == 't') {
				$query = 'UPDATE personaddress SET billing=true WHERE personid='.$this->db->qstr($_POST['personid']).' AND main';
				
				$this->db->Execute($query);	
			}
			
			if($_POST['shipping'] == 't') {
				$query = 'UPDATE personaddress SET shipping=true WHERE personid='.$this->db->qstr($_POST['personid']).' AND main';
				
				$this->db->Execute($query);	
			}
			
			if($_POST['payment'] == 't') {
				$query = 'UPDATE personaddress SET payment=true WHERE personid='.$this->db->qstr($_POST['personid']).' AND main';
				
				$this->db->Execute($query);	
			}
			
			if($_POST['technical'] == 't') {
				$query = 'UPDATE personaddress SET technical=true WHERE personid='.$this->db->qstr($_POST['personid']).' AND main';
				
				$this->db->Execute($query);	
			}
			
			$this->db->CompleteTrans();
				
			$smarty->assign('messages', array(_('Person Address successfully deleted')));
		
			return true;
		}

		$smarty->assign('errors', array(_('Error deleting person address - you have the incorrect access level. If you believe you should be able to perform this operation please contact you system administrator')));

		return false;
	}
	
	function updateAccess($_POST) {
		global $smarty;

		$id = $_POST['id'];
		if($this->accessLevel($id) > 2) {
			$this->db->StartTrans();
			
			if(!isset($_POST['restrictedreadgroups'])) $_POST['restrictedreadgroups'] = array();
			if(!isset($_POST['readgroups'])) $_POST['readgroups'] = array();
			if(!isset($_POST['writegroups'])) $_POST['writegroups'] = array();
			if(!isset($_POST['restrictedreadusers'])) $_POST['restrictedreadusers'] = array();
			if(!isset($_POST['readusers'])) $_POST['readusers'] = array();
			if(!isset($_POST['writeusers'])) $_POST['writeusers'] = array();
			
			/* Delete the exisitng user and group access, this is ok as it is in a transaction and will roll back
			 * if it breaks
			 */
			$query = 'DELETE FROM persongroupaccessxref WHERE personid='.$this->db->qstr($id).' AND groupid IN (SELECT id FROM groups WHERE companyid='.$this->db->qstr(EGS_COMPANY_ID).')';
			
			$this->db->Execute($query);
			
			$query = 'DELETE FROM personuseraccessxref WHERE personid='.$this->db->qstr($id).' AND usercompanyid='.$this->db->qstr(EGS_COMPANY_ID);
			
			$this->db->Execute($query);
			
			/* Prepare the insert for groups */
			$query = 'INSERT INTO persongroupaccessxref VALUES ('.$this->db->qstr($id).', ?, ?)';
			$stmt = $this->db->Prepare($query);
			
			/* Now iterate over the groups */
			while($group = array_shift($_POST['restrictedreadgroups'])) {
				$this->db->Execute($stmt, array($group, 0));	
			}
			
			while($group = array_shift($_POST['readgroups'])) {
				$this->db->Execute($stmt, array($group, 1));	
			}
			
			while($group = array_shift($_POST['writegroups'])) {
				$this->db->Execute($stmt, array($group, 4));	
			}
			
			/* Prepare the insert for users */
			$query = 'INSERT INTO personuseraccessxref (personid, username, usercompanyid, type) VALUES ('.$this->db->qstr($id).', ?,'.$this->db->qstr(EGS_COMPANY_ID).', ?)';
			$stmt = $this->db->Prepare($query);
			
			/* Now iterate over the users */
			while($user = array_shift($_POST['restrictedreadusers'])) {
				$this->db->Execute($stmt, array($user, 0));	
			}
			
			while($user = array_shift($_POST['readusers'])) {
				$this->db->Execute($stmt, array($user, 1));	
			}
			
			while($user = array_shift($_POST['writeusers'])) {
				$this->db->Execute($stmt, array($user, 4));	
			}
			
			$this->db->CompleteTrans();
			
			$smarty->assign('messages', array(_('Person access successfully updated')));
			return true;
		}
		else {
			$smarty->assign('errors', array(_('You do not have the correct access to update this person access. If you beleive you should please contact your system administrator.')));
		}
		
		return false;
	}
}
?>