<?php

/* $Revision: 1.20 $ */
	// Titles and screen header
	// Needs the file config.php loaded where the variables are defined for
	//  $rootpath
	//  $title - should be defined in the page this file is included with

	echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">';
	
	
	echo '<HTML><HEAD><TITLE>' . $title . '</TITLE>';
	echo '<link REL="shortcut icon" HREF="favicon.ico">';
	echo '<link REL="icon" HREF="favicon.ico">';
	echo '<meta http-equiv="Content-Type" content="text/html; charset=' . _('ISO-8859-1') . '">';
	echo '<LINK HREF="css/'. $_SESSION['Theme'] .'/default.css" REL="stylesheet" TYPE="text/css">';
	echo '</HEAD>';

	echo '<BODY>';


?>