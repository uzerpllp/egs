<?php  
class project {
	function project() {
		global $db;
		$this->db = & $db;
	}
 
 	function getProjects() {
 		if($this->isAdmin()) {
 			$query = 'SELECT id, name FROM project WHERE ownercompanyid='.$this->db->qstr(EGS_COMPANY_ID).' ORDER BY name';
 		} else {
 			$query = 'SELECT p.id, p.name FROM project p, projectaccess a WHERE p.id=a.projectid AND a.type>1 AND a.companyid='.$this->db->qstr(EGS_COMPANY_ID).' ORDER BY name';
 		}	
 		
 		$rs =  $this->db->Execute($query);
 		
 		$projects = array('' => _('All Projects'));
 		
 		while(!$rs->EOF) {
 			$projects[$rs->fields['id']] = $rs->fields['name'];
 				
 			$rs->MoveNext();
 		}
 		
 		return $projects;
 	}
 	
	/* Get the access level the current user has for a person */
	function accessLevel($id) {
		if (!isset ($access[$id])) {
			$query = 'SELECT type FROM projectaccess WHERE projectid='.$this->db->qstr($id).' AND companyid='.$this->db->qstr(EGS_COMPANY_ID).' AND username='.$this->db->qstr(EGS_USERNAME);
			
			$rs = $this->db->GetOne($query);

			if ($rs === false)
				return -1;

			$this->access[$id] = $rs;
		}

		return $this->access[$id];
	}
	
	function isAdmin() {
		$query = 'SELECT username FROM useraccess WHERE (projectmanager OR superuser) AND companyid='.$this->db->qstr(EGS_COMPANY_ID).' AND username='.$this->db->qstr(EGS_USERNAME);

		$rs = $this->db->GetOne($query);

		if ($rs === false) return false;
		else return true;
	}
	
	function accessHours($hoursId, $projectId) {
		if (!isset ($hoursAccess[$hoursId])) {
			if($this->accessLevel($projectId > 0)) $this->hoursAccess[$hoursId] = true;
			else {
				$query = 'SELECT id FROM projecthours WHERE projectid='.$this->db->qstr($id).' AND id='.$this->db->qstr($hoursId).' AND username='.$this->db->qstr(EGS_USERNAME);
	
				$rs = $this->db->GetOne($query);
	
				if ($rs === false)
					return -1;
	
				$this->access[$hoursId] = true;
			}
		}

		return $this->hoursAccess[$hoursId];
	}

