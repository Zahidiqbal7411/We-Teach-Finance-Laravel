  @extends('layouts.app')
  @section('contents')
  
  

      <div class="main-content">
        <div class="topbar p-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-semibold mb-0">Report</h4>
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
                <div class="report-title">
                    <h4 class="fw-semibold mb-0">Reports</h4>
                    <small class="text-muted">View and manage generated reports</small>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-dark btn-md" id="GenerateReport">
                        <i class="fa-solid fa-file-lines me-2"></i>
                        Generate Report</button>
                </div>
            </div> <!-- Cards Row -->
            <div class="row g-3 mb-4 details-cards" id="report-detailsCard">
                <div class="col-md-3">
                    <div class="info-card">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-arrow-trend-up " ></i>
                            <div class="ms-3 d-inline-block">
                                <p class="text-muted">Total Reports</p>
                                <h5 class="fw-bold" style="margin-top: -14px;">2</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-card ">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-user-group "></i>
                            <div class="ms-3 d-inline-block">
                                <p class="text-muted">Teacher Reports</p>
                                <h5 class="fw-bold" style="margin-top: -14px;">2</h5>
                            </div>
                        </div>
                      
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-card">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-user-group "></i>
                            <div class="ms-3 d-inline-block">
                                <p class="text-muted">This Month</p>
                                <h5 class="fw-bold" style="margin-top: -14px;">2</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-card">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-download"></i>
                            <div class="ms-3 d-inline-block">
                                <p class="text-muted">Downloads</p>
                                <h5 class="fw-bold" style="margin-top: -14px;">47</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Card Table -->
        <div class="card-table p-3 shadow-lg mt-3 ">
            <h5 class="fw-semibold mb-3" id="table-title">All Transactions</h5>

            <!-- Controls -->
            <div class="d-flex flex-wrap justify-content-between mb-3 gap-2">
                <div class="d-flex gap-2">
                    <button class="btn btn-dark btn-sm"><i class="fa-solid fa-plus"></i> Add</button>
                    <button class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-filter"></i> Filter</button>
                    <button class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-download"></i>
                        Export</button>
                    <select id="columnsSelect" class="form-select form-select-sm" style="width:auto;">
                        + <option value="id">Columns</option>
                        + <option value="date_time">Date &amp; Time</option>
                        + <option value="teacher">Teacher</option>
                        + </select>
                </div>
                <input type="text" id="search" class="form-control form-control-sm w-auto" placeholder="Search...">
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Scope</th>
                            <th>Type</th>
                            <th>Form Date</th>
                            <th>To Date</th>
                            <th>Created</th>
                            <th>Actions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="data-body"></tbody>
                </table>
            </div>
        </div>



    </div>



    
  @endsection