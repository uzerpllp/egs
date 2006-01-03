<?php

/*

  File: Estonian/language.inc
  Author: Argo Laanemets, Tea Tanner (kill@saba.purk.ee)
  Date: 15.07.2004
  E-mail: argo@inforing.ee, argo@ns.purk.ee
  Owl: Copyright Chris Vincent <cvincent@project802.net>

  You should have received a copy of the GNU Public
  License along with this package; if not, write to the
  Free Software Foundation, Inc., 59 Temple Place - Suite 330,
  Boston, MA 02111-1307, USA.

*/
//********************************************************
// Date Formating BEGIN
//********************************************************

// If config/owl.php   $default->generic_date_format is set USE That one if not
// use the one in this file

if (isset($default->generic_date_format) && trim($default->generic_date_format) != "") {

	$owl_lang->localized_date_format = $default->generic_date_format;
} else {
	$owl_lang->localized_date_format = "M d, Y \a\\t h:i a";
}

// Character Encoding
// default: "UTF-8"
$owl_lang->charset = "UTF-8";

//********************************************************
// Date Formating BEGIN
//********************************************************


//********************************************************
// Error Messages BEGIN
//********************************************************

$owl_lang->err_select_reviewer          = "Please select at least one Person to review your document";
$owl_lang->err_adding_comments		= "Sa ei saa sellele failile kommentaare lisada";
$owl_lang->err_comment_empty            = "Comment cannot be empty";
$owl_lang->err_backup_file   		= "Viga olemasolevast failist varufaili tegemisel";
$owl_lang->err_backup_folder_create 	= "Viga varukausta loomisel";
$owl_lang->err_bad_url			= "Palun sisesta kehtiv URL";
$owl_lang->err_bad_version_1 		= "Owl Intranet vajab minimaalset PHP versiooni";
$owl_lang->err_bad_version_2 		= "Versioon";
$owl_lang->err_bad_version_3 		= "Installeerige n&otilde;utav PHP versioon ja proovige uuesti";
$owl_lang->err_email         		= "Meili pole v&otilde;imalik saata";
$owl_lang->err_email_required		= "E-maili v&auml;li on n&otilde;utav";
$owl_lang->err_fexist1			= "<b>Fail on olemas:</b>";
$owl_lang->err_fexist2 			= "Sama nimega fail on juba olemas <i>";
$owl_lang->err_fexist3 			= "</i> selles kataloogis.";
$owl_lang->err_file_exists		= "Fail, mida Sa &uuml;ritad &uuml;les laadida on juba olemas";
$owl_lang->err_fileexists    		= "Liigutamine t&uuml;histatud.<BR>Samanimeline fail on juba olemas.";
$owl_lang->err_file_lock     		= "You cannot check this file out, it is currently held by";
$owl_lang->err_update_file_lock         = "You cannot update this file, it is currently held by";
$owl_lang->err_filemove_exist           = "Failinimi mida te proovite &uuml;mbernimetada, on juba olemas";
$owl_lang->err_file_not_exist		= "Kahjuks puudub see fail s&uuml;steemist";
$owl_lang->err_file_too_big		= "php.ini upload_max_filesize on &uuml;letatud v&otilde;i<BR>Owl maksimaalse &uuml;leslaetava falisuurus OWL Intarnetis on liiga v&auml;ike";
$owl_lang->err_file_update		= "Faili uuendamisel ei tohi muuta failinime!";
$owl_lang->err_folder_create 		= "Kataloogi tegermisel tekkis viga";
$owl_lang->err_folder_exist		= "See kataloog on juba olemas";
$owl_lang->err_folderexists  		= "&Uuml;mbernimetamine on t&uuml;histatud.<BR>Sama nimega kataloog on juba olemas!.";
$owl_lang->err_general 			= "Tekkis viga!";
$owl_lang->err_group_delete		= "Gruppi millel on liige ei saa kustutada!";
$owl_lang->err_group_exists		= "Sellise nimega grupp on juba olemas!.";
$owl_lang->err_gzip_not_found  		= "Puudub gzip";
$owl_lang->err_login			= "Palun logige sisse, et teha vajalikud toimingud";
$owl_lang->err_movecancel    		= "Liigutamine t&uuml;histatud<BR>";
$owl_lang->err_nameempty    		= "Kaustal peab olema nimi!";
$owl_lang->err_news_required		= "VIGA: Puudub Pealkiri ja Sisu!";
$owl_lang->err_no_access 		= "Antud failile puudub teil ligip&auml;&auml;s!";
$owl_lang->err_no_access_info           = "Possible causes: <br></br>1) You did not click any checkbox in front of a File or Folder<br></br>2) Bulk Delete, Bulk Email, Bulk Checkout do not apply to Folders<br></br>3) You do not have access to any of the files or folders you have selected.";
$owl_lang->err_noemail			= "Antud failile puudub teil ligip&auml;&auml;s,et saata emailile!";
$owl_lang->err_nofileaccess		= "Antud failile puudub teil ligip&auml;&auml;s!";
$owl_lang->err_nofiledelete		= "Teil puudub &otilde;igus,et kustutada see fail!";
$owl_lang->err_nofilemod		= "Teil puudub &otilde;igus,et muuta seda faili!";
$owl_lang->err_nofolderaccess		= "Teil puudub &otilde;igus,et vaadata seda kataloogi!";
$owl_lang->err_nofolderdelete		= "Teil puudub &otilde;igus,et kustutada see kataloog";
$owl_lang->err_nofoldermod		= "Teil puudub &otilde;igus,et muuta seda kataloogi!";
$owl_lang->err_nosubfolder		= "Teil puudub &otilde;ugus,et moodustada alamkatalooge siia!";
$owl_lang->err_note_title               = "Pealkiri on vajalik v&auml;li!";
$owl_lang->err_note_title_exists        = "M&auml;rge sama nimega on juba olemas!";
$owl_lang->err_noupload			= "Teil puudub &otilde;igus,et &uuml;les laadida faile sellesse kausta!";
$owl_lang->err_pass_missmatch		= "Uus parool ja kinnitatud parool ei &uuml;hti!";
$owl_lang->err_pass_wrong    		= "Vana parool on vale!";
$owl_lang->err_pod2html_not_found       = "VIGA: Puudub pod2html:";
$owl_lang->err_quota			= "Teie ketta kasutus on piiratud,et &uuml;les laadida seda faili!: ";
$owl_lang->err_quota_needed		= " vajalik ";
$owl_lang->err_quota_avail		= " saadaval.";
$owl_lang->err_quota_exceed  		= "Teie ketta kasutus on &uuml;letatud!";
$owl_lang->err_req			= "VIGA: K&otilde;ik v&auml;ljad peavad olema t&auml;idetud!";
$owl_lang->err_root_delete		= "Juurkausta ei saa kustutada!";
$owl_lang->err_sess_notvalid 		= "Sessiooni id on vale!";
$owl_lang->err_sess_write		= "Tekkis viga sessiooni andmete kirjutamisel andmebaasi!";
$owl_lang->err_specialfoldername 	= "'backup' on Owl Intraneti poolt reserveeritud kataloogi nimi!";
$owl_lang->err_tar_not_found  		= "Puudub tar ";
$owl_lang->err_trash_can_empty 		= "Pr&uuml;gikast on t&uuml;hi";
$owl_lang->err_unauth_area   		= "Teil puudub &otilde;igus,et n&auml;ha seda piirkonda!";
$owl_lang->err_unauthorized  		= "Kinnitamata";
$owl_lang->err_upload 			= "Tekkis VIGA faili &uuml;les laadimisel!";
$owl_lang->err_user_exists		= "Kasutajanimi on juba olemas!";
$owl_lang->err_cant_del_doc_type	= "Cannot Delete there are files using this Document Type";
$owl_lang->err_doc_type_name_req	= "Dokumendi t&uuml;&uuml;bi nimi on vajalik! <BR>";
$owl_lang->err_doc_field_req            = "Missing Required Field:";
$owl_lang->err_field_name_req		= "V&auml;lja nimi on vajalik <BR>";
$owl_lang->err_field_label_req 		= "V&auml;lja kirjeldus on vajalik <BR>";
$owl_lang->err_field_size_req		= "V&auml;lja suurus on vajalik <BR>";
$owl_lang->err_forbidden_file           = "Forbidden File Type";
$owl_lang->err_file_indexing            = "Temporary 'TEXT' File Creation Failure";
$owl_lang->err_not_zip                  = "Not a Valid ZIP Archive";
$owl_lang->err_database                 = "Database error";
$owl_lang->err_sql                      = "SQL error";


