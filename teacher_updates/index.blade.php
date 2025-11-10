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
                                <td><button class="btn btn-sm btn-outline-danger"><i
                                            class="fa-solid fa-trash"></i></button></td>
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
@endsection

@section('scripts')
    {{-- This is the teacher showing  --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const teacherSelect = document.getElementById('teacherSelect');
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

            // Transactions table
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

            // Utility functions
            function showSection(target) {
                sections.forEach(id => {
                    const el = document.getElementById(id);
                    if (!el) return;
                    el.style.display = (id === target) ? 'block' : 'none';
                });

                if (target === 'transactionsDiv') {
                    subTabContainer.style.display = 'flex';
                    activateSub('recent');
                } else {
                    subTabContainer.style.display = 'none';
                    subRecent.classList.remove('active');
                    subPerCourse.classList.remove('active');
                    restoreOriginalTransactions();
                }
            }

            function activateMainTab(button) {
                mainTabBtns.forEach(b => b.classList.remove('active'));
                if (button) button.classList.add('active');
                const target = button ? button.dataset.target : 'transactionsDiv';
                showSection(target);
            }

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

            function restoreOriginalTransactions() {
                thead.innerHTML = originalHead;
                tbody.innerHTML = originalBody;
                attachDeleteHandlers();
            }

            function switchToPerCourse() {
                thead.innerHTML = perCourseHead;
                tbody.innerHTML = perCourseBody;

                const viewBtn = tbody.querySelector('.viewCourseDetails');
                if (viewBtn) {
                    viewBtn.addEventListener('click', function() {
                        showCourseDetails();
                    });
                }
            }

            function showCourseDetails() {
                let detailCard = transactionsDiv.querySelector('.detail-card-custom');
                if (!detailCard) {
                    detailCard = document.createElement('div');
                    detailCard.className = 'card border-0 shadow-sm mt-3 p-3 detail-card-custom';
                    detailCard.innerHTML = `
                <div class="detail-content">
                    <h6 class="fw-semibold mb-2">Transaction Details</h6>
                    <div class="detail-body"></div>
                    <button class="btn btn-sm btn-outline-dark mt-3 closeDetail">Close</button>
                </div>`;
                    transactionsDiv.querySelector('.card-body').appendChild(detailCard);

                    detailCard.querySelector('.closeDetail').addEventListener('click', () => {
                        detailCard.style.display = 'none';
                    });
                }

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
                <tbody>
                    <tr>
                        <td>2</td>
                        <td>10/7/2024, 4:45:00 PM</td>
                        <td>Emma Wilson</td>
                        <td>LE 150.00</td>
                        <td>LE 75.00</td>
                        <td>LE 75.00</td>
                    </tr>
                </tbody>
            </table>`;
                detailCard.style.display = 'block';
            }

            function attachDeleteHandlers() {
                const deletes = document.querySelectorAll('button.btn-outline-danger');
                deletes.forEach(btn => {
                    if (!btn.dataset.handlerAttached) {
                        btn.addEventListener('click', function(e) {
                            if (!confirm('Are you sure you want to delete this row?')) e
                                .preventDefault();
                        });
                        btn.dataset.handlerAttached = '1';
                    }
                });
            }

            // Main & Sub tabs
            mainTabBtns.forEach(btn => btn.addEventListener('click', () => activateMainTab(btn)));
            subRecent.addEventListener('click', () => activateSub('recent'));
            subPerCourse.addEventListener('click', () => activateSub('percourse'));

            // Teacher selection change: fetch JSON
            teacherSelect.addEventListener('change', function() {
                const teacherId = this.value;

                if (!teacherId) {
                    noTeacherSelected.style.display = 'block';
                    teacherData.style.display = 'none';
                    subTabContainer.style.display = 'none';
                    return;
                }

                noTeacherSelected.style.display = 'none';
                teacherData.style.display = 'block';

                // Activate Transactions tab
                const transBtn = Array.from(mainTabBtns).find(b => b.dataset.target === 'transactionsDiv');
                activateMainTab(transBtn || mainTabBtns[0]);

                // Fetch teacher data via JSON
                fetch(`/teachers/${teacherId}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Teacher not found');
                        return response.json();
                    })

                    .then(data => {
                        // Update profile
                        if (teacherNameTag) teacherNameTag.textContent = data.name;
                        if (teacherEmailTag) teacherEmailTag.textContent = data.email;

                        // Update modal teacher name (transaction_teacher select)

                        if (teacherModalNameTag) {
                            teacherModalNameTag.value = data.name;
                        }
                        // Set hidden teacher ID
                        const teacherIdInput = document.getElementById('transaction_teacher_id');
                        if (teacherIdInput) {
                            teacherIdInput.value = data.id;
                        }
                        const sessionIdInput = document.getElementById('transaction_session_id');
                        if (sessionrIdInput) {
                            sessionIdInput.value = data.id;
                        }




                        // Update stats
                        const stats = teacherData.querySelectorAll('.row .card-body');
                        if (stats[0]) stats[0].querySelector('h5').textContent = data.current_balance;
                        if (stats[1]) stats[1].querySelector('h5').textContent = data.total_paid;
                        if (stats[2]) stats[2].querySelector('h5').textContent = data.total_earned;

                        // Update transactions
                        tbody.innerHTML = '';
                        data.transactions.forEach(tx => {
                            tbody.innerHTML += `
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>${tx.id}</td>
                            <td>${tx.date}</td>
                            <td>${tx.course}</td>
                            <td>${tx.session}</td>
                            <td>${tx.student}</td>
                            <td>${tx.parent}</td>
                            <td>${tx.total}</td>
                            <td>${tx.paid}</td>
                            <td>${tx.remaining}</td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>`;
                        });

                        attachDeleteHandlers();
                    })
                    .catch(err => console.error('Error fetching teacher data:', err));
            });

            // Initial state
            subTabContainer.style.display = 'none';
            attachDeleteHandlers();
        });
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
                    beforeSend: function() {
                        toastr.clear();
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

                            toastr.clear();
                            setTimeout(() => {
                                toastr.success('✅ Currency updated successfully!');
                            }, 200);
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

            // Optional: when modal is opened, ensure currency select reflects current value
            $('#transactionsModal').on('show.bs.modal', function() {
                updateModalCurrency();
            });
        });
    </script>


    {{-- This is the script of teacher  modal --}}


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
@endsection
