<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Warranty Registration</title>
    <!-- base:css -->
    <link rel="stylesheet" href="{{ asset('assets/login/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/login/vendor.bundle.base.css') }}">
    {{--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">--}}
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
        input[type="date"] {
            padding-left: 20px; /* same padding left */
            padding-right: 32px; /* enough space for icon on right */
            box-sizing: border-box; /* include padding in width */
            position: relative;
        }

        input[type="date"]::-webkit-calendar-picker-indicator {
            position: absolute;
            right: 20px; /* slight inward from right edge */
            top: 50%;
            transform: translateY(-50%);
            margin-left: 0;
            padding: 0;
            cursor: pointer;
            height: 20px; /* restrict icon size */
            width: 20px;
        }
        /* Adjust padding when validation icons (check or cross) exist */
        .was-validated input[type="date"].is-valid,
        .was-validated input[type="date"].is-invalid {
            padding-right: 10px; /* add space for validation icon + calendar icon */
        }

        /* Push native calendar icon left when validation icons present */
        .was-validated input[type="date"].is-valid::-webkit-calendar-picker-indicator,
        .was-validated input[type="date"].is-invalid::-webkit-calendar-picker-indicator {
            right: 30px; /* move left for validation icon on right */
        }
        .form-control {
            padding: 0.7rem 1rem;
        }
        .content-wrapper {
            background-image: url('{{ asset('assets/img/undraw/undraw_no_data_qbuo.svg') }}');
            background-attachment: scroll;
            background-size: 50rem 55rem;
            background-repeat: no-repeat;
            height: auto;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.937rem 1.437rem;
            width: 100%;
            -webkit-flex-grow: 1;
            flex-grow: 1;
            overflow-y: auto;

        }

        .swal-text {
            text-align: center !important;
        }


    </style>

</head>

<body>
<div class="container-scroller d-flex">
    <div class="container-fluid page-body-wrapper full-page-wrapper d-flex">
        <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0 justify-content-center">
                <div class="col-lg-6 col-md-8 offset-lg-6">
                    <div class="auth-form-light text-left py-5 px-5 px-sm-6 shadow-lg" style="border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
                        <h4 class="mb-5">Warranty Registration Form</h4>
                        <form id="registrationForm" method="post" enctype="multipart/form-data" class="row g-5 needs-validation" novalidate>
                            @csrf
                            <div class="col-md-6 mb-5">
                                <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="first_name" name="first_name" required>
                            </div>
                            <div class="col-md-6 mb-5">
                                <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="last_name" name="last_name" required>
                            </div>
                            <div class="col-md-6 mb-5">
                                <label for="contact_no" class="form-label">Contact No <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control form-control-lg" id="contact_no" name="contact_no" required pattern="^[0-9+\-\s]+$" maxlength="15">
                            </div>
                            <div class="col-md-6 mb-5">
                                <label for="product" class="form-label">Product <span class="text-danger">*</span></label>
                                <select class="form-control form-control-lg fs-4" id="product" name="product" required>
                                    <option value="" disabled selected>Select product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->product_label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-5">
                                <label for="product_name" class="form-label">Product Name <span class="text-danger">*</span></label>
                                <select class="form-control form-control-lg fs-4" id="product_name" name="product_name" required>
                                    <option value="" disabled selected>Select product name</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-5">
                                <label for="serial_no" class="form-label">Serial No <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="serial_no" name="serial_no" required>
                            </div>
                            <div class="col-md-6 mb-5">
                                <label for="purchase_date" class="form-label">Purchase Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control form-control-lg" id="purchase_date" name="purchase_date" required max="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="col-md-6 mb-5">
                                <label for="receipt_no" class="form-label">Receipt No <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="receipt_no" name="receipt_no" required>
                            </div>

                            <div class="col-md-6 mb-5">
                                <label for="store_name" class="form-label">Store Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="store_name" name="store_name" required>
                            </div>

                            <div class="col-md-6 mb-5">
                                <label for="fap_link" class="form-label">Facebook Account/Page Link <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="fap_link" name="fap_link" required>
                            </div>

                            <div class="col-md-6 mb-5">
                                <label for="receipt_image" class="form-label">Receipt Image <span class="text-danger">*</span></label>
                                <input type="file" class="form-control form-control-lg" id="receipt_image" name="receipt_image" accept="image/*" required>
                            </div>

                            <div class="col-md-6 mb-5">
                                <label for="product_image" class="form-label">Product Image <span class="text-danger">*</span></label>
                                <input type="file" class="form-control form-control-lg" id="product_image" name="product_image" accept="image/*" required>
                            </div>

                            {{--<div class="col-md-6 mb-5">--}}
                                {{--<label for="video" class="form-label">Installation Video <span class="text-danger">*</span></label>--}}
                                {{--<input type="file" class="form-control form-control-lg" id="video" name="video" accept="video/*" required>--}}
                                {{--<div class="valid-feedback"></div>--}}
                                {{--<div class="invalid-feedback"></div>--}}
                            {{--</div>--}}

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg w-100 register-form-btn">Register</button>
                            </div>
                            <div id="responseMessage" class="mt-3"></div>
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
{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>--}}


<script>
    $(function () {

        // Form submit event
        $('#registrationForm').submit(function(e) {
            e.preventDefault();
            const form = this;

            var $btn = $('.register-form-btn');
            $btn.prop('disabled', true);
            $btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Registering...');

            // Check file sizes here and block submission if size exceeded
            const maxSizeBytes = 5 * 1024 * 1024; // 5MB
            const receipt_imageInput = $('#receipt_image')[0];
            const product_imageInput = $('#product_image')[0];
//            const videoInput = $('#video')[0];
            if ((receipt_imageInput.files.length > 0 && receipt_imageInput.files[0].size > maxSizeBytes) ||
                (product_imageInput.files.length > 0 && product_imageInput.files[0].size > maxSizeBytes)) {
                swal("File Too Large!", "Image size must be less than 5 MB.", {
                    icon: "error",
                    buttons: {
                        confirm: {
                            className: "btn btn-danger",
                        },
                    },
                });
                $btn.prop('disabled', false);
                $btn.html('Register');
                event.preventDefault(); // Prevent form submission
                return false;
            }

            // If passed, continue with AJAX
            const formData = new FormData(form);

            $.ajax({
                url: '{{ route("registration") }}',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
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
                            },
                            closeOnClickOutside: false,
                        }).then(() => {
                            window.location.href = response.redirect;
                    });
                        form.reset();
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
                    $btn.html('Register');
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
                        console.log(data);
                        $productName.empty();

                        if (data.length > 0) {
                            $productName.append('<option value="" disabled selected>Select product name</option>');
                            $.each(data, function(index, productName) {
                                $productName.append($('<option>', {
                                    value: productName.id,
                                    text: productName.model_label
                                }));
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
