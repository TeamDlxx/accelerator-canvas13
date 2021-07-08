<?php
include '../../../include/config.php';
include '../../../include/functions.php';
// =====>meta tags <=====
$page_title = "Edit Faq ";;
$meta_description = "showcase";
/*********************if admin is not logged in it will be re directed to index page */
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
$error = $question = $success = $faq_order = $answer = '';
$faq_id = $_GET['faq_id'];
// ===>FAQ List<===
$faq_list = get_faq_info_by_id($connection_string, $faq_id);
$faq_listing_info = $faq_list['get_info'];
$question = stripslashes($faq_listing_info->question);
$status = $faq_listing_info->status;
$answer = stripslashes($faq_listing_info->answer);
$old_faq_order = $faq_listing_info->faq_order;
/*********Get Maximum Order */
$max_order = get_maximum_order($connection_string, "faqs", "faq_order");
// ===>Update FAQ<===
if (isset($_POST['submit'])) {
    $question = test_input($_POST['question']);
    $status = $_POST['status'];
    $answer = test_input($_POST['answer']);
    $faq_order = $_POST['faq_order'];
    if (($faq_order <= '0') || ($faq_order > $max_order)) {
        $error = "Faq order should be in 1 and " . $max_order;
    } elseif (empty($question)) {
        $error = 'Question is required. ';
    } else if (empty($answer)) {
        $error = 'Answer  is required. ';
    }
    /**********if there is no error then update the question */
    if (empty($error)) {
        if ($faq_order < $old_faq_order) {
            $update_order = faq_order_to_upper($old_faq_order, $faq_order, $connection_string);
        }
        //if new order is greater than older order
        else if ($faq_order > $old_faq_order) {
            $update_order = faq_order_to_lower($old_faq_order, $faq_order, $connection_string);
        }
        $add_user = "UPDATE `faqs` SET `question`='$question',`answer`='$answer',`status`='$status',`faq_order`='$faq_order' WHERE faq_id = $faq_id";
        $add_user_result = mysqli_query($connection_string, $add_user);
        if ($add_user == true) {
            $success = "Faq updated Successfully";
        } else {
            $error = $error_support;
        }
    }
}
?>
<!--  HEADER  -->
<?php include '../../includes/header.php'; ?>

<!-- END HEADER  -->

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
                            <li class="breadcrumb-item active" aria-current="page"><span>Edit FAQ</span></li>
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
    <?php include '../../includes/sidebar.php'; ?>
    <!--  END SIDEBAR  -->

    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <?php
        if ($error != "") {
        ?>
            <div class="alert text-center alert-danger alert-dismissible " role="alert" style="width:50%; margin-left:23%; margin-right:25%;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <?= $error; ?>
            </div>
        <?php } else if ($success != "") {
        ?>
            <div class="alert text-center alert-success alert-dismissible " role="alert" style="width:50%; margin-left:23%; margin-right:25%;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <?= $success; ?>
            </div>
        <?php } ?>
        <div class="layout-px-spacing">

            <div class="account-settings-container layout-top-spacing">

                <div class="account-content">
                    <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                <form id="contact" method="POST" class="section contact" enctype="multipart/form-data">
                                    <div class="info">
                                        <h5 class="">Edit FAQ</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="First Name">Question *</label>
                                                            <input type="text" class="form-control mb-4" id="First Name " placeholder="Question" value="<?php echo $question; ?>" name="question">

                                                        </div>
                                                        <div class="form-group">
                                                            <label for="First Name">Order</label>
                                                            <input type="text" class="form-control mb-4" id="First Name " placeholder="FAQ Order" value="<?php echo $old_faq_order; ?>" name="faq_order">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="email">Status</label>
                                                            <select class="form-control" id="Status" name="status">

                                                                <option value="1" <?php if ($status == 1) {
                                                                                        echo "selected";
                                                                                    } ?>>
                                                                    Active </option>
                                                                <option value="0" <?php if ($status == 0) {
                                                                                        echo "selected";
                                                                                    } ?>>Non Active</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-xs-12">
                                                        <div class="item form-group">
                                                            <label class="control-label col-md-1 col-sm-1 col-xs-12" for="number">Answer<span class="required">*</span>
                                                            </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                                <textarea name="answer" id="answer" name="answer" required class="form-control height_faq" placeholder="Answer"><?php echo $answer; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 text-right mb-5">
                                                        <button id="add-work-platforms" class="btn btn-primary" type="submit" name="submit">Save</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  END CONTENT AREA  -->
            </div>

            <!-- FOOTER BEGIN -->
            <?php include '../../includes/footer.php'; ?>
            <script>
                CKEDITOR.replace('answer', {
                    filebrowserUploadUrl: '../../upload.php',
                    filebrowserUploadMethod: "form"
                });
            </script>
            <!-- FOOTER END -->