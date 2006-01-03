<?php
/**
 * provides a set of functions useful throughout the system
 */
class egs {
	/**
	 * constructor- sets up the database for use within the class
	 * 
	 */
	function egs()
	{
		global $db;
		$this->db = $db;
	}
	
	/**
	 * returns a list of all users in the current company
	 * 
	 * Uses EGS_COMPANY_ID to determine which users are part of the company, and returns an array
	 * of the form [username]=>username
	 * 
	 * @return array(string => string)
	 */
	function getUsers() {
 		$query = 'SELECT username FROM useraccess WHERE companyid='.$this->db->qstr(EGS_COMPANY_ID).' ORDER BY username';	
 		
 		$rs =  $this->db->Execute($query);
 		
 		$users = array('' => _('All Users'));
 		
 		while(!$rs->EOF) {
 			$users[$rs->fields['username']] = $rs->fields['username'];
 				
 			$rs->MoveNext();
 		}
 		
 		return $users;
 	}

	/** 
	 * Syncs session to constants
	 * 
	 * Iterates over the $_SESSION superglobal and for each variable that begins 'EGS_', it gets
	 * define as a constant (it ignores anything beginning with 'EGS_DB_')
	 * 
	 * @see syncToSession
	 * */
	function syncToConstants()
	{
		/* Now iterate over the session */
		while (list($key, $val) = each($_SESSION))
		{
			/* If the session variable begins with 'EGS' define it */
			if((substr($key,0,7) != 'EGS_DB_') && (substr($key,0,4) == 'EGS_') && (!is_object($val) && !is_array($val)) && !defined($key)) define($key, $val);
		}
	}

	/**
	 * Syncs contstants to the session
	 * 
	 * Takes all defined constants, and if they begin 'EGS_', they are assigned to variables
	 * in the superglobal array $_SESSION
	 * 
	 * @see syncToConstants 
	 * */
	function syncToSession()
	{
		/* Get all the defined constants */
		$constants = get_defined_constants();

		/* Now iterate over the array of constants */
		while (list($key, $val) = each($constants))
		{
			/* If the constant begins with 'EGS' put it in the session */
			if((substr($key,0,7) != 'EGS_DB_') && (substr($key,0,4) == 'EGS_')) $_SESSION[$key] = $val;
		}
	}

	/**
	 * Paginates the results of a query
	 * 
	 * Uses the user's preferences for results-per-page (except when doing a tree)
	 * The tree argument allows the overview to format itself like a tree
	 * @todo this could do with more information as it's quite big/complex 
	 **/
	function page($query, $page, $links = array(), $tree = false)
	{
		global $db, $smarty;
		
		/* Set the perpage */
		if(!isset($_SESSION['preferences']['perpage'])) $_SESSION['preferences']['perpage'] = 10;

		$perpage = intval($_SESSION['preferences']['perpage']);

		/* This sets the perpage to a suitable large number for when we are printing, or exporting */
		//if((isset($_GET['print']) && ($_GET['print'] == 'true')) || (isset($_GET['export']) && ($_GET['export'] == 'tab')) || ($_GET['module']=='contacts')&&(isset($_GET['action']) && ($_GET['action']=='labels')))) $perpage = 99999;
		if((isset($_GET['print'])&& ($_GET['print']=='true')) || (isset($_GET['export']) && ($_GET['export']=='tab')) || ((isset($_GET['module']))&&($_GET['module']=='contacts') && (isset($_GET['action']))&& ($_GET['action']=='labels')))$perpage = 99999;
		/* Set the fetch mode */
		$db->setFetchMode(ADODB_FETCH_NUM);
		
		/* If we are doing a tree, having perpage does not make sense */
		if(!$tree) $rs = $db->pageExecute($query, $perpage, $_SESSION[$page]);
		else $rs = $db->Execute($query);
		echo $db->ErrorMsg();
		if(!$rs->AtFirstPage()) $smarty->assign('firstPage', true);		
		if(!$rs->AtLastPage()) $smarty->assign('lastPage', $rs->lastPageNo());
		if($rs->AbsolutePage() >1) $smarty->assign('backPage', $rs->AbsolutePage() - 1);
		if($rs->AbsolutePage() < $rs->lastPageNo()) $smarty->assign('nextPage', $rs->AbsolutePage() + 1);
		
		$smarty->assign('currentPage', $rs->AbsolutePage());
		$smarty->assign('totalPages', $rs->LastPageNo());
		$smarty->assign('perPage', $perpage);

		if(EGS_DEBUG_SQL && (!$rs)) die($db->errorMsg());

		$actualLinks = array();
		
		/* This is for indenting */
		$indents = array();
		/* This is for +/- */
		if($tree && (!isset($_SESSION[$page.'_action']))) $_SESSION[$page.'_action'] = array();
		$actions = array();
		
		while(!$rs->EOF) {
			$row = $rs->fetchRow();

			$link = array();

			if($page == 'activity_page') {
				$caseId = array_shift($row);
				$opportunityId = array_shift($row);
				
				if($opportunityId != '') $link[2] = 'action=viewopportunity&amp;id='.$opportunityId;
				if($caseId != '') $link[2] = 'action=viewcase&amp;id='.$caseId;
			}
				
			while(list($key, $val) = each($links)) {
				
				if(isset($links[$key])) {
					$link[$key] = $links[$key].urlencode(array_shift($row));
				}	
			}
			
			if(sizeof($link) > 0) $actualLinks[] = $link;
			
			if ((isset($_GET['module'])&&(isset($_GET['action'])))&&($_GET['module']=='contacts') && (isset($_GET['action']) && ($_GET['action']=='labels'))) {
				$address='';
				
				$name=$row[9];
				$compname=$row[8];
				$id=$row[7];
				//$atart=4;
				$address['street1']=$row[0];
				$address['street2']=$row[1];
				$address['street3']=$row[2];
				$address['town']=$row[3];
				$address['county']=$row[4];
				$address['postcode']=$row[5];
				$address['countrycode']=$row[6];
				
				$address=$this->formatAddress($address);
								
				$row[0]=$id;
				$row[1]=$compname;
				$row[2]=$name;
				$row[3]=$address;
				
				unset($row[4]);
				unset($row[5]);
				unset($row[6]);
				unset($row[7]);
				unset($row[8]);
				unset($row[9]);
			}
			reset($links);
			$rows[] = $row;
			
			$indents[] = 0;

			/* Do the sub tree */
			if($tree) {
				if(isset($_SESSION[$page.'_action'][$row[0]]) && ($_SESSION[$page.'_action'][$row[0]] == '-')) {
					$actions[] = '-';
					$this->subTree($query, $page, 1, $rows, $row[0], $indents, $actions);
				} else if($this->hasChildren($query, $row[0])) $actions[] = '+';
				else $actions[] = '';
			}
		}
		
		//echo "<pre>".print_r($actualLinks);
		if(isset($rows)) {
			$smarty->assign('rows', $rows);
			$smarty->assign('indent', $indents);
			$smarty->assign('action', $actions);
			$url = explode('&show', $_SERVER['REQUEST_URI']);
			$url = explode('&hide', $url[0]);
			$smarty->assign('myself', $url[0]);
			
			if($tree) $smarty->assign('tree', $tree);
		}

		if(sizeof($actualLinks) > 0) $smarty->assign('actualLinks', $actualLinks);
		/* Set back to associative */
		$db->setFetchMode(ADODB_FETCH_ASSOC);

	}
	
