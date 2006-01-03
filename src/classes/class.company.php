<?php 
class company {
	/**
	 * constructor
	 */
	function company() {
		global $db;
		$this->db = & $db;
	}

	/**
	 * Get the access level the current user has for a company 
	 * */
	function accessLevel($id) {
		$id = $this->parentId($id);
		if(!isset($access[$id])) {
			$query = 'SELECT type FROM companyaccess WHERE companyid='.$this->db->qstr($id).' AND usercompanyid='.$this->db->qstr(EGS_COMPANY_ID).' AND username='.$this->db->qstr(EGS_USERNAME);

			$rs = $this->db->GetOne($query);
	
			if ($rs === false)
				return -1;
			
			$this->access[$id] = $rs;
		}
		
		return $this->access[$id];
	}

	/**
	 * Function to delete a company 
	 * */
	function deleteCompany($id) {
		global $smarty;

		if($this->accessLevel($id) > 3) {
			$query = 'DELETE FROM company WHERE id='.$this->db->qstr($id);

			$this->db->execute($query);

			$smarty->assign('messages', array(_('Company successfully deleted')));
		
			return true;
		}

		$smarty->assign('errors', array(_('Error deleting company - you have the incorrect access level. If you believe you should be able to perform this operation please contact you system administrator')));

		return false;
	}
	
	/**
	 * Function to delete an address
	 * */
	function deleteAddress($_POST) {
		global $smarty;

		$query = 'SELECT * FROM companyaddress WHERE companyid='.$this->db->qstr($_POST['companyid']).' AND tag='.$this->db->qstr($_POST['tag']);
		
		$_POST = $this->db->GetRow($query);

		if($_POST['main'] == 't') {
			$smarty->assign('errors', array(_('You cannot delete the main address')));
			return true;
		}
		else if($this->accessLevel($_POST['companyid']) > 3) {
			$this->db->StartTrans();
			
			$query = 'DELETE FROM companyaddress WHERE tag='.$this->db->qstr($_POST['tag']).' AND companyid='.$this->db->qstr($_POST['companyid']).' AND main <> true';

			$this->db->execute($query);

			if($_POST['billing'] == 't') {
				$query = 'UPDATE companyaddress SET billing=true WHERE companyid='.$this->db->qstr($_POST['companyid']).' AND main';
				
				$this->db->Execute($query);	
			}
			
			if($_POST['shipping'] == 't') {
				$query = 'UPDATE companyaddress SET shipping=true WHERE companyid='.$this->db->qstr($_POST['companyid']).' AND main';
				
				$this->db->Execute($query);	
			}
			
			if($_POST['payment'] == 't') {
				$query = 'UPDATE companyaddress SET payment=true WHERE companyid='.$this->db->qstr($_POST['companyid']).' AND main';
				
				$this->db->Execute($query);	
			}
			
			if($_POST['technical'] == 't') {
				$query = 'UPDATE companyaddress SET technical=true WHERE companyid='.$this->db->qstr($_POST['companyid']).' AND main';
				
				$this->db->Execute($query);	
			}
			
			$this->db->CompleteTrans();
				
			$smarty->assign('messages', array(_('Company Address successfully deleted')));
		
			return true;
		}

		$smarty->assign('errors', array(_('Error deleting company address - you have the incorrect access level. If you believe you should be able to perform this operation please contact you system administrator')));

		return false;
	}
	/**
	 * function to delete a contact
	 */
	function deleteContact($_POST) {
		global $smarty;

		$query = 'SELECT * FROM companycontactmethod WHERE companyid='.$this->db->qstr($_POST['companyid']).' AND tag='.$this->db->qstr($_POST['tag']).' AND type='.$this->db->qstr($_SESSION['preferences']['contactsView']);
		
		$_POST = $this->db->GetRow($query);

		if($_POST['main'] == 't') {
			$smarty->assign('errors', array(_('You cannot delete the main contact')));
			return true;
		}
		else if($this->accessLevel($_POST['companyid']) > 3) {
			$this->db->StartTrans();
			
			$query = 'DELETE FROM companycontactmethod WHERE tag='.$this->db->qstr($_POST['tag']).' AND companyid='.$this->db->qstr($_POST['companyid']).' AND main <> true AND type='.$this->db->qstr($_SESSION['preferences']['contactsView']);

			$this->db->execute($query);

			if($_POST['billing'] == 't') {
				$query = 'UPDATE companycontactmethod SET billing=true WHERE companyid='.$this->db->qstr($_POST['companyid']).' AND main AND type='.$this->db->qstr($_SESSION['preferences']['contactsView']);
				
				$this->db->Execute($query);	
			}
			
			if($_POST['shipping'] == 't') {
				$query = 'UPDATE companycontactmethod SET shipping=true WHERE companyid='.$this->db->qstr($_POST['companyid']).' AND main AND type='.$this->db->qstr($_SESSION['preferences']['contactsView']);
				
				$this->db->Execute($query);	
			}
			
			if($_POST['payment'] == 't') {
				$query = 'UPDATE companycontactmethod SET payment=true WHERE companyid='.$this->db->qstr($_POST['companyid']).' AND main AND type='.$this->db->qstr($_SESSION['preferences']['contactsView']);
				
				$this->db->Execute($query);	
			}
			
			if($_POST['technical'] == 't') {
				$query = 'UPDATE companycontactmethod SET technical=true WHERE companyid='.$this->db->qstr($_POST['companyid']).' AND main AND type='.$this->db->qstr($_SESSION['preferences']['contactsView']);
				
				$this->db->Execute($query);	
			}
			
			$this->db->CompleteTrans();
				
			$smarty->assign('messages', array(_('Company Contact successfully deleted')));
		
			return true;
		}

		$smarty->assign('errors', array(_('Error deleting company contact - you have the incorrect access level. If you believe you should be able to perform this operation please contact you system administrator')));

		return false;
	}
	
