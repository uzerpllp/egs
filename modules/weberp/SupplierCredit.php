<?php
/* $Revision: 1.8 $ */
/*This page is very largely the same as the SupplierInvoice.php script
the same result could have been acheived by using if statements in that script and just having the one
SupplierTransaction.php script. However, to aid readability - variable names have been changed  -
and reduce clutter (in the form of a heap of if statements) two seperate scripts have been used, 
both with very similar code.

This does mean that if the logic is to be changed for supplier transactions then it needs to be changed
in both scripts.

This is widely considered poor programming but in my view, much easier to read for the uninitiated

*/

/*The supplier transaction uses the SuppTrans class to hold the information about the credit note
the SuppTrans class contains an array of GRNs objects - containing details of GRNs for invoicing and also
an array of GLCodes objects - only used if the AP - GL link is effective */

include('includes/DefineSuppTransClass.php');

$PageSecurity = 5;

/* Session started in header.inc for password checking and authorisation level check */

include('includes/session.inc');

$title = _('Supplier Credit Note');

include('includes/header.inc');
include('includes/SQL_CommonFunctions.inc');


if (isset($_GET['SupplierID'])){

 /*It must be a new credit note entry - clear any existing credit note details from the SuppTrans object and initiate a newy*/

	if (isset($_SESSION['SuppTrans'])){
		unset ($_SESSION['SuppTrans']->GRNs);
		unset ($_SESSION['SuppTrans']->Shipts);
		unset ($_SESSION['SuppTrans']->GLCodes);
		unset ($_SESSION['SuppTrans']);
	}

	 $_SESSION['SuppTrans'] = new SuppTrans;

/*Now retrieve supplier information - name, currency, default ex rate, terms, tax rate etc */

	 $sql = "SELECT suppliers.suppname,
	 		paymentterms.terms,
			paymentterms.daysbeforedue,
			paymentterms.dayinfollowingmonth,
	 		suppliers.currcode,
			currencies.rate As exrate,
			taxauthorities.description As taxdesc,
	 		taxauthorities.taxid,
			taxauthorities.purchtaxglaccount AS taxglcode
	 	FROM suppliers,
			currencies,
			paymentterms,
			taxauthorities
	 	WHERE suppliers.taxauthority = taxauthorities.taxid
	 	AND suppliers.currcode=currencies.currabrev
	 	AND suppliers.paymentterms=paymentterms.termsindicator
	 	AND suppliers.supplierid = '" . $_GET['SupplierID'] . "'";

	 $ErrMsg = _('The supplier record selected') . ': ' . $_GET['SupplierID'] . ' ' . _('cannot be retrieved because');
	 $DbgMsg = _('The SQL used to retrieve the supplier details and failed was');
	 $result = DB_query($sql, $db, $ErrMsg, $DbgMsg);

	 $myrow = DB_fetch_array($result);

	 $_SESSION['SuppTrans']->SupplierName = $myrow['suppname'];
	 $_SESSION['SuppTrans']->TermsDescription = $myrow['terms'];
	 $_SESSION['SuppTrans']->CurrCode = $myrow['currcode'];
	 $_SESSION['SuppTrans']->ExRate = $myrow['exrate'];

	 if ($myrow['daysbeforedue'] == 0){
	 	$_SESSION['SuppTrans']->Terms = "1" . $myrow['dayinfollowingmonth'];
	 } else {
		$_SESSION['SuppTrans']->Terms = "0" . $myrow['daysbeforedue'];
	 }
	 $_SESSION['SuppTrans']->SupplierID = $_GET['SupplierID'];
	 $_SESSION['SuppTrans']->TaxDescription = $myrow['taxdesc'];

	 $LocalTaxAuthResult = DB_query("SELECT taxauthority FROM locations WHERE loccode='" . $_SESSION['UserStockLocation'] . "'", $db);
	 $LocalTaxAuthRow = DB_fetch_row($LocalTaxAuthResult);

	 $_SESSION['SuppTrans']->TaxRate = GetTaxRate($myrow['taxid'],$LocalTaxAuthRow[0], $_SESSION['DefaultTaxLevel'], $db);

	 $_SESSION['SuppTrans']->TaxGLCode = $myrow['taxglcode'];

	 $_SESSION['SuppTrans']->GLLink_Creditors = $_SESSION['CompanyRecord']['gllink_creditors'];
	 $_SESSION['SuppTrans']->GRNAct = $_SESSION['CompanyRecord']['grnact'];
	 $_SESSION['SuppTrans']->CreditorsAct = $_SESSION['CompanyRecord']['creditorsact'];
	 $_SESSION['SuppTrans']->InvoiceOrCredit = 'Credit Note';

} elseif (!isset($_SESSION['SuppTrans'])){
	prnMsg(_('To enter a supplier credit note the supplier must first be selected from the supplier selection screen'),'warn');
	echo "<BR><A HREF='$rootpath/SelectSupplier.php?" . SID ."'>" . _('Select A Supplier to Enter an Credit Note For') . '</A>';
	exit;

	/*It all stops here if there aint no supplier selected */
}

