<?php
	/* If the page has not been set, set it */
	if(isset($_GET['page'])) $_SESSION['chooseaticketqueue_page'] = max(1, intval($_GET['page']));
	if(!isset($_SESSION['chooseaticketqueue_page'])) $_SESSION['chooseaticketqueue_page'] = 1;

	/* Set the page title */
	$smarty->assign('pageTitle', _('Ticket Queues'));
	
	/* If no default column ordering is set for the ticketqueues, setup the default */
	if(!isset($_SESSION['preferences']['chooseaticketqueueColumns']) || !is_array($_SESSION['preferences']['chooseaticketqueueColumns'])) {
		$_SESSION['preferences']['chooseaticketqueueColumns'] = array();
		$_SESSION['preferences']['chooseaticketqueueColumns'][] = 'name';
		$_SESSION['preferences']['chooseaticketqueueColumns'][] = 'actualaddress';
	}

	/* Array to hold the columns */
	$headings = array();

	/* Iterate over the columns and translate */
	for($i=0; $i < sizeof($_SESSION['preferences']['chooseaticketqueueColumns']); $i++) {
		switch ($_SESSION['preferences']['chooseaticketqueueColumns'][$i]) {
			case 'name':
				$headings[$_SESSION['preferences']['chooseaticketqueueColumns'][$i]] = _('Name');
				break;
			case 'actualaddress':
				$headings[$_SESSION['preferences']['chooseaticketqueueColumns'][$i]] = _('Email Address');
				break;
		}
	}

	$smarty->assign('headings', $headings);

	/* Set the search order */
	if(isset($_GET['order']) && ($_GET['order'] == $_SESSION['chooseaticketqueueOrder']) && in_array($_GET['order'], $_SESSION['preferences']['chooseaticketqueueColumns'])) {
		if(isset($_SESSION['chooseaticketqueueSort']) && ($_SESSION['chooseaticketqueueSort'] == 'ASC')) $_SESSION['chooseaticketqueueSort'] = 'DESC';
		else if(isset($_SESSION['chooseaticketqueueSort']) && ($_SESSION['chooseaticketqueueSort'] == 'DESC')) $_SESSION['chooseaticketqueueSort'] = 'ASC';
		$_SESSION['chooseaticketqueue_page'] = 1;
	} else if(isset($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['chooseaticketqueueColumns'])) {
		$_SESSION['chooseaticketqueueSort'] = 'DESC';
		$_SESSION['chooseaticketqueueOrder'] = $_GET['order'];
		$_SESSION['chooseaticketqueue_page'] = 1;
	}

	if(!isset($_SESSION['chooseaticketqueueOrder'])) $_SESSION['chooseaticketqueueOrder'] = $_SESSION['preferences']['chooseaticketqueueColumns'][0];
	if(!isset($_SESSION['chooseaticketqueueSort'])) $_SESSION['chooseaticketqueueSort'] = 'ASC';

	$_SESSION['order'] = $_SESSION['chooseaticketqueueOrder'];
	
	/* Build the query to get the relevant columns */
	$query = 'SELECT t.id, \'\' AS holder, ';

	$links = array();
	
	for($i = 0; $i < sizeof($_SESSION['preferences']['chooseaticketqueueColumns']); $i++) {
		$query .= 't.'.$_SESSION['preferences']['chooseaticketqueueColumns'][$i];
		if(($i+1) != sizeof($_SESSION['preferences']['chooseaticketqueueColumns'])) $query .= ', ';
	}

	$query .= ' FROM ticketqueue t, queueaccess a WHERE t.companyid='.$db->qstr(EGS_COMPANY_ID).' AND t.id=a.queueid AND a.username='.$db->qstr(EGS_USERNAME);


	$query .= ' ORDER BY t.'.$_SESSION['chooseaticketqueueOrder']. ' '.$_SESSION['chooseaticketqueueSort'];

	/* Set up the pager and send the query */
	$egs->page($query, 'chooseaticketqueue_page', $links);	
?>
