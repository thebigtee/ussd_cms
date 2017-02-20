<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Africa/Lagos");
require_once('MysqliDb.php');
class PoolDB extends MysqliDb{

    public $username = "root";
    public $password = "emlinux88";
    public $db = "ussd_services";
    protected $host = "localhost";
    // Server 208.109.95.86

  function __construct(){

      $this->connect();
  }
  public function authenticate_user($username, $password){
    // Does the user exist?
    $cols = array(
            "username" =>$username,
            "password" =>$password,
            );
    // $admins = $this->where($cols);
    $oneAdmin = $this->rawQuery('SELECT * from Admins where username = ? and password= ?', $cols);
      if(count($oneAdmin) > 0){
        //Admin record found!
        return true;
      }else{
        return false;
      }
  }
  #########################
  #All Pools
  public function get_all_pools(){
    return $this->get("Pools");
  }
  #########################
  #Get Pool by ID
  public function get_pool($Pool_ID){
    $Pool_ID = (int)$Pool_ID;
    $this->where("id", $Pool_ID);
    $Pool = $this->getOne("Pools");
    if(count($Pool) > 0){
      return $Pool;
    }else{
      return false;
    }
  }

  #########################
  #Get Pool Name by ID
  public function get_pool_name($Pool_ID){
    $Pool_ID = (int)$Pool_ID;
    $this->where("id", $Pool_ID);
    $Pool = $this->getOne("Pools");
    if(count($Pool) > 0){
      return $Pool['name'];
    }else{
      return false;
    }
  }
  #Get Pool Name by ID
  public function get_pool_type($Pool_ID){
    $Pool_ID = (int)$Pool_ID;
    $this->where("id", $Pool_ID);
    $Pool = $this->getOne("Pools");
    if(count($Pool) > 0){
      return $Pool['type'];
    }else{
      return false;
    }
  }
  #########################
  #All Fixtures Outcome based on Pool_ID
  public function get_all_fixtures_outcome($Pool_ID){
    $Pool_ID = (int)$Pool_ID;
    $cols = array(
            "pool_id" =>$Pool_ID,
            );
    $outcomes = $this->rawQuery('SELECT outcome from Fixtures where pool_id = ?  order by priority', $cols);
    if(count($outcomes) > 0){
      foreach ($outcomes as $outcome) {
        # code...
        $output .="".$outcome['outcome'];
      }
    }else{
      $output = "";
    }
    return $output;
  }
  #########################
  #Get Team Name, given the Unique id
  public function get_team_name($team_id){
    $team_id = (int)$team_id;
    $cols = array(
            "id" =>$team_id,
            );
    $names = $this->rawQuery('SELECT name from Teams where id = ?', $cols);
    $output ="";
    if(count($names) > 0){
        foreach ($names as $name) {
          $output .="".$name['name'];
        }
      }
    return $output;
  }
  #########################
  #Get All Team Names
  public function get_all_teams(){
    return $this->get("Teams");
  }
  ##############################
  #Get All Team Names Ordered by name
  public function get_all_teams_by_name(){
    return $this->rawQuery('SELECT * from Teams order by name asc');
  }

  #########################
  #Get Team by Id
  public function get_team($team_id){
    $this->where("id", $team_id);
    return $this->getOne("Teams");
  }

  #########################
  #Update Team
  public function update_team($data){
    $this->where('id', $data['id']);
    if ($this->update('Teams', $data)){
      return true;
    }else{
      return false;
    }
  }

  #########################
  #Check if Team Exists
  public function team_exists($team){
    $teams = $this->rawQuery("SELECT * from Teams where name='$team'");
    if(count($teams) > 0){
      return true;
    }else{
      return false;
    }
  }

  #########################
  #Check if Team Exists
  public function create_team($team){
    $cols = array(
          "name" => $team,
        );
    $id = $this->insert("Teams",$cols);
    if($id){
      return true;
    }else{
      return false;
    }
  }

  #########################
  #Delete Pool
  public function delete_team($team_id){
    $team_id = (int)$team_id;
    $this->where('id', $team_id);
    if($this->delete('Teams')){
      return true;
    }else{
      return false;
    }

  }
  #########################
  #Get All Team Names
  public function create_pool($data){
    $id = $this->insert("Pools",$data);
    if($id){
      return $id;
    }else{
      return false;
    }
  }
  #########################
  # Update Pool
  public function update_pool($data){
    $this->where('id', $data['id']);
    if ($this->update('Pools', $data)){
      return true;
    }else{
      return false;
    }

  }


  #########################
  # Get Active Pools
  public function get_active_pools($data){
    $this->where("status", $data['status']);
    $Pool = $this->get("Pools");
    if(count($Pool) > 0){
      return $Pool;
    }else{
      return false;
    }

  }