/* Set the session variables to the posted data from the form if the page has called itself */

if (isset($_POST['ExRate'])){
	$_SESSION['SuppTrans']->ExRate = $_POST['ExRate'];
	$_SESSION['SuppTrans']->Comments = $_POST['Comments'];
	$_SESSION['SuppTrans']->TranDate = $_POST['TranDate'];

	if (substr($_SESSION['SuppTrans']->$Terms,0,1)=="1") {
		$_SESSION['SuppTrans']->DueDate = Date($_SESSION['DefaultDateFormat'], Mktime(0,0,0,Date("m")+1,substr($_SESSION['SuppTrans']->$Terms,1),Date("y")));
	} else {
		$_SESSION['SuppTrans']->DueDate = Date($_SESSION['DefaultDateFormat'], Mktime(0,0,0,Date("m")+1,Date("d") + (int) substr($_SESSION['SuppTrans']->$Terms,1),Date("y")));
	}

	$_SESSION['SuppTrans']->SuppReference = $_POST['SuppReference'];

	if ($_SESSION['SuppTrans']->GLLink_Creditors ==1){

/*The link to GL from creditors is active so the total should be built up from GLPostings and GRN entries
if the link is not active then OvAmount must be entered manually. */

		$_SESSION['SuppTrans']->OvAmount =0; /* for starters */
		foreach ($_SESSION['SuppTrans']->GRNs as $GRN){
			$_SESSION['SuppTrans']->OvAmount = $_SESSION['SuppTrans']->OvAmount + ($GRN->This_QuantityInv * $GRN->ChgPrice);
		}

		foreach ($_SESSION['SuppTrans']->GLCodes as $GLLine){
			$_SESSION['SuppTrans']->OvAmount = $_SESSION['SuppTrans']->OvAmount + $GLLine->Amount;
		}

		$_SESSION['SuppTrans']->OvAmount = round($_SESSION['SuppTrans']->OvAmount,2);
	}else {

/*OvAmount must be entered manually */

		$_SESSION['SuppTrans']->OvAmount = round($_POST['OvAmount'],2);
	}
	if ($_POST['OverrideTax']=='Man'){
		$_SESSION['SuppTrans']->OvGST = round($_POST['OvGST'],2);
	} else {
		$_SESSION['SuppTrans']->OvGST = round($_SESSION['SuppTrans']->TaxRate * $_SESSION['SuppTrans']->OvAmount,2);
	}
}

if ($_POST['GRNS'] == _('Enter Credit Against Goods Recd')){

	/*This ensures that any changes in the page are stored in the session before calling the grn page */

	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=" . $rootpath . "/SuppCreditGRNs.php?" . SID . "'>";
	echo '<P>' . _('You should automatically be forwarded to the entry of credit notes against goods received page') . '. ' .
						_('If this does not happen') . ' (' . _('if the browser does not support META Refresh') . ') ' .
						"<A HREF='" . $rootpath . "/SuppCreditGRNs.php?" . SID . "'>" .
						_('click here') . '</A> ' . _('to continue') . '.<BR>';
	include('includes/footer.inc');
	exit;
}
if (isset($_POST['Shipts'])){

	/*This ensures that any changes in the page are stored in the session before calling the shipments page */

	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=" . $rootpath . "/SuppShiptChgs.php?" . SID . "'>";
	echo '<P>' . _('You should automatically be forwarded to the entry of credit notes against shipments page') . '. ' .
						_('If this does not happen') . ' (' . _('if the browser does not support META Refresh') . ') ' .
						"<A HREF='" . $rootpath . "/SuppShiptChgs.php?" . SID . "'>" .
						_('click here') . '</A> ' . _('to continue') . '.<BR>';
	include('includes/footer.inc');
	exit;
}
if ($_POST['GL'] == _('Enter General Ledger Analysis')){

	/*This ensures that any changes in the page are stored in the session before calling the shipments page */

	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=" . $rootpath . "/SuppTransGLAnalysis.php?" . SID . "'>";
	echo '<P>' . _('You should automatically be forwarded to the entry of credit notes against the general ledger page') . '. ' .
						_('If this does not happen') . ' (' . _('if the browser does not support META Refresh') . ') ' .
						"<A HREF='" . $rootpath . "/SuppTransGLAnalysis.php?" . SID . "'>" .
						_('click here') . '</A> ' . _('to continue') . '.<BR>';
	include('includes/footer.inc');
	exit;
}
/* everything below here only do if a Supplier is selected
   fisrt add a header to show who we are making an credit note for */

echo "<CENTER><TABLE BORDER=2 COLSPAN=4><TR><TD CLASS='tableheader'>" . _('Supplier') . "</TD>
				<TD CLASS='tableheader'>" . _('Currency') . "</TD>
				<TD CLASS='tableheader'>" . _('Terms') . "</TD>
				<TD CLASS='tableheader'>" . _('Tax Authority') . '</TD></TR>';

