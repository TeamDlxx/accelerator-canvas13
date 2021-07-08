<?php
include '../../../include/config.php';
include '../../../include/functions.php';
include '../../includes/admin_auth.php';
$active_menu = "setting";
/*********************if admin is not logged in it will be re directed to index page */
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
$page_title = "Add Color Scheme ";;
$meta_description = "showcase";
/*********initialize all fields */
$error = $success = $scheme_title = $header_background_color = $header_menu_color = $header_menu_hover_color = $move_to_top_button = $link_color = $login_box_color = $login_box_text = $footer_background_color = $footer_text = $button_color = $button_text =  "";
$status = 1;
$color_scheme_id = $_GET['color_scheme_id'];
/*********get color scheme data */
$color_scheme = get_website_color_by_id($connection_string, $color_scheme_id);
$color_scheme_info = $color_scheme['get_info'];
$scheme_title = $color_scheme_info->title;
$header_background_color = $color_scheme_info->website_header_color;
$header_menu_color = $color_scheme_info->website_header_text;
$header_menu_hover_color = $color_scheme_info->header_menu_hover_color;
$footer_background_color = $color_scheme_info->website_footer_color;
$footer_text = $color_scheme_info->website_footer_text;
$link_color = $color_scheme_info->link_color;
$login_box_color = $color_scheme_info->login_box_color;
$login_box_text = $color_scheme_info->login_box_text;
$button_color = $color_scheme_info->button_color;
$button_text  = $color_scheme_info->button_text;
$status = $color_scheme_info->color_scheme_status;
$move_to_top_button = $color_scheme_info->back_top_button;

