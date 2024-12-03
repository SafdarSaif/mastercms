<?php
require '../admin/includes/db-config.php';
session_start();


if (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($conn, $_GET['token']);


    $result = $conn->query("SELECT ID FROM users WHERE reset_token = '$token' AND reset_requested_at > NOW() - INTERVAL 1 HOUR");

    if ($result->num_rows > 0) {

?>
        <!DOCTYPE html>
        <html lang="en" class="h-100">

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Reset Password</title>
            <link rel="shortcut icon" type="image/png" href="/admin/admin-assets/images/hims-favicon.png">
            <link href="/admin/admin-assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
            <link href="/admin/admin-assets/css/style.css" rel="stylesheet">
            <link rel="stylesheet" href="/admin/admin-assets/vendor/toastr/css/toastr.min.css">
        </head>

        <body class="vh-100">
            <div class="page-wraper">
                <div class="browse-job login-style3">
                    <div class="bg-img-fix overflow-hidden" style="background:#fff url(/admin/admin-assets/images/background/bg9.jpg); height: 100vh;">
                        <div class="row gx-0">
                            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12 vh-100 bg-white d-flex align-items-center">
                                <div class="login-form style-2">
                                    <div class="card-body">
                                        <div class="logo-header">
                                            <a href="#" class="logo"><img src="/admin/admin-assets/images/logoIEC.png" alt="" style="width: 56%;" class="width-100 light-logo"></a>
                                            <a href="#" class="logo"><img src="/admin/admin-assets/images/logoIEC.png" alt="" style="width: 56%;" class="width-100 dark-logo"></a>
                                        </div>
                                        <form id="form-reset-password" action="app/login/reset-password" method="post">
                                            <h3 class="form-title m-t0">Reset Password</h3>
                                            <p>Enter your new password.</p>
                                            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                                            <div class="form-group mb-3">
                                                <input type="password" name="password" id="password" placeholder="New Password" class="form-control" required>
                                            </div>
                                            <div class="form-group mb-3">
                                                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm New Password" class="form-control" required>
                                            </div>
                                            <div class="form-group text-left mb-5 forget-main">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer">
                                        <div class="bottom-footer clearfix m-t10 m-b20 row text-center">
                                            <div class="col-lg-12 text-center">
                                                <span>© Copyright IEC University. <span class="heart"></span>
                                                    <a href="javascript:void(0);"></a> All rights reserved.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="/admin/admin-assets/vendor/global/global.min.js"></script>
            <script src="/admin/admin-assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
            <script src="/admin/admin-assets/js/deznav-init.js"></script>
            <script src="/admin/admin-assets/js/custom.js"></script>
            <script src="/admin/admin-assets/js/demo.js"></script>
            <script src="/admin/admin-assets/js/styleSwitcher.js"></script>
            <script src="/admin/admin-assets/vendor/toastr/js/toastr.min.js"></script>
            <script src="/admin/admin-assets/js/plugins-init/toastr-init.js"></script>
            <script src="/admin/admin-assets/vendor/jquery-validation/jquery.validate.min.js" type="text/javascript"></script>
            <script>
                $(function() {
                    $('#form-reset-password').validate({
                        rules: {
                            password: {
                                required: true,
                                minlength: 5
                            },
                            confirm_password: {
                                required: true,
                                minlength: 5,
                                equalTo: "#password"
                            }
                        },
                        messages: {
                            password: {
                                required: "Please enter your new password",
                                minlength: "Your new password must be at least 5 characters long"
                            },
                            confirm_password: {
                                required: "Please confirm your new password",
                                minlength: "Your new password must be at least 5 characters long",
                                equalTo: "Passwords do not match"
                            }
                        },
                        submitHandler: function(form) {
                            var formData = $(form).serialize();
                            $(':input[type="submit"]').prop('disabled', true);
                            $.ajax({
                                url: form.action,
                                type: 'post',
                                data: formData,
                                dataType: "json",
                                success: function(data) {
                                    if (data.status == 200) {
                                        toastr.success(data.message);
                                        window.setTimeout(function() {
                                            window.location.href = data.url;
                                        }, 1000);
                                    } else {
                                        $(':input[type="submit"]').prop('disabled', false);
                                        toastr.error(data.message);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    $(':input[type="submit"]').prop('disabled', false);
                                    toastr.error('An error occurred while processing your request. Please try again later.');
                                }
                            });
                            return false;
                        }
                    });
                });
            </script>
        </body>

        </html>
<?php
    } else {
        echo "Invalid or expired token.";
    }
} else {
    echo "Token not provided.";
}
?>