{* the home page, with the welcome message and the draggable summary-panels*}

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
