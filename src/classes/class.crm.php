<?php
class crm {
	function crm() {
		global $db;
		$this->db = $db;
	}

	function opportunityAccess($id) {
		$query = 'SELECT id, personid, companyid FROM opportunity WHERE id='.$this->db->qstr($id).' AND owner='.$this->db->qstr(EGS_USERNAME).' OR assigned='.$this->db->qstr(EGS_USERNAME).' AND usercompanyid='.$this->db->qstr(EGS_COMPANY_ID);

		if ($this->db->GetOne($query) === false) {
			$query = 'SELECT personid, companyid FROM opportunity WHERE id='.$this->db->qstr($id).' AND usercompanyid='.$this->db->qstr(EGS_COMPANY_ID);

			$opportunity = $this->db->GetRow($query);

			require_once (EGS_FILE_ROOT.'/src/classes/class.person.php');

			$person = new person();

			if (isset($opportunity['personid']) && ($person->accessLevel($opportunity['personid']) > 2))
				return 2;
			else if (isset($opportunity['personid']) && ($person->accessLevel($opportunity['personid']) > 1))
				return 1;
			else {
				require_once (EGS_FILE_ROOT.'/src/classes/class.company.php');

				$company = new company();

				if (isset($opportunity['companyid']) && ($company->accessLevel($opportunity['companyid']) > 2))
					return 2;
				else if (isset($opportunity['companyid']) && ($company->accessLevel($opportunity['companyid']) > 1))
					return 1;
			}
			return false;
		} else
			return 2;
	}

	function deleteOpportunity($id) {
		global $smarty;

		$query = 'SELECT id, companyid, personid FROM opportunity WHERE usercompanyid='.$this->db->qstr(EGS_COMPANY_ID).' AND id='.$this->db->qstr($id);
		
		$opportunity = $this->db->GetRow($query);
		
		require_once (EGS_FILE_ROOT.'/src/classes/class.person.php');

		$person = new person();

		require_once (EGS_FILE_ROOT.'/src/classes/class.company.php');

		$company = new company();

		$errors = array ();
		
		if(isset($id)) {				
		$personAccess = 0;
		$companyAccess = 0;
					
		$accessLevel = $this->opportunityAccess($id);
		
		if(!$accessLevel) {					
			$personAccess = $person->accessLevel($opportunity['personid']);
						
			if($personAccess > 2) $accessLevel = true;
			else {
				$companyAccess = $company->accessLevel($opportunity['companyid']);
							
				if($companyAccess > 2) $accessLevel = true;
			}	
		}
		}
		
		if ($accessLevel) {		
			/* This takes the opportunity out from the last viewed and redirects to approriate thing */
			unset($_SESSION['preferences']['lastViewed']['module=contacts&amp;action=viewopportunity&amp;id='.$id]);
				
				$smarty->assign('redirectAction', key($_SESSION['preferences']['lastViewed']));
				global $egs;
				$egs->syncPreferences();
			
			$query = 'DELETE FROM opportunity WHERE id='.$this->db->qstr($id).' AND usercompanyid='.$this->db->qstr(EGS_COMPANY_ID);

			$this->db->Execute($query);
			
			$smarty->assign('messages', array(_('Opportunity Successfully Deleted')));
			
		} else {
			$smarty->assign('errors', array(_('You do not have the correct access to delete this opportunity. If you beleive you should please contact your system administrator.')));	
		}
		
		return true;
	}

	function deleteActivity($id) {
		global $smarty;

		
		if ($this->activityAccess($id) > 1) {		
			/* This takes the opportunity out from the last viewed and redirects to approriate thing */
			unset($_SESSION['preferences']['lastViewed']['module=contacts&amp;action=viewactivity&amp;id='.$id]);
				
				$smarty->assign('redirectAction', key($_SESSION['preferences']['lastViewed']));
				global $egs;
				$egs->syncPreferences();
			
			$query = 'DELETE FROM activity WHERE id='.$this->db->qstr($id).' AND usercompanyid='.$this->db->qstr(EGS_COMPANY_ID);

			$this->db->Execute($query);
			
			$smarty->assign('messages', array(_('Activity Successfully Deleted')));
			
		} else {
			$smarty->assign('errors', array(_('You do not have the correct access to delete this activity. If you beleive you should please contact your system administrator.')));	
		}
		
		return true;
	}
	
