<?php 
class domain {
	function domain() {
		global $db;
		$this->db = & $db;
	}

	/* Get the access level the current user has for a company */
	function accessLevel($id) {
		if(!isset($access[$id])) {
			$query = 'SELECT u.username FROM useraccess u, domain d WHERE d.usercompanyid='.$this->db->qstr(EGS_ACTUAL_COMPANY_ID).' AND d.id='.$this->db->qstr($id).' AND u.companyid='.$this->db->qstr(EGS_COMPANY_ID).' AND u.username='.$this->db->qstr(EGS_USERNAME);
			$query = 'SELECT u.username FROM useraccess u, domain d WHERE d.id='.$this->db->qstr($id).' AND u.username='.$this->db->qstr(EGS_USERNAME).' AND d.companyid=u.companyid  AND u.companyid='.$this->db->qstr(EGS_COMPANY_ID);	
			$rs = $this->db->GetOne($query);
	
			if ($rs === false) {
				$query = 'SELECT id FROM domain WHERE id='.$this->db->quote(intval($id)).' AND usercompanyid='.$this->db->qstr(EGS_ACTUAL_COMPANY_ID);
				if(!EGS_DOMAINADMIN) $query.=' AND companyid='.$this->db->qstr(EGS_ACTUAL_COMPANY_ID);
				$rs = $this->db->GetOne($query);
				
				if($rs === false) $this->access[$id] = -1;
				else $this->access[$id] = 1;
			}	
			else $this->access[$id] = 2;
		}
		
		return $this->access[$id];
	}
	
	function isValidPageName($name, $domainId, $id = null) {
		$query = 'SELECT name FROM webpage WHERE domainid='.$this->db->qstr($domainId).' AND name='.$this->db->qstr($name);

		if($id != '') $query .= ' AND id<>'.$this->db->qstr($id);

		$rs = $this->db->GetOne($query);

		if ($rs != '')
			return true;
		else
			return false;
	}
	
	function saveParents ($domainId, $pageId, $parents) {	
		/* Check details are valid  - starting with the name */
		if($this->accessLevel($domainId) > 0) {	
			/* Start a transaction */
			$this->db->StartTrans();
	
			$stmt = $this->db->Prepare('INSERT INTO webpagesxassigned (webpageid, parentpageid) VALUES (?,?)');
			
			$this->db->Execute('DELETE FROM webpagesxassigned WHERE webpageid='.$this->db->qstr($pageId));
			
			while($page = array_shift($parents))
				$this->db->execute($stmt, array($pageId, $page));	
	
			$this->db->completeTrans();
		}
	}
	
	function savePortfolioCategory($_POST, $id = null) {
		global $egs, $smarty;
		if(isset($_POST['company']))unset($_POST['company']);
		if(isset($_POST['person']))unset($_POST['person']);
		if($id != '') $id = intval($id);

		/* Array to hold errors */
		$errors = array ();

		/* Check details are valid  - starting with the name */
		if($this->accessLevel($_POST['domainid']) < 1)
			$errors[] = _('You do not have the correct access to add this portfolio category. If you beleive you should please contact your system administrator.');
		if (!isset ($_POST['name']))
			$errors[] = _('No Category Name');

		/* No errors so we can save */
		if (sizeof($errors) == 0) {
			/* Set weather to insert or update */
			if ($id != null)
				$mode = 'UPDATE';
			else
				$mode = 'INSERT';

			if(($mode == 'UPDATE') && ($this->accessLevel($_POST['domainid']) < 1)) {
				$smarty->assign('errors', array(_('You do not have the correct access to update this portfolio category. If you beleive you should please contact your system administrator.')));
			} else {

				/* If we are doing an insert set some defaults */
				if ($mode == 'INSERT') {
					$_POST['id'] = $this->db->GenID('portfoliocategory_id_seq');
				}
				
				$_POST['companyid'] = EGS_COMPANY_ID;
				
				/* Start a transaction */
				$this->db->StartTrans();

				unset($_POST['save']);
	
				/* Insert the item */
				if (!$this->db->Replace('portfoliocategory', $_POST, 'id', true))
					$errors[] = _('Error saving portfolio category');		
	
				$this->db->completeTrans();
			}
		}

		/* If there are no errors return true and set success message */
		if (sizeof($errors) == 0) {
			$messages = array();
			if($mode == 'INSERT') $messages[] = _('Portfolio category Successfully Added');
			else $messages[] = _('Portfolio category Successfully Updated');
			
			$smarty->assign('messages', $messages);
			return true;
		} else {
			$smarty->assign('errors', $errors);
			return false;
		}
	}
	
