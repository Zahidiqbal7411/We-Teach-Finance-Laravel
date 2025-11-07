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
                        <option value="{{ $session_data->id }}">{{ $session_data->session_title }}</option>
                    @endforeach
                </select>

                <!-- Currency Dropdown -->


                {{-- <label class="form-label">Default Currency</label>
                <select class="form-select form-select-md w-25" name="default_currency" id="currencySelect">
                    @foreach ($currency_datas as $currency_data)
                        <option value="{{ $currency_data->id }}"
                            {{ $currency_data->selected_currency == 1 ? 'selected' : '' }}>
                            {{ $currency_data->currency_name }}
                        </option>
                    @endforeach
                </select> --}}
                <label class="form-label">Default Currency</label>
                <select class="form-select form-select-md w-25" name="default_currency" id="currencySelect">
                    @foreach ($currency_datas as $currency)
                        <option value="{{ $currency->id }}"
                            {{ $currentCurrency && $currency->id == $currentCurrency->id ? 'selected' : '' }}>
                            {{ $currency->currency_name }}
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


                            <div class="mb-3">
                                <label class="form-label">Current Currency</label>

                                <!-- Readonly visible field for display -->
                                <input type="text" class="form-control text-start"
                                    value="{{ $currentCurrency?->currency_name ?? 'No currency selected' }}" readonly>

                                <!-- Hidden field to hold actual currency value -->
                                <input type="hidden" name="current_currency" id="current_currency"
                                    value="{{ $currentCurrency?->id ?? '' }}">
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
    <!-- Restore Modal -->


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // ================= GLOBAL GUARD =================
        // This prevents the entire script from initializing more than once.
        if (window.platformFinanceScriptInitialized) {
            return;
        }
        window.platformFinanceScriptInitialized = true;

        // ================= GLOBAL VARIABLES (for Create Modal) =================
        const form = document.getElementById("transactionsForm");
        const totalInput = document.getElementById("transaction_total");
        const paidInput = document.getElementById("transaction_paid");
        const remainingInput = document.getElementById("transaction_remaining");
        const transactionsModal = document.getElementById("transactionsModal");
        const tableBody = document.getElementById("transactionsTableBody");
        const mainTabs = document.querySelectorAll('#mainTabContainer .tab-btn');
        const subRecent = document.getElementById('sub-recent');
        const subPerCourse = document.getElementById('sub-percourse');
        const balanceTeacher = document.getElementById('balance-teacher');
        const balancePlatform = document.getElementById('balance-platform');
        const tableHead = document.getElementById('transactionsTableHead');

        const perCourseHead = `
            <tr>
                <th>Course Name</th>
                <th>Session</th>
                <th>Transactions</th>
                <th>Total Amount</th>
                <th>Total Paid</th>
                <th>Total Remaining</th>
                <th>Actions</th>
            </tr>
        `;

        let isSubmitting = false;

        // ===================== FORM REMAINING CALC (Create Modal) =====================
        if (totalInput && paidInput && remainingInput) {
            function calculateRemaining() {
                const total = parseFloat(totalInput.value) || 0;
                const paid = parseFloat(paidInput.value) || 0;
                remainingInput.value = Math.max(0, (total - paid).toFixed(2));
            }
            totalInput.addEventListener("input", calculateRemaining);
            paidInput.addEventListener("input", calculateRemaining);
        }

        // ===================== FORM SUBMIT (Create Modal) =====================
        if (form) {
            form.addEventListener("submit", async function(e) {
                e.preventDefault();
                if (isSubmitting) return;
                isSubmitting = true;

                const formData = new FormData(form);
                const currencyInput = document.getElementById("current_currency");

                if (!currencyInput || !currencyInput.value) {
                    toastr.error("Please select a currency before submitting.");
                    isSubmitting = false;
                    return;
                }
                formData.set("selected_currency_id", currencyInput.value);

                try {
                    const csrfToken = document.querySelector('input[name="_token"]').value;

                    const res = await fetch("{{ route('platform_transaction.store') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": csrfToken
                        },
                        body: formData
                    });

                    const data = await res.json();

                    if (res.ok && data.status === "success") {
                        toastr.success(data.message || "Transaction saved successfully");
                        if (window.loadPlatformTransactions) {
                            window.loadPlatformTransactions(); // reload table
                        }

                        form.reset();
                        if (remainingInput) remainingInput.value = "";

                        if (transactionsModal) {
                            const modalInstance = bootstrap.Modal.getInstance(transactionsModal);
                            if (modalInstance) modalInstance.hide();
                        }
                    } else {
                        toastr.error(data.message || "Failed to save transaction");
                    }
                } catch (err) {
                    console.error(err);
                    toastr.error(err.message || "Unexpected error");
                } finally {
                    isSubmitting = false;
                }
            });
        }

        // ===================== CURRENCY SELECT (Create Modal) =====================
        const currencySelect = document.getElementById("currencySelect");
        if (currencySelect) {
            currencySelect.addEventListener("change", function() {
                const hiddenCurrencyInput = document.getElementById("current_currency");
                const textInput = document.getElementById("current_currency_name");

                if (hiddenCurrencyInput) {
                    hiddenCurrencyInput.value = this.value;
                }
                if (textInput) {
                    textInput.value = this.options[this.selectedIndex].text;
                }
            });
        }

        // ===================== TABS =====================
        function resetSubTabs() {
            if (subRecent) subRecent.style.display = 'none';
            if (subPerCourse) subPerCourse.style.display = 'none';
            if (balanceTeacher) balanceTeacher.style.display = 'none';
            if (balancePlatform) balancePlatform.style.display = 'none';
        }

        mainTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                mainTabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                const target = this.dataset.target;
                ['transactionsDiv', 'payoutsDiv', 'balancesDiv', 'reportsDiv'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.style.display = id === target ? 'block' : 'none';
                });

                resetSubTabs();

                if (target === 'transactionsDiv') {
                    if (subRecent) subRecent.style.display = 'inline-block';
                    if (subPerCourse) subPerCourse.style.display = 'inline-block';
                    if (subRecent) subRecent.click();
                } else if (target === 'balancesDiv') {
                    if (balanceTeacher) balanceTeacher.style.display = 'inline-block';
                    if (balancePlatform) balancePlatform.style.display = 'inline-block';
                    if (balanceTeacher) balanceTeacher.click();
                }
            });
        });

        if (subRecent) {
            subRecent.addEventListener('click', function() {
                subRecent.classList.add('active');
                if (subPerCourse) subPerCourse.classList.remove('active');

                if (tableHead) {
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
                        </tr>
                    `;
                }
                if (window.loadPlatformTransactions) {
                    window.loadPlatformTransactions();
                }
            });
        }

        if (subPerCourse) {
            subPerCourse.addEventListener('click', function() {
                subPerCourse.classList.add('active');
                if (subRecent) subRecent.classList.remove('active');
                if (tableHead) tableHead.innerHTML = perCourseHead;
                if (tableBody) tableBody.innerHTML = "";
            });
        }

        // ===================== LOAD TABLE (NOW FIXED) =====================
        if (tableBody) {
            window.loadPlatformTransactions = async function() {
                try {
                    const res = await fetch("{{ route('platform_transactions.index') }}");
                    const data = await res.json();

                    if (data.status !== "success") {
                        toastr.error("Failed to load transactions");
                        return;
                    }

                    tableBody.innerHTML = ""; // clear table to prevent duplicates

                    // --- START: Row logic is now INSIDE this function ---
                    data.data.forEach(row => {
                        const remaining = row.remaining ?? (row.total - row.paid_amount);

                        // This is the correct currency logic
                        const currencyName = row.selected_currency_name ?? row.currency?.name ?? '';
                        const currencyText = currencyName ? (${currencyName}) : '';

                        const rowHTML = `
                            <tr data-id="${row.id}" id="transaction-row-${row.id}">
                                <td>${row.id}</td>
                                <td>${row.created_at}</td>
                                <td>${row.teacher?.teacher_name ?? '-'}</td>
                                <td>${row.course?.course_title ?? '-'}</td>
                                <td>${row.session?.session_title ?? '-'}</td>
                                <td>${row.student_name ?? '-'}</td>
                                <td>${row.parent_name ?? '-'}</td>
                                <td>${Number(row.total).toFixed(2)} ${currencyText}</td>
                                <td class="paid-amount">${Number(row.paid_amount).toFixed(2)} ${currencyText}</td>
                                <td class="remaining-amount">${Number(remaining).toFixed(2)} ${currencyText}</td>
                                <td class="text-end">
                                    <button class="btn btn-sm icon-btn restore-btn"
                                        data-id="${row.id}"
                                        data-total="${row.total}"
                                        data-paid="${row.paid_amount}">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>
                                    <button class="btn btn-sm icon-btn text-danger delete-btn">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                        
                        // Check if row already exists (for updates)
                        const existingRow = tableBody.querySelector(tr[data-id="${row.id}"]);
                        if (existingRow) {
                            existingRow.outerHTML = rowHTML;
                        } else {
                            tableBody.insertAdjacentHTML('beforeend', rowHTML);
                        }
                    });
                    // --- END: Row logic ---

                } catch (err) {
                    console.error(err);
                    toastr.error("Error fetching transactions");
                }
            }
        }

        // ====================================================================
        // ===================== RESTORE MODAL LOGIC ==========================
        // ====================================================================

        let isSubmittingRestore = false;

        function safeToastr(type, msg) {
            if (typeof toastr !== 'undefined') {
                toastr.clear();
                if (type === 'success') {
                    toastr.success(msg);
                } else if (type === 'error') {
                    toastr.error(msg);
                }
            } else {
                console.log(TOAST ${type.toUpperCase()}:, msg);
            }
        }

        document.body.addEventListener('input', function(e) {
            if (e.target.id !== 'restorePaid') {
                return;
            }
            const form = e.target.closest('form');
            if (!form) return;

            const restoreTotal = form.querySelector('#restoreTotal');
            const restorePaidReadonly = form.querySelector('#restorePaidReadonly');
            const restorePaid = e.target;
            const restoreRemaining = form.querySelector('#restoreRemaining');

            if (!restoreTotal || !restorePaidReadonly || !restoreRemaining) {
                return;
            }

            const total = parseFloat(restoreTotal.value) || 0;
            const paidReadonly = parseFloat(restorePaidReadonly.value) || 0;
            let newPaid = parseFloat(restorePaid.value) || 0;

            if (newPaid < 0) newPaid = 0;
            const remainingBalance = total - paidReadonly;
            if (newPaid > remainingBalance) {
                newPaid = remainingBalance;
            }

            restoreRemaining.value = (total - paidReadonly - newPaid).toFixed(2);
        });

        document.body.addEventListener('blur', function(e) {
            if (e.target.id !== 'restorePaid') {
                return;
            }
            const form = e.target.closest('form');
            if (!form) return;

            const restoreTotal = form.querySelector('#restoreTotal');
            const restorePaidReadonly = form.querySelector('#restorePaidReadonly');
            const restorePaid = e.target;

            if (!restoreTotal || !restorePaidReadonly) return;

            const total = parseFloat(restoreTotal.value) || 0;
            const paidReadonly = parseFloat(restorePaidReadonly.value) || 0;
            let newPaid = parseFloat(restorePaid.value) || 0;

            if (newPaid < 0) newPaid = 0;
            const remainingBalance = total - paidReadonly;
            if (newPaid > remainingBalance) newPaid = remainingBalance;

            restorePaid.value = newPaid.toFixed(2);
        }, true);


        document.body.addEventListener('click', function(e) {
            const btn = e.target.closest('.restore-btn');
            if (!btn) return;

            const id = btn.dataset.id;
            const total = parseFloat(btn.dataset.total) || 0;
            const paid = parseFloat(btn.dataset.paid) || 0;

            const restoreModalEl = document.getElementById('restoreModal');
            if (!restoreModalEl) return;

            const restoreTransactionId = restoreModalEl.querySelector('#restoreTransactionId');
            const restoreTotal = restoreModalEl.querySelector('#restoreTotal');
            const restorePaidReadonly = restoreModalEl.querySelector('#restorePaidReadonly');
            const restorePaid = restoreModalEl.querySelector('#restorePaid');
            const restoreRemaining = restoreModalEl.querySelector('#restoreRemaining');

            if (restoreTransactionId) restoreTransactionId.value = id;
            if (restoreTotal) restoreTotal.value = total.toFixed(2);
            if (restorePaidReadonly) restorePaidReadonly.value = paid.toFixed(2);
            if (restorePaid) restorePaid.value = '';
            if (restoreRemaining) restoreRemaining.value = (total - paid).toFixed(2);

            isSubmittingRestore = false;

            const restoreModal = bootstrap.Modal.getOrCreateInstance(restoreModalEl);
            restoreModal.show();
        });

        document.addEventListener('hidden.bs.modal', function(e) {
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
            isSubmittingRestore = false;
        });

        // ===================== Submit Form (Restore) =====================
        document.addEventListener('submit', function(e) {
            if (e.target.id !== 'restoreForm') {
                return;
            }
            e.preventDefault();
            if (isSubmittingRestore) return;

            isSubmittingRestore = true;
            const submitForm = e.target;
            const submitBtn = submitForm.querySelector('button[type="submit"]');
            if (submitBtn) submitBtn.disabled = true;

            const transactionId = submitForm.querySelector('#restoreTransactionId').value;
            const newPaidValue = parseFloat(submitForm.querySelector('#restorePaid').value) || 0;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            fetch(/platform/transactions/${transactionId}/restore, {
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
                    if (submitBtn) submitBtn.disabled = false;
                    isSubmittingRestore = false;

                    const restoreModalEl = document.getElementById('restoreModal');
                    const restoreModal = bootstrap.Modal.getInstance(restoreModalEl);

                    if (res.status === 'success') {
                        safeToastr('success', res.message || 'Transaction updated successfully');
                        if (restoreModal) {
                            restoreModal.hide();
                        }

                        if (res.data) {
                            const updated = res.data;
                            const newRemainingAmount = (parseFloat(updated.total) - parseFloat(updated.paid_amount)).toFixed(2);
                            const row = document.querySelector(#transaction-row-${transactionId});

                            // This is the correct currency logic for the update
                            const currencyName = updated.selected_currency_name ?? updated.currency?.name ?? '';
                            const currencyText = currencyName ? (${currencyName}) : '';

                            if (row) {
                                const paidCell = row.querySelector('.paid-amount');
                                const remainingCell = row.querySelector('.remaining-amount');
                                const restoreBtn = row.querySelector('.restore-btn');

                                if (paidCell) paidCell.textContent = ${parseFloat(updated.paid_amount).toFixed(2)} ${currencyText};
                                if (remainingCell) remainingCell.textContent = ${newRemainingAmount} ${currencyText};
                                if (restoreBtn) restoreBtn.dataset.paid = updated.paid_amount;
                            }
                        }
                    } else {
                        safeToastr('error', res.message || 'Failed to update transaction');
                    }
                })
                .catch(err => {
                    console.error("Fetch Error:", err);
                    if (submitBtn) submitBtn.disabled = false;
                    isSubmittingRestore = false;

                    const restoreModalEl = document.getElementById('restoreModal');
                    const restoreModal = bootstrap.Modal.getInstance(restoreModalEl);
                    if (restoreModal) {
                        restoreModal.hide();
                    }
                    safeToastr('error', 'Network error or unhandled exception. Please try again.');
                });
        });

        // ===================== INITIAL LOAD =====================
        // Trigger the 'Recent' sub-tab to load the table on page load
        if (subRecent) {
             subRecent.click();
        } else if (window.loadPlatformTransactions) {
             // Fallback if tabs don't exist
             window.loadPlatformTransactions();
        }

    });
