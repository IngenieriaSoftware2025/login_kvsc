import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";

const FormReparaciones = document.getElementById('FormReparaciones');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const BtnBuscar = document.getElementById('BtnBuscar');
const SelectCliente = document.getElementById('rep_cliente_id');
const InputFalla = document.getElementById('rep_falla');

const ValidarFalla = () => {
    const falla = InputFalla.value.trim();

    if (falla.length < 1) {
        InputFalla.classList.remove('is-valid', 'is-invalid');
    } else {
        if (falla.length < 5) {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Descripción muy corta",
                text: "La descripción de la falla debe ser más detallada (mínimo 5 caracteres)",
                showConfirmButton: true,
            });
            InputFalla.classList.remove('is-valid');
            InputFalla.classList.add('is-invalid');
        } else {
            InputFalla.classList.remove('is-invalid');
            InputFalla.classList.add('is-valid');
        }
    }
}

const CargarClientes = async () => {
    const url = '/proyecto01/reparacion/buscarClientesAPI';
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
                option.textContent = `${cliente.cli_nombre} ${cliente.cli_apellido} - Tel: ${cliente.cli_telefono}`;
                SelectCliente.appendChild(option);
            });
        } else {
            console.error('Error al cargar clientes:', mensaje);
        }
    } catch (error) {
        console.error('Error al cargar clientes:', error);
    }
}

const GuardarReparacion = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormReparaciones, ['rep_id'])) {
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

    const body = new FormData(FormReparaciones);
    const url = '/proyecto01/reparacion/guardarAPI';
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
                title: "¡Reparación Registrada!",
                text: mensaje,
                showConfirmButton: true,
            });
            limpiarTodo();
        } else {
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

const BuscarReparaciones = async () => {
    const url = '/proyecto01/reparacion/buscarAPI';
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

const datatable = new DataTable('#TableReparaciones', {
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
            data: 'rep_id',
            width: '5%',
            render: (data, type, row, meta) => meta.row + 1
        },
        { 
            title: 'Cliente', 
            data: 'cli_nombre',
            render: (data, type, row) => `${row.cli_nombre} ${row.cli_apellido}`
        },
        { title: 'Equipo', data: 'rep_equipo' },
        { title: 'Marca', data: 'rep_marca' },
        { title: 'Falla', data: 'rep_falla' },
        { 
            title: 'Costo', 
            data: 'rep_costo',
            render: (data, type, row) => {
                if (data && data > 0) {
                    return `Q. ${parseFloat(data).toFixed(2)}`;
                }
                return '<span class="text-muted">Pendiente</span>';
            }
        },
        { 
            title: 'F. Ingreso', 
            data: 'rep_fecha_ingreso',
            render: (data, type, row) => {
                if (data) {
                    const fecha = new Date(data);
                    return fecha.toLocaleDateString('es-GT');
                }
                return '-';
            }
        },
        { 
            title: 'F. Entrega', 
            data: 'rep_fecha_entrega',
            render: (data, type, row) => {
                if (data) {
                    const fecha = new Date(data);
                    return fecha.toLocaleDateString('es-GT');
                }
                return '<span class="text-muted">Pendiente</span>';
            }
        },
        {
            title: 'Estado',
            data: 'rep_estado',
            render: (data, type, row) => {
                let badge = 'bg-secondary';
                switch(data) {
                    case 'RECIBIDO':
                        badge = 'bg-info';
                        break;
                    case 'EN_PROCESO':
                        badge = 'bg-warning';
                        break;
                    case 'REPARADO':
                        badge = 'bg-primary';
                        break;
                    case 'ENTREGADO':
                        badge = 'bg-success';
                        break;
                }
                return `<span class="badge ${badge}">${data}</span>`;
            }
        },
        {
            title: 'Situación',
            data: 'rep_situacion',
            render: (data, type, row) => {
                return data == 1 ? '<span class="badge bg-success">ACTIVO</span>' : '<span class="badge bg-danger">INACTIVO</span>';
            }
        },
        {
            title: 'Acciones',
            data: 'rep_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => {
                return `
                 <div class='d-flex justify-content-center'>
                     <button class='btn btn-warning modificar mx-1' 
                         data-id="${data}" 
                         data-cliente="${row.rep_cliente_id}"  
                         data-equipo="${row.rep_equipo}"  
                         data-marca="${row.rep_marca}"  
                         data-falla="${row.rep_falla}"  
                         data-diagnostico="${row.rep_diagnostico || ''}"  
                         data-costo="${row.rep_costo || ''}"  
                         data-entrega="${row.rep_fecha_entrega || ''}"  
                         data-estado="${row.rep_estado}"  
                         data-observaciones="${row.rep_observaciones || ''}"  
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

    document.getElementById('rep_id').value = datos.id;
    document.getElementById('rep_cliente_id').value = datos.cliente;
    document.getElementById('rep_equipo').value = datos.equipo;
    document.getElementById('rep_marca').value = datos.marca;
    document.getElementById('rep_falla').value = datos.falla;
    document.getElementById('rep_diagnostico').value = datos.diagnostico;
    document.getElementById('rep_costo').value = datos.costo;
    document.getElementById('rep_fecha_entrega').value = datos.entrega;
    document.getElementById('rep_estado').value = datos.estado;
    document.getElementById('rep_observaciones').value = datos.observaciones;

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    window.scrollTo({
        top: 0
    });
}

const limpiarTodo = () => {
    FormReparaciones.reset();
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
    InputFalla.classList.remove('is-valid', 'is-invalid');
    
    document.getElementById('rep_estado').value = 'RECIBIDO';
    
    const campos = ['rep_cliente_id', 'rep_equipo', 'rep_marca', 'rep_falla'];
    campos.forEach(campoId => {
        const campo = document.getElementById(campoId);
        if (campo) {
            campo.classList.remove('is-invalid', 'is-valid');
        }
    });
}

const ModificarReparacion = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormReparaciones, ['rep_id'])) {
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

    const body = new FormData(FormReparaciones);
    const url = '/proyecto01/reparacion/modificarAPI';
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
            BuscarReparaciones();
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

const EliminarReparaciones = async (e) => {
    const idReparacion = e.currentTarget.dataset.id;

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
        const url = `/proyecto01/reparacion/eliminarAPI?id=${idReparacion}`;
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
                BuscarReparaciones();
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
                text: "No se pudo conectar con el servidor para eliminar la reparación.",
                showConfirmButton: true,
            });
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    CargarClientes();
});

datatable.on('click', '.eliminar', EliminarReparaciones);
datatable.on('click', '.modificar', llenarFormulario);
FormReparaciones.addEventListener('submit', GuardarReparacion);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnModificar.addEventListener('click', ModificarReparacion);
BtnBuscar.addEventListener('click', BuscarReparaciones);
InputFalla.addEventListener('change', ValidarFalla);

document.getElementById('rep_falla').addEventListener('input', function() {
    this.classList.remove('is-invalid');
});