<?php

/**
 * news.php
 * 
 * Author: Steve Bourgeois <owl@bozzit.com>
 * Project Founder: Chris Vincent <cvincent@project802.net>
 * 
 * Copyright (c) 1999-2005 The Owl Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 */

global $default;

require_once("../config/owl.php");
require_once("../lib/disp.lib.php");
require_once("../lib/owl.lib.php");
include_once("../lib/header.inc");
include_once("../lib/userheader.inc");

print("<center>\n");

if (!fIsAdmin(true) && !fIsNewsAdmin($userid)) die("$owl_lang->err_unauthorized");

$sql = new Owl_DB;
if (!isset($nid))
{
   $nid = 0;
}
if (fIsNewsAdmin($userid))
{
   $sql->query("SELECT g.id, g.name from $default->owl_users_table u, $default->owl_groups_table g where u.groupid = g.id and u.id = '$userid';");
   $sql->next_record();
   $iPrimaryGroup = $sql->f("id");
   $groups[0][0] = $sql->f("id");
   $groups[0][1] = $sql->f("name");

   $sql->query("SELECT m.groupid, g.name from $default->owl_users_grpmem_table m, $default->owl_groups_table g where m.userid = '$userid' and m.groupid = g.id");
   $i = 1;
   while ($sql->next_record())
   {
      if (!($sql->f("groupid") == $iPrimaryGroup))
      {
         $groups[$i][0] = $sql->f("groupid");
         $groups[$i][1] = $sql->f("name");
         $i++;
      } 
   } 
} 
else
{
   $sql->query("SELECT id,name from $default->owl_groups_table order by name");
   $i = 0;
   while ($sql->next_record())
   {
      $groups[$i][0] = $sql->f("id");
      $groups[$i][1] = $sql->f("name");
      $i++;
   } 
} 

