<?php 
	require_once (EGS_FILE_ROOT.'/src/classes/class.domain.php');

$domain = new domain();

$query = 'SELECT id, CASE WHEN forumpostid=115 THEN \'Partners\' ELSE \'Youngpeople\' END AS section, title, '.$db->SQLDate('d-m-Y', 'added').' AS added, message, CASE WHEN approved THEN \'Yes\' ELSE \'No\' END AS approved	FROM forumpost WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' AND forumpostid IS NOT NULL ORDER BY added';

$rs=$db->Execute($query);
$rows=array();
while(!$rs->EOF) {
	$line=array();
	foreach($rs->fields as $key=>$val)
		$line[]=$val;
	$rows[]=$line;
	$rs->MoveNext();
}
//print_r($rows);
$headings=array('','Section','Title(name)','Date','Message','Approved');
$smarty->assign('headings',$headings);
$smarty->assign('rows',$rows);
$smarty->assign('sep',',');


?>