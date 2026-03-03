<?php 
include 'db.php';
include 'header.php';
 ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">System Settings</h1>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header"><i class="bi bi-shield-lock"></i> Security Configuration</div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control">
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="2fa">
                            <label class="form-check-label" for="2fa">Enable Two-Factor Authentication</label>
                        </div>
                        <button class="btn btn-danger btn-sm">Change Password</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header"><i class="bi bi-bell"></i> Notification Preferences</div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            Email on Incoming Documents
                            <div class="form-check form-switch"><input class="form-check-input" type="checkbox" checked></div>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            Sms Alert for Urgent Requests
                            <div class="form-check form-switch"><input class="form-check-input" type="checkbox"></div>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            Monthly Report Auto-Generation
                            <div class="form-check form-switch"><input class="form-check-input" type="checkbox" checked></div>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-sm mt-3">Save Preferences</button>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include 'footer.php'; ?>