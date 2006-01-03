<?php
// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Save Account Access 1.0          |
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

if (EGS_CRMADMIN) {
	/* If the page has not been set, set it */
	if(isset($_GET['page'])) $_SESSION['editletter_page'] = max(1, intval($_GET['page']));
	if(!isset($_SESSION['editletter_page'])) $_SESSION['editletter_page'] = 1;

	$smarty->assign('hideToggle', true);
	/* Set the page title */
	$smarty->assign('pageTitle', _('Edit Letters'));
	
	/* Setup the search box */
	$smarty->assign('searchTitle', _('Search Letters'));

	/* Set the search type */
	if(isset($_GET['search']) && ($_GET['search'] == 'adv')) $_SESSION['editletterSearchType'] = 'adv';
	else if(isset($_GET['search']) && ($_GET['search'] == 'norm')) $_SESSION['editletterSearchType'] = 'norm';
	else if(!isset($_SESSION['editletterSearchType'])) $_SESSION['editletterSearchType'] = 'norm';

	$smarty->assign('searchForm', $_SESSION['editletterSearchType']);
	
	$search = array();
	
	$search['id'] = array('name' =>_('Letter ID'), 'type' => 'text');
	$search['name'] = array('name' =>_('Letter Name'), 'type' => 'text');
	
	$_SESSION['editletterSearch'] = array();

	$smarty->assign('search', $search);
	
	/* If no default column ordering is set for the company, setup the default */
		$_SESSION['preferences']['editletterColumns'] = array();
		$_SESSION['preferences']['editletterColumns'][] = 'id';
		$_SESSION['preferences']['editletterColumns'][] = 'name';

	/* Array to hold the columns */
	$headings = array();

	/* Iterate over the columns and translate */
	for($i=0; $i < sizeof($_SESSION['preferences']['editletterColumns']); $i++) {
		switch ($_SESSION['preferences']['editletterColumns'][$i]) {
			
			case 'id':
				$headings[$_SESSION['preferences']['editletterColumns'][$i]] = _('Letter ID');
				break;
			case 'name':
				$headings[$_SESSION['preferences']['editletterColumns'][$i]] = _('Letter Name');
				break;
		}
	}

	$smarty->assign('headings', $headings);
	
	/* Do Search */
	if(sizeof($_POST) > 0) {
		$egs->checkPost();

		/* do a delete if necessary */
		if(isset($_POST['delete']) && sizeof($_POST['delete'])) {
			while(list($key, $val) = each($_POST['delete'])) {
				require_once(EGS_FILE_ROOT.'/src/classes/class.letter.php');

				$letter = new letter();

				$letter->deleteLetter(intval($val));
			}

			$smarty->assign('messages', array(_('Letters deleted')));
		}

		$save = false;
		
		if(!isset($_SESSION['editletterSearch']) || ($_SESSION['editletterSearch'] == '') || isset($_POST['clearsearch'])) {
			if(isset($_SESSION['preferences']['editletterSearch'])) $_SESSION['editletterSearch'] = $_SESSION['preferences']['editletterSearch'];
			else unset($_SESSION['editletterSearch']);	
		}
		
		/* If Saving, set to search then save */
		if(isset($_POST['savesearch'])) {
			unset($_POST['savesearch']);
			$_SESSION['preferences']['editletterSearch'] = $_POST;
			$_SESSION['editletterSearch'] = $_POST;
			$egs->syncPreferences();
		}
		
		/* We are searching */
		if(isset($_POST['search'])) {
			unset($_POST['search']);
			$_SESSION['editletterSearch'] = $_POST;
			$_SESSION['editletter_page'] = 1;
		}
	}
	else if(!isset($_SESSION['editletterSearch']) && isset($_SESSION['preferences']['editletterSearch'])) $_SESSION['editletterSearch'] = $_SESSION['preferences']['editletterSearch'];

	/* Set the search order */
	if(isset($_GET['order']) && ($_GET['order'] == $_SESSION['editletterOrder']) && in_array($_GET['order'], $_SESSION['preferences']['editletterColumns'])) {
		if(isset($_SESSION['editletterSort']) && ($_SESSION['editletterSort'] == 'ASC')) $_SESSION['editletterSort'] = 'DESC';
		else if(isset($_SESSION['editletterSort']) && ($_SESSION['editletterSort'] == 'DESC')) $_SESSION['editletterSort'] = 'ASC';
		$_SESSION['editletter_page'] = 1;
	} else if(isset($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['editletterColumns'])) {
		$_SESSION['editletterSort'] = 'DESC';
		$_SESSION['editletterOrder'] = $_GET['order'];
		$_SESSION['editletter_page'] = 1;
	}

	if(!isset($_SESSION['editletterOrder'])) $_SESSION['editletterOrder'] = $_SESSION['preferences']['editletterColumns'][0];
	if(!isset($_SESSION['editletterSort'])) $_SESSION['editletterSort'] = 'ASC';

	$_SESSION['order'] = $_SESSION['editletterOrder'];
	
	if (isset($_SESSION['editletterSearch']))$searchString = $egs->searchString($_SESSION['editletterSearch']);
	
		//keep track of search terms
	if (isset ($_SESSION['editletterSearch']) && (sizeof($_SESSION['editletterSearch']) > 0)) {
		$_SESSION['search'] = $_SESSION['editletterSearch'];
	} else
		if (isset ($_SESSION['search']))
			unset ($_SESSION['search']);
			
	//build query		
	$query = 'SELECT id, id, name ';
	$query .= 'FROM letters ';
	$query .= 'WHERE companyid='.$db->qstr(EGS_COMPANY_ID);
	if (!isset($searchString)) $searchString = '';
	if ($searchString != ')' && $searchString != '')$query .= ' AND '.$searchString;
	
	/* Set up the pager and send the query */
	$query .= ' ORDER BY '.$_SESSION['order']. ' '.$_SESSION['editletterSort'];
	$egs->page($query, 'editletter_page');	
	$smarty->assign('viewType', 'template');
}
else {
	$smarty->assign('errors',array(_('Only CRM Admins are allowed to view this page')));
	$smarty->assign('redirect',true);
	$smarty->assign('redirectAction','');
}
?>