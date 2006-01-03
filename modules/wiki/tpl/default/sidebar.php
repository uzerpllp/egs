<?php

// recursive function to establish best sidebar file to be used
function getSidebarFN($ns, $file) {
 
  // check for wiki page = $ns:$file (or $file where no namespace)
  $nsFile = ($ns) ? "$ns:$file" : $file;
  if (file_exists(wikiFN($nsFile))) return wikiFN($nsFile);
  
  // remove deepest namespace level and call function recursively
  
  // no namespace left, exit with no file found	
  if (!$ns) return '';
  
  $i = strrpos($ns, ":");
  $ns = ($i) ? substr($ns, 0, $i) : false;	
  return getSidebarFN($ns, $file);
}
 
function html_sidebar() {
  global $ID;
  global $ACT;

  if ($ACT != 'show') return '';
  
  // determine master sidebar file
  $masterFile = getSidebarFN(getNS($ID), 'sidebar');
  
  // hidden local sidebar filename
  $fn = wikiFN($ID.'_sidebar');
  $localFile = dirname($fn).'/_'.basename($fn);
  
  // update local file if required
  if ($masterFile) {
    if (   !@file_exists($localFile)
	|| (filemtime($masterFile) > filemtime($localFile))
       ) {
      copy($masterFile, $localFile);
    }
  }
 
  // open sidebar <div>
  echo("<div id='sidebar'>");
  
  // determine what to display
  if ($localFile) {
    print p_cached_xhtml($localFile);
  }
  else {
    html_index('.');
  }
  
  // close sidebar <div>
  echo("</div>");
}

?>