<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	{if $redirect}
	<meta http-equiv="refresh" content="3;url={$serverRoot}/?{$session}&amp;module={$module}&amp;{$redirectAction}" />
	{/if}
	<title>Enterprise Groupware System</title>
    <meta name="keywords" content="Groupware, ERP, Project Management" />
    <meta name="description" content="Enterprise Groupware System - built by Senokian Solutions Ltd - http://www.senokian.com" />
	<link rel="stylesheet" href="{$serverRoot}/themes/{$theme}/newstyle.css" type="text/css" />
	<link rel="stylesheet" type="text/css" media="all" href="{$serverRoot}/themes/{$theme}/js/jscalendar/skins/aqua/theme.css" title="Aqua" />
	<script type="text/javascript">
	{*this bit is here so that the AJAX calls know where to find the PHP scripts and they can pass on a session *}
		window.onload = function()
		{literal}{{/literal}
			serverroot = '{$serverRoot}';
			sessionid = '{$session}';
			img='<img src="'+serverroot+'/src/ajax/searching.gif" />';
		{literal}}{/literal}
	</script>

	<script type="text/javascript" src="{$serverRoot}/themes/{$theme}/js/jscalendar/calendar.js"></script>
	<script type="text/javascript" src="{$serverRoot}/themes/{$theme}/js/jscalendar/lang/calendar-en.js"></script>
	<script type="text/javascript" src="{$serverRoot}/themes/{$theme}/js/jscalendar/calendar-setup.js"></script>

	<script type='text/javascript' src="{$serverRoot}/src/ajax/dropdowns.js"></script>
	<script src="{$serverRoot}/src/ajax/prototype.js" type="text/javascript"></script>
	<script src="{$serverRoot}/src/ajax/scriptaculous.js" type="text/javascript"></script>
	

	{if $module eq "home"}<!--<script type="text/javascript" src="{$serverRoot}/modules/calendar/functions/event.js"></script>-->{/if}
	{if $module eq 'projects' && $smarty.get.action eq 'view'}
	<script type='text/javascript' src="{$serverRoot}/modules/projects/editing.js"></script>
	{/if}
	{if $showCurrentTask}
	<script type='text/javascript' src="{$serverRoot}/modules/projects/projectselect.js"></script>
	{/if}
	
	
	

	


	{if $redirect}
	<script type="text/javascript">
	{literal}
	<!--
	function delayer(){
	document.location = "{/literal}{$serverRoot}/?{$session}&module={$module}&{$redirectAction|replace:"amp;":""}{literal}"
	}
	//-->{/literal}
	</script>
	{/if}
	{if $module eq 'home'}
	{literal}
	<script type="text/javascript">
	<!--
	
	function openEventWindow(num) {
		// populate the hidden form
		
		var data = document.popup_data[num];
		var form = document.forms.eventPopupForm;
		form.elements.date.value = data.date;
		form.elements.time.value = data.time;
		form.elements.uid.value = data.uid;
		
		// open a new window
		var w = window.open('', 'Popup', 'scrollbars=yes,width=460,height=275');
		form.target = 'Popup';
		form.submit();
	}
	
	function EventData(date, time, uid) {
		this.date = date;
		this.time = time;
		this.uid = uid;
	}
	
	function openTodoInfo(vtodo_array) {	
		var windowW = 460;
		var windowH = 275;
		var url = '{/literal}{$serverRoot}{literal}/modules/calendar/includes/todo.php?vtodo_array='+vtodo_array;
		options = 'scrollbars=yes,width='+windowW+',height='+windowH;
		info = window.open(url, 'Popup', options);
		info.focus();
	}
	
	document.popup_data = new Array();
	//-->
	</script>
	{/literal}{/if}
	{literal}
	<script type="text/javascript">
	
	
	<!--//<![CDATA
	
	function confirmSubmit(message) {
	 var confirmed = confirm(message);
	
	 if(document.getElementById && confirmed) {
	   document.getElementById('multipledelete').submit();
	 }
	 else if(confirmed) {
	   document.all('multipledelete').submit();
	 }
	}
	{/literal}
	{if ($smarty.get.module eq "projects") && (($smarty.get.action eq "") || ($smarty.get.action eq "overview"))}
	{literal}
	function confirmToggle(message, type) {
	 var confirmed = confirm(message);
	
	 if(document.getElementById && confirmed) {
	   document.saveform.toggletype.value = type;
	   document.getElementById('multipledelete').submit();
	 }
	 else if(confirmed) {
	   document.all('multipledelete').submit();
	 }
	}
	{/literal}
	{/if}
	{literal}
	function CheckAllDelete() {
	 if(document.getElementById) {
	  for (var i = 0; i < document.getElementById('multipledelete').elements.length; i++) {
	    if(document.getElementById('multipledelete').elements[i].type == 'checkbox'){
	      document.getElementById('multipledelete').elements[i].checked =         !(document.getElementById('multipledelete').elements[i].checked);
	    }
	  }
	 }
	 else {
	  for (var i = 0; i < document.all('multipledelete').elements.length; i++) {
	    if(document.all('multipledelete').elements[i].type == 'checkbox'){
	      document.all('multipledelete').elements[i].checked =         !(document.all('multipledelete').elements[i].checked);
	    }
	  }
	 }
	}
	
	//]]-->
	{/literal}
	</script>
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
	<tr>
		<td class="logo" rowspan="4"><img src="{$serverRoot}/themes/{$theme}/graphics/{$module}.gif" alt="Logo" /></td>
		<td class="senokian"><a href="http://www.senokian.com/">Senokian Solutions Present</a></td>
		<td class="prefs">{if $module neq "admin" and $module neq "systemadmin"}	<a href="{$serverRoot}?{$session}&amp;module={$module}&amp;action={if $module eq "calendar"}calendar{/if}preferences">Module Preferences</a> |{/if}{if $module eq "contacts" || $module eq "projects" || $module eq "ticketing"} 	<a href="{$serverRoot}?{$session}&amp;module={$module}&amp;action=setup">{t}Module Setup{/t}</a> | {/if}	<a href="{$serverRoot}?{$session}&amp;module=home&amp;action=userdetails">{t}My Account{/t}</a>{if $admin}	| <a href="{$serverRoot}?{$session}&amp;module=admin">{t}Admin{/t}</a> {/if}{if $systemAdmin} 	|   <a href="{$serverRoot}?{$session}&amp;module=systemadmin">{t}System Admin{/t}</a> {/if}					|	<a href="{$serverRoot}?{$session}&amp;module=logout">{t}Logout{/t} ({$username})</a></td>
	</tr>
	<tr>
		<td class="title" colspan="2"><p><a href="http://www.enterprisegroupwaresystem.org/">EGS Enterprise Groupware System</a></p></td>
	</tr>
	<tr>
		<td colspan="2" class="modules">
			{section name=module loop=$modules}
			<a {if $modules[module].name eq $module}{assign var="moduleName" value=$modules[module].translated}class="on"{/if} href="{$serverRoot}?{$session}&amp;module={$modules[module].name}">{$modules[module].translated}</a>
			{assign var="currentModule" value=$modules[module].name}
			{/section}
		</td>
	</tr>
	<tr>
		<td colspan="2" class="options">{foreach name=submenu key=key item=item from=$subModules[$module]}<a href="{$serverRoot}?{$session}&amp;module={$module}{if $item neq ""}&amp;{$item}{/if}">{$key}</a>{foreachelse}&nbsp;{/foreach}</td>
	</tr>
	<tr>
		<td class="sub">
		{if $crossAssigned neq ""}
				<form id="xassignform" action="{$self}" method="POST" name="ca" id="ca"><p><b>{t}Current Company{/t}</b><br /><select onchange='return document.ca.submit()' name="assignedCompany" class="currentcompany">{html_options options=$crossAssigned selected=$currentCompany}</select></p></form>{/if}
			{foreach name=submenu key=key item=item from=$subModules[$module]}{if $smarty.foreach.submenu.first}<p><b>{$moduleName} {t}Options{/t}</b><br />{/if}<a href="{$serverRoot}?{$session}&amp;module={$module}{if $item neq ""}&amp;{$item}{/if}">{$key}</a><br />{if $smarty.foreach.submenu.last}</p>{/if}{/foreach}
			<p><b>{t}Last Viewed{/t}</b><br />{foreach name=lastviewed key=link item=type from=$smarty.session.preferences.lastViewed}<img width="8" height="8" src="{$serverRoot}/themes/{$theme}/graphics/{$type.0}.gif" alt="{$type.0}" /> <a href="{$serverRoot}/?{$session}&amp;{$link}">{$type.1|truncate:20:"..."}</a>{if !$smarty.foreach.lastview.last}<br/>{/if}{/foreach}</p>
				{if $smarty.get.action eq "setup"}
				<form action="./?{$session}&amp;module={$module}&amp;action=setup" method="POST" name="setupcat" id="setupcat"><p><b>{t}Category{/t}</b><br /><select onchange='return document.setupcat.submit()' name="category">{html_options options=$setupCat selected=$currentCat}</select></p>	</form>
				{/if}
				{if $showHours eq 'true'}
				<div id="project-hours" style="width:145px;">
				<form action="{$self}" method="POST" name="ct" id="ct">
					<input type="hidden" name="ticketid" value="{$currentticketID}" />
					<input type="hidden" name="projectid" value="{$currentprojectID}" />
					<input type="hidden" name="taskid" value="{$currentTaskID}" />					
					<p><b>{t}Currently Working On{/t}</b><br /><a href="{$serverRoot}/?{$session}&amp;module={if $currentticketID neq ''}tickets{else}projects{/if}&amp;action={$currentType}{if $currentType eq "viewtask"}&amp;projectid={$currentprojectID}&amp;taskid={else}&amp;id={/if}{$currentTaskID}">{$currentTask}</a>
					<br />
					<div id="projectchoices"> </div>
					<input id="projectinput" type="text" autocomplete="off" /><br />
					
					
					<select id="taskSelect" class="secondselect" readonly="readonly" disabled="disabled" name="currentTask" style="width:100%;">
					<option id="taskholder" value="">{t}Choose a Project first:{/t}</option>
					</select><br />
					{t}For{/t}: <input class="timefield" autocomplete="off" type="text" name="currentHours" id="currentHours" value="{$currentHours}" /> : <input class="timefield" autocomplete="off" type="text" name="currentMinutes" id="currentMinutes" value="{$currentMinutes}" />
					<br />
					
					<input class="submit" type="submit" name="currentTaskSubmit" id="currentTaskSubmit" value="{t}Save & Change To{/t}"/>
					</p>
				</form>
				
				</div>
				<script type="text/javascript">
				{literal}
				new Ajax.Autocompleter("projectinput", "projectchoices", "{/literal}{$serverRoot}{literal}/src/ajax/projects.php",
										 {
										 paramName: "value",
										 afterUpdateElement:function(input,selected) {
										 	schooseProject(selected.id);
										 	}
										 
										 });

				Droppables.add('project-hours',{
												hoverclass:'project-on-hover',
												accept:'dragg-project',
												onDrop:function(element) {
													schooseProject(element.id.split('-')[1]);
													ID('projectinput').value=element.innerHTML.split('-')[element.innerHTML.split('-').length-1].replace(/^\s*|\s*$/g,"");

												}
													
								});

				{/literal}
				</script>
				{/if}
				
				
				{if $projectReports}
					<form id="reportsform" action="{$serverRoot}/?{$session}&amp;module=projects&amp;action=projectreports" method="post">
					<p><b>{t}Run Project Reports{/t}</b><br />
					<select name="reporttype"><option value="jobsheet">{t}Job Sheet{/t}</option><option value="payroll">{t}Payroll{/t}</option><option value="timesheet">{t}Timesheets{/t}</option><option value="weekhours">{t}Weekly Hours{/t}</option></select><br />
					<select name="projectid">{html_options options=$projects}</select><br />
					<select name="username">{html_options options=$users}</select><br />
					<input type="hidden" name="reportdate" id="reportdate" value="" /><input type="text" class="date" readonly name="reportdateoutput" id="reportdateoutput" value="" /><input type="image" src="{$serverRoot}/themes/{$theme}/graphics/date.jpg" id="reportdatedate" value="{t}Choose Date{/t}" /><br />
					<input class="submit" type="submit" name="projectreport" value="{t}Run Report{/t}" /></p>
{literal}<script type="text/javascript">
  Calendar.setup(
    {
      inputField  : "reportdate",         // ID of the input field
      displayArea : "reportdateoutput",
      ifFormat    : "%Y-%m-%d",    // the date format
      daFormat    : "{/literal}{$dateFormat}{literal}",
      button      : "reportdatedate"       // ID of the button
    }
  );
