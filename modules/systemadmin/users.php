<?php
if (in_array('systemadmin', $_SESSION['modules'])) {
	/* If the page has not been set, set it */
	if(isset($_GET['page'])) $_SESSION['systemusers_page'] = max(1, intval($_GET['page']));
	if(!isset($_SESSION['systemusers_page'])) $_SESSION['systemusers_page'] = 1;

	/* Set the page title */
	$smarty->assign('pageTitle', _('Users'));
	
	/* If no default column ordering is set for the users, setup the default */
	if(!isset($_SESSION['preferences']['systemusersColumns']) || !is_array($_SESSION['preferences']['systemusersColumns'])) {
		$_SESSION['preferences']['systemusersColumns'] = array();
		$_SESSION['preferences']['systemusersColumns'][] = 'owner';
		$_SESSION['preferences']['systemusersColumns'][] = 'name';
		$_SESSION['preferences']['systemusersColumns'][] = 'crossassigned';
	}

	/* Array to hold the columns */
	$headings = array();

	/* Iterate over the columns and translate */
	for($i=0; $i < sizeof($_SESSION['preferences']['systemusersColumns']); $i++) {
		switch ($_SESSION['preferences']['systemusersColumns'][$i]) {
			case 'name':
				$headings[$_SESSION['preferences']['systemusersColumns'][$i]] = _('Name');
				break;
			case 'owner':
				$headings[$_SESSION['preferences']['systemusersColumns'][$i]] = _('Username');
				break;
			case 'crossassigned':
				$headings[$_SESSION['preferences']['systemusersColumns'][$i]] = _('Cross Assigned');
				break;
		}
	}

	$smarty->assign('headings', $headings);

	/* Set the search order */
	if(isset($_GET['order']) && ($_GET['order'] == $_SESSION['systemusersOrder']) && in_array($_GET['order'], $_SESSION['preferences']['systemusersColumns'])) {
		if(isset($_SESSION['systemusersSort']) && ($_SESSION['systemusersSort'] == 'ASC')) $_SESSION['systemusersSort'] = 'DESC';
		else if(isset($_SESSION['systemusersSort']) && ($_SESSION['systemusersSort'] == 'DESC')) $_SESSION['systemusersSort'] = 'ASC';
		$_SESSION['systemusers_page'] = 1;
	} else if(isset($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['systemusersColumns'])) {
		$_SESSION['systemusersSort'] = 'DESC';
		$_SESSION['systemusersOrder'] = $_GET['order'];
		$_SESSION['systemusers_page'] = 1;
	}

	if(!isset($_SESSION['systemusersOrder'])) $_SESSION['systemusersOrder'] = $_SESSION['preferences']['systemusersColumns'][0];
	if(!isset($_SESSION['systemusersSort'])) $_SESSION['systemusersSort'] = 'ASC';

	$_SESSION['order'] = $_SESSION['systemusersOrder'];
	
	/* Build the query to get the relevant columns */
	$query = 'SELECT p.owner, ';
	
	for($i = 0; $i < sizeof($_SESSION['preferences']['systemusersColumns']); $i++) {
			
		if($_SESSION['preferences']['systemusersColumns'][$i] == 'name') $query .= 'p.firstname || \' \' || p.surname AS name';
		else if($_SESSION['preferences']['systemusersColumns'][$i] == 'crossassigned') $query .= 'CASE WHEN count(username)=1 THEN '.$db->qstr(_('No')).' ELSE '.$db->qstr(_('Yes')).' END AS crossassigned ';
		else $query .= 'p.'.$_SESSION['preferences']['systemusersColumns'][$i];
		if(($i+1) != sizeof($_SESSION['preferences']['systemusersColumns'])) $query .= ', ';
	}

	$query .= ' FROM useraccess u, person p ';

	$query.= 'WHERE p.owner=u.username AND p.userdetail GROUP BY p.owner, p.firstname, p.surname ';

	$query .= ' ORDER BY '.$_SESSION['systemusersOrder']. ' '.$_SESSION['systemusersSort'];

	/* Set up the pager and send the query */
	$egs->page($query, 'systemusers_page');
	
	$smarty->assign('viewType', 'user');
}	
?>
