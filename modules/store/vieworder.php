<?php
// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - View Account 1.0                 |
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

/* Check user has access to this module */

if (isset ($_SESSION['modules']) && (in_array('store', $_SESSION['modules']))) {
	/* Include the company class, and initialise */
	require_once (EGS_FILE_ROOT.'/src/classes/class.store.php');
	$store = new store();

	/* This is set to false if something is successfully saved */
	$saved = false;

	/* Get the order details from the database */
	$query = 'SELECT o.*,p.*, p.firstname || \' \' || p.surname AS customer, '.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 'created').' AS created FROM store_order o JOIN personoverview p ON (p.id=o.personid) WHERE o.id='.$db->qstr(intval($_GET['id'])).' AND o.companyid='.$db->qstr(EGS_COMPANY_ID);
	
	$orderDetails = $db->GetRow($query);

	/* Now actuall do the display if the results were successfully retrieved */
	if ($orderDetails !== false) {
		$query = 'SELECT sum(quantity) AS quantity FROM store_order_items WHERE orderid='.$db->qstr(intval($_GET['id']));
		$orderDetails['quantity']=$db->GetOne($query);
		$query = 'SELECT sum(quantity*price) FROM store_order_items WHERE orderid='.$db->qstr(intval($_GET['id']));
		$orderDetails['total']='&pound;'.number_format($db->GetOne($query),2,'.',',');
		/* Add to last viewed and sync the preferences */
		$_SESSION['preferences']['lastViewed'] = array_slice(array_merge(array ('module=store&amp;action=vieworder&amp;id='.intval($_GET['id']) => array ('store', $_GET['id'])), $_SESSION['preferences']['lastViewed']), 0, EGS_RECENTLY_VIEWED);
		$egs->syncPreferences();

		/* Set the title to the company name */
		$smarty->assign('pageTitle', _('Order: ').$_GET['id']);
		$smarty->assign('pageEdit', 'action=saveorder&amp;id='.intval($_GET['id']));
		/* Output the order details */
		$leftData = array ();
		$leftData[] = array ('tag' => _('Status'), 'data' => $orderDetails['status']);
		$leftData[] = array ('tag' => _('# Items'), 'data' => $orderDetails['quantity']);
		$leftData[] = array ('tag' => _('Total Cost'), 'data' => $orderDetails['total']);

		$leftData[] = array ('tag' => _('Customer'), 'data' => $orderDetails['customer']);
		$leftData[] = array ('tag' => _('Phone'), 'data' => $orderDetails['phone']);
		$leftData[] = array ('tag' => _('Fax'), 'data' => $orderDetails['fax']);
		$leftData[] = array ('tag' => _('Email'), 'data' => $orderDetails['email'], 'link' => 'mailto:'.$orderDetails['email']);
		$leftData[] = array ('span' => true);

		/* Format the address according to the users settings */
		foreach ($orderDetails as $key => $val) {
			if (strpos($key, 'shipping_')!==false) {
				$shippingDetails[str_replace('shipping_', '', $key)] = $val;
			}
			if (strpos($key, 'billing_')!==false)
				$billingDetails[str_replace('billing_', '', $key)] = $val;

		}
		$formattedBillingAddress = $egs->formatAddress($billingDetails);
		$formattedShippingAddress = $egs->formatAddress($shippingDetails);

		/* And output it */
		$leftData[] = array ('tag' => _('Billing Address'), 'data' => $formattedBillingAddress);
		
		$leftData[] = array ('tag' => _('Shipping Address'), 'data' => $formattedShippingAddress);
		

		/* Do the company owner/assigned details */
		$leftData[] = array ('tag' => _('Added'), 'data' => $orderDetails['created']);

		$rightSpan = array ();

		/* Get the items in the order */
		$query = 'SELECT id, name, productcode,oi.price, quantity, CASE WHEN oi.attributevalue IS NULL THEN \'(none)\' ELSE (SELECT name FROM store_product_attribute_value WHERE id=oi.attributevalue) END AS option from store_order_items oi JOIN store_product p ON (oi.productid=p.id) WHERE orderid='.$db->qstr(intval($_GET['id']));
		
		$rs = $db->Execute($query);
		
		/* Show new link if correct access */

		$items = array ('type' => 'data', 'title' => _('Items'), 'header' => array (_('Product'),_('Code'), _('Price'), _('Quantity'),_('Option')), 'viewlink' => 'action=viewproduct&amp;id=');
		/* Just show the title */

		/* Iterate over and show the items */
		while (!$rs->EOF) {
			$rs->fields['price']='&pound;'.number_format($rs->fields['price'],2,'.',',');
			$items['data'][] = $rs->fields;
			$rs->MoveNext();
		}

		$bottomData[] = $items;
		$rightData=array();
		/* Assign the data to the template */
		$smarty->assign('view', true);
		$smarty->assign('leftData', $leftData);
		$smarty->assign('rightData', $rightData);
		$smarty->assign('rightSpan', $rightSpan);
		$smarty->assign('bottomData', $bottomData);
		$smarty->assign('moduleIcon', 'company');

	} else {
		$smarty->assign('errors', array (_('You do not have the correct permissions to access this company. If you believe you should please contact your system administrator')));
		$smarty->assign('redirect', true);
		$smarty->assign('redirectAction', 'action=orderoverview');
	}
} else {
	$smarty->assign('errors', array (_('You do not have the correct permissions to access this company. If you believe you should please contact your system administrator')));
		$smarty->assign('redirect', true);
		$smarty->assign('redirectAction', '');
}
?>