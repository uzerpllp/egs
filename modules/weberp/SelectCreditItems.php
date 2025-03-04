<?php
/* $Revision: 1.14 $ */
/*The credit selection screen uses the Cart class used for the making up orders
some of the variable names refer to order - please think credit when you read order */

$PageSecurity = 3;

include('includes/DefineCartClass.php');
include('includes/DefineSerialItems.php');
/* Session started in session.inc for password checking and authorisation level check */
include('includes/session.inc');

$title = _('Create Credit Note');

include('includes/header.inc');
include('includes/SQL_CommonFunctions.inc');
include('includes/GetSalesTransGLCodes.inc');
include('includes/GetPrice.inc');


if (isset($_POST['ProcessCredit']) AND !isset($_SESSION['CreditItems'])){
	echo '<BR>' . _('This credit note has already been processed') . '. ' . _('Refreshing the page will not enter the credit note again') . '. ' . _('Please use the navigation links provided rather than using the browser back button and then having to refresh');
	echo '<BR><A HREF="' . $rootpath . '/index.php?' . SID . '">' . _('Back to the menu') . '</A>';
	include('includes/footer.inc');
  exit;
}

if (isset($_GET['NewCredit'])){
/*New credit note entry - clear any existing credit note details from the Items object and initiate a newy*/
	if (isset($_SESSION['CreditItems'])){
		unset ($_SESSION['CreditItems']->LineItems);
		unset ($_SESSION['CreditItems']);
	}
}


if (!isset($_SESSION['CreditItems'])){
	 /* It must be a new credit note being created $_SESSION['CreditItems'] would be set up from a previous call*/

	 Session_register('CreditItems');
	 Session_register('RequireCustomerSelection');
	 Session_register('TaxDescription');
	 Session_Register('CurrencyRate');
	 Session_Register('TaxGLCode');
	 $_SESSION['CreditItems'] = new cart;

	 $_SESSION['RequireCustomerSelection'] = 1;
}

if (isset($_POST['ChangeCustomer'])){
	 $_SESSION['RequireCustomerSelection']=1;
}

if (isset($_POST['Quick'])){
	  unset($_POST['PartSearch']);
}

if (isset($_POST['CancelCredit'])) {
	 unset($_SESSION['CreditItems']->LineItems);
	 unset($_SESSION['CreditItems']);
	 $_SESSION['CreditItems'] = new cart;
	 $_SESSION['RequireCustomerSelection'] = 1;
}


if (isset($_POST['SearchCust']) AND $_SESSION['RequireCustomerSelection']==1){

	 If ($_POST['Keywords'] AND $_POST['CustCode']) {
		  $msg=_('Customer name keywords have been used in preference to the customer code extract entered');
	 }
	 If ($_POST['Keywords']=='' AND $_POST['CustCode']=='') {
		  $msg=_('At least one Customer Name keyword OR an extract of a Customer Code must be entered for the search');
	 } else {
		  If (strlen($_POST['Keywords'])>0) {
		  //insert wildcard characters in spaces

			   $i=0;
			   $SearchString = '%';
			   while (strpos($_POST['Keywords'], ' ', $i)) {
				    $wrdlen=strpos($_POST['Keywords'],' ',$i) - $i;
				    $SearchString=$SearchString . substr($_POST['Keywords'],$i,$wrdlen) . '%';
				    $i=strpos($_POST['Keywords'],' ',$i) +1;
			   }
			   $SearchString = $SearchString. substr($_POST['Keywords'],$i).'%';


			   $SQL = 'SELECT
			   		custbranch.debtorno,
					custbranch.brname,
					custbranch.contactname,
					custbranch.phoneno,
					custbranch.faxno,
					custbranch.branchcode
				FROM custbranch
				WHERE custbranch.brname ' . LIKE  ."'$SearchString'
				AND custbranch.disabletrans=0";

		  } elseif (strlen($_POST['CustCode'])>0){
			   $SQL = 'SELECT
			   		custbranch.debtorno,
					custbranch.brname,
					custbranch.contactname,
					custbranch.phoneno,
					custbranch.faxno,
					custbranch.branchcode
				FROM custbranch
				WHERE custbranch.branchcode ' . LIKE  . "'%" . $_POST['CustCode'] . "%'
				AND custbranch.disabletrans=0";
		  }

		  $ErrMsg = _('Customer branch records requested cannot be retrieved because');
		  $DbgMsg = _('SQL used to retrieve the customer details was');
		  $result_CustSelect = DB_query($SQL,$db,$ErrMsg,$DbgMsg);


		  if (DB_num_rows($result_CustSelect)==1){
			    $myrow=DB_fetch_array($result_CustSelect);
			    $_POST['Select'] = $myrow['debtorno'] . ' - ' . $myrow['branchcode'];
		  } elseif (DB_num_rows($result_CustSelect)==0){
			    prnMsg(_('Sorry') . ' ... ' . _('there are no customer branch records contain the selected text') . ' - ' . _('please alter your search criteria and try again'),'info');
		  }

	 } /*one of keywords or custcode was more than a zero length string */
} /*end of if search button for customers was hit*/


if (isset($_POST['Select'])) {

/*will only be true if page called from customer selection form
parse the $Select string into customer code and branch code */

	 $_SESSION['CreditItems']->Branch = substr($_POST['Select'],strpos($_POST['Select'],' - ')+3);
	 $_POST['Select'] = substr($_POST['Select'],0,strpos($_POST['Select'],' - '));

/*Now retrieve customer information - name, salestype, currency, terms etc */

	 $sql = "SELECT
	 	debtorsmaster.name,
		debtorsmaster.salestype,
		debtorsmaster.currcode,
		currencies.rate
		FROM debtorsmaster,
			currencies
		WHERE debtorsmaster.currcode=currencies.currabrev
		AND debtorsmaster.debtorno = '" . $_POST['Select'] . "'";

	$ErrMsg = _('The customer record of the customer selected') . ': ' . $_POST['Select'] . ' ' . _('cannot be retrieved because');
	$DbgMsg = _('The SQL used to retrieve the customer details and failed was');
	$result =DB_query($sql,$db,$ErrMsg,$DbgMsg);

	 $myrow = DB_fetch_row($result);

	 $_SESSION['CreditItems']->DebtorNo = $_POST['Select'];
	 $_SESSION['RequireCustomerSelection'] = 0;
	 $_SESSION['CreditItems']->CustomerName = $myrow[0];

/* the sales type determines the price list to be used by default the customer of the user is
defaulted from the entry of the userid and password.  */

	 $_SESSION['CreditItems']->DefaultSalesType = $myrow[1];
	 $_SESSION['CreditItems']->DefaultCurrency = $myrow[2];
	 $_SESSION['CurrencyRate'] = $myrow[3];

/*  default the branch information from the customer branches table CustBranch -particularly where the stock
will be booked back into. */

	 $sql = "SELECT
	 		custbranch.brname,
			custbranch.braddress1,
			custbranch.braddress2,
			custbranch.braddress3,
			custbranch.braddress4,
			custbranch.phoneno,
			custbranch.email,
			custbranch.defaultlocation,
			taxauthorities.description AS taxdescription,
			taxauthorities.taxid,
			taxauthorities.taxglcode,
			locations.taxauthority AS dispatchtaxauthority
			FROM custbranch
			INNER JOIN taxauthorities ON custbranch.taxauthority=taxauthorities.taxid
			INNER JOIN locations ON locations.loccode=custbranch.defaultlocation
			WHERE custbranch.branchcode='" . $_SESSION['CreditItems']->Branch . "'
			AND custbranch.debtorno = '" . $_SESSION['CreditItems']->DebtorNo . "'";

	 $ErrMsg = _('The customer branch record of the customer selected') . ': ' . $_POST['Select'] . ' ' . _('cannot be retrieved because');
	 $DbgMsg =  _('SQL used to retrieve the branch details was');
	 $result =DB_query($sql,$db,$ErrMsg,$DbgMsg);

	 $myrow = DB_fetch_row($result);
	 $_SESSION['CreditItems']->DeliverTo = $myrow[0];
	 $_SESSION['CreditItems']->BrAdd1 = $myrow[1];
	 $_SESSION['CreditItems']->BrAdd2 = $myrow[2];
	 $_SESSION['CreditItems']->BrAdd3 = $myrow[3];
	 $_SESSION['CreditItems']->BrAdd4 = $myrow[4];
	 $_SESSION['CreditItems']->PhoneNo = $myrow[5];
	 $_SESSION['CreditItems']->Email = $myrow[6];
	 $_SESSION['CreditItems']->Location = $myrow[7];
	 $_SESSION['TaxDescription'] = $myrow[8];
	 $_SESSION['TaxAuthority'] = $myrow[9];
	 $_SESSION['TaxGLCode'] = $myrow[10];
	 $_SESSION['DispatchTaxAuthority'] = $myrow[11];
	 $_SESSION['FreightTaxRate'] = GetTaxRate($_SESSION['TaxAuthority'],
	 					 $_SESSION['DispatchTaxAuthority'],
						  $_SESSION['DefaultTaxLevel'],
						  $db
						)*100;
}



