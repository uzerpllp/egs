<?php

/*

  File: Deutsch/language.inc
  Author: Chris
  Date: 2000/12/14
  Last modified by: Carlo Strub 2005/03/02 <owl@carlostrub.ch>

  Many thanks go to Roland Schroepfer

  Owl: Copyright Chris Vincent <cvincent@project802.net>

  You should have received a copy of the GNU Public
  License along with this package; if not, write to the
  Free Software Foundation, Inc., 59 Temple Place - Suite 330,
  Boston, MA 02111-1307, USA.

*/
//********************************************************
// Date Formating BEGIN
//********************************************************

// If config/owl.php   $default->generic_date_format is 
// set USE That one if not
// use the one in this file

if (isset($default->generic_date_format) && trim($default->generic_date_format) != "") {

        $owl_lang->localized_date_format = $default->generic_date_format;
} else {
        $owl_lang->localized_date_format = "d.m.Y \u\\m H:i \U\h\\r";
}


// Character Encoding used 
// default: "UTF-8"
$owl_lang->charset = "UTF-8";

//********************************************************
// Date Formating END
//********************************************************

//********************************************************
// Error Messages BEGIN
//********************************************************

$owl_lang->err_select_reviewer          = "Bitte w&auml;hlen Sie mindestens eine Person, um Ihr Dokument bewerten zu lassen";
$owl_lang->err_adding_comments          = "Sie haben keine Berechtigung um Kommentare hinzuzuf&uuml;gen.";
$owl_lang->err_comment_empty		= "Kommentarfeld darf nicht leer sein";
$owl_lang->err_backup_file    		= "Fehler beim Erzeugen der Sicherungsdatei.";
$owl_lang->err_backup_folder_create 	= "Fehler beim Erzeugen des Backup-Verzeichnisses.";
$owl_lang->err_bad_url                  = "Geben Sie bitte eine korrekte URL ein.";
$owl_lang->err_bad_version_1  		= "Owl Intranet ben&ouml;tigt mindestens PHP Version";
$owl_lang->err_bad_version_2  		= "Sie verwenden Version";
$owl_lang->err_bad_version_3  		= "Installieren Sie eine neuere PHP Version und versuchen Sie es erneut";
$owl_lang->err_email          		= "Die Nachricht konnte nicht gesendet werden.";
$owl_lang->err_email_required   	= "E-Mail Feld wird ben&ouml;tigt";
$owl_lang->err_fexist1 			= "<b>Datei existiert bereits:</b>";
$owl_lang->err_fexist2 			= "Es existiert bereits eine Datei mit diesem Namen <i>";
$owl_lang->err_fexist3 			= "</i> in diesem Verzeichnis.";
$owl_lang->err_file_exists         	= "Die Datei, die Sie versuchen einzustellen, existiert bereits";
$owl_lang->err_file_lock      		= "Sie k&ouml;nnen diese Datei nicht auschecken, da sie bereits verwendet wird von ";
$owl_lang->err_update_file_lock         = "Sie k&ouml;nnen diese Datei nicht aktualisieren, da sie bereits verwendet wird von ";
$owl_lang->err_filemove_exist           = "Der neue Name, den Sie dieser Datei geben m&ouml;chten, existiert bereits";
$owl_lang->err_file_not_exist 		= "Diese Datei existiert nicht auf der Festplatte";
$owl_lang->err_file_too_big     	= "php.ini upload_max_filesize &uuml;berschritten und/oder<br></br>Maximale Upload Gr&ouml;sse f&uuml;r Owl &uuml;berschritten";
$owl_lang->err_file_update    		= "Um eine Datei zu aktualisieren, m&uuml;ssen die Dateinamen &uuml;bereinstimmen. Benutzen Sie bitte den in OWL Intranet gespeicherten Dateinamen";
$owl_lang->err_fileexists     		= "Verschieben abgebrochen.<br></br>Eine Datei mit diesem Namen existiert bereits!";
$owl_lang->err_folder_create  		= "Verzeichnis konnte nicht angelegt werden";
$owl_lang->err_folder_exist   		= "Das Verzeichnis existiert bereits";
$owl_lang->err_folderexists   		= "Umbenennen abgebrochen.<br></br>Ein Verzeichnis mit diesem Namen existiert bereits!";
$owl_lang->err_general        		= "Ein Fehler ist aufgetreten";
$owl_lang->err_group_delete             = "Gruppen mit Mitglieder k&ouml;nnen nicht gel&ouml;scht werden";
$owl_lang->err_group_exists             = "Gruppe existiert bereits";
$owl_lang->err_gzip_not_found   	= "gzip nicht gefunden in ";
$owl_lang->err_login   			= "Um diese Funktion auszuf&uuml;hren m&uuml;ssen Sie sich anmelden!";
$owl_lang->err_movecancel     		= "Verschieben wurde abgebrochen.<br></br>";
$owl_lang->err_nameempty      		= "Der Verzeichnisname darf nicht leer sein.";
$owl_lang->err_news_required            = "FEHLER: Sie m&uuml;ssen f&uuml;r die Mitteilungen einen Titel und einen Text eingeben!";
$owl_lang->err_no_access       		= "Sie haben keinen Zugriff auf die ausgew&auml;hlten Dateien";
$owl_lang->err_no_access_info           = "M&ouml;gliche Gr&uuml;nde: <br></br>1) Sie haben keine Checkbox angeklickt, die sich vor einer Datei oder einem Verzeichnis befindet<br></br>2) Auswahl l&ouml;schen, Auswahl mailen und Auswahl ein-/auschecken geht f&uuml;r Verzeichnisse nicht<br></br>3) Sie haben keine Berechtigung f&uuml;r die von Ihnen ausgew&auml;hlten Dateien oder Verzeichnisse.";
$owl_lang->err_nofileaccess       	= "Sie haben keinen Zugriff auf die Datei";
$owl_lang->err_nofiledelete       	= "Sie haben keine Berechtigung zum L&ouml;schen dieser Datei";
$owl_lang->err_nofilemod          	= "Sie haben keine Berechtigung zum &auml;ndern dieser Datei";
$owl_lang->err_nofolderaccess     	= "Sie haben keinen Zugriff auf das Verzeichnis";
$owl_lang->err_nofolderdelete     	= "Sie haben keine Berechtigung, dieses Verzeichnis zu l&ouml;schen";
$owl_lang->err_nofoldermod        	= "Sie haben keine Berechtigung, dieses Verzeichnis zu ver&auml;ndern";
$owl_lang->err_noemail            	= "Sie haben keine Berechtigung, diese Datei zu versenden";
$owl_lang->err_nosubfolder        	= "Sie haben hier keine Berechtigung, Unterverzeichnisse zu erstellen";
$owl_lang->err_note_title               = "Bitte geben Sie einen Titel an";
$owl_lang->err_note_title_exists        = "Dateiname schon vorhanden";
$owl_lang->err_noupload           	= "Sie haben keine Berechtigung Dateien in dieses Verzeichnis hochzuladen";
$owl_lang->err_pass_missmatch 		= "Das neue und das Best&auml;tigungspasswort stimmen nicht &uuml;berein.";
$owl_lang->err_pass_wrong     		= "Das alte Passwort ist falsch!";
$owl_lang->err_pod2html_not_found       = "FEHLER: Das Programm pod2html wurde nicht gefunden:";
$owl_lang->err_quota          		= "Sie haben nicht genug Speicherplatz, um die Datei hochzuladen: ";
$owl_lang->err_quota_avail    		= " verf&uuml;gbar.";
$owl_lang->err_quota_exceed   		= "Sie haben keinen Speicherplatz mehr zur Verf&uuml;gung ";
$owl_lang->err_quota_needed   		= " ben&ouml;tigt ";
$owl_lang->err_req      		= "Fehler: Bitte alle Felder ausf&uuml;llen.";
$owl_lang->err_root_delete              = "Das Root-Verzeichnis kann nicht gel&ouml;scht werden";
$owl_lang->err_sess_notvalid  		= "Session-ID ist ung&uuml;ltig";
$owl_lang->err_sess_write     		= "Konnte Session Informationen nicht in die Datenbank schreiben";
$owl_lang->err_specialfoldername 	= "'backup' ist ein f&uuml;r Owl reservierter Verzeichnisname. Bitte einen anderen Namen w&auml;hlen!";
$owl_lang->err_tar_not_found    	= "tar nicht gefunden in ";
$owl_lang->err_trash_can_empty          = "Der Papierkorb<br></br>ist leer";
$owl_lang->err_unauth_area    		= "Sie haben keine Berechtigung f&uuml;r diesen Bereich";
$owl_lang->err_unauthorized   		= "Nicht autorisiert";
$owl_lang->err_upload         		= "Fehler beim Hochladen der Datei";
$owl_lang->err_user_exists    		= "Benutzername existiert bereits";
$owl_lang->err_cant_del_doc_type        = "Dieser Document Type kann nicht gel&ouml;scht werden, da er in Gebrauch ist";
$owl_lang->err_doc_type_name_req        	= "Geben Sie f&uuml;r den Document Type einen Namen ein <br></br>";
$owl_lang->err_doc_field_req            	= "Es fehlt das ben&ouml;tigte Feld:";
$owl_lang->err_field_name_req           	= "Ein Feldname wird ben&ouml;tigt <br></br>";
$owl_lang->err_field_label_req          	= "Ein Field Label wird ben&ouml;tigt <br></br>";
$owl_lang->err_field_size_req           	= "Eine Gr&ouml;sse f&uuml;r das Feld wird ben&ouml;tigt <br></br>";
$owl_lang->err_forbidden_file			= "Verbotener Dokumententyp";
$owl_lang->err_file_indexing			= "Fehler bei der tempor&auml;ren Erstellung einer Textdatei";
$owl_lang->err_not_zip				= "Dies ist kein g&uuml;ltiges ZIP Archiv";
$owl_lang->err_database				= "Datenbankfehler";
$owl_lang->err_sql				= "SQL Fehler";

