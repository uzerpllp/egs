<?php

/**
 * modify.php
 * 
 * Author: Steve Bourgeois <owl@bozzit.com>
 * Project Founder: Chris Vincent <cvincent@project802.net>
 *
 * Copyright (c) 1999-2005 The Owl Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 * 
 * $Id: modify.php,v 1.13 2005/03/20 22:08:23 b0zz Exp $
 */

require_once("./config/owl.php");
require_once("./lib/disp.lib.php");
require_once("./lib/owl.lib.php");
require_once("./lib/security.lib.php");
require_once("./phpid3v2/class.id3.php");

include_once("./lib/header.inc");
include_once("./lib/userheader.inc");

if ($sess == "0" && $default->anon_ro > 0)
{
   printError($owl_lang->err_login);
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

if(!isset($type))
{
   $type = "";
}

// V4B RNG Start
$urlArgs = array();
$urlArgs['sess']      = $sess;
$urlArgs['parent']    = $parent;
$urlArgs['expand']    = $expand;
$urlArgs['order']     = $order;
$urlArgs['sortorder'] = $sortorder;
// V4B RNG End

if ($action == "file_comment")
{
   if (check_auth($id, "file_download", $userid) == 1)
   {
      printModifyHeader();
      $sql = new Owl_DB; 
      $sql->query("SELECT * from $default->owl_comment_table where fid = '$id' order by id");

      fPrintNavBar($parent, $owl_lang->adding_comments . "&nbsp;", $id);
      $urlArgs2 = $urlArgs;
      $urlArgs2['action'] = 'file_comment';
      $urlArgs2['expand'] = $expand;
      $urlArgs2['id']     = $id;

      print("<form enctype=\"multipart/form-data\" action=\"dbmodify.php\" method=\"post\">\n");
      print fGetHiddenFields ($urlArgs2);
      print("<table class=\"margin2\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
      print("<tr>\n");
      print("<td align=\"left\" valign=\"top\">\n");
      print("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");

      fPrintFormTextArea($owl_lang->comments . ":", "newcomment", "",5,80);
      print("<tr>\n");
      print("<td class=\"form1\">");
      fPrintButtonSpace(1, 1);
      print("</td>\n");
      print("<td class=\"form2\" width=\"100%\">");
      fPrintSubmitButton($owl_lang->post_comment, $owl_lang->alt_add_comments, "submit", "send_file_x");
      fPrintSubmitButton($owl_lang->btn_reset, $owl_lang->alt_reset_form, "reset");
      print("</td>\n");
      print("</tr>\n");
      print("</table>\n");
      print("</td></tr></table>\n");
      print("</form>\n");


      print("<table class=\"margin2\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
      print("<tr>\n");
      print("<td align=\"left\" valign=\"top\">\n");
      print("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
      $iCountlines = 0;
      while ($sql->next_record())
      {
         $sComment = nl2br($sql->f("comments"));

         print("<tr>\n<td class=\"title1\" rowspan=\"2\"><b><font color=\"green\"> " . date($owl_lang->localized_date_format, strtotime($sql->f("comment_date"))) . "</font></b>");
         $iFileOwner = owlfilecreator($sql->f("fid"));
         if (fIsAdmin() || $iFileOwner == $userid)
         {
            $urlArgs2 = $urlArgs;
            $urlArgs2['action'] = 'del_comment';
            $urlArgs2['cid']    = $sql->f("id");
            $urlArgs2['id']     = $id;
            $url = fGetURL ('dbmodify.php', $urlArgs2);

            print("<br /><a href=\"$url\" onclick=\"return confirm('$owl_lang->reallydelete ?');\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/ui_misc/delete.gif\" alt=\"$owl_lang->alt_del_comments $file\" title=\"$owl_lang->alt_del_comments $file\" border=\"0\"></img></a>");
         } 

         print("</td>\n<td class=\"title1\" align=\"left\">$owl_lang->comments_added<b><font color=\"green\">" . uid_to_name($sql->f("userid")) . "</font></b></td>\n</tr>\n");
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
         print("<tr><td colspan=\"2\" class=\"$sTrClass\">" . $sComment . "</td></tr>");
      } 
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
   else
   {
      printError($owl_lang->err_adding_comments);
   } 
} 

if ($action == "file_update")
{
   if (check_auth($id, "file_modify", $userid) == 1)
   {
      printModifyHeader();
      $sql = new Owl_DB;
      $sql->query("SELECT groupid, description, linkedto from $default->owl_files_table where id = '$id'");
      $sql->next_record();
      $sDescription = $sql->f("description");

      print("<br />");


      $urlArgs2 = $urlArgs;
      $urlArgs2['action'] = 'file_update';
      $urlArgs2['groupid'] = $sql->f("groupid");
      $urlArgs2['linkedto'] = $sql->f("linkedto");
      $urlArgs2['MAX_FILE_SIZE VALUE'] = $default->max_filesize;
      $urlArgs2['id']     = $id;

      fPrintNavBar($parent, $owl_lang->updating . ":&nbsp;", $id);

      print("<form enctype=\"multipart/form-data\" action=\"dbmodify.php\" method=\"post\">\n");
      print fGetHiddenFields ($urlArgs2);
      print("<table class=\"margin2\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
      print("<tr>\n");
      print("<td align=\"left\" valign=\"top\">\n");
      print("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");


      print("<tr>\n");
      print("<td class=\"form1\">$owl_lang->sendthisfile:</td>\n");
      print("<td class=\"form1\" width=\"100%\"><input class=\"finput1\" type=\"file\" name=\"userfile\" size=\"24\" maxlength=\"512\"></input></td>\n");
      print("</tr>\n");

      // *****************************
      // PEER Review feature BEGIN
      // *****************************

      if ( $default->document_peer_review == 1 and empty($type))
      {
         //$sql->query("SELECT distinct id, name, username, email,language,attachfile from $default->owl_users_table u left join $default->owl_users_grpmem_table m on u.id=m.userid where disabled = '0' and (u.groupid = $usergroupid or m.groupid = $usergroupid) and u.id <> '$userid'");

          $aUserList = fGetUserInfoInMyGroups($userid, "email <> '' and id <> '$userid'");

          $i = 0;
          if (!empty($aUserList))
          {
             foreach ($aUserList as $aUsers)
             {
                $sUsername = $aUsers["username"];
                $sId = $aUsers["id"];
                $sName = $aUsers["name"];
                $sEmail = $aUsers["email"];
            //while ($sql->next_record())
            //{
               $reviewer[$i][0] = $sId;
               $reviewer[$i][1] = $sName . " (" . $sEmail . ")";
               //$reviewer[$i][0] = $sql->f("id");
               //$reviewer[$i][1] = $sql->f("name") . " (" . $sql->f("email") . ")";
               $i++;
            }
          }
          fPrintFormSelectBox("$owl_lang->peer_reviewer_list" . ":", "reviewers[]", $reviewer, "", 10, true);
          fPrintFormTextArea("$owl_lang->peer_msg_to_reviewer" . ":", "message", "", 2,80);
      }

      // *****************************
      // PEER Review feature END
      // *****************************
      if ($default->owl_version_control == 1)
      {
          print("<tr>\n");
          print("<td class=\"form1\">$owl_lang->vertype:</td>\n");
          print("<td class=\"form1\" width=\"100%\">");
          print("<select class=\"fpull1\" name=\"versionchange\" size=\"1\">\n");
          print("<option value=\"major_revision\">$owl_lang->vermajor</option>\n");
          print("<option selected=\"selected\" value=\"minor_revision\">$owl_lang->verminor</option>\n</select>\n</td>\n</tr>\n");

         fPrintFormTextArea($owl_lang->verdescription. ":", "newdesc", $sDescription);
      } 
      print("<tr>\n");
      print("<td class=\"form1\">");
      fPrintButtonSpace(1, 1);
      print("</td>\n");
      print("<td class=\"form2\" width=\"100%\">");
      fPrintSubmitButton($owl_lang->sendfile, $owl_lang->alt_sendfile, "submit", "send_file_x");
      fPrintSubmitButton($owl_lang->btn_reset, $owl_lang->alt_reset_form, "reset");
      print("</td>\n");
      print("</tr>\n");
      print("</table>\n");
      print("</td></tr></table>\n");
      print("</form>\n");
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
      printError($owl_lang->err_noupload);
   } 
} 

if ($action == "file_upload" or $action == "zip_upload")
{
   if (check_auth($parent, "folder_modify", $userid) == 1 or check_auth($parent, "folder_upload", $userid) == 1)
   {
      printModifyHeader(); 

      $groups = fGetGroups($userid);

      fPrintNavBar($parent, $owl_lang->addingfile . ":&nbsp;");
      $urlArgs2 = $urlArgs;
      $urlArgs2['action'] = $action;
      $urlArgs2['id']     = $id;
      $urlArgs2['type']   = $type;
      $urlArgs2['MAX_FILE_SIZE'] = $default->max_filesize;

      print("<form enctype=\"multipart/form-data\" action=\"dbmodify.php\" method=\"post\">\n");
      print fGetHiddenFields ($urlArgs2);
      print("<table class=\"margin2\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
      print("<tr>\n");
      print("<td align=\"left\" valign=\"top\">\n");
      print("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");


      if ($type == "url")
      {
         print("<tr>\n");
         print("<td class=\"form1\">$owl_lang->sendthisurl:</td>\n");
         print("<td class=\"form1\" width=\"100%\"><input class=\"finput1\" type=\"text\" name=\"userfile\" size=\"80\" value=\"http://\" maxlength=\"255\"></input></td>\n");
         print("</tr>\n");
      } 
      elseif ($type == "")
      {
         // if this is a new Document set the document type to DEFAULT
         if (!isset($doctype))
         {
            $doctype = 1;
         }

         $sql = new Owl_DB;
         $sql->query("SELECT * from $default->owl_doctype_table");
         if ($sql->num_rows() > 1)
         {
            print("<tr>\n");
            print("<td class=\"form1\">$owl_lang->document_type:</td>\n");
            print("<td class=\"form1\" width=\"100%\">");
            print("<select class=\"fpull1\" name=\"doctype\" size=\"1\" onchange=\"javascript:this.form.submit();\">\n");
            while ($sql->next_record())
            {
               print("<option value=\"" . $sql->f("doc_type_id"). "\"");
               if ( $sql->f("doc_type_id") == $doctype )
               {
                  print(" selected=\"selected\"");
               }
               print(">" . $sql->f("doc_type_name") . "</option>\n");
            }
            print("</select></td></tr>"); 
         }

         print("<tr>\n");
         print("<td class=\"form1\">$owl_lang->sendthisfile:</td>\n");
         print("<td class=\"form1\" width=\"100%\"><input class=\"finput1\" type=\"file\" name=\"userfile\" size=\"24\" maxlength=\"512\"></input>");
         print("</td>\n");
         print("</tr>\n");
      } 

         fPrintFormTextLine($owl_lang->title . ":" , "title", 60);

         print("<tr>\n");
         print("<td class=\"form1\"><label for=\"metadata\">$owl_lang->keywords:</label></td>\n");
         print("<td class=\"form1\" width=\"100%\"><input class=\"finput1\" type=\"text\" id=\"metadata\" name=\"metadata\" size=\"60\" maxlength=\"255\"></input>");
         if ($default->save_keywords_to_db)
         {
            print("&nbsp;<input class=\"fcheckbox1\" type=\"checkbox\" name=\"savekeyword\" value=\"1\"></input>&nbsp;Save keyword?");
         } 
         print("</td>\n");
         print("</tr>\n");

         if ($default->save_keywords_to_db)
         {
            $KeyWrd = new Owl_DB;
            $KeyWrd->query("SELECT keyword_text from $default->owl_keyword_table order by keyword_text");
            $i = 0;
            while ($KeyWrd->next_record())
            {
               $keywords[$i][0] = $KeyWrd->f("keyword_text");
               $keywords[$i][1] = $KeyWrd->f("keyword_text");
               $i++;
            }
            fPrintFormSelectBox("&nbsp;", "keywordpick[]", $keywords, "" , 5, true);
         }

      if ($default->owl_version_control == 1)
      {
         fPrintFormTextLine($owl_lang->vermajor . ":", "major_revision", 60, $default->major_revision);
         fPrintFormTextLine($owl_lang->verminor . ":", "minor_revision", 60, $default->minor_revision);
      } 


      print("<tr>\n");
      print("<td class=\"form1\">$owl_lang->ownergroup:</td>\n");
      print("<td class=\"form1\" width=\"100%\">");
      print("<select class=\"fpull1\" name=\"groupid\" size=\"1\">\n");
      if (isset($groupid))
      {
         print("<option value=\"" . $sql->f("groupid") . "\">" . group_to_name($sql->f("groupid")) . "</option>");
      } 
      foreach($groups as $g)
      {
         print("<option value=\"$g[0]\"");

         if ($g[0] == owlusergroup($userid))
         {
            print(" selected=\"selected\"");
         }
         print(">$g[1]</option>\n");
      } 
      print("</select>\n</td>\n</tr>\n");

      printfileperm($default->file_perm, "security", $owl_lang->permissions . ":", "admin");

      if ($action == "zip_upload")
      {
         if (fIsAdmin())
         {
            printgroupperm($default->folder_perm, "policy", "Folder " . $owl_lang->policy. ":", "admin");
         }
         else
         {
            printgroupperm($default->folder_perm, "policy", "Folder " . $owl_lang->policy. ":", "user");
         }
      }   

      // *****************************
      // PEER Review feature BEGIN
      // *****************************

      if ( $default->document_peer_review == 1 and empty($type))
      {
         //$sql->query("SELECT distinct id, name, username, email,language,attachfile from $default->owl_users_table u left join $default->owl_users_grpmem_table m on u.id=m.userid where disabled = '0' and (u.groupid = $usergroupid or m.groupid = $usergroupid) and u.id <> '$userid'");

          $aUserList = fGetUserInfoInMyGroups($userid, "email <> '' and id <> '$userid'");

          $i = 0;
          if (!empty($aUserList))
          {
             foreach ($aUserList as $aUsers)
             {
                $sUsername = $aUsers["username"];
                $sId = $aUsers["id"];
                $sName = $aUsers["name"];
                $sEmail = $aUsers["email"];
             //while ($sql->next_record())
             //{
                $reviewer[$i][0] = $sId;
                $reviewer[$i][1] = $sName . " (" . $sEmail . ")";
                //$reviewer[$i][0] = $sql->f("id");
                //$reviewer[$i][1] = $sql->f("name") . " (" . $sql->f("email") . ")";
                $i++;
             }
          }
          fPrintFormSelectBox("$owl_lang->peer_reviewer_list" . ":", "reviewers[]", $reviewer, "", 10, true);
          fPrintFormTextArea("$owl_lang->peer_msg_to_reviewer" . ":", "message", "", 2,80);
      }

      // *****************************
      // PEER Review feature END
      // *****************************


      if ($default->display_password_override == 1)
      {
         fPrintFormTextLine($owl_lang->newpassword . ":" , "newpassword", "", $sql->f("password"), "", false, "password");
         fPrintFormTextLine($owl_lang->confpassword . ":" , "confpassword", "", $sql->f("password"), "", false, "password");
      }

      if ($type == "note")
      {
         fPrintFormTextArea($owl_lang->description. ":", "description");
         fPrintFormTextArea($owl_lang->note_content. ":", "note_content", "", 20, 60);
      } 
      else
      {
         if (isset($doctype))
         {
            $sql->query("SELECT * from $default->owl_docfields_table where doc_type_id = '$doctype' order by field_position");

            if ($sql->num_rows($sql) > 0)
            {
               print("<tr><td class=\"browse0\" width=\"100%\" colspan=\"2\">$owl_lang->doc_specific</td></tr>\n");
            }
                                                                                                                   
            $qFieldLabel = new Owl_DB;

                                                                                                                   
            while ($sql->next_record())
            {
               $qFieldLabel->query("SELECT field_label from $default->owl_docfieldslabel_table where locale = '$language' and doc_field_id='" . $sql->f(id) . "'");
               $qFieldLabel->next_record();
   
               print("<tr><td  class=\"form1\">". $qFieldLabel->f("field_label") .":");
               if ($sql->f("required") == "1")
               {
                  print("<font color=red><b>&nbsp;*&nbsp;</b></font>");
               }
               else
               {
                  print("<font color=red><b>&nbsp;&nbsp;&nbsp;</b></font>");
               }
               print("</td><td  class=\"form1\"><input class=\"finput1\" type=\"" . $sql->f("field_type") . "\" name=\"" . $sql->f("field_name") . "\" size=\"" . $sql->f("field_size") ."\" value= \"" .  $sql->f("field_value") ."\"></input></td></tr>");

            }
            if ($sql->num_rows($sql) > 0)
            {
               print("<tr><td class=\"browse0\" width=\"100%\" colspan=\"2\">&nbsp;</td></tr>\n");
            }
    
         }
         fPrintFormTextArea($owl_lang->description. ":", "description");
      } 
      if ($type == "note")
      {
         print("<tr>\n");
         print("<td class=\"form1\">");
         fPrintButtonSpace(1, 1);
         print("</td>\n");
         print("<td class=\"form2\" width=\"100%\">");
         fPrintSubmitButton($owl_lang->btn_add_note, $owl_lang->alt_btn_add_note, "submit", "send_file_x");
         fPrintSubmitButton($owl_lang->btn_reset, $owl_lang->alt_reset_form, "reset");
         print("</td>\n");
         print("</tr>\n");
         //print("</form>\n");
      } 
      else if ($type == "url") 
      {
         print("<tr>\n");
         print("<td class=\"form1\">");
         fPrintButtonSpace(1, 1);
         print("</td>\n");
         print("<td class=\"form2\" width=\"100%\">");
         fPrintSubmitButton($owl_lang->btn_add_url, $owl_lang->alt_btn_add_url, "submit", "send_file_x");
         fPrintSubmitButton($owl_lang->btn_reset, $owl_lang->alt_reset_form, "reset");
         print("</td>\n");
         print("</tr>\n");
         //print("</form>\n");
      } 
      else 
      {
         
         print("<tr>\n");
         print("<td class=\"form1\">");
         fPrintButtonSpace(1, 1);
         print("</td>\n");
         print("<td class=\"form2\" width=\"100%\">");
	 fPrintSubmitButton($owl_lang->sendfile, $owl_lang->alt_sendfile, "submit", "send_file_x");
         fPrintSubmitButton($owl_lang->btn_reset, $owl_lang->alt_reset_form, "reset");
         print("</td>\n");
         print("</tr>\n");
      }
      print("</table>\n");
      print("</td></tr></table>\n");
      print("</form>\n");
      fPrintButtonSpace(12, 1);

      if ($default->show_prefs == 2 or $default->show_prefs == 3)
      {
         fPrintPrefs("infobar2");
      }
      print("</td></tr></table>\n");
      include("./lib/footer.inc");
      //print("</td></tr></table>\n");
   } 
   else
   {
      printError($owl_lang->err_noupload);
   } 
} 

if ($action == "file_modify")
{
   if (check_auth($id, "file_modify", $userid) == 1)
   {
      printModifyHeader();

      /**
       * BEGIN Bozz Change
       * Retrieve Group information if the user is in the
       * Administrator group
       */

      $mygroup = owlusergroup($userid);

      if (fIsAdmin())
      {
         $groups = fGetGroups($userid);

         $sql->query("SELECT id,name from $default->owl_users_table");

         $i = 0;
         while ($sql->next_record())
         {
            $users[$i][0] = $sql->f("id");
            $users[$i][1] = $sql->f("name");
            $i++;
         } 
      } 
      else
      {
         if (uid_to_name($userid) == fid_to_creator($id))
         {
            $groups = fGetGroups($userid);
            $mygroup = owlusergroup($userid);

            $sql->query("SELECT id,name from $default->owl_users_table where groupid='$mygroup'");
            $i = 0;
            while ($sql->next_record())
            {
               $users[$i][0] = $sql->f("id");
               $users[$i][1] = $sql->f("name");
               $i++;
            } 
         } 
      } 

      /**
       * END Bozz Change
       */
      $sql = new Owl_DB;
      $sql->query("SELECT * from $default->owl_files_table where id = '$id'");
      $sql->next_record();

      fPrintNavBar($parent, $owl_lang->modifying . ":&nbsp;", $id);
      print("<form action='dbmodify.php'>\n");
      if ($sql->f("url") == 1)
      {
         print("<input type=\"hidden\" name=\"filename\" value=\"" . $sql->f("filename") . "\"></input>\n");
         print("<input type=\"hidden\" name=\"type\" value=\"url\"></input>\n");
      }
      else
      {
         print("<input type=\"hidden\" name=\"filename\" value=\"" . $sql->f("filename") . "\"></input>");
      } 

      if (owlusergroup($userid) == 0 || uid_to_name($userid) == fid_to_creator($id) || $mygroup == $default->file_admin_group)
      {
      }
      else
      {
         print("<input type=\"hidden\" name=\"file_owner\" value=\"$current_owner\"></input>");
         print("<input type=\"hidden\" name=\"security\" value=\"$security\"></input>");
         print("<input type=\"hidden\" name=\"groupid\" value=\"$current_groupid\"></input>");
      }
      $urlArgs2 = $urlArgs;
      $urlArgs2['action']  = 'file_modify';
      $urlArgs2['id']      = $id;
      $urlArgs2['doctype'] = $sql->f("doctype");
      print fGetHiddenFields($urlArgs2);

      print("<table class=\"margin2\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
      print("<tr>\n");
      print("<td align=\"left\" valign=\"top\">\n");
      print("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
         fPrintFormTextLine($owl_lang->title . ":" , "title", 60,  $sql->f("name"));

         $link = $default->owl_notify_link . "browse.php?sess=0&amp;parent=" . $parent . "&amp;expand=1&amp;fileid=" . $id;

         fPrintFormTextLine($owl_lang->notify_link . ":" , "", "",  $link , "", true);

         if ($sql->f("url") == 1)
         {
            $link = "<a href=\"" . $sql->f("filename") . "\" target=\"new\" title=\"$owl_lang->title_browse_site\">" . $sql->f("filename") . "</a>";
            fPrintFormTextLine($owl_lang->modify_url . ":" , "", "",  $link , "", true);
            fPrintFormTextLine($owl_lang->file . ":" , "new_filename", 60,  $sql->f("filename"));
         } 
         else
         {
            fPrintFormTextLine($owl_lang->file . ":" , "new_filename", 40, $sql->f("filename"), gen_filesize($sql->f("f_size")) );
         } 
         // if a MP3 tag was found Display the information
         $filepath = $default->owl_FileDir . "/" . get_dirpath($sql->f("parent")) . "/" . $sql->f("filename");
         if ($sql->f("url") == 0 && file_exists($filepath))
         {
            $id3 = new id3($filepath);

            if ($id3->id3v11 | $id3->id3v1)
            {
               $id3->study();
               print("<tr><td class=\"form1\"><br />$owl_lang->disp_mp3<br /></td>");
               print("<td class=\"form1\" width=\"100%\">");
               print("<b>$id3->artists - $id3->name <br />");
               print("$id3->album <br />");
               print("$id3->bitrate kbps&nbsp;&nbsp;$id3->frequency Hz&nbsp;$id3->mode <br />");
               print("$id3->length<br />");
               print("$id3->genre<br />");
               print("$id3->comment</b>");
               print("</td></tr>");
            } 
         } 

         $security = $sql->f("security");
         $current_groupid = owlfilegroup($id);
         $current_owner = owlfilecreator($id);

         if (owlusergroup($userid) == 0 || uid_to_name($userid) == fid_to_creator($id) || $mygroup == $default->file_admin_group)
         {
            print("<tr>\n");
            print("<td class=\"form1\">$owl_lang->ownership:</td>\n");
            print("<td class=\"form1\" width=\"100%\">");
            print("<select class=\"fpull1\" name=\"file_owner\" size=\"1\">\n");

            foreach($users as $g)
            {
               print("<option value=\"$g[0]\" ");
               if ($g[0] == owlfilecreator($id))
               {
                  print("selected=\"selected\"");
               }
               print(">$g[1]</option>\n");
            } 
            print("</select></td></tr>");

            print("<tr>\n");
            print("<td class=\"form1\">$owl_lang->ownergroup:</td>\n");
            print("<td class=\"form1\" width=\"100%\">");
            print("<select class=\"fpull1\" name=\"groupid\" size=\"1\">\n");
            foreach($groups as $g)
            {
               print("<option value=\"$g[0]\" ");
               if ($g[0] == $current_groupid)
               {
                  print("selected=\"selected\"");
               }
               print(">$g[1]</option>\n");
            } 
            print("</select></td></tr>");
            printfileperm($security, "security", "$owl_lang->permissions:", "admin");
         } 
         else
         {
            fPrintFormTextLine($owl_lang->ownership .":", "", "",   fid_to_creator($id) . "&nbsp;(" . group_to_name(owlfilegroup($id)) . ")", "", true);
         } 
         // Bozz change End
         print("<tr>\n");
         print("<td class=\"form1\">$owl_lang->keywords:</td>\n");
         print("<td class=\"form1\" width=\"100%\"><input class=\"finput1\" type=\"text\" name=\"metadata\" value=\"" . $sql->f("metadata") . "\"size=\"60\" maxlength=\"255\"></input>");
         if ($default->save_keywords_to_db)
         {
            print("&nbsp;<input class=\"fcheckbox1\" type=\"checkbox\" name=\"savekeyword\" value=\"1\"></input>&nbsp;Save keyword?");
         } 
         print("</td>\n");
         print("</tr>\n");

         if ($default->save_keywords_to_db)
         {
            $KeyWrd = new Owl_DB;
            $KeyWrd->query("SELECT keyword_text from $default->owl_keyword_table order by keyword_text");
            $i = 0;
            while ($KeyWrd->next_record())
            {
               $keywords[$i][0] = $KeyWrd->f("keyword_text");
               $keywords[$i][1] = $KeyWrd->f("keyword_text");
               $i++;
            }
            fPrintFormSelectBox("&nbsp;", "keywordpick[]", $keywords, $sql->f("metadata") , 5, true);
         }

         if ($default->display_password_override == 1)
         {
            if (fIsAdmin() || uid_to_name($userid) == fid_to_creator($id))
            {
               fPrintFormTextLine($owl_lang->newpassword . ":" , "newpassword", "", $sql->f("password"), "", false, "password");
               fPrintFormTextLine($owl_lang->confpassword . ":" , "confpassword", "", $sql->f("password"), "", false, "password");
            }
         }
         if ($sql->f("url") == 2)
         {
            if ($default->owl_use_fs)
            {
               $filename = $default->owl_FileDir . "/" . find_path($parent) . "/" . $sql->f("filename");
               $handle = fopen ($filename, "r");
               $contents = fread ($handle, filesize ($filename));
               fclose ($handle);
            } 
            else
            {
               $getdata = new Owl_DB;
               $getdata->query("SELECT data from $default->owl_files_data_table where id='$id'");
               $getdata->next_record();
               $contents = $getdata->f("data");
            } 
            fPrintFormTextArea($owl_lang->description. ":", "description", $sql->f("description"));
            fPrintFormTextArea($owl_lang->note_content. ":", "note_content", $contents, 20, 50);
         } 
         else
         {
            $sql_custom = new Owl_DB;
            $sql_custom_values = new Owl_DB;
            
            $iCurrentDocType = $sql->f("doctype");

            if (!empty($iCurrentDocType))
            {
               $sql_custom->query("SELECT * from $default->owl_docfields_table where doc_type_id = '" . $iCurrentDocType. "' order by field_position");
   
               if ($sql_custom->num_rows($sql_custom) > 0)
               {
                  print("<tr><td class=\"browse0\" width=\"100%\" colspan=\"2\">$owl_lang->doc_specific</td></tr>\n");
               }


               $qFieldLabel = new Owl_DB;
   
               while ($sql_custom->next_record())
               {
                  $sql_custom_values->query("SELECT  field_value from $default->owl_docfieldvalues_table where file_id = '" . $sql->f("id") . "' and field_name = '" . $sql_custom->f("field_name") ."'");
                  $values_result = $sql_custom_values->next_record();
      
                  $qFieldLabel->query("SELECT field_label from $default->owl_docfieldslabel_table where locale = '$language' and doc_field_id='" . $sql_custom->f("id") . "'");
                  $qFieldLabel->next_record();
                  print("<tr><td class=\"form1\">". $qFieldLabel->f("field_label") .":");
      
                  if ($sql_custom->f("required") == "1")
                  {
                     print("<font color=\"red\"><b>&nbsp;*&nbsp;</b></font>");
                  }
                  else
                  {
                     print("<font color=\"red\"><b>&nbsp;&nbsp;&nbsp;</b></font>");
                  }
      
                  print("</td>\n<td  class=\"form1\" width=\"100%\"><input class=\"finput1\" type=\"" . $sql_custom->f("field_type") . "\" name=\"" . $sql_custom->f("field_name") . "\" size=\"" . $sql_custom->f("field_size") ."\" value= \"" .  $sql_custom_values->f("field_value") ."\"></input></td>\n</tr>\n");
               }
   
               if ($sql_custom->num_rows($sql_custom) > 0)
               {
                  print("<tr>\n<td class=\"browse0\" width=\"100%\" colspan=\"2\">&nbsp;</td></tr>\n");
               }
            }

            fPrintFormTextArea($owl_lang->description. ":", "description", $sql->f("description"));


         print("<tr>\n");
         print("<td class=\"form1\">");
         fPrintButtonSpace(1, 1);
         print("</td>\n");
         print("<td class=\"form2\" width=\"100%\">");
         fPrintSubmitButton($owl_lang->change, $owl_lang->alt_change);
         fPrintSubmitButton($owl_lang->btn_reset, $owl_lang->alt_reset_form, "reset");
         print("</td>\n");
         print("</tr>\n");
         print("</table>\n");
         print("</td>\n</tr>\n</table>\n");
         print("</form>\n");

         if ($default->show_prefs == 2 or $default->show_prefs == 3)
         {
            fPrintPrefs("infobar2");
         }
         print("</td></tr></table>\n");
         include("./lib/footer.inc");
      } 
   } 
   else
   {
      printError($owl_lang->err_nofilemod);
   } 
} 

if ($action == "folder_create")
{
   if (check_auth($parent, "folder_modify", $userid) == 1 or check_auth($parent, "folder_upload", $userid) == 1)
   {
      printModifyHeader(); 

      $groups = fGetGroups($userid);

      fPrintNavBar($parent, $owl_lang->addingfolder . ":&nbsp;");

      $urlArgs2 = $urlArgs;
      $urlArgs2['action']  = 'folder_create';

                                                                                                                                                                                                    
      print("<form action=\"dbmodify.php\">\n");
      print fGetHiddenFields ($urlArgs2);
      print("<table class=\"margin2\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
      print("<tr>\n");
      print("<td align=\"left\" valign=\"top\">\n");
      print("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
      fPrintFormTextLine($owl_lang->name . ":" , "name", 24);
      print("<tr>\n");
      print("<td class=\"form1\">$owl_lang->ownergroup</td>\n");
      print("<td class=\"form1\" width=\"100%\">");
      print("<select class=\"fpull1\" name=\"groupid\" size=\"1\">\n");
      foreach($groups as $g)
      {
         print("<option value=\"$g[0]\">$g[1]</option>\n");
      }
      print("</select>\n</td>\n</tr>\n");

      if (fIsAdmin())
      {
         printgroupperm($default->folder_perm, "policy", $owl_lang->policy, "admin");
      }
      else
      {
         printgroupperm($default->folder_perm, "policy", $owl_lang->policy, "user");
      }

      if ($default->display_password_override == 1)
      {
         fPrintFormTextLine($owl_lang->newpassword . ":" , "newpassword", "", $sql->f("password"), "", false, "password");
         fPrintFormTextLine($owl_lang->confpassword . ":" , "confpassword", "", $sql->f("password"), "", false, "password");
      }
      fPrintFormTextArea($owl_lang->description . ":", "description");
      print("<tr>");
      print("<td class=\"form1\">");
      fPrintButtonSpace(1, 1);
      print("</td>");
      print("<td class=\"form2\" width=\"100%\">");
      fPrintSubmitButton($owl_lang->create, $owl_lang->alt_btn_add_folder);
      fPrintSubmitButton($owl_lang->btn_reset, $owl_lang->alt_reset_form, "reset");
      print("</td>");
      print("</tr>");

      print("</table>\n");
      print("</td></tr></table>\n");
      print("</form>\n");


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
      printError($owl_lang->err_nosubfolder);
   } 
} 

if ($action == "folder_modify")
{
   if (check_auth($id, "folder_property", $userid) == 1)
   {
      printModifyHeader(); 
      /**
       * BEGIN Bozz Change
       * Retrieve Group information if the user is in the
       * Administrator group
       */

      if (fIsAdmin())
      {
         $groups = fGetGroups($userid);

         $sql->query("SELECT id,name from $default->owl_users_table");
         $i = 0;
         while ($sql->next_record())
         {
            $users[$i][0] = $sql->f("id");
            $users[$i][1] = $sql->f("name");
            $i++;
         } 
      } 
      else 
      {
         if ($userid == owlfoldercreator($id))
         {
            $groups = fGetGroups($userid);
            $mygroup = owlusergroup($userid);

            $sql->query("SELECT id,name from $default->owl_users_table where groupid='$mygroup'");
            $i = 0;
            while ($sql->next_record())
            {
               $users[$i][0] = $sql->f("id");
               $users[$i][1] = $sql->f("name");
               $i++;
            }

         }
      }

      fPrintNavBar($id, $owl_lang->modifying . ":&nbsp;");
 
      $sql = new Owl_DB;
      $sql->query("SELECT * from $default->owl_folders_table where id = '$id'");
      while ($sql->next_record())
      {
         $security = $sql->f("security");
         $urlArgs2 = $urlArgs;
         $urlArgs2['id']  = $id;
         $urlArgs2['action']  = 'folder_modify';
         print("<form action=\"dbmodify.php\">\n");
         print fGetHiddenFields ($urlArgs2);
         print("<table class=\"margin2\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
         print("<tr>\n");
         print("<td align=\"left\" valign=\"top\">\n");
         print("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
         fPrintFormTextLine($owl_lang->name . ":" , "name", 24, $sql->f("name"));

         if (fIsAdmin() || $userid == owlfoldercreator($id))
         {
            print("<tr>\n");
            print("<td class=\"form1\">>$owl_lang->ownership:</td>\n");
            print("<td class=\"form1\" width=\"100%\">");
            print("<select class=\"fpull1\" name=\"folder_owner\" size=\"1\">\n");
            foreach($users as $g)
            {
               print("<option value=\"$g[0]\" ");
               if ($g[0] == owlfoldercreator($id))
               {
                  print("selected=\"selected\"");
               }
               print(">$g[1]</option>\n");
            } 
            print("</select>\n</td>\n</tr>\n");
         } 


         /**
          * BEGIN Bozz Change
          * Display Retrieved Group information if the user is in the
          * Administrator group
          */
         if (fIsAdmin())
         {
            print("<tr>\n");
            print("<td class=\"form1\">$owl_lang->ownergroup:</td>\n");
            print("<td class=\"form1\" width=\"100%\">");
            print("<select class=\"fpull1\" name=\"groupid\" size=\"1\">\n");

            foreach($groups as $g)
            {
               print("<option value=\"$g[0]\" ");
               if ($g[0] == $sql->f("groupid"))
               {
                  print("selected=\"selected\"");
               } 
               print(">$g[1]</option>\n");
            } 
            print("</select>\n</td>\n</tr>\n");

            printgroupperm($security, "policy", $owl_lang->policy, "admin");
         } 
         else
         { 
            if ($userid == owlfoldercreator($id))
            {
               print("<tr>\n");
               print("<td class=\"form1\">$owl_lang->ownergroup:</td>\n");
               print("<td class=\"form1\" width=\"100%\">");
               print("<select class=\"fpull1\" name=\"groupid\" size=\"1\">\n");

               foreach($groups as $g)
               {
                  print("<option value=\"$g[0]\" ");
                  if ($g[0] == $sql->f("groupid"))
                  {
                     print("selected=\"selected\"");
                  }
                  print(">$g[1]</option>\n");
               }
               print("</select>\n</td>\n</tr>\n");

            }
            printgroupperm($security, "policy", $owl_lang->policy, "user");
         } 

         if ($default->display_password_override == 1)
         {
            if ($userid == owlfoldercreator($id) or fIsAdmin())
            {
               fPrintFormTextLine($owl_lang->newpassword . ":" , "newpassword", "", $sql->f("password"), "", false, "password");
               fPrintFormTextLine($owl_lang->confpassword . ":" , "confpassword", "", $sql->f("password"), "", false, "password");
            }
         }
         // ianm adding the prop. permissions checkbox
         if (fIsAdmin())
         {
            fPrintFormCheckBox($owl_lang->prop_permissions, "propagate", "1");
            print("<tr>\n");
            print("<td class=\"form1\">$owl_lang->prop_perms_files:</td>\n");
            print("<td class=\"form1\" width=\"100%\">");

            $file_perm[0][0] = -1; // added for the "do nothing" clause
            $file_perm[1][0] = 0;
            $file_perm[2][0] = 1;
            $file_perm[3][0] = 2;
            $file_perm[4][0] = 3;
            $file_perm[5][0] = 4;
            $file_perm[6][0] = 5;
            $file_perm[7][0] = 6;
            $file_perm[8][0] = 7;
            $file_perm[9][0] = 8;
   
            $file_perm[0][1] = "$owl_lang->donothing";
            $file_perm[1][1] = "$owl_lang->everyoneread_ad";
            $file_perm[2][1] = "$owl_lang->everyonewrite_ad";
            $file_perm[3][1] = "$owl_lang->groupread_ad";
            $file_perm[4][1] = "$owl_lang->groupwrite_ad";
            $file_perm[5][1] = "$owl_lang->onlyyou_ad";
            $file_perm[6][1] = "$owl_lang->groupwrite_ad_nod";
            $file_perm[7][1] = "$owl_lang->everyonewrite_ad_nod";
            $file_perm[8][1] = "$owl_lang->groupwrite_worldread_ad";
            $file_perm[9][1] = "$owl_lang->groupwrite_worldread_ad_nod";
   
            print("<select class=\"fpull1\" name=\"prop_file_sec\" size=\"1\">\n");
            //print("<SELECT NAME=prop_file_sec>");
            foreach($file_perm as $fp)
            {
               print("<option value=\"$fp[0]\" ");
               print(">$fp[1]</option>\n");
            }
            print("</select>\n</td>\n</tr>\n");
         }
         fPrintFormTextArea($owl_lang->description. ":", "description", $sql->f("description") );
         print("<tr>");
         print("<td class=\"form1\">");
         fPrintButtonSpace(1, 1);
         print("</td>");
         print("<td class=\"form2\" width=\"100%\">");
         fPrintSubmitButton($owl_lang->change, $owl_lang->alt_change);
         fPrintSubmitButton($owl_lang->btn_reset, $owl_lang->alt_reset_form, "reset");
         print("</td>");
         print("</tr>");
      }
      print("</table>\n");
      print("</td></tr></table>\n");
      print("</form>\n");
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
      printError($owl_lang->err_nofoldermod);
   } 
} 

if ($action == "bulk_email")
{
   printModifyHeader();
   $disp = unserialize(stripslashes($id));
   $sql = new Owl_DB;
   $sql->query("SELECT * from $default->owl_users_table where id = '$userid'");
   $sql->next_record();
   $default_reply_to = $sql->f("email");

   fPrintNavBar($parent, $owl_lang->emailing . ":&nbsp;");
   $query = "select * from $default->owl_files_table where ";
   foreach($disp as $fid)
   {
      if (check_auth($fid, "file_modify", $userid) == 1)
      {
               $query .= "id = '" . $fid . "' or ";
      }
   }

         $query .= "id = " . $fid . " and 1=1";
         $sql->query("$query");

   print("<table class=\"margin2\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
   print("<tr>\n");
   print("<td align=\"left\" valign=\"top\">\n");
   print("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">");
   fPrintSectionHeader($owl_lang->emailing . ":");
   while ($sql->next_record())
   {
      $fname = $sql->f("filename");
      fPrintSectionHeader("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$fname");
   }
   print("</table></td></tr></table>\n");

   $urlArgs2 = $urlArgs;
   $urlArgs2['id']     = $id;
   $urlArgs2['action'] = 'bulk_email';
   $urlArgs2['MAX_FILE_SIZE'] = $default->max_filesize;

   print("<form enctype=\"multipart/form-data\" action=\"dbmodify.php\" method=\"post\">\n");
   print fGetHiddenFields ($urlArgs2);
   if (!$default->use_smtp)
   {
      print("<input type=\"hidden\" name=\"ccto\" value=\"\"></input>\n");
   }
   print("<table class=\"margin2\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
   print("<tr>\n");
   print("<td align=\"left\" valign=\"top\">\n");
   print("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
   fPrintFormCheckBox($owl_lang->attach_file, "fileattached", "1");
   fPrintFormTextLine($owl_lang->email_to , "mailto");
   if ($default->use_smtp)
   {
      fPrintFormTextLine($owl_lang->email_cc , "ccto");
   }
    
   fPrintFormTextLine($owl_lang->email_reply_to , "replyto", 30, $default_reply_to);
   fPrintFormTextLine($owl_lang->email_subject , "subject", 80, $default->owl_email_subject);
                                                                                                                              
   fPrintFormTextArea($owl_lang->email_body . ":", "mailbody", "",20,80);
   print("<tr>\n");
   print("<td class=\"form1\">");
   fPrintButtonSpace(1, 1);
   print("</td>\n");         
   print("<td class=\"form2\" width=\"100%\">");
   fPrintSubmitButton($owl_lang->btn_send_email, $owl_lang->alt_send_email, "submit", "send_file_x");
   fPrintSubmitButton($owl_lang->btn_reset, $owl_lang->alt_reset_form, "reset");
   print("</td>\n");
   print("</tr>\n");
   print("</table>\n");
   print("</td></tr></table>\n");
   print("</form>\n");
   fPrintButtonSpace(12, 1);
   
   if ($default->show_prefs == 2 or $default->show_prefs == 3)
   {
      fPrintPrefs("infobar2");
   }
   print("</td></tr></table>\n");
   include("./lib/footer.inc");
} 

if ($action == "file_email")
{
   

   if (check_auth($id, "file_download", $userid) == 1)
   {
      printModifyHeader();
      print("<br />");

      $sql = new Owl_DB;
      $sql->query("SELECT * from $default->owl_users_table where id = '$userid'");
      $sql->next_record();
      $default_reply_to = $sql->f("email");

      fPrintNavBar($parent, $owl_lang->emailing . ":&nbsp;", $id);
      $urlArgs2 = $urlArgs;
      $urlArgs2['id']     = $id;
      $urlArgs2['action'] = 'file_email';
      $urlArgs2['type']   = $type;
      $urlArgs2['MAX_FILE_SIZE'] = $default->max_filesize;


      print("<form enctype=\"multipart/form-data\" action=\"dbmodify.php\" method=\"post\">\n");
      print fGetHiddenFields ($urlArgs2);
      if (!$default->use_smtp)
      {
         print("<input type=\"hidden\" name=\"ccto\" value=\"\"></input>\n");
      }
      print("<table class=\"margin2\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
      print("<tr>\n");
      print("<td align=\"left\" valign=\"top\">\n");
      print("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
      fPrintFormCheckBox($owl_lang->attach_file , "fileattached", "1", "checked");
      fPrintFormTextLine($owl_lang->email_to , "mailto");

      $aEmailList = fGetUserInfoInMyGroups($userid, "email <> ''");

      print("<tr>\n");
      print("<td class=\"form1\">&nbsp;</td>\n");
      print("<td class=\"form1\" width=\"100%\">");
      print("<select class=\"fpull1\" name=\"pick_mailto\" size=\"1\">\n");
      print("<option value=\"\" >" . $owl_lang->pick_select . "</option>\n");

      //while ($sql->next_record())
      foreach ($aEmailList as $aUsers)
      {
         $sUsername = $aUsers["username"];
         $sName = $aUsers["name"];
         $sEmail = $aUsers["email"];

         if ($sName == "")
         {
            print("<option value=\"" . $sEmail . "\">" . $sUsername . " - (" . $sEmail . ")</option>\n");
         } 
         else
         {
            print("<option value=\"" . $sEmail . "\">" . $sName . " - (" . $sEmail . ")</option>\n");
         }
      } 
      print("</select>\n</td>\n</tr>\n");
 
      if ($default->use_smtp)
      {
         fPrintFormTextLine($owl_lang->email_cc , "ccto");
      }

      fPrintFormTextLine($owl_lang->email_reply_to , "replyto", 30, $default_reply_to);
      fPrintFormTextLine($owl_lang->email_subject , "subject", 80, $default->owl_email_subject);
      fPrintFormTextArea($owl_lang->email_body . ":", "mailbody", "",20,80);
      print("<tr>\n");
      print("<td class=\"form1\">");
      fPrintButtonSpace(1, 1);
      print("</td>\n");
      print("<td class=\"form2\" width=\"100%\">");
      fPrintSubmitButton($owl_lang->btn_send_email, $owl_lang->alt_send_email, "submit", "send_file_x");
      fPrintSubmitButton($owl_lang->btn_reset, $owl_lang->alt_reset_form, "reset");
      print("</td>\n");
      print("</tr>\n");
      print("</table>\n");
      print("</td></tr></table>\n");
      print("</form>\n");
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
      printError($owl_lang->err_noemail);
   } 
} 

?>
