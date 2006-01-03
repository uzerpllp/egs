<?php
class ticket {
	function ticket() {
		global $db;
		$this->db = & $db;
	}
	
	function translatePriority($priority) {
		switch($priority) {
			case 0:
				return _('Emergency');
				break;
			case 1:
				return _('Urgent');
				break;
			case 2:
				return _('High');
				break;	
			case 3:
				return _('Normal');
				break;	
			case 4:
				return _('Low');
				break;	
			case 5:
				return _('Long Term');
				break;	
		}
	}
	
	function translateStatus($status) {
		switch($status) {
			case 'CRE':
				return _('Created');
				break;
			case 'OPN':
				return _('Opened');
				break;
			case 'LOC':
				return _('Locked');
				break;
			case 'DEL':
				return _('Deleted');
				break;
			case 'MOV':
				return _('Moved');
				break;
			case 'CLO':
				return _('Closed');
				break;
			case 'FIX':
				return _('Fixed');
				break;
			case 'WON':
				return _('Won\'t Fix');
				break;
			case 'INV':
				return _('Invalid');
				break;
			case 'CTE':
				return _('Closed by Staff');
				break;
			case 'CCL':
				return _('Closed by Client');
				break;
			case 'WTE':
				return _('Waiting on Staff');
				break;
			case 'WCL':
				return _('Waiting on Client');
				break;				
		}	
	}
	
	function translateLogMessage($message) {
		switch ($message['type']) {
			case 'E':
				return($message['timestamp'].' '._('Ticket Created').' '.$message['message']).' '.$message['name'];
				break;
			case 'P':
				return($message['timestamp'].' '._('Ticket Created in System').' '.$message['message']).' '.$message['name'];
				break;
			case 'COM':
				return($message['timestamp'].' '._('Company:').' '.$message['message']).' '.$message['name'];
				break;
			case 'SUB':
				return($message['timestamp'].' '._('Subject:').' '.$message['message']).' '.$message['name'];
				break;
			case 'PER':
				return($message['timestamp'].' '._('Person:').' '.$message['message']).' '.$message['name'];
				break;
			case 'INT':
				return($message['timestamp'].' '._('Internal Queue').' '.$message['message']).' '.$message['name'];
				break;
			case 'STA':
				return($message['timestamp'].' '._('Status').' '.$this->translateStatus($message['message'])).' '.$message['name'];
				break;
			case 'IST':
				return($message['timestamp'].' '._('Internal Status').' '.$this->translateStatus($message['message'])).' '.$message['name'];
				break;
			case 'PRV':
				return($message['timestamp'].' '._('Ticket made private').' '.$message['message']).' '.$message['name'];
				break;
			case 'PUB':
				return($message['timestamp'].' '._('Ticket made public').' '.$message['message']).' '.$message['name'];
				break;
			case 'PRI':
				return($message['timestamp'].' '._('Priority:').' '.$this->translatePriority($message['message'])).' '.$message['name'];
				break;
			case 'IPR':
				return($message['timestamp'].' '._('Internal Priority').' '.$this->translatePriority($message['message'])).' '.$message['name'];
				break;
			case 'DED':
				return($message['timestamp'].' '._('Deadline:').' '.$message['message']).' '.$message['name'];
				break;
			case 'OWN':
				return($message['timestamp'].' '._('Assigned to:').' '.$message['message']).' '.$message['name'];
				break;
			case 'FIL':
				return($message['timestamp'].' '._('File Attached:').' '.$message['message']).' '.$message['name'];
				break;
			case 'MER':
				return($message['timestamp'].' '._('Ticket merged with:').' '.$message['message']).' '.$message['name'];
				break;
			case 'UME':
				return($message['timestamp'].' '._('Ticket unmerged').' '.$message['message']).' '.$message['name'];
				break;			
		}
	}
	
