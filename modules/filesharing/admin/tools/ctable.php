<html>
<head>
<title>OWL Database - Load Script</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#000066" vlink="#666666" alink="#000066">
<?php
// THIS SCRIPT will allow you to create the Owl mysql tables in the database of your choice.

// you can call this script with:
//
// http://yourwebserver.com/intranet/admin/tools/ctable.php?action=clean
//
// This will Drop the existing database defined bellow in database_instance
// and recreate a default Owl Database.
//
// 

$database_instance = "intranet";
$table_prefix = "";

//$dblink = mysql_connect("server.hosting.your.database","username","password") or die ("could not connect");
$dblink = mysql_connect("localhost","root","") or die ("could not connect");

if ($action == "clean")
{
   print("<h2>Droping The Database....</h2>");
   $select = "DROP DATABASE $database_instance";
   $result = mysql_db_query($database_instance,$select,$dblink); 

   print("<h2>Creating The Database....</h2>");
   mysql_create_db($database_instance);
}

if ($action == "delete")
{
print("<h3>Droping table active_sessions....</h3>");
   $select ="DROP TABLE IF EXISTS " . $table_prefix ."active_sessions;";
   $result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not DROP TABLE active_sessions");
print("<h3>Droping table comments....</h3>");
   $select ="DROP TABLE IF EXISTS " . $table_prefix ."comments;";
   $result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not DROP TABLE comments");
print("<h3>Droping table docfields....</h3>");
   $select ="DROP TABLE IF EXISTS " . $table_prefix ."docfields;";
   $result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not DROP TABLE docfields");
print("<h3>Droping table docfieldslabel....</h3>");
   $select ="DROP TABLE IF EXISTS " . $table_prefix ."docfieldslabel;";
   $result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not DROP TABLE docfieldslabel");
print("<h3>Droping table docfieldvalues....</h3>");
   $select ="DROP TABLE IF EXISTS " . $table_prefix ."docfieldvalues;";
   $result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not DROP TABLE docfieldvalues");
print("<h3>Droping table doctype....</h3>");
   $select ="DROP TABLE IF EXISTS " . $table_prefix ."doctype;";
   $result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not DROP TABLE doctype");
print("<h3>Droping table filedata....</h3>");
   $select ="DROP TABLE IF EXISTS " . $table_prefix ."filedata;";
   $result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not DROP TABLE filedata");
print("<h3>Droping table files....</h3>");
   $select ="DROP TABLE IF EXISTS " . $table_prefix ."files;";
   $result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not DROP TABLE files");
print("<h3>Droping table folders....</h3>");
   $select ="DROP TABLE IF EXISTS " . $table_prefix ."folders;";
   $result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not DROP TABLE folders");
print("<h3>Droping table groups....</h3>");
   $select ="DROP TABLE IF EXISTS " . $table_prefix ."groups;";
   $result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not DROP TABLE groups");
print("<h3>Droping table html....</h3>");
   $select ="DROP TABLE IF EXISTS " . $table_prefix ."html;";
   $result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not DROP TABLE html");
print("<h3>Droping table membergroup....</h3>");
   $select ="DROP TABLE IF EXISTS " . $table_prefix ."membergroup;";
   $result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not DROP TABLE membergroup");
print("<h3>Droping table mimes....</h3>");
   $select ="DROP TABLE IF EXISTS " . $table_prefix ."mimes;";
   $result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not DROP TABLE mimes");
print("<h3>Droping table metakeywords....</h3>");
   $select ="DROP TABLE IF EXISTS " . $table_prefix ."metakeywords;";
   $result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not DROP TABLE metakeywords");
print("<h3>Droping table monitored_file....</h3>");
   $select ="DROP TABLE IF EXISTS " . $table_prefix ."monitored_file;";
   $result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not DROP TABLE monitored_file");
print("<h3>Droping table monitored_folder....</h3>");
   $select ="DROP TABLE IF EXISTS " . $table_prefix ."monitored_folder;";
   $result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not DROP TABLE monitored_folder");
print("<h3>Droping table news....</h3>");
   $select ="DROP TABLE IF EXISTS " . $table_prefix ."news;";
   $result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not DROP TABLE news");
print("<h3>Droping table owl_log....</h3>");
   $select ="DROP TABLE IF EXISTS " . $table_prefix ."owl_log;";
   $result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not DROP TABLE owl_log");
print("<h3>Droping table prefs....</h3>");
   $select ="DROP TABLE IF EXISTS " . $table_prefix ."prefs;";
   $result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not DROP TABLE prefs");
print("<h3>Droping table searchidx....</h3>");
   $select ="DROP TABLE IF EXISTS " . $table_prefix ."searchidx;";
   $result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not DROP TABLE searchidx");
print("<h3>Droping table users....</h3>");
   $select ="DROP TABLE IF EXISTS " . $table_prefix ."users;";
   $result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not DROP TABLE users");
print("<h3>Droping table wordidx....</h3>");
   $select ="DROP TABLE IF EXISTS " . $table_prefix ."wordidx;";
   $result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not DROP TABLE wordidx");
}



