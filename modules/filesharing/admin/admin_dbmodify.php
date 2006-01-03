<?php

/**
 * admin_dbmodify.php
 * 
 * Author: Steve Bourgeois <owl@bozzit.com>
 * Project Founder: Chris Vincent <cvincent@project802.net>
 *
 * Copyright (c) 1999-2003 The Owl Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 * 
 * $Id: admin_dbmodify.php,v 1.14 2005/03/17 00:22:21 b0zz Exp $
 */

require("../config/owl.php");
require("../lib/disp.lib.php");
require("../lib/owl.lib.php");

// Code to handle the click on the bulk action
// image button, If the button is not there and
// the alternate text is shown, then this doesn't
// work.
if (isset($bdeletegroup_x))
{
   $action = $owl_lang->deletegroup;
} elseif (isset($bdeleteuser_x))
{
   $action = $owl_lang->deleteuser;
} elseif (isset($btn_ed_user_x))
{
   header("Location: " . "index.php?sess=$sess&action=users&owluser=$owluser");
   exit;
} elseif (isset($btn_ed_group_x))
{
   header("Location: " . "index.php?sess=$sess&action=groups&group=$group");
   exit;
} elseif (isset($btn_cancel_news_x))
{
   header("Location: " . "news.php?sess=$sess");
   exit;
} 

if (!fIsAdmin(true) and !fIsNewsAdmin($userid)) die("$owl_lang->err_unauthorized");

if ($action == "edit_news")
{
   global $default;
   $sql = new Owl_DB;

   $news_end_date = $year . "-" . $month . "-" . "$day $hour" . ":" . $minute . ":00";
   //$newsdesc = ereg_replace("[\\]'", "'", $newsdesc);
   $newsdesc = stripslashes($newsdesc);
   $newsdesc = ereg_replace("'", "\\'" , $newsdesc);
   //$news_title = ereg_replace("[\\]'", "'", $news_title);
   $news_title = stripslashes($news_title);
   $news_title = ereg_replace("'", "\\'" , $news_title);

   if (trim($newsdesc) == "" || trim($news_title) == "")
   {
      printError($owl_lang->err_news_required);
   } 

   //$sql->query("INSERT INTO $default->owl_news_table (gid, news_title, news_date, news, news_end_date) VALUES ( '$audience', '$news_title', now(), '$newsdesc', '$news_end_date')");
   $sMyQuery = "INSERT INTO $default->owl_news_table (gid, news_title, news_date, news, news_end_date) VALUES ( '$audience', '$news_title', " . $sql->now() . ", '$newsdesc', " . $sql->now($news_end_date) .")";
   $sql->query($sMyQuery);
   $sql->query("DELETE FROM $default->owl_news_table  where id = '$nid'");
   header("Location: news.php?sess=$sess&change=1");
} 

if ($action == "add_news")
{
   global $default;
   $sql = new Owl_DB;

   $news_end_date = $year . "-" . $month . "-" . "$day $hour" . ":" . $minute . ":00";
   //$newsdesc = ereg_replace("[\\]'", "'", $newsdesc);
   $newsdesc = stripslashes($newsdesc);
   $newsdesc = ereg_replace("'", "\\'" , $newsdesc);
   //$news_title = ereg_replace("[\\]'", "'", $news_title);
   $news_title = stripslashes($news_title);
   $news_title = ereg_replace("'", "\\'" , $news_title);
   if (trim($newsdesc) == "" || trim($news_title) == "")
   {
      printError($owl_lang->err_news_required);
   } 

   $sMyQuery = "INSERT INTO $default->owl_news_table (gid, news_title, news_date, news, news_end_date) VALUES ( '$audience', '$news_title', " . $sql->now() . ", '$newsdesc', " . $sql->now($news_end_date) .")";
   $sql->query($sMyQuery);
   //$sql->query("INSERT INTO $default->owl_news_table (gid, news_title, news_date, news, news_end_date) VALUES ( '$audience', '$news_title', now(), '$newsdesc', '$news_end_date')");
   header("Location: news.php?sess=$sess&change=1");
} 

if (!fIsAdmin(true))
{
   exit("$owl_lang->err_unauth_area");
}

