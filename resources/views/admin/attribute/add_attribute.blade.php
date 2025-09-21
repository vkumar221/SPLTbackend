@extends('admin.layouts.app')
@section('title','SPLT | Attributes')
@section('sub_title','Attributes Management')
@section('import_export')
<li class="pc-h-item">

</li>
<li class="pc-h-item">

</li>
@endsection
@section('contents')
<div class="pc-container">
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard-page')}}">Home</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="{{route('admin.attributes')}}">All Attributes</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Add Attribute</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="card" style="background-color:transparent;border-color:unset;border: none;">
            <div class="card-body p-0">
                <div class="form-wrapper">
                <form id="add_attribute" action="{{ route('admin.add-attribute') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                @csrf
                    <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                        <label for="attribute_name">Attribute name</label>
                        <input type="text" class="form-control" name="attribute_name" id="attribute_name" value="{{old('attribute_name')}}" autocomplete="off">
                        </div>
                        @if($errors->has('attribute_name'))
                        <p class="text-danger">{{ $errors->first('attribute_name') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                        <label for="attribute_type">Attribute Type</label>
                        <input type="text" class="form-control" name="attribute_type" id="attribute_type" value="{{old('attribute_type')}}" autocomplete="off">
                        </div>
                        @if($errors->has('attribute_type'))
                        <p class="text-danger">{{ $errors->first('attribute_type') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                        <label for="category">Select Category</label>
                        <select class="form-control" name="attribute_category" id="attribute_category">
                            <option value="">Select</option>
                            @foreach($categories as $category)
                            <option value="{{$category->category_id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="variations-table">
                            <div class="variations-table__head">
                            <h2>Attribute Variations</h2>
                            <button type="button" class="add-btn" onclick="addRow()"><i class="ti ti-plus f-16"></i> Add</button>
                            </div>
                            <table id="variationTable">
                            <thead>
                                <tr>
                                <th>Name</th>
                                <th>Value</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td><input type="text" class="form-control" name="attribute_variation_name[1]" id="attribute_variation_name1" autocomplete="off"></td>
                                <td><input type="text" class="form-control" name="attribute_variation_value[1]" id="attribute_variation_value1" autocomplete="off"></td>
                                <td><button class="remove-btn" onclick="removeRow(this)"><img src="{{ asset(config('constants.admin_path').'images/icons/trash-blue.svg')}}" alt="trash"></button></td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-action__button">
                        <a href="{{route('admin.attributes')}}" class="btn-link btn-white"><img style="margin-right:5px" src="{{ asset(config('constants.admin_path').'images/icons/arrow-left.svg')}}" alt="arrow-left">Back</a>
                        <button type="submit" class="btn-link btn-dark" style="color:white" name="submit" value="Submit">Submit</button>
                        </div>
                    </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom_script')
<script>
        document.addEventListener('DOMContentLoaded', function () {
        ClassicEditor
            .create(document.querySelector('#classic-editor'))
            .catch(error => {
            console.error(error);
            });
        });
    </script>
    <script>
        document.querySelectorAll('.custom-file-input').forEach(function (input) {
        input.addEventListener('change', function () {
            const wrapper = this.closest('.custom-file-wrapper');
            const fileNameSpan = wrapper.querySelector('.file-name');
            fileNameSpan.textContent = this.files[0]?.name || '';
        });
        });
    </script>

    <script>
        $(document).ready(function () {
        $('#order-management').DataTable();
        });
    </script>

    <script>
        function addRow() {
        const tableBody = document.getElementById("variationTable").getElementsByTagName('tbody')[0];
        const rowCount = tableBody.rows.length;
        const isEven = (rowCount + 1) % 2 === 0;
        const newCount = rowCount + 1;

        const trashIcon = isEven
            ? '{{ asset(config('constants.admin_path').'images/icons/trash-blue.svg')}}'
            : '{{ asset(config('constants.admin_path').'images/icons/trash-blue.svg')}}';

        const newRow = document.createElement('tr');

        newRow.innerHTML = `
            <td><input type="text" class="form-control" name="attribute_variation_name[`+newCount+`]" id="attribute_variation_name`+newCount+`" autocomplete="off"></td>
            <td><input type="text" class="form-control" name="attribute_variation_value[`+newCount+`]" id="attribute_variation_value`+newCount+`" autocomplete="off"></td>
            <td>
            <button class="remove-btn" onclick="removeRow(this)">
                <img src="${trashIcon}" alt="trash" />
            </button>
            </td>
        `;

        tableBody.appendChild(newRow);
        }

        function removeRow(btn) {
        const row = btn.closest('tr');
        row.remove();
        resetTrashIcons();
        }

        function resetTrashIcons() {
        const rows = document.querySelectorAll("#variationTable tbody tr");
        rows.forEach((row, index) => {
            const img = row.querySelector("td:last-child img");
            if (img) {
            img.src = (index + 1) % 2 === 0
                ? "{{ asset(config('constants.admin_path').'images/icons/trash-white.svg')}}"
                : "{{ asset(config('constants.admin_path').'images/icons/trash-blue.svg')}}";
            }
        });
        }
    </script>
@endsection
