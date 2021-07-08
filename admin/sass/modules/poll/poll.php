<?php
include '../../../include/config.php';
include '../../../include/functions.php';
$error = $success = "";
$page_title = "Poll ";
$datatable = true;;
$meta_description = "showcase";
//Delete questions===//
if (isset($_GET['action']) && $_GET['action'] == "delete") {
    $poll_id = $_GET['poll_id'];
    $delete_poll_query = "DELETE FROM `pool_question` WHERE `pool_id`='$poll_id'";
    $delete_poll_query_result = mysqli_query($connection_string, $delete_poll_query);
    if ($delete_poll_query_result) {
        $success = "Poll deleted Successfully";
    } else {
        $error = $error_support;
    }
}

//===get questions data==//
$poll_result = get_poll_info($connection_string);
$poll_result_data = $poll_result['get_info'];


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
                            <li class="breadcrumb-item active" aria-current="page"><span>Poll</span></li>
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
                        <div class="col-md-12 text-right mb-5">
                            <a href="add_poll.php"><button id="add-work-platforms" class="btn btn-primary">Add
                                    New
                                    Poll </button></a>
                        </div>
                        <div class="table-responsive mb-4 mt-4">
                            <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Questions</th>
                                        <th>Total Options</th>
                                        <th>Show Website</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if ($poll_result['status'] == 1) {
                                        $count = 1;
                                        foreach ($poll_result_data as $poll_data_values) {
                                            $poll_id = $poll_data_values['pool_id'];
                                            $poll_answer_info = poll_answer_by_id($connection_string, $poll_id);
                                            $poll_answer_info = $poll_answer_info['get_info'];

                                    ?>

                                            <tr>
                                                <td><?php echo $count;
                                                    $count++; ?></td>
                                                <td><?php echo $poll_data_values['pool_question']; ?></td>
                                                <td><?php echo count($poll_answer_info); ?>
                                                </td>
                                                <td><?php echo ($poll_data_values['pool_status'] == '1') ? "Active" : "InActive"; ?>
                                                </td>

                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-dark btn-sm"><a href="">Open</a></button>
                                                        <button type="button" class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                                                <polyline points="6 9 12 15 18 9"></polyline>
                                                            </svg>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">
                                                            <a class="dropdown-item" href="poll.php?poll_id=<?= $poll_id; ?>&action=delete" onclick="return confirm('Are you sure you want to delete the Poll?')">Delete
                                                                Poll</a>
                                                            <a class="dropdown-item" href="delete_option.php?poll_id=<?= $poll_id; ?>;">Delete
                                                                Option
                                                            </a>
                                                            <a class="dropdown-item" href="edit_poll.php?poll_id=<?= $poll_id; ?>;">
                                                                Edit
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                    <?php }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!--  FOOTER  -->
        <?php include '../../includes/footer.php'; ?>