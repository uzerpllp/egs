{*displays the logos, page-header and the top menu*}


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