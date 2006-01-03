<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - View Opportunity 1.0             |
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
if (isset ($_SESSION['modules']) && (in_array('home', $_SESSION['modules'])) && (EGS_COMPANY_ID == EGS_ACTUAL_COMPANY_ID)) {
	/* Get the news details from the database */
	$errors=array();
	$query = 'SELECT *, '.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 'published').' AS published, '.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 'showfrom').' AS showfrom, '.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 'showuntil').' AS showuntil, '.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 'updated').' AS updated FROM news WHERE id='.$db->qstr(intval($_GET['id'])).' AND companyid='.$db->qstr(EGS_COMPANY_ID); 
	if(!$newsDetails = $db->GetRow($query))
		$errors=_('You don\'t have permission to view this news story');
		
	if(count($errors)==0) {	
	$smarty->assign('pageTitle', _('View News Item'));
	
		/* Output the news details */
		$leftData = array ();
		$leftData[] = array ('tag' => _('Headline'), 'data' => stripslashes($newsDetails['headline']));
		$leftData[] = array ('tag' => _('Website'), 'data' => $newsDetails['url']);
		$leftData[] = array ('tag' => _('Show From'), 'data' => $newsDetails['showfrom']);
		$leftData[] = array ('tag' => _('Show Until'), 'data' => $newsDetails['showuntil']);
		$leftData[] = array ('span' => true);
		$leftData[] = array ('tag' => _('Published'), 'data' => $newsDetails['published']);
		$leftData[] = array ('tag' => _('Last Updated'), 'data' => $newsDetails['updated'].' '._('by').' '.$newsDetails['alteredby']);
	
		$bottomData = array();
		$bottomData[] = array ('type'=>'display','title'=>_('Teaser'),'content'=>$newsDetails['teaser']);
		$bottomData[] = array ('type'=>'display','title'=>_('Full Story'),'content'=>$newsDetails['body']);	
	
		$smarty->assign('view', true);
		$smarty->assign('leftData', $leftData);
	$smarty->assign('bottomData', $bottomData);
	}
	else {
		$smarty->assign('errors',$errors);
		$smarty->assign('redirect',true);
		$smarty->assign('redirectAction'.'');
	}
} else {
	$smarty->assign('errors', array (_('You do not have the correct permissions to access this module. If you believe you should please contact your system administrator')));
}		

?>