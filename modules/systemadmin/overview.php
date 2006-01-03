<?php
if (in_array('systemadmin', $_SESSION['modules'])) {
	/* If the page has not been set, set it */
	if(isset($_GET['page'])) $_SESSION['systemcompanies_page'] = max(1, intval($_GET['page']));
	if(!isset($_SESSION['systemcompanies_page'])) $_SESSION['systemcompanies_page'] = 1;

	/* Set the page title */
	$smarty->assign('pageTitle', _('Companies with System Access'));
	
	/* Set the new button */
	$smarty->assign('pageNew', 'action=view');
	
	/* Setup the search box */
	$smarty->assign('searchTitle', _('Search'));

	if(isset($_SESSION['systemcompaniesSearchType'])) $smarty->assign('searchForm', $_SESSION['systemcompaniesSearchType']);
	$smarty->assign('hideAdvancedSearch', true);
	
	$search = array();
	
	$search['name'] = array('name' =>_('Company Name'), 'type' => 'text');
	$search['theme'] = array('name' =>_('Theme'), 'type' => 'text');
	if(!isset($_POST['clearsearch']) && isset($_SESSION['search']['access//boolean'])) $search['access//boolean'] = array('name' =>_('Login'), 'type' => 'checkbox', 'value' => 'true', 'checked' => 'true');
	else $search['access//boolean'] = array('name' =>_('Login'), 'type' => 'checkbox', 'value' => 'true');

	$smarty->assign('search', $search);
	
	/* If no default column ordering is set for the company, setup the default */
	if(!isset($_SESSION['preferences']['systemcompaniesColumns']) || !is_array($_SESSION['preferences']['systemcompaniesColumns'])) {
		$_SESSION['preferences']['systemcompaniesColumns'] = array();
		$_SESSION['preferences']['systemcompaniesColumns'][] = 'name';
		$_SESSION['preferences']['systemcompaniesColumns'][] = 'theme';
		$_SESSION['preferences']['systemcompaniesColumns'][] = 'quota';
		$_SESSION['preferences']['systemcompaniesColumns'][] = 'supercompany';
		$_SESSION['preferences']['systemcompaniesColumns'][] = 'access';
	}

	/* Array to hold the columns */
	$headings = array();

	/* Iterate over the columns and translate */
	for($i=0; $i < sizeof($_SESSION['preferences']['systemcompaniesColumns']); $i++) {
		switch ($_SESSION['preferences']['systemcompaniesColumns'][$i]) {
			case 'name':
				$headings[$_SESSION['preferences']['systemcompaniesColumns'][$i]] = _('Company');
				break;
			case 'theme':
				$headings[$_SESSION['preferences']['systemcompaniesColumns'][$i]] = _('Theme');
				break;
			case 'quota':
				$headings[$_SESSION['preferences']['systemcompaniesColumns'][$i]] = _('Quota');
				break;
			case 'supercompany':
				$headings[$_SESSION['preferences']['systemcompaniesColumns'][$i]] = _('Super Company');
				break;
			case 'access':
				$headings[$_SESSION['preferences']['systemcompaniesColumns'][$i]] = _('Login');
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
				require_once(EGS_FILE_ROOT.'/src/classes/class.systemadmin.php');

				$systemadmin = new systemadmin();

				$system->deleteCompany(intval($val));
			}

			$smarty->assign('messages', array(_('Companies deleted')));
		}

		$save = false;
		
		if(!isset($_SESSION['systemcompaniesSearch']) || ($_SESSION['systemcompaniesSearch'] == '') || isset($_POST['clearsearch'])) {
			if(isset($_SESSION['preferences']['systemcompaniesSearch'])) $_SESSION['systemcompaniesSearch'] = $_SESSION['preferences']['systemcompaniesSearch'];
			else unset($_SESSION['systemcompaniesSearch']);	
		}
		
		/* If Saving, set to search then save */
		if(isset($_POST['savesearch'])) {
			unset($_POST['savesearch']);
			$_SESSION['preferences']['systemcompaniesSearch'] = $_POST;
			$_SESSION['systemcompaniesSearch'] = $_POST;
			$egs->syncPreferences();
		}
		
		/* We are searching */
		if(isset($_POST['search'])) {
			unset($_POST['search']);
			$_SESSION['systemcompaniesSearch'] = $_POST;
			$_SESSION['systemcompanies_page'] = 1;
		}
	}
	else if(!isset($_SESSION['systemcompaniesSearch']) && isset($_SESSION['preferences']['systemcompaniesSearch'])) $_SESSION['systemcompaniesSearch'] = $_SESSION['preferences']['systemcompaniesSearch'];

	/* Set the search order */
	if(isset($_GET['order']) && ($_GET['order'] == $_SESSION['systemcompaniesOrder']) && in_array($_GET['order'], $_SESSION['preferences']['systemcompaniesColumns'])) {
		if(isset($_SESSION['systemcompaniesSort']) && ($_SESSION['systemcompaniesSort'] == 'ASC')) $_SESSION['systemcompaniesSort'] = 'DESC';
		else if(isset($_SESSION['systemcompaniesSort']) && ($_SESSION['systemcompaniesSort'] == 'DESC')) $_SESSION['systemcompaniesSort'] = 'ASC';
		$_SESSION['systemcompanies_page'] = 1;
	} else if(isset($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['systemcompaniesColumns'])) {
		$_SESSION['systemcompaniesSort'] = 'DESC';
		$_SESSION['systemcompaniesOrder'] = $_GET['order'];
		$_SESSION['systemcompanies_page'] = 1;
	}

	if(!isset($_SESSION['systemcompaniesOrder'])) $_SESSION['systemcompaniesOrder'] = $_SESSION['preferences']['systemcompaniesColumns'][0];
	if(!isset($_SESSION['systemcompaniesSort'])) $_SESSION['systemcompaniesSort'] = 'ASC';

	$_SESSION['order'] = $_SESSION['systemcompaniesOrder'];
	
	/* Build the query to get the relevant columns */
	$query = 'SELECT c.id, ';

	$category = false;

	if(isset($_SESSION['systemcompaniesSearch']) && array_key_exists('c_typeid', $_SESSION['systemcompaniesSearch'])) $category = true;

	for($i = 0; $i < sizeof($_SESSION['preferences']['systemcompaniesColumns']); $i++) {
		if($_SESSION['preferences']['systemcompaniesColumns'][$i] == 'name') $query .= 'c.name';
		else if(($_SESSION['preferences']['systemcompaniesColumns'][$i] == 'supercompany') || ($_SESSION['preferences']['systemcompaniesColumns'][$i] == 'access')) $query .= 'CASE WHEN d.'.$_SESSION['preferences']['systemcompaniesColumns'][$i].' THEN '.$db->qstr(_('Yes')).' ELSE '.$db->qstr(_('No')).' END AS '.$_SESSION['preferences']['systemcompaniesColumns'][$i];
		else $query .= 'd.'.$_SESSION['preferences']['systemcompaniesColumns'][$i];
		if(($i+1) != sizeof($_SESSION['preferences']['systemcompaniesColumns'])) $query .= ', ';
	}

	$query .= ' FROM company c, companydefaults d ';

	$query.= 'WHERE c.id=d.companyid ';
	
	if(isset($_SESSION['systemcompaniesSearch']) && (sizeof($_SESSION['systemcompaniesSearch']) > 0)) {
		$searchString = $egs->searchString($_SESSION['systemcompaniesSearch']);
		
		if(($searchString != '') && ($category)) $query .= ' AND c.companyid=a.id AND '.$searchString;
		else if($searchString != '') $query .= ' AND '.$searchString;
		
		$_SESSION['search'] = $_SESSION['systemcompaniesSearch'];
	}
	else if(isset($_SESSION['search'])) unset($_SESSION['search']);

	if($_SESSION['systemcompaniesOrder'] != 'name') $query .= ' ORDER BY d.'.$_SESSION['systemcompaniesOrder']. ' '.$_SESSION['systemcompaniesSort'];
	else $query .= ' ORDER BY c.'.$_SESSION['systemcompaniesOrder']. ' '.$_SESSION['systemcompaniesSort'];

	/* Set up the pager and send the query */
	$egs->page($query, 'systemcompanies_page');
}	
?>
