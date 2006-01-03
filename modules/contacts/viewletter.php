<?php
/* */
//echo $_GET['id'];
require_once(EGS_FILE_ROOT.'/modules/contacts/labelspdf.php');

	$FONT_NAME = 'Arial';
	$FONT_SIZE = '10';
	$FONT_SPACING = '5';
	$pdf = new PDF();
	$pdf->setFont($FONT_NAME, '', $FONT_SIZE);
	$pdf->setAutoPageBreak(false);
	$pdf->addPage('P');
	$pdf->addHeader();
	
		$info = '';		
		$query = 'SELECT c.id FROM company c, letterrefs lr where lr.id ='. $_GET['id'] .'AND lr.companyid = c.id';
		$rs = $db->execute($query);
		$cid = $rs->fields['id'];
		$query = 'SELECT p.id FROM person p, letterrefs lr where lr.id ='. $_GET['id'] .'AND lr.personid = p.id';
		$rs = $db->execute($query);
		$pid = $rs->fields['id'];
		if ((!isset ($pid)) || ($pid == '')) {

			$query = 'select ca.*, c.*, c.name AS companyname, a.* FROM company c, companyaddress ca, companyaccess a WHERE ca.companyid=c.id AND a.companyid=c.id AND a.usercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND a.username='.$db->qstr(EGS_USERNAME).' AND c.id='.$cid;

		} else {

			$query = 'select p.*, ca.*, a.*,c.*, c.name AS companyname';
			$query .= ' FROM company c LEFT OUTER JOIN person p ON'.'(p.companyid=c.id), companyaddress ca, companyaccess a';
			if (isset ($cat))
				$query .= ', companytypexref x';
			$query .= ' WHERE ca.companyid=c.id AND a.companyid=c.id AND'.' a.usercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND a.username='.$db->qstr(EGS_USERNAME).'';
			$query .= " AND p.id=$pid ";
			$query .= "AND c.id=$cid";
			$query .= " ORDER BY c.name";
		}

		$r = $db->Execute($query);

		if (EGS_DEBUG_SQL && !$rs)
		//$db->close();
		die($db->errorMsg());
		
			//Want to have title/firstname/surname/suffix all on one line
			//everything else is on a line on it's own
			//assumes nothing comes before title/fistname/surname/suffix
		$namebuild = '';
		$infoname = '';
		$display = array('title','firstname', 'surname','jobtitle','companyname', 'street1', 'street2', 'street3','town', 'county','postcode','country');
		for ($j = 0; $j < count($display); $j ++) {
			$key = $display[$j];
			$line = '';;

		if (isset ($r->fields[$key])) {
				switch ($key) {
					case 'title' :
					case 'firstname' :
					case 'middlename' :
					case 'surname' :
					case 'suffix' :
						$namebuild .= $r->fields[$key]." ";
						break;
					default :
						if ($namebuild != '') {
							$infoname .= $namebuild;
							$namebuild = '';
						}
						$r->fields[$key] = trim($r->fields[$key]);
						if (($r->fields[$key] != '') && ($r->fields[$key] != '-') && in_array($key, $_SESSION['preferences']['labelColumns']))
							$info .= $r->fields[$key]."\n";
				}
			}
		}
		$query = 'SELECT l.companyid ||'. $db->qstr('/'). '|| l.id ||' .$db->qstr('/').' || lr.id AS ref FROM letterrefs lr, letters l WHERE lr.id = '. $_GET['id']. 'AND l.id = lr.letterid';
		$rs = $db->execute($query);
		$pdf->Ln(5);
		$pdf->Cell(166,0,'Ref: '.$rs->fields['ref'],0,1,'R');
		$pdf->Ln(5);
		$pdf->write(5, $infoname);
		$pdf->Ln(5);
		$pdf->write(5, $info);
		$pdf->Ln(10);
		$query = 'SELECT lettertext from letterrefs where id = ' .$_GET['id'];
		$rs = $db->execute($query);
		if (EGS_DEBUG_SQL && !$rs)
			//$db->close();
			die($db->errorMsg());
		
		$countnumbering = 0;
		$personname = $infoname;
		$pdf->WriteHTML($rs->fields['lettertext']);
		$pdf->addFooter();
	
	
	//output the pdf
	$pdf->Output();
	
	

?>
