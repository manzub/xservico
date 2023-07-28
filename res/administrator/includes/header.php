<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <div class="menu-toggler sidebar-toggler">
                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
            </div>
            <div class="side-title">STORE ADMIN</div>
            <a href="<?php echo $GLOBALS['path']; ?>index">
<!--                <img src="../../assets/images/favicon.png" alt="logo" class="logo-default mob" />-->
            </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN PAGE ACTIONS -->
        <!-- DOC: Remove "hide" class to enable the page header actions -->
        <div class="page-actions">
            <div class="btn-group">
                <button type="button" class="btn btn-circle btn-outline red dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-plus"></i>&nbsp;
                    <span class="hidden-sm hidden-xs">New&nbsp;</span>&nbsp;
                    <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="<?php echo $GLOBALS['path']; ?>res/administrator/create-admin">
                            <i class="icon-docs"></i> Create Admin </a>
                    </li>
                    <li>
                        <a href="<?php echo $GLOBALS['path']; ?>res/administrator/product-categories">
                            <i class="icon-tag"></i> New Category </a>
                    </li>
                    <li>
                        <a href="<?php echo $GLOBALS['path']; ?>res/administrator/product-brands">
                            <i class="icon-bulb"></i> New Brand </a>
                    </li>
                    <li>
                        <a href="<?php echo $GLOBALS['path']; ?>res/administrator/new-product">
                            <i class="icon-briefcase"></i> Upload Product </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- END PAGE ACTIONS -->
        <!-- BEGIN PAGE TOP -->
        <div class="page-top">
            <!-- END HEADER SEARCH BOX -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <img alt="" class="img-circle" src="assets/images/users/default_dp.png" />
                            <span class="username username-hide-on-mobile"> <?php echo $_SESSION['xservico_slug'][2]; ?> </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="<?php echo $GLOBALS['path']; ?>res/administrator/profile">
                                    <i class="icon-user"></i> My Profile </a>
                            </li>
                            <li>
                                <a href="<?php echo $GLOBALS['path']; ?>res/administrator/logout">
                                    <i class="icon-key"></i> Log Out </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END PAGE TOP -->
    </div>
    <!-- END HEADER INNER -->
</div>