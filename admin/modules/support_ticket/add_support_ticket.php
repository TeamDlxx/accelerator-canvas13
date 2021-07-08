<?php
include '../../../include/config.php';
include '../../../include/functions.php';
include '../../includes/admin_auth.php';
$active_menu = "support_tickets";
/*********************if admin is not logged in it will be re directed to index page */
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
$error = $success = "";
/*********initialize all fields */
$page_title = "Add Support Ticket ";

/*********when user click the add button it  add new ticket*/
if (isset($_POST['submit'])) {
    $subject = $_POST['subject'];
    $ticket_type = $_POST['ticket_type'];
    $description = $_POST['description'];
    if (!empty($_FILES['support_file']['name'])) {
        $support_file = new CURLFile($_FILES['support_file']['tmp_name'], $_FILES['support_file']['name']);
        $support_file_name = $_FILES['support_file']['name'];
    }
    $post_data  = array(
        'subject' => $subject,
        'ticket_type' => $ticket_type,
        'description' => $description,
        'project_id' => $project_id,
        'support_file' => $support_file,
        'suppport_file_name' => $support_file_name
    );


    $add_member_api_url = "API/add_ticket.php";
    $content_type = "application/json";
    $add_member = ApiCalling('POST', $add_member_api_url, $post_data);
    if ($add_member['data']['status'] == 1) {
        header("Location: support_tickets.php");
    } else {
        $error = $add_member['data']['message'];
    }
}

?>
<!--  HEADER  -->
<?php include '../../includes/header.php'; ?>
<!-- END HEADER  -->

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
                            <!-- <li class="breadcrumb-item"><a href="javascript:void(0);">Add</a></li> -->
                            <li class="breadcrumb-item active" aria-current="page"><span>Create Support Ticket</span></li>
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
            <div class="account-settings-container layout-top-spacing">
                <?php
                if ($error != "") {
                ?>
                    <div class="alert text-center alert-danger alert-dismissible " role="alert" style="width:50%; margin-left:23%; margin-right:25%;">
                        <button type="button" id="ticket-result-sucs" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <?= $error; ?>
                    </div>
                <?php } else if ($success != "") {
                ?>
                    <div class="alert text-center alert-success alert-dismissible " role="alert" style="width:50%; margin-left:23%; margin-right:25%;">
                        <button type="button" id="ticket-result" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <?= $success; ?>
                    </div>
                <?php } ?>
                <div class="account-content">
                    <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                <form id="ticket-form-2" method="POST" class="section contact" enctype="multipart/form-data">
                                    <div class="info">
                                        <h5 class="" style="padding-left: 35px;">Create Support Ticket</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <span id=""></span>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="subject">Support Ticket Subject</label>
                                                            <input type="text" class="form-control mb-4" id="subject" placeholder="Ticket Subject " value="" name="subject" required>

                                                        </div>
                                                    </div>
                                                    <input type="hidden" value="<?= $project_id ?>" name="project_id">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="testimonial_image">Support File</label>
                                                            <input type="file" class="form-control mb-4" id="testimonial_image" placeholder="Support File " value="" name="support_file">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 d-none">
                                                        <div class="form-group">
                                                            <label for="ticket_type">Ticket Type</label>
                                                            <select class="form-control" id="ticket_type" name="ticket_type">
                                                                <option value="new_feature">Looking for new support</option>
                                                                <option value="issue">Something Not Working</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="description">Description</label>
                                                            <textarea type="text" rows="5" cols="4" class="form-control mb-4" id="description" placeholder="Description" value="" name="description"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 text-right mb-5">
                                                        <a href=""><button id="add-work-platforms" name="submit" class="btn btn-primary">Create Support Ticket</button></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  END CONTENT AREA  -->
            </div>

            <!-- FOOTER BEGIN -->
            <?php include '../../includes/footer.php'; ?>
            <script>
                $(document).ready(function() {

                    // $("#ticket-form-2").submit(function(e) {
                    //     e.preventDefault();
                    //     var formData = new FormData(this);
                    //     $.ajax({
                    //         headers: {
                    //             "X-Api-Key": "<?= $api_key ?>",
                    //         },
                    //         url: "<?= $support_api_url ?>API/add_ticket.php",
                    //         type: 'POST',
                    //         data: formData,
                    //         success: function(data) {
                    //             alert(data);
                    //             data = JSON.parse(data);
                    //             if (data.status == 1) {
                    //                 $("#ticket-form-2").trigger("reset");
                    //                 $('#ticket-result-sucs').css('color', 'green');
                    //                 $('#ticket-result-sucs').html("Ticket Submitted Successfully");

                    //                 $(location).attr('href', 'support_tickets.php');

                    //             } else {
                    //                 $('#ticket-result').css('color', 'red');
                    //                 $('#ticket-result').html(data.message);
                    //             }
                    //         },
                    //         cache: false,
                    //         contentType: false,
                    //         processData: false
                    //     });
                    // });
                });
            </script>
            <!-- FOOTER END -->