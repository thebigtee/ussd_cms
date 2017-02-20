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
var_dump($get_pool_id);
$Pool = $PoolManager->get_pool($get_pool_id);
$WinningBets = $PoolManager->get_winning_bets($get_pool_id);
$data = array("type" => "winner");
$WinMessage = $PoolManager->get_message($data);
var_dump($WinningBets);
var_dump($data);
var_dump($WinMessage);


if((count($WinningBets)>0) && ($WinningBets != false)){ //If we have winners
  // Send the message to the winners
  //$sent = blast_message("precin","747","Bets",$WinMessage,"localhost","ussd_services",$get_pool_id);

      if($sent){// All Messages sent successfully
        // Send Feedback to User
        $title = "Success";
        $message = "The Messages have been sent successfully!";
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

      }elseif(!$sent){

        # code...
        // Send Feedback to User
        $title = "An Error Occured!";
        $message = "There was an error in sending the messages. Please try again later.";
        $feedback = "";
        $feedback .= "<div class=\"row\">";
        $feedback .= "<div class=\"col-sm-12 col-xs-12\">";
        $feedback .= "<div class=\"box box-danger\">";
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
  $title = "No Winners!";
  $message = "There are no winners for the Pool ID: ".$get_pool_id;
  $feedback = "";
  $feedback .= "<div class=\"row\">";
  $feedback .= "<div class=\"col-sm-12 col-xs-12\">";
  $feedback .= "<div class=\"box box-warning\">";
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
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php require_once('footer.php'); ?>
