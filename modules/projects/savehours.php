<?php
	/* This is set to try if the company was saved */
	$saved = false;
	$select = false;
	$id = null;

	/* Set the id if set */
	if(isset($_GET['projectid'])) $projectId = intval($_GET['projectid']);
	if(isset($_POST['projectid'])) $projectId = intval($_POST['projectid']);
	if(isset($_GET['taskid'])) $taskId = intval($_GET['taskid']);
	if(isset($_POST['taskid'])) $taskId = intval($_POST['taskid']);
	if(isset($_GET['hoursid'])) $hoursId = intval($_GET['hoursid']);
	if(isset($_POST['hoursid'])) $hoursId = intval($_POST['hoursid']);
	if(isset($_GET['id'])) $id = intval($_GET['id']);
	if(isset($_POST['id'])) $id = ($_POST['id']);
	if(isset($_POST['companyid'])) $companyId = ($_POST['companyid']);
	
/*if the person looking at the page is a client, then they shouldn't be able to add hours*/
	$q = 'SELECT owner FROM personoverview WHERE owner='.$db->qstr(EGS_USERNAME).' AND companyid='.$db->qstr(EGS_COMPANY_ID);
	
	if(!$db->GetOne($q)) {
		$isClient=true;
			
	}
	else $isClient=false;
if (!$isClient && in_array('projects', $_SESSION['modules']) && (((isset ($projectId) && ($project->accessLevel($projectId) > 0))) || (!isset($hoursId) && ($project->accessLevel($projectId) >= 0)))) {
	/* Do a save if the form has been posted */
	if(sizeof($_POST) >0) {
		/* Check the post array */
		$egs->checkPost();
		
		if(isset($_POST['delete'])) {
			$project->deleteHours($projectId, $hoursId);
			$saved = true;
		}
		else if(isset($hoursId)) $saved = $project->saveHours($_POST, $hoursId);
		else  $saved = $project->saveHours($_POST);
	}

	if($saved) {
		$smarty->assign('redirect', true);
		if(isset($_POST['taskid'])) $smarty->assign('redirectAction', 'action=viewtask&amp;projectid='.$_POST['projectid'].'&amp;taskid='.$_POST['taskid']);
		else $smarty->assign('redirectAction', 'action=view&amp;id='.$_POST['projectid']);		
	} else {
	/* Set up arrays to hold form elements */
	$leftForm = array();
	$rightForm = array();
	$bottomForm = array();

		
	if(isset($hoursId)) {
		$smarty->assign('formDelete', true);
		if(($project->accessHours($hoursId, $projectId) > 0) && (sizeof($_POST) == 0)) {	
			$query = 'SELECT * FROM projecthours WHERE id='.$db->qstr($hoursId).' AND projectid='.$db->qstr($projectId);
			
			if(isset($taskId)) $query .= ' AND taskid='.$db->qstr($taskId);

			$_POST = $db->GetRow($query);

			if($_POST['taskid'] != '') $taskId = $_POST['taskid'];
			$select = true;
		} else if ($project->accessHours($hoursId, $projectId) < 0) {
			$smarty->assign('error', array(_('You do not have the correct access to edit this resource. If you believe you should please contact your system administrator')));
			$smarty->assign('redirect', true);
			$smarty->assign('redirectAction', 'action=view&amp;id='.$projectId);		
		}
	}
	
	$hidden = array();
	if(isset($hoursId)) $hidden['id'] = $hoursId;
	if(isset($projectId)) $hidden['projectid'] = $projectId;
	if(isset($taskId)) $hidden['taskid'] = $taskId;
	
	$smarty->assign('hidden', $hidden);
		
	/* Set up the title */
    if(isset($hoursId)) $smarty->assign('pageTitle',  _('Save Changes to Hours'));
    else $smarty->assign('pageTitle', _('Save New Hours'));    

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
			$hours = explode(':', $_POST['hours']);
			$item['value'] = $hours[0];
			if (!isset ($hours[1])) $item['value2'] = '00';
			else $item['value2']=$hours[1];
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
} else {
	$smarty->assign('redirect', true);
	$smarty->assign('redirectAction', 'action=view&amp;id='.$projectId);
	$smarty->assign('errors', array (_('You do not have the correct permissions to edit the project hours. If you beleive you should please contact your system administrator.')));
}?>
