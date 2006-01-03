<?php

require_once("../../../config/owl.php");
require_once("$default->owl_fs_root/lib/disp.lib.php");
require_once("$default->owl_fs_root/lib/owl.lib.php");
require_once("$default->owl_fs_root/lib/security.lib.php");
include_once("$default->owl_fs_root/lib/header.inc");
include_once("$default->owl_fs_root/lib/userheader.inc");


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
<img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_misc/owl_logo1.gif" width="99" height="53" border="0" alt=""><br></center>
<hr>

<!-- Help Begins Here -->

<h3>Gefilterte Anzeige</h3>

Die Informationsbox im Dateibrowser ist anklickbar. In Abh&auml;ngigkeit <i>wonach Sie filtern</i> m&ouml;chten, werden
die Dateien in den m&ouml;glichen Kategorien aufgelistet.<br>Im oberen Teil der Tabelle k&ouml;nnen Sie selbstverst&auml;ndlich die Suchmaschine zur weiteren Eingrenzung benutzen.

<h3><? echo $owl_lang->panel_file_info ?></h3>

<table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="2">
<tr>
  <td width = 3%><img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_icons/new.gif" width="13" height="16" border="0" alt=""></td>
  <td><i><? echo $owl_lang->tot_new_files ?></i> Anzahl der neu hinzugekommenen Dateien.</td>
</tr>
<tr>
  <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_icons/my.gif" width="13" height="16" border="0" alt=""></td>
  <td><i><? echo $owl_lang->tot_my_files ?></i> Gesamtanzahl Ihrer eigenen Dateien im Owl.</td>
</tr>
<tr>
  <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/lock.gif" width="17" height="17" border="0" alt=""></td>
  <td><i><? echo $owl_lang->tot_my_checked_out ?></i> Gesamtanzahl Ihrer ausgecheckten Dateien im Owl.</td>
</tr>
<tr>
  <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_icons/updated.gif" width="13" height="16" border="0" alt=""></td>
  <td><i><? echo $owl_lang->tot_updated_files ?></i> Gesamtanzahl Ihrer aktualisierten Dateien im Owl.</td>
</tr>
<tr>
  <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_icons/group.gif" width="13" height="16" border="0" alt=""></td>
  <td><i><? echo $owl_lang->tot_my_group ?></i> Gesamtanzahl der Dateien, die Ihre Gruppe besitzt.</td>
</tr>
<tr>
  <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/monitored.gif" width="17" height="20" border="0" alt=""></td>
  <td><i><? echo $owl_lang->tot_monitored ?></i> Gesamtanzahl der Dateien, die durch Sie &uuml;berwacht werden.</td>
</tr>
<tr>
  <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_icons/quota_0.gif" width="17" height="24" border="0" alt=""></td>
  <td>Sie haben durch den Administrator eine Speicherplatzgrenze auferlegt bekommen, diese ist jedoch noch nicht erreicht. Sie k&ouml;nnen speichern.</td>
</tr>
<tr>
  <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_icons/quota_50.gif" width="17" height="24" border="0" alt=""></td>
  <td>Ihr zugeteilter Speicherplatzbedarf ist zu 50% ersch&ouml;pft. Die Abstufung erfolgt in 10%-Schritten:&nbsp;
        <img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_icons/quota_10.gif" width="17" height="24" border="0" alt="">
        <img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_icons/quota_20.gif" width="17" height="24" border="0" alt="">
        <img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_icons/quota_30.gif" width="17" height="24" border="0" alt="">
        <img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_icons/quota_40.gif" width="17" height="24" border="0" alt="">
        <img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_icons/quota_50.gif" width="17" height="24" border="0" alt="">
        <img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_icons/quota_60.gif" width="17" height="24" border="0" alt="">
        <img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_icons/quota_70.gif" width="17" height="24" border="0" alt="">
        <img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_icons/quota_80.gif" width="17" height="24" border="0" alt="">
        <img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_icons/quota_90.gif" width="17" height="24" border="0" alt="">
        <img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_icons/quota_100.gif" width="17" height="24" border="0" alt="">
  </td>
