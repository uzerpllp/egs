{*displays the things on the left (jump between companies, submenu, last viewed, log hours) *}

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