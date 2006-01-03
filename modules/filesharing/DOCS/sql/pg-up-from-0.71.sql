create table wordidx (
        wordid int4,
        word char(128) not null
);
create UNIQUE INDEX word_index ON wordidx (word);

create table searchidx (
        wordid int4,
        owlfileid int4
);
create INDEX search_fileid ON searchidx (owlfileid);

ALTER TABLE prefs ADD pdftotext_path varchar(80);
update prefs set pdftotext_path = '/usr/bin/pdftotext';
ALTER TABLE prefs ADD wordtotext_path varchar(80);
update prefs set wordtotext_path = '/usr/local/bin/antiword';

ALTER TABLE prefs ADD pod2html_path varchar(80);
update prefs set pod2html_path = '/usr/local/bin/pod2html';

ALTER TABLE `prefs` CHANGE `email_from` `email_from` varchar(80) NOT NULL;
ALTER TABLE `prefs` CHANGE `email_fromname` `email_fromname` varchar(80) NOT NULL;
ALTER TABLE `prefs` CHANGE `email_replyto` `email_replyto` varchar(80) NOT NULL;
alter table users add column buttonstyle varchar(255);
UPDATE users set buttonstyle = 'Blue';
ALTER TABLE prefs ADD rec_per_page int4;
UPDATE prefs set rec_per_page = '0';
ALTER TABLE prefs ADD remember_me int4;
UPDATE prefs set remember_me = '0';
ALTER TABLE prefs ADD cookie_timeout int4;
UPDATE prefs set cookie_timeout = '30';
ALTER TABLE users ADD homedir int4;
UPDATE users set homedir = '1';
ALTER TABLE users ADD firstdir int4;
UPDATE users set firstdir = '1';
alter table prefs add column peer_review int4;
alter table prefs add column peer_opt int4;

ALTER TABLE comment RENAME COLUMN comment TO comments;
ALTER TABLE comment RENAME TO comments;
ALTER TABLE `users` CHANGE `quota_max` `quota_max` BIGINT;
ALTER TABLE `users` CHANGE `quota_current` `quota_current` BIGINT;
create INDEX parentid_index ON files (parent);
                                                                                                                                                                     
CREATE TABLE docfieldslabel (
  doc_field_id int4 NOT NULL default '0',
  field_label varchar(80) NOT NULL default '',
  locale varchar(80) NOT NULL default ''
);

CREATE TABLE doctype (
        doc_type_id serial,
        doc_type_name varchar(255) not null,
        primary key (doc_type_id)
);
                                                                                                                                                                     
INSERT INTO doctype (doc_type_name) values ('Default');
                                                                                                                                                                     
CREATE TABLE docfields (
        id serial,
        doc_type_id int4 not null ,
        field_name varchar(80) not null,
        field_position int4 not null,
        field_type varchar(80) not null,
        field_values varchar(80) not null,
        field_size int4 not null,
        searchable int4 not null,
        required int4 not null,
        primary key (id)
);

CREATE TABLE docfieldvalues (
        id serial,
        file_id int4 not null ,
        field_name varchar(80) not null,
        field_value varchar(80) not null,
        primary key (id)
);
                                                                                                                                                                     
alter table files add column doctype int4;
alter table files add column approved int4;
ALTER TABLE active_sessions RENAME COLUMN uid to usid;

alter table active_sessions add column currentdb int4;

alter table prefs add column self_reg_firstdir int4;
alter table prefs add column self_reg_homedir int4;

alter table prefs add column virus_path varchar(80);

alter table prefs add column smtp_auth_login varchar(50);

alter table prefs add column search_bar int4;
alter table prefs add column pref_bar int4;
alter table prefs add column bulk_buttons int4;
alter table prefs add column action_buttons int4;
alter table prefs add column folder_tools int4;

alter table prefs add column expand_disp_status int4;
alter table prefs add column expand_disp_doc_num int4;
alter table prefs add column expand_disp_doc_type int4;
alter table prefs add column expand_disp_title int4;
alter table prefs add column expand_disp_version int4;
alter table prefs add column expand_disp_file int4;
alter table prefs add column expand_disp_size int4;
alter table prefs add column expand_disp_posted int4;
alter table prefs add column expand_disp_modified int4;
alter table prefs add column expand_disp_action int4;
alter table prefs add column expand_disp_held int4;

alter table prefs add column collapse_disp_status int4;
alter table prefs add column collapse_disp_doc_num int4;
alter table prefs add column collapse_disp_doc_type int4;
alter table prefs add column collapse_disp_title int4;
alter table prefs add column collapse_disp_version int4;
alter table prefs add column collapse_disp_file int4;
alter table prefs add column collapse_disp_size int4;
alter table prefs add column collapse_disp_posted int4;
alter table prefs add column collapse_disp_modified int4;
alter table prefs add column collapse_disp_action int4;
alter table prefs add column collapse_disp_held int4;

alter table prefs add column expand_search_disp_score int4;
alter table prefs add column expand_search_disp_folder_path int4;
alter table prefs add column expand_search_disp_doc_type int4;
alter table prefs add column expand_search_disp_file int4;
alter table prefs add column expand_search_disp_size int4;
alter table prefs add column expand_search_disp_posted int4;
alter table prefs add column expand_search_disp_modified int4;
alter table prefs add column expand_search_disp_action int4;

