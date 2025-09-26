<?php

$role = session('role');
$name = session('name');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?= esc($title ?? 'LMS') ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Bootstrap + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <style>
    .top-header-alt { background: #0d6efd; color: #fff; padding: 14px 20px; }
    .logo h5 { margin: 0; color: #fff; }
    .nav-alt .nav-link { color: #fff; font-weight: 500; }
    .nav-alt .nav-link:hover { color: #ffc107; }
    .dropdown-toggle-alt { background: transparent; border: none; color: #fff; font-weight: 600; }
    .dropdown-menu-custom { display:none; right:0; }
    .dropdown-menu-custom.show { display:block; }
  </style>
</head>
<body class="bg-light">

<!-- New Header Layout -->
<div class="top-header-alt">
  <div class="container-fluid d-flex flex-wrap align-items-center justify-content-between">
    <!-- Left: Logo -->
    <div class="logo">
      <h5>RMMC learning Management System</h5>
    </div>

    <!-- Center: Navigation -->
    <nav>
      <ul class="nav nav-alt">
        <?php if ($role === 'admin'): ?>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/dashboard') ?>">Admin Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="#">User Management</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Courses Management</a></li>
        <?php elseif ($role === 'teacher'): ?>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('teacher/dashboard') ?>">Teacher Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="#">My Courses</a></li>
          <li class="nav-item"><a class="nav-link" href="#">New Lesson</a></li>
        <?php elseif ($role === 'student'): ?>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('student/dashboard') ?>">Student Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="#">My Grades</a></li>
        <?php endif; ?>
      </ul>
    </nav>

    <!-- Right: User Dropdown -->
    <div class="user-dropdown position-relative">
      <button class="dropdown-toggle-alt" onclick="toggleDropdown()">
        <i class="fas fa-user-circle me-1"></i> <?= esc($name ?? 'User') ?>
      </button>
      <div class="dropdown-menu-custom position-absolute bg-white shadow rounded p-2" id="userDropdown">
      <a href="<?= base_url('logout') ?>" class="dropdown-item text-dark text-decoration-none d-block px-2 py-1">
      <i class="fas fa-sign-out-alt me-2"></i>Logout
      </a>
      </div>
    </div>
  </div>
</div>

<script>
  function toggleDropdown() {
    document.getElementById('userDropdown').classList.toggle('show');
  }
  
  // Close dropdown when clicking outside
  window.addEventListener('click', function (event) {
    const btn = document.querySelector('.dropdown-toggle-alt');
    const menu = document.getElementById('userDropdown');
    if (!btn || !menu) return;
    if (!btn.contains(event.target) && !menu.contains(event.target)) {
      menu.classList.remove('show');
    }
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
