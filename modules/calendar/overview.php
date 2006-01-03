<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Calendar Overview 1.0            |
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

/* Check user has access to the calendar module */
if (in_array('calendar', $_SESSION['modules'])) {
	
	//$egs->syncPreferences();
	$smarty->assign('iframe', true);
	
	if(isset($_COOKIE['phpicalendar'])) $phpicalendar 		= unserialize(stripslashes($_COOKIE['phpicalendar']));
	if (isset($phpicalendar)) $_SESSION['preferences']['calendarview']=$phpicalendar['cookie_view'];
	if(!isset($_SESSION['preferences']['calendarview']))$_SESSION['preferences']['calendarview']='day';
	
	
	$smarty->assign('iframeSrc', EGS_SERVER.'/modules/calendar/'.$_SESSION['preferences']['calendarview'].'.php?sess='.strip_tags(session_id()));
	
//	$smarty->assign('iframeSrc', EGS_SERVER.'/modules/calendar/day.php?sess='.strip_tags(session_id()));
}
?>
