<?php

/*

  File: Italian/language.inc   Italian 
  Author: Luca Barba <<a href="mailto:angeloluca.barba@virgilio.it">angeloluca.barba@virgilio.it</a>>, F. Malfatto <<a href="mailto:fmal@fmal.com">fmal@fmal.com</a>>
  Date: 2003/08/05
	to <a href="mailto:steveb@bozzit.com">steveb@bozzit.com</a>
  Owl: Copyright Chris Vincent <<a href="mailto:cvincent@project802.net">cvincent@project802.net</a>>

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
$owl_lang->err_adding_comments      	= "Non hai permessi per aggiungere commenti al file";
$owl_lang->err_comment_empty            = "Comment cannot be empty";
$owl_lang->err_backup_file   		= "Errore durante il Backup di un file";
$owl_lang->err_backup_folder_create 	= "Errore durante la creazione della cartella di Backup";
$owl_lang->err_bad_url                  = "Please enter a valid URL";
$owl_lang->err_bad_version_1 		= "Owl Intranet richiede almeno PHP versione ";
$owl_lang->err_bad_version_2 		= "Tu stai utilizzando PHP versione ";
$owl_lang->err_bad_version_3 		= "Istalla una versione più recente di php e ritenta ";
$owl_lang->err_email         		= "Mail non inviata";
$owl_lang->err_email_required   	= "Indirizzo Email obbligatorio";
$owl_lang->err_fexist1  		= "<b>File Esistente:</b>";
$owl_lang->err_fexist2 			= "Esiste gi&agrave; un file di nome <i>";
$owl_lang->err_fexist3 			= "</i> in questa cartella.";
$owl_lang->err_file_exists        	= "Il file che cerchi di caricare esiste gia'";
$owl_lang->err_fileexists    		= "Move annullato<BR>File gi&agrave; esistente.";
$owl_lang->err_file_lock     		= "Check out non consentito, bloccato da ";
$owl_lang->err_update_file_lock         = "You cannot update this file, it is currently held by";
$owl_lang->err_filemove_exist       	= "Il nome che stati tentando di assegnare &egrave; gi&agrave; esistente";
$owl_lang->err_file_not_exist 	 	= "Il file richiesto non esiste sul file system";
$owl_lang->err_file_too_big  		= "php.ini upload_max_filesize superata e/o<BR>Max Dim. di upload di Owl superata";
$owl_lang->err_file_update   		= "Per aggiornare un file il filename deve rimanere lo stesso, per favore ritenta usando lo stesso filename filename";
$owl_lang->err_folder_create 		= "Errore durante la creazione della cartella";
$owl_lang->err_folder_exist  		= "Cartella gi&agrave; esistente";
$owl_lang->err_folderexists  		= "Rinomina annullato <BR>Cartella gi&agrave; esistente.";
$owl_lang->err_general       		= "Si &egrave; verificato un errore";
$owl_lang->err_group_delete             = "Puoi cancellare solo gruppi senza membri";
$owl_lang->err_group_exists             = "Nome di Gruppo gi&agrave; esistente.";
$owl_lang->err_gzip_not_found   	= "gzip non trovato in ";
$owl_lang->err_login   			= "Per favore esegui il Login per compiere questa azione";
$owl_lang->err_movecancel    		= "Move annullato<BR>";
$owl_lang->err_nameempty     		= "Il nome della cartella non pu&ograve; essere vuoto";
$owl_lang->err_news_required            = "ERRORE: News Heading and Content are required!";
$owl_lang->err_no_access       		= "Non hai i diritti di accesso per almeno uno dei files selezionati";
$owl_lang->err_no_access_info           = "Possible causes: <br></br>1) You did not click any checkbox in front of a File or Folder<br></br>2) Bulk Delete, Bulk Email, Bulk Checkout do not apply to Folders<br></br>3) You do not have access to any of the files or folders you have selected.";
$owl_lang->err_noemail           	= "Non hai i permessi per accedere all'email di questo file";
$owl_lang->err_nofileaccess      	= "Non hai permessi di accesso al file";
$owl_lang->err_nofiledelete      	= "Non hai permessi di cancellazione su questo file";
$owl_lang->err_nofilemod         	= "Non hai permessi di modifica su questo file";
$owl_lang->err_nofolderaccess    	= "Non hai permessi di accesso alla cartella";
$owl_lang->err_nofolderdelete    	= "Non hai permessi di cancellazione in questa cartella";
$owl_lang->err_nofoldermod       	= "Non hai permessi di modifica su questa cartella";
$owl_lang->err_nosubfolder       	= "Non hai permessi di scrittura in questa cartella";
$owl_lang->err_note_title               = "Il campo Title &egrave; obbligatorio";
$owl_lang->err_note_title_exists        = "Una Nota con questo nome gi&agrave; esiste";
$owl_lang->err_noupload          	= "Non hai permessi di scrittura in questa cartella";
$owl_lang->err_pass_missmatch		= "La Nuova Password e la Password di Conferma non sono uguali";
$owl_lang->err_pass_wrong    		= "La vecchia password &egrave; sbagliata";
$owl_lang->err_pod2html_not_found   	= "ERRORE: Non trovo il tool pod2html :";
$owl_lang->err_quota         		= "Non ti &egrave; rimasto abbastanza spazio di memorizzazione su disco per aggiungere questo file : ";
$owl_lang->err_quota_needed  		= " necessario ";
$owl_lang->err_quota_avail   		= " disponibile.";
$owl_lang->err_quota_exceed  		= "Hai esaurito il tuo spazio di memorizzazione";
$owl_lang->err_req      		= "ERROR: Tutti i campi sono obbligatori";
$owl_lang->err_root_delete              = "La Cartella base non pu&ograve; essere cancellata";
$owl_lang->err_sess_notvalid 		= "Identificativo di sessione non valido ";
$owl_lang->err_sess_write    		= "Si &egrave; verificato un errore : scrittura della sessione sul RDBMS";
$owl_lang->err_specialfoldername 	= "'backup' &egrave; un nome di Cartella riservato a Owl, scegli un altro nome";
$owl_lang->err_tar_not_found    	= "tar non trovato in ";
$owl_lang->err_trash_can_empty          = "Il cestino &egrave; vuoto";
$owl_lang->err_unauth_area   		= "Non sei autorizzato ad utilizzare quest'area";
$owl_lang->err_unauthorized  		= "Non autorizzato ";
$owl_lang->err_upload        		= "Errore di Upload";
$owl_lang->err_user_exists   		= "Identificativo utente gi&agrave; esistente";
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
$owl_lang->alt_add_comments     = "Aggiungi un commento";
$owl_lang->alt_btn_add_file     = "Aggiungi nuovo File";
$owl_lang->alt_btn_add_folder   = "Crea nuova Cartella";
$owl_lang->alt_add_group        = "Crea questo Gruppo";
$owl_lang->alt_add_news         = "Aggiungi una nuova Notizia";
$owl_lang->alt_btn_add_note     = "Aggiungi una nuova Nota";
$owl_lang->alt_add_user         = "Crea questo Utente";
$owl_lang->alt_btn_add_url      = "Aggiungi un nuovo Web link";
$owl_lang->alt_cancel           = "Cancle This Action";
$owl_lang->alt_cancel_move      = "Annulla azione Muovi";
$owl_lang->alt_change           = "Aggiorna questa riga";
$owl_lang->alt_btn_clickhere    = "Clicca qui";
$owl_lang->alt_btn_collapse_view= "Vista ridotta";
$owl_lang->alt_comments         = "Ci sono Commenti per questo file";
$owl_lang->alt_del_comments     = "Cancella questo Commento";
$owl_lang->alt_del_file      	= "Elimina File (Y/N)";
$owl_lang->alt_del_folder    	= "Elimina Cartella (Y/N)";
$owl_lang->alt_del_group        = "Cancella questo Gruppo";
$owl_lang->alt_del_news         = "Cancella questa Notizia";
$owl_lang->alt_del_selected     = "Cancella i files selezionati";
$owl_lang->alt_del_all          = "Empty Trash";
$owl_lang->alt_rest_selected    = "Restore all Selected Files";
$owl_lang->alt_del_this_folder  = "Cancella Cartella&#8211; ";
$owl_lang->alt_del_user         = "Cancella questo Utente";
$owl_lang->alt_edit_group       = "Modifica il Gruppo selezionato";
$owl_lang->alt_edit_news        = "Modifica questa Notizia";
$owl_lang->alt_edit_user        = "Modifica l' Utente selezionato";
$owl_lang->alt_email            = "Email di questo file";
$owl_lang->alt_email_selected   = "Email dei files selezionati"; 
$owl_lang->alt_btn_expand_view  = "Vista Espansa";
$owl_lang->alt_admin_flush   	= "Elimina le sessioni bloccate o scadute";
$owl_lang->alt_get_file      	= "Scarica File";
$owl_lang->alt_get_folder       = "Download Folder Content";
$owl_lang->alt_have_news        = "Hai delle Segnalazioni da vedere";
$owl_lang->alt_have_no_news     = "Nessuna Segnalazione da vedere";
$owl_lang->alt_home_folder      = "Back to Intial Dir ";
$owl_lang->alt_set_initial_dir  = "Set Current Dir as Initial";                                                                                                
$owl_lang->alt_site_map         = "Site Map";
$owl_lang->alt_lock_file        = "Check out del file";
$owl_lang->alt_log_clear        = "Cancella tutti i Logs (Y/N)";
$owl_lang->alt_log_file         = "File Log";
$owl_lang->alt_log_next         = "successivi";
$owl_lang->alt_log_prev         = "Visualizza precedenti";
$owl_lang->alt_log_top          = "Vai al primo";
$owl_lang->alt_btn_login        = "Login in  Owl Intranet";
$owl_lang->alt_btn_logout       = "Logout da Owl Intranet";
$owl_lang->alt_btn_help         = "Owl Online Help";
$owl_lang->alt_mod_file      	= "Modifica proprieta' del File";
$owl_lang->alt_mod_folder    	= "Modifica proprieta' Cartella";
$owl_lang->alt_move_file     	= "Sposta File";
$owl_lang->alt_copy_file        = "Copy File";
$owl_lang->alt_link_file        = "Link This File to Another Directory";
$owl_lang->alt_move_folder   	= "Sposta Cartella";
$owl_lang->alt_copy_folder      = "Copy Folder";
$owl_lang->alt_move_selected    = "Muovi tutti i files selezionati"; 
$owl_lang->alt_admin_groups 	= "Crea un nuovo gruppo";
$owl_lang->alt_news_close       = "Chiudi la finestra Notizie";
$owl_lang->alt_news_next        = "Visualizza prossima Notizia";
$owl_lang->alt_news_prev        = "Visualizza Notizia precedente ";
$owl_lang->alt_news_print       = "Stampa questa Notizia ";
$owl_lang->alt_admin_users      = "Crea un nuovo  Utente";
$owl_lang->alt_monitor  	= "Monitor this File";
$owl_lang->alt_monitored        = "Smetti di monitorare questo file";
$owl_lang->alt_btn_admin        = "Amministrazione di Owl Intranet";
$owl_lang->alt_play_file        = "Play";
$owl_lang->alt_recycle          = "Il tuo Cestino &egrave; vuoto";
$owl_lang->alt_recycle_disable  = "Il Cestino &egrave; disabilitato";
$owl_lang->alt_recycle_not_found= "Cestino non trovato";
$owl_lang->alt_refresh_filter   = "Inizia Filtraggio / Refresh ";
$owl_lang->alt_register         = "Conferma Registrazione";
$owl_lang->alt_btn_browse       = "Ritorna al File Browser";
$owl_lang->alt_search           = "Inizia Ricerca";
$owl_lang->alt_send_email       = "Spedisci Email";
$owl_lang->alt_sendfile         = "Spedisci File";
$owl_lang->alt_toggle_check_box = "Seleziona le Check Box";
$owl_lang->alt_unlock_file      = "Check in";
$owl_lang->alt_upd_file      	= "Aggiorna File";
$owl_lang->alt_view_comments    = "Aggiungi / Visualizza Commenti";
$owl_lang->alt_view_file     	= "Visualizza File";
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

$owl_lang->log_del_det          = "Contenuto gi&agrave; cancellato";
$owl_lang->log_detail           = "Nessun dettaglio disponibile.";
$owl_lang->log_file_to          = "TO: ";
$owl_lang->log_filter_all       = "TUTTI";
$owl_lang->log_login_det        = "Username: ";
$log_file_actions[1]            = "LOGIN";
$log_file_actions[2]            = "LOGIN FALLITO";
$log_file_actions[3]            = "LOGOUT";
$log_file_actions[4]            = "FILE CANCELLATO";
$log_file_actions[5]            = "FILE UPLOAD";
$log_file_actions[6]            = "FILE AGGIORNATO";
$log_file_actions[7]            = "FILE SCARICATO";
$log_file_actions[8]            = "FILE CAMBIATO";
$log_file_actions[9]            = "FILE BLOCCATO";
$log_file_actions[10]           = "FILE SBLOCCATO";
$log_file_actions[11]           = "FILE SPEDITO";
$log_file_actions[12]           = "FILE MOVIMENTATO";
$log_file_actions[13]           = "CARTELLA CREATA";
$log_file_actions[14]           = "CARTELLA CANCELLATA";
$log_file_actions[15]           = "CARTELLA MODIFICATO";
$log_file_actions[16]           = "CARTELLA MOVIMENTATA";
$log_file_actions[17]           = "PASS PERDUTA";
$log_file_actions[18]           = "USER REG";                                                                                                                                       
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

$owl_lang->anonymous         = "(Accesso Anonimo)";
$owl_lang->repository_list      = "Repository:";
$owl_lang->engine 	     = "Owl Intranet Engine";
$owl_lang->forgot_pass       = "Hai smarrito la tua Passuord?";
$owl_lang->like_register     = "Vuoi registrarti?";
$owl_lang->login             = "Login";
$owl_lang->loginfail         = "Errore di login";
$owl_lang->logindisabled     = "Account DISABILITATO, contatta il System Administrator";
$owl_lang->password          = "Password";
$owl_lang->successlogout     = "Logout completato";
$owl_lang->toomanysessions   = "Numero massimo di sessioni per utente raggiunto, contatta il System Administrator";
$owl_lang->username          = "Identificativo Utente";
$owl_lang->version 	     = "Versione";

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
$owl_lang->actions           		= "Azioni";
$owl_lang->del_selected          	= "Cancella Selezionati";
$owl_lang->del_all                      = "Empty Trash";
$owl_lang->rest_selected                = "Restore Selected";
$owl_lang->disk_quota                   = "Disk Quota";
$owl_lang->email_selected        	= "Invia Email ai Selezionati";
$owl_lang->file              		= "File";
$owl_lang->folder_policy                = "Current Folder Policy:";
$owl_lang->current_folder               = "Current Folder:";
$owl_lang->held                      	= "Bloccato da"; // for version control
$owl_lang->last_logged              	= "Ultima volta: ";
$owl_lang->current_db                   = "Current Repository:";
$owl_lang->modified          		= "Modificato";
$owl_lang->move_selected         	= "Muovi Selezionati";
$owl_lang->new_file                     = "Nuovo!";
$owl_lang->no_description               = "Nessuna Descrizione";
$owl_lang->page                         = "Page:";
$owl_lang->postedby          		= "Creato da";
$owl_lang->reallydelete      		= "Conferma cancellazione";
$owl_lang->reallydelete_logs            = "Conferma cancellazione del Log File";
$owl_lang->reallydelete_selected	= "Conferma cancellazione dei files selezionati";
$owl_lang->reallyrestore_selected       = "Really Restore all selected files";
$owl_lang->size              		= "Dimensione";
$owl_lang->score                        = "Score";
$owl_lang->title             		= "Titolo";
$owl_lang->doc_number                   = "Doc #";
$owl_lang->tot_files                    = "Totale:";
$owl_lang->tot_my_checked_out           = "Checked Out:";
$owl_lang->tot_my_files         	= "Miei:";
$owl_lang->tot_my_group                 = "Group:";
$owl_lang->tot_new_files                = "Nuovi:";
$owl_lang->tot_updated_files            = "Modificati:";
$owl_lang->tot_monitored                = "Monitored:";
$owl_lang->updated_file         	= "Modificato!";
$owl_lang->user               		= "Utente";
$owl_lang->ver                       	= "Ver."; // for version control
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
$owl_lang->adding_comments      = "Aggiungi / Visualixìzza Commenti : ";
$owl_lang->comments             = "Comment";
$owl_lang->post_comment         = "Post Comment";
$owl_lang->addingfile        	= "Aggiungi file a ";
$owl_lang->addingfolder      	= "Aggiungi cartella a ";
$owl_lang->attach_file       	= "Attach File";
$owl_lang->change            	= "Cambia";
$owl_lang->create            	= "Crea";
$owl_lang->comments_added       = "Commenti aggiunti da: ";
$owl_lang->description       	= "Descrizione";
$owl_lang->email_body        	= "Messaggio";
$owl_lang->email_cc          	= "CC";
$owl_lang->email_reply_to    	= "Rispondi";
$owl_lang->email_subject     	= "Titolo";
$owl_lang->email_to          	= "Invia Mail";
$owl_lang->emailing          	= "In spedizione";
$owl_lang->disp_mp3          	= "MP3&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;Song:<BR>Album:<BR>Bitrate&amp;nbsp;-&amp;nbsp;Samplerate:<BR>Duration:<BR>Genre:<BR>Comments:";
$owl_lang->keywords          	= "Chiavi di ricerca";
$owl_lang->modify_url           = "URL";
$owl_lang->modifying         	= "Modifica ";
$owl_lang->name               	= "Nome";                                                                                                                                                   
$owl_lang->notify_link          = "Owl External Link";
$owl_lang->note_content         = "Contenuto della Nota";
$owl_lang->ownergroup         	= "Proprietario (Gruppo)";
$owl_lang->ownership         	= "Proprietario";
$owl_lang->permissions       	= "Permessi";
$owl_lang->prop_permissions     = "Propagare i Permessi alle sottodirectory?";
$owl_lang->prop_perms_files     = "Permessi da propagare ai file";
$owl_lang->policy            	= "Permessi";
$owl_lang->pick_select          = "&#8212; Seleziona Utente&#8212;";
$owl_lang->sendfile          	= "Manda file";
$owl_lang->sendthisfile      	= "Manda questo file";
$owl_lang->sendthisurl       	= "Manda questo URL";
$owl_lang->updating          	= "Modifica in corso";
$owl_lang->verdescription	= "Descrizione<br></br>dei cambiamenti";
$owl_lang->vermajor          	= "Numero Base Revisione ";
$owl_lang->verminor          	= "Numero Secondario Revisione ";
$owl_lang->vertype           	= "Tipo di Revisione ";  // for modify.php when uploading

//********************************************************
// modify.php  END
//********************************************************


//********************************************************
// register.php  BEGIN
//********************************************************
                                                                                                       
$owl_lang->email             	= "Email ";
$owl_lang->full_name         	= "Nome Completo";
$owl_lang->register          	= "Registrazione utente";
$owl_lang->self_failed   	= "Fallito";
$owl_lang->self_passwd   	= "Password inviata a:";
$owl_lang->self_reg_bod  	= "Password Owl:";
$owl_lang->self_reg_rset 	= "Password Owl resettata a:";
$owl_lang->self_reg_subj	= "Identificativo Utente Owl";
$owl_lang->send_pass           	= "Invia Password";
$owl_lang->submit            	= "Conferma";
$owl_lang->thank_you_1          = "Grazie!";
$owl_lang->thank_you_2          = "Ti arriver&agrave; una email<BR> con la NUOVA password per <BR><b>l'UTENTE:</b>";

//********************************************************
// register.php  END
//********************************************************


//********************************************************
// move.php  BEGIN
//********************************************************

$owl_lang->cancel_button     = "Annulla";
$owl_lang->moving            = "Movimentazione in corso";
$owl_lang->moving_file          = "Moving file";
$owl_lang->moving_folder        = "Moving Folder";
$owl_lang->copy_file            = "Copying file";
$owl_lang->copy_folder          = "Copying Folder";
$owl_lang->select            = "Seleziona la Cartella destinazione:";

//********************************************************
// move.php  END
//********************************************************


//********************************************************
// log.php  BEGIN
//********************************************************

$owl_lang->viewlog           = "Visualizzazione Log Per ";

//********************************************************
// log.php  END
//********************************************************


//********************************************************
// prefs.php  BEGIN
//********************************************************

$owl_lang->confpassword  = "Conferma nuova Password";
$owl_lang->comment_notif = "Notifica dei Commenti ";
$owl_lang->email_tool   = "E-Mail Tool";
$owl_lang->last_modified= "Last Modified";
$owl_lang->group         = "Gruppo";
$owl_lang->groupmember   = "Membro";
$owl_lang->newpassword   = "Nuova Password";
$owl_lang->newsadmin     = "Amministratore Notizie";
$owl_lang->not_member    = "Non sei membro di alcun altro gruppo";
$owl_lang->notification  = "Ricevi Notifiche";
$owl_lang->oldpassword   = "Vecchia Password";
$owl_lang->preference    = "Preferenze";
$owl_lang->saved         = "Cambiamenti effettuati";
$owl_lang->status_no     = "NO";
$owl_lang->status_yes    = "YES";
$owl_lang->userlang      = "Lingua";

//********************************************************
// prefs.php  END
//********************************************************


//********************************************************
// search.php  BEGIN
//********************************************************

$owl_lang->elapsed_time         = "elapsed time";
$owl_lang->search             	= "Ricerca";
$owl_lang->search_any_word      = "Any Words";
$owl_lang->search_all_word      = "All Words";
$owl_lang->search_entire_phrase = "Entire Phrase";
$owl_lang->search_match         = "Match:";
$owl_lang->search_currentfolder = "Search Current Folder";
$owl_lang->search_for_folders   = "Searching For Folders";
$owl_lang->search_for_files     = "Searching For Files";
$owl_lang->search_score         = "Scoring Files";
$owl_lang->search_results_for 	= "Risultati Ricerca per";
$owl_lang->search_winthindocs   = "Search Within";
$owl_lang->related_query_empty  = "No metadata associated with document to perform 'Search Related'";
$owl_lang->query_empty        	= "Svuota Stringa di ricerca";

//********************************************************
// search.php  END
//********************************************************


//********************************************************
// view.php  BEGIN
//********************************************************

$owl_lang->viewing           = "Visualizzazione in corso ";

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
$owl_lang->add               		= "Aggiungi";
$owl_lang->anonymous_account            = "Account per Accesso Anonimo:";
$owl_lang->buttonstyle                  = "Button Style";
$owl_lang->deletegroup       		= "Cancella Gruppo";
$owl_lang->deleteuser        		= "Cancella Utente";
$owl_lang->disableuser       		= "Disabilita Utente";
$owl_lang->disable_recs_per_page        = "Enabling Restricted View Will DISABLE Records Per Page!";
$owl_lang->file_admin_group             = "File/Browser Admin Group:";
$owl_lang->flushed           		= "Tabella sessioni ripulita.<BR>";
$owl_lang->groups            		= "Gruppi";
$owl_lang->hide_bulk_buttons            = "Togli pulsanti funzionanti su più files:";
// Edit HTML Properties Messages
$owl_lang->ht_tbl_border_sz  		= "Table Border :";
$owl_lang->ht_tbl_hd_bg      		= "Header Background:";
$owl_lang->ht_tbl_cell_bg_cl 		= "Table Cell Background Colour:";
$owl_lang->ht_tbl_cell_bg_al 		= "Table Cell Background Colour Alternativo:";
$owl_lang->ht_expand_width   		= "Larghezza Expanded View :";
$owl_lang->ht_collapse_width 		= "Larghezza Collapse View :";
$owl_lang->ht_bd_bg_image    		= "Path Immagine Body Background :";
$owl_lang->ht_bd_txt_cl      		= "Colore Body Text :";
$owl_lang->ht_bd_lnk_cl      		= "Colore Body Link :";
$owl_lang->ht_bd_vlnk_cl     		= "Colore Body Visited Link :";
// Edit Prefs Properties Messages
$owl_lang->home_dir                     = "User's Home Directory";
$owl_lang->initial_dir                  = "User's Initial Directory";
$owl_lang->maxsessions       		= "Max Num. Sessioni";
$owl_lang->noprefaccess       		= "Disabilita Pref";
$owl_lang->owl_anon_full                = "Full Access";
$owl_lang->owl_anon_ro       		= "Imponi Utente Anonimo in sola lettura:";
$owl_lang->owl_anon_download            = "Download Only";
$owl_lang->anonymous_access             = "Set Anonymous Access";
$owl_lang->owl_dbdump_path   		= "Path DB Dump Tool :";
$owl_lang->owl_def_file_group_owner	= "Gruppo proprietario File (Default) :";
$owl_lang->owl_def_file_meta 		= "Meta Dati File (Default) :";
$owl_lang->owl_def_file_owner		= "Proprietario File (Default) :";
$owl_lang->owl_def_file_perm 		= "Policy Creazione File (Default):";
$owl_lang->owl_def_file_security	= "Sicurezza File (Default) :";
$owl_lang->owl_def_file_title		= "Nome File (Nessuno per Filename):";
$owl_lang->owl_def_fold_group_owner	= "Gruppo proprietario Cartella (Default) :";
$owl_lang->owl_def_fold_owner       	= "Proprietario Cartella (Default) :";
$owl_lang->owl_def_fold_sec  		= "Sicurezza Cartella (Default) :";
$owl_lang->owl_def_folder_perm 		= "Policy Creazione Cartella (Default):";
$owl_lang->owl_default_tmpdir   	= "Posizione Directory Files Temporanei: ";
$owl_lang->owl_email_from    		= "From Address / SMTP Auth Login:";
$owl_lang->owl_email_fromname		= "From Name:";
$owl_lang->owl_email_replyto 		= "Reply To Address:";
$owl_lang->owl_email_server  		= "SMTP Server:";
$owl_lang->owl_email_smtp               = "Usa Mailing SMTP ";
$owl_lang->owl_email_smtp_auth          = "Usa autenticazione SMTP ";
$owl_lang->owl_email_smtp_auth_login    = "SMTP Auth Login:";
$owl_lang->owl_email_smtp_auth_passwd   = "SMTP Password";
$owl_lang->owl_email_subject_pref      	= "Prefisso a titolo email:";
$owl_lang->owl_fogotpass             	= "Mostra link per recupero PW dimenticata:";
$owl_lang->owl_group_user    		= "Membri di questo Gruppo";
$owl_lang->owl_gzip_path     		= "Path gzip :";
$owl_lang->owl_hidebackup    		= "Nascondi la Directory di Backup :";
$owl_lang->owl_log_file      		= "Registra attivit&agrave; su Files:";
$owl_lang->owl_log_login_act 		= "Registra attivit&agrave; su Login/Logout:";
$owl_lang->owl_log_rec_page  		= "Numero di righe di Log Per Pagina:";
$owl_lang->owl_logging       		= "Abilita Logging:";
$owl_lang->owl_logo                  	= "Logo per Pagina di Login ([Language]/graphics):";
$owl_lang->owl_lookAtHD      		= "Disabilita visualizzazione HD:";
$owl_lang->owl_lookAtHDDel   		= "Rimuovi Files cancellati dal DB:";
$owl_lang->hide_folder_doc_count        = "Hide Folder File Type Count";                                                                                                                        
$owl_lang->hide_folder_size             = "Hide Folder Content Size";
$owl_lang->old_action_icons             = "Use pre Owl 0.80 Action Icons";
$owl_lang->search_result_folders        = "Include Folders in Search Results";
$owl_lang->restore_file_prefix          = "String Prefixed to Restored Files";
$owl_lang->owl_max_filesize  		= "Max Dimensione di Upload :";
$owl_lang->owl_owl_expand    		= "Vista di Default Browser (Espandi):";
$owl_lang->owl_owl_timeout   		= "Timeout Sessione in Secondi:";
$owl_lang->virus_path                   = "Virus Checking Software Path<br />Example: '/usr/bin/clamscan --quiet' <br />&#8211; Blank for Disabled:";
$owl_lang->owl_pdftotext_path           = "Indicizzazione per <BR>PDF e text Files <BR>&#8211; Blank for Disabled:";
$owl_lang->owl_wordtotext_path          = "MS-WORD Files <BR>&#8211; Blank for Disabled:";
$owl_lang->owl_pod2html_path            = "Perl 5.8.0 or Greater required<BR>Path to pod2html:";
$owl_lang->owl_restrict_view 		= "Abilita Visualizzazione ristretta :";
$owl_lang->owl_self_reg      		= "Abilita Autoregistrazione:";
$owl_lang->owl_self_reg_hd   		= "DEFAULTS PER UTENTI AUTOREGISTRATI";
$owl_lang->owl_tar_path     		= "Path tar :";
$owl_lang->owl_title_custom             = "CUSTOMIZE BROWSER COLUMNS";
$owl_lang->owl_title_custom_search      = "CUSTOMIZE SEARCH RESULTS";
$owl_lang->owl_title_browser        	= "CARATTERISTICHE OWL BROWSER";
$owl_lang->owl_title_defaults   	= "DEFAULTS";
$owl_lang->owl_title_email   		= "OWL System Mail Settings";
$owl_lang->owl_title_HD      		= "LOOK AT HD FOR NEW FILES SETINGS";
$owl_lang->owl_title_logging  		= "Impostazioni LOGGING";
$owl_lang->owl_title_other   		= "Altre Impostazioni";
$owl_lang->owl_title_tools   		= "TOOLS DB BACKUP/GZIP ";
$owl_lang->owl_unzip_path           	= "Path unzip :";
$owl_lang->owl_version_control		= "Abilita Version Control :";
$owl_lang->quota             		= "Quota 0=Disabled";
$owl_lang->reallydeluser                = "This user is owner of %numfiles% File(s) and %numfolders% Folder(s). These File(s) and Folder(s) will be orphaned. Is it Still Ok to Delete?";
$owl_lang->recs_per_page                = "Display Records Per Page (0 = Disabled):";
$owl_lang->remember_me_title            = "PERSISTENT LOGIN SETTINGS";
$owl_lang->remember_me                  = "Show the Remember Me link";
$owl_lang->remember_timeout             = "Cookie timeout in Days";
$owl_lang->remember_me_checkbox         = "Remember me";
$owl_lang->recycle_title                = "IMPOSTAZIONI CESTINO";
$owl_lang->recycle_enabled              = "Abilita Cestino:";
$owl_lang->recycle_location             = "Posizione Cestino:";
$owl_lang->show_panel_title             = "Display Status Panel:";
$owl_lang->show_search_title            = "Display Search Bar:";
$owl_lang->show_pref_title              = "Display Pref/logout Bar:";
$owl_lang->show_bulk_title              = "Display Bulk Buttons:";
$owl_lang->show_action_title            = "Display action Buttons:";
$owl_lang->show_folder_title            = "Display Folder Tools:";
$owl_lang->show_panel                   = "Show";
$owl_lang->hide_panel                   = "Hide";
$owl_lang->status_bar_both              = "Ambedue";
$owl_lang->status_bar_bottom            = "Base";
$owl_lang->status_bar_location          = "Visualizza barra di stato a:";
$owl_lang->status_bar_top               = "Testata";
$owl_lang->status_bar_not               = "Do Not Display";
$owl_lang->use_popup                    = "Usa popup per Notizie:";
$owl_lang->users             		= "Utenti";
$owl_lang->header_user_admin            = "User Administration";
$owl_lang->header_group_admin           = "Group Administration";
$owl_lang->header_sitefeatures_settings           = "Site Features and Settings";

//********************************************************
// admin/index.php  END
//********************************************************


//********************************************************
// admin/log.php  BEGIN
//********************************************************

$owl_lang->owl_log_viewer    	= "Visualizzazione LOG";
$owl_lang->owl_log_hd_action 	= "Azione";
$owl_lang->owl_log_hd_file   	= "File";
$owl_lang->owl_log_hd_fld_path	= "Path Cartella";
$owl_lang->owl_log_hd_user   	= "Utente";
$owl_lang->owl_log_hd_dt_tm  	= "Data Ora";
$owl_lang->owl_log_hd_ip     	= "IP / Indirizzo";
$owl_lang->owl_log_hd_agent  	= "Agente";
$owl_lang->owl_log_hd_dtls   	= "Dettagli";
$owl_lang->owl_log_no_rec    	= " Nessuna Riga Trovata ";
$owl_lang->owl_log_hide      	= "Nascondi: ";
$owl_lang->owl_log_filter    	= "Filtra";

//********************************************************
// admin/log.php  END
//********************************************************


//********************************************************
// admin/recycle.php  BEGIN
//********************************************************

$owl_lang->empty_trash          = "Svuota il Cestino";
$owl_lang->really_empty_trash   = "Vuoi veramente svuotare il Cestino?";
$owl_lang->recycle_bin_admin    = "Amministrazione Cestino";

//********************************************************
// admin/recycle.php  END
//********************************************************


//********************************************************
// lib/owl.lib.php  BEGIN
//********************************************************

$owl_lang->file_size_byte                       = "b";
$owl_lang->file_size_gigabyte                   = "g";
$owl_lang->file_size_kilobyte                   = "k";
$owl_lang->file_size_megabyte                   = "m";
$owl_lang->notif_subject_new 			= "Nuovo File in OWL Intranet ";
$owl_lang->notif_subject_upd 			= "Un File in OWL Intranet &egrave; stato modificato";
$owl_lang->notif_subject_monitor 		= "Un File o Cartella in OWL Intranet che stai monitorando &egrave; stato modificato";
$owl_lang->notif_subject_comment        	= "Un File in OWL Intranet &egrave; stato ";
$owl_lang->notif_comment_1              	= "commentato il";
$owl_lang->notif_comment_2              	= "Commento:";
$owl_lang->notif_msg         			= "MESSAGGIO AUTOMATICO DA OWL Intranet<BR><BR>Verifica il File nuovo/modificato che &egrave; collegato a questa mail<BR><BR>";
$owl_lang->notif_msg_link               = "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet<BR><BR>Find a link to a new/updated file in this E-Mail<BR><BR>";
$owl_lang->notif_msg_alt_link           = "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet\n\nFind a link to a new/updated file in this E-Mail\n\n";
$owl_lang->notif_msg_alt     			= "MESSAGGIO AUTOMATICO DA OWL Intranet\n\nVerifica il File nuovo/modificato che &egrave; collegato a questa mail\n\n";
$owl_lang->notif_salutation             	= "Salve";
$owl_lang->notif_user                   = "Created/Update by:";
$owl_lang->owl_path                     	= "Percorso del File : ";
$owl_lang->sessinuse         			= "Sessione attiva su un altro computer, accesso negato";
$owl_lang->invalidsess       			= "Sessione non valida, collegarsi dalla pagina principale<BR>";
$owl_lang->sesstimeout       			= "Tempo scaduto, ricollegarsi...<BR>";
$owl_lang->everyoneread      			= "Tutti possono leggere/scaricare";
$owl_lang->everyonewrite     			= "Tutti possono leggere/scrivere/scaricare";
$owl_lang->everyonewrite_nod 			= "Tutti possono leggere/scrivere/scaricare, NON CANCELLARE";
$owl_lang->groupread         			= "Il tuo gruppo puo' leggere/scaricare";
$owl_lang->groupwrite        			= "Il tuo gruppo puo' leggere/scrivere/scaricare";
$owl_lang->groupwrite_nod    			= "Il tuo gruppo puo' leggere/scrivere/scaricare, NON CANCELLARE";
$owl_lang->onlyyou           			= "Personale (accesso solo al proprietario)";
$owl_lang->donothing                    	= "Non fare niente &#8211; Lasciare i permessi dei file";
$owl_lang->groupwrite_worldread 		= "Il tuo gruppo puo' leggere/scrivere/scaricare &amp; Tutti possono leggere";
$owl_lang->groupwrite_worldread_nod 		= "Il tuo gruppo puo' leggere/scrivere/scaricare(NON CANCELLARE) &amp; Tutti possono leggere";
$owl_lang->ggroupwrite_worldread 		= "Il tuo gruppo puo' aggiungere files e cancellare questa cartella &amp; Tutti possono accedere ai contenuti";
$owl_lang->ggroupwrite_worldread_nod 		= "Il tuo gruppo puo' aggiungere files a questa cartella &amp; Tutti possono accedere ai contenuti, NON CANCELLARE";
$owl_lang->geveryoneread     			= "Tutti possono leggere la cartella";
$owl_lang->geveryonewrite    			= "Tutti possono scrivere/cancellare files nella cartella";
$owl_lang->geveryonewrite_nod			= "Tutti possono aggiungere files a questa cartella ";
$owl_lang->ggroupread        			= "Gli utenti del gruppo possono leggere";
$owl_lang->ggroupwrite       			= "Gli utenti del gruppo possono scrivere/cancellare";
$owl_lang->ggroupwrite_nod   			= "Il tuo gruppo pu&ograve; aggiungere files a questa cartella ";
$owl_lang->gonlyyou          			= "Accesso personale (solo il proprietario)";
$owl_lang->groupwrite_worldread_ad 		= "Il gruppo selezionato pu&ograve; leggere/scrivere/scaricare &amp; Tutti possono leggere";
$owl_lang->groupwrite_worldread_ad_nod 		= "Il gruppo selezionato pu&ograve; leggere/scrivere/scaricare(NON CANCELLARE) &amp; Tutti possono leggere";
$owl_lang->ggroupwrite_worldread_ad 		= "Il gruppo selezionato pu&ograve; aggiungere files e cancellare questa cartella &amp; Tutti possono accedere ai contenuti";
$owl_lang->ggroupwrite_worldread_ad_nod 	= "Il gruppo selezionato pu&ograve; aggiungere files a questa cartella &amp; Tutti possono accedere ai contenuti, NON CANCELLARE";
$owl_lang->everyoneread_ad   			= "Tutti possono leggere/scaricare";
$owl_lang->everyonewrite_ad  			= "Tutti possono leggere/scrivere/scaricare";
$owl_lang->everyonewrite_ad_nod      		= "Tutti possono leggere/scrivere/scaricare,NON CANCELLARE";
$owl_lang->groupread_ad      			= "Il gruppo selezionato pu&ograve; can leggere/scaricare";
$owl_lang->groupwrite_ad     			= "Il gruppo selezionato pu&ograve; can leggere/scrivere/scaricare";
$owl_lang->groupwrite_ad_nod 			= "Il gruppo selezionato pu&ograve; leggere/scrivere/scaricare,NON CANCELLARE";
$owl_lang->onlyyou_ad        			= "Solo tu puoi leggere/scrivere/scaricare";
$owl_lang->geveryoneread_ad  			= "Tutti possono leggere la cartella";
$owl_lang->geveryonewrite_ad 			= "Tutti possono scrivere/cancellare files nella cartella";
$owl_lang->geveryonewrite_ad_nod     		= "Tutti possono aggiungere files a questa cartella ";
$owl_lang->ggroupread_ad     			= "Gli utenti del gruppo possono leggere";
$owl_lang->ggroupwrite_ad    			= "Gli utenti del gruppo possono scrivere/cancellare";
$owl_lang->ggroupwrite_ad_nod			= "Il gruppo selezionato pu&ograve; aggiungere files a questa cartella ";
$owl_lang->gonlyyou_ad       			= "Accesso personale (solo il proprietario)";
$owl_lang->orphaned                     	= "&#8211; NO Owner  &#8211;";
$owl_lang->virus_infected               = "VIRUS INFECTED FILE";
$owl_lang->virus_return_val             = "Virus Program Return value:";

//********************************************************
// lib/owl.lib.php  END
//********************************************************


//********************************************************
// HREF TITLE messages  BEGIN
//********************************************************

$owl_lang->title_browse_folder          = "Consulta questa Cartella";
$owl_lang->title_browse_site            = "Vai a questo URL";
$owl_lang->title_download_view          = "Scarica  / Visualizza questo File";
$owl_lang->title_edit_prefs             = "Visualizza / Modifica Preferenze";
$owl_lang->title_return_folder          = "Ritorno a ";
$owl_lang->title_sort                   = "Ordina per";
$owl_lang->title_view_new               = "Lista dei nuovi Files dall'ultima visita";
$owl_lang->title_view_updated           = "Lista dei Files aggiornati dall'ultima visita";
$owl_lang->title_view_my                = "Lista dei Miei Files";

//********************************************************
// HREF TITLE messages  END
//********************************************************


//********************************************************
// admin/news.php and newsread.php BEGIN
//********************************************************

$owl_lang->news_title                   = "Gestione Notizie";
$owl_lang->news_hd                      = "Notizie";
$owl_lang->news_hd_created              = "Creata il";
$owl_lang->news_hd_expires              = "Scadenza il";
$owl_lang->news_hd_audience             = "Target ";
$owl_lang->news_heading                 = "Titolo";
$owl_lang->news_content                 = "Contenuto";
$owl_lang->news_posted_date             = "Notizie Inserite il:";
$owl_lang->news_read                    = "Letta";

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

$owl_lang->owl_stats_viewer     = "Statistiche";
$owl_lang->stats_files          = "Numero di Files per Utente";
$owl_lang->stats_folders        = "Numero di Cartelle per Utente";
$owl_lang->stats_top            = "Top 20 downloads";
$owl_lang->stats_users          = "USER Signon (Login / Failure / Logout)";
$owl_lang->stats_users_loggedin = "Currently Logged In";
$owl_lang->stats_information    = "Owl Logging and File logging devono essere attivi per avere questi dati";

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
