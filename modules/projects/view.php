<?php

/* Check for the submission of progress */
if (isset ($_POST['progress'])) {
	$progressarray = $_POST['progress'];
	unset ($_POST['progress']);
}

$accessLevel = $project->accessLevel(intval($_GET['id']));
/*if the person looking at the page is a client, then they shouldn't be able to add hours*/
$q = 'SELECT owner FROM personoverview WHERE owner='.$db->qstr(EGS_USERNAME).' AND companyid='.$db->qstr(EGS_COMPANY_ID);
if (!$db->GetOne($q))
	$isClient = true;
else
	$isClient = false;

/*end testing*/

if (isset ($_GET['show'])) {
	$_SESSION['showtasks'][intval($_GET['show'])] = 'show';
}

if (isset ($_GET['hide'])) {
	$_SESSION['showtasks'][intval($_GET['hide'])] = 'hide';
}

if ((sizeof($_POST) > 0) && ($accessLevel > 0) && (isset ($_POST['savetype']) && ($_POST['savetype'] == 'priority')) && (!isset ($_POST['delete']))) {
	if (isset ($_GET['priorityid']))
		$project->savePriority($_POST, $_GET['priorityid']);
	else
		$project->savePriority($_POST);
} else
	if ((sizeof($_POST) > 0) && ($accessLevel > 0) && (isset ($_POST['delete']))) {
		$delete = $project->deletePriority($_GET['id'], $_GET['priorityid']);
		if ($delete)
			$smarty->assign('messages', array (_('Priority successfully deleted.')));
		else
			$smarty->assign('messages', array (_('You do not have the correct access to update this priority. If you beleive you should please contact your system administrator.')));
	} else
		if ((sizeof($_POST) > 0) && ($accessLevel > 0) && (isset ($_POST['values']))) {
			$project->updateManagers($_POST['values'], $_GET['id']);
		}