/*********when user click the add button it validate and then add new Color Scheme*/
if (isset($_POST['submit'])) {
    //Get Maximum Testimonial Order
    $maximum_testimonial_order = maximum_testimonial_order($connection_string);
    $testimonial_order  = $maximum_testimonial_order + 1;
    /**********call test input function to add slashes********/
    $scheme_title = test_input($_POST['scheme_title']);
    $status = test_input($_POST['status']);
    $header_background_color = test_input($_POST['header_background_color']);
    $header_menu_color = test_input($_POST['header_menu_color']);
    $header_menu_hover_color = test_input($_POST['header_menu_hover_color']);
    $move_to_top_button = test_input($_POST['move_to_top_button']);
    $link_color = test_input($_POST['link_color']);
    $login_box_color = test_input($_POST['login_box_color']);
    $login_box_text = test_input($_POST['login_box_text']);
    $footer_text = test_input($_POST['footer_text']);
    $footer_background_color = test_input($_POST['footer_background_color']);
    $button_text = test_input($_POST['button_text']);
    $button_color = test_input($_POST['button_color']);

    /***********validate if any required field is empty*******/
    if (empty($scheme_title)) {
        $error = 'Scheme Title is required. ';
    } else if (empty($header_background_color)) {
        $error = 'Header Back Ground Color is required. ';
    } else if (empty($header_menu_color)) {
        $error = 'Header Menu Color is required. ';
    } else if (empty($header_menu_hover_color)) {
        $error = 'Header Menu Hover Color is required. ';
    } else if (empty($move_to_top_button)) {
        $error = 'Move To Top Button Color is required. ';
    } else if (empty($footer_background_color)) {
        $error = 'Footer Background Color is required. ';
    } else if (empty($footer_text)) {
        $error = 'Footer text Color is required. ';
    } else if (empty($login_box_text)) {
        $error = 'Log In Box Text Color is required. ';
    } else if (empty($link_color)) {
        $error = 'Link Color is required. ';
    } else if (empty($login_box_color)) {
        $error = 'log In Box Color is required. ';
    } else if (empty($button_color)) {
        $error = 'Button Color is required. ';
    } else if (empty($button_text)) {
        $error = 'Button Text Color is required. ';
    }
    /*********if there is no error in any field then insert data */
    if (empty($error)) {

        $Update_color_scheme_query = "UPDATE `color_scheme` SET `title`='$scheme_title',`website_footer_color`='$footer_background_color',`website_header_color`='$header_background_color',`website_header_text`='$header_menu_color',`website_footer_text`='$footer_text',`login_box_color`='$login_box_color',`login_box_text`='$login_box_text',`button_text`='$button_text',`button_color`='$button_color',`link_color`='$link_color',`back_top_button`='$move_to_top_button',`header_menu_hover_color`='$header_menu_hover_color',`color_scheme_status`='$status' WHERE `id`=$color_scheme_id";
        $Update_color_scheme_query_result = mysqli_query($connection_string, $Update_color_scheme_query);
        if ($Update_color_scheme_query_result) {
            header('Location:website_color.php');
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
                            <li class="breadcrumb-item active" aria-current="page"><span>Edit Color Scheme</span></li>
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
                                        <h5 class="">Edit Website Color</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="scheme_title">Color Scheme Title *</label>
                                                            <input type="text" class="form-control mb-4" id="scheme_title" placeholder="Color Scheme Title " value="<?php echo $scheme_title; ?>" name="scheme_title" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="move_to_top_button">Move To Top Button *</label>
                                                            <input type="color" class="form-control mb-4" id="move_to_top_button" placeholder="move To Top Button " value="<?php echo $move_to_top_button; ?>" name="move_to_top_button" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="header_background_color">Header Backhroungd
                                                                Color *</label>
                                                            <input type="color" class="form-control mb-4" id="header_background_color" placeholder="Header Background Color " value="<?php echo $header_background_color; ?>" name="header_background_color" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="header_menu_color">Header Menu Color *</label>
                                                            <input type="color" class="form-control mb-4" id="header_menu_color" placeholder="Header Menu Color " value="<?php echo $header_menu_color; ?>" name="header_menu_color" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="header_menu_hover_color">Header Menu Hover Color
                                                                *</label>
                                                            <input type="color" class="form-control mb-4" id="header_menu_hover_color" placeholder="Header Menu Hover Color " value="<?php echo $header_menu_hover_color; ?>" name="header_menu_hover_color" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="link_color">Link Color *</label>
                                                            <input type="color" class="form-control mb-4" id="link_color" placeholder="Link Color" value="<?php echo $link_color; ?>" name="link_color" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="footer_background_color">Footer Background Color
                                                                *</label>
                                                            <input type="color" class="form-control mb-4" id="footer_background_color" placeholder="Footer Background Color " value="<?php echo $footer_background_color; ?>" name="footer_background_color" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="footer_text">Footer Text *</label>
                                                            <input type="color" class="form-control mb-4" id="footer_text" placeholder="Footer Text " value="<?php echo $footer_text; ?>" name="footer_text" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="login_box_color">Login Box Color *</label>
                                                            <input type="color" class="form-control mb-4" id="login_box_color" placeholder="Log In Box Color " value="<?php echo $login_box_color; ?>" name="login_box_color" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="login_box_text">Log In Box Text *</label>
                                                            <input type="color" class="form-control mb-4" id="login_box_text" placeholder="Log In Box Text " value="<?php echo $login_box_text; ?>" name="login_box_text" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="button_color">Button Color *</label>
                                                            <input type="color" class="form-control mb-4" id="button_color" placeholder="Button Color " value="<?php echo $button_color; ?>" name="button_color" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="button_text">Button Text *</label>
                                                            <input type="color" class="form-control mb-4" id="button_text" placeholder="Button text " value="<?php echo $button_text; ?>" name="button_text" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="status">Status</label>
                                                            <select class="form-control" id="status" name="status">
                                                                <option <?php echo ($status == 1) ? "selected" : "" ?> value="1">Active</option>
                                                                <option <?php echo ($status == 0) ? "selected" : "" ?> value="0">Non Active</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 text-right mb-5">
                                                        <a href=""><button id="add-work-platforms" name="submit" class="btn btn-primary">Save Color Scheme</button></a>
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
            <!-- FOOTER END -->