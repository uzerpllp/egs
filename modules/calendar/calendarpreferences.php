<?php
	
	define('BASE',EGS_FILE_ROOT.'/modules/calendar/');
	require_once(EGS_FILE_ROOT.'/modules/calendar/functions/ical_parser.php');
	require_once(EGS_FILE_ROOT.'/modules/calendar/functions/template.php');
	/* Set up arrays to hold form elements */
	$leftForm = array();
	$rightForm = array();
	$bottomForm = array();
	if (isset($_POST['save'])) {
		unset($_POST['save']);
		$calendarview=$_POST['calendarview'];
		//Begin Update transaction
		$db->StartTrans();
		//delete user's prefs
		$q='DELETE FROM eventaccess WHERE username='.$db->qstr(EGS_USERNAME);
		$r=$db->Execute($q);
		//add new ones
		for ($i=0;$i<count($calendarview);$i++) {
			$allowname=$calendarview[$i];
			$q='INSERT INTO eventaccess (username,allowusername) VALUES ('.$db->qstr(EGS_USERNAME).','.$db->qstr($allowname).')';
			$r=$db->Execute($q);
			
		}
		$db->CompleteTrans();
		unset($_POST['calendarview']);
		/*add preferences to session and cookie*/
		
		if (!isset($cookie_url) || $cookie_uri == '') {
			$cookie_uri = $_SERVER['SERVER_NAME'].substr($_SERVER['PHP_SELF'],0,strpos($_SERVER['PHP_SELF'], '/'));
		}
		
		$cookie_language 	= 'English';
		if(isset($_POST['cookie_calendar'])) $cookie_calendar 	= $_POST['cookie_calendar'];
		if(isset($_POST['cookie_view'])) $cookie_view 			= $_POST['cookie_view'];
		if(isset($_POST['cookie_style'])) $cookie_style 		= $_POST['cookie_style'];
		if(isset($_POST['cookie_startday'])) $cookie_startday	= $_POST['cookie_startday'];
		if(isset($_POST['cookie_time'])) $cookie_time			= $_POST['cookie_time'];
			
		$the_cookie = array ("cookie_language" => "$cookie_language", "cookie_calendar" => "$cookie_calendar", "cookie_view" => "$cookie_view", "cookie_startday" => "$cookie_startday", "cookie_style" => "$cookie_style", "cookie_time" => "$cookie_time");
		$the_cookie 		= serialize($the_cookie);
		
		if(!setcookie("phpicalendar","$the_cookie",time()+(60*60*24*7*12*10))) {
			$errors=array();
			$errors[] = _('Error Setting the Cookie, some preferences may not take effect');
			$smarty->assign('errors',$errors);
		}
		$_COOKIE['phpicalendar'] = $the_cookie;
		
		/*now the session*/
		while (list ($key, $val) = each($_POST)) {
			if(isset($_POST[$key])) $_SESSION['preferences'][$key]=$val;
		
		}
		$egs->syncPreferences();
		
		
	}
	unset($_POST);
	$_POST = $_SESSION['preferences'];
	
	
	/* Set up the title */
	$smarty->assign('pageTitle',  _('My Calendar Preferences'));

	/* Build the form */
	
	//select the usernames to display in the options-list
	// (those who are in the same company, have calendar-access, and not yourself)
	$query= 'SELECT username FROM useraccess WHERE companyid='.$db->qstr(EGS_COMPANY_ID).'
			 AND username!='.$db->qstr(EGS_USERNAME);
	$query = 'SELECT DISTINCT gm.username 
						FROM 
						module AS m,
						groupmoduleaccess AS a,
						groups AS g,
						groupmembers AS gm 
						WHERE
						(
							gm.groupid=g.id AND 
							m.name='.$db->qstr('calendar').' AND 
							g.companyid='.$db->qstr(EGS_COMPANY_ID).' AND 
							a.groupid=gm.groupid AND 
							m.id=a.moduleid
							AND username!='.$db->qstr(EGS_USERNAME).'									
						)
					';
			 		
			 		
	
	$users = $db->query($query);
	
	if(!$users && EGS_DEBUG_SQL) die($db->ErrorMsg());

	$item['options'] = array();

	//add the usernames to the options-list
	while(!$users->EOF) {
		$item['options'][$users->fields['username']] = $users->fields['username'];
		$users->MoveNext();
	}
	
	//select which users to be selected
	$query='SELECT allowusername FROM eventaccess WHERE username='.$db->qstr(EGS_USERNAME);
	$r=$db->Execute($query);
	$cview=array();
	while (!$r->EOF) {
		$cview[]=$r->fields['allowusername'];	
		$r->MoveNext();
	}
	$item['value']=$cview;
	$item['type'] = 'multiple';
	$item['tag'] = _('Allow to edit my (public) Calendar');
	$item['name'] = 'calendarview[]';
	$leftForm[] = $item;
	
	/*no language choice
	$item = array();
	$item['tag'] = _('Language');
	$item['name'] = 'cookie_language';
	$item['type'] = 'select';
	$item['options'] = array();
	$dir_handle = @opendir(EGS_FILE_ROOT.'/modules/calendar/languages/');
	while ($file = readdir($dir_handle)) {
		if (substr($file, -8) == ".inc.php") {
			$language_tmp = urlencode(ucfirst(substr($file, 0, -8)));
			$item['options'][$language_tmp]=$language_tmp;
		}
	}
	if (isset($_POST['cookie_language']))
		$item['value']=$_POST['cookie_language'];
	$leftForm[] = $item;
	*end no language choice
	*/
	$item = array();
	$item['name'] = "cookie_calendar";
	$item['tag'] = _('Default Calendar');
	$item['type'] = 'select';
	
	$item['options'] = display_ical_options(availableCalendars($username, $password, $ALL_CALENDARS_COMBINED));
	if(isset($_POST['cookie_calendar']))
		$item['value'] = $_POST['cookie_calendar'];
	else
		$item['value'] = $ALL_CALENDARS_COMBINED;
	$leftForm[] = $item;
	
	$item = array();
	$item['name'] = 'cookie_view';
	$item['tag'] = _('Default View');
	$item['type'] = 'select';
	$item['options'] = array('day'=>_('Day'),'week'=>_('Week'),'month'=>_('Month'));
	if(isset($_POST['cookie_view']))
		$item['value'] = $_POST['cookie_view'];
	$leftForm[] = $item;
	
	$item = array();
	$item['name'] = 'cookie_time';
	$item['tag'] = _('Default Start Time');
	$item['type'] = 'select';
	$item['options'] = array();
	for ($i = 000; $i <= 1200; $i += 100) {
		$s = sprintf("%04d", $i);
		$item['options'][$s]=$s;
		
	}
	if(isset($_POST['cookie_time']))
		$item['value'] = $_POST['cookie_time'];
	$leftForm[] = $item;
	
	$item = array();
	$item['name'] = 'cookie_startday';
	$item['tag'] = _('Default Start Day');
	$item['type'] = 'select';
	$item['options'] = array('Monday'=>_('Monday'),'Tuesday'=>_('Tuesday'),'wednesday'=>_('Wednesday'),'thursday'=>_('Thursday'),'friday'=>_('Friday'),'saturday'=>_('Saturday'),'sunday'=>_('Sunday'));
	if(isset($_POST['cookie_startday']))
		$item['value']=$_POST['cookie_startday'];
	$leftForm[]=$item;
	
	$item = array();
	$item['name'] = 'cookie_style';
	$item['tag'] = _('Default Style');
	$item['type'] = 'select';
	$item['options'] = array();
	$dir_handle = @opendir(EGS_FILE_ROOT.'/modules/calendar/templates/');
	while ($file = readdir($dir_handle)) {
		if (($file != ".") && ($file != "..") && ($file != "CVS") &&($file!=".svn")) {
			if (!is_file($file)) {
				$file_disp = ucfirst($file);
				$item['options'][$file]=$file_disp;
			}
		}
	}
	$leftForm[]=$item;
	/* Assign the form variable */
	$smarty->assign('form', true);
	$smarty->assign('leftForm', $leftForm);
	$smarty->assign('rightForm', $rightForm);
	$smarty->assign('bottomForm', $bottomForm);
	
	function display_ical_options($cals) {
		global $cal, $ALL_CALENDARS_COMBINED, $current_view, $getdate, $calendar_lang, $all_cal_comb_lang;
		foreach ($cals as $cal_tmp) {
			// Format the calendar path for display.
			//
			// Only display the calendar name, replace all instances of "32" with " ",
			// and remove the .ics suffix.
			$cal_displayname_tmp = basename($cal_tmp);
			$cal_displayname_tmp = str_replace("32", " ", $cal_displayname_tmp);
			$cal_displayname_tmp = substr($cal_displayname_tmp, 0, -4);
	
			// If this is a webcal, add 'Webcal' to the display name.
			if (preg_match("/^(https?|webcal):\/\//i", $cal_tmp)) {
				$cal_displayname_tmp .= " Webcal";
			}
	
			// Otherwise, remove all the path information, since that should
			// not be used to identify local calendars. Also add the calendar
			// label to the display name.
			else {
				// Strip path and .ics suffix.
				$cal_tmp = basename($cal_tmp);
				$cal_tmp = substr($cal_tmp, 0, -4);
	
				// Add calendar label.
				$cal_displayname_tmp .= " $calendar_lang";
			}
	
			// Encode the calendar path.
			$cal_encoded_tmp = urlencode($cal_tmp);
	
			// Display the option.
			//
			// The submitted calendar will be encoded, and always use http://
			// if it is a webcal. So that is how we perform the comparison when
			// trying to figure out if this is the selected calendar.
			$cal_httpPrefix_tmp = str_replace('webcal://', 'http://', $cal_tmp);
			
				$return[$cal_encoded_tmp]=$cal_displayname_tmp;
			
				
			
		}	
			
			$return[$ALL_CALENDARS_COMBINED]=_('All Combined');
			
			return $return;
	}
	
?>
