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
                        <p class="text-muted small mb-1">Platform Balance </p>
                        <h5 class="fw-bold text-success mb-0" id="platformBalance">
                            {{ $selected_currency?->currency_name }} {{ number_format($platform_balance, 2) }}
                        </h5>
                        <small class="text-muted">Platform revenue</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-wrapper me-3"></div>
                    <div>
                        <p class="text-muted small mb-1">Total Revenue
                        </p>
                        <h5 class="fw-bold text-primary mb-0" id="total_revenue">
                            {{ $selected_currency?->currency_name }} {{ number_format($total_revenue, 2) }}
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
                        <h5 class="fw-bold text-purple mb-0" id="withdrawn_balance">
                            {{ $selected_currency?->currency_name }} {{ number_format($withdrawn_balance, 2) }}
                        </h5>
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

                        <div class="row g-3">
                            <!-- Teacher -->
                            <div class="col-md-6">
                                <label class="form-label">Teacher</label>
                                <select class="form-select" name="teacher_id" id="transaction_teacher">
                                    <option selected disabled>Select Teacher</option>
                                    @foreach ($teacher_datas as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->teacher_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Course -->
                            <div class="col-md-6">
                                <label class="form-label">Course</label>
                                <select class="form-select" name="course" id="transaction_course">
                                    <option selected disabled>Select Course</option>
                                    @foreach ($subject_datas as $course)
                                    <option value="{{ $course->id }}">{{ $course->course_title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Session -->
                            <div class="col-md-6">
                                <label class="form-label">Session</label>
                                <select class="form-select" name="session_id" id="transaction_session">
                                    <option selected disabled>Select Session</option>
                                    @foreach ($session_datas as $session)
                                    <option value="{{ $session->id }}">{{ $session->session_title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Student -->
                            <div class="col-md-6">
                                <label class="form-label">Student</label>
                                <input type="text" class="form-control" name="student_name" id="transaction_student">
                            </div>

                            <!-- Parent -->
                            <div class="col-md-6">
                                <label class="form-label">Parent</label>
                                <input type="text" class="form-control" name="parent_name" id="transaction_parent">
                            </div>

                            <!-- Student Contact -->
                            <div class="col-md-6">
                                <label class="form-label">Student Contact</label>
                                <input type="text" class="form-control" name="student_contact"
                                    id="transaction_student_contact" placeholder="Enter contact number">
                            </div>

                            <!-- Student Email -->
                            <div class="col-md-6">
                                <label class="form-label">Student Email</label>
                                <input type="email" class="form-control" name="student_email"
                                    id="transaction_student_email" placeholder="Enter email address">
                            </div>

                            <!-- Currency -->
                            <div class="col-md-6">
                                <label class="form-label">Currency</label>
                                <input type="text" class="form-control text-start"
                                    value="{{ $selected_currency->currency_name ?? '' }}" name="current_currency"
                                    id="current_currency" readonly>
                                <input type="hidden" name="selected_currency" id="selected_currency_id"
                                    value="{{ $selected_currency->id ?? '' }}">
                            </div>

                            <!-- Course Fee -->
                            <div class="col-md-6">
                                <label class="form-label">Course Fee</label>
                                <input type="number" class="form-control" name="course_fee" id="transaction_course_fee"
                                    step="0.01">
                            </div>

                            <!-- Note Fee -->
                            <div class="col-md-6">
                                <label class="form-label">Note Fee</label>
                                <input type="number" class="form-control" name="note_fee" id="transaction_note_fee"
                                    step="0.01">
                            </div>

                            <!-- Total -->
                            <div class="col-md-6">
                                <label class="form-label">Total</label>
                                <input type="number" class="form-control" name="total" id="transaction_total"
                                    step="0.01">
                            </div>

                            <!-- Paid -->
                            <div class="col-md-6">
                                <label class="form-label">Paid</label>
                                <input type="number" class="form-control" name="paid_amount" id="transaction_paid"
                                    step="0.01">
                            </div>

                            <!-- Remaining -->
                            <div class="col-md-6">
                                <label class="form-label">Remaining</label>
                                <input type="number" class="form-control" name="remaining" id="transaction_remaining"
                                    step="0.01" readonly>
                            </div>
                        </div>

                        <div class="modal-footer border-0 mt-3">
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
            <!-- Date Filter -->
            <div class="input-group mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <input type="date" class="form-control" id="startDate" placeholder="Start Date">
                    </div>
                    <div class="col-md-4">
                        <input type="date" class="form-control" id="endDate" placeholder="End Date">
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-dark" id="filterBtn">
                            <i class="fa-solid fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
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
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Total</th>
                            <th>Platform Share</th>
                            <th>Paid</th>
                            <th>Remaining</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="transactionsTableBody">
                        @forelse($platform_transaction_datas as $transaction)
                        @php
                        // Calculate paid and remaining amounts
                        $paid = $transaction->payments->sum('paid_amount');
                        $remaining = $transaction->total - $paid;
                        $currency_name = $transaction->currency?->currency_name ?? 'USD'; // Default to USD if currency

                        @endphp

                        <tr id="transaction-row-{{ $transaction->id }}">
                            {{-- 1. ID --}}
                            <td>{{ $transaction->id }}</td>

                            {{-- 2. Date/Time (Formatted for Asia/Karachi) --}}
                            <td>
                                {{ \Carbon\Carbon::parse($transaction->created_at)
                                ->setTimezone('Asia/Karachi')
                                ->format('M d, Y, h:i A') }}
                            </td>

                            {{-- 3. Teacher Name --}}
                            <td>{{ $transaction->teacher?->teacher_name ?? 'N/A' }}</td>

                            {{-- 4. Course Title --}}
                            <td>{{ $transaction->course?->course_title ?? 'N/A' }}</td>

                            {{-- 5. Session Title --}}
                            <td>{{ $transaction->session?->session_title ?? 'N/A' }}</td>

                            {{-- 6. Student Name --}}
                            <td>{{ $transaction->student_name }}</td>

                            {{-- 7. Parent Name --}}
                            <td>{{ $transaction->parent_name }}</td>

                            {{-- 8. Student Contact --}}
                            <td>{{ $transaction->student_contact }}</td>

                            {{-- 9. Student Email --}}
                            <td>{{ $transaction->student_email }}</td>

                            {{-- 10. Total Amount --}}
                            <td>{{ number_format($transaction->total, 2) }} ({{ $currency_name }})</td>
                            <td>{{ number_format($transaction->platform_amount, 2) }} ({{ $currency_name }})</td>

                            {{-- 11. Paid Amount --}}
                            <td class="paid-amount">{{ number_format($paid, 2) }} ({{ $currency_name }})</td>

                            {{-- 12. Remaining Amount (Changed from $remaining to $remaining to include $currency_name
                            in both places) --}}
                            <td class="remaining-amount">{{ number_format($remaining, 2) }} ({{ $currency_name }})</td>

                            {{-- 13. Actions (Restore and Delete buttons) --}}
                            <td class="text-end">
                                {{-- Restore Button --}}
                                <button class="btn btn-sm icon-btn restore-btn" data-id="{{ $transaction->id }}"
                                    data-total="{{ $transaction->total }}" data-paid="{{ $paid }}"
                                    data-remaining="{{ $remaining }}">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </button>

                                {{-- Delete Button --}}
                                <button class="btn btn-sm icon-btn text-danger delete-btn"
                                    data-id="{{ $transaction->id }}">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="13" class="text-center">No records found</td>
                        </tr>
                        @endforelse
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
                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                    data-bs-target="#payoutsModal">
                    <i class="fa-solid fa-money-bill-wave me-1"></i> Add Payout
                </button>

                <button class="btn btn-outline-success btn-sm" id="exportPayoutPdf"><i
                        class="fa-solid fa-file-export me-1"></i> Export PDF</button>
                <button class="btn btn-outline-success btn-sm" id="exportPayoutExcel"><i
                        class="fa-solid fa-file-export me-1"></i> Export Excel</button>
                <button class="btn btn-outline-dark btn-sm" id="PayoutColumn" data-bs-toggle="modal"
                    data-bs-target="#columnsModal"><i class="fa-solid fa-table-columns me-1"></i> Columns</button>
            </div>
            <div class="row g-2 mb-3">
                <div class="col-md-1">
                    <label class="form-label">Start Date</label>
                    <input type="date" id="payoutStartDate" class="form-control">
                </div>

                <div class="col-md-1">
                    <label class="form-label">End Date</label>
                    <input type="date" id="payoutEndDate" class="form-control">
                </div>

                <div class="col-md-1 d-flex align-items-end">
                    <button class="btn btn-dark w-100" id="filterPayoutBtn">
                        <i class="fa-solid fa-filter me-1"></i> Filter
                    </button>
                </div>
            </div>



            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light" id="payoutsTableHead">
                        <tr>
                            <th>Date/Time</th>
                            <th>Session</th>
                            <th>Paid</th>
                            <th>Type</th>
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







    <!-- payouts model -->
    <!-- Add Payout Modal -->
    <div class="modal fade" id="payoutsModal" tabindex="-1" aria-labelledby="payoutsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-dark text-white rounded-top-4">
                    <h5 class="modal-title" id="payoutsModalLabel">Add Payout</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="payoutForm">
                        @csrf

                        <!-- Session -->
                        <div class="mb-3">
                            <label class="form-label">Session</label>
                            <select class="form-select" name="session_id" id="session_id" required>
                                <option selected disabled>Select Session</option>
                                @foreach ($session_datas as $session)
                                <option value="{{ $session->id }}">{{ $session->session_title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Currency -->
                        <div class="mb-3">
                            <label class="form-label">Currency</label>
                            <input type="text" class="form-control text-start"
                                value="{{ $selected_currency->currency_name ?? '' }}" name="current_currency"
                                id="current_currency_id_payout" readonly>
                            <input type="hidden" name="selected_currency_id" id="selected_currency_id_payout"
                                value="{{ $selected_currency->id ?? '' }}">
                        </div>

                        <!-- Paid Amount -->
                        <div class="mb-3">
                            <label class="form-label">Paid Amount</label>
                            <input type="number" class="form-control" name="amount" id="amount" step="0.01" required>
                        </div>

                        <!-- Remarks -->
                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="3" required></textarea>
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
                            <th>Total Teacher Share </th>
                            <th>Total Teacher Paid</th>
                            <th>Total Teacher Balance</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="7" class="text-center">Loading...</td>
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
                <input type="text" id="transactionsSearchInput" class="form-control border-start-0"
                    placeholder="Search...">
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

<div class="modal fade" id="courseDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Course Transaction Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student</th>
                            <th>Total</th>
                            <th>Platform Share</th>
                            <th>Paid</th>
                            <th>Remaining</th>
                        </tr>
                    </thead>
                    <tbody id="detailsTableBody">
                        <!-- JS will fill this -->
                    </tbody>
                </table>

            </div>

        </div>
    </div>
</div>

@endsection

@section('scripts')
\


<script>
    //     $(document).ready(function() {


//          $('#currencySelect').on('change', function() {
//             const selectedCurrencyId = $(this).val();
//             const selectedCurrencyName = $('#currencySelect option:selected').text();
//             const csrfToken = $('meta[name="csrf-token"]').attr('content');

//             $.ajax({
//                 url: "{{ route('platform_currency.update') }}",
//                 type: 'POST',
//                 data: {
//                     default_currency: selectedCurrencyId,
//                     _token: csrfToken
//                 },
//                 success: function(res) {
//                     if (res.success) {
//                         // ✅ Update hidden fields
//                         $('#current_currency').val(selectedCurrencyName);
//                         $('#selected_currency_id').val(selectedCurrencyId);


//                     }
//                 }
//             });
//         });

// });
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
            const currencySelect = document.getElementById('currencySelect');
            // Get the balances main tab button
            const balancesTabBtn = document.querySelector('button.tab-btn[data-target="balancesDiv"]');

            // ✅ New Loader HTML
            const loaderHtml = `
                <tr>
                    <td colspan="100%" class="text-center p-5">
                        <div class="loader-container">
                            <span class="custom-loader"></span>
                        </div>
                    </td>
                </tr>
            `;

            // ✅ Fetch with Minimum Delay Helper
            async function fetchWithDelay(url, options = {}, minDuration = 1000) {
                const start = Date.now();
                try {
                    const [response] = await Promise.all([
                        fetch(url, options),
                        new Promise(resolve => setTimeout(resolve, minDuration))
                    ]);
                    return response;
                } catch (error) {
                    // Ensure delay even on error if needed, or just throw
                    const elapsed = Date.now() - start;
                    if (elapsed < minDuration) {
                        await new Promise(resolve => setTimeout(resolve, minDuration - elapsed));
                    }
                    throw error;
                }
            }
            const perCourseHead = `
            <tr>
            <th>Course Name</th>
            <th>Teacher Name</th>
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
                            loadTeacherBalances(selectYear.value);
                        } else if (target === 'payoutsDiv') {
                            // Fetch payouts data when Payouts tab is clicked
                            if (window.fetchPayoutsDataGlobal) {
                                window.fetchPayoutsDataGlobal();
                            }
                        }
                    });
                });

                // Function to fetch payouts data
            //   function fetchPayoutsData() {
            //         const sessionId = selectYear.value; // Assuming selectYear is your session select element
            //         const payoutsTableBody = document.getElementById('payoutsTableBody');

            //         if (!sessionId) {
            //             payoutsTableBody.innerHTML = '<tr><td colspan="9" class="text-center text-warning">Please select a session first</td></tr>';
            //             return;
            //         }

            //         // Show loading state
            //         payoutsTableBody.innerHTML = '<tr><td colspan="9" class="text-center">Loading...</td></tr>';

            //         let payoutsUrl = "{{ route('payouts.data', ['session_id' => ':sessionId']) }}".replace(':sessionId', sessionId);
            //         const startDate = document.getElementById('startDate').value;
            //         const endDate = document.getElementById('endDate').value;

            //         let params = [];
            //         if (startDate) params.push(`start_date=${startDate}`);
            //         if (endDate) params.push(`end_date=${endDate}`);

            //         if (params.length > 0) {
            //             payoutsUrl += '?' + params.join('&');
            //         }

            //         fetch(payoutsUrl)
            //             .then(response => {
            //                 if (!response.ok) throw new Error('Network response was not ok');
            //                 return response.json();
            //             })
            //             .then(data => {
            //                 payoutsTableBody.innerHTML = '';

            //                 if (data.success && data.payments.length > 0) {
            //                     appendPayoutsData(data.payments);
            //                 } else if (data.success && data.payments.length === 0) {
            //                     payoutsTableBody.innerHTML = '<tr><td colspan="9" class="text-center">No payouts found for this session</td></tr>';
            //                 } else {
            //                     payoutsTableBody.innerHTML = `<tr><td colspan="9" class="text-center text-danger">${data.message}</td></tr>`;
            //                 }
            //             })
            //             .catch(error => {
            //                 console.error('Error fetching payouts:', error);
            //                 payoutsTableBody.innerHTML = '<tr><td colspan="9" class="text-center text-danger">Error loading data</td></tr>';
            //             });
            //     }

            //     // Append payouts to table
            //    function appendPayoutsData(payouts) {
            //         const payoutsTableBody = document.getElementById('payoutsTableBody');
            //         payoutsTableBody.innerHTML = ''; // Clear previous rows

            //         payouts.forEach(payout => {
            //             const row = document.createElement('tr');

            //             const createdAt = new Date(payout.created_at).toLocaleString();
            //             const sessionTitle = payout.session ? payout.session.session_title : '-';
            //             const paidAmount = parseFloat(payout.paid_amount ?? 0).toFixed(2);
            //             const currency = payout.currency ? payout.currency.currency_name : '';
            //             const type = payout.type || '-';
            //             const remarks = payout.remarks || '';

            //             row.innerHTML = `
            //                 <td>${createdAt}</td>
            //                 <td>${sessionTitle}</td>
            //                 <td>${paidAmount} (${currency})</td>
            //                 <td>${type}</td>
            //                 <td>${remarks}</td>
            //                 <td class="text-end">
            //                     <button class="btn btn-sm btn-outline-danger delete-payout" data-id="${payout.id}">
            //                         <i class="fa-solid fa-trash me-1"></i>Delete
            //                     </button>
            //                 </td>
            //             `;

            //             payoutsTableBody.appendChild(row);
            //         });

            //         // Attach event listeners to Delete buttons
            //         document.querySelectorAll('.delete-payout').forEach(button => {
            //             button.addEventListener('click', function() {
            //                 const payoutId = this.dataset.id;
            //                 deletePayout(payoutId);
            //             });
            //         });
            //     }
            //     $('#payoutsTableBody').on('click', '.delete-payout', function() {
            //         const payoutId = $(this).data('id');
            //         deletePayout(payoutId);
            //     });
            //     // Your existing delete function
            //     function deletePayout(payoutId) {
            //         if (!confirm('Are you sure you want to delete this payout?')) return;

            //         fetch(`/payouts/delete/${payoutId}`, {
            //             method: 'DELETE',
            //             headers: {
            //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            //             },
            //         })
            //         .then(response => response.json())
            //         .then(data => {
            //             if (data.success) {
            //                 alert('Payout deleted successfully.');
            //                 fetchPayoutsData(); // Refresh the table
            //             } else {
            //                 alert('Failed to delete payout: ' + data.message);
            //             }
            //         })
            //         .catch(error => {
            //             console.error('Error deleting payout:', error);
            //             alert('Something went wrong.');
            //         });
            //     }





            //     // Optional: Add search functionality
            //     document.querySelector('#payoutsDiv input[type="text"]').addEventListener('input', function(e) {
            //         const searchTerm = e.target.value.toLowerCase();
            //         const rows = document.querySelectorAll('#payoutsTableBody tr');

            //         rows.forEach(row => {
            //             const text = row.textContent.toLowerCase();
            //             row.style.display = text.includes(searchTerm) ? '' : 'none';
            //         });
            //     });

            //     // Optional: Refresh payouts when session changes
            //     selectYear.addEventListener('change', function() {
            //         // If payouts tab is currently active, refresh the data
            //         const payoutsTab = document.querySelector('.tab-btn[data-target="payoutsDiv"]');
            //         if (payoutsTab.classList.contains('active')) {
            //             fetchPayoutsData();
            //         }
            //     });









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
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Total</th>
                    <th>Platform Share</th>
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

            // Filter Button Click Event
            document.getElementById('filterBtn').addEventListener('click', function() {
                const sessionId = selectYear.value;

                // Check which main tab is active
                const activeMainTab = document.querySelector('#mainTabContainer .tab-btn.active');
                const target = activeMainTab ? activeMainTab.dataset.target : '';

                if (target === 'transactionsDiv') {
                    if (subRecent.classList.contains('active')) {
                        loadPlatformTransactions(sessionId);
                    } else if (subPerCourse.classList.contains('active')) {
                        loadPerCourseTransactions(sessionId);
                    }
                } else if (target === 'payoutsDiv') {
                    if (window.fetchPayoutsDataGlobal) {
                        window.fetchPayoutsDataGlobal();
                    }
                } else if (target === 'balancesDiv') {
                    loadTeacherBalances(sessionId);
                }
            });



         function loadPerCourseTransactions(sessionId = null) {
                let url = "{{ route('platform_transactions.per_course') }}";
                const startDate = document.getElementById('startDate').value;
                const endDate = document.getElementById('endDate').value;

                let params = [];
                if (sessionId) params.push(`session_id=${sessionId}`);
                if (startDate) params.push(`start_date=${startDate}`);
                if (endDate) params.push(`end_date=${endDate}`);

                if (params.length > 0) {
                    url += '?' + params.join('&');
                }

                // Show loading state
                tableBody.innerHTML = loaderHtml;

                fetchWithDelay(url)
                    .then(res => res.json())
                    .then(res => {
                        if (res.status !== "success") {
                            toastr.clear();
                            toastr.error("Failed to load per-course transactions");
                            return;
                        }

                        // ✅ Update summary cards
                        const currency = $("#currencySelect option:selected").text();

                        $("#total_revenue").text(`${currency} ${Number(res.total_revenue).toFixed(2)}`);
                        $("#platformBalance").text(`${currency} ${Number(res.platform_balance).toFixed(2)}`);
                        $("#withdrawn_balance").text(`${currency} ${Number(res.withdrawn_balance).toFixed(2)}`);

                        // ✅ Populate table rows
                        tableBody.innerHTML = "";

                        if (res.data.length === 0) {
                            tableBody.innerHTML = '<tr><td colspan="9" class="text-center">No records found</td></tr>';
                            return;
                        }

                        res.data.forEach(item => {
                            const courseName = item.course_title ?? "-";
                            const teacherName = item.teacher_name ?? "-";
                            const sessionTitle = item.session_title ?? "-";
                            const transactionCount = item.transactions_count ?? 0;

                            const totalAmount = `${Number(item.total_amount).toFixed(2)} (${currency})`;
                            const platformAmount = `${Number(item.platform_amount ?? 0).toFixed(2)} (${currency})`;
                            const totalPaid = `${Number(item.total_paid).toFixed(2)} (${currency})`;

                            const totalRemaining = `${(Number(item.total_paid) - Number(item.platform_amount ?? 0)).toFixed(2)} (${currency})`;

                            tableBody.insertAdjacentHTML("beforeend", `
                                <tr>
                                    <td>${courseName}</td>
                                    <td>${teacherName}</td>
                                    <td>${sessionTitle}</td>
                                    <td>${transactionCount}</td>
                                    <td>${totalAmount}</td>
                                    <td>${platformAmount}</td>
                                    <td>${totalPaid}</td>
                                    <td>${totalRemaining}</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary view-details"
                                            data-course-id="${item.course_id}"
                                            data-teacher-id="${item.teacher_id}"
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


            document.addEventListener("click", (e) => {
                if (!e.target.classList.contains("view-details")) return;

                const courseId  = e.target.dataset.courseId;
                const teacherId = e.target.dataset.teacherId;
                const sessionId = e.target.dataset.sessionId;

                const url =
                    "{{ route('platform_transactions.per_course.details') }}" +
                    `?course_id=${courseId}&teacher_id=${teacherId}&session_id=${sessionId}`;

                openModalWithData(url);
            });


            async function openModalWithData(url) {

                const tbody = document.getElementById("detailsTableBody");
                tbody.innerHTML = `<tr><td colspan="6" class="text-center">Loading...</td></tr>`;

                $("#courseDetailsModal").modal("show");

                try {
                    const response = await fetch(url);
                    const res = await response.json();

                    if (res.status !== "success") {
                        tbody.innerHTML = `<tr><td colspan="6" class="text-danger text-center">
                            Failed to load data
                        </td></tr>`;
                        return;
                    }

                    if (!res.data.length) {
                        tbody.innerHTML = `<tr><td colspan="6" class="text-center">No transactions found</td></tr>`;
                        return;
                    }

                    tbody.innerHTML = res.data
                        .map(t => `
                            <tr>
                                <td>${t.id}</td>
                                <td>${t.student_name}</td>
                                <td>${t.total}</td>
                                <td>${t.platform_amount}</td>
                                <td>${t.paid_amount}</td>
                                <td>${t.remaining_amount}</td>
                            </tr>
                        `)
                        .join("");

                } catch (error) {
                    console.error(error);
                    tbody.innerHTML = `<tr><td colspan="6" class="text-danger text-center">
                        Error loading data
                    </td></tr>`;
                }
            }










            // ================= LOAD TRANSACTIONS =================
             function loadPlatformTransactions(sessionId = null, currencyId = null) {
                const tableBody = document.getElementById('transactionsTableBody'); // Ensure you have this ID
                let url = "{{ route('platform_transactions.index') }}";
                const startDate = document.getElementById('startDate')?.value || null;
                const endDate = document.getElementById('endDate')?.value || null;


                // Build query params
                const params = [];
                if (sessionId) params.push(`session_id=${encodeURIComponent(sessionId)}`);
                if (currencyId) params.push(`currency_id=${encodeURIComponent(currencyId)}`);
                if (startDate) params.push(`start_date=${encodeURIComponent(startDate)}`);
                if (endDate) params.push(`end_date=${encodeURIComponent(endDate)}`);

                if (params.length > 0) {
                    url += '?' + params.join('&');
                }

                // Show loading state
                tableBody.innerHTML = '<tr><td colspan="13" class="text-center">Loading...</td></tr>';

                fetch(url)
                    .then(res => res.json())
                    .then(res => {
                        if (res.status !== "success") {
                            toastr.clear();
                            toastr.error("Failed to load transactions");
                            tableBody.innerHTML = '<tr><td colspan="13" class="text-center">Error loading data</td></tr>';
                            return;
                        }

                        const data = res.data;
                        const totalRevenue = res.total_revenue || 0;
                        const platformBalance = res.platform_balance || 0;
                        const withdrawnBalance = res.withdrawn_balance || 0;
                        const currency = $("#currencySelect option:selected").text() || '';

                        // Update top cards
                        $("#total_revenue").text(`${currency} ${Number(totalRevenue).toFixed(2)}`);
                        $("#platformBalance").text(`${currency} ${Number(platformBalance).toFixed(2)}`);
                        $("#withdrawn_balance").text(`${currency} ${Number(withdrawnBalance).toFixed(2)}`);

                        // Update table
                        tableBody.innerHTML = "";
                        if (!data.length) {
                            tableBody.innerHTML = '<tr><td colspan="13" class="text-center">No records found</td></tr>';
                            return;
                        }

                        data.forEach((row, index) => {
                            const currencyName = row.currency?.currency_name ?? "-";
                            const createdAt = new Date(row.created_at).toLocaleString('en-US', {
                                year: 'numeric', month: 'short', day: '2-digit',
                                hour: '2-digit', minute: '2-digit', hour12: true
                            });

                            tableBody.insertAdjacentHTML('beforeend', `
                                <tr id="transaction-row-${row.id}">
                                    <td>${index + 1}</td>
                                    <td>${createdAt}</td>
                                    <td>${row.teacher?.teacher_name ?? '-'}</td>
                                    <td>${row.course?.course_title ?? '-'}</td>
                                    <td>${row.session?.session_title ?? '-'}</td>
                                    <td>${row.student_name ?? '-'}</td>
                                    <td>${row.parent_name ?? '-'}</td>
                                    <td>${row.student_contact ?? '-'}</td>
                                    <td>${row.student_email ?? '-'}</td>

                                    <td>${Number(row.total ?? 0).toFixed(2)} (${currencyName})</td>
                                    <td>${Number(row.platform_share ?? 0).toFixed(2)} (${currencyName})</td>
                                    <td class="paid-amount">${Number(row.paid_amount ?? 0).toFixed(2)} (${currencyName})</td>
                                    <td class="remaining-amount">${Number(row.remaining_amount ?? 0).toFixed(2)} (${currencyName})</td>

                                    <td class="text-end">
                                        <button class="btn btn-sm icon-btn restore-btn"
                                            data-id="${row.id}"
                                            data-total="${row.total ?? 0}"
                                            data-paid="${row.paid_amount ?? 0}"
                                            data-remaining="${row.remaining_amount ?? 0}">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                        </button>

                                        <button class="btn btn-sm icon-btn text-danger delete-btn"
                                            data-id="${row.id}">
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
                        tableBody.innerHTML = '<tr><td colspan="13" class="text-center">Error fetching data</td></tr>';
                    });


                }

                // Event delegation for Delete buttons using route name
                document.querySelector('#transactionsTableBody').addEventListener('click', function(e) {
                    const deleteBtn = e.target.closest('.delete-btn');
                    if (!deleteBtn) return;

                    const row = deleteBtn.closest('tr');
                    const transactionId = row.dataset.id || deleteBtn.dataset.id;

                    if (!transactionId) return;

                    if (!confirm('Are you sure you want to delete this transaction?')) return;

                    const deleteUrl = "{{ route('transactions.delete', ':id') }}".replace(':id', transactionId);

                    fetch(deleteUrl, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            row.remove();
                            toastr.success(data.message || 'Transaction deleted successfully');
                        } else {
                            toastr.error(data.message || 'Failed to delete transaction');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        toastr.error('Something went wrong while deleting the transaction');
                    });
                });



                // Initial load using the first selected session

               selectYear.addEventListener('change', function() {
                    const sessionId = this.value;
                    const  currencyId = currencySelect.value;

                    if (subRecent.classList.contains("active")) {

                        loadPlatformTransactions(sessionId, currencyId);
                    }

                    if (subPerCourse.classList.contains("active")) {
                        loadPerCourseTransactions(sessionId);  // ✅ If PerCourse tab active
                    }

                    // ✅ Add balances tab scenario
                    if (balancesTabBtn.classList.contains("active")) {
                        loadTeacherBalances(sessionId);  // If Balances tab active
                    }

                    // ✅ Add payouts tab scenario
                    const payoutsTabBtn = document.querySelector('button.tab-btn[data-target="payoutsDiv"]');
                    if (payoutsTabBtn && payoutsTabBtn.classList.contains("active")) {
                         if (window.fetchPayoutsDataGlobal) {
                            window.fetchPayoutsDataGlobal();
                        }
                    }
                });
               currencySelect.addEventListener('change', function() {
                    const sessionId = selectYear.value;
                    const currencyId = currencySelect.value;

                    // ✅ First update currency in backend
                    fetch("{{ route('platform_currency.update') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            default_currency: currencyId
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            // ✅ Currency updated successfully, now reload data based on active tab

                            if (subRecent.classList.contains("active")) {
                                loadPlatformTransactions(sessionId);
                            }

                            if (subPerCourse.classList.contains("active")) {
                                loadPerCourseTransactions(sessionId);
                            }

                            // Check if Balances tab is active
                            if (balancesTabBtn.classList.contains("active")) {
                                loadTeacherBalances(sessionId);
                            }

                            // ✅ Add payouts tab scenario
                            const payoutsTabBtn = document.querySelector('button.tab-btn[data-target="payoutsDiv"]');
                            if (payoutsTabBtn && payoutsTabBtn.classList.contains("active")) {
                                if (window.fetchPayoutsDataGlobal) {
                                    window.fetchPayoutsDataGlobal();
                                }
                            }
                        } else {
                            toastr.error('Failed to update currency');
                        }
                    })
                    .catch(err => {
                        console.error('Error updating currency:', err);
                        toastr.error('Error updating currency');
                    });
                });


               function loadTeacherBalances(sessionId) {
                let url = `{{ route('balances.teacher') }}?session_id=${sessionId}`;
                const startDate = document.getElementById('startDate').value;
                const endDate = document.getElementById('endDate').value;

                if (startDate) url += `&start_date=${startDate}`;
                if (endDate) url += `&end_date=${endDate}`;

                const tbody = document.querySelector('#teacherBalances tbody');
                tbody.innerHTML = loaderHtml;

                fetchWithDelay(url)
                    .then(res => res.json())
                    .then(res => {
                        if (res.status !== "success") {
                            toastr.clear();
                            toastr.error("Failed to load teacher balances");
                            return;
                        }

                        tbody.innerHTML = ''; // clear old rows

                        if (res.data.length === 0) {
                            tbody.innerHTML = '<tr><td colspan="7" class="text-center">No records found</td></tr>';
                            return;
                        }

                        // Get currency info from response
                        const currencyName = res.currency_name || '';
                        const currencySymbol = res.currency_symbol || '';

                        res.data.forEach(teacher => {
                            // Format numbers with currency
                            const totalRevenueFormatted = `${teacher.total_revenue.toLocaleString()} (${currencyName})`;
                            const platformShareFormatted = `${teacher.total_platform_share.toLocaleString()} (${currencyName})`;
                            const totalTeacherShareFormatted = `${teacher.total_teacher_share.toLocaleString()} (${currencyName})`;
                            const teacherPaidFormatted = `${teacher.total_teacher_paid.toLocaleString()} (${currencyName})`;

                            // Calculate remaining teacher balance
                            const remainingTeacherBalance = teacher.total_teacher_share - teacher.total_teacher_paid;
                            const remainingFormatted = `${remainingTeacherBalance.toLocaleString()} (${currencyName})`;

                            tbody.insertAdjacentHTML('beforeend', `
                                <tr>
                                    <td>${teacher.name}</td>
                                    <td>${totalRevenueFormatted}</td>
                                    <td>${platformShareFormatted}</td>
                                    <td>${totalTeacherShareFormatted}</td>
                                    <td>${teacherPaidFormatted}</td>
                                    <td>${remainingFormatted}</td> <!-- Remaining balance -->
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
            // Apply search/filter on transaction table
            const searchInput = document.getElementById('transactionsSearchInput');
            if (searchInput) {
                console.log('Search input found, attaching listener');
                searchInput.addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase();
                    const rows = document.querySelectorAll('#transactionsTableBody tr');
                    console.log(`Searching for "${searchTerm}" in ${rows.length} rows`);

                    rows.forEach(row => {
                        // Combine all cell text for search
                        const text = Array.from(row.cells).map(cell => cell.textContent.toLowerCase()).join(' ');
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                });
            } else {
                console.error('Search input not found!');
            }


                // Update your existing balancesTabBtn click event to use the function
                balancesTabBtn.addEventListener('click', function() {
                    const sessionId = selectYear.value;
                    loadTeacherBalances(sessionId);
                });




            // ================= RESTORE MODAL LOGIC REMOVED (Handled in separate script block below) =================


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

                // restorePaid.value = newPaid;
                restoreRemaining.value = (total - paidReadonly - newPaid);
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

                    fetch(`/platform/transactions/${transactionId}/restore`, {
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

                        // ✅ Update the transaction row in the table
                        if (res.transaction) {
                            const updated = res.transaction;
                            const currencyName = res.currency || '';
                            const newRemainingAmount = (parseFloat(updated.total) - parseFloat(updated
                                .paid_amount)).toFixed(2);
                            const row = document.querySelector(`#transaction-row-${transactionId}`);

                            if (row) {
                                // Row found - update the cells
                                const paidCell = row.querySelector('.paid-amount');
                                const remainingCell = row.querySelector('.remaining-amount');
                                const restoreBtn = row.querySelector('.restore-btn');

                                if (paidCell) paidCell.textContent = `${parseFloat(updated.paid_amount).toFixed(2)} (${currencyName})`;
                                if (remainingCell) remainingCell.textContent = `${newRemainingAmount} (${currencyName})`;
                                if (restoreBtn) {
                                    restoreBtn.dataset.paid = updated.paid_amount;
                                    restoreBtn.dataset.remaining = newRemainingAmount;
                                }
                            } else {
                                // Row not found - alert user to refresh
                                console.warn("Transaction row not found in DOM. Transaction ID:", transactionId);
                                safeToastr('success', 'Transaction updated! Please refresh the page to see the changes.');
                            }

                            // Update summary cards if provided
                            if (res.total_revenue !== undefined) {
                                const totalRevenueEl = document.getElementById('total_revenue');
                                if (totalRevenueEl) {
                                    totalRevenueEl.textContent = `${currencyName} ${Number(res.total_revenue).toFixed(2)}`;
                                }
                            }
                            if (res.platform_balance !== undefined) {
                                const platformBalanceEl = document.getElementById('platformBalance');
                                if (platformBalanceEl) {
                                    platformBalanceEl.textContent = `${currencyName} ${Number(res.platform_balance).toFixed(2)}`;
                                }
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
    const courseFeeInput = document.getElementById('transaction_course_fee');
    const noteFeeInput = document.getElementById('transaction_note_fee');
    const paidInput = document.getElementById("transaction_paid");
    const remainingInput = document.getElementById("transaction_remaining");
    const transactionsModal = document.getElementById('transactionsModal');
    const tableBody = document.getElementById('transactionsTableBody'); // Updated to match your table structure
    function updateTotal() {
    const courseFee = parseFloat(courseFeeInput.value) || 0;
    const noteFee = parseFloat(noteFeeInput.value) || 0;
    totalInput.value = (courseFee + noteFee).toFixed(2);
    }

    courseFeeInput.addEventListener('input', updateTotal);
    noteFeeInput.addEventListener('input', updateTotal);
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
            const hiddenInputPayout = document.getElementById("selected_currency_id_payout");
            if (hiddenInput) hiddenInput.value = selectedCurrencyId;
            if (hiddenInputPayout) hiddenInputPayout.value = selectedCurrencyId;

            // Update readonly text input
            const textInput = document.getElementById("current_currency");
            const current_currency_id_payout = document.getElementById("current_currency_id_payout");
            if (textInput) textInput.value = selectedCurrencyName;
            if (current_currency_id_payout) current_currency_id_payout.value = selectedCurrencyName;

        });
    }

});
</script>


{{-- This is the script for currency_update --}}







</script>

<script>
    $(document).ready(function() {

    // -------------------------
    //  ADD PAYOUT (AJAX POST)
    // -------------------------
    $('#payoutForm').on('submit', function(e) {
        e.preventDefault();

        let formData = {
            session_id: $('#session_id').val(),
            paid_amount: parseFloat($('#amount').val()),
            remarks: $('#remarks').val(),
            selected_currency_id: $('#selected_currency_id').val()
        };

        $.ajax({
            url: "{{ route('platform_payout') }}",
            method: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response && response.success) {

                    // Close modal & reset form
                    $('#payoutsModal').modal('hide');
                    $('#payoutForm')[0].reset();

                    let p = response.payout;

                    // ✅ FIX: Re-fetch all payouts to update both DOM and state arrays
                    // This prevents duplicates and ensures consistency
                    if (typeof window.fetchPayoutsDataGlobal === 'function') {
                        window.fetchPayoutsDataGlobal();
                    }

                    // Update withdrawn balance
                    let $bal = $('#withdrawn_balance');
                    if ($bal.length) {
                        let current = parseFloat($bal.data('balance') || 0);
                        current += parseFloat(p.paid_amount || 0);
                        $bal.data('balance', current);
                        $bal.text(`${p.selected_currency} ${current.toFixed(2)}`);
                    }

                    alert(response.message || 'Payout added successfully!');
                } else {
                    alert(response.message || 'Failed to add payout');
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                alert("Something went wrong!");
            }
        });

    });

    // -----------------------------------
    //  DELETE PAYOUT (DYNAMIC HANDLER)
    // -----------------------------------
   $(document).on('click', '.delete-payout', function(e) {
            e.preventDefault();

            const $btn = $(this);
            const payoutId = $btn.data('id');

            if (!payoutId) return;
            if (!confirm("Are you sure you want to delete this payout?")) return;

            const url = "{{ route('payouts.delete', ':id') }}".replace(':id', payoutId);

            $.ajax({
                url: url,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                },
                success: function(res) {
                    const ok = (res && (res.status === 'success' || res.success === true));

                    if (ok) {
                        // Get the paid amount before re-fetching (for balance update)
                        const $row = $btn.closest('tr');
                        const paidAmountText = $row.find('td').eq(2).text();
                        const paidAmount = parseFloat(paidAmountText.replace(/[^\d.-]/g, '')) || 0;

                        // ✅ FIX: Re-fetch all payouts to update both DOM and state arrays
                        if (typeof window.fetchPayoutsDataGlobal === 'function') {
                            window.fetchPayoutsDataGlobal();
                        }

                        // Update withdrawn balance
                        const $bal = $('#withdrawn_balance');
                        if ($bal.length) {
                            let current = parseFloat($bal.text().replace(/[^\d.-]/g, '')) || 0;
                            current -= paidAmount;
                            $bal.text(`${res.currency || 'AED'} ${current.toFixed(2)}`);
                            $bal.data('balance', current);
                        }

                        alert(res.message || 'Payout deleted successfully!');
                    } else {
                        alert(res.message || 'Failed to delete payout');
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Error deleting payout!');
                }
            });
        });




});
</script>


{{-- This is the script for of pdf and excel for transaction & recent table --}}



<script>
    $(document).ready(function () {

    // =========================
    // STATE
    // =========================
    window.tableState = window.tableState || {
        selectedColumns: [], // store indices of selected columns
    };

    const $tableHead = $('#transactionsTableHead');
    const $tableBody = $('#transactionsTableBody');
    const $columnsModal = $('#columnsModal');
    const $columnsCheckboxes = $('#columnsCheckboxes');
    const $applyColumnsBtn = $('#applyColumnsBtn');
    const $columnsBtn = $('#columnsBtn');

    const $exportExcelBtn = $('#exportExcelBtn');
    const $exportPdfBtn = $('#exportPdfBtn');

    function escapeHtml(text) {
        return $('<div>').text(text).html();
    }

    async function loadHtml2PdfLibrary() {
        if (typeof html2pdf !== 'undefined') return;
        return $.getScript(
            "https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        );
    }

    // Return visible column indices and header names
    function getVisibleColumns() {
        const visibleIndices = [];
        const headers = [];

        $tableHead.find('th').each(function (i) {
            if ($(this).is(':visible')) {
                visibleIndices.push(i);
                headers.push($(this).text().trim());
            }
        });

        return { visibleIndices, headers };
    }

    // -------------------------------------------------
    // OPEN COLUMN MODAL
    // -------------------------------------------------
    $columnsBtn.on('click', function () {
        $columnsCheckboxes.empty();
        const totalColumns = $tableHead.find('th').length;

        // Initialize default selection
        if (window.tableState.selectedColumns.length === 0) {
            window.tableState.selectedColumns = [...Array(totalColumns).keys()];
        }

        // Generate checkbox list
        $tableHead.find('th').each(function (i) {
            const label = $(this).text().trim();
            const checked = window.tableState.selectedColumns.includes(i);

            $columnsCheckboxes.append(`
                <label>
                    <input type="checkbox" data-index="${i}" ${checked ? "checked" : ""}>
                    ${label}
                </label><br>
            `);
        });

        $columnsModal.modal("show");
    });

    // -------------------------------------------------
    // APPLY COLUMNS
    // -------------------------------------------------
    $applyColumnsBtn.on("click", function () {
        const selected = [];

        $columnsCheckboxes.find("input[type='checkbox']:checked").each(function () {
            selected.push(parseInt($(this).data("index")));
        });

        window.tableState.selectedColumns = selected;

        // Show/hide columns (header + rows)
        $tableHead.find("th").each(function (i) {
            $(this).toggle(selected.includes(i));
        });

        $tableBody.find("tr").each(function () {
            $(this).find("td").each(function (i) {
                $(this).toggle(selected.includes(i));
            });
        });

        $columnsModal.modal("hide");
    });

    // -------------------------------------------------
    // EXPORT EXCEL
    // -------------------------------------------------
    $exportExcelBtn.on("click", function () {
    const { visibleIndices, headers } = getVisibleColumns();
    if (!headers.length) return alert("No columns selected");

    const wb = XLSX.utils.book_new();
    const rows = [];

    // Clean headers and trim spaces
    const cleanHeaders = headers.map(h => h.trim());
    rows.push(cleanHeaders);

    $tableBody.find("tr").each(function () {
        const row = [];
        $(this).find("td").each(function (i) {
            if (visibleIndices.includes(i)) {
                // Remove extra spaces and line breaks
                let cellText = $(this).text().replace(/\s+/g, ' ').trim();
                row.push(cellText);
            }
        });
        rows.push(row);
    });

    const ws = XLSX.utils.aoa_to_sheet(rows);

    // Auto-adjust column widths
        const colWidths = rows[0].map((_, colIndex) => {
            return { wch: Math.max(
                ...rows.map(row => (row[colIndex] ? row[colIndex].toString().length : 0)),
                10 // minimum width
            )};
        });
        ws['!cols'] = colWidths;

        XLSX.utils.book_append_sheet(wb, ws, "Transactions");
        XLSX.writeFile(wb, `WeTeach_Transactions_${new Date().toISOString().split('T')[0]}.xlsx`);
    });


    // -------------------------------------------------
    // EXPORT PDF (Your Design Copy-Pasted Exactly)
    // -------------------------------------------------
    // -------------------------------------------------
    // EXPORT PDF (Dynamic Title & Logo)
    // -------------------------------------------------
    $exportPdfBtn.off("click").on("click", async function () {

        const { visibleIndices, headers } = getVisibleColumns();
        if (!headers.length) return alert("No columns selected to export");

        const exportData = [];
        let totalRevenue = 0;

        // Detect "Paid" column by name (case insensitive) - works for "Paid" and "Total Paid"
        const totalPaidHeaderIndex = headers.findIndex(h => h.toLowerCase().includes('paid'));

        // Extract rows
        $tableBody.find("tr").each(function () {
            const row = [];
            let rowPaid = 0;

            $(this).find("td").each(function (i) {
                if (visibleIndices.includes(i)) {
                    const cell = $(this).text().trim();
                    row.push(cell);

                    // If column matches paid
                    if (visibleIndices.indexOf(i) === totalPaidHeaderIndex) {
                        rowPaid = parseFloat(cell.replace(/[^\d.-]/g, "")) || 0;
                    }
                }
            });

            if (row.length) {
                exportData.push(row);
                totalRevenue += rowPaid;
            }
        });

        if (!exportData.length) return alert("No data to export");

        await loadHtml2PdfLibrary();

        // Use .jpg as requested
        const logoUrl = "{{ asset('assets/logo_pic/vteach_logo.jpg') }}";
        const colWidth = 100 / headers.length;

        // Determine Title based on active tab
        const isRecent = $('#sub-recent').hasClass('active');
        const title = isRecent ? 'We Teach Platform Recent Transactions Sheet' : 'We Teach Platform Per Course Transactions Sheet';
        const options = { year: 'numeric', month: 'short', day: '2-digit', hour: '2-digit', minute: '2-digit', hour12: true };
         const formattedDate = new Date().toLocaleString('en-US', options);
        // Build header
        let headerHtml = "<tr>";
        headers.forEach(h => {
            headerHtml += `
                <th style="border-bottom:2px solid #4CAF50;padding:10px 6px;font-weight:bold;font-size:10px;text-align:center;background:#f3f3f3;color:#333;width:${colWidth}%">
                    ${escapeHtml(h)}
                </th>`;
        });
        headerHtml += "</tr>";

        // Build rows
        let rowsHtml = "";
        exportData.forEach((row, i) => {
            const bg = i % 2 === 0 ? "#fff" : "#f9f9f9";
            rowsHtml += "<tr>";
            row.forEach(c => {
                rowsHtml += `
                    <td style="border:1px solid #ddd;padding:8px;font-size:9px;text-align:left;background:${bg};width:${colWidth}%">
                        ${escapeHtml(c)}
                    </td>`;
            });
            rowsHtml += "</tr>";
        });

        // Add Total Revenue row (aligned properly)
        if (totalPaidHeaderIndex !== -1) {
            const colspan = totalPaidHeaderIndex;
            const emptyCols = headers.length - (colspan + 1);

            rowsHtml += `<tr>`;
            if (colspan > 0) {
                rowsHtml += `
                    <td colspan="${colspan}" style="border:1px solid #333;padding:10px;font-weight:bold;text-align:right;background:#f3f3f3;">
                        Total Revenue
                    </td>`;
            }
            rowsHtml += `
                <td style="border:1px solid #333;padding:10px;font-weight:bold;text-align:right;background:#f3f3f3;">
                    ${totalRevenue.toFixed(2)}
                </td>`;
            if (emptyCols > 0) {
                rowsHtml += `
                    <td colspan="${emptyCols}" style="border:1px solid #333;background:#f3f3f3;"></td>`;
            }
            rowsHtml += `</tr>`;
        }

        // Final PDF content
        const html = `
            <div style="font-family:Arial;width:95%;padding:10px;margin:auto">
                <div style="text-align:center;margin-bottom:15px">
                    <img src="${logoUrl}" style="height:60px;margin:auto;" />
                    <h2 style="margin:5px 0;color:#4CAF50;">${title}</h2>
                    <p style="font-size:10px;color:#666">
                        Generated on: ${formattedDate}
                    </p>
                </div>

                <table style="width:100%;border-collapse:collapse;table-layout:fixed;">
                    <thead>${headerHtml}</thead>
                    <tbody>${rowsHtml}</tbody>
                </table>

                <div style="margin-top:100px;text-align:center;">
                    <div style="display:flex;justify-content:center;gap:80px;margin-top:40px;">
                        <div>
                            <p>________________________</p>
                            <p>Teacher Signature</p>
                        </div>
                        <div>
                            <p>________________________</p>
                            <p>Platform Signature</p>
                        </div>
                    </div>
                </div>
            </div>
        `;

        const $element = $(`<div>${html}</div>`);
        $("body").append($element);

        html2pdf().set({
            margin: 10,
            filename: `WeTeach_Transactions_${new Date().toISOString().split("T")[0]}.pdf`,
            html2canvas: { scale: 2, useCORS: true },
            jsPDF: { orientation: "landscape", unit: "mm", format: "a4" },
        })
        .from($element[0])
        .save()
        .then(() => $element.remove());
    });

});
</script>




{{-- This is the script of pdf & excel for per course table --}}


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







            // ============================
            // EXPORT PDF
            // ============================


        });
</script>


{{-- This is the script of export pdf and excel for payout --}}





<script>
    $(document).ready(function () {

    // --- Global State ---
    window.payoutTableState = {
        allData: [],
        currentTableData: [],
        columns: ['id', 'date_time', 'session_name', 'paid', 'type', 'remarks', 'actions'],
        hiddenColumns: ['id'] // columns not shown initially, actions always visible
    };

    const $payoutsTableBody = $('#payoutsTableBody');
    const $payoutsTableHead = $('#payoutsTableHead tr');
    const $selectYear = $('#SelectYear');
    const $currencySelect = $('#currencySelect');
    const $columnsCheckboxes = $('#columnsCheckboxes');

    // CLEANER for currencies
    function cleanCurrencyText(value) {
        if (!value) return '';
        return String(value)
            .replace(/<br\s*\/?>/gi, ' ')
            .replace(/[\r\n]+/g, ' ')
            .replace(/\(\s+/g, '(')
            .replace(/\s+\)/g, ')')
            .replace(/\s+/g, ' ')
            .trim();
    }

    // API endpoint for fetching payouts
    function getApiEndpoint() {
        const sessionId = $selectYear.val();
        if (!sessionId) return null;
        let url = "{{ route('payouts.data', ':session_id') }}".replace(':session_id', sessionId);

        const startDate = $('#startDate').val();
        const endDate = $('#endDate').val();

        let params = [];
        if (startDate) params.push(`start_date=${startDate}`);
        if (endDate) params.push(`end_date=${endDate}`);

        if (params.length > 0) {
            url += '?' + params.join('&');
        }
        return url;
    }
    function formatDate(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);

        const options = {
            month: "short",
            day: "2-digit",
            year: "numeric",
            hour: "2-digit",
            minute: "2-digit",
            hour12: true
        };

        return date.toLocaleString("en-US", options);
    }

    // Fetch payouts
    window.fetchPayoutsDataGlobal = function(startDate = null, endDate = null) {
        const API_ENDPOINT = getApiEndpoint();
        if (!API_ENDPOINT) {
            $payoutsTableBody.html('<tr><td colspan="10" class="text-center text-danger">Could not determine data API URL.</td></tr>');
            return;
        }

        // Use global loaderHtml if available, otherwise fallback
        const loader = (typeof loaderHtml !== 'undefined') ? loaderHtml : '<tr><td colspan="10" class="text-center">Loading data...</td></tr>';
        $payoutsTableBody.html(loader);

        const delayPromise = new Promise(resolve => setTimeout(resolve, 1000));
        const ajaxPromise = $.ajax({
            url: API_ENDPOINT,
            type: 'GET',
            data: {
                start_date: startDate,
                end_date: endDate
            },
            dataType: 'json'
        });

        Promise.all([ajaxPromise, delayPromise])
            .then(([result]) => {
                if (result.success && Array.isArray(result.payments)) {

                    const formattedData = result.payments.map(p => ({
                        id: p.id,
                        date_time: formatDate(p.created_at),
                        session_name: p.session?.session_title ?? '-',
                        paid: cleanCurrencyText(`${parseFloat(p.paid_amount ?? 0).toFixed(2)} (${p.currency?.currency_name ?? ''})`),
                        type: p.type ?? '-',
                        remarks: p.remarks ?? '-'
                    }));

                    window.payoutTableState.allData = formattedData;
                    window.payoutTableState.currentTableData = formattedData;

                    renderTable(formattedData);
                    renderColumnsModal();
                } else {
                    $payoutsTableBody.html('<tr><td colspan="10" class="text-center text-danger">Invalid data received.</td></tr>');
                }
            })
            .catch(() => {
                $payoutsTableBody.html('<tr><td colspan="10" class="text-center text-danger">Failed to load payout data.</td></tr>');
            });
    }

    $("#filterPayoutBtn").on("click", function () {
        const start = $("#payoutStartDate").val() || null;
        const end = $("#payoutEndDate").val() || null;

        window.fetchPayoutsDataGlobal(start, end);
    });

    function fetchPayoutsData() {
        window.fetchPayoutsDataGlobal();
    }

    // Render table with only visible columns
    function renderTable(data) {
        $payoutsTableBody.empty();

        if (!data.length) {
            $payoutsTableBody.html('<tr><td colspan="10" class="text-center">No matching records found.</td></tr>');
            return;
        }

        data.forEach(row => {
            const $tr = $('<tr>');
            let html = '';
            window.payoutTableState.columns.forEach(col => {
                if (window.payoutTableState.hiddenColumns.includes(col) && col !== 'actions') return; // skip hidden columns except actions
                const val = row[col] ?? '-';
                if (col === 'actions') {
                    html += `<td class="text-end">
                                <button class="btn btn-sm btn-outline-danger delete-payout" data-id="${row.id}">
                                    <i class="fa-solid fa-trash me-1"></i>Delete
                                </button>
                            </td>`;
                } else {
                    html += `<td>${val}</td>`;
                }
            });
            $tr.html(html);
            $payoutsTableBody.append($tr);
        });

        renderTableHeader();
    }

    // Dynamically render the table header based on visible columns
    function renderTableHeader() {
        const labels = {
            date_time: 'Date/Time',
            session_name: 'Session',
            paid: 'Paid',
            type: 'Type',
            remarks: 'Remarks',
            actions: 'Actions'
        };

        $payoutsTableHead.empty();

        window.payoutTableState.columns.forEach(col => {
            if (window.payoutTableState.hiddenColumns.includes(col) && col !== 'actions') return; // skip hidden except actions
            const th = $('<th>').text(labels[col] || col);
            if (col === 'actions') th.addClass('text-end');
            $payoutsTableHead.append(th);
        });
    }

    // Render columns in modal
    function renderColumnsModal() {
        const labels = {
            date_time: 'Date/Time',
            session_name: 'Session',
            paid: 'Paid',
            type: 'Type',
            remarks: 'Remarks'
        };

        $columnsCheckboxes.empty();
        window.payoutTableState.columns.forEach(col => {
            if (col === 'id' || col === 'actions') return; // actions always visible
            const checked = !window.payoutTableState.hiddenColumns.includes(col);
            $columnsCheckboxes.append(`
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="${col}" id="col_${col}" ${checked ? 'checked' : ''}>
                    <label class="form-check-label" for="col_${col}">${labels[col] || col}</label>
                </div>
            `);
        });
    }

    // Open modal
    $('#PayoutColumn').click(function () {
        renderColumnsModal();
    });

    // Apply modal selection
    $('#applyColumnsBtn').click(function () {
        const hidden = $columnsCheckboxes.find('input[type=checkbox]:not(:checked)').map(function () {
            return this.value;
        }).get();

        if (!hidden.includes('id')) hidden.push('id'); // id remains hidden
        window.payoutTableState.hiddenColumns = hidden;

        // Re-render table and header with only selected columns
        renderTable(window.payoutTableState.currentTableData);
        $('#columnsModal').modal('hide');
    });

    // Search filter
    $('#payoutsDiv').on('input', '.form-control', function () {
        const term = $(this).val().toLowerCase();
        const filtered = window.payoutTableState.allData.filter(row =>
            Object.values(row).some(v => String(v).toLowerCase().includes(term))
        );
        window.payoutTableState.currentTableData = filtered;
        renderTable(filtered);
    });

    // EXCEL EXPORT
    $('#exportPayoutExcel').click(function () {
        const visible = window.payoutTableState.columns.filter(c => !window.payoutTableState.hiddenColumns.includes(c));
        if (!visible.length) return alert('No columns selected');

        const exportData = window.payoutTableState.currentTableData.map(row => {
            const cleaned = {};
            visible.forEach(col => cleaned[col] = cleanCurrencyText(row[col]));
            return cleaned;
        });

        const ws = XLSX.utils.json_to_sheet(exportData);
        ws['!cols'] = visible.map(col => ({ wch: col.length + 12 }));
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Payouts');
        XLSX.writeFile(wb, `Payouts_${new Date().toISOString().split('T')[0]}.xlsx`);
    });

    // Helper to load html2pdf if not present
    function loadHtml2PdfLibrary() {
        return new Promise((resolve, reject) => {
            if (window.html2pdf) return resolve();
            const script = document.createElement("script");
            script.src = "https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js";
            script.onload = resolve;
            script.onerror = reject;
            document.head.appendChild(script);
        });
    }

    function escapeHtml(text) {
        if (!text) return "";
        return String(text)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    // PDF EXPORT
    $('#exportPayoutPdf').click(async function () {
        const visible = window.payoutTableState.columns.filter(c => !window.payoutTableState.hiddenColumns.includes(c));
        if (!visible.length) return alert('No columns selected');

        await loadHtml2PdfLibrary();

        const logoUrl = "{{ asset('assets/logo_pic/vteach_logo.jpg') }}";
        const title = "We Teach Platform Payouts Sheet";
        const colWidth = 100 / visible.length;

        // Calculate total paid
        let totalPaid = 0;
        const data = window.payoutTableState.currentTableData;

        // Find index of paid column
        const paidColIndex = visible.findIndex(c => c.toLowerCase().includes('paid'));

        data.forEach(row => {
             // Extract number from "123.45 (USD)"
             const paidStr = row.paid || '0';
             const val = parseFloat(paidStr.replace(/[^\d.-]/g, "")) || 0;
             totalPaid += val;
        });
        const options = { year: 'numeric', month: 'short', day: '2-digit', hour: '2-digit', minute: '2-digit', hour12: true };
         const formattedDate = new Date().toLocaleString('en-US', options);
        // Build header
        let headerHtml = "<tr>";
        const labels = {
            date_time: 'Date/Time',
            session_name: 'Session',
            paid: 'Paid',
            type: 'Type',
            remarks: 'Remarks',
            actions: 'Actions'
        };

        visible.forEach(col => {
             const label = labels[col] || col;
             headerHtml += `
                <th style="border-bottom:2px solid #4CAF50;padding:10px 6px;font-weight:bold;font-size:10px;text-align:center;background:#f3f3f3;color:#333;width:${colWidth}%">
                    ${escapeHtml(label)}
                </th>`;
        });
        headerHtml += "</tr>";

        // Build rows
        let rowsHtml = "";
        data.forEach((row, i) => {
            const bg = i % 2 === 0 ? "#fff" : "#f9f9f9";
            rowsHtml += "<tr>";
            visible.forEach(col => {
                let val = row[col] || '-';
                rowsHtml += `
                    <td style="border:1px solid #ddd;padding:8px;font-size:9px;text-align:left;background:${bg};width:${colWidth}%">
                        ${escapeHtml(val)}
                    </td>`;
            });
            rowsHtml += "</tr>";
        });

        // Add Total Paid row
        if (paidColIndex !== -1) {
             const colspan = paidColIndex;
             const emptyCols = visible.length - (colspan + 1);

             rowsHtml += `<tr>`;
             if (colspan > 0) {
                 rowsHtml += `
                    <td colspan="${colspan}" style="border:1px solid #333;padding:10px;font-weight:bold;text-align:right;background:#f3f3f3;">
                        Total Paid
                    </td>`;
             }
             rowsHtml += `
                <td style="border:1px solid #333;padding:10px;font-weight:bold;text-align:right;background:#f3f3f3;">
                    ${totalPaid.toFixed(2)}
                </td>`;
             if (emptyCols > 0) {
                 rowsHtml += `
                    <td colspan="${emptyCols}" style="border:1px solid #333;background:#f3f3f3;"></td>`;
             }
             rowsHtml += `</tr>`;
        }

        // Final HTML
        const html = `
            <div style="font-family:Arial;width:95%;padding:10px;margin:auto">
                <div style="text-align:center;margin-bottom:15px">
                    <img src="${logoUrl}" style="height:60px;margin:auto;" />
                    <h2 style="margin:5px 0;color:#4CAF50;">${title}</h2>
                    <p style="font-size:10px;color:#666">
                        Generated on: ${formattedDate}
                    </p>
                </div>

                <table style="width:100%;border-collapse:collapse;table-layout:fixed;">
                    <thead>${headerHtml}</thead>
                    <tbody>${rowsHtml}</tbody>
                </table>

                <div style="margin-top:100px;text-align:center;">
                    <div style="display:flex;justify-content:center;gap:80px;margin-top:40px;">
                        <div>
                            <p>________________________</p>
                            <p>Teacher Signature</p>
                        </div>
                        <div>
                            <p>________________________</p>
                            <p>Platform Signature</p>
                        </div>
                    </div>
                </div>
            </div>
        `;

        const $element = $(`<div>${html}</div>`);
        $("body").append($element);

        html2pdf().set({
            margin: 10,
            filename: `Payouts_${new Date().toISOString().split("T")[0]}.pdf`,
            html2canvas: { scale: 2, useCORS: true },
            jsPDF: { orientation: "landscape", unit: "mm", format: "a4" },
        })
        .from($element[0])
        .save()
        .then(() => $element.remove());
    });

    $selectYear.on('change', fetchPayoutsDataGlobal);
    $currencySelect.on('change', fetchPayoutsDataGlobal);


});
</script>

<script>
    $(document).ready(function() {
        var $teacherSelect = $('#transaction_teacher');
        var $courseSelect = $('#transaction_course');

        $teacherSelect.on('change', function() {
            var teacherId = $(this).val();

            // Clear and disable course dropdown while loading
            $courseSelect.html('<option selected disabled>Loading courses...</option>');
            $courseSelect.prop('disabled', true);

            if (!teacherId) {
                $courseSelect.html('<option selected disabled>Select Teacher First</option>');
                return;
            }

            // Fetch courses for the selected teacher
            var url = "{{ route('teacher.courses', ':teacherId') }}".replace(':teacherId', teacherId);

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $courseSelect.html('<option selected disabled>Select Course</option>');

                    if (data.success && data.courses.length > 0) {
                        $.each(data.courses, function(index, course) {
                            $courseSelect.append(
                                $('<option>', {
                                    value: course.id,
                                    text: course.course_title
                                })
                            );
                        });
                        $courseSelect.prop('disabled', false);
                    } else {
                        $courseSelect.html('<option selected disabled>No courses available for this teacher</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching courses:', error);
                    $courseSelect.html('<option selected disabled>Error loading courses</option>');
                }
            });
        });
    });

</script>




@endsection
