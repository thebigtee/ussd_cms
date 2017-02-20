<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('includes/session.php');
require_once('includes/functions_base.php');
require_once('libs/PoolDB.php');
confirm_logged_in();
$PoolManager = new PoolDB;
// // Get the Pool by the ID
// $get_pool_id = (int)$_GET['p'];
// $Pool = $PoolManager->get_pool($get_pool_id);
$Messages = $PoolManager->get_all_messages();
// var_dump($Messages);
$output = "";
if((count($Messages)>0)&& ($Messages != false)){
  foreach ($Messages as $Message) {
    # code...
    $output .= "<div class=\"form-group col-sm-6 col-xs-6\">
      <label for=\"$Message[type]\" title=\"$Message[type] . Message: \">$Message[type] Message</label><br>
      <textarea name=\"$Message[type]\" rows=\"3\" cols=\"50\" >$Message[msg]</textarea>
    </div>";

  }
}

// Updating messages...
if(isset($_POST['MsgUpdate'])){
// var_dump($_POST);
foreach ($Messages as $Message) {
  # code...
  $data = array(
    "type" => $Message['type'],
    "msg"  => htmlspecialchars($_POST[$Message['type']]),
  );
  $PoolManager->update_messages($data);
  // var_dump($data);

}

  // Send Feedback to User
  $title = "Success";
  $message = "The Messages has been successfully updated!";
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
  // # code...
  // // Send Feedback to User
  // $title = "An Error Occured!";
  // $message = "There was an error updating the Messages. Please try again later.";
  // $feedback = "";
  // $feedback .= "<div class=\"row\">";
  // $feedback .= "<div class=\"col-sm-12 col-xs-12\">";
  // $feedback .= "<div class=\"box box-warning\">";
  // $feedback .= "<div class=\"box-header with-border\">";
  // $feedback .= "<h3 class=\"box-title\">$title</h3>";
  // $feedback .= "<div class=\"box-tools pull-right\">";
  // $feedback .= "<button type=\"button\" class=\"btn btn-box-tool\"";
  // $feedback .= "data-widget=\"remove\">";
  // $feedback .= "<i class=\"fa fa-times\"></i>";
  // $feedback .= "</button>";
  // $feedback .= "</div>";
  // $feedback .= "</div>";
  // $feedback .= "<div class=\"box-body\">";
  // $feedback .= $message;
  // $feedback .= "</div>";
  // $feedback .= "</div>";
  // $feedback .= "</div>";
  // $feedback .= "</div>";

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
                  <h3 class="box-title">All Messages</h3>
                </div>
                <!-- /.box-header -->


                  <div class="box-body">
                    <div>

                      <?php echo $output;?>
                      <!-- /.input group -->
                    </div>

                  </div>
                  <!-- /.box-body -->

                    <div class="box-footer">
                      <button name="MsgUpdate" type="submit" class="btn btn-primary">Update Messages</button>
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
