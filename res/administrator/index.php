<?php
require_once "../../core/init.php";
require_once "../../core/bookmark.php";
require_once 'validation.php';

$query = selectQuery("select * from members where roles is not NULL and email_slug = '{$_SESSION['xservico_slug'][0]}'");
if(mysqli_num_rows($query)==0) {
    header("Location: {$GLOBALS['path']}res/users/index");
    exit;
}

$query = selectQuery("select * from members where email_slug = '{$_SESSION['xservico_slug'][0]}'");
while($row=mysqli_fetch_assoc($query)) {
    $admin_id = $row['id'];
    $acct_password = $row['password'];
    $roles = explode(',', $row['roles']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Administrator Dashboard | Xservico Online Store</title>
    <?php require_once "includes/styles.php"; ?>
    <link rel="stylesheet" href="assets/dashboard.css" >
</head>
<!-- END HEAD -->
<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid" style="background-color: #2a3442 !important;">
<!-- BEGIN HEADER -->
<?php require_once "includes/header.php"; ?>
<!-- END HEADER -->
<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"> </div>
<!-- END HEADER & CONTENT DIVIDER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php if(in_array('7',$roles)) { require_once "includes/sidebar2.php"; }else{ require_once "includes/sidebar.php"; } ?>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">

            <div class="d-flex flex-column-fluid">
                <div class="container">
                    <!-- BEGIN PAGE HEADER-->
                    <h1 class="page-title"> Welcome to <?php if (in_array('7',$roles)) { echo "merchants"; }else{ echo "administrator"; } ?> dashboard
                    </h1>
                    <div class="page-bar rounded">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="index">Account</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li><span>Dashboard</span></li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->
                    <?php if(in_array('7', $roles)) {  ?>
                    <!-- Quick Actions -->
                    <h1 class="text-center p-4"><strong>Quick Actions</strong></h1>
                    <style>
                        .dfd:hover{
                            box-shadow: 0.5px 1px rgba(0,0,0,0.17);
                        }
                    </style>
                    <?php if(isset($_SESSION['login_info_message'])) { ?>
                        <div class="alert alert-info"><?php echo $_SESSION['login_info_message']; ?></div>
                    <?php } ?>
                    <div class="alert alert-warning">Upload local bank details <a href="bank-accounts.php" style="color:blue">Click here</a></div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card card-custom card-stretch gutter-b rounded dfd">
                                <div class="card-body p-3 rounded-bottom" style="position: relative">
                                    <a href="new-product.php">
                                        <div class="align-items-center justify-content-between card-spacer">
                                            <div class="text-center">
                                            <span class="symbol-light-success">
                                                <span class="symbol-label">
                                                    <i class="icon-briefcase text-success" style="font-size: 55px"></i>
                                                </span>
                                            </span>
                                            </div>
                                            <h1 class="text-center text-dark">Uplaod Product</h1>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card card-custom card-stretch gutter-b rounded dfd">
                                <div class="card-body p-3 rounded-bottom" style="position: relative">
                                    <a href="profile.php">
                                        <div class="align-items-center justify-content-between card-spacer">
                                            <div class="text-center">
                                            <span class="symbol-light-success">
                                                <span class="symbol-label">
                                                    <i class="icon-settings text-success" style="font-size: 55px"></i>
                                                </span>
                                            </span>
                                            </div>
                                            <h1 class="text-center text-dark">Manage Profile</h1>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card card-custom card-stretch gutter-b rounded dfd">
                                <div class="card-body p-3 rounded-bottom" style="position: relative">
                                    <a href="user-uploads.php">
                                        <div class="align-items-center justify-content-between card-spacer">
                                            <div class="text-center">
                                            <span class="symbol-light-success">
                                                <span class="symbol-label">
                                                    <i class="icon-folder-alt text-success" style="font-size: 55px"></i>
                                                </span>
                                            </span>
                                            </div>
                                            <h1 class="text-center text-dark">My Uploads</h1>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }else{ ?>
                    <!-- Admin Actions -->
                    <div class="row">
                        <div id="allSales" class="col-lg-6">
                            <div class="card card-custom card-stretch gutter-b rounded">
                                <div class="card-header rounded-top">
                                    <span class="symbol symbol-50 symbol-light-success mr-2">
                                        <span class="symbol-label">
                                            <span class="svg-icon svg-icon-xl svg-icon-success">
                                                <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                        <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5"></rect>
                                                        <path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3"></path>
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                    </span>
                                    <?php $indexStats = indexStats(); ?>
                                    <h2 class="card-title font-weight-bolder">All Sales</h2>
                                </div>
                                <div class="card-body p-0 rounded-bottom" style="position: relative">
                                    <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                        <h1 style="font-size: 45px">&#8358;<span data-counter="counterup" data-value="<?php echo $indexStats[0]; ?>">0</span></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="allOrders" class="col-lg-6">
                            <div class="card card-custom card-stretch gutter-b rounded">
                                <div class="card-header rounded-top">
                                    <span class="symbol symbol-50 symbol-light-success mr-2">
                                        <span class="symbol-label">
                                            <span class="svg-icon svg-icon-xl svg-icon-success">
                                                <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                        <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5"></rect>
                                                        <path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3"></path>
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                    </span>
                                    <h2 class="card-title font-weight-bolder">Total Orders</h2>
                                </div>
                                <div class="card-body p-0 rounded-bottom" style="position: relative">
                                    <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                        <h1 style="font-size: 45px"><span data-counter="counterup" data-value="<?php echo $indexStats[1]; ?>">0</span></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card card-custom bg-gray-100 card-stretch gutter-b rounded">
                                <!--begin::Header-->
                                <div class="card-header border-0 bg-danger py-5 rounded-top">
                                    <h3 class="card-title font-weight-bolder text-white">Sales Stat</h3>
                                    <div class="card-toolbar">
                                        <div class="dropdown dropdown-inline"></div>
                                    </div>
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body p-0 position-relative overflow-hidden rounded-bottom">
                                    <!--begin::Chart-->
                                    <div id="kt_mixed_widget_1_chart" class="card-rounded-bottom bg-danger" style="height: 200px; min-height: 200px;"><div id="apexchartsjbyu5q1j" class="apexcharts-canvas apexchartsjbyu5q1j apexcharts-theme-light" style="width: 370px; height: 200px;"><svg id="SvgjsSvg1621" width="370" height="200" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1623" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)"><defs id="SvgjsDefs1622"><clipPath id="gridRectMaskjbyu5q1j"><rect id="SvgjsRect1626" width="377" height="203" x="-3.5" y="-1.5" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="gridRectMarkerMaskjbyu5q1j"><rect id="SvgjsRect1627" width="374" height="204" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><filter id="SvgjsFilter1633" filterUnits="userSpaceOnUse" width="200%" height="200%" x="-50%" y="-50%"><feFlood id="SvgjsFeFlood1634" flood-color="#d13647" flood-opacity="0.5" result="SvgjsFeFlood1634Out" in="SourceGraphic"></feFlood><feComposite id="SvgjsFeComposite1635" in="SvgjsFeFlood1634Out" in2="SourceAlpha" operator="in" result="SvgjsFeComposite1635Out"></feComposite><feOffset id="SvgjsFeOffset1636" dx="0" dy="5" result="SvgjsFeOffset1636Out" in="SvgjsFeComposite1635Out"></feOffset><feGaussianBlur id="SvgjsFeGaussianBlur1637" stdDeviation="3 " result="SvgjsFeGaussianBlur1637Out" in="SvgjsFeOffset1636Out"></feGaussianBlur><feMerge id="SvgjsFeMerge1638" result="SvgjsFeMerge1638Out" in="SourceGraphic"><feMergeNode id="SvgjsFeMergeNode1639" in="SvgjsFeGaussianBlur1637Out"></feMergeNode><feMergeNode id="SvgjsFeMergeNode1640" in="[object Arguments]"></feMergeNode></feMerge><feBlend id="SvgjsFeBlend1641" in="SourceGraphic" in2="SvgjsFeMerge1638Out" mode="normal" result="SvgjsFeBlend1641Out"></feBlend></filter><filter id="SvgjsFilter1643" filterUnits="userSpaceOnUse" width="200%" height="200%" x="-50%" y="-50%"><feFlood id="SvgjsFeFlood1644" flood-color="#d13647" flood-opacity="0.5" result="SvgjsFeFlood1644Out" in="SourceGraphic"></feFlood><feComposite id="SvgjsFeComposite1645" in="SvgjsFeFlood1644Out" in2="SourceAlpha" operator="in" result="SvgjsFeComposite1645Out"></feComposite><feOffset id="SvgjsFeOffset1646" dx="0" dy="5" result="SvgjsFeOffset1646Out" in="SvgjsFeComposite1645Out"></feOffset><feGaussianBlur id="SvgjsFeGaussianBlur1647" stdDeviation="3 " result="SvgjsFeGaussianBlur1647Out" in="SvgjsFeOffset1646Out"></feGaussianBlur><feMerge id="SvgjsFeMerge1648" result="SvgjsFeMerge1648Out" in="SourceGraphic"><feMergeNode id="SvgjsFeMergeNode1649" in="SvgjsFeGaussianBlur1647Out"></feMergeNode><feMergeNode id="SvgjsFeMergeNode1650" in="[object Arguments]"></feMergeNode></feMerge><feBlend id="SvgjsFeBlend1651" in="SourceGraphic" in2="SvgjsFeMerge1648Out" mode="normal" result="SvgjsFeBlend1651Out"></feBlend></filter></defs><g id="SvgjsG1652" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG1653" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG1662" class="apexcharts-grid"><g id="SvgjsG1663" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine1665" x1="0" y1="0" x2="370" y2="0" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1666" x1="0" y1="20" x2="370" y2="20" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1667" x1="0" y1="40" x2="370" y2="40" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1668" x1="0" y1="60" x2="370" y2="60" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1669" x1="0" y1="80" x2="370" y2="80" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1670" x1="0" y1="100" x2="370" y2="100" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1671" x1="0" y1="120" x2="370" y2="120" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1672" x1="0" y1="140" x2="370" y2="140" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1673" x1="0" y1="160" x2="370" y2="160" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1674" x1="0" y1="180" x2="370" y2="180" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1675" x1="0" y1="200" x2="370" y2="200" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line></g><g id="SvgjsG1664" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine1677" x1="0" y1="200" x2="370" y2="200" stroke="transparent" stroke-dasharray="0"></line><line id="SvgjsLine1676" x1="0" y1="1" x2="0" y2="200" stroke="transparent" stroke-dasharray="0"></line></g><g id="SvgjsG1628" class="apexcharts-area-series apexcharts-plot-series"><g id="SvgjsG1629" class="apexcharts-series" seriesName="NetxProfit" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath1632" d="M 0 200L 0 125C 21.583333333333332 125 40.08333333333333 87.5 61.666666666666664 87.5C 83.25 87.5 101.75 120 123.33333333333333 120C 144.91666666666666 120 163.41666666666666 25 185 25C 206.58333333333331 25 225.08333333333331 100 246.66666666666666 100C 268.25 100 286.75 100 308.3333333333333 100C 329.91666666666663 100 348.4166666666667 100 370 100C 370 100 370 100 370 200M 370 100z" fill="transparent" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaskjbyu5q1j)" filter="url(#SvgjsFilter1633)" pathTo="M 0 200L 0 125C 21.583333333333332 125 40.08333333333333 87.5 61.666666666666664 87.5C 83.25 87.5 101.75 120 123.33333333333333 120C 144.91666666666666 120 163.41666666666666 25 185 25C 206.58333333333331 25 225.08333333333331 100 246.66666666666666 100C 268.25 100 286.75 100 308.3333333333333 100C 329.91666666666663 100 348.4166666666667 100 370 100C 370 100 370 100 370 200M 370 100z" pathFrom="M -1 200L -1 200L 61.666666666666664 200L 123.33333333333333 200L 185 200L 246.66666666666666 200L 308.3333333333333 200L 370 200"></path><path id="SvgjsPath1642" d="M 0 125C 21.583333333333332 125 40.08333333333333 87.5 61.666666666666664 87.5C 83.25 87.5 101.75 120 123.33333333333333 120C 144.91666666666666 120 163.41666666666666 25 185 25C 206.58333333333331 25 225.08333333333331 100 246.66666666666666 100C 268.25 100 286.75 100 308.3333333333333 100C 329.91666666666663 100 348.4166666666667 100 370 100" fill="none" fill-opacity="1" stroke="#d13647" stroke-opacity="1" stroke-linecap="butt" stroke-width="3" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaskjbyu5q1j)" filter="url(#SvgjsFilter1643)" pathTo="M 0 125C 21.583333333333332 125 40.08333333333333 87.5 61.666666666666664 87.5C 83.25 87.5 101.75 120 123.33333333333333 120C 144.91666666666666 120 163.41666666666666 25 185 25C 206.58333333333331 25 225.08333333333331 100 246.66666666666666 100C 268.25 100 286.75 100 308.3333333333333 100C 329.91666666666663 100 348.4166666666667 100 370 100" pathFrom="M -1 200L -1 200L 61.666666666666664 200L 123.33333333333333 200L 185 200L 246.66666666666666 200L 308.3333333333333 200L 370 200"></path><g id="SvgjsG1630" class="apexcharts-series-markers-wrap" data:realIndex="0"><g class="apexcharts-series-markers"><circle id="SvgjsCircle1683" r="0" cx="0" cy="0" class="apexcharts-marker w388tk1dl no-pointer-events" stroke="#d13647" fill="#ffe2e5" fill-opacity="1" stroke-width="3" stroke-opacity="0.9" default-marker-size="0"></circle></g></g></g><g id="SvgjsG1631" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine1678" x1="0" y1="0" x2="370" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1679" x1="0" y1="0" x2="370" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1680" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1681" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1682" class="apexcharts-point-annotations"></g></g><g id="SvgjsG1661" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG1624" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 100px;"></div><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-title" style="font-family: Poppins; font-size: 12px;"></div><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: transparent;"></span><div class="apexcharts-tooltip-text" style="font-family: Poppins; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label"></span><span class="apexcharts-tooltip-text-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
                                    <!--end::Chart-->
                                    <!--begin::Stats-->
                                    <div class="card-spacer mt-n25">
                                        <!--begin::Row-->
                                        <div class="row m-0">
                                            <div class="col bg-light-warning px-6 py-8 rounded-xl mr-7 mb-7">
															<span class="svg-icon svg-icon-3x svg-icon-warning d-block my-2">
																<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Media/Equalizer.svg-->
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24"></rect>
																		<rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5"></rect>
																		<rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5"></rect>
																		<rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5"></rect>
																		<rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5"></rect>
																	</g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
                                                <a href="#allSales" class="text-warning font-weight-bold font-size-h6">All Sales</a>
                                            </div>
                                            <div class="col bg-light-primary px-6 py-8 rounded-xl mb-7">
															<span class="svg-icon svg-icon-3x svg-icon-primary d-block my-2">
																<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Add-user.svg-->
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<polygon points="0 0 24 0 24 24 0 24"></polygon>
																		<path d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
																		<path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"></path>
																	</g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
                                                <a href="create-admin" class="text-primary font-weight-bold font-size-h6 mt-2">New Admin</a>
                                            </div>
                                        </div>
                                        <!--end::Row-->
                                        <!--begin::Row-->
                                        <div class="row m-0">
                                            <div class="col bg-light-danger px-6 py-8 rounded-xl mr-7">
															<span class="svg-icon svg-icon-3x svg-icon-danger d-block my-2">
																<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Design/Layers.svg-->
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<polygon points="0 0 24 0 24 24 0 24"></polygon>
																		<path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero"></path>
																		<path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3"></path>
																	</g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
                                                <a href="all-transactions" class="text-danger font-weight-bold font-size-h6 mt-2">All Orders</a>
                                            </div>
                                            <div class="col bg-light-success px-6 py-8 rounded-xl">
															<span class="svg-icon svg-icon-3x svg-icon-success d-block my-2">
																<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Urgent-mail.svg-->
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24"></rect>
																		<path d="M12.7037037,14 L15.6666667,10 L13.4444444,10 L13.4444444,6 L9,12 L11.2222222,12 L11.2222222,14 L6,14 C5.44771525,14 5,13.5522847 5,13 L5,3 C5,2.44771525 5.44771525,2 6,2 L18,2 C18.5522847,2 19,2.44771525 19,3 L19,13 C19,13.5522847 18.5522847,14 18,14 L12.7037037,14 Z" fill="#000000" opacity="0.3"></path>
																		<path d="M9.80428954,10.9142091 L9,12 L11.2222222,12 L11.2222222,16 L15.6666667,10 L15.4615385,10 L20.2072547,6.57253826 C20.4311176,6.4108595 20.7436609,6.46126971 20.9053396,6.68513259 C20.9668779,6.77033951 21,6.87277228 21,6.97787787 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,6.97787787 C3,6.70173549 3.22385763,6.47787787 3.5,6.47787787 C3.60510559,6.47787787 3.70753836,6.51099993 3.79274528,6.57253826 L9.80428954,10.9142091 Z" fill="#000000"></path>
																	</g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
                                                <a href="new-product" class="text-success font-weight-bold font-size-h6 mt-2">Add New Product</a>
                                            </div>
                                        </div>
                                        <!--end::Row-->
                                    </div>
                                    <!--end::Stats-->
                                    <div class="resize-triggers"><div class="expand-trigger"><div style="width: 371px;"></div></div><div class="contract-trigger"></div></div></div>
                                <!--end::Body-->
                            </div>
                        </div>

                        <!--widget 2-->
                        <div class="col-lg-6">
                            <?php $activity = allMyActivities(getUserID($_SESSION['xservico_slug'][0])) ?>
                            <div class="card card-custom card-stretch gutter-b rounded">
                                <!--begin::Header-->
                                <div class="card-header align-items-center border-0 mt-4 rounded-top">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="font-weight-bolder text-dark">My Activity</span>
                                        <span class="text-muted mt-3 font-weight-bold font-size-sm"><?php echo $activity[0]; ?> Logs</span>
                                    </h3>
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body pt-4 rounded-bottom">
                                    <!--begin::Timeline-->
                                    <div class="timeline timeline-6 mt-3">
                                        <?php echo  $activity[1]; ?>
                                    </div>
                                    <!--end::Timeline-->
                                </div>
                                <!--end: Card Body-->
                            </div>
                        </div>
                    </div>
                    <?php } ?>


                </div>
            </div>

        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
    <!-- BEGIN QUICK SIDEBAR -->
<!--    --><?php //require_once "includes/quick-sidebar.php"; ?>
    <!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<?php require_once "includes/footer.php"; ?>
<!-- END FOOTER -->
<!-- BEGIN QUICK NAV -->
<?php //require_once "includes/quick-nav.php"; ?>
<!-- END QUICK NAV -->
<?php require_once "includes/scripts.php"; ?>
</body>

</html>
