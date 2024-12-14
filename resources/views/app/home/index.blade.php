@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <a href="{{ url('/home') }}">หน้าแรก</a>
            </li>
        </ol>
    </nav>
    <hr>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <!-- User Sidebar -->
            <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
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
                        <h5 class="pb-2 border-bottom mb-4 mt-3">รายละเอียดข้อมูลส่วนตัว</h5>
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
                            <div class="d-flex justify-content-center pt-3">
                                <a href="javascript:;" class="btn btn-secondary me-3" data-bs-target="#editUser"
                                    data-bs-toggle="modal">Edit</a>
                                {{-- <a href="javascript:;" class="btn btn-label-danger suspend-user">Suspended</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /User Card -->
            </div>
            <!--/ User Sidebar -->

            <!-- User Content -->
            <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                <div class="row">
                    <div class="col-12">
                        <div class="nav-align-top mb-4">
                            <ul class="nav nav-pills mb-3" role="tablist">
                                <li class="nav-item">
                                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#service-problem" aria-controls="#service-problem"
                                        aria-selected="true">
                                        แจ้งปัญหาการใช้งาน
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#service-it" aria-controls="#service-it"
                                        aria-selected="true" id="reTabA">
                                        รายการแจ้งปัญหาฝ่ายไอที
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#service-mt" aria-controls="#service-mt"
                                        aria-selected="true" id="reTabB">
                                        รายการแจ้งปัญหาฝ่ายอาคาร
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#service-user-check" aria-controls="#service-user-check"
                                        aria-selected="true" id="reTabC">
                                        รายการตรวจสอบงานเสร็จสิ้น
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="service-problem" role="tabpanel">
                                    @include('app.home.service.opencase')
                                </div>

                                <div class="tab-pane fade" id="service-it" role="tabpanel">
                                    <div class="inline-spacing text-end">
                                        @if (Auth::user()->user_system != 'Viewer')
                                            <button type="button" class="btn btn-info" id="addCategoryType">
                                                <i class='menu-icon tf-icons bx bx-layer'></i>
                                                เพิ่มข้อมูลรายการประเภทหมวดหมู่
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

                                <div class="tab-pane fade" id="service-mt" role="tabpanel">
                                    <div class="inline-spacing text-end">
                                        @if (Auth::user()->user_system != 'Viewer')
                                            <button type="button" class="btn btn-info" id="addCategoryDetail">
                                                <i class='menu-icon tf-icons bx bx-sitemap'></i> เพิ่มข้อมูลอาการ
                                            </button>
                                        @endif
                                    </div>
                                    <div class="text-nowrap table-responsive">
                                        <table class="dt-category-detail table table-hover table-striped">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>ลำดับ</th>
                                                    <th>ข้อมูลรายการกลุ่มอุปกรณ์</th>
                                                    <th>ข้อมูลรายการประเภทหมวดหมู่</th>
                                                    <th>ข้อมูลอาการแจ้งซ่อม</th>
                                                    <th>สถานะการใช้งาน</th>
                                                    <th>วันที่บันทึกข้อมูล</th>
                                                    <th>ผู้บันทึกข้อมูล</th>
                                                    <th>วันที่แก้ไขข้อมูล</th>
                                                    <th>ผู้แก้ไขข้อมูล</th>
                                                    <th>กำหนดรายละเอียด</th>
                                                    <th>จัดการ</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="service-user-check" role="tabpanel">
                                    
                                    <div class="text-nowrap table-responsive">
                                        <table class="dt-category-detail table table-hover table-striped">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>ลำดับ</th>
                                                    <th>ข้อมูลรายการกลุ่มอุปกรณ์</th>
                                                    <th>ข้อมูลรายการประเภทหมวดหมู่</th>
                                                    <th>ข้อมูลอาการแจ้งซ่อม</th>
                                                    <th>สถานะการใช้งาน</th>
                                                    <th>วันที่บันทึกข้อมูล</th>
                                                    <th>ผู้บันทึกข้อมูล</th>
                                                    <th>วันที่แก้ไขข้อมูล</th>
                                                    <th>ผู้แก้ไขข้อมูล</th>
                                                    <th>กำหนดรายละเอียด</th>
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
            </div>
            <!--/ User Content -->
        </div>

        <!-- Modal -->
        <!-- Edit User Modal -->
        <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-simple modal-edit-user">
                <div class="modal-content p-3 p-md-5">
                    <div class="modal-body pt-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="text-center mb-4">
                            <h3>Edit User Information</h3>
                            <p>Updating user details will receive a privacy audit.</p>
                        </div>
                        <form id="editUserForm" class="row g-3" onsubmit="return false">
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="modalEditUserFirstName">First Name</label>
                                <input type="text" id="modalEditUserFirstName" name="modalEditUserFirstName"
                                    class="form-control" placeholder="John" />
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="modalEditUserLastName">Last Name</label>
                                <input type="text" id="modalEditUserLastName" name="modalEditUserLastName"
                                    class="form-control" placeholder="Doe" />
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="modalEditUserName">Username</label>
                                <input type="text" id="modalEditUserName" name="modalEditUserName"
                                    class="form-control" placeholder="john.doe.007" />
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="modalEditUserEmail">Email</label>
                                <input type="text" id="modalEditUserEmail" name="modalEditUserEmail"
                                    class="form-control" placeholder="example@domain.com" />
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="modalEditUserStatus">Status</label>
                                <select id="modalEditUserStatus" name="modalEditUserStatus" class="form-select"
                                    aria-label="Default select example">
                                    <option selected>Status</option>
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
                                    <option value="3">Suspended</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="modalEditTaxID">Tax ID</label>
                                <input type="text" id="modalEditTaxID" name="modalEditTaxID"
                                    class="form-control modal-edit-tax-id" placeholder="123 456 7890" />
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="modalEditUserPhone">Phone Number</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">+1</span>
                                    <input type="text" id="modalEditUserPhone" name="modalEditUserPhone"
                                        class="form-control phone-number-mask" placeholder="202 555 0111" />
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="modalEditUserLanguage">Language</label>
                                <select id="modalEditUserLanguage" name="modalEditUserLanguage"
                                    class="select2 form-select" multiple>
                                    <option value="">Select</option>
                                    <option value="english" selected>English</option>
                                    <option value="spanish">Spanish</option>
                                    <option value="french">French</option>
                                    <option value="german">German</option>
                                    <option value="dutch">Dutch</option>
                                    <option value="hebrew">Hebrew</option>
                                    <option value="sanskrit">Sanskrit</option>
                                    <option value="hindi">Hindi</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="modalEditUserCountry">Country</label>
                                <select id="modalEditUserCountry" name="modalEditUserCountry" class="select2 form-select"
                                    data-allow-clear="true">
                                    <option value="">Select</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Bangladesh">Bangladesh</option>
                                    <option value="Belarus">Belarus</option>
                                    <option value="Brazil">Brazil</option>
                                    <option value="Canada">Canada</option>
                                    <option value="China">China</option>
                                    <option value="France">France</option>
                                    <option value="Germany">Germany</option>
                                    <option value="India">India</option>
                                    <option value="Indonesia">Indonesia</option>
                                    <option value="Israel">Israel</option>
                                    <option value="Italy">Italy</option>
                                    <option value="Japan">Japan</option>
                                    <option value="Korea">Korea, Republic of</option>
                                    <option value="Mexico">Mexico</option>
                                    <option value="Philippines">Philippines</option>
                                    <option value="Russia">Russian Federation</option>
                                    <option value="South Africa">South Africa</option>
                                    <option value="Thailand">Thailand</option>
                                    <option value="Turkey">Turkey</option>
                                    <option value="Ukraine">Ukraine</option>
                                    <option value="United Arab Emirates">United Arab Emirates</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="United States">United States</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="switch">
                                    <input type="checkbox" class="switch-input" />
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on"></span>
                                        <span class="switch-off"></span>
                                    </span>
                                    <span class="switch-label">Use as a billing address?</span>
                                </label>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Edit User Modal -->

        <!-- Add New Credit Card Modal -->
        <div class="modal fade" id="upgradePlanModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-simple modal-upgrade-plan">
                <div class="modal-content p-3 p-md-5">
                    <div class="modal-body pt-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="text-center mb-4">
                            <h3>Upgrade Plan</h3>
                            <p>Choose the best plan for user.</p>
                        </div>
                        <form id="upgradePlanForm" class="row g-3" onsubmit="return false">
                            <div class="col-sm-9">
                                <label class="form-label" for="choosePlan">Choose Plan</label>
                                <select id="choosePlan" name="choosePlan" class="form-select" aria-label="Choose Plan">
                                    <option selected>Choose Plan</option>
                                    <option value="standard">Standard - $99/month</option>
                                    <option value="exclusive">Exclusive - $249/month</option>
                                    <option value="Enterprise">Enterprise - $499/month</option>
                                </select>
                            </div>
                            <div class="col-sm-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">Upgrade</button>
                            </div>
                        </form>
                    </div>
                    <hr class="mx-md-n5 mx-n3" />
                    <div class="modal-body pt-0">
                        <h6 class="mb-0">User current plan is standard plan</h6>
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="d-flex justify-content-center me-2 mt-3">
                                <sup class="h5 pricing-currency pt-1 mt-3 mb-0 me-1 text-primary">$</sup>
                                <h1 class="display-3 mb-0 text-primary">99</h1>
                                <sub class="h5 pricing-duration mt-auto mb-2">/month</sub>
                            </div>
                            <button class="btn btn-label-danger cancel-subscription mt-3">Cancel Subscription</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Add New Credit Card Modal -->

        <!-- /Modal -->
    </div>
@endsection
