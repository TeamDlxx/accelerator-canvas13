<?php
include('../../../include/config.php');
include('../../../include/functions.php');
$subject = $_POST['subject'];
$description = $_POST['description'];

$data = array(
    'subject' => $subject,
    'description' => $description
);
if (isset($_FILES['support_file']['name']) && file_exists($_FILES['support_file']['tmp_name']) && is_uploaded_file($_FILES['support_file']['tmp_name'])) {
    // $data['support_file'] = new CURLFile($_FILES['support_file']['tmp_name'], $_FILES['support_file']['name']);
    // $data['support_file_name'] = $_FILES['support_file']['name'];
}

$content_Type = "Content-Type: application/json";
$header = array($content_Type);
$api_url_message = $super_admin_url."/API/add_ticket.php";
$result = api_calling_2('POST', $api_url_message, $data, $header);

if ($result == 1) {
    // header('Location:ticket_details.php?ticket_id=' . $ticket_id);
} else {
    $error = $error_support;
}
