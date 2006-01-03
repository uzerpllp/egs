<?php
/*
 * Created on 01-Aug-2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class letter {
	function letter() {
		global $db;
		$this->db = & $db;
	}

function saveLetter($_POST, $id) {
		if(isset($_POST['company']))unset($_POST['company']);
		if(isset($_POST['person']))unset($_POST['person']);
		global $egs, $smarty;
		if($id != '') $id = intval($id);
		/* Array to hold errors */
		$errors = array ();
		/* Check details are valid  - starting with the name */
		if (!isset ($_POST['name']))
			$errors[] = _('No Letter Name');
			//echo '<br> valid'; echo print_r($_POST);
		if (!isset ($_POST['content']))
			$errors[] = _('No Letter');

		/* No errors so we can save */
		if (sizeof($errors) == 0) {
			/* Set weather to insert or update */
			if ($id != null)
				$mode = 'UPDATE';
			else
				$mode = 'INSERT';
				
				/* If we are doing an insert set some defaults */
				if ($mode == 'INSERT') {
					$_POST['id'] = $this->db->GenID('letters_id_seq');
					//$_POST['owner'] = EGS_USERNAME;
				}
	
				$_POST['alteredby'] = EGS_USERNAME;
	
				/* Start a transaction */
				$this->db->StartTrans();

				$_POST['alteredby'] = EGS_USERNAME;
				unset($_POST['save']);
				
				if($mode == 'UPDATE') {
					$_POST['alteredby'] = EGS_USERNAME;
					$_POST['updated'] = $this->db->DBTimeStamp(time());
					unset($_POST['updated']);
					unset($_POST['letterid']);
				}

				/* Insert the letter */
				//echo $_POST['content'];
				unset($_POST['alteredby']);
				$content = $_POST['content'];
				unset($_POST['content']);
				$post = array ();
				$post = $_POST;
				$post['companyid'] = EGS_COMPANY_ID;
				$post['body'] = $content;
				if (!$this->db->Replace('letters', $post, 'id', true)){	
					if ($mode == 'INSERT') $errors[] = _('Sorry, this letter name is already in used');
					else $errors[] = _('Error saving letter');
				}
				$this->db->completeTrans();
		}

		/* If there are no errors return true and set success message */
		if (sizeof($errors) == 0) {
			$messages = array();
			if($mode == 'INSERT') $messages[] = _('Letter Successfully Added');
			else $messages[] = _('Letter Successfully Updated');
			
			$smarty->assign('messages', $messages);
			return true;
		} else {
			$smarty->assign('errors', $errors);
			return false;
		}
	}

function deleteLetter($letterId) {
		global $smarty, $egs;
		if(EGS_CRMADMIN) {
			$query = 'Update letters set deleted = true where id = '.$this->db->qstr($letterId);

			$this->db->Execute($query);

			$smarty->assign('messages', array(_('Letter successfully deleted')));
			
			unset($_SESSION['preferences']['lastViewed']['module=letters&amp;action=view&amp;id='.$letterId]);
			
			$egs->syncPreferences();
			
			return true;
		} else {
			$smarty->assign('errors', array(_('You do not have the correct permissions to delete this letter. If you believe you should please contact your system administrator.')));
			
			return false;
		}
	}
	
}
?>