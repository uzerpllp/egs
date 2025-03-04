<?php
/* $Revision: 1.5 $ */
/* Definition of the Supplier Transactions class to hold all the information for an accounts payable invoice or credit note
*/

Class SuppTrans {

	var $GRNs; /*array of objects of class GRNs using the GRN No as the pointer */
	var $GLCodes; /*array of objects of class GLCodes using a counter as the pointer */
	var $Shipts;  /*array of objects of class Shipments using a counter as the pointer */
	var $SupplierID;
	var $SupplierName;
	var $CurrCode;
	var $TermsDescription;
	var $Terms;
	var $TaxDescription;
	var $TaxRate;
	var $TaxGLCode;
	var $GLLink_Creditors;
	var $GRNAct;
	var $CreditorsAct;
	var $InvoiceOrCredit;
	var $ExRate;
	var $Comments;
	var $TranDate;
	var $DueDate;
	var $SuppReference;
	var $OvAmount;
	var $OvGST;
	var $GLCodesCounter=0;
	var $ShiptsCounter=0;

	function SuppTrans(){
	/*Constructor function initialises a new Supplier Transaction object */
		$this->GRNs = array();
		$this->GLCodes = array();
		$this->Shipts = array();
	}

	function Add_GRN_To_Trans($GRNNo, $PODetailItem, $ItemCode, $ItemDescription, $QtyRecd, $Prev_QuantityInv, $This_QuantityInv, $OrderPrice, $ChgPrice, $Complete, $StdCostUnit, $ShiptRef, $JobRef, $GLCode){
		if ($This_QuantityInv!=0 && isset($This_QuantityInv)){
			$this->GRNs[$GRNNo] = new GRNs($GRNNo, $PODetailItem, $ItemCode, $ItemDescription, $QtyRecd, $Prev_QuantityInv, $This_QuantityInv, $OrderPrice, $ChgPrice, $Complete, $StdCostUnit, $ShiptRef, $JobRef, $GLCode);
			Return 1;
		}
		Return 0;
	}

	function Modify_GRN_To_Trans($GRNNo, $PODetailItem, $ItemCode, $ItemDescription, $QtyRecd, $Prev_QuantityInv, $This_QuantityInv, $OrderPrice, $ChgPrice, $Complete, $StdCostUnit, $ShiptRef, $JobRef, $GLCode){
		if ($This_QuantityInv!=0 && isset($This_QuantityInv)){
			$this->GRNs[$GRNNo]->Modify($PODetailItem, $ItemCode, $ItemDescription, $QtyRecd, $Prev_QuantityInv, $This_QuantityInv, $OrderPrice, $ChgPrice, $Complete, $StdCostUnit, $ShiptRef, $JobRef, $GLCode);
			Return 1;
		}
		Return 0;
	}

	function Copy_GRN_To_Trans($GRNSrc){
		if ($GRNSrc->This_QuantityInv!=0 && isset($GRNSrc->This_QuantityInv)){
			$this->GRNs[$GRNSrc->GRNNo] = new GRNs($GRNSrc->GRNNo, $GRNSrc->PODetailItem, $GRNSrc->ItemCode, $GRNSrc->ItemDescription, $GRNSrc->QtyRecd, $GRNSrc->Prev_QuantityInv, $GRNSrc->This_QuantityInv, $GRNSrc->OrderPrice, $GRNSrc->ChgPrice, $GRNSrc->Complete, $GRNSrc->StdCostUnit, $GRNSrc->ShiptRef, $GRNSrc->JobRef, $GRNSrc->GLCode);
			Return 1;
		}
		Return 0;
	}

	function Add_GLCodes_To_Trans($GLCode, $GLActName, $Amount, $JobRef, $Narrative){
		if ($Amount!=0 AND isset($Amount)){
			$this->GLCodes[$this->GLCodesCounter] = new GLCodes($this->GLCodesCounter, $GLCode, $GLActName, $Amount, $JobRef, $Narrative);
			$this->GLCodesCounter++;
			Return 1;
		}
		Return 0;
	}

	function Add_Shipt_To_Trans($ShiptRef, $Amount){
		if ($Amount!=0){
			$this->Shipts[$this->ShiptCounter] = new Shipment($this->ShiptCounter, $ShiptRef, $Amount);
			$this->ShiptCounter++;
			Return 1;
		}
		Return 0;
	}

	function Remove_GRN_From_Trans(&$GRNNo){
	     unset($this->GRNs[$GRNNo]);
	}
	function Remove_GLCodes_From_Trans(&$GLCodeCounter){
	     unset($this->GLCodes[$GLCodeCounter]);
	}
	function Remove_Shipt_From_Trans(&$ShiptCounter){
	     unset($this->Shipts[$ShiptCounter]);
	}

} /* end of class defintion */

