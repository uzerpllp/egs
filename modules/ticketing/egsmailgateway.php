#!/usr/bin/php 
<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Email Parser for Tickets 1.0     |
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

$fileRoot = "/mnt/websites/egs/egs";

require_once ("{$fileRoot}/conf/demo.senokian.com.config.php");
require_once ("{$fileRoot}/conf/db.php");
require_once ("{$fileRoot}/src/classes/class.mail.php");

function logger($ticketId, $time, $type, $extra, $internalQueueId = null) {
	global $db;

	$log = array ();
	$log['id'] = $db->GenID('ticketlog_id_seq');
	$log['type'] = $type;
	$log['ticketid'] = $ticketId;
	$log['message'] = $extra;
	if ($internalQueueId != '')
		$log['internalqueueid'] = $internalQueueId;
	$log['timestamp'] = $time;

	$result = $db->Replace('ticketlog', $log, 'id', true);
}

function defaultSubQueue($queueId) {
	global $db;

	$query = "
	  SELECT id FROM internalqueue
	  WHERE
	  (
	    queueid=".$db->qstr(intval($queueId))."
	    AND
	    auto
	  )
	  ";

	$defaultSubQueue = $db->GetOne($query);

	if ($defaultSubQueue !== false)
		return $defaultSubQueue;
	else
		return null;
}

// Used to add attached files to issues
function attach_files($issueid, $parser) {
	global $db;
	global $databaseUser;

	// make sure we actually have a issueid
	if (empty ($issueid)) {
		return;
	}

	// Only run through this if we actually have a mime message
	if (count($parser->mime_parts) > 0) {
		foreach ($parser->mime_parts as $mime) {
			// If its an attachment of type base64 then decode
			// and write the file, plain text attachments are
			// automatically added to the parsed mail body

			if (!empty ($mime['filename'])) {

				if (strtolower($mime['content-transfer-encoding']) == "base64") {
					$tmpfname = tempnam("/tmp", "MAIL");

					$handle = fopen($tmpfname, "w");
					fwrite($handle, trim(base64_decode($mime['body'])));
					fclose($handle);

					chmod($tmpfname, 0777);

					$fileType = explode(";", $mime['content-type']);

					$db->StartTrans();
					$fileId = $db->GenID('file_id_seq');

					echo $query = "
					            INSERT INTO file
					            (id,name,type,size,file)
					            VALUES
					            (
					              ".$db->quote($fileId).",
					              ".$db->quote(str_replace("\"", "", str_replace("\";", "", $mime['filename']))).",
					              ".$db->quote(strtolower($fileType[0])).",
					              ".$db->quote(filesize($tmpfname)).",
					              lo_import(".$db->quote($tmpfname).")
					            )
					            ";

					$result = $db->Execute($query);

					$query = "
					            INSERT INTO ticketfile
					            VALUES
					            (
					              ".$db->quote($fileId).",
					              ".$db->quote($issueid)."
					            )
					            ";

					$result = $db->Execute($query);

					$db->completeTrans();
					
					$currtime = date("r");
					logger($issueid, $currtime, 'FIL', str_replace("\"", "", str_replace("\";", "", $mime['filename'])));

					unlink($tmpfname);
				}
			} else
				if (eregi("text\/plain", $mime['content-type']) && isset ($mime['filename'])) {
					$tmpfname = tempnam("/tmp", "MAIL");

					$handle = fopen($tmpfname, "w");
					fwrite($handle, trim($mime['body']));
					fclose($handle);

					chmod($tmpfname, 0777);

					$fileId = $db->GenID('file_id_seq');

					$query = "
					            INSERT INTO file
					            (id,name,type,size,file)
					            VALUES
					            (
					              ".$db->quote($fileId).",
					              ".$db->quote(str_replace("\"", "", $mime['filename'])).",
					              ".$db->quote("text\plain").",
					              ".$db->quote(filesize($tmpfname)).",
					              lo_import(".$db->quote($tmpfname).")
					            )
					            ";

					$result = $db->query($query);
					$query = "
					            INSERT INTO ticketfile
					            VALUES
					            (
					              ".$db->quote($fileId).",
					              ".$db->quote($issueid)."
					            )
					            ";

					$result = $db->query($query);

					unlink($tmpfname);
				}
		}
	}
}

$rawdata = '';
// Read raw email from stdin
if ($fp = fopen("php://stdin","r")) {
//if ($fp = fopen($filename, "r")) {
	while (!feof($fp)) {
		$rawdata .= fgets($fp, 1024);
	}
	fclose($fp);
}

// Pull current timestamp
$currtime = date("r");

