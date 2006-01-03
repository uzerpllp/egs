<?php

require_once("../../../config/owl.php");
require_once("$default->owl_fs_root/lib/disp.lib.php");
require_once("$default->owl_fs_root/lib/owl.lib.php");
require_once("$default->owl_fs_root/lib/security.lib.php");
include_once("$default->owl_fs_root/lib/header.inc");
include_once("$default->owl_fs_root/lib/userheader.inc");


   unset($userid);

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

<a name="top">
<h2>Registrieren und Passwort Anfordern</h2>
<h3>&Uuml;bersicht</h3>
<ul>
	<li><a href="#an"><?php echo $owl_lang->anonymous_access ?></a></li>
    	<li><a href="#self">Selbstregistrierung</a></li>
    	<li><a href="#pw">Passwort vergessen</a></li>
    	<li><a href="#rm">Automatische Anmeldung</a></li>
</ul>

<a name="an">
<h3>Anonymer Zugriff</h3>
Der anonyme Zugang erlaubt Ihnen, Owl ohne "<?php echo $owl_lang->username ?>" und <?php echo $owl_lang->password ?>" zu benutzen. Es ist sehr wahrscheinlich, dass der Systemadministrator des Owl einige Einschr&auml;nkungen in mancher Beziehung f&uuml;r diesen Fall gesetzt hat. Der anonyme Benutzer wird wahrscheinlich nicht in der Lage sein, Dateien in Owl hochladen zu k&ouml;nnen. Desweiteren wird es ihm wahrscheinlich nicht m&ouml;glich sein, noch andere Funktionen zu nutzen. Sinnvoll sind diese Einstellungen, wenn der anonyme Benutzer den Inhalt eines bestimmten Verzeichnisses nur lesen darf. Es ist dem anonymen Benutzer erlaubt, Owl Hilfe System zu benutzen. Damit kann er sich mit dem Owl vertraut machen.

<p>
<div style="text-align: right;"><a href ="#top"><img src="../../../graphics/<?php echo $default->sButtonStyle ?>/ui_nav/desc.gif" width="7" height="4" border="0" alt=""></a></div></p>

<a name="self">
<h3><?php echo $owl_lang->register ?></h3>

<table  style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="2">
<tr>
 <td width ="10%"><i><?php echo $owl_lang->name ?></i></td>
 <td>Tragen Sie hier den Vor- und Nachnamen ein, unter dem Sie sich bei Owl registrieren lassen m&ouml;chten.</td>
</tr>
<tr>
 <td><i><?php echo $owl_lang->username ?></i></td>
 <td>Tragen Sie hier einen frei w&auml;hlbaren "<?php echo $owl_lang->username ?>n" ein, unter dem Sie sich in Zukunft bei Owl anmelden m&ouml;chten und nach erfolgreicher <?php echo $owl_lang->register ?> auch k&ouml;nnen.
<br>
 Tipp: Benutzen Sie Ihren Nachnamen <i>klein</i> geschrieben als "<?php echo $owl_lang->username ?>n".</td>
</tr>
<tr>
 <td><i><?php echo$owl_lang->email  ?></i></td>
 <td>Tragen Sie hier Ihre E-Mail-Adresse ein, unter der Sie erreichbar sind.</td>
</tr>
</table>
<p>
<div style="text-align: right;"><a href ="#top"><img src="../../../graphics/<?php echo $default->sButtonStyle ?>/ui_nav/desc.gif" width="7" height="4" border="0" alt=""></a></div></p>

<a name="pw">
<h3><?php echo $owl_lang->forgot_pass ?></h3>
Falls Sie in die Lage "<?php echo $owl_lang->forgot_pass ?>" gelangen sollten,
 haben Sie die M&ouml;glichkeit, unter Angabe Ihres "<?php echo $owl_lang->username ?>n", von Owl ein neu generiertes Passwort auf Ihre E-Mail Adresse gesendet zu bekommen.
 <br>
Es erfolgt sofort eine Owl-Meldung auf dem Bildschirm: <i>"<?php echo $owl_lang->thank_you_2 ?>"</i>. 
<br>
Bitte &auml;ndern Sie das automatisch generierte Passwort anschliessend in <i>"<?php echo $owl_lang->title_edit_prefs ?>"</i>!

<p>
<div style="text-align: right;"><a href ="#top"><img src="../../../graphics/<?php echo $default->sButtonStyle ?>/ui_nav/desc.gif" width="7" height="4" border="0" alt=""></a></div></p>

<a name="rm">
<h3><?php echo $owl_lang->remember_me_checkbox ?></h3>
Um die <?php echo $owl_lang->remember_me_checkbox ?> zu aktivieren, markieren Sie bitte das Kontrollk&auml;stchen "<?php echo $owl_lang->remember_me_checkbox ?>" und melden Sie sich an. Beim n&auml;chsten Besuch werden Sie automatisch angemeldet.

<p>Damit die automatische Anmeldung funktioniert m&uuml;ssen Sie in Ihrem Browser Cookies aktiviert haben.</p>

<h4>Achtung</h4>
Benutzen Sie die automatische Anmeldung nicht an &ouml;ffentlichen Computern!

<p>
<div style="text-align: right;"><a href ="#top"><img src="../../../graphics/<?php echo $default->sButtonStyle ?>/ui_nav/desc.gif" width="7" height="4" border="0" alt=""></a></div></p>

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