// -- MySQL dump 8.22
// --
// -- Host: localhost    Database: intranet
// ---------------------------------------------------------
// -- Server version	3.23.56-log

print("<h2>Start....</h2>");

// --
// -- Table structure for table 'active_sessions'
// --

print("<h3>Creating table active_sessions....</h3>");
$select = "CREATE TABLE " . $table_prefix ."active_sessions (
  sessid char(32) NOT NULL default '',
  usid char(25) default NULL,
  lastused int(10) unsigned default NULL,
  ip char(16) default NULL,
  currentdb int(4) default NULL,
  PRIMARY KEY  (sessid)
) TYPE=MyISAM;";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not CREATE TABLE active_sessions");

// --
// -- Table structure for table 'comment'
// --

print("<h3>Creating table comments....</h3>");
$select = "CREATE TABLE " . $table_prefix ."comments (
  id int(4) NOT NULL auto_increment,
  fid int(4) NOT NULL default '0',
  userid int(4) default NULL,
  comment_date datetime NOT NULL default '0000-00-00 00:00:00',
  comments text NOT NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not CREATE TABLE comment");

//--
//-- Table structure for table 'docfields'
//--

print("<h3>Creating table docfields....</h3>");
$select = "CREATE TABLE " . $table_prefix ."docfields (
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
) TYPE=MyISAM;";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not CREATE TABLE docfields");

//--
//-- Table structure for table 'docfieldslabel'
//--

print("<h3>Creating table docfieldslabel....</h3>");
$select = "CREATE TABLE " . $table_prefix ."docfieldslabel (
  doc_field_id int(4) NOT NULL default '0',
  field_label char(80) NOT NULL default '',
  locale char(80) NOT NULL default ''
) TYPE=MyISAM;";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not CREATE TABLE docfieldslabel");

//--
//-- Table structure for table 'docfieldvalues'
//--

print("<h3>Creating table docfieldvalues....</h3>");
$select = "CREATE TABLE " . $table_prefix ."docfieldvalues (
  id int(4) NOT NULL auto_increment,
  file_id int(4) NOT NULL default '0',
  field_name char(80) NOT NULL default '',
  field_value char(80) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not CREATE TABLE docfieldvalues");

//--
//-- Table structure for table 'doctype'
//--

print("<h3>Creating table doctype....</h3>");
$select = "CREATE TABLE " . $table_prefix ."doctype (
  doc_type_id int(4) NOT NULL auto_increment,
  doc_type_name char(255) NOT NULL default '',
  PRIMARY KEY  (doc_type_id)
) TYPE=MyISAM;";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not CREATE TABLE doctype");

//--
//-- Inserting data for table 'doctype'
//--

$select = "INSERT INTO " . $table_prefix ."doctype VALUES (1,'Default');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE doctype");

// --
// -- Table structure for table 'filedata'
// --

print("<h3>Creating table filedata....</h3>");
$select = "CREATE TABLE " . $table_prefix ."filedata (
  id int(4) NOT NULL default '0',
  compressed int(4) NOT NULL default '0',
  data longblob,
  PRIMARY KEY  (id)
) TYPE=MyISAM;";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not CREATE TABLE filedata");

// --
// -- Table structure for table 'files'
// --

--
-- Dumping data for table 'files'
print("<h3>Creating table files....</h3>");
$select = "CREATE TABLE " . $table_prefix ."files (
  id int(4) NOT NULL auto_increment,
  name varchar(80) NOT NULL default '',
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
  UNIQUE KEY fileid_index (id)
  KEY parentid_index (parent)
) TYPE=MyISAM;";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not CREATE TABLE files");

// --
// -- Data for table 'files'
// --

$select = "INSERT INTO " . $table_prefix ."files VALUES (1,'Test File','test.txt',36,1,1,'2000-12-27 05:17:00','','',0,0,'2000-12-27 05:17:00',0,0,1,0,'',1,0,0,1);";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE files");

// --
// -- Table structure for table 'folders'
// --

print("<h3>Creating table folders....</h3>");
$select = "CREATE TABLE " . $table_prefix ."folders (
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
) TYPE=MyISAM;";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not CREATE TABLE  folders"); 

