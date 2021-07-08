<?php
include '../../../include/config.php';
include '../../../include/functions.php';
include '../../../include/resize-class.php';
include '../../includes/admin_auth.php';
$active_menu = "pages";
$page_title = "Add Pages ";;
$meta_description = "showcase";
/*********************if admin is not logged in it will be re directed to index page */
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
$error = $success = $page_name = $meta_title = $page_url = $meta_description = $page_link = $video_embed_code = $image = $image2 = $image3 = $image4 = $image5 = $description = $description2 = $description3 = $description4 = $description5 = "";
$status = $show_menu = 1;

// ===>Get Max Order<===
$maximum_order = get_maximum_order($connection_string, 'pages', 'page_order');
$order = $maximum_order + 1;

/***********when user click on add page button then after all validations it will add the new event******/
if (isset($_POST['add_page'])) {
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
    /*******validation of input fields */
    if (empty($page_name)) {
        $error = "Page Name should not be empty";
    } elseif (empty($meta_title)) {
        $error = "Meta Title should not be empty";
    } elseif (empty($meta_description)) {
        $error = "Meta Description should not be empty";
    }
    //if error is empty then upload image and then insert data in data base
    if ($error == "") {
        /*********new images */
        // Upload image after verifying then resize and store image thumbnail//
        $file = $_FILES['image']['tmp_name'];
        $file_name = $_FILES['image']['name'];
        $file_name_array = explode(".", $file_name);
        $extension = end($file_name_array);
        //we want to save the image with timestamp and randomnumber
        $new_image_name = time() . rand() . '.' . $extension;
        $allowed_extension = array("jpg", "gif", "png", "jpeg");
        $image_dir = '../../../';
        if (in_array($extension, $allowed_extension)) {
            move_uploaded_file($file, $image_dir . 'uploads/pages/' . $new_image_name);
            $cover_thumbnail1 = $image_dir . 'uploads/pages/thumbnail/' . $new_image_name;
            $resizeObj = new resize($image_dir . 'uploads/pages/' . $new_image_name);
            $resizeObj->resizeImage(50, 50, 'crop');
            $resizeObj->saveImage($cover_thumbnail1, 100);
        }
        /****Image 2 */
        $file2 = $_FILES['image2']['tmp_name'];
        $file_name2 = $_FILES['image2']['name'];
        $file_name_array2 = explode(".", $file_name2);
        $extension = end($file_name_array2);
        //we want to save the image with timestamp and randomnumber
        $new_image_name2 = time() . rand() . '.' . $extension;
        $allowed_extension = array("jpg", "gif", "png", "jpeg");
        $image_dir = '../../../';
        if (in_array($extension, $allowed_extension)) {
            move_uploaded_file($file2, $image_dir . 'uploads/pages/' . $new_image_name2);
            $cover_thumbnail2 = $image_dir . 'uploads/pages/thumbnail/' . $new_image_name2;
            $resizeObj = new resize($image_dir . 'uploads/pages/' . $new_image_name2);
            $resizeObj->resizeImage(50, 50, 'crop');
            $resizeObj->saveImage($cover_thumbnail2, 100);
        }
        /********Image 3 ******/
        $file3 = $_FILES['image3']['tmp_name'];
        $file_name3 = $_FILES['image3']['name'];
        $file_name_array3 = explode(".", $file_name3);
        $extension = end($file_name_array3);
        //we want to save the image with timestamp and randomnumber
        $new_image_name3 = time() . rand() . '.' . $extension;
        $allowed_extension = array("jpg", "gif", "png", "jpeg");
        $image_dir = '../../../';
        if (in_array($extension, $allowed_extension)) {
            move_uploaded_file($file3, $image_dir . 'uploads/pages/' . $new_image_name3);
            $cover_thumbnail3 = $image_dir . 'uploads/pages/thumbnail/' . $new_image_name3;
            $resizeObj = new resize($image_dir . 'uploads/pages/' . $new_image_name3);
            $resizeObj->resizeImage(50, 50, 'crop');
            $resizeObj->saveImage($cover_thumbnail3, 100);
        }
        /********Image 4 ******/
        $file4 = $_FILES['image4']['tmp_name'];
        $file_name4 = $_FILES['image4']['name'];
        $file_name_array4 = explode(".", $file_name4);
        $extension = end($file_name_array4);
        //we want to save the image with timestamp and randomnumber
        $new_image_name4 = time() . rand() . '.' . $extension;
        $allowed_extension = array("jpg", "gif", "png", "jpeg");
        $image_dir = '../../../';
        if (in_array($extension, $allowed_extension)) {
            move_uploaded_file($file4, $image_dir . 'uploads/pages/' . $new_image_name4);
            $cover_thumbnail4 = $image_dir . 'uploads/pages/thumbnail/' . $new_image_name4;
            $resizeObj = new resize($image_dir . 'uploads/pages/' . $new_image_name4);
            $resizeObj->resizeImage(50, 50, 'crop');
            $resizeObj->saveImage($cover_thumbnail4, 100);
        }
        /******image 5 */
        $file5 = $_FILES['image5']['tmp_name'];
        $file_name5 = $_FILES['image5']['name'];
        $file_name_array5 = explode(".", $file_name5);
        $extension = end($file_name_array5);
        //we want to save the image with timestamp and randomnumber
        $new_image_name5 = time() . rand() . '.' . $extension;
        $allowed_extension = array("jpg", "gif", "png", "jpeg");
        $image_dir = '../../../';
        if (in_array($extension, $allowed_extension)) {
            move_uploaded_file($file5, $image_dir . 'uploads/pages/' . $new_image_name5);
            $cover_thumbnail5 = $image_dir . 'uploads/pages/thumbnail/' . $new_image_name5;
            $resizeObj = new resize($image_dir . 'uploads/pages/' . $new_image_name5);
            $resizeObj->resizeImage(50, 50, 'crop');
            $resizeObj->saveImage($cover_thumbnail5, 100);
        }

        //insert page data
        $insert_page_query = "INSERT INTO `pages`(`page_name`, `meta_title`, `meta_description`, 
        `page_url`, `video_link`, `description`, `description2`, `description3`, `description4`,
         `description5`, `status`, `image`, `image2`, `image3`, `image4`, `image5`, `show_menu`, 
         `page_order`,`page_link`) VALUES ('$page_name','$meta_title','$meta_description','$page_url','$video_embed_code'
         ,'$description',
         '$description2','$description3','$description4','$description5','$status','$new_image_name','$new_image_name2','$new_image_name3'
         ,'$new_image_name4','$new_image_name5','$show_menu','$order','$page_link')";
        $insert_page_query_result = mysqli_query($connection_string, $insert_page_query);
        if ($insert_page_query_result) {
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
                            <!-- <li class="breadcrumb-item"><a href="javascript:void(0);">Add</a></li> -->
                            <li class="breadcrumb-item active" aria-current="page"><span>Add Page</span></li>
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
                                                            <label for="page_url">Page URL</label>
                                                            <input type="text" class="form-control mb-4" id="page_url" placeholder="Page URL " value="<?php echo $page_url; ?>" name="page_url">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="meta_description">Meta Description *</label>
                                                            <input type="text" class="form-control mb-4" id="meta_description" placeholder="Meta Description " required value="<?php echo $meta_description; ?>" name="meta_description">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="page_link">Page Link</label>
                                                            <select class="form-control" id="page_link" name="page_link">
                                                                <option value="index.php">Home</option>
                                                                <option value="about.php">About</option>
                                                                <option value="contact.php">Contact</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="show_menu">Show In Menu</label>
                                                            <select class="form-control" id="show_menu" name="show_menu">
                                                                <option value="1">Yes</option>
                                                                <option value="0">No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="status">Status</label>
                                                            <select class="form-control" id="status" name="status">
                                                                <option value="1">Active
                                                                </option>
                                                                <option value="0">InActive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="image">Image 1</label>
                                                            <input type="file" class="form-control mb-4" id="image" placeholder="Image" value="<?php echo $image; ?>" name="image">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="image2">Image 2</label>
                                                            <input type="file" class="form-control mb-4" id="image2" value="<?php echo $image2; ?>" name="image2">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="image3">Image 3</label>
                                                            <input type="file" class="form-control mb-4" id="image3" value="<?php echo $image3; ?>" name="image3">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="image4">Image 4</label>
                                                            <input type="file" class="form-control mb-4" id="image4" value="<?php echo $image4; ?>" name="image4">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="image5">Image 5</label>
                                                            <input type="file" class="form-control mb-4" id="image5" placeholder="image5" value="<?php echo $image5; ?>" name="image5">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="video_embed_code">Video
                                                                Embed Code</label>
                                                            <textarea type="text" class="form-control mb-4" id="video_embed_code" name="video_embed_code"><?php echo $video_embed_code; ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="description">Description 1</label>
                                                            <textarea type="text" class="form-control mb-4" id="description" name="description"><?php echo $description; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="description2">Description 2</label>
                                                            <textarea type="text" class="form-control mb-4" id="description2" name="description2"><?php echo $description2; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="description3">Description 3</label>
                                                            <textarea type="text" class="form-control mb-4" id="description3" name="description3"><?php echo $description3; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="description4">Description 4</label>
                                                            <textarea type="text" class="form-control mb-4" id="description4" name="description4"><?php echo $description4; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="description5">Description 5</label>
                                                            <textarea type="text" class="form-control mb-4" id="description5" name="description5"><?php echo $description5; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 text-right mb-5">
                                                        <button name="add_page" type="submit" id="add-work-platforms" class="btn btn-primary">Add Page</button>
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