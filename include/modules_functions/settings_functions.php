<?php

/*********Get Dashboard data */
function get_dashboard_data($connection_string)
{
    $get_data = array();
    $select_dashboard_query = "SELECT * From `dashboard` WHERE `id`=1";
    $select_dashboard_query_result = mysqli_query($connection_string, $select_dashboard_query);
    if (mysqli_num_rows($select_dashboard_query_result) == 0) {
        return array('status' => 0, 'get_info' => $get_data);
    } else {
        $get_data = mysqli_fetch_object($select_dashboard_query_result);
        return array('status' => 1, 'get_info' => $get_data);
    }
}
/*************Get WebSite Color Scheme Data */
function get_website_color_scheme($connection_string)
{
    $get_data = array();
    $select_color_scheme = "SELECT `title`,`id`,`color_scheme_status` FROM `color_scheme`";
    $select_color_scheme_result = mysqli_query($connection_string, $select_color_scheme);
    if (mysqli_num_rows($select_color_scheme_result) == 0) {
        return array('status' => 0, 'get_info' => $get_data);
    } else {
        while ($color_scheme = mysqli_fetch_array($select_color_scheme_result)) {
            $get_data[] = $color_scheme;
        }
        return array('status' => 1, 'get_info' => $get_data);
    }
}
/*********Get Website Color By Id**********/
function get_website_color_by_id($connection_string, $color_scheme_id)
{
    $get_data = array();
    $select_color_scheme = "SELECT * FROM `color_scheme` WHERE `id`=$color_scheme_id";
    $select_color_scheme_result = mysqli_query($connection_string, $select_color_scheme);
    if (mysqli_num_rows($select_color_scheme_result) == 0) {
        return array('status' => 0, 'get_info' => $get_data);
    } else {
        $get_data = mysqli_fetch_object($select_color_scheme_result);
        return array('status' => 1, 'get_info' => $get_data);
    }
}
/********Get Setting Info */
function get_setting_info($connection_string)
{
    $get_data = array();
    $select_setting_info = "SELECT * FROM `setting` WHERE `id`=1";
    $select_setting_info_result = mysqli_query($connection_string, $select_setting_info);
    if (mysqli_num_rows($select_setting_info_result) == 0) {
        return array('status' => 0, 'get_info' => $get_data);
    } else {
        $get_data  = mysqli_fetch_object($select_setting_info_result);
        return array('status' => 1, 'get_info' => $get_data);
    }
}