if ($action == "user")
{
   if (!isset($notify))
   {
      $notify = 0;
   }
   if (!isset($attachfile))
   {
      $attachfile = 0;
   }
   if (!isset($disabled))
   {
      $disabled = 0;
   }
   if (!isset($noprefaccess))
   {
      $noprefaccess = 0;
   }
   if (!isset($newsadmin))
   {
      $newsadmin = 0;
   }
   if (!isset($comment_notify))
   {
      $comment_notify = 0;
   }
   if ($newlanguage != $oldlanguage)
   {
      $newbuttons = $default->system_ButtonStyle;
   }
   $maxsessions = $maxsessions - 1; // always is stored - 1
   $sql = new Owl_DB;
   $sql->query("SELECT * FROM $default->owl_users_table WHERE id = '$id'");
   $sql->next_record();

   $newpass = $sql->f("password");

   $sql->query("select sum(f_size) as actual_quota from $default->owl_files_table where creatorid = '$id'");
   $sql->next_record();
   if ($sql->num_rows() > 0)
   {
      $quota_current = $sql->f("actual_quota");
   }
   else
   {
      $quota_current = 0;
   }

   if (empty($quota_current))
   {
      $quota_current = 0;
   }

   if ($newpass == $edit_password)
   {
      $sql->query("UPDATE $default->owl_users_table SET groupid='$groupid',username='$edit_loginname',name='$name',password='$edit_password',quota_current = '$quota_current', quota_max='$quota', email='$email',notify='$notify',attachfile='$attachfile',disabled='$disabled',noprefaccess='$noprefaccess',language='$newlanguage',maxsessions='$maxsessions',newsadmin='$newsadmin', comment_notify = '$comment_notify', buttonstyle = '$newbuttons', homedir = '$homedir', firstdir = '$firstdir' , email_tool = '$email_tool' where id = '$id'");
   } 
   else
   {
      $sql->query("UPDATE $default->owl_users_table SET groupid='$groupid',username='$edit_loginname',name='$name',password='" . md5($edit_password) . "',quota_max='$quota',quota_current = '$quota_current',  email='$email', notify='$notify',attachfile='$attachfile',disabled='$disabled',noprefaccess='$noprefaccess',language='$newlanguage',maxsessions='$maxsessions', newsadmin='$newsadmin', comment_notify = '$comment_notify' , buttonstyle = '$newbuttons', homedir = '$homedir', firstdir = '$firstdir', email_tool = '$email_tool' where id = '$id'");
   } 
   // Bozz Change BEGIN
   // Clean Up the member group table first
   $sql->query("DELETE FROM $default->owl_users_grpmem_table WHERE userid = $id"); 
   // Insert the new Choices the member group table with selected groups
   for ($i = 0 ; $i <= $no_groups_displayed; $i++)
   {
      $checkboxfields = 'group' . $i;
      if ($$checkboxfields != '')
      {
         $checkboxvalue = $$checkboxfields;
         $sql->query("INSERT INTO $default->owl_users_grpmem_table (userid,groupid) VALUES ('$id', '$checkboxvalue')");
      } 
   } 
   /**
    * Bozz Change END
    */
   header("Location: index.php?sess=$sess&action=users&owluser=$id&change=1");
} 

if ($action == "group")
{
   global $default;
   $sql = new Owl_DB;
   $sql->query("UPDATE $default->owl_groups_table SET name='$name' where id = '$id'");
   header("Location: index.php?sess=$sess&action=groups&group=$id&change=1");
} 

if ($action == $owl_lang->deleteuser)
{
   $sql = new Owl_DB;
   $sql->query("DELETE FROM $default->owl_users_table WHERE id = '$id'"); 
   // Bozz Change Begin
   // Also Clean up the groupmember table when a user is deleted
   $sql->query("DELETE FROM $default->owl_users_grpmem_table WHERE userid = $id"); 
   // Also Clean up the any active sessions from the  table when a user is deleted
   $sql->query("DELETE FROM $default->owl_sessions_table WHERE usid = $id"); 
   // Bozz Change End
   header("Location: index.php?sess=$sess&action=users");
} 

if ($action == "edhtml")
{
   $sql = new Owl_DB;
   $sql->query("UPDATE $default->owl_html_table SET body_textcolor='$body_textcolor',body_link='$body_link',body_vlink='$body_vlink',table_expand_width='$expand_width',table_collapse_width='$collapse_width', body_background='$body_background',owl_logo = '$owl_logo' ");

   header("Location: index.php?sess=$sess&action=edhtml&change=1");
} 

