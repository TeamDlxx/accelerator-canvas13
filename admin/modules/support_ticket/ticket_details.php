<?php
include '../../../include/config.php';
include '../../../include/functions.php';
// include '../../includes/admin_auth.php';
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
$ticket_details = true;

$active_menu = "support_tickets";
$error = $success = "";
$page_title = "Ticket Details";


if (isset($_GET['ticket_id'])) {
    $ticket_id = $_GET['ticket_id'];
}
$api_key = constant("X-Api-Key");
$admin = $_SESSION['admin_info'];

// Call an Api for seen status of the ticket Messages
$api_url_ticket =  "API/seen.php?ticket_id=" . $ticket_id;
$api_result = ApiCalling('GET', $api_url_ticket);

// Call an Api for fetching the ticket details
$api_url = "API/support_ticket_details.php?ticket_id=" . $ticket_id;
$result = ApiCalling('GET', $api_url);
if ($result['data']['status'] === 1) {
    $support_ticket = $result['data']['get_info'];
}

// Call an Api for fetching the ticket Messages
$api_url_ticket =  "API/ticket_reply.php?ticket_id=" . $ticket_id;
$api_result = ApiCalling('GET', $api_url_ticket);
//Call an Api to enter message
if (isset($_POST['reply'])) {
    $message = $_POST['message'];
    $admin_name = $_SESSION['admin_info'];
    $data = array(
        'message' => $message,
        'ticket_id' => $ticket_id,
        'user_name' => $admin_name->admin_name
    );
    $api_url_message = $support_api_url . "API/add_message.php";
    $result = callAPI('POST', $api_url_message, json_encode($data));
    if ($result == 1) {
        header('Location:ticket_details.php?ticket_id=' . $ticket_id);
    } else {
        $error = $error_support;
    }
}





?>
<!-- BEGIN NAVBAR -->
<?php include '../../includes/header.php'; ?>
<link href="../../assets/css/custom_style.css" rel="stylesheet" type="text/css" />
<!-- END NAVBAR -->

<!-- BEGIN NAVBAR -->
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
                            <li class="breadcrumb-item active" aria-current="page"><span>Support Ticket Description</span></li>
                        </ol>
                    </nav>

                </div>
            </li>
        </ul>
        <?php include '../../includes/side_header.php'; ?>
    </header>
</div>
<!-- END NAVBAR -->

