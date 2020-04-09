
function openloader(){
    document.getElementById("result2").innerHTML ='<img src="../store_files/images/loader.gif" class="img-responsive" alt="Uploading...."/>';
}
function closeloader(){
    document.getElementById("result2").innerHTML ='';
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

function write_data() 
{
	var data_file=document.getElementById("desc").innerHTML;
	document.getElementById("g_description").value=data_file;
}

/*THIS DELETE ITEM FROM CART*/
function delete_Cart(p,q)
{
	//alert(q);
	var message = "Are You sure You Want to Remove \n" + q + " .. \n From your Store Goods List...?";
	var r=confirm(message);
	if (r==true)
	{
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			  {
			  alert ("Your browser does not support AJAX!");
			  return;
			 }
			
			openloader();
			var submit2 = "delete";
			var url="Admin_Cart_Processor.php";
			parameters="delete_item="+submit2+"&goods_id="+p+"&goods_name="+q;
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
		closeloader();
		var message_two = xmlHttp.responseText +" ... \n was Remove From Store Succesfully!!";
		alert(message_two);
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

//change of sates and department begin here
    function byId(e)
    {
        return document.getElementById(e);
    }

    function emptyCombo(e)
    {
        e.innerHTML = '';
    }

function schoolComboChange()
    {
        var combo3 = byId('faculty');
        var combo4 = byId('department');
	  //alert(combo3.value);

        emptydeptCombo(combo4);
        switch(combo3.value)
        { 
            case 'Select Faculty':  addDeptOption(combo4,  'Select Department', 'Select Department');
                        break;
            case 'Bussiness Studies':  addDeptOption(combo4, 'Accountancy', 'Accountancy');
                        addDeptOption(combo4, 'Bussiness Studies', 'Bussiness Studies');
                        addDeptOption(combo4, 'Marketing', 'Marketing');
                        addDeptOption(combo4, 'Office Tech and Mgment', 'Office Tech and Mgment');
						addDeptOption(combo4,'Library Management', 'Library Management');
                        break;
			case 'Agriculture':  addDeptOption(combo4, 'Agricultual Science', 'Agricultual Science');
                        addDeptOption(combo4, 'Botany', 'Botany');
                        break;
            case 'Science':  addDeptOption(combo4, 'Computer Science', 'Computer Science');
                        addDeptOption(combo4, 'Mathematics', 'Mathematics');
                        addDeptOption(combo4, 'Industrial Chemistry', 'Industrial Chemistry');
                        addDeptOption(combo4, 'Microbiology', 'Microbiology');
                        addDeptOption(combo4, 'Physics', 'Physics');
                        addDeptOption(combo4, 'Zoology', 'Zoology');
                        
                        break;
            case 'Engineering':  addDeptOption(combo4, 'Civil Engineering', 'Civil Engineering');
                        addDeptOption(combo4, 'Elect/Elect Engineering', 'Elect/Elect Engineering');
                        addDeptOption(combo4, 'Mechanical Engineering', 'Mechanical Engineering');
                        addDeptOption(combo4, 'Metallurgical Engineering', 'Metallurgical Engineering');
                        addDeptOption(combo4, 'Agricultural Engineering', 'Agricultural Engineering');
						addDeptOption(combo4, 'Computer Engineering', 'Computer Engineering');
                        break;
            case 'Environmental Studies':  addDeptOption(combo4, 'Architectural Technology', 'Architectural Technology');
                        addDeptOption(combo4,'Building Technology', 'Building Technology');
                        addDeptOption(combo4, 'Estate Management', 'Estate Management');
                        addDeptOption(combo4, 'Surveying and Geo-Informatics', 'Surveying and Geo-Informatics');
                        addDeptOption(combo4, 'Quantity Surveying', 'Quantity Surveying');
                        addDeptOption(combo4, 'Urban and Regional Planning', 'Urban and Regional Planning');
                        break;
        }
        //cityComboChange();
    }
    function emptydeptCombo(e)
    {
        e.innerHTML = '';
    }
 
    function addDeptOption(combo, val, txt)
    {
        var option = document.createElement('option');
        option.value = val;
        option.title = txt;
        option.appendChild(document.createTextNode(txt));
        combo.appendChild(option);
    }