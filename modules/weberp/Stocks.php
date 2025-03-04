<?php
/* $Revision: 1.19 $ */

$PageSecurity = 11;

include('includes/session.inc');
$title = _('Item Maintenance');
include('includes/header.inc');

/*If this form is called with the StockID then it is assumed that the stock item is to be modified */

if (isset($_GET['StockID'])){
	$StockID =strtoupper($_GET['StockID']);
} elseif (isset($_POST['StockID'])){
	$StockID =strtoupper($_POST['StockID']);
}


if (isset($_FILES['ItemPicture']) AND $_FILES['ItemPicture']['name'] !='') {
	
	$result    = $_FILES['ItemPicture']['error'];
 	$UploadTheFile = 'Yes'; //Assume all is well to start off with
	$filename = $_SESSION['part_pics_dir'] . '/' . $StockID . '.jpg';
	
	 //But check for the worst 
	if (strtoupper(substr(trim($_FILES['ItemPicture']['name']),strlen($_FILES['ItemPicture']['name'])-3))!='JPG'){
		prnMsg(_('Only jpg files are supported - a file extension of .jpg is expected'),'warn');
		$UploadTheFile ='No';
	} elseif ( $_FILES['ItemPicture']['size'] > ($_SESSION['MaxImageSize']*1024)) { //File Size Check
		prnMsg(_('The file size is over the maximum allowed. The maximum size allowed in KB is') . ' ' . $_SESSION['MaxImageSize'],'warn');
		$UploadTheFile ='No';
	} elseif ( $_FILES['ItemPicture']['type'] == "text/plain" ) {  //File Type Check
		prnMsg( _('Only graphics files can be uploaded'),'warn');
         	$UploadTheFile ='No';
	} elseif (file_exists($filename)){
		prnMsg(_('Attempting to overwrite an existing item image'),'warn');
		$result = unlink($filename);
		if (!$result){
			prnMsg(_('The existing image could not be removed'),'error');
			$UploadTheFile ='No';
		}
	}
	
	if ($UploadTheFile=='Yes'){
		$result  =  move_uploaded_file($_FILES['ItemPicture']['tmp_name'], $filename);
		$message = ($result)?_('File url') ."<a href='". $filename ."'>" .  $filename . '</a>' : "Somthing is wrong with uploading a file.";
	}
 /* EOR Add Image upload for New Item  - by Ori */
}