echo '<TR><TD><FONT COLOR=red><B>' . $_SESSION['SuppTrans']->SupplierID . ' - ' . $_SESSION['SuppTrans']->SupplierName . '</TD>
		<TD ALIGN=CENTER><FONT COLOR=red><B>' . $_SESSION['SuppTrans']->CurrCode . '</TD>
		<TD><FONT COLOR=red><B>' . $_SESSION['SuppTrans']->TermsDescription . '</TD>
		<TD ALIGN=CENTER><FONT COLOR=red><B>' . $_SESSION['SuppTrans']->TaxDescription . ' (' . (($_SESSION['SuppTrans']->TaxRate)*100) . '%)</TD>
		</TR></TABLE></B></FONT>';

echo "<FORM ACTION='" . $_SERVER['PHP_SELF'] . "?" . SID . "' METHOD=POST>";

echo '<TABLE>';
echo '<TR><TD><FONT COLOR=red>' . _('Supplier Credit Note Reference') . ":</FONT></TD>
	<TD><FONT SIZE=2><INPUT TYPE=TEXT SIZE=20 MAXLENGTH=20 NAME=SuppReference VALUE='" . $_SESSION['SuppTrans']->SuppReference . "'></TD></TR>";

if (!isset($_SESSION['SuppTrans']->TranDate)){
	$_SESSION['SuppTrans']->TranDate= Date($_SESSION['DefaultDateFormat'], Mktime(0,0,0,Date('m'),Date('d')-1,Date('y')));
}
echo '<TR><TD><FONT COLOR=red>' . _('Credit Note Date') . ' (' . _('in format') . ' ' . $_SESSION['DefaultDateFormat'] . ") :</FONT></TD>
		<TD><INPUT TYPE=TEXT SIZE=11 MAXLENGTH=10 NAME='TranDate' VALUE=" . $_SESSION['SuppTrans']->TranDate . '></TD></TR>';
echo '<TR><TD><FONT COLOR=red>' . _('Exchange Rate') . ":</FONT></TD>
		<TD><INPUT TYPE=TEXT SIZE=11 MAXLENGTH=10 NAME='ExRate' VALUE=" . $_SESSION['SuppTrans']->ExRate . '></TD></TR>';
echo '</TABLE>';

echo "<BR><CENTER><INPUT TYPE=SUBMIT NAME='GRNS' VALUE='" . _('Enter Credit Against Goods Recd') . "'> ";
echo "<INPUT TYPE=SUBMIT NAME='Shipts' VALUE='" . _('Enter Credit Against Shipment') . "'> ";
if ( $_SESSION['SuppTrans']->GLLink_Creditors ==1){
	echo "<INPUT TYPE=SUBMIT NAME='GL' VALUE='" . _('Enter General Ledger Analysis') . "'></CENTER>";
} else {
	echo '</CENTER>';
}

if (count($_SESSION['SuppTrans']->GRNs)>0){   /*if there are some GRNs selected for crediting then */

	/*Show all the selected GRNs so far from the SESSION['SuppInv']->GRNs array
	Note that the class for carrying GRNs refers to quantity invoiced read credited in this context*/

	echo '<TABLE CELLPADDING=2>';
	$TableHeader = "<TR><TD CLASS='tableheader'>" . _('GRN') . "</TD>
				<TD CLASS='tableheader'>" . _('Item Code') . "</TD>
				<TD CLASS='tableheader'>" . _('Description') . "</TD>
				<TD CLASS='tableheader'>" . _('Quantity') . '<BR>' . _('Credited') . "</TD>
				<TD CLASS='tableheader'>" . _('Price Credited') . '<BR>' . _('in') . ' ' . $_SESSION['SuppTrans']->CurrCode . "</TD>
				<TD CLASS='tableheader'>" . _('Line Total') . '<BR>' . _('in') . ' ' . $_SESSION['SuppTrans']->CurrCode . '</TD></TR>';
	echo $TableHeader;
	$TotalGRNValue=0;

	foreach ($_SESSION['SuppTrans']->GRNs as $EnteredGRN){

		echo '<TR><TD>' . $EnteredGRN->GRNNo . '</TD>
			<TD>' . $EnteredGRN->ItemCode . '</TD>
			<TD>' . $EnteredGRN->ItemDescription . '</TD>
			<TD ALIGN=RIGHT>' . number_format($EnteredGRN->This_QuantityInv,2) . '</TD>
			<TD ALIGN=RIGHT>' . number_format($EnteredGRN->ChgPrice,2) . '</TD>
			<TD ALIGN=RIGHT>' . number_format($EnteredGRN->ChgPrice * $EnteredGRN->This_QuantityInv,2) . '</TD>
			<TD></TR>';

		$TotalGRNValue = $TotalGRNValue + ($EnteredGRN->ChgPrice * $EnteredGRN->This_QuantityInv);

		$i++;
		if ($i>15){
			$i=0;
			echo $TableHeader;
		}
	}

	echo '<TR><TD COLSPAN=5 ALIGN=RIGHT><FONT COLOR=red>' . _('Total Value of Goods Credited') . ':</FONT></TD>
		<TD ALIGN=RIGHT><FONT COLOR=red><U>' . number_format($TotalGRNValue,2) . '</U></FONT></TD></TR>';
	echo '</TABLE>';
}

