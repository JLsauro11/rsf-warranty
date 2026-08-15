<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>RS8 x SRF Warranty | Recover Access</title>
    <link rel="icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/login/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/login/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/login/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fonts.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/rs8-srf-theme.css') }}">
</head>
<body class="rs-auth-page" data-brand="fusion">
<div class="rs-auth-shell">
    <section class="rs-auth-visual">
        <div class="rs-auth-brand">
            <div class="brand-combo">
                <img src="{{ asset('assets/img/rs8-brand.png') }}" alt="RS8" class="rs8-logo">
                <span class="brand-divider"></span>
                <img src="{{ asset('assets/img/srf-brand.png') }}" alt="SRF" class="srf-logo">
            </div>
            <small>Unified Warranty Management System</small>
        </div>

        <div class="rs-auth-message">
            <div class="rs-auth-kicker">Access Recovery</div>
            <h1>RESTORE ACCESS.<br><span>REJOIN OPERATIONS.</span></h1>
            <p>Request a verification code using the email address connected to your RS8 x SRF warranty account.</p>
        </div>

        <div class="rs-auth-footnote">RS8 x SRF • Internal Operations Portal</div>
    </section>

    <main class="rs-auth-panel">
        <div class="rs-auth-card">
            <div class="mobile-brand">
                <img src="{{ asset('assets/img/rs8-brand.png') }}" alt="RS8">
                <img src="{{ asset('assets/img/srf-brand.png') }}" alt="SRF">
            </div>
            <div class="auth-kicker">Account Recovery</div>
            <h2>Forgot your password?</h2>
            <p class="auth-copy">Enter your registered email and we’ll send the verification code needed to reset your password.</p>

            <form enctype="multipart/form-data">
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="name@company.com" aria-label="Email" autocomplete="email">
                </div>
                <button type="button" id="send-code-btn" class="btn btn-primary rs-auth-submit send-code">Send Verification Code</button>
            </form>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <a href="{{ route('login') }}" class="auth-link"><i class="fas fa-arrow-left me-1"></i> Back to sign in</a>
            </div>

            <div class="rs-auth-meta">
                <span>Secure account recovery</span>
                <span>RS8 × SRF</span>
            </div>
        </div>
    </main>
</div>

<script src="{{ asset('assets/login/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
<script>
    $(function () {
        $('#send-code-btn').on('click', function(e) {
            e.preventDefault();
            var $sendCode = $('.send-code');
            $sendCode.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Sending...');

            $.ajax({
                url: "{{ route('forgot-password') }}",
                type: 'POST',
                data: { email: $('#email').val(), _token: "{{ csrf_token() }}" },
                success: function(response) {
                    if (response.status === false) {
                        swal('Unable to send code', response.message, 'error');
                    } else {
                        swal('Verification code sent', response.message, 'success').then(() => {
                            window.location.href = response.redirect;
                        });
                    }
                },
                error: function(xhr) {
                    let errorMessage = xhr.responseJSON?.message || 'An error occurred.';
                    if (xhr.responseJSON?.errors) {
                        let errors = Object.values(xhr.responseJSON.errors)[0];
                        errorMessage = Array.isArray(errors) ? errors[0] : errors;
                    }
                    swal('Unable to send code', errorMessage, 'error');
                },
                complete: function() {
                    $sendCode.prop('disabled', false).html('Send Verification Code');
                }
            });
        });
    });
</script>
</body>
</html>
