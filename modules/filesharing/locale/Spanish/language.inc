<?php

/*

  File: Spanish/language.inc
  Author: Chris
  Modified: Hern&aacute;n E. Delgado
  Date: 2003/08/28
  See CVS logs for further modifications notes.

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
$owl_lang->err_adding_comments			= "Usted no tiene permisos para agregar comentarios a este archivo";
$owl_lang->err_comment_empty            = "Comment cannot be empty";
$owl_lang->err_backup_file				= "Error al crear una copia de seguridad de un archivo ya existente";
$owl_lang->err_bad_url                  = "Por favor introduzca un URL valido";
$owl_lang->err_backup_folder_create 	= "Error al crear la carpeta de copias de seguridad";
$owl_lang->err_bad_version_1			= "Owl Intranet requiere como m&iacute;nimo la versi&oacute;n de PHP";
$owl_lang->err_bad_version_2			= "T&uacute; ejecutas la Versi&oacute;n";
$owl_lang->err_bad_version_3			= "Instala una nueva versi&oacute;n de php e intentalo nuevamente";
$owl_lang->err_email					= "El mensaje no pudo ser enviado";
$owl_lang->err_email_required			= "Campo Email es requerido";
$owl_lang->err_fexist1					= "<b>Archivo Existe:</b>";
$owl_lang->err_fexist2					= "Existe un archivo con el nombre <i>";
$owl_lang->err_fexist3					= "</i> en este directorio.";
$owl_lang->err_file_exists				= "El archivo que intentas agregar ya existe";
$owl_lang->err_fileexists				= "La operaci&oacute;n mover fue cancelada, un archivo con el mismo nombre ya existe.";
$owl_lang->err_file_lock				= "En este momento no puede bajar este archivo, El archivo se encuentra bloqueado por";
$owl_lang->err_update_file_lock         = "You cannot update this file, it is currently held by";
$owl_lang->err_filemove_exist			= "El nombre de archivo al que quiere cambiar, ya existe previamente";
$owl_lang->err_file_not_exist			= "El archivo no existe en el sistema de archivos";
$owl_lang->err_file_too_big				= "php.ini upload_max_filesize excede y/o<BR>Ha Excedido el tama&ntilde;o m&aacute;ximo de Owl";
$owl_lang->err_file_update				= "Para actualizar un archivo es necesario usar el mismo nombre, por favor intentelo nuevamente usando el mismo nombre de archivo";
$owl_lang->err_folder_create			= "Error al crear la carpeta";
$owl_lang->err_folder_exist				= "Esta carpeta ya existe";
$owl_lang->err_folderexists				= "El renombramiento fue cancelado existe una carpeta con el mismo nombre.";
$owl_lang->err_general					= "Ha ocurrido un error";
$owl_lang->err_group_delete				= "Usted no puede borrar un grupo que tiene miembros";
$owl_lang->err_group_exists				= "Existe un grupo con este nombre.";
$owl_lang->err_gzip_not_found			= "gzip no fu&eacute; encontrado ";
$owl_lang->err_login					= "Por Favor Ingresa al sistema para realizar esta acci&oacute;n";
$owl_lang->err_movecancel				= "La operaci&oacute;n mover fue cancelada";
$owl_lang->err_nameempty				= "El nombre de la carpeta no puede estar en blanco";
$owl_lang->err_news_required			= "ERROR: ¡Encabezado de Noticas y Contenido es requerido!";
$owl_lang->err_no_access				= "Usted no tiene acesso a ning&uacute;n archivo selecionado";
$owl_lang->err_no_access_info           = "Possible causes: <br></br>1) You did not click any checkbox in front of a File or Folder<br></br>2) Bulk Delete, Bulk Email, Bulk Checkout do not apply to Folders<br></br>3) You do not have access to any of the files or folders you have selected.";
$owl_lang->err_noemail					= "No tienes permiso para mandar por correo este archivo";
$owl_lang->err_nofileaccess				= "No tienes acceso a este archivo";
$owl_lang->err_nofiledelete				= "No tienes permiso para borrar este archivo";
$owl_lang->err_nofilemod				= "No tienes permiso para modificar este archivo";
$owl_lang->err_nofolderaccess			= "No tienes acceso a esta carpeta";
$owl_lang->err_nofolderdelete			= "No tienes permiso para borrar esta carpeta";
$owl_lang->err_nofoldermod				= "No tienes permiso para modificar esta carpeta";
$owl_lang->err_nosubfolder				= "No tienes permisos para crear carpetas subordinadas aqu&iacute;";
$owl_lang->err_note_title				= "El Titulo es un campo requerido";
$owl_lang->err_note_title_exists		= "Una Nota con este nombre ya existe";
$owl_lang->err_noupload					= "No tienes permiso para agregar archivos a esta carpeta";
$owl_lang->err_pass_missmatch			= "La contrase&ntilde;a nueva y su confirmaci&oacute;n no coinciden";
$owl_lang->err_pass_wrong				= "La contrase&ntilde;a anterior es incorrecta";
$owl_lang->err_pod2html_not_found		= "ERROR: La herramienta pod2html no fu&eacute; encontrada:";
$owl_lang->err_quota					= "No tienes suficente espacio en disco asignado para subir este archivo: ";
$owl_lang->err_quota_avail				= " Disponible.";
$owl_lang->err_quota_exceed				= "Has excedido tu cuota";
$owl_lang->err_quota_needed				= " Necesario ";
$owl_lang->err_req						= "ERROR: Todos los campos son requeridos";
$owl_lang->err_root_delete				= "La carpeta Root (Principal) no puede ser borrada";
$owl_lang->err_sess_notvalid			= "Identificador de sesi&oacute;n no valido";
$owl_lang->err_sess_write				= "Error al escribir la informaci&oacute;n de la sesi&oacute;n en la base de datos";
$owl_lang->err_specialfoldername		= "'backup' es una Carpeta reservada para Owl Por Favor escoga otro Nombre";
$owl_lang->err_tar_not_found			= "tar no fu&eacute; encontrado ";
$owl_lang->err_trash_can_empty			= "La Papelera de Reciclaje esta vacia";
$owl_lang->err_unauth_area				= "No estas autorizado para acceder a este &aacute;rea";
$owl_lang->err_unauthorized				= "Acceso no autorizado";
$owl_lang->err_upload					= "Error al agregar el archivo";
$owl_lang->err_user_exists				= "El usuario ya existe";
$owl_lang->err_cant_del_doc_type		= "No puede borrar hay archivos usando este tipo de documento";
$owl_lang->err_doc_type_name_req		= "Se require el nombre del tipo de documento <BR>";
$owl_lang->err_doc_field_req			= "Falta el campo requerido:";
$owl_lang->err_field_name_req			= "Se requiere el campo nombre <BR>";
$owl_lang->err_field_label_req			= "Se requiere el campo etiqueta <BR>";
$owl_lang->err_field_size_req			= "Se requiere el campo tama&ntilde;o <BR>";
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
$owl_lang->alt_add_comments     = "Agregar un comentario a este archivo";
$owl_lang->alt_btn_add_file     = "Agregar un nuevo archivo";
$owl_lang->alt_btn_add_folder   = "Crear una nueva carpeta";
$owl_lang->alt_add_group        = "Crear este Grupo";
$owl_lang->alt_add_news         = "Agregar un nuevo elemento de Noticias";
$owl_lang->alt_btn_add_note     = "Agregar una nueva nota";
$owl_lang->alt_add_user         = "Crear este usuario";
$owl_lang->alt_btn_add_url      = "Crear un enlace Web";
$owl_lang->alt_cancel           = "Cancle This Action";
$owl_lang->alt_cancel_move      = "Cancelar acci&oacute;n mover";
$owl_lang->alt_change           = "Actualizar este Registro";
$owl_lang->alt_btn_clickhere    = "Presione Aqu&iacute;";
$owl_lang->alt_btn_collapse_view= "Cambiar a vista reducida";
$owl_lang->alt_comments         = "Existen comentarios para este archivo";
$owl_lang->alt_del_comments     = "Borrar este Comentario";
$owl_lang->alt_del_file			= "Borrar Archivo (S/N)";
$owl_lang->alt_del_folder		= "Borrar Carpeta (S/N)";
$owl_lang->alt_del_group        = "Borrar este grupo";
$owl_lang->alt_del_news         = "Borrar esta noticia";
$owl_lang->alt_del_selected     = "Borrar todos los archivos seleccionados";
$owl_lang->alt_del_all          = "Empty Trash";
$owl_lang->alt_rest_selected    = "Restore all Selected Files";
$owl_lang->alt_del_this_folder  = "Borrar carpeta &#8211; ";
$owl_lang->alt_del_user         = "Borrar este usuario";
$owl_lang->alt_edit_group       = "Modificar el grupo seleccionado";
$owl_lang->alt_edit_news        = "Modificar esta noticia";
$owl_lang->alt_edit_user        = "Modificar el usuario seleccionado";
$owl_lang->alt_email			= "Mandar este archivo por correo";
$owl_lang->alt_email_selected   = "Enviar por correo todos los archivos Seleccionados"; 
$owl_lang->alt_btn_expand_view  = "Cambiar a vista expandida";
$owl_lang->alt_admin_flush   	= "Purgar sessiones abandonadas";
$owl_lang->alt_get_file			= "Descargar el Archivo";
$owl_lang->alt_get_folder       = "Download Folder Content";
$owl_lang->alt_have_news        = "Usted tiene elemento(s) de noticia(s)para ver";
$owl_lang->alt_have_no_news     = "No hay elemento(s) de noticia(s) nuevos que ver";
$owl_lang->alt_home_folder      = "Volver a la carpeta inicial";
$owl_lang->alt_set_initial_dir  = "Configurar la carpeta actual como incial";                                                                                                
$owl_lang->alt_site_map         = "Mapa del Sitio";
$owl_lang->alt_lock_file		= "Bloquear el archivo";
$owl_lang->alt_log_clear        = "Borrar todos los sucesos (S/N)";
$owl_lang->alt_log_file			= "Hist&oacute;rico del Archivo";
$owl_lang->alt_log_next         = "Desplegar Registros Siguientes";
$owl_lang->alt_log_prev         = "Desplegar Registros Previos";
$owl_lang->alt_log_top          = "Ir al Primer Registro";
$owl_lang->alt_btn_login        = "Ingresar a Owl Intranet";
$owl_lang->alt_btn_logout       = "Salir de Owl Intranet";
$owl_lang->alt_btn_help         = "Owl Online Help";
$owl_lang->alt_mod_file			= "Modificar las propiedades del archivo";
$owl_lang->alt_mod_folder		= "Modificaci&oacute;n de las propiedades de la carpeta";
$owl_lang->alt_move_file		= "Mover el archivo";
$owl_lang->alt_copy_file        = "Copy File";
$owl_lang->alt_link_file        = "Link This File to Another Directory";
$owl_lang->alt_move_folder		= "Mover la carpeta";
$owl_lang->alt_copy_folder      = "Copy Folder";
$owl_lang->alt_move_selected    = "Mover todos los archivos seleccionados"; 
$owl_lang->alt_admin_groups 	= "Crear un nuevo grupo";
$owl_lang->alt_news_close       = "Cerrar la ventana de noticias";
$owl_lang->alt_news_next        = "Mostrar el pr&oacute;ximo elemento de noticias";
$owl_lang->alt_news_prev        = "Mostrar el elemento previo de noticias";
$owl_lang->alt_news_print       = "Imprimir elemento de Noticias";
$owl_lang->alt_admin_users		= "Crear un nuevo usuario";
$owl_lang->alt_monitor			= "Monitorizar este archivo";
$owl_lang->alt_monitored        = "Detener el monitorizado de este archivo";
$owl_lang->alt_btn_admin		= "Administraci&oacute;n de Owl";
$owl_lang->alt_play_file        = "Reproducir archivo Multimedia";
$owl_lang->alt_recycle          = "Su Papelera de Reciclaje esta vacia";
$owl_lang->alt_recycle_disable  = "La Papelera de Reciclaje esta desabilitada";
$owl_lang->alt_recycle_not_found= "La localizaci&oacute;n de la papelera de reciclaje no fu&eacute; encontrada";
$owl_lang->alt_refresh_filter   = "Inicializando Filtro /Actualize los resultados";
$owl_lang->alt_register         = "Envie su registro";
$owl_lang->alt_btn_browse       = "Regresar a examinar archivos";
$owl_lang->alt_search           = "Iniciar la Busqueda";
$owl_lang->alt_send_email       = "Enviar el email";
$owl_lang->alt_sendfile         = "Mandar archivo";
$owl_lang->alt_toggle_check_box = "Marcar/Desmarcar check boxes";
$owl_lang->alt_unlock_file      = "Desbloquear el archivo";
$owl_lang->alt_upd_file			= "Actualizar el archivo";
$owl_lang->alt_view_comments    = "Agregar / Ver comentarios del archivo";
$owl_lang->alt_view_file		= "Ver el archivo";
$owl_lang->alt_edit_field       = "Editar la definici&oacute;n de este campo";
$owl_lang->alt_del_field        = "Eliminar este campo";
$owl_lang->alt_add_field        = "A&ntilde;adir el campo superior";
$owl_lang->alt_deldoctype       = "Borrar el tipo de documento actual";
$owl_lang->alt_upd_field        = "Actualizar este campo";
$owl_lang->alt_new_doctype      = "Crear nuevo tipo de documento";
$owl_lang->alt_related          = "Find Releated Documents";
$owl_lang->alt_back             = "Return To Previous Screen";
$owl_lang->alt_submit           = "Submit Form";

//********************************************************
// Image Alternate popup Messages END
//********************************************************


//********************************************************
// Owl Logging messages BEGIN
//********************************************************

$owl_lang->log_del_det  	= "El contenido completo fu&eacute; tambi&eacute;n borrado";
$owl_lang->log_detail   	= "Sin detalles adicionales";
$owl_lang->log_file_to  	= "Para: ";
$owl_lang->log_filter_all	= "Todos";
$owl_lang->log_login_det	= "NombreUsuario: ";
$log_file_actions[1]		= "INGRESO";
$log_file_actions[2]		= "INGRESO FALLIDO";
$log_file_actions[3]		= "SALIR";
$log_file_actions[4]		= "ARCHIVO BORRADO";
$log_file_actions[5]		= "ARCHIVO MANDADO";
$log_file_actions[6]		= "ARCHIVO ACTUALIZADO";
$log_file_actions[7]		= "ARCHIVO DESCARGADO";
$log_file_actions[8]		= "EL ARCHIVO CAMBIO";
$log_file_actions[9]		= "ARCHIVO BLOQUEADO";
$log_file_actions[10]		= "ARCHIVO DESBLOQUEADO";
$log_file_actions[11]		= "ARCHIVO ENVIADO";
$log_file_actions[12]		= "ARCHIVO MOVIDO";
$log_file_actions[13]		= "CARPETA CREADA";
$log_file_actions[14]		= "CARPETA BORRADA";
$log_file_actions[15]		= "CARPETA MODIFICADA";
$log_file_actions[16]		= "CARPETA MOVIDA";
$log_file_actions[17]		= "OLVIDO CONSTRASEÑA";
$log_file_actions[18]		= "REG DE USUARIO";
$log_file_actions[19]		= "FICHERO VISUALIZADO";                                                                                                                                                                                        
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

$owl_lang->anonymous		= "(Acesso An&oacute;nimo)";
$owl_lang->repository_list      = "Repository:";
$owl_lang->engine			= "Owl Intranet Engine";
$owl_lang->forgot_pass		= "Olvid&oacute; su password?";
$owl_lang->like_register	= "Se quiere registrar?";
$owl_lang->login			= "Ingresar";
$owl_lang->logindisabled	= "La cuenta ha sido DESHABILITADA, contacte con el administrador del sistema";
$owl_lang->loginfail		= "Error al ingresar";
$owl_lang->password			= "Contrase&ntilde;a";
$owl_lang->successlogout	= "Se ha desconectado correctamente";
$owl_lang->toomanysessions	= "Ha alcanzado el m&aacute;ximo n&uacute;mero de sesiones permitidas, por favor contacte con el administrador del sistema";
$owl_lang->username 		= "Nombre de Usuario";
$owl_lang->version			= "Versi&oacute;n";

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
$owl_lang->actions					= "Acciones";
$owl_lang->del_selected				= "Borrar Seleccionados";
$owl_lang->del_all                      = "Empty Trash";
$owl_lang->rest_selected                = "Restore Selected";
$owl_lang->disk_quota				= "Quota de Disco";
$owl_lang->email_selected			= "Email Seleccionados";
$owl_lang->file						= "Archivo";
$owl_lang->folder_policy			= "Politica actual de la carpeta:";
$owl_lang->current_folder               = "Current Folder:";
$owl_lang->held						= "Bloqueado por";
$owl_lang->last_logged				= "Ultimo en: ";
$owl_lang->current_db                   = "Current Repository:";
$owl_lang->modified					= "Modificado";
$owl_lang->move_selected			= "Mover Seleccionados";
$owl_lang->new_file					= "Nuevo!";
$owl_lang->no_description			= "Descripci&oacute;n No Disponible";                                                                                                 
$owl_lang->page						= "P&aacute;gina:";
$owl_lang->postedby					= "A&ntilde;adida por";
$owl_lang->reallydelete				= "&iquest;Esta seguro que desea borrar?";
$owl_lang->reallydelete_logs		= "Realmente quiere borrar el archivo de sucesos";
$owl_lang->reallydelete_selected	= "Realmente quiere borrar los archivos seleccionados?";
$owl_lang->reallyrestore_selected       = "Really Restore all selected files";
$owl_lang->size						= "Tama&ntilde;o";
$owl_lang->score                        = "Score";
$owl_lang->title					= "T&iacute;tulo";
$owl_lang->doc_number                   = "Doc #";
$owl_lang->tot_files				= "Total:";                                                                                         
$owl_lang->tot_my_checked_out		= "Bloqueado:";
$owl_lang->tot_my_files				= "Mios:";
$owl_lang->tot_my_group				= "Groupo:";
$owl_lang->tot_new_files			= "Nuevos:";
$owl_lang->tot_updated_files		= "Actualizados:";
$owl_lang->tot_monitored                = "Monitored:";
$owl_lang->updated_file				= "Actualizado!";
$owl_lang->user						= "Usuario";
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
$owl_lang->adding_comments	= "Agregar / Ver comentarios: ";
$owl_lang->comments             = "Comment";
$owl_lang->post_comment         = "Post Comment";
$owl_lang->addingfile 		= "Agregar el archivo a ";
$owl_lang->addingfolder 	= "Agregar la carpeta a ";
$owl_lang->attach_file		= "Adjuntar archivo";
$owl_lang->change			= "Cambiar";
$owl_lang->create			= "Crear";
$owl_lang->comments_added	= "Comentarios agregados por: ";
$owl_lang->description		= "Descripci&oacute;n";
$owl_lang->email_body 		= "Mensaje";
$owl_lang->email_cc			= "CC:";
$owl_lang->email_reply_to 	= "Responder a (Reply To):";
$owl_lang->email_subject 	= "Asunto:";
$owl_lang->email_to 		= "Para:";
$owl_lang->disp_mp3			= "MP3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Canci&oacute;n:<BR>Album:<BR>Bitrate&nbsp;-&nbsp;Samplerate:<BR>Duraci&oacute;n:<BR>Genero:<BR>Comentarios:";
$owl_lang->emailing 		= "Enviando Correo";
$owl_lang->keywords 		= "Palabras clave";
$owl_lang->modify_url		= "URL";
$owl_lang->modifying 		= "Modificando ";
$owl_lang->name				= "Nombre"; 
$owl_lang->notify_link		= "Enlace externo a Owl";
$owl_lang->note_content		= "Contenido de la nota";
$owl_lang->ownergroup 		= "Propietario (Grupo)";
$owl_lang->ownership 		= "Propiedad de";
$owl_lang->permissions 		= "Permisos";
$owl_lang->prop_permissions	= "Propagar los permisos a las subcarpetas?";
$owl_lang->prop_perms_files	= "Permisos para propagar a los archivos:";
$owl_lang->policy			= "Politicas";
$owl_lang->pick_select		= "&#8212; Seleccionar un Usuario de Owl &#8212;";
$owl_lang->sendfile 		= "Mandar archivo";
$owl_lang->sendthisfile 	= "Mandar este archivo";
$owl_lang->sendthisurl		= "Enviar esta URL";
$owl_lang->updating			= "Actualizando";
$owl_lang->vermajor 		= "Cambios extensivos";
$owl_lang->verdescription	= "Descripci&oacute;n de cambios (Revisi&oacute;n)";
$owl_lang->verminor 		= "Cambios m&iacute;nimos";
$owl_lang->vertype			= "Tipo de cambio";

//********************************************************
// modify.php  END
//********************************************************


//********************************************************
// register.php  BEGIN
//********************************************************
                                                                                                       
$owl_lang->email		= "Direcci&oacute;n de correo electr&oacute;nico";
$owl_lang->full_name	= "Nombre Completo";
$owl_lang->register		= "Registro del Usuario";
$owl_lang->self_failed	= "Fallido";
$owl_lang->self_passwd	= "Password Enviado a:";
$owl_lang->self_reg_bod	= "Su Password OWL es:";
$owl_lang->self_reg_rset= "Su Password OWL ha sido cambiado a:";
$owl_lang->self_reg_subj= "Su Cuenta OWL";
$owl_lang->send_pass	= "Enviar Password";
$owl_lang->submit		= "Registro";
$owl_lang->thank_you_1	= "Gracias!";
$owl_lang->thank_you_2	= "Un Email ser&aacute; enviado a su direcci&oacute;n de correo <BR> con el NUEVO password para <BR><b>USUARIO:i</b>";

//********************************************************
// register.php  END
//********************************************************


//********************************************************
// move.php  BEGIN
//********************************************************

$owl_lang->cancel_button	= "Cancelar";
$owl_lang->moving			= "Moviendo";
$owl_lang->moving_file          = "Moving file";
$owl_lang->moving_folder        = "Moving Folder";
$owl_lang->copy_file            = "Copying file";
$owl_lang->copy_folder          = "Copying Folder";
$owl_lang->select			= "Por favor seleccione una nueva carpeta:";

//********************************************************
// move.php  END
//********************************************************


//********************************************************
// log.php  BEGIN
//********************************************************

$owl_lang->viewlog			= "Mostrando el historico de ";

//********************************************************
// log.php  END
//********************************************************


//********************************************************
// prefs.php  BEGIN
//********************************************************

$owl_lang->confpassword	= "Confirma la Nueva Contrase&ntilde;a";
$owl_lang->comment_notif= "Notificaci&oacute;n de Comentario";
$owl_lang->email_tool   = "E-Mail Tool";
$owl_lang->last_modified= "Last Modified";
$owl_lang->group		= "Grupo Principal";
$owl_lang->groupmember 	= "Miembro del Grupo";
$owl_lang->newpassword 	= "Nueva Contrase&ntilde;a";
$owl_lang->newsadmin    = "Administrador de Noticias";
$owl_lang->not_member   = "Usted no es miembro de otro grupo";
$owl_lang->notification = "Recibir Notificaciones";
$owl_lang->oldpassword 	= "Contrase&ntilde;a Anterior";
$owl_lang->preference   = "Preferencias";
$owl_lang->saved		= "Cambios Guardados";
$owl_lang->status_no    = "NO";
$owl_lang->status_yes   = "SI";
$owl_lang->userlang 	= "Idioma";

//********************************************************
// prefs.php  END
//********************************************************


//********************************************************
// search.php  BEGIN
//********************************************************

$owl_lang->elapsed_time         = "tiempo transcurrido";
$owl_lang->search				= "Buscar";
$owl_lang->search_any_word      = "Cualquier palabra";
$owl_lang->search_all_word      = "Todas las palabras";
$owl_lang->search_entire_phrase = "Frase completa";
$owl_lang->search_match         = "Comparar:";
$owl_lang->search_currentfolder = "Buscar en la carpeta actual";
$owl_lang->search_for_folders   = "Buscando carpetas";
$owl_lang->search_for_files     = "Buscando archivos";
$owl_lang->search_score         = "Puntuaci&oacute;n de los archivos buscados";
$owl_lang->search_results_for 	= "Resultados de la b&uacute;squeda sobre";
$owl_lang->search_winthindocs   = "Buscar dentro de los archivos (texto, pdf & MS-Word)";
$owl_lang->related_query_empty  = "No metadata associated with document to perform 'Search Related'";
$owl_lang->query_empty			= "Cadena de b&uacute;squeda vacia";

//********************************************************
// search.php  END
//********************************************************


//********************************************************
// view.php  BEGIN
//********************************************************

$owl_lang->viewing				= "Mostrando ";

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
$owl_lang->add						= "Agregar";
$owl_lang->anonymous_account		= "Cuenta de Acceso An&oacute;nima:";                                                                                                                      
$owl_lang->buttonstyle				= "Estilo de los botones";
$owl_lang->deletegroup				= "Borrar Grupo";
$owl_lang->deleteuser				= "Borrar Usuario";
$owl_lang->disableuser				= "Deshabilitar usuario";
$owl_lang->disable_recs_per_page	= "Habilitar la vista restringida DESHABILITA la visualizacion limitada de entradas por p&aacute;gina!";
$owl_lang->file_admin_group			= "Grupo Administrador de Archivos / Examinar:";
$owl_lang->flushed					= "La tabla de las sessiones a sido purgada, el usuario puede volver a ingresar de nuevo.<BR>";
$owl_lang->groups					= "Grupos";
$owl_lang->hide_bulk_buttons		= "Ocultar botones de selecci&oacute;n m&uacute;ltiple:";
// Edit HTML Properties Messages
$owl_lang->ht_tbl_border_sz			= "Tama&ntilde;o borde de la tabla:";
$owl_lang->ht_tbl_hd_bg				= "Fondo de la cabecera:";
$owl_lang->ht_tbl_cell_bg_cl		= "Color de fondo de las celdas de la tabla:";
$owl_lang->ht_tbl_cell_bg_al		= "Color de fondo alternativo de las celdas de la tabla:";
$owl_lang->ht_expand_width			= "Anchura de la vista expandida:";
$owl_lang->ht_collapse_width		= "Anchura de la vista contraida:";
$owl_lang->ht_bd_bg_image			= "Ruta para Imagen de fondo (body):";
$owl_lang->ht_bd_txt_cl				= "Color del texto del cuerpo:";
$owl_lang->ht_bd_lnk_cl				= "Color de los links (body):";
$owl_lang->ht_bd_vlnk_cl			= "Color de los links vistados (body):";
// Edit Prefs Properties Messages
$owl_lang->home_dir					= "Carpeta inicial del usuario";
$owl_lang->initial_dir                  = "User's Initial Directory";
$owl_lang->maxsessions				= "M&aacute;ximo Num. de sesiones";
$owl_lang->noprefaccess				= "Deshabilitar Preferencias";
$owl_lang->owl_anon_full                = "Full Access";
$owl_lang->owl_anon_ro					= "Asignar solo lectura a usuarios an&oacute;nimos:";
$owl_lang->owl_anon_download            = "Download Only";
$owl_lang->anonymous_access             = "Set Anonymous Access";
$owl_lang->owl_dbdump_path				= "Ruta para el volcado de la BD (copia de seguridad):";
$owl_lang->owl_def_file_group_owner		= "Grupo por defecto:";
$owl_lang->owl_def_file_meta			= "Meta Data de los ficheros por defecto:";
$owl_lang->owl_def_file_owner			= "Propietario por defecto:";
$owl_lang->owl_def_file_perm			= "Pol&iacute;tica por defecto para los archivos nuevos:";
$owl_lang->owl_def_file_security		= "Securidad de los archivos por defecto:";
$owl_lang->owl_def_file_title			= "Titulo del Fichero por defecto (Nada para usar el nombre del archivo):";
$owl_lang->owl_def_fold_group_owner		= "Grupo de las carpetas por defecto:";
$owl_lang->owl_def_fold_owner			= "Propietario de las carpetas por defecto:";
$owl_lang->owl_def_fold_sec				= "Seguridad de las carpetas por defecto:";
$owl_lang->owl_def_folder_perm			= "Pol&iacute;tica por defecto para las carpetas nuevas:";
$owl_lang->owl_default_tmpdir			= "Ruta del directorio para archivos temporales: ";
$owl_lang->owl_email_from				= "Direcci&oacute;n Email del From / SMTP Auth Login:";
$owl_lang->owl_email_fromname			= "Nombre Completo:";
$owl_lang->owl_email_replyto			= "Direccion Email del Reply To:";
$owl_lang->owl_email_server				= "Direccion Email del server (se muestra en los avisos emitidos):";
$owl_lang->owl_email_smtp				= "Envio de correos usando el ejecutable SMTP";
$owl_lang->owl_email_smtp_auth		= "Usar SMTP Auth";
$owl_lang->owl_email_smtp_auth_login    = "SMTP Auth Login:";
$owl_lang->owl_email_smtp_auth_passwd	= "Contrase&ntilde;a SMTP Auth";
$owl_lang->owl_email_subject_pref	= "Prefijo para el campo Tema de Email:";
$owl_lang->owl_fogotpass		= "Mostrar enlace de recordar contrase&ntilde;a:";
$owl_lang->owl_group_user		= "Usuarios que son miembros de este grupo";
$owl_lang->owl_gzip_path		= "Ruta gzip:";
$owl_lang->owl_hidebackup		= "Ocultar el directorio de respaldo:";
$owl_lang->owl_log_file			= "Actividades de Archivo de Sucesos:";
$owl_lang->owl_log_login_act		= "Actividades de Sucesos de Login/Logout:";
$owl_lang->owl_log_rec_page		= "# de Sucesos por P&aacute;gina de Registro:";
$owl_lang->owl_logging			= "Habilitar Sucesos:";
$owl_lang->owl_logo			= "Logo para p&aacute;gina principal ([Lenguaje]/graphics):";
$owl_lang->owl_lookAtHD			= "Deshabilitar buscar en local (disco duro):";
$owl_lang->owl_lookAtHDDel		= "Eliminar archivos borrados de la DB:";
$owl_lang->hide_folder_doc_count        = "Hide Folder File Type Count";
$owl_lang->hide_folder_size             = "Hide Folder Content Size";
$owl_lang->old_action_icons             = "Use pre Owl 0.80 Action Icons";
$owl_lang->search_result_folders        = "Include Folders in Search Results";
$owl_lang->restore_file_prefix          = "String Prefixed to Restored Files";
$owl_lang->owl_max_filesize		= "Tama&ntilde;o maximo de los ficheros subidos:";
$owl_lang->owl_owl_expand		= "Vista por defecto del arbol de archivos(Expandida):";
$owl_lang->owl_owl_timeout		= "Timeout de la sesi&oacute;n en segundos:";
$owl_lang->virus_path                   = "Virus Checking Software Path<br />Example: '/usr/bin/clamscan --quiet' <br />&#8211; Blank for Disabled:";
$owl_lang->owl_pdftotext_path		= "Mantener indice de busqueda para <BR>Archivos PDF y texto <BR>&#8211; en Blanco para deshabilitar:";
$owl_lang->owl_wordtotext_path		= "Archivos MS-WORD <BR>&#8211; en Blanco para deshabilitar:";
$owl_lang->owl_pod2html_path		= "Perl 5.8.0 o superior requerido<BR>Ruta para pod2html:";
$owl_lang->owl_restrict_view		= "Habilitar la visualizaci&oacute;n restringida:";
$owl_lang->owl_self_reg			= "Habilitar autoregistro:";
$owl_lang->owl_self_reg_hd		= "PREFERENCIAS PARA USUARIOS AUTOREGISTRADOS";
$owl_lang->owl_tar_path			= "Ruta tar:";
$owl_lang->owl_title_custom             = "CUSTOMIZE BROWSER COLUMNS";
$owl_lang->owl_title_custom_search      = "CUSTOMIZE SEARCH RESULTS";
$owl_lang->owl_title_browser		= "PREFERENCIAS DEL EXAMINADOR DE ARCHIVOS";
$owl_lang->owl_title_defaults		= "VALORES POR DEFECTO";
$owl_lang->owl_title_email		= "PREFERENCIAS DEL CORREO";
$owl_lang->owl_title_HD			= "PREFERENCIAS BUSCAR EN LOCAL (HD) PARA NUEVOS FICHEROS"; 
$owl_lang->owl_title_logging		= "SETTINGS DE REGISTRO";
$owl_lang->owl_title_other		= "OTRAS PREFERENCIAS";
$owl_lang->owl_title_tools		= "Utilidades para la copia de seguridad de la BD/GZIP";
$owl_lang->owl_unzip_path		= "Ruta unzip:";
$owl_lang->owl_version_control		= "Habilitar el control de revisiones:";
$owl_lang->quota			= "Cuota 0=Deshabilitado";
$owl_lang->reallydeluser		= "Este usuario es propietario de %numfiles% archivo(s) y %numfolders% carpetas(s). Estos archivos(s) y carpetas(s) estan huerfanos. Is it Still Ok to Delete?";
$owl_lang->recs_per_page		= "Numero de entradas a mostrar por p&aacute;gina (0 = Deshabilitado):";
$owl_lang->remember_me_title		= "PREFERENCIAS RECORDAR INGRESO";
$owl_lang->remember_me			= "Mostrar el enlace de recordar usuario";
$owl_lang->remember_timeout		= "Tiempo de vida de la cookie en dias";
$owl_lang->remember_me_checkbox		= "Recu&eacute;rdame";
$owl_lang->recycle_title		= "PREFERENCIAS DE LA PAPELERA DE RECICLAJE";
$owl_lang->recycle_enabled		= "Habilitar colecci&oacute;n en papelera:";
$owl_lang->recycle_location		= "Localizaci&oacute;n de la papelera de reciclaje:";
$owl_lang->show_panel_title             = "Display Status Panel:";
$owl_lang->show_search_title            = "Display Search Bar:";
$owl_lang->show_pref_title              = "Display Pref/logout Bar:";
$owl_lang->show_bulk_title              = "Display Bulk Buttons:";
$owl_lang->show_action_title            = "Display action Buttons:";
$owl_lang->show_folder_title            = "Display Folder Tools:";
$owl_lang->show_panel                   = "Show";
$owl_lang->hide_panel                   = "Hide";
$owl_lang->status_bar_both			= "Ambos";
$owl_lang->status_bar_bottom		= "Abajo";
$owl_lang->status_bar_location		= "Mostrar la barra de estado en:";
$owl_lang->status_bar_top			= "Arriba";
$owl_lang->status_bar_not               = "Do Not Display";
$owl_lang->use_popup				= "Usar ventana emergente para mostrar noticias:";
$owl_lang->users					= "Usuarios";
$owl_lang->header_user_admin            = "User Administration";
$owl_lang->header_group_admin           = "Group Administration";
$owl_lang->header_sitefeatures_settings           = "Site Features and Settings";

//********************************************************
// admin/index.php  END
//********************************************************


//********************************************************
// admin/log.php  BEGIN
//********************************************************

$owl_lang->owl_log_filter		= "Filtros";
$owl_lang->owl_log_hd_action	= "Acci&oacute;n";
$owl_lang->owl_log_hd_agent		= "Agente";
$owl_lang->owl_log_hd_dt_tm		= "Fecha Tiempo";
$owl_lang->owl_log_hd_dtls		= "Detalles";
$owl_lang->owl_log_hd_file		= "Archivo";
$owl_lang->owl_log_hd_fld_path	= "Ruta de Carpetas";
$owl_lang->owl_log_hd_ip     	= "Direcci&oacute;n IP";
$owl_lang->owl_log_hd_user   	= "Usuario";
$owl_lang->owl_log_hide      	= "Ocultar: ";
$owl_lang->owl_log_no_rec    	= " NO SE ENCONTRARON SUCESOS ";
$owl_lang->owl_log_viewer    	= "Visor de Sucesos";

//********************************************************
// admin/log.php  END
//********************************************************


//********************************************************
// admin/recycle.php  BEGIN
//********************************************************

$owl_lang->empty_trash          = "Vaciar Papelera";
$owl_lang->really_empty_trash   = "&iquest;Realmente quiere vaciar la papelera de reciclaje?";
$owl_lang->recycle_bin_admin    = "Administraci&oacute;n de papelera de reciclaje";

//********************************************************
// admin/recycle.php  END
//********************************************************


//********************************************************
// lib/owl.lib.php  BEGIN
//********************************************************

$owl_lang->file_size_byte               = "b";
$owl_lang->file_size_gigabyte           = "gb";
$owl_lang->file_size_kilobyte           = "kb";
$owl_lang->file_size_megabyte           = "mb";
$owl_lang->notif_subject_new			= "Nuevo archivo en OWL Intranet";
$owl_lang->notif_subject_upd			= "Un archivo de OWL Intranet fue actualizado";
$owl_lang->notif_subject_monitor		= "El archivo en OWL Intranet que esta monitorizando ha sido actualizado";
$owl_lang->notif_subject_comment        = "Un archivo de OWL Intranet tiene un nuevo comentario";
$owl_lang->notif_comment_1              = "Comentado en";
$owl_lang->notif_comment_2              = "Comentario:";
$owl_lang->notif_msg					= "ESTE ES UN MENSAJE GENERADO AUTOMATICAMENTE DESDE OWL Intranet<BR><BR>Haz Click en el enlace para ver el archivo nuevo/actualizado.<BR><BR>";
$owl_lang->notif_msg_link                               = "ESTE ES UN MENSAJE GENERADO AUTOMATICAMENTE DESDE OWL Intranet<BR><BR>Contiene un enlace a un archivo nuevo/actualizado.<BR><BR>";
$owl_lang->notif_msg_alt_link                           = "ESTE ES UN MENSAJE GENERADO AUTOMATICAMENTE DESDE OWL Intranet\n\nContiene un enlace a un archivo nuevo/actualizado.\n\n";
$owl_lang->notif_msg_alt				= "ESTE ES UN MENSAJE GENERADO AUTOMATICAMENTE DESDE OWL Intranet\n\nHaz Click en el enlace para ver el archivo nuevo/actualizado.\n\n";
$owl_lang->notif_salutation             = "Estimado";
$owl_lang->notif_user                   = "Created/Update by:";
$owl_lang->owl_path                     = "Ruta del archivo: ";
$owl_lang->sessinuse					= "La sesi&oacute;n esta activa en otra maquina, acceso denegado";
$owl_lang->invalidsess					= "Identificador de sesi&oacute;n invalido, por favor intente acceder nuevamente en la p&aacute;gina principal<BR>";
$owl_lang->sesstimeout					= "S&uacute; sesi&oacute;n ha expirado, por favor acceda nuevamente<BR>";
$owl_lang->everyoneread					= "Cualquiera puede leer/descargar";
$owl_lang->everyonewrite				= "Cualquiera puede leer/escribir/descargar";
$owl_lang->everyonewrite_nod			= "Cualquiera puede leer/escribir/descargar, NO BORRAR";
$owl_lang->groupread					= "T&uacute; grupo puede leer/descargar";
$owl_lang->groupwrite					= "T&uacute; grupo puede leer/escribir/descargar";
$owl_lang->groupwrite_nod				= "T&uacute; grupo puede leer/escribir/descargar, NO BORRAR";
$owl_lang->onlyyou						= "Solamente t&uacute; puedes leer/escribir/descargar";
$owl_lang->donothing					= "No hacer nada &#8211; Dejar los permisos del archivo como est&aacute;n";
$owl_lang->groupwrite_worldread			= "El grupo seleccionado puede leer/escribir/descargar y cualquiera puede leer";
$owl_lang->groupwrite_worldread_nod		= "El grupo seleccionado leer/escribir/descargar (NO BORRAR) y cualquiera puede leer";
$owl_lang->ggroupwrite_worldread		= "El grupo seleccionado puede agregar archivos y borrar esta carpeta y cualquiera puede ver sus contenidos";
$owl_lang->ggroupwrite_worldread_nod	= "El grupo seleccionado puede agregar archivos a esta carpeta y cualquiera puede ver sus contenidos, NO BORRAR";
$owl_lang->everyoneread_ad				= "Cualquiera puede leer/descargar";
$owl_lang->everyonewrite_ad				= "Cualquiera puede leer/escribir/descargar";
$owl_lang->everyonewrite_ad_nod			= "Cualquiera puede leer/escribir/descargar, NO BORRAR";
$owl_lang->groupread_ad					= "T&uacute; grupo puede leer/descargar";
$owl_lang->groupwrite_ad				= "T&uacute; grupo puede leer/escribir/descargar";
$owl_lang->groupwrite_ad_nod			= "T&uacute; grupo puede leer/escribir/descargar, NO BORRAR";
$owl_lang->onlyyou_ad					= "Solamente t&uacute; puedes leer/escribir/descargar";
$owl_lang->groupwrite_worldread_ad		= "El grupo seleccionado puede leer/escribir/descargar y cualquiera puede leer";
$owl_lang->groupwrite_worldread_ad_nod	= "El grupo seleccionado puede leer/escribir/descargar (NO BORRAR) y cualquiera puede leer";
$owl_lang->ggroupwrite_worldread_ad 	= "El grupo seleccionado puede agregar y borrar archivos de esta carpeta y cualquiera puede ver su contenido";
$owl_lang->ggroupwrite_worldread_ad_nod	= "El grupo seleccionado puede agregar y borrar archivos de esta carpeta y cualquiera puede ver su contenido, NO BORRAR";
$owl_lang->geveryoneread				= "Cualquiera puede leer esta carpeta";
$owl_lang->geveryonewrite				= "Cualquiera puede agregar archivos y borrar esta carpeta";
$owl_lang->geveryonewrite_nod			= "Cualquiera puede agregar archivos a esta carpeta";
$owl_lang->ggroupread					= "T&uacute; grupo puede leer esta carpeta";
$owl_lang->ggroupwrite					= "T&uacute; grupo puede agregar archivos y borrar esta carpeta";
$owl_lang->ggroupwrite_nod				= "T&uacute; grupo puede agregar archivos a esta carpeta";
$owl_lang->gonlyyou						= "Solamente t&uacute; puedes agregar archivos y borrar esta carpeta";
$owl_lang->geveryoneread_ad				= "Cualquiera puede leer esta carpeta";
$owl_lang->geveryonewrite_ad			= "Cualquiera puede agregar archivos y borrar esta carpeta";
$owl_lang->geveryonewrite_ad_nod		= "Cualquiera puede agregar archivos a esta carpeta";
$owl_lang->ggroupread_ad				= "El grupo seleccionado puede leer esta carpeta";
$owl_lang->ggroupwrite_ad				= "El grupo seleccionado puede agregar archivos y borrar esta carpeta";
$owl_lang->ggroupwrite_ad_nod			= "El grupo seleccionado puede agregar archivos a esta carpeta";
$owl_lang->gonlyyou_ad					= "Solamente t&uacute; puedes agregar archivos y borrar esta carpeta";
$owl_lang->orphaned						= "&#8211; No tiene propietario &#8211;";
$owl_lang->virus_infected               = "VIRUS INFECTED FILE";
$owl_lang->virus_return_val             = "Virus Program Return value:";

//********************************************************
// lib/owl.lib.php  END
//********************************************************


//********************************************************
// HREF TITLE messages  BEGIN
//********************************************************

$owl_lang->title_browse_folder          = "Examinar esta Carpeta";
$owl_lang->title_browse_site            = "Examinar este URL";
$owl_lang->title_download_view          = "Descargar / Ver este archivo";
$owl_lang->title_edit_prefs             = "Ver / Modificar preferencias de usuario";
$owl_lang->title_return_folder          = "Regresar a";
$owl_lang->title_sort                   = "Ordenar por";
$owl_lang->title_view_new               = "Ver lista de archivos nuevos desde mi &uacute;ltima visita";
$owl_lang->title_view_updated           = "Ver lista de archivos actualizados desde mi &uacute;ltima visita";
$owl_lang->title_view_my                = "Ver lista de Mis Archivos";

//********************************************************
// HREF TITLE messages  END
//********************************************************


//********************************************************
// admin/news.php and newsread.php BEGIN
//********************************************************

$owl_lang->news_title                   = "Administraci&oacute;n de Noticias";
$owl_lang->news_hd                      = "Noticias";
$owl_lang->news_hd_created              = "Creado en";
$owl_lang->news_hd_expires              = "Vence en";
$owl_lang->news_hd_audience             = "Audiencia objetivo";
$owl_lang->news_heading                 = "Encabezado de noticias";
$owl_lang->news_content                 = "Contenido";
$owl_lang->news_posted_date             = "Noticias publicadas:";
$owl_lang->news_read                    = "Leer";

//********************************************************
// admin/news.php and newsread.php  END
//********************************************************


//********************************************************
// DEBUG MESSAGES BEGIN
//********************************************************

$owl_lang->debug_tmp_not_exists         = "DEBUG: El directorio temporal OWL: $default->owl_tmpdir no existe.";
$owl_lang->debug_tmp_not_writeable      = "DEBUG: El directorio temporal OWL: $default->owl_tmpdir no es escribible.";
$owl_lang->debug_doc_not_exists         = "DEBUG: El directorio de documentos de OWL: " .$default->owl_fs_root . "/" . fid_to_name(1) ." no existe.";
$owl_lang->debug_doc_not_writeable      = "DEBUG: El directorio de documentos de OWL: " .$default->owl_fs_root . "/" . fid_to_name(1) ." no tiene permisos para que el servidor Web pueda escribir.";
$owl_lang->debug_webserver_no_access    = "DEBUG: The webserver does not have read access to: <br />'$default->owl_fs_root/$filename'. <br />Please fix the permissions and try again";
$owl_lang->debug_file_not_exist         = "DEBUG: The required file '$default->owl_fs_root/$filename' does not exists.<br /> OR<br />The path specified by \$default->owl_fs_root in config/owl.php is wrong.";

//********************************************************
// DEBUG MESSAGES END
//********************************************************


//********************************************************
// admin/stats.php BEGIN
//********************************************************

$owl_lang->owl_stats_viewer		= "Visor de Estad&iacute;sticas";
$owl_lang->stats_files          = "N&uacute;mero de archivos por usuario";
$owl_lang->stats_folders        = "N&uacute;mero de carpetas por usuario";
$owl_lang->stats_top            = "20 descargas mas populares";
$owl_lang->stats_users          = "USER Signon (Login / Failure / Logout)";
$owl_lang->stats_users_loggedin = "Currently Logged In";
$owl_lang->stats_information    = "Sucesos y archivo de sucesos deben ser habilitados para poder ver estas estad&iacute;sticas";

//********************************************************
// admin/stats.php END
//********************************************************

//********************************************************
// admin/doctype.php BEGIN
//********************************************************

$owl_lang->document_type        = "Tipo de Documento";
$owl_lang->document_type_name   = "Nombre tipo de documento";
$owl_lang->doc_field_name       = "Campo Nombre";
$owl_lang->doc_field_pos        = "Campo Pos";
$owl_lang->doc_field_label      = "Campo Etiqueta (Por Idioma)";
$owl_lang->doc_field_size       = "Tama&ntilde;o del Campo";
$owl_lang->doc_field_searchable = "Permite Busqueda?";
$owl_lang->doc_field_required   = "Requerido?";
$owl_lang->doc_new_doc_type     = "&#8212; A&ntilde;adir un nuevo tipo de documento &#8212;";
$owl_lang->doc_specific         = "CAMPOS ESPECIFICOS DEL DOCUMENTO:";
$owl_lang->doc_administration   = "Administracion del Tipo de Documento";

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
