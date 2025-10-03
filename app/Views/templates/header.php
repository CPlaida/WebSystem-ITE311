<?php $role = session('role') ?? null; $name = session('name') ?? null; ?>
<div class="top-header-alt">
  <div class="container-fluid d-flex flex-wrap align-items-center justify-content-between">
    <!-- Left: Logo -->
    <div class="logo">
      <h5>RMMC Learning Management System</h5>
    </div>

    <!-- Center: Navigation -->
    <nav>
      <ul class="nav nav-alt">
        <?php if ($role === 'admin'): ?>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/dashboard') ?>">Admin Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Reports & Analytics</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Settings</a></li>
        <?php elseif ($role === 'teacher'): ?>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('teacher/dashboard') ?>">Teacher Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="#">My Courses</a></li>
          <li class="nav-item"><a class="nav-link" href="#">New Lesson</a></li>
        <?php elseif ($role === 'student'): ?>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('student/dashboard') ?>">Student Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="#">My Grades</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('home') ?>">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('about') ?>">About</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('contact') ?>">Contact</a></li>
        <?php endif; ?>
      </ul>
    </nav>

    <!-- Right: Auth controls -->
    <?php if (session('isLoggedIn')): ?>
      <!-- Show user dropdown only when logged in -->
      <div class="user-dropdown position-relative">
        <button class="dropdown-toggle-alt" type="button" onclick="toggleDropdown()">
          <i class="fas fa-user-circle me-1"></i> <?= esc($name ?? 'User') ?>
        </button>
        <div class="dropdown-menu-custom position-absolute bg-white shadow rounded p-2" id="userDropdown">
          <a href="<?= base_url('logout') ?>" class="dropdown-item text-dark text-decoration-none d-block px-2 py-1">
            <i class="fas fa-sign-out-alt me-2"></i>Logout
          </a>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>
