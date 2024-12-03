<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="robots" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Knowledge ">
    <meta property="og:title" content="Knowledge ">
    <meta property="og:description" content="Knowledge ">
    <meta property="og:image" content="page-error-404.html">
    <meta name="format-detection" content="telephone=no">

    <!-- PAGE TITLE HERE -->
    <title>Forgot Password</title>

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="/admin/admin-assets/images/hims-favicon.png">
    <link href="/admin/admin-assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="/admin/admin-assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="/admin/admin-assets/vendor/toastr/css/toastr.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .spinner-border {
            width: 3rem;
            height: 3rem;
        }

        #loadingMessage {
            display: none;
            text-align: center;
            margin-top: 20px;
        }

        #loadingMessage p {
            margin-top: 10px;
        }
    </style>
</head>

<body class="vh-100">
    <div class="page-wraper">
        <div class="browse-job login-style3">
            <div class="bg-img-fix overflow-hidden" style="background:#fff url(/admin/admin-assets/images/background/bg9.jpg); height: 100vh;">
                <div class="row gx-0">
                    <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12 vh-100 bg-white d-flex  align-items-center">
                        <div class="login-form style-2">
                            <div class="card-body">
                                <div class="logo-header">
                                    <!-- <a href="#" class="logo"><img src="/admin/admin-assets/images/logoIEC.png" alt="" style="width: 56%;" class="width-100 light-logo"></a> -->
                                    <!-- <a href="#" class="logo"><img src="/admin/admin-assets/images/logoIEC.png" alt="" style="width: 56%;" class="width-100 dark-logo"></a> -->
                                </div>
                                <form id="form-forgot-password" action="app/login/forgot-password" method="post">
                                    <h3 class="form-title m-t0">Forgot Password</h3>
                                    <p>Enter your email address to reset your password.</p>
                                    <div class="form-group mb-3">
                                        <input type="email" name="email" placeholder="Email" class="form-control" required>
                                    </div>
                                    <div class="form-group text-left mb-5 forget-main">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                    <div id="loadingMessage">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <p>Sending email, please wait...</p>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <div class="bottom-footer clearfix m-t10 m-b20 row text-center">
                                    <div class="col-lg-12 text-center">
                                        <span>© Copyright Knowledge Nest.<span class="heart"></span>
                                            <a href="javascript:void(0);"> </a> All rights reserved.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Password Reset Email Sent</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>A password reset email has been sent to your email address. Please check your inbox and follow the instructions to reset your password.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="modalCloseButton">Password Reset</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="/admin/admin-assets/vendor/global/global.min.js"></script>
    <script src="/admin/admin-assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="/admin/admin-assets/js/deznav-init.js"></script>
    <script src="/admin/admin-assets/js/custom.js"></script>
    <script src="/admin/admin-assets/js/demo.js"></script>
    <script src="/admin/admin-assets/js/styleSwitcher.js"></script>
    <script src="/admin/admin-assets/vendor/toastr/js/toastr.min.js"></script>
    <script src="/admin/admin-assets/js/plugins-init/toastr-init.js"></script>

    <script>
        $(document).ready(function() {
            $("#form-forgot-password").on("submit", function(e) {
                e.preventDefault();

                $("#loadingMessage").show();

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
                        $("#loadingMessage").hide();
                        console.log(data);
                        if (data.status == 200) {
                            toastr.success(data.message);
                            $('#successModal').modal('show');
                            $('#form-forgot-password')[0].reset();
                            $('#successModal').on('hidden.bs.modal', function() {
                                window.location.href = data.url;
                            });
                        } else {
                            toastr.error(data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        $("#loadingMessage").hide();
                        toastr.error('An error occurred while processing your request. Please try again later.');
                    }
                });
            });


            $('#modalCloseButton').on('click', function() {
                $('#successModal').modal('hide');
            });
        });
    </script>
</body>

</html>