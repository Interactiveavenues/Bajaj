<?php
$_SESSION['stoken'] = md5(time() . rand(111111, 99999999));

?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><a href="#" style="text-decoration: none;"><?php echo (isset($_GET['s']) && $_GET['s']!='')?$_GET['s'].' Leads':"All Leads";?></a><div class="pull-right"> <a href="<?php echo MYWEBSITE; ?>?p=main_dashboard" class="btn  export-btn">Go Back to Dashboard</a> <a href="<?php echo MYWEBSITE; ?>reports.php" class="btn  export-btn">Export Leads</a></div></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".msg_head").click(function () {
       
            $( "#main-panel-body" ).slideToggle( "slow", function() {
                 var plus = $("#plus").text();
                 if(plus=='[-]') $("#plus").text('[+]');
                 else $("#plus").text('[-]');
              });
              
        });
    });
    
           
</script>
<?php if (!isset($_GET["did"])) { ?>
    <form method="get" action="" id="filterform">
        <input type="hidden" name="p" value="<?php echo $_GET['p']; ?>">
        <input type="hidden" name="stoken" value="<?php echo $_SESSION['stoken']; ?>">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary panel-primary-panel">
                    <div class="panel-heading msg_head" style="cursor: pointer;background-color:rgb(229, 25, 55); border:0px;">
                        <strong>Advance Filter </strong>
                        <div class="pull-right" ><span style="font-size:16px;" id="plus">[+]</span></div>
                    </div>
                    <div class="panel-body"  id="main-panel-body">
                        <div class="card-body row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <input type="text" name="cname" placeholder="Customer name" class="form-control" value="<?php echo isset($_GET['cname']) ? $_GET['cname'] : ""; ?>"/>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <input type="text" name="email" placeholder="Email" class="form-control" value="<?php echo isset($_GET['email']) ? $_GET['email'] : ""; ?>"/>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <input type="text" name="mobile" placeholder="Mobile Number" class="form-control" value="<?php echo isset($_GET['mobile']) ? $_GET['mobile'] : ""; ?>"/>
                                </div>
                            </div>
                            <?php $colmncls = (isset($_GET['s']) && $_GET['s']!='')?'col-lg-4':'col-lg-3';  ?>
                            
                            
                            <div class="<?php echo $colmncls;?>">
                                <div class="form-group">
                                    <select class="form-control" name="source">
                                        <option value="">-- Select Source --</option>
                                        <option value="Website" <?php echo (isset($_GET['source']) && $_GET['source']=='Website')?'selected':'';?>>Website</option>
                                        <option value="Facebook" <?php echo (isset($_GET['source']) && $_GET['source']=='Facebook')?'selected':'';?>>Facebook</option>
                                    </select>
                                </div>
                            </div>
                            <?php if(!isset($_GET['s'])) { ?>
                            <div class="<?php echo $colmncls;?>">
                                <div class="form-group">
                                    <select class="form-control" name="s">
                                        <option value="">-- Select Section --</option>
                                        <option value="Tractors">Tractors</option>
                                        <option value="Accessories">Accessories</option>
                                        <option value="Implements">Implements</option>
                                     </select>
                                </div>
                            </div>
                            <?php } else { ?>
                            <input type="hidden" name="s" value="<?php echo $_GET['s'];?>" />
                            <?php } ?>
                            
                            <div class="<?php echo $colmncls;?>">
                                <div class="form-group">
                                    <input type="text" name="sdate" placeholder="Start Date" id="sdate" class="form-control" value="<?php echo isset($_GET['sdate']) ? $_GET['sdate'] : ""; ?>"/>
                                </div>
                            </div>
                            <div class="<?php echo $colmncls;?>">
                                <div class="form-group">
                                    <input type="text" name="edate" placeholder="End Date" id="edate" class="form-control" value="<?php echo isset($_GET['edate']) ? $_GET['edate'] : ""; ?>"/>
                                </div>
                            </div>
                            <br clear="all">
                            <div class="col-lg-12">
                                <div class="btn-toolbar">
                                    <input type="submit" name="filter" value="Submit" class="btn btn-primary">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php } ?>
<?php if (isset($successmessage)) { ?>
    <div class="alert alert-success" id="add">
        <?php echo $successmessage; ?>
    </div>
<?php } ?>
<?php if (isset($errormessage)) { ?>
    <div class="alert alert-danger" id="add">
        <?php echo $errormessage; ?>
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
            $listorder = $iacommon->showleads(array('detail' => '?p=main_leadadd&uid=', 'pagination' => '?' . http_build_query($queryparam) . '&', 'delete' => '?p=main_role&action=delete&cid='), $_GET);
            if ($listorder) {
                echo $listorder;
            } else {
                echo "No Customer found.";
            }
            ?>	
        </div>
    </div>
</div>
<br />
<h1>&nbsp;</h1>
<link href="<?php echo MYWEBSITE; ?>skin/css/pagination.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo MYWEBSITE; ?>skin/js/jquery.validate.js"></script>
<script>
                $(function () {
                    $("#sdate").datepicker({"dateFormat": "yy-mm-dd", changeYear: false, maxDate: '0'});
                    $("#edate").datepicker({"dateFormat": "yy-mm-dd", changeYear: false, maxDate: '0'});

                    $('#filterform').validate();
                });
                
                <?php if(isset($_SESSION['search']) && $_SESSION['search']!='1') { ?>
                    $("#main-panel-body").show();
                <?php } ?>
</script>