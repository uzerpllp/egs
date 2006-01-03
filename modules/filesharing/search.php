<?php 
/*
 * search.php
 *
 * Author: Steve Bourgeois <owl@bozzit.com>
 * Project Founder: Chris Vincent <cvincent@project802.net>
 *
 * Copyright (c) 1999-2005 The Owl Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 *
 * $Id: search.php,v 1.13 2005/03/26 20:14:50 b0zz Exp $
 */
require_once("./config/owl.php");
require_once("./lib/disp.lib.php");
require_once("./lib/owl.lib.php");
require_once("./lib/security.lib.php");


if (isset($search_id))
{
     $sql->query("SELECT metadata FROM $default->owl_files_table where id = '$search_id'");
     while($sql->next_record()) 
     {
        $query = $sql->f("metadata");
     }

     $sql->query("SELECT field_value FROM $default->owl_docfieldvalues_table where file_id = '$search_id'");
     while($sql->next_record()) 
     {
        $query .= $sql->f("field_value");
     }
}

if (!isset($query))
{
   printError($owl_lang->query_empty);
}

// V4B RNG Start
$urlArgs = array();
$urlArgs['sess']      = $sess;
$urlArgs['parent']    = $parent;
$urlArgs['expand']    = $expand;
$urlArgs['order']     = $order;
$urlArgs['sortorder'] = $sort;
// V4B RNG End

$dStartTime = time();

// Display the Footer Tools (Seach, Newsadmin and Admin)
$bDisplayFooterTools = true;




$groupid = owlusergroup($userid);

$query = ereg_replace("[$default->list_of_chars_to_remove_from_wordidx]","",$query);
$query = trim($query);

if (strlen(trim($query)) == 0) 
{
   include_once("./lib/header.inc");
   include_once("./lib/userheader.inc");

   print("<center>\n");
   if ($expand == 1)
   {
      print("<table class='border1' cellspacing='0' cellpadding='0' border='0' width='$default->table_expand_width'><tr><td align='left' valign='top' width='100%'>\n");
   }
   else
   {
      print("<table class='border1' cellspacing='0' cellpadding='0' border='0' width='$default->table_collapse_width'><tr><td align='left' valign='top' width='100%'>\n");
   }
   fPrintButtonSpace(12, 1);
   print("<br></br>\n");
   print("<table class='border2' cellspacing='0' cellpadding='0' border='0' width='100%'><tr><td align='left' valign='top' width='100%'>\n");

   if ($default->show_prefs == 1 or $default->show_prefs == 3)
   {
      fPrintPrefs("infobar1", "top");
   }
   fPrintButtonSpace(12, 1);

   print("<table align=\"center\" width='98%' cellspacing='0' cellpadding='0' border='0'>");
   print("<tr>");
   print("<td>");
   if (isset($search_id))
   {
      fPrintSectionHeader($owl_lang->related_query_empty, "admin3");
   }
   else
   {
      fPrintSectionHeader($owl_lang->query_empty, "admin3");
   }
   print("<br></br>");
   print("</td>\n</tr>\n</table>");

   fPrintButtonSpace(12, 1);

   if ($default->show_search == 2 or $default->show_search == 3)
   {
      fPrintSpacer();
      fPrintSearch(1);
   }
   fPrintButtonSpace(12, 1);

   if ($default->show_prefs == 2 or $default->show_prefs == 3)
   {
      fPrintPrefs("infobar2");
   }
   print("</td>\n</tr>\n</table>\n");
   include("./lib/footer.inc");
   exit;
}
// first we have to find out what we can search
// we need a list of all folder that can be searched
// so we need to see which folders the user can read
// 692380 search exclude old documents

$sql = new Owl_DB;

// added by rsa@newtec.be (Ruben Samaey)
// setting up a second db connection to search tables based on a still running query
// needed for searching for matches in comments attached to files
$sql_two = new Owl_DB;
// end add by rsa

if ( $parent == 1)
{
   $currentfolder = 0;
}

function fFolderList( $FolderId )
{
   global $default;
   $qGetFolderList = new Owl_DB;
   $qGetFolderList->query("SELECT id from $default->owl_folders_table where parent = '$FolderId'");

   while ( $qGetFolderList->next_record())
   {
      $sFolderWhereClause .= " or id = '" . $qGetFolderList->f("id") . "'";
      $sFolderWhereClause .= fFolderList($qGetFolderList->f("id"));
   } 
   return $sFolderWhereClause;
}

if ($currentfolder == 1)
{
   $sFolderWhereClause = " and (id = '$parent'";
   $sFolderWhereClause .= fFolderList($parent);
   $sFolderWhereClause .= ")";

   $sql->query("SELECT id,creatorid,groupid,security FROM $default->owl_folders_table where name <> 'backup' and id = '$parent' $sFolderWhereClause");
}
else
{
   $sql->query("SELECT * FROM $default->owl_folders_table where name <> 'backup'");
}

//
// get all the folders that the user can read