</script>{/literal}
							</form>
					{/if}
		</td>
		<td colspan="2" class="body">
		<div id="testingbox"></div>
			{foreach name=errors item=error from=$errors}
					{if $smarty.foreach.errors.first}
					<table id="errors" cellspacing="0" cellpadding="0">
						<thead><tr><td>{t}You have the following errors, please correct before proceeding again:{/t}</td></tr></thead>
						<tbody><tr><td><ul>
					{/if}
					<li>{$error}</li>
					{if $smarty.foreach.errors.last}
						</ul></td></tr></tbody>
					</table>
					{/if}
				{/foreach}
				{foreach name=messages item=message from=$messages}
					{if $smarty.foreach.messages.first}
					<table id="messages" cellspacing="0" cellpadding="0">
						<thead><tr><td>{t}Success{/t}</td></tr></thead>
						<tbody><tr><td><ul>
					{/if}
					<li>{$message}</li>
					{if $smarty.foreach.messages.last}
						</ul></td></tr></tbody>
					</table>
					{/if}
				{/foreach}
			{if $homePage}
			<table class="welcome" cellspacing="0">
					<tr>
						<td>{t}Welcome to EGS{/t} {$personName}</td>
						<td class="right">{$todaysDate}</td>
					</tr>
			</table>
									
							<table cellpadding="0" cellspacing="0" style="padding:0px;margin:0px;"><tr><td>
							<div id="home-div" style="padding:0px;text-align:left;width:100%;height:100%;">

							{foreach name=homeorder item=item key=key from=$homeOrdering}
							<div id="dragg_{$item}" class="dragg" style="float:left;">

							<span id="close-{$item}"><a href="#" onclick="javascript:removeItem('{$item}');return false">X</a></span><span id="{$item}_handle" class="dragg-handle"></span>

							{if $item eq "motd"}
							
							<table id="motdit" class="item" cellspacing="0">
								<tr>
									<td class="header">{t}Message of the Day{/t}</td>
								</tr>
								<tr>
									<td class="item">{$motd}</td>
								</tr>
							</table>
							<script type="text/javascript">
							ID('close-motd').innerHTML="&nbsp;";
							</script>
							{elseif $item eq 'blank'}
							<div style="clear: both;display:block;height:100px;">&nbsp;</div>
							
							{elseif $showOpportunities && $item eq "opportunities"}
							<table class="item" cellspacing="0">
								<tr>
									<td class="header">{t}Current Opportunities{/t}</td>
								</tr>
								<tr>
									<td class="item">
										<table cellpadding="0" cellspacing="0" class="opps">
										<thead>
										<tr>
											<td>{t}Name{/t}</td>
											<td>{t}Account{/t}</td>
											<td>{t}Cost{/t}</td>
											<td>{t}Due Date{/t}</td>
										</tr>
										</thead>
										<tbody>
										{foreach name=opportunities key=opportunitiesid item=opportunitiesitem from=$opportunities}
										<tr>
											<td><a href="{$serverRoot}?{$session}&amp;module=contacts&amp;action=viewopportunity&amp;id={$opportunitiesid}">{$opportunitiesitem.name}</a></td>
											<td>{if $opportunitiesitem.companyname neq ""}<a href="{$serverRoot}?{$session}&amp;module=contacts&amp;action=view&amp;id={$opportunitiesitem.companyid}">{$opportunitiesitem.companyname}</a>{else}&nbsp;{/if}</td>
											<td>{$opportunitiesitem.cost}</td>
											<td>{$opportunitiesitem.enddate}</td>
										</tr>
										{foreachelse}<tr><td colspan="4"><p>{t}No Opportunities{/t}</p></td></tr>{/foreach}
										</tbody>
									</table>
									</td>
								</tr>
							</table>
							{elseif $item eq 'activities' && $showActivities}
							<table class="item" cellspacing="0">
								<tr>
									<td class="header">{t}Current Activities{/t}</td>
								</tr>
								<tr>
									<td class="item">
										<table cellpadding="0" cellspacing="0" class="opps">
										<thead>
										<tr>
											<td class="iconsmall">&nbsp;</td>
											<td>{t}Name{/t}</td>
											<td>{t}Type{/t}</td>
											<td>{t}Start Date{/t}</td>
											<td>{t}Due Date{/t}</td>
										</tr>
										</thead>
										<tbody>
										{foreach name=activities key=activitiesid item=activitiesitem from=$activities}
										<tr>
											<td class="iconsmall"><a class="img" onclick="confirm('{t}Are you sure you wish to complete this activity{/t}');" href="{$serverRoot}?{$session}&amp;module=home&amp;do=completeactivity&amp;id={$activitiesid}"><img src="{$serverRoot}/themes/{$theme}/graphics/completetodo.gif" /></a></td>
											<td><a href="{$serverRoot}?{$session}&amp;module=contacts&amp;action=viewactivity&amp;id={$activitiesid}">{$activitiesitem.name}</a></td>
											<td>{$activitiesitem.activity|default:"-"}</td>
											<td>{$activitiesitem.startdate}</td>
											<td class="noborder">{$activitiesitem.enddate}</td>
										{foreachelse}<tr><td colspan="5"><p>{t}No Activities{/t}</p></td></tr>{/foreach}
										</tbody>
									</table>
									</td>
								</tr>
							</table>
							{elseif $item eq 'open_tickets' && $showOpenTickets}
							<table class="item" cellspacing="0">
								<tr>
									<td class="header"><a href="{$serverRoot}?{$session}&amp;module=tickets">{t}Open Tickets{/t}</a></td>
								</tr>
								<tr>
									<td class="item"><ul>
									{foreach name=tickets key=ticketsid item=ticketsitem from=$tickets}
									<li id="ticket-t{$ticketsid}" class="dragg-project" {literal}onmousedown="new Effect.Highlight('project-hours',{startcolor:'#ffff44',endcolor:'#ffffff',restorecolor:'#ffffff#',duration:5.0})"{/literal}>
										<a href="{$serverRoot}?{$session}&amp;module=ticketing&amp;action=view&amp;id={$ticketsid}">
											{$ticketsitem.id}
										</a> - 
										{$ticketsitem.subject}
									</li>
									<script type="text/javascript">
										// <![CDATA[
										tid="ticket-t{$ticketsid}";
										{literal}
									   new Draggable(tid,{revert:true,ghosting:true});
									   {/literal}
									    
									 // ]]>
									</script>
									{foreachelse}
									<li>{t}No Open Tickets{/t}</li>
									{/foreach}</ul></td>
								</tr>
							</table>
							{elseif $item eq 'projects' && $showCurrentProjects}
							<table class="item" cellspacing="0">
								<tr>
									<td class="header"><a href="{$serverRoot}?{$session}&amp;module=projects">{t}Current Projects{/t}</a></td>
								</tr>
								<tr>
									<td class="item"><ul id ="project-list">
									{foreach name=projects key=projectsid item=projectsitem from=$projects}
									<li id="project-p{$projectsid}" class="dragg-project" {literal}onmousedown="new Effect.Highlight('project-hours',{startcolor:'#ffff44',endcolor:'#ffffff',restorecolor:'#ffffff#',duration:5.0})"{/literal}>
									<a href="{$serverRoot}?{$session}&amp;module=projects&amp;action=view&amp;id={$projectsid}">
										{$projectsitem.jobno}
									</a> -
										 {$projectsitem.name}
									</li>
									<script type="text/javascript">
										// <![CDATA[
										pid="project-p{$projectsid}";
										{literal}
									   new Draggable(pid,{revert:true,ghosting:true});
									   {/literal}
									    
									 // ]]>
									</script>
									{foreachelse}<li>{t}No Announcements{/t}</li>{/foreach}
									</ul></td>
								</tr>
							</table>


							{elseif $item eq 'pipeline' && $mypipeline}
							<table class="item" cellspacing="0">
								<tr>
									<td class="header">{t}My Pipeline{/t}</td>
								</tr>
								<tr>
									<td style="height:150px;" class="centre"><img style="padding:0px;margin:0px;" src="{$serverRoot}?{$session}&amp;module=crm&amp;action=graphs&amp;view=mypipeline" alt="{t}My Pipeline{/t}" /></td>
								</tr>
							</table>
							{elseif $item eq 'messages' && $showMessages}
							<table class="item" cellspacing="0">
								<tr>
									<td class="header">{t}Messages{/t}</td>
								</tr>
								<tr>
									<td class="item">
										{section name=userMessages loop=$userMessages}
										<p{if !$smarty.section.userMessages.first} class="startMessage"{/if}><b>{t}Message Taken By:{/t}</b> {$userMessages[userMessages].leftby} @ {$userMessages[userMessages].leftwhen}
										{if $userMessages[userMessages].personname neq ""}<br/><b>{t}Message Left By:{/t}</b> <a href="{$serverRoot}?{$session}&amp;module=contacts&amp;action=viewperson&amp;id={$userMessages[userMessages].personid}">{$userMessages[userMessages].personname}</a>{/if}</p>
										<p{if !$smarty.section.userMessages.last} class="finishMessage"{/if}>{$userMessages[userMessages].message} <a onclick="confirm('{t}Are you sure you want to delete this message?{/t}');" href="{$serverRoot}?{$session}&amp;module=home&amp;do=deletemessage&amp;id={$userMessages[userMessages].id}">{t}Delete{/t}</a></p>
										{sectionelse}
										{t}No Messages{/t}
										{/section}
									</td>
								</tr>
							</table>
							
						{elseif ($item eq 'events' && $showEvents) || ($item eq 'to_do' && $showTodos)}
							<table class="item" cellspacing="0">
								<tr>
									<td class="header">{t}Upcoming{/t} {if $showEvents}{t}Events{/t}{/if}{if $showTodos}{if $showEvents} /{/if} {t}Todos{/t}{/if}</td>
								</tr>
								<tr>
									<td class="item">
										{if $showEvents}
										{section name=events loop=$events}
										{if ($events[$smarty.section.events.index_prev].date neq $events[events].date) and ($futureEvents neq "done")}{if !$smarty.section.events.first}</ul>{/if}<b>{if $events[events].date eq "Today"}{t}Today's Events{/t}{elseif $events[events].date eq "Tomorrow"}Tomorrow's Events{else}{assign var="futureEvents" value="done"}{t}Future Events{/t}{/if}</b><ul>{/if}
										<li>{if ($events[events].date neq "Today") && ($events[events].date neq "Tomorrow")}{$events[events].date} {/if}{if $events[events].allday neq "yes"}{$events[events].start} - {$events[events].end} {/if}{$events[events].name|replace:"%27":"'"}{if $events[events].allday eq "yes"} ({t}All Day{/t}){/if}</li>
										{if $smarty.section.events.last}</ul>{/if}
										{sectionelse}<p>{t}No Current Events{/t}</p>{/section}
										{/if}
										{if $showTodos}
										{if $showEvents}
										<b>{t}Todos{/t}</b>
										{/if}
										<ul>
										{section name=todos loop=$todos}
											<li>{if $todos[todos].deadline neq ""}{$todos[todos].deadline} {/if}<a {if $todos[todos].priority eq "Urgent"} style="color:red;"{/if}href="{$todos[todos].link}">{$todos[todos].name}</a>{if $todos[todos].priority neq ""} ({$todos[todos].priority}){/if}</li>
										{sectionelse}<li>{t}No ToDo Items{/t}</li>{/section}
										</ul>
										{/if}
									</td>
								</tr>
							</table>
							{elseif ($item eq 'news' && $showNews) || ($item eq 'announcements' && $showAnnouncements)}
							<table class="item" cellspacing="0">
								<tr>
									<td class="header">{if $showNews}<a href="{$serverRoot}?{$session}&amp;module=home&amp;action=news">{t}News{/t}</a>{/if}{if $showAnnouncements}{if $showNews} / {/if}<a href="{$serverRoot}?{$session}&amp;module=home&amp;action=announcements">{t}Announcements{/t}</a>{/if}</td>
								</tr>
								<tr>
									<td class="item">
										{if $showNews}{if $showAnnouncements}<b>{t}News{/t}</b>{/if}<ul>{foreach name=news key=newsid item=newsitem from=$news}<li>({$newsitem.published}) <a href="{$serverRoot}?{$session}&amp;module=home&amp;action=viewnews&amp;id={$newsid}">{$newsitem.headline}</a></li>{foreachelse}<li>{t}No News Items{/t}</li>{/foreach}</ul>{/if}
										{if $showAnnouncements}{if $showNews}<b>{t}Announcements{/t}</b>{/if}<ul>{foreach name=announcements key=announcementsid item=announcementsitem from=$announcements}<li>({$announcementsitem.published}) <a href="{$serverRoot}?{$session}&amp;module=home&amp;action=viewannouncements&amp;id={$announcementsid}">{$announcementsitem.headline}</a></li>{foreachelse}<li>{t}No Announcements{/t}</li>{/foreach}</ul>{/if}
									</td>
								</tr>
							</table>

							{elseif $item eq 'domains' && $showDomains}
							<table class="item" cellspacing="0">
								<tr>
									<td class="header">{t}Domains Expiring Soon{/t}</td>
								</tr>
								<tr>
									<td class="item">
										<ul>
											{foreach name=domains key=domainsid item=domainsitem from=$domains}
											<li>({$domainsitem.expires}) <a class="{$domainsitem.when}" href="{$serverRoot}?{$session}&amp;module=domain&amp;action=view&amp;id={$domainsid}">{$domainsitem.name}</a></li>
								
											{foreachelse}<li>{t}No Domains Expiring within 30 Days{/t}</li>{/foreach}
										</ul>
									</td>
								</tr>
							</table>

							{/if}
							</div>
							{/foreach}
							</div>
			</td></tr></table>					
			{literal}
							<script type="text/javascript" language="javascript">
 // <![CDATA[
   Sortable.create("home-div",
     {
     tag:'div',overlap:'horizontal',constraint: false, handle:'dragg-handle',onUpdate:function(){
     poststring = Sortable.serialize('home-div');
     setHomeOrder(poststring);
     new Effect.Highlight('home-div',{startcolor:'#ffffdd', endcolor:'#ffffff',restorecolor:'#ffffff'});
     }
    	})
    
 // ]]>
 </script>{/literal}

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
				{if $pageTitle neq ""}<table id="bodyheader"><tr><td class="headingTitle">{$pageTitle}</td><td class="headingEdit">{if $oppToProject}<a href="{$serverRoot}/?{$session}&amp;module=projects&amp;action=saveproject&amp;opportunityid={$smarty.get.id}">Convert to Project</a> {/if}{if $pageDelete neq ""}<a href="#" onclick="var confirmDelete=confirm('{t}Are you sure you want to proceed? This action cannot be undone.{/t}'); if (confirmDelete) window.location='{$serverRoot}/?{$session}&amp;module={$module}&amp;{$pageDelete}';">{t}Delete{/t}</a> | {/if}{if $pageUpdateAccess neq ""}<a href="{$serverRoot}/?{$session}&amp;module={$module}&amp;{$pageUpdateAccess}">{t}Update Access{/t}</a> | {/if}{if $pageEdit neq ""}<a href="{$serverRoot}/?{$session}&amp;module={$module}&amp;{$pageEdit}">{t}Edit{/t}</a>{/if}{if $pageNew neq ""}<a href="{$serverRoot}/?{$session}&amp;module={$module}&amp;{$pageNew}">{t}New{/t}</a>{/if}</td></tr><tr><td colspan="2">{/if}
				<table id="mainbody" cellspacing="0" cellpadding="0">
				{if $search && ($hideSearch neq true)}
					<tr><td {if $pageNew neq ""} colspan="2" {/if}class="search">
						<table class="search" cellpadding="0" cellspacing="0">
							<thead><tr><td class="searchheading" colspan="2">{$searchTitle}</td><td class="searchswitch">{if !$hideAdvancedSearch}{if $searchForm eq "adv"}<a href="{$self|replace:"&amp;search=adv":""}&amp;search=norm">{t}Normal{/t}</a> | <b>{t}Advanced{/t}</b>{else}<b>{t}Normal{/t}</b> | <a href="{$self|replace:"&amp;search=norm":""}&amp;search=adv">Advanced</a>{/if}{else}&nbsp;{/if}</td></tr></thead>
							<tbody>
					{foreach name=search key=key item=item from=$search}
						{if $smarty.foreach.search.first}<tr>{/if}
						{if $item.type eq "text"}<td>{$item.name}<br /><input type="text" value="{$smarty.session.search.$key}" name="{$key}" /></td>
						{elseif $item.type eq "checkbox"}<td>{$item.name}<br /><input type="checkbox" value="{$item.value}" name="{$key}" {if $item.checked}checked="checked" {/if}/></td>
						{elseif $item.type eq "select"}<td>{$item.name}<br /><select name="{$key}">{foreach key=selectkey item=selectitem from=$item.values}<option value="{$selectitem}" {if $selectitem eq $smarty.session.search.$key}selected="selected"{/if}>{$selectkey}</option>{/foreach}</select></td>{/if}
						{if ($smarty.foreach.search.iteration%3 eq 0) && !$smarty.foreach.search.last}</tr><tr>
						{elseif $smarty.foreach.search.last}</tr>{/if}
					{/foreach}
							<tr><td colspan="3"><input class="button" type="submit" name="search" value="{t}Search{/t}" />{if !$hideSaveSearch} <input class="button" type="submit" name="savesearch" value="{t}Save as Default and Search{/t}" />{/if} <input class="button" type="submit" name="clearsearch" value="{t}Clear Search{/t}" /></td></tr>
							</tbody>
						</table>
					</td>
				</tr>
				{/if}
				
				{if $headings neq ""}
				<tr>
				
				{if $setup}
				<table cellspacing="0" cellpadding="0"><tr><td>&nbsp;</td><td>
				{/if}
					<td {if $pageNew neq ""} colspan="2"{/if}>
						{if $smarty.get.action neq "labels" && !$setup}
						<table cellspacing="0" cellpadding="0" id="page">
							<tr>
								<td class="left"><a href="{$self}&amp;export=tab">{t}Export{/t}</a> | <a target="_new" href="{$self}&amp;print=true">{t}Print{/t}</a></td>
								{if $tree neq true}<td class="page">{if $firstPage}<a href="{$self}&amp;page=1">&lt;&lt; Start</a>{else}&lt;&lt; Start{/if} {if $backPage}<a href="{$self}&amp;page={$backPage}">&lt; Previous</a>{else}&lt; Previous{/if} <span>({$currentPage} of {$totalPages})</span> {if $nextPage}<a href="{$self}&amp;page={$nextPage}">Next &gt;</a>{else}Next &gt;{/if} {if $lastPage}<a href="{$self}&amp;page={$lastPage}">End &gt;&gt;</a>{else}End &gt;&gt;{/if}</td>{/if}
							</tr>
						</table>
						{elseif $smarty.get.action eq "labels"}
						<table cellspacing="0" cellpadding="0" id="page">
							<tr>
							<td class="left"><a href="#" onclick="javascript:CheckAllDelete(); return false;">{t}Toggle{/t}</a> | <a href="javascript:confirmSubmit('{t}Are you sure you want to print all these labels?{/t}');">{t}Print Labels{/t}</a></td>
							</tr>
						</table>
						{/if}
						<table cellspacing="0" cellpadding="0" id="overview">
							<thead>
								<tr>
									{if (!$hideToggle)}<td class="toggle">&nbsp;</td>{/if}
									{foreach name=headings key=headingOrder item=headingTitle from=$headings}<td {if $smarty.foreach.headings.iteration eq 2 && $smarty.get.action neq 'letteroverview'}width="100%"{/if}{if $headingOrder eq $smarty.session.order} class="ordered"{/if}>{if !$setup}<a href="?{$session}&amp;module={$smarty.get.module}{if $smarty.get.action neq ""}&amp;action={$smarty.get.action}{/if}&amp;order={$headingOrder}">{/if}{$headingTitle}{if !$setup}</a>{/if}</td>{/foreach}
								</tr>
							</thead>
							<tbody>
								{section name=rows loop=$rows}
								{cycle values="off,on" assign="rowbg"}
									<tr onmouseover="this.className='over'" onmouseout="this.className='{$rowbg}'" class="{$rowbg}">
									{if (!$hideToggle)}<td class="white"><input type="checkbox" name="delete[{$smarty.section.rows.iteration}]" value="{$rows[rows][0]}" /></td>{/if}
									{section name=data loop=$rows[rows]}{if !$smarty.section.data.first}<td class="{$rowbg}{if $smarty.section.rows.last}off{/if}" {if ($indent[rows] neq "0") && ($smarty.section.data.iteration eq 2)}style="padding-left: {$indent[rows]*20}px;" {/if}>{if ($action[rows] eq "+") && ($smarty.section.data.iteration eq 2)}<a href="{$myself}&show={$rows[rows][0]}">{$action[rows]}</a>&nbsp;{elseif ($action[rows] eq "-") && ($smarty.section.data.iteration eq 2)}<a href="{$myself}&hide={$rows[rows][0]}">{$action[rows]}</a>&nbsp;{elseif $tree  && ($smarty.section.data.iteration eq 2)}&nbsp;&nbsp;{/if}{if $smarty.section.data.iteration eq 2}{if $tree[rows][data] eq "+"}+{/if}<a href="{$serverRoot}/?{$session}&amp;module={$module}&amp;action={if $setup}{if $module eq "store"}{$smarty.get.action}{else}setup&amp;category={$currentCat}{/if}{else}{if $module neq 'admin' && $smarty.get.action neq 'templateoverview' && $forceSave neq true}view{else}save{/if}{$viewType}{/if}&amp;id={$rows[rows][0]}">{elseif ($actualLinks[rows][data] neq "") && ($rows[rows][data] neq "")}<a href="{$serverRoot}/?{$session}&amp;{$actualLinks[rows][data]}">{/if}{$rows[rows][data]|default:"&nbsp;"|regex_replace:"#(.*)\@(.*)\.(.*)#":"<a href=\"mailto:\\1@\\2.\\3\">\\1@\\2.\\3</a>"|regex_replace:"`((http)+(s)?:(//)|(www\.))((\w|\.|\-|_)+)(/)?(\S+)?`i":"<a href=\"http\\3://\\5\\6\\8\\9\" title=\"\\0\">\\5\\6</a>"}{if $smarty.section.data.iteration eq 2}</a>{elseif ($actualLinks[rows][data] neq "") && ($rows[rows][data] neq "")}</a>{/if}</td>{/if}{/section}
									</tr>
								{sectionelse}<td class="centre" colspan="{if (!$hideToggle)}{$smarty.foreach.headings.total+1}{else}{$smarty.foreach.headings.total}{/if}">{t}{if !$setup}The search critera you have entered returned no data{else}No items setup{/if}{/t}</td>{/section}
							</tbody>
						</table>
						<table cellspacing="0" cellpadding="0" id="pageFooter">
							<tr>{if $queue || $module eq "admin" && $smarty.get.action eq ''}{else}
								{if $smarty.get.action eq "labels"}
								<td class="left"><a href="#" onclick="javascript:CheckAllDelete(); return false;">{t}Toggle{/t}</a> | <a href="javascript:confirmSubmit('{t}Are you sure you want to print all these labels?{/t}');">{t}Print Labels{/t}</a></td>
								{else}
								{if $setup}<input type="hidden" name="category" value="{$currentCat}" />{/if}
								{if (!$hideToggle)}<td class="left"><a href="#" onclick="javascript:CheckAllDelete(); return false;">{t}Toggle{/t}</a>{/if}{if $module neq "home" && $smarty.get.module neq "projects" || $setup } | <a href="javascript:confirmSubmit('{t}Are you sure you want to proceed? This action cannot be undone.{/t}');">{t}Delete Selected{/t}</a>{/if}{if $smarty.get.module eq "projects" && !$setup}| <a href="javascript:confirmToggle('{t}Are you sure you wish to change the completed status?{/t}', 'completed');">{t}Completed{/t}</a> | <a href="javascript:confirmToggle('{t}Are you sure you wish to change the invoiced status?{/t}', 'invoiced');">{t}Invoiced{/t}</a> | <a href="javascript:confirmToggle('{t}Are you sure you wish to change the archived status?{/t}', 'archived');">{t}Archived{/t}</a>{/if}</td>
								{if $tree neq true}<td class="page">{if $firstPage}<a href="{$self}{if $setup && $smarty.get.category eq ''}&amp;category={$currentCat}{/if}&amp;page=1">&lt;&lt; Start</a>{else}&lt;&lt; Start{/if} {if $backPage}<a href="{$self}{if $setup && $smarty.get.category eq ''}&amp;category={$currentCat}{/if}&amp;page={$backPage}">&lt; Previous</a>{else}&lt; Previous{/if} <span>({$currentPage} of {$totalPages})</span> {if $nextPage}<a href="{$self}{if $setup && $smarty.get.category eq ''}&amp;category={$currentCat}{/if}&amp;page={$nextPage}">Next &gt;</a>{else}Next &gt;{/if} {if $lastPage}<a href="{$self}{if $setup && $smarty.get.category eq ''}&amp;category={$currentCat}{/if}&amp;page={$lastPage}">End &gt;&gt;</a>{else}End &gt;&gt;{/if}</td>{/if}

								{/if}
								{/if}
							</tr>
						</table>
							{if $setup}
							</td><td>&nbsp;</td><td class="setupedit">
								<table id="overview">
								<form action="{$self}" method="POST" name="editForm">
								<thead><tr><td class="ordered" colspan="3">{t}{$editSetupTitle}{/t}</td>{if $editnewlink}<td><a href="{$serverRoot}?{$session}&amp;module={$module}&amp;action={$smarty.get.action}">{t}New{/t}</a></td>{/if}</tr></thead>	
										<tbody>
										{section name=editForm loop=$editForm}
											{if $editForm[editForm].type eq "text"}
											<tr><td><label for="{$editForm[editForm].name}"><b>{$editForm[editForm].tag}</b></label></td>
											<td><input class="editform" {if $editForm[editForm].readonly}readonly="readonly"{/if} type="text" id="{$editForm[editForm].name}" name="{$editForm[editForm].name}" value="{$editForm[editForm].value}" /></td></tr>
											{/if}
											{if $editForm[editForm].type eq "select" || $editForm[editForm].type eq "multiple"}
											<tr><td><label for="{$editForm[editForm].name}"><b>{$editForm[editForm].tag}</b></label></td>
											<td><select class="editform"  name="{$editForm[editForm].name}"{if $editForm[editForm].type eq "multiple"}multiple="multiple" class="multiple"{/if}>{html_options options=$editForm[editForm].options selected=$editForm[editForm].value}</select></td>
											</tr>
											{/if}
											{if $editForm[editForm].type eq "textarea"}
											<tr>
											<td><label for="{$editForm[editForm].name}"><b>{$editForm[editForm].tag}</b></label></td>
											<td><textarea "class="small" id="{$editForm[editForm].name}" name="{$editForm[editForm].name}">{$editForm[editForm].value}</textarea></td>
											<td>&nbsp;</td></tr>
											{/if}
											{if $editForm[editForm].type eq "title"}
											<tr><td colspan="3" class="editSubTitle">{$editForm[editForm].tag}</td></tr>
											{/if}
											{if $editForm[editForm].type eq "checkbox"}
											<td><label for="{$editForm[editForm].name}"><b>{$editForm[editForm].tag}</b></label></td>
											<td><input class="checkbox" type="checkbox" name="{$editForm[editForm].name}" {if $editForm[editForm].value eq "checked"}checked="checked"{/if} /></td>
											{/if}
											{if $editForm[editForm].type eq "subform"}
												<tr><td></td><td><table><tr>
												{foreach name=headings key=key item=item from=$editForm[editForm].headings}
													<td>{$item}</td>{if $item eq "Details"}<td>&nbsp;</td>{/if}
												{/foreach}
												
												<td>{t}Delete{/t}</td>
												</tr>
												{foreach name=rows key=key item=row from=$editForm[editForm].rows}
												<tr>
													{foreach name=values key=key2 item=value from=$row}
													{if $key2 eq "valueid"}{assign var="deleteid" value=$value}{/if}
													<td style="width:35px;"><input style="width: {if $key2 eq "valuevieworder"}20{else}70{/if}px; padding:0px;margin:0px;" type="{if $smarty.foreach.values.first}hidden{else}text{/if}" name="{$key2}[]" value="{$value}" />
													{if $key2 eq "valuedetails"}</td><td width="20px">{if $value|truncate:1:"":true eq "#"}<input type="text" readonly="readonly" style="width:10px; background-color:{$value|truncate:7:"":true|strip_tags}" />{else}&nbsp;{/if}{/if}
													</td>
													
													{/foreach}
													<td>
													<input type="checkbox" name="valuedelete[{$deleteid}]" />
													</td>
												</tr>	
												{/foreach}
												</table></td></tr>
											{/if}
										{/section}
										<tr>
											
										{if !$queue || $smarty.get.id neq ''}<td colspan="4"><input type="submit" name="editSetup" value="{t}Save{/t}" class="editbutton"/></td>{/if}
										</tr>
										</tbody>
				</form>
								</table>
							</td></tr></table>
							{/if}
					</td><td>&nbsp;</td>
				</tr>
				{/if}
			
				{if $view} 
                                <tr>
                                        <td colspan="2">
						<table cellspacing="0" cellpadding="0" id="viewcase">
							<tr>
								<td class="leftcol">
												{if ($leftData neq "") || ($rightData neq "")}
                                                <table cellspacing="0" cellpadding="0" class="view">
                                                        {foreach name=view key=key item=left from=$leftData}
														{assign var="right" value=$rightData[$key]}
														{if $left.fulltitle}
														</table>
														<table cellspacing="0" cellpadding="0" class="viewTitle{$left.pad}">
															<tr>
																<td>{$left.tag}</td>
															</tr>
														</table>
														<table cellspacing="0" cellpadding="0" class="view">
														{else}
														<tr>
															{if $left.span}
															<td class="left">&nbsp;</td>
															<td>&nbsp;</td>
															{elseif $left.title}
															<td class="leftBold">{$left.tag}</td>
															<td>&nbsp;</td>
															{elseif $left.tag neq ""}
							                                                                <td class="left"{if $left.rowspan neq ""} rowspan="{$left.rowspan}"{/if}>{$left.tag|default:"&nbsp;"}</td>
							                                                                <td{if ($left.tag eq $added) || ($left.tag eq $lastUpdated)} class="nonbold" {/if}{if $left.rowspan neq ""} rowspan="{$left.rowspan}"{/if}{if $left.colspan neq ""} colspan="{$left.colspan}"{/if} {if $left.overdue eq "true"}class="overdue"{/if}>{if ($left.link neq "") && ($left.data neq "")}<a href="{$left.link}">{$left.data|default:"&nbsp;"}</a>{else}{$left.data|default:"&nbsp;"}{/if}</td>
															{/if}
															{if $right.span && ($left.colspan eq "")}
															<td class="left">&nbsp;</td>
															<td>&nbsp;</td>
															{elseif $right.title}
															<td class="leftBold">{$right.tag}</td>
															<td>&nbsp;</td>
															{elseif ($left.colspan eq "") && (($rightRowSpan eq "") || ($rightRowSpan < 1))}
															<td {if $right.rowspan neq ""}rowspan="{$right.rowspan}" {counter assign="rightRowSpan" direction="down" start=$right.rowspan}{/if}class="left">{$right.tag|default:"&nbsp;"}</td>
															<td {if $right.rowspan neq ""}rowspan="{$right.rowspan}"{/if}{if $right.overdue eq "true"}style="color: red;" class="overdue"{/if}>{if ($right.link neq "") && ($right.data neq "")}<a href="{$right.link}">{$right.data}</a>{else}{$right.data|default:"&nbsp;"}{/if}</td>
															{/if}
                                                        </tr>
                                                        {/if}
                                                        {/foreach}
                                                </table>
                                                {/if}
					{foreach name=viewbottom key=bottomkey item=data from=$bottomData}
						{if $data.type eq "display"}
							<table cellspacing="0" cellpadding="0" class="bottomData">{if $data.title neq ""}<tr><td class="header">{$data.title}</td></tr>{/if}<tr><td><div class="scroll">{$data.content}</div></td></tr></table>
						{elseif $data.type eq "displayreply"}
							<table cellspacing="0" cellpadding="0" class="bottomData"><tr><td><pre>{$data.content}</pre></td></tr></table>
						{elseif $data.type eq "addreply"}
							<form method="post" action="{$self}">						
							<table cellspacing="0" cellpadding="0" class="bottomTitle"><tr><td>{t}Add Reply{/t}</td><td id="normal" align="right">{t}Internal{/t} <input type="checkbox" name="internal" value="true" /></td></tr></table>
							<input type="hidden" name="ticketid" value="{$smarty.get.id}" />
							<table id="ticketreply" cellspacing="0" cellpadding="0" class="bottomData">
								<tr><td><textarea class="reply" name="body"></textarea></td></tr>
							</table>
							<input type="submit" name="submit" value="{t}Add Reply{/t}" class="button" />
						{elseif $data.type eq "reply"}
							<table cellspacing="0" cellpadding="0" class="bottomData">
								<tr><td class="title">{if $data.hide}<a href="{$self}&amp;hide={$data.id}">-</a>{else}<a href="{$self}&amp;show={$data.id}">+</a>{/if} {$data.header}</td></tr>
							{if $data.body neq ""}
								<tr><td class="body"><pre>{$data.body}</pre></td></tr>
							{/if}
							</table>
						{elseif $data.type eq "contact"}
						<form name="contactsform" id="contactsform" action="{$self}" method="post">
						<input type="hidden" name="{if $smarty.get.action eq "viewperson"}person{else}company{/if}id" value="{$smarty.get.id}" />
						<table cellspacing="0" cellpadding="0" class="bottomTitle">
							<tr>
								<td class="header">{t}Additional Contacts:{/t} <select onchange='return window.open("index.php?{$session}&amp;module={$module}&amp;action={$smarty.get.action}&amp;id={$smarty.get.id}&amp;type=" + document.contactsform.type.value, "_parent");' name="type">{html_options options=$data.options selected=$data.title}</select></td>
								<td class="right">{if $data.newlink neq ""}<a href="{$serverRoot}?{$session}&amp;module={$module}&amp;{$data.newlink}">{if $data.newlinktext neq ""}{$data.newlinktext}{else}{t}New{/t}{/if}</a>{else}&nbsp;{/if}{if $data.newlink2 neq ""} | <a href="{$serverRoot}?{$session}&amp;module={$module}&amp;{$data.newlink2}">{if $data.newlinktext2 neq ""}{$data.newlinktext2}{else}{t}New{/t}{/if}</a>{else}&nbsp;{/if}</td>
							</tr>
							<tr>
								<td colspan="2">
						<table cellspacing="0" cellpadding="0" class="bottomData">
							<tr>
								{foreach name=bottomheaders item=header from=$data.header}
								<td class="header{if $smarty.foreach.bottomheaders.iteration eq 2}stretched{/if}">{$header}</td>
								{/foreach}
							</tr>
							{foreach name=itemrow item=item from=$data.data}
							{cycle values="off,on" assign="rowbg"}	
							<tr onmouseover="this.className='over'" onmouseout="this.className='{$rowbg}'" class="{$rowbg}">
						 	{foreach key=key name=bottomdata item=itemdata from=$item}
								{assign var="indent" value=$smarty.foreach.itemrow.iteration-1}
								{if !$smarty.foreach.bottomdata.first && (($smarty.foreach.bottomdata.iteration < 4) || ($data.contacttype eq ""))}<td{if $smarty.foreach.bottomdata.iteration eq "2"} class="stretched"{/if}>{if $smarty.foreach.bottomdata.iteration eq 2 && $data.viewlink neq ""}<a href="{$serverRoot}?{$session}&amp;module={$module}&amp;{$data.viewlink}{$item.tag}">{/if}{if ($smarty.foreach.bottomdata.iteration >3) && ($itemdata eq "y")}{t}Yes{/t}{elseif ($smarty.foreach.bottomdata.iteration >3) && ($itemdata eq "n")}{t}No{/t}{else}{$itemdata}{/if}{if ($smarty.foreach.bottomdata.iteration eq 2) && ($data.viewlink neq "")}</a>{/if}</td>
								{elseif !$smarty.foreach.bottomdata.first}{assign var="contactindex" value=$smarty.foreach.bottomdata.iteration-4}<td class="centre"><input onchange='return document.contactsform.submit()' type="radio" name="type[{$data.contacttype.$contactindex}]" {if $itemdata eq "t"}checked="checked" {/if} value="{$item.tag}" /></td>
								{/if}
							{/foreach}	
							</tr>
							{foreachelse}
							<tr>
								<td class="centre" colspan="{$smarty.foreach.bottomheaders.total}">{t}None{/t}</td>
							</tr>
							{/foreach}
							{if $rowbg eq "off"}{cycle values="off,on" assign="rowbg"}{/if}
						</table>
						</td></tr></table>
						</form>
						{else}{* Just putting a comment here so I can find this place rabbit*}
						<table cellspacing="0" cellpadding="0" class="bottomTitle">
							<tr>
								<td class="header">{$data.title}</td>
								<td class="right">{if $data.newlink neq ""}<a href="{$serverRoot}?{$session}&amp;module={$module}&amp;{$data.newlink}">{if $data.newlinktext neq ""}{$data.newlinktext}{else}{t}New{/t}{/if}</a>{else}&nbsp;{/if}{if $data.newlink2 neq ""} | <a href="{$serverRoot}?{$session}&amp;module={$module}&amp;{$data.newlink2}">{if $data.newlinktext2 neq ""}{$data.newlinktext2}{else}{t}New{/t}{/if}</a>{else}&nbsp;{/if}</td>
							</tr>
							<tr><td colspan="2">{if $data.title eq "Tasks"}<form name="progressform" id="progressform" >{/if}
						<table cellspacing="0" cellpadding="0" class="bottomData">
							<tr>
								{foreach name=bottomheaders key=key item=header from=$data.header}
								<td class="header">{if $data.title eq "Hours" || $data.title eq "Tasks" || $data.title eq "Resources"}<a href="{$serverRoot}?{$session}&amp;module={$module}&amp;action={$smarty.get.action}&amp;id={$smarty.get.id}&amp;{if $data.title eq "Hours"}hour{elseif $data.title eq "Tasks"}task{elseif $data.title eq "Resources"}resource{/if}Order={$key}">{/if}{$header}{if $data.title eq "Hours"}</a>{/if}</td>
								{/foreach}
							</tr>
							{foreach name=itemrow item=item from=$data.data}
							{cycle values="off,on" assign="rowbg"}	
							<tr onmouseover="this.className='over'" onmouseout="this.className='{$rowbg}'" class="{$rowbg}">
						 	{foreach key=key name=bottomdata item=itemdata from=$item}

								{assign var="indent" value=$smarty.foreach.itemrow.iteration-1}
								{if !$smarty.foreach.bottomdata.first}<td class="row"{if ($data.indents[$indent] neq "") && ($smarty.foreach.bottomdata.iteration eq 2)} style="padding-left: {$data.indents[$indent]*20}px;"{/if}>{if ($data.pre[$indent].sign eq "+") && ($smarty.foreach.bottomdata.iteration eq 2)}<a class="expand" href="{$self}&amp;show{if $data.pre[$indent].suffix neq ""}{$data.pre[$indent].suffix}{/if}={$data.pre[$indent].link}">{$data.pre[$indent].sign}</a> {elseif ($data.pre[$indent].sign eq "-") && ($smarty.foreach.bottomdata.iteration eq 2)}<a class="expand" href="{$self}&amp;hide{if $data.pre[$indent].suffix neq ""}{$data.pre[$indent].suffix}{/if}={$data.pre[$indent].link}">{$data.pre[$indent].sign}</a>  {elseif ($data.pre[$indent].sign eq "") && ($smarty.foreach.bottomdata.iteration eq 2) && $data.signpad}<span class="hide">&nbsp;</span> {/if}{if $smarty.foreach.bottomdata.iteration eq 2 && $data.viewlink neq ""}<a href="{$serverRoot}?{$session}&amp;module={$module}&amp;{$data.viewlink}{$item.id}">{elseif $data.links[$smarty.foreach.bottomdata.iteration][$indent] neq ""}<a href="{$serverRoot}?{$session}&amp;module={$module}&amp;{$data.links[$smarty.foreach.bottomdata.iteration][$indent]}">{/if}
								{*meow
													
								
								*}
								{if $key eq "progress" && $data.pre[$indent].sign eq ""}
								<input type="text" onchange="javascript:updateProgress(this.id,this.value,'{$smarty.get.id}')" id="progress{$item.id}" name="progress[{$item.id}]" value="{$itemdata}" class="editable" size="2" maxlength="3"  />
								{else}{$itemdata}{/if}{if ($smarty.foreach.bottomdata.iteration eq 2) && ($data.viewlink neq "")}</a>{/if}{if $data.links[$smarty.foreach.bottomdata.iteration][$indent] neq ""}</a>{/if}</td>{/if}
							{/foreach}	
							</tr>
							{foreachelse}
							<tr>
								<td class="centre" colspan="{$smarty.foreach.bottomheaders.total}">{t}None{/t}</td>
							</tr>
							{/foreach}
							{if $rowbg eq "off"}{cycle values="off,on" assign="rowbg"}{/if}
						</table>{if $data.title eq "Tasks"}</form>{/if}
							</td></tr></table>
						{/if}
					{/foreach}
								</td>
								{if $rightSpan neq ""}
								<td class="right">
								{foreach name=viewright key=key item=right from=$rightSpan}
									{if $right.type eq "image"}
									<div id="viewimage">{if $right.editlink neq ""}<a href="{$self}{$right.editlink}">{/if}<img src="{$serverRoot}/image.php?{$session}&id={$right.id}&show={$right.show}" alt="" />{if $right.editlink neq ""}</a>{/if}</div>
									{elseif $right.type eq "file"}
									<form enctype="multipart/form-data" method="post" action="{$self|replace:"edit":"editdone"}">
									<input type="hidden" name="MAX_FILE_SIZE" value="1000000">
									<table cellspacing="0" cellpadding="0" class="rightData">
										<tr>
											<td class="title">{$right.title}</td>
											<td class="titleright">{if $right.delete neq ""}<input onmouseover="this.className='scrollsaveon'" onmouseout="this.className='scrollsave'" onclick="return confirm('{t}Are you sure you wish to delete this item?{/t}');" class="scrollsave" type="submit" name="delete" value="{t}Delete{/t}" /> {/if}<input onmouseover="this.className='scrollsaveon'" onmouseout="this.className='scrollsave'" class="scrollsave" type="submit" name="save" value="{t}Save{/t}" /></td>
										</tr>
										<tr>
											<td colspan="2" class="file">
											 	<input class="file" type="file" name="file" />	
											</td>
										</tr>
										{if !$right.hidenotes}
										<tr>
											<td colspan="2" class="filenotes">
											 	<textarea class="file" name="notes">{$right.notes}</textarea>
											</td>
										</tr>
										{/if}
									</table>
									</form>
									{elseif $right.save neq ""}
									<form method="post" action="{$self|replace:"edit":"editdone"}">
									<table cellspacing="0" cellpadding="0" class="rightData">
										<tr>
											<td class="title">{$right.title}</td>
											<td class="titleright">{if $right.delete neq ""}<input onclick="return confirm('{t}Are you sure you wish to delete this item?{/t}');" class="scrollsave" type="submit" name="delete" value="{t}Delete{/t}" /> {/if}<input class="scrollsave" type="submit" name="save" value="{t}Save{/t}" /></td>
										</tr>
										<tr>
											<td colspan="2" class="scroll">
												{if $right.saveType neq ""}
												<input type="text" name="save" value="{$right.saveValue}" id="scrollsave" /><input type="hidden" name="savetype" value="{$right.saveType}" />{if $right.hiddenName neq ""}<input type="hidden" name="{$right.hiddenName}" value="{$right.hiddenValue}" />{/if}
												{else}
												<select class="scroll" multiple="multiple" name="values[]">
													{html_options options=$right.values selected=$right.selected}
												</select>
												{/if}
											</td>
										</tr>
									</table>
									</form>
									{elseif $right.type eq "text"}
									<table cellspacing="0" cellpadding="0" class="rightData">
										<tr>
											<td class="title">{$right.title}</td>
										</tr>
										<tr>
											<td colspan="2" class="scroll">{if $right.text neq ""}{$right.text}{else}<p class="empty">{t}No Data Entered{/t}</p>{/if}</td>
										</tr>
									</table>
									{elseif $right.type eq "data"}
									<table cellspacing="0" cellpadding="0" class="rightData">
										<tr>
											<td class="title">{$right.title}</td>
											<td class="titleright">{if $right.new neq ""}<a href="{$serverRoot}/?{$session}&amp;module={$module}&amp;{$right.new}">{t}New{/t}</a>{/if}{if $right.newactual neq ""}<a href="{$serverRoot}/{$right.newactual}">{t}New{/t}</a>{/if}{if $right.edit neq ""} <a href="{$serverRoot}/?{$session}&amp;module={$module}&amp;{$right.edit}">{t}Edit{/t}</a>{/if}{if ($right.new eq "") and ($right.edit eq "") and ($right.newactual eq "")}&nbsp;{/if}</td>
										</tr>
										<tr>
											<td colspan="2" class="scroll">
												{foreach name=viewrightdata key=datakey item=data from=$right.data}
												<p>{if $right.start[$datakey] neq ""}{$right.start[$datakey]} - {/if}{if $right.actuallink[$datakey] neq ""}<a href="{$serverRoot}/modules/projects/?{$right.actuallink[$datakey]}">{/if}{if $right.link[$datakey] neq ""}<a href="{$serverRoot}/?{$session}&amp;{$right.link[$datakey]}">{/if}{$data}{if $right.link[$datakey] neq ""}</a>{/if}{if $right.actuallink[$datakey] neq ""}</a>{/if}<p>{if $right.extra[$datakey] neq ""}<p class="right">{$right.extra[$datakey]}</p>{/if}
												{foreachelse}
												<p class="empty">{t}None{/t}</p>
												{/foreach}
											</td>
										</tr>
									</table>
									{elseif $right.type eq "album"}
									<table cellspacing="0" cellpadding="0" class="rightData">
									<tr>
										<td class="title">{$right.title}</td>
									</tr>
									<tr>
										<td colspan="2" class="scroll" vertical-align="middle">
										<table id="album">
										<tr><td>{t}Image (click to view){/t}</td><td>{t}Order{/t}</td><td>{t}Delete{/t}</td></tr>
										<form enctype="multipart/form-data" name="albumform" id="albumform" method="POST" action="{$self}">
										{foreach name=viewrightdata key=datakey item=data from=$right.data}
										<td>
											<a href="#" onclick='return window.open("{$serverRoot}/modules/store/storeimage.php?{$session}&amp;id={$data.id}","image","width=600,height=400,resizable=1,scrollbars=1");'>
											{$data.text}
										</td>
										<td>
											<input type="text" style="border:1px solid black; width:20px;" name="albumorder[{$data.id}]" value="{$data.order}" />
										</td>
										<td>
											<input type="checkbox" name="albumdelete[{$data.id}]" />
										</td>
										</tr>
										{/foreach}
										<tr>
										<td><input type="file" name="newalbumimage"/></td>
										<td><input type="text" style="border:1px solid black; width:20px;" name="albumorder[0]" value="{$right.neworder}" /></td>
										<td>&nbsp;</td>
										</tr><tr>
										<td colspan="3"><input type="submit" name="savealbum" value="{t}Save{/t}" /></td>
										</tr></form>
										</table>
										</td>
									</tr>
									{elseif $right.type eq 'new'}
									
									<table cellspacing="0" cellpadding="0" class="rightData">
									<tr>
										<td class="title">{$right.title}</td>
									</tr>
									<tr>
									{foreach name=headings item=heading from=$right.headings}
										<td>{$heading}</td>
									{/foreach}
									<td>&nbsp;</td>
									</tr>
									<tr>
									{foreach name=headings item=heading key=key from=$right.headings}
									<td><input type="text" name="{$key}" /></td>
									{/foreach}
									<td>
									<input type="submit" name="edit" value="save" />
									</td>
									</tr>
									</table>
									
									{/if}
								{/foreach}
								</td>
								{/if}
							</tr>
						</table>
                                        </td>
                                </tr>
                                {/if}
				{if $form}
				<tr>
					<td>
						<table cellspacing="0" cellpadding="0" id="formsave">
							<tr>
								<td><input type="submit" name="save" value="{t}Save{/t}" class="button" />{if $formDelete} <input onclick="return confirm('{t}Are you sure you wish to delete this item?{/t}');" type="submit" name="delete" value="{t}Delete{/t}" class="button" />{else}&nbsp;{/if}</td>
								<td class="right">{t}Fields marked with a{/t} <span class="compulsory">*</span> {t}are compulsory{/t}</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td class="search">
						<table cellspacing="0" cellpadding="0" id="saveformtable">
								{section name=leftForm loop=$leftForm}
							<tr>
								{if $leftForm[leftForm].type eq "space"}<td colspan="2">&nbsp;</td>
								{elseif $leftForm[leftForm].type eq "padder"}<td>&nbsp;</td>
								{elseif $leftForm[leftForm].type eq "noedit"}<td><b>{$leftForm[leftForm].tag}</b></td><td>{$leftForm[leftForm].value}</td>
								{elseif $leftForm[leftForm].type eq "title"}<td class="ul" colspan="{if $rightForm[leftForm].tag eq ""}3{else}1{/if}"><h1>{$leftForm[leftForm].tag}</h1></td><td class="ulr">{if $leftForm[leftForm].checkbox}<input class="checkbox" type="checkbox" {if $leftForm[leftForm].checked}checked="checked"{/if} {if $leftForm[leftForm].readonly}disabled="disabled"{/if} name="{$leftForm[leftForm].name}{if $leftForm[leftForm].readonly}holder{/if}" />{/if}{if $leftForm[leftForm].checkbox && $leftForm[leftForm].readonly}<input type="hidden" name="{$leftForm[leftForm].name}" value="on" />{/if}</td>
								{elseif $leftForm[leftForm].type eq "text"}
								<td><label for="{$leftForm[leftForm].name}"><b>{$leftForm[leftForm].tag}</b>{if $leftForm[leftForm].compulsory}<span class="compulsory"> *</span>{/if}</label></td>
								<td><input tabindex="{counter name="left"}" type="text" id="{$leftForm[leftForm].name}" name="{$leftForm[leftForm].name}" value="{$leftForm[leftForm].value}" />{if $leftForm[leftForm].suffix neq ""} <b>{$leftForm[leftForm].suffix}</b>{/if}
								{if $leftForm[leftForm].lookup}<input type="submit" onclick='return window.open("index.php?{$session}&amp;module=contacts&action=addresslookup&amp;postcode=" + document.saveform.postcode.value,"test","width=600,height=400,resizable=1,scrollbars=1");' />
								{/if}</td>
								{elseif $leftForm[leftForm].type eq "checkbox"}
								<td><label for="{$leftForm[leftForm].name}"><b>{$leftForm[leftForm].tag}</b>{if $leftForm[leftForm].compulsory}<span class="compulsory"> *</span<{/if}</label></td>
								<td><input tabindex="{counter name="left" start=100}" class="checkbox" type="checkbox" name="{$leftForm[leftForm].name}" {if $leftForm[leftForm].value eq "checked"}checked="checked"{/if} /></td>
								{elseif $leftForm[leftForm].type eq "select" || $leftForm[leftForm].type eq "multiple"}
								<td><label for="{$leftForm[leftForm].name}"><b>{$leftForm[leftForm].tag}</b>{if $leftForm[leftForm].compulsory}<span class="compulsory"> *</span>{/if}</label></td>
								<td{if $leftForm[leftForm].rowspan} rowspan="{$leftForm[leftForm].rowspan}"{/if}><select tabindex="{counter name="left"}" {if $leftForm[leftForm].type eq "multiple"}multiple="multiple" class="multiple" {/if}name="{$leftForm[leftForm].name}">{html_options options=$leftForm[leftForm].options selected=$leftForm[leftForm].value}</select></td>
								{elseif $leftForm[leftForm].type eq "splitselect" || $leftForm[leftForm].type eq "splitmultiple"}
								<td><label for="{$leftForm[leftForm].name}"><b>{$leftForm[leftForm].tag}</b>{if $leftForm[leftForm].compulsory}<span class="compulsory"> *</span>{/if}</label></td>
								<td class="split"><table class="split" cellspacing="0" cellpadding="0"><tr><td class="short"><input class="short" tabindex="{counter name="left"}" type="text" id="{$leftForm[leftForm].name}" name="{$leftForm[leftForm].name}" value="{$leftForm[leftForm].value}" />{if $leftForm[leftForm].suffix neq ""} <b>{$leftForm[leftForm].suffix}</b>{/if}</td><td align="left"><select class="short" tabindex="{counter name="left"}" {if $leftForm[leftForm].type eq "splitmultiple"}multiple="multiple" class="multiple" {/if}name="{$leftForm[leftForm].name}select">{html_options options=$leftForm[leftForm].options selected=$leftForm[leftForm].selectvalue}</select></td></tr></table></td>
								{elseif $leftForm[leftForm].type eq "password"}
								<td><label for="{$leftForm[leftForm].name}"><b>{$leftForm[leftForm].tag}</b>{if $leftForm[leftForm].compulsory}<span class="compulsory"> *</span>{/if}</label></td>
								<td><input tabindex="{counter name="left"}" type="password" id="{$leftForm[leftForm].name}" name="{$leftForm[leftForm].name}" value="{$leftForm[leftForm].value}" />{if $leftForm[leftForm].suffix neq ""} <b>{$leftForm[leftForm].suffix}</b>{/if}</td>
								{elseif $leftForm[leftForm].type eq "ajaxmultiple"}
								<td><label for="{$leftForm[leftForm].name}"><b>{$leftForm[leftForm].tag}</b></label><br />
									<span class="small-text">(Type and matching results will appear)
									
									</span>

									</td>