	function saveNewsCategory($_POST, $id = null) {
		global $egs, $smarty;
		if(isset($_POST['company']))unset($_POST['company']);
		if(isset($_POST['person']))unset($_POST['person']);
		if($id != '') $id = intval($id);

		/* Array to hold errors */
		$errors = array ();

		/* Check details are valid  - starting with the name */
		if($this->accessLevel($_POST['domainid']) < 1)
			$errors[] = _('You do not have the correct access to add this news category. If you beleive you should please contact your system administrator.');
		if (!isset ($_POST['name']))
			$errors[] = _('No Category Name');

		/* No errors so we can save */
		if (sizeof($errors) == 0) {
			/* Set weather to insert or update */
			if ($id != null)
				$mode = 'UPDATE';
			else
				$mode = 'INSERT';

			if(($mode == 'UPDATE') && ($this->accessLevel($_POST['domainid']) < 1)) {
				$smarty->assign('errors', array(_('You do not have the correct access to update this news category. If you beleive you should please contact your system administrator.')));
			} else {

				/* If we are doing an insert set some defaults */
				if ($mode == 'INSERT') {
					$_POST['id'] = $this->db->GenID('newscategory_id_seq');
				}
				
				$_POST['companyid'] = EGS_COMPANY_ID;
				
				/* Start a transaction */
				$this->db->StartTrans();

				unset($_POST['save']);
	
				/* Insert the company */
				if (!$this->db->Replace('newscategory', $_POST, 'id', true))
					$errors[] = _('Error saving news category');		
	
				$this->db->completeTrans();
			} 
		}

		/* If there are no errors return true and set success message */
		if (sizeof($errors) == 0) {
			$messages = array();
			if($mode == 'INSERT') $messages[] = _('News category Successfully Added');
			else $messages[] = _('News category Successfully Updated');
			
			$smarty->assign('messages', $messages);
			return true;
		} else {
			$smarty->assign('errors', $errors);
			return false;
		}
	}
	
	function savePage($_POST, $id = null) {
		global $egs, $smarty;
		if(isset($_POST['company']))unset($_POST['company']);
		if(isset($_POST['person']))unset($_POST['person']);
		if($id != '') $id = intval($id);

		/* Array to hold errors */
		$errors = array ();

		/* Check details are valid  - starting with the name */
		if($this->accessLevel($_POST['domainid']) < 1)
			$errors[] = _('You do not have the correct access to add this webpage. If you beleive you should please contact your system administrator.');
		if (!isset ($_POST['name']))
			$errors[] = _('No Page Name');
		if (isset ($_POST['name']) && $this->isValidPageName($_POST['name'], $_POST['domainid'], $id))
			$errors[] = _('Page Name is taken');
		if (!isset ($_POST['title']))
			$errors[] = _('No Page Title');
		if (!isset ($_POST['content']))
			$errors[] = _('No Page');

		/* No errors so we can save */
		if (sizeof($errors) == 0) {
			/* Set weather to insert or update */
			if ($id != null)
				$mode = 'UPDATE';
			else
				$mode = 'INSERT';

			if(($mode == 'UPDATE') && ($this->accessLevel($_POST['domainid']) < 1)) {
				$smarty->assign('errors', array(_('You do not have the correct access to update this webpage. If you beleive you should please contact your system administrator.')));
			} else {

				/* If we are doing an insert set some defaults */
				if ($mode == 'INSERT') {
					$_POST['id'] = $this->db->GenID('webpage_id_seq');
					$_POST['owner'] = EGS_USERNAME;
				}
	
				$_POST['alteredby'] = EGS_USERNAME;
	
				/* Start a transaction */
				$this->db->StartTrans();

				$_POST['alteredby'] = EGS_USERNAME;
				unset($_POST['save']);
				
				if($mode == 'UPDATE') {
					$_POST['alteredby'] = EGS_USERNAME;
					$_POST['updated'] = $this->db->DBTimeStamp(time());
				}
				if(!isset($_POST['description']))$_POST['description']='';
				/* Insert the company */
				if (!$this->db->Replace('webpage', $_POST, 'id', true))
					$errors[] = _('Error saving webpage');		
	
				$this->db->completeTrans();
			}
		}

		/* If there are no errors return true and set success message */
		if (sizeof($errors) == 0) {
			$messages = array();
			if($mode == 'INSERT') $messages[] = _('Webpage Successfully Added');
			else $messages[] = _('Webpage Successfully Updated');
			
			$smarty->assign('messages', $messages);
			return true;
		} else {
			$smarty->assign('errors', $errors);
			return false;
		}
	}

