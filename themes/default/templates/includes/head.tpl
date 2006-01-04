{* contains everything that goes between the <head> tags*}
{if $redirect}
	<meta http-equiv="refresh" content="3;url={$serverRoot}/?{$session}&amp;module={$module}&amp;{$redirectAction}" />
	{/if}
<title>Enterprise Groupware System</title>
    <meta name="keywords" content="Groupware, ERP, Project Management" />
    <meta name="description" content="Enterprise Groupware System - built by Senokian Solutions Ltd - http://www.senokian.com" />
	<link rel="stylesheet" href="{$serverRoot}/themes/{$theme}/newstyle.css" type="text/css" />
	<link rel="stylesheet" type="text/css" media="all" href="{$serverRoot}/themes/{$theme}/js/jscalendar/skins/aqua/theme.css" title="Aqua" />
	<script type="text/javascript">
	{*this bit is here so that the AJAX calls know where to find the PHP scripts and they can pass on a session *}
		window.onload = function()
		{literal}{{/literal}
			serverroot = '{$serverRoot}';
			sessionid = '{$session}';
			img='<img src="'+serverroot+'/src/ajax/searching.gif" />';
		{literal}}{/literal}
	</script>

	<script type="text/javascript" src="{$serverRoot}/themes/{$theme}/js/jscalendar/calendar.js"></script>
	<script type="text/javascript" src="{$serverRoot}/themes/{$theme}/js/jscalendar/lang/calendar-en.js"></script>
	<script type="text/javascript" src="{$serverRoot}/themes/{$theme}/js/jscalendar/calendar-setup.js"></script>

	<script type='text/javascript' src="{$serverRoot}/src/ajax/dropdowns.js"></script>
	<script src="{$serverRoot}/src/ajax/prototype.js" type="text/javascript"></script>
	<script src="{$serverRoot}/src/ajax/scriptaculous.js" type="text/javascript"></script>
	

	{if $module eq "home"}<!--<script type="text/javascript" src="{$serverRoot}/modules/calendar/functions/event.js"></script>-->{/if}
	{if $module eq 'projects' && $smarty.get.action eq 'view'}
	<script type='text/javascript' src="{$serverRoot}/modules/projects/editing.js"></script>
	{/if}
	{if $showCurrentTask}
	<script type='text/javascript' src="{$serverRoot}/modules/projects/projectselect.js"></script>
	{/if}
	
	
	

	


	{if $redirect}
	<script type="text/javascript">
	{literal}
	<!--
	function delayer(){
	document.location = "{/literal}{$serverRoot}/?{$session}&module={$module}&{$redirectAction|replace:"amp;":""}{literal}"
	}
	//-->{/literal}
	</script>
	{/if}
	{if $module eq 'home'}
	{literal}
	<script type="text/javascript">
	<!--
	
	function openEventWindow(num) {
		// populate the hidden form
		
		var data = document.popup_data[num];
		var form = document.forms.eventPopupForm;
		form.elements.date.value = data.date;
		form.elements.time.value = data.time;
		form.elements.uid.value = data.uid;
		
		// open a new window
		var w = window.open('', 'Popup', 'scrollbars=yes,width=460,height=275');
		form.target = 'Popup';
		form.submit();
	}
	
	function EventData(date, time, uid) {
		this.date = date;
		this.time = time;
		this.uid = uid;
	}
	
	function openTodoInfo(vtodo_array) {	
		var windowW = 460;
		var windowH = 275;
		var url = '{/literal}{$serverRoot}{literal}/modules/calendar/includes/todo.php?vtodo_array='+vtodo_array;
		options = 'scrollbars=yes,width='+windowW+',height='+windowH;
		info = window.open(url, 'Popup', options);
		info.focus();
	}
	
	document.popup_data = new Array();
	//-->
	</script>
	{/literal}{/if}
	{literal}
	<script type="text/javascript">
	
	
	<!--//<![CDATA
	
	function confirmSubmit(message) {
	 var confirmed = confirm(message);
	
	 if(document.getElementById && confirmed) {
	   document.getElementById('multipledelete').submit();
	 }
	 else if(confirmed) {
	   document.all('multipledelete').submit();
	 }
	}
	{/literal}
	{if ($smarty.get.module eq "projects") && (($smarty.get.action eq "") || ($smarty.get.action eq "overview"))}
	{literal}
	function confirmToggle(message, type) {
	 var confirmed = confirm(message);
	
	 if(document.getElementById && confirmed) {
	   document.saveform.toggletype.value = type;
	   document.getElementById('multipledelete').submit();
	 }
	 else if(confirmed) {
	   document.all('multipledelete').submit();
	 }
	}
	{/literal}
	{/if}
	{literal}
	function CheckAllDelete() {
	 if(document.getElementById) {
	  for (var i = 0; i < document.getElementById('multipledelete').elements.length; i++) {
	    if(document.getElementById('multipledelete').elements[i].type == 'checkbox'){
	      document.getElementById('multipledelete').elements[i].checked =         !(document.getElementById('multipledelete').elements[i].checked);
	    }
	  }
	 }
	 else {
	  for (var i = 0; i < document.all('multipledelete').elements.length; i++) {
	    if(document.all('multipledelete').elements[i].type == 'checkbox'){
	      document.all('multipledelete').elements[i].checked =         !(document.all('multipledelete').elements[i].checked);
	    }
	  }
	 }
	}
	
	//]]-->
	{/literal}
	</script>