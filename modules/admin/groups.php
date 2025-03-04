<?php
// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Groups Overview 1.0              |
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
if (in_array('admin', $_SESSION['modules'])) {
	/* If the page has not been set, set it */
	if(isset($_GET['page'])) $_SESSION['admingroups_page'] = max(1, intval($_GET['page']));
	if(!isset($_SESSION['admingroups_page'])) $_SESSION['admingroups_page'] = 1;

	/* Set the page title */
	$smarty->assign('pageTitle', _('Groups'));
	$smarty->assign('pageNew', 'action=savegroup');
	

	/* If no default column ordering is set for the users, setup the default */
	//if(!isset($_SESSION['preferences']['adminusersColumns']) || !is_array($_SESSION['preferences']['adminusersColumns'])) {
		$_SESSION['preferences']['admingroupsColumns'] = array();
		$_SESSION['preferences']['admingroupsColumns'][] = 'name';
		
	//}

	/* Array to hold the columns */
	$headings = array();


	/* Iterate over the columns and translate */
	for($i=0; $i < sizeof($_SESSION['preferences']['admingroupsColumns']); $i++) {
		switch ($_SESSION['preferences']['admingroupsColumns'][$i]) {
			case 'name':
				$headings[$_SESSION['preferences']['admingroupsColumns'][$i]] = _('Name');
				break;
			
		}
	}
	if(isset($_POST['delete']) && sizeof($_POST['delete']>0)) {
		
			while(list($key, $val) = each($_POST['delete'])) {
				require_once(EGS_FILE_ROOT.'/src/classes/class.admin.php');

				$admin = new admin();
				$admin->deleteGroup(intval($val));
			}
			
			$smarty->assign('messages', array(_('Groups deleted')));
		}
	$smarty->assign('headings', $headings);


	/* Set the search order */
	if(isset($_GET['order']) && ($_GET['order'] == $_SESSION['admingroupsOrder']) && in_array($_GET['order'], $_SESSION['preferences']['admingroupsColumns'])) {
		if(isset($_SESSION['admingroupsSort']) && ($_SESSION['admingroupsSort'] == 'ASC')) $_SESSION['admingroupsSort'] = 'DESC';
		else if(isset($_SESSION['admingroupsSort']) && ($_SESSION['admingroupsSort'] == 'DESC')) $_SESSION['admingroupsSort'] = 'ASC';
		$_SESSION['admingroups_page'] = 1;
	} else if(isset($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['admingroupsColumns'])) {
		$_SESSION['admingroupsSort'] = 'DESC';
		$_SESSION['admingroupsOrder'] = $_GET['order'];
		$_SESSION['admingroups_page'] = 1;
	}


	if(!isset($_SESSION['admingroupsOrder'])) $_SESSION['admingroupsOrder'] = $_SESSION['preferences']['admingroupsColumns'][0];
	if(!isset($_SESSION['admingroupsSort'])) $_SESSION['admingroupsSort'] = 'ASC';

	$_SESSION['order'] = $_SESSION['admingroupsOrder'];
	
	/* Build the query to get the relevant columns */
	$query = 'SELECT id, name FROM groups where companyid='.$db->qstr(EGS_COMPANY_ID).' order by name';
	/* Set up the pager and send the query */
	$egs->page($query, 'admingroups_page');
	
	$smarty->assign('viewType', 'group');
}	
?>
