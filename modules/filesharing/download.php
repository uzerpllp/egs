<?php

/**
 * download.php
 * 
 *
 * Author: Steve Bourgeois <owl@bozzit.com>
 * Project Founder: Chris Vincent <cvincent@project802.net>
 *
 * Copyright (c) 1999-2005 The Owl Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 * 
 * $Id: download.php,v 1.8 2005/03/09 15:43:51 b0zz Exp $
 */
require_once("./config/owl.php");
require_once("./lib/disp.lib.php");
require_once("./lib/owl.lib.php");
require_once("./lib/security.lib.php");
require_once("lib/pclzip/pclzip.lib.php");

if ($sess == "0" && $default->anon_ro == 1)
{
   printError($owl_lang->err_login);
}

if ($action == "bulk_download")
{
   $filename = fid_to_name(1) . ".zip";
   $tmpDir = $default->owl_tmpdir . "/owltmp.$sess";
   if ($filetype = strrchr($filename, "."))
      {
         $filetype = substr($filetype, 1);
         $sql = new Owl_DB;
         $sql->query("SELECT * from $default->owl_mime_table WHERE filetype = '$filetype'");
         while ($sql->next_record()) $mimeType = $sql->f("mimetype");
      }

   $fspath = $tmpDir . "/" . $filename;
   $fsize = filesize($fspath);

   header("Content-Disposition: attachment; filename=\"$filename\"");
   header("Content-Location: $filename");
   header("Content-Type: $mimeType");
   header("Content-Length: $fsize");
   header("Expires: 0");

      if (substr(php_uname(), 0, 7) != "Windows")
      {
         $fp = fopen("$fspath", "r");
      }
      else
      {
         $fp = fopen("$fspath", "rb");
      }
      fpassthru($fp);
   
  myDelete($tmpDir);
  exit;
}


$id = fGetPhysicalFileId($id);

$CheckPass = new Owl_DB;
$CheckPass->query("SELECT password from " . $default->owl_files_table . " WHERE id='$id'");
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


function zip_folder($id, $userid)
{
   global $default, $sess, $owl_lang;

   $tmpdir = $default->owl_tmpdir . "/owltmpfld_$sess.$id";
   if (file_exists($tmpdir)) myDelete($tmpdir);

   mkdir("$tmpdir", $default->directory_mask);
   $sql = new Owl_DB;
   $sql2 = new Owl_DB;

   $sql->query("SELECT name, id from $default->owl_folders_table WHERE id = '$id'");
   while ($sql->next_record())
   {
      $top = $sql->f("name");
   } 
   $path = "$tmpdir/$top";
   mkdir("$path", $default->directory_mask);

   folder_loop($sql, $sql2, $id, $path, $userid); 

   if ($default->use_zip_for_folder_download)
   {
      $filename = $tmpdir . "/" . $top . ".zip";
      $archive = new PclZip($filename);
      $v_list = $archive->create($tmpdir . "/" . $top, PCLZIP_OPT_REMOVE_PATH, "$tmpdir");
      if ($v_list == 0) 
      {
         if ($default->debug == true)
         {
            printError("DEBUG : ".$archive->errorInfo(true));
         }
         else
         {
            printError("ERROR creating zip File");
         }
      }
     
      $fsize = filesize($filename);

      header("Content-Disposition: attachment; filename=\"$top.zip\"");
      header("Content-Location: $filename");
      header("Content-Type: application/zip");
      header("Content-Length: $fsize");
      header("Expires: 0");

      if (substr(php_uname(), 0, 7) != "Windows")
      {
         $fp = fopen("$filename", "r");
      }
      else
      {
         $fp = fopen("$filename", "rb");
      }
      fpassthru($fp);
   }
   else
   {
      // get all files in folder
      // GETTING IE TO WORK IS A PAIN!
      if (file_exists($default->tar_path))
      {
         if (file_exists($default->gzip_path))
         {
            if (strstr($_SERVER["HTTP_USER_AGENT"], "MSIE"))
               header("Content-Type: application/x-gzip");
            else
               header("Content-Type: application/octet-stream");

            if (substr(php_uname(), 0, 7) != "Windows")
            {
               header("Content-Disposition: attachment; filename=\"$top.tgz\"");
               header("Content-Location: \"$top.tgz\"");
               header("Expires: 0");
               passthru("$default->tar_path cf - -C " . escapeshellarg($tmpdir) . " " . escapeshellarg($top) . "| " . $default->gzip_path . " -c -9");
            } 
            else
            {
               header("Content-Location: \"$top.tar.gz\"");
               header("Content-Disposition: attachment; filename=\"$top.tar.gz\"");
               header("Expires: 0");
               system("$default->tar_path cf " . '"' . $tmpdir . "/" . $top . '.tar"' . " -C " . '"' . $tmpdir . '" "' . $top . '"');
               passthru($default->gzip_path . ' -c -9 "' . $tmpdir . "\\" . $top . '.tar"');
            } 
         } 
         else
         {
            if (substr(php_uname(), 0, 7) != "Windows")
            {
               if (strstr($_SERVER["HTTP_USER_AGENT"], "MSIE"))
               {
                  header("Content-Type: application/x-gzip");
               }
               else
               {
                  header("Content-Type: application/octet-stream");
               }
               header("Content-Disposition: attachment; filename=\"$top.tar\"");
               header("Content-Location: \"$top.tgz\"");
               header("Expires: 0");
               passthru("$default->tar_path cf - -C " . escapeshellarg($tmpdir) . " " . escapeshellarg($top));
            } 
            else
            {
               printError("$owl_lang->err_gzip_not_found $default->gzip_path");
            } 
         } 
      } 
      else
      {
         myDelete($tmpdir);
         printError("$owl_lang->err_tar_not_found $default->tar_path");
      } 
   }
   myDelete($tmpdir);
} 
   
