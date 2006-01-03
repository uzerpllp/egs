<?php

/**
 * readnews.php
 *
 * Author: Steve Bourgeois <owl@bozzit.com>
 * Project Founder: Chris Vincent <cvincent@project802.net>
 * 
 * Copyright (c) 1999-2005 The Owl Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 * 
 * $Id: readnews.php,v 1.5 2005/03/09 15:43:52 b0zz Exp $
 */

require_once("./config/owl.php");
require_once("./lib/disp.lib.php");
require_once("./lib/owl.lib.php");
require_once("./lib/security.lib.php");

include_once("./lib/header.inc");
include_once("./lib/userheader.inc");

$iGroupId = owlusergroup($userid);

if ($default->anon_user == $userid)
{
   die("$owl_lang->err_unauthorized");
} 

$sql = new Owl_DB;

if (isset($start)) $iStartId = $start;
// 
// Create the where Clause for user Groups
// 
$sqlmemgroup = new Owl_DB;
$sqlmemgroup->query("select * from $default->owl_users_grpmem_table where userid = '" . $userid . "'");
$sGroupsWhereClause = "( gid = '-1' OR gid = '$iGroupId'";

while ($sqlmemgroup->next_record())
{
   $sGroupsWhereClause .= " OR gid = '" . $sqlmemgroup->f("groupid") . "'";
} 
$sGroupsWhereClause .= ")";
// print("W: $sGroupsWhereClause");
// exit;
// 
// Get the id of the last Viewed Article
// 
$sql->query("SELECT lastnews from $default->owl_users_table where id = '$userid'");
$sql->next_record();

if ($action == "")
{
   $Update = new Owl_DB;
   $iStartId = $sql->f("lastnews");
   if ($iStardId == "")
   {
      $iStartId = 0;
   }
   $bHidePrevious = true;
} 
// 
// Get the Next News Article for this user
// 
if ($action == "prev")
{
   $bHidePrevious = false;
   $iCurrentNewsId = $current - 1; 
   // 
   // If we go down one more is it the
   // first then we need to hide the
   // Prev button.
   // 
   $dNowDate = $sql->now();
   $sql->query("SELECT * from $default->owl_news_table where $sGroupsWhereClause and id <= '$iCurrentNewsId' and news_end_date >= $dNowDate order by id desc LIMIT 1");
   $sql->next_record();

   $iPreviousOne = $sql->f("id");
   if ($iPreviousOne <= $iStartId)
   {
      $bHidePrevious = true;
   } 
   if ($iCurrentNewsId <= $iStartId)
   {
      $iCurrentNewsId = $iStartId;
      $dNowDate = $sql->now();
      $sql->query("SELECT * from $default->owl_news_table where $sGroupsWhereClause and id >= '$iStartId'  and news_end_date >= $dNowDate LIMIT 1");
   } 
   else
   {
      $dNowDate = $sql->now();
      $sql->query("SELECT * from $default->owl_news_table where $sGroupsWhereClause and id <= '$iCurrentNewsId' and news_end_date >= $dNowDate order by id desc LIMIT 1");
   } 
   $sql->next_record();

   $iCurrentNewsId = $sql->f("id");
} 
else
{
   if ($action == "")
   {
      $dNowDate = $sql->now();
      $sql->query("SELECT * from $default->owl_news_table where $sGroupsWhereClause and id > '$iStartId' and news_end_date >= $dNowDate LIMIT 1");
      $sql->next_record();
      $iStartId = $sql->f("id");
   } 
   else
   {
      $bHidePrevious = false;
      $iCurrentNewsId = $current;
      $dNowDate = $sql->now();
      $sql->query("SELECT * from $default->owl_news_table where $sGroupsWhereClause and id > '$iCurrentNewsId' and news_end_date >= $dNowDate LIMIT 1");
      $sql->query($sMyQuery2);
      $sql->next_record();
   } 

   if ($sql->num_rows() == 0)
   {
      print('<script language="javascript">');
      print('window.close();');
      print('</script>');
   } 
   else
   {
      $iCurrentNewsId = $sql->f("id");
      $UpdateUser = new Owl_DB;
      $bLastNews = false;
      $dNowDate = $UpdateUser->now();
      $UpdateUser->query("SELECT * from $default->owl_news_table where $sGroupsWhereClause and id > '$iCurrentNewsId' and news_end_date >= $dNowDate LIMIT 1");
      $UpdateUser->next_record();

      if ($UpdateUser->num_rows() == 0)
      {
         $bLastNews = true;
      } 

      $UpdateUser->query("UPDATE $default->owl_users_table set lastnews = '" . $iCurrentNewsId . "' where id = '$userid'");
   } 
} 
print("<table align='center' WIDTH='90%' CELLSPACING='2' CELLPADDING='2' border='0' HEIGHT='100%'>");
print("<td align=left WIDTH='90%'>\n");
print("<h4>" . $sql->f("news_title") . "</h4>\n");
print("</td>\n");

