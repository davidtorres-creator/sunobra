<?php require_once __DIR__ . '/../partials/auth-header.php'; ?>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-user"></i> Detalles del Usuario</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($targetUser) && $targetUser): ?>
                        <dl class="row">
                            <dt class="col-sm-4">ID</dt>
                            <dd class="col-sm-8"><?= htmlspecialchars($targetUser['id']) ?></dd>

                            <dt class="col-sm-4">Nombre</dt>
                            <dd class="col-sm-8"><?= htmlspecialchars($targetUser['nombre'] . ' ' . $targetUser['apellido']) ?></dd>

                            <dt class="col-sm-4">Email</dt>
                            <dd class="col-sm-8"><?= htmlspecialchars($targetUser['email'] ?? $targetUser['correo']) ?></dd>

                            <dt class="col-sm-4">Rol</dt>
                            <dd class="col-sm-8">
                                <?php
                                switch($targetUser['role'] ?? $targetUser['tipo_usuario']) {
                                    case 'admin':
                                        echo '<span class="badge bg-warning">Admin</span>';
                                        break;
                                    case 'cliente':
                                        echo '<span class="badge bg-primary">Cliente</span>';
                                        break;
                                    case 'obrero':
                                        echo '<span class="badge bg-info">Obrero</span>';
                                        break;
                                    default:
                                        echo htmlspecialchars($targetUser['role'] ?? $targetUser['tipo_usuario']);
                                }
                                ?>
                            </dd>

                            <dt class="col-sm-4">Estado</dt>
                            <dd class="col-sm-8">
                                <?php
                                $status = $targetUser['status'] ?? ($targetUser['estado'] == 1 ? 'Activo' : 'Inactivo');
                                $statusClass = ($status === 'Activo' || $status === 'active') ? 'bg-success' : 'bg-danger';
                                $statusText = ($status === 'Activo' || $status === 'active') ? 'Activo' : 'Inactivo';
                                echo '<span class="badge ' . $statusClass . '">' . $statusText . '</span>';
                                ?>
                            </dd>

                            <dt class="col-sm-4">Fecha de Registro</dt>
                            <dd class="col-sm-8"><?= htmlspecialchars($targetUser['created_at'] ?? $targetUser['fecha_registro']) ?></dd>

                            <?php if (!empty($targetUser['telefono'])): ?>
                                <dt class="col-sm-4">Teléfono</dt>
                                <dd class="col-sm-8"><?= htmlspecialchars($targetUser['telefono']) ?></dd>
                            <?php endif; ?>
                            <?php if (!empty($targetUser['direccion'])): ?>
                                <dt class="col-sm-4">Dirección</dt>
                                <dd class="col-sm-8"><?= htmlspecialchars($targetUser['direccion']) ?></dd>
                            <?php endif; ?>
                        </dl>
                        <a href="/admin/users" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver a la lista</a>
                    <?php else: ?>
                        <div class="alert alert-danger">Usuario no encontrado.</div>
                        <a href="/admin/users" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver a la lista</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../partials/auth-footer.php'; ?> 