//********************************************************
// Error Messages END
//********************************************************


$owl_lang->btn_go_top      = "Zum Seitenanfang";                                                                                                                                                           
$owl_lang->btn_go_bottom      = "Zum Seitenende";
$owl_lang->btn_admin      			= "Administration";
$owl_lang->btn_logout     			= "Abmelden";
$owl_lang->btn_browse     			= "Bl&auml;ttern";
$owl_lang->btn_mail_tool     			= "E-Mail";
$owl_lang->btn_help     			= "Hilfe";
$owl_lang->btn_add_field          		= "Neues Feld";
$owl_lang->btn_add_url          		= "Neue Url";
$owl_lang->btn_create          			= "Erstellen";
$owl_lang->btn_register          		= "Registrieren";
$owl_lang->btn_add_file          		= "Neue Datei";
$owl_lang->btn_add_zip           		= "Neues Archiv";
$owl_lang->btn_admin_users          		= "Neuer Benutzer";
$owl_lang->btn_admin_groups          		= "Neue Gruppe";
$owl_lang->btn_deldoctype          		= "Dokumententyp l&ouml;schen";
$owl_lang->btn_expand_view          		= "Erweiterte Ansicht";
$owl_lang->btn_add_folder          		= "Neues Verzeichnis";
$owl_lang->btn_cancel          			= "Abbrechen";
$owl_lang->btn_login          			= "Anmelden";
$owl_lang->btn_send_email          		= "E-Mail senden";
$owl_lang->btn_admin_news          		= "Mitteilungen-Admin";
$owl_lang->btn_add_news          		= "Neue Mitteilung";
$owl_lang->btn_clickhere          		= "Hier klicken";
$owl_lang->btn_edit_group          		= "Gruppe anpassen";
$owl_lang->btn_add_note          		= "Neue Notiz";
$owl_lang->btn_collapse_view          		= "Einfache Ansicht";
$owl_lang->btn_edit_user          		= "Benutzer anpassen";
$owl_lang->btn_bulk_move          		= "Auswahl verschieben";
$owl_lang->btn_bulk_delete          		= "Auswahl l&ouml;schen";
$owl_lang->btn_bulk_checkout       		= "Auswahl ein-/auschecken";
$owl_lang->btn_bulk_email          		= "Auswahl mailen";
$owl_lang->btn_bulk_download          		= "Auswahl herunterladen";
$owl_lang->btn_reset          			= "Zur&uuml;cksetzen";
$owl_lang->btn_submit          			= "Senden";
$owl_lang->btn_back          			= "Zur&uuml;ck";
$owl_lang->btn_download_bulk_package		= "um Ihr Sammelpaket herunterzuladen";


//********************************************************
// Image Alternate popup Messages BEGIN
//********************************************************