<td>								

									<input type="text" onKeyUp="javascript:populate({$leftForm[leftForm].inputname}.value,'{$leftForm[leftForm].inputname}','participant')" name="{$leftForm[leftForm].inputname}" autocomplete="off" id="{$leftForm[leftForm].inputname}" onBlur="javascript:setTimeout(function(){literal}{{/literal}ID('chooseparticipant').style.display='none';ID('participantcontainer').style.display='none';{literal}}{/literal},200);" />
<br /><div id="participantcontainer" class="ajaxcontainer" style="display:none;">
<select id="chooseparticipant" onBlur="javascript:this.style.display='none';ID('participantcontainer').style.display='none';" class="hiddenselect" size="10" onchange="javascript:if(this.selectedIndex!=0){literal}{{/literal}moveOption('chooseparticipant','selectedparticipant',this.options[this.selectedIndex].value,this.options[this.selectedIndex].text){literal}}{/literal}">
									<option value="">{t}select result{/t}..</option></select>
</div>

									<select id="selectedparticipant" name="participants[]" class="otherselect" multiple="multiple" size="10" onchange="javascript:if(this.selectedIndex!=0){literal}{{/literal}this.removeChild(this.childNodes[this.selectedIndex]);j=1;while(j<this.length){literal}{{/literal}this.options[j].selected=true;j++;{literal}}{/literal}{literal}}{/literal}">
									<option value="">{t}selected participants{/t}:</option>
									{html_options options=$leftForm[leftForm].value selected=$leftForm[leftForm].value}
									</select><script type="text/javascript">
									to=ID('selectedparticipant');
									j=1;
									while(j<to.length){literal}{{/literal}
										to.options[j].selected=true;
										j++;
									{literal}}{/literal}</script>
	<br />
									</td>

									
								{elseif $leftForm[leftForm].type eq "assocproducts"}
								<td><label for="{$leftForm[leftForm].name}"><b>{$leftForm[leftForm].tag}</b></label><br />
									<span class="small-text">(Type and matching results will appear)</span>

									</td>
