{* the bit at the top of the overview page for searching *}
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