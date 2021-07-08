<?php
function get_client_info($connection_string)
{
    $get_info = array();
    $client_info_query = "SELECT * FROM `clients`";
    $client_info_query_result = mysqli_query($connection_string, $client_info_query);
    if (mysqli_num_rows($client_info_query_result) == 0) {
        return array('status' => "0", 'get_info' => $get_info);
    } else {
        while ($client_result = mysqli_fetch_array($client_info_query_result)) {
            $get_info[] = $client_result;
        }
        return array('status' => "1", 'get_info' => $get_info);
    }
}

function get_client_info_by_id($connection_string, $client_id)
{
    $get_info = array();
    $client_info_query = "SELECT * FROM `clients` WHERE `client_id`=$client_id";
    $client_info_query_result = mysqli_query($connection_string, $client_info_query);
    if (mysqli_num_rows($client_info_query_result) == 0) {
        return array('status' => "0", 'get_info' => $get_info);
    } else {
        $get_info = mysqli_fetch_object($client_info_query_result);
        return array('status' => "1", 'get_info' => $get_info);
    }
}

function get_acive_client_info($connection_string)
{
    $get_info = array();
    $client_info_query = "SELECT * FROM `clients` where `status`= 1";
    $client_info_query_result = mysqli_query($connection_string, $client_info_query);
    if (mysqli_num_rows($client_info_query_result) == 0) {
        return array('status' => "0", 'get_info' => $get_info);
    } else {
        while ($client_result = mysqli_fetch_array($client_info_query_result)) {
            $get_info[] = $client_result;
        }
        return array('status' => "1", 'get_info' => $get_info);
    }
}
