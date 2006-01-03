<?php

/**
 * doctype.php
 * 
 * Author: Steve Bourgeois <owl@bozzit.com>
 * Project Founder: Chris Vincent <cvincent@project802.net>
 * 
 * Copyright (c) 1999-2005 The Owl Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 */

global $default;

require_once("../config/owl.php");
require_once("../lib/disp.lib.php");
require_once("../lib/owl.lib.php");
include_once("../lib/header.inc");
include_once("../lib/userheader.inc");


if (!fIsAdmin(true))
{
   die("$owl_lang->err_unauthorized");
}

$sql = new Owl_DB;

if(isset($btn_add_doctype_x))
{
   $action = "add_doctype";
}
if(isset($btn_del_doctype_x))
{
   $action = "del_doctype";
   
}

if(isset($btn_add_field_x))
{
   $action = "add_field";
}
if(isset($btn_upd_field_x))
{
   $action = "upd_field";
}
if(!isset($nid) or empty($nid))
{
   $nid = 0;
}

if ( $myaction == $owl_lang->cancel_button )
{
   $action ="";
}
// *******************************************
// Delete a Document Type From the Database
// *******************************************
//
if ($action == "del_doctype")
{
   $sql = new Owl_DB;
   $sql->query("select count(*) as doccount from $default->owl_files_table where doctype = '$doctype'");
   $sql->next_record();
   if ( $sql->f("doccount") == 0 )
   {
      $del = new Owl_DB;
      $del->query("delete from $default->owl_doctype_table where doc_type_id = '$doctype'");
      $del->query("delete from $default->owl_docfields_table where doc_type_id = '$doctype'");
      $del->query("delete from $default->owl_docfieldslabel_table where doc_field_id = '$doctype'");
      $nid = 0;
      $doctype = "";
   }
   else
   {
   printError($owl_lang->err_cant_del_doc_type);
   }
   $action = "";
}

// *******************************************
// Add a New Document Type
// *******************************************
//
if ( $action == "add_doctype")
{
   $message = "";

   if ( trim($doctype) == "")
   {
      printError($message);
   }
 
   $add = new Owl_DB;
   $add->query("INSERT INTO $default->owl_doctype_table  (doc_type_name) VALUES  ('$doctype')");
   $action = "";

   $doctype= $add->insert_id($default->owl_doctype_table, 'doc_type_id');
}

// *******************************************
// Delete a Field from a Document  Type 
// *******************************************
//

if ($action == "del_field")
{
   $del = new Owl_DB;
   $del->query("delete from $default->owl_docfields_table where id = '$nid'");
   $del->query("delete from $default->owl_docfieldslabel_table where doc_field_id = '$nid'");
   $nid = 0;
}

if ( $action == "upd_field" )
{
   $message = "";
   
   $field_name = ereg_replace(" ","_",$field_name);

   if ( trim($field_name) == "")
   {
      $message .= $owl_lang->err_field_name_req;
   }
    
   if ( trim($field_size) == "")
   {
      $message .= $owl_lang->err_field_size_req;
   }

   if ( trim($message) <> "" )
   {
      printError($message);
   }

   if (!isset($field_size) or empty($field_size))
   {
      $field_size = 0;
   }

   if (!isset($field_position) or empty($field_position))
   {
      $field_position = 0;
   }
 
   if (!isset($searchable) or empty($searchable))
   {
      $searchable = 0;
   }
 
   if (!isset($required) or empty($required))
   {
      $required = 0;
   }

   $add = new Owl_DB;

   $add->query("UPDATE $default->owl_docfields_table  set field_name =  '$field_name',  field_position = '$field_position', field_type = 'TEXT', field_values = '$field_values', field_size = '$field_size', searchable = '$searchable', required = '$required' WHERE id = '$fieldid'");

   $del = new Owl_DB;
   $del->query("delete from $default->owl_docfieldslabel_table where doc_field_id = '$fieldid'");

   $dir = dir($default->owl_LangDir);
   $dir->rewind();
                                                                                                                                                                                             
   while ($file = $dir->read())
   {
     if ($file != "." and $file != ".." and $file != "CVS" and $file != "favicon.ico")
     {
        if (trim($field_label[$file]) == "")
        {
           $field_label[$file] = "Not Set";
        }    
        $add->query("INSERT INTO $default->owl_docfieldslabel_table  (doc_field_id, field_label, locale) values  ('$fieldid', '$field_label[$file]', '$file')");
     }
   }
   $dir->close();


   $action = "";
}

