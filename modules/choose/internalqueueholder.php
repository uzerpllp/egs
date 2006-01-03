<?php
	/* If the page has not been set, set it */
	if(isset($_GET['page'])) $_SESSION['chooseinternalqueuequeue_page'] = max(1, intval($_GET['page']));
	if(!isset($_SESSION['chooseinternalqueuequeue_page'])) $_SESSION['chooseinternalqueuequeue_page'] = 1;

	/* Set the page title */
	$smarty->assign('pageTitle', _('Internal Ticket Queues'));
	
	/* If no default column ordering is set for the ticketqueues, setup the default */
	if(!isset($_SESSION['preferences']['chooseinternalqueuequeueColumns']) || !is_array($_SESSION['preferences']['chooseinternalqueuequeueColumns'])) {
		$_SESSION['preferences']['chooseinternalqueuequeueColumns'] = array();
		$_SESSION['preferences']['chooseinternalqueuequeueColumns'][] = 'name';
		$_SESSION['preferences']['chooseinternalqueuequeueColumns'][] = 'queue';
		$_SESSION['preferences']['chooseinternalqueuequeueColumns'][] = 'actualaddress';
	}

	/* Array to hold the columns */
	$headings = array();

	/* Iterate over the columns and translate */
	for($i=0; $i < sizeof($_SESSION['preferences']['chooseinternalqueuequeueColumns']); $i++) {
		switch ($_SESSION['preferences']['chooseinternalqueuequeueColumns'][$i]) {
			case 'name':
				$headings[$_SESSION['preferences']['chooseinternalqueuequeueColumns'][$i]] = _('Internal Queue Name');
				break;
			case 'queue':
				$headings[$_SESSION['preferences']['chooseinternalqueuequeueColumns'][$i]] = _('Queue Name');
				break;
			case 'actualaddress':
				$headings[$_SESSION['preferences']['chooseinternalqueuequeueColumns'][$i]] = _('Email Address');
				break;
		}
	}

	$smarty->assign('headings', $headings);

	/* Set the search order */
	if(isset($_GET['order']) && ($_GET['order'] == $_SESSION['chooseinternalqueuequeueOrder']) && in_array($_GET['order'], $_SESSION['preferences']['chooseinternalqueuequeueColumns'])) {
		if(isset($_SESSION['chooseinternalqueuequeueSort']) && ($_SESSION['chooseinternalqueuequeueSort'] == 'ASC')) $_SESSION['chooseinternalqueuequeueSort'] = 'DESC';
		else if(isset($_SESSION['chooseinternalqueuequeueSort']) && ($_SESSION['chooseinternalqueuequeueSort'] == 'DESC')) $_SESSION['chooseinternalqueuequeueSort'] = 'ASC';
		$_SESSION['chooseinternalqueuequeue_page'] = 1;
	} else if(isset($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['chooseinternalqueuequeueColumns'])) {
		$_SESSION['chooseinternalqueuequeueSort'] = 'DESC';
		$_SESSION['chooseinternalqueuequeueOrder'] = $_GET['order'];
		$_SESSION['chooseinternalqueuequeue_page'] = 1;
	}

	if(!isset($_SESSION['chooseinternalqueuequeueOrder'])) $_SESSION['chooseinternalqueuequeueOrder'] = $_SESSION['preferences']['chooseinternalqueuequeueColumns'][0];
	if(!isset($_SESSION['chooseinternalqueuequeueSort'])) $_SESSION['chooseinternalqueuequeueSort'] = 'ASC';

	$_SESSION['order'] = $_SESSION['chooseinternalqueuequeueOrder'];
	
	/* Build the query to get the relevant columns */
	$query = 'SELECT i.id, t.id AS holder, i.name, t.name as queue, t.actualaddress';

	$links = array();

	$query .= ' FROM ticketqueue t, internalqueue i, queueaccess a WHERE i.queueid=t.id AND t.companyid='.$db->qstr(EGS_COMPANY_ID).' AND t.id=a.queueid AND a.username='.$db->qstr(EGS_USERNAME);


	$query .= ' ORDER BY i.'.$_SESSION['chooseinternalqueuequeueOrder']. ' '.$_SESSION['chooseinternalqueuequeueSort'];

	/* Set up the pager and send the query */
	$egs->page($query, 'chooseinternalqueuequeue_page', $links);	
?>
