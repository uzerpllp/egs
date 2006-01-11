<?php
// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Header 1.0                       |
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
// |
// | 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA               |
// +----------------------------------------------------------------------+
// | Author: Jake Stride <jake.stride@senokian.com>                       |
// +----------------------------------------------------------------------+
// | Changes:                                                             |
// |                                                                      |
// | 1.0                                                                  |
// | ===                                                                  |
// | Initial Stable Release                                               |
// +----------------------------------------------------------------------+
//
/* Start a PHP session */
session_start();

/* If the user has called logout, do it */
if ((isset ($_GET['module']) && ($_GET['module'] == 'logout')) || (isset ($_SESSION['time']) && ($_SESSION['time'] <= time()))) {
	session_destroy();
	//session_regenerate_id();
	session_start();
	unset ($_GET['module']);
	setcookie('flyspray_userid', '', time() - 60, '/');
	setcookie('flyspray_passhash', '', time() - 60, '/');
	if (isset ($_POST['assignedCompany']))
		unset ($_POST['assignedCompany']);

} else
	if (isset ($_GET['module']))
		define('EGS_MODULE', $_GET['module']);

/* We are changing companies so unset current session */
if (isset ($_POST['assignedCompany']) && (isset ($_SESSION['time']) && ($_SESSION['time'] >= time())) && $_SESSION['loggedIn']) {
	$tmpUser = $_SESSION['EGS_USERNAME'];

	session_destroy();
	session_start();
	unset ($_GET['module']);
	setcookie('flyspray_userid', '', time() - 60, '/');
	setcookie('flyspray_passhash', '', time() - 60, '/');

	require_once (EGS_FILE_ROOT.'/src/classes/class.users.php');

	$user = new users();

	$user->login($tmpUser, '', $_POST['assignedCompany'], true);
	
}

