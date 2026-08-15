@extends('layout.app')
@section('title', 'Product Names')

@section('content')

    @push('css')

    <style>
        #product-name-table th, tbody {
            text-align: center;
        }
    </style>

    @endpush

    <div class="main-panel">

        @include('layout.header')

        <div class="container">
            <div class="page-inner">
                @include('layout.breadcrumbs')
                <div class="rs-page-heading">
                    <div class="rs-eyebrow">Catalog Management</div>
                    <h2>Product Names</h2>
                    <p>Maintain the product model names used in warranty registration.</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0">Product Names</h4>
                                <div class="table-bulk-actions">
                                    <button type="button" id="bulkDeleteProductNames" class="btn-bulk-delete" disabled>
                                        <i class="fas fa-trash-alt"></i> Delete Selected
                                        <span class="bulk-select-count" data-count="0"></span>
                                    </button>
                                    <button id="btn-add-productName" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductNameModal">
                                        <i class="fas fa-plus me-1"></i> Add Product Name
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="product-name-table" class="nowrap display table table-striped table-hover" style="width: 100%;">
                                        <thead>
                                        <tr>
                                            <th class="bulk-select-head"><input type="checkbox" class="table-select-all" aria-label="Select all visible product names"></th>
                                            <th>Product Name</th>
                                            <th>Product</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th>Action</th>
                                            {{--<th>Action</th>--}}

                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addProductNameModal" tabindex="-1" aria-labelledby="addProductNameModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered app-modal-dialog">
            <form id="add-productName-form" method="post" enctype="multipart/form-data" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductNameModalLabel">Add Product Name</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="model_code" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="model_code" name="model_code" placeholder="Enter Product Name">
                    </div>
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Select Product</label>
                        <select class="form-select" id="product_id" name="product_id">
                            <option value="" selected disabled>Select a product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->product_label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Add more fields as needed -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary productName-btn">Save Product Name</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="editProductNameModal" tabindex="-1" role="dialog" aria-labelledby="editProductNameModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered app-modal-dialog" role="document">
            <form id="edit-productName-form" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductNameModalLabel">Edit Product Name</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_model_code" class="form-label">Model Label</label>
                            <input type="text" class="form-control" id="edit_model_code" name="model_code" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_product_id" class="form-label">Product</label>
                            <select class="form-control" id="edit_product_id" name="product_id" required>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->product_label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Add other fields as needed -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary editproductName-btn">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection

@push ('js')

<script>
    $(document).ready(function () {

        $('#addProductNameModal').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
        });

        var table = $("#product-name-table").DataTable({
            processing: true,
            pageLength: 5,
            lengthMenu: [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
            serverSide: false,
            ajax: "{{ route('product-name.index') }}",
            order: [[3, 'desc']],
            columnDefs: [
                {
                    targets: [3, 4],
                    visible: false
                }
            ],
            columns: [
                {
                    data: null, orderable: false, searchable: false, className: 'bulk-select-cell',
                    render: function(data, type, row) {
                        return `<input type="checkbox" class="table-row-select" value="${row.id}" aria-label="Select ${row.model_label || 'product name'}">`;
                    }
                },
                { data: 'model_label' },
                { data: 'product.product_label' },
                {
                    data: 'created_at'
                },
                {
                    data: 'updated_at'
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `<button class="btn edit-btn" data-id="${row.id}" title="Edit">
                        <i class="fas fa-edit" style="color: blue;"></i></button>

                        <button class="btn delete-btn" data-id="${row.id}" title="Delete">
                        <i class="fas fa-trash" style="color: red;"></i></button>`;
                    }

                }
            ]
        });

        if (window.RSFBulkDelete) {
            RSFBulkDelete.init({
                table: table,
                tableSelector: '#product-name-table',
                deleteUrl: '{{ route("product-name.bulk-delete") }}',
                buttonSelector: '#bulkDeleteProductNames'
            });
        }

        {{--var editUrlTemplate = "{{ url('product-name/edit') }}/:id";--}}
        const editUrlTemplate = "{{ route('product-name.edit', ':id') }}";
        const updateUrlTemplate = "{{ route('product-name.update', ':id') }}";

        $('#product-name-table tbody').on('click', 'button.edit-btn', function () {
            var id = $(this).data('id');
            var editUrl = editUrlTemplate.replace(':id', id);

            $.ajax({
                url: editUrl,
                method: 'GET',
                success: function (response) {
                    $('#edit_id').val(response.id);
                    $('#edit_model_code').val(response.model_code);
                    $('#edit_product_id').val(response.product_id);
                    $('#editProductNameModal').modal('show');
                },
                error: function () {
                    swal("Error!", "Could not fetch data.", "error");
                }
            });
        });

        $('#edit-productName-form').on('submit', function (e) {
            e.preventDefault();

            var $form = $(this);
            var formData = $form.serialize();
            const id = $('#edit_id').val(); // ✅ Get from hidden field
            const updateUrl = updateUrlTemplate.replace(':id', id);

            var $btn = $form.find('.editproductName-btn');
            $btn.prop('disabled', true);
            $btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...');

            $.ajax({
                url: updateUrl,
                method: 'PUT',
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


                    $('#editProductNameModal').modal('hide');
                    $('#edit-productName-form')[0].reset();
                    $('#product-name-table').DataTable().ajax.reload(null, false);

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
                    $btn.html('Update');
                }
            });
        });



        $('#add-productName-form').on('submit', function(e) {
            e.preventDefault();

            var $btn = $('.productName-btn');
            $btn.prop('disabled', true);
            $btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

            let formData = $(this).serialize(); // serialize form data

            $.ajax({
                url: "{{ route('product-name.add') }}",  // your POST route to save product
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
// Assuming response indicates success
                        $('#addProductNameModal').modal('hide');   // hide modal
                        $('#add-productName-form')[0].reset();     // reset form fields

// Reload the datatable to show new product
                        $('#product-name-table').DataTable().ajax.reload();
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
                    $btn.html('Save Product Name');
                }
            });
        });

        $('#product-name-table tbody').on('click', 'button.delete-btn', function(e) {
            e.preventDefault();

            var $btn = $(this);
            var id = $btn.data('id');
            var table = $('#product-name-table').DataTable(); // initialize DataTable instance

            swal({
                title: "Are you sure?",
                text: "You want to delete this?",
                type: "warning",
                buttons: {
                    cancel: {
                        visible: true,
                        text: "No, cancel!",
                        className: "btn btn-danger",
                    },
                    confirm: {
                        text: "Yes, delete it!",
                        className: "btn btn-success",
                    }
                },
            }).then((willDelete) => {
                if (willDelete) {
                    $btn.prop('disabled', true);

                    $.ajax({
                        url: '{{ route("product-name.delete") }}',
                        method: 'POST',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.validation === true) {
                                let errors = response.errors;

                                if (typeof errors === 'object') {
                                    errors = Object.values(errors)[0];
                                    if (Array.isArray(errors)) {
                                        errors = errors[0];
                                    }
                                }

                                errors = errors || "An error occurred";

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
                                            className: "btn btn-success"
                                        }
                                    }
                                });

// Reload the datatable after delete success
                                table.ajax.reload(null, false); // false to stay on the current page
                            }
                        },
                        error: function(xhr) {
                            let errors = xhr.responseJSON.errors;

                            if (typeof errors === 'object') {
                                errors = Object.values(errors)[0];
                                if (Array.isArray(errors)) {
                                    errors = errors[0];
                                }
                            }

                            errors = errors || "An error occurred";

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
                        }
                    });
                }
            });
        });
    });



</script>

@endpush