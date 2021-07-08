<?php

/**********Function to get faq list */
function get_faq_list($connection_string)
{
    $get_data = array();
    $faq_list = "SELECT * FROM  faqs ORDER BY `faq_order`";
    $get_faq_list_info_result = mysqli_query($connection_string, $faq_list);
    if (mysqli_num_rows($get_faq_list_info_result) == 0) {
        return array('status' => 0, 'get_info' => $get_data);
    } else {
        while ($faq_list = mysqli_fetch_array($get_faq_list_info_result)) {
            $get_data[] = $faq_list;
        }

        return array('status' => 1, 'get_info' => $get_data);
    }
}
/**************Get Faq data by id ********/
function get_faq_info_by_id($connection_string, $faq_id)
{
    $get_info = array();
    $faq_info_query = "SELECT * FROM `faqs` WHERE faq_id= $faq_id";
    $faq_info_query_result = mysqli_query($connection_string, $faq_info_query);
    if (mysqli_num_rows($faq_info_query_result) == 0) {
        return array('status' => "0", 'get_info' => $get_info);
    } else {
        $get_info = mysqli_fetch_object($faq_info_query_result);
        return array('status' => "1", 'get_info' => $get_info);
    }
}
function get_faqs_list($connection_string, $table_name)
{
    $get_data = array();
    $get_user_list = "SELECT * FROM  $table_name";
    $get_user_list_info_result = mysqli_query($connection_string, $get_user_list);

    if (mysqli_num_rows($get_user_list_info_result) == 0) {
        return array('status' => 0, 'get_info' => $get_data);
    } else {
        $get_data = mysqli_fetch_all($get_user_list_info_result, MYSQLI_ASSOC);
        return array('status' => 1, 'get_info' => $get_data);
    }
}
/********Faq order to upper****/
function faq_order_to_upper($old_faq_order, $faq_order, $connection_string)
{
    $get_faq_list = "SELECT `faq_id`,`faq_order` from `faqs` where `faq_order` between  '$faq_order'and '$old_faq_order' AND `faq_order`  NOT IN('$old_faq_order') ";
    $get_faq_list_result = mysqli_query($connection_string, $get_faq_list);
    if (mysqli_num_rows($get_faq_list_result) > 0) {
        $faq_data = mysqli_fetch_all($get_faq_list_result, MYSQLI_ASSOC);

        foreach ($faq_data as $faq) {
            $faq_id_new = $faq['faq_id'];
            $pre_order = $faq['faq_order'];
            $faq_order    =   $pre_order + 1;
            $update_page_query = "update `faqs` set `faq_order`='$faq_order' where `faq_id`='$faq_id_new'";
            $update_result = mysqli_query($connection_string, $update_page_query);
        }
    }
}
/*******Faq Oreder to lower*******/
function faq_order_to_lower($old_faq_order, $faq_order, $connection_string)
{
    $get_faq_list = "SELECT `faq_id`,`faq_order` from `faqs` where `faq_order` between  '$old_faq_order'and '$faq_order' AND `faq_order`  NOT IN('$old_faq_order') ";
    $get_faq_list_result = mysqli_query($connection_string, $get_faq_list);
    if (mysqli_num_rows($get_faq_list_result) > 0) {
        $faq_data = mysqli_fetch_all($get_faq_list_result, MYSQLI_ASSOC);

        foreach ($faq_data as $faq) {
            $faq_id_new = $faq['faq_id'];
            $pre_order = $faq['faq_order'];
            $faq_order    =   $pre_order - 1;
            $update_page_query = "update `faqs` set `faq_order`='$faq_order' where `faq_id`='$faq_id_new'";
            $update_result = mysqli_query($connection_string, $update_page_query);
        }
    }
}
function delete_faq_order($connection_string, $del_order, $max_order)
{
    $get_faq_list = "SELECT `faq_id`,`faq_order` from `faqs` where `faq_order` between  '$del_order'and '$max_order' AND `faq_order`  NOT IN('$del_order') ";
    $get_faq_list_result = mysqli_query($connection_string, $get_faq_list);
    if (mysqli_num_rows($get_faq_list_result) > 0) {
        $faq_data = mysqli_fetch_all($get_faq_list_result, MYSQLI_ASSOC);

        foreach ($faq_data as $faq) {
            $faq_id_new = $faq['faq_id'];
            $pre_order = $faq['faq_order'];
            $faq_order    =   $pre_order - 1;
            $update_page_query = "update `faqs` set `faq_order`='$faq_order' where `faq_id`='$faq_id_new'";
            $update_result = mysqli_query($connection_string, $update_page_query);
        }
    }
}
