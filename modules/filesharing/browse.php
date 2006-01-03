<?php
/**
 * browse.php -- Browse page
 * 
 * Author: Steve Bourgeois <owl@bozzit.com> 
 * Project Founder: Chris Vincent <cvincent@project802.net>
 *
 * Copyright (c) 1999-2004 The Owl Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 * 
 */

require_once("./config/owl.php");
require_once("./lib/disp.lib.php");

require_once("./lib/owl.lib.php");

require_once("./lib/readhd.php");

require_once("./lib/security.lib.php");

include_once("./lib/header.inc");

include_once("./lib/userheader.inc");

if (empty($parent) || !is_numeric($parent)) 
{
	
   $parent = $default->HomeDir;
   if(isset($fileid))
   {
      $parent =  owlfileparent($fileid);
   }
   
}
else
{
	
   // Check to see if the user tried to go outside his home directory
   if ($parent != $default->HomeDir )
   {
      $bIsWithinHomeDir = false;
      fCheckWithinHomeDir ( $parent );
      if (!$bIsWithinHomeDir)
      {
        printError($owl_lang->err_unauthorized);
      }
   } 

}

$CheckPass = new Owl_DB;
$CheckPass->query("select password from " . $default->owl_folders_table . " where id='$parent'");
$CheckPass->next_record();
$password = $CheckPass->f("password");


$bPasswordFailed = false;

if ($password == md5($docpassword))
{
  $bDownloadAllowed = true;
}
else
{
  if(!empty($docpassword))
  {
     $bPasswordFailed = true;
  }
  $bDownloadAllowed = false;
}



if (!isset($nextfiles)) 
{
   $nextfiles = 0;
}
if (!isset($nextfolders)) 
{
   $nextfolders = 0;
}

if (!isset($bDisplayFiles))
{
 $bDisplayFiles = false;
}

if (!isset($expand) or !is_numeric($expand)) 
{
   $expand = $default->expand;
}

if (!isset($order)) 
{
   $order = $default->default_sort_column;
}
if (!isset($sortname)) 
{
   $sortname = $default->default_sort_order;
}

if (!isset($sortver) or strlen($sortver) > 24) 
{
   $sortver = "ASC, minor_revision ASC";
}
if (!isset($sortcheckedout) or strlen($sortcheckedout) > 4) 
{
   $sortcheckedout = "ASC";
}
if (!isset($sortfilename) or strlen($sortfilename) > 4) 
{
   $sortfilename = "DESC";
}
if (!isset($sortsize) or strlen($sortsize) > 4) 
{
   $sortsize = "DESC";
}
if (!isset($sortposted) or strlen($sortposted) > 4) 
{
   $sortposted = "DESC";
}
if (!isset($sortmod) or strlen($sortmod) > 4) 
{
   $sortmod = "DESC";
}
if (!isset($sort) or strlen($sort) > 4) 
{
   $sort = "asc";
}


// Initialize Page count Variables

if (!isset($iCurrentPage))
{
   $iCurrentPage = 0;
}

if (!isset($next))
{
   $next = 0;
}

if (!isset($prev))
{
   $prev = 0;
}

// Display the Footer Tools (Seach, Newsadmin and Admin)
$bDisplayFooterTools = true;

switch ($order)
{
   case "id":
      $sortorder = 'id';
      $sort = $sortid;
      break;
   case "name":
      $sortorder = 'sortname';
      $sort = $sortname;
      break;
   case "major_minor_revision":
      $sortorder = 'sortver';
      $sort = $sortver;
      break;
   case "filename" :
      $sortorder = 'sortfilename';
      $sort = $sortfilename;
      break;
   case "f_size" :
      $sortorder = 'sortsize';
      $sort = $sortsize;
      break;
   case "creatorid" :
      $sortorder = 'sortposted';
      $sort = $sortposted;
      break;
   case "smodified" :
      $sortorder = 'sortmod';
      $sort = $sortmod;
      break;
   case "checked_out":
      $sortorder = 'sortcheckedout';
      $sort = $sortcheckedout;
      break;
   default:
      $order= "name";
      $sortorder= "sortname";
      $sort = "ASC";
      break;
}
// Next and Previous Page Handlers


if ($next == 1) 
{
      $iCurrentPage++;
      $nextfiles = $nextfiles + $default->records_per_page;
      $nextfolders = $nextfolders + $default->records_per_page;
}
if ($prev == 1)
{
      $iCurrentPage--;
      $nextfiles = $nextfiles - $default->records_per_page;
      if ($nextfiles < 0)
      {
         $nextfiles = 0;
      }
      $nextfolders = $nextfolders - $default->records_per_page;
      if ($nextfolders < 0)
      {
         $nextfolders = 0;
      }
}

// V4B RNG Start
   $urlArgs = array();
   $urlArgs['sess']      = $sess;
   $urlArgs['parent']    = $parent;
   $urlArgs['expand']    = $expand;
   $urlArgs['order']     = $order;
   $urlArgs[${sortorder}]  = $sort;
// V4B RNG End

if (check_auth($parent, "folder_view", $userid, false, false) != "1" and !$bDownloadAllowed)
{
   $sql->query("select password from " . $default->owl_folders_table . " where id='$parent'");
   $sql->next_record();

   $password = $sql->f("password");

   if (empty($password) or (!empty($password) and $bPasswordFailed))
   {
      printError($owl_lang->err_nofolderaccess);
   }
   else
   {
      if (file_exists("./lib/header.inc"))
      {
         include_once("./lib/header.inc");
         include_once("./lib/userheader.inc");
      }
      else
      {
         include_once("../lib/header.inc");
         include_once("../lib/userheader.inc");
      }
      if ($expand == 1)
      {
         print("<table class=\"border1\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"$default->table_expand_width\"><tr><td align=\"center\" valign=\"top\" width=\"100%\">\n");
      }
      else
      {
         print("<table class=\"border1\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"$default->table_collapse_width\"><tr><td align=\"center\" valign=\"top\" width=\"100%\">\n");
      }

      fPrintButtonSpace(12, 1);
      print("<table class=\"border2\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\"><tr><td align=\"left\" valign=\"top\" width=\"100%\">\n");

      if ($default->show_prefs == 1 or $default->show_prefs == 3)
      {
         fPrintPrefs("infobar1", "top");
      }

      fPrintButtonSpace(12, 1);
      print("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");

      print("<form action=\"browse.php\" method=\"post\">\n");
      print fGetHiddenFields ($urlArgs);
      fPrintFormTextLine($owl_lang->password , "docpassword", "", "", "", false, "password"); 
      print("<tr>\n");
      print("<td class=\"form1\">");
      fPrintButtonSpace(1, 1);
      print("</td>\n");
      print("<td class=\"form2\" width=\"100%\">");
      fPrintSubmitButton($owl_lang->btn_submit, $owl_lang->btn_submit, "submit");
      fPrintSubmitButton($owl_lang->btn_reset, $owl_lang->alt_reset_form, "reset");
      print("</td>\n");
      print("</tr>\n");
      print("</form>\n");
      print("</table>\n");
      fPrintButtonSpace(12, 1);
      
      if ($default->show_prefs == 2 or $default->show_prefs == 3)
      {
         fPrintPrefs("infobar2");
      }
      print("</td></tr></table>\n");
      include("./lib/footer.inc");

   }
   exit;
}


