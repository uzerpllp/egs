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
<H3>"fuer Developer: ACTION: <?php print $action ?> "</H3>
<a name="top">
<h2>&Auml;ndern und Hochladen</h2>
<h3>&Uuml;bersicht</h3>

<!--Begin of Language Independent -->

<table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="2">
<tr>
<td width ="3%"><a href="#folder"><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_filetype/folder_closed.gif" width="16" height="16" border="0" alt=""></td></a>
        <td width ="50%"><a href="#folder"><li><? echo $owl_lang->alt_btn_add_folder ?></a></li></td><td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_icons/updated.gif" width="13" height="16" border="0" alt=""> <i><b><? echo $owl_lang->owl_log_hd_fld_path ?>&nbsp;</b><? echo $owl_lang->permissions ?></i>!</td></tr>
        <tr><td><a href="#zip"><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_filetype/zip.gif" width="17" height="20" border="0" alt=""></td></a><td><a href="#zip"><li><? echo $owl_lang->alt_btn_add_zip ?></a></li></td><td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_icons/updated.gif" width="13" height="16" border="0" alt=""> <i><b><? echo $owl_lang->file ?>&nbsp;</b><? echo $owl_lang->permissions ?></i><b> + <i><? echo $owl_lang->owl_log_hd_fld_path ?>&nbsp;</b><? echo $owl_lang->permissions ?></i>!</td></tr>
        <tr><td><a href="#file"><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_filetype/file.gif" width="17" height="20" border="0" alt=""></td></a><td><a href="#file"><li><? echo $owl_lang->alt_btn_add_file ?></a></li></td><td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_icons/updated.gif" width="13" height="16" border="0" alt=""> <i><b><? echo $owl_lang->file ?>&nbsp;</b><? echo $owl_lang->permissions ?></i>!</td></tr>
        <tr><td><a href="#url"><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_filetype/url.gif" width="17" height="20" border="0" alt=""></td></a><td><a href="#url"><li><? echo $owl_lang->alt_btn_add_url ?></a></li></td><td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_icons/updated.gif" width="13" height="16" border="0" alt=""> <i><b><? echo $owl_lang->file ?>&nbsp;</b><? echo $owl_lang->permissions ?></i>!</td></tr>
        <tr><td><a href="#note"><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_filetype/txt.gif" width="16" height="16" border="0" alt=""></td></a><td><a href="#note"><li><? echo $owl_lang->alt_btn_add_note ?></a></li></td><td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_icons/updated.gif" width="13" height="16" border="0" alt=""> <i><b><? echo $owl_lang->file ?>&nbsp;</b><? echo $owl_lang->permissions ?></i>!</td></tr>
</table>
<br>
<a name="folder">
<h3><? echo $owl_lang->alt_btn_add_folder ?>&nbsp;<a href ="#top"><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_filetype/folder_closed.gif" width="16" height="16" border="0" alt=""></h3></a>
<table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="2">
<tr>
  <td><i><? echo $owl_lang->current_folder ?>&nbsp;<? echo $owl_lang->addingfolder ?></i></td>

<!-- End of Language Independent -->

  <td>Hier wird das aktuelle Verzeichnis angezeigt, zu dem Sie ein weiteres Verzeichnis hinzuf&uuml;gen.</td>
</tr>
<tr>
  <td><i><? echo $owl_lang->folder_policy ?></i></td>
  <td>Hier werden die Benutzerrechte f&uuml;r dieses Verzeichnis angezeigt. Diese Mitteilung ist anklickbar und Sie gelangen zum Dialog f&uuml;r "<? echo $owl_lang->title_edit_prefs ?>".</td>
</tr>
<tr>
  <td><i><? echo $owl_lang->name ?></i></td>
  <td>Tragen Sie hier einen kurzen aussagekr&auml;ftigen Namen f&uuml;r das neu anzulegende Verzeichnis ein.</td>
 </tr>
<tr>
  <td><i><? echo $owl_lang->group ?></i></td>
  <td>W&auml;hlen Sie hier die prim&auml;re Gruppe aus, f&uuml;r die dieses Verzeichnis bestimmt ist.</td>
