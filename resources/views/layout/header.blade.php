<style>
    .form-check, .form-group {
        margin-bottom: 0;
        padding: 0;
    }
    .toggle-header {
        margin-bottom: 12px; /* Add spacing below each toggle */
        border-radius: 8px;
        background: #f8f9fa;
        cursor: pointer;
        user-select: none;
        padding: 12px 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: background-color 0.25s ease;
        box-shadow: inset 0 -1px 0 #dee2e6;
    }
    .toggle-header:last-of-type {
        margin-bottom: 0; /* Remove margin for last toggle */
    }

    .toggle-header:hover {
        background: #e9ecef;
    }
    .toggle-header.active {
        background: #e0f2ff;
        box-shadow: inset 4px 0 0 0 #38a9ff;
    }

    .toggle-header span {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
    }
    .toggle-header i {
        font-size: 1.25rem;
        color: #38a9ff;
        transition: transform 0.3s ease;
    }

    /* When active, arrow points down (rotated) */
    .toggle-header.active i {
        transform: rotate(180deg);
        color: #0d6efd;
    }

</style>
<div class="main-header">
    <div class="main-header-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('index') }}" class="logo">
                <img
                        src="{{ asset('assets/img/rsf.png') }}"
                        alt="navbar brand"
                        class="navbar-brand"
                        height="20"
                />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <!-- Navbar Header -->
    <nav
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
    >
        <div class="container-fluid">
            {{--<nav--}}
                    {{--class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex"--}}
            {{-->--}}
                {{--<div class="input-group">--}}
                    {{--<div class="input-group-prepend">--}}
                        {{--<button type="submit" class="btn btn-search pe-1">--}}
                            {{--<i class="fa fa-search search-icon"></i>--}}
                        {{--</button>--}}
                    {{--</div>--}}
                    {{--<input--}}
                            {{--type="text"--}}
                            {{--placeholder="Search ..."--}}
                            {{--class="form-control"--}}
                    {{--/>--}}
                {{--</div>--}}
            {{--</nav>--}}

            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                {{--<li--}}
                        {{--class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none"--}}
                {{-->--}}
                    {{--<a--}}
                            {{--class="nav-link dropdown-toggle"--}}
                            {{--data-bs-toggle="dropdown"--}}
                            {{--href="#"--}}
                            {{--role="button"--}}
                            {{--aria-expanded="false"--}}
                            {{--aria-haspopup="true"--}}
                    {{-->--}}
                        {{--<i class="fa fa-search"></i>--}}
                    {{--</a>--}}
                    {{--<ul class="dropdown-menu dropdown-search animated fadeIn">--}}
                        {{--<form class="navbar-left navbar-form nav-search">--}}
                            {{--<div class="input-group">--}}
                                {{--<input--}}
                                        {{--type="text"--}}
                                        {{--placeholder="Search ..."--}}
                                        {{--class="form-control"--}}
                                {{--/>--}}
                            {{--</div>--}}
                        {{--</form>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                {{--<li class="nav-item topbar-icon dropdown hidden-caret">--}}
                    {{--<a--}}
                            {{--class="nav-link dropdown-toggle"--}}
                            {{--href="#"--}}
                            {{--id="messageDropdown"--}}
                            {{--role="button"--}}
                            {{--data-bs-toggle="dropdown"--}}
                            {{--aria-haspopup="true"--}}
                            {{--aria-expanded="false"--}}
                    {{-->--}}
                        {{--<i class="fa fa-envelope"></i>--}}
                    {{--</a>--}}
                    {{--<ul--}}
                            {{--class="dropdown-menu messages-notif-box animated fadeIn"--}}
                            {{--aria-labelledby="messageDropdown"--}}
                    {{-->--}}
                        {{--<li>--}}
                            {{--<div--}}
                                    {{--class="dropdown-title d-flex justify-content-between align-items-center"--}}
                            {{-->--}}
                                {{--Messages--}}
                                {{--<a href="#" class="small">Mark all as read</a>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<div class="message-notif-scroll scrollbar-outer">--}}
                                {{--<div class="notif-center">--}}
                                    {{--<a href="#">--}}
                                        {{--<div class="notif-img">--}}
                                            {{--<img--}}
                                                    {{--src="assets/img/jm_denis.jpg"--}}
                                                    {{--alt="Img Profile"--}}
                                            {{--/>--}}
                                        {{--</div>--}}
                                        {{--<div class="notif-content">--}}
                                            {{--<span class="subject">Jimmy Denis</span>--}}
                                            {{--<span class="block"> How are you ? </span>--}}
                                            {{--<span class="time">5 minutes ago</span>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                    {{--<a href="#">--}}
                                        {{--<div class="notif-img">--}}
                                            {{--<img--}}
                                                    {{--src="assets/img/chadengle.jpg"--}}
                                                    {{--alt="Img Profile"--}}
                                            {{--/>--}}
                                        {{--</div>--}}
                                        {{--<div class="notif-content">--}}
                                            {{--<span class="subject">Chad</span>--}}
                                            {{--<span class="block"> Ok, Thanks ! </span>--}}
                                            {{--<span class="time">12 minutes ago</span>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                    {{--<a href="#">--}}
                                        {{--<div class="notif-img">--}}
                                            {{--<img--}}
                                                    {{--src="assets/img/mlane.jpg"--}}
                                                    {{--alt="Img Profile"--}}
                                            {{--/>--}}
                                        {{--</div>--}}
                                        {{--<div class="notif-content">--}}
                                            {{--<span class="subject">Jhon Doe</span>--}}
                                            {{--<span class="block">--}}
                                {{--Ready for the meeting today...--}}
                              {{--</span>--}}
                                            {{--<span class="time">12 minutes ago</span>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                    {{--<a href="#">--}}
                                        {{--<div class="notif-img">--}}
                                            {{--<img--}}
                                                    {{--src="assets/img/talha.jpg"--}}
                                                    {{--alt="Img Profile"--}}
                                            {{--/>--}}
                                        {{--</div>--}}
                                        {{--<div class="notif-content">--}}
                                            {{--<span class="subject">Talha</span>--}}
                                            {{--<span class="block"> Hi, Apa Kabar ? </span>--}}
                                            {{--<span class="time">17 minutes ago</span>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a class="see-all" href="javascript:void(0);"--}}
                            {{-->See all messages<i class="fa fa-angle-right"></i>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                {{--<li class="nav-item topbar-icon dropdown hidden-caret">--}}
                    {{--<a--}}
                            {{--class="nav-link dropdown-toggle"--}}
                            {{--href="#"--}}
                            {{--id="notifDropdown"--}}
                            {{--role="button"--}}
                            {{--data-bs-toggle="dropdown"--}}
                            {{--aria-haspopup="true"--}}
                            {{--aria-expanded="false"--}}
                    {{-->--}}
                        {{--<i class="fa fa-bell"></i>--}}
                        {{--<span class="notification">4</span>--}}
                    {{--</a>--}}
                    {{--<ul--}}
                            {{--class="dropdown-menu notif-box animated fadeIn"--}}
                            {{--aria-labelledby="notifDropdown"--}}
                    {{-->--}}
                        {{--<li>--}}
                            {{--<div class="dropdown-title">--}}
                                {{--You have 4 new notification--}}
                            {{--</div>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<div class="notif-scroll scrollbar-outer">--}}
                                {{--<div class="notif-center">--}}
                                    {{--<a href="#">--}}
                                        {{--<div class="notif-icon notif-primary">--}}
                                            {{--<i class="fa fa-user-plus"></i>--}}
                                        {{--</div>--}}
                                        {{--<div class="notif-content">--}}
                                            {{--<span class="block"> New user registered </span>--}}
                                            {{--<span class="time">5 minutes ago</span>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                    {{--<a href="#">--}}
                                        {{--<div class="notif-icon notif-success">--}}
                                            {{--<i class="fa fa-comment"></i>--}}
                                        {{--</div>--}}
                                        {{--<div class="notif-content">--}}
                              {{--<span class="block">--}}
                                {{--Rahmad commented on Admin--}}
                              {{--</span>--}}
                                            {{--<span class="time">12 minutes ago</span>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                    {{--<a href="#">--}}
                                        {{--<div class="notif-img">--}}
                                            {{--<img--}}
                                                    {{--src="assets/img/profile2.jpg"--}}
                                                    {{--alt="Img Profile"--}}
                                            {{--/>--}}
                                        {{--</div>--}}
                                        {{--<div class="notif-content">--}}
                              {{--<span class="block">--}}
                                {{--Reza send messages to you--}}
                              {{--</span>--}}
                                            {{--<span class="time">12 minutes ago</span>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                    {{--<a href="#">--}}
                                        {{--<div class="notif-icon notif-danger">--}}
                                            {{--<i class="fa fa-heart"></i>--}}
                                        {{--</div>--}}
                                        {{--<div class="notif-content">--}}
                                            {{--<span class="block"> Farrah liked Admin </span>--}}
                                            {{--<span class="time">17 minutes ago</span>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a class="see-all" href="javascript:void(0);"--}}
                            {{-->See all notifications<i class="fa fa-angle-right"></i>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                {{--<li class="nav-item topbar-icon dropdown hidden-caret">--}}
                    {{--<a--}}
                            {{--class="nav-link"--}}
                            {{--data-bs-toggle="dropdown"--}}
                            {{--href="#"--}}
                            {{--aria-expanded="false"--}}
                    {{-->--}}
                        {{--<i class="fas fa-layer-group"></i>--}}
                    {{--</a>--}}
                    {{--<div class="dropdown-menu quick-actions animated fadeIn">--}}
                        {{--<div class="quick-actions-header">--}}
                            {{--<span class="title mb-1">Quick Actions</span>--}}
                            {{--<span class="subtitle op-7">Shortcuts</span>--}}
                        {{--</div>--}}
                        {{--<div class="quick-actions-scroll scrollbar-outer">--}}
                            {{--<div class="quick-actions-items">--}}
                                {{--<div class="row m-0">--}}
                                    {{--<a class="col-6 col-md-4 p-0" href="#">--}}
                                        {{--<div class="quick-actions-item">--}}
                                            {{--<div class="avatar-item bg-danger rounded-circle">--}}
                                                {{--<i class="far fa-calendar-alt"></i>--}}
                                            {{--</div>--}}
                                            {{--<span class="text">Calendar</span>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                    {{--<a class="col-6 col-md-4 p-0" href="#">--}}
                                        {{--<div class="quick-actions-item">--}}
                                            {{--<div--}}
                                                    {{--class="avatar-item bg-warning rounded-circle"--}}
                                            {{-->--}}
                                                {{--<i class="fas fa-map"></i>--}}
                                            {{--</div>--}}
                                            {{--<span class="text">Maps</span>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                    {{--<a class="col-6 col-md-4 p-0" href="#">--}}
                                        {{--<div class="quick-actions-item">--}}
                                            {{--<div class="avatar-item bg-info rounded-circle">--}}
                                                {{--<i class="fas fa-file-excel"></i>--}}
                                            {{--</div>--}}
                                            {{--<span class="text">Reports</span>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                    {{--<a class="col-6 col-md-4 p-0" href="#">--}}
                                        {{--<div class="quick-actions-item">--}}
                                            {{--<div--}}
                                                    {{--class="avatar-item bg-success rounded-circle"--}}
                                            {{-->--}}
                                                {{--<i class="fas fa-envelope"></i>--}}
                                            {{--</div>--}}
                                            {{--<span class="text">Emails</span>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                    {{--<a class="col-6 col-md-4 p-0" href="#">--}}
                                        {{--<div class="quick-actions-item">--}}
                                            {{--<div--}}
                                                    {{--class="avatar-item bg-primary rounded-circle"--}}
                                            {{-->--}}
                                                {{--<i class="fas fa-file-invoice-dollar"></i>--}}
                                            {{--</div>--}}
                                            {{--<span class="text">Invoice</span>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                    {{--<a class="col-6 col-md-4 p-0" href="#">--}}
                                        {{--<div class="quick-actions-item">--}}
                                            {{--<div--}}
                                                    {{--class="avatar-item bg-secondary rounded-circle"--}}
                                            {{-->--}}
                                                {{--<i class="fas fa-credit-card"></i>--}}
                                            {{--</div>--}}
                                            {{--<span class="text">Payments</span>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</li>--}}

                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a
                            class="dropdown-toggle profile-pic"
                            data-bs-toggle="dropdown"
                            href="#"
                            aria-expanded="false"
                    >
                        <div class="avatar-sm">
                            <img
                                    src="{{ asset('assets/img/profile-picture.png') }}"
                                    alt="..."
                                    class="avatar-img rounded-circle"
                            />
                        </div>
                        <span class="profile-username">
                      <span class="op-7">Hi,</span>
                      <span class="fw-bold" id="userDisplay"></span>
                    </span>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">
                                    <div class="avatar-lg">
                                        <img
                                                src="{{ asset('assets/img/profile-picture.png') }}"
                                                alt="image profile"
                                                class="avatar-img rounded"
                                        />
                                    </div>
                                    <div class="u-text">
                                        <h4 id="username"></h4>
                                        <p class="text-muted" id="email"></p>
                                        {{--<a--}}
                                                {{--href="profile.html"--}}
                                                {{--class="btn btn-xs btn-secondary btn-sm"--}}
                                        {{-->View Profile</a--}}
                                        {{-->--}}
                                    </div>
                                </div>
                            </li>
                            <li>
                                {{--<div class="dropdown-divider"></div>--}}
                                {{--<a class="dropdown-item" href="#">My Profile</a>--}}
                                {{--<a class="dropdown-item" href="#">My Balance</a>--}}
                                {{--<a class="dropdown-item" href="#">Inbox</a>--}}
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#accountSettingModal">Account Setting</a>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item" id="logout-btn">Logout</button>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
</div>

<!-- Modal structure -->
<div class="modal fade" id="accountSettingModal" tabindex="-1" aria-labelledby="accountSettingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="accountForm" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="accountSettingModalLabel">Account Setting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Username Settings Toggle -->
                    <div id="acctsetting_toggleUsernameSettings" class="toggle-header active" aria-expanded="true" aria-controls="acctsetting_usernameSettingsContainer" role="button">
                        <span>Username Settings</span>
                        <i class="fas fa-chevron-down" id="acctsetting_usernameSettingsArrow"></i>
                    </div>

                    <div id="acctsetting_usernameSettingsContainer">
                        <div class="mb-3">
                            <label for="acctsetting_userName" class="form-label">Username</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    id="acctsetting_userName"
                                    name="username"
                                    placeholder="Enter your username"

                            />
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <!-- Password Settings Toggle -->
                    <div id="acctsetting_togglePasswordSettings" class="toggle-header" aria-expanded="false" aria-controls="acctsetting_passwordSettingsContainer" role="button">
                        <span>Password Settings</span>
                        <i class="fas fa-chevron-down" id="acctsetting_passwordSettingsArrow"></i>
                    </div>

                    <div id="acctsetting_passwordSettingsContainer" style="display:none;">
                        <div class="form-group mb-3">
                            <label for="acctsetting_current_password" class="form-label">Current Password</label>
                            <div class="input-icon">
                                <input
                                        type="password"
                                        class="form-control"
                                        name="current_password"
                                        id="acctsetting_current_password"
                                        placeholder="Enter Current Password"
                                />
                                <span class="input-icon-addon" onclick="password_toggler('acctsetting_current_password')">
                        <i id="acctsetting_current_password_eye" class="fas fa-eye"></i>
                    </span>
                            </div>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="acctsetting_new_password" class="form-label">New Password</label>
                            <div class="input-icon">
                                <input
                                        type="password"
                                        id="acctsetting_new_password"
                                        name="new_password"
                                        class="form-control"
                                        placeholder="Enter New Password"
                                />
                                <span class="input-icon-addon" onclick="password_toggler('acctsetting_new_password')">
                        <i id="acctsetting_new_password_eye" class="fas fa-eye"></i>
                    </span>
                            </div>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="acctsetting_password_confirmation" class="form-label">Confirm Password</label>
                            <div class="input-icon">
                                <input
                                        type="password"
                                        id="acctsetting_password_confirmation"
                                        name="new_password_confirmation"
                                        class="form-control"
                                        placeholder="Enter New Password"
                                />
                                <span class="input-icon-addon" onclick="password_toggler('acctsetting_password_confirmation')">
                        <i id="acctsetting_password_confirmation_eye" class="fas fa-eye"></i>
                    </span>
                            </div>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary account-form-btn">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')

<script>

    $('#accountSettingModal').on('hidden.bs.modal', function () {
        var $passwordContainer = $("#acctsetting_passwordSettingsContainer");
        var $passwordToggleBtn = $("#acctsetting_togglePasswordSettings");
        var $passwordArrow = $("#acctsetting_passwordSettingsArrow");

        $passwordContainer.hide();
        $passwordToggleBtn.attr("aria-expanded", "false").removeClass("active");
        $passwordArrow.css('transform', 'rotate(0deg)').css('color', '#38a9ff'); // arrow up

        // Clear password inputs
        $passwordContainer.find('input[type="password"]').val('');
    });

    $(document).ready(function () {
        var $usernameContainer = $("#acctsetting_usernameSettingsContainer");
        var $usernameToggleBtn = $("#acctsetting_toggleUsernameSettings");
        var $usernameArrow = $("#acctsetting_usernameSettingsArrow");

        var $passwordContainer = $("#acctsetting_passwordSettingsContainer");
        var $passwordToggleBtn = $("#acctsetting_togglePasswordSettings");
        var $passwordArrow = $("#acctsetting_passwordSettingsArrow");

        // On modal show: username visible (active), password hidden (inactive)
        $("#acctsetting_accountSettingModal").on("show.bs.modal", function () {
            $usernameContainer.show();
            $usernameToggleBtn.attr("aria-expanded", "true").addClass("active");
            $usernameArrow.css('transform', 'rotate(180deg)').css('color', '#0d6efd'); // arrow down

            $passwordContainer.hide();
            $passwordToggleBtn.attr("aria-expanded", "false").removeClass("active");
            $passwordArrow.css('transform', 'rotate(0deg)').css('color', '#38a9ff'); // arrow up

            // Clear password inputs
            $passwordContainer.find('input[type="password"]').val('');
        });

        // Toggle username settings
        $usernameToggleBtn.on("click", function () {
            var isExpanded = $usernameToggleBtn.attr("aria-expanded") === "true";
            $usernameToggleBtn.attr("aria-expanded", !isExpanded).toggleClass("active");
            $usernameContainer.slideToggle(200);

            if (isExpanded) {
                $usernameArrow.css('transform', 'rotate(0deg)').css('color', '#38a9ff'); // arrow up
            } else {
                $usernameArrow.css('transform', 'rotate(180deg)').css('color', '#0d6efd'); // arrow down
            }
        });

        // Toggle password settings
        $passwordToggleBtn.on("click", function () {
            var isExpanded = $passwordToggleBtn.attr("aria-expanded") === "true";
            $passwordToggleBtn.attr("aria-expanded", !isExpanded).toggleClass("active");
            $passwordContainer.slideToggle(200);

            if (isExpanded) {
                $passwordArrow.css('transform', 'rotate(0deg)').css('color', '#38a9ff'); // arrow up
            } else {
                $passwordArrow.css('transform', 'rotate(180deg)').css('color', '#0d6efd'); // arrow down
            }
        });
    });




    $('#logout-btn').on('click', function() {
        $.ajax({
            url: '{{ route("logout") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    window.location.href = response.redirect_url; // example redirect after logout
                }
            }
        });
    });

    $.ajax({
        url: '{{ route("accountDisplay") }}',
        type: 'GET',
        success: function(data) {
            $('#userDisplay').text(data.user.username);
            $('#username').text(data.user.username);
            $('#email').text(data.user.email);
        }
    });

    $(document).ready(function() {
        $('#accountForm').submit(function(e) {
            e.preventDefault();

            var $form = $(this);
            var formData = $form.serialize();

            var $btn = $form.find('.account-form-btn');
            $btn.prop('disabled', true);
            $btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

            $.ajax({
                url: '{{ route('account.update') }}',
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
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
                            }
                        })
                    }
                    $('#userDisplay').text(response.username);
                    $('#acctsetting_current_password').val('');
                    $('#acctsetting_new_password').val('');
                    $('#acctsetting_password_confirmation').val('');

                    $('#accountSettingModal').modal('hide');

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
                    $btn.html('Save changes');
                }
            });
        });
    });


    $(document).ready(function() {
        // Fetch user data on modal show (or page load, depending on UX)
        $('#accountSettingModal').on('show.bs.modal', function() {
            $.ajax({
                url: "{{ route('account.update') }}",
                method: "GET",
                success: function(data) {
                    console.log(data);
                    $('#acctsetting_userName').val(data.username);
                    // Password fields remain empty for security reasons
                    $('#password').val('');
                    $('#change_password').val('');
                },
                error: function() {
                    alert('Failed to fetch account data.');
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

@endpush