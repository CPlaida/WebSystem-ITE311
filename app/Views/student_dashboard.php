<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - ITE311-PLAIDA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 bg-primary text-white p-3">
                <div class="text-center mb-4">
                    <h5>ITE311-PLAIDA</h5>
                    <small>Student Portal</small>
                </div>
                
                <nav class="nav flex-column">
                    <a class="nav-link text-white" href="#">Dashboard</a>
                    <a class="nav-link text-white-50" href="#">My Courses</a>
                    <a class="nav-link text-white-50" href="#">Assignments</a>
                    <a class="nav-link text-white-50" href="#">Grades</a>
                    <a class="nav-link text-white-50" href="#">Schedule</a>
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
                        <p class="mb-0">Student Dashboard - <?= $role ?></p>
                        <small><?= $email ?></small>
                    </div>
                </div>

                <!-- Stats Row -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h4 class="text-primary">5</h4>
                                <p class="mb-0">Enrolled Courses</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h4 class="text-warning">3</h4>
                                <p class="mb-0">Pending Assignments</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h4 class="text-success">85%</h4>
                                <p class="mb-0">Average Grade</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Row -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Recent Assignments</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">Database Design Project</h6>
                                            <small class="text-muted">Due: March 15, 2024</small>
                                        </div>
                                        <span class="badge bg-warning rounded-pill">Pending</span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">Web Development Quiz</h6>
                                            <small class="text-muted">Due: March 20, 2024</small>
                                        </div>
                                        <span class="badge bg-success rounded-pill">Completed</span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">System Analysis Report</h6>
                                            <small class="text-muted">Due: March 25, 2024</small>
                                        </div>
                                        <span class="badge bg-info rounded-pill">In Progress</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Upcoming Classes</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Database Systems</h6>
                                            <small>9:00 AM</small>
                                        </div>
                                        <p class="mb-1">Room 301 - Prof. Smith</p>
                                        <small class="text-muted">Today</small>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Web Development</h6>
                                            <small>2:00 PM</small>
                                        </div>
                                        <p class="mb-1">Room 205 - Prof. Johnson</p>
                                        <small class="text-muted">Today</small>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">System Analysis</h6>
                                            <small>10:00 AM</small>
                                        </div>
                                        <p class="mb-1">Room 102 - Prof. Davis</p>
                                        <small class="text-muted">Tomorrow</small>
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
