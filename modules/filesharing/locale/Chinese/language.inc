<?php

/*

  File: Chinese/language.inc
  Author: Chris 
  Modify: Edwin Evaner
  Date: 2003/04/07

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
$owl_lang->err_adding_comments          = "您没有给这个文件添加注释的权限";
$owl_lang->err_comment_empty            = "Comment cannot be empty";
$owl_lang->err_backup_file   		= "备份当前文件出错";
$owl_lang->err_bad_url                  = "Please enter a valid URL";
$owl_lang->err_backup_folder_create	= "备份文件夹创建出错";
$owl_lang->err_bad_version_1 		= "Owl Intranet 需要最少的 PHP 版本";
$owl_lang->err_bad_version_2 		= "你运行的版本是";
$owl_lang->err_bad_version_3 		= "安装一个新版本的PHP后再试";
$owl_lang->err_email         		= "信息无法发送";
$owl_lang->err_email_required   	= "Email 必须填写";
$owl_lang->err_fexist1  		= "<b>存在文件:</b>";
$owl_lang->err_fexist2 			= "已有文件同名 <i>";
$owl_lang->err_fexist3 			= "</i> 在这个目录.";
$owl_lang->err_file_exists		= "您上传的这个文件已经存在";
$owl_lang->err_fileexists    		= "转移已取消<BR>发现有文件名相同.";
$owl_lang->err_file_lock     		= "你不能访问这个文件,它当前已经锁定给";
$owl_lang->err_update_file_lock         = "You cannot update this file, it is currently held by";
$owl_lang->err_filemove_exist           = "The filename you are trying to rename this file to already exists";
$owl_lang->err_file_not_exist 		= "这个文件在文件系统中没有找到";
$owl_lang->err_file_too_big     	= "php.ini upload_max_filesize 超过了 或许<BR>超越了 Owl 最大上转文件大小";
$owl_lang->err_file_update   		= "上传的文件已有保留相同的文件名字, 请用其他的名字";
$owl_lang->err_folder_create 		= "创建文件夹出错";
$owl_lang->err_folder_exist  		= "这个文件夹已经存在";
$owl_lang->err_folderexists  		= "改名已取消<BR>发现有文件夹名相同.";
$owl_lang->err_general       		= "发生了一个错误";
$owl_lang->err_group_delete             = "你不能在还有成员的时候删除这个组";
$owl_lang->err_group_exists             = "已经有这个名字的组.";
$owl_lang->err_gzip_not_found   	= "gzip 没有找到位于 ";
$owl_lang->err_login   			= "请登录";
$owl_lang->err_movecancel    		= "转移已经取消<BR>";
$owl_lang->err_nameempty     		= "文件夹的名字不能是空的";
$owl_lang->err_news_required            = "ERROR: 信息头和内容必须填写!";
$owl_lang->err_no_access       		= "您没有权限使用您选择的文件";
$owl_lang->err_no_access_info           = "Possible causes: <br></br>1) You did not click any checkbox in front of a File or Folder<br></br>2) Bulk Delete, Bulk Email, Bulk Checkout do not apply to Folders<br></br>3) You do not have access to any of the files or folders you have selected.";
$owl_lang->err_noemail           	= "您没有发送这个文件的许可";
$owl_lang->err_nofileaccess		= "您没有权限打开这个文件";
$owl_lang->err_nofiledelete		= "您没有权限删除这个文件";
$owl_lang->err_nofilemod		= "您没有权限修改这个文件";
$owl_lang->err_nofolderaccess		= "您没有权限打开这个文件夹";
$owl_lang->err_nofolderdelete		= "您没有权限删除这个文件夹";
$owl_lang->err_nofoldermod		= "您没有权限修改这个文件夹";
$owl_lang->err_nosubfolder		= "您没有权限在这个地方创建子文件夹";
$owl_lang->err_note_title               = "这个标题需要一个字段";
$owl_lang->err_note_title_exists        = "这个注释的名字已经存在";
$owl_lang->err_noupload			= "您没有上传到这个文件夹的权限";
$owl_lang->err_pass_missmatch		= "新密码和验证密码不吻合";
$owl_lang->err_pass_wrong    		= "原密码不正确";
$owl_lang->err_pod2html_not_found       = "ERROR: The pod2html tool was not found:";
$owl_lang->err_quota         		= "您没有足够的许可空间上传这个文件: ";
$owl_lang->err_quota_needed  		= " 需要 ";
$owl_lang->err_quota_avail   		= " 可用.";
$owl_lang->err_quota_exceed  		= "您超过了许可空间配额";
$owl_lang->err_req     			= "ERROR: 需要填写所有的字段";
$owl_lang->err_root_delete              = "The Root Folder cannot be deleted";
$owl_lang->err_sess_notvalid 		= "进程号无效";
$owl_lang->err_sess_write    		= "写入进程信息到数据库出错";
$owl_lang->err_specialfoldername 	= "'backup' 是个 Owl 保留的文件夹名字,清选择其他的名字";
$owl_lang->err_tar_not_found    	= "tar 没有找到位于 ";
$owl_lang->err_trash_can_empty          = "垃圾箱已经空了";
$owl_lang->err_unauth_area   		= "您没有访问这个区域的许可";
$owl_lang->err_unauthorized  		= "没有许可";
$owl_lang->err_upload        		= "上传出错";
$owl_lang->err_user_exists   		= "用户名已存在";
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
$owl_lang->alt_add_comments     = "给这个文件添加注释";
$owl_lang->alt_btn_add_file     = "上传一个新文件";
$owl_lang->alt_btn_add_folder   = "创建一个新文件夹";
$owl_lang->alt_add_group        = "创建一个新的组";
$owl_lang->alt_add_news		= "添加新消息";
$owl_lang->alt_btn_add_note     = "Add a New Note";
$owl_lang->alt_add_user		= "创建这个用户";
$owl_lang->alt_btn_add_url	= "创建一个网页连接";
$owl_lang->alt_cancel		= "取消这个操作";
$owl_lang->alt_cancel_move	= "取消转移操作";
$owl_lang->alt_change		= "更新已纪录";
$owl_lang->alt_btn_clickhere	= "点击这个";
$owl_lang->alt_btn_collapse_view= "切换到缩小显示";
$owl_lang->alt_comments 	= "这个文件已经有注释";
$owl_lang->alt_del_comments     = "删除这个注释";
$owl_lang->alt_del_file      	= "删除文件 (Y/N)";
$owl_lang->alt_del_folder    	= "删除文件夹 (Y/N)";
$owl_lang->alt_del_group	= "删除这个组";
$owl_lang->alt_del_news		= "删除这消息";
$owl_lang->alt_del_selected	= "删除所有选中文件";
$owl_lang->alt_del_all          = "Empty Trash";
$owl_lang->alt_rest_selected    = "Restore all Selected Files";
$owl_lang->alt_del_this_folder	= "删除文件夹 &#8211; ";
$owl_lang->alt_del_user		= "删除这个用户";
$owl_lang->alt_edit_group       = "编辑选中的组";
$owl_lang->alt_edit_news	= "编辑这个消息";
$owl_lang->alt_edit_user        = "编辑选择的用户";
$owl_lang->alt_email		= "邮寄这个文件";
$owl_lang->alt_email_selected	= "邮寄所有选中文件";
$owl_lang->alt_btn_expand_view  = "切换到扩展显示";
$owl_lang->alt_admin_flush      = "重设状态/过期进程";
$owl_lang->alt_get_file      	= "下载文件";
$owl_lang->alt_get_folder       = "Download Folder Content";
$owl_lang->alt_have_news	= "你收道消息可以察看";
$owl_lang->alt_have_no_news	= "没有消息";
$owl_lang->alt_home_folder      = "Back to Intial Dir ";
$owl_lang->alt_set_initial_dir  = "Set Current Dir as Initial";                                                                                                
$owl_lang->alt_site_map         = "Site Map";
$owl_lang->alt_lock_file        = "Check file out";
$owl_lang->alt_log_clear        = "Delete all Logs (Y/N)";
$owl_lang->alt_log_file         = "文件日志";
$owl_lang->alt_log_next		= "显示下个记录";
$owl_lang->alt_log_prev		= "显示上个记录";
$owl_lang->alt_log_top		= "转到第一个记录";
$owl_lang->alt_btn_login 	= "登录到文件系统中";
$owl_lang->alt_btn_logout	= "退出OWL文件系统";
$owl_lang->alt_btn_help         = "Owl Online Help";
$owl_lang->alt_mod_file      	= "修改文件属性"; 
$owl_lang->alt_mod_folder    	= "修改文件夹属性";
$owl_lang->alt_move_file     	= "移动文件";
$owl_lang->alt_copy_file        = "Copy File";
$owl_lang->alt_link_file        = "Link This File to Another Directory";
$owl_lang->alt_move_folder   	= "移动文件夹";
$owl_lang->alt_copy_folder      = "Copy Folder";
$owl_lang->alt_move_selected	= "转移所有选中的文件";
$owl_lang->alt_admin_groups	= "创建一个新的组";
$owl_lang->alt_news_close	= "关闭公告板窗口";
$owl_lang->alt_news_next	= "显示下个公告";
$owl_lang->alt_news_prev	= "显示上个公告";
$owl_lang->alt_news_print	= "打印这条公告";
$owl_lang->alt_admin_users	= "创建一个新用户";
$owl_lang->alt_monitor		= "显示这个文件";
$owl_lang->alt_monitored	= "停止显示这个文件";
$owl_lang->alt_btn_admin 	= "维护管理";
$owl_lang->alt_play_file 	= "播放多媒体文件";
$owl_lang->alt_recycle		= "您的垃圾桶已经空了";
$owl_lang->alt_recycle_disable	= "垃圾桶功能被禁止";
$owl_lang->alt_recycle_not_found= "垃圾桶位置没有找到";
$owl_lang->alt_refresh_filter	= "初始化 / 刷新结果";
$owl_lang->alt_register		= "提交您的注册";
$owl_lang->alt_btn_browse	= "返回文件浏览";
$owl_lang->alt_search		= "查找";
$owl_lang->alt_send_email	= "发送 Email";
$owl_lang->alt_sendfile		= "发送文件";
$owl_lang->alt_toggle_check_box	= "Toggle Check Boxes";
$owl_lang->alt_unlock_file      = "Check file in";
$owl_lang->alt_upd_file      	= "更新文件";
$owl_lang->alt_view_comments    = "添加/察看文件注释";
$owl_lang->alt_view_file     	= "查看文件";
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

$owl_lang->log_del_det		= "内容也已删除";
$owl_lang->log_detail		= "没有扩展信息";
$owl_lang->log_file_to		= "到: ";
$owl_lang->log_filter_all	= "全部";
$owl_lang->log_login_det	= "用户名: ";
$log_file_actions[1]            = "登录";
$log_file_actions[2]            = "登录失败";
$log_file_actions[3]            = "注销";
$log_file_actions[4]            = "文件删除";
$log_file_actions[5]            = "文件上传";
$log_file_actions[6]            = "文件更新";
$log_file_actions[7]            = "文件下载";
$log_file_actions[8]            = "文件修改";
$log_file_actions[9]            = "文件锁定";
$log_file_actions[10]           = "文件解锁";
$log_file_actions[11]           = "文件邮寄";
$log_file_actions[12]           = "文件夹转移";
$log_file_actions[13]           = "文件夹创建";
$log_file_actions[14]           = "文件夹删除";
$log_file_actions[15]           = "文件夹修改";
$log_file_actions[16]           = "文件夹转移";
$log_file_actions[17]           = "忘记密码";
$log_file_actions[18]           = "用户注册";                                                                                                                                       
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

$owl_lang->anonymous 		= "(匿名登录)";
$owl_lang->repository_list      = "Repository:";
$owl_lang->engine 		= "OWL文件管理系统";
$owl_lang->forgot_pass		= "把密码忘记了?";
$owl_lang->like_register	= "要去注册吗?";
$owl_lang->login		= "登录";
$owl_lang->loginfail		= "登录失败";
$owl_lang->logindisabled	= "帐号已被封掉,请联系管理员";
$owl_lang->password		= "密码";
$owl_lang->successlogout 	= "您已经成功注销";
$owl_lang->toomanysessions	= "已经到达了最大进程许可,请联系管理员";
$owl_lang->username		= "用户名";
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
$owl_lang->actions 			= "操作";
$owl_lang->del_selected          	= "删除了";
$owl_lang->del_all                      = "Empty Trash";
$owl_lang->rest_selected                = "Restore Selected";
$owl_lang->disk_quota                   = "空间配额";
$owl_lang->email_selected        	= "Email 选中";
$owl_lang->file 			= "文件";
$owl_lang->folder_policy                = "Current Folder Policy:";
$owl_lang->current_folder               = "Current Folder:";
$owl_lang->held                      	= "Held"; // for version control
$owl_lang->last_logged              	= "最后登录在:";
$owl_lang->current_db                   = "Current Repository:";
$owl_lang->modified 			= "修改时间";
$owl_lang->move_selected         	= "Move Selected";
$owl_lang->new_file                     = "New!";
$owl_lang->no_description               = "没有解释";                                                                                                                  
$owl_lang->page                         = "Page:";
$owl_lang->postedby 			= "上传于";
$owl_lang->reallydelete			= "确定删除";
$owl_lang->reallydelete_logs            = "Really Clear the Log File";
$owl_lang->reallydelete_selected	= "确定删除所有文件";
$owl_lang->reallyrestore_selected       = "Really Restore all selected files";
$owl_lang->size 			= "大小";
$owl_lang->score                        = "Score";
$owl_lang->title 			= "标题";
$owl_lang->doc_number                   = "Doc #";
$owl_lang->tot_files                    = "总共有:";    
$owl_lang->tot_my_checked_out           = "Checked Out:";
$owl_lang->tot_my_files         	= "我有:";
$owl_lang->tot_my_group                 = "Group:";
$owl_lang->tot_new_files                = "新的有:";
$owl_lang->tot_updated_files            = "更新:";
$owl_lang->tot_monitored                = "Monitored:";
$owl_lang->updated_file         	= "更新!";
$owl_lang->user               		= "用户";
$owl_lang->ver                       	= "版本."; // for version control
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
$owl_lang->adding_comments      = "添加 / 察看 注释: ";
$owl_lang->comments             = "Comment";
$owl_lang->post_comment         = "Post Comment";
$owl_lang->addingfile 		= "添加一个文件到 ";
$owl_lang->addingfolder 	= "添加一个文件夹到 ";
$owl_lang->attach_file		= "添加附件";
$owl_lang->change		= "修改";
$owl_lang->create		= "创建";
$owl_lang->comments_added       = "注释添加于: ";
$owl_lang->description 		= "简介";
$owl_lang->email_body		= "内容";
$owl_lang->email_cc          	= "CC";
$owl_lang->email_reply_to	= "Reply To";
$owl_lang->email_subject	= "标题";
$owl_lang->email_to		= "寄给";
$owl_lang->emailing		= "邮寄中";
$owl_lang->disp_mp3		= "MP3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Song:<BR>Album:<BR>Bitrate&nbsp;-&nbsp;Samplerate:<BR>Duration:<BR>Genre:<BR>Comments:";
$owl_lang->keywords 		= "关键字";
$owl_lang->modify_url		= "URL";
$owl_lang->modifying		= "修改中 ";
$owl_lang->name               	= "名字";                                                                                                                                                   
$owl_lang->notify_link          = "Owl External Link";
$owl_lang->note_content		= "注释内容";
$owl_lang->ownergroup         	= "所属组";
$owl_lang->ownership		= "所属人";
$owl_lang->permissions 		= "权限";                                                                                                                        
$owl_lang->prop_permissions     = "Propagate Permissions to subfolders?";
$owl_lang->prop_perms_files     = "Permissions to propagate to files:";
$owl_lang->policy 		= "Policy";
$owl_lang->pick_select          = "&#8212; Select an Owl User &#8212;";
$owl_lang->sendfile 		= "发送文件";
$owl_lang->sendthisfile 	= "发送这个文件";
$owl_lang->sendthisurl       	= "发送这个 URL";
$owl_lang->updating		= "更新";
$owl_lang->verdescription 	= "简介<br></br>个修改";
$owl_lang->vermajor          	= "主版本";
$owl_lang->verminor          	= "小版本";
$owl_lang->vertype           	= "Revision type";  

//********************************************************
// modify.php  END
//********************************************************


//********************************************************
// register.php  BEGIN
//********************************************************
                                                                                                       
$owl_lang->email             	= "Email 地址";
$owl_lang->full_name         	= "全名";
$owl_lang->register          	= "用户注册";
$owl_lang->self_failed   	= "失败";
$owl_lang->self_passwd   	= "密码发送到:";
$owl_lang->self_reg_bod  	= "你的密码:";
$owl_lang->self_reg_rset 	= "你的账号密码更新为:";
$owl_lang->self_reg_subj	= "你的账号";
$owl_lang->send_pass           	= "发送密码";
$owl_lang->submit            	= "注册";
$owl_lang->thank_you_1          = "谢谢!";
$owl_lang->thank_you_2          = "一个邮件即将发送到您的Email地址 <BR> 包含密码 <BR><b>用户:</b>";

//********************************************************
// register.php  END
//********************************************************


//********************************************************
// move.php  BEGIN
//********************************************************

$owl_lang->cancel_button     = "取消";
$owl_lang->moving            = "转移";
$owl_lang->moving_file          = "Moving file";
$owl_lang->moving_folder        = "Moving Folder";
$owl_lang->copy_file            = "Copying file";
$owl_lang->copy_folder          = "Copying Folder";
$owl_lang->select            = "请选择新文件夹:";

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

$owl_lang->confpassword	= "再次验证";
$owl_lang->comment_notif= "提示警告";
$owl_lang->email_tool   = "E-Mail Tool";
$owl_lang->last_modified= "Last Modified";
$owl_lang->group	= "属于组";
$owl_lang->groupmember	= "组成员";
$owl_lang->newpassword  = "新密码";
$owl_lang->newsadmin    = "公告管理";
$owl_lang->not_member   = "你不属于任何组";
$owl_lang->notification = "接收警告";
$owl_lang->oldpassword  = "原密码";
$owl_lang->preference  	= "个性";
$owl_lang->saved	= "已经保存";
$owl_lang->status_no    = "是";
$owl_lang->status_yes   = "否";
$owl_lang->userlang     = "语言";

//********************************************************
// prefs.php  END
//********************************************************


//********************************************************
// search.php  BEGIN
//********************************************************

$owl_lang->elapsed_time         = "elapsed time";
$owl_lang->search             	= "查找";
$owl_lang->search_any_word      = "Any Words";
$owl_lang->search_all_word      = "All Words";
$owl_lang->search_entire_phrase = "Entire Phrase";
$owl_lang->search_match         = "Match:";
$owl_lang->search_currentfolder = "Search Current Folder";
$owl_lang->search_for_folders   = "Searching For Folders";
$owl_lang->search_for_files     = "Searching For Files";
$owl_lang->search_score         = "Scoring Files";
$owl_lang->search_results_for 	= "查找内容";
$owl_lang->search_winthindocs   = "Search Within (text, pdf and MS-WORD) Documents";
$owl_lang->related_query_empty  = "No metadata associated with document to perform 'Search Related'";
$owl_lang->query_empty    	= "查找内容是空的";

//********************************************************
// search.php  END
//********************************************************


//********************************************************
// view.php  BEGIN
//********************************************************

$owl_lang->viewing	= "Viewing ";

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
$owl_lang->add				= "添加";
$owl_lang->anonymous_account		= "匿名许可帐户:";                                                                                                                      
$owl_lang->buttonstyle                  = "Button Style";
$owl_lang->deletegroup			= "删除组";
$owl_lang->deleteuser			= "删除用户";
$owl_lang->disableuser			= "关闭用户";                                                                                                                              
$owl_lang->disable_recs_per_page        = "Enabling Restricted View Will DISABLE Records Per Page!";
$owl_lang->file_admin_group		= "文件/浏览 管理组:";
$owl_lang->flushed           		= "进程表刷新了, 用户现在可以再次登录了.<BR>";
$owl_lang->groups			= "组";
$owl_lang->hide_bulk_buttons		= "隐藏批处理按钮:";
// Edit HTML Properties Messages BEGIN
$owl_lang->ht_tbl_border_sz 		= "表格线宽度:";
$owl_lang->ht_tbl_hd_bg			= "头背景:";
$owl_lang->ht_tbl_cell_bg_cl 		= "表格背景色:";
$owl_lang->ht_tbl_cell_bg_al 		= "表格交替背景色:";
$owl_lang->ht_expand_width		= "扩展显示宽度:";
$owl_lang->ht_collapse_width 		= "缩小显示宽度:";
$owl_lang->ht_bd_bg_image		= "窗体背景图片位置:";
$owl_lang->ht_bd_txt_cl 		= "窗体字颜色:";
$owl_lang->ht_bd_lnk_cl			= "窗体连接色:";
$owl_lang->ht_bd_vlnk_cl 		= "窗体已察看连接色:";
// Edit Prefs Properties Messages END
$owl_lang->home_dir                     = "User's Home Directory";
$owl_lang->initial_dir                  = "User's Initial Directory";
$owl_lang->maxsessions			= "最大进程数量";
$owl_lang->noprefaccess			= "关闭预设";
$owl_lang->owl_anon_full                = "Full Access";
$owl_lang->owl_anon_ro			= "设定匿名用户只能读取:";
$owl_lang->owl_anon_download            = "Download Only";
$owl_lang->anonymous_access             = "Set Anonymous Access";
$owl_lang->owl_dbdump_path   		= "数据库导出工具位置:";
$owl_lang->owl_def_file_group_owner	= "默认的文件组:";
$owl_lang->owl_def_file_meta		= "Default File Meta Data:";
$owl_lang->owl_def_file_owner		= "默认的用户:";
$owl_lang->owl_def_file_perm 		= "Default File Creation Policy:";
$owl_lang->owl_def_file_security	= "Default File Security:";
$owl_lang->owl_def_file_title		= "Default File Title (None for Filename):";
$owl_lang->owl_def_fold_group_owner	= "Default Folder Group Owner:";
$owl_lang->owl_def_fold_owner		= "Default Folder Owner:";
$owl_lang->owl_def_fold_sec		= "Default Folder Security:";
$owl_lang->owl_def_folder_perm 		= "Default Folder Creation Policy:";
$owl_lang->owl_default_tmpdir		= "Temp file Directory Location: ";
$owl_lang->owl_email_from		= "Email From Address:";
$owl_lang->owl_email_fromname		= "Email From Name:";
$owl_lang->owl_email_replyto		= "Email Reply To Address:";
$owl_lang->owl_email_server		= "Email Delivery Server Address:";
$owl_lang->owl_email_smtp               = "Use SMTP Mailing Method";
$owl_lang->owl_email_smtp_auth          = "Use SMTP Auth";
$owl_lang->owl_email_smtp_auth_login    = "SMTP Auth Login:";
$owl_lang->owl_email_smtp_auth_passwd   = "SMTP Auth Password";
$owl_lang->owl_email_subject_pref	= "Email Subject Prefix:";
$owl_lang->owl_fogotpass		= "显示忘记密码连接:";
$owl_lang->owl_group_user		= "属于这个组中的成员";
$owl_lang->owl_gzip_path     		= "gzip 位置:";
$owl_lang->owl_hidebackup		= "隐含备份路径:";
$owl_lang->owl_log_file			= "日志文件启动:";
$owl_lang->owl_log_login_act		= "记录 登录/注销 动作:";
$owl_lang->owl_log_rec_page		= "Log Viewer Records Per Page:";
$owl_lang->owl_logging			= "Enable Logging:";
$owl_lang->owl_logo			= "Login Page logo ([Language]/graphics):";
$owl_lang->owl_lookAtHD			= "Disable Look at hd:";
$owl_lang->owl_lookAtHDDel		= "Remove Deleted Files From DB:";
$owl_lang->hide_folder_doc_count        = "Hide Folder File Type Count";                                                                                                                        
$owl_lang->hide_folder_size             = "Hide Folder Content Size";
$owl_lang->old_action_icons             = "Use pre Owl 0.80 Action Icons";
$owl_lang->search_result_folders        = "Include Folders in Search Results";
$owl_lang->restore_file_prefix          = "String Prefixed to Restored Files";
$owl_lang->owl_max_filesize		= "Maximum Upload File Size:";
$owl_lang->owl_owl_expand		= "Default Browser View (Expand):";
$owl_lang->owl_owl_timeout		= "Session Timeout in Seconds:";
$owl_lang->virus_path                   = "Virus Checking Software Path<br />Example: '/usr/bin/clamscan --quiet' <br />&#8211; Blank for Disabled:";
$owl_lang->owl_pdftotext_path           = "Maintain Search Index for <BR>PDF and text Files <BR>&#8211; Blank for Disabled:";
$owl_lang->owl_wordtotext_path          = "MS-WORD Files <BR>&#8211; Blank for Disabled:";
$owl_lang->owl_pod2html_path            = "Perl 5.8.0 or Greater required<BR>Path to pod2html:";
$owl_lang->owl_restrict_view		= "打开限定的显示:";
$owl_lang->owl_self_reg			= "Enable Self Register:";
$owl_lang->owl_self_reg_hd		= "SELF REGISTERED USER DEFAULTS";
$owl_lang->owl_tar_path     		= "tar 位置:";
$owl_lang->owl_title_custom             = "CUSTOMIZE BROWSER COLUMNS";
$owl_lang->owl_title_custom_search      = "CUSTOMIZE SEARCH RESULTS";
$owl_lang->owl_title_browser		= "OWL BROWSER FEATURES";
$owl_lang->owl_title_defaults   	= "默认";
$owl_lang->owl_title_email		= "EMAIL SETTINGS";
$owl_lang->owl_title_HD			= "LOOK AT HD FOR NEW FILES SETTINGS";
$owl_lang->owl_title_logging  		= "LOGGING SETTINGS";
$owl_lang->owl_title_other		= "其他设置";
$owl_lang->owl_title_tools   		= "DB BACKUP/GZIP TOOLS";
$owl_lang->owl_unzip_path     		= "unzip 位置:";
$owl_lang->owl_version_control		= "Enable Version Control Feature:";
$owl_lang->quota			= "配额 0=无限制";
$owl_lang->reallydeluser                = "This user is owner of %numfiles% File(s) and %numfolders% Folder(s). These File(s) and Folder(s) will be orphaned. Is it Still Ok to Delete?";
$owl_lang->recs_per_page                = "Display Records Per Page (0 = Disabled):";
$owl_lang->remember_me_title            = "PERSISTENT LOGIN SETTINGS";
$owl_lang->remember_me                  = "Show the Remember Me link";
$owl_lang->remember_timeout             = "Cookie timeout in Days";
$owl_lang->remember_me_checkbox         = "Remember me";
$owl_lang->recycle_title		= "TRASH COLLECTION SETTINGS";
$owl_lang->recycle_enabled		= "Enable Trash Collection:";
$owl_lang->recycle_location		= "Trash Can Location:";
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
$owl_lang->use_popup			= "使用跳出窗口显示公告:";
$owl_lang->users           		= "用户";
$owl_lang->header_user_admin            = "User Administration";
$owl_lang->header_group_admin           = "Group Administration";
$owl_lang->header_sitefeatures_settings           = "Site Features and Settings";

//********************************************************
// admin/index.php  END
//********************************************************


//********************************************************
// admin/log.php  BEGIN
//********************************************************

$owl_lang->owl_log_viewer    	= "日志察看";
$owl_lang->owl_log_hd_action 	= "操作";
$owl_lang->owl_log_hd_file   	= "文件";
$owl_lang->owl_log_hd_fld_path	= "文件夹位置";
$owl_lang->owl_log_hd_user   	= "用户";
$owl_lang->owl_log_hd_dt_tm  	= "日期 时间";
$owl_lang->owl_log_hd_ip     	= "IP 地址";
$owl_lang->owl_log_hd_agent  	= "引擎";
$owl_lang->owl_log_hd_dtls   	= "详情";
$owl_lang->owl_log_no_rec    	= " 没有记录 ";
$owl_lang->owl_log_hide		= "隐含: ";
$owl_lang->owl_log_filter    	= "过滤";

//********************************************************
// admin/log.php  END
//********************************************************


//********************************************************
// admin/recycle.php  BEGIN
//********************************************************

$owl_lang->empty_trash          = "空垃圾桶";
$owl_lang->really_empty_trash   = "确定要清空垃圾桶吗?";
$owl_lang->recycle_bin_admin    = "垃圾桶管理";

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
$owl_lang->notif_subject_new 		= "新文件";
$owl_lang->notif_subject_upd 		= "一个文件更新了";
$owl_lang->notif_subject_monitor	= "An OWL Intranet File or Folder your are MONITORING was updated";
$owl_lang->notif_subject_comment	= "An OWL Intranet File -- Comment Added";
$owl_lang->notif_comment_1		= "commented on";
$owl_lang->notif_comment_2		= "Comment:";
$owl_lang->notif_msg         		= "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet<BR><BR>Find the new/updated file attached to this Email<BR><BR>";
$owl_lang->notif_msg_link               = "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet<BR><BR>Find a link to a new/updated file in this E-Mail<BR><BR>";
$owl_lang->notif_msg_alt_link           = "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet\n\nFind a link to a new/updated file in this E-Mail\n\n";
$owl_lang->notif_msg_alt         	= "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet\n\nFind the new/updated file attached to this Email\n\n";
$owl_lang->notif_salutation		= "亲爱的";
$owl_lang->notif_user                   = "Created/Update by:";
$owl_lang->owl_path			= "文件目录: ";
$owl_lang->sessinuse			= "这个进程已经被另一台计算机占用,访问被禁止<BR>";
$owl_lang->invalidsess			= "无效的进程标示,请从主页登录<BR>";
$owl_lang->sesstimeout			= "你的进程超时,请重新登录<BR>";
$owl_lang->everyoneread			= "所有人都可以读取/下载";
$owl_lang->everyonewrite		= "所有人都可以读取/下载/修改";
$owl_lang->everyonewrite_nod		= "所有人都可以读取/下载/修改, 但不能删除";
$owl_lang->groupread			= "您的组可以读取/下载";
$owl_lang->groupwrite			= "您的组可以读取/下载/修改";
$owl_lang->groupwrite_nod		= "您的组可以读取/下载/修改, 但不能删除";
$owl_lang->onlyyou			= "只有您可以读取/下载/修改";                                                                                
$owl_lang->donothing                    = "Do nothing &#8211; Leave file permissions alone";
$owl_lang->groupwrite_worldread 	= "您的组可以读取/下载/修改 & 其他人都只能读取";
$owl_lang->groupwrite_worldread_nod 	= "您的组可以读取/下载/修改 (但不能删除) & 其他人都只能读取";
$owl_lang->ggroupwrite_worldread 	= "您的组可以上传文件和删除这个文件夹 & 其他人都只能读取";
$owl_lang->ggroupwrite_worldread_nod 	= "您的组可以上传文件到这个文件夹 & 其他人都只能读取, 但不能删除";
$owl_lang->everyoneread_ad		= "所有人都可以读取/下载";
$owl_lang->everyonewrite_ad		= "所有人都可以读取/下载/修改";
$owl_lang->everyonewrite_ad_nod		= "所有人都可以读取/下载/修改, 但不能删除";
$owl_lang->groupread_ad			= "指定的组可以读取/下载";
$owl_lang->groupwrite_ad		= "指定的组可以读取/下载/修改";
$owl_lang->groupwrite_ad_nod		= "指定的组可以读取/下载/修改, 但不能删除";
$owl_lang->onlyyou_ad			= "只有您可以读取/下载/修改";
$owl_lang->groupwrite_worldread_ad 	= "指定的组可以读取/下载/修改 & 其他人都只能读取";
$owl_lang->groupwrite_worldread_ad_nod 	= "指定的组可以读取/下载/修改 (但不能删除) & 其他人都只能读取";
$owl_lang->ggroupwrite_worldread_ad 	= "指定的组可以上传文件和删除这个文件夹 & 其他人都只能读取";
$owl_lang->ggroupwrite_worldread_ad_nod	= "指定的组可以上传文件到这个文件夹 & 其他人都只能读取, 但不能删除";
$owl_lang->geveryoneread		= "所有人都可以读取这个文件夹";
$owl_lang->geveryonewrite		= "所有人都可以上传文件和删除这个文件夹";
$owl_lang->geveryonewrite_nod		= "所有人都可以上传文件到这个文件夹";
$owl_lang->ggroupread			= "您的组可以读取这个文件夹";
$owl_lang->ggroupwrite			= "您的组可以上传文件和删除这个文件夹";
$owl_lang->ggroupwrite_nod		= "您的组可以上传文件到这个文件夹";
$owl_lang->gonlyyou			= "只有您可以上传文件和删除这个文件夹";
$owl_lang->geveryoneread_ad		= "所有人都可以读取这个文件夹";
$owl_lang->geveryonewrite_ad		= "所有人都可以上传文件和删除这个文件夹";
$owl_lang->geveryonewrite_ad_nod	= "所有人都可以上传文件到这个文件夹";
$owl_lang->ggroupread_ad		= "指定的组可以读取这个文件夹";
$owl_lang->ggroupwrite_ad    		= "指定的组可以上传文件和删除这个文件夹";
$owl_lang->ggroupwrite_ad_nod		= "指定的组可以上传文件到这个文件夹";
$owl_lang->gonlyyou_ad			= "只有您可以上传文件和删除这个文件夹";
$owl_lang->orphaned                     = "&#8211; NO Owner  &#8211;";
$owl_lang->virus_infected               = "VIRUS INFECTED FILE";
$owl_lang->virus_return_val             = "Virus Program Return value:";

//********************************************************
// lib/owl.lib.php  END
//********************************************************


//********************************************************
// HREF TITLE messages  BEGIN
//********************************************************

$owl_lang->title_browse_folder          = "打开这个文件夹";
$owl_lang->title_browse_site            = "打开这个 URL";
$owl_lang->title_download_view          = "下载 / 阅读 这个文件";
$owl_lang->title_edit_prefs             = "阅读 / 编辑 用户属性";
$owl_lang->title_return_folder          = "返回到";
$owl_lang->title_sort                   = "以此排序";
$owl_lang->title_view_new               = "看在我最后退出后所有新文件的列表";
$owl_lang->title_view_updated           = "看在我最后退出后所有更新过的文件的列表";
$owl_lang->title_view_my                = "看我文件的列表";

//********************************************************
// HREF TITLE messages  END
//********************************************************


//********************************************************
// admin/news.php and newsread.php BEGIN
//********************************************************

$owl_lang->news_title                   = "公告板";
$owl_lang->news_hd                      = "公告";
$owl_lang->news_hd_created              = "创建于";
$owl_lang->news_hd_expires              = "取消在";
$owl_lang->news_hd_audience             = "读者目标";
$owl_lang->news_heading                 = "公告标题";
$owl_lang->news_content                 = "内容";
$owl_lang->news_posted_date             = "公告发表了:";
$owl_lang->news_read                    = "阅读";

//********************************************************
// admin/news.php and newsread.php  END
//********************************************************


//********************************************************
// DEBUG MESSAGES BEGIN
//********************************************************

$owl_lang->debug_tmp_not_exists         = "DEBUG: The 临时目录: $default->owl_tmpdir 不存在.";
$owl_lang->debug_tmp_not_writeable      = "DEBUG: OWL 临时目录: $default->owl_tmpdir 不可写.";
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

$owl_lang->owl_stats_viewer     = "状态察看";
$owl_lang->stats_files          = "每个用户的文件数量";
$owl_lang->stats_folders        = "每个用户的文件夹数量";
$owl_lang->stats_top            = "最高的20次下载";
$owl_lang->stats_users          = "USER Signon (Login / Failure / Logout)";
$owl_lang->stats_users_loggedin = "Currently Logged In";
$owl_lang->stats_information    = "Owl 日志和文件日志需要激活这个状态察看才能显示出来";

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
