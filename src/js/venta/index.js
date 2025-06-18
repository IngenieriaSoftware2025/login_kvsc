import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";

const FormVentas = document.getElementById('FormVentas');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const BtnBuscar = document.getElementById('BtnBuscar');
const SelectCliente = document.getElementById('ven_cliente_id');
const SelectProducto = document.getElementById('ven_inventario_id');
const InputCantidad = document.getElementById('ven_cantidad');
const DisplayPrecio = document.getElementById('precio_unitario_display');
const DisplayStock = document.getElementById('stock_disponible');
const DisplayTotal = document.getElementById('total_display');

let productosData = [];
let precioUnitario = 0;
let stockDisponible = 0;

const CargarClientes = async () => {
    const url = '/proyecto01/venta/buscarClientesAPI';
    const config = {
        method: 'GET'
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje, data } = datos;

        if (codigo == 1) {
            SelectCliente.innerHTML = '<option value="">Seleccione un cliente</option>';
            
            data.forEach(cliente => {
                const option = document.createElement('option');
                option.value = cliente.cli_id;
                option.textContent = `${cliente.cli_nombre} ${cliente.cli_apellido} - NIT: ${cliente.cli_nit}`;
                SelectCliente.appendChild(option);
            });
        } else {
            console.error('Error al cargar clientes:', mensaje);
        }
    } catch (error) {
        console.error('Error al cargar clientes:', error);
    }
}

const CargarProductos = async () => {
    const url = '/proyecto01/venta/buscarProductosAPI';
    const config = {
        method: 'GET'
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje, data } = datos;

        if (codigo == 1) {
            productosData = data;
            SelectProducto.innerHTML = '<option value="">Seleccione un producto</option>';
            
            data.forEach(producto => {
                const option = document.createElement('option');
                option.value = producto.inv_id;
                option.textContent = `${producto.mar_nombre} ${producto.inv_modelo} - Stock: ${producto.inv_stock} - Q. ${parseFloat(producto.inv_precio_venta).toFixed(2)}`;
                SelectProducto.appendChild(option);
            });
        } else {
            console.error('Error al cargar productos:', mensaje);
        }
    } catch (error) {
        console.error('Error al cargar productos:', error);
    }
}

const ActualizarInfoProducto = () => {
    const productoId = SelectProducto.value;
    
    if (productoId) {
        const producto = productosData.find(p => p.inv_id == productoId);
        
        if (producto) {
            precioUnitario = parseFloat(producto.inv_precio_venta);
            stockDisponible = parseInt(producto.inv_stock);
            
            DisplayPrecio.value = `Q. ${precioUnitario.toFixed(2)}`;
            DisplayStock.value = stockDisponible;
            
            InputCantidad.value = '';
            DisplayTotal.value = 'Q. 0.00';
            
            InputCantidad.max = stockDisponible;
        }
    } else {
        DisplayPrecio.value = 'Q. 0.00';
        DisplayStock.value = '0';
        DisplayTotal.value = 'Q. 0.00';
        InputCantidad.value = '';
        precioUnitario = 0;
        stockDisponible = 0;
    }
}

const CalcularTotal = () => {
    const cantidad = parseInt(InputCantidad.value) || 0;
    
    if (cantidad > 0 && precioUnitario > 0) {
        if (cantidad > stockDisponible) {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Stock Insuficiente",
                text: `Solo hay ${stockDisponible} unidades disponibles`,
                showConfirmButton: true,
            });
            InputCantidad.classList.add('is-invalid');
            DisplayTotal.value = 'Q. 0.00';
        } else {
            const total = cantidad * precioUnitario;
            DisplayTotal.value = `Q. ${total.toFixed(2)}`;
            InputCantidad.classList.remove('is-invalid');
            InputCantidad.classList.add('is-valid');
        }
    } else {
        DisplayTotal.value = 'Q. 0.00';
        InputCantidad.classList.remove('is-valid', 'is-invalid');
    }
}

