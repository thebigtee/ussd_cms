<?php

define("user", "root");
define("pass", "Control123");
define("db", "sports");
define("host", "localhost");
#variables defined outside function to make them global
$Message = rtrim($_GET['text']);
$parts = preg_split('/[\s,]+/', $Message);
$number = $_GET['sender'];
#$number = '2348181856599';
#$Message="Che";
$spec = substr($number, -10);
$Source = '+234' . substr($number, -10);
$rec = $_GET['rec'];
#$rec =747;
$to = $_GET['to'];
$wmsg = "";
$stop_msg = "";
$help_msg = "";
$bill =0;
$cate = "";
$loopout = 0;
$msg = explode(",",$Message);
$uat =0;
$groups = "";
$dbc = mysqli_connect(host, user, pass, db)
        or
        die(mysqli_error($dbc));

#### deifine functions
function check($msg, $mobile) {
    global $groups, $wmsg, $stop_msg, $help_msg, $cate, $dbc,$uat,$bill,$rec;
	
    $qcheck = "select * from services where (active =1 or active =2) and s$rec=1";
   # echo $qcheck;		
    $result_check = mysqli_query($dbc, $qcheck) or die("An error has occured1");
    $loopout = 0;

    while ($row = mysqli_fetch_array($result_check)) {

        $check = explode(",", $row['alias']);
        foreach ($check as $checked) {

            if ($checked == $msg) {
                $loopout = 1;
                $wmsg = $row['wel_msg'];
                $stop_msg = $row['stop_msg'];
                $help_msg = $row['help_msg'];
                $cate = $row['keyword'];
                $uat = $row['uat'];
		$groups = $row['groups'];
                break;
            }
        }

        if ($loopout == 1)
            break;
    }
    if ($loopout == 1) {
        $qsub = " select * from sub where (active =1 or active =2) and cancled = 0 and num like '%$mobile%' and cate = '$cate' and free = '$bill'";

        $result_sub = mysqli_query($dbc, $qsub);
        $num = mysqli_num_rows($result_sub);
        If ($num > 0) {
            #2 means already registered
            return 2;
        } else {
            #means a valid keyword was set
            return 3;
        }
    } else {
        #1 means an invalid keyword was sent
        return 1;
    }
}
#end of function check
function stopall($mobile) {
    global $dbc,$spec;
#unsub from 86
    $query_86_upd = "update sub set cancled = 1, active = 0,deactivation_date = now(), deactivation_method = 'KEYWORD' where num like '%$mobile%'";
    mysqli_query($dbc, $query_86_upd) or die("an error has occured2");
#unsub from 98 voaeti
    $dbc_98 = mysqli_connect("208.109.186.98", "root", "Control123", "voaeti")
            or
            die(mysqli_error($dbc_98));
;        
    $query_98_upd = "update sub set cancled = 1, active = 0,deactivation_date = now(), deactivation_method = 'KEYWORD' where num like '%$mobile%'";
    $result_98_upd = mysqli_query($dbc_98, $query_98_upd) or die("an error has occured3");

#unsubs  from 98 talksports
    mysqli_select_db($dbc_98, "talksport");
    $result2_98 = mysqli_query($dbc_98, $query_98_upd) or die("an error has occured4");
    mysqli_close($dbc_98);
#Etras
$rest = mysqli_query($dbc,"select * from promo_base_list");
while($row=mysqli_fetch_array($rest)){
$name = $row['table_name'];
$rest2 = mysqli_query($dbc,"delete from $name where num like '%$spec%' limit 1");
 		
}
}
#end of function stop all
#initialiase  short codes


$ins = strtolower($Message);
    $key = str_replace('stop ','', $ins);
  #  echo $key;
 #  echo strlen($key); 
   $keyword = strtolower($key);
    if($rec==747) {
    $bill = 5475;
    }
    elseif($rec==38747){
    $bill =35747;
    }
   elseif($rec == 67601){
    $bill =67601;
   }