$owl_lang->alt_tool_status_red  = "Pfad ist falsch UND/ODER nicht Executable";
$owl_lang->alt_tool_status_green= "Tool ist Aktiv";
$owl_lang->alt_my_approval      = "Dokumente ohne Ihr Einverst&auml;ndnis";
$owl_lang->alt_pending_approval = "Dokumente bei denen ein Einverst&auml;ndnis fehlt";
$owl_lang->alt_email_reminder   = "E-Mail Erinnerung";
$owl_lang->alt_approve_file     = "Geben Sie Ihr Einverst&auml;ndnis f&uuml;r dieses Dokument";
$owl_lang->alt_reject_file      = "Weisen Sie dieses Dokument zur&uuml;ck";
$owl_lang->alt_publish_file     = "Machen Sie dieses Dokument &ouml;ffentlich";
$owl_lang->alt_go_top           = "Gehen Sie an den Beginn dieser Seite";
$owl_lang->alt_go_bottom           = "Gehen Sie an das Ende dieser Seite";
$owl_lang->alt_btn_add_zip           		= "Eine Zip-Datei hochladen, um sie anschliessend zu extrahieren";
$owl_lang->alt_btn_mail_tool     		= "E-Mail Programm";
$owl_lang->alt_btn_bulk_move          		= "Ausgew&auml;hlte Dateien und Verzeichnisse verschieben";
$owl_lang->alt_btn_bulk_delete          	= "Ausgew&auml;hlte Dateien l&ouml;schen";
$owl_lang->alt_btn_bulk_checkout          	= "Ausgew&auml;hlte Dateien ein-/auschecken";
$owl_lang->alt_btn_bulk_email          		= "Ausgew&auml;hlte Dateien mailen";
$owl_lang->alt_btn_bulk_download          	= "Ausgew&auml;hlte Dateien herunterladen";
$owl_lang->alt_reset_form			= "Formular zur&uuml;cksetzen";
$owl_lang->alt_add_comments     		= "Kommentar hinzuf&uuml;gen";
$owl_lang->alt_btn_add_file     		= "Neue Datei hochladen";
$owl_lang->alt_btn_add_folder   		= "Neues Verzeichnis erstellen";
$owl_lang->alt_add_group        		= "Diese Gruppe erstellen";
$owl_lang->alt_add_news         		= "Neue Mitteilung hinzuf&uuml;gen";
$owl_lang->alt_btn_add_note     		= "Neue Textdatei erstellen";
$owl_lang->alt_btn_add_url      		= "Neuen Link erstellen";
$owl_lang->alt_add_user         		= "Benutzer erstellen";
$owl_lang->alt_admin_backup     		= "SQL-Datenbank sichern";
$owl_lang->alt_backup_dis     			= "Sicherungs-Tool oder gzip nicht gefunden";
$owl_lang->alt_cancel_move      		= "Verschiebung abbrechen";
$owl_lang->alt_change           		= "Eintrag aktualisieren";
$owl_lang->alt_btn_clickhere    		= "Hier klicken";
$owl_lang->alt_btn_collapse_view		= "Auf einfache Ansicht umschalten";
$owl_lang->alt_comments         		= "Kommentare existieren f&uuml;r diese Datei";
$owl_lang->alt_del_comments     		= "Kommentar l&ouml;schen";
$owl_lang->alt_del_file       			= "Datei l&ouml;schen";
$owl_lang->alt_del_folder     			= "Verzeichnis l&ouml;schen";
$owl_lang->alt_del_group        		= "Diese Gruppe l&ouml;schen";
$owl_lang->alt_del_news         		= "Mitteilung l&ouml;schen";
$owl_lang->alt_del_selected     		= "Markierte Dateien l&ouml;schen";
$owl_lang->alt_del_this_folder  		= "Verzeichnis l&ouml;schen &#8211; ";
$owl_lang->alt_del_user         		= "Benutzer l&ouml;schen";
$owl_lang->alt_edit_group       		= "Ausgew&auml;hlte Gruppe &auml;ndern";
$owl_lang->alt_edit_news        		= "Mitteilung &auml;ndern";
$owl_lang->alt_edit_user        		= "Ausgew&auml;hlten Benutzer &auml;ndern";
$owl_lang->alt_email          			= "Datei per E-Mail versenden";
$owl_lang->alt_email_selected   		= "Markierte Dateien senden"; 
$owl_lang->alt_btn_expand_view  		= "Auf erweiterte Ansicht umschalten";
$owl_lang->alt_admin_flush   			= "H&auml;ngen gebliebene Sessions l&ouml;schen";
$owl_lang->alt_get_file       			= "herunterladen";
$owl_lang->alt_get_folder       = "Inhalt des Verzeichnisses herunterladen";
$owl_lang->alt_have_news        		= "Sie haben neue Mitteilungen";
$owl_lang->alt_have_no_news     		= "Keine neuen Mitteilungen";
$owl_lang->alt_home_folder      		= "Zum Home-Verzeichnis";
$owl_lang->alt_set_initial_dir  		= "Aktuelles Verzeichnis als Home-Verzeichnis festlegen";
$owl_lang->alt_site_map         		= "Verzeichnisplan";
$owl_lang->alt_lock_file        		= "Datei auschecken";
$owl_lang->alt_log_clear        		= "Logbuch l&ouml;schen";
$owl_lang->alt_log_file         		= "Logbuch dieser Datei";
$owl_lang->alt_log_next         		= "Zu den n&auml;chsten Eintr&auml;gen";
$owl_lang->alt_log_prev         		= "Zu den vorherigen Eintr&auml;gen";
$owl_lang->alt_log_top          		= "Zum ersten Eintrag";
$owl_lang->alt_btn_login        		= "Bei Owl Intranet anmelden";
$owl_lang->alt_btn_logout       		= "Bei Owl Intranet abmelden";
$owl_lang->alt_btn_help				= "Owl Hilfe";
$owl_lang->alt_mod_file       			= "Eigenschaften &auml;ndern";
$owl_lang->alt_mod_folder     			= "Eigenschaften &auml;ndern";
$owl_lang->alt_move_file      			= "Datei verschieben";
$owl_lang->alt_copy_file     			= "Datei kopieren";
$owl_lang->alt_link_file     			= "In einem anderen Verzeichnis einen Link zu dieser Datei setzen";
$owl_lang->alt_move_folder    			= "Verzeichnis verschieben";
$owl_lang->alt_copy_folder   			= "Verzeichnis kopieren";
$owl_lang->alt_move_selected    		= "Markierte Dateien verschieben"; 
$owl_lang->alt_admin_groups     		= "Gruppe anlegen";
$owl_lang->alt_news_close       		= "Fenster schliessen";
$owl_lang->alt_news_next        		= "Weitere Mitteilungen";
$owl_lang->alt_news_prev        		= "Vorherige Mitteilung";
$owl_lang->alt_news_print       		= "Drucken";
$owl_lang->alt_admin_users      		= "Benutzer anlegen";
$owl_lang->alt_monitor       			= "beobachten";
$owl_lang->alt_monitored     			= "Beobachtung beenden";
$owl_lang->alt_btn_admin        		= "OWL Administration";
$owl_lang->alt_play_file        		= "Datei Abspielen";
$owl_lang->alt_recycle          		= "Ihrer Papierkorb ist leer";
$owl_lang->alt_recycle_disable  		= "Papierkorb<br></br>(nicht aktiviert)";
$owl_lang->alt_recycle_not_found		= "Papierkorb Verzeichnis nicht gefunden";
$owl_lang->alt_refresh_filter   		= "Filter aktualisieren";
$owl_lang->alt_register         		= "Registrierung senden";
$owl_lang->alt_btn_browse       		= "Zum Dateibrowser";
$owl_lang->alt_search           		= "Suche starten";
$owl_lang->alt_send_email       		= "E-Mail senden";
$owl_lang->alt_sendfile         		= "Datei senden";
$owl_lang->alt_toggle_check_box			= "Auswahl umkehren";
$owl_lang->alt_unlock_file      		= "Datei einchecken";
$owl_lang->alt_upd_file       			= "Datei aktualisieren";
$owl_lang->alt_view_comments    		= "Kommentar";
$owl_lang->alt_view_file      			= "Datei ansehen";
$owl_lang->alt_edit_field       		= "Diese Felddefinition &auml;ndern";
$owl_lang->alt_del_field        		= "Dieses Feld l&ouml;schen";
$owl_lang->alt_add_field        		= "Feld einf&uuml;gen";
$owl_lang->alt_deldoctype       		= "Diesen Dokumententyp l&ouml;schen";
$owl_lang->alt_upd_field        		= "Dieses Feld updaten";
$owl_lang->alt_new_doctype      		= "Einen neuen Dokumententyp erstellen";
$owl_lang->alt_related				= "Nach &auml;hnlichen Dokumenten suchen";
$owl_lang->alt_back          			= "Zur&uuml;ck zur vorherigen Seite";
$owl_lang->alt_submit           		= "Absenden";

//********************************************************
// Image Alternate popup Messages END
//********************************************************


//********************************************************
// Owl Logging messages BEGIN
//********************************************************

$owl_lang->log_del_det  			= "Inhalt gel&ouml;scht";
$owl_lang->log_detail   			= "Keine weiteren Details";
$owl_lang->log_file_to  			= "AN: "; 
$owl_lang->log_filter_all       		= "ALLE";
$owl_lang->log_login_det        		= "Benutzername: ";
$log_file_actions[1]            		= "ANMELDUNG";
$log_file_actions[2]            		= "ANMELDUNG FEHLGESCHLAGEN";
$log_file_actions[3]            		= "ABMELDUNG";
$log_file_actions[4]            		= "DATEI GEL&Ouml;SCHT";
$log_file_actions[5]            		= "DATEI ERSTELLT";
$log_file_actions[6]            		= "DATEI AKTUALISIERT";
$log_file_actions[7]            		= "DATEI HERUNTERGELADEN";
$log_file_actions[8]            		= "DATEI GE&Auml;NDERT";
$log_file_actions[9]            		= "DATEI AUSGECHECKT";
$log_file_actions[10]           		= "DATEI EINGECHECKT";
$log_file_actions[11]           		= "DATEI GESENDET";
$log_file_actions[12]           		= "DATEI VERSCHOBEN";
$log_file_actions[13]           		= "VERZEICHNIS ERSTELLT";
$log_file_actions[14]           		= "VERZEICHNIS GEL&Ouml;SCHT";
$log_file_actions[15]           		= "VERZEICHNIS GER&Auml;NDERT";
$log_file_actions[16]           		= "VERZEICHNIS VERSCHOBEN";
$log_file_actions[17]           		= "PASSWORT VERGESSEN";
$log_file_actions[18]           		= "BENUTZER REGISTRIERUNG";
$log_file_actions[19]           		= "DATEI ANGESEHEN";
$log_file_actions[20]           		= "DATEI VIRUS";
$log_file_actions[21]           		= "DATEI KOPIERT";
$log_file_actions[22]           		= "VERZEICHNIS KOPIERT";
$log_file_actions[23]           		= "DATEI VERLINKT";

//********************************************************
// Owl Logging messages END
//********************************************************


//********************************************************
// index.php  BEGIN
//********************************************************

$owl_lang->anonymous          			= "(Anonymer Zugriff m&ouml;glich)";
$owl_lang->repository_list    			= "Datenbank:";
$owl_lang->engine             			= "Owl Intranet Engine";
$owl_lang->forgot_pass        			= "Passwort vergessen?";
$owl_lang->like_register      			= "M&ouml;chten Sie sich registrieren?";
$owl_lang->login              			= "Anmelden";
$owl_lang->loginfail          			= "Falscher Benutzername oder falsches Passwort";
$owl_lang->logindisabled      			= "Der Benutzername wurde deaktiviert, bitte kontaktieren Sie den Systemadministrator";
$owl_lang->password           			= "Passwort";
$owl_lang->successlogout      			= "Sie haben sich erfolgreich abgemeldet.";
$owl_lang->toomanysessions    			= "Die maximale Anzahl an Sessions f&uuml;r diesen Benutzer ist erreicht, kontaktieren Sie bitte den Systemadministrator";
$owl_lang->username           			= "Benutzername";
$owl_lang->version 				= "Version";

//********************************************************
// index.php  END
//********************************************************


//********************************************************
// browse.php  BEGIN
//********************************************************