Class GRNs {

/* Contains relavent information from the PurchOrderDetails as well to provide in cached form,
all the info to do the necessary entries without looking up ie additional queries of the database again */

	var $GRNNo;
	var $PODetailItem;
	var $ItemCode;
	var $ItemDescription;
	var $QtyRecd;
	var $Prev_QuantityInv;
	var $This_QuantityInv;
	var $OrderPrice;
	var $ChgPrice;
	var $Complete;
	var $StdCostUnit;
	var $ShiptRef;
	var $JobRef;
	var $GLCode;

	function GRNs ($GRNNo, $PODetailItem, $ItemCode, $ItemDescription, $QtyRecd, $Prev_QuantityInv, $This_QuantityInv, $OrderPrice, $ChgPrice, $Complete, $StdCostUnit, $ShiptRef, $JobRef, $GLCode){

	/* Constructor function to add a new GRNs object with passed params */
		$this->GRNNo = $GRNNo;
		$this->PODetailItem = $PODetailItem;
		$this->ItemCode = $ItemCode;
		$this->ItemDescription = $ItemDescription;
		$this->QtyRecd = $QtyRecd;
		$this->Prev_QuantityInv = $Prev_QuantityInv;
		$this->This_QuantityInv = $This_QuantityInv;
		$this->OrderPrice =$OrderPrice;
		$this->ChgPrice = $ChgPrice;
		$this->Complete = $Complete;
		$this->StdCostUnit = $StdCostUnit;
		$this->ShiptRef = $ShiptRef;
		$this->JobRef = $JobRef;
		$this->GLCode = $GLCode;
	}

	function Modify ($PODetailItem, $ItemCode, $ItemDescription, $QtyRecd, $Prev_QuantityInv, $This_QuantityInv, $OrderPrice, $ChgPrice, $Complete, $StdCostUnit, $ShiptRef, $JobRef, $GLCode){

	/* Modify function to edit a GRNs object with passed params */
		$this->PODetailItem = $PODetailItem;
		$this->ItemCode = $ItemCode;
		$this->ItemDescription = $ItemDescription;
		$this->QtyRecd = $QtyRecd;
		$this->Prev_QuantityInv = $Prev_QuantityInv;
		$this->This_QuantityInv = $This_QuantityInv;
		$this->OrderPrice =$OrderPrice;
		$this->ChgPrice = $ChgPrice;
		$this->Complete = $Complete;
		$this->StdCostUnit = $StdCostUnit;
		$this->ShiptRef = $ShiptRef;
		$this->JobRef = $JobRef;
		$this->GLCode = $GLCode;
	}
}


Class GLCodes {

	Var $Counter;
	Var $GLCode;
	Var $GLActName;
	Var $Amount;
	Var $JobRef;
	Var $Narrative;

	function GLCodes ($Counter, $GLCode, $GLActName, $Amount, $JobRef, $Narrative){

	/* Constructor function to add a new GLCodes object with passed params */
		$this->Counter = $Counter;
		$this->GLCode = $GLCode;
		$this->GLActName = $GLActName;
		$this->Amount = $Amount;
		$this->JobRef = $JobRef;
		$this->Narrative= $Narrative;
	}
}

Class Shipment {

	Var $Counter;
	Var $ShiptRef;
	Var $Amount;

	function Shipment ($Counter, $ShiptRef, $Amount){
		$this->Counter = $Counter;
		$this->ShiptRef = $ShiptRef;
		$this->Amount = $Amount;
	}
}
?>