if (isset($_POST['submit'])) {

	//initialise no input errors assumed initially before we test
	$InputError = 0;

	/* actions to take once the user has clicked the submit button
	ie the page has called itself with some user input */

	//first off validate inputs sensible

	if (strlen($_POST['Description']) > 50 OR strlen($_POST['Description'])==0) {
		$InputError = 1;
		prnMsg (_('The stock item description must be entered and be fifty characters or less long') . '. ' . _('It cannot be a zero length string either') . ' - ' . _('a description is required'),'error');
	} elseif (strlen($_POST['LongDescription'])==0) {
		$InputError = 1;
		prnMsg (_('The stock item description cannot be a zero length string') . ' - ' . _('a long description is required'),'error');
	} elseif (strlen($StockID) ==0) {
		$InputError = 1;
		prnMsg (_('The Stock Item code cannot be empty'),'error');
	}elseif (strstr($StockID,' ') OR strstr($StockID,"'") OR strstr($StockID,'+') OR strstr($StockID,"\\") OR strstr($StockID,"\"") OR strstr($StockID,'&') OR strstr($StockID,'.') OR strstr($StockID,'"')) {
		$InputError = 1;
		prnMsg(_('The stock item code cannot contain any of the following characters') . " - ' & + \" \\ " . _('or a space'),'error');

	} elseif (strlen($_POST['Units']) >20) {
		$InputError = 1;
		prnMsg(_('The unit of measure must be 20 characters or less long'),'error');
	} elseif (strlen($_POST['BarCode']) >20) {
		$InputError = 1;
		prnMsg(_('The barcode must be 20 characters or less long'),'error');
	} elseif (!is_numeric($_POST['Volume'])) {
		$InputError = 1;
		prnMsg (_('The volume of the packaged item in cubic metres must be numeric') ,'error');
	} elseif ($_POST['Volume'] <0) {
		$InputError = 1;
		prnMsg(_('The volume of the packaged item must be a positive number'),'error');
	} elseif (!is_numeric($_POST['KGS'])) {
		$InputError = 1;
		prnMsg(_('The weight of the packaged item in KGs must be numeric'),'error');
	} elseif ($_POST['KGS'] <0) {
		$InputError = 1;
		prnMsg(_('The weight of the packaged item must be a positive number'),'error');
	} elseif (!is_numeric($_POST['EOQ'])) {
		$InputError = 1;
		prnMsg(_('The economic order quantity must be numeric'),'error');
	} elseif ($_POST['EOQ'] <0) {
		$InputError = 1;
		prnMsg (_('The economic order quantity must be a positive number'),'error');
	} elseif (! is_numeric($_POST['TaxLevel'])){
		$InputError = 1;
		prnMsg(_('The tax level determines the rate of tax in conjunction with the tax authority of the branch where the item is sold to') . '. ' . _('The tax level must be a number between 0 and 9'),'error');
	}elseif ($_POST['Controlled']==0 AND $_POST['Serialised']==1){
		$InputError = 1;
		prnMsg(_('The item can only be serialised if there is lot control enabled already') . '. ' . _('Batch control') . ' - ' . _('with any number of items in a lot/bundle/roll is enabled when controlled is enabled') . '. ' . _('Serialised control requires that only one item is in the batch') . '. ' . _('For serialised control') . ', ' . _('both controlled and serialised must be enabled'),'error');
	} elseif (($_POST['MBFlag']=='A' OR $_POST['MBFlag']=='K' OR $_POST['MBFlag']=='D') AND $_POST['Controlled']==1){
		$InputError = 1;
		prnMsg(_('Assembly/Kitset/Dummy items cannot also be controlled items') . '. ' . _('Assemblies/Dummies and Kitsets are not physical items and batch/serial control is therefore not appropriate'),'error');
	} elseif (trim($_POST['CategoryID'])==''){
		$InputError = 1;
		prnMsg(_('There are no inventory categories defined. All inventory items must belong to a valid inventory category,'),'error');
	}

	if ($InputError !=1){

		if ($_POST['Serialised']==1){ /*Not appropriate to have several dp on serial items */
			$_POST['DecimalPlaces']=0;
		}

		if (!isset($_POST['New'])) { /*so its an existing one */

			/*first check on the changes being made we must disallow:
			- changes from manufactured or purchased to Dummy, Assembly or Kitset if there is stock			- changes from manufactured, kitset or assembly where a BOM exists
			*/

			$sql = "SELECT mbflag, controlled, serialised FROM stockmaster WHERE stockid = '$StockID'";
			$MBFlagResult = DB_query($sql,$db);
			$myrow = DB_fetch_row($MBFlagResult);
			$OldMBFlag = $myrow[0];
			$OldControlled = $myrow[1];
			$OldSerialised = $myrow[2];

			$sql = "SELECT SUM(locstock.quantity) FROM locstock WHERE stockid='$StockID'";
			$result = DB_query($sql,$db);
			$stkqtychk = DB_fetch_row($result);

			if ($OldMBFlag != $_POST['MBFlag']){
				if (($OldMBFlag == 'M' OR $OldMBFlag=='B') AND ($_POST['MBFlag']=='A' OR $_POST['MBFlag']=='K' OR $_POST['MBFlag']=='D')){ /*then need to check that there is no stock holding first */
					if ($stkqtychk[0]!=0){
						$InputError=1;
						prnMsg( _('The make or buy flag cannot be changed from') . ' ' . $OldMBFlag . ' ' . _('to') . ' ' . $_POST['MBFlag'] . ' ' . _('where there is a quantity of stock on hand at any location') . '. ' . _('Currently there are') . ' ' . $stkqtychk[0] .  ' ' . _('on hand') , 'errror');
					}

					if ($_POST['Controlled']==1){
						$InputError=1;
						prnMsg( _('The make or buy flag cannot be changed from') . ' ' . $OldMBFlag . ' ' . _('to') . ' ' . $_POST['MBFlag'] . ' ' . _('where the item is to be lot controlled') . '. ' . _('Kitset, dummy and assembly items cannot be lot controlled'), 'error');
					}
				}
				/*now check that if the item is being changed to a kitset, there are no items on order sales or purchase orders*/
				if ($_POST['MBFlag']=='K') {
					$sql = "SELECT quantity-qtyinvoiced 
						FROM salesorderdetails 
						WHERE stkcode = '$StockID' 
						AND completed=0";
						
					$result = DB_query($sql,$db);
					$ChkSalesOrds = DB_fetch_row($result);
					if ($ChkSalesOrds[0]!=0){
						$InputError = 1;
						prnMsg( _('The make or buy flag cannot be changed to a kitset where there is a quantity outstanding to be delivered on sales orders') . '. ' . _('Currently there are') .' ' . $ChkSalesOrds[0] . ' '. _('outstanding'), 'error');
					}
				}
				/*now check that if it is to be a kitset or assembly or dummy there is no quantity on purchase orders outstanding*/
				if ($_POST['MBFlag']=='K' OR $_POST['MBFlag']=='A' OR $_POST['MBFlag']=='D') {

					$sql = "SELECT quantityord-quantityrecd 
						FROM purchorderdetails 
						WHERE itemcode = '$StockID' 
						AND completed=0";
						
					$result = DB_query($sql,$db);
					$ChkPurchOrds = DB_fetch_row($result);
					if ($ChkPurchOrds[0]!=0){
						$InputError = 1;
						prnMsg( _('The make or buy flag cannot be changed to'). ' ' . $_POST['MBFlag'] . ' '. _('where there is a quantity outstanding to be received on purchase orders') . '. ' . _('Currently there are'). ' ' . $ChkPurchOrds[0] . ' '. _('yet to be received'). 'error');
					}
				}
				/*now check that if it is was a Manufactured, Kitset or Assembly and is being changed to a purchased or dummy - that no BOM exists */

				if (($OldMBFlag=='M' OR $OldMBFlag =='K' OR $OldMBFlag=='A') AND ($_POST['MBFlag']=='B' OR $_POST['MBFlag']=='D')) {
					$sql = "SELECT COUNT(*) FROM bom WHERE parent = '$StockID'";
					$result = DB_query($sql,$db);
					$ChkBOM = DB_fetch_row($result);
					if ($ChkBOM[0]!=0){
						$InputError = 1;
						prnMsg( _('The make or buy flag cannot be changed from manufactured, kitset or assembly to'). ' ' . $_POST['MBFlag'] . ' '. _('where there is a bill of material set up for the item') . '. ' . _('Bills of material are not appropriate for purchased or dummy items'), 'error');
					}
				}

				/*now check that if it was Manufac or Purchased and is being changed to assembly or kitset, it is not a component on an existing BOM */
				if (($OldMBFlag=='M' OR $OldMBFlag =='B' OR $OldMBFlag=='D') AND ($_POST['MBFlag']=='A' OR $_POST['MBFlag']=='K')) {
					$sql = "SELECT COUNT(*) FROM bom WHERE component = '$StockID'";
					$result = DB_query($sql,$db);
					$ChkBOM = DB_fetch_row($result);
					if ($ChkBOM[0]!=0){
						$InputError = 1;
						prnMsg( _('The make or buy flag cannot be changed from manufactured, purchased or dummy to a kitset or assembly where the item is a component in a bill of material') . '. ' . _('Assembly and kitset items are not appropriate as componennts in a bill of materials'), 'error');
					}
				}
			}

			/* Do some checks for changes in the Serial & Controlled setups */

			if ($OldControlled != $_POST['Controlled'] AND $stkqtychk[0]!=0){
				$InputError=1;
				prnMsg( _('You can not change a Non-Controlled Item to Controlled (or back from Controlled to non-controlled when there is currently stock on hand for the item') , 'error');

			}
			if ($OldSerialised != $_POST['Serialised'] AND $stkqtychk[0]!=0){
				$InputError=1;
				prnMsg( _('You can not change a Serialised Item to Non-Serialised (or visa-versa) when there is a quantity on hand for the item') , 'error');
			}


			if ($InputError == 0){
				$sql = "UPDATE stockmaster
						SET longdescription='" . DB_escape_string($_POST['LongDescription']) . "',
							description='" . DB_escape_string($_POST['Description']) . "',
							discontinued=" . $_POST['Discontinued'] . ",
							controlled=" . $_POST['Controlled'] . ",
							serialised=" . $_POST['Serialised'].",
							categoryid='" . $_POST['CategoryID'] . "',
							units='" . DB_escape_string($_POST['Units']) . "',
							mbflag='" . $_POST['MBFlag'] . "',
							eoq=" . $_POST['EOQ'] . ",
							volume=" . $_POST['Volume'] . ",
							kgs=" . $_POST['KGS'] . ",
							barcode='" . $_POST['BarCode'] . "',
							discountcategory='" . $_POST['DiscountCategory'] . "',
							taxlevel=" . $_POST['TaxLevel'] . ",
							decimalplaces=" . $_POST['DecimalPlaces'] . "
					WHERE stockid='$StockID'";


				$ErrMsg = _('The stock item could not be updated because');
				$DbgMsg = _('The SQL that was used to update the stock item and failed was');
				$result = DB_query($sql,$db,$ErrMsg,$DbgMsg);

				prnMsg( _('Stock Item') . ' ' . $StockID . ' ' . _('has been updated'), 'success');
			}

		} else { //it is a NEW part

			$sql = "INSERT INTO stockmaster (
						stockid,
						description,
						longdescription,
						categoryid,
						units,
						mbflag,
						eoq,
						discontinued,
						controlled,
						serialised,
						volume,
						kgs,
						barcode,
						discountcategory,
						taxlevel,
						decimalplaces)
					VALUES ('$StockID',
						'" . DB_escape_string($_POST['Description']) . "',
						'" . DB_escape_string($_POST['LongDescription']) . "',
						'" . $_POST['CategoryID'] . "',
						'" . DB_escape_string($_POST['Units']) . "',
						'" . $_POST['MBFlag'] . "',
						" . $_POST['EOQ'] . ",
						" . $_POST['Discontinued'] . ",
						" . $_POST['Controlled'] . ",
						" . $_POST['Serialised']. ",
						" . $_POST['Volume'] . ",
						" . $_POST['KGS'] . ",
						'" . $_POST['BarCode'] . "',
						'" . $_POST['DiscountCategory'] . "',
						" . $_POST['TaxLevel'] . ",
						" . $_POST['DecimalPlaces']. "
						)";

			$ErrMsg =  _('The item could not be added because');
			$DbgMsg = _('The SQL that was used to add the item failed was');
			$result = DB_query($sql,$db, $ErrMsg, $DbgMsg);
			if (DB_error_no($db) ==0) {

				$sql = "INSERT INTO locstock (loccode,
								stockid)
						SELECT locations.loccode,
							'" . $StockID . "'
						FROM locations";

				$ErrMsg =  _('The locations for the item') . ' ' . $myrow[0] .  ' ' . _('could not be added because');
				$DbgMsg = _('NB Locations records can be added by opening the utility page') . ' <i>Z_MakeStockLocns.php</i> ' . _('The SQL that was used to add the location records that failed was');
				$InsResult = DB_query($sql,$db,$ErrMsg,$DbgMsg);

				if (DB_error_no($db) ==0) {
					echo '<BR>' . _('New Item') .' ' . $StockID  . ' '. _('has been added to the database');
					unset($_POST['LongDescription']);
					unset($_POST['Description']);
					unset($_POST['EOQ']);
					unset($_POST['CategoryID']);
					unset($_POST['Units']);
					unset($_POST['MBFlag']);
					unset($_POST['Discontinued']);
					unset($_POST['Controlled']);
					unset($_POST['Serialised']);
					unset($_POST['Volume']);
					unset($_POST['KGS']);
					unset($_POST['BarCode']);
					unset($_POST['ReorderLevel']);
					unset($_POST['DiscountCategory']);
					unset($_POST['DecimalPlaces']);
					unset($StockID);
				}
			}
		}
		/*Check for a new TaxLevel and insert new records in TaxAuthLevels as necessary */

		$result = DB_query("SELECT taxauthority FROM taxauthlevels WHERE level=" . $_POST['TaxLevel'] ,$db);
		if (DB_num_rows($result)==0){ /*need to add the new level accross all TaxAuthorities */

			$DispTaxAuthResult = DB_query('SELECT DISTINCT taxauthority FROM locations',$db);

			while ($DispTaxAuthRow = DB_fetch_row($DispTaxAuthResult)){
				$sql = 'INSERT INTO taxauthlevels (taxauthority, 
								dispatchtaxauthority, 
								level) 
						SELECT taxid,
							 ' . $DispTaxAuthRow[0] . ', 
							 ' . $_POST['TaxLevel'] . ' 
						FROM taxauthorities';
				$InsertResult = DB_query($sql,$db);
			}
		}

	} else {
		echo '<BR>';
		prnMsg( _('Validation failed, no updates or deletes took place'), 'error');
	}

} elseif (isset($_POST['delete']) AND strlen($_POST['delete']) >1 ) {
//the button to delete a selected record was clicked instead of the submit button

	$CancelDelete = 0;

// PREVENT DELETES IF DEPENDENT RECORDS IN 'StockMoves'

	$sql= "SELECT COUNT(*) FROM stockmoves WHERE stockid='$StockID'";
	$result = DB_query($sql,$db);
	$myrow = DB_fetch_row($result);
	if ($myrow[0]>0) {
		$CancelDelete = 1;
		prnMsg( _('Cannot delete this stock item because there are stock movements that refer to this item'),'warn');
		echo '<BR>' . _('There are') . ' ' . $myrow[0] . ' ' . _('stock movements that refer to this item');

	} else {
		$sql= "SELECT COUNT(*) FROM bom WHERE component='$StockID'";
		$result = DB_query($sql,$db);
		$myrow = DB_fetch_row($result);
		if ($myrow[0]>0) {
			$CancelDelete = 1;
			prnMsg( _('Cannot delete this item record because there are bills of material that require this part as a component'),'warn');
			echo '<br>' . _('There are') . ' ' . $myrow[0] . ' ' . _('bills of material that require this part as a component');
		} else {
			$sql= "SELECT COUNT(*) FROM salesorderdetails WHERE stkcode='$StockID'";
			$result = DB_query($sql,$db);
			$myrow = DB_fetch_row($result);
			if ($myrow[0]>0) {
				$CancelDelete = 1;
				prnMsg( _('Cannot delete this item record because there are existing sales orders for this part'),'warn');
				echo '<BR>' . _('There are') . ' ' . $myrow[0] . ' ' . _('sales order items against this part');
			} else {
				$sql= "SELECT COUNT(*) FROM salesanalysis WHERE stockid='$StockID'";
				$result = DB_query($sql,$db);
				$myrow = DB_fetch_row($result);
				if ($myrow[0]>0) {
					$CancelDelete = 1;
					prnMsg(_('Cannot delete this item because sales analysis records exist for it'),'warn');
					echo '<BR>' . _('There are') . ' ' . $myrow[0] . ' ' . _('sales analysis records against this part');
				} else {
					$sql= "SELECT COUNT(*) FROM purchorderdetails WHERE itemcode='$StockID'";
					$result = DB_query($sql,$db);
					$myrow = DB_fetch_row($result);
					if ($myrow[0]>0) {
						$CancelDelete = 1;
						prnMsg(_('Cannot delete this item because there are existing purchase order items for it'),'warn');
						echo '<BR>' . _('There are') . ' ' . $myrow[0] . ' ' . _('purchase order item record relating to this part');
					} else {
						$sql = "SELECT SUM(quantity) AS qoh FROM locstock WHERE stockid='$StockID'";
						$result = DB_query($sql,$db);
						$myrow = DB_fetch_row($result);
						if ($myrow[0]!=0) {
							$CancelDelete = 1;
							prnMsg( _('Cannot delete this item because there is currently some stock on hand'),'warn');
							echo '<BR>' . _('There are') . ' ' . $myrow[0] . ' ' . _('on hand for this part');
						}
					}
				}
			}
		}

	}
	if ($CancelDelete==0) {
		$result = DB_query('BEGIN', $db);

			/*Deletes LocStock records*/
			$sql ="DELETE FROM locstock WHERE stockid='$StockID'";
			$result=DB_query($sql,$db,_('Could not delete the location stock records because'),'',true);
			/*and cascade deletes in PurchData */
			$sql ="DELETE FROM purchdata WHERE stockid='$StockID'";
			$result=DB_query($sql,$db,_('Could not delete the purchasing data because'),'',true);
			/*and cascade delete the bill of material if any */
			$sql = "DELETE FROM bom WHERE parent='$StockID'";
			$result=DB_query($sql,$db,_('Could not delete the bill of material because'),'',true);
			$sql="DELETE FROM stockmaster WHERE stockid='$StockID'";
			$result=DB_query($sql,$db, _('Could not delete the item record'),'',true);

		$result = DB_query('COMMIT', $db);

		prnMsg(_('Deleted the stock master record for') . ' ' . $StockID . '....' . 
		'<BR>. . ' . _('and all the location stock records set up for the part') .
		'<BR>. . .' . _('and any bill of material that may have been set up for the part') . 
		'<BR> . . . .' . _('and any purchasing data that may have been set up for the part'),'success');
		unset($_POST['LongDescription']);
		unset($_POST['Description']);
		unset($_POST['EOQ']);
		unset($_POST['CategoryID']);
		unset($_POST['Units']);
		unset($_POST['MBFlag']);
		unset($_POST['Discontinued']);
		unset($_POST['Controlled']);
		unset($_POST['Serialised']);
		unset($_POST['Volume']);
		unset($_POST['KGS']);
		unset($_POST['BarCode']);
		unset($_POST['ReorderLevel']);
		unset($_POST['DiscountCategory']);
		unset($_POST['TaxLevel']);
		unset($_POST['DecimalPlaces']);
		unset($StockID);
		unset($_SESSION['SelectedStockItem']);
		//echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=" . $rootpath . '/SelectProduct.php?' . SID  ."'>";


	} //end if Delete Part
}


