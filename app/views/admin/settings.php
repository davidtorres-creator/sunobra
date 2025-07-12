<?php require_once __DIR__ . '/../partials/auth-header.php'; ?>

<style>
body, .container-fluid, .container {
    background: #181818 !important;
    color: #fff !important;
}
.sidebar, .bg-light.sidebar {
    background: #232323 !important;
    color: #fff !important;
    min-height: 100vh;
    border-right: none !important;
    box-shadow: 2px 0 10px rgba(0,0,0,0.1);
}
.sidebar .nav-link {
    color: #ffe082 !important;
    font-weight: 500;
    border-radius: 12px;
    margin: 4px 12px;
    transition: all 0.3s ease;
}
.sidebar .nav-link.active, .sidebar .nav-link:hover {
    background: linear-gradient(90deg, #ffb300 0%, #ff6f00 100%) !important;
    color: #232323 !important;
    font-weight: 700;
    box-shadow: 0 4px 15px rgba(255,179,0,0.12);
}
.sidebar .nav-link i {
    color: #ffe082 !important;
}
.superprof-header-admin {
    background: linear-gradient(120deg, #ffb300 0%, #ff9800 50%, #ff6f00 100%) !important;
    color: #fff !important;
    border-radius: 28px !important;
    box-shadow: 0 4px 24px rgba(255,179,0,0.18) !important;
    padding: 38px 0 28px 0 !important;
    margin-bottom: 32px !important;
    text-align: center;
    filter: brightness(1.15) contrast(1.15);
}
.superprof-header-admin h1, .superprof-header-admin p {
    color: #fff !important;
    text-shadow: 0 2px 8px rgba(0,0,0,0.18);
}
.superprof-header-admin h1 {
    font-weight: 900 !important;
    letter-spacing: 0.04em;
    font-size: 2.8rem !important;
}
.superprof-header-admin p {
    font-weight: 500;
    font-size: 1.2rem;
}
.card, .card-body, .table, .table-responsive, .table-bordered, .table-striped, .table-hover {
    background: #fff !important;
    color: #232323 !important;
    border-radius: 18px !important;
    box-shadow: 0 4px 24px rgba(60,60,120,0.10) !important;
    border: none !important;
}
.btn-success, .btn-primary, .btn-info, .btn-warning, .btn-export, .btn-ver, .btn {
    background: linear-gradient(90deg, #ffb300 0%, #ff6f00 100%) !important;
    color: #232323 !important;
    border: none !important;
    font-weight: 700 !important;
    border-radius: 12px !important;
    box-shadow: 0 2px 12px rgba(255,179,0,0.10);
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
}
.btn-success:hover, .btn-primary:hover, .btn-info:hover, .btn-warning:hover, .btn-export:hover, .btn-ver:hover, .btn:hover {
    background: linear-gradient(90deg, #ff6f00 0%, #ffb300 100%) !important;
    color: #fff !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255,179,0,0.18);
}
.form-control {
    border-radius: 10px !important;
    border: 1.5px solid #ffb300 !important;
    background: #fff !important;
    color: #232323 !important;
    font-weight: 500;
}
.form-label.fw-bold {
    color: #ff6f00 !important;
    font-weight: 700 !important;
}
</style>

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
                        <a class="nav-link" href="/admin/users">
                            <i class="fas fa-users"></i> Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/reports">
                            <i class="fas fa-chart-bar"></i> Reportes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/admin/settings">
                            <i class="fas fa-cog"></i> Configuración
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <!-- Header visual tipo Superprof -->
            <div class="superprof-header-admin">
                <h1>Configuración del Sistema</h1>
                <p>Gestiona los parámetros y ajustes principales de la plataforma</p>
            </div>
            <div class="card">
                <div class="card-body">
                    <?php if (isset($_SESSION['settings_success'])): ?>
                        <div class="alert alert-success"> <?= $_SESSION['settings_success'] ?> </div>
                        <?php unset($_SESSION['settings_success']); ?>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['settings_error'])): ?>
                        <div class="alert alert-danger"> <?= $_SESSION['settings_error'] ?> </div>
                        <?php unset($_SESSION['settings_error']); ?>
                    <?php endif; ?>
                    <form method="POST" action="">
                        <div class="row">
                            <?php foreach (
                                $settings as $key => $value): ?>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold" for="setting_<?= htmlspecialchars($key) ?>">
                                        <?= htmlspecialchars(ucwords(str_replace('_', ' ', $key))) ?>
                                    </label>
                                    <input type="text" class="form-control" id="setting_<?= htmlspecialchars($key) ?>" name="settings[<?= htmlspecialchars($key) ?>]" value="<?= htmlspecialchars($value) ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
<?php require_once __DIR__ . '/../partials/auth-footer.php'; ?> 