alter table prefs add column collapse_search_disp_score int4;
alter table prefs add column collapse_search_disp_folder_path int4;
alter table prefs add column collapse_search_disp_doc_type int4;
alter table prefs add column collapse_search_disp_file int4;
alter table prefs add column collapse_search_disp_size int4;
alter table prefs add column collapse_search_disp_posted int4;
alter table prefs add column collapse_search_disp_modified int4;
alter table prefs add column collapse_search_disp_action int4;

alter table prefs add column hide_folder_doc_count int4;
alter table prefs add column old_action_icons int4;
alter table prefs add column search_result_folders int4;
alter table prefs add column restore_file_prefix varchar(50);
alter table prefs add column major_revision int4;
alter table prefs add column minor_revision int4;
alter table prefs add column doc_id_prefix varchar(10);
alter table prefs add column doc_id_num_digits int4;
alter table prefs add column view_doc_in_new_window int4;
alter table prefs add column admin_login_to_browse_page int4;
alter table prefs add column save_keywords_to_db int4;
alter table prefs drop column hide_bulk;



alter table users add column email_tool int4;
update users set email_tool = '0';


alter table folders add column password varchar(50);
alter table folders add column smodified timestamp;
update folders set smodified = now();

alter table files add column linkedto int4;
alter table files rename column name to name char(255);
alter table files add column password varchar(50);
alter table files add column updatorid int4;


CREATE TABLE metakeywords (
        keyword_id serial,
        keyword_text char(255) not null,
        primary key (keyword_id)
);


INSERT INTO mimes VALUES ('sxw', 'application/vnd.sun.xml.writer');
INSERT INTO mimes VALUES ('stw', 'application/vnd.sun.xml.writer.template');
INSERT INTO mimes VALUES ('sxg', 'application/vnd.sun.xml.writer.global');
INSERT INTO mimes VALUES ('sxc', 'application/vnd.sun.xml.calc');
INSERT INTO mimes VALUES ('stc', 'application/vnd.sun.xml.calc.template');
INSERT INTO mimes VALUES ('sxi', 'application/vnd.sun.xml.impress');
INSERT INTO mimes VALUES ('sti', 'application/vnd.sun.xml.impress.template');
INSERT INTO mimes VALUES ('sxd', 'application/vnd.sun.xml.draw');
INSERT INTO mimes VALUES ('std', 'application/vnd.sun.xml.draw.template');
INSERT INTO mimes VALUES ('sxm', 'application/vnd.sun.xml.math');


ALTER TABLE `owl_log` CHANGE `agent` `agent` varchar(255);

CREATE TABLE peerreview (
        reviewer_id int4,
        file_id int4,
        status int4 
);
UPDATE files set approved = '1';
alter table html drop column table_border;
alter table html drop column table_header_bg;
alter table html drop column table_cell_bg;
alter table html drop column table_cell_bg_alt;
alter table html drop column main_header_bgcolor;
alter table html drop column body_bgcolor;

UPDATE prefs SET self_reg_homedir='1', self_reg_firstdir='1',  virus_path = '', smtp_auth_login = '', search_bar = '2', pref_bar = '1', bulk_buttons = '1', action_buttons = '1', folder_tools = '1', expand_disp_status = '1', expand_disp_doc_num = '0', expand_disp_doc_type = '1', expand_disp_title = '1', expand_disp_version = '1', expand_disp_file = '1', expand_disp_size = '1', expand_disp_posted = '1', expand_disp_modified = '1', expand_disp_action = '1', expand_disp_held = '1', collapse_disp_status = '0', collapse_disp_doc_num = '0', collapse_disp_doc_type = '1', collapse_disp_title = '1', collapse_disp_version = '0', collapse_disp_file = '1', collapse_disp_size = '0', collapse_disp_posted = '0', collapse_disp_modified = '0', collapse_disp_action = '1', collapse_disp_held = '1', expand_search_disp_score = '1', expand_search_disp_folder_path = '1', expand_search_disp_doc_type = '1', expand_search_disp_file = '1', expand_search_disp_size = '1', expand_search_disp_posted = '1', expand_search_disp_modified = '1', expand_search_disp_action = '1', collapse_search_disp_score = '1', collapse_search_disp_folder_path = '1', collapse_search_disp_doc_type = '1', collapse_search_disp_file = '1', collapse_search_disp_size = '0', collapse_search_disp_posted = '0', collapse_search_disp_modified = '0', collapse_search_disp_action = '0', hide_folder_doc_count = '0', old_action_icons = '1', search_result_folders = '1', restore_file_prefix = 'RESTORED-', major_revision = '1', minor_revision = '0', doc_id_prefix = 'ABC-', doc_id_num_digits = '3', view_doc_in_new_window = '0', admin_login_to_browse_page = '0', save_keywords_to_db = '0',  peer_review = '0', peer_opt = '0';

alter table prefs add column folder_size int4;
update prefs set folder_size = '1';
                                                                                                                                                             
alter table prefs add column download_folder_zip int4;
update prefs set download_folder_zip = '0';

alter table prefs add column display_password_override int4;
update prefs set display_password_override = '1';