$owl_lang->menu_url_action              	= "Verf&uuml;gbare URL Aktionen";
$owl_lang->menu_file_action             	= "Verf&uuml;gbare Datei Aktionen";
$owl_lang->menu_folder_action           	= "Verf&uuml;gbare Verzeichnis Aktionen";
$owl_lang->panel_file_info			= "Information zu den Dateien";
$owl_lang->actions            			= "Aktionen";
$owl_lang->del_selected          		= "Markiert L&ouml;schen";
$owl_lang->del_all				= "Papierkorb leeren";
$owl_lang->rest_selected			= "Auswahl wiederherstellen";
$owl_lang->disk_quota                   	= "Verwendeter Speicher";
$owl_lang->email_selected        		= "Markiert Senden";
$owl_lang->file               			= "Datei";
$owl_lang->folder_policy               		= "Sicherheitseinstellungen f&uuml;r dieses Verzeichnis:";
$owl_lang->current_folder 			= "Aktuelles Verzeichnis:";
$owl_lang->held               			= "Ausgecheckt";
$owl_lang->last_logged              		= "Letzter Besuch: ";
$owl_lang->current_db         			= "Datenbank:";
$owl_lang->modified           			= "Ge&auml;ndert";
$owl_lang->move_selected         		= "Markiert Verschieben";
$owl_lang->new_file                     	= "Neu!";
$owl_lang->no_description               	= "Keine Beschreibung verf&uuml;gbar";
$owl_lang->page                         	= "Seite";
$owl_lang->postedby           			= "Erstellt";
$owl_lang->reallydelete      			= "Wirklich l&ouml;schen";
$owl_lang->reallydelete_logs            	= "Wirklich das Logbuch l&ouml;schen";
$owl_lang->reallydelete_selected		= "M&ouml;chten Sie die markierte(n) Datei(en) wirklich l&ouml;schen";
$owl_lang->reallyrestore_selected       	= "M&ouml;chten Sie die markierte(n) Datei(en) wirklich wiederherstellen";
$owl_lang->size               			= "Gr&ouml;sse";
$owl_lang->score                        	= "Bewertung";
$owl_lang->title              			= "Name";
$owl_lang->doc_number 				= "Register-<br></br>nummer";
$owl_lang->tot_files                    	= "Total:";                                                                                         
$owl_lang->tot_my_checked_out           	= "Ausgecheckt:";
$owl_lang->tot_my_files         		= "Eigene:";
$owl_lang->tot_my_group                 	= "Gruppe:";
$owl_lang->tot_new_files                	= "Neu:";
$owl_lang->tot_updated_files            	= "Ge&auml;ndert:";
$owl_lang->tot_monitored			= "Beobachtet:";
$owl_lang->updated_file         		= "Aktualisiert!";
$owl_lang->user               			= "Benutzer";
$owl_lang->ver                			= "Ver.";
$owl_lang->folder_count_pre             	= "Dieses Verzeichnis enth&auml;lt";
$owl_lang->folder_count_folder          	= "Verzeichnis(se)";
$owl_lang->folder_count_file            	= "Datei(en)";
$owl_lang->folder_count_url             	= "URL";
$owl_lang->folder_count_note            	= "Notiz(en)";

//********************************************************
// browse.php  END
//********************************************************


//********************************************************
// modify.php  BEGIN
//********************************************************

$owl_lang->none_selected      			= "NICHTS GEW&Auml;HLT";
$owl_lang->adding_comments    			= "Kommentar hinzuf&uuml;gen/&auml;ndern: ";
$owl_lang->comments           			= "Kommentar";
$owl_lang->post_comment	      			= "Kommentar hinzuf&uuml;gen";
$owl_lang->addingfile         			= "Hinzuf&uuml;gen einer Datei zu ";
$owl_lang->addingfolder       			= "Hinzuf&uuml;gen eines Verzeichnisses zu ";
$owl_lang->attach_file        			= "Als Attachment versenden";
$owl_lang->change             			= "&Auml;ndern";
$owl_lang->comments_added     			= "Kommentar von: ";
$owl_lang->create             			= "Anlegen";
$owl_lang->description        			= "Beschreibung";
$owl_lang->disp_mp3           			= "MP3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Song:<br></br>Album:<br></br>Bitrate&nbsp;-&nbsp;Samplerate:<br></br>Dauer:<br></br>Genre:<br></br>Kommentare:";
$owl_lang->email_body         			= "Mitteilung";
$owl_lang->email_cc           			= "Kopie an";
$owl_lang->email_reply_to     			= "Antwort an";
$owl_lang->email_subject      			= "Betreff";
$owl_lang->email_to           			= "E-Mail an";
$owl_lang->emailing           			= "Versende";
$owl_lang->keywords           			= "Schlagwort(e)";
$owl_lang->modify_url         			= "URL";
$owl_lang->modifying          			= "&auml;ndern ";
$owl_lang->name               			= "Name";                                                                                                                                                   
$owl_lang->notify_link        			= "Owl externer Link";
$owl_lang->note_content       			= "Inhalt der Notiz";
$owl_lang->ownergroup         			= "Gruppe";
$owl_lang->ownership          			= "Besitzer";
$owl_lang->permissions        			= "Berechtigungen";                                                                                                                      
$owl_lang->prop_permissions   			= "Berechtigung auf die Unterverzeichnisse &uuml;bertragen";
$owl_lang->prop_perms_files   			= "Auf die Dateien zu &uuml;bertragende Berechtigung";
$owl_lang->policy             			= "Berechtigung:"; 
$owl_lang->pick_select        			= "&#8211; Einen Owl Benutzer w&auml;hlen &#8211;";
$owl_lang->sendthisfile       			= "Diese Datei senden";
$owl_lang->sendthisurl        			= "Diese URL senden";
$owl_lang->sendfile           			= "Datei senden";
$owl_lang->updating           			= "Aktualisieren";
$owl_lang->verdescription     			= "Beschreibung<br></br>der &Auml;nderungen";
$owl_lang->vermajor           			= "Komplette &Uuml;berarbeitung";
$owl_lang->verminor           			= "Kleinere &Auml;nderungen";
$owl_lang->vertype            			= "Art der &Uuml;berarbeitung";  // for modify.php when uploading

//********************************************************
// modify.php  END
//********************************************************


//********************************************************
// register.php  BEGIN
//********************************************************
                                                                                                       
$owl_lang->email             			= "E-Mail";
$owl_lang->full_name         			= "Vorname &#8211; Name";
$owl_lang->register          			= "Registrierung";
$owl_lang->self_failed         			= "Kein Erfolg";
$owl_lang->self_passwd         			= "Passwort gesendet an:";
$owl_lang->self_reg_bod        			= "Ihr Owl Passwort ist:";
$owl_lang->self_reg_rset       			= "Ihr Owl Passwort wurde zur&uuml;ckgesetzt. Das neue Passwort lautet:";
$owl_lang->self_reg_subj       			= "Ihr OWL Konto";
$owl_lang->send_pass         			= "Neues Passwort Senden";
$owl_lang->submit            			= "Registrieren";
$owl_lang->thank_you_1          		= "Danke!";
$owl_lang->thank_you_2          		= "Sie erhalten in K&uuml;rze ein E-Mail mit dem Passwort f&uuml;r den Benutzernamen:<br></br> ";

//********************************************************
// register.php  END
//********************************************************


//********************************************************
// move.php  BEGIN
//********************************************************

$owl_lang->cancel_button      			= "Abbrechen";
$owl_lang->moving             			= "Verschieben";
$owl_lang->moving_file				= "Datei verschieben";
$owl_lang->moving_folder			= "Ordner verschieben";
$owl_lang->copy_file				= "Datei kopieren";
$owl_lang->copy_folder				= "Ordner kopieren";
$owl_lang->select             			= "W&auml;hlen Sie ein neues Verzeichnis:";

//********************************************************
// move.php  END
//********************************************************


//********************************************************
// log.php  BEGIN
//********************************************************

$owl_lang->viewlog            			= "Zeige Log f&uuml;r ";

//********************************************************
// log.php  END
//********************************************************


//********************************************************
// prefs.php  BEGIN
//********************************************************

