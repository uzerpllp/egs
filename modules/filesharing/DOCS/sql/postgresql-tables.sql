set search_path=company1;

CREATE TABLE active_sessions (
        sessid varchar(32),
        usid varchar(25),
        lastused int8,
        ip varchar(16),
        currentdb int4
);

CREATE TABLE membergroup (
        userid int4 not null,
        groupid int4 not null
);

CREATE TABLE folders (
        id serial,
        name varchar(255) not null,
        parent int4 not null,
        description text,
        security varchar(5) not null,
        groupid int4 not null,
        creatorid int4 not null,
 	password varchar(50) NOT NULL default '',
 	smodified timestamp default NULL
);
create UNIQUE INDEX folderid_index ON folders (id);

CREATE TABLE files (
        id serial,
        name varchar(80) not null,
        filename varchar(255) not null,
        f_size int8 not null,
        creatorid int4 not null,
        parent int4 not null,
        created timestamp not null,
        description text not null,
        metadata text not null,
        security int4 not null,
        groupid int4 not null,
        smodified timestamp not null,
        checked_out int4 not null default 0,
        major_revision int4 not null default 0,
        minor_revision int4 not null default 1,
        url int4 not null default 0,
        password varchar(50) NOT NULL default '',
  	doctype int4 default 0,
  	updatorid int4 default 1,
  	linkedto int4 default 0,
  	approved int4 default 0

);
create UNIQUE INDEX fileid_index ON files (id);


CREATE TABLE comments (
        id serial,
        fid int4 not null,
        userid int4,
        comment_date timestamp not null,
        comments text not null,
	primary key (id)
);
CREATE TABLE news (
        id serial,
        gid int4 not null,
        news_title varchar(255) not null,
        news_date timestamp not null,
        news text not null,
        news_end_date timestamp not null,
        primary key (id)
);

CREATE TABLE users (
        id serial,
        groupid varchar(10) not null,
        username varchar(20) not null,
        name varchar(50) not null,
        password varchar(50) not null,
	quota_max bigint not null,
	quota_current bigint not null,
        email varchar(255),
	disabled int, 
	attachfile int,
	noprefaccess int,
	language varchar(15),
        maxsessions int4 not null,	
        curlogin timestamp not null,
        lastlogin timestamp not null,
        notify int,
	lastnews int4 ,
        newsadmin int not null,
	comment_notify int4,
        buttonstyle varchar(255),
	homedir int4,
	firstdir int4,
        email_tool int4,
        primary key (id)

);

CREATE TABLE html (
        id serial,
        table_expand_width    varchar(15),
        table_collapse_width  varchar(15),
	body_background      varchar(255),
	owl_logo      varchar(255),
        body_textcolor        varchar(15),
        body_link             varchar(15),
        body_vlink            varchar(15),
        primary key (id)
);

INSERT INTO html VALUES (1,'90%','50%','','owl_logo1.gif','#000000','#000000','#000000');


