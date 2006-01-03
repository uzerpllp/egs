<?php

/**
 * register.php
 * 
 * Author: Steve Bourgeois <owl@bozzit.com>
 * Project Founder: Chris Vincent <cvincent@project802.net>
 *
 * Copyright (c) 1999-2005 The Owl Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 */

require_once("./config/owl.php");
require_once("./lib/disp.lib.php");
require_once("./lib/owl.lib.php");

if ($default->self_reg == 0 && $default->forgot_pass == 0)
{
   header("Location: " . $default->owl_root_url . "/index.php?login=1");
} 
if ($default->self_reg == 0 && $myaction == 'register')
{
   header("Location: " . $default->owl_root_url . "/index.php?login=1");
} 
if ($default->forgot_pass == 0 && $myaction == 'forgot')
{
   header("Location: " . $default->owl_root_url . "/index.php?login=1");
} 

require_once("./lib/security.lib.php");
require_once("phpmailer/class.phpmailer.php");

unset($userid);

function fPrintHeader ()
{
   global $default;

   include_once("./lib/header.inc");
   include_once("./lib/userheader.inc");

   print("<center>\n");
   print("<table class='border1' cellspacing='0' cellpadding='0' border='0' width='$default->table_collapse_width'><tr><td align='left' valign='top' width='100%'>\n");
   fPrintButtonSpace(12, 1);
   print("<table class='border2' cellspacing='0' cellpadding='0' border='0' width='100%'><tr><td align='left' valign='top' width='100%'>\n");
   
   if ($default->show_prefs == 1 or $default->show_prefs == 3)
   {
      fPrintPrefs("infobar1", "top");
   }

   fPrintButtonSpace(12, 1);
}

function printThankYou($username)
{
   global $default, $language;
   global $owl_lang;

   fPrintHeader();

   print("<table width='100%'><tr><td>");
   fPrintSectionHeader($owl_lang->thank_you_1, "admin3");
   print("</td></tr><table>");
   fPrintButtonSpace(12, 1);

   print("<table width='100%'><tr><td align='center'>");
   print("$owl_lang->thank_you_2 <b>$username</b>");
   print("</td></tr><table>");
   fPrintButtonSpace(12, 1);

   if ($default->show_prefs == 2 or $default->show_prefs == 3)
   {
      fPrintPrefs("infobar2");
   }
   print("</td></tr></table>\n");
   include("./lib/footer.inc");
} 

