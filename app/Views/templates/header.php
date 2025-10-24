<?php $role = session('role') ?? null; $displayName = session('username') ?? session('name') ?? 'User'; ?>
<div class="top-header-alt">
  <div class="container-fluid d-flex flex-wrap align-items-center justify-content-between">
    <!-- Left: Logo -->
    <div class="logo">
      <h5>Learning Management System</h5>
    </div>

    <!-- Center: Navigation -->
    <nav>
      <ul class="nav nav-alt">
        <?php if ($role === 'admin'): ?>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('dashboard') ?>">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="#">User Management</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('/admin/courses') ?>">Course Management</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Enrollment Records</a></li>
        <?php elseif ($role === 'teacher'): ?>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('dashboard') ?>">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('/teacher/classes') ?>">My Classes</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Assignments</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Grades</a></li>
        <?php elseif ($role === 'student'): ?>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('dashboard') ?>">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('dashboard') ?>?view=courses">My Courses</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Assignments</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Grades</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('home') ?>">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('about') ?>">About</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('contact') ?>">Contact</a></li>
        <?php endif; ?>
      </ul>
    </nav>


    <!-- Right: Auth controls -->
    <?php if (session('isLoggedIn')): ?>
      <!-- Right controls: notifications + user dropdown side-by-side -->
      <div class="d-flex align-items-center gap-3">
        <!-- Notifications bell beside username -->
        <div class="nav-item dropdown">
          <a class="nav-link position-relative dropdown-toggle text-white p-0" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="me-1">🔔</span>
            <?php if (!empty($notifUnread)): ?>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notif-badge">
                <?= (int) $notifUnread ?>
              </span>
            <?php else: ?>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notif-badge d-none">0</span>
            <?php endif; ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notifDropdown" id="notifMenu" style="min-width:320px; max-height: 360px; overflow-y: auto;">
            <li class="dropdown-header">Notifications</li>
            <?php if (!empty($notifRecent)): ?>
              <?php foreach ($notifRecent as $n): ?>
                <li class="dropdown-item small" data-id="<?= (int)($n['id'] ?? 0) ?>">
                  <div class="<?= (int)($n['is_read'] ?? 0) === 0 ? 'fw-semibold' : '' ?>">
                    <?= esc($n['message'] ?? '') ?>
                  </div>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small"><?= esc($n['created_at'] ?? '') ?></div>
                    <?php if ((int)($n['is_read'] ?? 0) === 0): ?>
                      <button class="btn btn-link btn-sm p-0 js-mark-read">Mark as read</button>
                    <?php endif; ?>
                  </div>
                </li>
              <?php endforeach; ?>
            <?php else: ?>
              <li class="dropdown-item text-muted small">No notifications</li>
            <?php endif; ?>
          </ul>
        </div>

        <!-- User dropdown -->
        <div class="user-dropdown position-relative">
          <button class="dropdown-toggle-alt" type="button" onclick="toggleDropdown()">
            <i class="fas fa-user-circle me-1"></i> <?= esc($displayName) ?>
          </button>
          <div class="dropdown-menu-custom position-absolute bg-white shadow rounded p-2" id="userDropdown">
            <a href="<?= base_url('logout') ?>" class="dropdown-item text-dark text-decoration-none d-block px-2 py-1">
              <i class="fas fa-sign-out-alt me-2"></i>Logout
            </a>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>
