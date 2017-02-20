<?php
require_once('includes/session.php');
require_once('includes/functions_base.php');
require_once('libs/PoolDB.php');
confirm_logged_in();
$PoolManager = new PoolDB;
$Bets = $PoolManager->get_all_bets();
$output = "";
$class = "";
if(count($Bets) > 0 ){
  foreach($Bets as $Bet){
    # code...
    $Pool = $PoolManager->get_pool($Bet['pool_id']);
    $pool_type = $PoolManager->get_pool_type($Bet['pool_id']) > 1 ? "Goal Outcome" : "Match Outcome";
    $winner = $Bet['winner'] > 0 ? "Yes" : "No";
    $pool_name = $PoolManager->get_pool_name($Bet['pool_id']);
    //var_dump($Bet['pool_id']);
    $output .="<tr role=\"row\" class=\"$class\">";
    $output .="<td>$Bet[id]</td>";
    $output .="<td>$pool_name</td>";
    $output .="<td>$pool_type</td>";
    $output .="<td>$Bet[msisdn]</td>";
    $PoolManager->convert_bet_predictions($Bet['pool_id']);
    $output .="<td>$Bet[result]</td>";
    $output .="<td>$winner</td>";
    $output .="<td>$Bet[prediction_date]</td>";
    $output .="</tr>";
  }
}else {
  $output = "<tr><td colspan=\"5\">Sorry, there are no pools to display.</td></tr>";
}

?>
<?php require_once('header.php'); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <section class="content">
          <!--Begin Bets Tables  -->
          <div class="row">

            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Bets List</h3>
                </div>
              <!-- /.box-header -->
            <div class="box-body">
                <div class="col-sm-12 col-xs-12">
                  <table id="example1"
                  class="table table-bordered table-striped dataTable"
                  role="grid"
                  aria-describedby="example1_info">
                  <thead>
                  <tr role="row">
                    <th class="sorting_asc">#</th>
                    <th class="sorting">Pool Name</th>
                    <th class="sorting">Pool Type</th>
                    <th class="sorting">Phone</th>
                    <th class="sorting">Prediction</th>
                    <th class="sorting">Won</th>
                    <th class="sorting">Time</th>
                  </tr>
                  </thead>
                  <tbody>
                      <?php if(!empty($output)){echo $output;}?>
                </tbody>
                  <tfoot>
                  <tr>
                    <th class="sorting_asc">#</th>
                    <th class="sorting">Pool Name</th>
                    <th class="sorting">Pool Type</th>
                    <th class="sorting">Phone</th>
                    <th class="sorting">Prediction</th>
                    <th class="sorting">Won</th>
                    <th class="sorting">Time</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              </div>
              <!-- /.box-body -->

          <!--End Bets Tables  -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php require_once('footer.php'); ?>
