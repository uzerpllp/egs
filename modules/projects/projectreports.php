<?php


// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Project Reports 1.0              |
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
/* Check the user has access to the module */
if (in_array('projects', $_SESSION['modules'])) {
	/* This should always be called via post so check that the POST variables */
	$egs->checkPost();

	if(count($_POST)==0) {
		$smarty->assign('redirect', true);
		$smarty->assign('redirectAction', '');
		return false;
	}
					

	/* This function translates a numerical month value into its textual equivilent */
	function transMonth($month) {
		switch ($month) {
			case 1 :
				return _('January');
			case 2 :
				return _('Feburary');
			case 3 :
				return _('March');
			case 4 :
				return _('April');
			case 5 :
				return _('May');
			case 6 :
				return _('June');
			case 7 :
				return _('July');
			case 8 :
				return _('August');
			case 9 :
				return _('September');
			case 10 :
				return _('October');
			case 11 :
				return _('November');
			case 12 :
				return _('December');
		}
	}
	
	
	
	/* If the user has project manager access to a project and is requesting a jobsheet, do the jobsheet! */
	if ((isset ($_POST['reporttype']) && ($_POST['reporttype'] == 'jobsheet')) && isset ($_POST['projectid']) && ($project->AccessLevel($_POST['projectid']) > 1)) {

		/* Grab the project details from the database */
		$query = 'SELECT p.jobno, p.name, c.name AS company, u.firstname || \' \' || u.surname AS person, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'p.startdate').' AS startdate, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'p.enddate').' AS enddate, description FROM project p LEFT OUTER JOIN company c ON (p.companyid=c.id) LEFT OUTER JOIN person u ON (p.personid=u.id) WHERE p.id='.$db->qstr($_POST['projectid']).' AND p.ownercompanyid='.$db->qstr(EGS_COMPANY_ID);

		$project = $db->GetRow($query);

		require_once (EGS_FILE_ROOT.'/src/classes/class.reports.pdf.php');

		/* Set up the PDF to be A4 portrait and someother house keeping bits */
		$pdf = new PDF('P', 'mm', 'a4');
		$pdf->SetDisplayMode('fullpage');
		$pdf->header = false;
		$pdf->next = true;
		$pdf->AliasNbPages();
		$pdf->AddPage();
		/* Grab the correct company logo */
		if (file_exists(EGS_FILE_ROOT.'/logos/'.EGS_COMPANY_ID.'.jpg'))
			$pdf->Image(EGS_FILE_ROOT.'/logos/'.EGS_COMPANY_ID.'.jpg', 145, 15.5, 50);
		/* Setup the title font and do the front page */
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->SetTextColor(102, 102, 102);
		$pdf->Ln(21);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, $project['name'], 0, 1, 'L');
		$pdf->Ln(10);
		$pdf->SetFont('Arial', 'B', 11);
		$pdf->write(5, _('Job Number: '));
		$pdf->SetFont('Arial', '', 11);
		$pdf->write(5, $project['jobno']);
		$pdf->Ln(5);
		$pdf->SetFont('Arial', 'B', 11);
		$pdf->write(5, _('Client: '));
		$pdf->SetFont('Arial', '', 11);
		$pdf->write(5, $project['company']);
		$pdf->Ln(5);
		$pdf->SetFont('Arial', 'B', 11);
		$pdf->write(5, _('Contact: '));
		$pdf->SetFont('Arial', '', 11);
		$pdf->write(5, $project['person']);
		$pdf->Ln(5);
		$pdf->SetFont('Arial', 'B', 11);
		$pdf->write(5, _('Dates: '));
		$pdf->SetFont('Arial', '', 11);
		$pdf->write(5, $project['startdate'].' - '.$project['enddate']);
		$pdf->Ln(10);

		$pdf->MultiCell(0, 5, $project['description'], 0, 'J');

		$pdf->Ln(5);

		/* If the report date is set we need to get the month and date from it so we can build the correct query */
		if (isset ($_POST['reportdate'])) {
			$reportdate = explode('-', $_POST['reportdate']);
			$month = $reportdate[1];
			$year = $reportdate[0];

			/* If we are only doing the report only for a specific user, add this into the query */
			if (isset ($_POST['username']))
				$query = 'SELECT h.username, p.firstname || \' \' || p.surname AS name, extract(month FROM h.entered) AS month, extract(year FROM h.entered) AS year, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'h.entered').' AS entered, hours(h.hours) AS hours, h.description, CASE WHEN h.billable THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS billable,CASE WHEN h.invoiced THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS invoiced, CASE WHEN h.overtime THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS overtime FROM projecthours h, person p WHERE  extract(month FROM h.entered)='.$db->qstr($month).' AND  extract(year FROM h.entered)='.$db->qstr($year).' AND h.projectid='.$db->qstr($_POST['projectid']).' AND p.owner=h.username AND p.owner='.$db->qstr($_POST['username']).' AND p.userdetail ORDER BY name, year, month, h.entered';
			/* Else just get the hours */
			else
				$query = 'SELECT h.username, p.firstname || \' \' || p.surname AS name, extract(month FROM h.entered) AS month, extract(year FROM h.entered) AS year, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'h.entered').' AS entered, hours(h.hours) AS hours, h.description, CASE WHEN h.billable THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS billable,CASE WHEN h.invoiced THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS invoiced, CASE WHEN h.overtime THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS overtime FROM projecthours h, person p WHERE  extract(month FROM h.entered)='.$db->qstr($month).' AND  extract(year FROM h.entered)='.$db->qstr($year).' AND h.projectid='.$db->qstr($_POST['projectid']).' AND p.owner=h.username AND p.userdetail ORDER BY name, year, month, h.entered';
			/* Otherwise just get all the hours for a project */
		} else {
			/* Restrict to the username if needed */
			if (isset ($_POST['username']))
				$query = 'SELECT h.username, p.firstname || \' \' || p.surname AS name, extract(month FROM h.entered) AS month, extract(year FROM h.entered) AS year, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'h.entered').' AS entered, hours(h.hours) AS hours, h.description, CASE WHEN h.billable THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS billable,CASE WHEN h.invoiced THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS invoiced, CASE WHEN h.overtime THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS overtime FROM projecthours h, person p WHERE h.projectid='.$db->qstr($_POST['projectid']).' AND p.owner='.$db->qstr($_POST['username']).' AND p.owner=h.username AND p.userdetail ORDER BY name, year, month, h.entered';
		/* Else just all the users and hours are got */
			else
				$query = 'SELECT h.username, p.firstname || \' \' || p.surname AS name, extract(month FROM h.entered) AS month, extract(year FROM h.entered) AS year, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'h.entered').' AS entered, hours(h.hours) AS hours, h.description, CASE WHEN h.billable THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS billable,CASE WHEN h.invoiced THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS invoiced, CASE WHEN h.overtime THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS overtime FROM projecthours h, person p WHERE h.projectid='.$db->qstr($_POST['projectid']).' AND p.owner=h.username AND p.userdetail ORDER BY name, year, month, h.entered';
		}
		/* Send the query */
		$rs = $db->Execute($query);

		/* Set the alignment and widths for the columns */
		$pdf->SetLineWidth(0.5);
		$pdf->SetWidths(array (25, 25, 80, 20, 20, 20));
		$pdf->SetAligns(array ('R', 'R', 'L', 'C', 'C', 'C'));
		$pdf->SetDrawColor(51, 51, 51);

		/* Set up headers, as to which ones have been called etc */
		$firstHeader = true;
		$pdf->header = false;
		$pdf->footer = false;

		/* Itereate over the hours */
		while (!$rs->EOF) {
			$hours = $rs->fields;
			
			/* We move to the next hours so that we can compare to see if we need a header row/page break */
			$rs->moveNext();

			/* Output the first header if needed */
			if (!$firstHeader)
				$pdf->Row(array ($hours['entered'], $hours['hours'], $hours['description'], $hours['billable'], $hours['invoiced'], $hours['overtime']));

			/* If this is the last set of hours for the month we need to do another query to get the total and then do the header again */
			if ((isset ($rs->fields['month']) && (($hours['month'] != $rs->fields['month']) || ($hours['name'] != $rs->fields['name']))) || ($firstHeader)) {
				/* Get the total hours */
				if (!$firstHeader) {
					$pdf->footer = true;
					$query = 'SELECT hours(sum(h.hours)) AS hours FROM projecthours h, project p WHERE h.projectid=p.id AND p.id='.$db->qstr($_POST['projectid']).' AND p.ownercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND extract(\'month\' FROM h.entered)='.$db->qstr($hours['month']).' AND extract(\'year\' FROM h.entered)='.$db->qstr($hours['year']).' AND h.username='.$db->qstr($hours['username']);

					$total = $db->GetOne($query);

					$pdf->Row(array (_('Total'), $total, '', '', '', ''));
					$pdf->footer = false;
				}
				if(!isset($rs->fields['month'])) {
					$rs->fields['month']=$hours['month'];
					$rs->fields['year']=$hours['year'];
					$rs->fields['name']=$hours['name'];
				}
				/* Add a page break and do the header */
				$pdf->AddPage();
				$pdf->titleText = _('Project Hours For: ');
				$pdf->SetDrawColor(51, 51, 51);

				$pdf->SetTextColor(102, 102, 102);
				$pdf->SetFont('Arial', 'B', 16);
				$pdf->Cell(0, 0, _('Project Hours For: ').$rs->fields['name'], 0, 1, 'L');
				$pdf->Ln(10);

				$pdf->SetFont('Arial', 'B', 11);
				$pdf->write(5, _('Job Number: '));
				$pdf->SetFont('Arial', '', 11);
				$pdf->write(5, $project['jobno']);
				$pdf->Ln(5);

				$pdf->SetFont('Arial', 'B', 11);
				//$pdf->Cell(25,0,_('Period: '),0,0,'L');
				$pdf->write(5, _('Period: '));
				$pdf->SetFont('Arial', '', 11);
				//$pdf->Cell(0,0,$pdf->month.' '.$pdf->year,0,2,'L');
				
				$pdf->write(5, transMonth($rs->fields['month']).' '.$rs->fields['year']);
				$pdf->Ln(10);
				$pdf->header = true;
				$pdf->Row(array (_('Entered'), _('Hours'), _('Description'), _('Billable'), _('Invoiced'), _('Overtime')));
				$pdf->header = false;
				if ($firstHeader) {
					$pdf->Row(array ($hours['entered'], $hours['hours'], $hours['description'], $hours['billable'], $hours['invoiced'], $hours['overtime']));

				}
			}

			/* This is set to true so that we only add an extra header row the first time round */
			$firstHeader = false;

			/* If this is the last row we need to get the total hours too */
			if ($rs->EOF) {
				$pdf->footer = true;
				$query = 'SELECT hours(sum(h.hours)) AS hours FROM projecthours h, project p WHERE h.projectid=p.id AND p.id='.$db->qstr($_POST['projectid']).' AND p.ownercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND extract(\'month\' FROM h.entered)='.$db->qstr($hours['month']).' AND extract(\'year\' FROM h.entered)='.$db->qstr($hours['year']).' AND h.username='.$db->qstr($hours['username']);

				$total = $db->GetOne($query);

				$pdf->Row(array (_('Total'), $total, '', '', '', ''));
				$pdf->footer = false;
			}
		}

		/* Set the PDF details */
		$pdf->setTitle(_('Job Sheet For ').$project['name']);
		$pdf->setAuthor('Enterprise Groupware System - http://www.enterprisegroupwaresystem.org');

		/* Send the PDF to the browser */
		$pdf->Output();
	} else
		/* If the user has project admin access and is requesting a payroll sheet, do the payroll sheet! */
		if ((isset ($_POST['reporttype']) && ($_POST['reporttype'] == 'payroll')) && ($project->isAdmin())) {

			require_once (EGS_FILE_ROOT.'/src/classes/class.reports.pdf.php');

			/* Set up the PDF to be A4 portrait and someother house keeping bits */
			$pdf = new PDF('P', 'mm', 'a4');
			$pdf->SetDisplayMode('fullpage');
			$pdf->header = false;
			$pdf->next = true;
			$pdf->AliasNbPages();



			/* If the report date is set we need to get the month and date from it so we can build the correct query */
			if (isset ($_POST['reportdate'])) {
				$reportdate = explode('-', $_POST['reportdate']);
				$month = $reportdate[1];
				$year = $reportdate[0];

				/* If we are only doing the report only for a specific user, add this into the query */
				if (isset ($_POST['username']))
					$query = 'SELECT p.firstname || \' \' || p.surname AS name, pr.jobno, pr.name AS project, t.name AS task, p.owner AS username, extract(month FROM h.entered) AS month, extract(year FROM h.entered) AS year, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'h.entered').' AS entered, hours(h.hours) AS hours, CASE WHEN h.billable THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS billable,CASE WHEN h.invoiced THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS invoiced, CASE WHEN h.overtime THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS overtime FROM projecthours h LEFT OUTER JOIN projecttask t ON (t.id=h.taskid), person p, project pr WHERE extract(month FROM h.entered)='.$db->qstr($month).' AND  extract(year FROM h.entered)='.$db->qstr($year).' AND h.projectid=pr.id AND pr.ownercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND extract(month FROM h.entered)='.$db->qstr($month).' AND  extract(year FROM h.entered)='.$db->qstr($year).' AND p.owner=h.username AND p.owner='.$db->qstr($_POST['username']).' AND p.userdetail ORDER BY p.owner, year, month, h.entered';
				/* Else just get the hours */
				else
					$query = 'SELECT p.firstname || \' \' || p.surname AS name, pr.jobno, pr.name AS project, t.name AS task, p.owner AS username, extract(month FROM h.entered) AS month, extract(year FROM h.entered) AS year, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'h.entered').' AS entered, hours(h.hours) AS hours, CASE WHEN h.billable THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS billable,CASE WHEN h.invoiced THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS invoiced, CASE WHEN h.overtime THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS overtime FROM projecthours h LEFT OUTER JOIN projecttask t ON (t.id=h.taskid), person p, project pr WHERE extract(month FROM h.entered)='.$db->qstr($month).' AND  extract(year FROM h.entered)='.$db->qstr($year).' AND h.projectid=pr.id AND pr.ownercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND extract(month FROM h.entered)='.$db->qstr($month).' AND  extract(year FROM h.entered)='.$db->qstr($year).' AND p.owner=h.username AND p.userdetail ORDER BY p.owner, year, month, h.entered';
				/* Otherwise just get all the hours for a project */
			} else {
				$month = date('m');
				$year = date('Y');
				/* Restrict to the username if needed */
				if (isset ($_POST['username']))
					$query = 'SELECT p.firstname || \' \' || p.surname AS name, pr.jobno, pr.name AS project, t.name AS task, p.owner AS username, extract(month FROM h.entered) AS month, extract(year FROM h.entered) AS year, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'h.entered').' AS entered, hours(h.hours) AS hours, CASE WHEN h.billable THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS billable,CASE WHEN h.invoiced THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS invoiced, CASE WHEN h.overtime THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS overtime FROM projecthours h LEFT OUTER JOIN projecttask t ON (t.id=h.taskid), person p, project pr WHERE extract(month FROM h.entered)='.$db->qstr($month).' AND  extract(year FROM h.entered)='.$db->qstr($year).' AND h.projectid=pr.id AND pr.ownercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND p.owner=h.username AND p.owner='.$db->qstr($_POST['username']).' AND p.userdetail ORDER BY p.owner, year, month, h.entered';
				/* Else just all the users and hours are got */
				else
					$query = 'SELECT p.firstname || \' \' || p.surname AS name, pr.jobno, pr.name AS project, t.name AS task, p.owner AS username, extract(month FROM h.entered) AS month, extract(year FROM h.entered) AS year, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'h.entered').' AS entered, hours(h.hours) AS hours, CASE WHEN h.billable THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS billable,CASE WHEN h.invoiced THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS invoiced, CASE WHEN h.overtime THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS overtime FROM projecthours h LEFT OUTER JOIN projecttask t ON (t.id=h.taskid), person p, project pr WHERE extract(month FROM h.entered)='.$db->qstr($month).' AND  extract(year FROM h.entered)='.$db->qstr($year).' AND h.projectid=pr.id AND pr.ownercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND p.owner=h.username AND p.userdetail ORDER BY p.owner, year, month, h.entered';
			}

			$rs = $db->Execute($query);
			/* Send the query */
			$rs = $db->Execute($query);

			/* Set the alignment and widths for the columns */
			$pdf->SetLineWidth(0.5);
			$pdf->SetWidths(array (25, 25, 15, 30, 35, 20, 20, 20));
			$pdf->SetAligns(array ('R', 'R', 'C', 'L', 'L', 'C', 'C', 'C'));
			$pdf->SetDrawColor(51, 51, 51);

			/* Set up headers, as to which ones have been called etc */
			$firstHeader = true;
			$pdf->header = false;
			$pdf->footer = false;
			$date = '';

			/* Itereate over the hours */
			while (!$rs->EOF) {
				$hours = $rs->fields;
				/* We move to the next hours so that we can compare to see if we need a header row/page break */
				$rs->moveNext();

				if ($hours['entered'] == $date) {
					$date = $hours['entered'];
					$hours['entered'] = '';
				} else
					$date = $hours['entered'];

				/* Output the first header if needed */
				if (!$firstHeader)
					$pdf->Row(array ($hours['entered'], $hours['hours'], $hours['jobno'], $hours['project'], $hours['task'], $hours['billable'], $hours['invoiced'], $hours['overtime']));

				/* If this is the last set of hours for the month we need to do another query to get the total and then do the header again */
				if ((isset ($rs->fields['month']) && (($hours['month'] != $rs->fields['month']) || ($hours['name'] != $rs->fields['name']))) || ($firstHeader)) {
					/* Get the total hours */
					if (!$firstHeader) {
						$pdf->footer = true;
						$query = 'SELECT hours(sum(h.hours)) AS hours FROM projecthours h, project p WHERE h.projectid=p.id AND  p.ownercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND extract(\'month\' FROM h.entered)='.$db->qstr($month).' AND extract(\'year\' FROM h.entered)='.$db->qstr($year).' AND h.username='.$db->qstr($hours['username']);

						$total = $db->GetOne($query);

						$pdf->Row(array (_('Total'), $total, '', '', '', '', '', ''));
						$pdf->footer = false;
					}

					/* Add a page break and do the header */
					$pdf->AddPage();
					/* Grab the correct company logo */
					if(file_exists(EGS_FILE_ROOT.'/logos/'.EGS_COMPANY_ID.'.jpg'))
					$pdf->Image(EGS_FILE_ROOT.'/logos/'.EGS_COMPANY_ID.'.jpg', 170, 8, 30);
					$pdf->SetDrawColor(51, 51, 51);

					$pdf->SetTextColor(102, 102, 102);
					$pdf->SetFont('Arial', 'B', 16);
					$pdf->Cell(0, 0, _('Payroll For: ').$rs->fields['name'], 0, 1, 'L');
					$pdf->Ln(10);

					$pdf->SetFont('Arial', 'B', 11);
					//$pdf->Cell(25,0,_('Period: '),0,0,'L');
					$pdf->write(5, _('Period: '));
					$pdf->SetFont('Arial', '', 11);
					//$pdf->Cell(0,0,$pdf->month.' '.$pdf->year,0,2,'L');
					$pdf->write(5, transMonth($rs->fields['month']).' '.$rs->fields['year']);
					$pdf->Ln(10);
					$pdf->header = true;
					$pdf->Row(array (_('Entered'), _('Hours'), _('No.'), _('Project'), _('Task'), _('Billable'), _('Invoiced'), _('Overtime')));
					$pdf->header = false;
					if ($firstHeader)
						$pdf->Row(array ($hours['entered'], $hours['hours'], $hours['jobno'], $hours['project'], $hours['task'], $hours['billable'], $hours['invoiced'], $hours['overtime']));
				}

				/* This is set to true so that we only add an extra header row the first time round */
				$firstHeader = false;

				/* If this is the last row we need to get the total hours too */
				if ($rs->EOF) {
					$pdf->footer = true;
					$query = 'SELECT hours(sum(h.hours)) AS hours FROM projecthours h, project p WHERE h.projectid=p.id AND p.ownercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND extract(\'month\' FROM h.entered)='.$db->qstr($month).' AND extract(\'year\' FROM h.entered)='.$db->qstr($year).' AND h.username='.$db->qstr($hours['username']);

					$total = $db->GetOne($query);

					$pdf->Row(array (_('Total'), $total, '', '', '', '', '', ''));
					$pdf->footer = false;
				}
			}

			/* Set the PDF details */
			$pdf->setTitle(_('Job Sheet For ').$project['name']);
			$pdf->setAuthor('Enterprise Groupware System - http://www.enterprisegroupwaresystem.org');

			/* Send the PDF to the browser */
			$pdf->Output();
		} else
			if ((isset ($_POST['reporttype']) && ($_POST['reporttype'] == 'timesheet')) && $project->isAdmin()) {

				require_once (EGS_FILE_ROOT.'/src/classes/class.reports.pdf.php');

				if (!isset ($_POST['reportdate']))
					$_POST['reportdate'] = date('Y-m-d');

				$pdf = new PDF('L', 'mm', 'a4');
				$pdf->header = true;
				$pdf->next = true;
				$pdf->timeSheet = true;
				
				$pdf->AliasNbPages();
				//$pdf->AddPage();
				$pdf->titleText = _('Time Sheet For: ');
				$response = array ('Y', 'N');
				$y = 0;
				if (isset ($_POST['reportdate'])) {
					$reportdate = explode('-', $_POST['reportdate']);
					$month = $reportdate[1];
					$year = $reportdate[0];

					if (isset ($_POST['username']))
						$query = 'SELECT p.firstname || \' \' || p.surname AS name, pr.name AS project, t.name AS task, extract(month FROM h.entered) AS month, extract(year FROM h.entered) AS year, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'h.entered').' AS entered, hours(h.hours) AS hours, h.description, h.billable, h.invoiced, h.overtime FROM projecthours h LEFT OUTER JOIN project pr ON (h.projectid=pr.id AND pr.ownercompanyid='.$db->qstr(EGS_COMPANY_ID).') LEFT OUTER JOIN projecttask t ON (h.taskid=t.id), person p WHERE extract(month FROM h.entered)='.$db->qstr($month).' AND  extract(year FROM h.entered)='.$db->qstr($year).' AND p.owner=h.username AND p.owner='.$db->qstr($_POST['username']).' AND p.userdetail GROUP BY year, month, entered, p.firstname, p.surname, h.hours, h.description, h.billable, h.invoiced, h.overtime ORDER BY year, month, h.entered, pr.name, t.name';
					else
						$query = 'SELECT p.firstname || \' \' || p.surname AS name, pr.name AS project, t.name AS task, extract(month FROM h.entered) AS month, extract(year FROM h.entered) AS year, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'h.entered').' AS entered, hours(h.hours) AS hours, h.description, h.billable, h.invoiced, h.overtime FROM projecthours h LEFT OUTER JOIN project pr ON (h.projectid=pr.id AND pr.ownercompanyid='.$db->qstr(EGS_COMPANY_ID).') LEFT OUTER JOIN projecttask t ON (h.taskid=t.id), person p WHERE extract(month FROM h.entered)='.$db->qstr($month).' AND  extract(year FROM h.entered)='.$db->qstr($year).' AND p.owner=h.username AND p.userdetail GROUP BY year, month, entered, p.firstname, p.surname, h.hours, h.description, h.billable, h.invoiced, h.overtime, pr.name, t.name ORDER BY year, month, h.entered';
				} else
					if (isset ($_POST['username']))
						$query = 'SELECT p.firstname || \' \' || p.surname AS name, pr.name AS project, t.name AS name, extract(month FROM h.entered) AS month, extract(year FROM h.entered) AS year, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'h.entered').' AS entered, hours(h.hours) AS hours, h.description, h.billable, h.invoiced, h.overtime FROM projecthours h LEFT OUTER JOIN project pr ON (h.projectid=pr.id AND pr.ownercompanyid='.$db->qstr(EGS_COMPANY_ID).') LEFT OUTER JOIN projecttask t ON (h.taskid=t.id), person p WHERE extract(month FROM h.entered)='.$db->qstr($month).' AND  extract(year FROM h.entered)='.$db->qstr($year).' AND p.owner=h.username AND p.owner='.$db->qstr($_POST['username']).' AND p.userdetail GROUP BY year, month, entered, p.firstname, p.surname, h.hours, h.description, h.billable, h.invoiced, h.overtime ORDER BY year, month, h.entered';
					else
						$query = 'SELECT p.firstname || \' \' || p.surname AS name, pr.name AS project, t.name AS name, extract(month FROM h.entered) AS month, extract(year FROM h.entered) AS year, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'h.entered').' AS entered, hours(h.hours) AS hours, h.description, h.billable, h.invoiced, h.overtime FROM projecthours h LEFT OUTER JOIN project pr ON (h.projectid=pr.id AND pr.ownercompanyid='.$db->qstr(EGS_COMPANY_ID).') LEFT OUTER JOIN projecttask t ON (h.taskid=t.id), person p WHERE extract(month FROM h.entered)='.$db->qstr($month).' AND  extract(year FROM h.entered)='.$db->qstr($year).' AND p.owner=h.username AND p.owner='.$db->qstr($_POST['username']).' AND p.userdetail GROUP BY year, month, entered, p.firstname, p.surname, h.hours, h.description, h.billable, h.invoiced, h.overtime ORDER BY year, month, h.entered';

				$rs = $db->Execute($query);

				$pdf->header = true;
				$pdf->title = true;
				$pdf->month = transMonth($rs->fields['month']);
				$pdf->year = $rs->fields['year'];
				$pdf->name = $rs->fields['name'];
				$pdf->AddPage();
				$pdf->SetLineWidth(0.5);
				$page = $pdf->PageNo();
				$pdf->SetFont('Arial', '', 14);
				$pdf->Cell(0, 0, _('Timesheet For: ').$rs->fields['name'], 0, 1, 'L');
				$pdf->Ln(10);
				/*here*/
				/* Set the alignment and widths for the columns */
				$pdf->SetFont('Arial', '', 11);
				$pdf->SetLineWidth(0.5);
				$pdf->SetWidths(array (25, 25, 35, 35,75, 20, 20, 20));
				$pdf->SetAligns(array ('R', 'R', 'L', 'L', 'L', 'C', 'C', 'C'));
				$pdf->SetDrawColor(51, 51, 51);
				$pdf->Row(array (_('Entered'), _('Hours'), _('Project'), _('Task'),'', _('Billable'), _('Invoiced'), _('Overtime')));
				/*to here*/

				$types = array ('t' => _('Y'), 'f' => _('N'));
				while (!$rs->EOF) {
					$hours = $rs->fields;
					$pdf->month = transMonth($rs->fields['month']);

					$pdf->SetFont('Arial', '', 11);
					$pdf->SetTextColor(0);
					$pdf->SetDrawColor(51, 51, 51);
					$pdf->SetFillColor(255);

					if ((intval($pdf->getY()) > 265) && ($y < 275)) {

						$pdf->Cell(25, 6, $rs->fields['entered'], 'LB', 0, 'R', 1);
						$pdf->SetFillColor(204, 204, 204);
						$pdf->Cell(25, 6, $rs->fields['hours'], 'B', 0, 'R', 1);
						$pdf->SetFillColor(255);
						if (strlen($rs->fields['project']) > 15)
							$pdf->Cell(35, 6, substr($rs->fields['project'], 0, 15).'...', 'B', 0, 'L', 1);
						else
							$pdf->Cell(35, 6, $rs->fields['project'], 'B', 0, 'L', 1);
						if (strlen($rs->fields['task']) > 15)
							$pdf->Cell(35, 6, substr($rs->fields['task'], 0, 15).'...', 'B', 0, 'L', 1);
						else
							$pdf->Cell(35, 6, $rs->fields['task'], 'B', 0, 'L', 1);
						$pdf->Cell(75, 6, '', 'B', 0, 'R', 1);
						$pdf->Cell(20, 6, $types[$rs->fields['billable']], 'B', 0, 'C', 1);
						$pdf->Cell(20, 6, $types[$rs->fields['invoiced']], 'B', 0, 'C', 1);
						$pdf->Cell(20, 6, $types[$rs->fields['overtime']], 'RB', 0, 'C', 1);
						$pdf->title = false;
					} else {
						$pdf->Cell(25, 6, $rs->fields['entered'], 'L', 0, 'R', 1);
						$pdf->SetFillColor(204, 204, 204);
						$pdf->Cell(25, 6, $rs->fields['hours'], 0, 0, 'R', 1);
						$pdf->SetFillColor(255);
						if (strlen($rs->fields['project']) > 15)
							$pdf->Cell(35, 6, substr($rs->fields['project'], 0, 15).'...', 'B', 0, 'L', 1);
						else
							$pdf->Cell(35, 6, $rs->fields['project'], 'B', 0, 'L', 1);
						if (strlen($rs->fields['task']) > 15)
							$pdf->Cell(35, 6, substr($rs->fields['task'], 0, 15).'...', 'B', 0, 'L', 1);
						else
							$pdf->Cell(35, 6, $rs->fields['task'], 'B', 0, 'L', 1);
						$pdf->SetFillColor(255);
						$pdf->Cell(75, 6, '', 'B', 0, 'R', 1);
						$pdf->Cell(20, 6, $types[$rs->fields['billable']],'B', 0, 'C', 1);
						$pdf->Cell(20, 6, $types[$rs->fields['invoiced']], 'B', 0, 'C', 1);
						$pdf->Cell(20, 6, $types[$rs->fields['overtime']], 'BR', 0, 'C', 1);
					}
					$pdf->Ln();
					$y = intval($pdf->getY());
					$next = $rs->MoveNext();
					if ($rs->fields['month'] != $hours['month']) {

						$pdf->month = transMonth($rs->fields['month']);
						$pdf->year = $rs->fields['year'];
						$pdf->name = $rs->fields['name'];

						$query = 'SELECT hours(sum(h.hours)) AS hours FROM projecthours h, project p WHERE h.projectid=p.id AND p.ownercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND extract(\'month\' FROM h.entered)='.$db->qstr($hours['month']).' AND extract(\'year\' FROM h.entered)='.$db->qstr($hours['year']);

						$total = $db->GetOne($query);

						$pdf->SetFont('Arial', 'B', 11);
						$pdf->SetTextColor(255);
						$pdf->SetDrawColor(51, 51, 51);
						$pdf->SetFillColor(102, 102, 102);
						$pdf->Cell(25, 6, _('Total'), 'TBL', 0, 'R', 1);
						$pdf->Cell(25, 6, $total, 'TB', 0, 'R', 1);
						$pdf->Cell(35, 6, '', 'TB', 0, 'R', 1);
						$pdf->Cell(35, 6, '', 'TB', 0, 'R', 1);
						$pdf->Cell(75, 6, '', 'TB', 0, 'L', 1);
						$pdf->Cell(20, 6, '', 'TB', 0, 'C', 1);
						$pdf->Cell(20, 6, '', 'TB', 0, 'C', 1);
						$pdf->Cell(20, 6, '', 'TBR', 0, 'C', 1);
						if ($next) {
							$pdf->AddPage();
						}
						$pdf->title = true;
						$pdf->next = $next;
					}
				}
				$pdf->setTitle(_('Job Sheet For ').$project['name']);
				$pdf->setAuthor('Enterprise Groupware System - http://www.enterprisegroupwaresystem.org');

				$pdf->Output();
			} else
				/* If the user has project admin access and is requesting a payroll sheet, do the payroll sheet! */
				if ((isset ($_POST['reporttype']) && ($_POST['reporttype'] == 'weekhours')) && ($project->isAdmin())) {

					require_once (EGS_FILE_ROOT.'/src/classes/class.reports.pdf.php');

					/* Set up the PDF to be A4 portrait and someother house keeping bits */
					$pdf = new PDF('P', 'mm', 'a4');
					$pdf->SetDisplayMode('fullpage');
					$pdf->header = false;
					$pdf->next = true;
					$pdf->AliasNbPages();

					/* If the report date is set we need to get the month and date from it so we can build the correct query */
					if (isset ($_POST['reportdate'])) {
						$week = date('W', strtotime($_POST['reportdate']));
						$year = date('Y', strtotime($_POST['reportdate']));

						/* If we are only doing the report only for a specific user, add this into the query */
						if (isset ($_POST['username']))
							$query = 'SELECT p.firstname || \' \' || p.surname AS name, pr.jobno, pr.name AS project, t.name AS task, p.owner AS username, extract(month FROM h.entered) AS month, extract(year FROM h.entered) AS year, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'h.entered').' AS entered, hours(h.hours) AS hours, CASE WHEN h.billable THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS billable,CASE WHEN h.invoiced THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS invoiced, CASE WHEN h.overtime THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS overtime FROM projecthours h LEFT OUTER JOIN projecttask t ON (t.id=h.taskid), person p, project pr WHERE extract(week FROM h.entered)='.$db->qstr($week).' AND  extract(year FROM h.entered)='.$db->qstr($year).' AND h.projectid=pr.id AND pr.ownercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND p.owner=h.username AND p.owner='.$db->qstr($_POST['username']).' AND p.userdetail ORDER BY p.owner, year, month, h.entered';
						/* Else just get the hours */
						else
							$query = 'SELECT p.firstname || \' \' || p.surname AS name, pr.jobno, pr.name AS project, t.name AS task, p.owner AS username, extract(month FROM h.entered) AS month, extract(year FROM h.entered) AS year, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'h.entered').' AS entered, hours(h.hours) AS hours, CASE WHEN h.billable THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS billable,CASE WHEN h.invoiced THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS invoiced, CASE WHEN h.overtime THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS overtime FROM projecthours h LEFT OUTER JOIN projecttask t ON (t.id=h.taskid), person p, project pr WHERE extract(week FROM h.entered)='.$db->qstr($week).' AND  extract(year FROM h.entered)='.$db->qstr($year).' AND h.projectid=pr.id AND pr.ownercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND p.owner=h.username AND p.userdetail ORDER BY p.owner, year, month, h.entered';
						/* Otherwise just get all the hours for a project */
					} else {
						$week = date('W');
						$year = date('Y');
						/* Restrict to the username if needed */
						if (isset ($_POST['username']))
							$query = 'SELECT p.firstname || \' \' || p.surname AS name, pr.jobno, pr.name AS project, t.name AS task, p.owner AS username, extract(month FROM h.entered) AS month, extract(year FROM h.entered) AS year, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'h.entered').' AS entered, hours(h.hours) AS hours, CASE WHEN h.billable THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS billable,CASE WHEN h.invoiced THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS invoiced, CASE WHEN h.overtime THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS overtime FROM projecthours h LEFT OUTER JOIN projecttask t ON (t.id=h.taskid), person p, project pr WHERE extract(week FROM h.entered)='.$db->qstr($week).' AND  extract(year FROM h.entered)='.$db->qstr($year).' AND h.projectid=pr.id AND pr.ownercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND p.owner=h.username AND p.owner='.$db->qstr($_POST['username']).' AND p.userdetail ORDER BY p.owner, year, month, h.entered';
						/* Else just all the users and hours are got */
						else
							$query = 'SELECT p.firstname || \' \' || p.surname AS name, pr.jobno, pr.name AS project, t.name AS task, p.owner AS username, extract(month FROM h.entered) AS month, extract(year FROM h.entered) AS year, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'h.entered').' AS entered, hours(h.hours) AS hours, CASE WHEN h.billable THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS billable,CASE WHEN h.invoiced THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS invoiced, CASE WHEN h.overtime THEN '.$db->qstr(_('Y')).' ELSE '.$db->qstr(_('N')).' END AS overtime FROM projecthours h LEFT OUTER JOIN projecttask t ON (t.id=h.taskid), person p, project pr WHERE extract(week FROM h.entered)='.$db->qstr($week).' AND  extract(year FROM h.entered)='.$db->qstr($year).' AND h.projectid=pr.id AND pr.ownercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND p.owner=h.username AND p.userdetail ORDER BY p.owner, year, month, h.entered';
					}

					$rs = $db->Execute($query);
					/* Send the query */
					$rs = $db->Execute($query);

					/* Set the alignment and widths for the columns */
					$pdf->SetLineWidth(0.5);
					$pdf->SetWidths(array (25, 25, 15, 30, 35, 20, 20, 20));
					$pdf->SetAligns(array ('R', 'R', 'C', 'L', 'L', 'C', 'C', 'C'));
					$pdf->SetDrawColor(51, 51, 51);

					/* Set up headers, as to which ones have been called etc */
					$firstHeader = true;
					$pdf->header = false;
					$pdf->footer = false;
					$date = '';
					if (!isset ($forceNL))
						$forceNL = false;
					if (!isset ($forceUser))
						$forceUser = false;
					/* Itereate over the hours */
					while (!$rs->EOF) {
						$hours = $rs->fields;
						/* We move to the next hours so that we can compare to see if we need a header row/page break */
						$rs->moveNext();

						if ($hours['entered'] == $date) {
							$date = $hours['entered'];
							$hours['entered'] = '';
						} else
							$date = $hours['entered'];

						/* Output the first header if needed */
						if (!$firstHeader && !$forceNL)
							$pdf->Row(array ($hours['entered'], $hours['hours'], $hours['jobno'], $hours['project'], $hours['task'], $hours['billable'], $hours['invoiced'], $hours['overtime']));

						/* If this is the last set of hours for the month we need to do another query to get the total and then do the header again */
						if ((isset ($rs->fields['name']) && ($hours['name'] != $rs->fields['name'])) || $firstHeader || $forceNL) {
							/* Get the total hours */
							if (!$firstHeader) {
								$pdf->footer = true;
								if ($forceNL)
									$query = 'SELECT hours(sum(h.hours)) AS hours FROM projecthours h, project p WHERE h.projectid=p.id AND  p.ownercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND extract(\'week\' FROM h.entered)='.$db->qstr($week).' AND extract(\'year\' FROM h.entered)='.$db->qstr($year).' AND h.username='.$db->qstr($forceUser);
								else
									$query = 'SELECT hours(sum(h.hours)) AS hours FROM projecthours h, project p WHERE h.projectid=p.id AND  p.ownercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND extract(\'week\' FROM h.entered)='.$db->qstr($week).' AND extract(\'year\' FROM h.entered)='.$db->qstr($year).' AND h.username='.$db->qstr($hours['username']);

								$total = $db->GetOne($query);

								$pdf->Row(array (_('Total'), $total, '', '', '', '', '', ''));
								$pdf->footer = false;
							}

							/* Add a page break and do the header */
							$pdf->AddPage();
							/* Grab the correct company logo */
							if (file_exists(EGS_FILE_ROOT.'/logos/'.EGS_COMPANY_ID.'.jpg'))
							$pdf->Image(EGS_FILE_ROOT.'/logos/'.EGS_COMPANY_ID.'.jpg', 170, 8, 30);
							$pdf->SetDrawColor(51, 51, 51);

							$pdf->SetTextColor(102, 102, 102);
							$pdf->SetFont('Arial', 'B', 16);
							if ($firstHeader)
								$pdf->Cell(0, 0, _('Weekly Hours For: ').$hours['name'], 0, 1, 'L');
							else
								$pdf->Cell(0, 0, _('Weekly Hours For: ').$rs->fields['name'], 0, 1, 'L');
							$pdf->Ln(10);

							$pdf->SetFont('Arial', 'B', 11);
							//$pdf->Cell(25,0,_('Period: '),0,0,'L');
							$pdf->write(5, _('Period: '));
							$pdf->SetFont('Arial', '', 11);
							//$pdf->Cell(0,0,$pdf->month.' '.$pdf->year,0,2,'L');
							$pdf->write(5, _('Week').' '.$week.', '.$year);
							$pdf->Ln(10);
							$pdf->header = true;
							$pdf->Row(array (_('Entered'), _('Hours'), _('No.'), _('Project'), _('Task'), _('Billable'), _('Invoiced'), _('Overtime')));
							$pdf->header = false;
							if ($firstHeader || $forceNL)
								$pdf->Row(array ($hours['entered'], $hours['hours'], $hours['jobno'], $hours['project'], $hours['task'], $hours['billable'], $hours['invoiced'], $hours['overtime']));
						}

						/* This is set to true so that we only add an extra header row the first time round */
						if ($firstHeader) {
							$firstHeader = false;
							if ($rs->fields['name'] != $hours['name']) {
								$forceNL = true;
								$forceUser = $hours['username'];
							}
						} else
							$forceNL = false;

						/* If this is the last row we need to get the total hours too */
						if ($rs->EOF) {
							$pdf->footer = true;
							$query = 'SELECT hours(sum(h.hours)) AS hours FROM projecthours h, project p WHERE h.projectid=p.id AND p.ownercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND extract(\'week\' FROM h.entered)='.$db->qstr($week).' AND extract(\'year\' FROM h.entered)='.$db->qstr($year).' AND h.username='.$db->qstr($hours['username']);

							$total = $db->GetOne($query);

							$pdf->Row(array (_('Total'), $total, '', '', '', '', '', ''));
							$pdf->footer = false;
						}
					}

					/* Set the PDF details */
					$pdf->setTitle(_('Job Sheet For ').$project['name']);
					$pdf->setAuthor('Enterprise Groupware System - http://www.enterprisegroupwaresystem.org');

					/* Send the PDF to the browser */
					$pdf->Output();
				} else {
					$errors=array();
					/*lets see why it's not available*/
					if(!isset($_POST['reporttype']))
						$errors[]=_('You Need to choose a report-type');
					else {
						if($_POST['reporttype']=='jobsheet' && !isset($_POST['projectid']))
							$errors[] = _('For a Job-Sheet, you must choose a specific project');
							
					}
					if(count($errors)==0)
						$errors[] = _('Generic Error With Project Reports');
					$smarty->assign('errors', $errors);
					//$smarty->assign('redirect', true);
					$smarty->assign('redirectAction', '');

				}
}
?>

