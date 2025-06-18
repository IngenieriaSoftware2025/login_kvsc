<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h5 class="text-center mb-2">¡Bienvenido al módulo de reparaciones!</h5>
                    <h4 class="text-center mb-2 text-primary">MÓDULO DE REPARACIONES</h4>
                </div>

                <div class="row justify-content-center p-5 shadow-lg">

                    <form id="FormReparaciones">
                        <input type="hidden" id="rep_id" name="rep_id">

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="rep_cliente_id" class="form-label">CLIENTE</label>
                                <select class="form-control" id="rep_cliente_id" name="rep_cliente_id" required>
                                    <option value="">Seleccione un cliente</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="rep_estado" class="form-label">ESTADO</label>
                                <select class="form-control" id="rep_estado" name="rep_estado" required>
                                    <option value="RECIBIDO">RECIBIDO</option>
                                    <option value="EN_PROCESO">EN PROCESO</option>
                                    <option value="REPARADO">REPARADO</option>
                                    <option value="ENTREGADO">ENTREGADO</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="rep_equipo" class="form-label">EQUIPO</label>
                                <input type="text" class="form-control" id="rep_equipo" name="rep_equipo" placeholder="Ej: iPhone 12, Galaxy S21, etc." required>
                            </div>
                            <div class="col-lg-6">
                                <label for="rep_marca" class="form-label">MARCA</label>
                                <input type="text" class="form-control" id="rep_marca" name="rep_marca" placeholder="Ej: Apple, Samsung, Xiaomi, etc." required>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-8">
                                <label for="rep_falla" class="form-label">DESCRIPCIÓN DE LA FALLA</label>
                                <textarea class="form-control" id="rep_falla" name="rep_falla" rows="2" placeholder="Describa detalladamente la falla reportada por el cliente" required></textarea>
                            </div>
                            <div class="col-lg-4">
                                <label for="rep_costo" class="form-label">COSTO ESTIMADO</label>
                                <input type="number" class="form-control" id="rep_costo" name="rep_costo" step="0.01" min="0" placeholder="0.00">
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-8">
                                <label for="rep_diagnostico" class="form-label">DIAGNÓSTICO</label>
                                <textarea class="form-control" id="rep_diagnostico" name="rep_diagnostico" rows="2" placeholder="Diagnóstico técnico del equipo (opcional)"></textarea>
                            </div>
                            <div class="col-lg-4">
                                <label for="rep_fecha_entrega" class="form-label">FECHA DE ENTREGA</label>
                                <input type="date" class="form-control" id="rep_fecha_entrega" name="rep_fecha_entrega">
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-8">
                                <label for="rep_observaciones" class="form-label">OBSERVACIONES</label>
                                <textarea class="form-control" id="rep_observaciones" name="rep_observaciones" rows="3" placeholder="Observaciones adicionales, notas internas, etc. (opcional)"></textarea>
                            </div>
                        </div>

                        <div class="row justify-content-center mt-5">
                            <div class="col-auto">
                                <button class="btn btn-success" type="submit" id="BtnGuardar">
                                    <i class="bi bi-save me-1"></i>Guardar Reparación
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
                                    <i class="bi bi-search me-1"></i>Buscar Reparaciones
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
                <h3 class="text-center">REPARACIONES REGISTRADAS EN LA BASE DE DATOS</h3>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableReparaciones">
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/reparacion/index.js') ?>"></script>