<?php

	if(isset($_GET['page'])) $_SESSION['setup_page'] = max(1, intval($_GET['page']));
	if(!isset($_SESSION['setup_page'])) $_SESSION['setup_page'] = 1;
if(EGS_PROJECTMANAGER) {
	$setupCatArray = array(
					'jobcategories' => 'Job Categories'
				);
	/*if a label is being changed*/
	$errors=array();
	$messages = array();
	if(count($_POST)>0) {
		
		$egs->checkPost();
		
		if(isset($_POST['delete'])&&count($_POST['delete'])>0) {
			if(isset($_POST['category'])&&!array_key_exists($_POST['category'],$setupCatArray)) {
				$errors[] = _('Invalid category');
			}
			if(count($errors)==0) {
				while(list($key, $val) = each($_POST['delete'])) {
					$query = 'DELETE FROM '.$_POST['category'].' WHERE id='.$db->qstr($val).' AND companyid='.$db->qstr(EGS_COMPANY_ID);
					
					$db->Execute($query);
					$messages[] = _('Deleted Successfully');
				}
			}
			if(count($errors)>0)
				$smarty->assign('errors',$errors);
			else	
				$smarty->assign('messages',$messages);
		
		}//end if delete>0
		
		if (isset($_POST['editSetup'])) {
			
			if(isset($_GET['category'])&&!array_key_exists($_GET['category'],$setupCatArray)) {
				$errors[] = _('Invalid category');
			}
			
			if(!isset($_GET['category'])&&isset($_POST['category']))$_GET['category']=$_POST['category'];
			else if(!isset($_GET['category'])) $_GET['category']='jobcategories';
			if(isset($_GET['id'])&&isset($_GET['category']))	{
				$q = 'SELECT id FROM '.$_GET['category'].' WHERE id='.$db->qstr($_GET['id']).' AND companyid='.$db->qstr(EGS_COMPANY_ID);
			}
			if(count($errors)==0) {
				if(!isset($_GET['id']) || $db->GetOne($q) ) {
					
					
					
					$catarray = array();
					if(!isset($_GET['id'])) {
						$id = $db->GenID($_GET['category'].'_id_seq');	
						
					}
					else $id=$_GET['id'];
					$catarray['id'] = $id;
					$catarray['name'] = $_POST['name'];
					$catarray['companyid']=EGS_COMPANY_ID;
					
					if(!$db->Replace($_GET['category'],$catarray,array('id'),true))
						$errors[] = _('Error updating category');
						
					$messages = _('Updated Successfully');
					unset($_POST);
					unset($_GET['id']);
				}
				else {
					
					$errors[] = _('You don\'t have permission to edit the job categories for this company');
					
				}
			}
			if(count($errors)>0)
				$smarty->assign('errors',$errors);
			else	
				$smarty->assign('messages',$messages);
		
		}//end if editsubmit
	}//end if post>0
	$errors=array();
	/*so now display the page*/
	$smarty->assign('setup',true);
	/*add things to the select menu*/
	
	$smarty->assign('setupCat',$setupCatArray);
	/*get the current category*/
	/*if there's a get set, then use that otherwise use post*/
	if(isset($_GET['category'])) {
		$currentCategory = $_GET['category'];
		
	} 
	else if(isset($_POST['category'])) {
		$smarty->assign('currentCat',$_POST['category']);
		$currentCategory = $_POST['category'];
	}
	else {
		$currentCategory= 'jobcategories';
	}
	$smarty->assign('currentCat',$currentCategory);
	
	if(isset($currentCategory)&&!array_key_exists($currentCategory,$setupCatArray)) {
				$errors[] = _('Invalid category');
				$smarty->assign('errors',$errors);
				
				
	}
	if(count($errors)==0) {
		/* Set the page title */
		
		$title=$setupCatArray[$currentCategory];
		$smarty->assign('pageTitle', _('Setup: '.$title));
		
		/*Assign the table headings*/
		$headings=array();
		$headings[] = _('Name');
		
		$smarty->assign('headings',$headings);
		$db->setFetchMode(ADODB_FETCH_NUM);
		/*get data for rows*/
		$q = 'SELECT id, name';
		$q.=' FROM '.$currentCategory. ' WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY name';
		
		$egs->page($q,'setup_page');
		
		
		/*Do the stuff on the right*/
		if(isset($_GET['id'])&&!isset($_POST['category'])) {
			$edit=true;
			/*fill $_POST with the values for the item being viewed*/
			$q = 'SELECT * from '.$_GET['category'].' WHERE id='.$db->qstr($_GET['id']).' AND companyid='.$db->qstr(EGS_COMPANY_ID);
			
			$_POST = $db->GetRow($q);	
			$mode = "Edit";
			$currentCat=$_GET['category'];
		}
		else if(isset($_POST['category'])){ 
			$mode="New";
			$currentCat = $_POST['category'];
		}
		else { $currentCat='jobcategories'; $mode='New';}
		/*set the title of the edit form*/
				
		switch($currentCat) {
			case "jobcategories" : $title = _('Job Category'); break;
			default : $title = _('Category Item');
		}
		
		$smarty->assign('editSetupTitle',$mode." ".$title);
		$editForm=array();
		
		$item=array();
		$item['type']  = 'text';
		$item['name']  = 'name';
		$item['tag']   =  _('Name');
		if(isset($_POST['name'])) {
			
			$item['value'] = $_POST['name'];
			
		}
		$editForm[] = $item;
		
		/*special cases for tables with other fields*/
		/*account status has a yes/no for disallowinvoices*/
		
		$smarty->assign('editForm',$editForm);
	}
	else {
		$errors=array();
	
	$errors[] = _('The category doesn\'t exist');
	$smarty->assign('errors',$errors);
	//$smarty->assign('redirect',true);
	$smarty->assign('redirectAction','');	
		
	}
}
else {
	$errors=array();
	$errors[] = _('You do not have access to view this page');
	$smarty->assign('errors',$errors);
	
	$smarty->assign('redirect',true);
	$smarty->assign('redirectAction','');	
	
}




?>