@extends('layouts.app')

@section('contents')
<div class="main-content p-4" style="margin-left: 260px; min-height: 100vh; background: #f8f9fa;">

    <!-- âœ… Top Bar -->
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
                <option value="{{ $currency->id }}" @if ($currentCurrency && $currency->id == $currentCurrency->id)
                    selected @endif>
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
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4">
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
    </div>

    <!-- ðŸ§¾ No Teacher Selected -->
    <div id="noTeacherSelected" class="card border-0 shadow-sm text-center p-5" style="display: block;">
        <h5 class="fw-semibold mb-2">No Teacher Selected</h5>
        <p class="text-muted mb-0">Please select a teacher from the dropdown above to view their data.</p>
    </div>

    <!-- âœ… Teacher Full Data -->
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

                            <div class="row">
                                <!-- Teacher -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Teacher</label>
                                    <input type="text" id="transaction_teacher" class="form-control" readonly>
                                </div>

                                <!-- Course -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Course</label>
                                    <select class="form-select" id="transaction_course" name="course">
                                        <option selected disabled>Select Course</option>
                                        <!-- Courses will be dynamically loaded here -->
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Session -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Session</label>
                                    <input type="text" id="transaction_session" class="form-control" readonly>
                                </div>

                                <!-- Student -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Student</label>
                                    <input type="text" class="form-control" name="student_name" id="transaction_student">
                                </div>
                            </div>

                            <div class="row">
                                <!-- Parent -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Parent</label>
                                    <input type="text" class="form-control" name="parent_name" id="transaction_parent">
                                </div>

                                <!-- Student Contact -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Student Contact</label>
                                    <input type="text" class="form-control" name="student_contact" id="transaction_student_contact">
                                </div>
                            </div>

                            <div class="row">
                                <!-- Student Email -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Student Email</label>
                                    <input type="email" class="form-control" name="student_email" id="transaction_student_email">
                                </div>

                                <!-- Currency -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Currency</label>
                                    <input type="text" class="form-control" id="transaction_currency_display"
                                        value="{{ $currentCurrency?->currency_name ?? 'No currency selected' }}" readonly>
                                    <input type="hidden" name="current_currency" id="transaction_current_currency"
                                        value="{{ $currentCurrency?->id ?? '' }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Course Fee</label>
                                    <input type="number" class="form-control" name="course_fee" id="transaction_course_fee">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Note Fee</label>
                                    <input type="number" class="form-control" name="note_fee" id="transaction_note_fee">
                                </div>
                            </div>

                            <!-- Total, Paid, Remaining -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Total</label>
                                    <input type="number" class="form-control" name="total" id="transaction_total">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Paid</label>
                                    <input type="number" class="form-control" name="paid_amount" id="transaction_paid">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Remaining</label>
                                    <input type="number" class="form-control" name="remaining" id="transaction_remaining"
                                        step="0.01" readonly>
                                </div>
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

        <script>
            // Load teacher-specific courses when the transaction modal is shown
            document.addEventListener('DOMContentLoaded', function() {
                const transactionModal = document.getElementById('transactionsModal');
                const courseSelect = document.getElementById('transaction_course');
                
                // Teacher-course relationships from backend
                const teacherCourses = @json($teacher_courses ?? []);
                const allCourses = @json($subject_datas ?? []);
                
                console.log('Teacher Courses Data:', teacherCourses);
                console.log('All Courses Data:', allCourses);
                
                if (transactionModal && courseSelect) {
                    transactionModal.addEventListener('show.bs.modal', function() {
                        // Get teacher ID from the dropdown
                        const teacherSelect = document.getElementById('teacherSelect');
                        const teacherId = teacherSelect?.value;
                        
                        // Get session ID from the session dropdown
                        const sessionSelect = document.getElementById('SelectYear');
                        const sessionId = sessionSelect?.value;
                        const sessionText = sessionSelect?.options[sessionSelect.selectedIndex]?.text || '';
                        
                        console.log('Selected Teacher ID:', teacherId);
                        console.log('Selected Session ID:', sessionId);
                        console.log('Selected Session Text:', sessionText);
                        
                        if (!teacherId) {
                            console.warn('No teacher selected');
                            courseSelect.innerHTML = '<option selected disabled>Please select a teacher first</option>';
                            return;
                        }

                        // Set the teacher ID in the hidden field
                        const teacherIdField = document.getElementById('transaction_teacher_id');
                        if (teacherIdField) {
                            teacherIdField.value = teacherId;
                        }

                        // Set the session ID in the hidden field
                        const sessionIdField = document.getElementById('transaction_session_id');
                        if (sessionIdField) {
                            sessionIdField.value = sessionId;
                        }

                        // Set the session text in the display field
                        const sessionTextField = document.getElementById('transaction_session');
                        if (sessionTextField) {
                            sessionTextField.value = sessionText;
                        }

                        // Filter courses for the selected teacher - convert both to numbers for comparison
                        const teacherSpecificCourses = teacherCourses.filter(tc => {
                            const match = parseInt(tc.teacher_id) === parseInt(teacherId);
                            console.log(`Comparing tc.teacher_id=${tc.teacher_id} with teacherId=${teacherId}, match=${match}`);
                            return match;
                        });

                        console.log('Filtered Teacher Specific Courses:', teacherSpecificCourses);

                        // Clear existing options
                        courseSelect.innerHTML = '<option selected disabled>Select Course</option>';

                        if (teacherSpecificCourses.length > 0) {
                            teacherSpecificCourses.forEach(tc => {
                                const course = allCourses.find(c => parseInt(c.id) === parseInt(tc.course_id));
                                console.log(`Looking for course with id=${tc.course_id}, found:`, course);
                                if (course) {
                                    const option = document.createElement('option');
                                    option.value = course.id;
                                    option.textContent = course.course_title;
                                    courseSelect.appendChild(option);
                                }
                            });
                            console.log('Courses added to dropdown');
                        } else {
                            console.warn('No courses found for this teacher');
                            courseSelect.innerHTML = '<option selected disabled>No courses available for this teacher</option>';
                        }
                    });
                }

                // Calculate remaining amount
                const totalInput = document.getElementById('transaction_total');
                const paidInput = document.getElementById('transaction_paid');
                const remainingInput = document.getElementById('transaction_remaining');
                
                function calculateRemaining() {
                    const total = parseFloat(totalInput?.value) || 0;
                    const paid = parseFloat(paidInput?.value) || 0;
                    if (remainingInput) {
                        remainingInput.value = (total - paid).toFixed(2);
                    }
                }

                totalInput?.addEventListener('input', calculateRemaining);
                paidInput?.addEventListener('input', calculateRemaining);

                // Calculate total from course fee and note fee
                const courseFeeInput = document.getElementById('transaction_course_fee');
                const noteFeeInput = document.getElementById('transaction_note_fee');
                
                function calculateTotal() {
                    const courseFee = parseFloat(courseFeeInput?.value) || 0;
                    const noteFee = parseFloat(noteFeeInput?.value) || 0;
                    if (totalInput) {
                        totalInput.value = (courseFee + noteFee).toFixed(2);
                        calculateRemaining();
                    }
                }

                courseFeeInput?.addEventListener('input', calculateTotal);
                noteFeeInput?.addEventListener('input', calculateTotal);
            });
        </script>

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
                            <h5 class="fw-bold text-primary mb-0 total-earned-value">0.00</h5>
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
                            <h5 class="fw-bold text-danger mb-0 current-balance-value"> 0.00</h5>
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
                            <h5 class="fw-bold text-success mb-0 paid-before-value">0.00</h5>
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
                    <h5 class="fw-semibold mb-2 mb-md-0" id="transactionHeading">Recent Transactions</h5>
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal"
                            data-bs-target="#transactionsModal">
                            <i class="fa-solid fa-plus me-1"></i> Add
                        </button>

                        <button class="btn btn-outline-danger btn-sm" onclick="exportPDF()">
                            <i class="fa-solid fa-file-export me-1"></i> Export PDF
                        </button>
                        <button class="btn btn-outline-success btn-sm" onclick="exportExcel()">
                            <i class="fa-solid fa-file-export me-1"></i> Export Excel
                        </button>
                        <button class="btn btn-outline-dark btn-sm" onclick="toggleColumnSelector()">
                            <i class="fa-solid fa-table-columns me-1"></i> Select Columns
                        </button>

                    </div>
                </div>

                <div class="d-flex gap-2 mb-3">
                    <input type="date" class="form-control" id="transactionFromDate" placeholder="From Date" style="max-width: 200px;">
                    <input type="date" class="form-control" id="transactionToDate" placeholder="To Date" style="max-width: 200px;">
                    <button class="btn btn-dark" id="transactionFilterBtn"><i class="fa-solid fa-filter me-1"></i> Filter</button>
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
                                <th>Student Email</th>
                                <th>Student Contact</th>
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
                <h5 class="fw-semibold mb-3">Teacher Payouts</h5>
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <div></div>
                    <div class="d-flex gap-2 flex-wrap">
                        <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal"
                            data-bs-target="#payoutsModal">
                            <i class="fa-solid fa-plus me-1"></i> Add Payout
                        </button>

                        <button class="btn btn-outline-danger btn-sm" onclick="exportPayoutPDF()">
                            <i class="fa-solid fa-file-export me-1"></i> Export PDF
                        </button>

                        <button class="btn btn-outline-success btn-sm" onclick="exportPayoutExcel()">
                            <i class="fa-solid fa-file-export me-1"></i> Export Excel
                        </button>

                        <button class="btn btn-outline-dark btn-sm" onclick="togglePayoutColumns()">
                            <i class="fa-solid fa-table-columns me-1"></i> Columns
                        </button>
                    </div>
                </div>
                <div class="d-flex gap-2 mb-3">
                    <input type="date" class="form-control" id="payoutFromDate" placeholder="From Date" style="max-width: 200px;">
                    <input type="date" class="form-control" id="payoutToDate" placeholder="To Date" style="max-width: 200px;">
                    <button class="btn btn-dark" id="payoutFilterBtn"><i class="fa-solid fa-filter me-1"></i> Filter</button>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle table-hover" id="payoutsTable">
                        <thead class="table-light" id="payoutsThead">
                            <tr>
                                <th data-col="date_time">Date/Time</th>
                                <th data-col="teacher_name">Teacher Name</th>
                                <th data-col="course_name">Course Name</th>
                                <th data-col="session_name">Session Name</th>
                                <th data-col="paid">Paid Amount</th>
                                <th data-col="remarks">Remarks</th>
                                <th data-col="actions" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="payoutsTableBody">
                            <!-- Payouts will be loaded here dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>




        {{-- payouts add modal --}}
        <div class="modal fade" id="payoutsModal" tabindex="-1" aria-labelledby="payoutsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">

                    <!-- HEADER -->
                    <div class="modal-header bg-dark text-white rounded-top-4">
                        <h5 class="modal-title" id="payoutsModalLabel">Add Payout</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <!-- BODY -->
                    <div class="modal-body">
                        <form id="teacherpayoutForm">
                            @csrf

                            <div class="row">

                                <!-- Transaction ID -->


                                <!-- Session -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Session</label>
                                    <select class="form-select" name="session_id" required>
                                        <option selected disabled>Select Session</option>
                                        @foreach ($session_datas as $session)
                                        <option value="{{ $session->id }}">{{ $session->session_title }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Currency -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Currency</label>
                                    <input type="text" class="form-control currency-input-fix" id="currency_name"
                                        value="{{ $currentCurrency->currency_name ?? '' }}" readonly>

                                    <input type="hidden" name="selected_currency" id="selected_currency"
                                        value="{{ $currentCurrency->id ?? '' }}">
                                </div>

                                <!-- Teacher ID -->


                                <input type="hidden" class="form-control" name="teacher_id" id="modal_teacher_id"
                                    required>



                                <!-- Course ID -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Course</label>
                                    <select class="form-select" name="course_id" required>
                                        <option selected disabled>Select Course</option>
                                        @foreach ($subject_datas as $subject_data)
                                        <option value="{{ $subject_data->id }}">{{ $subject_data->course_title }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Paid Amount -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Paid Amount</label>
                                    <input type="number" class="form-control" step="0.01" name="paid_amount" required>
                                </div>



                                <!-- Remarks -->
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Remarks</label>
                                    <textarea class="form-control" name="remarks" rows="3" required></textarea>
                                </div>

                            </div>

                            <!-- FOOTER -->
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-dark">Save</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>



<script>
    // Load teacher-specific courses when the payouts modal is shown
    document.addEventListener('DOMContentLoaded', function() {
        const payoutsModal = document.getElementById('payoutsModal');
        const payoutCourseSelect = document.querySelector('#payoutsModal select[name="course_id"]');
        
        // Teacher-course relationships from backend
        const teacherCourses = @json($teacher_courses ?? []);
        const allCourses = @json($subject_datas ?? []);
        
        console.log('Payout Modal - Teacher Courses Data:', teacherCourses);
        console.log('Payout Modal - All Courses Data:', allCourses);
        
        if (payoutsModal && payoutCourseSelect) {
            payoutsModal.addEventListener('show.bs.modal', function() {
                // Get teacher ID from the teacher dropdown
                const teacherSelect = document.getElementById('teacherSelect');
                const teacherId = teacherSelect?.value;
                
                console.log('Payout Modal - Selected Teacher ID:', teacherId);
                
                if (!teacherId) {
                    console.warn('Payout Modal - No teacher selected');
                    payoutCourseSelect.innerHTML = '<option selected disabled>Please select a teacher first</option>';
                    return;
                }

                // Set the teacher ID in the hidden field
                const modalTeacherIdField = document.getElementById('modal_teacher_id');
                if (modalTeacherIdField) {
                    modalTeacherIdField.value = teacherId;
                }
                
                // ✅ SYNC CURRENCY FIELDS WHEN MODAL OPENS - FIX ALIGNMENT ISSUE
                const currencySelect = document.getElementById('currencySelect');
                const currencyId = currencySelect?.value;
                const currencyName = currencySelect?.options[currencySelect.selectedIndex]?.text.trim();
                
                const payoutCurrencyName = document.getElementById('currency_name');
                const payoutSelectedCurrency = document.getElementById('selected_currency');
                
                if (payoutCurrencyName && currencyName) {
                    // ✅ FIX: Set value and immediately force left alignment
                    payoutCurrencyName.value = currencyName;
                }
                if (payoutSelectedCurrency && currencyId) {
                    payoutSelectedCurrency.value = currencyId;
                }
                
                console.log('Payout Modal - Currency synced:', currencyId, currencyName);

                // Filter courses for the selected teacher - convert both to numbers for comparison
                const teacherSpecificCourses = teacherCourses.filter(tc => {
                    const match = parseInt(tc.teacher_id) === parseInt(teacherId);
                    console.log(`Payout Modal - Comparing tc.teacher_id=${tc.teacher_id} with teacherId=${teacherId}, match=${match}`);
                    return match;
                });

                console.log('Payout Modal - Filtered Teacher Specific Courses:', teacherSpecificCourses);

                // Clear existing options
                payoutCourseSelect.innerHTML = '<option selected disabled>Select Course</option>';

                if (teacherSpecificCourses.length > 0) {
                    teacherSpecificCourses.forEach(tc => {
                        const course = allCourses.find(c => parseInt(c.id) === parseInt(tc.course_id));
                        console.log(`Payout Modal - Looking for course with id=${tc.course_id}, found:`, course);
                        if (course) {
                            const option = document.createElement('option');
                            option.value = course.id;
                            option.textContent = course.course_title;
                            payoutCourseSelect.appendChild(option);
                        }
                    });
                    console.log('Payout Modal - Courses added to dropdown');
                } else {
                    console.warn('Payout Modal - No courses found for this teacher');
                    payoutCourseSelect.innerHTML = '<option selected disabled>No courses available for this teacher</option>';
                }
            });
        }
    });
</script>

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
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="restoreTransactionId" name="transaction_id">
                    <input type="hidden" id="restoreTeacherId" name="teacher_id">
                    <input type="hidden" id="restoreSessionId" name="session_id">

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Total</label>
                            <input type="number" id="restoreTotal" name="total" class="form-control" readonly>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Paid amount</label>
                            <input type="number" id="restorePaidReadonly" name="paid_readonly" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pay new amount</label>
                        <input type="number" id="restorePaid" name="new_paid" class="form-control" min="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Remaining</label>
                        <input type="number" id="restoreRemaining" name="remaining" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Remarks</label>
                        <textarea id="restoreRemarks" name="remarks" class="form-control" rows="3"
                            placeholder="Enter remarks/description"></textarea>
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
<div class="modal fade" id="columnModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Columns</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="columnCheckboxes">
                <!-- checkboxes generated by JS -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="payoutColumnModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Columns</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="payoutColumnCheckboxes">
                <!-- Checkboxes will be injected here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Apply</button>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Course Details Modal -->
<div class="modal fade" id="courseDetailsModal" tabindex="-1" aria-labelledby="courseDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-dark text-white rounded-top-4">
                <h5 class="modal-title" id="courseDetailsModalLabel">Course Transaction Details</h5>
                <div class="d-flex gap-2 align-items-center ms-auto">
                    <button class="btn btn-danger" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;" onclick="exportCourseDetailsPDF()">
                        <i class="fa-solid fa-file-pdf me-1"></i> PDF
                    </button>
                    <button class="btn btn-success" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;" onclick="exportCourseDetailsExcel()">
                        <i class="fa-solid fa-file-excel me-1"></i> Excel
                    </button>
                    <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <div id="courseDetailsContent">
                    <table class="table table-hover table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Date/Time</th>
                                <th>Student</th>
                                <th>Student Email</th>
                                <th>Student Contact</th>
                                <th>Currency</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Remaining</th>
                            </tr>
                        </thead>
                        <tbody id="courseDetailsTableBody">
                            <tr>
                                <td colspan="9" class="text-center text-muted">No data available</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-end">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fa-solid fa-times me-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
{{-- CRITICAL FIX: Currency input alignment CSS - must load immediately --}}
<style>
#currency_name,
.currency-input-fix {
    text-align: left !important;
    padding-left: 12px !important;
    direction: ltr !important;
}

/* Additional specificity to override any Bootstrap defaults */
#payoutsModal #currency_name {
    text-align: left !important;
    padding-left: 12px !important;
}
</style>

{{-- This is the script for teacher index --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    /* ---------------------------
       ELEMENT REFERENCES
    --------------------------- */
    const teacherSelect = document.getElementById('teacherSelect');
    const sessionSelect = document.getElementById('SelectYear');
    const currencySelect = document.getElementById('currencySelect');

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

    const originalHead = thead ? thead.innerHTML : '';
    const originalBody = tbody ? tbody.innerHTML : '';

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

    const payoutForm = document.getElementById('payoutForm');
    const payoutTeacherInput = document.getElementById('payout_teacher_id');
    const payoutSessionInput = document.getElementById('payout_session_id');
    const payoutCurrencyInput = document.getElementById('payout_currency_id');

    function routePlaceholder(name, id) {
        return { name, id };
    }

    const inFlight = {
        transactions: false,
        percourse: false,
        balance: false,
        payoutLoad: false,
        payoutSubmit: false,
    };

    // ✅ GLOBAL STATE: Track active transaction tab
    window.currentTransactionTab = 'recent';

    function safeText(node, value) {
        if (!node) return;
        node.textContent = value;
    }

    /* ---------------------------
       FETCH: TRANSACTIONS
    --------------------------- */
    window.fetchTransactions = function fetchTransactions(teacherId, sessionId = null, currencyId = null) {
        if (!teacherId) return;
        
        // ✅ CRITICAL: Ensure we're supposed to be showing Recent
        console.log('🟢 fetchTransactions called - Current state:', window.currentTransactionTab);

        const teacherInput = document.getElementById('modal_teacher_id');
        if (teacherInput) teacherInput.value = teacherId;

        if (inFlight.transactions) return;
        inFlight.transactions = true;

        let url = "{{ route('teachers.data', ':id') }}".replace(':id', teacherId);
        const params = [];
        if (sessionId) params.push(`session_id=${sessionId}`);
        if (currencyId) params.push(`currency_id=${currencyId}`);
        if (params.length) url += `?${params.join('&')}`;

        // ✅ Set button states IMMEDIATELY
        if (subRecent) subRecent.classList.add('active');
        if (subPerCourse) subPerCourse.classList.remove('active');
        
        if (tbody) tbody.innerHTML = `<tr><td colspan="11" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>`;

        // Restore original thead and update heading
        if (thead) thead.innerHTML = originalHead;
        const heading = document.getElementById('transactionHeading');
        if (heading) heading.textContent = 'Recent Transactions';

        fetch(url)
            .then(resp => resp.json())
            .then(data => {
                if (teacherNameTag) teacherNameTag.textContent = data.teacher?.name || 'N/A';
                if (teacherEmailTag) teacherEmailTag.textContent = data.teacher?.email || 'N/A';
                if (teacherModalNameTag) teacherModalNameTag.value = data.teacher?.name || '';

                const teacherIdInput = document.getElementById('transaction_teacher_id');
                if (teacherIdInput) teacherIdInput.value = teacherId;

                const transactions = data.transactions || [];
                const totals = data.totals || {};

                /* ✅ UPDATE ALL TOTALS (authoritative source) */
                document.querySelectorAll('.total-earned-value').forEach(el =>
                    el.textContent = totals.total_earned ?? (`0.00 ${totals.currency ?? ''}`)
                );
                document.querySelectorAll('.paid-before-value').forEach(el =>
                    el.textContent = totals.paid_before ?? (`0.00 ${totals.currency ?? ''}`)
                );
                document.querySelectorAll('.current-balance-value').forEach(el =>
                    el.textContent = totals.current_balance ?? (`0.00 ${totals.currency ?? ''}`)
                );
                document.querySelectorAll('.total-paid-out-value').forEach(el =>
                    el.textContent = totals.paid_before ?? (`0.00 ${totals.currency ?? ''}`)
                );
                document.querySelectorAll('.total-remaining-value').forEach(el =>
                    el.textContent = totals.remaining ?? (`0.00 ${totals.currency ?? ''}`)
                );

                if (!tbody) return;
                if (!transactions.length) {
                    tbody.innerHTML = `<tr><td colspan="11" class="text-center">No transactions available for the selected session</td></tr>`;
                } else {
                    tbody.innerHTML = '';
                    transactions.forEach(tx => {
                        tbody.innerHTML += `
<tr data-id="${tx.id}">
<td><input type="checkbox"></td>
<td>${tx.id}</td>
<td>${tx.date}</td>
<td>${tx.course}</td>
<td>${tx.session}</td>
<td>${tx.student}</td>
<td>${tx.student_email || '-'}</td>
<td>${tx.student_contact || '-'}</td>
<td>${tx.parent}</td>
<td>${tx.total} (${tx.currency})</td>
<td class="paid-cell">${tx.paid} (${tx.currency})</td>
<td class="remaining-cell">${tx.remaining} (${tx.currency})</td>
<td class="text-center">
<button class="btn btn-sm icon-btn restore-btn" data-id="${tx.id}" data-total="${tx.total}" data-paid="${tx.paid}">
<i class="bi bi-arrow-counterclockwise"></i></button>
<button class="btn btn-sm btn-outline-danger delete-transaction-btn" data-id="${tx.id}">
<i class="fa-solid fa-trash"></i></button>
</td>
</tr>`;
                    });
                }

                attachDeleteHandlers();
                
                // ✅ REINFORCE button states after data loads
                if (subRecent) subRecent.classList.add('active');
                if (subPerCourse) subPerCourse.classList.remove('active');
                console.log('✅ fetchTransactions completed - State maintained:', window.currentTransactionTab);
            })
            .catch(err => {
                console.error('Error fetching teacher data:', err);
                if (tbody) tbody.innerHTML =
                    `<tr><td colspan="11" class="text-center text-danger">Failed to load transactions</td></tr>`;
            })
            .finally(() => inFlight.transactions = false);
    };

    /* ---------------------------
       FETCH: PER COURSE
    --------------------------- */
    window.fetchPerCourse = function fetchPerCourse(teacherId, sessionId = null, currencyId = null) {
        if (!teacherId) return;
        
        // ✅ CRITICAL: Ensure we're supposed to be showing Per Course
        console.log('🔵 fetchPerCourse called - Current state:', window.currentTransactionTab);
        
        if (inFlight.percourse) return;
        inFlight.percourse = true;

        let url = "{{ route('teachers.percourse', ':id') }}".replace(':id', teacherId);
        const params = [];
        if (sessionId) params.push(`session_id=${sessionId}`);
        if (currencyId) params.push(`currency_id=${currencyId}`);
        if (params.length) url += `?${params.join('&')}`;

        // ✅ Set button states IMMEDIATELY
        if (subPerCourse) subPerCourse.classList.add('active');
        if (subRecent) subRecent.classList.remove('active');
        
        if (thead) thead.innerHTML = perCourseHead;
        if (tbody) tbody.innerHTML = `<tr><td colspan="11" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>`;

        // Update heading
        const heading = document.getElementById('transactionHeading');
        if (heading) heading.textContent = 'Per Course Transactions';

        console.log('fetchPerCourse - URL:', url);
        
        fetch(url)
            .then(resp => {
                console.log('fetchPerCourse - Response status:', resp.status);
                return resp.json();
            })
            .then(data => {
                console.log('fetchPerCourse - Full response data:', data);
                const courses = data.courses || [];
                console.log('fetchPerCourse - Courses array:', courses);
                console.log('fetchPerCourse - Courses length:', courses.length);
                
                if (!tbody) return;

                if (!courses.length) {
                    tbody.innerHTML = `<tr><td colspan="11" class="text-center">No courses found</td></tr>`;
                    return;
                }

                tbody.innerHTML = '';
                courses.forEach((course, idx) => {
                    tbody.innerHTML += `
<tr class="course-row" data-idx="${idx}">
<td>${course.name}</td>
<td>${course.session}</td>
<td>${course.transactions}</td>
<td>${course.total_amount}</td>
<td class="paid-cell">${course.total_paid}</td>
<td class="remaining-cell">${course.total_remaining}</td>
<td class="text-center">
<button class="btn btn-sm btn-dark viewCourseDetails" data-idx="${idx}">View</button>
</td>
</tr>`;
                });

                tbody.querySelectorAll('.viewCourseDetails').forEach(btn => {
                    btn.addEventListener('click', e => {
                        e.stopPropagation();
                        showCourseDetails(courses[btn.dataset.idx]);
                    });
                });
                
                // ✅ REINFORCE button states after data loads
                if (subPerCourse) subPerCourse.classList.add('active');
                if (subRecent) subRecent.classList.remove('active');
                console.log('✅ fetchPerCourse completed - State maintained:', window.currentTransactionTab);

            })
            .catch(err => {
                console.error('Error fetching per-course:', err);
                if (tbody) tbody.innerHTML =
                    `<tr><td colspan="11" class="text-center text-danger">Failed to load per-course</td></tr>`;
            })
            .finally(() => inFlight.percourse = false);
    };

    /* ---------------------------
       FETCH: FILTERED TRANSACTIONS
    --------------------------- */
    window.fetchTransactionsFiltered = function fetchTransactionsFiltered(teacherId, sessionId = null, currencyId = null, fromDate = null, toDate = null) {
        if (!teacherId) return;
        if (inFlight.transactions) return;
        inFlight.transactions = true;

        const teacherInput = document.getElementById('modal_teacher_id');
        if (teacherInput) teacherInput.value = teacherId;

        let url = "{{ route('teachers.data', ':id') }}".replace(':id', teacherId);
        const params = [];
        if (sessionId) params.push(`session_id=${sessionId}`);
        if (currencyId) params.push(`currency_id=${currencyId}`);
        if (fromDate) params.push(`from_date=${fromDate}`);
        if (toDate) params.push(`to_date=${toDate}`);
        if (params.length) url += `?${params.join('&')}`;

        if (tbody) tbody.innerHTML = `<tr><td colspan="11" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>`;

        // Restore original thead
        if (thead) thead.innerHTML = originalHead;

        // Update heading
        const heading = document.getElementById('transactionHeading');
        if (heading) heading.textContent = 'Recent Transactions';

        fetch(url)
            .then(resp => resp.json())
            .then(data => {
                if (teacherNameTag) teacherNameTag.textContent = data.teacher?.name || 'N/A';
                if (teacherEmailTag) teacherEmailTag.textContent = data.teacher?.email || 'N/A';
                if (teacherModalNameTag) teacherModalNameTag.value = data.teacher?.name || '';

                const teacherIdInput = document.getElementById('transaction_teacher_id');
                if (teacherIdInput) teacherIdInput.value = teacherId;

                const transactions = data.transactions || [];
                const totals = data.totals || {};

                /* ✅ UPDATE ALL TOTALS (authoritative source) */
                document.querySelectorAll('.total-earned-value').forEach(el =>
                    el.textContent = totals.total_earned ?? (`0.00 ${totals.currency ?? ''}`)
                );
                document.querySelectorAll('.paid-before-value').forEach(el =>
                    el.textContent = totals.paid_before ?? (`0.00 ${totals.currency ?? ''}`)
                );
                document.querySelectorAll('.current-balance-value').forEach(el =>
                    el.textContent = totals.current_balance ?? (`0.00 ${totals.currency ?? ''}`)
                );
                document.querySelectorAll('.total-paid-out-value').forEach(el =>
                    el.textContent = totals.paid_before ?? (`0.00 ${totals.currency ?? ''}`)
                );
                document.querySelectorAll('.total-remaining-value').forEach(el =>
                    el.textContent = totals.remaining ?? (`0.00 ${totals.currency ?? ''}`)
                );

                if (!tbody) return;
                if (!transactions.length) {
                    tbody.innerHTML = `<tr><td colspan="11" class="text-center">No transactions available for the selected filters</td></tr>`;
                } else {
                    tbody.innerHTML = '';
                    transactions.forEach(tx => {
                        tbody.innerHTML += `
<tr data-id="${tx.id}">
<td><input type="checkbox"></td>
<td>${tx.id}</td>
<td>${tx.date}</td>
<td>${tx.course}</td>
<td>${tx.session}</td>
<td>${tx.student}</td>
<td>${tx.student_email}</td>
<td>${tx.student_contact}</td>
<td>${tx.parent}</td>
<td class="total-cell">${tx.total} (${tx.currency})</td>
<td class="paid-cell">${tx.paid} (${tx.currency})</td>
<td class="remaining-cell">${tx.remaining} (${tx.currency})</td>
<td class="text-center">
<button class="btn btn-sm icon-btn restore-btn" data-id="${tx.id}" data-total="${tx.total}" data-paid="${tx.paid}">
<i class="bi bi-arrow-counterclockwise"></i></button>
<button class="btn btn-sm btn-outline-danger delete-transaction-btn" data-id="${tx.id}">
<i class="fa-solid fa-trash"></i></button>
</td>
</tr>`;
                    });
                }

                attachDeleteHandlers();
            })
            .catch(err => {
                console.error('Error fetching teacher data:', err);
                if (tbody) tbody.innerHTML =
                    `<tr><td colspan="11" class="text-center text-danger">Failed to load transactions</td></tr>`;
            })
            .finally(() => inFlight.transactions = false);
    };

    /* ---------------------------
       FETCH: FILTERED PER COURSE
    --------------------------- */
    window.fetchPerCourseFiltered = function fetchPerCourseFiltered(teacherId, sessionId = null, currencyId = null, fromDate = null, toDate = null) {
        if (!teacherId) return;
        if (inFlight.percourse) return;
        inFlight.percourse = true;

        let url = "{{ route('teachers.percourse', ':id') }}".replace(':id', teacherId);
        const params = [];
        if (sessionId) params.push(`session_id=${sessionId}`);
        if (currencyId) params.push(`currency_id=${currencyId}`);
        if (fromDate) params.push(`from_date=${fromDate}`);
        if (toDate) params.push(`to_date=${toDate}`);
        if (params.length) url += `?${params.join('&')}`;

        if (thead) thead.innerHTML = perCourseHead;
        if (tbody) tbody.innerHTML = `<tr><td colspan="11" class="text-center">Loading per-course...</td></tr>`;

        // Update heading
        const heading = document.getElementById('transactionHeading');
        if (heading) heading.textContent = 'Per Course Transactions';

        fetch(url)
            .then(resp => resp.json())
            .then(data => {
                const courses = data.courses || [];
                if (!tbody) return;

                if (!courses.length) {
                    tbody.innerHTML = `<tr><td colspan="11" class="text-center">No courses found</td></tr>`;
                    return;
                }

                tbody.innerHTML = '';
                courses.forEach((course, idx) => {
                    tbody.innerHTML += `
<tr class="course-row" data-idx="${idx}">
<td>${course.name}</td>
<td>${course.session}</td>
<td>${course.transactions}</td>
<td>${course.total_amount}</td>
<td class="paid-cell">${course.total_paid}</td>
<td class="remaining-cell">${course.total_remaining}</td>
<td class="text-center">
<button class="btn btn-sm btn-dark viewCourseDetails" data-idx="${idx}">View</button>
</td>
</tr>`;
                });

                tbody.querySelectorAll('.viewCourseDetails').forEach(btn => {
                    btn.addEventListener('click', e => {
                        e.stopPropagation();
                        showCourseDetails(courses[btn.dataset.idx]);
                    });
                });

            })
            .catch(err => {
                console.error('Error fetching per-course:', err);
                if (tbody) tbody.innerHTML =
                    `<tr><td colspan="11" class="text-center text-danger">Failed to load per-course</td></tr>`;
            })
            .finally(() => inFlight.percourse = false);
    };

    /* ---------------------------
       FETCH: FILTERED TRANSACTIONS WITH DATE RANGE
    --------------------------- */
    window.fetchTransactionsFiltered = function fetchTransactionsFiltered(teacherId, sessionId = null, currencyId = null, fromDate = null, toDate = null) {
        if (!teacherId) return;
        if (inFlight.transactions) return;
        inFlight.transactions = true;

        const teacherInput = document.getElementById('modal_teacher_id');
        if (teacherInput) teacherInput.value = teacherId;

        let url = "{{ route('teachers.data', ':id') }}".replace(':id', teacherId);
        const params = [];
        if (sessionId) params.push(`session_id=${sessionId}`);
        if (currencyId) params.push(`currency_id=${currencyId}`);
        if (fromDate) params.push(`from_date=${fromDate}`);
        if (toDate) params.push(`to_date=${toDate}`);
        if (params.length) url += `?${params.join('&')}`;

        console.log('Fetching filtered transactions with URL:', url);

        if (tbody) tbody.innerHTML = `<tr><td colspan="11" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>`;

        // Restore original thead and update heading
        if (thead) thead.innerHTML = originalHead;
        const heading = document.getElementById('transactionHeading');
        if (heading) heading.textContent = 'Recent Transactions';

        fetch(url)
            .then(resp => resp.json())
            .then(data => {
                if (teacherNameTag) teacherNameTag.textContent = data.teacher?.name || 'N/A';
                if (teacherEmailTag) teacherEmailTag.textContent = data.teacher?.email || 'N/A';
                if (teacherModalNameTag) teacherModalNameTag.value = data.teacher?.name || '';

                const teacherIdInput = document.getElementById('transaction_teacher_id');
                if (teacherIdInput) teacherIdInput.value = teacherId;

                const transactions = data.transactions || [];
                const totals = data.totals || {};

                /* ✅ UPDATE ALL TOTALS (authoritative source) */
                document.querySelectorAll('.total-earned-value').forEach(el =>
                    el.textContent = totals.total_earned ?? (`0.00 ${totals.currency ?? ''}`)
                );
                document.querySelectorAll('.paid-before-value').forEach(el =>
                    el.textContent = totals.paid_before ?? (`0.00 ${totals.currency ?? ''}`)
                );
                document.querySelectorAll('.current-balance-value').forEach(el =>
                    el.textContent = totals.current_balance ?? (`0.00 ${totals.currency ?? ''}`)
                );
                document.querySelectorAll('.total-paid-out-value').forEach(el =>
                    el.textContent = totals.paid_before ?? (`0.00 ${totals.currency ?? ''}`)
                );
                document.querySelectorAll('.total-remaining-value').forEach(el =>
                    el.textContent = totals.remaining ?? (`0.00 ${totals.currency ?? ''}`)
                );

                if (!tbody) return;
                if (!transactions.length) {
                    tbody.innerHTML = `<tr><td colspan="11" class="text-center">No transactions available for the selected filters</td></tr>`;
                } else {
                    tbody.innerHTML = '';
                    transactions.forEach(tx => {
                        tbody.innerHTML += `
<tr data-id="${tx.id}">
<td><input type="checkbox"></td>
<td>${tx.id}</td>
<td>${tx.date}</td>
<td>${tx.course}</td>
<td>${tx.session}</td>
<td>${tx.student}</td>
<td>${tx.student_email}</td>
<td>${tx.student_contact}</td>
<td>${tx.parent}</td>
<td class="total-cell">${tx.total} (${tx.currency})</td>
<td class="paid-cell">${tx.paid} (${tx.currency})</td>
<td class="remaining-cell">${tx.remaining} (${tx.currency})</td>
<td class="text-center">
<button class="btn btn-sm icon-btn restore-btn" data-id="${tx.id}" data-total="${tx.total}" data-paid="${tx.paid}">
<i class="bi bi-arrow-counterclockwise"></i></button>
<button class="btn btn-sm btn-outline-danger delete-transaction-btn" data-id="${tx.id}">
<i class="fa-solid fa-trash"></i></button>
</td>
</tr>`;
                    });
                }

                attachDeleteHandlers();
            })
            .catch(err => {
                console.error('Error fetching filtered transactions:', err);
                if (tbody) tbody.innerHTML =
                    `<tr><td colspan="11" class="text-center text-danger">Failed to load transactions</td></tr>`;
            })
            .finally(() => inFlight.transactions = false);
    };

    /* ---------------------------
       FETCH: FILTERED PER COURSE WITH DATE RANGE
    --------------------------- */
    window.fetchPerCourseFiltered = function fetchPerCourseFiltered(teacherId, sessionId = null, currencyId = null, fromDate = null, toDate = null) {
        if (!teacherId) return;
        if (inFlight.percourse) return;
        inFlight.percourse = true;

        let url = "{{ route('teachers.percourse', ':id') }}".replace(':id', teacherId);
        const params = [];
        if (sessionId) params.push(`session_id=${sessionId}`);
        if (currencyId) params.push(`currency_id=${currencyId}`);
        if (fromDate) params.push(`from_date=${fromDate}`);
        if (toDate) params.push(`to_date=${toDate}`);
        if (params.length) url += `?${params.join('&')}`;

        console.log('Fetching filtered per-course with URL:', url);

        if (thead) thead.innerHTML = perCourseHead;
        if (tbody) tbody.innerHTML = `<tr><td colspan="11" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>`;

        // Update heading
        const heading = document.getElementById('transactionHeading');
        if (heading) heading.textContent = 'Per Course Transactions';

        fetch(url)
            .then(resp => resp.json())
            .then(data => {
                const courses = data.courses || [];
                if (!tbody) return;

                if (!courses.length) {
                    tbody.innerHTML = `<tr><td colspan="11" class="text-center">No courses found</td></tr>`;
                    return;
                }

                tbody.innerHTML = '';
                courses.forEach((course, idx) => {
                    tbody.innerHTML += `
<tr class="course-row" data-idx="${idx}">
<td>${course.name}</td>
<td>${course.session}</td>
<td>${course.transactions}</td>
<td>${course.total_amount}</td>
<td class="paid-cell">${course.total_paid}</td>
<td class="remaining-cell">${course.total_remaining}</td>
<td class="text-center">
<button class="btn btn-sm btn-dark viewCourseDetails" data-idx="${idx}">View</button>
</td>
</tr>`;
                });

                tbody.querySelectorAll('.viewCourseDetails').forEach(btn => {
                    btn.addEventListener('click', e => {
                        e.stopPropagation();
                        showCourseDetails(courses[btn.dataset.idx]);
                    });
                });

            })
            .catch(err => {
                console.error('Error fetching filtered per-course:', err);
                if (tbody) tbody.innerHTML =
                    `<tr><td colspan="11" class="text-center text-danger">Failed to load per-course</td></tr>`;
            })
            .finally(() => inFlight.percourse = false);
    };


    /* ----------------------------------------------------
       FIXED ⚠️ BALANCE UPDATE — NO LONGER OVERWRITES TOTALS
    ---------------------------------------------------- */
    window.updateCurrentBalance = function updateCurrentBalance(teacherId, sessionId, currencyId) {
        if (!teacherId) return;
        if (inFlight.balance) return;
        inFlight.balance = true;

        const balanceUrl = "{{ route('teachers.balance', ['teacherId' => ':id']) }}".replace(':id', teacherId);
        const url = `${balanceUrl}?session_id=${sessionId}&currency_id=${currencyId}`;

        fetch(url)
            .then(resp => resp.json())
            .then(data => {
                const balanceValue = data.current_balance ?? 0;
                const currencyName = data.currency_name ?? '';

                /* ✅ FIX: Update ONLY balance tab elements */
                document.querySelectorAll('.balances-tab-current-balance').forEach(el =>
                    el.textContent =
                    `${Number(balanceValue).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})} ${currencyName}`
                );
            })
            .catch(err => console.error('Error calculating balance:', err))
            .finally(() => inFlight.balance = false);
    };

    /* ---------------------------
       LOAD PAYOUT DATA
    --------------------------- */
    const payoutsTableBody = document.getElementById("payoutsTableBody");

    window.loadPayoutData = function loadPayoutData(teacherId, sessionId, currencyId) {
        if (!teacherId || !sessionId) return;

        if (inFlight.payoutLoad) return;
        inFlight.payoutLoad = true;

        let url = "{{ route('teacher.payouts.data', ':session_id') }}"
            .replace(':session_id', sessionId);
        
        // ✅ Include currency_id in the query parameters
        const params = [`teacher_id=${teacherId}`];
        if (currencyId) {
            params.push(`currency_id=${currencyId}`);
        }
        url += `?${params.join('&')}`;

        // Show loading spinner
        if (payoutsTableBody) {
            payoutsTableBody.innerHTML = `<tr><td colspan="7" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>`;
        }

        fetch(url)
            .then(resp => resp.json())
            .then(data => {
                if (!payoutsTableBody) return;

                const payouts = data.success ? data.payments : [];

                if (payouts.length === 0) {
                    payoutsTableBody.innerHTML =
                        `<tr><td colspan="7" class="text-center text-muted">No payout records</td></tr>`;
                    return;
                }

                payoutsTableBody.innerHTML = payouts.map(p => `
<tr>
<td>${p.date_time}</td>
<td>${p.teacher_name}</td>
<td>${p.course_name}</td>
<td>${p.session_name}</td>
<td>${p.paid_amount} ${p.currency_name}</td>
<td>${p.remarks}</td>
<td class="text-end"><button class="btn btn-sm btn-danger delete-payout-btn" data-id="${p.id}">Delete</button></td>
</tr>`).join('');

                if (window.applyColumnVisibility) window.applyColumnVisibility();
            })
            .catch(err => {
                console.error("Payout error:", err);
                payoutsTableBody.innerHTML =
                    `<tr><td colspan="7" class="text-center text-muted">Error loading payouts</td></tr>`;
            })
            .finally(() => inFlight.payoutLoad = false);
    };

    /* ---------------------------  
       LOAD PAYOUT DATA WITH DATE FILTER
    --------------------------- */
    window.loadPayoutDataFiltered = function loadPayoutDataFiltered(teacherId, sessionId, currencyId, fromDate = null, toDate = null) {
        if (!teacherId || !sessionId) return;

        if (inFlight.payoutLoad) return;
        inFlight.payoutLoad = true;

        let url = "{{ route('teacher.payouts.data', ':session_id') }}"
            .replace(':session_id', sessionId);
        
        // ✅ Include currency_id along with date filters
        const params = [`teacher_id=${teacherId}`];
        if (currencyId) {
            params.push(`currency_id=${currencyId}`);
        }
        if (fromDate) params.push(`from_date=${fromDate}`);
        if (toDate) params.push(`to_date=${toDate}`);
        url += `?${params.join('&')}`;

        // Show loading spinner
        if (payoutsTableBody) {
            payoutsTableBody.innerHTML = `<tr><td colspan="7" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>`;
        }

        fetch(url)
            .then(resp => resp.json())
            .then(data => {
                if (!payoutsTableBody) return;

                const payouts = data.success ? data.payments : [];

                if (payouts.length === 0) {
                    payoutsTableBody.innerHTML =
                        `<tr><td colspan="7" class="text-center text-muted">No payout records</td></tr>`;
                    return;
                }

                payoutsTableBody.innerHTML = payouts.map(p => `
<tr>
<td data-col="date_time">${p.date_time}</td>
<td data-col="teacher_name">${p.teacher_name}</td>
<td data-col="course_name">${p.course_name}</td>
<td data-col="session_name">${p.session_name}</td>
<td data-col="paid">${p.paid_amount} ${p.currency_name}</td>
<td data-col="remarks">${p.remarks}</td>
<td data-col="actions" class="text-end"><button class="btn btn-sm btn-danger delete-payout-btn" data-id="${p.id}">Delete</button></td>
</tr>`).join('');

                // if (window.applyColumnVisibility) window.applyColumnVisibility();
            })
            .catch(err => {
                console.error("Payout error:", err);
                payoutsTableBody.innerHTML =
                    `<tr><td colspan="7" class="text-center text-muted">Error loading payouts</td></tr>`;
            })
            .finally(() => inFlight.payoutLoad = false);
    };

    /* ---------------------------  
       DELETE TRANSACTION  
    --------------------------- */
    function attachDeleteHandlers() {
        document.querySelectorAll('.delete-transaction-btn').forEach(btn => {
            if (btn.dataset.handlerAttached) return;
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const transactionId = this.dataset.id;
                if (!transactionId) return;
                if (!confirm('Are you sure you want to delete this transaction?')) return;

                const deleteUrl = "{{ route('transactions.delete', ':id') }}"
                    .replace(':id', transactionId);

                const tokenMeta = document.querySelector('meta[name="csrf-token"]');
                const headers = { 'Accept': 'application/json' };
                if (tokenMeta) headers['X-CSRF-TOKEN'] = tokenMeta.content;

                fetch(deleteUrl, {
                    method: 'DELETE',
                    headers
                })
                    .then(resp => resp.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message || 'Transaction deleted successfully.');
                            const teacherId =
                                document.getElementById('transaction_teacher_id')?.value
                                || teacherSelect?.value;

                            const sessionId = sessionSelect?.value;
                            const currencyId = currencySelect?.value;

                            if (subPerCourse?.classList.contains('active'))
                                fetchPerCourse(teacherId, sessionId, currencyId);
                            else
                                fetchTransactions(teacherId, sessionId, currencyId);
                        }
                    });
            });
            btn.dataset.handlerAttached = '1';
        });
    }

    /* ---------------------------
       DETAIL MODAL (Replaced inline card with modal)
    --------------------------- */
    function showCourseDetails(course = null) {
        if (!course) course = { transactions_details: [] };

        const modal = document.getElementById('courseDetailsModal');
        const modalBody = document.getElementById('courseDetailsTableBody');
        const modalTitle = document.getElementById('courseDetailsModalLabel');
        
        if (!modal || !modalBody) return;

        // Update modal title
        if (modalTitle && course.name) {
            modalTitle.textContent = `${course.name} - Transaction Details`;
        } else {
            modalTitle.textContent = 'Course Transaction Details';
        }

        // Build table rows
        let rows = '';
        (course.transactions_details || []).forEach(tx => {
            rows += `
<tr data-id="${tx.id}">
<td>${tx.id}</td>
<td>${tx.date}</td>
<td>${tx.student}</td>
<td>${tx.student_email}</td>
<td>${tx.student_contact}</td>
<td>${tx.currency}</td>
<td>${tx.total}</td>
<td>${tx.paid}</td>
<td>${tx.remaining}</td>
</tr>`;
        });

        // Update modal content
        if (rows) {
            modalBody.innerHTML = rows;
        } else {
            modalBody.innerHTML = '<tr><td colspan="9" class="text-center text-muted">No transactions available</td></tr>';
        }

        // Show modal
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
    }

    /* ---------------------------
       RESTORE ORIGINAL TABLE
    --------------------------- */
    function restoreOriginalTransactions() {
        if (thead) thead.innerHTML = originalHead;
        if (tbody) tbody.innerHTML = originalBody;
        attachDeleteHandlers();
    }

    /* ---------------------------
       MAIN TAB CONTROLS
    --------------------------- */
    window.showSection = function showSection(sectionId) {
        sections.forEach(id => {
            const el = document.getElementById(id);
            if (!el) return;
            el.style.display = (id === sectionId) ? 'block' : 'none';
        });

        mainTabBtns.forEach(b =>
            b.classList.toggle('active', b.dataset.target === sectionId)
        );

        // ✅ CRITICAL FIX: Only show sub-tabs for transactions, hide for all others
        if (sectionId === 'transactionsDiv') {
            if (subTabContainer) {
                subTabContainer.style.removeProperty('display');
                subTabContainer.style.display = 'flex';
            }
        } else {
            // For all other tabs (Payouts, Balances, Reports), force hide sub-tabs
            if (subTabContainer) {
                subTabContainer.style.setProperty('display', 'none', 'important');
            }
        }

        if (sectionId !== 'transactionsDiv') {
            subRecent?.classList.remove('active');
            subPerCourse?.classList.remove('active');
        }

        const teacherId = document.getElementById('transaction_teacher_id')?.value || teacherSelect?.value;
        const sessionId = sessionSelect?.value;
        const currencyId = currencySelect?.value;

        if (!teacherId || !sessionId) return;

        if (sectionId === 'transactionsDiv') {
            // ✅ USE GLOBAL STATE to determine which sub-tab to show
            if (window.currentTransactionTab === 'percourse') {
                subPerCourse.classList.add('active');
                subRecent.classList.remove('active');
            } else {
                subRecent.classList.add('active');
                subPerCourse.classList.remove('active');
            }
            
            // Note: We don't fetch here because usually showSection is called by clicking the tab,
            // which doesn't necessarily mean we need to re-fetch if data is already there.
            // But if we wanted to be safe, we could.
        }

        if (sectionId === 'balancesDiv') {
            // Hide sub-tabs for balances
            if (subTabContainer) subTabContainer.style.setProperty('display', 'none', 'important');
            updateCurrentBalance(teacherId, sessionId, currencyId);
        }

        if (sectionId === 'payoutsDiv') {
            // Hide sub-tabs for payouts
            if (subTabContainer) subTabContainer.style.setProperty('display', 'none', 'important');
            loadPayoutData(teacherId, sessionId, currencyId);
        }

        if (sectionId === 'reportsDiv') {
            // Hide sub-tabs for reports
            if (subTabContainer) subTabContainer.style.setProperty('display', 'none', 'important');
        }
    };

    /* ---------------------------
       SUB-TABS
    --------------------------- */
    window.activateSub = function activateSub(which) {
        const teacherIdCurrent =
            document.getElementById('transaction_teacher_id')?.value ||
            teacherSelect?.value;

        if (!teacherIdCurrent) return;

        if (which === 'recent') {
            // ✅ UPDATE GLOBAL STATE
            console.log('🔄 activateSub(recent) - Setting global state to: recent');
            window.currentTransactionTab = 'recent';
            subRecent.classList.add('active');
            subPerCourse.classList.remove('active');
            fetchTransactions(teacherIdCurrent, sessionSelect?.value, currencySelect?.value);
        } else {
            // ✅ UPDATE GLOBAL STATE  
            console.log('🔄 activateSub(percourse) - Setting global state to: percourse');
            window.currentTransactionTab = 'percourse';
            subPerCourse.classList.add('active');
            subRecent.classList.remove('active');
            fetchPerCourse(teacherIdCurrent, sessionSelect?.value, currencySelect?.value);
        }
        console.log('✅ State after activateSub:', window.currentTransactionTab);
    };

    mainTabBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            showSection(btn.dataset.target);
        });
    });

    subRecent?.addEventListener('click', e => {
        e.preventDefault();
        activateSub('recent');
    });

    subPerCourse?.addEventListener('click', e => {
        e.preventDefault();
        activateSub('percourse');
    });

    /* ---------------------------
       TEACHER SELECT
    --------------------------- */
    teacherSelect?.addEventListener('change', function() {
        const teacherId = this.value;

        if (!teacherId) {
            noTeacherSelected.style.display = 'block';
            teacherData.style.display = 'none';
            return;
        }

        noTeacherSelected.style.display = 'none';
        teacherData.style.display = 'block';

        const transBtn = [...mainTabBtns].find(b => b.dataset.target === 'transactionsDiv');
        transBtn?.classList.add('active');
        subTabContainer.style.display = 'flex';

        subRecent.classList.add('active');
        subPerCourse.classList.remove('active');
        
        // ✅ Set global state to 'recent' since we're loading recent transactions
        window.currentTransactionTab = 'recent';

        fetchTransactions(teacherId, sessionSelect.value, currencySelect.value);
    });
    
    /* ---------------------------
       SESSION/YEAR CHANGED
    --------------------------- */
    if (sessionSelect) {
        sessionSelect.addEventListener('change', function(e) {
            e.preventDefault();
            const sessionId = this.value;
            if (!sessionId) return;
            
            console.log('======= YEAR CHANGE TRIGGERED =======');
            
            this.disabled = true;
            
            const teacherId = teacherSelect?.value;
            const currencyId = currencySelect?.value;
            
            if (!teacherId) {
                this.disabled = false;
                return;
            }
            
            // Check which main tab is active
            const payoutsDiv = document.getElementById('payoutsDiv');
            const transactionsDiv = document.getElementById('transactionsDiv');
            
            if (transactionsDiv && transactionsDiv.style.display !== 'none') {
                // ✅ Check which sub-tab button is active (same as platform file approach)
                console.log('Transaction tab is active, checking sub-tabs...');
                
                if (subPerCourse && subPerCourse.classList.contains('active')) {
                    // ✅ STAY ON PER COURSE
                    console.log('❗ Per Course is active - calling fetchPerCourse');
                    if (window.fetchPerCourse) {
                        window.fetchPerCourse(teacherId, sessionId, currencyId);
                    }
                } else if (subRecent && subRecent.classList.contains('active')) {
                    // ✅ STAY ON RECENT
                    console.log('❗ Recent is active - calling fetchTransactions');
                    if (window.fetchTransactions) {
                        window.fetchTransactions(teacherId, sessionId, currencyId);
                    }
                }
                
                setTimeout(() => { this.disabled = false; }, 200);
            } else if (payoutsDiv && payoutsDiv.style.display !== 'none') {
                const subTabContainer = document.getElementById('subTabContainer');
                if (subTabContainer) {
                    subTabContainer.style.setProperty('display', 'none', 'important');
                }
                if (window.loadPayoutData) {
                    window.loadPayoutData(teacherId, sessionId, currencyId);
                }
                this.disabled = false;
            } else if (document.getElementById('balancesDiv')?.style.display !== 'none') {
                const subTabContainer = document.getElementById('subTabContainer');
                if (subTabContainer) {
                    subTabContainer.style.setProperty('display', 'none', 'important');
                }
                this.disabled = false;
            } else if (document.getElementById('reportsDiv')?.style.display !== 'none') {
                const subTabContainer = document.getElementById('subTabContainer');
                if (subTabContainer) {
                    subTabContainer.style.setProperty('display', 'none', 'important');
                }
                this.disabled = false;
            } else {
                this.disabled = false;
            }
        });
    }

    /* ---------------------------
       INITIAL LOAD
    --------------------------- */
    (function initialLoad() {
        const initialTeacherId = teacherSelect.value;

        if (initialTeacherId) {
            noTeacherSelected.style.display = 'none';
            teacherData.style.display = 'block';
            // Only show sub-tabs for Transactions tab - this is the default
            subTabContainer.style.display = 'flex';

            const transBtn = [...mainTabBtns].find(b => b.dataset.target === 'transactionsDiv');
            transBtn?.classList.add('active');

            subRecent.classList.add('active');

            fetchTransactions(initialTeacherId, sessionSelect.value, currencySelect.value);
        }
    })();

    /* ---------------------------
       PAYOUT MODAL - CURRENCY ALIGNMENT FIX (ENHANCED)
    --------------------------- */
    const payoutsModalEl = document.getElementById('payoutsModal');
    if (payoutsModalEl) {
        // Fix alignment when modal is being shown
        payoutsModalEl.addEventListener('show.bs.modal', function() {
            const currencyInput = document.getElementById('currency_name');
            if (currencyInput) {
                currencyInput.style.setProperty('text-align', 'left', 'important');
                currencyInput.style.setProperty('padding-left', '12px', 'important');
            }
        });
        
        // Fix alignment after modal is fully shown
        payoutsModalEl.addEventListener('shown.bs.modal', function() {
            const currencyInput = document.getElementById('currency_name');
            if (currencyInput) {
                currencyInput.style.setProperty('text-align', 'left', 'important');
                currencyInput.style.setProperty('padding-left', '12px', 'important');
            }
        });
    }


    /* ---------------------------
       CURRENCY CHANGED
    --------------------------- */
    if (currencySelect) {
        currencySelect.addEventListener('change', function() {
            console.log('===== CURRENCY CHANGE DETECTED =====');
            
            const currencyId = this.value;
            const currencyName = this.options[this.selectedIndex]?.text.trim();
            
            console.log('Selected Currency ID:', currencyId);
            console.log('Selected Currency Name:', currencyName);
            
            if (!currencyId) {
                console.warn('No currency ID selected');
                return;
            }
            
            // ✅ SAVE CURRENCY TO BACKEND
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (csrfToken) {
                console.log('Saving currency to backend...');
                fetch("{{ route('platform_currency.update') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ default_currency: currencyId })
                })
                .then(resp => resp.json())
                .then(data => {
                    if (data.success) {
                        console.log('Currency saved to backend successfully');
                    } else {
                        console.warn('Backend currency save failed:', data);
                    }
                })
                .catch(err => console.error('Error saving currency:', err));
            }
            
            // ✅ UPDATE ALL CURRENCY FIELDS IMMEDIATELY
            console.log('Updating all currency fields...');
            
            // Transaction Modal Currency Fields
            const transactionCurrencyDisplay = document.getElementById('transaction_currency_display');
            const transactionCurrentCurrency = document.getElementById('transaction_current_currency');
            
            if (transactionCurrencyDisplay) {
                transactionCurrencyDisplay.value = currencyName;
                console.log('Updated transaction_currency_display');
            }
            if (transactionCurrentCurrency) {
                transactionCurrentCurrency.value = currencyId;
                console.log('Updated transaction_current_currency');
            }
            
            // Payout Modal Currency Fields
            const payoutCurrencyName = document.getElementById('currency_name');
            const payoutSelectedCurrency = document.getElementById('selected_currency');
            
            if (payoutCurrencyName) {
                payoutCurrencyName.value = currencyName;
                console.log('Updated payout currency_name');
            }
            if (payoutSelectedCurrency) {
                payoutSelectedCurrency.value = currencyId;
                console.log('Updated payout selected_currency');
            }
            
            // Hidden Currency Inputs
            const currentCurrency = document.getElementById('current_currency');
            const currentCurrencyName = document.getElementById('current_currency_name');
            
            if (currentCurrency) {
                currentCurrency.value = currencyId;
                console.log('Updated current_currency');
            }
            if (currentCurrencyName) {
                currentCurrencyName.value = currencyName;
                console.log('Updated current_currency_name');
            }
            
            console.log('All currency fields updated successfully');
            
            // ✅ RELOAD DATA WITH NEW CURRENCY
            const teacherId = teacherSelect?.value;
            const sessionId = sessionSelect?.value;
            
            console.log('Teacher ID:', teacherId);
            console.log('Session ID:', sessionId);
            
            if (!teacherId) {
                console.warn('No teacher selected, skipping data reload');
                console.log('===== CURRENCY CHANGE COMPLETED =====');
                return;
            }
            
            console.log('Reloading data with new currency...');
            
            // Check which tab is active and reload ONLY the appropriate data
            const payoutsDiv = document.getElementById('payoutsDiv');
            const transactionsDiv = document.getElementById('transactionsDiv');
            
            if (transactionsDiv && transactionsDiv.style.display !== 'none') {
                console.log('Transactions tab is active');
                
                // ✅ Check which sub-tab button is active (same as year change handler)
                if (subPerCourse && subPerCourse.classList.contains('active')) {
                    console.log('Per Course is active - fetching per-course data');
                    if (window.fetchPerCourse) {
                        window.fetchPerCourse(teacherId, sessionId, currencyId);
                    }
                } else if (subRecent && subRecent.classList.contains('active')) {
                    console.log('Recent is active - fetching recent transactions');
                    if (window.fetchTransactions) {
                        window.fetchTransactions(teacherId, sessionId, currencyId);
                    }
                }
            } else if (payoutsDiv && payoutsDiv.style.display !== 'none') {
                console.log('Payouts tab is active');
                if (window.loadPayoutData) {
                    console.log('Loading payout data...');
                    window.loadPayoutData(teacherId, sessionId, currencyId);
                }
            } else {
                console.log('Other tab is active');
            }
            
            console.log('===== CURRENCY CHANGE COMPLETED =====');
        });
        
        console.log('Currency select event listener attached successfully');
    } else {
        console.error('Currency select element not found!');
    }

    /* ---------------------------
       DATE RANGE FILTER FUNCTIONALITY
    --------------------------- */
    // Transaction Filter Button
    const transactionFilterBtn = document.getElementById('transactionFilterBtn');
    if (transactionFilterBtn) {
        transactionFilterBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const fromDate = document.getElementById('transactionFromDate')?.value;
            const toDate = document.getElementById('transactionToDate')?.value;
            const teacherId = document.getElementById('transaction_teacher_id')?.value || teacherSelect?.value;
            const sessionId = sessionSelect?.value;
            const currencyId = currencySelect?.value;

            if (!teacherId) {
                alert('Please select a teacher first');
                return;
            }

            // Check which sub-tab is active
            const subPerCourse = document.getElementById('sub-percourse');
            const isPerCourseActive = subPerCourse && subPerCourse.classList.contains('active');

            if (isPerCourseActive && window.fetchPerCourseFiltered) {
                window.fetchPerCourseFiltered(teacherId, sessionId, currencyId, fromDate, toDate);
            } else if (window.fetchTransactionsFiltered) {
                window.fetchTransactionsFiltered(teacherId, sessionId, currencyId, fromDate, toDate);
            }
        });
    }

    // Payout Filter Button
    const payoutFilterBtn = document.getElementById('payoutFilterBtn');
    if (payoutFilterBtn) {
        payoutFilterBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const fromDate = document.getElementById('payoutFromDate')?.value;
            const toDate = document.getElementById('payoutToDate')?.value;
            const teacherId = teacherSelect?.value;
            const sessionId = sessionSelect?.value;
            const currencyId = currencySelect?.value;

            if (!teacherId || !sessionId) {
                alert('Please select a teacher and session first');
                return;
            }

            // ✅ FETCH TRANSACTION DATA to update statistics (Total Revenue, Paid Before, Current Balance)
            if (window.fetchTransactionsFiltered) {
                console.log('Fetching transaction data with date filter to update statistics...');
                window.fetchTransactionsFiltered(teacherId, sessionId, currencyId, fromDate, toDate);
            }

            // ✅ FETCH PAYOUT DATA with date filter
            if (window.loadPayoutDataFiltered) {
                console.log('Fetching payout data with date filter...');
                window.loadPayoutDataFiltered(teacherId, sessionId, currencyId, fromDate, toDate);
            }
        });
    }

});
</script>






