@extends('layout.app')
@section('title', 'SRF')

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

        #srf-warranty th, tbody {
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

        .dataTables_filter {
            margin-left: 10px; /* space between buttons and search */
            margin-bottom: 0;  /* align vertically */
        }

        /* Excel green color */
        .btn-excel {
            background-color: #217346 !important; /* Excel Green */
            color: white !important;
        }

        .btn-pdf {
            background-color: #d44646 !important; /* PDF Red */
            color: white !important;
            font-weight: bold;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            padding: 10px 18px;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-pdf:hover {
            background-color: #b23636 !important; /* Slightly darker red for hover effect */
        }


        /* Optional: Add hover color changes */
        .btn-excel:hover {
            background-color: #1b5a30 !important;
        }

        .btn-pdf:hover {
            background-color: #a83636 !important;
        }

        .btn.disabled, .btn:disabled, fieldset:disabled .btn {
            background-color: #aeaeae;
        }

        button.delete-btn:disabled,
        button.delete-btn.disabled {
            background-color: transparent !important; /* Remove background */
            border: none !important;                   /* Remove border */
            box-shadow: none !important;               /* Remove shadow */
            color: inherit !important;                 /* Keep original text color */
            cursor: not-allowed !important;            /* Show disabled cursor */
            opacity: 0.6 !important;                    /* Optional: lighter look */
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
                                <h4 class="card-title">SRF Clients</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="srf-warranty" class=" nowrap display table table-striped table-hover">
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

    var userRole = @json(auth()->user()->role);

    var ajaxUrl;

    if (userRole === 'admin') {
        ajaxUrl = '{{ route("admin.srf.index") }}';
    } else if (userRole === 'csr_srf') {
        ajaxUrl = '{{ route("csr_srf.srf.index") }}';
    } else {
// Default fallback or redirect
        ajaxUrl = '{{ route("login") }}';
    }


    $(document).ready(function () {
        var yourBase64ReceiptImages = [];
        var yourBase64ProductImages = [];

        var table = $("#srf-warranty").DataTable({
            scrollX: true,
//            processing: true,
            serverSide: false,
            ajax: {
                url: ajaxUrl,
                dataSrc: function(json) {
// Map base64 images by the current order in data
                    yourBase64ReceiptImages = json.data.map(item => item.receipt_image_base64 || '');
                    yourBase64ProductImages = json.data.map(item => item.product_image_base64 || '');
                    return json.data;
                }
            },
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
                        let badgeClass = 'badge-secondary';
                        if (data === 'pending') badgeClass = 'badge-warning';
                        else if (data === 'approved') badgeClass = 'badge-success';
                        else if (data === 'disapproved') badgeClass = 'badge-danger';

// Use userRole variable defined in your scope to control rendering
                        if (userRole !== 'admin') {
                            return `<div class="dropdown">
<button class="text-white btn btn-sm ${badgeClass} disabled" type="button"
id="statusDropdown${row.id}" aria-expanded="false" disabled>
${data.charAt(0).toUpperCase() + data.slice(1)}
</button>
<ul class="dropdown-menu p-2" aria-labelledby="statusDropdown${row.id}">
<li><a class="dropdown-item status-option badge-warning mb-1" href="#" data-id="${row.id}" data-status="pending">Pending</a></li>
<li><a class="dropdown-item status-option badge-success mb-1" href="#" data-id="${row.id}" data-status="approved">Approved</a></li>
<li><a class="dropdown-item status-option badge-danger" href="#" data-id="${row.id}" data-status="disapproved">Disapproved</a></li>
</ul>
</div>`;
                        } else {

                            return `<div class="dropdown">
<button class="text-white btn btn-sm dropdown-toggle ${badgeClass}" type="button"
id="statusDropdown${row.id}" data-bs-toggle="dropdown" aria-expanded="false" data-id="${row.id}">
${data.charAt(0).toUpperCase() + data.slice(1)}
</button>
<ul class="dropdown-menu p-2" aria-labelledby="statusDropdown${row.id}">
<li><a class="dropdown-item status-option badge-warning mb-1" href="#" data-id="${row.id}" data-status="pending">Pending</a></li>
<li><a class="dropdown-item status-option badge-success mb-1" href="#" data-id="${row.id}" data-status="approved">Approved</a></li>
<li><a class="dropdown-item status-option badge-danger" href="#" data-id="${row.id}" data-status="disapproved">Disapproved</a></li>
</ul>
</div>`;
                        }
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
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
// Assume userRole is defined in your JS scope
                        if (userRole !== 'admin') {
                            return '<button class="btn delete-btn" data-id="' + row.id + '" title="Delete" disabled style="cursor:not-allowed; opacity:0.5;">' +
                                '<i class="fa fa-trash" style="color: gray;"></i>' +
                                '</button>';
                        } else {
                            return '<button class="btn delete-btn" data-id="' + row.id + '" title="Delete">' +
                                '<i class="fa fa-trash" style="color: red;"></i>' +
                                '</button>';
                        }
                    }
                }

            ],
            dom: '<"d-flex justify-content-end align-items-center"Bf>rtip',
            buttons: [
                {
                    extend: 'pdfHtml5',
                    className: 'btn-pdf',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10], // Removed 11 and 12
                        format: {
                            body: function(data, row, column, node) {
                                if (column === 10) { // Handle column 10 button text extraction as before
                                    var div = document.createElement('div');
                                    div.innerHTML = data;
                                    var btn = div.querySelector('button');
                                    return btn ? btn.textContent.trim() : data;
                                }
                                if (column === 9) {
                                    var div = document.createElement('div');
                                    div.innerHTML = data;
                                    return div.textContent || div.innerText || '';
                                }
                                return data;
                            }
                        },
                        modifier: {
                            search: 'applied',
                            order: 'applied',
                            page: 'all'
                        }
                    },
                    customize: function(doc) {
                        doc.pageSize = 'A4';
                        doc.pageOrientation = 'landscape';
                        doc.pageMargins = [5, 5, 5, 5];

                        // Center align table headers
                        doc.styles.tableHeader.alignment = 'center';
                        doc.styles.tableHeader.margin = [5, 5, 5, 5]; // top and bottom padding for visual middle

                        // Center align all table body cells with vertical padding for middle effect
                        var tableBody = doc.content[1].table.body;
                        tableBody.forEach(function(row, rowIndex) {
                            // Skip header row if desired or style it separately above
                            if (rowIndex === 0) return;

                            row.forEach(function(cell) {
                                if (typeof cell === 'string') {
                                    cell = { text: cell, alignment: 'center', margin: [5, 5, 5, 5] };
                                    row[cell] = cell;
                                } else {
                                    cell.alignment = 'center';
                                    cell.margin = [5, 5, 5, 5]; // adds vertical spacing for middle alignment
                                }
                            });
                        });

                        doc.defaultStyle.fontSize = 8;
                    }


                }


            ]
        });

        var updateStatusUrl = '{{ route("admin.srf.update-status") }}';

