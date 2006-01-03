<?php

/*
 * disp.lib.php
 *
 * Author: Steve Bourgeois <owl@bozzit.com>
 * Project Founder: Chris Vincent <cvincent@project802.net>
 *
 * Copyright (c) 1999-2005 The Owl Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 *
 * $Id: disp.lib.php,v 1.36 2005/03/25 14:15:44 carlostrub Exp $
 */

if (!$default->old_action_icons)
{
   require_once ($default->owl_fs_root . "/scripts/phplayersmenu/lib/PHPLIB.php");
   require_once ($default->owl_fs_root . "/scripts/phplayersmenu/lib/layersmenu-common.inc.php");
   require_once ($default->owl_fs_root . "/scripts/phplayersmenu/lib/layersmenu.inc.php");
}

// ***  Functions contributed by Value 4 Business
// BEGIN

function fGetURL ($file, $args)
{
   global $default;

   if ( 0 < strlen($default->owl_root_url))
   {
      $pos = strpos($file, $default->owl_root_url);
   }

   if ( $pos !== false)
   {
      $url = $file; 
   }
   else
   {
      $url = "$default->owl_root_url/$file";

   }
 
   $params = '';
   foreach ($args as $k => $v)
   {
      settype($v, "string");  

      if ($v != "")
      {
         $params .= "$k=$v". "&amp;";
      }
   }
   $params = substr ($params, 0, strlen($params)-5);

   $url .= "?$params";
   return $url;
}


function fGetHiddenFields ($args)
{
   $html = '';
   
   foreach ($args as $k => $v)
   {
      if ($v)
      {
         $html .= "<input type=\"hidden\" name=\"$k\" value=\"$v\"></input>\n";
      }
   }

    return $html;
}

// END

function fPrintFormRadio($rowtitle, $fieldname, $value, $option_text )
{
   print("<tr>\n");
   print("<td class=\"form1\">$rowtitle</td>\n");
   $iValue = 0;
   $checked = "";
   print("<td class=\"form1\" width=\"100%\">");
   foreach ($option_text as $caption)
   {
      if ($iValue == $value) 
      {
         $checked = "checked=\"checked\"";
      }
      print("<input type=\"radio\" value=\"$iValue\" name=\"$fieldname\" $checked></input>$caption\n");
      $checked = "";
      $iValue++;
   }

   print("</td>\n</tr>\n");
}

function fPrintSectionHeader($title, $class = 'admin2')
{
   print("<tr><td class=\"$class\" width=\"100%\" colspan=\"2\">$title<br></br></td></tr>\n");
}

function fPrintFormCheckBox($rowtitle, $fieldname, $value, $checked = "")
{
   if (!empty($checked))
   {
      $checked = "checked=\"$checked\"";
   }
   print("<tr>\n");
   print("<td class=\"form1\">$rowtitle</td>\n");
   print("<td class=\"form1\" width=\"100%\"><input class=\"fcheckbox1\" type=\"checkbox\" name=\"$fieldname\" value=\"$value\" $checked></input></td>\n");
   print("</tr>\n");
}

function fPrintFormTextArea($rowtitle, $fieldname, $currentvalue = "" , $row = 10, $cols = 50)
{
   print("<tr>\n");
   print("<td class=\"form1\">$rowtitle</td>\n");
   print("<td class=\"form1\" width=\"100%\"><textarea class=\"ftext1\" name=\"$fieldname\" rows=\"$row\" cols=\"$cols\">$currentvalue</textarea></td>\n");
   print("</tr>\n");
}

function fPrintFormTextLine($rowtitle, $name, $size = "24", $value = "", $bytes = "", $readonly = false, $type = 'text')
{
   print("<tr>\n");
   print("<td class=\"form1\">");
   if(!empty($name) and $type == "text")
   {
      print("<label for=\"$name\">");
   }
   print($rowtitle);

   if(!empty($name) and $type == "text")
   {
      print("</label>");
   }
   print("</td>\n");

   if ($readonly)
   {
      print("<td class=\"form1\" width=\"100%\">$value");
      if(!empty($bytes))
      {
         print(" ($bytes)");
      } 
      print("</td>\n");
   }
   else
   {
      print("<td class=\"form1\" width=\"100%\"><input class=\"finput1\" id=\"$name\" type=\"$type\" name=\"$name\" size=\"$size\" maxlength=\"255\" value=\"$value\"></input>");
      if(!empty($bytes))
      {
         print("($bytes)");
      } 
      print("</td>\n");

   }
   print("</tr>\n");
}


function fPrintFormSelectBox($rowtitle, $fieldname, $values, $currentvalue = "No value", $size = 1, $multiple = false)
{
   global $owl_lang;
   $found = false;
   print("<tr>\n");
   print("<td class=\"form1\">$rowtitle</td>\n");
   print("<td class=\"form1\" width=\"100%\">");
   print("<select class=\"fpull1\" name=\"$fieldname\" size=\"$size\"");
   if ($multiple)
   {
      print(" multiple=\"multiple\" ");
      $currentvalue = preg_split("/\s+/", strtolower($currentvalue));
   }
   print(">\n");
   if (is_array($values))
   {
      foreach($values as $g)
      {
         print("<option value=\"$g[0]\" ");
         if ($multiple)
         {
            if(preg_grep("/$g[0]/", $currentvalue))
            {
               print("selected=\"selected\"");
               $found = true;
            }
         }
         else
         {
            if ($g[0] == $currentvalue)
            {   
               print("selected=\"selected\"");
               $found = true;
            }   
         }
         print(">$g[1]</option>\n");
      }      
   }
   if (!$found and $currentvalue <> "No value")
   {
      if($multiple)
      {
         print("<option value=\"\" selected=\"selected\">$owl_lang->none_selected</option>");
      }
      else
      {
         print("<option value=\"$currentvalue\" selected=\"selected\">$owl_lang->none_selected</option>");
      }
   }
   print("</select></td></tr>");
}

function gethtmlprefs ( )
{
   global $default;

   $sql = new Owl_DB;
   $sql->query("select * from $default->owl_html_table");
   $sql->next_record();

   // styles sheet
   // this is an absolute URL and not a filesystem reference

   $default->styles                = "$default->owl_graphics_url/$default->sButtonStyle/styles.css";
                                                                                                                                                                                                    
   $default->table_expand_width    = $sql->f("table_expand_width");
   $default->table_collapse_width  = $sql->f("table_collapse_width");
   $default->body_background       = $sql->f("body_background");
   $default->owl_logo              = $sql->f("owl_logo");
   $default->body_textcolor        = $sql->f("body_textcolor");
   $default->body_link             = $sql->f("body_link");
   $default->body_vlink            = $sql->f("body_vlink");
   $default->table_header_height   = 40;
};