/*Changing the Current Task*/
if (isset ($_POST['currentTaskSubmit']) && $_SESSION['loggedIn']) {
		
	$_POST['hours'] = $_POST['currentHours'].':'.$_POST['currentMinutes'];
	$taskerrors = array ();
	//'taskid' is the id of the current task (from a hidden field)
	//'projectid' is the id of the current project (used when updating tasks)
	/*do some validation*/
	if(!isset($_POST['ticketid'])||$_POST['ticketid']=='') {
		if (!isset ($_POST['taskid']) || !isset ($_POST['projectid']))
			$taskerrors[] = _('Invalid Taskid');
		$ticket=false;
		
	}
	else {
		$ticket=true;
	}
	
		
	if (!isset($_POST['currentTask']))
		$taskerrors[] = _('Invalid Task');
		
	
	
	
	
	if (!isset ($_POST['currentHours']) || !isset ($_POST['currentMinutes']) || !is_numeric($_POST['currentHours']) || !is_numeric($_POST['currentMinutes']) || $_POST['currentHours'] < 0 || $_POST['currentMinutes'] < 0 || ($_POST['currentHours'] == 0 && $_POST['currentMinutes'] == 0))
		$taskerrors[] = _('Invalid Time Entered');
	/*no previous hours*/
	$q = 'SELECT id FROM projecthours WHERE username='.$db->qstr($_SESSION['EGS_USERNAME']).' ORDER BY entered DESC limit 1';
	if (!$db->GetOne($q))
		$taskerrors = array ();
	if (count($taskerrors) == 0) {
		
		$db->StartTrans();
		
			if (!$ticket &&$_POST['taskid'] == $_POST['projectid'])
				$type = 'p';
			else if(!$ticket)
				$type = 't';
			else	
				$type='tick';
			$taskid = $_POST['taskid'];
			$projectid = $_POST['projectid'];
	
			
			/*Update the latest entry in projecthours, set 'hours' to be the value entered*/
			/*get the id of the latest entry*/
			$q = 'SELECT id FROM projecthours WHERE username='.$db->qstr($_SESSION['EGS_USERNAME']).' ORDER BY entered DESC limit 1';
			if ($hoursid = $db->GetOne($q)) {
				if ($type == 't')
					$q1 = 'UPDATE projecthours SET hours='.$db->qstr($_POST['hours']).', entered='.$db->DBTimeStamp(time()).' WHERE id='.$db->qstr($hoursid);
				else if($type=='p')
					$q1 = 'UPDATE projecthours SET hours='.$db->qstr($_POST['hours']).', entered='.$db->DBTimeStamp(time()).' WHERE id='.$db->qstr($hoursid);
				else if($type=='tick')
					$q1 = 'UPDATE projecthours SET hours='.$db->qstr($_POST['hours']).', entered='.$db->DBTimeStamp(time()).' WHERE id='.$db->qstr($hoursid);
				if (!$db->Execute($q1))
					$errors[] = _('Error Updating Hours');
	
			}
		
		$check = substr($_POST['currentTask'],0,1);
		if($check=='t') {
			$_POST['currentTask']=substr($_POST['currentTask'],1);
			$temp = explode('/', $_POST['currentTask']);
			$ticketid=$temp[0];
			
			$q2='INSERT INTO projecthours (ticketid,username,hours,updated) VALUES ('.$db->qstr($ticketid).','.$db->qstr($_SESSION['EGS_USERNAME']).','.$db->qstr('00:00:00').','.$db->DBTimeStamp(time()).')';
			if (!$db->Execute($q2))
			$errors[] = _('Error Inserting New Hours Record');
			$q3 = 'UPDATE ticket SET owner='.$db->qstr($_SESSION['EGS_USERNAME']).', status='.$db->qstr('OPN').' WHERE id='.$db->qstr($ticketid).' AND owner IS NULL';
			$db->Execute($q3);
		$db->CompleteTrans();
		}
		else {
			$_POST['currentTask']=substr($_POST['currentTask'],1);
			
		$temp = explode('/', $_POST['currentTask']);
		$newtaskid = $temp[0];
		$newprojectid = $temp[1];
		if ($newtaskid == $newprojectid)
			$newtype = 'p';
		else
			$newtype = 't';
		/*create a new entry in projecthours, for the task chosen from the select*/
		if ($newtype == 't')
			$q2 = 'INSERT INTO projecthours (projectid,taskid,username,hours,updated) VALUES ('.$db->qstr($newprojectid).','.$db->qstr($newtaskid).','.$db->qstr($_SESSION['EGS_USERNAME']).','.$db->qstr('00:00:00').','.$db->DBTimeStamp(time()).')';
		else
			$q2 = 'INSERT INTO projecthours (projectid,username,hours,updated) VALUES ('.$db->qstr($newprojectid).','.$db->qstr($_SESSION['EGS_USERNAME']).','.$db->qstr('00:00:00').','.$db->DBTimeStamp(time()).')';
		if (!$db->Execute($q2))
			$errors[] = _('Error Inserting New Hours Record');
			
			
		$db->CompleteTrans();
		
		}
	}
	$_POST=array();
}

/* Include the class containing generic EGS functions */
require_once (EGS_FILE_ROOT.'/src/classes/class.egs.php');

$egs = new egs();

/* Unsets the theme if logging in so we can redefine it */
if (isset ($_POST['login']) && (isset($_SESSION['loggedIn']) && !$_SESSION['loggedIn'])) {
	session_regenerate_id();
	unset ($_SESSION['EGS_THEME']);
}

$egs->syncToConstants();

if (isset ($_POST['assignedCompany']) && $_SESSION['loggedIn']) {
	unset ($_POST['assignedCompany']);
	$_SESSION['time'] = time() + EGS_LOGIN_TIME;
}

/* Set up the system variables if not yet logged in */
if (!isset ($_SESSION['time']))
	$_SESSION['time'] = 0;
if (!isset ($_SESSION['loggedIn']))
	$_SESSION['loggedIn'] = false;
if (!defined('EGS_HIDE'))
	define('EGS_HIDE', false);
if (!isset ($_SESSION['preferences']['addressFormat']))
	$_SESSION['preferences']['addressFormat'] = 'street1, street2, street3, town, county, postcode, country';
if (!defined('EGS_ADDRESS'))
	define('EGS_ADDRESS', $_SESSION['preferences']['addressFormat']);
