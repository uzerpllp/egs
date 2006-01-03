<?php  
class users {
	/**
	 * Constructor- sets up the database
	 */
	function users() {
		global $db;
		$this->db = $db;
	}
 	/**
 	 * Tries to login a user
 	 * 
 	 * Checks the provided username and password against the table of users, and logs in or fails accordingly.
 	 * On success, defines constants for access levels, retrieves the stored preferences, and the list of permitted
 	 * modules.
 	 * 
 	 * @return boolean
 	 */
	function login($username, $password, $companyId='', $noPassword=false) {
		/* Get the last login if set */
		if($companyId == '') {
			$query = 'SELECT lastcompanylogin FROM users WHERE username='.$this->db->qstr($username);
			
			$lastCompany = $this->db->GetOne($query);
			
			if($lastCompany != '') $companyId = $lastCompany;
		}
			
		/* Build the query to select the user info from the database */
		$query = '
			      SELECT * FROM useroverview
			      WHERE
			      (
			        username='.$this->db->qstr($username).'
			        AND ';
		if(!$noPassword) {
			$query .= '
			        password='.$this->db->qstr(md5(strip_tags($password))).'
			        AND ';
		}
		
		$query .= '
			        access='.$this->db->qstr('true');
			        
		if($companyId != '') {
			$query .= '
					AND 
					companyid='.$this->db->qstr(intval($companyId));
		}
		
		$query .= '
			      )
				  LIMIT 1
			      ';

		/* Send the query */
		$user =& $this->db->GetRow($query);

		/* Die if there is an error */
		if (EGS_DEBUG_SQL && !$user) die($this->db->ErrorMsg());

		/* If there is a row returned then return true so user can login */
		if (isset($user['username']) && ($user['username'] != '')) {
			/* Define the username and activate the session */
			if(!defined('EGS_USERNAME')) define('EGS_USERNAME', $user['username']);
			if(!defined('EGS_COMPANY_ID')) define('EGS_COMPANY_ID', $user['companyid']);
			
			$query = 'UPDATE users set lastcompanylogin='.$this->db->qstr(EGS_COMPANY_ID).' WHERE username='.$this->db->qstr($username);

			$this->db->Execute($query);

			if(!defined('EGS_LANG')) define('EGS_LANG', $user['lang']);
			if(!defined('EGS_PERSON_ID')) define('EGS_PERSON_ID', $user['id']);
			if(!defined('EGS_PERSON_NAME')) define('EGS_PERSON_NAME', $user['name']);
			if(!defined('EGS_SUPERUSER') && ($user['superuser'] == 'true')) define('EGS_SUPERUSER', true);
			else if(!defined('EGS_SUPERUSER')) define('EGS_SUPERUSER', false);
			if(!defined('EGS_DOMAINADMIN') && ($user['domainuser'] == 'true')) define('EGS_DOMAINADMIN', true);
			else if(!defined('EGS_DOMAINADMIN')) define('EGS_DOMAINADMIN', false);
			if(!defined('EGS_PROJECTMANAGER') && ($user['projectmanager'] == 'true')) define('EGS_PROJECTMANAGER', true);
			else if(!defined('EGS_PROJECTMANAGER')) define('EGS_PROJECTMANAGER', false);
			if(!defined('EGS_TICKETADMIN') && ($user['ticketadmin'] == 'true')) define('EGS_TICKETADMIN', true);
			else if(!defined('EGS_TICKETADMIN')) define('EGS_TICKETADMIN', false);
			if(!defined('EGS_CALENDARADMIN') && ($user['calendaradmin'] == 'true')) define('EGS_CALENDARADMIN', true);
			else if(!defined('EGS_CALENDARADMIN')) define('EGS_CALENDARADMIN', false);
			if(!defined('EGS_CRMADMIN') && ($user['crmadmin'] == 'true')) define('EGS_CRMADMIN', true);
			else if(!defined('EGS_CRMADMIN')) define('EGS_CRMADMIN', false);
			$_SESSION['loggedIn'] = true;

			$query = 'SELECT companyid FROM person WHERE owner='.$this->db->qstr($username).' AND userdetail';
			
			if(!defined('EGS_ACTUAL_COMPANY_ID')) define('EGS_ACTUAL_COMPANY_ID', $this->db->GetOne($query));
			
			$query = 'SELECT theme FROM companydefaults WHERE companyid='.$this->db->qstr(EGS_COMPANY_ID);
			
			if(!defined('EGS_THEME')) define('EGS_THEME', $this->db->GetOne($query));
			/* Set the settings */
			if(is_array(unserialize(base64_decode($user['settings'])))) $_SESSION['preferences'] = unserialize(base64_decode($user['settings']));
			else $_SESSION['preferences'] = array();

			/* Get the user modules */
			$this->getModules();
			
			return true;
		}
		/* User is not allowed access */
		else {
			
			return false;
		}

		/* We should neve be here but return false if we are. User won't logon */
		return false;
	}
	
