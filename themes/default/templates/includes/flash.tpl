{*displays the errors and messages *}
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