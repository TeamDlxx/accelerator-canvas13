<?php
include '../../../include/config.php';
include '../../../include/functions.php';
// include '../../../includes/admin_auth.php';
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}

$color = $text = '';
$active_menu = "tickets";
$error = $success = "";
$page_title = "Support Tickets";
$support_ticket = true;
$ticket_details = true;
$support_ticket = array();

$api_url = $support_api_url . "API/support_ticket_list.php?project_id=" . $project_id;
$result = invokeApi('GET', $api_url, $data = '');
$tickets_result = json_decode($result);

if ($tickets_result->status === 1) {
    $support_ticket = $tickets_result->get_info;
}

?>
<!--  BEGIN NAVBAR  -->
<?php include '../../includes/header.php'; ?>
<!--  END NAVBAR  -->

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
                            <!-- <li class="breadcrumb-item"><a href="javascript:void(0);">Apps</a></li> -->
                            <li class="breadcrumb-item active" aria-current="page"><span>Support Tickets</span></li>
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
            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="row">
                        <div class="col-xl-12  col-md-12">
                            <div class="mail-box-container">
                                <div class="mail-overlay"></div>
                                <div id="mailbox-inbox" class="accordion mailbox-inbox">
                                    <div class="row" style="float: right;">
                                        <div class="text-center mt-2">
                                            <a style="background-color: #1b55e2 ;color:blanchedalmond" id="btn-compose-mail" class="btn btn-block" href="javascript:void(0);">
                                                Add Ticket
                                            </a>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-12 mail-categories-container">
                                            <div class="mail-sidebar-scroll">
                                            </div>
                                        </div>

                                    </div>



                                    <div class="row action-center">

                                        <div class="col-md-8">
                                            <div class="n-chk">
                                                <label class="new-control">
                                                    <input type="checkbox" class="new-control-input" id="inboxAll">
                                                    <span class="new-control-indicator"></span><strong>Support Tickets</strong>
                                                </label>


                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="n-chk" style="text-align: center;">
                                                <label class="new-control">
                                                    <input type="checkbox" class="new-control-input" id="inboxAll">
                                                    <span class="new-control-indicator"></span><strong>Ticket Status</strong>
                                                </label>


                                            </div>
                                        </div>
                                    </div>

                                    <div class="message-box">
                                        <div class="message-box-scroll" id="ct">
                                            <?php
                                            if (empty($support_ticket)) {
                                                echo "<p>No Ticket Found</p>";
                                            }
                                            foreach ($support_ticket as $support_ticket_info) { ?>
                                                <div id="unread-promotion-page" class="mail-item mailInbox">
                                                    <div class="animated animatedFadeInUp fadeInUp" id="">
                                                        <div class="mb-0">
                                                            <div class="mail-item-heading social collapsed">
                                                                <div class="mail-item-inner">
                                                                    <div class="d-flex">
                                                                        <div class="f-body">
                                                                            <div class="meta-mail-time">
                                                                                <a href="ticket_details.php?ticket_id=<?= $support_ticket_info->id ?>">
                                                                                    <p class="user-email">
                                                                                        <?= $support_ticket_info->subject ?></p>
                                                                                </a>
                                                                            </div>
                                                                            <div class="meta-title-tag">
                                                                                <a href="ticket_details.php?ticket_id=<?= $support_ticket_info->id ?>">
                                                                                    <p class="mail-content-excerpt">
                                                                                        <?php $speccified_string =  $support_ticket_info->description;
                                                                                        echo substr($speccified_string, 0, 200) ?>
                                                                                    </p>
                                                                                </a>
                                                                                <div class="col-4" style="display: flex;justify-content:space-between">
                                                                                    <div class="" id="result<?php echo $support_ticket_info->id ?>">
                                                                                        <?php
                                                                                        if ($support_ticket_info->status == 0) {
                                                                                            $class = 'btn-success';
                                                                                            $text = "Closed";
                                                                                            $style = "background:#d73a49;border:#d73a49;border-radius:20px";
                                                                                        } else {
                                                                                            $class = 'btn-success';
                                                                                            $text = "Open";
                                                                                            $style = "background:#28a745;border:#28a745;border-radius:20px";
                                                                                        }
                                                                                        ?>
                                                                                        <span class="btn <?= $class ?>" onclick="changeStatus('<?= $support_ticket_info->status ?>','<?= $support_ticket_info->id ?>')" id="status" style="<?= $style ?>"><?= $text ?></span>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <p style="padding: 5px;"><?= $support_ticket_info->date_time;  ?> </p>
                                                                                        <!-- <p style="padding: 5px;">(6:28 PM)</p> -->
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php $color = $text = '';
                                                                if ($support_ticket_info->ticket_type === 'issue') {
                                                                    $class = 'issue';
                                                                    $text = 'Issue';
                                                                } elseif ($support_ticket_info->ticket_type === 'new_feature') {
                                                                    $class = 'new';
                                                                    $text = 'New Feature';
                                                                }
                                                                ?>
                                                                <style>
                                                                    .new {
                                                                        display: inline-block !important;
                                                                        border: 1px solid #28a745 !important;
                                                                        padding: 1px 11px !important;
                                                                        border-radius: 30px !important;
                                                                        color: #fff !important;
                                                                        background: #28a745 !important;
                                                                        font-size: 12px !important;
                                                                        margin-right: 3px !important;
                                                                        font-weight: 700 !important;
                                                                        margin-bottom: 2px !important;
                                                                        letter-spacing: 0px !important;
                                                                        max-width: 96px !important;
                                                                        overflow: hidden !important;
                                                                        text-overflow: ellipsis !important;
                                                                        white-space: nowrap !important;
                                                                    }

                                                                    .issue {
                                                                        display: inline-block !important;
                                                                        border: 1px solid #d73a49 !important;
                                                                        padding: 1px 11px !important;
                                                                        border-radius: 30px !important;
                                                                        color: #fff !important;
                                                                        background: #d73a49 !important;
                                                                        font-size: 12px !important;
                                                                        margin-right: 3px !important;
                                                                        font-weight: 700 !important;
                                                                        margin-bottom: 2px !important;
                                                                        letter-spacing: 0px !important;
                                                                        max-width: 96px !important;
                                                                        overflow: hidden !important;
                                                                        text-overflow: ellipsis !important;
                                                                        white-space: nowrap !important;
                                                                    }
                                                                </style>
                                                                <div style="margin-left: 20rem;">
                                                                    <div class="<?= $class ?>">
                                                                        <span class=""><?= $text ?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="composeMailModal" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="modal">
                                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                                    </svg>
                                                    <div class="compose-box">
                                                        <div class="compose-content">
                                                            <form id="ticket-form-2" method="POST" enctype="multipart/form-data">
                                                                <div class="row">
                                                                    <div class="mx-auto mb-2">
                                                                        <h4>Add New Ticket</h4>
                                                                        <span style="color:red" id="ticket-result"></span>
                                                                    </div>
                                                                    <div class="col-md-6" style="display: none;">
                                                                        <div class="d-flex mb-4 mail-to">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2">
                                                                                </path>
                                                                                <circle cx="12" cy="7" r="4"></circle>
                                                                            </svg>
                                                                            <div class="">
                                                                                <input type="email" id="m-to" placeholder="To" class="form-control">
                                                                                <span class="validation-text"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6" style="display: none;">
                                                                        <div class="d-flex mb-4 mail-cc">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list">
                                                                                <line x1="8" y1="6" x2="21" y2="6"></line>
                                                                                <line x1="8" y1="12" x2="21" y2="12"></line>
                                                                                <line x1="8" y1="18" x2="21" y2="18"></line>
                                                                                <line x1="3" y1="6" x2="3" y2="6"></line>
                                                                                <line x1="3" y1="12" x2="3" y2="12"></line>
                                                                                <line x1="3" y1="18" x2="3" y2="18"></line>
                                                                            </svg>
                                                                            <div>
                                                                                <input type="text" id="m-cc" placeholder="Cc" class="form-control">
                                                                                <span class="validation-text"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="d-flex mb-4 mail-subject">
                                                                    <div style="width: 100%;">
                                                                        <input type="text" id="m-subject" name="subject" placeholder="Subject" class="form-control">
                                                                        <span class="validation-text"></span>
                                                                    </div>
                                                                </div>
                                                                <!-- <div class="d-flex">
                                                                    <input type="file" class="form-control mb-4" id="mail_File_attachment" multiple="multiple">
                                                                </div> -->

                                                                <div class="d-flex mb-4 mail-subject">
                                                                    <select class="form-control" id="menu_status" name="ticket_type">
                                                                        <option value="new_feature">New Feature </option>
                                                                        <option value="issue">Issue</option>
                                                                    </select>
                                                                </div>
                                                                <div class="d-flex mb-4 mail-subject form-control">
                                                                    <div class="w-100">
                                                                        <input type="file" id="file" name="support_file">
                                                                        <span class="validation-text"></span>
                                                                    </div>
                                                                </div>

                                                                <div id="" class=" mt-2">
                                                                    <textarea style="background: #1b2e4b;border: #1b2e4b;border-radius: 5px;padding:0.75rem 1.25rem;color: #009688;font-size: 15px;letter-spacing: 1px;" placeholder="Description" rows="12" cols="52" name="description" id="description"></textarea>
                                                                </div>
                                                                <!-- <input type="hidden" name="client_id" value="4"> -->
                                                                <input type="hidden" name="project_id" value="<?= $project_id ?>">
                                                                <div class="modal-footer">
                                                                    <button class="btn" data-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn" style="background-color: #1b55e2;color:blanchedalmond;height: 41px;width: 90px;">Send</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include '../../includes/footer.php' ?>
                <script>
                    $(document).ready(function() {
                        $('.ql-toolbar').hide();
                    })

                    $(document).ready(function() {

                        $("#ticket-form-2").submit(function(e) {
                            e.preventDefault();
                            var formData = new FormData(this);
                            $.ajax({
                                url: "<?= $support_api_url ?>API/add_ticket.php",
                                // url: "add_ticket.php",
                                type: 'POST',
                                data: formData,
                                success: function(data) {
                                    data = JSON.parse(data);
                                    if (data.status == 1) {
                                        $("#ticket-form-2").trigger("reset");
                                        $('#ticket-result').css('color', 'green');
                                        $('#ticket-result').html("Ticket Submitted Successfully");
                                        setInterval(function() {
                                            location.reload();
                                        }, 1500);
                                    } else {
                                        $('#ticket-result').css('color', 'red');
                                        $('#ticket-result').html(data.message);
                                    }
                                },
                                cache: false,
                                contentType: false,
                                processData: false
                            });
                        });
                    });
                </script>