$owl_lang->confpassword 			= "Neues Passwort best&auml;tigen";
$owl_lang->comment_notif			= "Neue Kommentare per E-Mail melden";
$owl_lang->email_tool   			= "E-Mail Tool";
$owl_lang->last_modified			= "Zuletzt ge&auml;ndert";
$owl_lang->group        			= "Gruppe";
$owl_lang->groupmember  			= "Gruppenmitglied";
$owl_lang->newpassword  			= "Neues Passwort";
$owl_lang->newsadmin    			= "Mitteilungen-Administrator";
$owl_lang->not_member   			= "Sie sind nicht Mitglied anderer Gruppen.";
$owl_lang->notification 			= "Benachrichtigungen empfangen";
$owl_lang->oldpassword  			= "Altes Passwort";
$owl_lang->preference   			= "Einstellungen";
$owl_lang->saved        			= "&#8212; &Auml; N D E R U N G E N&nbsp;&nbsp;&nbsp;G E S P E I C H E R T &#8212;";
$owl_lang->status_no    			= "Nein";
$owl_lang->status_yes   			= "Ja";
$owl_lang->userlang     			= "Sprache";

//********************************************************
// prefs.php  END
//********************************************************


//********************************************************
// search.php  BEGIN
//********************************************************

$owl_lang->elapsed_time         		= "Ben&ouml;tigte Zeit:";
$owl_lang->search               		= "Suchen";
$owl_lang->search_any_word      		= "Jedes Wort";
$owl_lang->search_all_word      		= "Alle W&ouml;rter";
$owl_lang->search_entire_phrase 		= "Ganzer Satz";
$owl_lang->search_match         		= "Treffer:";
$owl_lang->search_currentfolder 		= "Aktuelles Verzeichnis durchsuchen";
$owl_lang->search_for_folders   		= "Nach Verzeichnissen suchen&#133;";
$owl_lang->search_for_files     		= "Nach Dateien suchen&#133;";
$owl_lang->search_score         		= "Resultate bewerten&#133;";
$owl_lang->search_results_for   		= "Suchergebnisse f&uuml;r";
$owl_lang->search_winthindocs   		= "In Dateien (Text, PDF und MS Word) suchen";
$owl_lang->related_query_empty  		= "Mit diesem Dokument sind keine Metadaten (Schlagworte) verkn&uuml;pft, um nach &auml;hnlichen Dokumenten zu suchen.";
$owl_lang->query_empty          		= "Bitte geben Sie einen Suchbegriff ein.";

//********************************************************
// search.php  END
//********************************************************


//********************************************************
// view.php  BEGIN
//********************************************************

$owl_lang->viewing            			= "Anzeige ";

//********************************************************
// view.php  END
//********************************************************


//********************************************************
// admin/index.php  BEGIN
//********************************************************

