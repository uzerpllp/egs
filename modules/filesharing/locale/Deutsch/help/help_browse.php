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

<h2>Vorstellung von Owl</h2>
Owl ist ein mehrbenutzerf&auml;higes System zum Verwalten von Dokumenten in einer Wissensdatenbank. Die Benutzer k&ouml;nnen Dokumente einstellen und mit bestimmten Eigenschaften versehen, wenn sie in das Owl hochgeladen werden. Andere Benutzer sind dann in der Lage, die Dokumente wieder aufzufinden, entweder durch
das Benutzen der Verzeichnisstruktur oder durch Suchen &uuml;ber die eingebaute Suchmaschine.
<br>
Ein Dokument kann dabei jeder Typ eines Dokumentes oder Datei sein, zu den der Benutzer Zugriff hat. Typischerweise k&ouml;nnte das eine Word-Datei, eine Excel-Tabelle oder eine PDF-Datei sein. Aber Owl ist nicht begrenzt auf solche gew&ouml;hnlichen B&uuml;rodateien, sie k&ouml;nnen auch die meisten Grafik-Dateitypen in das System bringen und sie mit dem System wieder anzeigen lassen als auch Audio-, Video- und ausf&uuml;hrbare Programme einspeichern. Defacto ist
Owl nur durch Ihre eigene Fantasie eingegrenzt.
Ist erst einmal ein Dokument in das System eingestellt worden, haben die Benutzer eine Vielzahl
von M&ouml;glichkeiten:
<ul>
<li>die M&ouml;glichkeit, Dokumente direkt aus dem Owl per E-mail zu versenden</li>
<li>die Benutzer k&ouml;nnen Dokumente oder Verzeichnisse &uuml;berwachen und eine Benachrichtung per E-mail erhalten</li>
<li>es kann ein Versionskontrollsystem (VCS) benutzt werden, um Ver&auml;nderungen an Dokumenten
zu verfolgen, Kopien von veralteten Dokumenten aufbewahren und ein Protokoll dar&uuml;ber anbieten</li>
<li>die Benutzer k&ouml;nnen Kommentare zu individuellen Dokumenten hinzuf&uuml;gen</li>
</ul>

Alle diese M&ouml;glichkeiten sind einfach verf&uuml;gbar nur durch die Nutzung eines Internet Browsers.

<h2>Datei Browser</h2>
Das Browsen ist die Hauptmethode, die Sie verwenden werden, um in der hierarchischen Verzeichnisstruktur zu navigieren Dokumente finden und benutzen, die in das System eingestellt wurden. Sie k&ouml;nnen bestimmte <i>Aktionen</i> auf Verzeichnisse und Dokumente anwenden, das Dokument ansehen, herunterladen oder es an jemanden per E-mail versenden.

<h2>Verzeichnis-Struktur</h2>
Die in das Owl System hochgeladenen Dokumente sind in Verzeichnissen gespeichert und jedes Verzeichnis kann eine Reihe von Unterverzeichnissen haben. Diese Art der Strukturierung ist bekannt als hierarchische Struktur und typisch f&uuml;r das Speichern und Organisieren von Dateien
auf Ihrer Computer Festplatte.

Der Startpunkt der Hierarchie (auch root) ist dem Owl als <i>Documents</i>-Verzeichnis bekannt.
Die Verzeichnisstruktur erlaubt einen komfortablen Weg, Dokumente in sinnvoller Art und Weise zu gruppieren. Z.B. w&uuml;nschen Sie alle technischen Dokumente f&uuml;r eine Anzahl von Produkten in das Owl einzustellen. Sie k&ouml;nnten ein Verzeichnis namens "Technische Dokumente" anlegen
und danach eine Reihe von Unterverzeichnissen innerhalb von "Technische Dokumente" f&uuml;r jedes Produkt. Damit das sachgem&auml;ss funktioniert, m&uuml;ssen Sie sensible und beschreibende Verzeichnisnamen ausw&auml;hlen, um den Benutzer durch eine angemessene beschreibende Bedeutung zu unterst&uuml;tzen.