// Tiian changes 2003-07-31
$sql_bro = new Owl_DB;
$sql_bro->query("SELECT id FROM $default->owl_folders_table WHERE id = '$parent' AND name = 'backup'");

if ($sql_bro->num_rows() > 0)
{
    $is_backup_folder = true; 
}
else
{
    $is_backup_folder = false;
}

// **************************************
// Get File statistics for the status bar
// and for controling Pages
// **************************************

$lastlogin =  fGetLastLogin();

if ($default->show_file_stats == 1)
{
   fGetStatusBarCount();
}

$iFileCount = $iFolderCount + $iFileCount;
   
$whereclause = "";
$DBFolderCount = 0;

$sql = new Owl_DB;

if ($default->hide_backup == 1 and !fIsAdmin())
{
   $sql->query("SELECT * from $default->owl_folders_table where parent = '$parent' AND name = 'backup'");
   if ($sql->num_rows() > 0)
   {
      $DBFolderCount++; //count number of filez in db 2 use with array
      $DBFolders[$DBFolderCount] = 'backup'; //create list if files in
   } 

   $whereclause = " AND name <> 'backup'";
} 

if (isset($page))
{
   $iCurrentPage = $page;
   $nextfolders = ($default->records_per_page * $page);
   $nextfiles = 0;
}

if ($default->records_per_page > 0)
{
   $sLimit = "LIMIT $nextfolders,$default->records_per_page";
   $sql->query("SELECT * from $default->owl_folders_table where parent = '$parent' $whereclause order by name $sLimit");
   $iNumberFoldersDisplayed = $sql->num_rows();
   $iSaveNextfolders = $nextfolders;
   $iSaveNextfiles = $nextfiles  - $iNumberFoldersDisplayed;
   $iSaveDisplayFiles = $bDisplayFiles;
   $iSaveFileCount = $iFileCount;
   $iSaveCurrentPage = $iCurrentPage;
   
   if ($iNumberFoldersDisplayed < $default->records_per_page)
   {
      $bDisplayFiles = true;
      if (isset($page))
      {
         $iNumberOfPages = (int) (($iFolderCount / $default->records_per_page));
         //$iNumberOfPages = ($iNumberOfPages == 0) ? 1 :((int) round($iNumberOfPages + 0.4999));
         $iNumberOfPages = ($iNumberOfPages == 0) ? 1 :((int) round($iNumberOfPages + 0.51111));
         
         $iPageLeft = $page - $iNumberOfPages;
         
         if ($iFolderCount == 0 );
         {
            if($iPageLeft < 0)
            {
              $iPageLeft = 0;
            } 
            else
            {
              $iPageLeft++;
            } 
         }

         $iCorrection = 0;

         if($iFolderCount <> 0)
         {
           $iCorrection = $iFolderCount % $default->records_per_page;
         }

         if ($nextfiles == 0 and $iNumberFoldersDisplayed > 0)
         {
            $nextfiles = 0;
         }
         else
         {
            $nextfiles = ($default->records_per_page * $iPageLeft) - $iNumberFoldersDisplayed - $iCorrection ;
         }

         if ($nextfiles < 0)
         {
            $nextfiles = $nextfiles + $default->records_per_page;
         }
      }
   }
   else
   {
      $bDisplayFiles = false;
   }

   if ($iNumFilesPerPage != $default->records_per_page)
   {
      $inextfiles = $nextfiles - $iNumberFoldersDisplayed;
   }
}


// *********************************
// Display the Header Tool Bar BEGIN
// *********************************

print("<center>");

if ($default->owl_version_control == 1 && ! $default->owl_use_fs)
{           
   $FileQuery = "select f1.*, f1.major_revision+(f1.minor_revision/1000.0) as mval from $default->owl_files_table f1, $default->owl_files_table f2 where f1.name=f2.name AND f1.parent=f2.parent AND f1.parent=$parent group by f1.id having f1.major_revision+(f1.minor_revision/1000.0) = max(f2.major_revision+(f2.minor_revision/1000.0)) order by f1.$order $sort";
   $MenuFileQuery = "select f1.*, f1.major_revision+(f1.minor_revision/1000.0) as mval from $default->owl_files_table f1, $default->owl_files_table f2 where f1.name=f2.name AND f1.parent=f2.parent AND f1.parent=$parent group by f1.id having f1.major_revision+(f1.minor_revision/1000.0) = max(f2.major_revision+(f2.minor_revision/1000.0)) and approved = '1' order by f1.$order $sort";
}           
else        
{
   if ($order == "major_minor_revision")
   {
      $order_clause = "major_revision $sort, minor_revision $sort";
   }
   else
   {
      $order_clause = "$order $sort";
   }

   $sLimit = "";

   if ($default->records_per_page > 0)
   {
      $iNumFilesPerPage = $default->records_per_page - $iNumberFoldersDisplayed;
      $sLimit = "LIMIT $nextfiles,$iNumFilesPerPage";
   }

   // Query TO retreive the Files in the current Folder
   $FileQuery = "select * from $default->owl_files_table where parent = '$parent' order by $order_clause $sLimit";
   $MenuFileQuery = "select * from $default->owl_files_table where parent = '$parent' and approved = '1' order by $order_clause $sLimit";
}


$CountLines = 0;
$sLimit = '';
if ($default->records_per_page > 0)
{
   $sLimit = "LIMIT $nextfolders,$default->records_per_page";
}


if ($order == "creatorid")
{
   $FolderQuery = "SELECT * from $default->owl_folders_table where parent = '$parent' $whereclause order by creatorid $sortname $sLimit";
}
else
{
   $FolderQuery = "SELECT * from $default->owl_folders_table where parent = '$parent' $whereclause order by name $sortname $sLimit";
}



if(!$default->old_action_icons)
{
   $mid = new LayersMenu();
   $mid->setDirroot($default->owl_fs_root . "/scripts/phplayersmenu/");
   $mid->setImgwww($default->owl_root_url . '/scripts/phplayersmenu/menuimages/');

   if (substr(php_uname(), 0, 7) != "Windows")
   {
      $mid->setIcondir($default->owl_fs_root . "/graphics/$default->sButtonStyle/icon_action/");
   }
   else
   {
      $mid->setIcondir(ereg_replace("([A-Z]\:|[a-z]\:)", "", ereg_replace("[\\]", "/",$default->owl_fs_root)) . "/graphics/$default->sButtonStyle/icon_action/");
   }
   $mid->setIconwww($default->owl_graphics_url . "/$default->sButtonStyle/icon_action/");
   $mid->setIconsize(17, 20);
 
   fSetupFileActionMenus($MenuFileQuery);
   fSetupFolderActionMenus($FolderQuery);

   $mid->printHeader();

}