	function saveProject($_POST, $id = null) {
		global $egs, $smarty;
		if(isset($_POST['company']))unset($_POST['company']);
		if(isset($_POST['person']))unset($_POST['person']);
		if ($id != '')
			$id = intval($id);

		/* Array to hold errors */
		$errors = array ();

		require_once (EGS_FILE_ROOT.'/src/classes/class.company.php');
		$company = new company();
		require_once (EGS_FILE_ROOT.'/src/classes/class.person.php');
		$person = new person();

		/* Check details are valid  - starting with the name */
		if (!isset ($_POST['name']))
			$errors[] = _('No Name');
		if (!isset ($_POST['startdate']))
			$errors[] = _('No Start Date');
		if (!isset ($_POST['enddate']))
			$errors[] = _('No End Date');
		/* Check start date is before end date */
		if ((isset ($_POST['startdate']) && isset ($_POST['enddate'])) && (strtotime($_POST['enddate']) < strtotime($_POST['startdate'])))
			$errors[] = _('The end date is before the start date');
		if (!isset ($_POST['companyid']))
			$errors[] = _('No Account');
		if (isset ($_POST['companyid']) && !$company->accessLevel($_POST['companyid']))
			$errors[] = _('You do not have the correct access to attach this project to the company you have chosen.');
		if (isset ($_POST['personid']) && !$person->accessLevel($_POST['personid']))
			$errors[] = _('You do not have the correct access to attach this project to the contact you have chosen.');

		/* No errors so we can save */
		if (sizeof($errors) == 0) {
			/* Set weather to insert or update */
			if ($id != null)
				$mode = 'UPDATE';
			else
				$mode = 'INSERT';

			if (($mode == 'UPDATE') && ($this->accessLevel($id) < 1)) {
				$smarty->assign('errors', array (_('You do not have the correct access to update this project. If you beleive you should please contact your system administrator.')));
			}

			/* If we are doing an insert set some defaults */
			if ($mode == 'INSERT') {
				$_POST['id'] = $this->db->GenID('project_id_seq');

				$query = 'SELECT max(jobno) FROM project WHERE ownercompanyid='.$this->db->qstr(EGS_COMPANY_ID);

				$_POST['jobno'] = $this->db->GetOne($query) + 1;
				$_POST['owner'] = EGS_USERNAME;
			} else if(isset($_POST['opportunityid'])) unset($_POST['opportunityid']);

			$_POST['alteredby'] = EGS_USERNAME;
			$_POST['ownercompanyid'] = EGS_COMPANY_ID;
			unset ($_POST['save']);
			unset ($_POST['personname']);
			unset ($_POST['companyname']);
			unset ($_POST['startdateoutput']);
			unset ($_POST['enddateoutput']);
			if(isset($_POST['company'])) unset($_POST['company']);
			if(!isset($_POST['description']))
				$_POST['description']='';
			/* Start a transaction */
			$this->db->StartTrans();

			if ($mode == 'UPDATE') {
				$_POST['updated'] = $this->db->DBTimeStamp(time());
			}

			/* Insert the company */
			if (!$this->db->Replace('project', $_POST, 'id', true))
				$errors[] = _('Error saving project');
				
			/* We need to delete the ical files on updating */
			if ($mode == 'UPDATE') {
				$query = 'SELECT p.owner FROM person p, resource r WHERE p.id=r.personid AND p.userdetail AND r.projectid='.$this->db->qstr($_POST['id']);

				$rs = $this->db->Execute($query);
				
				while (isset($rs->EOF) && !$rs->EOF) {
					if(file_exists(EGS_FILE_ROOT.'/modules/calendar/calendars/'.EGS_COMPANY_ID.'/projects'.$rs->fields['owner'].'.ics')) unlink(EGS_FILE_ROOT.'/modules/calendar/calendars/'.EGS_COMPANY_ID.'/projects'.$rs->fields['owner'].'.ics');
					
					$rs->MoveNext();	
				}
			}
				
			/* Set up the groups if flyspray enabled */
			if($this->db->GetOne('SELECT tablename FROM pg_tables WHERE schemaname=\'company'.EGS_COMPANY_ID.'\' AND tablename LIKE \'flyspray_%\'')) {
				if ($mode == 'INSERT') {
					/* Set up the admin groups */
					$groupId = $this->db->GenID('company'.EGS_COMPANY_ID.'.flyspray_groups_group_id_seq');
					
					$query = 'INSERT INTO company'.EGS_COMPANY_ID.'.flyspray_groups 
						(
							group_id,
							group_name, 
							group_desc, 
							belongs_to_project, 
							is_admin, 
							manage_project, 
							view_tasks, 
							open_new_tasks, 
							modify_own_tasks, 
							modify_all_tasks, 
							view_comments, 
							add_comments, 
							edit_comments, 
							delete_comments, 
							view_attachments, 
							create_attachments, 
							delete_attachments, 
							view_history, 
							close_own_tasks, 
							close_other_tasks, 
							assign_to_self, 
							assign_others_to_self, 
							view_reports, 
							group_open
						) 
						VALUES 
						(
							'.$this->db->qstr($groupId).',
							'.$this->db->qstr('Project Admins').',
							'.$this->db->qstr(_('Members have unlimited access to all functionality.')).',
							'.$this->db->qstr($_POST['id']).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).'
						)';
						
						$this->db->Execute($query);
						
						$query = 'SELECT p.id FROM person p, useraccess a WHERE p.owner=a.username AND p.userdetail AND a.companyid='.$this->db->qstr(EGS_COMPANY_ID).' AND a.projectmanager';
						
						$rs = $this->db->Execute($query);
						
						$stmt = $this->db->Prepare('INSERT INTO company'.EGS_COMPANY_ID.'.flyspray_users_in_groups (user_id, group_id) VALUES (?, ?)');
	
						while(!$rs->EOF) {
							$this->db->Execute($stmt, array($rs->fields['id'], $groupId));
							$rs->MoveNext();
						}
						
						/* Set up the project managers groups */
						$query = 'INSERT INTO company'.EGS_COMPANY_ID.'.flyspray_groups 
						(
							group_name, 
							group_desc, 
							belongs_to_project, 
							is_admin, 
							manage_project, 
							view_tasks, 
							open_new_tasks, 
							modify_own_tasks, 
							modify_all_tasks, 
							view_comments, 
							add_comments, 
							edit_comments, 
							delete_comments, 
							view_attachments, 
							create_attachments, 
							delete_attachments, 
							view_history, 
							close_own_tasks, 
							close_other_tasks, 
							assign_to_self, 
							assign_others_to_self, 
							view_reports, 
							group_open
						) 
						VALUES 
						(
							'.$this->db->qstr('Project Managers').',
							'.$this->db->qstr(_('Members have unlimited access to all project functionality.')).',
							'.$this->db->qstr($_POST['id']).',
							'.$this->db->qstr(0).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).'
						)';
						
						$this->db->Execute($query);
						
						/* Set up developers groups */
						$query = 'INSERT INTO company'.EGS_COMPANY_ID.'.flyspray_groups 
						(
							group_name, 
							group_desc, 
							belongs_to_project, 
							is_admin, 
							manage_project, 
							view_tasks, 
							open_new_tasks, 
							modify_own_tasks, 
							modify_all_tasks, 
							view_comments, 
							add_comments, 
							edit_comments, 
							delete_comments, 
							view_attachments, 
							create_attachments, 
							delete_attachments, 
							view_history, 
							close_own_tasks, 
							close_other_tasks, 
							assign_to_self, 
							assign_others_to_self, 
							view_reports, 
							group_open
						) 
						VALUES 
						(
							'.$this->db->qstr('Project Developers').',
							'.$this->db->qstr(_('Project Developers.')).',
							'.$this->db->qstr($_POST['id']).',
							'.$this->db->qstr(0).',
							'.$this->db->qstr(0).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).'
						)';
						
						$this->db->Execute($query);
						
						/* Set up testers groups */
						$query = 'INSERT INTO company'.EGS_COMPANY_ID.'.flyspray_groups 
						(
							group_name, 
							group_desc, 
							belongs_to_project, 
							is_admin, 
							manage_project, 
							view_tasks, 
							open_new_tasks, 
							modify_own_tasks, 
							modify_all_tasks, 
							view_comments, 
							add_comments, 
							edit_comments, 
							delete_comments, 
							view_attachments, 
							create_attachments, 
							delete_attachments, 
							view_history, 
							close_own_tasks, 
							close_other_tasks, 
							assign_to_self, 
							assign_others_to_self, 
							view_reports, 
							group_open
						) 
						VALUES 
						(
							'.$this->db->qstr('Project Testers').',
							'.$this->db->qstr(_('Open new tasks / add comments in all projects.')).',
							'.$this->db->qstr($_POST['id']).',
							'.$this->db->qstr(0).',
							'.$this->db->qstr(0).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(0).',
							'.$this->db->qstr(0).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(0).',
							'.$this->db->qstr(0).',
							'.$this->db->qstr(1).',
							'.$this->db->qstr(0).',
							'.$this->db->qstr(0).',
							'.$this->db->qstr(0).',
							'.$this->db->qstr(0).',
							'.$this->db->qstr(0).',
							'.$this->db->qstr(0).',
							'.$this->db->qstr(0).',
							'.$this->db->qstr(0).',
							'.$this->db->qstr(1).'
						)';
						
						$this->db->Execute($query);
				} else {
					$adminGroupId = $this->db->GetOne('SELECT group_id FROM company'.EGS_COMPANY_ID.'.flyspray_groups WHERE group_name='.$this->db->qstr('Project Admins').' AND belongs_to_project='.$this->db->qstr($_POST['id']));
					
					//$usersInGroups = array('user_id')
				}
			}

			$this->db->completeTrans();
		}

		/* If there are no errors return true and set success message */
		if (sizeof($errors) == 0) {
			$messages = array ();
			if ($mode == 'INSERT')
				$messages[] = _('Project Successfully Added');
			else
				$messages[] = _('Project Successfully Updated');

			$smarty->assign('messages', $messages);
			return true;
		} else {
			$smarty->assign('errors', $errors);
			return false;
		}
	}

