<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Save Section 1.0                 |
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

/* Check user has access to the store module */
if (in_array('domain', $_SESSION['modules'])) {
	
	/* This is set to try if the product was saved */
	$saved = false;
	$select = false;
	$id = null;
	$clicked=false;
	/* Set the id if set */
	if (isset ($_GET['commentid']))
		$id = intval($_GET['commentid']);
	if (isset ($_POST['id']))
		$id = ($_POST['id']);

	require_once (EGS_FILE_ROOT.'/src/classes/class.domain.php');

	$domain = new domain();

	/* Do a save/delete if the form has been posted */
	if (sizeof($_POST) > 0) {
		/* Check the post array */
		$egs->checkPost();
		$clicked=true;
		if (isset ($_POST['delete']))
			$saved = $domain->deleteComment($id);
		else
			$saved = $domain->saveComment($_POST, $id);
	}

	if ($saved) {
		
		$smarty->assign('redirect', true);
		if (isset ($_POST['delete'])) {
			$smarty->assign('messages', array ('Comment successfully deleted'));
			
			$smarty->assign('redirectAction', 'action=view&amp;id='.$_GET['domainid']);
		}
		else {
			$smarty->assign('messages', array ('Comment successfully saved'));
		
			$smarty->assign('redirectAction', 'action=view&amp;id='.$_GET['domainid']);
		}
	} else {
		
		/* Set up arrays to hold form elements */
		$leftForm = array ();
		$rightForm = array ();
		$bottomForm = array ();
		
		if (isset ($id)&&!$clicked) {
			$q = 'SELECT * FROM forumpost WHERE id='.$db->qstr($id).' AND companyid='.EGS_COMPANY_ID;
			$_POST = $db->GetRow($q);
						
		}

		/* Set up the title and delete button */
		if (isset ($id)) {
			$smarty->assign('pageTitle', _('Save Changes to Comment'));
			$smarty->assign('formDelete', true);
		} else
			$smarty->assign('pageTitle', _('Save New Comment'));

		/* Build the form */
		$hidden = array ();
		if (isset ($id))
			$hidden['id'] = $id;
		
			
		$smarty->assign('hidden', $hidden);
		
		$item=array();
		$item['name']='title';
		$item['type']='text';
		$item['tag']=_('Title:');
		if(isset($_POST['title']))
			$item['value']=$_POST['title'];
		
		$leftForm[]=$item;
		
		$item=array();
		$item['name']='forumpostid';
		$item['type']='select';
		$item['tag']=_('Parent:');
		$item['options']=array();
		$query = 'SELECT id, title FROM forumpost WHERE companyid='.EGS_COMPANY_ID.' AND forumpostid IS NULL';
		$rs=$db->execute($query);
		while(!$rs->EOF) {
			$item['options'][$rs->fields['id']]=$rs->fields['title'];
			$rs->MoveNext();
		}
		if(isset($_POST['forumpostid']))
			$item['value']=$_POST['forumpostid'];
		
		$leftForm[]=$item;
		
		$item=array();
		$item['name']='approved';
		$item['type']='select';
		$item['options']=array('yes'=>'Yes','no'=>'No');
		$item['tag']=_('Approve:');
		if($_POST['approved']=='t')
			$item['value']='yes';
		else
			$item['value']='no';
		
		$leftForm[]=$item;
		
		$item=array();
		$item['name']='message';
		$item['type']='area';
		$item['tag']=_('Message:');
		if(isset($_POST['message']))
			$item['value']=$_POST['message'];
		
		$bottomForm[]=$item;
		$smarty->assign('forceSave', true);
		$smarty->assign('form', true);
		$smarty->assign('leftForm', $leftForm);
		$smarty->assign('rightForm', $rightForm);
		$smarty->assign('bottomForm', $bottomForm);
		$smarty->assign('formFile', true);
		$smarty->assign('formId', 'saveform');
		
		
	}
}
?>