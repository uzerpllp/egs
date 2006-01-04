<?php

/* Set the amount of memeory EGS can use
 * If you find things just appear blank, such as the calendar module it is normally
 * becuase this is set too low.
 */
ini_set('memory_limit', '16M');

/* Uncomment to set the session save directory */
//session_save_path('/tmp');

/* File System path to EGS directory */
DEFINE('EGS_FILE_ROOT', '/path/to/egs');

/* Web address of site */
DEFINE('EGS_SERVER', 'http://where-egs-is');

/* Tempory directory for file uploads */
DEFINE('EGS_TMP_DIR', '/tmp');

/* The database credentials */
define('EGS_DB_TYPE', 'pgsql');
define('EGS_DB_USER', 'user');
define('EGS_DB_PASSWORD', 'password');
define('EGS_DB_HOST', 'localhost');
define('EGS_DB_DATABASE', 'egsdb');

/* Set the length of time a login is valid for (in seconds) */
DEFINE('EGS_LOGIN_TIME', 3600);

/* Anything after here should only be changed if you know what you are doing */

/* Set this to true if you want to use the smarty template debugging */
DEFINE('EGS_DEBUG_THEME', false);

/* Set this to true if you wish to output DB errors to the browser */
DEFINE('EGS_DEBUG_SQL', false);

/* Set this to true if you wish to log errors to the database */
DEFINE('EGS_LOG_TO_SQL', false);

/* Set this to true if you want to perform an mx lookup when entering an email
 * this can slow the system down as the server has to go off and communicate
 * with the remote server */
DEFINE('EGS_MX_LOOKUP', false);

/* Employees Options */
$employees[0] = _('None');
$employees[1] = '1-10';
$employees[2] = '11-20';
$employees[3] = '21-50';
$employees[4] = '51-100';
$employees[5] = '101-500';
$employees[6] = '>500';

/* Company Types */
$companyTypes['LTD'] = _('Limited Company');
$companyTypes['PLC'] = _('Public Limited Company');
$companyTypes['PTNR'] = _('Partnership');
$companyTypes['STRA'] = _('Sole Trader');
$companyTypes['LLP'] = _('Limited Liability Partnership');
$companyTypes['IP'] = _('Industrial/Provident Registered Company');
$companyTypes['IND'] = _('Individual (representing self)');
$companyTypes['SCH'] = _('School');
$companyTypes['RCHAR'] = _('Registered Charity');
$companyTypes['GOV'] = _('Government Body');
$companyTypes['CRC'] = _('Corporation by Royal Charter');
$companyTypes['STAT'] = _('Statutory Body');
$companyTypes['OTHER'] = _('Other');
$companyTypes['FIND'] = _('Foreign Individual');
$companyTypes['FCORP'] = _('Foreign Corporation');
$companyTypes['FOTHER'] = _('Foreign Other');

/* Set to true if you want to use the OpenSRS/Nominet Plugins */
DEFINE('EGS_DOMAIN_ADMIN', false);

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

// Some urls
// owl_root_url below should not contain http://servername/intranet, but
// just the URL from the root of the web server.

$default->owl_root_url		= EGS_SERVER."/modules/filesharing";
$default->owl_graphics_url	= $default->owl_root_url . "/graphics";

// Ensure that the system_ButtonStyle you choose is a style that exists in 
// all locale
$default->system_ButtonStyle	= "rsdx_blue1";
//$default->system_ButtonStyle	= "Blue";

// Directory where owl is located
// this is the full physical path to where
// Owl was installed
$default->owl_fs_root		= EGS_FILE_ROOT.'/modules/filesharing';
$default->owl_LangDir		= $default->owl_fs_root . "/locale";

// Directory where The Documents Directory is On Disc
// This path should not include the Documents directory name
// only the path leading to it.

$default->owl_FileDir           =  EGS_FILE_ROOT.'/modules/filesharing/Documents';

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
// Brazilian
// Bulgarian
// Chinese
// CVS
// Czech
// Danish
// Deutsch
// Dutch
// English
// Francais
// Hungarian
// Italian
// Norwegian
// Polish
// Portuguese
// Russian
// Spanish
// 