	function completeActivity($id) {
		global $smarty;

		
		if ($this->activityAccess($id) > 1) {		
			$query = 'UPDATE activity SET completed=now()  WHERE id='.$this->db->qstr($id).' AND usercompanyid='.$this->db->qstr(EGS_COMPANY_ID);

			$this->db->Execute($query);
			
		}
		
		return true;
	}
	
	function deleteCase($id) {
		global $smarty;

		$query = 'SELECT id, companyid, personid FROM crmcase WHERE usercompanyid='.$this->db->qstr(EGS_COMPANY_ID).' AND id='.$this->db->qstr($id);
		
		$case = $this->db->GetRow($query);
		
		require_once (EGS_FILE_ROOT.'/src/classes/class.person.php');

		$person = new person();

		require_once (EGS_FILE_ROOT.'/src/classes/class.company.php');

		$company = new company();

		$errors = array ();
		
		if(isset($id)) {				
		$personAccess = 0;
		$companyAccess = 0;
					
		$accessLevel = $this->caseAccess($id);
		
		if(!$accessLevel) {					
			$personAccess = $person->accessLevel($case['personid']);
						
			if($personAccess > 2) $accessLevel = true;
			else {
				$companyAccess = $company->accessLevel($case['companyid']);
							
				if($companyAccess > 2) $accessLevel = true;
			}	
		}
		}
		
		if ($accessLevel) {		
			/* This takes the case out from the last viewed and redirects to approriate thing */
			unset($_SESSION['preferences']['lastViewed']['module=contacts&amp;action=viewcase&amp;id='.$id]);
				
				$smarty->assign('redirectAction', key($_SESSION['preferences']['lastViewed']));
				global $egs;
				$egs->syncPreferences();
			
			$query = 'DELETE FROM crmcase WHERE id='.$this->db->qstr($id).' AND usercompanyid='.$this->db->qstr(EGS_COMPANY_ID);

			$this->db->Execute($query);
			
			$smarty->assign('messages', array(_('Case Successfully Deleted')));
			
		} else {
			$smarty->assign('errors', array(_('You do not have the correct access to delete this case. If you beleive you should please contact your system administrator.')));	
		}
		
		return true;
	}

	function caseAccess($id) {
		$query = 'SELECT id, personid, companyid FROM crmcase WHERE id='.$this->db->qstr($id).' AND owner='.$this->db->qstr(EGS_USERNAME).' OR assigned='.$this->db->qstr(EGS_USERNAME).' AND usercompanyid='.$this->db->qstr(EGS_COMPANY_ID);

		if ($this->db->GetOne($query) === false) {
			$query = 'SELECT personid, companyid FROM crmcase WHERE id='.$this->db->qstr($id).' AND usercompanyid='.$this->db->qstr(EGS_COMPANY_ID);

			$case = $this->db->GetRow($query);

			require_once (EGS_FILE_ROOT.'/src/classes/class.person.php');

			$person = new person();

			if (isset($case['personid']) && ($person->accessLevel($case['personid']) > 2))
				return 2;
			else if (isset($case['personid']) && ($person->accessLevel($case['personid']) > 1))
				return 1;
			else {
				require_once (EGS_FILE_ROOT.'/src/classes/class.company.php');

				$company = new company();

				if (isset($case['companyid']) && ($company->accessLevel($case['companyid']) > 2))
					return 2;
				else if (isset($case['companyid']) && ($company->accessLevel($case['companyid']) > 1))
					return 1;
			}
			return false;
		} else
			return 2;
	}
	
	function activityAccess($id) {
		$query = 'SELECT id, personid, companyid FROM activityoverview WHERE id='.$this->db->qstr($id).' AND owner='.$this->db->qstr(EGS_USERNAME).' OR assigned='.$this->db->qstr(EGS_USERNAME).' AND usercompanyid='.$this->db->qstr(EGS_COMPANY_ID);

		if ($this->db->GetOne($query) === false) {
			$query = 'SELECT personid, companyid, caseid, opportunityid FROM activity WHERE id='.$this->db->qstr($id).' AND usercompanyid='.$this->db->qstr(EGS_COMPANY_ID);

			$activity = $this->db->GetRow($query);

			if($activity['caseid'] != '') return $this->caseAccess($activity['caseid']);
			if($activity['opportunityid'] != '') return $this->opportunityAccess($activity['opportunityid']);
			
			require_once (EGS_FILE_ROOT.'/src/classes/class.person.php');

			$person = new person();

			if (isset($activity['personid']) && ($person->accessLevel($activity['personid']) > 2))
				return 2;
			else if (isset($activity['personid']) && ($person->accessLevel($activity['personid']) > 1))
				return 1;
			else {
				require_once (EGS_FILE_ROOT.'/src/classes/class.company.php');

				$company = new company();

				if (isset($activity['companyid']) && ($company->accessLevel($activity['companyid']) > 2))
					return 2;
				else if (isset($activity['companyid']) && ($company->accessLevel($activity['companyid']) > 1))
					return 1;
			}
			return false;
		} else
			return 2;
	}