</tr>
<tr>
  <td><i><b><? echo $owl_lang->owl_log_hd_fld_path ?>&nbsp;</b><? echo $owl_lang->permissions ?></i></td>
  <td>W&auml;hlen Sie die zutreffende Berechtigungsstufe aus den folgenden M&ouml;glichkeiten aus:</td>
 </tr>
 <tr><td>&nbsp;</td>
  <td>
  <ul>
          <li><i><? echo $owl_lang->geveryoneread ?></i></li>
          <li><i><? echo $owl_lang->geveryonewrite ?></i></li>
          <li><i><? echo $owl_lang->ggroupread ?></i></li>
          <li><i><? echo $owl_lang->ggroupwrite ?></i></li>
          <li><i><? echo $owl_lang->gonlyyou ?></i></li>
          <li><i><? echo $owl_lang->ggroupwrite_ad_nod ?></i></li>
          <li><i><? echo $owl_lang->geveryonewrite_nod ?></i></li>
          <li><i><? echo $owl_lang->ggroupwrite_worldread_ad ?></i></li>
          <li><i><? echo $owl_lang->ggroupwrite_worldread_ad_nod ?></i></li>
  </ul>
  <b>&Uuml;berlegen Sie sich gut, welche Berechtigungen Sie geben!</b><p>
  </td>
 </tr>
 <tr>
   <td><i><? echo $owl_lang->newpassword ?></i></td>
   <td>Hier k&ouml;nnen Sie das neue Verzeichnis zus&auml;tzlich mit einem Passwort sch&uuml;tzen.</td>
 </tr>
<tr>
   <td><i><? echo $owl_lang->confpassword ?></i></td>
   <td>Die wiederholte Eingabe des Passwortes ist zwingend erforderlich, wenn Sie das Verzeichnis mit einem Passwort sch&uuml;tzen wollen.</td>
 </tr>
 <tr>
    <td><i><? echo $owl_lang->description ?></i></td>
    <td>Hier k&ouml;nnen Sie das neue Verzeichnis beschreiben. Beschreiben Sie in Kurzform, wozu es dient.</td>
 </tr>

</table>
<h4><? echo $owl_lang->create ?></h4>
Um das neue Verzeichnis zu aktivieren, klicken Sie auf &nbsp;"<? echo $owl_lang->create ?>". Wollen Sie Ihre Eintr&auml;ge verwerfen, klicken Sie auf &nbsp;"<? echo $owl_lang->btn_reset ?>".
<br>Das Owl setzt dann auf die voreingestellten Standardeintr&auml;ge zur&uuml;ck.
<p>
<div style="text-align: right;"><a href ="#top"><img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_nav/desc.gif" width="7" height="4" border="0" alt=""></a></div></p>

<a name="zip">
<h3><? echo $owl_lang->alt_btn_add_zip ?>&nbsp;<a href ="#top"><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_filetype/zip.gif" width="17" height="20" border="0" alt=""></h3></a>
<table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="2">
<tr>
  <td><i><? echo $owl_lang->current_folder ?>&nbsp;<? echo $owl_lang->addingfile ?></i></td>
  <td>Hier wird das aktuelle Verzeichnis angezeigt, zu dem Sie ein Archiv hinzuf&uuml;gen.</td>
</tr>
<tr>
  <td><i><? echo $owl_lang->folder_policy ?></i></td>
  <td>Hier werden die Benutzerrechte f&uuml;r dieses Verzeichnis angezeigt. Diese Mitteilung ist anklickbar und Sie gelangen zum Dialog f&uuml;r "<? echo $owl_lang->title_edit_prefs ?>".</td>
</tr>
<tr>
  <td><i><? echo $owl_lang->sendthisfile ?></i></td>
  <td>W&auml;hlen Sie hier von Ihrer Festplatte oder einem anderen Speicherort das Archiv (*.zip, *.rar, *.tar, etc.) aus, welches Sie in das Owl hochladen wollen.</td>
