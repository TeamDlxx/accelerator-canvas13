<?php
//Get page info 
function get_page_info($connection_string)
{
    $get_info = array();
    $pages_info_query = "SELECT * FROM `pages` ORDER BY `page_order`";
    $pages_info_query_result = mysqli_query($connection_string, $pages_info_query);
    if (mysqli_num_rows($pages_info_query_result) == 0) {
        return array('status' => "0", 'get_info' => $get_info);
    } else {
        while ($pages_result = mysqli_fetch_array($pages_info_query_result)) {
            $get_info[] = $pages_result;
        }
        return array('status' => "1", 'get_info' => $get_info);
    }
}
/**************Get page data by id ********/
function get_pages_info_by_id($connection_string, $page_id)
{
    $get_info = array();
    $page_info_query = "SELECT * FROM `pages` WHERE `id`=$page_id";
    $page_info_query_result = mysqli_query($connection_string, $page_info_query);
    if (mysqli_num_rows($page_info_query_result) == 0) {
        return array('status' => "0", 'get_info' => $get_info);
    } else {
        $get_info = mysqli_fetch_object($page_info_query_result);
        return array('status' => "1", 'get_info' => $get_info);
    }
}
//page Order to upper
function page_order_to_upper($old_page_order, $page_order, $connection_string)
{
    $get_page_list = "SELECT `id`,`page_order` from `pages` where `page_order` between  '$page_order'and '$old_page_order' AND `page_order`  NOT IN('$old_page_order') ";
    $get_page_list_result = mysqli_query($connection_string, $get_page_list);
    if (mysqli_num_rows($get_page_list_result) > 0) {
        $page_data = mysqli_fetch_all($get_page_list_result, MYSQLI_ASSOC);

        foreach ($page_data as $page) {
            $page_id_new = $page['id'];
            $pre_order = $page['page_order'];
            $page_order    =   $pre_order + 1;
            $update_page_query = "update `pages` set `page_order`='$page_order' where `id`='$page_id_new'";
            $update_result = mysqli_query($connection_string, $update_page_query);
        }
    }
}
//page order to lower
function page_order_to_lower($old_page_order, $page_order, $connection_string)
{
    $get_page_list_id =  "SELECT `id`,`page_order` from `pages` where `page_order` between '$old_page_order' and '$page_order'  AND `page_order`  NOT IN('$old_page_order') ";
    $get_page_list_result = mysqli_query($connection_string, $get_page_list_id);
    if (mysqli_num_rows($get_page_list_result) > 0) {
        $page_data = mysqli_fetch_all($get_page_list_result, MYSQLI_ASSOC);
        foreach ($page_data as $page) {
            $page_id_new = $page['id'];
            $pre_order = $page['page_order'];
            $page_order    =   $pre_order - 1;
            $update_page_query = "update `pages` set `page_order`='$page_order' where `id`='$page_id_new'";
            $update_result = mysqli_query($connection_string, $update_page_query);
        }
    }
}
function delete_page_order($connection_string, $del_order, $max_order)
{
    $get_page_list_id =  "SELECT `id`,`page_order` from `pages` where `page_order` between '$del_order' and '$max_order'  AND `page_order`  NOT IN('$del_order') ";
    $get_page_list_result = mysqli_query($connection_string, $get_page_list_id);
    if (mysqli_num_rows($get_page_list_result) > 0) {
        $page_data = mysqli_fetch_all($get_page_list_result, MYSQLI_ASSOC);
        foreach ($page_data as $page) {
            $page_id_new = $page['id'];
            $pre_order = $page['page_order'];
            $page_order    =   $pre_order - 1;
            $update_page_query = "update `pages` set `page_order`='$page_order' where `id`='$page_id_new'";
            $update_result = mysqli_query($connection_string, $update_page_query);
        }
    }
}
