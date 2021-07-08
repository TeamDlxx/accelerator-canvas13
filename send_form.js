function sendForm(firstName, surName, userEmail, success_id, error_id) {
    $.ajax({
        url: "form_submit.php",
        type: "POST",
        data: {
            first_name: firstName.val(),
            sur_name: surName.val(),
            email: userEmail.val(),

        },
        success: function (data) {
            data = JSON.parse(data);
            var spinner = $('#loader');
            spinner.hide();
            success_id.empty();
            error_id.empty();
            if (data.status == 1) {
                firstName.val('');
                surName.val('');
                userEmail.val('');


                success_id.append('<div class="alert text-center alert-success alert-dismissible " role="alert" style="width:100%; margin-top:10px;"><button type = "button" class = "close" data-dismiss = "alert" aria-label = "Close"><span aria-hidden = "true">×</span></button>  ' + data.message + '</div>')
            } else {
                error_id.append('<div class="alert text-center alert-danger alert-dismissible " role="alert" style="width:100%; margin-top:10px;" id="contact_error"> <button type = "button" class = "close" data-dismiss = "alert" aria-label = "Close"><span aria-hidden = "true"> × <span></button>' + data.message + '</div>')

            }
        }
    })
}