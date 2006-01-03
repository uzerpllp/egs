<?php

/**
 * log.php
 * 
 * Author: Steve Bourgeois <owl@bozzit.com>
 * Project Founder: Chris Vincent <cvincent@project802.net>
 * 
 * Copyright (c) 1999-2005 The Owl Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 * 
 * $Id: log.php,v 1.6 2005/03/09 15:45:08 b0zz Exp $
 */

global $default, $whereclause;

require_once("../lib/Net_CheckIP/CheckIP.php");
require_once("../config/owl.php");
require_once("../lib/disp.lib.php");
require_once("../lib/owl.lib.php");
include_once("../lib/header.inc");
include_once("../lib/userheader.inc");


if (!isset($nextrecord)) $nextrecord = 0;
if (!isset($next)) $next = 0;
if (!isset($prev)) $prev = 0;
if (!isset($hideagent)) $hideagent = 0;
if (isset($fa)) $filteraction = unserialize(stripslashes($fa));
if (!isset($hidedetail)) $hidedetail = 0;

if ($next == 1) $nextrecord = $nextrecord + $default->log_rec_per_page;
if ($prev == 1)
{
   $nextrecord = $nextrecord - $default->log_rec_per_page;
   if ($nextrecord < 0)
   {
      $nextrecord = 0;
   } 
} 

$whereclause = " where 1=1";

if ($filteraction && $filteraction[0] != "0")
{
   $whereclause .= " and (";
   foreach($filteraction as $fa)
   {
      $whereclause .= " action='$fa' or";
   } 
   $whereclause .= " action='$fa')";
} 

if ($filteruser && $filteruser != "0")
{
   $whereclause .= " and userid='$filteruser'";
} 

print("<center>\n");

if (!fIsAdmin(true)) die("$owl_lang->err_unauthorized");

