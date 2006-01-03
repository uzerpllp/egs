<?php
	/* If the page has not been set, set it */
	if(isset($_GET['page'])) $_SESSION['chooseperson_page'] = max(1, intval($_GET['page']));
	if(!isset($_SESSION['chooseperson_page'])) $_SESSION['chooseperson_page'] = 1;

	/* Set the page title */
	$smarty->assign('pageTitle', _('Contacts: People'));
	
	/* Setup the search box */
	$smarty->assign('searchTitle', _('Search People'));

	/* Set the search type */
	if(!isset($_SESSION['choosepersonSearchType'])) $_SESSION['choosepersonSearchType'] = 'norm';

	$smarty->assign('searchForm', $_SESSION['choosepersonSearchType']);
	
	$search = array();
	
	$search['p_firstname'] = array('name' =>_('First Name'), 'type' => 'text');
	$search['p_surname'] = array('name' =>_('Surname'), 'type' => 'text');
	$search['c_name'] = array('name' =>_('Company'), 'type' => 'text');

	$smarty->assign('search', $search);
	
	/* Setup the add box */
	$smarty->assign('addTitle', _('Add New Contact'));
	
	$add = array();
	
	$query = 'SELECT username FROM useraccess WHERE companyid='.$db->qstr(EGS_COMPANY_ID);
	
	$add['firstname'] = array('name' =>_('First Name'), 'type' => 'text');
	$add['surname'] = array('name' =>_('Surname'), 'type' => 'text');
	$add['assigned'] = array('name' =>_('Assigned To'), 'type' => 'select', 'values' => $db->GetCol($query));

	$smarty->assign('add', $add);
	
	/* If no default column ordering is set for the company, setup the default */
	if(!isset($_SESSION['preferences']['choosepersonColumns']) || !is_array($_SESSION['preferences']['choosepersonColumns'])) {
		$_SESSION['preferences']['choosepersonColumns'] = array();
		$_SESSION['preferences']['choosepersonColumns'][] = 'name';
		$_SESSION['preferences']['choosepersonColumns'][] = 'company';
	}

	/* Array to hold the columns */
	$headings = array();

	/* Iterate over the columns and translate */
	for($i=0; $i < sizeof($_SESSION['preferences']['choosepersonColumns']); $i++) {
		switch ($_SESSION['preferences']['choosepersonColumns'][$i]) {
			case 'name':
				$headings[$_SESSION['preferences']['choosepersonColumns'][$i]] = _('Name');
				break;
				break;
			case 'company':
				$headings[$_SESSION['preferences']['choosepersonColumns'][$i]] = _('Company');
				break;
		}
	}

	$smarty->assign('headings', $headings);
	
	/* Do Search */
	if(sizeof($_POST) > 0) {
		$egs->checkPost();

		/* do a delete if necessary */
		if(isset($_POST['add'])) {
			require_once(EGS_FILE_ROOT.'/src/classes/class.person.php');

			$person = new person();

			$_POST['lang'] = 'EN';
			$person->savePerson($_POST);

			$smarty->assign('message', _('Contact Saved'));
		} else {
			
			if(isset($_POST['firstname'])) unset($_POST['firstname']);
			if(isset($_POST['surname'])) unset($_POST['surname']);
			if(isset($_POST['assigned'])) unset($_POST['assigned']);

		$save = false;
		
		if(!isset($_SESSION['choosepersonSearch']) || ($_SESSION['choosepersonSearch'] == '') || isset($_POST['clearsearch'])) {
			if(isset($_SESSION['preferences']['choosepersonSearch'])) $_SESSION['choosepersonSearch'] = $_SESSION['preferences']['choosepersonSearch'];
			else unset($_SESSION['choosepersonSearch']);	
		}
		
		/* If Saving, set to search then save */
		if(isset($_POST['savesearch'])) {
			unset($_POST['savesearch']);
			$_SESSION['preferences']['choosepersonSearch'] = $_POST;
			$_SESSION['choosepersonSearch'] = $_POST;
			$egs->syncPreferences();
		}
		
		/* We are searching */
		if(isset($_POST['search'])) {
			unset($_POST['search']);
			$_SESSION['choosepersonSearch'] = $_POST;
			$_SESSION['chooseperson_page'] = 1;
		}
		}
	}
	else if(!isset($_SESSION['choosepersonSearch']) && isset($_SESSION['preferences']['choosepersonSearch'])) $_SESSION['choosepersonSearch'] = $_SESSION['preferences']['choosepersonSearch'];

	/* Set the search order */
	if(isset($_GET['order']) && ($_GET['order'] == $_SESSION['choosepersonOrder']) && in_array($_GET['order'], $_SESSION['preferences']['choosepersonColumns'])) {
		if(isset($_SESSION['choosepersonSort']) && ($_SESSION['choosepersonSort'] == 'ASC')) $_SESSION['choosepersonSort'] = 'DESC';
		else if(isset($_SESSION['choosepersonSort']) && ($_SESSION['choosepersonSort'] == 'DESC')) $_SESSION['choosepersonSort'] = 'ASC';
		$_SESSION['chooseperson_page'] = 1;
	} else if(isset($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['choosepersonColumns'])) {
		$_SESSION['choosepersonSort'] = 'DESC';
		$_SESSION['choosepersonOrder'] = $_GET['order'];
		$_SESSION['chooseperson_page'] = 1;
	}

	if(!isset($_SESSION['choosepersonOrder'])) $_SESSION['choosepersonOrder'] = $_SESSION['preferences']['choosepersonColumns'][0];
	if(!isset($_SESSION['choosepersonSort'])) $_SESSION['choosepersonSort'] = 'ASC';

	$_SESSION['order'] = $_SESSION['choosepersonOrder'];
	
	/* Build the query to get the relevant columns */
	$query = 'SELECT DISTINCT p.id, c.id AS companyid, p.firstname || \' \' || p.surname AS name, c.name AS company FROM personoverview p LEFT OUTER JOIN company c ON (p.companyid=c.id), personaccess a WHERE p.id=a.personid AND ((a.type>2) OR (p.userdetail AND p.companyid='.$db->qstr(EGS_ACTUAL_COMPANY_ID).')) AND a.personid=p.id AND a.usercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND a.username='.$db->qstr(EGS_USERNAME);

	if(isset($_GET['companyid']) && (trim($_GET['companyid']) != '')) $query .= ' AND p.companyid='.$_GET['companyid'];
	
	if(isset($_GET['hide']) && ($_GET['hide'] == 'email')) {
		$query .= ' AND p.email IS NOT NULL';
	}
	
	if(isset($_SESSION['choosepersonSearch']) && (sizeof($_SESSION['choosepersonSearch']) > 0)) {
		$searchString = $egs->searchString($_SESSION['choosepersonSearch']);
		
		if($searchString != '') $query .= ' AND '.$searchString;
		
		$_SESSION['search'] = $_SESSION['choosepersonSearch'];
	}
	else if(isset($_SESSION['search'])) unset($_SESSION['search']);

	$query .= ' ORDER BY '.$_SESSION['choosepersonOrder']. ' '.$_SESSION['choosepersonSort'];
	
	/* Set up the pager and send the query */
	$egs->page($query, 'chooseperson_page');	
?>
