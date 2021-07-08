<?php
include '../../../include/config.php';
include '../../../include/functions.php';
include '../../../include/resize-class.php';
$page_title = "Edit Pages ";;
$meta_description = "showcase";


/*********************if admin is not logged in it will be re directed to index page */
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
$error = $success = $page_name = $meta_title = $page_url = $meta_description = $page_link = $video_embed_code = $image = $image2 = $image3 = $image4 = $image5 = $description = $description2 = $description3 = $description4 = $description5 = "";
$status = $show_menu = 1;
/***************Get page data by id to update ****************/
$page_id = $_GET['page_id'];
$edit_page_data = get_pages_info_by_id($connection_string, $page_id);
$edit_page_info = $edit_page_data['get_info'];
$page_name = $edit_page_info->page_name;
$meta_title = $edit_page_info->meta_title;
$meta_description = $edit_page_info->meta_description;
$page_url = $edit_page_info->page_url;
$video_link = $edit_page_info->video_link;
$page_link = $edit_page_info->page_link;
$description = $edit_page_info->description;
$description2 = $edit_page_info->description2;
$description3 = $edit_page_info->description3;
$description4 = $edit_page_info->description4;
$description5 = $edit_page_info->description5;
$status = $edit_page_info->status;
$show_menu = $edit_page_info->show_menu;
$old_page_order = $edit_page_info->page_order;
$image = $edit_page_info->image;
$image2 = $edit_page_info->image2;
$image3 = $edit_page_info->image3;
$image4 = $edit_page_info->image4;
$image5 = $edit_page_info->image5;
/*********Get pages maximum  Order */
$max_order = get_maximum_order($connection_string, "pages", "page_order");
/***********when user click on add event button then after all validations it will add the new event******/
if (isset($_POST['edit_page'])) {
    //========= Validate Input Fields =======//
    $page_name = test_input($_POST['page_name']);
    $meta_title = test_input($_POST['meta_title']);
    $page_url = test_input($_POST['page_url']);
    $page_link = test_input($_POST['page_link']);
    $meta_description = test_input($_POST['meta_description']);
    $video_embed_code = test_input($_POST['video_embed_code']);
    $description = test_input(stripslashes($_POST['description']));
    $description2 = test_input(stripslashes($_POST['description2']));
    $description3 = test_input(stripslashes($_POST['description3']));
    $description4 = test_input(stripslashes($_POST['description4']));
    $description5 = test_input(stripslashes($_POST['description5']));
    $status = test_input($_POST['status']);
    $show_menu = test_input($_POST['show_menu']);
    $page_order = test_input($_POST['page_order']);

    /*******chechk if title is less than 5 chracters or greater than 200 chracters */
    if (($page_order <= '0') || ($page_order > $max_order)) {
        $error = "Page order should be in 1 and " . $max_order;
    } elseif (empty($page_name)) {
        $error = "Page Name should not be empty";
    } elseif (empty($meta_title)) {
        $error = "Meta Title should not be empty";
    } elseif (empty($meta_description)) {
        $error = "Meta Description should not be empty";
    }
    //if error is empty then upload image and then insert data in data base
    if ($error == "") {

        $main_image_upload_directory = 'uploads/pages';
        $image_directory = '../../../';
        if (!is_dir($image_directory . $main_image_upload_directory)) {
            mkdir($image_directory . $main_image_upload_directory, 0755, true);
        }

        // main image1 upload
        if (empty($_FILES["image"]["name"])) {
            $image = $image;
        } else {
            $image_replace =  str_replace(" ", "_", $_FILES["image"]["name"]);
            $image  =  "uploads/pages/" . date('YmdHis_') . "--" . $image_replace;
            move_uploaded_file($_FILES['image']['tmp_name'], $image_directory . $image);
        }

        if (empty($_FILES["image2"]["name"])) {
            $image2 = $image2;
        } else {
            // main image2 upload
            $image2_replace =  str_replace(" ", "_", $_FILES["image2"]["name"]);
            $image2  =  "uploads/pages/" . date('YmdHis_') . "--" . $image2_replace;
            move_uploaded_file($_FILES['image2']['tmp_name'], $image_directory . $image2);
        }
        if (empty($_FILES["image3"]["name"])) {
            $image3 = $image3;
        } else {
            // main image3 upload
            $image3_replace =  str_replace(" ", "_", $_FILES["image3"]["name"]);
            $image3  =  "uploads/pages/" . date('YmdHis_') . "--" . $image3_replace;
            move_uploaded_file($_FILES['image3']['tmp_name'], $image_directory . $image3);
        }
        if (empty($_FILES["image4"]["name"])) {
            $image4 = $image4;
        } else {
            // main image4 upload
            $image4_replace =  str_replace(" ", "_", $_FILES["image4"]["name"]);
            $image4  =  "uploads/pages/" . date('YmdHis_') . "--" . $image4_replace;
            move_uploaded_file($_FILES['image4']['tmp_name'], $image_directory . $image4);
        }
        if (empty($_FILES["image5"]["name"])) {
            $image5 = $image5;
        } else {
            // main image5 upload
            $image5_replace =  str_replace(" ", "_", $_FILES["image5"]["name"]);
            $image5  =  "uploads/pages/" . date('YmdHis_') . "--" . $image5_replace;
            move_uploaded_file($_FILES['image5']['tmp_name'], $image_directory . $image5);
        }

        //resize image 1
        if (!empty($image_replace)) {
            $resizeObj = new resize($image_directory . $image);
            $resizeObj->resizeImage(294, 196, 'crop');
            $resizeObj->saveImage($image_directory . $image, 100);
        }

        //resize image 2
        if (!empty($image2_replace)) {
            $resizeObj = new resize($image_directory . $image2);
            $resizeObj->resizeImage(294, 196, 'crop');
            $resizeObj->saveImage($image_directory . $image2, 100);
        }
        //resize image 3
        if (!empty($image3_replace)) {
            $resizeObj = new resize($image_directory . $image3);
            $resizeObj->resizeImage(294, 196, 'crop');
            $resizeObj->saveImage($image_directory . $image3, 100);
        }
        //resize image 4
        if (!empty($image4_replace)) {
            $resizeObj = new resize($image_directory . $image4);
            $resizeObj->resizeImage(294, 196, 'crop');
            $resizeObj->saveImage($image_directory . $image4, 100);
        }
        //resize image 5
        if (!empty($image5_replace)) {
            $resizeObj = new resize($image_directory . $image5);
            $resizeObj->resizeImage(294, 196, 'crop');
            $resizeObj->saveImage($image_directory . $image5, 100);
        }
        //If new  Order order is Lower
        if ($page_order < $old_page_order) {
            $update_order = page_order_to_upper($old_page_order, $page_order, $connection_string);
        }
        //if new order is greater than older order
        else if ($page_order > $old_page_order) {
            $update_order = page_order_to_lower($old_page_order, $page_order, $connection_string);
        }
        //Update page by id
        $update_page_query = "UPDATE `pages` SET `page_name`='$page_name',`meta_title`='$meta_title',
        `meta_description`='$meta_description',`page_url`='$page_url',`video_link`='$video_embed_code',
        `description`='$description',`description2`='$description2',`description3`='$description3',
        `description4`='$description4',`description5`='$description5',`status`='$status',
        `image`='$image',`image2`='$image2',`image3`='$image3',`image4`='$image4',
        `image5`='$image5',`show_menu`='$show_menu',`page_order`='$page_order' WHERE `id`='$page_id'";

        $update_page_query_result = mysqli_query($connection_string, $update_page_query);
        if ($update_page_query_result) {
            header('Location:pages.php');
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
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Add</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><span>User</span></li>
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
                                        <h5 class="">Add Page</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="Title">Page Name *</label>
                                                            <input type="text" class="form-control mb-4" id="Title" placeholder="Page Name" value="<?php echo $page_name; ?>" name="page_name" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="meta_title">Meta Title *</label>
                                                            <input type="text" class="form-control mb-4" id="meta_title" placeholder="Page Title " value="<?php echo $meta_title; ?>" name="meta_title" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="page_url">Page URL *</label>
                                                            <input type="text" class="form-control mb-4" id="page_url" placeholder="Page URL " value="<?php echo $page_url; ?>" name="page_url">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="meta_description">Meta Description *</label>
                                                            <input type="text" class="form-control mb-4" id="meta_description" placeholder="Meta Description " value="<?php echo $meta_description; ?>" name="meta_description" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="page_order">Page Order *</label>
                                                            <input type="text" class="form-control mb-4" id="page_order" placeholder="Page Order " value="<?php echo $old_page_order; ?>" name="page_order" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="page_link">Page Link</label>
                                                            <select class="form-control" id="page_link" name="page_link">
                                                                <option value="index.php" <?php echo ($page_link == 'index.php') ? "selected" : "" ?>>
                                                                    Home</option>
                                                                <option value="about.php" <?php echo ($page_link == 'about.php') ? "selected" : "" ?>>
                                                                    About</option>
                                                                <option value="contact.php" <?php echo ($page_link == 'contact.php') ? "selected" : "" ?>>
                                                                    Contact</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="show_menu">Show In Menu</label>
                                                            <select class="form-control" id="show_menu" name="show_menu">
                                                                <option value="1" <?php echo ($show_menu == '1') ? "selected" : "" ?>>
                                                                    Yes</option>
                                                                <option value="0" <?php echo ($show_menu == '0') ? "selected" : "" ?>>
                                                                    No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="status">Status</label>
                                                            <select class="form-control" id="status" name="status">
                                                                <option <?php echo ($status == '1') ? "selected" : "" ?> value="1">Active</option>
                                                                <option <?php echo ($status == '0') ? "selected" : "" ?> value="0">InActive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="image">Image 1*</label>
                                                            <input type="file" class="form-control mb-4" id="image" placeholder="Image" value="<?php echo $image; ?>" name="image">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="image2">Image 2*</label>
                                                            <input type="file" class="form-control mb-4" id="image2" value="<?php echo $image2; ?>" name="image2">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="image3">Image 3*</label>
                                                            <input type="file" class="form-control mb-4" id="image3" value="<?php echo $image3; ?>" name="image3">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="image4">Image 4*</label>
                                                            <input type="file" class="form-control mb-4" id="image4" value="<?php echo $image4; ?>" name="image4">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="image5">Image 5*</label>
                                                            <input type="file" class="form-control mb-4" id="image5" placeholder="image5" value="<?php echo $image5; ?>" name="image5">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="video_embed_code">Video
                                                                Embed Code</label>
                                                            <textarea type="text" class="form-control mb-4" id="video_embed_code" name="video_embed_code"><?php echo $video_link; ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="description">Description 1*</label>
                                                            <textarea type="text" class="form-control mb-4" id="description" name="description"><?php echo $description; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="description2">Description 2*</label>
                                                            <textarea type="text" class="form-control mb-4" id="description2" name="description2"><?php echo $description2; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="description3">Description 3*</label>
                                                            <textarea type="text" class="form-control mb-4" id="description3" name="description3"><?php echo $description3; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="description4">Description 4*</label>
                                                            <textarea type="text" class="form-control mb-4" id="description4" name="description4"><?php echo $description4; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="description5">Description 5*</label>
                                                            <textarea type="text" class="form-control mb-4" id="description5" name="description5"><?php echo $description5; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 text-right mb-5">
                                                        <button name="edit_page" type="submit" id="add-work-platforms" class="btn btn-primary">Edit Page</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <?php include '../../includes/footer.php'; ?>
                            <script>
                                CKEDITOR.replace('description', {
                                    filebrowserUploadUrl: '../../upload.php',
                                    filebrowserUploadMethod: "form"
                                });
                                CKEDITOR.replace('description2', {
                                    filebrowserUploadUrl: '../../upload.php',
                                    filebrowserUploadMethod: "form"
                                });
                                CKEDITOR.replace('description3', {
                                    filebrowserUploadUrl: '../../upload.php',
                                    filebrowserUploadMethod: "form"
                                });
                                CKEDITOR.replace('description4', {
                                    filebrowserUploadUrl: '../../upload.php',
                                    filebrowserUploadMethod: "form"
                                });
                                CKEDITOR.replace('description5', {
                                    filebrowserUploadUrl: '../../upload.php',
                                    filebrowserUploadMethod: "form"
                                });
                            </script>