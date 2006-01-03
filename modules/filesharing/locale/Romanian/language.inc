<?php

/*

  File: Romanian/language.inc
  Author: nelu-language.inc/eacxx-buttons
  Date: 2004/10/20

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
// Date Formating END
//********************************************************


//********************************************************
// Error Messages BEGIN
//********************************************************

$owl_lang->err_select_reviewer          = "Please select at least one Person to review your document";
$owl_lang->err_adding_comments		= "Nu aveti permisiunea sa adaugati comentarii la acest fisier"; 
$owl_lang->err_comment_empty            = "Comment cannot be empty";
$owl_lang->err_backup_file			= "Eroare la salvarea fisierului existent"; 
$owl_lang->err_backup_folder_create	= "Eroare la crearea folder-ului de salvare"; 
$owl_lang->err_bad_url				= "Va rog introduceti un URL corect"; 
$owl_lang->err_bad_version_1		= "OWL Intranet necesita PHP minim Versiubea"; 
$owl_lang->err_bad_version_2		= "Rulati Versiunea"; 
$owl_lang->err_bad_version_3		= "Instalati o versiune mai noua de PHP si incercati din nou"; 
$owl_lang->err_email				= "Mesajul nu a putut fi transmis"; 
$owl_lang->err_email_required		= "Cimpul Email este necesar"; 
$owl_lang->err_fexist1				= "<b>Fisierul exista:</b>"; 
$owl_lang->err_fexist2				= "Exista deja un fisier cu numele <i>"; 
$owl_lang->err_fexist3				= "</i> in acest folder"; 
$owl_lang->err_file_exists			= "Fisierul pe care incercati sa il salvati pe server exista deja"; 
$owl_lang->err_fileexists			= "Mutarea a fost anulata<BR>Un fisier cu acelasi nume exista deja"; 
$owl_lang->err_file_lock			= "Nu puteti bloca acest fisier, este retinut de"; 
$owl_lang->err_update_file_lock         = "You cannot update this file, it is currently held by";
$owl_lang->err_filemove_exist		= "Numele de fisier cu care incercati sa redenumiti acest fisier exista deja"; 
$owl_lang->err_file_not_exist		= "Fisierul nu exista pe server"; 
$owl_lang->err_file_too_big			= "Variabila upload_max_filesize este depasita si/sau variabila Owl Max Upload file size este depasita"; 
$owl_lang->err_file_update			= "La actualizarea unui fisier, numele trebuie sa ramina acelasi, va rugan sa incercati din nou folosind acelasi nume de fisier"; 
$owl_lang->err_folder_create		= "Eroare la crearea folder-ului"; 
$owl_lang->err_folder_exist			= "Acest folder exista deja"; 
$owl_lang->err_folderexists			= "Redenumirea a fost anulata<BR>Un folder cu acelasi nume exista deja."; 
$owl_lang->err_general				= "A aparut o eroare"; 
$owl_lang->err_group_delete			= "Nu puteti sterge un grup care are membri"; 
$owl_lang->err_group_exists			= "Exista deja un grup cu acest nume"; 
$owl_lang->err_gzip_not_found		= "gzip nu a fost gasit in "; 
$owl_lang->err_login				= "Autentificati-va pentru a face aceasta actiune"; 
$owl_lang->err_movecancel			= "Mutarea a fost anulata<BR>"; 
$owl_lang->err_nameempty			= "Numele de fisier nu poate fi vid"; 
$owl_lang->err_news_required		= "EROARE: Antetul si continutul strilor sunt necesare"; 
$owl_lang->err_no_access			= "Nu aveti acces la nici unul din fisierele selectate"; 
$owl_lang->err_no_access_info           = "Possible causes: <br></br>1) You did not click any checkbox in front of a File or Folder<br></br>2) Bulk Delete, Bulk Email, Bulk Checkout do not apply to Folders<br></br>3) You do not have access to any of the files or folders you have selected.";
$owl_lang->err_noemail				= "Nu aveti dreptul sa trimiteti acest fisier prin email"; 
$owl_lang->err_nofileaccess			= "Nu aveti acces la acest fisier"; 
$owl_lang->err_nofiledelete			= "Nu aveti dreptul sa stergegi acest fisier"; 
$owl_lang->err_nofilemod			= "Nu aveti dreptul sa modificati acest fisier"; 
$owl_lang->err_nofolderaccess		= "Nu aveti acces la acest folder"; 
$owl_lang->err_nofolderdelete		= "Nu aveti dreptul sa stergeti acest folder"; 
$owl_lang->err_nofoldermod			= "Nu aveti dreptul sa modificati acest folder"; 
$owl_lang->err_nosubfolder			= "Nu aveti dreptul sa creati foldere aici"; 
$owl_lang->err_note_title			= "Cimpul de titlu este necesar"; 
$owl_lang->err_note_title_exists	= "Exista deja o nota cu acest nume"; 
$owl_lang->err_noupload				= "Nu aveti dreptul sa puneti fisiere in acest folder"; 
$owl_lang->err_pass_missmatch		= "Parola Noua si Confirmare Parola nu se potrivesc"; 
$owl_lang->err_pass_wrong    		= "Parola veche este gresita"; 
$owl_lang->err_pod2html_not_found	= "ERROR: Modulul pod2html nu a fost gasit:"; 
$owl_lang->err_quota				= "Nu aveti alocat destul spatiu pentru a pune acest fisier pe server"; 
$owl_lang->err_quota_needed			= " necesar "; 
$owl_lang->err_quota_avail			= " disponibil(e)."; 
$owl_lang->err_quota_exceed			= "Ati depasit alocarea"; 
$owl_lang->err_req					= "EROARE: Toate cimpurile sunt necesare"; 
$owl_lang->err_root_delete			= "Folderul radacina nu poate fi sters"; 
$owl_lang->err_sess_notvalid		= "Id sesiune invalid"; 
$owl_lang->err_sess_write			= "Eroare la scrierea informatiilor sesiunii in baza de date"; 
$owl_lang->err_specialfoldername	= "'backup' este un nume de folder rezervat de Owl, alegeti alt nume"; 
$owl_lang->err_tar_not_found		= "tar nu a fost gasit in "; 
$owl_lang->err_trash_can_empty		= "Cosul de gunoi este gol"; 
$owl_lang->err_unauth_area			= "Nu sunteti autorizat in aceasta zona"; 
$owl_lang->err_unauthorized			= "Neautorizat"; 
$owl_lang->err_upload				= "Eroare la punerea fisierului pe server"; 
$owl_lang->err_user_exists			= "Numele de utilizator exista"; 
$owl_lang->err_cant_del_doc_type	= "Nu pot sterge, exista fisiere ce utilizeaza acest tip de document"; 
$owl_lang->err_doc_type_name_req	= "Nume Tip Fisier este necesar"; 
$owl_lang->err_field_name_req		= "Nume Fisier este necesar <BR>"; 
$owl_lang->err_doc_field_req		= "Lipseste cimpul necesar:"; 
$owl_lang->err_field_label_req		= "Eticheta Cimp este necesar <BR>"; 
$owl_lang->err_field_size_req		= "Marime Cimp este necesar <BR>"; 
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
$owl_lang->alt_add_comments		= "Adauga un comentariu la acest fisier"; 
$owl_lang->alt_btn_add_file		= "Pune pe server un fisier nou"; 
$owl_lang->alt_btn_add_folder	= "Creaza un folder nou"; 
$owl_lang->alt_add_group		= "Creaza acest grup"; 
$owl_lang->alt_add_news			= "Adauga o stire noua"; 
$owl_lang->alt_btn_add_note		= "Adauga o nota noua"; 
$owl_lang->alt_add_user			= "Creaza acest user"; 
$owl_lang->alt_btn_add_url		= "Creaza o legatura WEB noua"; 
$owl_lang->alt_cancel			= "Anuleaza aceasta actiune"; 
$owl_lang->alt_cancel_move		= "Anuleaza actiunea de mutare"; 
$owl_lang->alt_change			= "Actualizeaza aceasta inregistrare"; 
$owl_lang->alt_btn_clickhere	= "Clic aici"; 
$owl_lang->alt_btn_collapse_view= "Comuta in Vedere Redusa"; 
$owl_lang->alt_comments			= "Exista comentarii pentru acest fisier"; 
$owl_lang->alt_del_comments		= "Sterge acest comentariu"; 
$owl_lang->alt_del_file			= "Sterge fisierul (D/N)"; 
$owl_lang->alt_del_folder		= "Sterge folderul (D/N)"; 
$owl_lang->alt_del_group		= "Sterge acest grup"; 
$owl_lang->alt_del_news			= "Sterge acesta stire"; 
$owl_lang->alt_del_selected		= "Sterge toate fisierele selectate"; 
$owl_lang->alt_del_all          = "Empty Trash";
$owl_lang->alt_rest_selected    = "Restore all Selected Files";
$owl_lang->alt_del_this_folder	= "Sterge folder &#8211; "; 
$owl_lang->alt_del_user			= "Sterge acest user"; 
$owl_lang->alt_edit_group		= "Editeaza grupul selectat"; 
$owl_lang->alt_edit_news		= "Editeaza aceasta stire"; 
$owl_lang->alt_edit_user		= "Editeaza userul selectat"; 
$owl_lang->alt_email			= "Trimite prin email acest fisier"; 
$owl_lang->alt_email_selected	= "Trimite prin email toate fisierele selectate"; 
$owl_lang->alt_btn_expand_view	= "Comuta in Vedere Extinsa"; 
$owl_lang->alt_admin_flush		= "Reseteaza sesiunile intepenite/expirate"; 
$owl_lang->alt_get_file			= "Copie de pe server fisierul";
$owl_lang->alt_get_folder       = "Download Folder Content";
$owl_lang->alt_have_news		= "Aveti stiri de vizualizat"; 
$owl_lang->alt_have_no_news		= "Nu aveti stiri noi de vizualizat"; 
$owl_lang->alt_home_folder		= "Inapoi la folderul initial "; 
$owl_lang->alt_set_initial_dir	= "Seteaza folderul curent ca Initial"; 
$owl_lang->alt_site_map			= "Harta site"; 
$owl_lang->alt_lock_file		= "Blocheaza fisierul"; 
$owl_lang->alt_log_clear		= "Sterge toate log-urile (D/N)"; 
$owl_lang->alt_log_file			= "Log fisierre"; 
$owl_lang->alt_log_next			= "Afiseaza inregistrarea urmatoare"; 
$owl_lang->alt_log_prev			= "Afiseaza inregistrarea precedenta"; 
$owl_lang->alt_log_top			= "Salt la prima inregistrare"; 
$owl_lang->alt_btn_login		= "Autentificare in Owl Intranet"; 
$owl_lang->alt_btn_logout		= "Deconectare de la Owl Intranet"; 
$owl_lang->alt_btn_help         = "Owl Online Help";
$owl_lang->alt_mod_file			= "Modificare proprietati fisier"; 
$owl_lang->alt_mod_folder		= "Modificare proprietati folder"; 
$owl_lang->alt_move_file		= "Mutare fisier"; 
$owl_lang->alt_copy_file        = "Copy File";
$owl_lang->alt_link_file        = "Link This File to Another Directory";
$owl_lang->alt_move_folder		= "Mutare folder"; 
$owl_lang->alt_copy_folder      = "Copy Folder";
$owl_lang->alt_move_selected	= "Mutare fisiere selectate"; 
$owl_lang->alt_admin_groups		= "Creare grup nou"; 
$owl_lang->alt_news_close		= "Inchide fereastra de stiri"; 
$owl_lang->alt_news_next		= "Afiseaza stirea urmatoare"; 
$owl_lang->alt_news_prev		= "Afiseaza stirea precedenta"; 
$owl_lang->alt_news_print		= "Imprima aceasta stire"; 
$owl_lang->alt_admin_users		= "Creare utilizator nou"; 
$owl_lang->alt_monitor			= "Urmareste acest fisier"; 
$owl_lang->alt_monitored		= "Opreste urmarirea acestui fisier"; 
$owl_lang->alt_btn_admin		= "Administrare Owl"; 
$owl_lang->alt_play_file		= "Ruleaza fisier media"; 
$owl_lang->alt_recycle			= "Cosul dumneavoastra este gol"; 
$owl_lang->alt_recycle_disable	= "Cosul de gunoi a fost inhibat"; 
$owl_lang->alt_recycle_not_found= "Locatia cosului nu a fost gasita"; 
$owl_lang->alt_refresh_filter	= "Initiere filtru / Reimprospatare rezultate"; 
$owl_lang->alt_register			= "Trimiteri inregistrarea dumneavoastra"; 
$owl_lang->alt_btn_browse		= "Intoarcere la navigatorul de fisiere"; 
$owl_lang->alt_search			= "Initializati cautarea"; 
$owl_lang->alt_send_email		= "Trimiteti email-ul"; 
$owl_lang->alt_sendfile			= "Trimiteti fisierul"; 
$owl_lang->alt_toggle_check_box	= "Comuta casetele de selectie"; 
$owl_lang->alt_unlock_file      = "Deblocheaza fisierul"; 
$owl_lang->alt_upd_file      	= "Actualizeaza fisierul"; 
$owl_lang->alt_view_comments    = "Adauga / vizualizeaza comentarii fisier"; 
$owl_lang->alt_view_file     	= "Vedeti fisier"; 
$owl_lang->alt_edit_field		= "Editati definirea cimpului"; 
$owl_lang->alt_del_field		= "Sterge acest cimp"; 
$owl_lang->alt_add_field		= "Adauga cimpul deasupra"; 
$owl_lang->alt_deldoctype		= "Sterge tipul de document curent"; 
$owl_lang->alt_upd_field		= "Actualizeaza acest cimp"; 
$owl_lang->alt_new_doctype		= "Creaza un tip nou de document"; 
$owl_lang->alt_related          = "Find Releated Documents";
$owl_lang->alt_back             = "Return To Previous Screen";
$owl_lang->alt_submit           = "Submit Form";

//********************************************************
// Image Alternate popup Messages END
//********************************************************


//********************************************************
// Owl Logging messages BEGIN
//********************************************************

$owl_lang->log_del_det			= "Tot continutul a fost deasemenea sters"; 
$owl_lang->log_detail			= "Fara detalii aditionale"; 
$owl_lang->log_file_to			= "CATRE: "; 
$owl_lang->log_filter_all		= "TOATE"; 
$owl_lang->log_login_det		= "Nume Utilizator: "; 
$log_file_actions[1]        	= "AUTENTIFICARE"; 
$log_file_actions[2]        	= "AUTENTIFICARE GRESITA"; 
$log_file_actions[3]        	= "DECONECTARE"; 
$log_file_actions[4]        	= "FISIER STERS"; 
$log_file_actions[5]        	= "FISIER COPIAT PE SERVER"; 
$log_file_actions[6]        	= "FISIER ACTUALIZAT"; 
$log_file_actions[7]        	= "FISIER COPIAT DE PE SERVER"; 
$log_file_actions[8]        	= "FISIER SCHIMBAT"; 
$log_file_actions[9]        	= "FISIER BLOCAT"; 
$log_file_actions[10]        	= "FISIER DEBLOCAT"; 
$log_file_actions[11]        	= "FISIER TRIMIS PRIN EMAIL"; 
$log_file_actions[12]        	= "FISIER MUTAT"; 
$log_file_actions[13]        	= "FOLDER CREAT"; 
$log_file_actions[14]        	= "FOLDER STERS"; 
$log_file_actions[15]        	= "FOLDER MODIFICAT"; 
$log_file_actions[16]        	= "FOLDER MUTAT"; 
$log_file_actions[17]        	= "PAROLA UITATA"; 
$log_file_actions[18]        	= "INREGISTRARE UTILIZATOR"; 
$log_file_actions[19]           = "FISIER VAZUT"; 
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

$owl_lang->anonymous		= "(Acces Anonim)"; 
$owl_lang->repository_list      = "Repository:";
$owl_lang->engine			= "Owl Intranet Engine";
$owl_lang->forgot_pass		= "Parola uitata?"; 
$owl_lang->like_register	= "Doriti sa va inregistrati"; 
$owl_lang->login			= "Autentificare"; 
$owl_lang->loginfail		= "Autentificare gresita"; 
$owl_lang->logindisabled	= "Contul a fost DEZACTIVAT, contactati Administratorul de Sistem"; 
$owl_lang->password			= "Parola"; 
$owl_lang->successlogout	= "V-ati deconectat cu succes"; 
$owl_lang->toomanysessions	= "Numarul maxim de sesiuni/utilizator depasit, contactati Administratorul de Sistem"; 
$owl_lang->username			= "Nume Utilizator"; 
$owl_lang->version			= "Version";

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
$owl_lang->actions					= "Actiuni"; 
$owl_lang->del_selected				= "Sterge Selectia"; 
$owl_lang->del_all                      = "Empty Trash";
$owl_lang->rest_selected                = "Restore Selected";
$owl_lang->disk_quota				= "Cota Disk"; 
$owl_lang->email_selected			= "Trimite Selectia prin Email"; 
$owl_lang->file						= "Fisier"; 
$owl_lang->folder_policy			= "Reguli Folder Curent"; 
$owl_lang->current_folder               = "Current Folder:";
$owl_lang->held						= "Retinut"; 
$owl_lang->last_logged				= "Ultimul in: "; 
$owl_lang->current_db                   = "Current Repository:";
$owl_lang->modified 				= "Modificat"; 
$owl_lang->move_selected			= "Mutare Selectie"; 
$owl_lang->new_file					= "Nou"; 
$owl_lang->no_description			= "Descriere indisponibila"; 
$owl_lang->page						= "Pagina:"; 
$owl_lang->postedby 				= "Pus de"; 
$owl_lang->reallydelete				= "Sigur stergeti"; 
$owl_lang->reallydelete_logs		= "Sigur goliti fisierul de log"; 
$owl_lang->reallydelete_selected	= "Sigur stergeti toate fisierele selectate"; 
$owl_lang->reallyrestore_selected       = "Really Restore all selected files";
$owl_lang->size						= "Marime"; 
$owl_lang->score                        = "Score";
$owl_lang->title					= "Titlu"; 
$owl_lang->doc_number                   = "Doc #";
$owl_lang->tot_files				= "Total:"; 
$owl_lang->tot_my_checked_out		= "Blocate:"; 
$owl_lang->tot_my_files				= "Proprii:"; 
$owl_lang->tot_my_group				= "In grup:"; 
$owl_lang->tot_new_files			= "Noi:"; 
$owl_lang->tot_updated_files		= "Actualizate:"; 
$owl_lang->tot_monitored                = "Monitored:";
$owl_lang->updated_file				= "Actualizat!"; 
$owl_lang->user						= "Utilizator"; 
$owl_lang->ver						= "Ver."; 
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
$owl_lang->adding_comments		= "Adaugare / Vizualizare Comentarii: "; 
$owl_lang->comments             = "Comment";
$owl_lang->post_comment         = "Post Comment";
$owl_lang->addingfile			= "Adaugare un fisier in "; 
$owl_lang->addingfolder			= "Adaugare un folder in"; 
$owl_lang->attach_file			= "Ataseaza Fisier"; 
$owl_lang->change				= "Modifica"; 
$owl_lang->create				= "Creaza"; 
$owl_lang->comments_added		= "Comentarii adaugate de:"; 
$owl_lang->description			= "Descriere"; 
$owl_lang->email_body			= "Mesaj"; 
$owl_lang->email_cc				= "CC";
$owl_lang->email_reply_to		= "Adresa Raspuns"; 
$owl_lang->email_subject		= "Subiect"; 
$owl_lang->email_to				= "Trimite catre"; 
$owl_lang->emailing				= "Se trimite"; 
$owl_lang->disp_mp3				= "MP3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cintec:<BR>Album:<BR>Bitrate&nbsp;-&nbsp;Samplerate:<BR>Durata:<BR>Gen:<BR>Commentarii:"; 
$owl_lang->keywords				= "Cuvinte cheie"; 
$owl_lang->modify_url			= "URL";
$owl_lang->modifying			= "Se modifica"; 
$owl_lang->name					= "Nume"; 
$owl_lang->notify_link			= "Legaturi externe Owl"; 
$owl_lang->note_content			= "Continut Nota"; 
$owl_lang->ownergroup			= "Proprietar (Grup)"; 
$owl_lang->ownership			= "Proprietar (Utilizator)"; 
$owl_lang->permissions			= "Permisiuni"; 
$owl_lang->prop_permissions		= "Se propaga permisiunila la subfoldere?"; 
$owl_lang->prop_perms_files		= "Permisiuni de propagat la fisiere:"; 
$owl_lang->policy				= "Reguli"; 
$owl_lang->pick_select			= "&#8212; Selecteaza un utilizator Owl &#8212;"; 
$owl_lang->sendfile				= "Trimite Fisierul"; 
$owl_lang->sendthisfile			= "Trimite acest fisier"; 
$owl_lang->sendthisurl			= "Trimite acest URL"; 
$owl_lang->updating				= "Se actualizeaza"; 
$owl_lang->verdescription		= "Descrierea<br></br>schimbarilor"; 
$owl_lang->vermajor				= "Revizie Majora"; 
$owl_lang->verminor				= "Revizie Minora"; 
$owl_lang->vertype				= "Tip revizie"; 

//********************************************************
// modify.php  END
//********************************************************


//********************************************************
// register.php  BEGIN
//********************************************************

$owl_lang->email			= "Adresa Email"; 
$owl_lang->full_name		= "Nume Complet"; 
$owl_lang->register			= "Inregistrare utilizator"; 
$owl_lang->self_failed		= "Eroare"; 
$owl_lang->self_passwd		= "Parola Trimisa la:"; 
$owl_lang->self_reg_bod		= "Parola dumneavoastra Owl este:"; 
$owl_lang->self_reg_rset	= "Parola dumneavoastra Owl a fost modificata la:"; 
$owl_lang->self_reg_subj	= "Contul dumneavoastra Owl"; 
$owl_lang->send_pass		= "Trimite Parola"; 
$owl_lang->submit			= "Inregistrare"; 
$owl_lang->thank_you_1		= "Multumesc"; 
$owl_lang->thank_you_2		= "Un email va fi trimis catre adresa dumneavoastra de email <BR> si va contine NOUA parola pentru <BR><b>UTILIZATORUL:</b>"; 

//********************************************************
// register.php  END
//********************************************************


//********************************************************
// move.php  BEGIN
//********************************************************

$owl_lang->cancel_button	= "Renunta"; 
$owl_lang->moving			= "Se muta"; 
$owl_lang->moving_file          = "Moving file";
$owl_lang->moving_folder        = "Moving Folder";
$owl_lang->copy_file            = "Copying file";
$owl_lang->copy_folder          = "Copying Folder";
$owl_lang->select			= "Selectati va rog noul folder:"; 

//********************************************************
// move.php  END
//********************************************************


//********************************************************
// log.php  BEGIN
//********************************************************

$owl_lang->viewlog	= "Vizualizare log-ul pentru"; 

//********************************************************
// log.php  END
//********************************************************


//********************************************************
// prefs.php  BEGIN
//********************************************************

$owl_lang->confpassword	= "Confirmati Noua Parola"; 
$owl_lang->comment_notif= "Semnalare Comentarii"; 
$owl_lang->email_tool   = "E-Mail Tool";
$owl_lang->last_modified= "Last Modified";
$owl_lang->group		= "Grup Primar"; 
$owl_lang->groupmember	= "Membru al Grupurilor"; 
$owl_lang->newpassword	= "Parola Noua"; 
$owl_lang->newsadmin	= "Administrator Stiri"; 
$owl_lang->not_member	= "Nu sunteti membru la nici un alt grup"; 
$owl_lang->notification	= "Primeste Notificari"; 
$owl_lang->oldpassword	= "Parola Veche"; 
$owl_lang->preference	= "Preferinte"; 
$owl_lang->saved		= "Schimbari salvate"; 
$owl_lang->status_no	= "NU"; 
$owl_lang->status_yes	= "DA"; 
$owl_lang->userlang		= "Limba"; 

//********************************************************
// prefs.php  END
//********************************************************


//********************************************************
// search.php  BEGIN
//********************************************************

$owl_lang->elapsed_time			= "timp trecut"; 
$owl_lang->search				= "Cautare"; 
$owl_lang->search_any_word		= "Orice cuvint"; 
$owl_lang->search_all_word		= "Toate cuvintele"; 
$owl_lang->search_entire_phrase	= "Fraza intreaga"; 
$owl_lang->search_match			= "Potrivire:"; 
$owl_lang->search_currentfolder = "Cauta in folderul curent"; 
$owl_lang->search_for_folders 	= "Cauta foldere"; 
$owl_lang->search_for_files 	= "Cauta fisiere"; 
$owl_lang->search_score			= "Marcare fisiere"; 
$owl_lang->search_results_for	= "Rezultat cautare dupa"; 
$owl_lang->search_winthindocs   = "Cautare in (text, pdf & MS-Word) documente"; 
$owl_lang->related_query_empty  = "No metadata associated with document to perform 'Search Related'";
$owl_lang->query_empty       	= "Goleste sirul de cautare"; 

//********************************************************
// search.php  END
//********************************************************


//********************************************************
// view.php  BEGIN
//********************************************************

$owl_lang->viewing	= "Se vizualizeaza"; 

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
$owl_lang->add							= "Adauga"; 
$owl_lang->anonymous_account			= "Cont Acces Anonim:"; 
$owl_lang->buttonstyle					= "Stil Butoane"; 
$owl_lang->deletegroup					= "Sterge Grup"; 
$owl_lang->deleteuser					= "Sterge Utilizator"; 
$owl_lang->disableuser					= "Dezactiveaza Utilizator"; 
$owl_lang->disable_recs_per_page		= "Activarea Vizualizarii Restrinse va DEZACTIVA Inregistari pe Pagina"; 
$owl_lang->file_admin_group				= "Grup administrare OWL"; 
$owl_lang->flushed           			= "Tabela sesiuni resetata, utilizatorul se poate autentifica.<BR>"; 
$owl_lang->groups						= "Grupuri"; 
$owl_lang->hide_bulk_buttons			= "Ascunde butoane manipulare pachete fisiere:"; 
// Edit HTML Properties Messages BEGIN
$owl_lang->ht_tbl_border_sz 			= "Marime bordura tabel"; 
$owl_lang->ht_tbl_hd_bg					= "Fundal antet:"; 
$owl_lang->ht_tbl_cell_bg_cl 			= "Culoare fundal celule tabel:"; 
$owl_lang->ht_tbl_cell_bg_al 			= "Culoare alternativa fundal celule tabel"; 
$owl_lang->ht_expand_width				= "Latime Vedere Extinsa:"; 
$owl_lang->ht_collapse_width 			= "Latime Vedere Restrinsa:"; 
$owl_lang->ht_bd_bg_image				= "Cale imagine fundal pagina"; 
$owl_lang->ht_bd_txt_cl 				= "Culoare text:"; 
$owl_lang->ht_bd_lnk_cl					= "Culoare legaturi:"; 
$owl_lang->ht_bd_vlnk_cl 				= "Culoare legaturi vizitate:"; 
// Edit Prefs Properties Messages END
$owl_lang->home_dir						= "Folder radacina utilizator"; 
$owl_lang->initial_dir                  = "User's Initial Directory";
$owl_lang->maxsessions					= "Nr. maxim de sesiuni"; 
$owl_lang->noprefaccess					= "Dezactiveaza preferinte"; 
$owl_lang->owl_anon_full                = "Full Access";
$owl_lang->owl_anon_ro					= "Seteaza Anonimul numai in citire:"; 
$owl_lang->owl_anon_download            = "Download Only";
$owl_lang->anonymous_access             = "Set Anonymous Access";
$owl_lang->owl_dbdump_path   			= "Cale modul DB Dump:"; 
$owl_lang->owl_def_file_group_owner		= "Grup Propietar Fisier Implicit:"; 
$owl_lang->owl_def_file_meta			= "Fisier Meta Data Implicit:"; 
$owl_lang->owl_def_file_owner			= "Proprietar Fisier Implicit:"; 
$owl_lang->owl_def_file_perm 			= "Regula implicita la creare fisier:"; 
$owl_lang->owl_def_file_security		= "Securitati implicite fisier:"; 
$owl_lang->owl_def_file_title			= "Titlu Fisier Implicit (Nimic pentru Nume Fisier):"; 
$owl_lang->owl_def_fold_group_owner		= "Grup Proprietar Folder Implicit"; 
$owl_lang->owl_def_fold_owner			= "Proprietar Folder Implicit:"; 
$owl_lang->owl_def_fold_sec				= "Securitati implicite folder"; 
$owl_lang->owl_def_folder_perm 			= "Regula implicita la creare folder"; 
$owl_lang->owl_default_tmpdir			= "Locatie foldet fisiere temporare: "; 
$owl_lang->owl_email_from				= "Adresa Expeditor / Autorizare SMTP:"; 
$owl_lang->owl_email_fromname			= "Nume Expeditor:"; 
$owl_lang->owl_email_replyto			= "Adresa Raspuns:"; 
$owl_lang->owl_email_server				= "Server SMTP:"; 
$owl_lang->owl_email_smtp				= "Trimite Email via SMTP"; 
$owl_lang->owl_email_smtp_auth			= "Utilizeaza autentificare SMTP"; 
$owl_lang->owl_email_smtp_auth_login    = "SMTP Auth Login:";
$owl_lang->owl_email_smtp_auth_passwd	= "Parola autentificare SMTP"; 
$owl_lang->owl_email_subject_pref	= "Prefix Subiect:"; 
$owl_lang->owl_fogotpass		= "Afiseaza link-ul Parola Uitata:"; 
$owl_lang->owl_group_user		= "Utilizatorii care sunt membrii acestui grup"; 
$owl_lang->owl_gzip_path     		= "Cale gzip:"; 
$owl_lang->owl_hidebackup		= "Ascunde folderele de salvare versiuni:"; 
$owl_lang->owl_log_file			= "Scrie istoricul operatiilor:"; 
$owl_lang->owl_log_login_act		= "Scrie istoricul operatiilor de autentificare/deconectare:"; 
$owl_lang->owl_log_rec_page		= "Numar inregistrari pe pagina vizualizare istoric:"; 
$owl_lang->owl_logging			= "Activeaza scrierea istoricului:"; 
$owl_lang->owl_logo			= "Login Page logo ([Language]/graphics):";
$owl_lang->owl_lookAtHD			= "Dezactiveaza Look at hd.:"; 
$owl_lang->owl_lookAtHDDel		= "Inlatura fisierele sterse din DB:"; 
$owl_lang->hide_folder_doc_count        = "Hide Folder File Type Count";                                                                                                                        
$owl_lang->hide_folder_size             = "Hide Folder Content Size";
$owl_lang->old_action_icons             = "Use pre Owl 0.80 Action Icons";
$owl_lang->search_result_folders        = "Include Folders in Search Results";
$owl_lang->restore_file_prefix          = "String Prefixed to Restored Files";
$owl_lang->owl_max_filesize		= "Marime maxima fisier salvat pe server:"; 
$owl_lang->owl_owl_expand		= "Vizualizare implicita (Extinsa):"; 
$owl_lang->owl_owl_timeout		= "Timp expirate sesiune (Secunde)"; 
$owl_lang->virus_path                   = "Virus Checking Software Path<br />Example: '/usr/bin/clamscan --quiet' <br />&#8211; Blank for Disabled:";
$owl_lang->owl_pdftotext_path		= "Intretine Index cautare<br></br>pentru fisiere PDF si text<br></br>&#8211; Nimic pentru inhibare"; 
$owl_lang->owl_wordtotext_path          = "Fisiere MS-WORD <BR>&#8211; Nimic pentru inhibare"; 
$owl_lang->owl_pod2html_path            = "Este necesar Perl 5.8.0 sau mai nou<br></br> Cale catre pod2html:"; 
$owl_lang->owl_restrict_view		= "Activeaza caracteristica Vizualizare Restrictiva:"; 
$owl_lang->owl_self_reg			= "Activeaza Autoinregistrarea:"; 
$owl_lang->owl_self_reg_hd		= "CARACTERISTICI IMPLICITE UTILIZATOR AUTOINREGISTRAT"; 
$owl_lang->owl_tar_path			= "Cale tar:"; 
$owl_lang->owl_title_custom             = "CUSTOMIZE BROWSER COLUMNS";
$owl_lang->owl_title_custom_search      = "CUSTOMIZE SEARCH RESULTS";
$owl_lang->owl_title_browser		= "CARACTERISTICI MANAGER FISIERE OWL"; 
$owl_lang->owl_title_defaults		= "IMPLICITE"; 
$owl_lang->owl_title_email		= "OWL - Setari email"; 
$owl_lang->owl_title_HD			= "UITA-TE LA HD PENTRU SETARILE NOILOR FISIERE"; 
$owl_lang->owl_title_logging		= "SETARI INREGISTRARE ISTORIC"; 
$owl_lang->owl_title_other		= "ALTE SETARI"; 
$owl_lang->owl_title_tools		= "UTILITARE SALVARE DB/GZIP"; 
$owl_lang->owl_unzip_path		= "Cale unzip:"; 
$owl_lang->owl_version_control		= "Activeaza caracteristica Control Versiuni:"; 
$owl_lang->quota			= "Cota disk 0=dezactivat"; 
$owl_lang->reallydeluser		= "Acest utilizator este proprietarul Fisier-ului(ulor) %numfiles% si a Folder-ului(elor) %numfolders%. Aceste Fisiere si Foldere vor deveni orfane. Mai doriti STERGEREA?"; 
$owl_lang->recs_per_page		= "Numar de inregistrari pe pagina (0=Dezactivare)"; 
$owl_lang->remember_me_title		= "SETARI AUTENTIFICARE PERMANENTA"; 
$owl_lang->remember_me			= "Afiseaza link-ul Aminteste-ti de mine"; 
$owl_lang->remember_timeout				= "Timp expirare Cookie (zile)"; 
$owl_lang->remember_me_checkbox			= "Aminteste-ti de mine"; 
$owl_lang->recycle_title				= "SETARI COS DE GUNOI"; 
$owl_lang->recycle_enabled				= "Activare cos de gunoi:"; 
$owl_lang->recycle_location				= "Localizare cos de gunoi:"; 
$owl_lang->show_panel_title             = "Display Status Panel:";
$owl_lang->show_search_title            = "Display Search Bar:";
$owl_lang->show_pref_title              = "Display Pref/logout Bar:";
$owl_lang->show_bulk_title              = "Display Bulk Buttons:";
$owl_lang->show_action_title            = "Display action Buttons:";
$owl_lang->show_folder_title            = "Display Folder Tools:";
$owl_lang->show_panel                   = "Show";
$owl_lang->hide_panel                   = "Hide";
$owl_lang->status_bar_both              = "In ambele locuri"; 
$owl_lang->status_bar_bottom            = "Jos"; 
$owl_lang->status_bar_location          = "Afiseaza bara de stare:"; 
$owl_lang->status_bar_top               = "Sus";
$owl_lang->status_bar_not               = "Do Not Display";
$owl_lang->use_popup					= "Utilizeaza ferestre popup pentru stiri"; 
$owl_lang->users						= "Utilizatori"; 
$owl_lang->header_user_admin            = "User Administration";
$owl_lang->header_group_admin           = "Group Administration";
$owl_lang->header_sitefeatures_settings           = "Site Features and Settings";

//********************************************************
// admin/index.php  END
//********************************************************


//********************************************************
// admin/log.php  BEGIN
//********************************************************

$owl_lang->owl_log_viewer		= "Vizualizor IStoric"; 
$owl_lang->owl_log_hd_action	= "Actiune"; 
$owl_lang->owl_log_hd_file		= "Fisier"; 
$owl_lang->owl_log_hd_fld_path	= "Cale Folder"; 
$owl_lang->owl_log_hd_user		= "Utilizator"; 
$owl_lang->owl_log_hd_dt_tm		= "Data Timp"; 
$owl_lang->owl_log_hd_ip		= "IP / Adresa"; 
$owl_lang->owl_log_hd_agent		= "Agent"; 
$owl_lang->owl_log_hd_dtls		= "Detalii"; 
$owl_lang->owl_log_no_rec		= " NICI O INREGISTRARE GASITA "; 
$owl_lang->owl_log_hide			= "Ascuns: "; 
$owl_lang->owl_log_filter		= "Filtru"; 

//********************************************************
// admin/log.php  END
//********************************************************


//********************************************************
// admin/recycle.php  BEGIN
//********************************************************

$owl_lang->empty_trash          = "Golire Cos"; 
$owl_lang->really_empty_trash	= "Sigur goliti cosul de gunoi?"; 
$owl_lang->recycle_bin_admin    = "Administrare Cos de Gunoi"; 

//********************************************************
// admin/recycle.php  END
//********************************************************


//********************************************************
// lib/owl.lib.php  BEGIN
//********************************************************

$owl_lang->file_size_byte				= "B"; 
$owl_lang->file_size_gigabyte			= "Gb";
$owl_lang->file_size_kilobyte			= "Kb";
$owl_lang->file_size_megabyte			= "Mb";
$owl_lang->notif_subject_new 			= "OWL: Fisier nou pe server"; 
$owl_lang->notif_subject_upd 			= "OWL: Un fiser a fost actualizat"; 
$owl_lang->notif_subject_monitor		= "OWL: Un fisier sau folder pe care il urmariti a fost actualizat"; 
$owl_lang->notif_subject_comment		= "OWL: Fisier -- Adaugare comentariu"; 
$owl_lang->notif_comment_1				= "a comentat"; 
$owl_lang->notif_comment_2				= "Comentariu:"; 
$owl_lang->notif_msg         			= "ACESTA ESTE UN MESAJ AUTOMAT DE LA OWL Intranet <BR><BR> Atasat acestui email gasiti fisierul nou sau actualizat<BR><BR>"; 
$owl_lang->notif_msg_link               = "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet<BR><BR>Find a link to a new/updated file in this E-Mail<BR><BR>";
$owl_lang->notif_msg_alt_link           = "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet\n\nFind a link to a new/updated file in this E-Mail\n\n";
$owl_lang->notif_msg_alt         		= "ACESTA ESTE UN MESAJ AUTOMAT DE LA OWL Intranet\n\nAtasat acestui email gasiti fisierul nou sau actualizat\n\n"; 
$owl_lang->notif_salutation				= "Draga"; 
$owl_lang->notif_user                   = "Created/Update by:";
$owl_lang->owl_path						= "Cale fisier: "; 
$owl_lang->sessinuse					= "Aceasta sesiune este utilizata pe un alt computer, acces interzis<BR>"; 
$owl_lang->invalidsess					= "Identificator de sesiune invalid, va rugam autentificati-va in pagina principala<BR>"; 
$owl_lang->sesstimeout					= "Sesiunea a expirat, va rugam sa va reautentificati<BR>"; 
$owl_lang->everyoneread					= "Toata lumea poate sa citeasca/salveze de pe server"; 
$owl_lang->everyonewrite				= "Toata lumea poate sa citeasca/salveze pe si de pe server"; 
$owl_lang->everyonewrite_nod			= "Toata lumea poate sa citeasca/salveze pe si de pe server, NU POATE STERGE"; 
$owl_lang->groupread					= "Grupul dumneavoastra poate sa citeasca/salveze de pe server"; 
$owl_lang->groupwrite					= "Grupul dumneavoastra poate sa citeasca/ salveze pe si de pe server"; 
$owl_lang->groupwrite_nod				= "Grupul dumneavoastra poate sa citeasca/salveze pe si de pe server, NU POATE STERGE"; 
$owl_lang->onlyyou						= "Numai dumneavoastra puteri citi/salva pe si de pe server"; 
$owl_lang->donothing					= "Nu schimba permisiunile fisierului"; 
$owl_lang->groupwrite_worldread			= "Grupul dumneavoastra poate citi/salva pe si de pe server si ceilalti pot citi"; 
$owl_lang->groupwrite_worldread_nod		= "Grupul dumneavoastra poate citi/salva pe si de pe server (NU POATE STERGE) si ceilalti pot citi"; 
$owl_lang->ggroupwrite_worldread		= "Grupul dumneavoastra poate salva pe server si sterge acest folder, ceilalti pot vedea continutul"; 
$owl_lang->ggroupwrite_worldread_nod	= "Grupul dumneavoastra poate salva fisiere in acest folder, ceilalti pot vedea continutul (NU SE POATE STERGE)"; 
$owl_lang->everyoneread_ad				= "Toata lumea poate sa citeasca/salveze de pe server"; 
$owl_lang->everyonewrite_ad				= "Toata lumea poate sa citeasca/salveze pe si de pe server"; 
$owl_lang->everyonewrite_ad_nod			= "Toata lumea poate sa citeasca/salveze pe si de pe server, NU POATE STERGE"; 
$owl_lang->groupread_ad					= "Grupul selectat poate citi/salva de pe server"; 
$owl_lang->groupwrite_ad				= "Grupul selectat poate citi/salva pe si de pe server"; 
$owl_lang->groupwrite_ad_nod			= "Grupul selectat poate citi/salva pe si de pe server (NU POATE STERGE)"; 
$owl_lang->onlyyou_ad					= "Numai dumneavoastra puteti citi/salva pe si de pe server"; 
$owl_lang->groupwrite_worldread_ad		= "Grupul selectat poate citi/salva pe si de pe server, ceilalti pot doar citi"; 
$owl_lang->groupwrite_worldread_ad_nod	= "Grupul selectat poate citi/salva pe si de pe server (NU SE POATE STERGE), ceilalti pot doar citi"; 
$owl_lang->ggroupwrite_worldread_ad		= "Grupul selectat poate salva pe server si sterge acest folder, ceilalti pot vedea continutul"; 
$owl_lang->ggroupwrite_worldread_ad_nod	= "Grupul selectat poate salva pe server in acest folder, ceilalti pot vedea continutul (NU SE POATE STERGE)"; 
$owl_lang->geveryoneread				= "Toata lumea poate citi acest folder"; 
$owl_lang->geveryonewrite				= "Toata lumea poate salva fisiere si sterge acest folder"; 
$owl_lang->geveryonewrite_nod			= "Toata lumea poate salva fisiere in acest folder"; 
$owl_lang->ggroupread					= "Grupul dumneavoastra poate citi acest folder"; 
$owl_lang->ggroupwrite					= "Grupul dumneavoastra poate salva fisiere si sterge acest folder"; 
$owl_lang->ggroupwrite_nod				= "Grupul dumneavoastra poate salva fisiere in acest folder"; 
$owl_lang->gonlyyou						= "Numai dumneavoastra puteti salva fisiere si sterge acest folder"; 
$owl_lang->geveryoneread_ad				= "Toata lumea poate citi acest folder"; 
$owl_lang->geveryonewrite_ad			= "Toata lumea poate salva fisiere si sterge acest folder"; 
$owl_lang->geveryonewrite_ad_nod		= "Toata lumea poate salva fisiere in acest folder"; 
$owl_lang->ggroupread_ad				= "Grupul selectat poate citi acest folder"; 
$owl_lang->ggroupwrite_ad				= "Grupul selectat poate salva fisiere si sterge acest folder"; 
$owl_lang->ggroupwrite_ad_nod			= "Grupul selectat poate salva fisiere in acest folder"; 
$owl_lang->gonlyyou_ad					= "Numai dumneavoastra puteti salva fisiere si sterge acest folder"; 
$owl_lang->orphaned						= "&#8211; FARA Proprietar &#8211;"; 
$owl_lang->virus_infected               = "VIRUS INFECTED FILE";
$owl_lang->virus_return_val             = "Virus Program Return value:";

//********************************************************
// lib/owl.lib.php  END
//********************************************************


//********************************************************
// HREF TITLE messages  BEGIN
//********************************************************

$owl_lang->title_browse_folder     	= "Mergi in acest folder"; 
$owl_lang->title_browse_site     	= "Mergi in acest URL"; 
$owl_lang->title_download_view     	= "Salveaza de pe server / Vezi acest fisier"; 
$owl_lang->title_edit_prefs     	= "Vezi / Editeaza Preferinte Utilizatori"; 
$owl_lang->title_return_folder     	= "Intoarcete la"; 
$owl_lang->title_sort				= "Ordoneaza dupa"; 
$owl_lang->title_view_new     		= "Vizualizeaza lista fisierelor noi de la ultima mea vizita"; 
$owl_lang->title_view_updated     	= "Vizualizeaza lista fisierelor actualizate de la ultima mea vizita"; 
$owl_lang->title_view_my     		= "Vizualizeaza lista fisierelor mele"; 

//********************************************************
// HREF TITLE messages  END
//********************************************************


//********************************************************
// admin/news.php and newsread.php BEGIN
//********************************************************

$owl_lang->news_title			= "Administrator Stiri"; 
$owl_lang->news_hd				= "Stiri"; 
$owl_lang->news_hd_created		= "Creat la"; 
$owl_lang->news_hd_expires		= "Expira la"; 
$owl_lang->news_hd_audience		= "Audienta Tinta"; 
$owl_lang->news_heading			= "Antet Stire"; 
$owl_lang->news_content			= "Continut"; 
$owl_lang->news_posted_date		= "Stire din data:"; 
$owl_lang->news_read			= "Citit(a)"; 

//********************************************************
// admin/news.php and newsread.php  END
//********************************************************


//********************************************************
// DEBUG MESSAGES BEGIN
//********************************************************

$owl_lang->debug_tmp_not_exists		= "DEPANARE: Folderul OWL temporar: $default->owl_tmpdir nu exista."; 
$owl_lang->debug_tmp_not_writeable	= "DEPANARE: Folderul OWL temporar: $default->owl_tmpdir nu poate fi scris de catre WEB Server."; 
$owl_lang->debug_doc_not_exists		= "DEPANARE: Folderul OWL Documents: " .$default->owl_fs_root . "/" . fid_to_name(1) ." nu exista."; 
$owl_lang->debug_doc_not_writeable	= "DEPANARE: Folderul OWL Documents: " .$default->owl_fs_root . "/" . fid_to_name(1) ." nu poate fi scris de catre WEB Server."; 
$owl_lang->debug_webserver_no_access    = "DEBUG: The webserver does not have read access to: <br />'$default->owl_fs_root/$filename'. <br />Please fix the permissions and try again";
$owl_lang->debug_file_not_exist         = "DEBUG: The required file '$default->owl_fs_root/$filename' does not exists.<br /> OR<br />The path specified by \$default->owl_fs_root in config/owl.php is wrong.";
                                                                                                                                                                                                                                                                                                                                                                
//********************************************************
// DEBUG MESSAGES END
//********************************************************


//********************************************************
// admin/stats.php BEGIN
//********************************************************

$owl_lang->owl_stats_viewer		= "Vizualizare Statistici"; 
$owl_lang->stats_files			= "Numar de Fisiere/Utilizator"; 
$owl_lang->stats_folders		= "Numar de Foldere/Utilizator"; 
$owl_lang->stats_top			= "Top-ul celor 20 de fisiere salvate de pe server"; 
$owl_lang->stats_users          = "USER Signon (Login / Failure / Logout)";
$owl_lang->stats_users_loggedin = "Currently Logged In";
$owl_lang->stats_information	= "Istoricul OWL si Istoricul Fisierelor trebuie sa fie activate pentru a putea afisa aceste statistici"; 

//********************************************************
// admin/stats.php END
//********************************************************

//********************************************************
// admin/doctype.php BEGIN
//********************************************************

$owl_lang->document_type		= "Tip Document"; 
$owl_lang->document_type_name	= "Nume Tip Document"; 
$owl_lang->doc_field_name		= "Nume Cimp"; 
$owl_lang->doc_field_pos		= "Pozitie Cimp"; 
$owl_lang->doc_field_label		= "Eticheta Cimp (Pt Locale)"; 
$owl_lang->doc_field_size		= "Marime Cimp"; 
$owl_lang->doc_field_searchable	= "Inclus in cautari?"; 
$owl_lang->doc_field_required	= "Necesar?"; 
$owl_lang->doc_new_doc_type		= "&#8212; Adauga Tip Nou de Document &#8212;"; 
$owl_lang->doc_specific			= "CIMPURI SPECIFICE PT DOCUMENT"; 
$owl_lang->doc_administration	= "Administrare Tipuri Document"; 

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
