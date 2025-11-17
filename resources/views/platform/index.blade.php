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
                <option value="{{ $session_data->id }}" {{ request()->get('session_id') == $session_data->id ?
                    'selected' : '' }}>
                    {{ $session_data->session_title }}
                </option>
                @endforeach
            </select>

            <!-- Currency Dropdown -->


            <label class="form-label">Default Currency</label>
            <select class="form-select form-select-md w-25" name="default_currency" id="currencySelect">
                @foreach ($currency_datas as $currency_data)
                <option value="{{ $currency_data->id }}" {{ $currency_data->id == $selected_currency_id ? 'selected' :
                    '' }}>
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
                            <input type="number" class="form-control" name="total" id="transaction_total" step="0.01">
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
                <button class="btn btn-outline-success btn-sm"><i class="fa-solid fa-file-export me-1"></i>
                    Export</button>
                <button class="btn btn-outline-dark btn-sm"><i class="fa-solid fa-table-columns me-1"></i>
                    Columns</button>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-search"></i></span>
                <input type="text" class="form-control border-start-0" placeholder="Search...">
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
                            <td><button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
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



                        {{-- <tr>
                            <td>1</td>
                            <td>Dr. Ahmed Hassan</td>
                            <td>October 2024 Transactions Report</td>
                            <td>Recent</td>
                            <td>2024-10-01</td>
                            <td>2024-10-31</td>
                            <td>10/8/2024, 3:00:00 PM</td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
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
                                <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr> --}}
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
@endsection

