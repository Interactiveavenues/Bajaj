<?php ob_start(); session_start(); ini_set('max_execution_time', 100000);
   require_once 'config/config.php';
   require_once 'includes/gump.class.php';
   require_once 'includes/MysqliDb.php';
   require_once 'includes/common.php';
   // require_once 'includes/class.phpmailer.php';
   // require 'includes/class.smtp.php';
   
   $iacommon  = new Iacommonclass();
   $db = new Mysqlidb();
   
   $iacommon->validateadmin();
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
      <title><?php echo HEADING;?></title>
      <!-- Bootstrap Core CSS -->
      <link href="<?php echo MYWEBSITE;?>skin/css/bootstrap.min.css" rel="stylesheet">
      <!-- MetisMenu CSS -->
      <link href="<?php echo MYWEBSITE;?>skin/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">
      <!-- Timeline CSS -->
      <link href="<?php echo MYWEBSITE;?>skin/css/plugins/timeline.css" rel="stylesheet">
      <!-- Custom CSS -->
      <link href="<?php echo MYWEBSITE;?>skin/css/sb-admin-2.css" rel="stylesheet">
      <!-- Morris Charts CSS -->
      <link href="<?php echo MYWEBSITE;?>skin/css/plugins/morris.css" rel="stylesheet">
      <!-- Custom Fonts -->
      <link href="<?php echo MYWEBSITE;?>skin/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesnt work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
      <style>
         .navbar-default {
         background-color: #101010!important;
         border-color: #393D41!important;
         }
         .navbar-brand,.nav>li>a{
         color:#fff!important;
         }
         .nav>li>a{
         border-bottom:1px rgb(229, 25, 55)!important;
         }
         .sidebar{
         background-color:#29af8a!important;
         }
         .nav>li>a:hover, .nav>li>a:focus{
         background-color: rgb(229, 25, 55) !important;
         }
      </style>
      <script src="<?php echo MYWEBSITE;?>skin/js/jquery-1.10.2.js"></script>
      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
      <script src="<?php echo MYWEBSITE;?>skin/js/jquery-ui.js"></script>
      <!-- jQuery -->
      <!-- Bootstrap Core JavaScript -->
      <script src="<?php echo MYWEBSITE;?>skin/js/bootstrap.min.js"></script>
      <!-- Metis Menu Plugin JavaScript -->
      <script src="<?php echo MYWEBSITE;?>skin/js/plugins/metisMenu/metisMenu.min.js"></script>
      <!-- Morris Charts JavaScript -->
      <!-- Custom Theme JavaScript -->
      <script src="<?php echo MYWEBSITE;?>skin/js/sb-admin-2.js"></script>
      <script src="<?php echo MYWEBSITE;?>skin/js/custom.js"></script>
      <style>
         .error{
         color:red;
         }
         /* sidebar patch 
         #page-wrapper{
         margin-left:200px!important;
         }
         .sidebar{
         width:200px!important
         }
         sidebar patch */
      </style>
   </head>
   <body>
      <div id="wrapper">
         <!-- Navigation -->
         <nav class="navbar  navbar-static-top" role="navigation" style="margin-bottom: 0">
            <?php include 'header.php';?>
            <!-- /.navbar-top-links -->
            <?php 
               //include 'left.php';
               
               ?>
            <!-- /.navbar-static-side -->
         </nav>
         <div id="page-wrapper">
            <!-- /.row -->
            <?php
               if(isset($_GET['p']) && $_GET['p']!=""){
               
               $urltodisplay=explode('_',$_GET['p']);
               include 'modules/'.$urltodisplay[0].'/'.$urltodisplay[1].'.php';
               
               }else{
               
               include 'modules/main/dashboard.php';
               
               }
               
               ?>
            <!-- /.row -->
         </div>
         <!-- /#page-wrapper -->
         <?php include 'footer.php';?>
      </div>
      <!-- /#wrapper -->
   </body>
</html>