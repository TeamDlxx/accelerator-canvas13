<?php
include '../../../include/config.php';
include '../../../include/functions.php';
$message_image = "";
$append_message =   "";
$support_file_name  =   "";
$ticket_id  = test_input($_POST['ticket_id']);
$message    = test_input($_POST['message']);
$user_type  = test_input($_POST['user_type']);
$project_id = test_input($_POST['project_id']);
$status     = $_POST['status'];
if (!empty($_FILES['image']['name'])) {
    $message_image = new CURLFile($_FILES['image']['tmp_name']);
    $support_file_name = $_FILES['image']['name'];
}
$post_data  = array(
    'ticket_id' => $ticket_id,
    'message' => $message,
    'user_type' => $user_type,
    'project_id' => $project_id,
    'image' => $message_image,
    'support_file_name' => $support_file_name,
    'status' => $status

);
$add_message_api_url = "API/add_message.php";
$content_type = "application/json";
$result = ApiCalling('POST', $add_message_api_url, $post_data);
// get all messages
$message_status = $result['data']['status'];
if ($result['data']['status'] == 1) {
    $api_url = "API/support_tickets/support_ticket_detail.php?ticket_id=" . $ticket_id;
    $result = ApiCalling('GET', $api_url);
    if ($result['data']['status'] == 1) {
        $ticket_status = $result['data']['status'];
        $get_info = $result['data']['get_info'];
        $ticket_reply = $result['data']['ticket_reply'];
        $reply_by = $result['data']['reply_by'];
        $ticket_reply_length = sizeof($ticket_reply);
        for ($i = 0; $i < $ticket_reply_length; $i++) {
            $link_image = "";
            $date = $ticket_reply[$i]['date_time'];
            $newDate = date("d M y H:i A", strtotime($date));
            $message_message  = $ticket_reply[$i]['message'];
            $message_image    = $ticket_reply[$i]['reply_image'];
            $admin_name = $ticket_reply[$i]['admin_name'];
            $client_name = $ticket_reply[$i]['client_name'];
            if (empty($client_name)) {
                $client_name = $reply_by;
            }


            $append_message .=   " <div class='card component-card_4 mx-auto col-12' style='padding:0%; margin-right:10px !important;   margin-bottom: 10px;'>
            <div class='card-header' style='background-color: #1a1c2d;'>
                <div class='row' style='float: right;'>
                    <p style='padding: 10px;'>";
            $append_message =   $append_message . $newDate;
            $append_message =   $append_message . "</p></div>
                <div class='row'>
                    <div style='height: 30px; float:left; width:30px'>
                        <svg aria-hidden='true' focusable='false' data-prefix='fas' data-icon='user-tie' class='svg-inline--fa fa-user-tie fa-w-14' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512'>
                            <path fill='currentColor' d='M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm95.8 32.6L272 480l-32-136 32-56h-96l32 56-32 136-47.8-191.4C56.9 292 0 350.3 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-72.1-56.9-130.4-128.2-133.8z'></path>
                        </svg>
                    </div>
                    <p class='' style='margin-bottom: 0px;margin-left: 5px'>";
            $append_message =  $append_message . $client_name;
            $append_message =  $append_message  . "</p>
                </div>
            </div>";
            $append_message  =   $append_message . "<div class='card-body'>
                <div class='user-info' style='margin-left: 20px;'>
                    <p class='card-text'>";
            $append_message =   $append_message . $message_message;
            $append_message =   $append_message . "</p>";
            if (!empty($message_image)) {
                $append_message =   $append_message . "</p><a href='";
                $append_message =   $append_message . $support_api_url . $message_image;
                $append_message =   $append_message . "' target='_blank'><img alt='' width='200' src='";
                $append_message =   $append_message . $support_api_url . $message_image;
                $append_message =   $append_message . "'></a>";
            }

            $append_message =   $append_message . "
                </div>
            </div>
        </div>";
        }
    } else {
        $error = $result_decoded['message'];
    }
}
print_r(json_encode(array('status' => $message_status, 'message' => $append_message)));