//********************************************************
// Error Messages END
//********************************************************

$owl_lang->btn_go_top      = "Go To Top";                                                                                                                                                           
$owl_lang->btn_go_bottom      = "Go To Bottom";
$owl_lang->btn_admin      = "Admin";
$owl_lang->btn_logout     = "Logout";
$owl_lang->btn_browse     = "Browse";
$owl_lang->btn_mail_tool     = "E-Mail";
$owl_lang->btn_help     = "Help";
$owl_lang->btn_add_field          = "Add Field";
$owl_lang->btn_add_url          = "Add Url";
$owl_lang->btn_create          = "Create";
$owl_lang->btn_register          = "Register";
$owl_lang->btn_add_file          = "Add Document";
$owl_lang->btn_add_zip           = "Add Archive";
$owl_lang->btn_admin_users          = "New User";
$owl_lang->btn_admin_groups          = "New Group";
$owl_lang->btn_deldoctype          = "Del Doc Type";
$owl_lang->btn_expand_view          = "Expand View";
$owl_lang->btn_add_folder          = "Add Folder";
$owl_lang->btn_cancel          = "Cancel";
$owl_lang->btn_login          = "Login";
$owl_lang->btn_send_email          = "Send E-Mail";
$owl_lang->btn_admin_news          = "News Admin";
$owl_lang->btn_add_news          = "Add News";
$owl_lang->btn_clickhere          = "Click Here";
$owl_lang->btn_edit_group          = "Edit Group";
$owl_lang->btn_add_note          = "Add Note";
$owl_lang->btn_collapse_view          = "Collapse View";
$owl_lang->btn_edit_user          = "Edit User";
$owl_lang->btn_bulk_move          = "Bulk Move";
$owl_lang->btn_bulk_delete         = "Bulk Delete";
$owl_lang->btn_bulk_checkout       = "Bulk Checkout";
$owl_lang->btn_bulk_email          = "Bulk E-Mail";
$owl_lang->btn_bulk_download          = "Bulk Download";
$owl_lang->btn_reset          = "Reset";
$owl_lang->btn_submit          = "Submit";
$owl_lang->btn_back          = "Go Back";
$owl_lang->btn_download_bulk_package    = "to download your bulk download Package";

//********************************************************
// Image Alternate popup Messages BEGIN
//********************************************************

$owl_lang->alt_tool_status_red  = "Path is Incorrect AND/OR is not Executable";
$owl_lang->alt_tool_status_green= "Tool is Active";
$owl_lang->alt_my_approval      = "Document(s) Waiting my Approval";
$owl_lang->alt_pending_approval = "Document(s) Pending Approval";
$owl_lang->alt_email_reminder   = "Email Reminder";
$owl_lang->alt_approve_file     = "Approve This Document";
$owl_lang->alt_reject_file      = "Reject This Document";
$owl_lang->alt_publish_file     = "Make The Document Public";
$owl_lang->alt_go_top           = "Go to the top of the page";
$owl_lang->alt_go_bottom           = "Go to the bottom of the page";
$owl_lang->alt_btn_add_zip           = "Upload a Zip file to Be Extracted";
$owl_lang->alt_btn_mail_tool     = "Simple E-Mail Tool";
$owl_lang->alt_btn_bulk_move          = "Bulk Move Files and Folders";
$owl_lang->alt_btn_bulk_delete          = "Bulk Delete Files";
$owl_lang->alt_btn_bulk_checkout          = "Bulk Checkout Files";
$owl_lang->alt_btn_bulk_email          = "Bulk E-Mail Files";
$owl_lang->alt_btn_bulk_download          = "Bulk Download Files";
$owl_lang->alt_reset_form       = "Reset Form Values";
$owl_lang->alt_add_comments     = "Lisa failile kommentaar";
$owl_lang->alt_btn_add_file     = "Lisa uus dokument";
$owl_lang->alt_btn_add_folder	= "Lisa uus kaust";
$owl_lang->alt_add_group	= "Lisa see grupp";
$owl_lang->alt_add_news		= "Lisa uudis";
$owl_lang->alt_btn_add_note     = "Lisa uus m&auml;rge";
$owl_lang->alt_add_user		= "Lisa see kasutaja";
$owl_lang->alt_btn_add_url	= "Lisa uus WWW link";
$owl_lang->alt_admin_backup     = "SQL andmebaasi koopia";
$owl_lang->alt_backup_dis    	= "Puudub gzip ja mysqldump";
$owl_lang->alt_cancel		= "T&uuml;hista";
$owl_lang->alt_cancel_move	= "T&uuml;hista";
$owl_lang->alt_change		= "Uuenda";
$owl_lang->alt_btn_clickhere	= "Kliki siia";
$owl_lang->alt_btn_collapse_view= "V&auml;hendatud vaade";
$owl_lang->alt_comments 	= "Sellel failil on kommentaar";
$owl_lang->alt_del_comments     = "Kustuta see kommentaar";
$owl_lang->alt_del_file      	= "Kustuta fail (Y/N)";
$owl_lang->alt_del_folder    	= "Kustuta kaust (Y/N)";
$owl_lang->alt_del_group	= "Kustuta grupp";
$owl_lang->alt_del_news		= "Kustuta uudis";
$owl_lang->alt_del_selected	= "Kustuta k&otilde;ik valitud failid";
$owl_lang->alt_del_this_folder	= "Kustuta see kaust";
$owl_lang->alt_del_user		= "Kustuta kasutaja";
$owl_lang->alt_edit_group       = "Muuda gruppi";
$owl_lang->alt_edit_news	= "Muuda uudist";
$owl_lang->alt_edit_user        = "Muuda kasutajat";
$owl_lang->alt_email		= "Saada fail e-mailile";
$owl_lang->alt_email_selected	= "Saada see fail e-mailile";
$owl_lang->alt_btn_expand_view  = "Suurendatud vaade";
$owl_lang->alt_admin_flush      = "Kustuta aegunud sessioonid";
$owl_lang->alt_get_file      	= "Lae fail arvutisse";
$owl_lang->alt_get_folder       = "Download Folder Content";
$owl_lang->alt_have_news	= "Teile on uudiseid";
$owl_lang->alt_have_no_news	= "Uudiseid pole";
$owl_lang->alt_home_folder	= "Tagasi algkataloogi";
$owl_lang->alt_set_initial_dir	= "Muuda see algkataloogiks";
$owl_lang->alt_site_map         = "Lehek&uuml;lje plaan";
$owl_lang->alt_lock_file        = "M&auml;rgi fail v&auml;lja";
$owl_lang->alt_log_clear        = "Kustuta k&otilde;ik logid (Y/N)";
$owl_lang->alt_log_file         = "Failide logi";
$owl_lang->alt_log_next		= "Kuva j&auml;rgmine sisestus";
$owl_lang->alt_log_prev		= "Kuva eelmine sisestus";
$owl_lang->alt_log_top		= "Tagasi esimese sisestuse juurde";
$owl_lang->alt_btn_login	= "Logi sisse";
$owl_lang->alt_btn_logout	= "Logi v&auml;lja";
$owl_lang->alt_btn_help         = "Owl Online Help";
$owl_lang->alt_mod_file      	= "Muuda faili seadeid";
$owl_lang->alt_mod_folder    	= "Muuda kausta seadeid";
$owl_lang->alt_move_file     	= "Liiguta fail";
$owl_lang->alt_copy_file        = "Copy File";
$owl_lang->alt_link_file        = "Link This File to Another Directory";
$owl_lang->alt_move_folder   	= "Liiguta kaust";
$owl_lang->alt_copy_folder      = "Copy Folder";
$owl_lang->alt_move_selected	= "Liiguta k&otilde;ik valitud failid";
$owl_lang->alt_admin_groups	= "Lisa uus grupp";
$owl_lang->alt_news_close	= "Sulge";
$owl_lang->alt_news_next	= "Kuva j&auml;rgmine uudis";
$owl_lang->alt_news_prev	= "Kuva eelmine uudis";
$owl_lang->alt_news_print	= "Prindi";
$owl_lang->alt_admin_users	= "Lisa uus kasutaja";
$owl_lang->alt_monitor		= "J&auml;lgi seda faili";
$owl_lang->alt_monitored	= "L&otilde;peta selle faili j&auml;lgimine";
$owl_lang->alt_btn_admin 	= "Owl haldus";
$owl_lang->alt_play_file 	= "M&auml;ngi meediafaili";
$owl_lang->alt_recycle		= "Pr&uuml;gikast on t&uuml;hi";
$owl_lang->alt_recycle_disable	= "Pr&uuml;gikast ei ole aktiveeritud";
$owl_lang->alt_recycle_not_found= "Pr&uuml;gikasti asukohta ei leitud";
$owl_lang->alt_refresh_filter	= "Filtreeri / v&auml;rskenda tulemust";
$owl_lang->alt_register		= "Registreeri";
$owl_lang->alt_btn_browse	= "Tagasi failide juurde";
$owl_lang->alt_search		= "Otsi";
$owl_lang->alt_send_email	= "Saada e-mail";
$owl_lang->alt_sendfile		= "Saada fail";
$owl_lang->alt_toggle_check_box	= "M&auml;rgi k&otilde;ik";
$owl_lang->alt_unlock_file      = "M&auml;rgi fail";
$owl_lang->alt_upd_file      	= "Uuenda faili";
$owl_lang->alt_view_comments    = "Lisa / vaata faili kommentaari";
$owl_lang->alt_view_file     	= "Vaata seda faili";
$owl_lang->alt_edit_field	= "Muuda v&auml;lja definitsiooni";
$owl_lang->alt_del_field	= "Kustuta see v&auml;li";
$owl_lang->alt_add_field	= "Lisa &uuml;lalolev v&auml;li";
$owl_lang->alt_deldoctype	= "Kustuta antud dokumendit&uuml;&uuml;p";
$owl_lang->alt_upd_field	= "Uuenda seda v&auml;lja";
$owl_lang->alt_new_doctype	= "Lisa uus dokumendit&uuml;&uuml;p";
$owl_lang->alt_related          = "Find Releated Documents";
$owl_lang->alt_back             = "Return To Previous Screen";
$owl_lang->alt_submit           = "Submit Form";

