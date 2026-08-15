@php
    $headerUser = auth()->user();
    $headerRole = $headerUser->role;
    $headerUsername = $headerUser->username ?: 'Account';
    $headerEmail = $headerUser->email ?: '';
    $headerRoleLabel = match ($headerRole) {
        'admin' => 'Administrator',
        'csr_rs8' => 'RS8 Customer Service',
        'csr_srf' => 'SRF Customer Service',
        default => 'User',
    };
@endphp

<div class="main-header">
    <div class="main-header-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route($headerRole === 'admin' ? 'admin.index' : ($headerRole === 'csr_rs8' ? 'csr_rs8.index' : 'csr_srf.index')) }}" class="logo">
                <img src="{{ asset('assets/img/rs8xsrf.png') }}" alt="RS8 x SRF" class="navbar-brand" />
            </a>
            <div class="nav-toggle sidebar-toggle-mobile">
                <button type="button" class="btn btn-toggle universal-sidebar-toggler" aria-label="Toggle sidebar" aria-expanded="false">
                    <i class="gg-menu-right"></i>
                </button>
            </div>
            <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
        </div>
    </div>

    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg">
        <div class="container-fluid">
            <div class="main-header-title">
                <div class="title-mark"><i class="fas fa-shield-alt"></i></div>
                <div class="title-copy">
                    <span class="eyebrow">Operations System</span>
                    <span class="title">Warranty Management</span>
                </div>
            </div>


            <ul class="navbar-nav topbar-nav ms-auto align-items-center">
                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                        <div class="avatar-sm">
                            <img src="{{ asset('assets/img/profile-picture.png') }}" alt="Profile" class="avatar-img rounded-circle" />
                        </div>
                        <span class="profile-username">
                            <span class="op-7">{{ $headerRoleLabel }}</span><br>
                            <span class="fw-bold" id="userDisplay">{{ $headerUsername }}</span>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <li>
                            <div class="user-box">
                                <div class="avatar-lg">
                                    <img src="{{ asset('assets/img/profile-picture.png') }}" alt="Profile" class="avatar-img rounded" />
                                </div>
                                <div class="u-text">
                                    <h4 id="headerUsername">{{ $headerUsername }}</h4>
                                    <p class="text-muted mb-0" id="headerEmail">{{ $headerEmail }}</p>
                                    <small class="text-muted">{{ $headerRoleLabel }}</small>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#accountSettingModal">
                                <i class="fas fa-sliders-h me-2"></i> Account Settings
                            </a>
                            <button class="dropdown-item" id="logout-btn">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>

<div class="modal fade" id="accountSettingModal" tabindex="-1" aria-labelledby="accountSettingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered app-modal-dialog app-modal-dialog--wide">
        <div class="modal-content">
            <form id="accountForm" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title mb-1" id="accountSettingModalLabel">Account Settings</h5>
                        <small class="text-muted">Update your sign-in information and password.</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="acctsetting_toggleUsernameSettings" class="toggle-header active" aria-expanded="true" aria-controls="acctsetting_usernameSettingsContainer" role="button">
                        <span><i class="fas fa-user-circle me-2"></i> Profile Information</span>
                        <i class="fas fa-chevron-down" id="acctsetting_usernameSettingsArrow"></i>
                    </div>

                    <div id="acctsetting_usernameSettingsContainer">
                        <div class="mb-3">
                            <label for="acctsetting_userName" class="form-label">Username</label>
                            <input type="text" class="form-control" id="acctsetting_userName" name="username" placeholder="Enter your username" />
                        </div>
                        <div class="mb-3">
                            <label for="acctsetting_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="acctsetting_email" name="email" placeholder="Enter your email" />
                        </div>
                    </div>

                    <div id="acctsetting_togglePasswordSettings" class="toggle-header" aria-expanded="false" aria-controls="acctsetting_passwordSettingsContainer" role="button">
                        <span><i class="fas fa-lock me-2"></i> Password</span>
                        <i class="fas fa-chevron-down" id="acctsetting_passwordSettingsArrow"></i>
                    </div>

                    <div id="acctsetting_passwordSettingsContainer" style="display:none;">
                        <div class="form-group mb-3">
                            <label for="acctsetting_current_password" class="form-label">Current Password</label>
                            <div class="password-field">
                                <input type="password" class="form-control" name="current_password" id="acctsetting_current_password" placeholder="Enter current password" autocomplete="current-password" />
                                <button type="button" class="password-toggle" aria-label="Show password" aria-pressed="false" title="Show password">
                                    <i class="fas fa-eye" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="acctsetting_new_password" class="form-label">New Password</label>
                            <div class="password-field">
                                <input type="password" id="acctsetting_new_password" name="new_password" class="form-control" placeholder="Enter new password" autocomplete="new-password" />
                                <button type="button" class="password-toggle" aria-label="Show password" aria-pressed="false" title="Show password">
                                    <i class="fas fa-eye" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <label for="acctsetting_password_confirmation" class="form-label">Confirm Password</label>
                            <div class="password-field">
                                <input type="password" id="acctsetting_password_confirmation" name="new_password_confirmation" class="form-control" placeholder="Confirm new password" autocomplete="new-password" />
                                <button type="button" class="password-toggle" aria-label="Show password" aria-pressed="false" title="Show password">
                                    <i class="fas fa-eye" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary account-form-btn">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