	/**
	 *  Check if user is a super user for the current company
	 * 
	 * @return boolean
	 **/
	function isSuperUser() {
		/* Only do DB lookup if logged in */
		if(defined('EGS_USERNAME')) {
			/* If the status is already defined, retun it */
			if(defined('EGS_SUPERUSER')) return EGS_SUPERUSER;
			/* Do the DB lookup */
			else {
				/* Build the query to select the user info from the database */
				$query = '
					      SELECT superuser FROM useroverview
					      WHERE
					      (
					        username='.$this->db->qstr(EGS_USERNAME).'
					        AND
					        access='.$this->db->qstr('true').'
					      )
					      ';
		
				/* Send the query */
				$superuser =& $this->db->GetOne($query);
				
				/* Die if there is an error */
				if (EGS_DEBUG_SQL && !$superuser) die($this->db->ErrorMsg());
		
				/* If there is a row returned then return true as user is superuser */
				if (trim($superuser) == 'true') {
					/* Define the superuser status */
					if(!defined('EGS_SUPERUSER')) define('EGS_SUPERUSER', true);
				}
				/* User is not superuser */
				else {
					if(!defined('EGS_SUPERUSER')) define('EGS_SUPERUSER', false);
				}
			}
		} else {
			if(!defined('EGS_SUPERUSER')) define('EGS_SUPERUSER', false);
		}	
	}
	
	/**
	 *  Function to get users modules 
	 * 	
	 *  The list of allowed modules depends on both the group and user settings, as well as
	 *  the setup/preferences of their company. Finally, the module names are translated
	 *  to be displayed.
	 * 
	 * @todo do something with the module-ordering
	 * */
	function getModules()
	{
		/* If the modules are not set then do a db lookup */
		if(!isset($_SESSION['modules'])) {
			/* If the user is a super user they can access all their company's modules */
		    if ($this->isSuperUser ())
		      {
		        /* Select the module name from the database */
		        $query = '
						SELECT m.name FROM
						companymoduleaccess AS a,
						module AS m
						WHERE
						(
							m.id=a.moduleid AND
							a.companyid='.$this->db->qstr(EGS_COMPANY_ID).'
						)
						ORDER BY id
					';
		      }
		    /* Otherwise get the modules that they group can access */
		    else
		      {
		        /* Select the module name from the database */
		        $query = '
						SELECT DISTINCT m.name 
						FROM 
						module AS m,
						groupmoduleaccess AS a,
						groups AS g,
						groupmembers AS gm 
						WHERE
						(
							gm.groupid=g.id AND 
							gm.username='.$this->db->qstr(EGS_USERNAME).' AND 
							g.companyid='.$this->db->qstr(EGS_COMPANY_ID).' AND 
							a.groupid=gm.groupid AND 
							m.id=a.moduleid
						)
					';
		      }

			$_SESSION['modules'] = array('home');
			$_SESSION['translatedModules'] = array();
			$_SESSION['orderedModules'] = array();
			
			/* This is an array with the module order in it, at a later we will offer user customisation of this */
			$moduleOrder = array();
			
			$moduleOrder[] = 'home';
			$moduleOrder[] = 'crm';
			$moduleOrder[] = 'contacts';
			$moduleOrder[] = 'weberp';
			$moduleOrder[] = 'ticketing';
			$moduleOrder[] = 'calendar';
			$moduleOrder[] = 'projects';
			$moduleOrder[] = 'filesharing';
			$moduleOrder[] = 'domain';
			$moduleOrder[] = 'store';
			$moduleOrder[] = 'wiki';
			
			$moduleNames = array();
			$moduleNames['home'] = 'Home';
			$moduleNames['crm'] = 'CRM';
			$moduleNames['contacts'] = 'Contacts';
			$moduleNames['calendar'] = 'Calendar';
			$moduleNames['projects'] = 'Projects';
			$moduleNames['filesharing'] = 'Files';
			$moduleNames['admin'] = 'Admin';
			$moduleNames['systemadmin'] = 'System Admin';
			$moduleNames['ticketing'] = 'Tickets';
			$moduleNames['website'] = 'Websites';
			$moduleNames['domain'] = 'Domains';
			$moduleNames['weberp'] = 'ERP';
			$moduleNames['store'] = 'Store';
			$moduleNames['wiki'] = 'Wiki';

		    /* Send the query */
		    $rs = &$this->db->Execute($query);
			if (EGS_DEBUG_SQL && !$rs) die($this->db->ErrorMsg());
			else {
			while (!$rs->EOF) {
				array_push($_SESSION['modules'], $rs->fields['name']);
				$rs->MoveNext();
			}
			}
			$rs->Close();
			
			/* Iterate over available Modules and Translate and put in order */
			for($i=0; $i<sizeof($_SESSION['modules']); $i++) {
				if(isset($moduleNames[$_SESSION['modules'][$i]])) array_push($_SESSION['translatedModules'], _($moduleNames[$_SESSION['modules'][$i]]));
				if(in_array($_SESSION['modules'][$i], $moduleOrder)) {
					array_push($_SESSION['orderedModules'], array('name' => $_SESSION['modules'][$i], 'translated' => _($moduleNames[$_SESSION['modules'][$i]])));
					
					if($_SESSION['modules'][$i] == 'tikiwiki') {
						
					}
				}
			}
	      }
	}
}