if ($action == "edprefs")
{
   $sql = new Owl_DB;


   if (!isset($use_smtp_auth))
   {
      $use_smtp_auth = "0";
   }
   if (!isset($use_smtp))
   {
      $use_smtp = "0";
   }
   if (!isset($collect_trash))
   {
      $collect_trash = "0";
   }
   if (!isset($allow_popup))
   {
      $allow_popup = "0";
   }
   if (!isset($forget_pass))
   {
      $forget_pass = "0";
   }
   if (!isset($restrict_view))
   {
      $restrict_view = "0";
   }
   if (!isset($hide_backup))
   {
      $hide_backup = "0";
   }
   if (!isset($logging))
   {
      $logging = "0";
   }
   if (!isset($forgot_pass))
   {
      $forgot_pass = "0";
   }
   if (!isset($self_reg))
   {
      $self_reg = "0";
   }
   if (!isset($self_reg_notify))
   {
      $self_reg_notify = "0";
   }
   if (!isset($self_reg_attachfile))
   {
      $self_reg_attachfile = "0";
   }
   if (!isset($self_reg_disabled))
   {
      $self_reg_disabled = "0";
   }
   if (!isset($self_reg_noprefacces))
   {
      $self_reg_noprefacces = "0";
   }
   if (!isset($rec_per_page))
   {
      $rec_per_page = 0;
   }

   if (!isset($remember_me))
   {
      $remember_me = 0;
   }

   if ($lookAtHD != "false")
   {
      $lookAtHD = "true";
   }
   if ($owl_expand != "1")
   {
      $owl_expand = "0";
   }
   if ($version_control != "1")
   {
      $version_control = "0";
   }

   $maxsess = $self_reg_maxsessions - 1;

   if ($default->owl_FileDir == $owl_tmpdir)
   {
      $owl_tmpdir = "";
   } 
   if ($trash_can_location == $default->owl_FileDir . "/TrashCan")
   {
      $trash_can_location = "";
   } 

   // Restricted View Does not work with Records Per Page
   // Disable Records Per page if its set.

   if ($restrict_view == 1)
   {
      $rec_per_page = 0;
   }

   if(empty($expand_disp_status))
   {
      $expand_disp_status = 0;
   }
   if(empty($expand_disp_doc_num))
   {
      $expand_disp_doc_num = 0;
   }
   if(empty($expand_disp_doc_type))
   {
      $expand_disp_doc_type = 0;
   }
   if(empty($expand_disp_title))
   {
      $expand_disp_title = 0;
   }
   if(empty($expand_disp_version))
   {
      $expand_disp_version = 0;
   }
   if(empty($expand_disp_file))
   {
      $expand_disp_file = 0;
   }
   if(empty($expand_disp_size))
   {
      $expand_disp_size = 0;
   }
   if(empty($expand_disp_posted))
   {
      $expand_disp_posted = 0;
   }
   if(empty($expand_disp_modified))
   {
      $expand_disp_modified = 0;
   }
   if(empty($expand_disp_action))
   {
      $expand_disp_action = 0;
   }
   if(empty($expand_disp_held))
   {
      $expand_disp_held = 0;
   }
                                                                                                                                                                                                   
   if(empty($collapse_disp_status))
   {
      $collapse_disp_status = 0;
   }
   if(empty($collapse_disp_doc_num))
   {
      $collapse_disp_doc_num = 0;
   }
   if(empty($collapse_disp_doc_type))
   {
      $collapse_disp_doc_type = 0;
   }
   if(empty($collapse_disp_title))
   {
      $collapse_disp_title = 0;
   }
   if(empty($collapse_disp_version))
   {
      $collapse_disp_version = 0;
   }
   if(empty($collapse_disp_file))
   {
      $collapse_disp_file = 0;
   }
   if(empty($collapse_disp_size))
   {
      $collapse_disp_size = 0;
   }
   if(empty($collapse_disp_posted))
   {
      $collapse_disp_posted = 0;
   }
   if(empty($collapse_disp_modified))
   {
      $collapse_disp_modified = 0;
   }
   if(empty($collapse_disp_action))
   {
      $collapse_disp_action = 0;
   }
   if(empty($collapse_disp_held))
   {
      $collapse_disp_held = 0;
   }

   if(empty($expand_search_disp_score))
   {
      $expand_search_disp_score = 0;
   }
   if(empty($expand_search_disp_folder_path))
   {
      $expand_search_disp_folder_path = 0;
   }
   if(empty($expand_search_disp_doc_type))
   {
      $expand_search_disp_doc_type = 0;
   }
   if(empty($expand_search_disp_file))
   {
      $expand_search_disp_file = 0;
   }
   if(empty($expand_search_disp_size))
   {
      $expand_search_disp_size = 0;
   }
   if(empty($expand_search_disp_posted))
   {
      $expand_search_disp_posted = 0;
   }
   if(empty($expand_search_disp_modified))
   {
      $expand_search_disp_modified = 0;
   }
   if(empty($expand_search_disp_action))
   {
      $expand_search_disp_action = 0;
   }

   if(empty($collapse_search_disp_score))
   {
      $collapse_search_disp_score = 0;
   }
   if(empty($collapse_search_disp_folder_path))
   {
      $collapse_search_disp_folder_path = 0;
   }
   if(empty($collapse_search_disp_doc_type))
   {
      $collapse_search_disp_doc_type = 0;
   }
   if(empty($collapse_search_disp_file))
   {
      $collapse_search_disp_file = 0;
   }
   if(empty($collapse_search_disp_size))
   {
      $collapse_search_disp_size = 0;
   }
   if(empty($collapse_search_disp_posted))
   {
      $collapse_search_disp_posted = 0;
   }
   if(empty($collapse_search_disp_modified))
   {
      $collapse_search_disp_modified = 0;
   }
   if(empty($collapse_search_disp_action))
   {
      $collapse_search_disp_action = 0;
   }
   if(empty($hide_folder_doc_count))
   {
      $hide_folder_doc_count = 0;
   }
   if(empty($hide_folder_size))
   {
      $hide_folder_size = 0;
   }
   if(empty($old_action_icons))
   {
      $old_action_icons = 0;
   }
   if(empty($search_result_folders))
   {
      $search_result_folders = 0;
   }

   if(empty($major_revision))
   {
      $major_revision = 1;
   }
   if(empty($minor_revision))
   {
      $minor_revision = 0;
   }

   if(empty($doc_id_prefix))
   {
      $doc_id_prefix = "ABC-";
   }
   if(empty($doc_id_num_digits))
   {
      $doc_id_num_digits = 3;
   }

   if(empty($view_doc_in_new_window))
   {
      $view_doc_in_new_window = 0;
   }

   if(empty($admin_login_to_browse_page))
   {
      $admin_login_to_browse_page = 0;
   }

   if(empty($save_keywords_to_db))
   {
      $save_keywords_to_db = 0;
   }
   if(empty($use_zipe))
   {
      $use_zipe = 0;
   }
   if(empty($peer_opt))
   {
      $peer_opt = 0;
   }
   if(empty($peer_review))
   {
      $peer_review = 0;
   }
   if(empty($password_override))
   {
      $password_override = 0;
   }
   if(empty($use_zip))
   {
      $use_zip = 0;
   }
   if(empty($def_anon_user))
   {
      $def_anon_user = 2;
   }
   if(empty($file_admin_group))
   {
      $file_admin_group = 0;
   }

   $sql->query("UPDATE $default->owl_prefs_table SET  email_from='$email_from', email_fromname='$email_fromname', email_replyto='$email_replyto', email_server='$email_server', lookathd='$lookAtHD', lookathddel='$lookAtHD_del', def_file_security='$def_file_security', def_file_group_owner='$def_file_group_owner', def_file_owner='$def_file_owner', def_file_title='$def_file_title', def_file_meta='$def_file_meta', def_fold_security='$def_fold_security', def_fold_group_owner='$def_fold_group_owner', def_fold_owner='$def_fold_owner', max_filesize='$max_filesize', timeout='$owl_timeout', expand='$owl_expand', version_control='$version_control', restrict_view='$restrict_view', dbdump_path='$dbdump_path', gzip_path='$gzip_path', tar_path='$tar_path', file_perm='$file_security', folder_perm='$folder_security', anon_ro='$anon_ro', hide_backup='$hide_backup', logging='$logging', log_file='$log_file', log_login='$log_login', log_rec_per_page='$log_rec_per_page', self_reg='$self_reg', self_reg_quota='$self_reg_quota', self_reg_notify='$self_reg_notify', self_reg_attachfile='$self_reg_attachfile', self_reg_disabled='$self_reg_disabled', self_reg_noprefacces='$self_reg_noprefacces', self_reg_maxsessions='$maxsess', self_reg_group='$self_reg_group', self_reg_homedir='$self_reg_homedir', self_reg_firstdir='$self_reg_firstdir', forgot_pass = '$forgot_pass', email_subject = '$email_subject', tmpdir = '$owl_tmpdir', anon_user = '$def_anon_user', file_admin_group = '$file_admin_group', collect_trash = '$collect_trash', trash_can_location = '$trash_can_location', allow_popup = '$allow_popup' , status_bar_location = '$status_bar_location', virus_path = '$virus_path', pdftotext_path = '$pdftotext_path', wordtotext_path = '$wordtotext_path', unzip_path = '$unzip_path',  pod2html_path = '$pod2html_path', use_smtp = '$use_smtp', use_smtp_auth = '$use_smtp_auth', smtp_passwd = '$smtp_passwd' , smtp_auth_login = '$smtp_auth_login', rec_per_page = '$rec_per_page', remember_me = '$remember_me', cookie_timeout = '$cookie_timeout', search_bar = '$search_bar', pref_bar = '$pref_bar', bulk_buttons = '$bulk_buttons', action_buttons = '$action_buttons', folder_tools = '$folder_tools' , expand_disp_status = '$expand_disp_status', expand_disp_doc_num = '$expand_disp_doc_num', expand_disp_doc_type = '$expand_disp_doc_type', expand_disp_title = '$expand_disp_title', expand_disp_version = '$expand_disp_version', expand_disp_file = '$expand_disp_file', expand_disp_size = '$expand_disp_size', expand_disp_posted = '$expand_disp_posted', expand_disp_modified = '$expand_disp_modified', expand_disp_action = '$expand_disp_action', expand_disp_held = '$expand_disp_held', collapse_disp_status = '$collapse_disp_status', collapse_disp_doc_num = '$collapse_disp_doc_num', collapse_disp_doc_type = '$collapse_disp_doc_type', collapse_disp_title = '$collapse_disp_title', collapse_disp_version = '$collapse_disp_version', collapse_disp_file = '$collapse_disp_file', collapse_disp_size = '$collapse_disp_size', collapse_disp_posted = '$collapse_disp_posted', collapse_disp_modified = '$collapse_disp_modified', collapse_disp_action = '$collapse_disp_action', collapse_disp_held = '$collapse_disp_held', expand_search_disp_score = '$expand_search_disp_score', expand_search_disp_folder_path = '$expand_search_disp_folder_path', expand_search_disp_doc_type = '$expand_search_disp_doc_type', expand_search_disp_file = '$expand_search_disp_file', expand_search_disp_size = '$expand_search_disp_size', expand_search_disp_posted = '$expand_search_disp_posted', expand_search_disp_modified = '$expand_search_disp_modified', expand_search_disp_action = '$expand_search_disp_action', collapse_search_disp_score = '$collapse_search_disp_score', collapse_search_disp_folder_path = '$collapse_search_disp_folder_path', collapse_search_disp_doc_type = '$collapse_search_disp_doc_type', collapse_search_disp_file = '$collapse_search_disp_file', collapse_search_disp_size = '$collapse_search_disp_size', collapse_search_disp_posted = '$collapse_search_disp_posted', collapse_search_disp_modified = '$collapse_search_disp_modified', collapse_search_disp_action = '$collapse_search_disp_action', hide_folder_doc_count = '$hide_folder_doc_count', old_action_icons = '$old_action_icons', search_result_folders = '$search_result_folders', restore_file_prefix = '$restore_file_prefix', major_revision = '$major_revision', minor_revision = '$minor_revision', doc_id_prefix = '$doc_id_prefix', doc_id_num_digits = '$doc_id_num_digits', view_doc_in_new_window = '$view_doc_in_new_window', admin_login_to_browse_page = '$admin_login_to_browse_page', save_keywords_to_db = '$save_keywords_to_db', peer_review = '$peer_review', peer_opt = '$peer_opt', folder_size = '$hide_folder_size', download_folder_zip='$use_zip', display_password_override = '$password_override'"); 


   header("Location: index.php?sess=$sess&action=edprefs&change=1");
} 