$default->owl_lang		= "English";
$default->owl_notify_link       = "http://" . $_SERVER["SERVER_NAME"] . $default->owl_root_url . "/";


// Table Prefix
$default->owl_table_prefix = "company1.";
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

// Custom Document Fields Tables
$default->owl_docfields_table		= $default->owl_table_prefix . "docfields";
$default->owl_docfieldslabel_table	= $default->owl_table_prefix . "docfieldslabel";
$default->owl_doctype_table          	= $default->owl_table_prefix . "doctype";
$default->owl_docfieldvalues_table	= $default->owl_table_prefix . "docfieldvalues";

// Custom Document Fields Tables
$default->owl_keyword_table		= $default->owl_table_prefix . "metakeywords";

// Custom Document Fields Tables
$default->owl_peerreview_table		= $default->owl_table_prefix . "peerreview";

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


// to exclude Folders 
// Carefull as this applies to that foldername in any directory

$default->lookHD_ommit_directory[] = "CVS";

//**********************************************
// LookATHD Feature Filter Section END
//**********************************************

//**********************************************
// OMMIT FILES Section BEGIN
//**********************************************

//$default->upload_ommit_ext[] = "pdf";
//$default->upload_ommit_ext[] = "exe";

//**********************************************
// OMMIT FILES Section END
//**********************************************

//**********************************************
// LookATHD Feature Filter Section END
//**********************************************

// Change this to reflect the database you are using
// Mysql 
//require_once("$default->owl_fs_root/phplib/db_mysql.inc");
// Oracle  
//require_once("$default->owl_fs_root/phplib/db_oci8.inc");
// PostgreSQL  
require_once("$default->owl_fs_root/phplib/db_pgsql.inc");


//**********************************************
// Database info BEGIN
//**********************************************
                                                                                                                                                                                                
$default->owl_default_db = 0;    // This indicates what database should be selected by Default  when multiple repositories are defined
                                             
// First Database Information
$default->owl_db_id[0]           = "0";
$default->owl_db_user[0]           = EGS_DB_USER;
$default->owl_db_pass[0]           = EGS_DB_PASSWORD;
$default->owl_db_host[0]           = EGS_DB_HOST;
$default->owl_db_name[0]           = EGS_DB_DATABASE;
$default->owl_db_display_name[0]   = "EGS";
$default->owl_db_FileDir[0]           =  EGS_FILE_ROOT.'/modules/filesharing';
                                                                                                                                                                                                
// Second Database
                                                                                                                                                                                                
//$default->owl_db_id[1]           = "1";
//$default->owl_db_user[1]           = "root";
//$default->owl_db_pass[1]           = "";
//$default->owl_db_host[1]           = "localhost";
//$default->owl_db_name[1]           = "extranet";
//$default->owl_db_display_name[1]           = "Extranet";
//$default->owl_db_FileDir[1]           =  "/var/www/html/";
                                                                                                                                                                                                
// Third Database and so on and so on....
                                                                                                                                                                                                
//**********************************************
// Database info END
//**********************************************

// This is to display the version information in the footer

$default->version = "Owl 0.80 20050208";
$default->site_title = "Owl Intranet -- DEV -- " . $default->version;
$default->phpversion = "4.3.10";

$default->debug = true;

// BEGIN Drop Down Menu Order

$default->FolderMenuOrder = array(
'folder_delete', 
'folder_edit', 
'folder_copy', 
'folder_move', 
'folder_monitor', 
'folder_download'
);
$default->FileMenuOrder = array(
'file_log',
'file_delete',
'file_edit',
'file_link',
'file_copy',
'file_move',
'file_update',
'file_download',
'file_comment',
'file_lock',
'file_email',
'file_monitor',
'file_find',
'file_view'
);

// END Drop Down Menu Order

