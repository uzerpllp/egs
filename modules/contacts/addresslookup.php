<html><head>
<script type="text/javascript">
var finished="no";
function checkFinished() {
	if(finished=='yes') {
		window.close();
	}
	else {
	setTimeout('checkFinished()',250);	
		
	}
	
}
function chooseAddress(id) {
	document.getElementById('maindiv').style.backgroundColor='gray';
	document.getElementById('clickbutton').enabled='false';
	document.getElementById('clickbutton').value="Loading...";
	document.getElementById('clickbutton').onclick= new Function('return false');
	
	if (window.XMLHttpRequest) {xhr = new XMLHttpRequest();}
	else if (window.ActiveXObject) {xhr = new ActiveXObject("Microsoft.XMLHTTP");}
	else return false;
	if(!xhr) { return false;}
	
	address='http://intranet/src/ajax/postcodechoose.php';
	
	xhr.open("POST",address, true);
	xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');
	xhr.send(id);
	loading=0;
	var loadstring='Loading';
	xhr.onreadystatechange=function()
	{
		if (xhr.readyState==4)
		{

			if (xhr.responseText!="")
			{
				checkFinished();
				document.getElementById('maindiv').style.backgroundColor='white';
				var lines = xhr.responseText.split('@');
				if(lines[0]!='Error:') {
					window.opener.document.forms.saveform.street1.value=lines[0];
					window.opener.document.forms.saveform.street2.value=lines[1];
					window.opener.document.forms.saveform.street3.value=lines[2];
					window.opener.document.forms.saveform.town.value=lines[4];
					window.opener.document.forms.saveform.county.value=lines[5];
					window.opener.document.forms.saveform.postcode.value=lines[6];
					document.getElementById('clickbutton').onclick= new Function('window.close()');
					document.getElementById('clickbutton').value="Click to close...";
					finished='yes';
				}
				else {
					document.getElementById('testing').innerHTML=lines[0]+' '+lines[1];
					document.getElementById('clickbutton').attributes.onclick=chooseAddress(id);
					document.getElementById('clickbutton').value="Choose Again";
				}
			}
		}	
	}
	
}
</script>

<title>Address Lookup</title></head><body style="background-color:white;">
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

/*check for a logged in person, and that the postcodeanywhere details are stored*/
if ($_SESSION['EGS_LICENSE_KEY'] && $_SESSION['EGS_LICENSE_CODE'] && isset ($_SESSION['loggedIn']) && isset ($_SESSION['modules']) && in_array('contacts', $_SESSION['modules'])) {
	
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
	define('EGS_LICENSE_KEY',$_SESSION['EGS_LICENSE_KEY']);
	define('EGS_LICENSE_CODE',$_SESSION['EGS_LICENSE_CODE']);
	require_once EGS_FILE_ROOT.'/src/classes/class.xml2array.php';
	$_GET['postcode'] = str_replace(" ", "", $_GET['postcode']);
	/*check for a valid postcode*/
	if (preg_match("/[a-zA-Z]{1,2}\d{2,3}[a-zA-Z]{2}/", $_GET['postcode']) > 0) {
		
		/*get the xml from the remote site*/
		$xmlobj=new xml2Array();
		//
		$postcode=$_GET['postcode'];
		
		$url='http://services.postcodeanywhere.co.uk/xml.aspx?'
		.'account_code='.urlencode(EGS_LICENSE_KEY)		///senok11115
		.'&license_code='.urlencode(EGS_LICENSE_CODE)			////BF96-PF44-PP39-ZD87
		.'&action=lookup&type=by_postcode'
		.'&postcode='.urlencode($postcode);
		
		
		
		if(@$xmlfile=fopen($url,'r')) {
			$xmlstring='';
			while(!feof($xmlfile)) {
				$xmlstring.=fread($xmlfile,10000000);
			}
			fclose($xmlfile);
			
			$output=$xmlobj->parse($xmlstring);
			
			
			echo '<h1>'._('Choose an address:').'</h1>';
			echo '<div id="maindiv" style="border: 1px solid black;text-align:center;padding:10px">';
			echo '<select size="10" name="addresses" id="addresses" style="border: 1px solid black;">';
			
			foreach($output[0]['children'][1]['children'] as $item) {
				$id=$item['attrs']['ID'];
				$description=$item['attrs']['DESCRIPTION'];
				echo '<option value="'.$id,'">'.$description.'</option>';
			}
			echo '</select>';
			echo '<input id="clickbutton" type="submit" name="choose-address-submit" value="Choose" onclick="chooseAddress(document.getElementById(\'addresses\').options[document.getElementById(\'addresses\').options.selectedIndex].value)" />';
		
			echo '</div>';
			
		}
		else
			echo 'Cannot connect to remote site';
	}
	else {
		echo 'Not a valid Postcode';
	}
}
else {
	echo 'Not Logged In/Postcode lookup not configured';	
}

?>
</body></html>