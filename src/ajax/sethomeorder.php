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
	
	ob_start();
	if (file_exists('../../conf/'.$_SERVER['HTTP_HOST'].'.config.php')) {
		require_once ('../../conf/'.$_SERVER['HTTP_HOST'].'.config.php');
	}
	else if (file_exists('../../conf/config.php')) {
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
	require_once(EGS_FILE_ROOT.'/src/classes/class.egs.php');
	$egs = new egs();
	$incoming = '';
	$incoming = urldecode(implode(file('php://input')));
	
	$length = strlen($incoming);
	/*incoming in the form:
		home-div[]=<item1>&home-div[]=<item2>
	*/
	if(isset($_GET['type'])&&$_GET['type']=='move') {
		$incoming=str_replace('&','',$incoming);
		$temp=explode('home-div[]=',$incoming);
		unset($temp[0]);
		print_r($_SESSION['preferences']['homePreferences']);
		echo "<br>";
		$i=0;
		unset($_SESSION['preferences']['homePreferences']);
		foreach($temp as $key=>$item) {
			$_SESSION['preferences']['homePreferences'][$i]=$item;
			$i++;
		}
		print_r($_SESSION['preferences']['homePreferences']);
	}
	$last=false;
	if(isset($_GET['type'])&&$_GET['type']=='remove') {
		if(count($_SESSION['preferences']['homePreferences'])>1) {
			unset($_SESSION['preferences']['homePreferences'][array_search($incoming,$_SESSION['preferences']['homePreferences'])]);
			if($incoming=='news')unset($_SESSION['preferences']['homePreferences'][array_search('announcements',$_SESSION['preferences']['homePreferences'])]);
			if($incoming=='to_do')unset($_SESSION['preferences']['homePreferences'][array_search('events',$_SESSION['preferences']['homePreferences'])]);
			
		}
		else
			$last=true;
	}
	
		
	$db->close();
	$egs->syncPreferences();
	//echo $query;
	$debug=false;
	if($debug)
		ob_flush();
	else
		ob_end_clean();
	
}
?>