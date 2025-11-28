@extends('layouts.app')


@section('contents')

<div class="tab-pane fade" id="pills-system" role="tabpanel" aria-labelledby="pills-system-tab">
    <div class="card p-3 shadow-sm">
        <h5 class="fw-semibold mb-1">System Settings</h5>
        <p class="text-muted small">Manage your platform’s configuration, integrations, and performance options
            here.</p>

        <div class="row g-3">
            <!-- Security Settings -->
            <div class="col-md-6">
                <div class="settings-card">
                    <h6>Security Settings</h6>

                    <div class="mb-3">
                        <label class="form-label">Admin PIN</label>
                        <input type="password" class="form-control form-control-sm" placeholder="Current PIN: 1234">
                        <div class="form-text">Used for confirming sensitive actions like deletions</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Session Timeout (minutes)</label>
                        <input type="number" class="form-control form-control-sm" value="30">
                    </div>

                    <button class="btn btn-dark btn-sm">Update Security Settings</button>
                </div>
            </div>

            <!-- Currency Settings -->
            <div class="col-md-6">
                <div class="settings-card">
                    <h6>Currency Settings</h6>

                    <div class="mb-3">
                        <label class="form-label">Default Currency</label>
                        <select class="form-select form-select-sm">
                            <option selected>Egyptian Pound (EGP)</option>
                            <option>US Dollar (USD)</option>
                            <option>Euro (EUR)</option>
                            <option>British Pound (GBP)</option>
                        </select>
                    </div>

                    <div class="exchange-box mb-3">
                        <strong>Exchange Rates (Auto-update)</strong><br>
                        1 USD = 30.85 EGP<br>
                        1 EUR = 33.42 EGP<br>
                        <small class="text-muted">Last updated: 2 hours ago</small>
                    </div>

                    <button class="btn btn-dark btn-sm">Update Currency Settings</button>
                </div>
            </div>

            <!-- Notification Settings -->
            <div class="col-md-6">
                <div class="settings-card">
                    <h6>Notification Settings</h6>

                    <div class="form-check mb-2 d-flex justify-content-between me-0 ms-0">

                        <div style="margin-bottom: 10px;">
                            <label class="form-check-label fw-semibold" for="emailNotif">Email Notifications</label>
                            <div class="form-text">Send email alerts for important events</div>
                        </div>
                        <input class="form-check-input" type="checkbox" id="emailNotif" name="emailNo" checked>
                    </div>

                    <div class="form-check mb-2 d-flex justify-content-between me-0 ms-0">

                        <div class="m-0">
                            <label class="form-check-label fw-semibold" for="pyamentAlert">Payment Alerts</label>
                            <div class="form-text">Notify when payments are received</div>
                        </div>
                        <input class="form-check-input" type="checkbox" id="pyamentAlert" name="pyamentAlert" checked>
                    </div>

                    <div class="form-check mb-2 d-flex justify-content-between me-0 ms-0">

                        <div class="m-0">
                            <label class="form-check-label fw-semibold" for="emailNotif">Low balance Warning</label>
                            <div class="form-text">Alert when teacher balances are low</div>
                        </div>
                        <input class="form-check-input" type="checkbox" id="balanceWarning" name="balanceWarning"
                            checked>
                    </div>

                    <button class="btn btn-dark btn-sm">Update Notification Settings</button>
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
@endsection