{{-- This is the script for currency modal synchronization --}}

<script>
    $(document).ready(function() {
            // Ensure transaction modal shows current currency on open
            $('#transactionsModal').on('show.bs.modal', function() {
                const currentCurrencyId = $('#current_currency').val();
                if (currentCurrencyId) {
                    $('#currencySelect').val(currentCurrencyId);
                }
            });
        });
</script>



{{-- This is the script of teacher storing modal --}}


<script>
    document.addEventListener('DOMContentLoaded', function() {
            const transactionsForm = document.getElementById('transactionsForm');
            const transactionTeacher = document.getElementById('transaction_teacher');
            const transactionTeacherId = document.getElementById('transaction_teacher_id');
            const transactionSession = document.getElementById('transaction_session');
            const transactionSessionId = document.getElementById('transaction_session_id');
            const transactionTotal = document.getElementById('transaction_total');
            const transactionCourseFee = document.getElementById('transaction_course_fee');
            const transactionNoteFee = document.getElementById('transaction_note_fee');
            const transactionPaid = document.getElementById('transaction_paid');
            const transactionRemaining = document.getElementById('transaction_remaining');
            const selectYear = document.getElementById('SelectYear');
            const openModalBtns = document.querySelectorAll('.openTransactionModal');
            const transactionsModal = document.getElementById('transactionsModal');




            function updateTotal() {
                const courseFee = parseFloat(transactionCourseFee.value) || 0;
                const noteFee = parseFloat(transactionNoteFee.value) || 0;

                const newTotal = courseFee + noteFee;

                transactionTotal.value = newTotal.toFixed(2);
            }

            transactionCourseFee.addEventListener('input', updateTotal);
            transactionNoteFee.addEventListener('input', updateTotal);
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

                    // Trigger teacher change logic after session update
                    // 🚨 FIX: Commented out to prevent resetting to "Recent" tab when year changes
                    // const event = new Event('change');
                    // teacherSelect.dispatchEvent(event);
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
                            
                            // Reset the form to clear all fields
                            transactionsForm.reset();
                            
                            // Close the modal
                            bootstrap.Modal.getInstance(transactionsModal).hide();

                            // ✅ IMMEDIATELY RELOAD THE TABLE DATA
                            const teacherId = document.getElementById('transaction_teacher_id')?.value || 
                                            document.getElementById('teacherSelect')?.value;
                            const sessionId = document.getElementById('SelectYear')?.value;
                            const currencyId = document.getElementById('currencySelect')?.value;
                            
                            // Check which sub-tab is active
                            const subPerCourse = document.getElementById('sub-percourse');
                            const isPerCourseActive = subPerCourse && subPerCourse.classList.contains('active');
                            
                            if (teacherId) {
                                if (isPerCourseActive && window.fetchPerCourse) {
                                    window.fetchPerCourse(teacherId, sessionId, currencyId);
                                } else if (window.fetchTransactions) {
                                    window.fetchTransactions(teacherId, sessionId, currencyId);
                                }
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
                    // Fixed column indices based on actual table structure:
                    // 0=checkbox, 1=ID, 2=Date, 3=Course, 4=Session, 5=Student, 
                    // 6=Student Email, 7=Student Contact, 8=Parent, 9=Total, 10=Paid, 11=Remaining
                    totalCell = row.cells[9];
                    paidCell = row.cells[10];
                    remainingCell = row.cells[11];
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

                // Check if we're in Per Course mode
                const subPerCourse = document.getElementById('sub-percourse');
                const isCourse = subPerCourse && subPerCourse.classList.contains('active');

                console.log('Restore submission - isCourse:', isCourse);
                console.log('Transaction ID:', transactionId);
                console.log('New Paid:', newPaid);

                const endpoint = isCourse ?
                    "{{ route('transactions.restore-percourse') }}" :
                    "{{ route('transactions.restore') }}";

                console.log('Using endpoint:', endpoint);

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

                    console.log('Response:', data);

                    if (!response.ok || !data.success) {
                        const errorMsg = data.message || 'An error occurred';
                        console.error('Restore failed:', {
                            status: response.status,
                            statusText: response.statusText,
                            data: data
                        });
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
                    
                    const updatedRows = []; // Store updated rows for highlighting
                    
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
                            
                            // Store row for highlighting
                            updatedRows.push(r);
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
                            
                            // Store row for highlighting
                            updatedRows.push(r);
                        });
                    }

                    // ========== HIGHLIGHT UPDATED ROWS ==========
                    updatedRows.forEach(row => {
                        // Store original background color
                        const originalBg = row.style.backgroundColor || '';
                        
                        // Apply highlight color
                        row.style.transition = 'background-color 0.3s ease';
                        row.style.backgroundColor = '#d4edda'; // Light green
                        
                        // Remove highlight after 3 seconds
                        setTimeout(() => {
                            row.style.backgroundColor = originalBg;
                            // Remove transition after fade completes
                            setTimeout(() => {
                                row.style.transition = '';
                            }, 300);
                        }, 3000);
                    });

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

                    // Table is already updated in place above (lines 2221-2263)
                    // No need to refresh the entire table as it causes duplicate rows

                } catch (err) {
                    console.error('AJAX Error:', err);
                    alert('An error occurred. Check console for details.');
                }
            });

            console.log('=== Restore Modal Script Completed ===\n');
        });
