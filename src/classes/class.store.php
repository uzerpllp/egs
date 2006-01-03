<?php
class store {
	
	
	/**
	 * Constructor
	 * */
	function store() {
		global $db;
		$this->db = & $db;
	}
	
	function saveOrder($_POST,$id) {
		global $smarty;
		$errors=array();
		
		$order['status']=$_POST['status'];
		$order['id']=$id;
		if(!$this->db->Replace('store_order',$order,'id',true))
			$errors[]=_('Error Updating Order');
		if(count($errors)==0)
			return true;
		return false;
	}
	/**
	 * Save an array of files (to associate with suppliers, sections or products in the webstore)
	 * 
	 * @return boolean
	 * */
	function saveFile($_POST,$fileId,$supplierid=null,$sectionid=null,$productid=null,$albumid=null) {
		global $smarty;
		
		$errors=array();
		
		foreach($_FILES as $key=>$val) {
			
			if($val['size']==0) continue;
			//if(!strpos($val['type'],'image')) {
			if(substr($val['type'],0,5)!='image'&&substr($val['type'],0,5)!='') {
				
				$errors[] = _('Only images can be uploaded');
			}
			/*move the file to somewhere permanent*/
			if(count($errors)==0&&isset($val['name']) && ($val['error'] != UPLOAD_ERR_NO_FILE)) {
					$uploadedfile = EGS_TMP_DIR.'/'.md5(uniqid(time())).basename($val['name']);
	
					if(!move_uploaded_file($val['tmp_name'], $uploadedfile)) $errors[] = _('Error with uploaded file');
					else chmod($uploadedfile, 0655);
			}
			
			/*if it worked, do the DB stuff*/
			if(count($errors)==0) {
				
				/*make the entry in the files table*/
				if(!isset($val['fileId'])) {
					$file['id'] = $this->db->GenID('file_id_seq');
				}
				else $file['id'] = $val['fileId'];
				if(isset($val) && ($val['error'] != UPLOAD_ERR_NO_FILE)) {
					$file['name'] = $val['name'];
					$file['type'] = $val['type'];
					$file['size'] = $val['size'];
				}
				if(!$this->db->replace('file', $file, 'id', true))
					$errors[] = _('Error updating file');
				if(isset($val['name'])  && ($val['error'] != UPLOAD_ERR_NO_FILE)) {
						$this->db->UpdateBlobFile('file', 'file', $uploadedfile, 'id='.$file['id']);
						unlink($uploadedfile);	
					/*supplier and category images have an id in the table*/	
					if(isset($supplierid)&&$supplierid!='') {
						$supplier=array();
						$supplier['id']=$supplierid;
						$supplier[$key] = $file['id'];
						if(!$this->db->Replace('store_suppliers',$supplier,'id',true))
							$errors[] = _('Error Associating File with Supplier');
					}
					else if (isset($sectionid)&&($sectionid!='')) {
						$section=array();
						$section['id']=$sectionid;
						$section[$key]=$file['id'];
						if(!$this->db->Replace('store_section',$section,'id',true))
							$errors[] = _('Error Associating File with Section');
					}
					/*this bit just does the product's main images'*/
					else if(isset($productid)&&($productid!='')) {
						$product=array();
						$product['id']=$productid;
						$product[$key]=$file['id'];
						if(!$this->db->Replace('store_product',$product,'id',true))
							$errors[] = _('Error Associating File with Product');
						
					}
					else if(isset($albumid)&&$albumid!='') {
						$album=array();
						$album['productid']=$albumid;
						$album['fileid']=$file['id'];
						
						if(isset($_POST['albumorder'][0]))
							$album['displayorder']=$_POST['albumorder'][0];
						
						if(!$this->db->Replace('store_product_image_album',$album,array('productid','fileid'),true))
							$errors[]=_('Error Associating File With Album');
						
						
						
					}
				}
			}
			
		}
		if(count($errors)>0) {
			$smarty->assign('errors',$errors);
			return false;
		}
		return true;
		
	}
	/**
	 * Save a product in the webstore
	 * 
	 * @return boolean
	 * */
	function saveProduct($_POST,$id=null) {
		global $smarty;
		$errors=array();
		
		/*do the error-checking*/
		/*presence checks for not-null fields*/
		if(!isset($_POST['productcode']))
			$errors[] = _('You must enter a productcode');
		if(!isset($_POST['name']))
			$errors[] = _('You must enter a name');
		if(!isset($_POST['shortdescription']))
			$errors[] = _('You must enter a short description');
		if(!isset($_POST['description']))
			$errors[] = _('You must enter a full description');
		if(!isset($_POST['price'])||!is_numeric($_POST['price']))
			$errors[] = _('You must enter a price, and it must be numeric');
		
		/*numeric checks on some fields*/
		if(isset($_POST['normalprice'])&&!is_numeric($_POST['normalprice']))
			$errors[] = _('Normal Price must be a number');
		if(isset($_POST['oneoffprice'])&&!is_numeric($_POST['oneoffprice']))
			$errors[] = _('One-Off Price must be a number');
		if(isset($_POST['costprice'])&&!is_numeric($_POST['costprice']))
			$errors[] = _('Cost Price must be a number');
		if(isset($_POST['minquantity'])&&!is_numeric($_POST['minquantity']))
			$errors[] = _('Minimum Quantity must be a number');
		if(isset($_POST['maxquantity'])&&!is_numeric($_POST['maxquantity']))
			$errors[] = _('Maximum Quantity must be a number');
		if(isset($_POST['weight'])&&!is_numeric($_POST['weight']))
			$errors[] = _('Weight must be a number');
		if(isset($_POST['stocklevel'])&&!is_numeric($_POST['stocklevel']))
			$errors[] = _('Stock Level must be a number');
		if(isset($_POST['warninglevel'])&&!is_numeric($_POST['warninglevel']))
			$errors[] = _('Warning Level must be a number');
		
		/*convert the booleans*/
		if(isset($_POST['freeshipping']))
			$_POST['freeshipping']='true';
		else
			$_POST['freeshipping']='false';
		if(isset($_POST['newproduct']))
			$_POST['newproduct']='true';
		else
			$_POST['newproduct']='false';
		if(isset($_POST['topproduct']))
			$_POST['topproduct']='true';
		else
			$_POST['topproduct']='false';			
		if(isset($_POST['specialoffer']))
			$_POST['specialoffer']='true';
		else
			$_POST['specialoffer']='false';	
		if(isset($_POST['visible']))
			$_POST['visible']='true';
		else
			$_POST['visible']='false';	
		if(isset($_POST['forcehide']))
			$_POST['forcehide']='true';
		else
			$_POST['forcehide']='false';
		if(isset($_POST['stockcontrolenable']))
			$_POST['stockcontrolenable']='true';
		else
			$_POST['stockcontrolenable']='false';
		
		/*convert some field names*/
		if(isset($_POST['sectionid'])) {
			$_POST['productsection']=$_POST['sectionid'];
			unset($_POST['sectionid']);
			
		}
		if(isset($_POST['section']))
			unset($_POST['section']);
		if(isset($_POST['supplier'])) {
			unset($_POST['supplier']);
		}
		
		/*take the associated products out*/
		if(isset($_POST['selectedproducts'])) {
			$assocproducts=$_POST['selectedproducts'];
			unset($_POST['selectedproducts']);
		}
		if(count($errors)==0) {
			if (in_array('store', $_SESSION['modules'])) {
				if($id!=null) {
					$mode="UPDATE";	
					$_POST['id']=$id;
				} else {
					/*set some defaults*/
					$mode="INSERT";	
					$_POST['id'] = $this->db->GenID('store_product_id_seq');
					$_POST['owner']=EGS_USERNAME;
					$_POST['created']=$this->db->DBTimeStamp(time());
					$_POST['companyid']=EGS_COMPANY_ID;
				}
				/*some more defaults*/
				$_POST['lastupdate'] = $this->db->DBTimeStamp(time());
				$_POST['alteredby'] = EGS_USERNAME;
				
				/*unset the button variable*/
				unset ($_POST['save']);
				
				/*unset the hidden file-size variable*/
				if(isset($_POST['MAX_FILE_SIZE']))unset($_POST['MAX_FILE_SIZE']);
				
				/*things like metadescription could be '' if they're being cleared*/
				if(!isset($_POST['metadescription']))$_POST['metadescription']='';
				if(!isset($_POST['metakeywords']))$_POST['metakeywords']='';
				if(!isset($_POST['searchkeywords']))$_POST['searchkeywords']='';
				if(!isset($_POST['oneoffprice']))$_POST['oneoffprice']=0;
				if(!isset($_POST['normalprice']))$_POST['normalprice']=0;
				if(!isset($_POST['costprice']))$_POST['costprice']=0;
				if(!isset($_POST['supplierid']))$_POST['supplierid']='null';
				if(!isset($_POST['productsection']))$_POST['productsection']='null';
				/*image-saving needs to be in a transaction*/
				$this->db->StartTrans();
				
				if (!$this->db->Replace('store_product', $_POST, 'id', true))
						$errors[] = _('Error Saving Product');

			/*add the associated products*/
			/*first, delete them all*/
				$query = 'DELETE FROM store_associate_products WHERE productid='.$this->db->qstr($_POST['id']);
				if(!$this->db->Execute($query))
					$errors[]=_('Error Altering Associated Products');
				if(isset($assocproducts)&&count($assocproducts)>0) {
					$query = 'INSERT INTO store_associate_products VALUES(?,?)';
					$stmt=$this->db->Prepare($query);
					foreach($assocproducts as $key=>$val) {
						$this->db->Execute($stmt, array($_POST['id'],$val));
						
					}
				}
				$fileId='';
				if(isset($_FILES)&&count($_FILES)>0 ) {
					if($mode=='UPDATE') {
						foreach($_FILES as $key=>$val) {
							$q = 'SELECT '.$key.' FROM store_product WHERE id='.$this->db->qstr($_POST['id']);
							$_FILES[$key]['fileId']=$this->db->GetOne($q);	
						}
					}
					if(!$this->saveFile($_POST,$fileId,null,null, $_POST['id'])) {
						$errors[] = _('Error with image upload');
						$this->db->FailTrans();
					}
				}		
				$this->db->completeTrans();
				
			}
		}
		if(count($errors)==0) {
			$smarty->assign('messages',_('New Product Saved Successfully'));
			return true;	
		}
		$smarty->assign('errors',$errors);
		return false;
	}
	