//********************************************************
// Image Alternate popup Messages END
//********************************************************


//********************************************************
// Owl Logging messages BEGIN
//********************************************************

$owl_lang->log_del_det		= "K&otilde;ik sisu on kustutatud";
$owl_lang->log_detail		= "Detailid puuduvad";
$owl_lang->log_file_to		= "KELLELE: ";
$owl_lang->log_filter_all	= "K&Otilde;IK";
$owl_lang->log_login_det	= "Kasutajanimi: ";
$log_file_actions[1]        	= "LOGIMINE";
$log_file_actions[2]        	= "LOGIMINE EBA&Otilde;NNESTUS";
$log_file_actions[3]        	= "V&Auml;LJA LOGIMINE";
$log_file_actions[4]        	= "FAILI KUSTUTAMINE";
$log_file_actions[5]        	= "FAILI &Uuml;LES LAADIMINE";
$log_file_actions[6]        	= "FAILI UUENDAMINE";
$log_file_actions[7]        	= "FAILI LAADIMINE";
$log_file_actions[8]        	= "FAILI MUUTMINE";
$log_file_actions[9]        	= "FAILI LUKUSTAMINE";
$log_file_actions[10]        	= "FAILI LAHTI LASKMINE";
$log_file_actions[11]        	= "FAILI SAATMINE MAILILE";
$log_file_actions[12]        	= "FAILI LIIGUTAMINE";
$log_file_actions[13]        	= "KAUSTA LOOMINE";
$log_file_actions[14]        	= "KAUSTA KUSTUTAMINE";
$log_file_actions[15]        	= "KAUSTA MUUTMINE";
$log_file_actions[16]        	= "KAUST LIIGUTATUD";
$log_file_actions[17]        	= "SALAS&Otilde;NA UNUSTAMINE";
$log_file_actions[18]        	= "KASUTAJA REGISTREERIMINE";
$log_file_actions[19]           = "FAILI VAATAMINE";
$log_file_actions[20]           = "FILE VIRUS";
$log_file_actions[21]           = "FILE COPIED";
$log_file_actions[22]           = "FOLDER COPIED";
$log_file_actions[23]           = "FILE_LINKED";

//********************************************************
// Owl Logging messages END
//********************************************************


//********************************************************
// index.php  BEGIN
//********************************************************

$owl_lang->anonymous 		= "(Anon&uuml;&uuml;mne konto)";
$owl_lang->repository_list      = "Repository:";
$owl_lang->engine 		= "OWL Intranet";
$owl_lang->forgot_pass		= "Unustasite salas&otilde;na?";
$owl_lang->like_register	= "Soovite registreeruda?";
$owl_lang->login		= "Login";
$owl_lang->loginfail		= "Vale kasutajanimi v&otilde;i salas&otilde;na!";
$owl_lang->logindisabled	= "Teie konto on ajutiselt suletud, kontakteeruge administraatoriga";
$owl_lang->password		= "Salas&otilde;na";
$owl_lang->successlogout 	= "Te olete edukalt v&auml;ljaloginud!";
$owl_lang->toomanysessions	= "Maksimaalne sessioonide arv kasutatud, kontakteeruge s&uuml;steemiadministraatoriga";
$owl_lang->username		= "Kasutajanimi";
$owl_lang->version 		= "Versioon";

//********************************************************
// index.php  END
//********************************************************


//********************************************************
// browse.php  BEGIN
//********************************************************

