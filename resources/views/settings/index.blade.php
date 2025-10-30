  @extends('layouts.app')


  @section('contents')
      <div class="main-content">
          <div class="topbar p-3">
              <div class="d-flex justify-content-between align-items-center">
                  <h4 class="fw-semibold mb-0">Dashboard</h4>
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
                      <h4 class="fw-semibold mb-0">Settings</h4>
                      <small class="text-muted">Configure system settings and manage data sources</small>
                  </div>
              </div>

              <!-- Tabs -->

              <div class="setting-tabNavigation">

                  <ul class="nav nav-pills gap-2 flex-wrap" id="pills-tab" role="tablist">
                      <li class="nav-item">
                          {{-- <a href="{{ route('teacher_setting.create') }}" class="nav-link {{ request()->routeIs('teachers.*') ? 'active' : '' }}">
            Teachers
        </a> --}}
                          <a href="{{ route('teacher_setting.create') }}" class="nav-link active" id="pills-teachers-tab"
                              data-bs-toggle="pill" data-bs-target="#pills-teachers" role="tab"
                              aria-controls="pills-teachers" aria-selected="true">
                              Teachers
                          </a>

                      </li>
                      <li class="nav-item">
                          {{-- <a href="{{ route('taxonomies_setting.create') }}" class="nav-link {{ request()->routeIs('taxonomies.*') ? 'active' : '' }}">
            Taxonomies
        </a> --}}
                          <a href="{{ route('taxonomies_setting.create') }}"
                              class="nav-link {{ request()->routeIs('taxonomies_setting.*') ? 'active' : '' }}"
                              id="pills-taxonomies-tab" data-bs-toggle="pill" data-bs-target="#pills-taxonomies"
                              role="tab" aria-controls="pills-taxonomies"
                              aria-selected="{{ request()->routeIs('taxonomies_setting.*') ? 'true' : 'false' }}">
                              Taxonomies
                          </a>

                      </li>
                      <li class="nav-item">
                          {{-- <a href="{{ route('system_setting.create') }}" class="nav-link {{ request()->routeIs('system.*') ? 'active' : '' }}">
            System
        </a> --}}
                          <a href="{{ route('system_setting.create') }}"
                              class="nav-link {{ request()->routeIs('system_setting.*') ? 'active' : '' }}"
                              id="pills-system-tab" data-bs-toggle="pill" data-bs-target="#pills-system" role="tab"
                              aria-controls="pills-system"
                              aria-selected="{{ request()->routeIs('system_setting.*') ? 'true' : 'false' }}">
                              System
                          </a>

                      </li>
                  </ul>

              </div>


              <!-- Tab Content -->
              <div class="tab-content" id="pills-tabContent">
                  <!-- Teachers Tab -->
                  <div class="tab-pane fade show active mt-4" id="pills-teachers" role="tabpanel"
                      aria-labelledby="pills-teachers-tab">
                      <div class="card p-3 shadow-sm">
                          <h5 class="fw-semibold mb-1">Teacher Management</h5>
                          <p class="text-muted small mb-4">Manage teachers and their course revenue percentages. Teachers
                              are
                              synchronized from WordPress users with the 'instructor' role.</p>




                          <!-- Button -->
                       
                          <button id="addTeacher" class="btn btn-dark w-15 ms-auto d-block mb-5" data-bs-toggle="modal"
                              data-bs-target="#teacherModal">
                              Add New Teacher
                          </button>

                          <div class="modal fade" id="teacherModal" tabindex="-1" aria-labelledby="teacherModalLabel"
                              aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered modal-lg">
                                  <div class="modal-content border-0 shadow-lg rounded-4">
                                      <div class="modal-header bg-dark text-white rounded-top-4">
                                          <h5 class="modal-title" id="teacherModalLabel">Add New Teacher</h5>
                                          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                              aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                          <form id="teacherForm">
                                              @csrf
                                              <div class="mb-3">
                                                  <label for="teacherName" class="form-label">Name</label>
                                                  <input type="text" class="form-control" id="teacherName"
                                                      name="teacherName" placeholder="Enter full name" required>
                                              </div>
                                              <div class="mb-3">
                                                  <label for="teacherContact" class="form-label">Contact</label>
                                                  <input type="text" class="form-control" id="teacherContact"
                                                      name="teacherContact" placeholder="Enter contact number" required>
                                              </div>
                                              <div class="mb-3">
                                                  <label for="teacherEmail" class="form-label">Email</label>
                                                  <input type="email" class="form-control" id="teacherEmail"
                                                      name="teacherEmail" placeholder="Enter email address" required>
                                              </div>
                                              <div class="mb-3">
                                                  <label for="teacherOtherinfo" class="form-label">Other
                                                      Information</label>
                                                  <textarea class="form-control" id="teacherOtherinfo" name="teacherOtherinfo" rows="3"
                                                      placeholder="Enter additional info"></textarea>
                                              </div>
                                              <div class="modal-footer border-0">
                                                  <button type="button" class="btn btn-secondary"
                                                      data-bs-dismiss="modal">Close</button>
                                                  <button type="submit" id="teacherSubmitBtn" class="btn btn-dark">Save
                                                      Teacher</button>
                                              </div>
                                          </form>
                                      </div>
                                  </div>
                              </div>
                          </div>
                            @php
                                use App\Models\Teacher;

                                $teacher_data=Teacher::first();
                            @endphp

                          <!-- Teacher Accordion -->
                          <div class="accordion" id="teacherAccordion">
                              <!-- Teacher 1 -->
                              <div class="accordion-item teacher-card border mb-2 rounded">
                                  <h3 class="accordion-header" id="headingOne">
                                      <button class="accordion-button collapsed bg-white " type="button"
                                          data-bs-toggle="collapse" data-bs-target="#teacher1" aria-expanded="false"
                                          aria-controls="teacher1">
                                          <div class="teacher-info d-flex align-items-center gap-3">
                                              <div class="teacher-icon"><i class="fa-solid fa-user"></i></div>
                                              <div>
                                                  <h6 class="mb-0 fw-semibold">{{$teacher_data->teacher_name}}</h6>
                                                  <small class="text-muted">{{$teacher_data->teacher_email}}</small>
                                              </div>
                                          </div>
                                      </button>
                                  </h3>
                                  <div id="teacher1" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                      data-bs-parent="#teacherAccordion">
                                      <div class="accordion-body bg-light border-top">
                                          <div class="fw-semibold mb-2 percentage-title">Course Revenue Percentages</div>
                                          <div class="percentage-box mb-2 p-2">
                                              <span>IGCSE Mathematics</span>
                                              <small>Teacher: <span class="text-success">70%</span> | Platform: <span
                                                      class="text-primary">30%</span></small>
                                          </div>
                                          <div class="percentage-box mb-2 p-2">
                                              <span>SAT Math Prep</span>
                                              <small>Teacher: <span class="text-success">75%</span> | Platform: <span
                                                      class="text-primary">25%</span></small>
                                          </div>
                                          <button class="btn btn-dark btn-sm mt-2" data-bs-toggle="modal"
                                              data-bs-target="#addCourseModal" style="font-size: 15px;">
                                              <i class="fa-solid fa-plus"></i> Add Course Percentage
                                          </button>
                                      </div>
                                  </div>
                              </div>

                              <!-- Teacher 2 -->
                              <div class="accordion-item teacher-card border mb-2 rounded">
                                  <h2 class="accordion-header" id="headingTwo">
                                      <button class="accordion-button collapsed bg-white" type="button"
                                          data-bs-toggle="collapse" data-bs-target="#teacher2" aria-expanded="false"
                                          aria-controls="teacher2">
                                          <div class="teacher-info d-flex align-items-center gap-3">
                                              <div class="teacher-icon"><i class="fa-solid fa-user"></i></div>
                                              <div>
                                                  <h6 class="mb-0 fw-semibold">Prof. Sarah Johnson</h6>
                                                  <small class="text-muted">sarah.johnson@weteach.com</small>
                                              </div>
                                          </div>
                                      </button>
                                  </h2>
                                  <div id="teacher2" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                      data-bs-parent="#teacherAccordion">
                                      <div class="accordion-body bg-light border-top">
                                          <div class="fw-semibold mb-2">Course Revenue Percentages</div>
                                          <div class="percentage-box mb-2">
                                              <span>IELTS Writing</span>
                                              <small>Teacher: <span class="text-success">60%</span> | Platform: <span
                                                      class="text-primary">40%</span></small>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <!-- End Accordion -->
                      </div>
                  </div>

                  <!-- Taxonomies Tab -->
                  <div class="tab-pane fade" id="pills-taxonomies" role="tabpanel"
                      aria-labelledby="pills-taxonomies-tab">
                      <div class="card p-3 shadow-sm">
                          <h5 class="fw-semibold mb-1">Taxonomies Management</h5>
                          <p class="text-muted small">Manage subjects, categories, and levels here.</p>
                          <div class="container-fluid">
                              <div class="row g-3">

                                  <div class="col-md-6">
                                      <div class="taxonomy-card">
                                          <h6>Educational Systems</h6>

                                          <!-- List Container -->
                                          <div id="eduList" class="mt-2"></div>

                                          <!-- Add Form -->
                                          <form id="eduForm"
                                              action="{{ route('taxonomies_educational_systems.store') }}" method="POST"
                                              autocomplete="off">
                                              @csrf
                                              <div class="add-input w-100 d-flex gap-2 mt-2">
                                                  <input id="eduInput" type="text"
                                                      class="form-control form-control-sm" name="eduInput"
                                                      placeholder="Add new educational system">
                                                  <button type="submit" class="btn btn-sm btn-secondary">
                                                      <i class="fa fa-plus"></i>
                                                  </button>
                                              </div>
                                          </form>
                                      </div>
                                  </div>


                                  <!-- Subjects -->

                                  <div class="col-md-6">
                                      <div class="taxonomy-card">
                                          <h6>Subjects</h6>

                                          <!-- List Container -->
                                          <div id="subjectList" class="mt-2"></div>

                                          <!-- Add Form -->
                                          <form id="subjectForm" action="{{ route('taxonomies_subjects.store') }}"
                                              method="POST" autocomplete="off">
                                              @csrf
                                              <div class="add-input w-100 d-flex gap-2 mt-2">
                                                  <input id="subjectInput" type="text"
                                                      class="form-control form-control-sm" name="subjectInput"
                                                      placeholder="Add new subject">
                                                  <button type="submit" class="btn btn-sm btn-secondary">
                                                      <i class="fa fa-plus"></i>
                                                  </button>
                                              </div>
                                          </form>
                                      </div>
                                  </div>


                                  <!-- Examination Boards -->


                                  <div class="col-md-6">
                                      <div class="taxonomy-card">
                                          <h6>Examination Boards</h6>

                                          <!-- List -->
                                          <div id="boardList" class="mt-2"></div>

                                          <!-- Add Form -->
                                          <form id="boardForm" action="{{ route('taxonomies_examination_board.store') }}"
                                              method="POST" autocomplete="off">
                                              @csrf
                                              <div class="add-input w-100 d-flex gap-2 mt-2">
                                                  <input id="boardInput" type="text"
                                                      class="form-control form-control-sm" name="boardInput"
                                                      placeholder="Add new examination board">
                                                  <button type="submit" class="btn btn-sm btn-secondary">
                                                      <i class="fa fa-plus"></i>
                                                  </button>
                                              </div>
                                          </form>
                                      </div>
                                  </div>


                                  <!-- Sessions -->

                                  <div class="col-md-6">
                                      <div class="taxonomy-card">
                                          <h6>Sessions</h6>
                                          <div id="sessionList"></div>

                                          <form id="sessionForm" action="{{ route('taxonomies_sessions.store') }}"
                                              method="post" autocomplete="off">
                                              <div class="add-input">
                                                  @csrf
                                                  <input id="sessionInput" type="text"
                                                      class="form-control form-control-sm" name="sessionList"
                                                      placeholder="Add new session">
                                                  <button type="submit" class="btn btn-sm btn-secondary">
                                                      <i class="fa fa-plus"></i>
                                                  </button>
                                              </div>
                                          </form>
                                      </div>
                                  </div>


                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- System Tab -->
                  <div class="tab-pane fade" id="pills-system" role="tabpanel" aria-labelledby="pills-system-tab">
                      <div class="card p-3 shadow-sm">
                          <h5 class="fw-semibold mb-1">System Settings</h5>
                          <p class="text-muted small">Manage your platform’s configuration, integrations, and performance
                              options
                              here.</p>

                          <div class="row g-3">
                              <!-- Security Settings -->


                              <div class="col-md-6">
                                  <div class="settings-card">
                                      @php
                                          use App\Models\Setting;

                                          $admin = Setting::where('type', 'admin-pin')->first();
                                          $session_timeout = Setting::where('type', 'session_timeout')->first();
                                          $currencies = Setting::where('type', 'default_currency')->first();
                                          $selected_currency = Setting::where('type', 'selected_currency')->first();
                                          $default_currencies = [];
                                          if ($currencies) {
                                              $default_currencies = array_map(
                                                  'trim',
                                                  explode(',', trim($currencies->value, '[]')),
                                              );
                                          }
                                          $selected_currency_value = $selected_currency
                                              ? trim($selected_currency->value)
                                              : null;
                                          $email_notification = Setting::where('type', 'email_notification')->first();
                                          $payment_alert = Setting::where('type', 'payment_alert')->first();
                                          $low_balance_warning = Setting::where('type', 'low_balance_warning')->first();
                                      @endphp

                                      <h6>Security Settings</h6>

                                      <form id="securitySettingForm"
                                          action="{{ route('security_setting.update', $admin->id) }}" method="POST"
                                          data-route="{{ route('security_setting.update', $admin->id) }}">
                                          @csrf
                                          <input type="hidden" value="{{ $admin->id }}">

                                          <div class="mb-3">
                                              <label class="form-label">Admin PIN</label>
                                              <input type="password" class="form-control form-control-sm" name="admin"
                                                  value="{{ $admin->value }}" placeholder="Current PIN: 1234">
                                              <div class="form-text">Used for confirming sensitive actions like deletions
                                              </div>
                                          </div>

                                          <div class="mb-3">
                                              <label class="form-label">Session Timeout (minutes)</label>
                                              <input type="number" class="form-control form-control-sm"
                                                  name="session_timeout" value="{{ $session_timeout->value }}">
                                          </div>

                                          <button type="submit" class="btn btn-dark btn-sm" id="updateBtn">
                                              Update Security Settings
                                          </button>
                                      </form>


                                  </div>
                              </div>


                              <div class="col-md-6">
                                  <div class="settings-card">
                                      <h6>Currency Settings</h6>

                                      <form id="currencySettingForm"
                                          action="{{ route('currency_setting.update', $currencies->id) }}"
                                          method="POST">
                                          @csrf

                                          <div class="mb-3">
                                              <label class="form-label">Default Currency</label>
                                              <select class="form-select form-select-sm" name="default_currency">
                                                  @foreach ($default_currencies as $default_currency)
                                                      <option value="{{ $default_currency }}"
                                                          {{ $selected_currency_value == $default_currency ? 'selected' : '' }}>
                                                          {{ $default_currency }}
                                                      </option>
                                                  @endforeach
                                              </select>
                                          </div>

                                          <div class="exchange-box mb-3">
                                              <strong>Exchange Rates (Auto-update)</strong><br>
                                              1 USD = 30.85 EGP<br>
                                              1 EUR = 33.42 EGP<br>
                                              <small class="text-muted">Last updated: 2 hours ago</small>
                                          </div>



                                          <button type="submit" id="currencyUpdateBtn" class="btn btn-dark btn-sm w-20">
                                              Update Currency Settings
                                          </button>
                                      </form>
                                  </div>
                              </div>



                              <div class="col-md-6">
                                  <div class="settings-card">
                                      <h6>Notification Settings</h6>

                                      <form id="notificationSettingsForm" method="POST">
                                          @csrf

                                          <!-- Email Notifications -->
                                          <div class="form-check mb-2 d-flex justify-content-between me-0 ms-0">
                                              <div style="margin-bottom: 10px;">
                                                  <label class="form-check-label fw-semibold" for="emailNotif">Email
                                                      Notifications</label>
                                                  <div class="form-text">Send email alerts for important events</div>
                                              </div>
                                              <input class="form-check-input" type="checkbox" id="emailNotif"
                                                  name="email_notification"
                                                  {{ $email_notification->value == '1' ? 'checked' : '' }}
                                                  data-id="{{ $email_notification->id }}">
                                          </div>

                                          <!-- Payment Alerts -->
                                          <div class="form-check mb-2 d-flex justify-content-between me-0 ms-0">
                                              <div class="m-0">
                                                  <label class="form-check-label fw-semibold" for="paymentAlert">Payment
                                                      Alerts</label>
                                                  <div class="form-text">Notify when payments are received</div>
                                              </div>
                                              <input class="form-check-input" type="checkbox" id="paymentAlert"
                                                  name="payment_alert" {{ $payment_alert->value == '1' ? 'checked' : '' }}
                                                  data-id="{{ $payment_alert->id }}">
                                          </div>

                                          <!-- Low Balance Warning -->
                                          <div class="form-check mb-2 d-flex justify-content-between me-0 ms-0">
                                              <div class="m-0">
                                                  <label class="form-check-label fw-semibold" for="balanceWarning">Low
                                                      Balance Warning</label>
                                                  <div class="form-text">Alert when teacher balances are low</div>
                                              </div>
                                              <input class="form-check-input" type="checkbox" id="balanceWarning"
                                                  name="low_balance_warning"
                                                  {{ $low_balance_warning->value == '1' ? 'checked' : '' }}
                                                  data-id="{{ $low_balance_warning->id }}">
                                          </div>



                                          <button type="button" id="notificationUpdateBtn"
                                              class="btn btn-dark btn-sm w-20">
                                              Update Notification Settings
                                          </button>
                                      </form>
                                  </div>
                              </div>


                              <!-- Data Management -->
                              <div class="col-md-6">
                                  <div class="settings-card">
                                      <h6>Data Management</h6>

                                      <div class="mb-3">
                                          <label class="form-label fw-semibold">Data Backup</label>
                                          <div class="form-text mb-2">Last backup: 2 hours ago</div>
                                          <button class="btn btn-outline-dark btn-sm w-100">Create Backup Now</button>
                                      </div>

                                      <div class="mb-3">
                                          <label class="form-label fw-semibold">Data Export</label>
                                          <div class="form-text mb-2">Export all system data</div>
                                          <button class="btn btn-outline-dark btn-sm w-100">Export Data</button>
                                      </div>

                                      <div>
                                          <label class="form-label fw-semibold">WordPress Sync</label>
                                          <div class="form-text mb-2">Sync with WordPress users and taxonomies</div>
                                          <button class="btn btn-outline-dark btn-sm w-100">Sync Now</button>
                                      </div>
                                  </div>
                              </div>

                          </div>
                      </div>
                  </div>





                  <!-- Add Course Percentage Modal -->
                  <div class="modal fade percentage-modal" id="addCourseModal" tabindex="-1"
                      aria-labelledby="addCourseModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content p-2">
                              <div class="modal-header border-0 pb-0">
                                  <h5 class="modal-title fw-semibold d-flex align-items-center gap-2"
                                      id="addCourseModalLabel">
                                      <i class="fa-solid fa-book"></i>
                                      Add Course Percentage
                                  </h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"
                                      aria-label="Close"></button>
                              </div>

                              <div class="modal-body">
                                  <p class="text-muted small mb-3">
                                      Set the revenue sharing percentage for <strong>Dr. Ahmed Hassan</strong> on a specific
                                      course.
                                  </p>

                                  <!-- Course -->
                                  <div class="mb-3">
                                      <label class="form-label fw-semibold small">Course *</label>
                                      <select class="form-select" id="courseSelect">
                                          <option selected disabled>Select a course</option>
                                          <option value="IGCSE Mathematics">IGCSE Mathematics</option>
                                          <option value="SAT Math Prep">SAT Math Prep</option>
                                          <option value="IELTS Writing">IELTS Writing</option>
                                      </select>
                                  </div>

                                  <!-- Teacher Percentage -->
                                  <div class="mb-3">
                                      <label class="form-label fw-semibold small">Teacher Percentage *</label>
                                      <div class="input-group">
                                          <input type="number" class="form-control" id="teacherPercentage"
                                              value="70" min="0" max="100" step="1">
                                          <span class="input-group-text">%</span>
                                      </div>
                                      <div class="form-text">Percentage of course revenue that goes to the teacher</div>
                                  </div>

                                  <!-- Share Display -->
                                  <div class="p-3 bg-light rounded border">
                                      <div class="d-flex justify-content-between">
                                          <span>Teacher Share:</span>
                                          <span id="teacherShare" class="fw-semibold text-success">70%</span>
                                      </div>
                                      <div class="d-flex justify-content-between">
                                          <span>Platform Share:</span>
                                          <span id="platformShare" class="fw-semibold text-primary">30%</span>
                                      </div>
                                  </div>
                              </div>

                              <div class="modal-footer border-0">
                                  <button type="button" class="btn btn-dark modal-closeBtn"
                                      data-bs-dismiss="modal">Cancel</button>
                                  <button type="button" class="btn btn-dark">
                                      <i class="fa-solid fa-book me-2"></i>Add Course Percentage
                                  </button>
                              </div>
                          </div>
                      </div>
                  </div>






              </div>
          </div>
      </div>
  @endsection



  @section('scripts')
      <script>
          $(document).ready(function() {

              // ✅ Store initial values
              let lastAdminPIN = $('input[name="admin"]').val() || '';
              let lastSessionTimeout = $('input[name="session_timeout"]').val() || '';

              // ✅ Handle form submit
              $('#securitySettingForm').on('submit', function(e) {
                  e.preventDefault();

                  const form = $(this);
                  const url = form.attr('action');
                  const btn = $('#updateBtn');
                  const responseMsg = $('#securityResponseMsg');
                  const originalText = btn.html();
                  const newPIN = (form.find('input[name="admin"]').val() || '').trim();
                  const newSession = (form.find('input[name="session_timeout"]').val() || '').trim();

                  // ✅ Stop if nothing changed
                  if (newPIN === lastAdminPIN && newSession === lastSessionTimeout) {
                      return;
                  }

                  // ✅ Show spinner
                  btn.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
            Please wait, updating settings...
        `);

                  $.ajax({
                      type: 'POST',
                      url: url,
                      data: form.serialize(),
                      success: function(res) {
                          // ✅ Update reference values
                          lastAdminPIN = newPIN;
                          lastSessionTimeout = newSession;

                          responseMsg
                              .removeClass()
                              .addClass('alert alert-success text-center')
                              .html('✅ Security settings updated successfully!')
                              .fadeIn();

                          btn.html('<i class="bi bi-check-circle me-2"></i> Updated Successfully')
                              .removeClass('btn-dark')
                              .addClass('btn-success');

                          setTimeout(() => {
                              btn.prop('disabled', false)
                                  .removeClass('btn-success')
                                  .addClass('btn-dark')
                                  .html(originalText);
                              responseMsg.fadeOut();
                          }, 3000);
                      },
                      error: function() {
                          btn.prop('disabled', false).html(originalText);
                          responseMsg
                              .removeClass()
                              .addClass('alert alert-danger text-center')
                              .html('❌ Something went wrong. Please try again.')
                              .fadeIn()
                              .delay(2000)
                              .fadeOut();
                      }
                  });
              });
          });
      </script>


      {{-- this is the script of default_currency --}}

      <script>
          $(document).ready(function() {
              // Save the initially selected value
              let lastSelectedCurrency = $('#currencySettingForm select[name="default_currency"]').val();

              $('#currencySettingForm').on('submit', function(e) {
                  e.preventDefault();

                  const form = $(this);
                  const url = form.attr('action');
                  const btn = $('#currencyUpdateBtn');
                  const responseMsg = $('#currencyResponseMsg');
                  const formData = form.serialize();
                  const selectedCurrency = form.find('select[name="default_currency"]').val();
                  const originalText = btn.html();

                  // ✅ Check if value is unchanged
                  if (selectedCurrency === lastSelectedCurrency) {
                      responseMsg
                          .removeClass()
                          .addClass('alert alert-info text-center')
                          .html('ℹ️ No changes to update.')
                          .fadeIn()
                          .delay(2000)
                          .fadeOut();
                      return; // Stop here — don’t send AJAX
                  }

                  // ✅ Show spinner and disable button
                  btn.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-2"></span>
            Please wait, updating currency...
        `);

                  // ✅ Start AJAX
                  $.ajax({
                      type: 'POST',
                      url: url,
                      data: formData,
                      success: function(res) {
                          setTimeout(() => {
                              responseMsg
                                  .removeClass()
                                  .addClass('alert alert-success text-center')
                                  .html('✅ Currency settings updated successfully!')
                                  .fadeIn();

                              btn.html(
                                      '<i class="bi bi-check-circle me-2"></i> Updated Successfully'
                                  )
                                  .removeClass('btn-dark')
                                  .addClass('btn-success');

                              // update reference currency
                              lastSelectedCurrency = selectedCurrency;

                              setTimeout(() => {
                                  btn.prop('disabled', false)
                                      .removeClass('btn-success')
                                      .addClass('btn-dark')
                                      .html(originalText);

                                  responseMsg.fadeOut();
                              }, 2500);
                          }, 1000);
                      },
                      error: function() {
                          setTimeout(() => {
                              btn.prop('disabled', false).html(originalText);
                              responseMsg
                                  .removeClass()
                                  .addClass('alert alert-danger text-center')
                                  .html('❌ Something went wrong. Please try again.')
                                  .fadeIn()
                                  .delay(2500)
                                  .fadeOut();
                          }, 1000);
                      }
                  });
              });
          });
      </script>




      {{-- this is the script of notification --}}


      <script>
          $(function() {
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });

              // ✅ Store the initial values of all notification checkboxes
              const form = $('#notificationSettingsForm');
              let initialValues = {};
              form.find('input[type="checkbox"], input[type="radio"], input[type="text"], select').each(function() {
                  initialValues[$(this).attr('name')] = $(this).is(':checkbox') ? $(this).prop('checked') : $(
                      this).val();
              });

              $('#notificationUpdateBtn').on('click', function() {
                  const btn = $(this);
                  const responseMsg = $('#notificationResponseMsg');
                  const url = "{{ route('notification_settings.update') }}";
                  const formData = form.serialize();
                  const originalText = btn.html();

                  // ✅ Check if any field has changed
                  let hasChanged = false;
                  form.find('input[type="checkbox"], input[type="radio"], input[type="text"], select').each(
                      function() {
                          const name = $(this).attr('name');
                          const currentValue = $(this).is(':checkbox') ? $(this).prop('checked') : $(this)
                              .val();
                          if (initialValues[name] !== currentValue) {
                              hasChanged = true;
                          }
                      });

                  // ✅ If nothing changed — do nothing
                  if (!hasChanged) {
                      return; // stop here (no spinner, no message)
                  }

                  // ✅ Otherwise, show spinner and disable button
                  btn.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-2"></span>
            Please wait, updating notifications...
        `);

                  $.ajax({
                          url: url,
                          method: 'POST',
                          data: formData,
                          dataType: 'json'
                      })
                      .done(function(res) {
                          // success UI
                          responseMsg
                              .removeClass()
                              .addClass('alert alert-success text-center')
                              .html('✅ Notification settings updated successfully!')
                              .fadeIn();

                          btn.html('<i class="bi bi-check-circle me-2"></i> Updated Successfully')
                              .removeClass('btn-dark')
                              .addClass('btn-success');

                          // ✅ Update reference values after success
                          form.find(
                              'input[type="checkbox"], input[type="radio"], input[type="text"], select'
                          ).each(function() {
                              const name = $(this).attr('name');
                              initialValues[name] = $(this).is(':checkbox') ? $(this).prop(
                                  'checked') : $(this).val();
                          });

                          setTimeout(function() {
                              btn.prop('disabled', false)
                                  .removeClass('btn-success')
                                  .addClass('btn-dark')
                                  .html(originalText);
                              responseMsg.fadeOut();
                          }, 3000);
                      })
                      .fail(function(xhr, status, errorThrown) {
                          console.error('AJAX error. Status:', status, 'Thrown:', errorThrown);

                          let userMsg = '❌ Something went wrong. Please try again.';
                          if (xhr && xhr.responseJSON) {
                              if (xhr.responseJSON.message) userMsg = '❌ ' + xhr.responseJSON.message;
                              if (xhr.responseJSON.errors) {
                                  const firstKey = Object.keys(xhr.responseJSON.errors)[0];
                                  userMsg = '❌ ' + xhr.responseJSON.errors[firstKey][0];
                              }
                          }

                          responseMsg
                              .removeClass()
                              .addClass('alert alert-danger text-center')
                              .html(userMsg)
                              .fadeIn();

                          setTimeout(function() {
                              btn.prop('disabled', false).html(originalText);
                          }, 1200);
                      });
              });
          });
      </script>





      {{-- This is the script of educational system --}}




      <script>
          document.addEventListener("DOMContentLoaded", function() {
              const eduForm = document.getElementById("eduForm");
              const eduInput = document.getElementById("eduInput");
              const eduList = document.getElementById("eduList");
              const csrfToken = document.querySelector('input[name="_token"]').value;
              const data = {
                  eduList: []
              };

              // 🔹 Load all items on page load
              async function loadItems() {
                  eduList.innerHTML = '<small class="text-muted">Loading...</small>';
                  try {
                      const res = await fetch("{{ route('taxonomies_educational_systems.index') }}");
                      const items = await res.json();

                      data.eduList = items.map(i => ({
                          id: i.id,
                          title: i.educational_title
                      }));
                      renderList();
                  } catch (error) {
                      console.error("Error loading items:", error);
                      eduList.innerHTML = '<small class="text-danger">Failed to load items.</small>';
                  }
              }

              // 🔹 Render the list dynamically
              function renderList() {
                  eduList.innerHTML = '';

                  if (data.eduList.length === 0) {
                      eduList.innerHTML = '<small class="text-muted">No educational systems added yet.</small>';
                      return;
                  }

                  data.eduList.forEach(item => {
                      const div = document.createElement("div");
                      div.className =
                          "taxonomy-item d-flex justify-content-between align-items-center border rounded p-1 mb-1 position-relative";
                      div.dataset.id = item.id;
                      div.innerHTML = `
                <span>${item.title}</span>
                <i class="fa fa-trash text-danger delete-btn" style="cursor:pointer; font-size:16px;"></i>
            `;
                      eduList.appendChild(div);
                  });

                  attachDeleteListeners();
              }

              // 🔹 Handle Add Item form submit
              eduForm.addEventListener("submit", async function(e) {
                  e.preventDefault();
                  const title = eduInput.value.trim();
                  if (!title) return;

                  const button = eduForm.querySelector("button");
                  button.disabled = true;
                  button.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';

                  try {
                      const res = await fetch(eduForm.action, {
                          method: "POST",
                          headers: {
                              "Content-Type": "application/json",
                              "X-CSRF-TOKEN": csrfToken,
                              "Accept": "application/json"
                          },
                          body: JSON.stringify({
                              eduInput: title
                          })
                      });

                      const response = await res.json();

                      if (response.success) {
                          data.eduList.push({
                              id: response.id,
                              title: response.title
                          });
                          renderList();
                          eduInput.value = ''; // ✅ clear input
                      } else {
                          console.error("❌ Failed to save item.");
                      }
                  } catch (error) {
                      console.error("Error saving item:", error);
                  } finally {
                      button.disabled = false;
                      button.innerHTML = '<i class="fa fa-plus"></i>';
                  }
              });

              // 🔹 Delete item (Confirm + Spinner + Yellow highlight + Green toast)
              function attachDeleteListeners() {
                  document.querySelectorAll(".delete-btn").forEach(btn => {
                      btn.addEventListener("click", async function() {
                          const parent = this.closest(".taxonomy-item");
                          const id = parent.dataset.id;

                          // Confirm before deletion
                          if (!confirm(
                                  "Are you sure you want to delete this educational system?"))
                              return;

                          // Highlight in yellow
                          parent.style.backgroundColor = "#fff8d6";

                          // Hide delete icon, show spinner
                          const deleteIcon = this;
                          deleteIcon.style.visibility = "hidden";
                          const spinner = document.createElement("i");
                          spinner.className = "fa fa-spinner fa-spin text-warning ms-2";
                          parent.appendChild(spinner);

                          try {
                              const res = await fetch(
                                  `/taxonomies/educational_systems/delete/${id}`, {
                                      method: "DELETE",
                                      headers: {
                                          "X-CSRF-TOKEN": csrfToken,
                                          "Accept": "application/json"
                                      }
                                  });

                              const response = await res.json();

                              if (response.success) {
                                  setTimeout(() => {
                                      spinner.remove();

                                      // ✅ Create green toast below delete button
                                      const toast = document.createElement("div");
                                      toast.textContent =
                                          "✔ Education deleted successfully";
                                      toast.style.position = "absolute";
                                      toast.style.bottom = "-35px";
                                      toast.style.right = "0";
                                      toast.style.background = "#28a745";
                                      toast.style.color = "white";
                                      toast.style.padding = "4px 10px";
                                      toast.style.borderRadius = "6px";
                                      toast.style.fontSize = "13px";
                                      toast.style.boxShadow = "0 2px 8px rgba(0,0,0,0.2)";
                                      toast.style.opacity = "0";
                                      toast.style.transition = "opacity 0.3s ease";
                                      parent.appendChild(toast);

                                      // Fade in the toast
                                      setTimeout(() => (toast.style.opacity = "1"), 50);

                                      // Toast stays visible for 6 seconds before fading out
                                      setTimeout(() => {
                                          toast.style.opacity = "0";
                                          setTimeout(() => {
                                              toast.remove();
                                              data.eduList = data.eduList
                                                  .filter(i => i.id !=
                                                      id);
                                              renderList();
                                          }, 400);
                                      }, 1500);
                                  }, 800);
                              } else {
                                  deleteIcon.style.visibility = "visible";
                                  spinner.remove();
                                  parent.style.backgroundColor = "";
                                  console.error("Failed to delete item.");
                              }
                          } catch (error) {
                              deleteIcon.style.visibility = "visible";
                              spinner.remove();
                              parent.style.backgroundColor = "";
                              console.error("Error deleting item:", error);
                          }
                      });
                  });
              }

              // Load items on startup
              loadItems();
          });
      </script>



      {{-- this is the script of taxonomies subject --}}



      <script>
          document.addEventListener("DOMContentLoaded", function() {
              const subjectForm = document.querySelector('form[action="{{ route('taxonomies_subjects.store') }}"]');
              const subjectInput = document.getElementById("subjectInput");
              const subjectList = document.getElementById("subjectList");
              const csrfToken = document.querySelector('input[name="_token"]').value;
              const subjectData = {
                  list: []
              };

              // 🔹 Load all subjects
              async function loadSubjects() {
                  subjectList.innerHTML = '<small class="text-muted">Loading...</small>';
                  try {
                      const res = await fetch("{{ route('taxonomies_subjects.index') }}");
                      const items = await res.json();
                      subjectData.list = items.map(i => ({
                          id: i.id,
                          title: i.subject_title
                      }));
                      renderSubjects();
                  } catch (error) {
                      console.error("Error loading subjects:", error);
                      subjectList.innerHTML = '<small class="text-danger">Failed to load subjects.</small>';
                  }
              }

              // 🔹 Render subjects
              function renderSubjects() {
                  subjectList.innerHTML = '';
                  if (subjectData.list.length === 0) {
                      subjectList.innerHTML = '<small class="text-muted">No subjects added yet.</small>';
                      return;
                  }

                  subjectData.list.forEach(item => {
                      const div = document.createElement("div");
                      div.className =
                          "taxonomy-item d-flex justify-content-between align-items-center border rounded p-1 mb-1 position-relative";
                      div.dataset.id = item.id;
                      div.innerHTML = `
                <span>${item.title}</span>
                <i class="fa fa-trash text-danger delete-btn" style="cursor:pointer; font-size:16px;"></i>
            `;
                      subjectList.appendChild(div);
                  });

                  // Attach listeners **after rendering**
                  attachDeleteListeners();
              }

              // 🔹 Add Subject
              subjectForm.addEventListener("submit", async function(e) {
                  e.preventDefault();
                  const title = subjectInput.value.trim();
                  if (!title) return;

                  const button = subjectForm.querySelector("button");
                  button.disabled = true;
                  button.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';

                  try {
                      const res = await fetch(subjectForm.action, {
                          method: "POST",
                          headers: {
                              "Content-Type": "application/json",
                              "X-CSRF-TOKEN": csrfToken,
                              "Accept": "application/json"
                          },
                          body: JSON.stringify({
                              subjectInput: title
                          })
                      });

                      const response = await res.json();
                      if (response.success) {
                          subjectData.list.push({
                              id: response.id,
                              title: response.title
                          });
                          renderSubjects();
                          subjectInput.value = "";
                      } else {
                          console.error("Failed to save subject.");
                      }
                  } catch (error) {
                      console.error("Error saving subject:", error);
                  } finally {
                      button.disabled = false;
                      button.innerHTML = '<i class="fa fa-plus"></i>';
                  }
              });

              // 🔹 Delete Subject with Confirm + Spinner + Yellow Highlight + Green Toast
              function attachDeleteListeners() {
                  document.querySelectorAll("#subjectList .delete-btn").forEach(btn => {
                      // Remove any previous listeners to avoid duplication
                      btn.replaceWith(btn.cloneNode(true));
                  });

                  document.querySelectorAll("#subjectList .delete-btn").forEach(btn => {
                      btn.addEventListener("click", async function() {
                          const parent = this.closest(".taxonomy-item");
                          const id = parent.dataset.id;

                          // ✅ Confirm deletion
                          if (!confirm("Are you sure you want to delete this subject?")) return;

                          // Highlight in yellow
                          parent.style.backgroundColor = "#fff8d6";

                          // Hide delete icon and show spinner
                          const deleteIcon = this;
                          deleteIcon.style.visibility = "hidden";
                          const spinner = document.createElement("i");
                          spinner.className = "fa fa-spinner fa-spin text-warning ms-2";
                          parent.appendChild(spinner);

                          try {
                              const res = await fetch(`/taxonomies/subjects/delete/${id}`, {
                                  method: "DELETE",
                                  headers: {
                                      "X-CSRF-TOKEN": csrfToken,
                                      "Accept": "application/json"
                                  }
                              });

                              const response = await res.json();

                              if (response.success) {
                                  setTimeout(() => {
                                      spinner.remove();

                                      // ✅ Green Toast
                                      const toast = document.createElement("div");
                                      toast.textContent =
                                          "✔ Subject deleted successfully";
                                      toast.style.position = "absolute";
                                      toast.style.bottom = "-35px";
                                      toast.style.right = "0";
                                      toast.style.background = "#28a745";
                                      toast.style.color = "white";
                                      toast.style.padding = "4px 10px";
                                      toast.style.borderRadius = "6px";
                                      toast.style.fontSize = "13px";
                                      toast.style.boxShadow = "0 2px 8px rgba(0,0,0,0.2)";
                                      toast.style.opacity = "0";
                                      toast.style.transition = "opacity 0.3s ease";
                                      parent.appendChild(toast);

                                      setTimeout(() => (toast.style.opacity = "1"), 50);

                                      setTimeout(() => {
                                          toast.style.opacity = "0";
                                          setTimeout(() => {
                                              toast.remove();
                                              subjectData.list =
                                                  subjectData.list.filter(
                                                      i => i.id != id);
                                              renderSubjects();
                                          }, 400);
                                      }, 1500);
                                  }, 800);
                              } else {
                                  deleteIcon.style.visibility = "visible";
                                  spinner.remove();
                                  parent.style.backgroundColor = "";
                                  console.error("Failed to delete subject.");
                              }
                          } catch (error) {
                              deleteIcon.style.visibility = "visible";
                              spinner.remove();
                              parent.style.backgroundColor = "";
                              console.error("Error deleting subject:", error);
                          }
                      });
                  });
              }

              // 🔹 Initial load
              loadSubjects();
          });
      </script>


      <script>
          document.addEventListener("DOMContentLoaded", function() {
              const boardForm = document.getElementById("boardForm");
              const boardInput = document.getElementById("boardInput");
              const boardList = document.getElementById("boardList");
              const csrfToken = document.querySelector('input[name="_token"]').value;
              const data = {
                  boardList: []
              };

              // 🔹 Load all boards
              async function loadBoards() {
                  boardList.innerHTML = '<small class="text-muted">Loading...</small>';
                  try {
                      const res = await fetch("{{ route('taxonomies_examination_board.index') }}");
                      const items = await res.json();

                      data.boardList = items.map(i => ({
                          id: i.id,
                          title: i.examination_board_title
                      }));
                      renderBoards();
                  } catch (error) {
                      console.error("Error loading boards:", error);
                      boardList.innerHTML = '<small class="text-danger">Failed to load boards.</small>';
                  }
              }

              // 🔹 Render boards
              function renderBoards() {
                  boardList.innerHTML = '';

                  if (data.boardList.length === 0) {
                      boardList.innerHTML = '<small class="text-muted">No examination boards added yet.</small>';
                      return;
                  }

                  data.boardList.forEach(item => {
                      const div = document.createElement("div");
                      div.className =
                          "taxonomy-item d-flex justify-content-between align-items-center border rounded p-1 mb-1 position-relative";
                      div.dataset.id = item.id;
                      div.innerHTML = `
                <span>${item.title}</span>
                <i class="fa fa-trash text-danger delete-btn" style="cursor:pointer; font-size:16px;"></i>
            `;
                      boardList.appendChild(div);
                  });

                  attachDeleteListeners();
              }

              // 🔹 Add new board
              boardForm.addEventListener("submit", async function(e) {
                  e.preventDefault();
                  const title = boardInput.value.trim();
                  if (!title) return;

                  const button = boardForm.querySelector("button");
                  button.disabled = true;
                  button.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';

                  try {
                      const res = await fetch(boardForm.action, {
                          method: "POST",
                          headers: {
                              "Content-Type": "application/json",
                              "X-CSRF-TOKEN": csrfToken,
                              "Accept": "application/json"
                          },
                          body: JSON.stringify({
                              boardInput: title
                          })
                      });

                      const response = await res.json();

                      if (response.success) {
                          data.boardList.push({
                              id: response.id,
                              title: response.title
                          });
                          renderBoards();
                          boardInput.value = '';
                      } else {
                          console.error("❌ Failed to save board.");
                      }
                  } catch (error) {
                      console.error("Error saving board:", error);
                  } finally {
                      button.disabled = false;
                      button.innerHTML = '<i class="fa fa-plus"></i>';
                  }
              });

              // 🔹 Delete board (Confirm + Spinner + Yellow highlight + Green toast)
              function attachDeleteListeners() {
                  document.querySelectorAll(".delete-btn").forEach(btn => {
                      btn.addEventListener("click", async function() {
                          const parent = this.closest(".taxonomy-item");
                          const id = parent.dataset.id;

                          // Confirm deletion
                          if (!confirm("Are you sure you want to delete this examination board?"))
                              return;

                          // Highlight in yellow
                          parent.style.backgroundColor = "#fff8d6";

                          // Hide delete icon, show spinner
                          const deleteIcon = this;
                          deleteIcon.style.visibility = "hidden";
                          const spinner = document.createElement("i");
                          spinner.className = "fa fa-spinner fa-spin text-warning ms-2";
                          parent.appendChild(spinner);

                          try {
                              const res = await fetch(
                                  `/taxonomies/examination_board/delete/${id}`, {
                                      method: "DELETE",
                                      headers: {
                                          "X-CSRF-TOKEN": csrfToken,
                                          "Accept": "application/json"
                                      }
                                  });

                              const response = await res.json();

                              if (response.success) {
                                  setTimeout(() => {
                                      spinner.remove();

                                      // ✅ Green toast
                                      const toast = document.createElement("div");
                                      toast.textContent = "✔ Board deleted successfully";
                                      toast.style.position = "absolute";
                                      toast.style.bottom = "-35px";
                                      toast.style.right = "0";
                                      toast.style.background = "#28a745";
                                      toast.style.color = "white";
                                      toast.style.padding = "4px 10px";
                                      toast.style.borderRadius = "6px";
                                      toast.style.fontSize = "13px";
                                      toast.style.boxShadow = "0 2px 8px rgba(0,0,0,0.2)";
                                      toast.style.opacity = "0";
                                      toast.style.transition = "opacity 0.3s ease";
                                      parent.appendChild(toast);

                                      setTimeout(() => (toast.style.opacity = "1"), 50);

                                      // Toast stays visible for 6s
                                      setTimeout(() => {
                                          toast.style.opacity = "0";
                                          setTimeout(() => {
                                              toast.remove();
                                              data.boardList = data
                                                  .boardList.filter(i => i
                                                      .id != id);
                                              renderBoards();
                                          }, 400);
                                      }, 1500);
                                  }, 800);
                              } else {
                                  deleteIcon.style.visibility = "visible";
                                  spinner.remove();
                                  parent.style.backgroundColor = "";
                                  console.error("Failed to delete board.");
                              }
                          } catch (error) {
                              deleteIcon.style.visibility = "visible";
                              spinner.remove();
                              parent.style.backgroundColor = "";
                              console.error("Error deleting board:", error);
                          }
                      });
                  });
              }

              // 🔹 Load boards on startup
              loadBoards();
          });
      </script>



      {{-- This is the script of sessions --}}

      <script>
          document.addEventListener("DOMContentLoaded", function() {
              const sessionForm = document.getElementById("sessionForm");
              const sessionInput = document.getElementById("sessionInput");
              const sessionList = document.getElementById("sessionList");
              const csrfToken = document.querySelector('input[name="_token"]').value;

              const sessionData = {
                  list: []
              };

              // 🔹 Load all sessions
              async function loadSessions() {
                  sessionList.innerHTML = '<small class="text-muted">Loading...</small>';
                  try {
                      const res = await fetch("{{ route('taxonomies_sessions.index') }}");
                      const items = await res.json();

                      sessionData.list = items.map(i => ({
                          id: i.id,
                          title: i.session_title
                      }));

                      renderSessions();
                  } catch (error) {
                      console.error("Error loading sessions:", error);
                      sessionList.innerHTML = '<small class="text-danger">Failed to load sessions.</small>';
                  }
              }

              // 🔹 Render sessions
              function renderSessions() {
                  sessionList.innerHTML = '';

                  if (sessionData.list.length === 0) {
                      sessionList.innerHTML = '<small class="text-muted">No sessions added yet.</small>';
                      return;
                  }

                  sessionData.list.forEach(item => {
                      const div = document.createElement("div");
                      div.className =
                          "taxonomy-item d-flex justify-content-between align-items-center border rounded p-1 mb-1 position-relative";
                      div.dataset.id = item.id;
                      div.innerHTML = `
                <span>${item.title}</span>
                <i class="fa fa-trash text-danger delete-btn" style="cursor:pointer; font-size:16px;"></i>
            `;
                      sessionList.appendChild(div);
                  });

                  attachDeleteListeners();
              }

              // 🔹 Add new session
              sessionForm.addEventListener("submit", async function(e) {
                  e.preventDefault();
                  const title = sessionInput.value.trim();
                  if (!title) return;

                  const button = sessionForm.querySelector("button");
                  button.disabled = true;
                  button.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';

                  try {
                      const res = await fetch(sessionForm.action, {
                          method: "POST",
                          headers: {
                              "Content-Type": "application/json",
                              "X-CSRF-TOKEN": csrfToken,
                              "Accept": "application/json"
                          },
                          body: JSON.stringify({
                              sessionList: title
                          })
                      });

                      const response = await res.json();

                      if (response.success) {
                          sessionData.list.push({
                              id: response.id,
                              title: response.title
                          });
                          renderSessions();
                          sessionInput.value = ""; // ✅ clear input
                      } else {
                          console.error("❌ Failed to save session.");
                      }
                  } catch (error) {
                      console.error("Error saving session:", error);
                  } finally {
                      button.disabled = false;
                      button.innerHTML = '<i class="fa fa-plus"></i>';
                  }
              });

              // 🔹 Delete session (Confirm + Spinner + Yellow highlight + Green toast)
              function attachDeleteListeners() {
                  document.querySelectorAll("#sessionList .delete-btn").forEach(btn => {
                      btn.addEventListener("click", async function() {
                          const parent = this.closest(".taxonomy-item");
                          const id = parent.dataset.id;

                          // Confirm before deletion
                          if (!confirm("Are you sure you want to delete this session?")) return;

                          // Highlight in yellow
                          parent.style.backgroundColor = "#fff8d6";

                          // Hide delete icon, show spinner
                          const deleteIcon = this;
                          deleteIcon.style.visibility = "hidden";
                          const spinner = document.createElement("i");
                          spinner.className = "fa fa-spinner fa-spin text-warning ms-2";
                          parent.appendChild(spinner);

                          try {
                              const res = await fetch(`/taxonomies/sessions/delete/${id}`, {
                                  method: "DELETE",
                                  headers: {
                                      "X-CSRF-TOKEN": csrfToken,
                                      "Accept": "application/json"
                                  }
                              });

                              const response = await res.json();

                              if (response.success) {
                                  setTimeout(() => {
                                      spinner.remove();

                                      // ✅ Create green toast below delete button
                                      const toast = document.createElement("div");
                                      toast.textContent =
                                          "✔ Session deleted successfully";
                                      toast.style.position = "absolute";
                                      toast.style.bottom = "-35px";
                                      toast.style.right = "0";
                                      toast.style.background = "#28a745";
                                      toast.style.color = "white";
                                      toast.style.padding = "4px 10px";
                                      toast.style.borderRadius = "6px";
                                      toast.style.fontSize = "13px";
                                      toast.style.boxShadow = "0 2px 8px rgba(0,0,0,0.2)";
                                      toast.style.opacity = "0";
                                      toast.style.transition = "opacity 0.3s ease";
                                      parent.appendChild(toast);

                                      // Fade in toast
                                      setTimeout(() => (toast.style.opacity = "1"), 50);

                                      // Toast visible for 6 seconds
                                      setTimeout(() => {
                                          toast.style.opacity = "0";
                                          setTimeout(() => {
                                              toast.remove();
                                              sessionData.list =
                                                  sessionData.list.filter(
                                                      i => i.id != id);
                                              renderSessions();
                                          }, 400);
                                      }, 6000);
                                  }, 800);
                              } else {
                                  deleteIcon.style.visibility = "visible";
                                  spinner.remove();
                                  parent.style.backgroundColor = "";
                                  console.error("Failed to delete session.");
                              }
                          } catch (error) {
                              deleteIcon.style.visibility = "visible";
                              spinner.remove();
                              parent.style.backgroundColor = "";
                              console.error("Error deleting session:", error);
                          }
                      });
                  });
              }

              // 🔹 Load on startup
              loadSessions();
          });
      </script>



      

      <script>
          document.addEventListener("DOMContentLoaded", function() {
              const teacherForm = document.getElementById("teacherForm");
              const teacherModal = new bootstrap.Modal(document.getElementById('teacherModal'));
              const submitBtn = document.getElementById("teacherSubmitBtn");

              teacherForm.addEventListener("submit", async function(e) {
                  e.preventDefault();

                  // Collect values
                  const name = document.getElementById("teacherName").value.trim();
                  const contact = document.getElementById("teacherContact").value.trim();
                  const email = document.getElementById("teacherEmail").value.trim();
                  const otherInfo = document.getElementById("teacherOtherinfo").value.trim();

                  if (!name || !contact || !email) {
                      alert("Please fill all required fields!");
                      return;
                  }

                  submitBtn.disabled = true;
                  submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';

                  try {
                      const res = await fetch("{{ route('teacher_setting.store') }}", {
                          method: "POST",
                          headers: {
                              "Content-Type": "application/json",
                              "X-CSRF-TOKEN": document.querySelector('input[name="_token"]')
                                  .value,
                              "Accept": "application/json"
                          },
                          body: JSON.stringify({
                              teacherName: name,
                              teacherContact: contact,
                              teacherEmail: email,
                              teacherOtherinfo: otherInfo
                          })
                      });

                      const response = await res.json();

                      if (response.success) {
                          // Success toast
                          const toast = document.createElement("div");
                          toast.textContent = "✔ Teacher added successfully";
                          toast.className =
                              "position-fixed top-0 end-0 m-3 p-2 bg-success text-white rounded shadow";
                          toast.style.zIndex = 9999;
                          document.body.appendChild(toast);
                          setTimeout(() => toast.remove(), 3000);

                          teacherForm.reset();
                          teacherModal.hide();
                      } else {
                          alert(response.message || "Failed to add teacher!");
                      }
                  } catch (error) {
                      console.error("Error:", error);
                      alert("Something went wrong while adding teacher.");
                  } finally {
                      submitBtn.disabled = false;
                      submitBtn.innerHTML = "Save Teacher";
                  }
              });
          });
      </script>
  @endsection
