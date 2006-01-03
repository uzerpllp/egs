<?php   
// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - View Portfolio Item 1.0          |
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
				$saved = $domain->deletePortfolioFile($_GET['domainid'], $_GET['id']);
			/* We are saving a file for attachement */
			else
				$saved = $domain->saveFile($_POST, $id, $_GET['domainid'], null, $_GET['portfolioitemid']);
		}

		/* Build the query to get the portfolioitem details */
		$query = 'SELECT i.*, c.name AS categoryname, comp.name AS companyname, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'i.updated').' AS updated, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'i.added').' AS added FROM portfolioitem i LEFT OUTER JOIN company comp ON (i.companyid=comp.id), portfoliocategory c WHERE c.id=i.portfolioid AND c.domainid='.$db->qstr(intval($_GET['domainid'])).' AND i.id='.$db->qstr(intval($_GET['portfolioitemid']));

		/* Send the query and get results */
		$portfolioitemDetails = $db->GetRow($query);

		/* As long as the result set is not false we are allowed to view this portfolioitem */
		if ($portfolioitemDetails !== false) {
			/* Add to last viewed */
			$_SESSION['preferences']['lastViewed'] = array_slice(array_merge(array ('module=domain&amp;action=viewportfolioitem&amp;domainid='.intval($_GET['domainid']).'&amp;portfolioitemid='.intval($_GET['portfolioitemid']) => array ('webportfolioitem', $portfolioitemDetails['name'])), $_SESSION['preferences']['lastViewed']), 0, EGS_RECENTLY_VIEWED);

			/* Sync view to preferences */
			$egs->syncPreferences();

			/* Set the portfolioitem title and edit/delete links */
			$smarty->assign('pageTitle', $portfolioitemDetails['name']);
			$smarty->assign('pageEdit', 'action=saveportfolioitem&amp;domainid='.intval($_GET['domainid']).'&amp;portfolioitemid='.intval($_GET['portfolioitemid']));
			$smarty->assign('pageDelete', 'action=deleteportfolioitem&amp;domainid='.intval($_GET['domainid']).'&amp;portfolioitemid='.intval($_GET['portfolioitemid']));

			/* Now build the portfolioitem data for the left column */
			$leftData = array ();

			$leftData[] = array ('tag' => _('Page Name'), 'data' => $portfolioitemDetails['name']);
			$leftData[] = array ('tag' => _('Client'), 'data' => $portfolioitemDetails['companyname']);
			$leftData[] = array ('span' => true);

			/* The dates will already have been converted in the query above to the correct format */
			$leftData[] = array ('tag' => _('Added'), 'data' => $portfolioitemDetails['added'].' '._('by').' '.$portfolioitemDetails['owner']);
			$leftData[] = array ('tag' => _('Last Updated'), 'data' => $portfolioitemDetails['updated'].' '._('by').' '.$portfolioitemDetails['alteredby']);

			/* Now build the right column */
			$rightData = array ();

			/* Translate the portfolioitem type */
			switch ($portfolioitemDetails['orientation']) {
				case 'S' :
					$portfolioitemDetails['orientation'] = _('Square');
					break;
				case 'P' :
					$portfolioitemDetails['orientation'] = _('Portrait');
					break;
				case 'L' :
					$portfolioitemDetails['orientation'] = _('Landscape');
					break;
				case 'H' :
					$portfolioitemDetails['orientation'] = _('Panoramic');
					break;
			}

			$rightData[] = array ('tag' => _('Category'), 'data' => $portfolioitemDetails['categoryname']);
			$rightData[] = array ('tag' => _('Page Type'), 'data' => $portfolioitemDetails['orientation']);
			$rightData[] = array ('tag' => _('Website'), 'data' => $portfolioitemDetails['www']);

			/* Build the data for the boxes on the right */
			$rightSpan = array ();

			/* If the user is requesting to edit a file, pull out the editable details from the database */
			if (isset ($_GET['edit']) && ($_GET['edit'] == 'file')) {
				$fileDetails = $db->GetRow('SELECT f.name, f.note FROM portfolioitem p, file f, portfolioitemimages w WHERE p.id='.$db->qstr($_GET['portfolioitemid']).' AND p.id=w.portfolioitemid AND w.fileid=f.id AND p.domainid='.$db->qstr($_GET['domainid']).' AND f.id='.$db->qstr($_GET['id']));
			}

			/* User has requested to add a new file so show the form */
			if (isset ($_GET['new']) && ($_GET['new'] == 'files') && !$saved)
				$files = array ('type' => 'file', 'title' => _('Upload New File'), 'save' => 'action=viewportfolioitem&amp;domainid='.intval($_GET['domainid']).'&amp;portfolioitemid='.intval($_GET['portfolioitemid']));
			/* User has requested to edit a file */
			else
				if (isset ($_GET['edit']) && ($_GET['edit'] == 'file') && !$saved) {
					$files = array ('type' => 'file', 'title' => _('Update File'), 'save' => 'action=viewportfolioitem&amp;domainid='.intval($_GET['domainid']).'&amp;portfolioitemid='.intval($_GET['portfolioitemid']), 'delete' => true);
					$files['notes'] = $fileDetails['note'];
					/* Just the normal view box for the files */
				} else
					$files = array ('type' => 'data', 'title' => _('Files'), 'new' => 'action=viewportfolioitem&amp;new=files&amp;domainid='.intval($_GET['domainid']).'&amp;portfolioitemid='.intval($_GET['portfolioitemid']));

			/* If we are not editing or adding a new file, show a list of files and set the link to the save form */
			if ((!isset ($_GET['new']) || $saved) && !isset ($_GET['edit'])) {
				$query = 'SELECT f.id, f.name FROM file f, portfolioitemimages i, portfolioitem p WHERE f.id=i.fileid AND p.id=i.portfolioitemid AND p.domainid='.$db->qstr($_GET['domainid']).' AND p.id='.$db->qstr($_GET['portfolioitemid']).' ORDER BY id';
				$rs = $db->Execute($query);

				while (($rs !== false) && !$rs->EOF) {
					$files['data'][$rs->fields['id']] = $rs->fields['name'];
					$files['link'][$rs->fields['id']] = 'module=domain&amp;action=viewportfolioitem&amp;edit=file&amp;domainid='.$_GET['domainid'].'&amp;portfolioitemid='.$_GET['portfolioitemid'].'&amp;id='.$rs->fields['id'];
					$rs->MoveNext();
				}
			}

			$rightSpan[] = $files;

			/* Show the actual portfolioitem contents */
			$portfolioitem = array ('type' => 'display', 'content' => nl2br($portfolioitemDetails['description']));

			$bottomData[] = $portfolioitem;

			/* Send all the data we have just build to the smarty template */
			$smarty->assign('view', true);
			$smarty->assign('leftData', $leftData);
			$smarty->assign('rightData', $rightData);
			$smarty->assign('rightSpan', $rightSpan);
			$smarty->assign('bottomData', $bottomData);
		} else {
			$smarty->assign('errors', array (_('There was a temporary error trying to retrieve the portfolioitem details. Please try again later. If the problem persists please contact your system administrator')));
		}
	} else {
		$smarty->assign('errors', array (_('You do not have the correct permissions to access this portfolioitem. If you believe you should please contact your system administrator')));
	}
}
?>