	function saveCase($_POST, $id) {
		global $smarty;
		if(isset($_POST['company']))unset($_POST['company']);
		if(isset($_POST['person']))unset($_POST['person']);
		require_once (EGS_FILE_ROOT.'/src/classes/class.person.php');

		$person = new person();

		require_once (EGS_FILE_ROOT.'/src/classes/class.company.php');

		$company = new company();

		$errors = array ();

		if (isset ($id) && ($this->caseAccess($id) < 2)) {
			$errors[] = _('You do not have the correct access to update this case');
		} else {
			/* Check the name is complete */
			if (!isset ($_POST['name'])) {
				$errors[] = _('No name');
			}

			if (isset ($_POST['companyid']) && ($company->accessLevel($_POST['companyid']) < 3)) {
				$errors[] = _('You do not have the correct access to attach this case to the requested account');
			}

			if (isset ($_POST['personid']) && ($person->accessLevel($_POST['personid']) < 3)) {
				$errors[] = _('You do not have the correct access to attach this case to the requested contact');
			}
		}

		if (sizeof($errors) == 0) {

			if ($id != null)
				$mode = 'UPDATE';
			else
				$mode = 'INSERT';

			if ($mode == 'INSERT') {
				$_POST['id'] = $this->db->GenID('crmcase_id_seq');
				$_POST['owner'] = EGS_USERNAME;
			} else {
				$_POST['updated'] = $this->db->DBTimeStamp(time());
			}

			unset ($_POST['save']);
			unset ($_POST['personname']);
			unset ($_POST['companyname']);
			unset ($_POST['enddateoutput']);
			$_POST['alteredby'] = EGS_USERNAME;
			$_POST['usercompanyid'] = EGS_COMPANY_ID;

			if (!$this->db->Replace('crmcase', $_POST, array ('id', 'usercompanyid'), true))
				$errors[] = _('Error saving case');
		}

		/* If there are no errors return true and set success message */
		if (sizeof($errors) == 0) {
			$messages = array ();
			if ($mode == 'INSERT')
				$messages[] = _('Case Successfully Added');
			else
				$messages[] = _('Case Successfully Updated');

			$smarty->assign('messages', $messages);
			return $_POST['id'];
		} else {
			$smarty->assign('errors', $errors);
			return false;
		}
	}

	function saveOpportunity(&$_POST, $id) {
		global $smarty;
		if(isset($_POST['company']))unset($_POST['company']);
		if(isset($_POST['person']))unset($_POST['person']);
		require_once (EGS_FILE_ROOT.'/src/classes/class.person.php');

		$person = new person();

		require_once (EGS_FILE_ROOT.'/src/classes/class.company.php');

		$company = new company();

		$errors = array ();

		if (isset ($id) && ($this->opportunityAccess($id) < 2)) {
			$errors[] = _('You do not have the correct access to update this opportunity');
		} else {
			/* Check the name is complete */
			if (!isset ($_POST['name'])) {
				$errors[] = _('No name');
			}

			if (isset ($_POST['companyid']) && ($company->accessLevel($_POST['companyid']) < 3)) {
				$errors[] = _('You do not have the correct access to attach this opportunity to the requested account');
			}

			if (isset ($_POST['personid']) && ($person->accessLevel($_POST['personid']) < 3)) {
				$errors[] = _('You do not have the correct access to attach this opportunity to the requested contact');
			}
		}

		if (sizeof($errors) == 0) {

			if ($id != null)
				$mode = 'UPDATE';
			else
				$mode = 'INSERT';

			if ($mode == 'INSERT') {
				$_POST['id'] = $this->db->GenID('opportunity_id_seq');
				$_POST['owner'] = EGS_USERNAME;
			} else {
				$_POST['updated'] = $this->db->DBTimeStamp(time());
			}

			if(!isset($_POST['nextstep'])) $_POST['nextstep'] = '';
			
			unset ($_POST['save']);
			unset ($_POST['personname']);
			unset ($_POST['companyname']);
			unset ($_POST['enddateoutput']);
			
			$_POST['alteredby'] = EGS_USERNAME;
			$_POST['usercompanyid'] = EGS_COMPANY_ID;

			if (!$this->db->Replace('opportunity', $_POST, array ('id', 'usercompanyid'), true))
				$errors[] = _('Error saving opportunity');
		}

		/* If there are no errors return true and set success message */
		if (sizeof($errors) == 0) {
			$messages = array ();
			if ($mode == 'INSERT')
				$messages[] = _('Opportunity Successfully Added');
			else
				$messages[] = _('Opportunity Successfully Updated');

			$smarty->assign('messages', $messages);
			return $_POST['id'];
		} else {
			$smarty->assign('errors', $errors);
			return false;
		}
	}
	
