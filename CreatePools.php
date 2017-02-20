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
// Submitting the Pools Form
if(isset($_POST['CPool'])){
  // var_dump($_POST);
  $pool_id = "";
  $pname = filter_var($_POST['PName'], FILTER_SANITIZE_STRING);
  $ptype = filter_var($_POST['PType'], FILTER_SANITIZE_STRING);
  $pstatus = filter_var($_POST['PStatus'], FILTER_SANITIZE_STRING);
  $payout_amount = filter_var($_POST['PPAmount'], FILTER_SANITIZE_STRING);
  $num_of_fixtures = (int)filter_var($_POST['PNFixtures'], FILTER_SANITIZE_STRING);
  $winning_tiers = (int)filter_var($_POST['PWinTiers'], FILTER_SANITIZE_STRING);
  $start_date = filter_var($_POST['PSDate'], FILTER_SANITIZE_STRING);
  $end_date = filter_var($_POST['PEDate'], FILTER_SANITIZE_STRING);

  $Pools_data = array(
    "name" =>$pname,
    "type" =>$ptype,
    "status" =>$pstatus,
    "payout_amount" =>$payout_amount,
    "num_of_fixtures" =>$num_of_fixtures,
    "winning_tiers" =>$winning_tiers,
    "start_date" =>$start_date,
    "end_date" =>$end_date,
  );

  $pool_id = $PoolManager->create_pool($Pools_data);

  // Fixtures Magic
  $home_team_name = 'HTName';
  $home_team_score = 'HTScore';
  $away_team_name = 'ATName';
  $away_team_score = 'ATScore';
  $fixture_date = 'FxDate';
  $fixture_outcome = 'FxOut';
  $fixture_comment = 'FxComm';

  for($i=1;$i <= $num_of_fixtures;$i++){
    $fx_htname  = (int)filter_var($_POST[$home_team_name.$i], FILTER_SANITIZE_STRING);
    $fx_atname  = (int)filter_var($_POST[$away_team_name.$i], FILTER_SANITIZE_STRING);
    $fx_htname = $PoolManager->get_team_name($fx_htname);
    $fx_atname = $PoolManager->get_team_name($fx_atname);
    $fx_data = array(
      "pool_id" => $pool_id,
      "priority" => $i,
      "home_team" => $fx_htname,
      "home_team_score" => filter_var($_POST[$home_team_score.$i], FILTER_SANITIZE_STRING),
      "away_team" => $fx_atname,
      "away_team_score" => filter_var($_POST[$away_team_score.$i], FILTER_SANITIZE_STRING),
      "start_date" => filter_var($_POST[$fixture_date.$i], FILTER_SANITIZE_STRING),
      "outcome" => filter_var($_POST[$fixture_outcome.$i], FILTER_SANITIZE_STRING),
      "comments" => filter_var($_POST[$fixture_comment.$i], FILTER_SANITIZE_STRING),
    );

    $PoolManager->create_fixture($fx_data);
  }
  // Send Feedback to User
  $title = "Success";
  $message = "The Pool has been successfully created!";
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

?>
<?php require_once('header.php'); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <section class="content">
          <?php if(!empty($feedback)) echo $feedback;?>
          <!-- form start -->
          <form accept-charset="utf-8" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" role="form">
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
                      placeholder="Enter Pool Name" >
                    </div>
                    <div class="form-group col-sm-3 col-xs-3">
                      <label>Pool Type</label>
                      <select name="PType" class="form-control">
                        <option value="">--- Select Pool Type ---</option>
                        <option value="1">Match Outcome</option>
                        <option value="2">Goal Outcome</option>
                      </select>
                    </div>
                    <div class="form-group col-sm-3 col-xs-3">
                      <label>Pool Status</label>
                      <select name="PStatus" class="form-control">
                        <option value="">--- Select Pool Status ---</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="completed">Completed</option>
                      </select>
                    </div>
                    <div class="form-group col-sm-2 col-xs-2">
                      <label for="PNFixtures" title="Number Of Fixtures">Number Of Fixtures</label>
                      <input
                      type="number" class="form-control" class="PNFixtures" id="PNFixtures"
                      name="PNFixtures" min="1" max="12">
                    </div>
                    <div class="form-group col-sm-3 col-xs-3">
                      <label for="PWinTiers" title="Pool Winning Tiers">Winning Tiers</label>
                      <input
                      type="text" class="form-control" id="PWinTiers" name="PWinTiers"
                      placeholder="Enter Number Of Winners" >
                    </div>
                    <div class="form-group col-sm-3 col-xs-3">
                      <label for="PPAmount" title="Pool Payout Amount">Payout Amount</label>
                      <input
                      type="text" class="form-control" id="PPAmount" name="PPAmount"
                      placeholder="Enter Payout Amount" >
                    </div>
                    <div class="form-group col-sm-3 col-xs-3">
                    <label for="PSDate" title="Pool Start Date">Start Date:</label>

                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" name="PSDate" class="form-control DatetimeGame pull-right" id="datepicker_start">
                      </div>
                      <!-- /.input group -->
                    </div>
                    <div class="form-group col-sm-3 col-xs-3">
                    <label for="PEDate" title="Pool Start Date">End Date:</label>

                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" name="PEDate" class="form-control DatetimeGame pull-right" id="datepicker_end">
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
                  <div class="fixtureBlock" id="fixtureBlock" style="display: none;">
                    <!--Begin Fixture Row  -->

                      <!--End Of Fixture Row  -->
                    </div>
                </div>
                <!-- /.box-body -->

                  <div class="box-footer">
                    <button name="CPool" type="submit" class="btn btn-primary">Submit</button>
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
