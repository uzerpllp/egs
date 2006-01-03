<?php
class note {
	function note() 
	{
		global $db;
		$this->db = $db;
	}

	function deleteCompanyNote($_POST) 
	{
		global $smarty;
		
		require_once(EGS_FILE_ROOT.'/src/classes/class.company.php');
		
		$company = new company();	
		
		if($company->accessLevel(intval($_POST['companyid'])) > 2){
			$query = 'DELETE FROM companynotes WHERE id='.$this->db->qstr(intval($_GET['noteid'])).' AND companyid='.$this->db->qstr(intval($_GET['companyid'])).' AND ownercompanyid='.$this->db->qstr(EGS_COMPANY_ID);
			
			if($this->db->Execute($query) === false) {
				$smarty->assign('errors', array(_('There was an error deleting the requested note. Perhaps it has already been deleted.')));
				
				return false;
			} else {
				$smarty->assign('messages', array(_('Note successfully deleted.')));
				
				return true;
			}
		} else {
			$smarty->assign('errors', array(_('You do not have the correct permissions to delete this note. If you beleive this to be incorrect please contact your system administrator.')));
			
			return false;
		}
	}
	
	function deletePersonNote($_POST) 
	{
		global $smarty;
		
		require_once(EGS_FILE_ROOT.'/src/classes/class.person.php');
		
		$person = new person();	
		
		if($person->accessLevel(intval($_POST['personid'])) > 2){
			$query = 'DELETE FROM personnotes WHERE id='.$this->db->qstr(intval($_GET['noteid'])).' AND personid='.$this->db->qstr(intval($_GET['personid'])).' AND ownercompanyid='.$this->db->qstr(EGS_COMPANY_ID);

			if($this->db->Execute($query) === false) {
				$smarty->assign('errors', array(_('There was an error deleting the requested note. Perhaps it has already been deleted.')));
				
				return false;
			} else {
				$smarty->assign('messages', array(_('Note successfully deleted.')));
				
				return true;
			}
		} else {
			$smarty->assign('errors', array(_('You do not have the correct permissions to delete this note. If you beleive this to be incorrect please contact your system administrator.')));
			
			return false;
		}
	}
	
	function deleteCRMNote($_POST) {
		global $smarty;

		require_once(EGS_FILE_ROOT.'/src/classes/class.crm.php');
		
		$crm = new crm();
			
		/* Attaching to note so check opportuniyt/case access */
		if(isset($_POST['opportunityid'])) {		
			$accessLevel = $crm->opportunityAccess(intval($_GET['opportunityid']));
		} else if(isset($_POST['caseid'])) {
			$accessLevel = $crm->caseAccess(intval($_GET['caseid']));
		}

			/* Correct access level to add */
			if ($accessLevel > 1) {
				$query = 'DELETE FROM crmnotes WHERE id='.$this->db->qstr(intval($_POST['noteid']));
			
			if($this->db->Execute($query) === false) {
				$smarty->assign('errors', array(_('There was an error deleting the requested note. Perhaps it has already been deleted.')));
				
				return false;
			} else {
				$smarty->assign('messages', array(_('Note successfully deleted.')));
				
				return true;
			}
		} else {
			$smarty->assign('errors', array(_('You do not have the correct permissions to delete this note. If you beleive this to be incorrect please contact your system administrator.')));
			
			return false;
		}
	}
	
	function saveNote($_POST, $id)
	{
		if(isset($_POST['company']))unset($_POST['company']);
		if(isset($_POST['person']))unset($_POST['person']);
		if(isset($_POST['companyid'])) return $this->saveCompanyNote($_POST, $id);
		if(isset($_POST['personid'])) return $this->savePersonNote($_POST, $id);
		if(isset($_POST['opportunityid']) || isset($_POST['caseid'])) return $this->saveCRMNote($_POST, $id);
	}
	
	function deleteNote($_POST)
	{
		if(isset($_POST['companyid'])) return $this->deleteCompanyNote($_POST);
		if(isset($_POST['personid'])) return $this->deletePersonNote($_POST);
		if(isset($_POST['opportunityid']) || isset($_POST['caseid'])) return $this->deleteCRMNote($_POST);
	}
	