</script>

<script>
/* ---------------------------
   PAYOUT COLUMN VISIBILITY
--------------------------- */
function togglePayoutColumns() {
    const modal = document.getElementById('payoutColumnModal');
    const checkboxContainer = document.getElementById('payoutColumnCheckboxes');
    
    if (!modal || !checkboxContainer) {
        console.error('Payout column modal elements not found');
        return;
    }
    
    // Get all column headers from payout table
    const payoutTable = document.getElementById('payoutsTable');
    const headers = payoutTable.querySelectorAll('thead th[data-col]');
    
    // Clear existing checkboxes
    checkboxContainer.innerHTML = '';
    
    // Create checkbox for each column
    headers.forEach(header => {
        const colName = header.getAttribute('data-col');
        const colLabel = header.textContent.trim();
        // ✅ FIX: Check inline style instead of class
        const isVisible = header.style.display !== 'none';
        
        const div = document.createElement('div');
        div.className = 'form-check mb-2';
        div.innerHTML = `
            <input class="form-check-input payout-column-toggle" type="checkbox" data-col="${colName}"
                   value="${colName}" id="payout_col_${colName}" ${isVisible ? 'checked' : ''}>
            <label class="form-check-label" for="payout_col_${colName}">
                ${colLabel}
            </label>
        `;
        checkboxContainer.appendChild(div);
    });
    
    // Show modal
    const bsModal = new bootstrap.Modal(modal);
    bsModal.show();
}

