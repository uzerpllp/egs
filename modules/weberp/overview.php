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
if (in_array('weberp', $_SESSION['modules'])) {
	require_once (EGS_FILE_ROOT.'/src/classes/class.weberp.php');

	$weberp = new weberp();
	
	$weberp->authenticate();

	$smarty->assign('iframe', true);

	if(isset($_GET['view'])) $smarty->assign('iframeSrc', EGS_SERVER.'/modules/weberp/'.$_GET['view'].'.php');
	else if(isset($_GET['application'])) $smarty->assign('iframeSrc', EGS_SERVER.'/modules/weberp/?Application='.$_GET['application']);
	else $smarty->assign('iframeSrc', EGS_SERVER.'/modules/weberp/');
}
?>