</tr>
<tr>
  <td><i><? echo $owl_lang->name ?></i></td>
  <td>Tragen Sie hier einen kurzen aussagekr&auml;ftigen Namen f&uuml;r ein neu anzulegendes Verzeichnis ein, in dem sich das Archiv entpacken soll.</td>
 </tr>
<tr>
<tr>
  <td><i><? echo $owl_lang->keywords ?></i></td>
  <td>Hier sollten Sie kurze aussagekr&auml;ftige  <? echo $owl_lang->keywords ?> eintragen. Das unten stehende Fenster zeigt Ihnen, welche <? echo $owl_lang->keywords ?> das Owl schon kennt.<br>
  Hilfreich ist das, wenn man sp&auml;ter nach verwandten Dokumenten im System suchen m&ouml;chte.<br>
  "<? echo $owl_lang->save_keywords_to_db ?>". Genau das wird ausgef&uuml;hrt, wenn man diese Checkbox setzt.</td>
 </tr>
<tr>
  <td><i><? echo $owl_lang->vermajor ?></i></td>
  <td>Hier k&ouml;nnen Sie eine Anfangsversionsnummer festlegen. Die Versionsnummer wird im Owl durch einen Punkt getrennt mitgef&uuml;hrt und bei der n&auml;chsten Aktualisierung automatisch erh&ouml;ht.</td>
</tr>
<tr>
  <td><i><? echo $owl_lang->verminor ?></i></td>
  <td>Die Ziffer vor dem Punkt deutet auf umfangreiche &Auml;nderungen hin, w&auml;hrend die Ziffer nach dem Punkt kleine  &Auml;nderungen des Dokuments oder Verzeichnisses anzeigt.</td>
</tr>
<tr>
  <td><i><? echo $owl_lang->group ?></i></td>
  <td>W&auml;hlen Sie hier die prim&auml;re Gruppe aus, f&uuml;r die dieses Verzeichnis bestimmt ist.</td>
</tr>
<tr>
  <td><i><b><? echo $owl_lang->file ?>&nbsp;</b><? echo $owl_lang->permissions ?></i></td>
  <td>W&auml;hlen Sie die zutreffende Berechtigungsstufe aus den folgenden M&ouml;glichkeiten aus:</td>
 </tr>
 <tr><td>&nbsp;</td>
  <td>
  <ul>
          <li><i><? echo $owl_lang->everyoneread ?></i></li>
          <li><i><? echo $owl_lang->everyonewrite ?></i></li>
          <li><i><? echo $owl_lang->groupread_ad ?></i></li>
          <li><i><? echo $owl_lang->groupwrite ?></i></li>
          <li><i><? echo $owl_lang->onlyyou ?></i></li>
          <li><i><? echo $owl_lang->groupwrite_ad_nod ?></i></li>
          <li><i><? echo $owl_lang->everyonewrite_nod ?></i></li>
          <li><i><? echo $owl_lang->groupwrite_worldread_ad ?></i></li>
          <li><i><? echo $owl_lang->groupwrite_worldread_ad_nod ?></i></li>
  </ul>
  <b>&Uuml;berlegen Sie sich gut, welche Berechtigungen Sie geben!</b><p>
  </td>
 </tr>
 <tr>
   <td><i><b><? echo $owl_lang->owl_log_hd_fld_path ?>&nbsp;</b><? echo $owl_lang->permissions ?></i></td>
     <td>W&auml;hlen Sie die zutreffende Berechtigungsstufe aus den folgenden M&ouml;glichkeiten aus:</td>
    </tr>
    <tr><td>&nbsp;</td>
     <td>
     <ul>
             <li><i><? echo $owl_lang->geveryoneread ?></i></li>
             <li><i><? echo $owl_lang->geveryonewrite ?></i></li>
             <li><i><? echo $owl_lang->ggroupread ?></i></li>
             <li><i><? echo $owl_lang->ggroupwrite ?></i></li>
             <li><i><? echo $owl_lang->gonlyyou ?></i></li>
             <li><i><? echo $owl_lang->ggroupwrite_ad_nod ?></i></li>
             <li><i><? echo $owl_lang->geveryonewrite_nod ?></i></li>
             <li><i><? echo $owl_lang->ggroupwrite_worldread_ad ?></i></li>
             <li><i><? echo $owl_lang->ggroupwrite_worldread_ad_nod ?></i></li>
     </ul>
     <b>&Uuml;berlegen Sie sich gut, welche Berechtigungen Sie geben!</b><p>
     </td>
 </tr>
   <td><i><? echo $owl_lang->newpassword ?></i></td>
   <td>Hier k&ouml;nnen Sie das neue Verzeichnis zus&auml;tzlich mit einem Passwort sch&uuml;tzen.</td>
 </tr>
