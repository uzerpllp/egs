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

/*This page displays the overview of all past news items
  Deleting/Editing/Adding are done from the admin menu*/
  
	/* If the page has not been set, set it */
	if(isset($_GET['page'])) $_SESSION['news_page'] = max(1, intval($_GET['page']));
	if(!isset($_SESSION['news_page'])) $_SESSION['news_page'] = 1;

	/* Set the page title */
	$smarty->assign('pageTitle', _('News Archive'));
	
	/*column headings, using $_SESSION for consistency*/
	$_SESSION['preferences']['newsColumns'] = array();
	$_SESSION['preferences']['newsColumns'][] = 'published';
	$_SESSION['preferences']['newsColumns'][] = 'headline';
	$_SESSION['preferences']['newsColumns'][] = 'teaser';
				
	

	/* Array to hold the columns */
	$headings = array();

	/* Iterate over the columns and translate */
	for($i=0; $i < sizeof($_SESSION['preferences']['newsColumns']); $i++) {
		switch ($_SESSION['preferences']['newsColumns'][$i]) {
			case 'headline':
				$headings[$_SESSION['preferences']['newsColumns'][$i]] = _('Headline.');
				break;
			case 'teaser':
				$headings[$_SESSION['preferences']['newsColumns'][$i]] = _('Teaser');
				break;
			case 'url':
				$headings[$_SESSION['preferences']['newsColumns'][$i]] = _('Website');
				break;
			case 'published':
				$headings[$_SESSION['preferences']['newsColumns'][$i]] = _('Date Published');
				break;
			
			
		}
	}

	$smarty->assign('headings', $headings);
	
	/* Set the search order */
	if(isset($_GET['order']) && ($_GET['order'] == $_SESSION['newsOrder']) && in_array($_GET['order'], $_SESSION['preferences']['newsColumns'])) {
		if(isset($_SESSION['newsSort']) && ($_SESSION['newsSort'] == 'ASC')) $_SESSION['newsSort'] = 'DESC';
		else if(isset($_SESSION['newsSort']) && ($_SESSION['newsSort'] == 'DESC')) $_SESSION['newsSort'] = 'ASC';
		$_SESSION['news_page'] = 1;
	} else if(isset($_GET['order']) && in_array($_GET['order'], $_SESSION['preferences']['newsColumns'])) {
		$_SESSION['newsSort'] = 'DESC';
		$_SESSION['newsOrder'] = $_GET['order'];
		$_SESSION['news_page'] = 1;
	}

	if(!isset($_SESSION['newsOrder'])) $_SESSION['newsOrder'] = $_SESSION['preferences']['newsColumns'][0];
	if(!isset($_SESSION['newsSort'])) $_SESSION['newsSort'] = 'DESC';

	$_SESSION['order'] = $_SESSION['newsOrder'];
	
	/* Build the query to get the relevant columns */
	$query = 'SELECT n.id, ';

		
	/*add the fields to the query*/
	for($i = 0; $i < sizeof($_SESSION['preferences']['newsColumns']); $i++) {
		if($_SESSION['preferences']['newsColumns'][$i]=='url')
			$query .= 'CASE WHEN url IS NULL THEN '.$db->qstr('N/A').' ELSE url END AS url';
		else if($_SESSION['preferences']['newsColumns'][$i]=='published')
			$query .= $db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT),'n.'.$_SESSION['preferences']['newsColumns'][$i]).' AS '.$_SESSION['preferences']['newsColumns'][$i];
		else if($_SESSION['preferences']['newsColumns'][$i]=='teaser')
			$query .= $db->substr.'(teaser,0,150) || \'...\' as teaser';
		else
			$query .= $_SESSION['preferences']['newsColumns'][$i];
		if(($i+1) != sizeof($_SESSION['preferences']['newsColumns'])) $query .= ', ';
	}

	$query.= ' FROM news n LEFT OUTER JOIN domain d ON (n.domainid=d.id) WHERE n.companyid='.$db->qstr(EGS_COMPANY_ID).' AND n.news=true AND n.motd=false AND ((n.domainid IS NULL) OR (d.companyid='.$db->qstr(EGS_COMPANY_ID).')) AND n.visible AND (n.showfrom<=now() OR n.showfrom IS NULL) AND (n.showuntil>=now() OR n.showuntil IS NULL)';
	$query .= ' ORDER BY n.'.$_SESSION['newsOrder']. ' '.$_SESSION['newsSort'];
	
	
	
	$smarty->assign('hideToggle',true);
	$smarty->assign('viewType', 'news');
	/* Set up the pager and send the query */
	$egs->page($query, 'news_page');	
?>