// --
// -- Data for table 'folders'
// --

$select = "INSERT INTO " . $table_prefix ."folders VALUES (1,'Documents',0,'','51',0,1,'','2004-10-17 08:11:50');;";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE folders");

// --
// -- Table structure for table 'groups'
// --

print("<h3>Creating table groups....</h3>");
$select = "CREATE TABLE " . $table_prefix ."groups (
  id int(4) NOT NULL auto_increment,
  name char(30) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;";

$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not CREATE TABLE groups");

// --
// -- Data for table 'groups'
// --

$select = "INSERT INTO " . $table_prefix ."groups VALUES (0, 'Administrators');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE groups");
$select = "UPDATE " . $table_prefix ."groups SET id = 0 WHERE name = 'Administrators';";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not UPDATE TABLE groups");
$select = "INSERT INTO " . $table_prefix ."groups VALUES (1, 'Anonymous');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT groups");
$select = "INSERT INTO " . $table_prefix ."groups VALUES (2, 'File Admin');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT groups");

// --
// -- Table structure for table 'html'
// --

print("<h3>Creating table html....</h3>");
$select = "CREATE TABLE " . $table_prefix ."html (
  id int(4) NOT NULL auto_increment,
  table_expand_width char(15) default NULL,
  table_collapse_width char(15) default NULL,
  body_background char(255) default NULL,
  owl_logo char(255) default NULL,
  body_textcolor char(15) default NULL,
  body_link char(15) default NULL,
  body_vlink char(15) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;";
                                                                                                                                                                                             

$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not CREATE TABLE html");

// --
// -- Data for table 'html'
// --
$select = "INSERT INTO " . $table_prefix ."html VALUES (1,'90%','50%','','owl.gif','#000000','#000000','#000000');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE html");

// --
// -- Table structure for table 'membergroup'
// --

print("<h3>Creating table membergroup....</h3>");
$select = "CREATE TABLE " . $table_prefix ."membergroup (
  userid int(4) NOT NULL default '0',
  groupid int(4) NOT NULL default '0'
) TYPE=MyISAM;";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not CREATE TABLE membergroup");

//--
//-- Table structure for table 'metakeywords'
//--

print("<h3>Creating table metakeywords....</h3>");

$select = "CREATE TABLE " . $table_prefix ."metakeywords (
  keyword_id int(4) NOT NULL auto_increment,
  keyword_text char(255) NOT NULL default '',
  PRIMARY KEY  (keyword_id)
) TYPE=MyISAM;");


// --
// -- Table structure for table 'mimes'
// --

print("<h3>Creating table mimes....</h3>");
$select = "CREATE TABLE " . $table_prefix ."mimes (
  filetype char(10) NOT NULL default '',
  mimetype char(50) NOT NULL default '',
  PRIMARY KEY  (filetype)
) TYPE=MyISAM;";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not CREATE TABLE mimes");

