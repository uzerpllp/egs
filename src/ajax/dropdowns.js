function ID(id){return document.getElementById(id);}

function makeAjax(name,type) {
companyid='';
if(type=='person') {
	companyid=ID('companyid').value;
	
}
queueid=''
if(type=='ticketsubqueue') {
	queueid=ID('queueid').value;
}
new Ajax.Autocompleter(name, name+"choices",serverroot+"/src/ajax/ajaxchoose.php?"+sessionid+"&type="+type+"&companyid="+companyid+"&queueid="+queueid,
										 {
										 paramName: "value",
										 frequency: 0.2,
										 minChars: 2,
										 afterUpdateElement:function(input,selected) {
										 	ID(name+'id').value=selected.id;
										 	ID(name+'b').innerHTML=' ';
										 }
										 
										});

}

function removeItem(item) {
new Effect.Highlight('dragg_'+item,{startcolor:'#ff0000', endcolor:'#ffffff'});
if (window.XMLHttpRequest) {xhr = new XMLHttpRequest();}
	else if (window.ActiveXObject) {xhr = new ActiveXObject("Microsoft.XMLHTTP");}
	else return false;
	if(!xhr) { return false;}
	address=serverroot+"/src/ajax/sethomeorder.php?"+sessionid+"&type=remove";
	

	xhr.open("POST",address, true);
	xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');
	xhr.send(item);

//	ID('dragg_'+item).style.display='none';
	xhr.onreadystatechange=function()
	{
		if (xhr.readyState==4)
		{

			if (xhr.responseText!="")
			{
				if(xhr.responseText!="last") {
					ID('testingbox').innerHTML=xhr.responseText;
				}
			}
			else {
					new Effect.Fade('dragg_'+item);
			}
			
		}
	}
	

}
function setHomeOrder(poststring) {
	if (window.XMLHttpRequest) {xhr = new XMLHttpRequest();}
	else if (window.ActiveXObject) {xhr = new ActiveXObject("Microsoft.XMLHTTP");}
	else return false;
	if(!xhr) { return false;}
	address=serverroot+"/src/ajax/sethomeorder.php?"+sessionid+"&type=move";
	

	xhr.open("POST",address, true);
	xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');
	xhr.send(poststring);
	xhr.onreadystatechange=function()
	{
		if (xhr.readyState==4)
		{

			if (xhr.responseText!="")
			{
				ID('testingbox').innerHTML=xhr.responseText;
			}
			
		}
	}


}


var abuffer='';
var acounter=0;
var autocompleted=0;
function pollGeneric(input) {

	var control = ID(input);

	
	var text = control.value;
	if(text!=abuffer && text!='' && autocompleted==0) {
		populate(text,input,input);
		acounter++;
		abuffer=text;
	}
	if(autocompleted==1) {
		autocompleted=0;
		abuffer=text;
	}
	if(text=='') {
		abuffer='';
		ID('choose'+input).style.display="none";
		ID(input+'id').value='';	
	}
	setTimeout("pollGeneric('"+input+"')",500);

}
//sets a (hidden?) field '
function selectValue(field, hidden, value, text) {

	if(field=='item') {
		//need to set 'itemtype' to either 'Case' or 'Opportunity'
		if(text.indexOf('Case')!=-1)
			ID('itemtype').value='case';
		else if(text.indexOf('Opportunity')!=-1)
			ID('itemtype').value='opportunity';	
			
		alert(ID('itemtype').value);
	}
	var f=ID(field);
	var h=ID(hidden);
	ID(field+'container').style.display="none";
	h.setAttribute('value',value);
	autocompleted=1;
	f.value=text;


} 
//takes an option from 'fromsel' and moves it to 'tosel'
function moveOption(fromsel, tosel, v,t) {

	var fromselect = ID(fromsel);
	var toselect = ID(tosel);

	var val = v;
	var text = t;
	/*get the options from the left-box*/

	var fromoptions = fromselect.getElementsByTagName('option'), fromoption;
	/*get the options from the right box*/
	var tooptions = toselect.getElementsByTagName('option'), tooption;
	/*delete opt from the left-box*/
	var i=0;
	while(i<fromoptions.length) {
		var va=fromoptions[i].getAttribute('value');

		if(va==val) {
			fromselect.removeChild(fromoptions[i]);
		}
		i++;
	
	}
//	fromselect.removeChild(opt);
	/*and add to the right-box*/
	tooption = document.createElement('OPTION');
	fromloc=tosel;
	toloc=fromsel;

	tooption.setAttribute('id',val);
	tooption.setAttribute('value',val);

	//tooption.setAttribute('onClick','javascript:moveOption("'+fromloc+'","'+toloc+'","'+val+'","'+text+'")');
	tooption.appendChild(document.createTextNode(text));
	toselect.appendChild(tooption);
	var j=1;
		var to = ID(tosel);

	if(to) {
		while(j<to.length) {
			to.options[j].selected=true;
			j++;
		}
	}
	
}
function dropdownHTTPResponse(text, control)
{

	

	var select = ID(control);
	var vals = text.split('\n'), val;
	var options = select.getElementsByTagName('option'), option;
	var k, D = document;
	
	/* empty all options but first */
	while(options.length>1)
		select.removeChild(options[options.length-1]);
	
	/* (re)fill */
	var i=0;
	
	for(k=-1;val=vals[++k];)
	{

		var vs = val.split('@');
		var value = vs[1];
		var text = vs[0];


		
		option = D.createElement('option');
		option.setAttribute('value',value);
		option.setAttribute('id',value);
		//option.setAttribute('onClick','javascript:moveOption("selParts","selectedParts",'+value+',"'+text+'")');
		option.appendChild(D.createTextNode(text));
		select.appendChild(option);
		i++;
	}

}

