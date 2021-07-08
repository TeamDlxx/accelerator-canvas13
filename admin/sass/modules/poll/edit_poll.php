<?php
include '../../../include/config.php';
include '../../../include/functions.php';
// =====>meta tags <=====
$page_title = "Edit Poll ";;
$meta_description = "showcase";
/*********************if admin is not logged in it will be re directed to index page */
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
$error = $success = $pool_question = "";
$pool_status = 1;
$poll_id = $_GET['poll_id'];

/******Get poll Answere by id */
$get_poll_answere = poll_answer_by_id($connection_string, $poll_id);
$result = $get_poll_answere['get_info'];
/*******Get poll Count */
$count = get_poll_count($connection_string, $poll_id);
$_SESSION['count'] = $count;
/*******get poll innfo by id */
$poll_info = get_poll_question_info_by_id($connection_string, $poll_id);
$poll_info_result = $poll_info['get_info'];
if ($poll_info['status'] == 0) {
    $error = "Theri no data";
} else {
    $poll_question = $poll_info_result->pool_question;
    $poll_status = $poll_info_result->pool_question;
    $poll_type = $poll_info_result->pool_type;
    $event_id = $poll_info_result->event_id;
    $video_id = $poll_info_result->video_id;
}

if (isset($_POST['submit'])) {

    $poll_question = $_POST['poll_question'];
    $poll_status = $_POST['poll_status'];
    $poll_id = $_POST['poll_id'];
    $poll_type = $_POST['poll_type'];
    // $hidden_id = $_POST['add'];
    $event_id = $_POST['event_id'];
    $video_id = $_POST['video'];


    if (strlen($poll_question) < 5 or strlen($poll_question) > 200) {
        $error = "Minimum 5 and maximum 200 chracters allowed for title";
    }


    //If no error, edit event with give details
    if ($error == "") {
        $update_pool_query = "update `pool_question` set `pool_question`='$poll_question',`pool_status`='$poll_status',`event_id`='$event_id',`pool_type`='$poll_type' ,`video_id`='$video_id' where `pool_id`='$poll_id'";
        $update_pool_query_result = mysqli_query($connection_string, $update_pool_query);
        /********update Poll Answers */
        for ($j = 0; $j < $count;) {
            $update_answer = "UPDATE poll_answer SET poll_answer = '" . $_POST['poll_options'][$j] . "' WHERE id = '" . $_POST['poll_answer_id'][$j] . "' ";
            $update_result = mysqli_query($connection_string, $update_answer);
            $j++;
        }
        if ($update_pool_query_result === false) {
            $error = $error_support;
        } else {
            $number = count($_POST['name']);
            if ($number > 1) {
                for ($i = 0; $i < $number; $i++) {

                    if (trim($_POST["name"][$i] != '')) {
                        $sql = "INSERT INTO poll_answer(pool_id, poll_answer) VALUES('" . $poll_id . "' ,'" . $_POST["name"][$i] . "')";
                        mysqli_query($connection_string, $sql);
                    }
                }
                echo "Data Inserted";
            } else {
                echo "Please Enter Name";
            }
        }
    }

    //Form Validation ELSE ends here

}

$events = get_events_info($connection_string);
$events = $events['get_info'];

