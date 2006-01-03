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
 * $Id: log.php,v 1.11 2005/03/22 13:25:53 b0zz Exp $
 */

require_once("./config/owl.php");
require_once("./lib/disp.lib.php");
require_once("./lib/owl.lib.php");
require_once("./lib/security.lib.php");
include_once("./lib/header.inc");
include_once("./lib/userheader.inc");

// store file name and extension separately

//$filename = unserialize(stripslashes(stripslashes($filename)));
$filename = ereg_replace("<amp>","&", $filename);

$filesearch = explode('.', $filename);
$extensioncounter = 0;
while ($filesearch[$extensioncounter + 1] != null)
{ 
   // pre-append a "." separator in the name for each
   // subsequent part of the the name of the file.
   if ($extensioncounter != 0)
   {
      $firstpart = $firstpart . ".";
   } 
   $firstpart = $firstpart . $filesearch[$extensioncounter];
   $extensioncounter++;
} 
if ($extensioncounter == 0)
{
   $firstpart = $filename;
   $file_extension = '';
} 
else
{
   $file_extension = $filesearch[$extensioncounter];
} 
// Begin 496814 Column Sorts are not persistant
// + ADDED &order=$order&$sortorder=$sortname to
// all browse.php?  header and HREF LINES
switch ($order)
{
   case "name":
      $sortorder = 'sortname';
      break;
   case "major_revision":
      $sortorder = 'sortver';
      break;
   case "filename" :
      $sortorder = 'sortfilename';
      break;
   case "size" :
      $sortorder = 'sortsize';
      break;
   case "creatorid" :
      $sortorder = 'sortposted';
      break;
   case "smodified" :
      $sortorder = 'sortmod';
      break;
   case "checked_out":
      $sortorder = 'sortcheckedout';
      break;
   default:
      $order= "name";
      $sortorder= "sortname";
      break;
} 
// END 496814 Column Sorts are not persistant
print("<center>\n");

if ($expand == 1)
{
   print("<table class=\"border1\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"$default->table_expand_width\"><tr><td align=\"left\" valign=\"top\" width=\"100%\">\n");
}
else
{
   print("<table class=\"border1\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"$default->table_collapse_width\"><tr><td align=\"left\" valign=\"top\" width=\"100%\">\n");
}
fPrintButtonSpace(12, 1);
print("<br />\n");
print("<table class=\"border2\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\"><tr><td align=\"left\" valign=\"top\" width=\"100%\">\n");

if ($default->show_prefs == 1 or $default->show_prefs == 3)
{
      fPrintPrefs("infobar1", "top");
}
fPrintButtonSpace(12, 1);
print("<br />\n");
fPrintNavBar($parent, $owl_lang->viewlog . ":&nbsp;", $id);

print("<table class=\"margin2\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
print("<tr>\n");
print("<td align=\"left\" valign=\"top\">\n");
print("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");

print("<tr><td class=\"browse0\" width=\"100%\" colspan=\"20\">$filename</td></tr>\n");
print("<tr><td class=\"title1\">$owl_lang->ver</td>\n");
print("<td class=\"title1\">$owl_lang->user</td>\n");
print("<td class=\"title1\">$owl_lang->alt_log_file</td>\n");
print("<td class=\"title1\">$owl_lang->modified</td>\n");
print("<td class=\"title1\">$owl_lang->last_modified</td></tr>");

$sql = new Owl_DB; 

// SPECIFIC SQL LOG QUERY -  NOT USED (problematic)
// This SQL log query is designed for repository assuming there is only 1
// digit in major revision, and noone decides to have a "_x-" in their
// filename.

// Has to be changed if the naming structure changes.
// Also a problem that it didn't catch the "current"
// file because of the "_x-" matching (grr)

// $sql->query("select * from $default->owl_files_table where filename LIKE '$filesearch[0]\__-%$filesearch[1]' order by major_revision desc, minor_revision desc");
// GENERIC SQL LOG QUERY - currently used.
// prone to errors when people name a set of docs
// Blah.doc
// Blah_errors.doc
// Blah_standards.doc
// etc. and search for a log on Blah.doc (it brings up all 3 docs)
// $sql->query("select * from $default->owl_files_table where filename LIKE '$filesearch[0]%$filesearch[1]' order by major_revision desc, minor_revision desc");
// $SQL = "select * from $default->owl_files_table where filename LIKE '$filesearch[0]%$filesearch[1]' order by major_revision desc, minor_revision desc";
if ($default->owl_use_fs)
{
   $sql->query("Select id from $default->owl_folders_table where name='backup' and parent='$parent'");
   if ($sql->num_rows($sql) != 0)
   {
      while ($sql->next_record())
      {
         $backup_parent = $sql->f("id");
      } 
   } 
   else
   {
      $backup_parent = $parent;
   } 
   $sql->query("select * from $default->owl_files_table where (filename LIKE '" . $firstpart . "\\_%" . $file_extension . "' OR filename = '$filename') AND (parent = '$backup_parent' OR parent = '$parent') order by major_revision desc, minor_revision desc");
} 
else
{
   // name based query -- assuming that the given name for the file doesn't change...
   // at some point, we should really look into creating a "revision_id" field so that all revisions can be linked.
   // in the meanwhile, the code for changing the Title of the file has been altered to go back and
   $name = flid_to_name($id);
   $sQuery = "select * from $default->owl_files_table where name='$name' AND parent='$parent' order by major_revision desc, minor_revision desc";

   //print("DEBUG: $sQuery");

   $sql->query($sQuery);
} 

$CountLines = 0;
while ($sql->next_record())
{
   $choped = split("\.", $sql->f("filename"));
   $pos = count($choped);
   $ext = strtolower($choped[$pos-1]);

   if ($default->owl_use_fs )
   {
      $sFilePattern =  $firstpart . "\_[0-9]*\-[0-9]*\." . $file_extension;
      if(!ereg("$sFilePattern", $sql->f("filename")) and  $id != $sql->f("id"))
      {
         continue;
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

   print("<tr><td class=\"$sTrClass\" valign=\"top\">" . $sql->f("major_revision") . "." . $sql->f("minor_revision") . "</td>
               <td class=\"$sTrClass\" valign=\"top\">" . uid_to_name($sql->f("creatorid")) . "</td>
               <td class=\"$sTrClass\" valign=\"top\" align=\"left\" width=\"70%\"><font size=\"2\" style=\"font-weight:bold\">");

   if ($sql->f("parent") == $parent)
   {
       $is_backup_folder = false;
   }
   else
   {
       $is_backup_folder = true;
   }
   
   printFileIcons($sql->f("id"), $sql->f("filename"), $sql->f("checked_out"), $sql->f("url"), $default->owl_version_control, $ext, $sql->f("parent"), $is_backup_folder);

   print("&nbsp;&nbsp;[ " . $sql->f("filename") . " ]</font><br></br>" . nl2br($sql->f("description")) . "</td>
               <td class=\"$sTrClass\" valign=\"top\">" . date($owl_lang->localized_date_format, strtotime($sql->f("smodified"))) . "</td>
               <td class=\"$sTrClass\" valign=\"top\">" . uid_to_name($sql->f("updatorid")) ."</td></tr>");
} 
print("</table>");
print("</td></tr></table>\n");
fPrintButtonSpace(12, 1);
                                                                                                                                                                                       
          
if ($default->show_prefs == 2 or $default->show_prefs == 3)
{
   fPrintPrefs("infobar2");  
}
print("</td></tr></table>\n");
include("./lib/footer.inc");
?>
