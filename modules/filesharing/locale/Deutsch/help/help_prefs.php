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

<h2><?php echo $owl_lang->title_edit_prefs ?></h2>
<table  style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="2">
<tr>
 <td><i><?php echo $owl_lang->name ?></i></td>
 <td>Ihr Vor- und Nachname. Hier k&ouml;nnen Sie Ihren Namen korrigieren.</td>
</tr>
<tr>
 <td><i><?php echo $owl_lang->group ?></i></td>
 <td>Welcher prim&auml;ren Gruppe Sie angeh&ouml;ren.</td>
</tr>
<tr>
 <td><i><?php echo $owl_lang->groupmember  ?></i></td>
 <td>Gesamtauflistung aller Gruppen, in welchen Sie Mitglied sind.</td>
</tr>
<tr>
 <td><i><?php echo $owl_lang->userlang ?></i></td>
 <td>Hier sehen Sie Ihre gegenw&auml;rtig eingestellte Sprache. &Uuml;ber das Klappmenu k&ouml;nnen Sie eine andere Sprache w&auml;hlen.</td>
</tr>
<tr>
 <td><i><?php echo $owl_lang->buttonstyle ?></i></td>
 <td>&Uuml;ber das Klappmenu w&auml;hlen Sie den Stil der Kn&ouml;pfe in Owl aus.</td>
</tr>
<tr>
 <td><i><?php echo $owl_lang->oldpassword ?></i></td>
 <td>Falls Sie vorhaben, Ihr Passwort zu &auml;ndern, geben Sie hier bitte zuvor Ihr altes Passwort ein.</td>
</tr>
<tr>
 <td><i><?php echo $owl_lang->newpassword ?></i></td>
 <td>Hier geben Sie Ihr neues Passwort ein. W&auml;hlen Sie ein sicheres Passwort (Gross- und Kleinschreibung sowie Sonderzeichen verwenden)!</td>
</tr>
<tr>
 <td><i><?php echo $owl_lang->confpassword  ?></i></td>
 <td>Hier geben Sie Ihr neues Passwort erneut ein. Bei &Uuml;bereinstimmung informiert Owl Sie &uuml;ber den erfolgreichen Passwortwechsel.
 	 <br>Bei Nicht&uuml;bereinstimmung, wiederholen Sie bitte diesen Vorgang.</td>
</tr>
<tr>
 <td><i><?php echo $owl_lang->email?></i></td>
 <td>Hier wird Ihre gegenw&auml;rtig eingestellte E-Mail Adresse angezeigt. Bei Bedarf &auml;ndern Sie diese bitte hier.</td>
</tr>
<tr>
 <td><i><?php echo $owl_lang->notification ?></i></td>
 <td>Wenn Sie die Checkbox setzen, erhalten Sie Benachrichtigungen automatisch per E-Mail. Bleibt die Checkbox leer, so erhalten Sie keine automatisch generierten Benachrichtigungen von Owl.</td>
</tr>
<tr>
 <td><i><?php echo $owl_lang->attach_file ?></i></td>
 <td>Wenn Sie die Checkbox setzen, werden Ihnen neue oder aktualisierte Dokumente als Anhang per E-Mail gesendet sofern Sie oben "<?php echo $owl_lang->notification ?>" angeklickt haben. Bleibt die Checkbox leer, wird nur der Pfad zum Dokument im E-Mail gesendet.</td>
</tr>
<tr>
 <td><i><?php echo $owl_lang->comment_notif ?></i></td>
 <td>Wenn Sie die Checkbox setzen, erhalten Sie automatisch eine E-Mail, wenn ein Benutzer einen Kommentar zu einer Datei oder einem Verzeichnis hinzugf&uuml;gt oder ge&auml;ndert hat. Bleibt die Checkbox leer, erfolgt keine Meldung.</td>
</tr>
<tr>
 <td><i><?php echo $owl_lang->news_title ?></i></td>
 <td>Hier sehen Sie, ob der Sytemadministrator Ihnen die Rechte eines Mitteilungs-Administrators gegeben hat. Wenn ja, so haben Sie das Recht, Mitteilungen an andere Gruppenmitglieder zu versenden.</td>
</tr>
</table>
<h2>Best&auml;tigung der Einstellungen</h2>
Um Ihre Einstellungen zu speichern, klicken Sie auf den &Auml;nderungs-Knopf. Wollen Sie Ihre &Auml;nderungen verwerfen, klicken Sie den Zur&uuml;cksetzen-Knopf.


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
