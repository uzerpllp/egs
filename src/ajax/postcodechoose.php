<?php


// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Save Event 1.0                   |
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
//
/* Set the id if set */
session_start();

if (isset($_SESSION['EGS_LICENSE_KEY']) && isset($_SESSION['EGS_LICENSE_CODE']) && isset ($_SESSION['loggedIn']) && isset ($_SESSION['modules']) && in_array('contacts', $_SESSION['modules'])) {
	
	if (file_exists('/mnt/websites/egs/egs/conf/'.$_SERVER['HTTP_HOST'].'.config.php')) {
		require_once ('/mnt/websites/egs/egs/conf/'.$_SERVER['HTTP_HOST'].'.config.php');
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
	if(isset($_SESSION['EGS_LICENSE_KEY']))
		define('EGS_LICENSE_KEY',$_SESSION['EGS_LICENSE_KEY']);
	if(isset($_SESSION['EGS_LICENSE_CODE']))
		define('EGS_LICENSE_CODE',$_SESSION['EGS_LICENSE_CODE']);
	require_once EGS_FILE_ROOT.'/src/classes/class.xml2array.php';
	
	$incoming = '';
	$incoming = urldecode(implode(file('php://input')));
	
	/*check the incoming is a valid id*/
	if(is_numeric($incoming)) {
		if (isset ($_GET['type']))
			$type = $_GET['type'];
	
		$length = strlen($incoming);
		
		$xmlobj=new xml2Array();
		
		
		$url='http://services.postcodeanywhere.co.uk/xml.aspx?'
		.'account_code='.urlencode(EGS_LICENSE_KEY)		///senok11115
		.'&license_code='.urlencode(EGS_LICENSE_CODE)			////BF96-PF44-PP39-ZD87
		.'&action=fetch'
		.'&id='.urlencode($incoming); 		//$incoming;'47264566.00'
		
		//echo $url;
		
		if(@$xmlfile=fopen($url,'r')) {
			
		
			$xmlstring='';
			while(!feof($xmlfile)) {
				$xmlstring.=fread($xmlfile,10000000);
			}
			fclose($xmlfile);
			$output=$xmlobj->parse($xmlstring);
			$return='';
			$atts=$output[0]['children'][1]['children'][0]['attrs'];
			
			if(isset($atts['LINE1']))$return.=$atts['LINE1'];
			$return.='@';
			if(isset($atts['LINE2']))$return.=$atts['LINE2'];
			$return.='@';
			if(isset($atts['LINE3']))$return.=$atts['LINE3'];
			$return.='@';
			if(isset($atts['LINE4']))$return.=$atts['LINE4'];
			$return.='@';
			if(isset($atts['POST_TOWN']))$return.=$atts['POST_TOWN'];
			$return.='@';
			if(isset($atts['COUNTY']))$return.=$atts['COUNTY'];
			$return.='@';
			if(isset($atts['POSTCODE']))$return.=$atts['POSTCODE'];
			echo $return;
		}
		else {
			echo 'Error:@Cannot connect to remote site';	
		}
	}
	else {
		echo "Error:@Invalid ID";
	}
		
}
else 
	echo "Error:@Not Logged In (or not set up)";
	?>