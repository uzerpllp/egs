<?php
/**
 * index.php -- Main page
 * 
 * Author: Steve Bourgeois <owl@bozzit.com>
 * Project Founder: Chris Vincent <cvincent@project802.net>
 *
 * Copyright (c) 1999-2005 The Owl Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 * 
 * $Id: index.php,v 1.17 2005/03/25 12:57:07 carlostrub Exp $
 */
 
error_reporting(E_ALL ^ E_NOTICE);
if (bcheckLibExists("./config/owl.php")) require_once("./config/owl.php");
if (bcheckLibExists("./lib/disp.lib.php")) require_once("./lib/disp.lib.php");
if (bcheckLibExists("./lib/owl.lib.php")) require_once("./lib/owl.lib.php"); 

if (isset($HTTP_COOKIE_VARS["owl_sessid"]) and $default->remember_me)
{
   if ($login ==  "0")
   {
      if (!(strcmp($login, "logout") == 0))
      {
         if ( isset($_POST[loginname]) and isset($_POST[password]))
         {
            $sql = new Owl_DB;

            $sess = $HTTP_COOKIE_VARS["owl_sessid"];

            if ($default->active_session_ip) 
            {
               $sql->query("DELETE FROM $default->owl_sessions_table WHERE sessid = '$sess' and ip <> '0'");
            } 
            else 
            {
               $sql->query("DELETE FROM $default->owl_sessions_table WHERE sessid = '$sess' and ip = '0'");
            }
            setcookie ("owl_sessid", "");
         }
         else
         {
            $sess = $HTTP_COOKIE_VARS["owl_sessid"];
            $sql = new Owl_DB;
            $sql->query("SELECT usid FROM $default->owl_sessions_table WHERE sessid = '$sess'");
            $sql->next_record();
            $uid = $sql->f("usid");

            $sql->query("SELECT curlogin FROM $default->owl_users_table WHERE id = '$uid'");
            $sql->next_record();
            $curlogin = $sql->f("curlogin");

            $sql->query("update $default->owl_users_table set lastlogin = '" . $curlogin . "' WHERE id = '$uid'");
            $dNow = $sql->now();
            $sql->query("update $default->owl_users_table set curlogin = $dNow WHERE id = '$uid'");

            header("Location: browse.php?sess=$sess");
            exit;
         }
      }
   }
}
else
{
   setcookie ("owl_sessid", "");
}