	/**
	 * Save a supplier in the webstore
	 * 
	 * @return boolean
	 * */
	function saveSupplier($_POST, $id = null) {
		
		global $egs, $smarty;
		$errors = array ();
		/*if a name has been given, then don't use the company-name*/
		if(isset($_POST['name']))unset($_POST['name']);
		if(isset($_POST['company']))unset($_POST['company']);

		/*check for access*/
		if (in_array('store', $_SESSION['modules'])) {
			
			/*companyid needs to be set*/
			if (!isset ($_POST['companyid']))
				$errors[] = _('You must enter a company');
			/* No errors so we can save */
			if (sizeof($errors) == 0) {
				/* Set weather to insert or update */
				if ($id != null)
					$mode = 'UPDATE';
				else
					$mode = 'INSERT';
					
				/*switch some names around*/
				$_POST['supplierid'] = $_POST['companyid'];
				unset ($_POST['companyid']);
				
				/* If we are doing an insert set some defaults */
				if ($mode == 'INSERT') {
					$_POST['id'] = $this->db->GenID('store_supplier_id_seq');
					$_POST['companyid'] = EGS_COMPANY_ID;
					$_POST['owner'] = EGS_USERNAME;
					$_POST['created'] = $this->db->DBTimeStamp(time());
				}
				
				$_POST['lastupdated'] = $this->db->DBTimeStamp(time());
				$_POST['alteredby'] = EGS_USERNAME;
				unset ($_POST['save']);
				if(isset($_POST['MAX_FILE_SIZE']))unset($_POST['MAX_FILE_SIZE']);
				if(!isset($_POST['description']))$_POST['description']='';
				
				$this->db->StartTrans();
								
				if (!$this->db->Replace('store_suppliers', $_POST, 'id', true))
					$errors[] = _('Error Saving Supplier');
				
				$fileId='';
				if(isset($_FILES)&&count($_FILES)>0 ) {
					if($mode=='UPDATE') {
						foreach($_FILES as $key=>$val) {
							$q = 'SELECT '.$key.' FROM store_suppliers WHERE id='.$this->db->qstr($_POST['id']);
							$_FILES[$key]['fileId']=$this->db->GetOne($q);
						}
					}
					if(!$this->saveFile($_POST,$fileId, $_POST['id'])) {
						$errors[] = _('Error with image upload');
						$this->db->FailTrans();
					}
				}	
					
				
				$this->db->completeTrans();

			}
			if (sizeof($errors) == 0) {
				$messages = array ();
				if ($mode == 'INSERT')
					$messages[] = _('Supplier Successfully Added');
				else
					$messages[] = _('Supplier Successfully Updated');

				$smarty->assign('messages', $messages);
				return true;
			} else {
				$smarty->assign('errors', $errors);
				return false;
			}

		} else {
			$errors[] = _('You don\'t have the right permissions to perform this action, contact your administrator');
			$smarty->assign('errors', $errors);
			return false;
		}

	}
	/**
	 * Save a section in the webstore
	 * 
	 * @return boolean
	 * 
	 * */
	function saveSection($_POST,$id=null) {
		
		global $egs, $smarty;
		$errors = array ();	
		if (in_array('store', $_SESSION['modules'])) {
			if (!isset ($_POST['title']))
				$errors[] = _('You must provide a title');
			/* No errors so we can save */
			if (sizeof($errors) == 0) {
				/* Set whether to insert or update */
				if ($id != null) {
					$mode = 'UPDATE';
					$_POST['id']=$id;
				}
				else 
					$mode = 'INSERT';
						
				
				/* If we are doing an insert set some defaults */
				if ($mode == 'INSERT') {
					$_POST['id'] = $this->db->GenID('store_section_id_seq');
					$_POST['companyid'] = EGS_COMPANY_ID;
					$_POST['owner'] = EGS_USERNAME;
					$_POST['created'] = $this->db->DBTimeStamp(time());
				}
				if(isset($_POST['visible']))$_POST['visible']='true';
				else $_POST['visible']='false';
				$_POST['alteredby']=EGS_USERNAME;
				$_POST['lastupdated'] = $this->db->DBTimeStamp(time());
				unset ($_POST['save']);
				if(isset($_POST['MAX_FILE_SIZE']))unset($_POST['MAX_FILE_SIZE']);
				if(!isset($_POST['description']))$_POST['description']='';
				if(!isset($_POST['metadescription']))$_POST['metadescription']='';
				if(!isset($_POST['metakeywords']))$_POST['metakeywords']='';
				if(isset($_POST['parentsectionid'])&&$_POST['parentsectionid']==0)	$_POST['parentsectionid']='NULL';
				$this->db->StartTrans();
					
				if (!$this->db->Replace('store_section', $_POST, 'id', true))
					$errors[] = _('Error Saving Section');
				
				$fileId='';
				if(isset($_FILES)&&count($_FILES)>0 ) {
					
					if($mode=='UPDATE') {
						foreach($_FILES as $key=>$val) {
							$q = 'SELECT '.$key.' FROM store_section WHERE id='.$this->db->qstr($_POST['id']);
							$_FILES[$key]['fileId']=$this->db->GetOne($q);	
						}
					}
					
					if(!$this->saveFile($_POST,$fileId,null, $_POST['id'])) {
						$errors[] = _('Error with image upload');
						$this->db->FailTrans();
					}
				}	
					
				
				$this->db->completeTrans();
			}if (sizeof($errors) == 0) {
				$messages = array ();
				if ($mode == 'INSERT')
					$messages[] = _('Section Successfully Added');
				else
					$messages[] = _('Section Successfully Updated');

				$smarty->assign('messages', $messages);
				return true;
			} else {
				$smarty->assign('errors', $errors);
				return false;
			}

		} else {
			$errors[] = _('You don\'t have the right permissions to perform this action, contact your administrator');
			$smarty->assign('errors', $errors);
			return false;
		}
	}
	/**
	 * Update the images associated with a product
	 * 
	 */
	function updateAlbum($_POST,$id) {
		
		global $smarty;
		if (in_array('store', $_SESSION['modules'])) {
			
			
			$this->db->StartTrans();
			if(isset($_POST['albumdelete'])&&count($_POST['albumdelete'])>0) {
				/*do the deletes*/
				foreach($_POST['albumdelete'] as $key=>$val) {
					/*first delete the file*/
					$q = 'DELETE FROM file WHERE id='.intval($key);
					
					$rs=$this->db->Execute($q);	
					unset($_POST['albumorder'][$key]);
				}	
			}	
				/*then add a new one*/
				if(isset($_FILES)&&count($_FILES)>0&&isset($_FILES['newalbumimage']['name'])&&$_FILES['newalbumimage']['name']!='' ) {
					
						$fileid = $this->db->GenID('file_id_seq');
						$_FILES['newalbumimage']['fileId']=$fileid;
						if(!$this->saveFile($_POST,$fileid,null,null,null, $id)) {
						$errors[] = _('Error with image upload');
						$this->db->FailTrans();
					}
				}
				/*do some things with the ordering*/
				$neworders=$_POST['albumorder'];
				if(isset($fileid)) 
					$neworders[$fileid]=$neworders[0];
				unset($neworders[0]);
				$neworders=$this->fixOrdering($neworders);
				
				foreach($neworders as $key=>$val) {
					$q = 'UPDATE store_product_image_album SET displayorder='.intval($val).' WHERE fileid='.intval($key).' AND productid='.intval($id);	
					
					$rs=$this->db->Execute($q);
				}
				
				
			$this->db->CompleteTrans();
		}
		
		
	}
	/**
	 * Update the attributes associated with the product
	 * 
	 * */
	function updateAttributes($_POST,$id) {
			global $smarty;
			
			$this->db->StartTrans();
			
			/*delete all the attributes*/
			$q = 'DELETE FROM store_product_attributes WHERE productid='.intval($id);
			$rs=$this->db->Execute($q);
			
			/*add them back*/
			if(isset($_POST['values'])&&is_array($_POST['values'])) {
				$q = 'INSERT INTO store_product_attributes (productid,attributeid) VALUES (?,?)';
				$stmt = $this->db->Prepare($q);
				foreach($_POST['values'] as $attributeid) {
					$this->db->Execute($stmt,array($id,$attributeid));	
					
				}
				
			}
			$this->db->CompleteTrans();
		
	}
	/**
	 * Update the additional sections associated with the product
	 * 
	 * */
	function updateSections($_POST,$id) {
			global $smarty;
			
			$this->db->StartTrans();
			
			/*delete all the attributes*/
			$q = 'DELETE FROM store_product_sections WHERE productid='.intval($id);
			$rs=$this->db->Execute($q);
			
			/*add them back (if there are any)*/
			if(isset($_POST['values'])&&is_array($_POST['values'])) {
				$q = 'INSERT INTO store_product_sections (productid,sectionid) VALUES (?,?)';
				$stmt = $this->db->Prepare($q);
				foreach($_POST['values'] as $sectionid) {
					$this->db->Execute($stmt,array($id,$sectionid));	
					
				}
			}
			
			$this->db->CompleteTrans();
		
	}
	
