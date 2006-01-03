<?php
// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Save Account Access 1.0          |
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

/*printing lots of labels can take a long time*/
set_time_limit(300);

require_once(EGS_FILE_ROOT.'/modules/contacts/labelspdf.php');

/* This sets the default format for addresses if none set */
if(!isset($_SESSION['preferences']['addressformat'])) $_SESSION['preferences']['addressformat']='street1, street2, street3, town, county, postcode, country';

if ((isset ($_POST['delete'])) && (count($_POST['delete']) > 0)) { //'delete' means 'print labels'
	if (isset ($_POST['formats']))
		$format = $_POST['formats'];
	else
		$format = $_SESSION['labelsformat'];
	if (isset ($_POST['lettertypes']))
		$lettertypes = $_POST['lettertypes'];
	else
		$lettertypes = $_SESSION['labelslettertypes'];
	if (isset ($_POST['printmode']))
		$printmode = $_POST['printmode'];
	else
		$printmode = $_SESSION['labelsprintmode'];
	if (isset ($_POST['reference']))
		$reference = true;
	else
		$reference = $_SESSION['labelsReference'];

	$FONT_NAME = 'Arial';
	$FONT_SIZE = '10';
	$FONT_SPACING = '5';
	//Set up formatting for 2 different sizes of label
	if ($format == '2x7') {
		$LAYOUT_COLS = '2';
		$LAYOUT_ROWS = '7';
		$CELL_WIDTH = '100';
		$CELL_HEIGHT = '40';
		$MARGIN_TOP = '9';
		$MARGIN_LEFT = '4';
	} else {
		$LAYOUT_COLS = '3';
		$LAYOUT_ROWS = '8';
		$CELL_WIDTH = '70';
		$CELL_HEIGHT = '36';
		$MARGIN_TOP = '8';
		$MARGIN_LEFT = '3';
	}

	$NAME_DEFAULT = 'To Whom it may Concern';
	$NAME_PREFIX = 'Att: ';

	//initialise PDF
	$pdf = new PDF();
	$pdf->setFont($FONT_NAME, '', $FONT_SIZE);
	$pdf->setAutoPageBreak(true);
	$pdf->addPage('P');

	if (isset ($_SESSION['labelsSearch']['addtype']))
		$address_type = strtolower($_SESSION['labelsSearch']['addtype']);
	$cat = $_POST['x_typeid'];
	if ($cat == '')
		unset ($cat);
	$labels = array ();
	$labels = $_POST['delete'];
	$i = 0;
	$rows = array ();
	$pos_y = $MARGIN_TOP;
	$pos_x = $MARGIN_LEFT;
	$countcols = 0;
	$countrows = 0;
	//for each selected contact name/address
	foreach ($labels as $row) {
		//echo('foreach');
		$infoname = '';
		$info = '';
		$row = explode("/", $row);
		$labels[$i] = array ('cid' => $row[0], 'pid' => $row[1]);

		$cid = $labels[$i]['cid'];
		$pid = $labels[$i]['pid'];
		if (!isset ($address_type))
			$address_type = 'Main';
		if ((!isset ($pid)) || ($pid == '')) {
			$query = 'select ca.*, c.*, a.* FROM company c, companyaddress ca, companyaccess a WHERE ca.companyid=c.id AND a.companyid=c.id AND ca.'.$address_type.' AND a.usercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND a.username='.$db->qstr(EGS_USERNAME).' AND c.id='.$cid;

		} else {

			$query = 'select p.*, ca.*, a.*,c.*';
			$query .= ' FROM company c LEFT OUTER JOIN person p ON'.'(p.companyid=c.id), companyaddress ca, companyaccess a';
			if (isset ($cat))
				$query .= ', companytypexref x';
			$query .= ' WHERE ca.companyid=c.id AND ca.'.$address_type.' AND a.companyid=c.id AND'.' a.usercompanyid='.$db->qstr(EGS_COMPANY_ID).' AND a.username='.$db->qstr(EGS_USERNAME).'';
			$query .= " AND p.id=$pid ";
			$query .= "AND c.id=$cid";
			$query .= " ORDER BY c.name";
		}

		if (isset ($query))
			$r = $db->Execute($query);
		if (EGS_DEBUG_SQL && !$r)
			//$db->close();
			die($db->errorMsg());
		if (isset ($r)) {
			if ($r === false) {
				continue;
			}
		}

		if (isset ($_SESSION['preferences']['labelColumns']))
			$display = $_SESSION['preferences']['labelColumns'];
		//else display default
		else
			$display = array ('name', 'title', 'firstname', 'middlename', 'surname', 'suffix', 'street1', 'street2', 'street3', 'town', 'county', 'postcode');

		/*put the columns in the right order*/
		$newdisplay = array ();
		$name = array ('title', 'firstname', 'middlename', 'surname', 'suffix', 'companyname');

		foreach ($name as $item) {
			if (in_array($item, $display)) {
				$newdisplay[] = $item;
				unset ($display[$item]);
			}
		}

		$temp = explode(',', $_SESSION['preferences']['addressformat']);
		foreach ($temp as $item) {
			if (in_array(trim($item), $display)) {
				$newdisplay[] = trim($item);
				unset ($display[$item]);
			}
		}
		unset ($display);
		$display = $newdisplay;
		$namebuild = '';
		$display2 = array ();
		if (trim($r->fields['name']) == trim($r->fields['street1'])) {

			foreach ($display as $key) {
				if ($key != 'name')
					$display2[] = $key;
			}
		}
		if (isset ($display2) && count($display2) > 0)
			$display = $display2;
		//Insert letterrefs values into letterrefs table for each letter printed
		$letterid = $lettertypes;
		//echo $lettertypes;

		$query = 'SELECT body from letters where id = '.$lettertypes;
		//$query = 'SELECT username FROM useraccess WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY username';
		$rs = $db->execute($query);
		//print_r($rs->fields);
		if (EGS_DEBUG_SQL && !$rs)
			//$db->close();
			die($db->errorMsg());
		if (isset ($_SESSION['labelsReference']) && $reference == true) {
			if (($pid != '') && (isset ($rs->fields['body']))) {

				$query = 'INSERT INTO letterrefs (letterid, companyid, personid, sent, lettertext) VALUES ('.$letterid.' , '.$cid.' , '.$pid.' , now() , '.$db->qstr($rs->fields['body']).')';
			} else
				if (isset ($rs->fields['body'])) {

					$query = 'INSERT INTO letterrefs (letterid, companyid, sent, lettertext) VALUES ('.$letterid.' , '.$cid.' , now(), '.$rs->fields['body'].')';
				}

			$result = $db->execute($query);
			if (EGS_DEBUG_SQL && !$result)
				//$db->close();
				die($db->errorMsg());
		}
		////////////
		$query = 'SELECT l.companyid ||'.$db->qstr('/').'|| l.id ||'.$db->qstr('/').' || lr.id AS ref FROM letterrefs lr, letters l WHERE l.companyid='.$db->qstr(EGS_COMPANY_ID).' AND l.id = lr.letterid ORDER BY sent DESC';

		$rs = $db->execute($query);
		if (EGS_DEBUG_SQL && !$rs) {
			die($db->errorMsg());
		}
		$letterrefs[$i] = $rs->fields['ref'];
		//print_r($display);
		if (!isset ($display))
			$display = array ();
		//for each item of the contact information
		for ($j = 0; $j < count($display); $j ++) {
			$key = $display[$j];
			$line = '';
			//companyname needs to be changed to name
			if ($key == 'companyname')
				$key = 'name';
			//Want to have title/firstname/surname/suffix all on one line
			//everything else is on a line on it's own
			//assumes nothing comes before title/fistname/surname/suffix
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
							$infoname .= $namebuild."\n";
							$namebuild = '';
						}
						$r->fields[$key] = trim($r->fields[$key]);
						if (($r->fields[$key] != '') && ($r->fields[$key] != '-')) {
							$info .= $r->fields[$key]."\n";
							//echo $r->fields[$key].'<br/>';
						}

				}
			}
		}
		if ($format != 'none') {
			//decide when to move to a new line		
			if ($countcols == $LAYOUT_COLS) {
				$pos_y += $CELL_HEIGHT;
				$countrows ++;
				$pos_x = $MARGIN_LEFT;
				$countcols = 0;

				//decide when to move to a new page
				if ($countrows == $LAYOUT_ROWS) {
					$pdf->AddPage('P');
					if (($printmode == 'Duplex') && (($pdf->PageNo()) % 2) == 0)
						$pdf->AddPage();
					$countrows = 0;
					$pos_y = $MARGIN_TOP;
				}
			}
			//add the data to the pdf
			$pdf->setXY($pos_x, $pos_y);
			$info2 = $infoname.$info;
			$pdf->multiCell($CELL_WIDTH, $FONT_SPACING, $info2, 0, 'L');
			$pos_x += $CELL_WIDTH;
			$countcols ++;
			$info3[$i] = $info;
			$infoname2[$i] = trim($infoname);
			$i ++;
		}
	}

	//for each selected contact/name add a letter
	if (!isset ($info3))
		$info3 = array ();

	if ($lettertypes != 'none') {
		for ($i = 0; $i < count($info3); $i ++) {
			$pdf->AddPage();
			if (($printmode == 'Duplex') && (($pdf->PageNo()) % 2) == 0)
				$pdf->AddPage();
			$pdf->addHeader();
			$pdf->Ln(5);
			if ($reference)
				$pdf->Cell(166, 0, 'Ref: '.$letterrefs[$i], 0, 1, 'R');
			$pdf->write(5, $infoname2[$i]);
			$pdf->Ln(5);
			$pdf->write(5, $info3[$i]);
			$pdf->Ln(10);

			$query = 'SELECT body from letters where id = '.$lettertypes;

			$rs = $db->execute($query);
			if (EGS_DEBUG_SQL && !$rs)
				die($db->errorMsg());

			$body = $rs->fields['body'];
			$countnumbering = 0;
			$personname = $infoname2[$i];

			$pdf->WriteHTML($body);

			$pdf->addFooter();
		} //end foreach
	} //end if lettertypes!='none'

	//output the pdf
	$pdf->Output();

}
$smarty->assign('hideSaveSearch', true);
$_SESSION['labels_page'] = 1;
/* Set the page title */
$smarty->assign('pageTitle', _('Contacts: Print Labels'));

