<?php
include '../../../include/config.php';
include '../../../include/functions.php';
$page_title = "Events ";
$datatable = true;;
$meta_description = "showcase";
/*********************if admin is not logged in it will be re directed to index page */
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
$error = $success = "";

/********Delete Event*********/
if (isset($_GET['action']) && $_GET['action'] == "delete") {
    $event_id = $_GET['event_id'];
    $delete_event_query = "DELETE FROM `events` WHERE `event_id`='$event_id'";
    $delete_event_query_result = mysqli_query($connection_string, $delete_event_query);
    if ($delete_event_query_result) {
        $success = "Event is Deleted";
    } else {
        $error = $error_support;
    }
}
//===get event data==//
$events_result = get_events_info($connection_string);
$events_result_data = $events_result['get_info'];


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
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Events</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><span>Events</span></li>
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
    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <?php
            if ($error != "") {
            ?>
                <div class="alert text-center alert-danger alert-dismissible " role="alert" style="width:50%; margin-left:23%; margin-right:25%;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <?= $error; ?>
                </div>
            <?php } else if ($success != "") {
            ?>
                <div class="alert text-center alert-success alert-dismissible " role="alert" style="width:50%; margin-left:23%; margin-right:25%;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <?= $success; ?>
                </div>
            <?php } ?>
            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="col-md-12 text-right mb-5">
                            <a href="add_event.php"><button id="add-work-platforms" class="btn btn-primary">Add New
                                    Event </button></a>
                        </div>
                        <div class="table-responsive mb-4 mt-4">
                            <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Tag Line</th>
                                        <th>Start Date</th>
                                        <th>End date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if ($events_result['status'] == 1) {
                                        $count = 1;
                                        foreach ($events_result_data as $events_data_values) { ?>
                                            <tr>
                                                <td><?php echo $count;
                                                    $count++; ?></td>
                                                <td><?php echo $events_data_values['title']; ?></td>
                                                <td><?php echo $events_data_values['tagline']; ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($events_data_values['start_date_time'])); ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($events_data_values['end_date_time'])); ?></td>
                                                <td><?php echo ($events_data_values['status'] == '1') ? "Active" : "InActive"; ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-dark btn-sm"><a href="edit_events.php?event_id=<?php echo $events_data_values['event_id'];  ?>">Open</a></button>
                                                        <button type="button" class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                                                <polyline points="6 9 12 15 18 9"></polyline>
                                                            </svg>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">
                                                            <a class="dropdown-item" href="edit_events.php?event_id=<?= $events_data_values['event_id']; ?>">Edit</a>
                                                            <a class="dropdown-item" href="events.php?event_id=<?= $events_data_values['event_id']; ?>&action=delete" onclick="return confirm('Are you sure you want to delete the event?')">Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                    <?php }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!--  FOOTER  -->
        <?php include '../../includes/footer.php'; ?>