if (count($_SESSION['SuppTrans']->Shipts)>0){   /*if there are any Shipment charges on the credit note*/

	echo "<TABLE CELLPADDING=2><TR><TD CLASS='tableheader'>" . _('Shipment') . "</TD>
				<TD CLASS='tableheader'>" .  _('Credit Amount') . '</B></TD></TR>';

	$TotalShiptValue=0;

	foreach ($_SESSION['SuppTrans']->Shipts as $EnteredShiptRef){

		echo '<TR><TD>' . $EnteredShiptRef->ShiptRef . '</TD><TD ALIGN=RIGHT>' .
				number_format($EnteredShiptRef->Amount,2) . '</TD></TR>';

		$TotalShiptValue = $TotalShiptValue + $EnteredShiptRef->Amount;

		$i++;
		if ($i>15){
			$i=0;
			echo "<TR><TD CLASS='tableheader'>" . _('Shipment') . "</TD><TD class='tableheader'>" .
				  _('Credit Amount') . '</TD></TR>';
		}
	}

	echo '<TR><TD COLSPAN=2 ALIGN=RIGHT><FONT SIZE=4 COLOR=red>' . _('Total Credited Against Shipments') .  ':</FONT></TD>
		<TD ALIGN=RIGHT><FONT SIZE=4 COLOR=red><U>' . number_format($TotalShiptValue,2) .  '</U></FONT></TD></TR>';
}

if ($_SESSION['SuppTrans']->GLLink_Creditors ==1){

	if (count($_SESSION['SuppTrans']->GLCodes)>0){
		echo '<TABLE CELLPADDING=2>';
		$TableHeader = "<TR><TD CLASS='tableheader'>" . _('Account') . "</TD>
					<TD CLASS='tableheader'>" . _('Name') . "</TD>
					<TD CLASS='tableheader'>" . _('Amount') . '<BR>' . _('in') . ' ' . $_SESSION['SuppTrans']->CurrCode . "</TD>
					<TD CLASS='tableheader'>" . _('Shipment') . "</TD>
					<TD CLASS='tableheader'>" . _('Job') . "</TD>
					<TD CLASS='tableheader'>" . _('Narrative') . '</TD></TR>';
		echo $TableHeader;

		$TotalGLValue=0;

		foreach ($_SESSION['SuppTrans']->GLCodes as $EnteredGLCode){

			echo '<TR><TD>' . $EnteredGLCode->GLCode . '</TD>
				<TD>' . $EnteredGLCode->GLActName . '</TD>
				<TD ALIGN=RIGHT>' . number_format($EnteredGLCode->Amount,2) . '</TD>
				<TD>' . $EnteredGLCode->ShiptRef . '</TD>
				<TD>' . $EnteredGLCode->JobRef . '</TD>
				<TD>' . $EnteredGLCode->Narrative . '</TD></TR>';

			$TotalGLValue = $TotalGLValue + $EnteredGLCode->Amount;

			$i++;
			if ($i>15){
				$i=0;
				echo $TableHeader;
			}
		}

		echo '<TR><TD COLSPAN=2 ALIGN=RIGHT><FONT SIZE=4 COLOR=red>' . _('Total') . ':</FONT></TD>
			<TD ALIGN=RIGHT><FONT SIZE=4 COLOR=red><U>' . number_format($TotalGLValue,2) . '</U></FONT></TD>
			</TR></TABLE>';
	}

	$_SESSION['SuppTrans']->OvAmount = round($TotalGRNValue + $TotalGLValue + $TotalShiptValue,2);
	echo '<TABLE><TR><TD><FONT COLOR=red>' . _("Credit Amount in Supplier Currency") . ':</FONT></TD>
			<TD ALIGN=RIGHT>' . number_format($_SESSION['SuppTrans']->OvAmount,2) . '</TD></TR>';
} else {
	echo '<TABLE><TR><TD><FONT COLOR=red>' . _("Credit Amount in Supplier Currency") .
		  ':</FONT></TD>
		  	<TD ALIGN=RIGHT><INPUT TYPE=TEXT SIZE=12 MAXLENGTH=10 NAME=OvAmount VALUE=' . number_format($_SESSION['SuppTrans']->OvAmount,2) . '></TD></TR>';
}

echo "<TR><TD><INPUT TYPE=Submit NAME='ToggleTaxMethod' VALUE='" . _('Change Tax Calculation Method') .
	  "'></TD><TD><SELECT NAME='OverRideTax'>";

if ($_POST['OverRideTax']=='Man'){
	echo "<OPTION VALUE='Auto'>" . _('Automatic') . "<OPTION SELECTED VALUE='Man'>" . _('Manual');
	if (!isset($_SESSION['SuppTrans']->OvGST) OR $_SESSION['SuppTrans']->OvGST==''){
		$_SESSION['SuppTrans']->OvGST=0;
	}

} else {
	echo "<OPTION SELECTED VALUE='Auto'>" . _('Automatic') . "<OPTION VALUE='Man'>" . _('Manual');
	$_SESSION['SuppTrans']->OvGST = $_SESSION['SuppTrans']->TaxRate * $_SESSION['SuppTrans']->OvAmount;
}

