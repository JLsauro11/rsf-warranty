<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>RS8 x SRF | Warranty Registration</title>
    <link rel="icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/login/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/login/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/login/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fonts.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/rs8-srf-theme.css') }}">
</head>
<body class="rs-auth-page" data-brand="fusion">
<div class="registration-shell">
    <aside class="rs-auth-visual">
        <div class="rs-auth-brand">
            <div class="brand-combo">
                <img src="{{ asset('assets/img/rs8-brand.png') }}" alt="RS8" class="rs8-logo">
                <span class="brand-divider"></span>
                <img src="{{ asset('assets/img/srf-brand.png') }}" alt="SRF" class="srf-logo">
            </div>
            <small>Official Warranty Registration</small>
        </div>

        <div class="rs-auth-message">
            <div class="rs-auth-kicker">Warranty Registration</div>
            <h1>LOCK IN THE PRODUCT.<br><span>SECURE THE WARRANTY.</span></h1>
            <p>Complete the product and purchase information accurately. Your submitted details will be used for warranty verification and support.</p>
        </div>

        <div class="rs-auth-footnote">RS8 x SRF • Warranty Registration Portal</div>
    </aside>

    <main class="registration-panel">
        <div class="rs-auth-card wide registration-card">
            <div class="mobile-brand">
                <img src="{{ asset('assets/img/rs8-brand.png') }}" alt="RS8">
                <img src="{{ asset('assets/img/srf-brand.png') }}" alt="SRF">
            </div>
            <div class="auth-kicker">Product Protection</div>
            <h2>Warranty Registration</h2>
            <p class="auth-copy">Provide the customer, product, and proof-of-purchase details below. Fields marked with <span class="text-danger">*</span> are required.</p>

            <form id="registrationForm" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf

                <section class="registration-form-section">
                    <div class="registration-section">01 / Customer Information</div>
                    <div class="registration-form-grid">
                        <div class="registration-field">
                            <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="first_name" name="first_name" required>
                        </div>
                        <div class="registration-field">
                            <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="last_name" name="last_name" required>
                        </div>
                        <div class="registration-field">
                            <label for="contact_no" class="form-label">Contact No. <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control form-control-lg" id="contact_no" name="contact_no" required pattern="^[0-9+\-\s]+$" maxlength="15">
                        </div>
                        <div class="registration-field">
                            <label for="fap_link" class="form-label">Facebook Account / Page Link <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="fap_link" name="fap_link" required>
                        </div>
                    </div>
                </section>

                <section class="registration-form-section">
                    <div class="registration-section">02 / Product Details</div>
                    <div class="registration-form-grid">
                        <div class="registration-field">
                            <label for="product" class="form-label">Product <span class="text-danger">*</span></label>
                            <select class="form-select form-control-lg" id="product" name="product" required>
                                <option value="" disabled selected>Select product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->product_label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="registration-field">
                            <label for="product_name" class="form-label">Product Name <span class="text-danger">*</span></label>
                            <select class="form-select form-control-lg" id="product_name" name="product_name" required>
                                <option value="" disabled selected>Select product name</option>
                            </select>
                        </div>
                        <div class="registration-field">
                            <label for="serial_no" class="form-label">Serial No. <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="serial_no" name="serial_no" required>
                        </div>
                        <div class="registration-field">
                            <label for="purchase_date" class="form-label">Purchase Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-lg" id="purchase_date" name="purchase_date" required max="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                </section>

                <section class="registration-form-section">
                    <div class="registration-section">03 / Purchase & Proof</div>
                    <div class="registration-form-grid">
                        <div class="registration-field">
                            <label for="receipt_no" class="form-label">Receipt No. <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="receipt_no" name="receipt_no" required>
                        </div>
                        <div class="registration-field">
                            <label for="store_name" class="form-label">Store Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="store_name" name="store_name" required>
                        </div>
                        <div class="registration-field">
                            <label for="receipt_image" class="form-label">Receipt Image <span class="text-danger">*</span></label>
                            <input type="file" class="form-control form-control-lg" id="receipt_image" name="receipt_image" accept="image/*" required>
                            <small class="text-muted">JPG, PNG or WEBP · Maximum 5 MB</small>
                        </div>
                        <div class="registration-field">
                            <label for="product_image" class="form-label">Product Image <span class="text-danger">*</span></label>
                            <input type="file" class="form-control form-control-lg" id="product_image" name="product_image" accept="image/*" required>
                            <small class="text-muted">JPG, PNG or WEBP · Maximum 5 MB</small>
                        </div>
                    </div>
                </section>

                <div class="registration-submit">
                    <button type="submit" class="btn btn-primary btn-lg w-100 register-form-btn">Submit Warranty Registration</button>
                </div>
                <div id="responseMessage" class="mt-3"></div>
            </form>
        </div>
    </main>
</div>

<script src="{{ asset('assets/login/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
<script>
    $(function () {
        $('#registrationForm').submit(function(e) {
            e.preventDefault();
            const form = this;
            var $btn = $('.register-form-btn');
            $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Registering...');

            const maxSizeBytes = 5 * 1024 * 1024;
            const receiptImageInput = $('#receipt_image')[0];
            const productImageInput = $('#product_image')[0];
            if ((receiptImageInput.files.length > 0 && receiptImageInput.files[0].size > maxSizeBytes) ||
                (productImageInput.files.length > 0 && productImageInput.files[0].size > maxSizeBytes)) {
                swal('File Too Large', 'Image size must be less than 5 MB.', 'error');
                $btn.prop('disabled', false).html('Submit Warranty Registration');
                return false;
            }

            const formData = new FormData(form);
            $.ajax({
                url: '{{ route("registration") }}',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function (response) {
                    if (response.validation == true) {
                        let errors = response.errors;
                        if (typeof errors === 'object') {
                            errors = Object.values(errors)[0];
                            if (Array.isArray(errors)) errors = errors[0];
                        }
                        swal('Registration Failed', errors || 'An error occurred.', 'error');
                    } else {
                        swal('Registration Complete', response.message, 'success').then(() => {
                            window.location.href = response.redirect;
                        });
                        form.reset();
                    }
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON?.errors || xhr.responseJSON?.message || 'An error occurred.';
                    if (typeof errors === 'object') {
                        errors = Object.values(errors)[0];
                        if (Array.isArray(errors)) errors = errors[0];
                    }
                    swal('Registration Failed', errors, 'error');
                },
                complete: function() {
                    $btn.prop('disabled', false).html('Submit Warranty Registration');
                }
            });
        });

        $('#product').change(function() {
            var productId = $(this).val();
            var $productName = $('#product_name');
            $productName.empty().append('<option value="" disabled selected>Loading...</option>');

            if (productId) {
                $.ajax({
                    url: '{{ route("getProductNames", ["productId" => "PRODUCT_ID"]) }}'.replace('PRODUCT_ID', productId),
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $productName.empty();
                        if (data.length > 0) {
                            $productName.append('<option value="" disabled selected>Select product name</option>');
                            $.each(data, function(index, productName) {
                                $productName.append($('<option>', { value: productName.id, text: productName.model_label }));
                            });
                        } else {
                            $productName.append('<option value="" disabled selected>No product names available</option>');
                        }
                    },
                    error: function() {
                        $productName.empty().append('<option value="" disabled selected>Error loading product names</option>');
                    }
                });
            } else {
                $productName.empty().append('<option value="" disabled selected>Select product name</option>');
            }
        });
    });
</script>
</body>
</html>
