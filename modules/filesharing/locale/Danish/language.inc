<?php

/*

  File: Danish/language.inc
  Author: Chris
  Date: 2000/12/14

  Owl: Copyright Chris Vincent <cvincent@project802.net>

  You should have received a copy of the GNU Public
  License along with this package; if not, write to the
  Free Software Foundation, Inc., 59 Temple Place - Suite 330,
  Boston, MA 02111-1307, USA.

  updated    :           2003/04/13 by breiner@myrealbox.com
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

$owl_lang->charset = "UTF-8";

//********************************************************
// Date Formating BEGIN
//********************************************************

//********************************************************
// Error Messages BEGIN
//********************************************************

$owl_lang->err_select_reviewer          = "Please select at least one Person to review your document";
$owl_lang->err_adding_comments          = "Du har ikke tilladelse til at tilf&oslash;je kommentarer til denne fil";
$owl_lang->err_comment_empty            = "Comment cannot be empty";
$owl_lang->err_backup_file   		= "Fejl under oprettelse af sikkerhedskopi for eksisterende fil";
$owl_lang->err_backup_folder_create 	= "Kunne ikke oprette Sikkerhedskopimappe";
$owl_lang->err_bad_url                  = "Please enter a valid URL";
$owl_lang->err_bad_version_1 		= "Owl Intranet Kr&aelig;ver som en minimum PHP Version";
$owl_lang->err_bad_version_2 		= "Du k&oslash;rer Version";
$owl_lang->err_bad_version_3 		= "Installer en nyere version af php og pr&oslash;v igen";
$owl_lang->err_email         		= "Beskeden kunne ikke sendes";
$owl_lang->err_email_required           = "Email felt er kr&aelig;vet";
$owl_lang->err_fexist1                  = "<b>Fil eksistere:</b>";
$owl_lang->err_fexist2                  = "Der er allerede en fil af dette navn <i>";
$owl_lang->err_fexist3                  = "</i> i denne mappe.";
$owl_lang->err_file_exists              = "Filen du pr&oslash;ver at sende eksisterer allerede";
$owl_lang->err_fileexists    		= "Flyting blev annuleret<BR>Fil med samme navn eksisterer allerede.";
$owl_lang->err_file_lock     		= "Du kan ikke l&aring;se denne fil, da den for &oslash;jeblikket er l&aring;st af";
$owl_lang->err_update_file_lock         = "You cannot update this file, it is currently held by";
$owl_lang->err_filemove_exist           = "The filename you are trying to rename this file to already exists";
$owl_lang->err_file_not_exist           = "Fil eksisterer ikke p&aring; filsystemet";
$owl_lang->err_file_too_big             = "php.ini upload_max_filesize overskredet og/eller<BR>Overskredet Owl Max Upload file size";
$owl_lang->err_file_update		= "Opdatering af en fil kr&aelig;ver at filnavnet er u&aelig;ndret, pr&oslash;v igen med at bruge det samme filnavn";
$owl_lang->err_folder_create 		= "Kunne ikke at oprette mappen";
$owl_lang->err_folder_exist		= "Denne mappe findes allerede";
$owl_lang->err_folderexists  		= "Omd&oslash;b blev annuleret<BR>Mappe med det samme navn eksisterer.";
$owl_lang->err_general 			= "Der er opst&aring;et en fejl";
$owl_lang->err_group_delete             = "Du kan ikke slette en gruppe der har medlemmer";
$owl_lang->err_group_exists             = "Der er allerede en gruppe med dette navn.";
$owl_lang->err_gzip_not_found           = "gzip blev ikke fundet i ";
$owl_lang->err_login   			= "Venligst log ind for at udf&oslash;re denne aktion";
$owl_lang->err_movecancel    		= "Flyting blev annuleret<BR>";
$owl_lang->err_nameempty     		= "Mappens navn kan ikke v&aelig;re tom";
$owl_lang->err_news_required            = "FEJL: Nyheds Heading og indhold er kr&aelig;vet!";
$owl_lang->err_no_access                = "Du har ikke adgang til nogen af de filer som er valgt";
$owl_lang->err_no_access_info           = "Possible causes: <br></br>1) You did not click any checkbox in front of a File or Folder<br></br>2) Bulk Delete, Bulk Email, Bulk Checkout do not apply to Folders<br></br>3) You do not have access to any of the files or folders you have selected.";
$owl_lang->err_noemail                  = "Du har ikke adgang til at sende denne fil via e-mail";
$owl_lang->err_nofileaccess		= "Du har ikke adgang til denne fil";
$owl_lang->err_nofiledelete             = "Du har ikke adgang til at slette denne fil";
$owl_lang->err_nofilemod                = "Du har ikke adgang til at rette denne fil";
$owl_lang->err_nofolderaccess		= "Du har ikke adgang til denne mappe";
$owl_lang->err_nofolderdelete           = "Du har ikke adgang til at slette denne mappe";
$owl_lang->err_nofoldermod              = "Du har ikke adgang til at modificere denne mappe";
$owl_lang->err_nosubfolder              = "Du har ikke adgang til at oprette undermapper her";
$owl_lang->err_note_title               = "Titlen er kr&aelig;vet felt";
$owl_lang->err_note_title_exists        = "Et notat med dette navn eksistere allerede";
$owl_lang->err_noupload                 = "Du har ikke adgang til at sende til denne mappe";
$owl_lang->err_pass_missmatch		= "Nyt password og bekr&aelig;ftet password er ikke identiske";
$owl_lang->err_pass_wrong    		= "Det gamle password er forkert";
$owl_lang->err_pod2html_not_found       = "ERROR: The pod2html tool was not found:";
$owl_lang->err_quota			= "Du har ikke nok plads nok tilbage i den kvote, til at uploade denne fil: ";
$owl_lang->err_quota_needed		= " n&oslash;dvendig ";
$owl_lang->err_quota_avail		= " tilg&aelig;ngelig.";
$owl_lang->err_quota_exceed  		= "Du har overskridt over din kvote";
$owl_lang->err_req                      = "FEJL: alle felter er kr&aelig;vet";
$owl_lang->err_root_delete              = "The Root Folder cannot be deleted";
$owl_lang->err_sess_notvalid 		= "Sessions id er ikke gyldig";
$owl_lang->err_sess_write		= "Der opstod en fejl ved skriving af sessionsinformation til databasen";
$owl_lang->err_specialfoldername        = "'backup' er et reserveret mappe navn, v&aelig;lg venligst et andet navn";
$owl_lang->err_tar_not_found    	= "tar blev ikke fundet i ";
$owl_lang->err_trash_can_empty          = "Skaldespanden er tom";
$owl_lang->err_unauthorized  		= "Ikke tilladt";
$owl_lang->err_unauth_area   		= "Du har ikke tilladelse til at bruge dette omr&aring;de";
$owl_lang->err_upload 			= "Upload fejl";
$owl_lang->err_user_exists		= "Brugernavn eksisterer allerede";
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
$owl_lang->alt_add_comments     = "Tilf&oslash;j en kommentar til denne fil";
$owl_lang->alt_btn_add_file     = "Send en ny fil";
$owl_lang->alt_btn_add_folder   = "Opret en ny mappe";
$owl_lang->alt_add_group        = "Opret denne gruppe";
$owl_lang->alt_add_news         = "Add a New News Item";
$owl_lang->alt_btn_add_note     = "Add a New Note";
$owl_lang->alt_add_user         = "Opret denne bruger";
$owl_lang->alt_btn_add_url      = "Opret en ny Web link";
$owl_lang->alt_cancel           = "Cancle This Action";
$owl_lang->alt_cancel_move      = "Afbryd flytte aktion";
$owl_lang->alt_change           = "Opdater denne post";
$owl_lang->alt_btn_clickhere    = "Klik her";
$owl_lang->alt_btn_collapse_view= "Skift til reduceret oversigt";
$owl_lang->alt_comments         = "Kommentar(er) er tilknyttet denne fil";
$owl_lang->alt_del_comments     = "Slet denne kommentar";
$owl_lang->alt_del_file         = "Slet fil (J/N)";
$owl_lang->alt_del_folder       = "Slet denne mappe (J/N)";
$owl_lang->alt_del_group        = "Slet denne gruppe";
$owl_lang->alt_del_news         = "Delete This News";
$owl_lang->alt_del_selected     = "Slet alle valgte filer";
$owl_lang->alt_del_all          = "Empty Trash";
$owl_lang->alt_rest_selected    = "Restore all Selected Files";
$owl_lang->alt_del_this_folder  = "Slet mapper &#8211; ";
$owl_lang->alt_del_user         = "Slet denne bruger";
$owl_lang->alt_edit_group       = "Rediger den valgte gruppe";
$owl_lang->alt_edit_news        = "Edit This News";
$owl_lang->alt_edit_user        = "Rediger den valgte bruger";
$owl_lang->alt_email            = "Email denne fil";
$owl_lang->alt_email_selected   = "Email alle valgte filer";
$owl_lang->alt_btn_expand_view  = "Skift til udvidet oversigt";
$owl_lang->alt_admin_flush      = "T&oslash;m Stale/udl&oslash;bet sessions";
$owl_lang->alt_get_file         = "Hent fil";
$owl_lang->alt_get_folder       = "Download Folder Content";
$owl_lang->alt_have_news        = "Der er nyhed(er) til dig";
$owl_lang->alt_have_no_news     = "Ingen nye nyhed(er) til dig";
$owl_lang->alt_home_folder      = "Back to Intial Dir ";
$owl_lang->alt_set_initial_dir  = "Set Current Dir as Initial";                                                                                                
$owl_lang->alt_site_map         = "Site Map";
$owl_lang->alt_lock_file        = "L&aring;s filen";
$owl_lang->alt_log_clear        = "Delete all Logs (Y/N)";
$owl_lang->alt_log_file         = "Fil Log";
$owl_lang->alt_log_next         = "Vis n&aelig;ste poster";
$owl_lang->alt_log_prev         = "Vis forg&aring;ende poster";
$owl_lang->alt_log_top          = "G&aring; til den f&oslash;rst post";
$owl_lang->alt_btn_login        = "Log ind til intranet-server";
$owl_lang->alt_btn_logout       = "Log ud fra intranet-server";
$owl_lang->alt_btn_help         = "Owl Online Help";
$owl_lang->alt_mod_file         = "Ret p&aring; filegenskaber";
$owl_lang->alt_mod_folder       = "Ret p&aring; mappeegenskaber";
$owl_lang->alt_move_file        = "Flyt fil";
$owl_lang->alt_copy_file        = "Copy File";
$owl_lang->alt_link_file        = "Link This File to Another Directory";
$owl_lang->alt_move_folder      = "Flyt mappe";
$owl_lang->alt_copy_folder      = "Copy Folder";
$owl_lang->alt_move_selected    = "Flyt alle valgte filer";
$owl_lang->alt_admin_groups     = "Opret en ny gruppe";
$owl_lang->alt_news_close       = "Luk nyheds vinduet";
$owl_lang->alt_news_next        = "Vis n&aelig;ste nyhed";
$owl_lang->alt_news_prev        = "Vis forg&aring;ende nyhed";
$owl_lang->alt_news_print       = "Udskriv denne nyhed";
$owl_lang->alt_admin_users      = "Opret en ny bruger";
$owl_lang->alt_monitor          = "Overv&aring;g denne fil";
$owl_lang->alt_monitored        = "Stop overv&aring;gning af denne fil";
$owl_lang->alt_btn_admin        = "Administration";
$owl_lang->alt_play_file        = "Play Media fil";
$owl_lang->alt_recycle          = "Din skaldespand er tom";
$owl_lang->alt_recycle_disable  = "Trash indsamling er blevet sl&aring;et fra";
$owl_lang->alt_recycle_not_found= "Skaldespandens placering ikke fundet";
$owl_lang->alt_refresh_filter   = "Start filtrering / Opfrisk resultater";
$owl_lang->alt_register         = "Godkend din registrering";
$owl_lang->alt_btn_browse	= "Retur til dokument oversigt";
$owl_lang->alt_search           = "Start s&oslash;gningen";
$owl_lang->alt_send_email       = "Send emailen";
$owl_lang->alt_sendfile         = "Send filen";
$owl_lang->alt_toggle_check_box = "Check Bokse til/fra";
$owl_lang->alt_unlock_file      = "L&aring;s fil op";
$owl_lang->alt_upd_file         = "Opdater fil";
$owl_lang->alt_view_comments    = "Tilf&oslash;j/Se fil kommentarer";
$owl_lang->alt_view_file        = "Se fil";
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

$owl_lang->log_login_det        = "Brugernavn: ";
$owl_lang->log_filter_all       = "ALLE";
$owl_lang->log_file_to          = "TIL: ";
$owl_lang->log_detail           = "Ingen andre detaljer";
$owl_lang->log_del_det          = "Hele indhold er ogs&aring; blevet slettet";
$log_file_actions[1]            = "LOG IND";
$log_file_actions[2]            = "LOG IND FEJLET";
$log_file_actions[3]            = "LOG UD";
$log_file_actions[4]            = "FIL SLETTET";
$log_file_actions[5]            = "FIL SENDT";
$log_file_actions[6]            = "FIL OPDATERET";
$log_file_actions[7]            = "FIL HENTET";
$log_file_actions[8]            = "FIL &AElig;NDRET";
$log_file_actions[9]            = "FIL L&Aring;ST";
$log_file_actions[10]           = "FIL &Aring;BEN";
$log_file_actions[11]           = "FIL EMAILET";
$log_file_actions[12]           = "FIL FLYTTET";
$log_file_actions[13]           = "MAPPE OPRETTET";
$log_file_actions[14]           = "MAPPE SLETTET";
$log_file_actions[15]           = "MAPPE &AElig;NDRET";
$log_file_actions[16]           = "MAPPE FJERNET";
$log_file_actions[17]           = "GLEMT KODE";
$log_file_actions[18]           = "BRUGER REG";
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

$owl_lang->anonymous            = "(Anonym adgang)";
$owl_lang->repository_list      = "Repository:";
$owl_lang->engine               = "powered by Owl Intranet";
$owl_lang->forgot_pass          = "Glemt dit kodeord?";
$owl_lang->like_register        = "Vil gerne registere?";
$owl_lang->login                = "Log af";
$owl_lang->loginfail            = "Der opstod en fejl under login";
$owl_lang->logindisabled        = "Kontoen er blevet DEAKTIVERET, Kontakt systemadministrator";
$owl_lang->password             = "Kodeord";
$owl_lang->successlogout        = "Du er logget af";
$owl_lang->toomanysessions      = "Maximum sessions for bruger n&aring;et, kontakt system administratoren";
$owl_lang->username             = "Brugernavn";
$owl_lang->version              = "Version";

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
$owl_lang->actions                      = "Valg";
$owl_lang->del_selected                 = "Slet valgte";
$owl_lang->del_all                      = "Empty Trash";
$owl_lang->rest_selected                = "Restore Selected";
$owl_lang->disk_quota                   = "Disk Quota";
$owl_lang->email_selected               = "Email valgt";
$owl_lang->file                         = "Fil";                                                                                                                      
$owl_lang->folder_policy                = "Current Folder Policy:";
$owl_lang->current_folder               = "Current Folder:";
$owl_lang->held                         = "L&aring;s"; // for version control
$owl_lang->last_logged                  = "Sidst logget: ";
$owl_lang->current_db                   = "Current Repository:";
$owl_lang->modified                     = "&AElig;ndret";
$owl_lang->move_selected                = "Flyt valgte";
$owl_lang->new_file                     = "Ny!";
$owl_lang->no_description               = "Ingen beskrivelse tilg&aelig;ngelig";
$owl_lang->page                         = "Page:";
$owl_lang->postedby                     = "Tilf&oslash;jet af";
$owl_lang->reallydelete                 = "Er du sikker p&aring; at du vil slette?";
$owl_lang->reallydelete_logs            = "Really Clear the Log File";
$owl_lang->reallydelete_selected        = "Vil du virkelig slette alle valgte filer";
$owl_lang->reallyrestore_selected       = "Really Restore all selected files";
$owl_lang->size                         = "St&oslash;rrelse";
$owl_lang->score                        = "Score";
$owl_lang->title                        = "Titel";
$owl_lang->doc_number                   = "Doc #";
$owl_lang->tot_files                    = "Total:";                                                                                         
$owl_lang->tot_my_checked_out           = "Checked Out:";
$owl_lang->tot_my_files                 = "Min:";
$owl_lang->tot_my_group                 = "Group:";
$owl_lang->tot_new_files                = "Ny(e):";
$owl_lang->tot_updated_files            = "Opdateret:";
$owl_lang->tot_monitored                = "Monitored:";
$owl_lang->updated_file                 = "Opdateret!";
$owl_lang->user                         = "Bruger";
$owl_lang->ver                          = "Ver."; // for version control
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
$owl_lang->adding_comments      = "Tilf&oslash;j / Se kommentar: ";
$owl_lang->comments             = "Comment";
$owl_lang->post_comment         = "Post Comment";
$owl_lang->addingfile           = "Opretter en fil i ";
$owl_lang->addingfolder         = "Opretter en mappe i ";
$owl_lang->attach_file          = "Vedh&aelig;ft fil";
$owl_lang->change               = "&AElig;ndre";
$owl_lang->create               = "Opret";
$owl_lang->comments_added       = "Kommentar tilf&oslash;jet af: ";
$owl_lang->description          = "Beskrivelse";
$owl_lang->email_body           = "Besked";
$owl_lang->email_cc             = "CC";
$owl_lang->email_reply_to       = "Svar til";
$owl_lang->email_subject        = "Emne";
$owl_lang->email_to             = "Send til";
$owl_lang->emailing             = "Sender e-mail";
$owl_lang->disp_mp3             = "MP3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Song:<BR>Album:<BR>Bitrate&nbsp;-&nbsp;Samplerate:<BR>Duration:<BR>Genre:<BR>Comments:";
$owl_lang->keywords             = "N&oslash;gle ord";
$owl_lang->modify_url           = "URL";
$owl_lang->modifying            = "&AElig;ndrer ";
$owl_lang->name                 = "Navn";                                                                                                                                                   
$owl_lang->notify_link          = "Owl External Link";
$owl_lang->note_content         = "Notat indhold";
$owl_lang->ownergroup           = "Ejer (Gruppe)";
$owl_lang->ownership            = "Ejer";
$owl_lang->permissions          = "Tilladelse";                                                                                                                        
$owl_lang->prop_permissions     = "Propagate Permissions to subfolders?";
$owl_lang->prop_perms_files     = "Permissions to propagate to files:";
$owl_lang->policy               = "Sikkerhedsregler";
$owl_lang->pick_select          = "&#8212; Select an Owl User &#8212;";
$owl_lang->sendfile             = "Send Fil";
$owl_lang->sendthisfile         = "Send denne fil";
$owl_lang->sendthisurl          = "Send this URL";
$owl_lang->updating             = "Opdaterer";
$owl_lang->verdescription       = "Beskrivelse<br></br>af &aelig;ndringer";
$owl_lang->vermajor             = "Overordnet revision";
$owl_lang->verminor             = "Underordnet revision";
$owl_lang->vertype              = "Revision ";  // for modify.php when uploading

//********************************************************
// modify.php  END
//********************************************************


//********************************************************
// register.php  BEGIN
//********************************************************
                                                                                                       
$owl_lang->email                = "E-mail Adresse";
$owl_lang->full_name            = "Fuld navn";
$owl_lang->register             = "Bruger registrering";
$owl_lang->self_failed          = "Fejlet";
$owl_lang->self_passwd          = "Kodeord sendt til:";
$owl_lang->self_reg_bod         = "Dit kodeord er:";
$owl_lang->self_reg_rset        = "Dit kodeord er blevet sat til:";
$owl_lang->self_reg_subj        = "Din konto";
$owl_lang->send_pass            = "Send kodeord";
$owl_lang->submit               = "Register";
$owl_lang->thank_you_1          = "Tak!";
$owl_lang->thank_you_2          = "En email vil blivee sendt til din email adresse <BR> med det NYE kodeord for <BR><b>BRUGER:</b>";

//********************************************************
// register.php  END
//********************************************************


//********************************************************
// move.php  BEGIN
//********************************************************

$owl_lang->cancel_button     = "Afbryd";
$owl_lang->moving            = "Flytter";
$owl_lang->moving_file          = "Moving file";
$owl_lang->moving_folder        = "Moving Folder";
$owl_lang->copy_file            = "Copying file";
$owl_lang->copy_folder          = "Copying Folder";
$owl_lang->select            = "V&aelig;lg venligst en anden mappe:";

//********************************************************
// move.php  END
//********************************************************


//********************************************************
// log.php  BEGIN
//********************************************************

$owl_lang->viewlog           = "Ser loggen for ";

//********************************************************
// log.php  END
//********************************************************


//********************************************************
// prefs.php  BEGIN
//********************************************************

$owl_lang->confpassword = "Bekr&aelig;ft nyt kodeord";
$owl_lang->comment_notif= "Kommentar Notification";
$owl_lang->email_tool   = "E-Mail Tool";
$owl_lang->last_modified= "Last Modified";
$owl_lang->group        = "Hovedgruppe";
$owl_lang->groupmember  = "Medlemsgruppe";
$owl_lang->newpassword  = "Nyt kodeord";
$owl_lang->newsadmin    = "Nyhed administrator";
$owl_lang->not_member   = "Du er ikke medlem af andre grupper";
$owl_lang->notification = "Modtag besked";
$owl_lang->oldpassword  = "Gammelt kodeord";
$owl_lang->preference   = "Indstillnger";
$owl_lang->saved        = "&AElig;ndringer er gemt";
$owl_lang->status_no    = "NEJ";
$owl_lang->status_yes   = "JA";
$owl_lang->userlang     = "Sprog";

//********************************************************
// prefs.php  END
//********************************************************


//********************************************************
// search.php  BEGIN
//********************************************************

$owl_lang->elapsed_time         = "elapsed time";
$owl_lang->search             	= "S&oslash;g";
$owl_lang->search_any_word      = "Any Words";
$owl_lang->search_all_word      = "All Words";
$owl_lang->search_entire_phrase = "Entire Phrase";
$owl_lang->search_match         = "Match:";
$owl_lang->search_currentfolder = "Search Current Folder";
$owl_lang->search_for_folders   = "Searching For Folders";
$owl_lang->search_for_files     = "Searching For Files";
$owl_lang->search_score         = "Scoring Files";
$owl_lang->search_results_for 	= "S&oslash;geresultat for";
$owl_lang->search_winthindocs   = "Search Within (text, pdf & MS-WORD) Documents";
$owl_lang->related_query_empty  = "No metadata associated with document to perform 'Search Related'";
$owl_lang->query_empty        	= "Tom s&oslash;gestreng";

//********************************************************
// search.php  END
//********************************************************


//********************************************************
// view.php  BEGIN
//********************************************************

$owl_lang->viewing           = "Viewing ";

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
$owl_lang->add                          = "Tilf&oslash;j";
$owl_lang->anonymous_account            = "Anonym adgang konto:";                                                                                                                      
$owl_lang->buttonstyle                  = "Button Style";
$owl_lang->deletegroup                  = "Slet gruppe";
$owl_lang->deleteuser                   = "Slet bruger";
$owl_lang->disableuser                  = "Deaktiveret?";
$owl_lang->disable_recs_per_page        = "Enabling Restricted View Will DISABLE Records Per Page!";
$owl_lang->file_admin_group             = "Fil/Browser admin Gruppe:";
$owl_lang->flushed                      = "Session tabel t&oslash;mt, bruger kan nu logge ind igen.<BR>";
$owl_lang->groups                       = "Grupper";
$owl_lang->hide_bulk_buttons            = "Skjul bulk knapper:";
// Edit HTML Properties Messages
$owl_lang->ht_tbl_border_sz             = "Tabel kant str.:";
$owl_lang->ht_tbl_hd_bg                 = "Header baggrund:";
$owl_lang->ht_tbl_cell_bg_cl            = "Tabel celle baggrund farve:";
$owl_lang->ht_tbl_cell_bg_al            = "Tabel celle baggrund farve Alternativ:";
$owl_lang->ht_expand_width              = "Udvidet view bredde:";
$owl_lang->ht_collapse_width            = "Sammenfoldet view bredde:";
$owl_lang->ht_bd_bg_image               = "Body baggrund billede sti:";
$owl_lang->ht_bd_txt_cl                 = "Body Tekst farve:";
$owl_lang->ht_bd_lnk_cl                 = "Body Link farve:";
$owl_lang->ht_bd_vlnk_cl                = "Body bes&oslash;gt Link farve:";
// Edit Prefs Properties Messages
$owl_lang->home_dir                     = "User's Home Directory";
$owl_lang->initial_dir                  = "User's Initial Directory";
$owl_lang->maxsessions                  = "Maks antal sessions";
$owl_lang->noprefaccess                 = "Sl&aring; Pref fra";
$owl_lang->owl_anon_full                = "Full Access";
$owl_lang->owl_anon_ro                  = "S&aelig;t anonyme til 'l&aelig;s kun':";
$owl_lang->owl_anon_download            = "Download Only";
$owl_lang->anonymous_access             = "Set Anonymous Access";
$owl_lang->owl_dbdump_path              = "DB dump v&aelig;rkt&oslash;j sti:";
$owl_lang->owl_def_file_group_owner     = "Default fil gruppe ejer:";
$owl_lang->owl_def_file_meta            = "Default fil meta data:";
$owl_lang->owl_def_file_owner           = "Default fil ejer:";
$owl_lang->owl_def_file_perm            = "Default fil oprettelse politik:";
$owl_lang->owl_def_file_security        = "Default fil sikkerhed:";
$owl_lang->owl_def_file_title           = "Default fil titel (blank for filenavnet):";
$owl_lang->owl_def_fold_group_owner     = "Default mappe gruppe ejer:";
$owl_lang->owl_def_fold_owner           = "Default mappe ejer:";
$owl_lang->owl_def_fold_sec             = "Default mappe sikkerhed:";
$owl_lang->owl_def_folder_perm          = "Default mappe oprettelse politik:";
$owl_lang->owl_default_tmpdir           = "Temp fil mappe placering: ";
$owl_lang->owl_email_from               = "Email fra-adresse:";
$owl_lang->owl_email_fromname           = "Email fra-navn:";
$owl_lang->owl_email_replyto            = "Email svar-til adresse:";
$owl_lang->owl_email_server             = "Email Delivery server adresse:";
$owl_lang->owl_email_smtp               = "Use SMTP Mailing Method";
$owl_lang->owl_email_smtp_auth          = "Use SMTP Auth";
$owl_lang->owl_email_smtp_auth_login    = "SMTP Auth Login:";
$owl_lang->owl_email_smtp_auth_passwd   = "SMTP Auth Password";
$owl_lang->owl_email_subject_pref       = "Email emne prefix:";
$owl_lang->owl_fogotpass                = "Vis glemt kodeord link:";
$owl_lang->owl_group_user               = "Brugere som er medlemmer af denne gruppe";
$owl_lang->owl_gzip_path                = "Gzip sti:";
$owl_lang->owl_hidebackup               = "Skjul backup mappen:";
$owl_lang->owl_log_file                 = "Log fil aktiviteter:";
$owl_lang->owl_log_login_act            = "Log log ind/log ud aktiviteter:";
$owl_lang->owl_log_rec_page             = "Log viewer poster pr side:";
$owl_lang->owl_logging                  = "Sl&aring; logging til:";
$owl_lang->owl_logo                     = "Login side logo ([sprog]/grafik):";
$owl_lang->owl_lookAtHD                 = "Sl&aring; [SE P&Aring; HD FOR NYE FILER] fra:";
$owl_lang->owl_lookAtHDDel              = "Fjern slettet filer fra DB:";
$owl_lang->hide_folder_doc_count        = "Hide Folder File Type Count";                                                                                                                        
$owl_lang->hide_folder_size             = "Hide Folder Content Size";
$owl_lang->old_action_icons             = "Use pre Owl 0.80 Action Icons";
$owl_lang->search_result_folders        = "Include Folders in Search Results";
$owl_lang->restore_file_prefix          = "String Prefixed to Restored Files";
$owl_lang->owl_max_filesize             = "Maks. send fil str.:";
$owl_lang->owl_owl_expand               = "Default browser view (udvid):";
$owl_lang->owl_owl_timeout              = "Session tidsudl&oslash;b i sekunder:";
$owl_lang->virus_path                   = "Virus Checking Software Path<br />Example: '/usr/bin/clamscan --quiet' <br />&#8211; Blank for Disabled:";
$owl_lang->owl_pdftotext_path           = "Maintain Search Index for <BR>PDF and text Files <BR>&#8211; Blank for Disabled:";
$owl_lang->owl_wordtotext_path          = "MS-WORD Files <BR>&#8211; Blank for Disabled:";
$owl_lang->owl_pod2html_path            = "Perl 5.8.0 or Greater required<BR>Path to pod2html:";
$owl_lang->owl_restrict_view            = "Sl&aring; restriktet View feature til:";
$owl_lang->owl_self_reg                 = "Sl&aring; selv registrering til:";
$owl_lang->owl_self_reg_hd              = "SELV REGISTERET BRUGER DEFAULTS";
$owl_lang->owl_tar_path                 = "Tar sti:";
$owl_lang->owl_title_custom             = "CUSTOMIZE BROWSER COLUMNS";
$owl_lang->owl_title_custom_search      = "CUSTOMIZE SEARCH RESULTS";
$owl_lang->owl_title_browser            = "DOKUMENT OVERSIGT FEATURES";
$owl_lang->owl_title_defaults           = "DEFAULTS";
$owl_lang->owl_title_email              = "EMAIL INDSTILLINGER";
$owl_lang->owl_title_HD                 = "[SE P&Aring; HD FOR NYE FILER] INDSTILLINGER";
$owl_lang->owl_title_logging            = "LOGGING INDSTILLINGER";
$owl_lang->owl_title_other              = "ANDRE INDSTILLINGER";
$owl_lang->owl_title_tools              = "DB BACKUP/GZIP V&AElig;RKTØJ";
$owl_lang->owl_unzip_path               = "Unzip sti:";
$owl_lang->owl_version_control          = "Sl&aring; version kontrol feature til:";
$owl_lang->quota                        = "Kvote 0=sl&aring;et fra";
$owl_lang->reallydeluser                = "This user is owner of %numfiles% File(s) and %numfolders% Folder(s). These File(s) and Folder(s) will be orphaned. Is it Still Ok to Delete?";
$owl_lang->recs_per_page                = "Display Records Per Page (0 = Disabled):";
$owl_lang->remember_me_title            = "PERSISTENT LOGIN SETTINGS";
$owl_lang->remember_me                  = "Show the Remember Me link";
$owl_lang->remember_timeout             = "Cookie timeout in Days";
$owl_lang->remember_me_checkbox         = "Remember me";
$owl_lang->recycle_title                = "TRASH COLLECTION INDSTILLINGER";
$owl_lang->recycle_enabled              = "Sl&aring; Trash indsamling til:";
$owl_lang->recycle_location             = "Skaldespand placering:";
$owl_lang->show_panel_title             = "Display Status Panel:";
$owl_lang->show_search_title            = "Display Search Bar:";
$owl_lang->show_pref_title              = "Display Pref/logout Bar:";
$owl_lang->show_bulk_title              = "Display Bulk Buttons:";
$owl_lang->show_action_title            = "Display action Buttons:";
$owl_lang->show_folder_title            = "Display Folder Tools:";
$owl_lang->show_panel                   = "Show";
$owl_lang->hide_panel                   = "Hide";
$owl_lang->status_bar_both              = "Begge";
$owl_lang->status_bar_bottom            = "Bund";
$owl_lang->status_bar_location          = "Vis status baren i:";
$owl_lang->status_bar_top               = "Top";
$owl_lang->status_bar_not               = "Do Not Display";
$owl_lang->use_popup                    = "brug popup for at vise nyheder:";
$owl_lang->users                        = "Brugere";
$owl_lang->header_user_admin            = "User Administration";
$owl_lang->header_group_admin           = "Group Administration";
$owl_lang->header_sitefeatures_settings           = "Site Features and Settings";

//********************************************************
// admin/index.php  END
//********************************************************


//********************************************************
// admin/log.php  BEGIN
//********************************************************

$owl_lang->owl_log_viewer       = "LOG Viewer";
$owl_lang->owl_log_hd_action    = "Aktion";
$owl_lang->owl_log_hd_file      = "Fil";
$owl_lang->owl_log_hd_fld_path  = "Sti";
$owl_lang->owl_log_hd_user      = "Bruger";
$owl_lang->owl_log_hd_dt_tm     = "Dato/Tid";
$owl_lang->owl_log_hd_ip        = "IP/Adr.";
$owl_lang->owl_log_hd_agent     = "Agent";
$owl_lang->owl_log_hd_dtls      = "Detaljer";
$owl_lang->owl_log_no_rec       = " INGEN POSTER FUNDET ";
$owl_lang->owl_log_hide         = "Skjul: ";
$owl_lang->owl_log_filter       = "Filter";

//********************************************************
// admin/log.php  END
//********************************************************


//********************************************************
// admin/recycle.php  BEGIN
//********************************************************

$owl_lang->empty_trash          = "T&oslash;m skaldespand";
$owl_lang->really_empty_trash   = "Vil du virkelig t&oslash;mme skaldespanden?";
$owl_lang->recycle_bin_admin    = "Skaldespand Administration";

//********************************************************
// admin/recycle.php  END
//********************************************************


//********************************************************
// lib/owl.lib.php  BEGIN
//********************************************************

$owl_lang->file_size_byte               = "b";
$owl_lang->file_size_gigabyte           = "g";
$owl_lang->file_size_kilobyte           = "k";
$owl_lang->file_size_megabyte           = "m";
$owl_lang->notif_subject_new            = "Ny intranet-server fil";
$owl_lang->notif_subject_upd            = "En intranet-server fil blev opdateret";
$owl_lang->notif_subject_monitor        = "En intranet-server fil eller mappe som du overv&aring;ger er blevet opdateret";
$owl_lang->notif_subject_comment        = "En intranet-server fil -- kommentar tilf&oslash;jet";
$owl_lang->notif_comment_1              = "har tilf&oslash;jet en kommentar til";
$owl_lang->notif_comment_2              = "Kommentar:";
$owl_lang->notif_msg                    = "Dette er en automatiseret besked fra intranet-server<BR><BR>Tryk p&aring; linket nedenfor for at se den nye/opdaterede fil<BR><BR>";
$owl_lang->notif_msg_link               = "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet<BR><BR>Find a link to a new/updated file in this E-Mail<BR><BR>";
$owl_lang->notif_msg_alt_link           = "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet\n\nFind a link to a new/updated file in this E-Mail\n\n";
$owl_lang->notif_msg_alt                = "Dette er en automatiseret besked fra intranet-server\n\nTryk p&aring; linket nedenfor for at se den nye/opdaterede fil\n\n";
$owl_lang->notif_salutation             = "Hej";
$owl_lang->notif_user                   = "Created/Update by:";
$owl_lang->owl_path                     = "Fil sti: ";
$owl_lang->sessinuse                    = "Denne session er i brug p&aring; en anden computer, ingen adgang<BR>";
$owl_lang->invalidsess                  = "Sessions id er ikke gyldig, log p&aring; fra hovedsiden<BR>";
$owl_lang->sesstimeout                  = "Den session har for&aring;rsaget tidsudl&oslash;b,venligst log p&aring; igen<BR>";
$owl_lang->everyoneread                 = "Alle kan l&aelig;se/hente";
$owl_lang->everyonewrite                = "Alle kan l&aelig;se/skrive/hente";
$owl_lang->everyonewrite_nod            = "Alle kan l&aelig;se/skrive/hente, IKKE SLETTE";
$owl_lang->groupread                    = "Din gruppe kan l&aelig;se/hente";
$owl_lang->groupwrite                   = "Din gruppe kan l&aelig;se/skrive/hente";
$owl_lang->groupwrite_nod               = "Din gruppe kan l&aelig;se/skrive/hente, IKKE SLETTE";
$owl_lang->onlyyou                      = "Kun du kan l&aelig;se/skrive/hente";                                                                                
$owl_lang->donothing                    = "Do nothing &#8211; Leave file permissions alone";
$owl_lang->groupwrite_worldread         = "Din gruppe kan l&aelig;se/skrive/hente og alle kan l&aelig;se";
$owl_lang->groupwrite_worldread_nod     = "Din gruppe kan l&aelig;se/skrive/hente (IKKE SLETTE) og alle kan l&aelig;se";
$owl_lang->ggroupwrite_worldread        = "Din gruppe kan sende filer og slette mappen og alle kan se indholdet";
$owl_lang->ggroupwrite_worldread_nod    = "Din gruppe kan sende filer til mappen og alle kan se indhold, IKKE SLETTE";
$owl_lang->everyoneread_ad              = "Alle kan l&aelig;se/hente";
$owl_lang->everyonewrite_ad             = "Alle kan l&aelig;se/skrive/hente";
$owl_lang->everyonewrite_ad_nod         = "Alle kan l&aelig;se/skrive/hente, IKKE SLETTE";
$owl_lang->groupread_ad                 = "Den valgte gruppe kan l&aelig;se/hente";
$owl_lang->groupwrite_ad                = "Den valgte gruppe kan l&aelig;se/skrive/hente";
$owl_lang->groupwrite_ad_nod            = "Den valgte gruppe kan l&aelig;se/skrive/hente, IKKE SLETTE";
$owl_lang->onlyyou_ad                   = "Kun du kan l&aelig;se/skrive/hente";
$owl_lang->groupwrite_worldread_ad      = "Den valgte gruppe kan l&aelig;se/skrive/hente og alle kan l&aelig;se";
$owl_lang->groupwrite_worldread_ad_nod  = "Den valgte gruppe kan l&aelig;se/skrive/hente,(IKKE SLETTE) og alle kan l&aelig;se";
$owl_lang->ggroupwrite_worldread_ad     = "Den valgte gruppe kan sende filer og slette denne mappen og alle kan se indholdet";
$owl_lang->ggroupwrite_worldread_ad_nod = "Den valgte gruppe kan sende filer til mappen og alle kan se indholdet, IKKE SLETTE";
$owl_lang->geveryoneread                = "Alle kan l&aelig;se denne mappe";
$owl_lang->geveryonewrite               = "Alle kan sende filer og slette denne mappe";
$owl_lang->geveryonewrite_nod           = "Alle kan sende filer til denne mappe";
$owl_lang->ggroupread                   = "Din gruppe kan l&aelig;se denne mappe";
$owl_lang->ggroupwrite                  = "Din gruppe kan sende filer og slette denne mappe";
$owl_lang->ggroupwrite_nod              = "Din gruppe kan sende filer til denne mappe";
$owl_lang->gonlyyou                     = "Kun du kan sende filer og slette denne mappe";
$owl_lang->geveryoneread_ad             = "Alle kan l&aelig;se denne mappe";
$owl_lang->geveryonewrite_ad            = "Alle kan sende filer og slette denne mappe";
$owl_lang->geveryonewrite_ad_nod        = "Alle kan sende filer til denne mappe";
$owl_lang->ggroupread_ad                = "Den valgte gruppe kan l&aelig;se filer i denne mappe";
$owl_lang->ggroupwrite_ad               = "Den valgte gruppe kan sende filer og slette denne mappe";
$owl_lang->ggroupwrite_ad_nod           = "Den valgte gruppe kan sende filer til denne mappe";
$owl_lang->gonlyyou_ad                  = "Kun du kan sende filer og slette denne mappe";
$owl_lang->orphaned                     = "&#8211; NO Owner  &#8211;";
$owl_lang->virus_infected               = "VIRUS INFECTED FILE";
$owl_lang->virus_return_val             = "Virus Program Return value:";

//********************************************************
// lib/owl.lib.php  END
//********************************************************


//********************************************************
// HREF TITLE messages  BEGIN
//********************************************************

$owl_lang->title_browse_folder          = "Gennemse denne mappe";
$owl_lang->title_browse_site            = "Browse to denne URL";
$owl_lang->title_download_view          = "Hent/se denne fil";
$owl_lang->title_edit_prefs             = "Se/redigere bruger indstillinger";
$owl_lang->title_return_folder          = "Retur til";
$owl_lang->title_sort                   = "Ordnet som";
$owl_lang->title_view_new               = "Se liste af nye filer siden mit sidste bes&oslash;g";
$owl_lang->title_view_updated           = "Se liste af opdateret filer siden mit sidste bes&oslash;g";
$owl_lang->title_view_my                = "Se liste af mine filer";

//********************************************************
// HREF TITLE messages  END
//********************************************************


//********************************************************
// admin/news.php and newsread.php BEGIN
//********************************************************

$owl_lang->news_title                   = "Nyheder administration";
$owl_lang->news_hd                      = "Nyheder";
$owl_lang->news_hd_created              = "Oprettet d.";
$owl_lang->news_hd_expires              = "Udl&oslash;ber d.";
$owl_lang->news_hd_audience             = "M&aring;lgruppe";
$owl_lang->news_heading                 = "Nyhed overskrift";
$owl_lang->news_content                 = "Indhold";
$owl_lang->news_posted_date             = "Nyheder posteret:";
$owl_lang->news_read                    = "L&aelig;s";

//********************************************************
// admin/news.php and newsread.php  END
//********************************************************


//********************************************************
// DEBUG MESSAGES BEGIN
//********************************************************

$owl_lang->debug_tmp_not_exists         = "DEBUG: Midlertidig mappen: $default->owl_tmpdir eksistere ikke.";
$owl_lang->debug_tmp_not_writeable      = "DEBUG: Midlertidig mappen: $default->owl_tmpdir er ikke skrivebar.";
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

$owl_lang->owl_stats_viewer     = "Statistik Viewer";
$owl_lang->stats_files          = "Antal af filer pr brugere";
$owl_lang->stats_folders        = "Antal af mapper pr brugere";
$owl_lang->stats_top            = "Top 20 downloads";
$owl_lang->stats_users          = "USER Signon (Login / Failure / Logout)";
$owl_lang->stats_users_loggedin = "Currently Logged In";
$owl_lang->stats_information    = "Logging og fil logging skal v&aelig;re sl&aring;et til for at disse statistikker kan vises";

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
