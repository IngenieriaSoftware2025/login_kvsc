<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h5 class="text-center mb-2">¡Bienvenido al módulo de ventas!</h5>
                    <h4 class="text-center mb-2 text-primary">MÓDULO DE VENTAS</h4>
                </div>

                <div class="row justify-content-center p-5 shadow-lg">

                    <form id="FormVentas">
                        <input type="hidden" id="ven_id" name="ven_id">

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="ven_cliente_id" class="form-label">CLIENTE</label>
                                <select class="form-control" id="ven_cliente_id" name="ven_cliente_id" required>
                                    <option value="">Seleccione un cliente</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="ven_inventario_id" class="form-label">PRODUCTO</label>
                                <select class="form-control" id="ven_inventario_id" name="ven_inventario_id" required>
                                    <option value="">Seleccione un producto</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-3">
                                <label for="ven_cantidad" class="form-label">CANTIDAD</label>
                                <input type="number" class="form-control" id="ven_cantidad" name="ven_cantidad" min="1" placeholder="Cantidad" required>
                            </div>
                            <div class="col-lg-3">
                                <label for="precio_unitario_display" class="form-label">PRECIO UNITARIO</label>
                                <input type="text" class="form-control" id="precio_unitario_display" placeholder="Q. 0.00" readonly>
                            </div>
                            <div class="col-lg-3">
                                <label for="stock_disponible" class="form-label">STOCK DISPONIBLE</label>
                                <input type="text" class="form-control" id="stock_disponible" placeholder="0" readonly>
                            </div>
                            <div class="col-lg-3">
                                <label for="total_display" class="form-label">TOTAL</label>
                                <input type="text" class="form-control" id="total_display" placeholder="Q. 0.00" readonly>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-8">
                                <label for="ven_observaciones" class="form-label">OBSERVACIONES</label>
                                <textarea class="form-control" id="ven_observaciones" name="ven_observaciones" rows="3" placeholder="Observaciones adicionales (opcional)"></textarea>
                            </div>
                        </div>

                        <div class="row justify-content-center mt-5">
                            <div class="col-auto">
                                <button class="btn btn-success" type="submit" id="BtnGuardar">
                                    <i class="bi bi-save me-1"></i>Guardar Venta
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
                                    <i class="bi bi-search me-1"></i>Buscar Ventas
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
                <h3 class="text-center">VENTAS REGISTRADAS EN LA BASE DE DATOS</h3>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableVentas">
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/venta/index.js') ?>"></script>