	/**
	 * update the categories for a company
	 */
	function updateCategories($categories, $companyId)
	{
		
		if($this->accessLevel($companyId) > 2) {
			$this->db->StartTrans();

			$query = 'DELETE FROM companytypexref WHERE companyid='.$this->db->qstr($companyId);

			$this->db->Execute($query);

			$query = 'INSERT INTO companytypexref (companyid, typeid) VALUES (?, ?)';

			$stmt = $this->db->prepare($query);

			while(is_array($categories) && $type = array_pop($categories)) {
				$this->db->Execute($stmt, array($companyId, $type));
			}

		 	$this->db->completeTrans();

			return true;	
		} else {
			$smarty->assign('errors', array(_('You do not have the correct access to update the categories. If you beleive you should be able to perform this operation please contact your system administrator')));
		
			return false;
		}
	}

	/**
	 *  Function to check for valid account numbers
	 * */
	function isValidAccountNumber($accountNumber, $id = null) {
		$query = 'SELECT accountnumber FROM company WHERE companyid='.$this->db->qstr(EGS_COMPANY_ID).' AND accountnumber='.$this->db->qstr($accountNumber);

		if($id != '') $query .= ' AND id<>'.$this->db->qstr($id);

		$rs = $this->db->GetOne($query);

		if ($rs != '')
			return true;
		else
			return false;
	}
	