// --
// -- Data for table 'mimes'
// --

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('ai', 'application/postscript');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('aif', 'audio/x-aiff');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('aifc', 'audio/x-aiff');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('aiff', 'audio/x-aiff');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('asc', 'text/plain');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('au', 'audio/basic');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('avi', 'video/x-msvideo');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('bcpio', 'application/x-bcpio');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('bin', 'application/octet-stream');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('bmp', 'image/bmp');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('cdf', 'application/x-netcdf');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('class', 'application/octet-stream');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('cpio', 'application/x-cpio');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('cpt', 'application/mac-compactpro');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('csh', 'application/x-csh');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('css', 'text/css');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('dcr', 'application/x-director');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('dir', 'application/x-director');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('dms', 'application/octet-stream');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('doc', 'application/msword');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('dvi', 'application/x-dvi');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('dxr', 'application/x-director');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('eps', 'application/postscript');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('etx', 'text/x-setext');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('exe', 'application/octet-stream');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('ez', 'application/andrew-inset');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('gif', 'image/gif');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('gtar', 'application/x-gtar');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('hdf', 'application/x-hdf');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('hqx', 'application/mac-binhex40');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('htm', 'text/html');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('html', 'text/html');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('ice', 'x-conference/x-cooltalk');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('ief', 'image/ief');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('iges', 'model/iges');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('igs', 'model/iges');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('jpe', 'image/jpeg');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('jpeg', 'image/jpeg');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('jpg', 'image/jpeg');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('js', 'application/x-javascript');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('kar', 'audio/midi');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('latex', 'application/x-latex');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('lha', 'application/octet-stream');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('lzh', 'application/octet-stream');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('man', 'application/x-troff-man');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('me', 'application/x-troff-me');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('mesh', 'model/mesh');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('mid', 'audio/midi');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('midi', 'audio/midi');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('mif', 'application/vnd.mif');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('mov', 'video/quicktime');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('movie', 'video/x-sgi-movie');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('mp2', 'audio/mpeg');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('mp3', 'audio/mpeg');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('mpe', 'video/mpeg');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('mpeg', 'video/mpeg');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('mpg', 'video/mpeg');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('mpga', 'audio/mpeg');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('ms', 'application/x-troff-ms');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('msh', 'model/mesh');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('nc', 'application/x-netcdf');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('oda', 'application/oda');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('pbm', 'image/x-portable-bitmap');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('pdb', 'chemical/x-pdb');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('pdf', 'application/pdf');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('pgm', 'image/x-portable-graymap');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('pgn', 'application/x-chess-pgn');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('png', 'image/png');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('pnm', 'image/x-portable-anymap');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('ppm', 'image/x-portable-pixmap');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('ppt', 'application/vnd.ms-powerpoint');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('ps', 'application/postscript');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('qt', 'video/quicktime');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('ra', 'audio/x-realaudio');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('ram', 'audio/x-pn-realaudio');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('ras', 'image/x-cmu-raster');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('rgb', 'image/x-rgb');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('rm', 'audio/x-pn-realaudio');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('roff', 'application/x-troff');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('rpm', 'audio/x-pn-realaudio-plugin');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('rtf', 'text/rtf');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('rtx', 'text/richtext');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('sgm', 'text/sgml');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('sgml', 'text/sgml');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('sh', 'application/x-sh');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('shar', 'application/x-shar');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('silo', 'model/mesh');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('sit', 'application/x-stuffit');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('skd', 'application/x-koan');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('skm', 'application/x-koan');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('skp', 'application/x-koan');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('skt', 'application/x-koan');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('smi', 'application/smil');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('smil', 'application/smil');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('snd', 'audio/basic');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('spl', 'application/x-futuresplash');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('src', 'application/x-wais-source');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('sv4cpio', 'application/x-sv4cpio');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('sv4crc', 'application/x-sv4crc');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('swf', 'application/x-shockwave-flash');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('t', 'application/x-troff');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('tar', 'application/x-tar');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('tcl', 'application/x-tcl');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('tex', 'application/x-tex');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('texi', 'application/x-texinfo');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('texinfo', 'application/x-texinfo');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('tif', 'image/tiff');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('tiff', 'image/tiff');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('tr', 'application/x-troff');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('tsv', 'text/tab-separated-values');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('txt', 'text/plain');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('ustar', 'application/x-ustar');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('vcd', 'application/x-cdlink');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('vrml', 'model/vrml');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('wav', 'audio/x-wav');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('wrl', 'model/vrml');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('xbm', 'image/x-xbitmap');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('xls', 'application/vnd.ms-excel');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('xml', 'text/xml');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('xpm', 'image/x-xpixmap');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('xwd', 'image/x-xwindowdump');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('xyz', 'chemical/x-pdb');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('zip', 'application/zip');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('gz', 'application/x-gzip');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('tgz', 'application/x-gzip');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('sxw','application/vnd.sun.xml.writer');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('stw','application/vnd.sun.xml.writer.template');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('sxg','application/vnd.sun.xml.writer.global');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('sxc','application/vnd.sun.xml.calc');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('stc','application/vnd.sun.xml.calc.template');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('sxi','application/vnd.sun.xml.impress');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('sti','application/vnd.sun.xml.impress.template');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('sxd','application/vnd.sun.xml.draw');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('std','application/vnd.sun.xml.draw.template');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");

$select = "INSERT INTO " . $table_prefix ."mimes VALUES ('sxm','application/vnd.sun.xml.math');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE mimes");


// --
// -- Table structure for table 'monitored_file'
// --

print("<h3>Creating table monitored_file....</h3>");
$select = "CREATE TABLE " . $table_prefix ."monitored_file (
  id int(4) NOT NULL auto_increment,
  userid int(4) NOT NULL default '0',
  fid int(4) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not CREATE TABLE monitored_file");

// --
// -- Table structure for table 'monitored_folder'
// --

print("<h3>Creating table monitored_folder....</h3>");
$select = "CREATE TABLE " . $table_prefix ."monitored_folder (
  id int(4) NOT NULL auto_increment,
  userid int(4) NOT NULL default '0',
  fid int(4) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not CREATE TABLE monitored_folder");

// --
// -- Table structure for table 'news'
// --

