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
