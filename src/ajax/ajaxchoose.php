<?php
// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Save Event 1.0                   |
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
//session_id($_GET['PHPSESSID']);
session_start();

if (isset($_SESSION['loggedIn']) ) {
	
	if (file_exists('../../conf/'.$_SERVER['HTTP_HOST'].'.config.php')) {
		require_once ('../../conf/'.$_SERVER['HTTP_HOST'].'.config.php');
	}
	else if(file_exists('../../conf/config.php')) {
		require_once ('../../conf/config.php');
	}
	/* Use the default config file */
	else {
		require_once ('./conf/config.php');
	}
	require_once (EGS_FILE_ROOT.'/src/db.php');
	if (isset ($_SESSION['EGS_USERNAME']))
		define('EGS_USERNAME', $_SESSION['EGS_USERNAME']);
	if (isset ($_SESSION['EGS_COMPANY_ID']))
		define('EGS_COMPANY_ID', $_SESSION['EGS_COMPANY_ID']);
	
	
	$incoming = '';
	$incoming = urldecode(implode(file('php://input')));
	$incoming=$_POST['value'];
	if (isset ($_GET['type']))
		$type = $_GET['type'];

	$length = strlen($incoming);
	if(isset($_SESSION['ajaxcache'][$type][$incoming])) {
		echo '<ul>';
		foreach($_SESSION['ajaxcache'][$type][$incoming] as $key=>$val) {
			echo '<li id="'.$key.'">'.$val.'</li>';	
		}
		echo '</ul>';
	}
	else {
		if ($type == 'person') {
			//person might depend on company
			$query = 'SELECT DISTINCT p.id, p.firstname || \' \' || p.surname';
			if(!isset($_GET['companyid'])) 
				$query.='|| \' (\' || p.company || \')\' ';
			
			$query.=' AS name FROM personoverview p LEFT OUTER JOIN company c ON (p.companyid=c.id), personaccess a WHERE p.id=a.personid AND ((a.type>2) OR (p.userdetail AND p.companyid='.$db->qstr(EGS_COMPANY_ID).')) AND a.personid=p.id AND a.usercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND a.username='.$db->qstr(EGS_USERNAME);
			
			if(isset($_GET['companyid'])&&$_GET['companyid']!='') {
				
				$query.= 'AND p.companyid='.$db->qstr($_GET['companyid']);
			}
			$query.=' ORDER BY name ASC';
		}
		else if ($type == 'company') {
				$query = 'SELECT id, c.name AS name FROM companyoverview c, companyaccess a WHERE a.companyid=c.id AND a.usercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND a.username='.$db->qstr(EGS_USERNAME).' AND c.companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY c.name ASC';
				
		} else	if ($type == 'item') {
				$query = 'SELECT id, name || \' (Case)\' as name FROM crmcase UNION SELECT id, name ||\' (Opportunity)\' as name from opportunity';
	
		} else if ($type=='section') {
				$query='SELECT id, title as name FROM store_section WHERE companyid='.$db->qstr(EGS_COMPANY_ID);
			
		} else if ($type=='supplier') {
				$query = 'SELECT s.id AS id, c.name AS name FROM store_suppliers s, company c WHERE s.supplierid=c.id AND s.companyid='.$db->qstr(EGS_COMPANY_ID);
			
		}
		else if ($type=='ticketqueue') {
				$query = 'SELECT id, name FROM ticketqueue t JOIN queueaccess q ON (t.id=q.queueid) WHERE username='.$db->qstr(EGS_USERNAME).' AND t.companyid='.$db->qstr(EGS_COMPANY_ID);	
			
		}
		else if ($type=='ticketsubqueue') {
			$query = 'SELECT id, name FROM internalqueue WHERE companyid='.$db->qstr(EGS_COMPANY_ID);
			if(isset($_GET['queueid'])&&$_GET['queueid']!='') {
				$query.='AND queueid='.$db->qstr($_GET['queueid']);	
			}	
		}
		if($incoming=="*")
			$query.=' LIMIT 20';
		if(isset($query)) {
			@$rs = $db->CacheExecute(120,$query);
			$participants = array ();
			while (($rs !== false) && (!$rs->EOF)) {
				$participants[$rs->fields['id']] = trim($rs->fields['name']);
		
				$rs->MoveNext();
			}
			unset($_SESSION['ajaxcache'][$type]);
			echo '<ul>';
			foreach ($participants as $key => $val) {
		
				if ($incoming=='*'||$incoming != '' && substr(strtolower($val), 0, $length) == strtolower($incoming))
				{
					
					$_SESSION['ajaxcache'][$type][$incoming][$key]=$val.'*';
					echo '<li id="'.$key.'">'.$val.'</li>';	
				}
		
			}
			echo '</ul>';
			$db->close();
		}
	
	
	//echo $result;
	}
}
?>