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
            background-image: url('{{ asset('assets/img/undraw/undraw_Hello_qnas.svg') }}');
            background-size: 50rem 50rem;
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
                        <h4>Sign In</h4>
                        <form id="login-form" class="pt-3">
                            @csrf
                            <div class="form-group">
                                <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" id="password" class="form-control form-control-lg"  placeholder="Password">
                            </div>
                            <div class="mt-3">
                                <button type="submit" id="login-btn" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                            </div>
                            <div class="my-2 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    {{--<label class="form-check-label text-muted">--}}
                                        {{--<input type="checkbox" class="form-check-input">--}}
                                        {{--Keep me signed in--}}
                                    {{--</label>--}}
                                </div>
                                <a href="{{ route('forgot-password') }}" class="auth-link text-black text-center">Forgot password?</a>
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
        $('#login-form').on('submit', function(e) {
            e.preventDefault();

            var $btn = $('.auth-form-btn');
            $btn.prop('disabled', true);
            $btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Signing In...');

            $.ajax({
                url: '{{ route("login") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    email: $('#email').val(),
                    password: $('#password').val()
                },
                success: function(response) {
                    if (response.success) {
                        swal({
                            title: "Great Job!",
                            text: response.message,
                            icon: "success",
                            timer: 1500,
                            button: false
                        });

                        setTimeout(function() {
                            window.location.href = response.redirect_url;
                        }, 1500);
                    }
                },

                error: function(xhr) {
//                    swal("Login Failed", xhr.responseJSON.message, "error");
                        swal("Login Failed!", xhr.responseJSON.message, {
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
                    $btn.html('SIGN IN');
                }
            });
        });
    });




</script>

</body>

</html>
