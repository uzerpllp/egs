<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Bugs Redirect 1.0                |
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
// | 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA               |
// +----------------------------------------------------------------------+
// | Author: Jake Stride <jake.stride@senokian.com>                       |
// +----------------------------------------------------------------------+
// | 1.0                                                                  |
// | ===                                                                  |
// | First Stable Release                                                 |
// +----------------------------------------------------------------------+

/* Check user has access to the file module */
if (in_array('projects', $_SESSION['modules']) && $db->GetOne('SELECT tablename FROM pg_tables WHERE schemaname=\'company'.EGS_COMPANY_ID.'\' AND tablename LIKE \'flyspray_%\'')) {
	$query = 'SELECT password FROM users WHERE username='.$db->qstr(EGS_USERNAME);
	
	setcookie("flyspray_passhash",crypt($db->GetOne($query), "$cookiesalt"), time() + 3600, "/");
	setcookie('flyspray_userid', EGS_PERSON_ID, time() + 3600, "/");
	
	if(isset($_GET['id'])) {
		$_REQUEST['project'] = $_GET['id'];
		setcookie('flyspray_project', $_GET['id'], time() + 3600, "/");
		if(isset($_GET['do']) && ($_GET['do'] == 'details')) $smarty->assign('iframeSrc', EGS_SERVER.'/modules/projects/?do='.$_GET['do'].'&amp;id='.$_GET['id']);
		else if(isset($_GET['do'])) $smarty->assign('iframeSrc', EGS_SERVER.'/modules/projects/?do='.$_GET['do'].'&amp;project='.$_GET['id']);
		else $smarty->assign('iframeSrc', EGS_SERVER.'/modules/projects/?tasks=all&amp;project='.$_GET['id']);
	} else $smarty->assign('iframeSrc', EGS_SERVER.'/modules/projects/');

	$smarty->assign('iframe', true);
}
?>