// Begining of confirmation script.... federal republic of spagetti code
    if(strtolower($keyword)=='yes'){
	$pending_query = "select * from sub where active = 0 and cancled = 0 and num = '$Source' and confirm_sub = 'no' limit 1";
	$pendingresult = mysqli_query($dbc, $pending_query);
	$num_count = mysqli_num_rows($pendingresult);
	if($num_count > 0){
	// we have a winner
	$prow=mysqli_fetch_array($pendingresult);
	$pcate = $prow['cate'];
	$psid = $prow['id'];
	$update_pend = "update sub set active = 1, confirm_sub = 'yes' where id = $psid limit 1";
	mysqli_query($dbc,$update_pend);
	
	check($pcate, $Source);

	if ($rec == 38747) {
	$bill = 35747;
	$day = 7;
	$msg = "Your $wmsg\Audio Subscription is successful. The service would be renewed for N100/week. Text STOP $pcate to 38747 to opt-out anytime.";
	echo $msg;
	$bill_msg = "Hello you have been charged N100 for $wel_msg for 7days to unsubscribe text STOP to 38747 ";
	$send = "http://localhost:13013/cgi-bin/sendsms?username=tester&password=foobar&text=".urlencode($bill_msg)."&from=35747&to=".$Source
	."&smsc=precin2&pid=64&dlr-mask=31&dlr-url=".urlencode("http://localhost/dlrnew.php?status=%d&sid=$psid");
	file_get_contents($send);
	} elseif ($rec == 747) {
	$bill = 5475;
	$day = 7;
	$msg = "Your subscription for the $wmsg was successful. The service cost N75/7 days.For how to unsubscribe, text help to 747.";
	echo $msg;
	$bill_msg = "Hello you have been charged N75 for $wel_msg for 7days to unsubscribe text STOP to 747 ";
	$send = "http://localhost:13013/cgi-bin/sendsms?username=tester&password=foobar&text=".urlencode($bill_msg)."&from=5475&to=".$Source
	."&smsc=precin2&pid=64&dlr-mask=31&dlr-url=".urlencode("http://localhost/dlrnew.php?status=%d&sid=$psid");
	file_get_contents($send);
	}
	}
	else
	echo "Dear Subscriber, you dont have any pending subscription. Thank you";

	die();
   }

// End of confirmation script
	
    $bot = check($keyword, $Source);



if ($rec == 38747) {
    $bill = 35747;
    $day = 7;
    $msg = "Dear user, the keyword $keyword has been received kindly reply 'YES' to confirm your subscription to $wmsg at N100/wk";
} elseif ($rec == 747) {
    $bill = 5475;
    $day = 7;
    $msg = "Dear user, the keyword $keyword has been received kindly reply 'YES' to confirm your subscription to $wmsg at N75/wk";
}


if (count($msg) >1)
 {
     $content = 'comma seprated';
 }
 elseif (count($parts) >=1)
 {
     $content = 'spaced';
     
 }
 

$sql = "insert into transactionstest (source,message,date,keyword,shortcode) values ('$Source','$Message',now(),'$keyword','$to')";
$result = mysqli_query($dbc, $sql) or die(mysql_error());

