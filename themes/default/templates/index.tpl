<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	
	{include file="includes/head.tpl"}
</head>
<body{if $redirect} onLoad="setTimeout('delayer()', 2000)"{/if}>

{if $module eq 'home'}
<form id="eventPopupForm" method="post" action="{$serverRoot}/modules/calendar/includes/event2.php" style="display: none;">
	<div class="form">
	  <input type="hidden" name="date" id="date" value="" />
	  <input type="hidden" name="time" id="time" value="" />
	  <input type="hidden" name="uid" id="uid" value="" />
	 </div>
</form>
{/if}
<table id="body">
	{include file="includes/top.tpl"}
	<tr>
		<td class="sub">
		{include file="includes/left.tpl"}
		</td>
		<td colspan="2" class="body">

			{include file="includes/flash.tpl"}
			{if $homePage}
				{include file="includes/homepage.tpl"}
			{/if}
			{if $dashboard}
				<table class="dashboard" cellspacing="0" cellpadding="0">
					<tr><td class="heading">{t}Pipeline by Sales Stage{/t}</td></tr>
					<tr><td class="dashboard"><img src="{$serverRoot}/?{$session}&amp;module=crm&amp;action=graphs&amp;view=opportunities" alt="" /></td></tr>
				</table>
				<table class="dashboard" cellspacing="0" cellpadding="0">
					<tr><td class="heading">{t}Opportunities by Source by Outcome{/t}</td></tr>
					<tr><td class="dashboard"><img src="{$serverRoot}/?{$session}&amp;module=crm&amp;action=graphs&amp;view=sourceoutcome" alt="" /></td></tr>
				</table>
				<table class="dashboard" cellspacing="0" cellpadding="0">
					<tr><td class="heading">{t}Opportunities by Month by Outcome{/t}</td></tr>
					<tr><td class="dashboard"><img src="{$serverRoot}/?{$session}&amp;module=crm&amp;action=graphs&amp;view=monthoutcome" alt="" /></td></tr>
				</table>
				<table class="dashboard" cellspacing="0" cellpadding="0">
					<tr><td class="heading">{t}All Opportunities by Lead Source{/t}</td></tr>
					<tr><td class="dashboard"><img src="{$serverRoot}/?{$session}&amp;module=crm&amp;action=graphs&amp;view=allopportunities" alt="" /></td></tr>
				</table>
			{/if}
			{if $iframe}
			<div id="iframeholder{if $smarty.get.module eq "wiki"}wiki{elseif $smarty.get.module eq "weberp"}weberp{elseif $smarty.get.module eq "filesharing"}file{/if}"><iframe onload="document.getElementById('the_iframe').height=document.getElementById('the_iframe').contentWindow.document.body.scrollHeight+20;document.getElementById('bodyarea').style.width=(document.width-20) + 'px';document.getElementById('bodyarea').style.height=(document.height-20) + 'px';" id="the_iframe" src="{$iframeSrc}"></iframe></div>
			{/if}
			{if $image}
			<img src="{$serverRoot}/image.php?{$session}&amp;action={$imageAction}&amp;id={$imageId}" alt="" id="image"/>
			{/if}
			{if $setup || $form || $search || ($module eq "admin" && $smarty.get.action eq "groups") }
				<form {if $formFile}enctype="multipart/form-data" {/if}id="{$formId|default:"multipledelete"}" name="saveform" action="{$self}" method="post">
				{if $formFile}
				<input type="hidden" name="MAX_FILE_SIZE" value="1000000">
				{/if}
				{if $smarty.get.module eq "projects"}
				<input type="hidden" name="toggletype" value="">
				{/if}
				{foreach name=hidden key=name item=value from=$hidden}
				<input type="hidden" name="{$name}" value="{$value}" />
				{/foreach}
			{/if}
			{if ($pageTitle neq "") || $search || $view || $form }
				{if $pageTitle neq ""}
				<table id="bodyheader"><tr><td class="headingTitle">{$pageTitle}</td><td class="headingEdit">{if $oppToProject}<a href="{$serverRoot}/?{$session}&amp;module=projects&amp;action=saveproject&amp;opportunityid={$smarty.get.id}">Convert to Project</a> {/if}{if $pageDelete neq ""}<a href="#" onclick="var confirmDelete=confirm('{t}Are you sure you want to proceed? This action cannot be undone.{/t}'); if (confirmDelete) window.location='{$serverRoot}/?{$session}&amp;module={$module}&amp;{$pageDelete}';">{t}Delete{/t}</a> | {/if}{if $pageUpdateAccess neq ""}<a href="{$serverRoot}/?{$session}&amp;module={$module}&amp;{$pageUpdateAccess}">{t}Update Access{/t}</a> | {/if}{if $pageEdit neq ""}<a href="{$serverRoot}/?{$session}&amp;module={$module}&amp;{$pageEdit}">{t}Edit{/t}</a>{/if}{if $pageNew neq ""}<a href="{$serverRoot}/?{$session}&amp;module={$module}&amp;{$pageNew}">{t}New{/t}</a>{/if}</td></tr><tr><td colspan="2">{/if}
				<table id="mainbody" cellspacing="0" cellpadding="0">
				{if $search && ($hideSearch neq true)}
					{include file="includes/search.tpl"}
				{/if}
				
				{if $headings neq ""}
					{include file="includes/overview.tpl"}
				{/if}
			
				{if $view} 
	                {include file="includes/view.tpl"}
                {/if}
				{if $form}
					{include file="includes/save.tpl"}
				{/if}
				</table>
				</td></tr></table>
				{/if}
				{if $form || $search}
						</form>
				{/if}
		</td>
	</tr>
</table>

</body>
</html>