// Apply payout column visibility when checkboxes change
document.addEventListener('DOMContentLoaded', function() {
    // ✅ NOTE: Checkboxes use .payout-column-toggle class to work with jQuery handler at line 3628
    const applyBtn = document.querySelector('#payoutColumnModal .modal-footer .btn-primary[data-bs-dismiss="modal"]');
    
    console.log('=== Column Toggle Setup ===');
    console.log('Apply button found:', !!applyBtn);
    
    if (applyBtn) {
        applyBtn.addEventListener('click', function() {
            console.log('=== Apply Button Clicked ===');
            
            const checkboxes = document.querySelectorAll('.payout-col-checkbox');
            const payoutTable = document.getElementById('payoutsTable');
            
            console.log('Checkboxes found:', checkboxes.length);
            console.log('Payout table found:', !!payoutTable);
            
            if (!payoutTable) {
                console.error('Payout table not found!');
                return;
            }
            
            checkboxes.forEach(checkbox => {
                const colName = checkbox.value;
                const isChecked = checkbox.checked;
                
                console.log(`Processing column: ${colName}, checked: ${isChecked}`);
                
                // ✅ FIX: Use inline styles instead of classes for consistent behavior with renderTable()
                // Toggle headers
                const headers = payoutTable.querySelectorAll(`thead th[data-col="${colName}"]`);
                console.log(`  Found ${headers.length} header cells with data-col="${colName}"`);
                headers.forEach(h => {
                    h.style.display = isChecked ? '' : 'none';
                });
                
                // ✅ FIX: Toggle data cells using inline styles
                const cells = payoutTable.querySelectorAll(`tbody td[data-col="${colName}"]`);
                console.log(`  Found ${cells.length} body cells with data-col="${colName}"`);
                
                if (cells.length === 0) {
                    console.warn(`  WARNING: No body cells found for column ${colName}!`);
                    // Let's check what data-col values exist
                    const allBodyCells = payoutTable.querySelectorAll('tbody td[data-col]');
                    console.log(`  Total tbody cells with data-col attribute: ${allBodyCells.length}`);
                    if (allBodyCells.length > 0) {
                        console.log(`  Sample data-col values:`, Array.from(allBodyCells).slice(0, 3).map(c => c.getAttribute('data-col')));
                    }
                }
                
                cells.forEach(c => {
                    console.log(`    Toggling cell with data-col="${c.getAttribute('data-col')}" to display: ${isChecked ? '' : 'none'}`);
                    c.style.display = isChecked ? '' : 'none';
                });
                
                // ✅ UPDATE: Also update window.payoutTableState.hiddenColumns
                const hiddenIndex = window.payoutTableState.hiddenColumns.indexOf(colName);
                if (!isChecked && hiddenIndex === -1) {
                    window.payoutTableState.hiddenColumns.push(colName);
                } else if (isChecked && hiddenIndex !== -1) {
                    window.payoutTableState.hiddenColumns.splice(hiddenIndex, 1);
                }
            });
            
            console.log('Column visibility applied. Hidden columns:', window.payoutTableState.hiddenColumns);
            console.log('=== Apply Complete ===');
        });
    } else {
        console.error('Apply button not found in modal!');
    }
});
</script>