$owl_lang->menu_url_action              = "Available Url Actions";
$owl_lang->menu_file_action             = "Available File Actions";                                                
$owl_lang->menu_folder_action           = "Available Folder Actions";
$owl_lang->panel_file_info              = "File Information";
$owl_lang->actions 			= "Tegevused";
$owl_lang->del_selected			= "Kustuta valitud";
$owl_lang->del_all                      = "Empty Trash";
$owl_lang->rest_selected                = "Restore Selected";
$owl_lang->disk_quota			= "Kettamahu piirang";
$owl_lang->email_selected		= "E-mail valitud";
$owl_lang->file 			= "Fail";
$owl_lang->folder_policy 		= "Antud kausta &otilde;igused:";
$owl_lang->current_folder               = "Current Folder:";
$owl_lang->held                      	= "Hoitud"; 
$owl_lang->last_logged			= "Viimane k&uuml;lastus:";
$owl_lang->current_db                   = "Current Repository:";
$owl_lang->modified 			= "Muudetud";
$owl_lang->move_selected		= "Liiguta valitud";
$owl_lang->new_file			= "Uus!";
$owl_lang->no_description		= "Kirjeldust pole saadaval";
$owl_lang->page				= "Lehek&uuml;lg";
$owl_lang->postedby 			= "Postitanud";
$owl_lang->reallydelete			= "Kustutame?";
$owl_lang->reallydelete_logs		= "Soovid t&otilde;esti kustutada logifaili?";
$owl_lang->reallydelete_selected	= "Soovid t&otilde;esti kustutada valitud failid?";
$owl_lang->reallyrestore_selected       = "Really Restore all selected files";
$owl_lang->size 			= "Suurus";
$owl_lang->score                        = "Score";
$owl_lang->title 			= "Pealkiri";
$owl_lang->doc_number                   = "Doc #";
$owl_lang->tot_files			= "Kokku:";
$owl_lang->tot_my_checked_out		= "M&auml;rgitud:";
$owl_lang->tot_my_files			= "Minu Failid:";
$owl_lang->tot_my_group			= "Grupp:";
$owl_lang->tot_new_files		= "Uus:";
$owl_lang->tot_updated_files		= "Uuendatud:";
$owl_lang->tot_monitored                = "Monitored:";
$owl_lang->updated_file			= "Uuendatud!";
$owl_lang->user               		= "Kasutaja";
$owl_lang->ver                       	= "Versioon";
$owl_lang->folder_count_pre             = "This Folder Contains";
$owl_lang->folder_count_folder          = "Folder(s)";
$owl_lang->folder_count_file            = "File(s)";
$owl_lang->folder_count_url             = "URL(s)";
$owl_lang->folder_count_note            = "Note(s)";

//********************************************************
// browse.php  END
//********************************************************


//********************************************************
// modify.php  BEGIN
//********************************************************

$owl_lang->none_selected        = "NONE SELECTED";
$owl_lang->adding_comments      = "Vaata / lisa kommentaar: ";
$owl_lang->comments             = "Comment";
$owl_lang->post_comment         = "Post Comment";
$owl_lang->addingfile 		= "Faili lisamine ";
$owl_lang->addingfolder 	= "Kausta lisamine ";
$owl_lang->attach_file		= "Faili lisamine";
$owl_lang->change		= "Muuda";
$owl_lang->create		= "Loo";
$owl_lang->comments_added       = "Kommenteerinud: ";
$owl_lang->description 		= "Kirjeldus";
$owl_lang->email_body		= "S&otilde;num";
$owl_lang->email_cc          	= "Koopia";
$owl_lang->email_reply_to	= "Vastus saadetakse";
$owl_lang->email_subject	= "Pealkiri";
$owl_lang->email_to		= "Saaja";
$owl_lang->emailing		= "Emailing";
$owl_lang->disp_mp3		= "MP3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Song:<BR>Album:<BR>Bitrate&nbsp;-&nbsp;Samplerate:<BR>Duration:<BR>Genre:<BR>Comments:";
$owl_lang->keywords 		= "V&otilde;tmes&otilde;nad";
$owl_lang->modify_url		= "URL";
$owl_lang->modifying		= "Muutmine ";
$owl_lang->name               	= "Nimi"; 
$owl_lang->notify_link          = "Owl v&auml;line link";
$owl_lang->note_content         = "Sisu";
$owl_lang->ownergroup         	= "Omanikgrupp";
$owl_lang->ownership		= "Omanik";
$owl_lang->permissions 		= "&Otilde;igused";
$owl_lang->prop_permissions 	= "Laienda alamkaustadele samad &otilde;igused?";
$owl_lang->prop_perms_files 	= "Failidele laiendatavad &otilde;igused:";
$owl_lang->policy 		= "&Otilde;igused";
$owl_lang->pick_select		= "&#8212; Vali Owl Kasutaja &#8212;";
$owl_lang->sendfile 		= "Saada Fail";
$owl_lang->sendthisfile 	= "Saada antud fail";
$owl_lang->sendthisurl       	= "Saada antud URL";
$owl_lang->updating		= "Uuendamine";
$owl_lang->verdescription 	= "Muudatuste<br></br>kirjeldus";
$owl_lang->vermajor          	= "Suurem l&auml;bivaatus";
$owl_lang->verminor          	= "V&auml;iksem l&auml;bivaatus";
$owl_lang->vertype           	= "L&auml;bivaatuse t&uuml;&uuml;p";

//********************************************************
// modify.php  END
//********************************************************


//********************************************************
// register.php  BEGIN
//********************************************************

$owl_lang->email             	= "Mailiaadress";
$owl_lang->full_name		= "Ees ja perenimi";
$owl_lang->register		= "Kasutaja registreerimine";
$owl_lang->self_failed		= "Ei &otilde;nnestunud";
$owl_lang->self_passwd		= "Salas&otilde;na saadetud:";
$owl_lang->self_reg_bod		= "Teie Owl salas&otilde;na on:";
$owl_lang->self_reg_rset	= "Teie Owl salas&otilde;na on nullitud:";
$owl_lang->self_reg_subj	= "Teie OWL kasutajakonto";
$owl_lang->send_pass		= "Saada salas&otilde;na";
$owl_lang->submit		= "Registreeri";
$owl_lang->thank_you_1		= "T&auml;nan!";
$owl_lang->thank_you_2		= "Teie meiliaadressile on saadetud<BR>UUS salas&otilde;na<BR><b>KASUTAJALE:</b>";

//********************************************************
// register.php  END
//********************************************************


//********************************************************
// move.php  BEGIN
//********************************************************

$owl_lang->cancel_button	= "T&uuml;hista";
$owl_lang->moving		= "Liigutamine";
$owl_lang->moving_file          = "Moving file";
$owl_lang->moving_folder        = "Moving Folder";
$owl_lang->copy_file            = "Copying file";
$owl_lang->copy_folder          = "Copying Folder";
$owl_lang->select		= "Palun vali uus kaust:";

//********************************************************
// move.php  END
//********************************************************


//********************************************************
// log.php  BEGIN
//********************************************************

$owl_lang->viewlog	= "Vaata logi ";

//********************************************************
// log.php  END
//********************************************************


//********************************************************
// prefs.php  BEGIN
//********************************************************

$owl_lang->confpassword	= "Salas&otilde;na uuesti";
$owl_lang->comment_notif= "Kommentaarist teatamine";
$owl_lang->email_tool   = "E-Mail Tool";
$owl_lang->last_modified= "Last Modified";
$owl_lang->group	= "Esmane Grupp:";
$owl_lang->groupmember	= "Grupi liige:";
$owl_lang->newpassword	= "Uus salas&otilde;na";
$owl_lang->newsadmin	= "Uudiste haldaja";
$owl_lang->not_member	= "Te ei ole &uuml;hegi teise grupi liige.";
$owl_lang->notification	= "Teatadete vastuv&otilde;tmine";
$owl_lang->oldpassword	= "Vana salas&otilde;na";
$owl_lang->preference	= "Seadistused";
$owl_lang->saved	= "Muudatused salvestatud";
$owl_lang->status_no	= "EI";
$owl_lang->status_yes	= "JA";
$owl_lang->userlang	= "Keel";