<script>
    $(function () {
        const $usernameContainer = $('#acctsetting_usernameSettingsContainer');
        const $usernameToggle = $('#acctsetting_toggleUsernameSettings');
        const $passwordContainer = $('#acctsetting_passwordSettingsContainer');
        const $passwordToggle = $('#acctsetting_togglePasswordSettings');

        function setToggle($toggle, $container, open) {
            $toggle.attr('aria-expanded', open ? 'true' : 'false').toggleClass('active', open);
            open ? $container.stop(true, true).slideDown(180) : $container.stop(true, true).slideUp(180);
        }

        $usernameToggle.on('click', function () {
            setToggle($usernameToggle, $usernameContainer, $usernameToggle.attr('aria-expanded') !== 'true');
        });

        $passwordToggle.on('click', function () {
            setToggle($passwordToggle, $passwordContainer, $passwordToggle.attr('aria-expanded') !== 'true');
        });

        $('#accountSettingModal').on('show.bs.modal', function () {
            setToggle($usernameToggle, $usernameContainer, true);
            $passwordContainer.hide();
            $passwordToggle.attr('aria-expanded', 'false').removeClass('active');
            $passwordContainer.find('input').filter('[name*="password"]').attr('type', 'password').val('').trigger('input');
        });

        $('#accountSettingModal').on('hidden.bs.modal', function () {
            $passwordContainer.hide();
            $passwordToggle.attr('aria-expanded', 'false').removeClass('active');
            $passwordContainer.find('input').filter('[name*="password"]').attr('type', 'password').val('').trigger('input');
        });
    });

    $('#logout-btn').on('click', function() {
        $.ajax({
            url: '{{ route("logout") }}',
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                if (response.success) window.location.href = response.redirect_url;
            }
        });
    });

    var userRole = @json(auth()->user()->role);
    var routes = {
        admin: {
            update: '{{ route("admin.account.update") }}',
            display: '{{ route("admin.accountDisplay") }}'
        },
        csr_rs8: {
            update: '{{ route("csr_rs8.account.update") }}',
            display: '{{ route("csr_rs8.accountDisplay") }}'
        },
        csr_srf: {
            update: '{{ route("csr_srf.account.update") }}',
            display: '{{ route("csr_srf.accountDisplay") }}'
        }
    };

    var accountDisplayRoute = routes[userRole]?.display || '{{ route("login") }}';
    var accountUpdateRoute = routes[userRole]?.update || '{{ route("login") }}';

    function renderAccount(data) {
        if (!data || !data.user) return;
        $('#userDisplay').text(data.user.username || 'Account');
        $('#headerUsername').text(data.user.username || 'Account');
        $('#headerEmail').text(data.user.email || '');
    }

    $(function() {
        $('#accountForm').on('submit', function(e) {
            e.preventDefault();
            var $form = $(this);
            var $btn = $form.find('.account-form-btn');

            var currentPassword = $('#acctsetting_current_password').val();
            var newPassword = $('#acctsetting_new_password').val();
            var confirmPassword = $('#acctsetting_password_confirmation').val();
            var passwordChangeRequested = Boolean(currentPassword || newPassword || confirmPassword);

            // Mirror the server-side all-or-nothing password rule for instant UX feedback.
            if (passwordChangeRequested) {
                if (!currentPassword) {
                    $('#acctsetting_passwordSettingsContainer').stop(true, true).slideDown(180);
                    $('#acctsetting_togglePasswordSettings').attr('aria-expanded', 'true').addClass('active');
                    $('#acctsetting_current_password').trigger('focus');
                    swal('Current password required', 'Enter your current password before changing your password.', 'warning');
                    return;
                }

                if (!newPassword) {
                    $('#acctsetting_passwordSettingsContainer').stop(true, true).slideDown(180);
                    $('#acctsetting_togglePasswordSettings').attr('aria-expanded', 'true').addClass('active');
                    $('#acctsetting_new_password').trigger('focus');
                    swal('New password required', 'Enter the new password you want to use.', 'warning');
                    return;
                }

                if (newPassword.length < 8) {
                    $('#acctsetting_passwordSettingsContainer').stop(true, true).slideDown(180);
                    $('#acctsetting_togglePasswordSettings').attr('aria-expanded', 'true').addClass('active');
                    $('#acctsetting_new_password').trigger('focus');
                    swal('Password too short', 'Your new password must be at least 8 characters.', 'warning');
                    return;
                }

                if (!confirmPassword) {
                    $('#acctsetting_passwordSettingsContainer').stop(true, true).slideDown(180);
                    $('#acctsetting_togglePasswordSettings').attr('aria-expanded', 'true').addClass('active');
                    $('#acctsetting_password_confirmation').trigger('focus');
                    swal('Confirm password', 'Re-enter your new password to confirm it.', 'warning');
                    return;
                }

                if (newPassword !== confirmPassword) {
                    $('#acctsetting_passwordSettingsContainer').stop(true, true).slideDown(180);
                    $('#acctsetting_togglePasswordSettings').attr('aria-expanded', 'true').addClass('active');
                    $('#acctsetting_password_confirmation').trigger('focus');
                    swal('Passwords do not match', 'New password and confirmation must be identical.', 'error');
                    return;
                }
            }

            $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Saving...');

            $.ajax({
                url: accountUpdateRoute,
                method: 'POST',
                data: $form.serialize(),
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    if (response.validation) {
                        let errors = response.errors;
                        if (typeof errors === 'object') {
                            errors = Object.values(errors)[0];
                            if (Array.isArray(errors)) errors = errors[0];
                        }
                        swal('Unable to save', errors || 'Please check the form and try again.', 'error');
                    } else {
                        swal('Saved', response.message || 'Account updated successfully.', 'success');
                        $('#userDisplay').text(response.username || 'Account');
                        $('#headerUsername').text(response.username || 'Account');
                        $('#headerEmail').text(response.email || '');
                        $('#accountSettingModal').modal('hide');
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON?.errors || xhr.responseJSON?.message || 'An error occurred.';
                    if (typeof errors === 'object') {
                        errors = Object.values(errors)[0];
                        if (Array.isArray(errors)) errors = errors[0];
                    }
                    swal('Unable to save', errors, 'error');
                },
                complete: function() {
                    $btn.prop('disabled', false).html('Save Changes');
                    $('#acctsetting_current_password, #acctsetting_new_password, #acctsetting_password_confirmation').attr('type', 'password').val('').trigger('input');
                }
            });
        });

        $('#accountSettingModal').on('show.bs.modal', function() {
            $('#acctsetting_userName').val($('#userDisplay').text().trim());
            $('#acctsetting_email').val($('#headerEmail').text().trim());
        });
    });
</script>
@endpush