// Prevent non-admin roles from attempting this action client-side:
        if (userRole !== 'admin') {
            updateStatusUrl = '';
        }

        $('#srf-warranty tbody').on('click', 'a.status-option', function(e) {
            e.preventDefault();

            if (userRole === 'csr_rs8' || userRole === 'csr_srf') {
                swal("Access Denied", "You do not have permission to change status.", "error");
                return;
            }

            var $option = $(this);
            var id = $option.data('id');
            var newStatus = $option.data('status');
            var $dropdownBtn = $option.closest('.dropdown').find('button');

            var dropdown = bootstrap.Dropdown.getInstance($dropdownBtn[0]);
            if (dropdown) {
                dropdown.hide();
            }

// Disable dropdown button while processing
            $dropdownBtn.prop('disabled', true);

            $.ajax({
                url: updateStatusUrl,
                method: 'POST',
                data: {
                    id: id,
                    status: newStatus
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.validation == true) {
                        var errors = response.errors;
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
// Update button text & class
                        var badgeClass;
                        if (newStatus === 'pending') badgeClass = 'badge-warning';
                        else if (newStatus === 'approved') badgeClass = 'badge-success';
                        else if (newStatus === 'disapproved') badgeClass = 'badge-danger';
                        else badgeClass = 'badge-secondary';

                        $dropdownBtn.text(newStatus.charAt(0).toUpperCase() + newStatus.slice(1));
                        $dropdownBtn
                            .removeClass('badge-warning badge-success badge-secondary badge-danger')
                            .addClass(badgeClass)
                            .data('status', newStatus);

// Reload table data
                        if (typeof table !== 'undefined') {
                            table.ajax.reload(null, false);
                        }
                    }
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
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
                },
                complete: function() {
                    $dropdownBtn.prop('disabled', false);
                }
            });
        });


        var DeleteUrl = '{{ route("admin.srf.delete") }}';

// Prevent non-admin roles from attempting this action client-side:
        if (userRole !== 'admin') {
            DeleteUrl = '';
        }

        $('#srf-warranty tbody').on('click', 'button.delete-btn', function(e) {
            e.preventDefault();

            var $btn = $(this);
            var id = $btn.data('id');
            var table = $('#srf-warranty').DataTable(); // initialize DataTable instance

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
                        url: DeleteUrl,
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