/* if the change customer button hit or the customer has not already been selected */
if ($_SESSION['RequireCustomerSelection'] ==1
	OR !isset($_SESSION['CreditItems']->DebtorNo)
	OR $_SESSION['CreditItems']->DebtorNo=='' ) {

	echo '<FONT SIZE=3><B> - ' . _('Customer Selection') . '</B></FONT><BR>';
	echo '<FORM ACTION="' . $_SERVER['PHP_SELF'] . '?' . SID . '" METHOD=POST>';
	echo '<B><BR>' . $msg . '</B>';
	echo '<TABLE CELLPADDING=3 COLSPAN=4>';
	echo '<TR>';
	echo '<TD><FONT SIZE=1>' . _('Enter text in the customer name') . ':</FONT></TD>';
	echo '<TD><INPUT TYPE="Text" NAME="Keywords" SIZE=20	MAXLENGTH=25></TD>';
	echo '<TD><FONT SIZE=3><B>' . _('OR') . '</B></FONT></TD>';
	echo '<TD><FONT SIZE=1>' . _('Enter text extract in the customer code') . ':</FONT></TD>';
	echo '<TD><INPUT TYPE="Text" NAME="CustCode" SIZE=15	MAXLENGTH=18></TD>';
	echo '</TR>';
	echo '</TABLE>';
	echo '<CENTER><INPUT TYPE=SUBMIT NAME="SearchCust" VALUE="' . _('Search Now') . '"></CENTER>';

	if ($result_CustSelect) {

		  echo '<TABLE CELLPADDING=2 COLSPAN=7 BORDER=1>';

		  $TableHeader = '<TR>
		  	<TD class="tableheader">' . _('Code') . '</TD>
				<TD class="tableheader">' . _('Branch') . '</TD>
				<TD class="tableheader">' . _('Contact') . '</TD>
				<TD class="tableheader">' . _('Phone') . '</TD>
				<TD class="tableheader">' . _('Fax') . '</TD>
				</TR>';

		  echo $TableHeader;

		  $j = 1;
		  $k = 0; //row counter to determine background colour

		  while ($myrow=DB_fetch_array($result_CustSelect)) {

			   if ($k==1){
				    echo '<tr bgcolor="#CCCCCC">';
				    $k=0;
			   } else {
				    echo '<tr bgcolor="#EEEEEE">';
				    $k=1;
			   }

			   printf("<td><FONT SIZE=1><INPUT TYPE=SUBMIT NAME='Select' VALUE='%s - %s'</FONT></td>
			   	<td><FONT SIZE=1>%s</FONT></td>
				<td><FONT SIZE=1>%s</FONT></td>
				<td><FONT SIZE=1>%s</FONT></td>
				<td><FONT SIZE=1>%s</FONT></td>
				</tr>",
				$myrow['debtorno'],
				$myrow['branchcode'],
				$myrow['brname'],
				$myrow['contactname'],
				$myrow['phoneno'],
				$myrow['faxno']);

			   $j++;
			   If ($j == 11){
				$j=1;
				echo $TableHeader;
			   }
//end of page full new headings if
		  }
//end of while loop

		  echo '</TABLE>';

	 }
//end if results to show

//end if RequireCustomerSelection
} else {
/* everything below here only do if a customer is selected
   fisrt add a header to show who we are making a credit note for */

	 echo '<FONT SIZE=4><B><U>' . $_SESSION['CreditItems']->CustomerName  . ' - ' . $_SESSION['CreditItems']->DeliverTo . '</U></B></FONT></CENTER><BR>';

 /* do the search for parts that might be being looked up to add to the credit note */
	 If (isset($_POST['Search'])){

		  If ($_POST['Keywords']!='' AND $_POST['StockCode']!='') {
			   $msg=_('Stock description keywords have been used in preference to the Stock code extract entered') . '.';
		  }

		If ($_POST['Keywords']!="") {
			//insert wildcard characters in spaces

			$i=0;
			$SearchString = '%';
			while (strpos($_POST['Keywords'], ' ', $i)) {
				$wrdlen=strpos($_POST['Keywords'],' ',$i) - $i;
				$SearchString=$SearchString . substr($_POST['Keywords'],$i,$wrdlen) . '%';
				$i=strpos($_POST['Keywords'],' ',$i) +1;
			}
			$SearchString = $SearchString. substr($_POST['Keywords'],$i).'%';

			if ($_POST['StockCat']=='All'){
				$SQL = "SELECT stockmaster.stockid,
						stockmaster.description,
						stockmaster.units
					FROM stockmaster, stockcategory
					WHERE stockmaster.categoryid=stockcategory.categoryid
					AND (stockcategory.stocktype='F' OR stockcategory.stocktype='D')
					AND stockmaster.description " . LIKE . "'$SearchString'
					GROUP BY stockmaster.stockid, 
						stockmaster.description, 
						stockmaster.units
					ORDER BY stockmaster.stockid";
			} else {
				$SQL = "SELECT stockmaster.stockid,
						stockmaster.description,
						stockmaster.units
					FROM stockmaster, 
						stockcategory
					WHERE stockmaster.categoryid=stockcategory.categoryid
					AND (stockcategory.stocktype='F' OR stockcategory.stocktype='D')
					AND stockmaster.description " . LIKE . "'$SearchString'
					AND stockmaster.categoryid='" . $_POST['StockCat'] . "'
					GROUP BY stockmaster.stockid, 
						stockmaster.description, 
						stockmaster.units
					ORDER BY stockmaster.stockid";
			}

		} elseif ($_POST['StockCode']!=''){
			$_POST['StockCode'] = '%' . $_POST['StockCode'] . '%';
			if ($_POST['StockCat']=='All'){
				$SQL = "SELECT stockmaster.stockid,
						stockmaster.description,
						stockmaster.units
					FROM stockmaster, 
						stockcategory
					WHERE stockmaster.categoryid=stockcategory.categoryid
					AND (stockcategory.stocktype='F' OR stockcategory.stocktype='D')
					AND  stockmaster.stockid " . LIKE . " '" . $_POST['StockCode'] . "'
					GROUP BY stockmaster.stockid, 
						stockmaster.description, 
						stockmaster.units
					ORDER BY stockmaster.stockid";
			} else {
				$SQL = "SELECT stockmaster.stockid,
						stockmaster.description,
						stockmaster.units
						FROM stockmaster, 
							stockcategory
						WHERE stockmaster.categoryid=stockcategory.categoryid
						AND (stockcategory.stocktype='F' OR stockcategory.stocktype='D')
						AND stockmaster.stockid " . LIKE . " '" . $_POST['StockCode'] . "' AND stockmaster.categoryid='" . $_POST['StockCat'] . "'
						GROUP BY stockmaster.stockid, 
							stockmaster.description, 
							stockmaster.units
						ORDER BY stockmaster.stockid";
			}
		} else {
			if ($_POST['StockCat']=='All'){
				$SQL = "SELECT stockmaster.stockid,
						stockmaster.description,
						stockmaster.units
					FROM stockmaster, stockcategory
					WHERE stockmaster.categoryid=stockcategory.categoryid
					AND (stockcategory.stocktype='F' OR stockcategory.stocktype='D')
					GROUP BY stockmaster.stockid, 
						stockmaster.description, 
						stockmaster.units
					ORDER BY stockmaster.stockid";
			} else {
				$SQL = "SELECT stockmaster.stockid,
						stockmaster.description,
						stockmaster.units
					FROM stockmaster, 
						stockcategory
					WHERE stockmaster.categoryid=stockcategory.categoryid
					AND (stockcategory.stocktype='F' OR stockcategory.stocktype='D')
					AND stockmaster.categoryid='" . $_POST['StockCat'] . "'
					GROUP BY stockmaster.stockid, 
						stockmaster.description, 
						stockmaster.units
					ORDER BY stockmaster.stockid";
			  }
		}

		$ErrMsg = _('There is a problem selecting the part records to display because');
		$SearchResult = DB_query($SQL,$db,$ErrMsg);

		if (DB_num_rows($SearchResult)==0){
			   prnMsg(_('Sorry') . ' ... ' . _('there are no products available that match the criteria specified'),'info');
			   if ($debug==1){
				    echo '<P>' . _('The SQL statement used was') . ':<BR>' . $SQL;
			   }
		}
		if (DB_num_rows($SearchResult)==1){
			   $myrow=DB_fetch_array($SearchResult);
			   $_POST['NewItem'] = $myrow['stockid'];
			   DB_data_seek($SearchResult,0);
		}

	 } //end of if search for parts to add to the credit note

/*Always do the stuff below if not looking for a customerid
  Set up the form for the credit note display and  entry*/

	 echo '<FORM ACTION="' . $_SERVER['PHP_SELF'] . '?' . SID . '" METHOD=POST>';


/*Process Quick Entry */

	 If (isset($_POST['QuickEntry'])){
/* get the item details from the database and hold them in the cart object make the quantity 1 by default then add it to the cart */
	    $i=1;
	     do {
		   do {
			  $QuickEntryCode = 'part_' . $i;
			  $QuickEntryQty = 'qty_' . $i;
			  $i++;
		   } while (!is_numeric($_POST[$QuickEntryQty]) AND $_POST[$QuickEntryQty] <=0 AND strlen($_POST[$QuickEntryCode])!=0 AND $i<=$QuickEntires);

		   $_POST['NewItem'] = $_POST[$QuickEntryCode];
		   $NewItemQty = $_POST[$QuickEntryQty];

		   if (strlen($_POST['NewItem'])==0){
			     break;	 /* break out of the loop if nothing in the quick entry fields*/
		   }

		   $AlreadyOnThisCredit =0;

		   foreach ($_SESSION['CreditItems']->LineItems AS $OrderItem) {

		   /* do a loop round the items on the credit note to see that the item
		   is not already on this credit note */

			    if ($OrderItem->StockID == $_POST['NewItem']) {
				     $AlreadyOnThisCredit = 1;
				     echo '<BR><B>' . _('Warning') . ':</B> ' . _('the part') . ' ' . $_POST['NewItem'] . ' ' . _('is already on this credit') . ' - ' . _('the system will not allow the same item on the credit note more than once') . '. ' . _('However you can change the quantity credited of the existing line if necessary');
			    }
		   } /* end of the foreach loop to look for preexisting items of the same code */

		   if ($AlreadyOnThisCredit!=1){

			    $sql = "SELECT
			    		stockmaster.description,
			    		stockmaster.stockid,
					stockmaster.units,
					stockmaster.volume,
					stockmaster.kgs,
					(materialcost+labourcost+overheadcost) AS standardcost,
					stockmaster.mbflag,
					stockmaster.taxlevel,
					stockmaster.decimalplaces,
					stockmaster.controlled,
					stockmaster.serialised,
					stockmaster.discountcategory 
				FROM stockmaster
				 WHERE  stockmaster.stockid = '". $_POST['NewItem'] . "'";

				$ErrMsg =  _('There is a problem selecting the part because');
				$result1 = DB_query($sql,$db,$ErrMsg);


       		   		if ($myrow = DB_fetch_array($result1)){

					if ($_SESSION['CreditItems']->add_to_cart ($_POST['NewItem'],
											$NewItemQty,
											$myrow['description'],
											GetPrice ($_POST['NewItem'],
												$_SESSION['CreditItems']->DebtorNo,
												$_SESSION['CreditItems']->Branch, &$db),
												0,
											$myrow['units'],
											$myrow['volume'],
											$myrow['kgs'],
											0,
											$myrow['mbflag'],
											Date($_SESSION['DefaultDateFormat']),
											0,
											$myrow['discountcategory'],
											$myrow['controlled'],
											$myrow['serialised'],
											$myrow['decimalplaces']
										)
						==1){
							$_SESSION['CreditItems']->LineItems[$_POST['NewItem']]->StandardCost = $myrow['standardcost'];
					 		$_SESSION['CreditItems']->LineItems[$_POST['NewItem']]->TaxRate = GetTaxRate($_SESSION['TaxAuthority'], $_SESSION['DispatchTaxAuthority'], $myrow['taxlevel'],$db);

							if ($myrow['controlled']==1){
								/*Qty must be built up from serial item entries */

					   			$_SESSION['CreditItems']->LineItems[$_POST['NewItem']]->Quantity = 0;
							}

					}
			   	} else {
					prnMsg( _('The part code') . ' "' . $_POST['NewItem'] . '" ' . _('does not exist in the database and cannot therefore be added to the credit note'),'warn');
			   	}
		   	} /* end of if not already on the credit note */
		} while ($i<=$_SESSION['QuickEntries']); /*loop to the next quick entry record */
		unset($_POST['NewItem']);
	} /* end of if quick entry */


/* setup system defaults for looking up prices and the number of ordered items
   if an item has been selected for adding to the basket add it to the session arrays */

	 If ($_SESSION['CreditItems']->ItemsOrdered > 0 OR isset($_POST['NewItem'])){

		If(isset($_GET['Delete'])){
			$_SESSION['CreditItems']->remove_from_cart($_GET['Delete']);
		}

		foreach ($_SESSION['CreditItems']->LineItems as $StockItem) {

			if (isset($_POST['Quantity_' . $StockItem->StockID])){

				$Quantity = $_POST['Quantity_' . $StockItem->StockID];
				$Narrative = $_POST['Narrative_' . $StockItem->StockID];

				if (isset($_POST['Price_' . $StockItem->StockID])){
					if ($_POST['Gross']==True){
						$Price = round($_POST['Price_' . $StockItem->StockID]/($StockItem->TaxRate + 1),2);
					} else {
						$Price = $_POST['Price_' . $StockItem->StockID];
					}

     					$DiscountPercentage = $_POST['Discount_' . $StockItem->StockID];
					$_SESSION['CreditItems']->LineItems[$StockItem->StockID]->TaxRate = $_POST['TaxRate_' . $StockItem->StockID]/100;
				}
			}

			If ($Quantity<0 OR $Price <0 OR $DiscountPercentage >100 OR $DiscountPercentage <0){
				prnMsg(_('The item could not be updated because you are attempting to set the quantity credited to less than 0 or the price less than 0 or the discount more than 100% or less than 0%'),'warn');
			} elseif (isset($_POST['Quantity_' . $StockItem->StockID])) {
				$_SESSION['CreditItems']->update_cart_item($StockItem->StockID, $Quantity, $Price, $DiscountPercentage/100, $Narrative);
			}
		}

		If (isset($_POST['NewItem'])){
/* get the item details from the database and hold them in the cart object make the quantity 1 by default then add it to the cart */

			   $AlreadyOnThisCredit =0;

			   foreach ($_SESSION['CreditItems']->LineItems AS $OrderItem) {

			   /* do a loop round the items on the credit note to see that the item
			   is not already on this credit note */

				    if ($OrderItem->StockID == $_POST['NewItem']) {
					     $AlreadyOnThisCredit = 1;
					     prnMsg(_('The item selected is already on this credit') . ' - ' . _('the system will not allow the same item on the credit note more than once') . '. ' . _('However you can change the quantity credited of the existing line if necessary'),'warn');
				    }
			   } /* end of the foreach loop to look for preexisting items of the same code */

			   if ($AlreadyOnThisCredit!=1){

				$sql = "SELECT stockmaster.description,
						stockmaster.stockid,
						stockmaster.units,
						stockmaster.volume,
						stockmaster.kgs,
						(materialcost+labourcost+overheadcost) AS standardcost,
						taxlevel
					FROM stockmaster
					WHERE stockmaster.stockid = '". $_POST['NewItem'] . "'";

				$ErrMsg = _('The item details could not be retrieved because');
				$DbgMsg = _('The SQL used to retrieve the item details but failed was');
				$result1 = DB_query($sql,$db,$ErrMsg,$DbgMsg);
				$myrow = DB_fetch_array($result1);


/*validate the data returned before adding to the items to credit */
				if ($_SESSION['CreditItems']->add_to_cart ($_POST['NewItem'],
									1,
									$myrow['description'], GetPrice($_POST['NewItem'],$_SESSION['CreditItems']->DebtorNo,$_SESSION['CreditItems']->Branch, &$db),
									0,
									$myrow['units'],
									$myrow['volume'],
									$myrow['kgs'],
									0,
									$myrow['mbflag'],
									Date($_SESSION['DefaultDateFormat']),
									0,
									$myrow['discountcategory'],
									$myrow['controlled'],
									$myrow['serialised'],
									$myrow['decimalplaces']
									)==1){
					$_SESSION['CreditItems']->LineItems[$_POST['NewItem']]->StandardCost = $myrow['standardcost'];

$_SESSION['CreditItems']->LineItems[$_POST['NewItem']]->TaxRate = GetTaxRate($_SESSION['TaxAuthority'], $_SESSION['DispatchTaxAuthority'], $myrow['taxlevel'],&$db);

					if ($myrow['controlled']==1){
						/*Qty must be built up from serial item entries */

					   $_SESSION['CreditItems']->LineItems[$_POST['NewItem']]->Quantity = 0;
					}

				}
			   } /* end of if not already on the credit note */
		  } /* end of if its a new item */

/* This is where the credit note as selected should be displayed  reflecting any deletions or insertions*/

		  echo '<CENTER>
		  <TABLE CELLPADDING=2 COLSPAN=7>
		  <TR>
		  <TD class="tableheader">' . _('Item Code') . '</TD>
		  <TD class="tableheader">' . _('Item Description') . '</TD>
		  <TD class="tableheader">' . _('Quantity') . '</TD>
		  <TD class="tableheader">' . _('Unit') . '</TD>
		  <TD class="tableheader">' . _('Price') . '</TD>
		  <TD class="tableheader">' . _('Gross') . '</TD>
		  <TD class="tableheader">' . _('Discount') . '</TD>
		  <TD class="tableheader">' . _('Total') . '<BR>' . _('Excl Tax') . '</TD>
		  <TD class="tableheader">' . _('Tax') . '<BR>' . _('Rate') . '</TD>
		  <TD class="tableheader">' . _('Tax') . '<BR>' . _('Amount') . '</TD>
		  <TD class="tableheader">' . _('Total') . '<BR>' . _('Incl Tax') . '</TD>
		  </TR>';

		  $_SESSION['CreditItems']->total = 0;
		  $_SESSION['CreditItems']->totalVolume = 0;
		  $_SESSION['CreditItems']->totalWeight = 0;
		  $TaxTotal = 0;
		  $k =0;  //row colour counter
		  foreach ($_SESSION['CreditItems']->LineItems as $StockItem) {

			   $LineTotal =  $StockItem->Quantity * $StockItem->Price * (1 - $StockItem->DiscountPercent);
			   $DisplayLineTotal = number_format($LineTotal,2);

			   if ($k==1){
				$RowStarter = '<tr bgcolor="#EEAABB">';
			   } elseif ($k==1){
				$RowStarter = '<tr bgcolor="#CCCCCC">';
				$k=0;
			   } else {
				$RowStarter = '<tr bgcolor="#EEEEEE">';
				$k=1;
			   }


			   echo $RowStarter . '<TD>' . $StockItem->StockID . '</TD>
			   	<TD>' . $StockItem->ItemDescription . '</TD>';

			   if ($StockItem->Controlled==0){
			   	echo '<TD><INPUT TYPE=TEXT NAME="Quantity_' . $StockItem->StockID . '" MAXLENGTH=6 SIZE=6 VALUE=' . $StockItem->Quantity . '></TD>';
			   } else {
				echo '<TD ALIGN=RIGHT><A HREF="' . $rootpath . '/CreditItemsControlled.php?' . SID . 'StockID=' . $StockItem->StockID . '">' . $StockItem->Quantity . '</A>
              <INPUT TYPE=HIDDEN NAME="Quantity_' . $StockItem->StockID . '" VALUE=' . $StockItem->Quantity . '></TD>';
			   }

			echo '<TD>' . $StockItem->Units . '</TD>
			<TD><INPUT TYPE=TEXT NAME="Price_' . $StockItem->StockID . '" SIZE=8 MAXLENGTH=8 VALUE=' . $StockItem->Price . '></TD>
			<TD><INPUT TYPE="CheckBox" NAME="Gross" VALUE=False></TD>
			<TD><INPUT TYPE=TEXT NAME="Discount_' . $StockItem->StockID . '" SIZE=3 MAXLENGTH=3 VALUE=' . ($StockItem->DiscountPercent * 100) . '>%</TD>
			<TD ALIGN=RIGHT>' . $DisplayLineTotal . '</TD>
			<TD><INPUT TYPE=TEXT NAME="TaxRate_' . $StockItem->StockID . '" SIZE=4 MAXLENGTH=4 VALUE=' . ($StockItem->TaxRate * 100) . '>%</TD>
			<TD ALIGN=RIGHT>' . number_format($LineTotal*$StockItem->TaxRate,2) . '</TD>
			<TD ALIGN=RIGHT>' . number_format($LineTotal*(1+$StockItem->TaxRate),2) . '</TD>
			<TD><A HREF="' . $_SERVER['PHP_SELF'] . '?' . SID . 'Delete=' . $StockItem->StockID . '">' . _('Delete') . '</A></TD>
			</TR>';

			echo $RowStarter;
			echo '<TD COLSPAN=11><TEXTAREA  NAME="Narrative_' . $StockItem->StockID . '" cols=100% rows=1>' . $StockItem->Narrative . '</TEXTAREA><BR><HR></TD></TR>';


			$_SESSION['CreditItems']->total = $_SESSION['CreditItems']->total + $LineTotal;
			$_SESSION['CreditItems']->totalVolume = $_SESSION['CreditItems']->totalVolume + $StockItem->Quantity * $StockItem->Volume; $_SESSION['CreditItems']->totalWeight = $_SESSION['CreditItems']->totalWeight + $StockItem->Quantity * $StockItem->Weight;

			$TaxTotal += $LineTotal*$StockItem->TaxRate;
		}

		if (!isset($_POST['ChargeFreight'])) {
			$_POST['ChargeFreight']=0;
		}

		if  (!isset($_POST['FreightTaxRate'])) {
			$_POST['FreightTaxRate']=$_SESSION['FreightTaxRate'];
		} else {
   			$_SESSION['FreightTaxRate']=$_POST['FreightTaxRate'];
		}

		echo '<TR>
			<TD COLSPAN=7 ALIGN=RIGHT>' . _('Credit Freight') . '</TD>
			<TD><FONT SIZE=2><INPUT TYPE=TEXT SIZE=6 MAXLENGTH=6 NAME=ChargeFreight VALUE=' . $_POST['ChargeFreight'] . '></TD>
			<TD><INPUT TYPE=TEXT SIZE=4 MAXLENGTH=4 NAME=FreightTaxRate VALUE=' . $_POST['FreightTaxRate'] . '>%</TD>
			<TD ALIGN=RIGHT>' . number_format($_POST['FreightTaxRate']*$_POST['ChargeFreight']/100,2) . '</TD>
			<TD ALIGN=RIGHT>' . number_format((100+$_POST['FreightTaxRate'])*$_POST['ChargeFreight']/100,2) . '</TD>
		</TR>';


		$DisplayTotal = number_format($_SESSION['CreditItems']->total + $_POST['ChargeFreight'],2);
		$TaxTotal += $_POST['FreightTaxRate']*$_POST['ChargeFreight']/100;

		echo '<TR>
			<TD COLSPAN=7 ALIGN=RIGHT>' . _('Credit Totals') . '</TD>
			<TD ALIGN=RIGHT><HR><B>' . $DisplayTotal . '</B><HR></TD>
			<TD></TD>
			<TD ALIGN=RIGHT><HR><B>' . number_format($TaxTotal,2) . '<HR></TD>
			<TD ALIGN=RIGHT><HR><B>' . number_format($TaxTotal+($_SESSION['CreditItems']->total + $_POST['ChargeFreight']),2) . '</B><HR></TD>
		</TR></TABLE>';

/*Now show options for the credit note */

		echo '<BR><CENTER><TABLE><TR><TD>' . _('Credit Note Type') . ' :</TD><TD><SELECT NAME=CreditType>';
		if (!isset($_POST['CreditType']) OR $_POST['CreditType']=='Return'){
			   echo '<OPTION SELECTED VALUE="Return">' . _('Goods returned to store');
			   echo '<OPTION VALUE="WriteOff">' . _('Goods written off');
			   echo '<OPTION VALUE="ReverseOverCharge">' . _('Reverse an Overcharge');
		} elseif ($_POST['CreditType']=='WriteOff') {
			   echo '<OPTION SELECTED VALUE="WriteOff">' . _('Goods written off');
			   echo '<OPTION VALUE="Return">' . _('Goods returned to store');
			   echo '<OPTION VALUE="ReverseOverCharge">' . _('Reverse an Overcharge');
		} elseif($_POST['CreditType']=='ReverseOverCharge'){
		  	echo '<OPTION SELECTED VALUE="ReverseOverCharge">' . _('Reverse Overcharge Only');
			echo '<OPTION VALUE="Return">' . _('Goods Returned To Store');
			echo '<OPTION VALUE="WriteOff">' . _('Good written off');
		}

		echo '</SELECT></TD></TR>';


		if (!isset($_POST['CreditType']) OR $_POST['CreditType']=="Return"){

/*if the credit note is a return of goods then need to know which location to receive them into */

			echo '<TR><TD>' . _('Goods Returned to Location') . ' :</TD><TD><SELECT NAME=Location>';

			$SQL="SELECT loccode, locationname FROM locations";
			$Result = DB_query($SQL,$db);

			if (!isset($_POST['Location'])){
				$_POST['Location'] = $_SESSION['CreditItems']->Location;
			}
			while ($myrow = DB_fetch_array($Result)) {

				if ($_POST['Location']==$myrow['loccode']){
					echo '<OPTION SELECTED VALUE="' . $myrow['loccode'] . '">' . $myrow['locationname'];
				} else {
					echo '<OPTION VALUE="' . $myrow['loccode'] . '">' . $myrow['locationname'];
				}
			}
			echo '</SELECT></TD></TR>';

		} elseif ($_POST['CreditType']=='WriteOff') { /* the goods are to be written off to somewhere */

			echo '<TR><TD>' . _('Write off the cost of the goods to') . '</TD><TD><SELECT NAME=WriteOffGLCode>';

			   $SQL="SELECT accountcode, 
			   		accountname 
				FROM chartmaster, 
					accountgroups 
				WHERE chartmaster.group_=accountgroups.groupname 
				AND accountgroups.pandl=1 ORDER BY accountcode";
			   $Result = DB_query($SQL,$db);

			   while ($myrow = DB_fetch_array($Result)) {

				    if ($_POST['WriteOffGLCode']==$myrow['accountcode']){
					     echo '<OPTION SELECTED VALUE=' . $myrow['accountcode'] . '>' . $myrow['accountcode'] . ' - ' . $myrow["accountname"];
				    } else {
					     echo '<OPTION VALUE=' . $myrow['accountcode'] . '>' . $myrow['accountcode'] . ' - ' . $myrow['accountname'];
				    }
			   }
			   echo '</SELECT></TD></TR>';
		  }
		  echo '<TR><TD>' . _('Credit Note Text') . ' :</TD><TD><TEXTAREA NAME=CreditText COLS=31 ROWS=5>' . $_POST['CreditText'] . '</TEXTAREA></TD></TR></TABLE></CENTER>';

		  if (!isset($_POST['ProcessCredit'])){
				    echo '<CENTER><INPUT TYPE=SUBMIT NAME="Update" VALUE="' . _('Update') . '">
                  <INPUT TYPE=SUBMIT NAME="CancelCredit" VALUE="' . _('Cancel') . '">
                  <INPUT TYPE=SUBMIT NAME="ProcessCredit" VALUE="' . _('Process Credit Note') . '"></CENTER><HR>';
		  }
	 } # end of if lines


/* Now show the stock item selection search stuff below */

	 if (isset($_POST['PartSearch']) AND $_POST['PartSearch']!="" AND !isset($_POST['ProcessCredit'])){

		 echo '<input type="hidden" name="PartSearch" value="' . _('Yes Please') . '">';

		 $SQL="SELECT categoryid, 
		 	categorydescription 
			FROM stockcategory 
			WHERE stocktype='F' 
			ORDER BY categorydescription";
		 
		 $result1 = DB_query($SQL,$db);

		 echo '<B>' . $msg . '</B><BR><TABLE><TR><TD><FONT SIZE=2>' . _('Select a stock category') . ':</FONT><SELECT NAME="StockCat">';

		 echo '<OPTION SELECTED VALUE="All">' . _('All');
		 while ($myrow1 = DB_fetch_array($result1)) {
			  if ($_POST['StockCat']==$myrow1['categoryid']){
				   echo '<OPTION SELECTED VALUE=' . $myrow1['categoryid'] . '>' . $myrow1['categorydescription'];
			  } else {
				   echo '<OPTION VALUE=' . $myrow1['categoryid'] . '>' . $myrow1['categorydescription'];
			  }
		 }

		 echo '</SELECT>';

		 echo '<TD><FONT SIZE=2>' . _('Enter text extracts in the description') . ':</FONT></TD>';
		 echo '<TD><INPUT TYPE="Text" NAME="Keywords" SIZE=20 MAXLENGTH=25 VALUE="' . $_POST['Keywords'] . '"></TD></TR>';
		 echo '<TR><TD></TD>';
		 echo '<TD><FONT SIZE 3><B>' ._('OR') . '</B></FONT><FONT SIZE=2>' . _('Enter extract of the Stock Code') . ':</FONT></TD>';
		 echo '<TD><INPUT TYPE="Text" NAME="StockCode" SIZE=15 MAXLENGTH=18 VALUE="' . $_POST['StockCode'] . '"></TD>';
		 echo '</TR>';
		 echo '</TABLE>';

		 echo '<CENTER><INPUT TYPE=SUBMIT NAME="Search" VALUE="' . _('Search Now') .'">';
		 echo '<INPUT TYPE=SUBMIT Name="ChangeCustomer" VALUE="' . _('Change Customer') . '">';
		 echo '<INPUT TYPE=SUBMIT Name="Quick" VALUE="' . _('Quick Entry') . '">';
		 echo '</CENTER>';

		 if (isset($SearchResult)) {

			  echo '<CENTER><TABLE CELLPADDING=2 COLSPAN=7 BORDER=1>';
			  $TableHeader = '<TR><TD class="tableheader">' . _('Code') . '</TD>
			  			<TD class="tableheader">' . _('Description') . '</TD>
						<TD class="tableheader">' . _('Units') .'</TD></TR>';
			  echo $TableHeader;

			  $j = 1;
			  $k=0; //row colour counter

			  while ($myrow=DB_fetch_array($SearchResult)) {

				   $ImageSource = $_SESSION['part_pics_dir'] . "/" . $myrow["stockid"] . ".jpg";
				   /* $_SESSION['part_pics_dir'] is a user defined variable in config.php */

				   if ($k==1){
					    echo '<tr bgcolor="#CCCCCC">';
					    $k=0;
				   } else {
					    echo '<tr bgcolor="#EEEEEE">';
					    $k++;
				   }

				   printf("<td><FONT SIZE=1><INPUT TYPE=SUBMIT NAME='NewItem' VALUE='%s'></FONT></td>
                   				<td><FONT SIZE=1>%s</FONT></td>
                   				<td><FONT SIZE=1>%s</FONT></td>
                   				<td><img src=%s></td></tr>",
                   				$myrow['stockid'],
                   				$myrow['description'],
                   				$myrow['units'],
                   				$ImageSource);

				   $j++;
				   If ($j == 20){
					    $j=1;
					    echo $TableHeader;
				   }
	#end of page full new headings if
			  }
	#end of while loop
			  echo '</TABLE>';
		 }#end if SearchResults to show
	} /*end if part searching required */ elseif(!isset($_POST['ProcessCredit'])) { /*quick entry form */

/*FORM VARIABLES TO POST TO THE CREDIT NOTE 10 AT A TIME WITH PART CODE AND QUANTITY */
	     echo '<FONT SIZE=4 COLOR=BLUE><B>' . _('Quick Entry') . '</B></FONT><BR><CENTER><TABLE BORDER=1>
	     	<TR>
             	<TD class="tableheader">' . _('Part Code') . '</TD>
             	<TD class="tableheader">' . _('Quantity') . '</TD>
             	</TR>';

	      for ($i=1;$i<=$_SESSION['QuickEntries'];$i++){

	     	echo '<tr bgcolor="#CCCCCC"><TD><INPUT TYPE="text" name="part_' . $i . '" size=21 maxlength=20></TD>
			<TD><INPUT TYPE="text" name="qty_' . $i . '" size=6 maxlength=6></TD></TR>';
	     }

	     echo '</TABLE><INPUT TYPE="submit" name="QuickEntry" value="' . _('Process Entries') . '">
             <INPUT TYPE="submit" name="PartSearch" value="' . _('Search Parts') . '">';

	}

} #end of else not selecting a customer

