<?php

	/* If the page has not been set, set it */
	if(isset($_GET['page'])) $_SESSION['contact_page'] = max(1, intval($_GET['page']));
	if(!isset($_SESSION['contact_page'])) $_SESSION['contact_page'] = 1;

	/* Set the page title */
	$smarty->assign('pageTitle', _('Contacts: Contacts'));
	
	/* Setup the search box */
	$smarty->assign('searchTitle', _('Search Contacts'));

	/* Set the search type */
	if(isset($_GET['search']) && ($_GET['search'] == 'adv')) $_SESSION['contactSearchType'] = 'adv';
	else if(isset($_GET['search']) && ($_GET['search'] == 'norm')) $_SESSION['contactSearchType'] = 'norm';
	else if(!isset($_SESSION['contactSearchType'])) $_SESSION['contactSearchType'] = 'norm';

	$smarty->assign('searchForm', $_SESSION['contactSearchType']);
	
	$search = array();
	
	$search['a.firstname'] = array('name' =>_('First Name'), 'type' => 'text');
	$search['a.surname'] = array('name' =>_('Surname'), 'type' => 'text');

	if($_SESSION['contactSearchType'] == 'adv') {
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

	$search['a.owner'] = array('name' =>_('Contact Owner'), 'type' => 'select', 'values' => $users);
	$search['a.assigned'] = array('name' =>_('Contact Assigned To'), 'type' => 'select', 'values' => $users);

	$smarty->assign('search', $search);
	
	/* If no default column ordering is set for the person, setup the default */
	if(!isset($_SESSION['preferences']['contactColumns']) || !is_array($_SESSION['preferences']['contactColumns'])) {
		$_SESSION['preferences']['contactColumns'] = array();
		$_SESSION['preferences']['contactColumns'][] = 'name';
		$_SESSION['preferences']['contactColumns'][] = 'town';
		$_SESSION['preferences']['contactColumns'][] = 'email';
		$_SESSION['preferences']['contactColumns'][] = 'phone';
	}

	/* Array to hold the columns */
	$headings = array();

	/* Iterate over the columns and translate */
	for($i=0; $i < sizeof($_SESSION['preferences']['contactColumns']); $i++) {
		switch ($_SESSION['preferences']['contactColumns'][$i]) {
			case 'company':
				$headings[$_SESSION['preferences']['contactColumns'][$i]] = _('Account');
				break;
			case 'name':
				$headings[$_SESSION['preferences']['contactColumns'][$i]] = _('Name');
				break;
			case 'address':
				$headings[$_SESSION['preferences']['contactColumns'][$i]] = _('Address');
				break;
			case 'town':
				$headings[$_SESSION['preferences']['contactColumns'][$i]] = _('Town');
				break;
			case 'jobtitle':
				$headings[$_SESSION['preferences']['contactColumns'][$i]] = _('Job Title');
				break;
			case 'department':
				$headings[$_SESSION['preferences']['contactColumns'][$i]] = _('Department');
				break;
			case 'mobile':
				$headings[$_SESSION['preferences']['contactColumns'][$i]] = _('Mobile');
				break;
			case 'phone':
				$headings[$_SESSION['preferences']['contactColumns'][$i]] = _('Phone Number');
				break;
			case 'fax':
				$headings[$_SESSION['preferences']['contactColumns'][$i]] = _('Fax');
				break;
			case 'email':
				$headings[$_SESSION['preferences']['contactColumns'][$i]] = _('Email');
				break;
			case 'owner':
				$headings[$_SESSION['preferences']['contactColumns'][$i]] = _('Owner');
				break;
			case 'assigned':
				$headings[$_SESSION['preferences']['contactColumns'][$i]] = _('Assigned');
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
				require_once(EGS_FILE_ROOT.'/src/classes/class.person.php');

				$person = new person();

				$person->deleteContact(intval($val));
			}

			$smarty->assign('messages', array(_('Companies deleted')));
		}

		$save = false;
		
		if(!isset($_SESSION['contactSearch']) || ($_SESSION['contactSearch'] == '') || isset($_POST['clearsearch'])) {
			if(isset($_SESSION['preferences']['contactSearch'])) $_SESSION['contactSearch'] = $_SESSION['preferences']['contactSearch'];
			else unset($_SESSION['contactSearch']);	
		}
		
		/* If Saving, set to search then save */
		if(isset($_POST['savesearch'])) {
			unset($_POST['savesearch']);
			$_SESSION['preferences']['contactSearch'] = $_POST;
			$_SESSION['contactSearch'] = $_POST;
			$egs->syncPreferences();
		}
		
		/* We are searching */
		if(isset($_POST['search'])) {
			unset($_POST['search']);
			$_SESSION['contactSearch'] = $_POST;
			$_SESSION['contact_page'] = 1;
		}
	}
	else if(!isset($_SESSION['contactSearch']) && isset($_SESSION['preferences']['contactSearch'])) $_SESSION['contactSearch'] = $_SESSION['preferences']['contactSearch'];

	/* Set the search order */
	
	if(isset($_SESSION['contactOrder'])&&$_SESSION['contactOrder']=='street1')
		$_SESSION['contactOrder']='address';
	if(isset($_GET['order']) && ($_GET['order'] == $_SESSION['contactOrder']) && in_array($_GET['order'], $_SESSION['preferences']['contactColumns'])) {
		if(isset($_SESSION['contactSort']) && ($_SESSION['contactSort'] == 'ASC')) $_SESSION['contactSort'] = 'DESC';
		else if(isset($_SESSION['contactSort']) && ($_SESSION['contactSort'] == 'DESC')) $_SESSION['contactSort'] = 'ASC';
		$_SESSION['contact_page'] = 1;
	} else if(isset($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['contactColumns'])) {
		$_SESSION['contactSort'] = 'DESC';
		$_SESSION['contactOrder'] = $_GET['order'];
		$_SESSION['contact_page'] = 1;
	}
	
	if(!isset($_SESSION['contactOrder'])) $_SESSION['contactOrder'] = $_SESSION['preferences']['contactColumns'][0];
	if(!isset($_SESSION['contactSort'])) $_SESSION['contactSort'] = 'ASC';
	if($_SESSION['contactOrder']=='address')$_SESSION['contactOrder']='street1';
	$_SESSION['order'] = $_SESSION['contactOrder'];
	
	/* Build the query to get the relevant columns */
	$query = 'SELECT DISTINCT ';
	if(in_array('company',$_SESSION['preferences']['contactColumns'])) $query.='a.companyid, ';

	$query.='a.id, ';
	$category = false;

	$links = array();
	if(isset($_SESSION['contactSearch']) && array_key_exists('c_typeid', $_SESSION['contactSearch'])) $category = true;

	for($i = 0; $i < sizeof($_SESSION['preferences']['contactColumns']); $i++) {
		if ($_SESSION['preferences']['contactColumns'][$i] == 'company') {
			$links[$i+1] = '&amp;module=contacts&amp;action=view&amp;id=';
		}
		if($_SESSION['preferences']['contactColumns'][$i] == 'name')
			$query .= 'firstname || \' \' || surname AS name';
		else if($_SESSION['preferences']['contactColumns'][$i] == 'address')
			$query .= 'street1 || \', \' || street2 || \', \' || street3 || \', \' || town || \', \' || county || \', \' || postcode';
		else
			$query .= 'a.'.$_SESSION['preferences']['contactColumns'][$i];
		if(($i+1) != sizeof($_SESSION['preferences']['contactColumns'])) $query .= ', ';
	}

	$query .= ' FROM personoverview a, personaccess ca ';

	if($category) $query .= ', persontypexref c ';

	$query.= 'WHERE a.id=ca.personid AND ca.usercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND ca.username='.$db->qstr(EGS_USERNAME);
	
	if(isset($_SESSION['contactSearch']) && (sizeof($_SESSION['contactSearch']) > 0)) {	
		$searchString = $egs->searchString($_SESSION['contactSearch']);
		
		if(($searchString != '') && ($category)) $query .= ' AND c.personid=a.id AND '.$searchString;
		else if($searchString != '') $query .= ' AND '.$searchString;
		
		$_SESSION['search'] = $_SESSION['contactSearch'];
	}
	else if(isset($_SESSION['search'])) unset($_SESSION['search']);

	$query .= ' ORDER BY ';

	if($_SESSION['contactOrder'] != 'name') $query .= 'a.';
	
	if($_SESSION['contactOrder']=='street1')$_SESSION['contactOrder']='street1 || \', \' || street2 || \', \' || street3 || \', \' || town || \', \' || county || \', \' || postcode';
	$query .= $_SESSION['contactOrder']. ' '.$_SESSION['contactSort'];
	if($_SESSION['contactOrder']=='street1 || \', \' || street2 || \', \' || street3 || \', \' || town || \', \' || county || \', \' || postcode')
	$_SESSION['contactOrder']='street1';
	
	$smarty->assign('viewType', 'person');

	/* Set up the pager and send the query */
	$egs->page($query, 'contact_page', $links);	
?>
