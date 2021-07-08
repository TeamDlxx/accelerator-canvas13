<?php
include 'include/config.php';
include 'include/functions.php';

//For Registration
$first_name = "";
$sur_name = "";
$email = "";
$error = "";
$success = "";

//For Contact Message
// Assigning Values to Veriables
$first_name = test_input($_POST['first_name']);
$sur_name = test_input($_POST['sur_name']);
$email = email_validation($_POST['email']);

$active_campaign =  active_campign($first_name, $sur_name, $email, $url_campagin, $token, $list_id, $error_support, $error, $success, $connection_string);

echo json_encode($active_campaign);