$owl_lang->display_password_override    	= "&Auml;nderungsfeld des Verzeichnis-/Datei-Passwortes anzeigen";
$owl_lang->download_folder_zip          	= "Verzeichnisse als ZIP herunterladen (Standard ist tar.gz)";
$owl_lang->doc_id_prefix                	= "Pr&auml;fix der Registernummer";
$owl_lang->doc_id_num_digits            	= "Anzahl Ziffern der Registernummer";
$owl_lang->view_doc_in_new_window       	= "Bei Dokumentenansicht neues Fenster &ouml;ffnen";
$owl_lang->admin_login_to_browse_page   	= "Bei Anmeldung als Administrator erscheint Dateibrowser";
$owl_lang->save_keywords_to_db          	= "Schlagw&ouml;rter d&uuml;rfen zur Wiederverwendung gespeichert werden";
$owl_lang->status_column                	= "Status";
$owl_lang->vermajor_initial             	= "Grosse Versionsnummer bei neuer Datei";
$owl_lang->verminor_initial             	= "Kleine Versionsnummer bei neuer Datei";
$owl_lang->docicon_column               	= "Doc Icon";
$owl_lang->btn_users_groups			= "Benutzer und<br></br>Gruppen";
$owl_lang->alt_users_groups			= "Benutzer und Gruppen administrieren";
$owl_lang->btn_html_prefs			= "HTML<br></br>Voreinstellungen";
$owl_lang->alt_html_prefs			= "HTML Voreinstellungen editieren";
$owl_lang->btn_site_features			= "OWL<br></br>Eigenschaften";
$owl_lang->alt_site_features			= "Einstellungen und Eigenschaften editieren";
$owl_lang->btn_log_viewer			= "Logbuch";
$owl_lang->alt_log_viewer			= "Owl System Logbuch";
$owl_lang->btn_statistics_viewer		= "Berichte und<br></br>Statistiken";
$owl_lang->alt_statistics_viewer		= "Owl Statistiken";
$owl_lang->btn_news_admin			= "Mitteilungen-<br></br>Administration";
$owl_lang->alt_news_admin			= "Owl News-Administration";
$owl_lang->btn_doctype_admin			= "Dokumenten-<br></br>typen";
$owl_lang->alt_doctype_admin			= "Dokumententyp Administration";
$owl_lang->btn_backup				= "Datenbank<br></br>Backup";
$owl_lang->alt_backup				= "SQL Datenbank Backup";
$owl_lang->btn_trashcan				= "Papierkorb";
$owl_lang->alt_trashcan				= "Klicken Sie, um den Inhalt zu sehen";
$owl_lang->btn_initial_load			= "Erstmalige<br></br>Installation";
$owl_lang->alt_initial_load			= "Die Datenbank erstellen aufgrund des Dokumentenverzeichnisses";
$owl_lang->confirm_initial_load			= "*** ACHTUNG ***  Diese Installation darf nur bei einer leeren Datenbank und nur einmal durchgef&uuml;hrt werden!";
$owl_lang->add                			= "Hinzuf&uuml;gen";
$owl_lang->anonymous_account            	= "Anonymes Benutzerkonto:";                                                                                                                      
$owl_lang->buttonstyle                  	= "Stil der Kn&ouml;pfe";
$owl_lang->deletegroup        			= "Gruppe l&ouml;schen";
$owl_lang->deleteuser         			= "Benutzer l&ouml;schen";
$owl_lang->disableuser        			= "Benutzer deaktivieren";
$owl_lang->disable_recs_per_page        	= "Mit Eingeschr&auml;nkter Ansicht ist die Darstellung des Inhaltes auf mehreren Seiten nicht m&ouml;glich!";
$owl_lang->file_admin_group             	= "File/Browser Admin Gruppe:";
$owl_lang->flushed            			= "Die Sessiontabelle wurde bereinigt. Der Nutzer kann sich wieder anmelden!";
$owl_lang->groups             			= "Gruppen";
$owl_lang->hide_bulk_buttons            	= "Auswahl-Kn&ouml;pfe nicht anzeigen:";
// Edit HTML Properties Messages
$owl_lang->ht_tbl_border_sz   			= "Gr&ouml;sse des Tabellenrandes (0 = kein Rand):";
$owl_lang->ht_tbl_hd_bg       			= "Hintergrundfarbe des Tabellenkopfs:";
$owl_lang->ht_tbl_cell_bg_cl  			= "Erste Hintergrundfarbe der Tabellenfelder:";
$owl_lang->ht_tbl_cell_bg_al  			= "Zweite Hintergrundfarbe der Tabellenfelder:";
$owl_lang->ht_expand_width    			= "Breite Erweiterte Ansicht:";
$owl_lang->ht_collapse_width  			= "Breite Normalansicht:";
$owl_lang->ht_bd_bg_image     			= "Pfad zum Hintergrundbild (../graphics/back.jpg):";
$owl_lang->ht_bd_txt_cl       			= "Textfarbe:";
$owl_lang->ht_bd_lnk_cl       			= "Textfarbe f&uuml;r Links:";
$owl_lang->ht_bd_vlnk_cl      			= "Textfarbe f&uuml;r benutzte Links:";
// Edit Prefs Properties Messages
$owl_lang->home_dir                     	= "Hauptverzeichnis des Benutzers";
$owl_lang->initial_dir                  	= "Home-Verzeichnis des Benutzers";
$owl_lang->maxsessions        			= "Maximale Anzahl an Sessions";
$owl_lang->noprefaccess       			= "Pers&ouml;nliche Einstellungen deaktivieren ";
$owl_lang->owl_anon_full                	= "Voller Zugang";
$owl_lang->owl_anon_ro       			= "Nur Lesen";
$owl_lang->owl_anon_download            	= "Nur Herunterladen";
$owl_lang->anonymous_access             	= "Berechtigung f&uuml;r anonyme Benutzer";
$owl_lang->owl_dbdump_path    			= "Pfad zum DB-Dump-Tool (leer = deaktiviert):";
$owl_lang->owl_def_file_group_owner 		= "Standardbesitzer f&uuml;r Dateigruppen:";
$owl_lang->owl_def_file_meta  			= "Standard-Metadaten f&uuml;r Dateien:";
$owl_lang->owl_def_file_owner 			= "Standardbesitzer f&uuml;r Dateien:";
$owl_lang->owl_def_file_perm 			= "Standardberechtigung bei neuen Dateien:";
$owl_lang->owl_def_file_security 		= "Standard-Dateisicherheit:";
$owl_lang->owl_def_file_title 			= "Standard-Dateititel (leer = Dateiname):";
$owl_lang->owl_def_fold_group_owner  		= "Standardbesitzer f&uuml;r Verzeichnisgruppen:";
$owl_lang->owl_def_fold_owner        		= "Standardbesitzer f&uuml;r Verzeichnisse:";
$owl_lang->owl_def_fold_sec   			= "Standard-Verzeichnissicherheit:";
$owl_lang->owl_def_folder_perm 			= "Standardberechtigung bei neuen Verzeichnissen:";
$owl_lang->owl_default_tmpdir   		= "Verzeichnis f&uuml;r tempor&auml;re Dateien: ";
$owl_lang->owl_email_from     			= "Absenderadresse:";
$owl_lang->owl_email_fromname 			= "Absendername:";
$owl_lang->owl_email_replyto  			= "Antwortadresse:";
$owl_lang->owl_email_server   			= "E-Mail-Serveradresse:";
$owl_lang->owl_email_smtp               	= "SMTP System";
$owl_lang->owl_email_smtp_auth          	= "SMTP Auth verwenden";
$owl_lang->owl_email_smtp_auth_login		= "SMTP Auth Login:";
$owl_lang->owl_email_smtp_auth_passwd   	= "SMTP Auth Passwort";
$owl_lang->owl_email_subject_pref      		= "E-Mail Betreff Pr&auml;fix:";
$owl_lang->owl_fogotpass             		= "Link f&uuml;r vergessenes Passwort anzeigen";
$owl_lang->owl_group_user    			= "Mitglieder von diese Gruppe";
$owl_lang->owl_gzip_path      			= "Pfad zu gzip (leer = deaktiviert):";
$owl_lang->owl_hidebackup    			= "Backup-Verzeichnis verbergen";
$owl_lang->owl_log_file      			= "Dateien loggen";
$owl_lang->owl_log_login_act 			= "An/Abmeldung loggen";
$owl_lang->owl_log_rec_page  			= "Logbuch Eintr&auml;ge/Seite:";
$owl_lang->owl_logging       			= "Logbuch aktivieren";
$owl_lang->owl_logo                  		= "Logo auf der Anmelde Seite (graphics/):";
$owl_lang->owl_lookAtHD       			= "Bestehendes Dateisystem nicht beachten";
$owl_lang->owl_lookAtHDDel   			= "Gel&ouml;schte Dateien aus der Datenbank entfernen";
$owl_lang->hide_folder_doc_count        	= "Verzeichnis-/Dateiz&auml;hler verbergen";
$owl_lang->hide_folder_size             	= "Verzeichnisgr&ouml;sse verbergen";
$owl_lang->old_action_icons             	= "Alte Aktionskn&ouml;pfe (vor Owl 0.80) verwenden";
$owl_lang->search_result_folders        	= "Verzeichnisse in die Suchresultate einbeziehen";
$owl_lang->restore_file_prefix          	= "Pr&auml;fix f&uuml;r wiederhergestellte Dateien";
$owl_lang->owl_max_filesize   			= "Maximale Dateigr&ouml;sse f&uuml;r Upload";
$owl_lang->owl_owl_expand     			= "Standardansicht ist die erweiterte Ansicht";
$owl_lang->owl_owl_timeout    			= "Session-Timeout in Sekunden";
$owl_lang->virus_path                   	= "Pfad zur Antivirussoftware (z.B. '/usr/bin/clamscan --quiet')<br></br>(leer = deaktiviert):";
$owl_lang->owl_pdftotext_path           	= "Pfad zu pdftotext (leer = deaktiviert):";
$owl_lang->owl_wordtotext_path          	= "Pfad zu antiword (leer = deaktiviert):";
$owl_lang->owl_pod2html_path            	= "Perl 5.8.0 oder neuer wird ben&ouml;tigt<br></br>Pfad zu pod2html:";
$owl_lang->owl_restrict_view  			= "Eingeschr&auml;nkte Ansicht erlauben";
$owl_lang->owl_self_reg      			= "Selbstregistrierung erlauben";
$owl_lang->owl_self_reg_hd   			= "SELBSTREGISTRIERUNG VON BENUTZERN";
$owl_lang->owl_tar_path     	 		= "Pfad zu tar (leer = deaktiviert):";
$owl_lang->owl_title_custom             	= "SPALTEN DES DATEIBROWSERS";
$owl_lang->owl_title_custom_search      	= "SPALTEN DER SUCHRESULTATE";
$owl_lang->owl_title_browser            	= "DATEIBROWSER";
$owl_lang->owl_title_defaults   		= "STANDARD";
$owl_lang->owl_title_email    			= "E-MAIL EINSTELLUNGEN";
$owl_lang->owl_title_HD       			= "NEUE DATEIEN AUTOMATISCH ERKENNEN UND &Uuml;BERNEHMEN";
$owl_lang->owl_title_logging  			= "LOGBUCH";
$owl_lang->owl_title_other    			= "WEITERE EINSTELLUNGEN";
$owl_lang->owl_title_tools    			= "HILFSPROGRAMME";
$owl_lang->owl_unzip_path               	= "Pfad zu unzip (leer = deaktiviert):";
$owl_lang->owl_version_control 			= "Versionskontrolle einschalten";
$owl_lang->quota              			= "Speicherlimit (0 = kein)";
$owl_lang->reallydeluser                	= "Dieser Benutzer besitzt %numfiles% Datei(en) und %numfolders% Verzeichnis(se). Alle diese Dateien und Verzeichnisse werden verwaist. M&ouml;chten Sie trotzdem L&ouml;schen?";
$owl_lang->recs_per_page                	= "Anzahl Eintr&auml;ge pro Seite (0 = Alles auf einer Seite):";
$owl_lang->remember_me_title            	= "AUTOMATISCHE ANMELDUNG";
$owl_lang->remember_me                  	= "Automatische Anmeldung zulassen";
$owl_lang->remember_timeout             	= "Anzahl Tage bis das Cookie abl&auml;uft";
$owl_lang->remember_me_checkbox         	= "Automatische Anmeldung";
$owl_lang->recycle_title                	= "PAPIERKORB";
$owl_lang->recycle_enabled              	= "Papierkorb aktivieren";
$owl_lang->recycle_location             	= "Papierkorb Verzeichnis:";
$owl_lang->show_panel_title			= "Statusanzeige:";
$owl_lang->show_search_title			= "Suchbalken:";
$owl_lang->show_pref_title			= "Einstellungen und An-/Abmeldung:";
$owl_lang->show_bulk_title			= "Auswahlkn&ouml;pfe:";
$owl_lang->show_action_title			= "Aktionskn&ouml;pfe:";
$owl_lang->show_folder_title			= "Kn&ouml;pfe f&uuml;r Verzeichniseinstellungen:";
$owl_lang->show_panel				= "Anzeigen";
$owl_lang->hide_panel				= "Verbergen";
$owl_lang->status_bar_both              	= "Oben und unten";
$owl_lang->status_bar_bottom            	= "Unten";
$owl_lang->status_bar_location          	= "Statusanzeige Balken:";
$owl_lang->status_bar_top               	= "Oben";
$owl_lang->status_bar_not               	= "Verbergen";
$owl_lang->use_popup                    	= "Mitteilungen-Anzeige mit Pop-Up";
$owl_lang->users              			= "Benutzer";
$owl_lang->header_user_admin           		= "Benutzer Administration";
$owl_lang->header_group_admin           	= "Gruppen Administration";
$owl_lang->header_sitefeatures_settings 	= "OWL Eigenschaften und Einstellungen";

//********************************************************
// admin/index.php  END
//********************************************************


//********************************************************
// admin/log.php  BEGIN
//********************************************************

