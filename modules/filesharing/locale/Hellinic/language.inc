<?php

/*

  File: Hellenic/language.inc
  Author: Spiros Vasiliou (aka alfadeck)
  Date: 20/07/2004

  Owl: Copyright Spiros Vasiliou <alfadeck@freemail.gr>

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
	$owl_lang->localized_date_format = "\\<\B\R\\>d-M-y H:i";
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
$owl_lang->err_adding_comments		= "Δεν επιτρέπεται να Προσθέσετε Σχόλια σε αυτό το Αρχείο";
$owl_lang->err_comment_empty            = "Comment cannot be empty";
$owl_lang->err_backup_file   		= "Error backing up existing file";
$owl_lang->err_backup_folder_create 	= "Σφάλμα Δημιουργίας του Φακέλου Backup ";
$owl_lang->err_bad_url			= "Παρακαλώ πληκτρολογήστε μια σωστή URL";
$owl_lang->err_bad_version_1 		= "Το Owl Intranet απαιτεί ως ελάχιστη έκδοση PHP";
$owl_lang->err_bad_version_2 		= "Εκτελείτε την έκδοση";
$owl_lang->err_bad_version_3 		= "Install a newer version of php and try again";
$owl_lang->err_email         		= "Το μύνημα δεν μπόρεσε να αποσταλλεί";
$owl_lang->err_email_required		= "Το πεδίο του Email απαιτείται";
$owl_lang->err_fexist1			= "<b>Το αρχείο υπάρχει:</b>";
$owl_lang->err_fexist2 			= "Υπάρχει ήδη ένα αρχείο με όνομα <i>";
$owl_lang->err_fexist3 			= "</i> στον κατάλογο αυτό.";
$owl_lang->err_file_exists		= "Το αρχείο που προσπαθείτε να ανεβάσετε υπάρχει ήδη";
$owl_lang->err_fileexists    		= "Move was Canceled<BR>File with the same name already exists.";
$owl_lang->err_file_lock     		= "You cannot check this file out, it is currently held by";
$owl_lang->err_update_file_lock         = "You cannot update this file, it is currently held by";
$owl_lang->err_filemove_exist           = "The filename you are trying to rename this file to already exists";
$owl_lang->err_file_not_exist		= "File does not exist on the file system";
$owl_lang->err_file_too_big		= "php.ini upload_max_filesize exceeded and/or<BR>Exceeded Owl Max Upload file size";
$owl_lang->err_file_update		= "Updating a file requires the filename to remain the same, please try again using the same filename";
$owl_lang->err_folder_create 		= "Folder Creation error";
$owl_lang->err_folder_exist		= "This folder already exists";
$owl_lang->err_folderexists  		= "Rename was Canceled<BR>Folder with the same name exists.";
$owl_lang->err_general 			= "An Error has occured";
$owl_lang->err_group_delete		= "You cannot delete a group that has members";
$owl_lang->err_group_exists		= "There is already a group with this name.";
$owl_lang->err_gzip_not_found  		= "gzip was not found in ";
$owl_lang->err_login			= "Please Login to perform this action";
$owl_lang->err_movecancel    		= "Move was Canceled<BR>";
$owl_lang->err_nameempty    		= "Folder name cannot be empty";
$owl_lang->err_news_required		= "ERROR: News Heading and Content are required!";
$owl_lang->err_no_access 		= "You do not have access to any of the files selected";
$owl_lang->err_no_access_info           = "Possible causes: <br></br>1) You did not click any checkbox in front of a File or Folder<br></br>2) Bulk Delete, Bulk Email, Bulk Checkout do not apply to Folders<br></br>3) You do not have access to any of the files or folders you have selected.";
$owl_lang->err_noemail			= "You do not have access to email this file";
$owl_lang->err_nofileaccess		= "You do not have access to this file";
$owl_lang->err_nofiledelete		= "You do not have access to delete this file";
$owl_lang->err_nofilemod		= "You do not have access to modify this file";
$owl_lang->err_nofolderaccess		= "You do not have access to this folder";
$owl_lang->err_nofolderdelete		= "You do not have access to delete this folder";
$owl_lang->err_nofoldermod		= "You do not have access to modify this folder";
$owl_lang->err_nosubfolder		= "You do not have access to create subfolders here";
$owl_lang->err_note_title               = "The Title is a required field";
$owl_lang->err_note_title_exists        = "A Note with this name Already exists";
$owl_lang->err_noupload			= "You do not have access to upload to this folder";
$owl_lang->err_pass_missmatch		= "New Password and Confirm Password don't Match";
$owl_lang->err_pass_wrong    		= "Old Password is wrong";
$owl_lang->err_pod2html_not_found       = "ERROR: The pod2html tool was not found:";
$owl_lang->err_quota			= "You do not have enough quota space to upload this file: ";
$owl_lang->err_quota_needed		= " needed ";
$owl_lang->err_quota_avail		= " available.";
$owl_lang->err_quota_exceed  		= "You have exceeded your quota";
$owl_lang->err_req			= "ERROR: All Fields are required";
$owl_lang->err_root_delete		= "The Root Folder cannot be deleted";
$owl_lang->err_sess_notvalid 		= "Session id is not valid";
$owl_lang->err_sess_write		= "Error writing session information to database";
$owl_lang->err_specialfoldername 	= "'backup' is an Owl reserved Folder Name please choose another name";
$owl_lang->err_tar_not_found  		= "tar was not found in ";
$owl_lang->err_trash_can_empty 		= "The Trash Can is Empty";
$owl_lang->err_unauth_area   		= "You are not authorized to use this area";
$owl_lang->err_unauthorized  		= "Unauthorized";
$owl_lang->err_upload 			= "Upload error";
$owl_lang->err_user_exists		= "Username exists";
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
$owl_lang->alt_add_comments     = "Προσθέστε σχόλιο στο αρχείο";
$owl_lang->alt_btn_add_file     = "Στείλε ένα νέο αρχείο";
$owl_lang->alt_btn_add_folder	= "Δημιούργησε ένα νέο φάκελο";
$owl_lang->alt_add_group	= "Δημιούργησε αυτή την ομόδα";
$owl_lang->alt_add_news		= "Πρόσθεσε μια νέα ειδοποίηση";
$owl_lang->alt_btn_add_note     = "Πρόσθεσε μια νέα σημείωση";
$owl_lang->alt_add_user		= "Δημιούργησε αυτόν τον χρήστη";
$owl_lang->alt_btn_add_url	= "Δημιούργησε ένα νέο Web link";
$owl_lang->alt_cancel		= "Ακύρωσε αυτή την ενέργεια";
$owl_lang->alt_cancel_move	= "Ακύρωσε την μετακίνιση";
$owl_lang->alt_change		= "Ενημέρωσε αυτή την εγγραφή";
$owl_lang->alt_btn_clickhere	= "Κάνε κλικ εδώ";
$owl_lang->alt_btn_collapse_view= "Μετάβαση σε περιορισμένη προβολή";
$owl_lang->alt_comments 	= "Τα σχόλια υπάρχουν για το αρχείο αυτό";
$owl_lang->alt_del_comments     = "Διέγραψε αυτά τα σχόλια ";
$owl_lang->alt_del_file      	= "Διαγραφή αρχείου (Y/N)";
$owl_lang->alt_del_folder    	= "Διαγραφή φακέλου (Y/N)";
$owl_lang->alt_del_group	= "Διέγραψε αυτή την ομάδα";
$owl_lang->alt_del_news		= "Διέγραψε αυτή την ειδοποίηση";
$owl_lang->alt_del_selected	= "Διαγραφή όλων των επιλεγμένων αρχείων";
$owl_lang->alt_del_all          = "Empty Trash";
$owl_lang->alt_rest_selected    = "Restore all Selected Files";
$owl_lang->alt_del_this_folder	= "Διαγραφή φακέλου &#8211; ";
$owl_lang->alt_del_user		= "Διέγραψε αυτόν τον χρήστη";
$owl_lang->alt_edit_group       = "Διόρθωσε την επιλεγμένη ομάδα";
$owl_lang->alt_edit_news	= "Διόρθωσε την επιλεγμένη ειδοποίηση";
$owl_lang->alt_edit_user        = "Διόρθωσε τον επιλεγμένο χρήστη";
$owl_lang->alt_email		= "Στείλε με Email το αρχείο";
$owl_lang->alt_email_selected	= "Στείλε με Email τα επιλεγμένα αρχεία";
$owl_lang->alt_btn_expand_view  = "Μετάβαση σε εκτεταμένη προβολή";
$owl_lang->alt_admin_flush      = "Καθάρισε Stale/Expired Συνδέσεις";
$owl_lang->alt_get_file      	= "Κατέβασε το αρχείο";
$owl_lang->alt_get_folder       = "Download Folder Content";
$owl_lang->alt_have_news	= "Υπάρχουν νέες ειδοποιήσεις για να δείτε";
$owl_lang->alt_have_no_news	= "Δεν υπάρχουν ειδοποιήσεις για να δείτε";
$owl_lang->alt_home_folder	= "Επιστροφή στον αρχικό κατάλογο ";
$owl_lang->alt_set_initial_dir	= "Ορισμός αυτού του καταλόγου ως αρχικού";
$owl_lang->alt_site_map         = "Site Map";
$owl_lang->alt_lock_file        = "Πρόσθεσε κράτηση αρχείου";
$owl_lang->alt_log_clear        = "Διαγραφή όλων των καταγραφών (Y/N)";
$owl_lang->alt_log_file         = "Αρχείο καταγραφής";
$owl_lang->alt_log_next		= "Δείξε τις επόμενες εγγραφές";
$owl_lang->alt_log_prev		= "Δείξε τις προηγούμενες εγγραφές";
$owl_lang->alt_log_top		= "Πήγαινε στην πρώτη εγγραφή";
$owl_lang->alt_btn_login	= "Είσοδος στο Owl Intranet";
$owl_lang->alt_btn_logout	= "Αποσύνδεση από το Owl Intranet";
$owl_lang->alt_btn_help         = "Owl Online Help";
$owl_lang->alt_mod_file      	= "Μεταβολή ιδιοτήτων αρχείου"; 
$owl_lang->alt_mod_folder    	= "Μεταβολή ιδιοτήτων φακέλου";
$owl_lang->alt_move_file     	= "Μετακίνιση αρχείου";
$owl_lang->alt_copy_file        = "Copy File";
$owl_lang->alt_link_file        = "Link This File to Another Directory";
$owl_lang->alt_move_folder   	= "Μετακίνιση φακέλου";
$owl_lang->alt_copy_folder      = "Copy Folder";
$owl_lang->alt_move_selected	= "Μετακίνησε όλα τα επιλεγμένα αρχεία";
$owl_lang->alt_admin_groups	= "Δημιούργησε μια νέα ομάδα";
$owl_lang->alt_news_close	= "Κλείσε το παράθυρο ειδοποιήσεων";
$owl_lang->alt_news_next	= "Δείξε την επόμενη ειδοποίηση";
$owl_lang->alt_news_prev	= "Δείξε την προηγούμενη ειδοποίηση";
$owl_lang->alt_news_print	= "Εκτύπωσε αυτή την ειδοποίηση";
$owl_lang->alt_admin_users	= "Δημιούργησε ενά νέο χρήστη";
$owl_lang->alt_monitor		= "Ξεκίνα παρακολούθηση στο αρχείο";
$owl_lang->alt_monitored	= "Σταμάτα παρακολούθηση στο αρχείο";
$owl_lang->alt_btn_admin 	= "Διαχείριση Owl";
$owl_lang->alt_play_file 	= "Αναπαραγωγή αρχείου πολυμέσων";
$owl_lang->alt_recycle		= "Ο κάδος απορριμάτων είναι άδειος";
$owl_lang->alt_recycle_disable	= "Η συλλογή απορριμάτων έχει απενεργοποιηθεί";
$owl_lang->alt_recycle_not_found= "Η τοποθεσία του Κάδου Απορριμάτων δεν βρέθηκε";
$owl_lang->alt_refresh_filter	= "Ξεκίνα Φιλτρο/Ανανέωση Αποτελεσμάτων";
$owl_lang->alt_register		= "Καταχωρήστε την εγγραφή σας";
$owl_lang->alt_btn_browse	= "Επιστροφή στην προβολή αρχείων";
$owl_lang->alt_search		= "Ξεκίνα την αναζήτηση";
$owl_lang->alt_send_email	= "Στείλε το Email";
$owl_lang->alt_sendfile		= "Στείλε το αρχείο";
$owl_lang->alt_toggle_check_box	= "Εναλλαγή στα σημεία επιλογής";
$owl_lang->alt_unlock_file      = "Αφαίρεσε κράτηση αρχείου";
$owl_lang->alt_upd_file      	= "Ενημέρωσε το αρχείο";
$owl_lang->alt_view_comments    = "Πρόσθεσε/Πρόβαλε σχόλια του αρχείου";
$owl_lang->alt_view_file     	= "Προβολή αρχείου";
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

$owl_lang->log_del_det		= "Ολόκληρο το περιεχόμενο διαγράφηκε επίσης";
$owl_lang->log_detail		= "Δεν υπάρχουν επιπλέον Λεπτομέριες";
$owl_lang->log_file_to		= "ΣΕ: ";
$owl_lang->log_filter_all	= "ΟΛΑ";
$owl_lang->log_login_det	= "Χρήστης: ";
$log_file_actions[1]        	= "ΕΙΣΟΔΟΣ";
$log_file_actions[2]        	= "ΑΠΟΤΥΧΙΑ ΕΙΣΟΔΟΥ";
$log_file_actions[3]        	= "ΑΠΟΣΥΝΔΕΣΗ";
$log_file_actions[4]        	= "ΑΡΧΕΙΟ ΔΙΑΓΡΑΦΗΚΕ";
$log_file_actions[5]        	= "ΑΡΧΕΙΟ ΦΟΡΤΩΘΗΚΕ";
$log_file_actions[6]        	= "ΑΡΧΕΙΟ ΕΝΗΜΕΡΩΘΗΚΕ";
$log_file_actions[7]        	= "ΑΡΧΕΙΟ ΜΕΤΑΦΟΡΤΩΘΗΚΕ";
$log_file_actions[8]        	= "ΑΡΧΕΙΟ ΑΛΛΑΧΘΗΚΕ ";
$log_file_actions[9]        	= "ΑΡΧΕΙΟ ΚΛΕΙΔΩΘΗΚΕ";
$log_file_actions[10]        	= "ΑΡΧΕΙΟ ΞΕΚΛΕΙΔΩΘΗΚΕ";
$log_file_actions[11]        	= "ΑΡΧΕΙΟ EMAILED";
$log_file_actions[12]        	= "ΑΡΧΕΙΟ ΜΕΤΑΚΙΝΗΘΗΚΕ";
$log_file_actions[13]        	= "ΦΑΚΕΛΟΣ ΔΗΜΙΟΥΡΓΗΘΗΚΕ";
$log_file_actions[14]        	= "ΦΑΚΕΛΟΣ ΔΙΑΓΡΑΦΗΚΕ";
$log_file_actions[15]        	= "ΦΑΚΕΛΟΣ ΤΡΟΠΟΠΟΙΗΘΗΚΕ";
$log_file_actions[16]        	= "ΦΑΚΕΛΟΣ ΜΕΤΑΚΙΝΗΘΗΚΕ";
$log_file_actions[17]        	= "ΞΕΧΑΣΤΗΚΕ ΚΩΔΙΚΟΣ";
$log_file_actions[18]        	= "ΚΑΤΑΧΩΡΗΣΗ ΧΡΗΣΤΗ";                                                                                                                                       
$log_file_actions[19]           = "ΑΡΧΕΙΟ ΠΡΟΒΛΗΘΗΚΕ";
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

$owl_lang->anonymous 		= "(Ανώνυμη Πρόσβαση)";
$owl_lang->repository_list      = "Repository:";
$owl_lang->engine 		= "Owl Intranet Engine";
$owl_lang->forgot_pass		= "Ξεχάσατε τον κωδικό σας?";
$owl_lang->like_register	= "Θελέτε να εγγραφείτε?";
$owl_lang->login		= "Είσοδος";
$owl_lang->loginfail		= "Αποτυχία εισόδου";
$owl_lang->logindisabled	= "Ο λογαριασμος σας έχει ΑΠΕΝΕΡΓΟΠΟΙΗΘΕΙ, επικοινωνήστε με τον Διαχειριστή Συστήματος";
$owl_lang->password		= "Κωδικός";
$owl_lang->successlogout 	= "Εχετε αποσυνδεθεί επιτυχώς";
$owl_lang->toomanysessions	= "Μέγιστος αριθμός συνδέσεων χρήστη έχει επιτευχθεί, επικοινωνήστε με τον Διαχειριστή Συστήματος";
$owl_lang->username		= "Ονομα χρήστη";
$owl_lang->version 		= "Εκδοση";

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
$owl_lang->actions 			= "Ενέργειες";
$owl_lang->del_selected			= "Διαγραφή Επιλεγμένου";
$owl_lang->del_all                      = "Empty Trash";
$owl_lang->rest_selected                = "Restore Selected";
$owl_lang->disk_quota			= "Οριο Δίσκου";
$owl_lang->email_selected		= "Αποστολη Email Επιλεγμένου";
$owl_lang->file 			= "Αρχείο";
$owl_lang->folder_policy 		= "Πολιτική Τρέχοντος Φακέλου:";
$owl_lang->current_folder               = "Current Folder:";
$owl_lang->held                      	= "Κράτηση"; 
$owl_lang->last_logged			= "Τελευταία είσοδος: ";
$owl_lang->current_db                   = "Current Repository:";
$owl_lang->modified 			= "Τροποίηση";
$owl_lang->move_selected		= "Μετακίνιση Επιλεγμένων";
$owl_lang->new_file			= "Νέο!";
$owl_lang->no_description		= "Μη διαθέσιμη περιγραφή";
$owl_lang->page				= "Σελίδα:";
$owl_lang->postedby 			= "Αποστολή από";
$owl_lang->reallydelete			= "Διαγραφή";
$owl_lang->reallydelete_logs		= "Να καθαρίσω το αρχείο καταγραφής";
$owl_lang->reallydelete_selected	= "Να διαγράψω όλα τα επιλεγμένα αρχεία";
$owl_lang->reallyrestore_selected       = "Really Restore all selected files";
$owl_lang->size 			= "Μέγεθος";
$owl_lang->score                        = "Score";
$owl_lang->title 			= "Τίτλος";
$owl_lang->doc_number                   = "Doc #";
$owl_lang->tot_files			= "Συνολικά:";
$owl_lang->tot_my_checked_out		= "Κρατημένα:";
$owl_lang->tot_my_files			= "Δικά μου:";
$owl_lang->tot_my_group			= "Ομάδας:";
$owl_lang->tot_new_files		= "Νέα:";
$owl_lang->tot_updated_files		= "Ενημερωμένα:";
$owl_lang->tot_monitored                = "Monitored:";
$owl_lang->updated_file			= "Ενημερωμένο!";
$owl_lang->user               		= "Χρήστης ";
$owl_lang->ver                       	= "Εκδ."; 
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
$owl_lang->adding_comments      = "Πρόσθεσε / Πρόβαλε Σχόλια: ";
$owl_lang->comments             = "Comment";
$owl_lang->post_comment         = "Post Comment";
$owl_lang->addingfile 		= "Προσθήκη αρχείου στο ";
$owl_lang->addingfolder 	= "Προσθήκη φακέλου στο ";
$owl_lang->attach_file		= "Προσκόληση αρχείου";
$owl_lang->change		= "Αλλάξε";
$owl_lang->create		= "Δημιούργησε";
$owl_lang->comments_added       = "Προσθήκη Σχολίων Από: ";
$owl_lang->description 		= "Περιγραφή";
$owl_lang->email_body		= "Κείμενο";
$owl_lang->email_cc          	= "CC";
$owl_lang->email_reply_to	= "Απάντηση Σε";
$owl_lang->email_subject	= "Θέμα";
$owl_lang->email_to		= "Παραλήπτης";
$owl_lang->emailing		= "Αποστολή Email";
$owl_lang->disp_mp3		= "MP3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Song:<BR>Album:<BR>Bitrate&nbsp;-&nbsp;Samplerate:<BR>Duration:<BR>Genre:<BR>Comments:";
$owl_lang->keywords 		= "Λέξεις κλειδία";
$owl_lang->modify_url		= "URL";
$owl_lang->modifying		= "Τροποποίηση ";
$owl_lang->name               	= "Ονομα"; 
$owl_lang->notify_link          = "Εξωτερικό Link Owl";
$owl_lang->note_content         = "Περιεχόμενο Σημείωσης";
$owl_lang->ownergroup         	= "Ιδιοκτησία (Ομάδας)";
$owl_lang->ownership		= "Ιδιοκτήτης";
$owl_lang->permissions 		= "Δικαιώματα";
$owl_lang->prop_permissions 	= "Παρόμοια Δικαιώματα στους υποφακέλους?";
$owl_lang->prop_perms_files 	= "Δικαίωματα που θα αποδοθούν στα αρχεία:";
$owl_lang->policy 		= "Πολιτική";
$owl_lang->pick_select		= "&#8212; Επέλεξε Χρήστη OWL &#8212;";
$owl_lang->sendfile 		= "Αποστολή Αρχείου";
$owl_lang->sendthisfile 	= "Στείλε αυτό το αρχείο";
$owl_lang->sendthisurl       	= "Στείλε αυτό το URL";
$owl_lang->updating		= "Ενημέρωση";
$owl_lang->verdescription 	= "Περιγραφή<br></br>αλλαγών";
$owl_lang->vermajor          	= "Μέγιστη ενημέρωση";
$owl_lang->verminor          	= "Ελάχιστη ενημέρωση";
$owl_lang->vertype           	= "Τύπος ενημερώσεων";  

//********************************************************
// modify.php  END
//********************************************************


//********************************************************
// register.php  BEGIN
//********************************************************

$owl_lang->email             	= "Διεύθυνση Email";
$owl_lang->full_name		= "Πλήρες Όνομα";
$owl_lang->register		= "Καταχώρηση Χρήστη";
$owl_lang->self_failed		= "Απέτυχε";
$owl_lang->self_passwd		= "Ο κωδικός στάλθηκε σε:";
$owl_lang->self_reg_bod		= "Ο κωδικός για το Owl είναι:";
$owl_lang->self_reg_rset	= "Ο κωδικός για το Owl αλλάχθηκε σε:";
$owl_lang->self_reg_subj	= "Ο λογαριασμός σας στο OWL";
$owl_lang->send_pass		= "Αποστολή Κωδικού";
$owl_lang->submit		= "Καταχώρηση";
$owl_lang->thank_you_1		= "Ευχαριστούμε!";
$owl_lang->thank_you_2		= "Ενα email θα σταλεί στην διεύθυνση σας<BR>με τον νεο κωδικό για τον<BR><b>ΧΡΗΣΤΗ :</b>";

//********************************************************
// register.php  END
//********************************************************


//********************************************************
// move.php  BEGIN
//********************************************************

$owl_lang->cancel_button	= "Ακύρωση";
$owl_lang->moving		= "Μετακίνιση";
$owl_lang->moving_file          = "Moving file";
$owl_lang->moving_folder        = "Moving Folder";
$owl_lang->copy_file            = "Copying file";
$owl_lang->copy_folder          = "Copying Folder";
$owl_lang->select		= "Παρακαλώ επιλέξτε νέο φάκελο:";

//********************************************************
// move.php  END
//********************************************************


//********************************************************
// log.php  BEGIN
//********************************************************

$owl_lang->viewlog	= "Προβολή Καταγραφής για ";

//********************************************************
// log.php  END
//********************************************************


//********************************************************
// prefs.php  BEGIN
//********************************************************

$owl_lang->confpassword	= "Επιβεβαιώστε τον νέο κωδικό";
$owl_lang->comment_notif= "Ενημέρωση Σχολίων";
$owl_lang->email_tool   = "E-Mail Tool";
$owl_lang->last_modified= "Last Modified";
$owl_lang->group	= "Πρωτεύουσα Ομάδα";
$owl_lang->groupmember	= "Μέλος Ομάδων";
$owl_lang->newpassword	= "Νέος Κωδικός";
$owl_lang->newsadmin	= "Διαχειριστής Ειδοποιήσεων";
$owl_lang->not_member	= "Δεν είστε μέλος καμίας άλλης ομάδας";
$owl_lang->notification	= "Λήψη Ενημερώσεων";
$owl_lang->oldpassword	= "Παλαιός Κωδικός";
$owl_lang->preference	= "Προτιμήσεις";
$owl_lang->saved	= "Οι αλλαγές αποθηκεύτηκαν";
$owl_lang->status_no	= "ΟΧΙ";
$owl_lang->status_yes	= "ΝΑΙ";
$owl_lang->userlang	= "Γλώσσα";

//********************************************************
// prefs.php  END
//********************************************************


//********************************************************
// search.php  BEGIN
//********************************************************

$owl_lang->elapsed_time       	= "χρόνος εκτέλεσης";
$owl_lang->search             	= "Αναζήτηση";
$owl_lang->search_any_word	= "Οποιασδήποτε λέξης";
$owl_lang->search_all_word	= "Όλων των λέξεων ";
$owl_lang->search_entire_phrase	= "Ολόκληρης φράσης";
$owl_lang->search_match 	= "Ταίριασμα:";
$owl_lang->search_currentfolder = "Αναζήτηση στον τρέχοντα φάκελο";
$owl_lang->search_for_folders 	= "Αναζήτηση για Φακέλους";
$owl_lang->search_for_files 	= "Αναζήτηση για Αρχεία";
$owl_lang->search_score 	= "Βαθμονόμηση Αρχείων";
$owl_lang->search_results_for	= "Αποτελέσματα αναζήτησης για";
$owl_lang->search_winthindocs   = "Αναζήτηση εντός (text & pdf) Αρχείων";
$owl_lang->related_query_empty  = "No metadata associated with document to perform 'Search Related'";
$owl_lang->query_empty       	= "Καθαριστε την γραμμή αναζήτησης";

//********************************************************
// search.php  END
//********************************************************


//********************************************************
// view.php  BEGIN
//********************************************************

$owl_lang->viewing	= "Προβολή ";

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
$owl_lang->add				= "Πρόσθεσε";
$owl_lang->anonymous_account		= "Λογαριασμός Ανώνυμης Πρόσβασης:";
$owl_lang->buttonstyle                  = "Στυλ Κουμπιών";
$owl_lang->deletegroup			= "Διαγραφή Ομάδας";
$owl_lang->deleteuser			= "Διαγραφή Χρήστη";
$owl_lang->disableuser			= "Απενεργοποιήση Χρήστη";
$owl_lang->disable_recs_per_page	= "Η ενεργοποιήση της Περιορισμένης Προβολής θα ΑΠΕΝΕΡΓΟΠΟΙΗΣΗ τις Εγγραφές ανα Σελίδα!";
$owl_lang->file_admin_group		= "Ομάδα Διαχείρισης Προβολης Αρχείων:";
$owl_lang->flushed           		= "Ο πίνακας συνδέσεων μηδενίστηκε,ο χρηστης μπορεί να ξανασυνδεθεί.<BR>";
$owl_lang->groups			= "Ομάδες";
$owl_lang->hide_bulk_buttons		= "Απόκρυψη πλήκτρων μαζικών εργασίων:";
// Edit HTML Properties Messages BEGIN
$owl_lang->ht_tbl_border_sz 		= "Table Border Size:";
$owl_lang->ht_tbl_hd_bg			= "Header Background:";
$owl_lang->ht_tbl_cell_bg_cl 		= "Table Cell Background Colour:";
$owl_lang->ht_tbl_cell_bg_al 		= "Table Cell Background Colour Alternate:";
$owl_lang->ht_expand_width		= "Πλάτος Εκτεταμένης Προβολής:";
$owl_lang->ht_collapse_width 		= "Πλάτος Συμπικνωμένης Προβολής:";
$owl_lang->ht_bd_bg_image		= "Body Background Image Path:";
$owl_lang->ht_bd_txt_cl 		= "Body Text Colour:";
$owl_lang->ht_bd_lnk_cl			= "Body Link Colour:";
$owl_lang->ht_bd_vlnk_cl 		= "Body Visited Link Colour:";
// Edit Prefs Properties Messages END
$owl_lang->home_dir			= "Αρχικός κατάλογος χρήστη";
$owl_lang->initial_dir                  = "User's Initial Directory";
$owl_lang->maxsessions			= "Μέγιστος αριθμός συνδέσεων χρήστη";
$owl_lang->noprefaccess			= "Απενεργοποίηση Ρυθμίσεων";
$owl_lang->owl_anon_full                = "Full Access";
$owl_lang->owl_anon_ro			= "Ανώνυμη Πρόσβαση μόνο για ανάγνωση:";
$owl_lang->owl_anon_download            = "Download Only";
$owl_lang->anonymous_access             = "Set Anonymous Access";
$owl_lang->owl_dbdump_path   		= "DB Dump Tool Path:";
$owl_lang->owl_def_file_group_owner	= "Προεπιλεγμένος Ιδιοκτήτης Ομάδας Αρχείων:";
$owl_lang->owl_def_file_meta		= "Default File Meta Data:";
$owl_lang->owl_def_file_owner		= "Προεπιλεγμένος Ιδιοκτήτης Αρχείου:";
$owl_lang->owl_def_file_perm 		= "Προεπιλεγμένη Πολιτική Δημιουργίας Αρχείου:";
$owl_lang->owl_def_file_security	= "Προεπιλεγμένη Ασφάλεια Αρχείου:";
$owl_lang->owl_def_file_title		= "Προεπιλεγμένος Τίτλος Αρχείου (Τίποτα για εμφάνιση ονόματος αρχείου):";
$owl_lang->owl_def_fold_group_owner	= "Προεπιλεγμένος Ιδιοκτήτης Ομάδας Καταλόγου:";
$owl_lang->owl_def_fold_owner		= "Προεπιλεγμένος Ιδιοκτήτης Καταλόγου:";
$owl_lang->owl_def_fold_sec		= "Προεπιλεγμένη Ασφάλεια Καταλόγου:";
$owl_lang->owl_def_folder_perm 		= "Προεπιλεγμένη Πολιτική Δημιουργίας Καταλόγου:";
$owl_lang->owl_default_tmpdir		= "Temp file Directory Location: ";
$owl_lang->owl_email_from		= "From Address / SMTP Auth Login:";
$owl_lang->owl_email_fromname		= "Από όνομα:";
$owl_lang->owl_email_replyto		= "Απάντηση στην e-mail διεύθυνση:";
$owl_lang->owl_email_server		= "SMTP Server:";
$owl_lang->owl_email_smtp		= "Use SMTP Mailing Method";
$owl_lang->owl_email_smtp_auth		= "Use SMTP Auth";
$owl_lang->owl_email_smtp_auth_login    = "SMTP Auth Login:";
$owl_lang->owl_email_smtp_auth_passwd	= "SMTP Auth Password";
$owl_lang->owl_email_subject_pref	= "Πρόθεμα Θέματος:";
$owl_lang->owl_fogotpass		= "Δείξε τον σύνδεσμο υπενθύμισης κωδικού:";
$owl_lang->owl_group_user		= "Χρήστες που ανήκουν στην ομάδα αυτή";
$owl_lang->owl_gzip_path     		= "gzip Path:";
$owl_lang->owl_hidebackup		= "Κρύψε τον κατάλογο Backup:";
$owl_lang->owl_log_file			= "Κατέγραψε Δραστηριότητες Αρχείων:";
$owl_lang->owl_log_login_act		= "Κατέγραψε Δραστηριότητες Εισόδου/Εξόδου:";
$owl_lang->owl_log_rec_page		= "Εγγραφές καταγραφής ανα σελίδα:";
$owl_lang->owl_logging			= "Ενεργοποίηση Καταγραφής:";
$owl_lang->owl_logo			= "Login Page logo ([Language]/graphics):";
$owl_lang->owl_lookAtHD			= "Απενεργοποίησε την Ανίχνευση στον σκληρό δίσκο:";
$owl_lang->owl_lookAtHDDel		= "Αφαίρεσε τα Διεγραμένα Αρχεία απο την DB:";
$owl_lang->hide_folder_doc_count        = "Hide Folder File Type Count";                                                                                                                        
$owl_lang->hide_folder_size             = "Hide Folder Content Size";
$owl_lang->old_action_icons             = "Use pre Owl 0.80 Action Icons";
$owl_lang->search_result_folders        = "Include Folders in Search Results";
$owl_lang->restore_file_prefix          = "String Prefixed to Restored Files";
$owl_lang->owl_max_filesize		= "Μέγιστο μέγεθος αρχείου Upload:";
$owl_lang->owl_owl_expand		= "Προεπιλεγμένη Προβολή (Επεκτεταμένη):";
$owl_lang->owl_owl_timeout		= "Χρόνος αδράνειας αποσύνδεσης σε Δευτερόλεπτα:";
$owl_lang->virus_path                   = "Virus Checking Software Path<br />Example: '/usr/bin/clamscan --quiet' <br />&#8211; Blank for Disabled:";
$owl_lang->owl_pdftotext_path		= "Maintain Search Index for <BR>PDF and text Files <BR>&#8211; Blank for Disabled:";
$owl_lang->owl_wordtotext_path          = "MS-WORD Files <BR>&#8211; Blank for Disabled:";
$owl_lang->owl_pod2html_path            = "Perl 5.8.0 or Greater required<BR>Path to pod2html:";
$owl_lang->owl_restrict_view		= "Ενεργοποίηση χαρακτηριστικού περιορισμένης προβολής:";
$owl_lang->owl_self_reg			= "Ενεργοποίηση αυτόματης καταχώρησης χρήστη:";
$owl_lang->owl_self_reg_hd		= "ΠΡΟΕΠΙΛΟΓΕΣ ΑΥΤΟΜΑΤΗΣ ΚΑΤΑΧΩΡΗΣΗΣ ΧΡΗΣΤΗ";
$owl_lang->owl_tar_path     		= "tar Path:";
$owl_lang->owl_title_custom             = "CUSTOMIZE BROWSER COLUMNS";
$owl_lang->owl_title_custom_search      = "CUSTOMIZE SEARCH RESULTS";
$owl_lang->owl_title_browser		= "ΧΑΡΑΚΤΗΡΙΣΤΙΚΑ ΠΡΟΒΟΛΗΣ OWL";
$owl_lang->owl_title_defaults   	= "ΠΡΟΕΠΙΛΟΓΕΣ";
$owl_lang->owl_title_email		= "Ρυθμίσεις Ηλεκτρονικού Ταχυδρομείου OWL";
$owl_lang->owl_title_HD			= "ΡΥΘΜIΣΕΙΣ ΑΝΙΧΝΕΥΣΗΣ ΣΚΛΗΡΟΥ ΔΙΣΚΟΥ ΓΙΑ ΝΕΑ ΑΡΧΕΙΑ";
$owl_lang->owl_title_logging  		= "ΡΥΘΜΙΣΕΙΣ ΚΑΤΑΓΡΑΦΗΣ";
$owl_lang->owl_title_other		= "ΑΛΛΕΣ ΡΥΘΜΙΣΕΙΣ";
$owl_lang->owl_title_tools   		= "DB BACKUP/GZIP TOOLS";
$owl_lang->owl_unzip_path     		= "unzip Path:";
$owl_lang->owl_version_control		= "Ενεργοποίηση Ελέγχου Εκδοσης Αρχείου:";
$owl_lang->quota			= "Quota 0=Disabled";
$owl_lang->reallydeluser		= "Αυτός ο χρήστης είναι ιδιοκτήτης %numfiles% αρχείων και %numfolders% καταλόγων. Αυτά τα αρχεία και κατάλογοι θα μείνουν χωρίς ιδιοκτήτη. Θέλετε Σίγουρα να τον διαγράψετε?";
$owl_lang->recs_per_page		= "Προβολή εγγραφών ανά σελίδα (0 = Απενεργοποίηση):";
$owl_lang->remember_me_title		= "ΡΥΘΜΙΣΕΙΣ ΑΥΤΟΜΑΤΗΣ ΣΥΝΔΕΣΗΣ";
$owl_lang->remember_me			= "Προβολή του συνδέσμου Αυτόματης Σύνδεσης";
$owl_lang->remember_timeout		= "Απενεργοποιήση Cookie σε ημέρες";
$owl_lang->remember_me_checkbox		= "Αυτόματη σύνδεση";
$owl_lang->recycle_title		= "ΡΥΘΜΙΣΕΙΣ ΚΑΔΟΥ ΑΝΑΚΥΚΛΩΣΗΣ";
$owl_lang->recycle_enabled		= "Ενεργοποίηση Κάδου Ανακύκλωσης:";
$owl_lang->recycle_location		= "Τοποθεσία Κάδου:";
$owl_lang->show_panel_title             = "Display Status Panel:";
$owl_lang->show_search_title            = "Display Search Bar:";
$owl_lang->show_pref_title              = "Display Pref/logout Bar:";
$owl_lang->show_bulk_title              = "Display Bulk Buttons:";
$owl_lang->show_action_title            = "Display action Buttons:";
$owl_lang->show_folder_title            = "Display Folder Tools:";
$owl_lang->show_panel                   = "Show";
$owl_lang->hide_panel                   = "Hide";
$owl_lang->status_bar_both              = "Και τα δύο";
$owl_lang->status_bar_bottom            = "Κάτω";
$owl_lang->status_bar_location          = "Προβολή της γραμμής κατάστασης στην σελίδα:";
$owl_lang->status_bar_top               = "Πάνω";
$owl_lang->status_bar_not               = "Do Not Display";
$owl_lang->use_popup			= "Χρησημοποιήσε αναδυόμενα παράθυρα προβολής Ειδοποιήσεων:";
$owl_lang->users           		= "Χρήστες";
$owl_lang->header_user_admin            = "User Administration";
$owl_lang->header_group_admin           = "Group Administration";
$owl_lang->header_sitefeatures_settings           = "Site Features and Settings";

//********************************************************
// admin/index.php  END
//********************************************************


//********************************************************
// admin/log.php  BEGIN
//********************************************************

$owl_lang->owl_log_viewer	= "LOG Viewer";
$owl_lang->owl_log_hd_action	= "Δραστηριότητα";
$owl_lang->owl_log_hd_file	= "Αρχείο";
$owl_lang->owl_log_hd_fld_path	= "Διαδρομή Καταλόγου";
$owl_lang->owl_log_hd_user	= "Χρήστης";
$owl_lang->owl_log_hd_dt_tm	= "Ημερ/νια Ώρα";
$owl_lang->owl_log_hd_ip	= "IP / Address";
$owl_lang->owl_log_hd_agent	= "Agent";
$owl_lang->owl_log_hd_dtls	= "Λεπτομέριες";
$owl_lang->owl_log_no_rec	= " ΔΕΝ ΒΡΕΘΗΚΑΝ ΕΓΓΡΑΦΕΣ ";
$owl_lang->owl_log_hide      	= "Απόκρυψη: ";
$owl_lang->owl_log_filter	= "Φιλτρο";

//********************************************************
// admin/log.php  END
//********************************************************


//********************************************************
// admin/recycle.php  BEGIN
//********************************************************

$owl_lang->empty_trash          = "Άδεισμα Κάδου";
$owl_lang->really_empty_trash	= "Να διαγράψω τα περιεχόμενα του Κάδου Ανακύκλωσης?";
$owl_lang->recycle_bin_admin    = "Διαχείριση Κάδου Ανακύκλωσης";

//********************************************************
// admin/recycle.php  END
//********************************************************


//********************************************************
// lib/owl.lib.php  BEGIN
//********************************************************

$owl_lang->file_size_byte		= "b";
$owl_lang->file_size_gigabyte		= "g";
$owl_lang->file_size_kilobyte		= "k";
$owl_lang->file_size_megabyte		= "m";
$owl_lang->notif_subject_new 		= "Νέο OWL Intranet Αρχείο";
$owl_lang->notif_subject_upd 		= "Ένα OWL Intranet αρχείο ενημερώθηκε";
$owl_lang->notif_subject_monitor	= "Ενα OWL Intranet αρχείο ή φάκελος το οποίο το ΠΑΡΑΚΟΛΟΥΘΕΙΤΕ ενημερώθηκε";
$owl_lang->notif_subject_comment	= "Ενα OWL Intranet Αρχείο -- Σχόλιο προστέθηκε";
$owl_lang->notif_comment_1		= "σχολιάστηκε από";
$owl_lang->notif_comment_2		= "Σχόλιο:";
$owl_lang->notif_msg         		= "ΑΥΤΟΜΑΤΟΠΟΙΗΜΕΝΟ ΜΥΝΗΜΑ ΑΠΟ ΤΟ OWL Intranet<BR><BR>Βρείτε το νέο ή ενημερωμένο αρχείο ως συνημμένο σε αυτό το Email<BR><BR>";
$owl_lang->notif_msg_link               = "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet<BR><BR>Find a link to a new/updated file in this E-Mail<BR><BR>";
$owl_lang->notif_msg_alt_link           = "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet\n\nFind a link to a new/updated file in this E-Mail\n\n";
$owl_lang->notif_msg_alt         	= "ΑΥΤΟΜΑΤΟΠΟΙΗΜΕΝΟ ΜΥΝΗΜΑ ΑΠΟ ΤΟ OWL Intranet\n\nΒρείτε το νέο ή ενημερωμένο αρχείο ως συνημμένο σε αυτό το Email\n\n";
$owl_lang->notif_salutation		= "Αγαπητέ/ή";
$owl_lang->notif_user                   = "Created/Update by:";
$owl_lang->owl_path			= "Διαδρομή Αρχείου: ";
$owl_lang->sessinuse			= "Η σύνδεση σας χρησιμοποιείται σε άλλον υπολογιστή, πρόσβαση απορρίπτεται<BR>";
$owl_lang->invalidsess			= "Ακατάλληλο id σύνδεσης, παρακαλω συνδεθείτε από την κεντρική σελίδα<BR>";
$owl_lang->sesstimeout			= "Ξεπεράσατε τον μέγιστο χρόνο αδράνειας και έχετε αποσυνδεθεί.Παρακαλώ συνδεθείτε ξανά.<BR>";
$owl_lang->everyoneread			= "Όλοι μπορούν να διαβάσουν/μεταφορτώσουν";
$owl_lang->everyonewrite		= "Όλοι μπορούν να διαβάσουν/γράψουν/μεταφορτώσουν";
$owl_lang->everyonewrite_nod		= "Όλοι μπορούν να διαβάσουν/γράψουν/μεταφορτώσουν, ΟΧΙ ΔΙΑΓΡΑΦΗ";
$owl_lang->groupread			= "Η ομάδα σας μπορεί να διαβάσει/μεταφορτώσει";
$owl_lang->groupwrite			= "Η ομάδα σας μπορεί να διαβάσει/γράψει/μεταφορτώσει";
$owl_lang->groupwrite_nod		= "Η ομάδα σας μπορεί να διαβάσει/γράψει/μεταφορτώσει, ΟΧΙ ΔΙΑΓΡΑΦΗ";
$owl_lang->onlyyou			= "Μόνο εσείς μπορείτε να διαβάσετε/μεταφορτώσετε/γράψετε";
$owl_lang->donothing                    = "Μην κάνεις τίποτα &#8211; Άσε τις ιδιότητες ίδιες";
$owl_lang->groupwrite_worldread 	= "Η ομάδα σας μπορεί να διαβάσει/γράψει/μεταφορτώσει & οποιοσδήποτε άλλος μπορεί να διαβάσει";
$owl_lang->groupwrite_worldread_nod 	= "Η ομάδα σας μπορεί να διαβάσει/γράψει/μεταφορτώσει (ΟΧΙ ΔΙΑΓΡΑΦΗ) & οποιοσδήποτε άλλος μπορεί να διαβάσει";
$owl_lang->ggroupwrite_worldread 	= "Η ομάδα σας μπορεί να φορτώσει αρχεια και να διαγράψει τον φάκελο & οποιοσδηποτε άλλος μπορεί να δει τα περιεχόμενα";
$owl_lang->ggroupwrite_worldread_nod 	= "Η ομάδα σας μπορεί να φορτώσει αρχεια και να διαγράψει τον φάκελο & οποιοσδηποτε άλλος μπορεί να δει τα περιεχόμενα, ΟΧΙ ΔΙΑΓΡΑΦΗ";
$owl_lang->everyoneread_ad		= "Όλοι μπορούν να διαβάσουν/μεταφορτώσουν";
$owl_lang->everyonewrite_ad		= "Όλοι μπορούν να διαβάσουν/γράψουν/μεταφορτώσουν";
$owl_lang->everyonewrite_ad_nod		= "Όλοι μπορούν να διαβάσουν/γράψουν/μεταφορτώσουν, ΟΧΙ ΔΙΑΓΡΑΦΗ";
$owl_lang->groupread_ad			= "Η επιλεγμένη ομάδα μπορεί να διαβάσει/μεταφορτώσει";
$owl_lang->groupwrite_ad		= "Η επιλεγμένη ομάδα μπορεί να διαβάσει/γράψει/μεταφορτώσει";
$owl_lang->groupwrite_ad_nod		= "Η επιλεγμένη ομάδα μπορεί να διαβάσει/γράψει/μεταφορτώσει, ΟΧΙ ΔΙΑΓΡΑΦΗ";
$owl_lang->onlyyou_ad			= "Μόνο εσείς μπορείτε να διαβάσετε/μεταφορτώσετε/γράψετε";
$owl_lang->groupwrite_worldread_ad 	= "Η επιλεγμένη ομάδα μπορεί να διαβάσει/γράψει/μεταφορτώσει & οποιοσδήποτε άλλος μπορεί να διαβάσει";
$owl_lang->groupwrite_worldread_ad_nod 	= "Η επιλεγμένη ομάδα μπορεί να διαβάσει/γράψει/μεταφορτώσει (ΟΧΙ ΔΙΑΓΡΑΦΗ) & οποιοσδήποτε άλλος μπορεί να διαβάσει";
$owl_lang->ggroupwrite_worldread_ad 	= "Η επιλεγμένη ομάδα μπορεί να φορτώσει αρχεια και να διαγράψει τον φάκελο & οποιοσδηποτε άλλος μπορεί να δει τα περιεχόμενα";
$owl_lang->ggroupwrite_worldread_ad_nod	= "Η επιλεγμενη ομάδα μπορεί να φορτώσει αρχεια και να διαγράψει τον φάκελο & οποιοσδηποτε άλλος μπορεί να δει τα περιεχόμενα, ΟΧΙ ΔΙΑΓΡΑΦΗ";
$owl_lang->geveryoneread		= "Όλοι μπορούν να διαβάσουν τον φάκελο";
$owl_lang->geveryonewrite		= "Όλοι μπορούν να φορτώσουν αρχεία και να διαγράψουν αυτόν τον φάκελο";
$owl_lang->geveryonewrite_nod		= "Όλοι μπορούν να φορτώσουν αρχεία σε αυτόν τον φάκελο";
$owl_lang->ggroupread			= "Η ομάδα σας μπορεί να διαβάσει αυτόν τον φάκελο";
$owl_lang->ggroupwrite			= "Η ομάδα σας μπορεί να φορτώσει αρχεία και να διαγράψει τον φάκελο";
$owl_lang->ggroupwrite_nod		= "Η ομάδα σας μπορεί να φορτώσει αρχεία σε αυτόν τον φάκελο";
$owl_lang->gonlyyou			= "Μόνο εσείς μπορείτε να φορτώσετε αρχεία και να διαγράψετε τον φάκελο";
$owl_lang->geveryoneread_ad		= "Όλοι μπορούν να διαβάσουν τον φάκελο";
$owl_lang->geveryonewrite_ad		= "Όλοι μπορούν να φορτώσουν αρχεία και να διαγράψουν αυτόν τον φάκελο";
$owl_lang->geveryonewrite_ad_nod	= "Όλοι μπορούν να φορτώσουν αρχεία σε αυτόν τον φάκελο";
$owl_lang->ggroupread_ad		= "Η επιλεγμένη ομάδα μπορεί να διαβάσει αυτόν τον φάκελο";
$owl_lang->ggroupwrite_ad    		= "Η επιλεγμένη ομάδα μπορεί να φορτώσει αρχεία και να διαγράψει τον φάκελο";
$owl_lang->ggroupwrite_ad_nod		= "Η επιλεγμενη ομάδα μπορεί να φορτώσει αρχεία σε αυτόν τον φάκελο";
$owl_lang->gonlyyou_ad			= "Μόνο εσείς μπορείτε να φορτώσετε αρχεία και να διαγράψετε τον φάκελο";
$owl_lang->orphaned                     = "&#8211; NO Owner  &#8211;";
$owl_lang->virus_infected               = "VIRUS INFECTED FILE";
$owl_lang->virus_return_val             = "Virus Program Return value:";

//********************************************************
// lib/owl.lib.php  END
//********************************************************


//********************************************************
// HREF TITLE messages  BEGIN
//********************************************************

$owl_lang->title_browse_folder     	= "Προβολή του Φακέλου";
$owl_lang->title_browse_site     	= "Προβολή της URL";
$owl_lang->title_download_view     	= "Κατέβασε / Πρόβαλε το Αρχείο";
$owl_lang->title_edit_prefs     	= "Προβολή / Διόρθωση Προτιμήσεων Χρήστη";
$owl_lang->title_return_folder     	= "Επιστροφή στο";
$owl_lang->title_sort     		= "Ταξινόμηση κατά";
$owl_lang->title_view_new     		= "Προβολη Λίστας των Νέων Αρχείων από την τελευταια μου επίσκεψη";
$owl_lang->title_view_updated     	= "Προβολή Λίστας των Ανανεομένων Αρχείων από την τελευταία μου επίσκεψη";
$owl_lang->title_view_my     		= "Προβολή Λίστας των Αρχείων Μου";

//********************************************************
// HREF TITLE messages  END
//********************************************************


//********************************************************
// admin/news.php and newsread.php BEGIN
//********************************************************

$owl_lang->news_title			= "Διαχείριση Ειδοποιήσεων";
$owl_lang->news_hd			= "Ειδοποιήσεις";
$owl_lang->news_hd_created		= "Δημιουργήθηκε στις";
$owl_lang->news_hd_expires		= "Λήγει στις";
$owl_lang->news_hd_audience		= "Απευθύνεται σε";
$owl_lang->news_heading			= "Επικεφαλίδα Ειδοποίησης";
$owl_lang->news_content			= "Περιεχόμενα";
$owl_lang->news_posted_date		= "Η ειδοποίηση εκδόθηκε:";
$owl_lang->news_read			= "Αναγνώστηκε";

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

$owl_lang->owl_stats_viewer	= "Προβολή Στατιστικών";
$owl_lang->stats_files		= "Αριθμός Αρχείων ανά Χρήστη";
$owl_lang->stats_folders	= "Αριθμός Φακέλων ανά Χρήστη";
$owl_lang->stats_top		= "Top 20 downloads";
$owl_lang->stats_users          = "USER Signon (Login / Failure / Logout)";
$owl_lang->stats_users_loggedin = "Currently Logged In";
$owl_lang->stats_information	= "Η καταγραφή Owl και η καταγραφή αρχείων πρέπει να ενεργοποιηθεί για να προβληθούν τα στατιστικά αυτά";

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
$owl_lang->doc_new_doc_type     = "&#8211; ADD New Document Type &#8211;";
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
