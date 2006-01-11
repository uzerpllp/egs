<?php
// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - New Password 1.0                 |
// +----------------------------------------------------------------------+
// | Copyright (c) 2002-2006 Senokian Solutions                           |
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
if (isset ($_GET['id']))
	$username = urldecode($_GET['id']);
if (isset ($_POST['username']))
	$username = ($_POST['username']);
$errors=array();
$messages=array();
require_once(EGS_FILE_ROOT.'/src/classes/class.admin.php');

$admin = new admin();
if (in_array('admin', $_SESSION['modules'])) {

$password = $admin->GeneratePassword();

	$user['password'] = md5($password);
	$user['username'] = $username;
	$user['lastcompanylogin'] = EGS_COMPANY_ID;
	if (!$db->Replace('users', $user, array('username'), true))
		$errors[] = _('Error saving changing password');
		$q='SELECT email FROM personoverview WHERE userdetail=true AND owner='.$db->qstr($username);
		
		$to      = $db->GetOne($q);
		
		if(!isset($to)||$to=='')$errors[] = _('User doesn\'t have an email address to send the password to');
		if (count($errors)==0) {
			$message = _("The admin of the portal at {HOST} has changed your password\r\n" .
					"\r\n" .
					"Your access details are:\r\n" .
					"\r\n" .
					"Username: {USERNAME}\r\n" .
					"Password: {PASSWORD}\r\n".
					"If you have any queries, you should contact your admin.");
					
			
			
			
			$subject = _('Portal Access');
			
			$message = str_replace('{HOST}', EGS_SERVER, str_replace('{PASSWORD}', $password, str_replace('{USERNAME}', $username, $message)));
			
			mail($to, $subject, $message);
			$messages[] = _('User\'s password changes successfully');
			$smarty->assign('messages', $messages);
		}
		else {
			$smarty->assign('errors',$errors);
			
		}	
		$smarty->assign('redirect', true);
		$smarty->assign('redirectAction', '');
			
		
}			
?>
	