if ($accessLevel >= 0) {

	if (isset ($progressarray)) {

		/*the javascript has worked!!!*/

		foreach ($progressarray as $taskid => $progress) {
			/*check they are allowed to change the progress*/
			$q = 'SELECT ptr.taskid FROM projecttaskresources ptr JOIN resource r ON ptr.resourceid=r.id JOIN person p ON r.personid=p.id JOIN useraccess ua ON ua.username=p.owner WHERE p.owner='.$db->qstr(EGS_USERNAME).' AND ua.companyid='.$db->qstr(EGS_COMPANY_ID).' AND ptr.taskid='.$db->qstr($taskid);

			if ($db->GetOne($q) || (isset ($accessLevel) && $accessLevel > 0)) {
				$allowedit = true;
			} else
				$allowedit = false;
			/*get all the task details*/
			$q = 'SELECT * FROM projecttask WHERE id='.$db->qstr($taskid);
			$taskarray = $db->GetRow($q);
			/*overwrite the progress with the new value*/

			if ($taskarray['progress'] != $progress && $allowedit) {
				if ((!is_numeric($progress)) || !(0 <= $progress) || !($progress <= 100)) {
					$errors = array ();
					$errors[] = _('The progress must be a number between 0 and 100');
					$smarty->assign('errors', $errors);
					break;
				}
				$taskarray['progress'] = $progress;
				if ($taskarray['parenttaskid'] == '')
					unset ($taskarray['parenttaskid']);
				if ($taskarray['milestone'] == '')
					unset ($taskarray['milestone']);
				if ($taskarray['budget'] == '')
					unset ($taskarray['budget']);
				if ($taskarray['priorityid'] == '')
					unset ($taskarray['priorityid']);

				$project->saveTask($taskarray, $taskid, $allowedit);
			}
		}
		unset ($_POST['progress']);

	}

	$query = 'SELECT *, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'startdate').' AS startdate, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'enddate').' AS enddate, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'actualenddate').' AS actualenddate, '.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 'added').' AS added, '.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 'updated').' AS updated FROM projectoverview WHERE id='.$db->qstr(intval($_GET['id']));

	$projectDetails = $db->GetRow($query);

	if ($projectDetails !== false) {
		/* Add to last viewed */
		$_SESSION['preferences']['lastViewed'] = array_slice(array_merge(array ('module=projects&amp;action=view&amp;id='.intval($_GET['id']) => array ('project', $projectDetails['name'])), $_SESSION['preferences']['lastViewed']), 0, EGS_RECENTLY_VIEWED);

		/* Sync view to preferences */
		$egs->syncPreferences();

		$smarty->assign('pageTitle', $projectDetails['jobno'].' - '.$projectDetails['name']);

		if ($accessLevel > 0)
			$smarty->assign('pageEdit', 'action=saveproject&amp;id='.intval($_GET['id']));

		$leftData = array ();
		$leftData[] = array ('tag' => _('Job Name'), 'data' => $projectDetails['name']);
		$leftData[] = array ('tag' => _('Job Num.'), 'data' => $projectDetails['jobno']);
		$leftData[] = array ('tag' => _('Job Category'), 'data' => $projectDetails['categoryname']);
		$leftData[] = array ('span' => true);
		$leftData[] = array ('tag' => _('Start Date'), 'data' => $projectDetails['startdate']);
		$leftData[] = array ('tag' => _('End Date'), 'data' => $projectDetails['enddate']);
		$leftData[] = array ('tag' => _('Actual Date'), 'data' => $projectDetails['actualenddate'], 'overdue' => $projectDetails['overdue']);
		$leftData[] = array ('span' => true);

		$leftData[] = array ('tag' => _('Added'), 'data' => $projectDetails['added'].' '._('by').' '.$projectDetails['owner']);
		$leftData[] = array ('tag' => _('Last Updated'), 'data' => $projectDetails['updated'].' '._('by').' '.$projectDetails['alteredby']);

		$rightData = array ();

		$rightData[] = array ('tag' => _('Total Tasks'), 'data' => $projectDetails['tasks']);
		$rightData[] = array ('tag' => _('Complete'), 'data' => $projectDetails['percentage'].'%');
		$rightData[] = array ('tag' => _('Total Hours'), 'data' => $projectDetails['hours']);
		$rightData[] = array ('tag' => _('Budget'), 'data' => $projectDetails['cost']);
		$rightData[] = array ('span' => true);
		$rightData[] = array ('tag' => _('Website'), 'data' => $projectDetails['url'], 'link' => $projectDetails['url']);
		$rightData[] = array ('span' => true);
		$rightData[] = array ('tag' => _('Account'), 'data' => $projectDetails['companyname'], 'link' => EGS_SERVER.'/?'.session_name().'='.strip_tags(session_id()).'&amp;module=contacts&amp;action=view&amp;id='.$projectDetails['companyid']);
		$rightData[] = array ('tag' => _('Contact'), 'data' => $projectDetails['personname'], 'link' => EGS_SERVER.'/?'.session_name().'='.strip_tags(session_id()).'&amp;module=contacts&amp;action=viewperson&amp;companyid='.$projectDetails['companyid'].'&amp;personid='.$projectDetails['personid']);

		$rightSpan = array ();

		$rightSpan[] = array ('type' => 'text', 'title' => _('Project Description'), 'text' => nl2br($projectDetails['description']));

		$query = 'SELECT r.id, p.firstname || \' \' || p.surname AS name FROM resource r, person p WHERE p.id=r.personid AND r.projectid='.$db->qstr(intval($_GET['id'])).' AND r.projectmanager ORDER BY name';

		$rs = $db->Execute($query);

		if (($accessLevel > 0) && isset ($_GET['edit']) && ($_GET['edit'] == 'managers'))
			$managers = array ('type' => 'data', 'title' => _('Project Managers'), 'save' => 'action=view&amp;id='.intval($_GET['id']));
		else
			if ($accessLevel > 0)
				$managers = array ('type' => 'data', 'title' => _('Project Managers'), 'edit' => 'action=view&amp;edit=managers&amp;id='.intval($_GET['id']));
			else
				$managers = array ('type' => 'data', 'title' => _('Project Managers'));

		while (!$rs->EOF) {
			$managers['data'][$rs->fields['id']] = $rs->fields['name'];
			$managers['selected'][] = $rs->fields['id'];

			$rs->MoveNext();
		}

		if (($accessLevel > 0) && isset ($_GET['edit']) && ($_GET['edit'] == 'managers')) {
			$query = 'SELECT r.id, p.firstname || \' \' || p.surname AS name FROM resource r, person p WHERE p.id=r.personid AND r.projectid='.$db->qstr(intval($_GET['id'])).' ORDER BY name';

			$rs = $db->Execute($query);

			while (!$rs->EOF) {
				$managers['values'][$rs->fields['id']] = $rs->fields['name'];
				$rs->MoveNext();
			}
		}

		$rightSpan[] = $managers;

		/* If the fly spray schema is set up show bugs */
		if ($db->GetOne('SELECT tablename FROM pg_tables WHERE schemaname=\'company'.EGS_COMPANY_ID.'\' AND tablename LIKE \'flyspray_%\'')) {
			$query = 'SELECT task_id, item_summary FROM company'.EGS_COMPANY_ID.'.flyspray_tasks WHERE is_closed='.$db->qstr(0).' AND attached_to_project='.$db->qstr($_GET['id']).' ORDER BY task_id';

			$rs = $db->Execute($query);

			if ($accessLevel > 0)
				$bugs = array ('type' => 'data', 'title' => _('Open Bugs'), 'new' => 'action=bugs&amp;do=newtask&amp;id='.intval($_GET['id']));
			else
				$bugs = array ('type' => 'data', 'title' => _('Open Bugs'));

			while (!$rs->EOF) {
				$bugs['data'][] = '#'.$rs->fields['task_id'].'. '.$rs->fields['item_summary'];

				if ($accessLevel > 0)
					$bugs['link'][] = 'module=projects&amp;action=bugs&amp;do=details&amp;id='.$rs->fields['task_id'];
				$rs->MoveNext();
			}

			$rightSpan[] = $bugs;
		}

		if ($accessLevel > 0) {
			if (($accessLevel > 0) && isset ($_GET['edit']) && ($_GET['edit'] == 'priorities') && !isset ($_GET['priorityid']))
				$priorities = array ('type' => 'data', 'title' => _('Save New Priority'), 'save' => 'action=view&amp;id='.intval($_GET['id']), 'saveType' => 'priority', 'hiddenName' => 'projectid', 'hiddenValue' => $_GET['id']);
			else
				if (($accessLevel > 0) && isset ($_GET['edit']) && ($_GET['edit'] == 'priorities') && isset ($_GET['priorityid'])) {
					$priorityName = $db->GetOne('SELECT name FROM projecttaskpriority WHERE projectid='.$db->qstr(intval($_GET['id'])).' AND id='.$db->qstr(intval($_GET['priorityid'])));

					$priorities = array ('type' => 'data', 'title' => _('Save Priority'), 'save' => 'action=view&amp;id='.intval($_GET['id']), 'delete' => 'true', 'saveType' => 'priority', 'saveValue' => $priorityName, 'hiddenName' => 'projectid', 'hiddenValue' => $_GET['id']);
				} else
					$priorities = array ('type' => 'data', 'title' => _('Priorities'), 'new' => 'action=view&amp;edit=priorities&amp;id='.intval($_GET['id']));

			$query = 'SELECT id, name FROM projecttaskpriority WHERE projectid='.$db->qstr(intval($_GET['id'])).' ORDER BY name';

			$rs = $db->Execute($query);

			while (!$rs->EOF) {
				$priorities['data'][] = $rs->fields['name'];

				if ($accessLevel > 0)
					$priorities['link'][] = 'module=projects&amp;action=view&amp;edit=priorities&amp;id='.intval($_GET['id']).'&amp;priorityid='.$rs->fields['id'];
				$rs->MoveNext();
			}

			$rightSpan[] = $priorities;

		}

		if (isset ($_GET['taskOrder']) && ($_GET['taskOrder'] == $_SESSION['taskOrder'])) {
			if (isset ($_SESSION['taskSort']) && ($_SESSION['taskSort'] == 'ASC'))
				$_SESSION['taskSort'] = 'DESC';
			else
				if (isset ($_SESSION['taskSort']) && ($_SESSION['taskSort'] == 'DESC'))
					$_SESSION['taskSort'] = 'ASC';
			$_SESSION['project_page'] = 1;
		} else
			if (isset ($_GET['taskOrder'])) {
				$_SESSION['taskSort'] = 'DESC';
				$_SESSION['taskOrder'] = $_GET['taskOrder'];
				$_SESSION['project_page'] = 1;
			}

		if (!isset ($_SESSION['taskOrder']))
			$_SESSION['taskOrder'] = 't.startdate';
		if (!isset ($_SESSION['taskSort']))
			$_SESSION['taskSort'] = 'ASC';

		$_SESSION['taskOrder'] = $_SESSION['taskOrder'];

		if ($accessLevel > 0)
			$tasks = array ('type' => 'data', 'title' => _('Tasks'), 'header' => array ('name' => _('Task Name'), 'progress' => _('Progress'), 't.startdate' => _('Start Date'), 't.enddate' => _('End Date'), 'duration' => _('Duration'), 'hours' => _('Hours')), 'viewlink' => 'action=viewtask&amp;projectid='.intval($_GET['id']).'&amp;taskid=', 'newlink' => 'action=savetask&amp;projectid='.intval($_GET['id']));
		else
			$tasks = array ('type' => 'data', 'title' => _('Tasks'), 'header' => array ('name' => _('Task Name'), 'progress' => _('Progress'), 't.startdate' => _('Start Date'), 't.enddate' => _('End Date'), 'duration' => _('Duration'), 'hours' => _('Hours')), 'viewlink' => 'action=viewtask&amp;projectid='.intval($_GET['id']).'&amp;taskid=');

		function tasks(& $task, $id, & $indents, & $pre, $indent) {
			global $db, $project, $tasks;

			$query = 'SELECT id, name, progress, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 't.startdate').' AS startdate, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 't.enddate').' AS enddate, duration, hours FROM taskoverview t WHERE projectid='.$db->qstr(intval($_GET['id'])).' AND parenttaskid='.$db->qstr($id).' ORDER BY '.$_SESSION['taskOrder'].' '.$_SESSION['taskSort'];

			$rs = $db->Execute($query);

			$indent ++;

			while (!$rs->EOF) {
				$task['data'][] = $rs->fields;

				$indents[] = $indent;

				if (isset ($_SESSION['showtasks'][$rs->fields['id']]) && ($_SESSION['showtasks'][$rs->fields['id']] == 'show')) {
					if ($project->hasChildren($rs->fields['id'])) {
						$pre[] = array ('sign' => '-', 'link' => $rs->fields['id']);
						$tasks['signpad'] = true;
						tasks($task, $rs->fields['id'], $indents, $pre, $indent);
					} else
						$pre[] = array ('sign' => '');
				} else
					if ($project->hasChildren($rs->fields['id'])) {
						$pre[] = array ('sign' => '+', 'link' => $rs->fields['id']);
						$tasks['signpad'] = true;
					} else
						$pre[] = array ('sign' => '');

				$rs->MoveNext();
			}
		}

		$indents = array ();
		$pre = array ();

		$query = 'SELECT id, name, progress, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 't.startdate').' AS startdate, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 't.enddate').' AS enddate, duration, hours FROM taskoverview t WHERE projectid='.$db->qstr(intval($_GET['id'])).' AND parenttaskid IS NULL ORDER BY '.$_SESSION['taskOrder'].' '.$_SESSION['taskSort'];

		$rs = $db->Execute($query);

		while (!$rs->EOF) {
			$tasks['data'][] = $rs->fields;

			$indents[] = 0;

			if (isset ($_SESSION['showtasks'][$rs->fields['id']]) && ($_SESSION['showtasks'][$rs->fields['id']] == 'show')) {
				if ($project->hasChildren($rs->fields['id'])) {
					$pre[] = array ('sign' => '-', 'link' => $rs->fields['id']);
					$tasks['signpad'] = true;
					tasks($tasks, $rs->fields['id'], $indents, $pre, 0);
				} else
					$pre[] = array ('sign' => '', 'link' => $rs->fields['id']);
			} else
				if ($project->hasChildren($rs->fields['id'])) {
					$pre[] = array ('sign' => '+', 'link' => $rs->fields['id']);
					$tasks['signpad'] = true;
				} else
					$pre[] = array ('sign' => '');

			$rs->MoveNext();
		}

		$tasks['indents'] = $indents;
		$tasks['pre'] = $pre;

		$bottomData[] = $tasks;
		if (isset ($_GET['resourceOrder']) && ($_GET['resourceOrder'] == $_SESSION['resourceOrder'])) {
			if (isset ($_SESSION['resourceSort']) && ($_SESSION['resourceSort'] == 'ASC'))
				$_SESSION['resourceSort'] = 'DESC';
			else
				if (isset ($_SESSION['resourceSort']) && ($_SESSION['resourceSort'] == 'DESC'))
					$_SESSION['resourceSort'] = 'ASC';
			$_SESSION['project_page'] = 1;
		} else
			if (isset ($_GET['resourceOrder'])) {
				$_SESSION['resourceSort'] = 'DESC';
				$_SESSION['resourceOrder'] = $_GET['resourceOrder'];
				$_SESSION['project_page'] = 1;
			}

		if (!isset ($_SESSION['resourceOrder']))
			$_SESSION['resourceOrder'] = 'name';
		if (!isset ($_SESSION['resourceSort']))
			$_SESSION['resourceSort'] = 'ASC';

		$_SESSION['resourceOrder'] = $_SESSION['resourceOrder'];

		if ($accessLevel > 0) {
			$query = 'SELECT personid, companyid, id, name, standardrate, overtimerate, CASE WHEN projectmanager THEN '.$db->qstr(_('Yes')).' END AS projectmanger, quantity, cost FROM resourceoverview WHERE projectid='.$db->qstr($_GET['id']).' ORDER BY '.$_SESSION['resourceOrder'].' '.$_SESSION['resourceSort'];

			$rs = $db->Execute($query);

			$links = array ();

			if ($accessLevel > 0)
				$resources = array ('type' => 'data', 'title' => _('Resources'), 'header' => array ('name' => _('Name'), 'standardrate' => _('Standard Rate'), 'overtimerate' => _('Overtime Rate'), 'projectmanager' => _('Project Manager'), 'quantity' => _('Quantity'), 'cost' => _('Cost')), 'newlink' => 'action=savepersonresource&amp;projectid='.intval($_GET['id']), 'newlinktext' => _('New Person Resource'), 'newlink2' => 'action=savecompanyresource&amp;projectid='.intval($_GET['id']), 'newlinktext2' => _('New Company Resource'));

			while (!$rs->EOF) {
				if ($rs->fields['personid'] != '')
					$links[2][] = 'action=savepersonresource&amp;projectid='.$_GET['id'].'&amp;id='.$rs->fields['id'];
				else
					$links[2][] = 'action=savecompanyresource&amp;projectid='.$_GET['id'].'&amp;id='.$rs->fields['id'];
				unset ($rs->fields['personid']);
				unset ($rs->fields['companyid']);

				$resources['data'][] = $rs->fields;
				$rs->MoveNext();
			}

			$resources['links'] = $links;

			$bottomData[] = $resources;
		}
		/* Set the search order */

		if (isset ($_GET['hourOrder']) && ($_GET['hourOrder'] == $_SESSION['hourOrder'])) {
			if (isset ($_SESSION['hourSort']) && ($_SESSION['hourSort'] == 'ASC'))
				$_SESSION['hourSort'] = 'DESC';
			else
				if (isset ($_SESSION['hourSort']) && ($_SESSION['hourSort'] == 'DESC'))
					$_SESSION['hourSort'] = 'ASC';
			$_SESSION['project_page'] = 1;
		} else
			if (isset ($_GET['hourOrder'])) {
				$_SESSION['hourSort'] = 'DESC';
				$_SESSION['hourOrder'] = $_GET['hourOrder'];
				$_SESSION['project_page'] = 1;
			}

		if (!isset ($_SESSION['hourOrder']))
			$_SESSION['hourOrder'] = 'entered';
		if (!isset ($_SESSION['hourSort']))
			$_SESSION['hourSort'] = 'ASC';

		
		
		$query = 'SELECT t.id AS taskid, h.id, hours(h.hours) AS hours, h.username, t.name, h.description, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'h.entered').' AS entered, CASE WHEN h.billable THEN '.$db->qstr(_('Yes')).' ELSE '.$db->qstr(_('No')).' END AS billable, CASE WHEN h.overtime THEN '.$db->qstr(_('Yes')).' ELSE '.$db->qstr(_('No')).' END AS overtime, CASE WHEN h.invoiced THEN '.$db->qstr(_('Yes')).' ELSE '.$db->qstr(_('No')).' END AS invoiced FROM projecthours h LEFT OUTER JOIN projecttask t ON (h.taskid=t.id) WHERE h.projectid='.$db->qstr(intval($_GET['id']));

		if ($accessLevel < 1 && !$isClient)
			$query .= ' AND username='.$db->qstr(EGS_USERNAME);
		if ($isClient && $accessLevel < 1)
			$query .= ' AND billable';
		$query .= 'ORDER BY ';
		if($_SESSION['hourOrder']=='name')
				$query.='t.';
		else
			$query.='h.';
		$query.=$_SESSION['hourOrder'].' '.$_SESSION['hourSort'];

		$rs = $db->Execute($query);

		if (isset ($isClient) && $isClient && $accessLevel < 1)
			$tasks = array ('type' => 'data', 'title' => _('Hours'), 'header' => array ('hours' => _('Hours'), 'username' => _('Worked by'), 'name' => _('Worked On'), 'description' => _('Description'), 'entered' => _('Entered'), 'billable' => _('Billable'), 'overtime' => _('Overtime'), 'invoiced' => _('Invoiced')), 'viewlink' => 'action=savehours&amp;projectid='.$_GET['id'].'&amp;hoursid=');
		else
			if ($project->accessLevel($_GET['id']) > 0)
				$tasks = array ('type' => 'data', 'title' => _('Hours'), 'header' => array ('hours' => _('Hours'), 'username' => _('Worked by'), 'name' => _('Worked On'), 'description' => _('Description'), 'entered' => _('Entered'), 'billable' => _('Billable'), 'overtime' => _('Overtime'), 'invoiced' => _('Invoiced')), 'newlink' => 'action=savehours&amp;projectid='.intval($_GET['id']), 'viewlink' => 'action=savehours&amp;projectid='.$_GET['id'].'&amp;hoursid=');
			else
				$tasks = array ('type' => 'data', 'title' => _('Hours'), 'header' => array ('hours' => _('Hours'), 'username' => _('Worked by'), 'name' => _('Worked On'), 'description' => _('Description'), 'entered' => _('Entered'), 'billable' => _('Billable'), 'overtime' => _('Overtime'), 'invoiced' => _('Invoiced')), 'newlink' => 'action=savehours&amp;projectid='.intval($_GET['id']));
		$links = array ();
		if($rs!==false) {
			while (!$rs->EOF) {
				$links[4][] = 'action=viewtask&amp;projectid='.intval($_GET['id']).'&amp;taskid='.$rs->fields['taskid'];
				unset ($rs->fields['taskid']);

				$tasks['data'][] = $rs->fields;
				$rs->MoveNext();
			}
		}
		$tasks['links'] = $links;
		$bottomData[] = $tasks;

		$smarty->assign('view', true);
		$smarty->assign('leftData', $leftData);
		$smarty->assign('rightData', $rightData);
		$smarty->assign('rightSpan', $rightSpan);
		$smarty->assign('bottomData', $bottomData);

	} else {
		$smarty->assign('redirect', true);
		$smarty->assign('redirectAction', 'action=overview');
		$smarty->assign('errors', array (_('There was a temporary error trying to retrieve the project details. Please try again later. If the problem persists please contact your system administrator')));
	}
} else {
	unset ($_SESSION['preferences']['lastViewed']['module=projects&amp;action=view&amp;id='.$_GET['id']]);
	$egs->syncPreferences();

	$smarty->assign('redirect', true);
	$smarty->assign('redirectAction', 'action=overview');
	$smarty->assign('errors', array (_('You do not have the correct permissions to access this project. If you believe you should please contact your system administrator')));
}
?>