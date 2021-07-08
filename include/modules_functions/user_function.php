<?php
function get_user_list($connection_string)
{
    $get_data = array();
    $get_user_list = "SELECT * FROM subscribers order by `id` DESC";
    $get_user_list_info_result = mysqli_query($connection_string, $get_user_list);

    if (mysqli_num_rows($get_user_list_info_result) == 0) {
        return array('status' => 0, 'get_info' => $get_data);
    } else {
        $get_data = mysqli_fetch_all($get_user_list_info_result, MYSQLI_ASSOC);
        return array('status' => 1, 'get_info' => $get_data);
    }
}
/*********Get Last five records */
function get_recent_subscriber_user_list($connection_string)
{
    $get_data = array();
    $get_user_list = "SELECT * FROM subscribers  order by `id` DESC LIMIT 5";
    $get_user_list_info_result = mysqli_query($connection_string, $get_user_list);

    if (mysqli_num_rows($get_user_list_info_result) == 0) {
        return array('status' => 0, 'get_info' => $get_data);
    } else {
        $get_data = mysqli_fetch_all($get_user_list_info_result, MYSQLI_ASSOC);
        return array('status' => 1, 'get_info' => $get_data);
    }
}
function get_event_list($connection_string, $table_name)
{
    $get_data = array();
    $get_user_list = "SELECT * FROM $table_name  ";
    $get_user_list_info_result = mysqli_query($connection_string, $get_user_list);

    if (mysqli_num_rows($get_user_list_info_result) == 0) {
        return array('status' => 0, 'get_info' => $get_data);
    } else {
        $get_data = mysqli_fetch_all($get_user_list_info_result, MYSQLI_ASSOC);
        return array('status' => 1, 'get_info' => $get_data);
    }
}
/*************Get User Data BY id */
function get_user_info_by_id($connection_string, $user_id)
{
    $get_data = array();
    $select_uesr_query = "SELECT * FROM `subscribers` where `id`=$user_id ";
    $select_uesr_query_result = mysqli_query($connection_string, $select_uesr_query);
    if (mysqli_num_rows($select_uesr_query_result) == 0) {
        return array('status' => 0, 'get_info' => $get_data);
    } else {
        $get_data = mysqli_fetch_object($select_uesr_query_result);
        return array('status' => 1, 'get_info' => $get_data);
    }
}
/********check if user already exists */
function email_exist($connection_string, $email)
{
    $existance_query = "SELECT * FROM `subscribers` WHERE `email` = '$email' ";
    $existance_query_result = mysqli_query($connection_string, $existance_query);
    if (mysqli_num_rows($existance_query_result) > 0) {
        return false;
    } else {
        return true;
    }
}
/*********token function */
function getToken($length)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet .= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i = 0; $i < $length; $i++) {
        $token .= $codeAlphabet[random_int(0, $max - 1)];
    }

    return $token;
}
function user_purchased_event($connection_string, $user_id, $event_id)
{
    $get_data = array();
    $subscriber_query = "select `user_id`, `event_id` from `event_payment` where `user_id`= '$user_id' and `event_id`='$event_id'";
    $subscriber_query_result = mysqli_query($connection_string, $subscriber_query);
    if (mysqli_num_rows($subscriber_query_result) == 0) {
        return array('status' => 0, 'get_info' => $get_data);
    } else {
        $get_data = mysqli_fetch_object($subscriber_query_result);
        return array('status' => 1, 'get_info' => $get_data);
    }
}
function get_user_info_by_email($connection_string, $email)
{
    $get_data = array();
    $existance_query = "SELECT * FROM `subscribers` WHERE `email` = '$email' ";
    $existance_query_result = mysqli_query($connection_string, $existance_query);
    if (mysqli_num_rows($existance_query_result) == 0) {
        return array('status' => 0, 'get_info' => $get_data);
    } else {
        $get_data = mysqli_fetch_object($existance_query_result);
        return array('status' => 1, 'get_info' => $get_data);
    }
}