if ($action == $owl_lang->deletegroup)
{
   global $default;
   $sql = new Owl_DB;
   $sql->query("select distinct username,name,id,maxsessions,u.groupid from $default->owl_users_table u left join $default->owl_users_grpmem_table m on u.id=m.userid where u.groupid=$id or m.groupid=$id order by name");
   if ($sql->num_rows($sql) == 0)
   {
      $sql->query("DELETE FROM $default->owl_groups_table WHERE id = '$id'");
   } 
   else
   {
      printError($owl_lang->err_group_delete);
   } 
   header("Location: index.php?sess=$sess&action=groups");
} 

if ($action == "add")
{
   if ($type == "user")
   {
      if (!isset($notify))
      {
         $notify = 0;
      }
      if (!isset($attachfile))
      {
         $attachfile = 0;
      }
      if (!isset($disabled))
      {
         $disabled = 0;
      }
      if (!isset($noprefaccess))
      {
         $noprefaccess = 0;
      }
      if (!isset($newsadmin))
      {
         $newsadmin = 0;
      }
      if (!isset($comment_notify))
      {
         $comment_notify = 0;
      }

      $maxsessions = $maxsessions - 1; // always is stored - 1
      
      $sql = new Owl_DB;
      $sql->query("SELECT * FROM $default->owl_users_table WHERE username = '$edit_loginname'");
      if ($sql->num_rows($sql) > 0) printError("$owl_lang->err_user_exists", $owl_lang->username);
      $sql->query("SELECT * FROM $default->owl_users_table WHERE name = '$name'");
      if ($sql->num_rows($sql) > 0) printError("$owl_lang->err_user_exists", $owl_lang->full_name);

      //$dNow = date("Y-m-d H:i:s");
      $dNow = $sql->now();

      $sql->query("INSERT INTO $default->owl_users_table (groupid,username,name,password,quota_max,quota_current,email,notify,attachfile,disabled,noprefaccess,language,maxsessions,curlogin,lastlogin,newsadmin, comment_notify, buttonstyle, homedir,firstdir, email_tool) VALUES ('$groupid', '$edit_loginname', '$name', '" . md5($edit_password) . "', '$quota', '0', '$email', '$notify','$attachfile', '$disabled', '$noprefaccess', '$newlanguage', '$maxsessions', $dNow, $dNow, '$newsadmin', '$comment_notify', '$default->system_ButtonStyle', '$homedir', '$firstdir','$email_tool' )"); 
      // Bozz Change BEGIN
      // Populated the member group table with selected groups
      $sql->query("SELECT id FROM $default->owl_users_table WHERE username = '$edit_loginname'");
      $sql->next_record();
      $newuid = $sql->f("id");
      for ($i = 0 ; $i <= $no_groups_displayed; $i++)
      {
         $checkboxfields = 'group' . $i;
         if ($$checkboxfields != '')
         {
            $checkboxvalue = $$checkboxfields;
            $sql->query("INSERT INTO $default->owl_users_grpmem_table (userid,groupid) VALUES ('$newuid', '$checkboxvalue')");
         } 
      } 
      /**
       * Bozz Change END
       */
      if ($home == "1")
      {
         $sql->query("select * from $default->owl_users_table where username = '$edit_loginname'");
         while ($sql->next_record()) $id = $sql->f("id");
         $sql->query("insert into $default->owl_folders_table values (0, '$edit_loginname', '2', '54', '$groupid', '$id')");
         mkdir($default->owl_fs_root . "/" . fid_to_name("1") . "/Home/$edit_loginname", $default->directory_mask);
      } 

      header("Location: index.php?sess=$sess");
   } elseif ($type == "group")
   {
      $sql = new Owl_DB;
      $sql->query("SELECT id from  $default->owl_groups_table where name = '$name'");
      if ($sql->num_rows() > 0)
      {
         printError($owl_lang->err_group_exists);
      } 
      $sql->query("INSERT INTO $default->owl_groups_table (name) VALUES ('$name')");

      header("Location: index.php?sess=$sess");
   } 
} 

?>
