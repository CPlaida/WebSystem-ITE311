<?= $this->extend('template') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Welcome Message -->
    <div class="alert alert-primary alert-dismissible fade show mb-4" role="alert">
        <h1 class="fw-semibold text-primary mb-1">Welcome back, <?= esc($user['username'] ?? session('name')) ?>!</h1>
        <p class="text-success small mb-0">Here are your latest updates.</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <?php
      // Wrapper: load role-specific partials
      $role = $user['role'] ?? session('role');  
      $username = $user['username'] ?? session('username');
      
      switch ($role) {
        case 'admin':
          echo view('admin', ['username' => $username]);
          break;
        case 'teacher':
          echo view('teacher', ['username' => $username]);
          break;
        case 'student':
          echo view('student', ['username' => $username]);
          break;
        default: // Show warning if role is unknown
          echo '<div class="alert alert-warning mt-3">Role not recognized.</div>';
          break;
      }
    ?>
<?= $this->endSection() ?>