function fPrintNavBar($parent, $message = "", $fileid = 0, $nextfolders = 0, $inextfiles = 0, $bDisplayFiles = 0, $iFileCount = 0, $iCurrentPage = 0)
{
   global $default, $sess, $expand, $order, $sortorder, $sort, $language, $owl_lang;

   print("<table class=\"margin2\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\"><tr><td align=\"left\" valign=\"top\">\n");
   print("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
   print("\t<tr>\n");
   print("\t\t<td class=\"dir1\" id=\"ldir1\" width=\"100%\">$owl_lang->current_folder ");

   if ( 0 < strlen($message))
   {
      print("<b>".$message."</b>");
   }

   if ( $fileid > 0 )
   {
      print gen_navbar($parent, $fileid);
   }
   else
   {
      print gen_navbar($parent);
   }
}

function fPrintAdminButton($sHref, $sBtn_name, $sequence = 0, $type = "ui_icons")
{
 global $default, $language, $owl_lang; 

   if ($language == "")
   {
      $language = $default->owl_lang;
   }
      
   $sAltstring = 'alt_' . $sBtn_name;
   if ($sequence > 0)
   {
      $sImageName = $sBtn_name . "_" . $sequence;
   }
   else
   {
      $sImageName = $sBtn_name;
   }
   print("<a href=\"$sHref\" " . ' onmouseout="MM_swapImgRestore()" onmouseover="' . "MM_swapImage('$sImageName','','$default->owl_graphics_url/$default->sButtonStyle/$type/" . $sBtn_name . "_hover.gif',1)" .'"' .">");
   print("<img src=\"$default->owl_graphics_url/$default->sButtonStyle/$type/$sBtn_name.gif\" alt=\"" . $owl_lang->{$sAltstring} ."\" title=\"". $owl_lang->{$sAltstring} ."\" border=\"0\" name=\"$sImageName\"></img></a>\n");

}

function fPrintSubmitButton($value, $alt, $type = "submit", $name = "", $confirm_text = "")
{
   global $owl_lang;

   print("<input class=\"fbuttonup1\" ");
   if(!empty($name))
   {
      print("name=\"$name\" ");
   }
   print("type=\"$type\" value=\"$value\" alt=\"$alt\" title=\"$alt\" onmouseover=\"highlightButton('fbuttondown1')\" onmouseout=\"highlightButton('fbuttonup1')\"");

   if(!empty($confirm_text))
   { 
      print(" onclick=\"return confirm('$owl_lang->reallydelete_selected ?');\"");
   }

   print("></input>");

}


function fPrintButton($sHref, $sBtn_name, $sequence = 0, $type = "ui_buttons")
{
   global $default, $language, $owl_lang;

   if ($language == "")
   {
      $language = $default->owl_lang;
   }

   $sAltstring = 'alt_' . $sBtn_name;
   $sButtonString = $sBtn_name;

   if ($sequence > 0)
   {
      $sImageName = $sBtn_name . "_" . $sequence;
   }
   else
   {
      $sImageName = $sBtn_name;
   }
   print("\t\t<td class=\"button1\">");
   print("<a class=\"lbutton1\" href=\"$sHref\" title=\"". $owl_lang->{$sAltstring} ."\">&nbsp;" . $owl_lang->{$sButtonString} ."&nbsp;</a>");
   print("</td>\n");
}


//function fPrintButtonSpace ($height = 1, $width = 1) 
function fPrintButtonSpace ($height = 1, $width = 1) 
{
  global $default;
  global $owl_lang;
  print("<img src=\"$default->owl_graphics_url/$default->sButtonStyle/ui_misc/x_clear.gif\" height=\"$height\" width=\"$width\" alt=\"\"></img>");
}


function fPrintPrefs ( $class = "infobar1", $location = "bottom") 
{
   global $default, $language, $userid, $parent;
   global $sess, $expand, $sort, $sortorder, $order, $owl_lang, $action, $type;
  

   $lastlogin =  fGetLastLogin();
 
   $urlArgs = array();
   $urlArgs['sess']      = $sess;
   $urlArgs['parent']    = $parent;
   $urlArgs['expand']    = $expand;
   $urlArgs['order']     = $order;
   $urlArgs['owluser']   = $userid;
   $urlArgs[$sortorder] = $sort;

   $sUrl = fGetURL($default->owl_root_url . '/prefs.php', $urlArgs);

   print("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
   print("\t<tr>");
   if (isset($userid))
   {
      print("<td class=\"$class\" width=\"100%\"><b>$owl_lang->user:</b>&nbsp;" . uid_to_uname($userid));
      fPrintButtonSpace(1, 12);
      print("<b>$owl_lang->full_name:</b>&nbsp;" . uid_to_name($userid) );
      fPrintButtonSpace(1, 12);
      print("<b>$owl_lang->last_logged</b>&nbsp;". date($owl_lang->localized_date_format , strtotime($lastlogin)));
      fPrintButtonSpace(1, 12);
      print("<b>$owl_lang->current_db</b>&nbsp;". $default->owl_db_display_name[$default->owl_current_db] . "<br></br></td>\n");
   }
   else
   {
      print("\t\t<td class=\"$class\" width=\"100%\">&nbsp;");
      fPrintButtonSpace(1, 12);
      fPrintButtonSpace(1, 12);
      print("</td>\n");
   }

   
   if (fIsAdmin(true) and isset($userid))
   {
      fPrintButton("$default->owl_root_url/admin/index.php?sess=$sess", "btn_admin");
   }

   if (fIsNewsAdmin($userid) and isset($userid))
   {
      fPrintButton("$default->owl_root_url/admin/news.php?sess=$sess", "btn_admin_news");
   }

   if (prefaccess($userid) and isset($userid))
   {
      print("\t\t<td class=\"button1\">");
      print("<a class=\"lbutton1\" href=\"$sUrl\" title=\"$owl_lang->title_edit_prefs\">");
      print("&nbsp;$owl_lang->preference&nbsp;</a>");
      print("</td>\n");
    }

   if (isset($userid))
   {
      if (!$sess == "0")
      {
         fPrintButton("$default->owl_root_url/index.php?login=logout&amp;sess=$sess", "btn_logout");
      }
      else
      {
         fPrintButton("$default->owl_root_url/index.php?login=1", "btn_login");
      }
   }

   if(fIsEmailToolAccess($userid))
   {
      fPrintButton("$default->owl_root_url/mtool.php?sess=$sess&amp;parent=$parent&amp;expand=$expand&amp;order=$order&amp;$sortorder=$sortname", "btn_mail_tool");
   }

   if ($location == "bottom")
   {
      print("\t\t<td class=\"button1\">");
      print("<a class=\"lbutton1\" href=\"#top\" title=\"$owl_lang->alt_go_top\">");
      print("&nbsp;$owl_lang->btn_go_top&nbsp;</a>");
      print("</td>\n");
   }
   else
   {
      print("\t\t<td class=\"button1\">");
      print("<a class=\"lbutton1\" href=\"#bottom\" title=\"$owl_lang->alt_go_bottom\">");
      print("&nbsp;$owl_lang->btn_go_bottom&nbsp;</a>");
      print("</td>\n");
   }

   if (! ereg("help_", basename($_SERVER["PHP_SELF"])))
   {
      if (ereg("admin", $_SERVER["PHP_SELF"]))
      {
         $HelpDirectory = "help/admin";
         fPrintButton("../locale/$default->owl_lang/$HelpDirectory/help_". basename($_SERVER["PHP_SELF"]) . "?sess=$sess&amp;parent=$parent&amp;expand=$expand&amp;order=$order&amp;$sortorder=$sortname" , "btn_help");
      }
      else
      {
         $HelpDirectory = "help";
         if (isset($action))
         {
            $topic = "&amp;action=$action";
         }
         if (isset($type))
         {
            $topic .= "&amp;type=$type";
         }
         fPrintButton("locale/$default->owl_lang/$HelpDirectory/help_". basename($_SERVER["PHP_SELF"]) . "?sess=$sess&amp;parent=$parent&amp;expand=$expand&amp;order=$order&amp;$sortorder=$sortname$topic" , "btn_help");
      }
   }

   if (isset($userid) and  $_SERVER["PHP_SELF"] != $default->owl_root_url . "/browse.php" )
   { 
      if (empty($expand))
      {
         $expand = $default->expand;
      }
      if (empty($order))
      {
         $order = $default->default_sort_column; 
      }
      fPrintButton($default->owl_root_url . "/browse.php?sess=$sess&amp;parent=$parent&amp;expand=$expand&amp;order=$order&amp;$sortorder=$sortname", "btn_browse");
   }
   if (ereg("help_", basename($_SERVER["PHP_SELF"])))
   {
       print("<td class=\"button1\">");
       print("<input class=\"fbuttonup1\" type=\"submit\" value=\"$owl_lang->btn_back\" alt=\"$owl_lang->alt_back\" title=\"$owl_lang->alt_back\" onclick=\"history.back();\" onmouseover=\"highlightButton('fbuttondown1')\" onmouseout=\"highlightButton('fbuttonup1')\"></input>");
      //print("<a class='lbutton1' href='#' title='$owl_lang->alt_back' onclick='history.back(1)'>$owl_lang->btn_back</a>");
       print("</td>\n");
   }

   print("\t</tr>\n");
   print("</table>\n");
}


function fDisplayPolicy ($parent)
{
   global $default;
   global $owl_lang;
   $sql = new Owl_DB; 

   $sql->query("select security from $default->owl_folders_table where id = '$parent'");
   $sql->next_record();

   switch ($sql->f("security"))
   {
      case "50":
         $sPolicy = "$owl_lang->geveryoneread";
         break;
      case "51":
         $sPolicy = "$owl_lang->geveryonewrite";
         break;
      case "52":
         $sPolicy = "$owl_lang->ggroupread";
         break;
      case "53":
         $sPolicy = "$owl_lang->ggroupwrite";
         break;
      case "54":
         $sPolicy = "$owl_lang->gonlyyou";
         break;
      case "55":
         $sPolicy = "$owl_lang->ggroupwrite_nod";
         break;
      case "56":
         $sPolicy = "$owl_lang->geveryonewrite_nod";
         break;
      case "57":
         $sPolicy = "$owl_lang->ggroupwrite_worldread";
         break;
      case "58":
         $sPolicy = "$owl_lang->ggroupwrite_worldread_nod";
         break;
      default:
         $sPolicy = "";
         break;
   }

return $sPolicy;
   
}

function gen_navbar($nav_parent , $fileid = 0 , $movenav = 0) 
{
   global $default;
   global $sess, $expand, $sort, $sortorder, $order, $owl_lang, $userid, $usergroupid, $action, $moreFolder, $id, $parent, $language;
 

   $urlArgs = array();
   $urlArgs['sess']      = $sess;
   $urlArgs['parent']    = $parent;
   $urlArgs['expand']    = $expand;
   $urlArgs['order']     = $order;
   $urlArgs[$sortorder] = $sort;

   $name = fid_to_name($nav_parent);

   if ($movenav == 0)
   {
      $urlArgs2 = $urlArgs;
      $urlArgs2['parent'] = $nav_parent;
      $sUrl = fGetURL ('browse.php', $urlArgs2);

      $navbar .= "<a class=\"lfile1\" href=\"$sUrl\" title=\"$owl_lang->title_return_folder $name\">$name</a>";
   }
   else
   {

      $urlArgs2 = $urlArgs;
      if ( $parent == 0 )
      {
         $parent = $default->HomeDir;
         $urlArgs2['parent']     = $parent;
      }
      $urlArgs2['action']     = $action;
      $urlArgs2['id']     = $id;
      $urlArgs2['moreFolder'] = $nav_parent;
      $sUrl = fGetURL ('browse.php', $urlArgs2);

      $navbar .= "<a class=\"lfile1\" href=\"$sUrl\" title=\"$owl_lang->title_return_folder $name\">$name</a>";
   }

   $new = $nav_parent;
   while ($new != "$default->HomeDir") 
   {
      $sql = new Owl_DB; $sql->query("select parent from $default->owl_folders_table where id = '$new'");
      while($sql->next_record()) 
      {
         $newparentid = $sql->f("parent");
      }
      $name = fid_to_name($newparentid);
      if ($movenav == 0)
      {
         $urlArgs2 = $urlArgs;
         $urlArgs2['parent'] = $newparentid;
         $sUrl = fGetURL ('browse.php', $urlArgs2);

         $navbar = "<a class=\"lfile1\" href=\"$sUrl\" title=\"$owl_lang->title_return_folder $name\">$name</a>/" . $navbar;
      }
      else
      {
         $urlArgs2 = $urlArgs;
         $urlArgs2['moreFolder']= $newparentid;
         $urlArgs2['action']     = $action;
         $urlArgs2['id']= $id;
         $sUrl = fGetURL ('move.php', $urlArgs2);

         $navbar = "<a class=\"lfile1\" href=\"$sUrl\" title=\"$owl_lang->title_return_folder $name\">$name</a>/" . $navbar;
      }
      $new = $newparentid;
   }

   $iCurrentParent =  owlfolderparent($nav_parent);
   if ( $fileid <> "0"  )
   {
      $navbar .= "/" . fid_to_filename($fileid);
   }
   if ($movenav == 0)
   {
      //$navbar .= "<br></br></a></td>\n";
      $navbar .= "<br></br></td>\n";
      $navbar .= "\t</tr>\n";
      $navbar .= "</table>\n";
      $navbar .= "</td></tr></table>\n";



      $navbar .= "<table class=\"margin2\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\"><tr><td align=\"left\" valign=\"top\">\n";
      $navbar .= "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n";
      $navbar .= "\t<tr>\n";
      $navbar .= "\t<td class=\"policy1\" id=\"lpolicy1\" width=\"100%\"><b>$owl_lang->folder_policy</b>&nbsp;";


   }

   if (owlusergroup($userid) == 0 || owlusergroup($userid) == $default->file_admin_group)
   {
      $navbar .= "<a href=\"modify.php?sess=$sess&amp;action=folder_modify&amp;id=$nav_parent&amp;parent=$iCurrentParent&amp;expand=$expand&amp;order=$order&amp;$sortorder=$sort\" title=\"$owl_lang->alt_mod_folder\">";
      if ($movenav == 0)
      {
        $navbar .= fDisplayPolicy($nav_parent);
      }
      $navbar .= "<br></br></a></td>\n";
      $navbar .= "\t</tr>\n";
      $navbar .= "</table>\n";
      $navbar .= "</td></tr></table>\n";
   }
   else
   {
      if (check_auth($nav_parent, "folder_property", $userid) == 1 and $nav_parent != $default->HomeDir)
      {
      
         $urlArgs2 = $urlArgs;
         $urlArgs2['parent'] = $iCurrentParent;
         $urlArgs2['action'] = 'folder_modify';
         $urlArgs2['id'] = $nav_parent;
         $url = fGetURL ('modify.php', $urlArgs2);

         $navbar .= "<a href=\"$url\" title=\"$owl_lang->alt_mod_folder\">";
         if ($movenav == 0)
         {
           $navbar .= fDisplayPolicy($nav_parent);
         }
         $navbar .= "<br></br></a></td>\n";
         $navbar .= "\t</tr>\n";
         $navbar .= "</table>\n";
         $navbar .= "</td></tr></table>\n";
      }
      else
      {
         if ($movenav == 0)
         {
           $navbar .= fDisplayPolicy($nav_parent);
         }
         $navbar .= "</td>\n";
         $navbar .= "\t</tr>\n";
         $navbar .= "</table>\n";
         $navbar .= "</td></tr></table>\n";
      }
   }
   return $navbar;
}

//
// functions to create/show the links to be sorted on
//
function show_link($column,$sortname,$sortvalue,$order,$sess,$expand,$parent,$title) 
{
   global $default, $type, $owl_lang;
   
  // print("$sortname --- $sortvalue ");
   

   $urlArgs = array();
   $urlArgs['sess']      = $sess;
   $urlArgs['parent']    = $parent;
   $urlArgs['expand']    = $expand;
   $urlArgs['order']     = $order;
   $urlArgs[$sortname] = $sortvalue;

   $self = $_SERVER["PHP_SELF"]; 
   if ($sortvalue == "ASC")
   {
      $urlArgs2 = $urlArgs;
      $urlArgs2['type']     = $type;
      $urlArgs2['order']    = $column;
      $urlArgs2[$sortname] = 'DESC';
      $sUrl = fGetURL ($self, $urlArgs2);


      print("\t\t\t\t<td class=\"title1\" ");
      if ($title == $owl_lang->title or $title == $owl_lang->file )
      {
            print("width=\"50%\"");
      }
      print("><a class=\"ltitle1\" href=\"$sUrl\" style=\"toplink\" title=\"$owl_lang->title_sort\">$title");

      if ($order == $column)
      {
         print("</a>&nbsp;<img border=\"0\" src=\"$default->owl_graphics_url/$default->sButtonStyle/ui_nav/asc.gif\" alt=\"\"></img><br></br></td>\n");
      }
      else
      {
         print("<br></br></a></td>\n");
      }
   }
   else
   {
      $urlArgs2 = $urlArgs;
      $urlArgs2['type']     = $type;
      $urlArgs2['order']     = $column;
      $urlArgs2[$sortname] = 'ASC';
      $sUrl = fGetURL ($self, $urlArgs2);

      print("\t\t\t\t<td class=\"title1\" ");
      if ($title == $owl_lang->title or $title == $owl_lang->file)
      {
         print("width=\"50%\"");
      }
      print("><a class=\"ltitle1\" href=\"$sUrl\" style=\"toplink\" title=\"$owl_lang->title_sort\">$title");
      if ($order == $column)
      {
         print("</a>&nbsp;<img border=\"0\" src=\"$default->owl_graphics_url/$default->sButtonStyle/ui_nav/desc.gif\" alt=\"\"></img><br></br></td>\n");
      }
      else
      {
         print("<br></br></a></td>\n");
      }
   }
}

function fSetupFolderActionMenus($query)
{
   global $default;
   global $parent, $sess, $expand, $order, $sortorder ,$sortname, $userid;
   global $owl_lang, $mid;

   $sql = new Owl_DB; 
   $setmenu = new Owl_DB; 
   $setmenu->query($query);
   $aFolderMenuString = array();

   $urlArgs = array();
   $urlArgs['sess']      = $sess;
   $urlArgs['parent']    = $parent;
   $urlArgs['expand']    = $expand;
   $urlArgs['order']     = $order;
   $urlArgs[${sortorder}]  = $sort;


   // *****************************************
   // Display the Delete Icons For the Folders
   // *****************************************

   while ($setmenu->next_record())
   {
      $foldername = $setmenu->f("name");
      $fid     = $setmenu->f("id");

      $aFolderMenuString["folder_name"] = ".|$foldername|#|$owl_lang->menu_folder_action||\n";

      if (check_auth($setmenu->f("id"), "folder_delete", $userid, false, false) == 1)
      {
         $urlArgs2 = $urlArgs;
         $urlArgs2['id'] = $setmenu->f("id");
         $urlArgs2['action'] = 'folder_delete';
         $url = fGetURL ('dbmodify.php', $urlArgs2);
         $url .= "\" onclick=\"return confirm('$owl_lang->reallydelete ". $setmenu->f("name") ."?');\"";
         //$url .= "\" onclick=\"return confirm('$owl_lang->reallydelete " .htmlspecialchars($setmenu->f("name"), ENT_QUOTES) ."?');";
 
         $aFolderMenuString["folder_delete"] = "..|$owl_lang->alt_del_folder|$url|$owl_lang->alt_del_folder|trash.gif\n";
 
      }

      // *****************************************
      // Display the Property Icons For the Folders
      // *****************************************
 
      if (check_auth($setmenu->f("id"), "folder_property", $userid, false, false) == 1)
      {
         $urlArgs2 = $urlArgs;
         $urlArgs2['id'] = $setmenu->f("id");
         $urlArgs2['action'] = 'folder_modify';
         $url = fGetURL ('modify.php', $urlArgs2);
         $aFolderMenuString["folder_edit"] = "..|$owl_lang->alt_mod_folder|$url|$owl_lang->alt_mod_folder|edit.gif\n";
 
      }
 
      // *****************************************
      // Display the move Icons For the Folders
      // *****************************************
 
      if (check_auth($setmenu->f("id"), "folder_modify", $userid, false, false) == 1 and check_auth($setmenu->f("id"), "folder_delete", $userid, false, false) == 1)
      {
          $urlArgs2 = $urlArgs;
          $urlArgs2['id'] = $setmenu->f("id");
          $urlArgs2['action'] = 'cp_folder';
          $urlArgs2['parent'] = $parent;
          $url = fGetURL ('move.php', $urlArgs2);
 
          $aFolderMenuString["folder_copy"] = "..|$owl_lang->alt_copy_folder|$url|$owl_lang->alt_copy_folder|copy.gif\n";
 
          $urlArgs2 = $urlArgs;
          $urlArgs2['id'] = $setmenu->f("id");
          $urlArgs2['action'] = 'folder';
          $urlArgs2['parent'] = $parent;
          $url = fGetURL ('move.php', $urlArgs2);
          $aFolderMenuString["folder_move"] = "..|$owl_lang->alt_move_folder|$url|$owl_lang->alt_move_folder|move.gif\n";


      }
 

      if (check_auth($setmenu->f("id"), "folder_view", $userid, false, false) == 1)
      {
         $folder_id = $setmenu->f("id");
         $checksql = new Owl_DB;
         $checksql->query("select * from $default->owl_monitored_folder_table where fid = '$folder_id' and userid = '$userid'");
         $checknumrows = $checksql->num_rows($checksql);
 
         $checksql->query("SELECT * from $default->owl_users_table where id = '$userid'");
         $checksql->next_record();
         if (trim($checksql->f("email")) != "")
         {
            if ($checknumrows == 0)
            {
               $urlArgs2 = $urlArgs;
               $urlArgs2['id'] = $folder_id;
               $urlArgs2['parent'] = $parent;
               $urlArgs2['action'] = 'folder_monitor';
               $url = fGetURL ('dbmodify.php', $urlArgs2);
               $aFolderMenuString["folder_monitor"] = "..|$owl_lang->alt_monitor|$url|$owl_lang->alt_monitor|monitor.gif\n";
            } 
            else
            {
               $urlArgs2 = $urlArgs;
               $urlArgs2['id'] = $folder_id;
               $urlArgs2['parent'] = $parent;
               $urlArgs2['action'] = 'folder_monitor';
               $url = fGetURL ('dbmodify.php', $urlArgs2);
               $aFolderMenuString["folder_monitor"] = "..|$owl_lang->alt_monitored|$url|$owl_lang->alt_monitored|monitored.gif\n";
            } 
         } 
      } 

      if (check_auth($setmenu->f("id"), "folder_view", $userid, false, false) == 1)
      {
         $urlArgs2 = array();
         $urlArgs2['sess']   = $sess;
         $urlArgs2['id']     = $setmenu->f("id");
         $urlArgs2['parent'] = $setmenu->f("parent");
         $urlArgs2['action'] = 'folder';
         $urlArgs2['binary'] = 1;
         $urlArgs2['expand']    = $expand;
         $urlArgs2['order']     = $order;
         $urlArgs2['sortorder'] = $sort;
         $url = fGetURL ('download.php', $urlArgs2);
 
         if (file_exists($default->tar_path) && trim($default->tar_path) != "" && file_exists($default->gzip_path) && trim($default->gzip_path) != "")
         {
            $aFolderMenuString["folder_download"]= "..|$owl_lang->alt_get_folder|$url|$owl_lang->alt_get_folder|zip.gif\n";
         }
      } 


      $menustring = $aFolderMenuString["folder_name"];

      foreach ($default->FolderMenuOrder as $key) 
      {
         $menustring .= $aFolderMenuString[$key];
      }

      $mid->setMenuStructureString($menustring);
      $mid->parseStructureForMenu('vermenuf'.$fid);
      $mid->newVerticalMenu('vermenuf'.$fid);
   }
   return;
}

function fSetupFileActionMenus($query)
{
   global $default;
   global $parent, $sess, $expand, $order, $sortorder ,$sortname, $userid;
   global $owl_lang, $mid, $url;

   $aFileMenuString = array();
   $sql = new Owl_DB; 
   $setmenu = new Owl_DB; 
   $setmenu->query($query);

   $urlArgs = array();
   $urlArgs['sess']      = $sess;
   $urlArgs['parent']    = $parent;
   $urlArgs['expand']    = $expand;
   $urlArgs['order']     = $order;
   $urlArgs['sortname']  = $sortname;

   $self = $_SERVER["PHP_SELF"];

   while ($setmenu->next_record())
   {
      $fid = $setmenu->f("id");
      $filename = $setmenu->f("filename");
      $checked_out = $setmenu->f("checked_out");
      $url = $setmenu->f("url");
      $allicons = $default->owl_version_control;
      $backup_parent = $setmenu->f("parent");

      if ( $url == "1" )
      {
         $aFileMenuString["file_name"] = ".|$filename|$filename|$owl_lang->menu_url_action||1\n";
      }
      else
      {
         $urlArgs2 = $urlArgs;
         $urlArgs2['binary'] = 1;
         $urlArgs2['id'] = $fid;
         $urlArgs2['parent'] = $backup_parent;
         $sUrl = fGetURL ('download.php', $urlArgs2);
         $aFileMenuString["file_name"] = ".|$filename|$sUrl|$owl_lang->menu_file_action||\n";
      }

      $isBackup = fid_to_name($backup_parent);
      // check to see if the file is checked out
      // to display a the lock or unlock Icon.
   
      $iCheckedOut = $checked_out;
   
      $aFileAccess = check_auth($fid, "file_all", $userid, false, false);
      $bFileModify = $aFileAccess["file_modify"];
      $bFileDownload = $aFileAccess["file_download"];
      $bFileDelete	= $aFileAccess["file_delete"];
   
   
      $bCheckOK = false;
      if (($checked_out == 0) || ($checked_out == $userid) || owlusergroup($userid) == 0 ||  owlusergroup($userid) == $default->file_admin_group) 
      { 
         $bCheckOK = true; 
      }
   
                                                                                                                                                                                                      
      if ($allicons == 1)
      {
         if ($url == "0") 
         {
            $urlArgs2 = $urlArgs;
            $urlArgs2['id'] = $fid;
            $urlArgs2['filename'] = $filename;
            $urlArgs2['parent'] = $backup_parent;
            $sUrl = fGetURL ('log.php', $urlArgs2);
            $aFileMenuString["file_log"] = "..|$owl_lang->alt_log_file|$sUrl|$owl_lang->alt_log_file Log|log.gif\n";
         } 
      }
   
      // *****************************************************************************
      // Don't Show the delete icon if the user doesn't have delete access to the file
      // *****************************************************************************
   
      if($bFileDelete == 1)
      {
         if ($url == "1")
         {
            if ($bCheckOK) 
            {
               $urlArgs2 = $urlArgs;
               $urlArgs2['action'] = 'file_delete';
               $urlArgs2['type']   = 'url';
               $urlArgs2['id']     = $fid;
               $urlArgs2['parent'] = $backup_parent;
               if($self == $default->owl_root_url . "/log.php")
               {
                  $urlArgs2['self'] = 'log';
               }
               $sUrl = fGetURL ('dbmodify.php', $urlArgs2);
               $sUrl .= "\" onclick=\"return confirm('$owl_lang->reallydelete ". $filename ."?');\"";
               $aFileMenuString["file_delete"] = "..|$owl_lang->alt_del_file|$sUrl|$owl_lang->alt_del_file Log|trash.gif\n";
   
   
            } 
         }
         else
         {
            if ($bCheckOK) 
            { 
               $urlArgs2 = $urlArgs;
               $urlArgs2['action'] = 'file_delete';
               $urlArgs2['id']     = $fid;
               $urlArgs2['parent'] = $backup_parent;
               if($self == $default->owl_root_url . "/log.php")
               {
                  $urlArgs2['self'] = 'log';
               }
               $sUrl = fGetURL ('dbmodify.php', $urlArgs2);
               $sUrl .= "\" onclick=\"return confirm('$owl_lang->reallydelete " .$filename ."?');\"";
               $aFileMenuString["file_delete"] = "..|$owl_lang->alt_del_file|$sUrl|$owl_lang->alt_del_file Log|trash.gif\n";
   
            } 
         }
      }
   
      // *****************************************************************************
      // Don't Show the modify icon if the user doesn't have modify access to the file
      // *****************************************************************************
      
      if($bFileModify == 1 && !$is_backup_folder) 
      {
         if ($bCheckOK) 
         {
            $urlArgs2 = $urlArgs;
            $urlArgs2['action'] = 'file_modify';
            $urlArgs2['id'] = $fid;
            $urlArgs2['parent'] = $backup_parent;
            $sUrl = fGetURL ('modify.php', $urlArgs2);
            $aFileMenuString["file_edit"] = "..|$owl_lang->alt_mod_file|$sUrl|$owl_lang->alt_mod_file|edit.gif\n";
   
         } 
      }
       // *****************************************************************************
      // Don't Show the link icon if the user doesn't have move access to the file
      // *****************************************************************************
   

     $Realid = fGetPhysicalFileId($fid);
                                                                                                                                                                                                    
      if ($bFileModify == 1 && !$is_backup_folder and $Realid == $fid)
      {
         if (($default->hide_backup == 1 && $self != $default->owl_root_url . "/log.php")  || $isBackup != "backup" || $default->hide_backup != 1)
         {
            if ($bCheckOK)
            {
               $urlArgs2 = $urlArgs;
               $urlArgs2['action'] = 'lnk_file';
               $urlArgs2['id'] = $fid;
               $urlArgs2['parent'] = $backup_parent;
               $sUrl = fGetURL ('move.php', $urlArgs2);
               $aFileMenuString["file_link"] = "..|$owl_lang->alt_link_file|$sUrl|$owl_lang->alt_link_file|link.gif\n";
            }
         }
      }
   
   
      // *****************************************************************************
      // Don't Show the copy icon if the user doesn't have move access to the file
      // *****************************************************************************
   
      if ($bFileModify == 1 && !$is_backup_folder)
      {
         if (($default->hide_backup == 1 && $self != $default->owl_root_url . "/log.php")  || $isBackup != "backup" || $default->hide_backup != 1)
         {
            if ($url == "1")
            {
               if ($bCheckOK) 
               {
                  $urlArgs2 = $urlArgs;
                  $urlArgs2['action'] = 'cp_file';
                  $urlArgs2['id'] = $fid;
                  $urlArgs2['parent'] = $backup_parent;
                  $urlArgs2['type'] = 'url';
                  $sUrl = fGetURL ('move.php', $urlArgs2);
                  $aFileMenuString["file_copy"] = "..|$owl_lang->alt_copy_file|$sUrl|$owl_lang->alt_copy_file|copy.gif\n";
               }  
            }
            else
            {
               if ($bCheckOK) 
               {
                  $urlArgs2 = $urlArgs;
                  $urlArgs2['action'] = 'cp_file';
                  $urlArgs2['id'] = $fid;
                  $urlArgs2['parent'] = $backup_parent;
                  $sUrl = fGetURL ('move.php', $urlArgs2);
                  $aFileMenuString["file_copy"] = "..|$owl_lang->alt_copy_file|$sUrl|$owl_lang->alt_copy_file|copy.gif\n";
   
               } 
            }
         }
      }
   
      // *****************************************************************************
      // Don't Show the move modify icon if the user doesn't have move access to the file
      // *****************************************************************************
   
      if ($bFileModify == 1 && !$is_backup_folder)
      {
         if (($default->hide_backup == 1 && $self != $default->owl_root_url . "/log.php")  || $isBackup != "backup" || $default->hide_backup != 1)
         {
            if ($url == "1")
            {
               if ($bCheckOK) 
               {
                  $urlArgs2 = $urlArgs;
                  $urlArgs2['action'] = 'file';
                  $urlArgs2['id'] = $fid;
                  $urlArgs2['parent'] = $backup_parent;
                  $urlArgs2['type'] = 'url';
                  $sUrl = fGetURL ('move.php', $urlArgs2);
                  $aFileMenuString["file_move"] = "..|$owl_lang->alt_move_file|$sUrl|$owl_lang->alt_move_file|move.gif\n";
   
               }  
            }
            else
            {
               if ($bCheckOK) 
               {
                  $urlArgs2 = $urlArgs;
                  $urlArgs2['action'] = 'file';
                  $urlArgs2['id'] = $fid;
                  $urlArgs2['parent'] = $backup_parent;
                  $sUrl = fGetURL ('move.php', $urlArgs2);
                  $aFileMenuString["file_move"] = "..|$owl_lang->alt_move_file|$sUrl|$owl_lang->alt_move_file|move.gif\n";
   
               } 
            }
         }
      }
   
   
      // *****************************************************************************
      // Don't Show the file update icon if the user doesn't have update access to the file
      // *****************************************************************************
   
      if($bFileModify == 1 && !$is_backup_folder and $Realid == $fid)
      {
         if (($default->hide_backup == 1 && $self != $default->owl_root_url . "/log.php")  || $isBackup != "backup" || $default->hide_backup != 1)
         {
            if ($url != "1")
            {
               if ($bCheckOK) 
               {
                  $urlArgs2 = $urlArgs;
                  $urlArgs2['action'] = 'file_update';
                  $urlArgs2['id'] = $fid;
                  $urlArgs2['parent'] = $backup_parent;
                  $sUrl = fGetURL ('modify.php', $urlArgs2);
                  $aFileMenuString["file_update"] = "..|$owl_lang->alt_upd_file|$sUrl|$owl_lang->alt_upd_file|update.gif\n";
   
               } 
            }
         }
      }
      // *****************************************************************************
      // Don't Show the file dowload icon if the user doesn't have download access to the file
      // *****************************************************************************
      
      if($bFileDownload == 1)
      {
         if ($url != "1")
         {
            $urlArgs2 = $urlArgs;
            $urlArgs2['binary'] = 1;
            $urlArgs2['id'] = $fid;
            $urlArgs2['parent'] = $backup_parent;
            $sUrl = fGetURL ('download.php', $urlArgs2);
            $aFileMenuString["file_download"] = "..|$owl_lang->alt_get_file|$sUrl|$owl_lang->alt_get_file|bin.gif\n";
   
         }
      }
   
      // *****************************************************************************
      // Don't Show the comment icon if the user doesn't have download access to the file
      // *****************************************************************************
   
      if($bFileDownload == 1 && !$is_backup_folder) 
      {
         $sql = new Owl_DB;
         $sql->query("SELECT * from $default->owl_comment_table where fid = '$fid'");
         if($sql->num_rows() == 0) 
         {
            $urlArgs2 = $urlArgs;
            $urlArgs2['action'] = 'file_comment';
            $urlArgs2['id'] = $fid;
            $urlArgs2['parent'] = $backup_parent;
            $sUrl = fGetURL ('modify.php', $urlArgs2);
            $aFileMenuString["file_comment"] =  "..|$owl_lang->alt_add_comments|$sUrl|$owl_lang->alt_add_comments|comment_dis.gif\n";
         } 
         else 
         { 
            $urlArgs2 = $urlArgs;
            $urlArgs2['action'] = 'file_comment';
            $urlArgs2['id'] = $fid;
            $urlArgs2['parent'] = $backup_parent;
            $sUrl = fGetURL ('modify.php', $urlArgs2);
            $aFileMenuString["file_comment"] =  "..|$owl_lang->alt_view_comments|$sUrl|$owl_lang->alt_view_comments|comment.gif\n";
         }
      }

      if ($allicons == 1)
      {
         // *****************************************************************************
         // Don't Show the lock icon if the user doesn't have access to the file
         // *****************************************************************************
         if($bFileModify == 1 && !$is_backup_folder and $Realid == $fid)
         {
            if ($url != "1")
            {
               if ($bCheckOK) 
               {
                  if ($iCheckedOut <> 0) 
                  {
                     $urlArgs2 = $urlArgs;
                     $urlArgs2['action'] = 'file_lock';
                     $urlArgs2['id'] = $fid;
                     $urlArgs2['parent'] = $backup_parent;
                     $sUrl = fGetURL ('dbmodify.php', $urlArgs2);
                     $aFileMenuString["file_lock"] =  "..|$owl_lang->alt_unlock_file|$sUrl|$owl_lang->alt_unlock_file|unlock.gif\n";
   
                  } 
                  else 
                  {
                     $urlArgs2 = $urlArgs;
                     $urlArgs2['action'] = 'file_lock';
                     $urlArgs2['id'] = $fid;
                     $urlArgs2['parent'] = $backup_parent;
                     $sUrl = fGetURL ('dbmodify.php', $urlArgs2);
                     $aFileMenuString["file_lock"] =  "..|$owl_lang->alt_lock_file|$sUrl|$owl_lang->alt_lock_file|lock.gif\n";
   
                  }
               } 
            }
         }
      }

      // *****************************************************************************
      // Don't Show the email icon if the user doesn't have access to email the file
      // *****************************************************************************

      if($bFileDownload == 1 && !$is_backup_folder)
      {
         if ($url == "1") 
         {
            //if ($default->owl_version_control == 1) 
            //{
            //}
            $urlArgs2 = $urlArgs;
            $urlArgs2['action'] = 'file_email';
            $urlArgs2['type']   = 'url';
            $urlArgs2['id'] = $fid;
            $urlArgs2['parent'] = $backup_parent;
            $sUrl = fGetURL ('modify.php', $urlArgs2);
            $aFileMenuString["file_email"] =  "..|$owl_lang->alt_email|$sUrl|$owl_lang->alt_email|email.gif\n";

         } 
         else 
         {
            $urlArgs2 = $urlArgs;
            $urlArgs2['action'] = 'file_email';
            $urlArgs2['id'] = $fid;
            $urlArgs2['parent'] = $backup_parent;
            $sUrl = fGetURL ('modify.php', $urlArgs2);
            $aFileMenuString["file_email"] =  "..|$owl_lang->alt_email|$sUrl|$owl_lang->alt_email|email.gif\n";

         }
      }

      // *****************************************************************************
      // Don't Show the toggle monitor this file  icon if the user doesn't have access 
      // *****************************************************************************

      if($bFileDownload == 1)
      {
         $sql = new Owl_DB;
         $sql->query("SELECT * from $default->owl_users_table where id = '$userid'");
         $sql->next_record();
         $TestEmail = $sql->f("email");
         if ($url != "1") 
         {
            if (trim($TestEmail) != "") 
            {
               $sql->query("select * from $default->owl_monitored_file_table where fid = '$fid' and userid = '$userid'");
               if ($sql->num_rows($sql) == 0) 
               {
                  $urlArgs2 = $urlArgs;
                  $urlArgs2['action'] = 'file_monitor';
                  $urlArgs2['id'] = $fid;
                  $urlArgs2['parent'] = $backup_parent;
                  $sUrl = fGetURL ('dbmodify.php', $urlArgs2);
                  $aFileMenuString["file_monitor"] = "..|$owl_lang->alt_monitor|$sUrl|$owl_lang->alt_monitor|monitor.gif\n";

               }  
               else 
               {
                  $urlArgs2 = $urlArgs;
                  $urlArgs2['action'] = 'file_monitor';
                  $urlArgs2['id'] = $fid;
                  $urlArgs2['parent'] = $backup_parent;
                  $sUrl = fGetURL ('dbmodify.php', $urlArgs2);
                  $aFileMenuString["file_monitor"] = "..|$owl_lang->alt_monitored|$sUrl|$owl_lang->alt_monitored|monitored.gif\n";

               }
            }
         }
      }

      $urlArgs2 = $urlArgs;
      $urlArgs2['search_id'] = $fid;
      $urlArgs2['parent'] = $backup_parent;
      $sUrl = fGetURL ('search.php', $urlArgs2);
      $aFileMenuString["file_find"]  = "..|$owl_lang->alt_related|$sUrl|$owl_lang->alt_related|related.gif\n";
 
      // *****************************************************************************
      // Don't Show the view icon if the user doesn't have download access to the file
      // *****************************************************************************
      $ext = fFindFileExtension($filename);

      if ($default->view_doc_in_new_window)
      {
         $sTarget = "_new";
      }

      if($bFileDownload == 1)
      {
         if ($url != "1") 
         {
            $imgfiles = array("jpg","gif","bmp");
            if ($ext != "" && preg_grep("/\b$ext\b/", $imgfiles)) 
            {
               $urlArgs2 = $urlArgs;
               $urlArgs2['action'] = 'image_preview';
               $urlArgs2['id'] = $fid;
               $urlArgs2['parent'] = $backup_parent;
               $sUrl = fGetURL ('view.php', $urlArgs2);
               $aFileMenuString["file_view"] =  "..|$owl_lang->alt_view_file|$sUrl|$owl_lang->alt_view_file|mag.gif|$sTarget\n";


            }
            $htmlfiles = array("php","php3");
            if ($ext != "" && preg_grep("/\b$ext\b/", $htmlfiles)) 
            {
               $urlArgs2 = $urlArgs;
               $urlArgs2['action'] = 'php_show';
               $urlArgs2['id'] = $fid;
               $urlArgs2['parent'] = $backup_parent;
               $sUrl = fGetURL ('view.php', $urlArgs2);
	       $aFileMenuString["file_view"] =  "..|$owl_lang->alt_view_file|$sUrl|$owl_lang->alt_view_file|mag.gif|$sTarget\n";


            }
            
            $htmlfiles = array("html","htm","xml");
            if ($ext != "" && preg_grep("/\b$ext\b/", $htmlfiles)) 
            {
               $urlArgs2 = $urlArgs;
               $urlArgs2['action'] = 'html_show';
               $urlArgs2['id'] = $fid;
               $urlArgs2['parent'] = $backup_parent;
               $sUrl = fGetURL ('view.php', $urlArgs2);
	       $aFileMenuString["file_view"] =  "..|$owl_lang->alt_view_file|$sUrl|$owl_lang->alt_view_file|mag.gif|$sTarget\n";


            }
            if ($ext != "" && $ext == "pod") 
            {
               $urlArgs2 = $urlArgs;
               $urlArgs2['action'] = 'pod_show';
               $urlArgs2['id'] = $fid;
               $urlArgs2['parent'] = $backup_parent;
               $sUrl = fGetURL ('view.php', $urlArgs2);
	       $aFileMenuString["file_view"] =  "..|$owl_lang->alt_view_file|$sUrl|$owl_lang->alt_view_file|mag.gif|$sTarget\n";

            }
            $txtfiles = array("txt","text","README", "readme", "sh", "c", "h", "cpp", "pl", "perl", "sql", "py", "tex", "bib");
            if ($ext != "" && preg_grep("/\b$ext\b/", $txtfiles)) 
            {
               if(owlfiletype($fid) == 2) 
               { 
                  $urlArgs2 = $urlArgs;
                  $urlArgs2['action'] = 'note_show';
                  $urlArgs2['id'] = $fid;
                  $urlArgs2['parent'] = $backup_parent;
                  $sUrl = fGetURL ('view.php', $urlArgs2);
	          $aFileMenuString["file_view"] =  "..|$owl_lang->alt_view_file|$sUrl|$owl_lang->alt_view_file|mag.gif|$sTarget\n";

               }
               else
               {
                  $urlArgs2 = $urlArgs;
                  $urlArgs2['action'] = 'text_show';
                  $urlArgs2['id'] = $fid;
                  $urlArgs2['parent'] = $backup_parent;
                  $sUrl = fGetURL ('view.php', $urlArgs2);
	          $aFileMenuString["file_view"] =  "..|$owl_lang->alt_view_file|$sUrl|$owl_lang->alt_view_file|mag.gif|$sTarget\n";
               }
            }
         }
      }

      // BEGIN what I added to show PDF, DOC, and TXT special view

      if($bFileDownload == 1 and $url != 1)
      {
         $pdffiles = array("pdf");
         if ($ext != "" && preg_grep("/\b$ext\b/", $pdffiles)) 
         {
            $urlArgs2 = $urlArgs;
            $urlArgs2['action'] = 'pdf_show';
            $urlArgs2['id'] = $fid;
            $urlArgs2['parent'] = $backup_parent;
            $sUrl = fGetURL ('view.php', $urlArgs2);
	    $aFileMenuString["file_view"] =  "..|$owl_lang->alt_view_file|$sUrl|$owl_lang->alt_view_file|mag.gif|$sTarget\n";

         }
   
         $mswordfiles = array("doc", "sxw");
         if ($ext != "" && preg_grep("/\b$ext\b/", $mswordfiles)) 
         {
            $urlArgs2 = $urlArgs;
            $urlArgs2['action'] = 'doc_show';
            $urlArgs2['id'] = $fid;
            $urlArgs2['parent'] = $backup_parent;
            $sUrl = fGetURL ('view.php', $urlArgs2);
	    $aFileMenuString["file_view"] =  "..|$owl_lang->alt_view_file|$sUrl|$owl_lang->alt_view_file|mag.gif|$sTarget\n";

         }
   
         $msexcelfiles = array("xls");
         if ($ext != "" && preg_grep("/\b$ext\b/", $msexcelfiles)) 
         {
            $urlArgs2 = $urlArgs;
            $urlArgs2['action'] = 'xls_show';
            $urlArgs2['id'] = $fid;
            $urlArgs2['parent'] = $backup_parent;
            $sUrl = fGetURL ('view.php', $urlArgs2);
	    $aFileMenuString["file_view"] =  "..|$owl_lang->alt_view_file|$sUrl|$owl_lang->alt_view_file|mag.gif|$sTarget\n";
  
         }

         if (!empty ($default->view_other_file_type_inline))
         {
            $inline =$default->view_other_file_type_inline;
            if ($ext != "" && preg_grep("/\b$ext\b/", $inline)) 
            {
               $urlArgs2 = $urlArgs;
               $urlArgs2['action'] = 'inline';
               $urlArgs2['id'] = $fid;
               $urlArgs2['parent'] = $backup_parent;
               $sUrl = fGetURL ('view.php', $urlArgs2);
	       $aFileMenuString["file_view"] =  "..|$owl_lang->alt_view_file|$sUrl|$owl_lang->alt_view_file|mag.gif|$sTarget\n";
  
            }
         } 
         $audiofiles = array("mp3");
         if ($ext != "" && preg_grep("/\b$ext\b/", $audiofiles)) 
         {
            $urlArgs2 = $urlArgs;
            $urlArgs2['action'] = 'mp3_play';
            $urlArgs2['id'] = $fid;
            $urlArgs2['parent'] = $backup_parent;
            $sUrl = fGetURL ('view.php', $urlArgs2);
            $aFileMenuString["file_view"] =  "..|$owl_lang->alt_play_file|$sUrl|$owl_lang->alt_play_file|play.gif|$sTarget\n";
 
         }
   
         $pptfiles = array("ppt");
         if ($ext != "" && preg_grep("/\b$ext\b/", $pptfiles)) 
         {
            $urlArgs2 = $urlArgs;
            $urlArgs2['action'] = 'ppt_show';
            $urlArgs2['id'] = $fid;
            $urlArgs2['parent'] = $backup_parent;
            $sUrl = fGetURL ('view.php', $urlArgs2);
            $aFileMenuString["file_view"] =  "..|$owl_lang->alt_view_file|$sUrl|$owl_lang->alt_view_file|mag.gif|$sTarget\n";

         }
   
         $zipfiles = array("tar.gz", "tgz", "tar", "gz", "zip");
         $bPrintZipView = false;
         if ($ext != "" && preg_grep("/\b$ext\b/", $zipfiles)) 
         {
            if ($ext == "zip" && file_exists($default->unzip_path) && trim($default->unzip_path) != "") 
            {
                  $bPrintZipView = true;
            }
            if ($ext == "gz" && file_exists($default->gzip_path) && trim($default->gzip_path) != "") 
            {
                  $bPrintZipView = true;
            }
            if (($ext == "tar" || $ext == "tar.gz" || $ext == "tgz") && file_exists($default->tar_path) && trim($default->tar_path) != "") 
            {
               if (substr(php_uname(), 0, 7) != "Windows") 
               {
                  $bPrintZipView = true;
               }
            }
            if ( $bPrintZipView ) 
            {
               $urlArgs2 = $urlArgs;
               $urlArgs2['action'] = 'zip_preview';
               $urlArgs2['id'] = $fid;
               $urlArgs2['parent'] = $backup_parent;
               $urlArgs2['filext'] = $ext;
               $sUrl = fGetURL ('view.php', $urlArgs2);
               $aFileMenuString["file_view"] =  "..|$owl_lang->alt_view_file|$sUrl|$owl_lang->alt_view_file|mag.gif|$sTarget\n";

            }
         }
      }

      $menustring = $aFileMenuString["file_name"];

      foreach ($default->FileMenuOrder as $key) 
      {
         $menustring .= $aFileMenuString[$key];
      }

      $aFileMenuString = NULL;

      $mid->setMenuStructureString($menustring);
      $mid->parseStructureForMenu('vermenu'.$fid);
      $mid->newVerticalMenu('vermenu'.$fid);
      //$menustring = ".|||Available File Actions||\n";
   }
   return;
}


function printFileIcons ($fid, $filename, $checked_out, $url, $allicons, $ext, $backup_parent, $is_backup_folder = false)
{
   global $default;
   global $sess, $expand, $order, $sortorder ,$sortname, $userid;
   global $owl_lang ;

   $urlArgs = array();
   $urlArgs['sess']      = $sess;
   $urlArgs['parent']    = $backup_parent;
   $urlArgs['expand']    = $expand;
   $urlArgs['order']     = $order;
   $urlArgs['sortname']  = $sortname;

   $self = $_SERVER["PHP_SELF"];
   $isBackup = fid_to_name($backup_parent);
   // check to see if the file is checked out
   // to display a the lock or unlock Icon.

   $iCheckedOut = $checked_out;

   $aFileAccess = check_auth($fid, "file_all", $userid, false, false);
   $bFileModify = $aFileAccess["file_modify"];
   $bFileDownload = $aFileAccess["file_download"];
   $bFileDelete	= $aFileAccess["file_delete"];


   $bCheckOK = false;
   if (($checked_out == 0) || ($checked_out == $userid) || owlusergroup($userid) == 0 ||  owlusergroup($userid) == $default->file_admin_group) 
   { 
      $bCheckOK = true; 
   }

                                                                                                                                                                                                   
   if ($allicons == 1)
   {
      if ($url == "0") 
      {
         $filename = ereg_replace("\&","<amp>", $filename);
         $urlArgs2 = $urlArgs;
         $urlArgs2['id'] = $fid;
         $urlArgs2['filename'] = $filename;
         $urlArgs2['parent'] = $backup_parent;
         $sUrl = fGetURL ('log.php', $urlArgs2);

         print("<a href=\"$sUrl\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/log.gif\" border=\"0\" alt=\"$owl_lang->alt_log_file\" title=\"$owl_lang->alt_log_file\"></img></a>");
         fPrintButtonSpace(1, 4);
      } 
      else 
      {
         fPrintButtonSpace(1, 21);
      }
   }
   else
   {
      fPrintButtonSpace(1, 2);
   }

   // *****************************************************************************
   // Don't Show the delete icon if the user doesn't have delete access to the file
   // *****************************************************************************

   if($bFileDelete == 1)
   {
      if ($url == "1")
      {
         if ($bCheckOK) 
         {
            $urlArgs2 = $urlArgs;
            $urlArgs2['action'] = 'file_delete';
            $urlArgs2['type']   = 'url';
            $urlArgs2['id']     = $fid;
            $urlArgs2['parent'] = $backup_parent;
            if($self == $default->owl_root_url . "/log.php")
            {
               $urlArgs2['self'] = 'log';
            }

            $sUrl = fGetURL ('dbmodify.php', $urlArgs2);

            print("<a href=\"$sUrl\" onclick=\"return confirm('$owl_lang->reallydelete ".$filename."?');\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/trash.gif\" alt=\"$owl_lang->alt_del_file\" title=\"$owl_lang->alt_del_file\" border=\"0\"></img></a>");
         } 
         fPrintButtonSpace(1, 4);
      }
      else
      {
         if ($bCheckOK) 
         { 
            $urlArgs2 = $urlArgs;
            $urlArgs2['action'] = 'file_delete';
            $urlArgs2['id']     = $fid;
            $urlArgs2['parent'] = $backup_parent;
            if($self == $default->owl_root_url . "/log.php")
            {
               $urlArgs2['self'] = 'log';
            }
            $sUrl = fGetURL ('dbmodify.php', $urlArgs2);
            print("<a href=\"$sUrl\" onclick=\"return confirm('$owl_lang->reallydelete ".$filename."?');\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/trash.gif\" alt=\"$owl_lang->alt_del_file\" title=\"$owl_lang->alt_del_file\" border=\"0\"></img></a>");
         } 
         else 
         {
            fPrintButtonSpace(1, 17);
         }
         fPrintButtonSpace(1, 4);
      }
   }
   else
   {
      fPrintButtonSpace(1, 21);
   }

   // *****************************************************************************
   // Don't Show the modify icon if the user doesn't have modify access to the file
   // *****************************************************************************
   
   if($bFileModify == 1 && !$is_backup_folder) 
   {
      if ($bCheckOK) 
      {
         $urlArgs2 = $urlArgs;
         $urlArgs2['action'] = 'file_modify';
         $urlArgs2['id'] = $fid;
         $urlArgs2['parent'] = $backup_parent;
         $sUrl = fGetURL ('modify.php', $urlArgs2);

         print("<a href=\"$sUrl\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/edit.gif\" border=\"0\" alt=\"$owl_lang->alt_mod_file\" title=\"$owl_lang->alt_mod_file\"></img></a>");
      } 
      else 
      {
         fPrintButtonSpace(1, 17);
      }
      fPrintButtonSpace(1, 4);
   }
   else
   {
      fPrintButtonSpace(1, 21);
   }
 // *****************************************************************************
   // Don't Show the link icon if the user doesn't have move access to the file
   // *****************************************************************************


  $Realid = fGetPhysicalFileId($fid);
                                                                                                                                                                                                    
   if ($bFileModify == 1 && !$is_backup_folder and $Realid == $fid)
   {
      if (($default->hide_backup == 1 && $self != $default->owl_root_url . "/log.php")  || $isBackup != "backup" || $default->hide_backup != 1)
      {
         if ($bCheckOK)
         {
            $urlArgs2 = $urlArgs;
            $urlArgs2['action'] = 'lnk_file';
            $urlArgs2['id'] = $fid;
            $urlArgs2['parent'] = $backup_parent;
            $sUrl = fGetURL ('move.php', $urlArgs2);
            print("<a href=\"$sUrl\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/link.gif\" border=\"0\" alt=\"$owl_lang->alt_link_file\" title=\"$owl_lang->alt_link_file\"></img></a>");
         }
         else
         {
            fPrintButtonSpace(1, 17);
         }
         fPrintButtonSpace(1, 4);
      }
   }
   else
   {
      fPrintButtonSpace(1, 21);
   }


   // *****************************************************************************
   // Don't Show the copy icon if the user doesn't have move access to the file
   // *****************************************************************************

   if ($bFileModify == 1 && !$is_backup_folder)
   {
      if (($default->hide_backup == 1 && $self != $default->owl_root_url . "/log.php")  || $isBackup != "backup" || $default->hide_backup != 1)
      {
         if ($url == "1")
         {
            if ($bCheckOK) 
            {
               $urlArgs2 = $urlArgs;
               $urlArgs2['action'] = 'cp_file';
               $urlArgs2['id'] = $fid;
               $urlArgs2['parent'] = $backup_parent;
               $urlArgs2['type'] = 'url';
               $sUrl = fGetURL ('move.php', $urlArgs2);

               print("<a href=\"$sUrl\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/copy.gif\" border=\"0\" alt=\"$owl_lang->alt_copy_file\" title=\"$owl_lang->alt_copy_file\"></img></a>");
            }  
            else 
            {
               fPrintButtonSpace(1, 17);
            }
            fPrintButtonSpace(1, 4);
         }
         else
         {
            if ($bCheckOK) 
            {
               $urlArgs2 = $urlArgs;
               $urlArgs2['action'] = 'cp_file';
               $urlArgs2['id'] = $fid;
               $urlArgs2['parent'] = $backup_parent;
               $sUrl = fGetURL ('move.php', $urlArgs2);

               print("<a href=\"$sUrl\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/copy.gif\" border=\"0\" alt=\"$owl_lang->alt_copy_file\" title=\"$owl_lang->alt_copy_file\"></img></a>");
            } 
            else 
            {
               fPrintButtonSpace(1, 17);
            }
            fPrintButtonSpace(1, 4);
         }
      }
   }
   else
   {
      fPrintButtonSpace(1, 21);
   }



   // *****************************************************************************
   // Don't Show the move modify icon if the user doesn't have move access to the file
   // *****************************************************************************

   if ($bFileModify == 1 && !$is_backup_folder)
   {
      if (($default->hide_backup == 1 && $self != $default->owl_root_url . "/log.php")  || $isBackup != "backup" || $default->hide_backup != 1)
      {
         if ($url == "1")
         {
            if ($bCheckOK) 
            {
               $urlArgs2 = $urlArgs;
               $urlArgs2['action'] = 'file';
               $urlArgs2['id'] = $fid;
               $urlArgs2['parent'] = $backup_parent;
               $urlArgs2['type'] = 'url';
               $sUrl = fGetURL ('move.php', $urlArgs2);

               print("<a href=\"$sUrl\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/move.gif\" border=\"0\" alt=\"$owl_lang->alt_move_file\" title=\"$owl_lang->alt_move_file\"></img></a>");
            }  
            else 
            {
               fPrintButtonSpace(1, 17);
            }
         }
         else
         {
            if ($bCheckOK) 
            {
               $urlArgs2 = $urlArgs;
               $urlArgs2['action'] = 'file';
               $urlArgs2['id'] = $fid;
               $urlArgs2['parent'] = $backup_parent;
               $sUrl = fGetURL ('move.php', $urlArgs2);

               print("<a href=\"$sUrl\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/move.gif\" border=\"0\" alt=\"$owl_lang->alt_move_file\" title=\"$owl_lang->alt_move_file\"></img></a>");
            } 
            else 
            {
               fPrintButtonSpace(1, 17);
            }
            fPrintButtonSpace(1, 4);
         }
      }
   }
   else
   {
      fPrintButtonSpace(1, 21);
   }


   // *****************************************************************************
   // Don't Show the file update icon if the user doesn't have update access to the file
   // *****************************************************************************

   if($bFileModify == 1 && !$is_backup_folder and $Realid == $fid)
   {
      if (($default->hide_backup == 1 && $self != $default->owl_root_url . "/log.php")  || $isBackup != "backup" || $default->hide_backup != 1)
      {
         if ($url != "1")
         {
            if ($bCheckOK) 
            {
               $urlArgs2 = $urlArgs;
               $urlArgs2['action'] = 'file_update';
               $urlArgs2['id'] = $fid;
               $urlArgs2['parent'] = $backup_parent;
               $sUrl = fGetURL ('modify.php', $urlArgs2);

               print("<a href=\"$sUrl\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/update.gif\" border=\"0\" alt=\"$owl_lang->alt_upd_file\" title=\"$owl_lang->alt_upd_file\"></img></a>");
            } 
            else 
            {
               fPrintButtonSpace(1, 17);
            }
            fPrintButtonSpace(1, 4);
         }
         else
         {
            fPrintButtonSpace(1, 25);
         }
      }
   }
   else
   {
      fPrintButtonSpace(1, 21);
   }
   // *****************************************************************************
   // Don't Show the file dowload icon if the user doesn't have download access to the file
   // *****************************************************************************
   
   if($bFileDownload == 1)
   {
      if ($url != "1")
      {
         $urlArgs2 = $urlArgs;
         $urlArgs2['binary'] = 1;
         $urlArgs2['id'] = $fid;
         $urlArgs2['parent'] = $backup_parent;
         $sUrl = fGetURL ('download.php', $urlArgs2);

         print("<a href=\"$sUrl\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/bin.gif\" border=\"0\" alt=\"$owl_lang->alt_get_file\" title=\"$owl_lang->alt_get_file\"></img></a>");
         fPrintButtonSpace(1, 4);
      }
      else
      {
         fPrintButtonSpace(1, 21);
      }
   }

   // *****************************************************************************
   // Don't Show the comment icon if the user doesn't have download access to the file
   // *****************************************************************************

   if($bFileDownload == 1 && !$is_backup_folder) 
   {
      $sql = new Owl_DB;
      $sql->query("SELECT * from $default->owl_comment_table where fid = '$fid'");
      if($sql->num_rows() == 0) 
      {
          $urlArgs2 = $urlArgs;
          $urlArgs2['action'] = 'file_comment';
          $urlArgs2['id'] = $fid;
          $urlArgs2['parent'] = $backup_parent;
          $sUrl = fGetURL ('modify.php', $urlArgs2);

          print("<a href=\"$sUrl\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/comment_dis.gif\" border=\"0\" alt=\"$owl_lang->alt_add_comments\" title=\"$owl_lang->alt_add_comments\"></img></a>");
         fPrintButtonSpace(1, 4);
      } 
      else 
      { 
         $urlArgs2 = $urlArgs;
         $urlArgs2['action'] = 'file_comment';
         $urlArgs2['id'] = $fid;
         $urlArgs2['parent'] = $backup_parent;
         $sUrl = fGetURL ('modify.php', $urlArgs2);

         print("<a href=\"$sUrl\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/comment.gif\" border=\"0\" alt=\"$owl_lang->alt_view_comments\" title=\"$owl_lang->alt_view_comments\"></img></a>");
         fPrintButtonSpace(1, 4);
      }
   }
   else
   {
      fPrintButtonSpace(1, 21);
   }

   if ($allicons == 1)
   {
      // *****************************************************************************
      // Don't Show the lock icon if the user doesn't have access to the file
      // *****************************************************************************
      if($bFileModify == 1 && !$is_backup_folder and $Realid == $fid)
      {
         if ($url != "1")
         {
            if ($bCheckOK) 
            {
               if ($iCheckedOut <> 0) 
               {
                  $urlArgs2 = $urlArgs;
                  $urlArgs2['action'] = 'file_lock';
                  $urlArgs2['id'] = $fid;
                  $urlArgs2['parent'] = $backup_parent;
                  $sUrl = fGetURL ('dbmodify.php', $urlArgs2);

                  print("<a href=\"$sUrl\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/unlock.gif\" border=\"0\" alt=\"$owl_lang->alt_unlock_file\" title=\"$owl_lang->alt_unlock_file\"></img></a>");
               } 
               else 
               {
                  $urlArgs2 = $urlArgs;
                  $urlArgs2['action'] = 'file_lock';
                  $urlArgs2['id'] = $fid;
                  $urlArgs2['parent'] = $backup_parent;
                  $sUrl = fGetURL ('dbmodify.php', $urlArgs2);

                  print("<a href=\"$sUrl\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/lock.gif\" border=\"0\" alt=\"$owl_lang->alt_lock_file\" title=\"$owl_lang->alt_lock_file\"></img></a>");
               }
            } 
            else 
            {
               fPrintButtonSpace(1, 16); // not sure why this one needs to be 16, but it does to get things lined up
            }
            fPrintButtonSpace(1, 4);
         }
         else
         {
            fPrintButtonSpace(1, 21);
         }
      }
      else
      {
         fPrintButtonSpace(1, 21);
      }
   }

      // *****************************************************************************
      // Don't Show the email icon if the user doesn't have access to email the file
      // *****************************************************************************

      if($bFileDownload == 1 && !$is_backup_folder)
      {
         if ($url == "1") 
         {
            //if ($default->owl_version_control == 1) 
            //{
               //fPrintButtonSpace(17);
            //}
            $urlArgs2 = $urlArgs;
            $urlArgs2['action'] = 'file_email';
            $urlArgs2['type']   = 'url';
            $urlArgs2['id'] = $fid;
            $urlArgs2['parent'] = $backup_parent;
            $sUrl = fGetURL ('modify.php', $urlArgs2);

            print("<a href=\"$sUrl\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/email.gif\" border=\"0\" alt=\"$owl_lang->alt_email\" title=\"$owl_lang->alt_email\"></img></a>");
            fPrintButtonSpace(1, 4);
         } 
         else 
         {
            $urlArgs2 = $urlArgs;
            $urlArgs2['action'] = 'file_email';
            $urlArgs2['id'] = $fid;
            $urlArgs2['parent'] = $backup_parent;
            $sUrl = fGetURL ('modify.php', $urlArgs2);

            print("<a href=\"$sUrl\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/email.gif\" border=\"0\" alt=\"$owl_lang->alt_email\" title=\"$owl_lang->alt_email\"></img></a>");
            fPrintButtonSpace(1, 4);
         }
      }
      else
      {
         if ($default->owl_version_control == 0) 
         {
            fPrintButtonSpace(1, 4);
         }
         fPrintButtonSpace(1, 21);
      }

      // *****************************************************************************
      // Don't Show the toggle monitor this file  icon if the user doesn't have access 
      // *****************************************************************************

      if($bFileDownload == 1)
      {
         $sql = new Owl_DB;
         $sql->query("SELECT * from $default->owl_users_table where id = '$userid'");
         $sql->next_record();
         $TestEmail = $sql->f("email");
         if ($url != "1") 
         {
            if (trim($TestEmail) != "") 
            {
               $sql->query("select * from $default->owl_monitored_file_table where fid = '$fid' and userid = '$userid'");
               if ($sql->num_rows($sql) == 0) 
               {
                  $urlArgs2 = $urlArgs;
                  $urlArgs2['action'] = 'file_monitor';
                  $urlArgs2['id'] = $fid;
                  $urlArgs2['parent'] = $backup_parent;
                  $sUrl = fGetURL ('dbmodify.php', $urlArgs2);

                  print("<a href=\"$sUrl\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/monitor.gif\" border=\"0\" alt=\"$owl_lang->alt_monitor\" title=\"$owl_lang->alt_monitor\"></img></a>");
                  fPrintButtonSpace(1, 4);
               }  
               else 
               {
                  $urlArgs2 = $urlArgs;
                  $urlArgs2['action'] = 'file_monitor';
                  $urlArgs2['id'] = $fid;
                  $urlArgs2['parent'] = $backup_parent;
                  $sUrl = fGetURL ('dbmodify.php', $urlArgs2);

                  print("<a href=\"$sUrl\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/monitored.gif\" border=\"0\" alt=\"$owl_lang->alt_monitored\" title=\"$owl_lang->alt_monitored\"></img></a>");
                  fPrintButtonSpace(1,4);
               }
            }
         }
         else
         {
            if (! empty($TestEmail) )
            {
               fPrintButtonSpace(1,21);
            }
         }
      }

      if($bFileDownload != 1)
      {
         fPrintButtonSpace(1,21);
      }

      $urlArgs2 = $urlArgs;
      $urlArgs2['search_id'] = $fid;
      $urlArgs2['parent'] = $backup_parent;
      $sUrl = fGetURL ('search.php', $urlArgs2);
      print("<a href=\"$sUrl\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/related.gif\" border=\"0\" alt=\"$owl_lang->alt_related\" title=\"$owl_lang->alt_related\"></img></a>");
      fPrintButtonSpace(1, 4);
 
      // *****************************************************************************
      // Don't Show the view icon if the user doesn't have download access to the file
      // *****************************************************************************
      if ($default->view_doc_in_new_window)
      {
         $sTarget = "target='_new'";
      }

      if($bFileDownload == 1)
      {
         if ($url != "1") 
         {
            $imgfiles = array("jpg","gif","bmp");
            if ($ext != "" && preg_grep("/\b$ext\b/", $imgfiles)) 
            {
               $urlArgs2 = $urlArgs;
               $urlArgs2['action'] = 'image_preview';
               $urlArgs2['id'] = $fid;
               $urlArgs2['parent'] = $backup_parent;
               $sUrl = fGetURL ('view.php', $urlArgs2);

               print("<a href=\"$sUrl\" $sTarget><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/mag.gif\" border=\"0\" alt=\"$owl_lang->alt_view_file\" title=\"$owl_lang->alt_view_file\"></img></a>");

               fPrintButtonSpace(1, 4);
            }
            $htmlfiles = array("php","php3");
            if ($ext != "" && preg_grep("/\b$ext\b/", $htmlfiles)) 
            {
               $urlArgs2 = $urlArgs;
               $urlArgs2['action'] = 'php_show';
               $urlArgs2['id'] = $fid;
               $urlArgs2['parent'] = $backup_parent;
               $sUrl = fGetURL ('view.php', $urlArgs2);

               print("<a href=\"$sUrl\" $sTarget><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/mag.gif\" border=\"0\" alt=\"$owl_lang->alt_view_file\" title=\"$owl_lang->alt_view_file\"></img></a>");

               fPrintButtonSpace(1, 4);
            }
            
            $htmlfiles = array("html","htm","xml");
            if ($ext != "" && preg_grep("/\b$ext\b/", $htmlfiles)) 
            {
               $urlArgs2 = $urlArgs;
               $urlArgs2['action'] = 'html_show';
               $urlArgs2['id'] = $fid;
               $urlArgs2['parent'] = $backup_parent;
               $sUrl = fGetURL ('view.php', $urlArgs2);

               print("<a href=\"$sUrl\" $sTarget><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/mag.gif\" border=\"0\" alt=\"$owl_lang->alt_view_file\" title=\"$owl_lang->alt_view_file\"></img></a>");

               fPrintButtonSpace(1, 4);
            }
            if ($ext != "" && $ext == "pod") 
            {
               $urlArgs2 = $urlArgs;
               $urlArgs2['action'] = 'pod_show';
               $urlArgs2['id'] = $fid;
               $urlArgs2['parent'] = $backup_parent;
               $sUrl = fGetURL ('view.php', $urlArgs2);

               print("<a href=\"$sUrl\" $sTarget><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/mag.gif\" border=\"0\" alt=\"$owl_lang->alt_view_file\" title=\"$owl_lang->alt_view_file\"></img></a>");
               fPrintButtonSpace(1, 4);
            }
            $txtfiles = array("txt","text","README", "readme", "sh", "c", "h", "cpp", "pl", "perl", "sql", "py");
            if ($ext != "" && preg_grep("/\b$ext\b/", $txtfiles)) 
            {
               if(owlfiletype($fid) == 2) 
               { 
                  $urlArgs2 = $urlArgs;
                  $urlArgs2['action'] = 'note_show';
                  $urlArgs2['id'] = $fid;
                  $urlArgs2['parent'] = $backup_parent;
                  $sUrl = fGetURL ('view.php', $urlArgs2);

                  print("<a href=\"$sUrl\" $sTarget><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/mag.gif\" border=\"0\" alt=\"$owl_lang->alt_view_file\" title=\"$owl_lang->alt_view_file\"></img></a>");
                  fPrintButtonSpace(1, 4);
               }
               else
               {
                  $urlArgs2 = $urlArgs;
                  $urlArgs2['action'] = 'text_show';
                  $urlArgs2['id'] = $fid;
                  $urlArgs2['parent'] = $backup_parent;
                  $sUrl = fGetURL ('view.php', $urlArgs2);

                  print("<a href=\"$sUrl\" $sTarget><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/mag.gif\" border=\"0\" alt=\"$owl_lang->alt_view_file\" title=\"$owl_lang->alt_view_file\"></img></a>");
                   fPrintButtonSpace(1, 4);
               }
            }
         }
      }

      // BEGIN what I added to show PDF, DOC, and TXT special view
      if($bFileDownload == 1 and $url != 1)
      {
         $pdffiles = array("pdf");
         if ($ext != "" && preg_grep("/\b$ext\b/", $pdffiles)) 
         {
            $urlArgs2 = $urlArgs;
            $urlArgs2['action'] = 'pdf_show';
            $urlArgs2['id'] = $fid;
            $urlArgs2['parent'] = $backup_parent;
            $sUrl = fGetURL ('view.php', $urlArgs2);

            print("<a href=\"$sUrl\" $sTarget><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/mag.gif\" border=\"0\" alt=\"$owl_lang->alt_view_file\" title=\"$owl_lang->alt_view_file\"></img></a>");
            fPrintButtonSpace(1, 4);
         }
   
         $mswordfiles = array("doc", "sxw");
         if ($ext != "" && preg_grep("/\b$ext\b/", $mswordfiles)) 
         {
            $urlArgs2 = $urlArgs;
            $urlArgs2['action'] = 'doc_show';
            $urlArgs2['id'] = $fid;
            $urlArgs2['parent'] = $backup_parent;
            $sUrl = fGetURL ('view.php', $urlArgs2);

            print("<a href=\"$sUrl\" $sTarget><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/mag.gif\" border=\"0\" alt=\"$owl_lang->alt_view_file\" title=\"$owl_lang->alt_view_file\"></img></a>");
            fPrintButtonSpace(1, 4);
         }
   
         $msexcelfiles = array("xls");
         if ($ext != "" && preg_grep("/\b$ext\b/", $msexcelfiles)) 
         {
            $urlArgs2 = $urlArgs;
            $urlArgs2['action'] = 'xls_show';
            $urlArgs2['id'] = $fid;
            $urlArgs2['parent'] = $backup_parent;
            $sUrl = fGetURL ('view.php', $urlArgs2);
  
            print("<a href=\"$sUrl\" $sTarget><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/mag.gif\" border=\"0\" alt=\"$owl_lang->alt_view_file\" title=\"$owl_lang->alt_view_file\"></img></a>");
            fPrintButtonSpace(1, 4);
         }

         if (!empty ($default->view_other_file_type_inline))
         {
            $inline =$default->view_other_file_type_inline;
            if ($ext != "" && preg_grep("/\b$ext\b/", $inline)) 
            {
               $urlArgs2 = $urlArgs;
               $urlArgs2['action'] = 'inline';
               $urlArgs2['id'] = $fid;
               $urlArgs2['parent'] = $backup_parent;
               $sUrl = fGetURL ('view.php', $urlArgs2);
  
               print("<a href=\"$sUrl\" $sTarget><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/mag.gif\" border=\"0\" alt=\"$owl_lang->alt_view_file\" title=\"$owl_lang->alt_view_file\"></img></a>");
               fPrintButtonSpace(1, 4);
            }
         } 
         $audiofiles = array("mp3");
         if ($ext != "" && preg_grep("/\b$ext\b/", $audiofiles)) 
         {
            $urlArgs2 = $urlArgs;
            $urlArgs2['action'] = 'mp3_play';
            $urlArgs2['id'] = $fid;
            $urlArgs2['parent'] = $backup_parent;
            $sUrl = fGetURL ('view.php', $urlArgs2);
 
            print("<a href=\"$sUrl\" $sTarget><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/play.gif\" border=\"0\" alt=\"$owl_lang->alt_play_file\" title=\"$owl_lang->alt_play_file\"></img></a>");
            fPrintButtonSpace(1, 4);
         }
   
         $pptfiles = array("ppt");
         if ($ext != "" && preg_grep("/\b$ext\b/", $pptfiles)) 
         {
            $urlArgs2 = $urlArgs;
            $urlArgs2['action'] = 'ppt_show';
            $urlArgs2['id'] = $fid;
            $urlArgs2['parent'] = $backup_parent;
            $sUrl = fGetURL ('view.php', $urlArgs2);

            print("<a href=\"$sUrl\" $sTarget><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/mag.gif\" border=\"0\" alt=\"$owl_lang->alt_view_file\" title=\"$owl_lang->alt_view_file\"></img></a>");
            fPrintButtonSpace(1, 4);
         }
   
         $zipfiles = array("tar.gz", "tgz", "tar", "gz", "zip");
         $bPrintZipView = false;
         if ($ext != "" && preg_grep("/\b$ext\b/", $zipfiles)) 
         {
            if ($ext == "zip" && file_exists($default->unzip_path) && trim($default->unzip_path) != "") 
            {
                  $bPrintZipView = true;
            }
            if ($ext == "gz" && file_exists($default->gzip_path) && trim($default->gzip_path) != "") 
            {
                  $bPrintZipView = true;
            }
            if (($ext == "tar" || $ext == "tar.gz" || $ext == "tgz") && file_exists($default->tar_path) && trim($default->tar_path) != "") 
            {
               if (substr(php_uname(), 0, 7) != "Windows") 
               {
                  $bPrintZipView = true;
               }
            }
            if ( $bPrintZipView ) 
            {
               $urlArgs2 = $urlArgs;
               $urlArgs2['action'] = 'zip_preview';
               $urlArgs2['id'] = $fid;
               $urlArgs2['parent'] = $backup_parent;
               $urlArgs2['filext'] = $ext;
               $sUrl = fGetURL ('view.php', $urlArgs2);

               print("<a href=\"$sUrl\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/mag.gif\" border=\"0\" alt=\"$owl_lang->alt_view_file\" title=\"$owl_lang->alt_view_file\"></img></a>");
               fPrintButtonSpace(1, 4);
            }
         }
      }
}

function displayBrowsePage($parent) 
{
   global $sess, $expand, $order, $sortorder, $sortname, $parent;
   // If we are hidding the backup directory
   // then change the directory to return to
   // the parent of this backup  directory
   
   if(fid_to_name($parent) == "backup" && $default->hide_backup == 1) 
   {
      $sql->query("select parent from $default->owl_folders_table where id = $parent");
      $sql->next_record();
      $parent = $sql->f("parent");
   }
   header("Location: browse.php?sess=$sess&parent=$parent&expand=$expand&order=$order&$sortorder=$sortname");
}

function fGetStatusBarCount() 
{
   global $iUpdatedFileCount, $iNewFileCount, $iMyFileCount, $iTotalFileCount, $iQuotaCurrent, $iQuotaMax, $iNewsCount, $iFolderCount, $iFileCount;
   global $default, $owl_lang, $sess, $expand, $userid, $lastlogin, $parent, $usergroupid, $userid;
   global $iMyCheckedOutCount, $iGroupFileCount, $iMonitoredFiles, $iMonitoredFolders, $aNews; 
   global $iWaitingApproval, $iMyPendingDocs;

   $iMonitoredFiles = 0;
   $iMonitoredFolders = 0;
   $iMyCheckedOutCount = 0;
   $iUpdatedFileCount = 0;
   $iNewFileCount = 0;
   $iMyFileCount = 0;
   $iGroupFileCount = 0;
   $iTotalFileCount = 0;
   $iQuotaCurrent = 0;
   $iQuotaMax = 0;
   $iNewsCount = 0;
   $iFolderCount = 0;
   $iWaitingApproval = 0;
   
   $sql = new Owl_DB;

   // ******* Get Total Number of Monitored Files and Folders ********

   $sql->query("SELECT id from $default->owl_monitored_file_table  where userid = '$userid'");
   $iMonitoredFiles =  $sql->num_rows();

   $sql->query("SELECT id from $default->owl_monitored_folder_table where userid = '$userid'");
   $iMonitoredFolders  =  $sql->num_rows();
   

   $sql->query("SELECT id from $default->owl_folders_table where parent = '$parent'");
   if ($default->restrict_view == 1)
   {
      while($sql->next_record()) 
      {
         if (check_auth($sql->f("id"), "folder_view", $userid, false, false))
         {
            $iFolderCount++;
         } 
      }
   }
   else
   {
      $iFolderCount = $sql->num_rows();
   }

   // ******* Get Total Number of Files in Current Folder ********
   $sql->query("SELECT id from $default->owl_files_table where parent = '$parent' AND approved = '1'");
   if ($default->restrict_view == 1)
   {
      while($sql->next_record()) 
      {
         if (check_auth($sql->f("id"), "file_download", $userid, false, false))
         {
            $iFileCount++;
         } 
      }
   }
   else
   {
      $iFileCount = $sql->num_rows();
   }



   // ******* Get Count of Updated Files ********
   $sql->query("SELECT id FROM $default->owl_files_table where smodified > '$lastlogin' and created < '$lastlogin' AND approved = '1'");
   while($sql->next_record()) 
   {
      if(check_auth($sql->f("id"), "file_download", $userid, false, false) == 1) 
      {
         $iUpdatedFileCount++;
      }
   }

   // ******* Get Count of New Files ********

   $sql->query("SELECT id, parent FROM $default->owl_files_table where created > '$lastlogin' AND approved = '1'");
   while($sql->next_record()) 
   {
      if(check_auth($sql->f("id"), "file_download", $userid, false, false) == 1) 
      {
         $sDirectoryPath = get_dirpath($sql->f("parent"));
         $pos = strpos($sDirectoryPath, "backup");
         if (!(is_integer($pos) && $pos)) 
         {
            $iNewFileCount++;
         }
      }
   }

   // ******* Get Count of That users Files ********

   $sql->query("SELECT id FROM $default->owl_files_table where creatorid = '$userid'");
   $iMyFileCount = $sql->num_rows();

   // ****** Get Count that user has checked out*****
   $sql->query("SELECT id FROM $default->owl_files_table where checked_out = '$userid'");
   $iMyCheckedOutCount = $sql->num_rows();

   // ******* Get Count of All Files ********

   $sql->query("SELECT id FROM $default->owl_files_table WHERE approved = '1'");
   $iTotalFileCount = $sql->num_rows();

   // ******* Get Count of All Files ********

   $sql->query("SELECT * from $default->owl_users_table where id = '$userid'");
   $sql->next_record();
   $iQuotaCurrent = $sql->f("quota_current");
   $iQuotaMax = $sql->f("quota_max");

   $iPercent = $iQuotaCurrent ;

   // ******* Get Count of New News ********

   $iLastNews = $sql->f("lastnews");
   if (!isset($iLastNews))
   {
       $iLastNews = 0;
   }

   $sqlmemgroup = new Owl_DB;
   $sqlmemgroup->query("select * from $default->owl_users_grpmem_table where userid = '" . $userid . "'");
   $sGroupsWhereClause = "( gid = '-1' OR gid = '$usergroupid'";
   $sFilesGroupsWhereClause = "( groupid = '-1' OR groupid = '$usergroupid'";

   while($sqlmemgroup->next_record())
   {
      $sGroupsWhereClause .= " OR gid = '" . $sqlmemgroup->f("groupid") . "'";
      $sFilesGroupsWhereClause .= " OR groupid = '" . $sqlmemgroup->f("groupid") . "'";
   }
   $sGroupsWhereClause .= ")";
   $sFilesGroupsWhereClause .= ")";

   $sMyQuery = "SELECT * from $default->owl_news_table where $sGroupsWhereClause and id > '$iLastNews'  and news_end_date >= " . $sql->now();
   $sql->query($sMyQuery);
   $iNewsCount = $sql->num_rows();
  
   $i = 0; 
   while($sql->next_record())
   {
      $aNews[$i][id] = $sql->f("id");
      $aNews[$i][news_title] = $sql->f("news_title");
      $aNews[$i][news_date] = $sql->f("news_date");
      $aNews[$i][news] = $sql->f("news");
      $i++;
   }
   
   // ******* Get Count of files in My Groups  ********

   $sMyQuery = "SELECT * from $default->owl_files_table where $sFilesGroupsWhereClause  AND approved = '1'";
   $sql->query($sMyQuery);
   $iGroupFileCount = $sql->num_rows();


   // ******* Get Count of files for Review********
   if ( $default->document_peer_review == 1)
   {
      $sMyQuery = "SELECT reviewer_id from $default->owl_peerreview_table where reviewer_id = '$userid' and status = '0'";

      $sql->query($sMyQuery);
      $iWaitingApproval = $sql->num_rows();

      $sMyQuery = "SELECT id from $default->owl_files_table where creatorid = '$userid' and approved = '0'";
      $sql->query($sMyQuery);
      $iMyPendingDocs = $sql->num_rows();
   }

}

function fPrintSearch ($seq = 0)
{
   global $default, $owl_lang, $language, $keywords, $sess, $parent, $expand, $order, $sortorder, $sortname, $boolean;
   

   if (!isset($boolean))
   {
      $boolean = "";
   }
   if (!isset($keywords))
   {
      $keywords = "";
   }

   if(isset($userid) && $bDisplayFooterTools) 
   {
      switch ($boolean)
      {
         case "all":
            $sAnyChecked = "";
            $sAllChecked = "checked";
            $sPhraseChecked = "";
            break;
         case "phrase" :
            $sAnyChecked = "";
            $sAllChecked = "";
            $sPhraseChecked = "checked";
            break;
         default:
            $sAnyChecked = "checked";
            $sAllChecked = "";
            $sPhraseChecked = "";
         break;
      }
   }

   $urlArgs = array();
   $urlArgs['sess']      = $sess;
   $urlArgs['parent']    = $parent;
   $urlArgs['expand']    = $expand;
   $urlArgs['order']     = $order;
   $urlArgs['sort']  = $sortname;
   $urlArgs['sortorder']  = $sortorder;
                                                                                                                                                                                       
   print("<!-- BEGIN: Search -->\n");
   print("<form action=\"$default->owl_root_url/search.php\" method=\"post\">\n");
   print fGetHiddenFields ($urlArgs);
   print("<table class=\"margin2\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
   print("<tr>\n");
   print("<td align=\"left\" valign=\"top\">\n");
   print("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
   print("<tr>\n");
   print("<td class=\"search1\"><input class=\"sinput1\" type=\"text\" name=\"query\" size=\"24\" maxlength=\"255\" value=\"$keywords\"></input></td>\n");
   print("<td class=\"search1\">");
   print("<input name=\"search_$seq\" class=\"sbuttonup1\" type=\"submit\" value=\"$owl_lang->search\" onmouseover=\"highlightButton('sbuttondown1')\" onmouseout=\"highlightButton('sbuttonup1')\"></input>");
   print("</td>\n");
   print("<td class=\"search1\">\n");
   print("<select class=\"spull1\" name=\"boolean\" size=\"1\">\n");
   print("<option value=\"any\" selected=\"selected\">$owl_lang->search_any_word</option>\n");
   print("<option value=\"all\">$owl_lang->search_all_word</option>\n");
   print("<option value=\"phrase\">$owl_lang->search_entire_phrase</option>\n");
   print("</select>\n");
   print("</td>\n");
   print("<td class=\"search1\"><input type=\"checkbox\" name=\"withindocs\" value=\"1\"></input></td>\n");
   print("<td class=\"search1\">$owl_lang->search_winthindocs<br></br></td>\n");
   print("<td class=\"search1\"><input type=\"checkbox\" name=\"currentfolder\" value=\"1\"></input></td>\n");
   print("<td class=\"search1\">$owl_lang->search_currentfolder<br></br></td>\n");
   print("<td class=\"search1\" width=\"100%\">&nbsp;<br></br></td>\n");
   print("</tr>\n");
   print("</table>\n");
   print("</td>\n</tr>\n</table>\n");
   print("</form>");
   print("<!-- END: Search -->\n");
}


function fPrintPanel ()
{
   global $iUpdatedFileCount, $iNewFileCount, $iMyFileCount, $iTotalFileCount, $iQuotaCurrent, $iQuotaMax, $iNewsCount;
   global $iMyCheckedOutCount, $iGroupFileCount, $usergroupid, $aNews;
   global $iMonitoredFiles, $iMonitoredFolders, $iWaitingApproval, $iMyPendingDocs;
   global $default, $owl_lang, $sess, $expand, $userid, $lastlogin, $parent, $order, $sortname, $language, $sortorder;


   print("<!-- BEGIN: File Stats -->\n");
   print("<table class=\"margin1\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\"><tr><td align=\"left\" valign=\"top\">\n");

   print("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n");
   print("<tr><td>");
   print("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n");
   print("<tr><td class=\"stats1\" colspan=\"6\">$owl_lang->panel_file_info <br></br></td></tr>\n");
   print("<tr>\n");

   print("<td class=\"stats2\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/ui_icons/new.gif\" border=\"0\" alt=\"\"></img><br></br></td>\n");
   print("<td class=\"stats2\">");
   if ($iNewFileCount > 0 )
   {
      print ("<a class=\"lstats1\" href=\"showrecords.php?sess=$sess&amp;type=n&amp;expand=$expand\" title=\"$owl_lang->title_view_new\">$owl_lang->tot_new_files</a>");
   }
   else
   {
      print ("$owl_lang->tot_new_files");
   }

   print("<br></br></td>\n");
   print("<td class=\"stats2\">$iNewFileCount <br></br></td>\n");
   print("<td class=\"stats2\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/ui_icons/updated.gif\" border=\"0\" alt=\"\"></img><br></br></td>\n");
   print("<td class=\"stats2\">");
   if ($iUpdatedFileCount > 0 )
   {
      print("<a class=\"lstats1\" href=\"showrecords.php?sess=$sess&amp;type=u&amp;expand=$expand\" title=\"$owl_lang->title_view_updated\">$owl_lang->tot_updated_files</a>");
   }
   else
   {
      print("$owl_lang->tot_updated_files");
   }

   print("<br></br></td>\n");
   print("<td class=\"stats2\">$iUpdatedFileCount<br></br></td>\n");
   print("</tr>");
   print("<tr>");
   print("<td class=\"stats2\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/ui_icons/my.gif\" border=\"0\" alt=\"\"></img><br></br></td>\n");
   print("<td class=\"stats2\"><a class=\"lstats1\" href=\"showrecords.php?sess=$sess&amp;type=m&amp;expand=$expand\" title=\"$owl_lang->title_view_my\">$owl_lang->tot_my_files</a><br></br></td>\n");
   print("<td class=\"stats2\">$iMyFileCount<br></br></td>\n");


   print("<td class=\"stats2\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/ui_icons/group.gif\" border=\"0\" alt=\"\"></img><br></br></td>\n");
   print("<td class=\"stats2\"><a class=\"lstats1\" href=\"showrecords.php?sess=$sess&amp;type=g\" title=\"$owl_lang->title_view_my\">$owl_lang->tot_my_group</a><br></br></td>\n");
   print("<td class=\"stats2\">$iGroupFileCount<br></br></td>\n");
   print("</tr>\n");
   print("<tr>\n");
   print("<td class=\"stats2\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/lock.gif\" border=\"0\" alt=\"\"></img><br></br></td>\n");
   print("<td class=\"stats2\">");
   if ($iMyCheckedOutCount > 0)
   {
      print("<a class=\"lstats1\" href=\"showrecords.php?sess=$sess&amp;type=c&amp;expand=$expand\" title=\"$owl_lang->title_view_my\">$owl_lang->tot_my_checked_out</a>");
   }
   else
   {
      print("$owl_lang->tot_my_checked_out");
   }

   print("<br></br></td>\n");
   print("<td class=\"stats2\">$iMyCheckedOutCount<br></br></td>\n");

   print("<td class=\"stats2\"><img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_action/monitored.gif\" border=\"0\" alt=\"\"></img><br></br></td>\n");
   print("<td class=\"stats2\">");

   if ($iMonitoredFolders > 0 or $iMonitoredFiles > 0)
   {
      print("<a class=\"lstats1\" href=\"showrecords.php?sess=$sess&amp;type=t&amp;expand=$expand\" title=\"$owl_lang->title_view_my\">$owl_lang->tot_monitored</a>");
   }
   else
   {
      print("$owl_lang->tot_monitored");
   }
   print("<br></br></td>\n");
   print("<td class=\"stats2\">");

   if ($iMonitoredFolders > 0 or $iMonitoredFiles > 0)
   {
      print("&nbsp;(");
   }
   if ($iMonitoredFolders > 0 )
   {
      print("<a href=\"#\" class=\"cfolders1\">$iMonitoredFolders</a>");
   }
   if ($iMonitoredFiles > 0 )
   {
      if ($iMonitoredFolders > 0)
      {
         print(":");
      }
      print("<a href=\"#\" class=\"cfiles1\">$iMonitoredFiles</a>");
   }
   if ($iMonitoredFolders > 0 or $iMonitoredFiles > 0)
   {
      print(")");
   }
   else
   {
      print("(<a href=\"#\" class=\"cfolders1\">$iMonitoredFolders</a>:<a href=\"#\" class=\"cfiles1\">$iMonitoredFiles</a>)");
   }


   print("<br></br></td>\n");
   print("</tr>\n");

   if($iQuotaMax <> 0) 
   {
      $iPercent = round(($iQuotaCurrent / $iQuotaMax), 1) * 100;
      if ($iPercent > 100)
      {
         $iPercent = 100;
      }

      print("<tr><td class=\"stats3\" colspan=\"6\">");
      if($iQuotaMax <> 0) 
      {
         print("<img src=\"$default->owl_graphics_url/$default->sButtonStyle/ui_icons/quota_$iPercent.gif\" border=\"0\"\" alt=\"$owl_lang->disk_quota: $iPercent%\"></img>");
      }
      else
      {
         print("&nbsp;");
      }
   
      if($iQuotaMax <> 0) 
      {
         print("&nbsp;$owl_lang->disk_quota:&nbsp;");
      }
      else
      {
         print("&nbsp;");
      }
      if($iQuotaMax <> 0) 
      {
         print("(" .  gen_filesize($iQuotaCurrent) ." / ".  gen_filesize($iQuotaMax) .")");
      }
      else
      {
         print("&nbsp;");
      }
      print("<br></br></td></tr>\n");
   }



   print("<tr><td class=\"stats3\" colspan=\"6\"><b>$owl_lang->tot_files</b>&nbsp;$iTotalFileCount<br></br></td></tr>\n");
   print("<tr><td class=\"stats3\" colspan=\"6\">");
   if($iNewsCount > 0) 
   {
      print("<img src=\"$default->owl_graphics_url/$default->sButtonStyle/ui_icons/news.gif\" border=\"0\" alt=\"$owl_lang->alt_have_news\" title=\"$owl_lang->alt_have_news\"></img>");
   }
   else
   {
      print("<img src=\"$default->owl_graphics_url/$default->sButtonStyle/ui_icons/news.gif\" border=\"0\" alt=\"$owl_lang->alt_have_no_news\" title=\"$owl_lang->alt_have_no_news\"></img>");
   }
   print("&nbsp;");
   if($iNewsCount > 0) 
   {
      if($default->allow_popup ) 
      {
         print("<a class=\"lstats1\" href=" . '"#" onclick="' . "window.open('readnews.php?sess=$sess', 'NewsWindow', 'status=no,directories=no,scrollbars=yes,title=yes,menubar=no,resizable=yes,toolbar=no,location=no,width=400,height=480');" . '"' . " title=\"$owl_lang->alt_have_news\"" . '>' . "$owl_lang->news_hd:</a>");
      } 
      else 
      {
         print("<a href=\"readnews.php?sess=$sess\">$owl_lang->news_hd:</a>");
      }
   } 
   else 
   {
      print("<a class=\"lstats1\" href=\"#\" title=\"$owl_lang->alt_have_no_news\">$owl_lang->news_hd:</a>");
   }


   print("&nbsp;");
   print($iNewsCount);
   print("<br></br></td></tr>\n");
   print("</table>\n");
   print("</td>\n");
   print("<td>\n");
   fPrintButtonSpace(1, 100);
   print("</td>\n");
 
   // *********************************
   // NEWS Panel  BEGIN
   // *********************************
   if(count($aNews) > 0)
   {
      print("<td width=\"50%\" valign=\"top\" align=\"left\">");
      print("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n");
      print("<tr><td class=\"stats1\">$owl_lang->news_hd<br></br></td></tr>\n");
  
      foreach ($aNews as $news)
      {
         print("<tr>\n");
         print("<td class=\"stats2\">");
  
         if($default->allow_popup ) 
         {
            print("\n<a  class=\"lstats1\" href=\"#\" onclick=\"window.open('readnews.php?sess=$sess', 'NewsWindow', 'status=no,directories=no,scrollbars=yes,title=yes,menubar=no,resizable=yes,toolbar=no,location=no,width=400,height=480');\"  onmouseover=" . '"' . "return makeTrue(domTT_activate(this, event, 'statusText', ' ', 'caption', '" . $news[news_title] . "', 'content', '" . fCleanDomTTContent($news[news]). "', 'trail', true));" . '"');
         }
         else
         {
  
           print("<a class=\"lstats1\" href=\"readnews.php?sess=$sess\"");
         }
         print(">$news[news_title]</a>\n");
         print("</td>\n");
         print("</tr>\n");
      }
      print("</table>\n");
   }
   // *********************************
   // NEWS Panel  END
   // *********************************

   // *********************************
   // PEER Review Panel  BEGIN
   // *********************************

   if ($default->document_peer_review == 1)
   {
      print("<td width=\"100%\" valign=\"top\" align=\"left\">");
      print("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n");
      print("<tr><td class=\"stats1\"colspan=\"2\">Document Peer Review<br></br></td></tr>\n");
     
      print("<tr>\n");
      print("<td class=\"stats2\">");	

      if ($iWaitingApproval > 0 )
      {
         print ("<a class=\"lstats1\" href=\"showrecords.php?sess=$sess&amp;type=wa&amp;expand=$expand\" title=\"$owl_lang->alt_my_approval\">$owl_lang->peer_my_approval</a>:");
      }
      else
      {
         print ($owl_lang->peer_my_approval .":");
      }
      print(" $iWaitingApproval</td>\n");
      print("<td class=\"stats2\">");
      if ($iMyPendingDocs > 0 )
      {
         print ("<a class=\"lstats1\" href=\"showrecords.php?sess=$sess&amp;type=pa&amp;expand=$expand\" title=\"$owl_lang->alt_pending_approval\">$owl_lang->peer_pending_approval</a>:");
      }
      else
      {
         print ($owl_lang->peer_pending_approval .":");
      }
      print(" $iMyPendingDocs</td>\n");
      print("</tr>\n");
      print("</table>\n");
   }

   // *********************************
   // PEER Review Panel  BEGIN
   // *********************************

   print("</td></tr>\n");
   print("</table>\n");
   print("</td></tr></table>\n");
   print("<!-- END: File Stats -->\n");
}


function fPrintBulkButtons($where = 0)
{
   global $default, $sess, $order, $usergroupid, $owl_lang, $parent, $expand, $order, $sortname, $sortorder;
   
// V4B RNG Start
   $urlArgs = array();
   $urlArgs['sess']      = $sess;
   $urlArgs['parent']    = $parent;
   $urlArgs['expand']    = $expand;
   $urlArgs['order']     = $order;
   $urlArgs['sort']  = $sortname;
   $urlArgs['sortorder']  = $sortorder;
// V4B RNG End


   if ( (($default->show_bulk == 1 or $default->show_bulk == 3) and $where == 0) or (fIsAdmin() and $default->show_bulk == 0))
   {
      print("<form name=\"FileList\" enctype=\"multipart/form-data\" action=\"dbmodify.php\" method=\"post\" onsubmit=\"return checkform();\">\n");
      print fGetHiddenFields ($urlArgs);
      print("<table class=\"margin2\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
      print("<tr>\n<td align=\"left\" valign=\"top\">\n");
      print("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
      print("<tr>\n");
      if ($default->owl_use_fs)
      {
         print("<td>");
         fPrintSubmitButton($owl_lang->btn_bulk_download, $owl_lang->alt_btn_bulk_download, "submit", "bdlaction_x");
         print("</td>\n");
      }
      print("<td>");
      fPrintSubmitButton($owl_lang->btn_bulk_move, $owl_lang->alt_btn_bulk_move, "submit", "bmoveaction_x");
      print("</td>\n");
      print("<td>");
      fPrintSubmitButton($owl_lang->btn_bulk_email, $owl_lang->alt_btn_bulk_email, "submit", "bemailaction_x");
      print("</td>\n");
      print("<td>");
      fPrintSubmitButton($owl_lang->btn_bulk_delete, $owl_lang->alt_btn_bulk_delete, "submit", "bdeleteaction_x", $owl_lang->reallydelete_selected);
      print("</td>\n");
      if ($default->owl_version_control == 1)
      {
         print("<td>");
         fPrintSubmitButton($owl_lang->btn_bulk_checkout, $owl_lang->alt_btn_bulk_checkout, "submit", "bcheckout_x");
         print("</td>\n");
      }
      print("<td class=\"fbuttonfill1\" width=\"100%\">");
      fPrintButtonSpace(1, 1);
      print("<br /></td>\n");
      print("</tr>\n");
      print("</table>\n");
      print("</td></tr>\n");
      print("</table>\n");
   }

   if ( ($default->show_bulk == 2) and $where == 0)
   {
      print("<form name=\"FileList\" enctype=\"multipart/form-data\" action=\"dbmodify.php\" method=\"post\" onsubmit=\"return checkform();\">\n");
      print fGetHiddenFields ($urlArgs);
      //print("<table class='margin2' cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
   }

   if ( ($default->show_bulk == 2 or $default->show_bulk == 3) and $where == 1)
   {
      print("<table class=\"margin2\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
      print("<tr>\n<td align=\"left\" valign=\"top\">\n");
      print("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
      print("<tr>\n");
      print("<td>");
      fPrintSubmitButton($owl_lang->btn_bulk_download, $owl_lang->alt_btn_bulk_download, "submit", "bdlaction_x");
      print("</td>\n");
      print("<td>");
      fPrintSubmitButton($owl_lang->btn_bulk_move, $owl_lang->alt_btn_bulk_move, "submit", "bmoveaction_x");
      print("</td>\n");
      print("<td>");
      fPrintSubmitButton($owl_lang->btn_bulk_email, $owl_lang->alt_btn_bulk_email, "submit", "bemailaction_x");
      print("</td>\n");
      print("<td>");
      fPrintSubmitButton($owl_lang->btn_bulk_delete, $owl_lang->alt_btn_bulk_delete, "submit", "bdeleteaction_x", $owl_lang->reallydelete_selected);
      print("</td>\n");
      print("<td class=\"fbuttonfill1\" width=\"100%\">");
      fPrintButtonSpace(1, 1);
      print("<br></br></td>\n");
      print("</tr>\n");
      print("</table>\n");
      print("</td></tr>\n");
      print("</table>\n");
   }

   
   //if ($default->show_bulk > 0 or (fIsAdmin() and $default->show_bulk == 0))
   if ($where == 1 or (fIsAdmin() and $default->show_bulk == 0 and $where == 1))
   { 
      print("</form>\n");
   }
}

function fPrintActionButtons( $sequence = 0 )
{
   global $default, $sess, $order, $parent, $sort, $expand, $url, $usergroupid, $owl_lang;

   $urlArgs = array();
   $urlArgs['sess']      = $sess;
   $urlArgs['expand']    = $expand;
   $urlArgs['order']     = $order;
   $urlArgs['sortorder'] = $sort;
                                                                                                                                                                                                  

   print("<table class=\"margin2\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\"><tr><td align=\"left\" valign=\"top\">\n");
   print("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
   print("<tr>\n");
   // Add Folder Button
   $urlArgs2 = $urlArgs;
   $urlArgs2['action'] = "folder_create";
   $urlArgs2['parent'] = $parent;
   $url = fGetURL ('modify.php', $urlArgs2);
   fPrintButton("$url", "btn_add_folder", "$sequence");

   // Add Archive Button
   if (function_exists('gzopen'))
   {
      $urlArgs2 = $urlArgs;
      $urlArgs2['action'] = "zip_upload";
      $urlArgs2['parent'] = $parent;
      $url = fGetURL ('modify.php', $urlArgs2);
      fPrintButton("$url", "btn_add_zip", "$sequence");
   }

   // Add Document Button
   $urlArgs2 = $urlArgs;
   $urlArgs2['parent'] = $parent;
   $urlArgs2['action'] = "file_upload";
   $url = fGetURL ('modify.php', $urlArgs2);
   fPrintButton("$url", "btn_add_file", "$sequence");

   // Add URL Button
   $urlArgs2 = $urlArgs;
   $urlArgs2['action'] = "file_upload";
   $urlArgs2['parent'] = $parent;
   $urlArgs2['type'] = "url";
   $url = fGetURL ('modify.php', $urlArgs2);
   fPrintButton("$url", "btn_add_url", "$sequence");

   // Add Note Button
   $urlArgs2 = $urlArgs;
   $urlArgs2['action'] = "file_upload";
   $urlArgs2['parent'] = $parent;
   $urlArgs2['type'] = "note";
   $url = fGetURL ('modify.php', $urlArgs2);
   fPrintButton("$url", "btn_add_note", "$sequence");

   //print("\t<td class='button1' background='$default->owl_graphics_url/$default->sButtonStyle/ui_misc/button1_fill.jpg' width='100%'><a class='lbutton1' href='#'><br></br></a></td>\n");
   print("\t<td class=\"button1\" width=\"100%\"><a class=\"lbutton1\" href=\"#\"><br></br></a></td>\n");


   if ($expand == 1)
   {
      $urlArgs2 = $urlArgs;
      $urlArgs2['parent'] = $parent;
      $urlArgs2['expand'] = "0";
      $url = fGetURL ('browse.php', $urlArgs2);
                                                                                                                                                                             
      fPrintButton("$url", "btn_collapse_view", "$sequence");
   }
   else
   {
      $urlArgs2 = $urlArgs;
      $urlArgs2['parent'] = $parent;
      $urlArgs2['expand'] = "1";
      $url = fGetURL ('browse.php', $urlArgs2);
   
      fPrintButton("$url", "btn_expand_view", "$sequence");
   }

   print("</tr>\n");
   print("</table>\n");
   print("</td>\n</tr>\n</table>\n");
}

function fPrintFolderTools ($nextfolders = 0, $nextfiles = 0, $bDisplayFiles, $iFileCount = 0, $iCurrentPage = 0) 
{
   global $iUpdatedFileCount, $iNewFileCount, $iMyFileCount, $iTotalFileCount, $iQuotaCurrent, $iQuotaMax, $iNewsCount;
   global $iMyCheckedOutCount, $iGroupFileCount, $usergroupid;
   global $iMonitoredFiles, $iMonitoredFolders ;
   global $default, $owl_lang, $sess, $expand, $userid, $lastlogin, $parent, $order, $sortname, $language, $sortorder, $sort;

 
   $urlArgs = array();
   $urlArgs['sess']      = $sess;
   $urlArgs['parent']    = $parent;
   $urlArgs['expand']    = $expand;
   $urlArgs['order']     = $order;

switch ($order)
{
   case "id":
      $urlArgs['id']  = $sort;
      break;
   case "name":
      $urlArgs['sortname']  = $sort;
      break;
   case "major_minor_revision":
      $urlArgs['sortver']  = $sort;
      break;
   case "filename" :
      $urlArgs['sortfilename']  = $sort;
      break;
   case "f_size" :
      $urlArgs['sortsize']  = $sort;
      break;
   case "creatorid" :
      $urlArgs['sortposted']  = $sort;
      break;
   case "smodified" :
      $urlArgs['sortmod']  = $sort;
      break;
   case "checked_out":
      $urlArgs['sortcheckedout']  = $sort;
      $order = "name";
      break;
}
   $iNewParent = owlfolderparent($parent);

   print fGetHiddenFields ($urlArgs);

   print("<table class=\"margin2\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\"><tr><td align=\"left\" valign=\"top\">\n");
   print("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n");
   print("<tr>\n");
    print("<td class=\"navbar1\">");
   if ($parent != $default->HomeDir)
   {
      $urlArgs3 = array();
      $urlArgs3['sess']      = $sess;
      $urlArgs3['parent']    = $iNewParent;
      $urlArgs3['expand']    = $expand;
      $urlArgs3['order']     = $order;
      $urlArgs3[$sortorder] = $sort;
      $sUrl = fGetURL ('browse.php', $urlArgs3);
                                                                                                                                                                                            
      print("<a href=\"$sUrl\" " . 'onmouseout="MM_swapImgRestore()" onmouseover="' . "MM_swapImage('folder_up','','$default->owl_graphics_url/$default->sButtonStyle/ui_nav/nav1_hover.gif',1)" .'"' .">");
      print("<img src=\"$default->owl_graphics_url/$default->sButtonStyle/ui_nav/nav1.gif\" alt=\"$owl_lang->title_return_folder " . fid_to_name($iNewParent) ."\" title=\"$owl_lang->title_return_folder ". fid_to_name($iNewParent) ."\" border=\"0\" name=\"folder_up\"></img></a>\n");
   }
   else
   {
      print("<a href=\"#\"><img border=\"0\" src=\"$default->owl_graphics_url/$default->sButtonStyle/ui_nav/nav1_dis.gif\" alt=\"\"></img></a>");
   }
   $urlArgs2 = $urlArgs;
   $urlArgs2['parent'] = $default->FirstDir;
   $sUrl = fGetURL ('browse.php', $urlArgs2);

   print("<br></br></td>\n");
   print("\t\t<td class=\"navbar1\">");
   print("<a href=\"$sUrl\" " . 'onmouseout="MM_swapImgRestore()" onmouseover="' . "MM_swapImage('home','','$default->owl_graphics_url/$default->sButtonStyle/ui_nav/nav2_hover.gif',1)" .'"' .">");
   print("<img src=\"$default->owl_graphics_url/$default->sButtonStyle/ui_nav/nav2.gif\" alt=\"$owl_lang->alt_home_folder\" title=\"$owl_lang->alt_home_folder\" border=\"0\" name=\"home\"></img></a>");
   print("<br></br></td>\n");

   $urlArgs2 = $urlArgs;
   $urlArgs2['parent'] = $parent;
   $urlArgs2['action'] = 'set_intial';
   $sUrl = fGetURL ('dbmodify.php', $urlArgs2);

   print("\t\t<td class=\"navbar1\" >");

   print("<a href=\"$sUrl\" " . 'onmouseout="MM_swapImgRestore()" onmouseover="' . "MM_swapImage('set_initial','','$default->owl_graphics_url/$default->sButtonStyle/ui_nav/nav3_hover.gif',1)" .'"' .">");
   print("<img src=\"$default->owl_graphics_url/$default->sButtonStyle/ui_nav/nav3.gif\" alt=\"$owl_lang->alt_set_initial_dir\" title=\"$owl_lang->alt_set_initial_dir\" border=\"0\" name=\"set_initial\"></img></a>");
   print("<br></br></td>\n");
                                                                                                                                                                                            
   print("\t\t<td class=\"navbar1\"><a class=\"lbutton1\" href=\"$default->owl_root_url/sitemap.php?sess=$sess&amp;expand=$expand&amp;order=$order&amp;$sortorder=$sort\" title=\"$owl_lang->alt_site_map\">$owl_lang->alt_site_map</a><br></br></td>\n");
                                                                                                                                                                                            
   print("\t\t<td class=\"navbar1\" width=\"100%\">&nbsp;<br></br></td>\n");

   if ($default->records_per_page > 0)
   {
       $iNumberOfPages = (int) $iFileCount / $default->records_per_page;
       
       if ( $iNumberOfPages > 0)
       {
               $urlArgs2 = $urlArgs;
               $urlArgs2['page'] = 1;
               $urlArgs2['bDisplayFiles'] = $bDisplayFiles;
               $sUrl = fGetURL ('browse.php', $urlArgs2);
    
      if ( $iNumberOfPages > 1)
      {
         print("<td class=\"navbar3\">\n");
         print("<a class=\"lnavbar1\" href=\"$sUrl\" title=\"$owl_lang->page 1\">&lt;&lt;</a><br></br>");
         print("</td>\n");
      }

      if ($iCurrentPage != 0) 
      {
      print("<td class=\"navbar3\">\n");
         $urlArgs2 = $urlArgs;
         $urlArgs2['prev'] = 1;
         $urlArgs2['nextfolders'] = $nextfolders;
         $urlArgs2['nextfiles'] = $nextfiles;
         $urlArgs2['bDisplayFiles'] = $bDisplayFiles;
         $urlArgs2['iCurrentPage'] = $iCurrentPage;
         $sUrl = fGetURL ('browse.php', $urlArgs2);

         print("<a class=\"lnavbar1\" href=\"$sUrl\" title=\"$owl_lang->alt_log_prev\">&lt;</a><br></br>");
      print("</td>\n");
      }

      $iNumberOfPages = (int) round($iNumberOfPages + 0.4999);
      if($iNumberOfPages > 1)
      {
         for ($c = 0; $c < $iNumberOfPages; $c++)
         {
            $iPrintC = $c + 1;
            print("<td class=\"navbar3\">\n");
            $urlArgs2 = $urlArgs;
            $urlArgs2['page'] = $c;
            $urlArgs2['bDisplayFiles'] = $bDisplayFiles;
            $sUrl = fGetURL ('browse.php', $urlArgs2);
   
            if ($iCurrentPage == $c)
            {
               print("<b>$iPrintC&nbsp;</b>\n");
            }
            else
            {
               print("<a class=\"lnavbar1\" href=\"$sUrl\" title=\"$owl_lang->page $iPrintC\">$iPrintC</a>&nbsp;\n");
            }
            print("</td>\n");
         }
      }

      if ($iCurrentPage < ($iNumberOfPages - 1)) 
      {
         $urlArgs2 = $urlArgs;
         $urlArgs2['next'] = 1;
         $urlArgs2['nextfolders'] = $nextfolders;
         $urlArgs2['nextfiles'] = $nextfiles;
         $urlArgs2['bDisplayFiles'] = $bDisplayFiles;
         $urlArgs2['iCurrentPage'] = $iCurrentPage;
         $sUrl = fGetURL ('browse.php', $urlArgs2);

      print("<td class=\"navbar3\">\n");
      print("<a class=\"lnavbar1\" href=\"$sUrl\" title=\"$owl_lang->alt_log_next\">&gt;</a>&nbsp;\n");
      print("</td>\n");
      }
      $iCurrentPage++;
      $urlArgs2 = $urlArgs;
      $urlArgs2['page'] = $iPrintC - 1;
      $urlArgs2['bDisplayFiles'] = $bDisplayFiles;
      $sUrl = fGetURL ('browse.php', $urlArgs2);
   
      if ( $iPrintC > 1 ) 
      {
         print("<td class=\"navbar3\">\n");
         print("<a class=\"lnavbar1\" href=\"$sUrl\" title=\"$owl_lang->page " . $iPrintC . "\">&gt;&gt;</a>&nbsp;\n");
         print("</td>\n");
      }
      if ( $iNumberOfPages > 1 ) 
      {
         print("<td class=\"navbar2\">");
         print("$owl_lang->page <b>$iCurrentPage</b> / $iNumberOfPages\n");
      }
      print("<br></br></td>\n");
    }
   }

   print("</tr>\n");
   print("</table>\n");
   print("</td></tr></table>\n");
}


function fPrintSpacer()
{
   global $default;
   print("<!-- BEGIN: Spacer -->\n");
   print("<table class=\"margin2\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\"><tr><td align=\"left\" valign=\"top\">\n");
   print("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
   print("<tr><td class=\"spacer1\">");
   fPrintButtonSpace(12, 1);
   print("</td></tr>\n");
   print("</table>\n");
   print("</td></tr></table>\n");
   print("<!-- END: Spacer -->\n");
}

function fShowSiteMap($fid, $folder)
{
   global $owl_lang, $folderList, $fCount, $fDepth, $sess, $id, $default, $userid, $expand, $sort, $sortorder, $sortname, $order ;
   // If restricted view is in effect only show the folders you do have access to
   $showfolder = 1;
   if ($default->restrict_view == 1)
   {
      if (check_auth($fid, "folder_view", $userid) != 0 and $fid != 0)
      {
         $showfolder = 1;
      }
      else
      {
         $showfolder = 0;
      }
   }
   if ($showfolder == 1)
   {
      for ($c = 0 ;$c < ($fDepth-1) ; $c++)
      {
         print "<img src=\"$default->owl_graphics_url/$default->sButtonStyle/ui_misc/blank.gif\" width=\"16\" height=\"16\" align=\"top\" alt=\"\"></img>\n";
      }
      if ($fDepth) 
      {
         print "<img src=\"$default->owl_graphics_url/$default->sButtonStyle/ui_misc/link.gif\" align=\"top\" alt=\"\"></img>";
      }
 
      //if (check_auth($fid, "folder_modify", $userid) == 0 and check_auth($fid, "folder_upload", $userid) == 0)
      if (check_auth($fid, "folder_view", $userid) == 0)
      {
         $gray = 1; //       check for permissions
      }
 
      if ($gray)
      {
         print "<img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_filetype/folder_gray.gif\" align=\"top\" alt=\"\"></img>";
         print " <font color=\"silver\">$folder</font><br></br>\n";
      }
      else
      {
            print "<img src=\"$default->owl_graphics_url/$default->sButtonStyle/icon_filetype/folder_closed.gif\" align=\"top\" alt=\"\"></img>";
            print "&nbsp;<a class=\"lfile1\" href=\"$default->owl_root_url/browse.php?sess=$sess&amp;parent=$fid&amp;expand=$expand&amp;order=$order\" title=\"$owl_lang->title_return_folder $folder\">$folder</a><br></br>";
      }
   }  
   for ($c = 0; $c < $fCount; $c++)
   {
      if ($folderList[$c][2] == $fid)
      {
         $fDepth++; 
         fShowSiteMap($folderList[$c][0] , $folderList[$c][1]);
         $fDepth--;
      } 
   }
}
function printModifyHeader()
{
   global $owl_lang, $default, $sortorder, $userid, $sess, $parent, $expand, $order, $sortname, $language;
                                                                                                                                                                                                    
   // Ensure that the Id of the parent is valid
   if ($parent == 0)
   {
      $parent = 1;
   }
                                                                                                                                                                                                    
   print("<center>");
   if ($expand == 1)
   {
      print("<table class=\"border1\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"$default->table_expand_width\"><tr><td align=\"left\" valign=\"top\" width=\"100%\">\n");
   }
   else
   {
      print("<table class=\"border1\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"$default->table_collapse_width\"><tr><td align=\"left\" valign=\"top\" width=\"100%\">\n");
   }
   fPrintButtonSpace(12, 1);
   print("<br />\n");
   print("<table class=\"border2\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\"><tr><td align=\"left\" valign=\"top\" width=\"100%\">\n");
                                                                                                                                                                                                    
  if ($default->show_prefs == 1 or $default->show_prefs == 3)
  {
         fPrintPrefs("infobar1", "top");
  }
   fPrintButtonSpace(12, 1);
   print("<br />\n");
}

function fPrintAdminPanel($action)
{
   global $owl_lang, $sess, $default;

   print("<!-- BEGIN: Admin Panel -->\n");
   print("<table class=\"margin2\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\"><tr><td align=\"left\" valign=\"top\">\n");

   print("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n");
   print("<tr><td class=\"admin0\" width=\"100%\" colspan=\"20\">$owl_lang->alt_btn_admin</td></tr>\n");
   print("<tr>\n");
   if($action == "users")
   {
      print("\t<td class=\"abutton1\">&nbsp;</td>\n");
      print("\t<td class=\"abutton\">");
      print($owl_lang->btn_users_groups);
      print("</td>\n");
   }
   else
   {
      print("\t<td class=\"abutton1\">&nbsp;</td>\n");
      fPrintButton("index.php?sess=$sess&amp;action=users", "btn_users_groups");
   }
   
   if($action == "edhtml")
   {
      print("\t<td class=\"abutton1\">&nbsp;</td>\n");
      print("\t<td class=\"abutton\">&nbsp;");
      print($owl_lang->btn_html_prefs);
      print("</td>\n");
   }
   else
   {
      print("\t<td class=\"abutton1\">&nbsp;</td>\n");
      fPrintButton("index.php?sess=$sess&amp;action=edhtml", "btn_html_prefs");
   }
   
   
   if($action == "edprefs")
   {
      print("\t<td class=\"abutton1\">&nbsp;</td>\n");
      print("\t<td class=\"abutton\">&nbsp;");
      print($owl_lang->btn_site_features);
      print("</td>\n");
   }
   else
   {
      print("\t<td class=\"abutton1\">&nbsp;</td>\n");
      fPrintButton("index.php?sess=$sess&amp;action=edprefs", "btn_site_features");
   }
   
   if($action == "viewlog")
   {
      print("\t<td class=\"abutton1\">&nbsp;</td>\n");
      print("\t<td class=\"abutton\">&nbsp;");
      print($owl_lang->btn_log_viewer);
      print("</td>\n");
   }
   else
   {
      print("\t<td class=\"abutton1\">&nbsp;</td>\n");
      fPrintButton("log.php?sess=$sess", "btn_log_viewer");
   }
   
   if($action == "viewstats")
   {
      print("\t<td class=\"abutton1\">&nbsp;</td>\n");
      print("\t<td class=\"abutton\">&nbsp;");
      print($owl_lang->btn_statistics_viewer);
      print("</td>\n");
   }
   else
   {
      print("\t<td class=\"abutton1\">&nbsp;</td>\n");
      fPrintButton("stats.php?sess=$sess", "btn_statistics_viewer");
   }
   
   if($action == "newsadmin")
   {
      print("\t<td class=\"abutton1\">&nbsp;</td>\n");
      print("\t<td class=\"abutton\">&nbsp;");
      print($owl_lang->btn_news_admin);
      print("</td>\n");
   }
   else
   {
      print("\t<td class=\"abutton1\">&nbsp;</td>\n");
      fPrintButton("news.php?sess=$sess", "btn_news_admin");
   }
   
   if($action == "doctypes")
   {
      print("\t<td class=\"abutton1\">&nbsp;</td>\n");
      print("\t<td class=\"abutton\">&nbsp;");
      print($owl_lang->btn_doctype_admin);
      print("</td>\n");
   }
   else
   {
      print("\t<td class=\"abutton1\">&nbsp;</td>\n");
      fPrintButton("doctype.php?sess=$sess", "btn_doctype_admin");
   }
   
   if (file_exists($default->dbdump_path) && file_exists($default->gzip_path))
   {
      print("\t<td class=\"abutton1\">&nbsp;</td>\n");
      fPrintButton("index.php?sess=$sess&amp;action=backup", "btn_backup");
   }
   else
   {
      print("\t<td class=\"abutton0\">&nbsp;");
      print($owl_lang->btn_backup);
      print("</td>\n");
   }
   
   
   if ($default->collect_trash == 1)
   {
      $sql = new Owl_DB; //create new db connection
      $sql->query("SELECT name from $default->owl_folders_table where id = 1");
      $sql->next_record();
      $sRootFolderName = $sql->f("name");
      $iFileCounter = 0;
      if ($default->owl_use_fs)
      {
         if (is_dir($default->trash_can_location . "/" . $sRootFolderName) || is_dir($default->trash_can_location))
         {
            $Dir = @opendir($default->trash_can_location . "/" . $sRootFolderName);
            while ($file = @readdir($Dir))
            {
               $iFileCounter++;
            }
            if ($iFileCounter > 0)
            {
               print("\t<td class=\"abutton1\">&nbsp;</td>\n");
               fPrintButton("recycle.php?sess=$sess", "btn_trashcan");
            }
            else
            {
               print("\t<td class=\"abutton0\">&nbsp;</td>\n");
               print("\t<td class=\"abutton0\">&nbsp;");
               print($owl_lang->alt_recycle);
               print("</td>\n");
            }
         }
         else
         {
            print("\t<td class=\"abutton0\">&nbsp;</td>\n");
            print("\t<td class=\"abutton0\">&nbsp;");
            print($owl_lang->alt_recycle_not_found);
            print("</td>\n");
         }
      }
   }
   else
   {     
      print("\t<td class=\"abutton0\">&nbsp;</td>\n");
      print("\t<td class=\"abutton0\">&nbsp;");
      print($owl_lang->alt_recycle_disable);
      print("</td>\n");
   }
   
   print("\t<td class=\"abutton1\">&nbsp;");
   print("<a class=\"labutton1\" href=\"populate.php?sess=$sess\" onclick=\"return confirm('$owl_lang->confirm_initial_load');\" title=\"$owl_lang->alt_btn_initial_load\">$owl_lang->btn_initial_load</a>");
   print("</td>\n");
   print("\t<td class=\"abutton1\" width=\"100%\">&nbsp;</td>\n");
   print("</tr>\n");
   print("</table>\n");
   print("</td></tr></table>\n");
   print("<!-- END: Admin Panel -->\n");
}
?>