echo '</SELECT></TD></TR>';


if ($_POST['OverRideTax']=='Man'){
	$_SESSION['SuppTrans']->OvGST = $_POST['OvGST'];
	echo '<TR><TD><FONT COLOR=red>' . _('Tax') . ':</FONT></TD>
			<TD ALIGN=RIGHT><INPUT TYPE=TEXT SIZE=12 MAXLENGTH=12 NAME=OvGST VALUE=' .
			number_format($_SESSION['SuppTrans']->OvGST,2) . '></TD></TR>';
} else {
	echo '<TR><TD><FONT COLOR=red>' . _('Tax') . ':</FONT></TD><TD ALIGN=RIGHT>' .
		  number_format($_SESSION['SuppTrans']->OvGST,2) . '</TD></TR>';
}
$DisplayTotal = number_format(($_SESSION['SuppTrans']->OvAmount + $_SESSION['SuppTrans']->OvGST), 2);

echo '<TR><TD><FONT COLOR=red>' . _('Credit Note Total') . '</FONT></TD><TD ALIGN=RIGHT><B>' .
	  $DisplayTotal. '</B></TD></TR></TABLE>';

echo '<TABLE><TR><TD><FONT COLOR=red>' . _('Comments') . '</FONT></TD><TD><TEXTAREA NAME=Comments COLS=40 ROWS=2>' .
	  $_SESSION['SuppTrans']->Comments . '</TEXTAREA></TD></TR></TABLE>';

echo "<P><INPUT TYPE=SUBMIT NAME='PostCreditNote' VALUE='" . _('Enter Credit Note') . "'>";