	/**
	 * Function to create an account-number
	 * */
	function createAccountNumber($companyname) {
			/*make an acronym based on the name*/
			$letters=array();
			$words=explode(' ', $companyname);
			$len=1;
			if(count($words)<3) $len=2;
			foreach($words as $word) {
				$word = (substr($word, 0, $len));
				array_push($letters, $word);
			}
			$accnum = strtoupper(implode($letters));
			/*now add a number to the end until an untake one is found*/
			$i=1;
			$testaccnum=$accnum.sprintf("%02s",$i);
			while($this->isValidAccountNumber($testaccnum)) {
				$i++;
				$testaccnum=$accnum.sprintf("%02s",$i);	
			}
			return $testaccnum;
			
	}
	/**
	 *  Function to insert a company 
	 * */
	function saveCompany($_POST, $id = null) {
		global $egs, $smarty;

		if($id != '') $id = intval($id);

		/* Array to hold errors */
		$errors = array ();
		if(isset($_POST['company']))unset($_POST['company']);
		if(isset($_POST['person']))unset($_POST['person']);
		/* Check details are valid  - starting with the name */
		if (!isset ($_POST['name']))
			$errors[] = _('No Company Name');
		/* and the address */
		if ((isset ($_POST['street1']) || isset ($_POST['town']) || isset ($_POST['county']) || isset ($_POST['postcode'])) && (!isset ($_POST['street1']) || !isset ($_POST['town']) || !isset ($_POST['county']) || !isset ($_POST['postcode'])))
			$errors[] = _('Invalid address - The address must have a street, town, county and postcode');
		/* and email address */
		if (isset ($_POST['email']) && !$egs->validEmail($_POST['email']))
			$errors[] = _('Invalid email address');
		/* and account number */
		if (!isset ($_POST['accountnumber'])) {
			if(!isset($_SESSION['preferences']['autocreate']))
				$errors[] = _('No Account Number');
			else if(isset($_POST['name'])){
				/*auto-create the number*/
				$_POST['accountnumber']=$this->createAccountNumber($_POST['name']);;
			}
			else
				$errors[] = _('Can\'t auto-create an account-number without a companyname');
		}
		
		if (isset ($_POST['accountnumber']) && $this->isValidAccountNumber($_POST['accountnumber'], $id))
			$errors[] = _('Account Number is taken');

		/* No errors so we can save */
		if (sizeof($errors) == 0) {
			/* Set weather to insert or update */
			if ($id != null)
				$mode = 'UPDATE';
			else
				$mode = 'INSERT';

			if(($mode == 'UPDATE') && ($this->accessLevel($id) < 3)) {
				$smarty->assign('errors', array(_('You do not have the correct access to update this company. If you beleive you should please contact your system administrator.')));
			} else {

				/* If we are doing an insert set some defaults */
				if ($mode == 'INSERT') {
					$_POST['id'] = $this->db->GenID('company_id_seq');
					$_POST['owner'] = EGS_USERNAME;
					$_POST['companyid'] = EGS_COMPANY_ID;
				}
	
				$_POST['alteredby'] = EGS_USERNAME;
	
				/* Start a transaction */
				$this->db->StartTrans();
	
				if(isset($_POST['creditlimit'])) $_POST['creditlimit'] = intval($_POST['creditlimit']);
	
				$company = array();
				$company['id'] = $_POST['id'];
				$company['name'] = $_POST['name'];
				if(isset($_POST['creditlimit'])) $company['creditlimit'] = $_POST['creditlimit'];
				if(isset($_POST['vatnumber'])) $company['vatnumber'] = $_POST['vatnumber'];
				if(isset($_POST['companynumber'])) $company['companynumber'] = $_POST['companynumber'];
				if(isset($_POST['www'])) $company['www'] = $_POST['www'];
				else $company['www'] = '';
				if(isset($_POST['employees'])) $company['employees'] = $_POST['employees'];
				if(isset($_POST['branchcompanyid'])) $company['branchcompanyid'] = $_POST['branchcompanyid'];
				$company['assigned'] = $_POST['assigned'];
				$company['alteredby'] = EGS_USERNAME;
				$company['accountnumber'] = $_POST['accountnumber'];
				
				if($mode == 'INSERT') {
					$company['companyid'] = EGS_COMPANY_ID;
					$company['accountnumber'] = $_POST['accountnumber'];
					$company['owner'] = EGS_USERNAME;
				} else {
					$company['alteredby'] = EGS_USERNAME;
					$company['updated'] = $this->db->DBTimeStamp(time());
				}
	
				/* Insert the company */
				if (!$this->db->Replace('company', $company, 'id', true))
					$errors[] = _('Error saving company');
	
				/* Insert the address */
				if (isset ($_POST['street1'])) {
					$companyAddress = array ();
					$companyAddress['street1'] = $_POST['street1'];
					/* THis will set the sreet 2/3 or unset it needed */
					if (isset ($_POST['street2']))
						$companyAddress['street2'] = $_POST['street2'];
					else $companyAddress['street2'] = '';	
					if (isset ($_POST['street3']))
						$companyAddress['street3'] = $_POST['street3'];
					else $companyAddress['street3'] = '';
					
					$companyAddress['town'] = $_POST['town'];
					$companyAddress['county'] = $_POST['county'];
					if(is_numeric($_POST['postcode'])) {
						$companyAddress['postcode'] = $this->db->qstr($_POST['postcode']);
					}
					else
						$companyAddress['postcode'] = $_POST['postcode'];
					$companyAddress['countrycode'] = $_POST['countrycode'];
					$companyAddress['tag'] = 'MAIN';
					$companyAddress['companyid'] = $_POST['id'];
					
					if($mode == 'INSERT') {
						$companyAddress['name'] = _('Main');
						$companyAddress['main'] = 'true';
						$companyAddress['billing'] = 'true';
						$companyAddress['shipping'] = 'true';
						$companyAddress['payment'] = 'true';
						$companyAddress['technical'] = 'true';
					} else {
						$query = 'SELECT tag FROM companyaddress WHERE tag='.$this->db->qstr($companyAddress['tag']).' AND companyid='.$this->db->qstr($companyAddress['companyid']);
						
						if($this->db->GetOne($query) === false) {
							$companyAddress['name'] = _('Main');
							$companyAddress['main'] = 'true';
							$companyAddress['billing'] = 'true';
							$companyAddress['shipping'] = 'true';
							$companyAddress['payment'] = 'true';
							$companyAddress['technical'] = 'true';
						}
					}
	
					if (!$this->db->Replace('companyaddress', $companyAddress, array('tag', 'companyid'), true))
						$errors[] = _('Error saving company address');
				}
	
				/* Insert the contact details */
				$contacts = array ('phone', 'fax', 'email');
	
				/* Set an array to hold contact */
				$companyContact = array ();
				$companyContact['tag'] = 'MAIN';
				$companyContact['companyid'] = $_POST['id'];
	
				while ($contact = array_pop($contacts)) {
					if (isset ($_POST[$contact])) {
						$companyContact['contact'] = $_POST[$contact];
						$companyContact['type'] = strtoupper($contact {0});
						/* Change to T for phone */
						if($companyContact['type'] == 'P') $companyContact['type'] = 'T';
						
						if($mode == 'INSERT') {
						$companyContact['name'] = _('Main');
						$companyContact['main'] = 'true';
						$companyContact['billing'] = 'true';
						$companyContact['shipping'] = 'true';
						$companyContact['payment'] = 'true';
						$companyContact['technical'] = 'true';
					} else {
						$query = 'SELECT tag FROM companycontactmethod WHERE tag='.$this->db->qstr($companyContact['tag']).' AND type='.$this->db->qstr($companyContact['type']).' AND companyid='.$this->db->qstr($companyContact['companyid']);

						if($this->db->GetOne($query) === false) {
							$companyContact['name'] = _('Main');
							$companyContact['main'] = 'true';
							$companyContact['billing'] = 'true';
							$companyContact['shipping'] = 'true';
							$companyContact['payment'] = 'true';
							$companyContact['technical'] = 'true';
						}
						}
						if (!$this->db->Replace('companycontactmethod', $companyContact, array('tag', 'type', 'companyid'), true))
							$errors[] = _('Error saving company ')._($contact);
					}
					
					if(!isset($_POST[$contact])) {
						$type = strtoupper($contact {0});
						/* Change to T for phone */
						if($type == 'P') $type = 'T';
						
						/* If there is only one contact and it is unset we can delete it */
						$query = 'SELECT count(*) AS total FROM companycontactmethod WHERE main=true AND type='.$this->db->qstr($type).' AND companyid='.$this->db->qstr($companyContact['companyid']);
						
						$rs = $this->db->Execute($query);
						
						if($rs->fields['total'] == 1) {
							$query = 'DELETE FROM companycontactmethod WHERE main=true AND type='.$this->db->qstr($type).' AND companyid='.$this->db->qstr($companyContact['companyid']);
							
							$this->db->Execute($query);
						}
					}
				}
				
				/* If the user has access to CRM do the save */
				if(in_array('crm', $_SESSION['modules'])) {
					if(isset($_POST['crmstatusid'])) $crm['crmstatusid'] = $_POST['crmstatusid'];
					if(isset($_POST['crmaccountstatusid'])) $crm['crmaccountstatusid'] = $_POST['crmaccountstatusid'];
					if(isset($_POST['crmratingid'])) $crm['crmratingid'] = $_POST['crmratingid'];
					if(isset($_POST['terms'])) $crm['terms'] = $_POST['terms'];
					if(isset($_POST['crmsourceid'])) $crm['crmsourceid'] = $_POST['crmsourceid'];
					if(isset($_POST['crmindustryid'])) $crm['crmindustryid'] = $_POST['crmindustryid'];
					if(isset($_POST['revenue'])) $crm['revenue'] = intval($_POST['revenue']);
					if(isset($_POST['creditlimit'])) $crm['creditlimit'] = intval($_POST['creditlimit']);
					if(isset($_POST['accountnumber'])) $crm['accountnumber'] = $_POST['accountnumber'];
					if(isset($_POST['vatnumber'])) $crm['vatnumber'] = $_POST['vatnumber'];
					$crm['usercompanyid'] = EGS_COMPANY_ID;
					$crm['companyid'] = $_POST['id'];
					if(isset($_POST['companynumber'])) $crm['companynumber'] = $_POST['companynumber'];
					if(isset($_POST['employees'])) $crm['employees'] = $_POST['employees'];
					if(isset($_POST['companytype'])) $crm['companytype'] = $_POST['companytype'];
					if(isset($_POST['stocksymbol'])) $crm['stocksymbol'] = $_POST['stocksymbol'];
					if(isset($_POST['siccode'])) $crm['siccode'] = $_POST['siccode'];
	
					/* If they have erp do the accountstatus */
					if(isset($_POST['holdreason']) && in_array('weberp', $_SESSION['modules'])) 
						$crm['crmaccountstatusid'] = $_POST['holdreason'];
	
					if(!$this->db->Replace('companycrm', $crm, array('companyid', 'usercompanyid'), true))
						$errors[] = _('Error saving crm details');
				}
			
				/* We are ok to do the weberp save */
				if(in_array('weberp', $_SESSION['modules'])) {
					$_POST['companyid'] = EGS_COMPANY_ID;
	
					if(isset($_POST['iscustomer'])) {
						if(isset($_POST['customercurrcode'])) $customer['currcode'] = $_POST['customercurrcode'];
						if(isset($_POST['salestype'])) $customer['salestype'] = $_POST['salestype'];
						if(isset($_POST['holdreason'])) $customer['holdreason'] = $_POST['holdreason'];
						if(isset($_POST['paymentterms'])) $customer['paymentterms'] = $_POST['paymentterms'];
						if(isset($_POST['discount'])) $customer['discount'] = $_POST['discount'];
						if(isset($_POST['pymtdiscount'])) $customer['pymtdiscount'] = $_POST['pymtdiscount'];
						if(isset($_POST['creditlimit'])) $customer['creditlimit'] = $_POST['creditlimit'];
						if(isset($_POST['discountcode'])) $customer['discountcode'] = $_POST['discountcode'];
						if(isset($_POST['vatnumber'])) $customer['taxref'] = $_POST['vatnumber'];
						else $customer['taxref'] = '';
						$customer['companyid'] = $_POST['id'];
	
						if(!$this->db->Replace('company'.EGS_COMPANY_ID.'.erpdetails', $customer, 'companyid', true)) $errors[] = _('Error saving erp details');
						
						$customer = array();
						if(isset($_POST['estdeliverydays'])) $customer['estdeliverydays'] = $_POST['estdeliverydays'];
						if(isset($_POST['area'])) $customer['area'] = $_POST['area'];
						if(isset($_POST['fwddate'])) $customer['fwddate'] = $_POST['fwddate'];
						if(isset($_POST['defaultlocation'])) $customer['defaultlocation'] = $_POST['defaultlocation'];
						if(isset($_POST['customertaxauthority'])) $customer['taxauthority'] = $_POST['customertaxauthority'];
						if(isset($_POST['disabletrans'])) $customer['disabletrans'] = $_POST['disabletrans'];
						if(isset($_POST['defaultshipvia'])) $customer['defaultshipvia'] = $_POST['defaultshipvia'];
						if(isset($_POST['custbranchcode'])) $customer['custbranchcode'] = $_POST['custbranchcode'];
						$customer['companyid'] = $_POST['id'];
	
						if(!$this->db->Replace('company'.EGS_COMPANY_ID.'.erpbranchdetails', $customer, 'companyid', true)) $errors[] = _('Error saving erp branch details');	
					}
					
					if(isset($_POST['issupplier'])) {
						$supplier = array();
	
						if(isset($_POST['bankact'])) $supplier['bankact'] = $_POST['bankact'];
						if(isset($_POST['bankref'])) $supplier['bankref'] = $_POST['bankref'];
						if(isset($_POST['bankpartics'])) $supplier['bankpartics'] = $_POST['bankpartics'];
						if(isset($_POST['suppliertaxauthority'])) $supplier['taxauthority'] = $_POST['suppliertaxauthority'];
						if(isset($_POST['remittance'])) $supplier['remittance'] = $_POST['remittance'];
						if(isset($_POST['currcode'])) $supplier['currcode'] = $_POST['currcode'];
						if(isset($_POST['supplierpaymentterms'])) $supplier['paymentterms'] = $_POST['supplierpaymentterms'];
						if(isset($_POST['suppliercontact'])) $supplier['suppliercontact'] = $_POST['suppliercontact'];
						$supplier['companyid'] = $_POST['id'];
	
						$_POST['taxauthority'] = $_POST['suppliertaxauthority'];
						if(!$this->db->Replace('company'.EGS_COMPANY_ID.'.erpsupplierdetails', $supplier, 'companyid', true)) $errors[] = _('Error saving erp supplier details');	
					}
				}				
	
				/* Set the access */
				if($mode == 'INSERT') {
					if(isset($_SESSION['preferences'][EGS_COMPANY_ID]['restrictedread'])) $_POST['restrictedreadgroups'] = $_SESSION['preferences'][EGS_COMPANY_ID]['restrictedread'];
					if(isset($_SESSION['preferences'][EGS_COMPANY_ID]['read'])) $_POST['readgroups'] = $_SESSION['preferences'][EGS_COMPANY_ID]['read'];
					if(isset($_SESSION['preferences'][EGS_COMPANY_ID]['write'])) $_POST['writegroups'] = $_SESSION['preferences'][EGS_COMPANY_ID]['write'];
					
					if(!isset($_POST['branchcompanyid'])) $this->updateAccess($_POST);
				}
				
				$this->db->completeTrans();
			}
		}

		/* If there are no errors return true and set success message */
		if (sizeof($errors) == 0) {
			$messages = array();
			if($mode == 'INSERT') $messages[] = _('Company Successfully Added');
			else $messages[] = _('Company Successfully Updated');
			
			$smarty->assign('messages', $messages);
			return true;
		} else {
			$smarty->assign('errors', $errors);
			return false;
		}
	}
	
