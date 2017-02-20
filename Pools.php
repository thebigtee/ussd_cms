<?php
require_once('includes/session.php');
require_once('includes/functions_base.php');
require_once('libs/PoolDB.php');
confirm_logged_in();
$PoolManager = new PoolDB;
$Pools = $PoolManager->get_all_pools();
$output = "";
$class = "";
if(count($Pools) > 0 ){
  foreach($Pools as $Pool){
    # code...
    if($Pool['type'] == 1){
      $Pool_type = "Match Outcome";
    }else{
      $Pool_type = "Goals Outcome";
    }
    $output .="<tr role=\"row\" class=\"$class\">";
    $output .="<td>$Pool[id]</td>";
    $output .="<td>$Pool[name]</td>";
    $output .="<td>$Pool_type</td>";
    $output .="<td>$Pool[status]</td>";
    $output .="<td>$Pool[start_date]</td>";
    $output .="<td>$Pool[payout_amount]</td>";
    $output .="<td>$Pool[num_of_fixtures]</td>";
    // $output .="<td>$Pool[result]</td>";
    $outcome = $PoolManager->get_pool_result($Pool['id']);
    $winners = $PoolManager->get_winning_bets($Pool['id']);
    // var_dump($winners);
    if($winners !== false){
      $totalWinners = count($winners);
    }else{
      $totalWinners = 0;
    }
    // var_dump($totalWinners);
    $output .="<td>$outcome</td>";
    $output .="<td>$Pool[winning_tiers]</td>";
    // $output .="<td>Valid Bets</td>";
    $output .="<td>$totalWinners</td>";
    $output .="<td>
    <form method=\"post\">
    <center>
     <a class=\"btn btn-xs btn-success\" href=\"/ussd/SuccessMessage.php?p=$Pool[id]\" title=\"\" data-original-title=\"Send Message To Winners\">
     <span class=\"glyphicon glyphicon-envelope\" data-original-title=\"\" title=\"Send Message To Winners\"></span></a>
     <a class=\"btn btn-xs btn-primary\" href=\"/ussd/EditPools.php?p=$Pool[id]\" title=\"\" data-original-title=\"Edit\">
     <span class=\"glyphicon glyphicon-pencil\" data-original-title=\"\" title=\"Edit\"></span></a>
     <a class=\"btn btn-xs btn-danger confirmation\" href=\"/ussd/DelPools.php?p=$Pool[id]\" title=\"\" data-original-title=\"Delete\">
     <span class=\"glyphicon glyphicon-remove\" data-original-title=\"\" title=\"Delete\" onclick=\"return confirm('Are you sure to delete this Pool?')\"></span></a>
    </center>
    </form>
    </td>";

    $output .="</tr>";
  }
}else {
  $output = "<tr><td colspan=\"12\">Sorry, there are no pools to display.</td></tr>";
}

?>
<?php require_once('header.php'); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <section class="content">

          <div class="row">
              <div class="col-sm-12 col-xs-12">
                <div class="box box-default box-solid">
                  <div class="box-header with-border bg-aqua-active">
                    <h3 class="box-title">MANAGE POOLS</h3>

                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                    </div>
                    <!-- /.box-tools -->
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body" style="display: block;">
                    <a href="CreatePools.php" class="pull-left">Add New Pool
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button class="btn btn-xs btn-success" title="Add New Pool">
                    <span class="glyphicon glyphicon-plus" data-original-title="" title="Add New Pool">
                    </span>
                    </button>
                    </a>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
              </div>
          </div>
          <!--Begin Pool Tables  -->
          <div class="row">

            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Pools List</h3>
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
                    <th class="sorting">Name</th>
                    <th class="sorting">Type</th>
                    <th class="sorting">Status</th>
                    <th class="sorting">End</th>
                    <th class="sorting">Payout</th>
                    <th class="sorting">#Fixtures</th>
                    <th class="sorting">Outcome</th>
                    <th class="sorting">#Winning Tiers</th>
                    <!-- <th class="sorting">Valid Bets</th> -->
                    <th class="sorting">Winning Bets</th>
                    <th class="sorting">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                      <?php if(!empty($output)){echo $output;}?>
                </tbody>
                  <tfoot>
                  <tr>
                    <th class="sorting_asc">#</th>
                    <th class="sorting">Name</th>
                    <th class="sorting">Type</th>
                    <th class="sorting">Status</th>
                    <th class="sorting">End</th>
                    <th class="sorting">Payout</th>
                    <th class="sorting">#Fixtures</th>
                    <th class="sorting">Outcome</th>
                    <th class="sorting">#Winning Tiers</th>
                    <!-- <th class="sorting">Valid Bets</th> -->
                    <th class="sorting">Winning Bets</th>
                    <th class="sorting">Action</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              </div>
              <!-- /.box-body -->

          <!--End Pool Tables  -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php require_once('footer.php'); ?>
