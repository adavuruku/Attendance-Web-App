
var idall;
function byId(e)
{
    return document.getElementById(e);
}

function openloader(j){
	var idd= j;
    document.getElementById(idd).innerHTML ='<img src="loader.gif" class="img-responsive" alt="Uploading...."/>';
}

function closeloader(j){
	var idd= j;
    document.getElementById(idd).innerHTML ='';
}
	
	//dis prepared and submit results
	function submit_result(r,c,d){
	//alert(c);
	idall = r + "status";
	openloader(idall);
	var test1 = r+"T1";
	var test2 = r+"T2";
	var test3 = r+"T3";
	var exam = r+"E";
	
	var test1_value = new Number(document.getElementById(test1).value);
	var test2_value = new Number(document.getElementById(test2).value);
	var test3_value = new Number(document.getElementById(test3).value);
	var exam_value = new Number(document.getElementById(exam).value);
	
	//alert(test3_value);
	var course_gp = new Number(document.getElementById('course_gp').value);
		//calculate the GP
		var tot_score =  test1_value + test2_value + test3_value + exam_value;
		
		var grade = "C/O";
		var point = 0;
		if (tot_score <= 39)
		{
			grade = "C/O";
			point = course_gp * 0;
		}
		if (tot_score >= 40)
		{
			grade = "E";
			point = course_gp * 1;
		}
		if (tot_score >= 45)
		{
			grade = "D";
			point = course_gp * 2;
		}
		if (tot_score >= 50)
		{
			grade = "C";
			point = course_gp * 3;
		}
		if (tot_score >= 60)
		{
			grade = "B";
			point = course_gp * 4;
		}
		if (tot_score >= 70)
		{
			grade = "A";
			point = course_gp * 5;
		}
		if (tot_score > 100)
		{
			var idd= idall;
			closeloader(idall);
			document.getElementById(idd).innerHTML="";
			document.getElementById(idd).innerHTML='<p style="color:red">Total More than 100</p>';
			return;
		}
	//	alert(point);
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		  {
			var idd= idall;
			closeloader(idall);
		  alert ("Your browser does not support AJAX!");
		  return;
		 }
		

		var submit3 = "result";
		var url="Upload_Result_Script.php";
		parameters="result="+submit3+"&test1="+test1_value+"&test2="+test2_value+"&test3="+test3_value+
		"&exam_val="+exam_value+"&grade="+grade+"&point="+point
		+"&regno="+r+"&dept="+d+"&code="+c;
		//alert(point);
		xmlHttp.onreadystatechange=stateChanged33;
		xmlHttp.open("POST",url,true);
		xmlHttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xmlHttp.send(parameters);		
	}
	
/*THIS PROCESS ADMIN CHANGES*/
function submit_changes(p)
{
	//alert(p);
	idall = p;
	var idd = p +"status";	
	openloader(idd);
	var school = p + "S";
	var Course = p + "C";
	var school = p + "S";
	var admin = p + "A";
	

	var school_value =document.getElementById(school).value;
	var course_value =document.getElementById(Course).value;
	var admin_value =document.getElementById(admin).value;
	 
	if ((school_value.length==0) ||(course_value.length ==0) ||(admin_value.length ==0))
	 { 
		  var idd = p +"status";
		  closeloader(idd);
		  document.getElementById(idd).innerHTML="Empty Fields";
		return;
	  }
	  
	 if ((school_value != "0") && (school_value != "1"))
	 { 
		  var idd = p +"status";
		  closeloader(idd);
		  document.getElementById(idd).innerHTML="Fields Must Contain (0/1)";
		return;
	  }
	 if((course_value !="0") && (course_value !="1"))
	 { 
		
		  var idd = p +"status";
		  closeloader(idd);
		  document.getElementById(idd).innerHTML="Fields Must Contain (0/1)";
		return;
	  }
	  if((admin_value !="0") && (admin_value !="1"))
	 { 
		  var idd = p +"status";
		  closeloader(idd);
		  document.getElementById(idd).innerHTML="Fields Must Contain (0/1)";
		return;
	  }
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	  {
		var idd = p +"status";
		closeloader(idd);
	  alert ("Your browser does not support AJAX!");
	  return;
	 }
	

	var submit3 = "admin";
	var url="Upload_Result_Script.php";
	parameters="admin="+submit3+"&school_value="+school_value+"&course_value="+course_value+"&admin_value="+admin_value+"&staff_id="+p;
    xmlHttp.onreadystatechange=stateChanged33;
    xmlHttp.open("POST",url,true);
    xmlHttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlHttp.send(parameters);
} 

