<?php

/**
 * stats.php
 * 
 * Author: Steve Bourgeois <owl@bozzit.com>
 * Project Founder: Chris Vincent <cvincent@project802.net>
 *
 * Copyright (c) 1999-2005 The Owl Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 */

require_once("../lib/Net_CheckIP/CheckIP.php");
require_once("../config/owl.php");
require_once("../lib/disp.lib.php");
require_once("../lib/owl.lib.php");
include_once("../lib/header.inc");
include_once("../lib/userheader.inc");

print("<center>\n");

if (!fIsAdmin(true))
{
   die("$owl_lang->err_unauthorized");
} 

print("<table class='border1' cellspacing='0' cellpadding='0' border='0' width='$default->table_expand_width'><tr><td align='left' valign='top' width='100%'>\n");
fPrintButtonSpace(12, 1);
print("<br />\n");
print("<table class='border2' cellspacing='0' cellpadding='0' border='0' width='100%'><tr><td align='left' valign='top' width='100%'>\n");

if ($default->show_prefs == 1 or $default->show_prefs == 3)
{
   fPrintPrefs("infobar1", "top");
}

fPrintButtonSpace(12, 1);
print("<br />\n");

fPrintAdminPanel("viewstats");

print("<table class='margin2' cellspacing='0' cellpadding='0' border='0' width='100%'><tr><td align='left' valign='top'>\n");
print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>");
print("<tr><td class='admin0' width='100%' colspan='4'>$owl_lang->owl_stats_viewer</td></tr>\n");

$CountLines = 0;
$sql = new Owl_DB;
$sql->query("SELECT creatorid, sum(f_size) as total_size , count(*) as num_files from $default->owl_files_table group by creatorid order by num_files desc");
print("<tr>\n");
print("<td class='title1' colspan='3'>$owl_lang->username</td>\n");
print("<td class='title1'>$owl_lang->tot_files</td>");
print("</tr>\n");

print("<tr>\n");
print("<td align='left' colspan='3'>&nbsp;</td>\n");
print("<td align='left'>&nbsp;</td>\n");
print("</tr>\n");
print("<tr>\n");

// 
// User File Stats BEGIN
// 
print("<td class='admin2' align='left' colspan='4'>$owl_lang->stats_files</td>\n");
print("<td align='left'>&nbsp;</td>\n");
print("</tr>\n");
print("<tr>\n");
print("<td align='left' colspan='3'>&nbsp;</td>\n");
print("<td align='left'>&nbsp;</td>\n");
print("</tr>\n");

$iGrandFileTotal = 0;
$iGrandSizeTotal = 0;
while ($sql->next_record())
{
   $CountLines++;
   $PrintLines = $CountLines % 2;
   if ($PrintLines == 0)
   {
      $sTrClass = "file1";
      $sLfList = "lfile1";
   }
   else
   {  
      $sTrClass = "file2";
      $sLfList = "lfile1";
   }
      
   print("\t\t\t\t<tr>\n");

   print("<td class='$sTrClass' colspan='2'>" . uid_to_name($sql->f("creatorid")) . "</td>\n");
   print("<td class='$sTrClass'>" . $sql->f("num_files") . "</td>\n");
   $iGrandFileTotal = $iGrandFileTotal + $sql->f("num_files");
   print("<td class='$sTrClass'>" . gen_filesize($sql->f("total_size")) . "</td>\n");
   $iGrandSizeTotal = $iGrandSizeTotal + $sql->f("total_size");
   print("</tr>\n");
} 
print("<tr>\n");
print("<td class='title1' colspan='2'>$owl_lang->tot_files</td>\n");
print("<td class='title1'>$iGrandFileTotal</td>\n");
print("<td class='title1'>" . gen_filesize($iGrandSizeTotal) . "</td>\n");
print("</tr>\n");
// 
// User File Stats END
// 
// 
// User Folder Stats BEGIN
// 
print("<tr>\n");
print("<td align='left' colspan='3'>&nbsp;</td>\n");
print("<td align='left'>&nbsp;</td>\n");
print("</tr>\n");
print("<tr>\n");
print("<td class='admin2' align='left' colspan='4'>$owl_lang->stats_folders</td>\n");
print("<td align='left'>&nbsp;</td>\n");
print("</tr>\n");
print("<tr>\n");
print("<td align='left' colspan='3'>&nbsp;</td>\n");
print("<td align='left'>&nbsp;</td>\n");
print("</tr>\n");

$sql->query("SELECT creatorid , count(*) as num_folders from $default->owl_folders_table group by creatorid order by num_folders desc");

