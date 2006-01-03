<?php

/**
 * sitemap.php
 * 
 * Author: B0zz
 *
 * Copyright (c) 1999-2004 The Owl Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 * 
 */

require_once("./config/owl.php");
require_once("./lib/disp.lib.php");
require_once("./lib/owl.lib.php");
require_once("./lib/security.lib.php");

if ($sess == "0" && $default->anon_ro > 0)
{
   printError($owl_lang->err_login);
}

include("./lib/header.inc");
include("./lib/userheader.inc");

print("<center>\n");

 if ($expand == 1)
   {
      print("<table class='border1' cellspacing='0' cellpadding='0' border='0' width='$default->table_expand_width'><tr><td align='left' valign='top' width='100%'>\n");
   }
   else
   {
      print("<table class='border1' cellspacing='0' cellpadding='0' border='0' width='$default->table_collapse_width'><tr><td align='left' valign='top' width='100%'>\n");
   }
   fPrintButtonSpace(12, 1);
   print("<br />\n");

   print("<table class='border2' cellspacing='0' cellpadding='0' border='0' width='100%'><tr><td align='left' valign='top' width='100%'>\n");                                                                                                                                             
   if ($default->show_prefs == 1 or $default->show_prefs == 3)
   {
      fPrintPrefs("infobar1", "top");
   }
   fPrintButtonSpace(12, 1);
   print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
   fPrintSectionHeader("$owl_lang->alt_site_map");
   print("</table>\n");
   print("<br />\n");


?>
<div align="center">
<table cellspacing='0' border='1' cellpadding='4' bgcolor='white'><tr><td align='left'>
<?php 
// Get list of folders sorted by name
$whereclause = "";

if ($default->hide_backup == 1 and !fIsAdmin())
{
   $whereclause = " WHERE name <> 'backup'";
} 

$sql->query("select id,name,parent from $default->owl_folders_table $whereclause order by name");

$i = 0;
while ($sql->next_record())
{
   $folderList[$i][0] = $sql->f("id");
   $folderList[$i][1] = $sql->f("name");
   $folderList[$i][2] = $sql->f("parent");
   $i++;
} 

$fCount = count($folderList);

$fDepth = 0;


fshowsitemap($default->HomeDir, fid_to_name($default->HomeDir));

print("</td></tr></table>\n");
fPrintButtonSpace(12, 1);
                                                                                                                                             
print("</div>");
                                                                                                                                             
if ($default->show_prefs == 2 or $default->show_prefs == 3)
{
   fPrintPrefs("infobar2");
}
print("</td></tr></table>\n");
include("./lib/footer.inc");
?>
