@extends('layout.app')
@section('title', 'Manage Users')

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
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0">Manage Users</h4>
                                <button id="btn-add-user" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                    <i class="fas fa-plus me-1"></i> Add User
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="addUser-table" class=" nowrap display table table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
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

    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="add-user-form" method="post" enctype="multipart/form-data" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add Product Name</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="model_code" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username">
                    </div>
                    <div class="mb-3">
                        <label for="model_code" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email">
                    </div>
                    <div class="mb-3">
                        <label for="role_id" class="form-label">Role <span class="text-danger">*</span></label>
                        <select class="form-select" id="role_id" name="role_id" required>
                            <option value="">Select Role</option>
                            <option value="admin">Admin</option>
                            <option value="csr_rs8">CSR_RS8</option>
                            <option value="csr_srf">CSR_SRF</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="user_password" class="form-label">Password</label>
                        <div class="input-icon">
                            <input
                                    type="password"
                                    id="user_password"
                                    name="user_password"
                                    class="form-control"
                                    placeholder="Enter Password"
                            />
                            <span class="input-icon-addon" onclick="password_toggler('user_password')">
                        <i id="user_password_eye" class="fas fa-eye"></i>
                    </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="user_password_confirmation" class="form-label">Confirm Password</label>
                        <div class="input-icon">
                            <input
                                    type="password"
                                    id="user_password_confirmation"
                                    name="user_password_confirmation"
                                    class="form-control"
                                    placeholder="Confirm Password"
                            />
                            <span class="input-icon-addon" onclick="password_toggler('user_password_confirmation')">
                        <i id="user_password_confirmation_eye" class="fas fa-eye"></i>
                    </span>
                        </div>
                    </div>
                    <!-- Add more fields as needed -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary addUser-btn">Save User</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="edit-user-form" method="put" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="edit_username" name="username" placeholder="Enter Username" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" placeholder="Enter Email" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_role" class="form-label">Role <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_role" name="role" required>
                                <option value="">Select Role</option>
                                <option value="admin">admin</option>
                                <option value="csr_rs8">csr_rs8</option>
                                <option value="csr_srf">csr_srf</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary editUser-btn">Update User</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



@endsection

@push ('js')

<script>

    function password_toggler(selector){
        $('#'+selector+'_eye').toggleClass('fa-eye fa-eye-slash')
        $('#'+selector).attr('type', function(index, attr){
            return attr == 'text' ? 'password' : 'text';
        });
    }

    $(document).ready(function () {

        $('#addUserModal').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
        });

        $("#addUser-table").DataTable({
            processing: true,
            serverSide: false,
            ajax: "{{ route('user.index') }}",
            columns: [
                { data: 'username' },
                { data: 'email' },
                { data: 'role' },
                {
                    data: 'created_at',
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
                    data: 'updated_at',
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
                        return `<button class="btn edit-btn" data-id="${row.id}" title="Edit">
                        <i class="fas fa-edit" style="color: blue;"></i></button>

                        <button class="btn delete-btn" data-id="${row.id}" title="Delete">
                        <i class="fas fa-trash" style="color: red;"></i></button>`;
                    }

                }
            ]
        });

// Define template once
        const editUrlTemplate = "{{ route('user.edit', ':id') }}";

        $('#addUser-table tbody').on('click', 'button.edit-btn', function () {
            const $btn = $(this);
            const id = $btn.data('id');
            const editUrl = editUrlTemplate.replace(':id', id);

            $.ajax({
                url: editUrl,
                method: 'GET',
                success: function (user) {
                    $('#edit_id').val(user.id);
                    $('#edit_username').val(user.username);
                    $('#edit_email').val(user.email);
                    $('#edit_role').val(user.role);
                    $('#editUserModal').modal('show');
                },
                error: function () {
                    Swal.fire('Error!', 'Could not fetch user data.', 'error');
                }
            });
        });

        const updateUrlTemplate = "{{ route('user.update', ':id') }}";


        $('#edit-user-form').on('submit', function (e) {
            e.preventDefault();

            var $form = $(this);
            var formData = $form.serialize();
            const id = $('#edit_id').val(); // ✅ Get from hidden field
            const updateUrl = updateUrlTemplate.replace(':id', id);


            var $btn = $form.find('.editUser-btn');
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


                    $('#editUserModal').modal('hide');
                    $('#edit-user-form')[0].reset();
                    $('#addUser-table').DataTable().ajax.reload(null, false);

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



        $('#add-user-form').on('submit', function(e) {
            e.preventDefault();

            var $btn = $('.addUser-btn');
            $btn.prop('disabled', true);
            $btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

            let formData = $(this).serialize(); // serialize form data

            $.ajax({
                url: "{{ route('user.add') }}",  // your POST route to save product
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
                        $('#addUserModal').modal('hide');   // hide modal
                        $('#add-user-form')[0].reset();     // reset form fields

// Reload the datatable to show new product
                        $('#addUser-table').DataTable().ajax.reload();
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

        $('#addUser-table tbody').on('click', 'button.delete-btn', function(e) {
            e.preventDefault();

            var $btn = $(this);
            var id = $btn.data('id');
            var table = $('#addUser-table').DataTable(); // initialize DataTable instance

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
                        url: '{{ route("user.delete") }}',
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