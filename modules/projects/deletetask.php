<?php
require_once (EGS_FILE_ROOT.'/src/classes/class.project.php');

$project = new project();

if($project->deleteTask($_GET['projectid'], $_GET['taskid'])) {
	$smarty->assign('messages', array(_('Task successfully deleted')));
} else {
	$smarty->assign('errors', array(_('You do not have the correct permissions to delete this task. If you believe you should please contact your system administrator.')));
}

$smarty->assign('redirect', true);
$smarty->assign('redirectAction', 'action=view&amp;id='.$_GET['projectid']);
?>