	function ticketAccess ($ticketId)
  {
    /* Query to check use */
  $query = "
      SELECT id FROM ticket t, queueaccess a
      WHERE
      (
        t.id=".$this->db->qstr ($ticketId)."
        AND
        t.queueid=a.queueid
        AND
        a.companyid=".$this->db->qstr (EGS_COMPANY_ID)."
        AND
        a.username=".$this->db->qstr (EGS_USERNAME)."
        AND
        (
          t.owner=".$this->db->qstr (EGS_USERNAME)."
          OR
          t.createdby=".$this->db->qstr (EGS_USERNAME)."
          OR
          t.private <> true
        )
        AND
        t.parentticketid IS NULL
      )
    ";

    if ($this->db->GetOne($query) === false)
      {
        return false;
      }
    else
      {
        return true;
      }
  }
  
   /* Function to return user's access level for a queue */
  function queueAccess ($queueId)
  {
    /* We haven't got the access before so make a db query */
    if (!isset ($this->queueAccess[intval ($queueId)]))
      {
        /* Query to get the access level for this queue */
        $query = "
        SELECT access FROM queueaccess
        WHERE
        (
          queueid=".$this->db->qstr (intval ($queueId))."
          AND
          username=".$this->db->qstr (EGS_USERNAME)."
          AND
          companyid=".$this->db->qstr (EGS_COMPANY_ID)."
        )
        ";

        /* Send the query */
        $accessLevel = $this->db->GetOne($query);

        /* If no results, then return -1 */
        if ($accessLevel === false)
          {
            $this->queueAccessLevel[intval ($queueId)] = -1;
          }
        else
          {
            /* Set the access level. This is a built in caching mechanism so
               we don't have to keep making the same query */
            $this->queueAccessLevel[intval ($queueId)] = $accessLevel;
          }
      }

    /* Return the access level */
    return $this->queueAccessLevel[intval ($queueId)];
  }
  
  function saveReply ($_POST, $recurse = true, $type = 'S') {
	global $smarty;
	if(isset($_POST['company']))unset($_POST['company']);
		if(isset($_POST['person']))unset($_POST['person']);
	if(isset($_POST['internal']) && ($_POST['internal'] == 'true')) $type = 'N';
  	/* Check we have access to save a reply to this ticket */
  	if($this->ticketAccess($_POST['ticketid'])) {
  		$query = '
      SELECT t.id, t.fromaddress, t.queueid, q.name AS queuename, t.subject, q.address, q.actualaddress FROM ticket t, ticketqueue q
      WHERE
      (
        t.id='.$this->db->qstr (intval ($_POST['ticketid'])).'
        AND
        t.parentticketid IS NULL
        AND
        t.queueid=q.id
      )
      ';

  		$reply = $this->db->GetRow($query);
  		$_POST['queueid'] = $reply['queueid'];
  		
  		 $query = '
        INSERT INTO ticket
        (
          queueid,
          subject,
          body,
          owner,
          parentticketid,
          type
        )
        VALUES
        (
          '.$this->db->qstr (intval ($_POST['queueid'])).',
          '.$this->db->qstr ('['.$reply['queueid'].'-'.$reply['id'].' UPDATE] Re: '.trim ($reply['subject'])).',
          '.$this->db->qstr ($_POST['body']).',
          '.$this->db->qstr (EGS_USERNAME).',
          '.$this->db->qstr (intval ($_POST['ticketid'])).',
          '.$this->db->qstr ($type).'
        )
      ';

        $result = $this->db->Execute ($query);
        
        if($result !== false) {
        	
        	if($type != 'N') {
         mail ($reply['fromaddress'],
              "[{$reply['queueid']}-{$reply['id']} UPDATE] Re: ".
              trim (strip_tags ($reply['subject'])), stripslashes($_POST['body']),
              "From: {$reply['queuename']} <{$reply['actualaddress']}>\r\n".
              "X-Mailer: EGS Ticketing System");
        	}

        if($recurse)
        {
          $mergedId = $this->mergedId($_POST['ticketid']);

          $query = '
          SELECT id FROM ticket
          WHERE
          (
            (
              mergedticketid='.$this->db->quote(intval($mergedId)).' OR
              id='.$this->db->quote(intval($mergedId)).'
            )
            AND
            id<>'.$this->db->quote(intval($_POST['ticketid'])).'
            AND
            parentticketid IS NULL
          )
          ';

        $rs = $this->db->Execute ($query);

        while(!$rs->EOF)
        {
          $_POST['ticketid'] = $rs->fields['id'];
          $this->insertReply($_POST, false);
        }

        $rs->MoveNext();
        }
        
  		$smarty->assign('messages', array(_('Reply successfully sent.')));
        } else 
        {
        	$smarty->assign('error', array(_('There was an error sending the reply, please try again.')));
        }
  		
  		return true;
  		
  	}
  	
  	$smarty->assign('errors', array(_('You do not have the correct permissions to add a reply to this ticket.')));
  	
  	$smarty->assign('redirect', true);
		$smarty->assign('redirectAction', 'action=overview');
		
  	return false;
  }
  