<tr>
   <td><i><? echo $owl_lang->confpassword ?></i></td>
   <td>Die wiederholte Eingabe des Passwortes ist zwingend erforderlich, wenn Sie das Verzeichnis mit einem Passwort sch&uuml;tzen wollen.</td>
 </tr>
 <tr>
    <td><i><? echo $owl_lang->description ?></i></td>
    <td>Hier k&ouml;nnen Sie das neue Verzeichnis beschreiben. Beschreiben Sie in Kurzform, wozu es dient.</td>
 </tr>
</table>
<h4><? echo $owl_lang->sendfile ?></h4>
Um das Archiv hochzuladen, klicken Sie auf &nbsp;"<? echo $owl_lang->sendfile ?>". Wollen Sie Ihre Eintr&auml;ge verwerfen, klicken Sie auf &nbsp;"<? echo $owl_lang->btn_reset ?>".
<br>Das Owl setzt dann auf die voreingestellten Standardeintr&auml;ge zur&uuml;ck.
<br>Nach erfolgreichem Senden, packt sich das Archiv im angelegten Ordner automatisch selbst aus.
<p>
<div style="text-align: right;"><a href ="#top"><img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_nav/desc.gif" width="7" height="4" border="0" alt=""></a></div></p>

<a name="file">
<h3><? echo $owl_lang->alt_btn_add_file ?>&nbsp;<a href ="#top"><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_filetype/file.gif" width="17" height="20" border="0" alt=""></h3></a>
<table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="2">
<tr>
  <td><i><? echo $owl_lang->current_folder ?>&nbsp;<? echo $owl_lang->addingfile ?></i></td>
  <td>Hier wird das aktuelle Verzeichnis angezeigt, zu dem Sie eine Datei hinzuf&uuml;gen.</td>
</tr>
<tr>
  <td><i><? echo $owl_lang->folder_policy ?></i></td>
  <td>Hier werden die Benutzerrechte f&uuml;r dieses Verzeichnis angezeigt. Diese Mitteilung ist anklickbar und Sie gelangen zum Dialog f&uuml;r "<? echo $owl_lang->title_edit_prefs ?>".</td>
</tr>
<tr>
  <td><i><? echo $owl_lang->document_type ?></i></td>
  <td>W&auml;hlen Sie einen zutreffenden <? echo $owl_lang->document_type ?>, oder belassen ihn auf Standard.</td>
</tr>
<tr>
  <td><i><? echo $owl_lang->sendthisfile ?></i></td>
  <td>W&auml;hlen Sie hier von Ihrer Festplatte oder einem anderen Speicherort die Datei aus, welche Sie in das Owl hochladen wollen.</td>
</tr>
<tr>
  <td><i><? echo $owl_lang->name ?></i></td>
  <td>Tragen Sie hier einen kurzen aussagekr&auml;ftigen Namen f&uuml;r die hochzuladene Datei ein.</td>
 </tr>
<tr>
  <td><i><? echo $owl_lang->keywords ?></i></td>
  <td>Hier sollten Sie kurze aussagekr&auml;ftige  <? echo $owl_lang->keywords ?> eintragen. Das unten stehende Fenster zeigt Ihnen, welche <? echo $owl_lang->keywords ?> das Owl schon kennt.<br>
  Hilfreich ist das, wenn man sp&auml;ter nach verwandten Dokumenten im System suchen m&ouml;chte.<br>
  "<? echo $owl_lang->save_keywords_to_db ?>". Genau das wird ausgef&uuml;hrt, wenn man diese Checkbox setzt.</td>
 </tr>