	function saveTask($_POST, $id = null,$progressonly=false) {
		global $egs, $smarty;
		if(isset($_POST['company']))unset($_POST['company']);
		if(isset($_POST['person']))unset($_POST['person']);
		if(isset($_POST['milestone'])) {
			$_POST['enddate'] = $_POST['startdate'];
			unset($_POST['durationselect']);
			unset($_POST['duration']);
		}

		if ($id != '')
			$id = intval($id);

		/* Update the enddate if the duration is set */
		if (isset ($_POST['durationselect']) && isset ($_POST['duration'])) {
			if ($_POST['durationselect'] == 'days')
				$_POST['enddate'] = date('Y-m-d', (strtotime($_POST['startdate']) + ($_POST['duration'] * 86400)));
			else
				if ($_POST['durationselect'] == 'hours')
					$_POST['enddate'] = date('Y-m-d', (strtotime($_POST['startdate']) + ($_POST['duration'] * 3600)));
		}

		/* Array to hold errors */
		$errors = array ();

		/* Check details are valid  - starting with the name */
		if (!isset ($_POST['name']))
			$errors[] = _('No Name');
		if (!isset ($_POST['startdate']))
			$errors[] = _('No Start Date');
		/* Check start date is before end date */
		if ((isset ($_POST['startdate']) && isset ($_POST['enddate'])) && (strtotime($_POST['enddate']) < strtotime($_POST['startdate'])))
			$errors[] = _('The end date is before the start date');
		if (!isset ($_POST['enddate']) && !isset ($_POST['duration']))
			$errors[] = _('No Duration or End Date');
		if ($this->accessLevel($_POST['projectid']) < 1 && !$progressonly) {
			$errors=array();
			$errors[] = _('You do not have the correct access to update this task. If you beleive you should please contact your system administrator.');
			$smarty->assign('errors', $errors);
		}

		/* No errors so we can save */
		if (sizeof($errors) == 0) {
			/* Set weather to insert or update */
			if ($id != null)
				$mode = 'UPDATE';
			else
				$mode = 'INSERT';

			/* If we are doing an insert set some defaults */
			if ($mode == 'INSERT') {
				$_POST['id'] = $this->db->GenID('projecttask_id_seq');
				$_POST['owner'] = EGS_USERNAME;
			}

			$_POST['alteredby'] = EGS_USERNAME;
			unset ($_POST['save']);
			unset ($_POST['startdateoutput']);
			unset ($_POST['enddateoutput']);

			if(isset($_POST['progress'])) $_POST['progress'] = min(100, max(0, intval($_POST['progress'])));
                        else $_POST['progress'] = 0;

			if (isset ($_POST['durationselect']) && isset ($_POST['duration'])) {
				$_POST['duration'] .= ' '.$_POST['durationselect'];
			}

			unset ($_POST['durationselect']);

			/* Start a transaction */
			$this->db->StartTrans();

			/* Get the start date of the project so we can shift the task start date if it is before the project start */
			$query = 'SELECT startdate FROM project WHERE id='.$this->db->qstr($_POST['projectid']);

			$projectStart = strtotime($this->db->getOne($query));
			$interval = strtotime($_POST['startdate']) - $projectStart;

			if ($interval < 0) {
				$_POST['startdate'] = date('Y-m-d', (strtotime($_POST['startdate']) - $interval));
				$_POST['enddate'] = date('Y-m-d', (strtotime($_POST['enddate']) - $interval));
			}

			if ($mode == 'UPDATED') {
				$_POST['updated'] = $this->db->DBTimeStamp(time());
			}

			if(isset($_POST['milestone'])) {
				$_POST['milestone'] = true;
				$_POST['enddate'] = $_POST['startdate'];
			}

			/* Insert the company */
			if (!$this->db->Replace('projecttask', $_POST, 'id', true))
				$errors[] = _('Error saving task');

			/* Update parent tasks if set */
			if (isset ($_POST['parenttaskid'])&&($_POST['parenttaskid']!=''))
				$this->updateParentTasks($_POST['parenttaskid'], $_POST['startdate'], $_POST['enddate']);
				
			$this->updateDependencies($_POST['id'], $_POST['startdate'], $_POST['enddate']);
			
			$this->db->completeTrans();
		}

		/* If there are no errors return true and set success message */
		if (sizeof($errors) == 0) {
			$messages = array ();
			if ($mode == 'INSERT')
				$messages[] = _('Task Successfully Added');
			else
				$messages[] = _('Task Successfully Updated');
			if(isset($smarty))
				$smarty->assign('messages', $messages);
			return true;
		} else {
			$smarty->assign('errors', $errors);
			return false;
		}
	}

