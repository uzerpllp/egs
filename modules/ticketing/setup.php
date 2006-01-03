<?php

	if(isset($_GET['page'])) $_SESSION['setup_page'] = max(1, intval($_GET['page']));
	if(!isset($_SESSION['setup_page'])) $_SESSION['setup_page'] = 1;
if(EGS_TICKETADMIN) {
	$setupCatArray = array();
	/*assign parent queue*/
	$setupCatArray['ticketqueue']=array('name'=>_('Ticket Queues'),'title'=>_('Activity Type'),'type'=>'queues');
	
	$q = 'SELECT id,name FROM ticketqueue WHERE companyid='.$db->qstr(EGS_COMPANY_ID);
	$queues = $db->Execute($q);
	while(!$queues->EOF) {
		$setupCatArray[$queues->fields['name']] = array('name'=>$queues->fields['name'],'type'=>'subqueues','id'=>$queues->fields['id']);
		$queues->MoveNext();	
	}
	if(isset($_REQUEST['category'])&&$setupCatArray[$_REQUEST['category']]['type']=='subqueues') {
		$queue=false;
	}
	else
		$queue=true;			
					
					
	/*if a label is being changed*/
	$errors=array();
	$messages = array();
	if(count($_POST)>0) {
		
		$egs->checkPost();
		
		if(isset($_POST['delete'])&&count($_POST['delete'])>0) {
			if($queue) {
				$errors[] = _('You can\'t delete queues');
			}
			if(isset($_POST['category'])&&!array_key_exists($_POST['category'],$setupCatArray)) {
				
				$errors[] = _('Invalid category');
			}
			if(count($errors)==0) {
				
				while(list($key, $val) = each($_POST['delete'])) {
					$query = 'DELETE FROM internalqueue WHERE id='.$db->qstr($val).' AND companyid='.$db->qstr(EGS_COMPANY_ID);
					$db->Execute($query);
					
				}
				$messages[] = _('Deleted Successfully');
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
			else if(!isset($_GET['category'])) $_GET['category']='ticketqueue';
			if(isset($_GET['id'])&&isset($_GET['category']))	{
				if(!$queue) {
					$q = 'SELECT id FROM internalqueue WHERE id='.$db->qstr($_GET['id']).' AND companyid='.$db->qstr(EGS_COMPANY_ID);
					
				}
				else {
					$q = 'SELECT id FROM '.$_GET['category'].' WHERE id='.$db->qstr($_GET['id']).' AND companyid='.$db->qstr(EGS_COMPANY_ID);
					
				}
			}
			if(count($errors)==0) {
				if(!isset($_GET['id']) || $db->GetOne($q) ) {
					
					if($queue) {
						if(!isset($_GET['id'])) {
							$errors[] = _('New queues have to be added from the System Admin\'s Menu');
						}
						else {
							/*setup the array for the query*/
							$queue = array();
							$queue['id']=$_GET['id'];
							if(isset($_POST['name'])&&$_POST['name']!='')$queue['name']=$_POST['name'];
							else
								$errors[] = _('No Name Entered');
								
							if(isset($_POST['actualaddress'])&&$_POST['actualaddress']!='')$queue['actualaddress']=$_POST['actualaddress'];
							else if(isset($_POST['address']))
								$queue['actualaddress']=$_POST['address'];
							else
								$errors[] = _('There Needs to be an email address entered');
								
							$queue['companyid'] = EGS_COMPANY_ID;
							
							if(isset($_POST['insertmessage'])) $queue['insertmessage']=$_POST['insertmessage'];
							else $queue['insertmessage'] = '';
							
							if(isset($_POST['updatemessage'])) $queue['updatemessage']=$_POST['updatemessage'];
							else $queue['updatemessage'] = '';
							
							if(isset($_POST['closemessage'])) $queue['closemessage']=$_POST['closemessage'];
							else $queue['closemessage'] = '';
							
							if(isset($_POST['sendreply'])) $queue['sendreply']='t';
							else $queue['sendreply']='f';
							
							
							if(count($errors)==0) {
								$db->StartTrans();
								
								if(!$db->Replace('ticketqueue',$queue,'id',true))
									$errors[] = _('Error Updating Queue');
								
								/*delete everyone from the access table*/
								$q = 'DELETE FROM ticketqueueadmin WHERE queueid='.$db->qstr($_GET['id']);
								$db->Execute($q);
																
								/*then re-add those selected*/
								$q = 'INSERT INTO ticketqueueadmin (username, queueid) VALUES (?,?)';
								$stmt = $db->Prepare($q);
								foreach ($_POST['users'] as $username) {
									$db->Execute($stmt,array($username,$_GET['id']));		
								}
										
								$db->CompleteTrans();
							}
							//print_r($_POST);
							
							unset($_POST['category']);
						}
					}//end if $queue
					else {
						$db->StartTrans();
						$subqueue = array();
						if(isset($_POST['name']))$subqueue['name']=$_POST['name'];
						else
							$errors[] = _('No Name Entered');
						
						if(isset($_POST['keywords'])) $subqueue['keywords']=$_POST['keywords'];
						if(isset($_POST['auto'])) $subqueue['auto']='t';
						else $subqueue['auto']='f';
						
						$subqueue['companyid'] = EGS_COMPANY_ID;
						/*if it's a new queue*/
						if(!isset($_GET['id'])) {
							/*assign an id*/
							$subqueue['id'] = $db->GenID('internalqueue_id_seq');
							/*get the parent queue id*/
							$q = 'SELECT id FROM ticketqueue WHERE name='.$db->qstr($_GET['category']);
							$subqueue['queueid']=$db->GetOne($q);
							if(!isset($subqueue['queueid']))
								$errors[] = _('A Sub-queue must be part of a queue');
						}
						else
							$subqueue['id'] = $_GET['id'];
						if(count($errors)==0) {
							if(!$db->Replace('internalqueue',$subqueue,'id',true))
								$errors[] = _('Error updating Sub-Queue');
						
							
						/*now do groups*/
							$q = 'DELETE FROM internalqueueuseraccessxref WHERE internalqueueid='.$db->qstr($subqueue['id']);
							$db->Execute($q);
																
							/*then re-add those selected*/
							$q = 'INSERT INTO internalqueueuseraccessxref (internalqueueid, username) VALUES (?,?)';
							$stmt = $db->Prepare($q);
							foreach ($_POST['users'] as $username) {
								$db->Execute($stmt,array($subqueue['id'],$username));		
							}
						
						/*and users*/
						$q = 'DELETE FROM internalqueuegroupaccessxref WHERE internalqueueid='.$db->qstr($subqueue['id']);
							$db->Execute($q);
																
							/*then re-add those selected*/
							$q = 'INSERT INTO internalqueuegroupaccessxref (internalqueueid, groupid) VALUES (?,?)';
							$stmt = $db->Prepare($q);
							foreach ($_POST['groups'] as $groupid) {
								$db->Execute($stmt,array($subqueue['id'],$groupid));		
							}
							$db->CompleteTrans();
						}
						unset($_POST['category']);
					}//end else if $queue (i.e. if $subqueue)
					
					
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
		if($val['name']=='Ticket Queues')
			$temparray[$key] = $val['name'];	
		else
			$temparray[$key] = '-'.$val['name'];
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
		$currentCategory= 'ticketqueue';
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
		if($setupCatArray[$currentCategory]['type']=='queues') {
			$queue=true;
			$smarty->assign('queue',true);
			$smarty->assign('hideToggle',true);
		}
		else {
			$queue=false;
			$smarty->assign('queue',false);	
		}
		if($queue)	
			$headings[] = _('E-Mail');
		
		
		$smarty->assign('headings',$headings);
		$db->setFetchMode(ADODB_FETCH_NUM);
		/*get data for rows*/
		
		
		if($queue) {
			$q = 'SELECT id, name, address FROM '.$currentCategory. ' WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY name';
		}
		else {
		$q = 'SELECT id, name FROM internalqueue WHERE queueid='.$db->qstr($setupCatArray[$currentCategory]['id']);	
			
		}
		
		$egs->page($q,'setup_page');
		
		
		/*Do the stuff on the right*/
		if(isset($_GET['id'])&&!isset($_POST['category'])) {
			$edit=true;
			/*fill $_POST with the values for the item being viewed*/
			if($queue) {
				$q = 'SELECT * FROM '.$_GET['category'].' WHERE id='.$db->qstr($_GET['id']).' AND companyid='.$db->qstr(EGS_COMPANY_ID);
			}
			else {
				$q = 'SELECT * FROM internalqueue WHERE id='.$db->qstr($_GET['id']).' AND companyid='.$db->qstr(EGS_COMPANY_ID);	
			}
			if(!isset($_POST['editSetup']))$_POST = $db->GetRow($q);	
			if($queue) {
				$q = 'SELECT username FROM ticketqueueadmin WHERE queueid='.$db->qstr($_GET['id']);
				$temp = array();
				$users = $db->Execute($q);
				while (!$users->EOF) {
					$temp[$users->fields['username']]=$users->fields['username'];
					$users->MoveNext();	
				}	
				if(!isset($_POST['editSetup']))$_POST['users']=$temp;
				
			}
			else {
				$q = 'SELECT username FROM internalqueueuseraccessxref WHERE internalqueueid='.$db->qstr($_GET['id']);
				$temp = array();
				$users = $db->Execute($q);
				while (!$users->EOF) {
					$temp[$users->fields['username']]=$users->fields['username'];
					$users->MoveNext();	
				}	
				if(!isset($_POST['editSetup']))$_POST['users']=$temp;
				
				$q = 'SELECT groupid FROM internalqueuegroupaccessxref WHERE internalqueueid='.$db->qstr($_GET['id']);
				
				$temp = array();
				$groups = $db->Execute($q);
				while (!$groups->EOF) {
					$temp[$groups->fields['groupid']]=$groups->fields['groupid'];
					$groups->MoveNext();	
				}	
			if(!isset($_POST['editSetup']))	$_POST['groups']=$temp;
				
			}
			$mode = "Edit";
			$currentCat=$_GET['category'];
		}
		else if(isset($_POST['category'])){ 
			$edit=false;
			$mode="New";
			$currentCat = $_POST['category'];
		}
		else { $currentCat='ticketqueue'; $mode='New';$edit=false;}
		/*set the title of the edit form*/
		if($edit || !$queue) {
			if(!$queue)
				$title = _('Sub-Queue Details');
			
			$smarty->assign('editSetupTitle',$mode." ".$title);
			$editForm=array();
			/*both queues and subqueues have a name*/
			$item=array();
			$item['type']  = 'text';
			$item['name']  = 'name';
			$item['tag']   =  _('Name');
			if(isset($_POST['name'])) {
				
				$item['value'] = $_POST['name'];
				
			}
			$editForm[] = $item;
			
			/*do queue fields*/
			if ($queue) {
				
				$item = array();
				$item['type'] = 'text';
				$item['tag'] = _('Email');
				$item['name'] = 'address';
				if(isset($_POST['address']))
					$item['value']=$_POST['address'];
				$item['readonly']=true;
				$editForm[] = $item;
				
				$item = array();
				$item['type'] = 'text';
				$item['tag'] = _('Actual Email');
				$item['name'] = 'actualaddress';
				if(isset($_POST['actualaddress']))
					$item['value']=$_POST['actualaddress'];
				$editForm[] = $item;
				
				$item = array();
				$item['type'] = 'checkbox';
				$item['name'] = 'sendreply';
				$item['tag'] = _('Auto-Reply');
				if(isset($_POST['sendreply'])) {
					$item['value']='checked';
				}
				else if(!$edit) {
					$item['value']='checked';	
					
				}
				$editForm[] = $item;
				
				
				/*title for the Response field*/
				$item = array();
				$item['type'] = 'title';
				$item['tag'] = _('Response Details');
				$editForm[]=$item;
				
				$item = array();
				$item['type'] = 'textarea';
				$item['tag'] = _('Insert Response');
				$item['name'] = 'insertmessage';
				if(isset($_POST['insertmessage']))
					$item['value'] = $_POST['insertmessage'];
				$editForm[] = $item;
				
				$item = array();
				$item['type'] = 'textarea';
				$item['tag'] = _('Update Response');
				$item['name'] = 'updatemessage';
				if(isset($_POST['updatemessage']))
					$item['value'] = $_POST['updatemessage'];
				$editForm[] = $item;
				
				$item = array();
				$item['type'] = 'textarea';
				$item['tag'] = _('Close Response');
				$item['name'] = 'closemessage';
				if(isset($_POST['closemessage']))
					$item['value'] = $_POST['closemessage'];
				$editForm[] = $item;
				
				/*title for the Admin field*/
				$item = array();
				$item['type'] = 'title';
				$item['tag'] = _('Admin Users');
				$editForm[]=$item;
					
				$item = array();
				$item['type'] = 'multiple';
				$item['tag'] = _('Users');
				$item['name'] = 'users[]';
				$item['options'] = array();
				$q = 'SELECT username FROM useraccess WHERE companyid='.$db->qstr(EGS_COMPANY_ID);
				
				$users = $db->Execute($q);
				while(!$users->EOF) {
					$item['options'][$users->fields['username']]=$users->fields['username'];
					$users->MoveNext();	
				}
				if(isset($_POST['users']))
					$item['value']=$_POST['users'];
				$editForm[] = $item;
				
				$smarty->assign('editForm',$editForm);
			}
			else if (!$queue) {
				
				
				
				/*title for the Groups field*/
				$item = array();
				$item['type'] = 'title';
				$item['tag'] = _('Group Access');
				$editForm[]=$item;
				
				$item = array();
				$item['type'] = 'multiple';
				$item['tag'] = _('Groups');
				$item['name'] = 'groups[]';
				$item['options'] = array();
				$q = 'SELECT id, name FROM groups WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY name';
				
				$users = $db->Execute($q);
				while(!$users->EOF) {
					$item['options'][$users->fields['id']]=$users->fields['name'];
					$users->MoveNext();	
				}
				if(isset($_POST['groups']))
					$item['value']=$_POST['groups'];
				$editForm[] = $item;					
					
				/*title for the Users field*/
				$item = array();
				$item['type'] = 'title';
				$item['tag'] = _('User Access');
				$editForm[]=$item;
				
				$item = array();
				$item['type'] = 'multiple';
				$item['tag'] = _('Users');
				$item['name'] = 'users[]';
				$item['options'] = array();
				$q = 'SELECT username FROM useraccess WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY username';
				
				$users = $db->Execute($q);
				while(!$users->EOF) {
					$item['options'][$users->fields['username']]=$users->fields['username'];
					$users->MoveNext();	
				}
				if(isset($_POST['users']))
					$item['value']=$_POST['users'];
				$editForm[] = $item;
				
				/*title for the Keyword field*/
				$item = array();
				$item['type'] = 'title';
				$item['tag'] = _('Choose Keywords for Sub-Queue');
				$editForm[]=$item;
				
				$item = array();
				$item['type'] = 'text';
				$item['tag'] = _('Keywords');
				$item['name'] = 'keywords';
				if(isset($_POST['keywords']))
					$item['value'] = $_POST['keywords'];
				$editForm[] = $item;
				
				/*title for the Auto-Assigned field*/
				$item = array();
				$item['type'] = 'title';
				$item['tag'] = _('Choose if tickets are auto-assigned to this sub-queue');
				$editForm[]=$item;
				
				$item = array();
				$item['type'] = 'checkbox';
				$item['name'] = 'auto';
				$item['tag'] = _('Default Sub-Queue');
				if(isset($_POST['auto'])) {
					$item['value']='checked';
				}
				$editForm[] = $item;
				
				
				$smarty->assign('editForm',$editForm);
			}
			
		}
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
	return false;
	
}




?>