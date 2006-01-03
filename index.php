<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - System Page 1.0                  |
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
// | 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA               |
// +----------------------------------------------------------------------+
// | Author: Jake Stride <jake.stride@senokian.com>                       |
// +----------------------------------------------------------------------+
// | 1.0                                                                  |
// | ===                                                                  |
// | First Stable Release                                                 |
// +----------------------------------------------------------------------+

error_reporting(E_ALL);

/* Increase the memory limit - The 'home' module is the only one that
 * really needs this */

/* Get the current time so that we can work out the execution time later */
$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
$starttime = $mtime;

/* Disbale magic quotes if set */
if (get_magic_quotes_gpc()) {
   function stripslashes_deep($value)
   {
       $value = is_array($value) ?
                   array_map('stripslashes_deep', $value) :
                   stripslashes($value);

       return $value;
   }

   $_POST = array_map('stripslashes_deep', $_POST);
   $_GET = array_map('stripslashes_deep', $_GET);
   $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
}

/* Use a local config file if it exists */


if(file_exists('./conf/'.$_SERVER['HTTP_HOST'].'.config.php'))
{
  require_once ('./conf/'.$_SERVER['HTTP_HOST'].'.config.php');
}
/* Use the default config file */
else
{
  require_once ('./conf/config.php');
}

/* Include the db connection */
require_once (EGS_FILE_ROOT.'/src/db.php');

/* Include the header file, this sets up most system variables */
require_once (EGS_FILE_ROOT.'/src/header.php');

/* Include the footer to parse the template/close db connection etc */
require_once (EGS_FILE_ROOT.'/src/footer.php');
?>