<tr>
  <td><i><? echo $owl_lang->vermajor ?></i></td>
  <td>Hier k&ouml;nnen Sie eine Anfangsversionsnummer festlegen. Die Versionsnummer wird im Owl durch einen Punkt getrennt mitgef&uuml;hrt und bei der n&auml;chsten Aktualisierung automatisch erh&ouml;ht.</td>
</tr>
<tr>
  <td><i><? echo $owl_lang->verminor ?></i></td>
  <td>Die Ziffer vor dem Punkt deutet auf umfangreiche &Auml;nderungen hin, w&auml;hrend die Ziffer nach dem Punkt kleine  &Auml;nderungen der Datei oder Verzeichnis anzeigt.</td>
</tr>
<tr>
  <td><i><? echo $owl_lang->group ?></i></td>
  <td>W&auml;hlen Sie hier die prim&auml;re Gruppe aus, f&uuml;r die dieses Datei bestimmt ist.</td>
</tr>
<tr>
  <td><i><b><? echo $owl_lang->file ?>&nbsp;</b><? echo $owl_lang->permissions ?></i></td>
  <td>W&auml;hlen Sie die zutreffende Berechtigungsstufe aus den folgenden M&ouml;glichkeiten aus:</td>
 </tr>
 <tr><td>&nbsp;</td>
  <td>
  <ul>
          <li><i><? echo $owl_lang->everyoneread ?></i></li>
          <li><i><? echo $owl_lang->everyonewrite ?></i></li>
          <li><i><? echo $owl_lang->groupread ?></i></li>
          <li><i><? echo $owl_lang->groupwrite ?></i></li>
          <li><i><? echo $owl_lang->onlyyou ?></i></li>
          <li><i><? echo $owl_lang->groupwrite_ad_nod ?></i></li>
          <li><i><? echo $owl_lang->everyonewrite_nod ?></i></li>
          <li><i><? echo $owl_lang->groupwrite_worldread_ad ?></i></li>
          <li><i><? echo $owl_lang->groupwrite_worldread_ad_nod ?></i></li>
  </ul>
  <b>&Uuml;berlegen Sie sich gut, welche Berechtigungen Sie geben!</b><p>
  </td>
 </tr>
 <tr>
    <td><i><? echo $owl_lang->newpassword ?></i></td>
    <td>Hier k&ouml;nnen Sie die neue Datei zus&auml;tzlich mit einem Passwort sch&uuml;tzen.</td>
  </tr>
 <tr>
    <td><i><? echo $owl_lang->confpassword ?></i></td>
    <td>Die wiederholte Eingabe des Passwortes ist zwingend erforderlich, wenn Sie die Datei mit einem Passwort sch&uuml;tzen wollen.</td>
  </tr>
  <tr>
     <td><i><? echo $owl_lang->description ?></i></td>
     <td>Hier k&ouml;nnen Sie die neue Datei beschreiben. Beschreiben Sie in Kurzform, wozu sie dient.</td>
 </tr>
</table>
<h4><? echo $owl_lang->sendfile ?></h4>
Um die Datei hochzuladen, klicken Sie auf &nbsp;"<? echo $owl_lang->sendfile ?>". Wollen Sie Ihre Eintr&auml;ge verwerfen, klicken Sie auf &nbsp;"<? echo $owl_lang->btn_reset ?>".
<br>Das Owl setzt dann auf die voreingestellten Standardeintr&auml;ge zur&uuml;ck.
<br>Nach erfolgreichem Senden, befindet sich die neue Datei im gew&auml;hlten Verzeichnis und steht den anderen Owl-Benutzern zur Verf&uuml;gung.
<p>
<div style="text-align: right;"><a href ="#top"><img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_nav/desc.gif" width="7" height="4" border="0" alt=""></a></div></p>