if (isset($_POST['ProcessCredit'])){

/* SQL to process the postings for sales credit notes... First Get the area where the credit note is to from the branches table */
	 $SQL = "SELECT area 
	 		FROM custbranch 
			WHERE custbranch.debtorno ='". $_SESSION['CreditItems']->DebtorNo . "' 
			AND custbranch.branchcode = '" . $_SESSION['CreditItems']->Branch . "'";
	$ErrMsg = '<BR>' . _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The area cannot be determined for this customer');
	$DbgMsg = '<BR>' . _('The following SQL to insert the customer credit note was used');
	$Result = DB_query($SQL,$db,$ErrMsg,$DbgMsg);

	 if ($myrow = DB_fetch_row($Result)){
	     $Area = $myrow[0];
	 }

	 DB_free_result($Result);

	 if ($_SESSION['CompanyRecord']['gllink_stock']==1
	 	AND $_POST['CreditType']=="WriteOff"
		AND (!isset($_POST['WriteOffGLCode'])
		OR $_POST['WriteOffGLCode']=='')){

		  prnMsg(_('For credit notes created to write off the stock a general ledger account is required to be selected') . '. ' . _('Please select an account to write the cost of the stock off to then click on Process again'),'error');
		  include('includes/footer.inc');
		  exit;
	 }


/*Now Get the next credit note number - function in SQL_CommonFunctions*/
/*Start an SQL transaction */

	 $ErrMsg = '<BR>' . _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The database does not support transactions') . ' - ' . _('MYSQL must be compiled to support either Berkely or Innobase transactions and tables used set to the appropriate type');
	 $DbgMsg = '<BR>' . _('The following SQL to insert the customer credit note was used');

	 $Result = DB_query("BEGIN",$db,$ErrMsg,$DbgMsg);


	 $CreditNo = GetNextTransNo(11, $db);
	 $SQLCreditDate = Date("Y-m-d");
	 $PeriodNo = GetPeriod(Date($_SESSION['DefaultDateFormat']), $db);

/*Now insert the Credit Note into the DebtorTrans table allocations will have to be done seperately*/

	 $SQL = "INSERT INTO debtortrans (
	 		transno,
	 		type,
			debtorno,
			branchcode,
			trandate,
			prd,
			tpe,
			ovamount,
			ovgst,
			ovfreight,
			rate,
			invtext)
		  VALUES (". $CreditNo . ",
		  	11,
			'" . $_SESSION['CreditItems']->DebtorNo . "',
			'" . $_SESSION['CreditItems']->Branch . "',
			'" . $SQLCreditDate . "', " . $PeriodNo . ",
			'" . $_SESSION['CreditItems']->DefaultSalesType . "',
			" . -($_SESSION['CreditItems']->total) . ",
			" . -$TaxTotal . ",
		  	" . -$_POST['ChargeFreight'] . ",
			" . $_SESSION['CurrencyRate'] . ",
			'" . $_POST['CreditText'] . "'
		)";

	$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The customer credit note transaction could not be added to the database because');
	$DbgMsg = _('The following SQL to insert the customer credit note was used');
	$Result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);


