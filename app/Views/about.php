<!DOCTYPE html>
<html>
<head>
    <title>About - ITE311-PLAIDA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?= base_url() ?>">ITE311-PLAIDA</a>
                <div class="navbar-nav me-auto">
                    <a class="nav-link" href="<?= base_url() ?>">Home</a>
                    <a class="nav-link active" href="<?= base_url('about') ?>">About</a>
                    <a class="nav-link" href="<?= base_url('contact') ?>">Contact</a>
                </div>
                <div class="navbar-nav">
                    <?php if (session()->get('isLoggedIn')): ?>
                        <span class="navbar-text me-3">Welcome, <?= session()->get('fullname') ?>!</span>
                        <a class="nav-link" href="<?= base_url('dashboard') ?>">Dashboard</a>
                        <a class="nav-link" href="<?= base_url('logout') ?>">Logout</a>
                    <?php else: ?>
                        <a class="nav-link" href="<?= base_url('login') ?>">Login</a>
                        <a class="nav-link" href="<?= base_url('register') ?>">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-4">About RMMC</h1>
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-primary mb-3">Ramon Magsaysay Memorial Colleges</h3>
                        <p class="lead">A leading educational institution in General Santos City committed to providing quality education and developing future leaders.</p>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h5 class="text-secondary">Vision</h5>
                                <p>RMMC is an institution of innovative development and excellence.</p>
                                
                                <h5 class="text-secondary mt-4">Mission</h5>
                                <p>RMMC is committed to realize human potentials through holistic education.</p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-secondary">Core Values</h5>
                                <ul>
                                    <li>Love of God</li>
                                    <li>Integrity</li>
                                    <li>Patriotism</li>
                                    <li>Service</li>
                                    <li>Excellence</li>
                                </ul>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h5 class="text-secondary">Programs Offered</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul>
                                        <li>Business Administration</li>
                                        <li>Information Technology</li>
                                        <li>Education</li>
                                        <li>Engineering</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul>
                                        <li>Nursing</li>
                                        <li>Criminology</li>
                                        <li>Tourism Management</li>
                                        <li>Arts and Sciences</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
