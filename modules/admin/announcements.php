<?php
if (in_array('admin', $_SESSION['modules'])) {
	/* If the page has not been set, set it */
	if(isset($_GET['page'])) $_SESSION['adminnews_page'] = max(1, intval($_GET['page']));
	if(!isset($_SESSION['adminnews_page'])) $_SESSION['adminnews_page'] = 1;

	/* Set the page title */
	if($_GET['action'] == 'announcements') $smarty->assign('pageTitle', _('Annoucements'));
	else $smarty->assign('pageTitle', _('News'));
	
	/* Set the new button */
	if($_GET['action'] == 'announcements') $smarty->assign('pageNew', 'action=viewannouncements');
	else $smarty->assign('pageNew', 'action=viewnews');
	
	/* If no default column ordering is set for the news, setup the default */
	if(!isset($_SESSION['preferences']['adminnewsColumns']) || !is_array($_SESSION['preferences']['adminnewsColumns'])) {
		$_SESSION['preferences']['adminnewsColumns'] = array();
		$_SESSION['preferences']['adminnewsColumns'][] = 'headline';
		$_SESSION['preferences']['adminnewsColumns'][] = 'published';
		$_SESSION['preferences']['adminnewsColumns'][] = 'showfrom';
		$_SESSION['preferences']['adminnewsColumns'][] = 'showuntil';
		$_SESSION['preferences']['adminnewsColumns'][] = 'visible';
	}

	/* Array to hold the columns */
	$headings = array();

	/* Iterate over the columns and translate */
	for($i=0; $i < sizeof($_SESSION['preferences']['adminnewsColumns']); $i++) {
		switch ($_SESSION['preferences']['adminnewsColumns'][$i]) {
			case 'headline':
				$headings[$_SESSION['preferences']['adminnewsColumns'][$i]] = _('Headline');
				break;
			case 'showfrom':
				$headings[$_SESSION['preferences']['adminnewsColumns'][$i]] = _('Show From');
				break;
			case 'showuntil':
				$headings[$_SESSION['preferences']['adminnewsColumns'][$i]] = _('Show Until');
				break;
			case 'published':
				$headings[$_SESSION['preferences']['adminnewsColumns'][$i]] = _('Published');
				break;
			case 'visible':
				$headings[$_SESSION['preferences']['adminnewsColumns'][$i]] = _('Visible');
				break;
		}
	}

	$smarty->assign('headings', $headings);

	/* Set the search order */
	if(isset($_GET['order']) && ($_GET['order'] == $_SESSION['adminnewsOrder']) && in_array($_GET['order'], $_SESSION['preferences']['adminnewsColumns'])) {
		if(isset($_SESSION['adminnewsSort']) && ($_SESSION['adminnewsSort'] == 'ASC')) $_SESSION['adminnewsSort'] = 'DESC';
		else if(isset($_SESSION['adminnewsSort']) && ($_SESSION['adminnewsSort'] == 'DESC')) $_SESSION['adminnewsSort'] = 'ASC';
		$_SESSION['adminnews_page'] = 1;
	} else if(isset($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['adminnewsColumns'])) {
		$_SESSION['adminnewsSort'] = 'DESC';
		$_SESSION['adminnewsOrder'] = $_GET['order'];
		$_SESSION['adminnews_page'] = 1;
	}

	if(!isset($_SESSION['adminnewsOrder'])) $_SESSION['adminnewsOrder'] = 'published';
	if(!isset($_SESSION['adminnewsSort'])) $_SESSION['adminnewsSort'] = 'ASC';

	$_SESSION['order'] = $_SESSION['adminnewsOrder'];
	
	/* Build the query to get the relevant columns */
	$query = 'SELECT id, ';
	
	for($i = 0; $i < sizeof($_SESSION['preferences']['adminnewsColumns']); $i++) {
			
		if(($_SESSION['preferences']['adminnewsColumns'][$i] == 'showfrom') || ($_SESSION['preferences']['adminnewsColumns'][$i] == 'showuntil') || ($_SESSION['preferences']['adminnewsColumns'][$i] == 'published')) $query .= $db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), $_SESSION['preferences']['adminnewsColumns'][$i]).' AS '.$_SESSION['preferences']['adminnewsColumns'][$i];
		else if($_SESSION['preferences']['adminnewsColumns'][$i] == 'visible') $query .= 'CASE WHEN visible THEN '.$db->qstr(_('Yes')).' ELSE '.$db->qstr(_('No')).' END AS visible';
		else $query .= $_SESSION['preferences']['adminnewsColumns'][$i];
		if(($i+1) != sizeof($_SESSION['preferences']['adminnewsColumns'])) $query .= ', ';
	}

	$query .= ' FROM news ';

	$query.= 'WHERE domainid IS NULL AND motd<>true AND companyid='.$db->qstr(EGS_COMPANY_ID);
	
	if($_GET['action'] == 'announcements') $query .= ' AND news=false';

	$query .= ' ORDER BY '.$_SESSION['adminnewsOrder']. ' '.$_SESSION['adminnewsSort'];
	
	/* Set up the pager and send the query */
	$egs->page($query, 'adminnews_page');
	
	if($_GET['action'] == 'announcements') $smarty->assign('viewType', 'announcements');
	else $smarty->assign('viewType', 'news');
}	
?>