// BEGIN WORDIDX exlusion List
$default->words_to_exclude_from_wordidx[] = "the";
$default->words_to_exclude_from_wordidx[] = "a";
$default->words_to_exclude_from_wordidx[] = "is";
$default->words_to_exclude_from_wordidx[] = "on";
$default->words_to_exclude_from_wordidx[] = "or";
$default->words_to_exclude_from_wordidx[] = "he";
$default->words_to_exclude_from_wordidx[] = "she";
$default->words_to_exclude_from_wordidx[] = "his";
$default->words_to_exclude_from_wordidx[] = "her";
// END WORDIDX

// This is for adding a view icon to file types
// that are not currently supported by Owl
// DO NOT ADD FILE Types that already have
// a view icon (the magnifying glass) Or you will endup with 2 of them

$default->view_other_file_type_inline[] = "Your-Extension-without-the-dot-here";


$default->list_of_chars_to_remove_from_wordidx = "\"?$()/\*.;:,";

$default->list_of_valid_chars_in_file_names = "-A-Za-z0-9._[:space:]ÀàÁáÂâÃãÄäÅåÆæÇçÈèÉéÊêËëÌìÍíÎîÐðÏïÑñÒòÓóÔôÕõÖö×÷ØøÙùÚúÛûÜüÝýßÞþÿ()@#$\{}+,";

$default->default_sort_column = "name"; // Values are: name -- major_minor_revision -- filename -- f_size -- creatorid -- smodified -- sortchecked_out
$default->default_sort_order = "ASC";  // Values are ASC OR DESC

$default->charset = "UTF-8";

// This removes the ability to set a password on Files or Folders
$default->display_password_override = 1;

// Sets the Defautl MASK when OWL Creates a directory;
$default->directory_mask = 0777;
//$default->directory_mask = 02777;

// What authitencation should Owl Use.
// 0 = Old Standard Owl Authentication
// 1 = .htaccess authentication (username must also exists as the Owl users Table)
// 2 = pop3 authentication (username must also exists as the Owl users Table)
// 3 = LDAP authentication (username must also exists as the Owl users Table)

$default->auth = 0;

// Auth 2  POP3
$default->auth_port = "110";
$default->auth_host = "192.168.11.41";

// Auth 3 LDAP
$default->ldapserver = "host name or ip of ldap box";
$default->ldapserverroot = "ou=People,dc=??????,dc=???";
$default->ldapuserattr = "uid"; // whatever holds logon name in your ldap schema
$default->ldapprotocolversion = "3"; // or 2 to match your ldap


// If you are behind a load-balanced proxy, thus the IP
// changes, you get an "session in use" error, because
// active sessions are checked against the tripple (sessid,uid,ip). 
//
// DEFAULT
// true ---> track it as yet, i.e. (sessid,uid,ip)
//
// false --> track it alternate, i.e. (sessid,uid)
$default->active_session_ip = false;

/* Flyspray Setup */
/* Location of your Flyspray installation */
$basedir = "/mnt/websites/egs/egs/modules/projects/";
$cookiesalt = "e7";
$adodbpath = "/mnt/websites/egs/egs/src/adodb/adodb.inc.php";
/* Available options: "off", "on" and "gzip" */
$output_buffering = "on"; 

$dbtype = 'pgsql'; 
$dbhost = EGS_DB_HOST;
$dbname = EGS_DB_DATABASE;
$dbuser = EGS_DB_USER;
$dbpass = EGS_DB_PASSWORD;
$dbprefix = 'flyspray';

/* $Revision: 1.2 $ */
	/*--------------------------------------------------\
	| 		|               | config.php        |
	|---------------------------------------------------|
	| Web-ERP - http://web-erp.sourceforge.net          |
	| by Logic Works Ltd                                |
	|---------------------------------------------------|
	|                                                   |
	\--------------------------------------------------*/

// User configurable variables
//---------------------------------------------------

//DefaultLanguage
$DefaultLanguage ='en_GB';

// Whether to display the demo login and password or not 
$allow_demo_mode = True;

// Application version
$Version = '3.00';

