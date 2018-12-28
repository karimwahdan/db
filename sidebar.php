<?php 
    include 'library/crud.php';
    $db = new Database();
    $db->connect();
    function get_count($field,$table,$where = ''){
    if(!empty($where))
    	$where = "where ".$where;
    
    $sql = "SELECT COUNT(".$field.") as total FROM ".$table." ".$where;
    global $db;
    $db->sql($sql);
    $res = $db->getResult();
    foreach($res as $row)
    return $row['total'];
    }
    ?>
<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title text-center" style="border: 0;">
            <img src="images/logo-460x114.png" width="230" class="md">
			<img src="images/logo-half.png" width="56" class="sm">
            <!--<a href="home.php" class="site_title"><i class="fa fa-building"></i> <span>Shree Ram</span></a>-->
        </div>
        <div class="clearfix"></div>
        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
            </div>
            <div class="profile_info">
                <h2> Admin Panel</h2>
            </div>
        </div>
        <!-- /menu profile quick info -->
        <br />
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3><?=ucwords($_SESSION['company_name'])?></h3>
                <ul class="nav side-menu">
                    <li><a href ="home.php"><i class="fas fa-home"></i> Home</a></li>
                    <li>
						<a><i class="fas fa-gift"></i> Categories<span class="fas fa-caret-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="main-category.php">Main Category</a></li>
                            <li><a href="sub-category.php">Sub Category</a></li>
                        </ul>
                    </li>
					<li><a href="questions.php"><i class="fas fa-trophy"></i> Questions</a></li>
					<li><a href="send-notifications.php"><i class="fas fa-bullhorn"></i> Send Notifications</a></li>
					<li><a href="notification-settings.php"><i class="fas fa-cog"></i> Notification Settings</a></li>
                </ul>
            </div>
		</div>
    </div>
</div>
<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <nav>
			<div class="nav toggle">
				<a id="menu_toggle"><i class="fa fa-bars"></i></a>
			</div>
            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Admin
                    <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="password.php"><i class="fa fa-key pull-right"></i> Change Password</a></li>
                        <li><a href="logout.php"><i class="fas fa-sign-out-alt pull-right"></i> Log Out</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->