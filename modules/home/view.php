<?php
// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - View Account 1.0                 |
// +----------------------------------------------------------------------+
// | Copyright (c) 2002-2005 Jake Stride                                  |
// +----------------------------------------------------------------------+
// | This file is part of EGS.                                            |
// |                                                                      |
// | EGS is free software; you can redistribute it and/or modify it under |
// | the terms of the GNU General Public License as published by the Free |
// | Software Foundation; either version 2 of the License, or (at your    |
// | option) any later version.                                           |
// |                                                                      |
// | EGS is distributed in the hope that it will be useful, but WITHOUT   |
// | ANY WARRANTY; without even the implied warranty of MERCHANTABILITY   |
// | or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public     |
// | License for more details.                                            |
// |                                                                      |
// | You should have received a copy of the GNU General Public License    |
// | along with EGS; if not, write to the Free Software Foundation, Inc., |
// | 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA               |
// +----------------------------------------------------------------------+
// | Author: Jake Stride <jake.stride@senokian.com>                       |
// +----------------------------------------------------------------------+
// | 1.0                                                                  |
// | ===                                                                  |
// | First Stable Release                                                 |
// +----------------------------------------------------------------------+
/*IMPORTANT!!!
 * This File is both home/view.php and contacts/view.php
 */
/* Check user has access to this module */
if (isset ($_SESSION['modules']) && (in_array('contacts', $_SESSION['modules']) || in_array('home', $_SESSION['modules']))) {
	/* Include the company class, and initialise */
	require_once (EGS_FILE_ROOT.'/src/classes/class.company.php');
	$company = new company();

	//Is this too messy-->?
	if (isset ($_GET['id'])) {
		$explode = explode("/", $_GET['id']);
		$_GET['id'] = $explode[0];
	}
	//<--?

	/* Set the id to the user if in the home module */
	if ($_GET['module'] != 'contacts')
		$_GET['id'] = EGS_COMPANY_ID;

	/* Grab the access level for this company:
	 * 1 is restricted read
	 * 2 is read
	 * 3 is write
	 * 4 is full write
	 */
	$accessLevel = $company->accessLevel($_GET['id']);

	/* Set the view type */
	if (isset ($_GET['type']))
		$_SESSION['preferences']['contactsView'] = $_GET['type'];

	/* This is set to false if something is successfully saved */
	$saved = false;

	/* If the access level is correct and the correct variables set then update the logo */
	if ((sizeof($_POST) > 0) && ($accessLevel > 2) && (isset ($_GET['editdone']) && ($_GET['editdone'] == 'logo'))) {
		$company->updateLogo($_GET['id']);
	} else
		/* Update the contacts if correct access */
		if ((sizeof($_POST) > 0) && ($accessLevel > 3) && isset ($_POST['type'])) {
			if ($_SESSION['preferences']['contactsView'] == 'address')
				$company->updateAddress($_POST);
			else
				$company->updateContacts($_POST);
		} else
			/* Update the categories if correct access */
			if ((sizeof($_POST) > 0) && ($accessLevel > 2) && ($_GET['module'] != 'home')) {
				$company->updateCategories($_POST['values'], $_GET['id']);
			}

	/* If the access level is valid to view the company then we can display it */
	if ($accessLevel >= 0) {
		/* Get the parent company id, this is useful if the company is a branch */
		$parentId = $company->parentId($_GET['id']);

		/* Get the company details from the database */
		$query = 'SELECT *, '.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 'added').' AS added, '.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 'updated').' AS updated FROM companyoverview WHERE id='.$db->qstr(intval($_GET['id']));
		$companyDetails = $db->GetRow($query);

		/* Now actuall do the display if the results were successfully retrieved */
		if ($companyDetails !== false) {
			/* Add to last viewed and sync the preferences */
			$_SESSION['preferences']['lastViewed'] = array_slice(array_merge(array ('module=contacts&amp;action=view&amp;id='.intval($_GET['id']) => array ('company', $companyDetails['name'])), $_SESSION['preferences']['lastViewed']), 0, EGS_RECENTLY_VIEWED);
			$egs->syncPreferences();

			/* Set the title to the company name */
			$smarty->assign('pageTitle', $companyDetails['name']);

			/* If the user has write access then add the edit button */
			if ($accessLevel > 2 && $_GET['module'] != 'home') {
				$smarty->assign('pageEdit', 'action=saveaccount&amp;id='.intval($_GET['id']));
				if ($_GET['module'] != 'home')
					$smarty->assign('pageUpdateAccess', 'action=saveaccountaccess&amp;id='.intval($_GET['id']));
			}

			/* Output the company details */
			$leftData = array ();
			$leftData[] = array ('tag' => _('Company Name'), 'data' => $companyDetails['name']);
			$leftData[] = array ('tag' => _('Phone'), 'data' => $companyDetails['phone']);
			$leftData[] = array ('tag' => _('Fax'), 'data' => $companyDetails['fax']);
			$leftData[] = array ('tag' => _('Email'), 'data' => $companyDetails['email'], 'link' => 'mailto:'.$companyDetails['email']);
			$leftData[] = array ('tag' => _('Website'), 'data' => $companyDetails['www'], 'link' => 'http://'.str_replace('http://', '', $companyDetails['www']));
			$leftData[] = array ('span' => true);

			/* Format the address according to the users settings */
			$formattedAddress = $egs->formatAddress($companyDetails);

			/* And output it */
			$leftData[] = array ('tag' => _('Address'), 'data' => $formattedAddress, 'rowspan' => 4);
			$leftData[] = array ('tag' => '', 'data' => '');
			$leftData[] = array ('tag' => '', 'data' => '');
			$leftData[] = array ('tag' => '', 'data' => '');

			/* Do the company owner/assigned details */
			$leftData[] = array ('tag' => _('Owner'), 'data' => $companyDetails['owner']);
			$leftData[] = array ('tag' => _('Assigned To'), 'data' => $companyDetails['assigned']);
			$leftData[] = array ('tag' => _('Added'), 'data' => $companyDetails['added'].' '._('by').' '.$companyDetails['owner']);
			$leftData[] = array ('tag' => _('Last Updated'), 'data' => $companyDetails['updated'].' '._('by').' '.$companyDetails['alteredby']);

			/* If the crm module is enabled then get the details */
			if (isset ($_SESSION['modules']) && (in_array('crm', $_SESSION['modules']))) {
				$query = 'SELECT * FROM companycrmoverview WHERE companyid='.$db->qstr(intval($_GET['id'])).' AND usercompanyid='.$db->qstr(EGS_COMPANY_ID);

				$crmDetails = $db->GetRow($query);

				$companyDetails = array_merge($companyDetails, $crmDetails);
			}

			/* Do the CRM details */
			$rightData = array ();
			$rightData[] = array ('tag' => _('Account Num'), 'data' => $companyDetails['accountnumber']);
			$rightData[] = array ('tag' => _('Company Num'), 'data' => $companyDetails['companynumber']);
			$rightData[] = array ('tag' => _('VAT Num'), 'data' => $companyDetails['vatnumber']);
			if (isset ($companyDetails['siccode']))
				$rightData[] = array ('tag' => _('SIC Code'), 'data' => $companyDetails['siccode']);
			if (isset ($companyDetails['stocksymbol']))
				$rightData[] = array ('tag' => _('Stock Symbol'), 'data' => $companyDetails['stocksymbol']);
			$rightData[] = array ('span' => true);
			if (isset ($companyDetails['revenue']))
				$rightData[] = array ('tag' => _('Revenue'), 'data' => $companyDetails['revenue']);
			if (isset ($companyDetails['status']))
				$rightData[] = array ('tag' => _('Status'), 'data' => $companyDetails['status']);
			if (isset ($companyDetails['rating']))
				$rightData[] = array ('tag' => _('Rating'), 'data' => $companyDetails['rating']);
			if (isset ($companyDetails['source']))
				$rightData[] = array ('tag' => _('Source'), 'data' => $companyDetails['source']);
			if (isset ($companyDetails['industry']))
				$rightData[] = array ('tag' => _('Industry'), 'data' => $companyDetails['industry']);
			if (isset ($companyDetails['employees']))
				$rightData[] = array ('tag' => _('Employees'), 'data' => $employees[$companyDetails['employees']]);
			if (isset ($companyDetails['companytype']))
				$rightData[] = array ('tag' => _('Company Type'), 'data' => $companyTypes[$companyDetails['companytype']]);

			$rightSpan = array ();

			/* User has requested to upload a new logo so show the form */
			if (isset ($_GET['edit']) && ($_GET['edit'] == 'logo') && !$saved && ($accessLevel > 3)) {
				$files = array ('type' => 'file', 'title' => _('Update Logo'), 'save' => 'action=view&amp;id='.intval($_GET['id']), 'delete' => false, 'hidenotes' => true);
				$rightSpan[] = $files;
				/* Just the normal view box for the files */
			} else {
				/* If the user does not have write access then show the logo without edit link */
				if ($accessLevel < 4)
					$rightSpan[] = array ('type' => 'image', 'id' => $_GET['id'], 'show' => 'companylogo');
				/* Else show the logo with edit link */
				else
					$rightSpan[] = array ('type' => 'image', 'id' => $_GET['id'], 'editlink' => '&amp;edit=logo', 'show' => 'companylogo');
			}

			if ($_GET['module'] != 'home') {
				/* Get the queries the account is assigned to */
				$query = 'SELECT c.id, c.name FROM contactcategories c, companytypexref r WHERE c.id=r.typeid AND r.companyid='.$db->qstr(intval($_GET['id'])).' AND c.companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY c.name';

				$rs = $db->Execute($query);

				/* Show the save link if we are editing and the access is correct */
				if (($accessLevel > 1) && isset ($_GET['edit']) && ($_GET['edit'] == 'categories'))
					$categories = array ('type' => 'data', 'title' => _('Categories'), 'save' => 'action=view&amp;id='.intval($_GET['id']));
				else
					/* If the access level is correct show the edit link */
					if ($accessLevel > 1)
						$categories = array ('type' => 'data', 'title' => _('Categories'), 'edit' => 'action=view&amp;edit=categories&amp;id='.intval($_GET['id']));
				/* Just show the title */
				else
					$categories = array ('type' => 'data', 'title' => _('Categories'));

				/* Iterate over the categories and output them */
				while (!$rs->EOF) {
					$categories['data'][$rs->fields['id']] = $rs->fields['name'];
					$categories['selected'][] = $rs->fields['id'];

					$rs->MoveNext();
				}

				/* If we are editing with the correct access then grab the existing categories so we can select them */
				if (($accessLevel > 1) && isset ($_GET['edit']) && ($_GET['edit'] == 'categories')) {
					$query = 'SELECT id, name FROM contactcategories c WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY name';

					$rs = $db->Execute($query);

					while (!$rs->EOF) {
						$categories['values'][$rs->fields['id']] = $rs->fields['name'];
						$rs->MoveNext();
					}
				}

				$categories['icon'] = 'categories';
				$rightSpan[] = $categories;

				/* Get the company notes */
				$query = 'SELECT id, note, '.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 'date').' AS date, '.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 'updated').' AS updated, owner, alteredby FROM companynotes WHERE companyid='.$db->qstr(intval($_GET['id'])).' AND ownercompanyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY date';

				$rs = $db->Execute($query);

				/* If we are editing who the new button */
				if ($accessLevel > 2)
					$notes = array ('type' => 'data', 'title' => _('Notes'), 'new' => 'action=savenote&amp;companyid='.intval($_GET['id']));
				/* Just show the title */
				else
					$notes = array ('type' => 'data', 'title' => _('Notes'));

				/* Iterate over the notes */
				while (!$rs->EOF) {
					$notes['data'][] = nl2br($rs->fields['note']);
					$extra = _('Added by').' '.$rs->fields['owner'].' '._('on').' '.$rs->fields['date'];
					if ($rs->fields['alteredby'] != '')
						$extra .= '<br />'._('Last updated by').' '.$rs->fields['alteredby'].' '._('on').' '.$rs->fields['updated'];

					$notes['extra'][] = $extra;

					/* Show the edit link if the permissions are correct */
					if ($accessLevel > 2)
						$notes['link'][] = 'action=savenote&amp;companyid='.$_GET['id'].'&amp;noteid='.$rs->fields['id'];

					$rs->MoveNext();
				}

				$notes['icon'] = 'notes';
				$rightSpan[] = $notes;

				/* Show the open tickets assigned to the contact */
				if (($accessLevel > 1) && (isset ($_SESSION['modules']) && (in_array('ticketing', $_SESSION['modules'])))) {
					$query = 'SELECT id, queueid, subject FROM ticket WHERE companyid='.$db->qstr($_GET['id']).' AND (private=\'false\' OR (private AND owner='.$db->qstr(EGS_USERNAME).')) AND (internalstatus <> \'CLO\' AND status <> \'CLO\' AND internalstatus <> \'DEL\' AND status <> \'DEL\' ) ORDER BY id ASC';

					$rs = $db->Execute($query);

					$tickets = array ('type' => 'data', 'title' => _('Open Tickets'));

					while (!$rs->EOF) {
						$tickets['data'][] = $rs->fields['subject'];
						$tickets['start'][] = '['.$rs->fields['queueid'].'-'.$rs->fields['id'].']';
						$tickets['link'][] = 'module=ticketing&amp;action=view&amp;id='.$rs->fields['id'];
						$rs->MoveNext();
					}

					$tickets['icon'] = 'tickets';
					$rightSpan[] = $tickets;
				}

				/* Show the open projects assigned to the contact */
				if (($accessLevel > 1) && (isset ($_SESSION['modules']) && (in_array('projects', $_SESSION['modules'])))) {
					$query = 'SELECT p.id,
							         p.jobno,
							         p.name
							  FROM   project p,
							         projectaccess a
							  WHERE  p.id = a.projectid
							  AND    p.companyid = ?
							  AND a.companyid = ?
							  AND a.username = ?
							  AND archived = ?
							  ORDER BY p.jobno ASC';

					$rs = $db->Execute(
						$query,
						array(
							$_GET['id'],
							EGS_COMPANY_ID,
							EGS_USERNAME,
							'false'
						)
					);

					if ($accessLevel > 2)
						$projects = array ('type' => 'data', 'title' => _('Current Projects'));

					while (!$rs->EOF) {
						$projects['data'][] = $rs->fields['name'];
						$projects['start'][] = $rs->fields['jobno'];
						$projects['link'][] = 'module=projects&amp;action=view&amp;id='.$rs->fields['id'];
						$rs->MoveNext();
					}

					$projects['icon'] = 'projects';
					$rightSpan[] = $projects;
				}
			}
			if ($_GET['module'] != 'home') {
				/* Get the people assigned to the company */
				$query = 'SELECT id, firstname || \' \' || surname AS name, phone, mobile, email FROM personoverview WHERE companyid='.$db->qstr(intval($_GET['id'])).' ORDER BY name';

				$rs = $db->Execute($query);

				/* Show new link if correct access */
				if ($accessLevel > 2)
					$people = array ('type' => 'data', 'title' => _('People'), 'header' => array (_('Name'), _('Phone'), _('Mobile'), _('Email')), 'viewlink' => 'action=viewperson&amp;id=', 'newlink' => 'action=saveperson&amp;companyid='.intval($_GET['id']));
				/* Just show the title */
				else
					$people = array ('type' => 'data', 'title' => _('People'), 'header' => array (_('Name'), _('Phone'), _('Mobile'), _('Email')), 'viewlink' => 'action=viewperson&amp;id=');

				/* Iterate over and show the people */
				while (!$rs->EOF) {
					$people['data'][] = $rs->fields;
					$rs->MoveNext();
				}

				$people['icon'] = 'person';
				$bottomData[] = $people;
			}
			if (isset ($_SESSION['preferences']['contactsView']) && ($_SESSION['preferences']['contactsView'] != 'address')) {
				$query = 'SELECT * FROM companycontactmethod WHERE companyid='.$db->qstr($_GET['id']).' AND type='.$db->qstr($_SESSION['preferences']['contactsView']).' ORDER BY name';
			} else {
				$query = 'SELECT * FROM companyaddress WHERE companyid='.$db->qstr($_GET['id']).' ORDER BY name';

				$_SESSION['preferences']['contactsView'] = 'address';
			}

			$rs = $db->Execute($query);

			/* Show new link if correct access */
			if ($accessLevel > 2)
				$contacts = array ('type' => 'contact', 'title' => $_SESSION['preferences']['contactsView'], 'header' => array (_('Name'), _('Contact'), _('Main'), _('Billing'), _('Shipping'), _('Payment'), _('Technical')), 'viewlink' => 'action=save'.$_SESSION['preferences']['contactsView'].'&amp;companyid='.$_GET['id'].'&amp;id=', 'newlink' => 'action=save'.$_SESSION['preferences']['contactsView'].'&amp;companyid='.intval($_GET['id']), 'contacttype' => array ('main', 'billing', 'shipping', 'payment', 'technical'), 'options' => array ('address' => _('Addresses'), 'T' => _('Phone'), 'F' => _('Fax'), 'E' => _('Email')));
			/* Just show the title */
			else
				$contacts = array ('type' => 'contact', 'title' => $_SESSION['preferences']['contactsView'], 'header' => array (_('Name'), _('Contact'), _('Main'), _('Billing'), _('Shipping'), _('Payment'), _('Technical')), 'options' => array ('address' => _('Addresses'), 'T' => _('Phone'), 'F' => _('Fax'), 'E' => _('Email')));

			/* Iterate over and show the contacts */
			while (!$rs->EOF) {
				//$contacts['data'][] = $rs->fields;
				$contact = array ();

				$contact['tag'] = urlencode($rs->fields['tag']);
				$contact['name'] = $rs->fields['name'];

				if ($_SESSION['preferences']['contactsView'] == 'address') {
					$contact['contact'] = $egs->formatAddress($rs->fields);
				} else {
					$contact['contact'] = $rs->fields['contact'];
				}

				$contact['main'] = $rs->fields['main'];
				$contact['billing'] = $rs->fields['billing'];
				$contact['shipping'] = $rs->fields['shipping'];
				$contact['payment'] = $rs->fields['payment'];
				$contact['technical'] = $rs->fields['technical'];

				$contacts['data'][] = $contact;

				$rs->MoveNext();
			}

			$contacts['icon'] = 'addresses';
			$bottomData[] = $contacts;

			/* Show the branches and edit/new links if necessary */
			if ($accessLevel > 2)
				$company = array ('type' => 'data', 'title' => _('Branches'), 'header' => array (_('Name'), _('Phone'), _('Fax'), _('Email')), 'viewlink' => 'action=view&amp;id=', 'newlink' => 'action=saveaccount&amp;branchcompanyid='.intval($_GET['id']));
			/* Just show the title */
			else
				$company = array ('type' => 'data', 'title' => _('Branches'), 'header' => array (_('Name'), _('Phone'), _('Fax'), _('Email')), 'viewlink' => 'action=view&amp;id=');

			/* This is a recursive function to show the branches and sub branches */
			function branch(& $company, $id, & $indents, $indent) {
				global $db;
				$query = 'SELECT id, name, phone, fax, email FROM companyoverview WHERE branchcompanyid='.$db->qstr($id).' ORDER BY name';

				$rs = $db->Execute($query);

				$indent ++;

				while (!$rs->EOF) {
					$company['data'][] = $rs->fields;

					$indents[] = $indent;

					branch($company, $rs->fields['id'], $indents, $indent);

					$rs->MoveNext();
				}
			}

			$indents = array (0);

			/* Get the parent company */
			$query = 'SELECT id, name, phone, fax, email FROM companyoverview WHERE id='.$db->qstr($parentId).' ORDER BY name';

			$rs = $db->GetRow($query);

			$company['data'][] = $rs;

			/* Now get the branch companies */
			branch($company, $parentId, $indents, 0);

			$company['indents'] = $indents;

			$company['icon'] = 'branch';
			$bottomData[] = $company;

			if (($_GET['module'] != 'home') && ($accessLevel > 1)) {
				/* Get the open opportunities */
				$query = 'SELECT personid, id, name, person, status, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'enddate').' AS enddate FROM opportunityoverview WHERE usercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND companyid='.$db->qstr(intval($_GET['id'])).' AND open='.$db->qstr('true').' ORDER BY name';

				$rs = $db->Execute($query);

				$links = array ();

				if ($accessLevel > 2)
					$opportunities = array ('type' => 'data', 'title' => _('Open Opportunities'), 'header' => array (_('Name'), _('Type'), _('Contact'), _('Due Date')), 'viewlink' => 'action=viewopportunity&amp;id=', 'newlink' => 'action=saveopportunity&amp;companyid='.intval($_GET['id']));
				else
					$opportunities = array ('type' => 'data', 'title' => _('Open Opportunities'), 'header' => array (_('Name'), _('Type'), _('Contact'), _('Due Date')), 'viewlink' => 'action=viewopportunity&amp;id=');

				while (!$rs->EOF) {
					$links[4][] = 'action=viewperson&amp;id='.$rs->fields['personid'];
					unset ($rs->fields['personid']);
					unset ($rs->fields['companyid']);

					$opportunities['data'][] = $rs->fields;
					$rs->MoveNext();
				}

				$opportunities['links'] = $links;

				$opportunities['icon'] = 'opportunity';
				$bottomData[] = $opportunities;

				/* Grab the Cases */
				$query = 'SELECT personid, id, id AS num, name, person, priority, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'enddate').' AS enddate, assigned FROM crmcaseoverview WHERE usercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND companyid='.$db->qstr(intval($_GET['id'])).' ORDER BY name';

				$rs = $db->Execute($query);

				$links = array ();

				if ($accessLevel > 2)
					$cases = array ('type' => 'data', 'title' => _('Open Cases'), 'header' => array (_('Num'), _('Subject'), _('Contact'), _('Priority'), _('Due Date'), _('Assigned To')), 'viewlink' => 'action=viewcase&amp;id=', 'newlink' => 'action=savecase&amp;companyid='.intval($_GET['id']));
				else
					$cases = array ('type' => 'data', 'title' => _('Open Cases'), 'header' => array (_('Num'), _('Subject'), _('Contact'), _('Priority'), _('Due Date'), _('Assigned To')), 'viewlink' => 'action=viewcase&amp;id='.intval($_GET['id']).'&amp;id=');

				while (!$rs->EOF) {
					$links[4][] = 'action=viewperson&amp;id='.$rs->fields['personid'];
					unset ($rs->fields['personid']);
					unset ($rs->fields['companyid']);

					$cases['data'][] = $rs->fields;
					$rs->MoveNext();
				}

				$cases['links'] = $links;
				$cases['icon'] = 'cases';
				$bottomData[] = $cases;

				$query = 'SELECT caseid, opportunityid, personid, id, name, activity, casename, opportunity, person, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'startdate').' AS startdate, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'enddate').' AS enddate, personid, companyid FROM activityoverview WHERE usercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND companyid='.$db->qstr(intval($_GET['id'])).' AND completed IS NULL ORDER BY name';

				$rs = $db->Execute($query);

				$links = array ();

				if ($accessLevel > 2)
					$activities = array ('type' => 'data', 'title' => _('Open Activities'), 'header' => array (_('Name'), _('Type'), _('Attached To'), _('Contact'), _('Start Date'), _('End Date')), 'viewlink' => 'action=viewactivity&amp;id=', 'newlink' => 'action=saveactivity&amp;companyid='.intval($_GET['id']));
				else
					$activities = array ('type' => 'data', 'title' => _('Open Activities'), 'header' => array (_('Name'), _('Type'), _('Attached To'), _('Contact'), _('Start Date'), _('End Date')), 'viewlink' => 'action=viewactivity&amp;id=');

				while (!$rs->EOF) {
					$links[5][] = 'action=viewperson&amp;id='.$rs->fields['personid'];
					if ($rs->fields['opportunityid'] != '') {
						$links[4][] = 'action=viewopportuity&amp;id='.$rs->fields['opportunityid'];
						unset ($rs->fields['casename']);
					}
					if ($rs->fields['caseid'] != '') {
						$links[4][] = 'action=viewcase&amp;id='.$rs->fields['caseid'];
						unset ($rs->fields['opportunity']);
					}
					unset ($rs->fields['personid']);
					unset ($rs->fields['companyid']);
					unset ($rs->fields['opportunityid']);
					unset ($rs->fields['caseid']);

					$activities['data'][] = $rs->fields;
					$rs->MoveNext();
				}

				$activities['links'] = $links;
				$activities['icon'] = 'activity';
				$bottomData[] = $activities;
			}

			/* Assign the data to the template */
			$smarty->assign('view', true);
			$smarty->assign('leftData', $leftData);
			$smarty->assign('rightData', $rightData);
			$smarty->assign('rightSpan', $rightSpan);
			$smarty->assign('bottomData', $bottomData);
			$smarty->assign('moduleIcon', 'company');

		} else {
			$smarty->assign('errors', array (_('There was a temporary error trying to retrieve the company details. Please try again later. If the problem persists please contact your system administrator')));
			$smarty->assign('redirect', true);
			$smarty->assign('redirectAction', '');
		}
	} else {
		$smarty->assign('errors', array (_('You do not have the correct permissions to access this company. If you believe you should please contact your system administrator')));
		$smarty->assign('redirect', true);
		$smarty->assign('redirectAction', '');
	}
} else {
	$smarty->assign('errors', array (_('You do not have the correct permissions to access this module. If you believe you should please contact your system administrator')));
	$smarty->assign('redirect', true);
	$smarty->assign('redirectAction', '');
}
?>