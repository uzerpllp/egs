<?php

/**
 * owl.lib.php
 * 
 * Author: Steve Bourgeois <owl@bozzit.com>
 * Project Founder: Chris Vincent <cvincent@project802.net>
 *
 * Copyright (c) 1999-2005 The Owl Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 * 
 * $Id: owl.lib.php,v 1.34 2005/03/23 00:24:15 b0zz Exp $
 */

// 
// Controle the level of PHP Messages that are
// Reported

if ($default->debug == true)
{ 
   // error_reporting (E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
   // I think we have a bit of work to get Owl to run with E_NOTICE turned On ;-(
   error_reporting (E_ERROR | E_WARNING | E_PARSE);
} 
else
{ 
   error_reporting (0);
} 
// 
// Support for reg.globals off WES
if (substr(phpversion(), 0, 5) >= "4.1.0")
{
   //import_request_variables('pgc', 'owl_');
   import_request_variables('pgc');
}
else
{
   if (!EMPTY($_POST))
   {
      extract($_POST);
   } 
   else
   {
      extract($HTTP_POST_VARS);
   } 
   if (!EMPTY($_GET))
   {
      extract($_GET);
   } 
   else
   {
      extract($HTTP_GET_VARS);
   } 
   if (!EMPTY($_FILE))
   {
      extract($_FILE);
   } 
   else
   {
      extract($HTTP_POST_FILES);
   } 
} 

if(!empty($_GET[currentdb]))
{
   $default->owl_current_db = $_GET[currentdb];
}
else
{
   if(!empty($_POST[currentdb]))
   {
      $default->owl_current_db = $_POST[currentdb];
   }
  else
  {
      if(empty($default->owl_current_db))
      {
         $default->owl_current_db = 0;
      }
  }
}


if (!isset($sess)) 
{
   if (!isset($HTTP_COOKIE_VARS["owl_sessid"]))
   {
      $sess = 0;
   }
   else
   {
      $sess = $HTTP_COOKIE_VARS["owl_sessid"];
   }
}
else
{	
	
   if (isset($HTTP_COOKIE_VARS["owl_sessid"]))
   {
     $sess = $HTTP_COOKIE_VARS["owl_sessid"];
     
   }
}

if (!isset($loginname)) 
{
	
   $loginname = 0;
}
if (!isset($login))
{
   $login = 0;
}

class Owl_DB extends DB_Sql
{
   var $classname = "Owl_DB"; 
   // BEGIN wes changes -- moved these settings to config/owl.php
   // Server where the database resides
   var $Host = ""; 
   // Database name
   var $Database = ""; 
   // User to access database
   var $User = ""; 
   // Password for database
   var $Password = "";

   function Owl_DB()
   {
      global $default;

      if(empty($default->owl_current_db))
      {
         $db = $default->owl_default_db;
      }
      else
      {
         $db = $default->owl_current_db;
      }

      $this->Host = $default->owl_db_host[$db];
      $this->Database = $default->owl_db_name[$db];
      $this->User = $default->owl_db_user[$db];
      $this->Password = $default->owl_db_pass[$db];


      //$this->Host = $default->owl_db_host[0];
      //$this->Database = $default->owl_db_name[0];
      //$this->User = $default->owl_db_user[0];
      //$this->Password = $default->owl_db_pass[0];
   } 
   // END wes changes
   function haltmsg($msg)
   {
      printf("</td></table><b>$owl_lang->err_database:</b> %s<br>\n", $msg);
      printf("<b>$owl_lang->err_sql</b>: %s (%s)<br>\n",
         $this->Errno, $this->Error);
   } 
} 


if(!empty($sess))
{
	
   foreach ( $default->owl_db_id as $database )
   {
      $default->owl_current_db = $database;

      $sql = new Owl_DB;
      $sql->query("SELECT * from $default->owl_sessions_table where sessid = '$sess'");
      $sql->next_record();
      $numrows = $sql->num_rows($sql);
      if ($numrows == 1)
      {
         break;
      }
      $default->owl_current_db = null;
   }
}

getprefs();

getuserprefs();

// 
// Set the language from default or from the users file.
// NOTE: the messages here cannot be internationalized
// 

if (!isset($default->sButtonStyle)) 
{
   $default->sButtonStyle = $default->system_ButtonStyle;
}

gethtmlprefs();