?>
<td><a href="#" onClick="window.print(); return false");><img src="<?php print("$default->owl_graphics_url/$default->sButtonStyle/icon_action/print.gif");
?>" border='0' alt='<?php print $owl_lang->alt_news_print ?>' title='<?php print $owl_lang->alt_news_print ?>'></img></a></td>
<?php
if (!$bHidePrevious)
{

   ?>
   <td align='center' ><a href="readnews.php?sess=<?php print $sess;
   ?>&action=prev&start=<?php print $iStartId;
   ?>&current=<?php print $iCurrentNewsId;
   ?>" ><img src="<?php print("$default->owl_graphics_url/$default->sButtonStyle/ui_nav/prev.gif");
   ?>" border='0' alt='<?php print $owl_lang->alt_news_prev ?>' title='<?php print $owl_lang->alt_news_prev ?>'></img></a></td>
<?php
} 
else
{
   print("<td></td>");
} 

?>
<?php
if ($bLastNews)
{
   if ($default->allow_popup)
   {

      ?>
                <td align='center' ><a href="readnews.php?sess=<?php print $sess;
      ?>&action=next&start=<?php print $iStartId;
      ?>&start=<?php print $iStartId;
      ?>&current=<?php print $iCurrentNewsId;
      ?>" ><img src="<?php print("$default->owl_graphics_url/$default->sButtonStyle/ui_nav/close.gif");
      ?>" border='0' alt='<?php print $owl_lang->alt_news_close ?>' title='<?php print $owl_lang->alt_news_close ?>'></img></a></td>
<?php
   } 
   else
   {
      print("<td align='center'><a href='browse.php?sess=$sess'><img src='$default->owl_graphics_url/$default->sButtonStyle/ui_nav/close.gif' alt='$owl_lang->alt_return' title='$owl_lang->alt_return' border='0'></img></a> </td>");
   } 
} 
else
{

   ?>
   <td align='center' ><a href="readnews.php?sess=
<?php print $sess; ?>
&action=next&start=
<?php print $iStartId; ?>
&start=
<?php print $iStartId; ?>
&current=
<?php print $iCurrentNewsId; ?>
"><img src="
<?php print("$default->owl_graphics_url/$default->sButtonStyle/ui_nav/next.gif"); ?>
" border='0' alt='
<?php print $owl_lang->alt_news_next ?>
' title='
<?php print $owl_lang->alt_news_next ?>'>
</img></a></td>
<?php
} 
?>
<td></td>
</tr>
<tr>
<td valign='top' height='90%' colspan='5' align='left'> <?php print(nl2br($sql->f("news")));
?></td>
</tr>
<?php
print("<tr><td colspan='5' align='left'><br />$owl_lang->news_posted_date  " . date($owl_lang->localized_date_format, strtotime($sql->f("news_date"))) . "</td><br /><br /></tr>");
print("<tr>\n");
if ($default->allow_popup)
{

   ?>
   <td align='center' >&nbsp;</td>
<?php
} 
else
{
   print("<td align='center'><a href='browse.php?sess=$sess'><img src='$default->owl_graphics_url/$default->sButtonStyle/ui_nav/close.gif' alt='$owl_lang->alt_return' title='$owl_lang->alt_return' border='0'></img></a> </td>");
} 

?>
<td><a href="#" onClick="window.print(); return false");><img src="<?php print("$default->owl_graphics_url/$default->sButtonStyle/icon_action/print.gif");
?>" border='0' alt='<?php print $owl_lang->alt_news_print ?>' title='<?php print $owl_lang->alt_news_print ?>'></img></a></td>
<?php
if (!$bHidePrevious)
{

   ?>
   <td align='center' ><a href="readnews.php?sess=<?php print $sess;
   ?>&action=prev&start=<?php print $iStartId;
   ?>&current=<?php print $iCurrentNewsId;
   ?>" ><img src="<?php print("$default->owl_graphics_url/$default->sButtonStyle/ui_nav/prev.gif");
   ?>" border='0' alt='<?php print $owl_lang->alt_news_prev ?>' title='<?php print $owl_lang->alt_news_prev ?>'></img></a></td>
<?php
} 
else
{
   print("<td></td>");
} 

?>
<?php
if ($bLastNews)
{
   if ($default->allow_popup)
   {

      ?>
      <td align='center' ><a href="readnews.php?sess=<?php print $sess;
      ?>&action=next&start=<?php print $iStartId;
      ?>&start=<?php print $iStartId;
      ?>&current=<?php print $iCurrentNewsId;
      ?>" ><img src="<?php print("$default->owl_graphics_url/$default->sButtonStyle/ui_nav/close.gif");
      ?>" border='0' alt='<?php print $owl_lang->alt_news_close ?>' title='<?php print $owl_lang->alt_news_close ?>'></img></a></td>
<?php
   } 
   else
   {
      print("<td align='center'><a href='browse.php?sess=$sess'><img src='$default->owl_graphics_url/$default->sButtonStyle/ui_nav/close.gif' alt='$owl_lang->alt_return' title='$owl_lang->alt_return' border='0'></img></a> </td>");
   } 
} 
else
{

   ?>
   <td align='center' ><a href="readnews.php?sess=<?php print $sess;
   ?>&action=next&start=<?php print $iStartId;
   ?>&start=<?php print $iStartId;
   ?>&current=<?php print $iCurrentNewsId;
   ?>" ><img src="<?php print("$default->owl_graphics_url/$default->sButtonStyle/ui_nav/next.gif");
   ?>" border='0' alt='<?php print $owl_lang->alt_news_next ?>' title='<?php print $owl_lang->alt_news_next ?>'></img></a></td>
<?php
} 
print("</tr>");

?>
</table>
</body>
</html>
