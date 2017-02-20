<?php
$apply_active = array(
  "Pools"=>"",
  "Bets"=>"",
  "Teams"=>"",
  "Reports"=>"",
  "Messages"=>"",
);

function validate_fields($required_fields)
{
	$field_errors = array();
	foreach($required_fields as $fieldname)
	{

		if(!isset($_POST[$fieldname]) || (empty($_POST[$fieldname]) && !is_int($_POST[$fieldname])))
		{
			$field_errors[] = $fieldname;
		}
	}
	return $field_errors;
}

function redirect_to($location = NULL)
{
    if($location!=NULL)
    {
				header("Content-Type:text/html;charset=utf-8");
        header("location: {$location}");
        exit;
    }

}

function format_time($datetime, $format){
    $datetime = strtotime($datetime);
    return date($format, $datetime);
}

function format_for_sub($msisdn){
    return '+234' . substr($msisdn, -10);
}

function format_for_base($msisdn){
    return '+234' . substr($msisdn, -10);
}


function sanitize($input) {
    if (is_array($input)) {
        foreach($input as $var=>$val) {
            $output[$var] = sanitize($val);
        }
    }
    else {
        if (get_magic_quotes_gpc()) {
            $input = stripslashes($input);
        }
        $input  = cleanInput($input);
        $output = mysqli_escape_string($input);
    }
    return $output;
}

function cleanInput($input) {

  $search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
  );

    $output = preg_replace($search, '', $input);
    return $output;
  }

function set_active_page(){
	global $apply_active; //Important
	$current_page = $_SERVER['REQUEST_URI'];
	if($current_page == "/ussd/Reports.php"){
	  $apply_active['Reports'] = "active";
	}
	if($current_page == "/ussd/Bets.php"){
	$apply_active['Bets'] = "active";
	}
	if($current_page == "/ussd/Teams.php"){
	$apply_active["Teams"] = "active";
	}
	if($current_page == "/ussd/Pools.php"){
	$apply_active["Pools"] = "active";
	}
  if($current_page == "/ussd/Messages.php"){
	$apply_active["Messages"] = "active";
	}


}
set_active_page();












?>
