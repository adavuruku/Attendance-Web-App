

/*THIS PRINT TRANSACTION ORDER ALL YOUR ITEM IN CART*/
function Print_Cart(purchase_order)
{
	var message = "Are You sure You Want to Submit all the Goods List in Your Cart for Purchase...?";
	var r=confirm(message);
	if (r==true)
	{
			//alert(p);
			document.getElementById('show_cart').innerHTML="";
			window.location.assign("store_files/Purchase_Order_Slip_Print.php?former_trans_code=" + purchase_order);
	}
}

//auto fill all the courses
function fill_all_my_course()
{
	var message = "Are You sure You Want to Automatically Fill All your Departmental Courses \nfor the Semester...?";
	var r=confirm(message);
	if (r==true)
	{
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			  {
			  alert ("Your browser does not support AJAX!");
			  return;
			 }
			
			
			var submit6 = "auto_fill";
			var url="Cart_Processor.php";
			parameters="auto_fill="+submit6;
			xmlHttp.onreadystatechange=stateChanged33;
			xmlHttp.open("POST",url,true);
			xmlHttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xmlHttp.send(parameters);
	}

}
/*THIS DELETE ITEM FROM CART*/
function delete_Cart(p)
{
	//alert(p);
	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			  {
			  alert ("Your browser does not support AJAX!");
			  return;
			 }
			
			
			var submit2 = "delete";
			var url="Cart_Processor.php";
			parameters="delete_item="+submit2+"&course="+p;
			xmlHttp.onreadystatechange=stateChanged33;
			xmlHttp.open("POST",url,true);
			xmlHttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xmlHttp.send(parameters);
} 

//THIS UPDATE THE QUANTITY OF ITEM ON STACK
function update_Cart(p)
{
	var new_quantity = document.getElementById(p).value;
	if(new_quantity >0)
	{
	//alert(p);
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			  {
			  alert ("Your browser does not support AJAX!");
			  return;
			 }
			
			
			var submit1 = "update";
			var url="Cart_Processor.php";
			parameters="update_item="+submit1+"&goods_id="+p+"&new_quantity="+new_quantity;
			xmlHttp.onreadystatechange=stateChanged33;
			xmlHttp.open("POST",url,true);
			xmlHttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xmlHttp.send(parameters);
	}else{
		alert("Quantity Cant Be less than or equal Zero (0) And Empty as well");
	}
}
/*THIS PROCESS ADDING ITEM TO CART*/
function Add_to_Cart()
{
			var course = document.getElementById('txtcourse').value;
		if (course != "")
		{
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			  {
			  alert ("Your browser does not support AJAX!");
			  return;
			 }
			
			
			var submit4 = "add";
			var url="Cart_Processor.php";
			parameters="add_item="+submit4+"&course="+course;
			xmlHttp.onreadystatechange=stateChanged33;
			xmlHttp.open("POST",url,true);
			xmlHttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xmlHttp.send(parameters);

	}
}



function stateChanged33() 
{ 
	if (xmlHttp.readyState==4)
	{ 
		var re= xmlHttp.responseText;
		if(re=="Wrong Code"){
			document.getElementById("txtcourse").style.border="solid red";
		}else{
		document.getElementById('course_reg_div').innerHTML="";
		document.getElementById('course_reg_div').innerHTML=xmlHttp.responseText;
					document.getElementById("txtcourse").style.border="";
		}
	}
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
