<?php

/**
 * move.php
 *
 * Author: Steve Bourgeois <owl@bozzit.com>
 * Project Founder: Chris Vincent <cvincent@project802.net>
 * 
 * Copyright (c) 1999-2005 The Owl Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 * 
 * $Id: move.php,v 1.12 2005/03/23 00:21:00 b0zz Exp $
 */

require_once("./config/owl.php");
require_once("./lib/disp.lib.php");
require_once("./lib/owl.lib.php");
require_once("./lib/security.lib.php");

if ($sess == "0" && $default->anon_ro > 1)
{
   printError($owl_lang->err_login);
}

//print("M: $myaction_x X: $myaction");

if (isset($myaction_x))
{
   $myaction = "$owl_lang->cancel_button";
} 

global $order, $sortorder, $sortname;
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
if ($myaction == "$owl_lang->cancel_button")
{
   displayBrowsePage($parent);
   exit();
} 
if ($action == "file" or $action == "cp_file" or $action == "lnk_file")
{
   if (check_auth($id, "file_modify", $userid) == 0)
   {
      include("./lib/header.inc");
      include("./lib/userheader.inc");
      printError($owl_lang->err_nofilemod);
   } 
} elseif ($action == "bulk_move")
{
   if (isset($id))
   {
      $disp = unserialize(stripslashes(stripslashes(stripslashes(stripslashes(stripslashes($id))))));
   }
   
   if (isset($folders))
   {
      $fdisp = unserialize(stripslashes(stripslashes(stripslashes(stripslashes(stripslashes($folders))))));
   }
} 
else
{
   if (check_auth($id, "folder_modify", $userid) == 0 or check_auth($id, "folder_delete", $userid) == 0 )
   {
      include("./lib/header.inc");
      include("./lib/userheader.inc");
      printError($owl_lang->err_nofilemod);
   } 
} 

function checkForNewFolder()
{
   global $HTTP_POST_VARS, $newFolder, $moreFolder;
   if (!is_array($HTTP_POST_VARS)) return;
   while (list($key, $value) = each ($HTTP_POST_VARS))
   {
      if (substr($key, 0, 2) == "ID")
      {
         $newFolder = intval(substr($key, 2));
         break;
      } 
      if (substr($key, 0, 2) == "MO")
      {
         $moreFolder = intval(substr($key, 2));
         break;
      } 
   } 
} 