$iCount=0;
$iResults=0;
while($sql->next_record()) 
{

   $id = $sql->f("id");
   if(check_auth($id, "folder_view", $userid, false, false) == 1) 
   {
      $iCount++;
      $PrintDot = $iCount % 50;
      if ($PrintDot == 0)
      {
         print(".");
      }
      $folders[$id] = $id;

      $sQuery = explode(" ", $query);
      foreach($sQuery as $keyword)
      {
         if($keyword <> "*")
         {
            if(eregi("$keyword", $sql->f("name")) or eregi("$keyword", $sql->f("description")))
            {
               $iResults=1;
               $aFolderMatchSearch[$id][score] += 2;
               $aFolderMatchSearch[$id][id] = $id;
               $aFolderMatchSearch[$id][name] = $sql->f("name");
               $aFolderMatchSearch[$id][description] = $sql->f("description");
               $aFolderMatchSearch[$id][parent] = $sql->f("parent");
            }
         }
      }
   }
}

include_once("./lib/header.inc");
include_once("./lib/userheader.inc");

print("<center>\n");
if ($expand == 1)
{
   print("<table class='border1' cellspacing='0' cellpadding='0' border='0' width='$default->table_expand_width'><tr><td align='left' valign='top' width='100%'>\n");
}
else
{
   print("<table class='border1' cellspacing='0' cellpadding='0' border='0' width='$default->table_collapse_width'><tr><td align='left' valign='top' width='100%'>\n");
}
fPrintButtonSpace(12, 1);
print("<br></br>\n");
print("<table class='border2' cellspacing='0' cellpadding='0' border='0' width='100%'><tr><td align='left' valign='top' width='100%'>\n");

if ($default->show_prefs == 1 or $default->show_prefs == 3)
{
   fPrintPrefs("infobar1", "top");
}
fPrintButtonSpace(12, 1);
print("<br></br>\n");

fPrintNavBar($parent, $owl_lang->search . ":&nbsp;");
if ($default->show_search == 1 or $default->show_search == 3)
{
   $keywords = $query;
   fPrintSearch();
   fPrintSpacer();
}  

//
// get all the files in those folders that the user can read
print("<br></br><div class='searchresult'>$owl_lang->search_for_folders</div>");
print("<div class='searchresult'>$owl_lang->search_for_files</div>");