<td>								

									<input type="text" onKeyUp="javascript:populate({$leftForm[leftForm].name}.value,'{$leftForm[leftForm].name}','{$leftForm[leftForm].type}')" name="{$leftForm[leftForm].inputname}" autocomplete="off" id="{$leftForm[leftForm].name}" onBlur="javascript:setTimeout(function(){literal}{{/literal}ID('choose{$leftForm[leftForm].name|replace:"choose":""}').style.display='none';ID('{$leftForm[leftForm].name|replace:"choose":""}container').style.display='none';{literal}}{/literal},200);" />
<br /><div id="{$leftForm[leftForm].name|replace:"choose":""}container" class="ajaxcontainer" style="display:none;">
								<select id="choose{$leftForm[leftForm].name|replace:"choose":""}" onBlur="javascript:this.style.display='none';ID('{$leftForm[leftForm].name|replace:"choose":""}container').style.display='none';" class="hiddenselect" size="10" onchange="javascript:if(this.selectedIndex!=0){literal}{{/literal}moveOption('choose{$leftForm[leftForm].name|replace:"choose":""}','selectedproducts',this.options[this.selectedIndex].value,this.options[this.selectedIndex].text){literal}}{/literal}">
									<option value="">{t}select result{/t}..</option></select>																																												
								</div>

									<select name="selectedproducts[]" id="selectedproducts" class="otherselect" multiple="multiple" size="10" onchange="javascript:if(this.selectedIndex!=0){literal}{{/literal}this.removeChild(this.childNodes[this.selectedIndex]);j=1;while(j<this.length){literal}{{/literal}this.options[j].selected=true;j++;{literal}}{/literal}{literal}}{/literal}">
									<option value="">{t}selected products{/t}:</option>
									{html_options options=$leftForm[leftForm].value selected=$leftForm[leftForm].value}
									</select><script type="text/javascript">
									to=ID('selectedproducts');
									j=1;
									while(j<to.length){literal}{{/literal}
										to.options[j].selected=true;
										j++;
									{literal}}{/literal}</script>
	<br />
									</td>
								
								
								
								{elseif ($leftForm[leftForm].type eq "date")}
								<td><label for="{$leftForm[leftForm].name}"><b>{$leftForm[leftForm].tag}</b>{if $leftForm[leftForm].compulsory}<span class="compulsory"> *</span>{/if}</label></td>
								<td class="split"><table class="split" cellspacing="0" cellpadding="0"><tr><td class="input"><input type="hidden" name="{$leftForm[leftForm].name}" id="{$leftForm[leftForm].name}" value="{$leftForm[leftForm].actualvalue}" /><input type="text" tabindex="{counter name="left"}" readonly="readonly" name="{$leftForm[leftForm].name}output" id="{$leftForm[leftForm].name}output" value="{$leftForm[leftForm].value}" {if $leftForm[leftForm].radio}class="radiopair" {else}class="datefield" {/if}/></td><td align="left"><input class="button" type="button" id="{$leftForm[leftForm].name}date" value="{t}Change{/t}" /></td></tr></table>
{literal}<script type="text/javascript">
 Calendar.setup(
    {
      inputField  : "{/literal}{$leftForm[leftForm].name}{literal}",         // ID of the input field
      displayArea : "{/literal}{$leftForm[leftForm].name}{literal}output",
      ifFormat    : "%Y-%m-%d",    // the date format
      daFormat    : "{/literal}{$leftForm[leftForm].format}{literal}",
      button      : "{/literal}{$leftForm[leftForm].name}{literal}date"       // ID of the button

    }
  );
