<?php
include '../../../include/config.php';
include '../../../include/functions.php';
include '../../includes/admin_auth.php';
$active_menu = "dashboard";
$page_title = "Dashboard ";
$dashboard = true;

$count_user = get_count_records_by_table($connection_string, 'subscribers');
$count_events = get_count_records_by_table($connection_string, 'events');
$count_testimonial = get_count_records_by_table($connection_string, 'testimonial');
$count_faq = get_count_records_by_table($connection_string, 'faqs');
$user_list = get_recent_subscriber_user_list($connection_string);
$user_list_result = $user_list['get_info'];
$testimonial_list = get_recent_testimonial_list($connection_string);
$testimonial_list_result = $testimonial_list['get_info'];
/*************get Event LAtest Five Records */
$event_list = get_event_latest_five_records($connection_string);
$event_list_values = $event_list['get_info'];
?>
<!--  HEADER  -->
<?php include '../../includes/header.php'; ?>
<!--  BEGIN NAVBAR  -->
<div class="sub-header-container">
    <header class="header navbar navbar-expand-sm">
        <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg></a>

        <ul class="navbar-nav flex-row">
            <li>
                <div class="page-header">

                    <nav class="breadcrumb-one" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page"><span>Dashboard</span></li>
                        </ol>
                    </nav>

                </div>
            </li>
        </ul>
        <?php include '../../includes/side_header.php'; ?>
    </header>
</div>
<!--  END NAVBAR  -->
<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container" id="container">

    <div class="overlay"></div>
    <div class="search-overlay"></div>

    <!--  BEGIN SIDEBAR  -->
    <?php include '../../includes/sidebar.php'; ?>
    <!--  END SIDEBAR  -->

    <!--  BEGIN CONTENT PART  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                    <div class="row widget-statistic">
                        <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6 col-12">
                            <div class="widget widget-one_hybrid widget-followers">
                                <div style="text-align: center;" class="widget-heading">
                                    <div class="w-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        </svg>
                                    </div>
                                    <p class="w-value"><?= $count_user; ?></p>
                                    <h5 class="">Subscriber</h5>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="widget widget-one_hybrid widget-referral">
                                <div style="text-align: center;" class="widget-heading">
                                    <div class="w-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-link">
                                            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71">
                                            </path>
                                            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71">
                                            </path>
                                        </svg>
                                    </div>
                                    <p class="w-value"><?= $count_testimonial; ?></p>
                                    <h5 class="">Testimonial</h5>
                                </div>
                            </div>
                        </div> -->
                        <!-- <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                            <div class="widget widget-one_hybrid widget-engagement">
                                <div class="widget-heading">
                                    <div class="w-icon">
                                        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="calendar-minus" class="svg-inline--fa fa-calendar-minus fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                            <path fill="currentColor" d="M124 328c-6.6 0-12-5.4-12-12v-24c0-6.6 5.4-12 12-12h200c6.6 0 12 5.4 12 12v24c0 6.6-5.4 12-12 12H124zm324-216v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h48V12c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v52h128V12c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v52h48c26.5 0 48 21.5 48 48zm-48 346V160H48v298c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z"></path>
                                        </svg>
                                    </div>
                                    <p class="w-value"><?= $count_events; ?></p>
                                    <h5 class="">Event</h5>
                                </div>
                            </div>
                        </div> -->
                        <!-- <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                            <div class="widget widget-one_hybrid widget-engagement">
                                <div class="widget-heading">
                                    <div class="w-icon">
                                        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="question-circle" class="svg-inline--fa fa-question-circle fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <path fill="currentColor" d="M256 8C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm0 448c-110.532 0-200-89.431-200-200 0-110.495 89.472-200 200-200 110.491 0 200 89.471 200 200 0 110.53-89.431 200-200 200zm107.244-255.2c0 67.052-72.421 68.084-72.421 92.863V300c0 6.627-5.373 12-12 12h-45.647c-6.627 0-12-5.373-12-12v-8.659c0-35.745 27.1-50.034 47.579-61.516 17.561-9.845 28.324-16.541 28.324-29.579 0-17.246-21.999-28.693-39.784-28.693-23.189 0-33.894 10.977-48.942 29.969-4.057 5.12-11.46 6.071-16.666 2.124l-27.824-21.098c-5.107-3.872-6.251-11.066-2.644-16.363C184.846 131.491 214.94 112 261.794 112c49.071 0 101.45 38.304 101.45 88.8zM298 368c0 23.159-18.841 42-42 42s-42-18.841-42-42 18.841-42 42-42 42 18.841 42 42z"></path>
                                        </svg>
                                    </div>
                                    <p class="w-value"><?= $count_faq; ?></p>
                                    <h5 class="">FAQ</h5>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
                <!-- code check for subscriber-->
                <?php if ($user_list['status'] === 1) { ?>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-table-two">

                            <div class="widget-heading">
                                <h5 class="">Recent Subscriber</h5>
                            </div>

                            <div class="widget-content">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div class="th-content">Name</div>
                                                </th>
                                                <th>
                                                    <div class="th-content">Email</div>
                                                </th>
                                                <!-- <th>
                                                <div class="th-content">Mobile</div>
                                            </th> -->
                                                <th>
                                                    <div class="th-content">Status</div>
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!--Loop -->
                                            <?php foreach ($user_list_result as $user_value) {
                                                $user_status = "Active";
                                                $status_class =  "outline-badge-success";
                                                if ($user_value['status'] != 1) {
                                                    $user_status = "Not Active";
                                                    $status_class =  "outline-badge-danger";
                                                }
                                            ?>
                                                <tr>
                                                    <td>
                                                        <div class="td-content">
                                                            <?php echo $user_value['first_name'] . " " . $user_value['sur_name']; ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="td-content"><span class="">
                                                                <?php echo $user_value['email']; ?></span></div>
                                                    </td>
                                                    <!-- <td>
                                                <div class="td-content"><span class="">
                                                        <?php //echo $user_value['phone_number']; 
                                                        ?></span></div>
                                            </td> -->
                                                    <td>
                                                        <div class="td-content"><span class="badge <?= $status_class; ?>"><?= $user_status; ?></span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            <!--End Loop -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <!-- End code check for subscriber-->
                <!-- <?php if ($event_list['status'] === 1) {
                        ?> -->
                <!-- <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-table-two">

                            <div class="widget-heading">
                                <h5 class="">Events</h5>
                            </div>

                            <div class="widget-content">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div class="th-content">Title</div>
                                                </th>
                                                <th>
                                                    <div class="th-content">Tagline</div>
                                                </th>
                                                <th>
                                                    <div class="th-content">Status</div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($event_list_values as $event_list_result_values) {
                                                $event_status = "Active";
                                                $event_class =  "outline-badge-success";
                                                if ($event_list_result_values['status'] != 1) {
                                                    $event_status = "Not Active";
                                                    $event_class =  "outline-badge-danger";
                                                }
                                            ?>
                                                <tr>
                                                    <td>
                                                        <div class="td-content">
                                                            <?php echo $event_list_result_values['title'] ?></div>
                                                    </td>
                                                    <td>
                                                        <div class="td-content">
                                                            <?php echo $event_list_result_values['tagline'] ?></div>
                                                    </td>
                                                    <td>
                                                        <div class="td-content"><span class="badge <?= $event_class; ?>"><?= $event_status; ?></span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?> -->
            </div>
        </div>

        <!--  FOOTER  -->
        <?php include '../../includes/footer.php'; ?>