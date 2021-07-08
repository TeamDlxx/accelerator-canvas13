<?php
include '../../../include/config.php';
// $testimonial_order = 5;
// $old_testimonial_order = 2;
// $testimonial_id = 26;
// $get_testimonial_list        =  "SELECT `testimonial_id`,`testimonial_order` from `testimonial` where `testimonial_order` between '$old_testimonial_order' and '$testimonial_order'  AND `testimonial_order`  NOT IN('$old_testimonial_order') ";
// $get_testimonial_list_result = mysqli_query($connection_string, $get_testimonial_list);
// if (mysqli_num_rows($get_testimonial_list_result) > 0) {
//     $testimonial_data = mysqli_fetch_all($get_testimonial_list_result, MYSQLI_ASSOC);

//     foreach ($testimonial_data as $testimonial) {
//         $testimonial_id_new = $testimonial['testimonial_id'];
//         echo "old" . "  " . $porder = $testimonial['testimonial_order'];
//         $testimonial_order    =   $porder - 1;
//         $update_page_query = "update `testimonial` set `testimonial_order`='$testimonial_order' where `testimonial_id`='$testimonial_id_new'";
//         $update_result = mysqli_query($connection_string, $update_page_query);
//         if ($update_result) {
//             echo "New" . "$testimonial_order  ";
//         }
//     }
// }
//     for ($i = $testimonial_order; $i <= $old_testimonial_order; $i++) {

//         $testimonial_id_new = $testimonial_data['testimonial_id'];
//         if ($testimonial_id == $testimonial_id_new) {

//             return;
//         } else {
//             $testimonial_order_update    =   $i + 1;
//             $update_page_query = "update `testimonial` set `testimonial_order`='$testimonial_order_update' where `testimonial_id`='$testimonial_id_new'";
//             $update_result = mysqli_query($connection_string, $update_page_query);
//         }
//     }
// }
$select_number_ofrecord = "SELECT COUNT(testimonial_id) id FROM testimonial";
$result = mysqli_query($connection_string, $select_number_ofrecord);
$test = mysqli_fetch_object($result);
echo $test->id;