$owl_lang->owl_log_viewer    			= "Logbuch";
$owl_lang->owl_log_hd_action 			= "Aktion";
$owl_lang->owl_log_hd_file   			= "Datei";
$owl_lang->owl_log_hd_fld_path			= "Verzeichnis";
$owl_lang->owl_log_hd_user   			= "Benutzer";
$owl_lang->owl_log_hd_dt_tm  			= "Datum/Zeit";
$owl_lang->owl_log_hd_ip     			= "IP-Adresse";
$owl_lang->owl_log_hd_agent  			= "Browser";
$owl_lang->owl_log_hd_dtls   			= "Details";
$owl_lang->owl_log_no_rec    			= "Nichts gefunden!";
$owl_lang->owl_log_hide      			= "Nicht anzeigen: ";
$owl_lang->owl_log_filter    			= "Filtern";

//********************************************************
// admin/log.php  END
//********************************************************


//********************************************************
// admin/recycle.php  BEGIN
//********************************************************

$owl_lang->empty_trash          		= "Papierkorb leeren";
$owl_lang->really_empty_trash   		= "Sind Sie sicher?";
$owl_lang->recycle_bin_admin    		= "Papierkorb Administration";

//********************************************************
// admin/recycle.php  END
//********************************************************


//********************************************************
// lib/owl.lib.php  BEGIN
//********************************************************

$owl_lang->file_size_byte                       = "B";
$owl_lang->file_size_gigabyte                   = "GB";
$owl_lang->file_size_kilobyte                   = "kB";
$owl_lang->file_size_megabyte                   = "MB";
$owl_lang->notif_subject_new     		= "Neue OWL Intranet Datei";
$owl_lang->notif_subject_upd  	 		= "Eine OWL Intranet Datei wurde aktualisiert";
$owl_lang->notif_subject_monitor 		= "Eine von Ihnen beobachtete OWL Datei wurde aktualisiert";
$owl_lang->notif_subject_comment        	= "OWL Intranet Datei -- Kommentar hinzugef&uuml;gt";
$owl_lang->notif_comment_1              	= "kommentierte";
$owl_lang->notif_comment_2              	= "Kommentar:";
$owl_lang->notif_msg          			= "DIES IST EINE AUTOMATISCHE MITTEILUNG VON OWL Intranet<br></br>Die neue/ge&auml;nderte Datei ist angeh&auml;ngt.<br></br>";
$owl_lang->notif_msg_alt          		= "DIES IST EINE AUTOMATISCHE MITTEILUNG VON OWL Intranet\n\nDie neue/ge&auml;nderte Datei ist angeh&auml;ngt.\n\n";
$owl_lang->notif_msg_link                       = "DIES IST EINE AUTOMATISCHE MITTEILUNG VON OWL Intranet<br></br>Bitte beachten Sie den Link zur neuen/ge&auml;nderten Datei.<br></br>";
$owl_lang->notif_msg_alt_link                   = "DIES IST EINE AUTOMATISCHE MITTEILUNG VON OWL Intranet\n\nBitte beachten Sie den Link zur neuen/ge&auml;nderten Datei.\n\n";
$owl_lang->notif_salutation             	= "Sehr geehrte(r)";
$owl_lang->notif_user                   	= "Erstellt/Aktualisiert von:";
$owl_lang->owl_path                     	= "Verzeichnis: ";
$owl_lang->sessinuse          			= "Diese Session ist bereits auf einem anderen Computer aktiv. Zugang verweigert.";
$owl_lang->invalidsess        			= "Ung&uuml;ltige Anmeldung. Gehen Sie bitte zur Hauptseite<br></br>";
$owl_lang->sesstimeout        			= "Zeit&uuml;berschreitung! Bitte melden Sie sich neu an<br></br>";
$owl_lang->everyoneread       			= "Jeder kann lesen/herunterladen";
$owl_lang->everyonewrite      			= "Jeder kann lesen/schreiben/herunterladen";
$owl_lang->everyonewrite_nod  			= "Jeder kann lesen/schreiben/herunterladen, aber NICHT l&ouml;schen";
$owl_lang->groupread          			= "Ihre Gruppe kann lesen/herunterladen";
$owl_lang->groupwrite         			= "Ihre Gruppe kann lesen/schreiben/herunterladen";
$owl_lang->groupwrite_nod     			= "Ihre Gruppe kann lesen/schreiben/herunterladen, aber NICHT l&ouml;schen";
$owl_lang->onlyyou            			= "Nur Sie k&ouml;nnen lesen/schreiben/herunterladen";
$owl_lang->donothing                    	= "Nichts tun &#8211; Berechtigungen belassen";
$owl_lang->groupwrite_worldread 		= "Ihre Gruppe kann lesen/schreiben/herunterladen und jeder kann lesen";
$owl_lang->groupwrite_worldread_nod 		= "Ihre Gruppe kann lesen/schreiben/herunterladen, aber NICHT l&ouml;schen, jeder kann lesen";
$owl_lang->ggroupwrite_worldread 		= "Ihre Gruppe kann Dateien hochladen und dieses Verzeichnis l&ouml;schen, jeder kann den lesen";
$owl_lang->ggroupwrite_worldread_nod 		= "Ihre Gruppe kann Dateien hochladen und jeder kann den Inhalt lesen, aber NICHT l&ouml;schen";
$owl_lang->everyoneread_ad    			= "Jeder kann lesen/herunterladen";
$owl_lang->everyonewrite_ad   			= "Jeder kann lesen/schreiben/herunterladen";
$owl_lang->everyonewrite_ad_nod 		= "Jeder kann lesen/schreiben/herunterladen, aber NICHT l&ouml;schen";
$owl_lang->groupread_ad       			= "Die ausgew&auml;hlte Gruppe kann lesen/herunterladen";
$owl_lang->groupwrite_ad      			= "Die ausgew&auml;hlte Gruppe kann lesen/schreiben/herunterladen";
$owl_lang->groupwrite_ad_nod  			= "Die ausgew&auml;hlte Gruppe kann lesen/schreiben/herunterladen, aber NICHT l&ouml;schen";
$owl_lang->onlyyou_ad         			= "Nur der Besitzer kann lesen/schreiben/herunterladen";
$owl_lang->groupwrite_worldread_ad 		= "Die ausgew&auml;hlte Gruppe kann lesen/schreiben/herunterladen, jeder kann lesen";
$owl_lang->groupwrite_worldread_ad_nod 		= "Die ausgew&auml;hlte Gruppe kann lesen/schreiben/herunterladen, aber NICHT l&ouml;schen, jeder kann lesen";
$owl_lang->ggroupwrite_worldread_ad 		= "Die ausgew&auml;hlte Gruppe kann Dateien hochladen und dieses Verzeichnis l&ouml;schen, jeder kann den Inhalt lesen";
$owl_lang->ggroupwrite_worldread_ad_nod 	= "Die ausgew&auml;hlte Gruppe kann Dateien in dieses Verzeichnis hochladen, jeder kann den Inhalt lesen, aber NICHT l&ouml;schen";
$owl_lang->geveryoneread_ad   			= "Jeder kann dieses Verzeichnis lesen";
$owl_lang->geveryonewrite_ad  			= "Jeder kann Dateien erstellen und das Verzeichnis l&ouml;schen";
$owl_lang->geveryonewrite_ad_nod 		= "Jeder kann Dateien in dieses Verzeichnis speichern";
$owl_lang->ggroupread_ad      			= "Ihre Gruppe kann dieses Verzeichnis lesen";
$owl_lang->ggroupwrite_ad     			= "Ihre Gruppe kann Dateien erstellen und das Verzeichnis l&ouml;schen";
$owl_lang->ggroupwrite_ad_nod 			= "Die ausgew&auml;hlte Gruppe kann Dateien in dieses Verzeichnis speichern";
$owl_lang->gonlyyou_ad        			= "Nur Sie k&ouml;nnen Dateien erstellen und das Verzeichnis l&ouml;schen";
$owl_lang->geveryoneread      			= "Jeder kann dieses Verzeichnis lesen";
$owl_lang->geveryonewrite     			= "Jeder kann Dateien erstellen und das Verzeichnis l&ouml;schen";
$owl_lang->geveryonewrite_nod 			= "Jeder kann Dateien in dieses Verzeichnis speichern";
$owl_lang->ggroupread         			= "Ihre Gruppe kann dieses Verzeichnis lesen";
$owl_lang->ggroupwrite        			= "Ihre Gruppe kann Dateien erstellen und das Verzeichnis l&ouml;schen";
$owl_lang->ggroupwrite_nod    			= "Ihre Gruppe kann Dateien in dieses Verzeichnis speichern";
$owl_lang->gonlyyou           			= "Nur Sie k&ouml;nnen Dateien erstellen und das Verzeichnis l&ouml;schen";
$owl_lang->orphaned                         	= "&#8211; KEIN Besitzer &#8211;";
$owl_lang->virus_infected 			= "VIRUSINFIZIERTE DATEI";
$owl_lang->virus_return_val			= "Antivirus Programm Ausgabewert:";