// The timezone of the business - this allows the possibility of having
// the web-server on a overseas machine but record local time
// this is not necessary if you have your own server locally
// putenv('TZ=Europe/London');
// putenv('Australia/Melbourne');
// putenv('Australia/Sydney');
// putenv('TZ=Pacific/Auckland');

// Connection information for the database
// $host is the computer ip address or name where the database is located
// assuming that the web server is also the sql server
$host = EGS_DB_HOST;

//The type of db server being used - currently only postgres or mysql
//$dbType = 'mysql';
$dbType = 'postgres';
//$dbType = 'mysql';

$DatabaseName = EGS_DB_DATABASE;

// sql user & password
$dbuser = EGS_DB_USER;
$dbpassword = EGS_DB_PASSWORD;

//The maximum time that a login session can be idle before automatic logout
//time is in seconds  3600 seconds in an hour
$SessionLifeTime = 3600;

//The maximum time that a script can execute for before the web-server should terminate it
$MaximumExecutionTime =120;

//The path to which session files should be stored in the server
//this can be left commented out if only one company is running on the server
//However if multiple webERP installations are on the same server then a separate session directory is required for each install
//$SessionSavePath = '/tmp';


// which encryption function should be used
//$CryptFunction = "md5"; // MD5 Hash
//$CryptFunction = "sha1"; // SHA1 Hash
$CryptFunction = ""; // Plain Text



// END OF USER CONFIGURABLE VARIABLES




/*The $rootpath is used in most scripts to tell the script the installation details of the files.

NOTE: In some windows installation this command doesn't work and the administrator must set this to the path of the installation manually:
eg. if the files are under the webserver root directory then rootpath =''; if they are under weberp then weberp is the rootpath - notice no additional slashes are necessary.
*/

$rootpath = dirname($_SERVER['PHP_SELF']);
//$rootpath = '/web-erp';

/* Report all errors except E_NOTICE
This is the default value set in php.ini for most installations but just to be sure it is forced here
turning on NOTICES destroys things */

error_reporting (E_ALL & ~E_NOTICE);

/*Dont modify this bit
function required if gettext is not installed */

if (!function_exists('_')){
	function _($text){
		return ($text);
	}
}

// Configuration file for PHP iCalendar 2.0
//
// To set values, change the text between the single quotes
// Follow instructions to the right for detailed information

$template 				= 'default';		// Template support
$default_view 			= 'day';			// Default view for calendars = 'day', 'week', 'month', 'year'
$minical_view 			= 'current';		// Where do the mini-calendars go when clicked? = 'day', 'week', 'month', 'current'
$default_cal 			= $ALL_CALENDARS_COMBINED;		// Exact filename of calendar without .ics. Or set to $ALL_CALENDARS_COMBINED to open all calenders combined into one.
$language 				= 'English';		// Language support - 'English', 'Polish', 'German', 'French', 'Dutch', 'Danish', 'Italian', 'Japanese', 'Norwegian', 'Spanish', 'Swedish', 'Portuguese', 'Catalan', 'Traditional_Chinese', 'Esperanto', 'Korean'
$week_start_day 		= 'Sunday';			// Day of the week your week starts on
$day_start 				= '0700';			// Start time for day grid
$day_end				= '2300';			// End time for day grid
$gridLength 			= '15';				// Grid distance in minutes for day view, multiples of 15 preferred
$num_years 				= '1';				// Number of years (up and back) to display in 'Jump to'
$month_event_lines 		= '1';				// Number of lines to wrap each event title in month view, 0 means display all lines.
$tomorrows_events_lines = '1';				// Number of lines to wrap each event title in the 'Tommorrow's events' box, 0 means display all lines.
$allday_week_lines 		= '1';				// Number of lines to wrap each event title in all-day events in week view, 0 means display all lines.
$week_events_lines 		= '1';				// Number of lines to wrap each event title in the 'Tommorrow's events' box, 0 means display all lines.
$timezone 				= '';				// Set timezone. Read TIMEZONES file for more information
$calendar_path 			= '';				// Leave this blank on most installs, place your full FILE SYSTEM PATH to calendars if they are outside the phpicalendar folder.
$second_offset			= '';				// The time in seconds between your time and your server's time.
$bleed_time				= '-1';				// This allows events past midnight to just be displayed on the starting date, only good up to 24 hours. Range from '0000' to '2359', or '-1' for no bleed time.
$cookie_uri				= ''; 				// The HTTP URL to the PHP iCalendar directory, ie. http://www.example.com/phpicalendar -- AUTO SETTING -- Only set if you are having cookie issues.
$download_uri			= ''; 				// The HTTP URL to your calendars directory, ie. http://www.example.com/phpicalendar/calendars -- AUTO SETTING -- Only set if you are having subscribe issues.
$default_path			= ''; 				// The HTTP URL to the PHP iCalendar directory, ie. http://www.example.com/phpicalendar
$charset				= 'UTF-8';			// Character set your calendar is in, suggested UTF-8, or iso-8859-1 for most languages.