	/**
	 * Delete a supplier from the webstore
	 * 
	 * @return boolean
	 * */
	function deleteSupplier($id) {
		global $smarty;
		if (in_array('store', $_SESSION['modules'])) {
			$query = 'DELETE FROM store_suppliers WHERE id='.$this->db->qstr($id).' AND companyid='.$this->db->qstr(EGS_COMPANY_ID);
			$rs=$this->db->Execute($query);
			if($rs->RecordCount()>0)
				return true;
			else
				return false;
			
		}
	}
	
	/**
	 * Delete a section from the webstore 
	 * 
	 * @return boolean
	 * */
	function deleteSection($id) {
		if (in_array('store', $_SESSION['modules'])) {
			$query = 'DELETE FROM store_section WHERE id='.$this->db->qstr($id).' AND companyid='.$this->db->qstr(EGS_COMPANY_ID);
			$rs=$this->db->Execute($query);

			return true;
		}
		return false;
	}	
	
	/**
	 * Delete a product from the webstore
	 * 
	 * @return boolean
	 * */
	function deleteProduct($id) {
		if (in_array('store', $_SESSION['modules'])) {
			$query = 'DELETE FROM store_product WHERE id='.$this->db->qstr($id).' AND companyid='.$this->db->qstr(EGS_COMPANY_ID);
			$rs=$this->db->Execute($query);

			return true;
		}
		return false;
	}
	
