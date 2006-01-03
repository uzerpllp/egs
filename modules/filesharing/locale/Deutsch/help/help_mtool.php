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

<a name ="top">
<h2><? echo $owl_lang->alt_btn_mail_tool ?></h2>

<table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="2">
<tr>
  <td width ="10%"><i><? echo $owl_lang->email_to ?></td>
  <td>Hier tragen Sie eine E-Mail Adresse ein, wenn Sie jemanden schreiben m&ouml;chten, der <i>nicht</i> Owl-Benutzer ist.
  Im anderen Fall, w&auml;hlen Sie aus dem Klappmen&uuml; einen Owl-Benutzer aus.
 Hinter dem Klappmen&uuml; verbergen sich die, vom Owl eingesammelten E-Mail Adressen der Owl-Benutzer.</td>
</tr>
<tr>
  <td><i><? echo $owl_lang->email_cc ?></i></td>
  <td>Tragen Sie hier weitere Empf&auml;nger f&uuml;r diese E-Mail mit Semikolon getrennt ein.</td>
<tr>
<tr>
  <td><i><? echo $owl_lang->email_reply_to ?></i></td>
  <td>Hier k&ouml;nnen Sie Ihre Antwortadresse festlegen. Als Standard ist Ihre E-Mail Adresse voreingestellt.
  </td>
</tr>
<tr>
  <td><i><? echo $owl_lang->email_subject ?></i></td>
  <td>Tragen Sie hier einen kurzen aussagekr&auml;ftigen Betreff f&uuml;r diese E-Mail ein.</td>
</tr>
<tr>
  <td><i><? echo $owl_lang->email_body ?></i></td>
  <td>In dieses Textfeld schreiben Sie ihre Mitteilung am Besten als fortlaufenden Text.
  Im betreffenden Fenster wird automatisch umgebrochen, wenn das Zeilenende erreicht wurde.
  Sie k&ouml;nnen nur Texte verfassen, keine Grafiken oder Bilddateien einf&uuml;gen.
  <p>Beim einfachen Start des E-Mail Programmes, k&ouml;nnen Sie keinen Anhang mitsenden. Das machen Sie aus dem Datei-Browser heraus &uuml;ber den Aktionsknopf "<? echo $owl_lang->alt_email ?>".
  In diesem Fall erweitert sich das Owl E-Mail Programm um die Zeile: "<? echo $owl_lang->attach_file ?>". Das Ankreuzk&auml;stchen ist auf "gesetzt" voreingestellt.
 Sie k&ouml;nnen auch einen ganzen Auswahlblock als Anhang versenden: "<? echo $owl_lang->alt_btn_bulk_email ?>"
  Dabei werden im oberen Teil des E-Mail Programmes alle Dateien aufgelistet, die zum Verschicken als Anhang von Ihnen ausgew&auml;hlt wurden.
"<? echo $owl_lang->emailing ?>" "Dateiname"
Erst wenn Sie das Kontrollk&auml;stchen gesetzt haben, wird der Anhang als ganzes Paket versendet.
Beachten Sie bitte, dass Sie unter Umst&auml;nden <i>kein Benutzungsrecht haben</i>, Dateien oder ganze Verzeichnisse als Anhang zu versenden!</p></td>
</tr>
</table>
<h3><? echo $owl_lang->alt_send_email ?></h3>
Um diese E-Mail zu senden, klicken Sie auf &nbsp;"<? echo $owl_lang->alt_send_email ?>". Wollen Sie Ihre Eintr&auml;ge verwerfen, klicken Sie auf &nbsp;"<? echo $owl_lang->btn_reset ?>".
Owl l&ouml;scht die Inhalte und setzt dann auf die voreingestellten Standardeintr&auml;ge zur&uuml;ck.
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
