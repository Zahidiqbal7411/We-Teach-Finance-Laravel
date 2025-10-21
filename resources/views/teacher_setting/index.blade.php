    @extends('layouts.app')

    @section('contents')
    <div class="main-content">

     <!-- <div class="content"> -->
     <div class="teacher-topbar d-flex justify-content-between align-items-center mb-4">
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

      <div class="page-title">
        <h3 class="mb-1">Teachers</h3>
        <div class="page-desc">Manage teacher transactions, payouts, and reports</div>
      </div>

      <!-- select teacher card -->
      <div class="card-ghost mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
          <div style="flex:1; min-width:320px;">
            <label class="form-label mb-2">Select Teacher</label>
            <div class="d-flex gap-2 align-items-center">
              <div class=" select-wrap" style="width:600px;">
                <select id="teacherSelect" class="form-select">
                  <option value="">Choose a teacher to view their data</option>
                </select>
              </div>

              <div class="select-actions d-flex flex-wrap flex-md-row flex-column gap-2">
                <button id="btnDeleteTeacher" class="btn btn-danger btn-sm" title="Delete selected teacher" disabled>
                  <i class="fa-solid fa-trash me-1"></i> Delete Teacher
                </button>
                <!-- Optional: Add new teacher modal trigger -->
                <button id="btnAddManual" class="btn btn-ghost btn-sm" title="Add manual teacher">
                  <i class="fa-solid fa-user-pen me-1"></i> Add
                </button>
              </div>
            </div>
          </div>

          <div class="text-end small-muted">
            <div>Filter / Date range</div>
          </div>
        </div>
      </div>

      <!-- big panel showing selected teacher or placeholder -->
      <div class="card-ghost mb-4">
        <div id="teacherPanel" class="placeholder-card">
          <i class="fa-solid fa-user-group" style="color: #0D1A35;"></i>
          <div class="fw-semibold">No Teacher Selected</div>
          <div class="small-muted">Please select a teacher from the dropdown above to view their data.</div>
        </div>
      </div>

      <!-- transactions table -->
      <div class="card-ghost table-card mb-4">
        <div class="p-3 border-bottom">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="mb-0">Transactions</h6>
              <div class="small-muted">Teacher transaction history (select a teacher)</div>
            </div>
            <div>
              <button id="btnClearAllTx" class="btn btn-sm btn-outline-secondary" disabled><i class="fa-solid fa-trash-can me-1"></i> Clear transactions</button>
            </div>
          </div>
        </div>

        <div class="table-responsive">
          <table id="txTable" class="table mb-0">
            <thead>
              <tr>
                <th>#</th>
                <th>Date</th>
                <th>Type</th>
                <th>Reference</th>
                <th class="text-end">Amount</th>
                <th>Status</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              <!-- rows inserted by JS -->
            </tbody>
          </table>
        </div>
      </div>

   
  </div>

  <!-- Optional modal for adding manual teacher -->
  <div class="modal fade" id="manualModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title">Add Teacher</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <label class="form-label">Name</label>
            <input id="manualName" class="form-control form-control-sm" placeholder="Enter name" required>
          </div>
          <div class="mb-2">
            <label class="form-label">Email</label>
            <input id="manualEmail" class="form-control form-control-sm" placeholder="Enter Email" required>
          </div>
        </div>
        <div class="modal-footer">
          <button id="manualAddBtn" type="button" class="btn btn-primary btn-sm">Add</button>
        </div>
      </div>
       </div>
    </div>
  </div>
  @endsection