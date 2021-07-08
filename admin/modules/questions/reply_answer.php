<?php
include '../../../include/config.php';
include '../../../include/functions.php';
include '../../includes/admin_auth.php';
$active_menu = "questions";
$page_title = "Reply Answer ";;
$meta_description = "showcase";
$error = $success = "";
/*********************if admin is not logged in it will be re directed to index page */
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
/***************Get testimonial data by id to update ****************/
$question_id = $_GET['questions_id'];
$question_data = get_question_by_id($connection_string, $question_id);
$question_data_result = $question_data['get_info'];
$user_id = $question_data_result->user_id;
$old_question = $question_data_result->question;

$user_info = get_user_info_by_user_id($connection_string, $user_id);
$user_info = $user_info['get_info'];
$user_email = $user_info->email;

if (isset($_POST['submit'])) {

    $email_subject = test_input($_POST['email_subject']);
    $answer = test_input(stripslashes($_POST['answer']));

    if (strlen($answer) < 1) {
        $error = "Answer can not be empty";
    }

    if ($error == "") {
        //to check if admin already answered this question
        $answer_data = get_answer_by_id($connection_string, $question_id);
        if ($answer_data['status'] == 1) {
            $update_answer_query = "update `question_answer` set `question_answer`='$answer', `email_subject`='$email_subject',`user_id`='$user_id' where `question_id`='$question_id' ";
            if (!$update_result = mysqli_query($connection_string, $update_answer_query)) {
                $error = "There was issue updating Question's Answer ! Please try again later or contact support team";
            }
        } else {
            $insert_question_query = "INSERT INTO `question_answer`(`question_id`, `user_id`, `question_answer`,`email_subject`) VALUES (' $question_id ',' $user_id ',' $answer','$email_subject')";
            if (!$update_result = mysqli_query($connection_string, $insert_question_query)) {
                $error = "There was issue adding Question's Answer! Please try again later or contact support team";
            } else {
                $update_answer_status = "UPDATE `questions` SET `answered`= 1 WHERE `id`='$question_id'";
                if (!$update_result = mysqli_query($connection_string, $update_answer_status)) {
                    $error = "There was issue updating Question's Answer ! Please try again later or contact support team";
                }
            }
        }
        $message = stripslashes($answer);
        $str = str_replace("rnrn", "", $message);
        $message_body = "<html><head></head><body>" . $str . "</body></html>";

        $email_subject1 = stripslashes($email_subject);
        $subject = $email_subject1;

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $headers .= 'From: Showcase <explode@dynamitelifestyle.com>' . "\r\n";

        $message .= "<p><strong>Question:</strong><br>" . $old_question . "</p>";
        $message .= "<p><strong>Answer:</strong><br>" . $message_body . "</p>";

        if (mail($user_email, $email_subject1, $message, $headers)) {
            $success = "Thanks for contacting us. Our support team will contact you soon.";
        } else {
            $error_msg = "We could not process your request. Pleast try again later";
        }

        $_SESSION['question_reply_message'] = "Reply has been sent successfully";

        header("Location: questions.php");
    }
    //Form Validation ELSE ends here
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
                            <li class="breadcrumb-item active" aria-current="page"><span>Reply Answer</span></li>
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
            <div class="account-settings-container layout-top-spacing">
                <div class="account-content">
                    <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                <form id="contact" method="POST" class="section contact" enctype="multipart/form-data">
                                    <div class="info">
                                        <h5 class="">Reply Answer</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="short_description">Question</label>
                                                            <textarea type="text" class="form-control mb-4" id="question" placeholder="" value="" name="question"><?php echo $old_question; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="testimonial_order">Email Subject *</label>
                                                            <input type="text" class="form-control mb-4" required id="" placeholder="Email Subject" value="" name="email_subject">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="detailed_description">Answer
                                                                Reply</label>
                                                            <textarea type="text" class="form-control mb-4" id="detailed_description" placeholder="" value="" name="answer" required></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 text-right mb-5">
                                                        <button id="add-work-platforms" type="submit" name="submit" class="btn btn-primary">Reply Answer</button>
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
                CKEDITOR.replace('detailed_description', {
                    filebrowserUploadUrl: '../../upload.php',
                    filebrowserUploadMethod: "form"
                });
            </script>
            <!-- FOOTER END -->