<h3>Tabellen Kopfzeile</h3>

<table  style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="2">
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_icons/tg_check.gif" width="13" height="16" border="0" alt=""></td>
 <td>Checkbox zum Markieren oder Demarkieren zur Auswahl anstehender Dokumente oder Verzeichnisse</td>
</tr>
<tr>
 <td>Status</td>
 <td>Jedes der folgenden Symbole kann angezeigt werden:</td>
</tr>
<tr>
 <td>&nbsp;</td>
 <td><a class="curl1">*</a>
     &nbsp;Das Dokument wurde indiziert, d.h. es ist m&ouml;glich den Inhalt des Dokumentes zu durchsuchen</td>
</tr>
<tr>
 <td>&nbsp;</td>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_icons/new.gif" width="13" height="16" border="0" alt="">
     &nbsp;Dieses Dokument wurde seit Ihrem letzten Besuch hinzugef&uuml;gt</td>
</tr>
<tr>
 <td>&nbsp;</td>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/ui_icons/updated.gif" width="13" height="16" border="0" alt="">
     &nbsp;Dieses Dokument wurde seit Ihrem letzten Besuch aktualisiert</td>
</tr>
<tr><td>&nbsp;</td>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/comment.gif" width="17" height="20" border="0" alt="">
           Dieses Dokument hat einen Benutzer-Kommentar</td>
</tr>
<tr>
 <td><?php echo $owl_lang->doc_number ?></td>
 <td>Die von Owl automatisch vergebene eindeutige Registrier-Nummer.</td>
</tr>
<tr>
 <td><?php echo $owl_lang->title ?></td>
 <td>Beschreibender Name f&uuml;r das Dokument oder Verzeichnis.</td>
</tr>
<tr>
 <td><?php echo $owl_lang->ver  ?></td>
 <td>Die Version des Dokuments oder Verzeichnisses. Die Ziffer vor dem Punkt deutet auf umfangreiche &Auml;nderungen hin, w&auml;hrend die Ziffer nach dem Punkt kleine  &Auml;nderungen des Dokuments oder Verzeichnisses anzeigt.</td>
</tr>
<tr>
 <td><?php echo $owl_lang->file ?></td>
 <td>Der vom Benutzer vergebene Datei- oder Verzeichnisname.</td>
</tr>
<tr>
 <td><?php echo $owl_lang->size ?></td>
 <td>Die Gr&ouml;sse des Dokuments oder der Speicherplatzbedarf des Verzeichnisses.</td>
</tr>
<tr>
 <td><?php echo $owl_lang->postedby ?></td>
 <td>Der Name des Benutzers, der das Dokument eingestellt hat.</td>
</tr>
<tr>
 <td><?php echo $owl_lang->modified ?></td>
 <td>Das letzte &Auml;nderungs- bzw. Einstellungsdatum und Uhrzeit des Dokumentes oder Verzeichnisses.</td>
</tr>
<tr>
 <td><?php echo $owl_lang->held ?></td>
 <td>Hier sehen Sie, wer gerade das Dokument ausgecheckt hat und &auml;ndert. Wenn gerade jemand ein Dokument ausgecheckt hat, k&ouml;nnen Sie es solange nicht aktualisieren, bis er es wieder eingecheckt hat.</td>
</tr>
</table>


<h3><?php echo $owl_lang->actions ?></h3>
Aktionen bieten Funktionen f&uuml;r verschiedene Aufgaben, angewandt auf Verzeichnisse und Dokumente. Die Anzahl der sichtbaren Aktionssymbole ist abh&auml;ngig von Ihren Berechtigungen f&uuml;r ein Verzeichniss und Dokument.

<h4>Aktions Kn&ouml;pfe</h4>
<table  style="width: 100%; text-align: left;" border="0" cellpadding="2"
 cellspacing="2">