/* Insert stock movements for stock coming back in if the Credit is a return of goods */

	 foreach ($_SESSION['CreditItems']->LineItems as $CreditLine) {

		  If ($CreditLine->Quantity > 0){

			    $LocalCurrencyPrice= ($CreditLine->Price / $_SESSION['CurrencyRate']);

			    if ($CreditLine->MBflag=="M" oR $CreditLine->MBflag=="B"){
			   /*Need to get the current location quantity will need it later for the stock movement */
		 	    	$SQL="SELECT locstock.quantity
					FROM locstock
					WHERE locstock.stockid='" . $CreditLine->StockID . "'
					AND loccode= '" . $_SESSION['CreditItems']->Location . "'";

			    	$Result = DB_query($SQL, $db);
			    	if (DB_num_rows($Result)==1){
					$LocQtyRow = DB_fetch_row($Result);
					$QtyOnHandPrior = $LocQtyRow[0];
			    	} else {
					/*There must actually be some error this should never happen */
					$QtyOnHandPrior = 0;
			    	}
			    } else {
			    	$QtyOnHandPrior =0; //because its a dummy/assembly/kitset part
			    }

			    if ($_POST['CreditType']=='ReverseOverCharge') {
			   /*Insert a stock movement coming back in to show the credit note  - flag the stockmovement not to show on stock movement enquiries - its is not a real stock movement only for invoice line - also no mods to location stock records*/
				$SQL = "INSERT INTO stockmoves
					(stockid,
					type,
					transno,
					loccode,
					trandate,
					debtorno,
					branchcode,
					price,
					prd,
					reference,
					qty,
					discountpercent,
					standardcost,
					newqoh,
					hidemovt,
					narrative)
					VALUES
					('" . $CreditLine->StockID . "',
					11,
					" . $CreditNo . ",
					'" . $_SESSION['CreditItems']->Location . "',
					'" . $SQLCreditDate . "',
					'" . $_SESSION['CreditItems']->DebtorNo . "',
					'" . $_SESSION['CreditItems']->Branch . "',
					" . $LocalCurrencyPrice . ",
					" . $PeriodNo . ",
					'" . $_POST['CreditText'] . "',
					" . $CreditLine->Quantity . ",
					" . $CreditLine->DiscountPercent . ",
					" . $CreditLine->StandardCost . ",
					" . $QtyOnHandPrior  . ",
					1,
					'" . $CreditLine->Narrative . "')";

				$ErrMsg =  _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('Stock movement records could not be inserted because');
				$DbgMsg = _('The following SQL to insert the stock movement records for the purpose of display on the credit note was used');
				$Result = DB_query($SQL, $db,$ErrMsg,$DbgMsg,true);

			   } else { //its a return or a write off need to record goods coming in first

			    	if ($CreditLine->MBflag=="M" OR $CreditLine->MBflag=="B"){
			    		$SQL = "INSERT INTO stockmoves
							(stockid,
							type,
							transno,
							loccode,
							trandate,
							debtorno,
							branchcode,
							price,
							prd,
							qty,
							discountpercent,
							standardcost,
							reference,
							newqoh,
							taxrate,
							narrative)
						VALUES (
							'" . $CreditLine->StockID . "',
							11,
							" . $CreditNo . ",
							'" . $_SESSION['CreditItems']->Location . "',
							'" . $SQLCreditDate . "',
							'" . $_SESSION['CreditItems']->DebtorNo . "',
							'" . $_SESSION['CreditItems']->Branch . "',
							" . $LocalCurrencyPrice . ",
							" . $PeriodNo . ",
							" . $CreditLine->Quantity . ",
							" . $CreditLine->DiscountPercent . ",
							" . $CreditLine->StandardCost . ",
							'" . $_POST['CreditText'] . "',
							" . ($QtyOnHandPrior + $CreditLine->Quantity) . ",
							" . $CreditLine->TaxRate . ",
							'" . $CreditLine->Narrative . "'
						)";

			    	} else { /*its an assembly/kitset or dummy so don't attempt to figure out new qoh */
					$SQL = "INSERT INTO stockmoves
							(stockid,
							type,
							transno,
							loccode,
							trandate,
							debtorno,
							branchcode,
							price,
							prd,
							qty,
							discountpercent,
							standardcost,
							reference,
							taxrate,
							narrative)
						VALUES (
							'" . $CreditLine->StockID . "',
							11,
							" . $CreditNo . ",
							'" . $_SESSION['CreditItems']->Location . "',
							'" . $SQLCreditDate . "',
							'" . $_SESSION['CreditItems']->DebtorNo . "',
							'" . $_SESSION['CreditItems']->Branch . "',
							" . $LocalCurrencyPrice . ",
							" . $PeriodNo . ",
							" . $CreditLine->Quantity . ",
							" . $CreditLine->DiscountPercent . ",
							" . $CreditLine->StandardCost . ",
							'" . $_POST['CreditText'] . "',
							" . $CreditLine->TaxRate . ",
							'" . $CreditLine->Narrative . "'
							)";

			    	}

				$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('Stock movement records could not be inserted because');
				$DbgMsg = _('The following SQL to insert the stock movement records was used');
				$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, true);

				if (($CreditLine->MBflag=="M" OR $CreditLine->MBflag=="B") AND $CreditLine->Controlled==1){
					/*Need to do the serial stuff in here now */

					/*Get the stockmoveno from above - need to ref SerialStockMoves */
					$StkMoveNo = DB_Last_Insert_ID($db,'stockmoves','stkmoveno');

					foreach($CreditLine->SerialItems as $Item){

						/*1st off check if StockSerialItems already exists */
						$SQL = "SELECT COUNT(*)
							FROM stockserialitems
							WHERE stockid='" . $CreditLine->StockID . "'
							AND loccode='" . $_SESSION['CreditItems']->Location . "'
							AND serialno='" . $Item->BundleRef . "'";
						$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The existence of the serial stock item record could not be determined because');
						$DbgMsg = _('The following SQL to find out if the serial stock item record existed already was used');
						$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, true);
						$myrow = DB_fetch_row($Result);

						if ($myrow[0]==0) {
						/*The StockSerialItem record didnt exist
						so insert a new record */
							$SQL = "INSERT INTO stockserialitems (
								stockid,
								loccode,
								serialno,
								quantity)
								VALUES (
								'" . $CreditLine->StockID . "',
								'" . $_SESSION['CreditItems']->Location . "',
								'" . $Item->BundleRef . "',
								" . $Item->BundleQty . "
								)";

							$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The new serial stock item record could not be inserted because');
							$DbgMsg = _('The following SQL to insert the new serial stock item record was used') ;
							$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, true);
						} else { /*Update the existing StockSerialItems record */
							$SQL = "UPDATE stockserialitems SET
								quantity= quantity + " . $Item->BundleQty . "
								WHERE stockid='" . $CreditLine->StockID . "'
								AND loccode='" . $_SESSION['CreditItems']->Location . "'
								AND serialno='" . $Item->BundleRef . "'";

							$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The serial stock item record could not be updated because');
							$DbgMsg = _('The following SQL to update the serial stock item record was used');
							$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, true);
						}
						/* now insert the serial stock movement */

						$SQL = "INSERT INTO stockserialmoves (
								stockmoveno,
								stockid,
								serialno,
								moveqty)
							VALUES (
								" . $StkMoveNo . ",
								'" . $CreditLine->StockID . "',
								'" . $Item->BundleRef . "',
								" . $Item->BundleQty . "
								)";
						$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The serial stock movement record could not be inserted because');
						$DbgMsg = _('The following SQL to insert the serial stock movement record was used');
						$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, true);

					}/* foreach serial item in the serialitems array */

				} /*end if the credit line is a controlled item */

			    }/*End of its a return or a write off */

			    if ($_POST['CreditType']=='Return'){

				/* Update location stock records if not a dummy stock item */

				if ($CreditLine->MBflag=='B' OR $CreditLine->MBflag=='M') {

					$SQL = "UPDATE locstock
						SET locstock.quantity = locstock.quantity + " . $CreditLine->Quantity . "
						WHERE locstock.stockid = '" . $CreditLine->StockID . "'
						AND locstock.loccode = '" . $_SESSION['CreditItems']->Location . "'";

					$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('Location stock record could not be updated because');
					$DbgMsg = _('The following SQL to update the location stock record was used');
					$Result = DB_query($SQL, $db,$ErrMsg,$DbgMsg,true);

				} else if ($CreditLine->MBflag=='A'){ /* its an assembly */
					/*Need to get the BOM for this part and make stock moves
					for the componentsand of course update the Location stock
					balances for all the components*/

					$StandardCost =0; /*To start with then
				    		Accumulate the cost of the comoponents
						for use in journals later on */

					$SQL = "SELECT
				    		bom.component,
				    		bom.quantity, stockmaster.materialcost+stockmaster.labourcost+stockmaster.overheadcost AS standard
						FROM bom, stockmaster
						WHERE bom.component=stockmaster.stockid
						AND bom.parent='" . $CreditLine->StockID . "'
						AND bom.effectiveto > '" . Date("Y-m-d") . "'
						AND bom.effectiveafter < '" . Date("Y-m-d") . "'";

					$ErrMsg =  _('Could not retrieve assembly components from the database for') . ' ' . $CreditLine->StockID . ' ' . _('because');
				 	$DbgMsg = _('The SQL that failed was');
					$AssResult = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);

					while ($AssParts = DB_fetch_array($AssResult,$db)){

						$StandardCost += $AssParts['standard'];

/*Need to get the current location quantity will need it later for the stock movement */
					   	$SQL="SELECT locstock.quantity
					   	FROM locstock
						WHERE locstock.stockid='" . $AssParts['component'] . "'
						AND locstock.loccode= '" . $_SESSION['CreditItems']->Location . "'";

        					$Result = DB_query($SQL, $db);
						if (DB_num_rows($Result)==1){
							$LocQtyRow = DB_fetch_row($Result);
							$QtyOnHandPrior = $LocQtyRow[0];
						} else {
						/*There must actually be some error this should never happen */
							$QtyOnHandPrior = 0;
						}

						/*Add stock movements for the assembly component items */
						$SQL = "INSERT INTO stockmoves
							(stockid,
							type,
							transno,
							loccode,
							trandate,
							debtorno,
							branchcode,
							prd,
							reference,
							qty,
							standardcost,
							show_on_inv_crds,
							newqoh)
						VALUES (
							'" . $AssParts['component'] . "',
							11,
							" . $CreditNo . ",
							'" . $_SESSION['CreditItems']->Location . "',
							'" . $SQLCreditDate . "',
							'" . $_SESSION['CreditItems']->DebtorNo . "',
							'" . $_SESSION['CreditItems']->Branch . "',
							" . $PeriodNo . ",
							'Assembly: " . $CreditLine->StockID . "',
							" . $AssParts['quantity'] * $CreditLine->Quantity . ", " . $AssParts['standard'] . ",
							0,
							" . ($QtyOnHandPrior + ($AssParts['quantity'] * $CreditLine->Quantity)) . "
							)";

					$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('Stock movement records for the assembly components of') . ' ' . $CreditLine->StockID . ' ' . _('could not be inserted because');
					$DbgMsg = _('The following SQL to insert the assembly components stock movement records was used');
				        $Result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);

					  /*Update the stock quantities for the assembly components */
					 $SQL = "UPDATE locstock
					   		SET locstock.quantity = locstock.quantity + " . $AssParts['quantity'] * $CreditLine->Quantity . "
							WHERE locstock.stockid = '" . $AssParts['component'] . "'
							AND locstock.loccode = '" . $_SESSION['CreditItems']->Location . "'";

					$ErrMsg =  _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('Location stock record could not be updated for an assembly component because');
  					$DbgMsg =  _('The following SQL to update the component location stock record was used');
					$Result = DB_query($SQL, $db,$ErrMsg, $DbgMsg,true);
				    } /* end of assembly explosion and updates */


				    /*Update the cart with the recalculated standard cost
				    from the explosion of the assembly's components*/
				    $_SESSION['CreditItems']->LineItems[$CreditLine->StockID]->StandardCost = $StandardCost;
				    $CreditLine->StandardCost = $StandardCost;
				}
				    /*end of its a return of stock */
			   } elseif ($_POST['CreditType']=='WriteOff'){ /*its a stock write off */

			   	    if ($CreditLine->MBflag=="B" OR $CreditLine->MBflag=="M"){
			   		/* Insert stock movements for the
					item being written off - with unit cost */
				    	$SQL = "INSERT INTO stockmoves (
							stockid,
							type,
							transno,
							loccode,
							trandate,
							debtorno,
							branchcode,
							price,
							prd,
							qty,
							discountpercent,
							standardcost,
							reference,
							show_on_inv_crds,
							newqoh,
							narrative)
						VALUES (
							'" . $CreditLine->StockID . "',
							11,
							" . $CreditNo . ",
							'" . $_SESSION['CreditItems']->Location . "',
							'" . $SQLCreditDate . "',
							'" . $_SESSION['CreditItems']->DebtorNo . "',
							'" . $_SESSION['CreditItems']->Branch . "',
							" . $LocalCurrencyPrice . ",
							" . $PeriodNo . ",
							" . -$CreditLine->Quantity . ",
							" . $CreditLine->DiscountPercent . ",
							" . $CreditLine->StandardCost . ",
							'" . $_POST['CreditText'] . "',
							0,
							" . $QtyOnHandPrior . ",
							'" . $CreditLine->Narrative . "'
							)";

				    } else { /* its an assembly, so dont figure out the new qoh */

					$SQL = "INSERT INTO stockmoves (
							stockid,
							type,
							transno,
							loccode,
							trandate,
							debtorno,
							branchcode,
							price,
							prd,
							qty,
							discountpercent,
							standardcost,
							reference,
							show_on_inv_crds)
						VALUES (
							'" . $CreditLine->StockID . "',
							11,
							" . $CreditNo . ",
							'" . $_SESSION['CreditItems']->Location . "',
							'" . $SQLCreditDate . "',
							'" . $_SESSION['CreditItems']->DebtorNo . "',
							'" . $_SESSION['CreditItems']->Branch . "',
							" . $LocalCurrencyPrice . ",
							" . $PeriodNo . ",
							" . -$CreditLine->Quantity . ",
							" . $CreditLine->DiscountPercent . ",
							" . $CreditLine->StandardCost . ",
							'" . $_POST['CreditText'] . "',
							0)";

				}

     			$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('Stock movement record to write the stock off could not be inserted because');
				$DbgMsg = _('The following SQL to insert the stock movement to write off the stock was used');
				$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, true);

				if (($CreditLine->MBflag=="M" OR $CreditLine->MBflag=="B") AND $CreditLine->Controlled==1){
					/*Its a write off too still so need to process the serial items
					written off */

					$StkMoveNo = DB_Last_Insert_ID($db,'stockmoves','stkmoveno');

					foreach($CreditLine->SerialItems as $Item){
					/*no need to check StockSerialItems record exists
					it would have been added by the return stock movement above */
						$SQL = "UPDATE stockserialitems SET
							quantity= quantity - " . $Item->BundleQty . "
							WHERE stockid='" . $CreditLine->StockID . "'
							AND loccode='" . $_SESSION['CreditItems']->Location . "'
							AND serialno='" . $Item->BundleRef . "'";

						$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The serial stock item record could not be updated for the write off because');
						$DbgMsg = _('The following SQL to update the serial stock item record was used');
						$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, true);

						/* now insert the serial stock movement */

						$SQL = "INSERT INTO stockserialmoves (
								stockmoveno,
								stockid,
								serialno,
								moveqty)
							VALUES (
								" . $StkMoveNo . ",
								'" . $CreditLine->StockID . "',
								'" . $Item->BundleRef . "',
								" . -$Item->BundleQty . "
								)";
						$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The serial stock movement record for the write off could not be inserted because');
						$DbgMsg = _('The following SQL to insert the serial stock movement write off record was used');
						$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, true);

					}/* foreach serial item in the serialitems array */

				} /*end if the credit line is a controlled item */

   			} /*end if its a stock write off */

