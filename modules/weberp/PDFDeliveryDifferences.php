<?php
/* $Revision: 1.9 $ */

$PageSecurity = 3;
include ('includes/session.inc');
include('includes/SQL_CommonFunctions.inc');

$InputError=0;

if (isset($_POST['FromDate']) AND !Is_Date($_POST['FromDate'])){
	$msg = _('The date from must be specified in the format') . ' ' . $_SESSION['DefaultDateFormat'];
	$InputError=1;
}
if (isset($_POST['ToDate']) AND !Is_Date($_POST['ToDate'])){
	$msg =  _('The date to must be specified in the format') . ' ' .  $_SESSION['DefaultDateFormat'];
	$InputError=1;
}

if (!isset($_POST['FromDate']) OR !isset($_POST['ToDate']) OR $InputError==1){

     $title = _('Delivery Differences Report');
     include ('includes/header.inc');

     echo "<FORM METHOD='post' action='" . $_SERVER['PHP_SELF'] . '?' . SID . "'>";
     echo '<CENTER><TABLE><TR><TD>' . _('Enter the date from which variances between orders and deliveries are to be listed') . ":</TD><TD><INPUT TYPE=text NAME='FromDate' MAXLENGTH=10 SIZE=10 VALUE='" . Date($_SESSION['DefaultDateFormat'], Mktime(0,0,0,Date('m')-1,0,Date('y'))) . "'></TD></TR>";
     echo '<TR><TD>' . _('Enter the date to which variances between orders and deliveries are to be listed') . ":</TD><TD><INPUT TYPE=text NAME='ToDate' MAXLENGTH=10 SIZE=10 VALUE='" . Date($_SESSION['DefaultDateFormat']) . "'></TD></TR>";
     echo '<TR><TD>' . _('Inventory Category') . '</TD><TD>';

     $sql = "SELECT categorydescription, categoryid FROM stockcategory WHERE stocktype<>'D' AND stocktype<>'L'";
     $result = DB_query($sql,$db);


     echo "<SELECT NAME='CategoryID'>";
     echo "<OPTION SELECTED VALUE='All'>" . _('Over All Categories');

     while ($myrow=DB_fetch_array($result)){
	echo "<OPTION VALUE='" . $myrow['categoryid'] . "'>" . $myrow['categorydescription'];
     }


     echo '</SELECT></TD></TR>';

     echo '<TR><TD>' . _('Inventory Location') . ":</TD><TD><SELECT NAME='Location'>";
     echo "<OPTION SELECTED VALUE='All'>" . _('All Locations');

     $result= DB_query('SELECT loccode, locationname FROM locations',$db);
     while ($myrow=DB_fetch_array($result)){
	echo "<OPTION VALUE='" . $myrow['loccode'] . "'>" . $myrow['locationname'];
     }
     echo '</SELECT></TD></TR>';

     echo '<TR><TD>' . _('Email the report off') . ":</TD><TD><SELECT NAME='Email'>";
     echo "<OPTION SELECTED VALUE='No'>" . _('No');
     echo "<OPTION VALUE='Yes'>" . _('Yes');
     echo "</SELECT></TD></TR></TABLE><INPUT TYPE=SUBMIT NAME='Go' VALUE='" . _('Create PDF') . "'></CENTER>";

     if ($InputError==1){
     	prnMsg($msg,'error');
     }
     include('includes/footer.inc');
     exit;
} else {
	include('includes/ConnectDB.inc');
}

