<?php
include '../../../include/config.php';
include '../../../include/functions.php';
include '../../includes/admin_auth.php';
$active_menu = "general_settings";
/*********************if admin is not logged in it will be re directed to index page */
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
$page_title = "General Settings ";

/*********initialize all fields */
$setting_id = $brand_title = $meta_keyword = $error = $success = $meta_title = $fav_icon = $color_scheme =  $meta_description = $facebook_pixel_code_header = $facebook_pixel_code_body = $google_analytics_header = $google_analytics_body = $welcome_text =  $color_scheme = $brand_logo = $admin_logo = $event_id = $active_compaign_token = $active_compaign_url = $list_id = $email_subject = $email_sender = $thank_you_email_body = $thank_you_email_message = $contact_email_message = $publishable_key = $secret_key =  "";
/**********Get Color Scheme */
$website_color_scheme = get_website_color_scheme($connection_string);
$website_color_scheme_result = $website_color_scheme['get_info'];
/**********Get  SideBar Setting Info ****/
$get_setting_data = get_setting_info($connection_string);
if ($get_setting_data['status'] === 1) {
    $setting_info = $get_setting_data['get_info'];
    $meta_title = $setting_info->meta_title;
    $meta_description = $setting_info->meta_description;
    // $facebook_pixel_code_header = $setting_info->facebook_pixal_code;
    // $facebook_pixel_code_body = $setting_info->facebook_pixal_code_body;
    // $google_analytics_header = $setting_info->google_analytics;
    // $google_analytics_body = $setting_info->google_analytics_body;
    // $old_color_scheme = $setting_info->color_id;
    // $welcome_video_embed_code = $setting_info->welcome_video_embed_code;
    // $welcome_text = $setting_info->welcome_text;
    // $active_compaign_token = $setting_info->active_compaign_token;
    // $active_compaign_url = $setting_info->active_compaign_url;
    // $list_id = $setting_info->active_compaign_list_id;
    $email_subject = $setting_info->email_subject;
    // $email_sender = $setting_info->email_sender;
    // $thank_you_email_message = $setting_info->thank_you_message;
    $contact_email_message = $setting_info->contact_email_message;
    // $thank_you_email_body = $setting_info->email_body;
    // $poll_instruction_text = $setting_info->poll_text;
    // $publishable_key = $setting_info->publishable_key;
    // $secret_key = $setting_info->secret_key;
    $old_brand_logo = $setting_info->brand_logo;
    $old_admin_logo = $setting_info->admin_logo;
    $setting_id = $setting_info->id;
    // $event_id = $setting_info->event_id;
    $admin_email = $setting_info->admin_email;
    // $admin_phone = $setting_info->admin_phone;
    // $admin_fex = $setting_info->admin_fex;
    $button1_title = $setting_info->button1_text;
    $button1_link = $setting_info->button1_link;
    // $button2_title = $setting_info->button2_text;
    // $button2_link = $setting_info->button2_link;
    // $button3_title = $setting_info->button3_text;
    // $button3_link = $setting_info->button3_link;
    // $button4_title = $setting_info->button4_text;
    // $button4_link = $setting_info->button4_link;
    $meta_keyword = $setting_info->meta_keyword;
    $brand_title = $setting_info->brand_title;
    $show_logo = $setting_info->show_logo;

    $business_title = $setting_info->business_title;
}
/*********when user click the Update Setting button it validate and then update new Setting*/
if (isset($_POST['submit'])) {

    /**********call test input function to add slashes********/
    $meta_title = test_input($_POST['meta_title']);
    $meta_description = test_input($_POST['meta_description']);
    // $facebook_pixel_code_header = test_input($_POST['facebook_pixel_code_header']);
    // $facebook_pixel_code_body = test_input($_POST['facebook_pixel_code_body']);
    // $google_analytics_header = test_input($_POST['google_analytics_header']);
    // $google_analytics_body = test_input($_POST['google_analytics_body']);
    // $color_scheme = test_input($_POST['color_scheme']);
    // $event_id = test_input($_POST['event_id']);
    // $welcome_video_embed_code = test_input($_POST['welcome_video_embed_code']);
    // $welcome_text = test_input($_POST['welcome_text']);
    // $active_compaign_token = test_input($_POST['active_compaign_token']);
    // $active_compaign_url = test_input($_POST['active_compaign_url']);
    // $list_id = test_input($_POST['list_id']);
    $email_subject = test_input($_POST['email_subject']);
    // $email_sender = test_input($_POST['email_sender']);
    // $thank_you_email_body = test_input($_POST['thank_you_email_body']);
    // $thank_you_email_message = test_input($_POST['thank_you_email_message']);
    $contact_email_message = test_input($_POST['contact_email_message']);
    // $publishable_key = test_input($_POST['publishable_key']);
    // $secret_key = test_input($_POST['secret_key']);
    $admin_email = test_input($_POST['admin_email']);
    // $admin_phone = test_input($_POST['admin_phone']);
    // $admin_fex = test_input($_POST['admin_fex']);
    $button1_title = test_input($_POST['button1_title']);
    $button1_link = test_input($_POST['button1_link']);
    // $button2_title = test_input($_POST['button2_title']);
    // $button2_link = test_input($_POST['button2_link']);
    // $button3_title = test_input($_POST['button3_title']);
    // $button3_link = test_input($_POST['button3_link']);
    // $button4_title = test_input($_POST['button4_title']);
    // $button4_link = test_input($_POST['button4_link']);
    $meta_keyword = test_input($_POST['meta_keyword']);
    $brand_title = test_input($_POST['brand_title']);
    $show_logo = test_input($_POST['show_logo']);


    $business_title = test_input($_POST['business_title']);
    $old_fav_icon = $setting_info->fav_icon;


    // $brand_logo = $_FILES['brand_logo'];
    /***********validate if any required field is empty*******/
    if (empty($_FILES["brand_logo"]["name"])) {
        $brand_logo = $old_brand_logo;
    } else {
        //main image upload
        $main_image_replace              =  str_replace(" ", "_", $_FILES["brand_logo"]["name"]);
        $brand_logo                 =    "uploads/logo/" . date('YmdHis_') . "--" . $main_image_replace;
        $main_image_upload_directory    = 'uploads/logo/';
        $image_dir = '../../../';
        if (!is_dir($image_dir . $main_image_upload_directory)) {
            mkdir($image_dir . $main_image_upload_directory, 0755, true);
        }
        if (move_uploaded_file($_FILES['brand_logo']['tmp_name'], $image_dir . $brand_logo)) {
            unlink($image_dir . $old_brand_logo);
        }
        //for listing of images of program	
    }

    if (empty($_FILES["admin_logo"]["name"])) {
        $admin_logo = $old_admin_logo;
    } else {
        //main image upload
        $main_image_replace              =  str_replace(" ", "_", $_FILES["admin_logo"]["name"]);
        $admin_logo                 =    "uploads/logo/" . date('YmdHis_') . "--" . $main_image_replace;
        $main_image_upload_directory    = 'uploads/logo/';
        $image_dir = '../../../';
        if (!is_dir($image_dir . $main_image_upload_directory)) {
            mkdir($image_dir . $main_image_upload_directory, 0755, true);
        }
        if (move_uploaded_file($_FILES['admin_logo']['tmp_name'], $image_dir . $admin_logo)) {
            unlink($image_dir . $old_admin_logo);
        }
        //for listing of images of program	
    }


    if (empty($_FILES["fav_icon"]["name"])) {
        $fav_icon = $old_fav_icon;
    } else {
        //main image upload
        $main_image_replace              =  str_replace(" ", "_", $_FILES["fav_icon"]["name"]);
        $fav_icon                =    "uploads/logo/" . date('YmdHis_') . "--" . $main_image_replace;
        $main_image_upload_directory    = 'uploads/logo/';
        $image_dir = '../../../';
        if (!is_dir($image_dir . $main_image_upload_directory)) {
            mkdir($image_dir . $main_image_upload_directory, 0755, true);
        }
        if (move_uploaded_file($_FILES['fav_icon']['tmp_name'], $image_dir . $fav_icon)) {
            unlink($image_dir . $old_fav_icon);
        }
        //for listing of images of program	
    }








    if (empty($meta_title)) {
        $error = 'Meta Title is Required. ';
    } else if (empty($meta_description)) {
        $error = 'Meta Description Is required. ';
    }
    // else if (empty($color_scheme)) {
    //     $error = 'Color Scheme is required. ';
    // }

    /*********if there is no error in any field then insert data */
    if (empty($error)) {
        $update_setting = "UPDATE `setting` set `meta_title` = '$meta_title',
        `meta_description` = '$meta_description',`brand_logo` = '$brand_logo',`admin_logo` = '$admin_logo' , `fav_icon`='$fav_icon'
        ,`email_subject`='$email_subject',`thank_you_message`='$thank_you_email_message',`contact_email_message`='$contact_email_message',`email_body`='$thank_you_email_body',`email_sender`='$email_sender',`event_id`='$event_id',`publishable_key`='$publishable_key',`secret_key`='$secret_key',`admin_email`='$admin_email',`admin_phone`='$admin_phone',`admin_fex`='$admin_fex',`button1_text`='$button1_title',`button1_link`='$button1_link', `meta_keyword`='$meta_keyword',`brand_title`='$brand_title' ,`show_logo`='$show_logo', `business_title`='$business_title'  where `id`='$setting_id'  ";

        $update_setting_result = mysqli_query($connection_string, $update_setting);
        if ($update_setting_result) {
            // $success = "Settings Updated Successfully";
            header('Location:general_settings.php');
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
        <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg
                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-menu">
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
                            <li class="breadcrumb-item active" aria-current="page"><span>General Settings</span></li>
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
                <div class="alert text-center alert-danger alert-dismissible " role="alert"
                    style="width:50%; margin-left:23%; margin-right:25%;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <?= $error; ?>
                </div>
                <?php } else if ($success != "") {
                ?>
                <div class="alert text-center alert-success alert-dismissible " role="alert"
                    style="width:50%; margin-left:23%; margin-right:25%;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <?= $success; ?>
                </div>
                <?php } ?>
                <div class="account-content">
                    <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll"
                        data-offset="-100">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                <form id="contact" method="POST" class="section contact" enctype="multipart/form-data">

                                    <div class="info">
                                        <div class="row">
                                            <div class="col-6 ">
                                                <h5 class="" style="padding-left: 35px;">General Settings</h5>
                                            </div>
                                            <div class="col-6 text-right mb-5">
                                                <a href=""><button id="add-work-platforms" name="submit"
                                                        class="btn btn-primary">Save</button></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="meta_title">Meta Title *</label>
                                                            <input type="text" class="form-control mb-4" id="meta_title"
                                                                placeholder="Meta Title "
                                                                value="<?php echo $meta_title; ?>" name="meta_title"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="meta_description">Meta Description *</label>
                                                            <input type="text" class="form-control mb-4"
                                                                id="meta_description" placeholder="Meta Description"
                                                                value="<?php echo $meta_description; ?>"
                                                                name="meta_description" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="meta_description">Meta Keyword *</label>
                                                            <input type="text" class="form-control mb-4"
                                                                id="meta_keyword" placeholder="Meta Keyword"
                                                                value="<?php echo $meta_keyword; ?>" name="meta_keyword"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="show_logo">Show brand Logo *</label>
                                                            <select class="form-control" name="show_logo"
                                                                id="show_logo">
                                                                <option value="1" <?php if ($show_logo == 1) {
                                                                                        echo 'selected';
                                                                                    } ?>>Yes</option>
                                                                <option value="0" <?php if ($show_logo == 0) {
                                                                                        echo 'selected';
                                                                                    } ?>>No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" id="brand_logo">
                                                        <div class="form-group">
                                                            <label for="brand_logo">Brand Logo Recommended Size
                                                                (112x70)</label><a
                                                                href="<?php echo $base_url . $setting_info->brand_logo; ?>"
                                                                target="_blank"><img class="image_size"
                                                                    src="<?php echo $base_url . $setting_info->brand_logo; ?>"
                                                                    alt=""></a>
                                                            <input type="file" class="form-control mb-4"
                                                                placeholder="Brand Logo"
                                                                value="<?php echo $brand_logo; ?>" name="brand_logo">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" id="admin_logo">
                                                        <div class="form-group">
                                                            <label for="admin_logo">Admin Logo Recommended Size
                                                                (112x70)</label><a
                                                                href="<?php echo $base_url . $setting_info->admin_logo; ?>"
                                                                target="_blank"><img class="image_size"
                                                                    src="<?php echo $base_url . $setting_info->admin_logo; ?>"
                                                                    alt=""></a>
                                                            <input type="file" class="form-control mb-4"
                                                                placeholder="Admin Logo"
                                                                value="<?php echo $admin_logo; ?>" name="admin_logo">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" id="business_title">
                                                        <div class="form-group">
                                                            <label for="business_title">Business Title *</label>
                                                            <input type="text" class="form-control mb-4"
                                                                placeholder="Business Title"
                                                                value="<?php echo $business_title; ?>"
                                                                name="business_title" required>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="brand_logo">Brand Logo *</label>
                                                            <input type="file" class="form-control mb-4" id="brand_logo" placeholder="Brand Logo" value="<?php echo $brand_logo; ?>" name="brand_logo">
                                                        </div>
                                                    </div> -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="meta_description">Brand Tittle *</label>
                                                            <input type="text" class="form-control mb-4"
                                                                id="meta_keyword" placeholder="Brand Tittle"
                                                                value="<?php echo $brand_title; ?>" name="brand_title"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" id="brand_logo">
                                                        <div class="form-group">
                                                            <label for="fav_icon">Fav Icon Recomended Size(32 X
                                                                32)</label><a
                                                                href="<?php echo $base_url . $setting_info->fav_icon; ?>"
                                                                target="_blank"><img class="image_size"
                                                                    src="<?php echo $base_url . $setting_info->fav_icon; ?>"
                                                                    alt=""></a>
                                                            <input type="file" class="form-control mb-4"
                                                                placeholder="Brand Logo"
                                                                value="<?php echo $fav_icon; ?>" name="fav_icon">
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="color_scheme">Color Scheme *</label>
                                                            <select class="form-control" id="color_scheme"
                                                                name="color_scheme">
                                                                <?php foreach ($website_color_scheme_result as $color_scheme_info) { ?>
                                                                <option
                                                                    <?php echo ($old_color_scheme == $color_scheme_info['id']) ? "selected" : "" ?>
                                                                    value="<?php echo $color_scheme_info['id']; ?>">
                                                                    <?php echo $color_scheme_info['title']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div> -->
                                                    <!-- <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="facebook_pixel_code_header">Facebook Pixel Code
                                                                Header </label>
                                                            <textarea type="text" class="form-control mb-4" id="facebook_pixel_code_header" placeholder="Facebook Pixel Code Header" value="" name="facebook_pixel_code_header"><?php echo $facebook_pixel_code_header; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="facebook_pixel_code_body">Facebook Pixel Code
                                                                Body </label>
                                                            <textarea type="text" class="form-control mb-4" id="facebook_pixel_code_body" placeholder="Facebook Pixel Code Body" value="" name="facebook_pixel_code_body"><?php echo $facebook_pixel_code_body; ?></textarea>
                                                        </div>
                                                    </div> -->
                                                    <!-- <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="google_analytics_header">Google Analytics Header
                                                            </label>
                                                            <textarea type="text" class="form-control mb-4" id="google_analytics_header" placeholder="Google Analytics Header" value="" name="google_analytics_header"><?php echo $google_analytics_header; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="google_analytics_body">Google Analytics
                                                                Body</label>
                                                            <textarea type="text" class="form-control mb-4" id="google_analytics_body" placeholder="Google Analytics Body" value="" name="google_analytics_body"><?php echo $google_analytics_body; ?></textarea>
                                                        </div>
                                                    </div> -->
                                                    <!-- <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="welcome_video_embed_code">Google Map Code</label>
                                                            <textarea type="text" class="form-control mb-4" id="welcome_video_embed_code" placeholder="Google Map Code" value="" name="welcome_video_embed_code"><?php echo $welcome_video_embed_code; ?></textarea>
                                                        </div>
                                                    </div> -->
                                                    <!-- <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="event_id">Event Id </label>
                                                            <input type="text" class="form-control mb-4" id="event_id"
                                                                placeholder="Event Id" value="<?php echo $event_id; ?>"
                                                                name="event_id">
                                                        </div>
                                                    </div> -->
                                                    <!-- <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="welcome_text">Welcome Text</label>
                                                            <textarea type="text" class="form-control mb-4" id="welcome_text" placeholder="Welcome Text" value="" name="welcome_text"><?php echo $welcome_text; ?></textarea>
                                                        </div>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="info">
                                        <h5 class="" style="padding-left: 35px;">Contact Section</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="admin_email">Admin Email
                                                            </label>
                                                            <input type="email" class="form-control mb-4"
                                                                id="admin_email" placeholder="Admin Email"
                                                                value="<?php echo $admin_email; ?>" name="admin_email">
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="admin_phone">Admin Phone
                                                            </label>
                                                            <input type="text" class="form-control mb-4" id="admin_phone" placeholder="Admin Phone" value="<?php echo $admin_phone; ?>" name="admin_phone">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="admin_fex">Admin Fex
                                                            </label>
                                                            <input type="text" class="form-control mb-4" id="admin_fex" placeholder="Admin Fex" value="<?php echo $admin_fex; ?>" name="admin_fex">
                                                        </div>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="info">
                                        <h5 class="">Active Compaign Section</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="active_compaign_token">Active Compaign Token
                                                            </label>
                                                            <input type="text" class="form-control mb-4" id="active_compaign_token" placeholder="Active Compaign Token" value="<?php echo $active_compaign_token; ?>" name="active_compaign_token">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="active_compaign_url">Active Compaign Url
                                                            </label>
                                                            <input type="text" class="form-control mb-4" id="active_compaign_url" placeholder="Survey Url" value="<?php echo $active_compaign_url; ?>" name="active_compaign_url">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="list_id">List Id</label>
                                                            <input type="text" class="form-control mb-4" id="list_id" placeholder="List Id" value="<?php echo $list_id; ?>" name="list_id">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="info">
                                        <h5 class="" style="padding-left: 35px;">Thank You Section</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="email_subject">Email Subject </label>
                                                            <input type="text" class="form-control mb-4"
                                                                id="email_subject" placeholder="Email Subject"
                                                                value="<?php echo $email_subject; ?>"
                                                                name="email_subject">
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="email_sender">Email Sender</label>
                                                            <input type="text" class="form-control mb-4" id="email_sender" placeholder="Email Sender" value="<?php echo $email_sender; ?>" name="email_sender">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="thank_you_email_body">Thank You Email Body
                                                            </label>
                                                            <textarea type="text" class="form-control mb-4" id="thank_you_email_body" placeholder="Thank You Email Body" value="" name="thank_you_email_body"><?php echo $thank_you_email_body; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="thank_you_email_message">Thank You Email Message
                                                            </label>
                                                            <textarea type="text" class="form-control mb-4" id="thank_you_email_message" placeholder="Thank You Email Message" value="" name="thank_you_email_message"><?php echo $thank_you_email_message; ?></textarea>
                                                        </div>
                                                    </div> -->

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="contact_email_message"> Contact email message
                                                            </label>
                                                            <textarea type="text" class="form-control mb-4"
                                                                id="contact_email_message"
                                                                placeholder="contact_email_message" value=""
                                                                name="contact_email_message"><?php echo $contact_email_message; ?></textarea>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="info">
                                        <h5 class="" style="padding-left: 35px;">Website Buttons Setting</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="button1_title">Button 1 Title *</label>
                                                            <input type="text" class="form-control mb-4"
                                                                id="button1_title" placeholder="Button 1 Title "
                                                                value="<?php echo $button1_title; ?>"
                                                                name="button1_title">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="button2_link">Button 1 Link *</label>
                                                            <input type="text" class="form-control mb-4"
                                                                id="button1_link" placeholder="Button 2 link"
                                                                value="<?php echo $button1_link; ?>"
                                                                name="button1_link">
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="button2_title">Button 2 Title *</label>
                                                            <input type="text" class="form-control mb-4" id="button2_title" placeholder="Button 2 Title " value="<?php echo $button2_title; ?>" name="button2_title">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="button2_link">Button 2 Link *</label>
                                                            <input type="text" class="form-control mb-4" id="button2_link" placeholder="Button 2 Link" value="<?php echo $button2_link; ?>" name="button2_link">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="button3_title">Button 3 Title *</label>
                                                            <input type="text" class="form-control mb-4" id="button3_title" placeholder="Button 3 Title " value="<?php echo $button3_title; ?>" name="button3_title">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="button3_link">Button 3 Link *</label>
                                                            <input type="text" class="form-control mb-4" id="button3_link" placeholder="Button 3 link" value="<?php echo $button3_link; ?>" name="button3_link">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="button4_title">Button 4 Title *</label>
                                                            <input type="text" class="form-control mb-4" id="button4_title" placeholder="Button 4 Title " value="<?php echo $button4_title; ?>" name="button4_title">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="button4_link">Button 4 Link *</label>
                                                            <input type="text" class="form-control mb-4" id="button4_link" placeholder="Button 4 link" value="<?php echo $button4_link; ?>" name="button4_link">
                                                        </div>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="info">
                                        <h5 class="">Stripe Api Key</h5> -->
                                    <div class="row">
                                        <div class="col-md-11 mx-auto">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <!-- <div class="form-group">
                                                            <label for="publishable_key">Publishable Key</label>
                                                            <input type="text" class="form-control mb-4" id="publishable_key" placeholder="Publishable Key" value="<?php echo $publishable_key; ?>" name="publishable_key">
                                                        </div> -->
                                                </div>
                                                <div class="col-md-6">
                                                    <!-- <div class="form-group">
                                                            <label for="secret_key">Secret Key</label>
                                                            <input type="text" class="form-control mb-4" id="secret_key" placeholder="Secret Key" value="<?php echo $secret_key; ?>" name="secret_key">
                                                        </div> -->
                                                </div>
                                                <div class="col-md-12 text-right mb-5">
                                                    <a href=""><button id="add-work-platforms" name="submit"
                                                            class="btn btn-primary">Update Settings</button></a>
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
        $(document).ready(function() {
            var show_logo = $('#show_logo').val();
            if (show_logo == '1') {
                $("#business_title").hide();
                $("#brand_logo").show();
            } else {
                $("#business_title").show();
                $("#brand_logo").hide();
            }
            $('#show_logo').on('change', function() {
                if (this.value == '1') {
                    $("#business_title").hide();
                    $("#brand_logo").show();
                } else if (this.value == '0') {
                    $("#business_title").show();
                    $("#brand_logo").hide();
                }
            });
        });
        // CKEDITOR.replace('welcome_text', {
        //     filebrowserUploadUrl: '../../upload.php',
        //     filebrowserUploadMethod: "form"
        // });
        CKEDITOR.replace('thank_you_email_body', {
            filebrowserUploadUrl: '../../upload.php',
            filebrowserUploadMethod: "form"
        });
        CKEDITOR.replace('thank_you_email_message', {
            filebrowserUploadUrl: '../../upload.php',
            filebrowserUploadMethod: "form"
        });
        CKEDITOR.replace('contact_email_message', {
            filebrowserUploadUrl: '../../upload.php',
            filebrowserUploadMethod: "form"
        });
        </script>