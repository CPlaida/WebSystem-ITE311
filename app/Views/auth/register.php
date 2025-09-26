<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ITE311-PLAIDA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-white">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Register</h4>
                    </div>
                    <div class="card-body">
                        <!-- Flash Messages -->
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success">
                                <?= session()->getFlashdata('success') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('errors')): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                        <li><?= $error ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($validation)): ?>
                            <div class="alert alert-danger">
                                <?= $validation->listErrors() ?>
                            </div>
                        <?php endif; ?>

                        <!-- Registration Form -->
                        <form method="POST" action="<?= base_url('/register') ?>">
                         <?= csrf_field() ?>
                         <input type="text" name="username" placeholder="Username" required class="form-control mb-2">
                         <input type="email" name="email" placeholder="Email" required class="form-control mb-2">
                         <input type="password" name="password" placeholder="Password" required class="form-control mb-2">
                         <input type="password" name="password_confirm" placeholder="Confirm Password" required class="form-control mb-2">
                         <select name="role" class="form-select mb-3">
                         <option value="student" selected>Student</option>
                         <option value="teacher">Teacher</option>
                         <option value="admin">Admin</option>
                         </select>
                         <button type="submit" class="btn btn-primary w-100">Register</button>
                         </form>
                        <div class="text-center mt-2">
                            <a href="<?= base_url('/login') ?>">Already have an account?</a>
                        </div>
                        <div class="text-center mt-1">
                            <a href="<?= base_url('home') ?>">Back to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
