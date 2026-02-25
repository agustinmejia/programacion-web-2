<nav class="navbar navbar-expand-lg shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand text-white" href="../students/index.php">
            <i class="bi bi-mortarboard-fill me-2"></i>GestiEstudiantes
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) === 'index.php') ? 'active fw-semibold' : '' ?>"
                       href="../students/index.php">
                        <i class="bi bi-people"></i> Estudiantes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) === 'create.php') ? 'active fw-semibold' : '' ?>"
                       href="../students/create.php">
                        <i class="bi bi-person-plus"></i> Nuevo estudiante
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle fs-5"></i>
                        <span><?= htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Usuario') ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li>
                            <span class="dropdown-item-text text-muted small">
                                Rol: <?= htmlspecialchars($_SESSION['usuario_rol'] ?? '') ?>
                            </span>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="../auth/logout.php">
                                <i class="bi bi-box-arrow-right me-1"></i> Cerrar sesión
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