/* Setup the search box */
$smarty->assign('searchTitle', _('Print Labels'));

$smarty->assign('hideAdvancedSearch', true);
$search = array ();
//add the search boxes
$search['c.name'] = array ('name' => _('Company Name'), 'type' => 'text');
$search['person'] = array ('name' => _('Name'), 'type' => 'text');
//$search['p.surname'] = array ('name' => _('Surname'), 'type' => 'text');
$checked = false;
$checked = true;
$search['reference'] = array ('name' => _('Keep Reference'), 'type' => 'checkbox', 'checked' => $checked);
/* Add the assigned */
$query = 'SELECT username FROM useraccess WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY username';
$rs = $db->execute($query);
if (EGS_DEBUG_SQL && !$rs)
	//$db->close();
	die($db->errorMsg());
$users = array (_('All') => '');
while (!$rs->EOF) {
	$users[$rs->fields['username']] = $rs->fields['username'];
	$rs->MoveNext();
}
$search['assigned'] = array ('name' => _('Account Assigned To'), 'type' => 'select', 'values' => $users);

/* Add the contact categories to the search */
$query = 'SELECT id, name FROM contactcategories WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY name';
$rs = $db->execute($query);
if (EGS_DEBUG_SQL && !$rs)
	//$db->close();
	die($db->errorMsg());
