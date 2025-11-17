@extends('layouts.app')

@section('contents')
    <div class="main-content p-4" style="margin-left: 260px; min-height: 100vh; background: #f8f9fa;">

    <!-- ✅ Top Bar -->
    <div class="teacher-topbar d-flex justify-content-between align-items-center mb-4 p-3"
         style="background: #ffffff; border-radius: 10px;">
        <div>
            <h4 class="fw-semibold mb-0">Teachers</h4>
        </div>
        <div class="d-flex align-items-center gap-3">
            <select class="form-select form-select-md" id="SelectYear" name="year" style="outline: none !important; box-shadow: none !important;">
                <option>May/June 2026</option>
                <option>May/June 2027</option>
            </select>
            <select class="form-select form-select-md" id="currencySelect" name="currency" style="outline: none !important; box-shadow: none !important;">
                <option>EG/EGP</option>
                <option>US/USD</option>
                <option>EU/EUR</option>
            </select>
        </div>
    </div>

        <!-- Header -->
        <div class="mb-4">
            <h4 class="fw-semibold mb-1">Teachers</h4>
            <p class="text-muted mb-0">Manage teacher transactions, payouts, and reports</p>
        </div>

    <!-- Select Teacher -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body d-flex justify-content-center">
            <div style="width: 30%; margin-right: 1050px; padding-left: 0;">
                <label for="teacherSelect" class="form-label fw-semibold">Select Teacher</label>
                <select id="teacherSelect" class="form-select">
                    <option value="">Select Teacher</option>
                    <option value="1">Prof. Sarah Johnson</option>
                    <option value="2">Mr. John Doe</option>
                    <option value="3">Ms. Olivia Smith</option>
                </select>
            </div>
        </div>
    </div>

        <!-- 🧾 No Teacher Selected -->
        <div id="noTeacherSelected" class="card border-0 shadow-sm text-center p-5" style="display: block;">
            <h5 class="fw-semibold mb-2">No Teacher Selected</h5>
            <p class="text-muted mb-0">Please select a teacher from the dropdown above to view their data.</p>
        </div>

    <!-- ✅ Teacher Full Data -->
    <div id="teacherData" style="display: none;">
        
        <!-- Profile -->
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body d-flex align-items-center">
                <div class="me-3">
                    <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center" style="width:48px;height:48px;">
                        <i class="fa-solid fa-user"></i>
                    </div>
                </div>
                <div>
                    <h6 class="fw-semibold mb-0">Prof. Sarah Johnson</h6>
                    <small class="text-muted">sarah.johnson@weteach.com</small>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-wrapper me-3">
                            <i class="fa-solid fa-dollar-sign fa-lg text-danger"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-1">Current Balance</p>
                            <h5 class="fw-bold text-danger mb-0">-LE 6,725.30</h5>
                            <small class="text-muted">Available for payout</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-wrapper me-3">
                            <i class="fa-solid fa-arrow-trend-up fa-lg text-success"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-1">Paid Before</p>
                            <h5 class="fw-bold text-success mb-0">LE 12,340.00</h5>
                            <small class="text-muted">Total payouts received</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-wrapper me-3">
                            <i class="fa-solid fa-file fa-lg text-primary"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-1">Total Earned</p>
                            <h5 class="fw-bold text-primary mb-0">LE 5,614.70</h5>
                            <small class="text-muted">Lifetime earnings</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <!-- Tabs -->
            <div class="d-flex gap-2 mb-3 flex-wrap" id="mainTabContainer">
                <button class="tab-btn active" data-target="transactionsDiv">Transactions</button>
                <button class="tab-btn" data-target="payoutsDiv">Payouts</button>
                <button class="tab-btn" data-target="balancesDiv">Balances</button>
                <button class="tab-btn" data-target="reportsDiv">Reports</button>
            </div>

            <!-- Sub Tabs (Transactions only) -->
            <div class="d-flex gap-2 mb-3 flex-wrap" id="subTabContainer" style="display: none;">
                <button class="tab-btn active" id="sub-recent">Recent</button>
                <button class="tab-btn" id="sub-percourse">Per Course</button>
            </div>

        <!-- Transactions -->
        <div id="transactionsDiv" class="card shadow-sm border-0 rounded-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <h5 class="fw-semibold mb-2 mb-md-0">Recent Transactions</h5>
                    <div class="d-flex gap-2 flex-wrap">
                        <button class="btn btn-dark btn-sm"><i class="fa-solid fa-plus me-1"></i> Add</button>
                        <button class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-filter me-1"></i> Filter</button>
                        <button class="btn btn-outline-success btn-sm"><i class="fa-solid fa-file-export me-1"></i> Export</button>
                        <button class="btn btn-outline-dark btn-sm"><i class="fa-solid fa-table-columns me-1"></i> Columns</button>
                    </div>
                </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-search"></i></span>
                        <input type="text" class="form-control border-start-0" id="searchInput"
                            placeholder="Search...">
                    </div>

                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-light" id="transactionsThead">
                            <tr>
                                <th><input type="checkbox"></th>
                                <th>ID</th>
                                <th>Date/Time</th>
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
                                <td><input type="checkbox"></td>
                                <td>2</td>
                                <td>10/7/2024, 4:45:00 PM</td>
                                <td>A-Level Physics</td>
                                <td>May/June 2026</td>
                                <td>Emma Wilson</td>
                                <td>David Wilson</td>
                                <td>$ 120.00 USD</td>
                                <td>$ 60.00 USD</td>
                                <td>$ 60.00 USD</td>
                                <td class="text-end"><button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Payouts -->
        <div id="payoutsDiv" class="card shadow-sm border-0 rounded-3" style="display: none;">
            <div class="card-body">
                <h5 class="fw-semibold mb-3">Payouts</h5>
                <div class="d-flex justify-content-end gap-2 mb-3">
                    <button class="btn btn-outline-success btn-sm"><i class="fa-solid fa-file-export me-1"></i> Export</button>
                    <button class="btn btn-outline-dark btn-sm"><i class="fa-solid fa-table-columns me-1"></i> Columns</button>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-search"></i></span>
                    <input type="text" class="form-control border-start-0" placeholder="Search...">
                </div>
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Date/Time</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2</td>
                            <td>10/1/2024, 9:00:00 AM</td>
                            <td>September 2024 Earnings</td>
                            <td>Monthly payout for teaching services</td>
                            <td>$ 400.00 USD</td>
                            <td><button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Balances -->
        <div id="balancesDiv" class="card shadow-sm border-0 rounded-3" style="display: none;">
            <div class="card-body">
                <h5 class="fw-semibold mb-3">Balance Details</h5>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <div class="icon-wrapper me-3">
                                    <i class="fa-solid fa-dollar-sign fa-lg text-danger"></i>
                                </div>
                                <div>
                                    <p class="text-muted small mb-1">Current Balance</p>
                                    <h5 class="fw-bold text-danger mb-0">-LE 6,725.30</h5>
                                    <small class="text-muted">Available for payout</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <div class="icon-wrapper me-3">
                                    <i class="fa-solid fa-arrow-trend-up fa-lg text-success"></i>
                                </div>
                                <div>
                                    <p class="text-muted small mb-1">Total Paid Out</p>
                                    <h5 class="fw-bold text-success mb-0">LE 12,340.00</h5>
                                    <small class="text-muted">Total payouts received</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                    <p class="text-muted small mb-0">
                        Balance is calculated based on 70% teacher share of paid transactions minus total payouts.
                    </p>
                </div>
            </div>

        <!-- Reports -->
        <div id="reportsDiv" class="card shadow-sm border-0 rounded-3" style="display: none;">
            <div class="card-body">
                <h5 class="fw-semibold mb-3">Generated Reports</h5>
                <div class="d-flex justify-content-end gap-2 mb-3">
                    <button class="btn btn-dark btn-sm"><i class="fa-solid fa-plus me-1"></i> Add</button>
                    <button class="btn btn-outline-success btn-sm"><i class="fa-solid fa-file-export me-1"></i> Export</button>
                    <button class="btn btn-outline-dark btn-sm"><i class="fa-solid fa-table-columns me-1"></i> Columns</button>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-search"></i></span>
                    <input type="text" class="form-control border-start-0" placeholder="Search...">
                </div>
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>From Date</th>
                            <th>To Date</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td colspan="7" class="text-center text-muted">No data available</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Elements
    const teacherSelect = document.getElementById('teacherSelect');
    const noTeacherSelected = document.getElementById('noTeacherSelected');
    const teacherData = document.getElementById('teacherData');

            const mainTabContainer = document.getElementById('mainTabContainer');
            const mainTabBtns = document.querySelectorAll('#mainTabContainer .tab-btn');

            const subTabContainer = document.getElementById('subTabContainer');
            const subRecent = document.getElementById('sub-recent');
            const subPerCourse = document.getElementById('sub-percourse');

            const sections = ['transactionsDiv', 'payoutsDiv', 'balancesDiv', 'reportsDiv'];

            const transactionsDiv = document.getElementById('transactionsDiv');
            const thead = document.getElementById('transactionsThead');
            const tbody = document.getElementById('transactionsTableBody');

            const originalHead = thead.innerHTML;
            const originalBody = tbody.innerHTML;

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
    const perCourseBody = `
        <tr>
            <td>IB Chemistry HL</td>
            <td>May/June 2026</td>
            <td>1</td>
            <td>LE 150.00</td>
            <td>LE 75.00</td>
            <td>LE 75.00</td>
            <td><button class="btn btn-sm btn-dark viewCourseDetails">View</button></td>
        </tr>`;

    // Utility: show a section and hide others. Also manage subTab visibility.
    function showSection(target) {
        sections.forEach(id => {
            const el = document.getElementById(id);
            if (!el) return;
            el.style.display = (id === target) ? 'block' : 'none';
        });

        if (target === 'transactionsDiv') {
            // show sub-tabs & reset to Recent
            subTabContainer.style.display = 'flex';
            activateSub('recent');
        } else {
            // hide sub-tabs and reset their classes
            subTabContainer.style.display = 'none';
            subRecent.classList.remove('active');
            subPerCourse.classList.remove('active');
            // ensure transactions table returns to original when re-opened
            restoreOriginalTransactions();
        }
    }

    // Activate a main tab
    function activateMainTab(button) {
        mainTabBtns.forEach(b => b.classList.remove('active'));
        if (button) button.classList.add('active');
        const target = button ? button.dataset.target : 'transactionsDiv';
        showSection(target);
    }

    // Sub tab activation
    function activateSub(which) {
        if (which === 'recent') {
            subRecent.classList.add('active');
            subPerCourse.classList.remove('active');
            restoreOriginalTransactions();
        } else if (which === 'percourse') {
            subPerCourse.classList.add('active');
            subRecent.classList.remove('active');
            switchToPerCourse();
        }
    }

    // Restore original transactions table
    function restoreOriginalTransactions() {
        thead.innerHTML = originalHead;
        tbody.innerHTML = originalBody;
        attachDeleteHandlers(); // re-attach any handlers for original rows if needed
    }

    // Switch to per-course table and attach view button handler
    function switchToPerCourse() {
        thead.innerHTML = perCourseHead;
        tbody.innerHTML = perCourseBody;

        // Attach viewCourseDetails handler AFTER inserting HTML
        const viewBtn = tbody.querySelector('.viewCourseDetails');
        if (viewBtn) {
            viewBtn.addEventListener('click', function () {
                showCourseDetails();
            });
        }
    }

    // Example: show details panel (keeps previous behavior)
    function showCourseDetails() {
        // create or reuse a detail card next to transactionsDiv
        let detailCard = transactionsDiv.querySelector('.detail-card-custom');
        if (!detailCard) {
            detailCard = document.createElement('div');
            detailCard.className = 'card border-0 shadow-sm mt-3 p-3 detail-card-custom';
            detailCard.innerHTML = `
                <div class="detail-content">
                    <h6 class="fw-semibold mb-2">Transaction Details</h6>
                    <div class="detail-body"></div>
                    <div class="text-end mt-2">
                        <button class="btn btn-sm btn-outline-dark closeDetail">Close</button>
                    </div>
                </div>`;
                    transactionsDiv.querySelector('.card-body').appendChild(detailCard);

                    detailCard.querySelector('.closeDetail').addEventListener('click', () => {
                        detailCard.style.display = 'none';
                    });
                }

                if (!course) course = {
                    transactions_details: []
                };

                let rows = '';
                (course.transactions_details || []).forEach(tx => {
                    rows += `
                <tr>
                    <td>${tx.id}</td>
                    <td>${tx.date}</td>
                    <td>${tx.student}</td>
                    <td>${tx.total} (${tx.currency})</td>
                    <td>${tx.paid} (${tx.currency})</td>
                    <td>${tx.remaining} (${tx.currency})</td>
                </tr>`;
                });

                detailCard.querySelector('.detail-body').innerHTML = `
            <table class="table table-hover table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Date/Time</th>
                        <th>Student</th>
                        <th>Total</th>
                        <th>Paid</th>
                        <th>Remaining</th>
                    </tr>
                </thead>
                <tbody>${rows}</tbody>
            </table>`;
                detailCard.style.display = 'block';
            }

    // (Optional) re-attach delete or other handlers if original rows are replaced
    function attachDeleteHandlers() {
        // Example: find delete buttons and attach a simple click handler (no-op or confirm)
        const deletes = document.querySelectorAll('button.btn-outline-danger');
        deletes.forEach(btn => {
            if (!btn.dataset.handlerAttached) {
                btn.addEventListener('click', function (e) {
                    // simple confirm - you can replace with your real delete logic
                    if (!confirm('Are you sure you want to delete this row?')) {
                        e.preventDefault();
                    }
                });
                btn.dataset.handlerAttached = '1';
            }
        });
    }

    // ——— Event wiring ———

    // Main tab buttons
    mainTabBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            activateMainTab(btn);
        });
    });

    // Sub-tab buttons
    subRecent.addEventListener('click', function () { activateSub('recent'); });
    subPerCourse.addEventListener('click', function () { activateSub('percourse'); });

    // Teacher select change: show/hide teacherData + ensure correct tab state
    teacherSelect.addEventListener('change', function () {
        const val = this.value;
        if (val) {
            noTeacherSelected.style.display = 'none';
            teacherData.style.display = 'block';
            // Ensure UI starts on Transactions with sub-tabs visible (matching Platform)
            // Activate the Transactions main tab button
            const transBtn = Array.from(mainTabBtns).find(b => b.dataset.target === 'transactionsDiv');
            activateMainTab(transBtn || mainTabBtns[0]);
        } else {
            noTeacherSelected.style.display = 'block';
            teacherData.style.display = 'none';
            // hide sub-tabs just in case
            subTabContainer.style.display = 'none';
        }
    });

    // Initial state: sub-tabs hidden until a teacher is selected (keeps behaviour consistent)
    subTabContainer.style.display = 'none';
    attachDeleteHandlers();

    // If you want the UI to auto-open teacher data for a preselected value on load,
    // call teacherSelect.dispatchEvent(new Event('change')) here.
});
</script>
@endsection
