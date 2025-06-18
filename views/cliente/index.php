<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h5 class="text-center mb-2">¡Bienvenido a la gestión de clientes!</h5>
                    <h4 class="text-center mb-2 text-primary">REGISTRO DE CLIENTES</h4>
                </div>

                <div class="row justify-content-center p-5 shadow-lg">

                    <form id="FormClientes">
                        <input type="hidden" id="cli_id" name="cli_id">

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="cli_nombre" class="form-label">NOMBRE</label>
                                <input type="text" class="form-control" id="cli_nombre" name="cli_nombre" placeholder="Ingrese el nombre del cliente" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="cli_apellido" class="form-label">APELLIDO</label>
                                <input type="text" class="form-control" id="cli_apellido" name="cli_apellido" placeholder="Ingrese el apellido del cliente" required>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="cli_nit" class="form-label">NIT</label>
                                <input type="text" class="form-control" id="cli_nit" name="cli_nit" placeholder="Ingrese el NIT del cliente" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="cli_telefono" class="form-label">TELÉFONO</label>
                                <input type="text" class="form-control" id="cli_telefono" name="cli_telefono" placeholder="Ingrese el teléfono" maxlength="8" required>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-8">
                                <label for="cli_direccion" class="form-label">DIRECCIÓN</label>
                                <textarea class="form-control" id="cli_direccion" name="cli_direccion" rows="3" placeholder="Ingrese la dirección del cliente"></textarea>
                            </div>
                        </div>

                        <div class="row justify-content-center mt-5">
                            <div class="col-auto">
                                <button class="btn btn-success" type="submit" id="BtnGuardar">
                                    <i class="bi bi-save me-1"></i>Guardar
                                </button>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-warning d-none" type="button" id="BtnModificar">
                                    <i class="bi bi-pencil me-1"></i>Modificar
                                </button>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-secondary" type="reset" id="BtnLimpiar">
                                    <i class="bi bi-eraser me-1"></i>Limpiar
                                </button>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-info" type="button" id="BtnBuscar">
                                    <i class="bi bi-search me-1"></i>Buscar Clientes
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
                <h3 class="text-center">CLIENTES REGISTRADOS EN LA BASE DE DATOS</h3>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableClientes">
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/cliente/index.js') ?>"></script>