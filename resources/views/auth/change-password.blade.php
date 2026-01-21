<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>RSF</title>
    <!-- base:css -->
    <link rel="stylesheet" href="{{ asset('assets/login/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/login/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('assets/login/style.css') }}">
    <link
            rel="icon"
            href="{{ asset('assets/img/rs8xsrf.ico') }}"
            type="image/x-icon"
    />

    <!-- CSS Files -->
    <!-- endinject -->
    <!-- Fonts and icons -->
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: { families: ["Public Sans:300,400,500,600,700"] },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{ asset('assets/css/fonts.min.css') }}"],
            },
            active: function () {
                sessionStorage.fonts = true;
            },
        });
    </script>


    <style>
        .form-control {
            border: 1px solid #b3b3b3;
            font-weight: 400;
            font-size: 0.875rem;
        }
        .swal-footer {
            text-align: center;
        }
        .input-icon {
            position: relative;
        }

        .input-icon input {
            padding-right: 35px;
        }

        .input-icon-addon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
        }
        .content-wrapper {
            background-image: url('{{ asset('assets/img/undraw/undraw_sign_in_e6hj.svg') }}');
            background-size: 70rem 44rem;
            /*background-size: contain;*/

            /*background-position: center;*/
            background-repeat: no-repeat;
            height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.937rem 1.437rem;
            width: 100%;
            -webkit-flex-grow: 1;
            flex-grow: 1;

        }
        @media (min-width: 992px) {
            .offset-lg-7 {
                margin-left: 64.33333%;
            }
        }

    </style>

</head>

<body>
<div class="container-scroller d-flex">
    <div class="container-fluid page-body-wrapper full-page-wrapper d-flex">
        <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
                <div class="col-lg-4 offset-lg-7">
                    <div class="auth-form-light text-left py-5 px-4 px-sm-5 shadow-lg">
                        {{--<div class="brand-logo">--}}
                        {{--<img src="../../images/logo.svg" alt="logo">--}}
                        {{--</div>--}}
                        <h4>Update Password</h4>
                        <form id="verify-change-form" method="post" action="{{ route('change-password-submit') }}" enctype="multipart/form-data" class="pt-3">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="verification_code" id="verification_code" class="form-control" placeholder="Enter Verification Code">
                                <a href="{{ route('forgot-password') }}" class="auth-link text-black mt-2" style="display: block; text-align: right;">Didn't receive the code?</a>

                            </div>
                            <div class="form-group">
                                <div class="input-icon">
                                    <input
                                            type="password"
                                            class="form-control"
                                            name="password"
                                            id="password"
                                            placeholder="Enter New Password"
                                    />
                                    <span class="input-icon-addon" onclick="password_toggler('password')">
                              <i id="password_eye" class="fas fa-eye"></i>
                            </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon">
                                    <input
                                            type="password"
                                            id="password_confirmation"
                                            name="password_confirmation"
                                            class="form-control"
                                            placeholder="Confirm New Password"
                                    />
                                    <span class="input-icon-addon" onclick="password_toggler('password_confirmation')">
                              <i id="password_confirmation_eye" class="fas fa-eye"></i>
                            </span>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="submit" id="forgotpass-change-btn" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- base:js -->
<script src="{{ asset('assets/login/vendor.bundle.base.js') }}"></script>
<!-- endinject -->
<!-- inject:js -->
<script src="{{ asset('assets/login/off-canvas.js') }}"></script>
<script src="{{ asset('assets/login/hoverable-collapse.js') }}"></script>
<script src="{{ asset('assets/login/template.js') }}"></script>
<!-- Sweet Alert -->
<script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
<!-- endinject -->

<script>
    $(function () {

    $('#verify-change-form').submit(function(e) {
        e.preventDefault(); // Prevent form submission

        var $btn = $('#forgotpass-change-btn');
        $btn.prop('disabled', true);
        $btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...');

        var formdata = $(this).serialize();
        let url = $(this).attr('action');

        $.ajax({
            url: url,
            type: 'POST',
            data: formdata,
            success: function (response) {

                if (response.validation == true) {
                    let errors = response.errors;

                    if (typeof errors === 'object') {
                        errors = Object.values(errors)[0];
                        if (Array.isArray(errors)) {
                            errors = errors[0];
                        }
                    }

                    errors = errors || "An error occurred"; // fallback string if empty

                    swal("Failed!", errors, {
                        icon: "error",
                        buttons: {
                            confirm: {
                                className: "btn btn-danger",
                            },
                        },
                        closeOnClickOutside: false,
                    });
                } else {
                    swal({
                        title: "Success!",
                        text: response.message,
                        icon: "success",
                        buttons: {
                            confirm: {
                                text: "OK",
                                className: "btn btn-success"  // your custom CSS class
                            }
                        },
                        closeOnClickOutside: false,
                    }).then(() => {
                        window.location.href = response.redirect;
                });
                }
            },
            error: function (xhr) {
                let errors = xhr.responseJSON.errors;

                if (typeof errors === 'object') {
                    // If it's an object, try to get a string safely
                    errors = Object.values(errors)[0];
                    if (Array.isArray(errors)) {
                        errors = errors[0];
                    }
                }

                errors = errors || "An error occurred"; // fallback string if empty

                swal("Failed!", errors, {
                    icon: "error",
                    buttons: {
                        confirm: {
                            className: "btn btn-danger",
                        },
                    },
                });

            },
            complete: function() {
                $btn.prop('disabled', false);
                $btn.html('Update Password');
            }
        });
    });
    });

    function password_toggler(selector){
        $('#'+selector+'_eye').toggleClass('fa-eye fa-eye-slash')
        $('#'+selector).attr('type', function(index, attr){
            return attr == 'text' ? 'password' : 'text';
        });
    }

</script>
</body>

</html>