if ($_POST['PostCreditNote'] == _('Enter Credit Note')){

/*First do input reasonableness checks
then do the updates and inserts to process the credit note entered */

	$InputError = False;
	If ($_SESSION['SuppTrans']->OvGST + $_SESSION['SuppTrans']->OvAmount <= 0){
		$InputError = True;
		prnMsg(_('The credit note as entered cannot be processed because the total amount of the credit note is less than or equal to 0') . '. ' . 	_('Credit notes are expected to entered as positive amounts to credit'),'warn');
	} elseif (strlen($_SESSION['SuppTrans']->SuppReference) < 1){
		$InputError = True;
		prnMsg(_('The credit note as entered cannot be processed because the there is no suppliers credit note number or reference entered') . '. ' . _('The supplier credit note number must be entered'),'error');
	} elseif (!is_date($_SESSION['SuppTrans']->TranDate)){
		$InputError = True;
		prnMsg(_('The credit note as entered cannot be processed because the date entered is not in the format') . ' ' . $_SESSION['DefaultDateFormat'], 'error');
	} elseif (DateDiff(Date($_SESSION['DefaultDateFormat']), $_SESSION['SuppTrans']->TranDate, "d") < 0){
		$InputError = True;
		prnMsg(_('The credit note as entered cannot be processed because the date is after today') . '. ' . _('Purchase credit notes are expected to have a date prior to or today'),'error');
	}elseif ($_SESSION['SuppTrans']->ExRate <= 0){
		$InputError = True;
		prnMsg(_('The credit note as entered cannot be processed because the exchange rate for the credit note has been entered as a negative or zero number') . '. ' . _('The exchange rate is expected to show how many of the suppliers currency there are in 1 of the local currency'),'warn');
	}elseif ($_SESSION['SuppTrans']->OvAmount < round($TotalShiptValue + $TotalGLValue + $TotalGRNValue,2)){
		prnMsg(_('The credit note total as entered is less than the sum of the shipment charges') . ', ' . _('the general ledger entires (if any) and the charges for goods received') . '. ' . _('There must be a mistake somewhere') . ', ' . _('the credit note as entered will not be processed'),'error');
		$InputError = True;
	} else {

	/* SQL to process the postings for purchase credit note */

	/*Start an SQL transaction */

		$SQL = 'BEGIN';

		$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The database does not support transactions');
		$DbgMsg = _('The following SQL to start an SQL transaction was used');

		$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg);

		/*Get the next transaction number for internal purposes and the period to post GL transactions in based on the credit note date*/

		$CreditNoteNo = GetNextTransNo(21, $db);
		$PeriodNo = GetPeriod($_SESSION['SuppTrans']->TranDate, $db);
		$SQLCreditNoteDate = FormatDateForSQL($_SESSION['SuppTrans']->TranDate);


		if ($_SESSION['SuppTrans']->GLLink_Creditors == 1){

		/*Loop through the GL Entries and create a debit posting for each of the accounts entered */

			$LocalTotal = 0;

			/*the postings here are a little tricky, the logic goes like this:

			> if its a shipment entry then the cost must go against the GRN suspense account defined in the company record

			> if its a general ledger amount it goes straight to the account specified

			> if its a GRN amount credited then there are two possibilities:

			1 The PO line is on a shipment.
			The whole charge goes to the GRN suspense account pending the closure of the
			shipment where the variance is calculated on the shipment as a whole and the clearing entry to the GRN suspense
			is created. Also, shipment records are created for the charges in local currency.

			2. The order line item is not on a shipment
			The whole amount of the credit is written off to the purchase price variance account applicable to the
			stock category record of the stock item being credited.
			Or if its not a stock item but a nominal item then the GL account in the orignal order is used for the
			price variance account.
			*/

			foreach ($_SESSION['SuppTrans']->GLCodes as $EnteredGLCode){

			/*GL Items are straight forward - just do the credit postings to the GL accounts specified -
			the debit is to creditors control act  done later for the total credit note value + tax*/

				$SQL = 'INSERT INTO gltrans (type,
								typeno,
								trandate,
								periodno,
								account,
								narrative,
								amount,
								jobref)
						 	VALUES (21,
								' . $CreditNoteNo . ",
								'" . $SQLCreditNoteDate . "',
								" . $PeriodNo . ',
								' . $EnteredGLCode->GLCode . ",
								'" . $_SESSION['SuppTrans']->SupplierID . " " . $EnteredGLCode->Narrative . "',
						 		" . round(-$EnteredGLCode->Amount/$_SESSION['SuppTrans']->ExRate,2) .
						 ", '" . $EnteredGLCode->JobRef . "'
						 		)";

				$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The general ledger transaction could not be added because');

				$DbgMsg = _('The following SQL to insert the GL transaction was used');

				$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, True);

				$LocalTotal += ($EnteredGLCode->Amount/$_SESSION['SuppTrans']->ExRate);

			}

			foreach ($_SESSION['SuppTrans']->Shipts as $ShiptChg){

			/*shipment postings are also straight forward - just do the credit postings to the GRN suspense account
			these entries are reversed from the GRN suspense when the shipment is closed - entries only to open shipts*/

				$SQL = 'INSERT INTO gltrans (type,
								typeno,
								trandate,
								periodo,
								account,
								narrative,
								amount)
							VALUES (21,
								' . $CreditNoteNo . ",
								'" . $SQLCreditNoteDate . "',
								" . $PeriodNo . ',
								' . $_SESSION['SuppTrans']->GRNAct . ",
								'" . $_SESSION['SuppTrans']->SupplierID . ' ' .	 _('Shipment credit against') . ' ' . $ShiptChg->ShiptRef . "',
								" . round(-$ShiptChg->Amount/$_SESSION['SuppTrans']->ExRate,2) . '
								)';

				$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The general ledger transaction for the shipment') . ' ' . $ShiptChg->ShiptRef . ' ' . _('could not be added because');
				$DbgMsg = _('The following SQL to insert the GL transaction was used');

				$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, True);

				$LocalTotal += round($ShiptChg->Amount/$_SESSION['SuppTrans']->ExRate,2);

			}

			foreach ($_SESSION['SuppTrans']->GRNs as $EnteredGRN){

				if (strlen($EnteredGRN->ShiptRef)==0 OR $EnteredGRN->ShiptRef=="" OR $EnteredGRN->ShiptRef==0){ /*so its not a shipment item */

					$PurchPriceVar = round($EnteredGRN->This_QuantityInv * ($EnteredGRN->ChgPrice  / $_SESSION['SuppTrans']->ExRate),2);

					/*Yes but where to post this difference to - if its a stock item the variance account must be retreived from the stock category record
					if its a nominal purchase order item with no stock item then  post it to the account specified in the purchase order detail record */

					if ($PurchPriceVar !=0){ /* don't bother with this lot if there is no value to post ! */
						if (strlen($EnteredGRN->ItemCode)>0 OR $EnteredGRN->ItemCode!=""){ /*so it is a stock item */

							/*need to get the stock category record for this stock item - this is function in SQL_CommonFunctions.inc */

							$StockGLCode = GetStockGLCode($EnteredGRN->ItemCode,$db);

							$SQL = 'INSERT INTO gltrans (type,
											typeno,
											trandate,
											periodno,
											account,
											narrative,
											amount)
									 VALUES (21,
									 	' . $CreditNoteNo . ",
										'" . $SQLCreditNoteDate . "',
										" . $PeriodNo . ',
										' . $StockGLCode['purchpricevaract'] . ",
										'" . $_SESSION['SuppTrans']->SupplierID . ' - ' . _('GRN Credit Note') . ' ' . $EnteredGRN->GRNNo . ' - ' . $EnteredGRN->ItemCode . ' x ' .  $EnteredGRN->This_QuantityInv . ' x  ' . number_format(($EnteredGRN->ChgPrice  / $_SESSION['SuppTrans']->ExRate),2)  . "',
										" . (-$PurchPriceVar) . ')';

							$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The general ledger transaction could not be added for the price variance of the stock item because');
							$DbgMsg = _('The following SQL to insert the GL transaction was used');
							$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, True);

						} else {

						/* its a nominal purchase order item that is not on a shipment so post the whole lot to the GLCode specified in the order, the purchase price var is actually the diff between the
						order price and the actual credit note price since the std cost was made equal to the order price in local currency at the time
						the goods were received */

							$SQL = 'INSERT INTO gltrans (type,
											typeno,
											trandate,
											periodno,
											account,
											narrative,
											amount)
									VALUES (21,
										' . $CreditNoteNo . ",
										'" . $SQLCreditNoteDate . "',
										" . $PeriodNo . ',
										' . $EnteredGRN->GLCode . ",
										'" . $_SESSION['SuppTrans']->SupplierID . ' - ' .
									_('GRN Credit Note') . ' ' . $EnteredGRN->GRNNo . " - " . $EnteredGRN->ItemDescription . ' x ' . $EnteredGRN->This_QuantityInv . ' x ' . _('price var') . ' ' . number_format(($EnteredGRN->ChgPrice  / $_SESSION['SuppTrans']->ExRate),2) . "',
									" . (-$PurchPriceVar) . ')';

							$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The general ledger transaction could not be added for the price variance of the stock item because');
							$DbgMsg = _('The following SQL to insert the GL transaction was used');
							$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, True);

						}

					}

				} else {

					/*then its a purchase order item on a shipment - whole charge amount to GRN suspense pending closure of the shipment	when the variance is calculated and the GRN act cleared up for the shipment */

					$SQL = 'INSERT INTO gltrans (type,
									typeNo,
									trandate,
									periodno,
									account,
									narrative,
									amount)
							 VALUES (21,
							 	' . $CreditNoteNo . ",
								'" . $SQLCreditNoteDate . "',
								" . $PeriodNo . ',
								' . $_SESSION['SuppTrans']->GRNAct . ",
								'" . $_SESSION['SuppTrans']->SupplierID . ' - ' . _('GRN') .' ' . $EnteredGRN->GRNNo . ' - ' . $EnteredGRN->ItemCode . ' x ' . $EnteredGRN->This_QuantityInv . ' @ ' . $_SESSION['SuppTrans']->CurrCode . $EnteredGRN->ChgPrice . ' @ ' . _('a rate of') . ' ' . $_SESSION['SuppTrans']->ExRate . "',
								" . round(-$EnteredGRN->ChgPrice * $EnteredGRN->This_QuantityInv,2) / $_SESSION['SuppTrans']->ExRate . '
								)';

					$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The general ledger transaction could not be added because');
					$DbgMsg = _('The following SQL to insert the GL transaction was used');
					$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, True);
				}

				$LocalTotal += round(($EnteredGRN->ChgPrice * $EnteredGRN->This_QuantityInv) / $_SESSION['SuppTrans']->ExRate,2);

			} /* end of GRN postings */

			if ($debug == 1 AND abs(($_SESSION['SuppTrans']->OvAmount/ $_SESSION['SuppTrans']->ExRate) - $LocalTotal)>0.004){

				prnMsg(_('The total posted to the credit accounts is') . ' ' . $LocalTotal . ' ' . _('but the sum of OvAmount converted at ExRate') . " = " . ($_SESSION['SuppTrans']->OvAmount / $_SESSION['SuppTrans']->ExRate),'error');
			}

			if ($_SESSION['SuppTrans']->OvGST != 0){

				/* Now the TAX account */
				$SQL = 'INSERT INTO gltrans (type,
								typeno,
								trandate,
								periodno,
								account,
								narrative,
								amount)
						 VALUES (21,
						 	' . $CreditNoteNo . ",
							'" . $SQLCreditNoteDate . "',
							" . $PeriodNo . ',
							' . $_SESSION['SuppTrans']->TaxGLCode . ",
							'" . $_SESSION['SuppTrans']->SupplierID . ' - ' . _('Credit Note') . ' ' . $_SESSION['SuppTrans']->SuppReference . ' ' . $_SESSION['SuppTrans']->CurrCode . $_SESSION['SuppTrans']->OvGST  . ' @ ' . _('a rate of') . ' ' . $_SESSION['SuppTrans']->ExRate . "',
							" . round(-$_SESSION['SuppTrans']->OvGST/ $_SESSION['SuppTrans']->ExRate,2) . '
							)';

				$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The general ledger transaction for the tax on the suppliers credit note could not be added because');
				$DbgMsg = _('The following SQL to insert the GL transaction was used');
				$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, True);
			}

			/* Now the control account */

			$SQL = 'INSERT INTO gltrans (type,
							typeno,
							trandate,
							periodno,
							account,
							narrative,
							amount)
					 VALUES (21,
					 	' . $CreditNoteNo . ",
						'" . $SQLCreditNoteDate . "',
						" . $PeriodNo . ',
						' . $_SESSION['SuppTrans']->CreditorsAct . ",
						'" . $_SESSION['SuppTrans']->SupplierID . ' - ' . _('Credit Note') . ' ' . $_SESSION['SuppTrans']->SuppReference . ' ' .  $_SESSION['SuppTrans']->CurrCode . number_format($_SESSION['SuppTrans']->OvAmount + $_SESSION['SuppTrans']->OvGST,2)  . ' @ ' . _('a rate of') . ' ' . $_SESSION['SuppTrans']->ExRate .  "',
						" . round($LocalTotal + ($_SESSION['SuppTrans']->OvGST / $_SESSION['SuppTrans']->ExRate),2) . ')';

			$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The general ledger transaction for the control total could not be added because');
			$DbgMsg = _('The following SQL to insert the GL transaction was used');
			$Result = DB_query($SQL, $db, $ErrMSg, $DbgMsg, True);

		} /*Thats the end of the GL postings */

	/*Now insert the credit note into the SuppTrans table*/

		$SQL = 'INSERT INTO supptrans (transno,
						type,
						supplierno,
						suppreference,
						trandate,
						duedate,
						ovamount,
						ovgst,
						rate,
						transtext)
			VALUES ('. $CreditNoteNo . ",
				21,
				'" . $_SESSION['SuppTrans']->SupplierID . "',
				'" . $_SESSION['SuppTrans']->SuppReference . "',
				'" . $SQLCreditNoteDate . "',
				'" . FormatDateForSQL($_SESSION['SuppTrans']->DueDate) . "',
				" . round(-$_SESSION['SuppTrans']->OvAmount,2) . ',
				' .(-$_SESSION['SuppTrans']->OvGST) . ',
				' . $_SESSION['SuppTrans']->ExRate . ",
				'" . $_SESSION['SuppTrans']->Comments . "')";

		$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The supplier credit note transaction could not be added to the database because');
		$DbgMsg = _('The following SQL to insert the supplier credit note was used');
		$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, True);

		/* Now update the GRN and PurchOrderDetails records for amounts credited */

		foreach ($_SESSION['SuppTrans']->GRNs as $EnteredGRN){

			$SQL = 'UPDATE purchorderdetails SET qtyinvoiced = qtyinvoiced - ' .
					 $EnteredGRN->This_QuantityInv . ' WHERE podetailitem = ' . $EnteredGRN->PODetailItem;

			$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The quantity credited of the purchase order line could not be updated because');
			$DbgMsg = _('The following SQL to update the purchase order details was used');
			$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, True);

			$SQL = 'UPDATE grns SET quantityinv = quantityinv - ' .
					 $EnteredGRN->This_QuantityInv . ' WHERE grnno = ' . $EnteredGRN->GRNNo;

			$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The quantity credited off the goods received record could not be updated because');
			$DbgMsg = _('The following SQL to update the GRN quantity credited was used');
			$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, True);

			/*Update the shipment's accum value for the total local cost of shipment items being credited
			the total value credited against shipments is apportioned between all the items on the shipment
			later when the shipment is closed*/

			if (strlen($EnteredGRN->ShiptRef)>0 AND $EnteredGRN->ShiptRef!=0){

				/* and insert the shipment charge records */
				$SQL = 'INSERT INTO shipmentcharges (shiptref,
									transtype,
									transno,
									stockid,
									value)
							VALUES (' . $EnteredGRN->ShiptRef . ',
								21,
								' . $CreditNoteNo . ",
								'" . $EnteredGRN->ItemCode . "',
								" . round(-$EnteredGRN->This_QuantityInv * $EnteredGRN->ChgPrice / $_SESSION['SuppTrans']->ExRate,2) . '
								)';

				$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The shipment charge record for the shipment') . ' ' . $EnteredGRN->ShiptRef . ' ' . _('could not be added because');
				$DbgMsg = _('The following SQL to insert the Shipment charge record was used');

				$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, True);
			}

		} /* end of the loop to do the updates for the quantity of order items the supplier has credited */

		/*Add shipment charges records as necessary */

		foreach ($_SESSION['SuppTrans']->Shipts as $ShiptChg){

			$SQL = 'INSERT INTO shipmentcharges (shiptref,
								transtype,
								transno,
								value)
							VALUES (' . $ShiptChg->ShiptRef . ',
								21,
								' . $CreditNoteNo . ',
								' . (-$ShiptChg->Amount/$_SESSION['SuppTrans']->ExRate) . '
								)';

			$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The shipment charge record for the shipment') . ' ' . $ShiptChg->ShiptRef . ' ' . _('could not be added because');
			$DbgMsg = _('The following SQL to insert the Shipment charge record was used');
			$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, True);
		}

		$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The COMMIT SQL command failed');
		$DbgMsg = _('The COMMIT SQL failed');

		$SQL='COMMIT';
		$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg);

		unset($_SESSION['SuppTrans']->GRNs);
		unset($_SESSION['SuppTrans']->Shipts);
		unset($_SESSION['SuppTrans']->GLCodes);
		unset($_SESSION['SuppTrans']);

		prnMsg(_('Supplier credit note number') . ' ' . $CreditNoteNo . ' ' . _('has been processed'),'success');

		echo "<P><A HREF='$rootpath/SelectSupplier.php'>" . _('Enter Another Credit Note') . '</A>';
	}

} /*end of process credit note */

echo '</FORM>';
include('includes/footer.inc');
?>