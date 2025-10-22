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



@section('scripts')

 <script>

        // tabs buttons active state
        const tabButtons = document.querySelectorAll('.platform-tabsBtns .btn');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons
                tabButtons.forEach(btn => btn.classList.remove('active'));
                // Add active class to clicked button
                button.classList.add('active');
            });
        });





        // Platform page TABLE DATA RENDERING
        const transactions = [
            {
                id: 1,
                date: "10/8/2024, 2:30 PM",
                teacher: "Dr. Ahmed Hassan",
                course: "IGCSE Mathematics",
                session: "May/June 2026",
                student: "John Smith",
                parent: "Robert Smith",
                total: "LE 2,500.00",
                paid: "LE 2,500.00",
                remaining: "LE 0.00"
            },
            {
                id: 2,
                date: "10/7/2024, 4:45 PM",
                teacher: "Prof. Sarah Johnson",
                course: "A-Level Physics",
                session: "May/June 2026",
                student: "Emma Wilson",
                parent: "David Wilson",
                total: "LE 120.00",
                paid: "LE 60.00",
                remaining: "LE 60.00"
            },
            {
                id: 3,
                date: "10/6/2024, 10:15 AM",
                teacher: "Dr. Ahmed Hassan",
                course: "IGCSE Mathematics",
                session: "May/June 2026",
                student: "Ahmed Mohamed",
                parent: "Mohamed Ahmed",
                total: "LE 2,500.00",
                paid: "LE 2,500.00",
                remaining: "LE 0.00"
            },
            {
                id: 4,
                date: "10/5/2024, 1:20 PM",
                teacher: "Dr. Mohamed Ali",
                course: "IB Chemistry HL",
                session: "May/June 2026",
                student: "Layla Hassan",
                parent: "Hassan Ali",
                total: "LE 150.00",
                paid: "LE 75.00",
                remaining: "LE 75.00"
            },
            {
                id: 5,
                date: "10/4/2024, 9:30 AM",
                teacher: "Prof. Sarah Johnson",
                course: "SAT Math Prep",
                session: "May/June 2026",
                student: "Michael Chen",
                parent: "Lisa Chen",
                total: "LE 200.00",
                paid: "LE 200.00",
                remaining: "LE 0.00"
            },
        ];

        const reports = [
            {
                id: 1,
                date: "09/25/2024",
                teacher: "Dr. Ahmed Hassan",
                course: "IGCSE Math",
                session: "May/June 2026",
                student: "Emma Jones",
                parent: "Sam Jones",
                total: "LE 500.00",
                paid: "LE 400.00",
                remaining: "LE 100.00"
            },
            {
                id: 2,
                date: "09/22/2024",
                teacher: "Prof. Sarah Johnson",
                course: "A-Level Physics",
                session: "May/June 2026",
                student: "Ali Khan",
                parent: "Waqas Khan",
                total: "LE 350.00",
                paid: "LE 350.00",
                remaining: "LE 0.00"
            },
        ];

        const payouts = [
            {
                id: 1,
                date: "10/10/2024",
                teacher: "Dr. Ahmed Hassan",
                course: "IGCSE Math",
                session: "May/June 2026",
                student: "-",
                parent: "-",
                total: "LE 2,000.00",
                paid: "LE 2,000.00",
                remaining: "LE 0.00"
            },
        ];

        const balances = [
            {
                id: 1,
                date: "10/1/2024",
                teacher: "Prof. Sarah Johnson",
                course: "SAT Math Prep",
                session: "May/June 2026",
                student: "Michael Chen",
                parent: "Lisa Chen",
                total: "LE 500.00",
                paid: "LE 200.00",
                remaining: "LE 300.00"
            },
        ];


        const tableBody = document.getElementById("data-body");
        const tableTitle = document.getElementById("table-title");
        const tabs = document.querySelectorAll(".btn-outline-primary");
        const searchInput = document.getElementById("search");
        const tableContainer = document.querySelector(".table-responsive");

        let currentData = transactions;

        function renderTable(data) {
            tableBody.innerHTML = data.map(item => `
        <tr>
          <td>${item.id}</td>
          <td>${item.date}</td>
          <td>${item.teacher}</td>
          <td>${item.course}</td>
          <td>${item.session}</td>
          <td>${item.student}</td>
          <td>${item.parent}</td>
          <td>${item.total}</td>
          <td>${item.paid}</td>
          <td>${item.remaining}</td>
          <td><button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button></td>
        </tr>
      `).join("");
        }

        function switchTab(tabId, title, data) {
            tabs.forEach(btn => btn.classList.remove("active"));
            document.getElementById(tabId).classList.add("active");
            tableTitle.textContent = `All ${title}`;
            currentData = data;
            renderTable(currentData);
        }

        document.getElementById("tab-transactions").addEventListener("click", () => switchTab("tab-transactions", "Transactions", transactions));
        document.getElementById("tab-reports").addEventListener("click", () => switchTab("tab-reports", "Reports", reports));
        document.getElementById("tab-payouts").addEventListener("click", () => switchTab("tab-payouts", "Payouts", payouts));
        document.getElementById("tab-balances").addEventListener("click", () => switchTab("tab-balances", "Balances", balances));

        // Search filter
       
// Create “No record found” message element
const noRecordMsg = document.createElement("div");
noRecordMsg.textContent = "Sorry, no record found.";
noRecordMsg.className = "alert alert-danger text-center py-2 mt-3";
noRecordMsg.style.display = "none";
tableContainer.parentElement.appendChild(noRecordMsg);

searchInput.addEventListener("keyup", (e) => {
  const keyword = e.target.value.toLowerCase().trim();

  const filtered = currentData.filter(item =>
    Object.values(item).some(value =>
      value.toString().toLowerCase().includes(keyword)
    )
  );

  renderTable(filtered);

  // Show or hide "no record" message
  if (filtered.length === 0) {
    noRecordMsg.style.display = "block";
    setTimeout(() => {
      noRecordMsg.style.display = "none";
    }, 3000);
  } else {
    noRecordMsg.style.display = "none";
  }
});
        // Initial render
        renderTable(currentData);

    </script>




@endsection