<?php
include '../../../include/config.php';
include '../../../include/functions.php';
// include '../../includes/admin_auth.php';
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
$ticket_details = true;

$active_menu = "help_videos";
$error = $success = "";
$page_title = "Video Detail";

// Call an Api for fetching the Video details
if (isset($_GET['video_id'])) {
    $video_id = $_GET['video_id'];
}
$post_data = array();
$get_video_api_url = "API/client/video_detail.php?project_id=" . $project_id . "&&video_id=" . $video_id;
$content_type = "application/json";
$result_get_videos = ApiCalling('GET', $get_video_api_url, $post_data);
if ($result_get_videos['httpCode'] == 200) {
    $video_listing  = $result_get_videos['data']['videos'];
}




?>
<!-- BEGIN NAVBAR -->
<?php include '../../includes/header.php'; ?>
<link href="../../assets/css/custom_style.css" rel="stylesheet" type="text/css" />

<!-- END NAVBAR -->

<!-- BEGIN NAVBAR -->
<div class="sub-header-container">
    <header class="header navbar navbar-expand-sm">
        <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg></a>

        <ul class="navbar-nav flex-row">
            <li>
                <div class="page-header">

                    <nav class="breadcrumb-one" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <!-- <li class="breadcrumb-item"><a href="javascript:void(0);">Apps</a></li> -->
                            <li class="breadcrumb-item active" aria-current="page"><span>Help Video Detail</span></li>
                        </ol>
                    </nav>

                </div>
            </li>
        </ul>
        <?php include '../../includes/side_header.php'; ?>
    </header>
</div>
<!-- END NAVBAR -->

<!-- BEGIN MAIN CONTAINER -->
<div class="main-container" id="container">

    <div class="overlay"></div>
    <div class="search-overlay"></div>

    <!-- BEGIN SIDEBAR -->
    <?php include '../../includes/sidebar.php'; ?>
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="col-xl-12 col-md-12">
                        <div>
                            <div id="scrollend" class="message-box">
                                <div class="" style="margin: auto;width: 100%;position: relative;" id="ct">
                                    <div class="d-flex mt-4">
                                        <a style="font-size: 15px;color: #bfc9d4;padding: 3px;align-self: center;cursor: pointer;margin-right: 12px;" href="help_videos.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left close-message">
                                                <line x1="19" y1="12" x2="5" y2="12"></line>
                                                <polyline points="12 19 5 12 12 5"></polyline>
                                            </svg></a>
                                        <h2 style="font-size: 24px;font-weight: 600;color: #25d5e4;margin-bottom: 0;align-self: center;"><?= $video_listing['video_title'] ?></h2>
                                        <!-- <a style="    position: relative;left: 835px;" href="#ticket-form"> <button type="submit" class="btn btn-primary reply ">Reply</button></a> -->
                                        <!-- <div class="col-12 text-right" style="padding: 10px;"> -->

                                        <!-- </div> -->
                                    </div>

                                    <div class="mail-content-container  mailInbox">
                                        <p style="padding-top: 15px; margin-bottom: 25px;border-top: 1px solid #191e3a;margin-top: 40px;font-size: 14px;color: #bfc9d4; word-wrap: break-word;" data-mailTitle="Promotion Pa">
                                            <?= stripslashes(htmlspecialchars_decode($video_listing['video_description'])) ?>
                                        </p>
                                    </div>
                                    <?php if (!empty($video_listing['video_image'])) { ?>
                                        <div class="gallery text-left mb-5">
                                            <!-- <img src="<?= $support_api_url . $video_listing['video_image'] ?>" alt=""> -->
                                            <!-- <a class="btn btn-primary" href="<?= $support_api_url . $video_listing['video_image'] ?>" target="_blank">View Attacment</a> -->
                                        </div>
                                    <?php } ?>


                                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                                        Play Video
                                    </button> -->

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <!-- <h5 class="modal-title" id="exampleModalLongTitle">Watch Video</h5> -->
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php echo stripslashes(htmlspecialchars_decode($video_listing['video_embed_code']));
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center" style=" margin:auto">
                                        <?php echo stripslashes(htmlspecialchars_decode($video_listing['video_embed_code'])); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="end"></div>
                    </div>
                </div>
            </div>
        </div>

        <?php include '../../includes/footer.php' ?>

        <script>
            $(document).ready(function() {

                // $('html,body').animate({
                //     scrollTop: $('#end').offset().top
                // }, 1000);

            })
        </script>