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
                <a class="navbar-brand" href="<?= base_url() ?>">ITE311-PLAIDA</a>
                <div class="navbar-nav me-auto">
                    <a class="nav-link" href="<?= base_url() ?>">Home</a>
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
                    <p class="lead">Your comprehensive learning management system for students, instructors, and administrators.</p>
                    <?php if (!session()->get('isLoggedIn')): ?>
                        <hr class="my-4">
                        <p>Get started by creating an account or logging in to access your personalized dashboard.</p>
                        <a class="btn btn-light btn-lg me-2" href="<?= base_url('register') ?>" role="button">Register</a>
                        <a class="btn btn-outline-light btn-lg" href="<?= base_url('login') ?>" role="button">Login</a>
                    <?php else: ?>
                        <hr class="my-4">
                        <p>Welcome back! Access your role-specific dashboard to continue your work.</p>
                        <a class="btn btn-light btn-lg" href="<?= base_url('dashboard') ?>" role="button">Go to Dashboard</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