//FOR_FOLDERS

if ($expand == 1)
{
   print("<table class=\"border1\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"$default->table_expand_width\"><tr><td align=\"center\" valign=\"top\" width=\"100%\">\n");
}
else
{
   print("<table class=\"border1\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"$default->table_collapse_width\"><tr><td align=\"center\" valign=\"top\" width=\"100%\">\n");
}

fPrintButtonSpace(4, 1);
                                                                                                                                                                                       
print("<table class=\"border2\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\"><tr><td align=\"left\" valign=\"top\" width=\"100%\">\n");

if ($default->show_prefs == 1 or $default->show_prefs == 3)
{
   fPrintPrefs("infobar1", "top");
}

// *******************************
// Display the Header Tool Bar END
// *******************************

if ($default->show_file_stats == 1)
{
   fPrintPanel();
}
else
{
   fPrintButtonSpace(12, 1);
}

if ($default->show_search == 1 or $default->show_search == 3 or (fIsAdmin() and $default->show_search == 0))
{
   fPrintSearch();
   fPrintSpacer();
}
if (check_auth($parent, "folder_modify", $userid, false, false) == 1 or  check_auth($parent, "folder_upload", $userid, false, false) == 1  && !$is_backup_folder)
{
   if ($sess != "0" || ($sess == "0" && $default->anon_ro == 0))
   {
      if ($default->show_bulk > 0 or (fIsAdmin() and $default->show_bulk == 0 ))
      {     
            fPrintBulkButtons();
      }
      if ($default->show_action == 1 or $default->show_action == 3 or (fIsAdmin() and $default->show_action == 0))
      {
         fPrintActionButtons();
      }
   }
}

if ($default->show_folder_tools == 1 or $default->show_folder_tools == 3)
{
   fPrintFolderTools($nextfolders, $inextfiles, $bDisplayFiles, $iFileCount, $iCurrentPage);
}

fPrintNavBar($parent);

   print("<table class=\"margin2\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n<tr>\n<td align=\"left\" valign=\"top\">\n");
   print("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");

   if ($default->show_bulk > 0 or (fIsAdmin() and $default->show_bulk == 0 ))
   {
      if ($sess != "0" || ( $sess == "0" && $default->anon_ro == 0 ))
      {
         print("<tr>\n<td class=\"title1\">");
         fPrintButtonSpace(1,4);
         print("<a href=\"#\" onclick=\"CheckAll();\">");
         print("<img src=\"$default->owl_graphics_url/$default->sButtonStyle/ui_icons/tg_check.gif\" alt=\"$owl_lang->alt_toggle_check_box\" title=\"$owl_lang->alt_toggle_check_box\" border=\"0\"></img></a>");
   print("</td>\n");
      }
   }
   if (($default->expand_disp_status and $expand == 1) or ($default->collapse_disp_status and $expand == 0))
   {
      print("<td class=\"title1\">&nbsp;</td>\n"); 
   }

   if (($default->expand_disp_doc_num and $expand == 1) or ($default->collapse_disp_doc_num and $expand == 0))
   {
      show_link("id", "sortid", $sortid, $order, $sess, $expand, $parent, $owl_lang->doc_number);
   }

   if (($default->expand_disp_doc_type and $expand == 1) or ($default->collapse_disp_doc_type and $expand == 0))
   {
      print("<td class=\"title1\">&nbsp;</td>\n"); 
   }
   if (($default->expand_disp_title and $expand == 1) or ($default->collapse_disp_title and $expand == 0))
   {
      show_link("name", "sortname", $sortname, $order, $sess, $expand, $parent, $owl_lang->title);
   }
   if ($default->owl_version_control == 1)
   {
      if (($default->expand_disp_version and $expand == 1) or ($default->collapse_disp_version and $expand == 0))
      {
         show_link("major_minor_revision", "sortver", $sortver, $order, $sess, $expand, $parent, $owl_lang->ver);
      }
   } 
   if (($default->expand_disp_file and $expand == 1) or ($default->collapse_disp_file and $expand == 0))
   {
      show_link("filename", "sortfilename", $sortfilename, $order, $sess, $expand, $parent, $owl_lang->file);
   }
   if (($default->expand_disp_size and $expand == 1) or ($default->collapse_disp_size and $expand == 0))
   {
      show_link("f_size", "sortsize", $sortsize, $order, $sess, $expand, $parent, $owl_lang->size);
   }
   if (($default->expand_disp_posted and $expand == 1) or ($default->collapse_disp_posted and $expand == 0))
   {
      show_link("creatorid", "sortposted", $sortposted, $order, $sess, $expand, $parent, $owl_lang->postedby);
   }
   if (($default->expand_disp_modified and $expand == 1) or ($default->collapse_disp_modified and $expand == 0))
   {
      show_link("smodified", "sortmod", $sortmod, $order, $sess, $expand, $parent, $owl_lang->modified);
   }
   if ((($default->expand_disp_action and $expand == 1) or ($default->collapse_disp_action and $expand == 0)) and $default->old_action_icons)
   {
      print("<td class=\"title1\">$owl_lang->actions</td>\n"); 
   }
   if ($default->owl_version_control == 1)
   {  
      if (($default->expand_disp_held and $expand == 1) or ($default->collapse_disp_held and $expand == 0))
      {
         show_link("checked_out", "sortcheckedout", $sortcheckedout, $order, $sess, $expand, $parent, $owl_lang->held);
      }
   } 
   print("</tr>\n");

// Looping out Folders

   if ($default->owl_LookAtHD != "false")
   {
      $sql->query("SELECT * from $default->owl_folders_table where parent = '$parent' $whereclause");
      while ($sql->next_record())
      {
         $DBFolderCount++; //count number of filez in db 2 use with array
         $DBFolders[$DBFolderCount] = $sql->f("name"); //create list if files in
      }
   }

$sql->query($FolderQuery);
// **********************
// BEGIN Print Folders
// **********************