// Parse mail
$parser = new MAILER;
$parser->decode($rawdata);

if (is_array($parser->headers['to']))
	$parser->headers['to'] = $parser->headers['to'][0];

$ticketInfo = explode("-", eregi_replace('(\ )(.*)', "", eregi_replace('(.*)(\[)', "", $parser->headers['subject'])));

if (isset ($ticketInfo[0]))
	$queueId = $ticketInfo[0];
else
	$queueId = '';
if (isset ($ticketInfo[1]))
	$ticketId = $ticketInfo[1];
else
	$ticketId = '';
$toEmail = $parser->headers['to'];
if (isset ($parser->headers['x-priority']))
	$priority = $parser->headers['x-priority'];
else
	$priority = 3;

if (isset ($argv[1]))
	$parser->headers['to'] = $argv[1];

$reference = false;

$db->StartTrans();

/* Check if a ticket id is already present */
if (trim($ticketId) != "") {
	$query = "
	    SELECT t.id AS ticketid,
	           t.subject,
	           q.id AS queueid,
	           q.name,
	           q.updatemessage AS message,
	           c.name AS companyname,
	           q.sendreply,
	           t.subject,
	           q.address,
	           q.actualaddress
	    FROM 
	     ticket t, ticketqueue q, company c
	    WHERE
	    (
	      t.queueid=q.id
	      AND
	      q.id=".$db->qstr(intval($queueId))."
	      AND (
	          lower(q.address)=".$db->qstr(strtolower($parser->headers['to']))." OR
	          lower(q.actualaddress)=".$db->qstr(strtolower($parser->headers['to']))."
	      )
	      AND
	      lower(t.fromaddress)=".$db->qstr(strtolower($parser->headers['from']))."
	      AND
	      t.id=".$db->qstr(intval($ticketId))."
	      AND
	      c.id=q.companyid
	      AND parentticketid IS NULL
	    )
	  ";

	/* Send the query */
	$row = $db->GetRow($query);

	if ($row !== false) {
		$referenceTicketId = $row['ticketid'];
		$queueId = $row['queueid'];
		$queueName = $row['name'];
		$companyName = $row['companyname'];
		$message = $row['message'];
		$sendReply = $row['sendreply'];
		$oldSubject = $row['subject'];
		$queueAddress = $row['address'];
		$actualQueueAddress = $row['actualaddress'];

		logger($referenceTicketId, $currtime, $priority, null);

		$reference = true;
	} else {
		$reference = false;
	}

}