function folder_loop($sql, $sql2, $id, $tmpdir, $userid)
{
   global $default;

   if (check_auth($id, "folder_view", $userid) == 1)
   {
      $sql = new Owl_DB; 
      // write out all the files
      $sql->query("SELECT * from $default->owl_files_table WHERE parent = '$id' and url <> '1'");
      while ($sql->next_record())
      {
         $fid = $sql->f("id");
         $filename = $tmpdir . "/" . $sql->f("filename");
         if (check_auth($fid, "file_download", $userid) == 1)
         {
            if ($default->owl_use_fs)
            {
               $source = $default->owl_FileDir . "/" . get_dirpath($id) . "/" . $sql->f("filename");
               copy($source, $filename);
            } 
            else
            {
               $sql2->query("SELECT data,compressed from " . $default->owl_files_data_table . " WHERE id='$fid'");
               while ($sql2->next_record())
               {
                  if ($sql2->f("compressed"))
                  {
                     $fp = fopen($filename . ".gz", "w");
                     fwrite($fp, $sql2->f("data"));
                     fclose($fp);
                     system($default->gzip_path . " -d " . escapeshellarg($filename) . ".gz");
                  } 
                  else
                  {
                     $fp = fopen($filename, "w");
                     fwrite($fp, $sql2->f("data"));
                     fclose($fp);
                  } // end if     
               } // end if     
            } // end while
         } // end if
      } // end while 
      // recurse into directories
      $sql->query("SELECT name, id from $default->owl_folders_table WHERE parent = '$id'");
      while ($sql->next_record())
      {
         $saved = $tmpdir;
         $tmpdir .= "/" . $sql->f("name");
         mkdir("$tmpdir", $default->directory_mask);
         folder_loop($sql, $sql2, $sql->f("id"), $tmpdir, $userid);
         $tmpdir = $saved;
      } 
   } 
} 

if ($action == "folder")
{
   $abort_status = ignore_user_abort(true);
   zip_folder($id, $userid);
   ignore_user_abort($abort_status);
   exit;
} 


