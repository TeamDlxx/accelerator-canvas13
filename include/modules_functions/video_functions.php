<?php

/*************inner join function*/

function get_video_details($connection_string)
{
    $get_data = array();
    $event_video_data = "SELECT v.id,v.thumbnail, v.video_title,v.video_order,v.video_status,e.title FROM event_videos v INNER JOIN events e ON v.event_id = e.event_id ORDER BY `video_order`";
    $event_video_data_result = mysqli_query($connection_string, $event_video_data);
    if (mysqli_num_rows($event_video_data_result) == 0) {
        return array('status' => 0, 'get_info' => $get_data);
    } else {
        while ($videos_data = mysqli_fetch_array($event_video_data_result)) {
            $get_data[] = $videos_data;
        }
        return array('status' => 1, 'get_info' => $get_data);
    }
}
/********** get event video by id */
function get_event_video_by_id($connection_string, $event_video_id)
{
    $get_data = array();
    $select_event_video_query = "SELECT v.thumbnail,v.event_id, v.video_title,v.video_image,v.video_order,v.video_status,e.title,v.free_video,v.video_description,v.video_embed_code, v.video_short_description FROM event_videos v INNER JOIN events e ON v.event_id = e.event_id WHERE v.id=$event_video_id ";
    $event_video_data_result = mysqli_query($connection_string, $select_event_video_query);
    if (mysqli_num_rows($event_video_data_result) == 0) {
        return array('status' => 0, 'get_info' => $get_data);
    } else {
        $get_data = mysqli_fetch_object($event_video_data_result);
        return array('status' => 1, 'get_info' => $get_data);
    }
}

//Testimonial Order to upper
function video_order_to_upper($old_video_order, $video_order, $connection_string)
{
    $get_video_list = "SELECT `id`,`video_order` from `event_videos` where `video_order` between  '$video_order'and '$old_video_order' AND `video_order`  NOT IN('$old_video_order') ";
    $get_video_list_result = mysqli_query($connection_string, $get_video_list);
    if (mysqli_num_rows($get_video_list_result) > 0) {
        $video_data = mysqli_fetch_all($get_video_list_result, MYSQLI_ASSOC);

        foreach ($video_data as $video) {
            $video_id_new = $video['id'];
            $pre_order = $video['video_order'];
            $video_order    =   $pre_order + 1;
            $update_page_query = "update `event_videos` set `video_order`='$video_order' where `id`='$video_id_new'";
            $update_result = mysqli_query($connection_string, $update_page_query);
        }
    }
}
//testimonial order to lower
function video_order_to_lower($old_video_order, $video_order, $connection_string)
{
    $get_video_list = "SELECT `id`,`video_order` from `event_videos` where `video_order` between  '$old_video_order'and '$video_order' AND `video_order`  NOT IN('$old_video_order') ";
    $get_video_list_result = mysqli_query($connection_string, $get_video_list);
    if (mysqli_num_rows($get_video_list_result) > 0) {
        $video_data = mysqli_fetch_all($get_video_list_result, MYSQLI_ASSOC);

        foreach ($video_data as $video) {
            $video_id_new = $video['id'];
            $pre_order = $video['video_order'];
            $video_order    =   $pre_order - 1;
            $update_page_query = "update `event_videos` set `video_order`='$video_order' where `id`='$video_id_new'";
            $update_result = mysqli_query($connection_string, $update_page_query);
        }
    }
}
function delete_video_order($connection_string, $del_order, $max_order)
{
    $get_video_list = "SELECT `id`,`video_order` from `event_videos` where `video_order` between  '$del_order'and '$max_order' AND `video_order`  NOT IN('$del_order') ";
    $get_video_list_result = mysqli_query($connection_string, $get_video_list);
    if (mysqli_num_rows($get_video_list_result) > 0) {
        $video_data = mysqli_fetch_all($get_video_list_result, MYSQLI_ASSOC);

        foreach ($video_data as $video) {
            $video_id_new = $video['id'];
            $pre_order = $video['video_order'];
            $video_order    =   $pre_order - 1;
            $update_page_query = "update `event_videos` set `video_order`='$video_order' where `id`='$video_id_new'";
            $update_result = mysqli_query($connection_string, $update_page_query);
        }
    }
}


// function get_video_details($connection_string)
// {
//     $get_data = array();
//     $get_video_data = "SELECT * FROM `event_videos`";
//     $get_video_data_result = mysqli_query($connection_string, $get_video_data);
//     if (mysqli_num_rows($get_video_data_result) == 0) {
//         return array('status' => 0, 'get_info' => $get_data);
//     } else {
//         while ($event_video_details = mysqli_fetch_array($get_video_data_result)) {
//             $get_data[] = $event_video_details;
//         }
//         return array('status' => 1, 'get_info' => $get_data);
//     }
// }
/*******event title according to the event id from event_video */
// function get_events_info($connection_string)
// {
//     $get_data = array();
//     $event_query = "SELECT `title`,`event_id` from `events`";
//     $event_query_result = mysqli_query($connection_string, $event_query);
//     if (mysqli_num_rows($event_query_result) == 0) {
//         return array('status' => 0, 'get_info' => $get_data);
//     } else {
//         while ($event_result = mysqli_fetch_array($event_query_result)) {
//             $get_data[] = $event_result;
//         }
//         return array('status' => 1, 'get_info' => $get_data);
//     }
// }
