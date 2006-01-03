-- MySQL dump 8.22
--
-- Host: localhost    Database: intranet
---------------------------------------------------------
-- Server version	3.23.56-log

--
-- Table structure for table 'active_sessions'
--

CREATE TABLE active_sessions (
  sessid char(32) NOT NULL default '',
  usid char(25) default NULL,
  lastused int(10) unsigned default NULL,
  ip char(16) default NULL,
  currentdb int(4) default NULL,
  PRIMARY KEY  (sessid)
) TYPE=MyISAM;

--
-- Dumping data for table 'active_sessions'
--

--
-- Table structure for table 'comments'
--

CREATE TABLE comments (
  id int(4) NOT NULL auto_increment,
  fid int(4) NOT NULL default '0',
  userid int(4) default NULL,
  comment_date datetime NOT NULL default '0000-00-00 00:00:00',
  comments text NOT NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table 'comments'
--



--
-- Table structure for table 'docfields'
--

CREATE TABLE docfields (
  id int(4) NOT NULL auto_increment,
  doc_type_id int(4) NOT NULL default '0',
  field_name char(80) NOT NULL default '',
  field_position int(4) NOT NULL default '0',
  field_type char(80) NOT NULL default '',
  field_values char(80) NOT NULL default '',
  field_size bigint(20) NOT NULL default '0',
  searchable int(4) NOT NULL default '0',
  required int(4) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table 'docfields'
--


--
-- Table structure for table 'docfieldslabel'
--

CREATE TABLE docfieldslabel (
  doc_field_id int(4) NOT NULL default '0',
  field_label char(80) NOT NULL default '',
  locale char(80) NOT NULL default ''
) TYPE=MyISAM;

--
-- Dumping data for table 'docfieldslabel'
--


--
-- Table structure for table 'docfieldvalues'
--

CREATE TABLE docfieldvalues (
  id int(4) NOT NULL auto_increment,
  file_id int(4) NOT NULL default '0',
  field_name char(80) NOT NULL default '',
  field_value char(80) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table 'docfieldvalues'
--



--
-- Table structure for table 'doctype'
--

CREATE TABLE doctype (
  doc_type_id int(4) NOT NULL auto_increment,
  doc_type_name char(255) NOT NULL default '',
  PRIMARY KEY  (doc_type_id)
) TYPE=MyISAM;

--
-- Dumping data for table 'doctype'
--


INSERT INTO doctype VALUES (1,'Default');

--
-- Table structure for table 'filedata'
--

CREATE TABLE filedata (
  id int(4) NOT NULL default '0',
  compressed int(4) NOT NULL default '0',
  data longblob,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table 'filedata'
--



--
-- Table structure for table 'files'
--

CREATE TABLE files (
  id int(4) NOT NULL auto_increment,
  name varchar(255) default NULL,
  filename varchar(255) NOT NULL default '',
  f_size bigint(20) NOT NULL default '0',
  creatorid int(4) NOT NULL default '0',
  parent int(4) NOT NULL default '0',
  created datetime NOT NULL default '0000-00-00 00:00:00',
  description text NOT NULL,
  metadata text NOT NULL,
  security int(4) NOT NULL default '0',
  groupid int(4) NOT NULL default '0',
  smodified datetime NOT NULL default '0000-00-00 00:00:00',
  checked_out int(4) NOT NULL default '0',
  major_revision int(4) NOT NULL default '0',
  minor_revision int(4) NOT NULL default '1',
  url int(4) NOT NULL default '0',
  password varchar(50) NOT NULL default '',
  doctype int(4) default NULL,
  updatorid int(4) default NULL,
  linkedto int(4) default NULL,
  approved int(4) default NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY fileid_index (id),
  KEY parentid_index (parent)
) TYPE=MyISAM;

--
-- Dumping data for table 'files'
--

INSERT INTO files VALUES (1,'Test File','test.txt',36,1,1,'2000-12-27 05:17:00','','',0,0,'2000-12-27 05:17:00',0,0,1,0,'',NULL,NULL,NULL,1);

--
-- Table structure for table 'folders'
--

CREATE TABLE folders (
  id int(4) NOT NULL auto_increment,
  name varchar(255) NOT NULL default '',
  parent int(4) NOT NULL default '0',
  description text NOT NULL,
  security varchar(5) NOT NULL default '',
  groupid int(4) NOT NULL default '0',
  creatorid int(4) NOT NULL default '0',
  password varchar(50) NOT NULL default '',
  smodified datetime default NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY folderid_index (id)
) TYPE=MyISAM;

--
-- Dumping data for table 'folders'
--


INSERT INTO folders VALUES (1,'Documents',0,'','51',0,1,'','2004-10-17 08:11:50');

--
-- Table structure for table 'groups'
--

CREATE TABLE groups (
  id int(4) NOT NULL auto_increment,
  name char(30) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table 'groups'
--


INSERT INTO groups VALUES (1,'Administrators');
UPDATE groups SET id = 0 WHERE name = 'Administrators';
INSERT INTO groups VALUES (1,'Anonymous');
INSERT INTO groups VALUES (2,'File Admin');




--
-- Table structure for table 'html'
--

CREATE TABLE html (
  id int(4) NOT NULL auto_increment,
  table_expand_width char(15) default NULL,
  table_collapse_width char(15) default NULL,
  body_background char(255) default NULL,
  owl_logo char(255) default NULL,
  body_textcolor char(15) default NULL,
  body_link char(15) default NULL,
  body_vlink char(15) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table 'html'
--


INSERT INTO html VALUES (1,'90%','50%','','owl_logo1.gif','#000000','#000000','#000000');

--
-- Table structure for table 'membergroup'
--

CREATE TABLE membergroup (
  userid int(4) NOT NULL default '0',
  groupid int(4) NOT NULL default '0'
) TYPE=MyISAM;

--
-- Dumping data for table 'membergroup'
--



--
-- Table structure for table 'metakeywords'
--

CREATE TABLE metakeywords (
  keyword_id int(4) NOT NULL auto_increment,
  keyword_text char(255) NOT NULL default '',
  PRIMARY KEY  (keyword_id)
) TYPE=MyISAM;

--
-- Dumping data for table 'metakeywords'
--


--
-- Table structure for table 'mimes'
--

CREATE TABLE mimes (
  filetype char(10) NOT NULL default '',
  mimetype char(50) NOT NULL default '',
  PRIMARY KEY  (filetype)
) TYPE=MyISAM;

--
-- Dumping data for table 'mimes'
--


INSERT INTO mimes VALUES ('ai','application/postscript');
INSERT INTO mimes VALUES ('aif','audio/x-aiff');
INSERT INTO mimes VALUES ('aifc','audio/x-aiff');
INSERT INTO mimes VALUES ('aiff','audio/x-aiff');
INSERT INTO mimes VALUES ('asc','text/plain');
INSERT INTO mimes VALUES ('au','audio/basic');
INSERT INTO mimes VALUES ('avi','video/x-msvideo');
INSERT INTO mimes VALUES ('bcpio','application/x-bcpio');
INSERT INTO mimes VALUES ('bin','application/octet-stream');
INSERT INTO mimes VALUES ('bmp','image/bmp');
INSERT INTO mimes VALUES ('cdf','application/x-netcdf');
INSERT INTO mimes VALUES ('class','application/octet-stream');
INSERT INTO mimes VALUES ('cpio','application/x-cpio');
INSERT INTO mimes VALUES ('cpt','application/mac-compactpro');
INSERT INTO mimes VALUES ('csh','application/x-csh');
INSERT INTO mimes VALUES ('css','text/css');
INSERT INTO mimes VALUES ('dcr','application/x-director');
INSERT INTO mimes VALUES ('dir','application/x-director');
INSERT INTO mimes VALUES ('dms','application/octet-stream');
INSERT INTO mimes VALUES ('doc','application/msword');
INSERT INTO mimes VALUES ('dvi','application/x-dvi');
INSERT INTO mimes VALUES ('dxr','application/x-director');
INSERT INTO mimes VALUES ('eps','application/postscript');
INSERT INTO mimes VALUES ('etx','text/x-setext');
INSERT INTO mimes VALUES ('exe','application/octet-stream');
INSERT INTO mimes VALUES ('ez','application/andrew-inset');
INSERT INTO mimes VALUES ('gif','image/gif');
INSERT INTO mimes VALUES ('gtar','application/x-gtar');
INSERT INTO mimes VALUES ('hdf','application/x-hdf');
INSERT INTO mimes VALUES ('hqx','application/mac-binhex40');
INSERT INTO mimes VALUES ('htm','text/html');
INSERT INTO mimes VALUES ('html','text/html');
INSERT INTO mimes VALUES ('ice','x-conference/x-cooltalk');
INSERT INTO mimes VALUES ('ief','image/ief');
INSERT INTO mimes VALUES ('iges','model/iges');
INSERT INTO mimes VALUES ('igs','model/iges');
INSERT INTO mimes VALUES ('jpe','image/jpeg');
INSERT INTO mimes VALUES ('jpeg','image/jpeg');
INSERT INTO mimes VALUES ('jpg','image/jpeg');
INSERT INTO mimes VALUES ('js','application/x-javascript');
INSERT INTO mimes VALUES ('kar','audio/midi');
INSERT INTO mimes VALUES ('latex','application/x-latex');
INSERT INTO mimes VALUES ('lha','application/octet-stream');
INSERT INTO mimes VALUES ('lzh','application/octet-stream');
INSERT INTO mimes VALUES ('man','application/x-troff-man');
INSERT INTO mimes VALUES ('me','application/x-troff-me');
INSERT INTO mimes VALUES ('mesh','model/mesh');
INSERT INTO mimes VALUES ('mid','audio/midi');
INSERT INTO mimes VALUES ('midi','audio/midi');
INSERT INTO mimes VALUES ('mif','application/vnd.mif');
INSERT INTO mimes VALUES ('mov','video/quicktime');
INSERT INTO mimes VALUES ('movie','video/x-sgi-movie');
INSERT INTO mimes VALUES ('mp2','audio/mpeg');
INSERT INTO mimes VALUES ('mp3','audio/mpeg');
INSERT INTO mimes VALUES ('mpe','video/mpeg');
INSERT INTO mimes VALUES ('mpeg','video/mpeg');
INSERT INTO mimes VALUES ('mpg','video/mpeg');
INSERT INTO mimes VALUES ('mpga','audio/mpeg');
INSERT INTO mimes VALUES ('ms','application/x-troff-ms');
INSERT INTO mimes VALUES ('msh','model/mesh');
INSERT INTO mimes VALUES ('nc','application/x-netcdf');
INSERT INTO mimes VALUES ('oda','application/oda');
INSERT INTO mimes VALUES ('pbm','image/x-portable-bitmap');
INSERT INTO mimes VALUES ('pdb','chemical/x-pdb');
INSERT INTO mimes VALUES ('pdf','application/pdf');
INSERT INTO mimes VALUES ('pgm','image/x-portable-graymap');
INSERT INTO mimes VALUES ('pgn','application/x-chess-pgn');
INSERT INTO mimes VALUES ('png','image/png');
INSERT INTO mimes VALUES ('pnm','image/x-portable-anymap');
INSERT INTO mimes VALUES ('ppm','image/x-portable-pixmap');
INSERT INTO mimes VALUES ('ppt','application/vnd.ms-powerpoint');
INSERT INTO mimes VALUES ('ps','application/postscript');
INSERT INTO mimes VALUES ('qt','video/quicktime');
INSERT INTO mimes VALUES ('ra','audio/x-realaudio');
INSERT INTO mimes VALUES ('ram','audio/x-pn-realaudio');
INSERT INTO mimes VALUES ('ras','image/x-cmu-raster');
INSERT INTO mimes VALUES ('rgb','image/x-rgb');
INSERT INTO mimes VALUES ('rm','audio/x-pn-realaudio');
INSERT INTO mimes VALUES ('roff','application/x-troff');
INSERT INTO mimes VALUES ('rpm','audio/x-pn-realaudio-plugin');
INSERT INTO mimes VALUES ('rtf','text/rtf');
INSERT INTO mimes VALUES ('rtx','text/richtext');
INSERT INTO mimes VALUES ('sgm','text/sgml');
INSERT INTO mimes VALUES ('sgml','text/sgml');
INSERT INTO mimes VALUES ('sh','application/x-sh');
INSERT INTO mimes VALUES ('shar','application/x-shar');
INSERT INTO mimes VALUES ('silo','model/mesh');
INSERT INTO mimes VALUES ('sit','application/x-stuffit');
INSERT INTO mimes VALUES ('skd','application/x-koan');
INSERT INTO mimes VALUES ('skm','application/x-koan');
INSERT INTO mimes VALUES ('skp','application/x-koan');
INSERT INTO mimes VALUES ('skt','application/x-koan');
INSERT INTO mimes VALUES ('smi','application/smil');
INSERT INTO mimes VALUES ('smil','application/smil');
INSERT INTO mimes VALUES ('snd','audio/basic');
INSERT INTO mimes VALUES ('spl','application/x-futuresplash');
INSERT INTO mimes VALUES ('src','application/x-wais-source');
INSERT INTO mimes VALUES ('sv4cpio','application/x-sv4cpio');
INSERT INTO mimes VALUES ('sv4crc','application/x-sv4crc');
INSERT INTO mimes VALUES ('swf','application/x-shockwave-flash');
INSERT INTO mimes VALUES ('t','application/x-troff');
INSERT INTO mimes VALUES ('tar','application/x-tar');
INSERT INTO mimes VALUES ('tcl','application/x-tcl');
INSERT INTO mimes VALUES ('tex','application/x-tex');
INSERT INTO mimes VALUES ('texi','application/x-texinfo');
INSERT INTO mimes VALUES ('texinfo','application/x-texinfo');
INSERT INTO mimes VALUES ('tif','image/tiff');
INSERT INTO mimes VALUES ('tiff','image/tiff');
INSERT INTO mimes VALUES ('tr','application/x-troff');
INSERT INTO mimes VALUES ('tsv','text/tab-separated-values');
INSERT INTO mimes VALUES ('txt','text/plain');
INSERT INTO mimes VALUES ('ustar','application/x-ustar');
INSERT INTO mimes VALUES ('vcd','application/x-cdlink');
INSERT INTO mimes VALUES ('vrml','model/vrml');
INSERT INTO mimes VALUES ('wav','audio/x-wav');
INSERT INTO mimes VALUES ('wrl','model/vrml');
INSERT INTO mimes VALUES ('xbm','image/x-xbitmap');
INSERT INTO mimes VALUES ('xls','application/vnd.ms-excel');
INSERT INTO mimes VALUES ('xml','text/xml');
INSERT INTO mimes VALUES ('xpm','image/x-xpixmap');
INSERT INTO mimes VALUES ('xwd','image/x-xwindowdump');
INSERT INTO mimes VALUES ('xyz','chemical/x-pdb');
INSERT INTO mimes VALUES ('zip','application/zip');
INSERT INTO mimes VALUES ('gz','application/x-gzip');
INSERT INTO mimes VALUES ('tgz','application/x-gzip');
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

--
-- Table structure for table 'monitored_file'
--

CREATE TABLE monitored_file (
  id int(4) NOT NULL auto_increment,
  userid int(4) NOT NULL default '0',
  fid int(4) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table 'monitored_file'
--



--
-- Table structure for table 'monitored_folder'
--

CREATE TABLE monitored_folder (
  id int(4) NOT NULL auto_increment,
  userid int(4) NOT NULL default '0',
  fid int(4) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table 'monitored_folder'
--


INSERT INTO monitored_folder VALUES (3,5,8);

--
-- Table structure for table 'news'
--

CREATE TABLE news (
  id int(4) NOT NULL auto_increment,
  gid int(4) NOT NULL default '0',
  news_title varchar(255) NOT NULL default '',
  news_date datetime NOT NULL default '0000-00-00 00:00:00',
  news text NOT NULL,
  news_end_date datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table 'news'
--



--
-- Table structure for table 'owl_log'
--

CREATE TABLE owl_log (
  id int(4) NOT NULL auto_increment,
  userid int(4) default NULL,
  filename varchar(255) default NULL,
  parent int(4) default NULL,
  action varchar(40) default NULL,
  details text,
  ip varchar(16) default NULL,
  agent varchar(255) default NULL,
  logdate datetime NOT NULL default '0000-00-00 00:00:00',
  type varchar(20) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table 'owl_log'
--


--
-- Table structure for table 'prefs'
--

CREATE TABLE prefs (
  id int(4) NOT NULL auto_increment,
  email_from varchar(80) default NULL,
  email_fromname varchar(80) default NULL,
  email_replyto varchar(80) default NULL,
  email_server varchar(30) default NULL,
  email_subject varchar(60) default NULL,
  lookathd varchar(15) default NULL,
  lookathddel int(4) default NULL,
  def_file_security int(4) default NULL,
  def_file_group_owner int(4) default NULL,
  def_file_owner int(4) default NULL,
  def_file_title varchar(40) default NULL,
  def_file_meta varchar(40) default NULL,
  def_fold_security int(4) default NULL,
  def_fold_group_owner int(4) default NULL,
  def_fold_owner int(4) default NULL,
  max_filesize int(4) default NULL,
  tmpdir varchar(255) default NULL,
  timeout int(4) default NULL,
  expand int(4) default NULL,
  version_control int(4) default NULL,
  restrict_view int(4) default NULL,
  hide_backup int(4) default NULL,
  dbdump_path varchar(80) default NULL,
  gzip_path varchar(80) default NULL,
  tar_path varchar(80) default NULL,
  unzip_path varchar(80) default NULL,
  pod2html_path varchar(80) default NULL,
  pdftotext_path varchar(80) default NULL,
  wordtotext_path varchar(80) default NULL,
  file_perm int(4) default NULL,
  folder_perm int(4) default NULL,
  logging int(4) default NULL,
  log_file int(4) default NULL,
  log_login int(4) default NULL,
  log_rec_per_page int(4) default NULL,
  rec_per_page int(4) default NULL,
  self_reg int(4) default NULL,
  self_reg_quota int(4) default NULL,
  self_reg_notify int(4) default NULL,
  self_reg_attachfile int(4) default NULL,
  self_reg_disabled int(4) default NULL,
  self_reg_noprefacces int(4) default NULL,
  self_reg_maxsessions int(4) default NULL,
  self_reg_group int(4) default NULL,
  anon_ro int(4) default NULL,
  anon_user int(4) default NULL,
  file_admin_group int(4) default NULL,
  forgot_pass int(4) default NULL,
  collect_trash int(4) default NULL,
  trash_can_location varchar(80) default NULL,
  allow_popup int(4) default NULL,
  status_bar_location int(4) default NULL,
  remember_me int(4) default NULL,
  cookie_timeout int(4) default NULL,
  use_smtp int(4) default NULL,
  use_smtp_auth int(4) default NULL,
  smtp_passwd varchar(40) default NULL,
  search_bar int(4) default NULL,
  bulk_buttons int(4) default NULL,
  action_buttons int(4) default NULL,
  folder_tools int(4) default NULL,
  pref_bar int(4) default NULL,
  smtp_auth_login varchar(50) default NULL,
  expand_disp_status int(4) default NULL,
  expand_disp_doc_num int(4) default NULL,
  expand_disp_doc_type int(4) default NULL,
  expand_disp_title int(4) default NULL,
  expand_disp_version int(4) default NULL,
  expand_disp_file int(4) default NULL,
  expand_disp_size int(4) default NULL,
  expand_disp_posted int(4) default NULL,
  expand_disp_modified int(4) default NULL,
  expand_disp_action int(4) default NULL,
  expand_disp_held int(4) default NULL,
  collapse_disp_status int(4) default NULL,
  collapse_disp_doc_num int(4) default NULL,
  collapse_disp_doc_type int(4) default NULL,
  collapse_disp_title int(4) default NULL,
  collapse_disp_version int(4) default NULL,
  collapse_disp_file int(4) default NULL,
  collapse_disp_size int(4) default NULL,
  collapse_disp_posted int(4) default NULL,
  collapse_disp_modified int(4) default NULL,
  collapse_disp_action int(4) default NULL,
  collapse_disp_held int(4) default NULL,
  expand_search_disp_score int(4) default NULL,
  expand_search_disp_folder_path int(4) default NULL,
  expand_search_disp_doc_type int(4) default NULL,
  expand_search_disp_file int(4) default NULL,
  expand_search_disp_size int(4) default NULL,
  expand_search_disp_posted int(4) default NULL,
  expand_search_disp_modified int(4) default NULL,
  expand_search_disp_action int(4) default NULL,
  collapse_search_disp_score int(4) default NULL,
  collapse_search_disp_folder_path int(4) default NULL,
  collapse_search_disp_doc_type int(4) default NULL,
  collapse_search_disp_file int(4) default NULL,
  collapse_search_disp_size int(4) default NULL,
  collapse_search_disp_posted int(4) default NULL,
  collapse_search_disp_modified int(4) default NULL,
  collapse_search_disp_action int(4) default NULL,
  hide_folder_doc_count int(4) default NULL,
  old_action_icons int(4) default NULL,
  search_result_folders int(4) default NULL,
  restore_file_prefix varchar(50) default NULL,
  major_revision int(4) default NULL,
  minor_revision int(4) default NULL,
  doc_id_prefix varchar(10) default NULL,
  doc_id_num_digits int(4) default NULL,
  view_doc_in_new_window int(4) default NULL,
  admin_login_to_browse_page int(4) default NULL,
  save_keywords_to_db int(4) default NULL,
  self_reg_homedir int(4) default NULL,
  self_reg_firstdir int(4) default NULL,
  virus_path varchar(80) default NULL,
  peer_review int(4) default NULL,
  peer_opt int(4) default NULL,
  folder_size int(4) default NULL,
  download_folder_zip int(4) default NULL,
  display_password_override int(4) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table 'prefs'
--


INSERT INTO prefs VALUES (1,'owl@yourdomain.com','OWL','noreply@yourdomain.com','localhost','[OWL] :','false',1,0,0,1,'<font color=red>No Info</font>','not in\r\ndb',50,0,1,5120000,'/var/www/html/intranet/Documents',9000,1,1,0,1,'/usr/bin/mysqldump','/bin/gzip','/bin/tar','/usr/bin/unzip','/usr/local/bin/pod2html','/usr/bin/pdftotext','/usr/local/bin/antiword',4,54,0,1,1,5,0,0,0,0,0,0,0,0,1,1,2,2,1,0,'',1,1,0,30,0,0,'',2,0,1,1,3,'',1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,0,0,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,0,0,0,0,1,'RESTORED-',1,0,'ABC-',3,0,0,0,1,1,'','0','0','1','0','1');

--
-- Table structure for table 'searchidx'
--

CREATE TABLE searchidx (
  wordid int(4) default NULL,
  owlfileid int(4) default NULL,
  KEY search_fileid (owlfileid)
) TYPE=MyISAM;

--
-- Dumping data for table 'searchidx'
--


--
-- Table structure for table 'users'
--

CREATE TABLE users (
  id int(4) NOT NULL auto_increment,
  groupid varchar(10) NOT NULL default '',
  username varchar(20) NOT NULL default '',
  name varchar(50) NOT NULL default '',
  password varchar(50) NOT NULL default '',
  quota_max bigint(20) unsigned NOT NULL default '0',
  quota_current bigint(20) unsigned NOT NULL default '0',
  email varchar(255) default NULL,
  notify int(4) default NULL,
  attachfile int(4) default NULL,
  disabled int(4) default NULL,
  noprefaccess int(4) default '0',
  language varchar(15) default NULL,
  maxsessions int(4) default '0',
  lastlogin datetime NOT NULL default '0000-00-00 00:00:00',
  curlogin datetime NOT NULL default '0000-00-00 00:00:00',
  lastnews int(4) NOT NULL default '0',
  newsadmin int(4) NOT NULL default '0',
  comment_notify int(4) NOT NULL default '0',
  buttonstyle varchar(255) default NULL,
  homedir int(4) default NULL,
  firstdir int(4) default NULL,
  email_tool int(4) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table 'users'
--


INSERT INTO users VALUES (1,'0','admin','Administrator','21232f297a57a5a743894a0e4a801fc3',0,5170473,'',1,0,0,0,'English',0,'2005-01-07 16:16:28','2005-01-14 11:42:07',8,0,1,'rsdx_blue1',1,1,1);
INSERT INTO users VALUES (2,'1','guest','Anonymous','084e0343a0486ff05530df6c705c8bb4',0,0,'',0,0,0,1,'English',19,'2004-11-09 09:13:53','2004-11-10 05:02:42',0,0,0,'rsdx_blue1',1,1,0);



--
-- Table structure for table 'wordidx'
--

CREATE TABLE wordidx (
  wordid int(4) default NULL,
  word char(128) binary NOT NULL default '',
  UNIQUE KEY word_index (word)
) TYPE=MyISAM;

--
-- Dumping data for table 'wordidx'
--

CREATE TABLE peerreview (
        reviewer_id int(4) not null ,
        file_id int(4) not null ,
        status int(4) not null
);
UPDATE files set approved = '1';