if (!defined('EGS_TIME_FORMAT'))
	define('EGS_TIME_FORMAT', '%d/%m/%Y %H:%i');
if (!defined('EGS_DATE_FORMAT'))
	define('EGS_DATE_FORMAT', '%d/%m/%Y');
if (!defined('EGS_CURRENCY'))
	define('EGS_CURRENCY', '&pound;');
/* Set up the module if not set */
if (!defined('EGS_MODULE') && isset ($_GET['module']))
	define('EGS_MODULE', $_GET['module']);
else
	if (!defined('EGS_MODULE'))
		define('EGS_MODULE', 'home');
if (!defined('EGS_RECENTLY_VIEWED'))
	define('EGS_RECENTLY_VIEWED', 10);

/*define constants for postcode lookups*/
if (!defined('EGS_LICENSE_KEY') && defined('EGS_COMPANY_ID')) {

	$q = 'SELECT licensekey, licensecode FROM companydefaults WHERE companyid='.$db->qstr(EGS_COMPANY_ID);
	$rs = $db->Execute($q);
	if ($rs !== false) {

		define('EGS_LICENSE_KEY', $rs->fields['licensekey']);
		define('EGS_LICENSE_CODE', $rs->fields['licensecode']);
	}
	$egs->syncPreferences();
}
/*define constant for the default country (assumes same as country of users)*/
if (!defined('EGS_DEFAULT_COUNTRY') && defined('EGS_COMPANY_ID')) {
	$q = 'SELECT countrycode FROM companyoverview WHERE id='.$db->qstr(EGS_COMPANY_ID);
	define('EGS_DEFAULT_COUNTRY', $db->GetOne($q));
}

/* Check the session has not expired, if it has logout the user, if not refresh the time */
if (($_SESSION['time'] <= time()) && ($_SESSION['loggedIn'] === true)) {
	session_destroy();
	session_start();
} else {
	$_SESSION['time'] = time() + EGS_LOGIN_TIME;
}

/* Need to do the login for the user */
if (isset ($_POST['login']) && !$_SESSION['loggedIn']) {
	require_once (EGS_FILE_ROOT.'/src/classes/class.users.php');

	$user = new users();

	if (!$user->login($_POST['username'], $_POST['password']))
		$error = _("Invalid Username/Password Combination");
}

/* If no theme is set use the default */
if (!defined('EGS_THEME'))
	define('EGS_THEME', 'default');

/* Setup Smarty */
require 'smarty/Smarty.class.php';

$smarty = new Smarty;
require (EGS_FILE_ROOT.'/src/smarty/plugins/smarty-gettext.php');

$smarty->template_dir = EGS_FILE_ROOT.'/themes/'.EGS_THEME.'/templates/';
$smarty->compile_dir = EGS_FILE_ROOT.'/themes/'.EGS_THEME.'/templates_c/';
$smarty->config_dir = EGS_FILE_ROOT.'/themes/'.EGS_THEME.'/configs/';
$smarty->cache_dir = EGS_FILE_ROOT.'/themes/'.EGS_THEME.'/cache/';

$smarty->compile_check = true;
$smarty->debugging = EGS_DEBUG_THEME;
$smarty->register_block('t', 'smarty_translate');
if (isset ($error))
	$smarty->assign('error', _("Invalid Username/Password Combination"));
$smarty->assign('serverRoot', EGS_SERVER);
$smarty->assign('theme', EGS_THEME);
$smarty->assign('session', session_name().'='.strip_tags(session_id()));
$smarty->assign('module', EGS_MODULE);

