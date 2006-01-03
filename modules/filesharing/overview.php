<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Files Overview 1.0               |
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
if (in_array('filesharing', $_SESSION['modules'])) {
	/* Remove current sessions */
	$query = 'DELETE FROM company'.EGS_COMPANY_ID.'.active_sessions WHERE usid='.$db->qstr(EGS_PERSON_ID);

	$db->Execute($query);
	
	/* Now set a new session */
	$query = 'INSERT INTO company'.EGS_COMPANY_ID.'.active_sessions VALUES ('.$db->qstr(strip_tags(session_id())).', '.$db->qstr(EGS_PERSON_ID).', '.$db->qstr(time()+60).', '.$db->qstr($_SERVER['REMOTE_ADDR']).', '.$db->qstr(0).')';
	
	$db->Execute($query);
	
	$query = 'UPDATE company'.EGS_COMPANY_ID.'.owlusers SET curlogin=now(), lastlogin=now() WHERE username='.$db->qstr(EGS_USERNAME);
	
	$rs=$db->Execute($query);
	
	setcookie('owl_sessid', session_id());

	$smarty->assign('iframe', true);
	
	$smarty->assign('iframeSrc', EGS_SERVER.'/modules/filesharing/browse.php?sess='.strip_tags(session_id()));
}
?>