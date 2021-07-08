<?php
include '../../../include/config.php';
include '../../../include/functions.php';
$active_menu = "support_tickets";
$page_title = "Support Tickets";
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
$invoice = true;
$error = $success = "";
//echo substr($speccified_string, 0, 150) . "..."
//Delete the Support Ticket
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $ticket_id = $_GET['ticket_id'];
    $data = array(
        'ticket_id' => $ticket_id
    );
    $api_url_message = "API/change_status.php";
    $result = perform_http_request('POST', $api_url_message, json_encode($data));
    $update_result = json_decode($result);
    if ($update_result->status == 1) {
        $success = $update_result->message;
    }
}
//Close the Support Ticket
if (isset($_GET['support_ticket']) && $_GET['support_ticket'] == 'close') {
    $ticket_id = $_GET['ticket_id'];

    $data = array(
        'ticket_id' => $ticket_id
    );
    $api_url_message = "API/close_support_ticket.php";
    $result = perform_http_request('POST', $api_url_message, json_encode($data));
    $update_result = json_decode($result);
    if ($update_result->status == 1) {
        header('Location:support_tickets.php');
    }
}



$support_ticket = array();
$open_support_ticket = array();
$close_support_ticket = array();


$api_url = $support_api_url . "API/support_ticket_list.php?project_id=" . $project_id;
$result = invokeApi('GET', $api_url, $data = '');
$tickets_result = json_decode($result);
if ($tickets_result->status === 1) {
    $support_ticket = $tickets_result->get_info;
    $open_support_ticket   = $support_ticket->open_tickets;
    $close_support_ticket  = $support_ticket->close_tickets;
    $get_admin_reply_count = $support_ticket->get_admin_reply_count;
}
?>

<?php include '../../includes/header.php'; ?>
<!-- <link rel="stylesheet" type="text/css" href="../../plugins/editors/quill/quill.snow.css">-->
<link href="../../assets/css/custom_style.css" rel="stylesheet" type="text/css" />
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
                            <!-- <li class="breadcrumb-item"><a href="javascript:void(0);">Apps</a></li> -->
                            <li class="breadcrumb-item active" aria-current="page"><span>Support Tickets</span></li>
                        </ol>
                    </nav>

                </div>
            </li>
        </ul>
        <?php include '../../includes/side_header.php' ?>
    </header>
</div>
<!--  END NAVBAR  -->

