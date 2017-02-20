<?php
date_default_timezone_set("Africa/Lagos");
require_once('libs/MysqliDb.php');
class VoteDB extends MysqliDb{

    public $username = "root";
    public $password = "emlinux88";
    public $db = "_app_voting";
    protected $host = "localhost";

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
    $oneAdmin = $this->rawQuery('SELECT * from admin where username = ? and password= ?', $cols);
      if(count($oneAdmin) > 0){
        //Admin record found!
        return true;
      }else{
        return false;
      }
  }
  #########################
  #All Contestants
  public function get_all_contestants(){
    return $this->get("contestants");
  }
  #########################
  #Contestant's Name, given the Unique id
  public function get_contestant_name($id){
    $cols = array(
            "id" =>$id,
            );
    $contestant = $this->rawQuery('SELECT name from contestants where id = ? ', $cols);
    return $contestant[0]['name'];
  }
  ##############################
  #Total Contestants Daily Votes
  public function get_contestant_daily_votes($contestant_id){
    $cols = array(
            "contestant_id" =>$contestant_id,
            // "interval" =>1,
            );
    $sql = 'SELECT * from votes where contestant_id = ?  and DATE_FORMAT(votes.vote_time, \'%Y-%m-%d\') = CURDATE() ';
    $dailyVotes = $this->rawQuery($sql, $cols);
    return $this->count;
  }
  #########################
  #Total Votes Today
  public function get_contestant_total_votes($contestant_id){
    $cols = array(
            "contestant_id" =>$contestant_id,
            );
    $totalVotes = $this->rawQuery('SELECT * from votes where contestant_id = ? ', $cols);
    return $this->count;
  }
#########################
#Total Votes
  public function get_total_votes($contestant_id){
    $this->get("votes");
    return $this->count;
  }
  #########################
  #Total Unique Voters
  public function get_total_unique_votes($contestant_id){
    $sql = 'SELECT distinct phone from votes';
    $this->rawQuery($sql, $cols);
    return $this->count;
  }
  #########################
  #Total Votes Today
  public function get_total_daily_votes(){
    $cols = array(
            // "interval" =>1,
            );
    // $sql = 'SELECT * from votes where vote_time > DATE(NOW()) - INTERVAL ? DAY ';
    $sql = 'SELECT * from votes where DATE_FORMAT(votes.vote_time, \'%Y-%m-%d\') = CURDATE() ';
    $this->rawQuery($sql, $cols);
    return $this->count;
  }

  #########################
  #Save Votes
  public function save_vote($data){
    // $now = date('Y-m-d h:i:sa', time());
    // $data = array(
    //       "phone" => "admin",
    //       "contestant_id" =>4,
    //       "vote_time" => $now,
    //           );
    $this->insert('votes', $data);
    // if($id){
    //   return "Vote Has Been Saved!";
    // }else{
    //   return "Vote Was Not Saved!";
    // }
  }

  #########################
  #Save Votes
  public function log_sms($data){
    // $now = date('Y-m-d h:i:sa', time());
    // $data = array(
    //       "phone" => "admin",
    //       "contestant_id" =>4,
    //       "vote_time" => $now,
    //           );
    $id = $this->insert('logs', $data);
    if($id){
      return true;
    }else{
      return false;
    }
  }

}


?>