/*Insert Sales Analysis records use links to the customer master and branch tables to ensure that if
the salesman or area has changed a new record is inserted for the customer and salesman of the new
set up. Considered just getting the area and salesman from the branch table but these can alter and the
sales analysis needs to reflect the sales made before and after the changes*/

			   $SQL="SELECT
			   		COUNT(*),
					salesanalysis.stkcategory,
					salesanalysis.area,
					salesanalysis.salesperson
				FROM salesanalysis, 
					custbranch, 
					stockmaster
				WHERE salesanalysis.stkcategory=stockmaster.categoryid
				AND salesanalysis.stockid=stockmaster.stockid
				AND salesanalysis.cust=custbranch.debtorno
				AND salesanalysis.custbranch=custbranch.branchcode
				AND salesanalysis.area=custbranch.area
				AND salesanalysis.salesperson=custbranch.salesman
				AND salesanalysis.typeabbrev ='" . $_SESSION['CreditItems']->DefaultSalesType . "'
				AND salesanalysis.periodno=" . $PeriodNo . "
				AND salesanalysis.cust = '" . $_SESSION['CreditItems']->DebtorNo . "'
				AND salesanalysis.custbranch = '" . $_SESSION['CreditItems']->Branch . "'
				AND salesanalysis.stockid = '" . $CreditLine->StockID . "'
				AND salesanalysis.budgetoractual=1
				GROUP BY salesanalysis.stkcategory, 
					salesanalysis.area, 
					salesanalysis.salesperson";

			$ErrMsg = _('The count to check for existing Sales analysis records could not run because');
			$DbgMsg = _('SQL to count the no of sales analysis records');
			$Result = DB_query($SQL,$db, $ErrMsg, $DbgMsg, true);

			$myrow = DB_fetch_row($Result);

			if ($myrow[0]>0){  /*Update the existing record that already exists */

				if ($_POST['CreditType']=='ReverseOverCharge'){

					/*No updates to qty or cost data */

					$SQL = "UPDATE salesanalysis
					SET amt=amt-" . ($CreditLine->Price * $CreditLine->Quantity / $_SESSION['CurrencyRate']) . ",
					disc=disc-" . ($CreditLine->DiscountPercent * $CreditLine->Price * $CreditLine->Quantity / $_SESSION['CurrencyRate']) . "
					WHERE salesanalysis.area='" . $myrow[2] . "'
					AND salesanalysis.salesperson='" . $myrow[3] . "'
					AND salesanalysis.typeabbrev ='" . $_SESSION['CreditItems']->DefaultSalesType . "'
					AND salesanalysis.periodno = " . $PeriodNo . "
					AND salesanalysis.cust = '" . $_SESSION['CreditItems']->DebtorNo . "'
					AND salesanalysis.custbranch = '" . $_SESSION['CreditItems']->Branch . "'
					AND salesanalysis.stockid = '" . $CreditLine->StockID . "'
					AND salesanalysis.stkcategory ='" . $myrow[1] . "'
					AND salesanalysis.budgetoractual=1";

				} else {

					$SQL = "UPDATE SalesAnalysis
					SET Amt=Amt-" . ($CreditLine->Price * $CreditLine->Quantity / $_SESSION['CurrencyRate']) . ",
					Cost=Cost-" . ($CreditLine->StandardCost * $CreditLine->Quantity) . ",
					Qty=Qty-" . $CreditLine->Quantity . ",
					Disc=Disc-" . ($CreditLine->DiscountPercent * $CreditLine->Price * $CreditLine->Quantity / $_SESSION['CurrencyRate']) . "
					WHERE salesanalysis.area='" . $myrow[2] . "'
					AND salesanalysis.salesperson='" . $myrow[3] . "'
					AND salesanalysis.typeabbrev ='" . $_SESSION['CreditItems']->DefaultSalesType . "'
					AND salesanalysis.periodno = " . $PeriodNo . "
					AND salesanalysis.cust = '" . $_SESSION['CreditItems']->DebtorNo . "'
					AND salesanalysis.custbranch = '" . $_SESSION['CreditItems']->Branch . "'
					AND salesanalysis.stockid = '" . $CreditLine->StockID . "'
					AND salesanalysis.stkcategory ='" . $myrow[1] . "'
					AND salesanalysis.budgetoractual=1";
				}

			   } else { /* insert a new sales analysis record */

		   		if ($_POST['CreditType']=="ReverseOverCharge"){

					$SQL = "INSERT salesanalysis (
						typeabbrev,
						periodno,
						amt,
						cust,
						custbranch,
						qty,
						disc,
						stockid,
						area,
						budgetoractual,
						salesperson,
						stkcategory)
						SELECT
						'" . $_SESSION['CreditItems']->DefaultSalesType . "',
						" . $PeriodNo . ",
						" . -($CreditLine->Price * $CreditLine->Quantity / $_SESSION['CurrencyRate']) . ",
						'" . $_SESSION['CreditItems']->DebtorNo . "',
						'" . $_SESSION['CreditItems']->Branch . "',
						0,
						" . -($CreditLine->DiscountPercent * $CreditLine->Price * $CreditLine->Quantity / $_SESSION['CurrencyRate']) . ",
						'" . $CreditLine->StockID . "',
						custbranch.area,
						1,
						custbranch.salesman,
						stockmaster.categoryid
						FROM stockmaster, custbranch
						WHERE stockmaster.stockid = '" . $CreditLine->StockID . "'
						AND custbranch.debtorno = '" . $_SESSION['CreditItems']->DebtorNo . "'
						AND custbranch.branchcode='" . $_SESSION['CreditItems']->Branch . "'";

				} else {

				    $SQL = "INSERT salesanalysis (
				    	typeabbrev,
					periodno,
					amt,
					cost,
					cust,
					custbranch,
					qty,
					disc,
					stockid,
					area,
					budgetoractual,
					salesperson,
					stkcategory)
					SELECT '" . $_SESSION['CreditItems']->DefaultSalesType . "',
					" . $PeriodNo . ",
					" . -($CreditLine->Price * $CreditLine->Quantity / $_SESSION['CurrencyRate']) . ",
					" . -($CreditLine->StandardCost * $CreditLine->Quantity) . ",
					'" . $_SESSION['CreditItems']->DebtorNo . "',
					'" . $_SESSION['CreditItems']->Branch . "',
					" . -$CreditLine->Quantity . ",
					" . -($CreditLine->DiscountPercent * $CreditLine->Price * $CreditLine->Quantity / $_SESSION['CurrencyRate']) . ",
					'" . $CreditLine->StockID . "',
					custbranch.area,
					1,
					custbranch.salesman,
					stockmaster.categoryid
					FROM stockmaster, 
						custbranch
					WHERE stockmaster.stockid = '" . $CreditLine->StockID . "'
					AND custbranch.debtorno = '" . $_SESSION['CreditItems']->DebtorNo . "'
					AND custbranch.branchcode='" . $_SESSION['CreditItems']->Branch . "'";
				}
			}

			$ErrMsg = _('The sales analysis record for this credit note could not be added because');
			$DbgMsg = _('The following SQL to insert the sales analysis record was used');
			$Result = DB_query($SQL,$db,$ErrMsg, $DbgMsg, true);


