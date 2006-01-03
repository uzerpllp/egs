<?php

/**
 * recycle.php
 * 
 * Author: Steve Bourgeois <owl@bozzit.com>
 * Project Founder: Chris Vincent <cvincent@project802.net>
 * 
 * Copyright (c) 1999-2005 The Owl Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 * 
 */

require("../config/owl.php");
require("../lib/disp.lib.php");
require("../lib/owl.lib.php");
require("../lib/readhd.php");

if (!fIsAdmin(true)) 
{
   die("$owl_lang->err_unauthorized");
}

if (isset($bemptyaction_x))
{
   $action = $owl_lang->empty_trash;
} elseif (isset($bdeleteaction_x))
{
   $action = $owl_lang->del_selected;
} elseif (isset($brestoreaction_x))
{
   $action = $owl_lang->rest_selected;
}

$sql = new Owl_DB; //create new db connection
$sql->query("SELECT name from $default->owl_folders_table where id = 1");
$sql->next_record();
$sRootFolderName = $sql->f("name");
// 
// Delete all Selected Files
// 
if ($action == "$owl_lang->del_selected")
{
   foreach($batch as $sDeleteThis)
   {
      myDelete($default->trash_can_location . "/" . $sDeleteThis);
   } 
   header("Location: recycle.php?sess=$sess&folder=$folder");
} 
//
// Restore all Selected Files
//
function restoreFile($file,$path,$folderid)
{
   global $owl_lang, $default, $parent;

   $fileparts = explode("/",$file);
   $srcfile = $fileparts[count($fileparts)-1];

   $destfile = $default->restore_file_prefix . $srcfile;

   if(file_exists("$default->owl_FileDir/$path/$destfile"))
   {
      $i = 2;
      while(file_exists("$default->owl_FileDir/$path/$default->restore_file_prefix$i-file"))
         $i++;
      $destfile = "$default->restore_file_prefix$i-file";
   }

   if (substr(php_uname(), 0, 7) != "Windows")
   {
      $cmd = "mv " . '"' . "$default->trash_can_location/$file" . '" "' . "$default->owl_FileDir/$path/$destfile" . '"';
      $lines = array();
      $errco = 0;
      $result = myExec($cmd, $lines, $errco);
      if ($errco != 0)
      {
         printError($owl_lang->err_general, $result);
      }
   }
   else
   {
      copy("$default->trash_can_location/$file", "$default->owl_FileDir/$path/$destfile");
      unlink($default->trash_can_location . "/" . $file);
   }

//   function InsertHDFilezInDB($TheFile, $parent, $ThePath, $DBTable);
   chdir("..");
   InsertHDFilezInDB($destfile,$folderid,"$default->owl_FileDir/$path","trash");
}