if ($_POST['CategoryID']=='All' AND $_POST['Location']=='All'){
	$sql= "SELECT invoiceno,
			orderdeliverydifferenceslog.orderno,
			orderdeliverydifferenceslog.stockid,
			stockmaster.description,
			quantitydiff,
			trandate,
			orderdeliverydifferenceslog.debtorno,
			orderdeliverydifferenceslog.branch
		FROM orderdeliverydifferenceslog INNER JOIN stockmaster
			ON orderdeliverydifferenceslog.stockid=stockmaster.stockid
		INNER JOIN debtortrans ON orderdeliverydifferenceslog.invoiceno=debtortrans.transno
			AND debtortrans.type=10
			AND trandate >='" . FormatDateForSQL($_POST['FromDate']) . "'
			AND trandate <='" . FormatDateForSQL($_POST['ToDate']) . "'";

} elseif ($_POST['CategoryID']!='All' AND $_POST['Location']=='All') {
	$sql= "SELECT invoiceno,
			orderdeliverydifferenceslog.orderno,
			orderdeliverydifferenceslog.stockid,
			stockmaster.description,
			quantitydiff,
			trandate,
			orderdeliverydifferenceslog.debtorno,
			orderdeliverydifferenceslog.branch
		FROM orderdeliverydifferenceslog INNER JOIN stockmaster
			ON orderdeliverydifferenceslog.stockid=stockmaster.stockid
			INNER JOIN debtortrans ON orderdeliverydifferenceslog.invoiceno=debtortrans.transno
			AND debtortrans.type=10
			AND trandate >='" . FormatDateForSQL($_POST['FromDate']) . "'
			AND trandate <='" . FormatDateForSQL($_POST['ToDate']) . "'
			AND categoryid='" . $_POST['CategoryID'] ."'";

} elseif ($_POST['CategoryID']=='All' AND $_POST['Location']!='All') {
	$sql = "SELECT invoiceno,
			orderdeliverydifferenceslog.orderno,
			orderdeliverydifferenceslog.stockid,
			stockmaster.description,
			quantitydiff,
			trandate,
			orderdeliverydifferenceslog.debtorno,
			orderdeliverydifferenceslog.branch
		FROM orderdeliverydifferenceslog INNER JOIN stockmaster
			ON orderdeliverydifferenceslog.stockid=stockmaster.stockid
			INNER JOIN debtortrans
				ON orderdeliverydifferenceslog.invoiceno=debtortrans.transno
				INNER JOIN salesorders
					ON orderdeliverydifferenceslog.orderno=salesorders.orderno
		WHERE debtortrans.type=10
		AND salesorders.fromstkloc='". $_POST['Location'] . "'
		AND trandate >='" . FormatDateForSQL($_POST['FromDate']) . "'
		AND trandate <='" . FormatDateForSQL($_POST['ToDate']) . "'";

} elseif ($_POST['CategoryID']!='All' AND $_POST['location']!='�ll'){

	$sql = "SELECT invoiceno,
			orderdeliverydifferenceslog.orderno,
			orderdeliverydifferenceslog.stockid,
			stockmaster.description,
			quantitydiff,
			trandate,
			orderdeliverydifferenceslog.debtorno,
			orderdeliverydifferenceslog.branch
		FROM orderdeliverydifferenceslog INNER JOIN stockmaster
			ON orderdeliverydifferenceslog.stockid=stockmaster.stockid
			INNER JOIN debtortrans
				ON orderdeliverydifferenceslog.invoiceno=debtortrans.transno
				AND debtortrans.type=10
				INNER JOIN salesorders
					ON orderdeliverydifferenceslog.orderno = salesorders.orderno
		WHERE salesorders.fromstkloc='" . $_POST['Location'] . "'
		AND categoryid='" . $_POST['CategoryID'] . "'
		AND trandate >='" . FormatDateForSQL($_POST['FromDate']) . "'
		AND trandate <= '" . FormatDateForSQL($_POST['ToDate']) . "'";
}

$Result=DB_query($sql,$db,'','',false,false); //dont error check - see below

if (DB_error_no($db)!=0){
	$title = _('Delivery Differences Log Report Error');
	include('includes/header.inc');
	prnMsg( _('An error occurred getting the variances between deliveries and orders'),'error');
	if ($debug==1){
		prnMsg( _('The SQL used to get the variances between deliveries and orders that failed was') . "<BR>$SQL",'error');
	}
	include ('includes/footer.inc');
	exit;
} elseif (DB_num_rows($Result)==0){
	$title = _('Delivery Differences Log Report Error');
  	include('includes/header.inc');
	prnMsg( _('There were no variances between deliveries and orders found in the database within the period from') . ' ' . $_POST['FromDate'] . ' ' . _('to') . ' ' . $_POST['ToDate'] . '. ' . _('Please try again selecting a different date range'),'info');
	if ($debug==1) {
		prnMsg( _('The SQL that returned no rows was') . '<BR>' . $sql,'error');
	}
	include('includes/footer.inc');
	exit;
}

include('includes/PDFStarter_ros.inc');

/*PDFStarter_ros.inc has all the variables for page size and width set up depending on the users default preferences for paper size */

$pdf->addinfo('Title',_('Variances Between Deliveries and Orders'));
$pdf->addinfo('Subject',_('Variances Between Deliveries and Orders from') . ' ' . $_POST['FromDate'] . ' ' . _('to') . ' ' . $_POST['ToDate']);

$line_height=12;
$PageNumber = 1;

$TotalDiffs = 0;

include ('includes/PDFDeliveryDifferencesPageHeader.inc');

while ($myrow=DB_fetch_array($Result)){

      $LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,40,$FontSize,$myrow['invoiceno'], 'left');
      $LeftOvers = $pdf->addTextWrap($Left_Margin+40,$YPos,40,$FontSize,$myrow['orderno'], 'left');
      $LeftOvers = $pdf->addTextWrap($Left_Margin+80,$YPos,200,$FontSize,$myrow['stockid'] . ' - ' . $myrow['description'], 'left');

      $LeftOvers = $pdf->addTextWrap($Left_Margin+280,$YPos,50,$FontSize,number_format($myrow['quantitydiff']), 'right');
      $LeftOvers = $pdf->addTextWrap($Left_Margin+335,$YPos,50,$FontSize,$myrow['debtorno'], 'left');
      $LeftOvers = $pdf->addTextWrap($Left_Margin+385,$YPos,50,$FontSize,$myrow['branch'], 'left');
      $LeftOvers = $pdf->addTextWrap($Left_Margin+435,$YPos,50,$FontSize,ConvertSQLDate($myrow['trandate']), 'left');

      $YPos -= ($line_height);
      $TotalDiffs++;

      if ($YPos - (2 *$line_height) < $Bottom_Margin){
          /*Then set up a new page */
              $PageNumber++;
	      include ('includes/PDFDeliveryDifferencesPageHeader.inc');
      } /*end of new page header  */
} /* end of while there are delivery differences to print */


