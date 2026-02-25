<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'GestiEstudiantes') ?></title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary: #1e3a5f;
            --primary-light: #2d6a9f;
        }

        body { background-color: #f0f4f8; }

        /* ── Navbar ── */
        .navbar-brand { font-weight: 700; letter-spacing: .5px; }
        .navbar { background: linear-gradient(135deg, var(--primary), var(--primary-light)) !important; }
        .navbar .nav-link { color: rgba(255,255,255,.85) !important; }
        .navbar .nav-link:hover,
        .navbar .nav-link.active { color: #fff !important; }
        .navbar .nav-link i { margin-right: .3rem; }

        /* ── Cards ── */
        .card { border: none; border-radius: .75rem; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
        .card-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: #fff;
            border-radius: .75rem .75rem 0 0 !important;
            font-weight: 600;
        }

        /* ── Botones primarios ── */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border: none;
        }
        .btn-primary:hover { opacity: .88; }

        /* ── Badges de estado ── */
        .badge-activo     { background-color: #198754; }
        .badge-inactivo   { background-color: #6c757d; }
        .badge-suspendido { background-color: #dc3545; }

        /* ── Tabla ── */
        .table thead th { background-color: #e8eef5; font-weight: 600; }
        .table-hover tbody tr:hover { background-color: #f0f6ff; }

        /* ── Footer ── */
        footer { font-size: .8rem; color: #aaa; }
    </style>
</head>
<body>
