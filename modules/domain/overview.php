<?php
	/* If the page is being changed, set it */
	if(isset($_GET['page'])) $_SESSION['domain_page'] = max(1, intval($_GET['page']));
	/* If the page has not been set, set it */
	if(!isset($_SESSION['domain_page'])) $_SESSION['domain_page'] = 1;

	/* Set the page title */
	$smarty->assign('pageTitle', _('Domains'));
	
	/* Setup the search box */
	$smarty->assign('searchTitle', _('Search Domains'));
	
	/* Set the search type */
	if(isset($_GET['search']) && ($_GET['search'] == 'adv')) $_SESSION['accountSearchType'] = 'adv';
	else if(isset($_GET['search']) && ($_GET['search'] == 'norm')) $_SESSION['accountSearchType'] = 'norm';
	else if(!isset($_SESSION['accountSearchType'])) $_SESSION['accountSearchType'] = 'norm';

	$smarty->assign('searchForm', $_SESSION['accountSearchType']);
	
	$search = array();

	$search['name'] = array('name' =>_('Domain Name'), 'type' => 'text');
	$search['companyname'] = array('name' =>_('Client'), 'type' => 'text');
	$search['personname'] = array('name' =>_('Contact'), 'type' => 'text');

	if($_SESSION['accountSearchType'] == 'adv') {
	$search['sixtydays//boolean'] = array('name' =>_('Expiring in 60 Days'), 'type' => 'select', 'values' => array(_('All') => '', _('Yes') => 'true', _('No') => 'false'));
	$search['thirtydays//boolean'] = array('name' =>_('Expiring in 30 Days'), 'type' => 'select', 'values' => array(_('All') => '', _('Yes') => 'true', _('No') => 'false'));
	$search['fivedays//boolean'] = array('name' =>_('Expiring in 5 Days'), 'type' => 'select', 'values' => array(_('All') => '', _('Yes') => 'true', _('No') => 'false'));
	}
	
	$smarty->assign('search', $search);
	
	/* If no default column ordering is set for the company, setup the default */
	if(!isset($_SESSION['preferences']['domainColumns']) || !is_array($_SESSION['preferences']['domainColumns'])) {
		$_SESSION['preferences']['domainColumns'] = array();
		$_SESSION['preferences']['domainColumns'][] = 'name';
		$_SESSION['preferences']['domainColumns'][] = 'companyname';
		$_SESSION['preferences']['domainColumns'][] = 'personname';
		$_SESSION['preferences']['domainColumns'][] = 'expires';
	}

	/* Array to hold the columns */
	$headings = array();

	/* Iterate over the columns and translate */
	for($i=0; $i < sizeof($_SESSION['preferences']['domainColumns']); $i++) {
		switch ($_SESSION['preferences']['domainColumns'][$i]) {
			case 'name':
				$headings[$_SESSION['preferences']['domainColumns'][$i]] = _('Domain Name');
				break;
			case 'companyname':
				$headings[$_SESSION['preferences']['domainColumns'][$i]] = _('Client');
				break;
			case 'personname':
				$headings[$_SESSION['preferences']['domainColumns'][$i]] = _('Contact');
				break;
			case 'expires':
				$headings[$_SESSION['preferences']['domainColumns'][$i]] = _('Expires');
				break;
			case 'sixtydays':
				$headings[$_SESSION['preferences']['domainColumns'][$i]] = _('Expires in 60 Days');
				break;
			case 'thirtydays':
				$headings[$_SESSION['preferences']['domainColumns'][$i]] = _('Expires in 30 Days');
				break;
			case 'fivedays':
				$headings[$_SESSION['preferences']['domainColumns'][$i]] = _('Expires in 5 Days');
				break;
		}
	}

	$smarty->assign('headings', $headings);

	$links = array();
	/* Do Search */
	if(sizeof($_POST) > 0) {
		$egs->checkPost();

		/* do a delete if necessary */
		if(isset($_POST['delete']) && sizeof($_POST['delete'])) {
			while(list($key, $val) = each($_POST['delete'])) {
				require_once(EGS_FILE_ROOT.'/src/classes/class.project.php');

				$project= new project();

				$project->deleteProject(intval($val));
			}

			$smarty->assign('messages', array(_('Projects deleted')));
		}

		$save = false;
		
		if(!isset($_SESSION['domainSearch']) || ($_SESSION['domainSearch'] == '') || isset($_POST['clearsearch'])) {
			if(isset($_SESSION['preferences']['domainSearch'])) $_SESSION['domainSearch'] = $_SESSION['preferences']['domainSearch'];
			else unset($_SESSION['domainSearch']);	
		}
		
		/* If Saving, set to search then save */
		if(isset($_POST['savesearch'])) {
			unset($_POST['savesearch']);
			$_SESSION['preferences']['domainSearch'] = $_POST;
			$_SESSION['domainSearch'] = $_POST;
			$egs->syncPreferences();
		}
		
		/* We are searching */
		if(isset($_POST['search'])) {
			unset($_POST['search']);
			$_SESSION['domainSearch'] = $_POST;
			$_SESSION['domain_page'] = 1;
		}
	}
	else if(!isset($_SESSION['domainSearch']) && isset($_SESSION['preferences']['domainSearch'])) $_SESSION['domainSearch'] = $_SESSION['preferences']['domainSearch'];

	/* Set the search order */
	if(isset($_GET['order']) && ($_GET['order'] == $_SESSION['domainOrder']) && in_array($_GET['order'], $_SESSION['preferences']['domainColumns'])) {
		if(isset($_SESSION['domainSort']) && ($_SESSION['domainSort'] == 'ASC')) $_SESSION['domainSort'] = 'DESC';
		else if(isset($_SESSION['domainSort']) && ($_SESSION['domainSort'] == 'DESC')) $_SESSION['domainSort'] = 'ASC';
		$_SESSION['domain_page'] = 1;
	} else if(isset($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['domainColumns'])) {
		$_SESSION['domainSort'] = 'DESC';
		$_SESSION['domainOrder'] = $_GET['order'];
		$_SESSION['domain_page'] = 1;
	}

	if(!isset($_SESSION['domainOrder'])) $_SESSION['domainOrder'] = $_SESSION['preferences']['domainColumns'][0];
	if(!isset($_SESSION['domainSort'])) $_SESSION['domainSort'] = 'ASC';

	$_SESSION['order'] = $_SESSION['domainOrder'];

	/* Build the query to get the relevant columns */
	$query = 'SELECT companyid, personid, id, ';

	for($i = 0; $i < sizeof($_SESSION['preferences']['domainColumns']); $i++) {
		if($_SESSION['preferences']['domainColumns'][$i] == 'companyname') $links[$i+1] = '&amp;module=contacts&amp;action=view&amp;id=';
		if($_SESSION['preferences']['domainColumns'][$i] == 'personname') $links[$i+1] = '&amp;module=contacts&amp;action=viewperson&amp;personid=';
		
		if(strpos($_SESSION['preferences']['domainColumns'][$i], 'expires') !== false) $query .= $db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), $_SESSION['preferences']['domainColumns'][$i]).' AS '.$_SESSION['preferences']['domainColumns'][$i];
		else $query .= $_SESSION['preferences']['domainColumns'][$i];
		if(($i+1) != sizeof($_SESSION['preferences']['domainColumns'])) $query .= ', ';
	}

	$query .= ' FROM domainoverview';
	$searchString='';
	if(isset($_SESSION['domainSearch']) && (sizeof($_SESSION['domainSearch']) > 0)) {
		$searchString = $egs->searchString($_SESSION['domainSearch']);
		
		if($searchString != '') $query .= ' WHERE '.$searchString;
		
		$_SESSION['search'] = $_SESSION['domainSearch'];
	}
	else if(isset($_SESSION['search'])) unset($_SESSION['search']);

	if(($searchString == '') && !EGS_DOMAINADMIN) $query .= ' WHERE companyid='.$db->qstr(EGS_ACTUAL_COMPANY_ID);
	else if(!EGS_DOMAINADMIN) $query .= ' AND companyid='.$db->qstr(EGS_ACTUAL_COMPANY_ID);
		
	if(!isset($_SESSION['domainOrder'])) $_SESSION['domainOrder'] = 'jobno';
	if(!isset($_SESSION['domainSort'])) $_SESSION['domainSort'] = 'ASC';
	
	$query .= ' ORDER BY '.$_SESSION['domainOrder']. ' '.$_SESSION['domainSort'];

	/* Set up the pager and send the query */
	$egs->page($query, 'domain_page', $links);	
?>
