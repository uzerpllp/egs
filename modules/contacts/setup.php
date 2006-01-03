<?php

	if(isset($_GET['page'])) $_SESSION['setup_page'] = max(1, intval($_GET['page']));
	if(!isset($_SESSION['setup_page'])) $_SESSION['setup_page'] = 1;
if(EGS_CRMADMIN) {
	$setupCatArray = array(
					'crmactivity'=>array('name'=>_('Activity Types'),'title'=>_('Activity Type')),
					'crmindustry'=>array('name'=>_('Industries'),'title'=>_('Industry')),
					'crmcasetype'=>array('name'=>_('Case Types'),'title'=>_('Case Type')),
					'crmcompanysource'=>array('name'=>_('Company Sources'),'title'=>_('Company Source')),
					'crmstatus' => array('name'=>_('CRM Statuses'),'title'=>_('CRM Status')),
					'crmaccountstatus'=>array('name'=>_('Account Statuses'),'title'=>_('Account Status')),
					'crmrating' => array('name'=>_('Ratings'),'title'=>_('Rating')),
					'crmopportunity'=> array('name'=>_('Opportunity Statuses'),'title'=>_('Opportunity Status')),
					'crmcasetype' => array('name'=>_('Case Types'),'title'=>_('Case Type')),
					'crmcasestatus' => array('name'=>_('Case Statuses'),'title'=>_('Case Status')),
					'crmcasepriority' => array('name'=>_('Case Priorities'),'title'=>_('Case Priority')),
					'crmcampaigntype' => array('name'=>_('Campaign Types'),'title'=>_('Campaign Type')),
					'crmcampaignstatus' => array('name'=>_('Campaign Statuses'),'title'=>_('Campaign Status')),
					'contactcategories' => array('name'=>_('Contact Categories'),'title'=>_('Contact Category'))
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
			else if(!isset($_GET['category'])) $_GET['category']='crmactivity';
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
					
					if(isset($_POST['dissallowinvoices'])) $catarray['dissallowinvoices']=$_POST['dissallowinvoices'];
					if(isset($_POST['description'])) $catarray['description']=$_POST['description'];
					else if($_GET['category']=='crmopportunity')$catarray['description']='';
					if(isset($_POST['open'])) $catarray['open']=$_POST['open'];
					
					if(!$db->Replace($_GET['category'],$catarray,array('id'),true))
						$errors[] = _('Error updating category');
						
					$messages = _('Updated Successfully');
					unset($_POST);
					unset($_GET['id']);
				}
				else {
					
					$errors[] = _('You don\'t have permission to edit the CRM categories for this company');
					
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
	$temparray=array();
	foreach($setupCatArray as $key=>$val) {
		
		$temparray[$key] = $val['name'];	
	}
	$smarty->assign('setupCat',$temparray);
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
		$currentCategory= 'crmactivity';
	}
	$smarty->assign('currentCat',$currentCategory);
	
	if(isset($currentCategory)&&!array_key_exists($currentCategory,$setupCatArray)) {
				$errors[] = _('Invalid category');
				$smarty->assign('errors',$errors);
				
	}
	if(count($errors)==0) {
		/* Set the page title */
		
		$title=$setupCatArray[$currentCategory]['name'];
		$smarty->assign('pageTitle', _('Setup: '.$title));
		
		/*Assign the table headings*/
		$headings=array();
		$headings[] = _('Name');
		if($currentCategory=='crmopportunity') {
			$headings[]=_('Description');
			$headings[]=_('Open Status');
		}
		if($currentCategory=='crmaccountstatus') {
			$headings[]=_('Disallow Invoices');	
		}
		$smarty->assign('headings',$headings);
		$db->setFetchMode(ADODB_FETCH_NUM);
		/*get data for rows*/
		$q = 'SELECT id, name';
		if($currentCategory=='crmopportunity')
		$q.= ',description, CASE WHEN open='.$db->qstr('t').' THEN '.$db->qstr('Open').' ELSE '.$db->qstr('Closed').' END as open';
		if($currentCategory=='crmaccountstatus')
		$q.= ', CASE WHEN dissallowinvoices=1 THEN '.$db->qstr(_('Yes')).' ELSE '.$db->qstr(_('No')).' END AS dissallowinvoices';
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
		else { $currentCat='crmactivity'; $mode='New';}
		/*set the title of the edit form*/
				
		switch($currentCat) {
			case "crmactivity" : $title = _('Activity'); break;
			case "crmindustry" : $title = _('Industry'); break;
			case "crmcasetype" : $title = _('Case Type'); break;
			case "crmcompanysource" : $title = _('Company Source'); break;
			case "crmstatus" : $title = _('CRM Status'); break;
			case "crmaccountstatus" : $title = _('Account Status'); break;
			case "crmrating" : $title = _('Rating'); break;
			case "crmopportunity" : $title = _("Opportunity Status"); break;
			case "crmcasetype" : $title = _('Case Type'); break;
			case "crmcasestatus" : $title = _('Case Status'); break;
			case "crmcasepriority" : $title = _('Case Priority'); break;
			case "crmcampaigntype" : $title = _('Campaign Type'); break;
			case "crmcampaignstatus" : $title = _('Campaign Status'); break;
			case "contactcategories" : $title = _('Contact Category'); break;
			
			
			default : $title = _('Category Item');
		}
		$title = $setupCatArray[$currentCat]['title'];
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
		if($currentCat=='crmaccountstatus') {
			$item = array();
			$item['type'] = 'select';
			$item['name'] = 'dissallowinvoices';
			$item['tag'] = _('Disallow Invoices');
			$item['options'] = array('0'=>_('No'),'1'=>_('Yes'));
			if(isset($_POST['dissallowinvoices']))
				$item['value'] = $_POST['dissallowinvoices'];
			$editForm[] = $item;
		}
		/*Opportunity status has a boolean for 'open', and a textarea for description*/
		if($currentCat=='crmopportunity') {
			$item=array();
			$item['type'] = 'select';
			$item['name'] = 'open';
			$item['tag'] = _('Open Status');
			$item['options'] = array('t'=>_('Open'),'f'=>_('Closed'));
			if(isset($_POST['open']))
				$item['value'] = $_POST['open'];
			$editForm[] = $item;
			
			
			$item = array();
			$item['type'] = 'textarea';
			$item['name'] = 'description';
			$item['tag'] = _('Description');
			if(isset($_POST['description']))
				$item['value'] = $_POST['description'];
			$editForm[] = $item;
		}
		$smarty->assign('editForm',$editForm);
	}
	else {
		$errors=array();
		
	$errors[] = _('The category doesn\'t exist');
	$smarty->assign('errors',$errors);
	$smarty->assign('redirect',true);
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