	function saveActivity($_POST, $id) {
		global $smarty;
		if(isset($_POST['company']))unset($_POST['company']);
		if(isset($_POST['person']))unset($_POST['person']);
		require_once (EGS_FILE_ROOT.'/src/classes/class.person.php');

		$person = new person();

		require_once (EGS_FILE_ROOT.'/src/classes/class.company.php');

		$company = new company();

		$errors = array ();

		
		if (isset ($id) && $this->activityAccess($id)) {
			$personAccess = 0;
		$companyAccess = 0;
					
		$accessLevel = $this->opportunityAccess($id);
		
		if(!$accessLevel) {					
			$personAccess = $person->accessLevel($_POST['personid']);
						
			if($personAccess > 2) $accessLevel = true;
			else {
				$companyAccess = $company->accessLevel($_POST['companyid']);
							
				if($companyAccess > 2) $accessLevel = true;
			}	
		}
		if(!$accessLevel) $errors[] = _('You do not have the correct access to update this activity');
		} else {
			/* Check the name is complete */
			if (!isset ($_POST['name'])) {
				$errors[] = _('No name');
			}

			if (isset ($_POST['companyid']) && ($company->accessLevel($_POST['companyid']) < 3)) {
				$errors[] = _('You do not have the correct access to attach this activity to the requested account');
			}

			if (isset ($_POST['personid']) && ($person->accessLevel($_POST['personid']) < 3)) {
				$errors[] = _('You do not have the correct access to attach this activity to the requested contact');
			}
		}

		if (sizeof($errors) == 0) {

			if ($id != null)
				$mode = 'UPDATE';
			else
				$mode = 'INSERT';

			if ($mode == 'INSERT') {
				$_POST['id'] = $this->db->GenID('activity_id_seq');
			} else {
				$_POST['updated'] = $this->db->DBTimeStamp(time());
			}

			unset ($_POST['save']);
			unset ($_POST['personname']);
			unset ($_POST['companyname']);
			unset ($_POST['enddateoutput']);
			unset ($_POST['startdateoutput']);
			unset ($_POST['completedoutput']);
			$_POST['usercompanyid'] = EGS_COMPANY_ID;
			
			if(!isset($_POST['completed'])) $_POST['completed'] = 'null';
			
			if(isset($_POST['itemtype']) && isset($_POST['itemid'])) $_POST[$_POST['itemtype'].'id'] = $_POST['itemid'];
			
			unset ($_POST['itemitem']);
			unset ($_POST['itemname']);
			unset ($_POST['itemtype']);
			unset ($_POST['itemid']);
			
			if(!isset($_POST['crmactivityid'])) $_POST['crmactivityid'] = 'null';

			if (!$this->db->Replace('activity', $_POST, array ('id', 'usercompanyid'), true))
				$errors[] = _('Error saving activity');
		}

		/* If there are no errors return true and set success message */
		if (sizeof($errors) == 0) {
			$messages = array ();
			if ($mode == 'INSERT')
				$messages[] = _('Activity Successfully Added');
			else
				$messages[] = _('Activity Successfully Updated');

			$smarty->assign('messages', $messages);
			return $_POST['id'];
		} else {
			$smarty->assign('errors', $errors);
			return false;
		}
	}
}
?>