function showFoldersIn($fid, $folder)
{
   global $folderList, $fCount, $fDepth, $excludeID, $action, $id, $default, $userid, $moreFolder, $folders ; 

   $sql = new Owl_DB;
   

   // If restricted view is in effect only show the folders you do have access to
   $showfolder = 1;
   if ($default->restrict_view == 1)
      if (check_auth($fid, "folder_modify", $userid) != 0 && $fid != 0)
      {
         $showfolder = 1;
      }
      else
      {
         $showfolder = 0;
      }

      if ($showfolder == 1)
      {
         for ($c = 0 ;$c < ($fDepth-1) ; $c++) 
         {
            print "<img src='$default->owl_graphics_url/$default->sButtonStyle/ui_misc/blank.gif' alt='' height='16' width='16' align='top'></img>";
         }
         if ($fDepth) 
         {
            $sql->query("select name,parent from $default->owl_folders_table where parent='$fid'");
            if ($sql->num_rows() > 0)
            {
               print "<input type='image' src='$default->owl_graphics_url/$default->sButtonStyle/ui_misc/more.gif' align='top' name='MO" . $fid ."'></input>";
            }
            else
            {
               print "<img src='$default->owl_graphics_url/$default->sButtonStyle/ui_misc/link.gif' alt='' align='top'></img>";
            }
         }

         $gray = 0; //   Work out when to gray out folders ...
         if ($fid == $excludeID) $gray = 1; //   current parent for all moves
         if (($action == "folder" or $action == "cp_folder") && ($fid == $id)) $gray = 1; //   subtree for folder moves

         if (($action == "bulk_move")) 
         {
            $aFolders = unserialize(stripslashes(stripslashes(stripslashes(stripslashes(stripslashes($folders))))));
            foreach ($aFolders as $iFolder)
            {
               if ( $fid == $iFolder)
               {
                  $gray = 1;  // This is one of the folders we are moving
                  break;
               }
            }
         }
         if (($moreFolder > 0) && ($fid == $id)) $gray = 1; //   subtree for folder moves
         if (check_auth($fid, "folder_modify", $userid) == 0)
         {
            $gray = 1; //   check for permissions
         } 
         
         if ($gray)
         {
            print "<img src='$default->owl_graphics_url/$default->sButtonStyle/icon_filetype/folder_gray.gif' align='top' alt=''></img>";
            print " <font color=\"silver\">$folder</font><br></br>\n";
         } 
         else
         {
            print "<input type='image' src='$default->owl_graphics_url/$default->sButtonStyle/icon_filetype/folder_closed.gif' align='top' name='ID";
            print "$fid'></input> $folder<br></br>\n";
         } 
      } 
      if (($action == "folder") && ($fid == $id)) return; //   Don't show subtree of selected folder as target for folder move
      for ($c = 0; $c < $fCount; $c++)
      {
         if ($folderList[$c][2] == $fid)
         {
            $fDepth++;
            if ($fDepth == 1) 
            {
               showFoldersIn($folderList[$c][0] , $folderList[$c][1]);
            }
            $fDepth--;
         } 
      } 
   } 


   checkForNewFolder();

   if (isset($newFolder))
   {
      $sql = new Owl_DB;

      $source = "";
      $fID = $parent;
      do
      {
         $sql->query("SELECT name,parent from $default->owl_folders_table where id='$fID'");
         while ($sql->next_record())
         {
            $tName = $sql->f("name");
            $fID = $sql->f("parent");
         } 
         $source = $tName . "/" . $source;
      } 
      while ($fID != 0);

      $dest = "";
      $fID = $newFolder;
      do
      {
         $sql->query("SELECT name,parent from $default->owl_folders_table where id='$fID'");
         while ($sql->next_record())
         {
            $tName = $sql->f("name");
            $fID = $sql->f("parent");
         } 
         $dest = $tName . "/" . $dest;
      } 
      while ($fID != 0);

      if ($action == "file" or $action == "cp_file")
      {
         $sql = new Owl_DB;
         $sql->query("SELECT filename, parent from $default->owl_files_table where id = '$id'");
         while ($sql->next_record())
         {
            $fname = $sql->f("filename");
            $parent = $sql->f("parent");
         } 
      } 
      elseif ($action == "folder" or $action == "cp_folder")
      {
         $sql = new Owl_DB;
         $sql->query("SELECT name, parent from $default->owl_folders_table where id='$id'");
         while ($sql->next_record())
         {
            $fname = $sql->f("name");
            $parent = $sql->f("parent");
         } 
      } 

      if ($action == "lnk_file")
      {
         $sql->query("SELECT * from  $default->owl_files_table where id='$id'");
         $sql->next_record();

         $result = $sql->query("INSERT INTO $default->owl_files_table (name,filename,f_size,creatorid,parent,created,description,metadata,security,groupid,smodified,checked_out, major_revision, minor_revision, url, doctype, updatorid, linkedto, approved) values ('" . $sql->f("name") . "', '" . $sql->f("filename") . "', '" . $sql->f("f_size") . "', '" . $sql->f("creatorid") . "', '$newFolder', '" . $sql->f("created") . "', '" . $sql->f("description") . "', '" . $sql->f("metadata") . "', '" . $sql->f("security") . "', '" . $sql->f("groupid") . "','" . $sql->f("smodified") . "','" . $sql->f("checked_out") . "','" . $sql->f("major_revision") . "','" . $sql->f("minor_revision") . "', '" . $sql->f("url") . "', '" . $sql->f("doctype") . "', '" . $sql->f("updatorid") ."' , '$id', '" . $sql->f("approved") ."')");
         $newid = $sql->insert_id($default->owl_files_table, 'id');

         owl_syslog(FILE_LINKED, $userid, flid_to_filename($newid), $parent, $owl_lang->log_file_to . fid_to_name($newFolder), "FILE");
         displayBrowsePage($parent);
      }
      if ($action == "bulk_move")
      {
         if (isset($disp))
         {
            foreach($disp as $fid)
            {
               if (check_auth($fid, "file_modify", $userid) == 1)
               {
                  if ($default->owl_use_fs)
                  {
                     $sql = new Owl_DB;
                     $sql->query("SELECT filename, parent, url from $default->owl_files_table where id = '$fid'");
                     while ($sql->next_record())
                     {
                        $fname = $sql->f("filename");
                        $parent = $sql->f("parent");
                        if ($sql->f("url") == 1)
                        {
                           $type = "url";
                        } 
                        else
                        {
                           $type = "";
                        } 
                     } 
                     if ($type != "url")
                     {
                        if (!file_exists("$default->owl_FileDir/$dest$fname"))
                        {
                           if (substr(php_uname(), 0, 7) != "Windows")
                           {
                              $cmd = "mv \"$default->owl_FileDir/$source$fname\" \"$default->owl_FileDir/$dest\" 2>&1";
                              $lines = array();
                              $errco = 0;
                              $result = myExec($cmd, $lines, $errco);
                              if ($errco != 0)
                              {
                                 printError($owl_lang->err_movecancel, $result);
                              } 
                           } 
                           else
                           { 
                              // IF Windows just do a rename and hope for the best
                              rename ("$default->owl_FileDir/$source$fname", "$default->owl_FileDir/$dest/$fname");
                           } 
                        } 
                        else
                        {
                           printError($owl_lang->err_fileexists . "$default->owl_FileDir/$dest$fname", $result);
                        } 
                     } 
                  } 
                  $sql->query("update $default->owl_files_table set parent='$newFolder' where id='$fid'");
                  owl_syslog(FILE_MOVED, $userid, flid_to_filename($fid), $parent, $owl_lang->log_file_to . fid_to_name($newFolder), "FILE");
               } 
            } 
         }
         if (isset($fdisp))
         {
            foreach($fdisp as $fid)
            {
               if (check_auth($fid, "folder_modify", $userid) == 1)
               {
                  if ($default->owl_use_fs)
                  {
                     $sql = new Owl_DB;
                     $sql->query("SELECT name, parent from $default->owl_folders_table where id='$fid'");
                     while ($sql->next_record())
                     {
                        $fname = $sql->f("name");
                        $parent = $sql->f("parent");
                     }
                     if (!file_exists("$default->owl_FileDir/$dest$fname"))
                     {
                        if (substr(php_uname(), 0, 7) != "Windows")
                        {
                           $cmd = "mv \"$default->owl_FileDir/$source$fname\" \"$default->owl_FileDir/$dest\" 2>&1";
                           $lines = array();
                           $errco = 0;
                           $result = myExec($cmd, $lines, $errco);
                           if ($errco != 0)
                           {
                              printError($owl_lang->err_movecancel, $result);
                           }
                        } 
                        else
                        { 
                           // IF Windows just do a rename and hope for the best
                           rename ("$default->owl_FileDir/$source$fname", "$default->owl_FileDir/$dest/$fname");
                        } 
                     } 
                     else
                     {
                        printError($owl_lang->err_fileexists . "$default->owl_FileDir/$dest$fname", $result);
                     }
                     $sql->query("update $default->owl_folders_table set parent='$newFolder' where id='$fid'");
                     owl_syslog(FOLDER_MOVED, $userid, fid_to_name($fid), $parent, $owl_lang->log_file_to . fid_to_name($newFolder), "FILE");
                  } 
               }
            }
         }
      } 
      else
      {
         if ($default->owl_use_fs)
         {
            $Realid = fGetPhysicalFileId($fid);
            if ($type != "url" and $Realid == $fid)
            {
               if (!file_exists("$default->owl_FileDir/$dest$fname"))
               {
                  if (substr(php_uname(), 0, 7) != "Windows")
                  {
                     if ($action == "cp_file")
                     { 
                        $cmd = "cp \"$default->owl_FileDir/$source$fname\" \"$default->owl_FileDir/$dest\" 2>&1";
                        $lines = array();
                        $errco = 0;
                        $result = myExec($cmd, $lines, $errco);
                        if ($errco != 0)
                        {
                           printError($owl_lang->err_movecancel, $result);
                        }
                     }
                     else if ( $action == "cp_folder")
                     {
                        my_dir_copy("$default->owl_FileDir/$source$fname", "$default->owl_FileDir/$dest" . fid_to_name($id) ); 
                        //printError("S: $source N: $fname" , "$default->owl_FileDir/$source$fname", "$default->owl_FileDir/$dest" . fid_to_name($id) ); 
                     }
                     else if ( $action == "folder")
                     {
                        $cmd = "mv \"$default->owl_FileDir/$source$fname\" \"$default->owl_FileDir/$dest\" 2>&1";
                        $lines = array();
                        $errco = 0;
                        $result = myExec($cmd, $lines, $errco);
                        if ($errco != 0)
                        {  
                           printError($owl_lang->err_movecancel, $result);
                        }
                     }
                     else 
                     {
                        $cmd = "mv \"$default->owl_FileDir/$source$fname\" \"$default->owl_FileDir/$dest\" 2>&1";
                        $lines = array();
                        $errco = 0;
                        $result = myExec($cmd, $lines, $errco);
                        if ($errco != 0)
                        {
                           printError($owl_lang->err_movecancel, $result);
                        }
                     }
                  } 
                  else
                  { 
                     if ($action == "cp_file")
                     {
                        // IF Windows just do a copy and hope for the best
                        copy ("$default->owl_FileDir/$source$fname", "$default->owl_FileDir/$dest/$fname");
                     }
                     else if ( $action == "cp_folder")
                     {
                        my_dir_copy("$default->owl_FileDir/$source$fname", "$default->owl_FileDir/$dest"); 
                     }
                     else
                     {
                        // IF Windows just do a rename and hope for the best
                        rename ("$default->owl_FileDir/$source$fname", "$default->owl_FileDir/$dest/$fname");
                     }
                  } 
               } 
               else
               {
                  printError($owl_lang->err_fileexists . "$default->owl_FileDir/$dest$fname", $result);
               }
            } 
         } 
      } 

      if ($action == "file")
      {
         $sql->query("update $default->owl_files_table set parent='$newFolder' where id='$id'");
         owl_syslog(FILE_MOVED, $userid, flid_to_filename($id), $parent, $owl_lang->log_file_to . fid_to_name($newFolder), "FILE");
      } 
      else if ($action == "cp_file")
      {
         if (!$default->owl_use_fs) 
         {
            $sql->query("SELECT * from  $default->owl_files_data_table  where id='$id'");
            $sql->next_record();
            $filedata = $sql->f("data");
            $compressed = $sql->f("compressed");
         } 
        
         $sql->query("SELECT * from  $default->owl_files_table where id='$id'");
         $sql->next_record();

         $result = $sql->query("INSERT INTO $default->owl_files_table (name,filename,f_size,creatorid,parent,created,description,metadata,security,groupid,smodified,checked_out, major_revision, minor_revision, url, doctype, linkedto, approved) values ('" . $sql->f("name") . "', '" . $sql->f("filename") . "', '" . $sql->f("f_size") . "', '" . $sql->f("creatorid") . "', '$newFolder', '" . $sql->f("created") . "', '" . $sql->f("description") . "', '" . $sql->f("metadata") . "', '" . $sql->f("security") . "', '" . $sql->f("groupid") . "','" . $sql->f("smodified") . "','" . $sql->f("checked_out") . "','" . $sql->f("major_revision") . "','" . $sql->f("minor_revision") . "', '" . $sql->f("url") . "', '" . $sql->f("doctype") . "', '" . $sql->f("linkedto") . "', '" . $sql->f("approved") ."')");
         $newid = $sql->insert_id($default->owl_files_table, 'id');                                                                                                                                                                                               
         if (!$default->owl_use_fs) 
         {
            $sql->query("INSERT into $default->owl_files_data_table (id, data, compressed) values ('$newid', '$filedata','$compressed')");
         } 

         if (!$result && $default->owl_use_fs) unlink($newpath);

         owl_syslog(FILE_COPIED, $userid, flid_to_filename($newid), $parent, $owl_lang->log_file_to . fid_to_name($newFolder), "FILE");
      } 
      else if ($action == "cp_folder")
      {
         fCopyFolder($id, $newFolder);
         owl_syslog(FOLDER_COPIED, $userid, fid_to_name($id), $parent, $owl_lang->log_file_to . fid_to_name($newFolder), "FILE");
      }
      else if ($action == "folder")
      {
         $sql->query("update $default->owl_folders_table set parent='$newFolder' where id='$id'");
         owl_syslog(FOLDER_MOVED, $userid, fid_to_name($id), $parent, $owl_lang->log_file_to . fid_to_name($newFolder), "FILE");
      } 

      // if we deleted something that was in the backup directory
      // we want to display the Parent Directory when we are done
      displayBrowsePage($parent);
   } 
   // First time through. Generate screen for selecting target directory

   include("./lib/header.inc");
   include("./lib/userheader.inc");
    if ($parent == 0)
   {
      $parent = 1;
   }
                                                                                                                                                                                                 
   print("<center>"); 
   if ($expand == 1)
   {
      print("<table class='border1' cellspacing='0' cellpadding='0' border='0' width='$default->table_expand_width'>\n<tr>\n<td align='left' valign='top' width='100%'>\n");
   }
   else
   {
      print("<table class='border1' cellspacing='0' cellpadding='0' border='0' width='$default->table_collapse_width'>\n<tr>\n<td align='left' valign='top' width='100%'>\n");
   }
   fPrintButtonSpace(12, 1);
   print("<br />\n");
   print("<table class='border2' cellspacing='0' cellpadding='0' border='0' width='100%'>\n<tr>\n<td align='left' valign='top' width='100%'>\n");
                                                                                                                                                                                                 
  if ($default->show_prefs == 1 or $default->show_prefs == 3)
  {
         fPrintPrefs("infobar1", "top");
  }
   fPrintButtonSpace(12, 1);
   print("<br />\n");
                                                                                                                                                                                                 

   if ($action == "bulk_move")
   {
      fPrintNavBar($parent, $owl_lang->moving . ":&nbsp;");
   }
   else
   {
      if ($action == "folder")
      {
         fPrintNavBar($id, $owl_lang->moving_folder . ":&nbsp;");
      }
      elseif ($action == "lnk_file")
      {
         fPrintNavBar($parent, "LINKING FILE" . ":&nbsp;", $id);
      }
      elseif ($action == "cp_file")
      {
         fPrintNavBar($parent, $owl_lang->copy_file . ":&nbsp;", $id);
      }
      elseif ($action == "cp_folder")
      {
         fPrintNavBar($id, $owl_lang->copy_folder . ":&nbsp;");
      }
      else
      {
         fPrintNavBar($parent, $owl_lang->moving_file . ":&nbsp;", $id);
      }
   }
   //print("</TABLE><br />\n");
   // Get information about file or directory we want to move
   if ($action == "file")
   {
      $sql = new Owl_DB;
      $sql->query("SELECT filename, parent from $default->owl_files_table where id='$id'");
   } elseif ($action == "bulk_move")
   {
      $sql = new Owl_DB;
      $sql2 = new Owl_DB;
      $query = "SELECT * from $default->owl_files_table where ";
      $query2 = "SELECT * from $default->owl_folders_table where ";
      if (isset($disp))
      {
         foreach($disp as $fid)
         {
            if (check_auth($fid, "file_modify", $userid) == 1)
            {
               $query .= "id = '" . $fid . "' or ";
            } 
         } 
         $query .= "id = " . $fid . " and 1=1";
         $sql->query("$query");
      }

      if (isset($fdisp))
      {
      foreach($fdisp as $fid)
      {
         if (check_auth($fid, "folder_modify", $userid) == 1)
         {
            $query2 .= "id = '" . $fid . "' or ";
         } 
      } 
      $query2 .= "id = " . $fid . " and 1=1";
      $sql2->query("$query2");
      }
   } 
   else
   {
      $sql = new Owl_DB;
      $sql->query("SELECT name, parent from $default->owl_folders_table where id='$id'");
   } 
   print("<br />\n");
   print("<table class='margin2' cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
   print("<tr>\n");
   print("<td align='left' valign='top'>\n");
   print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>\n");

   if (isset($fdisp))
   {
      while ($sql2->next_record())
      {
         $fname = $sql2->f("name");
         $parent = $sql2->f("parent");
         print "<tr>\n<td><font size='1'><b style=\"color:#0000aa;\">".$owl_lang->moving."</b></font></td>\n<td align='left'>&nbsp;<img src='$default->owl_graphics_url/$default->sButtonStyle/icon_filetype/folder_closed.gif' alt=''></img><font size='1'>$fname</font></td>\n</tr>\n";
      } 
   }
   if (isset($disp))
   {
      while ($sql->next_record())
      {
         if ($action == "file" || $action == "bulk_move") 
         {
            $fname = $sql->f("filename");
         }
         if ($action == "folder") 
         {
            $fname = $sql->f("name");
         }
         $parent = $sql->f("parent");
	 print "<tr>\n<td><font size='1'><b style=\"color:#0000aa;\">".$owl_lang->moving."</b></font></td>\n<td align='left'><font size='1'>&nbsp;<img src='$default->owl_graphics_url/$default->sButtonStyle/ui_misc/16x16.gif' alt=''></img>$fname.</font></td>\n</tr>\n";
      } 
   }

   print "<tr>\n<td colspan='2'>\n<font size='1'>$owl_lang->select</font></td>\n</tr>\n</table>\n";

   print("<form method='post' action=''>");
   $urlArgs2 = $urlArgs;
   $urlArgs2['action'] = $action;
   $urlArgs2['myaction'] = $myaction;
   $urlArgs2['fname'] = $fname;
   $urlArgs2['id'] = $id;
   print fGetHiddenFields ($urlArgs2);


if (isset($moreFolder))
{
   print gen_navbar($moreFolder,0,1);
   print("<table class='margin2' cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
   print("<tr>\n");
   print("<td align='left' valign='top'>\n");
   print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>\n");

}

print ("<table cellspacing='0' border='1' cellpadding='4'>\n<tr>\n<td align='left' bgcolor='white'>\n<p>\n");

   // Get list of folders sorted by name
   $whereclause = " ";

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
   
   $excludeID = $parent; // current location should not be a offered as a target

 
   if (isset($moreFolder))
   {
      showFoldersIn($moreFolder, fid_to_name($moreFolder));
   }
   else
   {
      showFoldersIn($default->HomeDir, fid_to_name($default->HomeDir));
   }

   print("</p>\n</td>\n</tr>\n");
   print("</table>\n");
   print("</form>\n");
   print("</td>\n</tr>\n</table>\n</td>\n</tr>\n<tr>\n");
   print("<td colspan=\"2\" class='form2' width='90%' nowrap=\"nowrap\">\n");
   fPrintButtonSpace(4, 12);
   print("<form method='post' action=''>");
   fPrintSubmitButton($owl_lang->cancel_button, $owl_lang->alt_cancel, "submit", "myaction_x");
   fPrintButtonSpace(1, 12);
   print("</form>");
   print("</td>\n</tr><tr><td>\n");
   fPrintButtonSpace(12, 1);
   
   if ($default->show_prefs == 2 or $default->show_prefs == 3)
   {
      fPrintPrefs("infobar2");
   }
   print("</td>\n</tr>\n</table>\n");
   include("./lib/footer.inc");
?>
