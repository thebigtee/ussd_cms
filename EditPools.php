<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('includes/session.php');
require_once('includes/functions_base.php');
require_once('libs/PoolDB.php');
confirm_logged_in();
$PoolManager = new PoolDB;
$teams = $PoolManager->get_all_teams();
$teams_output = "";
foreach ($teams as $team) {
  $teams_output .= "<option value=\"$team[id]\">$team[name]</option>";
}
// Get the Pool by the ID
$get_pool_id = (int)$_GET['p'];
$Pool = $PoolManager->get_pool($get_pool_id);
$fixtures = $PoolManager->get_fixtures($get_pool_id);
$pool_type_output="";
$pool_status_output="";
$ptype = (int)$Pool['type'];
$ptype_array = array('','Match Outcome','Goal Outcome');
for($i=1;$i<3;$i++){
  # code...
  if($i == $ptype){
    $pool_type_output .= "<option value=\"$ptype\" selected=\"selected\">$ptype_array[$i]</option>";
  }else{
    $pool_type_output .= "<option value=\"$i\">$ptype_array[$i]</option>";
  }
}

$pstatus = $Pool['status'];
$pstatus_array = array('','active','inactive','completed');
for($i=1;$i<4;$i++){
  # code...
  if($pstatus == $pstatus_array[$i]){
    $pool_status_output .= "<option value=\"".strtolower($pstatus_array[$i])."\" selected=\"selected\">".ucwords($pstatus_array[$i])."</option>";
  }else{
    $pool_status_output .= "<option value=\"".strtolower($pstatus_array[$i])."\">".ucwords($pstatus_array[$i])."</option>";
  }
}


