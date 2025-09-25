<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
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
                    <a class="nav-link" href="<?= base_url('contact') ?>">Contact</a>
                </div>
                <div class="navbar-nav">
                    <?php if (session()->get('isLoggedIn')): ?>
                        <span class="navbar-text me-3">Welcome, <?= session()->get('fullname') ?>!</span>
                        <a class="nav-link" href="<?= base_url('dashboard') ?>">Dashboard</a>
                        <a class="nav-link" href="<?= base_url('logout') ?>">Logout</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="row">
            <div class="col-md-12">
                <div class="jumbotron bg-primary text-white p-5 rounded">
                    <h1 class="display-4">Welcome to RMMC</h1>
                    <p class="lead">Learning system for students and teachers.</p>
                    <hr class="my-4">
                    <?php if (!session()->get('isLoggedIn')): ?>
                        <p>Click login or register to start.</p>
                    <?php else: ?>
                        <p>Welcome back! Go to your dashboard.</p>
                    <?php endif; ?>
                    <a class="btn btn-outline-light btn-lg me-2" href="<?= base_url('login') ?>" role="button">Login</a>
                    <a class="btn btn-outline-light btn-lg" href="<?= base_url('register') ?>" role="button">Register</a>
                    <?php if (session()->get('isLoggedIn')): ?>
                        <a class="btn btn-light btn-lg ms-2" href="<?= base_url('dashboard') ?>" role="button">Dashboard</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