const GuardarVenta = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormVentas, ['ven_id'])) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe completar todos los campos obligatorios",
            showConfirmButton: true,
        });
        BtnGuardar.disabled = false;
        return;
    }

    const cantidad = parseInt(InputCantidad.value) || 0;
    if (cantidad > stockDisponible) {
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Stock Insuficiente",
            text: `Solo hay ${stockDisponible} unidades disponibles`,
            showConfirmButton: true,
        });
        BtnGuardar.disabled = false;
        return;
    }

    const body = new FormData(FormVentas);
    const url = '/proyecto01/venta/guardarAPI';
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje, campo, tipo } = datos;

        if (codigo == 1) {
            await Swal.fire({
                position: "center",
                icon: "success",
                title: "¡Venta Registrada!",
                text: mensaje,
                showConfirmButton: true,
            });
            limpiarTodo();
            await CargarProductos();
        } 
        else if (codigo == 2) {
            await Swal.fire({
                position: "center",
                icon: "warning",
                title: "Stock Insuficiente",
                text: mensaje,
                showConfirmButton: true,
            });
            
            const campoCantidad = document.getElementById('ven_cantidad');
            campoCantidad.classList.add('is-invalid');
            campoCantidad.focus();
        }
        else {
            await Swal.fire({
                position: "center",
                icon: "error",
                title: "Error en el Registro",
                text: mensaje,
                showConfirmButton: true,
            });
        }

    } catch (error) {
        console.log(error);
        await Swal.fire({
            position: "center",
            icon: "error",
            title: "Error de Conexión",
            text: "No se pudo conectar con el servidor. Por favor, intenta de nuevo.",
            showConfirmButton: true,
        });
    }
    BtnGuardar.disabled = false;
}

const BuscarVentas = async () => {
    const url = '/proyecto01/venta/buscarAPI';
    const config = {
        method: 'GET'
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje, data } = datos;

        if (codigo == 1) {
            document.getElementById('seccionTabla').style.display = 'block';
            
            datatable.clear().draw();
            datatable.rows.add(data).draw();
        } else {
            await Swal.fire({
                position: "center",
                icon: "error",
                title: "Error",
                text: mensaje,
                showConfirmButton: true,
            });
        }
    } catch (error) {
        console.log(error);
    }
}

const datatable = new DataTable('#TableVentas', {
    dom: `
        <"row mt-3 justify-content-between" 
            <"col" l> 
            <"col" B> 
            <"col-3" f>
        >
        t
        <"row mt-3 justify-content-between" 
            <"col-md-3 d-flex align-items-center" i> 
            <"col-md-8 d-flex justify-content-end" p>
        >
    `,
    language: lenguaje,
    data: [],
    columns: [
        {
            title: 'No.',
            data: 'ven_id',
            width: '5%',
            render: (data, type, row, meta) => meta.row + 1
        },
        { 
            title: 'Cliente', 
            data: 'cli_nombre',
            render: (data, type, row) => `${row.cli_nombre} ${row.cli_apellido}`
        },
        { 
            title: 'Producto', 
            data: 'inv_modelo',
            render: (data, type, row) => `${row.mar_nombre} ${row.inv_modelo}`
        },
        { title: 'Cantidad', data: 'ven_cantidad' },
        { 
            title: 'Precio Unit.', 
            data: 'ven_precio_unitario',
            render: (data, type, row) => `Q. ${parseFloat(data).toFixed(2)}`
        },
        { 
            title: 'Total', 
            data: 'ven_total',
            render: (data, type, row) => `Q. ${parseFloat(data).toFixed(2)}`
        },
        { 
            title: 'Fecha', 
            data: 'ven_fecha',
            render: (data, type, row) => {
                const fecha = new Date(data);
                return fecha.toLocaleDateString('es-GT');
            }
        },
        { title: 'Observaciones', data: 'ven_observaciones' },
        {
            title: 'Estado',
            data: 'ven_situacion',
            render: (data, type, row) => {
                return data == 1 ? '<span class="badge bg-success">ACTIVO</span>' : '<span class="badge bg-danger">INACTIVO</span>';
            }
        },
        {
            title: 'Acciones',
            data: 'ven_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => {
                return `
                 <div class='d-flex justify-content-center'>
                     <button class='btn btn-warning modificar mx-1' 
                         data-id="${data}" 
                         data-observaciones="${row.ven_observaciones || ''}"  
                        <i class='bi bi-pencil-square me-1'></i> Modificar 
                     </button>
                     <button class='btn btn-danger eliminar mx-1' 
                         data-id="${data}">
                        <i class="bi bi-trash3 me-1"></i>Eliminar
                     </button>
                 </div>`;
            }
        }
    ]
});