if ($action == "$owl_lang->rest_selected" && isset($batch))
{
   $path = find_path(intval($folder_id));
   foreach($batch as $filename)
   {
      restoreFile($filename,$path,$folder_id);
   }
   header("Location: recycle.php?sess=$sess&folder=$folder");
}
// 
// Delete Folder
// 
if ($action == "del_folder")
{
   myDelete($default->trash_can_location . "/" . $folder);
   $filesearch = explode('/', $folder);
   $extensioncounter = 0;
   while ($filesearch[$extensioncounter + 1] != null)
   { 
      // pre-append a "." separator in the name for each
      // subsequent part of the the name of the file.
      if ($extensioncounter != 0)
      {
         $firstpart = $firstpart . "/";
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
   header("Location: recycle.php?sess=$sess&folder=$firstpart");
} 
// 
// Empty Trash Can
// 
if ($action == $owl_lang->empty_trash)
{
   myDelete($default->trash_can_location . "/" . $sRootFolderName);
   header("Location: recycle.php?sess=$sess&folder=$sRootFolderName");
} 

include("../lib/header.inc");
include("../lib/userheader.inc");

if (!isset($folder) || $folder == "")
{
   $sRecyclePath = $sRootFolderName;
} 
else
{
   $sRecyclePath = $folder;
} 

if (!file_exists($default->trash_can_location . "/" . $sRecyclePath))
{
   printError($owl_lang->err_trash_can_empty);
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

fPrintAdminPanel($action);

print("<table class='margin2' cellspacing='0' cellpadding='0' border='0' width='100%'><tr><td align='left' valign='top'>\n");
print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>");
print("<tr><td class='admin0' width='100%' colspan='8'>$owl_lang->recycle_bin_admin</td></tr>\n");

print("<form name='FileList' enctype='multipart/form-data' action='recycle.php' method='post'>\n
                        <input type='hidden' name='sess' VALUE='$sess'\n>
                        <input type='hidden' name='folder' VALUE='$folder'\n>
                        <input type='hidden' name='action' VALUE='delete'>\n");
// 
// Show the Directories in the
// Recycle Bin
// 
$iCountLines = 0;

if ($Dir = opendir($default->trash_can_location . "/" . $sRecyclePath))
{
   print("<tr><td colspan='3' height='40' align='left'>$default->trash_can_location" . "/" . $sRecyclePath . "</td></tr>");
   if (!($sRecyclePath == $sRootFolderName))
   { 
      // I SEEM TO USE THIS IN QUITE A FEW PLACES
      // Maybe I should make this a FUNCTION?
      $filesearch = explode('/', $sRecyclePath);
      $extensioncounter = 0;
      while ($filesearch[$extensioncounter + 1] != null)
      { 
         // pre-append a "." separator in the name for each
         // subsequent part of the the name of the file.
         if ($extensioncounter != 0)
         {
            $firstpart = $firstpart . "/";
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

      print("\t\t\t\t<tr>");
      print("\n<td class='title1' width='1%' align='left'>&nbsp;</td>\n");
      print("<td class='title1' width='1%' align='left'><img src='$default->owl_graphics_url/$default->sButtonStyle/icon_filetype/folder_closed.gif' border='0' alt=''></img></td>\n<td class='title1' align='lef't><a class='lfile1' href='recycle.php?folder=" . $firstpart . "&amp;sess=" . $sess . "'>..</a></td>\n</tr>\n");
   } 

   while ($file = readdir($Dir))
   {
      if ($file[0] == '.')
      {
         continue;
      } 
      if (!is_file($default->trash_can_location . "/" . $sRecyclePath . "/" . $file))
      {
         $iCountLines++;
         $iPrintLines = $iCountLines % 2;
         if ($iPrintLines == 0)
         {
            $sTrClass = "file1";
            $sLfList = "lfile1";
         }
         else
         {
            $sTrClass = "file2";
            $sLfList = "lfile1";
         }
         print("<tr>\n<td class='$sTrClass'><a href='recycle.php?folder=" . $sRecyclePath . "/" . $file . "&amp;sess=" . $sess . "&amp;action=del_folder' onclick='return confirm(\"$owl_lang->reallydelete ?\");'><img src='$default->owl_graphics_url/$default->sButtonStyle/ui_misc/admin_del_folder.gif' alt='$owl_lang->alt_del_this_folder $file' title='$owl_lang->alt_del_this_folder $file' border='0'></img></a></td><td class='$sTrClass'><img src='$default->owl_graphics_url/$default->sButtonStyle/icon_filetype/folder_closed.gif' border='0' alt=''></img></td>\n<td class='$sTrClass'><a class='$sLfList' href='recycle.php?folder=" . $sRecyclePath . "/" . $file . "&amp;sess=" . $sess . "'>" . $file . "</a></td>\n</tr>\n");
      } 
   } 
} 
else
{
   printError($owl_lang->err_general);
} 
// 
// Show the Files in the
// Recycle Bin
// 
if ($Dir = opendir($default->trash_can_location . "/" . $sRecyclePath))
{
   while ($file = readdir($Dir))
   {
      if ($file[0] == '.')
         continue;

      if (is_file($default->trash_can_location . "/" . $sRecyclePath . "/" . $file))
      {
         $iCountLines++;
         $iPrintLines = $iCountLines % 2;
         if ($iPrintLines == 0)
         {
            $sTrClass = "file1";
            $sLfList = "lfile1";
         }
         else
         {
            $sTrClass = "file2";
            $sLfList = "lfile1";
         }
         print("\n<tr>\n<td class='$sTrClass' width='1%'><input type='checkbox' name='batch[]' value='" . $sRecyclePath . "/" . $file . "'></input><td  class='$sTrClass' width='1%'>");


      $choped = split("\.", $file);
      $pos = count($choped);
      if ( $pos > 1 )
      {
         $ext = strtolower($choped[$pos-1]);
         $sDispIcon = $ext;
      }
      else
      {
         $sDispIcon = "NoExtension";
      }
                                                                                                                                                                                                  
      if (($ext == "gz") && ($pos > 2))
      {
         $exttar = strtolower($choped[$pos-2]);
         if (strtolower($choped[$pos-2]) == "tar")
            $ext = "tar.gz";
      }
                                                                                                                                                                                                  
         if (!file_exists("$default->owl_fs_root/graphics/$default->sButtonStyle/icon_filetype/$sDispIcon.gif"))
         {
            $sDispIcon = "file";
         }
         print("<img src='$default->owl_graphics_url/$default->sButtonStyle/icon_filetype/$sDispIcon.gif' border='0' alt=''></img>");
         print("</td>\n<td class='$sTrClass'>");
         print("$file</td>\n</tr>\n");
      } 
   } 
} 
else
{
   printError($owl_lang->err_general);
} 

print("<br />");
print("<tr><td  class='$sTrClass' align='left' colspan='3' height='40' align='left'><a href='#' onclick='CheckAll();'><img src='$default->owl_graphics_url/$default->sButtonStyle/ui_icons/tg_check.gif' alt='$owl_lang->alt_toggle_check_box' title='$owl_lang->alt_toggle_check_box' border='0'></img></a></td></tr>\n");
         print("<tr>");
         print("<td class='form1'>");
         fPrintButtonSpace(1, 1);
         print("</td>");
         print("<td class='form1'>");
         fPrintButtonSpace(1, 1);
         print("</td>");
         print("<td class='form2' width='100%'>");
         print("<input class='fbuttonup1' name='bdeleteaction_x' type='submit' value='$owl_lang->del_selected' title='$owl_lang->alt_del_selected' onclick='return confirm(\"$owl_lang->reallydelete_selected ?\");' onmouseover=\"highlightButton('fbuttondown1')\" onmouseout=\"highlightButton('fbuttonup1')\"></input>");
         print("<input class='fbuttonup1' name='bemptyaction_x' type='submit' value='$owl_lang->del_all' title='$owl_lang->alt_del_all' onclick='return confirm(\"$owl_lang->reallydelete_selected ?\");' onmouseover=\"highlightButton('fbuttondown1')\" onmouseout=\"highlightButton('fbuttonup1')\"></input>");
         print("</td>");
         print("</tr>");




         print("<tr>");
         print("<td colspan='3' class='form1'>");
         fPrintButtonSpace(20, 1);
         print("</td>");
         print("</tr>");
         print("<tr>");
         print("<td class='form1'>");
         fPrintButtonSpace(1, 1);
         print("</td>");

         print("<td class='form2' width='1%'>&nbsp;</td>");
         print("<td class='form2' width='100%'>");
         print("<input class='fbuttonup1' name='brestoreaction_x' type='submit' value='$owl_lang->rest_selected' title='$owl_lang->alt_restdel_selected' onclick='return confirm(\"$owl_lang->reallyrestore_selected ?\");' onmouseover=\"highlightButton('fbuttondown1')\" onmouseout=\"highlightButton('fbuttonup1')\"></input>");

         print("&nbsp;&nbsp;<select class='fpull1' name='folder_id'>\n");
         exploreFolders();
         print("</select>\n");

         print("</td>");
         print("</tr>");

print("</td></tr>");
print("</form></table>");
print("</td></tr></table>\n");
fPrintButtonSpace(12, 1);
print("<br />\n");

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


function exploreFolders($parent = 0, $level = 0)
{
   $s = new Owl_DB;
   $s->query("SELECT id, name FROM folders WHERE parent = ".$parent);
   while($s->next_record())
   {
      print("<option value='".$s->f('id')."'>");
      for($i=0; $i<$level*3+1; $i++)
         print("&nbsp;");
      print($s->f('name')."</option>\n");
      exploreFolders($s->f('id'), $level+1);
   }
}

?>
<script language="JavaScript" type="text/javascript">
<!-- 
function CheckAll() {
  for (var i = 0; i < document.FileList.elements.length; i++) {
    if(document.FileList.elements[i].type == "checkbox"){
      document.FileList.elements[i].checked =         !(document.FileList.elements[i].checked);
    }
  }
}
//-->
</script>
