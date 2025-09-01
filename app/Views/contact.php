<!DOCTYPE html>
<html>
<head>
    <title>Contact - ITE311-PLAIDA</title>
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
                    <a class="nav-link" href="<?= base_url('about') ?>">About</a>
                    <a class="nav-link active" href="<?= base_url('contact') ?>">Contact</a>
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
                <h1 class="mb-4">Contact RMMC</h1>
                <div class="card">
                    <div class="card-body">
                        <p class="lead">Get in touch with Ramon Magsaysay Memorial Colleges for inquiries and information.</p>
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-primary">Campus Address</h5>
                                <p><strong>Ramon Magsaysay Memorial Colleges</strong><br>
                                National Highway, Fatima<br>
                                General Santos City 9500<br>
                                South Cotabato, Philippines</p>
                                
                                <p><strong>Phone:</strong> (083) 552-8293</p>
                                <p><strong>Email:</strong> info@rmmc.edu.ph</p>
                                <p><strong>Website:</strong> www.rmmc.edu.ph</p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-primary">Office Hours</h5>
                                <p><strong>Monday - Friday:</strong> 7:00 AM - 5:00 PM</p>
                                <p><strong>Saturday:</strong> 7:00 AM - 12:00 PM</p>
                                <p><strong>Sunday:</strong> Closed</p>
                                
                                <h5 class="text-primary mt-4">Admissions Office</h5>
                                <p><strong>Phone:</strong> (083) 552-8293 loc. 101</p>
                                <p><strong>Email:</strong> admissions@rmmc.edu.ph</p>
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
