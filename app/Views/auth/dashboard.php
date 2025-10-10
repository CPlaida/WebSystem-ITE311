<?= $this->extend('template') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>



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
          echo view('student', [
            'username' => $username,
            'enrolledCourses' => $enrolledCourses ?? [],
            'availableCourses' => $availableCourses ?? [],
          ]);
          break;
        default: // Show warning if role is unknown
          echo '<div class="alert alert-warning mt-3">Role not recognized.</div>';
          break;
      }
    ?>
<?= $this->endSection() ?>