if ((check_auth($id, "file_download", $userid) == 1) or $bDownloadAllowed or fCheckIfReviewer($id) )
{
   $filename = flid_to_filename($id);
   $mimeType = "application/octet-stream";

   if ($binary != 1)
   {
      if ($filetype = strrchr($filename, "."))
      {
         $filetype = substr($filetype, 1);
         $sql = new Owl_DB;
         $sql->query("SELECT * from $default->owl_mime_table WHERE filetype = '$filetype'");
         while ($sql->next_record()) $mimeType = $sql->f("mimetype");
      } 
   } 
   // BEGIN wes change
   if ($default->owl_use_fs)
   {
      $path = find_path(owlfileparent($id)) . "/" . $filename;
      $fspath = $default->owl_FileDir . "/" . $path;
      if (!file_exists($fspath))
      {
         if ($default->debug == true)
         {
            printError("$owl_lang->err_file_not_exist", $fspath);
         }
         else
         { 
            printError("$owl_lang->err_file_not_exist");
         }
      } 
      $fsize = filesize($fspath);
   } 
   else
   {
      $sql->query("SELECT f_size from " . $default->owl_files_table . " WHERE id='$id'");
      while ($sql->next_record()) $fsize = $sql->f("f_size");
   } 
   // END wes change
   // BEGIN BUG: 495556 File download sends incorrect headers
   // header("Content-Disposition: filename=\"$filename\"");
   header("Content-Disposition: attachment; filename=\"$filename\"");
   header("Content-Location: $filename");
   header("Content-Type: $mimeType");
   header("Content-Length: $fsize");
   header("Expires: 0"); 
   // END BUG: 495556 File download sends incorrect headers
   // BEGIN wes change
   if ($default->owl_use_fs)
   {
      if (substr(php_uname(), 0, 7) != "Windows")
      {
         $fp = fopen("$fspath", "r");
      }
      else
      {
         $fp = fopen("$fspath", "rb");
      }
      fpassthru($fp); 
      // print fread($fp,filesize("$fspath"));
      // fclose($fp);
   } 
   else
   {
      $sql->query("SELECT data,compressed from " . $default->owl_files_data_table . " WHERE id='$id'");
      while ($sql->next_record())
      {
         if ($sql->f("compressed"))
         {
            $tmpfile = $default->owl_tmpdir . "/" . "owltmp.$id";
            if (file_exists($tmpfile)) unlink($tmpfile);

            $fp = fopen($tmpfile, "w");
            fwrite($fp, $sql->f("data"));
            fclose($fp);
            flush(passthru($default->gzip_path . " -dfc $tmpfile"));
            unlink($tmpfile);
         } 
         else
         {
            print $sql->f("data");
            flush();
         } 
      } 
   } 
   // END wes change
   owl_syslog(FILE_DOWNLOADED, $userid, flid_to_filename($id), $parent, "", "FILE");
} 
else
{
   
   $sql->query("SELECT password from " . $default->owl_files_table . " WHERE id='$id'");
   $sql->next_record();

   $password = $sql->f("password");

   if (empty($password) or (!empty($password) and $bPasswordFailed))
   {
      printError($owl_lang->err_nofileaccess);
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
      if(empty($expand))
   {
      $expand = $default->expand;
   }
                                                                                                                                                                                  
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

      $urlArgs = array();
      $urlArgs['sess']      = $sess;
      $urlArgs['parent']    = $parent;
      $urlArgs['expand']    = $expand;
      $urlArgs['order']     = $order;
      $urlArgs['sort']  = $sortname;
      $urlArgs['sortorder']  = $sortorder;
      $urlArgs['id']  = $id;


      print("<table class='margin2' cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
      print("<tr><td class='browse0' width='100%' colspan='20'>$owl_lang->password</td></tr>\n");
      print("<tr>\n");
      print("<td align='left' valign='top'>\n");
      print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>\n");

                                                
      print("<form action='download.php' method='post'>\n");
      print fGetHiddenFields ($urlArgs);
      fPrintFormTextLine($owl_lang->password , "docpassword", "", "", "", false, "password");
      print("<tr>");
      print("<td class='form1'>");
      fPrintButtonSpace(1, 1);
      print("</td>");
      print("<td class='form2' width='100%'>");
      fPrintSubmitButton($owl_lang->btn_submit, $owl_lang->alt_submit, "submit", "submit");
      fPrintSubmitButton($owl_lang->btn_reset, $owl_lang->alt_reset_form, "reset");
      print("</td>");
      print("</tr>");
      print("</form>\n");
      print("</table>\n");
      print("</td></tr></table>\n");
      fPrintButtonSpace(12, 1);

      if ($default->show_prefs == 2 or $default->show_prefs == 3)
      {
         fPrintPrefs("infobar2");
      }
      print("</td></tr></table>\n");
      include("./lib/footer.inc");
   }
} 
// MAKE SURE THERE IS NOT BLANK LINE THE END OF THE FILE
// CUZ IT MESSES UP THE DOWNLOAD
?>
