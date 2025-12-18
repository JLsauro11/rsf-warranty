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
            margin-left: 0; /* space between buttons and search */
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
                                            <th>Status</th>
                                            <th>Facebook Account/Page Link</th>
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
                    targets: [9, 13], // zero-based index of Status and Action columns
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
                    data: 'facebook_account_link',
                    render: function(data) {
                        return data
                            ? '<a href="' + data + '" target="_blank" rel="noopener noreferrer">' + data + '</a>'
                            : '';
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
                        columns: [0,1,2,3,4,5,6,7,8,9], // Removed 11 and 12
                        format:  {
                            header: function (d, columnIdx) {
                                return d;
                            },
                            body: function(data, row, column, node) {
                                if (column === 9) { // Handle column 10 button text extraction as before
                                    var div = document.createElement('div');
                                    div.innerHTML = data;
                                    var btn = div.querySelector('button');
                                    return btn ? btn.textContent.trim() : data;
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
                        doc.content[1].margin = [ 12, 0, 10, 0 ];
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
                        doc.pageMargins = [10, 10, 10, 10]; // left, top, right, bottom

                        // === TABLE REFERENCE (after unshift, table is at index 1) ===
                        var table = doc.content[1].table;
                        var body  = table.body;

                        // === COLUMN WIDTHS (11 columns) ===
                        table.widths = [
                            '10%',  // First Name
                            '10%',  // Last Name
                            '10%',  // Contact No
                            '10%',  // Product
                            '10%', // Product Name
                            '10%',  // Serial No
                            '10%',  // Purchase Date
                            '10%',  // Receipt No
                            '10%',  // Store Name
                            '10%'  // Status
                        ];

                        // Center align table headers and prevent wrap
                        doc.styles.tableHeader.alignment = 'center';
                        doc.styles.tableHeader.margin = [20, 5, 5, 5];
                        doc.styles.tableHeader.fontSize = 10;
                        doc.styles.tableHeader.noWrap = true;

                        var tableBody = doc.content[1].table.body;
                        tableBody.forEach(function(row, rowIndex) {
                            if (rowIndex === 0) return;
                            row.forEach(function(cell, index) {
                                if (typeof cell === 'string') {
                                    row[index] = { text: cell, alignment: 'center', margin: [20, 5, 5, 5] };
                                } else {
                                    cell.alignment = 'center';
                                    cell.margin = [20, 5, 5, 5];
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


// Resulting order: date range -> PDF -> search
        $('#srf-warranty_wrapper .dt-buttons').before(dateFilterHtml);

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