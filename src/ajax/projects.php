<?php
session_start();

if (isset($_SESSION['loggedIn']) ) {
//	echo '<ul>';
//	foreach($_POST as $key=>$val) {
//		echo '<li>'.$key.'=>'.$val.'</li>';
//	}	
//	echo '</ul>';
	
	if (file_exists('../../conf/'.$_SERVER['HTTP_HOST'].'.config.php')) {
		require_once ('../../conf/'.$_SERVER['HTTP_HOST'].'.config.php');
	}
	else if(file_exists('../../conf/config.php')) {
		require_once ('../../conf/config.php');
	}
	/* Use the default config file */
	else {
		require_once ('./conf/config.php');
	}
	require_once (EGS_FILE_ROOT.'/src/db.php');
	if (isset ($_SESSION['EGS_USERNAME']))
		define('EGS_USERNAME', $_SESSION['EGS_USERNAME']);
	if (isset ($_SESSION['EGS_COMPANY_ID']))
		define('EGS_COMPANY_ID', $_SESSION['EGS_COMPANY_ID']);
	
	
	$incoming = $_REQUEST['value'];
	$length = strlen($incoming);
	$q = 'SELECT DISTINCT \'p\'||p.id as pid, p.jobno, p.name as pname FROM project p, projectaccess a WHERE  NOT p.completed AND p.id=a.projectid AND a.companyid='.$db->qstr(EGS_COMPANY_ID).' AND a.username='.$db->qstr(EGS_USERNAME).'ORDER BY p.jobno';
	$rs = $db->CacheExecute(120,$q);
	$projects = array ();
	$result = '<ul>';
	while (($rs !== false) && (!$rs->EOF)) {
		$projects[$rs->fields['pid']] = trim($rs->fields['pname']);
		
		$rs->MoveNext();
	}
	$q2='SElECT DISTINCT \'t\'||t.id AS tid, t.subject AS name FROM ticket t WHERE companyid='.$db->qstr(EGS_COMPANY_ID);
	$rs = $db->CacheExecute(120,$q2);
	while (($rs !== false) && (!$rs->EOF)) {
		$projects[$rs->fields['tid']] = trim($rs->fields['name']);
		
		$rs->MoveNext();
	}
	echo '<ul>';
	foreach ($projects as $key => $val) {
		$class='';
		if(substr($key,0,1)=='t')
			$class=' class="ticket" ';
		if ($incoming=='*'||$incoming != '' && substr(strtolower($val), 0, $length) == strtolower($incoming))
			echo '<li'.$class.' id="'.$key.'">'.$val."</li>";
			//$result .= '<li>'.$val."</li>";
			
	}
	echo '</ul>';
	$result.='</ul>';
	//echo $result;
	//echo '<ul><li>boo</li></ul>';
	$db->close();
	
	
}
else echo '<ul><li>boo</li></ul>';
?>