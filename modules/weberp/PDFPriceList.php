<?php
/* $Revision: 1.7 $ */

$PageSecurity = 2;

If (isset($_POST['PrintPDF'])
	AND isset($_POST['FromCriteria'])
	AND strlen($_POST['FromCriteria'])>=1
	AND isset($_POST['ToCriteria'])
		 AND strlen($_POST['ToCriteria'])>=1){

	include('config.php');
	include('includes/ConnectDB.inc');
	include('includes/PDFStarter_ros.inc');

	$FontSize=10;
	$pdf->addinfo('Title', _('Price Listing Report') );
	$pdf->addinfo('Subject', _('Price List') );

	$PageNumber=1;
	$line_height=12;

      /*Now figure out the inventory data to report for the category range under review */
	if ($_POST['CustomerSpecials']==_('Customer Special Prices Only')){

		if ($_SESSION['CustomerID']==''){
			include('includes/header.inc');
			echo '<BR>';
			prnMsg( _('The customer must first be selected from the select customer link') . '. ' . _('Re-run the price list once the customer has been selected') );
			include('includes/footer.inc');
			exit;
		}

		$SQL = "SELECT debtorsmaster.name, 
				debtorsmaster.salestype 
			FROM debtorsmaster 
			WHERE debtorno = '" . $_SESSION['CustomerID'] . "'";
		$CustNameResult = DB_query($SQL,$db);
		$CustNameRow = DB_fetch_row($CustNameResult);
		$CustomerName = $CustNameRow[0];
		$SalesType = $CustNameRow[1];

		$SQL = "SELECT prices.typeabbrev,
			prices.stockid,
			stockmaster.description,
			prices.currabrev,
			prices.price,
			stockmaster.materialcost+stockmaster.labourcost+stockmaster.overheadcost AS standardcost,
			stockmaster.categoryid,
			stockcategory.categorydescription,
			prices.debtorno,
			prices.branchcode,
			custbranch.brname
			FROM stockmaster, 
				stockcategory, 
				prices LEFT JOIN custbranch
			ON prices.debtorno=custbranch.debtorno
			AND prices.branchcode=custbranch.branchcode
			WHERE stockmaster.stockid=prices.stockid
			AND stockmaster.categoryid=stockcategory.categoryid
			AND prices.typeabbrev = '" . $SalesType . "'
			AND stockmaster.categoryid >= '" . $_POST['FromCriteria'] . "'
			AND stockmaster.categoryid <= '" . $_POST['ToCriteria'] . "'
			AND prices.debtorno='" . $_SESSION['CustomerID'] . "'
			ORDER BY prices.currabrev,
				stockmaster.categoryid,
				stockmaster.stockid";

	} else { /* the sales type list only */


		$SQL = "SELECT sales_type FROM salestypes WHERE typeabbrev='" . $_POST['SalesType'] . "'";
		$SalesTypeResult = DB_query($SQL,$db);
		$SalesTypeRow = DB_fetch_row($SalesTypeResult);
		$SalesTypeName = $SalesTypeRow[0];

		$SQL = "SELECT prices.typeabbrev,
				prices.stockid,
				stockmaster.description,
				prices.currabrev,
				prices.price,
				stockmaster.materialcost+stockmaster.labourcost+stockmaster.overheadcost as standardcost,
				stockmaster.categoryid,
				stockcategory.categorydescription
			FROM prices,
				stockmaster,
				stockcategory
			WHERE stockmaster.stockid=prices.stockid
			AND stockmaster.categoryid=stockcategory.categoryid
			AND stockmaster.categoryid >= '" . $_POST['FromCriteria'] . "'
			AND stockmaster.categoryid <= '" . $_POST['ToCriteria'] . "'
			AND prices.typeabbrev='" . $_POST['SalesType'] . "'
			AND prices.debtorno=''
			ORDER BY prices.currabrev,
				stockmaster.categoryid,
				stockmaster.stockid";
	}
	$PricesResult = DB_query($SQL,$db,'','',false,false);

	if (DB_error_no($db) !=0) {
		$title = _('Price List') . ' - ' . _('Problem Report....');
		include('includes/header.inc');
		prnMsg( _('The Price List could not be retrieved by the SQL because'). ' - ' . DB_error_msg($db), 'error');
		echo '<BR><A HREF="' .$rootpath .'/index.php?' . SID . '">'.  _('Back to the menu'). '</A>';
		if ($debug==1){
			echo '<BR>'. $SQL;
		}
		include('includes/footer.inc');
		exit;
	}

	include('includes/PDFPriceListPageHeader.inc');
	$CurrCode ='';
	$Category = '';
	$CatTot_Val=0;
	While ($PriceList = DB_fetch_array($PricesResult,$db)){

		if ($CurrCode != $PriceList['currabrev']){
			$FontSize=10;
			$YPos -=(2*$line_height);
			$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,300-$Left_Margin,$FontSize, $PriceList['currabrev'] . ' ' . _('Prices'));
			$CurrCode = $PriceList['currabrev'];
			$FontSize = 8;
			$YPos -= $line_height;
		}

		if ($Category!=$PriceList['categoryid']){
			$FontSize=10;
			$YPos -=(2*$line_height);
			$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,300-$Left_Margin,$FontSize,$PriceList['categoryid'] . ' - ' . $PriceList['categorydescription']);
			$Category = $PriceList['categoryid'];
			$CategoryName = $PriceList['categorydescription'];
			$FontSize=8;
			$YPos -=$line_height;
		}

		$YPos -=$line_height;


		$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,60,$FontSize,$PriceList['stockid']);					$LeftOvers = $pdf->addTextWrap(120,$YPos,260,$FontSize,$PriceList['description']);

		if ($_POST['CustomerSpecials']=='Customer Special Prices Only'){
			/*Need to show to which branch the price relates */
			if ($PriceList['branchcode']!=''){
				$LeftOvers = $pdf->addTextWrap(320,$YPos,130,$FontSize,$PriceList['brname'],'left');
			} else {
				$LeftOvers = $pdf->addTextWrap(320,$YPos,130,$FontSize,_('All'),'left');
			}

		}

		$DisplayUnitPrice = number_format($PriceList['price'],2);

		if ($PriceList['price']!=0){
			$DisplayGPPercent = (int)(($PriceList['price']-$PriceList['standardcost'])*100/$PriceList['price']) . '%';
		} else {
			$DisplayGPPercent = 0;
		}


		$LeftOvers = $pdf->addTextWrap(440,$YPos,60,$FontSize,$DisplayUnitPrice, 'right');

		if ($_POST['ShowGPPercentages']=='Yes'){
			$LeftOvers = $pdf->addTextWrap(530,$YPos,20,$FontSize,$DisplayGPPercent, 'right');
		}

		if ($YPos < $Bottom_Margin + $line_height){
		   include('includes/PDFPriceListPageHeader.inc');
		}

	} /*end inventory valn while loop */

	$FontSize =10;
