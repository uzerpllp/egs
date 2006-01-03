<?php

/**
 * index.php
 * 
 * Copyright (c) 1999-2005 The Owl Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 *
 * Author: Steve Bourgeois <owl@bozzit.com>
 * Project Founder: Chris Vincent <cvincent@project802.net>
 * 
 * $Id: index.php,v 1.28 2005/03/22 11:47:59 carlostrub Exp $
 */

require("../config/owl.php");
require("../lib/disp.lib.php");
require("../lib/owl.lib.php");

if (!fIsAdmin(true)) 
{
   die("<br /><center>$owl_lang->err_unauthorized</center><br />");
}

if ($action == "backup") 
{
   dobackup();
}

include("../lib/header.inc");
include("../lib/userheader.inc");

print("<center>");
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



if (!isset($action)) 
{
   $action = "JUNK";
}

function printusers()
{
   global $sess, $default, $owl_lang, $owluser;
   $sql = new Owl_DB;
   $sql_active_sess = new Owl_DB;

   $sql->query("select username,name,id,maxsessions from $default->owl_users_table order by name");

   fPrintSectionHeader("$owl_lang->header_user_admin");
   print("<tr>\n");
   print("<td class='form1'>$owl_lang->users:</td>\n");
   print("<td class='form1' width='100%'>");
   print("<select class='fpull1' name='owluser' size='1'>\n");
                                                                                                                                                                                                  
   while ($sql->next_record())
   {
      $uid = $sql->f("id");
      $username = $sql->f("username");
      $name = $sql->f("name");
      $maxsess = $sql->f("maxsessions") + 1;
      $numrows = 0;

      $sql_active_sess->query("select * from $default->owl_sessions_table where usid = $uid");
      $sql_active_sess->next_record();
      $numrows = $sql_active_sess->num_rows($sql_active_sess);

      if ($name == "")
      {
         if ($uid == $owluser)
         {
            print("\t\t\t\t\t\t\t\t<option value='" . $uid . "' selected='selected'>" . $username . "&nbsp;&nbsp;&#8211;&nbsp;&nbsp;(" . $numrows . "/" . $maxsess . ")</option>\n");
         }
         else
         {
            print("\t\t\t\t\t\t\t\t<option value='" . $uid . "' >" . $username . "&nbsp;&nbsp;&#8211;&nbsp;&nbsp;(" . $numrows . "/" . $maxsess . ")</option>\n");
         }
      }
      else
      {
         if ($uid == $owluser)
         {
            print("\t\t\t\t\t\t\t\t<option value='" . $uid . "' selected='selected'>" . $name . "&nbsp;&nbsp;&#8211;&nbsp;&nbsp;(" . $numrows . "/" . $maxsess . ")</option>\n");
         } 
         else
         {
            print("\t\t\t\t\t\t\t\t<option value='" . $uid . "' >" . $name . "&nbsp;&nbsp;&#8211;&nbsp;&nbsp;(" . $numrows . "/" . $maxsess . ")</option>\n");
         } 
     }
   } 

   print("</select></td></tr>");
   print("<tr>");
   print("<td class='form1'>");
   fPrintButtonSpace(1, 1);
   print("</td>");
   print("<td class='form2' width='100%'>");
   print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
   print("\t<tr>\n");
   print("<td width='100%'>&nbsp;</td>");
   fPrintButton("index.php?sess=$sess&amp;action=newuser", "btn_admin_users");
   print("<td>");
   fPrintSubmitButton($owl_lang->btn_edit_user, $owl_lang->alt_edit_user, "submit", "btn_ed_user_x");
   print("</td>");
   print("\t</tr></table>\n");
   print("</td></tr>");
   } 

   function printgroups()
   {
      global $sess, $owl_lang, $default, $group;
      $sql = new Owl_DB;
      $sql->query("select name,id from $default->owl_groups_table order by name");
      //print("<input type='hidden' name='action' value='groups'></input>\n");
      fPrintSectionHeader("$owl_lang->header_group_admin");
      print("<tr>\n");
      print("<td class='form1'>$owl_lang->groups:</td>\n");
      print("<td class='form1' width='100%'>");
      print("<select class='fpull1' name='group' size='1'>\n");
      while ($sql->next_record())
      {
         if ($group == $sql->f("id"))
         {
            print("\t\t\t\t\t\t\t\t<option value='" . $sql->f("id") . "' selected='selected'>" . $sql->f("name") . "</option>\n");
         } 
         else
         {
            print("\t\t\t\t\t\t\t\t<option value='" . $sql->f("id") . "'>" . $sql->f("name") . "</option>\n");
         } 
      } 
      print("\t\t\t\t\t\t\t</select>\n\t\t\t\t\t\t</td>\n</tr>\n");
   print("<tr>");
   print("<td class='form1'>");
   fPrintButtonSpace(1, 1);
   print("</td>");
   print("<td class='form2' width='100%'>");
   print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
   print("\t<tr>\n");
   print("<td width='100%'>&nbsp;</td>");
   fPrintButton("index.php?sess=$sess&amp;action=newgroup", "btn_admin_groups");
   print("<td>");
   fPrintSubmitButton($owl_lang->btn_edit_group, $owl_lang->alt_edit_group, "submit", "btn_ed_group_x");
   print("</td>");
   print("\t</tr></table>\n");
   print("</td></tr>");
   } 

   function printuser($id)
   {
      global $sess, $change, $default, $flush;
      global $owl_lang;

      if ($change == 1) 
      {
         fPrintSectionHeader($owl_lang->saved, "admin3");
      }

      if ($flush == 1)
      {
         flushsessions($id, $sess);
         fPrintSectionHeader($owl_lang->flushed, "admin3");
      } 

      $groups = fGetGroups($userid);

      $sql = new Owl_DB;
      $sql->query("select * from $default->owl_users_table where id = '$id'");
      while ($sql->next_record())
      {
         print("<tr><td colspan='2'><input type='hidden' name='id' value='" . $sql->f("id") . "'></input></td></tr>");
         print("<tr><td colspan='2'><input type='hidden' name='sess' value='$sess'></input></td></tr>");
         print("<tr><td colspan='2'><input type='hidden' name='oldlanguage' value='" . $sql->f("language") . "'></input></td></tr>");
         print("<tr><td colspan='2'><input type='hidden' name='action' value='user'></input></td></tr>");
         fPrintFormTextLine($owl_lang->full_name . ":" , "name", 40, $sql->f("name"));
         fPrintFormTextLine($owl_lang->username . ":" , "edit_loginname", 40, $sql->f("username"));
         if ( $sql->f("groupid") > 0 )
         {
            fPrintFormSelectBox($owl_lang->group . ":" , "groupid", $groups, $sql->f("groupid"));
         }
         else
         {
            print("<tr><td colspan='2'><input type='hidden' name='groupid' value='" . $sql->f("groupid") . "'></input></td></tr>");
         }
         // 
         // Display the Language dropdown
         // 
         print("<tr>\n");
         print("<td class='form1'>$owl_lang->userlang:</td>\n");
         print("<td class='form1' width='100%'>");
         print("<select class='fpull1' name='newlanguage' size='1'>");

         $dir = dir($default->owl_LangDir);
         $dir->rewind();

         while ($file = $dir->read())
         {
            if ($file != "." and $file != ".." and $file != "CVS" and $file != "favicon.ico")
            {
               print("<option value='$file'");
               if ($file == $sql->f("language"))
               {
                  print (" selected='selected'");
               }
               print(">$file</option>\n");
            }
         } 
         $dir->close();
         print("</select></td></tr>"); 

         // 
         // Display the Button Styles dropdown
         // 
         print("<tr>\n");
         print("<td class='form1'>$owl_lang->buttonstyle:</td>\n");
         print("<td class='form1' width='100%'>");
         print("<select class='fpull1' name='newbuttons' size='1'>");
         $dir = dir($default->owl_fs_root . "/graphics");
         //$dir = dir($default->owl_LangDir . "/" . $default->owl_lang . "/graphics");
         $dir->rewind();

         while ($file = $dir->read())
         {
            if ($file != "." and $file != ".." and $file != "CVS" and $file != "favicon.ico")
            {
               print("<option value='$file'");
               if ($file == $sql->f("buttonstyle"))
               {
                  print (" selected='selected'");
               }
               print(">$file</option>\n");
            }
         } 
         $dir->close();
         print("</select></td></tr>"); 

         // Bozz Change  begin
         // This is to allow a user to be part of more than one group
         print("<tr>\n");
         print("<td class='form1'>$owl_lang->groupmember:</td>\n");
         print("<td class='form1' width='100%'>");
         $i = 0;
         $sqlmemgroup = new Owl_DB;
         foreach($groups as $g)
         {
            $is_set_gid = $g[0];
            $sqlmemgroup->query("select userid from $default->owl_users_grpmem_table where userid = '$id' and groupid = '$is_set_gid'");
            $sqlmemgroup->next_record(); if ($sqlmemgroup->num_rows($sqlmemgroup) > 0)
            {
               print("<input class='fcheckbox1' type='checkbox' name='group$i' value='$g[0]' checked='checked'></input>$g[1]<br />");
            } 
            else
            {
               print("<input class='fcheckbox1' type='checkbox' name='group$i' value='$g[0]'></input>$g[1]<br />");
            } 
            $i++;
         } 
         print("</td></tr>");
         // This hidden field is to store the nubmer of displayed groups for future use
         // when the records are saved to the db
         print("<tr><td colspan='2'><input type='hidden' name='no_groups_displayed' value='$i'></input></td></tr>"); 
         // Bozz Change End

         // Display the Directories so a Home Directory may be chosen.

         print("<td class='form1'>$owl_lang->home_dir:</td>\n");
         print("<td class='form1' width='100%'>");
         print("<select class='fpull1' name='homedir' size='1'>");
         print("<option value='1' selected='selected'>Documents</option>\n");
         fPrintHomeDir("1", "--|", $sql->f("homedir"));
         print("</select>\n</td>\n</tr>\n");

         print("<tr>\n");
         print("<td class='form1'>$owl_lang->initial_dir:</td>\n");
         print("<td class='form1' width='100%'>");
         print("<select class='fpull1' name='firstdir' size='1'>");
         print("<option value='1' selected='selected'>Documents</option>\n");
         fPrintHomeDir("1", "--|", $sql->f("firstdir"));
         print("</select>\n</td>\n</tr>\n");

         fPrintFormTextLine($owl_lang->quota . ": &nbsp; &nbsp; " . $sql->f("quota_current") . " /", "quota", 20, $sql->f("quota_max"));

         print("<tr>\n");
         print("<td class='form1'>$owl_lang->maxsessions" . ": &nbsp; &nbsp; &nbsp;" . ($sql->f("maxsessions") + 1) . " / </td>\n");
         print("<td class='form1' width='100%'><input class='finput1' type='test' name='maxsessions' size='10' maxlength='255' value='" . ($sql->f("maxsessions") + 1) . "'>&nbsp;&nbsp;&nbsp;");
         fPrintAdminButton("index.php?sess=$sess&amp;action=user&amp;owluser=$id&amp;change=0&amp;flush=1", admin_flush);
         print("</td>\n");
         print("</tr>\n");
         print("</td></tr>");
         if ($default->auth == 0)
         {
            print("<tr>\n");
            print("<td class='form1'>$owl_lang->password:</td>\n");
            print("<td class='form1' width='100%'><input class='finput1' type='password' name='edit_password' size='15' maxlength='255' value='" . $sql->f("password") . "' onfocus='document.admin.edit_password.value=\"\"'>");
            print("</td>\n");
            print("</tr>\n");
         }
         fPrintFormTextLine($owl_lang->email . ":" , "email", 40, $sql->f("email"));
         if ($sql->f("notify") == 1)
         {
            fPrintFormCheckBox($owl_lang->notification . ":" , "notify", "1", "checked");
         }
         else
         {
            fPrintFormCheckBox($owl_lang->notification . ":" , "notify", "1");
         }
         if ($sql->f("attachfile") == 1)
         {
            fPrintFormCheckBox($owl_lang->attach_file . ":" , "attachfile", "1", "checked");
         }
         else
         {
            fPrintFormCheckBox($owl_lang->attach_file . ":" , "attachfile", "1");
         }

         if ($id != 1)
         {
            if ($sql->f("disabled") == 1)
            {
               fPrintFormCheckBox($owl_lang->disableuser . ":" , "disabled", "1", "checked");
            }
            else
            {
               fPrintFormCheckBox($owl_lang->disableuser . ":" , "disabled", "1");
            }
            if ($sql->f("noprefaccess") == 1)
            {
               fPrintFormCheckBox($owl_lang->noprefaccess . ":" , "noprefaccess", "1", "checked");
            }
            else
            {
               fPrintFormCheckBox($owl_lang->noprefaccess . ":" , "noprefaccess", "1");
            }
            if ($sql->f("newsadmin") == 1)
            {
               fPrintFormCheckBox($owl_lang->newsadmin . ":" , "newsadmin", "1", "checked");
            }
            else
            {
               fPrintFormCheckBox($owl_lang->newsadmin . ":" , "newsadmin", "1");
            }
         } 
         if ($sql->f("comment_notify") == 1)
         {
            fPrintFormCheckBox($owl_lang->comment_notif . ":" , "comment_notify", "1", "checked");
         }
         else
         {
            fPrintFormCheckBox($owl_lang->comment_notif . ":" , "comment_notify", "1");
         }

         if ($sql->f("email_tool") == 1)
         {
            fPrintFormCheckBox($owl_lang->email_tool . ":" , "email_tool", "1", "checked");
         }
         else
         {
            fPrintFormCheckBox($owl_lang->email_tool . ":" , "email_tool", "1");
         }
      print("<tr>\n");
      print("<td class='form2' width='100%' colspan='2'>\n");
      fPrintSubmitButton($owl_lang->change, $owl_lang->alt_change);


         $qItemCount = new Owl_DB;
         $qItemCount->query("SELECT count(*) as num_files from $default->owl_files_table where creatorid='$id'");
         $qItemCount->next_record();
         $iNumFiles = $qItemCount->f("num_files");
         $qItemCount->query("SELECT count(*) as num_folders from $default->owl_folders_table where creatorid='$id'");
         $qItemCount->next_record();
         $iNumFolders = $qItemCount->f("num_folders");

         if ($sql->f("id") != 1 && $sql->f("id") != $default->anon_user)
         {
            if ( $iNumFolders > 0 or $iNumFiles > 0 )
            {
               $sDeleteMessage = ereg_replace('%numfiles%', $iNumFiles ,ereg_replace('%numfolders%', $iNumFolders, $owl_lang->reallydeluser));
               fPrintSubmitButton($owl_lang->deleteuser, $owl_lang->alt_del_user, "submit", "bdeleteuser_x", $sDeleteMessage);
            }
            else
            {
               fPrintSubmitButton($owl_lang->deleteuser, $owl_lang->alt_del_user, "submit", "bdeleteuser_x");
            }
         } 
      fPrintSubmitButton($owl_lang->btn_reset, $owl_lang->alt_reset_form, "reset");
      print("</td>\n");
      print("</tr>\n");
      } 
   } 

   function flushsessions($id, $sess)
   {
      global $default;
      $sql = new Owl_DB;
      $sql->query("delete from $default->owl_sessions_table where usid='$id' AND sessid!='$sess'");
   } 

   function printgroup($id)
   {
      global $sess, $change, $default;
      global $owl_lang;

      if (isset($change)) 
      {
         fPrintSectionHeader($owl_lang->saved, "admin3");
      }
      $sql = new Owl_DB;
      $sql->query("select id,name from $default->owl_groups_table where id = '$id'");
      while ($sql->next_record())
      {
         fPrintFormTextLine($owl_lang->title . ":" , "name", 40, $sql->f("name"));
         print("<tr>\n");
         print("<td class='form2' width='100%' colspan='2'>\n");
         print("<tr><td colspan='2'><input type='hidden' name='id' value='" . $sql->f("id") . "'></input></td></tr>");
         print("<tr><td colspan='2'><input type='hidden' name='sess' value='$sess'></input></td></tr>");
         print("<tr><td colspan='2'><input type='hidden' name='action' value='group'></input></td></tr>");
         fPrintSubmitButton($owl_lang->change, $owl_lang->alt_change);
         if ($sql->f("id") != 0 && $sql->f("id") != 1)
         {
         fPrintSubmitButton($owl_lang->deletegroup, $owl_lang->alt_del_group, "submit", "bdeletegroup_x");
         } 
         fPrintSubmitButton($owl_lang->btn_reset, $owl_lang->alt_reset_form, "reset");
         print("</td>\n");
         print("</tr>\n");
      } 
      fPrintSectionHeader($owl_lang->owl_group_user);
      $sql->query("select distinct username,name,id,maxsessions,u.groupid from $default->owl_users_table u left join $default->owl_users_grpmem_table m on u.id=m.userid where u.groupid=$id or m.groupid=$id order by name");
      while ($sql->next_record())
      {
         $uid = $sql->f("id");
         $username = $sql->f("username");
         $name = $sql->f("name");
         $maxsess = $sql->f("maxsessions") + 1;
         $numrows = 0;

         if ($name == "")
         {
            print("<tr><td class='form1'>&nbsp;</td><td class='form1' width='100%'><a class='lfile1' href='index.php?sess=$sess&amp;action=users&amp;owluser=" . $uid . "'>" . $username . "</a></td></tr>");
         }
         else
         {
            print("<tr><td class='form1'>&nbsp;</td><td class='form1' width='100%' colspan='2'><a class='lfile1' href='index.php?sess=$sess&amp;action=users&amp;owluser=" . $uid . "'>" . $name . "</a></td></tr>");
         }
      } 
   } 

   function printnewgroup()
   {
      global $default, $sess, $owl_lang;

      fPrintFormTextLine($owl_lang->title . ":" , "name", 40);
      print("<tr>\n");
      print("<td class='form2' width='100%' colspan='2'>\n");
      fPrintSubmitButton($owl_lang->add, $owl_lang->alt_add_group);
      fPrintSubmitButton($owl_lang->btn_reset, $owl_lang->alt_reset_form, "reset");
      print("</td>\n");
      print("</tr>\n");
   } 

   function printnewuser()
   {
      global $sess, $owl_lang, $default;

      $groups = fGetGroups($userid);
      fPrintFormTextLine($owl_lang->full_name . ":" , "name", 40);
      fPrintFormTextLine($owl_lang->username . ":" , "edit_loginname", 40);
      fPrintFormSelectBox($owl_lang->group . ":" , "groupid", $groups);
       print("<tr>\n");
         print("<td class='form1'>$owl_lang->userlang:</td>\n");
         print("<td class='form1' width='100%'>");
         print("<select class='fpull1' name='newlanguage' size='1'>");
                                                                                                                                                                                       
         $dir = dir($default->owl_LangDir);
         $dir->rewind();
                                                                                                                                                                                       
         while ($file = $dir->read())
         {
            if ($file != "." and $file != ".." and $file != "CVS" and $file != "favicon.ico")
            {
               print("<option value='$file'");
               if ($file == $default->owl_lang)
               {
                  print (" selected='selected'");
               }
               print(">$file</option>\n");
            }
         }
         $dir->close();
         print("</select></td></tr>");


      // Bozz Change  begin
      // This is to allow a user to be part of more than one group

      print("<tr>\n");
      print("<td class='form1'>$owl_lang->groupmember:</td>\n");
      print("<td class='form1' width='100%'>");
      $i = 0;
      foreach($groups as $g)
      {
         print("<input class='fcheckbox1' type='checkbox' name='group$i' value='$g[0]'></input>$g[1]<br />");
         $i++;
      } 
      // This hidden field is to store the nubmer of displayed groups for future use
      // when the records are saved to the db
      print("<input type='hidden' name='no_groups_displayed' value='$i'></input>"); 
      // Bozz Change End
      print("</td></tr>");
      
      // Display the Directories so a Home Directory may be chosen.

      print("<tr>\n");
      print("<td class='form1'>$owl_lang->home_dir:</td>\n");
      print("<td class='form1' width='100%'>");
      print("<select class='fpull1' name='homedir'>");
      print("<option value='1' selected='selected'>Documents</option>\n");
      fPrintHomeDir("1", "--|", $homedir);
      print("</select>\n</td>\n</tr>\n");
	
      print("<tr>\n");
      print("<td class='form1'>$owl_lang->initial_dir:</td>\n");
      print("<td class='form1' width='100%'>");
      print("<select class='fpull1' name='firstdir' size='1'>");
      print("<option value='1' selected='selected'>Documents</option>\n");
      fPrintHomeDir("1", "--|", $firstdir);
      print("</select>\n</td>\n</tr>\n");

      fPrintFormTextLine($owl_lang->quota . ":" , "quota", 20, 0);
      fPrintFormTextLine($owl_lang->maxsessions . ":" , "maxsessions", 20, 1);
      if ($default->auth == 0)
      {
         fPrintFormTextLine($owl_lang->password . ":" , "edit_password", 20, "" ,"", "", "password");
      }
      fPrintFormTextLine($owl_lang->email . ":" , "email", 40);
      fPrintFormCheckBox($owl_lang->notification, "notify", "1");
      fPrintFormCheckBox($owl_lang->attach_file, "attachfile", "1");
      fPrintFormCheckBox($owl_lang->disableuser, "disabled", "1");
      fPrintFormCheckBox($owl_lang->noprefaccess, "noprefaccess", "1");
      fPrintFormCheckBox($owl_lang->newsadmin, "newsadmin", "1");
      fPrintFormCheckBox($owl_lang->comment_notif, "comment_notif", "1");
      fPrintFormCheckBox($owl_lang->email_tool, "email_tool", "1");
      print("<tr>\n");
      print("<td class='form2' width='100%' colspan='2'>\n");
      fPrintSubmitButton($owl_lang->add, $owl_lang->alt_add_user);
      fPrintSubmitButton($owl_lang->btn_reset, $owl_lang->alt_reset_form, "reset");
      print("</td>\n");
      print("</tr>\n");
   } 

   function printhtml()
   {
      global $default, $sess, $owl_lang, $change;

      if (isset($change)) 
      {
         fPrintSectionHeader($owl_lang->saved, "admin3");
      }
      fPrintSectionHeader("HTML Preferences");
      print("<tr><td colspan='2'><input type='hidden' name='action' value='edhtml'></input></td></tr>");
      print("<tr><td colspan='2'><input type='hidden' name='type' value='html'></input></td></tr>");
      print("<tr><td colspan='2'><input type='hidden' name='sess' value='$sess'></input></td></tr>");
      fPrintFormTextLine($owl_lang->ht_expand_width, "expand_width", 10, $default->table_expand_width);
      fPrintFormTextLine($owl_lang->ht_collapse_width, "collapse_width", 10, $default->table_collapse_width);
      fPrintFormTextLine($owl_lang->ht_bd_bg_image, "body_background", 80, $default->body_background);
      fPrintFormTextLine($owl_lang->owl_logo, "owl_logo", 80, $default->owl_logo);
      print("<tr>\n");
      print("<td class='form2' width='100%' colspan='2'>\n");
      fPrintSubmitButton($owl_lang->change, $owl_lang->alt_change);
      fPrintSubmitButton($owl_lang->btn_reset, $owl_lang->alt_reset_form, "reset");
      print("</td>\n");
      print("</tr>\n");

      print("<tr><td bgcolor='$default->table_header_bg' align='right'>$owl_lang->ht_bd_txt_cl</td>
                   <td align=left><input type=text name='body_textcolor' value='$default->body_textcolor'></td></tr>");
      print("<tr><td bgcolor='$default->table_header_bg' align='right'>$owl_lang->ht_bd_lnk_cl</td>
                   <td align=left><input type=text name='body_link' value='$default->body_link'></td></tr>");
      print("<tr><td bgcolor='$default->table_header_bg' align='right'>$owl_lang->ht_bd_vlnk_cl</td>
                   <td align=left><input type=text name='body_vlink' value='$default->body_vlink'></td></tr>");


      if (file_exists("$default->owl_graphics_url/$default->sButtonStyle/info.txt"))
      {
         $sFileContent = file_get_contents("$default->owl_graphics_url/$default->sButtonStyle/info.txt");
         print("<pre>$sFileContent</pre>");
      }
   } 

   function printprefs()
   {
      global $default, $sess, $owl_lang, $change;
      if (isset($change)) 
      {
         fPrintSectionHeader($owl_lang->saved, "admin3");
      }
  


      // 
      // Load all users to an array
      // 
      $sql = new Owl_DB;
      $sql->query("select id,name from $default->owl_users_table");
      $i = 0;
      while ($sql->next_record())
      {
         $users[$i][0] = $sql->f("id");
         $users[$i][1] = $sql->f("name");
         $i++;
      } 
      // 
      // Load all groups to an array
      // 
      $groups = fGetGroups($userid);

      print("<tr><td><input type='hidden' name='action' value='edprefs'></input>\n");
      print("<input type='hidden' name='type' value='html'></input>\n");
      print("<input type='hidden' name='sess' value='$sess'></input></td></tr>\n");

      fPrintSectionHeader($owl_lang->owl_title_email);

      if ($default->use_smtp == 1)
      {
         fPrintFormCheckBox($owl_lang->owl_email_smtp . ":" , "use_smtp", "1", "checked");
      }
      else
      {
         fPrintFormCheckBox($owl_lang->owl_email_smtp . ":" , "use_smtp", "1");
      }
      if ($default->use_smtp_auth == 1)
      {
         fPrintFormCheckBox($owl_lang->owl_email_smtp_auth . ":" , "use_smtp_auth", "1", "checked");
      }
      else
      {
         fPrintFormCheckBox($owl_lang->owl_email_smtp_auth . ":" , "use_smtp_auth", "1");
      }
      fPrintFormTextLine($owl_lang->owl_email_server, "email_server", 40, $default->owl_email_server);
      fPrintFormTextLine($owl_lang->owl_email_from, "email_from", 40, $default->owl_email_from);
      fPrintFormTextLine($owl_lang->owl_email_smtp_auth_login, "smtp_auth_login", 40, $default->smtp_auth_login);
      fPrintFormTextLine($owl_lang->owl_email_smtp_auth_passwd . ":", "smtp_passwd", 40, $default->smtp_passwd);
      fPrintFormTextLine($owl_lang->owl_email_fromname , "email_fromname", 40, $default->owl_email_fromname);
      fPrintFormTextLine($owl_lang->owl_email_replyto , "email_replyto", 40, $default->owl_email_replyto);
      fPrintFormTextLine($owl_lang->owl_email_subject_pref , "email_subject", 60, $default->owl_email_subject);
      if ($default->owl_use_fs)
      {
         fPrintSectionHeader($owl_lang->owl_title_HD);
         if ($default->owl_LookAtHD == "false")
         {
            fPrintFormCheckBox($owl_lang->owl_lookAtHD . ":" , "lookAtHD", "false", "checked");
            print("<tr><td colspan='2'><input type='hidden' name='lookAtHD_del' value='$default->owl_lookAtHD_del'></input></td></tr>");
            print("<tr><td colspan='2'><input type='hidden' name='def_file_security' value='$default->owl_def_file_security'></input></td></tr>");
            print("<tr><td colspan='2'><input type='hidden' name='def_file_group_owner' value='$default->owl_def_file_group_owner'></input></td></tr>");
            print("<tr><td colspan='2'><input type='hidden' name='def_file_owner' value='$default->owl_def_file_owner'></input></td></tr>");
            print("<tr><td colspan='2'><input type='hidden' name='def_file_title' value='$default->owl_def_file_title'></input></td></tr>");
            print("<tr><td colspan='2'><input type='hidden' name='def_file_meta'  value='$default->owl_def_file_meta'></input></td></tr>");
            print("<tr><td colspan='2'><input type='hidden' name='def_fold_security' value='$default->owl_def_fold_security'></input></td></tr>");
            print("<tr><td colspan='2'><input type='hidden' name='def_fold_group_owner' value='$default->owl_def_fold_group_owner'></input></td></tr>");
            print("<tr><td colspan='2'><input type='hidden' name='def_fold_owner' value='$default->owl_def_fold_owner'></input></td></tr>");
         } 
         else
         {
            fPrintFormCheckBox($owl_lang->owl_lookAtHD, "lookAtHD", "false");
            if ($default->owl_lookAtHD_del == 1)
            {
               fPrintFormCheckBox($owl_lang->owl_lookAtHDDel, "lookAtHD_del", "1", "checked");
            }
            else 
            {
               fPrintFormCheckBox($owl_lang->owl_lookAtHDDel, "lookAtHD_del", "1");
            }
            printfileperm($default->owl_def_file_security, "def_file_security", $owl_lang->owl_def_file_security, "user");

	    fPrintFormSelectBox($owl_lang->owl_def_file_group_owner, "def_file_group_owner", $groups, $default->owl_def_file_group_owner);
	    fPrintFormSelectBox($owl_lang->owl_def_file_owner, "def_file_owner", $users, $default->owl_def_file_owner);
            fPrintFormTextLine($owl_lang->owl_def_file_title , "def_file_title", "40", $default->owl_def_file_title);
            fPrintFormTextLine($owl_lang->owl_def_file_meta , "def_file_meta", "40", $default->owl_def_file_meta);
            printgroupperm($default->owl_def_fold_security, "def_fold_security", $owl_lang->owl_def_fold_sec, "user");
	    fPrintFormSelectBox($owl_lang->owl_def_fold_group_owner, "def_fold_group_owner", $groups, $default->owl_def_fold_group_owner);
	    fPrintFormSelectBox($owl_lang->owl_def_fold_owner, "def_fold_owner", $users, $default->owl_def_fold_owner);
         } 
      } 
      else
      { 
         // 
         // IF owl Use Fs is fals the LookAtHd feature is not
         // shown the following lines are to preserve the values
         // in the database when something else is changed.
         // 
         print("<tr><td colspan='2'><input type='hidden' name='lookAtHD' value='$default->owl_LookAtHD'></input></td></tr>");
         print("<tr><td colspan='2'><input type='hidden' name='lookAtHD_del' value='$default->owl_lookAtHD_del'></input></td></tr>");
         print("<tr><td colspan='2'><input type='hidden' name='def_file_security' value='$default->owl_def_file_security'></input></td></tr>");
         print("<tr><td colspan='2'><input type='hidden' name='def_file_group_owner' value='$default->owl_def_file_group_owner'></input></td></tr>");
         print("<tr><td colspan='2'><input type='hidden' name='def_file_owner' value='$default->owl_def_file_owner'></input></td></tr>");
         print("<tr><td colspan='2'><input type='hidden' name='def_file_title' value='$default->owl_def_file_title'></input></td></tr>");
         print("<tr><td colspan='2'><input type='hidden' name='def_file_meta'  value='$default->owl_def_file_meta'></input></td></tr>");
         print("<tr><td colspan='2'><input type='hidden' name='def_fold_security' value='$default->owl_def_fold_security'></input></td></tr>");
         print("<tr><td colspan='2'><input type='hidden' name='def_fold_group_owner' value='$default->owl_def_fold_group_owner'></input></td></tr>");
         print("<tr><td colspan='2'><input type='hidden' name='def_fold_owner' value='$default->owl_def_fold_owner'></input></td></tr>");
      } 
      // 
      // OWL BROWSER FEATURES
      // 
   fPrintSectionHeader($owl_lang->owl_title_browser);

   $status_bar[0] = $owl_lang->hide_panel;
   $status_bar[1] = $owl_lang->show_panel;
   fPrintFormRadio($owl_lang->show_panel_title, "status_bar_location", $default->show_file_stats, $status_bar);

   $status_bar[0] = $owl_lang->status_bar_not;
   $status_bar[1] = $owl_lang->status_bar_top;
   $status_bar[2] = $owl_lang->status_bar_bottom;
   $status_bar[3] = $owl_lang->status_bar_both;

   fPrintFormRadio($owl_lang->show_pref_title, "pref_bar", $default->show_prefs, $status_bar);
   fPrintFormRadio($owl_lang->show_search_title, "search_bar", $default->show_search, $status_bar);
   fPrintFormRadio($owl_lang->show_bulk_title, "bulk_buttons", $default->show_bulk, $status_bar);
   fPrintFormRadio($owl_lang->show_action_title, "action_buttons", $default->show_action, $status_bar);
   fPrintFormRadio($owl_lang->show_folder_title, "folder_tools", $default->show_folder_tools, $status_bar);

   if ($default->display_password_override == 1)
   {
      fPrintFormCheckBox($owl_lang->display_password_override . ":" , "password_override", "1", "checked");
   }
   else 
   {
      fPrintFormCheckBox($owl_lang->display_password_override . ":" , "password_override", "1");
   }

   if ($default->hide_folder_doc_count == 1)
   {
      fPrintFormCheckBox($owl_lang->hide_folder_doc_count . ":" , "hide_folder_doc_count", "1", "checked");
   }
   else 
   {
      fPrintFormCheckBox($owl_lang->hide_folder_doc_count . ":" , "hide_folder_doc_count", "1");
   }

   if ($default->hide_folder_size == 1)
   {
      fPrintFormCheckBox($owl_lang->hide_folder_size . ":" , "hide_folder_size", "1", "checked");
   }
   else 
   {
      fPrintFormCheckBox($owl_lang->hide_folder_size . ":" , "hide_folder_size", "1");
   }
   if ($default->use_zip_for_folder_download == 1)
   {
      fPrintFormCheckBox($owl_lang->download_folder_zip . ":" , "use_zip", "1", "checked");
   }
   else 
   {
      fPrintFormCheckBox($owl_lang->download_folder_zip . ":" , "use_zip", "1");
   }

   if ($default->old_action_icons == 1)
   {
      fPrintFormCheckBox($owl_lang->old_action_icons . ":" , "old_action_icons", "1", "checked");
   }
   else 
   {
      fPrintFormCheckBox($owl_lang->old_action_icons . ":" , "old_action_icons", "1");
   }

   if ($default->search_result_folders == 1)
   {
      fPrintFormCheckBox($owl_lang->search_result_folders . ":" , "search_result_folders", "1", "checked");
   }
   else 
   {
      fPrintFormCheckBox($owl_lang->search_result_folders . ":" , "search_result_folders", "1");
   }


   fPrintSectionHeader($owl_lang->owl_title_custom);
   print("<tr>\n");
   print("<td class='form1'>" . $owl_lang->btn_expand_view . ":</td>\n");
   print("<td class='form1' width='100%'>\n");
   print("<table>\n<tr>\n");
   print("<td class='form1' width='60'>$owl_lang->status_column<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->doc_number<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->docicon_column<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->title<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->ver<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->file<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->size<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->postedby<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->modified<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->actions<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->held<br /></td>\n");
   print("</tr>\n");
   print("<tr>\n");
   if ($default->expand_disp_status)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='expand_disp_status' value='1' $checked></input></td>\n");
   if ($default->expand_disp_doc_num)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='expand_disp_doc_num' value='1' $checked></input></td>\n");
   if ($default->expand_disp_doc_type)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='expand_disp_doc_type' value='1' $checked></input></td>\n");
   if ($default->expand_disp_title)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='expand_disp_title' value='1' $checked></input></td>\n");
   if ($default->expand_disp_version)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='expand_disp_version' value='1' $checked></input></td>\n");
   if ($default->expand_disp_file)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='expand_disp_file' value='1' $checked></input></td>\n");
   if ($default->expand_disp_size)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='expand_disp_size' value='1' $checked></input></td>\n");
   if ($default->expand_disp_posted)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='expand_disp_posted' value='1' $checked></input></td>\n");
   if ($default->expand_disp_modified)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='expand_disp_modified' value='1' $checked></input></td>\n");
   if ($default->expand_disp_action)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='expand_disp_action' value='1' $checked></input></td>\n");
   if ($default->expand_disp_held)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='expand_disp_held' value='1' $checked></input></td>\n");
   print("</tr>\n");
   print("</table>\n");
   print("</td>");
   print("</tr>\n");
   print("<tr>\n");
   print("<td class='form1'>" . $owl_lang->btn_collapse_view . ":</td>\n");
   print("<td class='form1' width='100%'>\n");
   print("<table>\n<tr>\n");
   print("<td class='form1' width='60'>$owl_lang->status_column<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->doc_number<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->docicon_column<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->title<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->ver<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->file<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->size<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->postedby<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->modified<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->actions<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->held<br /></td>\n");
   print("</tr>\n");
   print("<tr>\n");

   if ($default->collapse_disp_status)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='collapse_disp_status' value='1' $checked></input></td>\n");
   if ($default->collapse_disp_doc_num)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='collapse_disp_doc_num' value='1' $checked></input></td>\n");
   if ($default->collapse_disp_doc_type)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='collapse_disp_doc_type' value='1' $checked></input></td>\n");
   if ($default->collapse_disp_title)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='collapse_disp_title' value='1' $checked></input></td>\n");
   if ($default->collapse_disp_version)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='collapse_disp_version' value='1' $checked></input></td>\n");
   if ($default->collapse_disp_file)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='collapse_disp_file' value='1' $checked></input></td>\n");
   if ($default->collapse_disp_size)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='collapse_disp_size' value='1' $checked></input></td>\n");
   if ($default->collapse_disp_posted)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='collapse_disp_posted' value='1' $checked></input></td>\n");
   if ($default->collapse_disp_modified)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='collapse_disp_modified' value='1' $checked></input></td>\n");
   if ($default->collapse_disp_action)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='collapse_disp_action' value='1' $checked></input></td>\n");
   if ($default->collapse_disp_held)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='collapse_disp_held' value='1' $checked></input></td>\n");
   print("</tr>\n");
   print("</table>\n");
   print("</td>\n");
   print("</tr>\n");


   fPrintSectionHeader("$owl_lang->owl_title_custom_search");
   print("<tr>\n");
   print("<td class='form1'>" . $owl_lang->btn_expand_view . ":</td>\n");
   print("<td class='form1' width='100%'>\n");
   print("<table>\n<tr>\n");
   print("<td class='form1' width='60'>$owl_lang->score<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->owl_log_hd_fld_path<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->docicon_column<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->file<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->size<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->postedby<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->modified<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->actions<br /></td>\n");
   print("</tr>\n");
   print("<tr>\n");
   if ($default->expand_search_disp_score)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='expand_search_disp_score' value='1' $checked></input></td>\n");
   if ($default->expand_search_disp_folder_path)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='expand_search_disp_folder_path' value='1' $checked></input></td>\n");
   if ($default->expand_search_disp_doc_type)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='expand_search_disp_doc_type' value='1' $checked></input></td>\n");
   if ($default->expand_search_disp_file)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='expand_search_disp_file' value='1' $checked></input></td>\n");
   if ($default->expand_search_disp_size)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='expand_search_disp_size' value='1' $checked></input></td>\n");
   if ($default->expand_search_disp_posted)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='expand_search_disp_posted' value='1' $checked></input></td>\n");
   if ($default->expand_search_disp_modified)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='expand_search_disp_modified' value='1' $checked></input></td>\n");
   if ($default->expand_search_disp_action)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='expand_search_disp_action' value='1' $checked></input></td>\n");
   print("</tr>\n");
   print("</table>\n");
   print("</td>\n");
   print("</tr>\n");

   print("<tr>\n");
   print("<td class='form1'>" . $owl_lang->btn_collapse_view . ":</td>\n");
   print("<td class='form1' width='100%'>\n");
   print("<table>\n<tr>\n");
   print("<td class='form1' width='60'>$owl_lang->score<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->owl_log_hd_fld_path<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->docicon_column<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->file<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->size<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->postedby<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->modified<br /></td>\n");
   print("<td class='form1' width='60'>$owl_lang->actions<br /></td>\n");
   print("</tr>\n");
   print("<tr>\n");
   if ($default->collapse_search_disp_score)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='collapse_search_disp_score' value='1' $checked></input></td>\n");
   if ($default->collapse_search_disp_folder_path)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='collapse_search_disp_folder_path' value='1' $checked></input></td>\n");
   if ($default->collapse_search_disp_doc_type)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='collapse_search_disp_doc_type' value='1' $checked></input></td>\n");
   if ($default->collapse_search_disp_file)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='collapse_search_disp_file' value='1' $checked></input></td>\n");
   if ($default->collapse_search_disp_size)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='collapse_search_disp_size' value='1' $checked></input></td>\n");
   if ($default->collapse_search_disp_posted)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='collapse_search_disp_posted' value='1' $checked></input></td>\n");
   if ($default->collapse_search_disp_modified)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='collapse_search_disp_modified' value='1' $checked></input></td>\n");
   if ($default->collapse_search_disp_action)
   {
      $checked = "checked='checked'";
   }
   else
   {
      $checked = "";
   }
   print("<td class='form1'><input class='fcheckbox1' type='checkbox' name='collapse_search_disp_action' value='1' $checked></input></td>\n");
   print("</tr>\n");
   print("</table>\n");
   print("</td>\n");
   print("</tr>\n");

   if ($default->allow_popup == 1)
   {
      fPrintFormCheckBox($owl_lang->use_popup . ":" , "allow_popup", "1", "checked");
   }
   else
   {
      fPrintFormCheckBox($owl_lang->use_popup . ":" , "allow_popup", "1");
   }
   if ($default->expand == 1)
   {
      fPrintFormCheckBox($owl_lang->owl_owl_expand . ":" , "owl_expand", "1", "checked");
   }
   else
   {
      fPrintFormCheckBox($owl_lang->owl_owl_expand . ":" , "owl_expand", "1");
   }

   if ($default->owl_version_control == 1)
   {
      fPrintFormCheckBox($owl_lang->owl_version_control . ":" , "version_control", "1", "checked");
   }
   else
   {
      fPrintFormCheckBox($owl_lang->owl_version_control . ":" , "version_control", "1");
   }

   fPrintFormTextLine($owl_lang->vermajor_initial . ":" , "major_revision", "5", $default->major_revision);
   fPrintFormTextLine($owl_lang->verminor_initial . ":" , "minor_revision", "5", $default->minor_revision);

   if ($default->restrict_view == 1)
   {
      fPrintFormCheckBox($owl_lang->owl_restrict_view . ":" , "restrict_view", "1", "checked");
   }
   else
   {
      fPrintFormCheckBox($owl_lang->owl_restrict_view . ":" , "restrict_view", "1");

   }
   if ($default->hide_backup == 1)
   {
      fPrintFormCheckBox($owl_lang->owl_hidebackup . ":" , "hide_backup", "1", "checked");
   }
   else
   {
      fPrintFormCheckBox($owl_lang->owl_hidebackup . ":" , "hide_backup", "1");
   }
   if ($default->forgot_pass == 1)
   {
      fPrintFormCheckBox($owl_lang->owl_fogotpass . ":" , "forgot_pass", "1", "checked");
   }
   else
   {
      fPrintFormCheckBox($owl_lang->owl_fogotpass . ":" , "forgot_pass", "1");
   }
   if ($default->restrict_view == 0)
   { 
      fPrintFormTextLine($owl_lang->recs_per_page, "rec_per_page", "3", $default->records_per_page);
   }
   else
   {
      print("<tr>\n<td align='right'>$owl_lang->recs_per_page</td>\n
             <td align=left>$default->records_per_page</td>\n</tr>\n");
   }


   fPrintFormTextLine($owl_lang->doc_id_prefix . ":" , "doc_id_prefix", "10", $default->doc_id_prefix);
   fPrintFormTextLine($owl_lang->doc_id_num_digits . ":" , "doc_id_num_digits", "2", $default->doc_id_num_digits);

   if ($default->view_doc_in_new_window == 1)
   {
      fPrintFormCheckBox($owl_lang->view_doc_in_new_window . ":" , "view_doc_in_new_window", "1", "checked");
   }
   else
   {
      fPrintFormCheckBox($owl_lang->view_doc_in_new_window . ":" , "view_doc_in_new_window", "1");
   }

   if ($default->admin_login_to_browse_page == 1)
   {
      fPrintFormCheckBox($owl_lang->admin_login_to_browse_page . ":" , "admin_login_to_browse_page", "1", "checked");
   }
   else
   {
      fPrintFormCheckBox($owl_lang->admin_login_to_browse_page . ":" , "admin_login_to_browse_page", "1");
   }

   if ($default->save_keywords_to_db == 1)
   {
      fPrintFormCheckBox($owl_lang->save_keywords_to_db . ":" , "save_keywords_to_db", "1", "checked");
   }
   else
   {
      fPrintFormCheckBox($owl_lang->save_keywords_to_db . ":" , "save_keywords_to_db", "1");
   }

   // 
   // OTHER SETTINGS
   // 

   fPrintSectionHeader($owl_lang->owl_title_other);
   fPrintFormTextLine($owl_lang->owl_max_filesize . ":" , "max_filesize", "", $default->max_filesize);
   fPrintFormTextLine($owl_lang->owl_owl_timeout . ":" , "owl_timeout", "", $default->owl_timeout);
   fPrintFormTextLine($owl_lang->owl_default_tmpdir , "owl_tmpdir", 60, $default->owl_tmpdir);

      $anon[0] = $owl_lang->owl_anon_full;
      $anon[1] = $owl_lang->owl_anon_ro;
      $anon[2] = $owl_lang->owl_anon_download;

      fPrintFormRadio($owl_lang->anonymous_access . ":" , "anon_ro", $default->anon_access, $anon);

      //if ($default->anon_ro == 1)
      //{
         //fPrintFormCheckBox($owl_lang->owl_anon_ro, "anon_ro", "1", "checked");
      //}
      //else
      //{
         //fPrintFormCheckBox($owl_lang->owl_anon_ro, "anon_ro", "1");
      //}

      fPrintFormSelectBox($owl_lang->anonymous_account, "def_anon_user", $users, $default->anon_user);
      fPrintFormSelectBox($owl_lang->file_admin_group, "file_admin_group", $groups, $default->file_admin_group);
      // 
      // Trash Can Options
      // 
      if ($default->owl_use_fs)
      {
         fPrintSectionHeader($owl_lang->recycle_title);
         if ($default->collect_trash == 1)
         {
            fPrintFormCheckBox($owl_lang->recycle_enabled . ":" , "collect_trash", "1", "checked");
         }
         else
         {
            fPrintFormCheckBox($owl_lang->recycle_enabled . ":" , "collect_trash", "1");
         }

         if ($default->collect_trash == 1)
         {
            fPrintFormTextLine($owl_lang->recycle_location , "trash_can_location", 80, $default->trash_can_location);
         } 
         else
         {
            print("<tr><td colspan='2'><input type='hidden' name='trash_can_location' value='$default->trash_can_location'></input></td></tr>");
         } 

         if ($default->collect_trash == 1)
         {
            fPrintFormTextLine($owl_lang->restore_file_prefix . ":" , "restore_file_prefix", "40", $default->restore_file_prefix);
         } 
         else
         {
            print("<tr><td colspan='2'><input type='hidden' name='restore_file_prefix' value='$default->restore_file_prefix'></input></td></tr>");
         } 

      } 
      // **********************************
      // LOGGING Options
      // **********************************
      // 
      fPrintSectionHeader($owl_lang->owl_title_peer_review);
      if ($default->document_peer_review == 1)
      {
         fPrintFormCheckBox($owl_lang->owl_peer_review, "peer_review", "1", "checked");
      }
      else
      {
         fPrintFormCheckBox($owl_lang->owl_peer_review, "peer_review", "1");
      }

      if ($default->document_peer_review == 1)
      {
         if ($default->document_peer_review_optional == 1)
         {
            fPrintFormCheckBox($owl_lang->owl_peer_review_opt, "peer_opt", "1", "checked");
         }
         else
         {
            fPrintFormCheckBox($owl_lang->owl_peer_review_opt, "peer_opt", "1");
         }
      }
      else
      {
         print("<tr><td colspan='2'><input type='hidden' name='peer_opt' value='$default->document_peer_review_optional'></input></td></tr>");
      }

      // **********************************
      // LOGGING Options
      // **********************************
      // 
      fPrintSectionHeader($owl_lang->owl_title_logging);
      if ($default->logging == 1)
      {
         fPrintFormCheckBox($owl_lang->owl_logging . ":" , "logging", "1", "checked");
      }
      else
      {
         fPrintFormCheckBox($owl_lang->owl_logging . ":" , "logging", "1");
      }
      if ($default->logging == 1)
      {
         if ($default->log_file == 1)
         {
            fPrintFormCheckBox($owl_lang->owl_log_file . ":" , "log_file", "1", "checked");
         }
         else
         {
            fPrintFormCheckBox($owl_lang->owl_log_file . ":" , "log_file", "1");
         }
         if ($default->log_login == 1)
         {
            fPrintFormCheckBox($owl_lang->owl_log_login_act . ":" , "log_login", "1", "checked");
         }
         else
         {
            fPrintFormCheckBox($owl_lang->owl_log_login_act . ":" , "log_login", "1");
         }
         fPrintFormTextLine($owl_lang->owl_log_rec_page , "log_rec_per_page", "", $default->log_rec_per_page);
      } 
      else
      {
         print("<tr><td colspan='2'><input type='hidden' name='log_file' value='$default->log_file'></input></td></tr>");
         print("<tr><td colspan='2'><input type='hidden' name='log_login' value='$default->log_login'></input></td></tr>");
         print("<tr><td colspan='2'><input type='hidden' name='log_rec_per_page' value='$default->log_rec_per_page'></input></td></tr>");
      } 
      // 
      // SELF REGISTER Options
      // 
      fPrintSectionHeader($owl_lang->owl_self_reg_hd);
      $maxsess = $default->self_reg_maxsessions + 1;
      if ($default->self_reg == 1)
      {
         fPrintFormCheckBox($owl_lang->owl_self_reg . ":" , "self_reg", "1", "checked");
      }
      else
      {
         fPrintFormCheckBox($owl_lang->owl_self_reg . ":" , "self_reg", "1");
      }
      if ($default->self_reg == 1)
      {
         fPrintFormTextLine($owl_lang->quota . ":" , "self_reg_quota", "", $default->self_reg_quota);
         if ($default->self_reg_notify == 1)
         {
            fPrintFormCheckBox($owl_lang->notification, "self_reg_notify", "1", "checked");
         }
         else
         {
            fPrintFormCheckBox($owl_lang->notification, "self_reg_notify", "1");
         }
         if ($default->self_reg_attachfile == 1)
         {
            fPrintFormCheckBox($owl_lang->attach_file, "self_reg_attachfile", "1", "checked");
         }
         else
         {
            fPrintFormCheckBox($owl_lang->attach_file, "self_reg_attachfile", "1");
         }
         if ($default->self_reg_disabled == 1)
         {
            fPrintFormCheckBox($owl_lang->disableuser, "self_reg_disabled", "1", "checked");
         }
         else
         {
            fPrintFormCheckBox($owl_lang->disableuser, "self_reg_disabled", "1");
         }
         if ($default->self_reg_noprefacces == 1)
         {
            fPrintFormCheckBox($owl_lang->noprefaccess, "self_reg_noprefacces", "1", "checked");
         }
         else
         {
            fPrintFormCheckBox($owl_lang->noprefaccess, "self_reg_noprefacces", "1");
         }
         fPrintFormTextLine($owl_lang->maxsessions . ":" , "self_reg_maxsessions", "10", $maxsess);

         fPrintFormSelectBox($owl_lang->group . ":" , "self_reg_group", $groups, $default->self_reg_group);

         print("<td class='form1'>$owl_lang->home_dir:</td>\n");
         print("<td class='form1' width='100%'>");
         print("<select class='fpull1' name='self_reg_homedir' size='1'>");
         print("<option value='1' selected='selected'>Documents</option>\n");
         fPrintHomeDir("1", "--|", $default->self_reg_homedir);
         print("</select>\n</td>\n</tr>\n");

         print("<tr>\n");
         print("<td class='form1'>$owl_lang->initial_dir:</td>\n");
         print("<td class='form1' width='100%'>");
         print("<select class='fpull1' name='self_reg_firstdir' size='1'>");
         print("<option value='1' selected='selected'>Documents\n");
         fPrintHomeDir("1", "--|", $default->self_reg_firstdir);
         print("</select>\n</td>\n</tr>\n");
      } 
      else
      {
         print("<tr><td colspan='2'><input type='hidden' name='self_reg_quota' value='$default->self_reg_quota'></input></td></tr>\n");
         print("<tr><td colspan='2'><input type='hidden' name='self_reg_notify' value='$default->self_reg_notify'></input></td></tr>\n");
         print("<tr><td colspan='2'><input type='hidden' name='self_reg_attachfile' value='$default->self_reg_attachfile'></input></td></tr>\n");
         print("<tr><td colspan='2'><input type='hidden' name='self_reg_disabled' value='$default->self_reg_disabled'></input></td></tr>\n");
         print("<tr><td colspan='2'><input type='hidden' name='self_reg_noprefacces' value='$default->self_reg_noprefacces'></input></td></tr>\n");
         print("<tr><td colspan='2'><input type='hidden' name='self_reg_maxsessions' value='$maxsess'></input></td></tr>\n");
         print("<tr><td colspan='2'><input type='hidden' name='self_reg_group' value='$default->self_reg_group'></input></td></tr>\n");
         print("<tr><td colspan='2'><input type='hidden' name='self_reg_homedir' value='$default->self_reg_homedir'></input></td></tr>\n");
         print("<tr><td colspan='2'><input type='hidden' name='self_reg_firstdir' value='$default->self_reg_firstdir'></input></td></tr>\n");
      } 
      // REMEMBER ME OPTIONS

      fPrintSectionHeader($owl_lang->remember_me_title);
      if ($default->remember_me == 1)
      {
         fPrintFormCheckBox($owl_lang->remember_me, "remember_me", "1", "checked");
      }
      else
      {
         fPrintFormCheckBox($owl_lang->remember_me, "remember_me", "1");
     }

      if ($default->remember_me == 1)
      {
         fPrintFormTextLine($owl_lang->remember_timeout . ":" , "cookie_timeout", "", $default->cookie_timeout);
      }
      else
      {
         print("<tr><td colspan='2'><input type='hidden' name='cookie_timeout' value='$default->cookie_timeout'></input></td></tr>\n");
      }
   
      fPrintSectionHeader($owl_lang->owl_title_tools);
      fPrintFormTextLine($owl_lang->virus_path , "virus_path", 60, $default->virus_path);
      fPrintFormTextLine(fStatusImage($default->dbdump_path) . $owl_lang->owl_dbdump_path , "dbdump_path", 60, $default->dbdump_path);
      fPrintFormTextLine(fStatusImage($default->gzip_path) . $owl_lang->owl_gzip_path , "gzip_path", 60, $default->gzip_path);
      fPrintFormTextLine(fStatusImage($default->tar_path) . $owl_lang->owl_tar_path , "tar_path", 60, $default->tar_path);
      fPrintFormTextLine(fStatusImage($default->unzip_path) . $owl_lang->owl_unzip_path , "unzip_path", 60, $default->unzip_path);
      fPrintFormTextLine($owl_lang->owl_pod2html_path , "pod2html_path", 60, $default->pod2html_path);
      fPrintFormTextLine(fStatusImage($default->pdftotext_path) . $owl_lang->owl_pdftotext_path , "pdftotext_path", 60, $default->pdftotext_path);
      fPrintFormTextLine(fStatusImage($default->wordtotext_path) . $owl_lang->owl_wordtotext_path , "wordtotext_path", 60, $default->wordtotext_path);
      printfileperm($default->file_perm, "file_security", $owl_lang->owl_def_file_perm, "admin");
      printgroupperm($default->folder_perm, "folder_security", $owl_lang->owl_def_folder_perm, "user");
      print("<tr>\n");
      print("<td class='form2' width='100%' colspan='2'>\n");
      fPrintSubmitButton($owl_lang->change, $owl_lang->alt_change);
      fPrintSubmitButton($owl_lang->btn_reset, $owl_lang->alt_reset_form, "reset");
      print("</td>\n");
      print("</tr>\n");
   } 


function fStatusImage ( $path )
{
   global $default, $owl_lang;

      if (substr(php_uname(), 0, 7) != "Windows")
      {
         if(is_executable($path))
         {
            $sStatusImage = "<img src='$default->owl_graphics_url/$default->sButtonStyle/ui_icons/gstatus.gif' alt='$owl_lang->alt_tool_status' title='$owl_lang->alt_tool_status_green' border='0'></img>";
         }
         else
         {
            $sStatusImage = "<img src='$default->owl_graphics_url/$default->sButtonStyle/ui_icons/rstatus.gif' alt='$owl_lang->alt_tool_status' title='$owl_lang->alt_tool_status_red' border='0'></img>";
         }
      }
      else
      {
         if(file_exists($path))
         {
            $sStatusImage = "<img src='$default->owl_graphics_url/$default->sButtonStyle/ui_icons/gstatus.gif' alt='$owl_lang->alt_tool_status' title='$owl_lang->alt_tool_status_green' border='0'></img>";
         }
         else
         {
            $sStatusImage = "<img src='$default->owl_graphics_url/$default->sButtonStyle/ui_icons/rstatus.gif' alt='$owl_lang->alt_tool_status' title='$owl_lang->alt_tool_status_red' border='0'></img>";
         }
      }
   return $sStatusImage;
}

function fPrintHomeDir ( $currentparent, $level , $homedir, $stoplevel = "---")
{
   global $default;

   $sql = new Owl_DB;
   $sql->query("select id,name from $default->owl_folders_table where parent='$currentparent' order by name");

   while ($sql->next_record())
   {
      print("<option value='" . $sql->f("id") ."'");
      if ($sql->f("id") == $homedir)
      {
         print (" selected='selected'");
      }
      print(">" . $level . $sql->f("name") . "</option>\n");
      // if the level is 2 deep Stop
      if ($level == "-----|") // ADD --- for each additional level you want to see
      {
         continue;
      }
      else
      {
         fPrintHomeDir($sql->f("id"), $stoplevel . $level, $homedir);
      }
   }
}

   function dobackup()
   {
      global $sess, $default, $owl_lang;

      $date = date("Ymd.Hms");

      if (substr(php_uname(), 0, 7) != "Windows")
      {
         $command = $default->dbdump_path . " --opt --host=" . $default->owl_db_host[$default->owl_current_db] . " --user=" . $default->owl_db_user[$default->owl_current_db] . " --password=" . $default->owl_db_pass[$default->owl_current_db] . " " . $default->owl_db_name[$default->owl_current_db] . " | " . $default->gzip_path . " -fc";
      } 
      else
      {
         $tmpdir = $default->owl_FileDir . "\\owltmpfld_$sess";

         if (file_exists($tmpdir)) 
         {
            myDelete($tmpdir);
         }

         mkdir("$tmpdir", $default->directory_mask);
         $command = $default->dbdump_path . " --opt --host=" . $default->owl_db_host[$default->owl_current_db] . " --user=" . $default->owl_db_user[$default->owl_current_db] . " --password=" . $default->owl_db_pass[$default->owl_current_db] . " " . $default->owl_db_name[$default->owl_current_db] . " > \"" . $tmpdir . '\\' . $default->owl_db_name[$default->owl_current_db] . "-$date.sql\"";

         system($command);
         $command = $default->gzip_path . ' -c -9 "' . $tmpdir . "\\" . $default->owl_db_name[$default->owl_current_db] . "-$date.sql\"";
      } 

      header("Content-Disposition: attachment; filename=\"" . $default->owl_db_name[$default->owl_current_db] . "-$date.sql.gz\"");
      header("Content-Location: " . $default->owl_db_name[$default->owl_current_db] . "-$date.sql.gz");
      header("Content-Type: application/octet-stream"); 
      // header("Content-Length: $fsize");
      // header("Pragma: no-cache");
      header("Expires: 0");
      passthru($command);

      if (substr(php_uname(), 0, 7) == "Windows")
      {
         myDelete($tmpdir);
      } 
      exit();
   } 

   if ($action)
   {
      print("<form name='admin' action='admin_dbmodify.php' method='post'>\n");
      print("<input type='hidden' name='sess' value='$sess'></input>\n");

      if ($action == "newuser")
      {
         print("<input type='hidden' name='action' value='add'></input>");
         print("<input type='hidden' name='type' value='user'></input>");
      }
      elseif ($action == "newgroup")
      {
         print("<input type='hidden' name='action' value='add'></input>");
         print("<input type='hidden' name='type' value='group'></input>");
      } 
      else
      {
         print("<input type='hidden' name='action' value='$action'></input>\n");
      }

      print("<table class='margin2' cellspacing='0' cellpadding='0' border='0' width='100%'><tr><td align='left' valign='top'>\n");

      if ($action == "edprefs")
      {
         print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
         print("<tr>\n");
         print("\t<td class='admin1' width='100%'>$owl_lang->header_sitefeatures_settings</td>\n");
         print("</tr>\n");
         print("</table>\n");
      }

      print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
      if ($action <> "JUNK" and $action <> "users" and $action <> "newgroup" and $action <> "newuser" and $action <> "groups")
      {
         print("<tr>\n");
         print("<td class='form2' width='100%' colspan='2'>\n");
         fPrintSubmitButton($owl_lang->change, $owl_lang->alt_change);
         fPrintSubmitButton($owl_lang->btn_reset, $owl_lang->alt_reset_form, "reset");
         print("</td>\n");
         print("</tr>\n");
      }
      $usersgroup = false;
      if ($action == "users" or $action == "newuser") 
      {
         $usersgroup = true;
         printusers();
         printgroups();
         //print("</table>\n");
         //print("</td></tr></table>\n");
         //print("</form>\n");
      }
      if (isset($owluser)) 
      {
         if(!$usersgroup)
         {
            printusers();
            printgroups();
         }
         fPrintSectionHeader("&nbsp;");
         printuser($owluser);
      }
      if (isset($group)) 
      {
         printusers();
         printgroups();
         fPrintSectionHeader("&nbsp;");
         printgroup($group);
      }

      if ($action == "newgroup") 
      {
         printusers();
         printgroups();
         fPrintSectionHeader("&nbsp;");
         printnewgroup();
      }
      if ($action == "newuser") 
      {
         fPrintSectionHeader("&nbsp;");
         printnewuser(); 
      }
      if ($action == "edhtml") 
      {
         printhtml();
      }
      if ($action == "edprefs") 
      { 
         printprefs();
      }
   } 
   else
   {
      exit("$owl_lang->err_general");
   } 

   print("</table>\n");
   print("</td></tr></table>\n");
   print("</form>\n");

   if ($default->show_prefs == 2 or $default->show_prefs == 3)
   {
      fPrintPrefs("infobar2");
   }
   print("</td></tr></table>\n");
   include("../lib/footer.inc");
?>
