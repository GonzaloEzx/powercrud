<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../lib/db_connect.php';

$pdo = getPDO();

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: dashboard.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM sections WHERE id = ?");
$stmt->execute([$id]);
$section = $stmt->fetch();

if (!$section) {
    header('Location: dashboard.php');
    exit;
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    // Si más adelante agregás imagen, procesala acá

    $update = $pdo->prepare("UPDATE sections SET title = ?, content = ?, updated_at = NOW() WHERE id = ?");
    if ($update->execute([$title, $content, $id])) {
        $success = "Sección actualizada correctamente.";
        // Refrescamos datos para mostrar los nuevos valores
        $stmt->execute([$id]);
        $section = $stmt->fetch();
    } else {
        $error = "Hubo un error al actualizar la sección.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar sección - <?= htmlspecialchars($section['title']) ?></title>
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
        <a href="dashboard.php" class="btn btn-secondary mb-3">&larr; Volver</a>
        <h2>Editar sección: <span class="text-primary"><?= htmlspecialchars($section['title']) ?></span></h2>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">Título</label>
                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($section['title']) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Contenido (puede usar HTML)</label>
                <textarea name="content" class="form-control" rows="5"><?= htmlspecialchars($section['content']) ?></textarea>
            </div>
            <!-- Si más adelante agregás imagen, poné el input acá -->
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    </div>
</body>

</html>