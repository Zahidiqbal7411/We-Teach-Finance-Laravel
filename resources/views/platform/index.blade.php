@extends('layouts.app')
@section('contents')
<div class="main-content">
        <div class="topbar p-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-semibold mb-0">Platform</h4>
                <div class="d-flex  gap-3">
                    <select class="form-select form-select-md">
                        <option>May/June 2026</option>
                        <option>May/June 2027</option>
                    </select>
                    <select class="form-select form-select-md">
                        <option>EG/EGP</option>
                        <option>US/USD</option>
                        <option>EU/EUR</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="content-area">
            <div class="sub-topbar d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-semibold mb-0">Platform</h4>
                    <small class="text-muted">Cross-teacher views and platform management</small>
                </div>

            </div> <!-- Cards Row -->
            <div class="row g-3 mb-4 details-cards">
                <div class="col-md-4">
                    <div class="info-card border-start border-success border-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="fw-bold mb-1 ">Platform Balance</h5>
                                <h5 class="mb-0 fw-bold mt-3">LE 4,658.25</h5>
                                <small class="">Platform revenue (30% share)</small>
                            </div>
                            <i class="fa-solid fa-arrow-trend-up text-success fs-5 mb-5"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card border-start border-primary border-3" id="platform-cardone">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="fw-bold mb-1">Total Revenue</h5>
                                <h5 class="mb-0 fw-bold mt-3">LE 4,658.25</h5>
                                <small class="text-secondary">Lifetime platform earnings</small>
                            </div>
                            <i class="fa-solid fa-dollar-sign text-primary fs-5 mb-5"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card border-start border-purple border-3" id="platform-cardtwo">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="fw-bold mb-1">Withdrawn Balance</h5>
                                <h5 class="mb-0 fw-bold mt-3">LE 0.00</h5>
                                <small class="text-secondary">Amount withdrawn by platform</small>
                            </div>
                            <i class="fa-solid fa-coins text-purple fs-5 mb-5"></i>
                        </div>
                    </div>
                </div>

            </div>


        </div>



        <!-- Tabs -->
        <div class="d-flex gap-2 mb-3 flex-wrap platform-tabsBtns">
            <button class="btn btn-outline active" id="tab-transactions">Transactions</button>
            <button class="btn btn-outline" id="tab-reports">Reports</button>
            <button class="btn btn-outline" id="tab-payouts">Payouts</button>
            <button class="btn btn-outline" id="tab-balances">Balances</button>
        </div>

        <!-- Sub Tabs -->
        <div class="d-flex gap-2  mt-3 flex-wrap sub-tabbtns">
            <button class="btn btn-light border active" id="sub-recent">Recent</button>
            <button class="btn btn-light border" id="sub-percourse">Per Course</button>
        </div>

        <!-- Card Table -->
        <div class="card-table p-3 shadow-lg mt-3">
  <h5 class="fw-semibold mb-3" id="table-title">All Transactions</h5>

  <!-- Controls -->
  <div class="d-flex flex-wrap justify-content-between mb-3 gap-2 align-items-center">
    <div class="d-flex flex-wrap gap-2">
      <button class="btn btn-dark btn-sm d-flex align-items-center gap-1">
        <i class="fa-solid fa-plus"></i> Add
      </button>
      <button class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
        <i class="fa-solid fa-filter"></i> Filter
      </button>
      <button class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
        <i class="fa-solid fa-download"></i> Export
      </button>

      <select id="columnsSelect" class="form-select form-select-sm" style="width:auto; min-width:140px;">
        <option value="id">Columns</option>
        <option value="date_time">Date &amp; Time</option>
        <option value="teacher">Teacher</option>
      </select>
    </div>

    <input type="text" id="search" class="form-control form-control-sm w-auto" placeholder="Search...">
  </div>

  <!-- Table -->
  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle mb-0">
      <thead class="table-light text-secondary small text-uppercase">
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
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="data-body">
       
      </tbody>
    </table>
  </div>
</div>











    </div>

@endsection