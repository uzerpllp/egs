<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - WebERP Overview 1.0              |
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

	$db->Execute('SET search_path=company'.EGS_COMPANY_ID);
	$_SESSION['AccessLevel'] = '';
	$_SESSION['CustomerID'] = '';
	$_SESSION['UserBranch'] = '';
	$_SESSION['Module'] = '';
	$_SESSION['PageSize'] = '';
	$_SESSION['UserStockLocation'] = '';
	$_SESSION['AttemptsCounter']++;

	// Set Default theme for initial Screen.
	$query = "SELECT config.confvalue 
				FROM config
				WHERE config.confname='DefaultTheme'";

	$theme = $db->GetOne($query);

	$query = "SELECT www_users.fullaccess,
					www_users.customerid,
					www_users.lastvisitdate,
					www_users.pagesize,
					www_users.defaultlocation,
					www_users.branchcode,
					www_users.modulesallowed,
					www_users.blocked,
					www_users.realname,
					www_users.theme,
					www_users.displayrecordsmax,
					www_users.userid,
					www_users.language
				FROM www_users
				WHERE www_users.userid=".$db->qstr(EGS_USERNAME)." 
				AND www_users.password=".$db->qstr($db->GetOne('SELECT password FROM users WHERE username='.$db->qstr(EGS_USERNAME)));
	$rs = $db->Execute($query);

	// Populate session variables with data base results
	while(!$rs->EOF) {
		if ($rs->fields['blocked'] != 1) {

		/*reset the attempts counter on successful login */
		$_SESSION['AttemptsCounter'] = 0;
		$_SESSION['AccessLevel'] = $rs->fields['fullaccess'];
		$_SESSION['CustomerID'] = $rs->fields['customerid'];
		$_SESSION['UserBranch'] = $rs->fields['branchcode'];
		$_SESSION['DefaultPageSize'] = $rs->fields['pagesize'];
		$_SESSION['UserStockLocation'] = $rs->fields['defaultlocation'];
		$_SESSION['ModulesEnabled'] = explode(",", $rs->fields['modulesallowed']);
		$_SESSION['UsersRealName'] = $rs->fields['realname'];
		$_SESSION['Theme'] = $rs->fields['theme'];
		$_SESSION['UserID'] = $rs->fields['userid'];
		$_SESSION['Language'] = $rs->fields['language'];

		if ($myrow[10] > 0) {
			$_SESSION['DisplayRecordsMax'] = $rs->fields['displayrecordsmax'];
		} else {
			$_SESSION['DisplayRecordsMax'] = $_SESSION['DefaultDisplayRecordsMax']; // default comes from config.php
		}

		$sql = "UPDATE www_users SET lastvisitdate='".date("Y-m-d H:i:s")."' 
							WHERE www_users.userid='".$_POST['UserNameEntryField']."' 
							AND www_users.password='".$_POST['Password']."'";
		//$Auth_Result = DB_query($sql, $db);

		/*get the security tokens that the user has access to */
		$query = 'SELECT tokenid FROM securitygroups
							WHERE secroleid =  '.$_SESSION['AccessLevel'];
		$rs2 = $db->Execute($query);

		$_SESSION['AllowedPageSecurityTokens'] = array ();

			$i = 0;
			while (!$rs2->EOF) {
				$_SESSION['AllowedPageSecurityTokens'][$i] = $rs2->fields['tokenid'];
				$i ++;
				$rs2->MoveNext();
			}

		}

		$rs->MoveNext();
	}
	
	$db->Execute('SET search_path=public');

	$smarty->assign('iframe', true);

	$smarty->assign('iframeSrc', EGS_SERVER.'/modules/weberp/UserSettings.php');
}
?>