$iGrandFolderTotal = 0;
while ($sql->next_record())
{
   $CountLines++;
   $PrintLines = $CountLines % 2;
   if ($PrintLines == 0)
   {
      $sTrClass = "file1";
      $sLfList = "lfile1";
   }
   else
   {  
      $sTrClass = "file2";
      $sLfList = "lfile1";
   }
      
   print("\t\t\t\t<tr>\n");
   print("<td class='$sTrClass' colspan='3'>" . uid_to_name($sql->f("creatorid")) . "</td>\n");
   print("<td class='$sTrClass'>" . $sql->f("num_folders") . "</td>\n");
   $iGrandFolderTotal = $iGrandFolderTotal + $sql->f("num_folders");
   print("</tr>\n");
} 
print("<tr>\n");
print("<td class='title1' colspan='3'>$owl_lang->tot_files</td>\n");
print("<td class='title1'>$iGrandFolderTotal</td>\n");
print("</tr>\n");
// 
// User Folder Stats END
// 
if ($default->logging && $default->log_file)
{ 
   // 
   // User Logon Stats BEGIN
   // 
   print("<tr>\n");
   print("<td align='left' colspan='3'>&nbsp;</td>\n");
   print("<td align='left'>&nbsp;</td>\n");
   print("</tr>\n");
   print("<tr>\n");
   print("<td  class='admin2' colspan='4'>$owl_lang->stats_users</td>\n");
   print("<td align='left'>&nbsp;</td>\n");
   print("</tr>\n");
   print("<tr>\n");
   print("<td align='left' colspan='3'>&nbsp;</td>\n");
   print("<td align='left'>&nbsp;</td>\n");
   print("</tr>\n");

   $sql->query("select count(*) as num_action, userid, action  from $default->owl_log_table where type='LOGIN' group by userid, action");

   $iGrandLoginTotal = 0;
   $iGrandLogoutTotal = 0;
   $iGrandFailedTotal = 0;
   $SaveUser = -1;
   $iLoginTotal = 0;
   $iLogoutTotal = 0;
   $iFailedTotal = 0;

   while ($sql->next_record())
   {
      if ($SaveUser <> $sql->f("userid"))
      {
         if ($SaveUser <> -1)
         {
            print("($iLoginTotal / $iFailedTotal / $iLogoutTotal )");
            print("</td>\n");
            print("</tr>\n");
            $iGrandLoginTotal = $iGrandLoginTotal + $iLoginTotal;
            $iGrandLogoutTotal = $iGrandLogoutTotal + $iLogoutTotal;
            $iGrandFailedTotal = $iGrandFailedTotal + $iFailedTotal;
            $iLoginTotal = 0;
            $iLogoutTotal = 0;
            $iFailedTotal = 0;
         } 
         $CountLines++;
         $PrintLines = $CountLines % 2;
         if ($PrintLines == 0)
         {
            $sTrClass = "file1";
            $sLfList = "lfile1";
         }
         else
         {  
            $sTrClass = "file2";
            $sLfList = "lfile1";
         }
            
         print("\t\t\t\t<tr>\n");
         print("<td class='$sTrClass' colspan='3'>" . uid_to_name($sql->f("userid")) . "</td>\n");
         print("<td class='$sTrClass'>");
      } 

      switch ($sql->f("action"))
      {
         case LOGIN:
            $iLoginTotal = $sql->f("num_action");
            break;
         case LOGIN_FAILED:
            $iFailedTotal = $sql->f("num_action");
            break;
         case LOGOUT:
            $iLogoutTotal = $sql->f("num_action");
            break;
      } 
      $SaveUser = $sql->f("userid");
   } 

   $iGrandLoginTotal = $iGrandLoginTotal + $iLoginTotal;
   $iGrandLogoutTotal = $iGrandLogoutTotal + $iLogoutTotal;
   $iGrandFailedTotal = $iGrandFailedTotal + $iFailedTotal;

   print("($iLoginTotal / $iFailedTotal / $iLogoutTotal )");
   print("</td>\n");
   print("</tr>\n");
   print("<tr>\n");
   print("<td class='title1' colspan='3'>$owl_lang->tot_files</td>\n");
   print("<td class='title1'>($iGrandLoginTotal / $iGrandFailedTotal / $iGrandLogoutTotal)</td>\n");
   print("</tr>\n"); 
   // 
   // User Logon Stats END
   // 
} 
// 
// Currently Logged In BEGIN
// 
print("<tr>\n");
print("<td align='left' colspan='3'>&nbsp;</td>\n");
print("<td align='left'>&nbsp;</td>\n");
print("</tr>\n");
print("<tr>\n");
print("<td  class='admin2' align='left' colspan='4'>$owl_lang->stats_users_loggedin</td>\n");
print("<td align='left'>&nbsp;</td>\n");
print("</tr>\n");
print("<tr>\n");
print("<td align='left' colspan='3'>&nbsp;</td>\n");
print("<td align='left'>&nbsp;</td>\n");
print("</tr>\n");

