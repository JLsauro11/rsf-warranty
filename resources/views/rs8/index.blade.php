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

        .dataTables_filter {
            margin-left: 0; /* space between buttons and search */
            margin-bottom: 0;  /* align vertically */
        }

        /* Excel green color */
        .btn-excel {
            background-color: #217346 !important; /* Excel Green */
            color: white !important;
        }

        /* PDF red color */
        .btn-pdf {
            background-color: #d44646 !important; /* PDF Red */
            color: white !important;
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

        div.dt-buttons>.dt-button {
            margin-bottom: 0;
            font-size: 10px;
            padding: 7px 13px;
            font-weight: 500;
            border-radius: 3px;
            /*margin-left: -6px !important;*/
        }

        @media screen and (max-width: 767px) {
            div.dataTables_wrapper div.dataTables_length {
                text-align: center;
                margin-top: 0;
                margin-bottom: 0;
            }
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
                                <!-- Date Range Filter -->

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
        ajaxUrl = '{{ route("admin.rs8.index") }}';
    } else if (userRole === 'csr_rs8') {
        ajaxUrl = '{{ route("csr_rs8.rs8.index") }}';
    } else {
        // Default fallback or redirect
        ajaxUrl = '{{ route("login") }}';
    }

    $(document).ready(function () {
        var yourBase64ReceiptImages = [];
        var yourBase64ProductImages = [];

        var table = $("#rs8-warranty").DataTable({
            scrollX: true,
//            processing: true,
            serverSide: false,
            ajax: {
                url: ajaxUrl,
                data: function(d) {
                    // Add date range parameters to AJAX request
                    d.from_date = $('#fromDate').val();
                    d.to_date = $('#toDate').val();
                },
                dataSrc: function(json) {
                    return json.data;
                }
            },
            columnDefs: [
                {
                    targets: [10, 13], // zero-based index of Status and Action columns
                    visible: !(userRole === 'csr_rs8' || userRole === 'csr_srf')
                }
            ],
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
          </button>`;
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
            dom:
            // One row container
            '<"dt-top-row d-flex flex-wrap align-items-end justify-content-between"' +
            // Left block: length + date range + PDF
            '<"dt-left d-flex flex-wrap align-items-end gap-3"lB>' +
            // Right block: search
            '<"dt-right"f>' +
            '>rtip',
            buttons: [
                {
                    extend: 'pdfHtml5',
                    className: 'btn-pdf',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10], // Removed 11 and 12
                        format:  {
                            header: function (d, columnIdx) {
                                return d;
                            },
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
                        // Add date range to PDF title if filters are applied
                        var fromDate = $('#fromDate').val();
                        var toDate = $('#toDate').val();
                        var dateRangeTitle = '';

                        if (fromDate || toDate) {
                            dateRangeTitle = ' (';
                            if (fromDate && toDate) {
                                dateRangeTitle += `Date Range: ${fromDate} to ${toDate}`;
                            } else if (fromDate) {
                                dateRangeTitle += `From: ${fromDate}`;
                            } else {
                                dateRangeTitle += `To: ${toDate}`;
                            }
                            dateRangeTitle += ')';
                        }

                        doc.content.splice(0, 1);

                        // Add logo to the header
                        // Replace 'data:image/png;base64,...' with your actual base64 image string
                        doc.content.unshift({
                            image: 'data:image/png;base64,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', // your logo base64 here
                            width: 100, // adjust width as needed
                            margin: [0, 0, 0, 12], // margin below the image
                            alignment: 'center'
                        });

                        doc.pageSize = 'A4';
                        doc.pageOrientation = 'landscape';
                        doc.pageMargins = [6, 6, 6, 6];

                        // Center align table headers and prevent wrap
                        doc.styles.tableHeader.alignment = 'center';
                        doc.styles.tableHeader.margin = [5, 5, 3, 5];
                        doc.styles.tableHeader.fontSize = 10;
                        doc.styles.tableHeader.noWrap = true;

                        var tableBody = doc.content[1].table.body;
                        tableBody.forEach(function(row, rowIndex) {
                            if (rowIndex === 0) return;
                            row.forEach(function(cell, index) {
                                if (typeof cell === 'string') {
                                    row[index] = { text: cell, alignment: 'center', margin: [5, 2, 3, 2] };
                                } else {
                                    cell.alignment = 'center';
                                    cell.margin = [5, 2, 3, 2];
                                }
                            });
                        });

                        doc.defaultStyle.fontSize = 8;
                    }

                }


            ]
        });

        const dateFilterHtml = `
  <div id="dateFilterWrapper"
       class="d-flex flex-wrap align-items-end gap-2">

    <div class="d-flex flex-column">
      <label class="form-label mb-1">From Date</label>
      <input type="date" class="form-control form-control-sm" id="fromDate">
    </div>

    <div class="d-flex flex-column">
      <label class="form-label mb-1">To Date</label>
      <input type="date" class="form-control form-control-sm" id="toDate">
    </div>

    <div class="d-flex align-items-end gap-1">
      <button type="button" class="btn btn-primary btn-sm" id="filterBtn">Filter</button>
      <button type="button" class="btn btn-secondary btn-sm" id="clearFilterBtn">Clear</button>
    </div>
  </div>
`;

// Order inside left block: length -> date range -> PDF
        $('#rs8-warranty_wrapper .dt-buttons').before(dateFilterHtml);



        // Filter button click handler
        $('#filterBtn').on('click', function() {
            table.ajax.reload();
        });

        // Clear filter button handler
        $('#clearFilterBtn').on('click', function() {
            $('#fromDate').val('');
            $('#toDate').val('');
            table.ajax.reload();
        });

        // Enter key support for date inputs
        $('#fromDate, #toDate').on('keypress', function(e) {
            if (e.which === 13) {
                $('#filterBtn').click();
            }
        });




        var updateStatusUrl = '{{ route("admin.rs8.update-status") }}';

        // Prevent non-admin roles from attempting this action client-side:
        if (userRole !== 'admin') {
            updateStatusUrl = '';
        }


        $('#rs8-warranty tbody').on('click', 'a.status-option', function(e) {
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
                url: updateStatusUrl,  // Your update status API endpoint
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

                        // Reload table data
                        if (typeof table !== 'undefined') {
                            table.ajax.reload(null, false);
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

        var DeleteUrl = '{{ route("admin.rs8.delete") }}';

// Prevent non-admin roles from attempting this action client-side:
        if (userRole !== 'admin') {
            DeleteUrl = '';
        }
        $('#rs8-warranty tbody').on('click', 'button.delete-btn', function(e) {
            e.preventDefault();
            if (userRole === 'csr_rs8' || userRole === 'csr_srf') {
                swal("Access Denied", "You do not have permission to delete records.", "error");
                return;
            }
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
                        url: DeleteUrl,
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