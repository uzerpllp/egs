<?php

/*

  File: Czech/language.inc
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

$owl_lang->charset = "";

//********************************************************
// Date Formating BEGIN
//********************************************************

//********************************************************
// Error Messages BEGIN
//********************************************************

$owl_lang->err_select_reviewer          = "Please select at least one Person to review your document";
$owl_lang->err_adding_comments          = "You are not permitted to Add Comments to this File";
$owl_lang->err_comment_empty            = "Comment cannot be empty";
$owl_lang->err_backup_file   		= "Error backing up existing file";
$owl_lang->err_backup_folder_create 	= "Backup Folder Creation error";
$owl_lang->err_bad_url                  = "Please enter a valid URL";
$owl_lang->err_bad_version_1 		= "Owl Intranet potøebuje verzi PHP alespoò";
$owl_lang->err_bad_version_2 		= "Máte spuštìnou verzi";
$owl_lang->err_bad_version_3 		= "nainstalujte novìjší verzi PHP a zkuste to znovu";
$owl_lang->err_email         		= "Zpráva nemohla být odeslána";
$owl_lang->err_email_required   	= "Email field is required";
$owl_lang->err_fexist1  		= "<b>File Exists:</b>";
$owl_lang->err_fexist2 			= "There is already a file with the name <i>";
$owl_lang->err_fexist3 			= "</i> in this directory.";
$owl_lang->err_file_exists		= "Soubor, který se pokoušíte nahrát, již existuje";
$owl_lang->err_fileexists    		= "Pøesun byl stornován<BR>Soubor se stejným jménem již existuje.";
$owl_lang->err_file_lock     		= "Nemùžete soubor zamknout pro úpravy, protože je již zamèen uživatelem";
$owl_lang->err_update_file_lock         = "You cannot update this file, it is currently held by";
$owl_lang->err_filemove_exist           = "The filename you are trying to rename this file to already exists";
$owl_lang->err_file_not_exist 		= "File does not exist on the file system";
$owl_lang->err_file_too_big     	= "php.ini upload_max_filesize exceeded and/or<BR>Exceeded Owl Max Upload file size";
$owl_lang->err_file_update		= "Updating a file requires the filename to remain the same, please try again using the same filename";
$owl_lang->err_folder_create 		= "Chyba pøi vytváøení složky";
$owl_lang->err_folder_exist		= "Tato složka již existuje";
$owl_lang->err_folderexists  		= "Pøejmenování bylo stornováno<BR>Složka se stejným jménem již existuje.";
$owl_lang->err_general 			= "Došlo k chybì";
$owl_lang->err_group_delete             = "You cannot delete a group that has members";
$owl_lang->err_group_exists             = "There is already a group with this name.";
$owl_lang->err_gzip_not_found   	= "gzip was not found in ";
$owl_lang->err_login   			= "Please Login to perform this action";
$owl_lang->err_movecancel    		= "Pøesun byl stornován<BR>";
$owl_lang->err_nameempty    		= "Jméno složky nemùže být prázdné";
$owl_lang->err_news_required            = "ERROR: News Heading and Content are required!";
$owl_lang->err_no_access       		= "You do not have access to any of the files selected";
$owl_lang->err_no_access_info           = "Possible causes: <br></br>1) You did not click any checkbox in front of a File or Folder<br></br>2) Bulk Delete, Bulk Email, Bulk Checkout do not apply to Folders<br></br>3) You do not have access to any of the files or folders you have selected.";
$owl_lang->err_noemail			= "Nemáte pøístupové právo pro zaslání tohoto souboru e-mailem";
$owl_lang->err_nofileaccess		= "Nemáte pøístupové právo k tomuto souboru";
$owl_lang->err_nofiledelete		= "Nemáte pøístupové právo pro odstranìní tohoto souboru";
$owl_lang->err_nofilemod		= "Nemáte pøístupové právo pro zmìnu tohoto souboru";
$owl_lang->err_nofolderaccess		= "Nemáte pøístupové právo k této složce";
$owl_lang->err_nofolderdelete		= "Nemáte pøístupové právo pro odstranìní této složky";
$owl_lang->err_nofoldermod		= "Nemáte pøístupové právo pro zmìnu této složky";
$owl_lang->err_nosubfolder		= "Nemáte pøístupové právo pro vytváøení podsložek";
$owl_lang->err_note_title               = "The Title is a required field";
$owl_lang->err_note_title_exists        = "A Note with this name Already exists";
$owl_lang->err_noupload			= "Nemáte pøístupové právo pro nahrávání do této složky";
$owl_lang->err_pass_missmatch		= "Nové heslo a potvrzené heslo se neshodují";
$owl_lang->err_pass_wrong    		= "Pùvodní heslo je chybné";
$owl_lang->err_pod2html_not_found       = "ERROR: The pod2html tool was not found:";
$owl_lang->err_quota			= "Pro nahrání souboru nemáte dostateèný limit: ";
$owl_lang->err_quota_needed		= " potøeba ";
$owl_lang->err_quota_avail		= " dostupných.";
$owl_lang->err_quota_exceed  		= "Pøekroèil(a) jste váš limit";
$owl_lang->err_req      		= "ERROR: All Fields are required";
$owl_lang->err_root_delete              = "The Root Folder cannot be deleted";
$owl_lang->err_sess_notvalid 		= "Identifikátor relace není platný";
$owl_lang->err_sess_write		= "Chyba pøi zápisu relace do databáze";
$owl_lang->err_specialfoldername 	= "'backup' is an Owl reserved Folder Name please choose another name";
$owl_lang->err_tar_not_found    	= "tar was not found in ";
$owl_lang->err_trash_can_empty          = "The Trash Can is Empty";
$owl_lang->err_unauth_area   		= "You are not authorized to use this area";
$owl_lang->err_unauthorized  		= "Unauthorized";
$owl_lang->err_upload 			= "Chyba pøi nahrávání souboru";
$owl_lang->err_user_exists		= "Uživatelské jméno již existuje";
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
$owl_lang->alt_del_file      	= "Odstranit soubor (A/N)";
$owl_lang->alt_del_folder    	= "Odstranit složku (A/N)";
$owl_lang->alt_del_group        = "Delete This Group";
$owl_lang->alt_del_news         = "Delete This News";
$owl_lang->alt_del_selected     = "Delete all Selected Files";
$owl_lang->alt_del_this_folder  = "Delete Folder &#8211; ";
$owl_lang->alt_del_user         = "Delete This User";
$owl_lang->alt_edit_group       = "Edit The Selected Group";
$owl_lang->alt_edit_news        = "Edit This News";
$owl_lang->alt_edit_user        = "Edit The Selected User";
$owl_lang->alt_admin_site_prefs = "Edit Site Features and Settings";
$owl_lang->alt_admin_html_prefs = "Edit Site HTML Preferences";
$owl_lang->alt_email            = "Email this File";
$owl_lang->alt_email_selected   = "Email all Selected Files"; 
$owl_lang->alt_btn_expand_view  = "Switch to an Expanded View";
$owl_lang->alt_admin_flush      = "Flush Stale/Expired Sessions";
$owl_lang->alt_get_file      	= "Stáhnout soubor (uložit nebo otevøít; download)";
$owl_lang->alt_get_folder	= "Download Folder Content";
$owl_lang->alt_have_news        = "You Have News Item(s) To View";
$owl_lang->alt_have_no_news     = "No New News Item(s) To View";
$owl_lang->alt_home_folder      = "Back to Intial Dir ";
$owl_lang->alt_set_initial_dir  = "Set Current Dir as Initial";                                                                                                
$owl_lang->alt_site_map         = "Site Map";
$owl_lang->alt_lock_file        = "Odemknout/zamknout soubor pro úpravy";
$owl_lang->alt_log_clear        = "Delete all Logs (Y/N)";
$owl_lang->alt_log_file         = "Záznam souboru";
$owl_lang->alt_log_next         = "Display Next Records";
$owl_lang->alt_log_prev         = "Display Previous Records";
$owl_lang->alt_log_top          = "Go to the First Record";
$owl_lang->alt_btn_login        = "Log in to Owl Intranet";
$owl_lang->alt_btn_logout       = "Log out of Owl Intranet";
$owl_lang->alt_btn_help         = "Owl Online Help";
$owl_lang->alt_mod_file      	= "Upravit vlastnosti souboru";
$owl_lang->alt_mod_folder    	= "Zmìnit vlastnosti složky";
$owl_lang->alt_move_file     	= "Pøesunout soubor";
$owl_lang->alt_copy_file        = "Copy File";
$owl_lang->alt_link_file        = "Link This File to Another Directory";
$owl_lang->alt_move_folder   	= "Pøesunout složku";
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
$owl_lang->alt_btn_admin 	= "Owl - administrace";
$owl_lang->alt_play_file        = "Play Media File";
$owl_lang->alt_recycle          = "Your Trash Can is Empty";
$owl_lang->alt_recycle_disable  = "Trash Collection has been Disabled";
$owl_lang->alt_recycle_not_found= "Trash Can Location Was not Found";
$owl_lang->alt_refresh_filter   = "Initiate Filter / Refresh Results";
$owl_lang->alt_register         = "Submit your Registration";
$owl_lang->alt_btn_browse	= "Zpìt do správce souborù";
$owl_lang->alt_search           = "Initiate The Search";
$owl_lang->alt_send_email       = "Send The Email";
$owl_lang->alt_sendfile         = "Send The File";
$owl_lang->alt_toggle_check_box = "Toggle Check Boxes";
$owl_lang->alt_unlock_file      = "Check file in";
$owl_lang->alt_upd_file      	= "Aktualizovat soubor";
$owl_lang->alt_view_comments    = "Add / View File Comments";
$owl_lang->alt_view_file     	= "Zobrazit soubor";
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

$owl_lang->log_login_det        = "Username: ";
$owl_lang->log_filter_all       = "ALL";
$owl_lang->log_file_to  	= "TO: "; 
$owl_lang->log_detail   	= "No Additional Details";
$owl_lang->log_del_det  	= "Entire Content was also deleted";
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

$owl_lang->anonymous         	= "(Anonymous Access)";
$owl_lang->repository_list      = "Repository:";
$owl_lang->engine               = "Owl Intranet Engine";
$owl_lang->forgot_pass          = "Forgot your password?";
$owl_lang->like_register        = "Would Like to Register?";
$owl_lang->login		= "Pøihlásit";
$owl_lang->loginfail		= "Pøihlášení se nezdaøilo";
$owl_lang->logindisabled	= "Úèet byl VYPNUT, prosím kontaktujte Administrátora";
$owl_lang->password		= "Heslo";
$owl_lang->successlogout 	= "Úspìšnì jste se odhlásili ze systému";
$owl_lang->toomanysessions	= "Maximum sessions for user reached, contact the System Administrator";
$owl_lang->username		= "Uživatelské jméno";
$owl_lang->version 		= "Verze";

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
$owl_lang->actions 			= "Akce";
$owl_lang->del_selected          	= "Delete Selected";
$owl_lang->del_all                      = "Empty Trash";
$owl_lang->rest_selected                = "Restore Selected";
$owl_lang->disk_quota                   = "Disk Quota";
$owl_lang->email_selected        	= "Email Selected";
$owl_lang->file 			= "Soubor";
$owl_lang->folder_policy                = "Current Folder Policy:";
$owl_lang->current_folder               = "Current Folder:";
$owl_lang->held                      	= "Zamèeno"; // for version control
$owl_lang->last_logged              	= "Last on: ";
$owl_lang->current_db                   = "Current Repository:";
$owl_lang->modified 			= "Zmìnìno";
$owl_lang->move_selected         	= "Move Selected";
$owl_lang->new_file                     = "New!";
$owl_lang->no_description               = "No Description Available";
$owl_lang->page                         = "Page:";
$owl_lang->postedby 			= "Uloženo uživatelem";
$owl_lang->reallydelete			= "Opravdu odstranit";
$owl_lang->reallydelete_logs            = "Really Clear the Log File";
$owl_lang->reallydelete_selected	= "Really Delete all selected files";
$owl_lang->reallyrestore_selected       = "Really Restore all selected files";
$owl_lang->size 			= "Velikost";
$owl_lang->score                        = "Score";
$owl_lang->title 			= "Jméno";
$owl_lang->doc_number                   = "Doc #";
$owl_lang->tot_files                    = "Total:";                                                                                         
$owl_lang->tot_my_checked_out           = "Checked Out:";
$owl_lang->tot_my_files         	= "My:";                                                                                                                    
$owl_lang->tot_my_group                 = "Group:";
$owl_lang->tot_new_files                = "New:";
$owl_lang->tot_updated_files            = "Updated:";
$owl_lang->tot_monitored                = "Monitored:";
$owl_lang->updated_file         	= "Updated!";
$owl_lang->user               		= "Uživatel";
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
$owl_lang->adding_comments      = "Adding / Viewing Comments: ";
$owl_lang->comments             = "Comment";
$owl_lang->post_comment         = "Post Comment";
$owl_lang->addingfile 		= "Pøidávám soubor do ";
$owl_lang->addingfolder 	= "Pøídávám složku do ";
$owl_lang->attach_file       	= "Attach File";
$owl_lang->change		= "Zmìnit";
$owl_lang->create		= "Vytvoøit";
$owl_lang->comments_added       = "Comments Added By: ";
$owl_lang->description 		= "Popis";
$owl_lang->email_body		= "Message";
$owl_lang->email_cc          	= "CC";
$owl_lang->email_reply_to	= "Reply To";
$owl_lang->email_subject	= "Subject";
$owl_lang->email_to		= "Mail To";
$owl_lang->emailing		= "Emailing";
$owl_lang->disp_mp3          	= "MP3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Song:<BR>Album:<BR>Bitrate&nbsp;-&nbsp;Samplerate:<BR>Duration:<BR>Genre:<BR>Comments:";
$owl_lang->keywords 		= "Klíèová slova";
$owl_lang->modify_url           = "URL";
$owl_lang->modifying		= "Mìním ";
$owl_lang->name               	= "Jméno";           
$owl_lang->notify_link          = "Owl External Link";
$owl_lang->note_content         = "Note Content";
$owl_lang->ownergroup         	= "Vlastník (skupina)";
$owl_lang->ownership		= "Vlastník";
$owl_lang->permissions 		= "Práva";                                                                                                                        
$owl_lang->prop_permissions     = "Propagate Permissions to subfolders?";
$owl_lang->prop_perms_files     = "Permissions to propagate to files:";
$owl_lang->policy 		= "Pøístupová práva";
$owl_lang->pick_select          = "&#8212; Select an Owl User &#8212;";
$owl_lang->sendfile 		= "Nahrát soubor";
$owl_lang->sendthisfile 	= "Nahrát tento soubor";
$owl_lang->sendthisurl       	= "Send this URL";
$owl_lang->updating		= "Aktualizuji";
$owl_lang->verdescription 	= "Popis<br></br>zmìn";
$owl_lang->vermajor          	= "Vìtší revize";
$owl_lang->vertype           	= "Druh revize";  // for modify.php when uploading
$owl_lang->verminor          	= "Menší revize";

//********************************************************
// modify.php  END
//********************************************************


//********************************************************
// register.php  BEGIN
//********************************************************
                                                                                                       
$owl_lang->email             	= "E-mail";
$owl_lang->full_name         	= "Full Name";
$owl_lang->register          	= "User Registration";
$owl_lang->self_failed   	= "Failed";
$owl_lang->self_passwd   	= "Password Sent to:";
$owl_lang->self_reg_bod  	= "Your Owl Password is:";
$owl_lang->self_reg_rset 	= "Your Owl Password has been reset to:";
$owl_lang->self_reg_subj	= "Your OWL Account";
$owl_lang->send_pass         	= "Send Password";
$owl_lang->submit            	= "Register";
$owl_lang->thank_you_1          = "Thank You!";
$owl_lang->thank_you_2          = "An email will be sent to your email address <BR> with the NEW password for <BR><b>USER:</b>";

//********************************************************
// register.php  END
//********************************************************


//********************************************************
// move.php  BEGIN
//********************************************************

$owl_lang->cancel_button	= "Storno";
$owl_lang->moving		= "Pøesouvám";
$owl_lang->moving_file          = "Moving file";
$owl_lang->moving_folder        = "Moving Folder";
$owl_lang->copy_file            = "Copying file";
$owl_lang->copy_folder          = "Copying Folder";
$owl_lang->select		= "Prosím vyberte novou složku:";

//********************************************************
// move.php  END
//********************************************************


//********************************************************
// log.php  BEGIN
//********************************************************

$owl_lang->viewlog           = "Zobrazuji záznam pro ";

//********************************************************
// log.php  END
//********************************************************


//********************************************************
// prefs.php  BEGIN
//********************************************************

$owl_lang->confpassword	= "Potvrïte nové heslo";
$owl_lang->comment_notif= "Comment Notification";
$owl_lang->email_tool   = "E-Mail Tool";
$owl_lang->last_modified= "Last Modified";
$owl_lang->group	= "Primární skupina";
$owl_lang->groupmember	= "Èlen skupin";
$owl_lang->newpassword	= "Nové heslo";
$owl_lang->newsadmin    = "News Administrator";
$owl_lang->not_member   = "You are not member of any other groups";
$owl_lang->notification = "Dostávat upozornìní";
$owl_lang->oldpassword	= "Pùvodní heslo";
$owl_lang->preference	= "Preferences";
$owl_lang->saved	= "Zmìny uloženy";
$owl_lang->status_no    = "NO";
$owl_lang->status_yes   = "YES";
$owl_lang->userlang	= "Jazyk";

//********************************************************
// prefs.php  END
//********************************************************


//********************************************************
// search.php  BEGIN
//********************************************************

$owl_lang->elapsed_time         = "elapsed time";
$owl_lang->search             	= "Najít";
$owl_lang->search_any_word      = "Any Words";
$owl_lang->search_all_word      = "All Words";
$owl_lang->search_entire_phrase = "Entire Phrase";
$owl_lang->search_match         = "Match:";
$owl_lang->search_currentfolder = "Search Current Folder";
$owl_lang->search_for_folders   = "Searching For Folders";
$owl_lang->search_for_files     = "Searching For Files";
$owl_lang->search_score         = "Scoring Files";
$owl_lang->search_results_for   = "Výsledky hledání pro";
$owl_lang->search_winthindocs   = "Search Within (text, pdf & MS-WORD) Documents";
$owl_lang->related_query_empty  = "No metadata associated with document to perform 'Search Related'";
$owl_lang->query_empty          = "Empty Search String";

//********************************************************
// search.php  END
//********************************************************


//********************************************************
// view.php  BEGIN
//********************************************************

$owl_lang->viewing           = "Zobrazuji soubor ";

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
$owl_lang->add				= "Pøidat";
$owl_lang->anonymous_account            = "Anonynous Access Account:";                                                                                                                      
$owl_lang->buttonstyle                  = "Button Style";
$owl_lang->deleteuser			= "Odstranit uživatele";
$owl_lang->deletegroup			= "Odstranit skupinu";
$owl_lang->disableuser			= "Vypnout uživatele";
$owl_lang->disable_recs_per_page        = "Enabling Restricted View Will DISABLE Records Per Page!";
$owl_lang->file_admin_group             = "File/Browser Admin Group:";
$owl_lang->flushed           		= "Tabulka relací vyprázdnìna, uživatel se nyní mùže znovu pøihlásit.<BR>";
$owl_lang->groups			= "Skupiny";
$owl_lang->hide_bulk_buttons            = "Hide the bulk buttons:";
// Edit HTML Properties Messages
$owl_lang->ht_tbl_border_sz  		= "Table Border Size:";
$owl_lang->ht_tbl_hd_bg      		= "Header Background:";
$owl_lang->ht_tbl_cell_bg_cl 		= "Table Cell Background Colour:";
$owl_lang->ht_tbl_cell_bg_al 		= "Table Cell Background Colour Alternate:";
$owl_lang->ht_expand_width   		= "Expanded View Width:";
$owl_lang->ht_collapse_width 		= "Collapse View Width:";
$owl_lang->ht_bd_bg_image    		= "Body Background Image Path:";
$owl_lang->ht_bd_txt_cl      		= "Body Text Colour:";
$owl_lang->ht_bd_lnk_cl      		= "Body Link Colour:";
$owl_lang->ht_bd_vlnk_cl     		= "Body Visited Link Colour:";
// Edit Prefs Properties Messages
$owl_lang->home_dir                     = "User's Home Directory";
$owl_lang->initial_dir                  = "User's Initial Directory";
$owl_lang->maxsessions			= "Max. poèet relací";
$owl_lang->noprefaccess			= "Nesmí mìnit nastavení";
$owl_lang->owl_anon_full                = "Full Access";
$owl_lang->owl_anon_ro       		= "Set Anonymous to Read Only:";
$owl_lang->owl_anon_download            = "Download Only";
$owl_lang->anonymous_access             = "Set Anonymous Access";
$owl_lang->owl_dbdump_path   		= "DB Dump Tool Path:";
$owl_lang->owl_def_file_group_owner	= "Default File Group Owner:";
$owl_lang->owl_def_file_meta 		= "Default File Meta Data:";
$owl_lang->owl_def_file_owner		= "Default File Owner:";
$owl_lang->owl_def_file_perm 		= "Default File Creation Policy:";
$owl_lang->owl_def_file_security	= "Default File Security:";
$owl_lang->owl_def_file_title		= "Default File Title (None for Filename):";
$owl_lang->owl_def_fold_group_owner  	= "Default Folder Group Owner:";
$owl_lang->owl_def_fold_owner        	= "Default Folder Owner:";
$owl_lang->owl_def_folder_perm 		= "Default Folder Creation Policy:";
$owl_lang->owl_def_fold_sec  		= "Default Folder Security:";
$owl_lang->owl_email_from    		= "From Address / SMTP Auth Login:";
$owl_lang->owl_default_tmpdir   	= "Temp file Directory Location: ";
$owl_lang->owl_email_fromname		= "From Name:";
$owl_lang->owl_email_replyto 		= "Reply To Address:";
$owl_lang->owl_email_server  		= "SMTP Server:";
$owl_lang->owl_email_smtp               = "Use SMTP Mailing Method";
$owl_lang->owl_email_smtp_auth          = "Use SMTP Auth";
$owl_lang->owl_email_smtp_auth_login    = "SMTP Auth Login:";
$owl_lang->owl_email_smtp_auth_passwd   = "SMTP Auth Password";
$owl_lang->owl_email_subject_pref       = "Subject Prefix:";
$owl_lang->owl_fogotpass             	= "Show forgot password link:";
$owl_lang->owl_group_user    		= "Users that are member of this Group";
$owl_lang->owl_gzip_path     		= "gzip Path:";
$owl_lang->owl_hidebackup    		= "Hide the Backup Directory:";
$owl_lang->owl_log_file      		= "Log File Activities:";
$owl_lang->owl_log_login_act		= "Log Login/Logout Activities:";
$owl_lang->owl_log_rec_page  		= "Log Viewer Records Per Page:";
$owl_lang->owl_logging       		= "Enable Logging:";
$owl_lang->owl_logo                  	= "Login Page logo ([Language]/graphics):";
$owl_lang->owl_lookAtHD      		= "Disable Look at hd:";
$owl_lang->owl_lookAtHDDel   		= "Remove Deleted Files From DB:";
$owl_lang->hide_folder_doc_count        = "Hide Folder File Type Count";                                                                                                                        
$owl_lang->hide_folder_size             = "Hide Folder Content Size";
$owl_lang->old_action_icons             = "Use pre Owl 0.80 Action Icons";
$owl_lang->search_result_folders        = "Include Folders in Search Results";
$owl_lang->restore_file_prefix          = "String Prefixed to Restored Files";
$owl_lang->owl_max_filesize  		= "Maximum Upload File Size:";
$owl_lang->owl_owl_expand    		= "Default Browser View (Expand):";
$owl_lang->owl_owl_timeout   		= "Session Timeout in Seconds:";
$owl_lang->virus_path                   = "Virus Checking Software Path<br />Example: '/usr/bin/clamscan --quiet' <br />&#8211; Blank for Disabled:";
$owl_lang->owl_pdftotext_path           = "Maintain Search Index for <BR>PDF and text Files <BR>&#8211; Blank for Disabled:";
$owl_lang->owl_wordtotext_path          = "MS-WORD Files <BR>&#8211; Blank for Disabled:";
$owl_lang->owl_pod2html_path            = "Perl 5.8.0 or Greater required<BR>Path to pod2html:";
$owl_lang->owl_restrict_view 		= "Enable Restricted View Feature:";
$owl_lang->owl_self_reg      		= "Enable Self Register:";
$owl_lang->owl_self_reg_hd   		= "SELF REGISTERED USER DEFAULTS";
$owl_lang->owl_tar_path     		= "tar Path:";
$owl_lang->owl_title_custom             = "CUSTOMIZE BROWSER COLUMNS";
$owl_lang->owl_title_custom_search      = "CUSTOMIZE SEARCH RESULTS";
$owl_lang->owl_title_browser            = "OWL BROWSER FEATURES";
$owl_lang->owl_title_defaults   	= "DEFAULTS";
$owl_lang->owl_title_email   		= "OWL System Mail Settings";
$owl_lang->owl_title_HD      		= "LOOK AT HD FOR NEW FILES SETINGS";
$owl_lang->owl_title_logging  		= "LOGGING SETTINGS";
$owl_lang->owl_title_other   		= "OTHER SETINGS";
$owl_lang->owl_title_tools   		= "DB BACKUP/GZIP TOOLS";
$owl_lang->owl_unzip_path               = "unzip Path:";
$owl_lang->owl_version_control		= "Enable Version Control Feature:";
$owl_lang->quota			= "Limit 0=Disabled";
$owl_lang->reallydeluser                = "This user is owner of %numfiles% File(s) and %numfolders% Folder(s). These File(s) and Folder(s) will be orphaned. Is it Still Ok to Delete?";
$owl_lang->recs_per_page                = "Display Records Per Page (0 = Disabled):";
$owl_lang->remember_me_title            = "PERSISTENT LOGIN SETTINGS";
$owl_lang->remember_me                  = "Show the Remember Me link";
$owl_lang->remember_timeout             = "Cookie timeout in Days";
$owl_lang->remember_me_checkbox         = "Remember me";
$owl_lang->recycle_title                = "TRASH COLLECTION SETTINGS";
$owl_lang->recycle_enabled              = "Enable Trash Collection:";
$owl_lang->recycle_location             = "Trash Can Location:";
$owl_lang->show_panel_title             = "Display Status Panel:";
$owl_lang->show_search_title            = "Display Search Bar:";
$owl_lang->show_pref_title              = "Display Pref/logout Bar:";
$owl_lang->show_bulk_title              = "Display Bulk Buttons:";
$owl_lang->show_action_title            = "Display action Buttons:";
$owl_lang->show_folder_title            = "Display Folder Tools:";
$owl_lang->show_panel                   = "Show";
$owl_lang->hide_panel                   = "Hide";
$owl_lang->status_bar_both              = "Both";
$owl_lang->status_bar_bottom            = "Bottom";
$owl_lang->status_bar_location          = "Display the status bar at the:";
$owl_lang->status_bar_top               = "Top";
$owl_lang->status_bar_not               = "Do Not Display";
$owl_lang->use_popup                    = "Use popup to display News:";
$owl_lang->users			= "Uživatelé";
$owl_lang->header_user_admin            = "User Administration";
$owl_lang->header_group_admin           = "Group Administration";
$owl_lang->header_sitefeatures_settings           = "Site Features and Settings";

//********************************************************
// admin/index.php  END
//********************************************************


//********************************************************
// admin/log.php  BEGIN
//********************************************************

$owl_lang->owl_log_viewer    	= "LOG Viewer";
$owl_lang->owl_log_hd_action 	= "Action";
$owl_lang->owl_log_hd_file   	= "File";
$owl_lang->owl_log_hd_fld_path	= "Folder Path";
$owl_lang->owl_log_hd_user   	= "User";
$owl_lang->owl_log_hd_dt_tm  	= "Date Time";
$owl_lang->owl_log_hd_ip     	= "IP / Address";
$owl_lang->owl_log_hd_agent  	= "Agent";
$owl_lang->owl_log_hd_dtls   	= "Details";
$owl_lang->owl_log_no_rec    	= " NO RECORDS FOUND ";
$owl_lang->owl_log_hide      	= "Hide: ";
$owl_lang->owl_log_filter    	= "Filter";

//********************************************************
// admin/log.php  END
//********************************************************


//********************************************************
// admin/recycle.php  BEGIN
//********************************************************

$owl_lang->empty_trash          = "Empty Trash";
$owl_lang->really_empty_trash   = "Really Empty The Trash Can?";
$owl_lang->recycle_bin_admin    = "Trash Can Administration";

//********************************************************
// admin/recycle.php  END
//********************************************************


//********************************************************
// lib/owl.lib.php  BEGIN
//********************************************************

$owl_lang->file_size_byte               	= "b"; 
$owl_lang->file_size_gigabyte           	= "g";
$owl_lang->file_size_kilobyte           	= "k";
$owl_lang->file_size_megabyte           	= "m";
$owl_lang->notif_subject_new 			= "OWL: novy soubor";
$owl_lang->notif_subject_upd 			= "OWL: zmena souboru";
$owl_lang->notif_subject_monitor 		= "An OWL Intranet File or Folder your are MONITORING was updated";
$owl_lang->notif_subject_comment        	= "An OWL Intranet File -- Comment Added";
$owl_lang->notif_comment_1              	= "commented on";
$owl_lang->notif_comment_2              	= "Comment:";
$owl_lang->notif_msg         			= "Toto je automaticka zprava od MESSAGE FROM OWL Intranet<BR><BR>Click on the link below to view the new/updated file<BR><BR>";
$owl_lang->notif_msg_link               = "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet<BR><BR>Find a link to a new/updated file in this E-Mail<BR><BR>";
$owl_lang->notif_msg_alt_link           = "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet\n\nFind a link to a new/updated file in this E-Mail\n\n";
$owl_lang->notif_msg_alt         		= "Toto je automaticka zprava od MESSAGE FROM OWL Intranet\n\nClick on the link below to view the new/updated file\n\n";
$owl_lang->notif_salutation             	= "Dear";
$owl_lang->notif_user                   = "Created/Update by:";
$owl_lang->owl_path                     	= "File Path: ";
$owl_lang->sessinuse				= "Tato relace je používána na jiném poèítaèi, pøístup zakázán<BR>";
$owl_lang->invalidsess				= "Špatný identifikátor relace, prosím pøihlašte se z hlavní stránky<BR><A HREF='$default->owl_root_url/'>Pøihlášení</A>";
$owl_lang->sesstimeout				= "Vaše relace vypršela, prosím pøihlašte se znovu<BR><A HREF='$default->owl_root_url/'>Pøihlášení</A>";
$owl_lang->everyoneread				= "Každý smí èíst/stáhnout";
$owl_lang->everyonewrite			= "Každý smí èíst/zapisovat/stáhnout";
$owl_lang->everyonewrite_nod			= "Každý smí èíst/zapisovat/stáhnout, BEZ MAZÁNÍ";
$owl_lang->groupread				= "Vaše skupina smí èíst/stáhnout";
$owl_lang->groupwrite				= "Vaše skupina smí èíst/zapisovat/stáhnout";
$owl_lang->groupwrite_nod			= "Vaše skupina smí èíst/zapisovat/stáhnout, BEZ MAZÁNÍ";
$owl_lang->onlyyou				= "Pouze vy smíte èíst/zapisovat/stáhnout";
$owl_lang->donothing                    	= "Do nothing &#8211; Leave file permissions alone";
$owl_lang->groupwrite_worldread 		= "Vaše skupina smí èíst/zapisovat/stáhnout & každý smí èíst";
$owl_lang->groupwrite_worldread_nod 		= "Vaše skupina smí èíst/zapisovat/stáhnout (BEZ MAZÁNÍ) & každý smí èíst";
$owl_lang->ggroupwrite_worldread 		= "Vaše skupina smí nahrávat soubory a odstranit tuto složku & každý smí vidìt obsah";
$owl_lang->ggroupwrite_worldread_nod 		= "Vaše skupina smí nahrávat soubory do této složky (BEZ MAZÁNÍ) & každý smí vidìt obsah";
$owl_lang->everyoneread_ad			= "Každý smí èíst/stáhnout";
$owl_lang->everyonewrite_ad			= "Každý smí èást/zapisovat/stáhnout";
$owl_lang->everyonewrite_ad_nod			= "Každý smí èíst/zapisovat/stáhnout, BEZ MAZÁNÍ";
$owl_lang->groupread_ad				= "Vybraná skupina smí èíst/stáhnout";
$owl_lang->groupwrite_ad			= "Vybraná skupina smí èíst/zapisovat/stáhnout";
$owl_lang->groupwrite_ad_nod			= "Vybraná skupina smí èíst/zapisovat/stáhnout, BEZ MAZÁNÍ";
$owl_lang->onlyyou_ad				= "Pouze vy smíte èíst/zapisovat/stáhnout";
$owl_lang->groupwrite_worldread_ad 		= "vybraná skupina smí èíst/zapisovat/stáhnout & každý smí èíst";
$owl_lang->groupwrite_worldread_ad_nod 		= "Vybraná skupina smí èíst/zapisovat/stáhnout (BEZ MAZÁNÍ) & každý smí èíst";
$owl_lang->ggroupwrite_worldread_ad 		= "Vybraná skupina smí nahrávat soubory a odstranit tuto složku & každý smí vidìt obsah";
$owl_lang->ggroupwrite_worldread_ad_nod 	= "Vybraná skupina smí nahrávat soubory do této složky (BEZ MAZÁNÍ) & každý smí vidìt obsah";
$owl_lang->geveryoneread			= "Každý smí èíst tuto složku";
$owl_lang->geveryonewrite			= "Každý smí nahrávat soubory a odstranit tuto složku";
$owl_lang->geveryonewrite_nod			= "Každý smí nahrávat soubory do této složky";
$owl_lang->ggroupread				= "Vaše skupina smí èíst tuto složku";
$owl_lang->ggroupwrite				= "Vaše skupina smí nahrávat soubory a odstranit tuto složku";
$owl_lang->ggroupwrite_nod			= "Vase skupina smí nahrávat soubory do této složky";
$owl_lang->gonlyyou				= "Pouze vy smíte nahrávat soubory a odstranit tuto složku";
$owl_lang->geveryoneread_ad			= "Každý smí èíst tuto složku";
$owl_lang->geveryonewrite_ad			= "Každý smí nahrávat soubory a odstranit tuto složku";
$owl_lang->geveryonewrite_ad_nod		= "Každý smí nahrávat soubory do této složky";
$owl_lang->ggroupread_ad			= "Vybraná skupina smí èíst tuto složku";
$owl_lang->ggroupwrite_ad    			= "Vybraná skupina smí nahrávat soubory a odstranit tuto složku";
$owl_lang->ggroupwrite_ad_nod			= "Vybraná skupina smí nahrávat soubory do této složky";
$owl_lang->gonlyyou_ad				= "Pouze vy smíte nahrávat soubory a odstranit tuto složku";
$owl_lang->orphaned                     	= "&#8211; NO Owner  &#8211;";
$owl_lang->virus_infected               = "VIRUS INFECTED FILE";
$owl_lang->virus_return_val             = "Virus Program Return value:";

//********************************************************
// lib/owl.lib.php  END
//********************************************************


//********************************************************
// HREF TITLE messages  BEGIN
//********************************************************

$owl_lang->title_browse_folder          = "Browse This Folder";
$owl_lang->title_browse_site            = "Browse to this URL";
$owl_lang->title_download_view          = "Download / View This File";
$owl_lang->title_edit_prefs             = "View / Edit User Preferences";
$owl_lang->title_return_folder          = "Return to";
$owl_lang->title_sort                   = "Order by";
$owl_lang->title_view_new               = "View List of New Files Since My Last Visit";
$owl_lang->title_view_updated           = "View List of Updated Files Since My Last Visit";
$owl_lang->title_view_my                = "View List of My Files";

//********************************************************
// HREF TITLE messages  END
//********************************************************


//********************************************************
// admin/news.php and newsread.php BEGIN
//********************************************************

$owl_lang->news_title                   = "News Administration";
$owl_lang->news_hd                      = "News";
$owl_lang->news_hd_created              = "Created On";
$owl_lang->news_hd_expires              = "Expires On";
$owl_lang->news_hd_audience             = "Target Audience";
$owl_lang->news_heading                 = "News Heading";
$owl_lang->news_content                 = "Content";
$owl_lang->news_posted_date             = "News Posted:";
$owl_lang->news_read                    = "Read";

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

$owl_lang->owl_stats_viewer     = "Statistics Viewer";
$owl_lang->stats_files          = "Number of Files Per Users";
$owl_lang->stats_folders        = "Number of Folders Per Users";
$owl_lang->stats_top            = "Top 20 downloads";
$owl_lang->stats_users          = "USER Signon (Login / Failure / Logout)";
$owl_lang->stats_users_loggedin = "Currently Logged In";
$owl_lang->stats_information    = "Owl Logging and File logging needs to be turned on for this statistics to be displayed";

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