function populate(typed, control, type)
{
	
	if (window.XMLHttpRequest) {xhr = new XMLHttpRequest();}
	else if (window.ActiveXObject) {xhr = new ActiveXObject("Microsoft.XMLHTTP");}
	else return false;
	if(!xhr) { return false;}
	if(type=='participant') { address=serverroot+"/src/ajax/participants.php?"+sessionid+"&type="+type; }
	else if(type=='assocproducts') { address=serverroot+"/src/ajax/assocproducts.php?"+sessionid+"&type="+type; }
	else if(type=='section'||type=='supplier'||type=='item'||type=='person'||type=='company') { address=serverroot+"/src/ajax/ajaxchoose.php?"+sessionid+"&type="+type; }
	if(type=='person') {
		

		if(ID('companyid')!=null) {

			var company = ID('companyid').value;

			if(company!='') {address=address+'&companyid='+company;}
		}
		

	}	
//	address+='&'+sessionid;

	xhr.open("POST",address, true);
	xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');
	xhr.send(typed);
	xhr.onreadystatechange=function()
	{
		if (xhr.readyState==4)
		{

			if (xhr.responseText!="")
			{

				ID(control+'container').style.display="block";
				ID('choose'+control).style.display="block";

				dropdownHTTPResponse(xhr.responseText,'choose'+control);
	//			ID(control).style.visibility="visible";
				/*ID('testing').innerHTML=xhr.responseText;*/
			
	
			}
			else
			{
	//			ID(control).style.visibility="hidden";	
				ID('choose'+control).style.display="none";
				ID(control+'container').style.display="none";
	
	

			}
		}
	}
} 

function schooseProject(id) {


if (window.XMLHttpRequest) {xhr = new XMLHttpRequest();}
	else if (window.ActiveXObject) {xhr = new ActiveXObject("Microsoft.XMLHTTP");}
	else return false;
	var pflag;

	if(id.charAt(0)=='p') {
		type='chooseproject';
		pflag='p';
		address=serverroot+"/modules/projects/addhours.php?"+sessionid+"&type="+type;
		id=id.substring(1);
	}
	else if(id.charAt(0)=='t') {
		pflag='t';
		type='chooseticket';
		address=serverroot+"/src/ajax/tickets.php?"+sessionid;
		id=id.substring(1);
	}

	xhr.open("POST",address, true);
	xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');
	xhr.send(id);
	xhr.onreadystatechange=function()
	{
		if (xhr.readyState==4)
		{
			if (xhr.responseText!="")
			{

				var text=xhr.responseText;

				var select = ID('taskSelect');
				var vals = text.split('//'), val;
				var options = select.getElementsByTagName('option'), option;
				var k, D = document;
				
				/* empty all options but first */

				p=1;
				
					while(options.length>p)
						select.removeChild(options[options.length-1]);
					/* (re)fill */
					var i=0;
					for(k=-1;val=vals[++k];)
					{
						var vs = val.split('@');
						var value = vs[0];
						var text = vs[1];
	
						var re = /^[0-9]*\/[0-9]*/;
					//alert(re.test(value));
					if(pflag=='p') {
							option = D.createElement('option');
							option.setAttribute('value',pflag+value);
							option.setAttribute('id',pflag+value);
							//option.setAttribute('onClick','javascript:moveOption("selParts","selectedParts",'+value+',"'+text+'")');
							option.appendChild(D.createTextNode(text));
							select.appendChild(option);
					
						}
					
					}
					select.removeAttribute('disabled');
					if(pflag=='p')options[0].text="Now Choose a Task:";
					else {
						options[0].value=pflag+value;
						options[0].id=pflag+value;
						options[0].text="Click Submit";
					}
			}
			else {
				ID('taskSelect').setAttribute('disabled','disabled');
			}
			
		}
	}
	

}