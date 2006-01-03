<?php

/**
 * view.php
 * 
 * Copyright (c) 1999-2003 The Owl Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 * 
 * $Id: view.php,v 1.6 2005/03/02 01:50:21 b0zz Exp $
 */

require_once("./config/owl.php");
require_once("./lib/disp.lib.php");
require_once("./lib/owl.lib.php");
require_once("./lib/security.lib.php");
require_once("./phpid3v2/class.id3.php");

if ($sess == "0" && $default->anon_ro == 1)
{
   printError($owl_lang->err_login);
}

// BEGIN what Richard Bartz added to show PDF, DOC, and TXT special view
// While I was at it I added xls, mp3, and ppt.

if ($action == "pdf_show" || $action == "xls_show" || $action == "doc_show" || $action == "ppt_show" || $action == "mp3_play" or $action == "inline")
{
   if (check_auth($id, "file_download", $userid) == 1)
   {
      if ($default->owl_use_fs)
      {
         $fid = fGetPhysicalFileId($id);
         $path = $default->owl_FileDir . "/" . find_path(owlfileparent($fid)) . "/" . flid_to_filename($fid);
         //$path = $default->owl_FileDir . "/" . find_path($parent) . "/" . flid_to_filename($id);
      } 
      else
      {
         $uncomptmpfile = $default->owl_tmpdir . "/owltmp.$id.$sess";
         $getfile = new Owl_DB;
         $getfile->query("select data,compressed from $default->owl_files_data_table where id='$id'");
         while ($getfile->next_record())
         {
            if ($getfile->f("compressed"))
            {
               $tmpfile = $default->owl_tmpdir . "/owltmp.$id.$sess.gz";
               if ($default->debug)
               {
                  if (!file_exists($default->owl_tmpdir))
                  {
                     printError("$owl_lang->debug_tmp_not_exists");
                  } 
                  if (!is_writable($default->owl_tmpdir))
                  {
                     printError("$owl_lang->debug_tmp_not_writeable");
                  } 
               } 
               if (file_exists($tmpfile)) unlink($tmpfile);

               $fp = fopen($tmpfile, "wb");
               fwrite($fp, $getfile->f("data"));
               fclose($fp);

               system($default->gzip_path . " -df $tmpfile");

               $fsize = filesize($uncomptmpfile);
               $fd = fopen($uncomptmpfile, 'rb');
               $filedata = fread($fd, $fsize);
               fclose($fd);
            } 
            else
            {
               $tmpfile = $default->owl_tmpdir . "/owltmp.$id.$sess";
               if ($default->debug)
               {
                  if (!file_exists($default->owl_tmpdir))
                  {
                     printError("$owl_lang->debug_tmp_not_exists");
                  } 
                  if (!is_writable($default->owl_tmpdir))
                  {
                     printError("$owl_lang->debug_tmp_not_writeable");
                  } 
               } 
               if (file_exists($tmpfile)) unlink($tmpfile);

               $fp = fopen($tmpfile, "wb");
               fwrite($fp, $getfile->f("data"));
               fclose($fp);
            } 
         } 
         $path = $uncomptmpfile;
      } 
   } 
   else
   {
      printError($owl_lang->err_nofileaccess);
   } 
} 

if ($action == "pdf_show" || $action == "xls_show" || $action == "doc_show" || $action == "ppt_show" || $action == "mp3_play" || $action == "inline")
{
   $mimetyp = fGetMimeType(flid_to_filename($id));

   $len = filesize($path);
   header("Content-type: $mimetyp");
   header("Content-Length: $len");
   header("Content-Disposition: inline; filename=" . flid_to_filename($id));
   readfile($path);
   if (!$default->owl_use_fs)
   {
      unlink($path);
   } 
   owl_syslog(FILE_VIEWED, $userid, flid_to_filename($id), $parent, "", "FILE");
   die;
} 

// end of what Richard Bartz added to show PDF, DOC, and TXT special view
// cv change for security, should deny documents directory
// added image_show that passes the image through
if ($action != "image_show")
{
   include("./lib/header.inc");
   include("./lib/userheader.inc");
   print("<center>\n");
} 


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