$categories = array (_('All') => '');
while (!$rs->EOF) {
	$categories[$rs->fields['name']] = $rs->fields['id'];
	$rs->MoveNext();
}
$search['x.typeid'] = array ('name' => _('Contact Categories'), 'type' => 'select', 'values' => $categories);

//The type of address (main/billing etc.) to display
$addtypes = array ('Main' => 'Main', 'Billing' => 'Billing', 'Shipping' => 'Shipping', 'Payment' => 'Payment', 'Technical' => 'Technical');
$search['addtype'] = array ('name' => "Address Type", 'type' => 'select', 'values' => $addtypes);

//the format of label to be printed
$formats = array ('2x7' => '2x7', '3x8' => '3x8', _('None') => 'none',);
$search['formats'] = array ('name' => _('Format'), 'type' => 'select', 'values' => $formats);

//the type of letter to be printed
$query = 'SELECT id, name FROM letters WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY name';
$rs = $db->execute($query);
if (EGS_DEBUG_SQL && !$rs)
	//$db->close();
	die($db->errorMsg());

$lettertypes = array ();
$lettertypes[_('None')] = 'none';
while (!$rs->EOF) {
	$lettertypes[$rs->fields['name']] = $rs->fields['id'];
	$rs->MoveNext();
}
//$lettertypes = array ('Letter1' => 'Letter1', 'Letter2' => 'Letter2', 'Letter3' => 'Letter3');
$search['lettertypes'] = array ('name' => _('Letter Type'), 'type' => 'select', 'values' => $lettertypes);

