<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h5 class="text-center mb-2">¡Bienvenido a la Aplicación para el registro, modificación y eliminación de permisos!</h5>
                    <h4 class="text-center mb-2 text-primary">MANIPULACION DE PERMISOS</h4>
                </div>

                <div class="row justify-content-center p-5 shadow-lg">
                    <form id="formPermiso" class="p-4 bg-white rounded-3 shadow-sm border">
                        <input type="hidden" id="permiso_id" name="permiso_id">
                        <input type="hidden" id="permiso_fecha" name="permiso_fecha" value="">
                        <input type="hidden" id="permiso_situacion" name="permiso_situacion" value="1">

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="app_id" class="form-label">Aplicación</label>
                                <select class="form-control form-control-lg" id="app_id" name="app_id" required>
                                    <option value="">Seleccione una aplicación</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="permiso_nombre" class="form-label">Nombre del Permiso</label>
                                <input type="text" class="form-control form-control-lg" id="permiso_nombre" name="permiso_nombre" placeholder="Ingrese nombre del permiso" required>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="permiso_clave" class="form-label">Clave del Permiso</label>
                                <input type="password" class="form-control form-control-lg" id="permiso_clave" name="permiso_clave" placeholder="Ingrese clave del permiso" required>
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
                                <button class="btn btn-info" type="button" id="BtnBuscarPermisos">
                                    <i class="bi bi-search me-1"></i>Buscar Permisos
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
                <h3 class="text-center text-primary mb-4">Permisos registrados en la base de datos</h3>

                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered align-middle rounded-3 overflow-hidden w-100" id="TablePermisos" style="width: 100% !important;">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Aplicación</th>
                                <th>Nombre del Permiso</th>
                                <th>Clave del Permiso</th>
                                <th>Fecha</th>
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
<script src="<?= asset('build/js/permisos/index.js') ?>"></script>