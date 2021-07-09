<?php
//Get service onfo
function get_services_info($connection_string)
{
    $get_info = array();
    $service_info_query = "SELECT * FROM `services` order by `service_order`";
    $service_info_query_result = mysqli_query($connection_string, $service_info_query);
    if (mysqli_num_rows($service_info_query_result) == 0) {
        return array('status' => "0", 'get_info' => $get_info);
    } else {
        while ($service_result = mysqli_fetch_array($service_info_query_result)) {
            $get_info[] = $service_result;
        }
        return array('status' => "1", 'get_info' => $get_info);
    }
}

function get_active_services_info($connection_string)
{
    $get_info = array();
    $service_info_query = "SELECT * FROM `services` WHERE `status` = 1 ORDER BY `service_order` ASC";
    $service_info_query_result = mysqli_query($connection_string, $service_info_query);
    if (mysqli_num_rows($service_info_query_result) == 0) {
        return array('status' => "0", 'get_info' => $get_info);
    } else {
        while ($service_result = mysqli_fetch_array($service_info_query_result)) {
            $get_info[] = $service_result;
        }
        return array('status' => "1", 'get_info' => $get_info);
    }
}

//Get service data by id
function get_services_info_by_id($connection_string, $service_id)
{
    $get_info = array();
    $service_info_query = "SELECT * FROM `services` WHERE `id`=$service_id";
    $service_info_query_result = mysqli_query($connection_string, $service_info_query);
    if (mysqli_num_rows($service_info_query_result) == 0) {
        return array('status' => "0", 'get_info' => $get_info);
    } else {
        $get_info = mysqli_fetch_object($service_info_query_result);
        return array('status' => "1", 'get_info' => $get_info);
    }
}
//service Order to 
function services_order_to_upper($old_service_order, $service_order, $connection_string)
{
    $get_service_list = "SELECT `id`,`service_order` from `services` where `service_order` between  '$service_order'and '$old_service_order' AND `service_order`  NOT IN('$old_service_order') ";
    $get_service_list_result = mysqli_query($connection_string, $get_service_list);
    if (mysqli_num_rows($get_service_list_result) > 0) {
        $service_data = mysqli_fetch_all($get_service_list_result, MYSQLI_ASSOC);

        foreach ($service_data as $service) {
            $service_id_new = $service['id'];
            $pre_order = $service['service_order'];
            $service_order    =   $pre_order + 1;
            $update_page_query = "update `services` set `service_order`='$service_order' where `id`='$service_id_new'";
            $update_result = mysqli_query($connection_string, $update_page_query);
        }
    }
}
//service order to lower
function services_order_to_lower($old_service_order, $service_order, $connection_string)
{
    $get_service_list_id =  "SELECT `id`,`service_order` from `services` where `service_order` between '$old_service_order' and '$service_order'  AND `service_order`  NOT IN('$old_service_order') ";
    $get_service_list_result = mysqli_query($connection_string, $get_service_list_id);
    if (mysqli_num_rows($get_service_list_result) > 0) {
        $service_data = mysqli_fetch_all($get_service_list_result, MYSQLI_ASSOC);
        foreach ($service_data as $service) {
            $service_id_new = $service['id'];
            $pre_order = $service['service_order'];
            $service_order    =   $pre_order - 1;
            $update_page_query = "update `services` set `service_order`='$service_order' where `id`='$service_id_new'";
            $update_result = mysqli_query($connection_string, $update_page_query);
        }
    }
}
function delete_service_order($connection_string, $del_order, $max_order)
{
    $get_service_list_id =  "SELECT `id`,`service_order` from `services` where `service_order` between '$del_order' and '$max_order'  AND `service_order`  NOT IN('$del_order') ";
    $get_service_list_result = mysqli_query($connection_string, $get_service_list_id);
    if (mysqli_num_rows($get_service_list_result) > 0) {
        $service_data = mysqli_fetch_all($get_service_list_result, MYSQLI_ASSOC);
        foreach ($service_data as $service) {
            $service_id_new = $service['id'];
            $pre_order = $service['service_order'];
            $service_order    =   $pre_order - 1;
            $update_page_query = "update `services` set `service_order`='$service_order' where `id`='$service_id_new'";
            $update_result = mysqli_query($connection_string, $update_page_query);
        }
    }
}
function max_id($connection_string)
{
    $max_id = 0;
    $maximum_order_query = "SELECT MAX(id) as max_id FROM `services` LIMIT 1";
    $maximum_order_query_result = mysqli_query($connection_string, $maximum_order_query);
    $max_id_result = mysqli_fetch_object($maximum_order_query_result);
    if ($max_id_result) {
        $max_id = $max_id_result->max_id;
        return  $max_id;
    } else {
        return $max_id;
    }
}
function multiple_services_delete_order($connection_string, $del_order)
{
    $max_id = max_id($connection_string);
    foreach ($del_order as $video_id) {
        $get_help_videos_list_id =  "SELECT `id`,`service_order` from `services` where `id` between '$video_id' and '$max_id'  AND `id`  NOT IN('$video_id') ";
        $get_help_videos_list_result = mysqli_query($connection_string, $get_help_videos_list_id);
        if (mysqli_num_rows($get_help_videos_list_result) > 0) {
            $help_videos_data = mysqli_fetch_all($get_help_videos_list_result, MYSQLI_ASSOC);
            foreach ($help_videos_data as $help_videos) {
                $help_videos_id_new = $help_videos['id'];
                $pre_order = $help_videos['service_order'];
                $help_videos_order    =   $pre_order - 1;
                $update_help_videos_query = "update `services` set `service_order`='$help_videos_order' where `id`='$help_videos_id_new'";
                $update_result = mysqli_query($connection_string, $update_help_videos_query);
            }
        }
    }
}
