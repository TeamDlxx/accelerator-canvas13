<?php
include '../../../include/config.php';
include '../../../include/functions.php';
include '../../includes/admin_auth.php';
$active_menu = "menu";
// =====>meta tags <=====
$page_title = "Add Menu ";

$active_menu = "menu";
/*********************if admin is not logged in it will be re directed to index page */
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
/**********initialize variables********/
$error = $success = $menu_title = "";
$menu_status = 1;
$item_name = array();
$number = 0;
/***********when user click on save button it validate and then insert data into data base */
if (isset($_POST['submit'])) {

    $menu_title = $_POST['menu_title'];
    $menu_status = $_POST['menu_status'];
    if (isset($_POST['item_name']) || isset($_POST['item_url']) || isset($_POST['item_id'])) {
        $item_name = $_POST['item_name'];
        $item_url = $_POST['item_url'];
        $item_id = $_POST['item_id'];
    }


    if (strlen($menu_title) < 5 or strlen($menu_title) > 200) {
        $error = "Minimum 5 and maximum 200 chracters allowed for title";
    }


    //If no error, edit event with give details
    if ($error == "") {


        $add_menu_query = "INSERT INTO `menu_list`(`menu_title`, `menu_status`) VALUES ('$menu_title','$menu_status')";
        $add_menu_query_result =  mysqli_query($connection_string, $add_menu_query);
        if ($add_menu_query_result) {
            $menu_id = mysqli_insert_id($connection_string);
            $number = count($item_name);
            if ($number >= 1) {
                for ($i = 0; $i < $number; $i++) {
                    /*********if user choose existing page  */
                    if (trim($item_id[$i] != '')) {
                        $add_menu_item_query = "INSERT INTO `menu_items`( `menu_id`, `page_id`, `item_link`) VALUES ('$menu_id','$item_id[$i]','$item_url[$i]')";
                        $add_menu_item_query_result = mysqli_query($connection_string, $add_menu_item_query);
                        if ($add_menu_item_query_result != true) {
                            $error = $error_support;
                        }
                    } else { //if user choose custom page
                        $add_menu_item_query = "INSERT INTO `menu_items`( `menu_id`, `item_name`, `item_link`) VALUES ('$menu_id','$item_name[$i]','$item_url[$i]')";
                        $add_menu_item_query_result = mysqli_query($connection_string, $add_menu_item_query);
                        if ($add_menu_item_query_result != true) {
                            $error = $error_support;
                        }
                    }
                }
            }
            header('Location:menu_list.php');
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
                            <li class="breadcrumb-item active" aria-current="page"><span>Add Menu</span></li>
                        </ol>
                    </nav>

                </div>
            </li>
        </ul>
        <?php include '../../includes/side_header.php'; ?>
    </header>
</div>
<!--  END NAVBAR  -->
<script type="text/javascript">
    $(document).ready(function() {

        $("#add").click(function() {
            var counter = parseInt($("#insert").val());
            counter++;
            $("#insert").val(counter);
            $("#insert").text(counter);
        });

    });
</script>
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
                                        <h5 class="" style="padding-left: 35px;">Add Menu</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="menu_title">Menu Title*</label>
                                                            <input type="text" class="form-control mb-4" id="menu_title" placeholder="Menu Title" value="" name="menu_title" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="menu_status">Menu Status</label>
                                                            <select class="form-control" id="menu_status" name="menu_status">
                                                                <option value="1">Active </option>
                                                                <option value="0">InActive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" id="dynamic_field">
                                                </div>
                                                <div class="col-md-12 text-right mb-5">
                                                    <button id="add-work-platforms" class="btn btn-primary" type="submit" name="submit">Save</button>
                                                    <button id="add" class="btn btn-primary" type="button" name="add">Add Item</button>
                                                </div>
                                            </div>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  END CONTENT AREA  -->
    <!-- FOOTER BEGIN -->
    <?php include '../../includes/footer.php'; ?>
    <!-- FOOTER END -->


    <script>
        function suggession(id) {
            var query = document.getElementById("page_title" + id).value;
            // alert(query);
            $.ajax({
                url: "page_list.php",
                method: "POST",
                data: {
                    'query': query
                },
                success: function(data) {
                    data = JSON.parse(data);
                    $('#item_list' + id).empty();
                    data.forEach(function(page) {
                        var page_link = page.page_link + "," + page.id;
                        $('#item_list' + id).append('<option value="' + page.page_name + '" data-url = "' + page_link + '">');
                    })
                }
            });
        }

        function onInput(id) {
            var title = $('#page_title' + id).val()
            var item = $('#item_list' + id + ' option').filter(function() {
                return this.value == title;
            }).data('url');
            var msg = item ? item : '';
            var result = msg.split(",");
            var base_url = "<?= $base_url ?>";
            $('#page_url' + id).val(base_url + result[0]);
            $('#page_id' + id).val(result[1]);


        }

        function remove(id) {
            $('.item' + id).remove();
        }


        $(document).ready(function() {
            var i = 0;
            $('#add').click(function() {
                i++;

                $('#dynamic_field').append(

                    `<div class="col-md-6 item${i}">
                            <div class="form-group ">
                                <label for="item_title">Menu Item ${i} *</label>
                                <input type="text" onchange='onInput(${i})'  class="form-control mb-4" list = "item_list${i}" onkeyup="suggession(${i})" id="page_title${i}" placeholder="Menu Item ${i}" value="" name="item_name[]" required>
                                <datalist id="item_list${i}" ></datalist>
                            </div>
                        </div>
                        <div class="col-md-6 item${i}">
                            <div class="form-group">
                                <label for="page_url">Menu Item Url ${i} *</label><a class = "btn_remove float-right" onclick="remove(${i})">×</a>
                                <input type="text" class="form-control mb-4" id="page_url${i}" placeholder="Menu Item UrL${i}" value="" name="item_url[]" required>
                                <input type="hidden" class="form-control mb-4" id="page_id${i}" placeholder="Page Url" value="" name="item_id[]" required>
                                </div>
                            </div>
                            `
                );

            });


        });
    </script>