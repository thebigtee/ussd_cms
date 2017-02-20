<?php
date_default_timezone_set("Africa/Lagos");
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


function blast_message($smsc,$from,$tblname,$promomsg,$server,$dbname,$pool_id){

  $i=0;
  $tblname =$tblname;//Table to pick the numbers from ie <Bets>
  $from = $from; // 747 ie MyClub
  $smsc = $smsc; // precin
  $promomsg =$promomsg; // From PoolManager->get_message($data);
  $pool_id = (int)$pool_id;
  $server=$server; // 86 server ie 208.109.95.86
  $dbname=$dbname; // ussd_services
  $dbc = mysqli_connect($server, "root", "emlinux88",$dbname)
          or
          die("error connecting to database");
  // $query = "select distinct msisdn from " .$tblname;
  $query = "select distinct msisdn from Bets where winner=1"." and pool_id=".$pool_id;
  $result = mysqli_query($dbc, $query) or die("big error");

  $sip = "208.109.95.86";
  // $kannel_sender="http://208.109.95.86:13013/cgi-bin/sendsms?username=tester&password=foobar";
  // if($smsc == 'precin4' || $from == '38547')
	//    {$sip = "208.109.186.98";}

  while ($row = mysqli_fetch_array($result)) {
      $xml = new SimpleXMLElement(file_get_contents("http://$sip:13000/status.xml?password=password'"));
      $sms_store = $xml->sms->storesize;
      inner: $flag = 0;
      while ($sms_store >= 2000000) {

          $xml = new SimpleXMLElement(file_get_contents("http://$sip:13000/status.xml?password=password'"));
          $sms_store = $xml->sms->storesize;
          $sms_received = $xml->sms->received->total;
          $sms_sent = $xml->sms->sent->total;
          echo "sms sent = $sms_sent \n";
          echo "sms in store = $sms_store \n";
          echo "sms received = $sms_received \n";
          echo "Going into sleep mode to protect Kannel \n";
          sleep(60);
          unset($xml);
          $flag = 1;
          break;
        }
      if ($flag == 1)
       {goto inner;}

       $num = $row['msisdn'];
       //$rec_id = $row['id'];
       $i++;
   echo " Total message sent by blaster is $i \n ";
   echo "Message sent to $num\n";
   // Log the message to the sms_log table
   $promomsg = htmlentities(addslashes($promomsg));
   $date = date('Y-m-d H:i:s', time());
   $logit = "insert into sms_log(pool_id,sms,msisdn,sent_time) values(";
   $logit .= "'".$pool_id."',  ";
   $logit .= "'".$promomsg."',  ";
   $logit .= "'".$num."',  ";
   $logit .= "'".$date."')";
  //  echo $logit;
   mysqli_query($dbc, $logit) or die("Could not log the sms...".mysqli_error($dbc));
   echo file_get_contents("http://$sip:13013/cgi-bin/sendsms?username=tester&password=foobar&to=".$num."&text=" .urlencode($promomsg)."&from=$from&smsc=$smsc");

  unset($xml);
   }
  // unset($xml);
  // echo file_get_contents("http://$sip:13013/cgi-bin/sendsms?username=tester&password=foobar&to=2349093077609&text=" .urlencode($promomsg)."&from=$from&smsc=$smsc");
  // echo file_get_contents("http://$sip:13013/cgi-bin/sendsms?username=tester&password=foobar&to=2348184897653&text=" .urlencode($promomsg)."&from=$from&smsc=$smsc");
  // echo file_get_contents("http://$sip:13013/cgi-bin/sendsms?username=tester&password=foobar&to=2349084463381&text=" .urlencode($promomsg)."&from=$from&smsc=$smsc");
  mysqli_close($dbc);
  echo " Done sending\n";

  return true;
}









?>
