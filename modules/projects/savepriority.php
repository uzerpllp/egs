<?php
	/* This is set to try if the company was saved */
	$saved = false;
	$select = false;
	$id = null;

	/* Set the id if set */
	if(isset($_GET['projectid'])) $projectId = intval($_GET['projectid']);
	if(isset($_POST['projectid'])) $projectId = intval($_POST['projectid']);
	if(isset($_GET['id'])) $priorityd = intval($_GET['id']);
	if(isset($_POST['id'])) $priorityId = ($_POST['id']);

	/* Do a save if the form has been posted */
	if(sizeof($_POST) >0) {
		/* Check the post array */
		$egs->checkPost();

		require_once(EGS_FILE_ROOT.'/src/classes/class.project.php');

		$project = new project();
		
		if(isset($_POST['delete'])) {
			$project->deletePriority($projectId, $priorityId);
			$saved = true;
		}
		else if(isset($priorityId)) $saved = $project->savePriority($_POST, $priorityId);
		else  $saved = $project->savePriority($_POST);
	}

	if($saved) {
		$smarty->assign('redirect', true);
		if(isset($_POST['taskid'])) $smarty->assign('redirectAction', 'action=view&amp;id='.$_POST['projectid']);
		else $smarty->assign('redirectAction', 'action=view&amp;id='.$_POST['projectid']);		
	} else {
	/* Set up arrays to hold form elements */
	$leftForm = array();
	$rightForm = array();
	$bottomForm = array();

	require_once(EGS_FILE_ROOT.'/src/classes/class.project.php');

	$project = new project();
		
	if(isset($priorityId)) {

		if(($project->accessLevel($projectId) > 0) && (sizeof($_POST) == 0)) {	
			$query = 'SELECT * FROM projecttaskpriority WHERE id='.$db->qstr($priorityId).' AND projectid='.$db->qstr($projectId);

			$_POST = $db->GetRow($query);

			$select = true;
		} else if ($project->accessLevel($projectId) < 0) {
			$smarty->assign('error', array(_('You do not have the correct access to edit this priority. If you believe you should please contact your system administrator')));
			$smarty->assign('redirect', true);
			$smarty->assign('redirectAction', 'action=view&amp;id='.$projectId);		
		}
	}

	$hidden = array();
	if(isset($priorityId)) $hidden['id'] = $priorityId;
	if(isset($projectId)) $hidden['projectid'] = $projectId;
	
	$smarty->assign('hidden', $hidden);
		
	/* Set up the title */
    if(isset($hoursId)) $smarty->assign('pageTitle',  _('Save Changes to Priority'));
    else $smarty->assign('pageTitle', _('Save New Priority'));    

    /* Build the form */
    
        if(isset($taskId)) {
                $query = 'SELECT name FROM projecttask WHERE projectid='.$db->qstr($projectId).' AND id='.$db->qstr($taskId);

                $_POST['taskname'] = $db->GetOne($query);    
        }

        $item = array ();

		$query = 'SELECT id, name FROM projecttask WHERE projectid='.$db->qstr($projectId).' ORDER BY name';

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
		$item['tag'] = _('Task');
		$item['name'] = 'taskid';
		if (isset ($taskId))
			$item['value'] = $taskId;

		$leftForm[] = $item;

        $item = array();
        $item['type'] = 'checkbox';
        $item['tag'] = _('Billable');
        $item['name'] = 'billable';
        if(isset($_POST['billable']) && (($_POST['billable'] == 'on') || ($_POST['billable'] == 't'))) $item['value'] = true;
        
        $leftForm[] = $item;
        
        $item = array();
        $item['type'] = 'checkbox';
        $item['tag'] = _('Overtime');
        $item['name'] = 'overtime';
        if(isset($_POST['overtime']) && (($_POST['overtime'] == 'on') || ($_POST['overtime'] == 't'))) $item['value'] = true;
        
        $leftForm[] = $item;
        
        if($project->accessLevel($projectId) > 0) {
	        $item = array();
	        $item['type'] = 'checkbox';
	        $item['tag'] = _('Invoiced');
	        $item['name'] = 'invoiced';
	        if(isset($_POST['invoiced']) && (($_POST['invoiced'] == 'on') || ($_POST['invoiced'] == 't'))) $item['value'] = true;
	        
	        $leftForm[] = $item;
        }
        
	    $item = array ();
		$item['type'] = 'text';
		$item['compulsory'] = true;
		$item['maxlength'] = '9';
		$item['maxlength2'] = '2';
		$item['tag'] = _('Hours:Mins');
		$item['middle'] = ':';
		$item['name'] = 'hours';
		$item['name2'] = 'minutes';
		if (isset ($_POST['hours'])) {
			$item['value'] = $_POST['hours'];
			if (!isset ($_POST['minutes'])) $item['value2'] = '00';
		}
		if (isset ($_POST['minutes']))
			$item['value2'] = $_POST['minutes'];
	
	    $rightForm[] = $item;
	    
	    $item = array ();
		$item['type'] = 'date';
		$item['tag'] = _('Entered');
		$item['name'] = 'entered';
		$item['format'] = EGS_DATE_FORMAT;
		if (isset ($_POST['entered'])) {
			$item['actualvalue'] = $_POST['entered'];
			$item['value'] = date(str_replace('%', '', EGS_DATE_FORMAT), strtotime($_POST['entered']));
		} else {
			$item['actualvalue'] = date('Y-m-d H:i:s', time());
			$item['value'] = date(str_replace('%', '', EGS_DATE_FORMAT), time());
		}
		
		$item['compulsory'] = true;

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
?>