if (isset($default->owl_lang))
{
   $langdir = "$default->owl_fs_root/locale/$default->owl_lang";
   if (is_dir("$langdir") != 1)
   {
      die("<br></br><font size='4'><center>Path to the 'locale' directory was Not found: $langdir</center></font>");
   } 
   else
   {
      $sql = new Owl_DB;
      $sql->query("SELECT * from $default->owl_sessions_table where sessid = '$sess'");
      $sql->next_record();
      $numrows = $sql->num_rows($sql);
      $getuid = $sql->f("usid");
      if ($numrows == 1)
      {
         $sql->query("SELECT * from $default->owl_users_table where id = $getuid");
         $sql->next_record();
         $language = $sql->f("language"); 
         $default->sButtonStyle = $sql->f("buttonstyle");
         if (!$language)
         {
            $language = $default->owl_lang;
         } 
         if (file_exists("$default->owl_fs_root/locale/$language/language.inc"))
         {
            if (is_readable("$default->owl_fs_root/locale/$language/language.inc"))
            {
               require_once("$default->owl_fs_root/locale/$language/language.inc");
               $default->owl_lang = $language;
               if (!empty($owl_lang->charset))
               {
                  $default->charset = $owl_lang->charset;
               }
            } 
            else
            {
               die("<br></br><font size='4'><center>The webserver does not have read access to:
					     <br></br>The Language file '$default->owl_fs_root/locale/$language/language.inc'
				             <br></br>Please fix the permissions and try again</center></font>");
            } 
         } 
         else
         {
            die("<br></br><font size='4'><center>The Language file '$default->owl_fs_root/locale/$language/language.inc' does not exists.</center></font>");
         } 
      } 
      else
      {
         if ($sess == 0)
         {
            $language = $default->owl_lang;
         } 
         if (file_exists("$default->owl_fs_root/locale/$default->owl_lang/language.inc"))
         {
            if (is_readable("$default->owl_fs_root/locale/$default->owl_lang/language.inc"))
            {
               require_once("$default->owl_fs_root/locale/$default->owl_lang/language.inc");
            } 
            else
            {
               die("<br></br><font size='4'><center>The webserver does not have read access to:
				      	<br></br>The Language file '$default->owl_fs_root/locale/$default->owl_lang/language.inc'.
					<br></br>Please fix the permissions and try again</center></font>");
            } 
         } 
         else
         {
            die("<br></br><font size='4'><center>The Language file '$default->owl_fs_root/locale/$default->owl_lang/language.inc' does not exists.</center></font>");
         } 
      } 
   } 
} 
else
{
   die("<br></br><font size='4'><center>Unable to find language, please specify in config/owl.php.</center></font>");
} 

class Owl_Session
{
   var $sessid;
   var $sessuid;
   var $sessdata;

   function Open_Session($sessid = 0, $sessuid = 0)
   {
      global $default;
      global $rememberme;
      $this->sessid = $sessid;
      $this->sessuid = $sessuid;

      if ($sessid == "0") // if there is no user loged in, then create a session for them
      {

         $current = time();
         $random = $this->sessuid . $current;
         $this->sessid = md5($random);


         $OpenSess = new Owl_DB;

         if (getenv("HTTP_CLIENT_IP"))
         {
            $ip = getenv("HTTP_CLIENT_IP");
         } 
         elseif (getenv("HTTP_X_FORWARDED_FOR"))
         {
            $forwardedip = getenv("HTTP_X_FORWARDED_FOR");
            list($ip, $ip2, $ip3, $ip4) = split (",", $forwardedip);
         } 
         else
         {
            $ip = getenv("REMOTE_ADDR");
         } 

         if (!$default->active_session_ip)
         {
            $ip = 0;
         }

         if ($rememberme == 1)
         {
            $current = time() +60*60*24*$default->cookie_timeout; 
         }

         if (empty($_POST[currentdb]))
         {
            $iCurrentDB = "0";
         }
         else
         {
            $iCurrentDB = $_POST[currentdb];
         }

         $result = $OpenSess->query("INSERT INTO $default->owl_sessions_table  VALUES ('$this->sessid', '$this->sessuid', '$current', '$ip', '$iCurrentDB')");

         if (!$result) 
         {
            die("$owl_lang->err_sess_write");
         }

         if ($rememberme == 1 and $default->remember_me)
         {
            setcookie ("owl_sessid", $this->sessid, time()+60*60*24*$default->cookie_timeout);
         }
      } 
      // else we have a session id, try to validate it...
      $CheckSess = new Owl_DB;
      $CheckSess->query("SELECT * FROM $default->owl_sessions_table WHERE sessid = '$this->sessid'"); 
      // any matching session ids?
      $numrows = $CheckSess->num_rows($CheckSess);
      if (!$numrows) die("$owl_lang->err_sess_notvalid"); 
      // return if we are a.o.k.
      while ($CheckSess->next_record())
      {
         $this->sessdata["sessid"] = $CheckSess->f("sessid");
      } 
      return $this;
   } 
} 

function fCheckIfReviewer ($file_id)
{
   global $default, $userid;
   $dbCheck = new Owl_DB;

   $dbCheck->query("SELECT file_id from $default->owl_peerreview_table where reviewer_id = '$userid' and file_id = '$file_id' ");
   if ($dbCheck->num_rows() > 0)
   {
      return true;
   }
   return false;   
}

function fCountFileType ($id, $type)
{
   global $default, $userid;
   $GetItems = new Owl_DB;

   $GetItems->query("SELECT id FROM $default->owl_files_table WHERE url = '$type' AND parent = '$id' AND approved = '1'");

   if ($default->restrict_view == 1)
   {
      while ($GetItems->next_record())
      {
         $bFileDownload = check_auth($GetItems->f("id"), "file_download", $userid, false, false);
         if ($bFileDownload)
         {
            $iFileCount++;
         }
     }
   }
   else
   {
      $iFileCount = $GetItems->num_rows();
   }
   return $iFileCount;
}

// --------------------------------
function check_for_sess ($uid)
{
   global $default;

   $mysess = 0;
   $sql = new Owl_DB;
   $sql->query("SELECT * from $default->owl_sessions_table where usid = '$uid' and ip = '0' ORDER BY lastused ASC");
   while ($sql->next_record())
   {
      $time = time();
      if (($time - $sql->f("lastused")) <= $default->owl_timeout)
      {
         $mysess = $sql->f("sessid");
         if (!($default->remember_me))
         {
            $sql->query("UPDATE $default->owl_sessions_table set lastused = '$time' where sessid = '$mysess'");
         }
         break;
      } 
   } 
   if ($mysess == 0)
   {
      $session = new Owl_Session;
      $userid = $session->Open_Session(0, $uid);
      $mysess = $userid->sessdata["sessid"];
      $sql->query("UPDATE $default->owl_sessions_table set ip = '0' where sessid = '$mysess'");
   } 
   return $mysess;
} 

function notify_file_owner($iFileId, $comment)
{
   global $default, $userid;
   //global $owl_lang;

   $sql = new Owl_DB;
   $getuser = new Owl_DB;

   $sql->query("SELECT * from $default->owl_files_table where id = '$iFileId'");

   $sql->next_record();

   $iCreatorId = $sql->f("creatorid");
   $sFileName = $sql->f("filename");
   $iParent = $sql->f("parent");

   $getuser->query("SELECT language, email,comment_notify,name from $default->owl_users_table where id = '$iCreatorId' and disabled = '0'");
   $getuser->next_record();

   if ($getuser->f("comment_notify") == 1)
   {
      $language = $getuser->f("language");
      if (empty($language))
      {
         $language = $default->owl_lang;
      }
      if (file_exists("$default->owl_fs_root/locale/$language/language.inc"))
      {
         include("$default->owl_fs_root/locale/$language/language.inc");
      }
      $mail = new phpmailer();
      if ($default->use_smtp)
      {
         $mail->IsSMTP(); // set mailer to use SMTP
         if ($default->use_smtp_auth)
         {
            $mail->SMTPAuth = "true"; // turn on SMTP authentication
            $mail->Username = "$default->smtp_auth_login "; // SMTP username
            $mail->Password = "$default->smtp_passwd"; // SMTP password
         } 
      } 
      $mail->Host = "$default->owl_email_server"; // specify main and backup server
      $mail->From = "$default->owl_email_from";
      $mail->FromName = "$default->owl_email_fromname";
      $mail->AddAddress($getuser->f("email"));
      $mail->AddReplyTo("$default->owl_email_replyto", "OWL Intranet");
      $mail->WordWrap = 50; // set word wrap to 50 characters
      $mail->IsHTML(true); // set email format to HTML
      $mail->Subject = "$default->owl_email_subject  $owl_lang->notif_subject_comment";
      $mail->Body = "<html><body>" . "$owl_lang->notif_salutation " . $getuser->f("name") . ",<br></br><br></br>";
      $mail->Body .= uid_to_name($userid) . " $owl_lang->notif_comment_1 " . get_dirpath($iParent) . "/" . $sFileName . "<br></br><br></br>";
      $mail->Body .= "$owl_lang->notif_comment_2<br></br><br></br>";
      $mail->Body .= nl2br($comment) . "<br /><br /><br />";
      $mail->Body .= "</body></html>";

      $mail->Body .= "</body></html>";
      if (!$mail->Send() && $default->debug == true)
      {
         printError("DEBUG: " . $owl_lang->err_email, $mail->ErrorInfo);
      } 
   } 
} 

function notify_monitored_folders ($parent, $filename)
{
   global $default, $userid;
   //global $owl_lang;

   $sql = new Owl_DB;
   $getuser = new Owl_DB; 
   // For each user that want to receive notification of an UPDATE of this file
   
   $sql->query("SELECT f.id, fid, name, description, parent, userid, filename from $default->owl_files_table f, $default->owl_monitored_folder_table m where f.filename = '$filename' and f.parent = '$parent' and m.fid = '$parent'");

   while ($sql->next_record())
   {
      $CurrentUser = $sql->f("userid");
      $getuser->query("SELECT id, email,language,attachfile from $default->owl_users_table where id = '$CurrentUser' and disabled = '0'");
      $getuser->next_record();

      if (check_auth($sql->f("id"), "file_download", $getuser->f(id)) == 1 and $getuser->f(id) != $userid)
      {
         // END BUG 548994 More Below
         $path = find_path($sql->f("parent"));
         $filename = $sql->f("filename"); 
         // $newpath = ereg_replace(" ","%20",$path);
         $newpath = $path; 
         // $newfilename = ereg_replace(" ","%20",$sql->f("filename"));
         $newfilename = $sql->f("filename");
         $DefUserLang = $getuser->f("language");
         if(empty($DefUserLang))
         {         
            $DefUserLang = $default->owl_lang; 
         }
         require("$default->owl_fs_root/locale/$DefUserLang/language.inc");

         $r = preg_split("(\;|\,)", $getuser->f("email"));
         reset ($r);
         while (list ($occ, $email) = each ($r))
         { 
            $tempsess = check_for_sess($getuser->f("id"));

            $mail = new phpmailer();
            if ($default->use_smtp)
            {
               $mail->IsSMTP(); // set mailer to use SMTP
               if ($default->use_smtp_auth)
               {
                  $mail->SMTPAuth = "true"; // turn on SMTP authentication
                  $mail->Username = "$default->smtp_auth_login "; // SMTP username
                  $mail->Password = "$default->smtp_passwd"; // SMTP password
               } 
            } 
            $mail->Host = "$default->owl_email_server"; // specify main and backup server
            $mail->From = "$default->owl_email_from";
            $mail->FromName = "$default->owl_email_fromname";
            $mail->AddAddress($email);
            $mail->AddReplyTo("$default->owl_email_replyto", "OWL Intranet");
            $mail->WordWrap = 50; // set word wrap to 50 characters
            $mail->IsHTML(true); // set email format to HTML
            $mail->Subject = "$default->owl_email_subject $owl_lang->notif_subject_monitor";
            if ($type != "url")
            {
               if ($getuser->f("attachfile") == 1)
               {
                  //$desc = ereg_replace("[\\]", "", $sql->f("description"));
                  $desc = stripslashes($sql->f("description"));
                  $mail->Body = "<html><body>" . "$owl_lang->notif_msg<br /><br />" . "$owl_lang->title: " . $sql->f("name") . "<br /><br />$owl_lang->description: $desc <br /><br />";
                  $mail->Body .= $owl_lang->owl_path . $path . "/" . $filename;
                  $mail->Body .= "<br /><br />" . $owl_lang->notif_user . " " .uid_to_name($userid);
                  //$mail->altBody = "$owl_lang->notif_msg_alt\n\n" . "$owl_lang->title: " . $sql->f("name") . "\n\n $owl_lang->description: $desc \n\n";
                  //$mail->altBody .= $owl_lang->owl_path . $path . "/" . $filename;
                  if (!$default->owl_use_fs)
                  {
                     if (file_exists("$default->owl_FileDir/$filename"))
                     {
                        unlink("$default->owl_FileDir/$filename");
                     } 
                     $file = fopen("$default->owl_FileDir/$filename", 'wb');
                     $getfile = new Owl_DB;
                     $getfile->query("SELECT data,compressed from $default->owl_files_data_table where id='$fid'");
                     while ($getfile->next_record())
                     {
                        if ($getfile->f("compressed"))
                        {
                           $tmpfile = $default->owl_tmpdir . "/owltmp.$fid.gz";
                           $uncomptmpfile = $default->owl_tmpdir . "/owltmp.$fid";
                           if (file_exists($tmpfile)) unlink($tmpfile);

                           $fp = fopen($tmpfile, "w");
                           fwrite($fp, $getfile->f("data"));
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
                           fwrite($file, $getfile->f("data"));
                        } 
                     } 
                     fclose($file); 
                     // $mail->AddAttachment("$default->owl_FileDir/$newfilename");
                     $mimeType = fGetMimeType($newfilename);
                     $mail->AddAttachment("$default->owl_FileDir/$newfilename", "" , "base64" , "$mimeType");
                  } 
                  else
                  {
                     $mimeType = fGetMimeType($newfilename);
                     $mail->AddAttachment("$default->owl_FileDir/$newpath/$newfilename", "" , "base64" , "$mimeType"); 
                     // $mail->AddAttachment("$default->owl_FileDir/$newpath/$newfilename");
                  } 
               } 
               else
               {
                  //$desc = ereg_replace("[\\]", "", $sql->f("description"));
                  $desc = stripslashes($sql->f("description"));
                  $link = $default->owl_notify_link . "browse.php?sess=$tempsess&parent=" . $sql->f("parent") . "&expand=1&fileid=" . $sql->f("fid");
                  $mail->Body = "<html><body>" . "$owl_lang->notif_msg<br /><br />" . "$owl_lang->title: " . $sql->f("name") . "<br /><br />URL: <A HREF=" . $link . ">" . $link . "</A><br /><br />$owl_lang->description: $desc <br /><br />";
                  $mail->Body .= $owl_lang->owl_path . $path . "/" . $filename;
                  $mail->Body .= "<br /><br />" . $owl_lang->notif_user . " " .uid_to_name($userid);
                  //$mail->altBody = "$owl_lang->notif_msg_alt\n\n" . "$owl_lang->title: " . $sql->f("name") . "\n\n $owl_lang->description: $desc \n\n";
                  //$mail->altBody .= $owl_lang->owl_path . $path . "/" . $filename;
               } 
            } 
            else
            {
               $desc = stripslashes($sql->f("description"));
               //$desc = ereg_replace("[\\]", "", $sql->f("description"));
               $mail->Body = "<html><body>" . "URL: <A HREF=" . $newfilename . ">" . $newfilename . "</A> <br /><br />$owl_lang->notif_msg<br /><br />" . "$owl_lang->title: " . $sql->f("name") . "<br /><br />$owl_lang->description: $desc <br /><br />";
               $mail->Body .= $owl_lang->owl_path . $path . "/" . $filename;
               $mail->Body .= "<br /><br />" . $owl_lang->notif_user . " " .uid_to_name($userid);
               //$mail->altBody = "URL: $newfilename \n\n$owl_lang->notif_msg_alt\n\n" . "$owl_lang->title: " . $sql->f("name") . "\n\n $owl_lang->description: $desc \n\n";
               //$mail->altBody .= $owl_lang->owl_path . $path . "/" . $filename;
            } 
            $mail->Body .= "</body></html>";
            if (!$mail->Send() && $default->debug == true)
            {
               printError("DEBUG: " . $owl_lang->err_email, $mail->ErrorInfo);
            } 
            if (!$default->owl_use_fs && $sql->f("attachfile") == 1)
            {
               unlink("$default->owl_FileDir/$newfilename");
            } 
         } 
      } 
   } 
} 
// --------------------------------
function notify_monitored ($fid, $type)
{
   global $default, $userid;
   //global $owl_lang;

   $sql = new Owl_DB;
   $getuser = new Owl_DB; 
   // For each user that want to receive notification of an UPDATE of this file
   
   $sql->query("SELECT * from $default->owl_files_table f, $default->owl_monitored_file_table m where f.id = m.fid and m.fid = '$fid'");

   while ($sql->next_record())
   {
      $CurrentUser = $sql->f("userid");
      $getuser->query("SELECT id, email,language,attachfile from $default->owl_users_table where id = '$CurrentUser' and disabled = '0'");
      $getuser->next_record();

      if (check_auth($fid, "file_download", $getuser->f(id)) == 1 and $getuser->f(id) != $userid)
      {
         // END BUG 548994 More Below
         $path = find_path($sql->f("parent"));
         $filename = $sql->f("filename"); 
         $newpath = $path;
         $newfilename = $sql->f("filename"); 
         $DefUserLang = $getuser->f("language");
         if(empty($DefUserLang))
         {
            $DefUserLang = $default->owl_lang;
         }

         require("$default->owl_fs_root/locale/$DefUserLang/language.inc");

         $r = preg_split("(\;|\,)", $getuser->f("email"));
         reset ($r);
         while (list ($occ, $email) = each ($r))
         { 
            $tempsess = check_for_sess($getuser->f("id"));

            $mail = new phpmailer();
            if ($default->use_smtp)
            {
               $mail->IsSMTP(); // set mailer to use SMTP
               if ($default->use_smtp_auth)
               {
                  $mail->SMTPAuth = "true"; // turn on SMTP authentication
                  $mail->Username = "$default->smtp_auth_login "; // SMTP username
                  $mail->Password = "$default->smtp_passwd"; // SMTP password
               } 
            } 
            $mail->Host = "$default->owl_email_server"; // specify main and backup server
            $mail->From = "$default->owl_email_from";
            $mail->FromName = "$default->owl_email_fromname";
            $mail->AddAddress($email);
            $mail->AddReplyTo("$default->owl_email_replyto", "OWL Intranet");
            $mail->WordWrap = 50; // set word wrap to 50 characters
            $mail->IsHTML(true); // set email format to HTML
            $mail->Subject = "$default->owl_email_subject $owl_lang->notif_subject_monitor";
            if ($type != "url")
            {
               if ($getuser->f("attachfile") == 1)
               {
                  //$desc = ereg_replace("[\\]", "", $sql->f("description"));
                  $desc = stripslahes($sql->f("description"));
                  $mail->Body = "<html><body>" . "$owl_lang->notif_msg<br /><br />" . "$owl_lang->title: " . $sql->f("name") . "<br /><br />$owl_lang->description: $desc <br /><br />";
                  $mail->Body .= $owl_lang->owl_path . $path . "/" . $filename;
                  $mail->Body .= "<br /><br />" . $owl_lang->notif_user . " " .uid_to_name($userid);
                  //$mail->altBody = "$owl_lang->notif_msg_alt\n\n" . "$owl_lang->title: " . $sql->f("name") . "\n\n $owl_lang->description: $desc \n\n";
                  //$mail->altBody .= $owl_lang->owl_path . $path . "/" . $filename;
                  if (!$default->owl_use_fs)
                  {
                     if (file_exists("$default->owl_FileDir/$filename"))
                     {
                        unlink("$default->owl_FileDir/$filename");
                     } 
                     $file = fopen("$default->owl_FileDir/$filename", 'wb');
                     $getfile = new Owl_DB;
                     $getfile->query("SELECT data,compressed from $default->owl_files_data_table where id='$fid'");
                     while ($getfile->next_record())
                     {
                        if ($getfile->f("compressed"))
                        {
                           $tmpfile = $default->owl_tmpdir . "/owltmp.$fid.gz";
                           $uncomptmpfile = $default->owl_tmpdir . "/owltmp.$fid";
                           if (file_exists($tmpfile)) unlink($tmpfile);

                           $fp = fopen($tmpfile, "w");
                           fwrite($fp, $getfile->f("data"));
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
                           fwrite($file, $getfile->f("data"));
                        } 
                     } 
                     fclose($file); 
                     $mimeType = fGetMimeType($newfilename);
                     $mail->AddAttachment("$default->owl_FileDir/$newfilename", "" , "base64" , "$mimeType");
                  } 
                  else
                  { 
                     $mimeType = fGetMimeType($newfilename);
                     $mail->AddAttachment("$default->owl_FileDir/$newpath/$newfilename", "" , "base64" , "$mimeType");
                  } 
               } 
               else
               {
                  //$desc = ereg_replace("[\\]", "", $sql->f("description"));
                  $desc = stripslashes($sql->f("description"));
                  $link = $default->owl_notify_link . "browse.php?sess=$tempsess&parent=" . $sql->f("parent") . "&expand=1&fileid=" . $sql->f("fid");
                  $mail->Body = "<html><body>" . "$owl_lang->notif_msg<br /><br />" . "$owl_lang->title: " . $sql->f("name") . "<br /><br />URL: <A HREF=" . $link . ">" . $link . "</A><br /><br />$owl_lang->description: $desc <br /><br />";
                  $mail->Body .= $owl_lang->owl_path . $path . "/" . $filename;
                  $mail->Body .= "<br /><br />" . $owl_lang->notif_user . " " .uid_to_name($userid);
                  //$mail->altBody = "$owl_lang->notif_msg_alt\n\n" . "$owl_lang->title: " . $sql->f("name") . "\n\n $owl_lang->description: $desc \n\n";
                  //$mail->altBody .= $owl_lang->owl_path . $path . "/" . $filename;
               } 
            } 
            else
            {
               //$desc = ereg_replace("[\\]", "", $sql->f("description"));
               $desc = stripslashes($sql->f("description"));
               $mail->Body = "<html><body>" . "URL: <A HREF=" . $newfilename . ">" . $newfilename . "</A> <br /><br />$owl_lang->notif_msg<br /><br />" . "$owl_lang->title: " . $sql->f("name") . "<br /><br />$owl_lang->description: $desc <br /><br />";
               $mail->Body .= $owl_lang->owl_path . $path . "/" . $filename;
               $mail->Body .= "<br /><br />" . $owl_lang->notif_user . " " .uid_to_name($userid);
               //$mail->altBody = "URL: $newfilename \n\n$owl_lang->notif_msg_alt\n\n" . "$owl_lang->title: " . $sql->f("name") . "\n\n $owl_lang->description: $desc \n\n";
               //$mail->altBody .= $owl_lang->owl_path . $path . "/" . $filename;
            } 
            $mail->Body .= "</body></html>";
            if (!$mail->Send() && $default->debug == true)
            {
               printError("DEBUG: " . $owl_lang->err_email, $mail->ErrorInfo);
            } 
            if (!$default->owl_use_fs && $sql->f("attachfile") == 1)
            {
               unlink("$default->owl_FileDir/$newfilename");
            } 
         } 
      } 
   } 
} 



function notify_reviewer ($iUserId, $iFileId , $usermessage, $doc_action = "", $reason = "")
{
   global $default, $userid;

   $sql = new Owl_DB; 

   $sql->query("SELECT email,language,attachfile from $default->owl_users_table where id = '$iUserId'");
   $sql->next_record();

   $DefUserLang = $sql->f("language");
   if(empty($DefUserLang))
   {
      $DefUserLang = $default->owl_lang;
   }

   $email = $sql->f("email");

   $sql->query("SELECT filename, name, description from $default->owl_files_table where id = '$iFileId'");
   $sql->next_record();

   $tile = $sql->f("name");
   $desc = $sql->f("description");
   $filename = $sql->f("filename");

   require("$default->owl_fs_root/locale/$DefUserLang/language.inc");

   switch ($doc_action)
   {
      case "final_approved":
      case "approved":
         $email_subject = $owl_lang->peer_subj_approved;
         $body = "$usermessage <br /><br />";
         if ($doc_action == "final_approved")
         {
            $body .= $owl_lang->peer_file_final . "<br /><br />";
            $body .= $owl_lang->peer_final_body;
         }

         $body .= "$owl_lang->peer_approved_body" .uid_to_name($userid) ." <br />";
         $body .= "$owl_lang->peer_file_approved $filename <br />";
         $body .= "$owl_lang->title: $title" . "<br />";
         $body .= $owl_lang->description .": " . $desc ."<br /><br />";
         break;
      case "rejected":
         $email_subject = $owl_lang->peer_subj_rejected;
         $body = "$usermessage <br /><br />";
         $body .= "$owl_lang->peer_rejected_body" .uid_to_name($userid) ." <br />";
         $body .= "$owl_lang->peer_file_rejected $filename <br />";
         $body .= "$owl_lang->title: $title" . "<br />";
         $body .= $owl_lang->description .": " . $desc ."<br /><br />";
         $body .= "<br /><br />$owl_lang->peer_reject_reason $reason" ;
         break;
      case "reminder":
         $email_subject = $owl_lang->peer_subj_reminder;
         break;
      default:
         $email_subject = $owl_lang->peer_subj_review;
         $body = "$usermessage <br /><br />";
         $body .= "$owl_lang->peer_review_body<br />";
         $body .= "$owl_lang->peer_file_to_review $filename <br />";
         $body .= "$owl_lang->title: $title" . "<br />";
         $body .= $owl_lang->description .": " . $desc ."<br /><br />";
         $body .= $owl_lang->notif_user . ": " .uid_to_name($userid);
         break;
   } 

   $mail = new phpmailer();
                                                                                                                                                                                                 
   if ($default->use_smtp)
   {
      $mail->IsSMTP(); // set mailer to use SMTP
      if ($default->use_smtp_auth)
      {
         $mail->SMTPAuth = "true"; // turn on SMTP authentication
         $mail->Username = "$default->smtp_auth_login "; // SMTP username
         $mail->Password = "$default->smtp_passwd"; // SMTP password
      }
   }
   $mail->Host = "$default->owl_email_server"; // specify main and backup server
   $mail->From = "$default->owl_email_from";
   $mail->FromName = "$default->owl_email_fromname";
   $mail->AddAddress($email);
   $mail->AddReplyTo("$default->owl_email_replyto", "OWL Intranet");
   $mail->WordWrap = 50; // set word wrap to 50 characters
   $mail->IsHTML(true); // set email format to HTML

   $mail->Subject = $email_subject;

   $mail->Body = "<html><body>";
   $mail->Body .= $body;
   $mail->Body .= "</body></html>";

   if (!$mail->Send() && $default->debug == true)
   {
      printError("DEBUG: " . $owl_lang->err_email, $mail->ErrorInfo);
   }
}

function notify_users($groupid, $flag, $parent, $filename, $title, $desc, $type)
{
   global $default, $userid;
   //global $owl_lang;

   $sql = new Owl_DB; 
   $desc = stripslashes($desc);
   $title = stripslashes($title);

   $path = find_path($parent);
   $sql->query("SELECT id from $default->owl_files_table where filename='$filename' AND parent='$parent'");
   $sql->next_record();
   $fileid = $sql->f("id");


   //$sql->query("SELECT distinct id, email,language,attachfile from $default->owl_users_table u left join $default->owl_users_grpmem_table m on u.id=m.userid where notify = 1 and (u.groupid = $groupid or m.groupid = $groupid)");
   $sql->query("SELECT distinct id, email,language,attachfile from $default->owl_users_table u left join $default->owl_users_grpmem_table m on u.id=m.userid where notify = '1' and disabled = '0' and (u.groupid='$groupid' or m.groupid='$groupid') and u.id <> '$userid'");
     
   while ($sql->next_record())
   {
      if (check_auth($fileid, "file_download", $sql->f("id")) == 1)
      {
         $newpath = $path; 
         $newfilename = $filename;
         $DefUserLang = $sql->f("language");
         if(empty($DefUserLang))
         {
            $DefUserLang = $default->owl_lang;
         }
         require("$default->owl_fs_root/locale/$DefUserLang/language.inc");

         $r = preg_split("(\;|\,)", $sql->f("email"));
         reset ($r);
         while (list ($occ, $email) = each ($r))
         {
            $mail = new phpmailer(); 
            // Create a temporary session id, the user
            // will need to get to this file before
            // the default session timeout

            // $session = new Owl_Session;
            $tempsess = check_for_sess($sql->f("id"));

            if ($flag == 0)
            {
               if ($default->use_smtp)
               {
                  $mail->IsSMTP(); // set mailer to use SMTP
                  if ($default->use_smtp_auth)
                  {
                     $mail->SMTPAuth = "true"; // turn on SMTP authentication
                     $mail->Username = "$default->smtp_auth_login "; // SMTP username
                     $mail->Password = "$default->smtp_passwd"; // SMTP password
                  } 
               } 
               $mail->Host = "$default->owl_email_server"; // specify main and backup server
               $mail->From = "$default->owl_email_from";
               $mail->FromName = "$default->owl_email_fromname";
               $mail->AddAddress($email);
               $mail->AddReplyTo("$default->owl_email_replyto", "OWL Intranet");
               $mail->WordWrap = 50; // set word wrap to 50 characters
               $mail->IsHTML(true); // set email format to HTML
               $mail->Subject = "$default->owl_email_subject $owl_lang->notif_subject_new";
               if ($type != "url")
               {
                  if ($sql->f("attachfile") == 1)
                  {
                     $mail->Body = "<html><body>" . "$owl_lang->notif_msg<br /><br />" . "$owl_lang->title: $title" . "<br /><br />$owl_lang->description: $desc<br /><br />";
                     $mail->Body .= $owl_lang->owl_path . $path . "/" . $filename;
                     $mail->Body .= "<br /><br />" . $owl_lang->notif_user . " " .uid_to_name($userid);
                     //$mail->altBody = "$owl_lang->notif_msg_alt\n\n" . "$owl_lang->title: $title" . "\n\n $owl_lang->description: $desc\n\n";
                     //$mail->altBody .= $owl_lang->owl_path . $path . "/" . $filename;

                     if (!$default->owl_use_fs)
                     {
                        if (file_exists("$default->owl_FileDir/$filename"))
                        {
                           unlink("$default->owl_FileDir/$filename");
                        } 
                        $file = fopen("$default->owl_FileDir/$filename", 'wb');
                        $getfile = new Owl_DB;
                        $getfile->query("SELECT data,compressed from $default->owl_files_data_table where id='$fileid'");
                        while ($getfile->next_record())
                        {
                           if ($getfile->f("compressed"))
                           {
                              $tmpfile = $default->owl_tmpdir . "/owltmp.$fileid.gz";
                              $uncomptmpfile = $default->owl_tmpdir . "/owltmp.$fileid";
                              if (file_exists($tmpfile)) unlink($tmpfile);

                              $fp = fopen($tmpfile, "w");
                              fwrite($fp, $getfile->f("data"));
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
                              fwrite($file, $getfile->f("data"));
                           } 
                        } 
                        fclose($file); 
                        $mimeType = fGetMimeType($newfilename);
                        $mail->AddAttachment("$default->owl_FileDir/$newfilename", "" , "base64" , "$mimeType");
                     } 
                     else
                     { 
                        $mimeType = fGetMimeType($newfilename);
                        $mail->AddAttachment("$default->owl_FileDir/$newpath/$newfilename", "" , "base64" , "$mimeType");
                     } 
                  } 
                  else
                  {
                     $link = $default->owl_notify_link . "browse.php?sess=$tempsess&parent=$parent&expand=1&fileid=$fileid";
                     $mail->Body = "<html><body>" . "$owl_lang->notif_msg_link<br /><br />" . "$owl_lang->title: " . $title . "<br /><br />URL: <A HREF=" . $link . ">" . $link . "</A><br /><br />$owl_lang->description: $desc<br /><br />";
                     $mail->Body .= $owl_lang->owl_path . $path . "/" . $filename;
                     $mail->Body .= "<br /><br />" . $owl_lang->notif_user . " " .uid_to_name($userid);
                     //$mail->altBody = "$owl_lang->notif_msg_alt\n\n" . "$owl_lang->title: $title" . "\n\n $owl_lang->description: $desc\n\n";
                     //$mail->altBody .= $owl_lang->owl_path . $path . "/" . $filename;
                  } 
               } 
               else
               {
                  $mail->Body = "<html><body>" . "URL: <A HREF=" . $newfilename . ">" . $newfilename . "</A> <br /><br />$owl_lang->notif_msg_link<br /><br />" . "$owl_lang->title: " . $title . "<br /><br />$owl_lang->description: $desc <br /><br />";
                  $mail->Body .= $owl_lang->owl_path . $path . "/" . $filename;
                  $mail->Body .= "<br /><br />" . $owl_lang->notif_user . " " .uid_to_name($userid);
                  //$mail->altBody = "URL: $newfilename \n\n$owl_lang->notif_msg_alt\n\n" . "$owl_lang->title: $title" . "\n\n $owl_lang->description: $desc\n\n";
                  //$mail->altBody .= $owl_lang->owl_path . $path . "/" . $filename;
               } 
            } 
            else
            {
               $mail = new phpmailer();
               if ($default->use_smtp)
               {
                  $mail->IsSMTP(); // set mailer to use SMTP
                  if ($default->use_smtp_auth)
                  {
                     $mail->SMTPAuth = "true"; // turn on SMTP authentication
                     $mail->Username = "$default->smtp_auth_login "; // SMTP username
                     $mail->Password = "$default->smtp_passwd"; // SMTP password
                  } 
               } 
               $mail->Host = "$default->owl_email_server"; // specify main and backup server
               $mail->From = "$default->owl_email_from";
               $mail->FromName = "$default->owl_email_fromname";
               $mail->AddAddress($email);
               $mail->AddReplyTo("$default->owl_email_replyto", "OWL Intranet");
               $mail->WordWrap = 50; // set word wrap to 50 characters
               $mail->IsHTML(true); // set email format to HTML
               $mail->Subject = "$default->owl_email_subject $owl_lang->notif_subject_upd";
               if ($type != "url")
               {
                  if ($sql->f("attachfile") == 1)
                  {
                     $mail->Body = "<html><body>" . "$owl_lang->notif_msg<br /><br />" . "$owl_lang->title: $title" . "<br /><br />$owl_lang->description: $desc<br /><br />";
                     $mail->Body .= $owl_lang->owl_path . $path . "/" . $filename;
                     $mail->Body .= "<br /><br />" . $owl_lang->notif_user . " " .uid_to_name($userid);
                     //$mail->altBody = "$owl_lang->notif_msg_alt\n\n" . "$owl_lang->title: $title" . "\n\n $owl_lang->description: $desc \n\n";
                     //$mail->altBody .= $owl_lang->owl_path . $path . "/" . $filename;
                     if (!$default->owl_use_fs)
                     {
                        if (file_exists("$default->owl_FileDir/$filename"))
                        {
                           unlink("$default->owl_FileDir/$filename");
                        } 
                        $file = fopen("$default->owl_FileDir/$filename", 'wb');
                        $getfile = new Owl_DB;
                        $getfile->query("SELECT data,compressed from $default->owl_files_data_table where id='$fileid'");
                        while ($getfile->next_record())
                        {
                           if ($getfile->f("compressed"))
                           {
                              $tmpfile = $default->owl_tmpdir . "/owltmp.$fileid.gz";
                              $uncomptmpfile = $default->owl_tmpdir . "/owltmp.$fileid";
                              if (file_exists($tmpfile)) unlink($tmpfile);

                              $fp = fopen($tmpfile, "w");
                              fwrite($fp, $getfile->f("data"));
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
                              fwrite($file, $getfile->f("data"));
                           } 
                        } 
                        fclose($file); 
                        $mimeType = fGetMimeType($newfilename);
                        $mail->AddAttachment("$default->owl_FileDir/$newfilename", "" , "base64" , "$mimeType");
                     } 
                     else
                     { 
                        $mimeType = fGetMimeType($newfilename);
                        $mail->AddAttachment("$default->owl_FileDir/$newpath/$newfilename", "" , "base64" , "$mimeType");
                     } 
                  } 
                  else
                  {
                     $link = $default->owl_notify_link . "browse.php?sess=$tempsess&parent=$parent&expand=1&fileid=$fileid";
                     $mail->Body = "<html><body>" . "$owl_lang->notif_msg_link<br /><br />" . "$owl_lang->title: " . $title . "<br /><br />URL: <A HREF=" . $link . ">" . $link . "</A><br /><br />$owl_lang->description: $desc <br /><br />";
                     $mail->Body .= $owl_lang->owl_path . $path . "/" . $filename;
                     $mail->Body .= "<br /><br />" . $owl_lang->notif_user . " " .uid_to_name($userid);
                     //$mail->altBody = "$owl_lang->notif_msg_alt\n\n" . "$owl_lang->title: $title" . "\n\n $owl_lang->description: $desc \n\n";
                     //$mail->altBody .= $owl_lang->owl_path . $path . "/" . $filename;
                  } 
               } 
               else
               {
                  $mail->Body = "<html><body>" . "URL: <A HREF=" . $newfilename . ">" . $newfilename . "</A> <br /><br />$owl_lang->notif_msg_link<br /><br />" . "$owl_lang->title: " . $title . "<br /><br />$owl_lang->description:  $desc <br /><br />";
                  $mail->Body .= $owl_lang->owl_path . $path . "/" . $filename;
                  $mail->Body .= "<br /><br />" . $owl_lang->notif_user . " " .uid_to_name($userid);
                  //$mail->altBody = "URL: $newfilename \n\n$owl_lang->notif_msg_alt\n\n" . "$owl_lang->title: $title" . "\n\n $owl_lang->description: $desc \n\n";
                  //$mail->altBody .= $owl_lang->owl_path . $path . "/" . $filename;
               } 
            } 
            $mail->Body .= "</body></html>";

            if (!$mail->Send() && $default->debug == true)
            {
               printError("DEBUG: " . $owl_lang->err_email, $mail->ErrorInfo);
            } 

            if (!$default->owl_use_fs && $sql->f("attachfile") == 1)
            {
               if ($type == "")
               {
                  unlink("$default->owl_FileDir/$newfilename");
               }
            } 
         } 
      } 
   } 
} 

function fInsertUnzipedFiles($path, $cParent, $FolderPolicy, $FilePolicy, $description, $groupid, $userid, $metadata, $title, $major_revision, $minor_revision, $doctype)
{
   global $default, $userid;
   $sql = new OWL_DB;
   $sql_custom = new OWL_DB;

         $dir = dir($path);
         $dir->rewind();
                                                                                                                                                                                                 
         while (false !== ($file = $dir->read()))
         //while ($file = $dir->read())
         {
            if ($file != "." and $file != ".." and $file != "CVS")
            {
               if(is_dir($path . "/" . $file)) 
               {

                  $original_name = $file;
                  $file = trim(ereg_replace("[^$default->list_of_valid_chars_in_file_names]", "",  ereg_replace("%20|^-", "_", $file)));
                  if($original_name != $file)
                  {
                     rename($path. "/" . $original_name,$path . "/" . $file);
                  }
                  $smodified = $sql->now();
                  $sql->query("INSERT into $default->owl_folders_table (name,parent,security,description,groupid,creatorid,smodified) values ('$file', '$cParent', '$FolderPolicy', '$description', '$groupid', '$userid', $smodified)");

                  $newParent = $sql->insert_id($default->owl_folders_table, 'id');

                  fInsertUnzipedFiles($path . "/" .$file, $newParent, $FolderPolicy, $FilePolicy, $description, $groupid, $userid, $metadata, $title, $major_revision, $minor_revision, $doctype);
               }
               else
               {
                  $TheFileSize = filesize($path . "/" . $file);  //get filesize
                  $TheFileTime = date("Y-m-d H:i:s", filemtime($path . "/" . $file));
     
                  $original_name = $file;
                  $file = trim(ereg_replace("[^$default->list_of_valid_chars_in_file_names]", "",  ereg_replace("%20|^-", "_", $file)));
                  if($original_name != $file)
                  {
                     rename($path. "/" . $original_name,$path . "/" . $file);
                  }

                  if ($title == "") 
                  {
                     $ctitle = $file;
                  }
                  else
                  {
                     $ctitle = $title;
                  }
                  $ctitle = stripslashes($ctitle);
                  $ctitle = ereg_replace("'", "\\'" , ereg_replace("[<>]", "", $ctitle));

                  $new_quota = fCalculateQuota($TheFileSize, $userid, "ADD");

                  $result = $sql->query("INSERT INTO $default->owl_files_table (name,filename,f_size,creatorid,parent,created,description,metadata,security,groupid,smodified,checked_out, major_revision, minor_revision, url, doctype, approved) values ('$ctitle', '$file', '$TheFileSize', '$userid', '$cParent', '$TheFileTime' , '$description', '$metadata', '$FilePolicy', '$groupid', '$TheFileTime', '0','$major_revision','$minor_revision', '0', '$doctype', '1')");
                                                                                                                                                                                                 
                  if ( fIsQuotaEnabled($userid) )
                  {
                     $sql->query("UPDATE $default->owl_users_table set quota_current = '$new_quota' where id = '$userid'");
                  }

                  $searchid = $sql->insert_id($default->owl_files_table, 'id');

                  fIndexAFile($file, $path . "/" . $file, $searchid);
               
                  $sql_custom->query("SELECT * from $default->owl_docfields_table  where doc_type_id = '$doctype'");
                  while ($sql_custom->next_record())
                  {
                     $result = $sql->query("INSERT INTO $default->owl_docfieldvalues_table (file_id, field_name, field_value) values ('$searchid', '" . $sql_custom->f("field_name") ."', '" . ${$sql_custom->f("field_name")} ."');");
                  }
                  if ( !$default->owl_use_fs )
                  {
                     if ($default->owl_compressed_database && file_exists($default->gzip_path))
                     {
                        system($default->gzip_path . " " . escapeshellarg($zipedfile));
                        $zipedfile = $path . "/" . $file . ".gz";
                        $fsize = filesize($zipedfile);
                        $compressed = '1';
                     }
                     else
                     {
                        $zipedfile = $path . "/" . $file;
                        $fsize = filesize($zipedfile);
                     }

                     $fd = fopen($zipedfile, 'rb');
                     $filedata = addSlashes(fread($fd, $fsize));
                     fclose($fd);
                     unlink($zipedfile);
                                                                                                                                                                                                    
                     if ($searchid !== null && $filedata)
                     {
                        $sql->query("INSERT into $default->owl_files_data_table (id, data, compressed) values ('$searchid', '$filedata', '$compressed')");
                     }

                  } 
               }
            }
         }
         $dir->close();
}


function fVirusCheck($filename, $name)
{
   global $default, $userid, $parent, $owl_lang;

   //if ( file_exists($default->virus_path))
   if (trim($default->virus_path) <> "")
   {
      system($default->virus_path . " " . $filename, $retval);
      if ($retval > 0)
      {
         owl_syslog(FILE_VIRUS, $userid, $name, $parent, $owl_lang->log_detail, "FILE");
         if ($default->debug == true)
         {
            printError("DEBUG: $owl_lang->virus_infected -- $filename" , "DEBUG: $owl_lang->virus_return_val " . $retval);
         }
         else
         {
            printError($owl_lang->virus_infected);
         }
      }
   }
}

function verify_login($username, $password)
{
   global $default;
   $sql = new Owl_DB;

   if ($username == "admin")
   {
      $default->auth = 0;
   }

   if ( $default->auth == 1)
   {
      $username = addslashes($username);
      $password = addslashes($password);
      $sql->query("SELECT * from $default->owl_users_table where username = '$username'");
   }
   else if ( $default->auth == 2)
   {
      $mbox = @imap_open ("{" . $default->auth_host . "/pop3/notls:" . $default->auth_port . "}INBOX", $username, $password);
      if($mbox)
      {
            $username = addslashes($username);
            $sql->query("SELECT * from $default->owl_users_table where username = '$username'");
            imap_close($mbox);
      }
      else
      {
            $sql->query("SELECT * from $default->owl_users_table where username = 'junkusernamethatwillneverbeused'");
      }
   }
   else if ( $default->auth == 3)
   {
      // LDAP - authenticate the user and if successful get his details from owl db
      // then if he's not in the owl db, login wil fail...
      $error = ldap_authenticate($username, $password);
      if ($error == "0")
      {
         $sql->query("SELECT * from $default->owl_users_table where username = '$username'");
      }
      else
      {
            $sql->query("SELECT * from $default->owl_users_table where username = 'junkusernamethatwillneverbeused'");
      }
   }
   else
   {
      $username = addslashes($username);
      $password = addslashes($password);
      $sql->query("SELECT * from $default->owl_users_table where username = '$username' and password = '" . md5($password) . "'");
   }

   $numrows = $sql->num_rows($sql); 

   // Bozz Begin added Password Encryption above, but for now
   // I will allow admin to use non crypted password until he
   // upgrades all users
   if ($numrows == "1")
   {
      //while ($sql->next_record())
      $sql->next_record();
      //{
         $iFirstDir = $sql->f("firstdir"); 
         $iHomeDir = $sql->f("homedir"); 
         $iMaxSession = $sql->f("maxsessions"); 

         if ($sql->f("disabled") == 1)
         {
            $verified["bit"] = 2;
         }
         else
         {
            $verified["bit"] = 1;
         }
         $verified["user"] = $sql->f("username");
         $verified["uid"] = $sql->f("id");
         $verified["group"] = $sql->f("groupid");
         if (  $iHomeDir <>  $iFirstDir)
         {
            $sql->query("SELECT * from $default->owl_folders_table where id = '$iFirstDir'");
            $numrows = $sql->num_rows($sql);
            if ($numrows == "1")
            {
               $verified["homedir"] = $iFirstDir;
            } 
            else
            {
               $verified["homedir"] = $iHomeDir;
            }
         }
         else
         {
            $verified["homedir"] = $iHomeDir;
         }
         $maxsessions = $iMaxSession + 1;
      //} 
   } 
   else
   { 
      // LOGIN has FAILED, lets see if a valid username has been used
      // 
      $sql->query("SELECT * from $default->owl_users_table where username = '$username'");
      $numrows = $sql->num_rows($sql);
      if ($numrows == "1")
      {
         while ($sql->next_record())
         {
            $verified["uid"] = $sql->f("id");
            $verified["user"] = $sql->f("username");
         } 
      } 
      else
      {
         if ($default->auth == 1)
         {
            die("ACCESS DENIED");
            exit;
         }
      }

   } 
   // remove stale sessions from the database for the user
   // that is signing on.
   
   $time = time() - $default->owl_timeout;
   if ($verified["group"] == 0)
   {
      $sql = new Owl_DB;
      $sql->query("DELETE from $default->owl_sessions_table where lastused <= $time ");
   } 
   else
   {
      $sql = new Owl_DB;
      $sql->query("DELETE from $default->owl_sessions_table where usid = '" . $verified["uid"] . "' and lastused <= $time ");
   } 
   // Check if Maxsessions has been reached
   
   $sql = new Owl_DB;
   $sql->query("SELECT * from $default->owl_sessions_table where ip <> '0' and usid = '" . $verified["uid"] . "'");

   if ($sql->num_rows($sql) >= $maxsessions && $verified["bit"] != 0)
   {
      if ($verified["group"] == 0)
      {
         $verified["bit"] = 1;
      }
      else
      {
         $verified["bit"] = 3;
      }
   } 
   return $verified;
} 

function verify_session($sess)
{
   global $default;
   global $owl_lang;
   global $parent, $fileid;

   $sess = ltrim($sess);
   $verified["bit"] = 0;
   $sql = new Owl_DB;
   $sql->query("SELECT * from $default->owl_sessions_table where sessid = '$sess'");
   $numrows = $sql->num_rows($sql);
   
   $time = time();
   if ($numrows == "1")
   {
   	
      while ($sql->next_record())
      {
      	
         if (getenv("HTTP_CLIENT_IP"))
         {
         	
            $ip = getenv("HTTP_CLIENT_IP");
         } elseif (getenv("HTTP_X_FORWARDED_FOR"))
         {
            $forwardedip = getenv("HTTP_X_FORWARDED_FOR");
            list($ip, $ip2, $ip3, $ip4) = split (",", $forwardedip);
         } 
         else
         {
         	
            $ip = getenv("REMOTE_ADDR");
         } 
         if ($ip == $sql->f("ip") || 0 == $sql->f("ip"))
         {
         	
         	//echo ($time - $sql->f("lastused")).'-'.$default->owl_timeout;
            if (($time - $sql->f("lastused")) <= $default->owl_timeout)
            {
            
               $verified["bit"] = 1;
               $verified["userid"] = $sql->f("usid");
               $verified["currentdb"] = $sql->f("currentdb");
               $sql->query("SELECT * from $default->owl_users_table where id = '" . $verified["userid"] . "'");
               while ($sql->next_record()) $verified["groupid"] = $sql->f("groupid");
            } 
            else
            { 
            	
               if ($default->remember_me)
               {
               	
                  setcookie ("owl_sessid", "");
               }
               if (file_exists("./lib/header.inc"))
               {
               	
                  include_once("./lib/header.inc");
                  include_once("./lib/userheader.inc");
                  
               }
               else
               {
                  if (file_exists("../lib/header.inc"))
                  {
                  	
                     include_once("../lib/header.inc");
                     include_once("../lib/userheader.inc");
                  }
                  else
                  {
                  	
                     include_once("../../lib/header.inc");
                     include_once("../../lib/userheader.inc");
                  }
               }
               
               print("<center>");
               print("<table class='border1' cellspacing='0' cellpadding='0' border='0' width='$default->table_collapse_width'><tr><td align='left' valign='top' width='100%'>\n");
               fPrintButtonSpace(12, 1);
               print("<br />\n");
               print("<table class='border2' cellspacing='0' cellpadding='0' border='0' width='100%'><tr><td align='left' valign='top' width='100%'>\n");
                                       
               if ($default->show_prefs == 1 or $default->show_prefs == 3)
               {                       
                  fPrintPrefs();       
               }                       
         
               fPrintButtonSpace(12, 1);
               print("<br />\n");
               print("<table class='margin2' cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
               print("<tr>\n");        
               print("<td align='left' valign='top'>\n");
               print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
               fPrintFormTextLine("&nbsp;", "", "",  $owl_lang->sesstimeout , "", true);
               print("<tr>");
               print("<td class='form1'>");
               fPrintButtonSpace(1, 1);
               print("</td>");
               print("<td>");          
               print("<table class='border1' cellspacing='0' cellpadding='0' border='0' width='100%'>");
               print("<tr><td valign='top' width='100%'>");
               fPrintButtonSpace(1, 1);
               print("</td>");             
               if ($parent == "" || $fileid == "")
               {                    
                  fPrintButton("$default->owl_root_url/index.php", "btn_login");
               }                 
               else              
               {                 
                  fPrintButton("$default->owl_root_url/index.php?parent=$parent&fileid=$fileid", "btn_login");
               }              
               //print("\t\t<td class='button1' background='$default->owl_graphics_url/$default->sButtonStyle/ui_misc/button1_fill.jpg'>");
               print("\t\t<td class='button1'>");
               print("<input class='fbuttonup1' type='submit' value='$owl_lang->btn_back' alt='$owl_lang->alt_back' title='$owl_lang->alt_back' onclick='history.back();' onmouseover=\"highlightButton('fbuttondown1')\" onmouseout=\"highlightButton('fbuttonup1')\"></input>");
               print("</td>");
               print("</tr></table>\n");
               
               print("</td></tr>");
               print("</table>\n");
               fPrintButtonSpace(12, 1);
               print("<br />\n");
               print("</td></tr></table>\n");

               fPrintButtonSpace(12, 1);

               if ($default->show_prefs == 2 or $default->show_prefs == 3)
               {
                  fPrintPrefs();
               }
               print("</td></tr></table>\n");
               if (file_exists("./lib/footer.inc"))
               {
                  include("./lib/footer.inc");
               }
               else
               {
                  if (file_exists("../lib/footer.inc"))
                  {
                     include("../lib/footer.inc");
                  }
                  else
                  {
                     include("../../lib/footer.inc");
                  }
               }
               //print("</td></tr></table>\n");
               exit();
            } 
         } 
         else
         { 
            if (file_exists("./lib/header.inc"))
            {
               include("./lib/header.inc");
               include("./lib/userheader.inc");
            } 
            else
            {
               include("../lib/header.inc");
               include("../lib/userheader.inc");
            } 
            print("<br></br><br></br><center>" . $owl_lang->sessinuse);
            if ($parent == "" || $fileid == "")
            {
               fPrintButton("$default->owl_root_url/index.php", "btn_login");
            }
            else 
            {
               fPrintButton("$default->owl_root_url/index.php?parent=$parent&fileid=$fileid", "btn_login");
            }
            if (file_exists("./lib/footer.inc"))
            {
               include("./lib/footer.inc");
            } 
            else
            {
               include("../lib/footer.inc");
            } 
            exit;
         } 
      } 
   } 
   return $verified;
} 

function delTree($fid)
{
   global $fCount, $folderList, $default; 
   // delete from database
   $sql = new Owl_DB;
   $del = new Owl_DB;
   $sql->query("DELETE from $default->owl_folders_table where id = '$fid'");
   $sql->query("DELETE from $default->owl_monitored_folder_table where fid = '$fid'");

   $sql->query("SELECT id from $default->owl_files_table where parent = '$fid'"); 
   // Clean up Comments and Monitored Files from each file we are going to
   // delete
   while ($sql->next_record())
   {
      $iFileid = $sql->f("id");
      $del->query("DELETE from $default->owl_monitored_file_table where fid = '$iFileid'");
      $del->query("DELETE from $default->owl_comment_table where fid = '$iFileid'");
      if (!$default->owl_use_fs)
      {
         $del->query("DELETE from $default->owl_files_data_table  where id = '$iFileid'");
      } 
   } 
   $sql->query("DELETE from $default->owl_files_table where parent = '$fid'");

   for ($c = 0; $c < $fCount; $c++)
   {
      if ($folderList[$c][2] == $fid)
      {
         delTree($folderList[$c][0]);
      } 
   } 
} 

function find_path($parent)
{
   global $default;
   $path = fid_to_name($parent);
   $sql = new Owl_DB;
   while ($parent != 1)
   {
      $sql->query("SELECT parent from $default->owl_folders_table where id = '$parent'");
      while ($sql->next_record())
      {
         $path = fid_to_name($sql->f("parent")) . "/" . $path;
         $parent = $sql->f("parent");
      } 
   } 
   return $path;
} 

function fid_to_filename($id)
{
   global $default;
   $sql = new Owl_DB;
   $sql->query("SELECT filename from $default->owl_files_table where id = '$id'");
   while ($sql->next_record()) return $sql->f("filename");
} 

function fid_to_name($parent)
{
   global $default;
   $sql = new Owl_DB;
   if (empty($parent))
   {
      $parent=0;
   }
   $sql->query("SELECT name from $default->owl_folders_table where id = '$parent'");
   while ($sql->next_record())
   {
      return $sql->f("name");
   } 
} 

function flid_to_name($id)
{
   global $default;
   $sql = new Owl_DB;
   $sql->query("SELECT name from $default->owl_files_table where id = '$id'");
   while ($sql->next_record()) return $sql->f("name");
} 

function flid_to_filename($id)
{
   global $default;
   $sql = new Owl_DB;
   $sql->query("SELECT filename from $default->owl_files_table where id = '$id'");
   while ($sql->next_record()) return $sql->f("filename");
} 

function owlusergroup($userid)
{
   global $default;
   $sql = new Owl_DB;
   $sql->query("SELECT groupid from $default->owl_users_table where id = '$userid'");
   while ($sql->next_record()) $groupid = $sql->f("groupid");
   
   return $groupid;
} 

function owlfilecreator($fileid)
{
   global $default;
   $filecreator = 0;
   $sql = new Owl_DB;
   $sql->query("SELECT creatorid from " . $default->owl_files_table . " where id = '$fileid'");
   while ($sql->next_record()) $filecreator = $sql->f("creatorid");
   return $filecreator;
} 

function fid_to_creator($id)
{
   global $default, $owl_lang;
   //$sql = new Owl_DB;
   //$sql->query("SELECT creatorid from " . $default->owl_files_table . " where id = '$id'");
   $sql2 = new Owl_DB;
   //while ($sql->next_record())
   //{
      //$creatorid = $sql->f("creatorid");
      $creatorid = owlfilecreator($id);
      $sql2->query("SELECT name from $default->owl_users_table where id = '" . $creatorid . "'");
      $sql2->next_record();
      if ( $sql2->num_rows() == 0 )
      {
         $name = "<font class=url>" . $owl_lang->orphaned . "</font>";
      }
      else
      {
         $name = $sql2->f("name");
      }
   //} 
   return $name;
} 

function owlfoldercreator($folderid)
{
   global $default;
   $foldercreator = 0;
   $sql = new Owl_DB;
   $sql->query("SELECT creatorid from " . $default->owl_folders_table . " where id = '$folderid'");
   while ($sql->next_record()) $foldercreator = $sql->f("creatorid");
   return $foldercreator;
} 

function flid_to_creator($folderid)
{
   global $default, $owl_lang;
   //$sql = new Owl_DB;
   //$sql->query("SELECT creatorid from " . $default->owl_files_table . " where id = '$id'");
   $sql2 = new Owl_DB;
   //while ($sql->next_record())
   //{
      //$creatorid = $sql->f("creatorid");
      $creatorid = owlfoldercreator($folderid);
      $sql2->query("SELECT name from $default->owl_users_table where id = '" . $creatorid . "'");
      $sql2->next_record();
      if ( $sql2->num_rows() == 0 )
      {
         $name = "<font class=url>" . $owl_lang->orphaned . "</font>";
      }
      else
      {
         $name = $sql2->f("name");
      }
   //} 
   return $name;
} 

function owlfiletype ($fileid)
{
   global $default;
   $filecreator = 0;
   $sql = new Owl_DB;
   $sql->query("SELECT url from " . $default->owl_files_table . " where id = '$fileid'");
   while ($sql->next_record()) $filetype = $sql->f("url");
   return $filetype;
} 
function owlfilegroup($fileid)
{
   global $default;
   $filegroup = 0;
   $sql = new Owl_DB;
   $sql->query("SELECT groupid from $default->owl_files_table where id = '$fileid'");
   while ($sql->next_record()) $filegroup = $sql->f("groupid");
   return $filegroup;
} 

function owlfoldergroup($folderid)
{
   global $default;
   $foldergroup = 0;
   $sql = new Owl_DB;
   $sql->query("SELECT groupid from $default->owl_folders_table where id = '$folderid'");
   while ($sql->next_record()) $foldergroup = $sql->f("groupid");
   return $foldergroup;
} 


function fCurFolderSecurity($folderid)
{
   global $default;

   $sql = new Owl_DB;
   $sql->query("SELECT security from $default->owl_folders_table where id = '$folderid'");
   while ($sql->next_record()) 
   {
      $iFoldSecurity = $sql->f("security");
   }
   return $iFoldSecurity;
} 

function owlfolderparent($folderid)
{
   global $default;

   if ( $default->HomeDir == $folderid )
   {
      $folderparent = 1;
   }
   else
   {
      $sql = new Owl_DB;
      $sql->query("SELECT parent from $default->owl_folders_table where id = '$folderid'");
      while ($sql->next_record()) 
      {
         $folderparent = $sql->f("parent");
      }
   }
   return $folderparent;
} 



function owlfileparent($fileid)
{
   global $default;
   $sql = new Owl_DB;
   $sql->query("SELECT parent from $default->owl_files_table where id = '$fileid'");
   while ($sql->next_record()) $fileparent = $sql->f("parent");
   return $fileparent;
} 


function group_to_name($id)
{
   global $default;
   $sql = new Owl_DB;
   $sql->query("SELECT name from $default->owl_groups_table where id = '$id'");
   while ($sql->next_record()) return $sql->f("name");
} 

function uid_to_name($id)
{
   global $default;
   $name = "";
   $sql = new Owl_DB;
   $sql->query("SELECT name from $default->owl_users_table where id = '$id'");
   while ($sql->next_record()) $name = $sql->f("name");
   if ($name == "") $name = "Owl";
   return $name;
} 

function uid_to_uname($id)
{
   global $default;
   $name = "";
   $sql = new Owl_DB;
   $sql->query("SELECT username from $default->owl_users_table where id = '$id'");
   while ($sql->next_record()) $username = $sql->f("username");
   if ($username == "") $username = "Owl";
   return $username;
}

function prefaccess($id)
{
   global $default;
   $prefaccess = 1;
   $sql = new Owl_DB;
   $sql->query("SELECT noprefaccess from $default->owl_users_table where id = '$id'");
   while ($sql->next_record()) $prefaccess = !($sql->f("noprefaccess"));
   return $prefaccess;
} 
// only get dir path from db
function get_dirpath($parent)
{
   global $default;
   global $sess, $expand;
   $name = fid_to_name($parent);
   $navbar = "$name";
   $new = $parent;
   while ($new != "1")
   {
      $sql = new Owl_DB;
      $sql->query("SELECT parent from $default->owl_folders_table where id = '$new'");
      while ($sql->next_record()) $newparentid = $sql->f("parent");
      if ($newparentid == "") break;
      $name = fid_to_name($newparentid);
      $navbar = "$name/" . $navbar;
      $new = $newparentid;
   } 
   return $navbar;
} 

function get_dirpathfs($parent)
{
   global $default;
   global $sess, $expand;
   $name = fid_to_name($parent);
   $navbar = "$name";
   $new = $parent;
   while ($new != "1")
   {
      $sql = new Owl_DB;
      $sql->query("SELECT parent from $default->owl_folders_table where id = '$new'");
      while ($sql->next_record()) $newparentid = $sql->f("parent");
      if ($newparentid == "") break;
      $name = fid_to_name($newparentid);
      $navbar = "$name\\" . $navbar;
      $new = $newparentid;
   } 
   return $navbar;
} 

function fIsAdmin($Admin = false)
{
   global $default, $usergroupid, $userid;

   if (empty($userid))
   {
      $userid = 0;
   }

   if($Admin)
   {
      if ($usergroupid == "0")
      {
         return true;
      }
      else
      {
         $sql = new Owl_DB;
         $sql->query("SELECT userid,groupid from $default->owl_users_grpmem_table where userid = '$userid' and groupid = '0'");
   
         if ($sql->num_rows($sql) == 0)
         {
            return false;
         }
         else 
         {
            return true;
         }
      }
   }
   else
   {
      if ($usergroupid == "0" or $usergroupid == $default->file_admin_group)
      {
         return true;
      }
      else
      {
         $sql = new Owl_DB;
         $sql->query("SELECT userid,groupid from $default->owl_users_grpmem_table where userid = '$userid' and (groupid = '$default->file_admin_group' or groupid = '0')");
   
         if ($sql->num_rows($sql) == 0)
         {
            return false;
         }
         else 
         {
            return true;
         }
      }
   }
   return false;
}

function fIsEmailToolAccess($userid)
{
   global $default;

   $sql = new Owl_DB;
   $sql->query("SELECT email_tool from $default->owl_users_table where id = '$userid'");
   $sql->next_record();
   if ($sql->f("email_tool") == 1)
   {
      return true;
   } 
   return false;
} 

function fIsNewsAdmin($userid)
{
   global $default;

   $sql = new Owl_DB;
   $sql->query("SELECT newsadmin from $default->owl_users_table where id = '$userid'");
   $sql->next_record();
   if ($sql->f("newsadmin") == 1)
   {
      return true;
   } 
   return false;
} 

function gen_filesize($file_size)
{
   global $owl_lang;

   if (ereg("[^0-9]", $file_size)) return $file_size;

   if ($file_size >= 1073741824)
   {
      $file_size = round($file_size / 1073741824 * 100) / 100 . $owl_lang->file_size_gigabyte;
   } elseif ($file_size >= 1048576)
   {
      $file_size = round($file_size / 1048576 * 100) / 100 . $owl_lang->file_size_megabyte;
   } elseif ($file_size >= 1024)
   {
      $file_size = round($file_size / 1024 * 100) / 100 . $owl_lang->file_size_kilobyte;
   } 
   else
   {
      if(!empty($file_size))
      {
         $file_size = $file_size . $owl_lang->file_size_byte;
      }
      else
      {
         $file_size = "0". $owl_lang->file_size_byte;
      }
   } 
   return $file_size;
} 

function uploadCompat($varname)
{
   global $HTTP_POST_FILES;

   if ($_FILES[$varname]) return $_FILES[$varname];
   if ($HTTP_POST_FILES[$varname]) return $HTTP_POST_FILES[$varname];
   $tmp = "$varname_name";
   global $$tmp;
   $retfile['name'] = $$tmp;
   $tmp = "$varname_type";
   global $$tmp;
   $retfile['type'] = $$tmp;
   $tmp = "$varname_size";
   global $$tmp;
   $retfile['size'] = $$tmp;
   $tmp = "$varname_error";
   global $$tmp;
   $retfile['error'] = $$tmp;
   $tmp = "$varname_tmp_name";
   global $$tmp;
   $retfile['tmp_name'] = $$tmp;
   return $retfile;
} 

function fGetMimeType ($filename)
{
   global $default;

   $mimeType = "application/octet-stream";

   if ($filetype = strrchr($filename, "."))
   {
      $filetype = substr($filetype, 1);
      $sql = new Owl_DB;
      $sql->query("SELECT * from $default->owl_mime_table where filetype = '$filetype'");
      while ($sql->next_record()) $mimeType = $sql->f("mimetype");
   } 
   return $mimeType;
} 

if ($sess)
{
//bookmark meow

   $ok = verify_session($sess);
   
   $temporary_ok = $ok["bit"];
   $userid = $ok["userid"];
   $default->owl_current_db = $ok["currentdb"];
   $default->owl_FileDir  =  $default->owl_db_FileDir[$default->owl_current_db];
   getuserprefs();
   $usergroupid = $ok["groupid"];
   if ($ok["bit"] != "1")
   { 
      if ($default->remember_me)
      {
         setcookie ("owl_sessid", "");
      }
      if (file_exists("./lib/header.inc"))
      {
         include("./lib/header.inc");
         include("./lib/userheader.inc");
      } 
      else
      {
         include("../lib/header.inc");
         include("../lib/userheader.inc");
      } 
      print("<center>\n");
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
      print("<table class='margin2' cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
      print("<tr>\n");
      print("<td align='left' valign='top'>\n");
      print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
      fPrintFormTextLine("&nbsp;", "", "",  $owl_lang->invalidsess , "", true);
      print("<tr>\n");
      print("<td class='form1'>");
      fPrintButtonSpace(1, 1);
      print("</td>\n");
      print("<td>\n");
      print("<table class='border1' cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
      print("<tr>\n<td valign='top' width='100%'>");
      fPrintButtonSpace(1, 1);
      print("</td>");
      if ($parent == "" || $fileid == "")
      {
         fPrintButton("$default->owl_root_url/index.php", "btn_login");
      }
      else
      {
         fPrintButton("$default->owl_root_url/index.php?parent=$parent&fileid=$fileid", "btn_login");
      }   
      //print("\t\t<td class='button1' background=$default->owl_graphics_url/$default->sButtonStyle/ui_misc/button1_fill.jpg>");
      print("\t\t<td class='button1'>");
      print("<input class='fbuttonup1' type='submit' value='$owl_lang->btn_back' alt='$owl_lang->alt_back' title='$owl_lang->alt_back' onclick='history.back();' onmouseover=\"highlightButton('fbuttondown1')\" onmouseout=\"highlightButton('fbuttonup1')\"></input>");
      print("</td>\n</tr>\n</table>\n");
      print("</td>\n</tr>\n");

      
      print("</table>\n");
      print("</td>\n</tr>\n");
      print("</table>\n");

      fPrintButtonSpace(12, 1);
      print("</td>\n</tr>\n");
      print("</table>\n");

      //print("</table>\n");
      if (file_exists("./lib/footer.inc"))
      {
         require("./lib/footer.inc");
      }
      else
      {
         require("../lib/footer.inc");
      }
      exit;
   } 
   else
   {
         $lastused = time();
         $sql = new Owl_DB;
      if (!($default->remember_me))
      {
         $sql->query("UPDATE $default->owl_sessions_table set lastused = '$lastused' where usid = '$userid' and sessid = '$sess'");
      } 
      elseif (!(isset($HTTP_COOKIE_VARS["owl_sessid"])))
      {
         $sql->query("UPDATE $default->owl_sessions_table set lastused = '$lastused' where usid = '$userid' and sessid = '$sess'");
      }
   } 
} 
else
{
	
  $usergroupid = "DENIED";
  $user = "DENIED";
}

function checkrequirements()
{
   global $default;
   global $owl_lang;

   $status = 0;

   if (version_compare(phpversion(), $default->phpversion) == -1)
   {
      print("<center><h3>$owl_lang->err_bad_version_1<br></br>");
      print("$default->phpversion<br></br>");
      print("$owl_lang->err_bad_version_2<br></br>");
      print phpversion();
      print("<br></br>$owl_lang->err_bad_version_3</h3></center>");
      $status =  1;
   } 
   if ($default->debug == true)
   {
      if (!file_exists($default->owl_tmpdir))
      {
         print("<center><h3>$owl_lang->debug_tmp_not_exists</h3></center>");
         $status =  1;
      } 
      else
      {
         if (!is_writable($default->owl_tmpdir))
         {
            print("<center><h3>$owl_lang->debug_tmp_not_writeable</h3></center>");
            print("</h3>");
            $status =  1;
         } 
      } 

      if (!file_exists($default->owl_FileDir . "/" . fid_to_name(1)))
      {
         print("<center><h3>$owl_lang->debug_doc_not_exists</h3></center>");
         $status =  1;
      } 
      else
      {
         if (!is_writable($default->owl_FileDir . "/" . fid_to_name(1)))
         {
            print("<center><h3>$owl_lang->debug_doc_not_writeable</h3></center>");
            $status =  1;
         } 
      } 


      if(ini_get('safe_mode') == 1)
      {
            print("<center><h3>OWL REQUIRES SAFE MODE TO BE Off</h3></center>");
            $status =  1;
      }
   } 

   return $status;
} 

function myExec($_cmd, &$lines, &$errco)
{
   $cmd = "$_cmd ; echo $?";
   exec($cmd, $lines); 
   // Get rid of the last errco line...
   $errco = (integer) array_pop($lines);
   if (count($lines) == 0)
   {
      return "";
   } 
   else
   {
      return $lines[count($lines) - 1];
   } 
} 

function myDelete($file)
{
   if (file_exists($file))
   { 
      if (is_dir($file))
      {
         $handle = opendir($file);
         while ($filename = readdir($handle))
         {
            if ($filename != "." && $filename != "..")
            {
               myDelete($file . "/" . $filename);
            } 
         } 
         closedir($handle);
         rmdir($file);
      } 
      else
      {
         unlink($file);
      } 
   } 
} 

function printError($message, $submessage = "", $type = "ERROR")
{
   global $default;
   global $sess, $parent, $expand, $order, $sortorder , $sortname, $userid;
   global $language;
   global $owl_lang;

   if (file_exists("./lib/header.inc"))
   {
      include_once("./lib/header.inc");
      include_once("./lib/userheader.inc");
   } 
   else
   {
      if (file_exists("../lib/header.inc"))
      {
         include_once("../lib/header.inc");
         include_once("../lib/userheader.inc");
      }
      else
      {
         include_once("$default->owl_fs_root/lib/header.inc");
         include_once("$default->owl_fs_root/lib/userheader.inc");
      }
   } 
   if (isset($parent))
   {
      if (check_auth($parent, "folder_view", $userid) != "1")
      {
         $sql = new Owl_DB;
         $sql->query("SELECT * from $default->owl_folders_table where id = '$parent'");
         $sql->next_record();
         $parent = $sql->f("parent");
      } 
   } 

   print("<center>");
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

   print("<table class='margin2' cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
   print("<tr>\n");
   print("<td align='left' valign='top'>\n");
   print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
   //print("<tr>\n");

   fPrintFormTextLine("--- $type  ---", "", "",  $message , "", true);

   if(!empty($submessage))
   {
      fPrintFormTextLine("--- DETAILS ---", "", "",  $submessage , "", true);
   }

   print("<tr>");
   print("<td class='form1'>");
   fPrintButtonSpace(1, 1);
   print("</td>");
   print("<td class='form2'>");
   print("<input class='fbuttonup1' type='submit' value='$owl_lang->btn_back' alt='$owl_lang->alt_back' title='$owl_lang->alt_back' onclick='history.back();' onmouseover=\"highlightButton('fbuttondown1')\" onmouseout=\"highlightButton('fbuttonup1')\"></input>");
   print("</td>");
   print("</tr>");

   print("</table>\n");
   print("</td></tr></table>\n");
   fPrintButtonSpace(12, 1);
         
   print("</td></tr></table>\n");
   if (file_exists("./lib/footer.inc"))
   {
      include("./lib/footer.inc");
   }
   else
   {
      if (file_exists("../lib/footer.inc"))
      {
         include("../lib/footer.inc");
      }
      else
      {
         include("$default->owl_fs_root/lib/footer.inc");
      }
   }
   exit();
} 

function getuserprefs ()
{
   global $default, $userid;
 	
   if ($userid == "" )
   {
     $iUid = $default->anon_user;
     
   }
   else
   {
     $iUid = $userid;
   }
  //echo $userid.'-';

   $sql = new Owl_DB;
   $sql->query("SELECT firstdir, homedir from $default->owl_users_table where id = '$iUid'");
   $sql->next_record();
   $default->HomeDir = $sql->f("homedir");
   $default->FirstDir = $sql->f("firstdir");
   
}

function getprefs ()
{
   global $default, $userid;

   define ("LOGIN", "1");
   define ("LOGIN_FAILED", "2");
   define ("LOGOUT", "3");
   define ("FILE_DELETED", "4");
   define ("FILE_UPLOAD", "5");
   define ("FILE_UPDATED", "6");
   define ("FILE_DOWNLOADED", "7");
   define ("FILE_CHANGED", "8");
   define ("FILE_LOCKED", "9");
   define ("FILE_UNLOCKED", "10");
   define ("FILE_EMAILED", "11");
   define ("FILE_MOVED", "12");
   define ("FOLDER_CREATED", "13");
   define ("FOLDER_DELETED", "14");
   define ("FOLDER_MODIFIED", "15");
   define ("FOLDER_MOVED", "16");
   define ("FORGOT_PASS", "17");
   define ("USER_REG", "18");
   define ("FILE_VIEWED", "19");
   define ("FILE_VIRUS", "20");
   define ("FILE_COPIED", "21");
   define ("FOLDER_COPIED", "22");
   define ("FILE_LINKED", "23");

   $sql = new Owl_DB;
   $sql->query("SELECT * from $default->owl_prefs_table");
   $sql->next_record();

   $default->owl_email_from = $sql->f("email_from");
   $default->owl_email_fromname = $sql->f("email_fromname");
   $default->owl_email_replyto = $sql->f("email_replyto");
   $default->owl_email_server = $sql->f("email_server");
   $default->owl_email_subject = $sql->f("email_subject");
   $default->use_smtp = $sql->f("use_smtp");
   $default->use_smtp_auth = $sql->f("use_smtp_auth");
   $default->smtp_auth_login  = $sql->f("smtp_auth_login ");
   $default->smtp_passwd = $sql->f("smtp_passwd"); 
   // 
   // LookAtHD is not supported with $default->owl_use_fs = false
   // 
   if ($default->owl_use_fs)
   {
      $default->owl_LookAtHD = $sql->f("lookathd");
   } 
   else
   {
      if (substr(php_uname(), 0, 7) == "Windows")
      {
         $default->owl_compressed_database = 0;
      } 
      $default->owl_LookAtHD = "false";
   } 

   $default->owl_lookAtHD_del = $sql->f("lookathddel");
   $default->owl_def_file_security = $sql->f("def_file_security");
   $default->owl_def_file_group_owner = $sql->f("def_file_group_owner");
   $default->owl_def_file_owner = $sql->f("def_file_owner");
   $default->owl_def_file_title = $sql->f("def_file_title");
   $default->owl_def_file_meta = $sql->f("def_file_meta");
   $default->owl_def_fold_security = $sql->f("def_fold_security");
   $default->owl_def_fold_group_owner = $sql->f("def_fold_group_owner");
   $default->owl_def_fold_owner = $sql->f("def_fold_owner");
   $default->max_filesize = $sql->f("max_filesize");
   $default->owl_timeout = $sql->f("timeout");
   if ($sql->f("tmpdir") == "")
   {
      $default->owl_tmpdir = $default->owl_FileDir;
      $default->owl_tmpdir .= "/" . fid_to_name(1);
   } 
   else
   {
      $default->owl_tmpdir = $sql->f("tmpdir");
   } 
   $default->expand = $sql->f("expand");
   $default->owl_version_control = $sql->f("version_control");
   $default->major_revision = $sql->f("major_revision");
   $default->minor_revision = $sql->f("minor_revision");

   $default->restrict_view = $sql->f("restrict_view");
   $default->dbdump_path = $sql->f("dbdump_path");
   $default->gzip_path = $sql->f("gzip_path");
   $default->tar_path = $sql->f("tar_path");
   $default->unzip_path = $sql->f("unzip_path");
   $default->pod2html_path = $sql->f("pod2html_path");
   $default->pdftotext_path = $sql->f("pdftotext_path");
   $default->wordtotext_path = $sql->f("wordtotext_path");
   $default->file_perm = $sql->f("file_perm");
   $default->folder_perm = $sql->f("folder_perm");

   $default->anon_ro = $sql->f("anon_ro");
   $default->anon_user = $sql->f("anon_user");
   $default->file_admin_group = $sql->f("file_admin_group");

   $default->hide_backup = $sql->f("hide_backup");

   $default->collect_trash = $sql->f("collect_trash");
   if ($sql->f("trash_can_location") == "")
   {
      $default->trash_can_location = $default->owl_FileDir . "/TrashCan";
   } 
   else
   {
      $default->trash_can_location = $sql->f("trash_can_location");
   } 

   $default->allow_popup = $sql->f("allow_popup");
   $default->show_file_stats = $sql->f("status_bar_location");

   $default->show_prefs = $sql->f("pref_bar");
   $default->show_search = $sql->f("search_bar");
   $default->show_bulk = $sql->f("bulk_buttons");
   $default->show_action = $sql->f("action_buttons");
   $default->show_folder_tools = $sql->f("folder_tools");

   //$default->hide_bulk = $sql->f("hide_bulk"); 
   // 
   // Logging options
   // 
   $default->logging = $sql->f("logging");
   $default->log_file = $sql->f("log_file");
   $default->log_login = $sql->f("log_login");
   $default->log_rec_per_page = $sql->f("log_rec_per_page"); 
   //
   // Sticky loggin (remember me Link)
   //
   $default->remember_me = $sql->f("remember_me");
   $default->cookie_timeout = $sql->f("cookie_timeout");

   // 
   // Self Register options
   // 
   $default->self_reg = $sql->f("self_reg");
   $default->self_reg_quota = $sql->f("self_reg_quota");
   $default->self_reg_notify = $sql->f("self_reg_notify");
   $default->self_reg_attachfile = $sql->f("self_reg_attachfile");
   $default->self_reg_disabled = $sql->f("self_reg_disabled");
   $default->self_reg_noprefacces = $sql->f("self_reg_noprefacces");
   $default->self_reg_maxsessions = $sql->f("self_reg_maxsessions");
   $default->self_reg_group = $sql->f("self_reg_group");
   $default->forgot_pass = $sql->f("forgot_pass");
   $default->records_per_page = $sql->f("rec_per_page");
   $default->self_reg_homedir = $sql->f("self_reg_homedir");
   $default->self_reg_firstdir = $sql->f("self_reg_firstdir");


   $default->expand_disp_status = $sql->f("expand_disp_status");
   $default->expand_disp_doc_num = $sql->f("expand_disp_doc_num");
   $default->expand_disp_doc_type = $sql->f("expand_disp_doc_type");
   $default->expand_disp_title = $sql->f("expand_disp_title");
   $default->expand_disp_version = $sql->f("expand_disp_version");
   $default->expand_disp_file = $sql->f("expand_disp_file");
   $default->expand_disp_size = $sql->f("expand_disp_size");
   $default->expand_disp_posted = $sql->f("expand_disp_posted");
   $default->expand_disp_modified = $sql->f("expand_disp_modified");
   $default->expand_disp_action = $sql->f("expand_disp_action");
   $default->expand_disp_held = $sql->f("expand_disp_held");

   $default->collapse_disp_status = $sql->f("collapse_disp_status");
   $default->collapse_disp_doc_num = $sql->f("collapse_disp_doc_num");
   $default->collapse_disp_doc_type = $sql->f("collapse_disp_doc_type");
   $default->collapse_disp_title = $sql->f("collapse_disp_title");
   $default->collapse_disp_version = $sql->f("collapse_disp_version");
   $default->collapse_disp_file = $sql->f("collapse_disp_file");
   $default->collapse_disp_size = $sql->f("collapse_disp_size");
   $default->collapse_disp_posted = $sql->f("collapse_disp_posted");
   $default->collapse_disp_modified = $sql->f("collapse_disp_modified");
   $default->collapse_disp_action = $sql->f("collapse_disp_action");
   $default->collapse_disp_held = $sql->f("collapse_disp_held");

   $default->expand_search_disp_score =  $sql->f("expand_search_disp_score");
   $default->expand_search_disp_folder_path = $sql->f("expand_search_disp_folder_path");
   $default->expand_search_disp_doc_type = $sql->f("expand_search_disp_doc_type");
   $default->expand_search_disp_file = $sql->f("expand_search_disp_file");
   $default->expand_search_disp_size = $sql->f("expand_search_disp_size");
   $default->expand_search_disp_posted = $sql->f("expand_search_disp_posted");
   $default->expand_search_disp_modified = $sql->f("expand_search_disp_modified");
   $default->expand_search_disp_action = $sql->f("expand_search_disp_action");

   $default->collapse_search_disp_score =  $sql->f("collapse_search_disp_score");
   $default->collapse_search_disp_folder_path = $sql->f("collapse_search_disp_folder_path");
   $default->collapse_search_disp_doc_type = $sql->f("collapse_search_disp_doc_type");
   $default->collapse_search_disp_file = $sql->f("collapse_search_disp_file");
   $default->collapse_search_disp_size = $sql->f("collapse_search_disp_size");
   $default->collapse_search_disp_posted = $sql->f("collapse_search_disp_posted");
   $default->collapse_search_disp_modified = $sql->f("collapse_search_disp_modified");
   $default->collapse_search_disp_action = $sql->f("collapse_search_disp_action");

   $default->hide_folder_doc_count	= $sql->f("hide_folder_doc_count");
   $default->old_action_icons	= $sql->f("old_action_icons");
   $default->search_result_folders	= $sql->f("search_result_folders");
   $default->restore_file_prefix	= $sql->f("restore_file_prefix");


   $default->doc_id_prefix = $sql->f("doc_id_prefix");
   $default->doc_id_num_digits = $sql->f("doc_id_num_digits");

   $default->view_doc_in_new_window = $sql->f("view_doc_in_new_window");

   $default->admin_login_to_browse_page = $sql->f("admin_login_to_browse_page");

   $default->save_keywords_to_db = $sql->f("save_keywords_to_db");
   $default->anon_access = $sql->f("anon_ro");

   $default->document_peer_review = $sql->f("peer_review");
   $default->document_peer_review_req = $sql->f("peer_opt");
   $default->hide_folder_size = $sql->f("folder_size");
   $default->use_zip_for_folder_download = $sql->f("download_folder_zip");
   $default->display_password_override = $sql->f("display_password_override");
   $default->virus_path = $sql->f("virus_path");
}

function fIsQuotaEnabled($current_user)
{
   global $default ;
   global $owl_lang;

   $quota_max = 0;
   $sql = new Owl_DB;
   $sql->query("SELECT * from $default->owl_users_table where id = '$current_user'");
   while ($sql->next_record())
   {
      $quota_max = $sql->f("quota_max");
   }
   if ( $quota_max == 0)
   {
      return false;
   }
   else
   {
      return true;
   }
}
function fCalculateQuota($size, $current_user, $type)
{
   global $default;
   global $owl_lang;

   $sql = new Owl_DB;
   $sql->query("SELECT * from $default->owl_users_table where id = '$current_user'");
   while ($sql->next_record())
   {
      $quota_max = $sql->f("quota_max");
      $quota_current = $sql->f("quota_current");
      if ($type == "ADD")
      {
         $new_quota = $quota_current + $size;
      }
      elseif ($type == "DEL")
      {
         $new_quota = $quota_current - $size;
      }
   }
   if (($new_quota > $quota_max) and fIsQuotaEnabled($current_user))
   {
      printError("<b class=hilite>" . uid_to_name($current_user) ."</b>: $owl_lang->err_quota" . gen_filesize($size) . "$owl_lang->err_quota_needed" . gen_filesize($quota_max - $quota_current) . "$owl_lang->err_quota_avail");
      if (($quota_max - $quota_current) <= 0)
      {
         printError("$owl_lang->err_quota_exceed");
      }
   }
   return $new_quota;
}

function printfileperm($currentval, $namevariable, $printmessage, $type)
{
   global $default;
   global $owl_lang;

   $file_perm[0][0] = 0;
   $file_perm[1][0] = 1;
   $file_perm[2][0] = 2;
   $file_perm[3][0] = 3;
   $file_perm[4][0] = 4;
   $file_perm[5][0] = 5;
   $file_perm[6][0] = 6;
   $file_perm[7][0] = 7;
   $file_perm[8][0] = 8;

   if ($type == "admin")
   {
      $file_perm[0][1] = "$owl_lang->everyoneread_ad";
      $file_perm[1][1] = "$owl_lang->everyonewrite_ad";
      $file_perm[2][1] = "$owl_lang->groupread_ad";
      $file_perm[3][1] = "$owl_lang->groupwrite_ad";
      $file_perm[4][1] = "$owl_lang->onlyyou_ad";
      $file_perm[5][1] = "$owl_lang->groupwrite_ad_nod";
      $file_perm[6][1] = "$owl_lang->everyonewrite_ad_nod";
      $file_perm[7][1] = "$owl_lang->groupwrite_worldread_ad";
      $file_perm[8][1] = "$owl_lang->groupwrite_worldread_ad_nod";
   } 
   else
   {
      $file_perm[0][1] = "$owl_lang->everyoneread";
      $file_perm[1][1] = "$owl_lang->everyonewrite";
      $file_perm[2][1] = "$owl_lang->groupread";
      $file_perm[3][1] = "$owl_lang->groupwrite";
      $file_perm[4][1] = "$owl_lang->onlyyou";
      $file_perm[5][1] = "$owl_lang->groupwrite_nod";
      $file_perm[6][1] = "$owl_lang->everyonewrite_nod";
      $file_perm[7][1] = "$owl_lang->groupwrite_worldread";
      $file_perm[8][1] = "$owl_lang->groupwrite_worldread_nod";
   } 

   print("<tr>\n");
   print("<td class='form1'>$printmessage</td>\n");
   print("<td class='form1' width='100%'>");
   print("<select class='fpull1' name='$namevariable' size='1'>\n");
   foreach($file_perm as $fp)
   {
      print("<option value='$fp[0]'");
      if ($fp[0] == $currentval)
      {
         print(" selected='selected'");
      }
      print(">$fp[1]</option>\n");
   }
   print("</select>\n</td>\n</tr>\n");
} ;

function owl_syslog($action, $userid, $filename, $logparent, $detail, $type)
{
   global $default;

   if ($default->logging == 1)
   {
      $sql = new Owl_DB;
      $log = 0;

      $logdate = date("Y-m-d G:i:s");
      if ($_SERVER["HTTP_CLIENT_IP"])
      {
         $ip = $_SERVER["HTTP_CLIENT_IP"];
      } elseif ($_SERVER["HTTP_X_FORWARDED_FOR"])
      {
         $forwardedip = $_SERVER["HTTP_X_FORWARDED_FOR"];
         list($ip, $ip2, $ip3, $ip4) = split (",", $forwardedip);
      } 
      else
      {
         $ip = $_SERVER["REMOTE_ADDR"];
      } 
      $agent = $_SERVER["HTTP_USER_AGENT"];
      if ($default->log_file == 1 && $type == "FILE")
      {
         $log = 1;
      } 
      if ($default->log_login == 1 && $type == "LOGIN")
      {
         $log = 1;
      } 
      if ($log == 1)
      {
         if (empty($logparent))
         {
            $logparent = 0;
         }
         $sql->query("INSERT into $default->owl_log_table (userid, filename, action, parent, details, logdate, ip, agent, type) values ('$userid', '$filename', '$action', '$logparent', '$detail', '$logdate', '$ip', '$agent', '$type')");
      } 
   } 
} 


function change_ownership_perms($file, $id, $func_parent, $fileowner, $groupid, $policy, $prop_file_sec)
{
   global $default;

   if ( $id == "1")
   {
      $file = "";
   }
   if (is_dir($default->owl_FileDir . "/" . find_path($func_parent) . "/" . $file)) 
   {
      $sql = new Owl_DB;
      $smodified = $sql->now();
      $sql->query("UPDATE $default->owl_folders_table SET creatorid='$fileowner', groupid='$groupid', security='$policy', smodified=$smodified WHERE id='$id'");
      if ($prop_file_sec >= 0 )
      {
         $sql = new Owl_DB;
         $sql->query("UPDATE $default->owl_files_table SET creatorid='$fileowner', groupid='$groupid', security='$prop_file_sec', smodified=$smodified where parent='$id'");
      }
   
      $sql = new Owl_DB;
      $sql->query("SELECT name, id from $default->owl_folders_table where parent='$id'");
      while($sql->next_record())
      {
         $newfile = $sql->f("name");
         $newid = $sql->f("id");
         change_ownership_perms($newfile, $newid, $id, $fileowner, $groupid, $policy, $prop_file_sec);
      }
   } 
   else 
   {
      if ($default->debug == true)
      {
         printError("DEBUG: Security Propagation attempt on a file");
      } 
   }
}


function printgroupperm($currentval, $namevariable, $printmessage, $type)
{
   global $default;
   global $owl_lang;

   $group_perm[0][0] = 50;
   $group_perm[1][0] = 51;
   $group_perm[2][0] = 52;
   $group_perm[3][0] = 53;
   $group_perm[4][0] = 54;
   $group_perm[5][0] = 55;
   $group_perm[6][0] = 56;
   $group_perm[7][0] = 57;
   $group_perm[8][0] = 58;

   if ($type == "admin")
   {
      $group_perm[0][1] = "$owl_lang->geveryoneread_ad";
      $group_perm[1][1] = "$owl_lang->geveryonewrite_ad";
      $group_perm[2][1] = "$owl_lang->ggroupread_ad";
      $group_perm[3][1] = "$owl_lang->ggroupwrite_ad";
      $group_perm[4][1] = "$owl_lang->gonlyyou_ad";
      $group_perm[5][1] = "$owl_lang->ggroupwrite_ad_nod";
      $group_perm[6][1] = "$owl_lang->geveryonewrite_ad_nod";
      $group_perm[7][1] = "$owl_lang->ggroupwrite_worldread_ad";
      $group_perm[8][1] = "$owl_lang->ggroupwrite_worldread_ad_nod";
   } 
   else
   {
      $group_perm[0][1] = "$owl_lang->geveryoneread";
      $group_perm[1][1] = "$owl_lang->geveryonewrite";
      $group_perm[2][1] = "$owl_lang->ggroupread";
      $group_perm[3][1] = "$owl_lang->ggroupwrite";
      $group_perm[4][1] = "$owl_lang->gonlyyou";
      $group_perm[5][1] = "$owl_lang->ggroupwrite_nod";
      $group_perm[6][1] = "$owl_lang->geveryonewrite_nod";
      $group_perm[7][1] = "$owl_lang->ggroupwrite_worldread";
      $group_perm[8][1] = "$owl_lang->ggroupwrite_worldread_nod";
   } 

   print("<tr>\n");
   print("<td class='form1'>$printmessage</td>\n");
   print("<td class='form1' width='100%'>");
   print("<select class='fpull1' name='$namevariable' size='1'>\n");
   foreach($group_perm as $fp)
   {
      print("<option value='$fp[0]' ");
      if ($fp[0] == $currentval)
      {
         print("selected='selected'");
      }
      print(">$fp[1]</option>\n");
   } 
   print("</select></td>\n</tr>\n");
} ;

function get_title_tag($chaine)
{
   $fp = fopen ($chaine, 'r');
   while (! feof ($fp))
   {
      $contenu .= fgets ($fp, 1024);
      if (stristr($contenu, '</title>'))
      {
         break;
      } 
   } 
   if (eregi("<title>(.*)</title>", $contenu, $out))
   {
      return $out[1];
   } 
   else
   {
      return false;
   } 
} 

function RndInt($Format)
{
   switch ($Format)
   {
      case "letter":
         $Rnd = rand(0, 25);
         if ($Rnd > 25)
         {
            $Rnd = $Rnd - 1;
         } 
         break;
      case "number":
         $Rnd = rand(0, 9);
         if ($Rnd > 9)
         {
            $Rnd = $Rnd - 1;
         } 
         break;
   } 
   return $Rnd;
} 

function GenRandPassword()
{
   /**
    * RANDOM PASSWORD GENERATION ALGORITHM
    * PROGRAMMED BY: BRIAN GRIFFIN
    * January 1, 2003
    * MXrider005@hotmail.com
    * 
    * You can use this freely. Just don't credit it as your own work! And please e-mail me if you do just to let me know. Thanks.
    */
   // DEFINE STRINGS TO USE FOR CHARACTER C // OMBINATIONS IN THE PASSWORD
   $LCase = "abcdefghijklmnopqrstuvwxyz";
   $UCase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
   $Integer = "0123456789"; 
   // DEFINE CONSTANTS FOR ALGORTTHM
   define("LEN", "1");
   /**
    * THIS FUNCTION GENERATES A RANDOM NUMBER THAT WILL BE USED TO
    * RANDOMLY SELECT CHARACTERS FROM THE STRINGS ABOVE
    */

   /**
    * RUN THE FUNCTION TO GENERATE RANDOM INTEGERS FOR EACH OF THE
    * 6 CHARACTERS IN THE PASSWORD PRODUCED.
    */
   $a = RndInt("letter");
   $b = RndInt("letter");
   $c = RndInt("letter");
   $d = RndInt("letter");
   $e = RndInt("number");
   $f = RndInt("number"); 
   // EXTRACT 6 CHARACTERS RANDOMLY FROM TH // E DEFINITION STRINGS
   $L1 = substr($LCase, $a, LEN);
   $L2 = substr($LCase, $b, LEN);
   $U1 = substr($UCase, $c, LEN);
   $U2 = substr($UCase, $d, LEN);
   $I1 = substr($Integer, $e, LEN);
   $I2 = substr($Integer, $f, LEN); 
   // COMBINE THE CHARACTERS AND DISPLAY TH // E NEW PASSWORD
   $PW = $L1 . $U2 . $I1 . $L2 . $I2 . $U1;
   return $PW;
} 

if (!$sess && !$loginname && !$login)
{
   if (!isset($fileid))
   {
      $sql = new Owl_DB;
      $sql->query("SELECT * from $default->owl_users_table where id = '$default->anon_user'");
      $sql->next_record();
      if ($sql->num_rows() == 1)
      {
         $accountname = $sql->f("name");
         if ($sql->f("disabled") != 1)
            $userid = $default->anon_user;
         else
         {
            if ($_SERVER["PHP_SELF"] != $default->owl_root_url . "/register.php")
               header("Location: " . $default->owl_root_url . "/index.php?login=1");
         } 
      } 
      else
      {
         if ($_SERVER["PHP_SELF"] != $default->owl_root_url . "/register.php")
            header("Location: " . $default->owl_root_url . "/index.php?login=1&failure=4");
      } 
   } 
   else
   {
      header("Location: " . $default->owl_root_url . "/index.php?login=1&fileid=$fileid&parent=$parent");
   } 
} 

if (!$sess && $loginname)
{
   $sql = new Owl_DB;
   $sql->query("SELECT * from $default->owl_users_table where id = '$default->anon_user'");
   $sql->next_record();
   if ($sql->num_rows() == 1)
   {
      if ($sql->f("disabled") != 1)
      {
         $userid = $default->anon_user;
      } 
      else
      {
         //header("Location: " . $default->owl_root_url . "/index.php?login=1&currentdb=$default->owl_current_db");
         header("Location: " . $default->owl_root_url . "/index.php?login=1");
      } 
   } 
   else
   {
      header("Location: " . $default->owl_root_url . "/index.php?login=1");
   } 
} 

if (!$sess && $login)
{
   if ($_SERVER["PHP_SELF"] != $default->owl_root_url . "/index.php")
      header("Location: " . $default->owl_root_url . "/index.php?login=1");
} 
// 
// PDF and Text File Search Index Functions BEGIN
// 
// DoesFileIDContainKeyword:  Pass a file id from the files table and a keyword.
// pretty quickly tells you if that keyword is in that file, actually very quickly.

function DoesFileIDContainKeyword($fileid, $keyword)
{
   global $default;
   $sql = new Owl_DB;
   $sql->query("SELECT * from $default->owl_wordidx where word='$keyword'");
   $sql->query("SELECT * from $default->owl_wordidx where word like '%$keyword%'");
   if ($sql->num_rows() > 0)
   {
      $glue = "";
      while($sql->next_record())
      {
         $query .= $glue . " wordid = '" . $sql->f("wordid") . "'";
         $glue = " OR ";
      }
   }
   else
   {
      $query = "wordid = '-1'";
   }

   $sql->query("SELECT * from $default->owl_searchidx where ($query) and owlfileid = '$fileid'");

   return $sql->num_rows();
} 

function IndexATextFile($filename, $owlfileid)
{
   global $default;

   $fileidnum = $owlfileid;

   $sql = new Owl_DB;
   $sql->query("SELECT * from $default->owl_wordidx"); //Import all words and indexes
   $nextwordindex = 0;
   $wordindex = array();
   while ($sql->next_record()) // this may get ugly, we could have 100K words and indexes, they gotta go into memory.
   {
      $wordindex[$sql->f("word")] = $sql->f("wordid");
      if ($sql->f("wordid") > $nextwordindex)
      {
         $nextwordindex = $sql->f("wordid"); //get largest word index in table
      } 
   } 
   $nextwordindex++;

   // Note: again, here we've just read in the big wordidx, we should index as many
   // files as possible while we have this index in memory, here we
   // only index a single filename, but if someone wants to greatly improve performance,
   // index an array of filenames here...
   if (file_exists($filename))
   {
      $fp = fopen($filename, "rb");
      while (!feof($fp))
      {
         $line = fgets($fp, 128);
         $line = strtolower($line);
         //$wordtemp = preg_split("/\W/", $line); //split line into words a word is any # of A-Za-z's separated by somethign not a-zA-Z
         $wordtemp = preg_split("/\s+/", $line); //split line into words a word is any # of A-Za-z's separated by somethign not a-zA-Z
         if (!isset($wordtemp)) continue;
   
         foreach($wordtemp as $wd)
         {
            $wd = stripslashes(ereg_replace("[$default->list_of_chars_to_remove_from_wordidx]","",str_replace("]", "", str_replace("[", "",$wd))));

            if (strlen(trim($wd)) > 0) 
            {
               $words[$wd]++; //keep a count of how often each word is seen
               //print("WORDS: $words[$wd] ---- ");
               if ($words[$wd] == 1) // if this is the first time we've seen this word in this document...
               {
                  if ($wordindex[$wd]) // if this word was already in the wordidx table...
                  {
                     $sql->query("INSERT into $default->owl_searchidx values('$wordindex[$wd]','$fileidnum')"); //add a searchidx table entry for this fileidnum (owlidnum)
                  } 
                  else // if word not in word index, add to both wordidx and searchidx
                  {
                      if (!empty($default->words_to_exclude_from_wordidx))
                      {
                         array($WordList);
                         $WordList = $default->words_to_exclude_from_wordidx;

                         $checkword = str_replace("+", "\+", $wd);

                         if (!(preg_grep("/$checkword/", $WordList)))
                         {
                            $wordindex[$wd] = $nextwordindex; //first remember this word as being in the wordindex
                            $sql->query("INSERT into $default->owl_searchidx values('$wordindex[$wd]', '$fileidnum')"); //add pointer to owlidnum for this wordindexnum

		            $wd = ereg_replace("'", "\\'" , $wd);
                            $sql->query("SELECT wordid from $default->owl_wordidx where word = '$wd'");
                            $numrows = $sql->num_rows($sql);
                            if ( $numrows == 0 )
                            {
                               $sql->query("INSERT into $default->owl_wordidx values('$nextwordindex', '$wd')");
                               $nextwordindex++;
                            }
                         }
                      }
                      else
                      {
                         $wordindex[$wd] = $nextwordindex; //first remember this word as being in the wordindex
                         $sql->query("INSERT into $default->owl_searchidx values('$wordindex[$wd]', '$fileidnum')"); //add pointer to owlidnum for this wordindexnum

		         $wd = ereg_replace("'", "\\'" , $wd);
                         $sql->query("SELECT wordid from $default->owl_wordidx where word = '$wd'");
                         $numrows = $sql->num_rows($sql);
                         if ( $numrows == 0 )
                         {
                            $sql->query("INSERT into $default->owl_wordidx values('$nextwordindex', '$wd')");
                            $nextwordindex++;
                         }
                      }
                  } 
               } //if first instance of this word...
            }
         } //for each word
      } //while!feof
   } 
   else
   {
      if ($default->debug == true)
      {
         printError("DEBUG: $owl_lang->err_file_indexing");
      } 
   }
}

function IndexABigString($bigstring, $owlfileid)
{
   global $default;

   $fileidnum = $owlfileid;

   $sql = new Owl_DB;
   $sql->query("SELECT * from $default->owl_wordidx"); //Import all words and indexes
   $nextwordindex = 0;
   $wordindex = array();
   while ($sql->next_record()) // this may get ugly, we could have 100K words and indexes, they gotta go into memory.
   {
      $wordindex[$sql->f("word")] = $sql->f("wordid");
      if ($sql->f("wordid") > $nextwordindex)
      {
         $nextwordindex = $sql->f("wordid"); //get largest word index in table
      } 
   } 
   $nextwordindex++;

   // Note: again, here we've just read in the big wordidx, we should index as many
   // files as possible while we have this index in memory, here we
   // only index a single filename, but if someone wants to greatly improve performance,
   // index an array of filenames here...
   $wordtemp = preg_split("/\s+/", strtolower($bigstring)); //split line into words a word is any # of A-Za-z's separated by somethign not a-zA-Z
   if (!isset($wordtemp)) return;
   
   foreach($wordtemp as $wd)
   {
      $wd = ereg_replace("[$default->list_of_chars_to_remove_from_wordidx]","",$wd);

      if (strlen(trim($wd)) > 0) 
      {
         $words[$wd]++; //keep a count of how often each word is seen
         //print("WORDS: $words[$wd] ---- ");
         if ($words[$wd] == 1) // if this is the first time we've seen this word in this document...
         {
            if ($wordindex[$wd]) // if this word was already in the wordidx table...
            {
               $sql->query("INSERT into $default->owl_searchidx values('$wordindex[$wd]','$fileidnum')"); //add a searchidx table entry for this fileidnum (owlidnum)
            } 
            else // if word not in word index, add to both wordidx and searchidx
            {
               $wordindex[$wd] = $nextwordindex; //first remember this word as being in the wordindex
               $sql->query("INSERT into $default->owl_searchidx values('$wordindex[$wd]', '$fileidnum')"); //add pointer to owlidnum for this wordindexnum

               $wd = ereg_replace("'", "\\'" , $wd);
               $sql->query("SELECT wordid from $default->owl_wordidx where word = '$wd'");
               $numrows = $sql->num_rows($sql);
               if ( $numrows == 0 )
               {
                  $sql->query("INSERT into $default->owl_wordidx values('$nextwordindex', '$wd')");
                  $nextwordindex++;
               }
            } 
         } //if first instance of this word...
      }
   } //for each word
}

   // When a file gets delete/removed, this should be called to update the indexing
   // tables
   function fDeleteFileIndexID($fidtoremove)
   {
      global $default;
      $sql = new Owl_DB;

      $sql->query("DELETE from $default->owl_searchidx where owlfileid = $fidtoremove");
      // Note, I'm leaving the wordidx table alone, it can only grow so large as
      // there are only so many words in the language, will make indexing future items a bit faster methinks
   } 

   function fIndexAFile($new_name, $newpath, $id)
   {
      global $default, $sess; 
      // IF the file was inserted in the database now INDEX it for SEARCH.
      $sSearchExtension = fFindFileExtension($new_name);

      if ($sSearchExtension == 'pdf' || $sSearchExtension == 'c' || $sSearchExtension == 'html' || $sSearchExtension == 'htm' || $sSearchExtension == 'php' || $sSearchExtension == 'pl' || $sSearchExtension == 'txt' || $sSearchExtension == 'doc' || $sSearchExtension == 'xls' or $sSearchExtension == 'sxw')
      {
            if(file_exists($default->pdftotext_path) and $sSearchExtension == 'pdf') 
            {
                $command = $default->pdftotext_path . '  "' . $newpath . '" "' .  $default->owl_tmpdir . "/" . $new_name . '.text"';

                $last_line = system($command, $retval);
                if ($retval > 0)
                {
                   if ($default->debug == true)
                   {
                      switch ($retval)
                      {
                         case "1": 
                            $sPdfError = "Error opening a PDF file. (Not A PDF File?)";
                            break;
                         case "2": 
                            $sPdfError = "Error opening an ouput file. ($default->owl_tmpdir Writeable by the webserver?)";
                            break;
                      }
                      printError('DEBUG: Indexing PDF File \'' . $newpath . '\' Failed:' , $sPdfError);
                   }
                }
                IndexATextFile($default->owl_tmpdir . "/" . $new_name . '.text', $id);
                unlink($default->owl_tmpdir . "/" . $new_name . '.text');
             } 
             elseif (file_exists($default->wordtotext_path) and $sSearchExtension == 'doc')
             {
                //$command = "/bin/sh -c" . ' "' . $default->wordtotext_path . ' '  . $newpath . '"'  . ' > "' . $default->owl_tmpdir . "/" . $new_name . '.text"';
                $command = $default->wordtotext_path . '  "' . $newpath . '" > "' .  $default->owl_tmpdir . "/" . $new_name . '.text"';
                //print("C: $command");
                //exit;
                $last_line = system($command, $retval);
                if ($retval > 0)
                {
                   if ($default->debug == true)
                   {
                      $sPdfError = "Return: $retval $last_line";
                      printError('DEBUG: Indexing MS WORD File \'' . $newpath . '\' Failed:' , $sPdfError);
                   }
                }

                IndexATextFile($default->owl_tmpdir . "/" . $new_name . '.text', $id);
                unlink($default->owl_tmpdir . "/" . $new_name . '.text');
             }
             elseif($sSearchExtension == 'sxw')
             {
                $tmpDir = $default->owl_tmpdir . "/owltmp.$sess";
                if (file_exists($tmpDir))
                {
                   myDelete($tmpDir);
                }

                mkdir($tmpDir,$default->directory_mask);
                                                                                                                                                                 
                $archive = new PclZip($newpath);
                $aListOfFiles = $archive->listContent();
                while ($aFileDetails = current($aListOfFiles)) {
                   if($aFileDetails["filename"] == "content.xml")
                   {
                      $iContentFileIndex = $aFileDetails["index"]; 
                      break;
                   }
                   next($aListOfFiles);
   		}

                if ($archive->extractByIndex($iContentFileIndex, $tmpDir) == 0)
                {
                   printError("DEBUG: " .$archive->errorInfo(true), "N: $newpath P: $tmpDir");
                }
		$text = file_get_contents("$tmpDir/content.xml");
 		$fp = fopen($tmpDir ."/content.xml.text", "w");
                fwrite($fp, strip_tags($text));
                fclose($fp);

                IndexATextFile($tmpDir ."/content.xml.text", $id);
                myDelete($tmpDir);
             }
             elseif($sSearchExtension == 'xls')
             {
                $xlwords = '';
                require_once('xlread.inc');
                $xl = new Spreadsheet_Excel_Reader();
                $xl->read($newpath);
                for ($k = count($xl->sheets)-1; $k>=0; $k--)
                {
                   for ($i = 1; $i <= $xl->sheets[$k]['numRows']; $i++)
                   {
                      for ($j = 1; $j <= $xl->sheets[$k]['numCols']; $j++)
                      {
                         $xlwords .= $xl->sheets[$k]['cells'][$i][$j] . ' ';
                      }
                   }
                }
                $xlwords = preg_replace('# +#si',' ',$xlwords);
                $xlwords = preg_replace('# $#si','',$xlwords);
                IndexABigString($xlwords, $id);
             }
             else
             {
                if ($sSearchExtension != 'pdf' and $sSearchExtension != 'doc' and $sSearchExtension != 'xls')
                {
                   IndexATextFile($newpath, $id);
                }
             } 
      } 
   } 
   // 
   // PDF and Text File Search Index Functions END
   // 
   function fFindFileExtension ($filename)
   {
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
      return strtolower($file_extension);
   } 

if (!function_exists("file_get_contents")) 
{
   function file_get_contents($filename, $use_include_path = 0) 
   {
      $data = ""; // just to be safe. Dunno, if this is really needed
      $file = @fopen($filename, "rb", $use_include_path);
      if ($file) 
      {
         while (!feof($file)) $data .= fread($file, 1024);
         fclose($file);
      }
      return $data;
   }
}


function my_copy($oldname, $newname)
{
   if(is_file($oldname))
   {
      $perms = fileperms($oldname);
      return copy($oldname, $newname) && chmod($newname, $perms);
   }
   else if(is_dir($oldname))
   {
      my_dir_copy($oldname, $newname);
   }
   else
   {
      die("Cannot copy file: $oldname (it's neither a file nor a directory)");
   }
}
 
function my_dir_copy($oldname, $newname)
{
   global $default;

   if(!is_dir($newname))
   {
      mkdir($newname, $default->directory_mask);
   }

   $dir = opendir($oldname);
   while($file = readdir($dir))
   {
      if($file == "." || $file == "..")
      {
         continue;
      }
      my_copy("$oldname/$file", "$newname/$file");
   }
   closedir($dir);
}
function fCopyFolder ($Folderid, $destparent)
{
   global $default;
   $GetFolder = new Owl_DB;
   $InsertFolder = new Owl_DB;
   $smodified = $InsertFolder->now();
   $GetFolder->query("SELECT * from $default->owl_folders_table where id ='$Folderid'");
   $GetFolder->next_record();

   if ($GetFolder->num_rows() == 1)
   {
      $InsertFolder->query("INSERT into $default->owl_folders_table (name, parent, security, groupid, creatorid, description, smodified)  values ('". $GetFolder->f("name") ."', '" . $destparent ."', '" . $GetFolder->f("security") . "', '" . $GetFolder->f("groupid") . "', '" . $GetFolder->f("creatorid") . "', '" . $GetFolder->f("description") . "', $smodified)");

      $newParent = $InsertFolder->insert_id($default->owl_folders_table, 'id');

      $GetFiles = new Owl_DB;
      $PutFiles = new Owl_DB;
      $GetFileData = new Owl_DB;
      $PutFileData = new Owl_DB;
      $GetDoctype = new Owl_DB;
      $PutDoctype = new Owl_DB;
      $GetFiles->query("SELECT * from $default->owl_files_table where parent ='" . $GetFolder->f("id") . "'");
      while ( $GetFiles->next_record() )
      {         
         // INSERT Files
         $PutFiles->query("INSERT into $default->owl_files_table (name,filename,f_size,creatorid,parent,created, description,metadata,security,groupid,smodified,checked_out, major_revision, minor_revision, url, doctype, approved) values ('" . $GetFiles->f("name") . "' , '" . $GetFiles->f("filename") . "' , '" . $GetFiles->f("f_size") . "' , '" . $GetFiles->f("creatorid") . "' , '$newParent', '" . $GetFiles->f("created") . "' , '" . $GetFiles->f("description") . "' , '" . $GetFiles->f("metadata") . "' , '" . $GetFiles->f("security") . "' , '" . $GetFiles->f("groupid") . "' , '" . $GetFiles->f("smodified") . "' , '" . $GetFiles->f("checked_out") . "' , '" . $GetFiles->f("major_revision") . "' , '" . $GetFiles->f("minorr_revision") . "' , '" . $GetFiles->f("url") . "' , '" . $GetFiles->f("doctype") . "' , '1')");

         $newFile = $PutFiles->insert_id($default->owl_files_table, 'id');

         // INSERT Associated Data
 
         if (!$default->owl_use_fs)
         {
            $GetFileData->query("SELECT * from $default->owl_files_data_table where id = '" . $GetFiles->f("id") . "'");
            $GetFileData->next_record();
            $PutFileData->query("INSERT into $default->owl_files_data_table (id, data, compressed) values ('$newFile', '" . $GetFileData->f("data") . "','" . $GetFileData->f("compressed") . "')");
         }
 
         // INSERT Associated Custom Fields
         $GetDoctype->query("SELECT * from $default->owl_docfieldvalues_table  where file_id ='" . $GetFiles->f("id") . "'");
         while ( $GetDoctype->next_record() )
         {
            $PutDoctype->query("INSERT into $default->owl_docfieldvalues_table (file_id, field_name, field_value) values ('$newFile', '" . $GetDoctype->f("field_name") . "' , '" . $GetDoctype->f("field_value") . "'");
         }

      }

      $GetFolders = new Owl_DB;
      $GetFolders->query("SELECT * from $default->owl_folders_table where parent ='" . $GetFolder->f("id") . "'");
      while($GetFolders->next_record())
      {
         fCopyFolder($GetFolders->f("id"), $newParent);
      }

   }
}

function fGetUserInfoInMyGroups($uid, $condition = "", $primary_group = false)
{
   global $default;

   $i = 0;
   $sql = new Owl_DB;
   $membersql = new Owl_DB;




   $UserGroupid = owlusergroup($uid);

   $sql->query("SELECT id, language,attachfile, username,name ,email from $default->owl_users_table where $condition and groupid = '$UserGroupid'");
   while ($sql->next_record())
   {
      $users[$i][username] = $sql->f("username");
      $users[$i][name] = $sql->f("name");
      $users[$i][email] = $sql->f("email");
      $users[$i][id] = $sql->f("id");
      $users[$i][language] = $sql->f("language");
      $users[$i][attachfile] = $sql->f("attachfile");
      $i++;
   }

   if ($primary_group)
   {
      $sql->query("SELECT username,name ,email from $default->owl_users_table where $condition and groupid = '$UserGroupid' and disabled='0'");
      while ($sql->next_record())
      {
         $bAddUser = true;
         foreach ($users as $aUsers)
         {  
           $sId = $aUsers["id"];
           if($sId  == $sql->f("id"))
           {  
              $bAddUser = false;
           }  
         }  

         if($bAddUser)
         {
            $users[$i][username] = $sql->f("username");
            $users[$i][name] = $sql->f("name");
            $users[$i][email] = $sql->f("email");
            $users[$i][id] = $sql->f("id");
            $users[$i][language] = $sql->f("language");
            $users[$i][attachfile] = $sql->f("attachfile");
            $i++;
         }
      }
   }
   else
   {
      $membersql = new Owl_DB;
      $membersql->query("SELECT userid,groupid from $default->owl_users_grpmem_table where userid = '$uid'");
      while ($membersql->next_record())
      {
         $CurrentGroupid = $membersql->f("groupid");
   
         $sql->query("SELECT username,name ,email from $default->owl_users_table where $condition and groupid = '$CurrentGroupid' and disabled='0'");
         while ($sql->next_record())
         {
            $bAddUser = true;
            foreach ($users as $aUsers)
            {  
              $sId = $aUsers["id"];
              if($sId  == $sql->f("id"))
              {  
                 $bAddUser = false;
              }  
            }  

            if($bAddUser)
            {
               $users[$i][username] = $sql->f("username");
               $users[$i][name] = $sql->f("name");
               $users[$i][email] = $sql->f("email");
               $users[$i][id] = $sql->f("id");
               $users[$i][language] = $sql->f("language");
               $users[$i][attachfile] = $sql->f("attachfile");
               $i++;
            }
         }
      }
   } 
   return $users;
}

function fGetGroups ($uid)
{
   global $default;
   if (fIsAdmin())
   {
      $sql = new Owl_DB;
      $sql->query("SELECT id,name from $default->owl_groups_table order by name");
      $i = 0;
      while ($sql->next_record())
      {
         $groups[$i][0] = $sql->f("id");
         $groups[$i][1] = $sql->f("name");
         $i++;
      }
   }
   else
   {
      $sql = new Owl_DB;
      $sql->query("SELECT groupid from $default->owl_users_table where id = '$uid'");
      $i = 0;
      while ($sql->next_record())
      {
         $maingroup = $sql->f("groupid");
         $groups[$i][0] = $sql->f("groupid");
         $groups[$i][1] = group_to_name($sql->f("groupid"));
         $i++;
      }
      
      $sql->query("SELECT userid,groupid from $default->owl_users_grpmem_table where userid = '$uid' and groupid <> '$maingroup'");

      while ($sql->next_record())
      {
         $groups[$i][0] = $sql->f("groupid");
         $groups[$i][1] = group_to_name($sql->f("groupid"));
         $i++;
      }
   }
   return $groups;
}

function fGetLastLogin()
{
   global $default, $userid;

   $getlastlogin = new Owl_DB;

   if ($default->anon_user <> $userid and !empty($userid))
   {     
      $getlastlogin->query("SELECT lastlogin FROM $default->owl_users_table where id = '" . $userid . "'");
      $getlastlogin->next_record();
      $lastlogin = $getlastlogin->f("lastlogin");
   }
   else
   {
      $lastlogin = ereg_replace("'", "", $getlastlogin->now());
   }     
   return $lastlogin;
}

function fCheckWithinHomeDir ( $currentparent )
{
   global $default, $parent, $bIsWithinHomeDir;

   $sql = new Owl_DB;
   $sql->query("select id,name,parent from $default->owl_folders_table where id='$currentparent' ");

   while ($sql->next_record())
   {
      if ($bIsWithinHomeDir)
      {
         break;
      }
      if ($sql->f("parent") == $default->HomeDir)
      {
         $bIsWithinHomeDir = true;
         break;
      }

      fCheckWithinHomeDir ($sql->f("parent"));
   }
}

function fGetFolderSize($iFolderId, $iFolderSize = 0, $getfiles = 0)
{
   global $default;

   if ($getfiles == 0)
   {
      $getfiles = new Owl_DB;
   }
   $getfolders = new Owl_DB;

   
   if ($default->restrict_view == 1)
   { 
      $getfiles->query("SELECT id, f_size from $default->owl_files_table where parent = '$iFolderId'");

      while ($getfiles->next_record())
      {
          $iFileId = $getfiles->f("id");
   
          if (check_auth($iFileId, "file_download", $userid, false, false) == 1)
          { 
             $iFolderSize += $getfiles->f("f_size");
          }
      }
   }
   else
   {
      $getfiles->query("SELECT sum(f_size) as fsize from $default->owl_files_table where parent = '$iFolderId'");
      $getfiles->next_record();
      
      if(!is_null($getfiles->f("fsize")))
      {
         $iFolderSize += $getfiles->f("fsize");
      }
   }

   $getfolders->query("SELECT id from $default->owl_folders_table where parent = '$iFolderId'");

   while ($getfolders->next_record())
   {
      $iFolderSize = fGetFolderSize($getfolders->f("id") , $iFolderSize, $getfiles);
   }

   return $iFolderSize;
}

function fGetBulkDownloadFiles($iFolderId)
{
   global $filelist, $default;

   $getfiles = new Owl_DB;

   $getfiles->query("SELECT * from $default->owl_files_table where parent = '$iFolderId'");

   while ($getfiles->next_record())
   {
       $iFileId = $getfiles->f("id");
       if (check_auth($iFileId, "file_download", $userid) == 1)
       {
          $filelist[] = $default->owl_FileDir . "/" . get_dirpath(owlfileparent($iFileId)) . "/" .  flid_to_filename($iFileId);
       }
   }

   $getfolders = new Owl_DB;
   $getfolders->query("SELECT * from $default->owl_folders_table where parent = '$iFolderId'");

   while ($getfolders->next_record())
   {
      fGetBulkDownloadFiles($getfolders->f("id"));
   }
}



function fGetPhysicalFileId ( $iFileId )
{

   global $default;
                                                                                                                                                                                                   
   $RealId = 0;
   $getfiles = new Owl_DB;

   $getfiles->query("SELECT linkedto from $default->owl_files_table where id = '$iFileId'");
 
   while ($getfiles->next_record())
   {
      $RealId = $getfiles->f("linkedto");
   }

   if(empty($RealId) or $RealId == 0)
   {
      $RealId = $iFileId;
   }

   return $RealId;
}


function fCleanDomTTContent ($sDescription )
{
   $sReturnDesc = ereg_replace("\n", '<br />', $sDescription);
   $sReturnDesc = ereg_replace("\"", "'", $sReturnDesc);
   $sReturnDesc = ereg_replace("'", "\\'", $sReturnDesc);
   $sReturnDesc = ereg_replace("\r", '', $sReturnDesc);
   //$sReturnDesc = nl2br($sDescription);

   return $sReturnDesc;
}                                                                                                                                                                                                   
function ldap_authenticate($u, $p)
{
   global $default; 

   // Generate a DN from a uid
   $dn = "$default->ldapuserattr=$u, " . $default->ldapserverroot;

   // Connect to ldap server
   $dsCon = ldap_connect($default->ldapserver);

   // Make sure we connected
   if (!($dsCon))
   {
      printError("Sorry, cannot contact LDAP server");
      return(1);
   }

   // Attempt to bind, if it works, the password is acceptable
   ldap_set_option($dsCon, LDAP_OPT_PROTOCOL_VERSION, $default->ldapprotocolversion);
   $bind = ldap_bind($dsCon, $dn, $p);
   if(!($bind))
   {
      return(1);
   }
   else
   {
      // If we got here, the username/password worked.
      ldap_close($dsCon);
      return (0);
   }
}

?>
