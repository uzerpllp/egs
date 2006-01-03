<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Save Person Resource 1.0         |
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
// |
// | 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA               |
// +----------------------------------------------------------------------+
// | Author: Jake Stride <jake.stride@senokian.com>                       |
// +----------------------------------------------------------------------+
// | Changes:                                                             |
// |                                                                      |
// | 1.0                                                                  |
// | ===                                                                  |
// | Initial Stable Release                                               |
// +----------------------------------------------------------------------+
//
/* Set the project ID */
if(isset($_GET['projectid'])) $projectId = intval($_GET['projectid']);
if(isset($_POST['projectid'])) $projectId = ($_POST['projectid']);
	
if (in_array('projects', $_SESSION['modules']) && ((isset ($projectId) && ($project->accessLevel($projectId) > 0)))) {
	/* This is set to try if the resource was saved */
	$saved = false;
	$select = false;
	$id = null;

	/* Set the id if set */
	if(isset($_GET['id'])) $id = intval($_GET['id']);
	if(isset($_POST['id'])) $id = ($_POST['id']);
	if(isset($_POST['personid'])) $personId = ($_POST['personid']);

	/* Do a save if the form has been posted */
	if(sizeof($_POST) >0) {
		/* Check the post array */
		$egs->checkPost();
		
		if(isset($_POST['delete'])) $saved = $project->deleteResource($id, $projectId);
		else $saved = $project->saveResource($_POST, $id);
	}

	if($saved) {
		$smarty->assign('redirect', true);
		$smarty->assign('redirectAction', 'action=view&amp;id='.$_POST['projectid']);		
	} else {
	/* Set up arrays to hold form elements */
	$leftForm = array();
	$rightForm = array();
	$bottomForm = array();

	if(isset($id)) {

		/* Add the delete button if necessary */
		if($project->accessLevel($projectId) > 0) $smarty->assign('formDelete', true);
		
		if(($project->accessLevel($projectId) > 0) && (sizeof($_POST) == 0)) {	
			$query = 'SELECT * FROM resource WHERE projectid='.$db->qstr($projectId).' AND id='.$db->qstr($id);

			$_POST = $db->GetRow($query);

			$select = true;
		} else {
			$smarty->assign('error', array(_('You do not have the correct access to edit this resource. If you believe you should please contact your system administrator')));
			$smarty->assign('redirect', true);
			$smarty->assign('redirectAction', '');		
		}
	}

	$hidden = array();
	if(isset($id)) $hidden['id'] = $id;
	if(isset($projectId)) $hidden['projectid'] = $projectId;
	$hidden['companyid'] = '';
	
	$smarty->assign('hidden', $hidden);
		
	/* Set up the title */
    if(isset($id)) $smarty->assign('pageTitle',  _('Save Changes to Person Resource'));
    else $smarty->assign('pageTitle', _('Save New Person Resource'));    

    /* Build the form */
    
        if(isset($_POST['personid'])) {
                $query = 'SELECT firstname || \' \' || surname AS name FROM person WHERE id='.$db->qstr($_POST['personid']);

                $_POST['personname'] = $db->GetOne($query);    
        }

        $item = array();
        $item['type'] = 'person';
        $item['tag'] = _('Person');
        $item['name'] = 'person';
        $item['hide'] = 'company';
        if(isset($_POST['personid'])) $item['value'] = $_POST['personname'];
        if(isset($_POST['personid'])) $item['actualvalue'] = $_POST['personid'];

        $leftForm[] = $item;
        
        $item = array ();
		$item['type'] = 'checkbox';
		$item['tag'] = _('Project Manager');
		$item['name'] = 'projectmanager';
		if (isset ($_POST['projectmanager']) && ($_POST['projectmanager'] == 't'))
			$item['value'] = true;
	
	    $leftForm[] = $item;
        
	    $item = array ();
		$item['type'] = 'text';
		$item['maxlength'] = '9';
		$item['tag'] = _('Standard Rate');
		$item['name'] = 'standardrate';
		if (isset ($_POST['standardrate']))
			$item['value'] = $_POST['standardrate'];
	
	    $rightForm[] = $item;
	    
	    $item = array ();
		$item['type'] = 'text';
		$item['maxlength'] = '9';
		$item['tag'] = _('Overtime Rate');
		$item['name'] = 'overtimerate';
		if (isset ($_POST['overtimerate']))
			$item['value'] = $_POST['overtimerate'];
	
	    $rightForm[] = $item;


	/* Assign the form variable */
	$smarty->assign('form', true);
	$smarty->assign('leftForm', $leftForm);
	$smarty->assign('rightForm', $rightForm);
	$smarty->assign('formId', 'saveform');
	}
} else {
	$smarty->assign('redirect', true);
	$smarty->assign('redirectAction', 'action=view&amp;id='.$projectId);
	$smarty->assign('errors', array (_('You do not have the correct permissions to edit the project resources. If you beleive you should please contact your system administrator.')));
}
?>
