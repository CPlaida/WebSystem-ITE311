<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Dashboard - ITE311-PLAIDA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 bg-primary text-white p-3">
                <div class="text-center mb-4">
                    <h5>ITE311-PLAIDA</h5>
                    <small>Instructor Portal</small>
                </div>
                
                <nav class="nav flex-column">
                    <a class="nav-link text-white" href="#"><i class="fas fa-home"></i> Dashboard</a>
                    <a class="nav-link text-white-50" href="#"><i class="fas fa-chalkboard-teacher"></i> My Classes</a>
                    <a class="nav-link text-white-50" href="#"><i class="fas fa-plus-circle"></i> Create Assignment</a>
                    <a class="nav-link text-white-50" href="#"><i class="fas fa-clipboard-check"></i> Grade Students</a>
                    <a class="nav-link text-white-50" href="#"><i class="fas fa-chart-bar"></i> Analytics</a>
                    <a class="nav-link text-white-50" href="#"><i class="fas fa-users"></i> Students</a>
                    <a class="nav-link text-white-50" href="#"><i class="fas fa-user"></i> Profile</a>
                    <hr class="my-3">
                    <a class="nav-link text-white-50" href="<?= base_url('/logout') ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
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
                        <p class="mb-0">Instructor Dashboard - <?= $role ?></p>
                        <small><?= $email ?></small>
                    </div>
                </div>

                <!-- Stats Row -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h4 class="text-success">4</h4>
                                <p class="mb-0">Active Classes</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h4 class="text-warning">12</h4>
                                <p class="mb-0">Pending Grades</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h4 class="text-info">85</h4>
                                <p class="mb-0">Total Students</p>
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
                                            <small class="text-muted">ITE311 - 25 submissions</small>
                                        </div>
                                        <span class="badge bg-success rounded-pill">Active</span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">Web Development Quiz</h6>
                                            <small class="text-muted">ITE312 - 30 submissions</small>
                                        </div>
                                        <span class="badge bg-warning rounded-pill">Grading</span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">System Analysis Report</h6>
                                            <small class="text-muted">ITE313 - 18 submissions</small>
                                        </div>
                                        <span class="badge bg-info rounded-pill">Draft</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Today's Schedule</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Database Systems (ITE311)</h6>
                                            <small>9:00 - 11:00 AM</small>
                                        </div>
                                        <p class="mb-1">Room 301 - 25 Students</p>
                                        <small class="text-muted">Lecture: Normalization</small>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Web Development (ITE312)</h6>
                                            <small>2:00 - 4:00 PM</small>
                                        </div>
                                        <p class="mb-1">Room 205 - 30 Students</p>
                                        <small class="text-muted">Lab: PHP Frameworks</small>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Office Hours</h6>
                                            <small>4:00 - 5:00 PM</small>
                                        </div>
                                        <p class="mb-1">Office 102</p>
                                        <small class="text-muted">Student Consultations</small>
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
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js"></script>
</body>
</html>
