<?php
require_once __DIR__ . '/lib/db_connect.php';
$pdo = getPDO();

// Trae todas las secciones ordenadas
$stmt = $pdo->query("SELECT * FROM sections ORDER BY order_num ASC");
$sections = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>PowerCRUD - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Botón de acceso al Admin, puedes hacerlo fixed o discreto -->
    <div class="text-end p-2 bg-light">
        <a href="admin/login.php" class="btn btn-outline-primary btn-sm">Admin</a>
    </div>

    <div class="container my-3">
        <?php foreach ($sections as $sec): ?>
            <?php
            // Clases personalizadas por tipo
            $class = '';
            if (str_starts_with($sec['name'], 'banner')) {
                $class = 'alert alert-warning text-center my-4 fw-bold';
            } elseif ($sec['name'] === 'header') {
                $class = 'bg-primary text-white text-center p-4 mb-3 rounded';
            } elseif ($sec['name'] === 'footer') {
                $class = 'bg-dark text-white text-center p-3 mt-4 rounded';
            } else {
                $class = 'card mb-3';
            }
            ?>
            <div class="<?= $class ?>">
                <?= $sec['content'] ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>