<a name="url">
<h3><? echo $owl_lang->alt_btn_add_url ?>&nbsp;<a href ="#top"><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_filetype/url.gif" width="17" height="20" border="0" alt=""></h3></a>
<table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="2">
<tr>
  <td><i><? echo $owl_lang->current_folder ?>&nbsp;<? echo $owl_lang->addingfile ?></i></td>
  <td>Hier wird das aktuelle Verzeichnis angezeigt, zu dem Sie eine URL hinzuf&uuml;gen.</td>
</tr>
<tr>
  <td><i><? echo $owl_lang->folder_policy ?></i></td>
  <td>Hier werden die Benutzerrechte f&uuml;r dieses Verzeichnis angezeigt. Diese Mitteilung ist anklickbar und Sie gelangen zum Dialog f&uuml;r "<? echo $owl_lang->title_edit_prefs ?>".</td>
</tr>
<tr>
<tr>
  <td><i><? echo $owl_lang->sendthisurl ?></i></td>
  <td>Tragen Sie hier eine vollst&auml;ndige Internetadresse ein. Achten Sie genau auf die Schreibweise (Gross- u. Kleinschreibung)</td>
</tr>
<tr>
  <td><i><? echo $owl_lang->name ?></i></td>
  <td>Tragen Sie hier einen kurzen aussagekr&auml;ftigen Namen f&uuml;r die URL ein.</td>
 </tr>
<tr>
  <td><i><? echo $owl_lang->keywords ?></i></td>
  <td>Hier sollten Sie kurze aussagekr&auml;ftige  <? echo $owl_lang->keywords ?> eintragen. Das unten stehende Fenster zeigt Ihnen, welche <? echo $owl_lang->keywords ?> das Owl schon kennt.<br>
  Hilfreich ist das, wenn man sp&auml;ter nach verwandten Dokumenten im System suchen m&ouml;chte.<br>
  "<? echo $owl_lang->save_keywords_to_db ?>". Genau das wird ausgef&uuml;hrt, wenn man diese Checkbox setzt.</td>
 </tr>
<tr>
  <td><i><? echo $owl_lang->vermajor ?></i></td>
  <td>Hier k&ouml;nnen Sie eine Anfangsversionsnummer festlegen. Die Versionsnummer wird im Owl durch einen Punkt getrennt mitgef&uuml;hrt und bei der n&auml;chsten Aktualisierung automatisch erh&ouml;ht.</td>
</tr>
<tr>
  <td><i><? echo $owl_lang->verminor ?></i></td>
  <td>Die Ziffer vor dem Punkt deutet auf umfangreiche &Auml;nderungen hin, w&auml;hrend die Ziffer nach dem Punkt kleine  &Auml;nderungen der Datei oder Verzeichnis anzeigt.</td>
</tr>
<tr>
  <td><i><? echo $owl_lang->group ?></i></td>
  <td>W&auml;hlen Sie hier die prim&auml;re Gruppe aus, f&uuml;r die dieses Datei bestimmt ist.</td>
</tr>
<tr>
  <td><i><b><? echo $owl_lang->file ?>&nbsp;</b><? echo $owl_lang->permissions ?></i></td>
  <td>W&auml;hlen Sie die zutreffende Berechtigungsstufe aus den folgenden M&ouml;glichkeiten aus:</td>
 </tr>
 <tr><td>&nbsp;</td>
  <td>
  <ul>
          <li><i><? echo $owl_lang->everyoneread ?></i></li>
          <li><i><? echo $owl_lang->everyonewrite ?></i></li>
          <li><i><? echo $owl_lang->groupread ?></i></li>
          <li><i><? echo $owl_lang->groupwrite ?></i></li>
          <li><i><? echo $owl_lang->onlyyou ?></i></li>
          <li><i><? echo $owl_lang->groupwrite_ad_nod ?></i></li>
          <li><i><? echo $owl_lang->everyonewrite_nod ?></i></li>
          <li><i><? echo $owl_lang->groupwrite_worldread_ad ?></i></li>
          <li><i><? echo $owl_lang->groupwrite_worldread_ad_nod ?></i></li>
  </ul>
  <b>&Uuml;berlegen Sie sich gut, welche Berechtigungen Sie geben!</b><p>
  </td>
 </tr>
 <tr>
    <td><i><? echo $owl_lang->newpassword ?></i></td>
    <td>Hier k&ouml;nnen Sie die neue URL zus&auml;tzlich mit einem Passwort sch&uuml;tzen.</td>
  </tr>
 <tr>
    <td><i><? echo $owl_lang->confpassword ?></i></td>
    <td>Die wiederholte Eingabe des Passwortes ist zwingend erforderlich, wenn Sie die Datei mit einem Passwort sch&uuml;tzen wollen.</td>
  </tr>
  <tr>
     <td><i><? echo $owl_lang->description ?></i></td>
     <td>Hier k&ouml;nnen Sie die neue URL beschreiben. Beschreiben Sie in Kurzform, wozu sie dient.</td>
 </tr>
