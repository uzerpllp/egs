<?xml version="1.0"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Enterprise Groupware System Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
{literal}
<style type="text/css">
<!--
body {
	margin: 0px;
	padding: 0px;
	color : #333;
	background-color : #FFF;
	font-size : 11px;
	font-family : Arial, Helvetica, sans-serif;
}

#wrapper {
        border: 0px;
        margin: 0px;
        margin-left: auto;
        margin-right: auto;
        padding: 0px;
}

#break {
	height: 50px;
}

form {
    margin: 0px;
}



.button {
	border : solid 1px #7F7F7F;
	background: #ccc5b8;
	color : #7F7F7F;
	font-weight : bold;
	font-size : 11px;
	padding: 4px;
}

.login {
	margin-left: auto;
	margin-right: auto;
	margin-top: 6em;
	padding: 15px;
	border: 1px solid #7F7F7F;
	width: 429px;
	background: #b8c2cc;
}

.login p {
	padding: 0 1em 0 1em;
	}
	
.form-block {
	border: 1px solid #7F7F7F;
	background: #737a80;
	padding-top: 15px;
	padding-left: 10px;
	padding-bottom: 10px;
	padding-right: 10px;
}

.login-form {
	text-align: left;
	float: right;
	width: 60%;
}

span.logintitle {
	font-size: 24px;
	color: #737a80;
	display: block;
}

.login-text {
	text-align: left;
	width: 40%;
	float: left;
}
.loginerror {
background-color: white;
	color: #f00;
	font-size: 10pt;
	

}

.inputlabel {
	font-weight: bold;
	text-align: left;
	color: white;
	}

.inputbox {
	width: 150px;
	margin: 0 0 1em 0;
	border: 1px solid #7F7F7F;
	}

.clr {
    clear:both;
    }

.ctr {
	text-align: center;
}

.version {
	font-size: 0.8em;
}

.footer {

}

-->
</style>
<script language="javascript" type="text/javascript">
	function setFocus() {
		document.login.username.select();
		document.login.username.focus();
	}
</script>
{/literal}
</head>
<body onload="setFocus();">
<div id="ctr" align="center">
	<div class="login">
		<div class="login-form"><span class="logintitle">login</span>
        	<form class="loginForm" name="login" action="{$serverRoot}/?{$session}" method="post">
			<div class="form-block">
				{if $error neq ''}<div class="loginerror">{$error}</div>{/if}
	        	<div class="inputlabel">Username</div>

		    	<div><input name="username" type="text" class="inputbox" size="15" /></div>
	        	<div class="inputlabel">Password</div>
		    	<div><input name="password" type="password" class="inputbox" size="15" /></div>
	        	<div align="left"><input type="submit" name="login" class="button" value="Login" /></div>
        	</div>
			</form>
    	</div>
		<div class="login-text">

			<div class="ctr"><img src="{$serverRoot}/themes/{$theme}/graphics/lock.gif" width="44" height="64" alt="security" /></div>
        	<p>Welcome to EGS!</p>
			<p>Please use a valid username and password to gain access to the system.</p>
    	</div>
		<div class="clr"></div>
	</div>
	
</div>
<div id="break"></div>

<noscript>
!Warning! Javascript must be enabled for proper operation of Enterprise Groupware System
</noscript>
<div class="footer" align="center">
<div align="center"><a href="http://www.senokian.com/">Senokian Solutions Ltd</a>. &copy; 2002 - {$currentYear|default:"2006"} All rights reserved.</div>
<div align="center"><a href="http://www.enterprisegroupwaresystem.org">Enterprise Groupware System</a> is Free Software released under the GNU/GPL License.</div></div>
</body>
</html>
