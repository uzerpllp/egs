<?php
/**
 * readhd.php
 *
 * Author: Anders Axesson
 * Adapted to OWL global config file by B0zz
 * Project Founder: Chris Vincent <cvincent@project802.net>
 *
 * Copyright (c) 1999-2005 The Owl Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 *
 */



function GetFromHD($GetWhat, $ThePath) 
{
   global $default;

   if(!file_exists($ThePath)) 
   {
      return "NOTEXIST";
   }
   if ($Dir = opendir($ThePath)) 
   {
      $FileCount = 0;
      $DirCount = 0;
      while(false !== ($file = readdir($Dir))) 
      {
         if ($file[0] == '.')
         {
            continue;
         }
   
         $PathFile = $ThePath . "/" . $file; //must test with full path (is_file etc)
      
         if(($file <> ".") and ($file <> "..")) 
         {
            if (!is_file($PathFile)) 
            {  //check if it is a folder (dir) or file (dont check if it is a link)

               $bOmitFile = false;
               if(isset($default->lookHD_ommit_directory)) 
               {
                  foreach ($default->lookHD_ommit_directory as $omit) 
                  {
                     if ($file == $omit) 
                     {
                        $bOmitFile = true;
                     }
                  }
               }

               if(!$bOmitFile) 
               {
                  $DirCount++;
                  $Dirs[$DirCount] = $file;
               }
            }
            else
            {
               $bOmitFile = false;
               if(isset($default->lookHD_ommit_ext)) 
               {
                  $filesearch = explode('.',$file);
                  $extensioncounter=0;
                  while ($filesearch[$extensioncounter+1] != NULL) 
                  {
                     $extensioncounter++;
                  }
                  if($extensioncounter == 0) 
                  {
                     $file_extension = '';
                  } 
                  else 
                  {
                     $file_extension = $filesearch[$extensioncounter];
                  }
      
                  foreach ($default->lookHD_ommit_ext as $omit) 
                  {
                     if ($file_extension == $omit) 
                     {
                        $bOmitFile = true;
                     }
                  }
               }
               if(!$bOmitFile) 
               {
                  $FileCount++;
                  $Files[$FileCount] = $file;
               }
            }
         }
      }

      if ($GetWhat == 'file') 
      {
         $FileCount++;
         $Files[$FileCount] = "[END]";  //stop looping @ this
         return $Files;
      }

      if ($GetWhat == 'folder') 
      {
         $DirCount++;
         $Dirs[$DirCount] = "[END]";  //stop looping @ this
         return $Dirs;
      }
   }
}

function GetFileInfo($PathFile) {
  $TheFileSize = filesize($PathFile);  //get filesize
  $TheFileTime = date("Y-m-d H:i:s", filemtime($PathFile));  //get and fix time of last modifikation
  //$TheFileTime2 = date("M d, Y \a\\t h:i a", filemtime($PathFile));  //get and fix time of last modifikation


  $FileInfo[1] = $TheFileSize;
  $FileInfo[2] = $TheFileTime; //s$modified
  //$FileInfo[3] = $TheFileTime2; //modified

  return $FileInfo;
}

