import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";

const FormClientes = document.getElementById('FormClientes');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const BtnBuscar = document.getElementById('BtnBuscar');
const InputClienteTelefono = document.getElementById('cli_telefono');
const InputClienteNit = document.getElementById('cli_nit');

const ValidarTelefono = () => {
    const CantidadDigitos = InputClienteTelefono.value;

    if (CantidadDigitos.length < 1) {
        InputClienteTelefono.classList.remove('is-valid', 'is-invalid');
    } else {
        if (CantidadDigitos.length != 8) {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Revise el número de teléfono",
                text: "La cantidad de dígitos debe ser exactamente 8 dígitos",
                showConfirmButton: true,
            });
            InputClienteTelefono.classList.remove('is-valid');
            InputClienteTelefono.classList.add('is-invalid');
        } else {
            InputClienteTelefono.classList.remove('is-invalid');
            InputClienteTelefono.classList.add('is-valid');
        }
    }
}

const ValidarNIT = () => {
    const nit = InputClienteNit.value;

    if (nit.length < 1) {
        InputClienteNit.classList.remove('is-valid', 'is-invalid');
    } else {
        if (nit.length < 7) {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "NIT INVÁLIDO",
                text: "El NIT debe tener al menos 7 dígitos",
                showConfirmButton: true,
            });
            InputClienteNit.classList.remove('is-valid');
            InputClienteNit.classList.add('is-invalid');
        } else {
            InputClienteNit.classList.remove('is-invalid');
            InputClienteNit.classList.add('is-valid');
        }
    }
}

const GuardarCliente = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormClientes, ['cli_id'])) {
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

    const body = new FormData(FormClientes);
    const url = '/proyecto01/cliente/guardarAPI';
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
                title: "NIT Duplicado",
                text: "El número de NIT que ingresaste ya está registrado en el sistema. Por favor, verifica el número o contacta al administrador.",
                showConfirmButton: true,
            });
            
            const campoNit = document.getElementById('cli_nit');
            campoNit.classList.add('is-invalid');
            campoNit.focus();
        }
        else if (codigo == 3) {
            await Swal.fire({
                position: "center",
                icon: "warning",
                title: "Teléfono Duplicado",
                text: "El número de teléfono que ingresaste ya está registrado en el sistema. Por favor, usa un número diferente.",
                showConfirmButton: true,
            });
            
            const campoTelefono = document.getElementById('cli_telefono');
            campoTelefono.classList.add('is-invalid');
            campoTelefono.focus();
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

const BuscarClientes = async () => {
    const url = '/proyecto01/cliente/buscarAPI';
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

const datatable = new DataTable('#TableClientes', {
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
            data: 'cli_id',
            width: '5%',
            render: (data, type, row, meta) => meta.row + 1
        },
        { title: 'Nombre', data: 'cli_nombre' },
        { title: 'Apellido', data: 'cli_apellido' },
        { title: 'NIT', data: 'cli_nit' },
        { title: 'Teléfono', data: 'cli_telefono' },
        { title: 'Dirección', data: 'cli_direccion' },
        {
            title: 'Estado',
            data: 'cli_situacion',
            render: (data, type, row) => {
                return data == 1 ? '<span class="badge bg-success">ACTIVO</span>' : '<span class="badge bg-danger">INACTIVO</span>';
            }
        },
        {
            title: 'Acciones',
            data: 'cli_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => {
                return `
                 <div class='d-flex justify-content-center'>
                     <button class='btn btn-warning modificar mx-1' 
                         data-id="${data}" 
                         data-nombre="${row.cli_nombre}"  
                         data-apellido="${row.cli_apellido}"  
                         data-nit="${row.cli_nit}"  
                         data-telefono="${row.cli_telefono}"  
                         data-direccion="${row.cli_direccion}"  
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

    document.getElementById('cli_id').value = datos.id;
    document.getElementById('cli_nombre').value = datos.nombre;
    document.getElementById('cli_apellido').value = datos.apellido;
    document.getElementById('cli_nit').value = datos.nit;
    document.getElementById('cli_telefono').value = datos.telefono;
    document.getElementById('cli_direccion').value = datos.direccion;

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    window.scrollTo({
        top: 0
    });
}

const limpiarTodo = () => {
    FormClientes.reset();
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
    InputClienteTelefono.classList.remove('is-valid', 'is-invalid');
    InputClienteNit.classList.remove('is-valid', 'is-invalid');
    
    // Limpiar errores visuales
    const campos = ['cli_nombre', 'cli_apellido', 'cli_nit', 'cli_telefono'];
    campos.forEach(campoId => {
        const campo = document.getElementById(campoId);
        if (campo) {
            campo.classList.remove('is-invalid', 'is-valid');
        }
    });
}

const ModificarCliente = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormClientes, ['cli_id'])) {
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

    const body = new FormData(FormClientes);
    const url = '/proyecto01/cliente/modificarAPI';
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
            BuscarClientes();
        } 
        else if (codigo == 2) {
            await Swal.fire({
                position: "center",
                icon: "warning",
                title: "NIT Duplicado",
                text: "El número de NIT que ingresaste ya está registrado por otro cliente. Por favor, verifica el número.",
                showConfirmButton: true,
            });
            
            const campoNit = document.getElementById('cli_nit');
            campoNit.classList.add('is-invalid');
            campoNit.focus();
        }
        else if (codigo == 3) {
            await Swal.fire({
                position: "center",
                icon: "warning",
                title: "Teléfono Duplicado",
                text: "El número de teléfono que ingresaste ya está registrado por otro cliente. Por favor, usa un número diferente.",
                showConfirmButton: true,
            });
            
            const campoTelefono = document.getElementById('cli_telefono');
            campoTelefono.classList.add('is-invalid');
            campoTelefono.focus();
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

const EliminarClientes = async (e) => {
    const idCliente = e.currentTarget.dataset.id;

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
        const url = `/proyecto01/cliente/eliminarAPI?id=${idCliente}`;
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
                BuscarClientes();
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
                text: "No se pudo conectar con el servidor para eliminar el cliente.",
                showConfirmButton: true,
            });
        }
    }
}

datatable.on('click', '.eliminar', EliminarClientes);
datatable.on('click', '.modificar', llenarFormulario);
FormClientes.addEventListener('submit', GuardarCliente);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnModificar.addEventListener('click', ModificarCliente);
BtnBuscar.addEventListener('click', BuscarClientes);
InputClienteTelefono.addEventListener('change', ValidarTelefono);
InputClienteNit.addEventListener('change', ValidarNIT);

document.getElementById('cli_nit').addEventListener('input', function() {
    this.classList.remove('is-invalid');
});

document.getElementById('cli_telefono').addEventListener('input', function() {
    this.classList.remove('is-invalid');
});