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

if (isset ($_SESSION['loggedIn']) && isset ($_SESSION['modules']) && in_array('store', $_SESSION['modules'])) {
	ob_start();
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
	if (isset ($_GET['type']))
		$type = $_GET['type'];

	$length = strlen($incoming);
$query = 'SELECT id, name FROM store_product WHERE companyid='.$db->qstr(EGS_COMPANY_ID);
//$query = 'SELECT p.id, CASE WHEN c.name IS NULL THEN p.firstname || \' \' || p.surname ELSE p.firstname || \' \' || p.surname || \' (\' || c.name || \')\' END AS name FROM person p LEFT OUTER JOIN company c ON (p.companyid=c.id), personaccess a WHERE a.usercompanyid='.$db->qstr($companyid).' AND a.username='.$db->qstr($username).' AND a.personid=p.id ORDER BY name';

if(isset($query)) {
	@$rs = $db->CacheExecute(120,$query);
	$participants = array ();
	while (($rs !== false) && (!$rs->EOF)) {
		$participants[$rs->fields['id']] = trim($rs->fields['name']);

		$rs->MoveNext();
	}
	$result = '';
	foreach ($participants as $key => $val) {

		if ($incoming=='*'||$incoming != '' && substr(strtolower($val), 0, $length) == strtolower($incoming))
			$result .= $val.'@'.$key."\n";

	}
	$db->close();
	ob_end_clean();
	//echo $query;
	echo $result;
	}
}
else {
	//die("Illegal Action Performed");
}
?>