$sql->query("select usid, lastused, ip  from $default->owl_sessions_table order by usid");

$iGrandUserTotal = 0;
while ($sql->next_record())
{
   $CountLines++;
   $PrintLines = $CountLines % 2;
   if ($PrintLines == 0)
   {
      $sTrClass = "file1";
      $sLfList = "lfile1";
   }
   else
   {  
      $sTrClass = "file2";
      $sLfList = "lfile1";
   }
            
   print("\t\t\t\t<tr>\n");

   print("<td class='$sTrClass'>" . uid_to_name($sql->f("usid")) . "</td>\n");

   $time = time();
   if (($time - $sql->f("lastused")) <= $default->owl_timeout)
   {
      print("<td class='$sTrClass'>SESSION ACTIVE</td>\n");
   } 
   else
   {
      print("<td class='$sTrClass'>SESSION EXPIRED</td>\n");
   } 
   print("<td class='$sTrClass'>" . $sql->f("ip") . "</td>\n");
   if (Net_CheckIP::check_ip($sql->f('ip')))
   {
      print("<td class='$sTrClass'>" . gethostbyaddr($sql->f('ip')) . "</td>\n");
   }
   else
   {
      print("<td class='$sTrClass'>" . $sql->f('ip') . "</td>\n");
   }

   $iGrandUserTotal = $iGrandUserTotal + 1;
   print("</tr>\n");
} 
print("<tr>\n");
print("<td class='title1' colspan='3'>$owl_lang->tot_files</td>\n");
print("<td class='title1'>$iGrandUserTotal</td>\n");
print("</tr>\n");
// 
// User Folder Stats END
// 
print("<tr>\n");
print("<td align='left' colspan='3'>&nbsp;</td>\n");
print("<td align='left'>&nbsp;</td>\n");
print("</tr>\n");
print("<tr>");
print("<td class='title1' colspan='3'>$owl_lang->file</td>");
print("<td class='title1'>$owl_lang->tot_files</td>");
print("</tr>");
print("<tr>\n");
print("<td align='left' colspan='3'>&nbsp;</td>\n");
print("<td align='left'>&nbsp;</td>\n");
print("</tr>\n");
print("<tr>\n");
print("<td class='title1' colspan='3'>$owl_lang->stats_top</td>\n");
print("<td class='title1'>&nbsp;</td>\n");
print("</tr>\n");
print("<tr>\n");
print("<td align='left' colspan='3'>&nbsp;</td>\n");
print("<td align='left'>&nbsp;</td>\n");
print("</tr>\n");

if ($default->logging && $default->log_file)
{
   $sGetAction = FILE_DOWNLOADED;
   $sql->query("select action, parent, filename, count(filename) as download_count from $default->owl_log_table where action = '$sGetAction' group by filename, action, parent order by download_count desc");

   $iTopCount = 0;
   while ($sql->next_record())
   {
      $CountLines++;
      $PrintLines = $CountLines % 2;
      if ($PrintLines == 0)
      {
         $sTrClass = "file1";
         $sLfList = "lfile1";
      }
      else
      {  
         $sTrClass = "file2";
         $sLfList = "lfile1";
      }
      
      print("\t\t\t\t<tr>\n");
      print("<td class='$sTrClass' colspan='3'>" . $sql->f("filename") . "</td>\n");
      print("<td class='$sTrClass'>" . $sql->f("download_count") . "</td>\n");
      print("</tr>\n");
      $iTopCount++;

      if ($iTopCount > 20)
         break;
   } 
} 
else
{
   print("<tr>\n");
   print("<td class='$sTrClass' colspan='3'>$owl_lang->stats_information</td>\n");
   print("<td class='$sTrClass'>&nbsp;</td>\n");
   print("</tr>\n");
} 

print("</table>\n");
print("</td></tr></table>\n");
      fPrintButtonSpace(12, 1);


if ($default->show_prefs == 2 or $default->show_prefs == 3)
{
   fPrintPrefs("infobar2");
}
print("</td></tr></table>\n");
                                                                                                                                                                                                    
if (file_exists("./lib/footer.inc"))
{
   include("./lib/footer.inc");
}
else
{
   include("../lib/footer.inc");
}
?>
