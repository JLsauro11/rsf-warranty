@extends('layout.app')
@section('title', 'Product Names Trash')

@section('content')

    @push('css')

    <style>
        #product-name-trash-table th, tbody {
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
                    <div class="rs-eyebrow">Recovery</div>
                    <h2>Product Trash</h2>
                    <p>Restore product names that were previously removed.</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0">Product Names Trash</h4>
                                <div class="table-bulk-actions">
                                    <button type="button" id="bulkRestoreTrash" class="btn-bulk-restore" disabled>
                                        <i class="fas fa-redo-alt"></i> Restore Selected
                                        <span class="bulk-select-count" data-count="0"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="product-name-trash-table" class="nowrap display table table-striped table-hover" style="width: 100%;">
                                        <thead>
                                        <tr>
                                            <th class="bulk-select-head"><input type="checkbox" class="table-select-all" aria-label="Select all visible trash records"></th>
                                            <th>Product Name</th>
                                            <th>Product</th>
                                            <th>Deleted At</th>
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
@endsection

@push ('js')

<script>
    $(document).ready(function () {

        var table = $("#product-name-trash-table").DataTable({
            processing: true,
            pageLength: 5,
            lengthMenu: [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
            serverSide: false,
            ajax: "{{ route('product-name.trash') }}",
            order: [[3, 'desc']],
            columns: [
                {
                    data: null, orderable: false, searchable: false, className: 'bulk-select-cell',
                    render: function(data, type, row) {
                        return `<input type="checkbox" class="table-row-select" value="${row.id}" aria-label="Select ${row.model_label || 'trash record'}">`;
                    }
                },
                { data: 'model_label' },
                { data: 'product.product_label' },
                {
                    data: 'deleted_at',
                    render: function(data) {
                        if (!data) return '';
                        let dateObj = new Date(data);

                        let month = dateObj.getMonth() + 1;
                        let day = dateObj.getDate();
                        let year = dateObj.getFullYear();
                        let hours = dateObj.getHours();
                        let minutes = dateObj.getMinutes();
                        let seconds = dateObj.getSeconds();

                        month = month < 10 ? '0' + month : month;
                        day = day < 10 ? '0' + day : day;
                        hours = hours < 10 ? '0' + hours : hours;
                        minutes = minutes < 10 ? '0' + minutes : minutes;
                        seconds = seconds < 10 ? '0' + seconds : seconds;

                        return `${month}/${day}/${year} ${hours}:${minutes}:${seconds}`;
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        // row contains the full data object, e.g., row.id if available for identifying the record
                        return '<button class="btn restore-btn" data-id="' + row.id + '" title="Restore">' +
                            '<i class="fas fa-redo-alt" style="color: green;"></i>' +
                            '</button>';
                    }
                }
            ]
        });

        var bulkRestoreController = null;
        if (window.RSFBulkRestore) {
            bulkRestoreController = RSFBulkRestore.init({
                table: table,
                tableSelector: '#product-name-trash-table',
                deleteUrl: '{{ route("product-name.trash.bulk-restore") }}',
                buttonSelector: '#bulkRestoreTrash'
            });
        }

        $('#product-name-trash-table tbody').on('click', 'button.restore-btn', function(e) {
            e.preventDefault();

            var $btn = $(this);
            var id = $btn.data('id');
            var table = $('#product-name-trash-table').DataTable(); // initialize DataTable instance

            swal({
                title: "Are you sure?",
                text: "You want to restore this?",
                type: "warning",
                buttons: {
                    cancel: {
                        visible: true,
                        text: "No, cancel!",
                        className: "btn btn-danger",
                    },
                    confirm: {
                        text: "Yes, restore it!",
                        className: "btn btn-success",
                    }
                },
            }).then((willDelete) => {
                if (willDelete) {
                    $btn.prop('disabled', true);

                    $.ajax({
                        url: '{{ route("product-name.restore") }}',
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

// If this row was part of the multi-restore selection, remove it
                                // immediately so the Restore Selected count cannot stay stale.
                                if (bulkRestoreController) {
                                    bulkRestoreController.removeSelected(id);
                                }

                                // Reload and re-sync the remaining selections while staying
                                // on the current page.
                                table.ajax.reload(function () {
                                    if (bulkRestoreController) bulkRestoreController.sync();
                                }, false);
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