{{-- This is the script of teacher payout modal --}}
<script>
    $(document).ready(function() {

            $("#teacherpayoutForm").on("submit", function(e) {
                e.preventDefault();

                // CRITICAL: Force-sync currency from main dropdown RIGHT BEFORE submission
                const currentCurrency = $('#currencySelect').val();
                const currentCurrencyName = $('#currencySelect option:selected').text();
                
                console.log('=== FORCING CURRENCY SYNC BEFORE SUBMIT ===');
                console.log('Main Currency Dropdown:', currentCurrency, '-', currentCurrencyName);
                
                // Update the hidden field that will be submitted
                $('#selected_currency').val(currentCurrency);
                $('#currency_name').val(currentCurrencyName);
                
                console.log('Updated selected_currency to:', $('#selected_currency').val());
                console.log('==========================================');

                let formData = new FormData(this);
                
                // Debug: Log what currency is being submitted
                console.log('=== Payout Form Submission ===');
                console.log('Selected Currency (hidden):', formData.get('selected_currency'));
                console.log('Main Currency Dropdown:', $('#currencySelect').val());
                console.log('Currency Name Field:', $('#currency_name').val());
                console.log('==============================');

                $.ajax({
                    url: "{{ route('payouts.store') }}", // ✅ route name here
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(response) {
                        if (response.success) {
                            
                            // Reset the form to clear all fields
                            $("#teacherpayoutForm")[0].reset();
                            
                            // Show success message
                            alert("Payout saved successfully!");
                            
                            // Close the modal
                            $("#payoutsModal").modal("hide");

                            const p = response.payout;
                            const tbody = $("#payoutsTableBody");

                            // Remove placeholder row if exists
                            if (tbody.find("tr").length === 1 && tbody.find("tr td").first()
                                .attr("colspan") == 9) {
                                tbody.empty();
                            }

                            // Update global state for exports
                            if (window.payoutTableState) {
                                const formattedPayout = {
                                    id: p.id,
                                    date_time: p.created_at ? new Date(p.created_at).toLocaleString() : '-',
                                    teacher_name: p.teacher ? p.teacher.teacher_name : '-',
                                    course_name: p.course ? p.course.course_title : '-',
                                    session_name: p.session ? p.session.session_title : '-',
                                    student_name: '-', // Payouts don't usually have student/parent info like transactions
                                    parent_name: '-',
                                    paid: `${parseFloat(p.paid_amount).toFixed(2)} ${p.currency ? p.currency.currency_name : ''}`,
                                    remarks: p.remarks || '-',
                                    type: "Teacher"
                                };
                                window.payoutTableState.allData.push(formattedPayout);

                                // Only push to currentTableData if it's a different array (e.g. filtered)
                                if (window.payoutTableState.allData !== window.payoutTableState.currentTableData) {
                                    window.payoutTableState.currentTableData.push(formattedPayout);
                                }
                            }

                            // Append new row with proper related names
                            const newRow = `
                    <tr>
                        <td data-col="date_time">${p.created_at ? new Date(p.created_at).toLocaleString() : '-'}</td>
                        <td data-col="teacher_name">${p.teacher ? p.teacher.teacher_name : '-'}</td>
                        <td data-col="course_name">${p.course ? p.course.course_title : '-'}</td>
                        <td data-col="session_name">${p.session ? p.session.session_title : '-'}</td>
                        <td data-col="paid">${parseFloat(p.paid_amount).toFixed(2)} ${p.currency ? p.currency.currency_name : ''}</td>
                        <td data-col="remarks">${p.remarks || '-'}</td>
                        <td class="text-end" data-col="actions">
                            <button class="btn btn-sm btn-danger delete-payout-btn" data-id="${p.id}">Delete</button>
                        </td>
                    </tr>
                `;

                            // Instead of manually appending, refresh the payout table from backend
                            // This ensures data consistency when switching currencies
                            console.log('Payout added successfully, refreshing payout table...');
                            
                            // ✅ Refresh all balance statistics immediately
                            const teacherId = $('#teacherSelect').val();
                            const sessionId = $('#SelectYear').val();
                            const currencyId = $('#currencySelect').val();
                            
                            // ✅ Refresh payout table to get updated data from backend
                            if (window.loadPayoutData) {
                                window.loadPayoutData(teacherId, sessionId, currencyId);
                            } else {
                                console.error('loadPayoutData function not found!');
                            }
                            
                            if (teacherId && sessionId && window.fetchTransactions) {
                                // Fetch transactions updates all balance stats
                                window.fetchTransactions(teacherId, sessionId, currencyId);
                            }
                        }
                    },


                    error: function(xhr) {
                        console.log(xhr.responseText);

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let messages = "";

                            Object.keys(errors).forEach(function (key) {
                                messages += errors[key][0] + "\n";
                            });

                            alert("Validation Errors:\n\n" + messages);
                        } else {
                            alert("Error! Could not save payout.");
                        }
                    }

                });
            });

        });
</script>


{{-- This is the script for export of pdf and excel transaction and recent transaction --}}




