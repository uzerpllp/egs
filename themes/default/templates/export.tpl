{foreach name=headings key=headingOrder item=headingTitle from=$headings}{$headingTitle}{$sep|default:"		"}{/foreach}

{section name=rows loop=$rows}{section name=data loop=$rows[rows]}{if !$smarty.section.data.first}{$rows[rows][data]|default:" "}{/if}{$sep|default:"	"}{/section}

{/section}