function stateChanged33() 
{ 
	var idd = idall;
	if (xmlHttp.readyState==4)
	{ 
		closeloader(idd);
		document.getElementById(idd).innerHTML="";
		document.getElementById(idd).innerHTML=xmlHttp.responseText;
	}
}

//this load the department 
function load_department(){
	var id = "status";
	openloader(id);
	var course = document.getElementById('course_title').value;
	//alert(course);
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	  {
	  alert ("Your browser does not support AJAX!");
	  return;
	 }
	

	var submit3 = "result_step_one";
	var url="Upload_Result_Script.php";
	parameters="result_step_one="+submit3+"&course_code="+course;
    xmlHttp.onreadystatechange=stateChangedTwo;
    xmlHttp.open("POST",url,true);
    xmlHttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlHttp.send(parameters);

}

function stateChangedTwo() 
{ 
	if (xmlHttp.readyState==4)
	{ 
		var id = "status";
		closeloader(id);
		var outcome = xmlHttp.responseText;
		//alert(outcome);
		if(outcome!="No records"){
			
			var scat = outcome.split(";");
			var course_combo = byId('dept');
			emptyCombo(course_combo);
			for (i=0;i<= scat.length;i++){	  
				//alert(scat[i].toString());
				var value = scat[i].toString();
				addOption(course_combo, value, value);
			}
			
		}
		
		
	}
}
    function emptyCombo(e)
    {
        e.innerHTML = '';
    }
 
    function addOption(combo, val, txt)
    {
        var option = document.createElement('option');
        option.value = val;
        option.title = txt;
        option.appendChild(document.createTextNode(txt));
        combo.appendChild(option);
    }
	
function GetXmlHttpObject()
{
	var xmlHttp=null;
	try
		{
			 // Firefox, Opera 8.0+, Safari
			xmlHttp=new XMLHttpRequest();
		}
	catch (e)
		{
			// Internet Explorer
			 try
				{
					xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
				}
			  catch (e)
				{
					xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
		}
			return xmlHttp;
}

//delete records
function delete_Course(p,q)
{
	//alert(q);
	idall = p;
	var msg = p + " - " + q;
	var message = "Are You sure You Want to Remove \n\n" + msg + " .. \n\nFrom your Cart List...?";
	var r=confirm(message);
	if (r==true)
	{
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			  {
			  alert ("Your browser does not support AJAX!");
			  return;
			 }
			
			
			var submit2 = "delete";
			var url="Upload_Result_Script.php";
			parameters="delete_item="+submit2+"&course_code="+p;
			xmlHttp.onreadystatechange=stateChanged22;
			xmlHttp.open("POST",url,true);
			xmlHttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xmlHttp.send(parameters);
	}
}
function stateChanged22() 
{ 
	var idd = idall;
	if (xmlHttp.readyState==4)
	{
		document.getElementById(idd).innerHTML="";
		document.getElementById(idd).innerHTML=xmlHttp.responseText;
	}
}
function noNumbers(e, t) 
{
	try {

		if (window.event) {
			var charCode = window.event.keyCode;}

		else if (e) {
			var charCode = e.which;
		}
		else { return true; }

		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	}
	catch (err) {
		alert(err.Description);
	}   
} 