<?php
include '../../../include/config.php';
$error = $success = '';
if (isset($_POST['status']) && isset($_POST['ticket_id'])) {
    $id = $_POST['ticket_id'];
    if ($_POST['status'] == 1) {
        $status = 0;
        $update_status = "UPDATE `support_tickets` SET `status`=0 WHERE `id`='$id'";
    } else {
        $status = 1;
        $update_status = "UPDATE `support_tickets` SET `status`=1 WHERE `id`='$id'";
    }
    $update_status_result = mysqli_query($connection_string, $update_status);
    if ($update_status_result) {
        $success = "Status Updated Successfully";
    } else {
        $error = $error_support;
    }
    if ($error !== '') {
        $array = array('status' => 0, 'new_status' => $status, 'message' => $error);
    } else {
        $array = array('status' => 1, 'new_status' => $status, 'message' => $success);
    }
    echo json_encode($array);
}


