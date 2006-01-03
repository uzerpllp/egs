<?php

require_once("../../../config/owl.php");
require_once("$default->owl_fs_root/lib/disp.lib.php");
require_once("$default->owl_fs_root/lib/owl.lib.php");
require_once("$default->owl_fs_root/lib/security.lib.php");
include_once("$default->owl_fs_root/lib/header.inc");
include_once("$default->owl_fs_root/lib/userheader.inc");

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
      $sort = "ASC";
      $order= "name";
      $sortorder= "sortname";
      break;
} 

   $urlArgs = array();
   $urlArgs['sess']      = $sess;
   $urlArgs['parent']    = $parent;
   $urlArgs['expand']    = $expand;
   $urlArgs['order']     = $order;
   $urlArgs[$sortorder] = $sortname;

   if(empty($expand))
   {
      $expand = $default->expand;
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
   print("<br />\n");
   print("<table class='border2' cellspacing='0' cellpadding='0' border='0' width='100%'><tr><td align='left' valign='top' width='100%'>\n");
                                                                                                                                                                                          
  if ($default->show_prefs == 1 or $default->show_prefs == 3)
  {
         fPrintPrefs();
  }
   fPrintButtonSpace(12, 1);
   print("<br />\n");
?>

<center><h1><?php echo $owl_lang->alt_btn_help ?></h1>
<img src="../../../graphics/rsdx_blue1/ui_misc/owl_logo1.gif" width="99" height="53" border="0" alt=""><br></center>
<hr>

<!-- Help Begins Here -->

<h2>Introduction</h2>
Owl is a multi user document repository or knowledge based system. Users are able to capture documents and assign attributes to them when the document is uploaded into the Owl system. Other users are then able to locate the documents either by using the hierarchy folder structure or by using the built in search facility.
<br>A document can be any type of electronic document or file that the user can access from their computer. Typically theses documents could be a word processing file, spreadsheet, or PDF files. But Owl is not just limited to common office file types you can capture most graphic file types, and display them within the system, audio and video or executable program files. In fact Owl is only limited by your imagination.Once documents have been captured by the owl system users have numerous options:
<ul><li>Ability to e-mail documents directly from Owl</li><li>Users can monitor documents or folders for updates and receive notification by e-mail</li><li>A Version Control System (VCS) can be used to track changes to documents, keep copies of old documents and provide a change log.</li><li>Users can add comments to individual documents</li></ul>

All these facilities are easily available through the use of an Internet Browser.

<h2>File Browser</h2>
The browser is the main method, which you will use to navigate the hierarchical folder structure and to find and use documents that have been captured into the system. You can carry out certain <i>actions</i> on folders and documents such as sorting the displayed order, viewing or downloading the document, or e-mailing the document to some one.

<h2>Folder Structure</h2>
Documents that are uploaded into the Owl system are stored in folders and each folder can have a series of sub folders. This type of structure is known as a hierarchical structure and is typically used for the storage and organization of files onyour computers hard drive. In Owl, the start point of the hierarchy (or root) is known as the <i>documents</i> folder.The folder structure allows a convenient way to group documents in a meaningful fashion. For instances you may wish to capture all your technical documents for a number of products. You could create a folder named technical documents and thena series of sub folders in side technical documents of each product. For this to work properly, you must chose sensible and descriptive folder names that provide the user with a reasonable description and meaning.

<h3>Title Bar</h3>

<table  style="width: 100%; text-align: left;" border="0" cellpadding="2"
 cellspacing="2">
<tr>
 <td><?php echo $owl_lang->doc_number ?></td>
 <td>The specific number of the document.</td>
</tr>
<tr>
 <td><?php echo $owl_lang->title ?></td>
 <td>The title of the document or the folder.</td>
</tr>
<tr>
 <td><?php echo $owl_lang->ver  ?></td>
 <td>The version of the document or the folder. The number before the dot indicates big changes whereas the number after the dot indicates small modifications.</td>
</tr>
<tr>
 <td><?php echo $owl_lang->file ?></td>
 <td>The title of the document or the folder.</td>
</tr>
<tr>
 <td><?php echo $owl_lang->size ?></td>
 <td>The title of the document or the folder.</td>
</tr>
<tr>
 <td><?php echo $owl_lang->postedby ?></td>
 <td>The user who posted the file to the Owl Intranet System.</td>
</tr>
<tr>
 <td><?php echo $owl_lang->modified ?></td>
 <td>The date and time of the last modification of the file.</td>
</tr>
<tr>
 <td><?php echo $owl_lang->held ?></td>
 <td>Here you see, who is actually holding and modifying the file. If somebody holds a file you cannot update it unless he checks it out again.</td>
</tr>
</table>


<h3><?php echo $owl_lang->actions ?></h3>
Actions provide functions for various tasks on folders and documents. The number of action icons, which are visible, will depend on your permissions for a folder and document.

<h4>Action Buttons</h4>
<table  style="width: 100%; text-align: left;" border="0" cellpadding="2"
 cellspacing="2">
<tr>
 <td><img src="../../../graphics/rsdx_blue1/icon_action/log.gif" width="17" height="20" border="0" alt=""> </td>
 <td><?php echo $owl_lang->alt_log_file ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/rsdx_blue1/icon_action/trash.gif" width="17" height="20" border="0" alt=""> </td>
 <td><?php echo $owl_lang->alt_del_file ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/rsdx_blue1/icon_action/edit.gif" width="17" height="20" border="0" alt=""> </td>
 <td><?php echo $owl_lang->alt_mod_file ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/rsdx_blue1/icon_action/link.gif" width="17" height="20" border="0" alt=""> </td>
 <td><?php echo $owl_lang->alt_link_file ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/rsdx_blue1/icon_action/copy.gif" width="16" height="16" border="0" alt=""> </td>
 <td><?php echo $owl_lang->alt_copy_file ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/rsdx_blue1/icon_action/move.gif" width="17" height="20" border="0" alt=""> </td>
 <td><?php echo $owl_lang->alt_move_file ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/rsdx_blue1/icon_action/update.gif" width="17" height="20" border="0" alt=""> </td>
 <td><?php echo $owl_lang->alt_upd_file ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/rsdx_blue1/icon_action/bin.gif" width="17" height="20" border="0" alt=""></td>
 <td><?php echo $owl_lang->alt_get_file ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/rsdx_blue1/icon_action/comment_dis.gif" width="17" height="20" border="0" alt=""></td>
 <td><?php echo $owl_lang->alt_add_comments ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/rsdx_blue1/icon_action/lock.gif" width="17" height="17" border="0" alt=""></td>
 <td><?php echo $owl_lang->alt_lock_file ?></td>
</tr>
<td><img src="../../../graphics/rsdx_blue1/icon_action/unlock.gif" width="16" height="16" border="0" alt=""></td>
 <td><?php echo $owl_lang->alt_unlock_file ?></td>
</tr>
<td><img src="../../../graphics/rsdx_blue1/icon_action/zip.gif" width="17" height="20" border="0" alt=""></td>
<td><?php echo $owl_lang->alt_btn_add_zip ?></td>
</tr>
<tr>
<td><img src="../../../graphics/rsdx_blue1/icon_action/newcomment.gif" width="17" height="20" border="0" alt=""></td>
 <td><?php echo $owl_lang->alt_add_comments ?></td>
</tr>
 <td><img src="../../../graphics/rsdx_blue1/icon_action/email.gif" width="17" height="20" border="0" alt=""></td>
 <td><?php echo $owl_lang->alt_email ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/rsdx_blue1/icon_action/related.gif" width="17" height="20" border="0" alt=""></td>
 <td><?php echo $owl_lang->alt_related ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/rsdx_blue1/icon_action/mag.gif" width="17" height="20" border="0" alt=""></td>
 <td><?php echo $owl_lang->alt_view_file ?></td>
</tr>
<td><img src="../../../graphics/rsdx_blue1/icon_action/play.gif" width="17" height="20" border="0" alt=""></td>
 <td><?php echo $owl_lang->alt_play_file ?></td>
</tr>
<td><img src="../../../graphics/rsdx_blue1/icon_action/monitor.gif" width="17" height="20" border="0" alt=""></td>
 <td><?php echo $owl_lang->alt_monitor ?></td>
</tr>
<td><img src="../../../graphics/rsdx_blue1/icon_action/print.gif" width="17" height="20" border="0" alt=""></td>
 <td><?php echo $owl_lang->alt_news_print ?></td>
</tr>
</table>

<h4>Bulk Buttons</h4>
<p>If activated these buttons let you do actions with more than one file at the same time.
</p>
<table style="width: 100%; text-align: left;" border="0" cellpadding="2"
 cellspacing="2">
    <tr>
      <td>
<table>
<td nowrap>
         <?php fPrintSubmitButton($owl_lang->btn_bulk_download, $owl_lang->alt_btn_bulk_download, "", "") ?>
         </td>
</table>
      </td>
      <td>Download selected files.<br>
      </td>
    </tr>
 <tr>
      <td>
<table>
<td nowrap>
         <?php fPrintSubmitButton($owl_lang->btn_bulk_move, $owl_lang->alt_btn_bulk_move, "", "") ?>
         </td>
</table>
      </td>
      <td>Move selected files to another folder.<br>
      </td>
    </tr>
 <tr>
      <td>
<table>
<td nowrap>
         <?php fPrintSubmitButton($owl_lang->btn_bulk_email, $owl_lang->alt_btn_bulk_email, "", "") ?>
         </td>
</table>
      </td>
      <td>E-mail selected files to somebody.<br>
      </td>
    </tr>
 <tr>
      <td>
<table>
<td nowrap>
         <?php fPrintSubmitButton($owl_lang->btn_bulk_delete, $owl_lang->alt_btn_bulk_delete, "", "") ?>
         </td>
</table>
      </td>
      <td>Delete selected files. Note that you cannot delete selected folders.<br>
      </td>
    </tr>
 <tr>
      <td>
<table>
<td nowrap>
         <?php fPrintSubmitButton($owl_lang->btn_bulk_checkout, $owl_lang->alt_btn_bulk_checkout, "", "") ?>
         </td>
</table>
      </td>
      <td>Checkout selected files. Note that no other user can modify a file that is checked out by another user.<br>
      </td>
    </tr>
</table>
<br>

<!-- Help Ends Here -->


<?php

      fPrintButtonSpace(12, 1);
                                                                                                                                                                                                    
      if ($default->show_prefs == 2 or $default->show_prefs == 3)
      {
         fPrintPrefs("infobar2");
      }
      print("</td></tr></table>\n");
      include("../../../lib/footer.inc");
      print("</td></tr></table>\n");
?>
