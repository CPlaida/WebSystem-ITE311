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
                <h1 class="mb-4">About Us</h1>
                <div class="card">
                    <div class="card-body">
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h5 class="text-secondary">What We Do</h5>
                                <p>We help students learn and teachers teach better.</p>
                                
                                <h5 class="text-secondary mt-4">Our Goal</h5>
                                <p>Make learning easy and fun for everyone.</p>
                            </div>
                        <div class="mt-4">
                            <h5 class="text-secondary">What You Can Do</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul>
                                        <li>View courses</li>
                                        <li>Do activities</li>
                                        <li>Check reports</li>
                                        <li>See calendar</li>
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
