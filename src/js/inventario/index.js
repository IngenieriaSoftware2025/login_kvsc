import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";

const FormInventario = document.getElementById('FormInventario');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const BtnBuscar = document.getElementById('BtnBuscar');
const InputPrecioCompra = document.getElementById('inv_precio_compra');
const InputPrecioVenta = document.getElementById('inv_precio_venta');
const SelectMarca = document.getElementById('inv_marca_id');

const ValidarPrecios = () => {
    const precioCompra = parseFloat(InputPrecioCompra.value) || 0;
    const precioVenta = parseFloat(InputPrecioVenta.value) || 0;

    if (precioCompra > 0 && precioVenta > 0) {
        if (precioVenta <= precioCompra) {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Error en los precios",
                text: "El precio de venta debe ser mayor al precio de compra",
                showConfirmButton: true,
            });
            InputPrecioVenta.classList.remove('is-valid');
            InputPrecioVenta.classList.add('is-invalid');
        } else {
            InputPrecioVenta.classList.remove('is-invalid');
            InputPrecioVenta.classList.add('is-valid');
            InputPrecioCompra.classList.remove('is-invalid');
            InputPrecioCompra.classList.add('is-valid');
        }
    }
}

const CargarMarcas = async () => {
    const url = '/proyecto01/inventario/buscarMarcasAPI';
    const config = {
        method: 'GET'
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje, data } = datos;

        if (codigo == 1) {
            SelectMarca.innerHTML = '<option value="">Seleccione una marca</option>';
            
            data.forEach(marca => {
                const option = document.createElement('option');
                option.value = marca.mar_id;
                option.textContent = marca.mar_nombre;
                SelectMarca.appendChild(option);
            });
        } else {
            console.error('Error al cargar marcas:', mensaje);
        }
    } catch (error) {
        console.error('Error al cargar marcas:', error);
    }
}

