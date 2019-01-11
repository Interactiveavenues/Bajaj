<?php ob_start(); session_start();



include 'config/config.php';
require_once 'includes/gump.class.php';
require_once 'includes/MysqliDb.php';
require 'includes/common.php';
require 'includes/simple-php-captcha.php';

$db = new Mysqlidb();

$iacommon  = new Iacommonclass();

if(isset($_SESSION['adminid'])){
	header('Location:'.MYWEBSITE.'admin/?p=main_dashboard');
	exit();
}	

if(isset($_GET['extra']) && $_GET['extra']=='resetsuccess'){
	$notifcation="Password Updated , login now.";
}
if(isset($_POST['submit'])){
	$gump = new GUMP();
	$_POST = $gump->sanitize($_POST);
	
	
	$gump->validation_rules(array(
		'username'    => 'required|max_len,200|min_len,3',
		'password' => 'required|max_len,20|min_len,8',
		'captcha' => 'required|alpha_numeric|max_len,20|min_len,3',
	));

	$validated_data = $gump->run($_POST);
	if($validated_data === false) {
		$errorlist = $gump->get_errors_array();
		$loginmessage = implode('<br>',$errorlist);
	}else{
	
		if($_POST['captcha'] != $_SESSION['captcha']['code']){
			$loginmessage="Invalid Captcha";
		}else{

			//$password = md5(ACTLP.$_POST['password']);
			$password = md5(ACTLP.$_POST['password']);
			$db->where("emailid", $_POST['username']);
			$db->where("password", $password);
			$db->where("status", 'active');
			$customerid = $db->getOne ("lpuser", "id,role,emailid,assignedcity");
			if($customerid['id']){
				
				$updatelogin = array (
					'lastlogin' => $db->now()
				);
				$db->where ('id', $customerid['id']);
				$db->update ('lpuser', $updatelogin);


				$_SESSION['username'] = $customerid['emailid'];
				$_SESSION['adminid'] = $customerid['id'];
				$_SESSION['role'] = $customerid['role'];
				
				$_SESSION['cityassigned'] = $customerid['assignedcity'];
				header('Location:'.MYWEBSITE.'/?p=main_dashboard');
				exit();
			}else{
				$loginmessage="Invalid Login Details, Please retry";
			}
		}
	}
}
$_SESSION['captcha'] = simple_php_captcha();

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

    <!-- Custom CSS -->
    <link href="<?php echo MYWEBSITE;?>skin/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo MYWEBSITE;?>skin/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">
        <div class="row">
		
            <div class="col-md-4 col-md-offset-4">
			<?php if(!empty($notifcation)){?>
				<div class="alert alert-success">
				  <?php echo $notifcation;?>
				</div>
			<?php } ?>
                
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
					<?php if(!empty($loginmessage)){ echo '<span style="color:red">'.$loginmessage.'</span>';}?>
                        <form role="form" method="post" action="" id="adminreg">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control required" placeholder="Customer Id" name="username"  minlength="3" maxlength="200"  autofocus value="<?php echo isset($validated_data['username']) ? $validated_data['username']: "";?>" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <input class="form-control required" placeholder="Password" name="password" type="password" value="">
                                </div>
								
								<div class="form-group">
                                    <span id="mycpatcha" style="min-height:100px;display:block">
									<img src="<?php echo $_SESSION['captcha']['image_src'];?>"><br>
									</span><br>
									<label><span id="refreshcpatcha">Refresh Captcha</span></label>
                                </div>
								
								<div class="form-group">
									<input class="form-control required" maxlength="20" minlength="3" name="captcha" id="captcha" placeholder="Captcha Here" value="<?php echo isset($validated_data['captcha']) ? $validated_data['captcha'] : "";?>" autocomplete="off">
                                </div>
								
                                <!-- Change this to a button or input when using this as a form -->
                                <input class="btn btn-md btn-success btn-block" name="submit" id="Login" value="Login" type="submit" >
                            </fieldset>
                        </form>
                    </div>
                </div>
								
            </div>	
        </div>
				
    </div>

    <!-- jQuery -->
    <script src="<?php echo MYWEBSITE;?>skin/js/jquery.js"></script>
	<script src="<?php echo MYWEBSITE;?>skin/js/jquery.validate.js"></script>
	
	<script>
	$(function() {
		$( "#refreshcpatcha" ).click(function() {
			$( "#mycpatcha" ).load( "<?php echo MYWEBSITE;?>ajax/refreshcaptcha.php", function() {});
		});
		$("#adminreg").validate({errorClass: "text-danger"});
	});
	</script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo MYWEBSITE;?>skin/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo MYWEBSITE;?>skin/js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo MYWEBSITE;?>skin/js/sb-admin-2.js"></script>

</body>

</html>