<?php
session_start();
?>
<html><head><title>Image</title></head>
<body style="background-color: #ffffff">
<?php
if(isset($_POST)&&count($_POST)>0) {
	if(isset($_POST['delete'])&&isset($_POST['fileid'])&&isset($_POST['productid'])) {
		
		if (file_exists('../../conf/'.$_SERVER['HTTP_HOST'].'.config.php')) {
			
		require_once ('../../conf/'.$_SERVER['HTTP_HOST'].'.config.php');
		}
		else if(file_exists('../../conf/config.php')) {
			
			require_once ('../../conf/config.php');
		}
		/* Use the default config file */
		else {
			echo "no config";
		}
		require_once (EGS_FILE_ROOT.'/src/db.php');
		if (isset ($_SESSION['EGS_USERNAME']))
			define('EGS_USERNAME', $_SESSION['EGS_USERNAME']);
		if (isset ($_SESSION['EGS_COMPANY_ID']))
			define('EGS_COMPANY_ID', $_SESSION['EGS_COMPANY_ID']);
			
			
	
		require_once EGS_FILE_ROOT.'/src/classes/class.store.php';
		$store=new store();
		$store->deleteImage($_POST['productid'],$_POST['fileid']);
		echo '<input type="button" onclick="javascript: window.opener.location.reload(); window.close()" value="Close Window" />';
		return false;
	}
}
//echo '<img src="'.$_GET['server'].'/image.php?PHPSESSID=abc1fdf84854184ad5f8141b7aef9e02&id=7&show=storeimage" alt="" />';
if(isset($_GET['id'])) {
	echo '<div style="border:1px solid black;
			text-align:center;width:90%;height:90%;margin:10px;">';
	echo '<img src="'.$_GET['server'].'/image.php?action=storeimage&id='.$_GET['id'].'" style="vertical-align:middle;"/>';
	echo '</div>';
	echo '<form action="" method="post">';
	echo '<input type="hidden" value="'.$_GET['id'].'" name="fileid" />';
	echo '<input type="hidden" value="'.$_GET['productid'].'" name="productid" />';
	echo '<input type="submit" name="delete" value="Delete" />';
	echo '</form>';
			
}
?>
</body>
</html>