<tr>
 <td width ="3%"><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/log.gif" width="17" height="20" border="0" alt=""> </td>
 <td><?php echo $owl_lang->alt_log_file ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/trash.gif" width="17" height="20" border="0" alt=""> </td>
 <td><?php echo $owl_lang->alt_del_file ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/edit.gif" width="17" height="20" border="0" alt=""> </td>
 <td><?php echo $owl_lang->alt_mod_file ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/link.gif" width="17" height="20" border="0" alt=""> </td>
 <td><?php echo $owl_lang->alt_link_file ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/copy.gif" width="16" height="16" border="0" alt=""> </td>
 <td><?php echo $owl_lang->alt_copy_file ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/move.gif" width="17" height="20" border="0" alt=""> </td>
 <td><?php echo $owl_lang->alt_move_file ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/update.gif" width="17" height="20" border="0" alt=""> </td>
 <td><?php echo $owl_lang->alt_upd_file ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/bin.gif" width="17" height="20" border="0" alt=""></td>
 <td><?php echo $owl_lang->alt_get_file ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/comment_dis.gif" width="17" height="20" border="0" alt=""></td>
 <td><?php echo $owl_lang->alt_add_comments ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/lock.gif" width="17" height="17" border="0" alt=""></td>
 <td><?php echo $owl_lang->alt_lock_file ?></td>
</tr>
<td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/unlock.gif" width="16" height="16" border="0" alt=""></td>
 <td><?php echo $owl_lang->alt_unlock_file ?></td>
</tr>
<td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/zip.gif" width="17" height="20" border="0" alt=""></td>
<td><?php echo $owl_lang->alt_btn_add_zip ?></td>
</tr>
<tr>
<td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/newcomment.gif" width="17" height="20" border="0" alt=""></td>
 <td><?php echo $owl_lang->alt_add_comments ?></td>
</tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/email.gif" width="17" height="20" border="0" alt=""></td>
 <td><?php echo $owl_lang->alt_email ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/related.gif" width="17" height="20" border="0" alt=""></td>
 <td><?php echo $owl_lang->alt_related ?></td>
</tr>
<tr>
 <td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/mag.gif" width="17" height="20" border="0" alt=""></td>
 <td><?php echo $owl_lang->alt_view_file ?></td>
</tr>
<td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/play.gif" width="17" height="20" border="0" alt=""></td>
 <td><?php echo $owl_lang->alt_play_file ?></td>
</tr>
<td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/monitor.gif" width="17" height="20" border="0" alt=""></td>
 <td><?php echo $owl_lang->alt_monitor ?></td>
</tr>
<td><img src="../../../graphics/<? echo $default->sButtonStyle ?>/icon_action/print.gif" width="17" height="20" border="0" alt=""></td>
 <td><?php echo $owl_lang->alt_news_print ?></td>
</tr>
</table>

<h4>Auswahl Kn&ouml;pfe</h4>
<p>Das Aktivieren dieser Kn&ouml;pfe, l&auml;sst Sie Aktionen mit mehr als einer Datei zur gleichen Zeit ausf&uuml;hren.
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
      <td>Ausgew&auml;hlte Dateien herunterladen.<br>
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
      <td>Ausgew&auml;hlte Dateien in ein anderes Verzeichnis verschieben.<br>
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
      <td>Ausgew&auml;hlte Dateien per E-mail an jemanden senden.<br>
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
      <td>Ausgew&auml;hlte Dateien l&ouml;schen. Beachten Sie, dass Sie ausgew&auml;hlte Verzeichnisse nicht l&ouml;schen k&ouml;nnen.<br>
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
      <td>Ausgew&auml;hlte Dateien auschecken. Beachten Sie, dass kein Benutzer eine Datei aktualisieren kann, wenn ein anderer Benutzer sie ausgecheckt hat.<br>
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
