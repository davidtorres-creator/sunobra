<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="/cliente/dashboard">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/cliente/profile">
                            <i class="fas fa-user"></i> Mi Perfil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/cliente/services">
                            <i class="fas fa-tools"></i> Servicios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/cliente/requests">
                            <i class="fas fa-clipboard-list"></i> Mis Solicitudes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/cliente/history">
                            <i class="fas fa-history"></i> Historial
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Mi Perfil</h1>
            </div>

            <!-- Profile Form -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Información Personal</h6>
                        </div>
                        <div class="card-body">
                            <form action="/cliente/profile" method="POST">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nombre" class="form-label">Nombre *</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" 
                                               value="<?= htmlspecialchars($user['nombre'] ?? '') ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="apellido" class="form-label">Apellido *</label>
                                        <input type="text" class="form-control" id="apellido" name="apellido" 
                                               value="<?= htmlspecialchars($user['apellido'] ?? '') ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" 
                                               value="<?= htmlspecialchars($user['correo'] ?? '') ?>" readonly>
                                        <small class="text-muted">El email no se puede cambiar</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="telefono" class="form-label">Teléfono</label>
                                        <input type="tel" class="form-control" id="telefono" name="telefono" 
                                               value="<?= htmlspecialchars($user['telefono'] ?? '') ?>">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="direccion" class="form-label">Dirección</label>
                                    <textarea class="form-control" id="direccion" name="direccion" rows="3"><?= htmlspecialchars($user['direccion'] ?? '') ?></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="fecha_registro" class="form-label">Fecha de Registro</label>
                                        <input type="text" class="form-control" id="fecha_registro" 
                                               value="<?= htmlspecialchars($user['fecha_registro'] ?? '') ?>" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="estado" class="form-label">Estado</label>
                                        <input type="text" class="form-control" id="estado" 
                                               value="<?= htmlspecialchars($user['estado'] ?? 'Activo') ?>" readonly>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Guardar Cambios
                                    </button>
                                    <a href="/cliente/dashboard" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Volver al Dashboard
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Section -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Seguridad</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Cambiar Contraseña</h6>
                                    <p class="text-muted">Actualiza tu contraseña para mantener tu cuenta segura.</p>
                                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                        <i class="fas fa-key"></i> Cambiar Contraseña
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <h6>Autenticación de Dos Factores</h6>
                                    <p class="text-muted">Añade una capa extra de seguridad a tu cuenta.</p>
                                    <button class="btn btn-info" disabled>
                                        <i class="fas fa-shield-alt"></i> Configurar 2FA
                                    </button>
                                    <small class="text-muted d-block mt-2">Próximamente</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar Contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/cliente/change-password" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Contraseña Actual</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Nueva Contraseña</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 