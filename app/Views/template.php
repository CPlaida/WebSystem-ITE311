<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ITE311-PLAIDA</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="#">Welcome to CodeIgniter 4 with Bootstrap! </a>
        </div>
    </nav>
    <div class="container mt-4">
        <?= $this->renderSection('content') ?>
    </div>
</body>
</html>
