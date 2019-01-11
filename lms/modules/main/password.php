<script type="text/javascript" src="<?php echo MYWEBSITE;?>skin/js/jquery.validate.js"></script>
<script>
$(function() {
		$("#mform").validate({
			rules: {
				"newpwd": {
				  equalTo: "#newpwd1"
				}
			}
		});

});
</script>

<?php
if(isset($_POST['submit'])){
	$is_valid = GUMP::is_valid($_POST, array(
		'oldpwd'    => 'required|max_len,20|min_len,8',
		'newpwd'    => 'required|max_len,20|min_len,8',
		'newpwd1'    => 'required|max_len,20|min_len,8'
	));
	if($is_valid === true) {
		if($_POST['newpwd']!=$_POST['newpwd1']){
			$errormessage="Both Pawssord must match";
		}else{
			
			$password = md5(ACTLP.trim($_POST['oldpwd']));
			$db->where("id",$_SESSION['adminid']);
			$db->where("password", $password);
			$customerid = $db->getOne ("lpuser", "id");
			
			if($customerid['id']!=""){
				
				$newpassword = md5(ACTLP.trim($_POST['newpwd']));
				$db->where("id",$_SESSION['adminid']);
				if($db->update ('lpuser',array("password"=>$newpassword))){
					$successmessage="changed sucessfully";
				}else{
					$errormessage="Retry...";
				}
			}else{
				$errormessage="Inavlid Details";
			}
		}
	}else{
		$errormessage="Please put proper values";
	}
}


?>

<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header">Change Password</h3>
	</div>
</div>

<form method="post" action="" id="mform">
	<?php if(!empty($successmessage)){?>
	<div class="alert alert-success" id="add">
	<?php echo $successmessage;?>
	</div>
	<?php }?>
	
	<?php if(!empty($errormessage)){?>
	<div class="alert alert-danger" id="add">
	<?php echo $errormessage;?>
	</div>
	<?php } ?>
	
<div class="row">
	<div class="col-lg-6">
		<div class="form-group">
			<label>Old Password</label>
			<input type="text" class="form-control required" name="oldpwd" minlength="8" maxlength="20" />
		</div>
		<div class="form-group">
			<label>New Password</label>
			<input type="text" class="form-control required" name="newpwd" id="newpwd" minlength="8" maxlength="20" data-msg="Both password must match" />
		</div>
	</div>
	<div class="col-lg-6">
		<div class="form-group">
			<label>Confirm Password</label>
			<input type="text" class="form-control required" name="newpwd1" id="newpwd1" minlength="8" maxlength="20" />
		</div>
	</div>
	<div class="col-lg-12">
		<div class="form-group">
			<input type="submit" name="submit" value="submit" class="btn btn-primary" />
			<input type="reset" value="Reset" class="btn btn-primary" />
		</div>
	</div>
</div>
</form>