  function mergedId($ticketId)
  {
        $query = '
        SELECT mergedticketid FROM ticket
        WHERE
        (
          id='.$this->db->qstr(intval($ticketId)).'
        )
        ';

        $rs = $this->db->Execute ($query);

        while(!$rs->EOF)
        {
          if($rs->fields['mergedticketid'] != "")
          {
            $ticketId = $rs->fields['mergedticketid'];
          }
          
          $rs->MoveNext();
        }

      return $ticketId;
  }
  
  function deleteTicket($ticketId) {
  	if($this->ticketAccess($ticketId)) {
  	$query = '
  		UPDATE ticket SET status='.$this->db->qstr('DEL').', internalstatus='.$this->db->qstr('DEL').' WHERE id='.$this->db->qstr($ticketId);
  		
  	$this->db->Execute($query);
  	}
  }
  
  function saveTicket($_POST, $id = null) {
		global $egs, $smarty;
		if(isset($_POST['company']))unset($_POST['company']);
		if(isset($_POST['person']))unset($_POST['person']);
		if(isset($_POST['queue']))unset($_POST['queue']);
		if(isset($_POST['internalqueue']))unset($_POST['internalqueue']);
		if ($id != '')
			$id = intval($id);

		/* Array to hold errors */
		$errors = array ();

		/* Check details are valid  - starting with the subject */
		if (!isset ($_POST['subject']))
			$errors[] = _('No Subject');
		if (!isset ($_POST['personid']))
			$errors[] = _('No Person');
		
		$query = 'SELECT email FROM personoverview WHERE id='.$this->db->qstr($_POST['personid']);
			
		$_POST['fromaddress'] = $this->db->GetOne($query);
		
		if($_POST['fromaddress'] == false)
			$errors[] = _('The person you are trying to attach this ticket to does not have an email address. Please use the contacts module to update their email address before you try to add the ticket.');
		if (!isset ($_POST['body']))
			$errors[] = _('No Ticket Body');
		if ($this->queueAccess($_POST['queueid']) < 0)
			$errors[] = _('You do not have the correct access to attach this ticket to the requested queue. If you beleive you should please contact your system administrator.');
			
		/* No errors so we can save */
		if (sizeof($errors) == 0) {
			/* Set weather to insert or update */
			if ($id != null) {
				$mode = 'UPDATE';
				$query = 'SELECT * FROM ticket WHERE id='.$this->db->qstr($id);
				$oldTicket = $this->db->GetRow($query);
			}
			else
				$mode = 'INSERT';

			if (($mode == 'UPDATE') && !$this->ticketAccess($_POST['id'])) {
				$smarty->assign('errors', array (_('You do not have the correct access to update this ticket. If you beleive you should please contact your system administrator.')));
			} else {

			/* If we are doing an insert set some defaults */
			if ($mode == 'INSERT') {
				$_POST['id'] = $this->db->GenID('ticket_id_seq');

				$_POST['owner'] = EGS_USERNAME;
				$_POST['createdby'] = EGS_USERNAME;
				$_POST['time'] = date('Y-m-d h:i:s');
			}

			unset ($_POST['save']);
			unset ($_POST['personname']);
			unset ($_POST['companyname']);
			unset ($_POST['queuename']);
			if(isset($_POST['internalqueuename'])) unset($_POST['internalqueuename']);
			if(isset($_POST['deadlineoutput'])) unset($_POST['deadlineoutput']);
			unset ($_POST['enddateoutput']);
			if(isset($_POST['private'])) $_POST['private'] = 'true';
			else $_POST['private'] = 'false';

			/* Start a transaction */
			$this->db->StartTrans();

			if ($mode == 'UPDATED') {
				$_POST['updated'] = $this->db->DBTimeStamp(time());
			}

			/* Insert the company */
			if (!$this->db->Replace('ticket', $_POST, 'id', true))
				$errors[] = _('Error saving ticket');
				else if($mode == 'INSERT') {

		 $query = '
              SELECT q.id, q.name AS queuename, q.address, q.actualaddress,  q.insertmessage, c.name FROM ticketqueue q, company c
              WHERE
              (
                q.id='.$this->db->qstr ($_POST['queueid']).'
                AND
                c.id=q.companyid
              )
            ';

            $row = $this->db->GetRow($query);

            $message =
          str_replace ("{originalMessage}",
                       trim (strip_tags ($_POST['body'])),
                       str_replace ("{ticketId}", "[{$_POST['queueid']}-{$_POST['id']}]",
                                    str_replace ("{queueName}", $row['queuename'],
                                                 str_replace ("{companyName}",
                                                              $row['name'],
                                                              $row['insertmessage']))));
                                                              

            $this->logger($_POST['id'],$_POST['time'],"SUB", $_POST['subject']);
            $this->logger($_POST['id'],$_POST['time'],$_POST['priority'], 'PRI');
            $this->logger($_POST['id'],$_POST['time'],$_POST['internalpriority'], "I");
            $this->logger($_POST['id'],$_POST['time'],$_POST['status'], null);
            $this->logger($_POST['id'],$_POST['time'],$_POST['internalstatus'], "I");
            if(isset($_POST['internalqueueid']))$this->logger($_POST['id'],$_POST['time'],"INT", null,null,null,$_POST['internalqueueid']);

            if(isset($_POST['deadline']))
            {
              $this->logger($_POST['id'],$_POST['time'],"DED", $_POST['deadline']);
            }

            if(($mode == 'INSERT') && ($_POST['private'] == 'true'))
            {
              $this->logger($_POST['id'],$_POST['time'],"PRV",null);
            }
            else
            {
              $this->logger($_POST['id'],$_POST['time'],"PUB",null);
            }

            if(isset($_POST['companyid']))
            {
              $this->logger($_POST['id'],$_POST['time'],"COM",null, $_POST['companyid']);
            }
            
            if(isset($_POST['personid']))
            {
              $this->logger($_POST['id'],$_POST['time'],"PER",null,null, $_POST['personid']);
            }

            $this->db->CompleteTrans();
			
            mail ($_POST['fromaddress'],
                  "[{$row['id']}-{$_POST['id']} OPENED] Re: ".
                  trim (strip_tags ($_POST['subject'])), $message,
                  "From: {$row['queuename']} <{$row['actualaddress']}>\r\n".
                  "X-Mailer: EGS Ticketing System");
				} else {
					$_POST['time'] = date('Y-m-d h:i:s');

				if(($oldTicket['status'] != 'CLO') && ($_POST['status'] == 'CLO') ) {
					$query = '
              SELECT q.id, q.name AS queuename, q.address, q.actualaddress,  q.closemessage, c.name FROM ticketqueue q, company c
              WHERE
              (
                q.id='.$this->db->qstr ($_POST['queueid']).'
                AND
                c.id=q.companyid
              )
            ';

            $row = $this->db->GetRow($query);

            $message =
          str_replace ("<originalMessage>",
                       trim (strip_tags ($_POST['body'])),
                       str_replace ("<ticketId>", "[{$_POST['queueid']}-{$_POST['id']}]",
                                    str_replace ("<queueName>", $row['queuename'],
                                                 str_replace ("<companyName>",
                                                              $row['name'],
                                                              $row['closemessage']))));
                                                              
                                                              mail ($_POST['fromaddress'],
                  "[{$row['id']}-{$_POST['id']} CLOSED] Re: ".
                  trim (strip_tags ($_POST['subject'])), $message,
                  "From: {$row['queuename']} <{$row['actualaddress']}>\r\n".
                  "X-Mailer: EGS Ticketing System");
				}
                                                              
				if(isset($_POST['subject']) && ($_POST['subject'] != $oldTicket['subject'])) $this->logger($_POST['id'],$_POST['time'],"SUB", $_POST['subject']);
            if(isset($_POST['priority']) && ($_POST['priority'] != $oldTicket['priority'])) $this->logger($_POST['id'],$_POST['time'],$_POST['priority'], 'PRI');
            if(isset($_POST['internalpriority']) && ($_POST['internalpriority'] != $oldTicket['internalpriority'])) $this->logger($_POST['id'],$_POST['time'],$_POST['internalpriority'], "I");
            if(isset($_POST['status']) && ($_POST['status'] != $oldTicket['status'])) $this->logger($_POST['id'],$_POST['time'],$_POST['status'], null);
            if(isset($_POST['internalstatus']) && ($_POST['internalstatus'] != $oldTicket['internalstatus'])) $this->logger($_POST['id'],$_POST['time'],$_POST['internalstatus'], "I");
            if(isset($_POST['internalqueueid']) && ($_POST['internalqueueid'] != $oldTicket['internalqueueid'])) $this->logger($_POST['id'],$_POST['time'],"INT", null,null,null,$_POST['internalqueueid']);

            if(isset($_POST['deadline']) && ($_POST['deadline'] != $oldTicket['deadline'])) 
            {
              $this->logger($_POST['id'],$_POST['time'],"DED", $_POST['deadline']);
            }

            if(isset($_POST['private']) && ($_POST['private'] == 'true') && ($oldTicket['private'] == 'f')) 
            {
              $this->logger($_POST['id'],$_POST['time'],"PRV",null);
            }
            else if(isset($_POST['private']) && ($_POST['private'] == 'false') && ($oldTicket['private'] == 't'))
            {
              $this->logger($_POST['id'],$_POST['time'],"PUB",null);
            }

            if(isset($_POST['companyid']) && ($_POST['companyid'] != $oldTicket['companyid'])) 
            {
              $this->logger($_POST['id'],$_POST['time'],"COM",null, $_POST['companyid']);
            }
            
            if(isset($_POST['personid']) && ($_POST['personid'] != $oldTicket['personid'])) 
            {
              $this->logger($_POST['id'],$_POST['time'],"PER",null,null, $_POST['personid']);
            }

            $this->db->CompleteTrans();
				}
			}
		}
		
		/* If there are no errors return true and set success message */
		if (sizeof($errors) == 0) {
			$messages = array ();
			if ($mode == 'INSERT')
				$messages[] = _('Ticket Successfully Added');
			else
				$messages[] = _('Ticket Successfully Updated');

			$smarty->assign('messages', $messages);
			return true;
		} else {
			$smarty->assign('errors', $errors);
			return false;
		}
	}
	
	function logger($ticketId, $time, $type, $extra=null, $companyId=null, $personId=null, $internalQueueId = null, $mergedTicketId = null, $owner = null)
  {
    $query = '
    INSERT INTO ticketlog
    (type, username, timestamp,ticketid, message, companyid,personid, internalqueueid, mergedticketid, owner)
    VALUES
    (
      '.$this->db->qstr($type).',
      '.$this->db->qstr(EGS_USERNAME).',
      '.$this->db->qstr($time).',
      '.$this->db->qstr($ticketId).',
      '.$this->db->qstr($extra).',';
    if($companyId != null) $query .= $this->db->qstr($companyId).',';
    else $query .= 'NULL,';
    if($personId != null) $query .= $this->db->qstr($personId).',';
    else $query .= 'NULL,';
    if($internalQueueId != null) $query .= $this->db->qstr($internalQueueId).',';
    else $query .= 'NULL,';
    if($mergedTicketId != null) $query .= $this->db->qstr($mergedTicketId).',';
    else $query .= 'NULL,';
    if($owner != null) $query .= $this->db->qstr($owner);
    else $query .= 'NULL';
    
    $query .=
    '
    )
    ';

    $this->db->Execute($query);
  }
}
?>