import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";

const FormUsuarios = document.getElementById('FormUsuarios');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const InputUsuarioTel = document.getElementById('usuario_tel');
const InputUsuarioDpi = document.getElementById('usuario_dpi');
const InputConfirmarContra = document.getElementById('confirmar_contra');
const BtnBuscar = document.getElementById('BtnBuscar');

document.writeln("Hola Mundo");

const ValidarTelefono = () => {
    const CantidadDigitos = InputUsuarioTel.value;

    if (CantidadDigitos.length < 1) {
        InputUsuarioTel.classList.remove('is-valid', 'is-invalid');
    } else {
        if (CantidadDigitos.length != 8) {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Revise el numero de telefono",
                text: "La cantidad de digitos debe ser exactamente 8 digitos",
                showConfirmButton: true,
            });
            InputUsuarioTel.classList.remove('is-valid');
            InputUsuarioTel.classList.add('is-invalid');
        } else {
            InputUsuarioTel.classList.remove('is-invalid');
            InputUsuarioTel.classList.add('is-valid');
        }
    }
}

const ValidarDPI = () => {
    const dpi = InputUsuarioDpi.value;

    if (dpi.length < 1) {
        InputUsuarioDpi.classList.remove('is-valid', 'is-invalid');
    } else {
        if (dpi.length != 13) {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "DPI INVALIDO",
                text: "El DPI debe tener exactamente 13 digitos",
                showConfirmButton: true,
            });
            InputUsuarioDpi.classList.remove('is-valid');
            InputUsuarioDpi.classList.add('is-invalid');
        } else {
            InputUsuarioDpi.classList.remove('is-invalid');
            InputUsuarioDpi.classList.add('is-valid');
        }
    }
}

const ValidarContraseñas = () => {
    const contra1 = document.getElementById('usuario_contra').value;
    const contra2 = document.getElementById('confirmar_contra').value;
    const campo2 = document.getElementById('confirmar_contra');

    if (contra2.length < 1) {
        campo2.classList.remove('is-valid', 'is-invalid');
    } else {
        if (contra1 !== contra2) {
            campo2.classList.remove('is-valid');
            campo2.classList.add('is-invalid');
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Las contraseñas no coinciden",
                text: "Debe confirmar correctamente su contraseña",
                showConfirmButton: true,
            });
        } else {
            campo2.classList.remove('is-invalid');
            campo2.classList.add('is-valid');
        }
    }
}


const GuardarUsuario = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormUsuarios, ['usuario_id'])) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe de validar todos los campos",
            showConfirmButton: true,
        });
        BtnGuardar.disabled = false;
        return;
    }

    const body = new FormData(FormUsuarios);
    const url = '/proyecto01/registro/guardarAPI';
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
                title: "Exito",
                text: mensaje,
                showConfirmButton: true,
            });
            limpiarTodo();
            // BuscarUsuarios(); PARA BUSCAR EN AUTOMATICO
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
    BtnGuardar.disabled = false;
}

const BuscarUsuarios = async () => {
    const url = '/proyecto01/registro/buscarAPI';
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

const datatable = new DataTable('#TableUsuarios', {
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
            data: 'usuario_id',
            width: '5%',
            render: (data, type, row, meta) => meta.row + 1
        },
        { title: 'Primer Nombre', data: 'usuario_nom1' },
        { title: 'Segundo Nombre', data: 'usuario_nom2' },
        { title: 'Primer Apellido', data: 'usuario_ape1' },
        { title: 'Segundo Apellido', data: 'usuario_ape2' },
        { title: 'Teléfono', data: 'usuario_tel' },
        { title: 'DPI', data: 'usuario_dpi' },
        { title: 'Correo', data: 'usuario_correo' },
        { title: 'Dirección', data: 'usuario_direc' },
        {
            title: 'Fotografía',
            data: 'usuario_fotografia_base64',
            render: (data, type, row) => {
                if (data) {
                    return `<img src="${data}" class="img-thumbnail rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">`;
                }
                return '<span class="text-muted">Sin foto</span>';
            }
        },
        { title: 'Fecha Creación', data: 'usuario_fecha_creacion' },
        {
            title: 'Estado',
            data: 'usuario_situacion',
            render: (data, type, row) => {
                return data == 1 ? '<span class="badge bg-success">ACTIVO</span>' : '<span class="badge bg-danger">INACTIVO</span>';
            }
        },
        {
            title: 'Acciones',
            data: 'usuario_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => {
                return `
                 <div class='d-flex justify-content-center'>
                     <button class='btn btn-warning modificar mx-1' 
                         data-id="${data}" 
                         data-nom1="${row.usuario_nom1}"  
                         data-nom2="${row.usuario_nom2}"  
                         data-ape1="${row.usuario_ape1}"  
                         data-ape2="${row.usuario_ape2}"  
                         data-tel="${row.usuario_tel}"  
                         data-direc="${row.usuario_direc}"  
                         data-dpi="${row.usuario_dpi}"  
                         data-correo="${row.usuario_correo}"  
                         data-fecha="${row.usuario_fecha_creacion}"  
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

    document.getElementById('usuario_id').value = datos.id;
    document.getElementById('usuario_nom1').value = datos.nom1;
    document.getElementById('usuario_nom2').value = datos.nom2;
    document.getElementById('usuario_ape1').value = datos.ape1;
    document.getElementById('usuario_ape2').value = datos.ape2;
    document.getElementById('usuario_tel').value = datos.tel;
    document.getElementById('usuario_direc').value = datos.direc;
    document.getElementById('usuario_dpi').value = datos.dpi;
    document.getElementById('usuario_correo').value = datos.correo;
    document.getElementById('usuario_fecha_creacion').value = datos.fecha;

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    window.scrollTo({
        top: 0
    });
}

const limpiarTodo = () => {
    FormUsuarios.reset();
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
    InputUsuarioTel.classList.remove('is-valid', 'is-invalid');
    InputUsuarioDpi.classList.remove('is-valid', 'is-invalid');
}

const ModificarUsuario = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormUsuarios, [''])) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe de validar todos los campos",
            showConfirmButton: true,
        });
        BtnModificar.disabled = false;
        return;
    }

    const body = new FormData(FormUsuarios);
    const url = '/proyecto01/registro/modificarAPI';
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
                title: "Exito",
                text: mensaje,
                showConfirmButton: true,
            });
            limpiarTodo();
            BuscarUsuarios();
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
    BtnModificar.disabled = false;
}

const EliminarUsuarios = async (e) => {
    const idUsuario = e.currentTarget.dataset.id;

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
        const url = `/proyecto01/registro/eliminar?id=${idUsuario}`;
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
                    title: "Exito",
                    text: mensaje,
                    showConfirmButton: true,
                });
                BuscarUsuarios();
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
}

// Event Listeners
// BuscarUsuarios(); BUSCAR USUARIOS EN AUTOMATICO
datatable.on('click', '.eliminar', EliminarUsuarios);
datatable.on('click', '.modificar', llenarFormulario);
FormUsuarios.addEventListener('submit', GuardarUsuario);
InputUsuarioDpi.addEventListener('change', ValidarDPI);
InputUsuarioTel.addEventListener('change', ValidarTelefono);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnModificar.addEventListener('click', ModificarUsuario);
InputConfirmarContra.addEventListener('change', ValidarContraseñas);
BtnBuscar.addEventListener('click', BuscarUsuarios);