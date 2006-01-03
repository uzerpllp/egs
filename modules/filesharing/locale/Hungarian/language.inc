<?php  

/*

  File: Hungarian/language.inc      
  Author: Chris     
  Date: 2000/12/14

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
$owl_lang->err_adding_comments          = "Önnek nincs joga a megjegyzés hozzáfűzésére";
$owl_lang->err_comment_empty            = "Comment cannot be empty";
$owl_lang->err_backup_file   		= "Hiba az állomány mentésekor";
$owl_lang->err_backup_folder_create 	= "Mentés könyvtár létrehozási hiba";
$owl_lang->err_bad_url                  = "Kérem, adjon meg egy létező URL címet";
$owl_lang->err_bad_version_1 		= "Az Owl Intranethez szükséges minimális PHP verzió";
$owl_lang->err_bad_version_2 		= "Az Ön által használt verzió";
$owl_lang->err_bad_version_3 		= "Telepítsen egy újabb verziót, és próbálja újra";
$owl_lang->err_email         		= "Az üzenetet nem lehetett elküldeni";
$owl_lang->err_email_required   	= "Az E-mail mező kötelező";
$owl_lang->err_fexist1  		= "<b>Létező állomány:</b>";
$owl_lang->err_fexist2 			= "Van már ilyen nevű állomány <i>";
$owl_lang->err_fexist3 			= "</i> ebben a könyvtárban.";
$owl_lang->err_file_exists		= "A feltölteni kívánt állomány már létezik";
$owl_lang->err_fileexists    		= "Az átnevezés megszakadt<BR>Már létezik az állománynév.";
$owl_lang->err_file_lock     		= "Ezt az állományt már zárolták";
$owl_lang->err_update_file_lock         = "You cannot update this file, it is currently held by";
$owl_lang->err_filemove_exist           = "Már létezik olyan állománynév, amelyre ezt át akarja nevezni";
$owl_lang->err_file_not_exist 		= "Az állomány nem létezik a fájlrendszerben";
$owl_lang->err_file_too_big  		= "php.ini upload_max_filesize túllépés és/vagy<BR>Owl Max Upload file size túllépés";
$owl_lang->err_file_update		= "Az állomány neve módosítás esetén nem változtatható, próbálja újra";
$owl_lang->err_folder_create 		= "Könyvtár létrehozási hiba";
$owl_lang->err_folder_exist		= "A könyvtár már létezik";
$owl_lang->err_folderexists  		= "Az átnevezés megszakadt<BR>Már létezik a könytárnév.";
$owl_lang->err_general 			= "Hiba következett be";
$owl_lang->err_group_delete             = "Nem lehet olyan csoportot törölni, amelynek tagja van";
$owl_lang->err_group_exists             = "Már létezik ilyen nevű csoport.";
$owl_lang->err_gzip_not_found   	= "a gzip nem taláható : ";
$owl_lang->err_login   			= "Kérem, jelentkezzen be a művelet végrehajtásához";
$owl_lang->err_movecancel    		= "A mozgatás megszakadt<BR>";
$owl_lang->err_nameempty     		= "A könyvtárnév nem lehet üres";
$owl_lang->err_news_required            = "HIBA: Hír fejléc és tartalom szükséges!";
$owl_lang->err_no_access       		= "Egyetelen kiválasztott állományhoz sincs joga";
$owl_lang->err_no_access_info           = "Possible causes: <br></br>1) You did not click any checkbox in front of a File or Folder<br></br>2) Bulk Delete, Bulk Email, Bulk Checkout do not apply to Folders<br></br>3) You do not have access to any of the files or folders you have selected.";
$owl_lang->err_noemail           	= "Ezt az állományt nem küldheti el E-mail-ban";
$owl_lang->err_nofileaccess		= "Önnek nincs joga erre az állományra";
$owl_lang->err_nofiledelete		= "Önnek nincs joga az állomány törlésére";
$owl_lang->err_nofilemod		= "Önnek nincs joga az állomány módosítására";
$owl_lang->err_nofolderaccess		= "Önnek nincs joga erre erre könyvtárra";
$owl_lang->err_nofolderdelete		= "Önnek nincs joga ezt a könyvtárat törölni";
$owl_lang->err_nofoldermod		= "Önnek nincs joga ezt a könyvtárat módosítani";
$owl_lang->err_nosubfolder		= "Önnek nincs joga itt alkönyvtár létrehozására";
$owl_lang->err_note_title               = "A Cím kötelező mező";
$owl_lang->err_note_title_exists        = "Már létezik ilyen nevű megjegyzés";
$owl_lang->err_noupload			= "Önnek nincs joga feltölteni ebbe a könyvtárba";
$owl_lang->err_pass_missmatch		= "Az új jelszó két példánya nem azonos";
$owl_lang->err_pass_wrong    		= "A régi jelszó helytelen";
$owl_lang->err_pod2html_not_found       = "HIBA: A pod2html eszközt nem találtam:";
$owl_lang->err_quota			= "Tárolóhely limit túllépés miatt nem lehet feltölteni: ";
$owl_lang->err_quota_needed		= " szükséges ";
$owl_lang->err_quota_avail		= " rendelkezésre áll.";
$owl_lang->err_quota_exceed  		= "Az Ön tárolóhelye elfogyott";
$owl_lang->err_req      		= "HIBA: Az összes mezőt ki kell tölteni";
$owl_lang->err_root_delete              = "A kezdő könyvtár nem törölhető";
$owl_lang->err_sess_notvalid 		= "Hibás kapcsolat azonosító";
$owl_lang->err_sess_write		= "Hiba a kapcsolat információk adatbázisba írásakor";
$owl_lang->err_specialfoldername 	= "A 'backup' az Owl-ben foglat könyvtárnév, válasszon másikat";
$owl_lang->err_tar_not_found    	= "a tar nem található :";
$owl_lang->err_trash_can_empty          = "A szemétkosár üres";
$owl_lang->err_unauth_area   		= "Ehez a területhez nincs joga";
$owl_lang->err_unauthorized  		= "Jogtalan";
$owl_lang->err_upload 			= "Feltöltési hiba";
$owl_lang->err_user_exists		= "A felhasználó már létezik";
$owl_lang->err_cant_del_doc_type        = "Nem törölhető, létező dokumentumok használják ezt a típust";
$owl_lang->err_doc_type_name_req        = "A dokumentumtípus nevet meg kell adni <BR>";
$owl_lang->err_doc_field_req            = "Hiányzó kötelező mező:"; 
$owl_lang->err_field_name_req           = "A Név mezőt ki kel tölteni <BR>";
$owl_lang->err_field_label_req          = "A Címke mezőt ki kel tölteni <BR>";
$owl_lang->err_field_size_req           = "A Méret mezőt ki kel tölteni <BR>";
$owl_lang->err_forbidden_file		= "Tiltott állomány típus";
$owl_lang->err_file_indexing		= "Temp. 'TEXT' állomány létrehozási hiba";
$owl_lang->err_not_zip			= "Nem valódi ZIP archivum";
$owl_lang->err_database                 = "Database error";
$owl_lang->err_sql                      = "SQL error";


//********************************************************
// Error Messages END
//********************************************************

$owl_lang->btn_go_top      = "Go To Top";                                                                                                                                                           
$owl_lang->btn_go_bottom      = "Go To Bottom";
$owl_lang->btn_admin      		= "Admin.";
$owl_lang->btn_logout     		= "Kilépés";
$owl_lang->btn_browse     		= "Állományok";
$owl_lang->btn_mail_tool     		= "E-mail";
$owl_lang->btn_help     		= "Segít";
$owl_lang->btn_add_field          	= "Mező hozzáadás";
$owl_lang->btn_add_url          	= "Url hozzáadás";
$owl_lang->btn_create          		= "Készít";
$owl_lang->btn_register          	= "Regisztrál";
$owl_lang->btn_add_file          	= "Állomány hozzáadás";
$owl_lang->btn_add_zip           	= "Archivum hozzáadás";
$owl_lang->btn_admin_users          	= "Új felhasználó";
$owl_lang->btn_admin_groups          	= "Új csoport";
$owl_lang->btn_deldoctype          	= "Áll. tip. törlés";
$owl_lang->btn_expand_view          	= "Széles nézet";
$owl_lang->btn_add_folder          	= "Új könyvtár";
$owl_lang->btn_cancel          		= "Mégsem";
$owl_lang->btn_login          		= "Belép";
$owl_lang->btn_send_email          	= "E-mail küldés";
$owl_lang->btn_admin_news          	= "Hír adminisztráció";
$owl_lang->btn_add_news          	= "Új hír";
$owl_lang->btn_clickhere          	= "Kattinson ide";
$owl_lang->btn_edit_group          	= "Csoport szerkesztés";
$owl_lang->btn_add_note          	= "Új megjegyzés";
$owl_lang->btn_collapse_view          	= "Keskeny nézet";
$owl_lang->btn_edit_user          	= "Felhasználó szerkesztes";
$owl_lang->btn_bulk_move          	= "Több mozgatása";
$owl_lang->btn_bulk_delete          	= "Több törlése";
$owl_lang->btn_bulk_checkout       = "Bulk Checkout";
$owl_lang->btn_bulk_email          	= "Több küldés (Email)";
$owl_lang->btn_bulk_download          	= "Több letöltése";
$owl_lang->btn_reset          		= "Reset";
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
$owl_lang->alt_btn_bulk_move    = "Több állomány vagy könyvtár mozgatása";
$owl_lang->alt_btn_bulk_delete  = "Több állomány törlése";
$owl_lang->alt_btn_bulk_checkout          = "Bulk Checkout Files";
$owl_lang->alt_btn_bulk_email   = "Több állomány küldése (E-mail)";
$owl_lang->alt_btn_bulk_download= "Több állomány letöltése";
$owl_lang->alt_reset_form	= "Reset";
$owl_lang->alt_add_comments     = "Megjegyzés hozzáfűzése";
$owl_lang->alt_btn_add_file     = "Új állomány feltöltése";
$owl_lang->alt_btn_add_folder   = "Új könyvtár létrehozása";
$owl_lang->alt_add_group        = "Csoport létrehozása";
$owl_lang->alt_add_news         = "Add a New News Item";
$owl_lang->alt_btn_add_note     = "Add a New Note";
$owl_lang->alt_add_user         = "Create This User";
$owl_lang->alt_btn_add_url      = "Create a New Web link";
$owl_lang->alt_cancel		= "Akció megszakítása";
$owl_lang->alt_cancel_move      = "Cancel Move Action";
$owl_lang->alt_change           = "Update this Record";
$owl_lang->alt_btn_clickhere    = "Click Here";
$owl_lang->alt_btn_collapse_view= "Switch to a Reduced View";
$owl_lang->alt_comments         = "Comments Exist for this File";
$owl_lang->alt_del_comments     = "Delete This Comment";
$owl_lang->alt_del_file     	= "Állomány törlés (I/N)";
$owl_lang->alt_del_folder   	= "Könyvtár törlés (I/N)";
$owl_lang->alt_del_group        = "Delete This Group";
$owl_lang->alt_del_news         = "Delete This News";
$owl_lang->alt_del_selected     = "Delete all Selected Files";
$owl_lang->alt_del_all		= "Szemétkosár ürítés";
$owl_lang->alt_rest_selected	= "A kiválasztott állományok visszaállítása";
$owl_lang->alt_del_this_folder  = "Delete Folder &#8211; ";
$owl_lang->alt_del_user         = "Delete This User";
$owl_lang->alt_edit_group       = "Edit The Selected Group";
$owl_lang->alt_edit_news        = "Edit This News";
$owl_lang->alt_edit_user        = "Edit The Selected User";
$owl_lang->alt_email            = "Állomány küldése E-mailban";
$owl_lang->alt_email_selected   = "Kiválasztott állományok küldése E-mailban"; 
$owl_lang->alt_btn_expand_view  = "Switch to an Expanded View";
$owl_lang->alt_admin_flush   	= "Flush Stale/Expired Sessions";
$owl_lang->alt_get_file     	= "Állomány letöltése";
$owl_lang->alt_get_folder       = "Download Folder Content";
$owl_lang->alt_have_news        = "You Have News Item(s) To View";
$owl_lang->alt_have_no_news     = "No New News Item(s) To View";
$owl_lang->alt_home_folder      = "Back to Intial Dir ";
$owl_lang->alt_set_initial_dir  = "Set Current Dir as Initial";                                                                                                
$owl_lang->alt_site_map         = "Honlap térkép";
$owl_lang->alt_lock_file        = "Zárolás BE/KI";
$owl_lang->alt_log_clear        = "Napló törlés (I/N)";
$owl_lang->alt_log_file         = "Állomány napló";
$owl_lang->alt_log_next         = "Következő rekordok";
$owl_lang->alt_log_prev         = "Előző rekordok";
$owl_lang->alt_log_top          = "Első rekord";
$owl_lang->alt_btn_login        = "Belépés az Owl-be";
$owl_lang->alt_btn_logout       = "Kilépés az Owl-ből";
$owl_lang->alt_btn_help		= "Owl Online Segítség";
$owl_lang->alt_mod_file     	= "Állomány tulajdonságainak módósítása";
$owl_lang->alt_mod_folder   	= "Könyvtár tulajdonságainak módósítása";
$owl_lang->alt_move_file    	= "Állomány mozgatása";
$owl_lang->alt_copy_file     	= "Állomány másolása";
$owl_lang->alt_link_file     	= "Link másik könyvtárba"; 
$owl_lang->alt_move_folder  	= "Könyvtár mozgatása";
$owl_lang->alt_copy_folder   	= "Könyvtár másolása"; 
$owl_lang->alt_move_selected    = "A kiválasztottak mozgatása"; 
$owl_lang->alt_admin_groups 	= "Csoport létrehozás";
$owl_lang->alt_news_close       = "A hír ablak bezárása";
$owl_lang->alt_news_next        = "Következő hír";
$owl_lang->alt_news_prev        = "Előző hír";
$owl_lang->alt_news_print       = "Hír nyomtatása";
$owl_lang->alt_admin_users      = "Új felhasználó létrehozása";
$owl_lang->alt_monitor  	= "Nyomkövetés";
$owl_lang->alt_monitored        = "Nyomkövetés Laállítása";
$owl_lang->alt_btn_admin        = "Owl adminisztráció";
$owl_lang->alt_play_file        = "Media állomány lejátszása";
$owl_lang->alt_recycle          = "A szemétkosár üres";
$owl_lang->alt_recycle_disable  = "A szemétgyűjtés ki van kapcsolva";
$owl_lang->alt_recycle_not_found= "Nem találtam a szemétkosár helyét";
$owl_lang->alt_refresh_filter   = "Szűrő beállítás / Eredmények frissítése";
$owl_lang->alt_register         = "Regisztráció elküldése";
$owl_lang->alt_btn_browse       = "Vissza az állományokhoz";
$owl_lang->alt_search           = "Kersés beállítása";
$owl_lang->alt_send_email       = "E-mail küldés";
$owl_lang->alt_sendfile         = "Állomány küldés";
$owl_lang->alt_toggle_check_box = "Pipák váltása";
$owl_lang->alt_unlock_file      = "Zárolás feloldás";
$owl_lang->alt_upd_file     	= "Állomány módosítása";
$owl_lang->alt_view_comments    = "Megjegyzés felvitel/megtekintés";
$owl_lang->alt_view_file    	= "Állomány megtekintése";
$owl_lang->alt_edit_field       = "Mező definíció szerkesztése";
$owl_lang->alt_del_field        = "Mező törlése";
$owl_lang->alt_add_field        = "Mező hozzáadása";
$owl_lang->alt_deldoctype       = "Állománytípu störlése";
$owl_lang->alt_upd_field        = "Mező módosítása";
$owl_lang->alt_new_doctype      = "Új állomány típus létrehozása";
$owl_lang->alt_related		= "Kapcsolódó állományok keresése"; 
$owl_lang->alt_back             = "Return To Previous Screen";
$owl_lang->alt_submit           = "Submit Form";

//********************************************************
// Image Alternate popup Messages END
//********************************************************


//********************************************************
// Owl Logging messages BEGIN
//********************************************************

$owl_lang->log_del_det		= "Entire Content was also deleted";
$owl_lang->log_detail		= "No Additional Details";
$owl_lang->log_file_to		= "TO: ";
$owl_lang->log_filter_all	= "ALL";
$owl_lang->log_login_det	= "Username: ";
$log_file_actions[1]        	= "LOGIN";
$log_file_actions[2]        	= "LOGIN FAILED";
$log_file_actions[3]        	= "LOGOUT";
$log_file_actions[4]        	= "FILE DELETED";
$log_file_actions[5]        	= "FILE UPLOAD";
$log_file_actions[6]        	= "FILE UPDATED";
$log_file_actions[7]        	= "FILE DOWNLOADED";
$log_file_actions[8]        	= "FILE CHANGED";
$log_file_actions[9]        	= "FILE LOCKED";
$log_file_actions[10]        	= "FILE UNLOCKED";
$log_file_actions[11]        	= "FILE EMAILED";
$log_file_actions[12]        	= "FILE MOVED";
$log_file_actions[13]        	= "FOLDER CREATED";
$log_file_actions[14]        	= "FOLDER DELETED";
$log_file_actions[15]        	= "FOLDER MODIFIED";
$log_file_actions[16]        	= "FOLDER MOVED";
$log_file_actions[17]        	= "FORGOT PASS";
$log_file_actions[18]        	= "USER REG";
$log_file_actions[19]           = "FILE VIEWED";
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

$owl_lang->anonymous         	= "(Anoním belépés)";
$owl_lang->repository_list      = "Adatbázis:";
$owl_lang->loginfail		= "Belépési hiba";
$owl_lang->logindisabled     	= "A számlát zárolták, értesítse az Adminsztrátort!";
$owl_lang->toomanysessions	= "Ezzel a felhasználó névvel nem lehet több példányban belépni, értesítse az Adminsztrátort!";
$owl_lang->username		= "Felhasználó";
$owl_lang->password		= "Jelszó";
$owl_lang->login		= "Belépés";
$owl_lang->like_register        = "Kíván regisztrálni?";
$owl_lang->forgot_pass          = "Elfelejtette a jelszavát?";
$owl_lang->engine 		= "Owl állománykezelő";
$owl_lang->version 		= "Verzió";
$owl_lang->successlogout 	= "Ön kilépett";

//********************************************************
// index.php  END
//********************************************************


//********************************************************
// browse.php  BEGIN
//********************************************************

$owl_lang->menu_url_action              = "Available Url Actions";
$owl_lang->menu_file_action             = "Available File Actions";                                                
$owl_lang->menu_folder_action           = "Available Folder Actions";
$owl_lang->panel_file_info		= "Állomány információk";
$owl_lang->actions 			= "Akciók";
$owl_lang->del_selected          	= "Kiválasztottak törlése";
$owl_lang->del_all			= "Szemétkosár ürítés";
$owl_lang->rest_selected		= "Kiválasztottak visszaállítása";
$owl_lang->disk_quota                   = "Tárhely limit";
$owl_lang->email_selected        	= "Küldés E-mailban";
$owl_lang->file 			= "Állomány";
$owl_lang->folder_policy                = "Jogok a könyvtárra:";
$owl_lang->current_folder 		= "Könyvtár:";
$owl_lang->held                      	= "Zárolva"; // for version control
$owl_lang->last_logged              	= "Utolsó belépés: ";
$owl_lang->current_db         		= "Adatbázis:";
$owl_lang->modified 			= "Módosítva";
$owl_lang->move_selected         	= "Kiválasztottak mozgatása";
$owl_lang->new_file                     = "Új!";
$owl_lang->no_description               = "Nincs leírás";
$owl_lang->page                         = "Lap:";
$owl_lang->postedby 			= "Postázta";
$owl_lang->reallydelete			= "Biztosan törli :";
$owl_lang->reallydelete_logs            = "Biztosan törli a napló állományt";
$owl_lang->reallydelete_selected	= "Biztosan törli a kiválasztott állományokat";
$owl_lang->reallyrestore_selected	= "Biztosan visszaállítja a kiválasztott állományokat";
$owl_lang->size 			= "Méret";
$owl_lang->score                        = "Score";
$owl_lang->title 			= "Megnevezés";
$owl_lang->doc_number 			= "Áll. #";
$owl_lang->tot_files                    = "Összes:";                                                                                         
$owl_lang->tot_my_checked_out           = "Zárolt:";
$owl_lang->tot_my_files         	= "Saját:";                                                                                                                    
$owl_lang->tot_my_group                 = "Csoport:";
$owl_lang->tot_new_files                = "Új:";
$owl_lang->tot_updated_files            = "Módosított:";
$owl_lang->tot_monitored                = "Nyomkövetés:";
$owl_lang->updated_file         	= "Módosítva!";
$owl_lang->user              		= "Felhasználó";
$owl_lang->ver                       	= "Verzió"; // for version control
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

$owl_lang->none_selected        = "NINCS SEMMI KIVÁLASZTVA";
$owl_lang->adding_comments      = "Megjegyzés hozzáadás/megtekintés: ";
$owl_lang->comments      	= "Megjegyzés";
$owl_lang->post_comment		= "Megjegyzés hozzáfűzése"; 
$owl_lang->addingfile 		= "Dokumentum hozzáadás: ";
$owl_lang->addingfolder 	= "Könyvtár hozzáadás: ";
$owl_lang->attach_file       	= "Állomány hozzáfűzése";
$owl_lang->change		= "Változtat";
$owl_lang->create		= "Kész";
$owl_lang->comments_added       = "A megjegyzést hozzáfűzte: ";
$owl_lang->description 		= "Leírás";
$owl_lang->updating          	= "Módosítás";
$owl_lang->sendthisfile 	= "Küldendő állomány";
$owl_lang->sendthisurl       	= "URL cím küldés";
$owl_lang->sendfile 		= "Állomány küldés";
$owl_lang->keywords 		= "Kulcsszavak";
$owl_lang->modify_url           = "URL cím";
$owl_lang->permissions 		= "Jogok";                                                                                                                         
$owl_lang->prop_permissions     = "Az alkönyvtárak örököljék a jogokat?";
$owl_lang->prop_perms_files     = "Az állományok öröklött jogai:";
$owl_lang->vertype           	= "A módosítás típusa";  // for modify.php when uploading
$owl_lang->vermajor          	= "Alapvető módosítás (X.0)";
$owl_lang->verminor          	= "Kis módosítás (0.X)";
$owl_lang->verdescription	= "A módosítás <br></br>leírása";
$owl_lang->ownergroup        	= "Tulajdonos (Csoport)";
$owl_lang->name              	= "Név";                                                                                                                                                   
$owl_lang->notify_link          = "Owl külső Link";
$owl_lang->note_content         = "A megjegyzés tartalma";
$owl_lang->modifying		= "Módosítás ";
$owl_lang->disp_mp3          	= "MP3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dal:<BR>Album:<BR>Bitrate&nbsp;-&nbsp;Samplerate:<BR>Duration:<BR>Genre:<BR>Megj.:";
$owl_lang->ownership		= "Tulajdonos";
$owl_lang->policy 		= "Szabály";
$owl_lang->pick_select          = "&#8212; Válasszon egy Owl felhasználót &#8212;";
$owl_lang->emailing          	= "E-mail küldés";
$owl_lang->email_to          	= "Címzett";
$owl_lang->email_reply_to    	= "Feladó";
$owl_lang->email_cc          	= "Kapja még";
$owl_lang->email_subject     	= "Tárgy";
$owl_lang->email_body        	= "Üzenet";

//********************************************************
// modify.php  END
//********************************************************


//********************************************************
// register.php  BEGIN
//********************************************************
                                                                                                       
$owl_lang->register          	= "Felhasználó regisztráció";
$owl_lang->submit            	= "Regisztráció";
$owl_lang->thank_you_1          = "Köszönöm!";
$owl_lang->thank_you_2          = "Egy E-mail küldtünk az Ön címére <BR> az ÚJ jelszóval <BR><b>Felhasználó:</b>";
$owl_lang->self_reg_subj	= "Az Ön OWL számlája";
$owl_lang->self_reg_bod  	= "Az Ön Owl jelszava:";
$owl_lang->self_reg_rset 	= "Az Ön Owl jelszava átállítva:";
$owl_lang->full_name         	= "Teljes név";
$owl_lang->email             	= "Email cím";
$owl_lang->send_pass            = "Jelszó küldés";
$owl_lang->self_failed   	= "Sikertelen";
$owl_lang->self_passwd   	= "Jelszó elküldve:";

//********************************************************
// register.php  END
//********************************************************


//********************************************************
// move.php  BEGIN
//********************************************************

$owl_lang->moving            	= "Mozgatás";
$owl_lang->select            	= "Válasszon új könyvtárat:";
$owl_lang->cancel_button     	= "Mégsem";
$owl_lang->moving_file		= "Állomány mozgatás";
$owl_lang->moving_folder	= "Könyvtár mozgatás";
$owl_lang->copy_file		= "Állomány másolás";
$owl_lang->copy_folder		= "Könyvtár másolás";

//********************************************************
// move.php  END
//********************************************************


//********************************************************
// log.php  BEGIN
//********************************************************

$owl_lang->viewlog           = "Napló megtekintés ";

//********************************************************
// log.php  END
//********************************************************


//********************************************************
// prefs.php  BEGIN
//********************************************************

$owl_lang->confpassword	= "Új jelszó mégegyszer";
$owl_lang->comment_notif= "Értesítés megjegyzésről";
$owl_lang->email_tool   = "E-Mail Tool";
$owl_lang->last_modified= "Last Modified";
$owl_lang->group	= "Elsődleges csoport";
$owl_lang->groupmember	= "Csoporttagság";
$owl_lang->newpassword	= "Új jelszó";
$owl_lang->newsadmin    = "Hír adminisztrátor";
$owl_lang->not_member   = "Ön nem tagja egy másik csoprtnak sem";
$owl_lang->notification = "Értesítést kap";
$owl_lang->oldpassword	= "Régi jelszó";
$owl_lang->preference   = "Beállítások";
$owl_lang->saved	= "Változások elmentve";
$owl_lang->status_no    = "NEM";
$owl_lang->status_yes   = "IGEN";
$owl_lang->userlang     = "Nyelv";

//********************************************************
// prefs.php  END
//********************************************************


//********************************************************
// search.php  BEGIN
//********************************************************

$owl_lang->elapsed_time         = "eltelt idő";
$owl_lang->search            	= "Keresés";
$owl_lang->search_any_word      = "Bármely szó";
$owl_lang->search_all_word      = "Minden szó";
$owl_lang->search_entire_phrase = "Az egész kifejezés";
$owl_lang->search_match         = "Találat:";
$owl_lang->search_currentfolder = "Az aktuális könyvtárban";
$owl_lang->search_for_folders   = "Könyvtár keresése";
$owl_lang->search_for_files     = "Állományok keresése";
$owl_lang->search_score         = "Állományok sorrendje";
$owl_lang->search_results_for	= "A keresett szöveg :";
$owl_lang->search_winthindocs   = "Keresés tartalomban (text, pdf & MS-Word)";
$owl_lang->related_query_empty  = "No metadata associated with document to perform 'Search Related'";
$owl_lang->query_empty       	= "Üres a keresendő szöveg";

//********************************************************
// search.php  END
//********************************************************


//********************************************************
// view.php  BEGIN
//********************************************************

$owl_lang->viewing           = "Megtekint ";

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
$owl_lang->btn_users_groups		= "Felhasználók &amp;<br></br>csoportok";
$owl_lang->alt_btn_users_groups		= "Felhasználók és csoportok adminisztrációja";
$owl_lang->btn_html_prefs		= "HTML<br></br>beállítások";
$owl_lang->alt_btn_html_prefs		= "HTML beállítások szerkesztése";
$owl_lang->btn_site_features		= "Honlap<br></br>lehetőségek";
$owl_lang->alt_btn_site_features		= "Honlap lehetőségek és beállítások szerkesztése";
$owl_lang->btn_log_viewer		= "Napló<br></br>lista";
$owl_lang->alt_btn_log_viewer		= "Az Owl rendszernapló megtekintése";
$owl_lang->btn_statistics_viewer	= "Statisztika<br></br>lista";
$owl_lang->alt_btn_statistics_viewer	= "Owl Statisztika megtekintése";
$owl_lang->btn_news_admin		= "Hír<br></br>adminisztráció";
$owl_lang->alt_btn_news_admin		= "Owl Hír<br></br>adminisztráció";
$owl_lang->btn_doctype_admin		= "Állomány<br></br>típusok";
$owl_lang->alt_btn_doctype_admin		= "Állomány típusok adminisztrációja";
$owl_lang->btn_backup			= "Adatbázis<br></br>mentés";
$owl_lang->alt_btn_backup			= "SQL adatbázis mentése";
$owl_lang->btn_trashcan			= "Szemétkosár";
$owl_lang->alt_btn_trashcan			= "Kattintson ide a tartalom megtekintéséhez";
$owl_lang->btn_initial_load		= "Első betöltés";
$owl_lang->alt_btn_initial_load		= "A Documents könyvtár feltöltése adatbázisba";
$owl_lang->confirm_initial_load		= "*** WARNING ***  This should only be run once when the database is empty";
$owl_lang->add				= "Hozzáadás";
$owl_lang->anonymous_account            = "Anoním hozzáférés számlája:";                                                                                                                      
$owl_lang->buttonstyle                  = "Nyomógomb stílus";
$owl_lang->deletegroup			= "Csoport törlés";
$owl_lang->deleteuser			= "Felhasználó törlés";
$owl_lang->disableuser       		= "Felhasználó zárolása";
$owl_lang->disable_recs_per_page        = "Keskeny nézet esetén nem érvényesül az egy laplon megjelenő sorok száma beállítás!";
$owl_lang->file_admin_group             = "Állomány/Könyvtár Adminisztrátori csoport:";
$owl_lang->flushed           		= "A kapcsolat tábla kiürítve, a felhasználó most már be tud jelentkezni.<BR>";
$owl_lang->groups			= "Csoportok";
$owl_lang->hide_bulk_buttons            = "Többes (csoportos) gombok elrejtése:";
// Edit HTML Properties Messages
$owl_lang->ht_tbl_border_sz  		= "Táblázat keret mérete:";
$owl_lang->ht_tbl_hd_bg      		= "Fejléc háttere:";
$owl_lang->ht_tbl_cell_bg_cl 		= "A táblázatcellák háttérszíne:";
$owl_lang->ht_tbl_cell_bg_al 		= "A táblázatcellák háttérszíne, válozat:";
$owl_lang->ht_expand_width   		= "Széles nézet szélessége:";
$owl_lang->ht_collapse_width 		= "Keskeny nézet szélessége:";
$owl_lang->ht_bd_bg_image    		= "Szöveg háttér kép :";
$owl_lang->ht_bd_txt_cl      		= "Szöveg színe:";
$owl_lang->ht_bd_lnk_cl      		= "Linkek színe:";
$owl_lang->ht_bd_vlnk_cl     		= "Megnyitott Link színe:";
// Edit Prefs Properties Messages
$owl_lang->home_dir                     = "A felhasználó kezdőkönyvtára";
$owl_lang->initial_dir                  = "User's Initial Directory";
$owl_lang->maxsessions       		= "Kapcsolatok maximális száma";
$owl_lang->noprefaccess       		= "Kitüntetett hozzáférés kikapcsolása";
$owl_lang->owl_anon_full                = "Full Access";
$owl_lang->owl_anon_ro       		= "Anoním csak olvashat";
$owl_lang->owl_anon_download            = "Download Only";
$owl_lang->anonymous_access             = "Set Anonymous Access";
$owl_lang->owl_dbdump_path   		= "DB Dump eszköz helye:";
$owl_lang->owl_def_file_group_owner	= "Álapértelmezett állomány tulajdonos csoport:";
$owl_lang->owl_def_file_meta 		= "Álapértelmezett állomány leírás:";
$owl_lang->owl_def_file_owner		= "Álapértelmezett állomány tulajdonos:";
$owl_lang->owl_def_file_perm 		= "Álapértelmezett állomány létrehozási szabály:";
$owl_lang->owl_def_file_security	= "Álapértelmezett állomány jogok:";
$owl_lang->owl_def_file_title		= "Álapértelmezett állomány cím (ha üres, az állomány neve):";
$owl_lang->owl_def_fold_group_owner  	= "Álapértelmezett könyvtár tulajdonos csoport:";
$owl_lang->owl_def_fold_owner        	= "Álapértelmezett könyvtár tulajdonos:";
$owl_lang->owl_def_fold_sec  		= "Álapértelmezett könyvtár jogok:";
$owl_lang->owl_def_folder_perm 		= "Álapértelmezett könyvtár létrehozási szabály:";
$owl_lang->owl_default_tmpdir   	= "Temp állományok könyvtára: ";
$owl_lang->owl_email_from    		= "Feladó cím / SMTP bejelentkezés:";
$owl_lang->owl_email_fromname		= "Feladó neve:";
$owl_lang->owl_email_replyto 		= "Válasz cím:";
$owl_lang->owl_email_server  		= "SMTP szerver:";
$owl_lang->owl_email_smtp               = "SMTP levelezési metódus";
$owl_lang->owl_email_smtp_auth          = "SMTP azonosítás";
$owl_lang->owl_email_smtp_auth_login	= "SMTP felhasználó:";
$owl_lang->owl_email_smtp_auth_passwd   = "SMTP jelszó";
$owl_lang->owl_email_subject_pref       = "Tárgy Prefix:";
$owl_lang->owl_fogotpass             	= "Elfelejtette a jelszavát link";
$owl_lang->owl_group_user    		= "A csoport tagjai";
$owl_lang->owl_gzip_path     		= "gzip helye:";
$owl_lang->owl_hidebackup    		= "Backup könyvtár elrejtése:";
$owl_lang->owl_log_file      		= "Állományműveletek naplózása";
$owl_lang->owl_log_login_act 		= "Be/kilépés naplózása";
$owl_lang->owl_log_rec_page  		= "Napló megtekintő sorainak száma oldalanként";
$owl_lang->owl_logging       		= "Naplózás engedélyezve";
$owl_lang->owl_logo                  	= "Bejelenkezési logo ([Language]/graphics):";
$owl_lang->owl_lookAtHD      		= "Hard diszk keresés kikapcsolása:";
$owl_lang->owl_lookAtHDDel   		= "Törölt állományok eltávolítása az adatbázisból:";
$owl_lang->hide_folder_doc_count        = "Hide Folder File Type Count";                                                                                                                        
$owl_lang->hide_folder_size             = "Hide Folder Content Size";
$owl_lang->old_action_icons             = "Use pre Owl 0.80 Action Icons";
$owl_lang->search_result_folders        = "Include Folders in Search Results";
$owl_lang->restore_file_prefix          = "String Prefixed to Restored Files";
$owl_lang->owl_max_filesize  		= "Feltöltött állomány maximális mérete:";
$owl_lang->owl_owl_expand    		= "Alapértelmezett nézet (Széles)";
$owl_lang->owl_owl_timeout   		= "Kapcsolati idő lejár, másodperc:";
$owl_lang->virus_path                   = "Virus Checking Software Path<br />Example: '/usr/bin/clamscan --quiet' <br />&#8211; Blank for Disabled:";
$owl_lang->owl_pdftotext_path           = "Indexelés a kerséshez<BR>&#8212;PDF és text állományok (ha üres, kikapcsolva):";
$owl_lang->owl_wordtotext_path          = "&#8212;MS-WORD állományok (ha üres, kikapcsolva):";
$owl_lang->owl_pod2html_path            = "pod2html helye (Perl 5.8.0 vagy újabb szükséges):";
$owl_lang->owl_restrict_view 		= "Keskeny nézet lehetőség bekapcsolása";
$owl_lang->owl_self_reg      		= "Regisztráció lehetséges";
$owl_lang->owl_self_reg_hd   		= "Önmagukat regisztrálók alapértelmezései";
$owl_lang->owl_tar_path     		= "tar helye:";
$owl_lang->owl_title_custom             = "CUSTOMIZE BROWSER COLUMNS";
$owl_lang->owl_title_custom_search      = "CUSTOMIZE SEARCH RESULTS";
$owl_lang->owl_title_browser            = "OWL állománymegtekintő beállításai";
$owl_lang->owl_title_defaults   	= "Aapértelmezések";
$owl_lang->owl_title_email   		= "OWL e-Mail beállítások";
$owl_lang->owl_title_HD      		= "Új állományok keresése a hard diszken - beállítások";
$owl_lang->owl_title_logging  		= "Napló beállítások";
$owl_lang->owl_title_other   		= "Egyéb beállítások";
$owl_lang->owl_title_tools   		= "DB BACKUP/GZIP eszközök";
$owl_lang->owl_unzip_path               = "unzip helye:";
$owl_lang->owl_version_control		= "Verzió kontroll bekapcsolása";
$owl_lang->quota			= "Tárolóhely limit (0=nincs)";
$owl_lang->reallydeluser                = "Ez a felhasználó tulajdonosa %numfiles% állománynak és %numfolders% könyvtárnak. Biztos, hogy törölni akarja?";
$owl_lang->recs_per_page                = "Egy lapon megjelenő sorok száma (0 = nincs korlát):";
$owl_lang->remember_me_title            = "Bejelentkezési lehetőségek beállításai";
$owl_lang->remember_me                  = "Az emlékezzen rám sor látható";
$owl_lang->remember_timeout             = "A süti (cookie) életkora, nap";
$owl_lang->remember_me_checkbox         = "Emlékezzen rám";
$owl_lang->recycle_title                = "Szemétkosár beállításai";
$owl_lang->recycle_enabled              = "Szemétkosár engedélyezés:";
$owl_lang->recycle_location             = "Szemétkosár helye:";
$owl_lang->show_panel_title		= "Státusz sor:";
$owl_lang->show_search_title		= "Keresés csík látható:";
$owl_lang->show_pref_title		= "Beállítások/kijelentkezés:";
$owl_lang->show_bulk_title		= "Csoportos (bulk) gombok:";
$owl_lang->show_action_title		= "Akciógombok:";
$owl_lang->show_folder_title		= "Könyvtár eszközök:";
$owl_lang->show_panel			= "Megjelenik";
$owl_lang->hide_panel			= "Nem jelenik meg";
$owl_lang->status_bar_both              = "Mindkettő";
$owl_lang->status_bar_bottom            = "Alul";
$owl_lang->status_bar_location          = "Az állapotsor megjelenik:";
$owl_lang->status_bar_top               = "Felül";
$owl_lang->status_bar_not               = "Nem jelenik meg";
$owl_lang->use_popup                    = "Hírek megjelenítése felbukkanó ablakban";
$owl_lang->users			= "Felhasználók";
$owl_lang->header_user_admin            = "User Administration";
$owl_lang->header_group_admin           = "Group Administration";
$owl_lang->header_sitefeatures_settings           = "Site Features and Settings";

//********************************************************
// admin/index.php  END
//********************************************************


//********************************************************
// admin/log.php  BEGIN
//********************************************************

$owl_lang->owl_log_viewer    	= "Napló megjelenítő";
$owl_lang->owl_log_hd_action 	= "Akció";
$owl_lang->owl_log_hd_file   	= "Állomány";
$owl_lang->owl_log_hd_fld_path	= "Könyvtár elérési útvonala";
$owl_lang->owl_log_hd_user   	= "Felhasználó";
$owl_lang->owl_log_hd_dt_tm  	= "Dátum, idő";
$owl_lang->owl_log_hd_ip     	= "IP / Cím";
$owl_lang->owl_log_hd_agent  	= "Ügynök";
$owl_lang->owl_log_hd_dtls   	= "Részletek";
$owl_lang->owl_log_no_rec    	= " NINCS BEJEGYZÉS ";
$owl_lang->owl_log_hide      	= "Elrejt: ";
$owl_lang->owl_log_filter    	= "Szűrő";

//********************************************************
// admin/log.php  END
//********************************************************


//********************************************************
// admin/recycle.php  BEGIN
//********************************************************

$owl_lang->empty_trash          = "Szemétkosár ürítés";
$owl_lang->really_empty_trash   = "Biztosan kiüríti a szemétkosarat?";
$owl_lang->recycle_bin_admin    = "Szemétkosár adminisztráció";

//********************************************************
// admin/recycle.php  END
//********************************************************


//********************************************************
// lib/owl.lib.php  BEGIN
//********************************************************

$owl_lang->file_size_byte                       = "b";
$owl_lang->file_size_gigabyte                   = "G";
$owl_lang->file_size_kilobyte                   = "K";
$owl_lang->file_size_megabyte                   = "M";
$owl_lang->notif_subject_new 			= "Új OWL állomány";
$owl_lang->notif_subject_upd 			= "Karbantartott OWL állomány";
$owl_lang->notif_subject_monitor 		= "Egy nyomkövetésre jelölt OWL állomány vagy könyvtár módosult";
$owl_lang->notif_subject_comment        	= "Egy OWL állományhoz megjegyzést fűztek";
$owl_lang->notif_comment_1              	= "időpontja";
$owl_lang->notif_comment_2              	= "Megyjegyzés:";
$owl_lang->notif_msg         			= "EZ EGY AUTOMATIKUS ÜZENET AZ OWL Állománykezelőtől. <BR><BR>Kattintson a linkre az új/módosult állomány megtekintéséhez.<BR><BR>";
$owl_lang->notif_msg_alt         		= "EZ EGY AUTOMATIKUS ÜZENET AZ OWL Állománykezelőtől. \n\nKattintson a linkre az új/módosult állomány megtekintéséhez.\n\n";
$owl_lang->notif_msg_link               	= "EZ EGY AUTOMATIKUS ÜZENET AZ OWL Állománykezelőtől. <BR><BR>Find a link to a new/updated file in this Email<BR><BR>";
$owl_lang->notif_msg_alt_link           	= "EZ EGY AUTOMATIKUS ÜZENET AZ OWL Állománykezelőtől. \n\nFind a link to a new/updated file in this Email\n\n"; 
$owl_lang->notif_salutation             	= "Kedves";
$owl_lang->notif_user				= "Létrehozta/módosította:";
$owl_lang->owl_path                     	= "Állomány elérési útvonala: ";
$owl_lang->sessinuse				= "Ezt a kapcsolatot már más gépről használják<BR>";
$owl_lang->invalidsess				= "Tiltott kapcsolat azonosító, lépjen be a főlapról<BR>";
$owl_lang->sesstimeout				= "A kapcsolat ideje lejárt, lépjen be újra<BR>";
$owl_lang->everyoneread				= "Mindenki olvashatja/letöltheti";
$owl_lang->everyonewrite			= "Mindenki olvashatja/írhatja/letöltheti";
$owl_lang->everyonewrite_nod			= "Mindenki olvashatja/írhatja/letöltheti, NEM TÖRÖLHETŐ";
$owl_lang->groupread				= "Az Ön csoportja olvashatja/töltheti le";
$owl_lang->groupwrite				= "Az Ön csoportja olvashatja/írhatja/töltheti le";
$owl_lang->groupwrite_nod			= "Az Ön csoportja olvashatja/írhatja/töltheti le, NEM TÖRÖLHETŐ";
$owl_lang->onlyyou				= "Csak Ön olvashatja/írhatja/töltheti le";
$owl_lang->donothing                    	= "Nem csinál semmit - a jogok nem változnak";
$owl_lang->groupwrite_worldread 		= "Az Ön csoportja olvashatja/írhatja/töltheti le, mindenki olvashatja";
$owl_lang->groupwrite_worldread_nod 		= "Az Ön csoportja olvashatja/írhatja/töltheti le, mindenki olvashatja, NEM TÖRÖLHETŐ";
$owl_lang->ggroupwrite_worldread 		= "Az Ön csoprtja feltölthet ebbe a könyvtárba és törölheti, mindenki más láthatja atartalmát";
$owl_lang->ggroupwrite_worldread_nod 		= "Az Ön csoprtja feltölthet ebbe a könyvtárba, mindenki más láthatja atartalmát, NEM TÖRÖLHETŐ";
$owl_lang->everyoneread_ad			= "Mindenki olvashatja/letöltheti";
$owl_lang->everyonewrite_ad			= "Mindenki olvashatja/írhatja/letöltheti";
$owl_lang->everyonewrite_ad_nod			= "Mindenki olvashatja/írhatja/letöltheti, NEM TÖRÖLHETŐ";
$owl_lang->groupread_ad				= "A kiválasztott csoport olvashatja/töltheti le";
$owl_lang->groupwrite_ad			= "A kiválasztott csoport olvashatja/írhatja/töltheti le";
$owl_lang->groupwrite_ad_nod			= "A kiválasztott csoport olvashatja/írhatja/töltheti le, NEM TÖRÖLHETŐ";
$owl_lang->onlyyou_ad				= "Csak Ön olvashatja/írhatja/töltheti le";
$owl_lang->groupwrite_worldread_ad 		= "A kiválasztott csoport olvashatja/írhatja/töltheti le, mindenki olvashatja";
$owl_lang->groupwrite_worldread_ad_nod 		= "A kiválasztott csoport olvashatja/írhatja/töltheti le, mindenki olvashatja, NEM TÖRÖLHETŐ";
$owl_lang->ggroupwrite_worldread_ad 		= "A kiválasztott csoport feltölthet ebbe a könyvtárba és törölheti, mindenki más láthatja atartalmát";
$owl_lang->ggroupwrite_worldread_ad_nod		= "A kiválasztott csoport feltölthet ebbe a könyvtárba és törölheti, mindenki más láthatja atartalmát, NEM TÖRÖLHETŐ";
$owl_lang->geveryoneread			= "Mindenki olvashatja ezt a könyvtárat";
$owl_lang->geveryonewrite			= "Mindenki feltölthet és törölhet ebben a könyvtárban";
$owl_lang->geveryonewrite_nod			= "Mindenki feltölthet ebbe a könyvtárba";
$owl_lang->ggroupread				= "Az Ön csoportja olvashatja ezt a könyvtárat";
$owl_lang->ggroupwrite				= "Az Ön csoportja feltölthet és törölhet ebben a könyvtárban";
$owl_lang->ggroupwrite_nod			= "Az Ön csoportja tölhet fel ebbe a könyvtárba";
$owl_lang->gonlyyou				= "Csak Ön tölthet fel és törölhet ebben a könyvtárban";
$owl_lang->geveryoneread_ad			= "Mindenki olvashatja ezt a könyvtárat";
$owl_lang->geveryonewrite_ad			= "Mindenki feltölthet és törölhet ebben a könyvtárban";
$owl_lang->geveryonewrite_ad_nod		= "Mindenki feltölthet ebbe a könyvtárba";
$owl_lang->ggroupread_ad			= "A kiválasztott csoport olvashatja ezt a könyvtárat";
$owl_lang->ggroupwrite_ad   			= "A kiválasztott csoport feltölthet és törölhet ebben a könyvtárban";
$owl_lang->ggroupwrite_ad_nod			= "A kiválasztott csoport tölhet fel ebbe a könyvtárba";
$owl_lang->gonlyyou_ad				= "Csak Ön tölthet fel és törölhet ebben a könyvtárban";
$owl_lang->orphaned                     	= "&#8211; Nincs tulajdonos  &#8211;";
$owl_lang->virus_infected 			= "VÍRUSSAL FERTŐZÖTT ÁLLOMÁNY";
$owl_lang->virus_return_val			= "Vírus program válasza:";

//********************************************************
// lib/owl.lib.php  END
//********************************************************


//********************************************************
// HREF TITLE messages  BEGIN
//********************************************************

$owl_lang->title_browse_folder          = "Könyvtár megtekintése";
$owl_lang->title_browse_site            = "URL megtekintése";
$owl_lang->title_download_view          = "Állomány letőltés/megtekintés";
$owl_lang->title_edit_prefs             = "Felhasznlói beállítások megteintése/módosítása";
$owl_lang->title_return_folder          = "Vissza";
$owl_lang->title_sort                   = "Rendezés";
$owl_lang->title_view_new               = "Az utolsó belépés óta keletkezett állományok listája";
$owl_lang->title_view_updated           = "Az utolsó belépés óta módosult állományok listája";
$owl_lang->title_view_my                = "Saját állományok listája";

//********************************************************
// HREF TITLE messages  END
//********************************************************


//********************************************************
// admin/news.php and newsread.php BEGIN
//********************************************************

$owl_lang->news_title                   = "Hír adminisztráció";
$owl_lang->news_hd                      = "Hírek";
$owl_lang->news_hd_created              = "Keletkezett";
$owl_lang->news_hd_expires              = "Lejár";
$owl_lang->news_hd_audience             = "Célcsoport";
$owl_lang->news_heading                 = "Hír fejléc";
$owl_lang->news_content                 = "Tartalom";
$owl_lang->news_posted_date             = "Postázva:";
$owl_lang->news_read                    = "Olvasás";

//********************************************************
// admin/news.php and newsread.php  END
//********************************************************


//********************************************************
// DEBUG MESSAGES BEGIN
//********************************************************

$owl_lang->debug_tmp_not_exists         = "DEBUG: The OWL temporary Directory: $default->owl_tmpdir does not exists.";
$owl_lang->debug_tmp_not_writeable      = "DEBUG: The OWL temporary Directory: $default->owl_tmpdir is not writeable by the Web Server.";
$owl_lang->debug_doc_not_exists         = "DEBUG: The OWL Documents Directory: " .$default->owl_fs_root . "/" . fid_to_name(1) ." does not exists.";
$owl_lang->debug_doc_not_writeable      = "DEBUG: The OWL Documents Directory: " .$default->owl_fs_root . "/" . fid_to_name(1) ." is not writeable by the Web Server.";
$owl_lang->debug_webserver_no_access    = "DEBUG: The webserver does not have read access to: <br />'$default->owl_fs_root/$filename'. <br />Please fix the permissions and try again";
$owl_lang->debug_file_not_exist         = "DEBUG: The required file '$default->owl_fs_root/$filename' does not exists.<br /> OR<br />The path specified by \$default->owl_fs_root in config/owl.php is wrong.";
                                                                                                                                                                                                                                
//********************************************************
// DEBUG MESSAGES END
//********************************************************


//********************************************************
// admin/stats.php BEGIN
//********************************************************

$owl_lang->owl_stats_viewer     = "Statisztika";
$owl_lang->stats_files          = "Állományok száma felhasználónként";
$owl_lang->stats_folders        = "Könyvtárak száma felhasználónként";
$owl_lang->stats_top            = "A 20 legtöbbször letöltött";
$owl_lang->stats_users          = "USER Signon (Login / Failure / Logout)";
$owl_lang->stats_users_loggedin = "Currently Logged In";
$owl_lang->stats_information    = "Owl naplózását be kell kapcsolni, ha statisztikára kíváncsi";

//********************************************************
// admin/stats.php END
//********************************************************

//********************************************************
// admin/doctype.php BEGIN
//********************************************************

$owl_lang->document_type        = "Állomány típus";
$owl_lang->document_type_name   = "Állomány típus neve";
$owl_lang->doc_field_name       = "Mezőnév";
$owl_lang->doc_field_pos        = "Mező pozíció";
$owl_lang->doc_field_label      = "Mező címkéje";
$owl_lang->doc_field_size       = "Mező méret";
$owl_lang->doc_field_searchable = "Kereshető?";
$owl_lang->doc_field_required   = "Kötelező?";
$owl_lang->doc_new_doc_type     = "&#8212; Új állomány típus hozzáadása &#8212;";
$owl_lang->doc_specific         = "Állományra jellemző mezők:";
$owl_lang->doc_administration   = "Állománytípus adminisztráció";

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
