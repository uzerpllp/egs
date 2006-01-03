<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
<link rel="stylesheet" href="{$serverRoot}/themes/{$theme}/styles.css" type="text/css" />
<link rel="stylesheet" href="{$serverRoot}/themes/{$theme}/js/mygosmenu/styles.css" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="{$serverRoot}/themes/{$theme}/js/jscalendar/skins/aqua/theme.css" title="Aqua" />
{literal}<script type='text/javascript' language='JavaScript'>
function set_values(account_id, account_name, company_id, company_name) {
	window.opener.document.saveform.{/literal}{$smarty.get.name}name{literal}.value = account_name;
	window.opener.document.saveform.{/literal}{$smarty.get.name}id{literal}.value = account_id;
{/literal}
{if ($smarty.get.name eq "company") && ($smarty.get.hide neq "person")}
{literal}
	window.opener.document.saveform.{/literal}personid{literal}.value = '';
	window.opener.document.saveform.{/literal}personname{literal}.value = '';
{/literal}
{/if}
{if ($smarty.get.name eq "internalqueue")}
{literal}
	window.opener.document.saveform.{/literal}queueid{literal}.value = company_id;
	window.opener.document.saveform.{/literal}queuename{literal}.value = company_name;
{/literal}
{/if}
{if ($smarty.get.name eq "queue")}
{literal}
	window.opener.document.saveform.{/literal}internalqueueid{literal}.value = company_id;
	window.opener.document.saveform.{/literal}internalqueuename{literal}.value = company_name;
{/literal}
{/if}
{if ($smarty.get.name eq "person") && ($smarty.get.hide neq "company") && ($smarty.get.companyid eq "")}
{literal}
	window.opener.document.saveform.{/literal}companyid{literal}.value = company_id;
	window.opener.document.saveform.{/literal}companyname{literal}.value = company_name;
{/literal}
{/if}
{literal}
	window.close();
}
</script>{/literal}
</head>
<body id="chooser">
				<table id="mainbody" cellspacing="0" cellpadding="0">
				{if $pageTitle neq ""}<tr><td class="heading"><img src="{$serverRoot}/themes/{$theme}/graphics/{$module|lower}.gif" alt="" /> {$pageTitle}</td></tr>{/if}
				{if $search}
					<tr><td class="search">
						<form id="search" name="saveform" action="{$self}" method="post">
						<table class="search" cellpadding="0" cellspacing="0">
							<thead><tr><td class="searchheading" colspan="3">{$searchTitle}</td></tr></thead>
							<tbody>
					{foreach name=search key=key item=item from=$search}
						{if $smarty.foreach.search.first}<tr>{/if}
						{if $item.type eq "text"}<td>{$item.name}<br /><input type="text" value="{$smarty.session.search.$key}" name="{$key}" /></td>
						{elseif $item.type eq "select"}<td>{$item.name}<br /><select name="{$key}">{foreach key=selectkey item=selectitem from=$item.values}<option value="{$selectitem}" {if $selectitem eq $smarty.session.search.$key}selected="selected"{/if}>{$selectkey}</option>{/foreach}</select></td>{/if}
						{if ($smarty.foreach.search.iteration%3 eq 0) && !$smarty.foreach.search.last}</tr><tr>
						{elseif $smarty.foreach.search.last}</tr>{/if}
					{/foreach}
							<tr><td colspan="3"><input class="button" type="submit" name="search" value="{t}Search{/t}" /> <input class="button" type="submit" name="clearsearch" value="{t}Clear Search{/t}" /></td></tr>
							</tbody>
						</table>
						</form>
					</td>
				</tr>
				<tr><td class="add">
					{if $message neq ""}{$message}{else}
						<form id="add" name="saveform" action="{$self}" method="post">
						{foreach name=hidden key=name item=value from=$hidden}
						<input type="hidden" name="{$name}" value="{$value}" />
						{/foreach}
						<table class="search" cellpadding="0" cellspacing="0">
							<thead><tr><td class="searchheading" colspan="3">{$addTitle}</td></tr></thead>
							<tbody>
					{foreach name=add key=key item=item from=$add}
						{if $smarty.foreach.add.first}<tr>{/if}
						{if $item.type eq "text"}<td>{$item.name}<br /><input type="text" value="{$smarty.session.add.$key}" name="{$key}" /></td>
						{elseif $item.type eq "select"}<td>{$item.name}<br />{html_options name=$key values=$item.values output=$item.values}</td>{/if}
						{if ($smarty.foreach.add.iteration%3 eq 0) && !$smarty.foreach.add.last}</tr><tr>
						{elseif $smarty.foreach.add.last}</tr>{/if}
					{/foreach}
							<tr><td colspan="3"><input class="button" type="submit" name="add" value="{t}Add{/t}" /></td></tr>
							</tbody>
						</table>
						</form>
						{/if}
					</td>
				</tr>
				{/if}
				<tr>
					<td>
						<table cellspacing="0" cellpadding="0" id="page">
							<tr>
								<td class="page">{if $firstPage}<a href="{$self}&amp;page=1">&lt;&lt; Start</a>{else}&lt;&lt; Start{/if} {if $backPage}<a href="{$self}&amp;page={$backPage}">&lt; Previous</a>{else}&lt; Previous{/if} <span>({$currentPage} of {$totalPages})</span> {if $nextPage}<a href="{$self}&amp;page={$nextPage}">Next &gt;</a>{else}Next &gt;{/if} {if $lastPage}<a href="{$self}&amp;page={$lastPage}">End &gt;&gt;</a>{else}End &gt;&gt;{/if}</td>
							</tr>
						</table>
						<table cellspacing="0" cellpadding="0" id="overview">
							<thead>
								<tr>
									{foreach name=headings key=headingOrder item=headingTitle from=$headings}<td{if $headingOrder eq $smarty.session.order} class="ordered"{/if}><a href="?{$session}&amp;module={$smarty.get.module}{if $smarty.get.action neq ""}&amp;action={$smarty.get.action}{/if}&amp;order={$headingOrder}">{$headingTitle}</a></td>{/foreach}
								</tr>
							</thead>
							<tbody>
								{section name=rows loop=$rows}
								{cycle values="off,on" assign="rowbg"}
									<tr onmouseover="this.className='over'" onmouseout="this.className='{$rowbg}'" class="{$rowbg}">
									{section start=2 name=data loop=$rows[rows]}<td class="{$rowbg}{if $smarty.section.rows.last}off{/if}">{if $smarty.section.data.iteration eq 1}<a href="#" LANGUAGE=javascript onclick='set_values("{if $smarty.get.name eq "company"}{$rows[rows][1]}{else}{$rows[rows][0]}{/if}", "{if $case}{$rows[rows][3]}{elseif ($smarty.get.name eq "person") || ($smarty.get.name eq "item")}{$rows[rows][2]}{elseif ($smarty.get.name eq "queue")}{$rows[rows][2]}{elseif ($smarty.get.name eq "internalqueue")}{$rows[rows][2]}{else}{$rows[rows][3]}{/if}", "{if ($smarty.get.name neq "company") && ($smarty.get.name neq "queue")}{$rows[rows][1]}{/if}", "{if ($smarty.get.name neq "company") && ($smarty.get.name neq "queue")}{$rows[rows][3]}{/if}")'>{/if}{$rows[rows][data]|default:"&nbsp;"}{if $smarty.section.data.iteration eq 1}</a>{/if}</td>{/section}
									</tr>
								{sectionelse}<td class="centre" colspan="{$smarty.foreach.headings.total}">{t}The search critera you have entered returned no data{/t}</td>{/section}
							</tbody>
						</table>
					</td>
				</tr>
				</table>
</body>
</html>
