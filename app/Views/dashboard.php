<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - RMMC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 bg-primary text-white p-3">
                <div class="text-center mb-4">
                    <h5>RMMC SYSTEM</h5>
                    <small>Dashboard</small>
                </div>
                
                <nav class="nav flex-column">
                    <a class="nav-link text-white" href="#">Home</a>
                    <a class="nav-link text-white-50" href="#">Courses</a>
                    <a class="nav-link text-white-50" href="#">Activities</a>
                    <a class="nav-link text-white-50" href="#">Reports</a>
                    <a class="nav-link text-white-50" href="#">Calendar</a>
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
                        <h3>Welcome, <?= $username ?>!</h3>
                        <p class="mb-0">RMMC System</p>
                        <small><?= $email ?></small>
                    </div>
                </div>

                <!-- Stats Row -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h4 class="text-primary">8</h4>
                                <p class="mb-0">Available Courses</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h4 class="text-warning">15</h4>
                                <p class="mb-0">Active Tasks</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h4 class="text-success">100%</h4>
                                <p class="mb-0">System Online</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Row -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Recent Activity</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">Course Updated</h6>
                                            <small class="text-muted">ITE311 - New materials added</small>
                                        </div>
                                        <span class="badge bg-info rounded-pill">Update</span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">Task Completed</h6>
                                            <small class="text-muted">Assignment submission processed</small>
                                        </div>
                                        <span class="badge bg-success rounded-pill">Done</span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">System Notice</h6>
                                            <small class="text-muted">Maintenance scheduled for tonight</small>
                                        </div>
                                        <span class="badge bg-warning rounded-pill">Notice</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Quick Links</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Course Materials</h6>
                                            <small class="text-primary">Available</small>
                                        </div>
                                        <p class="mb-1">Access all course resources and materials</p>
                                        <small class="text-muted">Updated daily</small>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Activity Center</h6>
                                            <small class="text-primary">Active</small>
                                        </div>
                                        <p class="mb-1">View and manage all activities</p>
                                        <small class="text-muted">Real-time updates</small>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Reports</h6>
                                            <small class="text-primary">Ready</small>
                                        </div>
                                        <p class="mb-1">Generate and view reports</p>
                                        <small class="text-muted">Comprehensive data</small>
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