if ($action == "del_news")
{
   $del = new Owl_DB;
   $del->query("delete from $default->owl_news_table where id = '$nid'");
   $nid = 0;
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
 
fPrintAdminPanel("newsadmin");
 



if ($action == "edit_news")
{
   $edit = new Owl_DB;
   $edit->query("SELECT * from $default->owl_news_table where id = '$nid'");
   $edit->next_record();

   print("<form enctype='multipart/form-data' action='admin_dbmodify.php' method='post'>\n");
   print("<input type='hidden' name='nid' value='" . $edit->f("id") . "'></input>\n");
   print("<input type='hidden' name='action' value='edit_news'></input>\n");
   print("<input type='hidden' name='sess' value='$sess'></input>\n");
   print("<table class='margin2' cellspacing='0' cellpadding='0' border='0' width='100%'><tr><td align='left' valign='top'>\n");
   print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>");
   print("<tr><td class='admin0' width='100%' colspan='2'>$owl_lang->news_title</td></tr>\n");
   if ($change == 1)
   {
      print("<tr><td class='admin0' width='100%' colspan='2'>");
      print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>");
      print("<br></br>");
      fPrintSectionHeader($owl_lang->saved, "admin3");
      print("</table>");
      print("</td></tr>\n");
   }
   fPrintFormTextLine($owl_lang->news_heading . ":" , "news_title", 60, $edit->f("news_title"));
   fPrintFormTextArea($owl_lang->news_content . ":" , "newsdesc", $edit->f("news"));
   print("<tr>\n");
   print("<td class='form1'>$owl_lang->news_hd_expires:</td>\n");
   print("<td class='form1' width='100%'>");
   fPrintDatePicker($edit->f("news_end_date"));
   print("</td>");
   print("</tr>\n");

   print("<tr>\n");
   print("<td class='form1'>$owl_lang->news_hd_audience:</td>\n");
   print("<td class='form1' width='100%'>");
   print("<select class='fpull1' name='audience' size='1'>");
   if ($usergroupid == "0")
   {
      print("<option value='-1'>$owl_lang->log_filter_all</option>\n");
   } 
   foreach($groups as $g)
   {
      print("<option value='$g[0]' ");
      if ($g[0] == $edit->f("gid"))
      {
         print("selected='selected'");
      }
      print(">$g[1]</option>\n");
   } 
   print("</select>");
   print("</td></tr>");
   fPrintFormTextLine($owl_lang->news_hd_created . ":", "", "",  date($owl_lang->localized_date_format, strtotime($edit->f("news_date")))  , "", true);
   print("<tr>\n");
   print("<td class='form2' width='100%' colspan='2'>\n");
   fPrintSubmitButton($owl_lang->change, $owl_lang->alt_change, "submit", "btn_ed_news_x");
   fPrintSubmitButton($owl_lang->btn_cancel, $owl_lang->alt_cancel, "submit", "btn_cancel_news_x");
   fPrintSubmitButton($owl_lang->btn_reset, $owl_lang->alt_reset_form, "reset");
   print("</td>\n");
   print("</tr>\n");
   print("</table>\n");
   print("</td></tr></table>\n");
   print("</form>");
} 
else
{
   //if ($change == 1)
   //{
      //print("<table class='border2' cellspacing='0' cellpadding='0' border='0' width='99%'>");
      //fPrintSectionHeader($owl_lang->saved, "admin3");
      //print("</table>");
   //}
   $edit = new Owl_DB;
   $edit->query("SELECT * from $default->owl_news_table where id = '$nid'");
   $edit->next_record();
   print("<form enctype='multipart/form-data' action='admin_dbmodify.php' method='post'>\n");
   print("<input type='hidden' name='nid' value='" . $edit->f("id") . "'></input>\n");
   print("<input type='hidden' name='action' value='add_news'></input>\n");
   print("<input type='hidden' name='sess' value='$sess'></input>\n");
   print("<table class='margin2' cellspacing='0' cellpadding='0' border='0' width='100%'><tr><td align='left' valign='top'>\n");
   print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>");
   if ($change == 1)
   {
      print("<tr><td width='100%' colspan='2'>");
      print("<br></br>");
      print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>");
      fPrintSectionHeader($owl_lang->saved, "admin3");
      print("</table>");
      print("</td></tr>\n");
   }
   print("<tr><td class='admin0' width='100%' colspan='2'>$owl_lang->news_title</td></tr>\n");

   fPrintFormTextLine($owl_lang->news_heading . ":" , "news_title", 50, $edit->f("news_title"));
   fPrintFormTextArea($owl_lang->news_content . ":" , "newsdesc", $edit->f("news"));
   print("<tr>\n");
   print("<td class='form1'>$owl_lang->news_hd_expires:</td>\n");
   print("<td class='form1' width='100%'>");
   fPrintDatePicker();
   print("</td>");
   print("</tr>\n");
   print("<tr>\n");
   print("<td class='form1'>$owl_lang->news_hd_audience:</td>\n");
   print("<td class='form1' width='100%'>");
   print("<select class='fpull1' name='audience' size='1'>");
   if ($usergroupid == "0")
   {
      print("<option value='-1'>$owl_lang->log_filter_all</option>\n");
   } 
   foreach($groups as $g)
   {
      print("<option value='$g[0]' ");
      if ($g[0] == $edit->f("gid"))
      {
         print("selected='selected'");
      }
      print(">$g[1]</option>\n");
   } 
   print("</select>");
   print("</td>");
   print("</tr>\n");

   print("<tr>\n");
   print("<td class='form2' width='100%' colspan='2'>\n");
   fPrintSubmitButton($owl_lang->btn_add_news, $owl_lang->alt_add_news, "submit", "btn_add_news_x");
   fPrintSubmitButton($owl_lang->btn_reset, $owl_lang->alt_reset_form, "reset");
   print("</td>\n");
   print("</tr>\n");
   print("</table>\n");
   print("</td></tr></table>\n");
   print("</form>");
  
} 
      fPrintButtonSpace(20, 1);
      print("<br />\n");

print("<table class='margin2' cellspacing='0' cellpadding='0' border='0' width='100%'><tr><td align='left' valign='top'>\n");
print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>");
print("<tr>");
print("<td class='title1'>&nbsp;</td>");
print("<td class='title1'>$owl_lang->news_hd</td>");
print("<td class='title1'>$owl_lang->news_hd_created</td>");
print("<td class='title1'>$owl_lang->news_hd_expires</td>");
print("<td class='title1'>$owl_lang->news_hd_audience</td>");
print("</tr>");

$dbCountRead = new Owl_DB;
$dbGetUser = new Owl_DB;

$sWhereClause = "";
if (fIsNewsAdmin($userid))
{
   $sWhereClause = "where ";
   foreach($groups as $g)
   {
      $sWhereClause .= " gid = '$g[0]' or";
   } 
   $sWhereClause .= " 0 = 1";
} 

$sql->query("SELECT * from $default->owl_news_table $sWhereClause order by id desc");

while ($sql->next_record())
{
   $iNewsGid = $sql->f("gid");
   $iNewsId = $sql->f("id"); 
   // 
   // Get the number of Users that have Read this
   // 
   $dbCountRead->query("SELECT distinct username,name,id,maxsessions,u.groupid from $default->owl_users_table u left join $default->owl_users_grpmem_table m on u.id=m.userid where u.groupid='$iNewsGid' or m.groupid='$iNewsGid' order by name");
   $iCountRead = 0;
   $iCountTotalUser = 0;
   while ($dbCountRead->next_record())
   {
      $dbGetUser->query("SELECT lastnews from $default->owl_users_table where id ='" . $dbCountRead->f("id") . "' and disabled ='0'");
      $dbGetUser->next_record();
      if ($dbGetUser->f("lastnews") >= $iNewsId)
      {
         $iCountRead++;
      } 
      $iCountTotalUser++;
   } 
   if ($iCountTotalUser == 0)
   {
      $iCountTotalUser = 0;
      $dbCountRead->query("SELECT id,lastnews from $default->owl_users_table where disabled = '0'");
      while ($dbCountRead->next_record())
      {
         if ($dbCountRead->f("lastnews") >= $iNewsId)
         {
            $iCountRead++;
         } 
         $iCountTotalUser++;
      } 
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

   print("<tr>\n");
   print("<td class='$sTrClass'>");
   print("<br></br><a href='news.php?sess=" . $sess . "&amp;action=edit_news&amp;nid=" . $sql->f("id") . "'><img src='$default->owl_graphics_url/$default->sButtonStyle/icon_action/edit.gif' alt='$owl_lang->alt_edit_news' title='$owl_lang->alt_edit_news' border='0'></img></a>");
   print("<br></br><a href='news.php?sess=" . $sess . "&amp;action=del_news&amp;nid=" . $sql->f("id") . "' onclick='return confirm(\"$owl_lang->reallydelete " . $sql->f("news_title") . " ?\");'><img src='$default->owl_graphics_url/$default->sButtonStyle/ui_misc/delete.gif' alt='$owl_lang->alt_del_news' title='$owl_lang->alt_del_news' border='0'></img></a>");
   print("<br></br>$owl_lang->news_read:(" . $iCountRead . " / " . $iCountTotalUser . ")");
   print("</td>");

   print("<td class='$sTrClass' width='%100'><br />");
   print("<h4>" . $sql->f("news_title") . "</h4>\n");
   print(nl2br($sql->f("news")) . "</td>");
   print("<td class='$sTrClass'><br />" . date($owl_lang->localized_date_format, strtotime($sql->f("news_date"))) . "</td>");
   print("<td class='$sTrClass'><br />" . date($owl_lang->localized_date_format, strtotime($sql->f("news_end_date"))) . "</td>");
   print("<td class='$sTrClass' align='center'><br />");
   if ($sql->f("gid") == -1)
   {
      print("$owl_lang->log_filter_all");
   } 
   else
   {
      print group_to_name($sql->f("gid"));
   } 
   print("</td>\n");
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

function fPrintDatePicker ($date = "")
{
   if ($date == "")
   {
      $iCurrentYear = date("Y", mktime(0,0,0,date("m"),date("d")+7,date("y")));
      $iCurrentMonth = date("m", mktime(0,0,0,date("m"),date("d")+7,date("y")));
      $iCurrentDay = date("d", mktime(0,0,0,date("m"),date("d")+7,date("y")));
      $iCurrentHour = date("H");
      $iCurrentMinute = date("i");
   } 
   else
   {
      $iCurrentYear = substr($date, 0, 4);
      $iCurrentMonth = substr($date, 5, 2);
      $iCurrentDay = substr($date, 8, 2);
      $iCurrentHour = substr($date, 11, 2);
      $iCurrentMinute = substr($date, 14, 2);
   } 
   // 
   // Display the Year
   // 
   print("<select class='fpull1'  name='year'>\n");
   print("<option value='$iCurrentYear' selected='selected'>$iCurrentYear</option>\n");
   for ($i = $iCurrentYear;$i <= $iCurrentYear + 5;$i++)
   {
      if ($iCurrentYear != $i)
      {
         print ("<option value='$i'");
      print (">$i</option>\n");
      } 
   } 
   print ("</select>\n");
   print("-"); 
   // 
   // Display the Month
   // 
   print ("<select class='fpull1'  name='month'>\n");
   print ("<option value='$iCurrentMonth' selected='selected'>$iCurrentMonth</option>\n");
   for ($i = 1;$i < 13;$i++)
   {
      if ($i < 10)
      {
         $sString = "0" . $i;
      } 
      else
      {
         $sString = $i;
      } 
      if ($iCurrentMonth != $sString)
      {
         print ("<option value='$sString'");
         print (">$sString</option>\n");
      } 
   } 
   print ("</select>");
   print("-"); 
   // 
   // Display the Day
   // 
   print ("<select class='fpull1' name='day'>\n");
   print ("<option value='$iCurrentDay' selected='selected'>$iCurrentDay</option>\n");
   for ($i = 1;$i < 32;$i++)
   {
      if ($i < 10)
      {
         $sString = "0" . $i;
      } 
      else
      {
         $sString = $i;
      } 
      if ($iCurrentDay != $sString)
      {
         print ("<option value='$sString'");
         print (">$sString</option>\n");
      } 
   } 
   print ("</select>\n");
   print("&nbsp;");
   print("&nbsp;"); 
   // 
   // Display the Hour
   // 
   print ("<select class='fpull1'  name='hour'>\n");
   print ("<option value='$iCurrentHour' selected='selected'>$iCurrentHour</option>\n");
   for ($i = 0;$i < 25;$i++)
   {
      if ($i < 10)
      {
         $sString = "0" . $i;
      } 
      else
      {
         $sString = $i;
      } 
      if ($iCurrentHour != $sString)
      {
         print ("<option value='$sString'");
         print (">$sString</option>\n");
      } 
   } 
   print ("</select>\n");
   print(":"); 
   // 
   // Display the Hour
   // 
   print ("<select class='fpull1'  name='minute'>\n");
   print ("<option value='$iCurrentMinute' selected='selected'>$iCurrentMinute</option>\n");
   for ($i = 0;$i < 60;$i++)
   {
      if ($i < 10)
      {
         $sString = "0" . $i;
      } 
      else
      {
         $sString = $i;
      } 
      if ($iCurrentMinute != $sString)
      {
         print ("<option value='$sString'");
         print (">$sString</option>\n");
      } 
   } 
   print ("</select>\n");
   print("&nbsp;");
} 
?>