	/**
	 *  Function to update a company's addresses 
	 * */
	function updateAddress($_POST) {
		global $egs, $smarty;

		/* Array to hold errors */
		$errors = array ();

		if ($this->accessLevel($_POST['companyid']) < 4)
			$errors[] = _('You do not have the correct access to update the addresses associated with this company. If you beleive you should please contact your system administrator.');
			
		/* No errors so we can save */
		if (sizeof($errors) == 0) {	
				/* Start a transaction */
				$this->db->StartTrans();
	
				$query = 'UPDATE companyaddress SET main=false, billing=false, shipping=false, payment=false, technical=false WHERE companyid='.$this->db->qstr($_POST['companyid']);
				
				$this->db->Execute($query);
				
				while (list($key, $val) = each($_POST['type'])) {
					$query = 'UPDATE companyaddress SET '.$key.'=true WHERE tag='.$this->db->qstr(urldecode($val));
					
					$this->db->Execute($query);
				}
				
				$this->db->completeTrans();
		}
	}
	
	/**
	 *  Function to update a company's contacts
	 * */
	function updateContacts($_POST) {
		global $egs, $smarty;

		/* Array to hold errors */
		$errors = array ();

		if ($this->accessLevel($_POST['companyid']) < 4)
			$errors[] = _('You do not have the correct access to update the contacts associated with this company. If you beleive you should please contact your system administrator.');
			
		/* No errors so we can save */
		if (sizeof($errors) == 0) {	
				/* Start a transaction */
				$this->db->StartTrans();
	
				$query = 'UPDATE companycontactmethod SET main=false, billing=false, shipping=false, payment=false, technical=false WHERE companyid='.$this->db->qstr($_POST['companyid']).' AND type='.$this->db->qstr($_SESSION['preferences']['contactsView']);
				
				$this->db->Execute($query);
				
				while (list($key, $val) = each($_POST['type'])) {
					$query = 'UPDATE companycontactmethod SET '.$key.'=true WHERE tag='.$this->db->qstr(urldecode($val)).' AND type='.$this->db->qstr($_SESSION['preferences']['contactsView']);
					
					$this->db->Execute($query);
				}
				
				$this->db->completeTrans();
		}
	}
	