// Submitting the Pools Form
if(isset($_POST['CPoolUpdate'])){
  //var_dump($_POST);
  $pname = filter_var($_POST['PName'], FILTER_SANITIZE_STRING);
  $ptype = filter_var($_POST['PType'], FILTER_SANITIZE_STRING);
  $pstatus = filter_var($_POST['PStatus'], FILTER_SANITIZE_STRING);
  $payout_amount = filter_var($_POST['PPAmount'], FILTER_SANITIZE_STRING);
  $num_of_fixtures = (int)filter_var($_POST['PNFixtures'], FILTER_SANITIZE_STRING);
  $winning_tiers = filter_var($_POST['PWinTiers'], FILTER_SANITIZE_STRING);
  $start_date = filter_var($_POST['PSDate'], FILTER_SANITIZE_STRING);
  $end_date = filter_var($_POST['PEDate'], FILTER_SANITIZE_STRING);
  $PResult = $PoolManager->get_pool_result($get_pool_id);
//
  $Pools_data = array(
    "id"   => $get_pool_id,
    "name" =>$pname,
    "type" =>$ptype,
    "status" =>$pstatus,
    "payout_amount" =>$payout_amount,
    "num_of_fixtures" =>$num_of_fixtures,
    "winning_tiers" =>$winning_tiers,
    "start_date" =>$start_date,
    "end_date" =>$end_date,
    "result" =>$PResult,
  );
  // var_dump($Pools_data);
  if($PoolManager->update_pool($Pools_data)){
    // echo "Pool has been updated!";

    // Fixtures Magic
     $home_team_name = 'HTName';
     $home_team_score = 'HTScore';
     $away_team_name = 'ATName';
     $away_team_score = 'ATScore';
     $fixture_date = 'FxDate';
     $fixture_outcome = 'FxOut';
     $fixture_comment = 'FxComm';
   //
     for($f=1;$f <= $num_of_fixtures;$f++){
       // echo "Fixture Counting Thru:".$f;
       $fx_htname  = (int)filter_var($_POST[$home_team_name.$f], FILTER_SANITIZE_STRING);
       $fx_atname  = (int)filter_var($_POST[$away_team_name.$f], FILTER_SANITIZE_STRING);
       $fx_htname = $PoolManager->get_team_name($fx_htname);
       $fx_atname = $PoolManager->get_team_name($fx_atname);
       $fx_data = array(
         "pool_id" => $get_pool_id,
         "priority" => $f."",
         "home_team" => $fx_htname,
         "home_team_score" => filter_var($_POST[$home_team_score.$f], FILTER_SANITIZE_STRING),
         "away_team" => $fx_atname,
         "away_team_score" => filter_var($_POST[$away_team_score.$f], FILTER_SANITIZE_STRING),
         "start_date" => filter_var($_POST[$fixture_date.$f], FILTER_SANITIZE_STRING),
         "outcome" => filter_var($_POST[$fixture_outcome.$f], FILTER_SANITIZE_STRING),
         "comments" => filter_var($_POST[$fixture_comment.$f], FILTER_SANITIZE_STRING)
       );

       $PoolManager->update_fixture($fx_data);
       //Set the Winning Bets now
       $PoolManager->set_winning_bets($get_pool_id);
      //  var_dump($fx_data);
       unset($Pool);
       $Pool = $PoolManager->get_pool($get_pool_id);

       // Send Feedback to User
       $title = "Success";
       $message = "The Pool has been successfully updated!";
       $feedback = "";
       $feedback .= "<div class=\"row\">";
       $feedback .= "<div class=\"col-sm-12 col-xs-12\">";
       $feedback .= "<div class=\"box box-success\">";
       $feedback .= "<div class=\"box-header with-border\">";
       $feedback .= "<h3 class=\"box-title\">$title</h3>";
       $feedback .= "<div class=\"box-tools pull-right\">";
       $feedback .= "<button type=\"button\" class=\"btn btn-box-tool\"";
       $feedback .= "data-widget=\"remove\">";
       $feedback .= "<i class=\"fa fa-times\"></i>";
       $feedback .= "</button>";
       $feedback .= "</div>";
       $feedback .= "</div>";
       $feedback .= "<div class=\"box-body\">";
       $feedback .= $message;
       $feedback .= "</div>";
       $feedback .= "</div>";
       $feedback .= "</div>";
       $feedback .= "</div>";

  }

}else {
  # code...
  // Send Feedback to User
  $title = "An Error Occured!";
  $message = "There was an error updating the Pool. Please try again later.";
  $feedback = "";
  $feedback .= "<div class=\"row\">";
  $feedback .= "<div class=\"col-sm-12 col-xs-12\">";
  $feedback .= "<div class=\"box box-success\">";
  $feedback .= "<div class=\"box-header with-border\">";
  $feedback .= "<h3 class=\"box-title\">$title</h3>";
  $feedback .= "<div class=\"box-tools pull-right\">";
  $feedback .= "<button type=\"button\" class=\"btn btn-box-tool\"";
  $feedback .= "data-widget=\"remove\">";
  $feedback .= "<i class=\"fa fa-times\"></i>";
  $feedback .= "</button>";
  $feedback .= "</div>";
  $feedback .= "</div>";
  $feedback .= "<div class=\"box-body\">";
  $feedback .= $message;
  $feedback .= "</div>";
  $feedback .= "</div>";
  $feedback .= "</div>";
  $feedback .= "</div>";

}


}

