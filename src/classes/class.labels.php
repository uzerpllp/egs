<?php

session_start();
require_once 'DB.php';
require_once '../src/fpdf/fpdf.php';
require_once '../src/db.php';

/* config */
$FONT_NAME=$_POST['font_name'];
$FONT_SIZE=$_POST['font_size'];
$FONT_SPACING=$_POST['font_spacing'];
$LAYOUT_COLS=$_POST['layout_cols'];
$LAYOUT_ROWS=$_POST['layout_rows'];
$CELL_WIDTH=$_POST['cell_width'];
$CELL_HEIGHT=$_POST['cell_height'];
$MARGIN_TOP=$_POST['margin_top'];
$MARGIN_LEFT=$_POST['margin_left'];
$NAME_DEFAULT=$_POST['name_default'];
$NAME_PREFIX=$_POST['name_prefix'];

/* init pdf */
$pdf = new FPDF();
$pdf->setFont($FONT_NAME, '', $FONT_SIZE);
$pdf->setAutoPageBreak(false);

$done = false;
/* page */
while (!$done) {
	$pdf->addPage('P');

	/* row */
	$pos_y = $MARGIN_TOP;
	for ($i = 0; $i < $LAYOUT_ROWS; $i++) {
		$pos_x = $MARGIN_LEFT;
		/* col */
		for ($j = 0; $j < $LAYOUT_COLS; $j++) {
			$ids = explode('/', array_pop($_POST['item']));

			$query = 'SELECT c.name, p.firstname || \' \' || p.surname AS fullname, a.street1, a.street2, a.street3, a.town, a.county, a.postcode, a.countrycode
				FROM company c LEFT OUTER JOIN personaccess pa ON (c.id=pa.companyid AND pa.usercompanyid='.$db->quote($_SESSION['companyid']).' AND pa.username='.$db->quote($_SESSION['egsusername']).' AND pa.personid='.$db->quote($ids[1]).') LEFT OUTER JOIN person p ON (pa.personid=p.id AND p.id='.$db->quote($ids[1]).'), companyaddress a WHERE a.main AND a.companyid=c.id AND c.id='.$db->quote($ids[0]).' LIMIT 1';
			$res = $db->query($query);

			if(!$done) {
				$row =& $res->fetchRow(DB_FETCHMODE_ASSOC);
				$res->free();
			}

			$pdf->setXY($pos_x, $pos_y);
			
			$info = '';

			while (list ($key, $val) = each($row)) {
				if($key == 'fullname') $info .= $NAME_PREFIX . ( isset($row['fullname']) ? $row['fullname'] : $NAME_DEFAULT)."\n";
				else if($val != '') $info .= $val . "\n";
			}
			$pdf->multiCell($CELL_WIDTH, $FONT_SPACING, $info, 0, 'L');

			$pos_x += $CELL_WIDTH;
			if(sizeof($_POST['item']) ==0) {
				$done = true;
				break;
			}
		}
		$pos_y += $CELL_HEIGHT;
	}
}
$pdf->output('egs_print.pdf', 'I');

?>
