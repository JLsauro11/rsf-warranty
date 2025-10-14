{{--@extends('layout.app')--}}
{{--@section('title', 'RS8')--}}

{{--@section('content')--}}

    {{--@push('css')--}}

    {{--<style>--}}
        {{--#product-table th, tbody {--}}
            {{--text-align: center;--}}
        {{--}--}}
    {{--</style>--}}

    {{--@endpush--}}

    {{--<div class="main-panel">--}}

        {{--@include('layout.header')--}}

        {{--<div class="container">--}}
            {{--<div class="page-inner">--}}
                {{--@include('layout.breadcrumbs')--}}
                {{--<div class="row">--}}
                    {{--<div class="col-md-12">--}}
                        {{--<div class="card">--}}
                            {{--<div class="card-header d-flex justify-content-between align-items-center">--}}
                                {{--<h4 class="card-title mb-0">Products</h4>--}}
                                {{--<button id="btn-add-product" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">--}}
                                    {{--<i class="fas fa-plus me-1"></i> Add Product--}}
                                {{--</button>--}}
                            {{--</div>--}}

                            {{--<div class="card-body">--}}
                                {{--<div class="table-responsive">--}}
                                    {{--<table id="product-table" class=" nowrap display table table-striped table-hover">--}}
                                        {{--<thead>--}}
                                        {{--<tr>--}}
                                            {{--<th>Product</th>--}}
                                            {{--<th>Created At</th>--}}
                                            {{--<th>Updated At</th>--}}
                                            {{--<th>Action</th>--}}
                                        {{--</tr>--}}
                                        {{--</thead>--}}
                                        {{--<tbody>--}}
                                        {{--</tbody>--}}
                                    {{--</table>--}}

                                {{--</div>--}}

                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    {{--<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">--}}
        {{--<div class="modal-dialog">--}}
            {{--<form id="add-product-form" method="post" enctype="multipart/form-data" class="modal-content">--}}
                {{--@csrf--}}
                {{--<div class="modal-header">--}}
                    {{--<h5 class="modal-title" id="addProductModalLabel">Add Product</h5>--}}
                    {{--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
                {{--</div>--}}
                {{--<div class="modal-body">--}}
                    {{--<div class="mb-3">--}}
                        {{--<label for="product_code" class="form-label">Product</label>--}}
                        {{--<input type="text" class="form-control" id="product_code" name="product_code" placeholder="Enter Product">--}}
                    {{--</div>--}}
                    {{--<!-- Add more fields as needed -->--}}
                {{--</div>--}}
                {{--<div class="modal-footer">--}}
                    {{--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>--}}
                    {{--<button type="submit" class="btn btn-primary product-btn">Save Product</button>--}}
                {{--</div>--}}
            {{--</form>--}}
        {{--</div>--}}
    {{--</div>--}}


{{--@endsection--}}

{{--@push ('js')--}}

{{--<script>--}}

    {{--$(document).ready(function () {--}}

        {{--$('#addProductModal').on('hidden.bs.modal', function () {--}}
            {{--$(this).find('form')[0].reset();--}}
        {{--});--}}

        {{--$("#product-table").DataTable({--}}
            {{--processing: true,--}}
            {{--serverSide: false,--}}
            {{--ajax: "{{ route('product.index') }}",--}}
            {{--columns: [--}}
                {{--{ data: 'product_label' },--}}
                {{--{--}}
                    {{--data: 'created_at',--}}
                    {{--render: function(data) {--}}
                        {{--if (!data) return '';--}}
                        {{--let dateObj = new Date(data);--}}

                        {{--let month = dateObj.getMonth() + 1;--}}
                        {{--let day = dateObj.getDate();--}}
                        {{--let year = dateObj.getFullYear();--}}
                        {{--let hours = dateObj.getHours();--}}
                        {{--let minutes = dateObj.getMinutes();--}}
                        {{--let seconds = dateObj.getSeconds();--}}

                        {{--month = month < 10 ? '0' + month : month;--}}
                        {{--day = day < 10 ? '0' + day : day;--}}
                        {{--hours = hours < 10 ? '0' + hours : hours;--}}
                        {{--minutes = minutes < 10 ? '0' + minutes : minutes;--}}
                        {{--seconds = seconds < 10 ? '0' + seconds : seconds;--}}

                        {{--return `${month}/${day}/${year} ${hours}:${minutes}:${seconds}`;--}}
                    {{--}--}}
                {{--},--}}
                {{--{--}}
                    {{--data: 'updated_at',--}}
                    {{--render: function(data) {--}}
                        {{--if (!data) return '';--}}
                        {{--let dateObj = new Date(data);--}}

                        {{--let month = dateObj.getMonth() + 1;--}}
                        {{--let day = dateObj.getDate();--}}
                        {{--let year = dateObj.getFullYear();--}}
                        {{--let hours = dateObj.getHours();--}}
                        {{--let minutes = dateObj.getMinutes();--}}
                        {{--let seconds = dateObj.getSeconds();--}}

                        {{--month = month < 10 ? '0' + month : month;--}}
                        {{--day = day < 10 ? '0' + day : day;--}}
                        {{--hours = hours < 10 ? '0' + hours : hours;--}}
                        {{--minutes = minutes < 10 ? '0' + minutes : minutes;--}}
                        {{--seconds = seconds < 10 ? '0' + seconds : seconds;--}}

                        {{--return `${month}/${day}/${year} ${hours}:${minutes}:${seconds}`;--}}
                    {{--}--}}
                {{--},--}}
                {{--{--}}
                    {{--data: null,--}}
                    {{--orderable: false,--}}
                    {{--searchable: false,--}}
                    {{--render: function(data, type, row) {--}}
                        {{--// row contains the full data object, e.g., row.id if available for identifying the record--}}
                        {{--return '<button class="btn delete-btn" data-id="' + row.id + '" title="Delete">' +--}}
                            {{--'<i class="fa fa-trash" style="color: red;"></i>' +--}}
                            {{--'</button>';--}}
                    {{--}--}}
                {{--}--}}
            {{--]--}}
        {{--});--}}

        {{--$('#add-product-form').on('submit', function(e) {--}}
            {{--e.preventDefault();--}}

            {{--var $btn = $('.product-btn');--}}
            {{--$btn.prop('disabled', true);--}}
            {{--$btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');--}}

            {{--let formData = $(this).serialize(); // serialize form data--}}

            {{--$.ajax({--}}
                {{--url: "{{ route('product.add') }}",  // your POST route to save product--}}
                {{--method: 'POST',--}}
                {{--data: formData,--}}
                {{--success: function(response) {--}}

                    {{--if (response.validation == true) {--}}
                        {{--let errors = response.errors;--}}

                        {{--if (typeof errors === 'object') {--}}
                            {{--errors = Object.values(errors)[0];--}}
                            {{--if (Array.isArray(errors)) {--}}
                                {{--errors = errors[0];--}}
                            {{--}--}}
                        {{--}--}}

                        {{--errors = errors || "An error occurred"; // fallback string if empty--}}

                        {{--swal("Failed!", errors, {--}}
                            {{--icon: "error",--}}
                            {{--buttons: {--}}
                                {{--confirm: {--}}
                                    {{--className: "btn btn-danger",--}}
                                {{--},--}}
                            {{--},--}}
                        {{--});--}}
                    {{--} else {--}}
                        {{--swal({--}}
                            {{--title: "Success!",--}}
                            {{--text: response.message,--}}
                            {{--icon: "success",--}}
                            {{--buttons: {--}}
                                {{--confirm: {--}}
                                    {{--text: "OK",--}}
                                    {{--className: "btn btn-success"  // your custom CSS class--}}
                                {{--}--}}
                            {{--}--}}
                        {{--})--}}
                        {{--// Assuming response indicates success--}}
                        {{--$('#addProductModal').modal('hide');   // hide modal--}}
                        {{--$('#add-product-form')[0].reset();     // reset form fields--}}

                        {{--// Reload the datatable to show new product--}}
                        {{--$('#product-table').DataTable().ajax.reload();--}}
                    {{--}--}}



                {{--},--}}
                {{--error: function (xhr) {--}}
                    {{--let errors = xhr.responseJSON.errors;--}}

                    {{--if (typeof errors === 'object') {--}}
                        {{--// If it's an object, try to get a string safely--}}
                        {{--errors = Object.values(errors)[0];--}}
                        {{--if (Array.isArray(errors)) {--}}
                            {{--errors = errors[0];--}}
                        {{--}--}}
                    {{--}--}}

                    {{--errors = errors || "An error occurred"; // fallback string if empty--}}

                    {{--swal("Failed!", errors, {--}}
                        {{--icon: "error",--}}
                        {{--buttons: {--}}
                            {{--confirm: {--}}
                                {{--className: "btn btn-danger",--}}
                            {{--},--}}
                        {{--},--}}
                    {{--});--}}

                {{--},--}}
                {{--complete: function() {--}}
                    {{--$btn.prop('disabled', false);--}}
                    {{--$btn.html('Save Product');--}}
                {{--}--}}
            {{--});--}}
        {{--});--}}



    {{--$('#product-table tbody').on('click', 'button.delete-btn', function(e) {--}}
            {{--e.preventDefault();--}}

            {{--var $btn = $(this);--}}
            {{--var id = $btn.data('id');--}}

            {{--console.log(id);--}}

            {{--var table = $('#product-table').DataTable(); // initialize DataTable instance--}}

            {{--swal({--}}
                {{--title: "Are you sure?",--}}
                {{--text: "You won't be able to revert this!",--}}
                {{--type: "warning",--}}
                {{--buttons: {--}}
                    {{--cancel: {--}}
                        {{--visible: true,--}}
                        {{--text: "No, cancel!",--}}
                        {{--className: "btn btn-danger",--}}
                    {{--},--}}
                    {{--confirm: {--}}
                        {{--text: "Yes, delete it!",--}}
                        {{--className: "btn btn-success",--}}
                    {{--}--}}
                {{--},--}}
            {{--}).then((willDelete) => {--}}
                {{--if (willDelete) {--}}
                    {{--$btn.prop('disabled', true);--}}

                    {{--$.ajax({--}}
                        {{--url: '{{ route("rs8.delete") }}',--}}
                        {{--method: 'POST',--}}
                        {{--data: {--}}
                            {{--id: id,--}}
                            {{--_token: '{{ csrf_token() }}'--}}
                        {{--},--}}
                        {{--success: function(response) {--}}
                            {{--if (response.validation === true) {--}}
                                {{--let errors = response.errors;--}}

                                {{--if (typeof errors === 'object') {--}}
                                    {{--errors = Object.values(errors)[0];--}}
                                    {{--if (Array.isArray(errors)) {--}}
                                        {{--errors = errors[0];--}}
                                    {{--}--}}
                                {{--}--}}

                                {{--errors = errors || "An error occurred";--}}

                                {{--swal("Failed!", errors, {--}}
                                    {{--icon: "error",--}}
                                    {{--buttons: {--}}
                                        {{--confirm: {--}}
                                            {{--className: "btn btn-danger",--}}
                                        {{--},--}}
                                    {{--},--}}
                                {{--});--}}
                            {{--} else {--}}
                                {{--swal({--}}
                                    {{--title: "Success!",--}}
                                    {{--text: response.message,--}}
                                    {{--icon: "success",--}}
                                    {{--buttons: {--}}
                                        {{--confirm: {--}}
                                            {{--text: "OK",--}}
                                            {{--className: "btn btn-success"--}}
                                        {{--}--}}
                                    {{--}--}}
                                {{--});--}}

                                {{--// Reload the datatable after delete success--}}
                                {{--table.ajax.reload(null, false); // false to stay on the current page--}}
                            {{--}--}}
                        {{--},--}}
                        {{--error: function(xhr) {--}}
                            {{--let errors = xhr.responseJSON.errors;--}}

                            {{--if (typeof errors === 'object') {--}}
                                {{--errors = Object.values(errors)[0];--}}
                                {{--if (Array.isArray(errors)) {--}}
                                    {{--errors = errors[0];--}}
                                {{--}--}}
                            {{--}--}}

                            {{--errors = errors || "An error occurred";--}}

                            {{--swal("Failed!", errors, {--}}
                                {{--icon: "error",--}}
                                {{--buttons: {--}}
                                    {{--confirm: {--}}
                                        {{--className: "btn btn-danger",--}}
                                    {{--},--}}
                                {{--},--}}
                            {{--});--}}
                        {{--},--}}
                        {{--complete: function() {--}}
                            {{--$btn.prop('disabled', false);--}}
                        {{--}--}}
                    {{--});--}}
                {{--}--}}
            {{--});--}}
        {{--});--}}
    {{--});--}}



{{--</script>--}}

{{--@endpush--}}