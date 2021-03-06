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
$title = "";
$message = "";
$status = " box-success ";
foreach ($teams as $team) {
  $teams_output .= "<option value=\"$team[id]\">$team[name]</option>";
}

if(isset($_POST['NTeam'])){

  if(isset($_POST['TName']) && !empty($_POST['TName'])){
    $team_name  = filter_var($_POST['TName'], FILTER_SANITIZE_STRING);
    $team_name = strtoupper($team_name);
    if(!($PoolManager->team_exists($team_name))){
          $PoolManager->create_team($team_name);
          $title = "Success";
          $message = "The Team ".$team_name. " has been added successfully!";
          $status = " box-success ";

    }else{
      $title = "Fail - Already Exists";
      $message = "The Team Already Exists!";
      $status = " box-warning ";
    }
  }else{
    $title = "Fail";
    $message = "The Team Name Input Field was empty!";
    $status = " box-warning ";

  }

  // Send Feedback to User
  $feedback = "";
  $feedback .= "<div class=\"row\">";
  $feedback .= "<div class=\"col-sm-12 col-xs-12\">";
  $feedback .= "<div class=\"box $status\">";
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
          <!--Begin Pool Forms  -->
          <div class="row">

            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">New Team</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form accept-charset="utf-8" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" role="form">
                  <div class="box-body">
                    <div class="form-group col-sm-4 col-xs-4">
                      <label for="TName" title="Enter Team Name">Team Name</label>
                      <input
                      type="text" class="form-control" name="TName"id="TName"
                      placeholder="Enter Team Name" >
                    </div>
                  </div>
                  <!-- /.box-body -->

                  <div class="box-footer">
                    <button name="NTeam" type="submit" class="btn btn-primary">Add New Team</button>
                  </div>
                </form>
              </div>
              <!-- /.box -->

            </div>

          </div>
          <!--  /.row-->
          <!--End Pool Forms -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php require_once('footer.php'); ?>