echo '<FORM ENCTYPE="MULTIPART/FORM-DATA" METHOD="POST" ACTION="' . $_SERVER['PHP_SELF'] . '?' .SID .'"><CENTER><TABLE>
	<TR><TD><TABLE>'; //Nested table

if (!isset($StockID) OR isset($_POST['New'])) {

/*If the page was called without $StockID passed to page then assume a new stock item is to be entered show a form with a part Code field other wise the form showing the fields with the existing entries against the part will show for editing with only a hidden StockID field. New is set to flag that the page may have called itself and still be entering a new part, in which case the page needs to know not to go looking up details for an existing part*/

	echo '<INPUT TYPE="HIDDEN" NAME="New" VALUE="Yes">';

	echo '<TR><TD>'. _('Item Code'). ':</TD><TD><INPUT TYPE="TEXT" NAME="StockID" SIZE=21 MAXLENGTH=20 Value="'.$StockID.'"></TD></TR>';

} elseif (!isset($_POST['submit'])) { // Must be modifying an existing item and no changes made yet

	$sql = "SELECT stockid,
			description,
			longdescription,
			categoryid,
			units,
			mbflag,
			discontinued,
			controlled,
			serialised,
			eoq,
			volume,
			kgs,
			barcode,
			discountcategory,
			taxlevel,
			decimalplaces
		FROM stockmaster
		WHERE stockid = '$StockID'";

	$result = DB_query($sql, $db);
	$myrow = DB_fetch_array($result);

	$_POST['LongDescription'] = $myrow['longdescription'];
	$_POST['Description'] = $myrow['description'];
	$_POST['EOQ']  = $myrow['eoq'];
	$_POST['CategoryID']  = $myrow['categoryid'];
	$_POST['Units']  = $myrow['units'];
	$_POST['MBFlag']  = $myrow['mbflag'];
	$_POST['Discontinued']  = $myrow['discontinued'];
	$_POST['Controlled']  = $myrow['controlled'];
	$_POST['Serialised']  = $myrow['serialised'];
	$_POST['Volume']  = $myrow['volume'];
	$_POST['KGS']  = $myrow['kgs'];
	$_POST['BarCode']  = $myrow['barcode'];
	$_POST['ReorderLevel']  = $myrow['reorderlevel'];
	$_POST['DiscountCategory']  = $myrow['discountcategory'];
	$_POST['TaxLevel'] = $myrow['taxlevel'];
	$_POST['DecimalPlaces'] = $myrow['decimalplaces'];

	echo '<TR><TD>' . _('Item Code') . ':</TD><TD>'.$StockID.'</TD></TR>';
	echo "<input type='Hidden' name='StockID' value='$StockID'>";
	
} else { // some changes were made to the data so don't re-set form variables to DB ie the code above
	echo '<TR><TD>' . _('Item Code') . ':</TD><TD>'.$StockID.'</TD></TR>';
	echo "<input type='Hidden' name='StockID' value='$StockID'>";
}
	