// Yes/No questions --- 'yes' means Yes, anything else means no. 'yes' must be lowercase.
$allow_webcals 			= 'no';				// Allow http:// and webcal:// prefixed URLs to be used as the $cal for remote viewing of "subscribe-able" calendars. This does not have to be enabled to allow specific ones below.
$this_months_events 	= 'yes';			// Display "This month's events" at the bottom off the month page.
$enable_rss				= 'yes';			// Enable RSS access to your calendars (good thing).
$show_search			= 'yes';			// Show the search box in the sidebar.
$allow_preferences		= 'no';			// Allow visitors to change various preferences via cookies.
$printview_default		= 'no';				// Set print view as the default view. day, week, and month only supported views for $default_view (listed well above).
$show_todos				= 'yes';			// Show your todo list on the side of day and week view.
$show_completed			= 'yes';				// Show completed todos on your todo list.
$allow_login			= 'no';				// Set to yes to prompt for login to unlock calendars.
$login_cookies			= 'no';			// Set to yes to store authentication information via (unencrypted) cookies. Set to no to use sessions.

// Calendar Caching (decreases page load times)
$save_parsed_cals 		= 'no';				// Saves a copy of the cal in /tmp after it's been parsed. Improves performence.
$tmp_dir				= '/tmp';			// The temporary directory on your system (/tmp is fine for UNIXes including Mac OS X). Any php-writable folder works.
$webcal_hours			= '24';				// Number of hours to cache webcals. Setting to '0' will always re-parse webcals.

// Webdav style publishing
$phpicalendar_publishing = '';				// Set to '1' to enable remote webdav style publish. See 'calendars/publish.php' for complete information;

// Administration settings (/admin/)
$allow_admin			= 'yes';			// Set to yes to allow the admin page - remember to change the default password if using 'internal' as the $auth_method			
$auth_method			= 'ftp';			// Valid values are: 'ftp', 'internal', or 'none'. 'ftp' uses the ftp server's username and password as well as ftp commands to delete and copy files. 'internal' uses $auth_internal_username and $auth_internal_password defined below - CHANGE the password. 'none' uses NO authentication - meant to be used with another form of authentication such as http basic.
$auth_internal_username	= 'admin';			// Only used if $auth_method='internal'. The username for the administrator.
$auth_internal_password	= 'admin';			// Only used if $auth_method='internal'. The password for the administrator.
$ftp_server				= 'localhost';		// Only used if $auth_method='ftp'. The ftp server name. 'localhost' will work for most servers.
$ftp_port				= '21';				// Only used if $auth_method='ftp'. The ftp port. '21' is the default for ftp servers.
$ftp_calendar_path		= '';				// Only used if $auth_method='ftp'. The full path to the calendar directory on the ftp server. If = '', will attempt to deduce the path based on $calendar_path, but may not be accurate depending on ftp server config.

// Calendar colors
//
// You can increase the number of unique colors by adding additional images (monthdot_n.gif) 
// and in the css file (default.css) classes .alldaybg_n, .eventbg_n and .eventbg2_n
// Colors will repeat from the beginning for calendars past $unique_colors (7 by default), with no limit.
$unique_colors			= '7';				