//simplex or duplex printing modes
$printmode = array ('Simplex' => 'Simplex', 'Duplex' => 'Duplex');
$search['printmode'] = array ('name' => _('Printer Mode'), 'type' => 'select', 'values' => $printmode);

//add the search boxes to smarty
$smarty->assign('search', $search);

//if the form has been submitted
//if (sizeof($_POST) > 0) {
if (isset ($_POST['formats'])) {
	$_SESSION['labelsformat'] = $_POST['formats'];
}
if (isset ($_POST['lettertypes'])) {
	$_SESSION['labelslettertypes'] = $_POST['lettertypes'];
}
if (isset ($_POST['printmode'])) {
	$_SESSION['labelsprintmode'] = $_POST['printmode'];
}
if (isset ($_POST['reference']))
	$_SESSION['labelsReference'] = true;
else
	$_SESSION['labelsReference'] = false;
if (isset ($_POST['person']))
	$person = $_POST['person'];
if (isset ($_POST['companyname']))
	$companyname = $_POST['companyname'];
if (isset ($_POST['assigned']))
	$assigned = $_POST['assigned'];
if (isset ($_POST['assigned']) && ($assigned == ''))
	unset ($assigned);
if ((isset ($person)) && ($person == ''))
	unset ($person);
if ((isset ($companyname)) && ($companyname == ''))
	unset ($companyname);

$egs->checkPost();

//not used(?)
$save = false;
if (isset ($_POST['clearsearch'])) {
	$clearsearch = $_POST['clearsearch'];
	unset ($_POST['clearsearch']);
}
if (!isset ($_SESSION['labelsSearch']) || ($_SESSION['labelsSearch'] == '') || isset ($clearsearch)) {
	if (isset ($_SESSION['preferences']['labelsSearch']))
		$_SESSION['labelsSearch'] = $_SESSION['preferences']['labelsSearch'];
	else
		unset ($_SESSION['labelsSearch']);
}

/* If Saving, set to search then save */
if (isset ($_POST['savesearch'])) {
	unset ($_POST['savesearch']);
	$_SESSION['preferences']['labelsSearch'] = $_POST;
	$_SESSION['labelsSearch'] = $_POST;
	$egs->syncPreferences();
}
//end of not used

/* We are searching */
if (isset ($_POST['search'])) {
	unset ($_POST['search']);
	$_SESSION['labelsSearch'] = $_POST;
	$_SESSION['labels_page'] = 1;
}

/* No choice in column ordering for this page */
if (!isset ($_SESSION['preferences']['labelsColumns']) || !is_array($_SESSION['preferences']['labelsColumns'])) {
	$_SESSION['preferences']['labelsColumns'] = array ();
	$_SESSION['preferences']['labelsColumns'][] = 'name';
	$_SESSION['preferences']['labelsColumns'][] = 'person';
	$_SESSION['preferences']['labelsColumns'][] = 'address';
}
if (isset ($_SESSION['labelsSearch']['formats']))
	unset ($_SESSION['labelsSearch']['formats']);
if (isset ($_SESSION['labelsSearch']['lettertypes']))
	unset ($_SESSION['labelsSearch']['lettertypes']);
if (isset ($_SESSION['labelsSearch']['printmode']))
	unset ($_SESSION['labelsSearch']['printmode']);
if (isset ($_SESSION['labelsSearch']['reference']))
	unset ($_SESSION['labelsSearch']['reference']);
/* Array to hold the columns */
$headings = array ();

/* Iterate over the columns and translate */
for ($i = 0; $i < sizeof($_SESSION['preferences']['labelsColumns']); $i ++) {
	switch ($_SESSION['preferences']['labelsColumns'][$i]) {
		case 'name' :
			$headings[$_SESSION['preferences']['labelsColumns'][$i]] = _('Company Name');
			break;
		case 'person' :
			$headings[$_SESSION['preferences']['labelsColumns'][$i]] = _('Person');
			break;
		case 'address' :
			$headings[$_SESSION['preferences']['labelsColumns'][$i]] = _('Address');
			break;
	}
}