?>
<?php require_once('header.php'); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <section class="content">
          <?php if(!empty($feedback)) echo $feedback;?>
          <!-- form start -->
          <form accept-charset="utf-8" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?p=".$get_pool_id);?>" role="form">
          <!--Begin Pool Forms  -->
          <div class="row">

            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Pool Details</h3>
                </div>
                <!-- /.box-header -->


                  <div class="box-body">
                    <div class="form-group col-sm-4 col-xs-4">
                      <label for="PName" title="Enter Pool Name">Name</label>
                      <input
                      type="text" class="form-control" name="PName"id="PName"
                      placeholder="Enter Pool Name" value="<?php echo $Pool['name'];?>">
                    </div>
                    <div class="form-group col-sm-3 col-xs-3">
                      <label>Pool Type</label>
                      <select name="PType" class="form-control">
                        <option value="">--- Select Pool Type ---</option>
                        <?php echo $pool_type_output;?>
                      </select>
                    </div>
                    <div class="form-group col-sm-3 col-xs-3">
                      <label>Pool Status</label>
                      <select name="PStatus" class="form-control">
                        <option value="">--- Select Pool Status ---</option>
                        <?php echo $pool_status_output;?>
                      </select>
                    </div>
                    <div class="form-group col-sm-2 col-xs-2">
                      <label for="PNFixtures" title="Number Of Fixtures">Number Of Fixtures</label>
                      <input
                      type="number" class="form-control" class="PNFixtures" id="PNFixtures"
                      name="PNFixtures" readonly="readonly" min="1" max="12" value="<?php echo $Pool['num_of_fixtures'];?>">
                    </div>
                    <div class="form-group col-sm-3 col-xs-3">
                      <label for="PWinTiers" title="Pool Winning Tiers">Winning Tiers</label>
                      <input
                      type="text" class="form-control" id="PWinTiers" name="PWinTiers"
                      placeholder="Enter Number Of Winners" value="<?php echo $Pool['winning_tiers'];?>">
                    </div>
                    <div class="form-group col-sm-3 col-xs-3">
                      <label for="PPAmount" title="Pool Payout Amount">Payout Amount</label>
                      <input
                      type="text" class="form-control" id="PPAmount" name="PPAmount"
                      placeholder="Enter Payout Amount" value="<?php echo $Pool['payout_amount'];?>">
                    </div>
                    <div class="form-group col-sm-3 col-xs-3">
                    <label for="PSDate" title="Pool Start Date">Start Date:</label>

                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" name="PSDate"
                        class="form-control DatetimeGame pull-right"
                        id="datepicker_start" value="<?php echo $Pool['start_date'];?>">
                      </div>
                      <!-- /.input group -->
                    </div>
                    <div class="form-group col-sm-3 col-xs-3">
                    <label for="PEDate" title="Pool Start Date">End Date:</label>

                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" name="PEDate"
                        class="form-control DatetimeGame pull-right"
                        id="datepicker_end" value="<?php echo $Pool['end_date'];?>">
                      </div>
                      <!-- /.input group -->
                    </div>
                  </div>
                  <!-- /.box-body -->

                  <div class="box-footer">
                    <p>
                      Pool Information
                    </p>
                  </div>
              </div>
              <!-- /.box -->

            </div>

            <!--Fixtures Box  -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Fixtures</h3>
                </div>
                <!-- /.box-header -->
                <!-- The Fixtures Input start -->
                <div class="box-body">
                  <div class="fixtureBlock" id="fixtureBlock" >
                    <!--Begin Fixture Row  -->
                    <?php
                    unset($fixtures);
                    $fixtures = $PoolManager->get_fixtures($get_pool_id);
                    // var_dump($fixtures);
                    $counter = 1;
                    $fixture_output = "";
                    if(count($fixtures) > 0){
                      if($fixtures){
                        foreach($fixtures as $fixture){
                          $fixture_output .= "<div class=\"fixtureRow\">";
                          $fixture_output .= "<div class=\"row\">";
                          $fixture_output .= "<div class=\"col-sm-2 col-xs-2\">";
                          $fixture_output .= "<div class=\"form-group\">";
                          $fixture_output .= "<select name=\"HTName".$counter."\"class=\"form-control TeamHomeId\"";
                          $fixture_output .= "title=\"Home Team\" placeholder=\"Home Team\">";
                          $fixture_output .= "<option>---Select Team---</option>";
                          foreach ($teams as $team) {
                            $fixture_output .= "<option value=\"$team[id]\">$team[name]</option>";
                            if($fixture['home_team'] == $team['name']){
                              $fixture_output .= "<option selected=\"selected\" value=\"$team[id]\">$team[name]</option>";
                            }
                          }
                         $fixture_output .= "</select>" ;

                         $fixture_output .= "</div>" ;
                         $fixture_output .= "</div>" ;
                         $fixture_output .= "<div class=\"col-md-1\">" ;
                         $fixture_output .= "<div class=\"form-group\">" ;
                         $ht_score       = $fixture['home_team_score'];
                         $fixture_output .= "<input name=\"HTScore".$counter."\"type=\"text\"";
                         $fixture_output .= "class=\"form-control ScoreHome\" ";
                         $fixture_output .= "title=\"Home Team Score\" placeholder=\"Home Team Score\"";
                         $fixture_output .= "value=\"$ht_score\">" ;
                         $fixture_output .= "</div>" ;
                         $fixture_output .= "</div>" ;
                         $fixture_output .= "<div class=\"col-md-2\">" ;
                         $fixture_output .= "<div class=\"form-group\">" ;
                         $fixture_output .= "<select name=\"ATName".$counter."\" class=\"form-control TeamAwayId\"";
                         $fixture_output .= "title=\"Away Team\" placeholder=\"Away Team\">";
                         $fixture_output .= "<option value=\"\">---Select Team---</option>" ;
                           foreach($teams as $team) {
                             $fixture_output .= "<option value=\"$team[id]\">$team[name]</option>";
                             if($fixture['away_team'] == $team['name']){
                               $fixture_output .= "<option selected=\"selected\"value=\"$team[id]\">$team[name]</option>";
                             }
                           }
                         $fixture_output .= "</select>" ;
                         $fixture_output .= "</div>" ;
                         $fixture_output .= "</div>" ;
                         $fixture_output .= "<div class=\"col-md-1\">" ;
                         $fixture_output .= "<div class=\"form-group \">" ;
                         $at_score       = $fixture['away_team_score'];
                         $fixture_output .= "<input name=\"ATScore".$counter."\" type=\"text\" class=\"form-control ScoreAway\"";
                         $fixture_output .= "title=\"Away Team Score\" placeholder=\"Away Team Score\"" ;
                         $fixture_output .= "value=\"$at_score\">" ;
                         $fixture_output .= "</div>" ;
                         $fixture_output .= "</div>" ;
                         $fixture_output .= "<div class=\"col-md-2\">" ;
                         $fixture_output .= "<div class=\"form-group\">" ;
                         $fixture_output .= "<input name=\"FxDate".$counter."\" id=\"FxDate".$counter."\" type=\"text\" class=\"form-control DatetimeGame\"";
                         $fixture_output .= "title=\"Game Date\" placeholder=\"Game Date\"";
                         $fixture_output .= " value=\"$fixture[start_date]\">";
                         $fixture_output .= "</div>" ;
                         $fixture_output .= "</div>" ;
                         $fixture_output .= "<div class=\"col-md-2\">" ;
                         $fixture_output .= "<div class=\"form-group\">" ;
                         $fixture_output .= "<select name=\"FxOut".$counter."\" class=\"form-control Outcome\" title=\"Outcome\" placeholder=\"Outcome\">";
                         $fixture_output .= "<option value=\"0\">Select</option>" ;
                         $foutcome = (int)$fixture['outcome'];
                         $foutcome_array = array('','Home Win','Draw','Away Win');
                         for($a=0;$a<4;$a++){
                           # code...
                           if($foutcome == $a){
                             $fixture_output .= "<option value=\"".$a."\" selected=\"selected\">".ucwords($foutcome_array[$a])."</option>";
                           }else{
                             $fixture_output .= "<option value=\"".$a."\">".ucwords($foutcome_array[$a])."</option>";
                           }
                         }
                         $fixture_output .= "</select>" ;
                         $fixture_output .= "</div>" ;
                         $fixture_output .= "</div>" ;
                         $fixture_output .= "<div class=\"col-md-2\">";
                         $fixture_output .= "<div class=\"form-group\">";
                         $fixture_output .= "<input name=\"FxComm".$counter."\" type=\"text\" class=\"form-control Comment\"";
                         $fixture_output .= "title=\"Comment\" placeholder=\"Comment\"";
                         $fixture_output .= "value=\"$fixture[comments]\"";
                         $fixture_output .= "</div>" ;
                         $fixture_output .= "</div>" ;
                         $fixture_output .= "</div>" ;
                         $fixture_output .= "</div>";


                         $counter++;
                        }

                      }else{
                          $fixture_output = "";
                      }

                    }


                    ?>
                    <?php echo $fixture_output;?>
                    <!--End Of Fixture Row  -->
                    </div>
                </div>
                <!-- /.box-body -->

                  <div class="box-footer">
                    <button name="CPoolUpdate" type="submit" class="btn btn-primary">Submit</button>
                  </div>
              </div>
              <!-- /.box -->

            </div>


          </div>
          <!--  /.row-->
          </form>
          <!--End Pool Forms -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php require_once('footer.php'); ?>
