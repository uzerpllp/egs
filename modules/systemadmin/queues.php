<?php
if (in_array('systemadmin', $_SESSION['modules'])) {
	/* If the page has not been set, set it */
	if(isset($_GET['page'])) $_SESSION['systemqueues_page'] = max(1, intval($_GET['page']));
	if(!isset($_SESSION['systemqueues_page'])) $_SESSION['systemqueues_page'] = 1;

	/* Set the page title */
	$smarty->assign('pageTitle', _('Ticket Queues'));
	
	/* Set the new button */
	$smarty->assign('pageNew', 'action=viewqueue');
	
	/* If no default column ordering is set for the users, setup the default */
	if(!isset($_SESSION['preferences']['systemqueuesColumns']) || !is_array($_SESSION['preferences']['systemqueuesColumns'])) {
		$_SESSION['preferences']['systemqueuesColumns'] = array();
		$_SESSION['preferences']['systemqueuesColumns'][] = 'name';
		$_SESSION['preferences']['systemqueuesColumns'][] = 'company';
		$_SESSION['preferences']['systemqueuesColumns'][] = 'address';
		$_SESSION['preferences']['systemqueuesColumns'][] = 'actualaddress';
	}

	/* Array to hold the columns */
	$headings = array();

	/* Iterate over the columns and translate */
	for($i=0; $i < sizeof($_SESSION['preferences']['systemqueuesColumns']); $i++) {
		switch ($_SESSION['preferences']['systemqueuesColumns'][$i]) {
			case 'name':
				$headings[$_SESSION['preferences']['systemqueuesColumns'][$i]] = _('Name');
				break;
			case 'company':
				$headings[$_SESSION['preferences']['systemqueuesColumns'][$i]] = _('Company');
				break;
			case 'address':
				$headings[$_SESSION['preferences']['systemqueuesColumns'][$i]] = _('Email');
				break;
			case 'actualaddress':
				$headings[$_SESSION['preferences']['systemqueuesColumns'][$i]] = _('Actual Address');
				break;
		}
	}

	$smarty->assign('headings', $headings);

	/* Set the search order */
	if(isset($_GET['order']) && ($_GET['order'] == $_SESSION['systemqueuesOrder']) && in_array($_GET['order'], $_SESSION['preferences']['systemqueuesColumns'])) {
		if(isset($_SESSION['systemqueuesSort']) && ($_SESSION['systemqueuesSort'] == 'ASC')) $_SESSION['systemqueuesSort'] = 'DESC';
		else if(isset($_SESSION['systemqueuesSort']) && ($_SESSION['systemqueuesSort'] == 'DESC')) $_SESSION['systemqueuesSort'] = 'ASC';
		$_SESSION['systemqueues_page'] = 1;
	} else if(isset($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['systemqueuesColumns'])) {
		$_SESSION['systemqueuesSort'] = 'DESC';
		$_SESSION['systemqueuesOrder'] = $_GET['order'];
		$_SESSION['systemqueues_page'] = 1;
	}

	if(!isset($_SESSION['systemqueuesOrder'])) $_SESSION['systemqueuesOrder'] = $_SESSION['preferences']['systemqueuesColumns'][0];
	if(!isset($_SESSION['systemqueuesSort'])) $_SESSION['systemqueuesSort'] = 'ASC';

	$_SESSION['order'] = $_SESSION['systemqueuesOrder'];
	
	/* Build the query to get the relevant columns */
	$query = 'SELECT q.id, ';
	
	for($i = 0; $i < sizeof($_SESSION['preferences']['systemqueuesColumns']); $i++) {
		if($_SESSION['preferences']['systemqueuesColumns'][$i] == 'company') $query .= 'c.name AS company';
		else $query .= 'q.'.$_SESSION['preferences']['systemqueuesColumns'][$i];
		
		if(($i+1) != sizeof($_SESSION['preferences']['systemqueuesColumns'])) $query .= ', ';
	}

	$query .= ' FROM ticketqueue q, company c WHERE q.companyid=c.id';

	$query .= ' ORDER BY '.$_SESSION['systemqueuesOrder']. ' '.$_SESSION['systemqueuesSort'];

	/* Set up the pager and send the query */
	$egs->page($query, 'systemqueues_page');
	
	$smarty->assign('viewType', 'queue');
}	
?>