	/**
	 * Function to insert a company-address
	 * */
	function saveAddress($_POST, $id = null) {
		global $egs, $smarty;
		
		/* Array to hold errors */
		$errors = array ();

		/* Check details are valid  - starting with the name */
		if (!isset ($_POST['name']))
			$errors[] = _('No Address Name');
		/* and the address */
		if (!isset ($_POST['street1']) || !isset ($_POST['town']) || !isset ($_POST['county']) || !isset ($_POST['postcode']))
			$errors[] = _('Invalid address - The address must have a street, town, county and postcode');
		/* and the access */
		if ($this->accessLevel($_POST['companyid']) < 4)
			$errors[] = _('You do not have the correct access to add an address to this company. If you beleive you should please contact your system administrator.');
			
		/* No errors so we can save */
		if (sizeof($errors) == 0) {	
				/* Start a transaction */
				$this->db->StartTrans();
	
				/* Insert the address */
					$companyAddress = array ();
					$companyAddress['street1'] = $_POST['street1'];
					if (isset ($_POST['street2']))
						$companyAddress['street2'] = $_POST['street2'];
					if (isset ($_POST['street3']))
						$companyAddress['street3'] = $_POST['street3'];
					$companyAddress['town'] = $_POST['town'];
					$companyAddress['county'] = $_POST['county'];
					if(is_numeric($_POST['postcode'])) {
						
						$companyAddress['postcode'] = $this->db->qstr($_POST['postcode']);
					}
					else {
						
						$companyAddress['postcode'] = $_POST['postcode'];
					}
					$companyAddress['countrycode'] = $_POST['countrycode'];
					if(isset($_POST['tag'])) $companyAddress['tag'] = $_POST['tag'];
					else $companyAddress['tag'] = $_POST['name'];
					$companyAddress['name'] = $_POST['name'];
					$companyAddress['companyid'] = $_POST['companyid'];
	
					if (!$this->db->Replace('companyaddress', $companyAddress, array('tag', 'companyid'), true))
						$errors[] = _('Error saving company address');
				
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
	/**
	 * function to save a contact
	 */
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
		if ($this->accessLevel($_POST['companyid']) < 4)
			$errors[] = _('You do not have the correct access to add a contact to this company. If you beleive you should please contact your system administrator.');
			
		/* No errors so we can save */
		if (sizeof($errors) == 0) {	
				/* Start a transaction */
				$this->db->StartTrans();

				unset($_POST['save']);
				$_POST['tag'] = $_POST['name'];
				$_POST['type'] = $_SESSION['preferences']['contactsView'];
	
					if (!$this->db->Replace('companycontactmethod', $_POST, array('tag', 'type', 'companyid'), true))
						$errors[] = _('Error saving company contact');
				
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
	/**
	 * function to update a company's logo
	 */
	function updateLogo($companyId) {
		global $smarty;

		$errors = array();
		if(!isset($_FILES['file']['name'])) $errors[] = _('Please upload a file');
		else if($this->accessLevel($companyId) > 3) {

			if(isset($_FILES['file']) && ($_FILES['file']['error'] != UPLOAD_ERR_NO_FILE)) {
				$uploadedfile = EGS_FILE_ROOT.'/logos/'.$companyId.'.jpg';

				if(!move_uploaded_file($_FILES['file']['tmp_name'], $uploadedfile)) $errors[] = _('Error with uploaded file');
				else chmod($uploadedfile, 0755);
			}
		} else {
			$errors[] = _('You do not have the correct permissions to upload a file. If you beleive you should please contact your system administrator');
		}

		$smarty->assign('errors', $errors);
	}
	
	/**
	 * Function to get the parent id of the company 
	 * */
	function parentId($id) {
		global $db;

		$query = 'SELECT branchcompanyid FROM company WHERE id='.$this->db->qstr(intval($id));

		$rs = $this->db->getOne($query);

		if ($rs != '')
			return $this->parentId($rs);
		else
			return intval($id);
	}
	/**
	 * function to update the access-level of a company
	 */
	function updateAccess($_POST) {
		global $smarty;
		
		$id = $this->parentId($_POST['id']);
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
			$query = 'DELETE FROM companygroupaccessxref WHERE companyid='.$this->db->qstr($id).' AND groupid IN (SELECT id FROM groups WHERE companyid='.$this->db->qstr(EGS_COMPANY_ID).')';
			
			$this->db->Execute($query);
			
			$query = 'DELETE FROM companyuseraccessxref WHERE companyid='.$this->db->qstr($id).' AND usercompanyid='.$this->db->qstr(EGS_COMPANY_ID);
			
			$this->db->Execute($query);
			
			/* Prepare the insert for groups */
			$query = 'INSERT INTO companygroupaccessxref VALUES ('.$this->db->qstr($id).', ?, ?)';
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
			$query = 'INSERT INTO companyuseraccessxref VALUES ('.$this->db->qstr($id).', ?,'.$this->db->qstr(EGS_COMPANY_ID).', ?)';
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
			
			$smarty->assign('messages', array(_('Company access successfully updated')));
			return true;
		}
		else {
			$smarty->assign('errors', array(_('You do not have the correct access to update this company access. If you beleive you should please contact your system administrator.')));
		}
		
		return false;
	}
}
?>
