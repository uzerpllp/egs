<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Dashboard Overview 1.0           |
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

/* Check user has access to the crm module */
if (in_array('crm', $_SESSION['modules'])) {
	/* Do the Pipeline by sales stage session */
	if(!isset($_SESSION['pipelineSalesStageUsers'])) {
		/* If the user only wants certain uses set them to those */
		if(isset($_SESSION['preferences']['pipelineSalesStageUsers']) && ($_SESSION['preferences']['pipelineSalesStageUsers'] != '') )
			$_SESSION['pipelineSalesStageUsers'] = $_SESSION['preferences']['pipelineSalesStageUsers'];
		/* Otherwise get the current users */
		else {
			$query = 'SELECT gm.username FROM groupmembers gm, groups g, groupmoduleaccess a, module m WHERE gm.groupid=g.id AND g.companyid='.$db->qstr(EGS_COMPANY_ID).' AND a.moduleid=m.id AND m.name='.$db->qstr('crm').' AND a.groupid=g.id UNION SELECT username FROM useraccess WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' AND superuser ORDER BY username';
			
			$rs = $db->Execute($query);
			
			while(!$rs->EOF) {
				$_SESSION['pipelineSalesStageUsers'][] = $rs->fields['username'];
				$rs->MoveNext();
			}
		}
	}
	
	/* Do the opportunity by source by outcome session */
	if(!isset($_SESSION['opportunitySources'])) {
		/* If the user only wants certain uses set them to those */
		if(isset($_SESSION['preferences']['opportunitySources']) && ($_SESSION['preferences']['opportunitySources'] != '') )
			$_SESSION['opportunitySources'] = $_SESSION['preferences']['opportunitySources'];
		/* Otherwise get the current users */
		else {
			$query = 'SELECT id, name FROM crmcompanysource WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY name';
			
			$rs = $db->Execute($query);
			unset($_SESSION['opportunitySources']);
			while(!$rs->EOF) {
				$_SESSION['opportunitySources'][$rs->fields['id']] = $rs->fields['name'];
				$rs->MoveNext();
			}
		}
	}
	
	if(!isset($_SESSION['opportunityStages'])) {
		/* If the user only wants certain uses set them to those */
		if(isset($_SESSION['preferences']['opportunityStages']) && ($_SESSION['preferences']['opportunityStages'] != '') )
			$_SESSION['opportunityStages'] = $_SESSION['preferences']['opportunityStages'];
		/* Otherwise get the current users */
		else {
			$query = 'SELECT id, name FROM crmopportunity WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY id DESC';
			
			$rs = $db->Execute($query);
			unset($_SESSION['opportunityStages']);
			while(!$rs->EOF) {
				$_SESSION['opportunityStages'][$rs->fields['id']] = $rs->fields['name'];
				$rs->MoveNext();
			}
		}
	}

	/* Set the month stages */
	if(!isset($_SESSION['monthStages'])) {
		/* If the user only wants certain uses set them to those */
		if(isset($_SESSION['preferences']['monthStages']) && ($_SESSION['preferences']['monthStages'] != '') )
			$_SESSION['monthStages'] = $_SESSION['preferences']['monthStages'];
		/* Otherwise get the current users */
		else {
			$query = 'SELECT id, name FROM crmopportunity WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' AND id >4 ORDER BY id DESC';
			
			$rs = $db->Execute($query);
			unset($_SESSION['monthStages']);
			while(!$rs->EOF) {
				$_SESSION['monthStages'][$rs->fields['id']] = $rs->fields['name'];
				$rs->MoveNext();
			}
		}
	}
	
	if(!isset($_SESSION['monthYear'])) {
		/* If the user only wants certain uses set them to those */
		if(isset($_SESSION['preferences']['monthYear']) && ($_SESSION['preferences']['monthYear'] != '') )
			$_SESSION['monthYear'] = $_SESSION['preferences']['monthYear'];
		/* Otherwise get the current users */
		else {
				$_SESSION['monthYear'] = date('Y');
		}
	}
	
	/* Do the opportunity for all session */
	if(!isset($_SESSION['allOpportunitySources'])) {
		/* If the user only wants certain uses set them to those */
		if(isset($_SESSION['preferences']['allOpportunitySources']) && ($_SESSION['preferences']['allOpportunitySources'] != '') )
			$_SESSION['allOpportunitySources'] = $_SESSION['preferences']['allOpportunitySources'];
		/* Otherwise get the current users */
		else {
			$query = 'SELECT id, name FROM crmcompanysource WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' ORDER BY name';
			
			$rs = $db->Execute($query);
			unset($_SESSION['allOpportunitySources']);
			while(!$rs->EOF) {
				$_SESSION['allOpportunitySources'][$rs->fields['id']] = $rs->fields['name'];
				$rs->MoveNext();
			}
		}
	}
	
	if(isset($_GET['refresh']) && ($_GET['refresh'] == 'true')) {
		require_once (EGS_FILE_ROOT.'/src/classes/class.dashboard.php');

		$dashboard = new dashboard();
		
		$dashboard->refresh();
	}
;
	$smarty->assign('dashboard', true);
}
?>