echo '<TR><TD>' . _('Part Description') . ' (' . _('short') . '):</TD><TD><input type="Text" name="Description" SIZE=52 MAXLENGTH=50 value="' . $_POST['Description'] . '"></TD></TR>';

echo '<TR><TD>' . _('Part Description') . ' (' . _('long') . '):</TD><TD><textarea name="LongDescription" cols=40 rows=4>' . $_POST['LongDescription'] . '</textarea></TD></TR>';

// Add image upload for New Item  - by Ori
echo '<TR><TD>'. _('Image File (.jpg)') . ':</TD><TD><input type="file" id="ItemPicture" name="ItemPicture"></TD></TR>';
// EOR Add Image upload for New Item  - by Ori

echo '<TR><TD>' . _('Category') . ':</TD><TD><SELECT name=CategoryID>';

$sql = "SELECT categoryid, categorydescription FROM stockcategory";
$ErrMsg = _('The stock categories could not be retrieved because');
$DbgMsg = _('The SQL used to retrieve stock categories and failed was');
$result = DB_query($sql,$db,$ErrMsg,$DbgMsg);

while ($myrow=DB_fetch_array($result)){
	if ($myrow['categoryid']==$_POST['CategoryID']){
		echo '<OPTION SELECTED VALUE="'. $myrow['categoryid'] . '">' . $myrow['categorydescription'];
	} else {
		echo '<OPTION VALUE="'. $myrow['categoryid'] . '">' . $myrow['categorydescription'];
	}
}

