<?php
/*
 * admin/hddelcron.php
 *
 * Written by: B0zz
 *
 * Copyright (c) 1999-2003 The Owl Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 *
 */



// *******************************************************************************************
// This script is NOT desiged to work with
// DB only stored files ie owl_use_fs = false
// 
// This script will NOT work with Postgresql
//
// You can run this from your browser on demand or
// you  can setup a cron job to run this script
// at your leisure.
//
// This script was designer to replace the LookAtHD Delete
// Feature. As at some very large site, the LookAtHD Delete
// Feature can degrade the webservers performance. 
//
// Here is an examble of a cron job that runs every half hour.
//
// 59,29 * * * * lynx -dump http://localhost/intranet/admin/tools/hddelcron.php?type=both > /dev/null
//
// This would clean up all delete files and folders from that database
// that have been deleted from the file system.
//
// Hope this is usefull to someone.
//
//	Usage: hddelcron.php?type=ActionType&verbose=DetailLevel
//
//	DetailLevel
//	1 Display Deleted Items
//	0 Silent
//
//	Action Type
// 	file	To delete files from the Database that have been removed from the File System
//	folder 	To delete folders from the Database that have been removed from the File System
//	both 	To delete files and Folders from the Database that have been removed from the File System
//
//
// 	PLEASE BACKUP YOUR DATABASE THIS SCRIPT HAS THE POTENTIAL TO
//   	DELETE ALL FILES AND ALL FOLDER ENTRIES IN YOUR DATABASE.
//
//	mysqldump -u username -p > mydbdump.sql
//
// *******************************************************************************************


// **************************************
// Globals as per config/owl.php
// **************************************

$default->owl_files_table       	= "files";
$default->owl_folders_table     	= "folders";
$default->owl_monitored_file_table  	= "monitored_file";
$default->owl_monitored_folder_table  	= "monitored_folder";
$default->owl_comment_table  		= "comments";

$default->owl_FileDir           =  "/var/www/html/intranet";

$default->owl_db_user           = "someuser";
$default->owl_db_pass           = "";
$default->owl_db_host           = "localhost";
$default->owl_db_name           = "intranet";


// **************************************
// Register Globals = Off
// **************************************

if (substr(phpversion(),0,5) >= "4.1.0")
        import_request_variables('pgc');
 else {
        if (!EMPTY($_POST)) {
                extract($_POST);
        } else {
                extract($HTTP_POST_VARS);
        }
        if (!EMPTY($_GET)) {
                extract($_GET);
        } else {
                extract($HTTP_GET_VARS);
        }
        if (!EMPTY($_FILE)) {
                extract($_FILE);
        } else {
                extract($HTTP_POST_FILES);
        }
}

if(!file_exists($default->owl_FileDir)) {
	print("<font size=4 color=red>SEVERE ERROR:</font><font size=4>  \$default->owl_FileDir was not found '$default->owl_FileDir'<BR><BR> Script Terminating</font>");
	exit;
}

	


// **************************************
// MAIN BEGIN
// **************************************
if(isset($type)) {
	if($type == "file") {
		$somethingwasdeleted = DeleteDBFolderzNotInDB($default->owl_files_table,$verbose,$type);
	} elseif ($type == "folder") {
		$somethingwasdeleted = DeleteDBFolderzNotInDB($default->owl_folders_table,$verbose,$type);
	} elseif ($type == "both") {
		$somethingwasdeleted = DeleteDBFolderzNotInDB($default->owl_files_table,$verbose,$type);
		$somethingwasdeleted = DeleteDBFolderzNotInDB($default->owl_folders_table,$verbose,$type);
	} else {
		pringUsage(); 
	}
} else {
	pringUsage(); 
}

// **************************************
// MAIN END
// **************************************


// **************************************
// Functions Section BEGIN
// **************************************

// **************************************
// Main function that does the work
// **************************************

