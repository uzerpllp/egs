<?php

/*

  File: Bulgarian/language.inc
  Author: Alexander (alexo95401)
  Date: 2003/04/23

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
$owl_lang->err_adding_comments		= "Вие нямате разрешение за прибавяне на мнения за този файл";
$owl_lang->err_comment_empty            = "Comment cannot be empty";
$owl_lang->err_backup_file   		= "Error backing up existing file";
$owl_lang->err_bad_url                  = "Please enter a valid URL";
$owl_lang->err_backup_folder_create 	= "Грешка при създаването на папката за резервни копия";
$owl_lang->err_bad_version_1 		= "Owl Intranet Изисква като минимум PHP версия :";
$owl_lang->err_bad_version_2 		= "Вашата версия е";
$owl_lang->err_bad_version_3 		= "Инсталирайте по-нова версия на PHP и опитайте отново";
$owl_lang->err_email         		= "Съобщението не може да бъде изпратено";
$owl_lang->err_email_required		= "Email полето е задължително";
$owl_lang->err_fexist1			= "<b>Файла съществува:</b>";
$owl_lang->err_fexist2 			= "Вече има файл с името <i>";
$owl_lang->err_fexist3 			= "</i> в тази папка.";
$owl_lang->err_file_exists		= "Файла, който се опитвате да запишете съществува";
$owl_lang->err_fileexists    		= "Преместването отменено<BR>Съществува файл със същото име";
$owl_lang->err_file_lock     		= "Не можете да отключите този файл, той е собственост на";
$owl_lang->err_update_file_lock         = "You cannot update this file, it is currently held by";
$owl_lang->err_filemove_exist           = "The filename you are trying to rename this file to already exists";
$owl_lang->err_file_not_exist		= "Файла не съществува в системата";
$owl_lang->err_file_too_big		= "php.ini upload_max_filesize е надвишено и/или<BR>Е надхвърлена максималната допустима стойност";
$owl_lang->err_file_update		= "Обновяване на файл изисква същото име, Моля опитайте отново използвайки същото име";
$owl_lang->err_folder_create 		= "Грешка при създаването на папката";
$owl_lang->err_folder_exist		= "Такава папка вече съществува";
$owl_lang->err_folderexists  		= "Преименуването отменено<BR>Съществува папка с това име.";
$owl_lang->err_general 			= "ГРЕШКА !";
$owl_lang->err_group_delete		= "Не можете да изтриете група в която има членове";
$owl_lang->err_group_exists		= "Вече съществува група с това име.";
$owl_lang->err_gzip_not_found  		= "gzip не бе открит във ";
$owl_lang->err_login			= "Моля 'Влезте',за да извършите това действие";
$owl_lang->err_movecancel    		= "Преместването беше променено<BR>";
$owl_lang->err_nameempty    		= "Името на папката не може да бъде празно";
$owl_lang->err_news_required		= "Грешка: Заглавие и съдържание на новината са задължителни!";
$owl_lang->err_no_access 		= "Нямате права върху избраните файлове";
$owl_lang->err_no_access_info           = "Possible causes: <br></br>1) You did not click any checkbox in front of a File or Folder<br></br>2) Bulk Delete, Bulk Email, Bulk Checkout do not apply to Folders<br></br>3) You do not have access to any of the files or folders you have selected.";
$owl_lang->err_noemail			= "Нямате права за изпращане на този файл";
$owl_lang->err_nofileaccess		= "Нямате права до този файл";
$owl_lang->err_nofiledelete		= "Нямате права за изтриване на този файл";
$owl_lang->err_nofilemod		= "Нямате права за промяна на този файл";
$owl_lang->err_nofolderaccess		= "Нямате достъп до тази папка";
$owl_lang->err_nofolderdelete		= "Нямате права да изтриете тази папка";
$owl_lang->err_nofoldermod		= "Нямате права за промяна на тази папка";
$owl_lang->err_nosubfolder		= "Тук нямате права за създаване на подпапки";
$owl_lang->err_note_title               = "Заглавието е задължително поле";
$owl_lang->err_note_title_exists        = "Бележка с това име съществува";
$owl_lang->err_noupload			= "Нямате права за записване на папката";
$owl_lang->err_pass_missmatch		= "Новата парола и нейното потвърждение не съвпадат ";
$owl_lang->err_pass_wrong    		= "Старата парола е грешна";
$owl_lang->err_pod2html_not_found	= "ERROR: The pod2html tool was not found:";
$owl_lang->err_quota			= "Нямате достатъчно лимит за да запишете този файл: ";
$owl_lang->err_quota_needed		= " необходимо ";
$owl_lang->err_quota_avail		= " свободно.";
$owl_lang->err_quota_exceed  		= "Превишили сте вашия лимит";
$owl_lang->err_req			= "Грешка: Всички полета са задължителни";
$owl_lang->err_root_delete              = "The Root Folder cannot be deleted";
$owl_lang->err_sess_notvalid 		= "Невалидна сесия";
$owl_lang->err_sess_write		= "Грешка при записване на session information в базата данни";
$owl_lang->err_specialfoldername 	= "'backup' името е резервирано от системата, Моля изберете друго име";
$owl_lang->err_tar_not_found  		= "tar не е открит в ";
$owl_lang->err_trash_can_empty 		= "Кошчето е празно";
$owl_lang->err_unauth_area   		= "Нямате право на достъп до тази област";
$owl_lang->err_unauthorized  		= "Нямате достъп";
$owl_lang->err_upload 			= "Грешка при Upload-a";
$owl_lang->err_user_exists		= "Потребител с това име съществува";
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
$owl_lang->alt_add_comments     = "Прибави коментар към този файл";
$owl_lang->alt_btn_add_file     = "Upload на нов файл";
$owl_lang->alt_btn_add_folder	= "Създай нова директория";
$owl_lang->alt_add_group	= "Създай тази група";
$owl_lang->alt_add_news		= "Прибави новина";
$owl_lang->alt_btn_add_note     = "Прибави нова бележка";
$owl_lang->alt_add_user		= "Създай потребител";
$owl_lang->alt_btn_add_url      = "Create a New Web link";
$owl_lang->alt_cancel		= "Отмени действието";
$owl_lang->alt_cancel_move	= "Отмени преместването";
$owl_lang->alt_change		= "Обнови записа";
$owl_lang->alt_btn_clickhere	= "Кликнете тук";
$owl_lang->alt_btn_collapse_view= "Превключете на опростен изглед";
$owl_lang->alt_comments 	= "Има нови мнения за файла";
$owl_lang->alt_del_comments     = "Изтрий това мнение";
$owl_lang->alt_del_file      	= "Изтрий файла (Д/Н)";
$owl_lang->alt_del_folder    	= "Изтрий папката(Д/Н)";
$owl_lang->alt_del_group	= "Изтрий тази група";
$owl_lang->alt_del_news		= "Изтрий тази новина";
$owl_lang->alt_del_selected	= "Изтрий всички избрани файлове";
$owl_lang->alt_del_all          = "Empty Trash";
$owl_lang->alt_rest_selected    = "Restore all Selected Files";
$owl_lang->alt_del_this_folder	= "Изтрий папката &#8211; ";
$owl_lang->alt_del_user		= "Потребител изтриване";
$owl_lang->alt_edit_group       = "Редактирай групата";
$owl_lang->alt_edit_news	= "Редактирай Новината";
$owl_lang->alt_edit_user        = "Редактирай избрания потребител";
$owl_lang->alt_email		= "Прати по Email";
$owl_lang->alt_email_selected	= "Изпрати всички избрани файлове по Email";
$owl_lang->alt_btn_expand_view  = "Превключи на разширен изглед";
$owl_lang->alt_admin_flush      = "Изчисти остарели/невалидни сесии ";
$owl_lang->alt_get_file      	= "Файл Download";
$owl_lang->alt_get_folder       = "Download Folder Content";
$owl_lang->alt_have_news	= "Имате новина(и)";
$owl_lang->alt_have_no_news	= "Няма нова(и) новина(и)";
$owl_lang->alt_home_folder      = "Back to Intial Dir ";
$owl_lang->alt_set_initial_dir  = "Set Current Dir as Initial";                                                                                                
$owl_lang->alt_site_map         = "Site Map";
$owl_lang->alt_lock_file        = "Заключи файла";
$owl_lang->alt_log_clear        = "Изтриване на всички записи(Д/Н)";
$owl_lang->alt_log_file         = "Данни за файла";
$owl_lang->alt_log_next		= "Покажи следващия запис";
$owl_lang->alt_log_prev		= "Покажи следващия запис";
$owl_lang->alt_log_top		= "Отиди на първия запис";
$owl_lang->alt_btn_login 	= "Влезте в Елиа Intranet";
$owl_lang->alt_btn_logout	= "Изход от Intranet";
$owl_lang->alt_btn_help         = "Owl Online Help";
$owl_lang->alt_mod_file      	= "Редактирай свойствата на файла"; 
$owl_lang->alt_mod_folder    	= "Редактирай свойствата на папката";
$owl_lang->alt_move_file     	= "Премести файла";
$owl_lang->alt_copy_file        = "Copy File";
$owl_lang->alt_link_file        = "Link This File to Another Directory";
$owl_lang->alt_move_folder   	= "Премести папката";
$owl_lang->alt_copy_folder      = "Copy Folder";
$owl_lang->alt_move_selected	= "Премести всички избрани файлове";
$owl_lang->alt_admin_groups	= "Създай нова група";
$owl_lang->alt_news_close	= "Затвори прозореца с новините";
$owl_lang->alt_news_next	= "Покажи следващата новина";
$owl_lang->alt_news_prev	= "Покажи предишната новина ";
$owl_lang->alt_news_print	= "Принтирай  новината";
$owl_lang->alt_admin_users	= "Създай нов потребител";
$owl_lang->alt_monitor		= "Следи този файл";
$owl_lang->alt_monitored	= "Спри следенето на този файл";
$owl_lang->alt_btn_admin 	= "Интранет Administration";
$owl_lang->alt_play_file 	= "Стартирай Мedia файла";
$owl_lang->alt_recycle		= "Кошчето е празно";
$owl_lang->alt_recycle_disable	= "Кошчето е забранено";
$owl_lang->alt_recycle_not_found= "Кошчето не бе открито";
$owl_lang->alt_refresh_filter	= "Стартирай филтриране на резултатите";
$owl_lang->alt_register		= "Изпратете вашите данни за регистрация";
$owl_lang->alt_btn_browse	= "Обратно към браузера";
$owl_lang->alt_search		= "Стартирай Търсенето";
$owl_lang->alt_send_email	= "Изпрати e-mail";
$owl_lang->alt_sendfile		= "Изпрати файла";
$owl_lang->alt_toggle_check_box	= "Избери всички";
$owl_lang->alt_unlock_file      = "Отключи файла";
$owl_lang->alt_upd_file      	= "Обнови файла";
$owl_lang->alt_view_comments    = "Виж/Прибави коментар";
$owl_lang->alt_view_file     	= "Виж файла";
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

$owl_lang->log_del_det		= "Цялото съдържание беше изтрито";
$owl_lang->log_detail		= "Няма повече подробности";
$owl_lang->log_file_to		= "До: ";
$owl_lang->log_filter_all	= "Всички записи";
$owl_lang->log_login_det        = "Потребител: ";
$log_file_actions[1]            = "Вход";
$log_file_actions[2]            = "Неусп.Вх.";
$log_file_actions[3]            = "Изход";
$log_file_actions[4]            = "изтриване на файл";
$log_file_actions[5]            = "FILE UPLOAD";
$log_file_actions[6]            = "обновяване";
$log_file_actions[7]            = "DOWNLOAD на файл";
$log_file_actions[8]            = "Промяна файл";
$log_file_actions[9]            = "заключване на файл";
$log_file_actions[10]           = "отключване";
$log_file_actions[11]           = "изпращане на файл";
$log_file_actions[12]           = "местене на файл";
$log_file_actions[13]           = "нова папка";
$log_file_actions[14]           = "изтриване на папка";
$log_file_actions[15]           = "Папка променена";
$log_file_actions[16]           = "Папка преместена";
$log_file_actions[17]           = "Забравена парола";
$log_file_actions[18]           = "Рег.на.потр.";
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

$owl_lang->anonymous 		= "(Анонимен достъп)";
$owl_lang->repository_list      = "Repository:";
$owl_lang->engine 		= "Elia Intranet Engine";
$owl_lang->forgot_pass		= "Забравена парола?";
$owl_lang->like_register	= "Искате да се регистрирате?";
$owl_lang->login		= "Вход";
$owl_lang->loginfail		= "Вход неуспешен";
$owl_lang->logindisabled	= "Този потребител е забранен, свържете се с Администратора";
$owl_lang->password		= "Парола";
$owl_lang->successlogout 	= "Ви излязохте успешно";
$owl_lang->toomanysessions	= "Достигнат е максималния брой сесии за този потребител!";
$owl_lang->username		= "Потребител";
$owl_lang->version 		= "Версия";

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
$owl_lang->actions 			= "Действия";
$owl_lang->del_selected			= "Избор изтриване";
$owl_lang->del_all                      = "Empty Trash";
$owl_lang->rest_selected                = "Restore Selected";
$owl_lang->disk_quota			= "Дискова квота";
$owl_lang->email_selected		= "Email избран";
$owl_lang->file 			= "Файл";
$owl_lang->folder_policy                = "Current Folder Policy:";
$owl_lang->current_folder               = "Current Folder:";
$owl_lang->held                      	= "Собств."; 
$owl_lang->last_logged			= "Предишно влизане на: ";
$owl_lang->current_db                   = "Current Repository:";
$owl_lang->modified 			= "Променен";
$owl_lang->move_selected		= "Избор преместване";
$owl_lang->new_file			= "Нов!";
$owl_lang->no_description		= "Няма описание за този файл"; 
$owl_lang->page                         = "Page:";
$owl_lang->postedby 			= "Записан от";
$owl_lang->reallydelete			= "Желаете ли изтриване?";
$owl_lang->reallydelete_logs		= "Изтриване на LOG записите";
$owl_lang->reallydelete_selected	= "Желаете ли изтриване на всички избрани файлове";
$owl_lang->reallyrestore_selected       = "Really Restore all selected files";
$owl_lang->size 			= "Големина";
$owl_lang->score                        = "Score";
$owl_lang->title 			= "Заглавие";
$owl_lang->doc_number                   = "Doc #";
$owl_lang->tot_files			= "Всичко:";
$owl_lang->tot_my_checked_out           = "Checked Out:";
$owl_lang->tot_my_files			= "Мои:";
$owl_lang->tot_my_group                 = "Group:";
$owl_lang->tot_new_files		= "Нови:";
$owl_lang->tot_updated_files		= "Обновени:";
$owl_lang->tot_monitored                = "Monitored:";
$owl_lang->updated_file			= "Обновен!";
$owl_lang->user               		= "Потребител";
$owl_lang->ver                       	= "Верс."; 
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
$owl_lang->adding_comments      = "Прибавяне / Разглеждане на мнения: ";
$owl_lang->comments             = "Comment";
$owl_lang->post_comment         = "Post Comment";
$owl_lang->addingfile 		= "Прибавяне на файл към ";
$owl_lang->addingfolder 	= "Прибавяне на папка към ";
$owl_lang->attach_file		= "Прикачи файл";
$owl_lang->change		= "Промени";
$owl_lang->create		= "Създай";
$owl_lang->comments_added       = "Мнение прибавено от: ";
$owl_lang->description 		= "Описание";
$owl_lang->email_body		= "Съобщение";
$owl_lang->email_cc          	= "CC";
$owl_lang->email_reply_to	= "Отговор на";
$owl_lang->email_subject	= "Повод";
$owl_lang->email_to		= "Изпрати до";
$owl_lang->emailing		= "Emailing";
$owl_lang->disp_mp3		= "MP3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Песен:<BR>Албум:<BR>Bitrate&nbsp;-&nbsp;Samplerate:<BR>Времетраене:<BR>Тип:<BR>Коментари:";
$owl_lang->keywords 		= "Ключови думи";
$owl_lang->modify_url		= "URL";
$owl_lang->modifying		= "Редактиране ";
$owl_lang->name               	= "Име";                                                                                                                                                   
$owl_lang->notify_link          = "Owl External Link";
$owl_lang->note_content         = "Съдържание на ком.";
$owl_lang->ownergroup         	= "Собственик(Група)";
$owl_lang->ownership		= "Собственост";
$owl_lang->permissions 		= "Права";                                                                                                                        
$owl_lang->prop_permissions     = "Propagate Permissions to subfolders?";
$owl_lang->prop_perms_files     = "Permissions to propagate to files:";
$owl_lang->policy 		= "Политика";
$owl_lang->pick_select          = "&#8212; Select an Owl User &#8212;";
$owl_lang->sendfile 		= "Изпрати файл";
$owl_lang->sendthisfile 	= "Изпрати този файл";
$owl_lang->sendthisurl       	= "Изпрати URL";
$owl_lang->updating		= "Обновяване";
$owl_lang->verdescription 	= "Описание<br></br>на промените";
$owl_lang->vermajor          	= "Мащабни промени";
$owl_lang->verminor          	= "Малки промени";
$owl_lang->vertype           	= "Вид преработване";  

//********************************************************
// modify.php  END
//********************************************************


//********************************************************
// register.php  BEGIN
//********************************************************

$owl_lang->email             	= "Email адрес";
$owl_lang->full_name		= "Пълно име";
$owl_lang->register		= "Регистриране на потребител";
$owl_lang->self_failed		= "Неуспешен";
$owl_lang->self_passwd		= "Паролата е изпратена на:";
$owl_lang->self_reg_bod		= "Вашата парола е:";
$owl_lang->self_reg_rset	= "Вашата парола е сменена на:";
$owl_lang->self_reg_subj	= "Вашия Интранет потребител";
$owl_lang->send_pass		= "Изпрати парола";
$owl_lang->submit		= "Регистрация";
$owl_lang->thank_you_1		= "Благодарим ви!";
$owl_lang->thank_you_2		= "Ще получите e-mail <BR> с паролата за <BR><b>Потребителско име:</b>";

//********************************************************
// register.php  END
//********************************************************


//********************************************************
// move.php  BEGIN
//********************************************************

$owl_lang->cancel_button	= "Отмени";
$owl_lang->moving		= "Преместване";
$owl_lang->moving_file          = "Moving file";
$owl_lang->moving_folder        = "Moving Folder";
$owl_lang->copy_file            = "Copying file";
$owl_lang->copy_folder          = "Copying Folder";
$owl_lang->select		= "Моля, изберете нова папка:";

//********************************************************
// move.php  END
//********************************************************


//********************************************************
// log.php  BEGIN
//********************************************************

$owl_lang->viewlog	= "LOG файл за ";

//********************************************************
// log.php  END
//********************************************************


//********************************************************
// prefs.php  BEGIN
//********************************************************

$owl_lang->confpassword	= "Потвърдете новата парола";
$owl_lang->comment_notif= "Известяване за мнения";
$owl_lang->email_tool   = "E-Mail Tool";
$owl_lang->last_modified= "Last Modified";
$owl_lang->group	= "Главна група";
$owl_lang->groupmember	= "Членство в групи";
$owl_lang->newpassword	= "Нова парола";
$owl_lang->newsadmin	= "Администратор на новините";
$owl_lang->not_member	= "Вие не сте член в други групи";
$owl_lang->notification	= "Известяване за нови и/или обновени файлове";
$owl_lang->oldpassword	= "Стара парола";
$owl_lang->preference	= "Настройки";
$owl_lang->saved	= "Промените са запазени";
$owl_lang->status_no	= "Не";
$owl_lang->status_yes	= "Да";
$owl_lang->userlang	= "Език";

//********************************************************
// prefs.php  END
//********************************************************


//********************************************************
// search.php  BEGIN
//********************************************************

$owl_lang->elapsed_time         = "elapsed time";
$owl_lang->search             	= "Търсене";
$owl_lang->search_any_word      = "Any Words";
$owl_lang->search_all_word      = "All Words";
$owl_lang->search_entire_phrase = "Entire Phrase";
$owl_lang->search_match         = "Match:";
$owl_lang->search_currentfolder = "Search Current Folder";
$owl_lang->search_for_folders   = "Searching For Folders";
$owl_lang->search_for_files     = "Searching For Files";
$owl_lang->search_score         = "Scoring Files";
$owl_lang->search_results_for	= "Резултати от търсенето за";
$owl_lang->search_winthindocs	= "Search Within (text, pdf and MS-WORD) Documents";
$owl_lang->related_query_empty  = "No metadata associated with document to perform 'Search Related'";
$owl_lang->query_empty       	= "Празно поле за търсене";

//********************************************************
// search.php  END
//********************************************************


//********************************************************
// view.php  BEGIN
//********************************************************

$owl_lang->viewing	= "Преглед ";

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
$owl_lang->add				= "Прибави";
$owl_lang->anonymous_account		= "Потребител за анонимен достъп:";
$owl_lang->buttonstyle			= "Button Style";
$owl_lang->deletegroup			= "Изтрий групата";
$owl_lang->deleteuser			= "Изтрий потребителя";
$owl_lang->disableuser			= "Забрани потребителя";
$owl_lang->disable_recs_per_page        = "Enabling Restricted View Will DISABLE Records Per Page!";
$owl_lang->file_admin_group		= "Група за администриране на файловете:";
$owl_lang->flushed           		= "Таблицата със сесиите е изпразнена, потребителя трябва да влезе отново.<BR>";
$owl_lang->groups			= "Групи";
$owl_lang->hide_bulk_buttons		= "Скрий bulk бутоните:";
// Edit HTML Properties Messages BEGIN
$owl_lang->ht_tbl_border_sz 		= "Големина за рамките на таблиците:";
$owl_lang->ht_tbl_hd_bg			= "Header фон:";
$owl_lang->ht_tbl_cell_bg_cl 		= "Фон на клетките в табл.:";
$owl_lang->ht_tbl_cell_bg_al 		= "Фон на клетките в табл.(алт.) :";
$owl_lang->ht_expand_width		= "Ширина на разширения изглед:";
$owl_lang->ht_collapse_width 		= "Ширина на опростения изглед:";
$owl_lang->ht_bd_bg_image		= "Път на изображението за фон:";
$owl_lang->ht_bd_txt_cl 		= "Цвят за текст:";
$owl_lang->ht_bd_lnk_cl			= "Цвят на връзките(links):";
$owl_lang->ht_bd_vlnk_cl 		= "Цвят на посетените връзки:";
// Edit Prefs Properties Messages END
$owl_lang->home_dir                     = "User's Home Directory";
$owl_lang->initial_dir                  = "User's Initial Directory";
$owl_lang->maxsessions			= "Максимален брой сесии ";
$owl_lang->noprefaccess			= "Забрани лични настройки";
$owl_lang->owl_anon_full                = "Full Access";
$owl_lang->owl_anon_ro                  = "Read Only";
$owl_lang->owl_anon_download            = "Download Only";
$owl_lang->anonymous_access             = "Set Anonymous Access";
$owl_lang->owl_dbdump_path   		= "DB Dump Tool Path:";
$owl_lang->owl_def_file_group_owner	= "Default File Group Owner:";
$owl_lang->owl_def_file_meta		= "Default File Meta Data:";
$owl_lang->owl_def_file_owner		= "Default File Owner:";
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
$owl_lang->owl_email_smtp		= "Use SMTP Mailing Method";
$owl_lang->owl_email_smtp_auth		= "Use SMTP Auth";
$owl_lang->owl_email_smtp_auth_login    = "SMTP Auth Login:";
$owl_lang->owl_email_smtp_auth_passwd	= "SMTP Auth Password";
$owl_lang->owl_email_subject_pref	= "Email Subject Prefix:";
$owl_lang->owl_fogotpass		= "Show forgot password link:";
$owl_lang->owl_group_user		= "Потребители в тази група";
$owl_lang->owl_gzip_path     		= "gzip Path:";
$owl_lang->owl_hidebackup		= "Hide the Backup Directory:";
$owl_lang->owl_log_file			= "Log File Activities:";
$owl_lang->owl_log_login_act		= "Log Login/Logout Activities:";
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
$owl_lang->owl_owl_timeout		= "Session Time-out in Seconds:";
$owl_lang->virus_path                   = "Virus Checking Software Path<br />Example: '/usr/bin/clamscan --quiet' <br />&#8211; Blank for Disabled:";
$owl_lang->owl_pdftotext_path           = "Maintain Search Index for <BR>PDF and text Files <BR>&#8211; Blank for Disabled:";
$owl_lang->owl_wordtotext_path          = "MS-WORD Files <BR>&#8211; Blank for Disabled:";
$owl_lang->owl_pod2html_path		= "Perl 5.8.0 or Greater required<BR>Path to pod2html:";
$owl_lang->owl_restrict_view		= "Enable Restricted View Feature:";
$owl_lang->owl_self_reg			= "Разреши регистрирането:";
$owl_lang->owl_self_reg_hd		= "SELF REGISTERED USER DEFAULTS";
$owl_lang->owl_tar_path     		= "tar Path:";
$owl_lang->owl_title_custom             = "CUSTOMIZE BROWSER COLUMNS";
$owl_lang->owl_title_custom_search      = "CUSTOMIZE SEARCH RESULTS";
$owl_lang->owl_title_browser		= "OWL BROWSER FEATURES";
$owl_lang->owl_title_defaults   	= "DEFAULTS";
$owl_lang->owl_title_email		= "EMAIL SETTINGS";
$owl_lang->owl_title_HD			= "LOOK AT HD FOR NEW FILES SETTINGS";
$owl_lang->owl_title_logging  		= "LOGGING SETTINGS";
$owl_lang->owl_title_other		= "OTHER SETTINGS";
$owl_lang->owl_title_tools   		= "DB BACKUP/GZIP TOOLS";
$owl_lang->owl_unzip_path     		= "unzip Path:";
$owl_lang->owl_version_control		= "Разреши версии:";
$owl_lang->quota			= "Квота 0=неограничена";
$owl_lang->reallydeluser                = "This user is owner of %numfiles% File(s) and %numfolders% Folder(s). These File(s) and Folder(s) will be orphaned. Is it Still Ok to Delete?";
$owl_lang->recs_per_page                = "Display Records Per Page (0 = Disabled):";
$owl_lang->remember_me_title            = "PERSISTENT LOGIN SETTINGS";
$owl_lang->remember_me                  = "Show the Remember Me link";
$owl_lang->remember_timeout             = "Cookie timeout in Days";
$owl_lang->remember_me_checkbox         = "Remember me";
$owl_lang->recycle_title		= "Настройки Кошче";
$owl_lang->recycle_enabled		= "Разреши кошчето:";
$owl_lang->recycle_location		= "Местонахождение на кошчето:";
$owl_lang->show_panel_title             = "Display Status Panel:";
$owl_lang->show_search_title            = "Display Search Bar:";
$owl_lang->show_pref_title              = "Display Pref/logout Bar:";
$owl_lang->show_bulk_title              = "Display Bulk Buttons:";
$owl_lang->show_action_title            = "Display action Buttons:";
$owl_lang->show_folder_title            = "Display Folder Tools:";
$owl_lang->show_panel                   = "Show";
$owl_lang->hide_panel                   = "Hide";
$owl_lang->status_bar_both              = "И двете";
$owl_lang->status_bar_bottom            = "Долу";
$owl_lang->status_bar_location          = "Покажи статус 'бара':";
$owl_lang->status_bar_top               = "Горе";
$owl_lang->status_bar_not               = "Do Not Display";
$owl_lang->use_popup			= "Използвай нов прозорец за показване на новините:";
$owl_lang->users           		= "Потребители";
$owl_lang->header_user_admin            = "User Administration";
$owl_lang->header_group_admin           = "Group Administration";
$owl_lang->header_sitefeatures_settings           = "Site Features and Settings";

//********************************************************
// admin/index.php  END
//********************************************************


//********************************************************
// admin/log.php  BEGIN
//********************************************************

$owl_lang->owl_log_viewer	= "Преглед на LOG-a";
$owl_lang->owl_log_hd_action	= "Действие";
$owl_lang->owl_log_hd_file	= "Файл";
$owl_lang->owl_log_hd_fld_path	= "Път";
$owl_lang->owl_log_hd_user	= "Потр.";
$owl_lang->owl_log_hd_dt_tm	= "Дата/Час";
$owl_lang->owl_log_hd_ip	= "IP / Адрес";
$owl_lang->owl_log_hd_agent	= "Agent";
$owl_lang->owl_log_hd_dtls	= "Details";
$owl_lang->owl_log_no_rec	= " Няма ЗАПИСИ ";
$owl_lang->owl_log_hide      	= "Скрий : ";
$owl_lang->owl_log_filter	= "Филтриране";

//********************************************************
// admin/log.php  END
//********************************************************


//********************************************************
// admin/recycle.php  BEGIN
//********************************************************

$owl_lang->empty_trash          = "Изпразни кошчето";
$owl_lang->really_empty_trash	= "Наистина ли желаете да изпразните кошчето?";
$owl_lang->recycle_bin_admin    = "Администриране на кошчето";

//********************************************************
// admin/recycle.php  END
//********************************************************


//********************************************************
// lib/owl.lib.php  BEGIN
//********************************************************

$owl_lang->file_size_byte		= "B";
$owl_lang->file_size_gigabyte		= "G";
$owl_lang->file_size_kilobyte		= "k";
$owl_lang->file_size_megabyte		= "M";
$owl_lang->notif_subject_new 		= "Има нов файл";
$owl_lang->notif_subject_upd 		= "Обновен файл в Елиа Интранет";
$owl_lang->notif_subject_monitor	= "Файл или папка която следите в Интранета е била обновена";
$owl_lang->notif_subject_comment	= "Intranet файл - Ново мнение";
$owl_lang->notif_comment_1		= "commented on";
$owl_lang->notif_comment_2		= "Мнение:";
$owl_lang->notif_msg         		= "Това е автоматизирано съобщение от Елиа Intranet<BR><BR>Вижте файла прикачен към този e-mail<BR><BR>";
$owl_lang->notif_msg_link               = "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet<BR><BR>Find a link to a new/updated file in this E-Mail<BR><BR>";
$owl_lang->notif_msg_alt_link           = "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet\n\nFind a link to a new/updated file in this E-Mail\n\n";
$owl_lang->notif_msg_alt         	= " Това е автоматизирано съобщение от Елиа Intranet<BR><BR>Вижте файла прикачен към този e-mail<BR><BR>";
$owl_lang->notif_salutation		= "Здравейте ";
$owl_lang->notif_user                   = "Created/Update by:";
$owl_lang->owl_path			= "Път на файла: ";
$owl_lang->sessinuse			= "Тази сесия се използва от друг компютър, достъп е отказан<BR>";
$owl_lang->invalidsess			= "Невалидна сесия, Моля влезте през заглавната страница<BR>";
$owl_lang->sesstimeout			= "Изтече времето на вашата сесия, моля влeзте отново<BR>";
$owl_lang->everyoneread			= "Всеки може да чете/download";
$owl_lang->everyonewrite		= "Всеки може да чете/променя/download";
$owl_lang->everyonewrite_nod		= "Всеки може да чете/променя/download, БЕЗ Изтриване";
$owl_lang->groupread			= "Вашата група може да чете/download";
$owl_lang->groupwrite			= "Вашата група може да чете/променя/download";
$owl_lang->groupwrite_nod		= "Вашата група може да чете/променя/download, БЕЗ Изтриване";
$owl_lang->onlyyou			= "Само Вие може да четете/променяте/download ";
$owl_lang->donothing                    = "Do nothing &#8211; Leave file permissions alone";
$owl_lang->groupwrite_worldread 	= "Само вашата група може да чете/променя/download, А всички останали само четене";
$owl_lang->groupwrite_worldread_nod 	= "Само вашата група може да чете/променя/download(без изтриване) ,А всички останали само четене ";
$owl_lang->ggroupwrite_worldread 	= "Само вашата група може да upload файлове и да изтрива тази папка, а останалите само да разглеждат";
$owl_lang->ggroupwrite_worldread_nod 	= "Само вашата група може да записва файлове а всички останали да виждат съдържанието(Без Изтриване)";
$owl_lang->everyoneread_ad		= "Всеки може да чете и download";
$owl_lang->everyonewrite_ad		= "Всеки може да чете/променя/download";
$owl_lang->everyonewrite_ad_nod		= "Всеки може да чете/променя/download, Без Изтриване";
$owl_lang->groupread_ad			= "Избраната група може да чете/download";
$owl_lang->groupwrite_ad		= "Избраната група може чете/променя/download";
$owl_lang->groupwrite_ad_nod		= "Избраната група може чете/променя/download, Без Изтриване ";
$owl_lang->onlyyou_ad			= "Само Вие можете да четете/променяте/Download";
$owl_lang->groupwrite_worldread_ad 	= "Избраната група може чете/променя/download a останалите само да разглеждат";
$owl_lang->groupwrite_worldread_ad_nod 	= "Избраната група може чете/променя/download(Без Изтриване) a останалите само да разглеждат";
$owl_lang->ggroupwrite_worldread_ad 	= "Избраната група може да записва файлове а всички останали да виждат съдържанието";
$owl_lang->ggroupwrite_worldread_ad_nod	= "Избраната група може да записва файлове а всички останали да виждат съдържанието(Без Изтриване)";
$owl_lang->geveryoneread		= "Всеки може да разглежда съдържанието на тази папка";
$owl_lang->geveryonewrite		= "Всеки може да записва файлове в тази папка и да я изтрива";
$owl_lang->geveryonewrite_nod		= "Всеки може да записва файлове в тази папка";
$owl_lang->ggroupread			= "Вашата група може да разглежда тази папка";
$owl_lang->ggroupwrite			= "Вашата група може да записва файлове в тази папка и да я изтривате";
$owl_lang->ggroupwrite_nod		= "Вашата група може да записва файлове в тази папка";
$owl_lang->gonlyyou			= "Само Вие можете да записвате във и да изтривате тази папка";
$owl_lang->geveryoneread_ad		= "Всеки може да разглежда съдържанието";
$owl_lang->geveryonewrite_ad		= "Всеки може да записва файлове в тази папка и да я изтрива";
$owl_lang->geveryonewrite_ad_nod	= "Всеки може да записва файлове в тази папка";
$owl_lang->ggroupread_ad		= "Избраната група може да вижда съдържанието";
$owl_lang->ggroupwrite_ad    		= "Избраната група може да записва файлове и да изтрие тази папка ";
$owl_lang->ggroupwrite_ad_nod		= "Избраната група може да записва файлове в тази папка";
$owl_lang->gonlyyou_ad			= "Само вие можете да записвате файлове и да изтриете тази папка";
$owl_lang->orphaned                     = "&#8211; NO Owner  &#8211;";
$owl_lang->virus_infected               = "VIRUS INFECTED FILE";
$owl_lang->virus_return_val             = "Virus Program Return value:";

//********************************************************
// lib/owl.lib.php  END
//********************************************************


//********************************************************
// HREF TITLE messages  BEGIN
//********************************************************

$owl_lang->title_browse_folder     	= "Разгледайте папката";
$owl_lang->title_browse_site     	= "Вижте URL";
$owl_lang->title_download_view     	= "Свалете / Вижте този файл";
$owl_lang->title_edit_prefs     	= "Вижте / Редактирайте личните настройки";
$owl_lang->title_return_folder     	= "Обратно към";
$owl_lang->title_sort     		= "Подредете по";
$owl_lang->title_view_new     		= "Вижте списъка с новите файлове от последното ви влизане";
$owl_lang->title_view_updated     	= "Вижте списъка с обновените файлове от последното ви влизане";
$owl_lang->title_view_my     		= "Вижте само вашите файлове";

//********************************************************
// HREF TITLE messages  END
//********************************************************


//********************************************************
// admin/news.php and newsread.php BEGIN
//********************************************************

$owl_lang->news_title			= "Администриране на новините";
$owl_lang->news_hd			= "Новини";
$owl_lang->news_hd_created		= "Създадена на";
$owl_lang->news_hd_expires		= "Изтича на";
$owl_lang->news_hd_audience		= "За следните читатели";
$owl_lang->news_heading			= "Заглавие на новините";
$owl_lang->news_content			= "Съдържание";
$owl_lang->news_posted_date		= "Публикувани новини:";
$owl_lang->news_read			= "Прочетени";

//********************************************************
// admin/news.php and newsread.php  END
//********************************************************


//********************************************************
// DEBUG MESSAGES BEGIN
//********************************************************

$owl_lang->debug_tmp_not_exists		= "DEBUG: The OWL temporary Directory: $default->owl_tmpdir does not exists.";
$owl_lang->debug_tmp_not_writeable	= "DEBUG: The OWL temporary Directory: $default->owl_tmpdir is not writeable by the Web Server.";
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

$owl_lang->owl_stats_viewer	= "Преглед на статистиките";
$owl_lang->stats_files		= "Брой файла за потребител";
$owl_lang->stats_folders	= "Брой папки за потребител";
$owl_lang->stats_top		= "Top 20 downloads";
$owl_lang->stats_users          = "USER Signon (Login / Failure / Logout)";
$owl_lang->stats_users_loggedin = "Currently Logged In";
$owl_lang->stats_information	= "За да видите тази статистика трябва да е влючено OWL Logging";

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
