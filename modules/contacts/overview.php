<?php
	/* If the page has not been set, set it */
	if(isset($_GET['page'])) $_SESSION['account_page'] = max(1, intval($_GET['page']));
	if(!isset($_SESSION['account_page'])) $_SESSION['account_page'] = 1;

	/* Set the page title */
	$smarty->assign('pageTitle', _('Contacts: Accounts'));
	
	/* Setup the search box */
	$smarty->assign('searchTitle', _('Search Accounts'));

	/* Set the search type */
	if(isset($_GET['search']) && ($_GET['search'] == 'adv')) $_SESSION['accountSearchType'] = 'adv';
	else if(isset($_GET['search']) && ($_GET['search'] == 'norm')) $_SESSION['accountSearchType'] = 'norm';
	else if(!isset($_SESSION['accountSearchType'])) $_SESSION['accountSearchType'] = 'norm';

	$smarty->assign('searchForm', $_SESSION['accountSearchType']);
	
	$search = array();
	
	$search['a.accountnumber'] = array('name' =>_('Account No.'), 'type' => 'text');
	$search['a.name'] = array('name' =>_('Account Name'), 'type' => 'text');

	if($_SESSION['accountSearchType'] == 'adv') {
		$search['a.www'] = array('name' =>_('Website'), 'type' => 'text');
		$search['a.phone'] = array('name' =>_('Phone'), 'type' => 'text');
		$search['a.fax'] = array('name' =>_('Fax'), 'type' => 'text');
		$search['a.email'] = array('name' =>_('Email'), 'type' => 'text');
	} else {
		$search['a.town'] = array('name' =>_('Town'), 'type' => 'text');
	}

	/* Add the contact categories to the search */
	$query = 'SELECT id, name FROM contactcategories WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY name';

	$rs = $db->execute($query);

	if(EGS_DEBUG_SQL && !$rs) die ($db->errorMsg());

	$categories = array(_('All') => '');

	while(!$rs->EOF) {
		$categories[$rs->fields['name']] = $rs->fields['id'];
		$rs->MoveNext();
	}

	$search['c.typeid'] = array('name' =>_('Contact Categories'), 'type' => 'select', 'values' => $categories);

	/* Add the assigned */
	$query = 'SELECT username FROM useraccess WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY username';

	$rs = $db->execute($query);

	if(EGS_DEBUG_SQL && !$rs) die ($db->errorMsg());

	$users = array(_('All') => '');

	while(!$rs->EOF) {
		$users[$rs->fields['username']] = $rs->fields['username'];
		$rs->MoveNext();
	}

	$search['a.owner'] = array('name' =>_('Account Owner'), 'type' => 'select', 'values' => $users);
	$search['a.assigned'] = array('name' =>_('Account Assigned To'), 'type' => 'select', 'values' => $users);

	$smarty->assign('search', $search);
	
	/* If no default column ordering is set for the company, setup the default */
	if(!isset($_SESSION['preferences']['accountColumns']) || !is_array($_SESSION['preferences']['accountColumns'])) {
		$_SESSION['preferences']['accountColumns'] = array();
		$_SESSION['preferences']['accountColumns'][] = 'accountnumber';
		$_SESSION['preferences']['accountColumns'][] = 'name';
		$_SESSION['preferences']['accountColumns'][] = 'town';
		$_SESSION['preferences']['accountColumns'][] = 'www';
		$_SESSION['preferences']['accountColumns'][] = 'phone';
	}

	/* Array to hold the columns */
	$headings = array();

	/* Iterate over the columns and translate */
	for($i=0; $i < sizeof($_SESSION['preferences']['accountColumns']); $i++) {
		switch ($_SESSION['preferences']['accountColumns'][$i]) {
			case 'accountnumber':
				$headings[$_SESSION['preferences']['accountColumns'][$i]] = _('Account Num.');
				break;
			case 'name':
				$headings[$_SESSION['preferences']['accountColumns'][$i]] = _('Account Name');
				break;
			case 'address':
				$headings[$_SESSION['preferences']['accountColumns'][$i]] = _('Address');
				break;
			case 'town':
				$headings[$_SESSION['preferences']['accountColumns'][$i]] = _('Town');
				break;
			case 'www':
				$headings[$_SESSION['preferences']['accountColumns'][$i]] = _('Website');
				break;
			case 'phone':
				$headings[$_SESSION['preferences']['accountColumns'][$i]] = _('Phone Number');
				break;
			case 'fax':
				$headings[$_SESSION['preferences']['accountColumns'][$i]] = _('Fax');
				break;
			case 'email':
				$headings[$_SESSION['preferences']['accountColumns'][$i]] = _('Email');
				break;
			case 'owner':
				$headings[$_SESSION['preferences']['accountColumns'][$i]] = _('Owner');
				break;
			case 'assigned':
				$headings[$_SESSION['preferences']['accountColumns'][$i]] = _('Assigned');
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
				require_once(EGS_FILE_ROOT.'/src/classes/class.company.php');

				$company = new company();

				$company->deleteCompany(intval($val));
			}

			$smarty->assign('messages', array(_('Companies deleted')));
		}

		$save = false;
		
		if(!isset($_SESSION['accountSearch']) || ($_SESSION['accountSearch'] == '') || isset($_POST['clearsearch'])) {
			if(isset($_SESSION['preferences']['accountSearch'])) $_SESSION['accountSearch'] = $_SESSION['preferences']['accountSearch'];
			else unset($_SESSION['accountSearch']);	
		}
		
		/* If Saving, set to search then save */
		if(isset($_POST['savesearch'])) {
			unset($_POST['savesearch']);
			$_SESSION['preferences']['accountSearch'] = $_POST;
			$_SESSION['accountSearch'] = $_POST;
			$egs->syncPreferences();
		}
		
		/* We are searching */
		if(isset($_POST['search'])) {
			unset($_POST['search']);
			$_SESSION['accountSearch'] = $_POST;
			$_SESSION['account_page'] = 1;
		}
	}
	else if(!isset($_SESSION['accountSearch']) && isset($_SESSION['preferences']['accountSearch'])) $_SESSION['accountSearch'] = $_SESSION['preferences']['accountSearch'];

	/* Set the search order */
	
	if(isset($_SESSION['accountOrder'])&&$_SESSION['accountOrder']=='street1')
		$_SESSION['accountOrder']='address';
	if(isset($_GET['order']) && ($_GET['order'] == $_SESSION['accountOrder']) && in_array($_GET['order'], $_SESSION['preferences']['accountColumns'])) {
		if(isset($_SESSION['accountSort']) && ($_SESSION['accountSort'] == 'ASC')) $_SESSION['accountSort'] = 'DESC';
		else if(isset($_SESSION['accountSort']) && ($_SESSION['accountSort'] == 'DESC')) $_SESSION['accountSort'] = 'ASC';
		$_SESSION['account_page'] = 1;
	} else if(isset($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['accountColumns'])) {
		$_SESSION['accountSort'] = 'DESC';
		$_SESSION['accountOrder'] = $_GET['order'];
		$_SESSION['account_page'] = 1;
	}
	
	if(!isset($_SESSION['accountOrder'])) $_SESSION['accountOrder'] = $_SESSION['preferences']['accountColumns'][0];
	if(!isset($_SESSION['accountSort'])) $_SESSION['accountSort'] = 'ASC';
	if($_SESSION['accountOrder']=='address')$_SESSION['accountOrder']='street1';
	$_SESSION['order'] = $_SESSION['accountOrder'];
	
	/* Build the query to get the relevant columns */
	$query = 'SELECT a.id, ';

	$category = false;

	if(isset($_SESSION['accountSearch']) && array_key_exists('c_typeid', $_SESSION['accountSearch'])) $category = true;

	for($i = 0; $i < sizeof($_SESSION['preferences']['accountColumns']); $i++) {
		if($_SESSION['preferences']['accountColumns'][$i]=='address')
			$query .= 'street1 || \', \' || street2 || \', \' || street3 || \', \' || town || \', \' || county || \', \' || postcode';
		else
			$query .= 'a.'.$_SESSION['preferences']['accountColumns'][$i];
		if(($i+1) != sizeof($_SESSION['preferences']['accountColumns'])) $query .= ', ';
	}

	$query .= ' FROM companyoverview a, companyaccess ca ';

	if($category) $query .= ', companytypexref c ';

	$query.= 'WHERE a.id=ca.companyid AND ca.usercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND ca.username='.$db->qstr(EGS_USERNAME);
	
	if(isset($_SESSION['accountSearch']) && (sizeof($_SESSION['accountSearch']) > 0)) {
		$searchString = $egs->searchString($_SESSION['accountSearch']);
		
		if(($searchString != '') && ($category)) $query .= ' AND c.companyid=a.id AND '.$searchString;
		else if($searchString != '') $query .= ' AND '.$searchString;
		
		$_SESSION['search'] = $_SESSION['accountSearch'];
	}
	else if(isset($_SESSION['search'])) unset($_SESSION['search']);
	
	$query .= ' ORDER BY a.'.$_SESSION['accountOrder']. ' '.$_SESSION['accountSort'];
	
	/* Set up the pager and send the query */
	$egs->page($query, 'account_page');	
?>
