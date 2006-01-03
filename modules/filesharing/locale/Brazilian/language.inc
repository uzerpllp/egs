<?php

/*

  Arquivo: Portuguese/language.inc
  Author: Douglas Hipocreme <douglas@hipocreme.com.br>
  Date: 2005/03/02

  Last modified by: Douglas Hipocreme (2005/03/02)

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
        $owl_lang->localized_date_format = "d.m.Y \Ã \\s H:i";
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

$owl_lang->err_select_reviewer          = "Por favor selecione pelo menos um usu&aacute;rio para revisar o documento";
$owl_lang->err_adding_comments		= "N&atilde;o &eacute; permitido a Voc&ecirc; adicionar coment&aacute;rios a este arquivo";
$owl_lang->err_comment_empty            = "Coment&aacute;rio n&atilde;o pode ser vazio";
$owl_lang->err_backup_file   		= "Erro ao realizar backup do arquivo";
$owl_lang->err_backup_folder_create 	= "Erro na criacao de pasta de backup";
$owl_lang->err_bad_url                  = "Favor informar uma URL v&aacute;lida";
$owl_lang->err_bad_version_1            = "Owl Intranet requer como vers&atilde;o m&iacute;nima de PHP";
$owl_lang->err_bad_version_2            = "Voc&ecirc; est&aacute; usando a Vers&atilde;o";
$owl_lang->err_bad_version_3            = "Instale uma nova vers&atilde;o de PHP e tente de novo";
$owl_lang->err_email         		= "A mensagem n&atilde;o p&ocirc;de ser enviada" ;
$owl_lang->err_email_required   	= "O campo de E-Mail &eacute; requerido";
$owl_lang->err_fexist1 			= "<b>O arquivo existe:</b>";
$owl_lang->err_fexist2 			= "J&aacute; existe um arquivo com este nome<i>";
$owl_lang->err_fexist3 			= "</i> neste diret&oacute;rio.";
$owl_lang->err_file_exists       	= "O arquivo que voc&ecirc; est&aacute; tentando enviar j&aacute; existe";
$owl_lang->err_fileexists    		= "O envio foi Canceledo<BR>Um arquivo com o mesmo nome j&aacute; existe.";
$owl_lang->err_file_lock     		= "Voc&ecirc; n&atilde;o pode checar este arquivo, ele atualmente pertence a";
$owl_lang->err_update_file_lock         = "Voc&ecirc; n&atilde;o pode atualizar o arquivo, ele est&aacute; bloqueado por ";
$owl_lang->err_filemove_exist   	= "O Arquivo cujo nome voc&ecirc; esta tentando mudar ja existe";
$owl_lang->err_file_not_exist   	= "Arquivo n&atilde;o existe no sistema";
$owl_lang->err_file_too_big     	= "php.ini upload_max_filesize exceeded e/ou<BR>Foi Excedido o Tamanho m&aacute;ximo de envio de Arquivo Owl";
$owl_lang->err_file_update   		= "Requer o mesmo nome de arquivo, tente novamente utilizando o mesmo nome";
$owl_lang->err_folder_exist  		= "Esta pasta j&aacute; existe";
$owl_lang->err_folder_create 		= "Erro na cria&ccedil;&atilde;o da Pasta";
$owl_lang->err_folderexists     	= "A A&ccedil;&atilde;o de Renomear foi Cancelada<BR> Uma Pasta com o mesmo nome j&aacute; existe.";
$owl_lang->err_general       		= "Um erro foi encontrado";
$owl_lang->err_group_delete      	= "Voc&ecirc; n&atilde;o pode deletar um grupo que cont&eacute;m membros";
$owl_lang->err_group_exists      	= "J&aacute; existe um grupo com este nome.";
$owl_lang->err_gzip_not_found   	= "gzip n&atilde;o foi encontrado em ";
$owl_lang->err_login			= "Por favor logue-se para realizar esta tarefa";
$owl_lang->err_movecancel    		= "Movimentac&atilde;o Cancelada<BR>";
$owl_lang->err_nameempty     		= "A pasta n&atilde;o pode estar vazia";
$owl_lang->err_news_required     	= "ERRO: Titulo e conteudo da noticia s&atilde;o obrigat&oacute;rios!";
$owl_lang->err_no_access       		= "Voc&ecirc; n&atilde;o tem acesso a nenhum dos arquivos selecionados";
$owl_lang->err_no_access_info           = "Causa Possivel: <br></br>1) Voc&ecirc; n&atilde;o selecionou nenhum arquivo ou pasta <br></br>2) Bot&otilde;es Excluir Selecionados, Email Selecionados, Bloquear Selecionados n&atilde;o se aplicam a Pastas<br></br>3) Voc&ecirc; n&atilde;o tem acesso aos arquivos ou pastas selecionadas.";
$owl_lang->err_noemail           	= "Voc&ecirc; n&atilde;o tem acesso para enviar este Arquivo por email";
$owl_lang->err_nofileaccess		= "Voc&ecirc; n&atilde;o tem acesso a este arquivo";
$owl_lang->err_nofiledelete      	= "Voc&ecirc; n&atilde;o pode apagar este arquivo";
$owl_lang->err_nofilemod         	= "Voc&ecirc; n&atilde;o pode modificar este arquivo";
$owl_lang->err_nofolderaccess    	= "Voc&ecirc; n&atilde;o tem acesso a esta pasta";
$owl_lang->err_nofolderdelete  		= "Voc&ecirc; n&atilde;o pode apagar esta pasta";
$owl_lang->err_nofoldermod      	= "Voc&ecirc; n&atilde;o pode modificar esta pasta";
$owl_lang->err_nosubfolder       	= "Voc&ecirc; n&atilde;o pode criar sub-pastas aqui";
$owl_lang->err_note_title        	= "O T&iacute;tulo &eacute; um campo requerido";
$owl_lang->err_note_title_exists 	= "Uma Anota&ccedil;&atilde;o com este nome j&aacute; existe";
$owl_lang->err_noupload          	= "Voc&ecirc; n&atilde;o pode enviar arquivos para esta pasta";
$owl_lang->err_pass_missmatch		= "Senhas n&atilde;o s&atilde;o iguais";
$owl_lang->err_pass_wrong    		= "Senha antiga esta errada";
$owl_lang->err_pod2html_not_found       = "ERRO: A ferramenta pod2html n&atilde;o foi encontrada:";
$owl_lang->err_quota         		= "Insuficiente espa&ccedil;o em disco";
$owl_lang->err_quota_needed  		= " para gravar este arquivo ";
$owl_lang->err_quota_avail   		= "N&atilde;o h&aacute; quota dispon&iacute;vel" ;
$owl_lang->err_quota_exceed  		= "Voc&ecirc; excedeu sua quota";
$owl_lang->err_req      		= "ERRO: Todos os campos s&atilde;o necess&aacute;rios";
$owl_lang->err_root_delete      	= "O Arquivo Raiz n&atilde;o pode ser deletado";
$owl_lang->err_sess_notvalid 		= "Sess&atilde;o n&atilde;o &eacute; v&aacute;lida";
$owl_lang->err_sess_write    		= "Erro escrevendo sess&atilde;o no banco de dados";
$owl_lang->err_specialfoldername 	= "'backup' &eacute; um nome de pasta reservada do sistema, por favor escolha outro nome";
$owl_lang->err_tar_not_found    	= "tar  n&atilde;o foi encontrado em ";
$owl_lang->err_trash_can_empty   	= "A lata de Lixo est&aacute; vazia";
$owl_lang->err_unauth_area   		= "Voc&ecirc; n&atilde;o esta autorizado a utilizar esta &aacute;rea";
$owl_lang->err_unauthorized  		= "N&atilde;o autorizado";
$owl_lang->err_upload        		= "Erro de envio";
$owl_lang->err_user_exists   		= "Nome do usuario n&atilde;o existe";
$owl_lang->err_cant_del_doc_type        = "Imposs&iacute;vel Excluir, existem arquivos usando este tipo de Documento";
$owl_lang->err_doc_type_name_req        = "Nome do Tipo de Documento é obrigat&oacute;rio <BR>";
$owl_lang->err_field_name_req           = "Nome do Campo é obrigat&oacute;rio <BR>";
$owl_lang->err_doc_field_req            = "Faltando campo obrigat&oacute;rio:";
$owl_lang->err_field_label_req          = "Descri&ccedil;&atilde;o do campo é obrigat&oacute;ria <BR>";
$owl_lang->err_field_size_req           = "Tamanho do Campo é obrigat&oacute;rio <BR>";
$owl_lang->err_forbidden_file           = "Tipo de Arquivo Desconhecido";
$owl_lang->err_file_indexing            = "Falha na cria&ccedil;&atilde;o do arquivo tempor&aacute;rio 'TEXT' ";
$owl_lang->err_not_zip                  = "N&atilde;o é um arquivo ZIP v&aacute;lido";
$owl_lang->err_database                 = "Database error";
$owl_lang->err_sql                      = "SQL error";


//********************************************************
// Error Messages END
//********************************************************

$owl_lang->btn_go_top      = "V&aacute; para cima";
$owl_lang->btn_go_bottom      = "V&aacute; para Baixo";
$owl_lang->btn_admin      = "Admin";
$owl_lang->btn_logout     = "Sair";
$owl_lang->btn_browse     = "Explorar";
$owl_lang->btn_mail_tool     = "E-Mail";
$owl_lang->btn_help     = "Ajuda";
$owl_lang->btn_add_field          = "Adicionar Campo";
$owl_lang->btn_add_url          = "Adicionar URL";
$owl_lang->btn_create          = "Criar";
$owl_lang->btn_register          = "Registrar";
$owl_lang->btn_add_file          = "Adicionar Docs";
$owl_lang->btn_add_zip           = "Adicionar Pacote";
$owl_lang->btn_admin_users          = "Novo Usu&aacute;rio";
$owl_lang->btn_admin_groups          = "Novo Grupo";
$owl_lang->btn_deldoctype          = "Excluir Tipo de Doc";
$owl_lang->btn_expand_view          = "Vis&atilde;o Expandida";
$owl_lang->btn_add_folder          = "Criar Pasta";
$owl_lang->btn_cancel          = "Cancelar";
$owl_lang->btn_login          = "Entrar";
$owl_lang->btn_send_email          = "Enviar E-Mail";
$owl_lang->btn_admin_news          = "Admin. de Not&iacute;cias";
$owl_lang->btn_add_news          = "Adicionar Not&iacute;cias";
$owl_lang->btn_clickhere          = "Clique Aqui";
$owl_lang->btn_edit_group          = "Editar Grupo";
$owl_lang->btn_add_note          = "Adicionar Nota";
$owl_lang->btn_collapse_view          = "Vis&atilde;o Reduzida";
$owl_lang->btn_edit_user          = "Editar Usu&aacute;rio";
$owl_lang->btn_bulk_move          = "Mover Selecionados";
$owl_lang->btn_bulk_delete         = "Excluir Selecionados";
$owl_lang->btn_bulk_checkout       = "Bloquear Selecionados";
$owl_lang->btn_bulk_email          = "E-Mail Selecionados";
$owl_lang->btn_bulk_download          = "Download Selecionados";
$owl_lang->btn_reset          = "Limpar";
$owl_lang->btn_submit          = "Enviar";
$owl_lang->btn_back          = "Voltar";
$owl_lang->btn_download_bulk_package    = "Baixar pacote de Arquivos";

//********************************************************
// Image Alternate popup Messages BEGIN
//********************************************************


$owl_lang->alt_tool_status_red  = "Path is Incorrect AND/OR is not Executable";$owl_lang->alt_tool_status_green= "Tool is Active";
$owl_lang->alt_my_approval      = "Documento(s) Esperando minha Aprova&ccedil;&atilde;o";
$owl_lang->alt_pending_approval = "Documento(s) com Aprova&ccedil;&atilde;o Pendente";
$owl_lang->alt_email_reminder   = "Lembrete por Email";
$owl_lang->alt_approve_file     = "Aprove este Documento";
$owl_lang->alt_reject_file      = "Rejeite este Documento";
$owl_lang->alt_publish_file     = "Torne este Documento P&uacute;blico";
$owl_lang->alt_go_top           = "Ir para o topo da pagina";
$owl_lang->alt_go_bottom           = "Ir para o fim da pagina";
$owl_lang->alt_btn_add_zip           = "Adicionar um pacote de arquivos";
$owl_lang->alt_btn_mail_tool     = "Ferramenta de E-Mail";
$owl_lang->alt_btn_bulk_move          = "Mover pastas e arquivos selecionados";
$owl_lang->alt_btn_bulk_delete          = "Excluir arquivos selecionados";
$owl_lang->alt_btn_bulk_checkout          = "Bloquear Selecionados";
$owl_lang->alt_btn_bulk_email          = "E-Mail de arquivos selecionados";
$owl_lang->alt_btn_bulk_download          = "Baixar arquivos selecionados";
$owl_lang->alt_reset_form       = "Limpar Formul&aacute;rio";
$owl_lang->alt_add_comments     = "Adicionar um coment&aacute;rio para este Arquivo";
$owl_lang->alt_btn_add_file     = "Enviar um Novo Arquivo";
$owl_lang->alt_btn_add_folder   = "Criar uma Nova Pasta";
$owl_lang->alt_add_group        = "Criar este Grupo";
$owl_lang->alt_add_news         = "Adicionar novo item de Not&iacute;cia";
$owl_lang->alt_btn_add_note     = "Adicionar nova Anota&ccedil;&atilde;o";
$owl_lang->alt_add_user         = "Criar este Usu&aacute;rio";
$owl_lang->alt_btn_add_url      = "Criar um Novo Web link";
$owl_lang->alt_cancel           = "Cancle This Action";
$owl_lang->alt_cancel_move      = "Cancelar Acao Mover";
$owl_lang->alt_change           = "Atualizar este Registro";
$owl_lang->alt_btn_clickhere    = "Clique Aqui";
$owl_lang->alt_btn_collapse_view= "Mudar para Vis&atilde;o Compacta";
$owl_lang->alt_comments         = "H&aacute; Comet&aacute;rios para este Arquivo";
$owl_lang->alt_del_comments     = "Excluir este Coment&aacute;rio";
$owl_lang->alt_del_file      	= "Remover Arquivo (S/N)";
$owl_lang->alt_del_folder    	= "Remover Pasta? (S/N)";
$owl_lang->alt_del_group        = "Excluir este Grupo";
$owl_lang->alt_del_news         = "Excluir Esta Not&iacute;cia";
$owl_lang->alt_del_selected     = "Excluir todos os Arquivos Selecionados";
$owl_lang->alt_del_all          = "Esvaziar Lixeira";
$owl_lang->alt_rest_selected    = "Restaurar todos selecionados";
$owl_lang->alt_del_this_folder  = "Excluir Pasta &#8211; ";
$owl_lang->alt_del_user         = "Excluir este Usu&aacute;rio";
$owl_lang->alt_edit_group       = "Editar o Grupo selecionado";
$owl_lang->alt_edit_news        = "Editar esta Noticia";
$owl_lang->alt_edit_user        = "Editar o Usu&aacute;rio selecionado";
$owl_lang->alt_email            = "Enviar este Arquivo por Email";
$owl_lang->alt_email_selected   = "Enviar por E-Mail todos os Arquivos Selecionados"; 
$owl_lang->alt_btn_expand_view  = "Mudar para Vis&atilde;o expandida";
$owl_lang->alt_admin_flush   	= "Esvaziar Sess&otilde;es Expiradas";
$owl_lang->alt_get_file      	= "Baixar arquivo";
$owl_lang->alt_get_folder       = "Baixar conte&uacute;do da Pasta";
$owl_lang->alt_have_news        = "Voc&ecirc; tem Novos Item(s) Para Ver";
$owl_lang->alt_have_no_news     = "N&atilde;o h&aacute; Novos Item(s) Para Ver";
$owl_lang->alt_home_folder      = "Voltar o Diret&oacute;rio inicial ";
$owl_lang->alt_set_initial_dir  = "Ajustar este Diret&oacute;rio como Inicial";
$owl_lang->alt_site_map         = "Site Map";
$owl_lang->alt_lock_file        = "Bloquear Arquivo";
$owl_lang->alt_log_clear        = "Excluir Todos os Logs (S/N)";
$owl_lang->alt_log_file         = "Hist&oacute;rico de Arquivo";
$owl_lang->alt_log_next         = "Visualizar Pr&oacute;ximos Registros";
$owl_lang->alt_log_prev         = "Visualizar Registros Anteriores";
$owl_lang->alt_log_top          = "Ir para o Primeiro Registro";
$owl_lang->alt_btn_login        = "Logue-se na Intranet";
$owl_lang->alt_btn_logout       = "Sair da Intranet";
$owl_lang->alt_btn_help         = "Owl Online Help";
$owl_lang->alt_mod_file      	= "Modificar propriedades do arquivo";
$owl_lang->alt_mod_folder    	= "Modificar propriedades da pasta";
$owl_lang->alt_move_file     	= "Mover arquivo";
$owl_lang->alt_copy_file        = "Copiar Arquivo";
$owl_lang->alt_link_file        = "Criar atalho deste arquivo em outra pasta";
$owl_lang->alt_move_folder   	= "Mover pasta";
$owl_lang->alt_copy_folder      = "Copiar pasta";
$owl_lang->alt_move_selected    = "Mover todos os Arquivos Selecionados"; 
$owl_lang->alt_admin_groups 	= "Criar um Novo Grupo ";
$owl_lang->alt_news_close       = "Fechar Janela de Noticias";
$owl_lang->alt_news_next        = "Ver Novo Item de Not&iacute;cias";
$owl_lang->alt_news_prev        = "Ver Item de Not&iacute;cias Anterior";
$owl_lang->alt_news_print       = "Imprimir este Item de Not&iacute;cia";
$owl_lang->alt_admin_users      = "Criar um Novo Usu&aacute;rio";
$owl_lang->alt_monitor  	= "Monitorar este Arquivo";
$owl_lang->alt_monitored        = "Parar de Monitorar este Arquivo";
$owl_lang->alt_btn_admin        = "Owl - Administra&ccedil;&atilde;o";
$owl_lang->alt_play_file        = "Tocar Arquivo de M&iacute;dia";
$owl_lang->alt_recycle          = "Sua Lixeira est&aacute; Vazia";
$owl_lang->alt_recycle_disable  = "O Uso da Lixeira foi Desabilitado";
$owl_lang->alt_recycle_not_found= "A Localizaz&ccedil;&atilde;o do Lixo n&atilde;o foi Encontrada";
$owl_lang->alt_refresh_filter   = "Inicializar Filtro / Atualizaar Resultados";
$owl_lang->alt_register         = "Enviar se Registro";
$owl_lang->alt_btn_browse       = "Voltar para Navega&ccedil;&atilde;o";
$owl_lang->alt_search           = "Iniciar a Busca";
$owl_lang->alt_send_email       = "Enviar o Email";
$owl_lang->alt_sendfile         = "Enviar o Arquivo";
$owl_lang->alt_toggle_check_box = "Alternar caixas de sele&ccedil;&atilde;o";
$owl_lang->alt_unlock_file      = "Desbloquear Arquivo";
$owl_lang->alt_upd_file      	= "Atualizar arquivo";
$owl_lang->alt_view_comments    = "Adicionar / Ver Coment&aacute;rios deste Arquivo";
$owl_lang->alt_view_file     	= "Ver arquivo";
$owl_lang->alt_edit_field       = "Editar esta descri&ccedil;&atilde;o de campo";
$owl_lang->alt_del_field        = "Excluir este campo";
$owl_lang->alt_add_field        = "Adicionar o campo acima";
$owl_lang->alt_deldoctype       = "Excluir tipo de DOC";
$owl_lang->alt_upd_field        = "Atualizar este Campo";
$owl_lang->alt_new_doctype      = "Criar Novo tipo de DOC";
$owl_lang->alt_related          = "Encontar Doc's Relacionados";
$owl_lang->alt_back             = "Voltar a tela anterior";
$owl_lang->alt_submit           = "Enviar";

//********************************************************
// Image Alternate popup Messages END
//********************************************************


//********************************************************
// Owl Logging messages BEGIN
//********************************************************

$owl_lang->log_del_det          ="O Conte&uacute;do inteiro tanb&eacute;m foi deletado";
$owl_lang->log_detail           = "Sem Detalhes Adicionais";
$owl_lang->log_file_to          = "PARA: ";
$owl_lang->log_filter_all       = "TODOS";
$owl_lang->log_login_det        = "Usu&aacute;rio: ";
$log_file_actions[1]            = "LOGIN";
$log_file_actions[2]            = "LOGIN FALHOU";
$log_file_actions[3]            = "LOGOUT";
$log_file_actions[4]            = "ARQUIVO DELETADO";
$log_file_actions[5]            = "ARQUIVO ENVIADO";
$log_file_actions[6]            = "ARQUIVO ATUALIZADO";
$log_file_actions[7]            = "ARQUIVO BAIXADO";
$log_file_actions[8]            = "ARQUIVO MODIFICADO";
$log_file_actions[9]            = "ARQUIVO BLOQUEADO";
$log_file_actions[10]           = "ARQUIVO DESBLOQUEADO";
$log_file_actions[11]           = "ARQUIVO ENVIADO";
$log_file_actions[12]           = "ARQUIVO MOVIDO";
$log_file_actions[13]           = "PASTA CRIADA";
$log_file_actions[14]           = "PASTA DELETADA";
$log_file_actions[15]           = "PASTA MODIFICADA";
$log_file_actions[16]           = "PASTA MOVIDA";
$log_file_actions[17]           = "ESQUECER SENHA";
$log_file_actions[18]           = "REG USU&Aacute;RIO";
$log_file_actions[19]           = "ARQUIVO VISUALIZADO";
$log_file_actions[20]           = "ARQUIVO INFECTADO";
$log_file_actions[21]           = "ARQUIVO COPIADO";
$log_file_actions[22]           = "PASTA COPIADA";
$log_file_actions[23]           = "ATALHO";

//********************************************************
// Owl Logging messages END
//********************************************************


//********************************************************
// index.php  BEGIN
//********************************************************

$owl_lang->anonymous         = "(Acesso An&ocirc;nimo)";
$owl_lang->repository_list      = "Reposit&oacute;rio:";
$owl_lang->engine 	     = "OWL Intranet";
$owl_lang->forgot_pass       = "Esqueceu sua Senha?";
$owl_lang->like_register     = "Gostaria de se Registrar?";
$owl_lang->login             = "Acessar";
$owl_lang->loginfail         = "Acesso falhou";
$owl_lang->logindisabled     = "A conta foi DESABILITADA, contacte o Administrador do Sistema";
$owl_lang->password          = "Senha";
$owl_lang->successlogout     = "Voc&ecirc; saiu do sistema.";
$owl_lang->toomanysessions   = "Atingido o n&uacute;mero m&aacute;ximo de sessoes, contacte o Administrador de Sistemas";
$owl_lang->username          = "Usu&aacute;rio";
$owl_lang->version 	     = "Vers&atilde;o";

//********************************************************
// index.php  END
//********************************************************


//********************************************************
// browse.php  BEGIN
//********************************************************

$owl_lang->menu_url_action              = "A&ccedil;&otilde;es de URL";
$owl_lang->menu_file_action             = "A&ccedil;&otilde;es de Arquivo";
$owl_lang->menu_folder_action           = "Available Folder Actions";
$owl_lang->panel_file_info              = "Informa&ccedil;&atilde;o de Arquivo";
$owl_lang->actions           		= "A&ccedil;&otilde;es";
$owl_lang->del_selected          	= "Excluir Selecionados";
$owl_lang->del_all                      = "Esvaziar Lixeira";
$owl_lang->rest_selected                = "Recuperar Selecionados";
$owl_lang->disk_quota                   = "Quota de Disco";
$owl_lang->email_selected        	= "Email Selecionado";
$owl_lang->file              		= "Arquivo";
$owl_lang->folder_policy        	= "Regra Atual de Pasta:";
$owl_lang->current_folder               = "Pasta Atual:";
$owl_lang->held                      	= "Bloqueado por"; // for version control
$owl_lang->last_logged              	= "&Uacute;ltimo em: ";
$owl_lang->current_db                   = "Reposit&oacute;rio Atual:";
$owl_lang->modified          		= "Modificado";
$owl_lang->move_selected         	= "Mover Selecionado";
$owl_lang->new_file                     = "Novo!";
$owl_lang->no_description               = "Nenhuma Descri&ccedil;&atilde;o Dispon&iacute;vel";
$owl_lang->page                 	= "P&aacute;gina:";
$owl_lang->postedby          		= "Adicionado por";
$owl_lang->reallydelete      		= "Deseja remover? ";
$owl_lang->reallydelete_logs            = "Realmente Esvaziar o Conte&uacute;do do Arquivo de Log";
$owl_lang->reallydelete_selected	= "Realmente Excluir os Arquivos Selecionados";
$owl_lang->reallyrestore_selected       = "Realmente recuperar todos os selecionados";
$owl_lang->size              		= "Tamanho";
$owl_lang->score                        = "Score";
$owl_lang->title             		= "Titulo";
$owl_lang->doc_number                   = "Doc #";
$owl_lang->tot_files                    = "Total:";
$owl_lang->tot_my_checked_out           = "Bloqueado:";
$owl_lang->tot_my_files         	= "Meu:";
$owl_lang->tot_my_group                 = "Grupo:";
$owl_lang->tot_new_files                = "Novo:";
$owl_lang->tot_updated_files            = "Atualizado:";
$owl_lang->tot_monitored                = "Monitorado:";
$owl_lang->updated_file         	= "Atualizado!";
$owl_lang->user               		= "Usu&aacute;rio";
$owl_lang->ver                          = "Ver.";
$owl_lang->folder_count_pre             = "Esta Pasta Contém";
$owl_lang->folder_count_folder          = "Pasta(s)";
$owl_lang->folder_count_file            = "Arquivo(s)";
$owl_lang->folder_count_url             = "URL(s)";
$owl_lang->folder_count_note            = "Nota(s)";

//********************************************************
// browse.php  END
//********************************************************


//********************************************************
// modify.php  BEGIN
//********************************************************

$owl_lang->none_selected        = "NADA SELECIONADO";
$owl_lang->adding_comments      = "Adicionando / Visualizando Coment&aacute;rios: ";
$owl_lang->comments             = "Coment&aacute;rio";
$owl_lang->post_comment         = "Adicionar Coment&aacute;rio";
$owl_lang->addingfile           = "Adicionando um arquivo a ";
$owl_lang->addingfolder         = "Adicionando uma pasta a ";
$owl_lang->attach_file          = "Anexar Arquivo";
$owl_lang->change               = "Alterar";
$owl_lang->create               = "Criar";
$owl_lang->comments_added       = "Coment&aacute;rios Adicionados Por: ";
$owl_lang->description       	= "Descri&ccedil;&atilde;o";
$owl_lang->email_body        	= "Mensagem";
$owl_lang->email_cc          	= "CC";
$owl_lang->email_reply_to    	= "Responder Para";
$owl_lang->email_subject     	= "Assunto";
$owl_lang->email_to          	= "Mensagem Para";
$owl_lang->emailing          	= "Enviando Email";
$owl_lang->disp_mp3             = "MP3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Musica:<BR>Album:<BR>Bitrate&nbsp;-&nbsp;Sampreadate:<BR>Dura&ccedil;&atilde;o:<BR>G&ecirc;nero:<BR>Coment&aacute;rios:";
$owl_lang->keywords          	= "Palavras chaves";
$owl_lang->modify_url           = "URL";
$owl_lang->modifying         	= "Modificando ";
$owl_lang->name               	= "Nome";
$owl_lang->notify_link          = "OWL Intranet";
$owl_lang->note_content         = "Conte&uacute;do da Anota&ccedil;&atilde;o";
$owl_lang->ownergroup         	= "Grupo";
$owl_lang->ownership         	= "Criador por";
$owl_lang->permissions       	= "Permiss&otilde;es";
$owl_lang->prop_permissions     = "Propagar Permiss&otilde;es para os sub-diret&oacute;rios?";
$owl_lang->prop_perms_files     = "Permiss&otilde;es para Propagar para Arquivos:";
$owl_lang->policy            	= "Politica de acesso";
$owl_lang->pick_select          = "&#8212; Selecione um Usu&aacute;rio OWL Intranet &#8212;";
$owl_lang->sendfile          	= "Enviar aquivo";
$owl_lang->sendthisfile      	= "Enviar este arquivo";
$owl_lang->sendthisurl       	= "Enviar esta URL";
$owl_lang->updating             = "Atualizando";
$owl_lang->verdescription       = "Descri&ccedil;&atilde;o de mudan&ccedil;as";
$owl_lang->vermajor             = "Revis&atilde;o Maior";
$owl_lang->verminor             = "Revis&atilde;o Menor";
$owl_lang->vertype              = "Tipo de Revis&atilde;o"; // for modify.php when uploading

//********************************************************
// modify.php  END
//********************************************************


//********************************************************
// register.php  BEGIN
//********************************************************
                                                                                                       
$owl_lang->email         = "Email";
$owl_lang->full_name     = "Nome Completo";
$owl_lang->register      = "Registro de Usu&aacute;rio";
$owl_lang->self_failed   = "Falhou";
$owl_lang->self_passwd   = "Senha Enviar Para:";
$owl_lang->self_reg_bod  = "Sua senha da Intranet &eacute;:";
$owl_lang->self_reg_rset = "Sua senha da Intranet foi restabelecida como:";
$owl_lang->self_reg_subj = "Sua Conta OWL Intranet";
$owl_lang->send_pass     = "Enviar Senha";
$owl_lang->submit        = "Registrar";
$owl_lang->thank_you_1   = "Obrigado!";
$owl_lang->thank_you_2   = "Uma mensagem ser&aacute; enviada para seu endere&ccedil;o de E-Mail<BR> com a NOVA senha para <BR><b>USU&Aacute;RIO:</b>";

//********************************************************
// register.php  END
//********************************************************


//********************************************************
// move.php  BEGIN
//********************************************************

$owl_lang->cancel_button     = "Cancelar";
$owl_lang->moving            = "Movendo";
$owl_lang->moving_file          = "Movendo arquivo";
$owl_lang->moving_folder        = "Movendo pasta";
$owl_lang->copy_file            = "Copiando Arquivo";
$owl_lang->copy_folder          = "Copiando Pasta";
$owl_lang->select            = "Por Favor Selecione uma nova pasta:";

//********************************************************
// move.php  END
//********************************************************


//********************************************************
// log.php  BEGIN
//********************************************************

$owl_lang->viewlog           = "Visualizar Log de ";

//********************************************************
// log.php  END
//********************************************************


//********************************************************
// prefs.php  BEGIN
//********************************************************

$owl_lang->confpassword = "Confirmar Nova Senha";
$owl_lang->comment_notif= "Coment&aacute;rio de Notifica&ccedil;&atilde;o";
$owl_lang->email_tool   = "Ferramenta de E-Mail";
$owl_lang->last_modified= "Ultima modifica&ccedil;&atilde;o";
$owl_lang->group        = "Grupo Prim&aacute;rio";
$owl_lang->groupmember  = "Membro do Grupo";
$owl_lang->newpassword  = "Nova Senha";
$owl_lang->newsadmin    = "Administrador de Noticias";
$owl_lang->not_member   = "Voc&ecirc; n&atilde;o faz parte de nenhum outro Grupo";
$owl_lang->notification = "Receber Notifica&ccedil;&otilde;es";
$owl_lang->oldpassword  = "Senha Antiga";
$owl_lang->preference   = "Prefer&ecirc;ncias";
$owl_lang->saved        = "Altera&ccedil;&otilde;es Salvas";
$owl_lang->status_no    = "N&Atilde;O";
$owl_lang->status_yes   = "SIM";
$owl_lang->userlang     = "Idioma";

//********************************************************
// prefs.php  END
//********************************************************


//********************************************************
// search.php  BEGIN
//********************************************************

$owl_lang->elapsed_time       = "Tempo decorrido";
$owl_lang->search             = "Busca";
$owl_lang->search_any_word      = "Quaisquer Palavras";
$owl_lang->search_all_word      = "Todas Palavras";
$owl_lang->search_entire_phrase = "Toda Frase";
$owl_lang->search_match         = "Buscar:";
$owl_lang->search_currentfolder = "Buscar na Pasta Atual";
$owl_lang->search_for_folders = "Buscando Pastas";
$owl_lang->search_for_files   = "Buscando Arquivos";
$owl_lang->search_score       = "Ordenando Arquivos";
$owl_lang->search_results_for = "Resultados da busca por ";
$owl_lang->search_winthindocs = "Buscar no conte&uacute;do do Documentos(text, pdf & MS-Word)";
$owl_lang->related_query_empty  = "Sem metadados no documento para executar 'Search Related'";
$owl_lang->query_empty        = "Apagar Crit&eacute;rio de Busca";

//********************************************************
// search.php  END
//********************************************************


//********************************************************
// view.php  BEGIN
//********************************************************

$owl_lang->viewing           = "Visualizando ";

//********************************************************
// view.php  END
//********************************************************


//********************************************************
// admin/index.php  BEGIN
//********************************************************

$owl_lang->display_password_override    = "Display File/Folder Password Override";
$owl_lang->download_folder_zip          = "Download Folders as ZIP (Default is tar.gz)";
$owl_lang->doc_id_prefix                = "Prefixo para Doc# ";
$owl_lang->doc_id_num_digits            = "Numero de digitos dos Documentos";
$owl_lang->view_doc_in_new_window       = "Nova janela para visualizar Docs";
$owl_lang->admin_login_to_browse_page   = "Admin acessa direto a navega&ccedil;&atilde;o";
$owl_lang->save_keywords_to_db          = "Permite usu&aacute;rios salvar chaves pra reuso";
$owl_lang->status_column                = "Status";
$owl_lang->vermajor_initial             = "Vers&atilde;o Maior Inicial";
$owl_lang->verminor_initial             = "Vers&atilde;o Menor Inicial";
$owl_lang->docicon_column               = "Doc Icon";
$owl_lang->btn_users_groups             = "Usu&aacute;rios &amp;<br></br>Grupos";
$owl_lang->alt_btn_users_groups         = "Administrar Usu&aacute;rios e Grupos";
$owl_lang->btn_html_prefs               = "Prefer&ecirc;ncias <br></br> HTML";
$owl_lang->alt_btn_html_prefs           = "Editar prefer&ecirc;ncias HTML do Site";
$owl_lang->btn_site_features            = "Caracteristicas <br></br>do Site";
$owl_lang->alt_btn_site_features        = "Editar ajustes e caracteirsticas do Site";
$owl_lang->btn_log_viewer               = "Visualizar<br></br>LOG's";
$owl_lang->alt_btn_log_viewer           = "Visualizar LOG de sistema";
$owl_lang->btn_statistics_viewer        = "Estatisticas / Relat&oacute;rios <br />";
$owl_lang->alt_btn_statistics_viewer    = "Owl Statistics Viewer";
$owl_lang->btn_news_admin               = "Admin<br></br> Not&iacute;cias";
$owl_lang->alt_btn_news_admin           = "Owl News Administrator";
$owl_lang->btn_doctype_admin            = "Tipo de <br></br>Documentos";
$owl_lang->alt_btn_doctype_admin        = "Administrador do tipo de DOCs";
$owl_lang->btn_backup                   = "Backup<br></br>Database";
$owl_lang->alt_btn_backup               = "Backup SQL Database";
$owl_lang->btn_trashcan                 = "Lixeira";
$owl_lang->alt_btn_trashcan             = "Clique para ver os Conte&uacute;dos";
$owl_lang->btn_initial_load             = "Carga Inicial";
$owl_lang->alt_btn_initial_load         = "Carregar BD da Pasta de Documentos";
$owl_lang->confirm_initial_load         = "*** ATEN&Ccedil;&Atilde;O ***  Isto deve ser executado somente quando a base est&aacute; vazia";
$owl_lang->add               		= "Adicionar";
$owl_lang->anonymous_account            = "Conta de Acesso An&ocirc;nimo:";
$owl_lang->buttonstyle          	= "Estilo de Bot&atilde;o";
$owl_lang->deletegroup       		= "Remover Grupo";
$owl_lang->deleteuser        		= "Remover Usu&aacute;rio";
$owl_lang->disableuser       		= "Usu&aacute;rio Desabilitado";
$owl_lang->disable_recs_per_page        = "Habilitando a vis&atilde;o restrita desabilita a fun&ccedil;&atilde;o de pagina&ccedil;&atilde;o!";
$owl_lang->file_admin_group             = "Administrador de Grupo Arquivar/Navegar :";
$owl_lang->flushed           		= "Registrto de Sess&atilde;o esvaziado, o usu&aacute;rio pode agora logar novamente.<BR>";
$owl_lang->groups            		= "Grupos";
$owl_lang->hide_bulk_buttons            = "Ocultar bot&atilde;o 'em massa - bulk':";
// Edit HTML Properties Messages
$owl_lang->ht_tbl_border_sz  		= "Tamanho da Borda da Tabela:";
$owl_lang->ht_tbl_hd_bg      		= "Fundo do Cabe&ccedil;alho:";
$owl_lang->ht_tbl_cell_bg_cl 		= "Cor de Fundo da C&eacute;lula da Tabela:";
$owl_lang->ht_tbl_cell_bg_al 		= "Cor de Fundo Alternativa da C&eacute;lula da Tabela:";
$owl_lang->ht_expand_width   		= "Expandir Tamanho da &aacute;rea de Vis&atilde;o:";
$owl_lang->ht_collapse_width 		= "Retrair Tamanho da &aacute;rea de Vis&atilde;o:";
$owl_lang->ht_bd_bg_image    		= "Path da Imagem de Fundo:";
$owl_lang->ht_bd_txt_cl      		= "Cor do Corpo de Texto:";
$owl_lang->ht_bd_lnk_cl      		= "Cor do link Corpo de Texto:";
$owl_lang->ht_bd_vlnk_cl     		= "Corpo de Texto - Cor do Link Visitado:";
// Edit Prefs Properties Messages
$owl_lang->home_dir			= "Diret&oacute;rio do Usu&aacute;rio";
$owl_lang->initial_dir                  = "Diret&oacute;rio Inicial do Usu&aacute;rio";
$owl_lang->maxsessions       		= "Max No. Sessoes";
$owl_lang->noprefaccess       		= "Pref Desabilitada";
$owl_lang->owl_anon_full                = "Acesso Total";
$owl_lang->owl_anon_ro       		= "Definir An&ocirc;nimo como Somente Leitura:";
$owl_lang->owl_anon_download            = "Baixar apenas";
$owl_lang->anonymous_access             = "Ajustar Acesso Anonimo";
$owl_lang->owl_dbdump_path      	= "Caminho da Ferramenta DB Dump:";
$owl_lang->owl_def_file_group_owner	= "Grupo Propriet&aacute;rio Padr&atilde;o do Arquivo:";
$owl_lang->owl_def_file_meta 		= "Arquivo Padr&atilde;o de Meta Data:";
$owl_lang->owl_def_file_owner		= "Propriet&aacute;rio Padr&atilde;o do Arquivo:";
$owl_lang->owl_def_file_perm 		= "Regra Padr&atilde;o de Cria&ccedil;&atilde;o de Arquivo:";
$owl_lang->owl_def_file_security	= "Padr&atilde;o de Seguran&ccedil;a do Arquivo:";
$owl_lang->owl_def_file_title		= "T&iacute;tulo Padr&atilde;o de Arquivo (Nenhum para Nomedearquivo:";
$owl_lang->owl_def_fold_group_owner  	= "Grupo Propriet&aacute;rio Padr&atilde;o da Pasta:";
$owl_lang->owl_def_fold_owner        	= "Proprit&aacute;rio Padr&atilde;o de Pasta:";
$owl_lang->owl_def_fold_sec  		= "Seguran&ccedil;a Padr&atilde;o de Pasta:";
$owl_lang->owl_def_folder_perm 		= "Regra Padr&atilde;o de Cria&ccedil;&atilde;o de Pasta:";
$owl_lang->owl_default_tmpdir   	= "Localiza&ccedil;&atilde;odo Diret&oacute;rio Tempor&aacute;rio: ";
$owl_lang->owl_email_from    		= "Endere&ccedil;o De / Usu&aacute;rio SMTP Auth:";
$owl_lang->owl_email_fromname		= "Nome De:";
$owl_lang->owl_email_replyto 		= "Responder para Endere&ccedil;o:";
$owl_lang->owl_email_server  		= "Servidor SMTP:";
$owl_lang->owl_email_smtp               = "Usar SMTP Mailing Method";
$owl_lang->owl_email_smtp_auth          = "Usar SMTP Auth";
$owl_lang->owl_email_smtp_auth_login    = "SMTP Auth Login:";
$owl_lang->owl_email_smtp_auth_passwd   = "Senha SMTP Auth";
$owl_lang->owl_email_subject_pref       = "Assunto:";
$owl_lang->owl_fogotpass             	= "Mostrar o link 'esque&ccedil;i a senha':";
$owl_lang->owl_group_user    		= "Usu&aacute;rios membros deste Grupo";
$owl_lang->owl_gzip_path        	= "Caminho do gzip:";
$owl_lang->owl_hidebackup    		= "Ocultar o Diret&oacute;rio de Backup:";
$owl_lang->owl_log_file      		= "Log Arquivo Atividades:";
$owl_lang->owl_log_login_act 		= "Log Login/Logout Atividades:";
$owl_lang->owl_log_rec_page  		= "Ver Registros Por Pagina:";
$owl_lang->owl_logging       		= "Habilitar Logging:";
$owl_lang->owl_logo                  	= "Logo da P&aacute;gina de Login ([Language]/graphics):";
$owl_lang->owl_lookAtHD      		= "Desabilitado checar no hd:";
$owl_lang->owl_lookAtHDDel   		= "Remover Arquivos Deletados do BD:";
$owl_lang->hide_folder_doc_count        = "Desabilitar contador de tipo de arquivos";
$owl_lang->hide_folder_size             = "Hide Folder Content Size";
$owl_lang->old_action_icons             = "Usar Icones antigos";
$owl_lang->search_result_folders        = "Incluir Pastas no resultado de pesquisas";
$owl_lang->restore_file_prefix          = "Prefixo para arquivos recuperados";
$owl_lang->owl_max_filesize  		= "Tamanho M&aacute;ximo de Arquivos para Enviar:";
$owl_lang->owl_owl_expand    		= "Padr&atilde;o de Visualiza&ccedil;&atilde;o de Navega&ccedil;&atilde;o (Expandir):";
$owl_lang->owl_owl_timeout   		= "Tempo de T&eacute;rmino da Se&ccedil;&atilde;o em Segundos:";
$owl_lang->virus_path                   = "Virus Checking Software Path<br />Example: '/usr/bin/clamscan --quiet' <br />&#8211; Blank for Disabled:";
$owl_lang->owl_pdftotext_path   	= "Manter o &iacute;ndice de Busca para <BR>Arquivos PDF e texto <BR>&#8211; Em branco para n&atilde;o selecionado:";
$owl_lang->owl_wordtotext_path          = "Arquivos MS-WORD <BR>&#8211; Blank for Disabled:";
$owl_lang->owl_pod2html_path    	= "Perl 5.8.0 ou Maior requerido<BR>Caminho para o pod2html:";
$owl_lang->owl_restrict_view 		= "Habilitar Vis&atilde;o Restrita:";
$owl_lang->owl_self_reg      		= "Habilitar Registro Autom&aacute;tico:";
$owl_lang->owl_self_reg_hd      	= "PADR&Otilde;ES DE AUTO-REGISTRO DE US&Aacute;RIOS";
$owl_lang->owl_tar_path         	= "Caminho do tar:";
$owl_lang->owl_title_custom             = "CUSTOMIZAR COLUNAS DA NAVEGA&Ccedil;&Atilde;O";
$owl_lang->owl_title_custom_search      = "CUSTOMIZAR RESULTADOS DA BUSCA";
$owl_lang->owl_title_browser    	= "FACILIDADES DO NAVEGADOR OWL";
$owl_lang->owl_title_defaults   	= "PADR&Otilde;ES";
$owl_lang->owl_title_email   		= "OWL Intranet - Padr&otilde;es do Sistema de Correio";
$owl_lang->owl_title_HD         	= "INSPECIONANDO HD POR NOVAS DEFINI&Ccedil;&Otilde;ES DE ARQUIVOS";
$owl_lang->owl_title_logging    	= "PADR&Otilde;ES DE LOGGING";
$owl_lang->owl_title_other      	= "OUTRAS DEFINI&Ccedil;&Otilde;ES";
$owl_lang->owl_title_tools      	= "FERRAMENTAS BACKUP/GZIP BD";
$owl_lang->owl_unzip_path       	= "Localiza&ccedil;&atilde;o do unzip:";
$owl_lang->owl_version_control		= "Habilitar Controle de Vers&atilde;o:";
$owl_lang->quota             		= "Cota 0=Desabilitado";
$owl_lang->reallydeluser                = "Este usu&aacute;rio e propriet&aacute;rio de %numfiles% Arquivo(s) e %numfolders% Pasta(s). Estes ficar&atilde;o com problemas de permiss&atilde;o. Deseja remover assim mesmo ?";
$owl_lang->recs_per_page        	= "Visualizar Registro por P&aacute;gina (0 = Desabilitado):";
$owl_lang->remember_me_title            = "AJUSTES DE SESS&Atilde;O PERSISTENTE";
$owl_lang->remember_me                  = "Exibir o link Lembrar Senha";
$owl_lang->remember_timeout             = "Cookie timeout em Dias";
$owl_lang->remember_me_checkbox         = "Lembrar Senha";
$owl_lang->recycle_title        	= "DEFINI&Ccedil;&Otilde;ES DE COLETA DE LIXO";
$owl_lang->recycle_enabled              = "Habilitar Restaura&ccedil;&atilde;o de Lixo:";
$owl_lang->recycle_location             = "Lixeira Localiza&ccedil;&atilde;o:";
$owl_lang->show_panel_title             = "Display Painel de Status:";
$owl_lang->show_search_title            = "Display Barra de Pesquisa:";
$owl_lang->show_pref_title              = "Display Pref/logout Bar:";
$owl_lang->show_bulk_title              = "Display Bot&otilde;es Bulk:";
$owl_lang->show_action_title            = "Display Bot&otilde;es de A&ccedil;&atilde;o:";
$owl_lang->show_folder_title            = "Display Ferramenta de Pastas:";
$owl_lang->show_panel                   = "Exibir";
$owl_lang->hide_panel                   = "Esconder";
$owl_lang->status_bar_both              = "Ambos";
$owl_lang->status_bar_bottom            = "Fundo";
$owl_lang->status_bar_location          = "Mostrar a barra de status em:";
$owl_lang->status_bar_top               = "Alto";
$owl_lang->status_bar_not               = "N&atilde;o Exibir";
$owl_lang->use_popup                    = "Usar popup para exibir Not&iacute;cias:";
$owl_lang->users             		= "Usu&aacute;rios";
$owl_lang->header_user_admin            = "Administra&ccedil;&atilde;o de Usu&aacute;rios";
$owl_lang->header_group_admin           = "Administra&ccedil;&atilde;o de Grupos";
$owl_lang->header_sitefeatures_settings           = "Caracteristicas do SITE";

//********************************************************
// admin/index.php  END
//********************************************************


//********************************************************
// admin/log.php  BEGIN
//********************************************************

$owl_lang->owl_log_viewer       = "Visualizador de LOG";
$owl_lang->owl_log_hd_action 	= "Acao";
$owl_lang->owl_log_hd_file   	= "Arquivo";
$owl_lang->owl_log_hd_fld_path	= "Pasta Path";
$owl_lang->owl_log_hd_user   	= "Usu&aacute;rio";
$owl_lang->owl_log_hd_dt_tm     = "Data e Hora";
$owl_lang->owl_log_hd_ip        = "IP / Endere&ccedil;o";
$owl_lang->owl_log_hd_agent     = "Agente";
$owl_lang->owl_log_hd_dtls   	= "Detalhes";
$owl_lang->owl_log_no_rec    	= " NENHUM REGISTRO ENCONTRADO ";
$owl_lang->owl_log_hide      	= "Ocultar: ";
$owl_lang->owl_log_filter    	= "Filtro";

//********************************************************
// admin/log.php  END
//********************************************************


//********************************************************
// admin/recycle.php  BEGIN
//********************************************************

$owl_lang->empty_trash          = "Esvaziar Lixo";
$owl_lang->really_empty_trash   = "Confirma Esvaziar a Lixeira?";
$owl_lang->recycle_bin_admin    = "Administrac&atilde;o da Lata de Lixo";

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
$owl_lang->notif_subject_new 			= "Novo Arquivo";
$owl_lang->notif_subject_upd 			= "Altera&ccedil;&atilde;o em arquivo";
$owl_lang->notif_subject_monitor 		= "Um Arquivo ou Pasta da Intranet que voc&ecirc; est&aacute; monitorando foi atualizado";
$owl_lang->notif_subject_comment        	= "OWL Intranet -- Coment&aacute;rio Adicionado";
$owl_lang->notif_comment_1              	= "commentado em";
$owl_lang->notif_comment_2              	= "Coment&aacute;rio:";
$owl_lang->notif_msg         			= "Esta mensagem &eacute; do sistema OWL Intranet<BR><BR>Click no link abaixo para ver o arquivo<BR><BR>";
$owl_lang->notif_msg_link               = "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet<BR><BR>Find a link to a new/updated file in this E-Mail<BR><BR>";
$owl_lang->notif_msg_alt     			= "Esta mensagem &eacute; do sistema OWL Intranet\n\nClick no link abaixo para ver o arquivo\n\n";
$owl_lang->notif_msg_alt_link           = "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet\n\nFind a link to a new/updated file in this E-Mail\n\n";
$owl_lang->notif_salutation             	= "Prezado";
$owl_lang->notif_user                   = "Criado/Atualizado por:";
$owl_lang->owl_path                     	= " Caminho do Arquivo: ";
$owl_lang->sessinuse         			= "Esta sess&atilde;o esta sendo acessada de outro computador. Acesso negado.<BR>";
$owl_lang->invalidsess       			= "Sess&atilde;o inv&aacute;lida, favor clicar em sair pela p&aacute;gina principal.<BR>";
$owl_lang->sesstimeout       			= "Sess&atilde;o expirou, acesse o sistema novamente.<BR>";
$owl_lang->everyoneread      			= "Todos podem ler/baixar";
$owl_lang->everyonewrite     			= "Todos podem ler/escrever/baixar";
$owl_lang->everyonewrite_nod 			= "Qualquer um pode ler/escrever/baixar (N&Atilde;O APAGAR)";
$owl_lang->groupread         			= "Seu Grupo pode ler/baixar";
$owl_lang->groupwrite        			= "Seu Grupo pode ler/escrever/baixar";
$owl_lang->groupwrite_nod    			= "Seu Grupo pode ler/escrever/baixar (N&Atilde;O APAGAR)";
$owl_lang->onlyyou           			= "Apenas voc&ecirc; pode ler/baixar/escrever";
$owl_lang->donothing            		= "N&atilde;o Fazer Nada &#8211; Deixar as Permiss&otilde;es de Arquivo como est&atilde;o";
$owl_lang->groupwrite_worldread 		= "Seu Grupo pode ler/escrever/baixar & todos os outros podem ler";
$owl_lang->groupwrite_worldread_nod 		= "Seu Grupo pode ler/escrever/baixar (N&Atilde;O APAGAR) & todos os outros podem ler";
$owl_lang->ggroupwrite_worldread 		= "Seu Grupo pode enviar arquivos e deletar esta pasta & todos podem ver seu conte&uacute;do";
$owl_lang->ggroupwrite_worldread_nod 		= "Seu Grupo pode enviar arquivos para esta pasta & todos podem ver seu conte&uacute;do, (N&Atilde;O APAGAR)";
$owl_lang->everyoneread_ad   			= "Todos podem ler/baixar";
$owl_lang->everyonewrite_ad  			= "Todos podem ler/escrever/baixar";
$owl_lang->everyonewrite_ad_nod 		= "Todos podem baixar/ler/escrever (N&Atilde;O APAGAR)";
$owl_lang->groupread_ad      			= "O Grupo selecionado pode ler/baixar";
$owl_lang->groupwrite_ad     			= "O Grupo selecionado pode ler/escrever/baixar";
$owl_lang->groupwrite_ad_nod 			= "O Grupo selecionado pode ler/escrever/baixar, (N&Atilde;O APAGAR)";
$owl_lang->onlyyou_ad        			= "Apenas voc&ecirc; pode ler/escrever/baixar";
$owl_lang->groupwrite_worldread_ad 		= "O Grupo selecionado pode baixar/ler/escrever & todos os outros podem ler";
$owl_lang->groupwrite_worldread_ad_nod 		= "O Grupo pode ler/escrever/baixar arquivos (N&Atilde;O APAGAR) & todos os outros podem ler";
$owl_lang->ggroupwrite_worldread_ad 		= "O Grupo selecionado pode enviar arquivos e apagar esta pasta & todos podem ver seu conte&uacute;do";
$owl_lang->ggroupwrite_worldread_ad_nod 	= "O Grupo selecionado pode enviar arquivos para esta pasta & todos podem ver seu conte&uacute;do, (N&Atilde;O APAGAR)";
$owl_lang->geveryoneread     			= "Todos podem ler esta pasta";
$owl_lang->geveryonewrite    			= "Todos podem enviar arquivos e apagar esta pasta";
$owl_lang->geveryonewrite_nod			= "Todos podem enviar arquivos para esta pasta";
$owl_lang->ggroupread        			= "Seu Grupo pode ler esta pasta";
$owl_lang->ggroupwrite       			= "Seu Grupo pode enviar arquivos e apagar esta pasta.";
$owl_lang->ggroupwrite_nod   			= "Seu Grupo pode enviar arquivos para esta pasta";
$owl_lang->gonlyyou          			= "Apenas voc&ecirc; pode enviar arquivos e apagar esta pasta";
$owl_lang->geveryoneread_ad  			= "Todos podem ler esta pasta";
$owl_lang->geveryonewrite_ad 			= "Todos podem enviar arquivos e apagar esta pasta";
$owl_lang->geveryonewrite_ad_nod     		= "Todos podem adicionar arquivos para esta pasta";
$owl_lang->ggroupread_ad     			= "O Grupo selecionado pode ler esta pasta";
$owl_lang->ggroupwrite_ad    			= "O Grupo selecionado pode enviar arquivos e apagar esta pasta";
$owl_lang->ggroupwrite_ad_nod			= "O Grupo selecionado pode enviar arquivos para esta pasta";
$owl_lang->gonlyyou_ad       			= "Apenas voc&ecirc; pode enviar arquivos e apagar esta pasta";
$owl_lang->orphaned                     	= "&#8211; Sem Propriet&aacute;rio &#8211;";
$owl_lang->virus_infected               = "INFECTADO POR V&Iacute;RUS";
$owl_lang->virus_return_val             = "RESPOSTA DO ANTIV&Iacute;RUS:";

//********************************************************
// lib/owl.lib.php  END
//********************************************************


//********************************************************
// HREF TITLE messages  BEGIN
//********************************************************

$owl_lang->title_browse_folder          = "Navegar  nesta Pasta";
$owl_lang->title_browse_site            = "Navegar nesta URL";
$owl_lang->title_download_view          = "Baixar/Ver Este Arquivo";
$owl_lang->title_edit_prefs             = "Ver/Editar Prefer&ecirc;ncias de Usu&aacute;rios";
$owl_lang->title_return_folder          = "Voltar para";
$owl_lang->title_sort                   = "Ordenar por";
$owl_lang->title_view_new               = "Ver Lista de Novos Arquivos desde minha &uacute;ltima visita";
$owl_lang->title_view_updated           = "Ver Lista de Arquivos Atualizados desde minha &uacute;ltima visita";
$owl_lang->title_view_my                = "Ver Lista dos Meus Arquivos";

//********************************************************
// HREF TITLE messages  END
//********************************************************


//********************************************************
// admin/news.php and newsread.php BEGIN
//********************************************************

$owl_lang->news_title                   = "Administra&ccedil;&atilde;o de Not&iacute;cias";
$owl_lang->news_hd                      = "Not&iacute;cias";
$owl_lang->news_hd_created              = "Criado Em";
$owl_lang->news_hd_expires              = "Expira Em";
$owl_lang->news_hd_audience             = "P&uacute;blico-alvo";
$owl_lang->news_heading                 = "T&iacute;tulo da Noticia";
$owl_lang->news_content                 = "Conte&uacute;do";
$owl_lang->news_posted_date             = "Noticia Enviada:";
$owl_lang->news_read                   	= "Ler Not&iacute;cias";

//********************************************************
// admin/news.php and newsread.php  END
//********************************************************


//********************************************************
// DEBUG MESSAGES BEGIN
//********************************************************

$owl_lang->debug_tmp_not_exists 	= "DEBUG: Diret&oacute;rio Tempor&aacute;rio do OWL: $default->owl_tmpdir n&atilde;o existe.";
$owl_lang->debug_tmp_not_writeable 	= "DEBUG: The OWL temporary Directory: $default->owl_tmpdir n&atilde;o possui permiss&atilde;o de escrita.";
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

$owl_lang->owl_stats_viewer     = "Visualiza&ccedil;&atilde;o de Estat&iacute;sticas";
$owl_lang->stats_files          = "Numero de Arquivos Por Usu&aacute;rios";
$owl_lang->stats_folders        = "Numero de Pastas Por Usu&aacute;rios";
$owl_lang->stats_top            = "Os 20 Mais Baixados";
$owl_lang->stats_users          = "USER Signon (Login / Failure / Logout)";
$owl_lang->stats_users_loggedin = "Currently Logged In";
$owl_lang->stats_information    = "O  Log de Arquivo precisa estar Habilitado para estas estatisticas serem mostradas";

//********************************************************
// admin/stats.php END
//********************************************************

//********************************************************
// admin/doctype.php BEGIN
//********************************************************

$owl_lang->document_type        = "Tipo do Documento";
$owl_lang->document_type_name   = "Tipo do Documento";
$owl_lang->doc_field_name       = "Nome do Campo";
$owl_lang->doc_field_pos        = "Ordem de Exibi&ccedil;&atilde;o";
$owl_lang->doc_field_label      = "Descri&ccedil;&atilde;o do Campo (Por Idioma)";
$owl_lang->doc_field_size       = "Tamanho do Campo";
$owl_lang->doc_field_searchable = "Indexado?";
$owl_lang->doc_field_required   = "Requerido?";
$owl_lang->doc_new_doc_type     = "&#8212; Adicionar Novo Tipo de Documento &#8212;";
$owl_lang->doc_specific         = "Dados espec&iacute;ficos do Documento";
$owl_lang->doc_administration   = "Document Type Admininstration";

//********************************************************
// admin/doctype.php END
//********************************************************

                                                                                                                                                                           
//********************************************************
// DOC PEER Review  BEGIN
//********************************************************
                                                                                                                                                                           
$owl_lang->peer_reviewer_list   = "Revisor(es)";
$owl_lang->peer_msg_to_reviewer = "Mensagem para os Revisores";
$owl_lang->peer_final_approval  = "[Aprova&ccedil;&atilde;o Final]: ";
$owl_lang->peer_subj_review     = "Voc&ecirc; tem uma arquivo para revisar";
$owl_lang->peer_subj_approved   = "Seu Documento foi APROVADO";
$owl_lang->peer_subj_rejected   = "Seu Documento foi REJEITADO";
$owl_lang->peer_subj_reminder   = "LEMBRETE: Voc&ecirc; tem um arquivo para revisar";
$owl_lang->peer_notif_user      = "Criado/Atualizado por";
$owl_lang->peer_file_to_review  = "Arquivo para revisar:";
$owl_lang->peer_file_approved   = "Arquivo Aprovado:";
$owl_lang->peer_file_rejected   = "Arquivo Rejeitado:";
$owl_lang->peer_file_final      = "Aprova&ccedil;&atilde;o Final:";
$owl_lang->peer_final_body      = "Seu Documento foi aprovado por todos os revisores. Favor acessar o sistema e disponobilizar o Documento";
$owl_lang->peer_review_body     = "Sua aprova&ccedil;&atilde;o foi solicitada para o seguinte documento:";
$owl_lang->peer_approved_body   = "Seu arquivo foi aprovado:";
$owl_lang->peer_rejected_body   = "Seu arquivo foi rejeitado:";
$owl_lang->peer_my_approval     = "Esperando minha aprova&ccedil;&atilde;o";
$owl_lang->peer_pending_approval= "Aprova&ccedil;&atilde;o Pendente";
$owl_lang->peer_satus_pending   = "&#8212; P E N D E N T E &#8212;";
$owl_lang->peer_satus_rejected  = "&#8212; R E J E I T A D O &#8212;";
$owl_lang->peer_satus_approved  = "&#8212; A P R O V A D O &#8212;";
$owl_lang->peer_satus           = "Status";
$owl_lang->peer_pending_title   = "Meus Documentos com Aprova&ccedil;&atilde;o Pendente";
$owl_lang->peer_approval_title  = "Documentos esperando minha aprova&ccedil;&atilde;o";
$owl_lang->owl_title_peer_review= "CARACTERISTICAS DE REVIS&Atilde;O DE DOCUMENTOS";
$owl_lang->owl_peer_review      = "Habilitar Revisores:";
$owl_lang->owl_peer_review_opt  = "Tornar Revisores opcional:";
                                                                                                                                                                           
//********************************************************
// DOC PEER Review  END
//********************************************************
?>
