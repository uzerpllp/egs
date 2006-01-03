<?php
/*

  File: Francais/language.inc
  Author: Bozz
  Email: bozz@bozzit.com
  Date: 2001/10/16

  Owl: Copyright Chris Vincent <cvincent@project802.net>

  You should have received a copy of the GNU Public
  License along with this package; if not, write to the
  Free Software Foundation, Inc., 59 Temple Place - Suite 330,
  Boston, MA 02111-1307, USA.

  Updated by Roublev on 2003/06/10
  Email : roublev@free.fr

  Updated and corrected in "French of France" by philplug on 2004/08/31 (corrected hyphenations, Canadian idioms turned into French idioms, etc.)
  Email : ppeltier@bateaubois.com


*/
//********************************************************
// Date Formating BEGIN
//********************************************************

// If config/owl.php   $default->generic_date_format is set USE That one if not
// use the one in this file

if (isset($default->generic_date_format) && trim($default->generic_date_format) != "") {

        $owl_lang->localized_date_format = $default->generic_date_format;
} else {
        $owl_lang->localized_date_format = "d-m-Y @ H:i:s";
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
$owl_lang->err_adding_comments          = "Vous n'avez pas la permission n&eacute;cessaire pour ajouter un commentaire &agrave; ce fichier";
$owl_lang->err_comment_empty            = "Comment cannot be empty";
$owl_lang->err_backup_file              = "Erreur lors de la sauvegarde d'un fichier existant";
$owl_lang->err_backup_folder_create     = "Erreur lors de la cr&eacute;ation du dossier de sauvegarde";
$owl_lang->err_bad_url                  = "Entrez une URL valide SVP";
$owl_lang->err_bad_version_1            = "Owl Intranet a besoin d'une version minimum de PHP ";
$owl_lang->err_bad_version_2            = "Votre serveur a";
$owl_lang->err_bad_version_3            = "L'administrateur du syst&egrave;me doit installer une nouvelle version de PHP";
$owl_lang->err_email                    = "Le Message n'a pu &ecirc;tre envoy&eacute;";
$owl_lang->err_email_required           = "Le champ Adresse Email est requis";
$owl_lang->err_fexist1                  = "<b>Fichiers d&eacute;j&agrave; existant:</b>";
$owl_lang->err_fexist2                  = "Il y a d&eacute;j&agrave; un fichier nomm&eacute; <i>";
$owl_lang->err_fexist3                  = "</i> dans ce dossier.";
$owl_lang->err_file_exists              = "Le fichier que vous essayez d'ajouter existe d&eacute;j&agrave;";
$owl_lang->err_file_lock                = "Vous ne pouvez pas verrouiller ce fichier, il est d&eacute;j&agrave; verrouill&eacute; par ";
$owl_lang->err_update_file_lock         = "You cannot update this file, it is currently held by";
$owl_lang->err_filemove_exist           = "Le nom de fichier existe d&eacute;j&agrave; (renommer)";
$owl_lang->err_file_not_exist           = "Fichier inexistant sur le syst&egrave;me de fichier";
$owl_lang->err_file_too_big             = "php.ini upload_max_filesize d&eacute;pass&eacute;e et/ou<BR>Taille maximale autoris&eacute;e dans Owl d&eacute;pass&eacute;e";
$owl_lang->err_file_update              = "La mise &agrave; jour d'un fichier n&eacute;cessite le m&ecirc;me nom de fichier";
$owl_lang->err_fileexists               = "D&eacute;placement annul&eacute;<BR>Un fichier avec le m&ecirc;me nom existe d&eacute;j&agrave;.";
$owl_lang->err_folder_create            = "Erreur dans la cr&eacute;ation du dossier";
$owl_lang->err_folder_exist             = "dossier d&eacute;j&agrave; existant";
$owl_lang->err_folderexists             = "Impossible de renommer<BR>Un dossier avec le m&ecirc;me nom existe.";
$owl_lang->err_general                  = "Une erreur s'est produite";
$owl_lang->err_group_delete             = "Vous ne pouvez pas supprimer un groupe contenant des membres";
$owl_lang->err_group_exists             = "Groupe d&eacute;j&agrave; existant";
$owl_lang->err_gzip_not_found           = "gzip n'a pu &ecirc;tre trouv&eacute; dans ";
$owl_lang->err_login                    = "Vous devez &ecirc;tre connect&eacute; pour poser cette action";
$owl_lang->err_movecancel               = "D&eacute;placement annul&eacute;<BR>";
$owl_lang->err_nameempty                = "Le nom du dossier ne peut pas &ecirc;tre vide";
$owl_lang->err_news_required            = "ERREUR: Un titre de nouvelles et un contenu sont requis!";
$owl_lang->err_no_access                = "Vous n'avez pas les droits n&eacute;cessaires sur les fichiers s&eacute;lectionn&eacute;s";
$owl_lang->err_no_access_info           = "Possible causes: <br></br>1) You did not click any checkbox in front of a File or Folder<br></br>2) Bulk Delete, Bulk Email, Bulk Checkout do not apply to Folders<br></br>3) You do not have access to any of the files or folders you have selected.";
$owl_lang->err_noemail                  = "Vous n'&ecirc;tes pas autoris&eacute; &agrave; envoyer ce fichier par email";
$owl_lang->err_nofileaccess             = "Vous n'avez pas acc&egrave;s &agrave; ce fichier";
$owl_lang->err_nofiledelete             = "Vous n'&ecirc;tes pas autoris&eacute; &agrave; supprimer ce fichier";
$owl_lang->err_nofilemod                = "Vous n'&ecirc;tes pas autoris&eacute; &agrave; modifier ce fichier";
$owl_lang->err_nofolderaccess           = "Vous n'avez pas acc&egrave;s &agrave; ce dossier";
$owl_lang->err_nofolderdelete           = "Vous n'&ecirc;tes pas autoris&eacute; &agrave; supprimer ce dossier";
$owl_lang->err_nofoldermod              = "Vous n'&ecirc;tes pas autoris&eacute; &agrave; modifier ce dossier";
$owl_lang->err_nosubfolder              = "Vous n'&ecirc;tes pas autoris&eacute; &agrave; cr&eacute;er des sous-dossiers";
$owl_lang->err_note_title               = "Le Titre est un champ requis";
$owl_lang->err_note_title_exists        = "Une Note du m&ecirc;me nom existe d&eacute;j&agrve;";
$owl_lang->err_noupload                 = "Vous n'&ecirc;tes pas autoris&eacute; &agrave; charger un fichier dans ce dossier";
$owl_lang->err_pass_missmatch           = "Les mots de passe ne correspondent pas";
$owl_lang->err_pass_wrong               = "L'ancien mot de passe est incorrect";
$owl_lang->err_pod2html_not_found       = "ERREUR : l'outil pod2html n'a pas &eacutet&eacute trouv&eacute :";
$owl_lang->err_quota                    = "Vous n'avez pas l'espace disque suffisant pour ins&eacute;rer ce fichier: ";
$owl_lang->err_quota_avail              = " disponible.";
$owl_lang->err_quota_exceed             = "Vous avez d&eacute;pass&eacute; votre quota";
$owl_lang->err_quota_needed             = " n&eacute;cessaire ";
$owl_lang->err_req                      = "ERREUR: Tous les champs sont requis";
$owl_lang->err_root_delete              = "Le r&eacute;pertoire racine ne peut pas &ecirc;tre d&eacute;truit";
$owl_lang->err_sess_notvalid            = "L'identifiant de session n'est pas valide";
$owl_lang->err_sess_write               = "Erreur d'&eacute;criture dans la base de donn&eacute;e";
$owl_lang->err_specialfoldername        = "'backup' est un nom r&eacute;serv&eacute; au programme, veuillez choisir un autre nom";
$owl_lang->err_tar_not_found            = "tar n'a pu &ecirc;tre trouv&eacute; dans ";
$owl_lang->err_trash_can_empty          = "La corbeille est vide";
$owl_lang->err_unauthorized             = "Non autoris&eacute;";
$owl_lang->err_unauth_area              = "Vous n'&ecirc;tes pas autoris&eacute; &agrave; utiliser cet espace";
$owl_lang->err_upload                   = "Erreur de chargement";
$owl_lang->err_user_exists              = "Utilisateur d&eacute;j&agrave; existant";
$owl_lang->err_cant_del_doc_type        = "Suppression actuellement impossible";
$owl_lang->err_doc_type_name_req        = "Nom du document requis <BR>";
$owl_lang->err_doc_field_req            = "Manque le champ:";
$owl_lang->err_field_name_req           = "Le nom du chmap est requis <BR>";
$owl_lang->err_field_label_req          = "Le label du champ est requis <BR>";
$owl_lang->err_field_size_req           = "La taille du champ est requise <BR>";
$owl_lang->err_forbidden_file		= "Type de fichier interdit";
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
$owl_lang->alt_reset_form	= "Remettre à z&eacute;ro";
$owl_lang->alt_add_comments     = "Ajouter un commentaire &agrave; ce fichier";
$owl_lang->alt_btn_add_file     = "Charger un nouveau fichier";
$owl_lang->alt_btn_add_folder   = "Cr&eacute;er un nouveau dossier";
$owl_lang->alt_add_group        = "Cr&eacute;er le groupe";
$owl_lang->alt_add_news         = "Ajouter une Nouvelle";
$owl_lang->alt_add_user         = "Cr&eacute;er un utilisateur";
$owl_lang->alt_btn_add_note     = "Ajouter une Note";
$owl_lang->alt_btn_add_url      = "Cr&eacute;er un nouveau lien Web";
$owl_lang->alt_cancel           = "Cancle This Action";
$owl_lang->alt_cancel_move      = "Annuler le d&eacute;placement";
$owl_lang->alt_change           = "Mettre &agrave; jour l'enregistrement";
$owl_lang->alt_btn_clickhere    = "Cliquez ici";
$owl_lang->alt_btn_collapse_view= "Vue r&eacute;duite";
$owl_lang->alt_comments         = "Commentaires existants pour ce fichier";
$owl_lang->alt_del_comments     = "Supprimer le commentaire";
$owl_lang->alt_del_file         = "Supprimer le fichier (O/N)";
$owl_lang->alt_del_folder       = "Supprimer le dossier (O/N)";
$owl_lang->alt_del_group        = "Supprimer le groupe";
$owl_lang->alt_del_news         = "Effacer cette nouvelle";
$owl_lang->alt_del_selected     = "Supprimer les fichiers s&eacute;lectionn&eacute;s";
$owl_lang->alt_del_all          = "Empty Trash";
$owl_lang->alt_rest_selected    = "Restore all Selected Files";
$owl_lang->alt_del_this_folder  = "Supprimer le dossier &#8211; ";
$owl_lang->alt_del_user         = "Supprimer cet Utilisateur";
$owl_lang->alt_edit_group       = "&eacute;diter le groupe s&eacute;lectionn&eacute;";
$owl_lang->alt_edit_news        = "Editer les Nouvelles";
$owl_lang->alt_edit_user        = "&eacute;diter utilisateur s&eacute;lectionn&eacute;";
$owl_lang->alt_email            = "Envoyer ce fichier";
$owl_lang->alt_email_selected   = "Envoyer tous les fichiers s&eacute;lectionn&eacute;s"; 
$owl_lang->alt_btn_expand_view  = "Passer en vue &eacute;tendue";
$owl_lang->alt_admin_flush      = "Vider les sessions expir&eacute;es";
$owl_lang->alt_get_file         = "T&eacute;l&eacute;charger le fichier";
$owl_lang->alt_get_folder       = "Download Folder Content";
$owl_lang->alt_have_news        = "Nouvelle(s) &agrave; lire";
$owl_lang->alt_have_no_news     = "Aucune(s) nouvelle(s) &agrave; lire";
$owl_lang->alt_home_folder      = "Retour au r&eacute;pertoire racine ";
$owl_lang->alt_set_initial_dir  = "Fixer le r&eacute;pertoire de racine ici";                                                                                                
$owl_lang->alt_site_map         = "Carte du site";
$owl_lang->alt_lock_file        = "Verrouill&eacute;/D&eacute;verrouill&eacute; ";
$owl_lang->alt_log_clear        = "Supprimer les fichiers de log (O/N)";
$owl_lang->alt_log_file         = "Fichier de log";
$owl_lang->alt_log_next         = "Afficher les enregistrements suivants";
$owl_lang->alt_log_prev         = "Afficher les enregistrements pr&eacute;c&eacute;dents";
$owl_lang->alt_log_top          = "Aller au premier enregistrement";
$owl_lang->alt_btn_login        = "Se connecter &agrave; Owl Intranet";
$owl_lang->alt_btn_logout       = "Se d&eacute;connecter de Owl Intranet";
$owl_lang->alt_btn_help		= "Aide en ligne";
$owl_lang->alt_mod_file         = "Modifier les propri&eacute;t&eacute;s du fichier";
$owl_lang->alt_mod_folder       = "Modifier les propri&eacute;t&eacute;s du dossier";
$owl_lang->alt_move_file        = "D&eacute;placer le fichier";
$owl_lang->alt_copy_file     	= "Copier le fichier";
$owl_lang->alt_link_file        = "Link This File to Another Directory";
$owl_lang->alt_move_folder      = "D&eacute;placer le dossier";
$owl_lang->alt_copy_folder   	= "Copier le dossier";
$owl_lang->alt_move_selected    = "D&eacute;placer tous les fichiers s&eacute;lectionn&eacute;s"; 
$owl_lang->alt_admin_groups     = "Cr&eacute;er un Nouveau Groupe";
$owl_lang->alt_news_close       = "Fermer la fen&ecirc;tre de nouvelle";
$owl_lang->alt_news_next        = "Afficher la nouvelle suivante";
$owl_lang->alt_news_prev        = "Afficher la nouvelle pr&eacute;c&eacute;dente";
$owl_lang->alt_news_print       = "Imprimer cette nouvelle";
$owl_lang->alt_admin_users      = "Cr&eacute;er un Nouvel Utilisateur";
$owl_lang->alt_monitor          = "Surveiller ce fichier";
$owl_lang->alt_monitored        = "Arr&ecirc;ter la surveillance du fichier";
$owl_lang->alt_btn_admin        = "Administration Owl";
$owl_lang->alt_play_file        = "Jouer le fichier M&ecatute;dia";
$owl_lang->alt_recycle          = "Votre corbeille est vide";
$owl_lang->alt_recycle_disable  = "La corbeille a &eacute;t&eacute; d&eacute;sactiv&eacute;";
$owl_lang->alt_recycle_not_found= "Emplacement de la corbeille introuvable";
$owl_lang->alt_refresh_filter   = "Activer les filtres / Rafraîchir les r&eacute;sultats";
$owl_lang->alt_register         = "Inscription";
$owl_lang->alt_btn_browse       = "Retour &agrave; l'Explorateur";
$owl_lang->alt_search           = "Lancer la recherche";
$owl_lang->alt_send_email       = "Envoyer le mail";
$owl_lang->alt_sendfile         = "Envoyer le fichier";
$owl_lang->alt_toggle_check_box = "Cocher / D&eacute;cocher les cases &agrave; cocher";
$owl_lang->alt_unlock_file      = "D&eacute;verrouill&eacute;";
$owl_lang->alt_upd_file         = "Mise &agrave; jour du fichier";
$owl_lang->alt_view_comments    = "Ajouter / Voir les commentaires du fichier";
$owl_lang->alt_view_file        = "Voir le fichier";
$owl_lang->alt_edit_field       = "Editer cette d&eacute;finition de champ";
$owl_lang->alt_del_field        = "Supprimer ce champ";
$owl_lang->alt_add_field        = "Ajouter le champ ci-dessus";
$owl_lang->alt_deldoctype       = "Supprimer le type de document courant";
$owl_lang->alt_upd_field        = "Mettre ce champ &agrave; jour";
$owl_lang->alt_new_doctype      = "Cr&eacute;er un nouveau type de document";
$owl_lang->alt_related		= "Trouver les documents en rapport";
$owl_lang->alt_back             = "Return To Previous Screen";
$owl_lang->alt_submit           = "Submit Form";

//********************************************************
// Image Alternate popup Messages END
//********************************************************


//********************************************************
// Owl Logging messages BEGIN
//********************************************************

$owl_lang->log_del_det          = "Tout le contenu a &eacute;t&eacute; supprim&eacute;";
$owl_lang->log_detail           = "Aucuns d&eacute;tails suppl&eacute;mentaires";
$owl_lang->log_file_to          = "A: ";
$owl_lang->log_filter_all       = "TOUS";
$owl_lang->log_login_det        = "Utilisateur: ";
$log_file_actions[1]            = "CONNEXION";
$log_file_actions[2]            = "ECHEC DE LA CONNEXION";
$log_file_actions[3]            = "DECONNEXION";
$log_file_actions[4]            = "FICHIER SUPPRIM&#201;";
$log_file_actions[5]            = "FICHIER CHARG&#201;";
$log_file_actions[6]            = "FICHIER MIS A JOUR";
$log_file_actions[7]            = "FICHIER T&#201;L&#201;CHARG&#201;";
$log_file_actions[8]            = "FICHIER CHANG&#201;";
$log_file_actions[9]            = "FICHIER VERROUILL&#201;";
$log_file_actions[10]           = "FICHIER D&#201;VERROUILL&#201;";
$log_file_actions[11]           = "FICHIER ENVOY&#201;";
$log_file_actions[12]           = "FICHIER D&#201;PLAC&#201;";
$log_file_actions[13]           = "DOSSIER CR&#201;E";
$log_file_actions[14]           = "DOSSIER SUPPRIM&#201;";
$log_file_actions[15]           = "DOSSIER MODIFI&#201;";
$log_file_actions[16]           = "DOSSIER D&#201;PLAC&#201;";
$log_file_actions[17]           = "MOT DE PASSE OUBLI&#201;";
$log_file_actions[18]           = "INSCRIPTION";                                                                                                                                       
$log_file_actions[19]           = "FICHIER VU";
$log_file_actions[20]           = "FICHIER VIRUSS&#201;";
$log_file_actions[21]           = "FICHIER COPI&#201;";
$log_file_actions[22]           = "FOLDER COPIED";
$log_file_actions[23]           = "FILE_LINKED";

//********************************************************
// Owl Logging messages END
//********************************************************


//********************************************************
// index.php  BEGIN
//********************************************************

$owl_lang->anonymous         = "(Acc&egrave;s Anonyme)";
$owl_lang->repository_list      = "Repository:";
$owl_lang->engine            = "Owl Intranet Engine";
$owl_lang->forgot_pass       = "Vous avez oubliez votre mot de passe?";
$owl_lang->like_register     = "Voulez-vous vous inscrire?";
$owl_lang->login             = "Connexion";
$owl_lang->loginfail         = "Erreur de connexion";
$owl_lang->logindisabled     = "Ce compte a &eacute;t&eacute; SUSPENDU, veuillez contacter l'administrateur";
$owl_lang->password          = "Mot de passe";
$owl_lang->successlogout     = "Vous &ecirc;tes bien d&eacute;connect&eacute;";
$owl_lang->toomanysessions   = "Nombre maximum de sessions atteint pour l'utilisateur, contactez l'Administrateur";
$owl_lang->username          = "Utilisateur";
$owl_lang->version           = "Version";

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
$owl_lang->actions                      = "Actions";
$owl_lang->del_selected                 = "Effacer";
$owl_lang->del_all                      = "Empty Trash";
$owl_lang->rest_selected                = "Restore Selected";
$owl_lang->disk_quota                   = "Capacit&eacute; du Disque";
$owl_lang->email_selected               = "Envoyer par email";
$owl_lang->file                         = "Fichier";
$owl_lang->folder_policy                = "Droits du R&eacute;pertoire courant:";
$owl_lang->current_folder 		= "Dossier en cours:";
$owl_lang->held                         = "Tenu par"; // for version control
$owl_lang->last_logged                  = "Ma derni&egrave;re connexion: ";
$owl_lang->current_db                   = "Current Repository:";
$owl_lang->modified                     = "Derni&egrave;re modification";
$owl_lang->move_selected                = "D&eacute;placer";
$owl_lang->new_file                     = "New!";
$owl_lang->no_description               = "Aucune description";
$owl_lang->page                         = "Page:";
$owl_lang->postedby                     = "Envoy&eacute; par";
$owl_lang->reallydelete                 = "Voulez-vous vraiment supprimer ";
$owl_lang->reallydelete_logs            = "Souhaitez-vous vraiment vider le fichier de log";
$owl_lang->reallydelete_selected        = "Souhaitez-vous vraiment effacer les fichiers s&eacute;lectionn&eacute;s";
$owl_lang->reallyrestore_selected       = "Really Restore all selected files";
$owl_lang->size                         = "Taille";
$owl_lang->score                        = "Score";
$owl_lang->title                        = "Titre";
$owl_lang->doc_number 			= "Doc #";
$owl_lang->tot_files                    = "Total:";
$owl_lang->tot_my_checked_out           = "V&eacute;rifi&eacute; :";
$owl_lang->tot_my_files                 = "Mes fichiers:";
$owl_lang->tot_my_group                 = "Groupe:";
$owl_lang->tot_new_files                = "Nouveaut&eacute;s:";
$owl_lang->tot_updated_files            = "Mises &agrave; jour:";
$owl_lang->tot_monitored		= "Monitor&eacute; :";
$owl_lang->updated_file                 = "Mises &agrave; jour!";
$owl_lang->user                         = "Utilisateur";
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
$owl_lang->adding_comments      = "Ajouter / Voir les commentaires: ";
$owl_lang->comments      	= "Commentaires";
$owl_lang->post_comment		= "Ajouter un commentaire";
$owl_lang->addingfile           = "Ajout d'un fichier &agrave; ";
$owl_lang->addingfolder         = "Ajout d'un dossier &agrave; ";
$owl_lang->attach_file          = "Attacher un fichier";
$owl_lang->change               = "Changer";
$owl_lang->create               = "Cr&eacute;er";
$owl_lang->comments_added       = "Commentaires ajout&eacute; par: ";
$owl_lang->description          = "Description";
$owl_lang->email_body           = "Message";
$owl_lang->email_cc             = "Copie";
$owl_lang->email_reply_to       = "Adresse de r&eacute;ponse";
$owl_lang->email_subject        = "Objet";
$owl_lang->email_to             = "Destinataire";
$owl_lang->emailing             = "Email";
$owl_lang->disp_mp3             = "MP3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Chanson:<BR>Album:<BR>Bitrate&nbsp;-&nbsp;Samplerate:<BR>Dur&eacute;e:<BR>Genre:<BR>Commentaires:";
$owl_lang->keywords             = "Mots Cl&eacute;s";
$owl_lang->modify_url           = "URL";
$owl_lang->modifying            = "Modification ";
$owl_lang->name                 = "Nom";                                                                                                                                                   
$owl_lang->notify_link          = "Lien externe &agrave; OWL";
$owl_lang->note_content         = "Contenu de la note";
$owl_lang->ownergroup           = "Groupe Propri&eacute;taire";
$owl_lang->ownership            = "Propri&eacute;taire";
$owl_lang->permissions          = "Permissions";                                                                                                                        
$owl_lang->prop_permissions     = "Propager les Permissions aux sous-r&eacute;pertoires ?";
$owl_lang->prop_perms_files     = "Droits &agrave; donner aux fichiers propag&eacute;s:";
$owl_lang->policy               = "Droits";
$owl_lang->pick_select          = "&#8212; S&eacute;lectionnez un Utilisateur Owl &#8212;";
$owl_lang->sendfile             = "Envoi fichier";
$owl_lang->sendthisfile         = "Envoyer ce fichier";
$owl_lang->sendthisurl          = "Envoyer cette URL";
$owl_lang->updating             = "Mise &agrave; jour";
$owl_lang->verdescription       = "Description<br></br>des changements";
$owl_lang->vermajor             = "R&eacute;vision majeure";
$owl_lang->verminor             = "R&eacute;vision mineure";
$owl_lang->vertype              = "R&eacute;vision";  // for modify.php when uploading

//********************************************************
// modify.php  END
//********************************************************


//********************************************************
// register.php  BEGIN
//********************************************************
                                                                                                       
$owl_lang->email         = "Email";
$owl_lang->full_name     = "Nom complet";
$owl_lang->register      = "Enregistrement de l'utilisateur";
$owl_lang->self_failed   = "Echec";
$owl_lang->self_passwd   = "Mot de passe envoy&eacute; &agrave;:";
$owl_lang->self_reg_bod  = "Votre mot de passe Owl est:";
$owl_lang->self_reg_rset = "Votre ancien mot de passe a &eacute;t&eacute; chang&eacute; pour:";
$owl_lang->self_reg_subj = "Votre compte Owl";
$owl_lang->send_pass     = "Envoyer le mot de passe";
$owl_lang->submit        = "Enregistrement";
$owl_lang->thank_you_1   = "Merci!";
$owl_lang->thank_you_2   = "Un email/sbin/e-smith/expand-template vous sera envoy&eacute; <BR> avec un nouveau mot de passe pour <BR><b>l'utilisateur :</b>";

//********************************************************
// register.php  END
//********************************************************


//********************************************************
// move.php  BEGIN
//********************************************************

$owl_lang->cancel_button     = "Annuler";
$owl_lang->moving            = "D&eacute;placer";
$owl_lang->moving_file		= "D&eacute;placer un fichier";
$owl_lang->moving_folder	= "D&eacute;placer un dossier";
$owl_lang->copy_file		= "Copier un fichier";
$owl_lang->copy_folder		= "Copier un dossier";
$owl_lang->select            = "Veuillez s&eacute;lectionner un nouveau dossier:";

//********************************************************
// move.php  END
//********************************************************


//********************************************************
// log.php  BEGIN
//********************************************************

$owl_lang->viewlog           = "Visualiser le log de ";

//********************************************************
// log.php  END
//********************************************************


//********************************************************
// prefs.php  BEGIN
//********************************************************

$owl_lang->confpassword = "Confirmez le nouveau mot de passe";
$owl_lang->comment_notif= "Commentez la Notification";
$owl_lang->email_tool   = "E-Mail Tool";
$owl_lang->last_modified= "Last Modified";
$owl_lang->group        = "Groupe Primaire";
$owl_lang->groupmember  = "Groupe Membre";
$owl_lang->newpassword  = "Nouveau mot de passe";
$owl_lang->newsadmin    = "Administrateur de Nouvelles";
$owl_lang->not_member   = "Vous n'&ecirc;tes membre d'aucun autre groupe";
$owl_lang->notification = "Recevoir des notifications";
$owl_lang->oldpassword  = "Ancien mot de passe";
$owl_lang->preference   = "Pr&eacute;f&eacute;rences";
$owl_lang->saved        = "Modifications sauvegard&eacute;es";
$owl_lang->status_no    = "NON";
$owl_lang->status_yes   = "OUI";
$owl_lang->userlang     = "Langue";

//********************************************************
// prefs.php  END
//********************************************************


//********************************************************
// search.php  BEGIN
//********************************************************

$owl_lang->elapsed_time         = "Temps pass&eacute;";
$owl_lang->search               = "Recherche";
$owl_lang->search_any_word      = "Au moins un mot";
$owl_lang->search_all_word      = "Tous les mots";
$owl_lang->search_entire_phrase = "Expression exacte";
$owl_lang->search_match         = "Type de recherche:";
$owl_lang->search_currentfolder = "Recherche dans le dossier courant";
$owl_lang->search_for_folders   = "Recherche de Dossiers";
$owl_lang->search_for_files     = "Recherche de Fichiers";
$owl_lang->search_score         = "Fichiers trouv&eacute;s";
$owl_lang->search_results_for   = "R&eacute;sultats de recherche pour";
$owl_lang->search_winthindocs   = "Recherche dans les documents (text, pdf et MS-Word)";
$owl_lang->related_query_empty  = "No metadata associated with document to perform 'Search Related'";
$owl_lang->query_empty          = "Le champ de recherche est vide";

//********************************************************
// search.php  END
//********************************************************


//********************************************************
// view.php  BEGIN
//********************************************************

$owl_lang->viewing           = "Visualiser ";

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
$owl_lang->btn_users_groups		= "Utilisateurs<br></br>et groupes";
$owl_lang->alt_users_groups		= "Administrer les utilisateurs et les groupes";
$owl_lang->btn_html_prefs		= "Pr&eacute;f&eacute;rences<br></br>HTML";
$owl_lang->alt_html_prefs		= "Edit Site HTML Preferences";
$owl_lang->btn_site_features		= "Configuration<br></br>Site";
$owl_lang->alt_site_features		= "Modification de la configuration du site";
$owl_lang->btn_log_viewer		= "Voir les logs";
$owl_lang->alt_log_viewer		= "Visualisation des logs";
$owl_lang->btn_statistics_viewer	= "Voir les stats";
$owl_lang->alt_statistics_viewer	= "Visualisation des statistiques";
$owl_lang->btn_news_admin		= "Administration<br></br>des news";
$owl_lang->alt_news_admin		= "Administration des news";
$owl_lang->btn_doctype_admin		= "Types de<br></br>documents";
$owl_lang->alt_doctype_admin		= "Gestion des types de documents";
$owl_lang->btn_backup			= "Sauvegarde<br></br>base SQL";
$owl_lang->alt_backup			= "Sauvegarde de la base de donn&eacute;es SQL";
$owl_lang->btn_trashcan			= "Corbeille";
$owl_lang->alt_trashcan			= "Visualiser la corbeille";
$owl_lang->btn_initial_load		= "Chargement<br></br>initial";
$owl_lang->alt_initial_load		= "Chargement de la base SQL depuis le r&eacute;pertoire";
$owl_lang->confirm_initial_load		= "*** ATTENTION *** Ne le faire que lorsque la base est vide";
$owl_lang->add                          = "Ajouter";
$owl_lang->anonymous_account            = "Compte d'Acc&egrave;s Anonyme:";                                                                                                                      
$owl_lang->buttonstyle                  = "Style des boutons";
$owl_lang->deletegroup                  = "Supprimer un groupe";
$owl_lang->deleteuser                   = "Supprimer un utilisateur";
$owl_lang->disableuser                  = "D&eacute;sactiver utilisateur";
$owl_lang->disable_recs_per_page        = "Activer la vue restreinte d&eacture;sactivera l'affichage des enregistrements par page!";
$owl_lang->file_admin_group             = "Groupe Admin pour Fichier/Explorateur:";
$owl_lang->flushed                      = "Table des sessions vid&eacute;e, l'utilisateur peut &agrave; nouveau se connecter.<BR>";
$owl_lang->groups                       = "Groupes";
$owl_lang->hide_bulk_buttons            = "Masquer les boutons d'actions group&eacute;s:";
// Edit HTML Properties Messages
$owl_lang->ht_tbl_border_sz             = "Taille de la bordure du Tableau:";
$owl_lang->ht_tbl_hd_bg                 = "Arri&egrave;re-plan de l'Ent&ecirc;te:";
$owl_lang->ht_tbl_cell_bg_cl            = "Couleur d'arri&egrave;re-plan des cellules:";
$owl_lang->ht_tbl_cell_bg_al            = "Couleur d'arri&egrave;re-plan des cellules 2:";
$owl_lang->ht_expand_width              = "Largeur de la vue &eacute;tendue:";
$owl_lang->ht_collapse_width            = "Largeur de la vue r&eacute;duite:";
$owl_lang->ht_bd_bg_image               = "Chemin de l'image d'arri&egrave;re-plan:";
$owl_lang->ht_bd_txt_cl                 = "Couleur du texte:";
$owl_lang->ht_bd_lnk_cl                 = "Couleur des liens:";
$owl_lang->ht_bd_vlnk_cl                = "Couleur des liens visit&eacute;s:";
// Edit Prefs Properties Messages
$owl_lang->home_dir                     = "Dossier de base de l'utilisateur";
$owl_lang->initial_dir                  = "User's Initial Directory";
$owl_lang->maxsessions                  = "Nombre Max. de sessions";
$owl_lang->noprefaccess                 = "D&eacute;sactiver les pr&eacute;f&eacute;rences";
$owl_lang->owl_anon_full                = "Full Access";
$owl_lang->owl_anon_ro                  = "Les acc&egrave;s anonymes sont en lecture seul:";
$owl_lang->owl_anon_download            = "Download Only";
$owl_lang->anonymous_access             = "Set Anonymous Access";
$owl_lang->owl_dbdump_path              = "Chemin de l'outil de sauvegarde de la base:";
$owl_lang->owl_def_file_group_owner     = "Groupe propri&eacute;taire par d&eacute;faut:";
$owl_lang->owl_def_file_meta            = "M&eacute;ta-donn&eacute;e de fichier par d&eacute;faut:";
$owl_lang->owl_def_file_owner           = "Propri&eacute;taire de fichier par d&eacute;faut:";
$owl_lang->owl_def_file_perm            = "Attributs de cr&eacute;ation de fichier par d&eacute;faut:";
$owl_lang->owl_def_file_security        = "S&eacute;curit&eacute; de fichier par d&eacute;faut:";
$owl_lang->owl_def_file_title           = "Nom de fichier par d&eacute;faut (Aucun si m&ecirc;me nom):";
$owl_lang->owl_def_fold_group_owner     = "Groupe propri&eacute;taire de dossier par d&eacute;faut:";
$owl_lang->owl_def_fold_owner           = "Propri&eacute;taire de dossier par d&eacute;faut:";
$owl_lang->owl_def_fold_sec             = "S&eacute;curit&eacute; de dossier par d&eacute;faut:";
$owl_lang->owl_def_folder_perm          = "Attributs de cr&eacute;ation de dossier par d&eacute;faut:";
$owl_lang->owl_default_tmpdir           = "Emplacement du r&eacute;pertoire 'Temp': ";
$owl_lang->owl_email_from               = "Email de l'exp&eacute;diteur / Connexion SMTP:";
$owl_lang->owl_email_fromname           = "Nom de l'exp&eacute;diteur:";
$owl_lang->owl_email_replyto            = "Email de r&eacute;ponse:";
$owl_lang->owl_email_server             = "Serveur SMTP:";
$owl_lang->owl_email_smtp               = "Utiliser l'envoi par SMTP";
$owl_lang->owl_email_smtp_auth          = "Utiliser l'identification par SMTP";
$owl_lang->owl_email_smtp_auth_login    = "SMTP Auth Login:";
$owl_lang->owl_email_smtp_auth_passwd   = "Mot de passe SMTP";
$owl_lang->owl_email_subject_pref       = "Pr&eacute;fixe d'objet:";
$owl_lang->owl_fogotpass                = "Afficher le lien 'Mot de passe oubli&eacute;':";
$owl_lang->owl_group_user               = "Utilsateurs membres de ce groupe";
$owl_lang->owl_gzip_path                = "Chemin vers gzip:";
$owl_lang->owl_hidebackup               = "Cacher le dossier des sauvegardes:";
$owl_lang->owl_log_file                 = "Loguer les activit&eacute;s de fichiers:";
$owl_lang->owl_log_login_act            = "Loguer les activit&eacute;s de connexion/d&eacute;connexion:";
$owl_lang->owl_log_rec_page             = "Nbre d'enregistrements par page de Log:";
$owl_lang->owl_logging                  = "Autorisez la gestion des logs:";
$owl_lang->owl_logo                     = "Logo de la page de connexion ([Langue]/graphics):";
$owl_lang->owl_lookAtHD                 = "D&eacute;sactiver la surveillance du HD:";
$owl_lang->owl_lookAtHDDel              = "Retirer les fichiers supprim&eacute;s de la BD:";
$owl_lang->hide_folder_doc_count        = "Hide Folder File Type Count";                                                                                                                        
$owl_lang->hide_folder_size             = "Hide Folder Content Size";
$owl_lang->old_action_icons             = "Use pre Owl 0.80 Action Icons";
$owl_lang->search_result_folders        = "Include Folders in Search Results";
$owl_lang->restore_file_prefix          = "String Prefixed to Restored Files";
$owl_lang->owl_max_filesize             = "Taille maximale pour l'envoi d'un fichier:";
$owl_lang->owl_owl_expand               = "Vue par d&eacute;faut de l'explorateur (&eacute;largie):";
$owl_lang->owl_owl_timeout              = "Dur&eacute;e max. d'une session:";
$owl_lang->virus_path                   = "Virus Checking Software Path<br />Example: '/usr/bin/clamscan --quiet' <br />&#8211; Blank for Disabled:";
$owl_lang->owl_pdftotext_path           = "Maintenir l'index de recherche pour <BR>les fichiers PDF et textes <BR>&#8211; Laisser vide pour d&eacute;sactiver:";
$owl_lang->owl_wordtotext_path          = "les fichier MS-WORD <BR>&#8211;  Laisser vide pour d&eacute;sactiver:";
$owl_lang->owl_pod2html_path            = "Perl 5.8.0 ou plus r&eacute;cent requis<BR>Chemin vers pod2html:";
$owl_lang->owl_restrict_view            = "Autoriser la vue restreinte:";
$owl_lang->owl_self_reg                 = "Autorisez l'enregistrement automatique:";
$owl_lang->owl_self_reg_hd              = "ENREGISTREMENT AUTOMATIQUE";
$owl_lang->owl_tar_path                 = "Chemin vers tar:";
$owl_lang->owl_title_custom             = "CUSTOMIZE BROWSER COLUMNS";
$owl_lang->owl_title_custom_search      = "CUSTOMIZE SEARCH RESULTS";
$owl_lang->owl_title_browser            = "PARAM&#200;TRES DE L'EXPLORATEUR OWL";
$owl_lang->owl_title_defaults           = "ATTRIBUTS PAR D&#201;FAUT";
$owl_lang->owl_title_email              = "PARAMETRES EMAIL DE OWL";
$owl_lang->owl_title_HD                 = "PARAMETRES DE SURVEILLANCE DU HD POUR LES NOUVEAUX FICHIERS";
$owl_lang->owl_title_logging            = "CONFIGURATION DES LOGS";
$owl_lang->owl_title_other              = "CONFIGURATION G&#201;N&#201;RALE";
$owl_lang->owl_title_tools              = "OUTILS DE SAUVEGARDE DE LA BASE";
$owl_lang->owl_unzip_path               = "Chemin vers unzip:";
$owl_lang->owl_version_control          = "Autoriser le contrôle de version:";
$owl_lang->quota                        = "Capacit&eacute; 0=D&eacute;sactiv&eacute;";
$owl_lang->reallydeluser                = "Cet utilisateur poss&egrave;de %numfiles% Fichier(s) et %numfolders% Dossier(s). Ce(s) Fichier(s) et ce(s) Dossier(s) devienfront orphelins. Etes-vous toujours d'accord pour supprimer cet utilisateur ?";
$owl_lang->recs_per_page                = "Affiche le nombre d'enregistrement par Page (0= non actif):";
$owl_lang->remember_me_title            = "PARAMETRES DE LOGIN PERSISTANT";
$owl_lang->remember_me                  = "Affiche le lien 'Souvenez-vous de moi'";
$owl_lang->remember_timeout             = "Dur&eacute;e de vie du Cookie en jours";
$owl_lang->remember_me_checkbox         = "Souvenez-vous de moi";
$owl_lang->recycle_title                = "PARAM&#200;TRES DE LA CORBEILLE";
$owl_lang->recycle_enabled              = "Activer la corbeille:";
$owl_lang->recycle_location             = "Emplacement de la Corbeille:";
$owl_lang->show_panel_title             = "Display Status Panel:";
$owl_lang->show_search_title            = "Display Search Bar:";
$owl_lang->show_pref_title              = "Display Pref/logout Bar:";
$owl_lang->show_bulk_title              = "Display Bulk Buttons:";
$owl_lang->show_action_title            = "Display action Buttons:";
$owl_lang->show_folder_title            = "Display Folder Tools:";
$owl_lang->show_panel                   = "Show";
$owl_lang->hide_panel                   = "Hide";
$owl_lang->status_bar_both              = "Les Deux";
$owl_lang->status_bar_bottom            = "En bas";
$owl_lang->status_bar_location          = "Afficher la barre d'&eacute;tat :";
$owl_lang->status_bar_top               = "En haut";
$owl_lang->status_bar_not               = "Do Not Display";
$owl_lang->use_popup                    = "Utilser les 'popup' pour afficher les nouvelles:";
$owl_lang->users                        = "Utilisateurs";
$owl_lang->header_user_admin            = "User Administration";
$owl_lang->header_group_admin           = "Group Administration";
$owl_lang->header_sitefeatures_settings           = "Site Features and Settings";

//********************************************************
// admin/index.php  END
//********************************************************


//********************************************************
// admin/log.php  BEGIN
//********************************************************

$owl_lang->owl_log_viewer       = "Visualisateur de LOG";
$owl_lang->owl_log_hd_action    = "Action";
$owl_lang->owl_log_hd_file      = "Fichier";
$owl_lang->owl_log_hd_fld_path  = "Chemin de dossier";
$owl_lang->owl_log_hd_user      = "Utilisateur";
$owl_lang->owl_log_hd_dt_tm     = "Date/Heure";
$owl_lang->owl_log_hd_ip        = "Adresse IP";
$owl_lang->owl_log_hd_agent     = "Agent";
$owl_lang->owl_log_hd_dtls      = "D&eacute;tails";
$owl_lang->owl_log_no_rec       = " AUCUN ENREGISTREMENT TROUV&#201; ";
$owl_lang->owl_log_hide         = "Cacher: ";
$owl_lang->owl_log_filter       = "Filtre";

//********************************************************
// admin/log.php  END
//********************************************************


//********************************************************
// admin/recycle.php  BEGIN
//********************************************************

$owl_lang->empty_trash          = "Vider la corbeille";
$owl_lang->really_empty_trash   = "Voulez-vous vraiment vider la corbeille?";
$owl_lang->recycle_bin_admin    = "Administration de la corbeille";

//********************************************************
// admin/recycle.php  END
//********************************************************


//********************************************************
// lib/owl.lib.php  BEGIN
//********************************************************

$owl_lang->file_size_byte                       = "b";
$owl_lang->file_size_gigabyte                   = "go";
$owl_lang->file_size_kilobyte                   = "ko";
$owl_lang->file_size_megabyte                   = "mo";
$owl_lang->notif_subject_new                    = "Ajout d'un nouveau fichier sur le serveur";
$owl_lang->notif_subject_upd                    = "Mise &agrave; jour d'un fichier sur le serveur";
$owl_lang->notif_subject_monitor                = "Un fichier surveill&eacute; a &eacute;t&eacute; modifi&eacute;";
$owl_lang->notif_subject_comment                = "Un fichier OWL Intranet -- Commentaire Ajout&eacute;";
$owl_lang->notif_comment_1                      = "comment&eacute; le";
$owl_lang->notif_comment_2                      = "Commentaire:";
$owl_lang->notif_msg                            = "CECI EST UN MESSAGE AUTOMATIQUE<BR><BR>Veuillez trouver ci-joint, le fichier ajout&eacute; ou mis &agrave; jour<BR><BR>";
$owl_lang->notif_msg_link               = "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet<BR><BR>Find a link to a new/updated file in this E-Mail<BR><BR>";
$owl_lang->notif_msg_alt_link           = "THIS IS AN AUTOMATED MESSAGE FROM OWL Intranet\n\nFind a link to a new/updated file in this E-Mail\n\n";
$owl_lang->notif_msg_alt                        = "CECI EST UN MESSAGE AUTOMATIQUE\n\nVeuillez trouver ci-joint, le fichier ajout&eacute; ou mis &agrave; jour\n\n";
$owl_lang->notif_salutation                     = "Cher";
$owl_lang->notif_user                   = "Created/Update by:";
$owl_lang->owl_path                             = "Chemin du fichier: ";
$owl_lang->sessinuse                            = "Acc&egrave;s refus&eacute;, ce compte est en cours d'utilisation<BR>";
$owl_lang->invalidsess                          = "Index de session invalide, connectez vous depuis la page d'accueil<BR>";
$owl_lang->sesstimeout                          = "Votre session s'est termin&eacute;e, veuillez vous reconnecter<BR>";
$owl_lang->everyoneread                         = "Lecture/T&eacute;l&eacute;chargement par tous";
$owl_lang->everyonewrite                        = "Lecture/Ecriture/T&eacute;l&eacute;chargement par tous";
$owl_lang->everyonewrite_nod                    = "Lecture/Ecriture/T&eacute;l&eacute;chargement par tous, SANS SUPPRESSION";
$owl_lang->groupread                            = "Lecture/T&eacute;l&eacute;chargement par votre groupe";
$owl_lang->groupwrite                           = "Lecture/Ecriture/T&eacute;l&eacute;chargement par votre groupe";
$owl_lang->groupwrite_nod                       = "Lecture/Ecriture/T&eacute;l&eacute;chargement par votre groupe, SANS SUPPRESSION";
$owl_lang->onlyyou                              = "Lecture/Ecriture/T&eacute;l&eacute;chargement par vous seul";
$owl_lang->donothing                            = "Ne rien changer &#8211; laisser permissions en l'&eacute;tat";
$owl_lang->groupwrite_worldread                 = "Votre groupe peut lire/&eacute;crire/t&eacute;l&eacute;charger & tout le monde peut lire";
$owl_lang->groupwrite_worldread_nod             = "Votre groupe peut lire/&eacute;crire/t&eacute;l&eacute;charger (SANS SUPPRIMER) & tout le monde peut lire";
$owl_lang->ggroupwrite_worldread                = "Votre groupe peut ajouter des fichiers et effacer ce r&eacute;pertoire & tout le monde peut voir le contenu";
$owl_lang->ggroupwrite_worldread_nod            = "Votre groupe peut ajouter des fichiers & tout le monde peut voir le contenu, SANS SUPPRESSION";
$owl_lang->everyoneread_ad                      = "Lecture/T&eacute;l&eacute;chargement par tous";
$owl_lang->everyonewrite_ad                     = "Lecture/Ecriture/T&eacute;l&eacute;chargement par tous";
$owl_lang->everyonewrite_ad_nod                 = "Lecture/Ecriture/T&eacute;l&eacute;chargement par tous, SANS SUPPRESSION";
$owl_lang->groupread_ad                         = "Lecture/T&eacute;l&eacute;chargement par le groupe s&eacute;lectionn&eacute;";
$owl_lang->groupwrite_ad                        = "Lecture/Ecriture/T&eacute;l&eacute;chargement par le groupe s&eacute;lectionn&eacute;";
$owl_lang->groupwrite_ad_nod                    = "Lecture/Ecriture/T&eacute;l&eacute;chargement par le groupe s&eacute;lectionn&eacute;, SANS SUPPRESSION";
$owl_lang->onlyyou_ad                           = "Lecture/Ecriture/T&eacute;l&eacute;chargement par vous seul";
$owl_lang->groupwrite_worldread_ad              = "Le groupe s&eacute;lectionn&eacute; peut lire/&eacute;crire/t&eacute;l&eacute;charger & tout le monde peut lire";
$owl_lang->groupwrite_worldread_ad_nod          = "Le groupe s&eacute;lectionn&eacute; peut lire/&eacute;crire/t&eacute;l&eacute;charger (SANS SUPPRIMER) & tout le monde peut lire";
$owl_lang->ggroupwrite_worldread_ad             = "Le groupe s&eacute;lectionn&eacute; peut ajouter des fichiers et effacer ce r&eacute;pertoire & tout le monde peut voir le contenu";
$owl_lang->ggroupwrite_worldread_ad_nod         = "Le groupe s&eacute;lectionn&eacute; peut ajouter des fichiers & tout le monde peut voir le contenu, SANS SUPPRESSION";
$owl_lang->geveryoneread                        = "Lecture du dossier par tous";
$owl_lang->geveryonewrite                       = "T&eacute;l&eacute;chargement et suppression du dossier par tous";
$owl_lang->geveryonewrite_nod                   = "T&eacute;l&eacute;chargement par tous";
$owl_lang->ggroupread                           = "Lecture du dossier par votre groupe";
$owl_lang->ggroupwrite                          = "T&eacute;l&eacute;chargement et suppression du dossier par votre groupe";
$owl_lang->ggroupwrite_nod                      = "T&eacute;l&eacute;chargement du dossier par votre groupe";
$owl_lang->gonlyyou                             = "T&eacute;l&eacute;chargement et suppression du dossier par vous seul";
$owl_lang->geveryoneread_ad                     = "Lecture du dossier par tous";
$owl_lang->geveryonewrite_ad                    = "T&eacute;l&eacute;chargement et suppression du dossier par tous";
$owl_lang->geveryonewrite_ad_nod                = "T&eacute;l&eacute;chargement du dossier par tous";
$owl_lang->ggroupread_ad                        = "Lecture du dossier par le groupe s&eacute;lectionn&eacute;";
$owl_lang->ggroupwrite_ad                       = "T&eacute;l&eacute;chargement et suppression du dossier par le groupe s&eacute;lectionn&eacute;";
$owl_lang->ggroupwrite_ad_nod                   = "T&eacute;l&eacute;chargement du dossier par le groupe s&eacute;lectionn&eacute;";
$owl_lang->gonlyyou_ad                          = "T&eacute;l&eacute;chargement et suppression du dossier par vous seul";
$owl_lang->orphaned                     	= "&#8211; PAS DE PROPRIETAIRE  &#8211;";
$owl_lang->virus_infected               = "VIRUS INFECTED FILE";
$owl_lang->virus_return_val             = "Virus Program Return value:";

//********************************************************
// lib/owl.lib.php  END
//********************************************************


//********************************************************
// HREF TITLE messages  BEGIN
//********************************************************

$owl_lang->title_browse_folder          = "Explorer ce dossier";
$owl_lang->title_browse_site            = "Explorer cette URL";
$owl_lang->title_download_view          = "T&eacute;l&eacute;charger / Visualiser ce fichier";
$owl_lang->title_edit_prefs             = "Visualiser / &eacute;diter les pr&eacute;f&eacute;rences d'utilisateur";
$owl_lang->title_return_folder          = "Retourner vers";
$owl_lang->title_sort                   = "Trier par";
$owl_lang->title_view_new               = "Voir la liste des nouveaux fichiers depuis ma derni&egrave;re visite";
$owl_lang->title_view_updated           = "Voir la liste des fichiers mis &agrave; jour depuis ma derni&egrave;re visite";
$owl_lang->title_view_my                = "Visualiser la liste de mes fichiers";

//********************************************************
// HREF TITLE messages  END
//********************************************************


//********************************************************
// admin/news.php and newsread.php BEGIN
//********************************************************

$owl_lang->news_title                   = "Administration des nouvelles";
$owl_lang->news_hd                      = "Nouvelles";
$owl_lang->news_hd_created              = "Cr&eacute;e le";
$owl_lang->news_hd_expires              = "Expiration le";
$owl_lang->news_hd_audience             = "Public vis&eacute;";
$owl_lang->news_heading                 = "Ent&ecirc;te de nouvelles";
$owl_lang->news_content                 = "Contenu";
$owl_lang->news_posted_date             = "Nouvelles post&eacute;e:";
$owl_lang->news_read                    = "Lue";

//********************************************************
// admin/news.php and newsread.php  END
//********************************************************


//********************************************************
// DEBUG MESSAGES BEGIN
//********************************************************

$owl_lang->debug_tmp_not_exists         = "DEBUG: Le dossier TEMP de OWL: $default->owl_tmpdir n'existe pas.";
$owl_lang->debug_tmp_not_writeable      = "DEBUG: Le dossier TEMP de OWL: $default->owl_tmpdir n'est pas libre en &eacute;criture.";
$owl_lang->debug_doc_not_exists         = "DEBUG: Le dossier documents d'OWL : " .$default->owl_fs_root . "/" . fid_to_name(1) ." n'xiste pas.";
$owl_lang->debug_doc_not_writeable      = "DEBUG: Le dossier documents d'OWL : " .$default->owl_fs_root . "/" . fid_to_name(1) ." n'est pas autoris&eacute en &eacutecriture sur ce serveur.";
$owl_lang->debug_webserver_no_access    = "DEBUG: The webserver does not have read access to: <br />'$default->owl_fs_root/$filename'. <br />Please fix the permissions and try again";
$owl_lang->debug_file_not_exist         = "DEBUG: The required file '$default->owl_fs_root/$filename' does not exists.<br /> OR<br />The path specified by \$default->owl_fs_root in config/owl.php is wrong.";

//********************************************************
// DEBUG MESSAGES END
//********************************************************


//********************************************************
// admin/stats.php BEGIN
//********************************************************

$owl_lang->owl_stats_viewer     = "Visualisateur de Statistiques";
$owl_lang->stats_files          = "Nbre de fichiers par utilisateur";
$owl_lang->stats_folders        = "Nbre de dossiers par utilisateur";
$owl_lang->stats_top            = "Top 20 T&eacute;l&eacute;chargement";
$owl_lang->stats_users          = "USER Signon (Login / Failure / Logout)";
$owl_lang->stats_users_loggedin = "Currently Logged In";
$owl_lang->stats_information    = "Vous devez activer la gestion des logs de connexion et de fichiers pour pouvoir consulter les statistiques";

//********************************************************
// admin/stats.php END
//********************************************************

//********************************************************
// admin/doctype.php BEGIN
//********************************************************

$owl_lang->document_type        = "Type de Document";
$owl_lang->document_type_name   = "Nom du type de Document";
$owl_lang->doc_field_name       = "Nom du champ associ&eacute";
$owl_lang->doc_field_pos        = "Position du champ";
$owl_lang->doc_field_label      = "Label du champ (affich&eacute)";
$owl_lang->doc_field_size       = "Taille du champ";
$owl_lang->doc_field_searchable = "Inclus dans les recherches?";
$owl_lang->doc_field_required   = "Obligatoire ?";
$owl_lang->doc_new_doc_type     = "&#8212; Ajouter un nouveau type de document &#8212;";
$owl_lang->doc_specific         = "CHAMPS SPECIFIQUES DU DOCUMENT:";
$owl_lang->doc_administration   = "ADMINISTRATION DES TYPES DE DOCUMENTS";

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