</table>
<h4><? echo $owl_lang->sendthisurl ?></h4>
Um die URL hochzuladen, klicken Sie auf &nbsp;"<? echo $owl_lang->btn_add_url ?>". Wollen Sie Ihre Eintr&auml;ge verwerfen, klicken Sie auf &nbsp;"<? echo $owl_lang->btn_reset ?>".
<br>Das Owl setzt dann auf die voreingestellten Standardeintr&auml;ge zur&uuml;ck.
<br>Nach erfolgreichem Senden, befindet sich die neue URL im gew&auml;hlten Verzeichnis und steht den anderen Owl-Benutzern zur Verf&uuml;gung.<p>
<b>Diese URL ist im Datei-Browser anklickbar und springt aus dem Owl heraus zu dieser Internet-Adresse und &ouml;ffnet einen neuen Browser.</b>
<p>
<div style="text-align: right;"><a href ="#top"><img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_nav/desc.gif" width="7" height="4" border="0" alt=""></a></div></p>

<a name="note">
<h3><? echo $owl_lang->alt_btn_add_note ?>&nbsp;<a href ="#top"><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_filetype/txt.gif" width="16" height="16" border="0" alt=""></h3></a>
<table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="2">
<tr>
  <td><i><? echo $owl_lang->current_folder ?>&nbsp;<? echo $owl_lang->addingfile ?></i></td>
  <td>Hier wird das aktuelle Verzeichnis angezeigt, zu dem Sie eine Datei hinzuf&uuml;gen.</td>
</tr>
<tr>
  <td><i><? echo $owl_lang->folder_policy ?></i></td>
  <td>Hier werden die Benutzerrechte f&uuml;r dieses Verzeichnis angezeigt. Diese Mitteilung ist anklickbar und Sie gelangen zum Dialog f&uuml;r "<? echo $owl_lang->title_edit_prefs ?>".</td>
</tr>
<tr>
<tr>
  <td><i><? echo $owl_lang->name ?></i></td>
  <td>Tragen Sie hier einen kurzen aussagekr&auml;ftigen Dateinamen ohne Namenserweiterung f&uuml;r die neue Textdatei ein.</td>
 </tr>
<tr>
  <td><i><? echo $owl_lang->keywords ?></i></td>
  <td>Hier sollten Sie kurze aussagekr&auml;ftige  <? echo $owl_lang->keywords ?> eintragen. Das unten stehende Fenster zeigt Ihnen, welche <? echo $owl_lang->keywords ?> das Owl schon kennt.<br>
  Hilfreich ist das, wenn man sp&auml;ter nach verwandten Dokumenten im System suchen m&ouml;chte.<br>
  "<? echo $owl_lang->save_keywords_to_db ?>". Genau das wird ausgef&uuml;hrt, wenn man diese Checkbox setzt.</td>
 </tr>
<tr>
  <td><i><? echo $owl_lang->vermajor ?></i></td>
  <td>Hier k&ouml;nnen Sie eine Anfangsversionsnummer festlegen. Die Versionsnummer wird im Owl durch einen Punkt getrennt mitgef&uuml;hrt und bei der n&auml;chsten Aktualisierung automatisch erh&ouml;ht.</td>
