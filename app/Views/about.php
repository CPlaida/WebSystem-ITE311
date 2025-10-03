<?= $this->extend('template') ?>

<?= $this->section('title') ?>About<?= $this->endSection() ?>

<?= $this->section('content') ?>
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
<?= $this->endSection() ?>
