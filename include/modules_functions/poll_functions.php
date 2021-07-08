<?php
//Get question info 
function get_poll_info($connection_string)
{
    $get_info = array();
    $poll_info_query = "SELECT * FROM `pool_question`";
    $poll_info_query_result = mysqli_query($connection_string, $poll_info_query);
    if (mysqli_num_rows($poll_info_query_result) == 0) {
        return array('status' => "0", 'get_info' => $get_info);
    } else {
        while ($poll_result = mysqli_fetch_array($poll_info_query_result)) {
            $get_info[] = $poll_result;
        }
        return array('status' => "1", 'get_info' => $get_info);
    }
}
//get poll question info by id//
function get_poll_question_info_by_id($connection_string, $poll_id)
{
    $get_info = array();
    $poll_info_query = "SELECT * FROM `pool_question` WHERE `pool_id`=$poll_id";
    $poll_info_query_result = mysqli_query($connection_string, $poll_info_query);
    if (mysqli_num_rows($poll_info_query_result) == 0) {
        return array('status' => "0", 'get_info' => $get_info);
    } else {
        $get_info = mysqli_fetch_object($poll_info_query_result);
        return array('status' => "1", 'get_info' => $get_info);
    }
}

function poll_answer_by_id($connection_string, $poll_id)
{
    $get_info = array();
    $poll_answer_info_query = "SELECT * FROM `poll_answer` where `pool_id`='$poll_id'";
    $poll_answer_info_query_result = mysqli_query($connection_string, $poll_answer_info_query);
    if (mysqli_num_rows($poll_answer_info_query_result) == 0) {
        return array('status' => "0", 'get_info' => $get_info);
    } else {
        while ($poll_result = mysqli_fetch_array($poll_answer_info_query_result)) {
            $get_info[] = $poll_result;
        }
        return array('status' => "1", 'get_info' => $get_info);
    }
}

function get_event_videos_by_id($connection_string, $event_id)
{
    $get_info = array();
    $events_info_query = "SELECT * FROM `event_videos` where `event_id`= $event_id";
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
function get_event_videos($connection_string)
{
    $get_info = array();
    $events_info_query = "SELECT * FROM `event_videos`";
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
function get_event_info($connection_string)
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
function get_poll_count($connection_string, $poll_id)
{
    $count = 0;
    $select_query = "SELECT * FROM `poll_answer` where `pool_id` = '$poll_id' ORDER BY pool_id DESC";
    $select_query_result = mysqli_query($connection_string, $select_query);
    if (mysqli_num_rows($select_query_result) == 0) {
        return $count;
    } else {
        $count = mysqli_num_rows($select_query_result);
        return $count;
    }
}
