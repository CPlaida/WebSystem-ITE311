<!DOCTYPE html>
<html>
<head>s
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
            <div class="container-fluid">
                <div class="navbar-nav me-auto">
                    <a class="nav-link" href="<?= base_url('home') ?>">Home</a>
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
                <h1 class="mb-4">Contact Us</h1>
                <div class="card">
                    <div class="card-body">
                
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-primary">Get Help</h5>
                                <p><strong>Email:</strong> help@ite311.com</p>
                                <p><strong>Phone:</strong>09228765</p>
                                <p><strong>Website:</strong> www.ite311.com</p>
                                
                                <h5 class="text-primary mt-4">Address</h5>
                                <p>Pioneer Avenue<br>
                               General Santos City<br>
                                Philippines</p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-primary">Office Hours</h5>
                                <p><strong>Monday - Friday:</strong> 8:00 AM - 5:00 PM</p>
                                <p><strong>Saturday:</strong> 9:00 AM - 12:00 PM</p>
                                <p><strong>Sunday:</strong> Closed</p>
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
