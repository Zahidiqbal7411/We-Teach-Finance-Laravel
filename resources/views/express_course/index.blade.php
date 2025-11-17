@extends('layouts.app')

@section('contents')
    <div class="main-content p-4" style="margin-left: 260px; min-height: 100vh; background: #f8f9fa;">

        <!-- ✅ Top Bar -->
        <div class="teacher-topbar d-flex justify-content-between align-items-center mb-4 p-3"
            style="background: #ffffff; border-radius: 10px;">
            <div>
                <h4 class="fw-semibold mb-0">Express Course</h4>
            </div>

        </div>



        <!-- ✅ Platform Reports Section -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <h5 class="fw-semibold mb-2 mb-md-0">All Express Courses Record</h5>

                </div>


                <div class="input-group mb-3">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fa-solid fa-search"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" id="searchInput"
                        placeholder="Search express course...">
                </div>




                <div class="table-responsive">
                    <table class="table align-middle table-hover" id="transactionsTable">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Student Name</th>
                                <th>Parent Name</th>
                                <th>Course</th>
                                <th>Total</th>
                                <th>Paid Amount</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be injected by AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Payment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Date & Time:</strong> <span id="modalDateTime"></span></p>
                    <p><strong>Paid Amount:</strong> $<span id="modalPaidAmount"></span></p>
                    <p><strong>Original Amount:</strong> $<span id="modalOriginalAmount"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- This is the ajax for loading transaction related to express course --}}


    <script>
        $(document).ready(function() {
            let transactionsData = []; // store AJAX data globally

            function renderTable(data) {
                let tbody = '';
                data.forEach(function(transaction) {
                    let express_course = transaction.express_course;
                    let course = transaction.course;

                    tbody += `
                <tr>
                    <td>${transaction.id}</td>
                    <td>${transaction.student_name}</td>
                    <td>${transaction.parent_name}</td>
                    <td>${course ? course.course_title : ''}</td>
                    <td>$${transaction.total}</td>
                    <td>$${transaction.paid_amount}</td>
                    <td class="text-end">
                        <div class="d-flex gap-2 justify-content-end">
                            <button class="btn btn-sm px-2 py-1 btn-payment" 
                                style="background:#e8f0fe; border-radius:6px;"
                                data-date="${express_course.timestamp_req || ''}"
                                data-paid="${express_course.paid_amount || 0}"
                                data-original="${express_course.original_amount || 0}">
                                <i class="fa-solid fa-file-import text-primary"></i>
                            </button>
                            <button class="btn btn-sm px-2 py-1" style="background:#e6f4ea; border-radius:6px;">
                                <i class="fa-solid fa-credit-card text-success"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
                });

                $('#transactionsTable tbody').html(tbody);

                // Reattach click event for modal
                $('.btn-payment').click(function() {
                    const btn = $(this);
                    $('#modalDateTime').text(btn.data('date'));
                    $('#modalPaidAmount').text(btn.data('paid'));
                    $('#modalOriginalAmount').text(btn.data('original'));
                    new bootstrap.Modal(document.getElementById('paymentModal')).show();
                });
            }

            // Load transactions via AJAX
            $.ajax({
                url: "{{ route('express_courses.index') }}",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        transactionsData = response.data;
                        renderTable(transactionsData);
                    } else {
                        $('#transactionsTable tbody').html(
                            '<tr><td colspan="7" class="text-center">No transactions found.</td></tr>'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: " + error);
                    $('#transactionsTable tbody').html(
                        '<tr><td colspan="7" class="text-center text-danger">Error loading data.</td></tr>'
                    );
                }
            });

            // Search functionality
            $('#searchInput').on('keyup', function() {
                const searchTerm = $(this).val().toLowerCase();
                const filteredData = transactionsData.filter(transaction => {
                    const courseTitle = transaction.course ? transaction.course.course_title
                        .toLowerCase() : '';
                    const studentName = transaction.student_name.toLowerCase();
                    const parentName = transaction.parent_name.toLowerCase();
                    return courseTitle.includes(searchTerm) || studentName.includes(searchTerm) ||
                        parentName.includes(searchTerm);
                });
                renderTable(filteredData);
            });
        });
    </script>

    {{-- This is the script for showing import express course --}}
    <script>
        document.getElementById('showPaymentBtn').addEventListener('click', function() {
            // Example data – replace these with dynamic data as needed
            const dateTime = new Date().toLocaleString(); // Current date & time
            const paidAmount = 120; // Replace with actual paid amount
            const originalAmount = 150; // Replace with actual original amount

            // Set modal content
            document.getElementById('modalDateTime').innerText = dateTime;
            document.getElementById('modalPaidAmount').innerText = paidAmount;
            document.getElementById('modalOriginalAmount').innerText = originalAmount;

            // Show modal
            const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
            paymentModal.show();
        });
    </script>

    {{-- This is the script for debugging --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log("Platform Report page loaded successfully");
        });
    </script>
@endsection