/*Print out the category totals */

	$pdfcode = $pdf->output();
	$len = strlen($pdfcode);

      if ($len<=20){
		$title = _('Print Price List Error');
		include('includes/header.inc');
		prnMsg(_('There were no price details to print out for the customer or category specified'),'warn');
		echo '<BR><A HREF="'.$rootpath.'/index.php?' . SID . '">'. _('Back to the menu').'</A>';
		include('includes/footer.inc');
		exit;
      } else {
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=PriceList.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');

		$pdf->Stream();
	}
} else { /*The option to print PDF was not hit */

	include('includes/session.inc');
	$title= _('Price Listing');
	include('includes/header.inc');
	
	if (strlen($_POST['FromCriteria'])<1 || strlen($_POST['ToCriteria'])<1) {

	/*if $FromCriteria is not set then show a form to allow input	*/

		echo '<FORM ACTION=' . $_SERVER['PHP_SELF'] . ' METHOD="POST"><CENTER><TABLE>';

		echo '<TR><TD>'. _('From Inventory Category Code') .':</FONT></TD><TD><SELECT name=FromCriteria>';

		$sql='SELECT categoryid, categorydescription FROM stockcategory ORDER BY categoryid';
		$CatResult= DB_query($sql,$db);
		While ($myrow = DB_fetch_array($CatResult)){
			echo "<OPTION VALUE='" . $myrow['categoryid'] . "'>" . $myrow['categoryid'] . ' - ' . $myrow['categorydescription'];
		}
		echo '</SELECT></TD></TR>';

		echo '<TR><TD>' . _('To Inventory Category Code'). ':</TD><TD><SELECT name=ToCriteria>';

		/*Set the index for the categories result set back to 0 */
		DB_data_seek($CatResult,0);

		While ($myrow = DB_fetch_array($CatResult)){
			echo '<OPTION VALUE="' . $myrow['categoryid'] . '">' . $myrow['categoryid'] . ' - ' . $myrow['categorydescription'];
		}
		echo '</SELECT></TD></TR>';

		echo '<TR><TD>' . _('For Sales Type/Price List').':</TD><TD><SELECT name="SalesType">';
		$sql = 'SELECT sales_type, typeabbrev FROM salestypes';
		$SalesTypesResult=DB_query($sql,$db);

		while ($myrow=DB_fetch_array($SalesTypesResult)){
		          echo '<OPTION Value="' . $myrow['typeabbrev'] . '">' . $myrow['sales_type'];
		}
		echo '</SELECT></TD></TR>';

		echo '<TR><TD>' . _('Show Gross Profit %') . ':</TD><TD><SELECT name="ShowGPPercentages">';
		echo '<OPTION SELECTED Value="No">'. _('Prices Only');
		echo '<OPTION Value="Yes">'. _('Show GP % too');
		echo '</SELECT></TD></TR>';

		echo '<TR><TD>' . _('Price Listing Type'). ':</TD><TD><SELECT name="CustomerSpecials">';
		echo '<OPTION  Value="Customer Special Prices Only">'. _('Customer Special Prices Only');
		echo '<OPTION SELECTED Value="Sales Type Prices">'. _('Default Sales Type Prices');
		echo '</SELECT></TD></TR>';

		echo '</TABLE><INPUT TYPE=Submit Name="PrintPDF" Value="'. _('Print PDF'). '"></CENTER>';
	}
	include('includes/footer.inc');

} /*end of else not PrintPDF */
?>