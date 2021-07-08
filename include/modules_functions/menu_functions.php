<?php

function get_menu_list($connection_string)
{
    $get_date = array();
    $select_list_query = "SELECT * FROM `menu_list`";
    $select_list_query_result = mysqli_query($connection_string, $select_list_query);
    if (mysqli_num_rows($select_list_query_result) == 0) {
        return array('status' => 0, 'get_info' => $get_date);
    } else {
        while ($result = mysqli_fetch_assoc($select_list_query_result)) {
            $get_date[] = $result;
        }
        return array('status' => 1, 'get_info' => $get_date);
    }
}
function get_menu_items_count($connection_string, $menu_id)
{
    $count = 0;
    $select_query = "SELECT * FROM `menu_items` where `menu_id` = '$menu_id' ORDER BY `menu_id` DESC";
    $select_query_result = mysqli_query($connection_string, $select_query);
    if (mysqli_num_rows($select_query_result) == 0) {
        return $count;
    } else {
        $count = mysqli_num_rows($select_query_result);
        return $count;
    }
}
function get_menu_items_by_id($connection_string, $menu_id)
{
    $get_info = array();
    $menu_items_info_query = "SELECT * FROM `menu_items` where `menu_id`='$menu_id'";
    $menu_items_info_query_result = mysqli_query($connection_string, $menu_items_info_query);
    if (mysqli_num_rows($menu_items_info_query_result) == 0) {
        return array('status' => "0", 'get_info' => $get_info);
    } else {
        while ($items_result = mysqli_fetch_array($menu_items_info_query_result)) {
            $get_info[] = $items_result;
        }
        return array('status' => "1", 'get_info' => $get_info);
    }
}

function get_page_name_by_id($connection_string, $page_id)
{
    $get_info = array();
    $page_info_query = "SELECT `page_name` FROM `pages` WHERE `id`=$page_id";
    $page_info_query_result = mysqli_query($connection_string, $page_info_query);
    if (mysqli_num_rows($page_info_query_result) == 0) {
        return array('status' => "0", 'get_info' => $get_info);
    } else {
        $get_info = mysqli_fetch_object($page_info_query_result);
        return array('status' => "1", 'get_info' => $get_info);
    }
}
function get_menu_by_id($connection_string, $menu_id)
{
    $get_info = array();
    $menu_info_query = "SELECT menu_list.menu_title,menu_items.item_id, menu_list.menu_status,menu_list.menu_status, menu_items.page_id ,menu_items.item_name, menu_items.item_link FROM menu_list INNER JOIN menu_items ON menu_list.menu_id=menu_items.menu_id WHERE menu_list.menu_id ='$menu_id'";
    $menu_info_query_result = mysqli_query($connection_string, $menu_info_query);
    if (mysqli_num_rows($menu_info_query_result) == 0) {
        return array('status' => "0", 'get_info' => $get_info);
    } else {
        $get_info = mysqli_fetch_object($menu_info_query_result);
        return array('status' => "1", 'get_info' => $get_info);
    }
}
function get_item_and_link($connection_string, $menu_id)
{
    $get_info = array();
    $menu_info_query = "SELECT  `item_name`,`item_link`,`page_id`,`is_url` FROM `menu_items` where menu_id ='$menu_id'";
    $menu_info_query_result = mysqli_query($connection_string, $menu_info_query);
    if (mysqli_num_rows($menu_info_query_result) == 0) {
        return array('status' => "0", 'get_info' => $get_info);
    } else {
        $get_info = mysqli_fetch_all($menu_info_query_result, MYSQLI_ASSOC);
        return array('status' => "1", 'get_info' => $get_info);
    }
}
function get_page_id($connection_string, $menu_id)
{
    $get_info = array();
    $menu_info_query = "SELECT `page_id` FROM `menu_items` WHERE `menu_id` ='$menu_id'";
    $menu_info_query_result = mysqli_query($connection_string, $menu_info_query);
    if (mysqli_num_rows($menu_info_query_result) == 0) {
        return array('status' => "0", 'get_info' => $get_info);
    } else {
        $get_info = mysqli_fetch_all($menu_info_query_result, MYSQLI_ASSOC);
        return array('status' => "1", 'get_info' => $get_info);
    }
}

function get_last_menu_id($connection_string)
{
    $get_info = array();
    $menu_info_query = "SELECT `menu_id` FROM `menu_list` ORDER BY `menu_id` DESC ";
    $menu_info_query_result = mysqli_query($connection_string, $menu_info_query);
    if (mysqli_num_rows($menu_info_query_result) == 0) {
        return array('status' => "0", 'get_info' => $get_info);
    } else {
        $get_info = mysqli_fetch_assoc($menu_info_query_result);
        return array('status' => "1", 'get_info' => $get_info);
    }
}
