<?php
	require_once(EGS_FILE_ROOT.'/src/classes/class.ticket.php');

	$ticket = new ticket();
			
	if($ticket->ticketAccess($_GET['id'])) {
		if(isset($_POST['edit'])) {
			
			print_r($_POST);
			$hours['id']=$db->GenID('projecthours_id_seq');
			$hours['hours']=$_POST['hours'].':'.$_POST['minutes'].':00';
			$hours['username']=EGS_USERNAME;
			$hours['added']='now()';
			$hours['updated']='now()';
			$hours['ticketid']=$_GET['id'];
			
			$db->Replace('projecthours',$hours,'id',true);
			
			foreach($_POST as $key=>$val) {
				unset($_POST[$key]);	
			}
			if(isset($_GET['edit']))
				unset($_GET['edit']);
		}
		if (sizeof($_POST) > 0) $ticket->saveReply($_POST);
		
		$query = 'SELECT t.id, t.queueid, t.owner, '.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 't.time').' AS created, CASE WHEN u.updated IS NULL THEN '.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 't.time').' ELSE '.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 'u.updated').' END AS updated, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 't.deadline').' AS deadline, CASE WHEN t.createdby IS NULL THEN '.$db->qstr(_('Ticketing System')).' ELSE t.createdby END AS createdby, t.owner, i.name AS internalqueue, c.name AS company, c.id AS companyid, p.firstname || \' \' || p.surname AS person, p.id AS personid, t.priority, t.internalpriority, t.status, t.internalstatus, CASE WHEN t.private THEN '.$db->qstr(_('Yes')).' ELSE '.$db->qstr(_('No')).' END AS private, t.subject, t.body FROM ticket t LEFT OUTER JOIN (SELECT parentticketid, max(time) AS updated FROM ticket GROUP BY parentticketid) u ON (t.id=u.parentticketid) LEFT OUTER JOIN company c ON (t.companyid=c.id) LEFT OUTER JOIN person p ON (t.personid=p.id) LEFT OUTER JOIN internalqueue i ON (t.internalqueueid=i.id) WHERE t.id='.$db->qstr($_GET['id']);

	$ticketData = $db->GetRow($query);
	
		if(isset($_GET['show'])) {
		        $_SESSION['showtickets'][intval($_GET['show'])] = 'show';
		}

		if(isset($_GET['hide'])) {
        		$_SESSION['showtickets'][intval($_GET['hide'])] = 'hide';
		}
		
			/* Add to last viewed */
			$_SESSION['preferences']['lastViewed'] = array_slice(array_merge(array('module=ticketing&amp;action=view&amp;id='.intval($_GET['id']) => array('ticket', $ticketData['queueid'].'-'.$ticketData['id'])), $_SESSION['preferences']['lastViewed']), 0, EGS_RECENTLY_VIEWED);

			/* Sync view to preferences */
			$egs->syncPreferences();

			$smarty->assign('pageTitle', _('Ticket: ').$ticketData['queueid'].'-'.$ticketData['id']);
			$smarty->assign('pageEdit', 'action=saveticket&amp;id='.intval($_GET['id']));
			$smarty->assign('pageDelete', 'action=deleteticket&amp;id='.intval($_GET['id']));

			$leftData = array();
			$leftData[] = array('tag' => _('Ticket ID'), 'data' => $ticketData['queueid'].'-'.$ticketData['id']);
			$leftData[] = array('tag' => _('Received'), 'data' => $ticketData['created']);
			$leftData[] = array('tag' => _('Last Updated'), 'data' => $ticketData['updated']);
			$leftData[] = array('tag' => _('Deadline'), 'data' => $ticketData['deadline']);
			$leftData[] = array('span' => true);
			$leftData[] = array('tag' => _('Sub Queue'), 'data' => $ticketData['internalqueue']);
			$leftData[] = array('tag' => _('Private'), 'data' => $ticketData['private']);
			$leftData[] = array('span' => true);

			$leftData[] = array('tag' => _('Created By'), 'data' => $ticketData['createdby']);
			$leftData[] = array('tag' => _('Assigned To'), 'data' => $ticketData['owner']);
			
			$rightData = array();
			
			$rightData[] = array('tag' => _('Company Assigned To'), 'data' => $ticketData['company']);
			$rightData[] = array('tag' => _('Person Assigned To'), 'data' => $ticketData['person']);
			$rightData[] = array('span' => true);
			$rightData[] = array('tag' => _('Client Priority'), 'data' => $ticket->translatePriority($ticketData['priority']));
			$rightData[] = array('tag' => _('Internal Priority'), 'data' => $ticket->translatePriority($ticketData['internalpriority']));
			$rightData[] = array('span' => true);
			$rightData[] = array('tag' => _('Client Status'), 'data' => $ticket->translateStatus($ticketData['status']));
			$rightData[] = array('tag' => _('Internal Status'), 'data' => $ticket->translateStatus($ticketData['internalstatus']));
			
			$rightSpan = array();

				$query = 'SELECT type, message, name, '.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 'timestamp').' AS timestamp, timestamp as realtimestamp FROM ticketlogoverview WHERE ticketid='.$db->qstr($_GET['id']).' ORDER BY realtimestamp';
	
				$rs = $db->Execute($query);
				
				$messages = array();
				$messages['title'] = _('Ticket Log');
				$messages['type'] = 'data';
				
				while(!$rs->EOF) {
					$messages['data'][] = $ticket->translateLogMessage($rs->fields);
					$rs->MoveNext();
				}
			
			$rightSpan[] = $messages;
			
			$query = 'SELECT f.id, f.name, f.type, f.size FROM file f, ticketfile t WHERE f.id=t.fileid AND t.ticketid='.$db->qstr($_GET['id']).' ORDER BY f.created';
	
				$rs = $db->Execute($query);
				
				$files = array();
				$files['title'] = _('Files');
				$files['type'] = 'data';
				
				while(!$rs->EOF) {
					$files['data'][] = $rs->fields['name'];
					$rs->MoveNext();
				}
			
			$rightSpan[] = $files;
			if(isset($_GET['edit'])&&$_GET['edit']=='hours') {
				$hours['type']='new';
				$headings=array('hours'=>_('Hours'),'minutes'=>_('Minutes'));
				$hours['headings']=$headings;
				
				
			}
			else {
				$query = 'SELECT h.id, h.username, '.$db->SQLDate('d-m-Y H:i', 'h.entered').' as entered, h.hours FROM projecthours h WHERE h.ticketid='.$db->qstr($_GET['id']).' ORDER BY h.entered DESC';
					
					$rs=$db->Execute($query);
				
					$hours=array();
					$hours['title']=_('Hours');
					$hours['edit']='action=view&amp;id='.$_GET['id'].'&amp;edit=hours';
					
					
					$hours['type']='data';
					while(!$rs->EOF) {
						$hours['data'][$rs->fields['id']]=$rs->fields['username'].' - '.$rs->fields['hours'].' - '.$rs->fields['entered'];	
						$rs->MoveNext();
					}
			}
			$rightSpan[]=$hours;
			
			
			$bottomData = array();
			
			$reply = array();
			
			$reply['type'] = 'displayreply';
			$reply['content'] = $ticketData['body'];
			
			$bottomData[] = $reply;
			
			$query = 'SELECT id, subject, body, type, owner FROM ticket WHERE parentticketid='.$db->qstr($_GET['id']).' ORDER BY id';

			$rs = $db->Execute($query);

			while(!$rs->EOF) {
				$reply = array();

				$reply['type'] = 'reply';				
				$reply['header'] = $rs->fields['subject'];
				
				if($rs->fields['type'] == 'S') $reply['header'] .= ' ('._('Response sent to Client by ').$rs->fields['owner'].')';
				else if($rs->fields['type'] == 'N') $reply['header'] .= ' ('._('Internal Note by ').$rs->fields['owner'].')';
				else if($rs->fields['type'] == 'E') $reply['header'] .= _(' (Client Response via Email)');

				if(isset($_SESSION['showtickets'][$rs->fields['id']]) && ($_SESSION['showtickets'][$rs->fields['id']] == 'show')) {
					 $reply['hide'] = true;
					$reply['body'] = $rs->fields['body'];
				}

				$reply['id'] = $rs->fields['id'];
				
				$bottomData[] = $reply;
				$rs->MoveNext();
			}
			
			$reply = array();
			
			$reply['type'] = 'addreply';
			$reply['content'] = $ticketData['body'];
			
			$bottomData[] = $reply;

			$smarty->assign('view', true);
			$smarty->assign('leftData', $leftData);
			$smarty->assign('rightData', $rightData);
			$smarty->assign('rightSpan', $rightSpan);
			$smarty->assign('bottomData', $bottomData);
	} else {
		$smarty->assign('errors', array(_('You do not have the correct permissions to access this ticket. If you believe you should please contact your system administrator')));
		
		$smarty->assign('redirect', true);
		$smarty->assign('redirectAction', 'action=overview');
	}
?>
