<div class="footer-wrapper">
    <div class="footer-section f-section-1">
        <p style="margin-top: 30px;"><?php echo $footer_content; ?></p>
    </div>
    <div class="footer-section f-section-2">
        <div id="logo">
            <a href="index.php" class="standard-logo" data-dark-logo="<?= $base_url . $admin_logo ?>"><img src="<?= $base_url . $admin_logo; ?>" alt="Canvas Logo"></a>
        </div>
    </div>
</div>
</div>
<!--  END CONTENT PART  -->

</div>
<!-- END MAIN CONTAINER -->

<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="../../assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="../../bootstrap/js/popper.min.js"></script>
<script src="../../bootstrap/js/bootstrap.min.js"></script>
<script src="../../plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="../../assets/js/app.js"></script>
<script>
    $(document).ready(function() {
        App.init();
    });
    $(document).ready(function() {
        $("#ticket-form").submit(function(e) {
            $('.reply').prop('disabled', 'true');
            e.preventDefault();
            var formData = new FormData(this);
            var message = $('#message').val();
            var ticket_id = $('#ticket_id').val();
            var status = $('#status').val();
            var image = $('#image').val();
            // alert(image)

            $.ajax({

                url: "add_message.php",
                type: 'POST',
                data: formData,
                crossDomain: true,
                success: function(data) {
                    document.getElementById("reply").disabled = false;
                    data = JSON.parse(data);
                    if (data.status == 0) {
                        $('#message-result').css('color', 'red');
                        $('#message-result').html(data.message);

                    } else {
                        $('#message-result').html('');
                        $('#message').val('');
                        var messages = data.message;
                        $('#messages-list').html(messages);
                        document.getElementById("ticket-form").reset();


                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    });
</script>
<script src="../../assets/js/custom.js"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->
<script src="../../assets/js/ie11fix/fn.fix-padStart.js"></script>
<script src="../../plugins/editors/quill/quill.js"></script>
<script src="../../assets/js/apps/todoList.js"></script>
<!-- Start Invoice SCRIPTS -->
<script src="../../assets/js/apps/invoice.js"></script>
<!-- <script src="../../assets/js/apps/mailbox-chat.js"></script> -->
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<script src="../../plugins/apex/apexcharts.min.js"></script>
<script src="../../assets/js/dashboard/dash_2.js"></script>
<script src="../../assets/js/dashboard/dash_1.js"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->
<script src="../../assets/js/apps/mailbox-chat.js"></script>
<!-- script for the card -->
<script src="../../plugins/highlight/highlight.pack.js"></script>
<script src="../../assets/js/scrollspyNav.js"></script>
<!-- scripts for the tickets -->
<script src="../../plugins/sweetalerts/sweetalert2.min.js"></script>
<script src="../../plugins/notification/snackbar/snackbar.min.js"></script>
<script src="../../assets/js/apps/custom-mailbox.js"></script>
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<?php if (isset($datatable) && $datatable === true) { ?>
    <!-- BEGIN PAGE LEVEL CUSTOM SCRIPTS -->
    <script src="../../plugins/table/datatable/datatables.js"></script>
    <!-- NOTE TO Use Copy CSV Excel PDF Print Options You Must Include These Files  -->
    <script src="../../bootstrap/js/dataTables.responsive.min.js"></script>
    <script src="../../bootstrap/js/responsive.bootstrap.js"></script>
    <script src="../../plugins/table/datatable/button-ext/dataTables.buttons.min.js"></script>
    <script src="../../plugins/table/datatable/button-ext/jszip.min.js"></script>
    <script src="../../plugins/table/datatable/button-ext/buttons.html5.min.js"></script>
    <script src="../../plugins/table/datatable/button-ext/buttons.print.min.js"></script>
    <script>
        $('#html5-extension').DataTable({
            dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
            buttons: {
                buttons: [{
                        extend: 'copy',
                        className: 'btn'
                    },
                    {
                        extend: 'csv',
                        className: 'btn'
                    },
                    {
                        extend: 'excel',
                        className: 'btn'
                    },
                    {
                        extend: 'print',
                        className: 'btn'
                    }
                ]
            },
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [5, 10, 20, 50, 100],
            "pageLength": 50
        });
    </script>
    <!-- END PAGE LEVEL CUSTOM SCRIPTS -->
<?php } ?>

</body>

</html>