$event_videos = get_event_videos($connection_string);
$event_videos = $event_videos['get_info'];
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
                            <li class="breadcrumb-item active" aria-current="page"><span>Add FAQ</span></li>
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
                                        <h5 class="">Add FAQ</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="First Name">Poll Question *</label>
                                                            <input type="text" class="form-control mb-4" id="poll_question" placeholder="Poll Question" value="<?= $poll_question ?>" name="poll_question" required>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="email">Poll Status</label>
                                                            <select class="form-control" id="poll_status" name="poll_status">
                                                                <option <?php echo ($poll_status == 1) ? "selected" : "" ?> value="1">Active </option>
                                                                <option <?php echo ($poll_status == 0) ? "selected" : "" ?> value="0">InActive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="email">Poll Type</label>
                                                            <select class="form-control" name="poll_type" id="pool_type">
                                                                <option <?php echo ($poll_type == "general") ? "selected" : "" ?> value="general">General</option>
                                                                <option <?php echo ($poll_type == "event") ? "selected" : "" ?> value="event">Event</option>
                                                                <option <?php echo ($poll_type == "video") ? "selected" : "" ?> value="video">Video</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" id="events">
                                                        <div class="form-group">
                                                            <label for="email">Events</label>
                                                            <select class="form-control" name="event_id" id="event_id">
                                                                <?php
                                                                foreach ($events as $event_list) {
                                                                ?>
                                                                    <option value="<?php echo $event_list['event_id']; ?>">
                                                                        <?php echo $event_list['title']; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" id="video_box">
                                                        <div class="form-group">
                                                            <label for="email">Video</label>
                                                            <select class="form-control" name="video" id="video">
                                                                <?php
                                                                foreach ($event_videos as $videos) { ?>
                                                                    <option value="<?php echo $videos['id']; ?>
"><?php echo $videos['video_title']; ?></option>
                                                                <?php }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row"> <?php
                                                                    $i = 0;
                                                                    foreach ($result as $key) { ?>
                                                        <div class='col-md-6'>
                                                            <div class='item form-group'>
                                                                <label class='control-label col-12' for='email'>Option <?php echo $i + 1; ?> <span class="required">*</span>
                                                                </label>
                                                                <div class='col-12'>
                                                                    <input type='hidden' name='poll_id' value='<?= $key['pool_id']; ?>'>
                                                                    <input type='hidden' name='poll_answer_id[<?php echo $i ?>]' value='<?= $key['id']; ?>'>
                                                                    <input type='text' id='tagline' name='poll_options[<?php echo $i ?>]' value='<?= $key['poll_answer']; ?>' required='required' placeholder='options' class='form-control'>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php $i++;
                                                                    } ?>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="option" id="dynamic_field_label_odd"></label>
                                                        <div class="item form-group">
                                                            <div class="col-12" id="dynamic_field" style="padding-left:0; padding-right:0;">
                                                                <input type="hidden" name="name[]" placeholder="Add More Options" class="form-control name_list" />
                                                                <input type="hidden" name="insert" value="2" id="insert" class="form-control name_list" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 ">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="option" id="dynamic_field_label"></label>
                                                        <div class="item form-group">
                                                            <div class="col-12" id="dynamic_field_even" style="padding-left:0; padding-right:0;">
                                                                <input type="hidden" name="name[]" placeholder="Add More Options" class="form-control name_list" />
                                                                <input type="hidden" name="insert" value="2" id="insert" class="form-control name_list" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-right mb-5">
                                                    <button id="add-work-platforms" class="btn btn-primary" type="submit" name="submit">Save</button>
                                                    <button id="add" class="btn btn-primary" type="button" name="add">Add
                                                        Options</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
                $(document).ready(function() {
                    var i = "<?php echo $count; ?>";
                    $('#add').click(function() {
                        i++;
                        if (i % 2 != 0) {
                            $('#dynamic_field').append(
                                `<label>Option ${i}*</label><br>
                            <input type='text' name='name[]' id='option-${i}' placeholder='option ${i}' class='form-control name_list'style="margin-bottom: 10px;" />`
                            );
                        } else if (i % 2 == 0) {
                            // $('#dynamic_field_label').append(

                            $('#dynamic_field_even').append(
                                `<label>Option ${i}*</label><br>
                            <input type='text' name='name[]' id='option-${i}' placeholder=' option ${i}' class='form-control name_list'style="margin-bottom: 10px;" />`
                            );
                        }
                    });

                    $(document).on('click', '.btn_remove', function() {
                        var button_id = $(this).attr("id");
                        $('#row' + button_id + '').remove();
                    });

                    $('#submit').click(function() {
                        $.ajax({
                            url: "pool.php",
                            method: "POST",
                            data: $('#add_name').serialize(),
                            success: function(data) {
                                alert(data);
                                $('#add_name')[0].reset();
                            }
                        });
                    });



                    //Hide Event list on generel
                    $("#events").hide();
                    $("#video_box").hide();
                    $('#pool_type').on('change', function() {
                        if (this.value == 'general') {
                            $("#events").hide();
                            $("#video_box").hide();
                        } else if (this.value == 'event') {
                            $("#events").show();
                            $("#video_box").hide();
                        } else {
                            $("#events").show();
                            $("#video_box").show();
                        }
                    });
                    $("#pool_type").change(function() {
                        if (this.value == 'video') {
                            var event_id = $("#event_id").val();
                            $.ajax({
                                url: "get_event_videos.php",
                                type: "POST",
                                data: {
                                    event_id: event_id
                                },
                                success: function(data) {
                                    data = JSON.parse(data);
                                    $('#video').empty();
                                    data.forEach(function(video) {
                                        $('#video').append('<option value =' + video
                                            .id + '>' + video.video_title +
                                            '</option>')
                                    })
                                }
                            })
                        }
                    });
                    //Get Event Videos
                    $("#event_id").change(function() {
                        var event_id = $("#event_id").val();
                        $.ajax({
                            url: "get_event_videos.php",
                            type: "POST",
                            data: {
                                event_id: event_id
                            },
                            success: function(data) {
                                data = JSON.parse(data);
                                $('#video').empty();
                                data.forEach(function(video) {
                                    $('#video').append('<option value =' + video.id +
                                        '>' + video.video_title + '</option>')
                                })
                            }
                        })
                    });

                });
            </script>