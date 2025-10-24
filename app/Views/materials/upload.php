<?= $this->extend('template') ?>

<?= $this->section('title') ?>Upload Material<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
    <h2 class="mb-4">Upload Material</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('materials/upload') ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="course_id" value="<?= esc($course_id ?? '') ?>">

        <div class="mb-3">
            <label for="file" class="form-label">Choose file</label>
            <input type="file" name="file" id="file" class="form-control" required>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Upload</button>
            <a href="<?= base_url('materials/course/' . ($course_id ?? '')) ?>" class="btn btn-secondary">Back to Materials</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