function printuser($name, $username, $email)
{
   global $owl_lang;
   global $default;

   print("<form enctype='multipart/form-data' action='register.php' method='post'>\n");
   print("<input type='hidden' name='myaction' value='newuser'></input>");
   print("<table class='margin2' cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
   print("<tr><td class='browse0' width='100%' colspan='20'>$owl_lang->register</td></tr>\n");
   print("<tr>\n");
   print("<td align='left' valign='top'>\n");
   print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
   fPrintFormTextLine($owl_lang->full_name . ":" , "name", "40", $name);
   fPrintFormTextLine($owl_lang->username . ":" , "username", "", $username);
   fPrintFormTextLine($owl_lang->email . ":" , "email", "40", $email);

   print("<tr>\n");
   print("<td class='form1'>");
   fPrintButtonSpace(1, 1);
   print("</td>\n
");
   print("<td class='form2' width='100%'>");
   fPrintSubmitButton($owl_lang->submit, $owl_lang->register, "submit", "register_btn_x");
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

function printgetpasswd()
{
   global $owl_lang;
   global $default;


   print("<form enctype='multipart/form-data' action='register.php' method='post'>\n");
   print("<input type='hidden' name='myaction' value='getpasswd'></input>");
   print("<table class='margin2' cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
   print("<tr><td class='browse0' width='100%' colspan='20'>$owl_lang->send_pass</td></tr>\n");
   print("<tr>\n");
   print("<td align='left' valign='top'>\n");
   print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
   fPrintFormTextLine($owl_lang->username . ":" , "username", "", $username);

   print("<tr>\n");
   print("<td class='form1'>");
   fPrintButtonSpace(1, 1);
   print("</td>\n");
   print("<td class='form2' width='100%'>");
   fPrintSubmitButton($owl_lang->send_pass, $owl_lang->send_pass, "submit", "getpasswd_btn_x");
   fPrintSubmitButton($owl_lang->btn_reset, $owl_lang->alt_reset_form, "reset");
   print("</td>\n");
   print("</tr>\n");
   print("</table>\n");
   print("</td></tr></table>\n");
   fPrintButtonSpace(12, 1);
   print("</form>\n");

   if ($default->show_prefs == 2 or $default->show_prefs == 3)
   {
      fPrintPrefs("infobar2");
   }
   print("</td></tr></table>\n");
   include("./lib/footer.inc");
} 

if ($myaction == "newuser")
{
   $password = GenRandPassword();

   if ($email == "" || $name == "" || $username == "")
   {
      fPrintHeader();
      print("<table width='100%'><tr><td>");
      fPrintSectionHeader($owl_lang->err_req, "admin3");
      print("</td></tr><table>");
      //print("$owl_lang->err_req");
      printuser($name, $username, $email);
   } 
   else
   {
      $sql = new Owl_DB;
      $sql->query("SELECT * FROM $default->owl_users_table WHERE username = '$username'");
      if ($sql->num_rows($sql) > 0) printError("$owl_lang->err_user_exists<br></br>$owl_lang->username");
      $sql->query("SELECT * FROM $default->owl_users_table WHERE name = '$name'");
      if ($sql->num_rows($sql) > 0) printError("$owl_lang->err_user_exists<br></br>$owl_lang->full_name");

      $dNow = $sql->now();

       $sql->query("INSERT INTO $default->owl_users_table (groupid,username,name,password,quota_max,quota_current,email,notify,attachfile,disabled,noprefaccess,language,maxsessions,curlogin, lastlogin,newsadmin,buttonstyle, homedir, firstdir ) VALUES ('$default->self_reg_group', '$username', '$name', '" . md5($password) . "', '$default->self_reg_quota', '0', '$email', '$default->self_reg_notify','$default->self_reg_attachfile', '$default->self_reg_disabled', '$default->self_reg_noprefacces', '$default->owl_lang', '$default->self_reg_maxsessions', $dNow, $dNow, '0', '$default->system_ButtonStyle', '$default->self_reg_homedir','$default->self_reg_firstdir')");


      $sql->query("SELECT email FROM $default->owl_users_table WHERE username = 'admin'");
      $sql->next_record();
      $ccto = $sql->f("email");
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

      if ($ccto != "")
      {
         $mail->AddCC("$ccto");
      }
      $mail->WordWrap = 50; // set word wrap to 50 characters
      $mail->IsHTML(true); // set email format to HTML
      $mail->Subject = "$owl_lang->self_reg_subj";
      $mail->Body = "<html><body>" . "$owl_lang->self_reg_bod $password" . "<br></br><br></br>";
      $link = $default->owl_notify_link . "index.php" ;
      $mail->Body .= "<A HREF=" . $link . ">$owl_lang->login</A>";
      $mail->altBody = "$owl_lang->self_reg_bod $password" . "\n\n";
      $mail->Body .= "</body></html>";

      if (!$mail->Send())
      {
         print("$owl_lang->err_email<br></br>");
         print("$mail->ErrorInfo");
         $sql->query("DELETE from $default->owl_users_table where username = '$username' and name = '$name' and password = '" . md5($password) . "' AND  email='$email'");
      } 
      printThankYou($username);
      $sql->query("select id from $default->owl_users_table where username = '$username' and name = '$name' and password = '" . md5($password) . "' AND  email='$email'");
      $sql->next_record();
      owl_syslog(USER_REG, $sql->f("id"), 0, 0, "$owl_lang->self_passwd $email", "LOGIN");
      exit;
   } 
} elseif ($myaction == "forgot")
{
   fPrintHeader();
   printgetpasswd();

} elseif ($myaction == "getpasswd")
{
   $password = GenRandPassword();
   $sql = new Owl_DB;

   $sql->query("SELECT * FROM $default->owl_users_table WHERE username = '$username' and id <> '1' and disabled = '0'");

   $failed = false;

   if ($sql->num_rows($sql) == 0) 
   {
      $failed = true;
   }

   printThankYou($username);

   if ($failed === false)
   {
      $sql->query("SELECT email FROM $default->owl_users_table WHERE username = '$username'");
      $sql->next_record();
      $email = $sql->f("email");
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
      $mail->Subject = "$owl_lang->self_reg_subj";
      $mail->Body = "<html><body>" . "$owl_lang->self_reg_rset $password" . "<br></br><br></br>";
      $link = $default->owl_notify_link . "index.php" ;
      $mail->Body .= "<A HREF=" . $link . ">$owl_lang->login</A>";
      $mail->altBody = "$owl_lang->self_reg_rset $password" . "\n\n";
      $mail->Body .= "</body></html>";

      if (!$mail->Send())
      {
         print("$owl_lang->err_email<br></br>");
         print("$mail->ErrorInfo");
      } 
      $sql->query("UPDATE $default->owl_users_table set password = '" . md5($password) . "'where username = '$username'");
      $sql->query("select id from $default->owl_users_table where username = '$username'");
      $sql->next_record();
      owl_syslog(FORGOT_PASS, $sql->f("id"), 0, 0, "$owl_lang->self_passwd $email", "LOGIN");
   }
   exit;
} 
elseif ($myaction == "register")
{
   fPrintHeader();
   printuser("", "", "");
   exit;
} 
else
{
   header("Location: " . $default->owl_root_url . "/index.php?login=1");
   exit;
}
?>
