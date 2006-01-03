<?php

/*

  File: Dutch/language.inc (dutch)
  Author: Sander E. Robijns
  Date: 2001/03/04
  Updated by Fred Stuurman
  Date: 2002/10/24
  Updated by Reinier van Loon
  Date: 2004/03/31

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
        $owl_lang->localized_date_format = "d M Y \a\\t h:i a";
}

// Character Encoding used 
// default: "UTF-8"
$owl_lang->charset = "UTF-8";

//********************************************************
// Date Formating BEGIN
//********************************************************

//********************************************************
// Error Messages BEGIN
//********************************************************

$owl_lang->err_select_reviewer          = "Please select at least one Person to review your document";
$owl_lang->err_adding_comments   	= "U hebt geen autorisatie om notities toe te voegen";
$owl_lang->err_comment_empty            = "Comment cannot be empty";
$owl_lang->err_backup_file   	 	= "Fout bij maken van backup van bestaand bestand";
$owl_lang->err_backup_folder_create	= "Fout bij aanmaken van de backupmap";
$owl_lang->err_bad_url           	= "Geldige URL invullen";
$owl_lang->err_bad_version_1 		= "Owl Intranet vereist minimaal PHP versie";
$owl_lang->err_bad_version_2 		= "U gebruikt versie";
$owl_lang->err_bad_version_3 		= "Installeer een nieuwere versie van PHP en probeer opnieuw";
$owl_lang->err_email         		= "Email kon niet worden verzonden";
$owl_lang->err_email_required    	= "Email field is required";
$owl_lang->err_fexist1  		= "<b>Bestand bestaat reeds:</b>";
$owl_lang->err_fexist2 			= "Er is reeds een bestand genaamd <i>";
$owl_lang->err_fexist3 			= "</i> in deze map.";
$owl_lang->err_file_exists		= "Het bestand dat u probeert toe te voegen bestaat al";
$owl_lang->err_fileexists    		= "Hernoemen geannuleerd<BR>Bestand met dezelfde naam bestaat al.";
$owl_lang->err_file_lock     	 	= "U kunt dit bestand niet benaderen, het wordt gebruikt door";
$owl_lang->err_update_file_lock         = "You cannot update this file, it is currently held by";
$owl_lang->err_filemove_exist   	= "Er bestaat reeds een bestand met deze naam";
$owl_lang->err_file_not_exist 	 	= "Bestand bestaat niet (meer) in het bestandssysteem";
$owl_lang->err_file_too_big      	= "php.ini upload_max_filesize overschreden en/of<BR>Owl Max Upload file size overschreden";
$owl_lang->err_file_update   	 	= "Bij het wijzigen van een bestand moet de bestandsnaam hetzelfde blijven, probeer opnieuw met dezelfde bestandsnaam";
$owl_lang->err_folder_create 	 	= "Fout bij het aanmaken van de map";
$owl_lang->err_folder_exist  	 	= "Deze map bestaat al";
$owl_lang->err_folderexists  		= "Hernoemen geannuleerd<BR>Map met dezelfde naam bestaat al.";
$owl_lang->err_general       		= "Er is een algemene fout opgetreden";
$owl_lang->err_group_delete      	= "Het is niet toegestaan om een groep met leden te verwijderen";
$owl_lang->err_group_exists      	= "Er is reeds een groep met deze naam.";
$owl_lang->err_gzip_not_found    	= "gzip niet gevonden in ";
$owl_lang->err_login   		     	= "U dient zich eerst aan te melden";
$owl_lang->err_movecancel    		= "Verplaatsen geannuleerd<BR>";
$owl_lang->err_nameempty     		= "Mapnaam invullen a.u.b.";
$owl_lang->err_news_required     	= "ERROR: News Heading and Content are required!";
$owl_lang->err_no_access       	 	= "U bent niet geautoriseerd om de geselecteerde bestanden te openen";
$owl_lang->err_no_access_info           = "Possible causes: <br></br>1) You did not click any checkbox in front of a File or Folder<br></br>2) Bulk Delete, Bulk Email, Bulk Checkout do not apply to Folders<br></br>3) You do not have access to any of the files or folders you have selected.";
$owl_lang->err_noemail           	= "U mag deze file niet emailen";
$owl_lang->err_nofileaccess	   	= "U heeft geen toegang tot dit bestand";
$owl_lang->err_nofiledelete		= "U heeft geen rechten om dit bestand te verwijderen";
$owl_lang->err_nofilemod		= "U heeft geen toegang om dit bestand te wijzigen";
$owl_lang->err_nofolderaccess	 	= "U heeft geen toegang tot deze map";
$owl_lang->err_nofolderdelete 		= "U bent niet geautoriseerd om deze map te verwijderen";
$owl_lang->err_nofoldermod		= "U bent niet geautoriseerd om deze map te wijzigen";
$owl_lang->err_nosubfolder		= "U heeft geen rechten om hier mappen toe te voegen";
$owl_lang->err_note_title        	= "Titel invullen a.u.b.";
$owl_lang->err_note_title_exists 	= "Er bestaat reeds een notitie met deze naam";
$owl_lang->err_noupload			= "U heeft geen rechten om bestanden toe te voegen aan deze map";
$owl_lang->err_pass_missmatch		= "Nieuw wachtwoord en controle-wachtwoord zijn niet hetzelfde";
$owl_lang->err_pass_wrong    	 	= "Oude wachtwoord is fout";
$owl_lang->err_pod2html_not_found 	= "ERROR: Het pod2html programma is niet gevonden:";
$owl_lang->err_quota         	 	= "U heeft niet voldoende ruimterechten om dit bestand te uploaden: ";
$owl_lang->err_quota_needed  	 	= " nodig ";
$owl_lang->err_quota_avail   	 	= " beschikbaar.";
$owl_lang->err_quota_exceed  	 	= "U bent boven uw gestelde quota";
$owl_lang->err_req      		= "ERROR: Alle velden zijn verplicht in te vullen";
$owl_lang->err_root_delete       	= "De hoofdmap mag niet verwijderd worden";
$owl_lang->err_sess_notvalid 		= "Sessie is niet (meer) geldig";
$owl_lang->err_sess_write    		= "Fout bij opslaan van sessie-informatie in de database";
$owl_lang->err_specialfoldername 	= "'backup' is an Owl reserved Folder Name please choose another name";
$owl_lang->err_tar_not_found     	= "tar was not found in ";
$owl_lang->err_trash_can_empty   	= "De prullenbak is leeg";
$owl_lang->err_unauth_area   	 	= "U bent niet geautoriseerd om dit te gebruiken";
$owl_lang->err_unauthorized  	 	= "niet geautoriseerd";
$owl_lang->err_upload        	 	= "Er heeft zich een fout voorgedaan tijdens het uploaden";
$owl_lang->err_user_exists   		= "Gebruikersnaam bestaat al";
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
$owl_lang->alt_add_comments     = "Add a Comment to this File";
$owl_lang->alt_btn_add_file     = "Upload a New File";
$owl_lang->alt_btn_add_folder   = "Create a New Folder";
$owl_lang->alt_add_group        = "Create This Group";
$owl_lang->alt_add_news         = "Add a New News Item";
$owl_lang->alt_btn_add_note     = "Add a New Note";
$owl_lang->alt_add_user         = "Create This User";
$owl_lang->alt_btn_add_url      = "Create a New Web link";
$owl_lang->alt_cancel           = "Cancle This Action";
$owl_lang->alt_cancel_move      = "Cancel Move Action";
$owl_lang->alt_change           = "Update this Record";
$owl_lang->alt_btn_clickhere    = "Click Here";
$owl_lang->alt_btn_collapse_view= "Switch to a Reduced View";
$owl_lang->alt_comments         = "Comments Exist for this File";
$owl_lang->alt_del_comments     = "Delete This Comment";
$owl_lang->alt_del_file      	= "Verwijder bestand (J/N)";
$owl_lang->alt_del_folder    	= "Verwijder Folder (J/N)";
$owl_lang->alt_del_group        = "Delete This Group";
$owl_lang->alt_del_news         = "Delete This News";
$owl_lang->alt_del_selected     = "Delete all Selected Files";
$owl_lang->alt_del_all          = "Empty Trash";
$owl_lang->alt_rest_selected    = "Restore all Selected Files";
$owl_lang->alt_del_this_folder  = "Delete Folder &#8211; ";
$owl_lang->alt_del_user         = "Delete This User";
$owl_lang->alt_edit_group       = "Edit The Selected Group";
$owl_lang->alt_edit_news        = "Edit This News";
$owl_lang->alt_edit_user        = "Edit The Selected User";
$owl_lang->alt_email            = "Email this File";
$owl_lang->alt_email_selected   = "Email all Selected Files"; 
$owl_lang->alt_btn_expand_view  = "Switch to an Expanded View";
$owl_lang->alt_admin_flush      = "Flush Stale/Expired Sessions";
$owl_lang->alt_get_file      	= "Download Bestand";
$owl_lang->alt_get_folder       = "Download Folder Content";
$owl_lang->alt_have_news        = "You Have News Item(s) To View";
$owl_lang->alt_have_no_news     = "No New News Item(s) To View";
$owl_lang->alt_home_folder      = "Back to Intial Dir ";
$owl_lang->alt_set_initial_dir  = "Set Current Dir as Initial";                                                                                                
$owl_lang->alt_site_map         = "Site Map";
$owl_lang->alt_lock_file        = "Check file out";
$owl_lang->alt_log_clear        = "Delete all Logs (Y/N)";
$owl_lang->alt_log_file         = "Bestand Log";
$owl_lang->alt_log_next         = "Display Next Records";
$owl_lang->alt_log_prev         = "Display Previous Records";
$owl_lang->alt_log_top          = "Go to the First Record";
$owl_lang->alt_btn_login        = "Log in to Owl Intranet";
$owl_lang->alt_btn_logout       = "Log out of Owl Intranet";
$owl_lang->alt_btn_help         = "Owl Online Help";
$owl_lang->alt_mod_file      	= "Wijzig Bestand Eigenschappen";
$owl_lang->alt_mod_folder    	= "Wijzig Folder Eigenschappen";
$owl_lang->alt_move_file     	= "Verplaats Bestand";
$owl_lang->alt_copy_file        = "Copy File";
$owl_lang->alt_link_file        = "Link This File to Another Directory";
$owl_lang->alt_move_folder   	= "Verplaats Folder";
$owl_lang->alt_copy_folder      = "Copy Folder";
$owl_lang->alt_move_selected    = "Move all Selected Files"; 
$owl_lang->alt_admin_groups 	= "Create a new group";
$owl_lang->alt_news_close       = "Close the News Window";
$owl_lang->alt_news_next        = "Display Next News Item";
$owl_lang->alt_news_prev        = "Display Previous News Item";
$owl_lang->alt_news_print       = "Print This News Item";
$owl_lang->alt_admin_users      = "Create a new user";
$owl_lang->alt_monitor  	= "Monitor this File";
$owl_lang->alt_monitored        = "Stop Monitoring this File";
$owl_lang->alt_btn_admin        = "Owl Administratie";
$owl_lang->alt_play_file        = "Play Media File";
$owl_lang->alt_recycle          = "Your Trash Can is Empty";
$owl_lang->alt_recycle_disable  = "Trash Collection has been Disabled";
$owl_lang->alt_recycle_not_found= "Trash Can Location Was not Found";
$owl_lang->alt_refresh_filter   = "Initiate Filter / Refresh Results";
$owl_lang->alt_register         = "Submit your Registration";
$owl_lang->alt_btn_browse       = "Return to File Browser";
$owl_lang->alt_search           = "Initiate The Search";
$owl_lang->alt_send_email       = "Send The Email";
$owl_lang->alt_sendfile         = "Send The File";
$owl_lang->alt_toggle_check_box = "Toggle Check Boxes";
$owl_lang->alt_unlock_file      = "Check file in";
$owl_lang->alt_upd_file      	= "Update Bestand";
$owl_lang->alt_view_comments    = "Add / View File Comments";
$owl_lang->alt_view_file     	= "Bekijk Bestand";
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

$owl_lang->log_del_det          = "Entire Content was also deleted";
$owl_lang->log_detail           = "No Additional Details";
$owl_lang->log_file_to          = "TO: ";
$owl_lang->log_filter_all       = "ALL";
$owl_lang->log_login_det        = "Username: ";
$log_file_actions[1]            = "LOGIN";
$log_file_actions[2]            = "LOGIN FAILED";
$log_file_actions[3]            = "LOGOUT";
$log_file_actions[4]            = "FILE DELETED";
$log_file_actions[5]            = "FILE UPLOAD";
$log_file_actions[6]            = "FILE UPDATED";
$log_file_actions[7]            = "FILE DOWNLOADED";
$log_file_actions[8]            = "FILE CHANGED";
$log_file_actions[9]            = "FILE LOCKED";
$log_file_actions[10]           = "FILE UNLOCKED";
$log_file_actions[11]           = "FILE EMAILED";
$log_file_actions[12]           = "FILE MOVED";
$log_file_actions[13]           = "FOLDER CREATED";
$log_file_actions[14]           = "FOLDER DELETED";
$log_file_actions[15]           = "FOLDER MODIFIED";
$log_file_actions[16]           = "FOLDER MOVED";
$log_file_actions[17]           = "FORGOT PASS";
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

$owl_lang->anonymous       = "(anonieme toegang)";
$owl_lang->repository_list      = "Repository:";
$owl_lang->engine          = "Owl Intranet Engine";
$owl_lang->forgot_pass     = "Wachtwoord vergeten?";
$owl_lang->like_register   = "Klik hier om te registreren?";
$owl_lang->login           = "Aanmelden";
$owl_lang->loginfail	   = "Er is een fout opgetreden bij het aanmelden";
$owl_lang->logindisabled   = "Account is GEBLOKKEERD. Neem contact op met de helpdesk.";
$owl_lang->password        = "Wachtwoord";
$owl_lang->successlogout   = "Afmelden succesvol";
$owl_lang->toomanysessions = "Maximum aantal sessies bereikt. Neem contact op met helpdesk";
$owl_lang->username        = "Gebruikersnaam";
$owl_lang->version         = "Versie";

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
$owl_lang->actions 	      = "Acties";
$owl_lang->del_selected       = "Selectie verwijderen";
$owl_lang->del_all                      = "Empty Trash";
$owl_lang->rest_selected                = "Restore Selected";
$owl_lang->disk_quota         = "Schijfruimte";
$owl_lang->email_selected     = "Selectie versturen";
$owl_lang->file		      = "Bestand";
$owl_lang->folder_policy      = "Maprechten:";
$owl_lang->current_folder               = "Current Folder:";
$owl_lang->held               = "In bewerking"; // for version control
$owl_lang->last_logged        = "Laatst gewijzigd op: ";
$owl_lang->current_db                   = "Current Repository:";
$owl_lang->modified 	      = "Gewijzigd";
$owl_lang->move_selected      = "Selectie verplaatsen";
$owl_lang->new_file           = "Nieuw";
$owl_lang->no_description     = "Geen omschrijving";
$owl_lang->page               = "Pagina:";
$owl_lang->postedby 	      = "Eigenaar";
$owl_lang->reallydelete       = "Werkelijk verwijderen";
$owl_lang->reallydelete_logs  = "Really Clear the Log File";
$owl_lang->reallydelete_selected = "Really Delete all selected files";
$owl_lang->reallyrestore_selected       = "Really Restore all selected files";
$owl_lang->size 	      = "Grootte";
$owl_lang->score                        = "Score";
$owl_lang->title 	      = "Titel";
$owl_lang->doc_number                   = "Doc #";
$owl_lang->tot_files          = "Totaal:";                                                                                         
$owl_lang->tot_my_checked_out = "In bewerking:";
$owl_lang->tot_my_files       = "Mijn:";                                                                                                                    
$owl_lang->tot_my_group       = "Groep:";
$owl_lang->tot_new_files      = "Nieuw:";
$owl_lang->tot_updated_files  = "Gewijzigd:";
$owl_lang->tot_monitored      = "Monitored:";
$owl_lang->updated_file       = "Gewijzigd";
$owl_lang->user               = "Gebruiker";
$owl_lang->ver                = "Versie"; // for version control
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
$owl_lang->adding_comments    = "Commentaar toevoegen/lezen: ";
$owl_lang->comments             = "Comment";
$owl_lang->post_comment         = "Post Comment";
$owl_lang->addingfile 		    = "Een bestand toevoegen aan ";
$owl_lang->addingfolder 	    = "Een map toevoegen aan ";
$owl_lang->attach_file       	= "Bestand bijsluiten";
$owl_lang->change		          = "Wijzig";
$owl_lang->create		          = "Nieuw";
$owl_lang->comments_added     = "Commentaar teogevoegd door: ";
$owl_lang->description 		    = "Beschrijving";
$owl_lang->email_body      	  = "Boodschap";
$owl_lang->email_cc          	= "CC";
$owl_lang->email_reply_to  	  = "Antwoord naar";
$owl_lang->email_subject   	  = "Onderwerp";
$owl_lang->email_to        	  = "Verstuur naar";
$owl_lang->emailing        	  = "Versturen van:";
$owl_lang->disp_mp3          	= "MP3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Song:<BR>Album:<BR>Bitrate&nbsp;-&nbsp;Samplerate:<BR>Duration:<BR>Genre:<BR>Comments:";
$owl_lang->keywords 		      = "Trefwoorden";
$owl_lang->modify_url         = "URL";
$owl_lang->modifying		      = "Wijzigen van ";
$owl_lang->name               = "Naam";                                                                                                                                                   
$owl_lang->notify_link        = "Owl External Link";
$owl_lang->note_content       = "Note Content";
$owl_lang->ownergroup         = "Groepseigenaar";
$owl_lang->ownership		      = "Eigendom";
$owl_lang->permissions 		    = "Permissies";
$owl_lang->prop_permissions   = "Propagate Permissions to subfolders?";
$owl_lang->prop_perms_files   = "Permissions to propagate to files:";
$owl_lang->policy 		        = "Beleid";
$owl_lang->pick_select        = "&#8212; Kies Owl-gebruiker &#8212;";
$owl_lang->sendfile 		      = "Verstuur bestand";
$owl_lang->sendthisfile 	    = "Bestandsnaam";
$owl_lang->sendthisurl       	= "URL versturen";
$owl_lang->updating          	= "Wijzigen";
$owl_lang->verdescription	    = "Beschrijving van de<br></br>wijzigingen";
$owl_lang->vermajor          	= "Major Revisie";
$owl_lang->verminor          	= "Minor Revisie";
$owl_lang->vertype           	= "Type revisie";  // for modify.php when uploading

//********************************************************
// modify.php  END
//********************************************************


//********************************************************
// register.php  BEGIN
//********************************************************
                                                                                                       
$owl_lang->email         = "Email-adres";
$owl_lang->full_name     = "Volledige naam";
$owl_lang->register      = "Aanmelden";
$owl_lang->self_failed   = "Mislukt";
$owl_lang->self_passwd   = "Wachtwoord verzonden naar:";
$owl_lang->self_reg_bod  = "Uw Owl wachtwoord is:";
$owl_lang->self_reg_rset = "Uw Owl Password is ingesteld op:";
$owl_lang->self_reg_subj = "Uw OWL account";
$owl_lang->send_pass     = "Wachtwoord versturen";
$owl_lang->submit        = "Versturen";
$owl_lang->thank_you_1   = "Hartelijk dank!";
$owl_lang->thank_you_2   = "Een bericht wordt verstuurd naar uw emailadres <BR> met het nieuwe wachtwoord voor <BR><b>gebruiker:</b>";

//********************************************************
// register.php  END
//********************************************************


//********************************************************
// move.php  BEGIN
//********************************************************

$owl_lang->cancel_button     = "Annuleer";
$owl_lang->moving            = "Verplaatsen van";
$owl_lang->moving_file          = "Moving file";
$owl_lang->moving_folder        = "Moving Folder";
$owl_lang->copy_file            = "Copying file";
$owl_lang->copy_folder          = "Copying Folder";
$owl_lang->select            = "Geef een nieuwe folder:";

//********************************************************
// move.php  END
//********************************************************


//********************************************************
// log.php  BEGIN
//********************************************************

$owl_lang->viewlog           = "Bekijk log voor ";

//********************************************************
// log.php  END
//********************************************************


//********************************************************
// prefs.php  BEGIN
//********************************************************

$owl_lang->confpassword	 = "Controle nieuwe wachtwoord";
$owl_lang->comment_notif = "Commentaar melding";
$owl_lang->email_tool   = "E-Mail Tool";
$owl_lang->last_modified= "Last Modified";
$owl_lang->group         = "Groep";
$owl_lang->groupmember 	 = "Lid van groep";
$owl_lang->newpassword 	 = "Nieuwe wachtwoord";
$owl_lang->newsadmin     = "Nieuwsbeheerder";
$owl_lang->not_member    = "U bent in geen enkele groep opgenomen";
$owl_lang->notification	 = "Ontvang meldingen";
$owl_lang->oldpassword 	 = "Huidige wachtwoord";
$owl_lang->preference    = "Eigenschappen";
$owl_lang->saved	       = "Wijzigingen zijn opgeslagen";
$owl_lang->status_no     = "NEE";
$owl_lang->status_yes    = "JA";
$owl_lang->userlang      = "Taal";

//********************************************************
// prefs.php  END
//********************************************************


//********************************************************
// search.php  BEGIN
//********************************************************

$owl_lang->elapsed_time         = "duur";
$owl_lang->search             	= "Zoeken";
$owl_lang->search_any_word      = "Een van de woorden";
$owl_lang->search_all_word      = "Alle woorden";
$owl_lang->search_entire_phrase = "Complete zin";
$owl_lang->search_match         = "Match:";
$owl_lang->search_currentfolder = "Zoek in deze map";
$owl_lang->search_for_folders   = "Zoek mappen";
$owl_lang->search_for_files     = "Zoek bestanden";
$owl_lang->search_score         = "Bestanden scoren";
$owl_lang->search_results_for 	= "Zoek resultaten voor";
$owl_lang->search_winthindocs   = "Zoek in (tekst, pdf en MS-WORD) documenten";
$owl_lang->related_query_empty  = "No metadata associated with document to perform 'Search Related'";
$owl_lang->query_empty        	= "Zoektekst is leeg";

//********************************************************
// search.php  END
//********************************************************


//********************************************************
// view.php  BEGIN
//********************************************************

$owl_lang->viewing              = "Bekijken ";

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
$owl_lang->add                          = "Toevoegen";
$owl_lang->anonymous_account            = "anoniem account:";                                                                                                                      
$owl_lang->buttonstyle                  = "Knopstijl";
$owl_lang->deletegroup                  = "Verwijder groep";
$owl_lang->deleteuser                   = "Verwijder gebruiker";
$owl_lang->disableuser                  = "Gebruiker blokkeren";
$owl_lang->disable_recs_per_page        = "Beperkt lezen schakelt meerdere rijen per pagina uit!";
$owl_lang->file_admin_group             = "Bestand/Browser beheergroep:";
$owl_lang->flushed                      = "Sessietabel gewist. Gebruiker kan zich weer aanmelden.<BR>";
$owl_lang->groups                       = "Groepen";
$owl_lang->hide_bulk_buttons            = "Bulkknoppen verbergen:";
// Edit HTML Properties Messages
$owl_lang->ht_tbl_border_sz             = "Dikte tabelrand:";
$owl_lang->ht_tbl_hd_bg                 = "Achtergrondkleur kop:";
$owl_lang->ht_tbl_cell_bg_cl            = "Achtergrondkleur tabelcel 1:";
$owl_lang->ht_tbl_cell_bg_al 		        = "Achtergrondkleur tabelcel 2:";
$owl_lang->ht_expand_width   		        = "Beeldbreedte in uitgeklapte toestand:";
$owl_lang->ht_collapse_width            = "Beeldbreedte in ingeklapte toestand:";
$owl_lang->ht_bd_bg_image    		        = "Locatie achtergrondfiguur:";
$owl_lang->ht_bd_txt_cl      		        = "Tekstkleur romp:";
$owl_lang->ht_bd_lnk_cl      		        = "Linkkleur romp:";
$owl_lang->ht_bd_vlnk_cl     		        = "Linkkleur romp bezocht:";
// Edit Prefs Properties Messages
$owl_lang->home_dir                     = "Map Mijn documenten";
$owl_lang->initial_dir                  = "User's Initial Directory";
$owl_lang->maxsessions                  = "Maximum aantal sessies";
$owl_lang->noprefaccess                 = "Eigenschappen uitschakelen";
$owl_lang->owl_anon_full                = "Full Access";
$owl_lang->owl_anon_ro       		        = "anoniem mag alleen lezen:";
$owl_lang->owl_anon_download            = "Download Only";
$owl_lang->anonymous_access             = "Set Anonymous Access";
$owl_lang->owl_dbdump_path   		        = "Locatie DB Dump Tool:";
$owl_lang->owl_def_file_group_owner	    = "Initiele bestandsgroep:";
$owl_lang->owl_def_file_meta 		        = "Initiele mapmetadata:";
$owl_lang->owl_def_file_owner		        = "Initiele bestandseigenaar:";
$owl_lang->owl_def_file_perm 		        = "Initiele bestandsrechten:";
$owl_lang->owl_def_file_security	      = "Initiele bestandsbeveiling:";
$owl_lang->owl_def_file_title		        = "Initiele bestandstitle (leeg indien bestandsnaam):";
$owl_lang->owl_def_fold_group_owner  	  = "Initiele mapgroep:";
$owl_lang->owl_def_fold_owner          	= "Initiele mapeigenaar:";
$owl_lang->owl_def_fold_sec  		        = "Initiele mapbeveiliging:";
$owl_lang->owl_def_folder_perm 		      = "Initiele maprechten:";
$owl_lang->owl_default_tmpdir   	      = "Maplocatie voor tijdelijke bestanden: ";
$owl_lang->owl_email_from    		        = "From Address / SMTP Auth Login:";
$owl_lang->owl_email_fromname		        = "From Name:";
$owl_lang->owl_email_replyto 		        = "Reply To Address:";
$owl_lang->owl_email_server  		        = "SMTP Server:";
$owl_lang->owl_email_smtp               = "Gebruik SMTP Mailing Method";
$owl_lang->owl_email_smtp_auth          = "Gebruik SMTP Auth";
$owl_lang->owl_email_smtp_auth_login    = "SMTP Auth Login:";
$owl_lang->owl_email_smtp_auth_passwd   = "SMTP Auth wachtwoord";
$owl_lang->owl_email_subject_pref       = "Voorloop onderwerp:";
$owl_lang->owl_fogotpass                = "Toon link [wachtwoord vergeten]:";
$owl_lang->owl_group_user    		= "Gebruikers in deze groep";
$owl_lang->owl_gzip_path     		= "Locatie gzip:";
$owl_lang->owl_hidebackup    	        = "Map met backups verbergen:";
$owl_lang->owl_log_file      		= "Registreer bestandshandelingen:";
$owl_lang->owl_log_login_act 		= "Registreer aanmelden/afmelden:";
$owl_lang->owl_log_rec_page  		= "Aantal rijen per pagina voor pagina:";
$owl_lang->owl_logo                     = "Logo aanmeldpagina ([Taal]/figuur):";
$owl_lang->owl_logging       		= "Registreren inschakelen:";
$owl_lang->owl_lookAtHD      		= "Instellingen overnemen uit bestandssysteem uitschakelen:";
$owl_lang->owl_lookAtHDDel   		= "Verwijderde bestanden wissen in database:";
$owl_lang->hide_folder_doc_count        = "Hide Folder File Type Count";                                                                                                                        
$owl_lang->hide_folder_size             = "Hide Folder Content Size";
$owl_lang->old_action_icons             = "Use pre Owl 0.80 Action Icons";
$owl_lang->search_result_folders        = "Include Folders in Search Results";
$owl_lang->restore_file_prefix          = "String Prefixed to Restored Files";
$owl_lang->owl_max_filesize  		= "Maximale bestandsgrootte voor upload:";
$owl_lang->owl_owl_expand    		= "Initiele browserbeeld (Uitgeklapt):";
$owl_lang->owl_owl_timeout   		= "Verlooptijd sessie in seconden:";
$owl_lang->virus_path                   = "Virus Checking Software Path<br />Example: '/usr/bin/clamscan --quiet' <br />&#8211; Blank for Disabled:";
$owl_lang->owl_pdftotext_path           = "Gebruik zoekindex voor <BR>PDF en tekstbestanden <BR>&#8211; Leeglaten om uit te schakelen:";
$owl_lang->owl_wordtotext_path          = "MS-WORD Files <BR>&#8211; Blank for Disabled:";
$owl_lang->owl_pod2html_path            = "Perl 5.8.0 or hoger nodig<BR>Locatie pod2html:";
$owl_lang->owl_restrict_view 		= "Beperkt lezen inschakelen:";
$owl_lang->owl_self_reg      		= "Zelfregistratie inschakelen:";
$owl_lang->owl_self_reg_hd   		= "INSTELLINGEN ZELFREGISTRATIE";
$owl_lang->owl_tar_path     		= "Locatie tar:";
$owl_lang->owl_title_custom             = "CUSTOMIZE BROWSER COLUMNS";
$owl_lang->owl_title_custom_search      = "CUSTOMIZE SEARCH RESULTS";
$owl_lang->owl_title_browser            = "OWL BROWSER KENMERKEN";
$owl_lang->owl_title_defaults           = "INSTELLINGEN";
$owl_lang->owl_title_email   		        = "OWL System Mail Settings";
$owl_lang->owl_title_HD      		        = "INSTELLINGEN OVERNEMEN UIT BESTANDSSYSTEEM";
$owl_lang->owl_title_logging  	        = "INSTELLINGEN REGISTRATIE";
$owl_lang->owl_title_other   		        = "OVERIGE INSTELLINGEN";
$owl_lang->owl_title_tools   		        = "INSTELLINGEN UITBREIDINGEN";
$owl_lang->owl_unzip_path               = "Locatie unzip:";
$owl_lang->owl_version_control		      = "Versiebeheer inschakelen:";
$owl_lang->quota                        = "Quotum 0=Uitgeschakeld";
$owl_lang->reallydeluser                = "Gebruiker is eigenaar van %numfiles% bestanden en %numfolders% mappen. Deze mappen en bestanden hebben dan geen eigenaar meer. Doorgaan met verwijderen?";
$owl_lang->recs_per_page                = "Aantal rijen per pagina (0 = Uitgeschakeld):";
$owl_lang->remember_me_title            = "INSTELLINGEN AANMELDEN";
$owl_lang->remember_me                  = "Toon de Onthoud me verwijzing";
$owl_lang->remember_timeout             = "Cookie verlooptijd in dagen";
$owl_lang->remember_me_checkbox         = "Onthoud me";
$owl_lang->recycle_title                = "INSTELLING PRULLENBAK";
$owl_lang->recycle_enabled              = "Prullenbak inschakelen:";
$owl_lang->recycle_location             = "Plaats prullenbak:";
$owl_lang->show_panel_title             = "Display Status Panel:";
$owl_lang->show_search_title            = "Display Search Bar:";
$owl_lang->show_pref_title              = "Display Pref/logout Bar:";
$owl_lang->show_bulk_title              = "Display Bulk Buttons:";
$owl_lang->show_action_title            = "Display action Buttons:";
$owl_lang->show_folder_title            = "Display Folder Tools:";
$owl_lang->show_panel                   = "Show";
$owl_lang->hide_panel                   = "Hide";
$owl_lang->status_bar_both              = "Beide";
$owl_lang->status_bar_bottom            = "Onder";
$owl_lang->status_bar_location          = "Positie van de statusbalk:";
$owl_lang->status_bar_top               = "Boven";
$owl_lang->status_bar_not               = "Do Not Display";
$owl_lang->use_popup                    = "Gebruik popup voor nieuwsberichten:";
$owl_lang->users                        = "Gebruikers";
$owl_lang->header_user_admin            = "User Administration";
$owl_lang->header_group_admin           = "Group Administration";
$owl_lang->header_sitefeatures_settings           = "Site Features and Settings";

//********************************************************
// admin/index.php  END
//********************************************************


//********************************************************
// admin/log.php  BEGIN
//********************************************************

$owl_lang->owl_log_viewer    	 = "LOG Viewer";
$owl_lang->owl_log_hd_action 	 = "Actie";
$owl_lang->owl_log_hd_file   	 = "Bestand";
$owl_lang->owl_log_hd_fld_path = "Maplocatie";
$owl_lang->owl_log_hd_user   	 = "Gebruiker";
$owl_lang->owl_log_hd_dt_tm  	 = "Datum tijd";
$owl_lang->owl_log_hd_ip     	 = "IP / Adres";
$owl_lang->owl_log_hd_agent  	 = "Agent";
$owl_lang->owl_log_hd_dtls   	 = "Details";
$owl_lang->owl_log_no_rec    	 = " GEEN GEGEVENS BESCHIKBAAR ";
$owl_lang->owl_log_hide      	 = "Verbergen: ";
$owl_lang->owl_log_filter    	 = "Filter";

//********************************************************
// admin/log.php  END
//********************************************************


//********************************************************
// admin/recycle.php  BEGIN
//********************************************************

$owl_lang->empty_trash          = "Prullenbak leegmaken";
$owl_lang->really_empty_trash   = "Prullenbak leegmaken?";
$owl_lang->recycle_bin_admin    = "Beheer prullenbak";

//********************************************************
// admin/recycle.php  END
//********************************************************


//********************************************************
// lib/owl.lib.php  BEGIN
//********************************************************

$owl_lang->file_size_byte           = "B";
$owl_lang->file_size_gigabyte       = "G";
$owl_lang->file_size_kilobyte       = "K";
$owl_lang->file_size_megabyte       = "M";
$owl_lang->notif_subject_new 	    = "Nieuw OWL Intranetbestand";
$owl_lang->notif_subject_upd 	    = "Een OWL Intranetbestand is gewijzigd";
$owl_lang->notif_subject_monitor    = "An OWL Intranet File or Folder you are MONITORING was updated";
$owl_lang->notif_subject_comment    = "An OWL Intranet File -- Comment Added";
$owl_lang->notif_comment_1          = "commented on";
$owl_lang->notif_comment_2          = "Comment:";
$owl_lang->notif_msg         	    = "Bericht van OWL Intranet<BR><BR>Klik op de link hieronder om het bestand te bekijken<BR><BR>";
$owl_lang->notif_msg_link               = "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet<BR><BR>Find a link to a new/updated file in this E-Mail<BR><BR>";
$owl_lang->notif_msg_alt_link           = "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet\n\nFind a link to a new/updated file in this E-Mail\n\n";
$owl_lang->notif_msg_alt            = "Bericht van OWL Intranet\n\nKlik op de link hieronder om het bestand te bekijken\n\n";
$owl_lang->notif_salutation         = "Beste";
$owl_lang->notif_user                   = "Created/Update by:";
$owl_lang->owl_path                 = "Bestandslocatie: ";
$owl_lang->sessinuse		    = "Deze sessie is in gebruik op een andere computer, toegang geweigerd<BR>";
$owl_lang->invalidsess		    = "Verkeerde sessie, meldt u zich aan op de hoofdpagina a.u.b.<BR></A>";
$owl_lang->sesstimeout	            = "Uw sessie is verlopen, meldt u zich opnieuw aan op de hoofdpagina a.u.b.<BR>";
$owl_lang->everyoneread	            = "Iedereen kan lezen/downloaden";
$owl_lang->everyonewrite            = "Iedereen kan lezen/schrijven/downloaden";
$owl_lang->everyonewrite_nod        = "Iedereen kan lezen/schrijven/downloaden, NIET VERWIJDEREN";
$owl_lang->groupread		    = "Uw groep kan lezen/downloaden";
$owl_lang->groupwrite		    = "Uw groep kan lezen/schrijven/downloaden";
$owl_lang->groupwrite_nod  	    = "Uw groep kan lezen/schrijven/downloaden, NIET VERWIJDEREN";
$owl_lang->onlyyou		    = "Alleen u kunt lezen/schrijven/downloaden";
$owl_lang->donothing                = "Niets wijzigen &#8211; Bestandsrechten ongewijzigd laten";
$owl_lang->groupwrite_worldread     = "Uw groep kan lezen/schrijven/downloaden en iedereen kan lezen";
$owl_lang->groupwrite_worldread_nod = "Uw groep kan lezen/schrijven/downloaden (NIET VERWIJDEREN) en iedereen kan lezen";
$owl_lang->ggroupwrite_worldread    = "Uw groep kan bestanden uploaden en verwijderen uit deze folder en iedereen kan de inhoud lezen";
$owl_lang->ggroupwrite_worldread_nod= "Uw groep kan bestanden uploaden in deze folder en iedereen kan de inhoud lezen, NIET VERWIJDEREN";
$owl_lang->everyoneread_ad   	    = "Iedereen kan lezen/downloaden";
$owl_lang->everyonewrite_ad  	    = "Iedereen kan lezen/schrijven/downloaden";
$owl_lang->everyonewrite_ad_nod     = "Iedereen kan lezen/schrijven/downloaden, NIET VERWIJDEREN";
$owl_lang->groupread_ad      	    = "Uw groep kan lezen/downloaden";
$owl_lang->groupwrite_ad     	    = "Uw groep kan lezen/schrijven/downloaden";
$owl_lang->groupwrite_ad_nod 	    = "Uw groep kan lezen/schrijven/downloaden, NIET VERWIJDEREN";
$owl_lang->onlyyou_ad        	    = "Alleen u kan lezen/schrijven/downloaden";
$owl_lang->groupwrite_worldread_ad  = "De geselecteerde groep kan lezen/schrijven/downloaden & iedereen kan lezen";
$owl_lang->groupwrite_worldread_ad_nod = "De geselecteerde groep kan lezen/schrijven/downloaden (NIET VERWIJDEREN) en iedereen kan lezen";
$owl_lang->ggroupwrite_worldread_ad = "De geselecteerde groep upload bestanden en verwijderen deze folder en iedereen kan de inhoud lezen";
$owl_lang->ggroupwrite_worldread_ad_nod= "De geselecteerde groep kan bestanden uploaden naar deze folder en iedereen kan de inhoud lezen, NIET VERWIJDEREN";
$owl_lang->geveryoneread	    = "Iedereen kan deze map lezen";
$owl_lang->geveryonewrite	    = "Iedereen kan bestanden toevoegen en deze map verwijderen";
$owl_lang->geveryonewrite_nod	    = "Iedereen kan bestanden toevoegen";
$owl_lang->ggroupread		    = "Uw groep kan deze map lezen";
$owl_lang->ggroupwrite		    = "Uw groep kan bestanden toevoegen en deze map verwijderen";
$owl_lang->ggroupwrite_nod   	    = "Uw groep kan bestanden toevoegen in deze map";
$owl_lang->gonlyyou		    = "Alleen u kunt bestanden toevoegen en deze map verwijderen";
$owl_lang->geveryoneread_ad	    = "Iedereen kan deze map lezen";
$owl_lang->geveryonewrite_ad	    = "Iedereen kan bestanden toevoegen en deze map verwijderen";
$owl_lang->geveryonewrite_ad_nod    = "Iedereen kan bestanden toevoegen aan de map";
$owl_lang->ggroupread_ad	    = "Uw groep kan deze map lezen";
$owl_lang->ggroupwrite_ad	    = "Uw groep kan bestanden toevoegen en deze map verwijderen";
$owl_lang->ggroupwrite_ad_nod       = "Uw groep kan bestanden toevoegen aan deze map";
$owl_lang->gonlyyou_ad		    = "Alleen u kunt bestanden toevoegen en deze map verwijderen";
$owl_lang->orphaned                 = "&#8211; NO Owner  &#8211;";
$owl_lang->virus_infected               = "VIRUS INFECTED FILE";
$owl_lang->virus_return_val             = "Virus Program Return value:";

//********************************************************
// lib/owl.lib.php  END
//********************************************************


//********************************************************
// HREF TITLE messages  BEGIN
//********************************************************

$owl_lang->title_browse_folder          = "Map openen";
$owl_lang->title_browse_site            = "URL openen";
$owl_lang->title_download_view          = "Bestand openen";
$owl_lang->title_edit_prefs             = "Voorkeursinstellingen bewerken";
$owl_lang->title_return_folder          = "Terug naar";
$owl_lang->title_sort                   = "Sorteren op";
$owl_lang->title_view_new               = "Overzicht nieuwe bestanden sinds laatste bezoek";
$owl_lang->title_view_updated           = "Overzicht gewijzigde bestanden sinds laatste bezoek";
$owl_lang->title_view_my                = "Overzicht persoonlijke bestanden";

//********************************************************
// HREF TITLE messages  END
//********************************************************


//********************************************************
// admin/news.php and newsread.php BEGIN
//********************************************************

$owl_lang->news_title                   = "Beheer nieuwsberichten";
$owl_lang->news_hd                      = "Nieuws";
$owl_lang->news_hd_created              = "Aangemaakt";
$owl_lang->news_hd_expires              = "Verloopt";
$owl_lang->news_hd_audience             = "Doelgroep";
$owl_lang->news_heading                 = "Berichtkop";
$owl_lang->news_content                 = "Inhoud";
$owl_lang->news_posted_date             = "Geplaatste berichten:";
$owl_lang->news_read                    = "Lezen";

//********************************************************
// admin/news.php and newsread.php  END
//********************************************************


//********************************************************
// DEBUG MESSAGES BEGIN
//********************************************************

$owl_lang->debug_tmp_not_exists         = "DEBUG: De Owl-map: $default->owl_tmpdir bestaat niet.";
$owl_lang->debug_tmp_not_writeable      = "DEBUG: De Owl-map: $default->owl_tmpdir is niet schrijfbaar.";
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

$owl_lang->owl_stats_viewer     = "Statistieken";
$owl_lang->stats_files          = "Aantal bestanden per gebruiker";
$owl_lang->stats_folders        = "Aantal mappen per gebruiker";
$owl_lang->stats_top            = "Top 20 downloads";
$owl_lang->stats_users          = "USER Signon (Login / Failure / Logout)";
$owl_lang->stats_users_loggedin = "Currently Logged In";
$owl_lang->stats_information    = "Owl Logging and bestandslogging inschakelen voor deze statistieken";

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
