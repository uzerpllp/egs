<?php
	/* If the page has not been set, set it */
	if(isset($_GET['page'])) $_SESSION['chooseacase_page'] = max(1, intval($_GET['page']));
	if(!isset($_SESSION['chooseacase_page'])) $_SESSION['chooseacase_page'] = 1;

	/* Set the page title */
	$smarty->assign('pageTitle', _('Contacts: Cases'));
	
	/* Set this to make it take the case not num */
	$smarty->assign('case', true);
	
	/* Setup the search box */
	$smarty->assign('searchTitle', _('Search Cases'));

	/* Set the search type */
	$_SESSION['chooseacaseSearchType'] = 'norm';

	$smarty->assign('searchForm', $_SESSION['chooseacaseSearchType']);
	
	$search = array();
	
	$search['name'] = array('name' =>_('Case Name'), 'type' => 'text');
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

	$search['assigned'] = array('name' =>_('Case Assigned To'), 'type' => 'select', 'values' => $users);

	$smarty->assign('search', $search);
	
	/* If no default column ordering is set for the company, setup the default */
	if(!isset($_SESSION['preferences']['chooseacaseColumns']) || !is_array($_SESSION['preferences']['chooseacaseColumns'])) {
		$_SESSION['preferences']['chooseacaseColumns'] = array();
		$_SESSION['preferences']['chooseacaseColumns'][] = 'id';
		$_SESSION['preferences']['chooseacaseColumns'][] = 'name';
		$_SESSION['preferences']['chooseacaseColumns'][] = 'company';
		$_SESSION['preferences']['chooseacaseColumns'][] = 'person';
		$_SESSION['preferences']['chooseacaseColumns'][] = 'priority';
		$_SESSION['preferences']['chooseacaseColumns'][] = 'status';
		$_SESSION['preferences']['chooseacaseColumns'][] = 'assigned';
	}

	/* Array to hold the columns */
	$headings = array();

	/* Iterate over the columns and translate */
	for($i=0; $i < sizeof($_SESSION['preferences']['chooseacaseColumns']); $i++) {
		switch ($_SESSION['preferences']['chooseacaseColumns'][$i]) {
			case 'name':
				$headings[$_SESSION['preferences']['chooseacaseColumns'][$i]] = _('Case');
				break;
			case 'company':
				$headings[$_SESSION['preferences']['chooseacaseColumns'][$i]] = _('Account');
				break;
			case 'status':
				$headings[$_SESSION['preferences']['chooseacaseColumns'][$i]] = _('Sales Stage');
				break;
			case 'id':
				$headings[$_SESSION['preferences']['chooseacaseColumns'][$i]] = _('Num');
				break;
			case 'priority':
				$headings[$_SESSION['preferences']['chooseacaseColumns'][$i]] = _('Priority');
				break;
			case 'assigned':
				$headings[$_SESSION['preferences']['chooseacaseColumns'][$i]] = _('Assigned To');
				break;
			case 'person':
				$headings[$_SESSION['preferences']['chooseacaseColumns'][$i]] = _('Contact');
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
		
		if(!isset($_SESSION['chooseacaseSearch']) || ($_SESSION['chooseacaseSearch'] == '') || isset($_POST['clearsearch'])) {
			if(isset($_SESSION['preferences']['chooseacaseSearch'])) $_SESSION['chooseacaseSearch'] = $_SESSION['preferences']['chooseacaseSearch'];
			else unset($_SESSION['chooseacaseSearch']);	
		}
		
		/* If Saving, set to search then save */
		if(isset($_POST['savesearch'])) {
			unset($_POST['savesearch']);
			$_SESSION['preferences']['chooseacaseSearch'] = $_POST;
			$_SESSION['chooseacaseSearch'] = $_POST;
			$egs->syncPreferences();
		}
		
		/* We are searching */
		if(isset($_POST['search'])) {
			unset($_POST['search']);
			$_SESSION['chooseacaseSearch'] = $_POST;
			$_SESSION['chooseacase_page'] = 1;
		}
	}
	else if(!isset($_SESSION['chooseacaseSearch']) && isset($_SESSION['preferences']['chooseacaseSearch'])) $_SESSION['chooseacaseSearch'] = $_SESSION['preferences']['chooseacaseSearch'];

	/* Set the search order */
	if(isset($_GET['order']) && ($_GET['order'] == $_SESSION['chooseacaseOrder']) && in_array($_GET['order'], $_SESSION['preferences']['chooseacaseColumns'])) {
		if(isset($_SESSION['chooseacaseSort']) && ($_SESSION['chooseacaseSort'] == 'ASC')) $_SESSION['chooseacaseSort'] = 'DESC';
		else if(isset($_SESSION['chooseacaseSort']) && ($_SESSION['chooseacaseSort'] == 'DESC')) $_SESSION['chooseacaseSort'] = 'ASC';
		$_SESSION['chooseacase_page'] = 1;
	} else if(isset($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['chooseacaseColumns'])) {
		$_SESSION['chooseacaseSort'] = 'DESC';
		$_SESSION['chooseacaseOrder'] = $_GET['order'];
		$_SESSION['chooseacase_page'] = 1;
	}

	if(!isset($_SESSION['chooseacaseOrder'])) $_SESSION['chooseacaseOrder'] = $_SESSION['preferences']['chooseacaseColumns'][0];
	if(!isset($_SESSION['chooseacaseSort'])) $_SESSION['chooseacaseSort'] = 'ASC';

	$_SESSION['order'] = $_SESSION['chooseacaseOrder'];
	
	/* Build the query to get the relevant columns */
	$query = 'SELECT id, id, id, id, ';

	$links = array();
	
	for($i = 0; $i < sizeof($_SESSION['preferences']['chooseacaseColumns']); $i++) {
		if($_SESSION['preferences']['chooseacaseColumns'][$i] == 'company') $links[$i+1] = '&amp;module=contacts&amp;action=view&amp;id=';
		if($_SESSION['preferences']['chooseacaseColumns'][$i] == 'person') $links[$i+1] = '&amp;module=contacts&amp;action=viewperson&amp;personid=';
		
		if(strpos($_SESSION['preferences']['chooseacaseColumns'][$i], 'date')) $query .= $db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), $_SESSION['preferences']['chooseacaseColumns'][$i]).' AS '.$_SESSION['preferences']['chooseacaseColumns'][$i];
		else $query .= $_SESSION['preferences']['chooseacaseColumns'][$i];
		if(($i+1) != sizeof($_SESSION['preferences']['chooseacaseColumns'])) $query .= ', ';
	}

	$query .= ' FROM crmcaseoverview WHERE  companyid='.$_GET['companyid'];
	
	if(isset($_SESSION['chooseacaseSearch']) && (sizeof($_SESSION['chooseacaseSearch']) > 0)) {
		$searchString = $egs->searchString($_SESSION['chooseacaseSearch']);
		
		if($searchString != '') $query .= ' '.$searchString;
		
		$_SESSION['search'] = $_SESSION['chooseacaseSearch'];
	}
	else if(isset($_SESSION['search'])) unset($_SESSION['search']);

	$query .= ' ORDER BY '.$_SESSION['chooseacaseOrder']. ' '.$_SESSION['chooseacaseSort'];

	/* Set up the pager and send the query */
	$egs->page($query, 'chooseacase_page', $links);	
?>
