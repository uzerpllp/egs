<?php

/*

  File: English/language.inc
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
$owl_lang->err_adding_comments		= "Niemożesz Dodać komentarza Do Tego Pliku";
$owl_lang->err_comment_empty            = "Comment cannot be empty";
$owl_lang->err_backup_file   		= "Błąd Backupu Plik Istnieje";
$owl_lang->err_backup_folder_create 	= "Błąd Utworzenia Folderu Backup";
$owl_lang->err_bad_url                  = "Please enter a valid URL";
$owl_lang->err_bad_version_1 		= "Wymagana Jest Nowsza Wersja PHP";
$owl_lang->err_bad_version_2 		= "Zainsatlowana Wersja";
$owl_lang->err_bad_version_3 		= "Zainstaluj Nowszą Wersję PHP";
$owl_lang->err_email         		= "Wiadomość Nie Mogła Być Wysyłana";
$owl_lang->err_email_required		= "Adres Email Jest Wymagany";
$owl_lang->err_fexist1			= "<b>Plik Już Istnieje:</b>";
$owl_lang->err_fexist2 			= "Ta Nazwa Pliku Już Istnieje <i>";
$owl_lang->err_fexist3 			= "</i> w tym katalogu.";
$owl_lang->err_file_exists		= "Taki Plik Juz Istnieje";
$owl_lang->err_fileexists    		= "Błąd<BR>Plik O Takiej Nazwie Już Istnieje.";
$owl_lang->err_file_lock     		= "Nie możesz sprawdzić tego pliku,jest obecnie przetrzymywany przez..";
$owl_lang->err_update_file_lock         = "You cannot update this file, it is currently held by";
$owl_lang->err_filemove_exist       	= "Nazwa pliku,która chcesz nadać temu plikowi już istnieje";
$owl_lang->err_file_not_exist		= "Plik nie istnieje w systemie";
$owl_lang->err_file_too_big		= "Przekroczony rozmiar ladowanego pliku";
$owl_lang->err_file_update		= "Update pliku wymaga zachowania tej samej nazwy, proszę sprobój ponownie";
$owl_lang->err_folder_create 		= "Bląd w tworzeniu folderu";
$owl_lang->err_folder_exist		= "Ten Folder Już Istnieje";
$owl_lang->err_folderexists  		= "Anulowano nowo wprowadzoną nazwę.<BR> Folder o tej nazwie juz istnieje.";
$owl_lang->err_general 			= "Wystapił bląd";
$owl_lang->err_group_delete		= "Nie możesz usunąc grupy zawierającej czlonków";
$owl_lang->err_group_exists		= "Grupa o tej nazwie już istnieje.";
$owl_lang->err_gzip_not_found  		= "Gzip nie został znaleziony";
$owl_lang->err_login			= "Przed wykonaniem tej czynności zaloguj sie";
$owl_lang->err_movecancel    		= "Akcja została anulowana<BR>";
$owl_lang->err_nameempty    		= "Pole z nazwą folderu nie może być puste";
$owl_lang->err_news_required		= "BŁĄD: Nagłówek wiadomości I Zawartość wymagane!";
$owl_lang->err_no_access 		= "Brak Dostępu";
$owl_lang->err_no_access_info           = "Possible causes: <br></br>1) You did not click any checkbox in front of a File or Folder<br></br>2) Bulk Delete, Bulk Email, Bulk Checkout do not apply to Folders<br></br>3) You do not have access to any of the files or folders you have selected.";
$owl_lang->err_noemail			= "Nie Możesz Wysłąć Emaila Brak Dostepu";
$owl_lang->err_nofileaccess		= "Brak Dostępu Do Pliku";
$owl_lang->err_nofiledelete		= "Niemożesz Usunąć Pliku Brak Dostępu";
$owl_lang->err_nofilemod		= "Brak Dostępu";
$owl_lang->err_nofolderaccess		= "Brak Dostępu";
$owl_lang->err_nofolderdelete		= "Niemożesz Skasować Folderu Brak Dostępu";
$owl_lang->err_nofoldermod		= "Brak Dostępu";
$owl_lang->err_nosubfolder		= "Niemożesz Utworzyć Podkatalogu Brak Dostępu";
$owl_lang->err_note_title               = "Wypełnij pole : Tytuł";
$owl_lang->err_note_title_exists        = "Notatka o tej nazwie juz istnieje";
$owl_lang->err_noupload			= "Nie masz dostępu do uploadowanego folderu";
$owl_lang->err_pass_missmatch		= "Nowe hasło I potwierdzone hasło nie są takie same";
$owl_lang->err_pass_wrong    		= "Stare hasło jest błedne";
$owl_lang->err_pod2html_not_found       = "BŁĄD: Narzędzie pod2html nie zostało znalezione:";
$owl_lang->err_quota			= "Nie masz wystarczającego miejsca by uploadować ten plik: ";
$owl_lang->err_quota_needed		= " Potrzebny ";
$owl_lang->err_quota_avail		= " Dostępny.";
$owl_lang->err_quota_exceed  		= "Przekroczyłeś dostępne dla ciebie miejsce";
$owl_lang->err_req			= "BŁĄD: Wymagane uzupełnienie wszystkich pól";
$owl_lang->err_root_delete		= "Główny folder nie może być usunięty";
$owl_lang->err_sess_notvalid 		= "Sesja nie jest aktywna";
$owl_lang->err_sess_write		= "Błąd w czasie wpisywania operacji do bazy";
$owl_lang->err_specialfoldername 	= "'backup' Ta nazwa jest zarezerwowana . Wybierz inną";
$owl_lang->err_tar_not_found  		= "nie został znaleziony ";
$owl_lang->err_trash_can_empty 		= "Kosz jest pusty";
$owl_lang->err_unauth_area   		= "Nie masz uprawnień do korzystania z tej strefy";
$owl_lang->err_unauthorized  		= "Brak Autoryzacji";
$owl_lang->err_upload 			= "Błąd Uploadowania";
$owl_lang->err_user_exists		= "Użytkownik już Istnieje";
$owl_lang->err_cant_del_doc_type        = "Cannot Delete there are files using this Document Type";
$owl_lang->err_doc_type_name_req        = "Document Type Name is Required <BR>";
$owl_lang->err_field_name_req           = "Field Name is Required <BR>";
$owl_lang->err_doc_field_req            = "Missing Required Field:";
$owl_lang->err_field_label_req          = "Field Label is Required <BR>";
$owl_lang->err_field_size_req           = "Field Size is Required <BR>";
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
$owl_lang->alt_add_comments     = "Dodaj Komentarz do Pliku";
$owl_lang->alt_btn_add_file     = "Dodaj Nowy Plik";
$owl_lang->alt_btn_add_folder	= "Utwórz nowy Folder";
$owl_lang->alt_add_group	= "Utwórz Grupę";
$owl_lang->alt_add_news		= "Dodaj Nową Wiadomość";
$owl_lang->alt_btn_add_note     = "Dodaj Nową Notatkę";
$owl_lang->alt_add_user		= "Utwórz Tego Użytkownika";
$owl_lang->alt_btn_add_url	= "Utwórz Nowy Link";
$owl_lang->alt_cancel		= "Zrezygnuj";
$owl_lang->alt_cancel_move	= "Zrezygnyj Z Przeniesienia";
$owl_lang->alt_change		= "Updatuj To Nagranie";
$owl_lang->alt_btn_clickhere	= "Kliknij Tu";
$owl_lang->alt_btn_collapse_view= "Przejdż Do Zredukowanego Widoku";
$owl_lang->alt_comments 	= "Komentarz Do Tego Pliku Już Istnieje";
$owl_lang->alt_del_comments     = "Skasuj komentarz";
$owl_lang->alt_del_file      	= "Skasuj Plik (Y/N)";
$owl_lang->alt_del_folder    	= "Skasuj Folder (Y/N)";
$owl_lang->alt_del_group	= "Skasuj Grupę";
$owl_lang->alt_del_news		= "Skasuj News";
$owl_lang->alt_del_selected	= "Skasuj Zaznaczone Pliki";
$owl_lang->alt_del_all          = "Empty Trash";
$owl_lang->alt_rest_selected    = "Restore all Selected Files";
$owl_lang->alt_del_this_folder	= "Skasuj Folder &#8211; ";
$owl_lang->alt_del_user		= "Usuń Użytkownika";
$owl_lang->alt_edit_group       = "Edytuj Group";
$owl_lang->alt_edit_news	= "Edytuj News";
$owl_lang->alt_edit_user        = "Edytuj Użytkownika";
$owl_lang->alt_email		= "Wyślij Emailem";
$owl_lang->alt_email_selected	= "Wyślij Emailem Zaznaczone Pliki";
$owl_lang->alt_btn_expand_view  = "Przejdż Do Widoku Rozszerzonego";
$owl_lang->alt_admin_flush      = "Wygaśniecie Sesji";
$owl_lang->alt_get_file      	= "Pobierz Plik";
$owl_lang->alt_get_folder       = "Download Folder Content";
$owl_lang->alt_have_news	= "Masz Nową Wiadomość Do Wyświetlenia";
$owl_lang->alt_have_no_news	= "Brak Nowych Wiadomości Do Wyświetlenia";
$owl_lang->alt_home_folder      = "Back to Intial Dir ";
$owl_lang->alt_set_initial_dir  = "Set Current Dir as Initial";
$owl_lang->alt_site_map         = "Site Map";
$owl_lang->alt_lock_file        = "Zablokuj Plik";
$owl_lang->alt_log_clear        = "Skasuj Wszytkie Logi (Y/N)";
$owl_lang->alt_log_file         = "Log Pliku";
$owl_lang->alt_log_next		= "Dalej";
$owl_lang->alt_log_prev		= "Wróć";
$owl_lang->alt_log_top		= "Idż Do Pierwszego";
$owl_lang->alt_btn_login 	= "Zaloguj Się";
$owl_lang->alt_btn_logout	= "Wyloguj Się";
$owl_lang->alt_btn_help         = "Owl Online Help";
$owl_lang->alt_mod_file      	= "Modyfikuj Włąsciwości Pliku"; 
$owl_lang->alt_mod_folder    	= "Modyfikuj Włąsciwości Folderu";
$owl_lang->alt_move_file     	= "Przenieś Plik";
$owl_lang->alt_copy_file        = "Copy File";
$owl_lang->alt_link_file        = "Link This File to Another Directory";
$owl_lang->alt_move_folder   	= "Przenieś Folder";
$owl_lang->alt_copy_folder      = "Copy Folder";
$owl_lang->alt_move_selected	= "Przenieś Zaznaczone Pliki";
$owl_lang->alt_admin_groups	= "Utwórz Nową Grupę";
$owl_lang->alt_news_close	= "Zamknij Okno Newsa";
$owl_lang->alt_news_next	= "Pokaż Nową Wiadomość";
$owl_lang->alt_news_prev	= "Pokaż Poprzednią Wiadomość";
$owl_lang->alt_news_print	= "Wydrukuj Wiadomość";
$owl_lang->alt_admin_users	= "Utwórz Nowego Uzytkownika";
$owl_lang->alt_monitor		= "Monitoruj Ten Plik";
$owl_lang->alt_monitored	= "Przestań Monitorować Ten Plik";
$owl_lang->alt_btn_admin 	= "Panel Administracyjny";
$owl_lang->alt_play_file 	= "Odtwórz Multimedia";
$owl_lang->alt_recycle		= "Twój kosz Jest Pusty";
$owl_lang->alt_recycle_disable	= "Wyświetlanie Kosza Wyłączone";
$owl_lang->alt_recycle_not_found= "Nie Odnaleziono Kosza";
$owl_lang->alt_refresh_filter	= "Podstawowy Filtr / Odświerz Rezultaty";
$owl_lang->alt_register		= "Submit your Registration";
$owl_lang->alt_btn_browse	= "Wróć Do Uploadu";
$owl_lang->alt_search		= "Rozpocznij Szukanie";
$owl_lang->alt_send_email	= "Wyślij Emailem";
$owl_lang->alt_sendfile		= "Wyślij Ten Plik";
$owl_lang->alt_toggle_check_box	= "Toggle Check Boxes";
$owl_lang->alt_unlock_file      = "Odblokuj Plik";
$owl_lang->alt_upd_file      	= "Updatuj plik";
$owl_lang->alt_view_comments    = "Dodaj / Zobacz Komentarz Pliku";
$owl_lang->alt_view_file     	= "Podejrzyj Plik";
$owl_lang->alt_edit_field       = "Edit This Field Definition";
$owl_lang->alt_del_field        = "Delete This Field";
$owl_lang->alt_add_field        = "Add The Field Above";
$owl_lang->alt_deldoctype       = "Delete Current Document Type";
$owl_lang->alt_upd_field        = "Update This Field";
$owl_lang->alt_new_doctype      = "Create New Document Type";
$owl_lang->alt_related          = "Find Releated Documents";
$owl_lang->alt_back             = "Return To Previous Screen";
$owl_lang->alt_submit           = "Submit Form";

//********************************************************
// Image Alternate popup Messages END
//********************************************************


//********************************************************
// Owl Logging messages BEGIN
//********************************************************

$owl_lang->log_del_det		= "Cała Zawartość Została Usunięta";
$owl_lang->log_detail		= "Żadnych Dodatkowych Szczegółów";
$owl_lang->log_file_to		= "DO: ";
$owl_lang->log_filter_all	= "WSZYSCY";
$owl_lang->log_login_det	= "NICK: ";
$log_file_actions[1]        	= "LOGIN";
$log_file_actions[2]        	= "NIEPRAWIDŁOWY LOGIN";
$log_file_actions[3]        	= "WYLOGUJ";
$log_file_actions[4]        	= "PLIK USUNIETY";
$log_file_actions[5]        	= "PLIK UPLOADOWANY";
$log_file_actions[6]        	= "PLIK UPDATOWANY";
$log_file_actions[7]        	= "PLIK POBRANY";
$log_file_actions[8]        	= "PLIK ZMIENIONY";
$log_file_actions[9]        	= "PLIK ZABLOKOWANY";
$log_file_actions[10]        	= "PLIK ODBLOKOWANY";
$log_file_actions[11]        	= "PLIK WYSŁANY EMAILEM";
$log_file_actions[12]        	= "PLIK PRZENIESIONY";
$log_file_actions[13]        	= "FOLDER UTWOŻONY";
$log_file_actions[14]        	= "FOLDER USUNIĘTY";
$log_file_actions[15]        	= "FOLDER ZMODYFIKOWANY";
$log_file_actions[16]        	= "FOLDER PRZENIESIONY";
$log_file_actions[17]        	= "ZAPOMNIANE HASLO";
$log_file_actions[18]        	= "UŻYTKOWNIK REG";
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

$owl_lang->anonymous 		= "(Dostep anonimowy)";
$owl_lang->repository_list      = "Repository:";
$owl_lang->engine 		= "modified by : @aro_w  @Mr_Alucard language sk&pl by @Snacan @Monia ";
$owl_lang->forgot_pass		= "PRZYPOMNIJ HASŁO";
$owl_lang->like_register	= "REJESTRACJA";
$owl_lang->login		= "Login";
$owl_lang->loginfail		= "Błąd Logowania";
$owl_lang->logindisabled	= "Dostęp został ZABLOKOWANY, skontaktuj się z Administratorem";
$owl_lang->password		= "HASŁO";
$owl_lang->successlogout 	= "Wylogowany";
$owl_lang->toomanysessions	= "Wykorzystałeś maksymalną ilość sesji, skontaktuj się z Administratorem";
$owl_lang->username		= "NAZWA UŻYTKOWNIKA";
$owl_lang->version 		= "Version";

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
$owl_lang->actions 			= "Operacje Na Plikach";
$owl_lang->del_selected			= "Skasuj Zaznaczony";
$owl_lang->del_all                      = "Empty Trash";
$owl_lang->rest_selected                = "Restore Selected";
$owl_lang->disk_quota			= "Twoje Miesjsce Na Dysku";
$owl_lang->email_selected		= "Email Wybrany";
$owl_lang->file 			= "Nazwa Pliku";
$owl_lang->folder_policy                = "Current Folder Policy:";
$owl_lang->current_folder               = "Current Folder:";
$owl_lang->held                      	= "Lock"; 
$owl_lang->last_logged			= "Ostatnio Zalogowany: ";
$owl_lang->current_db                   = "Current Repository:";
$owl_lang->modified 			= "Data Uploadowania";
$owl_lang->move_selected		= "Przenieś Zaznaczony";
$owl_lang->new_file			= "Nowy!";
$owl_lang->no_description		= "Brak Opisu";
$owl_lang->page                         = "Page:";
$owl_lang->postedby 			= "Nick ";
$owl_lang->reallydelete			= "Usuń";
$owl_lang->reallydelete_logs		= "Usuń Log Pliku";
$owl_lang->reallydelete_selected	= "Usuń Wybrane Pliki";
$owl_lang->reallyrestore_selected       = "Really Restore all selected files";
$owl_lang->size 			= "Wielkość";
$owl_lang->score                        = "Score";
$owl_lang->title 			= "Nazwa";
$owl_lang->doc_number                   = "Doc #";
$owl_lang->tot_files			= "Razem:";
$owl_lang->tot_my_checked_out           = "Checked Out:";
$owl_lang->tot_my_files			= "Moje:";
$owl_lang->tot_my_group                 = "Group:";
$owl_lang->tot_new_files		= "Nowe:";
$owl_lang->tot_updated_files		= "Wszystkie:";
$owl_lang->tot_monitored                = "Monitored:";
$owl_lang->updated_file			= "Dodane!";
$owl_lang->user               		= "Użytkownik";
$owl_lang->ver                       	= "Wersja."; 
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
$owl_lang->adding_comments      = "Dodaj / Zobacz Komentarz: ";
$owl_lang->comments             = "Comment";
$owl_lang->post_comment         = "Post Comment";
$owl_lang->addingfile 		= "Dodaj Plik Do ";
$owl_lang->addingfolder 	= "Dodaj Folder Do ";
$owl_lang->attach_file		= "Dołącz Plik";
$owl_lang->change		= "Zmień";
$owl_lang->create		= "Utwórz";
$owl_lang->comments_added       = "Komentarz Dodany Przez: ";
$owl_lang->description 		= "Opis";
$owl_lang->email_body		= "Wiadomość";
$owl_lang->email_cc          	= "CC";
$owl_lang->email_reply_to	= "Odpowiedz";
$owl_lang->email_subject	= "Temat";
$owl_lang->email_to		= "Odpisz";
$owl_lang->emailing		= "Emailing";
$owl_lang->disp_mp3		= "MP3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Utwór:<BR>Album:<BR>Bitrate&nbsp;-&nbsp;Samplerate:<BR>Czas Trwania:<BR>Genre:<BR>Komentarz:";
$owl_lang->keywords 		= "Słowa kluczowe";
$owl_lang->modify_url		= "URL";
$owl_lang->modifying		= "Modyfikuj ";
$owl_lang->name               	= "Nazwa /Imię";     
$owl_lang->notify_link          = "Owl External Link";
$owl_lang->note_content         = "Zawartość Notatki";
$owl_lang->ownergroup         	= "Włąściciel (Grupa)";
$owl_lang->ownership		= "Włąsciciele";
$owl_lang->permissions 		= "Zezwolenia";
$owl_lang->prop_permissions     = "Propagate Permissions to subfolders?";
$owl_lang->prop_perms_files     = "Permissions to propagate to files:";
$owl_lang->policy 		= "Sposób postępowania";
$owl_lang->pick_select		= "&#8212; Wybierz Użytkownika &#8212;";
$owl_lang->sendfile 		= "Wyślij Plik";
$owl_lang->sendthisfile 	= "Wyślij Ten Plik";
$owl_lang->sendthisurl       	= "Wyślij ten URL";
$owl_lang->updating		= "Updatuj";
$owl_lang->verdescription 	= "Opis<br></br>Zmian";
$owl_lang->vermajor          	= "Numer";
$owl_lang->verminor          	= "Wersja";
$owl_lang->vertype           	= "Typ";  

//********************************************************
// modify.php  END
//********************************************************


//********************************************************
// register.php  BEGIN
//********************************************************

$owl_lang->email             	= "Addres Email ";
$owl_lang->full_name		= "Nick";
$owl_lang->register		= "Rejestracja Użytkownika";
$owl_lang->self_failed		= "Nieudało Się";
$owl_lang->self_passwd		= "Hasło Wysłano Do:";
$owl_lang->self_reg_bod		= "Twoje Hasło Do Uploadu To:";
$owl_lang->self_reg_rset	= "Twoje Nowe Hasło Do Uploadu To:";
$owl_lang->self_reg_subj	= "Twoje Konto";
$owl_lang->send_pass		= "Wyślij Hasło";
$owl_lang->submit		= "Zarejestruj Się";
$owl_lang->thank_you_1		= "Dziękuję!";
$owl_lang->thank_you_2		= "Email Z Nowym Hasłem Został Wysłany<BR> Dla <BR><b>Użytkownik:</b>";

//********************************************************
// register.php  END
//********************************************************


//********************************************************
// move.php  BEGIN
//********************************************************

$owl_lang->cancel_button	= "Anuluj";
$owl_lang->moving		= "Przenieś";
$owl_lang->moving_file          = "Moving file";
$owl_lang->moving_folder        = "Moving Folder";
$owl_lang->copy_file            = "Copying file";
$owl_lang->copy_folder          = "Copying Folder";
$owl_lang->select		= "Wybierz Nowy Folder:";

//********************************************************
// move.php  END
//********************************************************


//********************************************************
// log.php  BEGIN
//********************************************************

$owl_lang->viewlog	= "Zobacz Logi Dla ";

//********************************************************
// log.php  END
//********************************************************


//********************************************************
// prefs.php  BEGIN
//********************************************************

$owl_lang->confpassword	= "Powtórz Hasło";
$owl_lang->comment_notif= "Widoczny Komentarz";
$owl_lang->email_tool   = "E-Mail Tool";
$owl_lang->last_modified= "Last Modified";
$owl_lang->group	= "Grupa Nadrzędna";
$owl_lang->groupmember	= "Grupa";
$owl_lang->newpassword	= "Nowe Hasło";
$owl_lang->newsadmin	= "Administrator Newsów";
$owl_lang->not_member	= "Nie Jesteś Użytkownikiem Tej Grupy";
$owl_lang->notification	= "Wysyłaj Uploadowane Pliki Na Mój Email";
$owl_lang->oldpassword	= "Poprzednie Hasło";
$owl_lang->preference	= "Preferencje";
$owl_lang->saved	= "Zapisz Kometarz";
$owl_lang->status_no	= "NIE";
$owl_lang->status_yes	= "TAK";
$owl_lang->userlang	= "Język";

//********************************************************
// prefs.php  END
//********************************************************


//********************************************************
// search.php  BEGIN
//********************************************************

$owl_lang->elapsed_time         = "elapsed time";
$owl_lang->search             	= "Szukaj";
$owl_lang->search_any_word      = "Any Words";
$owl_lang->search_all_word      = "All Words";
$owl_lang->search_entire_phrase = "Entire Phrase";
$owl_lang->search_match         = "Match:";
$owl_lang->search_currentfolder = "Search Current Folder";
$owl_lang->search_for_folders   = "Searching For Folders";
$owl_lang->search_for_files     = "Searching For Files";
$owl_lang->search_score         = "Scoring Files";
$owl_lang->search_results_for	= "Szukaj Dla";
$owl_lang->search_winthindocs   = "Search Within (text & pdf) Documents";
$owl_lang->related_query_empty  = "No metadata associated with document to perform 'Search Related'";
$owl_lang->query_empty       	= "Brak Wyników Wyszukiwania";

//********************************************************
// search.php  END
//********************************************************


//********************************************************
// view.php  BEGIN
//********************************************************

$owl_lang->viewing	= "Zobacz ";

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
$owl_lang->add				= "Dodaj";
$owl_lang->anonymous_account		= "Dostęp Anonimowy:";                                                                                                                      
$owl_lang->buttonstyle                  = "Button Style";
$owl_lang->deletegroup			= "Skasuj Grupę";
$owl_lang->deleteuser			= "Skasuj Użytkownika";
$owl_lang->disableuser			= "Zablokuj Użytkownika";
$owl_lang->disable_recs_per_page        = "Enabling Restricted View Will DISABLE Records Per Page!";
$owl_lang->file_admin_group		= "Przeglądanie/Plików Grupy Admin:";
$owl_lang->flushed           		= "Sesja Wygasła Zaloguj Się Ponownie.<BR>";
$owl_lang->groups			= "Grupa";
$owl_lang->hide_bulk_buttons		= "Ukryj Przyciski:";
// Edit HTML Properties Messages BEGIN
$owl_lang->ht_tbl_border_sz 		= "Table Border Size:";
$owl_lang->ht_tbl_hd_bg			= "Header Background:";
$owl_lang->ht_tbl_cell_bg_cl 		= "Table Cell Background Colour:";
$owl_lang->ht_tbl_cell_bg_al 		= "Table Cell Background Colour Alternate:";
$owl_lang->ht_expand_width		= "Expanded View Width:";
$owl_lang->ht_collapse_width 		= "Collapse View Width:";
$owl_lang->ht_bd_bg_image		= "Body Background Image Path:";
$owl_lang->ht_bd_txt_cl 		= "Body Text Colour:";
$owl_lang->ht_bd_lnk_cl			= "Body Link Colour:";
$owl_lang->ht_bd_vlnk_cl 		= "Body Visited Link Colour:";
// Edit Prefs Properties Messages END
$owl_lang->home_dir                     = "User's Home Directory";
$owl_lang->initial_dir                  = "User's Initial Directory";
$owl_lang->maxsessions			= "Max Ilość Sesji";
$owl_lang->noprefaccess			= "Zamknij Preferencje";
$owl_lang->owl_anon_full                = "Full Access";
$owl_lang->owl_anon_ro			= "Anonimowy Tylko Do Odczytu:";
$owl_lang->owl_anon_download            = "Download Only";
$owl_lang->anonymous_access             = "Set Anonymous Access";
$owl_lang->owl_dbdump_path   		= "DB Narzędzia :";
$owl_lang->owl_def_file_group_owner	= "Default File Group Owner:";
$owl_lang->owl_def_file_meta		= "Default File Meta Data:";
$owl_lang->owl_def_file_owner		= "Default File Owner:";
$owl_lang->owl_def_file_perm 		= "Podstawowe Włąściwości Tworzenia Plików:";
$owl_lang->owl_def_file_security	= "Podstawowe Zabezpieczenia Plików:";
$owl_lang->owl_def_file_title		= "Default File Title (None for Filename):";
$owl_lang->owl_def_fold_group_owner	= "Default Folder Group Owner:";
$owl_lang->owl_def_fold_owner		= "Default Folder Owner:";
$owl_lang->owl_def_fold_sec		= "Podstawowe Zabezpieczenia Folderów:";
$owl_lang->owl_def_folder_perm 		= "Podstawowe Włąściwości Tworzenia Folderów:";
$owl_lang->owl_default_tmpdir		= "Lokalizacja Katalogu Temp: ";
$owl_lang->owl_email_from		= "Login Do / SMTP :";
$owl_lang->owl_email_fromname		= "Od:";
$owl_lang->owl_email_replyto		= "Odpisz na Adres:";
$owl_lang->owl_email_server		= "SMTP Server:";
$owl_lang->owl_email_smtp		= "Użyj SMTP";
$owl_lang->owl_email_smtp_auth		= "Użyj Autoryzacji SMTP";
$owl_lang->owl_email_smtp_auth_login    = "SMTP Auth Login:";
$owl_lang->owl_email_smtp_auth_passwd	= "Hasło Do SMTP";
$owl_lang->owl_email_subject_pref	= "Przedrostek Tematu:";
$owl_lang->owl_fogotpass		= "Przypominanie Hasła:";
$owl_lang->owl_group_user		= "Członkowie Grupy";
$owl_lang->owl_gzip_path     		= "Ścieżka Do gzip:";
$owl_lang->owl_hidebackup		= "Ukryj Folder Backupu:";
$owl_lang->owl_log_file			= "Logowanie Aktywne:";
$owl_lang->owl_log_login_act		= "Loguj Czynności:";
$owl_lang->owl_log_rec_page		= "Ilość Logów Na Stronie:";
$owl_lang->owl_logging			= "Uruchom Logowanie:";
$owl_lang->owl_logo			= "Loguj System Uzytkownika";
$owl_lang->owl_lookAtHD			= "Zablokuj Podgląd HD:";
$owl_lang->owl_lookAtHDDel		= "Usuń Skasowane Pliki Z bazy:";
$owl_lang->hide_folder_doc_count        = "Hide Folder File Type Count";                                                                                                                        
$owl_lang->hide_folder_size             = "Hide Folder Content Size";
$owl_lang->old_action_icons             = "Use pre Owl 0.80 Action Icons";
$owl_lang->search_result_folders        = "Include Folders in Search Results";
$owl_lang->restore_file_prefix          = "String Prefixed to Restored Files";
$owl_lang->owl_max_filesize		= "Maxymalna Wielkość Pliku:";
$owl_lang->owl_owl_expand		= "Podstawowy Widok (Expand):";
$owl_lang->owl_owl_timeout		= "Długość Sesji:";
$owl_lang->virus_path                   = "Virus Checking Software Path<br />Example: '/usr/bin/clamscan --quiet' <br />&#8211; Blank for Disabled:";
$owl_lang->owl_pdftotext_path		= "Ukrywaj Przeszukiwanie Indexu Dla <BR>PDF i TXT<BR>&#8211; Brak Wyłączone:";
$owl_lang->owl_wordtotext_path          = "MS-WORD Files <BR>&#8211; Blank for Disabled:";
$owl_lang->owl_pod2html_path            = "Perl 5.8.0 Wymagany<BR>Ścieżka Do pod2html:";
$owl_lang->owl_restrict_view		= "Restrykcje Podglądu:";
$owl_lang->owl_self_reg			= "Udostępnij Rejestracje:";
$owl_lang->owl_self_reg_hd		= "PRAWA DOSTĘPU UŻYTKOWNIKA";
$owl_lang->owl_tar_path     		= "Ścieżka Do tar :";
$owl_lang->owl_title_custom             = "CUSTOMIZE BROWSER COLUMNS";
$owl_lang->owl_title_custom_search      = "CUSTOMIZE SEARCH RESULTS";
$owl_lang->owl_title_browser		= "OPCJE PRZEGLĄDARKI";
$owl_lang->owl_title_defaults   	= "PODSTAWOWE";
$owl_lang->owl_title_email		= "OPCJE EMAIL";
$owl_lang->owl_title_HD			= "OPCJE PLIKOW I PODGLĄDU DYSKU";
$owl_lang->owl_title_logging  		= "OPCJE LOGOWANIA";
$owl_lang->owl_title_other		= "OPCJE ŚCIEŻEK DOSTĘPU";
$owl_lang->owl_title_tools   		= "NRZĘDZIA BACKUPU/KOMPRESJI";
$owl_lang->owl_unzip_path     		= "Scieżka Do unzip :";
$owl_lang->owl_version_control		= "Kontrola Wersji:";
$owl_lang->quota			= "Quota 0=Wyłączone";
$owl_lang->reallydeluser                = "This user is owner of %numfiles% File(s) and %numfolders% Folder(s). These File(s) and Folder(s) will be orphaned. Is it Still Ok to Delete?";
$owl_lang->recs_per_page                = "Display Records Per Page (0 = Disabled):";
$owl_lang->remember_me_title            = "PERSISTENT LOGIN SETTINGS";
$owl_lang->remember_me                  = "Show the Remember Me link";
$owl_lang->remember_timeout             = "Cookie timeout in Days";
$owl_lang->remember_me_checkbox         = "Remember me";
$owl_lang->recycle_title		= "OPCJE KOSZA";
$owl_lang->recycle_enabled		= "Kosz Włączony:";
$owl_lang->recycle_location		= "Lokalizacja Kosza:";
$owl_lang->show_panel_title             = "Display Status Panel:";
$owl_lang->show_search_title            = "Display Search Bar:";
$owl_lang->show_pref_title              = "Display Pref/logout Bar:";
$owl_lang->show_bulk_title              = "Display Bulk Buttons:";
$owl_lang->show_action_title            = "Display action Buttons:";
$owl_lang->show_folder_title            = "Display Folder Tools:";
$owl_lang->show_panel                   = "Show";
$owl_lang->hide_panel                   = "Hide";
$owl_lang->status_bar_both              = "Góra I Dół";
$owl_lang->status_bar_bottom            = "Na Dole";
$owl_lang->status_bar_location          = "Lokalizacja Menu:";
$owl_lang->status_bar_top               = "U Góry";
$owl_lang->status_bar_not               = "Do Not Display";
$owl_lang->use_popup			= "Użyj Popup Do Wyświetlenia Wiadomości:";
$owl_lang->users           		= "Użytkownik";
$owl_lang->header_user_admin            = "User Administration";
$owl_lang->header_group_admin           = "Group Administration";
$owl_lang->header_sitefeatures_settings           = "Site Features and Settings";

//********************************************************
// admin/index.php  END
//********************************************************


//********************************************************
// admin/log.php  BEGIN
//********************************************************

$owl_lang->owl_log_viewer	= "Podgląd Logów";
$owl_lang->owl_log_hd_action	= "Akcja";
$owl_lang->owl_log_hd_file	= "Plik";
$owl_lang->owl_log_hd_fld_path	= "System";
$owl_lang->owl_log_hd_user	= "Użytkownik";
$owl_lang->owl_log_hd_dt_tm	= "Data ";
$owl_lang->owl_log_hd_ip	= "IP/Host";
$owl_lang->owl_log_hd_agent	= "Filtr";
$owl_lang->owl_log_hd_dtls	= "Szczegóły";
$owl_lang->owl_log_no_rec	= " NIC NIE ZNALEZIONO ";
$owl_lang->owl_log_hide      	= "Ukryj: ";
$owl_lang->owl_log_filter	= "Filtr";

//********************************************************
// admin/log.php  END
//********************************************************


//********************************************************
// admin/recycle.php  BEGIN
//********************************************************

$owl_lang->empty_trash          = "Opróżnij Kosz";
$owl_lang->really_empty_trash	= "Czy Napewno Chcesz Opróżnić Kosz?";
$owl_lang->recycle_bin_admin    = "Zarządzaj Koszem";

//********************************************************
// admin/recycle.php  END
//********************************************************


//********************************************************
// lib/owl.lib.php  BEGIN
//********************************************************

$owl_lang->file_size_byte		= "b";
$owl_lang->file_size_gigabyte		= "gb";
$owl_lang->file_size_kilobyte		= "kb";
$owl_lang->file_size_megabyte		= "mb";
$owl_lang->notif_subject_new 		= "Nowy Plik";
$owl_lang->notif_subject_upd 		= "Plik Został Zmieniony";
$owl_lang->notif_subject_monitor	= "Plik Lub Folder Który Monitorujesz Został Zmieniony";
$owl_lang->notif_subject_comment	= "Komentarz Do Pliku Został Dodany";
$owl_lang->notif_comment_1		= "Komentarz Włączony";
$owl_lang->notif_comment_2		= "Komentarz:";
$owl_lang->notif_msg         		= "TO JEST AUTOMATYCZNY EMAIL Z UPLOADU<BR><BR>Znajdż Nowy / Zmieniony Plik<BR><BR>";
$owl_lang->notif_msg_link               = "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet<BR><BR>Find a link to a new/updated file in this E-Mail<BR><BR>";
$owl_lang->notif_msg_alt_link           = "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet\n\nFind a link to a new/updated file in this E-Mail\n\n";
$owl_lang->notif_msg_alt         	= "TO JEST AUTOMATYCZNY EMAIL Z UPLOADU\n\nZnajdż / Zobacz Nowy Lub Zmieniony Istniejący Plik\n\n";
$owl_lang->notif_salutation		= "Droga";
$owl_lang->notif_user                   = "Created/Update by:";
$owl_lang->owl_path			= "Ścieżka Pliku: ";
$owl_lang->sessinuse			= "Ta Sesja Jest Uzywana Na Innym Komputerze Dostęp Zabroniony<BR>";
$owl_lang->invalidsess			= "Błędne ID Sesji Zaloguj Się Ponownie<BR>";
$owl_lang->sesstimeout			= "Twoja Sesja Wygasła Zaloguj Się Ponownie<BR>";
$owl_lang->everyoneread			= "Wszyscy: Odczyt/Zapis ";
$owl_lang->everyonewrite		= "Wszyscy: Odczyt/Zapis/Download ";
$owl_lang->everyonewrite_nod		= "Wszyscy: Odczyt/Zapis/Download, BEZ KASOWANIA";
$owl_lang->groupread			= "Twoja Grupa : Odczyt/Zapis ";
$owl_lang->groupwrite			= "Twoja Grupa : Odczyt/Zapis/Download";
$owl_lang->groupwrite_nod		= "Twoja Grupa : Odczyt/Zapis/Download, BEZ KASOWANIA";
$owl_lang->onlyyou			= "Tylko Ty: Odczyt/Zapis/Download";
$owl_lang->donothing                    = "Do nothing &#8211; Leave file permissions alone";
$owl_lang->groupwrite_worldread 	= "Twoja Grupa : Odczyt/Zapis/Download : Pozostali Użytkownicy Tylko Odczyt";
$owl_lang->groupwrite_worldread_nod 	= "Twoja Grupa : Odczyt/Zapis/Download, BEZ KASOWANIA : Pozostali Użytkownicy Odczyt";
$owl_lang->ggroupwrite_worldread 	= "Twoja Grupa : Odczyt/Zapis/Download/Kasowanie Folderu : Pozostali Użytkownicy Odczyt";
$owl_lang->ggroupwrite_worldread_nod 	= "Twoja Grupa : Zapis W Tym Folderze : Pozostali Użytkownicy Odczyt, BEZ KASOWANIA";
$owl_lang->everyoneread_ad		= "Wszyscy: Odczyt/Zapis";
$owl_lang->everyonewrite_ad		= "Wszyscy: Odczyt/Zapis/Download";
$owl_lang->everyonewrite_ad_nod		= "Wszyscy: Odczyt/Zapis/Download, BEZ KASOWANIA";
$owl_lang->groupread_ad			= "Wybrana Grupa : Odczyt/Zapis";
$owl_lang->groupwrite_ad		= "Wybrana Grupa : Odczyt/Zapis/Download";
$owl_lang->groupwrite_ad_nod		= "Wybrana Grupa : Odczyt/Zapis/Download, BEZ KASOWANIA";
$owl_lang->onlyyou_ad			= "Tylko Ty : Odczyt/Zapis/Download";
$owl_lang->groupwrite_worldread_ad 	= "Wybrana Grupa : Odczyt/Zapis/Download : Pozostali Użytkownicy Odczyt";
$owl_lang->groupwrite_worldread_ad_nod 	= "Wybrana Grupa : Odczyt/Zapis/Download, BEZ KASOWANIA : Pozostali Użytkownicy Odczyt";
$owl_lang->ggroupwrite_worldread_ad 	= "Wybrana Grupa : Odczyt/Zapis/Download/Kasowanie Folderu : Pozostali Użytkownicy Odczyt";
$owl_lang->ggroupwrite_worldread_ad_nod	= "Wybrana Grupa : Zapis W Tym Folderze : Pozostali Użytkownicy Odczyt, BEZ KASOWANIA";
$owl_lang->geveryoneread		= "Wszyscy : Przeglądanie Folderu";
$owl_lang->geveryonewrite		= "Wszyscy : Zapis I Usunięcie Folderu";
$owl_lang->geveryonewrite_nod		= "Wszyscy :Zapis W Tym Folderze";
$owl_lang->ggroupread			= "Twoja Grupa : Przeglądanie Folderu";
$owl_lang->ggroupwrite			= "Twoja Grupa : Zapis I Usunięcie Folderu";
$owl_lang->ggroupwrite_nod		= "Twoja Grupa : Zapis W Tym Folderze";
$owl_lang->gonlyyou			= "Tylko Ty : Zapis I Usunięcie Folderu";
$owl_lang->geveryoneread_ad		= "Wszyscy : Przeglądanie Folderu";
$owl_lang->geveryonewrite_ad		= "Wszyscy : Zapis I Usunięcie Folderu";
$owl_lang->geveryonewrite_ad_nod	= "Wszyscy : Zapis W Tym Folderze";
$owl_lang->ggroupread_ad		= "Wybrana Grupa : Przeglądanie Folderu";
$owl_lang->ggroupwrite_ad    		= "Wybrana Grupa : Zapis I Usunięcie Folderu";
$owl_lang->ggroupwrite_ad_nod		= "Wybrana Grupa : Zapis W Tym Folderze";
$owl_lang->gonlyyou_ad			= "Tylko Ty : Zapis I Usunięcie Folderu";
$owl_lang->orphaned                     = "&#8211; NO Owner  &#8211;";
$owl_lang->virus_infected               = "VIRUS INFECTED FILE";
$owl_lang->virus_return_val             = "Virus Program Return value:";

//********************************************************
// lib/owl.lib.php  END
//********************************************************


//********************************************************
// HREF TITLE messages  BEGIN
//********************************************************

$owl_lang->title_browse_folder     	= "Przeglądaj Ten Folder";
$owl_lang->title_browse_site     	= "Przeglądaj Ten URL";
$owl_lang->title_download_view     	= "Sciągnij / Podejrzyj Plik";
$owl_lang->title_edit_prefs     	= "Pokaż / Edytuj Preferencje Użytkownika";
$owl_lang->title_return_folder     	= "Wróć Do";
$owl_lang->title_sort     		= "Wedłóg";
$owl_lang->title_view_new     		= "Pokaż Listę Nowych Plików Od Czasu Mojej Ostatniej Wizyty";
$owl_lang->title_view_updated     	= "Pokaż Listę Zmienionych Plików Od Czasu Mojej Ostatniej Wizyty";
$owl_lang->title_view_my     		= "Pokaż Moje Pliki";

//********************************************************
// HREF TITLE messages  END
//********************************************************


//********************************************************
// admin/news.php and newsread.php BEGIN
//********************************************************

$owl_lang->news_title			= "Administracja Newsami";
$owl_lang->news_hd			= "Wiadomości";
$owl_lang->news_hd_created		= "Utwórz W";
$owl_lang->news_hd_expires		= "Wyślij : Dzień/Godzina";
$owl_lang->news_hd_audience		= "Odbiorca Docelowy";
$owl_lang->news_heading			= "Nagłówek Wiadomości";
$owl_lang->news_content			= "Zawartość";
$owl_lang->news_posted_date		= "Dodaj Wiadomość:";
$owl_lang->news_read			= "Czytaj";

//********************************************************
// admin/news.php and newsread.php  END
//********************************************************


//********************************************************
// DEBUG MESSAGES BEGIN
//********************************************************

$owl_lang->debug_tmp_not_exists		= "DEBUG: The OWL temporary Directory: $default->owl_tmpdir does not exists.";
$owl_lang->debug_tmp_not_writeable	= "DEBUG: The OWL temporary Directory: $default->owl_tmpdir is not writeable.";
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

$owl_lang->owl_stats_viewer	= "Podgląd Statystyk";
$owl_lang->stats_files		= "Ilość Plików Użytkownika";
$owl_lang->stats_folders	= "Ilość Folderów Użytkownika";
$owl_lang->stats_top		= "20 Najczęśćiej Ściągnych Plików";
$owl_lang->stats_users          = "USER Signon (Login / Failure / Logout)";
$owl_lang->stats_users_loggedin = "Currently Logged In";
$owl_lang->stats_information	= "Logowanie Musi Być Włączone By Wyświetlić Logi";

//********************************************************
// admin/stats.php END
//********************************************************

//********************************************************
// admin/doctype.php BEGIN
//********************************************************

$owl_lang->document_type        = "Document Type";
$owl_lang->document_type_name   = "Document Type Name";
$owl_lang->doc_field_name       = "Field Name";
$owl_lang->doc_field_pos        = "Field Pos";
$owl_lang->doc_field_label      = "Field Label (Per Locale)";
$owl_lang->doc_field_size       = "Field Size";
$owl_lang->doc_field_searchable = "Searchable?";
$owl_lang->doc_field_required   = "Required?";
$owl_lang->doc_new_doc_type     = "&#8212; ADD New Document Type &#8212;";
$owl_lang->doc_specific         = "DOCUMENT SPECIFIC FIELDS:";
$owl_lang->doc_administration   = "Document Type Admininstration";

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
