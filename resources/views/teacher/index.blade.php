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

                <select id="SelectYear" class="form-select form-select-md" name="session_id">
                    @foreach ($session_datas as $session_data)
                        <option value="{{ $session_data->id }}">{{ $session_data->session_title }}</option>
                    @endforeach
                </select>



                <select class="form-select form-select-md w-50" name="default_currency" id="currencySelect">
                    @foreach ($currency_datas as $currency)
                        <option value="{{ $currency->id }}" @if ($currentCurrency && $currency->id == $currentCurrency->id) selected @endif>
                            {{ $currency->currency_name }}
                        </option>
                    @endforeach
                </select>


                <!-- Hidden inputs to store current selection -->
                <input type="hidden" id="current_currency" name="current_currency" value="{{ $currentCurrency?->id }}">
                <input type="hidden" id="current_currency_name" name="current_currency_name"
                    value="{{ $currentCurrency?->currency_name }}">



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

                    <select id="teacherSelect" class="form-select" name="teacher_id">
                        <option value="" selected disabled>Select a teacher</option>
                        @foreach ($teacher_datas as $teacher)
                            <option value="{{ $teacher->id }}">
                                {{ $teacher->teacher_name }}
                            </option>
                        @endforeach
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
                        <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center"
                            style="width:48px;height:48px;">
                            <i class="fa-solid fa-user"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="fw-semibold mb-0" id="teacher_name">Prof. Sarah J</h6>
                        <small class="text-muted" id="teacher_email">sarah.johnson@weteach.com</small>
                    </div>
                </div>
            </div>


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

                                <!-- Hidden inputs for IDs -->
                                <input type="hidden" name="teacher_id" id="transaction_teacher_id">
                                <input type="hidden" name="session_id" id="transaction_session_id">

                                <!-- Teacher -->
                                <div class="mb-3">
                                    <label class="form-label">Teacher</label>
                                    <input type="text" id="transaction_teacher" class="form-control" readonly>
                                </div>

                                <!-- Course -->
                                <div class="mb-3">
                                    <label class="form-label">Course</label>
                                    <select class="form-select" id="transaction_course" name="course">
                                        <option selected disabled>Select Course</option>
                                        @foreach ($subject_datas as $course)
                                            <option value="{{ $course->id }}">{{ $course->course_title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Session -->
                                <div class="mb-3">
                                    <label class="form-label">Session</label>
                                    <input type="text" id="transaction_session" class="form-control" readonly>
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

                                <!-- Currency -->
                                <div class="mb-3">
                                    <label class="form-label">Current Currency</label>
                                    <input type="text" class="form-control"
                                        value="{{ $currentCurrency?->currency_name ?? 'No currency selected' }}" readonly>
                                    <input type="hidden" name="current_currency" id="current_currency"
                                        value="{{ $currentCurrency?->id ?? '' }}">
                                </div>

                                <!-- Total, Paid, Remaining -->
                                <div class="mb-3">
                                    <label class="form-label">Total</label>
                                    <input type="number" class="form-control" name="total" id="transaction_total">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Paid</label>
                                    <input type="number" class="form-control" name="paid_amount" id="transaction_paid">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Remaining</label>
                                    <input type="number" class="form-control" name="remaining"
                                        id="transaction_remaining" step="0.01" readonly>
                                </div>

                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-dark">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="row g-3 mb-4">
                <!-- Total Earned - First Position -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="fa-solid fa-file fa-lg text-primary"></i>
                            </div>
                            <div>
                                <p class="text-muted small mb-1">Total Revenue</p>
                                <h5 class="fw-bold text-primary mb-0 total-earned-value">LE 0.00</h5>
                                <small class="text-muted">Lifetime earnings</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Current Balance - Second Position -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="fa-solid fa-dollar-sign fa-lg text-danger"></i>
                            </div>
                            <div>
                                <p class="text-muted small mb-1">Current Balance</p>
                                <h5 class="fw-bold text-danger mb-0 current-balance-value">-LE 6,725.30</h5>
                                <small class="text-muted">Available for payout</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paid Before - Third Position -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="fa-solid fa-arrow-trend-up fa-lg text-success"></i>
                            </div>
                            <div>
                                <p class="text-muted small mb-1">Paid Before</p>
                                <h5 class="fw-bold text-success mb-0 paid-before-value">LE 0.00</h5>
                                <small class="text-muted">Total payouts received</small>
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
                                    <td class="text-end"><button class="btn btn-sm btn-outline-danger"><i
                                                class="fa-solid fa-trash"></i></button></td>
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
                            <thead class="table-light">
                                <tr>
                                    <th>Date/Time</th>
                                    <th>Teacher Name</th>
                                    <th>Course Name</th>
                                    <th>Session Name</th>
                                    <th>Student Name</th>
                                    <th>Parent Name</th>
                                    <th>Paid Amount</th>
                                    <th>Remarks</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="payoutsTableBody">
                                <tr>
                                    <td colspan="9" class="text-center text-muted">Select a teacher to view payouts
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
                                        <h5 class="fw-bold text-danger mb-0 current-balance-value">-LE 6,725.30</h5>
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
                                        <h5 class="fw-bold text-success mb-0 total-paid-out-value">LE 12,340.00</h5>
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
                        <button class="btn btn-outline-success btn-sm"><i class="fa-solid fa-file-export me-1"></i>
                            Export</button>
                        <button class="btn btn-outline-dark btn-sm"><i class="fa-solid fa-table-columns me-1"></i>
                            Columns</button>
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
                            <tr>
                                <td colspan="7" class="text-center text-muted">No data available</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
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
                            <textarea id="restoreRemarks" class="form-control" rows="3" placeholder="Enter remarks/description"></textarea>
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
    {{-- This is the script for teacher index --}}
    <script>
        // ================== CALCULATE CURRENT BALANCE ==================
        window.updateCurrentBalance = function updateCurrentBalance(teacherId, sessionId, currencyId) {
            if (!teacherId || !sessionId || !currencyId) return;
            const balanceUrl = "{{ route('teachers.balance', ['teacherId' => ':teacherId']) }}"
                .replace(':teacherId', teacherId) + `?session_id=${sessionId}&currency_id=${currencyId}`;
            fetch(balanceUrl)
                .then(resp => resp.json())
                .then(data => {
                    if (data.success) {
                        const balanceValue = data.current_balance || 0;
                        const currencyName = data.currency_name || '';
                        const balanceText =
                            `${balanceValue.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} ${currencyName}`;

                        const balanceCards = document.querySelectorAll('.current-balance-value');
                        balanceCards.forEach(card => {
                            card.textContent = balanceText;
                        });
                    }
                })
                .catch(err => console.error('Error calculating balance:', err));
        }

        document.addEventListener('DOMContentLoaded', function() {
            // ================== ELEMENTS ==================
            const teacherSelect = document.getElementById('teacherSelect');
            const sessionSelect = document.getElementById('SelectYear');
            const noTeacherSelected = document.getElementById('noTeacherSelected');
            const teacherData = document.getElementById('teacherData');

            const teacherNameTag = document.getElementById('teacher_name');
            const teacherModalNameTag = document.getElementById('transaction_teacher');
            const teacherEmailTag = document.getElementById('teacher_email');

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

            // ================== UTILITY FUNCTIONS ==================
            function showSection(target, subTab = null) {
                sections.forEach(id => {
                    const el = document.getElementById(id);
                    if (!el) return;
                    el.style.display = (id === target) ? 'block' : 'none';
                });

                if (target === 'transactionsDiv') {
                    subTabContainer.style.display = 'flex';
                    if (subTab === 'percourse') activateSub('percourse');
                    else activateSub('recent');
                } else {
                    subTabContainer.style.display = 'none';
                    subRecent.classList.remove('active');
                    subPerCourse.classList.remove('active');
                    restoreOriginalTransactions();
                    if (target === 'balancesDiv') {
                        const teacherIdForBalance = document.getElementById('transaction_teacher_id')?.value ||
                            document.getElementById('teacherSelect')?.value;
                        if (teacherIdForBalance) {
                            fetchTransactions(teacherIdForBalance, sessionSelect?.value, document.getElementById(
                                'currencySelect')?.value);
                        }
                    }
                    if (target === 'payoutsDiv') {
                        const sessionId = sessionSelect?.value;
                        if (sessionId) {
                            fetchPayoutsData(sessionId);
                        }
                    }
                }
            }

            function activateMainTab(button) {
                mainTabBtns.forEach(b => b.classList.remove('active'));
                if (button) button.classList.add('active');
                const target = button ? button.dataset.target : 'transactionsDiv';
                showSection(target);
            }

            function activateSub(which) {
                const teacherIdCurrent = document.getElementById('transaction_teacher_id')?.value || document
                    .getElementById('teacherSelect')?.value;

                if (which === 'recent') {
                    subRecent.classList.add('active');
                    subPerCourse.classList.remove('active');
                    thead.innerHTML = originalHead;
                    if (teacherIdCurrent) {
                        tbody.innerHTML = '<tr><td colspan="11" class="text-center">Loading...</td></tr>';
                        fetchTransactions(teacherIdCurrent, sessionSelect?.value, document.getElementById(
                            'currencySelect')?.value);
                    } else {
                        tbody.innerHTML = originalBody;
                    }
                } else if (which === 'percourse') {
                    subPerCourse.classList.add('active');
                    subRecent.classList.remove('active');
                    if (teacherIdCurrent) {
                        fetchPerCourse(teacherIdCurrent, sessionSelect?.value, document.getElementById(
                            'currencySelect')?.value);
                    }
                }
            }

            function restoreOriginalTransactions() {
                thead.innerHTML = originalHead;
                tbody.innerHTML = originalBody;
                attachDeleteHandlers();
            }

            function showCourseDetails(course = null) {
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

            function attachDeleteHandlers() {
                const deleteButtons = document.querySelectorAll('.delete-transaction-btn');
                deleteButtons.forEach(btn => {
                    if (!btn.dataset.handlerAttached) {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            const transactionId = this.dataset.id;

                            if (!confirm('Are you sure you want to delete this transaction?')) {
                                return;
                            }

                            const deleteTransactionUrl =
                                "{{ route('transactions.delete', ['id' => ':transactionId']) }}"
                                .replace(':transactionId', transactionId);

                            fetch(deleteTransactionUrl, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').content,
                                        'Accept': 'application/json',
                                    }
                                })
                                .then(resp => resp.json())
                                .then(data => {
                                    if (data.success) {
                                        alert('Transaction deleted successfully!');
                                        const teacherId = document.getElementById(
                                            'transaction_teacher_id')?.value;
                                        const sessionId = document.getElementById('SelectYear')
                                            ?.value;
                                        const currencyId = document.getElementById(
                                            'currencySelect')?.value;

                                        if (teacherId) {
                                            if (subPerCourse.classList.contains('active')) {
                                                fetchPerCourse(teacherId, sessionId,
                                                    currencyId);
                                            } else {
                                                fetchTransactions(teacherId, sessionId,
                                                    currencyId);
                                            }
                                        }
                                    } else {
                                        alert('Failed to delete transaction: ' + (data
                                            .message || 'Unknown error'));
                                    }
                                })
                                .catch(err => {
                                    console.error('Error deleting transaction:', err);
                                    alert('Error deleting transaction. Please check console.');
                                });
                        });
                        btn.dataset.handlerAttached = '1';
                    }
                });
            }

            // ================== FETCH RECENT TRANSACTIONS ==================
            window.fetchTransactions = function fetchTransactions(teacherId, sessionId = null, currencyId = null) {
                console.log('Fetching transactions for:', {
                    teacherId,
                    sessionId,
                    currencyId
                });
                if (!teacherId) return;

              
                let teacherDataUrl = "{{ route('teachers.data', ['id' => ':id']) }}".replace(':id', teacherId);

                const params = [];
                if (sessionId) params.push(`session_id=${sessionId}`);
                if (currencyId) params.push(`currency_id=${currencyId}`);
                if (params.length) teacherDataUrl += `?${params.join('&')}`;


                fetch(teacherDataUrl)
                    .then(resp => resp.json())
                    .then(data => {
                        console.log('Teacher data received:', data);

                        if (teacherNameTag) {
                            teacherNameTag.textContent = data.teacher?.name || 'N/A';
                        }
                        if (teacherEmailTag) {
                            teacherEmailTag.textContent = data.teacher?.email || 'N/A';
                        }
                        if (teacherModalNameTag) {
                            teacherModalNameTag.value = data.teacher?.name || '';
                        }

                        const teacherIdInput = document.getElementById('transaction_teacher_id');
                        if (teacherIdInput) teacherIdInput.value = teacherId;

                        const transactions = data.transactions || [];
                        tbody.innerHTML = '';

                        try {
                            const totals = data.totals || {};
                            const totalEarnedText = totals.total_earned || (
                                `0.00 ${totals.currency || ''}`);
                            const currentBalanceText = totals.current_balance || totals.remaining || (
                                `0.00 ${totals.currency || ''}`);
                            const paidBeforeText = totals.paid_before || totals.paid || (
                                `0.00 ${totals.currency || ''}`);

                            document.querySelectorAll('.total-earned-value').forEach(el => {
                                el.textContent = totalEarnedText;
                            });

                            document.querySelectorAll('.current-balance-value').forEach(el => {
                                el.textContent = currentBalanceText;
                            });

                            document.querySelectorAll('.paid-before-value').forEach(el => {
                                el.textContent = paidBeforeText;
                            });

                            document.querySelectorAll('.total-paid-out-value').forEach(el => {
                                el.textContent = paidBeforeText;
                            });
                        } catch (e) {
                            console.error('Error updating stats:', e);
                        }

                        if (transactions.length === 0) {
                            tbody.innerHTML =
                                `<tr><td colspan="11" class="text-center">No transactions available for the selected session</td></tr>`;
                            return;
                        }

                        transactions.forEach(tx => {
                            tbody.innerHTML += `
                        <tr data-id="${tx.id}">
                            <td><input type="checkbox"></td>
                            <td>${tx.id}</td>
                            <td>${tx.date}</td>
                            <td>${tx.course}</td>
                            <td>${tx.session}</td>
                            <td>${tx.student}</td>
                            <td>${tx.parent}</td>
                            <td>${tx.total} (${tx.currency})</td>
                            <td class="paid-cell">${tx.paid} (${tx.currency})</td>
                            <td class="remaining-cell">${tx.remaining} (${tx.currency})</td>
                            <td class="text-center">
                                <button class="btn btn-sm icon-btn restore-btn"
                                    data-id="${tx.id}"
                                    data-total="${tx.total}"
                                    data-paid="${tx.paid}">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger delete-transaction-btn" data-id="${tx.id}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>`;
                        });
                        attachDeleteHandlers();
                    })
                    .catch(err => {
                        console.error('Error fetching teacher data:', err);
                        alert('Error loading teacher data. Please check console for details.');
                    });
            }

            // ================== FETCH PER COURSE ==================
            window.fetchPerCourse = function fetchPerCourse(teacherId, sessionId = null, currencyId = null) {
                if (!teacherId) return;

                const perCourseUrl = "{{ route('teachers.percourse', ['teacher' => ':teacherId']) }}".replace(
                    ':teacherId', teacherId);

                const params = [];
                if (sessionId) params.push(`session_id=${sessionId}`);
                if (currencyId) params.push(`currency_id=${currencyId}`);
                if (params.length) perCourseUrl += `?${params.join('&')}`;

                fetch(perCourseUrl)
                    .then(resp => resp.json())
                    .then(data => {
                        const courses = data.courses || [];
                        thead.innerHTML = perCourseHead;
                        tbody.innerHTML = '';

                        courses.forEach((course, idx) => {
                            tbody.innerHTML += `
                        <tr class="course-row" data-idx="${idx}" data-id="${course.transactions_details[0]?.id || ''}">
                            <td>${course.name}</td>
                            <td>${course.session}</td>
                            <td>${course.transactions}</td>
                            <td>${course.total_amount}</td>
                            <td class="paid-cell">${course.total_paid}</td>
                            <td class="remaining-cell">${course.total_remaining}</td>
                            <td class="text-center">
                                <button class="btn btn-sm icon-btn restore-btn"
                                    data-id="${course.transactions_details[0]?.id || ''}"
                                    data-total="${course.total_amount}"
                                    data-paid="${course.total_paid}">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </button>
                                <button class="btn btn-sm btn-dark viewCourseDetails" data-idx="${idx}">View</button>
                            </td>
                        </tr>`;
                        });

                        tbody.querySelectorAll('.viewCourseDetails').forEach(btn => {
                            btn.addEventListener('click', e => {
                                e.stopPropagation();
                                const idx = btn.dataset.idx;
                                showCourseDetails(courses[idx]);
                            });
                        });

                        tbody.querySelectorAll('.course-row').forEach(row => {
                            row.addEventListener('click', e => {
                                if (e.target.closest('.restore-btn')) return;
                                const idx = row.dataset.idx;
                                showCourseDetails(courses[idx]);
                            });
                        });
                    })
                    .catch(err => console.error('Error fetching per-course data:', err));
            }

            // ================== FETCH PAYOUTS DATA ==================
            window.fetchPayoutsData = function fetchPayoutsData(sessionId) {
                const payoutsTableBody = document.getElementById('payoutsTableBody');

                if (!sessionId) {
                    payoutsTableBody.innerHTML =
                        '<tr><td colspan="9" class="text-center text-warning">Please select a session first</td></tr>';
                    return;
                }

                payoutsTableBody.innerHTML = '<tr><td colspan="9" class="text-center">Loading...</td></tr>';
                const payoutsUrl = "{{ route('teacher.payouts.data', ['session_id' => ':sessionId']) }}"
                    .replace(':sessionId', sessionId);


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

            // APPEND PAYOUTS TO TABLE
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
                    const paidAmount = `${parseFloat(payout.paid_amount ?? 0).toFixed(2)}`;
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

                document.querySelectorAll('.delete-payout').forEach(button => {
                    button.addEventListener('click', function() {
                        const payoutId = this.dataset.id;
                        deletePayout(payoutId);
                    });
                });
            }

            // DELETE PAYOUT FUNCTION
            function deletePayout(payoutId) {
                if (!confirm('Are you sure you want to delete this payout?')) return;
                const deletePayoutUrl = "{{ route('teacher.payouts.delete', ['id' => ':payoutId']) }}".replace(
                    ':payoutId', payoutId);
                fetch(deletePayoutUrl, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Payout deleted successfully.');
                            const sessionId = document.getElementById('SelectYear')?.value;
                            if (sessionId) {
                                fetchPayoutsData(sessionId);
                            }
                        } else {
                            alert('Failed to delete payout: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting payout:', error);
                        alert('Something went wrong.');
                    });
            }

            // ================== RESTORE MODAL FUNCTIONALITY ==================
            function openRestoreModal(transaction = null) {
                const restoreModal = new bootstrap.Modal(document.getElementById('restoreModal'));
                const restoreTransactionId = document.getElementById('restoreTransactionId');
                const restoreTotal = document.getElementById('restoreTotal');
                const restorePaidReadonly = document.getElementById('restorePaidReadonly');
                const restorePaid = document.getElementById('restorePaid');
                const restoreRemaining = document.getElementById('restoreRemaining');

                if (transaction) {
                    restoreTransactionId.value = transaction.id || '';
                    restoreTotal.value = transaction.total || 0;
                    restorePaidReadonly.value = transaction.paid || 0;
                    restorePaid.value = 0;
                    restoreRemaining.value = transaction.total - transaction.paid || 0;
                }

                restorePaid.addEventListener('input', function() {
                    const newPaid = parseFloat(this.value) || 0;
                    const total = parseFloat(restoreTotal.value) || 0;
                    const paid = parseFloat(restorePaidReadonly.value) || 0;
                    restoreRemaining.value = total - paid - newPaid;
                });

                restoreModal.show();
            }

            // ================== EVENT LISTENERS ==================
            mainTabBtns.forEach(btn => btn.addEventListener('click', () => activateMainTab(btn)));

            subRecent.addEventListener('click', () => {
                activateSub('recent');
                const teacherId = document.getElementById('transaction_teacher_id')?.value;
                if (!teacherId) return;
                fetchTransactions(teacherId, sessionSelect?.value, document.getElementById('currencySelect')
                    ?.value);
            });

            subPerCourse.addEventListener('click', () => {
                activateSub('percourse');
                const teacherId = document.getElementById('transaction_teacher_id')?.value;
                if (!teacherId) return;
                fetchPerCourse(teacherId, sessionSelect?.value, document.getElementById('currencySelect')
                    ?.value);
            });

            // ================== TEACHER SELECTION - SHOW DATA FOR DIFFERENT TEACHERS ==================
            teacherSelect.addEventListener('change', function() {
                const teacherId = this.value;
                const sessionId = sessionSelect?.value;
                const currencyId = document.getElementById('currencySelect')?.value;

                console.log('Teacher selected, ID:', teacherId);

                if (!teacherId || teacherId === '' || teacherId === 'Select a teacher') {
                    console.log('Invalid teacher ID');
                    noTeacherSelected.style.display = 'block';
                    teacherData.style.display = 'none';
                    subTabContainer.style.display = 'none';
                    tbody.innerHTML = originalBody;
                    thead.innerHTML = originalHead;
                    return;
                }

                console.log('Valid teacher ID, showing teacher data');
                noTeacherSelected.style.display = 'none';
                teacherData.style.display = 'block';

                const transBtn = Array.from(mainTabBtns).find(b => b.dataset.target === 'transactionsDiv');
                activateMainTab(transBtn || mainTabBtns[0]);

                tbody.innerHTML = '<tr><td colspan="11" class="text-center">Loading...</td></tr>';

                subRecent.classList.add('active');
                subPerCourse.classList.remove('active');
                subTabContainer.style.display = 'flex';

                const detailCard = transactionsDiv.querySelector('.detail-card-custom');
                if (detailCard) {
                    detailCard.style.display = 'none';
                }

                console.log('Fetching transactions for teacher:', teacherId);
                fetchTransactions(teacherId, sessionId, currencyId);

                console.log('Updating balance for teacher:', teacherId);
                updateCurrentBalance(teacherId, sessionId, currencyId);
            });

            if (sessionSelect) {
                sessionSelect.addEventListener('change', function() {
                    const teacherId = document.getElementById('transaction_teacher_id')?.value;
                    if (!teacherId) return;

                    const sessionId = this.value;
                    const currencyId = document.getElementById('currencySelect')?.value;

                    if (subPerCourse.classList.contains('active')) {
                        thead.innerHTML = perCourseHead;
                        tbody.innerHTML = '';
                        fetchPerCourse(teacherId, sessionId, currencyId);
                    } else {
                        fetchTransactions(teacherId, sessionId, currencyId);
                    }

                    updateCurrentBalance(teacherId, sessionId, currencyId);

                    const payoutsDiv = document.getElementById('payoutsDiv');
                    if (payoutsDiv && payoutsDiv.style.display !== 'none') {
                        fetchPayoutsData(sessionId);
                    }
                });
            }

            const currencySelect = document.getElementById('currencySelect');
            if (currencySelect) {
                currencySelect.addEventListener('change', function() {
                    const teacherId = document.getElementById('transaction_teacher_id')?.value;
                    if (!teacherId) return;

                    if (subPerCourse.classList.contains('active')) {
                        fetchPerCourse(teacherId, sessionSelect?.value, this.value);
                    } else {
                        fetchTransactions(teacherId, sessionSelect?.value, this.value);
                    }

                    updateCurrentBalance(teacherId, sessionSelect?.value, this.value);

                    const payoutsDiv = document.getElementById('payoutsDiv');
                    if (payoutsDiv && payoutsDiv.style.display !== 'none') {
                        fetchPayoutsData(sessionSelect?.value);
                    }
                });
            }

            // ================== INITIAL STATE ==================
            subTabContainer.style.display = 'none';
            attachDeleteHandlers();

            // ================== TRANSACTIONS SEARCH ==================
            const transactionsSearchInput = document.getElementById('searchInput');
            if (transactionsSearchInput) {
                transactionsSearchInput.addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase();
                    const rows = document.querySelectorAll('#transactionsTableBody tr');

                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                });
            }

            // ================== PAYOUTS SEARCH ==================
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

            // ================== LOAD INITIAL DATA ON PAGE REFRESH ==================
            const initialTeacherId = teacherSelect?.value;
            if (initialTeacherId) {
                noTeacherSelected.style.display = 'none';
                teacherData.style.display = 'block';
                subTabContainer.style.display = 'flex';

                subRecent.classList.add('active');
                subPerCourse.classList.remove('active');

                const sessionId = sessionSelect?.value;
                const currencyId = document.getElementById('currencySelect')?.value;

                fetchTransactions(initialTeacherId, sessionId, currencyId);
            } else {
                noTeacherSelected.style.display = 'block';
                teacherData.style.display = 'none';
                subTabContainer.style.display = 'none';
            }
        });

        window.fetchTransactions = fetchTransactions;
        window.fetchPerCourse = fetchPerCourse;
    </script>

    {{-- This is the script for currency update --}}

    <script>
        $(document).ready(function() {
            // Ensure select shows current currency on modal open
            const updateModalCurrency = () => {
                const currentCurrencyId = $('#current_currency').val();
                if (currentCurrencyId) {
                    $('#currencySelect').val(currentCurrencyId);
                }
            };

            // Call once on page load
            updateModalCurrency();

            // Whenever the currency select changes
            $('#currencySelect').on('change', function() {
                const selectedCurrencyId = $(this).val();
                const selectedCurrencyName = $('#currencySelect option:selected').text().trim();
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
                            // Update hidden inputs in modal
                            $('#current_currency').val(selectedCurrencyId);
                            $('#current_currency_display').val(
                                selectedCurrencyName); // Visible field in modal
                            $('#current_currency_name').val(
                                selectedCurrencyName); // If you have another hidden input

                            // Keep select updated
                            $('#currencySelect').val(selectedCurrencyId);
                        }
                    },
                    error: function() {
                        // Optional: handle server error silently or with console
                        console.error('Server error. Please try again.');
                    }
                });
            });

            // Optional: when modal is opened, ensure currency select reflects current value
            $('#transactionsModal').on('show.bs.modal', function() {
                updateModalCurrency();
            });
        });
    </script>



    {{-- This is the script of teacher modal --}}


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const transactionsForm = document.getElementById('transactionsForm');
            const transactionTeacher = document.getElementById('transaction_teacher');
            const transactionTeacherId = document.getElementById('transaction_teacher_id');
            const transactionSession = document.getElementById('transaction_session');
            const transactionSessionId = document.getElementById('transaction_session_id');
            const transactionTotal = document.getElementById('transaction_total');
            const transactionPaid = document.getElementById('transaction_paid');
            const transactionRemaining = document.getElementById('transaction_remaining');
            const selectYear = document.getElementById('SelectYear');
            const openModalBtns = document.querySelectorAll('.openTransactionModal');
            const transactionsModal = document.getElementById('transactionsModal');

            // Auto-calculate Remaining
            function updateRemaining() {
                const total = parseFloat(transactionTotal.value) || 0;
                const paid = parseFloat(transactionPaid.value) || 0;
                transactionRemaining.value = (total - paid).toFixed(2);
            }
            transactionTotal.addEventListener('input', updateRemaining);
            transactionPaid.addEventListener('input', updateRemaining);

            // Update session input & hidden ID on change and page load
            if (selectYear && transactionSession && transactionSessionId) {
                function updateSession() {
                    const selectedOption = selectYear.options[selectYear.selectedIndex];
                    transactionSession.value = selectedOption ? selectedOption.text.trim() : '';
                    transactionSessionId.value = selectedOption ? selectedOption.value : '';
                }

                // Run on select change
                selectYear.addEventListener('change', updateSession);

                // Run once on page load
                updateSession();
            }

            // Open modal
            openModalBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    transactionsForm.reset();
                    transactionRemaining.value = '';

                    // Set teacher name and hidden ID
                    const teacherName = btn.dataset.teacherName;
                    const teacherId = btn.dataset.teacherId;
                    transactionTeacher.value = teacherName || '';
                    transactionTeacherId.value = teacherId || '';

                    // Set session text and hidden ID (already initialized on page load)
                    if (selectYear && transactionSession && transactionSessionId) {
                        const selectedOption = selectYear.options[selectYear.selectedIndex];
                        transactionSession.value = selectedOption ? selectedOption.text.trim() : '';
                        transactionSessionId.value = selectedOption ? selectedOption.value : '';
                    }

                    const modal = new bootstrap.Modal(transactionsModal);
                    modal.show();
                });
            });

            // Submit via AJAX
            transactionsForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(transactionsForm);

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch("{{ route('transactions.store') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert('Transaction saved successfully!');
                            bootstrap.Modal.getInstance(transactionsModal).hide();

                            // ✅ Refresh transactions immediately after adding new transaction
                            const teacherId = document.getElementById('transaction_teacher_id')?.value;
                            const sessionId = document.getElementById('SelectYear')?.value;
                            const currencyId = document.getElementById('currencySelect')?.value;

                            if (teacherId && window.fetchTransactions) {
                                // Use setTimeout to ensure modal is fully closed before refresh
                                setTimeout(() => {
                                    window.fetchTransactions(teacherId, sessionId, currencyId);
                                    // Also update balance if visible
                                    updateCurrentBalance(teacherId, sessionId, currencyId);
                                }, 300);
                            }
                        } else {
                            alert('Error: ' + (data.message || JSON.stringify(data.errors)));
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('An error occurred.');
                    });
            });
        });
    </script>

    {{-- this is the script for teacher transaction restore modal --}}


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('=== Restore Modal Script Started ===');

            // ========== PARSE AMOUNT FROM CELL ==========
            function parseAmountFromCell(cell) {
                if (!cell || !cell.textContent) return 0;
                const text = cell.textContent.trim();
                const match = text.match(/([\d,]+\.?\d*)\s*\(/);
                if (match) return parseFloat(match[1].replace(/,/g, '')) || 0;
                const numMatch = text.match(/([\d,]+\.?\d*)/);
                if (numMatch) return parseFloat(numMatch[1].replace(/,/g, '')) || 0;
                return 0;
            }

            // ========== GET CURRENCY FROM CELL ==========
            function getCurrencyFromCell(cell) {
                if (!cell || !cell.textContent) return '';
                const text = cell.textContent.trim();
                const match = text.match(/\(([A-Z]{3})\)/);
                return match ? ` (${match[1]})` : '';
            }

            // ========== HANDLE RESTORE BUTTON CLICK ==========
            document.addEventListener('click', function(e) {
                const restoreBtn = e.target.closest('.restore-btn');
                if (!restoreBtn) return;

                e.stopPropagation();
                e.preventDefault();

                const transactionId = restoreBtn.dataset.id;
                const row = restoreBtn.closest('tr');

                if (!transactionId || !row) {
                    alert('Error: Cannot find transaction data');
                    return;
                }

                const isCourse = row.classList.contains('course-row');

                let totalCell, paidCell, remainingCell;

                if (isCourse) {
                    totalCell = row.cells[3];
                    paidCell = row.cells[4];
                    remainingCell = row.cells[5];
                } else {
                    totalCell = row.cells[7];
                    paidCell = row.cells[8];
                    remainingCell = row.cells[9];
                }

                const totalAmount = parseAmountFromCell(totalCell);
                const paidAmount = parseAmountFromCell(paidCell);
                const remainingAmount = totalAmount - paidAmount;

                const currencySuffix = getCurrencyFromCell(totalCell) || getCurrencyFromCell(paidCell) ||
                    getCurrencyFromCell(remainingCell);

                // Fill modal inputs
                const restoreTransactionId = document.getElementById('restoreTransactionId');
                const restoreTotal = document.getElementById('restoreTotal');
                const restorePaidReadonly = document.getElementById('restorePaidReadonly');
                const restorePaid = document.getElementById('restorePaid');
                const restoreRemaining = document.getElementById('restoreRemaining');

                if (restoreTransactionId) restoreTransactionId.value = transactionId;
                if (restoreTotal) restoreTotal.value = totalAmount;
                if (restorePaidReadonly) restorePaidReadonly.value = paidAmount;
                if (restorePaid) restorePaid.value = '';
                if (restoreRemaining) restoreRemaining.value = remainingAmount;

                // Show modal
                const restoreModalEl = document.getElementById('restoreModal');
                if (restoreModalEl) {
                    const restoreModal = new bootstrap.Modal(restoreModalEl);
                    restoreModal.show();
                }
            });

            // ========== HANDLE INPUT CHANGES ==========
            const restorePaidInput = document.getElementById('restorePaid');
            if (restorePaidInput) {
                restorePaidInput.addEventListener('input', function() {
                    const newPaid = parseFloat(this.value) || 0;
                    const total = parseFloat(document.getElementById('restoreTotal')?.value) || 0;
                    const currentPaid = parseFloat(document.getElementById('restorePaidReadonly')?.value) ||
                        0;
                    const remaining = total - currentPaid - newPaid;
                    const restoreRemaining = document.getElementById('restoreRemaining');
                    if (restoreRemaining) restoreRemaining.value = remaining >= 0 ? remaining : 0;
                });
            }

            // ========== HANDLE FORM SUBMIT ==========
            const restoreForm = document.getElementById('restoreForm');
            if (!restoreForm) return;

            restoreForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const transactionId = document.getElementById('restoreTransactionId')?.value;
                const newPaidValue = document.getElementById('restorePaid')?.value;
                const newPaid = parseFloat(newPaidValue) || 0;
                const remarks = document.getElementById('restoreRemarks')?.value || '';

                if (!transactionId || !newPaidValue || newPaid <= 0) {
                    alert('Please enter a valid amount and ensure transaction ID exists');
                    return;
                }

                const subPerCourse = document.getElementById('sub-percourse');
                const isCourse = subPerCourse && subPerCourse.classList.contains('active');
                const endpoint = isCourse ? "{{ route('transactions.restore-percourse') }}" :
                    "{{ route('transactions.restore') }}";


                try {
                    const response = await fetch(endpoint, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                ?.getAttribute('content') || ''
                        },
                        body: JSON.stringify({
                            transaction_id: transactionId,
                            new_paid: newPaid,
                            remarks: remarks
                        })
                    });

                    const data = await response.json();

                    if (!response.ok || !data.success) {
                        const errorMsg = data.message || 'An error occurred';
                        alert('Error: ' + errorMsg);
                        return;
                    }

                    // Update any table rows that match this transaction ID (covers
                    // recent list and per-course rows). Update restore-btn dataset
                    // so subsequent opens show correct values.
                    const updatedPaid = parseFloat(data.transaction?.paid ?? data.paid) || 0;
                    const updatedRemaining = parseFloat(data.transaction?.remaining ?? data
                        .remaining) || 0;

                    // Find buttons matching the transaction id and update their rows
                    const restoreButtons = Array.from(document.querySelectorAll(
                        `button.restore-btn[data-id="${transactionId}"]`));
                    if (restoreButtons.length) {
                        restoreButtons.forEach(btn => {
                            const r = btn.closest('tr');
                            if (!r) return;

                            const paidCell = r.querySelector('.paid-cell');
                            const remainingCell = r.querySelector('.remaining-cell');
                            const currency = getCurrencyFromCell(paidCell) ||
                                getCurrencyFromCell(remainingCell) || '';

                            if (paidCell) paidCell.textContent = `${updatedPaid}${currency}`;
                            if (remainingCell) remainingCell.textContent =
                                `${updatedRemaining}${currency}`;

                            // update dataset so next modal open reads correct values
                            btn.dataset.paid = updatedPaid;
                            if (data.transaction && data.transaction.total !== undefined) btn
                                .dataset.total = data.transaction.total;
                        });
                    } else {
                        // Fallback: try to find any table row with data-id attr
                        const rows = Array.from(document.querySelectorAll(
                            `tr[data-id="${transactionId}"]`));
                        rows.forEach(r => {
                            const paidCell = r.querySelector('.paid-cell');
                            const remainingCell = r.querySelector('.remaining-cell');
                            const currency = getCurrencyFromCell(paidCell) ||
                                getCurrencyFromCell(remainingCell) || '';
                            if (paidCell) paidCell.textContent = `${updatedPaid}${currency}`;
                            if (remainingCell) remainingCell.textContent =
                                `${updatedRemaining}${currency}`;
                        });
                    }

                    // ========== CLOSE & CLEAR MODAL ==========
                    const restoreModalEl = document.getElementById('restoreModal');
                    if (restoreModalEl) {
                        const restoreModal = bootstrap.Modal.getInstance(restoreModalEl) ||
                            new bootstrap.Modal(restoreModalEl);

                        // Clear inputs AFTER modal fully hidden
                        restoreModalEl.addEventListener('hidden.bs.modal', function clearModalInputs() {
                            const fieldsToClear = [
                                'restoreTransactionId',
                                'restoreTotal',
                                'restorePaidReadonly',
                                'restorePaid',
                                'restoreRemaining',
                                'restoreRemarks'
                            ];
                            fieldsToClear.forEach(id => {
                                const el = document.getElementById(id);
                                if (el) el.value = '';
                            });
                            restoreModalEl.removeEventListener('hidden.bs.modal',
                                clearModalInputs);
                        });

                        restoreModal.hide();
                    }

                    alert('Transaction updated successfully!');

                    // Refresh table from server
                    const teacherId = document.getElementById('transaction_teacher_id')?.value;
                    const sessionId = document.getElementById('SelectYear')?.value;
                    const currencyId = document.getElementById('currencySelect')?.value;

                    if (teacherId && window.fetchTransactions) {
                        setTimeout(() => {
                            if (isCourse && window.fetchPerCourse) {
                                window.fetchPerCourse(teacherId, sessionId, currencyId);
                            } else {
                                window.fetchTransactions(teacherId, sessionId, currencyId);
                            }
                        }, 500);
                    }

                    // ✅ Refresh payouts if payouts tab is active
                    const payoutsDiv = document.getElementById('payoutsDiv');
                    if (payoutsDiv && payoutsDiv.style.display !== 'none' && sessionId) {
                        setTimeout(() => {
                            fetchPayoutsData(sessionId);
                        }, 500);
                    }

                } catch (err) {
                    console.error('AJAX Error:', err);
                    alert('An error occurred. Check console for details.');
                }
            });

            console.log('=== Restore Modal Script Completed ===\n');
        });
    </script>
@endsection
