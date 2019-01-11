<?php
//Total Leads
$count = $db->getValue("leads", "count(*)");

//Section wise leads
$sectionRes = $db->rawQuery('SELECT section,count(*) as cnt from leads group by section');
$sectionArr = array();
foreach ($sectionRes as $section) {
   $sectionArr[$section['section']] = $section['cnt'];
}
//Type wise leads
$sectionRes = $db->rawQuery('SELECT source,count(*) as cnt from leads group by source');
foreach ($sectionRes as $section) {
   $sectionArr[$section['source']] = $section['cnt'];
}

?>
<div class="row">
   <div class="col-lg-12">
      <h1 class="page-header"><a href="<?php echo MYWEBSITE;?>?p=main_dashboard">Dashboard</a></h1>
   </div>
   <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
   <div class="col-lg-3 col-md-6">
      <div class="panel panel-primary">
         <div class="panel-heading">
            <div class="row">
               <div class="col-xs-3">
                  <i class="fa fa-tasks fa-5x"></i>
               </div>
               <div class="col-xs-9 text-right">
                  <div class="huge"><?php echo $count;?></div>
                  <div>All Leads</div>
               </div>
            </div>
         </div>
         <a href="<?php echo MYWEBSITE;?>?p=main_leads">
            <div class="panel-footer">
               <span class="pull-left">View Details</span>
               <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
               <div class="clearfix"></div>
            </div>
         </a>
      </div>
   </div>
   <div class="col-lg-3 col-md-6">
      <div class="panel panel-green">
         <div class="panel-heading">
            <div class="row">
               <div class="col-xs-3">
                  <i class="fa fa-tasks fa-5x"></i>
               </div>
               <div class="col-xs-9 text-right">
                  <div class="huge"><?php echo isset($sectionArr['Tractors'])?$sectionArr['Tractors']:'0';?></div>
                  <div>Tractor Leads</div>
               </div>
            </div>
         </div>
         <a href="<?php echo MYWEBSITE;?>?p=main_leads&s=Tractors">
            <div class="panel-footer">
               <span class="pull-left">View Details</span>
               <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
               <div class="clearfix"></div>
            </div>
         </a>
      </div>
   </div>
   <div class="col-lg-3 col-md-6">
      <div class="panel panel-yellow">
         <div class="panel-heading">
            <div class="row">
               <div class="col-xs-3">
                  <i class="fa fa-tasks fa-5x"></i>
               </div>
               <div class="col-xs-9 text-right">
                  <div class="huge"><?php echo isset($sectionArr['Accessories'])?$sectionArr['Accessories']:'0';?></div>
                  <div>Accessories Leads</div>
               </div>
            </div>
         </div>
         <a href="<?php echo MYWEBSITE;?>?p=main_leads&s=Accessories">
            <div class="panel-footer">
               <span class="pull-left">View Details</span>
               <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
               <div class="clearfix"></div>
            </div>
         </a>
      </div>
   </div>
   <div class="col-lg-3 col-md-6">
      <div class="panel panel-red">
         <div class="panel-heading">
            <div class="row">
               <div class="col-xs-3">
                  <i class="fa fa-tasks fa-5x"></i>
               </div>
               <div class="col-xs-9 text-right">
                   <div class="huge"><?php echo isset($sectionArr['Implements'])?$sectionArr['Implements']:'0';?></div>
                  <div>Implements Leads</div>
               </div>
            </div>
         </div>
         <a href="<?php echo MYWEBSITE;?>?p=main_leads&s=Implements">
            <div class="panel-footer">
               <span class="pull-left">View Details</span>
               <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
               <div class="clearfix"></div>
            </div>
         </a>
      </div>
   </div>
    
    <div class="col-lg-3 col-md-6">
      <div class="panel panel-red">
         <div class="panel-heading">
            <div class="row">
               <div class="col-xs-3">
                  <i class="fa fa-tasks fa-5x"></i>
               </div>
               <div class="col-xs-9 text-right">
                   <div class="huge"><?php echo isset($sectionArr['Facebook'])?$sectionArr['Facebook']:'0';?></div>
                  <div>Facebook Leads</div>
               </div>
            </div>
         </div>
         <a href="<?php echo MYWEBSITE;?>?p=main_leads&source=Facebook">
            <div class="panel-footer">
               <span class="pull-left">View Details</span>
               <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
               <div class="clearfix"></div>
            </div>
         </a>
      </div>
   </div>
    
    <div class="col-lg-3 col-md-6">
      <div class="panel panel-yellow">
         <div class="panel-heading">
            <div class="row">
               <div class="col-xs-3">
                  <i class="fa fa-tasks fa-5x"></i>
               </div>
               <div class="col-xs-9 text-right">
                  <div class="huge"><?php echo isset($sectionArr['Website'])?$sectionArr['Website']:'0';?></div>
                  <div>Website Leads</div>
               </div>
            </div>
         </div>
         <a href="<?php echo MYWEBSITE;?>?p=main_leads&source=Website">
            <div class="panel-footer">
               <span class="pull-left">View Details</span>
               <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
               <div class="clearfix"></div>
            </div>
         </a>
      </div>
   </div>
    
</div>