function CompareDBnHD($GetWhat, $ThePath, $DBList, $parent, $DBTable) {  //compare files or folders in database with files on harddrive
  global $default, $fCount, $folderList;

     $RefreshPage = false;  //if filez/Folderz are found the page need to be refreshed in order to see them.
     $somethingwasdeleted = false;

     if ($default->owl_lookAtHD_del == 1) {

	 $sql = new Owl_DB;
         $sql->query("SELECT id,name,parent from $default->owl_folders_table order by name");
         $fCount = ($sql->nf());
         $i = 0;
         while($sql->next_record()) {
         	$folderList[$i][0] = $sql->f("id");
		$folderList[$i][2] = $sql->f("parent");
		$i++;
	}

	if($GetWhat == "folder") {
     		$somethingwasdeleted = DeleteDBFolderzNotInDB($default->owl_files_table, $parent);
        } else {
		$somethingwasdeleted = DeleteDBFolderzNotInDB($default->owl_folders_table, $parent);
	}
     }
     $F = GetFromHD($GetWhat, $ThePath);

    if ( $F == "NOTEXIST") return true;

   if(is_array($F)) 
   {
      for($HDLoopCount = 1; $F[$HDLoopCount] !== "[END]";$HDLoopCount++) 
      {
         for($DBLoopCount = 1; $DBList[$DBLoopCount] !== "[END]";$DBLoopCount++) 
         {
            if($F[$HDLoopCount] == $DBList[$DBLoopCount]) 
            {
	       unset($F[$HDLoopCount]); //removing file/folder that is in db from list of filez on disc (leaving list of filez on disc but not in db)
	       break;
            }
         }
       } 

      if(count($F) > 1)
      {
         for($HDLoopCount = 1; $F[$HDLoopCount] !== "[END]";$HDLoopCount++) 
         {
            if(ord($F[$HDLoopCount]) !== 0)  //if not the file/folder name is empty...
            {
               if($GetWhat == "file") 
               {
	          $RefreshPage = true;
                  InsertHDFilezInDB($F[$HDLoopCount], $parent, $ThePath, $DBTable); //call function that inserts the filez-on-disc-but-not-in-db into the db.
               } 
               else
               {
	          $RefreshPage = false;
               }
   
               if($GetWhat == "folder") 
               {
	          $RefreshPage = true;
                  InsertHDFolderzInDB($F[$HDLoopCount], $parent, $ThePath, $DBTable); //call function that inserts the folderz-on-disc-but-not-in-db into the db.
               }
            }
         }
      }
   }

   if($somethingwasdeleted)
   {
      $RefreshPage = $somethingwasdeleted;
   }

  return $RefreshPage;

}

function DeleteDBFolderzNotInDB($table, $parent) {
	global $default;
	$somethingwasdeleted = false;

	$get = new Owl_DB;  //create new db connection
	$del = new Owl_DB;  //create new db connection
	$children = new Owl_DB;  //create new db connection
	$query = "select * from $table ";
	if ($table == $default->owl_files_table) {
		$query .= " where linkedto = '0' and url <> '1' and parent = '$parent' ";
		//$query .= " where url <> 1 ";
		$query .= " order by parent desc ";
	} else {
		$query .= " where parent = '$parent' ";
		$query .= " order by parent desc ";
	}
 	 
	$get->query("$query");
	while($get->next_record()) {
		$newparent = $get->f("parent");
		if ($table == $default->owl_files_table) {
			$dbfolder = $default->owl_FileDir . "/" . get_dirpath($get->f("parent")) . "/" . $get->f("filename");
		} else {
			$dbfolder = $default->owl_FileDir . "/" . get_dirpath($get->f("id"));
		}
	
		if(!file_exists($dbfolder)) {
			$delid = $get->f("id");
			if ($table == $default->owl_files_table) 
                        {
				$del->query("DELETE from $table where id = '$delid'");
		 		// Clean up all monitored files with that id
                     		$del->query("DELETE from $default->owl_monitored_file_table where fid = '$delid'");
                        	// Clean up all comments with this file 
                        	$del->query("DELETE from $default->owl_comment_table where fid = '$delid'");
                                // Clean up all comments with this file
                                $del->query("DELETE from $default->owl_docfieldvalues_table where file_id = '$delid'");
                                // Clean up all linked files
                                $del->query("DELETE from $default->owl_files_table where linkedto = '$delid'");

				fDeleteFileIndexID($delid);
			} 
                        else 
                        {
				delTree($delid);
			}

			$somethingwasdeleted = true;
		}
	}

	return $somethingwasdeleted;
}