const GuardarInventario = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormInventario, ['inv_id'])) {
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

    const body = new FormData(FormInventario);
    const url = '/proyecto01/inventario/guardarAPI';
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
                title: "¡Registro Exitoso!",
                text: mensaje,
                showConfirmButton: true,
            });
            limpiarTodo();
        } 
        else if (codigo == 2) {
            await Swal.fire({
                position: "center",
                icon: "warning",
                title: "Modelo Duplicado",
                text: "El modelo que ingresaste ya está registrado para esta marca. Por favor, verifica el modelo o selecciona otra marca.",
                showConfirmButton: true,
            });
            
            const campoModelo = document.getElementById('inv_modelo');
            campoModelo.classList.add('is-invalid');
            campoModelo.focus();
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

const BuscarInventario = async () => {
    const url = '/proyecto01/inventario/buscarAPI';
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

const datatable = new DataTable('#TableInventario', {
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
            data: 'inv_id',
            width: '5%',
            render: (data, type, row, meta) => meta.row + 1
        },
        { title: 'Marca', data: 'mar_nombre' },
        { title: 'Modelo', data: 'inv_modelo' },
        { 
            title: 'Precio Compra', 
            data: 'inv_precio_compra',
            render: (data, type, row) => `Q. ${parseFloat(data).toFixed(2)}`
        },
        { 
            title: 'Precio Venta', 
            data: 'inv_precio_venta',
            render: (data, type, row) => `Q. ${parseFloat(data).toFixed(2)}`
        },
        { 
            title: 'Stock', 
            data: 'inv_stock',
            render: (data, type, row) => {
                let badge = 'bg-success';
                if (data == 0) badge = 'bg-danger';
                else if (data <= 5) badge = 'bg-warning';
                
                return `<span class="badge ${badge}">${data}</span>`;
            }
        },
        { title: 'Descripción', data: 'inv_descripcion' },
        {
            title: 'Estado',
            data: 'inv_situacion',
            render: (data, type, row) => {
                return data == 1 ? '<span class="badge bg-success">ACTIVO</span>' : '<span class="badge bg-danger">INACTIVO</span>';
            }
        },
        {
            title: 'Acciones',
            data: 'inv_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => {
                return `
                 <div class='d-flex justify-content-center'>
                     <button class='btn btn-warning modificar mx-1' 
                         data-id="${data}" 
                         data-marca="${row.inv_marca_id}"  
                         data-modelo="${row.inv_modelo}"  
                         data-compra="${row.inv_precio_compra}"  
                         data-venta="${row.inv_precio_venta}"  
                         data-stock="${row.inv_stock}"  
                         data-descripcion="${row.inv_descripcion}"  
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

    document.getElementById('inv_id').value = datos.id;
    document.getElementById('inv_marca_id').value = datos.marca;
    document.getElementById('inv_modelo').value = datos.modelo;
    document.getElementById('inv_precio_compra').value = datos.compra;
    document.getElementById('inv_precio_venta').value = datos.venta;
    document.getElementById('inv_stock').value = datos.stock;
    document.getElementById('inv_descripcion').value = datos.descripcion;

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    window.scrollTo({
        top: 0
    });
}

const limpiarTodo = () => {
    FormInventario.reset();
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
    InputPrecioCompra.classList.remove('is-valid', 'is-invalid');
    InputPrecioVenta.classList.remove('is-valid', 'is-invalid');
    
    const campos = ['inv_modelo', 'inv_marca_id'];
    campos.forEach(campoId => {
        const campo = document.getElementById(campoId);
        if (campo) {
            campo.classList.remove('is-invalid', 'is-valid');
        }
    });
}

const ModificarInventario = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormInventario, ['inv_id'])) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe completar todos los campos obligatorios",
            showConfirmButton: true,
        });
        BtnModificar.disabled = false;
        return;
    }

    const body = new FormData(FormInventario);
    const url = '/proyecto01/inventario/modificarAPI';
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
                title: "¡Modificación Exitosa!",
                text: mensaje,
                showConfirmButton: true,
            });
            limpiarTodo();
            BuscarInventario();
        } 
        else if (codigo == 2) {
            await Swal.fire({
                position: "center",
                icon: "warning",
                title: "Modelo Duplicado",
                text: "El modelo que ingresaste ya está registrado para esta marca por otro producto. Por favor, verifica el modelo.",
                showConfirmButton: true,
            });
            
            const campoModelo = document.getElementById('inv_modelo');
            campoModelo.classList.add('is-invalid');
            campoModelo.focus();
        }
        else {
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

const EliminarInventario = async (e) => {
    const idInventario = e.currentTarget.dataset.id;

    const AlertaConfirmarEliminar = await Swal.fire({
        position: "center",
        icon: "warning",
        title: "¿Desea ejecutar esta acción?",
        text: 'Esta completamente seguro que desea eliminar este registro',
        showConfirmButton: true,
        confirmButtonText: 'Si, Eliminar',
        confirmButtonColor: 'red',
        cancelButtonText: 'No, Cancelar',
        showCancelButton: true
    });

    if (AlertaConfirmarEliminar.isConfirmed) {
        const url = `/proyecto01/inventario/eliminarAPI?id=${idInventario}`;
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
                BuscarInventario();
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
                text: "No se pudo conectar con el servidor para eliminar el producto.",
                showConfirmButton: true,
            });
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    CargarMarcas();
});

datatable.on('click', '.eliminar', EliminarInventario);
datatable.on('click', '.modificar', llenarFormulario);
FormInventario.addEventListener('submit', GuardarInventario);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnModificar.addEventListener('click', ModificarInventario);
BtnBuscar.addEventListener('click', BuscarInventario);
InputPrecioCompra.addEventListener('change', ValidarPrecios);
InputPrecioVenta.addEventListener('change', ValidarPrecios);

document.getElementById('inv_modelo').addEventListener('input', function() {
    this.classList.remove('is-invalid');
});