$iCount=0;
foreach($folders as $item) 
{
   // BEGIN NEW STUFF
   #Clean up the keywords a bit (remove all commas and duplicate spaces)
   $sqlquery = "";
   $glue = "";
   if ($withindocs == "1")
   {
      $keywords = strtolower($query);
   }
   else
   { 
      $keywords = $query;
   }
   $keywords = str_replace(', ', ' ', $keywords);
   $keywords = str_replace(',', ' ', $keywords);
   $keywords = str_replace('  ', ' ', $keywords);

   #Replace asterisks with % signs for MySQL wildcards
   $keywords = str_replace("*", "%", $keywords);

   #Tack the search terms onto the query
   if ($withindocs == "1")
   {
      $keywordid = "";
      $sqlquery .= " AND (";
      if($boolean == "phrase")
      {
         #Match the entire term
         $sql = new Owl_DB;
         //$sql->query("SELECT wordid from $default->owl_wordidx where word='$keywords'");
         //if ($sql->num_rows() > 0)
         //{
            //$sql->next_record();
            //$keywordid .= " OR wordid = '" . $sql->f("wordid") . "'";
         //}
         //else
         //{
            $keywords = strtolower($keywords);

            $sql->query("SELECT * from $default->owl_wordidx where word like '%$keywords%'");
            if ($sql->num_rows() > 0)
            {
               while($sql->next_record())
               {
                  $keywordid .= " OR wordid = '" . $sql->f("wordid") . "'";
               }
               //$keywordid = $sql->f("wordid");
            }
            else
            {
               $keywordid = " OR wordid = '-1' ";
            }
         //}
         //$sqlquery .= "name LIKE '%$keywords%' OR metadata LIKE '%$keywords%' OR description LIKE '%$keywords%' OR filename LIKE '%$keywords%' OR wordid = '$keywordid'";
         $sqlquery .= "name LIKE '%$keywords%' OR metadata LIKE '%$keywords%' OR description LIKE '%$keywords%' OR filename LIKE '%$keywords%' $keywordid";
      }
      else
      {
         #Match any or all words
         $keywordid = '';
         $tok = strtok($keywords, " ");
         while($tok)
         {
            //$sql = new Owl_DB;
            //$sql->query("SELECT wordid from $default->owl_wordidx where word='$tok'");
            //if ($sql->num_rows() > 0)
            //{
               //$sql->next_record();
               //$keywordid .= " OR wordid = '" . $sql->f("wordid") . "'";
               //$keywordid = $sql->f("wordid");
            //}
            //else
            //{
               $sql->query("SELECT * from $default->owl_wordidx where word like '%$tok%'");
               if ($sql->num_rows() > 0)
               {
                  //$sql->next_record();
                  while($sql->next_record())
                  {
                     $keywordid .= " OR wordid = '" . $sql->f("wordid") . "'";
                  }
                  //$keywordid = $sql->f("wordid");
               }
               else
               {
                  $keywordid = " OR wordid = '-1' ";
                  //$keywordid = -1;
               }
            //}

            $sqlquery .= "$glue (name LIKE '%$tok%' OR metadata LIKE '%$tok%' OR description LIKE '%$tok%' OR filename LIKE '%$tok%' ";

            //$sqlquery .= " OR wordid = '$keywordid')";
            $sqlquery .= " $keywordid)";

            $glue = ($boolean == "all") ? " AND" : " OR";
            //$glue = " OR";
            $tok = strtok(" ");
         }
      }
      $sqlquery .= ")";
   }       
   else
   {
      $sqlquery .= " AND ((";
      if($boolean == "phrase")
      {
         #Match the entire term
         $sql = new Owl_DB;
         $sqlquery .= "name LIKE '%$keywords%' OR metadata LIKE '%$keywords%' OR description LIKE '%$keywords%' OR filename LIKE '%$keywords%' )";

            $sql_two->query("select field_name from $default->owl_docfields_table");
            $iQueryTwo = $sql_two->num_rows();
            if ( $iQueryTwo > 0)
            {
               $sqlquery2 .= " OR (";
               while($sql_two->next_record())
               {
                  $sqlquery2 .= "$glue3 (field_name='". $sql_two->f("field_name") ."' and field_value LIKE '%$keywords%')";
                  //$glue3 = ($boolean == "all") ? " AND" : " OR";
                  $glue3 = " OR ";
               }
               $sqlquery2 .= ")";
            }
      }
      else
      {
         #Match any or all words
         $tok = strtok($keywords, " ");
         while($tok)
         {
            $glue3 = "";
            $sql_two->query("select field_name from $default->owl_docfields_table");
            $iQueryTwo = $sql_two->num_rows();
            if ( $iQueryTwo > 0)
            {
               $sqlquery2 .= " OR (";

               while($sql_two->next_record())
               {
                  $sqlquery2 .= "$glue3 (field_name='". $sql_two->f("field_name") ."' and field_value LIKE '%$tok%')";
                  //$glue3 = ($boolean == "all") ? " AND" : " OR";
                  $glue3 = " OR ";
               }
               $sqlquery2 .= ")";
            }
            $sqlquery .= "$glue (name LIKE '%$tok%' OR metadata LIKE '%$tok%' OR description LIKE '%$tok%' OR filename LIKE '%$tok%')";
            $glue = ($boolean == "all") ? " AND" : " OR";

            $tok = strtok(" ");
            
         }
      $sqlquery2 .= ")";
      }
      $sqlquery .= ")";
   } 

   if ($withindocs == "1")
   {
     $sql->query("SELECT f_size, smodified, f.id as fid, parent, name, metadata, description, filename, checked_out, url FROM $default->owl_files_table f left outer join $default->owl_searchidx on owlfileid=f.id where approved = '1' and parent = '$item' $sqlquery LIMIT 10");

     //print("<BR> DEBUG: SELECT f_size, smodified, f.id as fid, parent, name, metadata, description, filename, checked_out, url FROM $default->owl_files_table f left outer join $default->owl_searchidx on owlfileid=f.id where parent = '$item' $sqlquery LIMIT 10");
   }
   else
   {
     $sSearchQuery = "SELECT f_size, smodified, f.id as fid, parent, name, metadata, description, filename, checked_out, url  FROM $default->owl_files_table f left outer join $default->owl_docfieldvalues_table d on f.id=file_id where approved = '1' and parent = '$item' $sqlquery $sqlquery2";
     //print("<BR> DEBUG: $sSearchQuery");
     //print("<BR> DEBUG: $sqlquery2");
     $sql->query($sSearchQuery);
     $sqlquery2 = "";
     
   }

 
   while($sql->next_record()) 
   {
      $id = $sql->f("fid");
      //$id = $sql->f("id");
      if ($oldid == $id) 
      {
         $files[$id][score] += 1;
         continue;
      }
      if(check_auth($id, "file_download", $userid, false, false) == 1) 
      {
         // added by rsa@newtec.be (Ruben Samaey)
         // perform a query to fetch all comments attached to the current file the user is authorized to download
         // all comments found are concattenated in $comment
         $comment = "";
         $sql_two->query("SELECT comments FROM $default->owl_comment_table where fid = '$id'");
         while($sql_two->next_record())  
         {
            $comment .= " ";
            $comment .= $sql_two->f("comments");
         }
         //end add by rsa@newtec.be
         $searchable_custom_fields = "";
          
         $sql_two->query("select * from $default->owl_docfieldvalues_table v left join $default->owl_docfields_table d on v.field_name = d.field_name where file_id = '$id' and searchable = 1;");
         while($sql_two->next_record())  
         {
            $searchable_custom_fields .= " ";
            $searchable_custom_fields .= $sql_two->f("field_value");
         }

         $files[$id][id] = $id;
         $files[$id][n] = $sql->f("name");
         $files[$id][m] = explode(" ", $sql->f("metadata"));
         $files[$id][d] = explode(" ", $sql->f("description"));
         $files[$id][f] = $sql->f("filename");
         $files[$id][c] = $sql->f("checked_out");
         $files[$id][u] = $sql->f("url");
         $files[$id][p] = $sql->f("parent");
         $files[$id][x] = $sql->f("description");
         $files[$id][s] = $sql->f("f_size");
         $files[$id][date] = $sql->f("smodified");
//added by rsa@newtec.be
         $files[$id][comments] = explode(" ",$comment);
//end add by rsa
         $files[$id][custom] = explode(" ",$searchable_custom_fields);

        $iCount++;
        $PrintDot = $iCount % 50;
        if ($PrintDot == 0)
        {
           print(".");
        }
        $files[$id][score] = 0;
        $oldid = $id;
      }
   }
}
print("<div class='searchresult'>$owl_lang->search_score</div>");
//
// right now we have the array $files with all possible files that the user has read access to

