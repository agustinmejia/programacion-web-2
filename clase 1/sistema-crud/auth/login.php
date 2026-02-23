<?php
session_start();

// Si ya está logueado, redirigir al dashboard
if (isset($_SESSION['usuario_id'])) {
    header('Location: ../students/index.php');
    exit;
}

require_once __DIR__ . '/../config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']    ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
        $error = 'Por favor completá todos los campos.';
    } else {
        $db   = getDB();
        $stmt = $db->prepare('SELECT id, nombre, password, rol FROM usuarios WHERE email = ? AND activo = 1 LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['usuario_id']     = $user['id'];
            $_SESSION['usuario_nombre'] = $user['nombre'];
            $_SESSION['usuario_rol']    = $user['rol'];
            header('Location: ../students/index.php');
            exit;
        } else {
            $error = 'Email o contraseña incorrectos.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión – GestiEstudiantes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1e3a5f 0%, #2d6a9f 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 20px 60px rgba(0,0,0,.35);
            max-width: 420px;
            width: 100%;
        }
        .login-header {
            background: linear-gradient(135deg, #1e3a5f, #2d6a9f);
            border-radius: 1rem 1rem 0 0;
            padding: 2rem;
            text-align: center;
            color: #fff;
        }
        .login-header i { font-size: 3rem; }
        .login-body { padding: 2rem; }
        .btn-login {
            background: linear-gradient(135deg, #1e3a5f, #2d6a9f);
            color: #fff;
            border: none;
        }
        .btn-login:hover { opacity: .88; color: #fff; }
        .form-control:focus { border-color: #2d6a9f; box-shadow: 0 0 0 .2rem rgba(45,106,159,.25); }
    </style>
</head>
<body>
<div class="login-card card mx-3">
    <div class="login-header">
        <i class="bi bi-mortarboard-fill"></i>
        <h4 class="mt-2 mb-0">GestiEstudiantes</h4>
        <small class="opacity-75">Sistema de gestión escolar</small>
    </div>

    <div class="login-body">
        <h5 class="mb-4 text-center text-secondary">Iniciá sesión</h5>

        <?php if ($error !== ''): ?>
            <div class="alert alert-danger d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <form method="POST" novalidate>
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        placeholder="admin@sistema.com"
                        value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                        required
                        autofocus
                    >
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label fw-semibold">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        placeholder="••••••••"
                        required
                    >
                </div>
            </div>

            <button type="submit" class="btn btn-login w-100 py-2 fw-semibold">
                <i class="bi bi-box-arrow-in-right me-1"></i> Ingresar
            </button>
        </form>

        <p class="text-center text-muted small mt-4 mb-0">
            Demo: <strong>admin@sistema.com</strong> / <strong>password</strong>
        </p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