	function updateParentTasks($taskId, $startDate, $endDate) {
		/* Build a query to get the tasks parent id */
		$query = '
				      SELECT id FROM projecttask
				      WHERE
				      (
				        id='.$this->db->qstr(intval($taskId)).'
				      )
				    ';

		/* Send the query */
		$taskId = $this->db->getOne($query);

		/* If the task has a parent */
		if ($taskId !== false) {

			/* Get the start and end of all it's children */
			$query = '
						        SELECT min(startdate) AS startdate, max(enddate) AS enddate, avg(progress) AS progress
						        FROM projecttask
						        WHERE
						        (
						          parenttaskid='.$this->db->qstr(intval($taskId)).'
						        )
						      ';

			/* Send the query */
			$row = $this->db->GetRow($query);

			/* Update start and end if present */
			if ($row['startdate'] == "") {
				$row['startdate'] = $startDate;
			}

			if ($row['enddate'] == "") {
				$row['enddate'] = $endDate;
			}

			if ($row['enddate'] != "") {
				/* Update the parent task's start and end */
				$query = '
								            UPDATE projecttask SET
								              startdate='.$this->db->qstr($row['startdate']).',
								              enddate='.$this->db->qstr($row['enddate']).',
											  progress='.$this->db->qstr(intval($row['progress'])).'
								            WHERE
								            (
								              id='.$this->db->qstr(intval($taskId)).'
								            )
								          ';

				/* Send the query */
				$this->db->Execute($query);

			} else {
				$query = 'UPDATE projecttask SET progress='.$this->db->qstr(intval($row['progress'])).' WHERE id='.$this->db->qstr(intval($taskId));
				
				$this->db->Execute($query);
			}
				

			/* Get the tasks parent */
			$query = '
						        SELECT parenttaskid, startdate, enddate FROM projecttask
						        WHERE
						        (
						          id='.$this->db->qstr(intval($taskId)).'
						        )
						       ';

			/* Send the query */
			$rs = $this->db->Execute($query);

			/* Now iterate over the tasks */
			while (!$rs->EOF) {
				/* Build a query to get thetasks parent id */
				$query = '
								              SELECT count(*) FROM projecttask
								              WHERE
								              (
								                parenttaskid='.$this->db->qstr(intval($rs->fields['parenttaskid'])).'
								              )
								            ';

				/* Send the query */
				$result = $this->db->GetOne($query);

				/* If the task has a parent */
				if ($result !== false) {
					$query = "
										                  DELETE FROM projecttaskdependencies
										                  WHERE
										                  (
										                    taskid=".$this->db->qstr(intval($rs->fields['parenttaskid']))."
										                  )
										                ";

					/* Send the query */
					$this->db->Execute($query);
				}

				/* Call recursively to update */
				$this->updateParentTasks($rs->fields['parenttaskid'], $rs->fields['startdate'], $endDate);

				/* Call recursively to update */
				$this->updateDependencies($taskId, $rs->fields['startdate'], $endDate);

				$rs->MoveNext();
			}
		}
	}

	function updateDependencies($taskId, $startDate, $endDate) {
		$query = '
		    SELECT d.taskid, p.startdate, p.enddate FROM projecttaskdependencies d, projecttask p
		    WHERE
		    (
		      d.dependsontaskid='.$this->db->qstr(intval($taskId)).'
		      AND
		      p.id=d.taskid
		    )
		   ';

		/* Send the database query */
		$rs = $this->db->Execute($query);

			while (!$rs->EOF) {
				$query = '
				           UPDATE projecttask
				           SET
				             startdate = CASE WHEN startdate > date '.$this->db->quote($endDate).' THEN startdate  ELSE date '.$this->db->quote($endDate).'  + interval \'1 day\' END,
				             enddate = CASE WHEN startdate > date '.$this->db->quote($endDate).' THEN enddate ELSE date '.$this->db->quote($endDate).' + age(date '.$this->db->qstr($rs->fields['enddate']).', date '.$this->db->qstr($rs->fields['startdate']).')  + interval \'1 day\' END
				           WHERE
				           (
				            id='.$this->db->qstr(intval($rs->fields['taskid'])).'
				           )
				         ';

				$this->db->Execute($query);

				$query = '
				          SELECT id, startdate, enddate FROM projecttask
				          WHERE
				          (
				            id='.$this->db->qstr(intval($rs->fields['taskid'])).'
				          )
				         ';

				/* Send the database query */
				$row2= $this->db->GetRow($query);

				$this->updateDependencies($row2['id'], $row2['startdate'], $row2['enddate']);

				$this->updateParentTasks($row2['id'], $row2['startdate'], $row2['enddate']);
				
				$rs->MoveNext();
			}

		return true;
	}

