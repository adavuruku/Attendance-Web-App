<?php
function checkempty($field){
    // Sanitize user name
	if(empty($field)){
		return FALSE;
	}
	else{
	 return $field;
	}
} 

//email
function filterEmail($field){
    // Sanitize e-mail address
    $field = filter_var(trim($field), FILTER_SANITIZE_EMAIL);
    
    // Validate e-mail address
    if(filter_var($field, FILTER_VALIDATE_EMAIL)){
        return $field;
    }else{
        return FALSE;
    }
}
function checksize($field){
    // check string size
	$field = trim($field);
    $size = strlen($field);
    if($size >= 11){
        return $field;
    }else{
      return FALSE;
    }
}


function filterName($field){
    // Sanitize user name
    $field = filter_var(trim($field), FILTER_SANITIZE_STRING);
    
    // Validate user name
    if(filter_var($field, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+/")))){
        return $field;
    }
	else
	{
        return FALSE;
    }
} 



//string
function filterString($field){
    // Sanitize string
    $field = filter_var(trim($field), FILTER_SANITIZE_STRING);
    if(!empty($field)){
        return $field;
    }else{
       return FALSE;
    }
}

//convert value to abu email
function turn_to_abu_mail($abumail)
{
	$final_result="";
	$k = strpos($abumail,"@");
	//check if user add @ sign
	if($k > 0)
	{
		$E = substr($abumail,$k);
		$final_result = strtolower(str_replace($E,"@abumail.com",$abumail));		
	}
	else
	{
		$final_result = strtolower($abumail."@abumail.com");
	}
	return $final_result;
}
?>