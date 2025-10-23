{{-- @extends('layouts.app')

@section('contents')
<div class="main-content p-4" style="margin-left: 260px; min-height: 100vh; background: #f8f9fa;">

    <!-- ✅ Top Bar -->
    <div class="teacher-topbar d-flex justify-content-between align-items-center mb-4 p-3" 
         style="background: #ffffff; border-radius: 10px;">
        <div>
            <h4 class="fw-semibold mb-0">Platform</h4>
        </div>
        <div class="d-flex align-items-center gap-3">
            <select class="form-select form-select-md" id="SelectYear" style="outline: none !important; box-shadow: none !important;">
                <option>May/June 2026</option>
                <option>May/June 2027</option>
            </select>
            <select class="form-select form-select-md" id="currencySelect" style="outline: none !important; box-shadow: none !important;">
                <option>EG/EGP</option>
                <option>US/USD</option>
                <option>EU/EUR</option>
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

    <!-- Sub Tabs -->
    <div class="d-flex gap-2 mb-3 flex-wrap" id="subTabContainer">
        <!-- Transactions default sub-tabs -->
        <button class="tab-btn active" id="sub-recent">Recent</button>
        <button class="tab-btn" id="sub-percourse">Per Course</button>
    </div>

    <!-- Transactions Table -->
    <div id="transactionsDiv" class="card border-0 shadow-sm">
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
                <input type="text" class="form-control border-start-0" id="searchInput" placeholder="Search...">
            </div>

            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
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
                            <td class="text-end"><button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Payouts Table -->
    <div id="payoutsDiv" class="card border-0 shadow-sm" style="display: none;">
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
                        <td>1</td>
                        <td>10/10/2024, 9:00 AM</td>
                        <td>Monthly Earnings</td>
                        <td>Payout for platform earnings</td>
                        <td>LE 2,000.00</td>
                        <td><button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Balances Table -->
    <div id="balancesDiv" class="card border-0 shadow-sm" style="display: none;">
        <div class="card-body">
            <div class="d-flex gap-2 mb-3 flex-wrap" id="balancesSubTabs">
                <button class="tab-btn active" id="balance-teacher">Teacher</button>
                <button class="tab-btn" id="balance-platform">Platform</button>
            </div>

            <div id="balancesContent">
                <div id="teacherBalances">
                    <table class="table align-middle table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Teacher</th>
                                <th>Course</th>
                                <th>Session</th>
                                <th>Total Amount</th>
                                <th>Total Paid</th>
                                <th>Total Remaining</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Prof. Sarah Johnson</td>
                                <td>A-Level Physics</td>
                                <td>May/June 2026</td>
                                <td>LE 120.00</td>
                                <td>LE 60.00</td>
                                <td>LE 60.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="platformBalances" style="display: none;">
                    <table class="table align-middle table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Platform</th>
                                <th>Course</th>
                                <th>Session</th>
                                <th>Total Amount</th>
                                <th>Total Paid</th>
                                <th>Total Remaining</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Main Platform</td>
                                <td>A-Level Physics</td>
                                <td>May/June 2026</td>
                                <td>LE 40.00</td>
                                <td>LE 20.00</td>
                                <td>LE 20.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Main Tab Switching
    const mainTabs = document.querySelectorAll('#mainTabContainer .tab-btn');
    mainTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            mainTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            const target = this.dataset.target;
            ['transactionsDiv','payoutsDiv','balancesDiv','reportsDiv'].forEach(divId => {
                document.getElementById(divId).style.display = divId === target ? 'block' : 'none';
            });

            // Transactions sub-tabs
            if(target === 'transactionsDiv') {
                document.getElementById('subTabContainer').style.display = 'flex';
                document.getElementById('sub-recent').click();
            } else {
                document.getElementById('subTabContainer').style.display = 'none';
            }

            // Balances sub-tabs
            if(target === 'balancesDiv') {
                document.getElementById('balancesSubTabs').style.display = 'flex';
                document.getElementById('balance-teacher').click();
            } else {
                document.getElementById('balancesSubTabs').style.display = 'none';
            }
        });
    });

    // Transactions Sub Tabs
    const subRecent = document.getElementById('sub-recent');
    const subPerCourse = document.getElementById('sub-percourse');
    const tableHead = document.querySelector('#transactionsDiv thead');
    const tableBody = document.getElementById('transactionsTableBody');

    const recentRows = tableBody.innerHTML;
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
    const perCourseRows = `
        <tr>
            <td>A-Level Physics</td>
            <td>May/June 2026</td>
            <td>1</td>
            <td>LE 120.00</td>
            <td>LE 60.00</td>
            <td>LE 60.00</td>
            <td><button class="btn btn-sm btn-dark">View</button></td>
        </tr>
    `;

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
            </tr>
        `;
        tableBody.innerHTML = recentRows;
    });

    subPerCourse.addEventListener('click', function() {
        subPerCourse.classList.add('active');
        subRecent.classList.remove('active');
        tableHead.innerHTML = perCourseHead;
        tableBody.innerHTML = perCourseRows;
    });

    // Balances Sub Tabs
    const balanceTeacher = document.getElementById('balance-teacher');
    const balancePlatform = document.getElementById('balance-platform');
    const teacherDiv = document.getElementById('teacherBalances');
    const platformDiv = document.getElementById('platformBalances');

    balanceTeacher.addEventListener('click', function() {
        balanceTeacher.classList.add('active');
        balancePlatform.classList.remove('active');
        teacherDiv.style.display = 'block';
        platformDiv.style.display = 'none';
    });

    balancePlatform.addEventListener('click', function() {
        balancePlatform.classList.add('active');
        balanceTeacher.classList.remove('active');
        teacherDiv.style.display = 'none';
        platformDiv.style.display = 'block';
    });
});
</script>
@endsection --}}


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
            <select class="form-select form-select-md" id="SelectYear" style="outline: none !important; box-shadow: none !important;">
                <option>May/June 2026</option>
                <option>May/June 2027</option>
            </select>
            <select class="form-select form-select-md" id="currencySelect" style="outline: none !important; box-shadow: none !important;">
                <option>EG/EGP</option>
                <option>US/USD</option>
                <option>EU/EUR</option>
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
                    <div >
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
        <button class="tab-btn" data-target="balancesDiv" id="balances">Balances</button>
        <button class="tab-btn" data-target="reportsDiv">Reports</button>
    </div>

    <!-- Sub Tabs -->
    <div class="d-flex gap-2 mb-3 flex-wrap" id="subTabContainer" >
        <!-- Transactions default sub-tabs -->
        <button class="tab-btn active" id="sub-recent">Recent</button>
        <button class="tab-btn" id="sub-percourse">Per Course</button>
    </div>

    <!-- Transactions Table -->
    <div id="transactionsDiv" class="card border-0 shadow-sm">
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
                <input type="text" class="form-control border-start-0" id="searchInput" placeholder="Search...">
            </div>

            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
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
                            <td class="text-end"><button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Payouts Table -->
    <div id="payoutsDiv" class="card border-0 shadow-sm" style="display: none;">
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
        </div>
    </div>

    <!-- Balances Table -->
    <div id="balancesDiv" class="card border-0 shadow-sm" style="display: none;">
        <div class="card-body">
            <div class="d-flex gap-2 mb-3 flex-wrap" id="balancesSubTabs">
                <button class="tab-btn active" id="balance-teacher">Teacher</button>
                <button class="tab-btn" id="balance-platform">Platform</button>
            </div>

            <div id="balancesContent">
                <!-- Teacher Balances -->
                <div id="teacherBalances">
                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                        <h5 class="fw-semibold mb-2 mb-md-0">Teacher Balances</h5>
                        <div class="d-flex gap-2 flex-wrap">
                            <button class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-filter me-1"></i> Filter</button>
                            <button class="btn btn-outline-success btn-sm"><i class="fa-solid fa-file-export me-1"></i> Export</button>
                            <button class="btn btn-outline-dark btn-sm"><i class="fa-solid fa-table-columns me-1"></i> Columns</button>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-search"></i></span>
                        <input type="text" class="form-control border-start-0" placeholder="Search...">
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
                                <td><button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button></td>
                            </tr>
                            <tr>
                                <td>Prof. Sarah Johnson</td>
                                <td>-LE 218.00</td>
                                <td>LE 400.00</td>
                                <td><button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button></td>
                            </tr>
                            <tr>
                                <td>Dr. Mohamed Ali</td>
                                <td>LE 52.50</td>
                                <td>LE 0.00</td>
                                <td><button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Platform Balances -->
                <div id="platformBalances" style="display: none;">
                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                        <h5 class="fw-semibold mb-2 mb-md-0">Platform Balances</h5>
                        <div class="d-flex gap-2 flex-wrap">
                            <button class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-filter me-1"></i> Filter</button>
                            <button class="btn btn-outline-success btn-sm"><i class="fa-solid fa-file-export me-1"></i> Export</button>
                            <button class="btn btn-outline-dark btn-sm"><i class="fa-solid fa-table-columns me-1"></i> Columns</button>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-search"></i></span>
                        <input type="text" class="form-control border-start-0" placeholder="Search...">
                    </div>
                    <div class="row">
                      <div class="card col-md-6 w-40 h-70">hello</div>
                       <div class="card col-md-6 w-40 h-70">hi</div>
                       </div>
                    {{-- <table class="table align-middle table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Platform Name</th>
                                <th>Current Balance</th>
                                <th>Paid Before</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Main Platform</td>
                                <td>LE 4,658.25</td>
                                <td>LE 0.00</td>
                                <td><button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button></td>
                            </tr>
                        </tbody>
                    </table> --}}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
  






document.addEventListener('DOMContentLoaded', function() {




    const balancesBtn = document.getElementById('balances');
    const subTabContainer = document.getElementById('subTabContainer');

    balancesBtn.addEventListener('click', function() {
        console.log("khan")
        subTabContainer.style.display = 'none';
    });
    // Main Tab Switching
    const mainTabs = document.querySelectorAll('#mainTabContainer .tab-btn');
    mainTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            mainTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            const target = this.dataset.target;
            ['transactionsDiv','payoutsDiv','balancesDiv','reportsDiv'].forEach(divId => {
                document.getElementById(divId).style.display = divId === target ? 'block' : 'none';
            });



  
            // Sub-tabs logic
            if(target === 'transactionsDiv') {
                document.getElementById('subTabContainer').style.display = 'flex';
                document.getElementById('sub-recent').click();
                document.getElementById('balancesSubTabs').style.display = 'none';
            } else if(target === 'balancesDiv') {
                document.getElementById('subTabContainer').style.display = 'none';
                document.getElementById('balancesSubTabs').style.display = 'flex';
                document.getElementById('balance-teacher').click();
            } else {
                // Other tabs
                document.getElementById('subTabContainer').style.display = 'flex';
                document.getElementById('sub-recent').click();
                document.getElementById('balancesSubTabs').style.display = 'none';
            }
        });
    });

    // Transactions Sub Tabs
    const subRecent = document.getElementById('sub-recent');
    const subPerCourse = document.getElementById('sub-percourse');
    const tableHead = document.querySelector('#transactionsDiv thead');
    const tableBody = document.getElementById('transactionsTableBody');

    const recentRows = tableBody.innerHTML;
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
    const perCourseRows = `
        <tr>
            <td>A-Level Physics</td>
            <td>May/June 2026</td>
            <td>1</td>
            <td>LE 120.00</td>
            <td>LE 60.00</td>
            <td>LE 60.00</td>
            <td><button class="btn btn-sm btn-dark">View</button></td>
        </tr>
    `;

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
            </tr>
        `;
        tableBody.innerHTML = recentRows;
    });

    subPerCourse.addEventListener('click', function() {
        subPerCourse.classList.add('active');
        subRecent.classList.remove('active');
        tableHead.innerHTML = perCourseHead;
        tableBody.innerHTML = perCourseRows;
    });

    // Balances Sub Tabs
    const balanceTeacher = document.getElementById('balance-teacher');
    const balancePlatform = document.getElementById('balance-platform');
    const teacherDiv = document.getElementById('teacherBalances');
    const platformDiv = document.getElementById('platformBalances');

    balanceTeacher.addEventListener('click', function() {
        balanceTeacher.classList.add('active');
        balancePlatform.classList.remove('active');
        teacherDiv.style.display = 'block';
        platformDiv.style.display = 'none';
    });

    balancePlatform.addEventListener('click', function() {
        balancePlatform.classList.add('active');
        balanceTeacher.classList.remove('active');
        teacherDiv.style.display = 'none';
        platformDiv.style.display = 'block';
    });
});
</script>
@endsection