// 
// Function to check if the required libraries exists
// and are readable by the web server.
// and issue a more significant message
// Maybe we need this in other files as well, I'll wait and
// see.
function fPrintLoginPage($message = "")
{
   global $default, $owl_lang, $language, $parent, $fileid, $anon_disabled ;

   print("<table class=\"login1\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
   print("<tr><td width=\"100%\">\n");
   print("</td></tr>\n");
   print("</table>\n");
   
   print("<table class=\"login2\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n");
   print("<tr>\n");
   print("<td width=\"50%\">");
   fPrintButtonSpace(1, 24); 
   print("<img src=\"$default->owl_graphics_url/$default->sButtonStyle/ui_misc/$default->owl_logo\" alt=\"OWL Logo\"></img></td>\n");
   print("<td>\n");


   if ($anon_disabled != 1)
   {
      print("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
      print("<tr><td class=\"logbutton1\" align=\"center\" width=\"100%\">\n");
      print("<a class=\"loglbutton1\" href=\"browse.php\">$owl_lang->anonymous</a><br />\n");
      fPrintButtonSpace(8, 1); 
      print("<br />\n");
      print("</td></tr>\n");
      print("</table>\n");
   }

   if (!empty($message))
   {
      print($message);
   }

   print("<form action=\"index.php\" method=\"post\">");

   print("<table class=\"login3\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">");
   if (isset($fileid))
   {
      print "<input type=\"hidden\" name=\"parent\" value=\"$parent\"></input>\n";
      print "<input type=\"hidden\" name=\"fileid\" value=\"$fileid\"></input>\n";
   } 
   print("<tr><td colspan=\"4\">");
   fPrintButtonSpace(14, 1);
   print("</td>\n</tr>\n");
   print("<tr>\n");
   print("<td width=\"50%\">");
   fPrintButtonSpace(10, 1);
   print("</td>\n");
   print("<td class=\"logtxt1\"><label for=\"loginname\">" . $owl_lang->username . ":&nbsp;</label></td>\n");
   print("<td><input id=\"loginname\" class=\"finput1\" type=\"text\" name=\"loginname\" size=\"24\" maxlength=\"255\"></input></td>\n");
   print("<td width=\"50%\">");
   fPrintButtonSpace(1, 1);
   print("</td>\n");
   print("</tr>\n");
   print("<tr>\n");
   print("<td colspan=\"4\" width=\"50%\">");
   fPrintButtonSpace(3, 1);
   print("</td>\n");
   print("</tr>\n");
   print("<tr>\n");
   print("<td width=\"50%\">");
   fPrintButtonSpace(1, 1);
   print("</td>\n");
   print("<td class=\"logtxt1\"><label for=\"password\">". $owl_lang->password . ":&nbsp;</label></td>\n");
   print("<td><input id=\"password\" class=\"finput1\" type=\"password\" name=\"password\" size=\"24\" maxlength=\"255\"></input></td>\n");
   print("<td width=\"50%\">");
   fPrintButtonSpace(1, 1);
   print("</td>\n");
   print("</tr>\n");
   print("<tr><td colspan=\"4\">");
   fPrintButtonSpace(4, 1);
   print("</td></tr>\n");
   if ($default->remember_me)
   {
      print("<tr>\n");
      print("<td class=\"logtxt2\" colspan=\"3\">$owl_lang->remember_me_checkbox &nbsp;<input type=\"checkbox\" id=\"remember\" name=\"rememberme\" value=\"1\"></input></td>\n");
      print("<td>");
      fPrintButtonSpace(1, 1);
      print("</td>\n");
      print("</tr>\n");
   }
   print("<tr><td colspan=\"4\">");
   fPrintButtonSpace(8, 1);
   print("</td></tr>\n");
   print("</table>\n");

   print("<table class=\"login4\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
   print("<tr><td colspan=\"4\">");
   fPrintButtonSpace(1, 1);
   print("</td></tr>\n");
   print("<tr>\n");
   if (count($default->owl_db_display_name) > 1)
   {
      print("<td  class=\"logtxt2\" >$owl_lang->repository_list &nbsp;</td>");
      print("<td align=\"left\" >");

      print("<select class=\"fpull1\" name=\"currentdb\" size=\"1\">\n");
      $i = 0;
      foreach($default->owl_db_display_name as $database)
      {
         print("<option value=\"$i\" ");
         if ( $i == $default->owl_default_db)
         {
            print("selected=\"selected\"");
         }
         print(">$database</option>\n");
         $i++;
      }
      print("</select></td>");
   }
   else
   {
      print("<td align=\"left\" >&nbsp;</td>");
      print("<td align=\"left\">&nbsp;</td>");
   }
   print("<td align=\"right\">");
   fPrintSubmitButton($owl_lang->btn_login, $owl_lang->alt_btn_login);
   print("</td>\n");
   print("<td>");
   fPrintButtonSpace(1, 1);
   print("</td>\n");
   print("</tr>\n");
   print("<tr><td colspan=\"4\">");
   fPrintButtonSpace(1, 1);
   print("</td></tr>\n");
   print("</table>\n");

   if ($default->self_reg == 1 or $default->forgot_pass == 1)
   {
      print("<table class=\"login5\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
      print("<tr><td colspan=\"2\">");
      fPrintButtonSpace(1, 8);
      print("</td></tr>\n");
      print("<tr>\n");
      print("<td class=\"logbutton1\" >");
   }

   if ($default->self_reg == 1)
   {
      print("<a class=\"loglbutton1\" href=\"register.php?myaction=register\">$owl_lang->like_register</a>&nbsp;&nbsp;\n");
   }

   if ($default->self_reg == 1 and $default->forgot_pass == 1)
   {
     print("|&nbsp;&nbsp;");
   }

   if ($default->forgot_pass == 1)
   {
      print("<a class=\"loglbutton1\" href=\"register.php?myaction=forgot\">$owl_lang->forgot_pass<br></br></a>\n");
   }

   if ($default->self_reg == 1 or $default->forgot_pass == 1)
   {
      print("</td>\n");
      print("</tr>\n");
      print("</table>\n");
   }

   print("</form>\n");
   print("</td>\n");
   print("<td width=\"50%\">");
   fPrintButtonSpace(1, 1);
   print("</td>\n");
   print("</tr>\n");
   print("</table>\n");

   print("<table class=\"login9\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
   print("<tr><td class=\"logowlbar1\" width=\"100%\">\n");
   fPrintButtonSpace(1, 4);
   print("<a class=\"lbutton1\" href=\"http://validator.w3.org/check?uri=referer\">" . $owl_lang->engine . ", " . $owl_lang->version . " " . $default->version . "</a>\n");
}

// 
function bcheckLibExists ($filename)
{
   global $default;
   if (file_exists("$filename"))
   {
      if (is_readable("$filename"))
      {
         return true;
      } 
      else
      {
         die("<br /><font size=\"4\"><center>$owl_lang->debug_webserver_no_access</center></font>");
      } 
   } 
   else
   {
      die("<br /><font size=\"4\"><center>$owl_lang->debug_file_not_exist</center></font>");
   } 
} 

//if (checkrequirements() == 1)
//{
   //exit;
//} 

if (!isset($failure)) $failure = 0;
if (!$login) $login = 1;

if($default->auth == 1 and isset($_SERVER['PHP_AUTH_USER']))
{
   $_POST[loginname] = $_SERVER['PHP_AUTH_USER'];
}


//print("DB: $default->owl_current_db") ;
//print("L: $_POST[loginname] -- $_GET[loginname]") ;
//exit;
if (($_POST[loginname] && $_POST[password]) or ($default->auth == 1 and $_POST[loginname] and $login <> "logout"))
{
   $verified["bit"] = 0;
   $verified = verify_login($_POST[loginname], $_POST[password]);

   if ($verified["bit"] == 1)
   {
      $session = new Owl_Session;
      $uid = $session->Open_Session(0, $verified["uid"]);
      $id = 1;

      /**
       * If an admin signs on We want to se the admin menu
       * Not the File Browser.
       */
      owl_syslog(LOGIN, $verified["uid"], 0, 0, $owl_lang->log_login_det . $verified["user"], "LOGIN");

      $sql = new Owl_DB;
      $sql->query("SELECT curlogin FROM $default->owl_users_table WHERE id = '" . $verified["uid"] . "'");
      $sql->next_record();
      $curlogin = $sql->f("curlogin");
      $sql->query("update $default->owl_users_table set lastlogin = '" . $curlogin . "' WHERE id = '" . $verified["uid"] . "'");
      $dNow = $sql->now();
      $sql->query("update $default->owl_users_table set curlogin = $dNow WHERE id = '" . $verified["uid"] . "'");

      $usergroupid = $verified["group"];
      $userid = $verified["uid"];
 
      if (fIsAdmin(true))
      {
         if (!isset($fileid))
         {
            if($default->admin_login_to_browse_page)
            {
               header("Location: browse.php?sess=" . $uid->sessdata["sessid"] . "&parent=" . $verified["homedir"]);
            }
            else
            {
               header("Location: admin/index.php?sess=" . $uid->sessdata["sessid"]);
            }
         }
         else
         {
            header("Location: browse.php?sess=" . $uid->sessdata["sessid"] . "&parent=$parent&fileid=$fileid");
         }
      } 
      else
      {
         if (!isset($fileid))
         {
            header("Location: browse.php?sess=" . $uid->sessdata["sessid"] . "&parent=" . $verified["homedir"] );
         }
         else
         {
            header("Location: browse.php?sess=" . $uid->sessdata["sessid"] . "&parent=$parent&fileid=$fileid");
         }
      } 
   } 
   else
   {
      owl_syslog(LOGIN_FAILED, $verified["uid"], 0, 0, $owl_lang->log_login_det . $verified["user"], "LOGIN");
      if ($verified["bit"] == 2)
      {
         header("Location: index.php?login=1&failure=2");
      }
      else
      {
         if ($verified["bit"] == 3)
         {
            if ($default->auth == 0)
            {
               header("Location: index.php?login=1&failure=3");
            }
            else
            {
               printError("$owl_lang->toomanysessions");
            }
         }
         else
         {
            header("Location: index.php?login=1&failure=1");
         }
      }
   }
} 

// CHECK IF THE ANONYMOUS USER IS DISABLELD
$sql = new Owl_DB;
$anon_disabled = 1;
$sql->query("select * from $default->owl_users_table WHERE id = '$default->anon_user'");
if ($sql->num_rows() == 1)
{
   $sql->next_record();
   $anon_disabled = $sql->f("disabled");
} 

if (($login == 1) || ($failure > 0))
{
   include("./lib/header.inc");
   include("./lib/userheader.inc");

   print("<center>\n");
   if ($failure == 1) $message = "$owl_lang->loginfail<br />\n";
   if ($failure == 2) $message = "<B>'$accountname'</B>&nbsp;$owl_lang->logindisabled<br /><br />\n";
   if ($failure == 3) $message = "$owl_lang->toomanysessions<br />\n";
   if ($failure == 4) $message = "$owl_lang->err_login<br />\n";
   fPrintLoginPage($message);
   include("./lib/footer.inc");
   exit;
} 

if ($login == "logout")
{
   include("./lib/header.inc");
   include("./lib/userheader.inc");
   print("<center>\n");
   if ($default->auth == 0 or $default->auth == 2)
   {
      if (!isset($HTTP_COOKIE_VARS["owl_sessid"]))
      {
         $sql = new Owl_DB;
         if ($default->active_session_ip) 
         {
            $sql->query("DELETE FROM $default->owl_sessions_table WHERE sessid = '$sess' and ip <> '0'");
         } 
         else 
         {
            $sql->query("DELETE FROM $default->owl_sessions_table WHERE sessid = '$sess' and ip = '0'");
         }
      }
      $tmpDir = $default->owl_tmpdir . "/owltmp.$sess";
      if (file_exists($tmpDir))
      {
         myDelete($tmpDir);
      }

      $message = "$owl_lang->successlogout<br />\n";

      owl_syslog(LOGOUT, $userid, 0, 0, $owl_lang->log_detail, "LOGIN");
   
      fPrintLoginPage($message);
   }
   else
   {
      if (!isset($HTTP_COOKIE_VARS["owl_sessid"]))
      {
         $sql = new Owl_DB;
         if ($default->active_session_ip) 
         {
            $sql->query("DELETE FROM $default->owl_sessions_table WHERE sessid = '$sess' and ip <> '0'");
         } 
         else 
         {
            $sql->query("DELETE FROM $default->owl_sessions_table WHERE sessid = '$sess' and ip = '0'");
         }
      }
      $tmpDir = $default->owl_tmpdir . "/owltmp.$sess";
      if (file_exists($tmpDir))
      {
         myDelete($tmpDir);
      }

      $message = "$owl_lang->successlogout<br />\n";
      owl_syslog(LOGOUT, $userid, 0, 0, $owl_lang->log_detail, "LOGIN");

      fPrintLoginPage($message);

   }
   include("./lib/footer.inc");
   exit;
} 
include("./lib/footer.inc");
?>