print("<h3>Creating table news....</h3>");
$select = "CREATE TABLE " . $table_prefix ."news (
  id int(4) NOT NULL auto_increment,
  gid int(4) NOT NULL default '0',
  news_title varchar(255) NOT NULL default '',
  news_date datetime NOT NULL default '0000-00-00 00:00:00',
  news text NOT NULL,
  news_end_date datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (id)
) TYPE=MyISAM;";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not CREATE TABLE news");

// --
// -- Table structure for table 'owl_log'
// --

print("<h3>Creating table owl_log....</h3>");
$select = "CREATE TABLE " . $table_prefix ."owl_log (
  id int(4) NOT NULL auto_increment,
  userid int(4) default NULL,
  filename varchar(255) default NULL,
  parent int(4) default NULL,
  action varchar(40) default NULL,
  details text,
  ip varchar(16) default NULL,
  agent varchar(100) default NULL,
  logdate datetime NOT NULL default '0000-00-00 00:00:00',
  type varchar(20) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not CREATE TABLE owl_log");

//--
//-- Table structure for table 'peerreview'
//--

print("<h3>Creating table peerreview....</h3>");
$select = "CREATE TABLE " . $table_prefix ."peerreview (
  reviewer_id int(4) NOT NULL default '0',
  file_id int(4) NOT NULL default '0',
  status int(4) NOT NULL default '0'
) TYPE=MyISAM;";

$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not CREATE TABLE peerreview");


// --
// -- Table structure for table 'prefs'
// --

print("<h3>Creating table prefs....</h3>");
$select = "CREATE TABLE " . $table_prefix ."prefs (
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
) TYPE=MyISAM;";

$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not CREATE TABLE prefs");

// --
// -- Data for table 'prefs'
// --

$select = "INSERT INTO prefs VALUES (1,'owl@yourdomain.com','OWL','noreply@yourdomain.com','localhost','[OWL] :','false',1,0,0,1,'<font color=red>No Info</font>','not in\r\ndb',50,0,1,5120000,'/var/www/html/intranet/Documents',9000,1,1,0,1,'/usr/bin/mysqldump','/bin/gzip','/bin/tar','/usr/bin/unzip','/usr/local/bin/pod2html','/usr/bin/pdftotext','/usr/local/bin/antiword',4,54,0,1,1,5,0,0,0,0,0,0,0,0,1,1,2,2,1,0,'',1,1,0,30,0,0,'',2,0,1,1,3,'',1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,0,0,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,0,0,0,0,1,'RESTORED-',1,0,'ABC-',3,0,0,0,1,1,'','0','0','1','0','1');";

$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE prefs");

// --
// -- Table structure for table 'searchidx'
// --

print("<h3>Creating table searchidx....</h3>");
$select = "CREATE TABLE " . $table_prefix ."searchidx (
  wordid int(4) default NULL,
  owlfileid int(4) default NULL,
  KEY search_fileid (owlfileid)
) TYPE=MyISAM;";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not CREATE TABLE searchidx");

// --
// -- Table structure for table 'users'
// --

print("<h3>Creating table users....</h3>");
$select = "CREATE TABLE " . $table_prefix ."users (
  id int(4) NOT NULL auto_increment,
  groupid varchar(10) NOT NULL default '',
  username varchar(20) NOT NULL default '',
  name varchar(50) NOT NULL default '',
  password varchar(50) NOT NULL default '',
  quota_max int(16) NOT NULL default '0',
  quota_current int(16) NOT NULL default '0',
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
  homedir int(4),
  firstdir int(4),
  email_tool int(4) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;";

$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not CREATE TABLE users");

// --
// -- Data for table 'users'
// --

$select = "INSERT INTO " . $table_prefix ."users VALUES (1,'0','admin','Administrator','21232f297a57a5a743894a0e4a801fc3',0,0,NULL,0,0,0,0,'English',0,now(),now(),0,0,0,'Blue','1','1','0');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE users");

$select = "INSERT INTO " . $table_prefix ."users VALUES (2,'1','guest','Anonymous','084e0343a0486ff05530df6c705c8bb4',0,0,NULL,0,0,1,1,'English',19,now(),now(),0,0,0,'Blue','1','1','0');";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not INSERT TABLE users");

// --
// -- Table structure for table 'wordidx'
// --
print("<h3>Creating table wordidx....</h3>");
$select = "CREATE TABLE " . $table_prefix ."wordidx (
  wordid int(4) default NULL,
  word char(128) NOT NULL default '',
  UNIQUE KEY word_index (word)
) TYPE=MyISAM;";
$result = mysql_db_query($database_instance,$select,$dblink) or die ("Could not CREATE TABLE wordidx");



mysql_close($dblink);
?>
<h2> Done !</h2>
</body>
</html>

