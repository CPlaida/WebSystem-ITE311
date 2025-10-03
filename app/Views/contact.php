<?= $this->extend('template') ?>

<?= $this->section('title') ?>Contact<?= $this->endSection() ?>

<?= $this->section('content') ?>
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
<?= $this->endSection() ?>
