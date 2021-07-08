<?php
include '../../../include/config.php';
include '../../../include/functions.php';

if (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
    $get_event_videos = get_event_videos_by_id($connection_string, $event_id);
    $get_event_videos_result = $get_event_videos['get_info'];
    echo json_encode($get_event_videos_result);
}