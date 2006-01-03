<?php

require_once (EGS_FILE_ROOT.'/src/classes/class.store.php');

	$store = new store();


if(isset($_GET['page'])) $_SESSION['attribute_page'] = max(1, intval($_GET['page']));
if(!isset($_SESSION['attribute_page'])) $_SESSION['attribute_page'] = 1;
if (in_array('store', $_SESSION['modules'])) {
$setupCatArray = array(
					'store_product_attribute' => 'Product Attributes'
				);
				
/*if a label is being changed*/
	$errors=array();
	$messages = array();
	if(count($_POST)>0) {
		
		$egs->checkPost();
		
		if(isset($_POST['delete'])&&count($_POST['delete'])>0) {
			if(count($errors)==0) {
				while(list($key, $val) = each($_POST['delete'])) {
					$query = 'DELETE FROM store_product_attribute WHERE id='.$db->qstr($val).' AND companyid='.$db->qstr(EGS_COMPANY_ID);
					
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
			//echo "<pre>".print_r($_POST);
			//echo "<pre>".print_r($_POST);
			/*Post variables:
			name->attribute.name
			type->attribute.type
			
			valueid[]->value.id
			valuename[]->value.name
			valuedetails[]->value.details
			value.vieworder[]->value.vieworder
			valueid will be empty for a new entry, but other values will be filled in
			(assume if name is filled, then a new one is being added)
			*/
			$attribute = array();
			if(isset($_GET['id'])) {
				$mode="UPDATE";
				$attribute['id']=$_GET['id'];
				
			}
			else {
				$mode="INSERT";
				$attribute['id']=$db->GenID('store_product_attribute_id_seq');	
				$attribute['companyid']=EGS_COMPANY_ID;
			}
			if(!isset($_POST['name']))
				$errors[] = _('You must enter a name');
			else
				$attribute['name']=$_POST['name'];
			if(!isset($_POST['type']))
				$errors[] = _('You must enter a type');
			else
				$attribute['type']=$_POST['type'];
			$db->StartTrans();
			if(!$db->Replace('store_product_attribute',$attribute,'id',true))
				$errors[] = _('Error Saving Attribute');
			
			/*do deletes first*/
			if(isset($_POST['valuedelete'])&&count($_POST['valuedelete'])>0) {
				foreach($_POST['valuedelete'] as $key=>$val) {
					$query = 'DELETE FROM store_product_attribute_value WHERE id='.$db->qstr($key);
					if(!$db->Execute($query))
						$errors[] = _('Error Deleting Value');
					//now need to delete from the other arrays
					$temp = array_flip($_POST['valueid']);
					$deleteid=$temp[$key];
					unset($_POST['valueid'][$deleteid]);
					if(isset($_POST['valuename'][$deleteid]))unset($_POST['valuename'][$deleteid]);
					
				}
			}
			if(is_array($_POST['valuevieworder'])&&count($_POST['valuevieworder'])>0) 
				$_POST['valuevieworder']=$store->fixOrdering($_POST['valuevieworder']);
			/*Do an insert/update for each row that has a name filled in*/
			foreach($_POST['valuename'] as $key=>$val) {
				$value=array();
				if(isset($_POST['valueid'][$key])) {
					$valmode="UPDATE";
					$value['id']=$_POST['valueid'][$key];
				}
				else {
					$valmode="INSERT";
					$value['productattributeid']=$attribute['id'];
					$value['id']=$db->GenID('store_product_attribute_value_id_seq');
				}
				if(isset($_POST['valuedetails'][$key]))
					$value['details']=$_POST['valuedetails'][$key];
				else
					$value['details']='';
				$value['name']=$val;
				if(isset($_POST['valuevieworder'][$key]))
					$value['vieworder']=$_POST['valuevieworder'][$key];
				else $value['vieworder']=max($_POST['valuevieworder'])+1;
				if(!$db->Replace('store_product_attribute_value',$value,'id',true))
					$errors[] = _('Error Adding Atrribute-Values');
			}
			
			
			$db->CompleteTrans();
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
	
	
	
	
	
	$currentCategory= 'store_product_attribute';
	
	$smarty->assign('currentCat',$currentCategory);
	
	if(isset($currentCategory)&&!array_key_exists($currentCategory,$setupCatArray)) {
				$errors[] = _('Invalid Attribute');
				$smarty->assign('errors',$errors);
				
				
	}
	if(count($errors)==0) {
		/* Set the page title */
		
		$title=$setupCatArray[$currentCategory];
		$smarty->assign('pageTitle', _('Store: '.$title));
		
		/*Assign the table headings*/
		$headings=array();
		$headings[] = _('Name');
		$headings[] = _('Type');
		
		
		$smarty->assign('headings',$headings);
		$db->setFetchMode(ADODB_FETCH_NUM);
		/*get data for rows*/
		$q = 'SELECT id, name,type';
		$q.=' FROM '.$currentCategory. ' WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY name';
		
		$egs->page($q,'attribute_page');
		
		
		/*Do the stuff on the right*/
		$currentCat='store_product_attribute';
		if(isset($_GET['id'])) {
			$edit=true;
			/*fill $_POST with the values for the item being viewed*/
			$q = 'SELECT * from store_product_attribute WHERE id='.$db->qstr($_GET['id']).' AND companyid='.$db->qstr(EGS_COMPANY_ID);
			
			$_POST = $db->GetRow($q);	
			$mode = "Edit";
			$smarty->assign('editnewlink',true);
			
		}
		else {  $mode='New';}
		/*set the title of the edit form*/
				
		
		$title = _('Attribute');
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
		
		$types=array('Colour','Size','Text','Length','Weight');
		$item=array();
		$item['type']  = 'select';
		$item['name']  = 'type';
		$item['tag']   =  _('Type');
		$item['options']=array();
		for($i=0;$i<count($types);$i++) {
			$item['options'][$types[$i]]=_($types[$i]);	
		}
		
		if(isset($_POST['type'])) {
			$item['value'] = $_POST['type'];
			
		}
		$editForm[] = $item;
		$item = array();
		$item['type'] = 'title';
		$item['tag'] = _('Values');
		$editForm[]=$item;
		
		
		//add a row for each value
		$item=array();
		$item['type']='subform';
		$item['headings']=array('',_('Name'),_('Details'),_('Order'));		
		$item['rows']=array();
		$i=0;
		if(isset($_GET['id'])) {
			$q = 'SELECT * FROM store_product_attribute_value WHERE productattributeid='.$db->qstr($_GET['id']).' ORDER BY vieworder';
			$rs = $db->Execute($q);
			
			while(!$rs->EOF) {
				$item['rows'][$i]=array();
				$item['rows'][$i]['valueid']=$rs->fields['id'];
				$item['rows'][$i]['valuename']=$rs->fields['name'];
				$item['rows'][$i]['valuedetails']=$rs->fields['details'];
				$item['rows'][$i]['valuevieworder']=$rs->fields['vieworder'];
				$i++;
				$rs->MoveNext();	
			}
		}
		
		
		//then one blank one
		$item['rows']['new']=array();
		$item['rows']['new']['valueid']='';
		$item['rows']['new']['valuename']='';
		$item['rows']['new']['valuedetails']='';
		$item['rows']['new']['valuevieworder']=(isset($item['rows'][$i-1]['valuevieworder']))?$item['rows'][$i-1]['valuevieworder']+1:1;
		$editForm[]=$item;
		
		
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