//********************************************************
// prefs.php  END
//********************************************************


//********************************************************
// search.php  BEGIN
//********************************************************

$owl_lang->elapsed_time       	= "kulunud aeg";
$owl_lang->search             	= "Otsi";
$owl_lang->search_any_word	= "Iga s&otilde;na eraldi";
$owl_lang->search_all_word	= "K&otilde;ik s&otilde;nad";
$owl_lang->search_entire_phrase	= "Terve fraas";
$owl_lang->search_match 	= "Vaste:";
$owl_lang->search_currentfolder = "Otsi antud kaustast";
$owl_lang->search_for_folders 	= "Otsing kaustadest";
$owl_lang->search_for_files 	= "Otsing failidest";
$owl_lang->search_score 	= "Leitud failid";
$owl_lang->search_results_for	= "Otsi tulemusi";
$owl_lang->search_winthindocs   = "Otsi ( pdf,text ) failide seast";
$owl_lang->related_query_empty  = "No metadata associated with document to perform 'Search Related'";
$owl_lang->query_empty       	= "Otsistring puudub";

//********************************************************
// search.php  END
//********************************************************


//********************************************************
// view.php  BEGIN
//********************************************************

$owl_lang->viewing	= "Vaatamine ";

//********************************************************
// view.php  END
//********************************************************


//********************************************************
// admin/index.php  BEGIN
//********************************************************