if ($action == "image_show")
{
   if (check_auth($id, "file_download", $userid) == 1)
   {
      if ($default->owl_use_fs)
      {
         $path = $default->owl_FileDir . "/" . find_path($parent) . "/" . flid_to_filename($id);
         readfile("$path");
      } 
      else
      {
         $sql = new Owl_DB;
         $filename = flid_to_filename($id);
         if ($filetype = strrchr($filename, "."))
         {
            $filetype = substr($filetype, 1);
            $sql->query("select * from $default->owl_mime_table where filetype = '$filetype'");
            while ($sql->next_record()) $mimeType = $sql->f("mimetype");
         } 
         if ($mimeType)
         {
            header("Content-Type: $mimeType");
            $sql->query("select data,compressed from " . $default->owl_files_data_table . " where id='$id'");
            while ($sql->next_record())
            {
               if ($sql->f("compressed"))
               {
                  $tmpfile = $default->owl_tmpdir . "/owltmp.$id";
                  if (file_exists($tmpfile)) unlink($tmpfile);
                  $fp = fopen($tmpfile, "wb");
                  fwrite($fp, $sql->f("data"));
                  fclose($fp);
                  flush(passthru($default->gzip_path . " -dfc $tmpfile"));
                  unlink($tmpfile);
               } 
               else
               {
                  print $sql->f("data");
               } 
            } 
         } 
      } 
   } 
   else
   {
      print($owl_lang->err_nofileaccess);
   } 
   die;
} 

