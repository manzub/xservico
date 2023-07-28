<?php $page = basename($_SERVER['REQUEST_URI'], '?'.$_SERVER['QUERY_STRING']); ?>

<div class="page-sidebar-wrapper pt-5 mt-3">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu pt-5 mt-5" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li class="nav-item start <?php echo $page=='index' ? "active open" : null ?>">
                <a href="<?php echo $GLOBALS['path']; ?>res/administrator/index" class="nav-link">
                    <i class="icon-home float-left"></i>
                    <span class="title">Home</span>
                    <span class="arrow open"></span>
                </a>
            </li>

            <li class="nav-item <?php echo in_array($page,array('product-categories','product-brands','new-product','manage-products')) ? "active open" : null ?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-bulb float-left"></i>
                    <span class="title">Products</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item ">
                        <a href="<?php echo $GLOBALS['path']; ?>res/administrator/new-product" class="nav-link "> Uplaod Product </a>
                    </li>
                    <li class="nav-item ">
                        <a href="<?php echo $GLOBALS['path']; ?>res/administrator/user-uploads" class="nav-link "> My Inventory </a>
                    </li>
                </ul>
            </li>



            <li class="mt-5 nav-item <?php echo $page=='logout' ? "active open" : null ?>">
                <a href="<?php echo $GLOBALS['path']; ?>res/administrator/logout" class="nav-link">
                    <i class="icon-logout float-left"></i>
                    <span class="title"><strong>Logout</strong></span>
                    <span class="arrow"></span>
                </a>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>