</script>{/literal}
								</td>
								{elseif ($leftForm[leftForm].type eq "ticketqueue") or ($leftForm[leftForm].type eq "ticketsubqueue") or ($leftForm[leftForm].type eq "section") or ($leftForm[leftForm].type eq "supplier") or ($leftForm[leftForm].type eq "company") or ($leftForm[leftForm].type eq "person")}
								<td><label for="{$leftForm[leftForm].name}"><b>{$leftForm[leftForm].tag}</b>{if $leftForm[leftForm].compulsory}<span class="compulsory"> *</span>{/if}</label> ({t}Begin Typing{/t})</td>
								<td class="input">

								<input tabindex="{counter name="left"}" type="text" id="{$leftForm[leftForm].name}" name="{$leftForm[leftForm].name}" value="{$leftForm[leftForm].value}" autocomplete="off"
								onclick="makeAjax('{$leftForm[leftForm].name}','{$leftForm[leftForm].type}');"
								onkeyup='ID("{$leftForm[leftForm].name}b").innerHTML=img;'
								onblur='ID("{$leftForm[leftForm].name}b").innerHTML=" ";'
								/>
								<span id="{$leftForm[leftForm].name}b">&nbsp;</span>
								<input type="hidden" id="{$leftForm[leftForm].name}id" name="{$leftForm[leftForm].name}id" value="{$leftForm[leftForm].actualvalue}"/>
								<div id="{$leftForm[leftForm].name}choices" class="autocompleteoptions" style="display:none;"></div>
								{*<input type="hidden" id="{$leftForm[leftForm].name|replace:"choose":""}id" name="{$leftForm[leftForm].name|replace:"choose":""}id" value="{$leftForm[leftForm].actualvalue}" />
								<input type="text" autocomplete="off" tabindex="{counter name="left"}" id="{$leftForm[leftForm].name|replace:"choose":""}"  name="{$leftForm[leftForm].name|replace:"choose":""}" value="{$leftForm[leftForm].value}" onKeyUp="javascript:ID('{$leftForm[leftForm].name}').style.backgroundColor='#42ADD4';populate({$leftForm[leftForm].name}.value,'{$leftForm[leftForm].name}','{$leftForm[leftForm].type}');ID('{$leftForm[leftForm].name}').style.backgroundColor='#ffffff';" onBlur="javascript:setTimeout(function(){literal}{{/literal}ID('choose{$leftForm[leftForm].name|replace:"choose":""}').style.display='none';ID('{$leftForm[leftForm].name|replace:"choose":""}container').style.display='none';{literal}}{/literal},200);" />
								<a href="#" onclick="javascript:ID('{$leftForm[leftForm].name|replace:"choose":""}id').value='';ID('{$leftForm[leftForm].name|replace:"choose":""}').value='';">X</a>
								<br /><div id="{$leftForm[leftForm].name|replace:"choose":""}container" class="ajaxcontainer" style="display:none;">
								<select id="choose{$leftForm[leftForm].name|replace:"choose":""}" onBlur="javascript:this.style.display='none';ID('{$leftForm[leftForm].name|replace:"choose":""}container').style.display='none';" class="hiddenselect" size="10" onchange="javascript:if(this.selectedIndex!=0){literal}{{/literal}selectValue('{$leftForm[leftForm].name|replace:"choose":""}','{$leftForm[leftForm].name|replace:"choose":""}id',this.options[this.selectedIndex].value,this.options[this.selectedIndex].text){literal}}{/literal}">
									<option value="">{t}select result{/t}..</option></select>
								</div>
								<div id="testing">
								<div>
								*}
								</td>
								{*<td><label for="{$leftForm[leftForm].name}"><b>{$leftForm[leftForm].tag}</b>{if $leftForm[leftForm].compulsory}<span class="compulsory"> *</span>{/if}</label></td>
								<td class="split"><table class="split" cellspacing="0" cellpadding="0"><tr><td class="input"><input type="hidden" name="{$leftForm[leftForm].name|replace:"choose":""}id" value="{$leftForm[leftForm].actualvalue}" /><input type="text" tabindex="{counter name="left"}"  readonly="readonly" name="{$leftForm[leftForm].name|replace:"choose":""}name" value="{$leftForm[leftForm].value}" /></td><td align="left"><input class="button" type="button" name="{$leftForm[leftForm].type}" id="{$leftForm[leftForm].type}" value="{t}Change{/t}" onclick='return window.open("index.php?{$session}&amp;module=choose&amp;action={$leftForm[leftForm].name|replace:"branch":""}holder&amp;name={$leftForm[leftForm].name|replace:"choose":""}{if $leftForm[leftForm].hide neq ""}&amp;hide={$leftForm[leftForm].hide}{/if}&amp;companyid=" + document.saveform.companyid.value,"test","width=600,height=400,resizable=1,scrollbars=1");' /></td></tr></table></td>
								*}
								{elseif ($leftForm[leftForm].type eq "task")}
								<td><label for="{$leftForm[leftForm].name}"><b>{$leftForm[leftForm].tag}</b>{if $leftForm[leftForm].compulsory}<span class="compulsory"> *</span>{/if}</label></td>
								<td class="split"><table class="split" cellspacing="0" cellpadding="0"><tr><td class="input"><input type="hidden" name="{$leftForm[leftForm].name|replace:"choose":""}id" value="{$leftForm[leftForm].actualvalue}" /><input type="text" tabindex="{counter name="left"}"  readonly="readonly" name="{$leftForm[leftForm].name|replace:"choose":""}name" value="{$leftForm[leftForm].value}" /></td><td align="left"><input class="button" type="button" name="{$leftForm[leftForm].type}" id="{$leftForm[leftForm].type}" value="{t}Change{/t}" onclick='return window.open("index.php?{$session}&amp;module=choose&amp;action={$leftForm[leftForm].name|replace:"branch":""}holder&amp;name={$leftForm[leftForm].name|replace:"choose":""}&amp;projectid={$leftForm[leftForm].projectid}{if $leftForm[leftForm].hide neq ""}&amp;hide={$leftForm[leftForm].hide}{/if}","test","width=600,height=400,resizable=1,scrollbars=1");' /></td></tr></table></td>
								
								{/if}
								
								{if $rightForm[leftForm].type eq "space"}<td colspan="2">&nbsp;</td>
								{elseif ($rightForm[leftForm].type eq "title") && ($rightForm[leftForm].tag neq "")}<td colspan="2" class="ul"><h1>{$rightForm[leftForm].tag}</h1></td>
								{elseif $rightForm[leftForm].type eq "text"}
								<td><label for="{$rightForm[leftForm].name}"><b>{$rightForm[leftForm].tag}</b>{if $rightForm[leftForm].compulsory}<span class="compulsory"> *</span>{/if}</label></td>
								{if ($rightForm[leftForm].name neq "") || $rightForm[leftForm].radio}<td>{if $rightForm[leftForm].radio}<input class="radio" type="radio" name="{$rightForm[leftForm].radioname}" value="{$rightForm[leftForm].radiovalue}"{if $rightForm[leftForm].checked} checked="checked"{/if} />{/if}{if $rightForm[leftForm].name neq ""}<input tabindex="{counter name="right" start=100}" {if $rightForm[leftForm].min neq ""}min="{$rightForm[leftForm].min}"{/if} {if $rightForm[leftForm].max neq ""}max="{$rightForm[leftForm].max}"{/if} {if $rightForm[leftForm].maxlength neq ""}maxlength="{$rightForm[leftForm].maxlength}" class="short"{/if} type="text" name="{$rightForm[leftForm].name}" value="{$rightForm[leftForm].value}" /> {$rightForm[leftForm].post}{if $rightForm[leftForm].middle neq ""} {$rightForm[leftForm].middle} {/if} {if $rightForm[leftForm].name2 neq ""}<input tabindex="{counter name="right" start=100}" {if $rightForm[leftForm].min2 neq ""}min="{$rightForm[leftForm].min2}"{/if} {if $rightForm[leftForm].max2 neq ""}max="{$rightForm[leftForm].max2}"{/if} {if $rightForm[leftForm].maxlength2 neq ""}maxlength="{$rightForm[leftForm].maxlength2}" class="short"{/if} type="text" name="{$rightForm[leftForm].name2}" value="{$rightForm[leftForm].value2}" {if $rightForm[leftForm].radio && ($rightForm[leftForm].max eq "")}class="radiopair"{/if} />{/if}{/if}{/if}
								{if $rightForm[leftForm].lookup}<input value="{t}Lookup{/t}" class="button" type="button" onclick='return pcode=window.open("{$serverRoot}/modules/contacts/addresslookup.php/?{$session}&amp;postcode=" + document.saveform.postcode.value,"postcodewindow","width=750,height=400,resizable=1,scrollbars=1,menubar=1");' />
								{/if}
								</td>
								{elseif $rightForm[leftForm].type eq "file"}
								<td><label for="{$rightForm[leftForm].name}">{if $rightForm[leftForm].image neq ''}<a href="#" onclick='return window.open("{$serverRoot}/modules/store/{$rightForm[leftForm].image}.php?{$session}&amp;id={$rightForm[leftForm].value}&amp;server={$serverRoot}&amp;productid={$smarty.get.id}","image","width=600,height=400,resizable=1,scrollbars=1");' >{/if}
								<b>{$rightForm[leftForm].tag}</b>
								{if $rightForm[leftForm].image neq ''}</a><span class="small-text">Click to View</span>{/if}
								{if $rightForm[leftForm].compulsory}<span class="compulsory"> *</span>{/if}</label></td>
								<td><input tabindex="{counter name="right" start=100}" class="file" type="file" name="{$rightForm[leftForm].name}" id="{$rightForm[leftForm].name}" /></td>
								{elseif $rightForm[leftForm].type eq "checkbox"}
								<td><label for="{$rightForm[leftForm].name}"><b>{$rightForm[leftForm].tag}</b>{if $rightForm[leftForm].compulsory}<span class="compulsory"> *</span>{/if}</label></td>
								<td><input tabindex="{counter name="right" start=100}" class="checkbox" type="checkbox" name="{$rightForm[leftForm].name}" {if $rightForm[leftForm].value eq "checked"}checked="checked"{/if} /></td>
								{elseif $rightForm[leftForm].type eq "select" || $rightForm[leftForm].type eq "multiple"}
								<td><label for="{$rightForm[leftForm].name}"><b>{$rightForm[leftForm].tag}</b>{if $rightForm[leftForm].compulsory}<span class="compulsory"> *</span>{/if}</label></td>
								<td {if $rightForm[leftForm].rowspan neq ""}rowspan="{$rightForm[leftForm].rowspan}"{/if}><select tabindex="{counter name="right" start=100}" {if $rightForm[leftForm].type eq "multiple"}multiple="multiple" class="multiple{if $rightForm[leftForm].rowspan neq ""}small{/if}" {/if}name="{$rightForm[leftForm].name}">{html_options options=$rightForm[leftForm].options selected=$rightForm[leftForm].value}</select></td>
								{elseif ($rightForm[leftForm].type eq "radio")}
								<td><label for="{$rightForm[leftForm].name}"><b>{$rightForm[leftForm].tag}</b>{if $rightForm[leftForm].compulsory}<span class="compulsory"> *</span>{/if}</label></td>
								<td>
									{foreach name=radios item=radio key=key from=$rightForm[leftForm].options}
									<label for="radio-{$key}">{$radio}</label>
									<input id="radio-{$key}" type="radio" name="{$rightForm[leftForm].name}" value="{$key}" {if $rightForm[leftForm].value eq $key}checked="checked"{/if} />
									
									{/foreach}</td>
								{elseif ($rightForm[leftForm].type eq "date")}
								<td><label for="{$rightForm[leftForm].name}"><b>{$rightForm[leftForm].tag}</b>{if $rightForm[leftForm].compulsory}<span class="compulsory"> *</span>{/if}</label></td>
								<td class="split"><table class="split" cellspacing="0" cellpadding="0"><tr>{if $rightForm[leftForm].radio}<td class="radio"><input class="radio" type="radio" name="{$rightForm[leftForm].radioname}" value="{$rightForm[leftForm].radiovalue}"{if $rightForm[leftForm].checked} checked="checked"{/if} /></td>{/if}<td class="input"><input type="hidden" name="{$rightForm[leftForm].name}" id="{$rightForm[leftForm].name}" value="{$rightForm[leftForm].actualvalue}" /><input {if $rightForm[leftForm].radio}class="radiopair"{elseif $rightForm[leftForm].time}class="datetimefield"{else}class="datefield" {/if}type="text" tabindex="{counter name="left"}" readonly="readonly" name="{$rightForm[leftForm].name}output" id="{$rightForm[leftForm].name}output" value="{$rightForm[leftForm].value}" /></td>{if $rightForm[leftForm].time}<td><input type="text" class="timefield" name="{$rightForm[leftForm].name}hour" value="{$rightForm[leftForm].timehourvalue}" />:<input type="text" class="timefield" name="{$rightForm[leftForm].name}minute" value="{$rightForm[leftForm].timeminutevalue}" /></td>{/if}<td align="left"><input type="button" id="{$rightForm[leftForm].name}date" value="{t}Choose{/t}" class="button" /></td></tr></table>
{literal}<script type="text/javascript">
  Calendar.setup(
    {
      inputField  : "{/literal}{$rightForm[leftForm].name}{literal}",         // ID of the input field
      displayArea : "{/literal}{$rightForm[leftForm].name}{literal}output",
      ifFormat    : "%Y-%m-%d",    // the date format{/literal}
      
      {literal}daFormat    : "{/literal}{$rightForm[leftForm].format}{literal}",
      button      : "{/literal}{$rightForm[leftForm].name}{literal}date"       // ID of the button
    }
  );