	function subTreeQuery ($query, $id) {
		if($page = 'section_page') return str_replace('s.parentsectionid is null', 's.parentsectionid='.$id, $query);
	}
	
	function subTree($query, $page, $indent, &$rows, $id, &$indents, &$actions) {
		global $db;
		
		$newquery = $this->subTreeQuery($query, $id);
		
		$rs = $db->Execute($newquery);

		while(!$rs->EOF) {
			$row = $rs->fetchRow();
			
			$rows[] = $row;
			
			$indents[] = $indent;
			
			if(isset($_SESSION[$page.'_action'][$row[0]]) && ($_SESSION[$page.'_action'][$row[0]] == '-')) {
				$actions[] = '-';
				$this->subTree($query, $page, $indent++, $rows, $row[0], $indents, $actions);
			} else if($this->hasChildren($query, $row[0])) $actions[] = '+';
			else $actions[] = '';
		}	
	}
	
	function hasChildren($query, $id) {
		global $db;
		
		$query = $this->subTreeQuery($query, $id);
		
		$rs = $db->Execute($query);
		
		if($rs->RecordCount() > 0) return true;
		else return false;
	}
	
	/**
	 * Sync the user preferences back to the database
	 * 
	 * Puts a base64-encoded string of the $_SESSION['preferences'] array into the useraccess table 
	 **/
	function syncPreferences() {
		global $db;
		
		$query = 'UPDATE useraccess SET settings='.$db->qstr(base64_encode(serialize($_SESSION['preferences']))).' WHERE username='.$db->qstr(EGS_USERNAME).' AND companyid='.$db->qstr(EGS_COMPANY_ID);
		
		$db->Execute($query);
	}

	/**
	 * Check the $_POST array for nasty things
	 * 
	 * Removes any keys with null/empty values
	 * Removes HTML tags from most pages, and php-tags from those few that are allowed to post HTML
	 **/
	function checkPost()
	{
		while(list($key, $val) = each($_POST)) {
			if(!is_array($val) && trim($val) == '') unset($_POST[$key]);
			else if(!is_array($val)) {
				if(isset($_GET['action']) && ($_GET['action'] != 'savepage')&&($_GET['action'] != 'saveletter')&&($_GET['action'] != 'vieweditletter')) $_POST[$key] = strip_tags(trim($_POST[$key]));
				else $_POST[$key] = str_replace('?>', '', str_replace('<?php', '', trim($_POST[$key])));
			}
			else if(is_array($val)) {
				while(list($key2, $val2) = each($val)) {
					if(trim($val2) == '') unset($_POST[$key][$key2]);
					else {
						if(isset($_GET['action']) && ($_GET['action'] != 'savepage')&&($_GET['action'] != 'saveletter')&&($_GET['action'] != 'vieweditletter')) $_POST[$key][$key2] = strip_tags(trim($_POST[$key][$key2]));
						else $_POST[$key][$key2] = str_replace('?>', '', str_replace('<?php', '', trim($_POST[$key][$key2])));
					}
				}
			}
		}
	}