echo '</SELECT><a target="_blank" href="'. $rootpath . '/StockCategories.php?' . SID . '">' . _('Add or Modify Stock Categories') . '</a></TD></TR>';


if ($_POST['EOQ']=='' or !isset($_POST['EOQ'])){
    $_POST['EOQ']=0;
}

if ($_POST['Volume']=='' OR !isset($_POST['Volume'])){
    $_POST['Volume']=0;
}
if ($_POST['KGS']=='' OR !isset($_POST['KGS'])){
    $_POST['KGS']=0;
}
if ($_POST['Controlled']=='' OR !isset($_POST['Controlled'])){
    $_POST['Controlled']=0;
}
if ($_POST['Serialised']=='' OR !isset($_POST['Serialised']) || $_POST['Controlled']==0){
    $_POST['Serialised']=0;
}
if ($_POST['DecimalPlaces']=='' OR !isset($_POST['DecimalPlaces'])){
	$_POST['DecimalPlaces']=0;
}
if ($_POST['Discontinued']=='' OR !isset($_POST['Discontinued'])){
    $_POST['Discontinued']=0;
}


echo '<TR><TD>' . _('Economic Order Quantity') . ':</TD><TD><input type="Text" name="EOQ" SIZE=12 MAXLENGTH=10 Value="' . $_POST['EOQ'] . '"></TD></TR>';