	function saveHours($_POST, $id = null) {
		global $egs, $smarty;
		if(isset($_POST['company']))unset($_POST['company']);
		if(isset($_POST['person']))unset($_POST['person']);
		if ($id != '')
			$id = intval($id);

		/* Array to hold errors */
		$errors = array ();

		/* Check details are valid  - starting with the name */
		if (!isset ($_POST['projectid']))
			$errors[] = _('No Project');
		if (!isset ($_POST['hours']) && !isset($_POST['minutes']))
			$errors[] = _('No Hours or Minutes');
		if (isset($_POST['minutes']) && (($_POST['minutes'] < 0) || ($_POST['minutes'] > 59)))
			$errors[] = _('Invalid Minutes - must be between 0 and 59');
		if (!isset ($_POST['entered']))
			$errors[] = _('No Entered Date');

		/* No errors so we can save */
		if (sizeof($errors) == 0) {
			/* Set weather to insert or update */
			if ($id != null)
				$mode = 'UPDATE';
			else
				$mode = 'INSERT';

			if (($mode == 'UPDATE') && ($this->accessLevel($_POST['projectid']) < 0)) {
				$smarty->assign('errors', array (_('You do not have the correct access to update these hours. If you beleive you should please contact your system administrator.')));
			}

			/* If we are doing an insert set some defaults */
			if ($mode == 'INSERT') {
				$_POST['id'] = $this->db->GenID('projecthours_id_seq');
				$_POST['username'] = EGS_USERNAME;
			}

			$_POST['alteredby'] = EGS_USERNAME;
			unset ($_POST['save']);
			unset ($_POST['enteredoutput']);

			if(isset($_POST['billable'])) $_POST['billable'] = 'true';
			else $_POST['billable'] = 'false';
			if(isset($_POST['overtime'])) $_POST['overtime'] = 'true';
			else $_POST['overtime'] = 'false';
			if(isset($_POST['invoiced'])) $_POST['invoiced'] = 'true';
			else $_POST['invoiced'] = 'false';
			
			/* Set the time spent */
			if(isset($_POST['minutes']) && (($_POST['minutes'] > 0) && ($_POST['minutes'] < 60))) {
				if(isset($_POST['hours'])) $_POST['hours'] .= ' hours '.sprintf('%02s', $_POST['minutes']).' minutes';
				else $_POST['hours'] = '0 hours '.sprintf('%02s', $_POST['minutes']).' minutes';
				unset($_POST['minutes']);
			} else if(isset($_POST['minutes'])) {
				unset($_POST['minutes']);
				$_POST['hours'] .= ' hours';
			} else {
				$_POST['hours'] .= ' hours';
			}

			/* Start a transaction */
			$this->db->StartTrans();

			if ($mode == 'UPDATED') {
				$_POST['updated'] = $this->db->DBTimeStamp(time());
			}

			/* Insert the company */
			if (!$this->db->Replace('projecthours', $_POST, 'id', true))
				$errors[] = _('Error saving project hours');

			$this->db->completeTrans();
		}

		/* If there are no errors return true and set success message */
		if (sizeof($errors) == 0) {
			$messages = array ();
			if ($mode == 'INSERT')
				$messages[] = _('Hours Successfully Added');
			else
				$messages[] = _('Hours Successfully Updated');

			$smarty->assign('messages', $messages);
			return true;
		} else {
			$smarty->assign('errors', $errors);
			return false;
		}
	}
	
	function savePriority($_POST, $id = null) {
		global $egs, $smarty;
		if(isset($_POST['company']))unset($_POST['company']);
		if(isset($_POST['person']))unset($_POST['person']);
		if ($id != '')
			$id = intval($id);

		/* Array to hold errors */
		$errors = array ();

		/* Check details are valid  - starting with the name */
		if (!isset ($_POST['save']))
			$errors[] = _('No Name for Priority');

		/* Check if name is taken */
		$query = 'SELECT id FROM projecttaskpriority WHERE lower(name)='.$this->db->qstr(strtolower($_POST['save'])).' AND id<>'.$this->db->qstr(intval($id)).' AND projectid='.$this->db->qstr($_POST['projectid']);
		
		if($this->db->GetOne($query) !== false) $errors[] = _('Priority Name is already in use');
		/* No errors so we can save */
		if (sizeof($errors) == 0) {
			/* Set weather to insert or update */
			if ($id != null) {
				$mode = 'UPDATE';
				$_POST['id'] = intval($id);
			}
			else
				$mode = 'INSERT';

			if (($mode == 'UPDATE') && ($this->accessLevel($_POST['projectid']) < 0)) {
				$smarty->assign('errors', array (_('You do not have the correct access to update these hours. If you beleive you should please contact your system administrator.')));
			} else {

			/* If we are doing an insert set some defaults */
			if ($mode == 'INSERT') $_POST['id'] = $this->db->GenID('projecthours_id_seq');

			/* Start a transaction */
			$this->db->StartTrans();

			if ($mode == 'UPDATED') {
				$_POST['updated'] = $this->db->DBTimeStamp(time());
			}

			$_POST['name'] = $_POST['save'];
			unset($_POST['save']);
			unset($_POST['savetype']);
			
			/* Insert the company */
			if (!$this->db->Replace('projecttaskpriority', $_POST, 'id', true))
				$errors[] = _('Error saving project task priority');

			$this->db->completeTrans();
			}
		}

		/* If there are no errors return true and set success message */
		if (sizeof($errors) == 0) {
			$messages = array ();
			if ($mode == 'INSERT')
				$messages[] = _('Priority Successfully Added');
			else
				$messages[] = _('Priority Successfully Updated');

			$smarty->assign('messages', $messages);
			return true;
		} else {
			$smarty->assign('errors', $errors);
			return false;
		}
	}

	function freeResource($personId, $companyId, $projectId) {
		if (isset ($personId))
			$query = 'SELECT id FROM resource WHERE projectid='.$this->db->qstr($projectId).' AND personid='.$this->db->qstr($personId);
		else
			$query = 'SELECT id FROM resource WHERE projectid='.$this->db->qstr($projectId).' AND companyid='.$this->db->qstr($companyId);

		$rs = $this->db->GetOne($query);

		if ($rs === false)
			return true;

		return false;
	}

