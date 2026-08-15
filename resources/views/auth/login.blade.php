<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>RS8 x SRF Warranty | Sign In</title>
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
                <img src="{{ asset('assets/img/rs8-brand.png') }}" alt="RS8 Taiwan Speed Factory" class="rs8-logo">
                <span class="brand-divider"></span>
                <img src="{{ asset('assets/img/srf-brand.png') }}" alt="SRF" class="srf-logo">
            </div>
            <small>Unified Warranty Management System</small>
        </div>

        <div class="rs-auth-message rs-auth-message-minimal">
            <div class="rs-auth-kicker">Warranty Operations</div>
            <h1>Control the workflow.<br>Keep it moving.</h1>
            <p>One command interface for RS8 × SRF warranty operations, customer support, and product administration.</p>
        </div>

        <div class="rs-auth-footnote">RS8 x SRF • Internal Operations Portal</div>
    </section>

    <main class="rs-auth-panel">
        <div class="rs-auth-card">
            <div class="mobile-brand">
                <img src="{{ asset('assets/img/rs8-brand.png') }}" alt="RS8">
                <img src="{{ asset('assets/img/srf-brand.png') }}" alt="SRF">
            </div>
            <div class="auth-kicker">Secure Access</div>
            <h2>Welcome back.</h2>
            <p class="auth-copy">Sign in to continue to the RS8 x SRF warranty control center.</p>

            <form id="login-form">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control form-control-lg" placeholder="Enter your username" autocomplete="username">
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="password-field">
                        <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Enter your password" autocomplete="current-password">
                        <button type="button" class="password-toggle" aria-label="Show password" aria-pressed="false" title="Show password">
                            <i class="fas fa-eye" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" id="login-btn" class="btn btn-primary btn-lg auth-form-btn">Sign In</button>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('forgot-password') }}" class="auth-link">Forgot password?</a>
                </div>
            </form>

            <div class="rs-auth-meta">
                <span>Authorized personnel only</span>
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
        $('#login-form').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const $btn = $('.auth-form-btn');

            $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Signing In...');

            $.ajax({
                url: '{{ route("login") }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    if (response.success) window.location.href = response.redirect_url;
                },
                error: function(xhr) {
                    swal('Login Failed', xhr.responseJSON?.message || 'Please check your username and password.', 'error');
                },
                complete: function() {
                    $btn.prop('disabled', false).html('Sign In');
                }
            });
        });
    });
</script>
</body>
</html>
