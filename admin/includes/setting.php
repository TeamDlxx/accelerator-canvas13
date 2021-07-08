<?php
$api_url            = $support_api_url . "API/setting.php?project_id=" . $project_id;
$result             = invokeApi('GET', $api_url, $data = '');
$result_decoded     = json_decode($result);
$notification_count =   $result_decoded->count;

?>