	function deleteFile($domainId, $fileId) {
		global $smarty;
		
		if($this->accessLevel($domainId) >= 0) {

			$actualFileId = $this->db->GetOne('SELECT w.fileid FROM webpagefile w, webpage p WHERE p.domainid='.$this->db->qstr($domainId).' AND p.id=w.webpageid AND w.fileid='.$this->db->qstr($fileId));

			if($actualFileId == $fileId) $this->db->Execute('DELETE FROM file WHERE id='.$this->db->qstr($fileId));

			$smarty->assign('messages', array(_('File successfully deleted')));

			return true;
		} else {
			$smarty->assign('errors', array(_('You do not have the correct access to delete this file. If you beleive you should please contact your system administrator')));

			return false;
		}
	}	
	
	function deletePortfolioFile($domainId, $fileId) {
		global $smarty;
		
		if($this->accessLevel($domainId) >= 0) {

			$actualFileId = $this->db->GetOne('SELECT i.fileid FROM portfolioitemimages i, portfolioitem p WHERE p.domainid='.$this->db->qstr($domainId).' AND p.id=i.portfolioitemid AND i.fileid='.$this->db->qstr($fileId));

			if($actualFileId == $fileId) {
				$this->db->StartTrans();
				$this->db->Execute('DELETE FROM portfolioitemimages WHERE fileid='.$this->db->qstr($fileId));
				$this->db->Execute('DELETE FROM file WHERE id='.$this->db->qstr($fileId));
				$this->db->CompleteTrans();
			}

			$smarty->assign('messages', array(_('File successfully deleted')));

			return true;
		} else {
			$smarty->assign('errors', array(_('You do not have the correct access to delete this file. If you beleive you should please contact your system administrator')));

			return false;
		}
	}
	function deletePage($id, $domainId) {
		global $smarty;
		
		if($this->accessLevel($domainId) > 0) {
			$this->db->StartTrans();
			
			$query = 'SELECT parentpageid FROM webpage WHERE id='.$this->db->qstr($id).' AND domainid='.$this->db->qstr($domainId);
			
			$parentId = $this->db->GetOne($query);
			
			if($parentId != '') {
				$query = 'UPDATE webpage SET parentpageid='.$this->db->qstr($parentId).' WHERE parentpageid='.$this->db->qstr($id);
				
				$this->db->Execute($query);
			}
			
			$query = 'DELETE FROM webpage WHERE id='.$this->db->qstr($id).' AND domainid='.$this->db->qstr($domainId);
			
			$this->db->Execute($query);
	
			$this->db->completeTrans();
			
			$smarty->assign('messages', array(_('Webpage Successfully Deleted')));
			
			return true;
		} else {
			$smarty->assign('messages', array(_('Your do not have the correct permissions to delete this webpage. If you beleive you should please contact your system administrator.')));
			
			return true;
		}
	}
	
	function deleteNews($id, $domainId) {
		global $smarty;
		
		if($this->accessLevel($domainId) > 0) {
			$this->db->StartTrans();
			
			$query = 'DELETE FROM news WHERE id='.$this->db->qstr($id).' AND domainid='.$this->db->qstr($domainId);
			
			$this->db->Execute($query);
	
			$this->db->completeTrans();
			
			$smarty->assign('messages', array(_('News Item Successfully Deleted')));
			
			return true;
		} else {
			$smarty->assign('error', array(_('Your do not have the correct permissions to delete this news item. If you believe you should please contact your system administrator.')));
			
			return true;
		}
	}
	
