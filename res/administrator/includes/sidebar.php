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

            <li class="nav-item <?php echo in_array($page, array('all-transactions','completed-orders','pending-orders','canceled-orders')) ? "active open" : null ?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-briefcase float-left"></i>
                    <span class="title">Orders</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="<?php echo $GLOBALS['path']; ?>res/administrator/all-transactions" class="nav-link ">
                            <span class="title">Transactions</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?php echo $GLOBALS['path']; ?>res/administrator/completed-orders" class="nav-link ">
                            <span class="title">Completed Orders</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?php echo $GLOBALS['path']; ?>res/administrator/pending-orders" class="nav-link ">
                            <span class="title">Pending Orders</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?php echo $GLOBALS['path']; ?>res/administrator/canceled-orders" class="nav-link ">
                            <span class="title">Canceled Orders</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item <?php echo in_array($page,array('product-categories','product-brands','new-product','manage-products')) ? "active open" : null ?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-bulb float-left"></i>
                    <span class="title">Products</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="<?php echo $GLOBALS['path']; ?>res/administrator/product-categories" class="nav-link ">
                            <span class="title">Categories</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?php echo $GLOBALS['path']; ?>res/administrator/product-brands" class="nav-link ">
                            <span class="title">Brands</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <span class="title">Products</span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item ">
                                <a href="<?php echo $GLOBALS['path']; ?>res/administrator/new-product" class="nav-link "> New Product </a>
                            </li>
                            <li class="nav-item ">
                                <a href="<?php echo $GLOBALS['path']; ?>res/administrator/manage-products" class="nav-link "> Inventory </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item  ">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <span class="title">Product Filters</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item ">
                                <a href="<?php echo $GLOBALS['path']; ?>res/administrator/featured" class="nav-link "> Featured </a>
                            </li>
                            <li class="nav-item ">
                                <a href="<?php echo $GLOBALS['path']; ?>res/administrator/special-offers" class="nav-link "> Special Offers </a>
                            </li>
                            <li class="nav-item ">
                                <a href="<?php echo $GLOBALS['path']; ?>res/administrator/deals" class="nav-link "> Deals of the Day </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li class="nav-item <?php echo in_array($page, array('manage-users','merchants')) ? "active open" : null ?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-user float-left"></i>
                    <span class="title">Customers</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item">
                        <a href="<?php echo $GLOBALS['path']; ?>res/administrator/manage-users" class="nav-link">Users</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo $GLOBALS['path']; ?>res/administrator/merchants" class="nav-link">Merchants</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item <?php echo in_array($page, array('all-admins','create-admin')) ? "active open" : null ?>">
                <a href="javascript:;" class="nav-link ">
                    <i class="icon-puzzle float-left"></i>
                    <span class="title">Admins</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item">
                        <a href="<?php echo $GLOBALS['path']; ?>res/administrator/all-admins" class="nav-link">
                            <span>All Admins</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?php echo $GLOBALS['path']; ?>res/administrator/create-admin" class="nav-link ">
                            <span class="title">Create Admin</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item <?php echo in_array($page,array('sliders','banners','faq','return-policy','order-cancellation','terms-use','privacy-policy')) ? "active open" : null ?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-feed float-left"></i>
                    <span class="title">Page Management</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="<?php echo $GLOBALS['path']; ?>res/administrator/sliders" class="nav-link ">
                            <span class="title">Sliders</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?php echo $GLOBALS['path']; ?>res/administrator/banners" class="nav-link ">
                            <span class="title">Banners</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?php echo $GLOBALS['path']; ?>res/administrator/faq" class="nav-link ">
                            <span class="title">FAQ</span>
                        </a>
                    </li>
<!--                    <li class="nav-item  ">-->
<!--                        <a href="--><?php //echo $GLOBALS['path']; ?><!--res/administrator/return-policy" class="nav-link ">-->
<!--                            <span class="title">Return Policy</span>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="nav-item  ">-->
<!--                        <a href="--><?php //echo $GLOBALS['path']; ?><!--res/administrator/order-cancellation" class="nav-link ">-->
<!--                            <span class="title">Order Cancellation</span>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="nav-item  ">-->
<!--                        <a href="--><?php //echo $GLOBALS['path']; ?><!--res/administrator/terms-use" class="nav-link ">-->
<!--                            <span class="title">Terms of Use</span>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="nav-item  ">-->
<!--                        <a href="--><?php //echo $GLOBALS['path']; ?><!--res/administrator/privacy-policy" class="nav-link ">-->
<!--                            <span class="title">Privacy Policy</span>-->
<!--                        </a>-->
<!--                    </li>-->
                </ul>
            </li>

            <li class="mt-5 nav-item <?php echo $page=='settings' ? "active open" : null ?>">
                <a href="<?php echo $GLOBALS['path']; ?>res/administrator/settings" class="nav-link">
                    <i class="icon-settings float-left"></i>
                    <span class="title"><strong>Settings</strong></span>
                    <span class="arrow"></span>
                </a>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>