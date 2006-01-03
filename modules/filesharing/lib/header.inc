<?php

/*

  File: header.inc
  Author: Chris
  Date: 2000/12/14

  Owl: Copyright Chris Vincent <cvincent@project802.net>

  You should have received a copy of the GNU Public
  License along with this package; if not, write to the
  Free Software Foundation, Inc., 59 Temple Place - Suite 330,
  Boston, MA 02111-1307, USA.

 // <script language="JavaScript" src="<?php print $default->owl_root_url?>/scripts/tree/tree.js"></script>
  //<script language="JavaScript" src="<?php print $default->owl_root_url?>/scripts/tree/tree_items.js"></script>
  //<script language="JavaScript" src="<?php print $default->owl_root_url?>/scripts/tree/tree_tpl.js"></script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>


<!DOCTYPE html 
     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<!DOCTYPE html 
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<!DOCTYPE html 
     PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
*/

?>
<!DOCTYPE html 
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
<head>
  <title><?php print $default->site_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo($default->charset) ?>"></meta>
<link rel="SHORTCUT ICON" href="<?php print $default->owl_graphics_url?>/favicon.ico"></link>
<link rel="Bookmark" href="<?php print $default->owl_graphics_url?>/favicon.ico"></link>
<link rel="stylesheet" href="<?php print $default->owl_root_url?>/scripts/phplayersmenu/layersmenu-gtk2.css" type="text/css"></link>
<link rel="stylesheet" type="text/css" title="style1" href="<?php echo($default->styles)?>"></link>

  <script type="text/javascript" src="<?php print $default->owl_root_url?>/scripts/DomTT/domLib.js"></script>
  <script type="text/javascript" src="<?php print $default->owl_root_url?>/scripts/DomTT/domTT.js"></script>

  <script type="text/javascript">
var domTT_classPrefix = 'domTTOverlib';
  </script>

<script type="text/javascript">
function highlightButton(s) {if ("INPUT"==event.srcElement.tagName) event.srcElement.className=s}
</script>

<script type="text/javascript">
<!--
function checkform(form) 
{
   var test = 0
   for (var i = 0; i < document.FileList.elements.length; i++) 
   {
       if(document.FileList.elements[i].type == "checkbox")
       {
         if(document.FileList.elements[i].checked)
         {
           test++
         }
       }
   }

   if (test < 1)
   {
      alert("ERROR");
      return false;
   }
   else
   {
      return true;
   }
}
-->
</script>


<script type="text/javascript">
<!--
function CheckAll() {
  for (var i = 0; i < document.FileList.elements.length; i++) {
    if(document.FileList.elements[i].type == "checkbox"){
      document.FileList.elements[i].checked =         !(document.FileList.elements[i].checked);
    }
  }
}
-->
</script>

<script type="text/javascript">
<!--
<?php require_once "$default->owl_fs_root/scripts/phplayersmenu/libjs/layersmenu-browser_detection.js"; ?>
// -->
</script>
                                                                                                                                                                                                   
<script type="text/javascript" src="<?php print $default->owl_root_url?>/scripts/phplayersmenu/libjs/layersmenu-library.js"></script>
<script type="text/javascript" src="<?php print $default->owl_root_url?>/scripts/phplayersmenu/libjs/layersmenu.js"></script>


</head>

<body
<?php 
if(isset($default->body_background))
{
   print("background=\"$default->body_background\"");
}
?>
>
<a name="top"></a>
