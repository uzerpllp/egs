<?php  
/* This is set to try if the company was saved */
$saved = false;
$select = false;
$id = null;

/* Set the id if set */
if (isset ($_GET['taskid']))
	$id = intval($_GET['taskid']);
if (isset ($_POST['id']))
	$id = ($_POST['id']);
if (isset ($_GET['projectid']))
	$projectId = intval($_GET['projectid']);
if (isset ($_POST['projectid']))
	$projectId = ($_POST['projectid']);
	
if (in_array('projects', $_SESSION['modules']) && ($project->accessLevel($projectId) > 0)) {

/* Do a save if the form has been posted */
if (sizeof($_POST) > 0) {
	/* Check the post array */
	$egs->checkPost();

	if(isset($_POST['delete'])) {
		$project->deleteTask($_POST['projectid'], $id);
		$smarty->assign('redirect', true);
		$smarty->assign('redirectAction', 'action=view&amp;id='.$_POST['projectid']);
		return;
	}
	else $saved = $project->saveTask($_POST, $id);
} else {
	if (isset ($_GET['assubtaskid']))
	$_POST['parenttaskid'] = $_GET['assubtaskid'];
}

if ($saved) {
	$smarty->assign('redirect', true);
	$smarty->assign('redirectAction', 'action=viewtask&amp;projectid='.$_POST['projectid'].'&amp;taskid='.$_POST['id']);
} else
	if ($project->accessLevel($projectId) < 1) {
		$smarty->assign('errors', array (_('You do not have the correct permissions to add a task to this project. If you beleive you should please contact your system administrator')));
		$smarty->assign('redirect', true);
		$smarty->assign('redirectAction', 'action=view&amp;id='.$projectId);
	} else {
		/* Set up arrays to hold form elements */
		$leftForm = array ();
		$rightForm = array ();
		$bottomForm = array ();

		if (isset ($id)) {
			require_once (EGS_FILE_ROOT.'/src/classes/class.project.php');

			$project = new project();

			if (($project->accessLevel($projectId) > 0) && (sizeof($_POST) == 0)) {
				$query = 'SELECT * FROM taskoverview WHERE id='.$db->qstr($id);

				$_POST = $db->GetRow($query);

				$select = true;
			} else {
				$smarty->assign('errors', array (_('You do not have the correct access to edit this task. If you believe you should please contact your system administrator')));
				$smarty->assign('redirect', true);
				$smarty->assign('redirectAction', 'action=viewtask&amp;projectid='.$projectId.'&amp;taskid='.$id);
			}
		}
		
		$hidden = array();
		if(isset($id)) $hidden['id'] = $id;
		if(isset($projectId)) $hidden['projectid'] = $projectId;
	
		$smarty->assign('hidden', $hidden);

		/* Set up the title */
		if (isset ($id))
			$smarty->assign('pageTitle', _('Save Changes to Task'));
		else
			$smarty->assign('pageTitle', _('Save New Task'));

		/* Build the form */

		/* Setup the task name */
		$item = array ();
		$item['type'] = 'text';
		$item['tag'] = _('Task Name');
		$item['name'] = 'name';
		if (isset ($_POST['name']))
			$item['value'] = $_POST['name'];
		$item['compulsory'] = true;

		$leftForm[] = $item;
		
		$item = array ();
		$item['type'] = 'checkbox';
		$item['tag'] = _('Milestone');
		$item['name'] = 'milestone';
		if (isset ($_POST['milestone']) && ($_POST['milestone'] != 'f'))
			$item['value'] = $_POST['milestone'];

		$leftForm[] = $item;

		/* Setup the sub tasks */
		$item = array ();

		$query = 'SELECT id, name FROM projecttask WHERE projectid='.$db->qstr($projectId).' AND id<>'.$db->qstr(intval($id)).' ORDER BY name';

		$tasks = $db->Execute($query);

		if (!$tasks && EGS_DEBUG_SQL)
			die($db->ErrorMsg());

		$item['options'] = array ();
		$item['options'][''] = _('None');

		while (!$tasks->EOF) {
			$item['options'][$tasks->fields['id']] = $tasks->fields['name'];
			$tasks->MoveNext();
		}

		$item['type'] = 'select';
		$item['tag'] = _('Sub task of');
		$item['name'] = 'parenttaskid';
		if (isset ($_POST['parenttaskid']))
			$item['value'] = $_POST['parenttaskid'];

		$leftForm[] = $item;

		/* Setup the date fields */
		$item = array ();
		$item['type'] = 'date';
		$item['tag'] = _('Start Date');
		$item['name'] = 'startdate';
		$item['format'] = EGS_DATE_FORMAT;
		if (isset ($_POST['startdate'])) {
			$item['actualvalue'] = $_POST['startdate'];
			$item['value'] = date(str_replace('%', '', EGS_DATE_FORMAT), strtotime($_POST['startdate']));
		}
		$item['compulsory'] = true;

		$leftForm[] = $item;

		$item = array ();
		$item['type'] = 'date';
		$item['tag'] = _('End Date');
		$item['name'] = 'enddate';
		$item['format'] = EGS_DATE_FORMAT;
		if (isset ($_POST['enddate'])) {
			$item['actualvalue'] = $_POST['enddate'];
			$item['value'] = date(str_replace('%', '', EGS_DATE_FORMAT), strtotime($_POST['enddate']));
		}
		$item['compulsory'] = true;

		$leftForm[] = $item;
		
		$item = array ();
		$item['options'] = array('hours' => _('Hours'), 'days' => _('Days'));
		$item['type'] = 'splitselect';
		$item['tag'] = _('Duration');
		$item['name'] = 'duration';
		
		/* Split the database duration if set */
		if(isset($_POST['duration']) && ($_POST['duration'] == '00:00:00')) unset($_POST['duration']);
		else if(isset($_POST['duration']) && !isset($_POST['durationselect'])) {
			$tmpDuration = explode(' ', $_POST['duration']);
			
			$_POST['duration'] = $tmpDuration[0];
			if(isset($tmpDuration[1])) $_POST['durationselect'] = $tmpDuration[1];	
		}
		
		if (isset ($_POST['duration']))
			$item['value'] = $_POST['duration'];
		if (isset ($_POST['durationselect']))
			$item['selectvalue'] = $_POST['durationselect'];

		$leftForm[] = $item;

		/* Setup the cost */
		$item = array ();
		$item['type'] = 'text';
		$item['tag'] = _('Budget');
		$item['name'] = 'cost';
		if (isset ($_POST['cost']))
			$item['value'] = $_POST['cost'];

		$rightForm[] = $item;

		$item = array ();

		$query = 'SELECT id, name FROM projecttaskpriority WHERE projectid='.$db->qstr($projectId).' ORDER BY name';

		$priority = $db->Execute($query);

		if (!$priority && EGS_DEBUG_SQL)
			die($db->ErrorMsg());

		$item['options'] = array ();
		$item['options'][''] = _('None');

		while (!$priority->EOF) {
			$item['options'][$priority->fields['id']] = $priority->fields['name'];
			$priority->MoveNext();
		}

		$item['type'] = 'select';
		$item['tag'] = _('Priority');
		$item['name'] = 'priorityid';
		if (isset ($_POST['priorityid']))
			$item['value'] = $_POST['priorityid'];

		$rightForm[] = $item;
		
		$item = array ();
		$item['type'] = 'text';
		$item['min'] = '0';
		$item['max'] = '100';
		$item['maxlength'] = '3';
		$item['post'] = '%';
		$item['tag'] = _('Progress');
		$item['name'] = 'progress';
		if (isset ($_POST['progress']))
			$item['value'] = $_POST['progress'];

		$rightForm[] = $item;
		
		$item = array ();

		$query = 'SELECT id, name FROM resourceoverview WHERE projectid='.$db->qstr($projectId).' ORDER BY name';

		$resource = $db->Execute($query);

		if (!$resource && EGS_DEBUG_SQL)
			die($db->ErrorMsg());

		$item['options'] = array ();

		while (!$resource->EOF) {
			$item['options'][$resource->fields['id']] = $resource->fields['name'];
			$resource->MoveNext();
		}

		$item['type'] = 'multiple';
		$item['tag'] = _('Resources');
		$item['name'] = 'resources[]';
		$item['rowspan'] = '3';
		if (isset ($_POST['resources']))
			$item['value'] = $_POST['resources'];

		$rightForm[] = $item;
		
		$item = array ();
		$item['type'] = 'text';
		$item['tag'] = '';

		$rightForm[] = $item;

		$item = array ();
		$item['type'] = 'text';
		$item['tag'] = '';

		$rightForm[] = $item;

		/* Setup the descrption */
		$item = array ();
		$item['type'] = 'area';
		$item['tag'] = _('Description');
		$item['name'] = 'description';
		if (isset ($_POST['description']))
			$item['value'] = $_POST['description'];

		$bottomForm[] = $item;

		/* Assign the form variable */
		$smarty->assign('form', true);
		$smarty->assign('leftForm', $leftForm);
		$smarty->assign('rightForm', $rightForm);
		$smarty->assign('bottomForm', $bottomForm);
		$smarty->assign('formId', 'saveform');

	}
} else {
	$smarty->assign('redirect', true);
	$smarty->assign('redirectAction', 'action=view&amp;id='.$projectId);
	$smarty->assign('errors', array (_('You do not have the correct permissions to edit a this projects tasks. If you beleive you should please contact your system administrator.')));
}
?>