$blacklisted_cals[] = '';					// Fill in between the quotes the name of the calendars 
$blacklisted_cals[] = '';					// you wish to 'blacklist' or that you don't want to show up in your calendar
$blacklisted_cals[] = '';					// list. This should be the exact calendar filename without .ics
$blacklisted_cals[] = '';					// the parser will *not* parse any cal that is in this list (it will not be Web accessible)
// add more lines as necessary

$list_webcals[] = '';						// Fill in between the quotes exact URL of a calendar that you wish
$list_webcals[] = '';						// to show up in your calendar list. You must prefix the URL with http://
$list_webcals[] = '';						// or webcal:// and the filename should contain the .ics suffix
$list_webcals[] = '';						// $allow_webcals does *not* need to be "yes" for these to show up and work
// add more lines as necessary

$locked_cals[] = '';						// Fill in-between the quotes the names of the calendars you wish to hide
$locked_cals[] = '';						// unless unlocked by a username/password login. This should be the
$locked_cals[] = '';						// exact calendar filename without the .ics suffix.
$locked_cals[] = '';						//
// add more lines as necessary

$locked_map['user1:pass'] = array('');		// Map username:password accounts to locked calendars that should be
$locked_map['user2:pass'] = array('');		// unlocked if logged in. Calendar names should be the same as what is
$locked_map['user3:pass'] = array('');		// listed in the $locked_cals, again without the .ics suffix.
$locked_map['user4:pass'] = array('');		// Example: $locked_map['username:password'] = array('Locked1', 'Locked2');
// add more lines as necessary

$apache_map['user1'] = array('');			// Map HTTP authenticated users to specific calendars. Users listed here and
$apache_map['user2'] = array('');			// authenticated via HTTP will not see the public calendars, and will not be
$apache_map['user3'] = array('');			// given any login/logout options. Calendar names not include the .ics suffix.
$apache_map['user4'] = array('');			// Example: $apache_map['username'] = array('Calendar1', 'Calendar2');
// add more lines as necessary
error_reporting (E_ALL);
/**
 * This is DokuWiki's Main Configuration file
 * This is a piece of PHP code so PHP syntax applies!
 *
 * For help with the configuration see http://www.splitbrain.org/dokuwiki/wiki:config
 */


/* Datastorage and Permissions */

$conf['umask']       = 0111;              //set the umask for new files
$conf['dmask']       = 0000;              //directory mask accordingly
$conf['lang']        = 'en';              //your language
$conf['basedir']     = '';                //relative dir to serveroot - blank for autodetection
$conf['datadir']     = './data';          //where to store the data
$conf['olddir']      = './attic';         //where to store old revisions
$conf['mediadir']    = './media';         //where to store media files
$conf['changelog']   = './changes.log';   //change log

/* Display Options */

$conf['start']       = 'start';           //name of start page
$conf['title']       = 'DokuWiki';        //what to show in the title
$conf['template']    = 'default';         //see tpl directory
$conf['fullpath']    = 0;                 //show full path of the document or relative to datadir only? 0|1
$conf['recent']      = 20;                //how many entries to show in recent
$conf['breadcrumbs'] = 5;                //how many recent visited pages to show
$conf['typography']  = 1;                 //convert quotes, dashes and stuff to typographic equivalents? 0|1
$conf['htmlok']      = 0;                 //may raw HTML be embedded? This may break layout and XHTML validity 0|1
$conf['phpok']       = 0;                 //may PHP code be embedded? Never do this on the internet! 0|1
$conf['dformat']     = 'Y/m/d H:i';       //dateformat accepted by PHPs date() function
$conf['signature']   = ' --- //[[@MAIL@|@NAME@]] @DATE@//'; //signature see wiki:config for details
$conf['maxtoclevel'] = 3;                 //Up to which level include into AutoTOC (max. 5)
$conf['maxseclevel'] = 3;                 //Up to which level create editable sections (max. 5)
$conf['camelcase']   = 0;                 //Use CamelCase for linking? (I don't like it) 0|1
$conf['deaccent']    = 1;                 //convert accented chars to unaccented ones in pagenames?
$conf['useheading']  = 1;                 //use the first heading in a page as its name

