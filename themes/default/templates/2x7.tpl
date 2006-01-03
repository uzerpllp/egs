<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="{$serverRoot}/themes/{$theme}/styles.css" type="text/css" />

<title>EGS</title>
</head>
<body>
 <form action='pdf/print_pdf.php' method='post'>
 <input type='hidden' name='font_name' value='Arial' />
 <input type='hidden' name='font_size' value='10' />
 <input type='hidden' name='font_spacing' value='5' />
 <input type='hidden' name='layout_cols' value='2' />
 <input type='hidden' name='layout_rows' value='7' />
 <input type='hidden' name='cell_width' value='100' />
 <input type='hidden' name='cell_height' value='38' />
 <input type='hidden' name='margin_top' value='18' />
 <input type='hidden' name='margin_left' value='4' />
 <input type='hidden' name='name_default' value='IT-ansvarlig' />
 <input type='hidden' name='name_prefix' value='Att: ' />

 <table id="labels" cellspacing="0">
  <tbody>
  	<tr>
   {section name="row" loop=$row_data}
   		<td>{section name="address" loop=$row_data[row] start=2}{if $row_data[row][address] neq ""}{$row_data[row][address]}<br />{/if}{/section}</td><td><input type="checkbox" name="item[{$smarty.section.row.index}]" value="{$row_data[row][0]}/{$row_data[row][1]}"></td>
   		{if $smarty.section.row.iteration%4 eq 0}</tr><tr>{/if} 		
   {/section}
   {if $smarty.section.row.total%4 eq 1}<td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td></tr>
   {elseif $smarty.section.row.total%4 eq 2}<td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td></tr>
   {elseif $smarty.section.row.total%4 eq 3}<td colspan="2">&nbsp;</td></tr>{/if}
</tbody>
</table>
	<input type='submit'>
	</form>
</body>
</html>


