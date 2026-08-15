<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>RS8 x SRF Warranty | Update Password</title>
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
            <div class="rs-auth-kicker">Secure Reset</div>
            <h1>Reset credentials.<br><span>Restore access.</span></h1>
            <p>Enter the verification code sent to your email, then create a new password for your warranty management account.</p>
        </div>

        <div class="rs-auth-footnote">RS8 x SRF • Internal Operations Portal</div>
    </section>

    <main class="rs-auth-panel">
        <div class="rs-auth-card">
            <div class="mobile-brand">
                <img src="{{ asset('assets/img/rs8-brand.png') }}" alt="RS8">
                <img src="{{ asset('assets/img/srf-brand.png') }}" alt="SRF">
            </div>
            <div class="auth-kicker">Password Reset</div>
            <h2>Set a new password.</h2>
            <p class="auth-copy">Use your verification code and choose a strong new password.</p>

            <form id="verify-change-form" method="post" action="{{ route('change-password.submit') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="verification_code" class="form-label">Verification Code</label>
                    <input type="text" name="verification_code" id="verification_code" class="form-control" placeholder="Enter verification code" autocomplete="one-time-code">
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">New Password</label>
                    <div class="password-field">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter new password" autocomplete="new-password" />
                        <button type="button" class="password-toggle" aria-label="Show password" aria-pressed="false" title="Show password">
                            <i class="fas fa-eye" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <div class="password-field">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm new password" autocomplete="new-password" />
                        <button type="button" class="password-toggle" aria-label="Show password" aria-pressed="false" title="Show password">
                            <i class="fas fa-eye" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" id="forgotpass-change-btn" class="btn btn-primary auth-form-btn">Update Password</button>
            </form>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <a href="{{ route('forgot-password') }}" class="auth-link"><i class="fas fa-redo-alt me-1"></i> Request another code</a>
            </div>

            <div class="rs-auth-meta">
                <span>Protected reset flow</span>
                <span>RS8 × SRF</span>
            </div>
        </div>
    </main>
</div>

<script src="{{ asset('assets/login/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/password-toggle.js') }}"></script>
<script>
    $(function () {

        $('#verify-change-form').on('submit', function(e) {
            e.preventDefault();
            var $btn = $('#forgotpass-change-btn');
            $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Updating...');

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status === false) {
                        swal('Unable to update password', response.message, 'error');
                    } else {
                        swal('Password updated', response.message, 'success').then(() => {
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
                    swal('Unable to update password', errorMessage, 'error');
                },
                complete: function() {
                    $btn.prop('disabled', false).html('Update Password');
                }
            });
        });
    });
</script>
</body>
</html>
