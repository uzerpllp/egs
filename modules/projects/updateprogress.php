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

if (isset ($_SESSION['loggedIn']) && isset ($_SESSION['modules']) && in_array('projects', $_SESSION['modules'])) {
	if (file_exists('/mnt/websites/egs/egs/conf/'.$_SERVER['HTTP_HOST'].'.config.php')) {
		require_once ('/mnt/websites/egs/egs/conf/'.$_SERVER['HTTP_HOST'].'.config.php');
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
	/* Include the header file, this sets up most system variables */
	//require_once (EGS_FILE_ROOT.'/src/header.php');
	$incoming = '';
	$incoming = urldecode(implode(file('php://input')));
	//$incoming is progress<taskid>//<value>
	$incoming=explode('//',str_replace('progress','',$incoming));
	$taskid=$incoming[0];
	$progress=$incoming[1];
	$projectid=$incoming[2];
	include(EGS_FILE_ROOT.'/src/classes/class.project.php');
	$project = new Project();
	
	$accessLevel = $project->accessLevel(intval($projectid));
	
	if($accessLevel>0) {
		$q = 'SELECT ptr.taskid FROM projecttaskresources ptr JOIN resource r ON ptr.resourceid=r.id JOIN person p ON r.personid=p.id JOIN useraccess ua ON ua.username=p.owner WHERE p.owner='.$db->qstr(EGS_USERNAME).' AND ua.companyid='.$db->qstr(EGS_COMPANY_ID).' AND ptr.taskid='.$db->qstr($taskid);

			if ($db->GetOne($q) || (isset ($accessLevel) && $accessLevel > 0)) {
				$allowedit = true;
			} else
				$allowedit = false;
				/*get all the task details*/
			$q = 'SELECT * FROM projecttask WHERE id='.$db->qstr($taskid);
			$taskarray = $db->GetRow($q);
			/*overwrite the progress with the new value*/

			if ($taskarray['progress'] != $progress && $allowedit) {
				if ((!is_numeric($progress)) || !(0 <= $progress) || !($progress <= 100)) {
					$errors = array ();
					$errors[] = _('The progress must be a number between 0 and 100');
					$smarty->assign('errors', $errors);
					break;
				}
				$taskarray['progress'] = $progress;
				if ($taskarray['parenttaskid'] == '')
					unset ($taskarray['parenttaskid']);
				if ($taskarray['milestone'] == '')
					unset ($taskarray['milestone']);
				if ($taskarray['budget'] == '')
					unset ($taskarray['budget']);
				if ($taskarray['priorityid'] == '')
					unset ($taskarray['priorityid']);

				if($project->saveTask($taskarray, $taskid, $allowedit))
					echo "success";
			}
	}
}
?>