	function deletePortfolioItem($id, $domainId) {
		global $smarty;
		
		if($this->accessLevel($domainId) > 0) {
			$this->db->StartTrans();
			
			$query = 'DELETE FROM portfolioitem WHERE id='.$this->db->qstr($id).' AND domainid='.$this->db->qstr($domainId);
			
			$this->db->Execute($query);
			
			$this->db->completeTrans();
			
			$smarty->assign('messages', array(_('Portfolio Item Successfully Deleted')));
			
			return true;
		} else {
			$smarty->assign('messages', array(_('Your do not have the correct permissions to delete this portfolio item. If you beleive you should please contact your system administrator.')));
			
			return true;
		}
	}
	function hasSubposts($commentId) {
		$query = 'SELECT id FROM forumpost WHERE forumpostid='.$this->db->qstr(intval($commentId));	
		
		$rs=$this->db->GetOne($query);
		if($rs===false) {
		
			return false;
		}
		
		return true;
	}
	function hasChildren ($pageId)
  {
  	if(!isset($this->children[$pageId])) {
	    $query = "
	      SELECT id FROM webpage
	      WHERE
	      (
	        parentpageid=".$this->db->qstr (intval ($pageId))."
	      )
	    ";
	
	    $result = $this->db->GetOne ($query);
	
	    if ($result === false)
	      {
	        $this->children[$pageId] = false;
	      }
	    else
	      {
	        $this->children[$pageId] = true;
	      }
  	}
  	
  	return $this->children[$pageId];

  }
  
  function hasPortfolioCategoryChildren ($categoryId)
  {
  	if(!isset($this->portfolioCategoryChildren[$categoryId])) {
	    $query = "
	      SELECT id FROM portfoliocategory
	      WHERE
	      (
	        parentcategoryid=".$this->db->qstr (intval ($categoryId))."
	      )
	    ";
	
	    $result = $this->db->GetOne ($query);
	
	    if ($result === false)
	      {
	        $this->portfolioCategoryChildren[$categoryId] = false;
	      }
	    else
	      {
	        $this->portfolioCategoryChildren[$categoryId] = true;
	      }
  	}
  	
  	return $this->portfolioCategoryChildren[$categoryId];

  }
  
  function hasPortfolioItemsChildren ($categoryId)
  {
  	if(!isset($this->portfolioItemsChildren[$categoryId])) {
	    $query = "
	      SELECT id FROM portfolioitem
	      WHERE
	      (
	        portfolioid=".$this->db->qstr (intval ($categoryId))."
	      )
	    ";
	
	    $result = $this->db->GetOne ($query);
	
	    if ($result === false)
	      {
	        $this->portfolioItemsChildren[$categoryId] = false;
	      }
	    else
	      {
	        $this->portfolioItemsChildren[$categoryId] = true;
	      }
  	}
  	
  	return $this->portfolioItemsChildren[$categoryId];

  }
  
  function hasNewsCategoryChildren ($categoryId)
  {
  	if(!isset($this->newsCategoryChildren[$categoryId])) {
	    $query = "
	      SELECT id FROM newscategory
	      WHERE
	      (
	        parentcategoryid=".$this->db->qstr (intval ($categoryId))."
	      )
	    ";
	
	    $result = $this->db->GetOne ($query);
	
	    if ($result === false)
	      {
	        $this->newsCategoryChildren[$categoryId] = false;
	      }
	    else
	      {
	        $this->newsCategoryChildren[$categoryId] = true;
	      }
  	}
  	
  	return $this->newsCategoryChildren[$categoryId];

  }
  
  function hasNewsItemsChildren ($categoryId)
  {
  	if(!isset($this->newsItemsChildren[$categoryId])) {
	    $query = "
	      SELECT id FROM news
	      WHERE
	      (
	        newscategoryid=".$this->db->qstr (intval ($categoryId))."
	      )
	    ";
	
	    $result = $this->db->GetOne ($query);
	
	    if ($result === false)
	      {
	        $this->newsItemsChildren[$categoryId] = false;
	      }
	    else
	      {
	        $this->newsItemsChildren[$categoryId] = true;
	      }
  	}
  	
  	return $this->newsItemsChildren[$categoryId];

  }
  
