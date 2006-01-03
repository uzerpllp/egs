<?php 
	require_once (EGS_FILE_ROOT.'/src/classes/class.domain.php');

$domain = new domain();

$accessLevel = $domain->accessLevel(intval($_GET['id']));

if(isset($_GET['show'])) {
	$_SESSION['showwebpages'][intval($_GET['show'])] = 'show';
}

if(isset($_GET['hide'])) {
	$_SESSION['showwebpages'][intval($_GET['hide'])] = 'hide';
}

if(isset($_GET['showcategory'])) {
	$_SESSION['showportfoliocategories'][intval($_GET['showcategory'])] = 'show';
}

if(isset($_GET['hidecategory'])) {
	$_SESSION['showportfoliocategories'][intval($_GET['hidecategory'])] = 'hide';
}

if(isset($_GET['shownewscategory'])) {
	$_SESSION['shownewscategories'][intval($_GET['shownewscategory'])] = 'show';
}

if(isset($_GET['hidenewscategory'])) {
	$_SESSION['shownewscategories'][intval($_GET['hidenewscategory'])] = 'hide';
}
if(isset($_GET['showcomments'])) {
	$_SESSION['showcomments'][intval($_GET['showcomments'])] = 'show';
}
if(isset($_GET['hidecomments'])) {
	$_SESSION['showcomments'][intval($_GET['hidecomments'])] = 'hide';
}
if ($accessLevel > 0) {

	$query = 'SELECT *, owner_address[1] AS owner_address1, owner_address[2] AS owner_address2, owner_address[3] AS owner_address3, admin_address[1] AS admin_address1, admin_address[2] AS admin_address2, admin_address[3] AS admin_address3, billing_address[1] AS billing_address1, billing_address[2] AS billing_address2, billing_address[3] AS billing_address3, tech_address[1] AS tech_address1, tech_address[2] AS tech_address2, tech_address[3] AS tech_address3, '.$db->SQLDate(str_replace('%', '', EGS_DATE_FORMAT), 'expires').' AS expires FROM domain WHERE id='.$db->qstr(intval($_GET['id']));

	$domainDetails = $db->GetRow($query);

	if ($domainDetails !== false) {
		
		/* Add to last viewed */
		$_SESSION['preferences']['lastViewed'] = array_slice(array_merge(array ('module=domain&amp;action=view&amp;id='.intval($_GET['id']) => array ('domains', $domainDetails['name'])), $_SESSION['preferences']['lastViewed']), 0, EGS_RECENTLY_VIEWED);

		/* Sync view to preferences */
		$egs->syncPreferences();

		$smarty->assign('pageTitle', $domainDetails['name']);

		if(EGS_DOMAIN_ADMIN) {
		if ($accessLevel > 0)
			$smarty->assign('pageEdit', 'action=savedomain&amp;id='.intval($_GET['id']));

		$leftData = array ();
		$rightData = array ();
		
		$fields = array();
		$fields[] = '_first_name';
		$fields[] = '_last_name';
		$fields[] = '_org_name';
		$fields[] = '_address1';
		$fields[] = '_address2';
		$fields[] = '_address3';
		$fields[] = '_city';
		$fields[] = '_state';
		$fields[] = '_postal_code';
		$fields[] = '_country';
		$fields[] = '_phone';
		$fields[] = '_fax';
		$fields[] = '_email';
		
		$types = array('owner', 'admin', 'billing', 'tech');
		
		while($type = array_shift($types)) {
			if (($type == 'owner') || ($type == 'billing')) $leftData[] = array ('title' => true, 'tag' => _(ucwords($type.' Details')));
			else $rightData[] = array ('title' => true, 'tag' => _(ucwords($type.' Details')));
			
			while(list($key, $field) = each($fields)) {
				switch($field) {	
					case '_first_name':
						$trans = _('First Name');
						break;
					case '_last_name':
						$trans = _('Surname');
						break;
					case '_org_name':
						$trans = _('Organisation Name');
						break;
					case '_address1':
						$trans = _('Address');
						break;
					case '_address2':
						$trans = '&nbsp;';
						break;
					case '_address3':
						$trans = '&nbsp;';
						break;
					case '_city':
						$trans = _('Town');
						break;
					case '_state':
						$trans = _('County');
						break;
					case '_postal_code':
						$trans = _('Post Code');
						break;
					case '_country':
						$trans = _('Country');
						break;
					case '_phone':
						$trans = _('Phone');
						break;
					case '_fax':
						$trans = _('Fax');
						break;
					case '_email':
						$trans = _('Email');
						break;
				}
				
				if((trim($domainDetails[$type.$field]) !== '') && (($type == 'owner') || ($type == 'billing'))) $leftData[] = array ('tag' => $trans, 'data' => $domainDetails[$type.$field]);
				else if(trim($domainDetails[$type.$field]) !== '') $rightData[] = array ('tag' => $trans, 'data' => $domainDetails[$type.$field]);
			}
			
			reset($fields);
			if ($type == 'owner') $leftData[] = array ('span' => true);
			else if($type == 'admin') $rightData[] = array ('span' => true);
		}
		
		$rightSpan = array ();

		$query = 'SELECT r.id, p.firstname || \' \' || p.surname AS name FROM resource r, person p WHERE p.id=r.personid AND r.domainid='.$db->qstr(intval($_GET['id'])).' AND r.domainmanager ORDER BY name';

		$rs = $db->Execute($query);

		if (($accessLevel > 0) && isset ($_GET['edit']) && ($_GET['edit'] == 'managers'))
			$managers = array ('type' => 'data', 'title' => _('Project Managers'), 'save' => 'action=view&amp;id='.intval($_GET['id']));
		else
			if ($accessLevel > 0)
				$managers = array ('type' => 'data', 'title' => _('Name Servers'), 'edit' => 'action=view&amp;edit=managers&amp;id='.intval($_GET['id']));
			else
				$managers = array ('type' => 'data', 'title' => _('Name Servers'));

		while (!$rs->EOF && ($rs !== false)) {
			$managers['data'][$rs->fields['id']] = $rs->fields['name'];
			$managers['selected'][] = $rs->fields['id'];

			$rs->MoveNext();
		}

		if (($accessLevel > 0) && isset ($_GET['edit']) && ($_GET['edit'] == 'managers')) {
			$query = 'SELECT r.id, p.firstname || \' \' || p.surname AS name FROM resource r, person p WHERE p.id=r.personid AND r.domainid='.$db->qstr(intval($_GET['id'])).' ORDER BY name';

			$rs = $db->Execute($query);

			while (!$rs->EOF) {
				$managers['values'][$rs->fields['id']] = $rs->fields['name'];
				$rs->MoveNext();
			}
		}

		$rightSpan[] = $managers;
		}
		/*things from the forumpost table*/
		$comments = array ('type' => 'data', 'title' => _('Comments'), 'header' => array (_('Title'), _('Added'), _('Message'), _('Approved')), 'viewlink' => 'action=savecomment&amp;domainid='.intval($_GET['id']).'&amp;commentid=','newlinktext' => _('Export Comments'), 'newlink' => 'action=exportcomments&amp;export=tab&amp;domainid='.intval($_GET['id']),);
		
		function comments(& $comments, $id, & $indents, & $pre, $indent) {
			global $db, $domain;
			$query = 'SELECT id, title, '.$db->SQLDate('d-m-Y', 'added').' AS added, CASE WHEN char_length(message) > 50 THEN substring(message,0,50) || \'...\' ELSE message END AS message, CASE WHEN approved THEN \'Yes\' ELSE \'No\' END AS approved	FROM forumpost WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' AND forumpostid='.$db->qstr($id).' ORDER BY added';
			
			$rs = $db->Execute($query);
			
			$indent ++;
			while (($rs !== false) && !$rs->EOF) {
				$comments['data'][] = $rs->fields;

				$indents[] = $indent;
				if(isset($_SESSION['showcomments'][$rs->fields['id']]) && ($_SESSION['showcomments'][$rs->fields['id']] == 'show')) {
					if($domain->hasSubposts($rs->fields['id'])) {
						$pre[] = array('sign' => '-', 'link' => $rs->fields['id']);
						pages($comments, $rs->fields['id'], $indents, $pre, $indent);
					} else $pre[] = array('sign' => '');
				} else if($domain->hasSubposts($rs->fields['id'])) $pre[] = array('sign' => '+', 'link' => $rs->fields['id']);
				else $pre[] = array('sign' => '');
				
				$rs->MoveNext();
			}
		}
		
		
		/*-----------------------------*/
		if ($accessLevel > 0)
			$pages = array ('type' => 'data', 'title' => _('Web Pages'), 'header' => array (_('Page Name'), _('Page Title'), _('Keywords'), _('Page Type')), 'viewlink' => 'action=viewpage&amp;domainid='.intval($_GET['id']).'&amp;pageid=', 'newlink' => 'action=savepage&amp;domainid='.intval($_GET['id']));
		else
			$pages = array ('type' => 'data', 'title' => _('Web Pages'), 'header' => array (_('Task Name'), _('Page Title'), _('Keywords'), _('Page Type')));
		
		function pages(& $page, $id, & $indents, & $pre, $indent) {
			global $db, $domain;
			$query = 'SELECT id, name, title, CASE WHEN char_length(keywords) > 50 THEN substring(keywords, 0, 50) || \' ...\' ELSE keywords END AS keywords, CASE WHEN type='.$db->qstr('S').' THEN '.$db->qstr(_('Static')).' WHEN type='.$db->qstr('P').' THEN '.$db->qstr(_('Portfolio Page')).' ELSE '.$db->qstr(_('News Page')).' END AS pagetype FROM webpage WHERE domainid='.$db->qstr(intval($_GET['id'])).' AND parentpageid='.$db->qstr($id).' ORDER BY name';

			$rs = $db->Execute($query);

			$indent ++;

			while (($rs !== false) && !$rs->EOF) {
				$page['data'][] = $rs->fields;

				$indents[] = $indent;

				if(isset($_SESSION['showwebpages'][$rs->fields['id']]) && ($_SESSION['showwebpages'][$rs->fields['id']] == 'show')) {
					if($domain->hasChildren($rs->fields['id'])) {
						$pre[] = array('sign' => '-', 'link' => $rs->fields['id']);
						pages($page, $rs->fields['id'], $indents, $pre, $indent);
					} else $pre[] = array('sign' => '');
				} else if($domain->hasChildren($rs->fields['id'])) $pre[] = array('sign' => '+', 'link' => $rs->fields['id']);
				else $pre[] = array('sign' => '');
				
				$rs->MoveNext();
			}
		}
		
		function portfolioItems(& $page, $id, & $indents, & $pre, & $links, $indent) {
			global $db, $domain;
			$query = 'SELECT id, name, \'-\' AS items, \'0\' AS rating, \'0\' as verified, voteoffset FROM portfolioitem WHERE portfolioid='.$db->qstr($id).' ORDER BY name';

			$rs = $db->Execute($query);

			$indent++;
			
			while (($rs !== false) && !$rs->EOF) {
				$page['data'][] = $rs->fields;

				$indents[] = $indent;
				
				$links[2][] = 'action=viewportfolioitem&amp;domainid='.$_GET['id'].'&amp;portfolioitemid='.$rs->fields['id'];

				$pre[] = array('sign' => '');
				
				$rs->MoveNext();
			}
		}
		
		function newsItems(& $page, $id, & $indents, & $pre, & $links, $indent) {
			global $db, $domain;
			$query = 'SELECT id, headline, \'-\' AS items, '.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 'published').' AS published, '.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 'showfrom').' AS showfrom, '.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 'showuntil').' AS showuntil FROM news WHERE newscategoryid='.$db->qstr($id).' ORDER BY published';

			$rs = $db->Execute($query);

			$indent++;
			
			while (($rs !== false) && !$rs->EOF) {
				$page['data'][] = $rs->fields;

				$indents[] = $indent;
				
				$links[2][] = 'action=savenewsitem&amp;domainid='.$_GET['id'].'&amp;id='.$rs->fields['id'];

				$pre[] = array('sign' => '');
				
				$rs->MoveNext();
			}
		}

		$indents = array ();
		$pre = array ();

		$query = 'SELECT id, name, title, CASE WHEN char_length(keywords) > 50 THEN substring(keywords, 0, 50) || \' ...\' ELSE keywords END AS keywords, CASE WHEN type='.$db->qstr('S').' THEN '.$db->qstr(_('Static')).' WHEN type='.$db->qstr('P').' THEN '.$db->qstr(_('Portfolio Page')).' ELSE '.$db->qstr(_('News Page')).' END AS pagetype FROM webpage WHERE domainid='.$db->qstr(intval($_GET['id'])).' AND parentpageid IS NULL ORDER BY name';

		$rs = $db->Execute($query);

		while (!$rs->EOF && ($rs !== false)) {
			$pages['data'][] = $rs->fields;
		
			$indents[] = 0;
	
			if(isset($_SESSION['showwebpages'][$rs->fields['id']]) && ($_SESSION['showwebpages'][$rs->fields['id']] == 'show')) {
				if($domain->hasChildren($rs->fields['id'])) {
					$pre[] = array('sign' => '-', 'link' => $rs->fields['id']);
					pages($pages, $rs->fields['id'], $indents, $pre, 0);
				} else $pre[] = array('sign' => '', 'link' => $rs->fields['id']);
			} else if($domain->hasChildren($rs->fields['id'])) $pre[] = array('sign' => '+', 'link' => $rs->fields['id']);
			else $pre[] = array('sign' => '');
			
			$rs->MoveNext();
		}

		$pages['indents'] = $indents;
		$pages['pre'] = $pre;

		$bottomData[] = $pages;
		
		if ($accessLevel > 0) {
			$categories = array ('type' => 'data', 'title' => _('Portfolio'), 'header' => array (_('Name'), _('Portfolio Items'), _('Rating'), _('Verified Rating'), _('Rating Offset')), 'newlinktext' => _('New Category'), 'newlink' => 'action=savecategory&amp;domainid='.intval($_GET['id']), 'newlink2' => 'action=saveportfolioitem&amp;domainid='.intval($_GET['id']), 'newlinktext2' => _('New Portfolio Item'));
		
		function categories(& $category, $id, & $indents, & $pre, & $links,  $indent) {
			global $db, $domain;
			$query = 'SELECT c.id, c.name, CASE WHEN i.items IS NULL THEN 0 ELSE i.items END AS items, \'-\' AS rating, \'-\' AS verified, \'-\' AS offset FROM portfoliocategory c LEFT OUTER JOIN (SELECT portfolioid, count(id) AS items FROM portfolioitem GROUP BY portfolioid) i ON (c.id=i.portfolioid) WHERE domainid='.$db->qstr(intval($_GET['id'])).' AND parentcategoryid='.$db->qstr($id).' ORDER BY name';

			$rs = $db->Execute($query);

			$indent ++;

			while (($rs !== false) && !$rs->EOF) {
				$category['data'][] = $rs->fields;

				$indents[] = $indent;
				$links[2][] = 'action=savecategory&amp;domainid='.$_GET['id'].'&amp;portfoliocategoryid='.$rs->fields['id'];

				if(isset($_SESSION['showportfoliocategories'][$rs->fields['id']]) && ($_SESSION['showportfoliocategories'][$rs->fields['id']] == 'show')) {
					if($domain->hasPortfolioCategoryChildren($rs->fields['id']) || $domain->hasPortfolioItemsChildren($rs->fields['id'])) {
						if($domain->hasPortfolioCategoryChildren($rs->fields['id'])) {
							$pre[] = array('sign' => '-', 'suffix' => 'category', 'link' => $rs->fields['id']);
							categories($category, $rs->fields['id'], $indents, $pre, $links, $indent);
						}
					
						if($domain->hasPortfolioItemsChildren($rs->fields['id'])) {
							$pre[] = array('sign' => '');
							portfolioItems($category, $rs->fields['id'], $indents, $pre, $links, $indent);
						}
					} else $pre[] = array('sign' => '');
				} else if($domain->hasPortfolioCategoryChildren($rs->fields['id']) || $domain->hasPortfolioItemsChildren($rs->fields['id'])) $pre[] = array('sign' => '+', 'link' => $rs->fields['id'], 'suffix' => 'category');
				else $pre[] = array('sign' => '');
				
				$rs->MoveNext();
			}
		}

		$indents = array ();
		$pre = array ();
		$links = array();

		$query = 'SELECT c.id, c.name, CASE WHEN i.items IS NULL THEN 0 ELSE i.items END AS items, \'-\' AS rating, \'-\' AS verified, \'-\' AS offset FROM portfoliocategory c LEFT OUTER JOIN (SELECT portfolioid, count(id) AS items FROM portfolioitem GROUP BY portfolioid) i ON (c.id=i.portfolioid) WHERE domainid='.$db->qstr(intval($_GET['id'])).' AND parentcategoryid IS NULL ORDER BY name';

		$rs = $db->Execute($query);

		while (!$rs->EOF && ($rs !== false)) {
			$categories['data'][] = $rs->fields;
		
			$indents[] = 0;

			$links[2][] = 'action=savecategory&amp;domainid='.$_GET['id'].'&amp;portfoliocategoryid='.$rs->fields['id'];
	
			if(isset($_SESSION['showportfoliocategories'][$rs->fields['id']]) && ($_SESSION['showportfoliocategories'][$rs->fields['id']] == 'show')) {
				if($domain->hasPortfolioCategoryChildren($rs->fields['id'])) {
					$pre[] = array('sign' => '-', 'suffix' => 'category', 'link' => $rs->fields['id']);
					categories($categories, $rs->fields['id'], $indents, $pre, $links, 0);
				}
				else if($domain->hasPortfolioItemsChildren($rs->fields['id'])) {
					$pre[] = array('sign' => '-', 'suffix' => 'category', 'link' => $rs->fields['id']);
					portfolioItems($categories, $rs->fields['id'], $indents, $pre, $links, 0);
				} else $pre[] = array('sign' => '', 'suffix' => 'category', 'link' => $rs->fields['id']);
			} else if($domain->hasPortfolioCategoryChildren($rs->fields['id']) || $domain->hasPortfolioItemsChildren($rs->fields['id'])) $pre[] = array('sign' => '+', 'suffix' => 'category', 'link' => $rs->fields['id']);
			else $pre[] = array('sign' => '');
			
			$rs->MoveNext();
		}

		$categories['indents'] = $indents;
		$categories['pre'] = $pre;
		$categories['links'] = $links;

		$bottomData[] = $categories;
		}
		
		if ($accessLevel > 0) {
			$categories = array ('type' => 'data', 'title' => _('News'), 'header' => array (_('Name/Title'), _('News Items'), _('Published'), _('Show From'), _('Show Until')), 'newlinktext' => _('New Category'), 'newlink' => 'action=savenewscategory&amp;domainid='.intval($_GET['id']), 'newlink2' => 'action=savenewsitem&amp;domainid='.intval($_GET['id']), 'newlinktext2' => _('New News Item'));
		
		function newsCategories(& $category, $id, & $indents, & $pre, & $links,  $indent) {
			global $db, $domain;
			$query = 'SELECT c.id, c.name, CASE WHEN i.items IS NULL THEN 0 ELSE i.items END AS items, \'-\' AS published, \'-\' AS showfrom, \'-\' AS showuntil FROM newscategory c LEFT OUTER JOIN (SELECT newscategoryid, count(id) AS items FROM news GROUP BY newscategoryid) i ON (c.id=i.newscategoryid) WHERE domainid='.$db->qstr(intval($_GET['id'])).' AND parentcategoryid='.$db->qstr($id).' ORDER BY name';

			$rs = $db->Execute($query);

			$indent ++;

			while (($rs !== false) && !$rs->EOF) {
				$category['data'][] = $rs->fields;

				$indents[] = $indent;
				$links[2][] = 'action=savenewscategory&amp;domainid='.$_GET['id'].'&amp;newscategoryid='.$rs->fields['id'];

				if(isset($_SESSION['shownewscategories'][$rs->fields['id']]) && ($_SESSION['shownewscategories'][$rs->fields['id']] == 'show')) {
					if($domain->hasNewsCategoryChildren($rs->fields['id']) || $domain->hasNewsItemsChildren($rs->fields['id'])) {
						if($domain->hasNewsCategoryChildren($rs->fields['id'])) {
							$pre[] = array('sign' => '-', 'suffix' => 'newscategory', 'link' => $rs->fields['id']);
							newsCategories($category, $rs->fields['id'], $indents, $pre, $links, $indent);
						}
					
						if($domain->hasNewsItemsChildren($rs->fields['id'])) {
							$pre[] = array('sign' => '');
							newsItems($category, $rs->fields['id'], $indents, $pre, $links, $indent);
						}
					} else $pre[] = array('sign' => '');
				} else if($domain->hasNewsCategoryChildren($rs->fields['id']) || $domain->hasNewsItemsChildren($rs->fields['id'])) $pre[] = array('sign' => '+', 'link' => $rs->fields['id'], 'suffix' => 'newscategory');
				else $pre[] = array('sign' => '');
				
				$rs->MoveNext();
			}
		}

		$indents = array ();
		$pre = array ();
		$links = array();

		$query = 'SELECT c.id, c.name, CASE WHEN i.items IS NULL THEN 0 ELSE i.items END AS items, \'-\' AS published, \'-\' AS verified, \'-\' AS offset FROM newscategory c LEFT OUTER JOIN (SELECT newscategoryid, count(id) AS items FROM news GROUP BY newscategoryid) i ON (c.id=i.newscategoryid) WHERE domainid='.$db->qstr(intval($_GET['id'])).' AND parentcategoryid IS NULL ORDER BY name';

		$rs = $db->Execute($query);

		while (!$rs->EOF && ($rs !== false)) {
			$categories['data'][] = $rs->fields;
		
			$indents[] = 0;

			$links[2][] = 'action=savenewscategory&amp;domainid='.$_GET['id'].'&amp;newscategoryid='.$rs->fields['id'];
	
			if(isset($_SESSION['shownewscategories'][$rs->fields['id']]) && ($_SESSION['shownewscategories'][$rs->fields['id']] == 'show')) {
				if($domain->hasNewsCategoryChildren($rs->fields['id'])) {
					$pre[] = array('sign' => '-', 'suffix' => 'newscategory', 'link' => $rs->fields['id']);
					newsCategories($categories, $rs->fields['id'], $indents, $pre, $links, 0);
				}
				else if($domain->hasNewsItemsChildren($rs->fields['id'])) {
					$pre[] = array('sign' => '-', 'suffix' => 'newscategory', 'link' => $rs->fields['id']);
					newsItems($categories, $rs->fields['id'], $indents, $pre, $links, 0);
				} else $pre[] = array('sign' => '', 'suffix' => 'newscategory', 'link' => $rs->fields['id']);
			} else if($domain->hasNewsCategoryChildren($rs->fields['id']) || $domain->hasNewsItemsChildren($rs->fields['id'])) $pre[] = array('sign' => '+', 'suffix' => 'newscategory', 'link' => $rs->fields['id']);
			else $pre[] = array('sign' => '');
			
			$rs->MoveNext();
		}
		
		$query = 'SELECT id, headline, \'-\' AS items, '.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 'published').' AS published, '.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 'showfrom').' AS showfrom, '.$db->SQLDate(str_replace('%', '', EGS_TIME_FORMAT), 'showuntil').' AS showuntil FROM news WHERE newscategoryid IS null AND domainid='.$db->qstr(intval($_GET['id'])).' ORDER BY published';

			$rs = $db->Execute($query);
			
			while (($rs !== false) && !$rs->EOF) {
				$categories['data'][] = $rs->fields;

				$indents[] = 0;
				
				$links[2][] = 'action=savenewsitem&amp;domainid='.$_GET['id'].'&amp;id='.$rs->fields['id'];

				$pre[] = array('sign' => '');
				
				$rs->MoveNext();
			}

		$categories['indents'] = $indents;
		$categories['pre'] = $pre;
		$categories['links'] = $links;

		$bottomData[] = $categories;
		}
		
		
		/*now comments*/
		$indents = array ();
		$pre = array ();

		$query = 'SELECT id, title FROM forumpost WHERE companyid='.$db->qstr(EGS_COMPANY_ID).' AND forumpostid IS NULL ORDER BY title';
		
		$rs = $db->Execute($query);

		while (!$rs->EOF && ($rs !== false)) {
			$comments['data'][] = $rs->fields;
		
			$indents[] = 0;
	
			if(isset($_SESSION['showcomments'][$rs->fields['id']]) && ($_SESSION['showcomments'][$rs->fields['id']] == 'show')) {
				
				if($domain->hasSubposts($rs->fields['id'])) {
					$pre[] = array('sign' => '-','suffix'=>'comments', 'link' => $rs->fields['id']);
					comments($comments, $rs->fields['id'], $indents, $pre, 0);
				} else $pre[] = array('sign' => '','suffix'=>'comments', 'link' => $rs->fields['id']);
			} else if($domain->hasSubposts($rs->fields['id'])) $pre[] = array('sign' => '+','suffix'=>'comments', 'link' => $rs->fields['id']);
			else $pre[] = array('sign' => '');
			
			$rs->MoveNext();
		}

		$comments['indents'] = $indents;
		$comments['pre'] = $pre;

		$bottomData[] = $comments;
		
		
		$smarty->assign('view', true);
		if(EGS_DOMAIN_ADMIN) {
		$smarty->assign('leftData', $leftData);
		$smarty->assign('rightData', $rightData);
		$smarty->assign('rightSpan', $rightSpan);
		}
		$smarty->assign('bottomData', $bottomData);

	} else {
		$smarty->assign('errors', array (_('There was a temporary error trying to retrieve the domain details. Please try again later. If the problem persists please contact your system administrator')));
	}
} else {
	$smarty->assign('errors', array (_('You do not have the correct permissions to access this domain. If you believe you should please contact your system administrator')));
}
?>