if ($action == "file_details")
{
   if (check_auth($parent, "folder_view", $userid) == 1)
   {
      if ($expand == 1)
      {
         print("<table class='border1' cellspacing='0' cellpadding='0' border='0' width='$default->table_expand_width'><tr><td align='left' valign='top' width='100%'>\n");
      }
      else
      {
         print("<table class='border1' cellspacing='0' cellpadding='0' border='0' width='$default->table_collapse_width'><tr><td align='left' valign='top' width='100%'>\n");
      }
      fPrintButtonSpace(12, 1);
      print("<br></br>\n");
      print("<table class='border2' cellspacing='0' cellpadding='0' border='0' width='100%'><tr><td align='left' valign='top' width='100%'>\n");
                                                                                                                                                                                                       
     if ($default->show_prefs == 1 or $default->show_prefs == 3)
     {
        fPrintPrefs("infobar1", "top");
     }

     fPrintButtonSpace(12, 1);
     print("<br></br>\n");

      fPrintNavBar($parent);
      $sql = new Owl_DB;
      $sql->query("select * from $default->owl_files_table where id = '$id'");
      while ($sql->next_record())
      {
         $security = $sql->f("security");
         if ($security == "0") $security = $owl_lang->everyoneread;
         if ($security == "1") $security = $owl_lang->everyonewrite;
         if ($security == "2") $security = $owl_lang->groupread;
         if ($security == "3") $security = $owl_lang->groupwrite;
         if ($security == "4") $security = $owl_lang->onlyyou;
         if ($security == "5") $security = $owl_lang->groupwrite_nod;
         if ($security == "6") $security = $owl_lang->everyonewrite_nod;
         if ($security == "7") $security = $owl_lang->groupwrite_worldread;
         if ($security == "8") $security = $owl_lang->groupwrite_worldread_nod;

         $choped = split("\.", $sql->f("filename"));
         $pos = count($choped);
         $ext = strtolower($choped[$pos-1]);
         print("<table class='margin2' cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
         print("<tr>\n");
         print("<td align='left' valign='top'>\n");
         print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
         print("<tr>\n");
         print("<td class='form1'>$owl_lang->title:</td>\n");
         print("<td class='form1' width='100%'>". $sql->f("name") ." &nbsp;&nbsp;");

         // Tiian change 2003-07-31
         $pos = strpos(get_dirpath($sql->f("parent")), "backup");
         if (is_integer($pos) && $pos)
         {
             $is_backup_folder = true;
         }
         else
         {
             $is_backup_folder = false;
         }
         printFileIcons($sql->f("id"), $sql->f("filename"), $sql->f("checked_out"), $sql->f("url"), $default->owl_version_control, $ext, $sql->f("parent"),$is_backup_folder);

         print("</td>\n");
         print("</tr>\n");

         
         $link = $default->owl_notify_link . "browse.php?sess=0&parent=" . $parent . "&expand=1&fileid=" . $id;
         fPrintFormTextLine($owl_lang->notify_link . ":" , "", "",  $link , "", true);
         fPrintFormTextLine($owl_lang->file . ":" , "", "", $sql->f("filename"), gen_filesize($sql->f("f_size")), true );
         // if a MP3 tag was found Display the information
         $filepath = $default->owl_FileDir . "/" . get_dirpath($sql->f("parent")) . "/" . $sql->f("filename");
         if ($sql->f("url") != 1 && file_exists($filepath))
         {
            $id3 = new id3($filepath);

            if ($id3->id3v11 || $id3->id3v1 || $id3->id3v2)
            {
               $id3->study();
               print("<tr><td align='right' valign='top'><br></br>$owl_lang->disp_mp3<br></br><br></br></td>");
               print("<td align='left'>");
               print("<b>$id3->artists - $id3->name <br></br>");
               print("$id3->album <br></br>");
               print("$id3->bitrate kbps&nbsp;&nbsp;$id3->frequency Hz&nbsp;$id3->mode <br></br>");
               print("$id3->length<br></br>");
               print("$id3->genre<br></br>");
               print("$id3->comment</b>");
               print("</td></tr>");
            } 
         } 

         fPrintFormTextLine($owl_lang->ownership . ":" , "", "",  fid_to_creator($id) . "&nbsp;(" . group_to_name(owlfilegroup($id)) . ")" , "", true);
         fPrintFormTextLine($owl_lang->permissions . ":" , "", "",  $security , "", true);
         fPrintFormTextLine($owl_lang->keywords . ":" , "", "",  $sql->f("metadata")  , "", true);
         $sql_custom = new Owl_db;
         $sql_custom_values = new Owl_db;
                                                                                                                                                                                               
            $sql_custom->query("SELECT * from $default->owl_docfields_table where doc_type_id = '" . $sql->f("doctype") . "' order by field_position");
                                                                                                                                                                                               
            if ($sql_custom->num_rows($sql_custom) > 0)
            {
               print("<tr><td align='right'>$owl_lang->doc_specific</td><td align='left'>&nbsp;</td></tr>");
            }
                                                                                                                                                                                               
            $qFieldLabel = new Owl_DB;
                                                                                                                                                                                               
            while ($sql_custom->next_record())
            {
               $sql_custom_values->query("SELECT  field_value from $default->owl_docfieldvalues_table where file_id = '" . $sql->f("id") . "' and field_name = '" . $sql_custom->f("field_name") ."'");
               $values_result = $sql_custom_values->next_record();
                                                                                                                                                                                               
               $qFieldLabel->query("SELECT field_label from $default->owl_docfieldslabel_table where locale = '$language' and doc_field_id='" . $sql_custom->f("id") . "'");
               $qFieldLabel->next_record();
               print("<tr><td align='right'>". $qFieldLabel->f("field_label") .":");
                                                                                                                                                                                               
               if ($sql_custom->f("required") == "1")
               {
                  print("<font color=red><b>&nbsp;*&nbsp;</b></font>");
               }
               else
               {
                  print("<font color=red><b>&nbsp;&nbsp;&nbsp;</b></font>");
               }
                                                                                                                                                                                               
               print("</td><td align='left'>" . $sql_custom_values->f("field_value") ."</td></tr>");
            }
                                                                                                                                                                                               
            if ($sql_custom->num_rows($sql_custom) > 0)
            {
               print("<tr><td align='right'>&nbsp;</td><td align='left'>&nbsp;</td></tr>");
            }

         fPrintFormTextArea($owl_lang->description. ":", "description", $sql->f("description"));

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
} 

if ($action == "image_preview")
{
   if (check_auth($id, "file_download", $userid) == 1)
   {
      owl_syslog(FILE_VIEWED, $userid, flid_to_filename($id), $parent, "", "FILE");
      if ($expand == 1)
      {
         print("<table class='border1' cellspacing='0' cellpadding='0' border='0' width='$default->table_expand_width'><tr><td align='left' valign='top' width='100%'>\n");
      }
      else
      {
         print("<table class='border1' cellspacing='0' cellpadding='0' border='0' width='$default->table_collapse_width'><tr><td align='left' valign='top' width='100%'>\n");
      }
      fPrintButtonSpace(12, 1);
      print("<br></br>\n");
      print("<table class='border2' cellspacing='0' cellpadding='0' border='0' width='100%'><tr><td align='left' valign='top' width='100%'>\n");
                                                                                                                                                                                                       
     if ($default->show_prefs == 1 or $default->show_prefs == 3)
     {
        fPrintPrefs();
     }

     fPrintButtonSpace(12, 1);
     $path = find_path($parent) . "/" . flid_to_filename($id);
     fPrintNavBar($parent, $owl_lang->viewing . ":&nbsp;", $id);

     print("<table class='margin2' cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
     print("<tr>\n");
     print("<td align='left' valign='top'>\n");
     print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
     print('<tr>');
     print("<td align='left'>");
     print('<p align="center">');
     print("<img src='$path' alt=''></img></p>");
     print("</td></tr></table>");
     print("</td></tr></table>");
     fPrintButtonSpace(12, 1);
     if ($default->show_prefs == 2 or $default->show_prefs == 3)
     {
        fPrintPrefs("infobar2");
     }
     print("</td></tr></table>");
     include("./lib/footer.inc");
   } 
   else
   {
      printError($owl_lang->err_nofileaccess);
   } 
} 

if ($action == "zip_preview")
{
   if (check_auth($id, "file_download", $userid) == 1)
   {
      owl_syslog(FILE_VIEWED, $userid, flid_to_filename($id), $parent, "", "FILE");
      $name = flid_to_filename($id);

      if ($default->owl_use_fs)
      {
         $path = find_path($parent) . "/" . $name;
      } 
      else
      {
         $path = $name;
         if (file_exists($default->owl_FileDir . "/$path")) unlink($default->owl_FileDir . "/$path");
         $file = fopen($default->owl_FileDir . "/$path", 'wb');
         $sql->query("select data,compressed from $default->owl_files_data_table where id='$id'");
         while ($sql->next_record())
         {
            if ($sql->f("compressed"))
            {
               $tmpfile = $default->owl_tmpdir . "/owltmp.$id.gz";
               $uncomptmpfile = $default->owl_tmpdir . "/owltmp.$id";
               if (file_exists($tmpfile)) unlink($tmpfile);

               $fp = fopen($tmpfile, "wb");
               fwrite($fp, $sql->f("data"));
               fclose($fp);

               system($default->gzip_path . " -df $tmpfile");

               $fsize = filesize($uncomptmpfile);
               $fd = fopen($uncomptmpfile, 'rb');
               $filedata = fread($fd, $fsize);
               fclose($fd);

               fwrite($file, $filedata);
               unlink($uncomptmpfile);
            } 
            else
            {
               fwrite($file, $sql->f("data"));
            } 
            fclose($file);
         } 
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
      print("<br></br>\n");
      print("<table class='border2' cellspacing='0' cellpadding='0' border='0' width='100%'><tr><td align='left' valign='top' width='100%'>\n");


      if ($default->show_prefs == 1 or $default->show_prefs == 3)
      {
         fPrintPrefs();
      }

      fPrintButtonSpace(12, 1);


      fPrintNavBar($parent, $owl_lang->viewing . ":&nbsp;", $id);

      print("<table><tr><td align='left'><pre>");

      if ($filext == "tar")
      {
         $expr = "-tvf ";
         $unzipbin = "$default->tar_path $expr " . "\"" . "./" . $path . "\" ";
         if (substr(php_uname(), 0, 7) != "Windows")
         {
            $unzipbin .= " 2>&1";
         } 
         passthru("$unzipbin");
      } 
      else if (($filext == "tar.gz") || ($filext == "tgz"))
      {
         $expr = "-tz ";
         $unzipbin = "$default->tar_path $expr  < " . "\"" . "./" . $path . "\" ";
         if (substr(php_uname(), 0, 7) != "Windows")
         {
            $unzipbin .= " 2>&1";
         } 
         passthru("$unzipbin");
      } elseif ($filext == "gz")
      {
         $expr = "-lt";
         $unzipbin = "$default->gzip_path $expr " . "\"" . "./" . $path . "\" ";
         if (substr(php_uname(), 0, 7) != "Windows")
         {
            $unzipbin .= " 2>&1";
         } 
         passthru("$unzipbin");
      } 
      else if ($filext == "zip")
      {
         $expr = "-l";
         $unzipbin = "$default->unzip_path $expr " . "\"" .  $default->owl_FileDir  . "/" . $path . "\" ";
         if (substr(php_uname(), 0, 7) != "Windows")
         {
            $unzipbin .= " 2>&1";
         } 
         passthru("$unzipbin");
      } 
      else
      {
         exit();
      }

      if (!$default->owl_use_fs)
      {
         unlink($default->owl_FileDir . "/$path");
      } 
      print("</pre></td></tr></table>");

      fPrintButtonSpace(12, 1);

      if ($default->show_prefs == 2 or $default->show_prefs == 3)
      {
         fPrintPrefs("infobar2");
      }
      print("</td></tr></table>\n");
      include("./lib/footer.inc");
   } 
   else
   {
      print($owl_lang->err_nofileaccess);
   } 
} 
// BEGIN wes change
if ($action == "html_show" || $action == "text_show" || $action == "note_show" || $action == "pod_show" || $action == "php_show")
{
   if (check_auth($id, "file_download", $userid) == 1)
   {
      owl_syslog(FILE_VIEWED, $userid, flid_to_filename($id), $parent, "", "FILE");
      if ($default->owl_use_fs)
      {
         $path = $default->owl_FileDir . "/" . find_path($parent) . "/" . flid_to_filename($id);
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
            fPrintPrefs();
         }

         fPrintButtonSpace(12, 1);
         print("<br />\n");
                                                                                                                                                                                                 

         fPrintNavBar($parent, $owl_lang->viewing . ":&nbsp;", $id);
         print("<table class='margin2' cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
         print("<tr>\n");
         print("<td align='left' valign='top'>\n");
         print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
         print('<tr>');
         print("<td align='left'>");
         print('<p align="left">');

         if ($action == "text_show" or $action == "note_show" or $action == "html_show") 
         {
            print("<xmp>"); 
         }

         if ($action == "pod_show")
         {
            if (file_exists($default->pod2html_path))
            {
               $sOwltmpview = $default->owl_tmpdir . "/owltmpview.$id.$sess";
               $mystring = system("$default->pod2html_path --cachedir=$default->owl_tmpdir --infile=$path --outfile=$sOwltmpview");
               readfile("$sOwltmpview"); 
               myDelete($sOwltmpview); 
            }
            else 
            {
               print("<H2>$owl_lang->err_pod2html_not_found $default->pod2html_path</H2>");
            }
         }
         elseif ($action == "php_show")
         {
               $sOwltmpview = $default->owl_tmpdir . "/owltmpview.$id.$sess";
               $mystring = system("php -s -q $path > $sOwltmpview");
               readfile("$sOwltmpview");
               myDelete($sOwltmpview);
         }
         else
         {
            readfile("$path"); 
         }
         //if ($action == "text_show" or $action == "note_show" or $action == "html_show") 
         //{
            //print("</xmp>");
         //}
         //print('</td>');
         //print('</tr>');
      } 
      else
      {
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
            fPrintPrefs();
         }
                                                                                                                                                                                                    
         fPrintButtonSpace(12, 1);
         print("<br />\n");
                                                                                                                                                                                                    
                                                                                                                                                                                                    
         fPrintNavBar($parent, $owl_lang->viewing . ":&nbsp;", $id);
         print("<table class='margin2' cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
         print("<tr>\n");
         print("<td align='left' valign='top'>\n");
         print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
         print('<tr>');
         print("<td align='left'>");
         print('<p align="left">');

         if ($action == "text_show" or $action == "note_show" or $action == "html_show") 
         {
            print("<xmp>");
         }

         $sql->query("select data,compressed from " . $default->owl_files_data_table . " where id='$id'");

         while ($sql->next_record())
         {
            if ($sql->f("compressed"))
            {
                  print("<xmp>");
                  $tmpfile = $default->owl_tmpdir . "/owltmp.$id.$sess";
                  if (file_exists($tmpfile)) unlink($tmpfile);
                  $fp = fopen($tmpfile, "wb");
                  fwrite($fp, $sql->f("data"));
                  fclose($fp);
                  flush(stripslashes(passthru($default->gzip_path . " -dfc $tmpfile")));
                  print("</xmp>");
                  unlink($tmpfile);
            } 
            else
            {
               if ($action == "php_show")
               {
                     $sOwltmpview = $default->owl_tmpdir . "/owltmpview.$id.$sess";
                     $tmpfile = $default->owl_tmpdir . "/owltmpview2.$id.$sess";
                     if (file_exists($tmpfile)) unlink($tmpfile);
                     $fp = fopen($tmpfile, "wb");
                     fwrite($fp, stripslashes($sql->f("data")));
                     fclose($fp);
                     $mystring = system("php -s -q $tmpfile > $sOwltmpview");
                     readfile("$sOwltmpview");
                     myDelete($sOwltmpview);
                     myDelete($tmpfile);
               }
               else
               {
                  print stripslashes($sql->f("data"));
               }
            } 
         } 
      } 

      if ($action == "text_show" or $action == "note_show" or $action == "html_show") 
      {
         print("</xmp>");
      }

      print('</td>');
      print('</tr>');
      print('</table>');
      $path = find_path($parent) . "/" . flid_to_filename($id);

      print("</td></tr></table>");

      fPrintButtonSpace(12, 1);

       if ($default->show_prefs == 2 or $default->show_prefs == 3)
       {
          fPrintPrefs("infobar2");
       }
       print("</td></tr></table>\n");
       include("./lib/footer.inc");
   } 
   else
   {
      print($owl_lang->err_nofileaccess);
   } 
} 
// end wes change

?>
