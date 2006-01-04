{* for showing one specific 'thing', currently with the sub-bits at the bottom/side, but these will probably be
put in their own templates at some point*}
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