<!-- BEGIN MAIN CONTAINER -->
<div class="main-container" id="container">

    <div class="overlay"></div>
    <div class="search-overlay"></div>

    <!-- BEGIN SIDEBAR -->
    <?php include '../../includes/sidebar.php'; ?>
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="col-xl-12 col-md-12">
                        <div>
                            <div id="scrollend" class="message-box">
                                <div class="message-box-scroll" style="margin: auto;width: 100%;overflow: auto;position: relative;" id="ct">
                                    <div class="d-flex mt-4">
                                        <a style="font-size: 15px;color: #bfc9d4;padding: 3px;align-self: center;cursor: pointer;margin-right: 12px;" href="support_tickets.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left close-message">
                                                <line x1="19" y1="12" x2="5" y2="12"></line>
                                                <polyline points="12 19 5 12 12 5"></polyline>
                                            </svg></a>
                                        <h2 style="font-size: 24px;font-weight: 600;color: #25d5e4;margin-bottom: 0;align-self: center;"><?= $support_ticket['subject'] ?></h2>
                                        <!-- <a style="    position: relative;left: 835px;" href="#ticket-form"> <button type="submit" class="btn btn-primary reply ">Reply</button></a> -->
                                        <!-- <div class="col-12 text-right" style="padding: 10px;"> -->

                                        <!-- </div> -->
                                    </div>

                                    <div class="mail-content-container  mailInbox">
                                        <p style="padding-top: 45px; margin-bottom: 25px;border-top: 1px solid #191e3a;margin-top: 40px;font-size: 14px;color: #bfc9d4; word-wrap: break-word;" data-mailTitle="Promotion Pa">
                                            <?= $support_ticket['description'] ?>
                                        </p>
                                    </div>
                                    <?php if (!empty($support_ticket['image'])) { ?>
                                        <div class="gallery mb-5">
                                            <a class="btn btn-primary" href="<?= $support_api_url . $support_ticket['image'] ?>" target="_blank">View Attacment</a>
                                        </div>
                                    <?php } ?>
                                    <div style="width:99%;" id="messages-list">
                                        <!-- Message Box -->
                                        <?php if ($api_result['data']['status'] === 1) {
                                            $message_result_info = $api_result['data']['get_info'];
                                            $project_reply_by = $api_result['data']['reply_by'];
                                            foreach ($message_result_info as $message_box_info) {
                                                $date = date('Y/m/d', strtotime($message_box_info['date_time']));
                                                $time = date('H:i:s', strtotime($message_box_info['date_time']));
                                                if ($message_box_info['user_type'] == 'client') {
                                                    $user_name = $message_box_info['client_name'];
                                                } else if ($message_box_info['user_type'] == 'admin') {
                                                    $user_name =  $project_reply_by;
                                                } else {
                                                    $user_name = "User";
                                                }
                                        ?>

                                                <div class="card component-card_4 col-12" style="padding:0%; margin-bottom: 10px;">
                                                    <div class="card-header" style="background-color: #1a1c2d;">
                                                        <div class="row" style="float: right;">
                                                            <p style="padding: 10px;"><?= $date ?></p>
                                                            <p class="align-self-center">(<?= $time ?>)</p>
                                                        </div>
                                                        <div class="row">
                                                            <div style="height: 30px; float:left; width:30px">
                                                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-tie" class="svg-inline--fa fa-user-tie fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                                    <path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm95.8 32.6L272 480l-32-136 32-56h-96l32 56-32 136-47.8-191.4C56.9 292 0 350.3 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-72.1-56.9-130.4-128.2-133.8z"></path>
                                                                </svg>
                                                            </div>
                                                            <p class="" style="margin-bottom: 0px;margin-left: 5px;margin-top:auto;"><?= $user_name ?></p>
                                                        </div>

                                                    </div>
                                                    <?php $message_contain_image = $message_box_info['message'];
                                                    if (strpos($message_contain_image, "@") !== false) {
                                                        $message_image = explode('@', $message_contain_image);
                                                        $message = $message_image[0];
                                                        $new_message = str_replace('@', "", $message);
                                                        $image = $message_image[1];
                                                    } else {
                                                        $message = $message_box_info['message'];
                                                        $image = "";
                                                    } ?>
                                                    <div class="card-body">
                                                        <div class="user-info" style="margin-left: 20px;">
                                                            <p class="card-text"><?= stripslashes(htmlspecialchars_decode($message))  ;?></p>
                                                            <?php if(!empty($message_box_info['reply_image']))
                                                            {?>
                                                            <a href="<?=$support_api_url.$message_box_info['reply_image'];?>" target="_blank"><img src="<?=$support_api_url.$message_box_info['reply_image'];?>" width="200"></a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>

                                        <?php }
                                        } ?>
                                    </div>

                                    <div id="end" class="chat-footer">
                                        <div class="chat-input col-12" style="width: 99%; padding: 0%;">
                                            <form method="POST" id="ticket-form" enctype="multipart/form-data">
                                                <input type="hidden" name="project_id" value="<?= $project_id ?>">
                                                <input type="hidden" name="user_type" value="client">
                                                <input type="hidden" name="ticket_id" id="ticket_id" value="<?php echo $ticket_id ?>">
                                                <input type="hidden" id="status" conf name="status" value="<?= $support_ticket['status'] ?>">
                                                <textarea type="text" name="message" id="message" rows="3" cols="6" class="mail-write-box form-control" placeholder="Message"></textarea>
                                                <span id="message-result"></span>
                                                <div id="end"></div>
                                                <div class="col-md-12 text-right" style="padding: 10px;">
                                                    <label class="custom-input" style="background: #1b55e2;color: white;padding: 7px 12px;cursor: pointer;border-radius: 4px;">

                                                        <input type="file" style="display: none;" name="image" id="image">
                                                        Upload Attachment
                                                    </label>
                                                    <button type="submit" id="reply" name="reply" class="btn btn-primary reply">Reply</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div id="end"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php include '../../includes/footer.php' ?>
        <script>
            $(document).ready(function() {
                window.location.href = '#end';




            })
        </script>