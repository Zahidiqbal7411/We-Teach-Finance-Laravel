@extends('layouts.app')

@section('contents')
<div class="main-content p-4" style="margin-left: 260px; min-height: 100vh; background: #f8f9fa;">

    <!-- ✅ Top Bar -->
    <div class="teacher-topbar d-flex justify-content-between align-items-center mb-4 p-3" 
         style="background: #ffffff; border-radius: 10px;">
        <div>
            <h4 class="fw-semibold mb-0">Reports</h4>
        </div>
        <div class="d-flex align-items-center gap-3">
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

    <!-- ✅ Reports Header with Generate Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-semibold mb-1">Reports</h4>
            <p class="text-muted mb-0">Generate and manage platform-level reports</p>
        </div>
        <button class="btn btn-dark px-3">
            <i class="fa-solid fa-file me-1"></i> Generate Report
        </button>
    </div>

    <!-- ✅ Info Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <i class="fa-solid fa-file-lines fa-lg text-primary me-3"></i>
                    <div>
                        <p class="text-muted small mb-1">Total Reports</p>
                        <h5 class="fw-bold text-primary mb-0">1</h5>
                        <small class="text-muted">All generated reports</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <i class="fa-solid fa-calendar-days fa-lg text-warning me-3"></i>
                    <div>
                        <p class="text-muted small mb-1">This Quarter</p>
                        <h5 class="fw-bold text-warning mb-0">1</h5>
                        <small class="text-muted">Reports in Q3 2024</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <i class="fa-solid fa-chart-line fa-lg text-success me-3"></i>
                    <div>
                        <p class="text-muted small mb-1">Revenue Growth</p>
                        <h5 class="fw-bold text-success mb-0">+8.4%</h5>
                        <small class="text-muted">Compared to last quarter</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <i class="fa-solid fa-download fa-lg text-danger me-3"></i>
                    <div>
                        <p class="text-muted small mb-1">Downloads</p>
                        <h5 class="fw-bold text-danger mb-0">47</h5>
                        <small class="text-muted">Total downloads</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ Platform Reports Section -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                <h5 class="fw-semibold mb-2 mb-md-0">All Reports</h5>
                <div class="d-flex gap-2 flex-wrap">
                    <button class="btn btn-outline-primary btn-sm">
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

            <div class="input-group mb-3">
                <span class="input-group-text bg-white border-end-0">
                    <i class="fa-solid fa-search"></i>
                </span>
                <input type="text" class="form-control border-start-0" placeholder="Search platform reports...">
            </div>

            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>From Date</th>
                            <th>To Date</th>
                            <th>Created</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Platform Revenue Report - Q3 2024</td>
                            <td>Platform</td>
                            <td>2024-07-01</td>
                            <td>2024-09-30</td>
                            <td>10/1/2024, 10:00:00 AM</td>
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
document.addEventListener('DOMContentLoaded', function() {
    console.log("Platform Report page loaded successfully");
});
</script>
@endsection
