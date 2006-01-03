<?php
// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Projects 1.0                     |
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
	/* Set up arrays to hold form elements */
	$leftForm = array();
	//$rightForm = array();
	//$bottomForm = array();

	/* If the form has been submitted do an update */
	if(sizeof($_POST) > 0) {
		unset($_POST['save']);
		
		/* Assign the preferences to the session */	
		while (list ($key, $val) = each($_POST)) {
			$_SESSION['preferences'][$key] = $val;
		}

		/* Sync the preferences to the database */
		$egs->syncPreferences();
	}
	
	$_POST = $_SESSION['preferences'];
	

	/* Set up the title */
	$smarty->assign('pageTitle',  _('My Home Preferences'));

	/* Build the form */

/* Fields for home preferences */
	$item = array();

	$item['options'] = array();
	$item['options']['messages'] = _('Messages');
	$item['options']['news'] = _('News');
	$item['options']['announcements'] = _('Announcements');
	$item['options']['open_tickets'] = _('Open Tickets');
	$item['options']['projects'] = _('Project');
	$item['options']['domains'] = _('Domains');
	$item['options']['pipeline'] = _('Pipeline');
	$item['options']['opportunities'] = _('Opportunities');
	$item['options']['activities'] = _('Activities');
	$item['options']['events'] = _('Events');
	$item['options']['to_do'] = _('To Do');
	
	$item['type'] = 'multiple';
	$item['tag'] = _('Modules Displayed in Overview');
	$item['name'] = 'homePreferences[]';
		
	if(isset($_POST['homePreferences'])) $item['value'] = $_POST['homePreferences'];

	$leftForm[] = $item;

	/*choose how far into the future to display events*/
	$item = array();
	$item['name'] = 'eventsDisplay';
	$item['type'] = 'select';
	$item['tag'] = 'Display Events For';
	$item['options'] = array(
						0=>'Today',
						1=>'Tomorrow',
						5=>'5 Days',
						7=>'7 Days',
						14=>'14 Days',
						30=>'1 Month',
						365=>'1 year'
						);
	if(isset($_POST['eventsDisplay'])) $item['value'] = $_POST['eventsDisplay'];
	$leftForm[] = $item;
	
	/* Assign the form variable */
	$smarty->assign('form', true);
	$smarty->assign('leftForm', $leftForm);
	
	$smarty->assign('moduleIcon', 'preferences');
?>