	function saveResource($_POST, $id = null) {
		global $egs, $smarty;
		if(isset($_POST['company']))unset($_POST['company']);
		if(isset($_POST['person']))unset($_POST['person']);
		if ($id != '')
			$id = intval($id);

		/* Array to hold errors */
		$errors = array ();

		/* Check details are valid  - starting with the name */
		if (!isset ($_POST['personid']) && !isset ($_POST['companyid']))
			$errors[] = _('No Resource');
		if ($this->accessLevel($_POST['projectid']) < 1)
			$errors[] = _('You do not have the correct access to update this project. If you beleive you should please contact your system administrator.');
		if (!isset ($id) && isset ($_POST['personid']) && !$this->freeResource($_POST['personid'], null, $_POST['projectid']))
			$errors[] = _('The resource you are trying to add has already been attached to this project');
		if (!isset ($id) && isset ($_POST['companyid']) && !$this->freeResource(null, $_POST['companyid'], $_POST['projectid']))
			$errors[] = _('The resource you are trying to add has already been attached to this project');

		/* No errors so we can save */
		if (sizeof($errors) == 0) {
			/* Set weather to insert or update */
			if ($id != null)
				$mode = 'UPDATE';
			else
				$mode = 'INSERT';

			if (($mode == 'UPDATE') && ($this->accessLevel($_POST['projectid']) < 1)) {
				$smarty->assign('errors', array (_('You do not have the correct access to update this resource. If you beleive you should please contact your system administrator.')));
				return false;
			}

			/* If we are doing an insert set some defaults */
			if ($mode == 'INSERT') {
				$_POST['id'] = $this->db->GenID('resource_id_seq');
			}

			unset ($_POST['save']);
			unset ($_POST['personname']);
			unset ($_POST['companyname']);
			if (isset ($_POST['projectmanager']))
				$_POST['projectmanager'] = 'true';
			else
				$_POST['projectmanager'] = 'false';

			if (isset ($_POST['personid']))
				unset ($_POST['companyid']);
			else
				unset ($_POST['personid']);

			/* Start a transaction */
			$this->db->StartTrans();

			/* Insert the resource */
			if (!$this->db->Replace('resource', $_POST, 'id', true))
				$errors[] = _('The was an error saving the resource, please try again later.');

			/* Put the person into the bug groups */
			if(($mode == 'INSERT') && isset($_POST['personid']) && ($this->db->GetOne('SELECT tablename FROM pg_tables WHERE schemaname=\'company'.EGS_COMPANY_ID.'\' AND tablename LIKE \'flyspray_%\'') !== false)) {
				$query = 'SELECT id FROM person WHERE id='.$this->db->qstr($_POST['personid']).' AND userdetail';
				
				if($this->db->GetOne($query)) {
					$groupID = $this->db->GetOne('SELECT group_id FROM company'.EGS_COMPANY_ID.'.flyspray_groups WHERE group_name='.$this->db->qstr('Project Developers').' AND belongs_to_project='.$this->db->qstr($_POST['projectid']).' LIMIT 1');
					
					$query = 'INSERT INTO company'.EGS_COMPANY_ID.'.flyspray_users_in_groups (user_id, group_id) VALUES ('.$this->db->qstr($_POST['personid']).', '.$groupID.')';
					
					if($groupID !== false) $this->db->Execute($query);	
				}
			}

			$this->db->completeTrans();
		}

		/* If there are no errors return true and set success message */
		if (sizeof($errors) == 0) {
			$messages = array ();
			if ($mode == 'INSERT')
				$messages[] = _('Resource Successfully Added');
			else
				$messages[] = _('Resource Successfully Updated');

			$smarty->assign('messages', $messages);
			return true;
		} else {
			$smarty->assign('errors', $errors);
			return false;
		}
	}

	function updateManagers($_POST, $id) {
		if ($this->accessLevel($id) > 0) {
			/* Start a transaction */
			$this->db->StartTrans();

			$query = 'UPDATE resource SET projectmanager='.$this->db->qstr('false').' WHERE projectid='.$this->db->qstr($id);

			$this->db->Execute($query);

			$query = 'UPDATE resource SET projectmanager='.$this->db->qstr('true').' WHERE projectid='.$this->db->qstr($id).' AND id=?';

			$stmt = $this->db->Prepare($query);

			while ($resource = array_pop($_POST))
				$this->db->Execute($stmt, array ($resource));

			$this->db->completeTrans();
		}
	}
	
	function updateResources($_POST, $projectId, $taskId) {

		if ($this->accessLevel($projectId) > 0) {
			/* Start a transaction */
			$this->db->StartTrans();

			$query = 'DELETE FROM projecttaskresources WHERE taskid='.$this->db->qstr($taskId);

			$this->db->Execute($query);

			$query = 'INSERT INTO projecttaskresources (taskid, resourceid) VALUES ('.$this->db->qstr($taskId).', ?)';

			$stmt = $this->db->Prepare($query);

			while ($resource = array_pop($_POST))
				$this->db->Execute($stmt, array ($resource));

			$this->db->completeTrans();
		}
	}

	function deleteTask($projectId, $taskId) {
		global $smarty;
		
		if($this->accessLevel($projectId) > 0) {
			$this->db->startTrans();

        /* Get the origianl parent task incase we are changing it */
        $query = '
                SELECT 
                  parenttaskid
                FROM projecttask
                WHERE
                (
                  id='.$this->db->qstr (intval ($taskId)).'
                  AND
                  projectid='.$this->db->qstr (intval ($projectId)).'
                )
              ';

        /* Send the query */
        $row = $this->db->GetRow ($query);

		if(isset($row['parenttaskid'])) {

        /* Update all children tasks to the task's parent */
        $query = '
          UPDATE projecttask
          SET
            parenttaskid='.$this->db->qstr ($row['parenttaskid']).'
          WHERE
          (
            parenttaskid='.$this->db->qstr (intval ($taskId)).'
          )
        ';

        /* Send the query */
        $this->db->Execute($query);

        /* Build a query to get the childrens tasks start and end dates */
        $query = '
          SELECT parenttaskid, startdate, enddate
          FROM projecttask
          WHERE
            (
              parenttaskid='.$this->db->qstr (intval ($row['parenttaskid'])).'
            )
        ';

        /* Send the query */
        $rs = $this->db->Execute ($query);

        /* Update the start and end dates for all the children */
        while (!$rs->EOF)
          {
            $this->updateParentTasks ($rs->fields['parenttaskid'], $rs->fields['startdate'],
                                      $rs->fields['enddate']);
                                      
			$rs->MoveNext();
          }
		}
			$query = 'DELETE FROM projecttask WHERE id='.$this->db->qstr($taskId).' AND projectid='.$this->db->qstr($projectId);

			$this->db->Execute($query);
		
			
			$this->db->completeTrans();

			$smarty->assign('messages', array(_('Task successfully deleted')));
			
			return true;
		} else {
			$smarty->assign('errors', array(_('You do not have the correct permissions to delete this task. If you believe you should please contact your system administrator.')));
			
			return false;
		}
	}
	
