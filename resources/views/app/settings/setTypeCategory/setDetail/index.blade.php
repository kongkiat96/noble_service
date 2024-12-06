@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/home') }}">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item"><a href="{{ url('/settings-system/set-type-category-' . strtolower($tag)) }}">
                    กำหนดรายการประเภทแจ้งซ่อม ({{ $tag }}s)</a></li>
            <li class="breadcrumb-item active">{{ $urlName }}</li>
        </ol>
    </nav>
    <hr>



    <div class="modal fade" id="addCategoryItemModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">

        </div>
    </div>

    <div class="modal fade" id="editCategoryItemModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">

        </div>
    </div>

    <div class="modal fade" id="addCategoryListModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">

        </div>
    </div>

    <div class="modal fade" id="editCategoryListModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">

        </div>
    </div>


    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="card-info">
                            <p class="card-text">ประเภทอุปกรณ์ในร้าน</p>
                            <div class="d-flex align-items-end mb-2">
                                <h4 class="card-title mb-0 me-2">{{ $dataCategoryDetail->category_main_name }}</h4>
                            </div>
                            <figcaption class="blockquote-footer mb-0 text-muted mt-3">
                                <cite title="Source Title">สำหรับหน้าร้านเลือก</cite>
                            </figcaption>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-primary rounded p-2">
                                <i class="bx bxs-purchase-tag bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="card-info">
                            <p class="card-text">หมวดหมู่</p>
                            <div class="d-flex align-items-end mb-2">
                                <h4 class="card-title mb-0 me-2">{{ $dataCategoryDetail->category_type_name }}</h4>
                            </div>
                            <figcaption class="blockquote-footer mb-0 text-muted mt-3">
                                <cite title="Source Title">สำหรับหน้าร้านเลือก</cite>
                            </figcaption>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-info rounded p-2">
                                <i class="bx bx-layer bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="card-info">
                            <p class="card-text">อาการแจ้งซ่อม</p>
                            <div class="d-flex align-items-end mb-2">
                                <h4 class="card-title mb-0 me-2">{{ $dataCategoryDetail->category_detail_name }}</h4>
                            </div>
                            <figcaption class="blockquote-footer mb-0 text-muted mt-3">
                                <cite title="Source Title">สำหรับหน้าร้านเลือก</cite>
                            </figcaption>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-success rounded p-2">
                                <i class="bx bx-sitemap bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="nav-align-top mb-4">
                <ul class="nav nav-pills mb-3" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#settype-category-item" aria-controls="#settype-category-item"
                            aria-selected="true" id="reTabA">
                            ข้อมูลรายการสาเหตุที่เสีย
                        </button>
                    </li>

                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#settype-category-list" aria-controls="#settype-category-list"
                            aria-selected="true" id="reTabB">
                            ข้อมูลรายการที่แก้ไข
                        </button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="settype-category-item" role="tabpanel">
                        <div class="inline-spacing text-end">
                            @if (Auth::user()->user_system != 'Viewer')
                                <button type="button" class="btn btn-info" id="addCategoryItem">
                                    <i class='menu-icon tf-icons bx bx-movie'></i> เพิ่มข้อมูลรายการสาเหตุที่เสีย
                                </button>
                            @endif
                        </div>
                        <div class="text-nowrap table-responsive">
                            <table class="dt-category-item table table-hover table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>ข้อมูลสาเหตุที่เสีย</th>
                                        <th>สถานะการใช้งาน</th>
                                        <th>วันที่บันทึกข้อมูล</th>
                                        <th>ผู้บันทึกข้อมูล</th>
                                        <th>วันที่แก้ไขข้อมูล</th>
                                        <th>ผู้แก้ไขข้อมูล</th>
                                        <th>จัดการ</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="settype-category-list" role="tabpanel">
                        <div class="inline-spacing text-end">
                            @if (Auth::user()->user_system != 'Viewer')
                                <button type="button" class="btn btn-info" id="addCategoryList">
                                    <i class='menu-icon tf-icons bx bxs-wrench'></i> เพิ่มข้อมูลรายการที่แก้ไข
                                </button>
                            @endif
                        </div>
                        <div class="text-nowrap table-responsive">
                            <table class="dt-category-type table table-hover table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>ข้อมูลรายการกลุ่มอุปกรณ์</th>
                                        <th>ข้อมูลรายการประเภทหมวดหมู่</th>
                                        <th>สถานะการใช้งาน</th>
                                        <th>วันที่บันทึกข้อมูล</th>
                                        <th>ผู้บันทึกข้อมูล</th>
                                        <th>วันที่แก้ไขข้อมูล</th>
                                        <th>ผู้แก้ไขข้อมูล</th>
                                        <th>จัดการ</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-4">
                <a href="{{ url('/settings-system/set-type-category-' . strtolower($tag)) }}" class="btn btn-danger"><i
                        class="bx bx-arrow-back"></i> ย้อนกลับ</a>
            </div>
        </div>
    </div>
    <input type="text" id="categoryAllID" name="categoryAllID" value="{{ $dataCategoryDetail->id }}" hidden>
@endsection
@section('script')
    <script type="text/javascript"
        src="{{ asset('/assets/custom/settings/setTypeCategory/set_type_category.js?v=') }}@php echo date("H:i:s") @endphp">
    </script>
@endsection