	/**
	 * Delete the image associated with a product. Done this way so the front-end
	 * doesn't need to worry about it being a thumb or a full image.
	 */
	function deleteImage($productid,$imageid) {
		
		$q = 'DELETE FROM file WHERE id='.$imageid;
		$this->db->Execute($q);
		
		
	}
	
	/**
	 * function that takes an array of $key=>$order and sorts it nicely
	 * 
	 * Deals with the problems that allowing user-specified ordering bring, namely
	 * duplicate order-values and gaps. This function will (arbitrarily) re-order duplicates,
	 * and then re-order elements as necessary to remove gaps.
	 * 
	 * Example:
	 * <code>
	 * <?php
	 * $array = array(6,1,1,2,4,3);
	 * $array = fixOrdering($array);
	 *	//array is now: [5,0,1,2,4,3]
	 * ?>
	 * </code>
	 * 
	 * */
	function fixOrdering($array) {
		
		//e.g. [6,1,1,2,4,3] will return [5,0,1,2,4,3]
		$temp=$array;
		$i=0;
		for($i;$i<count($array);$i++) {
			//get the key of the smallest element in $temp
			$minkey = array_search(min($temp),$temp);
			//assign $i to that element in $array
			$array[$minkey]=$i+1;
			//delete the element in $temp
			unset($temp[$minkey]);
		}
		return $array;
	}
	/**
	 * Function to allow for indenting/nesting sections and subsections (and sub-subsections ad infinitum)
	 * 
	 * Made for use in drop-down boxes
	 * Indenting is done with '-'s
	 **/
	function nestSections(& $sections,$parent=null,$count=1) {
		global $sections,$db;
		$prefix = '';
			for ($i = 1; $i < $count; $i ++) {
				$prefix .= '-';

			}
		if(!isset($parent)) {
			/*get all the top-level sections*/
			$q = 'SELECT id, title FROM store_section WHERE parentsectionid is null AND companyid='.$this->db->qstr(EGS_COMPANY_ID);
			
			$rs=$this->db->Execute($q);
			while (!$rs->EOF) {
				$sections[$rs->fields['id']]=$prefix.$rs->fields['title'];
				$this->nestSections($sections,$rs->fields['id'],$count+1);
				$rs->MoveNext();
			}
		}
		else {
			$q='SELECT id, title FROM store_section WHERE parentsectionid='.intval($parent).' AND companyid='.$this->db->qstr(EGS_COMPANY_ID);
			$rs=$this->db->Execute($q);
			while (!$rs->EOF) {
				$sections[$rs->fields['id']]=$prefix.$rs->fields['title'];
				$this->nestSections($sections,$rs->fields['id'],$count+1);
				$rs->MoveNext();
			}
		}
		
	}
	
	/**
	 * Returns the options for the 'actiononzero' column
	 * */
	function getActionOnZeroOptionsArray() {
		$actiononzerooptions = array(_('Available (No Purchase)'),_('Available (With Purchase)'),_('Hide'));	
		return $actiononzerooptions;
	}
	function deleteOrder($id) {
		$query = 'UPDATE store_order SET status='.$this->db->qstr('deleted').' WHERE id='.$id;
		if($this->db->Execute($query))
			return true;
		return false;	
	}
	function deleteCustomer($id) {
		return false;	
	}
	function getOrderStatuses() {
		$array=array('new'=>'new','approved'=>'approved','fraud_pending'=>'fraud_pending','technical_problem'=>'technical_problem','rejected'=>'rejected','completed'=>'completed','deleted'=>'deleted');
		return $array;
	}
}
