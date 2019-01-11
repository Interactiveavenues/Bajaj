            <div class="navbar-header">
                <!--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>-->
                <a href="<?php echo MYWEBSITE;?>?p=main_dashboard"><img src="images/logo.png" alt="Mahindra Tractor" /></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown" style="float:right">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <!--
			<li>
				<a href="<?php //echo MYWEBSITE;?>?p=main_password"><i class="fa fa-wrench fa-fw"></i> Change Password</a>
			</li>
                        -->
                        <li><a href="<?php echo MYWEBSITE;?>?p=main_dashboard"><i class="fa fa-wrench fa-fw"></i> Dashboard</a></li>
                        <li><a href="<?php echo MYWEBSITE;?>?p=main_leads"><i class="fa fa-wrench fa-fw"></i> Leads</a></li>
                        <li><a href="<?php echo MYWEBSITE;?>logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>