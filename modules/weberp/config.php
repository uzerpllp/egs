<?php
/* Use a local config file if it exists */
if(file_exists('../../conf/'.$_SERVER['HTTP_HOST'].'.config.php'))
{
  require_once ('../../conf/'.$_SERVER['HTTP_HOST'].'.config.php');
}
/* Use the default config file */
else
{
  require_once ('../../conf/config.php');
}

error_reporting (E_ALL & ~E_NOTICE);
?>
