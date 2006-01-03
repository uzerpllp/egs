<?php
print("<H1>This file is only here as a REFERENCE Do NOT USE</h1>");
exit;


/*

  File: owl.php
  Author: Chris
  Date: 2000/12/14

  Owl: Copyright Chris Vincent <cvincent@project802.net>

  You should have received a copy of the GNU Public
  License along with this package; if not, write to the
  Free Software Foundation, Inc., 59 Temple Place - Suite 330,
  Boston, MA 02111-1307, USA.

*/

// Modified for Sambar Server by sambarx - 03-03-05

// Some urls
$default->owl_root_url		= "/intranet";
$default->owl_graphics_url	= $default->owl_root_url . "/graphics";
$default->system_ButtonStyle	= "Blue";

// Directory where owl is located
// this is the full physical path to where
// Owl was installed
$default->owl_fs_root		= "d:/sambar/docs/intranet";
$default->owl_LangDir		= $default->owl_fs_root . "/locale";

// Set to true to use the file system to store documents, false only 
// uses the database and files are stored in the filedata table.

$default->owl_use_fs            = true;

// Directory where The Documents Directory is On Disc
// This path should not include the Documents directory name
// only the path leading to it.
$default->owl_FileDir           =  "d:/sambar/docs/intranet";

// NOTE: There should be a directory writeable by the web server
//       called Documents in $default->owl_FileDir.  If you want to make 
//	 that a different name you need to rename this directory to what 
//	 ever you want then change the name of the Documents folder in 
//	 the folders table. Using mysql or pgsql update statment.
//	 Check the README FILE


// ***************************************************
// Use File System BEGIN
// ***************************************************

// Use the file system of the database to store the
// files uploaded.
// $default->owl_use_fs            = true		// This stores uploaded files to the Hard Drive
// $default->owl_use_fs            = false		// This stores uploaded files to a table in the database
// Note that temporary files are created to gzip files
// so set to something that is valid, and is writable by the web server
// For Example: $default->owl_FileDir           =  "/tmp/OWLDB";
// 
// NOTE: This feature is only functional with Mysql
// I don't plan on fixing this unless there is a big demand
// For this feature and Postgres.
// 

$default->owl_use_fs            = true;

//  set to 1 to compress the data in the database 
//  when using $default->owl_use_fs = false this compresses the data 
//  before storing to the database

//$default->owl_compressed_database = 1;

// ***************************************************
// Use File System END
// ***************************************************

//****************************************************
// Pick your language system default language
// now each user can pick his language
// if they are allowed by the admin to change their
// preferences.
//****************************************************
// b5
// Chinese
// Czech
// Danish
// Deutsch
// Dutch
// English
// Francais
// Hungarian
// Italian
// Norwegian
// Portuguese
// Russian
// Spanish

$default->owl_lang		= "English";


$default->owl_notify_link       = "http://" . $_SERVER["SERVER_NAME"] . $default->owl_root_url . "/";


// Table Prefix
$default->owl_table_prefix = "";
//$default->owl_table_prefix = "owl_";


// Table with user info
$default->owl_users_table		= $default->owl_table_prefix . "users";

// Table with group memebership for users 
$default->owl_users_grpmem_table	= $default->owl_table_prefix . "membergroup";
$default->owl_sessions_table 		= $default->owl_table_prefix . "active_sessions";

// Table with file info
$default->owl_files_table		= $default->owl_table_prefix . "files";

// Table with folders info
$default->owl_folders_table		= $default->owl_table_prefix . "folders";

// Table with group info
$default->owl_groups_table		= $default->owl_table_prefix . "groups";

// Table with mime info
$default->owl_mime_table		= $default->owl_table_prefix . "mimes";

// Table with html attributes
$default->owl_html_table		= $default->owl_table_prefix . "html";

// Table with html attributes
$default->owl_prefs_table		= $default->owl_table_prefix . "prefs";

// Table with file data info
$default->owl_files_data_table  	= $default->owl_table_prefix . "filedata";

// Table with files that are monitored
$default->owl_monitored_file_table  	= $default->owl_table_prefix . "monitored_file";

// Table with folders that are monitored
$default->owl_monitored_folder_table  	= $default->owl_table_prefix . "monitored_folder";

// Table with all logging
$default->owl_log_table  		= $default->owl_table_prefix . "owl_log";
 
// Table with all user comments
$default->owl_comment_table  		= $default->owl_table_prefix . "comments";
 
// Table with all news
$default->owl_news_table  		= $default->owl_table_prefix . "news";

// Search Tables
$default->owl_wordidx  			= $default->owl_table_prefix . "wordidx";
$default->owl_searchidx 		= $default->owl_table_prefix . "searchidx";

//**********************************************
// Global Date Format BEGIN
// -------------------------------------
//
// If you want one date format for all the language files
// set the variable bellow to the date patern of your
// Choice.   If you require a different pattern for 
// different lanugages, edit each language file
// and set your pattern in the Date Format Section of 
// each file
//
//
// Examples of Valid patterns:
//$default->generic_date_format 	= "Y-m-d"; 			// 2003-03-07
//$default->generic_date_format 	= "Y-m-d H:i:s";		// 2003-03-13 16:46:24
//$default->generic_date_format 	= "r";				// Thu, 13 Mar 2003 16:46:24 -0500
//$default->generic_date_format 	= "d-M-Y h:i:s a";		// 13-Mar-2003 04:46:24 pm
//$default->generic_date_format 	= "Y-m-d\\<\B\R\\>H:i:s";	// 2003-03-13<BR>16:46:24
//$default->generic_date_format         = "Y-M-d\\<\B\R\\>H:i ";  	// 2003-Mar-09<br>12:29 
//$default->generic_date_format         = "d-m-y\\<\B\R\\>H:i ";  	// 27-10-02<br>10:58
//$default->generic_date_format         = "D-M-Y\\<\B\R\\>H:i ";  	// Sun-Oct-2002<br>10:58 
//
// For more options check the php documentation:
// http://www.php.net/manual/en/function.date.php
//**********************************************

$default->generic_date_format 	= "";

//**********************************************
// Global Date Format END
//**********************************************

//**********************************************
// LookATHD Feature Filter Section BEGIN
// -------------------------------------
//
// Uncomment the 2 lines following this section
// to exclude files that have db or txt for 
// an extension
// 
// You can add as many extention as you need.
// and files with the extensions listed below
// are not added to the LookAtHD feature
//
//**********************************************

//$default->lookHD_ommit_ext[] = "db";
//$default->lookHD_ommit_ext[] = "txt";

//**********************************************
// LookATHD Feature Filter Section END
//**********************************************


// Change this to reflect the database you are using
require_once("$default->owl_fs_root/phplib/db_mysql.inc");
//require_once("$default->owl_fs_root/phplib/db_pgsql.inc");

//begin WES change
// Database info
//$default->owl_db_user           = "postgres";
$default->owl_db_user           = "root";
$default->owl_db_pass           = "";
$default->owl_db_host           = "localhost";
$default->owl_db_name           = "intranet";

// This is to display the version information in the footer

$default->version = "Owl 0.72 20031023";
$default->site_title = "Owl Intranet -- " . $default->version;
$default->phpversion = "4.1.0";

$default->debug = false;
$default->admin_login_to_browse_page = false;

?>
