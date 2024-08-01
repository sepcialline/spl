<x-app-layout>
    @section('title')
        {{ __('admin.branch_branch_manager') }} | {{ __('admin.branch_add_branch') }}
    @endsection
    @section('VendorsCss')
        <style>
            .active {
                box-shadow: 0 0.125rem 0.25rem rgba(147, 158, 170, 0.4);
                background-color: #5a8dee !important;
            }
        </style>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">{{ __('admin.branch_branch_list') }} /</span>
            {{ __('admin.accountant_details') }} / {{ __('admin.accounts_expenses') }}
        </h4>
        <div class="row gy-4">
            <!-- User Sidebar -->
            @include('admin.branchs.includes.card-details', ['branch' => $branch])
            <!--/ User Sidebar -->

            <!-- User Content -->
            <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                <!-- User Pills -->
                @include('admin.branchs.includes.nav_list', ['active' => 'exp', 'branch' => $branch])
                <!--/ User Pills -->

                @include('admin.branchs.includes.add_account', ['store' => 'exp', 'branch' => $branch,'account' =>$exp_account])

                <!-- Project table -->
                {{-- <div class="card mb-4">
                    <h5 class="card-header">User's Projects List</h5>
                    <div class="table-responsive mb-3">
                        <table class="table datatable-project border-top">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Project</th>
                                    <th class="text-nowrap">Total Task</th>
                                    <th>Progress</th>
                                    <th>Hours</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div> --}}
                <!-- /Project table -->

                <!-- Activity Timeline -->
                {{-- <div class="card mb-4">
                    <h5 class="card-header">User Activity Timeline</h5>
                    <div class="card-body">
                        <ul class="timeline">
                            <li class="timeline-item timeline-item-transparent">
                                <span class="timeline-point timeline-point-primary"></span>
                                <div class="timeline-event">
                                    <div class="timeline-header mb-1">
                                        <h6 class="mb-0">12 Invoices have been paid</h6>
                                        <small class="text-muted">12 min ago</small>
                                    </div>
                                    <p class="mb-2">Invoices have been paid to the company</p>
                                    <div class="d-flex">
                                        <a href="javascript:void(0)" class="me-3">
                                            <img src="../../assets/img/icons/misc/pdf.png" alt="PDF image"
                                                width="20" class="me-2" />
                                            <span class="fw-bold text-body">invoices.pdf</span>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li class="timeline-item timeline-item-transparent">
                                <span class="timeline-point timeline-point-warning"></span>
                                <div class="timeline-event">
                                    <div class="timeline-header mb-1">
                                        <h6 class="mb-0">Client Meeting</h6>
                                        <small class="text-muted">45 min ago</small>
                                    </div>
                                    <p class="mb-2">Project meeting with john @10:15am</p>
                                    <div class="d-flex flex-wrap">
                                        <div class="avatar me-3">
                                            <img src="../../assets/img/avatars/3.png" alt="Avatar"
                                                class="rounded-circle" />
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Lester McCarthy (Client)</h6>
                                            <span>CEO of PIXINVENT</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="timeline-item timeline-item-transparent">
                                <span class="timeline-point timeline-point-info"></span>
                                <div class="timeline-event">
                                    <div class="timeline-header mb-1">
                                        <h6 class="mb-0">Create a new project for client</h6>
                                        <small class="text-muted">2 Day Ago</small>
                                    </div>
                                    <p class="mb-2">5 team members in a project</p>
                                    <div class="d-flex align-items-center avatar-group">
                                        <div class="avatar pull-up" data-bs-toggle="tooltip"
                                            data-popup="tooltip-custom" data-bs-placement="top"
                                            title="Vinnie Mostowy">
                                            <img src="../../assets/img/avatars/5.png" alt="Avatar"
                                                class="rounded-circle" />
                                        </div>
                                        <div class="avatar pull-up" data-bs-toggle="tooltip"
                                            data-popup="tooltip-custom" data-bs-placement="top" title="Marrie Patty">
                                            <img src="../../assets/img/avatars/12.png" alt="Avatar"
                                                class="rounded-circle" />
                                        </div>
                                        <div class="avatar pull-up" data-bs-toggle="tooltip"
                                            data-popup="tooltip-custom" data-bs-placement="top"
                                            title="Jimmy Jackson">
                                            <img src="../../assets/img/avatars/9.png" alt="Avatar"
                                                class="rounded-circle" />
                                        </div>
                                        <div class="avatar pull-up" data-bs-toggle="tooltip"
                                            data-popup="tooltip-custom" data-bs-placement="top"
                                            title="Kristine Gill">
                                            <img src="../../assets/img/avatars/6.png" alt="Avatar"
                                                class="rounded-circle" />
                                        </div>
                                        <div class="avatar pull-up" data-bs-toggle="tooltip"
                                            data-popup="tooltip-custom" data-bs-placement="top"
                                            title="Nelson Wilson">
                                            <img src="../../assets/img/avatars/14.png" alt="Avatar"
                                                class="rounded-circle" />
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="timeline-item timeline-item-transparent">
                                <span class="timeline-point timeline-point-success"></span>
                                <div class="timeline-event">
                                    <div class="timeline-header mb-1">
                                        <h6 class="mb-0">Design Review</h6>
                                        <small class="text-muted">5 days Ago</small>
                                    </div>
                                    <p class="mb-0">Weekly review of freshly prepared design for our new app.</p>
                                </div>
                            </li>
                            <li class="timeline-end-indicator">
                                <i class="bx bx-check-circle"></i>
                            </li>
                        </ul>
                    </div>
                </div> --}}
                <!-- /Activity Timeline -->

                <!-- Invoice table -->
                {{-- <div class="card">
                    <div class="table-responsive mb-3">
                        <table class="table datatable-invoice border-top">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th><i class="bx bx-trending-up"></i></th>
                                    <th>Total</th>
                                    <th>Issued Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div> --}}
                <!-- /Invoice table -->
            </div>
            <!--/ User Content -->
        </div>

        <!-- Modal -->
        <!-- Edit User Modal -->
        {{-- <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-simple modal-edit-user">
                <div class="modal-content p-3 p-md-5">
                    <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
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
                                <select id="modalEditUserCountry" name="modalEditUserCountry"
                                    class="select2 form-select" data-allow-clear="true">
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
                            <div class="col-12 text-center mt-4">
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
        </div> --}}
        <!--/ Edit User Modal -->

        <!-- Add New Credit Card Modal -->
        <div class="modal fade" id="upgradePlanModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-simple modal-upgrade-plan">
                <div class="modal-content p-3 p-md-5">
                    <div class="modal-body">
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
                    <div class="modal-body">
                        <h6 class="mb-0">User current plan is standard plan</h6>
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="d-flex justify-content-center me-2 mt-2">
                                <sup class="h5 pricing-currency fw-normal pt-2 mt-4 mb-0 me-1 text-primary">$</sup>
                                <h1 class="fw-normal display-1 mb-0 text-primary">99</h1>
                                <sub class="h5 pricing-duration mt-auto mb-3">/month</sub>
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


    @include('admin.branchs.includes.js')

</x-app-layout>
