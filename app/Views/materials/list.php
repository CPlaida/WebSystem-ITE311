<?= $this->extend('template') ?>

<?= $this->section('title') ?>Course Materials<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
    <?php $courseIsArray = (isset($course) && is_array($course));
        // support legacy/session key variations (some code uses 'userID')
        $sessionUserId = session()->get('user_id') ?? session()->get('userID');
    ?>
    <?php if ($courseIsArray): ?>
        <!-- Single course -> show materials list -->
        <h2 class="mb-4"><?= esc($course['title'] ?? 'Course') ?> - Materials</h2>

        <?php if (session()->get('role') == 'teacher' || session()->get('role') == 'admin'): ?>
            <!-- Use the GET upload route which maps to Materials::uploadForm -->
            <a href="<?= base_url('materials/upload/' . ($course['id'] ?? '')) ?>" class="btn btn-primary mb-3">
                ➕ Upload Material
            </a>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <?php if (session()->get('role') == 'student' && $courseIsArray && isset($course['id']) && $sessionUserId && !model('EnrollmentModel')->isAlreadyEnrolled($sessionUserId, $course['id'])): ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> You must be enrolled in this course to download materials.
            </div>
        <?php endif; ?>

        <table class="table table-bordered bg-white shadow-sm">
            <thead class="table-primary">
                <tr>
                    <th>File Name</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($materials) && is_array($materials)): ?>
                    <?php foreach ($materials as $m): ?>
                    <tr>
                        <td><?= esc($m['file_name'] ?? '') ?></td>
                        <td><?= esc($m['created_at'] ?? '') ?></td>
                        <td>
                            <?php
                            // Show download button for admins/teachers or enrolled students
                            $canDownload = false;
                            if (session()->get('role') == 'admin' || session()->get('role') == 'teacher') {
                                $canDownload = true;
                            } elseif (session()->get('role') == 'student' && $courseIsArray && $sessionUserId && isset($course['id'])) {
                                $canDownload = model('EnrollmentModel')->isAlreadyEnrolled($sessionUserId, $course['id']);
                            }
                            if ($canDownload):
                            ?>
                                <a href="<?= base_url('materials/download/' . ($m['id'] ?? '')) ?>" class="btn btn-success btn-sm">⬇ Download</a>
                            <?php endif; ?>

                            <?php if (session()->get('role') == 'teacher' || session()->get('role') == 'admin'): ?>
                                <a href="<?= base_url('materials/delete/' . ($m['id'] ?? '')) ?>" class="btn btn-danger btn-sm">🗑 Delete</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted">No materials found for this course.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    <?php else: ?>
        <!-- Courses list (admin/teacher view) -->
        <h2 class="mb-4">📚 Courses</h2>

        <?php $list = !empty($courses) ? $courses : ( !empty($classes) ? $classes : [] ); ?>

        <?php if (empty($list)): ?>
            <div class="alert alert-info">No courses found.</div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($list as $c): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($c['title'] ?? $c['name'] ?? 'Untitled') ?></h5>
                                <p class="card-text text-muted">Instructor: <?= esc($c['instructor_name'] ?? $c['username'] ?? '') ?></p>
                                <div class="d-flex justify-content-between">
                                    <a href="<?= base_url('materials/course/' . ($c['id'] ?? '')) ?>" class="btn btn-outline-primary btn-sm">View Materials</a>
                                    <?php if (session()->get('role') == 'teacher' || session()->get('role') == 'admin'): ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    <?php endif; ?>
</div>
<?= $this->endSection() ?>
