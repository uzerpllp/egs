<?php

require_once("../../../../config/owl.php");
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
<img src="../../../../graphics/<? echo $default->sButtonStyle ?>/ui_misc/owl_logo1.gif" width="99" height="53" border="0" alt=""><br></center>
<hr>

<!-- Help Begins Here -->

<H2><?php echo $owl_lang->news_title ?></H2>

<H3><?php echo $owl_lang->news_heading ?></H3>
 Tragen Sie bitte hier einen aussagekr&auml;ftigen Titel f&uuml;r ihreMitteilung ein, so dass Ihre Zielgruppe sofort auf ihre Mitteilungaufmerksam wird.

<H3><?php echo $owl_lang->news_content ?></H3>
 In dieses Textfeld schreiben Sie ihre Mitteilung am Besten alsfortlaufenden Text. Im betreffenden Fenster wird automatischumgebrochen, wenn das Zeilenende erreicht wurde. Sie k&ouml;nnen nurTexte verfassen, keine Grafiken oder Bilddateien einf&uuml;gen.

<H3><?php echo $owl_lang->news_hd_expires ?></H3>
 Hier k&ouml;nnen die die G&uuml;ltigkeitdauer Ihrer Mitteilungfestlegen. Vom Owl wird eine Voreinstellung von genau einer Wocheangeboten. Das ermittelte Datum und die Uhrzeit bezieht dabei Owl vomNetzwerkserver auf dem es installiert wurde. Bitte beachten Sie das!W&auml;hlen Sie &uuml;ber die Klappmen&uuml;s Ihr Datum und die Uhrzeit aus. Dasist sinnvoll, wenn Sie einen exakten Endtermin zu dieser Mitteilungf&uuml;r Ihre Zielgruppe w&uuml;nschen.

<H3><?php echo $owl_lang->news_hd_audience ?></H3>
 Die Zielgruppe, die Sie mit dieser Mitteilung erreichenm&ouml;chten. Aus dem Klappmen&uuml; w&auml;hlen Sie, die Ihnen und demOwl bekannte Zielgruppe aus. Als Standard wird Ihnen vom Owl Ihreprim&auml;re Gruppenzugeh&ouml;rigkeit angeboten.

<p>
In der unten stehenden Tabelle sind ihreMitteilungen aufgelistet, die Sie &auml;ndern oder l&ouml;schenk&ouml;nnen. Es bleiben auch Mitteilungen stehen, die schon abgelaufensind. Erst wenn Sie diese gel&ouml;scht haben, werden sie nicht mehraufgelistet.
</p>

<H3>Best&auml;tigung der Mitteilung</H3>
Um Ihre Mitteilung f&uuml;r ihre Zielgruppe zu ver&ouml;ffentlichen, klickenSie auf den Knopf "<?php echo $owl_lang->btn_add_news ?>". Wollen Sie Ihre&Auml;nderungen verwerfen, klicken auf "<?php echo $owl_lang->btn_reset ?>". DasOwl initialisiert dann alle Eingabefelder erneut auf die ihm bekanntenStandardwerte.

<p>
Es erfolgt ein Hinweis, wie viele Gruppenmitgliederdiese Mitteilung gelesen haben. (z.B. 1/5 - bedeutet, nur einer von 5Gruppenmitgliedern hat diese Mitteilung gelesen. Im Idealfall sind beideZahlen gleich. Dann wissen Sie, dass Sie die gesamte Zielgruppe erreichthaben.
</p>

<!-- Help Ends Here -->

<?php

      fPrintButtonSpace(12, 1);
                                                                                                                                                                                                    
      if ($default->show_prefs == 2 or $default->show_prefs == 3)
      {
         fPrintPrefs("infobar2");
      }
      print("</td></tr></table>\n");
      include("$default->owl_fs_root/lib/footer.inc");
      print("</td></tr></table>\n");
?>