if ($action == "clear_log")
{
   $sql = new Owl_DB;
   $sql->query("DELETE from $default->owl_log_table");
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

fPrintAdminPanel("viewlog");

print("<table class='margin2' cellspacing='0' cellpadding='0' border='0' width='100%'><tr><td align='left' valign='top'>\n");
print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>");
print("<tr><td class='admin0' width='100%' colspan='8'>$owl_lang->owl_log_viewer</td></tr>\n");
print("<tr>\n");
print("<td class='title1'>$owl_lang->owl_log_hd_action</td>\n");
print("<td class='title1'>$owl_lang->owl_log_hd_file</td>\n");
print("<td class='title1'>$owl_lang->owl_log_hd_fld_path</td>\n");
print("<td class='title1'>$owl_lang->owl_log_hd_user</td>\n");
print("<td class='title1'>$owl_lang->owl_log_hd_dt_tm</td>\n");
print("<td class='title1'>$owl_lang->owl_log_hd_ip</td>\n");
if ($hideagent == 1)
{
   print("<td class='title1'>&nbsp;</td>\n");
}
else
{
   print("<td class='title1'>$owl_lang->owl_log_hd_agent</td>\n");
}
if ($hidedetail == 1)
{
   print("<td class='title1'>&nbsp;</td>\n");
}
else
{
   print("<td class='title1'>$owl_lang->owl_log_hd_dtls</td>\n");
}

print("</tr>\n");
// print the LOG Details
$CountLines = 0;
$sql = new Owl_DB;
$getusers = new Owl_DB; 
// Found out how many records we are going to retreive
$sql->query("select * from $default->owl_log_table $whereclause");
$recordcount = $sql->num_rows($sql); 

// Retreive the log records for display
if ($recordcount == 0)
{
   print("<tr>\n<td colspan='8' align='center'><h2>$owl_lang->owl_log_no_rec</h2></td>\n</tr>\n");
   print("<tr>\n<td colspan='8' align='center'><h2>&nbsp;</h2></td>\n</tr>\n");
} 
else
{
   $sql->query("select * from $default->owl_log_table $whereclause order by logdate DESC LIMIT $nextrecord,$default->log_rec_per_page");
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
      print("<td class='$sTrClass'><font color='green'><b>&lsaquo;" . $log_file_actions[$sql->f("action")] . "></b></font></td>\n");
      if ($sql->f("type") != "LOGIN")
      {
         print("<td class='$sTrClass'>" . $sql->f("filename") . "</td>\n");
         print("<td class='$sTrClass'>" . get_dirpath($sql->f("parent")) . "</td>\n");
      } 
      else
      {
         print("<td class='$sTrClass'>&nbsp;</td>\n");
         print("<td class='$sTrClass'>&nbsp;</td>\n");
      } 
      print("<td class='$sTrClass'>" . uid_to_name($sql->f("userid")) . "</td>\n");
      print("<td class='$sTrClass'>" . date($owl_lang->localized_date_format, strtotime($sql->f("logdate"))) . "</td>\n");
      if (Net_CheckIP::check_ip($sql->f('ip')))
      {
         print("<td class='$sTrClass'>" . gethostbyaddr($sql->f('ip')) . "</td>\n");
      }
      else
      {
         print("<td class='$sTrClass'>" . $sql->f('ip') . "</td>\n");
      }
      //print("<td class='$sTrClass'>" . gethostbyaddr($sql->f('ip')) . "</td>\n");
      if ($hideagent == 1)
      {
         print("<td class='$sTrClass'>&nbsp;</td>\n");
      }
      else
      {
         print("<td class='$sTrClass'>" . $sql->f("agent") . "</td>\n");
      }
      if ($hidedetail == 1)
      {
         print("<td class='$sTrClass'>&nbsp;</td>\n");
      }
      else
      {
         print("<td class='$sTrClass'>" . $sql->f("details") . "</td>\n");
      }
      print ("</tr>\n");
   } 
} 
print("</table>"); 
// print out the filters
$logactions[0][1] = "$owl_lang->log_filter_all";
$logactions[1][1] = $log_file_actions[LOGIN];
$logactions[2][1] = $log_file_actions[LOGIN_FAILED];
$logactions[3][1] = $log_file_actions[LOGOUT];
$logactions[4][1] = $log_file_actions[FILE_DELETED];
$logactions[5][1] = $log_file_actions[FILE_UPLOAD];
$logactions[6][1] = $log_file_actions[FILE_UPDATED];
$logactions[7][1] = $log_file_actions[FILE_DOWNLOADED];
$logactions[8][1] = $log_file_actions[FILE_CHANGED];
$logactions[9][1] = $log_file_actions[FILE_LOCKED];
$logactions[10][1] = $log_file_actions[FILE_UNLOCKED];
$logactions[11][1] = $log_file_actions[FILE_EMAILED];
$logactions[12][1] = $log_file_actions[FILE_MOVED];
$logactions[13][1] = $log_file_actions[FOLDER_CREATED];
$logactions[14][1] = $log_file_actions[FOLDER_DELETED];
$logactions[15][1] = $log_file_actions[FOLDER_MODIFIED];
$logactions[16][1] = $log_file_actions[FOLDER_MOVED];
$logactions[17][1] = $log_file_actions[FORGOT_PASS];
$logactions[18][1] = $log_file_actions[USER_REG];
$logactions[19][1] = $log_file_actions[FILE_VIEWED];
$logactions[20][1] = $log_file_actions[FILE_VIRUS];
$logactions[21][1] = $log_file_actions[FILE_COPIED];
$logactions[22][1] = $log_file_actions[FOLDER_COPIED];
$logactions[23][1] = $log_file_actions[FILE_LINKED];