while ($sql->next_record())
{
   if ($default->restrict_view == 1)
   {
      if (!check_auth($sql->f("id"), "folder_view", $userid, false, false))
      {
         if ($default->records_per_page == 0) 
         {
            $DBFolderCount++; //count number of filez in db 2 use with array
            $DBFolders[$DBFolderCount] = $sql->f("name"); //create list if files in
         }
         continue;
      } 
   } 
   
   // *******************************************
   // Find out how many items (Folders and Files)
   // *******************************************
   if(!$default->hide_folder_doc_count)
   {
      $GetItems = new Owl_DB;

      $iFolderCount = 0;
      $iParent = $sql->f("parent");
      $GetItems->query("SELECT id from $default->owl_folders_table where parent = '" . $sql->f("id") . "'" . $whereclause);
   
      if ($default->restrict_view == 1)
      {
         while ($GetItems->next_record())
         {
            $bFileDownload = check_auth($GetItems->f("id"), "folder_view", $userid, false, false);
            if ($bFileDownload)
            {
               $iFolderCount++;
            }
        }
      }
      else
      {
         $iFolderCount = $GetItems->num_rows();
      }
   
      $iFileCount = fCountFileType ($sql->f("id"), '0');
      $iUrlCount = fCountFileType ($sql->f("id"), '1');
      $iNoteCount = fCountFileType ($sql->f("id"), '2');
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
   if ($default->show_bulk > 0 or (fIsAdmin() and $default->show_bulk == 0 ))
   {
      if ($sess != "0" || ($sess == "0" && $default->anon_ro == 0))
      {
         print("<td class=\"$sTrClass\">");
         print("<input type=\"checkbox\" name=\"fbatch[]\" value=\"" . $sql->f("id") . "\"></input>");
         print("</td>");
      } 
   } 

   if(($default->expand_disp_status and $expand == 1) or ($default->collapse_disp_status and $expand == 0))
   {
      print("<td class=\"$sTrClass\">&nbsp;<br /></td>");
   }
   if(($default->expand_disp_doc_num and $expand == 1) or ($default->collapse_disp_doc_num and $expand == 0))
   {
      print("<td class=\"$sTrClass\">&nbsp;<br /></td>");
   }
   if(($default->expand_disp_doc_type and $expand == 1) or ($default->collapse_disp_doc_type and $expand == 0))
   {
      print("<td class=\"$sTrClass\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_filetype/folder_closed.gif\" border=\"0\" alt=\"\"></img><br /></td>");
   }

   if(($default->expand_disp_title and $expand == 1) or ($default->collapse_disp_title and $expand == 0))
   {
      print("<td class=\"$sTrClass\">");
      //$sPopupDescription = ereg_replace("\n", '<br />', trim($sql->f("description")));
      $sPopupDescription = nl2br(trim($sql->f("description")));
   
      $urlArgs2 = $urlArgs;
      $urlArgs2['parent'] = $sql->f("id");
      $url = fGetURL ('browse.php', $urlArgs2);
   
      print("\n<a class=\"$sLfList\" href=\"$url\" title=\"$owl_lang->title_browse_folder\">" . $sql->f("name") . "</a>");
   
      if(!$default->hide_folder_doc_count)
      {
         if ($iFolderCount > 0 or $iFileCount > 0 or $iUrlCount  > 0 or $iNoteCount > 0)
         {
            print("&nbsp;(");
         } 
         if ($iFolderCount > 0 )
         {
            print("<a href=\"#\" class=\"cfolders1\" title=\"$owl_lang->folder_count_pre $iFolderCount $owl_lang->folder_count_folder\">$iFolderCount</a>");
         }
         if ($iFileCount > 0 )
         {
            if ($iFolderCount > 0)
            {
               print(":");
            }
            print("<a href=\"#\" class=\"cfiles1\" title=\"$owl_lang->folder_count_pre $iFileCount $owl_lang->folder_count_file\">$iFileCount</a>");
         }
         if ($iUrlCount  > 0 )
         {
            if ($iFileCount > 0)
            {
               print(":");
            }
            print("<a href=\"#\" class=\"curl1\" title=\"$owl_lang->folder_count_pre $iUrlCount $owl_lang->folder_count_url\">$iUrlCount</a>");
         }
         if ($iNoteCount > 0)
         {
            print(":<a href=\"#\" class=\"cnotes1\" title=\"$owl_lang->folder_count_pre $iNoteCount $owl_lang->folder_count_note\">$iNoteCount</a>");
            //print(":<a class='cnotes1'>$iNoteCount</a></b>");
         }
         if ($iFolderCount > 0 or $iFileCount > 0 or $iUrlCount  > 0 or $iNoteCount > 0)
         {
            print(")");
         }
      }
   
      if (trim($sql->f("description")))
      {
         print("<br></br><img src=\"$default->owl_graphics_url/$default->sButtonStyle/ui_misc/transparent.gif\" border=\"0\"><a class=\"desc\">" . str_replace("\n", "<br /><img src=$default->owl_graphics_url/$default->sButtonStyle/ui_misc/transparent.gif border=\"0\"></img>", $sql->f("description")) . "</a>");
      }

      print("</td>\n");
   }

   if ($default->records_per_page == 0)
   {
      $DBFolderCount++; //count number of filez in db 2 use with array
      $DBFolders[$DBFolderCount] = $sql->f("name"); //create list if files in
      
   }


      if ($default->owl_version_control == 1)
      {
         if (($default->expand_disp_version and $expand == 1) or ($default->collapse_disp_version and $expand == 0))
         {
            print("\t\t\t\t<td class=\"$sTrClass\">&nbsp;</td>\n");
         }
         if (($default->expand_disp_file and $expand == 1) or ($default->collapse_disp_file and $expand == 0))
         {
            //print("\t\t\t\t<td class='$sTrClass'>&nbsp;</td>\n");
            print("\t\t\t\t<td class=\"$sTrClass\">");

            if(!$default->old_action_icons)
            {
               $mid->printMenu('vermenuf' .$sql->f("id"));
            }
            else
            {
               print("&nbsp;");
            }
            print("</td>\n");
         }
         if (($default->expand_disp_size and $expand == 1) or ($default->collapse_disp_size and $expand == 0))
         {
            if ($default->hide_folder_size)
            {
               print("\t\t\t\t<td class=\"$sTrClass\">&nbsp;</td>\n");
            }
            else
            {
               $FolderSize = fGetFolderSize($sql->f("id"));
               print("\t\t\t\t<td class=\"$sTrClass\">" . gen_filesize($FolderSize) . "</td>\n");
            }
         }
         if (($default->expand_disp_posted and $expand == 1) or ($default->collapse_disp_posted and $expand == 0))
         {
            print("<td class=\"$sTrClass\" align=\"left\"><a class=\"$sLfList\" href=\"prefs.php?owluser=" . $sql->f("creatorid") . "&amp;sess=$sess&amp;expand=$expand&amp;parent=$parent&amp;order=$order&amp;sortname=$sortname\">" . flid_to_creator($sql->f("id")) . "</a></td>\n");
         }
         if (($default->expand_disp_modified and $expand == 1) or ($default->collapse_disp_modified and $expand == 0))
         {
            print("<td class=\"$sTrClass\">" . date($owl_lang->localized_date_format, strtotime($sql->f("smodified"))) . "</td>\n");
         }
      } 
      else
      {
         if (($default->expand_disp_file and $expand == 1) or ($default->collapse_disp_file and $expand == 0))
         {
            print("\t\t\t\t<td class=\"$sTrClass\">&nbsp;</td>\n");
         }
         if (($default->expand_disp_size and $expand == 1) or ($default->collapse_disp_size and $expand == 0))
         {
            print("\t\t\t\t<td class=\"$sTrClass\">&nbsp;</td>\n");
         }
         if (($default->expand_disp_posted and $expand == 1) or ($default->collapse_disp_posted and $expand == 0))
         {
            print("<td class=\"$sTrClass\" align=\"left\">" . flid_to_creator($sql->f("id")) . "</td>\n");
         }
         if (($default->expand_disp_modified and $expand == 1) or ($default->collapse_disp_modified and $expand == 0))
         {
            print("<td class=\"$sTrClass\">" . date($owl_lang->localized_date_format, strtotime($sql->f("smodified"))) . "</td>\n");
         }
      } 

      if ((($default->expand_disp_action and $expand == 1) or ($default->collapse_disp_action and $expand == 0)) and $default->old_action_icons)
      {
         print("<td class=\"$sTrClass\" align=\"left\">");

         // *****************************************
         // There is not Log Icon for folders so put A space
         // *****************************************
   
         if ($default->owl_version_control == 1)
         {
            fPrintButtonSpace(1,21);
         } 
         else
         {
            fPrintButtonSpace(1,2);
         }

         // *****************************************
         // Display the Delete Icons For the Folders
         // *****************************************
    
         if (check_auth($sql->f("id"), "folder_delete", $userid, false, false) == 1)
         {
            $urlArgs2 = $urlArgs;
            $urlArgs2['id'] = $sql->f("id");
            $urlArgs2['action'] = 'folder_delete';
            $url = fGetURL ('dbmodify.php', $urlArgs2);
   
            print("<a href=\"$url\" onclick=\"return confirm('$owl_lang->reallydelete " . htmlspecialchars($sql->f("name"), ENT_QUOTES) . "?');\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/trash.gif\" title=\"$owl_lang->alt_del_folder\" border=\"0\"></img></a>");
            fPrintButtonSpace(1,4);
         }
         else
         {
             fPrintButtonSpace(1,18);
         }

         // *****************************************
         // Display the Property Icons For the Folders
         // *****************************************
    
         if (check_auth($sql->f("id"), "folder_property", $userid, false, false) == 1)
         {
         	
            $urlArgs2 = $urlArgs;
            $urlArgs2['id'] = $sql->f("id");
            $urlArgs2['action'] = 'folder_modify';
            $url = fGetURL ('modify.php', $urlArgs2);
   
            print("<a href=\"$url\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/edit.gif\" border=\"0\" alt=\"$owl_lang->alt_mod_folder\" title=\"$owl_lang->alt_mod_folder\"></img></a>");
            fPrintButtonSpace(1,4);
         }
         else
         {
             fPrintButtonSpace(1,21);
         }
   
         fPrintButtonSpace(1,21);
         // *****************************************
         // Display the move Icons For the Folders
         // *****************************************
 
         if (check_auth($sql->f("id"), "folder_modify", $userid, false, false) == 1 and check_auth($sql->f("id"), "folder_delete", $userid, false, false) == 1)
         {
             $urlArgs2 = $urlArgs;
             $urlArgs2['id'] = $sql->f("id");
             $urlArgs2['action'] = 'cp_folder';
             $urlArgs2['parent'] = $parent;
             $url = fGetURL ('move.php', $urlArgs2);
   
             print("<a href=\"$url\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/copy.gif\" border=\"0\" alt=\"$owl_lang->alt_copy_folder\" title=\"$owl_lang->alt_copy_folder\"></img></a>");
   
             fPrintButtonSpace(1,4);

             $urlArgs2 = $urlArgs;
             $urlArgs2['id'] = $sql->f("id");
             $urlArgs2['action'] = 'folder';
             $urlArgs2['parent'] = $parent;
             $url = fGetURL ('move.php', $urlArgs2);

             print("<a href=\"$url\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/move.gif\" border=\"0\" alt=\"$owl_lang->alt_move_folder\" title=\"$owl_lang->alt_move_folder\"></img></a>");

             fPrintButtonSpace(1,73);
         } 
         else
         {
             fPrintButtonSpace(1,106);
         }
   

         if (check_auth($sql->f("id"), "folder_view", $userid, false, false) == 1)
         {
            $folder_id = $sql->f("id");
            $checksql = new Owl_DB;
            $checksql->query("select * from $default->owl_monitored_folder_table where fid = '$folder_id' and userid = '$userid'");
            $checknumrows = $checksql->num_rows($checksql);
   
            $checksql->query("SELECT * from $default->owl_users_table where id = '$userid'");
            $checksql->next_record();
            if ($default->owl_version_control == 1)
            {
               fPrintButtonSpace(1,18);
            } 
            if (trim($checksql->f("email")) != "")
            {
               if ($checknumrows == 0)
               {
                  $urlArgs2 = $urlArgs;
                  $urlArgs2['id'] = $folder_id;
                  $urlArgs2['parent'] = $parent;
                  $urlArgs2['action'] = 'folder_monitor';
                  $url = fGetURL ('dbmodify.php', $urlArgs2);
   
                  print("<a href=\"$url\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/monitor.gif\" border=\"0\" alt=\"$owl_lang->alt_monitor\" title=\"$owl_lang->alt_monitor\"></img></a>");
               } 
               else
               {
                  $urlArgs2 = $urlArgs;
                  $urlArgs2['id'] = $folder_id;
                  $urlArgs2['parent'] = $parent;
                  $urlArgs2['action'] = 'folder_monitor';
                  $url = fGetURL ('dbmodify.php', $urlArgs2);
   
                  print("<a href=\"$url\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/monitored.gif\" border=\"0\" alt=\"$owl_lang->alt_monitored\" title=\"$owl_lang->alt_monitored\"></img></a>");
               } 
               fPrintButtonSpace(1,40);
            } 
            else
            {
               fPrintButtonSpace(1,39);
            }
         } 

         if (check_auth($sql->f("id"), "folder_view", $userid, false, false) == 1)
         {
            $urlArgs2 = array();
            $urlArgs2['sess']   = $sess;
            $urlArgs2['id']     = $sql->f("id");
            $urlArgs2['parent'] = $sql->f("parent");
            $urlArgs2['action'] = 'folder';
            $urlArgs2['binary'] = 1;
            $urlArgs2['expand']    = $expand;
            $urlArgs2['order']     = $order;
            $urlArgs2['sortorder'] = $sort;
            $url = fGetURL ('download.php', $urlArgs2);
   
            if (file_exists($default->tar_path) && trim($default->tar_path) != "" && file_exists($default->gzip_path) && trim($default->gzip_path) != "")
            {
               print("<a href=\"$url\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_filetype/zip.gif\" border=\"0\" alt=\"$owl_lang->alt_get_folder\" title=\"$owl_lang->alt_get_folder\"></img></a>");
               fPrintButtonSpace(1,1);
            }
            else
            {
               fPrintButtonSpace(1,17);
            }
         } 

         print("</td>\n");
      }

      if ($default->owl_version_control == 1)
      {
         if (($default->expand_disp_held and $expand == 1) or ($default->collapse_disp_held and $expand == 0))
         {
            print ("<td class=\"$sTrClass\">&nbsp;</td>\n");
         }
      }
      print("</tr>\n");
} 

if ($default->owl_LookAtHD != "false")
{
   $DBFolders[$DBFolderCount + 1] = "[END]"; //end DBfolder array
   $RefreshPage = CompareDBnHD('folder', $default->owl_FileDir . "/" . get_dirpath($parent), $DBFolders, $parent, $default->owl_folders_table);
} 

//$midf->printFooter();
//*************************************
// BEGIN Print Files
//*************************************
// 

$DBFileCount = 0;

$sql = new Owl_DB;

//if ($default->owl_version_control == 1 && ! $default->owl_use_fs)
//{
   //$sql->query("select f1.*, f1.major_revision+(f1.minor_revision/1000.0) as mval from $default->owl_files_table f1, $default->owl_files_table f2 where f1.name=f2.name AND f1.parent=f2.parent AND f1.parent=$parent group by f1.id having f1.major_revision+(f1.minor_revision/1000.0) = max(f2.major_revision+(f2.minor_revision/1000.0)) order by f1.$order $sort");
//} 
//else
//{
   //if ($order == "major_minor_revision")
   //{
      //$order_clause = "major_revision $sort, minor_revision $sort";
   //}
   //else
   //{
      //$order_clause = "$order $sort";
   //}
//
   //$sLimit = "";

   if ($default->records_per_page > 0)
   {
      //$iNumFilesPerPage = $default->records_per_page - $iNumberFoldersDisplayed;
      //$sLimit = "LIMIT $nextfiles,$iNumFilesPerPage";

      $sql->query("select * from $default->owl_files_table where parent = '$parent'");
      while ($sql->next_record())
      {
         $DBFileCount++; //count number of filez in db 2 use with array
         $DBFiles[$DBFileCount] = $sql->f("filename"); //create list if files in
      }
   }

$sql->query($FileQuery);

while ($sql->next_record())
{
   $bPrintNew = false;
   $bPrintUpdated = false;
   $bFileDownload = check_auth($sql->f("id"), "file_download", $userid, false, false);
   if ($default->restrict_view == 1)
   {
      if (!$bFileDownload)
      {
         if ($default->records_per_page == 0)
         {
            $DBFileCount++; //count number of filez in db 2 use with array
            $DBFiles[$DBFileCount] = $sql->f("filename"); //create list if files in
         }
         continue;
      } 
   } 

   if ($sql->f("approved") == 0)
   {
      $DBFileCount++; //count number of filez in db 2 use with array
      $DBFiles[$DBFileCount] = $sql->f("filename"); //create list if files in
      continue;
   } 

   // 
   // Find New files
   // 
   
   if ($bFileDownload == 1)
   {
      if ($sql->f("created") > $lastlogin)
      {
         $bPrintNew = true;
      } 
      if ($sql->f("smodified") > $lastlogin && $sql->f("created") < $lastlogin)
      {
         $bPrintUpdated = true;
      } 
   } 

   // ******************************************
   // Check to see if this file as any comments
   // ******************************************

   $bHasComments = true;
   $bPrintNewComment = false;

   $CheckComments = new Owl_DB;

   $CheckComments->query("SELECT * from $default->owl_comment_table where fid = '" . $sql->f("id") . "' order by comment_date desc");

   $iTotalComments = $CheckComments->num_rows();

   $CheckComments->next_record();

   if ($CheckComments->f("comment_date") > $lastlogin)
   {
      $bPrintNewComment = true;
   }


   if ($iTotalComments == 0)
   {
      $bHasComments = false;
   } 

   // ******************************************
   // Check to see if this file is Word Indexed 
   // ******************************************

   $CheckComments->query("SELECT * from $default->owl_searchidx where owlfileid = '" . $sql->f("id") . "' limit 1");

   if ($CheckComments->num_rows() == 1)
   {
      $bWasIndexed = true;
   }
   else
   {
      $bWasIndexed = false;
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
      print("\t\t\t\t<tr>");

   if ($default->show_bulk > 0 or (fIsAdmin() and $default->show_bulk == 0 ))
   {
      if ($sess != "0" || ($sess == "0" && $default->anon_ro == 0))
      {
         print("<td class=\"$sTrClass\">");
         print("<input type=\"checkbox\" name=\"batch[]\" value=\"" . $sql->f("id") . "\"></input>");
         print("</td>");
      } 
   } 
   
   if(($default->expand_disp_status and $expand == 1) or ($default->collapse_disp_status and $expand == 0))
   {
      print("<td class=\"$sTrClass\" align=\"left\">");
      if ($bHasComments)
      {
         if ($bPrintNewComment)
         {
            $iImage = "newcomment";
         }
         else
         {
            $iImage = "comment";
         }
         
         $urlArgs2 = $urlArgs;
         $urlArgs2['id']     = $sql->f("id");
         $urlArgs2['parent'] = $parent;
         $urlArgs2['action'] = 'file_comment';
         $url = fGetURL ('modify.php', $urlArgs2);
   
         print("<a class=\"$sLfList\" href=\"$url\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/$iImage.gif\" border=\"0\" alt=\"$iTotalComments --- $owl_lang->alt_comments\" title=\"$iTotalComments --- $owl_lang->alt_comments\"></img></a>");
      } 
      if ($default->anon_user <> $userid)
      {
         if ($bPrintNew)
         {
            print("<img src=\"$default->owl_graphics_url/$default->sButtonStyle/ui_icons/new.gif\" border=\"0\" alt=\"\"></img>");
         } 
         if ($bPrintUpdated)
         {
            print("<img src=\"$default->owl_graphics_url/$default->sButtonStyle/ui_icons/updated.gif\" border=\"0\" alt=\"\"></img>");
         } 
         if ($bWasIndexed)
         {
            print("&nbsp;<a class=\"curl1\">*</a>");
         }
      } 
   
      print("<br></br></td>");
   }

   if (($default->expand_disp_doc_num and $expand == 1) or ($default->collapse_disp_doc_num and $expand == 0))
   {
      $sZeroFilledId = str_pad($sql->f("id"),$default->doc_id_num_digits, "0", STR_PAD_LEFT);
      print("<td class=\"$sTrClass\" align=\"left\">");
      if ($fileid == $sql->f("id"))
      {
         print("<b class=\"hilite\">" . $default->doc_id_prefix . $sZeroFilledId . "</b>");
      }
      else
      {
         print $default->doc_id_prefix . $sZeroFilledId;
      } 
      print("</td>");

   }
   if (($default->expand_disp_doc_type and $expand == 1) or ($default->collapse_disp_doc_type and $expand == 0))
   {
      print("<td class=\"$sTrClass\" align=\"left\">");
      $choped = split("\.", $sql->f("filename"));
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
   
      if ($sql->f("url") == "1")
      {
         print("<img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_filetype/url.gif\" border=\"0\" alt=\"\"></img>");
      }
      else
      {
         if (!file_exists("$default->owl_fs_root/graphics/$default->sButtonStyle/icon_filetype/$sDispIcon.gif"))
         {
            $sDispIcon = "file";
         }
         print("<img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_filetype/$sDispIcon.gif\" border=\"0\" alt=\"\"></img>");
      } 

      print("<br></br></td>\n"); 
   }

   if (($default->expand_disp_title and $expand == 1) or ($default->collapse_disp_title and $expand == 0))
   {
      print("<td class=\"$sTrClass\" align=\"left\">");

      $sPopupDescription = fCleanDomTTContent($sql->f("description"));

      if (trim($sPopupDescription) == "") 
      {
         $sPopupDescription = $owl_lang->no_description;
      }
      $urlArgs2 = $urlArgs;
      $urlArgs2['sess']   = $sess;
      $urlArgs2['id']     = $sql->f("id");
      $urlArgs2['parent'] = $parent;
      $urlArgs2['action'] = 'file_details';
      $url = fGetURL ('view.php', $urlArgs2);
   
      print("\n<a class=\"$sLfList\" href=\"$url\" onmouseover=" . '"' . "return makeTrue(domTT_activate(this, event, 'caption', '" . $owl_lang->description . "', 'content', '" . $sPopupDescription . "', 'lifetime', 3000, 'fade', 'both', 'delay', 10, 'statusText', ' ', 'trail', true));" . '"');
   
      print(">\n");
      print("\n");
   
      if ($fileid == $sql->f("id"))
      {
         print("<b class=\"hilite\">" . $sql->f("name") . "</b></a>");
      }
      else
      {
         print $sql->f("name") . "</a>";
      } 
      print("</td>\n");
   }

   if ($default->owl_version_control == 1)
   {
      if ($fileid == $sql->f("id"))
      {
         if (($default->expand_disp_version and $expand == 1) or ($default->collapse_disp_version and $expand == 0))
         {
            print("\n<td class=\"$sTrClass\" align=\"left\"><b class=\"hilite\">" . $sql->f("major_revision") . "." . $sql->f("minor_revision") . "</b></td>");
         }
      }
      else
      {
         if (($default->expand_disp_version and $expand == 1) or ($default->collapse_disp_version and $expand == 0))
         {
            print("\n<td class=\"$sTrClass\" align=\"left\">" . $sql->f("major_revision") . "." . $sql->f("minor_revision") . "</td>");
         }
      }
   } 

   if ($sql->f("url") == "1")
   {
      if ($fileid == $sql->f("id"))
      {
         if ($bFileDownload == 1)
         {
            if (($default->expand_disp_file and $expand == 1) or ($default->collapse_disp_file and $expand == 0))
            {
               print("\n<td class=\"$sTrClass\" align=\"left\"><a class=\"$sLfList\" href=\"" . $sql->f("filename") . "\" target=\"new\" title=\"$owl_lang->title_browse_site : " . $sql->f("filename") . "\"><b class=\"hilite\">" . $sql->f("filename") . " </b></a></td>\n");
            }
            if (($default->expand_disp_size and $expand == 1) or ($default->collapse_disp_size and $expand == 0))
            {
               print("<td class=\"$sTrClass\" align=\"right\"><b class=\"hilite\">&nbsp;</b></td>\n");
            }
         } 
         else
         {
            if (($default->expand_disp_file and $expand == 1) or ($default->collapse_disp_file and $expand == 0))
            {
               print("\n<td class=\"$sTrClass\" align=\"left\">" . $sql->f("filename") . "</td>\n");
            }
            if (($default->expand_disp_size and $expand == 1) or ($default->collapse_disp_size and $expand == 0))
            {
               print("<td class=\"$sTrClass\" align=\"right\"><b class=\"hilite\">&nbsp;</b></td>");
            }
         } 
      } 
      else
      {
         if ($bFileDownload == 1)
         {
            if (($default->expand_disp_file and $expand == 1) or ($default->collapse_disp_file and $expand == 0))
            {
               if($default->old_action_icons)
               {
               print("\n<td class=\"$sTrClass\" align=\"left\"><a class=\"$sLfList\" href=\"" . $sql->f("filename") . "\" target=\"new\" title=\"$owl_lang->title_browse_site : " . $sql->f("filename") . "\">" . $sql->f("filename") . "</a></td>\n");
                  print("</td>\n");
               }
               else
               {
                  print("\n<td class=\"$sTrClass\" align=\"left\">");
                  if(!$default->old_action_icons)
                  {
                     $mid->printMenu('vermenu'.$sql->f("id"));
                  }
                  else
                  {
                     print("&nbsp;");
                  }
                  print("</td>\n");
               }
            }
            if (($default->expand_disp_size and $expand == 1) or ($default->collapse_disp_size and $expand == 0))
            {
               print("<td class=\"$sTrClass\" align=\"right\">&nbsp;</td>\n");
            }
         } 
         else
         {
            if (($default->expand_disp_file and $expand == 1) or ($default->collapse_disp_file and $expand == 0))
            {
               print("\n<td class=\"$sTrClass\" align=\"left\">" . $sql->f("filename") . "</td>\n");
            }
            if (($default->expand_disp_size and $expand == 1) or ($default->collapse_disp_size and $expand == 0))
            {
               print("<td class=\"$sTrClass\" align=\"right\">&nbsp;</td>\n");
            }
         } 
      } 
   }
   else
   {
      $urlArgs2 = $urlArgs;
      $urlArgs2['id']     = $sql->f("id");
      $urlArgs2['parent'] = $sql->f("parent");
      $url = fGetURL ('download.php', $urlArgs2);

      if ($fileid == $sql->f("id"))
      {
         if (($default->expand_disp_file and $expand == 1) or ($default->collapse_disp_file and $expand == 0))
         {
            if(!$default->old_action_icons)
            {
               print("\n<td class=\"$sTrClass\" align=\"left\"><b class=\"hilite\">");
               $mid->printMenu('vermenu'.$sql->f("id"));
               print("</b></a>");
            }
            else
            {
               print("\n<td class=\"$sTrClass\"  align=\"left\"><a  class=\"$sLfList\" href=\"$url\" title=\"$owl_lang->title_download_view\"><b class=\"hilite\">" . $sql->f("filename") . "</b></a>");
            }
            print("</td>\n");
         }
         if (($default->expand_disp_size and $expand == 1) or ($default->collapse_disp_size and $expand == 0))
         {
            print("<td class=\"$sTrClass\" align=\"right\"><b class=\"hilite\">" . gen_filesize($sql->f("f_size")) . "</b></td>\n");
         }
      }
      else
      { 
         if (($default->expand_disp_file and $expand == 1) or ($default->collapse_disp_file and $expand == 0))
         {
            if($default->old_action_icons)
            {
               print("\n<td class=\"$sTrClass\" align=\"left\"><a class=\"$sLfList\" href=\"$url\" title=\"$owl_lang->title_download_view\">" . $sql->f("filename") . "</a>");
               print("</td>\n");
            }
            else
            {
               print("\n<td class=\"$sTrClass\" align=\"left\">");
            if(!$default->old_action_icons)
            {
               $mid->printMenu('vermenu'.$sql->f("id"));
            }
               print("</td>\n");
            }
         }
         if (($default->expand_disp_size and $expand == 1) or ($default->collapse_disp_size and $expand == 0))
         {
            print("<td class=\"$sTrClass\" align=\"right\">" . gen_filesize($sql->f("f_size")) . "</td>");
         }
      }

      if ($default->records_per_page == 0)
      {
         if ($sql->f("linkedto") == 0)
         {
            $DBFileCount++; //count number of filez in db 2 use with array
            $DBFiles[$DBFileCount] = $sql->f("filename"); //create list if files in
         }
      }
   }

      if ($fileid == $sql->f("id"))
      {
         if (($default->expand_disp_posted and $expand == 1) or ($default->collapse_disp_posted and $expand == 0))
         {
            print("\t\t\t\t<td class=\"$sTrClass\" align=\"left\"><b class=\"hilite\"><a class=\"$sLfList\" href=\"prefs.php?owluser=" . $sql->f("creatorid") . "&amp;sess=$sess&amp;expand=$expand&amp;parent=$parent&amp;order=$order&amp;sortname=$sortname\">" . fid_to_creator($sql->f("id")) . "</a></b></td>\n");
         }
         if (($default->expand_disp_modified and $expand == 1) or ($default->collapse_disp_modified and $expand == 0))
         {
            print("<td class=\"$sTrClass\" align=\"left\"><b class=\"hilite\">" . date($owl_lang->localized_date_format, strtotime($sql->f("smodified"))) . "</b></td>\n");
         }
      }
      else
      {
         if (($default->expand_disp_posted and $expand == 1) or ($default->collapse_disp_posted and $expand == 0))
         {
            print("\t\t\t\t<td class=\"$sTrClass\" align=\"left\"><a class=\"$sLfList\" href=\"prefs.php?owluser=" . $sql->f("creatorid") . "&amp;sess=$sess&amp;expand=$expand&amp;parent=$parent&amp;order=$order&amp;sortname=$sortname\">" . fid_to_creator($sql->f("id")) . "</a></td>\n");
         }
         if (($default->expand_disp_modified and $expand == 1) or ($default->collapse_disp_modified and $expand == 0))
         {
            print("<td class=\"$sTrClass\" align=\"left\">" . date($owl_lang->localized_date_format, strtotime($sql->f("smodified"))) . "</td>\n");
         }
      }
      if ((($default->expand_disp_action and $expand == 1) or ($default->collapse_disp_action and $expand == 0)) and $default->old_action_icons)
      {
         print("\t\t\t\t<td class=\"$sTrClass\" align=\"left\">");
         printFileIcons($sql->f("id"), $sql->f("filename"), $sql->f("checked_out"), $sql->f("url"), $default->owl_version_control, $ext, $parent, $is_backup_folder);
      }
   if ($default->owl_version_control == 1)
   {
      if (($default->expand_disp_held and $expand == 1) or ($default->collapse_disp_held and $expand == 0))
      {
         if (($holder = uid_to_name($sql->f("checked_out"))) == "Owl")
         {
            print("\t<td class=\"$sTrClass\" align=\"center\">-</td></tr>");
         } 
         else
         {
            print("\t<td class=\"$sTrClass\" align=\"left\"><a class=\"$sLfList\" href=\"prefs.php?owluser=" . $sql->f("checked_out") . "&amp;sess=$sess&amp;expand=$expand&amp;parent=$parent&amp;order=$order&amp;sortname=$sortname\">$holder</a></td></tr>");
         } 
      }
   } 
} 

   $DBFiles[$DBFileCount + 1] = "[END]"; //end DBfile array
   print("</table>");
   print("</td></tr></table>\n");

   if ($default->show_folder_tools == 2 or $default->show_folder_tools == 3)
   {
      fPrintFolderTools($iSaveNextfolders, $inextfiles, $iSaveDisplayFiles, $iSaveFileCount, $iSaveCurrentPage);
   }
      if (check_auth($parent, "folder_modify", $userid, false, false) == 1 or  check_auth($parent, "folder_upload", $userid, false, false) == 1  && !$is_backup_folder)
      {
         if ($sess != "0" || ($sess == "0" && $default->anon_ro == 0))
         {
            if ($default->show_action == 2 or $default->show_action == 3 )
            {
               fPrintActionButtons(1);
            }
            if ($default->show_bulk > 0)
            {
               fPrintBulkButtons(1);
            }
            else
            {
               print("</form>");
            }
         }
      }

   if ($default->show_search == 2 or $default->show_search == 3)
   {
      fPrintSpacer();
      fPrintSearch(1);
   }

   fPrintButtonSpace(12, 1);

   if ($default->show_prefs == 2 or $default->show_prefs == 3)
   {
      fPrintPrefs("infobar2");
   }
   print("</td></tr>");
   print("</table>");

   // *******************************
   // If the refresh from hard drive
   // feature is enabled
   // *******************************
   // 
   if ($default->owl_use_fs)
   {
      if ($default->owl_LookAtHD != "false")
      {
         //print_r($DBFiles);
         //exit;
         if ($RefreshPage == true)
         {
            CompareDBnHD('file', $default->owl_FileDir . "/" . get_dirpath($parent), $DBFiles, $parent, $default->owl_files_table);
         } 
         else
         {
            $RefreshPage = CompareDBnHD('file', $default->owl_FileDir . "/" . get_dirpath($parent), $DBFiles, $parent, $default->owl_files_table);
         } 
         if ($RefreshPage == true)
         {

   print('<script type="text/javascript">');
   print('window.location.reload(true);');
   print('</script>');
         } 
      } 
   } 
            if(!$default->old_action_icons)
            {
$mid->printFooter();
}
   include("./lib/footer.inc");
?>