$smarty->assign('headings', $headings);

/* Do Search */
$address_type = 'Main';
if (isset ($_SESSION['labelsSearch']['addtype']))
	$address_type = $_SESSION['labelsSearch']['addtype'];
if (isset ($_SESSION['labelsSearch']['x_typeid']))
	$cat = $_SESSION['labelsSearch']['x_typeid'];
if (isset ($_SESSION['labelsSearch']['assigned']))
	unset ($_SESSION['labelsSearch']['assigned']);
if (isset ($_SESSION['labelsSearch']['addtype']))
	unset ($_SESSION['labelsSearch']['addtype']);

// Set the search order 

if (isset ($_GET['order']) && ($_GET['order'] == $_SESSION['labelOrder']) && in_array($_GET['order'], $_SESSION['preferences']['labelsColumns'])) {
	if (isset ($_SESSION['labelSort']) && ($_SESSION['labelSort'] == 'ASC'))
		$_SESSION['labelSort'] = 'DESC';
	else
		if (isset ($_SESSION['labelSort']) && ($_SESSION['labelSort'] == 'DESC'))
			$_SESSION['labelSort'] = 'ASC';
	$_SESSION['label_page'] = 1;
} else
	if (isset ($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['labelsColumns'])) {
		$_SESSION['labelSort'] = 'DESC';
		$_SESSION['labelOrder'] = $_GET['order'];
		$_SESSION['label_page'] = 1;
	}

if (!isset ($_SESSION['labelOrder']))
	$_SESSION['labelOrder'] = $_SESSION['preferences']['labelsColumns'][1];
if (!isset ($_SESSION['labelSort']))
	$_SESSION['labelSort'] = 'ASC';

$_SESSION['order'] = $_SESSION['labelOrder'];

//build query
//,
//get rid of these before case if want to work normally

//, ca.street1 || ', ' || ca.street2 || ', ' || ca.street3 || ', '
//|| ca.town || ', ' || ca.county || ', ' || ca.postcode || ', ' ||
//ca.countrycode AS address
if (isset ($_SESSION['labelsSearch']['person'])) {
	$_SESSION['labelsSearch']['p.firstname || \' \' || p.surname'] = $_SESSION['labelsSearch']['person'];
	unset ($_SESSION['labelsSearch']['person']);
}

//if(isset($_SESSION['labelsSearch'])&&(!isset($_POST)||count($_POST)==0))$_POST=$_SESSION['labelsSearch'];
$query = "select ca.street1, ca.street2, ca.street3, ca.town, ca.county, ca.postcode, ca.countrycode, case when p.id is null then c.id || '/' else c.id ||
'/' || p.id end ,c.name AS name, p.firstname || ' ' || p.surname AS
person FROM company c LEFT OUTER JOIN person p ON
(p.companyid=c.id) LEFT OUTER JOIN companyaddress ca ON
(c.id=ca.companyid), companyaccess a";
if (isset ($cat))
	$query .= ', companytypexref x';

$query .= " WHERE ca.Main AND a.companyid=c.id
AND a.usercompanyid=".$db->qstr(EGS_COMPANY_ID)." AND a.username=".$db->qstr(EGS_USERNAME).' AND a.type>2';
if (isset ($cat))
	$query .= ' AND x.companyid=c.id';
$searchString = '';
if (isset ($_SESSION['labelsSearch']) && is_array($_SESSION['labelsSearch']))
	$searchString = $egs->searchString($_SESSION['labelsSearch']);
if (($searchString != '') && ($searchString != ')'))
	$query .= ' AND '.$searchString;
$query .= " union select ca.street1, ca.street2, ca.street3, ca.town, ca.county, ca.postcode, ca.countrycode, case when p.id is null then c.id || '/' else c.id ||
'/' || p.id end ,c.name AS name, p.firstname || ' ' || p.surname AS
person FROM company c LEFT OUTER JOIN person p ON (p.companyid=c.id) LEFT OUTER
JOIN personaddress ca ON (p.id=ca.personid), companyaccess a ";
if (isset ($cat))
	$query .= ', companytypexref x';