	function saveFile($_POST, $fileId, $domainId, $pageId = null, $portfolioId = null) {
		global $smarty;
		if(isset($_POST['company']))unset($_POST['company']);
		if(isset($_POST['person']))unset($_POST['person']);
		if($fileId != '') $mode = 'UPDATE';
		else $mode = 'INSERT';

		$errors = array();
		if(($mode == 'INSERT') && !isset($_FILES['file']['name'])) $errors[] = _('Please upload a file');
		else if($this->accessLevel($domainId) >= 0) {

			if(isset($_FILES['file']) && ($_FILES['file']['error'] != UPLOAD_ERR_NO_FILE)) {
				$uploadedfile = EGS_TMP_DIR.'/'.md5(uniqid(time())).basename($_FILES['file']['name']);

				if(!move_uploaded_file($_FILES['file']['tmp_name'], $uploadedfile)) $errors[] = _('Error with uploaded file');
				else chmod($uploadedfile, 0655);
			}

			if(sizeof($errors) ==0) {
				$file = array();

				if($mode == 'INSERT') {
					$file['id'] = $this->db->GenID('file_id_seq');
					$file['name'] = $_FILES['file']['name'];
				}
				else $file['id'] = $fileId;
			
				if(isset($_POST['notes'])) $file['note'] = $_POST['notes'];
				else $file['note']='';
				if(isset($_FILES['file']) && ($_FILES['file']['error'] != UPLOAD_ERR_NO_FILE)) {
					$file['name'] = $_FILES['file']['name'];
					$file['type'] = $_FILES['file']['type'];
					$file['size'] = $_FILES['file']['size'];
				}

				if(!$this->db->replace('file', $file, 'id', true))
					echo "error";

				if(isset($_FILES['file']['name'])  && ($_FILES['file']['error'] != UPLOAD_ERR_NO_FILE)) {
					$this->db->UpdateBlobFile('file', 'file', $uploadedfile, 'id='.$file['id']);
					unlink($uploadedfile);	
					$rev=$this->db->GetOne('SELECT revision FROM file WHERE id='.$file['id']);
					
					if(!isset($rev)||$rev=='')$rev=0;
					$rev++;
					$q = 'UPDATE file SET revision='.$rev.' WHERE id='.$file['id'];
					
					$this->db->Execute($q);
					
					if(isset($pageId) && ($mode == 'INSERT')) $this->db->Execute('INSERT INTO webpagefile VALUES ('.$this->db->qstr($pageId).', '.$this->db->qstr($file['id']).')');
					if(isset($portfolioId) && ($mode == 'INSERT')) $this->db->Execute('INSERT INTO portfolioitemimages VALUES ('.$this->db->qstr($portfolioId).', '.$this->db->qstr($file['id']).')');
				}

				$messages = array();
				if($mode == 'INSERT') $messages[] = _('File successfully uploaded');
				else $messages[] = _('File successfully updated');

				$smarty->assign('messages', $messages);
				return true;
			}
		} else {
			$errors[] = _('You do not have the correct permissions to upload a file. If you beleive you should please contact your system administrator');
		}

		$smarty->assign('errors', $errors);

		return false;
	}

	function savePortfolioItem($_POST, $id) {
		global $smarty;
		if(isset($_POST['company']))unset($_POST['company']);
		if(isset($_POST['person']))unset($_POST['person']);
		$errors = array();

		if(!isset($_POST['name'])) {
			$errors[] = _('No Title');
		}

		if((sizeof($errors) == 0) && ($this->accessLevel($_POST['domainid']) >= 0)) {
			
			if(!isset($id)) {
				$mode = 'INSERT';
				$_POST['id'] = $this->db->GenID('portfolioitem_id_seq');
				$_POST['owner'] = EGS_USERNAME;
				$_POST['added'] = $this->db->DBTimeStamp(time());
			} else $mode = 'UPDATE';

			unset($_POST['save']);
			unset($_POST['companyname']);
			unset($_POST['MAX_FILE_SIZE']);
			
			$_POST['updated'] = $this->db->DBTimeStamp(time());
			$_POST['alteredby'] = EGS_USERNAME;
			if(!isset($_POST['description']))$_POST['description']='';
			$this->db->StartTrans();

			$this->db->Replace('portfolioitem', $_POST, 'id', true);
			/*removed ($mode == 'INSERT') && from the start of the conditional below for making CM'd front-ends easier*/
			if( isset($_FILES['file']) && ($_FILES['file']['error'] != UPLOAD_ERR_NO_FILE)) {
				$this->saveFile($_POST, null, $_POST['domainid'], null, $_POST['id']);
			}
	
			$this->db->CompleteTrans();

			$smarty->assign('messages', array(_('Portfolio Item Successfully Saved')));
			
			return true;
		} else {
			$smarty->assign('errors', $errors);
			return false;
		}
	}
	