echo '<TR><TD>' . _('Packaged Volume (metres cubed)') . ':</TD><TD><input type="Text" name="Volume" SIZE=12 MAXLENGTH=10 value="' . $_POST['Volume'] . '"></TD></TR>';

echo '<TR><TD>' . _('Packaged Weight (KGs)') . ':</TD><TD><input type="Text" name="KGS" SIZE=12 MAXLENGTH=10 value="' . $_POST['KGS'] . '"></TD></TR>';

echo '<TR><TD>' . _('Units of Measure') . ':</TD><TD><SELECT name="Units">';


$sql = 'SELECT unitname FROM unitsofmeasure ORDER by unitname';
$UOMResult = DB_query($sql,$db);

while( $UOMrow = DB_fetch_array($UOMResult) ) {
     if ($_POST['Units']==$UOMrow['unitname']){
	    echo "<OPTION SELECTED Value='" . $UOMrow['unitname'] . "'>" . $UOMrow['unitname'];
     } else {
	    echo "<OPTION Value='" . $UOMrow['unitname'] . "'>" . $UOMrow['unitname'];
     }
}

echo '</SELECT></TD></TR>';

echo '<TR><TD>' . _('Make, Buy, Kit, Assembly or Dummy Part') . ':</TD><TD><SELECT name="MBFlag">';
if ($_POST['MBFlag']=='A'){
	echo '<OPTION SELECTED VALUE="A">' . _('Assembly');
} else {
	echo '<OPTION VALUE="A">' . _('Assembly');
}
if ($_POST['MBFlag']=='K'){
	echo '<OPTION SELECTED VALUE="K">' . _('Kit');
} else {
	echo '<OPTION VALUE="K">' . _('Kit');
}
if ($_POST['MBFlag']=='M'){
	echo '<OPTION SELECTED VALUE="M">' . _('Manufactured');
} else {
	echo '<OPTION VALUE="M">' . _('Manufactured');
}
if ($_POST['MBFlag']=='B' OR !isset($_POST['MBFlag']) OR $_POST['MBFlag']==''){
	echo '<OPTION SELECTED VALUE="B">' . _('Purchased');
} else {
	echo '<OPTION VALUE="B">' . _('Purchased');
}