CREATE TABLE prefs (
  id serial,
  email_from varchar(80) default NULL,
  email_fromname varchar(80) default NULL,
  email_replyto varchar(80) default NULL,
  email_server varchar(30) default NULL,
  email_subject varchar(60) default NULL,
  lookathd varchar(15) default NULL,
  lookathddel int4 default NULL,
  def_file_security int4 default NULL,
  def_file_group_owner int4 default NULL,
  def_file_owner int4 default NULL,
  def_file_title varchar(40) default NULL,
  def_file_meta varchar(40) default NULL,
  def_fold_security int4 default NULL,
  def_fold_group_owner int4 default NULL,
  def_fold_owner int4 default NULL,
  max_filesize int4 default NULL,
  tmpdir varchar(255) default NULL,
  timeout int4 default NULL,
  expand int4 default NULL,
  version_control int4 default NULL,
  restrict_view int4 default NULL,
  hide_backup int4 default NULL,
  dbdump_path varchar(80) default NULL,
  gzip_path varchar(80) default NULL,
  tar_path varchar(80) default NULL,
  unzip_path varchar(80) default NULL,
  pod2html_path varchar(80) default NULL,
  pdftotext_path varchar(80) default NULL,
  wordtotext_path varchar(80) default NULL,
  file_perm int4 default NULL,
  folder_perm int4 default NULL,
  logging int4 default NULL,
  log_file int4 default NULL,
  log_login int4 default NULL,
  log_rec_per_page int4 default NULL,
  rec_per_page int4 default NULL,
  self_reg int4 default NULL,
  self_reg_quota int4 default NULL,
  self_reg_notify int4 default NULL,
  self_reg_attachfile int4 default NULL,
  self_reg_disabled int4 default NULL,
  self_reg_noprefacces int4 default NULL,
  self_reg_maxsessions int4 default NULL,
  self_reg_group int4 default NULL,
  anon_ro int4 default NULL,
  anon_user int4 default NULL,
  file_admin_group int4 default NULL,
  forgot_pass int4 default NULL,
  collect_trash int4 default NULL,
  trash_can_location varchar(80) default NULL,
  allow_popup int4 default NULL,
  status_bar_location int4 default NULL,
  remember_me int4 default NULL,
  cookie_timeout int4 default NULL,
  use_smtp int4 default NULL,
  use_smtp_auth int4 default NULL,
  smtp_passwd varchar(40) default NULL,
  search_bar int4 default NULL,
  bulk_buttons int4 default NULL,
  action_buttons int4 default NULL,
  folder_tools int4 default NULL,
  pref_bar int4 default NULL,
  smtp_auth_login varchar(50) default NULL,
  expand_disp_status int4 default NULL,
  expand_disp_doc_num int4 default NULL,
  expand_disp_doc_type int4 default NULL,
  expand_disp_title int4 default NULL,
  expand_disp_version int4 default NULL,
  expand_disp_file int4 default NULL,
  expand_disp_size int4 default NULL,
  expand_disp_posted int4 default NULL,
  expand_disp_modified int4 default NULL,
  expand_disp_action int4 default NULL,
  expand_disp_held int4 default NULL,
  collapse_disp_status int4 default NULL,
  collapse_disp_doc_num int4 default NULL,
  collapse_disp_doc_type int4 default NULL,
  collapse_disp_title int4 default NULL,
  collapse_disp_version int4 default NULL,
  collapse_disp_file int4 default NULL,
  collapse_disp_size int4 default NULL,
  collapse_disp_posted int4 default NULL,
  collapse_disp_modified int4 default NULL,
  collapse_disp_action int4 default NULL,
  collapse_disp_held int4 default NULL,
  expand_search_disp_score int4 default NULL,
  expand_search_disp_folder_path int4 default NULL,
  expand_search_disp_doc_type int4 default NULL,
  expand_search_disp_file int4 default NULL,
  expand_search_disp_size int4 default NULL,
  expand_search_disp_posted int4 default NULL,
  expand_search_disp_modified int4 default NULL,
  expand_search_disp_action int4 default NULL,
  collapse_search_disp_score int4 default NULL,
  collapse_search_disp_folder_path int4 default NULL,
  collapse_search_disp_doc_type int4 default NULL,
  collapse_search_disp_file int4 default NULL,
  collapse_search_disp_size int4 default NULL,
  collapse_search_disp_posted int4 default NULL,
  collapse_search_disp_modified int4 default NULL,
  collapse_search_disp_action int4 default NULL,
  hide_folder_doc_count int4 default NULL,
  old_action_icons int4 default NULL,
  search_result_folders int4 default NULL,
  restore_file_prefix varchar(50) default NULL,
  major_revision int4 default NULL,
  minor_revision int4 default NULL,
  doc_id_prefix varchar(10) default NULL,
  doc_id_num_digits int4 default NULL,
  view_doc_in_new_window int4 default NULL,
  admin_login_to_browse_page int4 default NULL,
  save_keywords_to_db int4 default NULL,
  self_reg_homedir int4 default NULL,
  self_reg_firstdir int4 default NULL,
  virus_path varchar(80) default NULL,
  peer_review int4 default NULL,
  peer_opt int4 default NULL,
  folder_size int4 default NULL,
  download_folder_zip int4 default NULL,
  display_password_override int4 default NULL,
  PRIMARY KEY  (id)
); 


INSERT INTO prefs VALUES (1,'owl@yourdomain.com','OWL','noreply@yourdomain.com','localhost','[OWL] :','false',1,0,0,1,'<font color=red>No Info</font>','not in\r\ndb',50,0,1,5120000,'/var/www/html/intranet/Documents',9000,1,1,0,1,'/usr/bin/mysqldump','/bin/gzip','/bin/tar','/usr/bin/unzip','/usr/local/bin/pod2html','/usr/bin/pdftotext','/usr/local/bin/antiword',4,54,0,1,1,5,0,0,0,0,0,0,0,0,1,1,2,2,1,0,'',1,1,0,30,0,0,'',2,0,1,1,3,'',1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,0,0,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,0,0,0,0,1,'RESTORED-',1,0,'ABC-',3,0,0,0,1,1,'','0','0','1','0','1');


