<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h5 class="text-center mb-2">¡Bienvenido a la gestión del inventario de celulares!</h5>
                    <h4 class="text-center mb-2 text-primary">INVENTARIO DE CELULARES</h4>
                </div>

                <div class="row justify-content-center p-5 shadow-lg">

                    <form id="FormInventario">
                        <input type="hidden" id="inv_id" name="inv_id">

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="inv_marca_id" class="form-label">MARCA</label>
                                <select class="form-control" id="inv_marca_id" name="inv_marca_id" required>
                                    <option value="">Seleccione una marca</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="inv_modelo" class="form-label">MODELO</label>
                                <input type="text" class="form-control" id="inv_modelo" name="inv_modelo" placeholder="Ingrese el modelo del celular" required>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="inv_precio_compra" class="form-label">PRECIO DE COMPRA</label>
                                <input type="number" class="form-control" id="inv_precio_compra" name="inv_precio_compra" step="0.01" min="0.01" placeholder="0.00" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="inv_precio_venta" class="form-label">PRECIO DE VENTA</label>
                                <input type="number" class="form-control" id="inv_precio_venta" name="inv_precio_venta" step="0.01" min="0.01" placeholder="0.00" required>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-4">
                                <label for="inv_stock" class="form-label">STOCK</label>
                                <input type="number" class="form-control" id="inv_stock" name="inv_stock" min="0" placeholder="Cantidad en stock" required>
                            </div>
                            <div class="col-lg-8">
                                <label for="inv_descripcion" class="form-label">DESCRIPCIÓN</label>
                                <textarea class="form-control" id="inv_descripcion" name="inv_descripcion" rows="3" placeholder="Ingrese una descripción del producto"></textarea>
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
                                    <i class="bi bi-search me-1"></i>Buscar Inventario
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
    <div class="col-lg-12">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <h3 class="text-center">PRODUCTOS REGISTRADOS EN EL INVENTARIO</h3>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableInventario">
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/inventario/index.js') ?>"></script>