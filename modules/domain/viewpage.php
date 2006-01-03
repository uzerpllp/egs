<?php   
// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - View Webpage 1.0                 |
// +----------------------------------------------------------------------+
// | Copyright (c) 2002-2005 Jake Stride                                  |
// +----------------------------------------------------------------------+
// | This file is part of EGS.                                            |
// |                                                                      |
// | EGS is free software; you can redistribute it and/or modify it under |
// | the terms of the GNU General Public License as published by the Free |
// | Software Foundation; either version 2 of the License, or (at your    |
// | option) any later version.                                           |
// |                                                                      |
// | EGS is distributed in the hope that it will be useful, but WITHOUT   |
// | ANY WARRANTY; without even the implied warranty of MERCHANTABILITY   |
// | or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public     |
// | License for more details.                                            |
// |                                                                      |
// | You should have received a copy of the GNU General Public License    |
// | along with EGS; if not, write to the Free Software Foundation, Inc., |
// | 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA               |
// +----------------------------------------------------------------------+
// | Author: Jake Stride <jake.stride@senokian.com>                       |
// +----------------------------------------------------------------------+
// | 1.0                                                                  |
// | ===                                                                  |
// | First Stable Release                                                 |
// +----------------------------------------------------------------------+

/* Check user has access to this module */
if (isset ($_SESSION['modules']) && (in_array('domain', $_SESSION['modules']))) {
	/* Include the domain class, at the very least we will need it to confirm 
	 * access level.
	 */
	require_once (EGS_FILE_ROOT.'/src/classes/class.domain.php');

	$domain = new domain();

	/* Grab the current access level for the domain */
	$accessLevel = $domain->accessLevel(intval($_GET['domainid']));

	if ($accessLevel >= 0) {
		/* This variable will be set to true when a save is successfully completed
		 * and can be used later on to check which sort of form to show
		 */
		$saved = false;

		/* If the form was submitted check the values and do what we need to do */
		if ((sizeof($_POST) > 0) && ($accessLevel > 0)) {
			/* Check the posted values */
			$egs->checkPost();

			/* Set the id if it is set */
			if (isset ($_GET['id']))
				$id = $_GET['id'];
			else
				$id = null;

			/* Perform a delete if required and set the saved status */
			if (isset ($_POST['delete']))
				$saved = $domain->deleteFile($_GET['domainid'], $_GET['id']);
			else if (isset ($_POST['values']))
				$saved = $domain->saveParents($_GET['domainid'], $_GET['pageid'], $_POST['values']);
			/* We are saving a file for attachement */
			else
				$saved = $domain->saveFile($_POST, $id, $_GET['domainid'], $_GET['pageid']);
		}

		/* Build the query to get the page details */
		$query = 'SELECT w.*, p.name AS parentpage, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'w.updated').' AS updated, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'w.added').' AS added FROM webpage w LEFT OUTER JOIN webpage p ON (w.parentpageid=p.id) WHERE w.domainid='.$db->qstr(intval($_GET['domainid'])).' AND w.id='.$db->qstr(intval($_GET['pageid']));

		/* Send the query and get results */
		$pageDetails = $db->GetRow($query);

		/* As long as the result set is not false we are allowed to view this page */
		if ($pageDetails !== false) {
			/* Add to last viewed */
			$_SESSION['preferences']['lastViewed'] = array_slice(array_merge(array ('module=domain&amp;action=viewpage&amp;domainid='.intval($_GET['domainid']).'&amp;pageid='.intval($_GET['pageid']) => array ('webpage', $pageDetails['name'])), $_SESSION['preferences']['lastViewed']), 0, EGS_RECENTLY_VIEWED);

			/* Sync view to preferences */
			$egs->syncPreferences();

			/* Set the page title and edit/delete links */
			$smarty->assign('pageTitle', $pageDetails['title']);
			$smarty->assign('pageEdit', 'action=savepage&amp;domainid='.intval($_GET['domainid']).'&amp;pageid='.intval($_GET['pageid']));
			$smarty->assign('pageDelete', 'action=deletepage&amp;domainid='.intval($_GET['domainid']).'&amp;pageid='.intval($_GET['pageid']));

			/* Now build the page data for the left column */
			$leftData = array ();

			$leftData[] = array ('tag' => _('Page Name'), 'data' => $pageDetails['name']);
			$leftData[] = array ('span' => true);

			/* The dates will already have been converted in the query above to the correct format */
			$leftData[] = array ('tag' => _('Added'), 'data' => $pageDetails['added'].' '._('by').' '.$pageDetails['owner']);
			$leftData[] = array ('tag' => _('Last Updated'), 'data' => $pageDetails['updated'].' '._('by').' '.$pageDetails['alteredby']);

			/* Now build the right column */
			$rightData = array ();

			/* Translate the page type */
			switch ($pageDetails['type']) {
				case 'S' :
					$pageDetails['type'] = _('Static');
					break;
				case 'P' :
					$pageDetails['type'] = _('Portfolio');
					break;
				case 'N' :
					$pageDetails['type'] = _('News');
					break;
			}

			$rightData[] = array ('tag' => _('Parent Page'), 'data' => $pageDetails['parentpage']);
			$rightData[] = array ('tag' => _('Page Type'), 'data' => $pageDetails['type']);

			/* Build the data for the boxes on the right */
			$rightSpan = array ();

			/* Show the keywords */
			$rightSpan[] = array ('type' => 'text', 'title' => _('Meta Keywords'), 'text' => $pageDetails['keywords']);

			/* and the description */
			$rightSpan[] = array ('type' => 'text', 'title' => _('Meta Description'), 'text' => $pageDetails['description']);

			/* Get the queries the account is assigned to */
			$query = 'SELECT p.id, substr(p.name, 0, 50) AS name FROM webpage p, webpagesxassigned x WHERE p.id=x.parentpageid AND x.webpageid='.$db->qstr(intval($_GET['pageid'])).' ORDER BY p.name';

			$rs = $db->Execute($query);

			/* Show the save link if we are editing and the access is correct */
			if (isset ($_GET['edit']) && ($_GET['edit'] == 'parents'))
				$categories = array ('type' => 'data', 'title' => _('Other Parent Pages'), 'save' => 'action=viewpage&amp;domainid='.intval($_GET['domainid']).'&amp;pageid='.intval($_GET['pageid']));
			else
				$categories = array ('type' => 'data', 'title' => _('Other Parent Pages'), 'edit' => 'action=viewpage&amp;edit=parents&amp;domainid='.intval($_GET['domainid']).'&amp;pageid='.intval($_GET['pageid']));

			/* Iterate over the categories and output them */
			while (!$rs->EOF) {
				$categories['data'][$rs->fields['id']] = $rs->fields['name'];
				$categories['selected'][] = $rs->fields['id'];

				$rs->MoveNext();
			}
			
			/* If we are editing with the correct access then grab the existing categories so we can select them */
			if (isset ($_GET['edit']) && ($_GET['edit'] == 'parents')) {
				$query = 'SELECT id, substr(title, 0, 50) AS name FROM webpage WHERE domainid='.$db->qstr($_GET['domainid']).' AND id<>'.$db->qstr($_GET['pageid']).' ORDER BY name';

				$rs = $db->Execute($query);

				while (!$rs->EOF) {
					$categories['values'][$rs->fields['id']] = $rs->fields['name'];
					$rs->MoveNext();
				}
			}

			$rightSpan[] = $categories;
			
			/* If the user is requesting to edit a file, pull out the editable details from the database */
			if (isset ($_GET['edit']) && ($_GET['edit'] == 'file')) {
				$fileDetails = $db->GetRow('SELECT f.name, f.note FROM webpage p, file f, webpagefile w WHERE p.id='.$db->qstr($_GET['pageid']).' AND p.id=w.webpageid AND w.fileid=f.id AND p.domainid='.$db->qstr($_GET['domainid']).' AND f.id='.$db->qstr($_GET['id']));
			}

			/* User has requested to add a new file so show the form */
			if (isset ($_GET['new']) && ($_GET['new'] == 'files') && !$saved)
				$files = array ('type' => 'file', 'title' => _('Upload New File'), 'save' => 'action=viewpage&amp;domainid='.intval($_GET['domainid']).'&amp;pageid='.intval($_GET['pageid']));
			/* User has requested to edit a file */
			else
				if (isset ($_GET['edit']) && ($_GET['edit'] == 'file') && !$saved) {
					$files = array ('type' => 'file', 'title' => _('Update File'), 'save' => 'action=viewpage&amp;domainid='.intval($_GET['domainid']).'&amp;pageid='.intval($_GET['pageid']), 'delete' => true);
					$files['notes'] = $fileDetails['note'];
					/* Just the normal view box for the files */
				} else
					$files = array ('type' => 'data', 'title' => _('Files'), 'new' => 'action=viewpage&amp;new=files&amp;domainid='.intval($_GET['domainid']).'&amp;pageid='.intval($_GET['pageid']));

			/* If we are not editing or adding a new file, show a list of files and set the link to the save form */
			if ((!isset ($_GET['new']) || $saved) && !isset ($_GET['edit'])) {
				$query = 'SELECT f.id, f.name FROM file f, webpagefile i, webpage p WHERE f.id=i.fileid AND p.id=i.webpageid AND p.domainid='.$db->qstr($_GET['domainid']).' AND p.id='.$db->qstr($_GET['pageid']).' ORDER BY id';
				$rs = $db->Execute($query);

				while (($rs !== false) && !$rs->EOF) {
					$files['data'][$rs->fields['id']] = $rs->fields['name'];
					$files['link'][$rs->fields['id']] = 'module=domain&amp;action=viewpage&amp;edit=file&amp;domainid='.$_GET['domainid'].'&amp;pageid='.$_GET['pageid'].'&amp;id='.$rs->fields['id'];
					$rs->MoveNext();
				}
			}

			$rightSpan[] = $files;

			/* Show the actual page contents */
			$page = array ('type' => 'display', 'content' => $pageDetails['content']);

			$bottomData[] = $page;

			/* Send all the data we have just build to the smarty template */
			$smarty->assign('view', true);
			$smarty->assign('leftData', $leftData);
			$smarty->assign('rightData', $rightData);
			$smarty->assign('rightSpan', $rightSpan);
			$smarty->assign('bottomData', $bottomData);
		} else {
			$smarty->assign('errors', array (_('There was a temporary error trying to retrieve the page details. Please try again later. If the problem persists please contact your system administrator')));
		}
	} else {
		$smarty->assign('errors', array (_('You do not have the correct permissions to access this page. If you believe you should please contact your system administrator')));
	}
}
?>
