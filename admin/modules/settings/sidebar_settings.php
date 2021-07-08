<?php
include '../../../include/config.php';
include '../../../include/functions.php';
include '../../includes/admin_auth.php';
$active_menu = "setting";
/*********************if admin is not logged in it will be re directed to index page */
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
$page_title = "Sidebar Settings ";;
$meta_description = "showcase";
/*********initialize all fields */
$setting_id = $error = $success = $meta_title = $color_scheme =  $meta_description = $button_text = $button_url = $general_instruction_text = $brand_logo = $color_scheme = $survey_button_text = $survey_url = $survey_instruction_text = $question_button_text = $question_box_text = $question_instruction_text = $poll_button_text = $poll_instruction_text =  "";
$general_show = $survey_show = $question_show = $poll_show  = 1;
/**********Get Color Scheme */
$website_color_scheme = get_website_color_scheme($connection_string);
$website_color_scheme_result = $website_color_scheme['get_info'];
/**********Get  SideBar Setting Info ****/
$get_setting_data = get_setting_info($connection_string);
if ($get_setting_data['status'] === 1) {
    $setting_info = $get_setting_data['get_info'];
    $meta_title = $setting_info->meta_title;
    $meta_description = $setting_info->meta_description;
    $button_text = $setting_info->general_button_text;
    $button_url = $setting_info->general_button_url;
    $general_instruction_text = $setting_info->general_text;
    $general_show = $setting_info->general_section;
    $old_color_scheme = $setting_info->color_id;
    $survey_button_text = $setting_info->survey_button_text;
    $survey_url = $setting_info->survey_button_url;
    $survey_instruction_text = $setting_info->survey_text;
    $survey_show = $setting_info->survey_section;
    $question_button_text = $setting_info->question_button_text;
    $question_box_text = $setting_info->question_box_text;
    $question_instruction_text = $setting_info->question_text;
    $question_show = $setting_info->question_section;
    $poll_button_text = $setting_info->poll_button_text;
    $poll_instruction_text = $setting_info->poll_text;
    $poll_show = $setting_info->poll_section;
    $old_brand_logo = $setting_info->brand_logo;
    $setting_id = $setting_info->id;
}
/*********when user click the Update Setting button it validate and then update new Setting*/
if (isset($_POST['submit'])) {

    /**********call test input function to add slashes********/
    $meta_title = test_input($_POST['meta_title']);
    $meta_description = test_input($_POST['meta_description']);
    $button_text = test_input($_POST['button_text']);
    $button_url = test_input($_POST['button_url']);
    $general_instruction_text = test_input($_POST['general_instruction_text']);
    $color_scheme = test_input($_POST['color_scheme']);
    $survey_button_text = test_input($_POST['survey_button_text']);
    $survey_url = test_input($_POST['survey_url']);
    $survey_instruction_text = test_input($_POST['survey_instruction_text']);
    $survey_show = test_input($_POST['survey_show']);
    $question_button_text = test_input($_POST['question_button_text']);
    $question_box_text = test_input($_POST['question_box_text']);
    $question_instruction_text = test_input($_POST['question_instruction_text']);
    $question_show = test_input($_POST['question_show']);
    $poll_button_text = test_input($_POST['poll_button_text']);
    $poll_instruction_text = test_input($_POST['poll_instruction_text']);
    $poll_show = test_input($_POST['poll_show']);
    $brand_logo = $_FILES['brand_logo'];
    /***********validate if any required field is empty*******/
    if (empty($_FILES["brand_logo"]["name"])) {
        $brand_logo = $old_brand_logo;
    } else {
        //main image upload
        $main_image_replace              =  str_replace(" ", "_", $_FILES["brand_logo"]["name"]);
        $main_image_name                 =    "assets/img/logo/" . date('YmdHis_') . "--" . $main_image_replace;
        $main_image_upload_directory    = 'assets/img/logo/';
        $image_dir = '../../';
        if (!is_dir($image_dir . $main_image_upload_directory)) {
            mkdir($image_dir . $main_image_upload_directory, 0755, true);
        }
        move_uploaded_file($_FILES['brand_logo']['tmp_name'], $image_dir . $main_image_name);
        //for listing of images of program	
        $brand_logo = 'assets/img/logo' . date('YmdHis_') . "--" . $main_image_replace;
    }
    if (empty($meta_title)) {
        $error = 'Meta TItle is Required. ';
    } else if (empty($meta_description)) {
        $error = 'Meta Description Is required. ';
    } else if (empty($brand_logo)) {
        $error = 'brand Logo is required. ';
    } else if (empty($color_scheme)) {
        $error = 'Color Scheme is required. ';
    }
    /*********if there is no error in any field then insert data */
    if (empty($error)) {
        $update_setting = "update `setting` set `general_button_text`='$button_text',
            `general_button_url`='$button_url',`general_text`='$general_instruction_text',
            `general_section`='$general_show',`meta_title` = '$meta_title',
            `meta_description` = '$meta_description',`brand_logo` = '$brand_logo',
            `color_id` ='$color_scheme',`survey_button_text`='$survey_button_text',
            `survey_button_url`='$survey_url',`survey_text`='$survey_instruction_text',
            `survey_section`='$survey_show',`question_button_text`='$question_button_text',
            `question_text`='$question_instruction_text',`question_section`='$question_show',
            `poll_section`='$poll_show',`question_box_text`='$question_box_text',
            `poll_button_text`='$poll_button_text',`poll_text`='$poll_instruction_text' where `id`='$setting_id' ";
        $update_setting_result = mysqli_query($connection_string, $update_setting);
        if ($update_setting_result) {
            header('Location:sidebar_settings.php');
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
                            <li class="breadcrumb-item active" aria-current="page"><span>Sidebar Settings</span></li>
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
        <div class="layout-px-spacing">
            <div class="account-settings-container layout-top-spacing">
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
                <div class="account-content">
                    <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                <form id="contact" method="POST" class="section contact" enctype="multipart/form-data">
                                    <div class="info">
                                        <h5 class="">Sidebar Settings</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="button_text">Button Text </label>
                                                            <input type="text" class="form-control mb-4" id="button_text" placeholder="Button Text " value="<?php echo $button_text; ?>" name="button_text">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="button_url">Button Url </label>
                                                            <input type="text" class="form-control mb-4" id="button_url" placeholder="Button Url" value="<?php echo $button_url; ?>" name="button_url">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="general_show">Show</label>
                                                            <select class="form-control" id="general_show" name="general_show">
                                                                <option <?php echo ($general_show == 1) ? "selected" : ""; ?> value="1">Yes</option>
                                                                <option <?php echo ($general_show == 0) ? "selected" : ""; ?> value="0">No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="general_instruction_text">Instruction Text </label>
                                                            <textarea type="text" class="form-control mb-4" id="general_instruction_text" placeholder="Instruction Text" value="" name="general_instruction_text"><?php echo $general_instruction_text; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="info">
                                        <h5 class="">Generic Settings</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="meta_title">Meta Title *</label>
                                                            <input type="text" class="form-control mb-4" id="meta_title" placeholder="Meta Title " value="<?php echo $meta_title; ?>" name="meta_title" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="meta_description">Meta Description *</label>
                                                            <input type="text" class="form-control mb-4" id="meta_description" placeholder="Meta Description" value="<?php echo $meta_description; ?>" name="meta_description" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="brand_logo">Brand Logo *</label>
                                                            <input type="file" class="form-control mb-4" id="brand_logo" placeholder="Brand Logo" value="<?php echo $brand_logo; ?>" name="brand_logo" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="color_scheme">Color Scheme *</label>
                                                            <select class="form-control" id="color_scheme" name="color_scheme">
                                                                <?php foreach ($website_color_scheme_result as $color_scheme_info) { ?>
                                                                    <option <?php echo ($old_color_scheme == $color_scheme_info['id']) ? "selected" : "" ?> value="<?php echo $color_scheme_info['id']; ?>">
                                                                        <?php echo $color_scheme_info['title']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="info">
                                        <h5 class="">Survey Settings</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="survey_button_text">Survey Button Text </label>
                                                            <input type="text" class="form-control mb-4" id="survey_button_text" placeholder="Survey Button Text " value="<?php echo $survey_button_text; ?>" name="survey_button_text">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="survey_url">Survey Url </label>
                                                            <input type="text" class="form-control mb-4" id="survey_url" placeholder="Survey Url" value="<?php echo $survey_url; ?>" name="survey_url">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="survey_show">Show</label>
                                                            <select class="form-control" id="survey_show" name="survey_show">
                                                                <option <?php echo ($survey_show == 1) ? "selected" : ""; ?> value="1">Yes</option>
                                                                <option <?php echo ($survey_show == 0) ? "selected" : ""; ?> value="0">No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="survey_instruction_text">Instruction Text </label>
                                                            <textarea type="text" class="form-control mb-4" id="survey_instruction_text" placeholder="Instruction Text" value="" name="survey_instruction_text"><?php echo $survey_instruction_text; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="info">
                                        <h5 class="">Question Settings</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="question_button_text">Question Button </label>
                                                            <input type="text" class="form-control mb-4" id="question_button_text" placeholder="Question Button" value="<?php echo $question_button_text; ?>" name="question_button_text">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="question_box_text">Question Box Text</label>
                                                            <input type="text" class="form-control mb-4" id="question_box_text" placeholder="Question Box Text" value="<?php echo $question_box_text; ?>" name="question_box_text">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="question_show">Show</label>
                                                            <select class="form-control" id="question_show" name="question_show">
                                                                <option <?php echo ($question_show == 1) ? "selected" : ""; ?> value="1">Yes</option>
                                                                <option <?php echo ($question_show == 0) ? "selected" : ""; ?> value="0">No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="question_instruction_text">Instruction Text </label>
                                                            <textarea type="text" class="form-control mb-4" id="question_instruction_text" placeholder="Instruction Text" value="" name="question_instruction_text"><?php echo $question_instruction_text; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="info">
                                        <h5 class="">Poll Settings</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="poll_button_text">Poll Button Text</label>
                                                            <input type="text" class="form-control mb-4" id="poll_button_text" placeholder="Poll Button Text" value="<?php echo $poll_button_text; ?>" name="poll_button_text">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="poll_show">Show</label>
                                                            <select class="form-control" id="poll_show" name="poll_show">
                                                                <option <?php echo ($poll_show == 1) ? "selected" : ""; ?> value="1">Yes</option>
                                                                <option <?php echo ($poll_show == 0) ? "selected" : ""; ?> value="0">No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="poll_instruction_text">Instruction Text </label>
                                                            <textarea type="text" class="form-control mb-4" id="poll_instruction_text" placeholder="Instruction Text" value="" name="poll_instruction_text"><?php echo $poll_instruction_text; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 text-right mb-5">
                                                        <a href=""><button id="add-work-platforms" name="submit" class="btn btn-primary">Update Settings</button></a>
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
                CKEDITOR.replace('general_instruction_text', {
                    filebrowserUploadUrl: '../../upload.php',
                    filebrowserUploadMethod: "form"
                });
                CKEDITOR.replace('survey_instruction_text', {
                    filebrowserUploadUrl: '../../upload.php',
                    filebrowserUploadMethod: "form"
                });
                CKEDITOR.replace('question_instruction_text', {
                    filebrowserUploadUrl: '../../upload.php',
                    filebrowserUploadMethod: "form"
                });
                CKEDITOR.replace('poll_instruction_text', {
                    filebrowserUploadUrl: '../../upload.php',
                    filebrowserUploadMethod: "form"
                });
            </script>
            <!-- FOOTER END -->