$owl_lang->display_password_override    = "Display File/Folder Password Override";
$owl_lang->download_folder_zip          = "Download Folders as ZIP (Default is tar.gz)";
$owl_lang->doc_id_prefix                = "Doc# Display Prefix String";
$owl_lang->doc_id_num_digits            = "Doc# Number Digit to display";
$owl_lang->view_doc_in_new_window       = "New Window when Viewing Documents";
$owl_lang->admin_login_to_browse_page   = "Admin goes to Browse Page on Logon";
$owl_lang->save_keywords_to_db          = "Allow Users to save Keywords for Reuse";
$owl_lang->status_column                = "Status";
$owl_lang->vermajor_initial             = "Initial Major Revision";
$owl_lang->verminor_initial             = "Initial Minor Revision";
$owl_lang->docicon_column               = "Doc Icon";
$owl_lang->btn_users_groups             = "Users &amp;<br></br>Groups";
$owl_lang->alt_btn_users_groups         = "Administer Users and Groups";
$owl_lang->btn_html_prefs               = "HTML<br></br>Preferences";
$owl_lang->alt_btn_html_prefs           = "Edit Site HTML Preferences";
$owl_lang->btn_site_features            = "Site<br></br>Features";
$owl_lang->alt_btn_site_features        = "Edit Site Features and Settings";
$owl_lang->btn_log_viewer               = "Log<br></br>Viewer";
$owl_lang->alt_btn_log_viewer           = "Owl System Log Viewer";
$owl_lang->btn_statistics_viewer        = "Statistics / Report <br />Viewer";
$owl_lang->alt_btn_statistics_viewer    = "Owl Statistics Viewer";
$owl_lang->btn_news_admin               = "News<br></br>Admin";
$owl_lang->alt_btn_news_admin           = "Owl News Administrator";
$owl_lang->btn_doctype_admin            = "Document<br></br>Types";
$owl_lang->alt_btn_doctype_admin        = "Document Type Administrator";
$owl_lang->btn_backup                   = "Backup<br></br>Database";
$owl_lang->alt_btn_backup               = "Backup SQL Database";
$owl_lang->btn_trashcan                 = "TrashCan";
$owl_lang->alt_btn_trashcan             = "Click to View the Contents";
$owl_lang->btn_initial_load             = "Initial Load";
$owl_lang->alt_btn_initial_load         = "Load DB From Documents Folder";
$owl_lang->confirm_initial_load         = "*** WARNING ***  This should only be run once when the database is empty";
$owl_lang->add				= "Lisa";
$owl_lang->anonymous_account		= "Anon&uuml;&uuml;mne kasutajakonto:";
$owl_lang->buttonstyle                  = "Nuppude stiil";
$owl_lang->deletegroup			= "Kustuta grupp";
$owl_lang->deleteuser			= "Kustuta kasutaja";
$owl_lang->disableuser			= "Blokeeri ajutiselt";
$owl_lang->disable_recs_per_page	= "Turvatud vaate lubamine blokeerib kirjed lehek&uuml;ljel";
$owl_lang->file_admin_group		= "Faili-brauseri haldusrupp:";
$owl_lang->flushed           		= "Sessiooni tabel kustutatud, kasutaja v&otilde;ib uuesti logida.<BR>";
$owl_lang->groups			= "Grupid";
$owl_lang->hide_bulk_buttons		= "Varja enamus nuppe:";
// Edit HTML Properties Messages BEGIN
$owl_lang->ht_tbl_border_sz 		= "Tabeli &auml;&auml;rise suurus:";
$owl_lang->ht_tbl_hd_bg			= "P&auml;ise taust:";
$owl_lang->ht_tbl_cell_bg_cl 		= "Tabeli lahtri taustav&auml;rv:";
$owl_lang->ht_tbl_cell_bg_al 		= "Tabeli lahtri vahelduv taustav&auml;rv:";
$owl_lang->ht_expand_width		= "Suurendatud vaate laius:";
$owl_lang->ht_collapse_width 		= "V&auml;hendatud vaate laius:";
$owl_lang->ht_bd_bg_image		= "Taustapildi asukoht:";
$owl_lang->ht_bd_txt_cl 		= "Teksti v&auml;rv:";
$owl_lang->ht_bd_lnk_cl			= "Lingi v&auml;rv:";
$owl_lang->ht_bd_vlnk_cl 		= "K&uuml;lastatud lingi v&auml;rv:";
// Edit Prefs Properties Messages END
$owl_lang->home_dir			= "Kasutajate kodukataloog";
$owl_lang->initial_dir                  = "User's Initial Directory";
$owl_lang->maxsessions			= "Maksimaalne sessioonide arv";
$owl_lang->noprefaccess			= "Seadistuste keelamine";
$owl_lang->owl_anon_full                = "Full Access";
$owl_lang->owl_anon_ro			= "Sea anon&uuml;&uuml;msele kasutajale lugemise &otilde;igus:";
$owl_lang->owl_anon_download            = "Download Only";
$owl_lang->anonymous_access             = "Set Anonymous Access";
$owl_lang->owl_dbdump_path   		= "Andmebaasi t&otilde;mmise asukoht:";
$owl_lang->owl_def_file_group_owner	= "Vaikimisi failigrupi omanik:";
$owl_lang->owl_def_file_meta		= "Metadata vaikefail:";
$owl_lang->owl_def_file_owner		= "Vaikimisi faili omanik:";
$owl_lang->owl_def_file_perm 		= "Vaikimisi faili loomise &otilde;igused:";
$owl_lang->owl_def_file_security	= "Faili turvalisus vaikimisi:";
$owl_lang->owl_def_file_title		= "Vaikimisi failinimi(j&auml;ta t&uuml;hjaks kasutamaks faili nime):";
$owl_lang->owl_def_fold_group_owner	= "Vaikimisi kaustagrupi omanik:";
$owl_lang->owl_def_fold_owner		= "Vaikimisi kausta omanik:";
$owl_lang->owl_def_fold_sec		= "Kausta vaiketurvalisus:";
$owl_lang->owl_def_folder_perm 		= "Vaikimisi kausta loomise &otilde;igused:";
$owl_lang->owl_default_tmpdir		= "Ajutise kataloogi asukoht: ";
$owl_lang->owl_email_from		= "Kellelt aadress / SMTP auth login:";
$owl_lang->owl_email_fromname		= "Kellelt:";
$owl_lang->owl_email_replyto		= "Vastusaadress:";
$owl_lang->owl_email_server		= "SMTP Server:";
$owl_lang->owl_email_smtp		= "Kasuta SMTP Mailing Method";
$owl_lang->owl_email_smtp_auth		= "Kasuta SMTP autentimist";
$owl_lang->owl_email_smtp_auth_login    = "SMTP Auth Login:";
$owl_lang->owl_email_smtp_auth_passwd	= "SMTP autentimise salas&otilde;na";
$owl_lang->owl_email_subject_pref	= "Teema eesliide:";
$owl_lang->owl_fogotpass		= "N&auml;ita ununenud salas&otilde;na linki:";
$owl_lang->owl_group_user		= "Kasutajad, kes on selle grupi liikmed";
$owl_lang->owl_gzip_path     		= "gzip asukoht:";
$owl_lang->owl_hidebackup		= "Varja koopia asukohta:";
$owl_lang->owl_log_file			= "Logi failitoimingud:";
$owl_lang->owl_log_login_act		= "Logi sisse/v&auml;ljalogimine:";
$owl_lang->owl_log_rec_page		= "Logi kirjed &uuml;hel lehel:";
$owl_lang->owl_logging			= "Luba logimine:";
$owl_lang->owl_logo			= "Loginlehe logo ([keel]/pilt):";
$owl_lang->owl_lookAtHD			= "Keela k&otilde;vaketta vaade:";
$owl_lang->owl_lookAtHDDel		= "Kustuta kustutatud kirjed andmebaasist:";
$owl_lang->hide_folder_doc_count        = "Hide Folder File Type Count";                                                                                                                        
$owl_lang->hide_folder_size             = "Hide Folder Content Size";
$owl_lang->old_action_icons             = "Use pre Owl 0.80 Action Icons";
$owl_lang->search_result_folders        = "Include Folders in Search Results";
$owl_lang->restore_file_prefix          = "String Prefixed to Restored Files";
$owl_lang->owl_max_filesize		= "Maksimaalne &uuml;les laetava faili suurus:";
$owl_lang->owl_owl_expand		= "Vaikimisi failibrauseri vaade (laiendatud):";
$owl_lang->owl_owl_timeout		= "Sessiooni aegumine sekundites:";
$owl_lang->virus_path                   = "Virus Checking Software Path<br />Example: '/usr/bin/clamscan --quiet' <br />&#8211; Blank for Disabled:";
$owl_lang->owl_pdftotext_path		= "Pea otsinguindeksit<BR>PDF ja text failide jaoks <BR>&#8211; t&uuml;hi = ei ole aktiivne:";
$owl_lang->owl_wordtotext_path          = "MS-WORD failid <BR>&#8211; t&uuml;hi = ei ole aktiivne:";
$owl_lang->owl_pod2html_path            = "Perl 5.8.0 vajalik<BR>pod2html asukoht:";
$owl_lang->owl_restrict_view		= "Aktiveeri turvatud vaade:";
$owl_lang->owl_self_reg			= "Aktiveeri iseregistreerumine:";
$owl_lang->owl_self_reg_hd		= "ISEREGISTREERUNUD KASUTAJA S&Auml;TTED";
$owl_lang->owl_tar_path     		= "tar asukoht:";
$owl_lang->owl_title_custom             = "CUSTOMIZE BROWSER COLUMNS";
$owl_lang->owl_title_custom_search      = "CUSTOMIZE SEARCH RESULTS";
$owl_lang->owl_title_browser		= "OWL BRAUSERI S&Auml;TTED";
$owl_lang->owl_title_defaults   	= "VAIKES&Auml;TTED";
$owl_lang->owl_title_email		= "OWL mailis&auml;tted";
$owl_lang->owl_title_HD			= "VAATA K&Otilde;VAKETTALT UUTE FAILIDE S&Auml;TTEID";
$owl_lang->owl_title_logging  		= "LOGIMISS&Auml;TTED";
$owl_lang->owl_title_other		= "MUUD S&Auml;TTED";
$owl_lang->owl_title_tools   		= "ANDMEBAASI KOOPIA-PAKKIMISE RIISTAD";
$owl_lang->owl_unzip_path     		= "unzip asukoht:";
$owl_lang->owl_version_control		= "Aktiveeri versioonikontroll:";
$owl_lang->quota			= "Ketta Quota 0=Pole Aktiivne";
$owl_lang->reallydeluser		= "See kasutaja on %numfiles% faili ja %numfolders% kausta omanik. Need failid-kaustad j&auml;&auml;ks orvuks. Kas kustutame nad??";
$owl_lang->recs_per_page		= "&Uuml;hel lehel kirjeid (0 = Pole Aktiivne):";
$owl_lang->remember_me_title		= "P&Uuml;SIVAD LOGIMISS&Auml;TTED";
$owl_lang->remember_me			= "N&auml;ita 'M&auml;leta mind' linki";
$owl_lang->remember_timeout		= "K&uuml;psiste aegumine p&auml;evades";
$owl_lang->remember_me_checkbox		= "M&auml;leta mind";
$owl_lang->recycle_title		= "PR&Uuml;GIKASTI SEADED";
$owl_lang->recycle_enabled		= "Aktiveeri pr&uuml;gikast:";
$owl_lang->recycle_location		= "Pr&uuml;gikasti asukoht:";
$owl_lang->show_panel_title             = "Display Status Panel:";
$owl_lang->show_search_title            = "Display Search Bar:";
$owl_lang->show_pref_title              = "Display Pref/logout Bar:";
$owl_lang->show_bulk_title              = "Display Bulk Buttons:";
$owl_lang->show_action_title            = "Display action Buttons:";
$owl_lang->show_folder_title            = "Display Folder Tools:";
$owl_lang->show_panel                   = "Show";
$owl_lang->hide_panel                   = "Hide";
$owl_lang->status_bar_both              = "M&otilde;lemas kohas";
$owl_lang->status_bar_bottom            = "All";
$owl_lang->status_bar_location          = "Kuva olekuriba:";
$owl_lang->status_bar_top               = "&Uuml;leval";
$owl_lang->status_bar_not               = "Do Not Display";
$owl_lang->use_popup			= "Kuva uudised popupina:";
$owl_lang->users           		= "Kasutajad";
$owl_lang->header_user_admin            = "User Administration";
$owl_lang->header_group_admin           = "Group Administration";
$owl_lang->header_sitefeatures_settings           = "Site Features and Settings";

//********************************************************
// admin/index.php  END
//********************************************************


//********************************************************
// admin/log.php  BEGIN
//********************************************************

