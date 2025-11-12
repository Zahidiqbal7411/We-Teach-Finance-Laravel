 <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ================== Original Elements ==================
            const teacherSelect = document.getElementById('teacherSelect');
            const sessionSelect = document.getElementById('SelectYear');
            const noTeacherSelected = document.getElementById('noTeacherSelected');
            const teacherData = document.getElementById('teacherData');

            const teacherNameTag = document.getElementById('teacher_name');
            const teacherModalNameTag = document.getElementById('transaction_teacher');
            const teacherEmailTag = document.getElementById('teacher_email');

            const mainTabContainer = document.getElementById('mainTabContainer');
            const mainTabBtns = document.querySelectorAll('#mainTabContainer .tab-btn');

            const subTabContainer = document.getElementById('subTabContainer');
            const subRecent = document.getElementById('sub-recent');
            const subPerCourse = document.getElementById('sub-percourse');

            const sections = ['transactionsDiv', 'payoutsDiv', 'balancesDiv', 'reportsDiv'];

            const transactionsDiv = document.getElementById('transactionsDiv');
            const thead = document.getElementById('transactionsThead');
            const tbody = document.getElementById('transactionsTableBody');

            const originalHead = thead.innerHTML;
            const originalBody = tbody.innerHTML;

            const perCourseHead = `
            <tr>
                <th>Course Name</th>
                <th>Session</th>
                <th>Transactions</th>
                <th>Total Amount</th>
                <th>Total Paid</th>
                <th>Total Remaining</th>
                <th>Actions</th>
            </tr>`;

            // ================== Utility Functions ==================
            function showSection(target, subTab = null) {
                sections.forEach(id => {
                    const el = document.getElementById(id);
                    if (!el) return;
                    el.style.display = (id === target) ? 'block' : 'none';
                });

                if (target === 'transactionsDiv') {
                    subTabContainer.style.display = 'flex';
                    if (subTab === 'percourse') activateSub('percourse');
                    else activateSub('recent');
                } else {
                    subTabContainer.style.display = 'none';
                    subRecent.classList.remove('active');
                    subPerCourse.classList.remove('active');
                    restoreOriginalTransactions();
                }
            }

            function activateMainTab(button) {
                mainTabBtns.forEach(b => b.classList.remove('active'));
                if (button) button.classList.add('active');
                const target = button ? button.dataset.target : 'transactionsDiv';
                showSection(target);
            }

            function activateSub(which) {
                if (which === 'recent') {
                    subRecent.classList.add('active');
                    subPerCourse.classList.remove('active');
                    restoreOriginalTransactions();
                } else if (which === 'percourse') {
                    subPerCourse.classList.add('active');
                    subRecent.classList.remove('active');
                }
            }

            function restoreOriginalTransactions() {
                thead.innerHTML = originalHead;
                tbody.innerHTML = originalBody;
                attachDeleteHandlers();
            }

            function showCourseDetails(course = null) {
                let detailCard = transactionsDiv.querySelector('.detail-card-custom');
                if (!detailCard) {
                    detailCard = document.createElement('div');
                    detailCard.className = 'card border-0 shadow-sm mt-3 p-3 detail-card-custom';
                    detailCard.innerHTML = `
            <div class="detail-content">
                <h6 class="fw-semibold mb-2">Transaction Details</h6>
                <div class="detail-body"></div>
                <div class="text-end mt-2">
                    <button class="btn btn-sm btn-outline-dark closeDetail">Close</button>
                </div>
            </div>`;
                    transactionsDiv.querySelector('.card-body').appendChild(detailCard);

                    detailCard.querySelector('.closeDetail').addEventListener('click', () => {
                        detailCard.style.display = 'none';
                    });
                }

                if (!course) course = {
                    transactions_details: []
                };

                let rows = '';
                (course.transactions_details || []).forEach(tx => {
                    rows += `
            <tr>
                <td>${tx.id}</td>
                <td>${tx.date}</td>
                <td>${tx.student}</td>
                <td>${tx.total} (${tx.currency})</td>
                <td>${tx.paid} (${tx.currency})</td>
                <td>${tx.remaining} (${tx.currency})</td>
            </tr>`;
                });

                detailCard.querySelector('.detail-body').innerHTML = `
        <table class="table table-hover table-bordered mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Date/Time</th>
                    <th>Student</th>
                    <th>Total</th>
                    <th>Paid</th>
                    <th>Remaining</th>
                </tr>
            </thead>
            <tbody>${rows}</tbody>
        </table>`;
                detailCard.style.display = 'block';
            }

            function attachDeleteHandlers() {
                const deletes = document.querySelectorAll('button.btn-outline-danger');
                deletes.forEach(btn => {
                    if (!btn.dataset.handlerAttached) {
                        btn.addEventListener('click', function(e) {
                            if (!confirm('Are you sure you want to delete this row?')) e
                                .preventDefault();
                        });
                        btn.dataset.handlerAttached = '1';
                    }
                });
            }

            // ================== Fetch Recent Transactions ==================
            function fetchTransactions(teacherId, sessionId = null, currencyId = null) {
                if (!teacherId) return;
                let url = `/teachers/${teacherId}`;
                const params = [];
                if (sessionId) params.push(`session_id=${sessionId}`);
                if (currencyId) params.push(`currency_id=${currencyId}`);
                if (params.length) url += `?${params.join('&')}`;

                fetch(url)
                    .then(resp => resp.json())
                    .then(data => {
                        if (teacherNameTag) teacherNameTag.textContent = data.teacher?.name || 'N/A';
                        if (teacherEmailTag) teacherEmailTag.textContent = data.teacher?.email || 'N/A';
                        if (teacherModalNameTag) teacherModalNameTag.value = data.teacher?.name || '';

                        const teacherIdInput = document.getElementById('transaction_teacher_id');
                        if (teacherIdInput) teacherIdInput.value = teacherId;

                        const transactions = data.transactions || [];
                        tbody.innerHTML = '';

                        if (transactions.length === 0) {
                            tbody.innerHTML =
                                `<tr><td colspan="11" class="text-center">No transactions available for the selected session</td></tr>`;
                            return;
                        }

                        transactions.forEach(tx => {
                            tbody.innerHTML += `
                    <tr data-id="${tx.id}">
                        <td><input type="checkbox"></td>
                        <td>${tx.id}</td>
                        <td>${tx.date}</td>
                        <td>${tx.course}</td>
                        <td>${tx.session}</td>
                        <td>${tx.student}</td>
                        <td>${tx.parent}</td>
                        <td>${tx.total} (${tx.currency})</td>
                        <td class="paid-cell">${tx.paid} (${tx.currency})</td>
                        <td class="remaining-cell">${tx.remaining} (${tx.currency})</td>
                        <td class="text-center">
                            <button class="btn btn-sm icon-btn restore-btn" 
                                data-id="${tx.id}" 
                                data-total="${tx.total}" 
                                data-paid="${tx.paid}">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>`;
                        });
                        attachDeleteHandlers();
                    })
                    .catch(err => console.error('Error fetching teacher data:', err));
            }

            // ================== Fetch Per Course ==================
            function fetchPerCourse(teacherId, sessionId = null, currencyId = null) {
                if (!teacherId) return;

                let url = `/teachers/${teacherId}/percourse`;
                const params = [];
                if (sessionId) params.push(`session_id=${sessionId}`);
                if (currencyId) params.push(`currency_id=${currencyId}`);
                if (params.length) url += `?${params.join('&')}`;

                fetch(url)
                    .then(resp => resp.json())
                    .then(data => {
                        const courses = data.courses || [];

                        thead.innerHTML = perCourseHead;
                        tbody.innerHTML = '';

                        courses.forEach((course, idx) => {
                            tbody.innerHTML += `
                    <tr class="course-row" data-idx="${idx}" data-id="${course.transactions_details[0]?.id || ''}">
                        <td>${course.name}</td>
                        <td>${course.session}</td>
                        <td>${course.transactions}</td>
                        <td>${course.total_amount}</td>
                        <td class="paid-cell">${course.total_paid}</td>
                        <td class="remaining-cell">${course.total_remaining}</td>
                        <td class="text-center">
                            <button class="btn btn-sm icon-btn restore-btn" 
                                data-id="${course.transactions_details[0]?.id || ''}" 
                                data-total="${course.total_amount}" 
                                data-paid="${course.total_paid}">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </button>
                            <button class="btn btn-sm btn-dark viewCourseDetails" data-idx="${idx}">View</button>
                        </td>
                    </tr>`;
                        });

                        tbody.querySelectorAll('.viewCourseDetails').forEach(btn => {
                            btn.addEventListener('click', e => {
                                e.stopPropagation();
                                const idx = btn.dataset.idx;
                                showCourseDetails(courses[idx]);
                            });
                        });

                        tbody.querySelectorAll('.course-row').forEach(row => {
                            row.addEventListener('click', e => {
                                if (e.target.closest('.restore-btn')) return;
                                const idx = row.dataset.idx;
                                showCourseDetails(courses[idx]);
                            });
                        });
                    })
                    .catch(err => console.error('Error fetching per-course data:', err));
            }

            // ================== Restore Modal Functionality ==================
            function openRestoreModal(transaction = null) {
                const restoreModal = new bootstrap.Modal(document.getElementById('restoreModal'));
                const restoreTransactionId = document.getElementById('restoreTransactionId');
                const restoreTotal = document.getElementById('restoreTotal');
                const restorePaidReadonly = document.getElementById('restorePaidReadonly');
                const restorePaid = document.getElementById('restorePaid');
                const restoreRemaining = document.getElementById('restoreRemaining');

                if (transaction) {
                    restoreTransactionId.value = transaction.id || '';
                    restoreTotal.value = transaction.total || 0;
                    restorePaidReadonly.value = transaction.paid || 0;
                    restorePaid.value = 0;
                    restoreRemaining.value = transaction.total - transaction.paid || 0;
                }

                restorePaid.addEventListener('input', function() {
                    const newPaid = parseFloat(this.value) || 0;
                    const total = parseFloat(restoreTotal.value) || 0;
                    const paid = parseFloat(restorePaidReadonly.value) || 0;
                    restoreRemaining.value = total - paid - newPaid;
                });

                // Show modal only. Submit handling is consolidated in the separate
                // restore form script below to avoid duplicate requests/handlers.
                restoreModal.show();
            }

            // Note: opening the restore modal is handled by the consolidated
            // click handler later in the file. Removed this earlier duplicate
            // listener to avoid conflicting handlers.

            // ================== Event Listeners ==================
            mainTabBtns.forEach(btn => btn.addEventListener('click', () => activateMainTab(btn)));

            subRecent.addEventListener('click', () => {
                activateSub('recent');
                const teacherId = document.getElementById('transaction_teacher_id')?.value;
                if (!teacherId) return;
                fetchTransactions(teacherId, sessionSelect?.value, document.getElementById('currencySelect')
                    ?.value);
            });

            subPerCourse.addEventListener('click', () => {
                activateSub('percourse');
                const teacherId = document.getElementById('transaction_teacher_id')?.value;
                if (!teacherId) return;
                fetchPerCourse(teacherId, sessionSelect?.value, document.getElementById('currencySelect')
                    ?.value);
            });

            teacherSelect.addEventListener('change', function() {
                const teacherId = this.value;
                if (!teacherId) {
                    noTeacherSelected.style.display = 'block';
                    teacherData.style.display = 'none';
                    subTabContainer.style.display = 'none';
                    return;
                }

                noTeacherSelected.style.display = 'none';
                teacherData.style.display = 'block';

                const transBtn = Array.from(mainTabBtns).find(b => b.dataset.target === 'transactionsDiv');
                activateMainTab(transBtn || mainTabBtns[0]);

                const sessionId = sessionSelect?.value;
                const currencyId = document.getElementById('currencySelect')?.value;

                if (subPerCourse.classList.contains('active')) {
                    fetchPerCourse(teacherId, sessionId, currencyId);
                } else {
                    fetchTransactions(teacherId, sessionId, currencyId);
                }
            });

            if (sessionSelect) {
                sessionSelect.addEventListener('change', function() {
                    const teacherId = document.getElementById('transaction_teacher_id')?.value;
                    if (!teacherId) return;

                    const sessionId = this.value;
                    const currencyId = document.getElementById('currencySelect')?.value;

                    if (subPerCourse.classList.contains('active')) {
                        thead.innerHTML = perCourseHead;
                        tbody.innerHTML = '';
                        fetchPerCourse(teacherId, sessionId, currencyId);
                    } else {
                        fetchTransactions(teacherId, sessionId, currencyId);
                    }
                });
            }

            const currencySelect = document.getElementById('currencySelect');
            if (currencySelect) {
                currencySelect.addEventListener('change', function() {
                    const teacherId = document.getElementById('transaction_teacher_id')?.value;
                    if (!teacherId) return;

                    if (subPerCourse.classList.contains('active')) {
                        fetchPerCourse(teacherId, sessionSelect?.value, this.value);
                    } else {
                        fetchTransactions(teacherId, sessionSelect?.value, this.value);
                    }
                });
            }

            // ================== Initial State ==================
            subTabContainer.style.display = 'none';
            attachDeleteHandlers();

            // ===== Fixed: Load latest server data on page refresh =====
            const initialTeacherId = teacherSelect?.value;
            if (initialTeacherId) {
                noTeacherSelected.style.display = 'none';
                teacherData.style.display = 'block';
                subTabContainer.style.display = 'flex';

                // Force Recent tab active
                subRecent.classList.add('active');
                subPerCourse.classList.remove('active');

                const sessionId = sessionSelect?.value;
                const currencyId = document.getElementById('currencySelect')?.value;

                // Fetch recent transactions for selected teacher
                fetchTransactions(initialTeacherId, sessionId, currencyId);
            }
        });
        window.fetchTransactions = fetchTransactions;
        window.fetchPerCourse = fetchPerCourse;
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('=== Restore Modal Script Started ===');

            // ========== PARSE AMOUNT FROM CELL ==========
            function parseAmountFromCell(cell) {
                if (!cell || !cell.textContent) return 0;
                const text = cell.textContent.trim();
                const match = text.match(/([\d,]+\.?\d*)\s*\(/);
                if (match) return parseFloat(match[1].replace(/,/g, '')) || 0;
                const numMatch = text.match(/([\d,]+\.?\d*)/);
                if (numMatch) return parseFloat(numMatch[1].replace(/,/g, '')) || 0;
                return 0;
            }

            // ========== GET CURRENCY FROM CELL ==========
            function getCurrencyFromCell(cell) {
                if (!cell || !cell.textContent) return '';
                const text = cell.textContent.trim();
                const match = text.match(/\(([A-Z]{3})\)/);
                return match ? ` (${match[1]})` : '';
            }

            // ========== HANDLE RESTORE BUTTON CLICK ==========
            document.addEventListener('click', function(e) {
                const restoreBtn = e.target.closest('.restore-btn');
                if (!restoreBtn) return;

                e.stopPropagation();
                e.preventDefault();

                const transactionId = restoreBtn.dataset.id;
                const row = restoreBtn.closest('tr');

                if (!transactionId || !row) {
                    alert('Error: Cannot find transaction data');
                    return;
                }

                const isCourse = row.classList.contains('course-row');

                let totalCell, paidCell, remainingCell;

                if (isCourse) {
                    totalCell = row.cells[3];
                    paidCell = row.cells[4];
                    remainingCell = row.cells[5];
                } else {
                    totalCell = row.cells[7];
                    paidCell = row.cells[8];
                    remainingCell = row.cells[9];
                }

                const totalAmount = parseAmountFromCell(totalCell);
                const paidAmount = parseAmountFromCell(paidCell);
                const remainingAmount = totalAmount - paidAmount;

                const currencySuffix = getCurrencyFromCell(totalCell) || getCurrencyFromCell(paidCell) ||
                    getCurrencyFromCell(remainingCell);

                // Fill modal inputs
                const restoreTransactionId = document.getElementById('restoreTransactionId');
                const restoreTotal = document.getElementById('restoreTotal');
                const restorePaidReadonly = document.getElementById('restorePaidReadonly');
                const restorePaid = document.getElementById('restorePaid');
                const restoreRemaining = document.getElementById('restoreRemaining');

                if (restoreTransactionId) restoreTransactionId.value = transactionId;
                if (restoreTotal) restoreTotal.value = totalAmount;
                if (restorePaidReadonly) restorePaidReadonly.value = paidAmount;
                if (restorePaid) restorePaid.value = '';
                if (restoreRemaining) restoreRemaining.value = remainingAmount;

                // Show modal
                const restoreModalEl = document.getElementById('restoreModal');
                if (restoreModalEl) {
                    const restoreModal = new bootstrap.Modal(restoreModalEl);
                    restoreModal.show();
                }
            });

            // ========== HANDLE INPUT CHANGES ==========
            const restorePaidInput = document.getElementById('restorePaid');
            if (restorePaidInput) {
                restorePaidInput.addEventListener('input', function() {
                    const newPaid = parseFloat(this.value) || 0;
                    const total = parseFloat(document.getElementById('restoreTotal')?.value) || 0;
                    const currentPaid = parseFloat(document.getElementById('restorePaidReadonly')?.value) ||
                        0;
                    const remaining = total - currentPaid - newPaid;
                    const restoreRemaining = document.getElementById('restoreRemaining');
                    if (restoreRemaining) restoreRemaining.value = remaining >= 0 ? remaining : 0;
                });
            }

            // ========== HANDLE FORM SUBMIT ==========
            const restoreForm = document.getElementById('restoreForm');
            if (!restoreForm) return;

            restoreForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const transactionId = document.getElementById('restoreTransactionId')?.value;
                const newPaidValue = document.getElementById('restorePaid')?.value;
                const newPaid = parseFloat(newPaidValue) || 0;

                if (!transactionId || !newPaidValue || newPaid <= 0) {
                    alert('Please enter a valid amount and ensure transaction ID exists');
                    return;
                }

                const subPerCourse = document.getElementById('sub-percourse');
                const isCourse = subPerCourse && subPerCourse.classList.contains('active');
                const endpoint = isCourse ? '/transactions/restore-percourse' : '/transactions/restore';

                try {
                    const response = await fetch(endpoint, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                ?.getAttribute('content') || ''
                        },
                        body: JSON.stringify({
                            transaction_id: transactionId,
                            new_paid: newPaid
                        })
                    });

                    const data = await response.json();

                    if (!response.ok || !data.success) {
                        const errorMsg = data.message || 'An error occurred';
                        alert('Error: ' + errorMsg);
                        return;
                    }

                    // Update any table rows that match this transaction ID (covers
                    // recent list and per-course rows). Update restore-btn dataset
                    // so subsequent opens show correct values.
                    const updatedPaid = parseFloat(data.transaction?.paid ?? data.paid) || 0;
                    const updatedRemaining = parseFloat(data.transaction?.remaining ?? data.remaining) || 0;

                    // Find buttons matching the transaction id and update their rows
                    const restoreButtons = Array.from(document.querySelectorAll(`button.restore-btn[data-id="${transactionId}"]`));
                    if (restoreButtons.length) {
                        restoreButtons.forEach(btn => {
                            const r = btn.closest('tr');
                            if (!r) return;

                            const paidCell = r.querySelector('.paid-cell');
                            const remainingCell = r.querySelector('.remaining-cell');
                            const currency = getCurrencyFromCell(paidCell) || getCurrencyFromCell(remainingCell) || '';

                            if (paidCell) paidCell.textContent = `${updatedPaid}${currency}`;
                            if (remainingCell) remainingCell.textContent = `${updatedRemaining}${currency}`;

                            // update dataset so next modal open reads correct values
                            btn.dataset.paid = updatedPaid;
                            if (data.transaction && data.transaction.total !== undefined) btn.dataset.total = data.transaction.total;
                        });
                    } else {
                        // Fallback: try to find any table row with data-id attr
                        const rows = Array.from(document.querySelectorAll(`tr[data-id="${transactionId}"]`));
                        rows.forEach(r => {
                            const paidCell = r.querySelector('.paid-cell');
                            const remainingCell = r.querySelector('.remaining-cell');
                            const currency = getCurrencyFromCell(paidCell) || getCurrencyFromCell(remainingCell) || '';
                            if (paidCell) paidCell.textContent = `${updatedPaid}${currency}`;
                            if (remainingCell) remainingCell.textContent = `${updatedRemaining}${currency}`;
                        });
                    }

                    // ========== CLOSE & CLEAR MODAL ==========
                    const restoreModalEl = document.getElementById('restoreModal');
                    if (restoreModalEl) {
                        const restoreModal = bootstrap.Modal.getInstance(restoreModalEl) ||
                            new bootstrap.Modal(restoreModalEl);

                        // Clear inputs AFTER modal fully hidden
                        restoreModalEl.addEventListener('hidden.bs.modal', function clearModalInputs() {
                            const fieldsToClear = [
                                'restoreTransactionId',
                                'restoreTotal',
                                'restorePaidReadonly',
                                'restorePaid',
                                'restoreRemaining'
                            ];
                            fieldsToClear.forEach(id => {
                                const el = document.getElementById(id);
                                if (el) el.value = '';
                            });
                            restoreModalEl.removeEventListener('hidden.bs.modal',
                                clearModalInputs);
                        });

                        restoreModal.hide();
                    }

                    alert('Transaction updated successfully!');

                    // Refresh table from server
                    const teacherId = document.getElementById('transaction_teacher_id')?.value;
                    const sessionId = document.getElementById('SelectYear')?.value;
                    const currencyId = document.getElementById('currencySelect')?.value;

                    if (teacherId && window.fetchTransactions) {
                        setTimeout(() => {
                            if (isCourse && window.fetchPerCourse) {
                                window.fetchPerCourse(teacherId, sessionId, currencyId);
                            } else {
                                window.fetchTransactions(teacherId, sessionId, currencyId);
                            }
                        }, 500);
                    }

                } catch (err) {
                    console.error('AJAX Error:', err);
                    alert('An error occurred. Check console for details.');
                }
            });

            console.log('=== Restore Modal Script Completed ===\n');
        });
    </script>
    