if ($content == 'spaced') {
    

    if(strtolower($parts[0]) == 'stop' && strtolower($parts[1]) == NULL){
        stopall($Source);
        echo "You have been successfully unsubscribed from All Services.To susbscribe again text SERVICE KEYWORD to $rec";
    }
    elseif(strtolower($parts[0]) == 'stop' && strtolower($parts[1]) != NULL){
               
            $res = mysqli_query($dbc, "update sub set active = 0,cancled = 1,deactivation_date = now(), deactivation_method = 'KEYWORD' where num like '%$Source%' and cate = '$cate' and free = '$bill'");
            $aff = mysqli_affected_rows($dbc);
            if ($aff >= 1) {
                echo "You have successfully opted out of $wmsg service.To subscribe again text $keyword to $rec";
            } else {
                echo"You are not subscribed to $wmsg " ;
            }
        
            
        }
      elseif(strtolower($parts[0]) == 'help' || $bot==1){
          if($rec==747){
            echo "TO subscribe for SPORTS ALERT(A) text CLUB NAME to 747, for BETTING TIPS (B) text BT to 747 cost N75/7 days";
          }
           else  {
               echo "Welcome.Text your Premier League Club or top European Club name to $rec,and get team news,breaking news and live match alerts e.g text ars for Arsenal news.";
                }
     }
    
 
       
 
    elseif($bot == 2) {
        echo "Dear subscriber you are already subscribed to $wmsg Kindly text another keyword to subscribe for another service";
    } 
    elseif ($bot == 3){
       $sql4 ="insert into newsubs (num,tdate,x1,cate) values('$Source',now(),'$gid','$cate')";
       $result4=mysqli_query($dbc,$sql4) or die(mysqli_error($dbc));
   	//echo $msg;   
        
        if($uat ==1)
        {
       # $sql3 = "insert into sub (bdate,num,cate,sdate,edate,active,cancled,free,rn) values(now(),'$Source','$cate',now(),NOW() - INTERVAL 2 DAY,'2','0','$bill','0')";
       # $result3 = mysqli_query($dbc, $sql3) or die(mysqli_error($dbc));
       # $gid=mysqli_insert_id($dbc);

        # echo "Hello your susbscription to  $wel_msg was successful. The service cost N75/7 days.For how to unsubscribe text HELP to 747.";
         $bmsg="Hello, you have been charged N75 for BETTING TIPS service for 7 days. To unsubscribe text STOP to 747.";

         $send="http://localhost:13013/cgi-bin/sendsms?username=tester&password=foobar&text=".urlencode($bmsg)."&from=5475&to=".$Source."&smsc=precin2&dlr-mask=31&dlr-url=".urlencode("http://localhost/uatreg.php?source=$Source&stat=%d&cate=$cate&msg=$wmsg"); 
           file_get_contents($send);
           $sql3 = "insert into sub (bdate,num,cate,sdate,edate,active,cancled,free,rn,groups) values(now(),'$Source','$cate',now(),NOW() - INTERVAL 2 DAY,'2','0','$bill','1','$groups')";
        
        }
          
	else
        {
        $sql3 = "insert into sub (bdate,num,cate,sdate,edate,active,cancled,free,rn,groups,confirm_sub) values(now(),'$Source','$cate',now(),NOW() - INTERVAL 1 DAY,'0','0','$bill','1','$groups','no')";
        $result3 = mysqli_query($dbc, $sql3) or die(mysqli_error($dbc));
        $gid=mysqli_insert_id($dbc);
        echo $msg;
      //  file_get_contents($send);
        
       }
        
    } 

}
 
 if ($content =='comma seprated')
 {
     ###yellow pages
     if (strtolower($msg[0]) =='yp' && $rec ==38747){
         $con2=mysqli_connect("208.109.176.184","ypng","Control123","ypng");
            $err_msg = 'You have enetered an invalid category. Kindly text a valid category to 5475 and get maximum exposure for your business'; 
            $keyword = $msg[0];
            $name = $msg[1];
            $Address = $msg[2];
            $Area = $msg[3];
            $Category = ucfirst($msg[4]);
            $Description = $msg[5];
            $query_valid ="select * from vlif9_jdbusiness_categories where category_name = '$Category'";
            $result_valid = mysqli_query($con2,$query_valid) or die("An error has occured5");
            if(mysqli_num_rows($result_valid) == 0)
            {
             
             file_get_contents("http://127.0.0.1:13013/cgi-bin/sendsms?username=tester&password=foobar&to=".$Source."&text=".urlencode($err_msg)."&from=38747&smsc=precin");
            }
             
            else         
         {
$bill_msg = "entry received you have been charged N100";
$send="http://localhost:13013/cgi-bin/sendsms?username=tester&password=foobar&text=".urlencode($bill_msg)."&from=35747&to=".$Source
."&smsc=precin2&pid=64&dlr-mask=31&dlr-url=".urlencode("http://localhost/dlr_direct.php?status=%d&to=%P&from=%p&cate=yp&amt=100&yid=$id");
file_get_contents($send);
echo "Processing";
/*while ($row =mysqli_fetch_array($result_valid))
$id = $row['id'];         

mysqli_query($con2,"insert into vlif9_jdbusiness_listings (company_name,address1,city,category,company_description,state,created_by) values ('$name','$Address','$Area','$id','$Description',1,968)") or die("An error has occured on yp");
echo "Dear ".ucfirst($name)." your entry has been received and will be available for million of viewers on the yellow pages.Thank you.";
$listing_id =mysqli_insert_id($con2);
mysqli_query($con2,"insert into vlif9_jdbusiness_listings_categories (id,listing_id,category_id) values(0,'$listing_id','$id')") or die("An error has occured on yp");
*/
     }
 }
}
?>

