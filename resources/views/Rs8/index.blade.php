@extends('layout.app')
@section('title', 'RS8')

@section('content')

    @push('css')

    <style>
        .dataTables_scrollBody tr[style*="height: 0px"] {
            visibility: hidden !important;
        }

        div.dataTables_scrollBody table {
            border-top: none;
            margin-top: -20px !important;
            margin-bottom: 0 !important;
        }
        .dropdown-menu.p-2 .dropdown-item.badge-warning:hover {
            background-color: #ffad46 !important; /* your desired hover background for warning */
            color: white !important;           /* your desired hover text color */
            cursor: pointer;
        }

        .dropdown-menu.p-2 .dropdown-item.badge-success:hover {
            background-color: #28a745 !important; /* bootstrap success green */
            color: white !important;
            cursor: pointer;
        }

        .dropdown-menu.p-2 .dropdown-item.badge-danger:hover {
            background-color: #dc3545 !important; /* bootstrap danger red */
            color: white !important;
            cursor: pointer;
        }
        /* Darken dropdown toggle button on hover, preserving badge color */
        button.btn.dropdown-toggle.badge-warning:hover {
            background-color: #ffad46 !important; /* your desired hover background for warning */
            color: white !important;           /* your desired hover text color */
            cursor: pointer;
        }

        button.btn.dropdown-toggle.badge-success:hover {
            background-color: #28a745 !important; /* bootstrap success green */
            color: white !important;
            cursor: pointer;
        }

        button.btn.dropdown-toggle.badge-danger:hover {
            background-color: #dc3545 !important; /* bootstrap danger red */
            color: white !important;
            cursor: pointer;
        }
        button.btn.dropdown-toggle.badge-warning.show,
        .dropdown.show > button.btn.dropdown-toggle.badge-warning {
            background-color: #ffc107; /* Bootstrap warning color */
            filter: brightness(85%);
            color: white;
        }

        button.btn.dropdown-toggle.badge-success.show,
        .dropdown.show > button.btn.dropdown-toggle.badge-success {
            background-color: #28a745; /* Bootstrap success color */
            filter: brightness(85%);
            color: white;
        }

        button.btn.dropdown-toggle.badge-danger.show,
        .dropdown.show > button.btn.dropdown-toggle.badge-danger {
            background-color: #dc3545; /* Bootstrap danger color */
            filter: brightness(85%);
            color: white;
        }

        td img {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        #rs8-warranty th, tbody {
            text-align: center;
        }

        .table thead th {
            font-size: .95rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 12px 50px !important;
            border-bottom-width: 1px;
            font-weight: 600;
        }



    </style>

    @endpush

    <div class="main-panel">

        @include('layout.header')

        <div class="container">
            <div class="page-inner">
                    @include('layout.breadcrumbs')
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">RS8 Clients</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="rs8-warranty" class=" nowrap display table table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Contact No</th>
                                            <th>Product</th>
                                            <th>Product Name</th>
                                            <th>Serial No</th>
                                            <th>Purchase Date</th>
                                            <th>Receipt No</th>
                                            <th>Store Name</th>
                                            <th>Facebook Account/Page Link</th>
                                            <th>Status</th>
                                            <th>Receipt Image</th>
                                            <th>Product Image</th>
                                            {{--<th>Video</th>--}}
                                            <th>Action</th>

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
        $("#rs8-warranty").DataTable({
            scrollX: true,
            processing: true,
            serverSide: false,
            ajax: "{{ route('rs8.index') }}",
            columns: [
                { data: 'first_name' },
                { data: 'last_name' },
                { data: 'contact_no' },
                { data: 'product' },
                { data: 'product_name' },
                { data: 'serial_no' },
                { data: 'purchase_date' },
                { data: 'receipt_no' },
                { data: 'store_name' },
                {
                    data: 'facebook_account_link',
                    render: function(data) {
                        return data
                            ? '<a href="' + data + '" target="_blank" rel="noopener noreferrer">' + data + '</a>'
                            : '';
                    }
                },

                {
                    data: 'status',
                    render: function(data, type, row) {
                        if (!data) return '';
                        let badgeClass = 'badge-secondary'; // default

                        if (data === 'pending') badgeClass = 'badge-warning';
                        else if (data === 'approved') badgeClass = 'badge-success';
                        else if (data === 'disapproved') badgeClass = 'badge-danger';

                        return `
        <div class="dropdown">
            <button class="text-white btn btn-sm dropdown-toggle ${badgeClass}" type="button" id="statusDropdown${row.id}" data-bs-toggle="dropdown" aria-expanded="false" data-id="${row.id}">
                ${data.charAt(0).toUpperCase() + data.slice(1)}
            </button>
<ul class="dropdown-menu p-2" aria-labelledby="statusDropdown${row.id}">
    <li><a class="dropdown-item status-option badge-warning mb-1" href="#" data-id="${row.id}" data-status="pending">Pending</a></li>
    <li><a class="dropdown-item status-option badge-success mb-1" href="#" data-id="${row.id}" data-status="approved">Approved</a></li>
    <li><a class="dropdown-item status-option badge-danger" href="#" data-id="${row.id}" data-status="disapproved">Disapproved</a></li>
</ul>

        </div>`;
                    }
                },



                {
                    data: 'receipt_image_path',
                    render: function(data) {
                        return data
                            ? '<a href="' + data + '" target="_blank"><img src="' + data + '" width="50" height="50"/></a>'
                            : '';
                    }
                },
                {
                    data: 'product_image_path',
                    render: function(data) {
                        return data
                            ? '<a href="' + data + '" target="_blank"><img src="' + data + '" width="50" height="50"/></a>'
                            : '';
                    }
                },

//                {
//                    data: 'video_path', render: function(data) {
//                    return data ? '<a href="' + data + '" target="_blank">View Video</a>' : '';
//                }
//                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        // row contains the full data object, e.g., row.id if available for identifying the record
                        return '<button class="btn delete-btn" data-id="' + row.id + '" title="Delete">' +
                            '<i class="fa fa-trash" style="color: red;"></i>' +
                            '</button>';
                    }
                }
            ]
        });


        $('#rs8-warranty tbody').on('click', 'a.status-option', function(e) {
            e.preventDefault();

            var $option = $(this);
            var id = $option.data('id');
            var newStatus = $option.data('status');
            var $dropdownBtn = $option.closest('.dropdown').find('button');

            console.log(id);

            var dropdown = bootstrap.Dropdown.getInstance($dropdownBtn[0]);
            if (dropdown) {
                dropdown.hide();
            }

            // Disable dropdown button while processing
            $dropdownBtn.prop('disabled', true);

            $.ajax({
                url: '{{ route('rs8.update-status') }}',  // Your update status API endpoint
                method: 'POST',
                data: {
                    id: id,
                    status: newStatus,
                },
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
                        // Update button text, class, and data-status attribute
                        var badgeClass;

                        if (newStatus === 'pending') {
                            badgeClass = 'badge-warning';
                        } else if (newStatus === 'approved') {
                            badgeClass = 'badge-success';
                        } else if (newStatus === 'disapproved') {
                            badgeClass = 'badge-danger';
                        } else {
                            badgeClass = 'badge-secondary'; // fallback default
                        }
                        $dropdownBtn.text(newStatus.charAt(0).toUpperCase() + newStatus.slice(1));
                        $dropdownBtn
                            .removeClass('badge-warning badge-success badge-secondary badge-danger')
                            .addClass(badgeClass)
                            .data('status', newStatus);

                        // Close the dropdown menu manually after selection
                        var dropdown = bootstrap.Dropdown.getInstance($dropdownBtn[0]);
                        if (dropdown) {
                            dropdown.hide();
                        }
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
                    $dropdownBtn.prop('disabled', false);
                }
            });
        });

        $('#rs8-warranty tbody').on('click', 'button.delete-btn', function(e) {
            e.preventDefault();

            var $btn = $(this);
            var id = $btn.data('id');
            var table = $('#rs8-warranty').DataTable(); // initialize DataTable instance

            swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
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
                        url: '{{ route("rs8.delete") }}',
                        method: 'POST',
                        data: {
                            id: id,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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