</tr>
<tr>
  <td><i><? echo $owl_lang->verminor ?></i></td>
  <td>Die Ziffer vor dem Punkt deutet auf umfangreiche &Auml;nderungen hin, w&auml;hrend die Ziffer nach dem Punkt kleine  &Auml;nderungen der Datei oder Verzeichnis anzeigt.</td>
</tr>
<tr>
  <td><i><? echo $owl_lang->group ?></i></td>
  <td>W&auml;hlen Sie hier die prim&auml;re Gruppe aus, f&uuml;r die dieses Datei bestimmt ist.</td>
</tr>
<tr>
  <td><i><b><? echo $owl_lang->file ?>&nbsp;</b><? echo $owl_lang->permissions ?></i></td>
  <td>W&auml;hlen Sie die zutreffende Berechtigungsstufe aus den folgenden M&ouml;glichkeiten aus:</td>
 </tr>
 <tr><td>&nbsp;</td>
  <td>
  <ul>
          <li><i><? echo $owl_lang->everyoneread ?></i></li>
          <li><i><? echo $owl_lang->everyonewrite ?></i></li>
          <li><i><? echo $owl_lang->groupread ?></i></li>
          <li><i><? echo $owl_lang->groupwrite ?></i></li>
          <li><i><? echo $owl_lang->onlyyou ?></i></li>
          <li><i><? echo $owl_lang->groupwrite_ad_nod ?></i></li>
          <li><i><? echo $owl_lang->everyonewrite_nod ?></i></li>
          <li><i><? echo $owl_lang->groupwrite_worldread_ad ?></i></li>
          <li><i><? echo $owl_lang->groupwrite_worldread_ad_nod ?></i></li>
  </ul>
  <b>&Uuml;berlegen Sie sich gut, welche Berechtigungen Sie geben!</b><p>
  </td>
 </tr>
 <tr>
    <td><i><? echo $owl_lang->newpassword ?></i></td>
    <td>Hier k&ouml;nnen Sie die neue Textatei zus&auml;tzlich mit einem Passwort sch&uuml;tzen.</td>
  </tr>
 <tr>
    <td><i><? echo $owl_lang->confpassword ?></i></td>
    <td>Die wiederholte Eingabe des Passwortes ist zwingend erforderlich, wenn Sie die Textdatei mit einem Passwort sch&uuml;tzen wollen.</td>
  </tr>
  <tr>
     <td><i><? echo $owl_lang->description ?></i></td>
     <td>Hier k&ouml;nnen Sie die neue Textatei beschreiben. Beschreiben Sie in Kurzform, wozu sie dient.</td>
 </tr>
 <tr>
      <td><i><? echo $owl_lang->note_content ?></i></td>
      <td>In dieses Textfeld schreiben Sie ihren den Text. Sie ben&ouml;tigen keinen Normaleditor f&uuml;r das Verfasen von einfachen Texten. Das liefert Ihnen hiermit das Owl.<br>
      Beachten Sie bitte, dass das Owl die Namenserweiterung .txt automatisch an Ihren gew&auml;hlten Textdateinamen anhh&auml;ngt.</td>
 </tr>

</table>
<h4><? echo $owl_lang->sendfile ?></h4>
Um die Textdatei hochzuladen, klicken Sie auf &nbsp;"<? echo $owl_lang->btn_add_note ?>". Wollen Sie Ihre Eintr&auml;ge verwerfen, klicken Sie auf &nbsp;"<? echo $owl_lang->btn_reset ?>".
<br>Das Owl setzt dann auf die voreingestellten Standardeintr&auml;ge zur&uuml;ck.
<br>Nach erfolgreichem Senden, befindet sich die neue Textdatei (*.txt) im gew&auml;hlten Verzeichnis und steht den anderen Owl-Benutzern zur Verf&uuml;gung.
<p>
<div style="text-align: right;"><a href ="#top"><img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_nav/desc.gif" width="7" height="4" border="0" alt=""></a></div></p>

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
