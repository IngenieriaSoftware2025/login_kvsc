<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="build/js/app.js"></script>
    <link rel="shortcut icon" href="<?= asset('images/cit.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= asset('build/styles.css') ?>">
    <title>DemoApp</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark  bg-dark">

        <div class="container-fluid">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="/ejemplo/">
                <img src="<?= asset('./images/cit.png') ?>" width="35px'" alt="cit">
                Aplicaciones
            </a>
            <div class="collapse navbar-collapse" id="navbarToggler">

                <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="margin: 0;">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/proyecto01/login"><i class="bi bi-house-fill me-2"></i>Login</a>
                    </li>



                    <div class="nav-item dropdown ">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-gear me-2"></i>Registro
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-dark " id="dropwdownRevision" style="margin: 0;">
                            <li class="nav-item">
                                <a class="nav-link px-3" style="background: none; border: none;" href="/proyecto01/cliente">
                                    <i class="bi bi-shield-lock-fill me-2"></i>Clientes
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/proyecto01/registro"><i class="bi bi-house-fill me-2"></i>Usuarios</a>
                            </li>
                        </ul>
                    </div>



                    <div class="nav-item dropdown ">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-gear me-2"></i>Gestion
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-dark " id="dropwdownRevision" style="margin: 0;">
                            <li class="nav-item">
                                <a class="nav-link px-3" style="background: none;" href="/proyecto01/aplicacion">
                                    <i class="bi bi-grid-fill me-2"></i>Aplicaciones
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-3" style="background: none; border: none;" href="/proyecto01/permisos">
                                    <i class="bi bi-shield-lock-fill me-2"></i>Permisos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-3" style="background: none; border: none;" href="/proyecto01/asignacion">
                                    <i class="bi bi-shield-lock-fill me-2"></i>Asignacion de Permisos
                                </a>
                            </li>
                        </ul>
                    </div>


                    <div class="nav-item dropdown ">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-gear me-2"></i>Celulares
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-dark " id="dropwdownRevision" style="margin: 0;">
                            <li class="nav-item">
                                <a class="nav-link px-3" style="background: none; border: none;" href="/proyecto01/marca">
                                    <i class="bi bi-shield-lock-fill me-2"></i>Marcas de Celulares
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/proyecto01/inventario"><i class="bi bi-house-fill me-2"></i>Inventario</a>
                            </li>
                        </ul>
                    </div>


                    <div class="nav-item dropdown ">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-gear me-2"></i>Accion
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-dark " id="dropwdownRevision" style="margin: 0;">
                            <li class="nav-item">
                                <a class="nav-link px-3" style="background: none; border: none;" href="/proyecto01/venta">
                                    <i class="bi bi-shield-lock-fill me-2"></i>Ventas
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/proyecto01/reparacion"><i class="bi bi-house-fill me-2"></i>Reparaciones</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/proyecto01/estadistica"><i class="bi bi-house-fill me-2"></i>Estadisticas</a>
                            </li>
                        </ul>
                    </div>



                </ul>
            </div>
        </div>

    </nav>
    <div class="progress fixed-bottom" style="height: 6px;">
        <div class="progress-bar progress-bar-animated bg-danger" id="bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="container-fluid pt-5 mb-4" style="min-height: 85vh">

        <?php echo $contenido; ?>
    </div>
    <div class="container-fluid ">
        <div class="row justify-content-center text-center">
            <div class="col-12">
                <p style="font-size:xx-small; font-weight: bold;">
                    Comando de Informática y Tecnología, <?= date('Y') ?> &copy;
                </p>
            </div>
        </div>
    </div>
</body>

</html>