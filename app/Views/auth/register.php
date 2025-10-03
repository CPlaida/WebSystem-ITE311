<?= $this->extend('template') ?>

<?= $this->section('title') ?>Register<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="row justify-content-center mt-2">
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
                                    <li><?= esc($error) ?></li>
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
                   <p class="mt-3 text-center">
                        Already have an account? <a href="<?= base_url('login') ?>">Login here</a>
                    </p>
                    
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
