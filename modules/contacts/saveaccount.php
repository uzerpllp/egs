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

/* Check user has access to the contacts and crm module */
if (in_array('contacts', $_SESSION['modules'])) {
	/* This is set to try if the company was saved */
	$saved = false;
	$select = false;
	$id = null;

	/* Set the id if set */
	if (isset ($_GET['id']))
		$id = intval($_GET['id']);
	if (isset ($_POST['id']))
		$id = ($_POST['id']);
	if (isset ($_GET['branchcompanyid']))
		$branchCompanyId = intval($_GET['branchcompanyid']);
	if (isset ($_POST['branchcompanyid']))
		$branchCompanyId = intval($_POST['branchcompanyid']);

	require_once (EGS_FILE_ROOT.'/src/classes/class.company.php');

	$company = new company();

	/* Do a save if the form has been posted */
	if (sizeof($_POST) > 0) {
		/* Check the post array */
		$egs->checkPost();

		if(!isset($_POST['branchcompanyid']) && isset($branchCompanyId)) unset($branchCompanyId);
		if(isset($_POST['delete'])) $saved = $company->deleteCompany($id);
		else $saved = $company->saveCompany($_POST, $id);
	}

	if ($saved) {
		$smarty->assign('redirect', true);
		if(!isset($_POST['delete'])) $smarty->assign('redirectAction', 'action=view&amp;id='.$_POST['id']);
	} else {
		/* Set up arrays to hold form elements */
		$leftForm = array ();
		$rightForm = array ();
		$bottomForm = array ();

		if (isset ($id)) {

			if (($company->accessLevel($id) > 2) && (sizeof($_POST) == 0)) {
				$query = 'SELECT * FROM companyoverview WHERE id='.$db->qstr($id);

				$_POST = $db->GetRow($query);

				if (in_array('crm', $_SESSION['modules'])) {
					$query = 'SELECT * FROM companycrm WHERE companyid='.$db->qstr($id).' AND usercompanyid='.$db->qstr(EGS_COMPANY_ID);

					$_POST = array_merge($_POST, $db->getRow($query));
				}
				
				if(isset($_POST['branchcompanyid'])) $branchCompanyId = $_POST['branchcompanyid'];

				$select = true;
			} else if (sizeof($_POST) == 0){
			$smarty->assign('errors', array (_('You do not have the correct access to edit this company. If you beleive you should please contact your system administrator')));
			$smarty->assign('redirect', true);
			$smarty->assign('redirectAction', 'action=view&amp;id='.$id);
			
			return false;
		}
		} else if(isset($branchCompanyId)) {
			if($company->accessLevel($branchCompanyId) < 3) {
				$smarty->assign('errors', array (_('You do not have the correct access to add a branch to this company. If you beleive you should please contact your system administrator')));
			$smarty->assign('redirect', true);
			$smarty->assign('redirectAction', 'action=view&amp;id='.$branchCompanyId);
			
			return false;
			}
		}

			/* Set up the title */
			if (isset ($id))
				$smarty->assign('pageTitle', _('Save Changes to Account'));
			else
				$smarty->assign('pageTitle', _('Save New Account'));

			if(isset($id) && ($company->accessLevel($id) > 3)) $smarty->assign('formDelete', true);
			
			/* Build the form */

			$hidden = array ();
			if (isset ($id))
				$hidden['id'] = $id;

			$smarty->assign('hidden', $hidden);

			/* Set the title */
			$item = array ();
			$item['type'] = 'title';
			$item['tag'] = _('Address Details');

			$leftForm[] = $item;

			/* Set the title */
			$item = array ();
			$item['type'] = 'title';
			$item['tag'] = '';
			$rightForm[] = $item;

			/* Setup the name */
			$item = array ();
			$item['type'] = 'text';
			$item['tag'] = _('Name');
			$item['name'] = 'name';
			if (isset ($_POST['name']))
				$item['value'] = $_POST['name'];
			$item['compulsory'] = true;

			$leftForm[] = $item;

			if (isset ($branchCompanyId)) {
				$query = 'SELECT name FROM company WHERE id='.$db->qstr($branchCompanyId);

				$_POST['branchcompanyname'] = $db->GetOne($query);
			}

			/* Setup the branch */
			$item = array ();
			$item['type'] = 'company';
			$item['tag'] = _('Attach to');
			$item['name'] = 'branchcompany';
			if (isset ($_POST['branchcompanyname']))
				$item['value'] = $_POST['branchcompanyname'];
			if (isset ($branchCompanyId))
				$item['actualvalue'] = $branchCompanyId;

			$leftForm[] = $item;

			/* Setup the user it is assigned to */
			$item = array ();

			$query = 'SELECT username FROM useraccess WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY username';

			$users = $db->query($query);

			if (!$users && EGS_DEBUG_SQL)
				die($db->ErrorMsg());

			$item['options'] = array ();

			while (!$users->EOF) {
				$item['options'][$users->fields['username']] = $users->fields['username'];
				$users->MoveNext();
			}

			$item['type'] = 'select';
			$item['tag'] = _('Assigned To');
			$item['name'] = 'assigned';
			if (isset ($_POST['assigned']))
				$item['value'] = $_POST['assigned'];
			else
				$item['value'] = EGS_USERNAME;

			$leftForm[] = $item;

			/* Setup the contact details */
			$item = array ();
			$item['type'] = 'text';
			$item['tag'] = _('Website');
			$item['name'] = 'www';
			if (isset ($_POST['www']))
				$item['value'] = $_POST['www'];

			$leftForm[] = $item;

			$item = array ();
			$item['type'] = 'text';
			$item['tag'] = _('Phone');
			$item['name'] = 'phone';
			if (isset ($_POST['phone']))
				$item['value'] = $_POST['phone'];

			$leftForm[] = $item;

			$item = array ();
			$item['type'] = 'text';
			$item['tag'] = _('Fax');
			$item['name'] = 'fax';
			if (isset ($_POST['fax']))
				$item['value'] = $_POST['fax'];

			$leftForm[] = $item;

			$item = array ();
			$item['type'] = 'text';
			$item['tag'] = _('Email');
			$item['name'] = 'email';
			if (isset ($_POST['email']))
				$item['value'] = $_POST['email'];

			$leftForm[] = $item;

			/* Set up the address */
			$item = array ();
			$item['type'] = 'text';
			$item['tag'] = _('Street 1');
			$item['name'] = 'street1';
			if (isset ($_POST['street1']))
				$item['value'] = $_POST['street1'];

			$rightForm[] = $item;

			$item = array ();
			$item['type'] = 'text';
			$item['tag'] = _('Street 2');
			$item['name'] = 'street2';
			if (isset ($_POST['street2']))
				$item['value'] = $_POST['street2'];

			$rightForm[] = $item;

			$item = array ();
			$item['type'] = 'text';
			$item['tag'] = _('Street 3');
			$item['name'] = 'street3';
			if (isset ($_POST['street3']))
				$item['value'] = $_POST['street3'];

			$rightForm[] = $item;

			$item = array ();
			$item['type'] = 'text';
			$item['tag'] = _('Town');
			$item['name'] = 'town';
			if (isset ($_POST['town']))
				$item['value'] = $_POST['town'];

			$rightForm[] = $item;

			$item = array ();
			$item['type'] = 'text';
			$item['tag'] = _('County');
			$item['name'] = 'county';
			if (isset ($_POST['county']))
				$item['value'] = $_POST['county'];

			$rightForm[] = $item;

			$item = array ();
			$item['type'] = 'text';
			$item['tag'] = _('Postcode');
			$item['name'] = 'postcode';
			if(defined('EGS_LICENSE_CODE') && EGS_LICENSE_CODE!='' && defined('EGS_LICENSE_KEY') && EGS_LICENSE_KEY!='')
				$item['lookup']=true;
			if (isset ($_POST['postcode']))
				$item['value'] = $_POST['postcode'];

			$rightForm[] = $item;

			/* Setup the countries */
			$item = array ();

			$query = 'SELECT code, name FROM country ORDER BY name';

			$countries = $db->query($query);

			if (!$countries && EGS_DEBUG_SQL)
				die($db->ErrorMsg());

			$item['options'] = array ();

			while (!$countries->EOF) {
				$item['options'][$countries->fields['code']] = $countries->fields['name'];
				$countries->MoveNext();
			}

			$item['type'] = 'select';
			$item['tag'] = _('Country');
			$item['name'] = 'countrycode';
			if (isset ($_POST['countrycode']))
				$item['value'] = $_POST['countrycode'];
			else $item['value']=EGS_DEFAULT_COUNTRY;
			$rightForm[] = $item;

			/* Set the title */
			$item = array ();
			$item['type'] = 'title';
			$item['tag'] = _('Account Details');

			$leftForm[] = $item;

			$item = array ();
			$item['type'] = 'title';
			$item['tag'] = '';
			$rightForm[] = $item;

			/* Set the CRM Details */
			$item = array ();
			$item['type'] = 'text';
			$item['tag'] = _('Account Num.');
			$item['name'] = 'accountnumber';
			if (isset ($_POST['accountnumber']))
				$item['value'] = $_POST['accountnumber'];
			$item['compulsory'] = true;

			$leftForm[] = $item;

			$item = array ();
			$item['type'] = 'text';
			$item['tag'] = _('Company Num.');
			$item['name'] = 'companynumber';
			if (isset ($_POST['companynumber']))
				$item['value'] = $_POST['companynumber'];

			$leftForm[] = $item;

			$item = array ();
			$item['type'] = 'text';
			$item['tag'] = _('VAT Num.');
			$item['name'] = 'vatnumber';
			if (isset ($_POST['vatnumber']))
				$item['value'] = $_POST['vatnumber'];

			$leftForm[] = $item;

			if (in_array('crm', $_SESSION['modules'])) {
				$item = array ();
				$item['type'] = 'text';
				$item['tag'] = _('SIC Code');
				$item['name'] = 'siccode';
				if (isset ($_POST['siccode']))
					$item['value'] = $_POST['siccode'];
	
				$leftForm[] = $item;
	
				$item = array ();
				$item['type'] = 'text';
				$item['tag'] = _('Stock Symbol');
				$item['name'] = 'stocksymbol';
				if (isset ($_POST['stocksymbol']))
					$item['value'] = $_POST['stocksymbol'];
	
				$leftForm[] = $item;
	
				$item = array ();
				$item['type'] = 'text';
				$item['tag'] = _('Revenue (&pound;)');
				$item['name'] = 'revenue';
				if (isset ($_POST['revenue']))
					$item['value'] = $_POST['revenue'];
	
				$leftForm[] = $item;
	
				/* Setup the statuses */
				$item = array ();
	
				$query = 'SELECT id, name FROM crmstatus WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY id';
	
				$status = $db->query($query);
	
				if (!$status && EGS_DEBUG_SQL)
					die($db->ErrorMsg());
	
				$item['options'] = array ('' => _('None'));
	
				while (!$status->EOF) {
					$item['options'][$status->fields['id']] = $status->fields['name'];
					$status->MoveNext();
				}
	
				$item['type'] = 'select';
				$item['tag'] = _('Status');
				$item['name'] = 'crmstatusid';
				if (isset ($_POST['crmstatusid']))
					$item['value'] = $_POST['crmstatusid'];
	
				$rightForm[] = $item;
	
				/* Setup the rating */
				$item = array ();
	
				$query = 'SELECT id, name FROM crmrating WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY id';
	
				$rating = $db->query($query);
	
				if (!$rating && EGS_DEBUG_SQL)
					die($db->ErrorMsg());
	
				$item['options'] = array ('' => _('None'));
	
				while (!$rating->EOF) {
					$item['options'][$rating->fields['id']] = $rating->fields['name'];
					$rating->MoveNext();
				}
	
				$item['type'] = 'select';
				$item['tag'] = _('Rating');
				$item['name'] = 'crmratingid';
				if (isset ($_POST['crmratingid']))
					$item['value'] = $_POST['crmratingid'];
	
				$rightForm[] = $item;
	
				/* Setup the source */
				$item = array ();
	
				$query = 'SELECT id, name FROM crmcompanysource WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY name';
	
				$rating = $db->query($query);
	
				if (!$rating && EGS_DEBUG_SQL)
					die($db->ErrorMsg());
	
				$item['options'] = array ('' => _('None'));
	
				while (!$rating->EOF) {
					$item['options'][$rating->fields['id']] = $rating->fields['name'];
					$rating->MoveNext();
				}
	
				$item['type'] = 'select';
				$item['tag'] = _('Source');
				$item['name'] = 'crmsourceid';
				if (isset ($_POST['crmsourceid']))
					$item['value'] = $_POST['crmsourceid'];
	
				$rightForm[] = $item;
	
				/* Setup the industry */
				$item = array ();
	
				$query = 'SELECT id, name FROM crmindustry WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY name';
	
				$rating = $db->query($query);
	
				if (!$rating && EGS_DEBUG_SQL)
					die($db->ErrorMsg());
	
				$item['options'] = array ('' => _('None'));
	
				while (!$rating->EOF) {
					$item['options'][$rating->fields['id']] = $rating->fields['name'];
					$rating->MoveNext();
				}
	
				$item['type'] = 'select';
				$item['tag'] = _('Industry');
				$item['name'] = 'crmindustryid';
				if (isset ($_POST['crmindustryid']))
					$item['value'] = $_POST['crmindustryid'];
	
				$rightForm[] = $item;
			}

			/* Setup the employees */
			$item = array ();

			$item['type'] = 'select';
			$item['tag'] = _('Employees');
			$item['name'] = 'employees';
			$item['options'] = $employees;

			if (isset ($_POST['employees']))
				$item['value'] = $_POST['employees'];

			$rightForm[] = $item;

			/* Setup the company type */
			$item = array ();

			$item['type'] = 'select';
			$item['tag'] = _('Company Type');
			$item['name'] = 'companytype';
			$item['options'] = $companyTypes;

			if (isset ($_POST['companytype']))
				$item['value'] = $_POST['companytype'];

			$rightForm[] = $item;
			
			if (!in_array('crm', $_SESSION['modules'])) {
				$item = array();
				$item['type'] = 'space';

				$rightForm[] = $item;
			}

			if ($db->GetOne('SELECT tablename FROM pg_tables WHERE schemaname=\'company'.EGS_COMPANY_ID.'\' AND tablename LIKE \'erp%\'') && in_array('weberp', $_SESSION['modules'])) {
				/* Get the erp details */
				if ($select) {
					$query = 'SELECT * FROM company'.EGS_COMPANY_ID.'.erpdetails WHERE companyid='.$db->qstr($id);

					$_POST = $db->GetRow($query);

					$query = 'SELECT * FROM company'.EGS_COMPANY_ID.'.erpbranchdetails WHERE companyid='.$db->qstr($id);

					$_POST = array_merge($_POST, $db->GetRow($query));
				}

				/* Set the title */
				$item = array ();
				$item['type'] = 'title';
				$item['tag'] = _('Invoicing Details');
				$item['checkbox'] = true;
				$item['name'] = 'iscustomer';
				if (isset ($_POST['currcode'])) {
					$item['checked'] = true;
					$item['readonly'] = true;
				}
				$leftForm[] = $item;

				$item = array ();
				$item['type'] = 'title';
				$item['tag'] = '';
				$rightForm[] = $item;

				/* Setup the sales type */
				$item = array ();

				$query = 'SELECT typeabbrev, sales_type FROM company'.EGS_COMPANY_ID.'.salestypes ORDER BY sales_type';

				$salestype = $db->query($query);

				if (!$salestype && EGS_DEBUG_SQL)
					die($db->ErrorMsg());

				$item['options'] = array ();

				while (!$salestype->EOF) {
					$item['options'][$salestype->fields['typeabbrev']] = $salestype->fields['sales_type'];
					$salestype->MoveNext();
				}

				$item['type'] = 'select';
				$item['tag'] = _('Sales Type');
				$item['name'] = 'salestype';
				if (isset ($_POST['salestype']))
					$item['value'] = $_POST['salestype'];

				$leftForm[] = $item;

				/* Setup the discount */
				$item = array ();
				$item['type'] = 'text';
				$item['tag'] = _('Discount');
				$item['name'] = 'discount';
				$item['suffix'] = '%';
				if (isset ($_POST['discount']))
					$item['value'] = $_POST['discount'];

				$leftForm[] = $item;

				/* Setup the discount code */
				$item = array ();
				$item['type'] = 'text';
				$item['tag'] = _('Discount Code');
				$item['name'] = 'discountcode';
				if (isset ($_POST['discountcode']))
					$item['value'] = $_POST['discountcode'];

				$leftForm[] = $item;

				/* Setup the payment discount */
				$item = array ();
				$item['type'] = 'text';
				$item['tag'] = _('Payment Discount');
				$item['name'] = 'pymtdiscount';
				$item['suffix'] = '%';
				if (isset ($_POST['pymtdiscount']))
					$item['value'] = $_POST['pymtdiscount'];

				$leftForm[] = $item;

				/* Setup the currency */
				$item = array ();

				$query = 'SELECT currabrev, currency FROM company'.EGS_COMPANY_ID.'.currencies ORDER BY currency';

				$currency = $db->query($query);

				if (!$currency && EGS_DEBUG_SQL)
					die($db->ErrorMsg());

				$item['options'] = array ();

				while (!$currency->EOF) {
					$item['options'][$currency->fields['currabrev']] = $currency->fields['currency'];
					$currency->MoveNext();
				}

				$currencies = $item['options'];

				$item['type'] = 'select';
				$item['tag'] = _('Currency');
				$item['name'] = 'customercurrcode';
				if (isset ($_POST['customercurrcode']))
					$item['value'] = $_POST['customercurrcode'];
				if (isset ($_POST['currcode']))
					$item['value'] = $_POST['currcode'];

				$leftForm[] = $item;

				/* Setup the credit limit */
				$item = array ();
				$item['type'] = 'text';
				$item['tag'] = _('Credit Limit');
				$item['name'] = 'creditlimit';
				if (isset ($_POST['creditlimit']))
					$item['value'] = $_POST['creditlimit'];

				$leftForm[] = $item;

				/* Setup the payment terms */
				$item = array ();

				$query = 'SELECT termsindicator, terms FROM company'.EGS_COMPANY_ID.'.paymentterms ORDER BY termsindicator';

				$terms = $db->query($query);

				if (!$terms && EGS_DEBUG_SQL)
					die($db->ErrorMsg());

				$item['options'] = array ();

				while (!$terms->EOF) {
					$item['options'][$terms->fields['termsindicator']] = $terms->fields['terms'];
					$terms->MoveNext();
				}

				$item['type'] = 'select';
				$item['tag'] = _('Payment Terms');
				$item['name'] = 'paymentterms';
				if (isset ($_POST['paymentterms']))
					$item['value'] = $_POST['paymentterms'];

				$paymentTerms = $item['options'];

				$leftForm[] = $item;

				/* Setup the account status */
				$item = array ();

				$query = 'SELECT id, name FROM crmaccountstatus WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY id';

				$accountstatus = $db->query($query);

				if (!$accountstatus && EGS_DEBUG_SQL)
					die($db->ErrorMsg());

				$item['options'] = array ();

				while (!$accountstatus->EOF) {
					$item['options'][$accountstatus->fields['id']] = $accountstatus->fields['name'];
					$accountstatus->MoveNext();
				}

				$item['type'] = 'select';
				$item['tag'] = _('Account Status');
				$item['name'] = 'holdreason';
				if (isset ($_POST['holdreason']))
					$item['value'] = $_POST['holdreason'];

				$leftForm[] = $item;

				/* Setup the delivery days */
				$item = array ();
				$item['type'] = 'text';
				$item['tag'] = _('Delivery Days');
				$item['name'] = 'estdeliverydays';
				if (isset ($_POST['estdeliverydays']))
					$item['value'] = $_POST['estdeliverydays'];

				$rightForm[] = $item;

				/* Setup the forward date */
				$item = array ();
				$item['type'] = 'text';
				$item['tag'] = _('Forward Date After (day in month)');
				$item['name'] = 'fwddate';
				if (isset ($_POST['fwddate']))
					$item['value'] = $_POST['fwddate'];

				$rightForm[] = $item;

				/* Setup the sales area */
				$item = array ();

				$query = 'SELECT areacode, areadescription FROM company'.EGS_COMPANY_ID.'.areas ORDER BY areadescription';

				$salesarea = $db->query($query);

				if (!$salesarea && EGS_DEBUG_SQL)
					die($db->ErrorMsg());

				$item['options'] = array ();

				while (!$salesarea->EOF) {
					$item['options'][$salesarea->fields['areacode']] = $salesarea->fields['areadescription'];
					$salesarea->MoveNext();
				}

				$item['type'] = 'select';
				$item['tag'] = _('Sales Area');
				$item['name'] = 'area';
				if (isset ($_POST['area']))
					$item['value'] = $_POST['area'];

				$rightForm[] = $item;

				/* Setup the default location */
				$item = array ();

				$query = 'SELECT loccode, locationname FROM company'.EGS_COMPANY_ID.'.locations ORDER BY locationname';

				$locations = $db->query($query);

				if (!$locations && EGS_DEBUG_SQL)
					die($db->ErrorMsg());

				$item['options'] = array ();

				while (!$locations->EOF) {
					$item['options'][$locations->fields['loccode']] = $locations->fields['locationname'];
					$locations->MoveNext();
				}

				$item['type'] = 'select';
				$item['tag'] = _('Default Locations');
				$item['name'] = 'defaultlocation';
				if (isset ($_POST['defaultlocation']))
					$item['value'] = $_POST['defaultlocation'];

				$rightForm[] = $item;

				/* Setup the tax authority */
				$item = array ();

				$query = 'SELECT taxid, description FROM company'.EGS_COMPANY_ID.'.taxauthorities ORDER BY description';

				$tax = $db->query($query);

				if (!$tax && EGS_DEBUG_SQL)
					die($db->ErrorMsg());

				$item['options'] = array ();

				while (!$tax->EOF) {
					$item['options'][$tax->fields['taxid']] = $tax->fields['description'];
					$tax->MoveNext();
				}

				$taxAuthority = $item['options'];

				$item['type'] = 'select';
				$item['tag'] = _('Tax Authority');
				$item['name'] = 'customertaxauthority';
				if (isset ($_POST['customertaxauthority']))
					$item['value'] = $_POST['customertaxauthority'];
				if (isset ($_POST['taxauthority']))
					$item['value'] = $_POST['taxauthority'];

				$rightForm[] = $item;

				/* Enable/Disable transaction */
				$item = array ();

				$item['options']['0'] = _('Enabled');
				$item['options']['1'] = _('Disabled');

				$item['type'] = 'select';
				$item['tag'] = _('Disable transactions');
				$item['name'] = 'disabletrans';
				if (isset ($_POST['disabletrans']))
					$item['value'] = $_POST['disabletrans'];

				$rightForm[] = $item;

				/* Setup the default shipper */
				$item = array ();

				$query = 'SELECT shipper_id, shippername FROM company'.EGS_COMPANY_ID.'.shippers ORDER BY shippername';

				$shipper = $db->query($query);

				if (!$shipper && EGS_DEBUG_SQL)
					die($db->ErrorMsg());

				$item['options'] = array ();

				while (!$shipper->EOF) {
					$item['options'][$shipper->fields['shipper_id']] = $shipper->fields['shippername'];
					$shipper->MoveNext();
				}

				$item['type'] = 'select';
				$item['tag'] = _('Default freight company');
				$item['name'] = 'defaultshipvia';
				if (isset ($_POST['defaultshipvia']))
					$item['value'] = $_POST['defaultshipvia'];

				$rightForm[] = $item;

				/* Setup the branch code */
				$item = array ();
				$item['type'] = 'text';
				$item['tag'] = _('Customers Internal Branch Code (EDI)');
				$item['name'] = 'custbranchcode';
				if (isset ($_POST['custbranchcode']))
					$item['value'] = $_POST['custbranchcode'];

				$rightForm[] = $item;

				/* Get the erp details */
				if ($select) {
					$query = 'SELECT *, taxauthority AS suppliertaxauthority, paymentterms AS supplierpaymentterms FROM company'.EGS_COMPANY_ID.'.erpsupplierdetails WHERE companyid='.$db->qstr($id);
					$_POST = $db->GetRow($query);
				}

				/* Set the title */
				$item = array ();
				$item['type'] = 'title';
				$item['tag'] = _('Supplier Details');
				$item['checkbox'] = true;
				$item['name'] = 'issupplier';
				if (isset ($_POST['remittance'])) {
					$item['checked'] = true;
					$item['readonly'] = true;
				}

				$leftForm[] = $item;

				$item = array ();
				$item['type'] = 'title';
				$item['tag'] = '';
				$rightForm[] = $item;

				/* Setup the currency */
				$item = array ();

				$item['options'] = $currencies;
				$item['type'] = 'select';
				$item['tag'] = _('Currency');
				$item['name'] = 'currcode';
				if (isset ($_POST['currcode']))
					$item['value'] = $_POST['currcode'];

				$leftForm[] = $item;

				/* Setup the payment terms */
				$item = array ();

				$item['options'] = $paymentTerms;
				$item['type'] = 'select';
				$item['tag'] = _('Payment Terms');
				$item['name'] = 'supplierpaymentterms';
				if (isset ($_POST['supplierpaymentterms']))
					$item['value'] = $_POST['supplierpaymentterms'];

				$leftForm[] = $item;

				/* Setup the tax authority */
				$item = array ();

				$item['options'] = $taxAuthority;
				$item['type'] = 'select';
				$item['tag'] = _('Tax Authority');
				$item['name'] = 'suppliertaxauthority';
				if (isset ($_POST['suppliertaxauthority']))
					$item['value'] = $_POST['suppliertaxauthority'];

				$leftForm[] = $item;

				$item = array ();

				$query = 'SELECT id, firstname || \' \' || surname AS name FROM person WHERE companyid='.$db->qstr(intval($id)).' ORDER BY name';

				$contact = $db->query($query);

				$item['options'] = array ('' => _('None'));

				while (!$contact->EOF) {
					$item['options'][$contact->fields['id']] = $contact->fields['name'];
					$contact->MoveNext();
				}

				$item['type'] = 'select';
				$item['tag'] = _('Supplier Contact');
				$item['name'] = 'suppliercontact';
				if (isset ($_POST['suppliercontact']))
					$item['value'] = $_POST['suppliercontact'];

				$leftForm[] = $item;

				/* Remitance Advice */
				$item = array ();

				$item['options']['1'] = _('Not Required');
				$item['options']['0'] = _('Required');

				$item['type'] = 'select';
				$item['tag'] = _('Remittance Advice');
				$item['name'] = 'remittance';
				if (isset ($_POST['remittance']))
					$item['value'] = $_POST['remittance'];

				$rightForm[] = $item;

				/* Setup the bank details */
				$item = array ();
				$item['type'] = 'text';
				$item['tag'] = _('Bank Particulars');
				$item['name'] = 'bankpartics';
				if (isset ($_POST['bankpartics']))
					$item['value'] = $_POST['bankpartics'];

				$rightForm[] = $item;

				$item = array ();
				$item['type'] = 'text';
				$item['tag'] = _('Bank Reference');
				$item['name'] = 'bankref';
				if (isset ($_POST['bankref']))
					$item['value'] = $_POST['bankref'];

				$rightForm[] = $item;

				$item = array ();
				$item['type'] = 'text';
				$item['tag'] = _('Bank Account');
				$item['name'] = 'bankact';
				if (isset ($_POST['bankact']))
					$item['value'] = $_POST['bankact'];

				$rightForm[] = $item;
			}

			$validate = 'name';

			/* Assign the form variable */
			$smarty->assign('form', true);
			$smarty->assign('leftForm', $leftForm);
			$smarty->assign('rightForm', $rightForm);
			$smarty->assign('validate', $validate);
			$smarty->assign('formId', 'saveform');
	}
} else {
	$smarty->assign('errors', array (_('You are trying to access a module to which you do not have access, if you beleive you should please contact your system administrator')));
}
?>
