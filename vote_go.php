<?php
require_once('VoteDB.php');

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
$help_msg = "To Vote for your Favourite Contestant on
Reality TV Show, Send #number to 55330. To see all contestants, send 'list' to 55300. SMS costs N10 only.";
$myMsg  = strip_tags(strtolower($Message));
$num = (int)$myMsg;
$parts = preg_split('/[\s,]+/', $myMsg);



##########################
// Valid Numbers
$ValidNumbers = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);
$ValidKeywords = array("help");
############################
// The Votes Manager a.k.a Chairman...lol
$VoteManager = new VoteDB;

##########################
	if ($rec == 55330) {
		// Check For 'help' message
		if (in_array('help',$my_parts) !== false) {
		    echo $help_msg;
		    exit();
		}
		if (in_array('list',$my_parts) !== false) {
			  $contestants = $VoteManager->get_all_contestants();
			  $output = "";
			  foreach ($contestants as $contestant) {
			    $output .= "$contestant[id]-$contestant[name],";
			  }
			    $output = rtrim($output, ",");
			    $output .=".";
			    echo $output;
					exit();
		}
		if(in_array($num, $ValidNumbers)){
			$now = date('Y-m-d h:i:sa', time());
		  $data = array(
		        "phone" => $Source,
		        "contestant_id" =>$num,
		        "vote_time" => $now,
		            );
		    $VoteManager->save_vote($data);
		    $contestant = $VoteManager->get_contestant_name($num);
		    $Ucontestant = ucwords(strtolower($contestant));
		    $success_msg = "You have successfully voted for $contestant.
		    Keep voting to ensure victory for $Ucontestant. To get help info, send 'help' to 55330";
				echo $success_msg;
		}else{
			echo "That was an invalid Vote. Send 'help' to get more information.";
		}





	}





?>
