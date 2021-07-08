<?php
// Get event info 
function get_events_info($connection_string)
{
    $get_info = array();
    $events_info_query = "SELECT `title`,`tagline`,`start_date_time`,`end_date_time`,`status`,`event_id` FROM `events`";
    $events_info_query_result = mysqli_query($connection_string, $events_info_query);
    if (mysqli_num_rows($events_info_query_result) == 0) {
        return array('status' => "0", 'get_info' => $get_info);
    } else {
        while ($events_result = mysqli_fetch_array($events_info_query_result)) {
            $get_info[] = $events_result;
        }
        return array('status' => "1", 'get_info' => $get_info);
    }
}

//function to get event info by id
function get_events_info_id($connection_string, $event_id)
{
    $get_info = array();
    $events_info_query = "SELECT * FROM `events` where `event_id`='$event_id'";
    $events_info_query_result = mysqli_query($connection_string, $events_info_query);
    if (mysqli_num_rows($events_info_query_result) == 0) {
        return array('status' => "0", 'get_info' => $get_info);
    } else {
        $get_info = mysqli_fetch_object($events_info_query_result);
        return array('status' => "1", 'get_info' => $get_info);
    }
}
/********get latest five records from events */
function get_event_latest_five_records($connection_string)
{
    $get_info = array();
    $event_latest_records = "SELECT * FROM `events` ORDER BY `event_id` ASC LIMIT 5 ";
    $event_latest_records_result = mysqli_query($connection_string, $event_latest_records);
    if (mysqli_num_rows($event_latest_records_result) == 0) {
        return array('status' => 0, 'get_info' => $get_info);
    } else {
        while ($events_result = mysqli_fetch_array($event_latest_records_result)) {
            $get_info[] = $events_result;
        }
        return array('status' => 1, 'get_info' => $get_info);
    }
}
