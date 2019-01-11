<?php
   $_SESSION['stoken'] = md5(time().rand(111111,99999999));
?>
<div class="row">
   <div class="col-lg-12">
       <h2 class="page-header">Enquiries</h2>
   </div>
   <!-- /.col-lg-12 -->
</div>

<form method="get" action="" id="filterform">
   <input type="hidden" name="p" value="<?php echo $_GET['p'];?>">
   <input type="hidden" name="stoken" value="<?php echo $_SESSION['stoken'];?>">
   <div class="row">
      <div class="col-lg-12">
         <div class="panel panel-primary">
            <div class="panel-heading">
               Filter :
            </div>
            <div class="panel-body">
               <div class="card-body row">
                  <div class="col-lg-4">
                     <div class="form-group">
                        <input type="text" name="cname" placeholder="Customer name" class="form-control" value="<?php echo isset($_GET['cname']) ? $_GET['cname']:"";?>"/>
                     </div>
                  </div>
                  
                    <div class="col-lg-4">
                     <div class="form-group">
                        <input type="text" name="mobile" placeholder="Mobile Number" class="form-control" value="<?php echo isset($_GET['mobile']) ? $_GET['mobile']:"";?>"/>
                     </div>
                  </div>
                  
                  <div class="col-lg-4">
                     <div class="form-group">
                        <input type="text" name="email" placeholder="Email" class="form-control" value="<?php echo isset($_GET['email']) ? $_GET['email']:"";?>"/>
                     </div>
                  </div>
                  
                  <div class="col-lg-4">
                     <div class="form-group">
                        <input type="text" name="sdate" placeholder="Start Date" id="sdate" class="form-control" value="<?php echo isset($_GET['sdate']) ? $_GET['sdate']:"";?>"/>
                     </div>
                  </div>
                  <div class="col-lg-4">
                     <div class="form-group">
                        <input type="text" name="edate" placeholder="End Date" id="edate" class="form-control" value="<?php echo isset($_GET['edate']) ? $_GET['edate']:"";?>"/>
                     </div>
                  </div>
                  <br clear="all">
                  <div class="col-lg-12">
                     <div class="btn-toolbar">
                        <input type="submit" name="filter" value="submit" class="btn btn-primary">
                        <a href="<?php echo MYWEBSITE;?>?p=main_enquiries" class="btn btn-danger  ml-1">Reset</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</form>

<?php if(isset($successmessage)){?>
<div class="alert alert-success" id="add">
   <?php echo $successmessage;?>
</div>
<?php }?>
<?php if(isset($errormessage)){?>
<div class="alert alert-danger" id="add">
   <?php echo $errormessage;?>
</div>
<?php } ?>
<br />
<div class="row">
   <div class="col-lg-12">
      <div class="table-responsive">
            <?php
                       $queryparam = $_GET;
                       unset($queryparam['page']);
                       unset($queryparam['action']);
                       unset($queryparam['cid']);
                       $listorder = $iacommon->showenquiries(array('detail'=>'?p=main_leadadd&uid=','pagination'=>'?'.http_build_query($queryparam).'&','delete'=>'?p=main_role&action=delete&cid='),$_GET);
                       if($listorder){
                               echo $listorder;
                       }else{
                               echo "No Customer found.";
                       }
               ?>	
      </div>
   </div>
</div>
<br />
<h1>&nbsp;</h1>
<link href="<?php echo MYWEBSITE;?>skin/css/pagination.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo MYWEBSITE;?>skin/js/jquery.validate.js"></script>
<script>
   $(function() {
   	$("#sdate").datepicker({"dateFormat":"yy-mm-dd",changeYear: false,maxDate:'0'});
   	$("#edate").datepicker({"dateFormat":"yy-mm-dd",changeYear: false,maxDate:'0'});
   	
   	$('#filterform').validate();
   });
</script>