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
// Get the Pool by the ID
$get_pool_id = (int)$_GET['p'];
$Pool = $PoolManager->get_pool($get_pool_id);
// var_dump($Pool);
$num_of_fixtures = $Pool['num_of_fixtures'];
for($i=0;$i<$num_of_fixtures;$i++){
  $PoolManager->delete_fixture($get_pool_id);
}
$PoolManager->delete_pool($get_pool_id);

$title = "Success";
$message = "The Pool : ".$Pool['name']." has been successfully deleted!";
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

?>
<?php require_once('header.php'); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <section class="content">
          <?php if(!empty($feedback)) echo $feedback;?>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php require_once('footer.php'); ?>
