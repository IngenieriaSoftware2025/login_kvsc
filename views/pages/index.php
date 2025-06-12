<div class="row mb-3">
  <div class="col text-center">
    <h1 class="display-4 text-primary">¡Bienvenido al Sistema!</h1>
    <p class="lead text-muted">Usuario: <strong><?= $_SESSION['nombre'] ?? 'Usuario' ?></strong></p>
  </div>
</div>

<div class="row justify-content-center mb-4">
  <div class="col-lg-3">
    <img src="./images/cit.png" width="100%" alt="CIT Logo" class="img-fluid">
  </div>
</div>

<div class="row justify-content-center">
  <div class="col-lg-10">
    <div class="card shadow-lg">
      <div class="card-body p-4">
        <h3 class="text-center mb-4">Panel de Control</h3>
        
        <div class="row text-center">
          <div class="col-md-3 mb-3">
            <div class="card h-100 border-primary">
              <div class="card-body">
                <i class="bi bi-person-plus-fill text-primary" style="font-size: 3rem;"></i>
                <h5 class="card-title mt-3">Usuarios</h5>
                <p class="card-text">Gestionar usuarios del sistema</p>
                <a href="/proyecto01/registro" class="btn btn-primary">Acceder</a>
              </div>
            </div>
          </div>
          
          <div class="col-md-3 mb-3">
            <div class="card h-100 border-success">
              <div class="card-body">
                <i class="bi bi-grid-fill text-success" style="font-size: 3rem;"></i>
                <h5 class="card-title mt-3">Aplicaciones</h5>
                <p class="card-text">Administrar aplicaciones</p>
                <a href="/proyecto01/aplicacion" class="btn btn-success">Acceder</a>
              </div>
            </div>
          </div>
          
          <div class="col-md-3 mb-3">
            <div class="card h-100 border-warning">
              <div class="card-body">
                <i class="bi bi-shield-lock-fill text-warning" style="font-size: 3rem;"></i>
                <h5 class="card-title mt-3">Permisos</h5>
                <p class="card-text">Configurar permisos</p>
                <a href="/proyecto01/permisos" class="btn btn-warning">Acceder</a>
              </div>
            </div>
          </div>
          
          <div class="col-md-3 mb-3">
            <div class="card h-100 border-info">
              <div class="card-body">
                <i class="bi bi-person-check-fill text-info" style="font-size: 3rem;"></i>
                <h5 class="card-title mt-3">Asignaciones</h5>
                <p class="card-text">Asignar permisos</p>
                <a href="/proyecto01/asignacion" class="btn btn-info">Acceder</a>
              </div>
            </div>
          </div>
        </div>
        
        <hr class="my-4">
        
        <div class="text-center">
          <a href="/proyecto01/logout" class="btn btn-danger btn-lg">
            <i class="bi bi-box-arrow-right me-2"></i>
            Cerrar Sesión
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="build/js/inicio.js"></script>