if (strlen(trim($query))>0) 
{
   //
   // break up our query string
   $query = explode(" ", $query);
   //
   // the is the meat of the matching
   if(sizeof($files) > 0) 
   {
      foreach($query as $keyword) 
      {
         if($keyword <> "*")
         {
            foreach(array_keys($files) as $key) 
            {
               // BEGIN enhancement Sunil Savkar
               // if the $parent string contains a keyword to be searched, then the score is
               // adjusted.  This takes into account the hierarchy.
               if(eregi("$keyword", find_path($files[$key][p]))) 
               {    
                  $iResults = 1;
                  $files[$key][score] = $files[$key][score] + 4;
               }
               if(eregi("$keyword", $files[$key][n])) 
               {
                  $iResults = 1;
                  $files[$key][score] = $files[$key][score] + 4;
               }
               if(eregi("$keyword", $files[$key][f]))
               {
                  $iResults = 1;
                  $files[$key][score] = $files[$key][score] + 3;
               }
               foreach($files[$key][m] as $metaitem) 
               {
                  // add 2 to the score if we find it in metadata (key search items)
                  if(eregi("$keyword", $metaitem)) 
                  {
                     $iResults = 1;
                     $files[$key][score] = $files[$key][score] + 2;
                  }
               }
               // added by rsa@newtec.be
               // search the exploded comment array
               foreach($files[$key][comments] as $commentitem) 
               {
                  // add 1 to the score if we find it in comments
                  if(eregi("$keyword", $commentitem)) 
                  {
                     $iResults = 1;
                     $files[$key][score] = $files[$key][score] + 1;
                  }
               }
               // end add rsa
               // search the exploded comment array
               foreach($files[$key][custom] as $customitem)
               {
                  if(eregi("$keyword", $customitem))
                  {
                     $iResults = 1;
                     $files[$key][score] = $files[$key][score] + 5;
                  }
               }

               foreach($files[$key][d] as $descitem) 
               {
                  // only add 1 for regular description matches
                  if(eregi("$keyword", $descitem)) 
                  {
                     $iResults = 1;
                     $files[$key][score] = $files[$key][score] + 1;
                  }
               }
               if ($withindocs == "1")
               {
                  $x = $files[$key][id];
                  $keyword = strtolower($keyword);
                  if(DoesFileIDContainKeyword($files[$key][id], $keyword) > 0) 
                  {
                     $iResults = 1;
                     $files[$key][score] = $files[$key][score] + 5;
                  }
               }
               $iCount++;
               $PrintDot = $iCount % 50;
               if ($PrintDot == 0)
               {
                  print(".");
               }
            }
         }
      }
   }
//
// gotta find order to the scores...any better ideas?
   if ($iResults > 0)
   {
      //print("<br></br>");
      $diff = time()-$dStartTime;
      $minsDiff = floor($diff/60);
      $diff -= $minsDiff*60;
      $secsDiff = $diff;
   
      print("<div class='searchresult'>($owl_lang->elapsed_time ".$minsDiff.'m '.$secsDiff.'s)'."</div>");
      print("<div class='searchresult'> $owl_lang->search_results_for \"".htmlspecialchars(implode(" ", $query))."\"</div><br></br>");
   
      $max = 90;
      $hit = 1;
      $CountLines = 0;
   
      print("<table class='margin2' cellspacing='0' cellpadding='0' border='0' width='100%'><tr><td align='left' valign='top'>\n");
      print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>");
      print("<tr>");

      if (($default->expand_search_disp_score and $expand == 1) or ($default->collapse_search_disp_score and $expand == 0))
      {
         print("<td class='title1'>&nbsp;</td>\n");
      }
      if (($default->expand_search_disp_folder_path and $expand == 1) or ($default->collapse_search_disp_folder_path and $expand == 0))
      {
         print("<td class='title1'>$owl_lang->owl_log_hd_fld_path</td>\n");
      }
      if (($default->expand_search_disp_doc_type and $expand == 1) or ($default->collapse_search_disp_doc_type and $expand == 0))
      {
         print("<td class='title1'>&nbsp;</td>\n");
      }
      if (($default->expand_search_disp_file and $expand == 1) or ($default->collapse_search_disp_file and $expand == 0))
      {
         print("<td class='title1'>$owl_lang->file</td>\n");
      }
      if (($default->expand_search_disp_size and $expand == 1) or ($default->collapse_search_disp_size and $expand == 0))
      {
         print("<td class='title1'>$owl_lang->size</td>\n");
      }

      if (($default->expand_search_disp_posted and $expand == 1) or ($default->collapse_search_disp_posted and $expand == 0))
      {
         print("<td class='title1'>$owl_lang->postedby</td>\n");
      }
      if (($default->expand_search_disp_modified and $expand == 1) or ($default->collapse_search_disp_modified and $expand == 0))
      {
         print("<td class='title1'>$owl_lang->modified</td>\n");
      }
      if (($default->expand_search_disp_action and $expand == 1) or ($default->collapse_search_disp_action and $expand == 0))
      {
         print("<td class='title1'>$owl_lang->actions</td>\n");
      }
      print("</tr>\n");


    if (isset($aFolderMatchSearch) and $default->search_result_folders)
    {
       arsort($aFolderMatchSearch);
       foreach(array_keys($aFolderMatchSearch) as $fkey)
       {
          $CountLines++;
          $PrintLines = $CountLines % 2;
          print("<tr>\n");
          if ($PrintLines == 0)
          {
            $sTrClass = "file1";
            $sLfList = "lfile1";
          }
          else
          {
            $sTrClass = "file2";
            $sLfList = "lfile1";
          }

         if (($default->expand_search_disp_score and $expand == 1)  or ($default->collapse_search_disp_score and $expand == 0))
         {
                  //print "<td class='$sTrClass' id='$sLfList'>";
                  print "<td class='$sTrClass'>";

                  $t_score = $aFolderMatchSearch[$fkey][score]; 

                  for ($c=$max; $c>=1; $c--)
                  {
                     if ( $t_score >= 10)
                     {
                        if ( 0 == ($c % 10))
                        {
                           print "<img src='$default->owl_graphics_url/$default->sButtonStyle/ui_icons/star10.gif' border='0' alt=''></img>";
                           $t_score = $t_score - 10;
                        }
                     }
                     else
                     {
                        if ( (0 == ($t_score % 2)) and $t_score > 0 )
                        {
                           print "<img src='$default->owl_graphics_url/$default->sButtonStyle/ui_icons/star.gif' border='0' alt=''></img>";
                        }
                        $t_score = $t_score - 1;
                     }

                  }
                  print "</td>\n";
             }
         if (($default->expand_search_disp_folder_path and $expand == 1) or ($default->collapse_search_disp_folder_path and $expand == 0))
         {
                  //print "<td class='$sTrClass' id='$sLfList'>";
                  print "<td class='$sTrClass'>";
                  $sPopupDescription = fCleanDomTTContent($aFolderMatchSearch[$id][description]);

                  if ($sPopupDescription == "")
                  {
                     $sPopupDescription = $owl_lang->no_description;
                  }
                  print("<a class='$sLfList' href='browse.php?sess=$sess&amp;parent=". $aFolderMatchSearch[$fkey][id] . "&amp;expand=1'");
                  print(" onmouseover=" . '"' . "return makeTrue(domTT_activate(this, event, 'caption', '" . $owl_lang->description . "', 'content', '" . $sPopupDescription . "', 'lifetime', 3000, 'fade', 'both', 'delay', 10, 'statusText', ' ', 'trail', true));" . '"');

                  print(">\n");
                  $name = find_path($aFolderMatchSearch[$fkey][id]);
                  print("$hit. " . $name);
                  print("</a>\n");
                  print("</td>\n");
         }
 
   $GetItems = new Owl_DB;

   $iItemCount = 0;
   $iParent = $sql->f("parent");
   $GetItems->query("SELECT id from $default->owl_folders_table where parent = '" . $aFolderMatchSearch[$fkey][id] . "'");

   if ($default->restrict_view == 1)
   {
      while ($GetItems->next_record())
      {
         $bFileDownload = check_auth($GetItems->f("id"), "folder_view", $userid, false, false);
         if ($bFileDownload)
         {
            $iItemCount++;
         }
     }
   }
   else
   {
      $iItemCount = $GetItems->num_rows();
   }

   $GetItems->query("SELECT id from $default->owl_files_table where parent = '" . $aFolderMatchSearch[$fkey][id] . "'");
   if ($default->restrict_view == 1)
   {
      while ($GetItems->next_record())
      {
         $bFileDownload = check_auth($GetItems->f("id"), "file_download", $userid, false, false);
         if ($bFileDownload)
         {
            $iItemCount++;
         }
     }
   }
   else
   {
      $iItemCount = $iItemCount + $GetItems->num_rows();
   }
 
      if (($default->expand_search_disp_doc_type and $expand == 1) or ($default->collapse_search_disp_doc_type and $expand == 0))
      {
         //print "<td class='$sTrClass' id='$sLfList'>";
         print "<td class='$sTrClass'>";
         print("<img src='$default->owl_graphics_url/$default->sButtonStyle/icon_filetype/folder_closed.gif' border='0' alt=''></img>");
         print("</td>\n");
      }
      if (($default->expand_search_disp_file and $expand == 1) or ($default->collapse_search_disp_file and $expand == 0))
      {
         //print "<td class='$sTrClass' id='$sLfList'>";
         print "<td class='$sTrClass'>";
         print("<a class='$sLfList' href='browse.php?sess=$sess&amp;parent=". $aFolderMatchSearch[$fkey][id] . "&amp;expand=$expand'");
         print(" onmouseover=" . '"' . "return makeTrue(domTT_activate(this, event, 'caption', '" . $owl_lang->description . "', 'content', '" . $sPopupDescription . "', 'lifetime', 3000, 'fade', 'both', 'delay', 10, 'statusText', ' ', 'trail', true));" . '"');

         print(">\n");
         $name = find_path($aFolderMatchSearch[$fkey][id]);
         print($aFolderMatchSearch[$fkey][name]);
         print("</a>\n");
         if ($iItemCount > 0)
         {
            print("<font color='blue>'&nbsp;($iItemCount)</font>");
         }
         print("</td>\n");
      }
      if (($default->expand_search_disp_size and $expand == 1) or ($default->collapse_search_disp_size and $expand == 0))
      {
         //print "<td class='$sTrClass' id='$sLfList'>";
         print "<td class='$sTrClass'>";
         print("&nbsp;");
         print("</td>\n");
      }

      if (($default->expand_search_disp_posted and $expand == 1) or ($default->collapse_search_disp_posted and $expand == 0))
      {
         //print "<td class='$sTrClass' id='$sLfList'>";
         print "<td class='$sTrClass'>";
         print("&nbsp;");
         print("</td>\n");
      }
      if (($default->expand_search_disp_modified and $expand == 1) or ($default->collapse_search_disp_modified and $expand == 0))
      {
         //print "<td class='$sTrClass' id='$sLfList'>";
         print "<td class='$sTrClass'>";
         print("&nbsp;");
         print("</td>\n");
      }
      if (($default->expand_search_disp_action and $expand == 1) or ($default->collapse_search_disp_action and $expand == 0))
      {
          //   print "<td class='$sTrClass' id='$sLfList'>";
          print "<td class='$sTrClass'>";
          print("&nbsp;&nbsp;");
          print("<img src='$default->owl_graphics_url/$default->sButtonStyle/ui_misc/16x16.gif' border='0' alt=''></img>");
          fPrintButtonSpace(1, 4);
          if (check_auth($aFolderMatchSearch[$fkey][id], "folder_delete", $userid, false, false) == 1)
          {
             $urlArgs2 = $urlArgs;
             $urlArgs2['action'] = 'folder_delete';
             $urlArgs2['id'] = $aFolderMatchSearch[$fkey][id];
             $urlArgs2['parent'] = $parent;
             $url = fGetURL ('dbmodify.php', $urlArgs2);
             fPrintButtonSpace(1, 2);
             print("<a class='$sLfList' href='$url'\tonclick='return confirm(\"$owl_lang->reallydelete " . htmlspecialchars($sql->f("name"), ENT_QUOTES) . "?\");'><img src='$default->owl_graphics_url/$default->sButtonStyle/icon_action/trash.gif' alt='$owl_lang->alt_del_folder' title='$owl_lang->alt_del_folder'\tborder='0' ></img></a>");
             fPrintButtonSpace(1, 4);
          }
          if (check_auth($aFolderMatchSearch[$fkey][id], "folder_property", $userid, false, false) == 1)
          {           
             $urlArgs2 = $urlArgs;
             $urlArgs2['action'] = 'folder_modify';
             $urlArgs2['id'] = $aFolderMatchSearch[$fkey][id];
             $urlArgs2['parent'] = $parent;
             $url = fGetURL ('modify.php', $urlArgs2);

             print("<a class='$sLfList' href='$url'><img src='$default->owl_graphics_url/$default->sButtonStyle/icon_action/edit.gif' border='0' alt='$owl_lang->alt_mod_folder' title='$owl_lang->alt_mod_folder'></img></a>");
             fPrintButtonSpace(1, 4);
          }
          print("</td>\n");
       }
       print("</tr>\n");
       $hit++; 
    }
 }
 if(sizeof($files) > 0) 
 {
         while($max > 0) 
         {
            foreach(array_keys($files) as $key) 
            {
               if($files[$key][score] == $max) 
               {
                  $name = find_path($files[$key][p])."/".$files[$key][n];
                  $filename = $files[$key][f];
                  $description = $files[$key][x];
                  $choped = split("\.", $filename);
                  $pos = count($choped);
                  if ( $pos > 1 )
                  {
                     $ext = strtolower($choped[$pos-1]);
                   }
                  else
                  {
                     $ext = "NoExtension";
                  }
                  $CountLines++;
                  $PrintLines = $CountLines % 2;
                  print("<tr>\n");

         if ($PrintLines == 0)
         {
            $sTrClass = "file1";
            $sLfList = "lfile1";
         }
         else
         {
            $sTrClass = "file2";
            $sLfList = "lfile1";
         }
                                                                                                                                                                                                   
         if (($default->expand_search_disp_score and $expand == 1) or ($default->collapse_search_disp_score and $expand == 0))
         {
                  //print "<td class='$sTrClass' id='$sLfList'>";
                  print "<td class='$sTrClass'>";

                  $t_score = $max;
                  for ($c=$max; $c>=1; $c--) 
                  {
                     if ( $t_score >= 10) 
                     {
                        if ( 0 == ($c % 10)) 
                        {
                           print "<img src='$default->owl_graphics_url/$default->sButtonStyle/ui_icons/star10.gif' border='0' alt=''></img>";
                           $t_score = $t_score - 10;
                        }
                     } 
                     else 
                     {
                        if ( (0 == ($t_score % 2)) && $t_score > 0 ) 
                        {
                           print "<img src='$default->owl_graphics_url/$default->sButtonStyle/ui_icons/star.gif' border='0' alt=''></img>";
                        }
                        $t_score = $t_score - 1;
                     }   
   
                  }
   
                  print "</td>\n";
         }
         if (($default->expand_search_disp_folder_path and $expand == 1) or ($default->collapse_search_disp_folder_path and $expand == 0))
         {
                  //print "<td class=$sTrClass id='$sLfList'>";
                  print "<td class='$sTrClass'>";
                  if(!empty($description))
                  {
                     $sPopupDescription = fCleanDomTTContent($aFolderMatchSearch[$id][description]);
                  }
                  else
                  {
                     $sPopupDescription = $owl_lang->no_description;
                  }
                  if ($sPopupDescription == "") 
                  {
                     $sPopupDescription = $owl_lang->no_description;
                  }
                  print("<a class='$sLfList' href='browse.php?sess=$sess&amp;parent=". $files[$key][p] . "&amp;expand=1&amp;fileid=" . $files[$key][id] ."'");
                  print(" onmouseover=" . '"' . "return makeTrue(domTT_activate(this, event, 'caption', '" . $owl_lang->description . "', 'content', '" . $sPopupDescription . "', 'lifetime', 3000, 'fade', 'both', 'delay', 10, 'statusText', ' ', 'trail', true));" . '"');
                  print(">\n");
                  print("$hit. $name");
                  print("</a>\n");
                  print("</td>\n");

         }
         if (($default->expand_search_disp_doc_type and $expand == 1) or ($default->collapse_search_disp_doc_type and $expand == 0))
         {

                  //print "<td class='$sTrClass' id='$sLfList' width='16'>";
                  print "<td class='$sTrClass' width='16'>";
                  if ($files[$key][u] == "1")
                  {
                     print("<img src='$default->owl_graphics_url/$default->sButtonStyle/icon_filetype/url.gif' border='0' alt=''></img>");
                  }
                  else 
                  {
                     $sDispIcon = $ext;
                     if (($ext == "gz") and ($pos > 2))
                     {
                        $exttar = strtolower($choped[$pos-2]);
                        if (strtolower($choped[$pos-2]) == "tar")
                        {
                           $ext = "tar.gz";
                        }
                     }
                     if (!file_exists("$default->owl_fs_root/graphics/$default->sButtonStyle/icon_filetype/$sDispIcon.gif"))
                     {
                        $sDispIcon = "file";
                     }
                     print("<img src='$default->owl_graphics_url/$default->sButtonStyle/icon_filetype/$sDispIcon.gif' border='0' alt=''></img>");

                  }
                  print("</td>\n");
              }
              if (($default->expand_search_disp_file and $expand == 1) or ($default->collapse_search_disp_file and $expand == 0))
              {
                  //print "<td class='$sTrClass' id='$sLfList'>";
                  print "<td class='$sTrClass'>";
                  if ($files[$key][u] == "1") 
                  {
                     print "<a class='$sLfList' href='$filename' target='new'>".$filename."</a>";
                  } 
                  else 
                  {
                     print "<a class='$sLfList' href='download.php?sess=$sess&amp;id=".$files[$key][id]."&amp;parent=".$files[$key][p]."'>".$filename."</a>";
                  }
                  print("</td>\n");
              }
              if (($default->expand_search_disp_size and $expand == 1) or ($default->collapse_search_disp_size and $expand == 0))
              {
                  //print "<td class='$sTrClass' id='$sLfList'>";
                  print "<td class='$sTrClass'>";
                  if ($files[$key][u] == "1")
                  {
                     print("&nbsp;");
                  }
                  else
                  {
                     print("".gen_filesize($files[$key][s]));
                  }
                  print("</td>\n");
              }
      if (($default->expand_search_disp_posted and $expand == 1) or ($default->collapse_search_disp_posted and $expand == 0))
      {
                  //print "<td class='$sTrClass' id='$sLfList'>";
                  print "<td class='$sTrClass'>";
                     print("<a class='$sLfList' href='prefs.php?owluser=" . $files[$key][id] . "&amp;sess=$sess&amp;expand=$expand&amp;parent=$parent&amp;order=$order&amp;sortname=$sortname'>" . fid_to_creator($files[$key][id])  ."</a>");
                     print("</td>\n");
      }
      if (($default->expand_search_disp_modified and $expand == 1) or ($default->collapse_search_disp_modified and $expand == 0))
      {
                  //print "<td class='$sTrClass' id='$sLfList'>";
                  print "<td class='$sTrClass'>";
                     print("".date($owl_lang->localized_date_format, strtotime($files[$key][date])));
                     print("</td>\n");
      }
      
      if (($default->expand_search_disp_action and $expand == 1) or ($default->collapse_search_disp_action and $expand == 0))
      {
                  //print "<td class='$sTrClass' id='$sLfList'>";
                  print "<td class='$sTrClass'>";
                     printFileIcons($files[$key][id],$name,$files[$key][c],$files[$key][u],$default->owl_version_control,$ext,$files[$key][p],true);
                     print("</td>\n");
      }
                  print("</tr>\n");
                  $hit++;
               }
            }
            $max--;
         }
      }
   }
   else
   {
      print "<div class='searchresult'>$owl_lang->search_results_for \"".htmlspecialchars(implode(" ", $query))."\"<br></br><br></br></div>";
      print("<table class='margin2' cellspacing='0' cellpadding='0' border='0' width='100%'><tr><td align='left' valign='top'>\n");
      print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>");
      print("<tr>");

      $iColspan = 0;
      if (($default->expand_search_disp_score and $expand == 1) or ($default->collapse_search_disp_score and $expand == 0))
      {
         print("<td class='title1'>&nbsp;</td>\n");
         $iColspan++;
      }
      if (($default->expand_search_disp_folder_path and $expand == 1) or ($default->collapse_search_disp_folder_path and $expand == 0))
      {
         print("<td class=title1>$owl_lang->owl_log_hd_fld_path</td>\n");
         $iColspan++;
      }
      if (($default->expand_search_disp_doc_type and $expand == 1) or ($default->collapse_search_disp_doc_type and $expand == 0))
      {
         print("<td class='title1'>&nbsp;</td>\n");
         $iColspan++;
      }
      if (($default->expand_search_disp_file and $expand == 1) or ($default->collapse_search_disp_file and $expand == 0))
      {
         print("<td class='title1'>$owl_lang->file</td>\n");
         $iColspan++;
      }
      if (($default->expand_search_disp_size and $expand == 1) or ($default->collapse_search_disp_size and $expand == 0))
      {
         print("<td class='title1'>$owl_lang->size</td>\n");
         $iColspan++;
      }
                                                                                                                                                                                                   
      if (($default->expand_search_disp_posted and $expand == 1) or ($default->collapse_search_disp_posted and $expand == 0))
      {
         print("<td class='title1'>$owl_lang->postedby</td>\n");
         $iColspan++;
      }
      if (($default->expand_search_disp_modified and $expand == 1) or ($default->collapse_search_disp_modified and $expand == 0))
      {
         print("<td class='title1'>$owl_lang->modified</td>\n");
         $iColspan++;
      }
      if (($default->expand_search_disp_action and $expand == 1) or ($default->collapse_search_disp_action and $expand == 0))
      {
         print("<td class='title1'>$owl_lang->actions</td>\n");
         $iColspan++;
      }
      print("</tr>\n");


      print("<tr><td class=\"admin3\" colspan='$iColspan' align='center'>");
      print("$owl_lang->owl_log_no_rec</td></tr>\n");
      print("<tr><td colspan='$iColspan' align='center'>");
      print("&nbsp;</td></tr>\n");
   }
} 
else 
{ 
   print("<p>" . $owl_lang->query_empty . "</p>");
}

$keywords = str_replace("%", "*", $keywords);
print("</table>");
print("</td>\n</tr>\n</table>\n");

if ($default->show_search == 2 or $default->show_search == 3)
{
   fPrintSpacer();
   fPrintSearch(1);
}

if ($default->show_prefs == 2 or $default->show_prefs == 3)
{
   fPrintPrefs("infobar2");
}

print("</td>\n</tr>\n</table>\n");
include("./lib/footer.inc");
?> 
