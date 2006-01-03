function ID(id){return document.getElementById(id);}

var buffer='';
var counter=0;
var auto=0;
function poll(input) {

	var control = ID(input);
	var text = control.value;
	if(text!=buffer&&text!=''&&auto==0) {
		projectPopulate(text,'projectSelect','projectinput');
		counter++;
		buffer=text;
	}
	if(auto==1) {
		auto=0;
		buffer=text;
	}
				
if(text=='')ID('projectSelect').style.display="none";
setTimeout("poll('projectinput')",500);

}


//takes an option from 'fromsel' and moves it to 'tosel'
function chooseProject(fromsel, tosel, v, t) {
	ID('projectselectcontainer').style.display="none";
	auto=1;
	ID('projectinput').value=t;

	var pid = v;
	if (window.XMLHttpRequest) {xhr = new XMLHttpRequest();}
	else if (window.ActiveXObject) {xhr = new ActiveXObject("Microsoft.XMLHTTP");}
	else return false;
	type='chooseproject';
	address=serverroot+"/modules/projects/addhours.php?"+sessionid+"&type="+type;
	xhr.open("POST",address, true);
	xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');
	xhr.send(v);
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
				while(options.length>1)
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
				
						option = D.createElement('option');
						option.setAttribute('value',value);
						option.setAttribute('id',value);
						//option.setAttribute('onClick','javascript:moveOption("selParts","selectedParts",'+value+',"'+text+'")');
						option.appendChild(D.createTextNode(text));
						select.appendChild(option);
				
					
				
				}
				select.removeAttribute('disabled');
				options[0].text="Now Choose a Task:";
			}
			else {
				ID('taskSelect').setAttribute('disabled','disabled');
			}
			
		}
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
		if(val.indexOf('@')!=-1) {
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
}

function projectPopulate(typed, control, type)
{
	if (window.XMLHttpRequest) {xhr = new XMLHttpRequest();}
	else if (window.ActiveXObject) {xhr = new ActiveXObject("Microsoft.XMLHTTP");}
	else return false;
	if(!xhr) return false;

	address=serverroot+"/modules/projects/addhours.php?"+sessionid+"&type="+type;

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
	
				ID('projectselectcontainer').style.display="block";
				ID(control).style.display="block";
	
			}
			else
			{
	//			ID(control).style.visibility="hidden";	
				ID(control).style.display="none";
				ID('projectselectcontainer').style.display="none";
	
	
		//		ID(control).style.z-index="-1";	
			}
		}
	}
} 