@extends('layouts.app')

@section('contents')
    <div class="main-content p-4" style="margin-left: 260px; min-height: 100vh; background: #f8f9fa;">

        <!-- ✅ Top Bar -->



        @php
            use App\Models\Setting;
            use App\Models\Taxonomies_sessions;

            // Fetch currency and session rows (assuming both have id=3 for now)
            $currency_data = Setting::find(3);
            $session_datas = Taxonomies_sessions::get(); // Replace id with actual session id if different

            // Prepare currency options
            $currency_options = [];
            if ($currency_data) {
                $clean_value = str_replace(['[', ']'], '', $currency_data->value); // remove brackets
                $currency_options = array_map('trim', explode(',', $clean_value)); // split and trim
            }

            // Prepare session options

        @endphp

        <div class="teacher-topbar d-flex justify-content-between align-items-center mb-4 p-3"
            style="background: #ffffff; border-radius: 10px;">
            <div>
                <h4 class="fw-semibold mb-0">Platform</h4>
            </div>
            <div class="d-flex align-items-center gap-3">

                <!-- Session / Year Dropdown -->
                <select class="form-select form-select-md" id="SelectYear">
                    @foreach ($session_datas as $session_data)
                        <option value="{{ $session_data->id }}">{{ $session_data->session_title }}</option>
                    @endforeach
                </select>

                <!-- Currency Dropdown -->
                <select class="form-select form-select-md" id="currencySelect">
                    @foreach ($currency_options as $option)
                        <option value="{{ $option }}">{{ $option }}</option>
                    @endforeach
                </select>

            </div>
        </div>







        <!-- Header -->
        <div class="mb-4">
            <h4 class="fw-semibold mb-1">Platform Overview</h4>
            <p class="text-muted mb-0">Manage platform transactions, payouts, balances, and reports</p>
        </div>

        <!-- Platform Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-wrapper me-3">
                            <i class="fa-solid fa-arrow-trend-up fa-lg text-success"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-1">Platform Balance</p>
                            <h5 class="fw-bold text-success mb-0">LE 4,658.25</h5>
                            <small class="text-muted">Platform revenue (30% share)</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-wrapper me-3">
                            <i class="fa-solid fa-dollar-sign fa-lg text-primary"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-1">Total Revenue</p>
                            <h5 class="fw-bold text-primary mb-0">LE 4,658.25</h5>
                            <small class="text-muted">Lifetime platform earnings</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-wrapper me-3">
                            <i class="fa-solid fa-coins fa-lg text-purple"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-1">Withdrawn Balance</p>
                            <h5 class="fw-bold text-purple mb-0">LE 0.00</h5>
                            <small class="text-muted">Amount withdrawn by platform</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Tabs -->
        <div class="d-flex gap-2 mb-3 flex-wrap" id="mainTabContainer">
            <button class="tab-btn active" data-target="transactionsDiv">Transactions</button>
            <button class="tab-btn" data-target="payoutsDiv">Payouts</button>
            <button class="tab-btn" data-target="balancesDiv">Balances</button>
            <button class="tab-btn" data-target="reportsDiv">Reports</button>
        </div>

        <!-- Sub Tabs Container -->
        <div class="d-flex gap-2 mb-3 flex-wrap" id="subTabContainer">
            <button class="tab-btn active" id="sub-recent">Recent</button>
            <button class="tab-btn" id="sub-percourse">Per Course</button>
            <button class="tab-btn" id="balance-teacher" style="display:none;">Teacher</button>
            <button class="tab-btn" id="balance-platform" style="display:none;">Platform</button>
        </div>


        <!-- Transactions Modal -->

        {{-- <button type="button" class="btn btn-dark mb-3 ms-2" id="openTransactionsModal">
            View Transactions
        </button> --}}
        {{-- <div class="d-flex justify-content-end mb-3 me-2">
            <button type="button" class="btn btn-dark" id="openTransactionsModal">
                Add Transaction
            </button>
        </div> --}}

        <!-- Transactions Modal -->
        {{-- <div class="modal fade" id="transactionsModal" tabindex="-1" aria-labelledby="transactionsModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="transactionsModalLabel">Transaction Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="transactionsForm">

                            <!-- Transaction 1 -->


                            <div class="mb-3">
                                <label for="transaction1_date" class="form-label">Date/Time</label>
                                <input type="datetime-local" class="form-control" id="transaction1_date" name="date_time[]"
                                    value="2025-11-04T14:30">
                            </div>

                            <div class="mb-3">
                                <label for="transaction1_teacher" class="form-label">Teacher</label>
                                <input type="text" class="form-control" id="transaction1_teacher" name="teacher[]"
                                    value="Mr. Ali">
                            </div>

                            <div class="mb-3">
                                <label for="transaction1_course" class="form-label">Course</label>
                                <input type="text" class="form-control" id="transaction1_course" name="course[]"
                                    value="Mathematics">
                            </div>

                            <div class="mb-3">
                                <label for="transaction1_session" class="form-label">Session</label>
                                <input type="text" class="form-control" id="transaction1_session" name="session[]"
                                    value="2025">
                            </div>

                            <div class="mb-3">
                                <label for="transaction1_student" class="form-label">Student</label>
                                <input type="text" class="form-control" id="transaction1_student" name="student[]"
                                    value="Ahmed">
                            </div>

                            <div class="mb-3">
                                <label for="transaction1_parent" class="form-label">Parent</label>
                                <input type="text" class="form-control" id="transaction1_parent" name="parent[]"
                                    value="Mr. Khan">
                            </div>

                            <div class="mb-3">
                                <label for="transaction1_total" class="form-label">Total</label>
                                <input type="number" class="form-control" id="transaction1_total" name="total[]"
                                    value="500" step="0.01">
                            </div>

                            <div class="mb-3">
                                <label for="transaction1_paid" class="form-label">Paid</label>
                                <input type="number" class="form-control" id="transaction1_paid" name="paid[]"
                                    value="200" step="0.01">
                            </div>

                            <div class="mb-3">
                                <label for="transaction1_remaining" class="form-label">Remaining</label>
                                <input type="number" class="form-control" id="transaction1_remaining"
                                    name="remaining[]" value="300" step="0.01">
                            </div>

                            <!-- You can duplicate the above block for more transactions -->

                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" form="transactionsForm">Save Changes</button>
                    </div>
                </div>
            </div>
        </div> --}}



        {{-- <div class="modal fade" id="transactionsModal" tabindex="-1" aria-labelledby="transactionsModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header bg-dark text-white rounded-top-4">
                        <h5 class="modal-title" id="transactionsModalLabel">Transaction Details</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="transactionsForm">
                            <!-- Transaction 1 -->



                            <div class="mb-3">
                                <label for="transaction1_teacher" class="form-label">Teacher</label>
                                <select class="form-select" id="transaction1_teacher" name="teacher">
                                    <option selected disabled>Select Teacher</option>
                                    @foreach ($teacher_datas as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->teacher_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="transaction1_course" class="form-label">Course</label>
                                <select class="form-select" id="transaction1_course" name="course">
                                    <option selected disabled>Select Course</option>
                                    @foreach ($subject_datas as $course)
                                        <option value="{{ $course->id }}">{{ $course->course_title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="transaction1_session" class="form-label">Session</label>
                                <select class="form-select" id="transaction1_session" name="session">
                                    <option selected disabled>Select Session</option>
                                    @foreach ($session_datas as $session)
                                        <option value="{{ $session->id }}">{{ $session->session_title }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-3">
                                <label for="transaction1_student" class="form-label">Student</label>
                                <input type="text" class="form-control" id="transaction1_student" name="student">
                            </div>

                            <div class="mb-3">
                                <label for="transaction1_parent" class="form-label">Parent</label>
                                <input type="text" class="form-control" id="transaction1_parent" name="parent">
                            </div>

                            <div class="mb-3">
                                <label for="transaction1_total" class="form-label">Total</label>
                                <input type="number" class="form-control" id="transaction1_total" name="total"
                                    step="0.01">
                            </div>

                            <div class="mb-3">
                                <label for="transaction1_paid" class="form-label">Paid</label>
                                <input type="number" class="form-control" id="transaction1_paid" name="paid"
                                    step="0.01">
                            </div>

                            <div class="mb-3">
                                <label for="transaction1_remaining" class="form-label">Remaining</label>
                                <input type="number" class="form-control" id="transaction1_remaining" name="remaining"
                                    step="0.01">
                            </div>

                            <!-- You can duplicate the above block for more transactions -->

                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-dark">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="modal fade" id="transactionsModal" tabindex="-1" aria-labelledby="transactionsModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header bg-dark text-white rounded-top-4">
                        <h5 class="modal-title" id="transactionsModalLabel">Transaction Details</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="transactionsForm">

                            @csrf

                            <!-- Teacher -->
                            <div class="mb-3">
                                <label class="form-label">Teacher</label>
                                <select class="form-select" name="teacher" id="transaction_teacher">
                                    <option selected disabled>Select Teacher</option>
                                    @foreach ($teacher_datas as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->teacher_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Course -->
                            <div class="mb-3">
                                <label class="form-label">Course</label>
                                <select class="form-select" name="course" id="transaction_course">
                                    <option selected disabled>Select Course</option>
                                    @foreach ($subject_datas as $course)
                                        <option value="{{ $course->id }}">{{ $course->course_title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Session -->
                            <div class="mb-3">
                                <label class="form-label">Session</label>
                                <select class="form-select" name="session" id="transaction_session">
                                    <option selected disabled>Select Session</option>
                                    @foreach ($session_datas as $session)
                                        <option value="{{ $session->id }}">{{ $session->session_title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Student -->
                            <div class="mb-3">
                                <label class="form-label">Student</label>
                                <input type="text" class="form-control" name="student_name" id="transaction_student">
                            </div>

                            <!-- Parent -->
                            <div class="mb-3">
                                <label class="form-label">Parent</label>
                                <input type="text" class="form-control" name="parent_name" id="transaction_parent">
                            </div>

                            <!-- Total -->
                            <div class="mb-3">
                                <label class="form-label">Total</label>
                                <input type="number" class="form-control" name="total" id="transaction_total"
                                    step="0.01">
                            </div>

                            <!-- Paid -->
                            <div class="mb-3">
                                <label class="form-label">Paid</label>
                                <input type="number" class="form-control" name="paid_amount" id="transaction_paid"
                                    step="0.01">
                            </div>

                            <!-- Remaining -->
                            <div class="mb-3">
                                <label class="form-label">Remaining</label>
                                <input type="number" class="form-control" name="remaining" id="transaction_remaining"
                                    step="0.01" readonly>
                            </div>

                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-dark">Save</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>



        <!-- Transactions Div -->
        <div id="transactionsDiv" class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <h5 class="fw-semibold mb-2 mb-md-0">Recent Transactions</h5>
                    <div class="d-flex gap-2 flex-wrap">
                        {{-- <button class="btn btn-dark btn-sm"><i class="fa-solid fa-plus me-1"></i> Add</button> --}}
                        <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal"
                            data-bs-target="#transactionsModal">
                            <i class="fa-solid fa-plus me-1"></i> Add
                        </button>
                        <button class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-filter me-1"></i>
                            Filter</button>
                        <button class="btn btn-outline-success btn-sm"><i class="fa-solid fa-file-export me-1"></i>
                            Export</button>
                        <button class="btn btn-outline-dark btn-sm"><i class="fa-solid fa-table-columns me-1"></i>
                            Columns</button>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-search"></i></span>
                    <input type="text" class="form-control border-start-0" id="searchInput" placeholder="Search...">
                </div>

                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-light" id="transactionsTableHead">
                            <tr>
                                <th>ID</th>
                                <th>Date/Time</th>
                                <th>Teacher</th>
                                <th>Course</th>
                                <th>Session</th>
                                <th>Student</th>
                                <th>Parent</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Remaining</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="transactionsTableBody">
                            <tr>
                                <td>1</td>
                                <td>10/7/2024, 4:45 PM</td>
                                <td>Prof. Sarah Johnson</td>
                                <td>A-Level Physics</td>
                                <td>May/June 2026</td>
                                <td>Emma Wilson</td>
                                <td>David Wilson</td>
                                <td>LE 120.00</td>
                                <td>LE 60.00</td>
                                <td>LE 60.00</td>
                                <td class="text-end"><button class="btn btn-sm btn-outline-danger"><i
                                            class="fa-solid fa-trash"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



        <!-- Payouts Div -->
        <div id="payoutsDiv" class="card border-0 shadow-sm" style="display: none;">
            <div class="card-body">
                <h5 class="fw-semibold mb-3">Payouts</h5>
                <div class="d-flex justify-content-end gap-2 mb-3">
                    <button class="btn btn-outline-success btn-sm"><i class="fa-solid fa-file-export me-1"></i>
                        Export</button>
                    <button class="btn btn-outline-dark btn-sm"><i class="fa-solid fa-table-columns me-1"></i>
                        Columns</button>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-search"></i></span>
                    <input type="text" class="form-control border-start-0" placeholder="Search...">
                </div>
            </div>
        </div>

        <!-- Balances Div -->
        <div id="balancesDiv" class="card border-0 shadow-sm" style="display: none;">
            <div class="card-body">
                <div id="teacherBalances">
                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                        <h5 class="fw-semibold mb-2 mb-md-0">Teacher Balances</h5>
                    </div>
                    <table class="table align-middle table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Teacher Name</th>
                                <th>Current Balance</th>
                                <th>Paid Before</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Dr. Ahmed Hassan</td>
                                <td>-LE 11,500.00</td>
                                <td>LE 15,000.00</td>
                                <td><button class="btn btn-sm btn-outline-danger"><i
                                            class="fa-solid fa-trash"></i></button></td>
                            </tr>
                            <tr>
                                <td>Prof. Sarah Johnson</td>
                                <td>-LE 218.00</td>
                                <td>LE 400.00</td>
                                <td><button class="btn btn-sm btn-outline-danger"><i
                                            class="fa-solid fa-trash"></i></button></td>
                            </tr>
                            <tr>
                                <td>Dr. Mohamed Ali</td>
                                <td>LE 52.50</td>
                                <td>LE 0.00</td>
                                <td><button class="btn btn-sm btn-outline-danger"><i
                                            class="fa-solid fa-trash"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="platformBalances" style="display: none;">
                    <h5 class="fw-semibold mb-3">Platform Balances</h5>
                    <div class="row">
                        <div class="card col-md-6 w-40 h-70">hello</div>
                        <div class="card col-md-6 w-40 h-70">hi</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ✅ Reports Div -->
        <div id="reportsDiv" class="card border-0 shadow-sm" style="display:none;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <h5 class="fw-semibold mb-2 mb-md-0">Platform Reports</h5>
                    <div class="d-flex gap-2 flex-wrap">
                        <button class="btn btn-dark btn-sm"><i class="fa-solid fa-plus me-1"></i> Add</button>
                        <button class="btn btn-outline-success btn-sm"><i class="fa-solid fa-file-export me-1"></i>
                            Export</button>
                        <button class="btn btn-outline-dark btn-sm"><i class="fa-solid fa-table-columns me-1"></i>
                            Columns</button>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-search"></i></span>
                    <input type="text" class="form-control border-start-0" placeholder="Search...">
                </div>

                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Teacher</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>From Date</th>
                                <th>To Date</th>
                                <th>Created</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>



                            <tr>
                                <td>1</td>
                                <td>Dr. Ahmed Hassan</td>
                                <td>October 2024 Transactions Report</td>
                                <td>Recent</td>
                                <td>2024-10-01</td>
                                <td>2024-10-31</td>
                                <td>10/8/2024, 3:00:00 PM</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-danger"><i
                                            class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Platform</td>
                                <td>Platform Revenue Report - Q3 2024</td>
                                <td>Platform</td>
                                <td>2024-07-01</td>
                                <td>2024-09-30</td>
                                <td>10/1/2024, 10:00:00 AM</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-danger"><i
                                            class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- Restore Modal -->
    {{-- <div class="modal fade" id="restoreModal" tabindex="-1" aria-labelledby="restoreModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">

                <div class="modal-header border-0">
                    <h5 class="modal-title" id="restoreModalLabel">
                        <i class="bi bi-arrow-counterclockwise me-2"></i> Restore Transaction
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="restoreTransactionId">


                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Total</label>
                            <input type="number" class="form-control" readonly>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Paid amount</label>
                            <input type="number" id="restorePaid" class="form-control" readonly>
                        </div>
                    </div>



                    <div class="mb-3">
                        <label class="form-label">Paid Amount</label>
                        <input type="number" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label"></label>
                        <input type="number" id="restoreRemaining" class="form-control" readonly>
                    </div>
                </div>

                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-dark btn-sm" id="confirmRestore">
                        <i class="bi bi-check-circle"></i> Restore
                    </button>
                </div>

            </div>
        </div>
    </div> --}}
    {{-- <div class="modal fade" id="restoreModal" tabindex="-1" aria-labelledby="restoreModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">

                <div class="modal-header border-0">
                    <h5 class="modal-title" id="restoreModalLabel">
                        <i class="bi bi-arrow-counterclockwise me-2"></i> Restore Transaction
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                    <form action="" method="post">
                <div class="modal-body">
                    <form>
                    <input type="hidden" id="restoreTransactionId">

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Total</label>
                            <input type="number" id="restoreTotal" class="form-control" readonly>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Paid amount</label>
                            <input type="number" id="restorePaidReadonly" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pay new amount</label>
                        <input type="number" id="restorePaid" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Remaining</label>
                        <input type="number" id="restoreRemaining" class="form-control" readonly>
                    </div>
                </div>

                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-dark btn-sm" id="confirmRestore">
                        <i class="bi bi-check-circle"></i> Recover amounts
                    </button>
                </div>
                 </form>
            </div>
        </div>
    </div> --}}

    {{-- <div class="modal fade" id="restoreModal" tabindex="-1" aria-labelledby="restoreModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <form id="restoreForm" method="post">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="restoreModalLabel">
                            <i class="bi bi-arrow-counterclockwise me-2"></i> Restore Transaction
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" id="restoreTransactionId">

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Total</label>
                                <input type="number" id="restoreTotal" class="form-control" readonly>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Paid amount</label>
                                <input type="number" id="restorePaidReadonly" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pay new amount</label>
                            <input type="number" id="restorePaid" name="new_paid" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Remaining</label>
                            <input type="number" id="restoreRemaining" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="modal-footer border-0 justify-content-center">
                        <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-dark btn-sm" id="confirmRestore">
                            <i class="bi bi-check-circle"></i> Recover amounts
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}

    <div class="modal fade" id="restoreModal" tabindex="-1" aria-labelledby="restoreModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">

                <div class="modal-header border-0">
                    <h5 class="modal-title" id="restoreModalLabel">
                        <i class="bi bi-arrow-counterclockwise me-2"></i> Restore Transaction
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="restoreForm">
                    <div class="modal-body">
                        <input type="hidden" id="restoreTransactionId">

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Total</label>
                                <input type="number" id="restoreTotal" class="form-control" readonly>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Paid amount</label>
                                <input type="number" id="restorePaidReadonly" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pay new amount</label>
                            <input type="number" id="restorePaid" class="form-control" min="0">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Remaining</label>
                            <input type="number" id="restoreRemaining" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="modal-footer border-0 justify-content-center">
                        <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-dark btn-sm">
                            <i class="bi bi-check-circle"></i> Recover amounts
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ======= TAB LOGIC =======
            const mainTabs = document.querySelectorAll('#mainTabContainer .tab-btn');
            const subRecent = document.getElementById('sub-recent');
            const subPerCourse = document.getElementById('sub-percourse');
            const balanceTeacher = document.getElementById('balance-teacher');
            const balancePlatform = document.getElementById('balance-platform');
            const tableHead = document.getElementById('transactionsTableHead');
            const tableBody = document.getElementById('transactionsTableBody');

            const perCourseHead = `
<tr>
<th>Course Name</th>
<th>Session</th>
<th>Transactions</th>
<th>Total Amount</th>
<th>Total Paid</th>
<th>Total Remaining</th>
<th>Actions</th>
</tr>`;

            function resetSubTabs() {
                subRecent.style.display = 'none';
                subPerCourse.style.display = 'none';
                balanceTeacher.style.display = 'none';
                balancePlatform.style.display = 'none';
            }

            mainTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    mainTabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    const target = this.dataset.target;
                    ['transactionsDiv', 'payoutsDiv', 'balancesDiv', 'reportsDiv'].forEach(
                        id => document.getElementById(id).style.display = id === target ?
                        'block' : 'none'
                    );

                    resetSubTabs();

                    if (target === 'transactionsDiv') {
                        subRecent.style.display = 'inline-block';
                        subPerCourse.style.display = 'inline-block';
                        subRecent.click();
                    } else if (target === 'balancesDiv') {
                        balanceTeacher.style.display = 'inline-block';
                        balancePlatform.style.display = 'inline-block';
                        balanceTeacher.click();
                    }
                });
            });

            // ======= SUB-TAB EVENTS =======
            subRecent.addEventListener('click', function() {
                subRecent.classList.add('active');
                subPerCourse.classList.remove('active');

                tableHead.innerHTML = `
<tr>
<th>ID</th>
<th>Date/Time</th>
<th>Teacher</th>
<th>Course</th>
<th>Session</th>
<th>Student</th>
<th>Parent</th>
<th>Total</th>
<th>Paid</th>
<th>Remaining</th>
<th class="text-end">Actions</th>
</tr>`;
                loadPlatformTransactions();
            });

            subPerCourse.addEventListener('click', function() {
                subPerCourse.classList.add('active');
                subRecent.classList.remove('active');
                tableHead.innerHTML = perCourseHead;
                tableBody.innerHTML = "";
            });

            // ======= LOAD TRANSACTIONS =======
            function loadPlatformTransactions() {
                fetch("{{ route('platform_transactions.index') }}")
                    .then(res => res.json())
                    .then(res => {
                        if (res.status !== "success") {
                            toastr.error("Failed to load transactions");
                            return;
                        }

                        const data = res.data;
                        tableBody.innerHTML = "";

                        data.forEach(row => {
                            const remaining = row.remaining ?? (row.total - row.paid_amount);

                            tableBody.insertAdjacentHTML('beforeend', `
<tr>
<td>${row.id}</td>
<td>${row.created_at}</td>
<td>${row.teacher?.teacher_name ?? '-'}</td>
<td>${row.course?.course_title ?? '-'}</td>
<td>${row.session?.session_title ?? '-'}</td>
<td>${row.student_name ?? '-'}</td>
<td>${row.parent_name ?? '-'}</td>
<td>${row.total ?? 0}</td>
<td>${row.paid_amount ?? 0}</td>
<td>${remaining.toFixed(2)}</td>

<td class="text-end">
      <button class="btn btn-sm icon-btn restore-btn"
        data-id="${row.id}"
        data-total="${row.total}"
        data-paid="${row.paid_amount}"
        data-remaining="${remaining}">
        <i class="bi bi-arrow-counterclockwise"></i>
    </button>

    <button class="btn btn-sm icon-btn text-danger delete-btn">
        <i class="bi bi-trash3-fill"></i>
    </button>
</td>

</tr>`);
                        });

                        toastr.success(res.message);
                    })
                    .catch(() => toastr.error("Error fetching transaction data"));
            }

            // Initial load
            loadPlatformTransactions();

        });
    </script> --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // ================= TRANSACTIONS TABLE & TAB LOGIC =================
            const mainTabs = document.querySelectorAll('#mainTabContainer .tab-btn');
            const subRecent = document.getElementById('sub-recent');
            const subPerCourse = document.getElementById('sub-percourse');
            const balanceTeacher = document.getElementById('balance-teacher');
            const balancePlatform = document.getElementById('balance-platform');
            const tableHead = document.getElementById('transactionsTableHead');
            const tableBody = document.getElementById('transactionsTableBody');

            const perCourseHead = `
<tr>
<th>Course Name</th>
<th>Session</th>
<th>Transactions</th>
<th>Total Amount</th>
<th>Total Paid</th>
<th>Total Remaining</th>
<th>Actions</th>
</tr>`;

            function resetSubTabs() {
                subRecent.style.display = 'none';
                subPerCourse.style.display = 'none';
                balanceTeacher.style.display = 'none';
                balancePlatform.style.display = 'none';
            }

            mainTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    mainTabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    const target = this.dataset.target;
                    ['transactionsDiv', 'payoutsDiv', 'balancesDiv', 'reportsDiv'].forEach(
                        id => document.getElementById(id).style.display = id === target ?
                        'block' : 'none'
                    );

                    resetSubTabs();

                    if (target === 'transactionsDiv') {
                        subRecent.style.display = 'inline-block';
                        subPerCourse.style.display = 'inline-block';
                        subRecent.click();
                    } else if (target === 'balancesDiv') {
                        balanceTeacher.style.display = 'inline-block';
                        balancePlatform.style.display = 'inline-block';
                        balanceTeacher.click();
                    }
                });
            });

            subRecent.addEventListener('click', function() {
                subRecent.classList.add('active');
                subPerCourse.classList.remove('active');

                tableHead.innerHTML = `
<tr>
<th>ID</th>
<th>Date/Time</th>
<th>Teacher</th>
<th>Course</th>
<th>Session</th>
<th>Student</th>
<th>Parent</th>
<th>Total</th>
<th>Paid</th>
<th>Remaining</th>
<th class="text-end">Actions</th>
</tr>`;
                loadPlatformTransactions();
            });

            subPerCourse.addEventListener('click', function() {
                subPerCourse.classList.add('active');
                subRecent.classList.remove('active');
                tableHead.innerHTML = perCourseHead;
                tableBody.innerHTML = "";
            });

            // ================= LOAD TRANSACTIONS =================
            function loadPlatformTransactions() {
                fetch("{{ route('platform_transactions.index') }}")
                    .then(res => res.json())
                    .then(res => {
                        if (res.status !== "success") {
                            toastr.error("Failed to load transactions");
                            return;
                        }

                        const data = res.data;
                        tableBody.innerHTML = "";

                        data.forEach(row => {
                            const remaining = row.remaining ?? (row.total - row.paid_amount);

                            tableBody.insertAdjacentHTML('beforeend', `
<tr>
<td>${row.id}</td>
<td>${row.created_at}</td>
<td>${row.teacher?.teacher_name ?? '-'}</td>
<td>${row.course?.course_title ?? '-'}</td>
<td>${row.session?.session_title ?? '-'}</td>
<td>${row.student_name ?? '-'}</td>
<td>${row.parent_name ?? '-'}</td>
<td>${row.total ?? 0}</td>
<td>${row.paid_amount ?? 0}</td>
<td>${remaining.toFixed(2)}</td>

<td class="text-end">
    <button class="btn btn-sm icon-btn restore-btn"
        data-id="${row.id}"
        data-total="${row.total}"
        data-paid="${row.paid_amount}"
        data-remaining="${remaining}">
        <i class="bi bi-arrow-counterclockwise"></i>
    </button>

    <button class="btn btn-sm icon-btn text-danger delete-btn">
        <i class="bi bi-trash3-fill"></i>
    </button>
</td>
</tr>`);
                        });
                    })
                    .catch(() => toastr.error("Error fetching transaction data"));
            }

            // Initial load
            loadPlatformTransactions();

            // ================= TRANSACTION MODAL SUBMISSION =================
            const transactionForm = document.getElementById("transactionsForm");
            const totalInput = document.getElementById("transaction_total");
            const paidInput = document.getElementById("transaction_paid");
            const remainingInput = document.getElementById("transaction_remaining");

            function calculateRemaining() {
                let total = parseFloat(totalInput.value) || 0;
                let paid = parseFloat(paidInput.value) || 0;
                remainingInput.value = (total - paid >= 0 ? (total - paid).toFixed(2) : 0);
            }

            totalInput.addEventListener("input", calculateRemaining);
            paidInput.addEventListener("input", calculateRemaining);

            transactionForm.addEventListener("submit", function(e) {
                e.preventDefault();
                let formData = new FormData(transactionForm);

                fetch("{{ route('platform_transaction.store') }}", {
                        method: "POST",
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === "success") {
                            toastr.success(data.message || "Transaction Saved Successfully");

                            transactionForm.reset();
                            remainingInput.value = "";

                            const modalCloseBtn = document.querySelector(
                                '#transactionsModal .btn-close');
                            if (modalCloseBtn) modalCloseBtn.click();

                            // 🔹 Refresh table immediately
                            loadPlatformTransactions();
                        } else {
                            toastr.error(data.message || "Something went wrong");
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        toastr.error("Error submitting transaction");
                    });
            });

            // ================= RESTORE BUTTON MODAL =================
            const restoreModalEl = document.getElementById('restoreModal');
            const restoreModal = new bootstrap.Modal(restoreModalEl);

            document.body.addEventListener('click', function(e) {
                const btn = e.target.closest('.restore-btn');
                if (!btn) return;

                const id = btn.dataset.id;
                const total = parseFloat(btn.dataset.total) || 0;
                const paid = parseFloat(btn.dataset.paid) || 0;

                document.getElementById('restoreTransactionId').value = id;
                document.getElementById('restoreTotal').value = total;
                document.getElementById('restorePaidReadonly').value = paid;
                document.getElementById('restorePaid').value = 0;
                document.getElementById('restoreRemaining').value = total - paid;

                restoreModal.show();
            });

            document.getElementById('restorePaid').addEventListener('input', function() {
                const total = parseFloat(document.getElementById('restoreTotal').value) || 0;
                const paidReadonly = parseFloat(document.getElementById('restorePaidReadonly').value) || 0;
                let newPaid = parseFloat(this.value) || 0;

                if (newPaid < 0) newPaid = 0;
                if (newPaid > total - paidReadonly) newPaid = total - paidReadonly;
                this.value = newPaid;

                document.getElementById('restoreRemaining').value = (total - paidReadonly - newPaid)
                    .toFixed(2);
            });

            document.getElementById('restoreForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const transactionId = document.getElementById('restoreTransactionId').value;
                const newPaid = parseFloat(document.getElementById('restorePaid').value) || 0;

                fetch(`/platform/transactions/${transactionId}/restore`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            new_paid: newPaid
                        })
                    })
                    .then(res => res.json())
                    .then(res => {
                        if (res.status === 'success') {
                            toastr.success(res.message || "Transaction restored successfully");

                            restoreModal.hide();

                            // 🔹 Refresh table immediately
                            loadPlatformTransactions();
                        } else {
                            toastr.error(res.message || "Failed to update transaction");
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        toastr.error('Error updating transaction');
                    });
            });

        });
    </script>



    <!-- Restore Modal -->






    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const restoreModalEl = document.getElementById('restoreModal');
            const restoreModal = new bootstrap.Modal(restoreModalEl);
            const restoreForm = document.getElementById('restoreForm');

            const restoreTransactionId = document.getElementById('restoreTransactionId');
            const restoreTotal = document.getElementById('restoreTotal');
            const restorePaidReadonly = document.getElementById('restorePaidReadonly');
            const restorePaid = document.getElementById('restorePaid');
            const restoreRemaining = document.getElementById('restoreRemaining');

            let isSubmitting = false;

            // Function to calculate remaining
            function updateRemaining() {
                const total = parseFloat(restoreTotal.value) || 0;
                const paidReadonly = parseFloat(restorePaidReadonly.value) || 0;
                let newPaid = parseFloat(restorePaid.value) || 0;

                if (newPaid < 0) newPaid = 0;
                if (newPaid > total - paidReadonly) newPaid = total - paidReadonly;

                restorePaid.value = newPaid;
                restoreRemaining.value = (total - paidReadonly - newPaid).toFixed(2);
            }

            // Only attach input listener once
            restorePaid.addEventListener('input', updateRemaining);

            // Open modal and populate data
            document.body.addEventListener('click', function(e) {
                const btn = e.target.closest('.restore-btn');
                if (!btn) return;

                const id = btn.dataset.id;
                const total = parseFloat(btn.dataset.total) || 0;
                const paid = parseFloat(btn.dataset.paid) || 0;

                restoreTransactionId.value = id;
                restoreTotal.value = total;
                restorePaidReadonly.value = paid;
                restorePaid.value = 0;
                restoreRemaining.value = (total - paid).toFixed(2);

                restoreModal.show();
            });

            // Reset modal on close
            restoreModalEl.addEventListener('hidden.bs.modal', function() {
                restoreForm.reset();
                restoreRemaining.value = '';
                isSubmitting = false;
                document.body.classList.remove('modal-open');
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            });

            // Submit form — only once
            restoreForm.addEventListener('submit', function(e) {
                e.preventDefault();
                if (isSubmitting) return;

                isSubmitting = true;
                const submitBtn = restoreForm.querySelector('button[type="submit"]');
                submitBtn.disabled = true;

                const transactionId = restoreTransactionId.value;
                const newPaidValue = parseFloat(restorePaid.value) || 0;
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                    'content') || '';

                fetch(`/platform/transactions/${transactionId}/restore`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            new_paid: newPaidValue
                        })
                    })
                    .then(res => res.json())
                    .then(res => {
                        submitBtn.disabled = false;
                        isSubmitting = false;
                        restoreModal.hide();

                        // ✅ Single toast
                        if (typeof toastr !== 'undefined') {
                            toastr.clear();
                            setTimeout(() => {
                                if (res.status === 'success') {
                                    toastr.success(res.message ||
                                        'Transaction updated successfully');
                                } else {
                                    toastr.error(res.message || 'Failed to update transaction');
                                }
                            }, 50);
                        }

                        if (res.status === 'success' && res.data) {
                            const updated = res.data;

                            // 🔹 Update modal row if exists
                            const modalRow = document.querySelector(
                            `#transaction-row-${transactionId}`);
                            if (modalRow) {
                                const paidCell = modalRow.querySelector('.paid-amount');
                                const remainingCell = modalRow.querySelector('.remaining-amount');
                                const restoreBtn = modalRow.querySelector('.restore-btn');

                                if (paidCell) paidCell.textContent = parseFloat(updated.paid_amount)
                                    .toFixed(2);
                                if (remainingCell) remainingCell.textContent = (parseFloat(updated
                                    .total) - parseFloat(updated.paid_amount)).toFixed(2);
                                if (restoreBtn) restoreBtn.dataset.paid = updated.paid_amount;
                            }

                            // 🔹 Update other tables if needed
                            const otherRows = document.querySelectorAll(
                                `[data-transaction-id="${transactionId}"]`);
                            otherRows.forEach(row => {
                                const paidCell = row.querySelector('.paid-amount');
                                const remainingCell = row.querySelector('.remaining-amount');

                                if (paidCell) paidCell.textContent = parseFloat(updated
                                    .paid_amount).toFixed(2);
                                if (remainingCell) remainingCell.textContent = (parseFloat(
                                        updated.total) - parseFloat(updated.paid_amount))
                                    .toFixed(2);
                            });
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        submitBtn.disabled = false;
                        isSubmitting = false;
                        restoreModal.hide();

                        if (typeof toastr !== 'undefined') {
                            toastr.clear();
                            setTimeout(() => toastr.error('Something went wrong. Please try again.'),
                                50);
                        }
                    });
            });

        });
    </script>

    <!-- ✅ Open Modal Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const transactionsModal = new bootstrap.Modal(document.getElementById('transactionsModal'));
            document.getElementById('openTransactionsModal').addEventListener('click', function() {
                transactionsModal.show();
            });
        });
    </script>


    <!-- ✅ Store Modal Form -->

    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {

            const form = document.getElementById("transactionsForm");
            const totalInput = document.getElementById("transaction_total");
            const paidInput = document.getElementById("transaction_paid");
            const remainingInput = document.getElementById("transaction_remaining");

            function calculateRemaining() {
                let total = parseFloat(totalInput.value) || 0;
                let paid = parseFloat(paidInput.value) || 0;
                let remaining = total - paid;
                remainingInput.value = remaining >= 0 ? remaining.toFixed(2) : 0;
            }

            totalInput.addEventListener("input", calculateRemaining);
            paidInput.addEventListener("input", calculateRemaining);

            // Use a function so we can attach it every time modal opens
            function attachFormSubmit() {
                form.addEventListener("submit", function submitHandler(e) {
                    e.preventDefault();

                    let formData = new FormData(form);

                    fetch("{{ route('platform_transaction.store') }}", {
                            method: "POST",
                            body: formData,
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status == "success") {
                                if (typeof toastr !== "undefined") {
                                    toastr.success(data.message || "Transaction Saved Successfully");
                                }

                                form.reset();
                                remainingInput.value = "";

                                // Close modal
                                const modalCloseBtn = document.querySelector(
                                    '#transactionsModal .btn-close');
                                if (modalCloseBtn) modalCloseBtn.click();

                            } else {
                                if (typeof toastr !== "undefined") {
                                    toastr.error(data.message || "Something went wrong");
                                }
                            }
                        })
                        .catch(err => console.log(err));

                    // Remove this listener after submission to prevent multiple bindings
                    form.removeEventListener("submit", submitHandler);
                });
            }

            // Attach listener initially
            attachFormSubmit();

            // Reattach submit listener every time modal opens (for multiple submissions)
            const transactionsModal = document.getElementById('transactionsModal');
            transactionsModal.addEventListener('shown.bs.modal', function() {
                attachFormSubmit();
            });

            // Reset form on modal close
            transactionsModal.addEventListener('hidden.bs.modal', function() {
                form.reset();
                remainingInput.value = "";
            });

        });
    </script> --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const form = document.getElementById("transactionsForm");
            const totalInput = document.getElementById("transaction_total");
            const paidInput = document.getElementById("transaction_paid");
            const remainingInput = document.getElementById("transaction_remaining");
            const transactionsModal = document.getElementById('transactionsModal');

            function calculateRemaining() {
                let total = parseFloat(totalInput.value) || 0;
                let paid = parseFloat(paidInput.value) || 0;
                let remaining = total - paid;
                remainingInput.value = remaining >= 0 ? remaining.toFixed(2) : 0;
            }

            totalInput.addEventListener("input", calculateRemaining);
            paidInput.addEventListener("input", calculateRemaining);

            // ✅ Attach submit listener only once
            if (!form.dataset.listener) {
                form.dataset.listener = "true";

                form.addEventListener("submit", function(e) {
                    e.preventDefault();

                    let formData = new FormData(form);

                    fetch("{{ route('platform_transaction.store') }}", {
                            method: "POST",
                            body: formData,
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status == "success") {
                                // ✅ Only Toastr, no alert
                                if (typeof toastr !== "undefined") {
                                    toastr.success(data.message || "Transaction Saved Successfully");
                                }

                                form.reset();
                                remainingInput.value = "";

                                // Close modal
                                const modalCloseBtn = document.querySelector(
                                    '#transactionsModal .btn-close');
                                if (modalCloseBtn) modalCloseBtn.click();

                            } else {
                                if (typeof toastr !== "undefined") {
                                    toastr.error(data.message || "Something went wrong");
                                }
                            }
                        })
                        .catch(err => console.log(err));
                });
            }

            // Reset form on modal close
            transactionsModal.addEventListener('hidden.bs.modal', function() {
                form.reset();
                remainingInput.value = "";
            });

        });
    </script>
@endsection
