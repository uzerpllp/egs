#!/usr/bin/php 
<?php
$fileRoot = "/mnt/websites/egs/egs";

require_once ("{$fileRoot}/conf/demo.senokian.com.config.php");
require_once ($fileRoot.'/src/db.php');

if ($handle = opendir('/tmp/emails')) {

   /* This is the correct way to loop over the directory. */
   while (false !== ($file = readdir($handle))) {

       $query = 'SELECT count(*) FROM ticket';
	
		$num = $db->GetOne($query);
		if($file{0} != '.') {
			exec('cat /tmp/emails/'.$file.' | /mnt/websites/egs/egs/modules/ticketing/egsmailgateway.php jake@senokian.com');
		}
		
		if($num < $db->GetOne($query)) unlink('/tmp/emails/'.$file);
   }

   closedir($handle);
}

?>