if ( $action == "add_field" )
{

   $message = "";

   $field_name = ereg_replace(" ","_",$field_name);

   if ( trim($field_label) == "")
   {
      $message .= $owl_lang->err_field_label_req;
   }
   if ( trim($field_size) == "")
   {
      $message .= $owl_lang->err_field_size_req;
   }

   if ( trim($message) <> "" )
   {
      printError($message);
   }
  
   if (!isset($field_size) or empty($field_size))
   {
      $field_size = 0;
   }

   if (!isset($field_position) or empty($field_position))
   {
      $field_position = 0;
   }

   if (!isset($searchable) or empty($searchable))
   {
      $searchable = 0;
   }

   if (!isset($required) or empty($required))
   {
      $required = 0;
   }



   $add = new Owl_DB;
   $add->query("INSERT INTO $default->owl_docfields_table  (doc_type_id, field_name, field_position, field_type, field_values, field_size, searchable, required) values  ('$doctype', '$field_name', '$field_position', 'TEXT', '$field_values', '$field_size', '$searchable', '$required')");

   $fieldid= $add->insert_id($default->owl_docfields_table, 'id');


   $dir = dir($default->owl_LangDir);
   $dir->rewind();
                                                                                                                                                                                             
   while ($file = $dir->read())
   {
     if ($file != "." and $file != ".." and $file != "CVS" and $file != "favicon.ico")
     {
        if (trim($field_label[$file]) == "")
        {
           $field_label[$file] = "Not Set";
        }
        $add->query("INSERT INTO $default->owl_docfieldslabel_table  (doc_field_id, field_label, locale) values  ('$fieldid', '$field_label[$file]', '$file')");
     }
   }
   $dir->close();

   $action = "";
}

print("<center>");
print("<table class='border1' cellspacing='0' cellpadding='0' border='0' width='$default->table_expand_width'>\n<tr>\n<td align='left' valign='top' width='100%'>\n");
fPrintButtonSpace(12, 1);
print("<br />\n");
print("<table class='border2' cellspacing='0' cellpadding='0' border='0' width='100%'><tr><td align='left' valign='top' width='100%'>\n");
                                                                                                                                                                                                 
if ($default->show_prefs == 1 or $default->show_prefs == 3)
{
   fPrintPrefs("infobar1", "top");
}

fPrintButtonSpace(12, 1);
print("<br />\n");
 
fPrintAdminPanel("doctypes");



