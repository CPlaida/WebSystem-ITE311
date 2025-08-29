<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ITE311-PLAIDA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 bg-primary text-white p-3">
                <div class="text-center mb-4">
                    <h5>ITE311-PLAIDA</h5>
                    <small>Admin Portal</small>
                </div>
                
                <nav class="nav flex-column">
                    <a class="nav-link text-white" href="#">Dashboard</a>
                    <a class="nav-link text-white-50" href="#">Manage Users</a>
                    <a class="nav-link text-white-50" href="#">System Settings</a>
                    <a class="nav-link text-white-50" href="#">Reports</a>
                    <a class="nav-link text-white-50" href="#">Database</a>
                    <a class="nav-link text-white-50" href="#">Security</a>
                    <a class="nav-link text-white-50" href="#">Profile</a>
                    <hr class="my-3">
                    <a class="nav-link text-white-50" href="<?= base_url('/logout') ?>">Logout</a>
                </nav>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 p-4">
                
                <!-- Flash Messages -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Header -->
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">
                        <h3>Welcome, <?= $fullname ?>!</h3>
                        <p class="mb-0">Admin Dashboard - <?= $role ?></p>
                        <small><?= $email ?></small>
                    </div>
                </div>

                <!-- Stats Row -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h4 class="text-danger">150</h4>
                                <p class="mb-0">Total Users</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h4 class="text-warning">8</h4>
                                <p class="mb-0">Active Classes</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h4 class="text-success">99.5%</h4>
                                <p class="mb-0">System Uptime</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Row -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Recent User Activity</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">New Student Registration</h6>
                                            <small class="text-muted">John Doe - john@example.com</small>
                                        </div>
                                        <span class="badge bg-success rounded-pill">New</span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">Instructor Login</h6>
                                            <small class="text-muted">Prof. Smith - 2 hours ago</small>
                                        </div>
                                        <span class="badge bg-info rounded-pill">Login</span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">System Backup</h6>
                                            <small class="text-muted">Daily backup completed</small>
                                        </div>
                                        <span class="badge bg-success rounded-pill">Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>System Overview</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Database Status</h6>
                                            <small class="text-success">Online</small>
                                        </div>
                                        <p class="mb-1">MySQL Server - 2.1GB used</p>
                                        <small class="text-muted">Last backup: 2 hours ago</small>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Server Performance</h6>
                                            <small class="text-success">Optimal</small>
                                        </div>
                                        <p class="mb-1">CPU: 15% | RAM: 45% | Disk: 60%</p>
                                        <small class="text-muted">Response time: 120ms</small>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Security Status</h6>
                                            <small class="text-success">Secure</small>
                                        </div>
                                        <p class="mb-1">SSL Active | Firewall Enabled</p>
                                        <small class="text-muted">Last scan: 1 hour ago</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
