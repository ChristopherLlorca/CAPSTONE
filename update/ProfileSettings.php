<?php include('header.php'); ?>

<div class="col-md-3 col-lg-2 d-md-block sidebar collapse py-3" id="sidebarMenu">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="Dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="NewDocument.php"><i class="bi bi-file-earmark-plus"></i> New Document</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="Incoming.php">
                <i class="bi bi-inbox"></i> Incoming <span class="badge bg-danger float-end">3</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="Outgoing.php"><i class="bi bi-send"></i> Outgoing</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="ProfileSettings.php"><i class="bi bi-person-gear"></i> Profile & Settings</a>
        </li>
    </ul>
</div>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">My Profile & Settings</h1>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div class="user-avatar mx-auto mb-3" style="width: 100px; height: 100px; font-size: 2.5rem; background-color: #0056b3; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        LR
                    </div>
                    <h5 class="my-3">LHS REGISTRAR ADMIN</h5>
                    <p class="text-muted mb-1">Administrator</p>
                    <p class="text-muted mb-4">Lagro High School, Quezon City</p>
                    <div class="d-flex justify-content-center mb-2">
                        <button type="button" class="btn btn-primary">Upload New Photo</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="settingsTab" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button">Edit Profile</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button">Security</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications" type="button">Notifications</button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="settingsTabContent">
                        
                        <div class="tab-pane fade show active" id="profile" role="tabpanel">
                            <form>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">First Name</label>
                                        <input type="text" class="form-control" value="LHS Registrar">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control" value="Admin">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" class="form-control" value="admin@lagrohs.edu.ph">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Department</label>
                                    <select class="form-select">
                                        <option selected>Registrar's Office</option>
                                        <option>Faculty</option>
                                        <option>Administration</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="security" role="tabpanel">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Current Password</label>
                                    <input type="password" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <input type="password" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-danger">Update Password</button>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="notifications" role="tabpanel">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="emailNotif" checked>
                                <label class="form-check-label" for="emailNotif">Email notifications for new incoming documents</label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="browserNotif">
                                <label class="form-check-label" for="browserNotif">Enable desktop browser alerts</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Preferences</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include('footer.php'); ?>