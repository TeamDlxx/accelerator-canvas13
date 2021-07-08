<?php
include '../../../include/config.php';
// $query = '';
$query =  $_POST['query'];


if ($query != "") {
    $select_page_list = "SELECT * from `pages` where `page_name` LIKE '%{$query}%'";
    $select_page_list_result = mysqli_query($connection_string, $select_page_list);
    $outtput = array();
    if (mysqli_num_rows($select_page_list_result) > 0) {
        while ($row = mysqli_fetch_assoc($select_page_list_result)) {
            $outtput[] = $row;
        }
        echo json_encode($outtput);
    } else {
        echo json_encode('value not Found');
    }
}
