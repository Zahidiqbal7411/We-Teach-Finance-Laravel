@extends('layouts.app')

@section('contents')
<div class="main-content p-4" style="margin-left: 260px; min-height: 100vh; background: #f8f9fa;">
    
    <!-- ✅ Top Bar with Background -->
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

    <!-- Teachers Header -->
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
                    <option selected>Prof. Sarah Johnson</option>
                    <option>Mr. John Doe</option>
                    <option>Ms. Olivia Smith</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Teacher Profile -->
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

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <!-- Current Balance -->
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

        <!-- Paid Before -->
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

        <!-- Total Earned -->
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

    <!-- Main Tabs -->
    <div class="d-flex gap-2 mb-3 flex-wrap" id="mainTabContainer">
        <button class="tab-btn active">Transactions</button>
        <button class="tab-btn">Payouts</button>
        <button class="tab-btn">Balances</button>
        <button class="tab-btn">Reports</button>
    </div>

    <!-- Sub Tabs -->
    <div class="d-flex gap-2 mb-3 flex-wrap" id="subTabContainer">
        <button class="tab-btn active" id="sub-recent">Recent</button>
        <button class="tab-btn" id="sub-percourse">Per Course</button>
    </div>

    <!-- Recent Transactions -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                <h5 class="fw-semibold mb-2 mb-md-0">Recent Transactions</h5>
                <div class="d-flex gap-2 flex-wrap">
                    <button class="btn btn-dark btn-sm">
                        <i class="fa-solid fa-plus me-1"></i> Add
                    </button>
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="fa-solid fa-filter me-1"></i> Filter
                    </button>
                    <button class="btn btn-outline-success btn-sm">
                        <i class="fa-solid fa-file-export me-1"></i> Export
                    </button>
                    <button class="btn btn-outline-dark btn-sm">
                        <i class="fa-solid fa-table-columns me-1"></i> Columns
                    </button>
                </div>
            </div>

            <!-- Search -->
            <div class="input-group mb-3">
                <span class="input-group-text bg-white border-end-0">
                    <i class="fa-solid fa-search"></i>
                </span>
                <input type="text" class="form-control border-start-0" id="searchInput" placeholder="Search...">
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
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
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>5</td>
                            <td>10/4/2024, 9:30:00 AM</td>
                            <td>SAT Math Prep</td>
                            <td>May/June 2026</td>
                            <td>Michael Chen</td>
                            <td>Lisa Chen</td>
                            <td>$ 200.00 USD</td>
                            <td>$ 200.00 USD</td>
                            <td>$ 0.00 USD</td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Tab functionality
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Search filter
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('keyup', function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#transactionsTableBody tr');
        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>

<style>
    .main-content {
        transition: all 0.3s ease;
    }

    /* Tabs (Main + Sub) */
    .tab-btn {
        background: #f9f9fb;
        color: #000;
        padding: 6px 18px;
        border: none;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .tab-btn:hover {
        background: #eceff3;
    }

    .tab-btn.active {
        background: #fff;
        color: #000;
        font-weight: 600;
        box-shadow: 0 0 6px rgba(0, 0, 0, 0.1);
    }

    /* Card styles */
    .card {
        background: #fff;
        border-radius: 12px;
    }

    .table thead th {
        white-space: nowrap;
    }

    .table tbody td {
        vertical-align: middle;
    }

    .btn-sm {
        border-radius: 8px;
        font-weight: 500;
    }

    .icon-wrapper {
        background: #f4f6f8;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
@endsection
