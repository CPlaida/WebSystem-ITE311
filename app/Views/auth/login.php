<?= $this->extend('template') ?>

<?= $this->section('title') ?>Login<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="row justify-content-center mt-2">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Login</h4>
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

                    <!-- Login Form -->
                    <form method="POST" action="<?= base_url('/login') ?>">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>

                    <div class="text-center mt-2">
                        <p class="mt-3">Don't have an account? <a href="<?= base_url('register') ?>">Register here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