	function saveCompanyNote($_POST, $id) {
		global $smarty;
		if(isset($_POST['company']))unset($_POST['company']);
		if(isset($_POST['person']))unset($_POST['person']);
		/* Attaching to note so check company access */
		if(isset($_POST['companyid'])) {
			require_once(EGS_FILE_ROOT.'/src/classes/class.company.php');
		
			$company = new company();

			/* Correct access level to add */
			if($company->accessLevel($_POST['companyid']) > 2) {

				/* Check note is filled out */
				if(!isset($_POST['description'])) {
					$smarty->assign('errors', array(_('No note')));
				} else {
					$note = array();

					if(isset($id)) {
						$mode = 'UPDATE';
						$note['id'] = $id;
						$note['alteredby'] = EGS_USERNAME;
						$note['updated'] = $this->db->DBTimeStamp(time());
					} else {
						$mode = 'INSERT';
						$note['id'] = $this->db->GenID('companynotes_id_seq');
						$note['owner'] = EGS_USERNAME;
					}

					$note['note'] = $_POST['description'];
					$note['companyid'] = intval($_POST['companyid']);
					$note['ownercompanyid'] = EGS_COMPANY_ID;

					if($this->db->Replace('companynotes', $note, array('id', 'companyid', 'ownercompanyid'), $mode)) {
						
						if($mode == 'INSERT') $smarty->assign('messages', array(_('Note successfully added')));
						else if($mode == 'UPDATE') $smarty->assign('messages', array(_('Note successfully updated')));

						return true;
					} else {
						$smarty->assign('errors', array(_('Error saving note, please try again later')));

						return false;
					}
				}
			}
		}
	}
	
	function savePersonNote($_POST, $id) {
		global $smarty;
		if(isset($_POST['company']))unset($_POST['company']);
		if(isset($_POST['person']))unset($_POST['person']);
		/* Attaching to note so check person access */
		if(isset($_POST['personid'])) {
			require_once(EGS_FILE_ROOT.'/src/classes/class.person.php');
		
			$person = new person();

			/* Correct access level to add */
			if($person->accessLevel($_POST['personid']) > 2) {

				/* Check note is filled out */
				if(!isset($_POST['description'])) {
					$smarty->assign('errors', array(_('No note')));
				} else {
					$note = array();

					if(isset($id)) {
						$mode = 'UPDATE';
						$note['id'] = $id;
						$note['alteredby'] = EGS_USERNAME;
						$note['updated'] = $this->db->DBTimeStamp(time());
					} else {
						$mode = 'INSERT';
						$note['id'] = $this->db->GenID('personnotes_id_seq');
						$note['owner'] = EGS_USERNAME;
					}

					$note['note'] = $_POST['description'];
					$note['personid'] = intval($_POST['personid']);
					$note['ownercompanyid'] = EGS_COMPANY_ID;

					if($this->db->Replace('personnotes', $note, array('id', 'personid', 'ownercompanyid'), $mode)) {
						
						if($mode == 'INSERT') $smarty->assign('messages', array(_('Note successfully added')));
						else if($mode == 'UPDATE') $smarty->assign('messages', array(_('Note successfully updated')));

						return true;
					} else {
						$smarty->assign('errors', array(_('Error saving note, please try again later')));

						return false;
					}
				}
			}
		}
	}
	
	function saveCRMNote($_POST, $id) {
		global $smarty;
		if(isset($_POST['company']))unset($_POST['company']);
		if(isset($_POST['person']))unset($_POST['person']);
		require_once(EGS_FILE_ROOT.'/src/classes/class.crm.php');
		
		$crm = new crm();
			
		/* Attaching to note so check opportuniyt/case access */
		if(isset($_POST['opportunityid'])) {		
			$accessLevel = $crm->opportunityAccess(intval($_GET['opportunityid']));
		} else if(isset($_POST['caseid'])) {
			$accessLevel = $crm->caseAccess(intval($_GET['caseid']));
		}

			/* Correct access level to add */
			if ($accessLevel > 1) {
				/* Check note is filled out */
				if(!isset($_POST['description'])) {
					$smarty->assign('errors', array(_('No note')));
				} else {
					$note = array();

					if(isset($id)) {
						$mode = 'UPDATE';
						$note['id'] = $id;
						$note['alteredby'] = EGS_USERNAME;
						$note['updated'] = $this->db->DBTimeStamp(time());
					} else {
						$mode = 'INSERT';
						$note['id'] = $this->db->GenID('companynotes_id_seq');
						$note['owner'] = EGS_USERNAME;
					}

					$note['note'] = $_POST['description'];
					if(isset($_POST['opportunityid'])) {
						$note['opportunityid'] = intval($_POST['opportunityid']);
						$type = 'opportunity';
					} else if(isset($_POST['caseid'])) {
						$note['caseid'] = intval($_POST['caseid']);
						$type = 'case';
					}

					if($this->db->Replace('crmnotes', $note, array('id', $type.'id'), $mode)) {
						
						if($mode == 'INSERT') $smarty->assign('messages', array(_('Note successfully added')));
						else if($mode == 'UPDATE') $smarty->assign('messages', array(_('Note successfully updated')));

						return true;
					} else {
						$smarty->assign('errors', array(_('Error saving note, please try again later')));

						return false;
					}
				}
			}
	}
}