<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container" id="container">

    <div class="overlay"></div>
    <div class="search-overlay"></div>

    <!--  BEGIN SIDEBAR  -->
    <?php include '../../includes/sidebar.php' ?>
    <!--  END SIDEBAR  -->

    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="row layout-top-spacing">
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
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <?php if (empty($support_ticket)) {
                        echo "<p>No Ticket Found</p>";
                    } ?>
                    <div class="mail-box-container">
                        <div class="mail-overlay"></div>

                        <div class="tab-title">
                            <div class="row">
                                <div class="todoList-sidebar-scroll">
                                    <div class="col-md-12 col-sm-12 col-12 pl-0">
                                        <ul class="nav nav-pills d-block" id="pills-tab" role="tablist">
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link list-actions" id="todo-task-important" data-toggle="pill" href="#pills-important" role="tab" aria-selected="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star">
                                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                    </svg> Open <span style="color:#e7515a!important;border-color:#e7515a !important;" class="todo-badge badge"></span></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link list-actions" id="todo-task-done" data-toggle="pill" href="#pills-sentmail" role="tab" aria-selected="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up">
                                                        <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                                                    </svg> Close <span class="todo-badge badge"></span></a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>

                                <a style="background-color: #009688; border-color:#009688;color:#191e3a;" class="btn" id="addTas" href="add_support_ticket.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>Add Support Ticket</a>
                            </div>
                        </div>

                        <div id="todo-inbox" class="accordion todo-inbox">
                            <div class="search">
                                <input type="text" class="form-control input-search" placeholder="Search Here...">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu mail-menu d-lg-none">
                                    <line x1="3" y1="12" x2="21" y2="12"></line>
                                    <line x1="3" y1="6" x2="21" y2="6"></line>
                                    <line x1="3" y1="18" x2="21" y2="18"></line>
                                </svg>
                            </div>

                            <div class="todo-box">

                                <div id="ct" class="todo-box-scroll">
                                    <!-- done -->
                                    <?php
                                    foreach ($close_support_ticket as $support_list) {

                                        $support_date = $support_list->date_time;
                                        $yrdata = strtotime($support_date);
                                        $date =  date('j F Y', $yrdata);
                                    ?>
                                        <div class="todo-item all-list todo-task-done">
                                            <div class="todo-item-inner">
                                                <div class="todo-content">
                                                    <a href="ticket_details.php?ticket_id=<?= $support_list->id ?>">
                                                        <!-- <?php if ($support_list->response_status == 0) {
                                                                    $res_class = "response";
                                                                    $res_text = "Waiting Response";
                                                                } else {
                                                                    $res_class = "answered";
                                                                    $res_text = "Answered";
                                                                } ?> -->
                                                        <a href="ticket_details.php?ticket_id=<?= $support_list->id ?>">
                                                            <h5 class="todo-heading" data-todoHeading="<?= $support_list->subject  ?>"> <?= $support_list->subject ?>
                                                            </h5>
                                                        </a>
                                                        <a href="ticket_details.php?ticket_id=<?= $support_list->id ?>">
                                                            <p class="todo-text"> <?php $speccified_string =  $support_list->description;
                                                                                    echo substr($speccified_string, 0, 150) . "..."
                                                                                    // echo  $string = (strlen($speccified_string) > 150) ? substr($speccified_string, 0, 150) . '...' : $speccified_string;
                                                                                    // $length = strlen($speccified_string);

                                                                                    // if ($length < 200) {
                                                                                    //     $speccified_string .= str_repeat('&nbsp', 200 - $length);
                                                                                    // } else {
                                                                                    //     $speccified_string = substr($speccified_string, 0, 200);
                                                                                    // }
                                                                                    // echo $speccified_string;
                                                                                    ?></p>
                                                        </a>
                                                        <p class="meta-date"><?= $date ?></p>
                                                </div>
                                                <?php $color = $text = '';
                                                if ($support_list->ticket_type === 'issue') {
                                                    $class = 'support_issue';
                                                    $text = 'Issue';
                                                } elseif ($support_list->ticket_type === 'new_feature') {
                                                    $class = 'support_new_feature';
                                                    $text = 'New&nbspFeature';
                                                }
                                                ?>

                                                <!-- <div class="priority-dropdown custom-dropdown-icon">
                                                    <div class="dropdown p-dropdown">
                                                        <a class="<?= $class ?>"><?= $text ?>
                                                        </a>
                                                    </div>
                                                </div> -->
                                                <div class="action-dropdown custom-dropdown-icon">
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical">
                                                                <circle cx="12" cy="12" r="1"></circle>
                                                                <circle cx="12" cy="5" r="1"></circle>
                                                                <circle cx="12" cy="19" r="1"></circle>
                                                            </svg>
                                                        </a>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink-2">
                                                            <a class="dropdown-item delete" href="support_tickets.php?ticket_id=<?= $support_list->id ?>&action=delete" onclick="return confirm('Are you sure you want to delete the Support Ticket?')">Delete</a>
                                                            <!-- <a class="dropdown-item" href="support_tickets.php?ticket_id=<?= $support_list->id ?>&& support_ticket=close" onclick="return confirm('Are you sure you want to close the Support Ticket?')">Delete</a> -->

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                    ?>
                                    <!-- important -->
                                    <?php
                                    $count  =   0;


                                    foreach ($open_support_ticket as $support_list) {
                                        $support_date = $support_list->date_time;
                                        $yrdata = strtotime($support_date);
                                        $date =  date('j F Y', $yrdata);
                                    ?>
                                        <div class="todo-item all-list todo-task-important">
                                            <div class="todo-item-inner">
                                                <div class="todo-content">
                                                    <a href="ticket_details.php?ticket_id=<?= $support_list->id ?>">
                                                        <?php if ($support_list->response_status == 0) {
                                                            $res_class = "response";
                                                            $res_text = "Waiting Response";
                                                        } else {
                                                            $res_class = "answered";
                                                            $res_text = "Answered";
                                                        }
                                                        ?>
                                                        <h5 class="todo-heading" data-todoHeading="<?= $support_list->subject ?>"> <?= $support_list->subject ?> <span class="<?= $res_class; ?>"><?= $res_text; ?></span>&nbsp;&nbsp; <?php if ($get_admin_reply_count[$count]->count > 0) { ?> <span class="badge badge-danger rounded-circle"><?= $get_admin_reply_count[$count]->count; ?></span><?php } ?>
                                                        </h5>
                                                        <p class="todo-text"> <?php $speccified_string =  $support_list->description;
                                                                                echo substr($speccified_string, 0, 150) . "..."
                                                                                // echo  $string = (strlen($speccified_string) > 150) ? substr($speccified_string, 0, 150) . '...' : $speccified_string;
                                                                                // $length = strlen($speccified_string);
                                                                                // if ($length < 200) {
                                                                                //     $speccified_string .= str_repeat('&nbsp', 200 - $length);
                                                                                // } else {
                                                                                //     $speccified_string = substr($speccified_string, 0, 200);
                                                                                // }
                                                                                // echo $speccified_string;
                                                                                ?></p>
                                                        <p class="meta-date"><?= $date ?></p>
                                                    </a>

                                                </div>
                                                <?php $color = $text = '';
                                                if ($support_list->ticket_type === 'issue') {
                                                    $class = 'support_issue';
                                                    $text = 'Something&nbspNot&nbspWorking';
                                                } elseif ($support_list->ticket_type === 'new_feature') {
                                                    $class = 'support_new_feature';
                                                    $text = 'Looking&nbspFor&nbspNew&nbspSupport';
                                                }
                                                ?>

                                                <!-- <div class="priority-dropdown custom-dropdown-icon">
                                                    <div class="dropdown p-dropdown">
                                                        <a class=" $class ?>"> $text ?>

                                                        </a>
                                                    </div>
                                                </div> -->
                                                <div class="action-dropdown custom-dropdown-icon">
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical">
                                                                <circle cx="12" cy="12" r="1"></circle>
                                                                <circle cx="12" cy="5" r="1"></circle>
                                                                <circle cx="12" cy="19" r="1"></circle>
                                                            </svg>
                                                        </a>

                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink-2">

                                                            <a class="dropdown-item delete" href="support_tickets.php?ticket_id=<?= $support_list->id ?>&action=delete" onclick="return confirm('Are you sure you want to delete the Support Ticket?')">Delete</a>
                                                            <a class="dropdown-item" href="support_tickets.php?ticket_id=<?= $support_list->id ?>&support_ticket=close" onclick="return confirm('Are you sure you want to close the Support Ticket?')">Complete</a>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                        $count++;
                                    }

                                    ?>

                                </div>

                                <div class="modal fade" id="todoShowListItem" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="modal">
                                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                                </svg>
                                                <div class="compose-box">
                                                    <div class="compose-content">
                                                        <h5 class="task-heading"></h5>
                                                        <p class="task-text"></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn" data-dismiss="modal"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                    </svg> Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php include '../../includes/footer.php' ?>
                    <!-- <script src="../../assets/js/ie11fix/fn.fix-padStart.js"></script>
                    <script src="../../plugins/editors/quill/quill.js"></script>
                    <script src="../../assets/js/apps/todoList.js"></script> -->
                    <script>
                        $(document).ready(function() {
                            $('#todo-task-important').trigger('click');
                            const ps = new PerfectScrollbar('.todo-box-scroll', {
                                suppressScrollX: true
                            });
                            const todoListScroll = new PerfectScrollbar('.todoList-sidebar-scroll', {
                                suppressScrollX: true
                            });
                            $('#addTaskModal').css('display', 'none');
                        })
                    </script>