	function deletePriority($projectId, $priorityId) {
		if($this->accessLevel($projectId) > 0) {
			$query = 'DELETE FROM projecttaskpriority WHERE id='.$this->db->qstr($priorityId).' AND projectid='.$this->db->qstr($projectId);

			$this->db->Execute($query);

			return true;
		} else {
			return false;
		}
	}
	
	function deleteResource($resourceId, $projectId) {
		global $smarty, $egs;
		if($this->accessLevel($projectId) > 0) {
			$query = 'DELETE FROM resource WHERE id='.$this->db->qstr($resourceId).' AND projectid='.$this->db->qstr($projectId);

			$this->db->Execute($query);

			$smarty->assign('messages', array(_('Resource successfully deleted')));
			
			return true;
		} else {
			$smarty->assign('errors', array(_('You do not have the correct permissions to delete this resource. If you believe you should please contact your system administrator.')));
			
			return false;
		}
	}
	
	function deleteProject($projectId) {
		global $smarty, $egs;
		if($this->isAdmin()) {
			$query = 'DELETE FROM project WHERE id='.$this->db->qstr($projectId).' AND ownercompanyid='.$this->db->qstr(EGS_COMPANY_ID);

			$this->db->Execute($query);

			$smarty->assign('messages', array(_('Project successfully deleted')));
			
			unset($_SESSION['preferences']['lastViewed']['module=projects&amp;action=view&amp;id='.$projectId]);
			
			$egs->syncPreferences();
			
			return true;
		} else {
			$smarty->assign('errors', array(_('You do not have the correct permissions to delete this project. If you believe you should please contact your system administrator.')));
			
			return false;
		}
	}
	
	function toggleProject($projectId, $type) {
		global $smarty, $egs;
		if($this->isAdmin()) {
			$query = 'UPDATE project SET '.$type.'=CASE WHEN '.$type.' THEN false ELSE true END WHERE id='.$this->db->qstr($projectId).' AND ownercompanyid='.$this->db->qstr(EGS_COMPANY_ID);

			$this->db->Execute($query);

			return true;
		}
	}
	
	function deleteHours ($projectId, $hoursId) {
		global $smarty;
		
		if($this->accessHours($projectId, $hoursId)) {
			$query = 'DELETE FROM projecthours WHERE id='.$this->db->qstr($hoursId).' AND projectid='.$this->db->qstr($projectId);

			$this->db->Execute($query);
			
			$smarty->assign('messages', array(_('Hours successfully deleted.')));
			
			return true;
		} else {
			$smarty->assign('errors', array(_('You do not have the correct access to delete these hours. If you believe you should please contact your system administrator.')));
		}
			
		return false;
	}

  function gantt($projectId)
  {
    require_once ( EGS_FILE_ROOT.'/src/jpgraph/jpgraph.php');
    require_once (EGS_FILE_ROOT.'/src/jpgraph/jpgraph_gantt.php');
    /* Get all the contacts the user can view */
    $query = "
      SELECT id FROM 
      taskoverview
      WHERE
      (
      	projectid=".$this->db->qstr (intval ($projectId))."
        AND parenttaskid IS NULL
      )
      ORDER BY startdate
    ";


    $tasks = array();
    $progress = array();
    $depends = array();
    $rows = array();
    
     $counter = 0;
    
    /* Send the query */
    $result = $this->db->Execute($query);
  while (!$result->EOF)
      {
  	$row = $result->fields;
        /* Strip html/php */
        while (list ($key, $val) = each ($row))
          {
            $row[$key] = stripslashes (trim ($row[$key]));
          }   
      
	$indent = null;
 
        /* Format the task */
        $this->formatGanttTask ($row['id'], $projectId, $indent, $tasks, $progress, $depends, $rows, $counter);

        /* Get the children tasks */
        $this->getGanttChildren ($row['id'], $projectId, 1, $tasks,$progress, $depends, $rows, $counter);
        
       $result->MoveNext(); 
      }
      
      $query = "
        SELECT name FROM project WHERE id=".$this->db->qstr(intval($projectId))."
      ";
      
      /* Send the query */
      $row = $this->db->GetRow ($query);
      
      // Create the basic graph
$graph = new GanttGraph ();
$graph->title-> Set($row['name']);

// Setup scale
$graph->ShowHeaders( GANTT_HYEAR | GANTT_HDAY | GANTT_HWEEK);
$graph->scale-> week->SetStyle(WEEKSTYLE_FIRSTDAY);

// Add the specified activities
$graph->CreateSimple( $tasks, $depends, $progress);

// .. and stroke the graph
$graph->Stroke(); 
  }

  /* Function to get all the task that are a child of the requested task */
  function getGanttChildren ($taskId, $projectId, $indent, &$tasks, &$progress, &$depends, &$rows, &$counter)
  {
    /* Build a query to get all the child tasks */
    $query = '
    SELECT id FROM projecttask
    WHERE 
    (
      parenttaskid = '.$this->db->qstr (intval ($taskId)).' AND
      projectid='.$this->db->qstr(intval ($projectId)).'
    )
    ORDER BY startdate
    ';

    /* Send the query */
    $result = $this->db->Execute ($query);

            /* For each child task */
            while (!$result->EOF)
              {
		$row = $result->fields;
                /* Format/output the task */
                $this->formatGanttTask ($row['id'], $projectId, $indent, $tasks, $progress, $depends, $rows, $counter);

                $indent++;

                /* Then get it's children */
                $this->getGanttChildren ($row['id'], $projectId, $indent,
                                    $tasks, $progress, $depends, $rows, $counter);

                $indent--;
		$result->MoveNext();
              }

  }

