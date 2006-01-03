function ID(id){return document.getElementById(id);}

var buffer='';
var counter=0;
function poll(input) {
var control = ID(input);
var text = control.value;
if(text!=buffer&&text!='') {
	populate(text,'selParts','participant');
	counter++;
	ID('testing').innerHTML=counter;
	buffer=text;
}
setTimeout("poll('participant')",500);

}
window.onload = function()
{
setTimeout("poll('participant')",500);
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
	fromloc='selParts';
	toloc='selectedParts';
	if(fromsel=='selParts') {
		fromloc='selectedParts';
		toloc='selParts';
	}
	tooption.setAttribute('id',val);
	tooption.setAttribute('value',val);

	//tooption.setAttribute('onClick','javascript:moveOption("'+fromloc+'","'+toloc+'","'+val+'","'+text+'")');
	tooption.appendChild(document.createTextNode(text));
	toselect.appendChild(tooption);
	var j=1;
		var to = ID('selectedParts');


	while(j<to.length) {

		to.options[j].selected=true;
		j++;
	
	}
/**
 * Removes duplicates in the array 'a'
 * @author Johan Känngård, http://dev.kanngard.net
 */
function unique(a) {
	tmp = new Array(0);
	for(i=0;i<a.length;i++){
		if(!contains(tmp, a[i])){
			tmp.length+=1;
			tmp[tmp.length-1]=a[i];
		}
	}
	return tmp;
}

/**
 * Returns true if 's' is contained in the array 'a'
 * @author Johan Känngård, http://dev.kanngard.net
 */
function contains(a, e) {
	var	count=0;
	for(j=0;j<a.length;j++)if(a[j]==e)count++;
	if(count>1) return true;
	return false;
}
}
function HTTPResponse(text, control)
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
	
	}
}

function populate(typed, control, type)
{
	if (window.XMLHttpRequest) {xhr = new XMLHttpRequest();}
	else if (window.ActiveXObject) {xhr = new ActiveXObject("Microsoft.XMLHTTP");}
	else return false;
	address="/modules/calendar/mysaveevent.php?type="+type;
	xhr.open("POST",address, true);
	xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');
	xhr.send(typed);
	xhr.onreadystatechange=function()
	{
	if (xhr.readyState==4)
	{
		if (xhr.responseText!="")
		{
			HTTPResponse(xhr.responseText, control);
			ID(control).style.visibility="visible";
						ID('container').style.display="block";




		}
		else
		{
			ID(control).style.visibility="hidden";	
									ID('container').style.display="none";



	//		ID(control).style.z-index="-1";	
		}
	}
}
} 