	/**
	 * Check an email-address for validity
	 * 
	 * Works on two levels:
	 * *firstly checks against a regexp for correct format
	 * *then, if the MX_LOOKUP is defined, it does proper verification 
	 **/
	function validEmail($email)
	{
		if(eregi("^[a-zA-Z0-9_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$]", $email)) return false;

		if(EGS_MX_LOOKUP) {
			list($Username, $Domain) = split("@",$email);

			if(getmxrr($Domain, $MXHost)) return true;
   			else 
			{
				if(fsockopen($Domain, 25, $errno, $errstr, 30)) return true;
				else return false;
			}
		} else {
			return true;
		}
	}
	
	/**
	 * Function to return search string from key-value pairs
	 * 
	 * Builds up a query-string for searching:
	 * * automatically assumes a wildcard at the end of the string (so a search for 'fo' will match 'foo')
	 * * more wild-cards can be inserted manually as a *  (so '*oo' will match 'foo' and 'fool' etc.)
	 * */
	function searchString($values = array())
	{
		global $db;
		
		$string = '(';
		
		while(list($key, $val) = each($values)) {
			
			if($val == '//OPEN') $string .= 'open='.$db->qstr('true').' AND '; 
			else if(strpos($key, 'id') !== false) $string .= str_replace('_', '.', $key).'='.$db->qstr($val).' AND ';
			else if(strpos($key, '//not') !== false)	$string .= str_replace('2', '', str_replace('//not', '', str_replace('_', '.', $key))).' <> '.$db->qstr($val).' AND ';
			else if(strpos($key, '//boolean') === false)	$string .= 'lower('.str_replace('_', '.', $key).') LIKE '.$db->qstr(str_replace('*','%',strtolower($val)).'%').' AND ';
			else $string .= str_replace('_', '.', str_replace('//boolean', '', $key)).'='.$db->qstr(strtolower($val)).' AND ';
		}
		
		return substr($string, 0, -4).')';
	}

	/**
	 * Formats an address according to the user preferences 
	 * */
	function formatAddress($address) {
		return str_replace(',  ,', ', ', str_replace(',  ,  ,', '', str_replace(', , ,', ', ', str_replace(', ,', ', ', str_replace('country', trim($address['countrycode']), str_replace('postcode', trim($address['postcode']), str_replace('county', trim($address['county']), str_replace('town', trim($address['town']), str_replace('street3', trim($address['street3']), str_replace('street2', trim($address['street2']), str_replace('street1', trim($address['street1']), $_SESSION['preferences']['addressFormat'])))))))))));
	}
	
	/**
	 * Check if user is a ticket admin
	 * 
	 * Also returns true if the user is a superuser 
	 **/
	function isTicketAdmin() {
		$query = 'SELECT username FROM useraccess WHERE (ticketadmin OR superuser) AND companyid='.$this->db->qstr(EGS_COMPANY_ID).' AND username='.$this->db->qstr(EGS_USERNAME);

		$rs = $this->db->GetOne($query);

		if ($rs === false) return false;
		else return true;
	}
	
	/**
	 * Function to save a message (to send to someone)
	 */
	function saveMessage($_POST) {
		global $smarty;
		
		/* Check Message */
		if(!isset($_POST['message'])) {
			$smarty->assign('errors', array(_('Please enter a message')));
			
			return false;	
		}
		
		/* Check access */
		if (EGS_COMPANY_ID == EGS_ACTUAL_COMPANY_ID) {
			$message = array();
			$message['id'] = $this->db->GenID('message_id_seq');
			$message['message'] = $_POST['message'];
			$message['leftby'] = EGS_USERNAME;
			$message['leftfor'] = $_POST['leftfor'];
			$message['companyid'] = EGS_COMPANY_ID;
			if(isset($_POST['personid'])) $message['personid'] = $_POST['personid'];
			
			$this->db->Replace('message', $message, 'id', true);
			
			$smarty->assign('messages', array(_('Message successfully left.')));

			return true;
		} else {
			$smarty->assign('errors', array(_('You are not allowed to leave messages. If you beleive this to be incorrect please contact your system administrator.')));
			
			return true;
		}
	}
	/**
	 * Delete a message that has been left
	 */
	function deleteMessage($id) {
		global $smarty;
		
		if (EGS_COMPANY_ID == EGS_ACTUAL_COMPANY_ID) {
			$query = 'DELETE FROM message WHERE id='.$this->db->qstr($id).' AND leftfor='.$this->db->qstr(EGS_USERNAME).' AND companyid='.$this->db->qstr(EGS_COMPANY_ID);
			
			$this->db->Execute($query);
			
			$smarty->assign('messages', array(_('Message Deleted.')));	
		} else {
			$smarty->assign('errors', array(_('Message cannot be deleted.')));
		}
	}
}
?>
