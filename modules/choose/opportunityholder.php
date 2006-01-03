<?php
	/* If the page has not been set, set it */
	if(isset($_GET['page'])) $_SESSION['chooseaopportunity_page'] = max(1, intval($_GET['page']));
	if(!isset($_SESSION['chooseaopportunity_page'])) $_SESSION['chooseaopportunity_page'] = 1;

	/* Set the page title */
	$smarty->assign('pageTitle', _('Contacts: Opportunities'));
	
	/* Setup the search box */
	$smarty->assign('searchTitle', _('Search Opportunities'));

	/* Set the search type */
	$_SESSION['chooseaopportunitySearchType'] = 'norm';

	$smarty->assign('searchForm', $_SESSION['chooseaopportunitySearchType']);
	
	$search = array();
	
	$search['name'] = array('name' =>_('Opportunity Name'), 'type' => 'text');
	$search['company'] = array('name' =>_('Account Name'), 'type' => 'text');

	/* Add the assigned */
	$query = 'SELECT username FROM useraccess WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY username';

	$rs = $db->execute($query);

	if(EGS_DEBUG_SQL && !$rs) die ($db->errorMsg());

	$users = array(_('All') => '');

	while(!$rs->EOF) {
		$users[$rs->fields['username']] = $rs->fields['username'];
		$rs->MoveNext();
	}

	$search['assigned'] = array('name' =>_('Opportunity Assigned To'), 'type' => 'select', 'values' => $users);

	$smarty->assign('search', $search);
	
	/* If no default column ordering is set for the company, setup the default */
	if(!isset($_SESSION['preferences']['chooseaopportunityColumns']) || !is_array($_SESSION['preferences']['chooseaopportunityColumns'])) {
		$_SESSION['preferences']['chooseaopportunityColumns'] = array();
		$_SESSION['preferences']['chooseaopportunityColumns'][] = 'name';
		$_SESSION['preferences']['chooseaopportunityColumns'][] = 'company';
		$_SESSION['preferences']['chooseaopportunityColumns'][] = 'person';
		$_SESSION['preferences']['chooseaopportunityColumns'][] = 'status';
		$_SESSION['preferences']['chooseaopportunityColumns'][] = 'cost';
		$_SESSION['preferences']['chooseaopportunityColumns'][] = 'enddate';
		$_SESSION['preferences']['chooseaopportunityColumns'][] = 'assigned';
	}

	/* Array to hold the columns */
	$headings = array();

	/* Iterate over the columns and translate */
	for($i=0; $i < sizeof($_SESSION['preferences']['chooseaopportunityColumns']); $i++) {
		switch ($_SESSION['preferences']['chooseaopportunityColumns'][$i]) {
			case 'name':
				$headings[$_SESSION['preferences']['chooseaopportunityColumns'][$i]] = _('Opportunity');
				break;
			case 'company':
				$headings[$_SESSION['preferences']['chooseaopportunityColumns'][$i]] = _('Account');
				break;
			case 'status':
				$headings[$_SESSION['preferences']['chooseaopportunityColumns'][$i]] = _('Sales Stage');
				break;
			case 'cost':
				$headings[$_SESSION['preferences']['chooseaopportunityColumns'][$i]] = _('Amount');
				break;
			case 'enddate':
				$headings[$_SESSION['preferences']['chooseaopportunityColumns'][$i]] = _('End Date');
				break;
			case 'assigned':
				$headings[$_SESSION['preferences']['chooseaopportunityColumns'][$i]] = _('Assigned To');
				break;
			case 'person':
				$headings[$_SESSION['preferences']['chooseaopportunityColumns'][$i]] = _('Contact');
				break;
			case 'email':
				$headings[$_SESSION['preferences']['chooseaopportunityColumns'][$i]] = _('Email');
				break;
			case 'owner':
				$headings[$_SESSION['preferences']['chooseaopportunityColumns'][$i]] = _('Owner');
				break;
			case 'assigned':
				$headings[$_SESSION['preferences']['chooseaopportunityColumns'][$i]] = _('Assigned');
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
		
		if(!isset($_SESSION['chooseaopportunitySearch']) || ($_SESSION['chooseaopportunitySearch'] == '') || isset($_POST['clearsearch'])) {
			if(isset($_SESSION['preferences']['chooseaopportunitySearch'])) $_SESSION['chooseaopportunitySearch'] = $_SESSION['preferences']['chooseaopportunitySearch'];
			else unset($_SESSION['chooseaopportunitySearch']);	
		}
		
		/* If Saving, set to search then save */
		if(isset($_POST['savesearch'])) {
			unset($_POST['savesearch']);
			$_SESSION['preferences']['chooseaopportunitySearch'] = $_POST;
			$_SESSION['chooseaopportunitySearch'] = $_POST;
			$egs->syncPreferences();
		}
		
		/* We are searching */
		if(isset($_POST['search'])) {
			unset($_POST['search']);
			$_SESSION['chooseaopportunitySearch'] = $_POST;
			$_SESSION['chooseaopportunity_page'] = 1;
		}
	}
	else if(!isset($_SESSION['chooseaopportunitySearch']) && isset($_SESSION['preferences']['chooseaopportunitySearch'])) $_SESSION['chooseaopportunitySearch'] = $_SESSION['preferences']['chooseaopportunitySearch'];

	/* Set the search order */
	if(isset($_GET['order']) && ($_GET['order'] == $_SESSION['chooseaopportunityOrder']) && in_array($_GET['order'], $_SESSION['preferences']['chooseaopportunityColumns'])) {
		if(isset($_SESSION['chooseaopportunitySort']) && ($_SESSION['chooseaopportunitySort'] == 'ASC')) $_SESSION['chooseaopportunitySort'] = 'DESC';
		else if(isset($_SESSION['chooseaopportunitySort']) && ($_SESSION['chooseaopportunitySort'] == 'DESC')) $_SESSION['chooseaopportunitySort'] = 'ASC';
		$_SESSION['chooseaopportunity_page'] = 1;
	} else if(isset($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['chooseaopportunityColumns'])) {
		$_SESSION['chooseaopportunitySort'] = 'DESC';
		$_SESSION['chooseaopportunityOrder'] = $_GET['order'];
		$_SESSION['chooseaopportunity_page'] = 1;
	}

	if(!isset($_SESSION['chooseaopportunityOrder'])) $_SESSION['chooseaopportunityOrder'] = $_SESSION['preferences']['chooseaopportunityColumns'][0];
	if(!isset($_SESSION['chooseaopportunitySort'])) $_SESSION['chooseaopportunitySort'] = 'ASC';

	$_SESSION['order'] = $_SESSION['chooseaopportunityOrder'];
	
	/* Build the query to get the relevant columns */
	$query = 'SELECT id, id, id, id,  ';

	$links = array();
	
	for($i = 0; $i < sizeof($_SESSION['preferences']['chooseaopportunityColumns']); $i++) {
		if($_SESSION['preferences']['chooseaopportunityColumns'][$i] == 'company') $links[$i+1] = '&amp;module=contacts&amp;action=view&amp;id=';
		if($_SESSION['preferences']['chooseaopportunityColumns'][$i] == 'person') $links[$i+1] = '&amp;module=contacts&amp;action=viewperson&amp;personid=';
		
		if(strpos($_SESSION['preferences']['chooseaopportunityColumns'][$i], 'date')) $query .= $db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), $_SESSION['preferences']['chooseaopportunityColumns'][$i]).' AS '.$_SESSION['preferences']['chooseaopportunityColumns'][$i];
		else $query .= $_SESSION['preferences']['chooseaopportunityColumns'][$i];
		if(($i+1) != sizeof($_SESSION['preferences']['chooseaopportunityColumns'])) $query .= ', ';
	}

	$query .= ' FROM opportunityoverview WHERE companyid='.$_GET['companyid'];
	
	if(isset($_SESSION['chooseaopportunitySearch']) && (sizeof($_SESSION['chooseaopportunitySearch']) > 0)) {
		$searchString = $egs->searchString($_SESSION['chooseaopportunitySearch']);
		
		if($searchString != '') $query .= ' '.$searchString;
		
		$_SESSION['search'] = $_SESSION['chooseaopportunitySearch'];
	}
	else if(isset($_SESSION['search'])) unset($_SESSION['search']);

	$query .= ' ORDER BY '.$_SESSION['chooseaopportunityOrder']. ' '.$_SESSION['chooseaopportunitySort'];

	/* Set up the pager and send the query */
	$egs->page($query, 'chooseaopportunity_page', $links);	
?>
