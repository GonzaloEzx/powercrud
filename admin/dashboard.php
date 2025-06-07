<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../lib/db_connect.php';

$pdo = getPDO();
$stmt = $pdo->query("SELECT * FROM sections ORDER BY order_num ASC");
$sections = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">PowerCRUD Admin</span>
            <span class="text-muted">Usuario: <b><?= htmlspecialchars($_SESSION['admin_username']) ?></b></span>
            <a href="logout.php" class="btn btn-outline-danger btn-sm">Salir</a>
        </div>
    </nav>
    <div class="container mt-4">
        <h2>Secciones del sitio</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Título</th>
                    <th>Orden</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sections as $sec): ?>
                    <tr>
                        <td><?= htmlspecialchars($sec['name']) ?></td>
                        <td><?= htmlspecialchars($sec['title']) ?></td>
                        <td><?= (int)$sec['order_num'] ?></td>
                        <td>
                            <a href="edit_section.php?id=<?= $sec['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>