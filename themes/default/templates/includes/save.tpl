{* for editing/creating a new 'thing', will probably want to be split up a bit more, as everything is repeated
but might need a function?*}
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
								{if $leftForm[leftForm].readonly}readonly="readonly"{/if}
								{if $leftForm[leftForm].disabled}disabled="disabled"{/if}
								onfocus="makeAjax('{$leftForm[leftForm].name}','{$leftForm[leftForm].type}');"
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
								onfocus="makeAjax('{$rightForm[leftForm].name}','{$rightForm[leftForm].type}');"
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