if ($_POST['MBFlag']=='D'){
	echo '<OPTION SELECTED VALUE="D">' . _('Dummy');
} else {
	echo '<OPTION VALUE="D">' . _('Dummy');
}

echo '</SELECT></TD></TR>';

echo '<TR><TD>' . _('Current or Obsolete') . ':</TD><TD><SELECT name="Discontinued">';
if ($_POST['Discontinued']==0){
	echo '<OPTION SELECTED VALUE=0>' . _('Current');
} else {
	echo '<OPTION VALUE=0>' . _('Current');
}
if ($_POST['Discontinued']==1){
	echo '<OPTION SELECTED VALUE=1>' . _('Obsolete');
} else {
	echo '<OPTION VALUE=1>' . _('Obsolete');
}
echo '</SELECT></TD></TR>';

echo '<TR><TD>' . _('Batch, Serial or Lot Control') . ':</TD><TD><SELECT name="Controlled">';

if ($_POST['Controlled']==0){
	echo '<OPTION SELECTED VALUE=0>' . _('No Control');
} else {
        echo '<OPTION VALUE=0>' . _('No Control');
}
if ($_POST['Controlled']==1){
	echo '<OPTION SELECTED VALUE=1>' . _('Controlled');
} else {
	echo "<OPTION VALUE=1>" . _('Controlled');
}
echo '</SELECT></TD></TR>';