function InsertHDFolderzInDB($TheFolder, $parent, $ThePath, $DBTable) 
{
   global $default;

   $sql = new Owl_DB;  //create new db connection
   $check = new Owl_DB;  //create new db connection
   $smodified = $sql->now();

   $original_name = $TheFolder;
   $TheFolder = trim(ereg_replace("[^$default->list_of_valid_chars_in_file_names]", "",  ereg_replace("%20|^-", "_", $TheFolder)));

   $check->query("select * from $DBTable where name='$TheFolder' and parent='$parent'");
 

   while($check->next_record()) 
   {
      if ($check->f("name") == $TheFolder ) 
      {
         $TheFolder .= "-" .date("Ymd-gis");
      }
   }

   rename($ThePath . "/" . $original_name, $ThePath . "/" . $TheFolder);

   $SQL = "INSERT INTO $DBTable (name,parent,security,groupid,creatorid,description,smodified) values ('$TheFolder', '$parent', '$default->owl_def_fold_security', '$default->owl_def_fold_group_owner', '$default->owl_def_fold_owner', '', $smodified)";
   $sql->query($SQL);
}


function InsertHDFilezInDB($TheFile, $parent, $ThePath, $DBTable) 
{
   global $default;

   $sql = new Owl_DB;  //create new db connection
   $check = new Owl_DB;  //create new db connection

   $original_name = $TheFile;
   $TheFile = trim(ereg_replace("[^$default->list_of_valid_chars_in_file_names]", "",  ereg_replace("%20|^-", "_", $TheFile)));
 
   if ($DBTable == "trash")
   {
      $DBTable = $default->owl_files_table;
   }
   else
   {
      $check->query("select * from $DBTable where filename='$TheFile' and parent='$parent'");
      if ($check->num_rows($check) != 0) 
      {
         $TheFile .= "-" . date("Ymd-gis");
         rename($ThePath . "/" . $original_name, $ThePath . "/" . $TheFile);
      }
   }

   $FileInfo = GetFileInfo($ThePath . "/" . $TheFile);  //get file size etc. 2=File size, 2=File time (smodified), 3=File time 2 (modified)

   if (empty($FileInfo[1]))
   {
     $iFileSize = "0";
   }
   else
   {
      $iFileSize = $FileInfo[1]; 
   }
   
   if ($default->owl_def_file_title == "")
   {
      $filesearch = explode('.',$TheFile);
      $extensioncounter=0;
      while ($filesearch[$extensioncounter+1] != NULL)
      {
         // pre-append a "." separator in the name for each
         // subsequent part of the the name of the file.
         if ( $extensioncounter != 0)
         {
            $firstpart = $firstpart.".";
         }
         $firstpart = $firstpart.$filesearch[$extensioncounter];
         $extensioncounter++;
      }

      if($extensioncounter == 0)
      {
         $firstpart = $TheFile;
         $file_extension = '';
      }
      else 
      {
         $file_extension = $filesearch[$extensioncounter];
      }
      $title_name =  $firstpart;
      $title_name = trim(ereg_replace("[^$default->list_of_valid_chars_in_file_names]", "",  ereg_replace("%20|^-", "_", $title_name)));
   }
   else
   {
      $title_name = $default->owl_def_file_title;
   }

   $SQL = "INSERT into $DBTable (name,filename,f_size,creatorid,parent,created,description,metadata,security,groupid,smodified,approved,linkedto) values ('$title_name', '$TheFile', '$iFileSize', '$default->owl_def_file_owner', '$parent', '$FileInfo[2]', '$TheFile', '$default->owl_def_file_meta', '$default->owl_def_file_security', '$default->owl_def_file_group_owner','$FileInfo[2]', '1', '0')";
   $sql->query($SQL);

   // index New Files pdf and TXT Files for SEARCH

   $searchid = $sql->insert_id($default->owl_files_table, 'id');
   fIndexAFile($TheFile, $ThePath . "/" . $TheFile, $searchid);
}

?>