  /* Function to parse a task in the overview */
  function formatGanttTask ($taskId, $projectId, $indent, &$tasks, &$progress, &$depends, &$rows, &$counter)
  {
    /* Build a query to get all the details */
    $query = '
    SELECT * FROM taskoverview   
    WHERE 
    (
      id='.$this->db->qstr (intval ($taskId)).'
    )
    LIMIT 1;
    ';

    /* Fetch the result */
    $row = $this->db->GetRow ($query);
    
    /* This is to translate html values back */
    $trans = get_html_translation_table(HTML_ENTITIES);
    $trans = array_flip($trans);

    /* Strip html/php */
    while (list ($key, $val) = each ($row))
      {
        $row[$key] = strtr(stripslashes (trim ($row[$key])), $trans);
      }

    $counter++;
    
    $pad = "";
    
    for($i=0; $i<$indent; $i++)
    {
     $pad .= "  ";
    }
    
    if($row['milestone'] == "t")
    {
      array_push($tasks, array(($counter-1) ,ACTYPE_MILESTONE , $pad.$row['name'], $row['startdate'],"",""));
    }
    else if($this->hasChildren($taskId))
    {
      array_push($tasks, array(($counter-1) ,ACTYPE_GROUP , $pad.$row['name'], $row['startdate'],$row['enddate'],""));
      array_push($progress, array(($counter-1), (intval($row['progress'])/100)));
    }
    else 
    {
      array_push($tasks, array(($counter-1) ,ACTYPE_NORMAL , $pad.$row['name'], $row['startdate'],$row['enddate'],""));
      array_push($progress, array(($counter-1), (intval($row['progress'])/100)));
    }
    
    $rows[$row['id']] = ($counter - 1);
    
    $query = '
      SELECT * FROM projecttaskdependencies
      WHERE taskid='.$this->db->qstr(intval($taskId)).'
    ';
    
    /* Send the query */
    $result = $this->db->Execute ($query);

    /* Strip html/php */
    while (!$result->EOF) {
	$row = $result->fields;
        array_push($depends, array($rows[$row['dependsontaskid']], ($counter-1), CONSTRAIN_ENDSTART));

	$result->MoveNext();
      }
      
  }

	/* Function to check if a task has children */
  function hasChildren ($taskId)
  {
  	if(!isset($this->children[$taskId])) {
	    $query = "
	      SELECT id FROM projecttask
	      WHERE
	      (
	        parenttaskid=".$this->db->qstr (intval ($taskId))."
	      )
	    ";
	
	    $result = $this->db->GetOne ($query);
	
	    if ($result === false)
	      {
	        $this->children[$taskId] = false;
	      }
	    else
	      {
	        $this->children[$taskId] = true;
	      }
  	}
  	
  	return $this->children[$taskId];

  }
  
  function updateTaskDependencies($_POST, $projectId, $taskId)
  {
  	global $smarty;
    /* Check the users has access to update task resources */
    if (($this->accessLevel ($projectId) < 1) && (!$this->hasChildren($taskId)))
      {
        $smarty->assign('errors', array(_('You do not the correct permissions to update this task. If you beleive you should please contact your system administrator')));
      }
    else
      {
        $this->db->StartTrans();

        /* Remove existing resources */
        $query = '
          DELETE FROM projecttaskdependencies
          WHERE
          (
           taskid='.$this->db->qstr (intval ($taskId)).'
          )
        ';

        /* Send the database query */
        $this->db->Execute ($query);

        /* We have a database error so send back the error message and
           rollback the database */
        if(isset($_POST['values']) && (sizeof($_POST['values']) >0))
          {
            
            $query = '
              SELECT max(enddate) AS enddate FROM projecttask
              WHERE
              (
            ';
            
            /* Iterate over resources and assign them to the task */
            for ($i = 0; $i < sizeof ($_POST['values']); $i++)
              {
                $query2 = '
                  INSERT INTO projecttaskdependencies
                  (
                    taskid,
                    dependsontaskid
                  )
                  VALUES
                  (
                    '.$this->db->qstr(intval($taskId)).',
                    '.$this->db->qstr(intval($_POST['values'][$i])).'
                  )
                ';
                
                $this->db->Execute($query2);
                
                $query .= '
            		id='.$this->db->quote(intval($_POST['values'][$i])).'	
            	 ';
                
                
                if($i != (sizeof($_POST['values'])-1))
                {
                 $query .= '
                  OR
                 '; 
                }
              }

            $query .= '
              )
            ';

            /* Send the database query */
            $row = $this->db->GetRow($query);

            $dependencyEnd = $row['enddate'];
            $dependencyEndParts = explode("-", $dependencyEnd);
            
            $query = '
              SELECT startdate, enddate FROM projecttask
              WHERE
              (
                id='.$this->db->qstr(intval($taskId)).'
              )
            ';
            
            /* Send the database query */
            $row = $this->db->GetRow ($query);

            $taskStart = $row['startdate'];
            $taskStartParts = explode("-", $taskStart);
            
            if(intval($taskStartParts[0].$taskStartParts[1].$taskStartParts[2]) <= intval($dependencyEndParts[0].$dependencyEndParts[1].$dependencyEndParts[2]))
            {
              $query = '
                UPDATE projecttask
                SET
                  startdate= (date '.$this->db->quote($dependencyEnd).' + interval \'1 day\'),
                  enddate= (date '.$this->db->quote($dependencyEnd).' + age(date '.$this->db->quote($row['enddate']).', date '.$this->db->quote($row['startdate']).') + interval \'1 day\')
                WHERE
                (
                  id='.$this->db->quote(intval($taskId)).'
                )
              ';
              
              $this->db->Execute($query);
              
              //function updateParentTasks ($taskId, $startDate, $endDate)      
            }
            
            $query = '
              SELECT id, startdate, enddate FROM projecttask
              WHERE
              (
                id='.$this->db->qstr(intval($taskId)).'
              )
            ';
            
            /* Send the database query */
            $row = $this->db->GetRow ($query);
            
            $this->updateDependencies($row['id'], $row['startdate'], $row['enddate']);
            
            $this->updateParentTasks($row['id'], $row['startdate'], $row['enddate']);
            
            $this->db->completeTrans();

          }


        $smarty->assign('messages', array(_('Dependencies successfully updated')));
    }
  }
}
?>
