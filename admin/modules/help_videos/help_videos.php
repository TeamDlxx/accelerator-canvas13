<?php
include '../../../include/config.php';
include '../../../include/functions.php';
include '../../includes/admin_auth.php';
$active_menu = "help_videos";
$page_title = "Help Videos";

// =====>Video list<=====
$post_data = array();
$get_video_api_url = "API/client/catgorized_help_videos.php?project_id=" . $project_id;
$content_type = "application/json";
$result_get_videos = ApiCalling('GET', $get_video_api_url, $post_data);
if ($result_get_videos['httpCode'] == 200) {
    $video_listing  = $result_get_videos['data']['videos'];
} else {
    $video_listing  = $result_get_videos['data']['videos'];
}



?>
<?php include '../../includes/header.php' ?>


<!--  END NAVBAR  -->

<!--  BEGIN NAVBAR  -->
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
                            <!-- <li class="breadcrumb-item"><a href="javascript:void(0);">Add</a></li> -->
                            <li class="breadcrumb-item active" aria-current="page"><span style="font-weight: 500;">Help Video</span></li>
                        </ol>
                    </nav>

                </div>
            </li>
        </ul>
        <?php include '../../includes/side_header.php'; ?>
    </header>
</div>
<!--  END NAVBAR  -->

<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container" id="container">

    <div class="overlay"></div>
    <div class="search-overlay"></div>

    <!--  BEGIN SIDEBAR  -->
    <?php include '../../includes/sidebar.php' ?>
    <!--  END SIDEBAR  -->

    <!--  BEGIN CONTENT PART  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <?php if ($result_get_videos['httpCode'] == 400) { ?>
                <p style="cursor: none;" class="mt-4"><?= $video_listing ?></p>
                <?php } else {
                foreach ($video_listing as $video_list) {
                    $catagory = $video_list['videos'];
                ?>
                    <div class="row layout-top-spacing">
                        <div class="col-xl-12 mb-3 mt-4 cat-title">
                            <h5><?= $video_list['title'] ?></h5>
                        </div>

                        <?php foreach ($catagory as $video_result) {
                            if ($video_result['status'] == 1) {
                        ?>
                                <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                                    <div class="card b-l-card-1 h-100" style="-webkit-box-shadow: 0 6px 10px 0 rgba(0,0,0,.14), 0 1px 18px 0 rgba(0,0,0,.12), 0 3px 5px -1px rgba(0,0,0,.2); -moz-box-shadow: 0 6px 10px 0 rgba(0,0,0,.14), 0 1px 18px 0 rgba(0,0,0,.12), 0 3px 5px -1px rgba(0,0,0,.2); box-shadow: 0 6px 10px 0 rgba(0,0,0,.14), 0 1px 18px 0 rgba(0,0,0,.12), 0 3px 5px -1px rgba(0,0,0,.2); ">
                                        <a href="video_detail.php?video_id=<?= $video_result['id'] ?>"> <img class="card-img-top" src="<?= $support_api_url . $video_result['video_image'] ?>" alt="Video Image">
                                            <div class="card-body">
                                                <!-- <strong class="card-category title"><?= $video_result['title'] ?></strong> -->
                                                <h5 class="card-title mt-2 video-title"><?php if (strlen($video_result['video_title']) > 100) {
                                                                                            echo  $str = substr($video_result['video_title'], 0, 100) . '...';
                                                                                        } else {
                                                                                            echo $video_result['video_title'];
                                                                                        };
                                                                                        ?></h5>
                                                <p class="card-text mb-4"> <?= $video_result['short_description'] ?></p>
                                            </div>
                                    </div>
                                    </a>
                                </div>

                        <?php
                            }
                        } ?>

                    </div>
            <?php }
            } ?>
        </div>
        <?php include '../../includes/footer.php' ?>