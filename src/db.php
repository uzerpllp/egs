<?php
	include(EGS_FILE_ROOT.'/src/adodb/adodb.inc.php');
	
	$db = &ADONewConnection(EGS_DB_TYPE);
	
	$db->PConnect(EGS_DB_HOST, EGS_DB_USER, EGS_DB_PASSWORD, EGS_DB_DATABASE);
	
	$db->SetFetchMode(ADODB_FETCH_ASSOC);
	$db->debug = EGS_DEBUG_SQL;
	
	$db->LogSQL(EGS_LOG_TO_SQL);
?>
