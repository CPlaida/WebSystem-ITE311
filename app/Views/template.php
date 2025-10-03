<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - ITE311-PLAIDA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f4; }

        /* Header*/
        .top-header-alt { background: #0d6efd; color: #fff; padding: 14px 20px; }
        .logo h5 { margin: 0; color: #fff; }
        .nav-alt .nav-link { color: #fff; font-weight: 500; }
        .nav-alt .nav-link:hover { color: #ffc107; }
        .dropdown-toggle-alt { background: transparent; border: none; color: #fff; font-weight: 600; }
        .dropdown-menu-custom { display: none; right: 0; }
        .dropdown-menu-custom.show { display: block; }
        
        /* White margin orcontainer */
        .main-content { background-color: white; margin: 0; width: 100%; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        h1, h2, h3 { margin-bottom: 1rem; color:#000; }
        p { margin-bottom: 1rem; color:#333; }
        
        /* card */
        .card { background-color: #f8f9fa; padding: 1.5rem; margin-bottom: 1rem; border-radius: 6px; border-left: 4px solid #3498db; }
        .form-group { margin-bottom: 1rem; }
        
        /* label */
        label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
        input, textarea { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; }
        input:focus, textarea:focus { outline: none; border-color: #3498db; }

        /* Home page text color */
        .home-hero { background: #0d6efd; border-radius: 8px; padding: 2.5rem; }
        .home-hero h1,
        .home-hero p,
        .home-hero .lead { color: #fff !important; }
        .home-hero hr { border-top: 1px solid rgba(255,255,255,.25); }
    </style>
</head>
<body>
    <!-- Header include -->
    <?= $this->include('templates/header') ?>

    <!-- Main Content -->
    <div class="container-fluid px-0">
        <main class="main-content">
            <?= $this->renderSection('content') ?>
        </main>
    </div>

    <script>
      // Dropdown behavior for header user menu
      function toggleDropdown() {
        const menu = document.getElementById('userDropdown');
        if (menu) menu.classList.toggle('show');
      }
      window.addEventListener('click', function (event) {
        const btn = document.querySelector('.dropdown-toggle-alt');
        const menu = document.getElementById('userDropdown');
        if (!btn || !menu) return;
        if (!btn.contains(event.target) && !menu.contains(event.target)) {
          menu.classList.remove('show');
        }
      });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