const llenarFormulario = (event) => {
    const datos = event.currentTarget.dataset;

    document.getElementById('ven_id').value = datos.id;
    document.getElementById('ven_observaciones').value = datos.observaciones;

    SelectCliente.disabled = true;
    SelectProducto.disabled = true;
    InputCantidad.disabled = true;

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    window.scrollTo({
        top: 0
    });
}

const limpiarTodo = () => {
    FormVentas.reset();
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
    
    SelectCliente.disabled = false;
    SelectProducto.disabled = false;
    InputCantidad.disabled = false;
    
    DisplayPrecio.value = 'Q. 0.00';
    DisplayStock.value = '0';
    DisplayTotal.value = 'Q. 0.00';
    
    precioUnitario = 0;
    stockDisponible = 0;
    
    const campos = ['ven_cliente_id', 'ven_inventario_id', 'ven_cantidad'];
    campos.forEach(campoId => {
        const campo = document.getElementById(campoId);
        if (campo) {
            campo.classList.remove('is-invalid', 'is-valid');
        }
    });
}

const ModificarVenta = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    const body = new FormData(FormVentas);
    const url = '/proyecto01/venta/modificarAPI';
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje } = datos;

        if (codigo == 1) {
            await Swal.fire({
                position: "center",
                icon: "success",
                title: "¡Modificación Exitosa!",
                text: mensaje,
                showConfirmButton: true,
            });
            limpiarTodo();
            BuscarVentas();
        } else {
            await Swal.fire({
                position: "center",
                icon: "error",
                title: "Error en la Modificación",
                text: mensaje,
                showConfirmButton: true,
            });
        }

    } catch (error) {
        console.log(error);
        await Swal.fire({
            position: "center",
            icon: "error",
            title: "Error de Conexión",
            text: "No se pudo conectar con el servidor. Por favor, intenta de nuevo.",
            showConfirmButton: true,
        });
    }
    BtnModificar.disabled = false;
}

const EliminarVentas = async (e) => {
    const idVenta = e.currentTarget.dataset.id;

    const AlertaConfirmarEliminar = await Swal.fire({
        position: "center",
        icon: "warning",
        title: "¿Desea ejecutar esta acción?",
        text: 'Esta acción eliminará la venta y restaurará el stock del producto',
        showConfirmButton: true,
        confirmButtonText: 'Si, Eliminar',
        confirmButtonColor: 'red',
        cancelButtonText: 'No, Cancelar',
        showCancelButton: true
    });

    if (AlertaConfirmarEliminar.isConfirmed) {
        const url = `/proyecto01/venta/eliminarAPI?id=${idVenta}`;
        const config = {
            method: 'GET'
        }

        try {
            const consulta = await fetch(url, config);
            const respuesta = await consulta.json();
            const { codigo, mensaje } = respuesta;

            if (codigo == 1) {
                await Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "¡Eliminación Exitosa!",
                    text: mensaje,
                    showConfirmButton: true,
                });
                BuscarVentas();
                await CargarProductos();
            } else {
                await Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Error al Eliminar",
                    text: mensaje,
                    showConfirmButton: true,
                });
            }
        } catch (error) {
            console.log(error);
            await Swal.fire({
                position: "center",
                icon: "error",
                title: "Error de Conexión",
                text: "No se pudo conectar con el servidor para eliminar la venta.",
                showConfirmButton: true,
            });
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    CargarClientes();
    CargarProductos();
});

datatable.on('click', '.eliminar', EliminarVentas);
datatable.on('click', '.modificar', llenarFormulario);
FormVentas.addEventListener('submit', GuardarVenta);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnModificar.addEventListener('click', ModificarVenta);
BtnBuscar.addEventListener('click', BuscarVentas);
SelectProducto.addEventListener('change', ActualizarInfoProducto);
InputCantidad.addEventListener('input', CalcularTotal);

document.getElementById('ven_cantidad').addEventListener('input', function() {
    this.classList.remove('is-invalid');
});