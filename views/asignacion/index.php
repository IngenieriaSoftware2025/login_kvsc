<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h5 class="text-center mb-2">¡Bienvenido a la Aplicación para la asignación de permisos a usuarios!</h5>
                    <h4 class="text-center mb-2 text-primary">ASIGNACION DE PERMISOS A USUARIOS</h4>
                </div>

                <div class="row justify-content-center p-5 shadow-lg">
                    <form id="formAsignacion" class="p-4 bg-white rounded-3 shadow-sm border">
                        <input type="hidden" id="asignacion_id" name="asignacion_id">
                        <input type="hidden" id="asignacion_fecha" name="asignacion_fecha" value="">
                        <input type="hidden" id="asignacion_quitar_fechapermiso" name="asignacion_quitar_fechapermiso" value="">
                        <input type="hidden" id="asignacion_situacion" name="asignacion_situacion" value="1">

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="asignacion_usuario_id" class="form-label">Usuario</label>
                                <select class="form-control form-control-lg" id="asignacion_usuario_id" name="asignacion_usuario_id" required>
                                    <option value="">Seleccione un usuario</option>
                                </select>
                            </div>

                            <div class="col-lg-6">
                                <label for="asignacion_app_id" class="form-label">Aplicación</label>
                                <select class="form-control form-control-lg" id="asignacion_app_id" name="asignacion_app_id" required>
                                    <option value="">Seleccione una aplicación</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="asignacion_permiso_id" class="form-label">Permiso</label>
                                <select class="form-control form-control-lg" id="asignacion_permiso_id" name="asignacion_permiso_id" required>
                                    <option value="">Primero seleccione una aplicación</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="asignacion_usuario_asigno" class="form-label">Usuario que Asigna</label>
                                <select class="form-control form-control-lg" id="asignacion_usuario_asigno" name="asignacion_usuario_asigno" required>
                                    <option value="">Seleccione quién asigna</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-12">
                                <label for="asignacion_motivo" class="form-label">Motivo de la Asignación</label>
                                <textarea class="form-control form-control-lg" id="asignacion_motivo" name="asignacion_motivo" placeholder="Ingrese el motivo de la asignación" rows="3" required></textarea>
                            </div>
                        </div>

                        <div class="row justify-content-center mt-5">
                            <div class="col-auto">
                                <button class="btn btn-success" type="submit" id="BtnGuardar">Guardar</button>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-warning d-none" type="button" id="BtnModificar">Modificar</button>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-secondary" type="reset" id="BtnLimpiar">Limpiar</button>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-info" type="button" id="BtnBuscarAsignaciones">
                                    <i class="bi bi-search me-1"></i>Buscar Asignaciones
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
                <h3 class="text-center text-primary mb-4">Permisos asignados en la base de datos</h3>

                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered align-middle rounded-3 overflow-hidden w-100" id="TableAsignaciones" style="width: 100% !important;">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Usuario</th>
                                <th>Aplicación</th>
                                <th>Permiso</th>
                                <th>Fecha Asignación</th>
                                <th>Asignado por</th>
                                <th>Motivo</th>
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
<script src="<?= asset('build/js/asignacion/index.js') ?>"></script>