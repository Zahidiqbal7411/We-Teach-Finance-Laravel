@extends('layouts.app')

@section('contents')
    <div class="main-content p-4" style="margin-left: 260px; min-height: 100vh; background: #f8f9fa;">

        <!-- ✅ Top Bar -->





        <div class="teacher-topbar d-flex justify-content-between align-items-center mb-4 p-3"
            style="background: #ffffff; border-radius: 10px;">
            <div>
                <h4 class="fw-semibold mb-0">Platform</h4>
            </div>
            <div class="d-flex align-items-center gap-3">

                <!-- Session / Year Dropdown -->
                <select class="form-select form-select-md" id="SelectYear">
                    @foreach ($session_datas as $session_data)
                        <option value="{{ $session_data->id }}"
                            {{ request()->get('session_id') == $session_data->id ? 'selected' : '' }}>
                            {{ $session_data->session_title }}
                        </option>
                    @endforeach
                </select>

                <!-- Currency Dropdown -->


                <label class="form-label">Default Currency</label>
                <select class="form-select form-select-md w-25" name="default_currency" id="currencySelect">
                    @foreach ($currency_datas as $currency_data)
                        <option value="{{ $currency_data->id }}"
                            {{ $currency_data->id == $selected_currency_id ? 'selected' : '' }}>
                            {{ $currency_data->currency_name }}
                        </option>
                    @endforeach
                </select>






                <div id="currencyResponseMsg" class="mt-2"></div>

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
                            <h5 class="fw-bold text-success mb-0" id="platformBalance">0.00</h5>
                            <small class="text-muted">Platform revenue (30% share)</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-wrapper me-3">
                            {{-- <i class="fa-solid fa-dollar-sign fa-lg text-primary"></i> --}}
                        </div>
                        <div>
                            <p class="text-muted small mb-1">Total Revenue</p>
                            <h5 class="fw-bold text-primary mb-0" id="total_revenue">0.00
                            </h5>
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
                            <h5 class="fw-bold text-purple mb-0" id="withdrawn_balance">0.00</h5>
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
                            {{-- <div class="mb-3">
                            <label class="form-label">Currency</label>
                            <input type="text" class="form-control" value="{{ $current_currency->currency_name }}"
                                name="parent_name" id="transaction_parent" readonly>

                            <!-- Hidden input to hold the currency ID -->
                            <input type="hidden" name="selected_currency_id" value="{{ $current_currency->id }}">
                        </div> --}}
                            <div class="mb-3">
                                <label class="form-label">Currency</label>
                                <input type="text" class="form-control text-start"
                                    value="{{ $selectedCurrency->currency_name ?? '' }}" name="current_currency"
                                    id="current_currency" readonly>

                                <!-- Hidden input to hold the currency ID -->
                                <input type="hidden" name="selected_currency_id" id="selected_currency_id"
                                    value="{{ $selected_currency_id ?? '' }}">
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
                        {{-- <button class="btn btn-outline-danger btn-sm">
                            <i class="fa-solid fa-file-export me-1"></i> Export PDF
                        </button>

                        <button class="btn btn-outline-success btn-sm">
                            <i class="fa-solid fa-file-export me-1"></i> Export Excel
                        </button>

                        <button class="btn btn-outline-dark btn-sm">
                            <i class="fa-solid fa-table-columns me-1"></i> Columns
                        </button> --}}
                        <button id="exportPdfBtn" class="btn btn-outline-danger btn-sm">
                            <i class="fa-solid fa-file-export me-1"></i> Export PDF
                        </button>
                        <button id="exportExcelBtn" class="btn btn-outline-success btn-sm">
                            <i class="fa-solid fa-file-export me-1"></i> Export Excel
                        </button>
                        <button id="columnsBtn" class="btn btn-outline-dark btn-sm">
                            <i class="fa-solid fa-table-columns me-1"></i> Columns
                        </button>


                    </div>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-search"></i></span>
                    <input type="text" class="form-control border-start-0" id="transactionsSearchInput"
                        placeholder="Search...">
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
                                <th>Total Revenue</th>
                                <th>Paid</th>
                                <th>Remaining</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="transactionsTableBody">

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
                    <button class="btn btn-outline-success btn-sm" id="exportPayoutPdf"><i
                            class="fa-solid fa-file-export me-1"></i> Export PDF</button>
                    <button class="btn btn-outline-success btn-sm" id="exportPayoutExcel"><i
                            class="fa-solid fa-file-export me-1"></i> Export Excel</button>
                    <button class="btn btn-outline-dark btn-sm" id="SelectYear" data-bs-toggle="modal"
                        data-bs-target="#columnsModal"><i class="fa-solid fa-table-columns me-1"></i> Columns</button>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-search"></i></span>
                    <input type="text" id="payoutsSearchInput" class="form-control border-start-0"
                        placeholder="Search...">
                </div>


                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-light" id="payoutsTableHead">
                            <tr>
                                <th>Date/Time</th>
                                <th>Teacher</th>
                                <th>Course</th>
                                <th>Session</th>
                                <th>Student</th>
                                <th>Parent</th>
                                <th>Paid</th>
                                <th>Remarks</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="payoutsTableBody">
                            <!-- Data will be populated here -->
                        </tbody>
                    </table>
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
                                <th>Total Revenue</th>
                                <th>Total Platform Share</th>
                                <th>Total Platform Paid </th>
                                <th>Total Platform Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Dr. Ahmed Hassan</td>
                                <td>-LE 11,500.00</td>
                                <td>LE 15,000.00</td>
                                <td><button class="btn btn-sm btn-outline-danger"><i
                                            class="fa-solid fa-trash"></i></button>
                                </td>
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




                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- Restore Modal -->


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
                        <div class="mb-3">
                            <label class="form-label">Remarks</label>
                            <textarea id="restoreRemarks" class="form-control" rows="3"></textarea>
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


    <div class="modal fade" id="columnsModal" tabindex="-1" aria-labelledby="columnsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="columnsModalLabel">Select Columns to Display</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="columnsCheckboxes"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="applyColumnsBtn">Apply</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="columnsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Columns</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="columnsForm"></form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="applyColumns">Apply</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // ============================================================================
        // SCRIPT 1: TABLE MANAGEMENT & DATA HANDLING
        // File: table-manager.js
        // PRESERVES ALL ORIGINAL LOGIC
        // ============================================================================

        document.addEventListener("DOMContentLoaded", function() {

            // ================= TRANSACTIONS TABLE & TAB LOGIC =================
            const mainTabs = document.querySelectorAll('#mainTabContainer .tab-btn');
            const subRecent = document.getElementById('sub-recent');
            const subPerCourse = document.getElementById('sub-percourse');
            const balanceTeacher = document.getElementById('balance-teacher');
            const balancePlatform = document.getElementById('balance-platform');
            const tableHead = document.getElementById('transactionsTableHead');
            const tableBody = document.getElementById('transactionsTableBody');
            const selectYear = document.getElementById('SelectYear');
            // Get the balances main tab button
            const balancesTabBtn = document.querySelector('button.tab-btn[data-target="balancesDiv"]');

            const perCourseHead = `
                <tr>
                <th data-column="course_name">Course Name</th>
                <th data-column="session">Session</th>
                <th data-column="transactions">Transactions</th>
                <th data-column="total_amount">Total Amount</th>
                <th data-column="platform_amount">Platform Amount</th>
                <th data-column="total_paid">Total Paid</th>
                <th data-column="total_remaining">Total Remaining</th>
                <th data-column="actions">Actions</th>
                </tr>`;

            // Store data for exports
            window.tableState = {
                currentTableData: [],
                currentColumns: [],
                selectedColumns: [],
                currentDataSource: 'recent'
            };

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
                        balanceTeacher.style.display = 'none';
                        balancePlatform.style.display = 'none';
                        balanceTeacher.click();
                    } else if (target === 'payoutsDiv') {
                        // Fetch payouts data when Payouts tab is clicked
                        fetchPayoutsData();
                    }
                });
            });

            // Function to fetch payouts data
            function fetchPayoutsData() {
                const sessionId = selectYear.value; // Assuming selectYear is your session select element

                const payoutsTableBody = document.getElementById('payoutsTableBody');

                if (!sessionId) {
                    payoutsTableBody.innerHTML =
                        '<tr><td colspan="9" class="text-center text-warning">Please select a session first</td></tr>';
                    return;
                }

                // Show loading state
                payoutsTableBody.innerHTML = '<tr><td colspan="9" class="text-center">Loading...</td></tr>';

                const payoutsUrl = "{{ route('payouts.data', ['session_id' => ':sessionId']) }}".replace(
                    ':sessionId', sessionId);

                fetch(payoutsUrl)
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        payoutsTableBody.innerHTML = '';

                        if (data.success && data.data.length > 0) {
                            appendPayoutsData(data.data);
                        } else if (data.success && data.data.length === 0) {
                            payoutsTableBody.innerHTML =
                                '<tr><td colspan="9" class="text-center">No payouts found for this session</td></tr>';
                        } else {
                            payoutsTableBody.innerHTML =
                                `<tr><td colspan="9" class="text-center text-danger">${data.message}</td></tr>`;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching payouts:', error);
                        payoutsTableBody.innerHTML =
                            '<tr><td colspan="9" class="text-center text-danger">Error loading data</td></tr>';
                    });
            }

            // Append payouts to table
            function appendPayoutsData(payouts) {
                const payoutsTableBody = document.getElementById('payoutsTableBody');

                payouts.forEach(payout => {
                    const row = document.createElement('tr');
                    const dateTime = new Date(payout.date_time).toLocaleString();
                    const teacherName = payout.teacher_name || '-';
                    const courseName = payout.course_name || '-';
                    const sessionName = payout.session_name || '-';
                    const studentName = payout.student_name || '-';
                    const parentName = payout.parent_name || '-';
                    const paidAmount = `${parseFloat(payout.paid_amount ?? payout.paid).toFixed(2)}`;
                    const currency = payout.currency_name || '';
                    const remarks = payout.remarks || '-';

                    row.innerHTML = `
                    <td data-column="date_time">${dateTime}</td>
                    <td data-column="teacher">${teacherName}</td>
                    <td data-column="course">${courseName}</td>
                    <td data-column="session">${sessionName}</td>
                    <td data-column="student">${studentName}</td>
                    <td data-column="parent">${parentName}</td>
                    <td data-column="paid">${paidAmount} (${currency})</td>
                    <td data-column="remarks">${remarks}</td>
                    <td data-column="actions" class="text-end">
                        <button class="btn btn-sm btn-outline-danger delete-payout" data-id="${payout.id}">
                            <i class="fa-solid fa-trash me-1"></i>Delete
                        </button>
                    </td>
                `;

                    payoutsTableBody.appendChild(row);
                });

                // Attach event listeners to Delete buttons
                document.querySelectorAll('.delete-payout').forEach(button => {
                    button.addEventListener('click', function() {
                        const payoutId = this.dataset.id;
                        deletePayout(payoutId);
                    });
                });
            }


            function deletePayout(payoutId) {
                if (!confirm('Are you sure you want to delete this payout?')) return;

                fetch(`/payouts/delete/${payoutId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Payout deleted successfully.');
                            fetchPayoutsData(); // Refresh the table
                        } else {
                            alert('Failed to delete payout: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting payout:', error);
                        alert('Something went wrong.');
                    });
            }




            // Optional: Add search functionality
            const payoutsSearchInput = document.querySelector('#payoutsDiv input[type="text"]');
            if (payoutsSearchInput) {
                payoutsSearchInput.addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase();
                    const rows = document.querySelectorAll('#payoutsTableBody tr');

                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                });
            }

            // Optional: Refresh payouts when session changes
            selectYear.addEventListener('change', function() {
                // If payouts tab is currently active, refresh the data
                const payoutsTab = document.querySelector('.tab-btn[data-target="payoutsDiv"]');
                if (payoutsTab && payoutsTab.classList.contains('active')) {
                    fetchPayoutsData();
                }
            });

            // ================= SUB TABS =================
            subRecent.addEventListener('click', function() {
                subRecent.classList.add('active');
                subPerCourse.classList.remove('active');

                tableHead.innerHTML = `
                    <tr>
                    <th data-column="id">ID</th>
                    <th data-column="date_time">Date/Time</th>
                    <th data-column="teacher">Teacher</th>
                    <th data-column="course">Course</th>
                    <th data-column="session">Session</th>
                    <th data-column="student">Student</th>
                    <th data-column="parent">Parent</th>
                    <th data-column="total">Total</th>
                    <th data-column="paid">Paid</th>
                    <th data-column="remaining">Remaining</th>
                    <th data-column="actions" class="text-end">Actions</th>
                    </tr>`;
                window.tableState.currentDataSource = 'recent';
                loadPlatformTransactions(selectYear.value);
            });

            subPerCourse.addEventListener('click', function() {
                subPerCourse.classList.add('active');
                subRecent.classList.remove('active');
                tableHead.innerHTML = perCourseHead;
                tableBody.innerHTML = "";
                window.tableState.currentDataSource = 'percourse';
                loadPerCourseTransactions(selectYear.value);
            });



            function loadPerCourseTransactions(sessionId = null) {
                let url = "{{ route('platform_transactions.per_course') }}";
                if (sessionId) {
                    url += `?session_id=${sessionId}`;
                }

                fetch(url)
                    .then(res => res.json())
                    .then(res => {
                        if (res.status !== "success") {
                            toastr.clear();
                            toastr.error("Failed to load per-course transactions");
                            return;
                        }

                        // ✅ Update cards (same as recent tab)
                        const currency = $("#currencySelect option:selected").text();

                        $("#total_revenue").text(`${currency} ${Number(res.total_revenue).toFixed(2)}`);
                        $("#platformBalance").text(`${currency} ${Number(res.platform_balance).toFixed(2)}`);
                        $("#withdrawn_balance").text(`${currency} ${Number(res.withdrawn_balance).toFixed(2)}`);

                        // ✅ Populate table rows
                        tableBody.innerHTML = "";
                        window.tableState.currentTableData = [];

                        res.data.forEach(course => {
                            const courseName = course.course_title ?? "-";
                            const sessionTitle = course.session_title ?? "-";
                            const transactionCount = course.transactions_count ?? 0;

                            const totalAmount =
                                ` ${Number(course.total_amount).toFixed(2)}  (${currency})`;
                            const platformAmount =
                                `${Number(course.platform_amount ?? 0).toFixed(2)} (${currency})`;
                            const totalPaid = `${Number(course.total_paid).toFixed(2)} (${currency})`;

                            // ✅ Remaining = total_paid - platform_amount
                            const totalRemaining =
                                `${(Number(course.total_paid) - Number(course.platform_amount ?? 0)).toFixed(2)} (${currency})`;

                            // Store data for export
                            window.tableState.currentTableData.push({
                                course_name: courseName,
                                session: sessionTitle,
                                transactions: transactionCount,
                                total_amount: totalAmount,
                                platform_amount: platformAmount,
                                total_paid: totalPaid,
                                total_remaining: totalRemaining,
                                courseId: course.course_id
                            });

                            tableBody.insertAdjacentHTML("beforeend", `
                                <tr data-course-id="${course.course_id}">
                                    <td data-column="course_name">${courseName}</td>
                                    <td data-column="session">${sessionTitle}</td>
                                    <td data-column="transactions">${transactionCount}</td>
                                    <td data-column="total_amount">${totalAmount}</td>
                                    <td data-column="platform_amount">${platformAmount}</td>
                                    <td data-column="total_paid">${totalPaid}</td>
                                    <td data-column="total_remaining">${totalRemaining}</td>
                                    <td data-column="actions">
                                        <button class="btn btn-sm btn-primary view-details"
                                            data-course-id="${course.course_id}"
                                            data-session-id="${sessionId}">
                                            View
                                        </button>
                                    </td>
                                </tr>
                            `);
                        });

                        // Update columns list
                        updateColumnsList();
                    })
                    .catch(() => {
                        toastr.clear();
                        toastr.error("Error fetching per-course data");
                    });
            }

            // ================= LOAD TRANSACTIONS =================
            function loadPlatformTransactions(sessionId = null) {
                let url = "{{ route('platform_transactions.index') }}";
                if (sessionId) {
                    url += `?session_id=${sessionId}`;
                }

                fetch(url)
                    .then(res => res.json())
                    .then(res => {
                        if (res.status !== "success") {
                            toastr.clear();
                            toastr.error("Failed to load transactions");
                            return;
                        }

                        const data = res.data;
                        const totalRevenue = res.total_revenue;
                        const platformBalance = res.platform_balance;
                        const withdrawnBalance = res.withdrawn_balance; // ✅ new field

                        const currency = $("#currencySelect option:selected").text();

                        // ✅ Update cards
                        $("#total_revenue").text(`${currency} ${Number(totalRevenue).toFixed(2)}`);
                        $("#platformBalance").text(`${currency} ${Number(platformBalance).toFixed(2)}`);
                        $("#withdrawn_balance").text(`${currency} ${Number(withdrawnBalance).toFixed(2)}`);

                        // ✅ Update table
                        tableBody.innerHTML = "";
                        window.tableState.currentTableData = [];

                        data.forEach((row, index) => {
                            // ✅ Compute platform paid amount from payments array
                            const platformPaid = row.payments?.reduce((sum, p) => sum + parseFloat(p
                                .paid_amount || 0), 0) || 0;

                            // ✅ Remaining = total - sum of platform payments
                            const remaining = parseFloat(row.total) - platformPaid;

                            const currencyName = row.currency?.currency_name ?? '';
                            const createdAt = new Date(row.created_at).toLocaleString('en-US', {
                                year: 'numeric',
                                month: 'short',
                                day: '2-digit',
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: true
                            });

                            // Store data for export
                            window.tableState.currentTableData.push({
                                id: index + 1,
                                date_time: createdAt,
                                teacher: row.teacher?.teacher_name ?? '-',
                                course: row.course?.course_title ?? '-',
                                session: row.session?.session_title ?? '-',
                                student: row.student_name ?? '-',
                                parent: row.parent_name ?? '-',
                                total: `${Number(row.total).toFixed(2)} (${currencyName})`,
                                paid: `${platformPaid.toFixed(2)} (${currencyName})`,
                                remaining: `${remaining.toFixed(2)} (${currencyName})`,
                                rowId: row.id,
                                totalValue: Number(row.total).toFixed(2),
                                paidValue: platformPaid.toFixed(2),
                                remainingValue: remaining.toFixed(2)
                            });

                            tableBody.insertAdjacentHTML('beforeend', `
                                    <tr data-row-id="${row.id}">
                                        <td data-column="id">${index + 1}</td>
                                        <td data-column="date_time">${createdAt}</td>
                                        <td data-column="teacher">${row.teacher?.teacher_name ?? '-'}</td>
                                        <td data-column="course">${row.course?.course_title ?? '-'}</td>
                                        <td data-column="session">${row.session?.session_title ?? '-'}</td>
                                        <td data-column="student">${row.student_name ?? '-'}</td>
                                        <td data-column="parent">${row.parent_name ?? '-'}</td>
                                        <td data-column="total">${Number(row.total).toFixed(2)} (${currencyName})</td>
                                        <td data-column="paid">${platformPaid.toFixed(2)} (${currencyName})</td>
                                        <td data-column="remaining">${remaining.toFixed(2)} (${currencyName})</td>
                                        <td data-column="actions" class="text-end">
                                            <button class="btn btn-sm icon-btn restore-btn"
                                                data-id="${row.id}"
                                                data-total="${row.total}"
                                                data-paid="${platformPaid}"
                                                data-remaining="${remaining}">
                                                <i class="bi bi-arrow-counterclockwise"></i>
                                            </button>
                                            <button class="btn btn-sm icon-btn text-danger delete-btn">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `);
                        });

                        // Update columns list
                        updateColumnsList();

                    })
                    .catch(() => {
                        toastr.clear();
                        toastr.error("Error fetching transaction data");
                    });
            }


            // Initial load using the first selected session
            loadPlatformTransactions(selectYear.value);
            selectYear.addEventListener('change', function() {
                const sessionId = this.value;

                if (subRecent.classList.contains("active")) {
                    loadPlatformTransactions(sessionId); // ✅ If Recent tab active
                }

                if (subPerCourse.classList.contains("active")) {
                    loadPerCourseTransactions(sessionId); // ✅ If PerCourse tab active
                }

                // ✅ Add balances tab scenario
                if (balancesTabBtn && balancesTabBtn.classList.contains("active")) {
                    loadTeacherBalances(sessionId); // If Balances tab active
                }
            });

            function loadTeacherBalances(sessionId) {
                fetch(`{{ route('balances.teacher') }}?session_id=${sessionId}`)
                    .then(res => res.json())
                    .then(res => {
                        if (res.status !== "success") {
                            toastr.clear();
                            toastr.error("Failed to load teacher balances");
                            return;
                        }

                        const tbody = document.querySelector('#teacherBalances tbody');
                        tbody.innerHTML = ''; // clear old rows

                        // Get currency info from response
                        const currencyName = res.currency_name || '';
                        const currencySymbol = res.currency_symbol || '';

                        res.data.forEach(teacher => {
                            // Format numbers with currency
                            const totalRevenueFormatted =
                                `${teacher.total_revenue.toLocaleString()} (${currencyName})`;
                            const platformShareFormatted =
                                `${teacher.total_platform_share.toLocaleString()} (${currencyName})`;
                            const platformPaidFormatted =
                                `${teacher.total_platform_paid.toLocaleString()} (${currencyName})`;
                            const platformBalanceFormatted =
                                `${teacher.total_platform_balance.toLocaleString()} (${currencyName})`;

                            tbody.insertAdjacentHTML('beforeend', `
                        <tr data-teacher-id="${teacher.id}">
                            <td data-column="name">${teacher.name}</td>
                            <td data-column="total_revenue">${totalRevenueFormatted}</td>
                            <td data-column="platform_share">${platformShareFormatted}</td>
                            <td data-column="platform_paid">${platformPaidFormatted}</td>
                            <td data-column="platform_balance">${platformBalanceFormatted}</td>
                            <td data-column="actions">
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `);
                        });

                    })
                    .catch(() => {
                        toastr.clear();
                        toastr.error("Error fetching teacher balances");
                    });
            }

            // Apply search/filter on transaction table
            const transactionsSearchInput = document.querySelector('#transactionsSearchInput');
            if (transactionsSearchInput) {
                transactionsSearchInput.addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase();
                    const rows = document.querySelectorAll('#transactionsTableBody tr');

                    rows.forEach(row => {
                        // Combine all cell text for search
                        const text = Array.from(row.cells).map(cell => cell.textContent
                                .toLowerCase())
                            .join(' ');
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                });
            }


            // Update your existing balancesTabBtn click event to use the function
            if (balancesTabBtn) {
                balancesTabBtn.addEventListener('click', function() {
                    const sessionId = selectYear.value;
                    loadTeacherBalances(sessionId);
                });
            }




            // ================= RESTORE MODAL =================
            const restoreModalEl = document.getElementById('restoreModal');
            const restoreModal = new bootstrap.Modal(restoreModalEl);
            const restoreForm = document.getElementById('restoreForm');
            const restoreRemarks = document.getElementById('restoreRemarks');

            const restoreTransactionId = document.getElementById('restoreTransactionId');
            const restoreTotal = document.getElementById('restoreTotal');
            const restorePaidReadonly = document.getElementById('restorePaidReadonly');
            const restorePaid = document.getElementById('restorePaid');
            const restoreRemaining = document.getElementById('restoreRemaining');


            let isSubmittingRestore = false;

            // Open restore modal
            document.body.addEventListener('click', function(e) {
                const btn = e.target.closest('.restore-btn');
                if (!btn) return;

                const id = btn.dataset.id;
                const total = parseFloat(btn.dataset.total) || 0;
                const paid = parseFloat(btn.dataset.paid) || 0;

                restoreTransactionId.value = id;
                restoreTotal.value = total.toFixed(2);
                restorePaidReadonly.value = paid.toFixed(2);
                restorePaid.value = "";
                restoreRemaining.value = (total - paid).toFixed(2);

                restoreModal.show();
            });

            // Update remaining in modal
            restorePaid.addEventListener('input', function() {
                const total = parseFloat(restoreTotal.value) || 0;
                const paidReadonly = parseFloat(restorePaidReadonly.value) || 0;
                let newPaid = parseFloat(this.value) || 0;

                // Maximum allowed is remaining
                const maxPayable = Math.max(0, total - paidReadonly);

                if (newPaid < 0) newPaid = 0;
                if (newPaid > maxPayable) newPaid = maxPayable;

                // Update the field value dynamically without breaking typing
                if (this.value !== newPaid.toString()) {
                    this.value = newPaid;
                }

                // Update remaining field
                restoreRemaining.value = (total - paidReadonly - newPaid).toFixed(2);
            });

            // Format input to 2 decimals only when user leaves the field
            restorePaid.addEventListener('blur', function() {
                let value = parseFloat(this.value) || 0;
                const total = parseFloat(restoreTotal.value) || 0;
                const paidReadonly = parseFloat(restorePaidReadonly.value) || 0;
                const maxPayable = Math.max(0, total - paidReadonly);

                if (value < 0) value = 0;
                if (value > maxPayable) value = maxPayable;

                this.value = value.toFixed(2);
            });



            // Submit restore form
            restoreForm.addEventListener('submit', function(e) {
                e.preventDefault();
                if (isSubmittingRestore) return;

                isSubmittingRestore = true;

                const transactionId = restoreTransactionId.value;
                const newPaid = parseFloat(restorePaid.value) || 0;
                const restoreRemarksValue = restoreRemarks.value;
                console.log(newPaid);

                fetch(`/platform/transactions/${transactionId}/restore`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            new_paid: newPaid,
                            remarks: restoreRemarksValue
                        })
                    })
                    .then(res => res.json())
                    .then(res => {
                        isSubmittingRestore = false;
                        restoreModal.hide();

                        toastr.clear();
                        if (res.status === 'success') {
                            toastr.success(res.message || "Transaction restored successfully");
                            // Refresh table immediately
                            loadPlatformTransactions(selectYear.value);
                        } else {
                            toastr.error(res.message || "Failed to update transaction");
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        isSubmittingRestore = false;
                        restoreModal.hide();
                        toastr.clear();
                        toastr.error('Error updating transaction');
                    });
            });

            // Ensure modal backdrop is removed on close
            restoreModalEl.addEventListener('hidden.bs.modal', function() {
                document.body.classList.remove('modal-open');
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                restoreForm.reset();
                restoreRemaining.value = '';
                isSubmittingRestore = false;
            });

            // ================= COLUMN UTILITY FUNCTION =================

            window.updateColumnsList = function() {
                const headers = Array.from(tableHead.querySelectorAll('th')).map(th => ({
                    text: th.textContent.trim(),
                    column: th.getAttribute('data-column') || th.textContent.trim().toLowerCase()
                }));

                window.tableState.currentColumns = headers;
                window.tableState.selectedColumns = headers.map(h => h.column);
            };

        });
    </script>


    <!-- Restore Modal -->




    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // This flag is fine here, as this whole script only runs once.
            let isSubmitting = false;

            // ===================== Helper Toasts =====================
            function safeToastr(type, msg) {
                if (typeof toastr !== 'undefined') {
                    // 🚨 FIX 1: Removed setTimeout.
                    // Clear toasts immediately before showing the new one
                    // to prevent stacking or race conditions.
                    toastr.clear();
                    if (type === 'success') {
                        toastr.success(msg);
                    } else if (type === 'error') {
                        toastr.error(msg);
                    }
                } else {
                    console.log(`TOAST ${type.toUpperCase()}:`, msg);
                }
            }

            // ===================== Remaining Calculation =====================
            // 🚨 FIX 2 (Part A): Use event delegation for the 'input' event
            document.body.addEventListener('input', function(e) {
                // Only act if the event came from our specific input
                if (e.target.id !== 'restorePaid') {
                    return;
                }

                // Find related elements from the input's form
                const form = e.target.closest('form');
                if (!form) return;

                const restoreTotal = form.querySelector('#restoreTotal');
                const restorePaidReadonly = form.querySelector('#restorePaidReadonly');
                const restorePaid = e.target; // This is '#restorePaid'
                const restoreRemaining = form.querySelector('#restoreRemaining');

                if (!restoreTotal || !restorePaidReadonly || !restoreRemaining) {
                    return;
                }

                // --- Your calculation logic (unchanged) ---
                const total = parseFloat(restoreTotal.value) || 0;
                const paidReadonly = parseFloat(restorePaidReadonly.value) || 0;
                let newPaid = parseFloat(restorePaid.value) || 0;

                if (newPaid < 0) newPaid = 0;
                const remainingBalance = total - paidReadonly;
                if (newPaid > remainingBalance) newPaid = remainingBalance;

                restorePaid.value = newPaid.toFixed(2);
                restoreRemaining.value = (total - paidReadonly - newPaid).toFixed(2);
            });

            // ===================== Open Modal =====================
            // Your click listener already used delegation, which is great.
            // We just need to make sure we get the current modal instance.
            document.body.addEventListener('click', function(e) {
                const btn = e.target.closest('.restore-btn');
                if (!btn) return;

                const id = btn.dataset.id;
                const total = parseFloat(btn.dataset.total) || 0;
                const paid = parseFloat(btn.dataset.paid) || 0;

                // Get the modal element now
                const restoreModalEl = document.getElementById('restoreModal');
                if (!restoreModalEl) return;

                // Find inputs inside this modal
                const restoreTransactionId = restoreModalEl.querySelector('#restoreTransactionId');
                const restoreTotal = restoreModalEl.querySelector('#restoreTotal');
                const restorePaidReadonly = restoreModalEl.querySelector('#restorePaidReadonly');
                const restorePaid = restoreModalEl.querySelector('#restorePaid');
                const restoreRemaining = restoreModalEl.querySelector('#restoreRemaining');

                // Populate the inputs
                restoreTransactionId.value = id;
                restoreTotal.value = total;
                restorePaidReadonly.value = paid.toFixed(2);

                // ✅ ONLY THIS LINE CHANGED (was restorePaid.value = 0.00;)
                restorePaid.value = ''; // input now starts empty for user entry

                restoreRemaining.value = (total - paid).toFixed(2);

                isSubmitting = false;

                // Get or create the modal instance now
                const restoreModal = bootstrap.Modal.getOrCreateInstance(restoreModalEl);
                restoreModal.show();
            });

            // ===================== Reset Modal on Close =====================
            // 🚨 FIX 2 (Part B): Delegate the modal close event
            document.addEventListener('hidden.bs.modal', function(e) {
                // Only act on the modal we care about
                if (e.target.id !== 'restoreModal') {
                    return;
                }

                const restoreForm = e.target.querySelector('#restoreForm');
                if (restoreForm) {
                    restoreForm.reset();
                }

                const restoreRemaining = e.target.querySelector('#restoreRemaining');
                if (restoreRemaining) {
                    restoreRemaining.value = '';
                }
                isSubmitting = false;

                // Removed the manual backdrop/overflow cleanup.
                // Bootstrap handles this automatically and manually
                // removing it can cause bugs.
            });

            // ===================== Submit Form =====================
            // 🚨 FIX 2 (Part C): Use event delegation for the 'submit' event
            document.addEventListener('submit', function(e) {
                    // Only act if the event came from our specific form
                    if (e.target.id !== 'restoreForm') {
                        return;
                    }

                    // This will now reliably prevent the page refresh
                    e.preventDefault();
                    if (isSubmitting) return;

                    isSubmitting = true;
                    const submitForm = e.target; // The form that was submitted
                    const submitBtn = submitForm.querySelector('button[type="submit"]');
                    submitBtn.disabled = true;

                    // Get values from the form that was just submitted
                    const transactionId = submitForm.querySelector('#restoreTransactionId').value;
                    const newPaidValue = parseFloat(submitForm.querySelector('#restorePaid').value) || 0;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                        'content') || '';

                    fetch(/platform/transactions / $ {
                            transactionId
                        }
                        /restore, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            new_paid: newPaidValue
                        })
                    })
                .then(res => res.json())
                .then(res => {
                    submitBtn.disabled = false;
                    isSubmitting = false;

                    // Get the modal instance to hide it
                    const restoreModalEl = document.getElementById('restoreModal');
                    const restoreModal = bootstrap.Modal.getInstance(restoreModalEl);

                    if (res.status === 'success') {
                        safeToastr('success', res.message || 'Transaction updated successfully');
                        if (restoreModal) {
                            restoreModal.hide();
                        }

                        // --- Your row-update logic (unchanged) ---
                        if (res.data) {
                            const updated = res.data;
                            const newRemainingAmount = (parseFloat(updated.total) - parseFloat(updated
                                .paid_amount)).toFixed(2);
                            const row = document.querySelector(#transaction - row - $ {
                                transactionId
                            });

                            if (row) {
                                const paidCell = row.querySelector('.paid-amount');
                                const remainingCell = row.querySelector('.remaining-amount');
                                const restoreBtn = row.querySelector('.restore-btn');

                                if (paidCell) paidCell.textContent = parseFloat(updated.paid_amount)
                                    .toFixed(2);
                                if (remainingCell) remainingCell.textContent = newRemainingAmount;
                                if (restoreBtn) restoreBtn.dataset.paid = updated.paid_amount;
                            }
                        }
                    } else {
                        safeToastr('error', res.message || 'Failed to update transaction');
                    }
                })
                .catch(err => {
                    console.error("Fetch Error:", err);
                    submitBtn.disabled = false;
                    isSubmitting = false;

                    const restoreModalEl = document.getElementById('restoreModal');
                    const restoreModal = bootstrap.Modal.getInstance(restoreModalEl);
                    if (restoreModal) {
                        restoreModal.hide(); // Hide on catastrophic network failure
                    }
                    safeToastr('error', 'Network error or unhandled exception. Please try again.');
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


    {{-- This is the script for transactions --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const form = document.getElementById("transactionsForm");
            const totalInput = document.getElementById("transaction_total");
            const paidInput = document.getElementById("transaction_paid");
            const remainingInput = document.getElementById("transaction_remaining");
            const transactionsModal = document.getElementById('transactionsModal');
            const tableBody = document.getElementById(
                'transactionsTableBody'); // Updated to match your table structure

            // 1️⃣ Calculate remaining dynamically
            function calculateRemaining() {
                const total = parseFloat(totalInput.value) || 0;
                const paid = parseFloat(paidInput.value) || 0;
                remainingInput.value = (total - paid >= 0 ? (total - paid).toFixed(2) : 0);
            }

            totalInput.addEventListener("input", calculateRemaining);
            paidInput.addEventListener("input", calculateRemaining);

            // 2️⃣ Submit form via AJAX only once
            let isSubmitting = false; // Prevent double submission

            if (!form.dataset.listener) {
                form.dataset.listener = "true";

                form.addEventListener("submit", async function(e) {
                    e.preventDefault();

                    // Prevent multiple simultaneous submissions
                    if (isSubmitting) {
                        console.log("Form is already being submitted");
                        return;
                    }

                    isSubmitting = true;

                    // Log form data for debugging
                    const formData = new FormData(form);

                    // ✅ Ensure hidden input selected_currency_id is included
                    const selectedCurrencyInput = document.getElementById("selected_currency_id");
                    if (selectedCurrencyInput) {
                        formData.set("selected_currency_id", selectedCurrencyInput.value);
                    }
                    console.log(selectedCurrencyInput)

                    console.log("Submitting form data:");
                    for (let [key, value] of formData.entries()) {
                        console.log(key, ":", value);
                    }

                    try {
                        // Get fresh CSRF token
                        const csrfToken = document.querySelector('input[name="_token"]')?.value ||
                            document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                        const res = await fetch("{{ route('platform_transaction.store') }}", {
                            method: "POST",
                            body: formData,
                            headers: {
                                "X-CSRF-TOKEN": csrfToken
                            }
                        });

                        const text = await res.text();

                        // Parse JSON safely
                        let data;
                        try {
                            data = JSON.parse(text);
                        } catch (parseErr) {
                            console.error("Server response is not valid JSON:", text);
                            throw new Error("Server did not return valid JSON");
                        }

                        // ✅ Success: transaction saved
                        if (res.ok && data.status === "success" && data.transaction) {

                            // Optional: show success toastr
                            if (typeof toastr !== "undefined") {
                                toastr.clear();
                                toastr.success("Transaction saved successfully!");
                            }

                            // Get the currently selected session ID
                            const selectedSessionId = document.getElementById("SelectYear")?.value;

                            // Reload page with session_id as query param to preserve selection
                            const url = new URL(window.location.href);
                            if (selectedSessionId) {
                                url.searchParams.set("session_id", selectedSessionId);
                            }
                            window.location.href = url.toString();
                        }
                        // Validation errors
                        else if (res.status === 422 && data.errors) {
                            const messages = Object.values(data.errors).flat().join("<br>");
                            if (typeof toastr !== "undefined") {
                                toastr.clear();
                                toastr.error(messages);
                            }
                        }
                        // Other server errors
                        else {
                            if (typeof toastr !== "undefined") {
                                toastr.clear();
                                toastr.error(data.message || "Server error while saving transaction");
                            }
                        }

                    } catch (err) {
                        console.error("AJAX/JS Error:", err);
                        if (typeof toastr !== "undefined") {
                            toastr.clear();
                            toastr.error(err.message ||
                                "Unexpected error occurred while saving transaction");
                        }
                    } finally {
                        isSubmitting = false;
                    }

                });
            }

            // 3️⃣ Reset form when modal closes
            transactionsModal.addEventListener('hidden.bs.modal', function() {
                form.reset();
                remainingInput.value = "";
                isSubmitting = false; // Reset submission flag when modal closes

                // Remove any lingering backdrops
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
            });

            // Optional: If you later have a select for changing currency dynamically
            const currencySelect = document.getElementById("currencySelect");
            if (currencySelect) {
                currencySelect.addEventListener("change", function() {
                    const selectedCurrencyId = this.value;
                    const selectedCurrencyName = this.options[this.selectedIndex].text;

                    // Update hidden input
                    const hiddenInput = document.getElementById("selected_currency_id");
                    if (hiddenInput) hiddenInput.value = selectedCurrencyId;

                    // Update readonly text input
                    const textInput = document.getElementById("current_currency");
                    if (textInput) textInput.value = selectedCurrencyName;
                });
            }

        });
    </script>


    {{-- This is the script for currency_update --}}




    <script>
        $(document).ready(function() {


            $('#currencySelect').on('change', function() {
                const selectedCurrencyId = $(this).val();
                const selectedCurrencyName = $('#currencySelect option:selected').text();
                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: "{{ route('platform_currency.update') }}",
                    type: 'POST',
                    data: {
                        default_currency: selectedCurrencyId,
                        _token: csrfToken
                    },
                    success: function(res) {
                        if (res.success) {
                            // ✅ Update hidden fields
                            $('#current_currency').val(selectedCurrencyName);
                            $('#selected_currency_id').val(selectedCurrencyId);

                            // ✅ Reload the entire page
                            window.location.reload();
                        }
                    }
                });
            });

        });
    </script>

    {{-- This is the script for select year --}}
    <script>
        $(document).ready(function() {
            function updateTransactionSession() {
                const selectedOption = $("#SelectYear option:selected");

                if (selectedOption.length) {
                    const selectedValue = selectedOption.val();
                    const selectedText = selectedOption.text();

                    const $transactionSession = $("#transaction_session");
                    $transactionSession.empty(); // clear existing options
                    $transactionSession.append(
                        `<option value="${selectedValue}" selected>${selectedText}</option>`
                    );
                }
            }

            // Run on page load
            updateTransactionSession();

            // Run when the selection changes
            $("#SelectYear").on("change", function() {
                updateTransactionSession();
            });
        });
    </script>















    {{-- This is the script for of pdf and excel for transaction & recent table --}}


    <script>
        $(document).ready(function() {

            // =========================
            // STATE
            // =========================
            window.tableState = window.tableState || {
                currentTableData: [],
                currentColumns: [],
                selectedColumns: [],
                currentDataSource: 'recent'
            };

            const $tableHead = $('#transactionsTableHead');
            const $tableBody = $('#transactionsTableBody');
            const $columnsModal = $('#columnsModal');
            const $columnsCheckboxes = $('#columnsCheckboxes');
            const $applyColumnsBtn = $('#applyColumnsBtn');
            const $columnsBtn = $('#columnsBtn');
            const $exportExcelBtn = $('#exportExcelBtn');
            const $exportPdfBtn = $('#exportPdfBtn');
            // Note: $exportCsvBtn was not implemented in the original code, but I'll update the Excel logic.
            const $exportCsvBtn = $('#exportCsvBtn');
            const $selectYear = $('#SelectYear');

            function escapeHtml(text) {
                if (text === null || text === undefined) return '';
                return $('<div>').text(text).html();
            }

            async function loadHtml2PdfLibrary() {
                if (typeof html2pdf !== 'undefined') return;
                return $.getScript(
                    'https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js');
            }

            // Helper function to get the current visible column indices
            function getVisibleColumns() {
                const visibleIndices = [];
                const headers = [];
                $tableHead.find('th').each(function(i) {
                    if ($(this).is(':visible')) {
                        visibleIndices.push(i);
                        headers.push($(this).text().trim());
                    }
                });
                return {
                    visibleIndices,
                    headers
                };
            }

            // -------------------------
            // COLUMN SELECTION
            // -------------------------
            $columnsBtn?.off('click').on('click', function() {
                $columnsCheckboxes.empty();
                const columnsCount = $tableHead.find('th').length;

                // Initialize selectedColumns if it's empty
                if (window.tableState.selectedColumns.length === 0 && columnsCount > 0) {
                    window.tableState.selectedColumns = Array.from({
                        length: columnsCount
                    }, (_, i) => i);
                }

                $tableHead.find('th').each(function(i) {
                    const colName = $(this).text().trim();
                    const isChecked = window.tableState.selectedColumns.includes(i);

                    $columnsCheckboxes.append(
                        `<label><input type="checkbox" data-index="${i}" ${isChecked ? 'checked' : ''}> ${colName}</label><br>`
                    );
                });
                $columnsModal.show();
            });

            $applyColumnsBtn?.off('click').on('click', function() {
                const selected = [];
                $columnsCheckboxes.find('input[type="checkbox"]:checked').each(function() {
                    selected.push(parseInt($(this).data('index')));
                });
                window.tableState.selectedColumns = selected;

                // Update visibility of headers
                $tableHead.find('th').each(function(i) {
                    $(this).toggle(selected.includes(i));
                });

                // Update visibility of body cells
                $tableBody.find('tr').each(function() {
                    $(this).find('td').each(function(i) {
                        $(this).toggle(selected.includes(i));
                    });
                });

                $columnsModal.hide();
            });

            // -------------------------
            // EXCEL EXPORT (Corrected to use visible columns and set widths)
            // -------------------------
            $exportExcelBtn?.off('click').on('click', function() {
                const {
                    visibleIndices,
                    headers
                } = getVisibleColumns();
                if (!headers.length) return alert('No columns selected to export');

                const wb = XLSX.utils.book_new();
                const ws_data = [];

                // 1. Headers
                ws_data.push(headers);

                // 2. Rows
                $tableBody.find('tr').each(function() {
                    const row = [];
                    $(this).find('td').each(function(i) {
                        if (visibleIndices.includes(i)) {
                            row.push($(this).text().trim());
                        }
                    });
                    ws_data.push(row);
                });

                // 3. Set column widths (wch: Width Character - sets cell to 'full width' based on content/heuristic)
                const wscols = headers.map(h => ({
                    wch: Math.max(20, h.length + 5)
                }));

                const ws = XLSX.utils.aoa_to_sheet(ws_data);
                ws['!cols'] = wscols; // Apply column widths

                XLSX.utils.book_append_sheet(wb, ws, "Transactions");
                XLSX.writeFile(wb, `WeTeach_Transactions_${new Date().toISOString().split('T')[0]}.xlsx`);
            });

            // -------------------------
            // PDF EXPORT (Fully corrected to use visible columns and styles)
            // -------------------------
            $exportPdfBtn?.off('click').on('click', async function() {
                const {
                    visibleIndices,
                    headers
                } = getVisibleColumns();
                if (!headers.length) return alert('No columns selected to export');

                // 1. Collect only visible data
                const exportData = [];
                let totalRevenue = 0;

                // Try to find the 'Total Paid' column index for the sum calculation
                const totalPaidHeaderIndex = headers.findIndex(h => h.toLowerCase().includes(
                    'total paid'));

                $tableBody.find('tr').each(function() {
                    const rowData = [];
                    let rowPaidValue = 0;

                    $(this).find('td').each(function(i) {
                        if (visibleIndices.includes(i)) {
                            const cellText = $(this).text().trim();
                            rowData.push(cellText);

                            // If the cell corresponds to the 'Total Paid' column
                            if (visibleIndices.indexOf(i) === totalPaidHeaderIndex) {
                                rowPaidValue = parseFloat(cellText.replace(/[^\d.-]/g,
                                    '')) || 0;
                            }
                        }
                    });

                    if (rowData.length > 0) {
                        exportData.push(rowData);
                        totalRevenue += rowPaidValue;
                    }
                });

                if (!exportData.length) return alert('No data to export');

                await loadHtml2PdfLibrary();
                const logoUrl = "{{ asset('assets/logo_pic/vteach_logo.png') }}";

                // Calculate equal column width percentage for PDF table
                const colWidth = 100 / headers.length;

                // Build Header HTML
                let headerHtml = '<tr>';
                headers.forEach(h => {
                    headerHtml +=
                        `<th style="border-bottom:2px solid #4CAF50;padding:10px 6px;font-weight:bold;font-size:10px;text-align:center;background-color:#f3f3f3;color:#333;width:${colWidth}%">${escapeHtml(h)}</th>`;
                });
                headerHtml += '</tr>';

                // Build Rows HTML
                let rowsHtml = '';
                exportData.forEach((row, i) => {
                    const bgColor = i % 2 === 0 ? '#ffffff' : '#f9f9f9';
                    rowsHtml += '<tr>';
                    row.forEach(cellData => {
                        rowsHtml +=
                            `<td style="border:1px solid #ddd;padding:8px;font-size:9px;text-align:left;background-color:${bgColor};width:${colWidth}%">${escapeHtml(cellData)}</td>`;
                    });
                    rowsHtml += '</tr>';
                });

                // Total revenue row logic (aligned to the 'Total Paid' column)
                if (totalPaidHeaderIndex !== -1) {
                    const colspan = totalPaidHeaderIndex;
                    const emptyColspan = headers.length - (colspan + 1);

                    rowsHtml += `<tr>`;
                    if (colspan > 0) {
                        rowsHtml +=
                            `<td colspan="${colspan}" style="border:1px solid #333;padding:10px;font-weight:bold;text-align:right;background-color:#f3f3f3;color:#333">Total Revenue</td>`;
                    }
                    rowsHtml +=
                        `<td style="border:1px solid #333;padding:10px;font-weight:bold;text-align:right;background-color:#f3f3f3;color:#333">${totalRevenue.toFixed(2)}</td>`;
                    if (emptyColspan > 0) {
                        rowsHtml +=
                            `<td colspan="${emptyColspan}" style="border:1px solid #333;padding:10px;font-weight:bold;text-align:right;background-color:#f3f3f3;color:#333"></td>`;
                    }
                    rowsHtml += `</tr>`;
                }

                const htmlContent = `
                <div style="font-family:Arial,sans-serif;width:95%;padding:10px;margin:auto">
                    <div style="text-align:center;margin-bottom:15px">
                        <img src="${logoUrl}" style="height:60px; display:block; margin:0 auto;" />
                        <h2 style="margin:5px 0;color:#4CAF50;">We Teach Platform Transaction & Recent Sheet</h2>
                        <p style="font-size:10px;color:#666">Generated on: ${new Date().toLocaleString()}</p>
                    </div>
                    <table style="width:100%;border-collapse:collapse;table-layout:fixed;font-family:Arial,sans-serif">
                        <thead>${headerHtml}</thead>
                        <tbody>${rowsHtml}</tbody>
                    </table>
                    <div style="margin-top:40px;width:100%; display:block; page-break-inside:avoid; text-align:center;">
                        <div style="margin-bottom:50px;">
                            <div style="display:inline-block; width:40%; text-align:center;">
                                <p>________________________</p>
                                <p>Teacher Signature</p>
                            </div>
                            <div style="display:inline-block; width:40%; text-align:center; margin-left:5%;">
                                <p>________________________</p>
                                <p>Platform Signature</p>
                            </div>
                        </div>
                    </div>
                </div>`;


                const $element = $(`<div>${htmlContent}</div>`);
                $('body').append($element);

                html2pdf().set({
                    margin: [10, 10, 10, 10],
                    filename: `WeTeach_Transactions_${new Date().toISOString().split('T')[0]}.pdf`,
                    html2canvas: {
                        scale: 2,
                        logging: false,
                        useCORS: true,
                        allowTaint: true
                    },
                    jsPDF: {
                        orientation: 'landscape',
                        unit: 'mm',
                        format: 'a4',
                        compress: true
                    },
                    pagebreak: {
                        mode: ['css', 'legacy'],
                        avoid: 'tr'
                    }
                }).from($element[0]).toPdf().get('pdf').then(function(pdf) {
                    pdf.save(
                        `WeTeach_Transactions_${new Date().toISOString().split('T')[0]}.pdf`
                    );
                }).finally(() => $element.remove());

            });

            // -------------------------
            // CSV EXPORT (Using Excel logic)
            // -------------------------
            $exportCsvBtn?.off('click').on('click', function() {
                const {
                    visibleIndices,
                    headers
                } = getVisibleColumns();
                if (!headers.length) return alert('No columns selected to export');

                const data = [];
                data.push(headers.join(','));

                $tableBody.find('tr').each(function() {
                    const row = [];
                    $(this).find('td').each(function(i) {
                        if (visibleIndices.includes(i)) {
                            // Simple escaping for CSV (wrap in double quotes if it contains commas or double quotes)
                            let cell = $(this).text().trim();
                            if (cell.includes(',') || cell.includes('"') || cell.includes(
                                    '\n')) {
                                cell = `"${cell.replace(/"/g, '""')}"`;
                            }
                            row.push(cell);
                        }
                    });
                    data.push(row.join(','));
                });

                const csvContent = data.join('\n');
                const blob = new Blob([csvContent], {
                    type: 'text/csv;charset=utf-8;'
                });
                const link = document.createElement("a");
                const url = URL.createObjectURL(blob);
                link.setAttribute("href", url);
                link.setAttribute("download",
                    `WeTeach_Transactions_${new Date().toISOString().split('T')[0]}.csv`);
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            });

        });
    </script>


    {{-- This is the script of pdf & excel  for per course table --}}


    <script>
        $(document).ready(function() {

            // ============================
            // CONFIG
            // ============================
            const HIDE_COLUMNS = ['actions', 'action', 'view'];
            const CURRENCY_COLUMNS = ['total', 'paid', 'remaining', 'amount', 'price'];
            const TABLE_ID = '#perCourseTable';

            const $table = $(TABLE_ID);

            if (typeof window.perCourseTableState === 'undefined') {
                window.perCourseTableState = {
                    currentColumns: [],
                    headers: []
                };
            }

            // ============================
            // UTILITIES
            // ============================
            function escapeHtml(str) {
                if (typeof str !== 'string') return str;
                return str.replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            // FIXED & IMPROVED PARSER
            function parseCurrencyValue(value) {
                if (!value) return 0;

                let clean = value.toString().trim();

                // Remove line breaks
                clean = clean.replace(/\r?\n|\r/g, " ").trim();

                // Remove ( EURO ) or any parentheses text
                clean = clean.replace(/\([^)]*\)/g, "").trim();

                // Extract number
                const match = clean.match(/-?\d+(\.\d+)?/);
                if (!match) return 0;

                return parseFloat(match[0]);
            }

            function formatCurrencyForDisplay(value) {
                const numValue = parseCurrencyValue(value);
                if (isNaN(numValue)) return value;
                return '€' + numValue.toFixed(2);
            }

            function isColumnHidden(columnName) {
                if (!columnName) return false;

                const lower = columnName.toLowerCase().trim();

                return HIDE_COLUMNS.some(h => lower.includes(h.toLowerCase()));
            }

            function isCurrencyColumn(columnName) {
                if (!columnName) return false;
                const lower = columnName.toLowerCase().trim();
                return CURRENCY_COLUMNS.some(c => lower.includes(c));
            }

            // ============================
            // INITIALIZE COLUMNS
            // ============================
            function initializeColumns() {
                const headers = [];
                const columns = [];

                $table.find('thead th').each(function(index) {
                    const headerText = $(this).text().trim();
                    headers.push(headerText);

                    if (!isColumnHidden(headerText)) {
                        columns.push({
                            index: index,
                            column: headerText.toLowerCase().replace(/\s+/g, ''),
                            text: headerText
                        });
                    }
                });

                window.perCourseTableState.currentColumns = columns;
                window.perCourseTableState.headers = headers;
            }

            initializeColumns();


            // ============================
            // COLLECT EXPORT DATA
            // ============================
            function getExportData() {
                const data = [];
                const visibleCols = window.perCourseTableState.currentColumns;

                $table.find('tbody tr:visible').each(function() {
                    const row = {};
                    const $cells = $(this).find('td');

                    visibleCols.forEach(col => {
                        let cellValue = $cells.eq(col.index).text().trim();

                        if (isCurrencyColumn(col.text)) {
                            cellValue = formatCurrencyForDisplay(cellValue);
                        }

                        row[col.text] = cellValue;
                    });

                    data.push(row);
                });

                return data;
            }

            function getVisibleColumns() {
                const visibleIndices = [];
                const headers = [];

                window.perCourseTableState.currentColumns.forEach(col => {
                    visibleIndices.push(col.index);
                    headers.push(col.text);
                });

                return {
                    visibleIndices,
                    headers
                };
            }


            // ============================
            // EXPORT EXCEL
            // ============================
            $(document).on('click', '#perCourseExportExcelBtn', function() {

                const {
                    headers
                } = getVisibleColumns();
                const data = getExportData();

                if (!data.length) {
                    alert('No data to export');
                    return;
                }

                const exportHeaders = headers.filter(h => !isColumnHidden(h));

                const wsData = [];
                wsData.push(exportHeaders);

                data.forEach(row => {
                    const formattedRow = exportHeaders.map(h => {
                        if (isCurrencyColumn(h)) {
                            return parseCurrencyValue(row[h]); // REAL NUMBER
                        }
                        return row[h] || '';
                    });
                    wsData.push(formattedRow);
                });

                const ws = XLSX.utils.aoa_to_sheet(wsData);

                // Apply Excel currency style
                exportHeaders.forEach((h, colIndex) => {
                    if (isCurrencyColumn(h)) {
                        for (let rowIndex = 1; rowIndex < wsData.length; rowIndex++) {
                            const cellRef = XLSX.utils.encode_cell({
                                r: rowIndex,
                                c: colIndex
                            });
                            if (!ws[cellRef]) continue;
                            ws[cellRef].t = 'n';
                            ws[cellRef].z = '€#,##0.00';
                        }
                    }
                });

                ws['!cols'] = exportHeaders.map(h => ({
                    wch: Math.max(15, h.length + 5)
                }));

                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, 'Transactions');

                XLSX.writeFile(
                    wb,
                    `PerCourseTransactions_${new Date().toISOString().split('T')[0]}.xlsx`
                );
            });


            // ============================
            // EXPORT PDF
            // ============================
            $(document).on('click', '#perCourseExportPdfBtn', async function() {

                const {
                    headers
                } = getVisibleColumns();
                const data = getExportData();

                if (!data.length) {
                    alert('No data to export');
                    return;
                }

                const exportHeaders = headers.filter(h => !isColumnHidden(h));
                const colWidth = 100 / exportHeaders.length;

                let headerHtml = '<tr>';
                exportHeaders.forEach(h => {
                    headerHtml += `
                <th style="border-bottom:2px solid #4CAF50;padding:10px 6px;
                font-weight:bold;font-size:10px;text-align:center;background-color:#f3f3f3;
                color:#333;width:${colWidth}%">${escapeHtml(h)}</th>`;
                });
                headerHtml += '</tr>';

                let rowsHtml = '';
                let totalRevenue = 0;
                const paidIndex = exportHeaders.findIndex(h => h.toLowerCase().includes('paid'));

                data.forEach((row, i) => {
                    const bgColor = i % 2 === 0 ? '#ffffff' : '#f9f9f9';
                    rowsHtml += '<tr>';

                    exportHeaders.forEach((h, idx) => {
                        const cellValue = row[h] || '';

                        rowsHtml += `
                    <td style="border:1px solid #ddd;padding:8px;font-size:9px;
                    text-align:left;background-color:${bgColor};width:${colWidth}%">
                    ${escapeHtml(cellValue)}</td>`;

                        if (idx === paidIndex && isCurrencyColumn(h)) {
                            totalRevenue += parseCurrencyValue(cellValue);
                        }
                    });

                    rowsHtml += '</tr>';
                });

                if (paidIndex !== -1) {
                    const colspan = paidIndex;
                    const emptyColspan = exportHeaders.length - (colspan + 1);

                    rowsHtml += `<tr>`;

                    if (colspan > 0) {
                        rowsHtml += `
                    <td colspan="${colspan}" 
                    style="border:1px solid #333;padding:10px;font-weight:bold;
                    text-align:right;background-color:#f3f3f3;color:#333">
                    Total Revenue</td>`;
                    }

                    rowsHtml += `
                <td style="border:1px solid #333;padding:10px;font-weight:bold;
                text-align:right;background-color:#f3f3f3;color:#333">
                €${totalRevenue.toFixed(2)}</td>`;

                    if (emptyColspan > 0) {
                        rowsHtml += `
                    <td colspan="${emptyColspan}" 
                    style="border:1px solid:#333;background-color:#f3f3f3;"></td>`;
                    }

                    rowsHtml += `</tr>`;
                }

                const htmlContent = `
            <div style="font-family:Arial,sans-serif;width:95%;padding:10px;margin:auto">
                <div style="text-align:center;margin-bottom:15px">
                    <h2 style="margin:5px 0;color:#4CAF50;">Per Course Transactions Report</h2>
                    <p style="font-size:10px;color:#666">
                        Generated on: ${new Date().toLocaleString()}
                    </p>
                </div>
                <table style="width:100%;border-collapse:collapse;table-layout:fixed;
                    font-family:Arial,sans-serif">
                    <thead>${headerHtml}</thead>
                    <tbody>${rowsHtml}</tbody>
                </table>
            </div>`;

                const element = document.createElement('div');
                element.innerHTML = htmlContent;
                document.body.appendChild(element);

                if (typeof html2pdf === 'undefined') {
                    await $.getScript(
                        'https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js'
                    );
                }

                html2pdf()
                    .set({
                        margin: [10, 10, 10, 10],
                        filename: `PerCourseTransactions_${new Date().toISOString().split('T')[0]}.pdf`,
                        html2canvas: {
                            scale: 2,
                            logging: false,
                            useCORS: true,
                            allowTaint: true
                        },
                        jsPDF: {
                            orientation: 'landscape',
                            unit: 'mm',
                            format: 'a4',
                            compress: true
                        },
                        pagebreak: {
                            mode: ['css', 'legacy'],
                            avoid: 'tr'
                        }
                    })
                    .from(element)
                    .save()
                    .finally(() => element.remove());
            });

        });
    </script>


    {{-- This is the script of export pdf and excel for payout --}}



    <script>
        $(document).ready(function() {
            // --- Global State & Utility Functions ---
            window.payoutTableState = {
                allData: [],
                currentTableData: [],
                columns: ['id', 'date_time', 'teacher_name', 'course_name', 'session_name', 'student_name',
                    'parent_name', 'paid', 'remarks', 'actions'
                ],
                hiddenColumns: ['id']
            };

            const $payoutsTableBody = $('#payoutsTableBody');
            const $selectYear = $('#SelectYear');
            const $columnsForm = $('#columnsForm');
            const columnsModalElement = document.getElementById('columnsModal');
            const bootstrapModal = columnsModalElement ? (window.bootstrap ? new bootstrap.Modal(
                columnsModalElement) : null) : null;

            function getApiEndpoint() {
                const sessionId = $selectYear.val();
                if (!sessionId) return null;
                return "{{ route('payouts.data', ':session_id') }}".replace(':session_id', sessionId);
            }

            async function fetchPayoutsData() {
                const API_ENDPOINT = getApiEndpoint();
                if (!API_ENDPOINT) {
                    $payoutsTableBody.html(
                        '<tr><td colspan="10" class="text-center text-danger">Could not determine data API URL.</td></tr>'
                    );
                    return;
                }
                $payoutsTableBody.html('<tr><td colspan="10" class="text-center">Loading data...</td></tr>');

                $.ajax({
                    url: API_ENDPOINT,
                    type: 'GET',
                    dataType: 'json',
                    success: function(result) {
                        if (result.success && Array.isArray(result.data)) {
                            const formattedData = result.data.map(p => ({
                                id: p.id,
                                date_time: p.date_time ?? p.date_at ?? '-',
                                teacher_name: p.teacher_name ?? '-',
                                course_name: p.course_name ?? '-',
                                session_name: p.session_name ?? '-',
                                student_name: p.student_name ?? '-',
                                parent_name: p.parent_name ?? '-',
                                paid: `${p.paid_amount ?? 0} ${p.currency_name ?? ''}`,
                                remarks: p.remarks ?? '-'
                            }));
                            window.payoutTableState.allData = formattedData;
                            window.payoutTableState.currentTableData = formattedData;
                            renderTable(formattedData);
                            renderColumnsForm();
                            applyColumnVisibility();
                        } else {
                            $payoutsTableBody.html(
                                '<tr><td colspan="10" class="text-center text-danger">Invalid data received from API.</td></tr>'
                            );
                            console.error('API Error:', result);
                        }
                    },
                    error: function(xhr, status, error) {
                        $payoutsTableBody.html(
                            '<tr><td colspan="10" class="text-center text-danger">Failed to load payout data.</td></tr>'
                        );
                        console.error('Error fetching data:', error);
                    }
                });
            }

            function renderTable(data) {
                $payoutsTableBody.empty();
                if (data.length === 0) {
                    $payoutsTableBody.html(
                        '<tr><td colspan="10" class="text-center">No matching records found.</td></tr>');
                    return;
                }
                data.forEach(row => {
                    const $tr = $('<tr>');
                    let rowHtml = '';
                    window.payoutTableState.columns.forEach(col => {
                        const hiddenClass = window.payoutTableState.hiddenColumns.includes(col) ?
                            'd-none' : '';
                        if (col === 'actions') {
                            rowHtml +=
                                `<td data-col="${col}" class="text-end ${hiddenClass}"><button class="btn btn-sm btn-outline-danger" data-id="${row.id}">Delete</button></td>`;
                        } else {
                            const value = row[col] !== undefined && row[col] !== null ? row[col] :
                                '-';
                            rowHtml += `<td data-col="${col}" class="${hiddenClass}">${value}</td>`;
                        }
                    });
                    $tr.html(rowHtml);
                    $payoutsTableBody.append($tr);
                });
            }

            function renderColumnsForm() {
                const columnLabels = {
                    date_time: 'Date/Time',
                    teacher_name: 'Teacher',
                    course_name: 'Course',
                    session_name: 'Session',
                    student_name: 'Student',
                    parent_name: 'Parent',
                    paid: 'Paid',
                    remarks: 'Remarks'
                };
                $columnsForm.empty();
                window.payoutTableState.columns.forEach(col => {
                    if (col === 'id' || col === 'actions') return;
                    const isChecked = !window.payoutTableState.hiddenColumns.includes(col);
                    const labelText = columnLabels[col] || col.split('_').map(w => w.charAt(0)
                        .toUpperCase() + w.slice(1)).join(' ');
                    const div = `<div class="form-check">
                <input class="form-check-input" type="checkbox" value="${col}" id="col_${col}" ${isChecked ? 'checked':''}>
                <label class="form-check-label" for="col_${col}">${labelText}</label>
            </div>`;
                    $columnsForm.append(div);
                });
            }

            function applyColumnVisibility() {
                $('table thead th').each(function() {
                    const col = $(this).data('col');
                    $(this).css('display', window.payoutTableState.hiddenColumns.includes(col) ? 'none' :
                        '');
                });
                $('table tbody td').each(function() {
                    const col = $(this).data('col');
                    $(this).css('display', window.payoutTableState.hiddenColumns.includes(col) ? 'none' :
                        '');
                });
            }

            $selectYear.on('change', fetchPayoutsData);

            $('#applyColumns').on('click', function() {
                const hiddenFromChecks = $columnsForm.find('input[type=checkbox]:not(:checked)').map(
                    function() {
                        return this.value;
                    }).get();
                if (!hiddenFromChecks.includes('id')) hiddenFromChecks.push('id');
                window.payoutTableState.hiddenColumns = hiddenFromChecks;
                applyColumnVisibility();
                if (bootstrapModal) bootstrapModal.hide();
            });

            $('#payoutsSearchInput').on('input', function() {
                const term = $(this).val().toLowerCase();
                const filtered = window.payoutTableState.allData.filter(r =>
                    Object.keys(r).some(key => r[key] && String(r[key]).toLowerCase().includes(term))
                );
                window.payoutTableState.currentTableData = filtered;
                renderTable(filtered);
                applyColumnVisibility();
            });

            // --- PDF Export ---
            $('#exportPayoutPdf').on('click', async function() {
                const visibleColumns = window.payoutTableState.columns.filter(c => !window
                    .payoutTableState.hiddenColumns.includes(c) && c !== 'actions');
                if (!visibleColumns.length) return alert('No columns selected to export');
                const columnLabels = {
                    date_time: 'Date/Time',
                    teacher_name: 'Teacher',
                    course_name: 'Course',
                    session_name: 'Session',
                    student_name: 'Student',
                    parent_name: 'Parent',
                    paid: 'Paid',
                    remarks: 'Remarks'
                };
                const headers = visibleColumns.map(key => columnLabels[key] || key.split('_').map(w => w
                    .charAt(0).toUpperCase() + w.slice(1)).join(' '));
                const exportData = window.payoutTableState.currentTableData.map(row => visibleColumns
                    .map(c => row[c] || ''));
                if (!exportData.length) return alert('No data to export');
                if (typeof html2pdf === 'undefined') {
                    await $.getScript(
                        'https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js'
                    );
                }
                const logoUrl = "{{ asset('assets/logo_pic/vteach_logo.png') }}";
                const colWidth = 100 / headers.length;
                let headerHtml = '<tr>';
                headers.forEach(h => {
                    headerHtml +=
                        `<th style="border-bottom:2px solid #4CAF50;padding:10px 6px;font-weight:bold;font-size:10px;text-align:center;background-color:#f3f3f3;color:#333;width:${colWidth}%">${h}</th>`;
                });
                headerHtml += '</tr>';
                let rowsHtml = '';
                exportData.forEach((row, i) => {
                    const bgColor = i % 2 === 0 ? '#ffffff' : '#f9f9f9';
                    rowsHtml += '<tr>';
                    row.forEach(cell => {
                        rowsHtml +=
                            `<td style="border:1px solid #ddd;padding:8px;font-size:9px;text-align:left;background-color:${bgColor};width:${colWidth}%">${cell}</td>`;
                    });
                    rowsHtml += '</tr>';
                });
                const htmlContent = `
            <div style="font-family:Arial,sans-serif;width:95%;padding:10px;margin:auto">
                <div style="text-align:center;margin-bottom:15px">
                    <img src="${logoUrl}" style="height:60px; display:block; margin:0 auto;" />
                    <h2 style="margin:5px 0;color:#4CAF50;">Payout Report</h2>
                    <p style="font-size:10px;color:#666">Generated on: ${new Date().toLocaleString()}</p>
                </div>
                <table style="width:100%;border-collapse:collapse;table-layout:fixed;font-family:Arial,sans-serif">
                    <thead>${headerHtml}</thead>
                    <tbody>${rowsHtml}</tbody>
                </table>
                 <div style="margin-top:40px;width:100%; display:block; page-break-inside:avoid; text-align:center;">
                        <div style="margin-bottom:50px;">
                            <div style="display:inline-block; width:40%; text-align:center;">
                                <p>________________________</p>
                                <p>Teacher Signature</p>
                            </div>
                            <div style="display:inline-block; width:40%; text-align:center; margin-left:5%;">
                                <p>________________________</p>
                                <p>Platform Signature</p>
                            </div>
                        </div>
                    </div>
            </div>`;
                const $element = $(`<div>${htmlContent}</div>`);
                $('body').append($element);
                html2pdf().set({
                    margin: [10, 10, 10, 10],
                    filename: `Payouts_${new Date().toISOString().split('T')[0]}.pdf`,
                    html2canvas: {
                        scale: 2,
                        logging: false,
                        useCORS: true,
                        allowTaint: true
                    },
                    jsPDF: {
                        orientation: 'landscape',
                        unit: 'mm',
                        format: 'a4',
                        compress: true
                    },
                    pagebreak: {
                        mode: ['css', 'legacy'],
                        avoid: 'tr'
                    }
                }).from($element[0]).toPdf().get('pdf').then(pdf => {
                    pdf.save(`Payouts_${new Date().toISOString().split('T')[0]}.pdf`);
                }).finally(() => $element.remove());
            });

            // --- Excel Export ---
            $('#exportPayoutExcel').on('click', function() {
                const visibleColumns = window.payoutTableState.columns.filter(c => !window.payoutTableState
                    .hiddenColumns.includes(c) && c !== 'actions');
                if (!visibleColumns.length) return alert('No columns selected for Excel');

                const exportData = window.payoutTableState.currentTableData.map(row => {
                    const obj = {};
                    visibleColumns.forEach(col => {
                        obj[col] = row[col];
                    });
                    return obj;
                });
                if (!exportData.length) return alert('No data to export');

                const ws = XLSX.utils.json_to_sheet(exportData);

                // Adjust column widths dynamically (or set fixed widths)
                ws['!cols'] = visibleColumns.map(col => {
                    switch (col) {
                        case 'date_time':
                            return {
                                wch: 20
                            };
                        case 'teacher_name':
                            return {
                                wch: 25
                            };
                        case 'course_name':
                            return {
                                wch: 30
                            };
                        case 'session_name':
                            return {
                                wch: 20
                            };
                        case 'student_name':
                            return {
                                wch: 25
                            };
                        case 'parent_name':
                            return {
                                wch: 25
                            };
                        case 'paid':
                            return {
                                wch: 15
                            };
                        case 'remarks':
                            return {
                                wch: 40
                            };
                        default:
                            return {
                                wch: 15
                            };
                    }
                });

                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, 'Payouts');
                XLSX.writeFile(wb, `Payouts_${new Date().toISOString().split('T')[0]}.xlsx`);
            });

            fetchPayoutsData();
        });
    </script>
@endsection