</tr>
<tr>
  <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_icons/quota_100.gif" width="17" height="24" border="0" alt=""></td>
  <td>Ihr Speicherplatz ist ersch&ouml;pft, kontaktieren Sie bitte den Systemadministrator. Sie k&ouml;nnen <b>nicht mehr speichern</b>.</td>
</tr>
<tr>
  <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_misc/transparent.gif" width="20" height="20" border="0" alt=""</td>
  <td><? echo $owl_lang->tot_files ?> Gesamtanzahl aller Dateien im Owl &uuml;ber alle Benutzer.</td>
</tr>
<tr>
  <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_icons/news.gif" width="13" height="16" border="0" alt=""></td>
  <td><i><? echo $owl_lang->news_hd ?></i> Anzahl, der f&uuml;r die Benutzer anstehenden Mitteilungen.</td>
</tr>

</table>

<h3><?php echo $owl_lang->actions ?></h3>
Aktionen bieten Funktionen f&uuml;r verschiedene Aufgaben, angewandt auf Verzeichnisse und Dokumente.<br>Die Anzahl der sichtbaren Aktionssymbole ist abhän&auml;gig von Ihren Berechtigungen f&uuml;r ein Verzeichnis und Dokument.

<h4>Aktions Kn&ouml;pfe</h4>
<table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="2">
<tr>
 <td width = 3%><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/log.gif" width="17" height="20" border="0" alt=""></td>
 <td><? echo $owl_lang->alt_log_file ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/trash.gif" width="17" height="20" border="0" alt=""></td>
 <td><? echo $owl_lang->alt_del_file ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/edit.gif" width="17" height="20" border="0" alt=""></td>
 <td><? echo $owl_lang->alt_mod_file ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/link.gif" width="17" height="20" border="0" alt=""></td>
 <td><? echo $owl_lang->alt_link_file ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/copy.gif" width="16" height="16" border="0" alt=""></td>
 <td><? echo $owl_lang->alt_copy_file ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/move.gif" width="17" height="20" border="0" alt=""></td>
 <td><? echo $owl_lang->alt_move_file ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/update.gif" width="17" height="20" border="0" alt=""></td>
 <td><? echo $owl_lang->alt_upd_file ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/bin.gif" width="17" height="20" border="0" alt=""></td>
 <td><? echo $owl_lang->alt_get_file ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/comment_dis.gif" width="17" height="20" border="0" alt=""></td>
 <td><? echo $owl_lang->alt_add_comments ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/lock.gif" width="17" height="17" border="0" alt=""></td>
 <td><? echo $owl_lang->alt_lock_file ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/unlock.gif" width="16" height="16" border="0" alt=""></td>
 <td><? echo $owl_lang->alt_unlock_file ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/zip.gif" width="17" height="20" border="0" alt=""></td>
 <td><? echo $owl_lang->alt_btn_add_zip ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/newcomment.gif" width="17" height="20" border="0" alt=""></td>
 <td><? echo $owl_lang->alt_add_comments ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/email.gif" width="17" height="20" border="0" alt=""></td>
 <td><? echo $owl_lang->alt_email ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/related.gif" width="17" height="20" border="0" alt=""></td>
 <td><? echo $owl_lang->alt_related ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/mag.gif" width="17" height="20" border="0" alt=""></td>
 <td><? echo $owl_lang->alt_view_file ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/play.gif" width="17" height="20" border="0" alt=""></td>
 <td><? echo $owl_lang->alt_play_file ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/monitor.gif" width="17" height="20" border="0" alt=""></td>
 <td><? echo $owl_lang->alt_monitor ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/print.gif" width="17" height="20" border="0" alt=""></td>
 <td><? echo $owl_lang->alt_news_print ?></td>
</tr>
</table>

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
