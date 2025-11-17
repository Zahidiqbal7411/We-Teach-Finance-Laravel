@extends('layouts.app')

@section('contents')
<div class="main-content">
    <div class="topbar p-3">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-semibold mb-0">Dashboard</h4>
            <div class="d-flex  gap-3">
                <select class="form-select form-select-sm" id="SelectYear" name="year">

                    @foreach ($sessions as $session)
                    <option value="{{ $session->id }}">{{ $session->session_title }}</option>

                    @endforeach

                </select>
                <select class="form-select form-select-sm" id="currencySelect" name="currency">

                    @foreach ($currencies as $currency)
                    <option value="{{ $currency->id }}">{{ $currency->currency_name }}</option>

                    @endforeach

                </select>
            </div>
        </div>
    </div>

    <div class="content-area">
        <div class="sub-topbar d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-semibold mb-0">Dashboard</h4>
                <small class="text-muted">Financial overview and system
                    status</small>
            </div>
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-dark btn-md" id="exportSummary"><i class="fa-solid fa-download me-2"></i>Export
                    Summary</button>
            </div>
        </div> <!-- Cards Row -->
        <div class="row g-3 mb-4 details-cards">
            <div class="col-md-3">
                <div class=" border-start border-success border-3" id="info-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold mb-1 ">Today's Inflow</h5>
                            <h6 class="mb-0 today-inflow mt-3" id="today-inflow"> 0.00</h6>
                            <small class="text-secondary">Payments received today</small>
                        </div>
                        <i class="fa-solid fa-arrow-trend-up text-success fs-5 mb-5"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="border-start border-primary border-3" id="info-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold mb-1">MTD Inflow</h5>
                            <h6 class="mb-0 text-primary mt-3 mtd-inflow" id="mtd-inflow"> 0.00</h6>
                            <small class="text-secondary">Month-to-date revenue</small>
                        </div>
                        <i class="fa-solid fa-dollar-sign text-primary fs-5 mb-5"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class=" border-start border-purple border-3" id="info-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold mb-1">MTD Payouts</h5>
                            <h6 class="mb-0 mtd-payouts mt-3"> 0.00</h6>
                            <small class="text-secondary">Teacher payments</small>
                        </div>
                        <i class="fa-solid fa-coins text-purple fs-5 mb-5"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class=" border-start border-warning border-3" id="info-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold mb-1">Pending Balance</h5>
                            <h6 class="mb-0 text-warning mt-3 pending-teacher-balance">0.00</h6>
                            <small class="text-secondary">Outstanding to
                                collect</small>
                        </div>
                        <i class="fa-solid fa-triangle-exclamation text-warning fs-5 mb-5"></i>
                    </div>
                </div>
            </div>
        </div> <!-- Exceptions & Alerts -->
        <div class="card p-3 mb-4 shadow-sm Exceptions-alertCard">
            <h6 class="fw-semibold mb-2">Exceptions & Alerts</h6>
            <div class="alert-box d-flex justify-content-between align-items-center p-3 border rounded bg-light">
                <div> <i class="fa-solid fa-clock text-warning me-2"></i> <span class="fw-semibold">2
                        transaction(s)</span>
                    have pending amounts > 7 days <div class="small text-secondary">Medium Priority</div>
                </div> <button class="btn btn-outline-dark btn-sm">Review</button>
            </div>
        </div> <!-- Activity & Health -->
        <div class="row g-3 Activity-healthRow">
            <div class="col-md-6">
                <div class="card p-3 shadow-sm recent-activity-card">
                    <h6 class="fw-semibold mb-3">Recent Activity</h6>
                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item d-flex justify-content-between mb-2"> <span>New transactions
                                today</span><span class="fw-semibold">12</span> </li>
                        <li class="list-group-item d-flex justify-content-between mb-2"> <span>Active
                                teachers</span><span class="fw-semibold">5</span> </li>
                        <li class="list-group-item d-flex justify-content-between mb-2"> <span>Pending
                                payouts</span><span class="fw-semibold">2</span> </li>
                        <li class="list-group-item d-flex justify-content-between mb-2"> <span>Generated
                                reports</span><span class="fw-semibold">8</span> </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3 shadow-sm system-health-card">
                    <h6 class="fw-semibold mb-3">System Health</h6>
                    <ul class="list-group list-group-flush small system-health">
                        <li class="list-group-item d-flex justify-content-between mb-2"> <span>Data
                                synchronization</span><span class="badge bg-success-subtle text-success">Healthy</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between mb-2"> <span>Payment
                                processing</span><span class="badge bg-success-subtle text-success">Online</span> </li>
                        <li class="list-group-item d-flex justify-content-between mb-2"> <span>Report
                                generation</span><span class="badge bg-success-subtle text-success">Available</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between mb-2"> <span>Last backup</span><span
                                class="text-secondary">2 hours ago</span> </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('scripts')


<script>
    $(document).ready(function() {

    // Function to fetch and update inflow cards
    function updateInflowCards(sessionId) {
        console.log("Fetching data for session ID:", sessionId);

        $.ajax({
            url: "{{ route('dashboard.update_session') }}",
            method: "POST",
            data: {
                session_id: sessionId,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log("Response:", response);

                if(response.status === 'success') {
                    // Convert values to float
                    var todayInflow = parseFloat(response.today_inflow);
                    var mtdInflow = parseFloat(response.mtd_inflow);
                    var mtdPayouts = parseFloat(response.mtd_teacher_payouts);
                    var pending_teacher_balance = parseFloat(response.pending_teacher_balance);

                    // Update cards
                    $('.today-inflow').text(todayInflow.toFixed(2) + ' ' + response.selected_currency);
                    $('.mtd-inflow').text(mtdInflow.toFixed(2) + ' ' + response.selected_currency);
                    $('.mtd-payouts').text(mtdPayouts.toFixed(2) + ' ' + response.selected_currency);
                    $('.pending-teacher-balance').text(pending_teacher_balance.toFixed(2) + ' ' + response.selected_currency);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
            }
        });
    }

    // Trigger when session dropdown changes
    $('#SelectYear').on('change', function() {
        var sessionId = $(this).val();
        updateInflowCards(sessionId);
    });

    // Trigger on page load
    var initialSessionId = $('#SelectYear').val(); // default selected session
    if(initialSessionId) {
        updateInflowCards(initialSessionId);
    }

    // Trigger when currency dropdown changes
    $('#currencySelect').on('change', function() {
        var selectedSession = $('#SelectYear').val(); // get current session dynamically
        var selectedCurrency = $(this).val();

        console.log("Currency ID:", selectedCurrency, "Session ID:", selectedSession);

        // Update selected currency in backend
        $.ajax({
            url: "{{ route('dashboard.update_currency') }}",
            method: "POST",
            data: {
                currency_id: selectedCurrency,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                // Re-fetch cards for CURRENTLY selected session
                updateInflowCards(selectedSession);
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
            }
        });
    });

});
</script>







@endsection