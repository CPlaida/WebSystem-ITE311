<?= $this->extend('template') ?>

<?= $this->section('title') ?>Home<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="row">
        <div class="col-md-12">
            <div class="home-hero">
                <h1 class="display-4">Welcome to RMMC</h1>
                <p class="lead">Learning system for students and teachers.</p>
                <hr class="my-4">
                <p>Click login or register to start.</p>
                <a class="btn btn-outline-light btn-lg me-2" href="<?= base_url('login') ?>" role="button">Login</a>
                <a class="btn btn-outline-light btn-lg" href="<?= base_url('register') ?>" role="button">Register</a>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
