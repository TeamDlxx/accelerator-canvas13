<?php

include 'include/config.php';
include 'include/functions.php';

//For Registration
$first_name = "";
$sur_name = "";
$phone = "";
$email = "";
$error = "";
$success = "";
// Checking Values Should not Empty

$user_name = test_input($_POST['user_name']);
$phone = test_input($_POST['phone']);
$email = test_input($_POST['email']);
$subject = test_input($_POST['subject']);
$contact_message = test_input($_POST['message']);

if (empty($user_name)) {
    $error = 'Name is required. ';
} else if (empty($phone)) {
    $error = 'Phone Number is required. ';
} else if (empty($email)) {
    $error = 'Email is required. ';
} else if (empty($subject)) {
    $error = 'Email Subject is required. ';
} else if (empty($contact_message)) {
    $error = 'Message is required. ';
}

if (empty($error)) {

    //Send Email to the Admin
    $email_subject = $email_subject1;
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From:' . $user_name . "\r\n";
    // $message = "<p>New Contact requests was submitted from Canvasone Contact website. Following are the details of Registration request</p>";

    $message = $contact_email_message;
    $message .= '<p><strong>Name: </strong>' . $user_name . '</p>';
    $message .= '<p><strong>Phone: </strong>' . $phone . '</p>';
    $message .= '<p><strong>Email: </strong>' . $email . '</p>';
    $message .= '<p><strong>Email Subject: </strong>' . $subject . '</p>';
    $message .= '<p><strong>Message: </strong>' . $contact_message . '</p>';

    //mail(To, Subject, Message, Header(From))

    if (mail($admin_email, $email_subject, $message, $headers)) {
        if (json_encode(array("statusCode" => 200))) {
            $success = "Thanks for filling out our form!";
        } else {
            $error = $error_support;
        }
    }
}

if ($error != '') {

    $arrray = array('status' => "0", 'message' => $error);
} else {
    $arrray = array('status' => "1", 'message' => $success);
}
echo json_encode($arrray);
