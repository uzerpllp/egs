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
session_start();
//print_r($_SESSION);
if (isset ($_SESSION['loggedIn']) && isset ($_SESSION['modules']) && in_array('projects', $_SESSION['modules'])) {
	
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
		$username = $_SESSION['EGS_USERNAME'];
	if (isset ($_SESSION['EGS_COMPANY_ID']))
		$companyid = $_SESSION['EGS_COMPANY_ID'];
	/* Include the header file, this sets up most system variables */
	//require_once (EGS_FILE_ROOT.'/src/header.php');
	$incoming = '';
	$incoming = urldecode(implode(file('php://input')));
	if (isset ($_GET['type']))
		$type = $_GET['type'];
	//$incoming="Le";
	//$incoming='';
	//if(isset($_GET['type']))$incoming=$_GET['type'];
	$length = strlen($incoming);
	if ($type == 'projectinput') {
		$q = ' SELECT DISTINCT p.id as pid, p.jobno, p.name as pname FROM project p, projectaccess a WHERE  NOT p.completed AND p.id=a.projectid AND a.companyid='.$db->qstr($companyid).' AND a.username='.$db->qstr($username).'ORDER BY p.jobno';
		$rs = $db->CacheExecute(120,$q);
		$projects = array ();
		$result = '';
		while (($rs !== false) && (!$rs->EOF)) {
			$projects[$rs->fields['pid']] = trim($rs->fields['pname']);
			
			$rs->MoveNext();
		}
		
		foreach ($projects as $key => $val) {
			if ($incoming != '' && substr(strtolower($val), 0, $length) == strtolower($incoming))
				$result .= $val.'@'.$key."\n";
				
		}
		$db->close();
		echo $result;
	} else {
		//choose-project
		$tasks = '';
		$lastid = '';
		$prefix = '';
		function getTasks(& $tasks, $projectid, $parent = null, $count = 1) {
			global $db, $tasks;
			$prefix = '';
			for ($i = 0; $i < $count; $i ++) {
				$prefix .= '-';

			}
			if (!isset ($parent)) {

				$q = 'SELECT id, name, projectid FROM projecttask WHERE projectid='.$db->qstr($projectid).' AND parenttaskid IS NULL AND progress<100';
				$rs = $db->CacheExecute(120,$q);
				while (!$rs->EOF) {
					$tasks .= $rs->fields['id'].'/'.$rs->fields['projectid'].'@'.$prefix.$rs->fields['name'].'//';
					//$tasks[$rs->fields['id'].'/'.$rs->fields['projectid']]=array('name'=>$prefix.$rs->fields['name'],'class'=>'task');
					getTasks($tasks, $projectid, $rs->fields['id'], $count +1);
					$rs->MoveNext();

				}

			} else {
				$q = 'SELECT id, name, projectid FROM projecttask WHERE projectid='.$db->qstr($projectid).' AND parenttaskid='.$db->qstr($parent);
				$rs = $db->CacheExecute(120,$q);
				while (!$rs->EOF) {
					$tasks .= $rs->fields['id'].'/'.$rs->fields['projectid'].'@'.$prefix.$rs->fields['name'].'//';
					//$tasks[$rs->fields['id'].'/'.$rs->fields['projectid']]=array('name'=>$prefix.$rs->fields['name'],'class'=>'task');
					getTasks($tasks, $projectid, $rs->fields['id'], $count +1);
					$rs->MoveNext();

				}
			}

		}
		$q = 'SELECT name FROM project WHERE id='.$db->qstr(intval($incoming));
		$rs = $db->CacheExecute(120,$q);
		$tasks .= $incoming.'/'.$incoming.'@'.$rs->fields['name'].'//';
		getTasks($tasks, $incoming);
		
		$db->close();
		echo $tasks;
	}
} else {
	//die("Illegal Action Performed");
}
?>