CREATE TABLE monitored_file (
        id serial,
        userid int4 not null,
        fid int4 not null,
        primary key (id)
);

CREATE TABLE monitored_folder (
        id serial,
        userid int4 not null,
        fid int4 not null,
        primary key (id)
);




CREATE TABLE groups (
        id serial,
        name varchar(30) not null
);

CREATE TABLE filedata (
        id serial,
        compressed int4 not null default 0,
        data bytea, 
        primary key (id)
);
CREATE TABLE owl_log (
        id serial,
        userid int4,
        filename varchar(255),
        parent int4,
        action varchar(40), 
        details text,
        ip varchar(16),
        agent varchar(255),
        logdate timestamp not null,
        type varchar(20),
        primary key (id)
);



create table wordidx (
        wordid int4,
        word varchar(128) not null
);

create UNIQUE INDEX word_index ON wordidx (word);

create table searchidx (
        wordid int4,
        owlfileid int4
);
create INDEX search_fileid ON searchidx (owlfileid);

CREATE TABLE mimes (
        filetype varchar(10) not null primary key,
        mimetype varchar(50) not null
);

INSERT INTO users (groupid,username,name,password,quota_max,quota_current,email,notify,disabled,noprefaccess,language,maxsessions,curlogin,lastlogin,newsadmin, comment_notify, buttonstyle, homedir, firstdir) VALUES ( 0, 'root', 'Administrator', 'root', 0, 0, '', 0, 0, 0, 'English', 0, now(), now(), '0', '0', 'Blue', '1', '1');
UPDATE users SET id = 1 WHERE name = 'Administrator';
UPDATE users SET password = '21232f297a57a5a743894a0e4a801fc3' WHERE name = 'Administrator';
INSERT INTO users (groupid,username,name,password,quota_max,quota_current,email,notify,disabled,noprefaccess,language,maxsessions,curlogin,lastlogin,newsadmin, comment_notify, buttonstyle, homedir, firstdir) VALUES ( 1, 'guest', 'Anonymous', 'guest', '0', '0', '', '0', '1', '1', 'English',19, now(),now(), '0', '0', 'Blue', '1', '1' );
UPDATE users SET password = '084e0343a0486ff05530df6c705c8bb4' WHERE name = 'Anonymous';


INSERT INTO folders (name,parent,security,groupid,creatorid,description, smodified, password) VALUES ('Documents', 0, 51, 0, 0, '', '2004-10-17 08:11:50', '');

INSERT INTO groups (name) VALUES ('Administrators');
INSERT INTO groups (name) VALUES ('Anonymous');
INSERT INTO groups (name) VALUES ('File Admin');
INSERT INTO files VALUES (1, 'Test File', 'test.txt', '36', '1', '1', '2000-12-27 05:17:00','', '', '0', '0','2000-12-27 05:17:00', '0', '0', '1','0','1');
UPDATE GROUPS SET id = 0 WHERE name = 'Administrators';
UPDATE GROUPS SET id = 1 WHERE name = 'Anonymous';
UPDATE GROUPS SET id = 3 WHERE name = 'File Admin';