$owl_lang->owl_log_viewer	= "LOGI vaatamine";
$owl_lang->owl_log_hd_action	= "Tegevus";
$owl_lang->owl_log_hd_file	= "Fail";
$owl_lang->owl_log_hd_fld_path	= "Kausta asukoht";
$owl_lang->owl_log_hd_user	= "Kasutaja";
$owl_lang->owl_log_hd_dt_tm	= "Kuup&auml;ev";
$owl_lang->owl_log_hd_ip	= "IP / aadress";
$owl_lang->owl_log_hd_agent	= "Brauser";
$owl_lang->owl_log_hd_dtls	= "Detailid";
$owl_lang->owl_log_no_rec	= " EI LEIDNUD &Uuml;HTEGI VASTET ";
$owl_lang->owl_log_hide      	= "Varja: ";
$owl_lang->owl_log_filter	= "Filter";

//********************************************************
// admin/log.php  END
//********************************************************


//********************************************************
// admin/recycle.php  BEGIN
//********************************************************

$owl_lang->empty_trash          = "T&uuml;hjenda pr&uuml;gikast";
$owl_lang->really_empty_trash	= "T&uuml;hjendame?";
$owl_lang->recycle_bin_admin    = "Pr&uuml;gikasti haldus";

//********************************************************
// admin/recycle.php  END
//********************************************************


//********************************************************
// lib/owl.lib.php  BEGIN
//********************************************************

$owl_lang->file_size_byte		= "b";
$owl_lang->file_size_gigabyte		= "G";
$owl_lang->file_size_kilobyte		= "k";
$owl_lang->file_size_megabyte		= "M";
$owl_lang->notif_subject_new 		= "Uus OWL Intraneti fail";
$owl_lang->notif_subject_upd 		= "OWL Intraneti faili on uuendatud";
$owl_lang->notif_subject_monitor	= "OWL Intraneti faili v&otilde;i kausta, mida te j&auml;lgite on uuendatud";
$owl_lang->notif_subject_comment	= "OWL Intraneti failile -- on lisatud kommentaar";
$owl_lang->notif_comment_1		= "Kommenteeritud";
$owl_lang->notif_comment_2		= "Kommentaar:";
$owl_lang->notif_msg         		= "SEE ON AUTOMAATS&Otilde;NUM OWL Intranetilt<BR><BR>Uus/uuendatud fail on kaasatud meiliga<BR><BR>";
$owl_lang->notif_msg_link               = "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet<BR><BR>Find a link to a new/updated file in this E-Mail<BR><BR>";
$owl_lang->notif_msg_alt_link           = "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet\n\nFind a link to a new/updated file in this E-Mail\n\n";
$owl_lang->notif_msg_alt         	= "SEE ON AUTOMAATS&Otilde;NUM OWL Intranetilt\n\nUus/uuendatud fail on kaasatud meiliga\n\n";
$owl_lang->notif_salutation		= "Tere";
$owl_lang->notif_user                   = "Created/Update by:";
$owl_lang->owl_path			= "Faili asukoht: ";
$owl_lang->sessinuse			= "Seda sessiooni kasutatakse teisest arvutist, ligip&auml;&auml;s puudub!<BR>";
$owl_lang->invalidsess			= "Vale sessiooni id, palun logige avalehelt<BR>";
$owl_lang->sesstimeout			= "Teie sessioon on aegunud, palun logige uuesti sisse!<BR>";
$owl_lang->everyoneread			= "K&otilde;ik saavad lugeda/alla laadida";
$owl_lang->everyonewrite		= "K&otilde;ik saavad lugeda/kirjutada/alla laadida";
$owl_lang->everyonewrite_nod		= "K&otilde;ik saavad lugeda/kirjutada/alla laadida, kuid MITTE KUSTUTADA";
$owl_lang->groupread			= "Teie grupp saab lugeda/alla laadida";
$owl_lang->groupwrite			= "Teie grupp saab lugeda/kirjutada/alla laadida";
$owl_lang->groupwrite_nod		= "Teie grupp saab lugeda/kirjutada/alla laadida, kuid MITTE KUSTUTADA";
$owl_lang->onlyyou			= "Ainult sina saad lugeda/kirjutada/alla laadida";
$owl_lang->donothing                    = "J&auml;ta faili &otilde;igused muutmata";
$owl_lang->groupwrite_worldread 	= "Teie grupp saab lugeda/kirjutada/alla laadida ja teised lugeda";
$owl_lang->groupwrite_worldread_nod 	= "Teie grupp saab lugeda/kirjutada/alla laadida (MITTE KUSTUTADA) ja teised lugeda";
$owl_lang->ggroupwrite_worldread 	= "Teie grupp saab &uuml;les laadida faile ja kustutada seda kausta ja teised n&auml;evad selle sisu";
$owl_lang->ggroupwrite_worldread_nod 	= "Teie grupp saab &uuml;les laadida faile siia kausta ja teised n&auml;evad selle sisu, EI SAA KUSTUTADA";
$owl_lang->everyoneread_ad		= "K&otilde;ik saavad lugeda/alla laadida";
$owl_lang->everyonewrite_ad		= "K&otilde;ik saavad lugeda/kirjutada/alla laadida";
$owl_lang->everyonewrite_ad_nod		= "K&otilde;ik saavad lugeda/kirjutada/alla laadida, MITTE KUSTUTADA";
$owl_lang->groupread_ad			= "Valitud grupp saab lugeda/alla laadida";
$owl_lang->groupwrite_ad		= "Valitud grupp saab lugeda/kirjutada/alla laadida";
$owl_lang->groupwrite_ad_nod		= "Valitud grupp saab lugeda/kirjutada/alla laadida, MITTE KUSTUTADA";
$owl_lang->onlyyou_ad			= "Ainult teie saate lugeda/kirjutada/alla laadida";
$owl_lang->groupwrite_worldread_ad 	= "Valitud grupp saab lugeda/kirjutada/alla laadida ja teised lugeda";
$owl_lang->groupwrite_worldread_ad_nod 	= "Valitud grupp saab lugeda/kirjutada/alla laadida (MITTE KUSTUTADA) ja teised lugeda";
$owl_lang->ggroupwrite_worldread_ad 	= "Valitud grupp saab &uuml;les laadida faile ja kustutada seda kausta ja teised n&auml;evad selle sisu";
$owl_lang->ggroupwrite_worldread_ad_nod	= "Valitud grupp saab &uuml;les laadida faile siia kausta ja teised n&auml;evad kausta sisu, EI SAA KUSTUTADA";
$owl_lang->geveryoneread		= "K&otilde;ik saavad lugeda seda kausta";
$owl_lang->geveryonewrite		= "K&otilde;ik saavad &uuml;les laadida faile ja kustutada seda kausta";
$owl_lang->geveryonewrite_nod		= "K&otilde;ik saavad &uuml;les laadida faile siia kausta";
$owl_lang->ggroupread			= "Teie grupp saab lugeda selda kausta";
$owl_lang->ggroupwrite			= "Teie grupp saab &uuml;les laadida faile ja kustutada seda kausta";
$owl_lang->ggroupwrite_nod		= "Teie grupp saab &uuml;les laadida faile siia kausta";
$owl_lang->gonlyyou			= "Ainult teie saate &uuml;les laadida faile ja kustutada seda kausta";
$owl_lang->geveryoneread_ad		= "K&otilde;ik saavad lugeda seda kausta";
$owl_lang->geveryonewrite_ad		= "K&otilde;ik saavad &uuml;les laadida faile ja kustutada seda kausta";
$owl_lang->geveryonewrite_ad_nod	= "K&otilde;ik saavad &uuml;les laadida faile siia kausta";
$owl_lang->ggroupread_ad		= "Valitud grupp saab lugeda seda kausta";
$owl_lang->ggroupwrite_ad    		= "Valitud grupp saab &uuml;les laadida  faile ja kustutada seda kausta";
$owl_lang->ggroupwrite_ad_nod		= "Valitud grupp saab &uuml;les laadida faile siia kausta";
$owl_lang->gonlyyou_ad			= "Ainult teie saate &uuml;les laadida faile ja kustutada seda kausta";
$owl_lang->orphaned			= "&#8211; Omanik PUUDUB  &#8211;";
$owl_lang->virus_infected               = "VIRUS INFECTED FILE";
$owl_lang->virus_return_val             = "Virus Program Return value:";

