<?php

/* Use a local config file if it exists */
if (file_exists('./conf/'.$_SERVER['HTTP_HOST'].'.config.php')) {
	require_once ('./conf/'.$_SERVER['HTTP_HOST'].'.config.php');
}
/* Use the default config file */
else {
	require_once ('./conf/config.php');
}

/* Include the db connection */
require_once (EGS_FILE_ROOT.'/src/db.php');

/* Start a PHP session */
session_start();

/* If the user has called logout, do it */
if ((isset ($_GET['module']) && ($_GET['module'] == 'logout')) || (isset ($_SESSION['time']) && ($_SESSION['time'] <= time()))) {
	session_destroy();
	session_start();
	unset ($_GET['module']);
} else
	if (isset ($_GET['module']))
		define('EGS_MODULE', $_GET['module']);

/* Include the class containing generic EGS functions */
require_once (EGS_FILE_ROOT.'/src/classes/class.egs.php');

$egs = new egs();

$egs->syncToConstants();

if (isset ($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
	if (isset ($_GET['action']) && ($_GET['action'] == 'gantt')) {
		require_once (EGS_FILE_ROOT.'/src/classes/class.project.php');

		$project = new project();

		$project->gantt($_GET['id']);
	} 
	else if ((isset($_GET['action'])&&$_GET['action']=='storeimage')||(isset($_GET['show'])&&$_GET['show']=='storeimage')) {
		define('EGS_CACHE','tmp/egs/');
		
		$q = 'SELECT name,type,file,size FROM file WHERE id='.$db->qstr($_GET['id']);
		$row = $db->GetRow($q);
		$file=$row['file'];
		$size = $row['size'];
		$type=$row['type'];
		if(!file_exists(EGS_CACHE.'/'.$file)) {
			
			$db->maxblobsize=1000000;
			//$db->StartTrans();
			$filename = $db->BlobDecode($file);
			//$f=fopen('/tmp/egs/test.jpg','w+');
			//fwrite($f,$filename);
		//	fclose($f);
			//$db->CompleteTrans();
			header("Pragma: public"); // required
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private", false); // required for certain browsers 
			header("Content-Type: ".$type);
			//header("Content-Disposition: attachment; filename=".basename('/tmp/egs/test.jpg').";");
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: ".$size);
			//readfile('/tmp/egs/test.jpg');
			echo $filename;
			exit();
			
		}
		
	}
	else {
		if ($_GET['show'] == 'personlogo')
			$filename = EGS_FILE_ROOT.'/photos/'.$_GET['id'].'.jpg';
		else
			$filename = EGS_FILE_ROOT.'/logos/'.$_GET['id'].'.jpg';
		if (!file_exists($filename))
			$filename = EGS_FILE_ROOT.'/logos/holder.jpg';

		// required for IE, otherwise Content-disposition is ignored
		if (ini_get('zlib.output_compression'))
			ini_set('zlib.output_compression', 'Off');

		$file_extension = strtolower(substr(strrchr($filename, "."), 1));

		switch ($file_extension) {
			case "pdf" :
				$ctype = "application/pdf";
				break;
			case "exe" :
				$ctype = "application/octet-stream";
				break;
			case "zip" :
				$ctype = "application/zip";
				break;
			case "doc" :
				$ctype = "application/msword";
				break;
			case "xls" :
				$ctype = "application/vnd.ms-excel";
				break;
			case "ppt" :
				$ctype = "application/vnd.ms-powerpoint";
				break;
			case "gif" :
				$ctype = "image/gif";
				break;
			case "png" :
				$ctype = "image/png";
				break;
			case "pjpeg":
			case "jpeg" :
			case "jpg" :
				$ctype = "image/jpg";
				break;
			default :
				$ctype = "application/force-download";
		}
		header("Pragma: public"); // required
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private", false); // required for certain browsers 
		header("Content-Type: $ctype");
		header("Content-Disposition: attachment; filename=".basename($filename).";");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".filesize($filename));
		readfile("$filename");
		exit ();
	}
}
?>

