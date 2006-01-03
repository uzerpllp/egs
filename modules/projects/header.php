<?php
// As of 24 July 2004, all editable config is stored in flyspray.conf.php
// There should be no reason to edit this file anymore, except if you
// move flyspray.conf.php to a directory where a browser can't access it.
// (RECOMMENDED).

// You might like to uncomment the next line if you are receiving lots of
// PHP NOTICE errors.  We are in the process of making Flyspray stop making
// these errors, but this will help hide them until we are finished.

//error_reporting(E_ALL & -E_NOTICE);

// Check PHP Version (Must Be at least 4.3)
if (PHP_VERSION  < '4.3.0')
   die('Your version of PHP is not compatible with Flyspray, please upgrade to the latest version of PHP.  Flyspray requires at least PHP version 4.3.0');

// This line gets the operating system so that we know which way to put slashes in the path
strstr( PHP_OS, "WIN") ? $slash = "\\" : $slash = "/";

// Check if we're upgrading, modify the path to the config file accordingly
if (ereg("sql|scripts", $_SERVER['PHP_SELF']))
{
   $path_append = '..';
} else
{
   $path_append = '';
}

// Get the path to the Flyspray directory
$path = realpath('./' . $path_append);

// Modify PHP's include path to add the Flyspray directory
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

// This line was used in testing
//echo get_include_path();

// Define the path to the config file.  Change this line if you move flyspray.conf.php elsewhere
$conf_file = $path . $slash . "flyspray.conf.php";

// Check if config file exists and its not empty.
// If it doesn't exist or is empty, take the user to the setup page
if (!file_exists($conf_file) || (count($config = parse_ini_file($conf_file, true)) == 0) )
{
  header("Location: setup/index.php");
  exit;
}

// Load the config file
$conf = @parse_ini_file($conf_file, true);

// Detect for lack of variables that would be in a 0.9.8 installation,
// and redirect to the setup script
if (!isset($conf['general']['baseurl']))
{
  header("Location: setup/index.php");
  exit;
}

// Set values from the config file. Once these settings are loaded a connection
// is made to the database to retrieve all the other preferences.
$basedir     = $conf['general']['basedir'];
$baseurl     = $conf['general']['baseurl'];
$adodbpath   = $conf['general']['adodbpath'];
$cookiesalt  = $conf['general']['cookiesalt'];
$dbtype      = $conf['database']['dbtype'];
$dbhost      = $conf['database']['dbhost'];
$dbname      = $conf['database']['dbname'];
$dbprefix    = $conf['database']['dbprefix'];
$dbuser      = $conf['database']['dbuser'];
$dbpass      = $conf['database']['dbpass'];

/* Use a local config file if it exists */
if(file_exists(str_replace('modules/projects', '', $path).'./conf/'.$_SERVER['HTTP_HOST'].'.config.php'))
{
require_once (str_replace('modules/projects', '', $path).'./conf/'.$_SERVER['HTTP_HOST'].'.config.php');
}
/* Use the default config file */
else
{
require_once (str_replace('modules/projects', '', $path).'./conf/config.php');
}

error_reporting (E_ALL & ~E_NOTICE);

   /* 
   Not required since you are already adding a slash in the include statements below.
   I have updated other locations for the same scenario. ~ Jeffery
   if (substr($basedir,-1,1) != '/')
   {
      $basedir .= '/';
   }*/

   if (substr($baseurl,-1,1) != '/')
   {
      $baseurl .= '/';
   }

include_once ( $adodbpath );
include_once ( "$basedir/includes/functions.inc.php" );
include_once ( "$basedir/includes/db.inc.php" );
include_once ( "$basedir/includes/backend.inc.php" );

// Define our functions classes
$fs = new Flyspray;
$db = new Database;
$be = new Backend;

include_once ( "$basedir/includes/markdown.php" );
include_once ( "$basedir/includes/regexp.php" );

session_start();


// Open a connection to the database
$res = $db->dbOpen($dbhost, $dbuser, $dbpass, $dbname, $dbtype);
if (!$res)
   die("Flyspray was unable to connect to the database.  Check your settings in flyspray.conf.php");


// Retrieve the global application preferences
$flyspray_prefs = $fs->getGlobalPrefs();

// Stop php NOTICE messages by defining a whole bunch of stuff
$fs->fixMissingIndices();

// If we've gone directly to a task, we want to override the project_id set in the function below
// Any "do" mode that accepts a task_id or id field should be added here.
if ( (isset($_REQUEST['do'])  && $_REQUEST['do']  == 'details') ||
     (isset($_REQUEST['do'])  && $_REQUEST['do']  == 'depends') ||
     (isset($_REQUEST['do']) && $_REQUEST['do'] == 'modify') )
{
   unset($id);
   if ( isset($_REQUEST['task_id']) ) { $id = $_REQUEST['task_id']; }
   elseif ( isset($_REQUEST['id']) && !is_array($_REQUEST['id']) ) { $id = $_REQUEST['id']; }
   if ( isset($id) )
   {
     $project_id = $db->FetchOne($db->Query("SELECT attached_to_project FROM {$dbprefix}tasks WHERE task_id = ?", array($id)));
     setcookie('flyspray_project', $project_id, time()+60*60*24*30, "/");
   }
}

// Determine which project we want to see
if ( !isset($project_id) )
{
   if ( isset($_REQUEST['project']) && $_REQUEST['project'] != '0' && !empty($_REQUEST['project']))
   {
      $project_id = $_REQUEST['project'];
      setcookie('flyspray_project', $_REQUEST['project'], time()+60*60*24*30, "/");

   } elseif ( isset($_REQUEST['project_id']) )
   {
      $project_id = $_REQUEST['project_id'];
      setcookie('flyspray_project', $_REQUEST['project_id'], time()+60*60*24*30, "/");

   } elseif ( isset($_COOKIE['flyspray_project']) )
   {
      $project_id = $_COOKIE['flyspray_project'];

   } else
   {
      $project_id = $flyspray_prefs['default_project'];
      setcookie('flyspray_project', $flyspray_prefs['default_project'], time()+60*60*24*30, "/");
   }
}

// Get the preferences for the currently selected project
$project_prefs = $fs->getProjectPrefs($project_id);

// This to stop PHP being retarded and using the '&' char for session id delimiters
ini_set("arg_separator.output","&amp;");

// This is for retarded Windows servers not having REQUEST_URI
if(!isset($_SERVER['REQUEST_URI']))
{
   if(isset($_SERVER['SCRIPT_NAME']))
      $_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'];
   else
      $_SERVER['REQUEST_URI'] = $_SERVER['PHP_SELF'];

   if($_SERVER['QUERY_STRING'])
   {
      $_SERVER['REQUEST_URI'] .=  '?'.$_SERVER['QUERY_STRING'];
   }
}

?>
