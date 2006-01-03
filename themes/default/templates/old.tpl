
	<div id="button"><a href="javascript:toggleLayer('sideBar');"><img src="themes/senokian/graphics/out.png" border="0" id="sidebarImage"/></a></div>
				<div id="sideBar">
				
<table cellspacing="0" class="corner">
	<thead>
	<tr>
		<td>{$moduleName} {t}Options{/t}</td>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td></td>
	</tr>
	</tbody>
</table>
<table cellspacing="0" class="corner">
	<thead>
	<tr>
		<td>{t}Last Viewed{/t}</td>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td></td>
	</tr>
	</tbody>
</table>

				<table id="submenu" cellpadding="0" cellspacing="0">
					
					
				</table>
				</div>
			<div id="bodyarea">
				<!-- This is the main body area -->
				
				
				
				
				
				
				<!-- End of main body area -->
			</div>
			<!--<div id="footer">
	<table id="lowermodules" cellspacing="0" cellpadding="0">
		<tr>
			<td class="modules"> {section name=module loop=$modules}<a {if $modules[module].name eq $module}class="on" {/if}href="{$serverRoot}?{$session}&amp;module={$modules[module].name}">{$modules[module].translated}</a>{if !$smarty.section.module.last} | {/if}{/section}</td>
		</tr>
		<tr>
			<td><p>{t}This page was created in{/t} {$totalTime}s</p><p>{t}Powered by{/t}: <a href="http://www.enterprisegroupwareystem.org">Enterprise Groupware System</a>{if $smarty.get.action eq "bugs"} &amp; <a href="http://flyspray.rocks.cc/">Flyspray</a>{/if}{if $smarty.get.module eq "calendar"} &amp; <a href="http://phpicalendar.net/">PHPiCalendar</a>{/if}{if $smarty.get.module eq "wiki"} &amp; <a href="http://wiki.splitbrain.org/wiki:dokuwiki">DokuWiki</a>{/if}{if $smarty.get.module eq "weberp"} &amp; <a href="http://www.weberp.org">webERP</a>{/if}</p><p>&copy; 2004-2005 <a href="http://www.senokian.com">Senokian Solutions</a> {t}All rights reserved{/t}</p></td>
		</tr>
	</table>
	</div>-->
    <script type="text/javascript">
    var ddm1 = new DropDownMenu1('menu1');
    ddm1.position.top = -1;
    ddm1.init();
    </script>