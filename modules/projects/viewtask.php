<?php
	require_once(EGS_FILE_ROOT.'/src/classes/class.project.php');

	$project = new project();

	$accessLevel = $project->accessLevel(intval($_GET['projectid']));

	/*if the person looking at the page is a client, then they shouldn't be able to add hours*/
	$q = 'SELECT owner FROM personoverview WHERE owner='.$db->qstr(EGS_USERNAME).' AND companyid='.$db->qstr(EGS_COMPANY_ID);
	if(!$db->GetOne($q))
		$isClient=true;
	else $isClient=false;
	if((sizeof($_POST) > 0) && ($accessLevel > 0)) {
		if(isset($_GET['editdone']) && ($_GET['editdone'] == 'dependencies')) $project->updateTaskDependencies($_POST, $_GET['projectid'], $_GET['taskid']);
		else if(isset($_POST['values']))$project->updateResources($_POST['values'], $_GET['projectid'], $_GET['taskid']);
	}
			
	if($accessLevel >= 0) {
		
		$query = 'SELECT *, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'startdate').' AS startdate, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'enddate').' AS enddate, '.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 'added').' AS added, '.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 'updated').' AS updated FROM taskoverview WHERE projectid='.$db->qstr(intval($_GET['projectid'])).' AND id='.$db->qstr(intval($_GET['taskid']));

		$taskDetails = $db->GetRow($query);

		if($taskDetails !== false) {
			/* Add to last viewed */
			$_SESSION['preferences']['lastViewed'] = array_slice(array_merge(array('module=projects&amp;action=viewtask&amp;projectid='.intval($_GET['projectid']).'&amp;taskid='.intval($_GET['taskid']) => array('projecttask', $taskDetails['name'])), $_SESSION['preferences']['lastViewed']), 0, EGS_RECENTLY_VIEWED);

			/* Sync view to preferences */
			$egs->syncPreferences();

			$smarty->assign('pageTitle', $taskDetails['name']);
			
			if($accessLevel > 0) {
				$smarty->assign('pageEdit', 'action=savetask&amp;projectid='.intval($_GET['projectid']).'&amp;taskid='.intval($_GET['taskid']));
				$smarty->assign('pageDelete', 'action=deletetask&amp;projectid='.intval($_GET['projectid']).'&amp;taskid='.intval($_GET['taskid']));
			}

			$leftData = array();
			$leftData[] = array('tag' => _('Task Name'), 'data' => $taskDetails['name']);
			if($taskDetails['milestone'] == 'f') $leftData[] = array('tag' => _('Milestone'), 'data' => _('No'));
			else $leftData[] = array('tag' => _('Milestone'), 'data' => _('Yes'));
			$leftData[] = array('span' => true);
			$leftData[] = array('tag' => _('Start Date'), 'data' => $taskDetails['startdate']);
			$leftData[] = array('tag' => _('End Date'), 'data' => $taskDetails['enddate']);
			$leftData[] = array('tag' => _('Duration'), 'data' => $taskDetails['duration']);
			$leftData[] = array('span' => true);

			$leftData[] = array('tag' => _('Added'), 'data' => $taskDetails['added'].' '._('by').' '.$taskDetails['owner']);
			$leftData[] = array('tag' => _('Last Updated'), 'data' => $taskDetails['updated'].' '._('by').' '.$taskDetails['alteredby']);
			
			$rightData = array();
			
			$rightData[] = array('tag' => _('Budget'), 'data' => $taskDetails['budget']);
			$rightData[] = array('tag' => _('Priority'), 'data' => $taskDetails['priorityname']);
			$rightData[] = array('tag' => _('Progress'), 'data' => $taskDetails['progress'].' %');
			$rightData[] = array('tag' => _('Hours'), 'data' => $taskDetails['hours']);
			
			$rightSpan = array();

			$rightSpan[] = array('type' => 'text', 'title' => _('Task Description'), 'text' => nl2br($taskDetails['description']));

			$query = 'SELECT r.id, r.name FROM resourceoverview r, projecttaskresources t WHERE r.id=t.resourceid AND t.taskid='.$db->qstr(intval($_GET['taskid'])).' ORDER BY r.name';

			$rs = $db->Execute($query);

			if(($accessLevel > 0) && isset($_GET['edit']) && ($_GET['edit'] == 'resources')) $resources = array('type' => 'data', 'title' => _('Resources'), 'save' => 'action=viewtask&amp;projectid='.intval($_GET['projectid']).'&amp;taskid='.intval($_GET['taskid']));
			else if($accessLevel > 0) $resources = array('type' => 'data', 'title' => _('Resources'), 'edit' => 'action=viewtask&amp;edit=resources&amp;projectid='.intval($_GET['projectid']).'&amp;taskid='.intval($_GET['taskid']));
			else $resources= array('type' => 'data', 'title' => _('Resources'));

			while(!$rs->EOF) {
				$resources['data'][$rs->fields['id']] = $rs->fields['name'];
				$resources['selected'][] = $rs->fields['id'];

				$rs->MoveNext();
			}
			
			if(($accessLevel > 0) && isset($_GET['edit']) && ($_GET['edit'] == 'resources')) {
				$query = 'SELECT r.id, r.name FROM resourceoverview r WHERE r.projectid='.$db->qstr(intval($_GET['projectid'])).' ORDER BY r.name';
	
				$rs = $db->Execute($query);
				
				while(!$rs->EOF) {
					$resources['values'][$rs->fields['id']] = $rs->fields['name'];
					$rs->MoveNext();
				}
			}
			
			$rightSpan[] = $resources;
			
			$query = 'SELECT t.id, t.name FROM projecttask t, projecttaskdependencies d WHERE t.id=d.dependsontaskid AND d.taskid='.$db->qstr(intval($_GET['taskid'])).' ORDER BY t.name';

			$rs = $db->Execute($query);

			if(($accessLevel > 0) && isset($_GET['edit']) && ($_GET['edit'] == 'dependencies')) $dependencies = array('type' => 'data', 'title' => _('Dependencies'), 'save' => 'action=viewtask&amp;projectid='.intval($_GET['projectid']).'&amp;taskid='.intval($_GET['taskid']));
			else if($accessLevel > 0) $dependencies = array('type' => 'data', 'title' => _('Dependencies'), 'edit' => 'action=viewtask&amp;edit=dependencies&amp;projectid='.intval($_GET['projectid']).'&amp;taskid='.intval($_GET['taskid']));
			else $dependencies= array('type' => 'data', 'title' => _('Dependencies'));

			while(!$rs->EOF) {
				$dependencies['data'][$rs->fields['id']] = $rs->fields['name'];
				$dependencies['selected'][] = $rs->fields['id'];

				$rs->MoveNext();
			}
			
			if(($accessLevel > 0) && isset($_GET['edit']) && ($_GET['edit'] == 'dependencies')) {
				$query = 'SELECT t.id, t.name FROM projecttask t WHERE t.projectid='.$db->qstr(intval($_GET['projectid'])).' AND t.id<>'.$db->qstr(intval($_GET['taskid'])).' ORDER BY t.name';
	
				$rs = $db->Execute($query);
				
				while(!$rs->EOF) {
					$dependencies['values'][$rs->fields['id']] = $rs->fields['name'];
					$rs->MoveNext();
				}
			}
			
			$rightSpan[] = $dependencies;
			
			if ($accessLevel > 0)
				$tasks = array ('type' => 'data', 'title' => _('Sub Tasks'), 'header' => array (_('Task Name'), _('Progress'), _('Start Date'), _('End Date'), _('Duration'), _('Hours')), 'viewlink' => 'action=viewtask&amp;projectid='.intval($_GET['projectid']).'&amp;taskid=', 'newlink' => 'action=savetask&amp;projectid='.intval($_GET['projectid']).'&amp;assubtaskid='.$_GET['taskid']);
			else
				$tasks = array ('type' => 'data', 'title' => _('Sub Tasks'), 'header' => array (_('Task Name'), _('Progress'), _('Start Date'), _('End Date'), _('Duration'), _('Hours')));
			
			function tasks(& $task, $id, & $indents, $indent) {
				global $db;
				$query = 'SELECT id, name, progress, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'startdate').' AS startdate, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'enddate').' AS enddate, duration, hours FROM taskoverview WHERE projectid='.$db->qstr(intval($_GET['projectid'])).' AND parenttaskid='.$db->qstr($id).' ORDER BY startdate';
	
				$rs = $db->Execute($query);
	
				$indent ++;
	
				while (!$rs->EOF) {
					$task['data'][] = $rs->fields;
	
					$indents[] = $indent;
	
					tasks($task, $rs->fields['id'], $indents, $indent);
	
					$rs->MoveNext();
				}
			}
	
			$indents = array ();
	
			$query = 'SELECT id, name, progress, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'startdate').' AS startdate, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'enddate').' AS enddate, duration, hours FROM taskoverview WHERE projectid='.$db->qstr(intval($_GET['projectid'])).' AND parenttaskid='.$db->qstr(intval($_GET['taskid'])).' ORDER BY startdate';
	
			$rs = $db->Execute($query);
	
			while (!$rs->EOF) {
				
				$tasks['data'][] = $rs->fields;
			
				$indents[] = 0;
		
				tasks($tasks, $rs->fields['id'], $indents, 0);
				
				$rs->MoveNext();
			}
			
			$tasks['indents'] = $indents;
	
			$bottomData[] = $tasks;
		
			if($accessLevel > 0) $query = 'SELECT id, extract(hour from hours) || \':\' || to_char(extract(minutes FROM hours), \'FM09\') AS hours, username, description, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'entered').' AS entered, CASE WHEN overtime THEN '.$db->qstr(_('Yes')).' ELSE '.$db->qstr(_('No')).' END AS overtime, CASE WHEN billable THEN '.$db->qstr(_('Yes')).' ELSE '.$db->qstr(_('No')).' END AS billable, CASE WHEN invoiced THEN '.$db->qstr(_('Yes')).' ELSE '.$db->qstr(_('No')).' END AS invoiced FROM projecthours WHERE projectid='.$db->qstr(intval($_GET['projectid'])).' AND taskid='.$db->qstr(intval($_GET['taskid']));
			else $query = 'SELECT id, hours, username, description, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'entered').' AS entered, CASE WHEN overtime THEN '.$db->qstr(_('YES')).' ELSE '.$db->qstr(_('No')).' END AS overtime, CASE WHEN billable THEN '.$db->qstr(_('YES')).' ELSE '.$db->qstr(_('No')).' END AS billable FROM projecthours WHERE projectid='.$db->qstr(intval($_GET['projectid'])).' AND taskid='.$db->qstr(intval($_GET['taskid']));
			
			if($accessLevel < 1 && !$isClient) $query .= ' AND username='.$db->qstr(EGS_USERNAME);
			if($isClient &&$accessLevel<1) $query .= ' AND billable';
			$query .= ' ORDER BY projecthours.entered';

			$rs = $db->Execute($query);
			if ((isset($_GET['projectid']))&&$isClient &&$accessLevel<1) $tasks = array ('type' => 'data', 'title' => _('Hours'), 'header' => array (_('Hours'), _('Worked by'), _('Worked On'), _('Description'), _('Entered'), _('Billable'), _('Overtime'), _('Invoiced')),'viewlink' => 'action=savehours&amp;projectid='.$_GET['projectid'].'&amp;hoursid=');
			else if($accessLevel > 0) $tasks = array('type' => 'data', 'title' => _('Hours'), 'header' => array(_('Hours'), _('Worked by'), _('Description'), _('Entered'), _('Overtime'), _('Billable'), _('Invoiced')), 'newlink' => 'action=savehours&amp;projectid='.intval($_GET['projectid']).'&amp;taskid='.intval($_GET['taskid']), 'viewlink' => 'action=savehours&amp;projectid='.$_GET['projectid'].'&amp;taskid='.$_GET['taskid'].'&amp;hoursid=');
			else $tasks = array('type' => 'data', 'title' => _('Hours'), 'header' => array(_('Hours'), _('Worked by'), _('Description'), _('Entered'), _('Overtime'), _('Invoiced')), 'newlink' => 'action=savehours&amp;projectid='.intval($_GET['projectid']).'&amp;taskid='.intval($_GET['taskid']));

			while(!$rs->EOF) {
				$tasks['data'][] = $rs->fields;
				$rs->MoveNext();
			}

			$bottomData[] = $tasks;

			$smarty->assign('view', true);
			$smarty->assign('leftData', $leftData);
			$smarty->assign('rightData', $rightData);
			$smarty->assign('rightSpan', $rightSpan);
			$smarty->assign('bottomData', $bottomData);

		} else {
			$smarty->assign('errors', array(_('There was a temporary error trying to retrieve the task details. Please try again later. If the problem persists please contact your system administrator')));
		}
	} else {
		$smarty->assign('errors', array(_('You do not have the correct permissions to access this task. If you believe you should please contact your system administrator')));
	}
?>
