<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h5 class="text-center mb-2">¡Bienvenido a la gestión de marcas de celulares!</h5>
                    <h4 class="text-center mb-2 text-primary">MANTENIMIENTO DE MARCAS</h4>
                </div>

                <div class="row justify-content-center p-5 shadow-lg">

                    <form id="FormMarcas">
                        <input type="hidden" id="mar_id" name="mar_id">

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="mar_nombre" class="form-label">NOMBRE DE LA MARCA</label>
                                <input type="text" class="form-control" id="mar_nombre" name="mar_nombre" placeholder="Ingrese el nombre de la marca" required>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-8">
                                <label for="mar_descripcion" class="form-label">DESCRIPCIÓN</label>
                                <textarea class="form-control" id="mar_descripcion" name="mar_descripcion" rows="3" placeholder="Ingrese una descripción de la marca"></textarea>
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
                                    <i class="bi bi-search me-1"></i>Buscar Marcas
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
                <h3 class="text-center">MARCAS REGISTRADAS EN LA BASE DE DATOS</h3>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableMarcas">
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/marca/index.js') ?>"></script>