</script>{/literal}
								</td>
								{elseif ($rightForm[leftForm].type eq "ticketsubqueue") or  ($rightForm[leftForm].type eq "ticketqueue") or  ($rightForm[leftForm].type eq "section") or ($rightForm[leftForm].type eq "supplier") or ($rightForm[leftForm].type eq "item") or  ($rightForm[leftForm].type eq "company") or ($rightForm[leftForm].type eq "person")}
								<td><label for="{$rightForm[leftForm].name}"><b>{$rightForm[leftForm].tag}</b>{if $rightForm[leftForm].compulsory}<span class="compulsory"> *</span>{/if}</label> ({t}Begin Typing{/t})</td>
								<td class="input">
								<input tabindex="{counter name="right" start=100}" type="text" id="{$rightForm[leftForm].name}" name="{$rightForm[leftForm].name}" value="{$rightForm[leftForm].value}" autocomplete="off"
								onclick="makeAjax('{$rightForm[leftForm].name}','{$rightForm[leftForm].type}');"
								/>
								<input type="hidden" id="{$rightForm[leftForm].name}id" name="{$rightForm[leftForm].name}id" value="{$rightForm[leftForm].actualvalue}"/>
								<div id="{$rightForm[leftForm].name}choices" class="autocompleteoptions" style="display:none;"></div>
								<script type="text/javascript">
													
															
								
								</script>
								{*<input type="hidden" id="{$rightForm[leftForm].name|replace:"choose":""}id" name="{$rightForm[leftForm].name|replace:"choose":""}id" value="{$rightForm[leftForm].actualvalue}" />
								<input type="text" autocomplete="off" tabindex="{counter name="left"}" id="{$rightForm[leftForm].name|replace:"choose":""}"  name="{$rightForm[leftForm].name|replace:"choose":""}" value="{$rightForm[leftForm].value}" onKeyUp="javascript:ID('{$rightForm[leftForm].name}').style.backgroundColor='#42ADD4';populate({$rightForm[leftForm].name}.value,'{$rightForm[leftForm].name}','{$rightForm[leftForm].type}');ID('{$rightForm[leftForm].name}').style.backgroundColor='#ffffff';" onBlur="javascript:setTimeout(function(){literal}{{/literal}ID('choose{$rightForm[leftForm].name|replace:"choose":""}').style.display='none';ID('{$rightForm[leftForm].name|replace:"choose":""}container').style.display='none';{literal}}{/literal},200);" />
								<a href="#" onclick="javascript:ID('{$rightForm[leftForm].name|replace:"choose":""}id').value='';ID('{$rightForm[leftForm].name|replace:"choose":""}').value='';">X</a>
								<br /><div id="{$rightForm[leftForm].name|replace:"choose":""}container" class="ajaxcontainer" style="display:none;">
								<select id="choose{$rightForm[leftForm].name|replace:"choose":""}" onBlur="javascript:this.style.display='none';ID('{$rightForm[leftForm].name|replace:"choose":""}container').style.display='none';" class="hiddenselect" size="10" onchange="javascript:if(this.selectedIndex!=0){literal}{{/literal}selectValue('{$rightForm[leftForm].name|replace:"choose":""}','{$rightForm[leftForm].name|replace:"choose":""}id',this.options[this.selectedIndex].value,this.options[this.selectedIndex].text){literal}}{/literal}">
									<option value="">{t}select result{/t}..</option></select>
								</div>
								<div id="testing">
								<div>
								*}
								</td>
								{*<td><label for="{$leftForm[leftForm].name}"><b>{$leftForm[leftForm].tag}</b>{if $leftForm[leftForm].compulsory}<span class="compulsory"> *</span>{/if}</label></td>
								<td class="split"><table class="split" cellspacing="0" cellpadding="0"><tr><td class="input"><input type="hidden" name="{$leftForm[leftForm].name|replace:"choose":""}id" value="{$leftForm[leftForm].actualvalue}" /><input type="text" tabindex="{counter name="left"}"  readonly="readonly" name="{$leftForm[leftForm].name|replace:"choose":""}name" value="{$leftForm[leftForm].value}" /></td><td align="left"><input class="button" type="button" name="{$leftForm[leftForm].type}" id="{$leftForm[leftForm].type}" value="{t}Change{/t}" onclick='return window.open("index.php?{$session}&amp;module=choose&amp;action={$leftForm[leftForm].name|replace:"branch":""}holder&amp;name={$leftForm[leftForm].name|replace:"choose":""}{if $leftForm[leftForm].hide neq ""}&amp;hide={$leftForm[leftForm].hide}{/if}&amp;companyid=" + document.saveform.companyid.value,"test","width=600,height=400,resizable=1,scrollbars=1");' /></td></tr></table></td>
								*}
								{elseif ($rightForm[leftForm].type eq "item")}
								<td><label for="{$rightForm[leftForm].name}"><b>{$rightForm[leftForm].tag}</b>{if $rightForm[leftForm].compulsory}<span class="compulsory"> *</span>{/if}</label></td>
								<td class="split"><table class="split" cellspacing="0" cellpadding="0"><tr><td><select onchange="document.saveform.{$rightForm[leftForm].name|replace:"choose":""}name.value='';document.saveform.{$rightForm[leftForm].name|replace:"choose":""}id.value='';document.saveform.{$rightForm[leftForm].name|replace:"choose":""}type.value=document.saveform.{$rightForm[leftForm].name|replace:"choose":""}item.value;" name="{$rightForm[leftForm].name|replace:"choose":""}item">{foreach name=items key=itemkey item=item from=$rightForm[leftForm].items}{if $smarty.foreach.items.first}{assign var="itemtype" value=$itemkey}{/if}<option value="{$itemkey}"{if $itemkey eq $rightForm[leftForm].itemtype} selected="selected"{/if}>{$item}</option>{/foreach}</select></td><td class="input"><input type="text" tabindex="{counter name="right"}"  readonly="readonly" name="{$rightForm[leftForm].name|replace:"choose":""}name" value="{$rightForm[leftForm].value}" /></td><td align="left"><input class="button" type="button" name="{$rightForm[leftForm].type}" id="{$rightForm[leftForm].type}" value="{t}Change{/t}" onclick='return window.open("index.php?{$session}&amp;module=choose&action="+ document.saveform.{$rightForm[leftForm].name|replace:"choose":""}item.value + "holder&amp;name={$rightForm[leftForm].name|replace:"choose":""}&amp;companyid={$smarty.get.companyid}","test","width=600,height=400,resizable=1,scrollbars=1");' /></td></tr></table><input type="hidden" name="{$rightForm[leftForm].name|replace:"choose":""}type" value="{$rightForm[leftForm].itemtype|default:$itemtype}" /><input type="hidden" name="{$rightForm[leftForm].name|replace:"choose":""}id" value="{$rightForm[leftForm].actualvalue}" /></td>
								{elseif ($rightForm[leftForm].type eq "ticketqueue")}
								<td><label for="{$rightForm[leftForm].name}"><b>{$rightForm[leftForm].tag}</b>{if $rightForm[leftForm].compulsory}<span class="compulsory"> *</span>{/if}</label></td>
								<td class="split"><table class="split" cellspacing="0" cellpadding="0"><tr><td class="input"><input type="hidden" name="{$rightForm[leftForm].name|replace:"choose":""}id" value="{$rightForm[leftForm].actualvalue}" /><input type="text" tabindex="{counter name="left"}"  readonly="readonly" name="{$rightForm[leftForm].name|replace:"choose":""}name" value="{$rightForm[leftForm].value}" /></td><td align="left"><input class="button" type="button" name="{$rightForm[leftForm].type}" id="{$rightForm[leftForm].type}" value="{t}Change{/t}" onclick='return window.open("index.php?{$session}&amp;module=choose&action={$rightForm[leftForm].name|replace:"branch":""}holder&amp;name={$rightForm[leftForm].name|replace:"choose":""}{if $rightForm[leftForm].hide neq ""}&amp;hide={$rightForm[leftForm].hide}{/if}","test","width=600,height=400,resizable=1,scrollbars=1");' /></td></tr></table></td>
								{elseif ($rightForm[leftForm].type eq "ticketsubqueue")}
								<td><label for="{$rightForm[leftForm].name}"><b>{$rightForm[leftForm].tag}</b>{if $rightForm[leftForm].compulsory}<span class="compulsory"> *</span>{/if}</label></td>
								<td class="split"><table class="split" cellspacing="0" cellpadding="0"><tr><td class="input"><input type="hidden" name="{$rightForm[leftForm].name|replace:"choose":""}id" value="{$rightForm[leftForm].actualvalue}" /><input type="text" tabindex="{counter name="left"}"  readonly="readonly" name="{$rightForm[leftForm].name|replace:"choose":""}name" value="{$rightForm[leftForm].value}" /></td><td align="left"><input class="button" type="button" name="{$rightForm[leftForm].type}" id="{$rightForm[leftForm].type}" value="{t}Change{/t}" onclick='return window.open("index.php?{$session}&amp;module=choose&action={$rightForm[leftForm].name|replace:"branch":""}holder&amp;name={$rightForm[leftForm].name|replace:"choose":""}","test","width=600,height=400,resizable=1,scrollbars=1");' /></td></tr></table></td>
								{elseif $leftForm[leftForm].type neq "title"}<td colspan="2">&nbsp;</td>{/if}
							</tr>
								{/section}
								{section name=bottomForm loop=$bottomForm}
								{if $bottomForm[bottomForm].type eq "smallarea"}
							<tr>
								<td><label for="{$bottomForm[bottomForm].name}"><b>{$bottomForm[bottomForm].tag}</b>{if $bottomForm[bottomForm].compulsory}<span class="compulsory"> *</span>{/if}</label></td>
								<td {if $leftForm eq ""}class="desc"{/if} colspan="3"><textarea class="small" name="{$bottomForm[bottomForm].name}">{$bottomForm[bottomForm].value}</textarea></td>
							</tr>
								{elseif $bottomForm[bottomForm].type eq "mediumarea"}
							<tr>
								<td><label for="{$bottomForm[bottomForm].name}"><b>{$bottomForm[bottomForm].tag}</b>{if $bottomForm[bottomForm].compulsory}<span class="compulsory"> *</span>}{/if}</label></td>
								<td {if $leftForm eq ""}class="desc"{/if} colspan="3"><textarea class="medium" name="{$bottomForm[bottomForm].name}">{$bottomForm[bottomForm].value}</textarea></td>
							</tr>
								{elseif $bottomForm[bottomForm].type eq "area"}
							<tr>
								<td><label for="{$bottomForm[bottomForm].name}"><b>{$bottomForm[bottomForm].tag}</b>{if $bottomForm[bottomForm].compulsory}<span class="compulsory"> *</span>{/if}</label></td>
								<td {if $leftForm eq ""}class="desc"{/if} colspan="3"><textarea rows="10" cols="20" name="{$bottomForm[bottomForm].name}">{$bottomForm[bottomForm].value}</textarea></td>
							</tr>
								{elseif $bottomForm[bottomForm].type eq "fckeditor"}
							<tr>
								<td><label for="{$bottomForm[bottomForm].name}"><b>{$bottomForm[bottomForm].tag}</b>{if $bottomForm[bottomForm].compulsory}<span class="compulsory"> *</span>}{/if}</label></td>
								<td class="fck" colspan="3">{$bottomForm[bottomForm].fckeditor}</td>
							</tr>
								{/if}
								{/section}
						</table>
					</td>
				</tr>
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
