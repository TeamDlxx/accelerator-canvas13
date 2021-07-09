<?php
include 'include/config.php';

include 'includes/header.php';



?>
<section class="income-sound mt-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mt-4">
                <img src="<?= $banner_image ?>">
            </div>
            <div class="col-lg-6">
                <div id="success" class="w-100">
                </div>
                <div id="error" class="w-100">
                </div>
                <div class="ml-lg-5 mt-4">
                    <?= $home_description ?>
                    <!-- h3>HOW DOES ANOTHER SOURCE OF INCOME SOUND, BY WORKING FROM HOME?</h3>
                    <p class="pt-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                        tempor incididunt m labore et dolore manna aliqua. Quis ipsum suspendisse
                        ultrices gravida. Risus commodo viverra maecenas accumsan locus vel facilisis. </p>< -->
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <span class="form-iconleft"><i class="fa fa-asterisk" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" placeholder="First Name" id="firstname">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <span class="form-iconleft"><i class="fa fa-asterisk" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" placeholder="Last Name" id="lastname">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group border-none">
                                <span class="form-iconleft"><i class="fa fa-asterisk" aria-hidden="true"></i></span>
                                <input type="text" class="form-control border-none" placeholder="Email" id="email">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <a href="#"><button type="submit" id="register" class="button-contact"><?= $slider_button1_title ?></button></a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-check mt-lg-2">
                                <input type="checkbox" class="form-check-input" id="checkSurfaceEnvironment-1">
                                <label class="form-check-label pl-3" id="checkSurfaceEnvironment-1" for="exampleCheck1"><?= $slider_button2_title ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="mission bg-navy mt-3 mt-lg-5">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-2">
            </div>
            <div class="col-sm-12 col-lg-8 text-center">
                <?= $welcome_content ?>
                <!-- <h3>MY MISSION</h3>
                <p class="pt-3">is to help other women to build a successful business from home around their current committments without interferring with what they are already doing.</p>
                <p class="pt-2">I will guide you and support you in following a simple blueprint that will lead you to achieve any goal you have.</p> -->
            </div>
            <div class="col-sm-12 col-lg-2">
            </div>
        </div>
    </div>
</section>
<section class="desire mt-3 mt-lg-5 pt-lg-3">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-1">
            </div>
            <div class="col-sm-12 col-lg-10 text-center">
                <?= $service_content ?>
                <!-- h2>LIVE THE LIFE YOU DESIRE </h2>
                <p class="mt-4">What kind ofjob can give you the luxury of a full-time wage, working from home with part-time hours around four children? </p>
                <p class="mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                    eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                    dese-runt mollit anim id est laborum.</p>< -->
            </div>
            <div class="col-sm-12 col-lg-1">
            </div>
        </div>
    </div>
</section>
<section class="benefits mt-3 mt-lg-5">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <i class="fa fa-square" aria-hidden="true"></i>
                <div class="border-icon"></div>
                <h3 class="mt-4 pt-2"><?= $benifint_heading ?></h3>
            </div>
        </div>
        <div class="row mt-5">
            <?php if ($services) {
                foreach ($services as $service_info) { ?>
                    <div class="col-lg-4 col-md-4 col-sm-12 text-center">
                        <img src="<?= $service_info['image'] ?>" class="img-fluid" alt="">
                        <div class="border-icon2"></div>
                        <h3 class="mt-5"><?= $service_info['service_name'] ?></h3>
                        <!-- <div class="mt-3">
                            <?= stripslashes(htmlspecialchars_decode($service_info['short_description'])) ?>
                        </div> -->
                        <p class="mt-3"><?= $service_info['short_description'] ?></p>
                    </div>

            <?php     }
            } ?>

            <!-- <div class="col-lg-4 col-md-4 col-sm-12 text-center mt-5 mt-md-0">
                <img src="images/Group 2.png" class="img-fluid" alt="">
                <div class="border-icon2"></div>
                <h3 class="mt-5">Benefit 2</h3>
                <p class="mt-3">You are your own boss so you choose hours that suit you, your family and other commihnentt.</p>
            </div> -->
            <!-- <div class="col-lg-4 col-md-4 col-sm-12 text-center mt-5 mt-md-0">
                <img src="images/Group 2.png" class="img-fluid" alt="">
                <div class="border-icon2"></div>
                <h3 class="mt-5">Benefit 3</h3>
                <p class="mt-3">Full Support and training are available 24.</p>
            </div> -->
            <!-- <div class="col-lg-4 col-md-4 col-sm-12 text-center mt-5">
                <img src="images/Group 2.png" class="img-fluid" alt="">
                <div class="border-icon2"></div>
                <h3 class="mt-5">Benefit 4</h3>
                <p class="mt-3">Personal development is huge, not only do, grow your income but you also grow as a person.</p>
            </div> -->
            <!-- <div class="col-lg-4 col-md-4 col-sm-12 text-center mt-5">
                <img src="images/Group 2.png" class="img-fluid" alt="">
                <div class="border-icon2"></div>
                <h3 class="mt-5">Benefit 5</h3>
                <p class="mt-3"> Uncapped and Willable income. The sky is the limit with your earning potential plus you build a Ngacy for generations to come.</p>
            </div> -->
            <!-- <div class="col-lg-4 col-md-4 col-sm-12 text-center mt-5">
                <img src="images/Group 2.png" class="img-fluid" alt="">
                <div class="border-icon2"></div>
                <h3 class="mt-5">Benefit 6</h3>
                <p class="mt-3">Access to free global travel and car plan incentive.</p>
            </div> -->
        </div>
        <div class="row mt-3 mt-lg-5">
            <div class="col-sm-12 text-center">
                <a id="contact" href="#scrollform"> <button class="button-contact"><?= $service_button_text ?></button></a>
            </div>
        </div>
    </div>
