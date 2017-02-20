<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('includes/session.php');
require_once('includes/functions_base.php');
require_once('libs/PoolDB.php');
confirm_logged_in();
$PoolManager = new PoolDB;
// Get the Pool by the ID
$get_pool_id = (int)$_GET['p'];
$Pool = $PoolManager->get_pool($get_pool_id);
$WinningBets = $PoolManager->get_winning_bets($get_pool_id);
var_dump($WinningBets);
echo "We are here so?";

// All Messages sent successfully
if(true){
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

          </div>
          <!--  /.row-->
          </form>
          <!--End Pool Forms -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php require_once('footer.php'); ?>
