<?php
include '../../../include/config.php';
include '../../../include/functions.php';
include '../../includes/admin_auth.php';
$active_menu = "menu";
$error = $success = "";
$page_title = "Menu Items ";
$datatable = true;


//Get Options
$menu_id = $_GET['menu_id'];
//Delete Answers===//
if (isset($_GET['action']) and $_GET['action'] == 'delete') {
    $delete_item_query = "DELETE FROM `menu_items` WHERE `item_id`='" . $_GET['item_id'] . "'";
    $delete_item_query_result = mysqli_query($connection_string, $delete_item_query);

    if (!$delete_item_query_result) {
        $error = $error_support;
    } else {
        header("location: items_list.php?menu_id=$menu_id");
    }
}

$items_list = get_menu_items_by_id($connection_string, $menu_id);
$items_list_info = $items_list['get_info'];

?>

<!--  HEADER  -->
<?php include '../../includes/header.php'; ?>
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
                            <li class="breadcrumb-item active" aria-current="page"><span>Items List</span></li>
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
            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="table-responsive mb-4 mt-4">
                            <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Item Name</th>
                                        <th>Item Name Link</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 0;
                                    foreach ($items_list_info as $items_list_info_values) {
                                        $count++;
                                        $item_id = $items_list_info_values['item_id']; ?>
                                        <tr>
                                            <td><?php echo $count;
                                                ?></td>
                                            <?php if ($items_list_info_values['page_id'] == 0) { ?>
                                                <td><?php echo $items_list_info_values['item_name']; ?></td>
                                                <td><?php echo $items_list_info_values['item_link']; ?></td>
                                            <?php } ?>
                                            <?php if ($items_list_info_values['page_id'] > 0) {
                                                $page_id = $items_list_info_values['page_id'];
                                                $item_name_list = get_page_name_by_id($connection_string, $page_id);
                                                if ($item_name_list['status'] == 1) {
                                                    $item_name_info = $item_name_list['get_info'];
                                            ?>
                                                    <td><?php echo $item_name_info->page_name;
                                                    } ?></td>
                                                    <td><?php echo $items_list_info_values['item_link']; ?></td>
                                                <?php } ?>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-dark btn-sm" id="dropdownMenuReference1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent"><a href="">Open</a></button>
                                                        <button type="button" class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                                                <polyline points="6 9 12 15 18 9"></polyline>
                                                            </svg>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">
                                                            <a class="dropdown-item" href="items_list.php?item_id=<?= $item_id ?>&action=delete&menu_id=<?= $menu_id; ?>" onClick="return confirm('Are you sure you want to delete this option?')">Delete
                                                                items
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                        </tr>
                                    <?php }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!--  FOOTER  -->
        <?php include '../../includes/footer.php'; ?>