INSERT INTO mimes VALUES ('ai', 'application/postscript');
INSERT INTO mimes VALUES ('aif', 'audio/x-aiff');
INSERT INTO mimes VALUES ('aifc', 'audio/x-aiff');
INSERT INTO mimes VALUES ('aiff', 'audio/x-aiff');
INSERT INTO mimes VALUES ('asc', 'text/plain');
INSERT INTO mimes VALUES ('au', 'audio/basic');
INSERT INTO mimes VALUES ('avi', 'video/x-msvideo');
INSERT INTO mimes VALUES ('bcpio', 'application/x-bcpio');
INSERT INTO mimes VALUES ('bin', 'application/octet-stream');
INSERT INTO mimes VALUES ('bmp', 'image/bmp');
INSERT INTO mimes VALUES ('cdf', 'application/x-netcdf');
INSERT INTO mimes VALUES ('class', 'application/octet-stream');
INSERT INTO mimes VALUES ('cpio', 'application/x-cpio');
INSERT INTO mimes VALUES ('cpt', 'application/mac-compactpro');
INSERT INTO mimes VALUES ('csh', 'application/x-csh');
INSERT INTO mimes VALUES ('css', 'text/css');
INSERT INTO mimes VALUES ('dcr', 'application/x-director');
INSERT INTO mimes VALUES ('dir', 'application/x-director');
INSERT INTO mimes VALUES ('dms', 'application/octet-stream');
INSERT INTO mimes VALUES ('doc', 'application/msword');
INSERT INTO mimes VALUES ('dvi', 'application/x-dvi');
INSERT INTO mimes VALUES ('dxr', 'application/x-director');
INSERT INTO mimes VALUES ('eps', 'application/postscript');
INSERT INTO mimes VALUES ('etx', 'text/x-setext');
INSERT INTO mimes VALUES ('exe', 'application/octet-stream');
INSERT INTO mimes VALUES ('ez', 'application/andrew-inset');
INSERT INTO mimes VALUES ('gif', 'image/gif');
INSERT INTO mimes VALUES ('gtar', 'application/x-gtar');
INSERT INTO mimes VALUES ('hdf', 'application/x-hdf');
INSERT INTO mimes VALUES ('hqx', 'application/mac-binhex40');
INSERT INTO mimes VALUES ('htm', 'text/html');
INSERT INTO mimes VALUES ('html', 'text/html');
INSERT INTO mimes VALUES ('ice', 'x-conference/x-cooltalk');
INSERT INTO mimes VALUES ('ief', 'image/ief');
INSERT INTO mimes VALUES ('iges', 'model/iges');
INSERT INTO mimes VALUES ('igs', 'model/iges');
INSERT INTO mimes VALUES ('jpe', 'image/jpeg');
INSERT INTO mimes VALUES ('jpeg', 'image/jpeg');
INSERT INTO mimes VALUES ('jpg', 'image/jpeg');
INSERT INTO mimes VALUES ('js', 'application/x-javascript');
INSERT INTO mimes VALUES ('kar', 'audio/midi');
INSERT INTO mimes VALUES ('latex', 'application/x-latex');
INSERT INTO mimes VALUES ('lha', 'application/octet-stream');
INSERT INTO mimes VALUES ('lzh', 'application/octet-stream');
INSERT INTO mimes VALUES ('man', 'application/x-troff-man');
INSERT INTO mimes VALUES ('me', 'application/x-troff-me');
INSERT INTO mimes VALUES ('mesh', 'model/mesh');
INSERT INTO mimes VALUES ('mid', 'audio/midi');
INSERT INTO mimes VALUES ('midi', 'audio/midi');
INSERT INTO mimes VALUES ('mif', 'application/vnd.mif');
INSERT INTO mimes VALUES ('mov', 'video/quicktime');
INSERT INTO mimes VALUES ('movie', 'video/x-sgi-movie');
INSERT INTO mimes VALUES ('mp2', 'audio/mpeg');
INSERT INTO mimes VALUES ('mp3', 'audio/mpeg');
INSERT INTO mimes VALUES ('mpe', 'video/mpeg');
INSERT INTO mimes VALUES ('mpeg', 'video/mpeg');
INSERT INTO mimes VALUES ('mpg', 'video/mpeg');
INSERT INTO mimes VALUES ('mpga', 'audio/mpeg');
INSERT INTO mimes VALUES ('ms', 'application/x-troff-ms');
INSERT INTO mimes VALUES ('msh', 'model/mesh');
INSERT INTO mimes VALUES ('nc', 'application/x-netcdf');
INSERT INTO mimes VALUES ('oda', 'application/oda');
INSERT INTO mimes VALUES ('pbm', 'image/x-portable-bitmap');
INSERT INTO mimes VALUES ('pdb', 'chemical/x-pdb');
INSERT INTO mimes VALUES ('pdf', 'application/pdf');
INSERT INTO mimes VALUES ('pgm', 'image/x-portable-graymap');
INSERT INTO mimes VALUES ('pgn', 'application/x-chess-pgn');
INSERT INTO mimes VALUES ('png', 'image/png');
INSERT INTO mimes VALUES ('pnm', 'image/x-portable-anymap');
INSERT INTO mimes VALUES ('ppm', 'image/x-portable-pixmap');
INSERT INTO mimes VALUES ('ppt', 'application/vnd.ms-powerpoint');
INSERT INTO mimes VALUES ('ps', 'application/postscript');
INSERT INTO mimes VALUES ('qt', 'video/quicktime');
INSERT INTO mimes VALUES ('ra', 'audio/x-realaudio');
INSERT INTO mimes VALUES ('ram', 'audio/x-pn-realaudio');
INSERT INTO mimes VALUES ('ras', 'image/x-cmu-raster');
INSERT INTO mimes VALUES ('rgb', 'image/x-rgb');
INSERT INTO mimes VALUES ('rm', 'audio/x-pn-realaudio');
INSERT INTO mimes VALUES ('roff', 'application/x-troff');
INSERT INTO mimes VALUES ('rpm', 'audio/x-pn-realaudio-plugin');
INSERT INTO mimes VALUES ('rtf', 'text/rtf');
INSERT INTO mimes VALUES ('rtx', 'text/richtext');
INSERT INTO mimes VALUES ('sgm', 'text/sgml');
INSERT INTO mimes VALUES ('sgml', 'text/sgml');
INSERT INTO mimes VALUES ('sh', 'application/x-sh');
INSERT INTO mimes VALUES ('shar', 'application/x-shar');
INSERT INTO mimes VALUES ('silo', 'model/mesh');
INSERT INTO mimes VALUES ('sit', 'application/x-stuffit');
INSERT INTO mimes VALUES ('skd', 'application/x-koan');
INSERT INTO mimes VALUES ('skm', 'application/x-koan');
INSERT INTO mimes VALUES ('skp', 'application/x-koan');
INSERT INTO mimes VALUES ('skt', 'application/x-koan');
INSERT INTO mimes VALUES ('smi', 'application/smil');
INSERT INTO mimes VALUES ('smil', 'application/smil');
INSERT INTO mimes VALUES ('snd', 'audio/basic');
INSERT INTO mimes VALUES ('spl', 'application/x-futuresplash');
INSERT INTO mimes VALUES ('src', 'application/x-wais-source');
INSERT INTO mimes VALUES ('sv4cpio', 'application/x-sv4cpio');
INSERT INTO mimes VALUES ('sv4crc', 'application/x-sv4crc');
INSERT INTO mimes VALUES ('swf', 'application/x-shockwave-flash');
INSERT INTO mimes VALUES ('t', 'application/x-troff');
INSERT INTO mimes VALUES ('tar', 'application/x-tar');
INSERT INTO mimes VALUES ('tcl', 'application/x-tcl');
INSERT INTO mimes VALUES ('tex', 'application/x-tex');
INSERT INTO mimes VALUES ('texi', 'application/x-texinfo');
INSERT INTO mimes VALUES ('texinfo', 'application/x-texinfo');
INSERT INTO mimes VALUES ('tif', 'image/tiff');
INSERT INTO mimes VALUES ('tiff', 'image/tiff');
INSERT INTO mimes VALUES ('tr', 'application/x-troff');
INSERT INTO mimes VALUES ('tsv', 'text/tab-separated-values');
INSERT INTO mimes VALUES ('txt', 'text/plain');
INSERT INTO mimes VALUES ('ustar', 'application/x-ustar');
INSERT INTO mimes VALUES ('vcd', 'application/x-cdlink');
INSERT INTO mimes VALUES ('vrml', 'model/vrml');
INSERT INTO mimes VALUES ('wav', 'audio/x-wav');
INSERT INTO mimes VALUES ('wrl', 'model/vrml');
INSERT INTO mimes VALUES ('xbm', 'image/x-xbitmap');
INSERT INTO mimes VALUES ('xls', 'application/vnd.ms-excel');
INSERT INTO mimes VALUES ('xml', 'text/xml');
INSERT INTO mimes VALUES ('xpm', 'image/x-xpixmap');
INSERT INTO mimes VALUES ('xwd', 'image/x-xwindowdump');
INSERT INTO mimes VALUES ('xyz', 'chemical/x-pdb');
INSERT INTO mimes VALUES ('zip', 'application/zip');
INSERT INTO mimes VALUES ('gz', 'application/x-gzip');
INSERT INTO mimes VALUES ('tgz', 'application/x-gzip');
INSERT INTO mimes VALUES ('sxw','application/vnd.sun.xml.writer');
INSERT INTO mimes VALUES ('stw','application/vnd.sun.xml.writer.template');
INSERT INTO mimes VALUES ('sxg','application/vnd.sun.xml.writer.global');
INSERT INTO mimes VALUES ('sxc','application/vnd.sun.xml.calc');
INSERT INTO mimes VALUES ('stc','application/vnd.sun.xml.calc.template');
INSERT INTO mimes VALUES ('sxi','application/vnd.sun.xml.impress');
INSERT INTO mimes VALUES ('sti','application/vnd.sun.xml.impress.template');
INSERT INTO mimes VALUES ('sxd','application/vnd.sun.xml.draw');
INSERT INTO mimes VALUES ('std','application/vnd.sun.xml.draw.template');
INSERT INTO mimes VALUES ('sxm','application/vnd.sun.xml.math');



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
                                                                                                                                                                     
CREATE TABLE peerreview (
        reviewer_id int4,
        file_id int4,
        status int4
);