<script>
    // ================= PDF Export =================
       window.exportPDF = function() {
            const teacherId = document.getElementById('transaction_teacher_id')?.value ||
                document.getElementById('teacherSelect')?.value;

            if (!teacherId) {
                toastr.error('Select a teacher first');
                return;
            }

            const tbody = document.getElementById('transactionsTableBody');
            const thead = document.getElementById('transactionsThead');

            if (!tbody || !thead || tbody.rows.length === 0) {
                toastr.error('No transactions to export');
                return;
            }

            if (typeof jspdf === 'undefined') {
                toastr.error('PDF libraries not loaded');
                return;
            }

            const img = new Image();
            img.src = '{{ asset('assets/logo_pic/vteach_logo.jpg') }}';
            img.crossOrigin = "anonymous";

            img.onload = function() {
                generatePDF(img, true);
            };

            img.onerror = function() {
                console.warn('Logo could not be loaded, PDF will be generated without it.');
                generatePDF(null, false);
            };

            function generatePDF(imgElement, hasLogo) {
                try {
                    const { jsPDF } = window.jspdf;
                    const doc = new jsPDF();

                    const teacherName = document.getElementById('teacher_name')?.textContent || 'Teacher Report';
                    const teacherEmail = document.getElementById('teacher_email')?.textContent || '';

                    const totalEarned = document.querySelector('.total-earned-value')?.textContent || '0.00';
                    const currentBalance = document.querySelector('.current-balance-value')?.textContent || '0.00';
                    const paidBefore = document.querySelector('.paid-before-value')?.textContent || '0.00';

                    // Add logo
                    if (hasLogo && imgElement) {
                        const canvas = document.createElement('canvas');
                        canvas.width = imgElement.width;
                        canvas.height = imgElement.height;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(imgElement, 0, 0);
                        const imgData = canvas.toDataURL('image/jpeg');

                        const pageWidth = doc.internal.pageSize.getWidth();
                        doc.addImage(imgData, 'JPEG', pageWidth - 32, 10, 20, 20);
                    }

                    // Title
                    doc.setFontSize(14);
                    doc.setFont('helvetica', 'bold');
                    doc.text("Teacher Transaction Report", 15, 20);

                    // Generated Time (ADDED)
                    doc.setFontSize(10);
                    doc.setFont('helvetica', 'normal');
                    const options = { 
                        year: 'numeric', month: 'short', day: '2-digit', 
                        hour: '2-digit', minute: '2-digit', hour12: true 
                    };
                    const generatedTime = new Date().toLocaleString('en-US', options);
                    doc.text(`Generated Time: ${generatedTime}`, 15, 26);

                    // Teacher Info (pushed downward)
                    doc.text(`Teacher: ${teacherName}`, 15, 34);
                    doc.text(`Email: ${teacherEmail}`, 15, 41);

                    // Collect Table Columns
                    const headerCells = thead.querySelectorAll('th');
                    const headerRow = [];
                    const visibleIndices = [];

                    headerCells.forEach((th, index) => {
                        const isActions = th.textContent.trim().toLowerCase() === 'actions';
                        const hasText = th.textContent.trim().length > 0;

                        if (th.style.display !== 'none' && !isActions && hasText) {
                            headerRow.push(th.textContent.trim());
                            visibleIndices.push(index);
                        }
                    });

                    // Collect Rows
                    const rows = tbody.querySelectorAll('tr');
                    const body = [];
                    rows.forEach(row => {
                        const cells = row.querySelectorAll('td');
                        const rowData = [];
                        visibleIndices.forEach(index => {
                            if (cells[index]) {
                                rowData.push(cells[index].textContent.trim());
                            }
                        });
                        if (rowData.length > 0) body.push(rowData);
                    });

                    // AutoTable
                    doc.autoTable({
                        startY: 50,
                        head: [headerRow],
                        body: body,
                        styles: { fontSize: 8 },
                        headStyles: { fillColor: [41, 128, 185], textColor: 255 },
                        alternateRowStyles: { fillColor: [245, 245, 245] },
                        margin: { top: 50 }
                    });

                    const finalY = doc.lastAutoTable.finalY || 50;

                    // Summary Section
                    doc.setFontSize(11);
                    doc.setFont('helvetica', 'bold');

                    doc.setDrawColor(41, 128, 185);
                    doc.setLineWidth(0.8);
                    doc.line(15, finalY + 12, 195, finalY + 12);

                    doc.text("Summary", 15, finalY + 20);

                    doc.setFontSize(9);
                    doc.setFont('helvetica', 'normal');

                    doc.text(`Total Earned:`, 15, finalY + 28);
                    doc.setFont('helvetica', 'bold');
                    doc.text(`${totalEarned}`, 60, finalY + 28);

                    doc.setFont('helvetica', 'normal');
                    doc.text(`Paid Before:`, 15, finalY + 36);
                    doc.setFont('helvetica', 'bold');
                    doc.text(`${paidBefore}`, 60, finalY + 36);

                    doc.setFont('helvetica', 'normal');
                    doc.text(`Current Balance:`, 15, finalY + 44);
                    doc.setFont('helvetica', 'bold');
                    doc.text(`${currentBalance}`, 60, finalY + 44);

                    // Line under summary
                    doc.setDrawColor(41, 128, 185);
                    doc.setLineWidth(0.8);
                    doc.line(15, finalY + 54, 195, finalY + 54);

                    // Signatures (kept same)
                    const pageWidth = doc.internal.pageSize.getWidth();
                    const signatureY = finalY + 100;

                    doc.text("________________________", pageWidth * 0.2, signatureY);
                    doc.text("Teacher Signature", pageWidth * 0.2, signatureY + 7);

                    doc.text("________________________", pageWidth * 0.65, signatureY);
                    doc.text("Platform Signature", pageWidth * 0.65, signatureY + 7);

                    // Save PDF
                    doc.save(`teacher-report-${teacherName.replace(/\s+/g, '-')}-${new Date().getTime()}.pdf`);
                    toastr.success('PDF exported successfully');

                } catch (error) {
                    console.error('PDF export error:', error);
                    toastr.error('Error generating PDF');
                }
            }
        };


        // ================= Excel Export =================
        window.exportExcel = function() {
            try {
                const teacherId = document.getElementById('transaction_teacher_id')?.value ||
                    document.getElementById('teacherSelect')?.value;

                if (!teacherId) {
                    toastr.error('Select a teacher first');
                    console.warn('No teacher selected');
                    return;
                }

                const tbody = document.getElementById('transactionsTableBody');
                if (!tbody) {
                    toastr.error("Transactions table not found");
                    console.warn('Table with ID "transactionsTableBody" not found');
                    return;
                }

                if (tbody.querySelectorAll('tr').length === 0) {
                    toastr.error("No transactions to export");
                    return;
                }

                if (typeof XLSX === 'undefined') {
                    toastr.error('Excel library not loaded');
                    console.error('XLSX library not available');
                    return;
                }

                const thead = document.getElementById('transactionsThead');
                if (!thead) {
                    toastr.error("Table header not found");
                    return;
                }

                // Get visible columns from table
                const originalHeaderCells = thead.querySelectorAll('th');
                const visibleColumns = [];
                const visibleIndices = [];
                
                originalHeaderCells.forEach((th, index) => {
                    const isActions = th.textContent.trim().toLowerCase() === 'actions';
                    const hasText = th.textContent.trim().length > 0;
                    
                    if (th.style.display !== 'none' && !isActions && hasText) {
                        visibleColumns.push(th.textContent.trim());
                        visibleIndices.push(index);
                    }
                });

                // Extract data from table rows
                const originalRows = tbody.querySelectorAll('tr');
                const exportData = [];
                
                originalRows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    const rowData = {};
                    
                    visibleIndices.forEach((colIndex, i) => {
                        if (cells[colIndex]) {
                            rowData[visibleColumns[i]] = cells[colIndex].textContent.trim();
                        }
                    });
                    
                    if (Object.keys(rowData).length > 0) {
                        exportData.push(rowData);
                    }
                });

                // Create worksheet from JSON
                const worksheet = XLSX.utils.json_to_sheet(exportData);
                
                // Auto-width for columns
                worksheet['!cols'] = visibleColumns.map(() => ({ wch: 20 }));

                // Create workbook and add worksheet
                const workbook = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(workbook, worksheet, "Transactions");

                const teacherName = document.getElementById('teacher_name')?.textContent || 'Teacher';
                const fileName = `transactions-${teacherName.replace(/\s+/g, '-')}-${new Date().getTime()}.xlsx`;

                XLSX.writeFile(workbook, fileName);
                toastr.success('Excel exported successfully');

            } catch (error) {
                console.error("Excel Export Error:", error);
                toastr.error('Error exporting to Excel: ' + error.message);
            }
        };

        // ================= Column Selector =================
        window.toggleColumnSelector = function() {
            window.showColumnModal();
        };

        window.showColumnModal = function() {
            try {
                const thead = document.getElementById('transactionsThead');
                if (!thead) {
                    toastr.error('Table header not found');
                    return;
                }

                const headerCells = thead.querySelectorAll('th');
                if (headerCells.length === 0) {
                    toastr.error('No columns found');
                    return;
                }

                const existingModal = document.getElementById('columnModalOverlay');
                if (existingModal) existingModal.remove();

                const backdrop = document.createElement('div');
                backdrop.id = 'columnModalOverlay';
                backdrop.style.cssText = `
                position: fixed; top: 0; left: 0; right: 0; bottom: 0;
                background: rgba(0,0,0,0.5); display: flex;
                justify-content: center; align-items: center; z-index: 9998;
            `;

                const modal = document.createElement('div');
                modal.style.cssText = `
                background: white; border-radius: 8px; padding: 25px;
                max-width: 400px; width: 90%; box-shadow: 0 5px 25px rgba(0,0,0,0.3);
                z-index: 9999; max-height: 70vh; overflow-y: auto;
            `;

                const title = document.createElement('h3');
                title.textContent = 'Toggle Column Visibility';
                title.style.cssText = `
                margin: 0 0 15px 0; font-size: 18px; color: #333;
                border-bottom: 2px solid #2980b9; padding-bottom: 10px;
            `;
                modal.appendChild(title);

                headerCells.forEach((th, idx) => {
                    // Skip columns without text (like checkbox) and Actions column
                    const hasText = th.textContent.trim().length > 0;
                    const isActions = th.textContent.trim().toLowerCase() === 'actions';
                    
                    if (!hasText || isActions) return;

                    const isVisible = th.style.display !== 'none';
                    const label = document.createElement('label');
                    label.style.cssText =
                        `display: flex; align-items: center; margin: 10px 0; cursor: pointer; user-select: none;`;

                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.checked = isVisible;
                    checkbox.style.cssText = `margin-right: 10px; width: 18px; height: 18px; cursor: pointer;`;
                    checkbox.onchange = function() {
                        window.toggleColumn(idx);
                    };

                    const labelText = document.createElement('span');
                    labelText.textContent = th.textContent.trim();
                    labelText.style.cssText = `font-size: 14px; color: #333;`;

                    label.appendChild(checkbox);
                    label.appendChild(labelText);
                    modal.appendChild(label);
                });

                const buttonContainer = document.createElement('div');
                buttonContainer.style.cssText =
                    `display:flex; gap:10px; margin-top:20px; padding-top:15px; border-top:1px solid #eee; justify-content:flex-end;`;

                const closeBtn = document.createElement('button');
                closeBtn.textContent = 'Close';
                closeBtn.style.cssText =
                    `padding:8px 15px; background:#95a5a6; color:white; border:none; border-radius:4px; cursor:pointer; font-size:14px;`;
                closeBtn.onclick = function() {
                    backdrop.remove();
                    toastr.success('Columns updated');
                };

                const resetBtn = document.createElement('button');
                resetBtn.textContent = 'Show All';
                resetBtn.style.cssText =
                    `padding:8px 15px; background:#27ae60; color:white; border:none; border-radius:4px; cursor:pointer; font-size:14px;`;
                resetBtn.onclick = function() {
                    headerCells.forEach((th, idx) => {
                        th.style.display = '';
                        const rows = tbody.querySelectorAll('tr');
                        rows.forEach(row => {
                            const cells = row.querySelectorAll('td');
                            if (cells[idx]) cells[idx].style.display = '';
                        });
                    });
                };

                buttonContainer.appendChild(resetBtn);
                buttonContainer.appendChild(closeBtn);
                modal.appendChild(buttonContainer);
                backdrop.appendChild(modal);
                document.body.appendChild(backdrop);

                backdrop.addEventListener('click', function(e) {
                    if (e.target === backdrop) backdrop.remove();
                });

            } catch (error) {
                console.error("Column modal error:", error);
                toastr.error('Error opening column selector');
            }
        };

        window.toggleColumn = function(colIdx) {
            try {
                const thead = document.getElementById('transactionsThead');
                const tbody = document.getElementById('transactionsTableBody');
                if (!thead || !tbody) {
                    console.error('Table elements not found');
                    return;
                }

                const headerCells = thead.querySelectorAll('th');
                const header = headerCells[colIdx];
                if (!header) {
                    console.error('Header cell not found');
                    return;
                }

                header.style.display = header.style.display === 'none' ? '' : 'none';
                const rows = tbody.querySelectorAll('tr');
                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    if (cells[colIdx]) cells[colIdx].style.display = cells[colIdx].style.display === 'none' ?
                        '' : 'none';
                });

            } catch (error) {
                console.error("Column toggle error:", error);
                toastr.error('Error toggling column');
            }
        };

        // ================= Course Details PDF Export =================
        window.exportCourseDetailsPDF = function() {
            const modalBody = document.getElementById('courseDetailsTableBody');
            const modalTitle = document.getElementById('courseDetailsModalLabel');

            if (!modalBody || modalBody.querySelectorAll('tr').length === 0) {
                toastr.error('No transactions to export');
                return;
            }

            if (typeof jspdf === 'undefined') {
                toastr.error('PDF libraries not loaded');
                return;
            }

            const img = new Image();
            img.src = '{{ asset('assets/logo_pic/vteach_logo.jpg') }}';
            img.crossOrigin = "anonymous";

            img.onload = function() {
                generateCourseDetailsPDF(img, true);
            };

            img.onerror = function() {
                console.warn('Logo could not be loaded, PDF will be generated without it.');
                generateCourseDetailsPDF(null, false);
            };

            function generateCourseDetailsPDF(imgElement, hasLogo) {
                try {
                    const {
                        jsPDF
                    } = window.jspdf;
                    const doc = new jsPDF();

                    const title = modalTitle?.textContent || 'Course Transaction Details';
                    const teacherName = document.getElementById('teacher_name')?.textContent || 'Teacher';

                    if (hasLogo && imgElement) {
                        const canvas = document.createElement('canvas');
                        canvas.width = imgElement.width;
                        canvas.height = imgElement.height;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(imgElement, 0, 0);
                        const imgData = canvas.toDataURL('image/jpeg');

                        const pageWidth = doc.internal.pageSize.getWidth();
                        doc.addImage(imgData, 'JPEG', pageWidth - 32, 10, 20, 20);
                    }

                    doc.setFontSize(14);
                    doc.setFont('helvetica', 'bold');
                    doc.text(title, 15, 20);

                    doc.setFontSize(10);
                    doc.setFont('helvetica', 'normal');
                    doc.text(`Teacher: ${teacherName}`, 15, 30);

                    // Get table headers
                    const thead = document.querySelector('#courseDetailsModal thead');
                    const headerCells = thead?.querySelectorAll('th') || [];
                    const headerRow = [];
                    
                    headerCells.forEach((th) => {
                        headerRow.push(th.textContent.trim());
                    });

                    // Get table data
                    const rows = modalBody.querySelectorAll('tr');
                    const body = [];
                    rows.forEach(row => {
                        const cells = row.querySelectorAll('td');
                        const rowData = [];
                        cells.forEach((cell) => {
                            rowData.push(cell.textContent.trim());
                        });
                        if (rowData.length > 0 && rowData.length === headerRow.length) {
                            body.push(rowData);
                        }
                    });

                    doc.autoTable({
                        startY: 40,
                        head: [headerRow],
                        body: body,
                        styles: {
                            fontSize: 8
                        },
                        headStyles: {
                            fillColor: [41, 128, 185],
                            textColor: 255
                        },
                        alternateRowStyles: {
                            fillColor: [245, 245, 245]
                        }
                    });

                    const fileName = `${title.replace(/\s+/g, '-')}-${new Date().getTime()}.pdf`;
                    doc.save(fileName);
                    toastr.success('PDF exported successfully');

                } catch (error) {
                    console.error('PDF export error:', error);
                    toastr.error('Error generating PDF');
                }
            }
        };

        // ================= Course Details Excel Export =================
        window.exportCourseDetailsExcel = function() {
            try {
                const modalBody = document.getElementById('courseDetailsTableBody');
                const modalTitle = document.getElementById('courseDetailsModalLabel');

                if (!modalBody || modalBody.querySelectorAll('tr').length === 0) {
                    toastr.error('No transactions to export');
                    return;
                }

                if (typeof XLSX === 'undefined') {
                    toastr.error('Excel library not loaded');
                    console.error('XLSX library not available');
                    return;
                }

                const title = modalTitle?.textContent || 'Course Transaction Details';

                // Get table headers
                const thead = document.querySelector('#courseDetailsModal thead');
                const headerCells = thead?.querySelectorAll('th') || [];
                const headers = [];
                
                headerCells.forEach((th) => {
                    headers.push(th.textContent.trim());
                });

                // Get table data
                const rows = modalBody.querySelectorAll('tr');
                const exportData = [];
                
                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    const rowData = {};
                    
                    cells.forEach((cell, index) => {
                        if (headers[index]) {
                            rowData[headers[index]] = cell.textContent.trim();
                        }
                    });
                    
                    if (Object.keys(rowData).length > 0) {
                        exportData.push(rowData);
                    }
                });

                if (exportData.length === 0) {
                    toastr.error('No data to export');
                    return;
                }

                // Create worksheet from JSON
                const worksheet = XLSX.utils.json_to_sheet(exportData);
                
                // Auto-width for columns
                worksheet['!cols'] = headers.map(() => ({ wch: 20 }));

                // Create workbook and add worksheet
                const workbook = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(workbook, worksheet, "Course Transactions");

                const fileName = `${title.replace(/\s+/g, '-')}-${new Date().getTime()}.xlsx`;

                XLSX.writeFile(workbook, fileName);
                toastr.success('Excel exported successfully');

            } catch (error) {
                console.error("Excel Export Error:", error);
                toastr.error('Error exporting to Excel: ' + error.message);
            }
        };

</script>



{{-- This is the script of payout pdf and excel --}}