if ( $doctype == "add_doctype" )
{
   print("<form enctype='multipart/form-data' action='" . $_SERVER["PHP_SELF"] ."' method='post'>
         <input type='hidden' name='sess' value='$sess'></input>
         <input type='hidden' name='action' value='add_doctype'></input>");
print("<table class='margin2' cellspacing='0' cellpadding='0' border='0' width='100%'><tr><td align='left' valign='top'>\n");
print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>");
print("<tr><td class='admin0' width='100%' colspan='6'>$owl_lang->doc_administration</td></tr>\n");
   fPrintFormTextLine($owl_lang->document_type_name . ":", "doctype", 30);
   print("<tr>\n");
   print("<td class='form2' width='100%' colspan='2'>\n");
   fPrintSubmitButton($owl_lang->btn_create, $owl_lang->alt_new_doctype, "submit", "btn_add_doctype_x");
   fPrintSubmitButton($owl_lang->cancel_button, $owl_lang->alt_cancel, "submit", "myaction");
   print("</td>\n</tr>\n");      
   //print("</form>\n");
}
else
{
   print("<form enctype='multipart/form-data' action='" . $_SERVER["PHP_SELF"] ."' method='post'>
         <input type='hidden' name='sess' value='$sess'></input>");
print("<table class='margin2' cellspacing='0' cellpadding='0' border='0' width='100%'><tr><td align='left' valign='top'>\n");
print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>");
print("<tr><td class='admin0' width='100%' colspan='6'>$owl_lang->doc_administration</td></tr>\n");

                                                                                                                      
   $sql = new Owl_DB;
   $fieldlabel = new Owl_DB;
   $sql->query("SELECT * from $default->owl_doctype_table");
                                                                                                                        
   print("<tr>\n");
   print("<td class='form1'>$owl_lang->document_type:</td>\n");
   print("<td class='form1' width='100%'>");
   print("<select class='fpull1' name='doctype' size='1' onchange='javascript:this.form.submit();'>\n");

//print("$owl_lang->document_type:<SELECT NAME=doctype onchange='javascript:this.form.submit();'>");
                                                                                                                      
   while ($sql->next_record())
   {
      print("<option value='" . $sql->f("doc_type_id") . "'");
      if ( $sql->f("doc_type_id") == $doctype )
      {
         print(" selected='selected'");
      }
      print(">" . $sql->f("doc_type_name") . "</option>\n");
   }
   print("<option value='add_doctype'>$owl_lang->doc_new_doc_type</option>\n</select></td></tr>");

   if ( $doctype  > 1 )
   {
 
      if ($action == "edit_field")
      {
         $sql->query("SELECT * from $default->owl_docfields_table where id = '$nid'");
         $sql->next_record();
      }
      print("<form enctype= 'multipart/form-data' action='" . $_SERVER["PHP_SELF"] ."' method='post'>
            <input type='hidden' name='sess' value='$sess'></input>
            <input type='hidden' name='doctype' value='$doctype'></input>");
   
      if ($action == "edit_field")
      {
         print("<input type='hidden' name='action' value='upd_field'></input>");
         print("<input type='hidden' name='fieldid' value='".$sql->f("id") ."'></input>");
      }
      else
      {
         print("<input type='hidden' name='action' value='add_field'></input>");
      }

      fPrintFormTextLine($owl_lang->doc_field_name . ":", "field_name", 15, $sql->f("field_name"));
      fPrintFormTextLine($owl_lang->doc_field_pos . ":", "field_position", 3, $sql->f("field_position"));
      print("<tr>\n");
      print("<td class='form1'>$owl_lang->doc_field_label:</td>\n");
      print("<td class='form1' width='100%'>");


         $dir = dir($default->owl_LangDir);
         $dir->rewind();
print("<table>");       
         while ($file = $dir->read())
         {
            if ($file != "." and $file != ".." and $file != "CVS" and $file != "favicon.ico")
            {
               print("<tr>\n");
               print("<td class='form1'>$file</td>\n");
               $fieldlabel->query("SELECT * from $default->owl_docfieldslabel_table where doc_field_id ='$nid' and locale = '$file'");
               $fieldlabel->next_record();
               print("<td class='form1' width='100%'><input class='finput1' type='text' name='field_label[$file]' size='20' maxlength='255' value='".$fieldlabel->f("field_label") ."'></input>");
               //print("<td align=left><INPUT TYPE=TEXT NAME=field_label[$file] SIZE=20 VALUE='" .  $fieldlabel->f("field_label") ."'></td>\n");
               print("</tr>\n");
            }
         }
         $dir->close();
print("</table>");       
//print("</form>");       

      print("</td>\n");
      print("</tr>\n");
       
      fPrintFormTextLine($owl_lang->doc_field_size . ":", "field_size", 5, $sql->f("field_size"));
      if ( $sql->f("searchable") == 1 )
      {
         fPrintFormCheckBox($owl_lang->doc_field_searchable, "searchable", "1", "checked");
      }
      else
      {
         fPrintFormCheckBox($owl_lang->doc_field_searchable, "searchable", "1");
      }
      if ( $sql->f("required") == 1 )
      {
         fPrintFormCheckBox($owl_lang->doc_field_required, "required", "1", "checked");
      }
      else
      {
         fPrintFormCheckBox($owl_lang->doc_field_required, "required", "1");
      }

      if ($action == "edit_field")
      {
         print("<tr>\n");
         print("<td class='form2' width='100%' colspan='2'>\n");
         fPrintSubmitButton($owl_lang->change, $owl_lang->alt_upd_field, "submit", "btn_upd_field_x");
      }
      else
      {
         print("<tr>\n");
         print("<td class='form2' width='100%' colspan='2'>\n");
         fPrintSubmitButton($owl_lang->btn_add_field, $owl_lang->alt_add_field, "submit", "btn_add_field_x");
         fPrintSubmitButton($owl_lang->btn_deldoctype, $owl_lang->alt_del_doctype, "submit", "btn_del_doctype_x");
      }
      fPrintSubmitButton($owl_lang->btn_reset, $owl_lang->alt_reset_form, "reset");

      print("</td></tr>");

   }
   print("</table>\n");
   //print("</form>");
 

   if (!isset($doctype) or empty($doctype))
   {
      $doctype = 0;
   }

   $sql->query("SELECT * from $default->owl_docfields_table where doc_type_id = '$doctype' order by field_position");

   fPrintButtonSpace(12, 1);

   if ($sql->num_rows() > 0)
   {
      print("<table class='margin2' cellspacing='0' cellpadding='0' border='0' width='100%'><tr><td align='left' valign='top'>\n");
      print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>");
      print("<tr>\n");
      print("<td class='title1'>&nbsp;</td>\n");
      print("<td class='title1'>$owl_lang->doc_field_name</td>\n");
      print("<td class='title1'>$owl_lang->doc_field_pos</td>\n");
      //print("<td class='title1' nowrap>FIELD TYPE</td>\n");
      //print("<td class='title1' nowrap>FIELD VAL</td>\n");
      print("<td class='title1'>$owl_lang->doc_field_label</td>\n");
      print("<td class='title1'>$owl_lang->doc_field_size</td>\n");
      print("<td class='title1'>$owl_lang->doc_field_searchable</td>\n");
      print("<td class='title1'>$owl_lang->doc_field_required</td>\n");
      print("</tr>\n");
      $CountLines = 0;
      while ($sql->next_record())
      {
         $CountLines++;
         $PrintLines = $CountLines % 2;
         if ($PrintLines == 0)
         {
            $sTrClass = "file1";
            $sLfList = "lfile1";
         }
         else
         {
            $sTrClass = "file2";
            $sLfList = "lfile1";
         }
         print("<tr><td class='$sTrClass'><a href='doctype.php?&amp;sess=" . $sess . "&amp;action=edit_field&amp;doctype=$doctype&amp;nid=" . $sql->f("id") . "'><img src='$default->owl_graphics_url/$default->sButtonStyle/icon_action/edit.gif' alt='$owl_lang->alt_edit_field' title='$owl_lang->alt_edit_field' border='0'></img></a>");
         print("&nbsp;<a href='doctype.php?&amp;sess=" . $sess . "&amp;action=del_field&amp;doctype=$doctype&amp;nid=" . $sql->f("id") . "' onclick='return confirm(\"$owl_lang->reallydelete " . $sql->f("field_name") . " ?\");'><img src='$default->owl_graphics_url/$default->sButtonStyle/ui_misc/delete.gif' alt='$owl_lang->alt_del_field' title='$owl_lang->alt_del_field' BORDER='0'></img></a></td>");
         print("<td class='$sTrClass' align='left'>" .  $sql->f("field_name") ."</td>\n");
         print("<td class='$sTrClass' align='left'>" .  $sql->f("field_position") ."</td>\n");


         $fieldlabel->query("SELECT * from $default->owl_docfieldslabel_table where doc_field_id ='" . $sql->f("id") ."' order by locale");

         print("<td align='left'><table width='100%'>");
         $SubTableCountLines = 0;
         while ( $fieldlabel->next_record() )
         {
            $SubTableCountLines++;
            $PrintLines = $SubTableCountLines % 2;
            if ($PrintLines == 0)
            {
              $sTrClass = "file1";
              $sLfList = "lfile1";
            }
            else
            {
               $sTrClass = "file2";
               $sLfList = "lfile1";
            }

            print("<td class='$sTrClass' width='10%'>" . $fieldlabel->f("locale") . ": </td>"); 
            print("<td class='$sTrClass' width='90%'>" . $fieldlabel->f("field_label") . "</td>"); 
            print("</tr>");
         }
         print("</table>\n");


         print("</td>\n");
         print("<td class='$sTrClass' align='right'>" .  $sql->f("field_size") ."</td>\n");

         if ($sql->f("searchable") == 1)
         {
            print("<td class='$sTrClass' align='center'>Yes</td>\n");
         }
         else
         {
            print("<td class='$sTrClass' align='center'>No</td>\n");
         }
      
         if ($sql->f("required") == 1)
         {
            print("<td class='$sTrClass' align='center'>Yes</td>\n");
         }
         else
         {
            print("<td class='$sTrClass' align='center'>No</td>\n");
         }
   
         print("</tr>\n");
      }
      print("</table>");
      print("</table>\n");
   }
}

if ( $doctype === "add_doctype" )
{
   print("</td></tr></table>\n");
}

print("</td></tr></table>\n");
      print("</form>\n");

if ($default->show_prefs == 2 or $default->show_prefs == 3)
{
   fPrintPrefs("infobar2");
}
print("</td></tr></table>\n");

if (file_exists("./lib/footer.inc"))
{
   include("./lib/footer.inc");
}
else
{
   include("../lib/footer.inc");
}
?>