  #########################
  #Delete Pool
  public function delete_pool($pool_id){
    $pool_id = (int)$pool_id;
    $this->where('id', $pool_id);
    if($this->delete('Pools')){
      return true;
    }else{
      return false;
    }

  }
  #########################
  #Delete Fixtures
  public function delete_fixture($pool_id){
    $pool_id = (int)$pool_id;
    $this->where('pool_id', $pool_id);
    if($this->delete('Fixtures')){
      return true;
    }else{
      return false;
    }
  }
  ##########################
  #Create Fixture
  public function create_fixture($data){
    $id = $this->insert("Fixtures",$data);
    if($id){
      return true;
    }else{
      return false;
    }

  }
  #########################
  #All Pools
  public function get_fixtures($Pool_ID){
    $Pool_ID = (int)$Pool_ID;
    $cols = array(
          "pool_id" => $Pool_ID,
        );
    $fixtures = $this->rawQuery('SELECT * from Fixtures where pool_id = ? order by priority asc', $cols);
    if(count($fixtures) > 0){
      return $fixtures;
    }else{
      return false;
    }
  }

##########################
#Create Fixture
public function update_fixture($data){
  $this->where ("pool_id", $data['pool_id']);
  $this->where ("priority", $data['priority']);
    if($this->update("Fixtures",$data)){
      return true;
    }else{
      return false;
    }
}
#########################
#Get Pool Result
public function get_pool_result($Pool_ID){
  $Pool_ID = (int)$Pool_ID;
  $Pool = $this->get_pool($Pool_ID);
  $pool_type = (int)$Pool['type'];
  $cols = array(
        "pool_id" => $Pool_ID,
      );
  $fixtures = $this->rawQuery('SELECT * from Fixtures where pool_id = ? order by priority ', $cols);
  $output = "";
  // $Pool Type 1 = Match Outcome
  if($pool_type == 1){
      foreach ($fixtures as $fixture) {
        $outcome = (int)$fixture['outcome'];
        if($outcome == 1){
          $output .= "HW";
        }
        if($outcome == 2){
          $output .= "D";
        }
        if($outcome == 3){
          $output .= "AW";
        }
      }
  }elseif($pool_type == 2){
    foreach($fixtures as $fixture){
      $ht_score = (int)$fixture['home_team_score'];
      $at_score = (int)$fixture['away_team_score'];
      $goals = $ht_score + $at_score;
      $output .="G".$goals;
    }

  }
  $data = array(
    "id" => $Pool_ID,
    "result" => $output
  );
  $this->update_pool($data);
  return $output;
}
##################################
#Get All Bets
public function get_all_bets(){
  return $this->get("Bets");
}


##################################
#Get All Bets by Pool_ID
public function convert_bet_predictions($pool_id){
  $pool_id = (int)$pool_id;
  $Pool = $this->get_pool($pool_id);
  $pool_type = (int)$Pool['type'];
  $cols = array(
        "pool_id" => $pool_id,
      );
  $bets = $this->rawQuery('SELECT * from Bets where pool_id = ? and formatted=0', $cols);
  $bet_update = array();
  foreach ($bets as $bet) {
    # code...
    if($pool_type == 1){
      $prediction = preg_replace("(\,)", "", $bet['prediction']);
      $prediction = preg_replace("(1)", "HW", $prediction);
      $prediction = preg_replace("(2)", "D",  $prediction);
      $prediction = preg_replace("(3)", "AW", $prediction);

      $bet_update = array(
        "id" => $bet['id'],
        "result" => $prediction,
        "formatted" => 1
      );
      $this->update_bet($bet_update);

    }elseif($pool_type > 1){
      $prediction = $bet['prediction'];
      //Remove any spaces and the last "," if any
      $prediction = str_replace(' ', '', $prediction);
      $prediction = rtrim($prediction,", " );
      // Convert to Array by "," character
      $data = explode(",",$prediction);
      $output = "";
      foreach ($data as $datum) {
        # code...
        $output .= "G".$datum;
      }
      $bet_update = array(
        "id" => $bet['id'],
        "result" => $output,
        "formatted" => 1
      );
      $this->update_bet($bet_update);
    }
  }


}

#########################
#Update Bet
public function update_bet($data){
  $this->where('id', $data['id']);
  if ($this->update('Bets', $data)){
    return true;
  }else{
    return false;
  }
}
##################################
#Get Winning Bets
public function set_winning_bets($pool_id){
  $pool_id = (int)$pool_id;
  $Pool = $this->get_pool($pool_id);
  $pool_result = $this->get_pool_result($pool_id);
  $cols = array(
        "pool_id" => $pool_id,
        "result" => $pool_result,
      );
  $bets = $this->rawQuery('SELECT * from Bets where pool_id = ? and result = ? and formatted=1', $cols);
  if(count($bets) > 0){
    foreach ($bets as $bet) {
      # code...
      $data = array(
        "id" => $bet['id'],
        "winner" => 1,
      );
      $this->update_bet($data);
    }
  }

}

##################################
#Get Winning Bets
public function get_winning_bets($pool_id){
  $pool_id = (int)$pool_id;
  $Pool = $this->get_pool($pool_id);
  $pool_result = $this->get_pool_result($pool_id);
  $cols = array(
        "pool_id" => $pool_id,
        "result" => $pool_result
      );
  $bets = $this->rawQuery('SELECT * from Bets where pool_id = ? and result = ? and winner=1', $cols);
  if(count($bets) > 0){
    return $bets;
  }else{
    return false;
  }

}


##################################
#Get All Messages
public function get_all_messages(){
  return $this->get("Messages");
}

##################################
#Get All Messages
public function update_messages($data){
  $this->where('type', $data['type']);
  if ($this->update('Messages', $data)){
    return true;
  }else{
    return false;
  }
}


}


?>