print("<form enctype='multipart/form-data' action='log.php' method='post'>
                        <input type='hidden' name='sess' value='$sess'></input>
                        <input type='hidden' name='action' value='refresh'></input>
                        <input type='hidden' name='id' value='$id'></input>
                        <input type='hidden' name='whereclause' value='$whereclause'></input>");
print("<input type='hidden' name='expand' value='$expand'></input>\n");
print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
fPrintSectionHeader($owl_lang->owl_log_filter .":");
print("<tr>\n<td class='form1'>$owl_lang->owl_log_hd_action:</td>\n<td class='form1' width='100%'>");
print("<select size='8' name='filteraction[]' multiple='multiple'>");
$i = 0;
foreach($logactions as $fp)
{
   $isSelected = false;
   if ($filteraction[0] != "")
   {
      foreach($filteraction as $fa)
      {
         if ($fa == $i)
         {
            $isSelected = true;
         }
      } 
   } 
   print("<option value='$i' ");
   if ($isSelected)
   {
      print("selected='selected'");
   }
   print(">$fp[1]</option>");
   $i++;
} 
print("</select>\n</td>\n</tr>\n"); 
// Print Users
$getusers->query("select name,username,id from $default->owl_users_table order by name");

print("<tr>");
print("<td class='form1'>$owl_lang->owl_log_hd_user:</td><td class='form1' width='100%'><select name='filteruser'>");

print("<option value='0'>$owl_lang->log_filter_all</option>");
while ($getusers->next_record())
{
   $uid = $getusers->f("id");
   $name = $getusers->f("name");
   $username = $getusers->f("username");

   if ($name == "")
   {
      print("<option value='" . $uid . "'>" . $username . "</option>");
   }
   else
   {
      if ($uid == $filteruser)
      {
         print("<option value='" . $uid . "' selected='selected'> " . $name . "</option>");
      }
      else
      {
         print("<option value='" . $uid . "' >" . $name . "</option>");
      }
   }
} 
print("</select></td>\n</tr>\n"); 

// print Hide columns
print("<tr>\n<td class='form1'>$owl_lang->owl_log_hide $owl_lang->owl_log_hd_agent:</td>\n");
if ($hideagent == 1)
{
   print("<td class='form1' width='100%'><input type='checkbox' name='hideagent' value='1' checked='checked'></input></td>\n");
}
else
{
   print("<td class='form1' width='100%'><input type='checkbox' name='hideagent' value='1' ></input></td>\n");
}

print("</tr>\n");
print("<tr>\n<td class='form1'>$owl_lang->owl_log_hide $owl_lang->owl_log_hd_dtls::</td>\n");
if ($hidedetail == 1)
{
   print("<td class='form1' width='100%'><input type='checkbox' name='hidedetail' value='1' checked='checked'></input></td>\n");
}
else
{
   print("<td class='form1' width='100%'><input type='checkbox' name='hidedetail' value='1' ></input></td>\n");
}
print("</tr>\n");

//print("<tr>\n<td>\n");
print("<tr>\n");
print("<td class='form2' width='100%' colspan='3'>\n");
fPrintSubmitButton($owl_lang->owl_log_filter, $owl_lang->alt_refresh_filter, "submit", "myaction");
print("</td>\n</tr>\n");
print("</table></form>");
//</td>\n</tr>\n</table>\n</form>\n"); 

// print Footer with Record Count and PREV TOP NEXT

print("<table width='100%' cellspacing='0' cellpadding='0'>\n");
print("<tr>\n");
print("<td class='form2' width='100%'>&nbsp;</td>\n");
$fa = serialize($filteraction);
print("<td class='form2'><a href='log.php?sess=$sess&amp;prev=1&amp;nextrecord=$nextrecord&amp;fa=$fa&amp;filteruser=$filteruser&amp;hideagent=$hideagent&amp;hidedetail=$hidedetail'><img src='$default->owl_graphics_url/$default->sButtonStyle/ui_nav/prev.gif' border='0' alt='$owl_lang->alt_log_prev' title='$owl_lang->alt_log_prev'></img></a></td>\n");
print("<td class='form2'><a href='log.php?sess=$sess&amp;next=0&amp;nextrecord=0&amp;fa=$fa&amp;filteruser=$filteruser&amp;hideagent=$hideagent&amp;hidedetail=$hidedetail'><img src='$default->owl_graphics_url/$default->sButtonStyle/ui_nav/top.gif' border='0' alt='$owl_lang->alt_log_top' title='$owl_lang->alt_log_top'></img></a></td>\n");
$from = $nextrecord + 1;
if ($recordcount == 0)
   $from = $recordcount;
$to = $nextrecord + $default->log_rec_per_page;
if ($to > $recordcount)
   $to = $recordcount;
if ($to < $recordcount)
{
   print("<td class='form2'><a href='log.php?sess=$sess&amp;next=1&amp;nextrecord=$nextrecord&amp;fa=$fa&amp;filteruser=$filteruser&amp;hideagent=$hideagent&amp;hidedetail=$hidedetail'><img src='$default->owl_graphics_url/$default->sButtonStyle/ui_nav/next.gif' border='0' alt='$owl_lang->alt_log_next' title='$owl_lang->alt_log_next'></img></a></td>\n");
} 
else
{
   print("<td class='form2' align='left' ><img src='$default->owl_graphics_url/$default->sButtonStyle/ui_misc/transparent.gif' border='0' alt=''></img></td>\n");
} 
print("<td class='form2' align='left' ><a href='log.php?sess=$sess&amp;action=clear_log' onclick='return confirm(\"$owl_lang->reallydelete_logs ?\");'><img src='$default->owl_graphics_url/$default->sButtonStyle/ui_misc/log_delete.gif' border='0' alt='$owl_lang->alt_log_clear' title='$owl_lang->alt_log_clear'></img></a></td>\n");

print("<td class='form2' nowrap='nowrap'>&nbsp;($from to $to) of $recordcount &nbsp;</td>\n");
print ("</tr>");
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
