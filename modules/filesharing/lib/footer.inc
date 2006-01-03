<?php
/*

  File: footer.inc
  Author: Chris
  Date: 2000/12/14

  Owl: Copyright Chris Vincent <cvincent@project802.net>

  You should have received a copy of the GNU Public
  License along with this package; if not, write to the
  Free Software Foundation, Inc., 59 Temple Place - Suite 330,
  Boston, MA 02111-1307, USA.

*/

if(!isset($sortname)) 
{
   $sortname = "ASC";
}

if(!isset($bDisplayFooterTools))
{
   $bDisplayFooterTools = false;
}

print("<a name='bottom'></a>");

if ($_SERVER["PHP_SELF"] != $default->owl_root_url . "/index.php")
{
   print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>\n");
   print("<tr><td class='owlbar1' align='right'><a class='lbutton1' href='http://validator.w3.org/check?uri=referer'>$owl_lang->engine $default->version</a></td></tr>");
   print("</table>");
}
else
{
   print("<table cellspacing='0' cellpadding='0' border='0' width='100%'>");
   print("<tr><td class='owlbar1' align='right'>&nbsp;</td></tr>");
   print("</table>");
}


if (file_exists("./lib/userfooter.inc")) 
{
   include_once("./lib/userfooter.inc");
} 
else 
{
   if (file_exists("../lib/userfooter.inc")) 
   {
      include_once("../lib/userfooter.inc");
   }
   else
   {
      include_once("$default->owl_fs_root/lib/userfooter.inc");
   }
}

print("</td></tr></table></center>");
?>
</body>
</html>