//********************************************************
// lib/owl.lib.php  END
//********************************************************


//********************************************************
// HREF TITLE messages  BEGIN
//********************************************************

$owl_lang->title_browse_folder          	= "Verzeichnis &ouml;ffnen";
$owl_lang->title_browse_site            	= "URL &ouml;ffnen";
$owl_lang->title_download_view          	= "Datei herunterladen";
$owl_lang->title_edit_prefs             	= "Ihre pers&ouml;nlichen Einstellungen &auml;ndern";
$owl_lang->title_return_folder          	= "Zum Verzeichnis:";
$owl_lang->title_sort                   	= "Sortieren nach";
$owl_lang->title_view_new               	= "Neue Dateien seit Ihrem letztem Besuch";
$owl_lang->title_view_updated           	= "Ge&auml;nderte Dateien seit letztem Besuch";
$owl_lang->title_view_my                	= "Liste Ihrer Dateien";

//********************************************************
// HREF TITLE messages  END
//********************************************************


//********************************************************
// admin/news.php and newsread.php BEGIN
//********************************************************

$owl_lang->news_title                   	= "Mitteilungen-Administration";
$owl_lang->news_hd                     		= "Mitteilungen";
$owl_lang->news_hd_created              	= "Erstellt am";
$owl_lang->news_hd_expires              	= "Ablaufdatum";
$owl_lang->news_hd_audience             	= "Zielgruppe";
$owl_lang->news_heading				= "Titel";
$owl_lang->news_content                 	= "Mitteilung";
$owl_lang->news_posted_date             	= "Erstellt";
$owl_lang->news_read                    	= "Gelesen";

//********************************************************
// admin/news.php and newsread.php  END
//********************************************************


//********************************************************
// DEBUG MESSAGES BEGIN
//********************************************************

$owl_lang->debug_tmp_not_exists         	= "DEBUG: Das tempor&auml;re Verzeichnis: $default->owl_tmpdir existiert nicht.";
$owl_lang->debug_tmp_not_writeable      	= "DEBUG: Das tempor&auml;re Verzeichnis: $default->owl_tmpdir kann vom Web Server nicht beschrieben werden.";
$owl_lang->debug_doc_not_exists         	= "DEBUG: Das OWL Verzeichnis: " .$default->owl_fs_root . "/" . fid_to_name(1) ." existiert nicht.";
$owl_lang->debug_doc_not_writeable      	= "DEBUG: Das OWL Verzeichnis: " .$default->owl_fs_root . "/" . fid_to_name(1) ." kann vom Web Server nicht beschrieben werden.";
$owl_lang->debug_webserver_no_access		= "DEBUG: Der Webserver hat keine Leseberechtigung f&uuml;r: <br />'$default->owl_fs_root/$filename'. <br />Bitte korrigieren Sie die Berechtigungen und versuchen Sie es erneut.";
$owl_lang->debug_file_not_exist			= "DEBUG: Die ben&ouml;tigte Datei '$default->owl_fs_root/$filename' existiert nicht.<br /> ODER<br />Der durch \$default->owl_fs_root in config/owl.php beschriebene Pfad ist falsch.";

//********************************************************
// DEBUG MESSAGES END
//********************************************************


//********************************************************
// admin/stats.php BEGIN
//********************************************************

$owl_lang->owl_stats_viewer     		= "Berichte und Statistiken";
$owl_lang->stats_files          		= "Anzahl Dateien/Benutzer";
$owl_lang->stats_folders        		= "Anzahl Verzeichnis/Benutzer";
$owl_lang->stats_top            		= "Top 20 Downloads";
$owl_lang->stats_users           		= "Benutzer (Angemeldet/Anmeldefehler/Abgemeldet)";
$owl_lang->stats_users_loggedin 		= "Zurzeit Angemeldet";
$owl_lang->stats_information    		= "Owl Logging muss aktiviert sein, damit Statistiken dargestellt werden k&ouml;nnen.";

//********************************************************
// admin/stats.php END
//********************************************************

//********************************************************
// admin/doctype.php BEGIN
//********************************************************

$owl_lang->document_type        		= "Dokumententyp";
$owl_lang->document_type_name   		= "Dokumententyp Name";
$owl_lang->doc_field_name       		= "Feldname";
$owl_lang->doc_field_pos        		= "Feldposition";
$owl_lang->doc_field_label      		= "Dargestellter Name (Nach Sprache)";
$owl_lang->doc_field_size       		= "Feldgr&ouml;sse";
$owl_lang->doc_field_searchable 		= "Durchsuchbar";
$owl_lang->doc_field_required   		= "Ben&ouml;tigt";
$owl_lang->doc_new_doc_type     		= "&#8211; Neuen Dokumententyp erstellen &#8211;";
$owl_lang->doc_specific         		= "Dokumentenspezifische Felder";
$owl_lang->doc_administration   		= "Dokumententyp Admininstration";

//********************************************************
// admin/doctype.php END
//********************************************************

                                                                                                                                                                           
//********************************************************
// DOC PEER Review  BEGIN
//********************************************************
                                                                                                                                                                           
$owl_lang->peer_reviewer_list   = "Korreferent(en)";
$owl_lang->peer_msg_to_reviewer = "Mitteilung an die Korreferenten";
$owl_lang->peer_final_approval  = "[Endg&uuml;ltige Genehmigung]: ";
$owl_lang->peer_subj_review     = "Sie haben ein Owl Dokument zur Bewertung";
$owl_lang->peer_subj_approved   = "Ihr Dokument wurde GENEHMIGT";
$owl_lang->peer_subj_rejected   = "Ihr Dokument wurde ZUR&Uuml;CKGEWIESEN";
$owl_lang->peer_subj_reminder   = "ERINNERUNG: Sie haben ein Owl Dokument zur Bewertung";
$owl_lang->peer_notif_user      = "Erstellt/Ge&auml;ndert von";
$owl_lang->peer_file_to_review  = "Datei zur Bewertung:";
$owl_lang->peer_file_approved   = "Datei Genehmigt:";
$owl_lang->peer_file_rejected   = "Datei Zur&uuml;ckgewiesen:";
$owl_lang->peer_file_final      = "Endg&uuml;ltige Genehmigung:";
$owl_lang->peer_final_body      = "Ihr Dokument wurde von allen angefragten Korreferenten genehmigt. Bitte melden Sie sich an und ver&ouml;ffentlichen Sie das Dokument";
$owl_lang->peer_review_body     = "Sie wurden angefragt, folgendes Dokument zu bewerten:";
$owl_lang->peer_approved_body   = "Ihre Datei wurde genehmigt:";
$owl_lang->peer_rejected_body   = "Ihre Datei wurde zur&uuml;ckgewiesen:";
$owl_lang->peer_my_approval     = "Erwarten meine Genehmigung";
$owl_lang->peer_pending_approval= "Meine ausstehenden Genehmigungen";
$owl_lang->peer_satus_pending   = "&#8212; A U S S T E H E N D &#8212;";
$owl_lang->peer_satus_rejected  = "&#8212; Z U R &Uuml; C K G E W I E S E N &#8212;";
$owl_lang->peer_satus_approved  = "&#8212; G E N E H M I G T &#8212;";
$owl_lang->peer_satus           = "Status";
$owl_lang->peer_pending_title   = "Meine Dokumente Mit Ausstehender Bewertung";
$owl_lang->peer_approval_title  = "Auf Meine Bewertung Wartende Dokumente";                                                                                                                 
$owl_lang->owl_title_peer_review= "DOKUMENTEN PEER REVIEW FEATURE";
$owl_lang->owl_peer_review      = "Peer Review Feature einschalten:";
$owl_lang->owl_peer_review_opt  = "Peer Review optional machen:";
                                                                                                                                                                           
//********************************************************
// DOC PEER Review  END
//********************************************************
?>
