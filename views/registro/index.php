<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h5 class="text-center mb-2">¡Bienvenido a la Aplicación para el registro, modificación y eliminación de usuario!</h5>
                    <h4 class="text-center mb-2 text-primary">MANIPULACION DE USUARIOS</h4>
                </div>

                <div class="row justify-content-center p-5 shadow-lg">

                    <form id="FormUsuarios">
                        <input type="hidden" id="usuario_id" name="usuario_id">

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="usuario_nom1" class="form-label">INGRESE PRIMER NOMBRE</label>
                                <input type="text" class="form-control" id="usuario_nom1" name="usuario_nom1" placeholder="Ingrese aca primer nombre">
                            </div>
                            <div class="col-lg-6">
                                <label for="usuario_nom2" class="form-label">INGRESE SEGUNDO NOMBRE</label>
                                <input type="text" class="form-control" id="usuario_nom2" name="usuario_nom2" placeholder="Ingrese aca segundo nombre">
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="usuario_ape1" class="form-label">INGRESE PRIMER APELLIDO</label>
                                <input type="text" class="form-control" id="usuario_ape1" name="usuario_ape1" placeholder="Ingrese aca primer apellido">
                            </div>
                            <div class="col-lg-6">
                                <label for="usuario_ape2" class="form-label">INGRESE SEGUNDO APELLIDO</label>
                                <input type="text" class="form-control" id="usuario_ape2" name="usuario_ape2" placeholder="Ingrese aca segundo apellido">
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="usuario_tel" class="form-label">INGRESE SU TELEFONO</label>
                                <input type="text" class="form-control" id="usuario_tel" name="usuario_tel" placeholder="Ingrese aca el telefono">
                            </div>
                            <div class="col-lg-6">
                                <label for="usuario_direc" class="form-label">INGRESE LA DIRECCION</label>
                                <input type="text" class="form-control" id="usuario_direc" name="usuario_direc" placeholder="Ingrese aca la dirección">
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="usuario_dpi" class="form-label">INGRESE EL DPI</label>
                                <input type="text" class="form-control" id="usuario_dpi" name="usuario_dpi" placeholder="Ingrese aca el DPI" maxlength="13">
                            </div>
                            <div class="col-lg-6">
                                <label for="usuario_correo" class="form-label">INGRESE EL CORREO ELECTRONICO</label>
                                <input type="email" class="form-control" id="usuario_correo" name="usuario_correo" placeholder="Ingrese aca el correo ejemplo@mindef.com">
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="usuario_contra" class="form-label">INGRESE LA CONTRASEÑA</label>
                                <input type="password" class="form-control" id="usuario_contra" name="usuario_contra" placeholder="Ingrese la contraseña" required minlength="8">
                            </div>
                           <div class="col-lg-6">
                                <label for="confirmar_contra" class="form-label">CONFIRME LA CONTRASEÑA</label>
                                <input type="password" class="form-control" id="confirmar_contra" name="confirmar_contra" placeholder="Ingrese la contraseña" required minlength="8">
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                             <div class="col-lg-6">
                                <label for="usuario_fecha_creacion" class="form-label">FECHA DE CREACION</label>
                                <input type="date" class="form-control" id="usuario_fecha_creacion" name="usuario_fecha_creacion">
                            </div>
                            <div class="col-lg-6">
                                <label for="usuario_fotografia" class="form-label">FOTOGRAFIA</label>
                                <input type="file" class="form-control" id="usuario_fotografia" name="usuario_fotografia" accept="image/*">
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
                                <button class="btn btn-info" type="button" id="BtnBuscar">
                                    <i class="bi bi-search me-1"></i>Buscar Usuarios
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center p-3" id="seccionTabla" style="display: none;">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <h3 class="text-center">USUARIOS REGISTRADOS EN LA BASE DE DATOS</h3>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableUsuarios">
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/registro/index.js') ?>"></script>