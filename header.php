<?php global $apply_active;?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Prediction App | Dashboard</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- DataTables styles -->
    <link href="plugins/datatables/jquery.dataTables.css" rel="stylesheet" type="text/css" />
    <!-- DataTables styles -->
    <link href="plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />

    <!-- daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
  <link rel="stylesheet" href="bootstrap/css/bootstrap-datetimepicker.min.css">
  <link rel="stylesheet" href="bootstrap/css/custom.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b><img src="soccer-ball.png" width="30px"></b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b><img src="soccer-ball.png" width="90px"></b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>

  </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header"><h3><?php echo ucwords($_SESSION['admin']);?></h3> <a href="logout.php">Logout</a></li>
            <li class="treeview <?php echo $apply_active["Pools"];?>">
              <a href="Pools.php">
                <i class="fa fa-circle-o text-info"></i> <span>Pools</span>
              </a>
            </li>
            <li class="treeview  <?php echo $apply_active["Bets"];?>">
              <a href="Bets.php">
                <i class="fa fa-circle-o text-red"></i> <span>Bets</span>
              </a>
            </li>
            <li class="treeview  <?php echo $apply_active["Teams"];?>">
              <a href="Teams.php">
                <i class="fa fa-circle-o text-yellow"></i> <span>Teams</span>
              </a>
            </li>
            <li class="treeview  <?php echo $apply_active["Reports"];?>">
              <a href="Reports.php">
                <i class="fa fa-circle-o text-green"></i> <span>Reports</span>
              </a>
            </li>
            <li class="treeview  <?php echo $apply_active["Messages"];?>">
              <a href="Messages.php">
                <i class="fa fa-circle-o text-yellow"></i> <span>Messages</span>
              </a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
