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
                                                  <h6 class="mb-0 fw-semibold">Dr. Ahmed Hassan</h6>
                                                  <small class="text-muted">ahmed.hassan@weteach.com</small>
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

                                  <!-- Educational Systems -->
                                  <div class="col-md-6">
                                      <div class="taxonomy-card">
                                          <h6>Educational Systems</h6>
                                          <div id="eduList"></div>
                                          <div class="add-input">
                                              <input id="eduInput" type="text" class="form-control form-control-sm"
                                                  name="eduInput" placeholder="Add new educational systems">
                                              <button class="btn btn-sm btn-secondary"
                                                  onclick="addItem('eduList', 'eduInput')"><i
                                                      class="fa fa-plus"></i></button>
                                          </div>
                                      </div>
                                  </div>

                                  <!-- Subjects -->
                                  <div class="col-md-6">
                                      <div class="taxonomy-card">
                                          <h6>Subjects</h6>
                                          <div id="subjectList"></div>
                                          <div class="add-input">
                                              <input id="subjectInput" type="text"
                                                  class="form-control form-control-sm" name="subjectInput"
                                                  placeholder="Add new subjects">
                                              <button class="btn btn-sm btn-secondary"
                                                  onclick="addItem('subjectList', 'subjectInput')"><i
                                                      class="fa fa-plus"></i></button>
                                          </div>
                                      </div>
                                  </div>

                                  <!-- Examination Boards -->
                                  <div class="col-md-6">
                                      <div class="taxonomy-card">
                                          <h6>Examination Boards</h6>
                                          <div id="boardList"></div>
                                          <div class="add-input">
                                              <input id="boardInput" type="text" class="form-control form-control-sm"
                                                  name="boardList" placeholder="Add new examination boards">
                                              <button class="btn btn-sm btn-secondary"
                                                  onclick="addItem('boardList', 'boardInput')"><i
                                                      class="fa fa-plus"></i></button>
                                          </div>
                                      </div>
                                  </div>

                                  <!-- Sessions -->
                                  <div class="col-md-6">
                                      <div class="taxonomy-card">
                                          <h6>Sessions</h6>
                                          <div id="sessionList"></div>
                                          <div class="add-input">
                                              <input id="sessionInput" type="text"
                                                  class="form-control form-control-sm" name="sessionList"
                                                  placeholder="Add new sessions">
                                              <button class="btn btn-sm btn-secondary"
                                                  onclick="addItem('sessionList', 'sessionInput')"><i
                                                      class="fa fa-plus"></i></button>
                                          </div>
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

                                      <div class="mb-3">
                                          <form id="securitySettingForm"
                                              action="{{ route('security_setting.update', $admin->id) }}" method="POST"
                                              data-route="{{ route('security_setting.update', $admin->id) }}">
                                              @csrf
                                              <input type="hidden" value="{{ $admin->id }}">
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

                                      <button class="btn btn-dark btn-sm" id="updateBtn">Update Security Settings</button>
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

                                     

                                          <button type="submit" id="currencyUpdateBtn"
                                              class="btn btn-dark btn-sm w-20">
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
          $(function() {
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });

              // ✅ Store initial values for both admin and session
              let lastAdminPIN = $('input[name="admin"]').val();
              let lastSessionTimeout = $('input[name="session_timeout"]').val();

              $('#securitySettingForm').on('submit', function(e) {
                  e.preventDefault();

                  const form = $(this);
                  const url = form.attr('action');
                  const btn = $('#updateBtn');
                  const responseMsg = $('#securityResponseMsg');
                  const formData = form.serialize();
                  const newPIN = form.find('input[name="admin"]').val().trim();
                  const newSession = form.find('input[name="session_timeout"]').val()?.trim() || '';
                  const originalText = btn.html();

                  // ✅ Check if both values are unchanged
                  if (newPIN === lastAdminPIN && newSession === lastSessionTimeout) {
                      responseMsg
                          .removeClass()
                          .addClass('alert alert-info text-center')
                          .html('ℹ️ No changes to update.')
                          .fadeIn()
                          .delay(2000)
                          .fadeOut();
                      return;
                  }

                  // ✅ Show spinner
                  btn.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
            Please wait, updating settings...
        `);

                  const minVisibleMs = 1200;
                  const startTs = Date.now();

                  $.post(url, formData)
                      .done(function(res) {
                          const elapsed = Date.now() - startTs;
                          const remaining = Math.max(0, minVisibleMs - elapsed);

                          setTimeout(function() {
                              // ✅ Show success message
                              responseMsg
                                  .removeClass()
                                  .addClass('alert alert-success text-center')
                                  .html('✅ ' + (res.message ||
                                      'Security settings updated successfully!'))
                                  .fadeIn();

                              btn.html(
                                      '<i class="bi bi-check-circle me-2"></i> Updated Successfully'
                                  )
                                  .removeClass('btn-dark')
                                  .addClass('btn-success');

                              // ✅ Update stored reference values
                              lastAdminPIN = newPIN;
                              lastSessionTimeout = newSession;

                              // ✅ Revert UI
                              setTimeout(function() {
                                  btn.prop('disabled', false)
                                      .removeClass('btn-success')
                                      .addClass('btn-dark')
                                      .html(originalText);

                                  responseMsg.fadeOut();
                              }, 2000);
                          }, remaining);
                      })
                      .fail(function(xhr) {
                          const elapsed = Date.now() - startTs;
                          const remaining = Math.max(0, minVisibleMs - elapsed);

                          setTimeout(function() {
                              btn.prop('disabled', false).html(originalText);

                              let msg = '❌ Something went wrong. Please try again.';
                              if (xhr && xhr.responseJSON && xhr.responseJSON.message) {
                                  msg = '❌ ' + xhr.responseJSON.message;
                              }

                              responseMsg
                                  .removeClass()
                                  .addClass('alert alert-danger text-center')
                                  .html(msg)
                                  .fadeIn()
                                  .delay(2500)
                                  .fadeOut();
                          }, remaining);
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
$(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $('#notificationUpdateBtn').on('click', function () {
        const btn = $(this);
        const form = $('#notificationSettingsForm');
        const responseMsg = $('#notificationResponseMsg');
        const url = "{{ route('notification_settings.update') }}"; // ensure route exists
        const formData = form.serialize();
        const originalText = btn.html();

        // quick client-side UX
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
        .done(function (res) {
            // success UI
            responseMsg.removeClass().addClass('alert alert-success text-center').html('✅ Notification settings updated successfully!').fadeIn();
            btn.html('<i class="bi bi-check-circle me-2"></i> Updated Successfully').removeClass('btn-dark').addClass('btn-success');

            setTimeout(function () {
                btn.prop('disabled', false).removeClass('btn-success').addClass('btn-dark').html(originalText);
                responseMsg.fadeOut();
            }, 1800);
        })
        .fail(function (xhr, status, errorThrown) {
            // LOG for debugging (open browser console)
            console.error('AJAX error. Status:', status, 'Thrown:', errorThrown);
            console.error('XHR:', xhr);

            // Try to show a helpful message from server:
            let userMsg = '❌ Something went wrong. Please try again.';
            if (xhr && xhr.responseJSON) {
                // Laravel validation or JSON exception
                if (xhr.responseJSON.message) userMsg = '❌ ' + xhr.responseJSON.message;
                // If validation errors exist, show first one
                if (xhr.responseJSON.errors) {
                    const firstKey = Object.keys(xhr.responseJSON.errors)[0];
                    userMsg = '❌ ' + xhr.responseJSON.errors[firstKey][0];
                }
            } else if (xhr && xhr.responseText) {
                // Not JSON — show a short snippet of responseText (for debugging)
                let txt = xhr.responseText.substring(0, 500);
                console.log('ResponseText (first 500 chars):', txt);
            }

            responseMsg.removeClass().addClass('alert alert-danger text-center').html(userMsg).fadeIn();

            // restore button after a short delay
            setTimeout(function () {
                btn.prop('disabled', false).html(originalText);
            }, 1200);
        });
    });
});
</script>



      <script>
          const teacherInput = document.getElementById("teacherPercentage");
          const teacherShareText = document.getElementById("teacherShare");
          const platformShareText = document.getElementById("platformShare");

          teacherInput.addEventListener("input", () => {
              let teacherValue = Math.min(Math.max(Number(teacherInput.value), 0), 100); // keep between 0 and 100
              let platformValue = 100 - teacherValue;

              teacherShareText.textContent = `${teacherValue}%`;
              platformShareText.textContent = `${platformValue}%`;
          });



          // add taxnomy
          const data = {
              eduList: ['British System', 'American System', 'Egyptian System', 'International Baccalaureate',
                  'French System'
              ],
              subjectList: ['Mathematics', 'Physics', 'Chemistry', 'Biology', 'English Language', 'Arabic Language',
                  'History', 'Geography'
              ],
              boardList: ['Cambridge IGCSE', 'Edexcel', 'AQA', 'OCR', 'IB Organization',
                  'Egyptian Ministry of Education'
              ],
              sessionList: ['May/June 2026', 'October/November 2025', 'May/June 2025', 'October/November 2024']
          };

          Object.keys(data).forEach(key => renderList(key));

          function renderList(listId) {
              const container = document.getElementById(listId);
              container.innerHTML = '';
              data[listId].forEach((item, index) => {
                  container.innerHTML += `
        <div class="taxonomy-item">
          <span>${item}</span>
          <i class="fa-solid fa-trash" onclick="deleteItem('${listId}', ${index})"></i>
        </div>
      `;
              });
          }

          function addItem(listId, inputId) {
              const input = document.getElementById(inputId);
              const value = input.value.trim();
              if (value) {
                  data[listId].push(value);
                  renderList(listId);
                  input.value = '';
              }
          }

          function deleteItem(listId, index) {
              data[listId].splice(index, 1);
              renderList(listId);
          }
      </script>
  @endsection
