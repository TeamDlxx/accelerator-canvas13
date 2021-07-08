<?php
function get_testimonial_info($connection_string)
{
    $get_info = array();
    $testimonial_info_query = "SELECT * FROM `testimonial` order by `testimonial_order`";
    $testimonial_info_query_result = mysqli_query($connection_string, $testimonial_info_query);
    if (mysqli_num_rows($testimonial_info_query_result) == 0) {
        return array('status' => "0", 'get_info' => $get_info);
    } else {
        while ($testimonial_result = mysqli_fetch_array($testimonial_info_query_result)) {
            $get_info[] = $testimonial_result;
        }
        return array('status' => "1", 'get_info' => $get_info);
    }
}

function get_acive_testimonial_info($connection_string)
{
    $get_info = array();
    $testimonial_info_query = "SELECT * FROM `testimonial` where `status`= 1 order by `testimonial_order`";
    $testimonial_info_query_result = mysqli_query($connection_string, $testimonial_info_query);
    if (mysqli_num_rows($testimonial_info_query_result) == 0) {
        return array('status' => "0", 'get_info' => $get_info);
    } else {
        while ($testimonial_result = mysqli_fetch_array($testimonial_info_query_result)) {
            $get_info[] = $testimonial_result;
        }
        return array('status' => "1", 'get_info' => $get_info);
    }
}

function get_recent_testimonial_list($connection_string)
{
    $get_info = array();
    $testimonial_info_query = "SELECT * FROM `testimonial` order by `testimonial_id` DESC LIMIT 5";
    $testimonial_info_query_result = mysqli_query($connection_string, $testimonial_info_query);
    if (mysqli_num_rows($testimonial_info_query_result) == 0) {
        return array('status' => "0", 'get_info' => $get_info);
    } else {
        while ($testimonial_result = mysqli_fetch_array($testimonial_info_query_result)) {
            $get_info[] = $testimonial_result;
        }
        return array('status' => "1", 'get_info' => $get_info);
    }
}
/**************Get Testimonial data by id ********/
function get_testimonial_info_by_id($connection_string, $testimonial_id)
{
    $get_info = array();
    $testimonial_info_query = "SELECT * FROM `testimonial` WHERE `testimonial_id`=$testimonial_id";
    $testimonial_info_query_result = mysqli_query($connection_string, $testimonial_info_query);
    if (mysqli_num_rows($testimonial_info_query_result) == 0) {
        return array('status' => "0", 'get_info' => $get_info);
    } else {
        $get_info = mysqli_fetch_object($testimonial_info_query_result);
        return array('status' => "1", 'get_info' => $get_info);
    }
}
//Maximum Testimonia Order
function maximum_testimonial_order($connection_string)
{
    $max_order = 0;
    $maximum_order_query = "SELECT MAX(testimonial_order) as max_order FROM `testimonial` LIMIT 1";
    $maximum_order_query_result = mysqli_query($connection_string, $maximum_order_query);
    $max_order_result = mysqli_fetch_object($maximum_order_query_result);
    if ($max_order_result) {
        $max_order = $max_order_result->max_order;
        return  $max_order;
    } else {
        return $max_order;
    }
}

/*********new function *******/


//Testimonial Order to upper
function testimonial_order_to_upper($old_testimonial_order, $testimonial_order, $connection_string)
{
    $get_testimonial_list_id = "SELECT `testimonial_id`,`testimonial_order` from `testimonial` where `testimonial_order` between  '$testimonial_order'and '$old_testimonial_order' AND `testimonial_order`  NOT IN('$old_testimonial_order') ";
    $get_testimonial_list_result = mysqli_query($connection_string, $get_testimonial_list_id);
    if (mysqli_num_rows($get_testimonial_list_result) > 0) {
        $testimonial_data = mysqli_fetch_all($get_testimonial_list_result, MYSQLI_ASSOC);

        foreach ($testimonial_data as $testimonial) {
            $testimonial_id_new = $testimonial['testimonial_id'];
            $pre_order = $testimonial['testimonial_order'];
            $testimonial_order    =   $pre_order + 1;
            $update_testimonial_query = "update `testimonial` set `testimonial_order`='$testimonial_order' where `testimonial_id`='$testimonial_id_new'";
            $update_result = mysqli_query($connection_string, $update_testimonial_query);
        }
    }
}
//testimonial order to lower
function testimonial_order_to_lower($old_testimonial_order, $testimonial_order, $connection_string)
{
    $get_testimonial_list_id =  "SELECT `testimonial_id`,`testimonial_order` from `testimonial` where `testimonial_order` between '$old_testimonial_order' and '$testimonial_order'  AND `testimonial_order`  NOT IN('$old_testimonial_order') ";
    $get_testimonial_list_result = mysqli_query($connection_string, $get_testimonial_list_id);
    if (mysqli_num_rows($get_testimonial_list_result) > 0) {
        $testimonial_data = mysqli_fetch_all($get_testimonial_list_result, MYSQLI_ASSOC);
        foreach ($testimonial_data as $testimonial) {
            $testimonial_id_new = $testimonial['testimonial_id'];
            $pre_order = $testimonial['testimonial_order'];
            $testimonial_order    =   $pre_order - 1;
            $update_testimonial_query = "update `testimonial` set `testimonial_order`='$testimonial_order' where `testimonial_id`='$testimonial_id_new'";
            $update_result = mysqli_query($connection_string, $update_testimonial_query);
        }
    }
}
/**********Delete Order**********/
function delete_order($connection_string, $del_order, $max_order)
{
    $get_testimonial_list_id =  "SELECT `testimonial_id`,`testimonial_order` from `testimonial` where `testimonial_order` between '$del_order' and '$max_order'  AND `testimonial_order`  NOT IN('$del_order') ";
    $get_testimonial_list_result = mysqli_query($connection_string, $get_testimonial_list_id);
    if (mysqli_num_rows($get_testimonial_list_result) > 0) {
        $testimonial_data = mysqli_fetch_all($get_testimonial_list_result, MYSQLI_ASSOC);
        foreach ($testimonial_data as $testimonial) {
            $testimonial_id_new = $testimonial['testimonial_id'];
            $pre_order = $testimonial['testimonial_order'];
            $testimonial_order    =   $pre_order - 1;
            $update_testimonial_query = "update `testimonial` set `testimonial_order`='$testimonial_order' where `testimonial_id`='$testimonial_id_new'";
            $update_result = mysqli_query($connection_string, $update_testimonial_query);
        }
    }
}
