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
    <!-- endinject -->
    <link
            rel="icon"
            href="{{ asset('assets/img/rsf.ico') }}"
            type="image/x-icon"
    />

    <style>
        .form-control {
            border: 1px solid #b3b3b3;
            font-weight: 400;
            font-size: 0.875rem;
        }
        .swal-footer {
            text-align: center;
        }
        .content-wrapper {
            background-image: url('{{ asset('assets/img/undraw/undraw_blank_canvas_3rbb.svg') }}');
            background-size: 60rem 50rem;
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
                margin-left: 57.77777%;
            }
        }

    </style>

</head>

<body>
<div class="container-scroller d-flex">
    <div class="container-fluid page-body-wrapper full-page-wrapper d-flex">
        <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
                <div class="col-lg-5 offset-lg-7">
                    <div class="auth-form-light text-left py-5 px-4 px-sm-5 shadow-lg">
                        {{--<div class="brand-logo">--}}
                        {{--<img src="../../images/logo.svg" alt="logo">--}}
                        {{--</div>--}}
                        <h4>Forgot Password?</h4>
                        <form enctype="multipart/form-data" class="pt-3">
                            <div class="form-group">
                                <div class="input-group input-group-lg">
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" aria-label="Email">
                                    <button type="button" id="send-code-btn" class="btn btn-outline-primary send-code">Send Code</button>
                                </div>
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

        $('#send-code-btn').click(function(e) {
            var $sendCode = $('.send-code');
            $sendCode.prop('disabled', true);
            $sendCode.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

            e.preventDefault();

            var email = $('#email').val();

            $.ajax({
                url: "{{ route('verify-submit') }}",
                type: 'POST',
                data: {
                    email: email,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
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

                error: function(xhr) {
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
                    $sendCode.prop('disabled', false);
                    $sendCode.html('Send Code');
//                    $sendCode.css('background-color', '#ffff');
                }

            });
        });

    });
</script>

</body>

</html>