if (isset ($_SESSION['loggedIn']) && ($_SESSION['loggedIn'] !== true)) {
	$smarty->assign('username', _('Username'));
	if (isset ($_GET['username']))
		$smarty->assign('usernameValue', $_GET['username']);
	$smarty->assign('password', _('Password'));
	$smarty->assign('login', _('Login'));
} else {
	/* Setup the admin and system admin links if present */
	if (isset ($_SESSION['modules']) && in_array('systemadmin', $_SESSION['modules']))
		$smarty->assign('systemAdmin', true);
	if (isset ($_SESSION['modules']) && in_array('admin', $_SESSION['modules']))
		$smarty->assign('admin', true);

	/* Set up an array to hold the sub menus */
	$subMenus = array ();

	/* Setup the home sub menus */
	if (isset ($_SESSION['modules']) && in_array('home', $_SESSION['modules'])) {
		$subMenus[_('home')] = array ();

		$subMenus[_('home')][_('Overview')] = '';
		$subMenus[_('home')][_('My Details')] = 'action=details';
		$subMenus[_('home')][_('Company Details')] = 'action=view';
		$subMenus[_('home')][_('News Archive')] = 'action=news';
		$subMenus[_('home')][_('Announcement Archive')] = 'action=announcements';
		if (EGS_COMPANY_ID == EGS_ACTUAL_COMPANY_ID)
			$subMenus[_('home')][_('New Message')] = 'action=savemessage';
	}

	/* Setup the dashboard sub menus */
	if (isset ($_SESSION['modules']) && in_array('crm', $_SESSION['modules'])) {
		$subMenus[_('crm')] = array ();

		$subMenus[_('crm')][_('Dashboard')] = 'action=overview';
		if (!isset ($_GET['action']) || ($_GET['action'] == 'overview'))
			$subMenus[_('crm')][_('Refresh Graphs')] = 'refresh=true';
		$subMenus[_('crm')][_('Opportunities')] = 'action=opportunityoverview';
		$subMenus[_('crm')][_('Cases')] = 'action=caseoverview';
		$subMenus[_('crm')][_('Activities')] = 'action=activityoverview';

		$subMenus[_('crm')][_('New Opportunity')] = 'action=saveopportunity';
		$subMenus[_('crm')][_('New Case')] = 'action=savecase';
		$subMenus[_('crm')][_('New Activity')] = 'action=saveactivity';

		if (isset ($_GET['id']) && isset ($_GET['module']) && ($_GET['module'] == 'contacts') && (!isset ($_GET['action']) || ($_GET['action'] == 'view'))) {
			$subMenus[_('crm')][_('New Opportunity')] .= '&amp;companyid='.intval($_GET['id']);
			$subMenus[_('crm')][_('New Case')] .= '&amp;companyid='.intval($_GET['id']);
			$subMenus[_('crm')][_('New Activity')] .= '&amp;companyid='.intval($_GET['id']);
		}
	}

	/* Setup the admin sub menus */
	if (isset ($_SESSION['modules']) && in_array('admin', $_SESSION['modules'])) {
		$subMenus[_('admin')] = array ();

		$subMenus[_('admin')][_('Users')] = '';
		$subMenus[_('admin')][_('Groups')] = 'action=groups';
		$subMenus[_('admin')][_('MOTD')] = 'action=motd';
		$subMenus[_('admin')][_('News')] = 'action=news';
		$subMenus[_('admin')][_('Announcements')] = 'action=announcements';
	}
	/*set up the contacts-module submenus*/
	if (isset ($_SESSION['modules']) && in_array('contacts', $_SESSION['modules'])) {
		$subMenus[_('contacts')] = array ();

		$subMenus[_('contacts')][_('Accounts')] = 'action=overview';
		$subMenus[_('contacts')][_('Contacts')] = 'action=personoverview';
		$subMenus[_('contacts')][_('Print Labels/Letters')] = 'action=labels';
		$subMenus[_('contacts')][_('Sent Letters')] = 'action=letteroverview';
		/*templates require CRM_ADMIN access*/
		if (EGS_CRMADMIN) {
			$subMenus[_('contacts')][_('Letter Templates')] = 'action=templateoverview';
			$subMenus[_('contacts')][_('New Letter Template')] = 'action=savetemplate';
		}
		$subMenus[_('contacts')][_('New Account')] = 'action=saveaccount';
		$subMenus[_('contacts')][_('New Contact')] = 'action=saveperson';
		;
		if (isset ($_GET['id']) && isset ($_GET['module']) && ($_GET['module'] == 'contacts') && (!isset ($_GET['action']) || ($_GET['action'] == 'view'))) {
			$subMenus[_('contacts')][_('New Contact')] .= '&amp;companyid='.intval($_GET['id']);
		}
	}
	/*set up the domain-module submenu*/
	if (isset ($_SESSION['modules']) && in_array('domain', $_SESSION['modules'])) {
		$subMenus[_('domain')] = array ();

		$subMenus[_('domain')][_('Domains')] = 'action=overview';
		if (isset ($_GET['id']) && isset ($_GET['module']) && ($_GET['module'] == 'domain')) {
			$subMenus[_('domain')][_('New Webpage')] = 'action=newwebpage&amp;domainid='.intval($_GET['id']);
			$subMenus[_('domain')][_('New Portfolio Item')] = 'action=saveportfolioitem&amp;domainid='.intval($_GET['id']);
			$subMenus[_('domain')][_('New News Items')] = 'action=savenewsitem&amp;domainid='.intval($_GET['id']);
		}
	}

	/*set up the webERP sub-menus*/
	if (isset ($_SESSION['modules']) && in_array('weberp', $_SESSION['modules'])) {
		$subMenus[_('domain')] = array ();

		if (!isset ($_SESSION['ModulesEnabled'])) {
			require_once (EGS_FILE_ROOT.'/src/classes/class.weberp.php');
			$weberp = new weberp();
			$weberp->authenticate();
		}

		if (isset ($_SESSION['ModulesEnabled'][0]) && ($_SESSION['ModulesEnabled'][0] == 1))
			$subMenus[_('weberp')][_('Orders')] = 'action=overview&amp;application=orders';
		if (isset ($_SESSION['ModulesEnabled'][1]) && ($_SESSION['ModulesEnabled'][1] == 1))
			$subMenus[_('weberp')][_('Receivables')] = 'action=overview&amp;application=AR';
		if (isset ($_SESSION['ModulesEnabled'][2]) && ($_SESSION['ModulesEnabled'][2] == 1))
			$subMenus[_('weberp')][_('Payables')] = 'action=overview&amp;application=AP';
		if (isset ($_SESSION['ModulesEnabled'][3]) && ($_SESSION['ModulesEnabled'][3] == 1))
			$subMenus[_('weberp')][_('Purchasing')] = 'action=overview&amp;application=PO';
		if (isset ($_SESSION['ModulesEnabled'][4]) && ($_SESSION['ModulesEnabled'][4] == 1))
			$subMenus[_('weberp')][_('Inventory')] = 'action=overview&amp;application=stock';
		if (isset ($_SESSION['ModulesEnabled'][5]) && ($_SESSION['ModulesEnabled'][5] == 1))
			$subMenus[_('weberp')][_('Manufacturing')] = 'action=overview&amp;application=manuf';
		if (isset ($_SESSION['ModulesEnabled'][6]) && ($_SESSION['ModulesEnabled'][6] == 1))
			$subMenus[_('weberp')][_('General Ledger')] = 'action=overview&amp;application=GL';
		if (isset ($_SESSION['ModulesEnabled'][7]) && ($_SESSION['ModulesEnabled'][7] == 1))
			$subMenus[_('weberp')][_('Setup')] = 'action=overview&amp;application=system';

		$subMenus[_('weberp')][_('Main Menu')] = 'action=overview';
		$subMenus[_('weberp')][_('Select Customer')] = 'action=overview&amp;view=SelectCustomer';
		$subMenus[_('weberp')][_('Select Item')] = 'action=overview&amp;view=SelectProduct';
		$subMenus[_('weberp')][_('Select Supplier')] = 'action=overview&amp;view=SelectSupplier';

	}
	/*set up the ticketing module submenu*/
	if (isset ($_SESSION['modules']) && in_array('ticketing', $_SESSION['modules'])) {
		$subMenus[_('ticketing')] = array ();

		$subMenus[_('ticketing')][_('Overview')] = 'action=overview';

		$subMenus[_('ticketing')][_('New Ticket')] = 'action=saveticket';

	}

	/*set up the calendar module submenu*/
	if (isset ($_SESSION['modules']) && in_array('calendar', $_SESSION['modules'])) {
		$subMenus[_('calendar')] = array ();

		$subMenus[_('calendar')][_('View')] = 'action=overview';
		$subMenus[_('calendar')][_('New Event')] = 'action=saveevent';
		$subMenus[_('calendar')][_('New ToDo')] = 'action=savetodo';

	}
	/*set up the system-admin submenu*/
	if (isset ($_SESSION['modules']) && in_array('systemadmin', $_SESSION['modules'])) {
		$subMenus[_('systemadmin')] = array ();

		$subMenus[_('systemadmin')][_('Companies')] = 'action=overview';
		$subMenus[_('systemadmin')][_('Users')] = 'action=users';
		$subMenus[_('systemadmin')][_('Ticket Queues')] = 'action=queues';

	}
	/*set up the admin menu*/
	if (isset ($_SESSION['modules']) && in_array('store', $_SESSION['modules'])) {
		$subMenus[_('store')] = array ();
		$subMenus[_('store')][_('Products')] = 'action=overview';
		$subMenus[_('store')][_('Sections')] = 'action=sectionoverview';
		$subMenus[_('store')][_('Suppliers')] = 'action=supplieroverview';
		$subMenus[_('store')][_('Attributes')] = 'action=attributeoverview';
		$subMenus[_('store')][_('Customers')] = 'action=customeroverview';
		$subMenus[_('store')][_('Orders')] = 'action=orderoverview';
	}
	/*set up the projects sub-menu*/
	if (isset ($_SESSION['modules']) && in_array('projects', $_SESSION['modules'])) {
		/* This shows the hours box in the menu */
		$smarty->assign('showHours', 'true');

		$subMenus[_('projects')] = array ();

		$subMenus[_('projects')][_('Overview')] = 'action=overview';

		if (isset ($_GET['id']))
			$projectId = $_GET['id'];
		if (isset ($_GET['projectid']))
			$projectId = $_GET['projectid'];

		if (isset ($projectId) && isset ($_GET['module']) && ($_GET['module'] == 'projects')) {
			$subMenus[_('projects')][_('View Project')] = 'action=view&amp;id='.$projectId;
			$subMenus[_('projects')][_('Gantt Chart')] = 'action=gantt&amp;id='.$projectId;
			$subMenus[_('projects')][_('Bug Overview')] = 'action=bugs&amp;id='.$projectId;

			require_once (EGS_FILE_ROOT.'/src/classes/class.project.php');

			$project = new project();

			if ((isset ($_GET['module']) && ($_GET['module'] == 'projects')) && $project->isAdmin()) {
				$smarty->assign('projectReports', true);
				$smarty->assign('projects', $project->getProjects());
				$smarty->assign('users', $egs->getUsers());
				$smarty->assign('dateFormat', EGS_DATE_FORMAT);
			}

			if ($project->isAdmin())
				$subMenus[_('projects')][_('New Project')] = 'action=saveproject';
			$subMenus[_('projects')][_('New Task')] = 'action=savetask&amp;projectid='.$projectId;
			$subMenus[_('projects')][_('New Bug')] = 'action=bugs&amp;do=newtask&amp;id='.$projectId;
		} else {

			$subMenus[_('projects')][_('Bug Overview')] = 'action=bugs';
			require_once (EGS_FILE_ROOT.'/src/classes/class.project.php');

			$project = new project();

			if ((isset ($_GET['module']) && ($_GET['module'] == 'projects')) && $project->isAdmin()) {
				$smarty->assign('projectReports', true);
				$smarty->assign('projects', $project->getProjects());
				$smarty->assign('users', $egs->getUsers());
				$smarty->assign('dateFormat', EGS_DATE_FORMAT);
			}

			if ($project->isAdmin())
				$subMenus[_('projects')][_('New Project')] = 'action=saveproject';
		}

		if (isset ($_POST['username']) && isset ($_POST['password'])) {
			$username = $_POST['username'];
			$password = $_POST['password'];

			/* Do the flyspray authentication */
			$db->Execute('SET search_path=public, company'.EGS_COMPANY_ID);

			$result = $db->Execute("SELECT uig.*, g.group_open, u.account_enabled, u.user_pass FROM flyspray_users_in_groups uig
			                          LEFT JOIN flyspray_groups g ON uig.group_id = g.group_id
			                          LEFT JOIN flyspray_users u ON uig.user_id = u.user_id
			                          WHERE u.user_name = ? AND g.belongs_to_project = ?
			                          ORDER BY g.group_id ASC", array ($_POST['username'], '0'));

			$auth_details = $result->fields;

			// Encrypt the password, and compare it to the one in the database
			if (md5(strip_tags($password)) == $auth_details['user_pass']) {

				// Check that the user's account is enabled
				if ($auth_details['account_enabled'] == '1' // And that their global group is allowed to login
				&& $auth_details['group_open'] == '1') {

					$cookie_time = 0; // Set cookies to expire when session ends (browser closes)

					// Set a couple of cookies
					setcookie('flyspray_userid', $auth_details['user_id'], $cookie_time, "/");
					setcookie('flyspray_passhash', crypt("{$auth_details['user_pass']}", "bc�"), $cookie_time, "/");
				}
			}
		}
	}
	if (!in_array('choose', $_SESSION['modules']))
		$_SESSION['modules'][] = 'choose';

	if (!isset ($_SESSION['preferences']['lastViewed']))
		$_SESSION['preferences']['lastViewed'] = array ();
	/* Include the correct files if valid */
	if (isset ($_SESSION['modules']) && in_array(strtolower(EGS_MODULE), $_SESSION['modules'])) {
		if (isset ($_GET['action']))
			$page = strtolower($_GET['action']);
		else
			$page = 'overview';

		if (file_exists(EGS_FILE_ROOT.'/modules/'.strtolower(EGS_MODULE).'/'.$page.'.php'))
			require_once (EGS_FILE_ROOT.'/modules/'.strtolower(EGS_MODULE).'/'.$page.'.php');
	}

	/* Assign the modules */
	if (isset ($_SESSION['orderedModules']))
		$smarty->assign('modules', $_SESSION['orderedModules']);
	$smarty->assign('subModules', $subMenus);
	$smarty->assign('module', EGS_MODULE);
	$smarty->assign('lang', EGS_LANG);
	$smarty->assign('username', EGS_USERNAME);
	$smarty->assign('personName', EGS_PERSON_NAME);
	$smarty->assign('todaysDate', _(date('l')).' '.date('j').'<sup>'._(date('S')).'</sup> '._(date('F')).' '.date('Y'));

	setcookie('EGS_COMPANY_ID', EGS_COMPANY_ID);
	setcookie('EGS_USERNAME', EGS_USERNAME);

	$self = 'http';
	if ($_SERVER['SERVER_PORT'] == 443)
		$self .= 's';
	$self .= '://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
	if ($_SERVER['QUERY_STRING'] > ' ')
		$self .= '?'.str_replace('&', '&amp;', $_SERVER['QUERY_STRING']);

	if (strpos($self, 'pageid') === false)
		$tmpSelf = explode('&amp;page', $self);
	else
		$tmpSelf = array ($self);
	$tmpSelf = explode('&amp;order', $tmpSelf[0]);
	$tmpSelf = explode('&amp;print', $tmpSelf[0]);
	$tmpSelf = explode('&amp;show', $tmpSelf[0]);
	$tmpSelf = explode('&amp;hide', $tmpSelf[0]);
	$self = $tmpSelf[0];

	$smarty->assign('self', $self);

	/* Get the companies the user has access to */
	$query = 'SELECT c.id, c.name FROM company c, useraccess a WHERE c.id=a.companyid AND a.username='.$db->qstr(EGS_USERNAME).' ORDER BY c.name';

	$rs = $db->Execute($query);

	$companies = array ();

	while (!$rs->EOF) {
		$companies[$rs->fields['id']] = $rs->fields['name'];

		$rs->MoveNext();
	}

	if (sizeof($companies) > 1) {
		$smarty->assign('crossAssigned', $companies);
		$smarty->assign('currentCompany', EGS_COMPANY_ID);
	}
	/*The bit below sets up the sub-menu for stating what task you're currently working on
	 * The population of the drop-downs is now done with AJAX things
	 * */
	 
	if (isset ($_SESSION['modules']) && in_array('projects', $_SESSION['modules'])) {
		$q = 'SELECT CASE WHEN ticketid IS NOT NULL THEN ticketid WHEN taskid IS NOT NULL THEN taskid ELSE projectid END AS id, projectid, hours, entered FROM projecthours WHERE username='.$db->qstr(EGS_USERNAME).' ORDER BY entered DESC LIMIT 1';
		$rs = $db->Execute($q);

		if ($rs->RecordCount() > 0) {
			$row = $rs->FetchRow($q);

			/* Added this to stop undefined variables */
			$ticket = false;

			if ($row['id'] == $row['projectid'])
				$q2 = 'SELECT name FROM project WHERE id='.$db->qstr($row['projectid']);
			else if(isset($row['projectid']))
				$q2 = 'SELECT name FROM projecttask WHERE id='.$db->qstr($row['id']);
			else {
				$q2 = 'SELECT subject FROM ticket WHERE id='.$db->qstr($row['id']);
				$ticket=true;	
			}
			$name = $db->GetOne($q2);
			
			if(isset($ticket) && $ticket)$_POST['currentTicketID']=$row['id'];
			else {
				$_POST['currentTaskID'] = $row['id'];
				$_POST['currentProjectID'] = $row['projectid'];
			}
			$_POST['currentTask'] = $name;
			$_POST['hours'] = $row['hours'];

			if (strpos($row['entered'], '.'))
				$_POST['entered'] = substr($row['entered'], 0, strpos($row['entered'], '.'));
			else
				$_POST['entered'] = $row['entered'];
			$entered = strtotime($_POST['entered']);

			$now = strtotime(date('Y-m-d H:i:s'));
			$difference = $now - $entered;
			$difference = $difference / 3600;

			$temp = explode('.', $difference);
			$hours = $temp[0];

			$temp = explode('.', substr(($difference - $hours) * 60, 0, 2));
			$minutes = sprintf("%02d", $temp[0]);

			$_POST['hours'] = $hours.':'.$minutes;

		}
		
		if ((isset($_POST['currentTicketID']))||( isset($_POST['currentTaskID']) && isset ($_POST['currentProjectID']))) {
			preg_match("/(\d*):(\d{2})*/i", $_POST['hours'], $matches);
			$_POST['currentHours'] = $matches[1];
			$_POST['currentMinutes'] = $matches[2];
			$task = str_replace('-', '', $_POST['currentTask']);
			$smarty->assign('currentTask', $task);

			if (isset($_POST['currentTaskID'])&&isset($_POST['currentProjectID'])&&$_POST['currentTaskID'] == $_POST['currentProjectID']) {
				$type = 'p';
			} else if (!$ticket)
				$type = 't';
			else
				$type='tick';
			if(isset($_POST['currentTaskID']))$smarty->assign('currentTaskID', $_POST['currentTaskID']);
			if ($type == 't')
				$smarty->assign('currentType', 'viewtask');
			else
				$smarty->assign('currentType', 'view');
			
			if(isset($_POST['currentTicketID']))$smarty->assign('currentticketID',$_POST['currentTicketID']);
				
			if(isset($_POST['currentProjectID']))$smarty->assign('currentprojectID', $_POST['currentProjectID']);
			if (isset ($_POST['currentHours']))
				$smarty->assign('currentHours', $_POST['currentHours']);
			if (isset ($_POST['currentMinutes']))
				$smarty->assign('currentMinutes', $_POST['currentMinutes']);
		} else {
			$smarty->assign('currentTask', '&lt;'._('Nothing').'&gt;');
		}
		$smarty->assign('showCurrentTask', true);

	}
	//end CurentTask stuff

	/* Assign the translations of added and updated so we can make sure they are not bold in the template */
	$smarty->assign('added', _('Added'));
	$smarty->assign('lastUpdated', _('Last Updated'));
}
?>