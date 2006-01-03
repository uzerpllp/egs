<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Enterprise Groupware System</title>
	<link rel="stylesheet" href="{$serverRoot}/themes/{$theme}/print.css" type="text/css" />
    <meta name="keywords" content="Groupware, ERP, Project Management" />
    <meta name="description" content="Enterprise Groupware System - built by Senokian Solutions Ltd - http://www.senokian.com" />

</head>
<body>
				<!-- This is the main body area -->


						<table cellspacing="0" cellpadding="0" id="overview">
							<thead>
								<tr>
									{foreach name=headings key=headingOrder item=headingTitle from=$headings}<td>{$headingTitle}</td>{/foreach}
								</tr>
							</thead>
							<tbody>
								{section name=rows loop=$rows}
								{cycle values="off,on" assign="rowbg"}
									<tr onmouseover="this.className='over'" onmouseout="this.className='{$rowbg}'" class="{$rowbg}">
									{section name=data loop=$rows[rows]}{if !$smarty.section.data.first}<td class="{$rowbg}{if $smarty.section.rows.last}off{/if}">{$rows[rows][data]|default:"&nbsp;"}</td>{/if}{/section}
									</tr>
								{/section}
							</tbody>
						</table>
				<!-- End of main body area -->
</body>
</html>
