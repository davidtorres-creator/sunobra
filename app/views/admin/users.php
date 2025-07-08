<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/dashboard">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/admin/users">
                            <i class="fas fa-users"></i> Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/reports">
                            <i class="fas fa-chart-bar"></i> Reportes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/settings">
                            <i class="fas fa-cog"></i> Configuración
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Gestión de Usuarios</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Exportar</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Filtrar</button>
                    </div>
                    <button type="button" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Nuevo Usuario
                    </button>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="search" class="form-label">Buscar Usuarios</label>
                                    <input type="text" class="form-control" id="search" placeholder="Nombre, email...">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="role" class="form-label">Rol</label>
                                    <select class="form-select" id="role">
                                        <option value="">Todos los roles</option>
                                        <option value="admin">Administrador</option>
                                        <option value="cliente">Cliente</option>
                                        <option value="obrero">Obrero</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="status" class="form-label">Estado</label>
                                    <select class="form-select" id="status">
                                        <option value="">Todos los estados</option>
                                        <option value="active">Activo</option>
                                        <option value="inactive">Inactivo</option>
                                        <option value="suspended">Suspendido</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="button" class="btn btn-primary w-100">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Lista de Usuarios</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Rol</th>
                                            <th>Estado</th>
                                            <th>Fecha Registro</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><?= $user['id'] ?></td>
                                            <td><?= htmlspecialchars($user['nombre'] . ' ' . $user['apellido']) ?></td>
                                            <td><?= htmlspecialchars($user['email']) ?></td>
                                            <td>
                                                <?php
                                                $roleClass = '';
                                                $roleText = '';
                                                switch($user['role']) {
                                                    case 'admin':
                                                        $roleClass = 'bg-warning';
                                                        $roleText = 'Admin';
                                                        break;
                                                    case 'cliente':
                                                        $roleClass = 'bg-primary';
                                                        $roleText = 'Cliente';
                                                        break;
                                                    case 'obrero':
                                                        $roleClass = 'bg-info';
                                                        $roleText = 'Obrero';
                                                        break;
                                                }
                                                ?>
                                                <span class="badge <?= $roleClass ?>"><?= $roleText ?></span>
                                            </td>
                                            <td>
                                                <?php
                                                $statusClass = $user['status'] === 'active' ? 'bg-success' : 'bg-danger';
                                                $statusText = $user['status'] === 'active' ? 'Activo' : 'Inactivo';
                                                ?>
                                                <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                                            </td>
                                            <td><?= htmlspecialchars($user['created_at']) ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="/admin/users/<?= $user['id'] ?>" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal<?= $user['id'] ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal<?= $user['id'] ?>">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Statistics -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Estadísticas de Usuarios</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 text-center mb-3">
                                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                        <span class="h3 mb-0"><?= count($users) ?></span>
                                    </div>
                                    <h6 class="mt-2">Total Usuarios</h6>
                                </div>
                                <div class="col-md-3 text-center mb-3">
                                    <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                        <span class="h3 mb-0"><?= count(array_filter($users, function($u) { return $u['role'] === 'cliente'; })) ?></span>
                                    </div>
                                    <h6 class="mt-2">Clientes</h6>
                                </div>
                                <div class="col-md-3 text-center mb-3">
                                    <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                        <span class="h3 mb-0"><?= count(array_filter($users, function($u) { return $u['role'] === 'obrero'; })) ?></span>
                                    </div>
                                    <h6 class="mt-2">Obreros</h6>
                                </div>
                                <div class="col-md-3 text-center mb-3">
                                    <div class="bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                        <span class="h3 mb-0"><?= count(array_filter($users, function($u) { return $u['role'] === 'admin'; })) ?></span>
                                    </div>
                                    <h6 class="mt-2">Administradores</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Edit User Modals -->
<?php foreach ($users as $user): ?>
<div class="modal fade" id="editUserModal<?= $user['id'] ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/admin/users/<?= $user['id'] ?>" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre<?= $user['id'] ?>" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre<?= $user['id'] ?>" name="nombre" 
                                   value="<?= htmlspecialchars($user['nombre']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="apellido<?= $user['id'] ?>" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido<?= $user['id'] ?>" name="apellido" 
                                   value="<?= htmlspecialchars($user['apellido']) ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email<?= $user['id'] ?>" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email<?= $user['id'] ?>" name="email" 
                               value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="role<?= $user['id'] ?>" class="form-label">Rol</label>
                            <select class="form-select" id="role<?= $user['id'] ?>" name="role" required>
                                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
                                <option value="cliente" <?= $user['role'] === 'cliente' ? 'selected' : '' ?>>Cliente</option>
                                <option value="obrero" <?= $user['role'] === 'obrero' ? 'selected' : '' ?>>Obrero</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status<?= $user['id'] ?>" class="form-label">Estado</label>
                            <select class="form-select" id="status<?= $user['id'] ?>" name="status" required>
                                <option value="active" <?= $user['status'] === 'active' ? 'selected' : '' ?>>Activo</option>
                                <option value="inactive" <?= $user['status'] === 'inactive' ? 'selected' : '' ?>>Inactivo</option>
                                <option value="suspended" <?= $user['status'] === 'suspended' ? 'selected' : '' ?>>Suspendido</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete User Modals -->
<div class="modal fade" id="deleteUserModal<?= $user['id'] ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que quieres eliminar al usuario <strong><?= htmlspecialchars($user['nombre'] . ' ' . $user['apellido']) ?></strong>?</p>
                <p class="text-danger">Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="/admin/users/<?= $user['id'] ?>" method="POST" style="display: inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 