/* Antispam Features */

$conf['usewordblock']= 1;                 //block spam based on words? 0|1
$conf['indexdelay']  = 60*60*24*5;        //allow indexing after this time (seconds) default is 5 days
$conf['relnofollow'] = 1;                 //use rel="nofollow" for external links?
$conf['mailguard']   = 'hex';             //obfuscate email addresses against spam harvesters?
                                          //valid entries are:
                                          //  'visible' - replace @ with [at], . with [dot] and - with [dash]
                                          //  'hex'     - use hex entities to encode the mail address
                                          //  'none'    - do not obfuscate addresses

/* Authentication Options */
$conf['useacl']      = 1;                //Use Access Control Lists to restrict access?
$conf['openregister']= 0;                //Should users to be allowed to register?
$conf['authtype']    = 'pgsql';          //which authentication DB should be used (currently plain only)
$conf['defaultgroup']= 'user';           //Default groups new Users are added to
$conf['superuser']   = 'root';       //The admin can be user or @group

/* Advanced Options */
$conf['userewrite']  = 0;                //this makes nice URLs: 0: off 1: .htaccess 2: internal
$conf['useslash']    = 0;                //use slash instead of colon? only when rewrite is on
$conf['canonical']   = 0;                //Should all URLs use full canonical http://... style?
$conf['autoplural']  = 0;                //try (non)plural form of nonexisting files?
$conf['usegzip']     = 1;                //gzip old revisions?
$conf['cachetime']   = 60*60*24;         //maximum age for cachefile in seconds (defaults to a day)
$conf['purgeonadd']  = 1;                //purge cache when a new file is added (needed for up to date links)
$conf['locktime']    = 15*60;            //maximum age for lockfiles (defaults to 15 minutes)
$conf['notify']      = '';               //send change info to this email (leave blank for nobody)
$conf['mailfrom']    = '';               //use this email when sending mails
$conf['gdlib']       = 2;                //the GDlib version (0, 1 or 2) 2 tries to autodetect

//Set target to use when creating links - leave empty for same window
$conf['target']['wiki']      = '';
$conf['target']['interwiki'] = '_blank';
$conf['target']['extern']    = '_blank';
$conf['target']['media']     = '';
$conf['target']['windows']   = '';

/* Safemode Hack */
$conf['safemodehack'] = 0;               //read http://wiki.splitbrain.org/wiki:safemodehack !
$conf['ftp']['host'] = 'localhost';
$conf['ftp']['port'] = '21';
$conf['ftp']['user'] = 'user';
$conf['ftp']['pass'] = 'password';
$conf['ftp']['root'] = '/home/user/htdocs';

$conf['authtype'] = 'pgsql';
 
$conf['auth']['pgsql']['server']   = EGS_DB_HOST;
$conf['auth']['pgsql']['user']     = EGS_DB_USER;
$conf['auth']['pgsql']['password'] = EGS_DB_PASSWORD;
$conf['auth']['pgsql']['database'] = EGS_DB_DATABASE;
 
$conf['auth']['pgsql']['passcheck']= "SELECT u.username AS login
                                        FROM users u, useraccess a
                                       WHERE u.username='%u'
                                         AND a.username=u.username
                                         AND a.access
                                         AND a.companyid=0";
$conf['auth']['pgsql']['userinfo'] = "SELECT firstname || ' ' || surname AS name, email AS mail
                                        FROM personoverview
                                       WHERE owner='%u' AND userdetail";
$conf['auth']['pgsql']['groups']   = "SELECT g.name as group
                                        FROM groups g, users u, groupmembers m
                                       WHERE u.username=m.username
                                         AND g.id=m.groupid
                                         AND u.username='%u'";
                                         
/*Make sure there is nothing - not even spaces after this last ?> */
?>
