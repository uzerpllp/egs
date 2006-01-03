<?php

/**
 * mtool.php
 * 
 * Author: Steve Bourgeois <owl@bozzit.com>
 * Project Founder: Chris Vincent <cvincent@project802.net>
 *
 * Copyright (c) 1999-2005 The Owl Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 * 
 */

require_once("./config/owl.php");
require_once("./lib/disp.lib.php");
require_once("./lib/owl.lib.php");
require_once("./lib/security.lib.php");
require_once("./phpid3v2/class.id3.php");

if(!fIsEmailToolAccess($userid))
{
   displayBrowsePage($parent);
}

include_once("./lib/header.inc");
include_once("./lib/userheader.inc");

if ($sess == "0" && $default->anon_ro > 1)
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

      printModifyHeader();
      print("<br />");

      $sql = new Owl_DB;
      $sql->query("SELECT * from $default->owl_users_table where id = '$userid'");
      $sql->next_record();
      $default_reply_to = $sql->f("email");

      $urlArgs2 = $urlArgs;
      $urlArgs2['id']     = $id;
      $urlArgs2['action'] = 'email';
      $urlArgs2['type']   = $type;
      //$urlArgs2['MAX_FILE_SIZE'] = $default->max_filesize;


      print("<form enctype='multipart/form-data' action='dbmodify.php' method='post'>\n");
      print fGetHiddenFields ($urlArgs2);
      if (!$default->use_smtp)
      {
         print("<input type='hidden' name='ccto' value=''></input>\n");
      }

      print("<table class='margin2' cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
      print("<tr>\n");
      print("<td align='left' valign='top'>\n");
      print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
      fPrintFormTextLine($owl_lang->email_to . ":" , "mailto");

      $sql = new Owl_DB;
      $sQuery = "SELECT distinct username,name ,email from $default->owl_users_table u , $default->owl_users_grpmem_table m where email <> '' and (u.groupid = '$usergroupid' or m.groupid = '$usergroupid' ";
      $sql->query("SELECT groupid from $default->owl_users_grpmem_table where userid = '$userid'");
      $i = 1;
      while ($sql->next_record())
      {
         if ($sql->f("groupid") != $usergroupid)
         {
            $sQuery .= " or u.groupid = '" . $sql->f("groupid") . "' or m.groupid = '" . $sql->f("groupid") . "'";
         } 
      } 

      $sQuery .= ")  order by name";
      $sql->query("$sQuery");

      print("<tr>\n");
      print("<td class='form1'>&nbsp;</td>\n");
      print("<td class='form1' width='100%'>");
      print("<select class='fpull1' name='pick_mailto' size='1'>\n");
      print("<option value=''>" . $owl_lang->pick_select . "</option>\n");

      while ($sql->next_record())
      {
         $sUsername = $sql->f("username");
         $sName = $sql->f("name");
         $sEmail = $sql->f("email");

         if ($sName == "")
         {
            print("<option value=\"" . $sEmail . "\" >" . $sUsername . " &#8211; (" . $sEmail . ")</option>\n");
         } 
         else
         {
            print("<option value=\"" . $sEmail . "\" >" . $sName . " &#8211; (" . $sEmail . ")</option>\n");
         }
      } 
      print("</select>\n</td>\n</tr>\n");
 
   if ($default->use_smtp)
   {
      fPrintFormTextLine($owl_lang->email_cc . ":" , "ccto");
   }

   fPrintFormTextLine($owl_lang->email_reply_to . ":" , "replyto", 30, $default_reply_to);
   fPrintFormTextLine($owl_lang->email_subject . ":" , "subject", 80, "$default->owl_email_subject");
   fPrintFormTextArea($owl_lang->email_body . ":", "mailbody", "",20,80);
   print("<tr>\n");
   print("<td class='form1'>");
   fPrintButtonSpace(1, 1);
   print("</td>\n");
   print("<td class='form2' width='100%'>");
   fPrintSubmitButton($owl_lang->btn_send_email, $owl_lang->alt_send_email, "submit", "send_file_x");
   fPrintSubmitButton($owl_lang->btn_reset, $owl_lang->alt_reset_form, "reset");
   print("</td>\n");
   print("</tr>\n");
   print("</table>\n");
   print("</td></tr></table>\n");
   print("</form>\n");
   fPrintButtonSpace(1, 12);

   if ($default->show_prefs == 2 or $default->show_prefs == 3)
   {
      fPrintPrefs("infobar2");
   }
   print("</td></tr></table>\n");
   include("./lib/footer.inc");
?>