$YPos-=$line_height;
$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,200,$FontSize,_('Total number of differences') . ' ' . number_format($TotalDiffs), 'left');

if ($_POST['CategoryID']=='All' AND $_POST['Location']=='All'){
	$sql = "SELECT COUNT(salesorderdetails.orderno) 
			FROM salesorderdetails INNER JOIN debtortrans 
				ON salesorderdetails.orderno=debtortrans.order_ 
			WHERE debtortrans.trandate>='" . FormatDateForSQL($_POST['FromDate']) . "' 
			AND debtortrans.trandate <='" . FormatDateForSQL($_POST['ToDate']) . "'";

} elseif ($_POST['CategoryID']!='All' AND $_POST['Location']=='All') {
	$sql = "SELECT COUNT(salesorderdetails.orderno) 
		FROM salesorderdetails INNER JOIN debtortrans 
			ON salesorderdetails.orderno=debtortrans.order_ INNER JOIN stockmaster 
			ON salesorderdetails.stkcode=stockmaster.stockid 
		WHERE debtortrans.trandate>='" . FormatDateForSQL($_POST['FromDate']) . "' 
		AND debtortrans.trandate <='" . FormatDateForSQL($_POST['ToDate']) . "' 
		AND stockmaster.categoryid='" . $_POST['CategoryID'] . "'";

} elseif ($_POST['CategoryID']=='All' AND $_POST['Location']!='All'){

	$sql = "SELECT COUNT(salesorderdetails.orderno) 
		FROM salesorderdetails INNER JOIN debtortrans 
			ON salesorderdetails.orderno=debtortrans.order_ INNER JOIN salesorders 
			ON salesorderdetails.orderno = salesorders.orderno 
		WHERE debtortrans.trandate>='". FormatDateForSQL($_POST['FromDate']) . "' 
		AND debtortrans.trandate <='" . FormatDateForSQL($_POST['ToDate']) . "' 
		AND salesorders.fromstkloc='" . $_POST['Location'] . "'";

} elseif ($_POST['CategoryID'] !='All' AND $_POST['Location'] !='All'){

	$sql = "SELECT COUNT(salesorderdetails.orderno) 
		FROM salesorderdetails INNER JOIN debtortrans ON salesorderdetails.orderno=debtortrans.order_ 
			INNER JOIN salesorders ON salesorderdetails.orderno = salesorders.orderno 
			INNER JOIN stockmaster ON salesorderdetails.stkcode = stockmaster.stockid 
		WHERE salesorders.fromstkloc ='" . $_POST['Location'] . "' 
		AND categoryid='" . $_POST['CategoryID'] . "' 
		AND trandate >='" . FormatDateForSQL($_POST['FromDate']) . "' 
		AND trandate <= '" . FormatDateForSQL($_POST['ToDate']) . "'";

}
$Errmsg = _('Could not retrieve the count of sales order lines in the period under review');
$result = DB_query($sql,$db,$ErrMsg);


$myrow=DB_fetch_row($result);
$YPos-=$line_height;
$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,200,$FontSize,_('Total number of order lines') . ' ' . number_format($myrow[0]), 'left');

$YPos-=$line_height;
$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,200,$FontSize,_('DIFOT') . ' ' . number_format((1-($TotalDiffs/$myrow[0])) * 100,2) . '%', 'left');


$pdfcode = $pdf->output();
$len = strlen($pdfcode);
header('Content-type: application/pdf');
header('Content-Length: ' . $len);
header('Content-Disposition: inline; filename=DeliveryDifferences.pdf');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');

$pdf->stream();

if ($_POST['Email']=='Yes'){
	if (file_exists($_SESSION['reports_dir'] . '/DeliveryDifferences.pdf')){
		unlink($_SESSION['reports_dir'] . '/DeliveryDifferences.pdf');
	}
    	$fp = fopen( $_SESSION['reports_dir'] . '/DeliveryDifferences.pdf','wb');
	fwrite ($fp, $pdfcode);
	fclose ($fp);

	include('includes/htmlMimeMail.php');

	$mail = new htmlMimeMail();
	$attachment = $mail->getFile($_SESSION['reports_dir'] . '/DeliveryDifferences.pdf');
	$mail->setText(_('Please find herewith delivery differences report from') . ' ' . $_POST['FromDate'] .  ' '. _('to') . ' ' . $_POST['ToDate']);
	$mail->addAttachment($attachment, 'DeliveryDifferences.pdf', 'application/pdf');
	$mail->setFrom($_SESSION['CompanyRecord']['coyname'] . '<' . $_SESSION['CompanyRecord']['email'] .'>');

	/* $DelDiffsRecipients defined in config.php */
	$result = $mail->send($DelDiffsRecipients);
}

?>