if ($reference) {
	/* Start a database transaction */
	//$db->StartTrans();

	// Attempt to find a contact for the supplied email address
	$rsContact = $db->Execute(
		"SELECT pcm.personid,
		        p.companyid
		 FROM   personcontactmethod pcm
		 LEFT JOIN person p ON (pcm.personid = p.id)
		 WHERE  contact ILIKE ?;",
		array(
			 $parser->headers['from']
		)
	);

	/* Assign the id we have for the company */
	$ticketId = $db->GenID('ticket_id_seq');

	/* Now build the query to insert into the database */
	$result = $db->Execute(
		"INSERT INTO ticket
	     (
	         id,
	         queueid,
	         fromaddress,
	         subject,
	         body,
	         parentticketid,
	         time,
	         personid,
	         companyid
	     )
	     VALUES
	     (
	         ?, ?, ?, ?, ?, ?, ?, ?, ?
	     )",
		array(
			intval($ticketId),
			intval($queueId),
			trim($parser->headers['from']),
			trim(strip_tags($parser->headers['subject'])),
			trim(strip_tags($parser->body)),
			intval($referenceTicketId),
			$currtime,
			$rsContact->fields['personid'],
			$rsContact->fields['companyid']
		)
	);

	/* Send the query */
	$result = $db->Execute($query);

	/* Update the priority */
	$query = "
	    UPDATE ticket
	    SET priority=".$db->qstr(intval($priority))."
	    WHERE
	    (
	      id=".$db->qstr(intval($referenceTicketId))." OR
	      parentticketid=".$db->qstr(intval($referenceTicketId))."
	    )
	    ";

	/* Send the query */
	$result = $db->Execute($query);

	//$db->CompleteTrans();

	$ticketId = $referenceTicketId;

	if ($sendReply == "t") {
		$message = str_replace("{originalMessage}", trim(strip_tags($parser->body)), str_replace("{ticketId}", "[".$queueId."-".$ticketId."]", str_replace("{queueName}", $queueName, str_replace("{companyName}", $companyName, stripslashes($message)))));

		mail($parser->headers['from'], "[{$queueId}-{$ticketId} UPDATED] Re: ".trim(strip_tags($oldSubject)), $message, "From: {$queueName} <{$actualQueueAddress}>\r\n"."X-Mailer: EGS Ticketing System");
	}
} else {
	/* Start a database transaction */
	//$db->StartTrans();

	$ticketId = $db->GenID('ticket_id_seq');

	/* Build a query to get the queue id we need to insert */
	$query = "
	        SELECT q.id, q.name,q.address, q.actualaddress, c.name AS companyname, q.insertmessage, q.sendreply
	        FROM ticketqueue q, company c
	        WHERE
	        (
	          (
			lower(q.address)=".$db->qstr(strtolower($parser->headers['to']))." OR
			lower(q.actualaddress)=".$db->qstr(strtolower($parser->headers['to']))."
		  )
	          AND
	          c.id=q.companyid
	        )
	       ";

	/* Fetch the row */
	$row = $db->GetRow($query);

	/* Assign the id we have for the company */
	$queueId = $row['id'];
	$queueName = $row['name'];
	$queueAddress = $row['address'];
	$actualQueueAddress = $row['actualaddress'];
	$companyName = $row['companyname'];
	$message = $row['insertmessage'];
	$sendReply = $row['sendreply'];

	/* Check for keywords */
	$query = "
	    SELECT id, lower(keywords) AS keywords
	    FROM internalqueue
	    WHERE 
	    (
	      queueid=".$db->qstr(intval($queueId))."
	    )";

	/* Send the query */
	$rs = $db->Execute($query);

	$internalQueueId = null;

	$possibleKeywords = explode(" ", $parser->headers['subject']);

	/* Fetch the row */
	while (!$rs->EOF && ($internalQueueId == null)) {
		$keywords = explode(" ", stripslashes($rs->fields['keywords']));

		for ($i = 0;(($internalQueueId == null) && ($i < sizeof($possibleKeywords))); $i ++) {
			if (in_array(strtolower($possibleKeywords[$i]), $keywords)) {
				$internalQueueId = $rs->fields['id'];
			}
		}

		$rs->MoveNext();
	}

	if ($internalQueueId == null) {
		$internalQueueId = defaultSubQueue($queueId);
	}

	// Attempt to find a contact for the supplied email address
	$rsContact = $db->Execute(
		"SELECT pcm.personid,
		        p.companyid
		 FROM   personcontactmethod pcm
		 LEFT JOIN person p ON (pcm.personid = p.id)
		 WHERE  contact ILIKE ?;",
		array(
			 $parser->headers['from']
		)
	);

	$ticket = array ();
	$ticket['id'] = $ticketId;
	$ticket['queueid'] = $queueId;
	$ticket['fromaddress'] = trim($parser->headers['from']);
	$ticket['priority'] = $priority;
	$ticket['subject'] = trim(strip_tags($parser->headers['subject']));
	$ticket['body'] = trim(strip_tags($parser->body));
	if (isset($rsContact->fields['personid'])) {
		$ticket['personid'] = $rsContact->fields['personid'];
	}
	if (isset($rsContact->fields['companyid'])) {
		$ticket['companyid'] = $rsContact->fields['companyid'];
	}
	
	if ($internalQueueId != '')
		$ticket['internalqueueid'] = $internalQueueId;
	$ticket['time'] = $currtime;

	if (intval($queueId) != 0) {
		/* Send the query */
		$result = $db->Replace('ticket', $ticket, 'id', true);

		$currtime = date("r");

		logger($ticketId, $currtime, "SUB", $parser->headers['subject']);
		logger($ticketId, $currtime, $priority, null);
		logger($ticketId, $currtime, "INT", null, $internalQueueId);

		if ($sendReply == "t") {
			$message = str_replace("{originalMessage}", trim(strip_tags($parser->body)), str_replace("{ticketId}", "[".$queueId."-".$ticketId."]", str_replace("{queueName}", $queueName, str_replace("{companyName}", $companyName, stripslashes($message)))));

			mail($parser->headers['from'], "[{$queueId}-{$ticketId} OPENED] Re: ".trim(strip_tags($parser->headers['subject'])), $message, "From: {$queueName} <{$actualQueueAddress}>\r\n"."X-Mailer: EGS Ticketing System");
		}

		attach_files($ticketId, $parser);
	} else {
		//$db->FailTrans();
		//mail ($parser->headers['from'],
		//      'Invalid Email Address', $parser->body, "From: postmaster@{$_SERVER['SERVER_NAME']}\r\n".
		//      "X-Mailer: EGS Ticketing System");
	}
}

$db->CompleteTrans();
$db->close();
?>


