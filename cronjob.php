<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Africa/Lagos");

require_once('includes/session.php');
//require_once('includes/functions_base.php');
require_once('libs/PoolDB.php');
//

// $timezone = date_default_timezone_get();
// echo "The current server timezone is: " . $timezone;
$date = date('Y-m-d H:i:s', time());
echo "<br> The current date is: ".$date;

$PoolManager = new PoolDB;
$data = array("status" => "active");
echo "<br> The current data['status'] is: ";
var_dump($data);
$ActivePools = $PoolManager->get_active_pools($data);
echo "<br> The current active pools are: ";
var_dump($ActivePools);

if((count($ActivePools) > 0) && ($ActivePools != false)){
  foreach ($ActivePools as $ActivePool) {
    # code...
    if($date > $ActivePool['start_date']){// Pool has started...
      $ActivePool['status'] = "completed";
      $data = array(
        "id" => $ActivePool['id'],
        "status" => "completed"
      );
      $PoolManager->update_pool($data);
      $PoolManager->convert_bet_predictions($ActivePool['id']);
      $PoolManager->set_winning_bets($ActivePool['id']);
      var_dump($ActivePool);
    }
  }

}
?>
