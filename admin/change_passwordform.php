<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="robots" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="IEC">
    <meta property="og:title" content="IEC">
    <meta property="og:description" content="IEC">
    <meta property="og:image" content="page-error-404.html">
    <meta name="format-detection" content="telephone=no">

    <!-- PAGE TITLE HERE -->
    <title>IEC</title>

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="/admin/admin-assets/images/hims-favicon.png">
    <link href="/admin/admin-assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="/admin/admin-assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="/admin/admin-assets/vendor/toastr/css/toastr.min.css">
    <style>
        .error {
            color: red;
        }

        .toggle-password {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
    </style>
</head>

<body class="vh-100">
    <div class="page-wraper">
        <!-- Content -->
        <div class="browse-job login-style3">
            <!-- Coming Soon -->
            <div class="bg-img-fix overflow-hidden" style="background:#fff url(/admin/admin-assets/images/background/bg9.jpg); height: 100vh;">
                <div class="row gx-0">
                    <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12 vh-100 bg-white d-flex align-items-center">
                        <div class="login-form style-2">
                            <div class="card-body">
                                <div class="logo-header">
                                    <a href="#" class="logo"><img src="/admin/admin-assets/images/logoIEC.png" alt="" style="width: 56%;" class="width-100 light-logo"></a>
                                    <a href="#" class="logo"><img src="/admin/admin-assets/images/logoIEC.png" alt="" style="width: 56%;" class="width-100 dark-logo"></a>
                                </div>

                                <?php
                                // Start PHP session and error handling
                                function session_error_function()
                                {
                                    header("Location: /");
                                }

                                set_error_handler('session_error_function');
                                session_start();
                                if (!isset($_SESSION['Role'])) {
                                    header("Location: /admin/login");
                                }
                                restore_error_handler();
                                date_default_timezone_set('Asia/Kolkata');
                                header('Content-Type: text/html; charset=utf-8');
                                ?>

                                <form id="form-login" role="form" autocomplete="off" action="app/login/change-password" class="dz-form pb-3">
                                    <h3 class="form-title m-t0">Change Credentials</h3>
                                    <div class="dz-separator-outer m-b5">
                                        <div class="dz-separator bg-primary style-liner"></div>
                                    </div>
                                    <p>Enter your New Username and your Password.</p>
                                    <div class="form-group mb-3">
                                        <input type="text" name="username" style="text-transform: uppercase" placeholder="Username" class="form-control">
                                    </div>
                                    <div class="form-group mb-3 position-relative">
                                        <input type="password" class="form-control" name="old_password" id="old_password" placeholder="Old Password" required>
                                        <span class="toggle-password" onclick="togglePasswordVisibility('old_password')">
                                            <i class="fa fa-eye" id="toggleOldPasswordIcon"></i>
                                        </span>
                                    </div>
                                    <div class="form-group mb-3 position-relative">
                                        <input type="password" class="form-control" name="password" id="password" placeholder="New Password" required>
                                        <span class="toggle-password" onclick="togglePasswordVisibility('password')">
                                            <i class="fa fa-eye" id="togglePasswordIcon"></i>
                                        </span>
                                    </div>
                                    <div class="form-group mb-3 position-relative">
                                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm New Password" required>
                                        <span class="toggle-password" onclick="togglePasswordVisibility('confirm_password')">
                                            <i class="fa fa-eye" id="toggleConfirmPasswordIcon"></i>
                                        </span>
                                    </div>

                                    <div class="form-group text-left mb-5 forget-main">
                                        <div class="d-flex align-items-center mb-3">
                                            <button type="submit" class="btn btn-primary me-3">Sign Me In</button>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="check1" name="example1">
                                                <label class="form-check-label" for="check1">Remember me</label>
                                            </div>
                                        </div>
                                        <p>
                                            <a href="/admin/forgot_passwordform" class="btn btn-link p-0">Forgot Password?</a>
                                        </p>
                                    </div>

                                    <!-- <div class="form-group text-left mb-5 forget-main">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <span class="form-check d-inline-block">
                                            <input type="checkbox" class="form-check-input" id="check1" name="example1">
                                            <label class="form-check-label" for="check1">Remember me</label>
                                        </span>
                                        <span>
                                            <p><a href="/admin/forgot_passwordform">Forgot Password?</a></p>
                                        </span>
                                    </div> -->

                                </form>
                            </div>
                            <div class="card-footer">
                                <div class="bottom-footer clearfix m-t10 m-b20 row text-center">
                                    <div class="col-lg-12 text-center">
                                        <span> © Copyright IEC University. <span class="heart"></span>
                                            <a href="javascript:void(0);"> </a> All rights reserved.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Full Blog Page Contant -->
        </div>
        <!-- Content END-->
    </div>

    <!--**********************************
    Scripts
    ***********************************-->
    <!-- Required vendors -->
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
            $('#form-login').validate({
                rules: {
                    old_password: {
                        required: true
                    },
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
                    old_password: {
                        required: "Please enter your old password"
                    },
                    password: {
                        required: "Please enter your new password",
                        minlength: "Your new password must be at least 5 characters long"
                    },
                    confirm_password: {
                        required: "Please confirm your new password",
                        minlength: "Your new password must be at least 5 characters long",
                        equalTo: "Passwords do not match"
                    }
                }
            });

            $("#form-login").on("submit", function(e) {
                if ($('#form-login').valid()) {
                    $(':input[type="submit"]').prop('disabled', true);
                    var formData = new FormData(this);
                    $.ajax({
                        url: this.action,
                        type: 'post',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        success: function(data) {
                            console.log(data);
                            if (data.status == 200) {
                                toastr.success(data.message);
                                window.setTimeout(function() {
                                    window.location.href = data.url;
                                }, 1000);
                            } else {
                                $(':input[type="submit"]').prop('disabled', false);
                                toastr.error(data.message);
                            }
                        }
                    });
                    e.preventDefault();
                }
            });
        });

        function togglePasswordVisibility(fieldId) {
            var passwordField = document.getElementById(fieldId);
            var toggleIcon = document.getElementById(fieldId === "password" ? "togglePasswordIcon" : "toggleConfirmPasswordIcon");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }
    </script>
</body>

</html>