function DeleteDBFolderzNotInDB($table, $verbose,$type) {
	global $default;
	if($verbose == 1) {
		if($default->owl_files_table == $table) {
			print("<h2>Begin File Script...</h2>");
		}
		if($default->owl_folders_table == $table) {
			print("<h2>Begin Folder Script...</h2>");
		}
	}
  	$somethingwasdeleted = false;

	$dblink = mysql_connect("$default->owl_db_host","$default->owl_db_user","$default->owl_db_pass") or die ("could not connect") ;

  	if ($table == $default->owl_files_table) {
  		$query = "select id,parent,filename from $table where url <> 1";
	} else {
  		$query = "select id,name from $table order by parent desc";
	}

	$get = mysql_db_query($default->owl_db_name,$query,$dblink) or die ("GET QUERY FAILED");

	while($getrow = mysql_fetch_row ($get)) {
		if ($table == $default->owl_files_table) {
      			$dbfolder = $default->owl_FileDir . "/" . get_dirpath($getrow[1]) . "/" . $getrow[2];
   		} else {
      			$dbfolder = $default->owl_FileDir . "/" . get_dirpath($getrow[0]);
   		}
   		if(!file_exists($dbfolder)) {
     			$delid = $getrow[0];
			$db_del_link = mysql_connect("$default->owl_db_host","$default->owl_db_user","$default->owl_db_pass") or die ("could not connect") ;
  			$delquery = "delete from $table where id = '$delid'";
			$del = mysql_db_query($default->owl_db_name,$delquery,$db_del_link) or die ("DELETE QUERY FAILED");
			 if ($table == $default->owl_files_table) {
                                // Clean up all monitored files with that id
                                $delquery = "DELETE from $default->owl_monitored_file_table where fid = '$delid'";
				$del = mysql_db_query($default->owl_db_name,$delquery,$db_del_link) or die ("DELETE MONITORED FILE QUERY FAILED");
                                // Clean up all comments with this file 
                                $delquery = "DELETE from $default->owl_comment_table where fid = '$delid'";
				$del = mysql_db_query($default->owl_db_name,$delquery,$db_del_link) or die ("DELETE COMMENT QUERY FAILED");
                        } else {
                                $delquery = "DELETE from $default->owl_monitored_folder_table where fid = '$delid'";
				$del = mysql_db_query($default->owl_db_name,$delquery,$db_del_link) or die ("DELETE MONITORED FOLDERQUERY FAILED");
                        }


     			$somethingwasdeleted = true;
			if($verbose == 1) {
					
				if($default->owl_files_table == $table) {
					print("Deleted file '$dbfolder' from the database<BR>");
				}
				if($default->owl_folders_table == $table) {
					print("Deleted file '$dbfolder' from the database<BR>");
				}
			}
   		}
  	}
    	mysql_free_result($get);
	if($verbose == 1) {
		if($default->owl_files_table == $table) {
			print("<h2>End File Script...</h2>");
		}
		if($default->owl_folders_table == $table) {
			print("<h2>End Folder Script...</h2>");
		}
	}

  return $somethingwasdeleted;
}


// **************************************
// Function that returns the path 
// of the file or folder
// **************************************

function get_dirpath($parent) {
        global $default;
        $name = fid_to_name($parent);
        $navbar = "$name";
        $new = $parent; 
        while ($new != "1") {
        	$dblink = mysql_connect("$default->owl_db_host","$default->owl_db_user","$default->owl_db_pass") or die ("could not connect") ;
		$query = "select parent from $default->owl_folders_table where id = '$new'";
        	$getparent = mysql_db_query($default->owl_db_name,$query,$dblink) or die ("QUERY FAILED");
		$row = mysql_fetch_row ($getparent);
    		mysql_free_result($getparent);
    		mysql_close($dblink);
                $newparentid = $row[0];
                if($newparentid == "") break;
                $name = fid_to_name($newparentid);
                $navbar = "$name/" . $navbar;
                $new = $newparentid;
        }
        return $navbar;
}

function fid_to_name($parent) {
        global $default;

        $dblink = mysql_connect("$default->owl_db_host","$default->owl_db_user","$default->owl_db_pass") or die ("could not connect") ;
	$query = "select name from $default->owl_folders_table where id = '$parent'";
        $getname = mysql_db_query($default->owl_db_name,$query,$dblink) or die ("QUERY FAILED");
	$row = mysql_fetch_row ($getname);
    	mysql_free_result($getname);
    	mysql_close($dblink);
        return $row[0];;
}

function pringUsage () {
	print("<B>Usage:<B> hddelcron.php?type=ActionType&verbose=DetailLevel<BR><BR>");
	print("<B>DetailLevel<B><BR>");
	print("<TABLE>\n");
	print("<TR><TD width=90 align=left><B><font color=red>1</font></B></TD><TD>Display Deleted Items</TD></TR>");
	print("<TR><TD width=90 align=left><B><font color=red>0</font></B></TD><TD>Silent</TD></TR>");
	print("</TABLE><BR>");
	
	print("<B>Action Type<B><BR>");
	print("<TABLE>\n");
	print("<TR><TD width=90 align=left><B><font color=red>file</font></B></TD><TD>To delete files from the Database that have been removed from the File System </TD></TR>");
	print("<TR><TD width=90 align=left><B><font color=red>folder</font></B></TD><TD>To delete folders from the Database that have been removed from the File System </TD></TR>");
	print("<TR><TD width=90 align=left><B><font color=red>both</font></B></TD><TD>To delete files and Folders from the Database that have been removed from the File System </TD></TR>");
	print("</TABLE>");
}
?>
