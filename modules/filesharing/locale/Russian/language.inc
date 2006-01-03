<?php
/*
  File: Russian/language.inc
  Author: Ruslan Malanchuk
  Date: 2004/11/03

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
	$owl_lang->localized_date_format = "d M, Y \a\\t h:i a";
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
$owl_lang->err_adding_comments= "Вы не можете Добавлять комментарии к этому файлу";
$owl_lang->err_comment_empty            = "Comment cannot be empty";
$owl_lang->err_backup_file= "Ошибка при резервировании исходного файла";
$owl_lang->err_backup_folder_create="Ошибка создания папки Backup";
$owl_lang->err_bad_url= "Пожалуйста, введите правильный адрес";
$owl_lang->err_bad_version_1="Эта версия Owl Intranet требует наличия версии PHP";
$owl_lang->err_bad_version_2= "У вас работает версия";
$owl_lang->err_bad_version_3="Установите более новую версию php и попробуйте опять";
$owl_lang->err_email= "Сообщение не может быть отослано";
$owl_lang->err_email_required="Требуется адрес Email";
$owl_lang->err_fexist1="<b>Файл существует:</b>";
$owl_lang->err_fexist2= "В этой директории уже есть файл <i>";
$owl_lang->err_fexist3= "</i>.";
$owl_lang->err_file_exists="The file you are trying to upload already exists";
$owl_lang->err_fileexists= "Перемещение отменено<BR>Файл с таким именем уже существует.";
$owl_lang->err_file_lock= "You cannot check this file out, it is currently held by";
$owl_lang->err_update_file_lock         = "You cannot update this file, it is currently held by";
$owl_lang->err_filemove_exist="The filename you are trying to rename this file to already exists";
$owl_lang->err_file_not_exist="В файле настроек файловой системы php.ini значение";
$owl_lang->err_file_too_big="upload_max_filesize больше и/или<BR>несоответствует размеру этого файла";
$owl_lang->err_file_update="Для обновления файла требуется ввести его название отличающееся от прежнего, пожалуйста используйте другое название";
$owl_lang->err_folder_create="Ошибка создания папки";
$owl_lang->err_folder_exist="Эта папка уже есть";
$owl_lang->err_folderexists="Переименование отменено<BR>Папка с таким названием уже есть.";
$owl_lang->err_general="Произошла ошибка";
$owl_lang->err_group_delete="Вы не можете удалить группу пользователей";
$owl_lang->err_group_exists="Группа с таким названием уже есть.";
$owl_lang->err_gzip_not_found= "не найден gzip в ";
$owl_lang->err_login= "Пожалуйста введите логин для этого действия";
$owl_lang->err_movecancel="Перемещение отменено<BR>";
$owl_lang->err_nameempty="У папки должно быть название";
$owl_lang->err_news_required="ОШИБКА: У новости должен быть заголовок и текст!";
$owl_lang->err_no_access= "У вас нет прав для доступа к выделеным файлам";
$owl_lang->err_no_access_info           = "Possible causes: <br></br>1) You did not click any checkbox in front of a File or Folder<br></br>2) Bulk Delete, Bulk Email, Bulk Checkout do not apply to Folders<br></br>3) You do not have access to any of the files or folders you have selected.";
$owl_lang->err_noemail="You do not have access to email this file";
$owl_lang->err_nofileaccess="У вас нет прав для доступа к этому файлу";
$owl_lang->err_nofiledelete="У вас нет прав для удаления этого файла";
$owl_lang->err_nofilemod="У вас нет прав для редактирования этого файла";
$owl_lang->err_nofolderaccess= "У вас нет прав для доступа к этой папке";
$owl_lang->err_nofolderdelete= "У вас нет прав для удаления этой папки";
$owl_lang->err_nofoldermod="У вас нет прав для модификации этой папки";
$owl_lang->err_nosubfolder="У вас нет прав для создания подпапки";
$owl_lang->err_note_title="Заголовок является обязательным полем";
$owl_lang->err_note_title_exists = "Заметка с таким названием уже существует";
$owl_lang->err_noupload= "У вас нет прав для загрузки в эту папку";
$owl_lang->err_pass_missmatch= "Новый пароль и его подтверждение не совпадают";
$owl_lang->err_pass_wrong= "Старый пароль не правильный";
$owl_lang->err_pod2html_not_found="ОШИБКА: утилита pod2html не найдена:";
$owl_lang->err_quota= "У вас не хватает места для загрузки файла: ";
$owl_lang->err_quota_needed=" требуется ";
$owl_lang->err_quota_avail=" доступно.";
$owl_lang->err_quota_exceed= "Вы превысили выделенное вам дисковое пространство";
$owl_lang->err_req="ОШИБКА: все поля обязательны";
$owl_lang->err_root_delete="Корневую папку нельзя удалять";
$owl_lang->err_sess_notvalid="идентификатор вашей сессии не верный";
$owl_lang->err_sess_write= "Ошибка при записи информации о сессии в базу данных";
$owl_lang->err_specialfoldername="Название папки 'backup' зарезервировано системой документооборота";
$owl_lang->err_tar_not_found="tar не найден в ";
$owl_lang->err_trash_can_empty="Мусорка пуста";
$owl_lang->err_unauth_area= "Вы не авторизированы для доступа к этому разделу";
$owl_lang->err_unauthorized="Неавторизирован";
$owl_lang->err_upload= "Ошибка загрузки";
$owl_lang->err_user_exists="Есть такое имя пользователя";
$owl_lang->err_cant_del_doc_type="Немогу удалить этот тип документов, пока есть связанные с ним файлы";
$owl_lang->err_doc_type_name_req="Название типа документа обязательно<BR>";
$owl_lang->err_field_name_req="Название поля обязательно <BR>";
$owl_lang->err_doc_field_req="Не хватает нужных полей:";
$owl_lang->err_field_label_req="Надпись поля обязательна <BR>";
$owl_lang->err_field_size_req= "Размер поля обязательно <BR>";
$owl_lang->err_forbidden_file= "Forbidden File Type";
$owl_lang->err_file_indexing            = "Temporary 'TEXT' File Creation Failure";
$owl_lang->err_not_zip                  = "Not a Valid ZIP Archive";
$owl_lang->err_database                 = "Database error";
$owl_lang->err_sql                      = "SQL error";


//********************************************************
// Error Messages END
//********************************************************

$owl_lang->btn_go_top      = "Go To Top";                                                                                                                                                           
$owl_lang->btn_go_bottom      = "Go To Bottom";
$owl_lang->btn_admin="Админ";
$owl_lang->btn_logout="Выход";
$owl_lang->btn_browse="Обзор";
$owl_lang->btn_mail_tool     = "E-Mail";
$owl_lang->btn_help="Помощь";
$owl_lang->btn_add_field= "Add Field";
$owl_lang->btn_add_url= "Добавить адрес";
$owl_lang->btn_create= "Create";
$owl_lang->btn_register="Регистрация";
$owl_lang->btn_add_file="Добавить документ";
$owl_lang->btn_add_zip="Добавить архив";
$owl_lang->btn_admin_users="Новый пользователь";
$owl_lang->btn_admin_groups="Новая группа";
$owl_lang->btn_deldoctype="Del Doc Type";
$owl_lang->btn_expand_view="Развернуть";
$owl_lang->btn_add_folder="Добавить папку";
$owl_lang->btn_cancel="Отмена";
$owl_lang->btn_login="Логин";
$owl_lang->btn_send_email="Send E-Mail";
$owl_lang->btn_admin_news="Новости админа";
$owl_lang->btn_add_news="Добавить новость";
$owl_lang->btn_clickhere="Щелкните здесь";
$owl_lang->btn_edit_group="Редактировать группу";
$owl_lang->btn_add_note="Добавить заметку";
$owl_lang->btn_collapse_view="Свернуть";
$owl_lang->btn_edit_user="Редактировать юзера";
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
$owl_lang->alt_reset_form="Сбросить значения формы";
$owl_lang->alt_add_comments="Добавить комментарий к файлу";
$owl_lang->alt_btn_add_file="Загрузить новый файл";
$owl_lang->alt_btn_add_folder="Создать новую папку";
$owl_lang->alt_add_group="Создать группу";
$owl_lang->alt_add_news="Добавить новую тему новостей";
$owl_lang->alt_btn_add_note="Добавить заметку";
$owl_lang->alt_add_user="Создать пользователя";
$owl_lang->alt_btn_add_url="Создать новую ссылку";
$owl_lang->alt_cancel="Отменить действие";
$owl_lang->alt_cancel_move="Отменить перемещение";
$owl_lang->alt_change="Обновить эту запись";
$owl_lang->alt_btn_clickhere="Щелкните здесь";
$owl_lang->alt_btn_collapse_view="Переключиться на краткий просмотр";
$owl_lang->alt_comments="Комментарии к этому файлу есть";
$owl_lang->alt_del_comments="Удалить комментарий";
$owl_lang->alt_del_file="Удалить файл(Да/Нет)";
$owl_lang->alt_del_folder="Удалить папку(Да/Нет)";
$owl_lang->alt_del_group="Удалить эту группу";
$owl_lang->alt_del_news="Удалить эту новость";
$owl_lang->alt_del_selected="Удалить все выделенные файлы";
$owl_lang->alt_del_all          = "Empty Trash";
$owl_lang->alt_rest_selected="Восстановить отмеченные файлы";
$owl_lang->alt_del_this_folder="Удалить папку - ";
$owl_lang->alt_del_user= "Удалить пользователя";
$owl_lang->alt_edit_group="Редактировать эту группу";
$owl_lang->alt_edit_news="Редактировать новость";
$owl_lang->alt_edit_user="Редактировать пользователя";
$owl_lang->alt_email="Отправить файл по почте";
$owl_lang->alt_email_selected="Отправить все отмеченные файлы по почте";
$owl_lang->alt_btn_expand_view="Переключиться на расширенный просмотр";
$owl_lang->alt_admin_flush="Сбросить оставленную/прошедшую сессию";
$owl_lang->alt_get_file="Загрузить файл";                                                                                                                                                 
$owl_lang->alt_get_folder       = "Download Folder Content";
$owl_lang->alt_have_news="У вас есть новинки для просмотра";
$owl_lang->alt_have_no_news="Ничего нового для просмотра нет";
$owl_lang->alt_home_folder="Назад в корневую папку ";
$owl_lang->alt_set_initial_dir="Установить эту папку стартовой";
$owl_lang->alt_site_map="Карта сайта";
$owl_lang->alt_lock_file="Проверить файлы";
$owl_lang->alt_log_clear="Удалить все логи(Да/Нет)";
$owl_lang->alt_log_file="Файл протокола";
$owl_lang->alt_log_next="Показать следующие записи";
$owl_lang->alt_log_prev="Показать предыдущие записи";
$owl_lang->alt_log_top="Перейти к первой записи";
$owl_lang->alt_btn_login="Войти в Систему документооборота";
$owl_lang->alt_btn_logout="Выйти из Системы";
$owl_lang->alt_btn_help="Онлайновая справка по Owl";
$owl_lang->alt_mod_file="Изменить свойства файла"; 
$owl_lang->alt_mod_folder="Изменить свойства папки";
$owl_lang->alt_move_file="Переместить файл";
$owl_lang->alt_copy_file="Скопировать файл";
$owl_lang->alt_link_file        = "Link This File to Another Directory";
$owl_lang->alt_move_folder="Переместить папку";
$owl_lang->alt_copy_folder="Скопировать папку";
$owl_lang->alt_move_selected="Переместить выбранные файлы";
$owl_lang->alt_admin_groups="Создать новую группу";
$owl_lang->alt_news_close="Закрыть окно новостей";
$owl_lang->alt_news_next="Показать следующую новость";
$owl_lang->alt_news_prev="Показать предыдущую новость";
$owl_lang->alt_news_print="Напечатать эту новость";
$owl_lang->alt_admin_users="Создать нового пользователя";
$owl_lang->alt_monitor="Контроль этого файла";
$owl_lang->alt_monitored="Остановить контроль этого файла";
$owl_lang->alt_btn_admin="Администрирование";
$owl_lang->alt_play_file="Играть медиафайл";
$owl_lang->alt_recycle="Корзина<br></br>(пустая)";
$owl_lang->alt_recycle_disable="Корзина<br></br>(отключена)";
$owl_lang->alt_recycle_not_found="Корзина<br></br>(Не найдена)";
$owl_lang->alt_refresh_filter="Применить фильтр/Обновить результаты";
$owl_lang->alt_register="Отправить мою регистрацию";
$owl_lang->alt_btn_browse="Назад в проводник файлов";
$owl_lang->alt_search="Начать поиск";
$owl_lang->alt_send_email="Отправить письмо";
$owl_lang->alt_sendfile="Отправить файл";
$owl_lang->alt_toggle_check_box="Отметить файлы";
$owl_lang->alt_unlock_file="Check file in";
$owl_lang->alt_upd_file="Обновить файл";
$owl_lang->alt_view_comments="Добавить/просмотреть комментарии";
$owl_lang->alt_view_file="Просмотреть файл";
$owl_lang->alt_edit_field="Править описание этого поля";
$owl_lang->alt_del_field="Удалить это поле";
$owl_lang->alt_add_field="Добавить поле после";
$owl_lang->alt_deldoctype="Удалить текущий тип документа";
$owl_lang->alt_upd_field="Обновить поле";
$owl_lang->alt_new_doctype="Создать новый тип документа";
$owl_lang->alt_related="Найти связанные документы";
$owl_lang->alt_back             = "Return To Previous Screen";
$owl_lang->alt_submit           = "Submit Form";

//********************************************************
// Image Alternate popup Messages END
//********************************************************


//********************************************************
// Owl Logging messages BEGIN
//********************************************************

$owl_lang->log_del_det="Entire Content was also deleted";
$owl_lang->log_detail="Нет текущих деталей";
$owl_lang->log_file_to="TO: ";
$owl_lang->log_filter_all="ВСЕ";
$owl_lang->log_login_det="Имя: ";
$log_file_actions[1]="LOGIN";
$log_file_actions[2]="LOGIN FAILED";
$log_file_actions[3]="LOGOUT";
$log_file_actions[4]="FILE DELETED";
$log_file_actions[5]="FILE UPLOAD";
$log_file_actions[6]="FILE UPDATED";
$log_file_actions[7]="FILE DOWNLOADED";
$log_file_actions[8]="FILE CHANGED";
$log_file_actions[9]="FILE LOCKED";
$log_file_actions[10]="FILE UNLOCKED";
$log_file_actions[11]="FILE EMAILED";
$log_file_actions[12]="FILE MOVED";
$log_file_actions[13]="FOLDER CREATED";
$log_file_actions[14]="FOLDER DELETED";
$log_file_actions[15]="FOLDER MODIFIED";
$log_file_actions[16]="FOLDER MOVED";
$log_file_actions[17]="FORGOT PASS";
$log_file_actions[18]="USER REG";
$log_file_actions[19]="FILE VIEWED";
$log_file_actions[20]="FILE VIRUS";
$log_file_actions[21]="FILE COPIED";
$log_file_actions[22]           = "FOLDER COPIED";
$log_file_actions[23]           = "FILE_LINKED";

//********************************************************
// Owl Logging messages END
//********************************************************


//********************************************************
// index.php  BEGIN
//********************************************************

$owl_lang->anonymous="(Анонимный доступ)";
$owl_lang->repository_list      = "Repository:";
$owl_lang->engine="Система документооборота";
$owl_lang->forgot_pass="Забыли свой пароль?";
$owl_lang->like_register="Хотите зарегистрироваться?";
$owl_lang->login= "Логин";
$owl_lang->loginfail="Логин неверный";
$owl_lang->logindisabled="Ваш аккаунт ОТКЛЮЧЕН, обратитесь к Администратору";
$owl_lang->password="Пароль";
$owl_lang->successlogout="Вы вышли";
$owl_lang->toomanysessions="Максимальное количество сессий использовано, обратитесь к Администратору сервера";
$owl_lang->username="Имя";
$owl_lang->version ="Версия";

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
$owl_lang->actions="Действия";
$owl_lang->del_selected="Удалить выбранные";
$owl_lang->del_all                      = "Empty Trash";
$owl_lang->rest_selected="Восстановить выбранные";
$owl_lang->disk_quota= "Дисковая квота";
$owl_lang->email_selected="Выбран Email";
$owl_lang->file= "Файл";
$owl_lang->folder_policy="Установки текущей папки:";
$owl_lang->current_folder="Текущая папка:";
$owl_lang->held="Сжата"; 
$owl_lang->last_logged="Последний: ";
$owl_lang->current_db                   = "Current Repository:";
$owl_lang->modified="Изменен";
$owl_lang->move_selected="Переместить выделенные";
$owl_lang->new_file= "Новые!";
$owl_lang->no_description="Без описания";
$owl_lang->page= "Страница:";
$owl_lang->postedby= "Прислано";
$owl_lang->reallydelete="Действительно удалить";
$owl_lang->reallydelete_logs="Очистить лог-файл";
$owl_lang->reallydelete_selected="Действительно удалить отмеченные файлы";
$owl_lang->reallyrestore_selected="Действительно восстановить все отмеченные файлы";
$owl_lang->size="Размер";
$owl_lang->score                        = "Score";
$owl_lang->title="Заголовок";
$owl_lang->doc_number="Документ №";
$owl_lang->tot_files="Всего:";
$owl_lang->tot_my_checked_out="Проверено:";
$owl_lang->tot_my_files="Мои:";
$owl_lang->tot_my_group	="Группа:";
$owl_lang->tot_new_files="Новый:";
$owl_lang->tot_updated_files="Обновлен:";
$owl_lang->tot_monitored= "На контроле:";
$owl_lang->updated_file= "Обновлен!";
$owl_lang->user="Пользователь";
$owl_lang->ver="Вер.";
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
$owl_lang->adding_comments="Добавить/Смотреть комментарии: ";
$owl_lang->comments= "Комментарии";
$owl_lang->post_comment="Добавить комментарий";
$owl_lang->addingfile="Добавить файл в ";
$owl_lang->addingfolder="Добавить папку в ";
$owl_lang->attach_file="Прикрепить файл";
$owl_lang->change="Изменить";
$owl_lang->create="Создать";
$owl_lang->comments_added="Комментарии добавлены: ";
$owl_lang->description="Описание";
$owl_lang->email_body="Сообщение";
$owl_lang->email_cc="CC";
$owl_lang->email_reply_to="Ответить";
$owl_lang->email_subject="Тема";
$owl_lang->email_to="Кому";
$owl_lang->emailing="Emailing";
$owl_lang->disp_mp3	= "MP3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Песня:<BR>Альбом:<BR>Битрейт&nbsp;-&nbsp;Samplerate:<BR>Частота:<BR>Жанр:<BR>Комментарий:";
$owl_lang->keywords="Ключевые слова";
$owl_lang->modify_url="Адрес";
$owl_lang->modifying="Модифицирован ";
$owl_lang->name="Полное имя"; 
$owl_lang->notify_link="Owl External Link";
$owl_lang->note_content="Текст заметки";
$owl_lang->ownergroup="Владелец (группа)";
$owl_lang->ownership= "Ownership";
$owl_lang->permissions="Права доступа";
$owl_lang->prop_permissions="Propagate Permissions to subfolders?";
$owl_lang->prop_perms_files="Permissions to propagate to files:";
$owl_lang->policy="Безопасность";
$owl_lang->pick_select="&#8212; Выберите пользователя &#8212;";
$owl_lang->sendfile="Отправить файл";
$owl_lang->sendthisfile="Отправить этот файл";
$owl_lang->sendthisurl="Отправить адрес";
$owl_lang->updating="Обновить";
$owl_lang->verdescription="Описание<br></br>изменений";
$owl_lang->vermajor="Версия первого пересмотра";
$owl_lang->verminor="Версия последнего пересмотра";
$owl_lang->vertype="Тип пересмотра";  

//********************************************************
// modify.php  END
//********************************************************


//********************************************************
// register.php  BEGIN
//********************************************************

$owl_lang->email="Адрес почты";
$owl_lang->full_name="Полное имя";
$owl_lang->register="Регистрация пользователя";
$owl_lang->self_failed="Ошибка";
$owl_lang->self_passwd="Пароль отправлен к:";
$owl_lang->self_reg_bod="Ваш пароль в Системе:";
$owl_lang->self_reg_rset="Ваш пароль в Системе сброшен до:";
$owl_lang->self_reg_subj="Ваша учетная запись";
$owl_lang->send_pass="Отослать пароль";
$owl_lang->submit="Зарегистрироваться";
$owl_lang->thank_you_1="Спасибо!";
$owl_lang->thank_you_2="Письмо отослано на ваш электронный адрес<BR>с НОВЫМ паролем для<BR><b>ПОЛЬЗОВАТЕЛЯ:</b>";

//********************************************************
// register.php  END
//********************************************************


//********************************************************
// move.php  BEGIN
//********************************************************

$owl_lang->cancel_button="Отмена";
$owl_lang->moving="Перемещение";
$owl_lang->moving_file="Переместить файлы";
$owl_lang->moving_folder="Переместить папку";
$owl_lang->copy_file="Скопировать файл";
$owl_lang->copy_folder="Скопировать папку";
$owl_lang->select="Пожалуйста выберите новую папку:";

//********************************************************
// move.php  END
//********************************************************


//********************************************************
// log.php  BEGIN
//********************************************************

$owl_lang->viewlog="Просмотр лога для ";

//********************************************************
// log.php  END
//********************************************************


//********************************************************
// prefs.php  BEGIN
//********************************************************

$owl_lang->confpassword="Повторите новый пароль";
$owl_lang->comment_notif="Сообщать о комментариях";
$owl_lang->email_tool   = "E-Mail Tool";
$owl_lang->last_modified="Последнее изменение";
$owl_lang->group="Ведущая группа";
$owl_lang->groupmember="Состоит в группе";
$owl_lang->newpassword="Новый пароль";
$owl_lang->newsadmin="Новости администратора";
$owl_lang->not_member="Вы не состоите ни в одной из текущих групп";
$owl_lang->notification="Присылать извещения";
$owl_lang->oldpassword="Старый пароль";
$owl_lang->preference="Настройки";
$owl_lang->saved="Изменения сохранены";
$owl_lang->status_no="НЕТ";
$owl_lang->status_yes="ДА";
$owl_lang->userlang="Язык";

//********************************************************
// prefs.php  END
//********************************************************


//********************************************************
// search.php  BEGIN
//********************************************************

$owl_lang->elapsed_time="осталось времени";
$owl_lang->search="Поиск";
$owl_lang->search_any_word="Любое слово";
$owl_lang->search_all_word="Все слова";
$owl_lang->search_entire_phrase="Как фразу";
$owl_lang->search_match="Соответствие:";
$owl_lang->search_currentfolder="Искать в текущей папке";
$owl_lang->search_for_folders="Искать в папках";
$owl_lang->search_for_files="Искать в файлах";
$owl_lang->search_score="Scoring Files";
$owl_lang->search_results_for="Результаты поиска для";
$owl_lang->search_winthindocs="Искать внутри";
$owl_lang->related_query_empty  = "No metadata associated with document to perform 'Search Related'";
$owl_lang->query_empty="Поле поиска пустое";

//********************************************************
// search.php  END
//********************************************************


//********************************************************
// view.php  BEGIN
//********************************************************

$owl_lang->viewing="Просмотр ";

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
$owl_lang->btn_users_groups="Пользователи<br></br>и Группы";
$owl_lang->alt_users_groups="Администрирование пользователей и групп";
$owl_lang->btn_html_prefs="Настройки<br></br>HTML";
$owl_lang->alt_html_prefs="Редактировать HTML-настройки сайта";
$owl_lang->btn_site_features="Настройки<br></br>сайта";
$owl_lang->alt_site_features="Редактировать настройки и возможности сайта";
$owl_lang->btn_log_viewer="Просмотр<br></br>логов";
$owl_lang->alt_log_viewer="Просмотр протоколов работы сайта";
$owl_lang->btn_statistics_viewer="Просмотр<br></br>статистики";
$owl_lang->alt_statistics_viewer="Просмотр статистики";
$owl_lang->btn_news_admin="Новости<br></br>админа";
$owl_lang->alt_news_admin="Новости администратора";
$owl_lang->btn_doctype_admin="Типы<br></br>документов";
$owl_lang->alt_doctype_admin="Администрирование типов документов";
$owl_lang->btn_backup="Резерв<br></br>базы данных";
$owl_lang->alt_backup="Резервировать БД SQL";
$owl_lang->btn_trashcan="Корзина";
$owl_lang->alt_trashcan="Щелкните для просмотра содержимого";
$owl_lang->btn_initial_load="Инициирующая загрузка";
$owl_lang->alt_initial_load="Load DB From Documents Folder";
$owl_lang->confirm_initial_load= "*** ПРЕДУПРЕЖДЕНИЕ ***  Это надо делать только один раз, пока таблицы БД пусты";
$owl_lang->add="Добавить";
$owl_lang->anonymous_account="Аккаунт анонимного доступа:";
$owl_lang->buttonstyle= "Стиль кнопок";
$owl_lang->deletegroup="Удалить группу";
$owl_lang->deleteuser="Удалить пользователя";
$owl_lang->disableuser="Отключить пользователя";
$owl_lang->disable_recs_per_page="Enabling Restricted View Will DISABLE Records Per Page!";
$owl_lang->file_admin_group="Администраторы файлов/проводника:";
$owl_lang->flushed="Таблицы сессии сброшены, пользователь может логиниться.<BR>";
$owl_lang->groups="Группы";
$owl_lang->hide_bulk_buttons="Hide the bulk buttons:";
// Edit HTML Properties Messages BEGIN
$owl_lang->ht_tbl_border_sz="Размер бордюра таблицы:";
$owl_lang->ht_tbl_hd_bg	="Фон заголовка:";
$owl_lang->ht_tbl_cell_bg_cl="Фоновый цвет ячейки таблицы:";
$owl_lang->ht_tbl_cell_bg_al="Альтернативный фоновый цвет ячейки:";
$owl_lang->ht_expand_width="Ширина расширенного просмотра:";
$owl_lang->ht_collapse_width="Ширина сокращенного просмотра:";
$owl_lang->ht_bd_bg_image="Путь к фоновому изображению:";
$owl_lang->ht_bd_txt_cl="Основной цвет текста:";
$owl_lang->ht_bd_lnk_cl="Основной цвет ссылок:";
$owl_lang->ht_bd_vlnk_cl="Основной цвет посещенных ссылок:";
// Edit Prefs Properties Messages END
$owl_lang->home_dir="Домашняя папка пользователей";
$owl_lang->initial_dir                  = "User's Initial Directory";
$owl_lang->maxsessions="Максимальное кол-во сессий";
$owl_lang->noprefaccess="Отключить настройки";
$owl_lang->owl_anon_full                = "Full Access";
$owl_lang->owl_anon_ro="Анонимные пользователи могут только читать:";
$owl_lang->owl_anon_download            = "Download Only";
$owl_lang->anonymous_access             = "Set Anonymous Access";
$owl_lang->owl_dbdump_path="Путь к утилите Dump:";
$owl_lang->owl_def_file_group_owner="Группа владельцев файла по-умолчанию:";
$owl_lang->owl_def_file_meta="Default File Meta Data:";
$owl_lang->owl_def_file_owner="Владелец файла по-умолчанию:";
$owl_lang->owl_def_file_perm="Default File Creation Policy:";
$owl_lang->owl_def_file_security="Default File Security:";
$owl_lang->owl_def_file_title="Default File Title (None for Filename):";
$owl_lang->owl_def_fold_group_owner="Default Folder Group Owner:";
$owl_lang->owl_def_fold_owner="Default Folder Owner:";
$owl_lang->owl_def_fold_sec="Default Folder Security:";
$owl_lang->owl_def_folder_perm="Установки прав доступа к папке по-умолчанию:";
$owl_lang->owl_default_tmpdir="Путь к папке Temp: ";
$owl_lang->owl_email_from="From Address/SMTP Auth Login:";
$owl_lang->owl_email_fromname="От кого:";
$owl_lang->owl_email_replyto="Адрес в ответе:";
$owl_lang->owl_email_server="Сервер SMTP:";
$owl_lang->owl_email_smtp="Использовать SMTP";
$owl_lang->owl_email_smtp_auth		="Аутентификация SMTP";
$owl_lang->owl_email_smtp_auth_login    = "SMTP Auth Login:";
$owl_lang->owl_email_smtp_auth_passwd	= "Пароль SMTP";
$owl_lang->owl_email_subject_pref	="Приставка к теме:";
$owl_lang->owl_fogotpass		="Показывать ссылку <u>Забыли пароль?</u>:";
$owl_lang->owl_group_user		="Users that are member of this Group";
$owl_lang->owl_gzip_path		="Путь к gzip:";
$owl_lang->owl_hidebackup		="Скрыть папку Backup:";
$owl_lang->owl_log_file			="Включить протоколирование в лог:";
$owl_lang->owl_log_login_act		="Записывать в логи вход/выход пользователей:";
$owl_lang->owl_log_rec_page		="Кол-во записей лога на страницу:";
$owl_lang->owl_logging			= "Включить вход по логину:";
$owl_lang->owl_logo			= "Логотип страницы входа (в папке [ваш_язык]/graphics):";
$owl_lang->owl_lookAtHD			= "Disable Look at hd:";
$owl_lang->owl_lookAtHDDel		="Удалить вытертые файлы из БД:";
$owl_lang->hide_folder_doc_count        = "Hide Folder File Type Count";                                                                                                                        
$owl_lang->hide_folder_size             = "Hide Folder Content Size";
$owl_lang->old_action_icons             = "Use pre Owl 0.80 Action Icons";
$owl_lang->search_result_folders        = "Include Folders in Search Results";
$owl_lang->restore_file_prefix          = "String Prefixed to Restored Files";
$owl_lang->owl_max_filesize		="Максимальный размер загружаемого файла:";
$owl_lang->owl_owl_expand		="Просмотр по-умолчанию(развернутый):";
$owl_lang->owl_owl_timeout		= "Продолжительность сессии в секундах:";
$owl_lang->virus_path                   = "Virus Checking Software Path<br />Example: '/usr/bin/clamscan --quiet' <br />&#8211; Blank for Disabled:";
$owl_lang->owl_pdftotext_path		="Поддержка поискового индекса<BR>для PDF и текстовых файлов<BR>&#8211; Оставить пустым для отключения:";
$owl_lang->owl_wordtotext_path		= "Файлы MS-WORD<BR>- Оставить пустым для отключения:";
$owl_lang->owl_pod2html_path		= "Требуется Perl 5.8.0 и выше<BR>Путь к pod2html:";
$owl_lang->owl_restrict_view		= "Включить функции ограничения просмотра:";
$owl_lang->owl_self_reg			="Включить саморегистрацию пользователей:";
$owl_lang->owl_self_reg_hd		="УМОЛЧАНИЯ ДЛЯ САМОРЕГИСТРАЦИИ";
$owl_lang->owl_tar_path			= "Путь к tar:";
$owl_lang->owl_title_custom             = "CUSTOMIZE BROWSER COLUMNS";
$owl_lang->owl_title_custom_search      = "CUSTOMIZE SEARCH RESULTS";
$owl_lang->owl_title_browser		="ВОЗМОЖНОСТИ ПРОСМОТРА";
$owl_lang->owl_title_defaults		="ПО УМОЛЧАНИЮ";
$owl_lang->owl_title_email		="Настройки системы почты";
$owl_lang->owl_title_HD			="LOOK AT HD FOR NEW FILES SETTINGS";
$owl_lang->owl_title_logging		="НАСТРОЙКИ ВХОДА";
$owl_lang->owl_title_other		="ОБЩИЕ НАСТРОЙКИ";
$owl_lang->owl_title_tools		="РЕЗЕРВ БД/УТИЛИТА GZIP";
$owl_lang->owl_unzip_path		="путь к unzip:";
$owl_lang->owl_version_control		="Включить контроль версий файлов:";
$owl_lang->quota			= "Квота 0=Отключена";
$owl_lang->reallydeluser		= "У этого пользователя %numfiles% файл(ов) и %numfolders% папка(ок). Этот файл(ы) и папка(ки) останутся бе владельца. Ok для удаления?";
$owl_lang->recs_per_page		= "Количество записей на страницу (0=Отключено):";
$owl_lang->remember_me_title		="ПОСТОЯННЫЕ НАСТРОЙКИ ЛОГИНА";
$owl_lang->remember_me			="Показывать ссылку Запомнить меня";
$owl_lang->remember_timeout		= "Cookie недействительны через дней";
$owl_lang->remember_me_checkbox		= "Запомнить меня";
$owl_lang->recycle_title		= "НАСТРОЙКИ КОРЗИНЫ";
$owl_lang->recycle_enabled= "Включить накопитель мусорки:";
$owl_lang->recycle_location= "Размещение мусорки:";
$owl_lang->show_panel_title="Показывать панель статуса:";
$owl_lang->show_search_title= "Показывать панель поиска:";
$owl_lang->show_pref_title="Показывать панель Настроек/Выхода:";
$owl_lang->show_bulk_title="Display Bulk Buttons:";
$owl_lang->show_action_title= "Показывать кнопки действия:";
$owl_lang->show_folder_title= "Показывать папку утилит:";
$owl_lang->show_panel= "Показать";
$owl_lang->hide_panel= "Скрыть";
$owl_lang->status_bar_both= "Вверху и внизу";
$owl_lang->status_bar_bottom ="Только внизу";
$owl_lang->status_bar_location= "Показывать строку статуса:";
$owl_lang->status_bar_top="Только наверху";
$owl_lang->status_bar_not= "Не показывать";
$owl_lang->use_popup="Использовать вспл.окно для показа Новостей:";
$owl_lang->users= "Пользователи";
$owl_lang->header_user_admin            = "User Administration";
$owl_lang->header_group_admin           = "Group Administration";
$owl_lang->header_sitefeatures_settings           = "Site Features and Settings";

//********************************************************
// admin/index.php  END
//********************************************************


//********************************************************
// admin/log.php  BEGIN
//********************************************************

$owl_lang->owl_log_viewer="Просмотр лога";
$owl_lang->owl_log_hd_action="Действие";
$owl_lang->owl_log_hd_file="Файл";
$owl_lang->owl_log_hd_fld_path="Путь к папке";
$owl_lang->owl_log_hd_user="Пользователь";
$owl_lang->owl_log_hd_dt_tm="Дата время";
$owl_lang->owl_log_hd_ip="IP/адрес";
$owl_lang->owl_log_hd_agent="Агент";
$owl_lang->owl_log_hd_dtls="Подробно";
$owl_lang->owl_log_no_rec=" НЕ НАЙДЕНЫ ЗАПИСИ ";
$owl_lang->owl_log_hide="Скрыто: ";
$owl_lang->owl_log_filter="Фильтр";

//********************************************************
// admin/log.php  END
//********************************************************


//********************************************************
// admin/recycle.php  BEGIN
//********************************************************

$owl_lang->empty_trash = "Очистить мусорку";
$owl_lang->really_empty_trash= "Вы действительно хотите очистить мусорку?";
$owl_lang->recycle_bin_admin= "Администрирование корзины";

//********************************************************
// admin/recycle.php  END
//********************************************************


//********************************************************
// lib/owl.lib.php  BEGIN
//********************************************************

$owl_lang->file_size_byte= "байт";
$owl_lang->file_size_gigabyte= "Гб";
$owl_lang->file_size_kilobyte= "Кб";
$owl_lang->file_size_megabyte= "Мб";
$owl_lang->notif_subject_new= "Новые файлы";
$owl_lang->notif_subject_upd= "Файл в Системе обновлен";
$owl_lang->notif_subject_monitor= "An OWL Intranet File or Folder you are MONITORING was updated";
$owl_lang->notif_subject_comment= "Комментарий к файлу добавлен";
$owl_lang->notif_comment_1= "комментарий включен";
$owl_lang->notif_comment_2= "Комментарий:";
$owl_lang->notif_msg= "Это автоматическое сообщение Системы документооборота<BR><BR>Новые/обновленные файлы прикреплены к этому письму<BR><BR>";
$owl_lang->notif_msg_link               = "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet<BR><BR>Find a link to a new/updated file in this E-Mail<BR><BR>";
$owl_lang->notif_msg_alt_link           = "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet\n\nFind a link to a new/updated file in this E-Mail\n\n";
$owl_lang->notif_msg_alt= "Это автоматическое сообщение Системы документооборота\n\nНовые/обновленные файлы прикреплены к этому письму\n\n";
$owl_lang->notif_salutation	= "Уважаемый";
$owl_lang->notif_user                   = "Created/Update by:";
$owl_lang->owl_path= "Путь к файлу: ";
$owl_lang->sessinuse= "Эта сессия запущена на другом компьютере, доступ запрещен<BR>";
$owl_lang->invalidsess= "Неверный номер сессии, пожалуйста ввойдите еще раз с главной страницы<BR>";
$owl_lang->sesstimeout= "Время вашей сессии закончилось, пожалуйста повторите вход<BR>";
$owl_lang->everyoneread	= "Все могут читать/скачивать";
$owl_lang->everyonewrite= "Все могут читать/записывать/скачивать";
$owl_lang->everyonewrite_nod= "Все могут читать/записывать/скачивать, НО НЕ УДАЛЯТЬ";
$owl_lang->groupread= "Ваша группа может читать/скачивать";
$owl_lang->groupwrite= "Ваша группа может читать/записывать/скачивать";
$owl_lang->groupwrite_nod= "Ваша группа может читать/записывать/скачивать, НО НЕ УДАЛЯТЬ";
$owl_lang->onlyyou= "Только чтение/скачивание/запись";
$owl_lang->donothing = "Ничего не делать - Оставьте поля доступа как есть";
$owl_lang->groupwrite_worldread="Ваша группа может читать/записывать/скачивать и любой другой может читать";
$owl_lang->groupwrite_worldread_nod= "Ваша группа может читать/записывать/скачивать (БЕЗ УДАЛЕНИЯ) и любой может читать";
$owl_lang->ggroupwrite_worldread= "Ваша группа может загружать файлы и удалять из этой папки и любой может просмотреть содержимое папки";
$owl_lang->ggroupwrite_worldread_nod="Ваша группа может загружать файлы и удалять из этой папки и любой может просмотреть содержимое папки, БЕЗ УДАЛЕНИЯ";
$owl_lang->everyoneread_ad= "Все могут читать/скачивать";
$owl_lang->everyonewrite_ad= "Все могут читать/записывать/скачивать";
$owl_lang->everyonewrite_ad_nod= "Все могут читать/записывать/скачивать, БЕЗ УДАЛЕНИЯ";
$owl_lang->groupread_ad="Выбранная группа может читать/скачивать";
$owl_lang->groupwrite_ad= "Выбранная группа может читать/записывать/скачивать";
$owl_lang->groupwrite_ad_nod="Выбранная группа может читать/записывать/скачивать, БЕЗ УДАЛЕНИЯ";
$owl_lang->onlyyou_ad= "Только вы можете читать/скачивать/записывать";
$owl_lang->groupwrite_worldread_ad="Выбранная группа может читать/записывать/скачивать и любой другой может читать";
$owl_lang->groupwrite_worldread_ad_nod= "Выбранная группа может читать/записывать/скачивать (БЕЗ УДАЛЕНИЯ) и любой другой может читать";
$owl_lang->ggroupwrite_worldread_ad="Выбранная группа может загружать файлы и удалять из этой папки и любой другой может просматривать содержимое";
$owl_lang->ggroupwrite_worldread_ad_nod	= "Выбранная группа может загружать файлы в эту папку и любой другой может просмотреть содержимое, БЕЗ УДАЛЕНИЯ";
$owl_lang->geveryoneread="Все могут просматривать эту папку";
$owl_lang->geveryonewrite= "Все могут загружать и удалять файлы из этой папки";
$owl_lang->geveryonewrite_nod= "Все могут загружать файлы в эту папку";
$owl_lang->ggroupread="Ваша группа может читать эту папку";
$owl_lang->ggroupwrite= "Ваша группа может загружать и удалять файлы из этой папки";
$owl_lang->ggroupwrite_nod= "Ваша группа может загружать файлы в эту папку";
$owl_lang->gonlyyou="Только ВЫ можете загружать и удалять файлы из этой папки";
$owl_lang->geveryoneread_ad= "Все могут читать содержимое этой папки";
$owl_lang->geveryonewrite_ad= "Все могут загружать и удалять файлы из этой папки";
$owl_lang->geveryonewrite_ad_nod="Все могут загружать файлы в эту папку";
$owl_lang->ggroupread_ad="Выбранная группа может читать эту папку";
$owl_lang->ggroupwrite_ad= "Выбранная группа может загружать и удалять файлы в этой папке";
$owl_lang->ggroupwrite_ad_nod	= "Выбранная группа может загружать файлы в эту папке";
$owl_lang->gonlyyou_ad= "Только вы можете загружать и удалять файлы в этой папке";
$owl_lang->orphaned="&#8211; БЕЗ владельца  &#8211;";
$owl_lang->virus_infected= "ФАЙЛ ИНФИЦИРОВАН ВИРУСОМ";
$owl_lang->virus_return_val= "Антивирус вернул значение:";

//********************************************************
// lib/owl.lib.php  END
//********************************************************


//********************************************************
// HREF TITLE messages  BEGIN
//********************************************************

$owl_lang->title_browse_folder= "Обзор этой папки";
$owl_lang->title_browse_site= "Просмотр этого адреса";
$owl_lang->title_download_view= "Загрузить/Посмотреть файл";
$owl_lang->title_edit_prefs = "Просмотреть/изменить настройки пользователя";
$owl_lang->title_return_folder= "Назад к";
$owl_lang->title_sort= "Сортировать по";
$owl_lang->title_view_new = "Просмотреть список новых файлов с момента моего последнего визита";
$owl_lang->title_view_updated= "Просмотреть список обновленных файлов с момента моего последнего визита";
$owl_lang->title_view_my = "Показать список моих файлов";

//********************************************************
// HREF TITLE messages  END
//********************************************************


//********************************************************
// admin/news.php and newsread.php BEGIN
//********************************************************

$owl_lang->news_title= "Администрирование новостей";
$owl_lang->news_hd= "Новости";
$owl_lang->news_hd_created= "Создано в";
$owl_lang->news_hd_expires= "Заканчивается в";
$owl_lang->news_hd_audience= "Целевая аудитория";
$owl_lang->news_heading	= "Заголовок новости";
$owl_lang->news_content= "Текст";
$owl_lang->news_posted_date	= "Новость размещена:";
$owl_lang->news_read="Читать";

//********************************************************
// admin/news.php and newsread.php  END
//********************************************************


//********************************************************
// DEBUG MESSAGES BEGIN
//********************************************************

$owl_lang->debug_tmp_not_exists= "ОТЛАДКА: Временная папка OWL: $default->owl_tmpdir не существует.";
$owl_lang->debug_tmp_not_writeable= "ОТЛАДКА: Временная папка OWL: $default->owl_tmpdir не доступна для записи на сервере.";
$owl_lang->debug_doc_not_exists= "ОТЛАДКА: Папка документов OWL: ".$default->owl_fs_root."/".fid_to_name(1)." не существует.";
$owl_lang->debug_doc_not_writeable= "ОТЛАДКА: Папка документов OWL: ".$default->owl_fs_root."/".fid_to_name(1)." не доступна для записи на сервере.";
$owl_lang->debug_webserver_no_access    = "DEBUG: The webserver does not have read access to: <br />'$default->owl_fs_root/$filename'. <br />Please fix the permissions and try again";
$owl_lang->debug_file_not_exist         = "DEBUG: The required file '$default->owl_fs_root/$filename' does not exists.<br /> OR<br />The path specified by \$default->owl_fs_root in config/owl.php is wrong.";

//********************************************************
// DEBUG MESSAGES END
//********************************************************


//********************************************************
// admin/stats.php BEGIN
//********************************************************

$owl_lang->owl_stats_viewer="Просмотр статистики";
$owl_lang->stats_files="Количество файлов на пользователя";
$owl_lang->stats_folders="Количество папок на пользователя";
$owl_lang->stats_top="ТОП 20 загрузок";
$owl_lang->stats_users          = "USER Signon (Login / Failure / Logout)";
$owl_lang->stats_users_loggedin = "Currently Logged In";
$owl_lang->stats_information="Owl Logging and File logging needs to be turned on for this statistics to be displayed";

//********************************************************
// admin/stats.php END
//********************************************************

//********************************************************
// admin/doctype.php BEGIN
//********************************************************

$owl_lang->document_type="Тип документа";
$owl_lang->document_type_name="Название типа документа";
$owl_lang->doc_field_name="Название поля";
$owl_lang->doc_field_pos="Позиция поля";
$owl_lang->doc_field_label="Название поля (на вашем языке)";
$owl_lang->doc_field_size="Размер поля";
$owl_lang->doc_field_searchable="Поиск по полю?";
$owl_lang->doc_field_required="Обязательное?";
$owl_lang->doc_new_doc_type= "&#8212; Добавить новый тип документа &#8212;";
$owl_lang->doc_specific="Специфические поля документа:";
$owl_lang->doc_administration="Администрирование типов документов";

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
