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


            <div class="mb-3 d-flex gap-2">
                <button id="btnNotImported" class="btn btn-primary btn-sm">Not Imported</button>
                <button id="btnImported" class="btn btn-success btn-sm">Imported</button>
            </div>


            <div class="table-responsive">
                <table class="table align-middle table-hover" id="transactionsTable">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Student Name</th>
                            <th>Parent Name</th>
                            <th>Email</th>
                            <th>WhatsApp</th>
                            <th>Course</th>
                            <th>Total</th>
                            <th>Paid Amount</th>
                            <th>Currency</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expressCourses as $expressCourse)
                        <tr>
                            <td>{{ $expressCourse->id }}</td>
                            <td>{{ $expressCourse->name }}</td>
                            <td>{{ $expressCourse->parent_name }}</td>
                            <td>{{ $expressCourse->email }}</td>
                            <td>{{ $expressCourse->whatsapp }}</td>
                            <td>{{ $expressCourse->course}}</td>
                            <td>{{ $expressCourse->origional_price_amount }}</td>
                            <td>{{ $expressCourse->payments->first()->paid_amount ?? 'N/A' }}</td>
                            <td>{{ $expressCourse->origional_price_currency }}</td>
                            <td class="text-end">
                                <div class="d-flex gap-2 justify-content-end">
                                    <!-- Button to open modal -->
                                    <button type="button" class="btn btn-sm px-2 py-1 btn-payment"
                                        style="background: #e8f0fe; border-radius: 6px; border: 1px solid #d0d7ff;"
                                        @if(!$expressCourse->has_transaction)
                                        data-bs-toggle="modal" data-bs-target="#transactionsModal"
                                        @endif>
                                        <i class="fa-solid fa-file-import text-primary"></i>
                                        @if($expressCourse->has_transaction)
                                        imported
                                        @else
                                        import
                                        @endif


                                    </button>


                                    {{-- <button class="btn btn-sm px-2 py-1"
                                        style="background:#e6f4ea; border-radius:6px;">
                                        <i class="fa-solid fa-credit-card text-success"></i>
                                    </button> --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>



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

                    <input type="hidden" name="expressCourse_id" id="expressCourse_id">

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
                                @foreach ($courses as $course)
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

                        <!-- Currency -->
                        <div class="col-md-6">
                            <label class="form-label">Currency</label>
                            <select class="form-select" name="selected_currency_id" id="transaction_currency">
                                <option selected disabled>Select Currency</option>
                                @foreach ($currency_datas as $currency)
                                <option value="{{ $currency->id }}">{{ $currency->currency_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Student Name -->
                        <div class="col-md-6">
                            <label class="form-label">Student</label>
                            <input type="text" class="form-control" name="student_name" id="transaction_student">
                        </div>

                        <!-- Parent Name -->
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
                            <input type="email" class="form-control" name="student_email" id="transaction_student_email"
                                placeholder="Enter email address">
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
                            <input type="number" class="form-control" name="total" id="transaction_total" step="0.01"
                                readonly>
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


{{-- <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
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
</div> --}}
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Payment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <table class="table table-bordered text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Date & Time</th>
                            <th>Paid Amount</th>
                            <th>Original Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="modalDateTime"></td>
                            <td id="modalPaidAmount"></td>
                            <td id="modalOriginalAmount"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>
    $(document).ready(function() {

    // Open modal and populate fields
    $('.btn-payment').on('click', function() {
        var $tr = $(this).closest('tr');

        // Get values from table row
        var expressCourseId = $tr.find('td:nth-child(1)').text().trim();
        var studentName = $tr.find('td:nth-child(2)').text().trim();
        var parentName = $tr.find('td:nth-child(3)').text().trim();
        var studentEmail = $tr.find('td:nth-child(4)').text().trim();  // Email
        var studentContact = $tr.find('td:nth-child(5)').text().trim(); // WhatsApp
        var courseName = $tr.find('td:nth-child(6)').text().trim();
        var courseFee = parseFloat($tr.find('td:nth-child(7)').text().trim()) || 0;
        var paidAmount = parseFloat($tr.find('td:nth-child(8)').text().trim()) || 0;
        var currencyText = $tr.find('td:nth-child(9)').text().trim();

        // Fill modal fields
        $('#expressCourse_id').val(expressCourseId);
        $('#transaction_student').val(studentName);
        $('#transaction_parent').val(parentName);
        $('#transaction_student_email').val(studentEmail);        // Email field
        $('#transaction_student_contact').val(studentContact);    // Contact field
        $('#transaction_course_fee').val(courseFee.toFixed(2));
        $('#transaction_note_fee').val(''); // empty initially
        $('#transaction_total').val(courseFee.toFixed(2));
        $('#transaction_paid').val(paidAmount.toFixed(2));

        // Select the correct currency
        $('#transaction_currency option').each(function() {
            $(this).prop('selected', $(this).text().trim() === currencyText);
        });

        // Calculate remaining
        function updateRemaining() {
            var total = parseFloat($('#transaction_total').val()) || 0;
            var paid = parseFloat($('#transaction_paid').val()) || 0;
            var remaining = Math.max(total - paid, 0);
            $('#transaction_remaining').val(remaining.toFixed(2));
        }
        updateRemaining();

        // Recalculate total when note_fee changes
        $('#transaction_note_fee').off('input').on('input', function() {
            var noteFee = parseFloat($(this).val()) || 0;
            var total = (courseFee + noteFee);
            $('#transaction_total').val(total.toFixed(2));
            updateRemaining();
        });

        // Recalculate remaining in real-time when Paid changes
        $('#transaction_paid').off('input').on('input', function() {
            var paid = parseFloat($(this).val()) || 0;
            var total = parseFloat($('#transaction_total').val()) || 0;

            if(paid > total) paid = total;
            $(this).val(paid.toFixed(2));

            updateRemaining();
        });
    });


    // Submit form via AJAX
    $('#transactionsForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('express_course.transaction.store') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                if(response.status === 'success') {
                    alert('Transaction saved successfully!');
                    $('#transactionsModal').modal('hide');
                    $('#transactionsForm')[0].reset();

                    let transaction = response.data;
                    let expressCourseId = transaction.express_course_id;

                    let $row = $('#transactionsTable tbody tr').filter(function() {
                        return $(this).find('td:first').text().trim() == expressCourseId;
                    });

                    if($row.length) {
                       let paidAmount = parseFloat(transaction.paid_amount) || 0;
                       let noteFee = parseFloat(transaction.note_fee) || 0;
                       let totalPaid = paidAmount + noteFee;
                       $row.find('td:nth-child(6)').text(totalPaid.toFixed(2));

                        // Update button -> imported & disable modal
                        let $btn = $row.find('.btn-payment');
                        $btn.html('<i class="fa-solid fa-file-import text-primary"></i> imported');
                        $btn.removeAttr('data-bs-toggle').removeAttr('data-bs-target');
                        $btn.prop('disabled', true).css({ opacity: 0.6, cursor: 'not-allowed' });
                    }
                } else {
                    alert('Something went wrong!');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let resp = xhr.responseJSON;

                    if (resp.errors) {
                        let messages = [];
                        $.each(resp.errors, function(key, value){
                            messages.push(value[0]);
                        });
                        alert(messages.join("\n"));
                    } else if (resp.message) {
                        alert(resp.message); // <-- This will show "A transaction already exists..."
                    }
                } else {
                    alert('An error occurred. Please try again.');
                }
            }

        });
    });

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
<script>
    $(document).ready(function() {

        // Function to filter table
        function filterTable(showImported) {
            $('#transactionsTable tbody tr').each(function() {
                var isImported = $(this).find('.btn-payment').text().trim().toLowerCase().includes('imported');
                if(showImported) {
                    $(this).toggle(isImported); // show only imported
                } else {
                    $(this).toggle(!isImported); // show only not imported
                }
            });
        }

        // By default, show only Not Imported courses
        filterTable(false);

        // Button clicks
        $('#btnNotImported').on('click', function() {
            filterTable(false);
        });

        $('#btnImported').on('click', function() {
            filterTable(true);
        });
    });
</script>








@endsection