$query .= " WHERE ca.Main AND a.companyid=c.id AND a.usercompanyid=".$db->qstr(EGS_COMPANY_ID)." AND a.type>2 AND
a.username=".$db->qstr(EGS_USERNAME)."";
if (isset ($cat))
	$query .= ' AND x.companyid=c.id';

/*
$query = "select case when p.id is null then c.id || '/' else c.id || '/' || p.id end ,c.name AS name, p.firstname || ' ' || p.surname AS person,
	ca.street1 || ', ' || ca.street2 || ', ' || ca.street3 || ', ' || ca.town || ', ' || ca.county || ', ' || ca.postcode
	|| ', ' || ca.countrycode AS address FROM company c LEFT OUTER JOIN person p ON
	(p.companyid=c.id";
$query .= ") LEFT OUTER JOIN companyaddress ca ON (c.id=ca.companyid), companyaccess a";
if (isset ($cat))
	$query .= ', companytypexref x';

$query .= " WHERE ca.companyid=c.id AND ca.$address_type AND a.companyid=c.id AND a.usercompanyid=".$db->qstr(EGS_COMPANY_ID).' AND a.username='.$db->qstr(EGS_USERNAME)."";

if (isset ($cat))
	$query .= ' AND x.companyid=c.id';
*/
$searchString = '';
if (isset ($_SESSION['labelsSearch']) && is_array($_SESSION['labelsSearch']))
	$searchString = $egs->searchString($_SESSION['labelsSearch']);
if (isset ($_SESSION['labelsSearch']) && (sizeof($_SESSION['labelsSearch']) > 0)) {
	if (($searchString != '') && ($searchString != ')'))
		$query .= ' AND '.$searchString;

	/*tidy up the search fields (set them to the right values)*/
	//assignedunset ($_SESSION['labelsSearch']['formats']);
	//unset ($_SESSION['labelsSearch']['lettertypes']);
	//unset ($_SESSION['labelsSearch']['printmode']);
	//unset ($_SESSION['labelsSearch']['reference']);
	//format
	//letter
	//printer
	//addtype
	if (isset ($assigned))
		$_SESSION['labelsSearch']['assigned'] = $assigned;
	if (isset ($address_type))
		$_SESSION['labelsSearch']['addtype'] = $address_type;
	if (isset ($_SESSION['labelsformat']))
		$_SESSION['labelsSearch']['formats'] = $_SESSION['labelsformat'];
	if (isset ($_SESSION['labelslettertypes']))
		$_SESSION['labelsSearch']['lettertypes'] = $_SESSION['labelslettertypes'];
	if (isset ($_SESSION['labelsprintmode']))
		$_SESSION['labelsSearch']['printmode'] = $_SESSION['labelsprintmode'];

	if (isset ($_SESSION['labelsSearch']['p.firstname || \' \' || p.surname'])) {
		$_SESSION['labelsSearch']['person'] = $_SESSION['labelsSearch']['p.firstname || \' \' || p.surname'];
		unset ($_SESSION['labelsSearch']['p.firstname || \' \' || p.surname']);
	}
	$_SESSION['search'] = $_SESSION['labelsSearch'];
} else
	if (isset ($_SESSION['search']))
		unset ($_SESSION['search']);

//$query = str_replace("AND (lower(clearsearch) LIKE 'clear search%' )", '',$query);
if (isset ($assigned))
	$query .= ' AND case when p.id is null then c.assigned='.$db->qstr($assigned).' else p.assigned='.$db->qstr($assigned).' OR (c.assigned='.$db->qstr($assigned).'AND p.assigned is null) end';
//$query .= " ORDER BY c.name, person";

//keep track of search terms
if (isset ($_SESSION['labelsSearch']) && (sizeof($_SESSION['labelsSearch']) > 0)) {
	$_SESSION['search'] = $_SESSION['labelsSearch'];
} else
	if (isset ($_SESSION['search']))
		unset ($_SESSION['search']);
if ($_SESSION['labelOrder'] == 'address')
	$_SESSION['labelOrder'] = 'street1';

$query .= ' ORDER BY '.$_SESSION['labelOrder'].' '.$_SESSION['labelSort'];
/* Set up the pager and send the query */
$egs->page($query, 'labels_page');

//} else
//if (!isset ($_SESSION['labelsSearch']) && isset ($_SESSION['preferences']['labelsSearch']))
//	$_SESSION['labelsSearch'] = $_SESSION['preferences']['labelsSearch'];
?>
