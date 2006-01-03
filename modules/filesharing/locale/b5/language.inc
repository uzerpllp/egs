<?php

/*

  File: b5/language.inc
  Author: Wen-ping Lee <liwenpin@tpts5.seed.net.tw>
  Date: 2001/08/13

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
// All Error Messages BEGIN
//********************************************************

$owl_lang->err_select_reviewer          = "Please select at least one Person to review your document";
$owl_lang->err_adding_comments          = "您沒有權限新增註解/評論到這個檔案";
$owl_lang->err_comment_empty            = "Comment cannot be empty";
$owl_lang->err_backup_file   		= "備份現存的檔案錯誤";
$owl_lang->err_backup_folder_create     = "Backup Folder Creation error";
$owl_lang->err_bad_url                  = "請輸入一個正確的網址";
$owl_lang->err_bad_version_1 		= "知識庫基本需要的PHP版本";
$owl_lang->err_bad_version_2 		= "您正在使用的版本";
$owl_lang->err_bad_version_3 		= "請更新您的PHP並且再試一次";
$owl_lang->err_email			= "訊息無法被送出";
$owl_lang->err_email_required   	= "郵件資料欄位是必要的";
$owl_lang->err_fexist1  		= "<b>檔案位置:</b>";
$owl_lang->err_fexist2 			= "這個檔名已經存在<i>";
$owl_lang->err_fexist3 			= "</i> 在這個目錄";
$owl_lang->err_file_exists		= "您要上傳的檔案已經存在";
$owl_lang->err_fileexists		= "移動取消<BR>檔案依原有名字存在";
$owl_lang->err_file_lock     		= "You cannot check this file out, it is currently held by";
$owl_lang->err_update_file_lock         = "You cannot update this file, it is currently held by";
$owl_lang->err_filemove_exist           = "這個檔名已經存在請您修改後再試一次";
$owl_lang->err_file_update   		= "Updating a file requires the filename to remain the same, please try again using the same filename";
$owl_lang->err_file_not_exist 		= "無法建立檔案";
$owl_lang->err_file_too_big     	= "php.ini upload_max_filesize 超越或者<BR>超越知識庫最大檔案大小限制";
$owl_lang->err_folder_create 		= "資料夾建立失敗";
$owl_lang->err_folder_exist  		= "這個資料夾已經存在";
$owl_lang->err_folderexists		= "重新命名取消<BR>資料夾依原有名字存在";
$owl_lang->err_general       		= "有一個錯誤被發現";
$owl_lang->err_group_delete             = "您不能刪除含有成員的群組";
$owl_lang->err_group_exists             = "有一個相同名字的群組已經存在";
$owl_lang->err_gzip_not_found   	= "gzip 不能被找到";
$owl_lang->err_login   			= "請登入來完成這個動作";
$owl_lang->err_movecancel  		= "移動取消<BR>";
$owl_lang->err_nameempty     		= "名稱不能空白";
$owl_lang->err_news_required            = "錯誤: News Heading and Content are required!";
$owl_lang->err_no_access       		= "您沒有任何權限更動檔案";
$owl_lang->err_no_access_info           = "Possible causes: <br></br>1) You did not click any checkbox in front of a File or Folder<br></br>2) Bulk Delete, Bulk Email, Bulk Checkout do not apply to Folders<br></br>3) You do not have access to any of the files or folders you have selected.";
$owl_lang->err_noemail           	= "您沒有權限寄送這個檔案";
$owl_lang->err_nofileaccess		= "您沒有權限存取這個檔案";
$owl_lang->err_nofiledelete		= "您沒有權限刪除這個檔案";
$owl_lang->err_nofilemod		= "您沒有權限存取這個檔案";
$owl_lang->err_nofolderaccess		= "您沒有權限存取這個資料夾";
$owl_lang->err_nofolderdelete		= "您沒有權限刪除這個資料夾";
$owl_lang->err_nofoldermod		= "您沒有權限修改這個資料夾";
$owl_lang->err_nosubfolder		= "您沒有權限在這裡新增資料夾";
$owl_lang->err_note_title               = "主題欄位是必要的";
$owl_lang->err_note_title_exists        = "有一個同名的筆記已經存在";
$owl_lang->err_noupload			= "您沒有權限上傳檔案到這個資料夾";
$owl_lang->err_pass_missmatch		= "兩次輸入的密碼不相同";
$owl_lang->err_pass_wrong    		= "舊密碼是錯誤的";
$owl_lang->err_pod2html_not_found       = "錯誤: pod2html 工具不能被找到:";
$owl_lang->err_quota         		= "您沒有足夠的空間來上傳檔案: ";
$owl_lang->err_quota_needed  		= "需要";
$owl_lang->err_quota_avail   		= "可用的";
$owl_lang->err_quota_exceed  		= "您已經超越您的磁碟配額了";
$owl_lang->err_req      		= "錯誤:全部的欄位都是必要的";
$owl_lang->err_root_delete              = "這個根目錄不能刪除";
$owl_lang->err_sess_notvalid 		= "登入逾時";
$owl_lang->err_sess_write    		= "寫入登入資訊到資料庫錯誤";
$owl_lang->err_specialfoldername 	= "'backup' 是知識庫保留的資料夾名稱，請選擇其他名稱";
$owl_lang->err_tar_not_found    	= "tar 不能被找到 ";
$owl_lang->err_trash_can_empty          = "垃圾桶是空的";
$owl_lang->err_unauth_area   		= "您沒有權限使用這個區域";
$owl_lang->err_unauthorized  		= "未經授權";
$owl_lang->err_upload        		= "上傳錯誤";
$owl_lang->err_user_exists   		= "使用者名稱已經存在";
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
$owl_lang->alt_add_comments     = "新增一個註解/評論到這個檔案";
$owl_lang->alt_btn_add_file     = "上傳一個新檔案";
$owl_lang->alt_btn_add_folder   = "建立一個新的資料夾";
$owl_lang->alt_add_group        = "建立這個群組";
$owl_lang->alt_add_news         = "新增一個新聞記事";
$owl_lang->alt_btn_add_note     = "撰寫一個新的筆記";
$owl_lang->alt_add_user         = "建立這個使用者";
$owl_lang->alt_btn_add_url      = "新增一個連結";
$owl_lang->alt_cancel           = "Cancle This Action";
$owl_lang->alt_cancel_move      = "Cancel Move Action";
$owl_lang->alt_change           = "更新這個紀錄";
$owl_lang->alt_btn_clickhere    = "請按這裡";
$owl_lang->alt_btn_collapse_view= "Switch to a Reduced View";
$owl_lang->alt_comments         = "Comments Exist for this File";
$owl_lang->alt_del_comments     = "刪除這則註解/評論";
$owl_lang->alt_del_file      	= "刪除這個檔案 (Y/N)";
$owl_lang->alt_del_folder    	= "刪除這個資料夾 (Y/N)";
$owl_lang->alt_del_group        = "刪除這個群組";
$owl_lang->alt_del_news         = "刪除這則新聞";
$owl_lang->alt_del_selected     = "刪除所有選擇的檔案";
$owl_lang->alt_del_all          = "Empty Trash";
$owl_lang->alt_rest_selected    = "Restore all Selected Files";
$owl_lang->alt_del_this_folder  = "刪除資料夾 &#8211; ";
$owl_lang->alt_del_user         = "刪除這個使用者";
$owl_lang->alt_edit_group       = "編輯群組";
$owl_lang->alt_edit_news        = "編輯這則新聞";
$owl_lang->alt_edit_user        = "編輯使用者";
$owl_lang->alt_email            = "寄送著個檔案";
$owl_lang->alt_email_selected   = "寄送所有選擇的檔案"; 
$owl_lang->alt_btn_expand_view  = "Switch to an Expanded View";
$owl_lang->alt_admin_flush      = "Flush Stale/Expired Sessions";
$owl_lang->alt_get_file      	= "下載檔案";
$owl_lang->alt_get_folder       = "Download Folder Content";
$owl_lang->alt_have_news        = "You Have News Item(s) To View";
$owl_lang->alt_have_no_news     = "No New News Item(s) To View";
$owl_lang->alt_home_folder      = "Back to Intial Dir ";
$owl_lang->alt_set_initial_dir  = "Set Current Dir as Initial";
$owl_lang->alt_site_map         = "Site Map";
$owl_lang->alt_lock_file        = "Check file out";
$owl_lang->alt_log_clear        = "是否刪除所有的紀錄 (Y/N)";
$owl_lang->alt_log_file         = "File Log";
$owl_lang->alt_log_next         = "Display Next Records";
$owl_lang->alt_log_prev         = "Display Previous Records";
$owl_lang->alt_log_top          = "到第一筆";
$owl_lang->alt_btn_login        = "登入知識庫";
$owl_lang->alt_btn_logout       = "登出知識庫";
$owl_lang->alt_btn_help         = "Owl Online Help";
$owl_lang->alt_mod_file      	= "變更檔案屬性";
$owl_lang->alt_mod_folder    	= "修改資料夾屬性";
$owl_lang->alt_move_file     	= "移動檔案";
$owl_lang->alt_copy_file        = "Copy File";
$owl_lang->alt_link_file        = "Link This File to Another Directory";
$owl_lang->alt_move_folder   	= "移動資料夾";
$owl_lang->alt_copy_folder      = "Copy Folder";
$owl_lang->alt_move_selected    = "移動所有選擇的檔案"; 
$owl_lang->alt_admin_groups 	= "建立一個新的群組"; 
$owl_lang->alt_news_close       = "關閉新聞視窗";
$owl_lang->alt_news_next        = "下一則新聞";
$owl_lang->alt_news_prev        = "Display Previous News Item";
$owl_lang->alt_news_print       = "列印這則新聞";
$owl_lang->alt_admin_users      = "建立一個新使用者";
$owl_lang->alt_monitor  	= "Monitor this File";
$owl_lang->alt_monitored        = "Stop Monitoring this File";
$owl_lang->alt_btn_admin        = "知識庫管理";
$owl_lang->alt_play_file        = "撥放媒體檔";
$owl_lang->alt_recycle          = "您的垃圾桶是空的";
$owl_lang->alt_recycle_disable  = "Trash Collection has been Disabled";
$owl_lang->alt_recycle_not_found= "Trash Can Location Was not Found";
$owl_lang->alt_refresh_filter   = "Initiate Filter / Refresh Results";
$owl_lang->alt_register         = "Submit your Registration";
$owl_lang->alt_btn_browse       = "進入知識庫";
$owl_lang->alt_search           = "搜尋";
$owl_lang->alt_send_email       = "寄送郵件";
$owl_lang->alt_sendfile         = "寄送這個檔案";
$owl_lang->alt_toggle_check_box = "全選";
$owl_lang->alt_unlock_file      = "Check file in";
$owl_lang->alt_upd_file      	= "更新檔案";
$owl_lang->alt_view_comments    = "Add / View File Comments";
$owl_lang->alt_view_file     	= "檢視檔案內容";
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
$owl_lang->log_file_to          = "收信人: ";
$owl_lang->log_filter_all       = "全";
$owl_lang->log_login_det        = "使用者名稱: ";
$log_file_actions[1]            = "登入";
$log_file_actions[2]            = "登入失敗";
$log_file_actions[3]            = "登出";
$log_file_actions[4]            = "刪除檔案";
$log_file_actions[5]            = "上載檔案";
$log_file_actions[6]            = "更新檔案";
$log_file_actions[7]            = "下載檔案";
$log_file_actions[8]            = "變更檔案";
$log_file_actions[9]            = "檔案上鎖";
$log_file_actions[10]           = "解除鎖定";
$log_file_actions[11]           = "寄送檔案";
$log_file_actions[12]           = "移動檔案";
$log_file_actions[13]           = "變更資料夾";
$log_file_actions[14]           = "刪除資料夾";
$log_file_actions[15]           = "變更資料夾";
$log_file_actions[16]           = "移動資料夾";
$log_file_actions[17]           = "資料夾權限";
$log_file_actions[18]           = "使用者 REG";
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

$owl_lang->anonymous         	= "(匿名登入)";
$owl_lang->repository_list      = "Repository:";
$owl_lang->engine 		= "知識庫";
$owl_lang->forgot_pass      	= "忘記您的密碼?";
$owl_lang->like_register     	= "想註冊嗎?";
$owl_lang->login		= "登入";
$owl_lang->loginfail		= "登入失敗";
$owl_lang->logindisabled     	= "您的使用者帳號是被封鎖的,有任何問題,請聯絡管理員";
$owl_lang->password		= "使用者密碼";
$owl_lang->successlogout 	= "您已經成功登出";
$owl_lang->toomanysessions	= "您達到最大的連線限制,有任何問題,請聯絡管理員";
$owl_lang->username		= "使用者名稱";
$owl_lang->version 		= "版本";

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
$owl_lang->actions 			= "動作";
$owl_lang->del_selected          	= "Delete Selected";
$owl_lang->del_all                      = "Empty Trash";
$owl_lang->rest_selected                = "Restore Selected";
$owl_lang->disk_quota                   = "磁碟配額";
$owl_lang->email_selected        	= "Email Selected";
$owl_lang->file 			= "檔案名稱";
$owl_lang->folder_policy                = "目前的資料夾權限:";
$owl_lang->current_folder               = "Current Folder:";
$owl_lang->held                      	= "隱藏"; // for version control
$owl_lang->last_logged              	= "上次登入: ";
$owl_lang->current_db                   = "Current Repository:";
$owl_lang->modified 			= "修改";
$owl_lang->move_selected         	= "Move Selected";
$owl_lang->new_file                     = "新!";
$owl_lang->no_description               = "No Description Available";
$owl_lang->page                         = "Page:";
$owl_lang->postedby 			= "發表人";
$owl_lang->reallydelete			= "真的要刪除";
$owl_lang->reallydelete_logs            = "真的刪除紀錄檔";
$owl_lang->reallydelete_selected	= "您確定要刪除所有選擇的檔案嗎?";
$owl_lang->reallyrestore_selected       = "Really Restore all selected files";
$owl_lang->size 			= "檔案大小";
$owl_lang->score                        = "Score";
$owl_lang->title 			= "顯示名稱";
$owl_lang->doc_number                   = "Doc #";
$owl_lang->tot_files                    = "總計:";
$owl_lang->tot_my_checked_out           = "Checked Out:";
$owl_lang->tot_my_files         	= "我的:";
$owl_lang->tot_my_group                 = "Group:";
$owl_lang->tot_new_files                = "新:";
$owl_lang->tot_updated_files            = "上載檔案:";
$owl_lang->tot_monitored                = "Monitored:";
$owl_lang->updated_file         	= "更新!";
$owl_lang->user               		= "使用者";
$owl_lang->ver                       	= "版本 "; // for version control
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
$owl_lang->addingfile 		= "新增一個檔案到 ";
$owl_lang->addingfolder 	= "新增一個資料夾到 ";
$owl_lang->attach_file       	= "附加檔案";
$owl_lang->change		= "更改";
$owl_lang->create		= "創造";
$owl_lang->comments_added       = "Comments Added By: ";
$owl_lang->description 		= "描述";
$owl_lang->disp_mp3          	= "MP3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Song:<BR>Album:<BR>Bitrate&nbsp;-&nbsp;Samplerate:<BR>Duration:<BR>Genre:<BR>Comments:";
$owl_lang->emailing          	= "Emailing";
$owl_lang->email_body        	= "訊息";
$owl_lang->email_cc          	= "副本";
$owl_lang->email_reply_to    	= "回信至";
$owl_lang->email_subject     	= "主旨";
$owl_lang->email_to          	= "Mail To";
$owl_lang->keywords 		= "關鍵字";
$owl_lang->modify_url           = "連結";
$owl_lang->modifying		= "修改中";
$owl_lang->name               	= "名稱";                                                                                                                                                   
$owl_lang->notify_link          = "Owl External Link";
$owl_lang->note_content         = "Note Content";
$owl_lang->ownergroup         	= "擁有者(群組)";
$owl_lang->ownership		= "擁有者";
$owl_lang->permissions 		= "權限";                                                                                                                         
$owl_lang->prop_permissions     = "Propagate Permissions to subfolders?";
$owl_lang->prop_perms_files     = "Permissions to propagate to files:";
$owl_lang->policy 		= "目前權限";
$owl_lang->pick_select          = "&#8212; 選則一個使用者 &#8212;";
$owl_lang->sendfile 		= "送出";
$owl_lang->sendthisfile 	= "送出這個檔案";
$owl_lang->sendthisurl       	= "Send this URL";
$owl_lang->updating          	= "Updating";
$owl_lang->verdescription	= "Description<br></br>of changes";
$owl_lang->vermajor          	= "Major Revision";
$owl_lang->verminor          	= "Minor Revision";
$owl_lang->vertype           	= "Revision type";  

//********************************************************
// modify.php  END
//********************************************************


//********************************************************
// register.php  BEGIN
//********************************************************
                                                                                                                  
$owl_lang->email             	= "電子郵件位址";
$owl_lang->full_name         	= "顯示名稱";
$owl_lang->register          	= "使用者註冊";
$owl_lang->self_reg_subj	= "您的OWL帳號資訊";
$owl_lang->self_reg_bod  	= "您的密碼是:";
$owl_lang->self_reg_rset 	= "Your Owl Password has been reset to:";
$owl_lang->submit            	= "註冊";
$owl_lang->send_pass         	= "寄送密碼";
$owl_lang->self_failed   	= "Failed";
$owl_lang->self_passwd   	= "密碼寄至:";
$owl_lang->thank_you_1          = "謝謝您!";
$owl_lang->thank_you_2          = "有一封點子郵件已經寄往您指定的郵寄位址<BR>裡面包含有您的新密碼<BR><b>使用者:</b>";

//********************************************************
// register.php  END
//********************************************************


//********************************************************
// move.php  BEGIN
//********************************************************

$owl_lang->cancel_button     = "取消";
$owl_lang->moving            = "移動中";
$owl_lang->moving_file          = "Moving file";
$owl_lang->moving_folder        = "Moving Folder";
$owl_lang->copy_file            = "Copying file";
$owl_lang->copy_folder          = "Copying Folder";
$owl_lang->select            = "請選擇一個目的地資料夾:";

//********************************************************
// move.php  END
//********************************************************


//********************************************************
// log.php  BEGIN
//********************************************************

$owl_lang->viewlog	= "Viewing Log For ";

//********************************************************
// log.php  END
//********************************************************


//********************************************************
// prefs.php  BEGIN
//********************************************************

$owl_lang->confpassword = "確認新密碼";
$owl_lang->comment_notif= "Comment Notification";
$owl_lang->email_tool   = "E-Mail Tool";
$owl_lang->last_modified= "Last Modified";
$owl_lang->group	= "主要群組";
$owl_lang->groupmember	= "成員群組";
$owl_lang->oldpassword  = "舊密碼";
$owl_lang->newpassword  = "新密碼";
$owl_lang->newsadmin    = "News Administrator";
$owl_lang->not_member   = "You are not member of any other groups";
$owl_lang->notification = "Receive Notifications";
$owl_lang->preference  	= "偏好設定";
$owl_lang->saved	= "變更已經儲存";
$owl_lang->status_no    = "NO";
$owl_lang->status_yes   = "YES";
$owl_lang->userlang     = "語言";

//********************************************************
// prefs.php  END
//********************************************************


//********************************************************
// search.php  BEGIN
//********************************************************

$owl_lang->elapsed_time         = "elapsed time";
$owl_lang->search             	= "搜尋";
$owl_lang->search_any_word      = "Any Words";
$owl_lang->search_all_word      = "All Words";
$owl_lang->search_entire_phrase = "Entire Phrase";
$owl_lang->search_match         = "Match:";
$owl_lang->search_currentfolder = "Search Current Folder";
$owl_lang->search_for_folders   = "搜尋資料夾";
$owl_lang->search_for_files     = "搜尋檔案";
$owl_lang->search_score         = "Scoring Files";
$owl_lang->search_results_for 	= "Search results for";
$owl_lang->search_winthindocs   = "搜尋包含Text和PDF文件 and MS-Word";
$owl_lang->related_query_empty  = "No metadata associated with document to perform 'Search Related'";
$owl_lang->query_empty      	= "Empty Search String";

//********************************************************
// search.php  END
//********************************************************


//********************************************************
// view.php  BEGIN
//********************************************************

$owl_lang->viewing 	= "Viewing ";

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
$owl_lang->add				= "增加";
$owl_lang->anonymous_account            = "Anonynous Access Account:";                                                                                                                      
$owl_lang->buttonstyle                  = "按鈕樣式";
$owl_lang->deleteuser			= "刪除使用者";
$owl_lang->deletegroup			= "刪除群組";
$owl_lang->disableuser       		= "禁止使用";
$owl_lang->disable_recs_per_page        = "Enabling Restricted View Will DISABLE Records Per Page!";
$owl_lang->file_admin_group             = "File/Browser Admin Group:";
$owl_lang->flushed           		= "Session table flushed, user can now log in again.<BR>";
$owl_lang->groups			= "群組";
$owl_lang->hide_bulk_buttons            = "Hide the bulk buttons:";
// Edit HTML Properties Messages
$owl_lang->ht_tbl_border_sz  		= "表格框線粗細:";
$owl_lang->ht_tbl_hd_bg      		= "Header Background:";
$owl_lang->ht_tbl_cell_bg_cl 		= "Table Cell Background Colour:";
$owl_lang->ht_tbl_cell_bg_al 		= "Table Cell Background Colour Alternate:";
$owl_lang->ht_expand_width   		= "Expanded View Width:";
$owl_lang->ht_collapse_width 		= "Collapse View Width:";
$owl_lang->ht_bd_bg_image    		= "背景圖示路徑:";
$owl_lang->ht_bd_txt_cl      		= "字體顏色:";
$owl_lang->ht_bd_lnk_cl      		= "連結顏色:";
$owl_lang->ht_bd_vlnk_cl     		= "連結顏色(滑鼠移至時):";
// Edit Prefs Properties Messages
$owl_lang->home_dir                     = "User's Home Directory";
$owl_lang->initial_dir                  = "User's Initial Directory";
$owl_lang->maxsessions       		= "同時最大連線數";
$owl_lang->noprefacces      		= "Disable Pref";
$owl_lang->owl_anon_full                = "Full Access";
$owl_lang->owl_anon_ro                  = "Read Only";
$owl_lang->owl_anon_download            = "Download Only";
$owl_lang->anonymous_access             = "Set Anonymous Access";
$owl_lang->owl_dbdump_path   		= "DB Dump Tool Path:";
$owl_lang->owl_def_file_group_owner	= "Default File Group Owner:";
$owl_lang->owl_def_file_meta 		= "Default File Meta Data:";
$owl_lang->owl_def_file_owner		= "Default File Owner:";
$owl_lang->owl_def_file_perm 		= "Default File Creation Policy:";
$owl_lang->owl_def_file_security	= "Default File Security:";
$owl_lang->owl_def_file_title		= "Default File Title (None for Filename):";
$owl_lang->owl_def_fold_group_owner	= "預設資叫夾擁有群組:";
$owl_lang->owl_def_fold_owner        	= "預設資料夾擁有者:";
$owl_lang->owl_def_fold_sec  		= "Default Folder Security:";
$owl_lang->owl_def_folder_perm 		= "Default Folder Creation Policy:";
$owl_lang->owl_default_tmpdir   	= "Temp file Directory Location: ";
$owl_lang->owl_email_from    		= "From Address / SMTP Auth Login:";
$owl_lang->owl_email_fromname		= "From Name:";
$owl_lang->owl_email_replyto 		= "Reply To Address:";
$owl_lang->owl_email_server  		= "SMTP主機:";
$owl_lang->owl_email_smtp               = "Use SMTP Mailing Method";
$owl_lang->owl_email_smtp_auth          = "Use SMTP Auth";
$owl_lang->owl_email_smtp_auth_login    = "SMTP Auth Login:";
$owl_lang->owl_email_smtp_auth_passwd   = "SMTP Auth Password";
$owl_lang->owl_email_subject_pref       = "Subject Prefix:";
$owl_lang->owl_fogotpass             	= "顯示忘記密碼連結:";
$owl_lang->owl_group_user    		= "Users that are member of this Group";
$owl_lang->owl_gzip_path     		= "gzip 路徑:";
$owl_lang->owl_hidebackup    		= "隱藏 Backup 資料夾:";
$owl_lang->owl_log_file      		= "紀錄檔案活動:";
$owl_lang->owl_log_login_act 		= "紀錄登入登出活動:";
$owl_lang->owl_log_rec_page  		= "Log Viewer Records Per Page:";
$owl_lang->owl_logging       		= "Enable Logging:";
$owl_lang->owl_logo                  	= "登入頁面logo圖示 ([Language]/graphics):";
$owl_lang->owl_lookAtHD      		= "Disable Look at hd:";
$owl_lang->owl_lookAtHDDel   		= "Remove Deleted Files From DB:";
$owl_lang->hide_folder_doc_count        = "Hide Folder File Type Count";                                                                                                                        
$owl_lang->hide_folder_size             = "Hide Folder Content Size";
$owl_lang->old_action_icons             = "Use pre Owl 0.80 Action Icons";
$owl_lang->search_result_folders        = "Include Folders in Search Results";
$owl_lang->restore_file_prefix          = "String Prefixed to Restored Files";
$owl_lang->owl_max_filesize  		= "最大檔案上傳限制:";
$owl_lang->owl_owl_expand    		= "Default Browser View (Expand):";
$owl_lang->virus_path                   = "Virus Checking Software Path<br />Example: '/usr/bin/clamscan --quiet' <br />&#8211; Blank for Disabled:";
$owl_lang->owl_owl_timeout   		= "登入逾時秒數:";
$owl_lang->owl_pdftotext_path           = "Maintain Search Index for <BR>PDF and text Files <BR>&#8211; Blank for Disabled:";
$owl_lang->owl_wordtotext_path          = "MS-WORD Files <BR>&#8211; Blank for Disabled:";
$owl_lang->owl_pod2html_path            = "Perl 5.8.0 or Greater required<BR>Path to pod2html:";
$owl_lang->owl_restrict_view 		= "Enable Restricted View Feature:";
$owl_lang->owl_self_reg      		= "Enable Self Register:";
$owl_lang->owl_self_reg_hd   		= "SELF REGISTERED USER DEFAULTS";
$owl_lang->owl_tar_path     		= "tar 路徑:";
$owl_lang->owl_title_custom_search      = "CUSTOMIZE SEARCH RESULTS";
$owl_lang->owl_title_browser            = "OWL BROWSER FEATURES";
$owl_lang->owl_title_browser            = "OWL BROWSER FEATURES";
$owl_lang->owl_title_defaults   	= "DEFAULTS";
$owl_lang->owl_title_email   		= "知識庫郵件設定";
$owl_lang->owl_title_HD      		= "LOOK AT HD FOR NEW FILES SETINGS";
$owl_lang->owl_title_logging  		= "LOGGING SETTINGS";
$owl_lang->owl_title_other   		= "其他偏好設定";
$owl_lang->owl_title_tools   		= "資料庫備份/GZIP 工具";
$owl_lang->owl_unzip_path               = "unzip 路徑:";
$owl_lang->owl_version_control		= "Enable Version Control Feature:";
$owl_lang->quota			= "磁碟空間配額  0=關閉此功能";
$owl_lang->reallydeluser                = "This user is owner of %numfiles% File(s) and %numfolders% Folder(s). These File(s) and Folder(s) will be orphaned. Is it Still Ok to Delete?";
$owl_lang->recs_per_page                = "Display Records Per Page (0 = Disabled):";
$owl_lang->remember_me_title            = "PERSISTENT LOGIN SETTINGS";
$owl_lang->remember_me                  = "Show the Remember Me link";
$owl_lang->remember_timeout             = "Cookie timeout in Days";
$owl_lang->remember_me_checkbox         = "Remember me";
$owl_lang->recycle_title                = "TRASH COLLECTION SETTINGS";
$owl_lang->recycle_enabled              = "Enable Trash Collection:";
$owl_lang->recycle_location             = "垃圾桶位置:";
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
$owl_lang->use_popup                    = "使用彈跳視窗(popup)展示新聞:";
$owl_lang->users			= "使用者";
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
$owl_lang->owl_log_hd_action 	= "動作";
$owl_lang->owl_log_hd_file   	= "檔案";
$owl_lang->owl_log_hd_fld_path	= "資料夾路徑";
$owl_lang->owl_log_hd_user   	= "使用者";
$owl_lang->owl_log_hd_dt_tm  	= "Date Time";
$owl_lang->owl_log_hd_ip     	= "IP位址";
$owl_lang->owl_log_hd_agent  	= "Agent";
$owl_lang->owl_log_hd_dtls   	= "Details";
$owl_lang->owl_log_no_rec    	= "找不到任何紀錄";
$owl_lang->owl_log_hide      	= "隱藏: ";
$owl_lang->owl_log_filter    	= "資料夾";

//********************************************************
// admin/log.php  END
//********************************************************


//********************************************************
// admin/recycle.php  BEGIN
//********************************************************

$owl_lang->empty_trash          = "清空垃圾桶";
$owl_lang->really_empty_trash   = "您確定要輕空垃圾桶嗎?";
$owl_lang->recycle_bin_admin    = "垃圾桶管理員";

//********************************************************
// admin/recycle.php  END
//********************************************************


//********************************************************
// lib/owl.lib.php  BEGIN
//********************************************************

$owl_lang->file_size_byte               = "byte";
$owl_lang->file_size_gigabyte           = "GB";
$owl_lang->file_size_kilobyte           = "KB";
$owl_lang->file_size_megabyte           = "MB";
$owl_lang->notif_subject_new 		= "新的知識庫檔案";
$owl_lang->notif_subject_upd 		= "有一個知識庫檔案已經更新";
$owl_lang->notif_subject_monitor 	= "An OWL Intranet File or Folder your are MONITORING was updated";
$owl_lang->notif_subject_comment        = "An OWL Intranet File -- Comment Added";
$owl_lang->notif_comment_1              = "commented on";
$owl_lang->notif_comment_2              = "註解:";
$owl_lang->notif_msg         		= "這是一個知識庫自動產生的訊息<BR><BR>找到新的更新 attached to this Email<BR><BR>";
$owl_lang->notif_msg_link               = "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet<BR><BR>Find a link to a new/updated file in this E-Mail<BR><BR>";
$owl_lang->notif_msg_alt_link           = "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet\n\nFind a link to a new/updated file in this E-Mail\n\n";
$owl_lang->notif_msg_alt         	= "這是一個知識庫自動產生的訊息t\n\n找到新的更新 attached to this Email\n\n";
$owl_lang->notif_salutation             = "親愛的";
$owl_lang->notif_user                   = "Created/Update by:";
$owl_lang->owl_path                     = "檔案路徑: ";
$owl_lang->sessinuse			= "拒絕存取，這個連現正在被另一台電腦使用<BR>";
$owl_lang->invalidsess			= "無效的連線編號, 請從主頁登入<BR>";
$owl_lang->sesstimeout			= "連線已經逾時, 請重新登入<BR>";
$owl_lang->everyoneread			= "每個人都可以讀/下載";
$owl_lang->everyonewrite		= "每個人都可以讀/寫/下載";
$owl_lang->everyonewrite_nod 		= "每個人都可以讀/寫/下載,不能刪除";
$owl_lang->groupread			= "您的群組可以讀/下載";
$owl_lang->groupwrite			= "您的群組可以讀/寫/下載";
$owl_lang->groupwrite_nod    		= "您的群組可以讀/寫/下載,不能刪除";
$owl_lang->onlyyou			= "只有你可以讀/寫/下載";                                                                                
$owl_lang->donothing                    = "沒有任何權限 &#8211; 檔案為私有的";
$owl_lang->groupwrite_worldread 	= "您的群組可以讀/寫/下載 且 任何人可以讀";
$owl_lang->groupwrite_worldread_nod 	= "您的群組可以讀/寫/下載 (不能刪除) 且 任何人可以讀";
$owl_lang->ggroupwrite_worldread 	= "您的群組可以上傳檔案和刪除這個資料夾 且 任何人可以檢視目錄";
$owl_lang->ggroupwrite_worldread_nod 	= "您的群組可以上傳檔案到這個資料夾 且 任何人可以檢視目錄 (不能刪除)";
$owl_lang->everyoneread_ad   		= "任何人可以讀/下載";
$owl_lang->everyonewrite_ad  		= "任何人可以讀/寫/下載";
$owl_lang->everyonewrite_ad_nod      	= "任何人可以讀/寫/下載, 不能刪除";
$owl_lang->groupread_ad      		= "指定的群組可以讀/下載";
$owl_lang->groupwrite_ad     		= "指定的群組可以讀/寫/下載";
$owl_lang->groupwrite_ad_nod 		= "指定的群組可以讀/寫/下載, 不能刪除";
$owl_lang->onlyyou_ad        		= "只有您可以讀/下載/寫";
$owl_lang->groupwrite_worldread_ad 	= "指定的群組可以讀/寫/下載 且 任何人可以讀";
$owl_lang->groupwrite_worldread_ad_nod 	= "指定的群組可以讀/寫/下載 (不能刪除) 且 任何人可以讀";
$owl_lang->ggroupwrite_worldread_ad 	= "指定的群組可以上傳檔案和刪除這個資料夾 且 任何人可以檢視目錄";
$owl_lang->ggroupwrite_worldread_ad_nod = "所指定的群組可以上傳檔案到這個資料夾 且 任何人可以檢視目錄 (不能刪除)";
$owl_lang->geveryoneread		= "每個人都可以讀取這個資料夾";
$owl_lang->geveryonewrite		= "每個人都可以上傳檔案和刪除這個資料夾";
$owl_lang->geveryonewrite_nod		= "任何人可以上傳檔案至這個資料夾";
$owl_lang->ggroupread			= "您的群組可以讀取這個資料夾";
$owl_lang->ggroupwrite			= "您的群組可以上傳檔案和刪除這個資料夾";
$owl_lang->ggroupwrite_nod   		= "您的群組可以上傳檔案到著個資料夾";
$owl_lang->gonlyyou			= "只有您可以上傳檔案和刪除這個資料夾";
$owl_lang->geveryoneread_ad		= "每個人都可以讀取這個資料夾";
$owl_lang->geveryonewrite_ad		= "每個人都可以上傳檔案和刪除這個資料夾";
$owl_lang->geveryonewrite_ad_nod     	= "任何人可以上傳檔案到這個資料夾";
$owl_lang->ggroupread_ad		= "所選擇的群組可以讀取這個資料夾";
$owl_lang->ggroupwrite_ad		= "所選擇的群組可以上傳檔案和刪除這個資料夾";
$owl_lang->ggroupwrite_ad_nod		= "指定的群組可以上傳檔案到這個資料夾";
$owl_lang->gonlyyou_ad			= "只有您可以上傳檔案和刪除這個資料夾";
$owl_lang->orphaned                     = "&#8211; NO Owner  &#8211;";
$owl_lang->virus_infected               = "VIRUS INFECTED FILE";
$owl_lang->virus_return_val             = "Virus Program Return value:";

//********************************************************
// lib/owl.lib.php  END
//********************************************************


//********************************************************
// HREF TITLE messages  BEGIN
//********************************************************

$owl_lang->title_browse_folder          = "瀏覽這個資料夾";
$owl_lang->title_browse_site            = "瀏覽這個網站(連結)";
$owl_lang->title_download_view          = "下載 / 檢視這個檔案";
$owl_lang->title_edit_prefs             = "檢視 / 編輯使用者偏好設定";
$owl_lang->title_return_folder          = "Return to";
$owl_lang->title_sort                   = "排序";
$owl_lang->title_view_new               = "View List of New Files Since My Last Visit";
$owl_lang->title_view_updated           = "View List of Updated Files Since My Last Visit";
$owl_lang->title_view_my                = "View List of My Files";

//********************************************************
// HREF TITLE messages  END
//********************************************************


//********************************************************
// admin/news.php and newsread.php BEGIN
//********************************************************

$owl_lang->news_title                   = "新聞管理員";
$owl_lang->news_hd                      = "新聞";
$owl_lang->news_hd_created              = "Created On";
$owl_lang->news_hd_expires              = "Expires On";
$owl_lang->news_hd_audience             = "Target Audience";
$owl_lang->news_heading                 = "News Heading";
$owl_lang->news_content                 = "Content";
$owl_lang->news_posted_date             = "News Posted:";
$owl_lang->news_read                    = "閱讀";

//********************************************************
// admin/news.php and newsread.php  END
//********************************************************


//********************************************************
// DEBUG MESSAGES BEGIN
//********************************************************

$owl_lang->debug_tmp_not_exists         = "除錯: The OWL temporary Directory: $default->owl_tmpdir does not exists.";
$owl_lang->debug_tmp_not_writeable      = "除錯: The OWL temporary Directory: $default->owl_tmpdir is not writeable.";
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
$owl_lang->stats_top            = "下載前二十名";
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
