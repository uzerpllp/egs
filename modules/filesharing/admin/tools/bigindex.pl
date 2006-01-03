#!/usr/bin/perl


# ************************************************
# Script to index existing pdf and txt files
#
# Make sure the wordidx and searchidx tables are empty
# 
# Run this only once at the begining to upgrade an
# existing database.
#
# Change your database name and host name as needed
# in my $data_source = "DBI:mysql:intranet;host=localhost";
#
# Set the owl_fileDir and pdftotxt_location
#
# ./bigindex.pl
#
# For Windows:
# 
# Check shebang path to Perl:
# 
# #!c:/perl/bin/perl.exe
# 
# 
# Check path to pdftotext (C:\windows\system32 or C:\Winnt\system32 or anywhere in
# your path) as in OWL's Admin page
# (I normally have a c:\tools folder and put them all in there and add c:\tools to the
# system path)
# 
# ActivePerl doesn't always install all required DBI/DBD modules for Myqsl.
# Use Active Perl's PPM to check your installed packages.
# 
# IMPORTANT: If PDF file's security settings disallow copying text then the contents
# of the file will not be indexed.
# This is not an OWL or pdftotext bug but a drawback caused by the way PDF files are
# secured.
# ************************************************

use DBI;
use strict;

my $data_source = "DBI:mysql:intranet;host=localhost";
my $username = "root"; 
my $password = "";

#my $owl_FileDir = "c:\\program files\\apache group\\apache\\htdocs\\intranet";
my $owl_FileDir = "/var/www/html/intranet";

#my $pdftotxt_location = "c:\pdftotext.exe";
my $pdftotxt_location = "/usr/bin/pdftotext";
my $wordtotxt_location = "/usr/local/bin/antiword";


my $dbh = DBI->connect( $data_source, $username, $password,
	{RaiseError=>1,AutoCommit=>0})
   or die "Can't connect to $data_source: \n";

my $owlfileid; 
my $ext;

#first, lets read in the word index data, we reuse this over and over
my %words=();
my %wordindex=();
my $nextwordindex=1;

my $getwrdidx = $dbh->prepare(q{select wordid,word from wordidx}) or 
  die "Cant get word index from Owl database to start off with\n";

my $rc = $getwrdidx->execute or die "Cant execute word grab from db\n";

my $wordid;
my $word;

$nextwordindex=1;

while(($wordid,$word) = $getwrdidx->fetchrow_array)
{
  $wordindex{$word} = $wordid;

  if ($wordid > $nextwordindex)
  {
    $nextwordindex=$wordid;
  }
}

my $pidcount=0;
my $readallfileinfo = $dbh->prepare(q{select parent,id,filename from files});
my $ex=$readallfileinfo->execute;
my @pidlist,my @fidlist,my @efnames;

  while (($pidlist[$pidcount],$fidlist[$pidcount],$efnames[$pidcount]) = $readallfileinfo->fetchrow_array)
  {
    $pidcount++;
  }

  print "pidcount = $pidcount\n";
  my $i=0;
  for($i=0;$i<$pidcount;$i++) 
  {
    if ($pidlist[$i])
    {  #Don't index a owlfileid if its already in the index
  	  my $send="select * from searchidx where owlfileid = $fidlist[$i]";
	  my $chkdbl=$dbh->prepare($send); 
	  my $tex=$chkdbl->execute or die "blah outch";

      if ($chkdbl->rows==0) 
      {
        my $fileid=$pidlist[$i]; 
        my $realfileid=$fidlist[$i]; 
        my $filepath=$owl_FileDir."/".get_dirpathfs($fileid)."/".$efnames[$i];
	if (($filepath=~/\.txt/) || ($filepath=~/\.pdf/) || ($filepath=~/\.doc/)) 
	{#text file?
                print "$filepath is being indexed\n";
		IndexAFile($filepath,$realfileid);
	}
      }
    }
  }  

 $dbh->commit;
 $dbh->disconnect;



#-----------------------------------------------------------------------------
#IndexAFile Takes a filename (with full path), and a owl file id number
#If the file type is a PDF, it converts it temporarily to a .text file and 
#indexes it.  If its a txt file it just indexes it.

sub IndexAFile 
{
my $filename=$_[0];
my $fileidnum=$_[1];

my $deletefileafter=0;

#$12filename=~s/_/ /g;   #sub any _'s with spaces

if ($filename=~/\.(.*)$/)  #get extension
{
	$ext=$1;
}

if ($filename=~/\.pdf/)  #pdf file?
{
	`$pdftotxt_location "$filename" "$filename.text"`;
	$filename=$filename.'.text';
	$deletefileafter=1;
}
elsif ($filename=~/\.doc/)  #doc file?
{
        `/bin/sh -c '$wordtotxt_location "$filename"' > '$filename.text'`;

        #  '$wordtotext_location \"$filename\" \" > $filename.text\"'; 
        # Windows! `$wordtotxt_location "$filename" >"$filename.text"`;
	$filename=$filename.'.text';
	$deletefileafter=1;
}
#{
	#if (!($filename=~/txt/)) #text file?
	#{
		#die  "Invalid File type, currently only pdf and txt files indexable\n";
	#}
#}

open(THEINFILE,$filename); # or die PARMS " failed open";

my %words=();
my $w;

while(<THEINFILE>)
{
  chop();
  while(/([a-zA-Z][A-Za-z\']*)/g)
  {
    $w=lc($1);
    $words{$w}++;
	if ($words{$w}==1)
	{
	  if ($wordindex{$w})
	  {
	  	my $addsrchidx= $dbh->prepare(q{insert into searchidx(wordid,owlfileid) VALUES(?,?)});
	  	$addsrchidx->execute($wordindex{$w},$fileidnum);
	  }
	  else
	  {
	  	$wordindex{$w}=$nextwordindex;
	  	my $addsrchidx= $dbh->prepare(q{insert into searchidx(wordid,owlfileid) VALUES(?,?)});
	  	$addsrchidx->execute($wordindex{$w},$fileidnum);
	  	my $addwrdidx = $dbh->prepare(q{insert into wordidx(wordid,word) VALUES (?,?)});
	  	$addwrdidx->execute($nextwordindex,$w);
	  	$nextwordindex++;
	  }
	}
  }
}# end of while
  close(THEINFILE);
  if ($deletefileafter==1)  #is filename a temp file created just for indexing?
  {
	 unlink($filename);  #delete
  }
} #end of indexafile subroutine


#-----------------------------------------------------------------------------
#fid_to_name takes a parent id passed in and returns the name of that file
sub fid_to_name #($parent)
{
	my $parent=$_[0];
	my $send = "select name from folders where id = $parent";
	my $tmp = $dbh->prepare($send); #q{select name from folders where id = $parent});
	$tmp->execute;

	my $name;
	while(($name) = $tmp->fetchrow_array)
	{
		return $name;
	}
}



#-----------------------------------------------------------------------------
#get_dirpathfs : Get Directory Path Forward Slash
#passed a fileid it returns a string with the directory path to get to the file
sub get_dirpathfs
{
  my $parent = $_[0];
  my $name = fid_to_name($parent);
  my $navbar = "$name";
  my $new = $parent;
  while ($new != "1")
  {
	my $send="select parent from folders where id = $new";
	my $dp=$dbh->prepare($send); #q{select parent from folders where id = $new});
	$dp->execute;

	my $newparentid=$dp->fetchrow_array;

    if($newparentid == "")
	{
      last;
	}
    $name = fid_to_name($newparentid);
    $navbar = "$name/" . $navbar;
    $new = $newparentid;
  }
  return $navbar;
}