echo '<TR><TD>' . _('Serialised') . ':</TD><TD><SELECT name="Serialised">';

if ($_POST['Serialised']==0){
        echo '<OPTION SELECTED VALUE=0>' . _('No');
} else {
        echo '<OPTION VALUE=0>' . _('No');
}
if ($_POST['Serialised']==1){
        echo '<OPTION SELECTED VALUE=1>' . _('Yes');
} else {
        echo '<OPTION VALUE=1>' . _('Yes');
}
echo '</SELECT><i>' . _('Note') . ', ' . _('this has no effect if the item is not Controlled') . '</i></TD></TR>';

echo '<TR><TD>' . _('Decimal Places to Display') . ':</TD><TD><input type="Text" name="DecimalPlaces" SIZE=1 MAXLENGTH=1 value="' . $_POST['DecimalPlaces'] . '"><TD></TR>';

echo '<TR><TD>' . _('Bar Code') . ':</TD><TD><input type="Text" name="BarCode" SIZE=22 MAXLENGTH=20 value="' . $_POST['BarCode'] . '"></TD></TR>';

echo '<TR><TD>' . _('Discount Category') . ':</TD><TD><input type="Text" name="DiscountCategory" SIZE=2 MAXLENGTH=2 value="' . $_POST['DiscountCategory'] . '"></TD></TR>';

if (!isset($_POST['TaxLevel'])){
	$_POST['TaxLevel']=1;
}

echo '<TR><TD>' . _('Tax Level') . ':</TD><TD><input type="Text" name="TaxLevel" SIZE=1 MAXLENGTH=1 value="' . $_POST['TaxLevel'] . '"></TD></TR>';

if (function_exists('imagecreatefrompng')){
	$StockImgLink = '<img src="GetStockImage.php?SID&automake=1&textcolor=FFFFFF&bgcolor=CCCCCC'.
		'&stockid='.urlencode($StockID.'.jpg').
		'&text='.
		'&width=64'.
		'&height=64'.
		'" >';
} else {
	if( file_exists($_SESSION['part_pics_dir'] . '/' .$StockID.'.jpg') ) {
		$StockImgLink = '<img src="'.$rootpath . '/' . $_SESSION['part_pics_dir'] . '/' .$StockID.'.jpg" >';
	} else {
		$StockImgLink = 'No Image';
	}
}

echo '</TABLE></TD><TD><CENTER>' . _('Image') . '<BR>'.$StockImgLink . '</CENTER></TD></TR></TABLE>';
	
//echo '</TABLE></TD><TD><CENTER>' . _('Image') . '<BR><img src=' . $rootpath . '/' . $_SESSION['part_pics_dir'] . '/' . $StockID . '.jpg' . '>' . '</CENTER></TD></TR></TABLE>';



if (isset($_POST['New']) OR $_POST['New']!="") {
	echo '<input type="Submit" name="submit" value="' . _('Insert New Item') . '">';

} else {

	echo '<input type="Submit" name="submit" value="' . _('Submit Alterations') . '">';
	echo '<P>';
	prnMsg( _('Only click the Delete button if you are sure you wish to delete the item') . '. ' . _('There is no second warning') . '! ' . _('Checks will be made to ensure that there are no stock movements, sales analysis records, sales order items or purchase order items for the item') . '. ' . _('No deletions will be allowed if they exist'), 'warn', 'WARNING');
	echo '<P><input type="Submit" name="delete" value="' . _('Delete This Item') . '">';

}

echo '</FORM></CENTER>';
include('includes/footer.inc');
?>