</section>
<section class="gallery mt-5 pt-lg-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 p-0">
                <div class="img-height">
                    <img src="<?= $banner_image_2 ?>">
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 p-0">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 p-0 text-center">
                        <img src="<?= $banner_image3 ?>">
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 p-0 text-center">
                        <img src="<?= $banner_image4 ?>">
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 p-0 text-center">
                        <img src="<?= $banner_image5 ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="story mt-5 mt-lg-5 pt-lg-3">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <i class="fa fa-square " aria-hidden="true"></i>
                <div class="border-icon-story"></div>
                <h2 class="pt-2"><?= $about_heading ?></h2>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <img src="<?= $service_image ?>">
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="ml-lg-5 mt-4 mt-lg-5">
                    <?= $client_content ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="form-contact mt-3 mt-lg-5" id="scrollform">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <?= $contact_form_content ?>
                <!-- <p>Have any question?</p> -->
                <i class="fa fa-square" aria-hidden="true"></i>
                <div class="border-icon-form"></div>
                <div class="mt-2">
                    <?= $contact_us_content ?>
                </div>
                <!-- <h2 class="mt-2">CONTACT US</h2> -->
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-2">
            </div>
            <div class="col-sm-12 col-md-8 text-center">
                <form action="#" method="post">
                    <div class="row">
                        <div id="success" class="w-100">
                        </div>
                        <div id="error" class="w-100">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="d-flex border-bottom mt-5">
                                <label for="name" class="form-label pt-3">NAME*</label>
                                <input type="name" class="form-contact-control" id="name" placeholder="Type your full name">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="d-flex mt-5 border-bottom">
                                <label for="phone" class="form-label pt-3">PHONE*</label>
                                <input type="phone" class="form-contact-control" id="phone" placeholder="(123) 456 7890">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="d-flex mt-5 border-bottom">
                                <label for="email" class="form-label pt-3">EMAIL</label>
                                <input type="email" class="form-contact-control" id="emails" placeholder="email@address.com">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="d-flex mt-5 border-bottom">
                                <label for="examplesubject" class="form-label pt-3">SUBJECT*</label>
                                <input type="phone" class="form-contact-control" id="subject" placeholder="What this is about?">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="d-flex mt-5 border-bottom">
                                <label for="message" class="form-label pt-3">MESSAGE*</label>
                                <input type="text" class="form-contact-control" id="examplemessage" placeholder="Type your message here">
                                <span class="form-iconright"><i class="fa fa-plus" aria-hidden="true"></i></span>

                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-sm-12 text-center">
                            <a href="#"><button style="padding: 0.5rem" type="submit" class="send-btn"><?= $contact_form_button_text ?></button></a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-12 col-md-2">
            </div>
        </div>
    </div>
</section>
<?php include 'includes/footer.php' ?>
<script src="send_form.js"></script>
<script>
    $(document).ready(function() {
        $('#contact').click(function(event) {
            window.location('#scrollform');
        });

        $("#register").click(function(e) {
            if ($("#checkSurfaceEnvironment-1").prop('checked') == true) {
                e.preventDefault();
                var spinner = $('#loader');
                spinner.show();
                var success_id = $("#success");
                var error_id = $("#error");
                var firstName = $("#firstname");
                var surName = $("#lastname");
                var userEmail = $("#email");
                sendForm(firstName, surName, userEmail, success_id, error_id);
            } else {
                alert("CheckBox Is not Checked")
            }




        })
        $("#contact_form_submit").click(function(e) {
            e.preventDefault();
            var spinner = $('#loader');
            spinner.show();
            var success_id = $("#success_1");
            var error_id = $("#error_1");
            var userName = $("#name");
            var userEmail = $("#emails");
            var userPhone = $("#phone");
            var message = $("#examplemessage");
            var emailSubject = $("#subject");

            // var userMessage = $("#template-contactform-message");

            $.ajax({

                url: "contact_submit.php",
                type: "POST",
                data: {
                    user_name: userName.val(),
                    email: userEmail.val(),
                    subject: emailSubject.val(),
                    message: message.val(),
                    phone: userPhone.val()
                },
                success: function(data) {

                    data = JSON.parse(data);
                    var spinner = $('#loader');
                    spinner.hide();
                    success_id.empty();
                    error_id.empty();
                    if (data.status == 1) {
                        userName.val('');
                        userEmail.val('');
                        emailSubject.val('');
                        message.val('');
                        userPhone.val('')

                        // userMessage.val('');
                        success_id.append(
                            '<div class="alert text-center alert-success alert-dismissible " role="alert" style="width:66%; margin-top:10px;margin-right:238px;margin-left:190px"><button type = "button" class = "close" data-dismiss = "alert" aria-label = "Close"><span aria-hidden = "true">×</span></button> ' +
                            data.message + '</div>')
                    } else {
                        error_id.append(
                            '<div class="alert text-center alert-danger alert-dismissible " role="alert" style="width:66%; margin-top:10px;margin-right:238px;margin-left:190px" id="contact_error"> <button type = "button" class = "close" data-dismiss = "alert" aria-label = "Close"><span aria-hidden = "true"> × <span></button>' +
                            data.message + '</div>')

                    }
                }
            })

        })
    })
</script>