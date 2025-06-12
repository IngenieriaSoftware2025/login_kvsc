<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h5 class="text-center mb-2">¡Bienvenido a la Aplicación para el registro, modificación y eliminación de aplicaciones!</h5>
                    <h4 class="text-center mb-2 text-primary">MANIPULACION DE APLICACIONES</h4>
                </div>

                <div class="row justify-content-center p-5 shadow-lg">

                    <form id="formAplicacion">

                        <input type="hidden" id="app_id" name="app_id">

                        <div class="row mb-3 justify-content-center">

                            <div class="col-lg-6">
                                 <label for="app_nombre_largo" class="form-label">Nombre Largo</label>
                                <input type="text" class="form-control form-control-lg" id="app_nombre_largo" name="app_nombre_largo" placeholder="Ingrese nombre largo de la aplicación" required>
                            </div>
                            <div class="col-lg-6">
                                 <label for="app_nombre_medium" class="form-label">Nombre Mediano</label>
                                <input type="text" class="form-control form-control-lg" id="app_nombre_medium" name="app_nombre_medium" placeholder="Ingrese nombre mediano" required>
                            </div>

                        </div>


                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="app_nombre_corto" class="form-label">Nombre Corto</label>
                                <input type="text" class="form-control form-control-lg" id="app_nombre_corto" name="app_nombre_corto" placeholder="Ingrese nombre corto" required>
                            </div>
                        </div>

                        <div class="row justify-content-center mt-5">

                            <div class="col-auto">
                                <button class="btn btn-success" type="submit" id="BtnGuardar">
                                    Guardar
                                </button>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-warning d-none" type="button" id="BtnModificar">
                                    Modificar
                                </button>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-secondary" type="reset" id="BtnLimpiar">
                                    Limpiar
                                </button>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-info" type="button" id="BtnBuscarAplicaciones">
                                    <i class="bi bi-search me-1"></i>Buscar Aplicaciones
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center mt-5" id="seccionTabla" style="display: none;">
    <div class="col-lg-11">
        <div class="card shadow-lg border-primary rounded-4">
            <div class="card-body">
                <h3 class="text-center text-primary mb-4">Aplicaciones registradas en la base de datos</h3>

                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered align-middle rounded-3 overflow-hidden w-100" id="TableAplicaciones" style="width: 100% !important;">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nombre Largo</th>
                                <th>Nombre Mediano</th>
                                <th>Nombre Corto</th>
                                <th>Situación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="<?= asset('build/js/aplicacion/index.js') ?>"></script>