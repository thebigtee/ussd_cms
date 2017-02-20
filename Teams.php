<?php
require_once('includes/session.php');
require_once('includes/functions_base.php');
require_once('libs/PoolDB.php');
confirm_logged_in();
$PoolManager = new PoolDB;
$Teams = $PoolManager->get_all_teams_by_name();
$output = "";
if(count($Teams) > 0 ){
  foreach($Teams as $Team){
    # code...
    $output .="<tr role=\"row\" class=\"\">";
    $output .="<td>$Team[id]</td>";
    $output .="<td>$Team[name]</td>";
    $output .="<td>
    <form method=\"post\">
     <a class=\"btn btn-xs btn-primary\" href=\"/ussd/EditTeams.php?p=$Team[id]\" title=\"\" data-original-title=\"Edit\"><span class=\"glyphicon glyphicon-pencil\" data-original-title=\"\" title=\"Edit\"></span></a>
     <a class=\"btn btn-xs btn-danger confirmation\" href=\"/ussd/DelTeams.php?p=$Team[id]\" title=\"\" data-original-title=\"Edit\"><span class=\"glyphicon glyphicon-remove\" data-original-title=\"\" title=\"Delete\"onclick=\"return confirm('Are you sure to delete this Team?')\"></span></a>
    </form>
    </td>";

    $output .="</tr>";
  }
}else {
  $output = "<tr><td>Sorry, there are no teams to display.</td></tr>";
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
                    <h3 class="box-title">MANAGE TEAMS</h3>

                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                    </div>
                    <!-- /.box-tools -->
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body" style="display: block;">
                    <a href="CreateTeams.php" class="pull-left">Add New Team
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button class="btn btn-xs btn-success" title="Add New Team">
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
                  <h3 class="box-title">Teams List</h3>
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
