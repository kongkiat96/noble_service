@extends('layouts.app')

@section('stylesheets')
    <style>
        #tree-container {
            width: 100%;
            height: 500px;
            border: 1px solid #ccc;
        }

        .boc-edit-form-instruments {
            margin-top: 0px !important;
        }

        input[data-binding="ImgUrl"] {
            display: none;
        }
    </style>
@endsection
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/home') }}">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">{{ $urlName }}</li>
        </ol>
    </nav>
    <hr>

    <div class="container-p-y">
        <div class="row">
            <!-- User Sidebar -->
            <div class="col-md-4 order-md-0">
                <!-- User Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="user-avatar-section">
                            <div class="d-flex align-items-center flex-column">

                                @if ($dataEmployee->img_base == null)
                                    <img class="img-fluid rounded my-4" src="{{ asset('assets/img/img-not-found.png') }}"
                                        alt="Employee Image" height="200" width="200" />
                                @else
                                    <img class="img-fluid rounded my-4" src="{{ $dataEmployee->img_base }}"
                                        alt="Employee Image" height="200" width="200" />
                                @endif
                                <div class="user-info text-center">
                                    <h4 class="mb-2">{{ $dataEmployee->first_name . ' ' . $dataEmployee->last_name }}</h4>
                                    @if ($dataEmployee->user_class == 'SuperAdmin')
                                        <span class="badge bg-label-danger">ผู้ดูแลระบบ</span>
                                    @elseif($dataEmployee->user_class == 'Admin')
                                        <span class="badge bg-label-warning">เจ้าหน้าที่</span>
                                    @elseif($dataEmployee->user_class == 'user')
                                        <span class="badge bg-label-primary">ผู้บันทึกข้อมูล</span>
                                    @else
                                        <span class="badge bg-label-info">ผู้ใช้งานทั่วไป</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- <h5 class="pb-2 border-bottom mb-4 mt-3">รายละเอียดข้อมูลส่วนตัว</h5>
                        <div class="info-container">
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Status :</span>
                                    @if ($dataEmployee->status_login == 1)
                                        <span class="badge bg-label-success">Active</span>
                                    @else
                                        <span class="badge bg-label-danger">Inactive</span>
                                    @endif
                                </li>
                                <li class="mb-3">
                                    <span class="fw-bold me-2">บริษัท :</span>
                                    <span>{{ $aboutDepartment[0]->company_name_th }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-bold me-2">สังกัด / ฝ่าย :</span>
                                    <span>{{ $aboutDepartment[0]->departmentName }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-bold me-2">สาขา :</span>
                                    <span>{{ $dataEmployee->branch_name }}</span>
                                </li>
                            </ul>

                        </div> --}}
                    </div>
                </div>
                <!-- /User Card -->
            </div>
            <!--/ User Sidebar -->

            <!-- User Content -->
            <div class="col-md-8 order-md-1">
                <div class="row">
                    <div class="col-12">
                        <div class="nav-align-top mb-4">
                            <ul class="nav nav-pills mb-3" role="tablist">
                                <li class="nav-item">
                                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#open-case" aria-controls="#open-case" aria-selected="true">
                                        ข้อมูลส่วนตัว
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#service-it" aria-controls="#service-it" aria-selected="true"
                                        id="reTabA">
                                        เปลี่ยนแปลงรหัสผ่าน
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#service-mt" aria-controls="#service-mt" aria-selected="true"
                                        id="reTabB">
                                        ผู้ใต้บังคับบัญา
                                    </button>
                                </li>


                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="open-case" role="tabpanel">
                                    {{-- @include('app.home.service.opencase') --}}
                                </div>

                                <div class="tab-pane fade" id="service-it" role="tabpanel">
                                    <form id="formChangePasswordUser">
                                        <div class="alert alert-warning" role="alert">
                                            <h6 class="alert-heading fw-bold mb-1">คําแนะนําการเปลี่ยนรหัสผ่าน</h6>
                                            <span>ความยาวขั้นต่ำ 6 ตัวอักษร ตัวพิมพ์ใหญ่ และสัญลักษณ์</span>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-12 col-sm-6 form-password-toggle">
                                                <label class="form-label" for="newPassword">รหัสผ่านใหม่</label>
                                                <div class="input-group input-group-merge">
                                                    <input class="form-control" type="password" id="newPassword"
                                                        name="newPassword"
                                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                                    <span class="input-group-text cursor-pointer"><i
                                                            class="bx bx-hide"></i></span>
                                                </div>
                                            </div>

                                            <div class="mb-3 col-12 col-sm-6 form-password-toggle">
                                                <label class="form-label" for="confirmPassword">ยืนยันรหัสผ่านใหม่</label>
                                                <div class="input-group input-group-merge">
                                                    <input class="form-control" type="password"
                                                        name="confirmPassword" id="confirmPassword"
                                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                                    <span class="input-group-text cursor-pointer"><i
                                                            class="bx bx-hide"></i></span>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                {{-- <button type="submit" class="btn btn-primary me-2">Change
                                                    Password</button> --}}
                                                <button type="submit" name="changePassword"
                                                    id="changePassword"
                                                    class="btn btn-info btn-form-block-overlay"><i
                                                        class='menu-icon tf-icons bx bxs-paper-plane'></i>
                                                    แจ้งปัญหา</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="service-mt" role="tabpanel">
                                    <div id="tree-container"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ User Content -->
        </div>
    </div>
    {{-- {{ dd($dataManager[0]) }} --}}
@endsection
@section('script')
    <script src="{{ asset('/assets/custom/myProfile/my_profile.js?v=') }}@php echo date("H:i:s") @endphp"></script>

    <script>
        OrgChart.templates.anaOrange = Object.assign({}, OrgChart.templates.ana);
        OrgChart.templates.anaOrange.editFormHeaderColor = '#FFCA28';

        var chart = new OrgChart(document.getElementById("tree-container"), {
            enableSearch: false,
            mouseScrool: OrgChart.action.none,
            // layout: OrgChart.mixed,
            tags: {
                orange: {
                    template: 'anaOrange'
                }
            },
            editForm: {
                titleBinding: "EmployeeName",
                photoBinding: "ImgUrl",
                addMoreBtn: 'Add element',
                addMore: 'Add more elements',
                addMoreFieldName: 'Element name',
                buttons: {
                    edit: null,
                    share: null,
                    pdf: null,
                },
                generateElementsFromFields: true,

            },
            nodeBinding: {
                field_0: "EmployeeName",
                field_1: "Title",
                img_0: "ImgUrl"
            }
        });

        // chart.on('init', function (sender) { sender.editUI.show(1, true); });

        chart.editUI.on('element-btn-click', function(sender, args) {
            OrgChart.fileUploadDialog(function(file) {
                var formData = new FormData();
                formData.append('file', file);
                alert('upload the file');
            })
        });
        // chart.on('init', function (sender) { sender.editUI.show(3, true); });
        chart.load([{
                id: {{ $dataManager[0]['id'] }},
                EmployeeName: "{{ $dataManager[0]['EmployeeName'] }}",
                Title: "{{ $dataManager[0]['Title'] }}",
                ImgUrl: "{{ $dataManager[0]['ImgUrl'] }}"
            },
            @foreach ($dataManager[0]['subordinates'] as $key => $value)
                {
                    id: "{{ $value['id'] }}",
                    pid: "{{ $value['pid'] }}",
                    EmployeeName: "{{ $value['EmployeeName'] }}",
                    Title: "{{ $value['Title'] }}",
                    ImgUrl: "{{ $value['ImgUrl'] }}"
                },
            @endforeach
        ]);
    </script>
@endsection