</script>

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


    <!-- ✅ Store Transaction Modal Form -->





    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Prevent double initialization
            if (window.transactionsScriptInitialized) return;
            window.transactionsScriptInitialized = true;

            const form = document.getElementById("transactionsForm");
            const totalInput = document.getElementById("transaction_total");
            const paidInput = document.getElementById("transaction_paid");
            const remainingInput = document.getElementById("transaction_remaining");
            const transactionsModal = document.getElementById("transactionsModal");
            const tableBody = document.getElementById("transactionsTableBody");
            let isSubmitting = false;

            // Auto-calculate remaining
            function calculateRemaining() {
                const total = parseFloat(totalInput.value) || 0;
                const paid = parseFloat(paidInput.value) || 0;
                remainingInput.value = Math.max(0, (total - paid).toFixed(2));
            }
            totalInput.addEventListener("input", calculateRemaining);
            paidInput.addEventListener("input", calculateRemaining);

            // Form submit via AJAX (attach only once)
            form.addEventListener("submit", async function(e) {
                e.preventDefault();
                if (isSubmitting) return;
                isSubmitting = true;

                const formData = new FormData(form);
                const currencyInput = document.getElementById("current_currency");

                if (!currencyInput || !currencyInput.value) {
                    toastr.error("Please select a currency before submitting.");
                    isSubmitting = false;
                    return;
                }
                formData.set("selected_currency_id", currencyInput.value);

                try {
                    const csrfToken = document.querySelector('input[name="_token"]').value;

                    const res = await fetch("{{ route('platform_transaction.store') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": csrfToken
                        },
                        body: formData
                    });

                    const data = await res.json();

                    if (res.ok && data.status === "success") {
                        toastr.success(data.message || "Transaction saved successfully");

                        // Reload table from server
                        loadPlatformTransactions();

                        // Reset form
                        form.reset();
                        remainingInput.value = "";

                        // Close modal
                        if (transactionsModal) {
                            const modalInstance = bootstrap.Modal.getInstance(transactionsModal);
                            if (modalInstance) modalInstance.hide();
                        }
                    } else {
                        toastr.error(data.message || "Failed to save transaction");
                    }
                } catch (err) {
                    console.error(err);
                    toastr.error(err.message || "Unexpected error");
                } finally {
                    isSubmitting = false;
                }
            });

            // Currency select
            const currencySelect = document.getElementById("currencySelect");
            if (currencySelect) {
                currencySelect.addEventListener("change", function() {
                    const hiddenInput = document.getElementById("current_currency");
                    const textInput = document.getElementById("current_currency_name");

                    if (hiddenInput) hiddenInput.value = this.value;
                    if (textInput) textInput.value = this.options[this.selectedIndex].text;
                });
            }

            // Load transactions table
            window.loadPlatformTransactions = async function() {
                try {
                    const res = await fetch("{{ route('platform_transactions.index') }}");
                    const data = await res.json();

                    if (data.status !== "success") {
                        toastr.error("Failed to load transactions");
                        return;
                    }

                    tableBody.innerHTML = ""; // Clear table to avoid duplicates

                    data.data.forEach(row => {
                        const remaining = row.remaining ?? (row.total - row.paid_amount);
                        const currency = row.selected_currency_name ?? '';
                        console.log(currency);

                        const rowHTML = `
                    <tr data-id="${row.id}">
                        <td>${row.id}</td>
                        <td>${row.created_at}</td>
                        <td>${row.teacher?.teacher_name ?? '-'}</td>
                        <td>${row.course?.course_title ?? '-'}</td>
                        <td>${row.session?.session_title ?? '-'}</td>
                        <td>${row.student_name ?? '-'}</td>
                        <td>${row.parent_name ?? '-'}</td>
                        <td>${Number(row.total).toFixed(2)} (${currency})</td>
                        <td>${Number(row.paid_amount).toFixed(2)} (${currency})</td>
                        <td>${Number(remaining).toFixed(2)} (${currency})</td>
                        <td class="text-end">
                            <button class="btn btn-sm icon-btn restore-btn"
                                data-id="${row.id}"
                                data-total="${row.total}"
                                data-paid="${row.paid_amount}">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </button>
                            <button class="btn btn-sm icon-btn text-danger delete-btn">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        </td>
                    </tr>
                `;
                        tableBody.insertAdjacentHTML('beforeend', rowHTML);
                    });
                } catch (err) {
                    console.error(err);
                    toastr.error("Error fetching transactions");
                }
            };

            // Initial table load
            loadPlatformTransactions();
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
                    beforeSend: function() {
                        toastr.clear();
                    },
                    success: function(res) {
                        if (res.success) {
                            // Update inputs only after successful response
                            $('#current_currency').val(selectedCurrencyName);
                            $('#selected_currency_id').val(selectedCurrencyId);

                            toastr.clear();
                            setTimeout(() => {
                                toastr.success('✅ Currency updated successfully!');
                            }, 200);

                            // Update the selected option visually
                            $('#currencySelect option').each(function() {
                                $(this).prop('selected', $(this).val() ==
                                    selectedCurrencyId);
                            });
                        } else {
                            toastr.clear();
                            setTimeout(() => {
                                toastr.error('❌ Something went wrong.');
                            }, 200);
                        }
                    },
                    error: function() {
                        toastr.clear();
                        setTimeout(() => {
                            toastr.error('❌ Server error. Please try again.');
                        }, 200);
                    }
                });
            });
        });
    </script>
@endsection