{{-- <script>
    $(document).ready(function() {

            // ---------------------------
            // GLOBAL STATE
            // ---------------------------
            window.payoutTableState = {
                allData: [],
                currentTableData: [],
                columns: ['date_time', 'teacher_name', 'course_name', 'session_name', 'student_name',
                    'parent_name', 'paid', 'remarks', 'type', 'actions'
                ],
                hiddenColumns: []
            };

            const $payoutsTableBody = $('#payoutsTableBody');
            const $selectYear = $('#SelectYear');
            const $columnsForm = $('#payoutColumnCheckboxes');

            // Helper
            function cleanCurrencyText(value) {
                return value ? String(value).replace(/\s+/g, ' ').trim() : '-';
            }

            // Render table
            function renderTable(data) {
                $payoutsTableBody.empty();
                if (!data.length) {
                    $payoutsTableBody.html('<tr><td colspan="10" class="text-center">No payouts found.</td></tr>');
                    return;
                }
                data.forEach(row => {
                    let html = '';
                    window.payoutTableState.columns.forEach(col => {
                        if (col === 'student_name' || col === 'parent_name' || col === 'type') return;
                        let hidden = window.payoutTableState.hiddenColumns.includes(col) ?
                            'd-none' : '';
                        let val = row[col] ?? '-';
                        if (col === 'actions') {
                            html += `<td class="${hidden}" data-col="${col}">
                                <button class="btn btn-sm btn-outline-danger delete-payout-btn" data-id="${row.id}">Delete</button>
                            </td>`;
                        } else {
                            html += `<td class="${hidden}" data-col="${col}">${val}</td>`;
                        }
                    });
                    $payoutsTableBody.append(`<tr>${html}</tr>`);
                });
            }

            // Render column toggle form
            function renderColumnsForm() {
                const labels = {
                    date_time: 'Date & Time',
                    teacher_name: 'Teacher Name',
                    course_name: 'Course Name',
                    session_name: 'Session',
                    paid: 'Paid Amount',
                    remarks: 'Remarks',
                    type: 'Type'
                };
                $columnsForm.empty();
                window.payoutTableState.columns.forEach(col => {
                    if (col === 'actions' || col === 'student_name' || col === 'parent_name' || col === 'type') return;
                    let checked = !window.payoutTableState.hiddenColumns.includes(col);
                    $columnsForm.append(`
                <div class="form-check">
                    <input type="checkbox" class="form-check-input payout-column-toggle" id="col_${col}" data-col="${col}" ${checked?'checked':''}>
                    <label class="form-check-label" for="col_${col}">${labels[col]??col}</label>
                </div>
            `);
                });
            }

            function applyColumnVisibility() {
                $("#payoutsTable tr").each(function() {
                    $(this).find("td,th").each(function() {
                        let col = $(this).data("col");
                        if (!col) return;
                        $(this).toggle(!window.payoutTableState.hiddenColumns.includes(col));
                    });
                });
            }

            // Fetch payout data
            function fetchPayoutsData() {
                let year = $selectYear.val() || '';
                $payoutsTableBody.html('<tr><td colspan="10" class="text-center">Loading...</td></tr>');

                // Get selected currency
                let currencyId = $('#currencySelect').val() || '';
                
                let routeUrl = "/teacher/payouts/" + year;
                
                // Add currency_id as query parameter if available
                if (currencyId) {
                    routeUrl += "?currency_id=" + currencyId;
                }

                // Debug logging
                console.log('=== Fetching Payouts (First Instance) ===');
                console.log('Year/Session:', year);
                console.log('Currency ID:', currencyId);
                console.log('Request URL:', routeUrl);

                $.ajax({
                    url: routeUrl,
                    type: 'GET',
                    success: function(res) {
                        if (!res.success || !Array.isArray(res.payments) || !res.payments.length) {
                            $payoutsTableBody.html(
                                '<tr><td colspan="10" class="text-center">No payouts found.</td></tr>'
                            );
                            window.payoutTableState.allData = [];
                            window.payoutTableState.currentTableData = [];
                            return;
                        }

                        let formatted = res.payments.map(p => ({
                            id: p.id,
                            date_time: p.date_time ?? '-',
                            teacher_name: p.teacher_name ?? '-',
                            course_name: p.course_name ?? '-',
                            session_name: p.session_name ?? '-',
                            student_name: p.student_name ?? '-',
                            parent_name: p.parent_name ?? '-',
                            paid: `${parseFloat(p.paid_amount).toFixed(2)} (${p.currency_name})`,
                            remarks: p.remarks ?? '-',
                            type: "Teacher"
                        }));

                        window.payoutTableState.allData = formatted;
                        window.payoutTableState.currentTableData = formatted;

                        renderTable(formatted);
                        renderColumnsForm();
                        applyColumnVisibility();
                    },
                    error: function() {
                        $payoutsTableBody.html(
                            '<tr><td colspan="10" class="text-center text-danger">Failed to load data</td></tr>'
                        );
                    }
                });
            }

            // ---------------------------
            // SEARCH
            // ---------------------------
            $('#payoutsSearchInput').on('input', function() {
                let term = $(this).val().toLowerCase();
                let filtered = window.payoutTableState.allData.filter(row =>
                    Object.values(row).some(v => String(v).toLowerCase().includes(term))
                );
                window.payoutTableState.currentTableData = filtered;
                renderTable(filtered);
                applyColumnVisibility();
            });

            // ---------------------------
            // COLUMN TOGGLE
            // ---------------------------
            $(document).on('change', '.payout-column-toggle', function() {
                const col = $(this).data('col');
                const visible = $(this).is(':checked');
                if (visible) {
                    window.payoutTableState.hiddenColumns = window.payoutTableState.hiddenColumns.filter(
                        c => c !== col);
                } else {
                    if (!window.payoutTableState.hiddenColumns.includes(col)) {
                        window.payoutTableState.hiddenColumns.push(col);
                    }
                }
                applyColumnVisibility();
            });

            // ✅ FIX: Use the actual function name that exists
            window.showPayoutColumnModal = function() {
                // Call the togglePayoutColumns function defined at line 2615
                togglePayoutColumns();
            }
            
            // Keep old name for backwards compatibility
            window.togglePayoutColumns = window.showPayoutColumnModal;

            // ---------------------------
            // EXPORT EXCEL
            // ---------------------------
            window.exportPayoutExcel = function() {
                if (typeof XLSX === 'undefined') {
                    alert("Excel library (XLSX) is not loaded.");
                    console.error("XLSX library missing");
                    return;
                }

                let visibleCols = window.payoutTableState.columns.filter(c =>
                    !window.payoutTableState.hiddenColumns.includes(c) && c !== 'actions' &&
                    c !== 'student_name' && c !== 'parent_name'
                );

                if (!visibleCols.length) {
                    alert("No columns selected!");
                    return;
                }

                try {
                    let exportData = window.payoutTableState.currentTableData.map(row => {
                        let obj = {};
                        visibleCols.forEach(c => obj[c] = row[c] || '');
                        return obj;
                    });

                    const columnLabels = {
                        date_time: 'Date & Time',
                        teacher_name: 'Teacher Name',
                        course_name: 'Course Name',
                        session_name: 'Session',
                        paid: 'Paid Amount',
                        remarks: 'Remarks',
                        type: 'Type'
                    };

                    let formattedData = exportData.map(row => {
                        let obj = {};
                        visibleCols.forEach(c => {
                            obj[columnLabels[c] || c] = row[c] || '';
                        });
                        return obj;
                    });

                    let ws = XLSX.utils.json_to_sheet(formattedData);

                    const colWidths = {
                        'Date & Time': 20,
                        'Teacher Name': 22,
                        'Course Name': 24,
                        'Session': 18,
                        'Paid Amount': 18,
                        'Remarks': 25,
                        'Type': 12
                    };
                    ws['!cols'] = visibleCols.map(c => ({
                        wch: colWidths[columnLabels[c] || c] || 15
                    }));

                    let wb = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(wb, ws, "Payouts");
                    XLSX.writeFile(wb, `payouts-${new Date().toISOString().split('T')[0]}.xlsx`);
                    console.log("Excel export successful");
                } catch (error) {
                    console.error("Excel export error:", error);
                    alert("Error exporting to Excel: " + error.message);
                }
            };

            // ---------------------------
            // EXPORT PDF
            // ---------------------------
            window.exportPayoutPDF = function() {
                if (typeof window.jspdf === 'undefined' || typeof window.jspdf.jsPDF === 'undefined') {
                    alert("PDF library (jsPDF) is not loaded.");
                    console.error("jsPDF library missing");
                    return;
                }

                let visibleCols = window.payoutTableState.columns.filter(c =>
                    !window.payoutTableState.hiddenColumns.includes(c) && c !== 'actions' &&
                    c !== 'student_name' && c !== 'parent_name'
                );

                if (!visibleCols.length) {
                    alert("No columns selected!");
                    return;
                }

                try {
                    const img = new Image();
                    img.src = '{{ asset('assets/logo_pic/vteach_logo.jpg') }}';
                    img.crossOrigin = "anonymous";

                    img.onload = function() {
                        generatePayoutPDF(img, true);
                    };
                    img.onerror = function() {
                        console.warn('Logo not loaded');
                        generatePayoutPDF(null, false);
                    };

                    function generatePayoutPDF(imgElement, hasLogo) {
                        const {
                            jsPDF
                        } = window.jspdf;
                        const columnLabels = {
                            date_time: 'Date & Time',
                            teacher_name: 'Teacher Name',
                            course_name: 'Course Name',
                            session_name: 'Session',
                            paid: 'Paid Amount',
                            remarks: 'Remarks',
                            type: 'Type'
                        };

                        const body = window.payoutTableState.currentTableData.map(row =>
                            visibleCols.map(c => row[c] || '-')
                        );

                        if (!body.length) {
                            alert("No data to export!");
                            return;
                        }

                        const doc = new jsPDF('landscape', 'mm', 'a4');
                        const pageWidth = doc.internal.pageSize.getWidth();

                        if (hasLogo && imgElement) {
                            const canvas = document.createElement('canvas');
                            canvas.width = imgElement.width;
                            canvas.height = imgElement.height;
                            const ctx = canvas.getContext('2d');
                            ctx.drawImage(imgElement, 0, 0);
                            const imgData = canvas.toDataURL('image/jpeg');
                            doc.addImage(imgData, 'JPEG', pageWidth - 32, 10, 20, 20);
                        }

                        doc.setFontSize(14);
                        doc.setFont('helvetica', 'bold');
                        doc.text('Teacher Payouts Report', 15, 20);

                        doc.setFontSize(10);
                        doc.setFont('helvetica', 'normal');
                        doc.text(`Generated Time: ${new Date().toLocaleString()}`, 15, 27);

                        doc.autoTable({
                            head: [visibleCols.map(c => columnLabels[c] || c.replace(/_/g, ' '))],
                            body: body,
                            startY: 35,
                            styles: {
                                fontSize: 9,
                                cellPadding: 4,
                                lineColor: [200, 200, 200],
                                lineWidth: 0.5
                            },
                            headStyles: {
                                fillColor: [41, 128, 185],
                                textColor: 255,
                                fontStyle: 'bold',
                                lineColor: [41, 128, 185],
                                lineWidth: 1
                            },
                            bodyStyles: {
                                lineColor: [200, 200, 200],
                                lineWidth: 0.5
                            },
                            alternateRowStyles: {
                                fillColor: [255, 255, 255]
                            },
                            columnStyles: {
                                2: {
                                    halign: 'right'
                                }
                            }
                        });

                        const finalY = doc.lastAutoTable.finalY || 35;
                        doc.setFontSize(11);
                        doc.setFont('helvetica', 'bold');
                        doc.setDrawColor(41, 128, 185);
                        doc.setLineWidth(0.8);
                        doc.line(15, finalY + 12, pageWidth - 15, finalY + 12);
                        doc.text("Summary", 15, finalY + 20);

                        let totalPaid = 0;
                        window.payoutTableState.currentTableData.forEach(row => {
                            let amount = parseFloat(row.paid.replace(/[^\d.-]/g, '')) || 0;
                            totalPaid += amount;
                        });

                        doc.setFontSize(10);
                        doc.setFont('helvetica', 'normal');
                        doc.text(`Total Payouts:`, 15, finalY + 28);
                        doc.setFont('helvetica', 'bold');
                        doc.text(`${window.payoutTableState.currentTableData.length}`, 60, finalY + 28);
                        doc.setFont('helvetica', 'normal');
                        doc.text(`Total Amount:`, 15, finalY + 36);
                        doc.setFont('helvetica', 'bold');
                        doc.text(`${totalPaid.toFixed(2)}`, 60, finalY + 36);

                        doc.setDrawColor(41, 128, 185);
                        doc.setLineWidth(0.8);
                        doc.line(15, finalY + 42, pageWidth - 15, finalY + 42);

                        const signatureY = finalY + 52;
                        doc.setFontSize(10);
                        doc.setFont('helvetica', 'normal');
                        doc.text("________________________", pageWidth * 0.25, signatureY, {
                            align: 'center'
                        });
                        doc.text("Teacher Signature", pageWidth * 0.25, signatureY + 7, {
                            align: 'center'
                        });
                        doc.text("________________________", pageWidth * 0.75, signatureY, {
                            align: 'center'
                        });
                        doc.text("Platform Signature", pageWidth * 0.75, signatureY + 7, {
                            align: 'center'
                        });

                        doc.save(`payouts-${new Date().toISOString().split('T')[0]}.pdf`);
                        console.log("PDF export successful");
                    }
                } catch (error) {
                    console.error("PDF export error:", error);
                    alert("Error exporting to PDF: " + error.message);
                }
            };



            // ---------------------------
            // INITIAL LOAD
            // ---------------------------
            if ($selectYear.val() === null) $selectYear.append(`<option value="2025" selected>2025</option>`);
            fetchPayoutsData();
            $selectYear.on('change', fetchPayoutsData);

            // ---------------------------
            // ADD NEW PAYOUT DYNAMICALLY
            // ---------------------------
            window.addNewPayoutToTable = function(newPayout) {
                const formatted = {
                    id: newPayout.id,
                    date_time: newPayout.date_time ?? '-',
                    teacher_name: newPayout.teacher_name ?? '-',
                    course_name: newPayout.course_name ?? '-',
                    session_name: newPayout.session_name ?? '-',
                    student_name: newPayout.student_name ?? '-',
                    parent_name: newPayout.parent_name ?? '-',
                    paid: `${parseFloat(newPayout.paid_amount).toFixed(2)} (${newPayout.currency_name})`,
                    remarks: newPayout.remarks ?? '-',
                    type: "Teacher"
                };

                window.payoutTableState.allData.push(formatted);
                window.payoutTableState.currentTableData.push(formatted);

                let html = '';
                window.payoutTableState.columns.forEach(col => {
                    let hidden = window.payoutTableState.hiddenColumns.includes(col) ? 'd-none' : '';
                    let val = formatted[col] ?? '-';
                    if (col === 'actions') {
                        html += `<td class="${hidden}" data-col="${col}">
                            <button class="btn btn-sm btn-outline-danger delete-payout-btn" data-id="${formatted.id}">Delete</button>
                        </td>`;
                    } else {
                        html += `<td class="${hidden}" data-col="${col}">${val}</td>`;
                    }
                });
                $('#payoutsTableBody').append(`<tr>${html}</tr>`);
                applyColumnVisibility();
            };

        });
</script> --}}
<script>
    $(document).ready(function() {

    // ---------------------------
    // GLOBAL STATE
    // ---------------------------
    window.payoutTableState = {
        allData: [],
        currentTableData: [],
        columns: ['date_time', 'teacher_name', 'course_name', 'session_name',  'paid', 'remarks', 'actions'
        ],
        hiddenColumns: []
    };

    const $payoutsTableBody = $('#payoutsTableBody');
    const $selectYear = $('#SelectYear');

    // Helper
    function cleanCurrencyText(value) {
        return value ? String(value).replace(/\s+/g, ' ').trim() : '-';
    }

    // Render table with proper column visibility
    function renderTable(data) {
        $payoutsTableBody.empty();
        if (!data.length) {
            $payoutsTableBody.html('<tr><td colspan="10" class="text-center">No payouts found.</td></tr>');
            return;
        }
        data.forEach(row => {
            let html = '';
            window.payoutTableState.columns.forEach((col, index) => {
                let hidden = window.payoutTableState.hiddenColumns.includes(col) ? 'none' : '';
                let val = row[col] ?? '-';
                if (col === 'actions') {
                    html += `<td class="text-end" style="display: ${hidden};" data-col="${col}" data-col-index="${index}">
                        <button class="btn btn-sm btn-outline-danger delete-payout-btn" data-id="${row.id}">Delete</button>
                    </td>`;
                } else {
                    html += `<td style="display: ${hidden};" data-col="${col}" data-col-index="${index}">${val}</td>`;
                }
            });
            $payoutsTableBody.append(`<tr>${html}</tr>`);
        });
    }

    // Apply column visibility to both header and body
    function applyColumnVisibility() {
        console.log('=== applyColumnVisibility called ===');
        console.log('Hidden columns:', window.payoutTableState.hiddenColumns);
        
        const thead = document.querySelector('#payoutsTable thead');
        const tbody = document.getElementById('payoutsTableBody');

        if (!thead || !tbody) {
            console.error('Table elements not found');
            return;
        }
        
        console.log('Table found. Processing...');

        // Apply to table header
        const headerCells = thead.querySelectorAll('th');
        console.log(`Found ${headerCells.length} header cells`);
        
        headerCells.forEach((th) => {
            const col = th.getAttribute('data-col');
            if (!col) return;

            if (window.payoutTableState.hiddenColumns.includes(col)) {
                th.style.display = 'none';
                console.log(`  Header ${col}: HIDDEN`);
            } else {
                th.style.display = '';
                console.log(`  Header ${col}: VISIBLE`);
            }
        });

        // ✅ CRITICAL FIX: Add data-col attributes to cells that don't have them
        const columns = window.payoutTableState.columns; // ['date_time', 'teacher_name', 'course_name', ...]
        
        // Apply to table body
        const rows = tbody.querySelectorAll('tr');
        console.log(`Found ${rows.length} table rows`);
        
        let totalCells = 0;
        let fixedCells = 0;
        
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            
            // ✅ FIX: Add data-col to cells that are missing it
            cells.forEach((cell, index) => {
                if (!cell.getAttribute('data-col') && columns[index]) {
                    cell.setAttribute('data-col', columns[index]);
                    fixedCells++;
                    console.log(`    Fixed cell ${index}: added data-col="${columns[index]}"`);
                }
            });
            
            // Now apply visibility
            cells.forEach((cell) => {
                const col = cell.getAttribute('data-col');
                if (!col) return;
                
                totalCells++;

                if (window.payoutTableState.hiddenColumns.includes(col)) {
                    cell.style.display = 'none';
                } else {
                    cell.style.display = '';
                }
            });
        });
        
        console.log(`Fixed ${fixedCells} cells without data-col attributes`);
        console.log(`Processed ${totalCells} body cells`);
        console.log('=== applyColumnVisibility complete ===');
    }

    // Fetch payout data - Make it global so it can be called from anywhere
    window.fetchPayoutsData = function() {
        // ✅ CRITICAL FIX: Only hide sub-tabs if the Payouts tab is actually active
        const payoutsDiv = document.getElementById('payoutsDiv');
        if (payoutsDiv && payoutsDiv.style.display !== 'none') {
            const subTabContainer = document.getElementById('subTabContainer');
            if (subTabContainer) {
                subTabContainer.style.setProperty('display', 'none', 'important');
            }
        }
        
        // Look up elements directly to avoid scope issues
        const yearSelect = document.getElementById('SelectYear');
        const currencySelect = document.getElementById('currencySelect');
        const payoutsTableBody = document.getElementById('payoutsTableBody');
        
        if (!yearSelect || !currencySelect || !payoutsTableBody) {
            console.error('Required elements not found:', {
                yearSelect: !!yearSelect,
                currencySelect: !!currencySelect,
                payoutsTableBody: !!payoutsTableBody
            });
            return;
        }
        
        const year = yearSelect.value || '';
        const currencyId = currencySelect.value || '';
        
        console.log('=== Fetching Payouts ===');
        console.log('Year/Session:', year);
        console.log('Currency ID:', currencyId);
        
        payoutsTableBody.innerHTML = '<tr><td colspan="10" class="text-center">Loading...</td></tr>';

        let routeUrl = "/teacher/payouts/" + year;
        
        // Add currency_id as query parameter if available
        if (currencyId) {
            routeUrl += "?currency_id=" + currencyId;
        }

        console.log('Request URL:', routeUrl);
        console.log('========================');

        $.ajax({
            url: routeUrl,
            type: 'GET',
            success: function(res) {
                // Always clear the table first to prevent race conditions
                payoutsTableBody.innerHTML = '';
                
                if (!res.success || !Array.isArray(res.payments) || !res.payments.length) {
                    payoutsTableBody.innerHTML = '<tr><td colspan="10" class="text-center">No payouts found.</td></tr>';
                    window.payoutTableState.allData = [];
                    window.payoutTableState.currentTableData = [];
                    console.log('No payouts found for this currency/session');
                    return;
                }

                console.log('Payouts received:', res.payments.length);
                
                let formatted = res.payments.map(p => ({
                    id: p.id,
                    date_time: p.date_time ?? '-',
                    teacher_name: p.teacher_name ?? '-',
                    course_name: p.course_name ?? '-',
                    session_name: p.session_name ?? '-',

                    paid: `${parseFloat(p.paid_amount).toFixed(2)} (${p.currency_name})`,
                    remarks: p.remarks ?? '-',
                    type: "Teacher"
                }));

                window.payoutTableState.allData = formatted;
                window.payoutTableState.currentTableData = formatted;

                console.log('Formatted payouts:', formatted.length);
                renderTable(formatted);
                applyColumnVisibility();
            },
            error: function() {
                $payoutsTableBody.empty();
                $payoutsTableBody.html(
                    '<tr><td colspan="10" class="text-center text-danger">Failed to load data</td></tr>'
                );
            }
        });
    }

    // ---------------------------
    // SEARCH
    // ---------------------------
    $('#payoutsSearchInput').on('input', function() {
        let term = $(this).val().toLowerCase();
        let filtered = window.payoutTableState.allData.filter(row =>
            Object.values(row).some(v => String(v).toLowerCase().includes(term))
        );
        window.payoutTableState.currentTableData = filtered;
        renderTable(filtered);
        applyColumnVisibility();
    });

    // ---------------------------
    // CURRENCY CHANGE - Refresh data based on active tab
    // ---------------------------
    $('#currencySelect').on('change', function() {
        let selectedCurrency = $(this).val();
        let currencyText = $(this).find('option:selected').text();
        
        console.log('Currency changed to:', selectedCurrency, '-', currencyText);
        
        // Update all currency-related fields to sync with modal
        $('#current_currency').val(selectedCurrency);
        $('#current_currency_name').val(currencyText);
        $('#selected_currency').val(selectedCurrency);
        
        // Update the visible readonly currency field in payout modal and ensure it's aligned properly
        const currencyNameInput = $('#currency_name');
        currencyNameInput.val(currencyText);
        // Force text alignment to start
        currencyNameInput.css('text-align', 'left');
        
        // If there's also a visible currency select in the modal, update it too
        $('#payout_currency_select').val(selectedCurrency);
        
        // Refresh data based on which tab is active
        const transactionsDiv = document.getElementById('transactionsDiv');
        const payoutsDiv = document.getElementById('payoutsDiv');
        const teacherId = $('#teacherSelect').val();
        const sessionId = $('#SelectYear').val();
        
        if (transactionsDiv && transactionsDiv.style.display !== 'none') {
            // On Transactions tab - refresh transactions
            // ✅ USE GLOBAL STATE
            const isPerCourseActive = window.currentTransactionTab === 'percourse';
            
            if (isPerCourseActive && window.fetchPerCourse) {
                window.fetchPerCourse(teacherId, sessionId, selectedCurrency);
            } else if (window.fetchTransactions) {
                window.fetchTransactions(teacherId, sessionId, selectedCurrency);
            }
        } else if (payoutsDiv && payoutsDiv.style.display !== 'none') {
            // On Payouts tab - refresh payouts
            if (window.fetchPayoutsData) {
                window.fetchPayoutsData();
            }
        }
    });

    // ---------------------------
    // PAYOUT MODAL - Sync Currency When Modal Opens
    // ---------------------------
    // Listen for any modal with 'payout' in the ID to open
    $('[id*="payout"]').on('shown.bs.modal', function() {
        const selectedCurrency = $('#currencySelect').val();
        const currencyText = $('#currencySelect option:selected').text();
        
        console.log('Modal opened - syncing currency:', selectedCurrency, currencyText);
        
        // Update all currency fields in the modal
        $('#current_currency').val(selectedCurrency);
        $('#current_currency_name').val(currencyText);
        $('#selected_currency').val(selectedCurrency);
        $('#currency_name').val(currencyText);
    });

    // COLUMN TOGGLE MODAL (Live Update)
    // ---------------------------
    window.togglePayoutColumns = function() {
        try {
            const tbody = document.getElementById('payoutsTableBody');
            if (!tbody) {
                alert('Table body not found');
                return;
            }

            const table = tbody.closest('table');
            if (!table) {
                alert('Table element not found');
                return;
            }

            let thead = table.querySelector('thead');

            // Remove existing modal if present
            const existingModal = document.getElementById('payoutColumnModalOverlay');
            if (existingModal) existingModal.remove();

            // Create modal backdrop
            const backdrop = document.createElement('div');
            backdrop.id = 'payoutColumnModalOverlay';
            backdrop.style.cssText = `
                position: fixed; top: 0; left: 0; right: 0; bottom: 0;
                background: rgba(0,0,0,0.5); display: flex;
                justify-content: center; align-items: center; z-index: 9998;
            `;

            // Create modal
            const modal = document.createElement('div');
            modal.style.cssText = `
                background: white; border-radius: 8px; padding: 25px;
                max-width: 400px; width: 90%; box-shadow: 0 5px 25px rgba(0,0,0,0.3);
                z-index: 9999; max-height: 70vh; overflow-y: auto;
            `;

            // Title
            const title = document.createElement('h3');
            title.textContent = 'Toggle Column Visibility';
            title.style.cssText = `
                margin: 0 0 15px 0; font-size: 18px; color: #333;
                border-bottom: 2px solid #2980b9; padding-bottom: 10px;
            `;
            modal.appendChild(title);

            const columnLabels = {
                date_time: 'Date & Time',
                teacher_name: 'Teacher Name',
                course_name: 'Course Name',
                session_name: 'Session',
                paid: 'Paid Amount',
                remarks: 'Remarks',
                type: 'Type'
            };

            // Create checkboxes for each column (except actions)
            window.payoutTableState.columns.forEach((col, idx) => {
                if (col === 'actions' || col === 'student_name' || col === 'parent_name' || col === 'type') return;

                const isVisible = !window.payoutTableState.hiddenColumns.includes(col);
                const label = columnLabels[col] || col;

                const checkboxDiv = document.createElement('label');
                checkboxDiv.style.cssText = `
                    display: flex; align-items: center; margin: 10px 0;
                    cursor: pointer; user-select: none; padding: 8px;
                    border-bottom: 1px solid #eee;
                `;

                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.id = `payout_col_${col}`;
                checkbox.checked = isVisible;
                checkbox.style.cssText = 'cursor: pointer; width: 18px; height: 18px; margin-right: 10px;';
                checkbox.setAttribute('data-col', col);
                checkbox.setAttribute('data-index', idx);

                // Real-time toggle on checkbox change
                checkbox.onchange = function() {
                    window.togglePayoutColumn(idx);
                };

                const labelText = document.createElement('span');
                labelText.textContent = label;
                labelText.style.cssText = 'font-size: 14px; color: #333;';

                checkboxDiv.appendChild(checkbox);
                checkboxDiv.appendChild(labelText);
                modal.appendChild(checkboxDiv);
            });

            // Button container
            const buttonContainer = document.createElement('div');
            buttonContainer.style.cssText = `
                display: flex; gap: 10px; margin-top: 20px; padding-top: 15px;
                border-top: 1px solid #eee; justify-content: flex-end;
            `;

            // Show All button
            const showAllBtn = document.createElement('button');
            showAllBtn.textContent = 'Show All';
            showAllBtn.style.cssText = `
                padding: 8px 15px; background: #27ae60; color: white;
                border: none; border-radius: 4px; cursor: pointer; font-size: 14px;
            `;
            showAllBtn.onclick = function() {
                // Clear hidden columns
                window.payoutTableState.hiddenColumns = [];

                // Update all checkboxes
                modal.querySelectorAll('input[type="checkbox"]').forEach(cb => {
                    cb.checked = true;
                });

                // Apply visibility
                applyColumnVisibility();
            };

            // Close button
            const closeBtn = document.createElement('button');
            closeBtn.textContent = 'Close';
            closeBtn.style.cssText = `
                padding: 8px 15px; background: #95a5a6; color: white;
                border: none; border-radius: 4px; cursor: pointer; font-size: 14px;
            `;
            closeBtn.onclick = function() {
                backdrop.remove();
            };

            buttonContainer.appendChild(showAllBtn);
            buttonContainer.appendChild(closeBtn);
            modal.appendChild(buttonContainer);
            backdrop.appendChild(modal);
            document.body.appendChild(backdrop);

            // Close on backdrop click
            backdrop.addEventListener('click', function(e) {
                if (e.target === backdrop) {
                    backdrop.remove();
                }
            });

            console.log('Column modal opened successfully');

        } catch (error) {
            console.error('Error opening column modal:', error);
            alert('Error opening column selector: ' + error.message);
        }
    };

    // Toggle individual column (LIVE UPDATE)
    window.togglePayoutColumn = function(colIdx) {
        try {
            const col = window.payoutTableState.columns[colIdx];

            if (!col) {
                console.error('Column not found at index:', colIdx);
                return;
            }

            // Toggle visibility in state
            const isCurrentlyHidden = window.payoutTableState.hiddenColumns.includes(col);

            if (isCurrentlyHidden) {
                // Show column
                window.payoutTableState.hiddenColumns = window.payoutTableState.hiddenColumns.filter(c => c !== col);
            } else {
                // Hide column
                if (!window.payoutTableState.hiddenColumns.includes(col)) {
                    window.payoutTableState.hiddenColumns.push(col);
                }
            }

            // Apply visibility immediately
            applyColumnVisibility();

            console.log('Column toggled:', col, 'Hidden:', !isCurrentlyHidden);
            console.log('Current hidden columns:', window.payoutTableState.hiddenColumns);

        } catch (error) {
            console.error('Column toggle error:', error);
            alert('Error toggling column');
        }
    };

    // ---------------------------
    // EXPORT EXCEL (Uses current column visibility state)
    // ---------------------------
    window.exportPayoutExcel = function() {
        if (typeof XLSX === 'undefined') {
            alert("Excel library (XLSX) is not loaded.");
            return;
        }

        // Get visible columns (exclude hidden and actions)
        let visibleCols = window.payoutTableState.columns.filter(c =>
            !window.payoutTableState.hiddenColumns.includes(c) &&
            c !== 'actions' && c !== 'student_name' && c !== 'parent_name' && c !== 'type'
        );

        if (!visibleCols.length) {
            alert("No columns selected!");
            return;
        }

        try {
            let exportData = window.payoutTableState.currentTableData.map(row => {
                let obj = {};
                visibleCols.forEach(c => obj[c] = row[c] || '');
                return obj;
            });

            const columnLabels = {
                date_time: 'Date & Time',
                teacher_name: 'Teacher Name',
                course_name: 'Course Name',
                session_name: 'Session',
                paid: 'Paid Amount',
                remarks: 'Remarks',
                type: 'Type'
            };

            let formattedData = exportData.map(row => {
                let obj = {};
                visibleCols.forEach(c => {
                    obj[columnLabels[c] || c] = row[c] || '';
                });
                return obj;
            });

            let ws = XLSX.utils.json_to_sheet(formattedData);

            const colWidths = {
                'Date & Time': 20,
                'Teacher Name': 22,
                'Course Name': 24,
                'Session': 18,
                'Paid Amount': 18,
                'Remarks': 25,
                'Type': 12
            };
            ws['!cols'] = visibleCols.map(c => ({
                wch: colWidths[columnLabels[c] || c] || 15
            }));

            let wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Payouts");
            XLSX.writeFile(wb, `payouts-${new Date().toISOString().split('T')[0]}.xlsx`);

            let msg = visibleCols.length === window.payoutTableState.columns.filter(c => c !== 'actions').length
                ? 'Excel exported successfully with all columns'
                : 'Excel exported successfully with ' + visibleCols.length + ' columns';

            toastr.success(msg);
            console.log("Excel export successful with columns:", visibleCols);
        } catch (error) {
            console.error("Excel export error:", error);
            alert("Error exporting to Excel: " + error.message);
        }
    };

    // ---------------------------
    // EXPORT PDF (Uses current column visibility state)
    // ---------------------------
    window.exportPayoutPDF = function() {
        if (typeof window.jspdf === 'undefined' || typeof window.jspdf.jsPDF === 'undefined') {
            alert("PDF library (jsPDF) is not loaded.");
            return;
        }

        // Get visible columns (exclude hidden and actions)
        let visibleCols = window.payoutTableState.columns.filter(c =>
            !window.payoutTableState.hiddenColumns.includes(c) &&
            c !== 'actions' && c !== 'student_name' && c !== 'parent_name' && c !== 'type'
        );

        if (!visibleCols.length) {
            alert("No columns selected!");
            return;
        }

        try {
            const img = new Image();
            img.src = '{{ asset("assets/logo_pic/vteach_logo.jpg") }}';
            img.crossOrigin = "anonymous";

            img.onload = function() {
                generatePayoutPDF(img, true);
            };
            img.onerror = function() {
                console.warn('Logo not loaded');
                generatePayoutPDF(null, false);
            };

            function generatePayoutPDF(imgElement, hasLogo) {
                const { jsPDF } = window.jspdf;
                const columnLabels = {
                    date_time: 'Date & Time',
                    teacher_name: 'Teacher Name',
                    course_name: 'Course Name',
                    session_name: 'Session',
                    paid: 'Paid Amount',
                    remarks: 'Remarks',
                    type: 'Type'
                };

                // Build table body with only visible columns
                const body = window.payoutTableState.currentTableData.map(row =>
                    visibleCols.map(c => row[c] || '-')
                );

                if (!body.length) {
                    alert("No data to export!");
                    return;
                }

                const doc = new jsPDF('landscape', 'mm', 'a4');
                const pageWidth = doc.internal.pageSize.getWidth();

                if (hasLogo && imgElement) {
                    const canvas = document.createElement('canvas');
                    canvas.width = imgElement.width;
                    canvas.height = imgElement.height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(imgElement, 0, 0);
                    const imgData = canvas.toDataURL('image/jpeg');
                    doc.addImage(imgData, 'JPEG', pageWidth - 32, 10, 20, 20);
                }

                doc.setFontSize(14);
                doc.setFont('helvetica', 'bold');
                doc.text('Teacher Payouts Report', 15, 20);

                doc.setFontSize(10);
                doc.setFont('helvetica', 'normal');
                const options = { 
                        year: 'numeric', month: 'short', day: '2-digit', 
                        hour: '2-digit', minute: '2-digit', hour12: true 
                    };
                    const generatedTime = new Date().toLocaleString('en-US', options);
                    doc.text(`Generated Time: ${generatedTime}`, 15, 26);

                doc.autoTable({
                    head: [visibleCols.map(c => columnLabels[c] || c.replace(/_/g, ' '))],
                    body: body,
                    startY: 35,
                    styles: {
                        fontSize: 9,
                        cellPadding: 4,
                        lineColor: [200, 200, 200],
                        lineWidth: 0.5
                    },
                    headStyles: {
                        fillColor: [41, 128, 185],
                        textColor: 255,
                        fontStyle: 'bold',
                        lineColor: [41, 128, 185],
                        lineWidth: 1
                    },
                    bodyStyles: {
                        lineColor: [200, 200, 200],
                        lineWidth: 0.5
                    },
                    alternateRowStyles: {
                        fillColor: [255, 255, 255]
                    }
                });

                const finalY = doc.lastAutoTable.finalY || 35;
                doc.setFontSize(11);
                doc.setFont('helvetica', 'bold');
                doc.setDrawColor(41, 128, 185);
                doc.setLineWidth(0.8);
                doc.line(15, finalY + 12, pageWidth - 15, finalY + 12);
                doc.text("Summary", 15, finalY + 20);

                let totalPaid = 0;
                window.payoutTableState.currentTableData.forEach(row => {
                    let amount = parseFloat(row.paid.replace(/[^\d.-]/g, '')) || 0;
                    totalPaid += amount;
                });

                doc.setFontSize(10);
                doc.setFont('helvetica', 'normal');
                doc.text(`Total Payouts:`, 15, finalY + 28);
                doc.setFont('helvetica', 'bold');
                doc.text(`${window.payoutTableState.currentTableData.length}`, 60, finalY + 28);
                doc.setFont('helvetica', 'normal');
                doc.text(`Total Amount:`, 15, finalY + 36);
                doc.setFont('helvetica', 'bold');
                doc.text(`${totalPaid.toFixed(2)}`, 60, finalY + 36);

                doc.setDrawColor(41, 128, 185);
                doc.setLineWidth(0.8);
                doc.line(15, finalY + 42, pageWidth - 15, finalY + 42);

                const signatureY = finalY + 100;
                doc.setFontSize(10);
                doc.setFont('helvetica', 'normal');
                doc.text("________________________", pageWidth * 0.25, signatureY, { align: 'center' });
                doc.text("Teacher Signature", pageWidth * 0.25, signatureY + 7, { align: 'center' });
                doc.text("________________________", pageWidth * 0.75, signatureY, { align: 'center' });
                doc.text("Platform Signature", pageWidth * 0.75, signatureY + 7, { align: 'center' });

                doc.save(`payouts-${new Date().toISOString().split('T')[0]}.pdf`);

                let msg = visibleCols.length === window.payoutTableState.columns.filter(c => c !== 'actions').length
                    ? 'PDF exported successfully with all columns'
                    : 'PDF exported successfully with ' + visibleCols.length + ' columns';

                toastr.success(msg);
                console.log("PDF export successful with columns:", visibleCols);
                console.log("PDF export successful with columns:", visibleCols);
            }
        } catch (error) {
            console.error("PDF export error:", error);
            alert("Error exporting to PDF: " + error.message);
        }
    };

    // ---------------------------
    // DELETE PAYOUT
    // ---------------------------
    $(document).off('click', '.delete-payout-btn').on('click', '.delete-payout-btn', function(e) {
        e.preventDefault();
        const payoutId = $(this).data('id');
        const row = $(this).closest('tr');
        if (!payoutId) return;
        if (!confirm("Are you sure you want to delete this payout?")) return;

        $.ajax({
            url: `/teacher/payouts/delete/${payoutId}`,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                if (res.success) {
                    window.payoutTableState.allData = window.payoutTableState.allData
                        .filter(p => p.id != payoutId);
                    window.payoutTableState.currentTableData = window.payoutTableState
                        .currentTableData.filter(p => p.id != payoutId);

                    row.fadeOut(300, function() {
                        $(this).remove();
                        if (!$('#payoutsTableBody tr').length) {
                            $payoutsTableBody.html(
                                '<tr><td colspan="10" class="text-center">No payouts found.</td></tr>'
                            );
                        }
                    });
                    
                    // ✅ Refresh all balance statistics immediately after deleting payout
                    const teacherId = $('#teacherSelect').val();
                    const sessionId = $('#SelectYear').val();
                    const currencyId = $('#currencySelect').val();
                    
                    if (teacherId && sessionId && window.fetchTransactions) {
                        // Fetch transactions updates all balance stats (Total Revenue, Paid Before, Current Balance)
                        window.fetchTransactions(teacherId, sessionId, currencyId);
                    }
                    
                    toastr.success("Payout deleted successfully!");
                } else {
                    alert(res.message || "Failed to delete payout");
                }
            },
            error: function(xhr) {
                console.error("Delete error:", xhr);
                alert("Error deleting payout. Please try again.");
            }
        });
    });

    // ---------------------------
    // INITIAL LOAD
    // ---------------------------
    if ($selectYear.val() === null) $selectYear.append(`<option value="2025" selected>2025</option>`);
    fetchPayoutsData();
    // $selectYear.on('change', fetchPayoutsData); // REMOVED DUPLICATE LISTENER

    // ---------------------------
    // ADD NEW PAYOUT DYNAMICALLY
    // ---------------------------
    window.addNewPayoutToTable = function(newPayout) {
        const formatted = {
            id: newPayout.id,
            date_time: newPayout.date_time ?? '-',
            teacher_name: newPayout.teacher_name ?? '-',
            course_name: newPayout.course_name ?? '-',
            session_name: newPayout.session_name ?? '-',
            student_name: newPayout.student_name ?? '-',
            parent_name: newPayout.parent_name ?? '-',
            paid: `${parseFloat(newPayout.paid_amount).toFixed(2)} (${newPayout.currency_name})`,
            remarks: newPayout.remarks ?? '-',
            type: "Teacher"
        };

        window.payoutTableState.allData.push(formatted);
        window.payoutTableState.currentTableData.push(formatted);

        // If this is the first payout, clear the "No payouts found" message
        if (window.payoutTableState.currentTableData.length === 1) {
            $('#payoutsTableBody').empty();
        }

        let html = '';
        window.payoutTableState.columns.forEach(col => {
            let hidden = window.payoutTableState.hiddenColumns.includes(col) ? 'none' : '';
            let val = formatted[col] ?? '-';
            if (col === 'actions') {
                html += `<td style="display: ${hidden};" data-col="${col}">
                    <button class="btn btn-sm btn-outline-danger delete-payout-btn" data-id="${formatted.id}">Delete</button>
                </td>`;
            } else {
                html += `<td style="display: ${hidden};" data-col="${col}">${val}</td>`;
            }
        });
        $('#payoutsTableBody').append(`<tr>${html}</tr>`);
    };

});
</script>

@endsection