	function saveNews($_POST, $announcement = false) {
		global $smarty;
		
		$errors = array();
		if(isset($_POST['company']))unset($_POST['company']);
		if(isset($_POST['person']))unset($_POST['person']);
		if(!isset($_POST['headline'])) $errors[] = _('Please enter a headline it is a compulsory field');
		if(!isset($_POST['published'])) $errors[] = _('Please enter a published date it is a compulsory field');
		if(!isset($_POST['teaser'])) $errors[] = _('Please enter a teaser it is a compulsory field');
		if((isset($_POST['showfrom']) && (isset($_POST['showuntil']))) && (strtotime($_POST['showfrom']) >= strtotime($_POST['showuntil']))) $errors[] = _('Please ensure that the show from time is before the show until time');
		
		/* It is OK to do the save */
		if(sizeof($errors) == 0) {
			$article = array();

			if (isset($_POST['id']))
				$mode = 'UPDATE';
			else
				$mode = 'INSERT';

			if ($mode == 'INSERT') 
				$article['id'] = $this->db->GenID('news_id_seq');
			else $article['id'] = $_POST['id'];
			
			$article['domainid'] = $_POST['domainid'];
			$article['headline'] = $_POST['headline'];
			$article['published'] = $_POST['published'];
			$article['teaser'] = $_POST['teaser'];
			$article['body'] = $_POST['body'];
			if(isset($_POST['visible'])) $article['visible'] = 'true';
			else $article['visible'] = 'false';
			
			if(isset($_POST['external'])) $article['external'] = 'true';
			else $article['external'] = 'false';
			
			if(isset($_POST['frontpage'])) $article['frontpage'] = 'true';
			else $article['frontpage'] = 'false';
			
			if(isset($_POST['showfrom'])) $article['showfrom'] = $_POST['showfrom'];
			if(isset($_POST['showuntil'])) $article['showuntil'] = $_POST['showuntil'];
			
			if(isset($_POST['newscategoryid'])) $article['newscategoryid'] = $_POST['newscategoryid'];
			if(isset($_POST['url'])) $article['url'] = $_POST['url'];
			
			$article['companyid'] = EGS_COMPANY_ID;
			$article['alteredby'] = EGS_USERNAME;
			$article['updated'] = date('Y-m-d H:i', time());
			
			if($announcement) $article['news'] = 'false';

			$this->db->Replace('news', $article, 'id', true);

			if($announcement) $smarty->assign('messages', array(_('Announcement Successfully Saved')));
			else $smarty->assign('messages', array(_('News Article Successfully Saved')));

			return true;
		} else {
			$smarty->assign('errors', $errors);
			
			return false;	
		}
	}
	/**
	 * Deletes a comment (forum-post)- won' delete top-level comments
	 */
	function deleteComment($id) {
		$query = 'DELETE FROM forumpost WHERE forumpostid IS NOT NULL AND id='.$this->db->qstr($id).' AND companyid='.EGS_COMPANY_ID;
		if($this->db->Execute($query))
			return true;
		return false;	
	}
	/**
	 * Save a comment (forum-post)
	 */
	 function saveComment($_POST,$id) {
	 	if(isset($_POST['id']))
	 		$comment['id']=$_POST['id'];
	 	else
	 		$comment['id']=$this->db->GenID('forumpost_id_seq');
	 	if(isset($_POST['title']))
	 		$comment['title']=$_POST['title'];
	 	else
	 		$comment['id']='';	
	 	if(isset($_POST['message']))
	 		$comment['message']=$_POST['message'];
	 	else
	 		$comment['idmessage']='';
	 	if(isset($_POST['approved'])&&$_POST['approved']=='yes') {
	 		$comment['approved']='t';
	 	}
	 	else
	 		$comment['approved']='f';
	 	$comment['companyid']=EGS_COMPANY_ID;
	 	$comment['personid']=10686;	
	 
	 	if(!$this->db->Replace('forumpost',$comment,'id',true))
	 		return false;
	 	return true;
	 		
	 }
}
?>
