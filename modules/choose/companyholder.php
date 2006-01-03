<?php
	/* If the page has not been set, set it */
	if(isset($_GET['page'])) $_SESSION['chooseaccount_page'] = max(1, intval($_GET['page']));
	if(!isset($_SESSION['chooseaccount_page'])) $_SESSION['chooseaccount_page'] = 1;

	/* Set the page title */
	$smarty->assign('pageTitle', _('Contacts: Accounts'));
	
	/* Setup the search box */
	$smarty->assign('searchTitle', _('Search Accounts'));

	/* Set the search type */
	if(isset($_GET['search']) && ($_GET['search'] == 'adv')) $_SESSION['chooseaccountSearchType'] = 'adv';
	else if(isset($_GET['search']) && ($_GET['search'] == 'norm')) $_SESSION['chooseaccountSearchType'] = 'norm';
	else if(!isset($_SESSION['chooseaccountSearchType'])) $_SESSION['chooseaccountSearchType'] = 'norm';

	$smarty->assign('searchForm', $_SESSION['chooseaccountSearchType']);
	
	$search = array();
	
	$search['accountnumber'] = array('name' =>_('Account No.'), 'type' => 'text');
	$search['name'] = array('name' =>_('Account Name'), 'type' => 'text');
	$search['town'] = array('name' =>_('Town'), 'type' => 'text');

	$smarty->assign('search', $search);
	
	/* Setup the add box */
	$smarty->assign('addTitle', _('Add New Account'));
	
	$add = array();
	
	$query = 'SELECT username FROM useraccess WHERE companyid='.$db->qstr(EGS_COMPANY_ID);
	
	$add['accountnumber'] = array('name' =>_('Account No.'), 'type' => 'text');
	$add['name'] = array('name' =>_('Account Name'), 'type' => 'text');
	$add['assigned'] = array('name' =>_('Assigned To'), 'type' => 'select', 'values' => $db->GetCol($query));

	$smarty->assign('add', $add);
	
	/* If no default column ordering is set for the company, setup the default */
	if(!isset($_SESSION['preferences']['chooseaccountColumns']) || !is_array($_SESSION['preferences']['chooseaccountColumns'])) {
		$_SESSION['preferences']['chooseaccountColumns'] = array();
		$_SESSION['preferences']['chooseaccountColumns'][] = 'c.accountnumber';
		$_SESSION['preferences']['chooseaccountColumns'][] = 'c.name';
		$_SESSION['preferences']['chooseaccountColumns'][] = 'c.town';
	}

	/* Array to hold the columns */
	$headings = array();

	/* Iterate over the columns and translate */
	for($i=0; $i < sizeof($_SESSION['preferences']['chooseaccountColumns']); $i++) {
		switch ($_SESSION['preferences']['chooseaccountColumns'][$i]) {
			case 'accountnumber':
				$headings[$_SESSION['preferences']['chooseaccountColumns'][$i]] = _('Account Num.');
				break;
			case 'name':
				$headings[$_SESSION['preferences']['chooseaccountColumns'][$i]] = _('Account Name');
				break;
			case 'town':
				$headings[$_SESSION['preferences']['chooseaccountColumns'][$i]] = _('Town');
				break;
		}
	}

	$smarty->assign('headings', $headings);
	
	/* Do Search */
	if(sizeof($_POST) > 0) {
		$egs->checkPost();

		/* do a delete if necessary */
		if(isset($_POST['add'])) {
			require_once(EGS_FILE_ROOT.'/src/classes/class.company.php');

			$company = new company();

			$company->saveCompany($_POST);

			$smarty->assign('message', _('Account Added'));
			
		} else {

		$save = false;
		
		if(!isset($_SESSION['chooseaccountSearch']) || ($_SESSION['chooseaccountSearch'] == '') || isset($_POST['clearsearch'])) {
			if(isset($_SESSION['preferences']['chooseaccountSearch'])) $_SESSION['chooseaccountSearch'] = $_SESSION['preferences']['chooseaccountSearch'];
			else unset($_SESSION['chooseaccountSearch']);	
		}
		
		/* If Saving, set to search then save */
		if(isset($_POST['savesearch'])) {
			unset($_POST['savesearch']);
			$_SESSION['preferences']['chooseaccountSearch'] = $_POST;
			$_SESSION['chooseaccountSearch'] = $_POST;
			$egs->syncPreferences();
		}
		
		/* We are searching */
		if(isset($_POST['search'])) {
			unset($_POST['search']);
			$_SESSION['chooseaccountSearch'] = $_POST;
			$_SESSION['chooseaccount_page'] = 1;
		}
		}
	}
	else if(!isset($_SESSION['chooseaccountSearch']) && isset($_SESSION['preferences']['chooseaccountSearch'])) $_SESSION['chooseaccountSearch'] = $_SESSION['preferences']['chooseaccountSearch'];

	/* Set the search order */
	if(isset($_GET['order']) && ($_GET['order'] == $_SESSION['chooseaccountOrder']) && in_array($_GET['order'], $_SESSION['preferences']['chooseaccountColumns'])) {
		if(isset($_SESSION['chooseaccountSort']) && ($_SESSION['chooseaccountSort'] == 'ASC')) $_SESSION['chooseaccountSort'] = 'DESC';
		else if(isset($_SESSION['chooseaccountSort']) && ($_SESSION['chooseaccountSort'] == 'DESC')) $_SESSION['chooseaccountSort'] = 'ASC';
		$_SESSION['chooseaccount_page'] = 1;
	} else if(isset($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['chooseaccountColumns'])) {
		$_SESSION['chooseaccountSort'] = 'DESC';
		$_SESSION['chooseaccountOrder'] = $_GET['order'];
		$_SESSION['chooseaccount_page'] = 1;
	}

	if(!isset($_SESSION['chooseaccountOrder'])) $_SESSION['chooseaccountOrder'] = $_SESSION['preferences']['chooseaccountColumns'][0];
	if(!isset($_SESSION['chooseaccountSort'])) $_SESSION['chooseaccountSort'] = 'ASC';

	$_SESSION['order'] = $_SESSION['chooseaccountOrder'];
	
	/* Build the query to get the relevant columns */
	$query = 'SELECT \'\' AS nothing, id, ';

	for($i = 0; $i < sizeof($_SESSION['preferences']['chooseaccountColumns']); $i++) {
		$query .= $_SESSION['preferences']['chooseaccountColumns'][$i];
		if(($i+1) != sizeof($_SESSION['preferences']['chooseaccountColumns'])) $query .= ', ';
	}

	$query .= ' FROM companyoverview c, companyaccess a WHERE a.companyid=c.id AND a.usercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND a.username='.$db->qstr(EGS_USERNAME).' AND c.companyid='.$db->qstr(EGS_COMPANY_ID);
	
	if(isset($_SESSION['chooseaccountSearch']) && (sizeof($_SESSION['chooseaccountSearch']) > 0)) {
		$searchString = $egs->searchString($_SESSION['chooseaccountSearch']);
		
		if($searchString != '') $query .= ' AND '.$searchString;
		
		$_SESSION['search'] = $_SESSION['chooseaccountSearch'];
	}
	else if(isset($_SESSION['search'])) unset($_SESSION['search']);

	$query .= ' ORDER BY '.$_SESSION['chooseaccountOrder']. ' '.$_SESSION['chooseaccountSort'];
	
	/* Set up the pager and send the query */
	$egs->page($query, 'chooseaccount_page');	
?>
