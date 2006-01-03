<?php
if (in_array('admin', $_SESSION['modules'])) {
	/* If the page has not been set, set it */
	if(isset($_GET['page'])) $_SESSION['adminusers_page'] = max(1, intval($_GET['page']));
	if(!isset($_SESSION['adminusers_page'])) $_SESSION['adminusers_page'] = 1;

	/* Set the page title */
	$smarty->assign('pageTitle', _('Users'));
	$smarty->assign('pageNew', 'action=saveuser');
	
	/* If no default column ordering is set for the users, setup the default */
	//if(!isset($_SESSION['preferences']['adminusersColumns']) || !is_array($_SESSION['preferences']['adminusersColumns'])) {
		$_SESSION['preferences']['adminusersColumns'] = array();
		$_SESSION['preferences']['adminusersColumns'][] = 'username';
		$_SESSION['preferences']['adminusersColumns'][] = 'name';
		$_SESSION['preferences']['adminusersColumns'][] = 'superuser';
		$_SESSION['preferences']['adminusersColumns'][] = 'quota';
		$_SESSION['preferences']['adminusersColumns'][] = 'access';
		$_SESSION['preferences']['adminusersColumns'][] = 'reset';
	//}

	/* Array to hold the columns */
	$headings = array();

	/* Iterate over the columns and translate */
	for($i=0; $i < sizeof($_SESSION['preferences']['adminusersColumns']); $i++) {
		switch ($_SESSION['preferences']['adminusersColumns'][$i]) {
			case 'name':
				$headings[$_SESSION['preferences']['adminusersColumns'][$i]] = _('Name');
				break;
			case 'username':
				$headings[$_SESSION['preferences']['adminusersColumns'][$i]] = _('Username');
				break;
			case 'superuser':
				$headings[$_SESSION['preferences']['adminusersColumns'][$i]] = _('Superuser');
				break;
			case 'quota':
				$headings[$_SESSION['preferences']['adminusersColumns'][$i]] = _('Quota');
				break;
			case 'access':
				$headings[$_SESSION['preferences']['adminusersColumns'][$i]] = _('Login');
				break;
				case 'reset':
				$headings[$_SESSION['preferences']['adminusersColumns'][$i]] = '&nbsp;';
				break;
		}
	}

	$smarty->assign('headings', $headings);

	/* Set the search order */
	if(isset($_GET['order']) && ($_GET['order'] == $_SESSION['adminusersOrder']) && in_array($_GET['order'], $_SESSION['preferences']['adminusersColumns'])) {
		if(isset($_SESSION['adminusersSort']) && ($_SESSION['adminusersSort'] == 'ASC')) $_SESSION['adminusersSort'] = 'DESC';
		else if(isset($_SESSION['adminusersSort']) && ($_SESSION['adminusersSort'] == 'DESC')) $_SESSION['adminusersSort'] = 'ASC';
		$_SESSION['adminusers_page'] = 1;
	} else if(isset($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['adminusersColumns'])) {
		$_SESSION['adminusersSort'] = 'DESC';
		$_SESSION['adminusersOrder'] = $_GET['order'];
		$_SESSION['adminusers_page'] = 1;
	}

	if(!isset($_SESSION['adminusersOrder'])) $_SESSION['adminusersOrder'] = $_SESSION['preferences']['adminusersColumns'][0];
	if(!isset($_SESSION['adminusersSort'])) $_SESSION['adminusersSort'] = 'ASC';

	$_SESSION['order'] = $_SESSION['adminusersOrder'];
	
	/* Build the query to get the relevant columns */
	$query = 'SELECT p.owner, p.owner, ';
	
	for($i = 0; $i < sizeof($_SESSION['preferences']['adminusersColumns']); $i++) {
			
		if($_SESSION['preferences']['adminusersColumns'][$i] == 'name') $query .= 'p.firstname || \' \' || p.surname AS name';
		else if($_SESSION['preferences']['adminusersColumns'][$i] == 'superuser') $query .= 'CASE WHEN superuser THEN '.$db->qstr(_('Yes')).' ELSE '.$db->qstr(_('No')).' END AS superuser';
		else if($_SESSION['preferences']['adminusersColumns'][$i] == 'access') $query .= 'CASE WHEN access THEN '.$db->qstr(_('Yes')).' ELSE '.$db->qstr(_('No')).' END AS access';
		else if ($_SESSION['preferences']['adminusersColumns'][$i]!='reset') $query .= 'u.'.$_SESSION['preferences']['adminusersColumns'][$i];
		if(($i+1) != sizeof($_SESSION['preferences']['adminusersColumns'])) $query .= ', ';
	}
	$links[$i] = '&amp;module=admin&amp;action=newpass&amp;id=';
	$query .= '  '.$db->qstr(_('Reset Password')).' FROM useraccess u, person p ';

	$query.= 'WHERE p.owner=u.username AND p.userdetail AND u.companyid='.$db->qstr(EGS_COMPANY_ID);

	$query .= ' ORDER BY '.$_SESSION['adminusersOrder']. ' '.$_SESSION['adminusersSort'];

	/* Set up the pager and send the query */
	$egs->page($query, 'adminusers_page',$links);
	
	$smarty->assign('viewType', 'user');
}	
?>