//********************************************************
// lib/owl.lib.php  END
//********************************************************


//********************************************************
// HREF TITLE messages  BEGIN
//********************************************************

$owl_lang->title_browse_folder     	= "Vaata seda kausta";
$owl_lang->title_browse_site     	= "Vaata seda  URL-i";
$owl_lang->title_download_view     	= "Lae alla / vaata seda faili";
$owl_lang->title_edit_prefs     	= "Vaata / muuda kasutaja seadistusi";
$owl_lang->title_return_folder     	= "Tagasi";
$owl_lang->title_sort     		= "J&auml;rjesta";
$owl_lang->title_view_new     		= "Vaata faile, mis on lisatud p&auml;rast sinu viimast logimist";
$owl_lang->title_view_updated     	= "Vaata faile, mida on uuendatud p&auml;rast sinu viimast logimist";
$owl_lang->title_view_my     		= "Minu failid";

//********************************************************
// HREF TITLE messages  END
//********************************************************


//********************************************************
// admin/news.php and newsread.php BEGIN
//********************************************************

$owl_lang->news_title			= "Uudiste haldamine";
$owl_lang->news_hd			= "Uudised";
$owl_lang->news_hd_created		= "Loodud";
$owl_lang->news_hd_expires		= "Kaotab kehtivuse";
$owl_lang->news_hd_audience		= "Kellele";
$owl_lang->news_heading			= "Uus pealkiri";
$owl_lang->news_content			= "Sisu";
$owl_lang->news_posted_date		= "Uudis postitatud:";
$owl_lang->news_read			= "Loe";

//********************************************************
// admin/news.php and newsread.php  END
//********************************************************


//********************************************************
// DEBUG MESSAGES BEGIN
//********************************************************

$owl_lang->debug_tmp_not_exists		= "DEBUG: The OWL temporary Directory: $default->owl_tmpdir does not exists.";
$owl_lang->debug_tmp_not_writeable	= "DEBUG: The OWL temporary Directory: $default->owl_tmpdir is not writeable by the Web Server.";
$owl_lang->debug_doc_not_exists		= "DEBUG: The OWL Documents Directory: " .$default->owl_fs_root . "/" . fid_to_name(1) ." does not exists.";
$owl_lang->debug_doc_not_writeable	= "DEBUG: The OWL Documents Directory: " .$default->owl_fs_root . "/" . fid_to_name(1) ." is not writeable by the Web Server.";
$owl_lang->debug_webserver_no_access    = "DEBUG: The webserver does not have read access to: <br />'$default->owl_fs_root/$filename'. <br />Please fix the permissions and try again";
$owl_lang->debug_file_not_exist         = "DEBUG: The required file '$default->owl_fs_root/$filename' does not exists.<br /> OR<br />The path specified by \$default->owl_fs_root in config/owl.php is wrong.";
                                                                                                                                                                                                                           
//********************************************************
// DEBUG MESSAGES END
//********************************************************


//********************************************************
// admin/stats.php BEGIN
//********************************************************

$owl_lang->owl_stats_viewer	= "Statistika Vaatamine";
$owl_lang->stats_files		= "Kasutaja faile (kokku)";
$owl_lang->stats_folders	= "Kasutaja kaustu (kokku)";
$owl_lang->stats_top		= "Top 20 alla laadimist";
$owl_lang->stats_users          = "USER Signon (Login / Failure / Logout)";
$owl_lang->stats_users_loggedin = "Currently Logged In";
$owl_lang->stats_information	= "Statistika vaatamiseks tuleb LOGIMINE lubada";

//********************************************************
// admin/stats.php END
//********************************************************

//********************************************************
// admin/doctype.php BEGIN
//********************************************************

$owl_lang->document_type	= "Dokumendit&uuml;&uuml;p";
$owl_lang->document_type_name	= "Dokumendit&uuml;&uuml;bi nimi";
$owl_lang->doc_field_name	= "V&auml;lja nimi";
$owl_lang->doc_field_pos	= "V&auml;lja positsioon";
$owl_lang->doc_field_label	= "V&auml;lja pealdis (Per Locale)";
$owl_lang->doc_field_size	= "V&auml;lja suurus";
$owl_lang->doc_field_searchable	= "Kas v&auml;li on otsitav?";
$owl_lang->doc_field_required	= "Kas v&auml;li on kohustuslik?";
$owl_lang->doc_new_doc_type	= "&#8212; Lisa uus dokumendit&uuml;&uuml;p &#8212;";
$owl_lang->doc_specific		= "DOKUMENDI ERIS&Auml;TTED:";
$owl_lang->doc_administration	= "Dokumendit&uuml;&uuml;bi haldus";

//********************************************************
// admin/doctype.php END
//********************************************************

                                                                                                                                                                           
//********************************************************
// DOC PEER Review  BEGIN
//********************************************************
                                                                                                                                                                           
$owl_lang->peer_reviewer_list   = "Reviewer(s)";
$owl_lang->peer_msg_to_reviewer = "Message to Reviewers";
$owl_lang->peer_final_approval  = "[Final Approval]: ";
$owl_lang->peer_subj_review     = "You have an OWL file to review";
$owl_lang->peer_subj_approved   = "Your Document has been APPROVED";
$owl_lang->peer_subj_rejected   = "Your Document has been REJECTED";
$owl_lang->peer_subj_reminder   = "REMINDER: You have a OWL file to review";
$owl_lang->peer_notif_user      = "Created/Update by";
$owl_lang->peer_file_to_review  = "File to review:";
$owl_lang->peer_file_approved   = "File Approved:";
$owl_lang->peer_file_rejected   = "File Rejected:";
$owl_lang->peer_file_final      = "Final Approval:";
$owl_lang->peer_final_body      = "Your document has been approved by all requested reviewers. Please login and make the document public";
$owl_lang->peer_review_body     = "Your approval has been requested for the following document:";
$owl_lang->peer_approved_body   = "Your file has been approved:";
$owl_lang->peer_rejected_body   = "Your file has been rejected:";
$owl_lang->peer_my_approval     = "Waiting my Approval";
$owl_lang->peer_pending_approval= "My Pending Approval";
$owl_lang->peer_satus_pending   = "&#8212; P E N D I N G &#8212;";
$owl_lang->peer_satus_rejected  = "&#8212; R E J E C T E D &#8212;";
$owl_lang->peer_satus_approved  = "&#8212; A P P R O V E D &#8212;";
$owl_lang->peer_satus           = "Status";
$owl_lang->peer_pending_title   = "My Documents Pending Approval";
$owl_lang->peer_approval_title  = "Documents Awaiting My Approval";                                                                                                                 
$owl_lang->owl_title_peer_review= "DOCUMENT PEER REVIEW FEATURE";
$owl_lang->owl_peer_review      = "Enable Peer Review Feature:";
$owl_lang->owl_peer_review_opt  = "Make Peer Review Optional:";
                                                                                                                                                                           
//********************************************************
// DOC PEER Review  END
//********************************************************
?>
