{*displays the overview pages (and module-setup too, and add-pages for somethings (attributes))*}
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