/* If GLLink_Stock then insert GLTrans to either debit stock or an expense
depending on the valuve of $_POST['CreditType'] and then credit the cost of sales
at standard cost*/

			   if ($_SESSION['CompanyRecord']['gllink_stock']==1 AND $CreditLine->StandardCost !=0 AND $_POST['CreditType']!="ReverseOverCharge"){

/*first reverse credit the cost of sales entry*/
				  $COGSAccount = GetCOGSGLAccount($Area, $CreditLine->StockID, $_SESSION['CreditItems']->DefaultSalesType, $db);
				  $SQL = "INSERT INTO gltrans (
				  		type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount)
					VALUES (
						11,
						" . $CreditNo . ",
						'" . $SQLCreditDate . "',
						" . $PeriodNo . ",
						" . $COGSAccount . ",
						'" . $_SESSION['CreditItems']->DebtorNo . " - " . $CreditLine->StockID . " x " . $CreditLine->Quantity . " @ " . $CreditLine->StandardCost . "',
						" . ($CreditLine->StandardCost * -$CreditLine->Quantity) . 					")";

				$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The cost of the stock credited GL posting could not be inserted because');
				$DbgMsg = _('The following SQL to insert the GLTrans record was used');
				$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, true);


				if ($_POST['CreditType']=="WriteOff"){

/* The double entry required is to reverse the cost of sales entry as above
then debit the expense account the stock is to written off to */

					$SQL = "INSERT INTO gltrans (
							type,
							typeno,
							trandate,
							periodno,
							account,
							narrative,
							amount)
						VALUES (
							11,
							" . $CreditNo . ",
							'" . $SQLCreditDate . "',
							" . $PeriodNo . ",
							" . $_POST['WriteOffGLCode'] . ",
							'" . $_SESSION['CreditItems']->DebtorNo . " - " . $CreditLine->StockID . " x " . $CreditLine->Quantity . " @ " . $CreditLine->StandardCost . "',
							" . ($CreditLine->StandardCost * $CreditLine->Quantity) . "
							)";

					$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The cost of the stock credited GL posting could not be inserted because');
					$DbgMsg = _('The following SQL to insert the GLTrans record was used');
					$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, true);
				    } else {

/*the goods are coming back into stock so debit the stock account*/
					$StockGLCode = GetStockGLCode($CreditLine->StockID, $db);
					$SQL = "INSERT INTO gltrans (
					     		type,
							typeno,
							trandate,
							periodno,
							account,
							narrative,
							amount)
						VALUES (
							11,
							" . $CreditNo . ",
							'" . $SQLCreditDate . "',
							" . $PeriodNo . ", " . $StockGLCode['stockact'] . ",
							'" . $_SESSION['CreditItems']->DebtorNo . " - " . $CreditLine->StockID . " x " . $CreditLine->Quantity . " @ " . $CreditLine->StandardCost . "',
							" . ($CreditLine->StandardCost * $CreditLine->Quantity) . "
							)";

					$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The stock side (or write off) of the cost of sales GL posting could not be inserted because');
					$DbgMsg = _('The following SQL to insert the GLTrans record was used');
					$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, true);
				    }

			   } /* end of if GL and stock integrated and standard cost !=0 */

			   if ($_SESSION['CompanyRecord']['gllink_debtors']==1 AND $CreditLine->Price !=0){

//Post sales transaction to GL credit sales
				    $SalesGLAccounts = GetSalesGLAccount($Area, $CreditLine->StockID, $_SESSION['CreditItems']->DefaultSalesType, $db);

				$SQL = "INSERT INTO gltrans (
						type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount)
					VALUES (
						11,
						" . $CreditNo . ",
						'" . $SQLCreditDate . "',
						" . $PeriodNo . ",
						" . $SalesGLAccounts['salesglcode'] . ",
						'" . $_SESSION['CreditItems']->DebtorNo . " - " . $CreditLine->StockID . " x " . $CreditLine->Quantity . " @ " . $CreditLine->Price . "',
						" . ($CreditLine->Price * $CreditLine->Quantity) . "
						)";

				$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The credit note GL posting could not be inserted because');
				$DbgMsg = _('The following SQL to insert the GLTrans record was used');
				$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, true);

				if ($CreditLine->DiscountPercent !=0){

					     $SQL = "INSERT INTO gltrans (
					     		type,
							typeno,
							trandate,
							periodno,
							account,
							narrative,
							amount)
						VALUES (
							11,
							" . $CreditNo . ",
							'" . $SQLCreditDate . "',
							" . $PeriodNo . ",
							" . $SalesGLAccounts['discountglcode'] . ",
							'" . $_SESSION['CreditItems']->DebtorNo . " - " . $CreditLine->StockID . " @ " . ($CreditLine->DiscountPercent * 100) . "%',
							" . -($CreditLine->Price * $CreditLine->Quantity * $CreditLine->DiscountPercent) . "
							)";


					$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The credit note discount GL posting could not be inserted because');
					$DbgMsg = _('The following SQL to insert the GLTrans record was used');
					$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, true);
				}/* end of if discount not equal to 0 */
			   } /*end of if sales integrated with debtors */
		  } /*Quantity credited is more than 0 */
	 } /*end of CreditLine loop */


	 if ($_SESSION['CompanyRecord']['gllink_debtors']==1){

/*Post credit note transaction to GL credit debtors, debit freight re-charged and debit sales */
		  if (($_SESSION['CreditItems']->total + $_POST['ChargeFreight'] + $TaxTotal) !=0) {
			$SQL = "INSERT INTO gltrans (
					type,
					typeno,
					trandate,
					periodno,
					account,
					narrative,
					amount)
				VALUES (
					11,
					" . $CreditNo . ",
					'" . $SQLCreditDate . "',
					" . $PeriodNo . ",
					" . $_SESSION['CompanyRecord']['debtorsact'] . ",
					'" . $_SESSION['CreditItems']->DebtorNo . "',
					" . -($_SESSION['CreditItems']->total + $_POST['ChargeFreight'] + $TaxTotal) . "
					)";

			$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The total debtor GL posting for the credit note could not be inserted because');
			$DbgMsg = _('The following SQL to insert the GLTrans record was used');
			$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, true);
		  }
		  if ($_POST['ChargeFreight'] !=0) {
			$SQL = "INSERT INTO gltrans (
			   		type,
					typeno,
					trandate,
					periodno,
					account,
					narrative,
					amount)
				VALUES (
					11,
					" . $CreditNo . ",
					'" . $SQLCreditDate . "',
					" . $PeriodNo . ",
					" . $_SESSION['CompanyRecord']['freightact'] . ",
					'" . $_SESSION['CreditItems']->DebtorNo . "',
					" . $_POST['ChargeFreight'] . "
				)";

			$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The freight GL posting for this credit note could not be inserted because');
			$DbgMsg = _('The following SQL to insert the GLTrans record was used');
			$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, true);
		}
		if ($TaxTotal !=0){
			$SQL = "INSERT INTO gltrans (
						type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount)
					VALUES (
						11,
						" . $CreditNo . ",
						'" . $SQLCreditDate . "',
						" . $PeriodNo . ",
						" . $_SESSION['TaxGLCode'] . ",
						'" . $_SESSION['CreditItems']->DebtorNo . "',
						" . $TaxTotal . "
					)";


			$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The tax GL posting for this credit note could not be inserted because');
			$DbgMsg =  _('The following SQL to insert the GLTrans record was used');
			$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, true);
		} /*end of if TaxTotal Not equal 0 */
	 } /*end of if Sales and GL integrated */

	 $SQL="Commit";
	 $Result = DB_query($SQL,$db);

	 unset($_SESSION['CreditItems']->LineItems);
	 unset($_SESSION['CreditItems']);

	 echo _('Credit Note number') . ' ' . $CreditNo . ' ' . _('processed') . '<BR>';
	 echo '<A target="_blank" HREF="' . $rootpath . '/PrintCustTrans.php?FromTransNo=' . $CreditNo . '&InvOrCredit=Credit">' . _('Show this Credit Note on screen') . '</A><BR>';
	 echo '<A HREF="' . $rootpath . '/PrintCustTrans.php?FromTransNo=' . $CreditNo . '&InvOrCredit=Credit&PrintPDF=True">' . _('Print this Credit Note') . '</A>';
	 echo '<P><A HREF="' . $rootpath . '/SelectCreditItems.php">' . _('Enter Another Credit Note') . '</A>';

} /*end of process credit note */

echo '</FORM>';
include('includes/footer.inc');
?>