@section('scripts')
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
            const selectYear = document.getElementById('SelectYear');
            // Get the balances main tab button
                const balancesTabBtn = document.querySelector('button.tab-btn[data-target="balancesDiv"]');
            const perCourseHead = `
            <tr>
            <th>Course Name</th>
            <th>Session</th>
            <th>Transactions</th>
            <th>Total Amount</th>
            <th>Platform Amount</th>
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
                        payoutsTableBody.innerHTML = '<tr><td colspan="9" class="text-center text-warning">Please select a session first</td></tr>';
                        return;
                    }

                    // Show loading state
                    payoutsTableBody.innerHTML = '<tr><td colspan="9" class="text-center">Loading...</td></tr>';

                    const payoutsUrl = "{{ route('payouts.data', ['session_id' => ':sessionId']) }}".replace(':sessionId', sessionId);

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
                                payoutsTableBody.innerHTML = '<tr><td colspan="9" class="text-center">No payouts found for this session</td></tr>';
                            } else {
                                payoutsTableBody.innerHTML = `<tr><td colspan="9" class="text-center text-danger">${data.message}</td></tr>`;
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching payouts:', error);
                            payoutsTableBody.innerHTML = '<tr><td colspan="9" class="text-center text-danger">Error loading data</td></tr>';
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
                            <td>${dateTime}</td>
                            <td>${teacherName}</td>
                            <td>${courseName}</td>
                            <td>${sessionName}</td>
                            <td>${studentName}</td>
                            <td>${parentName}</td>
                            <td>${paidAmount} (${currency})</td>
                            <td>${remarks}</td>
                            <td class="text-end">
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
                document.querySelector('#payoutsDiv input[type="text"]').addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase();
                    const rows = document.querySelectorAll('#payoutsTableBody tr');

                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                });

                // Optional: Refresh payouts when session changes
                selectYear.addEventListener('change', function() {
                    // If payouts tab is currently active, refresh the data
                    const payoutsTab = document.querySelector('.tab-btn[data-target="payoutsDiv"]');
                    if (payoutsTab.classList.contains('active')) {
                        fetchPayoutsData();
                    }
                });









            // ================= SUB TABS =================
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
                loadPlatformTransactions(selectYear.value);
            });

            subPerCourse.addEventListener('click', function() {
                subPerCourse.classList.add('active');
                subRecent.classList.remove('active');
                tableHead.innerHTML = perCourseHead;
                tableBody.innerHTML = "";
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

                        res.data.forEach(course => {
                            const courseName = course.course_title ?? "-";
                            const sessionTitle = course.session_title ?? "-";
                            const transactionCount = course.transactions_count ?? 0;

                            const totalAmount = ` ${Number(course.total_amount).toFixed(2)}  (${currency})`;
                            const platformAmount = `${Number(course.platform_amount ?? 0).toFixed(2)} (${currency})`;
                            const totalPaid = `${Number(course.total_paid).toFixed(2)} (${currency})`;

                            // ✅ Remaining = total_paid - platform_amount
                            const totalRemaining = `${(Number(course.total_paid) - Number(course.platform_amount ?? 0)).toFixed(2)} (${currency})`;

                            tableBody.insertAdjacentHTML("beforeend", `
                                <tr>
                                    <td>${courseName}</td>
                                    <td>${sessionTitle}</td>
                                    <td>${transactionCount}</td>
                                    <td>${totalAmount}</td>
                                    <td>${platformAmount}</td>
                                    <td>${totalPaid}</td>
                                    <td>${totalRemaining}</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary view-details"
                                            data-course-id="${course.course_id}"
                                            data-session-id="${sessionId}">
                                            View
                                        </button>
                                    </td>
                                </tr>
                            `);
                        });
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
                            data.forEach((row, index) => {
                                // ✅ Compute platform paid amount from payments array
                                const platformPaid = row.payments?.reduce((sum, p) => sum + parseFloat(p.paid_amount || 0), 0) || 0;

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

                                tableBody.insertAdjacentHTML('beforeend', `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${createdAt}</td>
                                        <td>${row.teacher?.teacher_name ?? '-'}</td>
                                        <td>${row.course?.course_title ?? '-'}</td>
                                        <td>${row.session?.session_title ?? '-'}</td>
                                        <td>${row.student_name ?? '-'}</td>
                                        <td>${row.parent_name ?? '-'}</td>
                                        <td>${Number(row.total).toFixed(2)} (${currencyName})</td>
                                        <td>${platformPaid.toFixed(2)} (${currencyName})</td>
                                        <td>${remaining.toFixed(2)} (${currencyName})</td>
                                        <td class="text-end">
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
                        loadPlatformTransactions(sessionId);   // ✅ If Recent tab active
                    }

                    if (subPerCourse.classList.contains("active")) {
                        loadPerCourseTransactions(sessionId);  // ✅ If PerCourse tab active
                    }

                    // ✅ Add balances tab scenario
                    if (balancesTabBtn.classList.contains("active")) {
                        loadTeacherBalances(sessionId);  // If Balances tab active
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
                            const totalRevenueFormatted = `${teacher.total_revenue.toLocaleString()} (${currencyName})`;
                            const platformShareFormatted = `${teacher.total_platform_share.toLocaleString()} (${currencyName})`;
                            const platformPaidFormatted = `${teacher.total_platform_paid.toLocaleString()} (${currencyName})`;
                            const platformBalanceFormatted = `${teacher.total_platform_balance.toLocaleString()} (${currencyName})`;

                            tbody.insertAdjacentHTML('beforeend', `
                                <tr>
                                    <td>${teacher.name}</td>
                                    <td>${totalRevenueFormatted}</td>
                                    <td>${platformShareFormatted}</td>
                                    <td>${platformPaidFormatted}</td>
                                    <td>${platformBalanceFormatted}</td>
                                    <td>
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
            document.querySelector('#transactionsSearchInput').addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const rows = document.querySelectorAll('#transactionsTableBody tr');

                rows.forEach(row => {
                    // Combine all cell text for search
                    const text = Array.from(row.cells).map(cell => cell.textContent.toLowerCase()).join(' ');
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });


                // Update your existing balancesTabBtn click event to use the function
                balancesTabBtn.addEventListener('click', function() {
                    const sessionId = selectYear.value;
                    loadTeacherBalances(sessionId);
                });




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



<script>
    document.addEventListener("DOMContentLoaded", function() {

    const form = document.getElementById("transactionsForm");
    const totalInput = document.getElementById("transaction_total");
    const paidInput = document.getElementById("transaction_paid");
    const remainingInput = document.getElementById("transaction_remaining");
    const transactionsModal = document.getElementById('transactionsModal');
    const tableBody = document.getElementById('transactionsTableBody'); // Updated to match your table structure

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
                    toastr.error(err.message || "Unexpected error occurred while saving transaction");
                }
            }
            finally {
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

<script>
    $(document).ready(function () {
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
    $("#SelectYear").on("change", function () {
        updateTransactionSession();
    });
});
</script>


</script>

@endsection