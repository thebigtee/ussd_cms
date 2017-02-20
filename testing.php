<?php
require_once('VoteDB.php');
// date_default_timezone_set("Africa/Lagos");
// $now = date('Y-m-d h:i:sa', time());
// var_dump($now);


$VoteManager = new VoteDB;
// $now = date('Y-m-d h:i:sa', time());
// $data = array(
//       "phone" => "080367843984",
//       "contestant_id" =>1,
//       "vote_time" => $now,
//           );
// $result = $VoteManager->save_vote($data);

##########################
// Valid Numbers
$ValidNumbers = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);
$ValidKeywords = array("help");

$Message = "110 31 2 3  heLP list";
echo "<br><br><hr>";
echo "Original Message: \n".$Message;
echo "<br><br><hr>";
$myMsg  = strtolower($Message);
$num = (int)$myMsg;
$my_parts = preg_split('/[\s,]+/', $myMsg);

// if (strpos($myMsg, 'help') !== false) {
//     echo 'Found in String';
// }else{
//   echo 'Not Found in Strrrring, Mtcheeww!';
// }
// echo "<br><br><hr>";
$now = date('Y-m-d h:i:sa', time());
$data = array(
      "phone" => "080367843984-log",
      "message" =>$myMsg,
      "time_sent" => $now,
          );
$VoteManager->log_sms($data);
if($id){

echo "Message Logged successfully";
echo "<br><br><hr>";
}else{

  echo "Log Failure!";
  echo "<br><br><hr>";
}

if (in_array('help',$my_parts) !== false) {
    echo 'Found in Array';
}else{
  echo 'Not Found in Array, Joor!';
}
echo "<br><br><hr>";

if (in_array('list',$my_parts) !== false) {
  $contestants = $VoteManager->get_all_contestants();
  $output = "";
  foreach ($contestants as $contestant) {
    $output .= "$contestant[id]-$contestant[name],";
  }
    $output = rtrim($output, ",");
    $output .=".";
    echo $output;
}
echo "<br><br><hr>";

if (in_array($num,$ValidNumbers) !== false) {
  $now = date('Y-m-d h:i:sa', time());
  $data = array(
        "phone" => "080367843984",
        "contestant_id" =>$num,
        "vote_time" => $now,
            );
    $VoteManager->save_vote($data);
    $contestant = $VoteManager->get_contestant_name($num);
    $Ucontestant = ucwords(strtolower($contestant));
    $success_msg = "You have successfully voted for $contestant.
    Keep voting to ensure victory for $Ucontestant. To get help info, send 'help' to 55330";

    echo 'Valid Vote!!';
    echo "<br><br><hr>";
    echo $success_msg;
  }else{
  echo "That was an invalid Vote. Send 'help' to get more information.";
}
echo "<br><br><hr>";

if (is_int($num) !== false) {
    echo 'Converted to Number: '.$num;
}else{
  echo 'Not Found in Array, Joor!';
}
echo "<br><br><hr>";

echo $myMsg;
echo "<br><br><hr>";
var_dump($my_parts);


?>
