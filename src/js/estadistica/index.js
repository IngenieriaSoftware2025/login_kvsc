import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";

const Chart = window.Chart || require('chart.js');

const grafico1 = document.getElementById("grafico1");
const grafico2 = document.getElementById("grafico2");
const grafico3 = document.getElementById("grafico3");
const grafico4 = document.getElementById("grafico4");

function getColorForEstado(cantidad) {
    let color = "";
    if(cantidad > 10){
        color = "paleturquoise";
    } else if(cantidad > 5 && cantidad <= 10){
        color = "pink";
    } else if(cantidad > 2 && cantidad <= 5){
        color = 'thistle';
    } else if(cantidad <= 2){
        color = 'peachpuff';
    }
    return color;
}

let graficaProductos, graficaClientes, graficaVentas, graficaReparaciones;

const inicializarGraficos = () => {
    try {
        graficaProductos = new Chart(grafico1, {
            type: 'bar',
            data: { labels: [], datasets: [] },
            options: { responsive: true }
        });

        graficaClientes = new Chart(grafico2, {
            type: 'bar',
            data: { labels: [], datasets: [] },
            options: { responsive: true, indexAxis: 'y' }
        });

        graficaVentas = new Chart(grafico3, {
            type: 'line',
            data: { labels: [], datasets: [] },
            options: { responsive: true }
        });

        graficaReparaciones = new Chart(grafico4, {
            type: 'doughnut',
            data: { labels: [], datasets: [] },
            options: { responsive: true }
        });
    } catch (error) {
        console.error('Error al inicializar gráficos:', error);
    }
}

const BuscarProductos = async () => {
    try {
        const respuesta = await fetch('/proyecto01/estadistica/buscarAPI');
        const datos = await respuesta.json();
        
        if (datos.codigo == 1) {
            const productos = [];
            const datosProductos = new Map();
            
            datos.data.forEach(d => {
                if (!datosProductos.has(d.producto)) {
                    datosProductos.set(d.producto, d.cantidad);
                    productos.push({ 
                        producto: d.producto, 
                        inv_id: d.inv_id, 
                        cantidad: d.cantidad 
                    });
                }
            });
            
            const etiquetasProductos = [...new Set(datos.data.map(d => d.producto))];
            const datasets = productos.map(e => ({
                label: e.producto,
                data: etiquetasProductos.map(productos => {
                    const match = datos.data.find(d => d.producto === productos && e.producto === d.producto);
                    return match ? match.cantidad : 0;
                }),
                backgroundColor: getColorForEstado(e.cantidad)
            }));
            
            graficaProductos.data.labels = etiquetasProductos;
            graficaProductos.data.datasets = datasets;
            graficaProductos.update();
        }
    } catch (error) {
        console.log(error);
    }
}

const BuscarTopClientes = async () => {
    try {
        const respuesta = await fetch('/proyecto01/estadistica/clientesTopAPI');
        const datos = await respuesta.json();
        
        if (datos.codigo == 1) {
            const labels = datos.data.map(cliente => `${cliente.nombres} ${cliente.apellidos}`);
            const valores = datos.data.map(cliente => parseInt(cliente.total_productos));
            
            graficaClientes.data.labels = labels;
            graficaClientes.data.datasets = [{
                label: 'Productos Comprados',
                data: valores,
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40']
            }];
            graficaClientes.update();
        }
    } catch (error) {
        console.log(error);
    }
}

const BuscarVentasPorMes = async () => {
    try {
        const respuesta = await fetch('/proyecto01/estadistica/ventasPorMesAPI');
        const datos = await respuesta.json();
        
        if (datos.codigo == 1) {
            const labels = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
                           'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
            
            const valores = [
                parseInt(datos.data.enero) || 0, parseInt(datos.data.febrero) || 0, parseInt(datos.data.marzo) || 0,
                parseInt(datos.data.abril) || 0, parseInt(datos.data.mayo) || 0, parseInt(datos.data.junio) || 0,
                parseInt(datos.data.julio) || 0, parseInt(datos.data.agosto) || 0, parseInt(datos.data.septiembre) || 0,
                parseInt(datos.data.octubre) || 0, parseInt(datos.data.noviembre) || 0, parseInt(datos.data.diciembre) || 0
            ];
            
            graficaVentas.data.labels = labels;
            graficaVentas.data.datasets = [{
                label: 'Ventas por Mes',
                data: valores,
                borderColor: '#36A2EB',
                backgroundColor: 'rgba(54, 162, 235, 0.1)',
                fill: true
            }];
            graficaVentas.update();
        }
    } catch (error) {
        console.log(error);
    }
}

const BuscarReparacionesPorEstado = async () => {
    try {
        const respuesta = await fetch('/proyecto01/estadistica/reparacionesPorEstadoAPI');
        const datos = await respuesta.json();
        
        if (datos.codigo == 1) {
            const labels = datos.data.map(reparacion => reparacion.estado);
            const valores = datos.data.map(reparacion => parseInt(reparacion.cantidad));
            
            graficaReparaciones.data.labels = labels;
            graficaReparaciones.data.datasets = [{
                label: 'Reparaciones',
                data: valores,
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0']
            }];
            graficaReparaciones.update();
        }
    } catch (error) {
        console.log(error);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        inicializarGraficos();
        
        setTimeout(() => {
            BuscarProductos();
            BuscarTopClientes();
            BuscarVentasPorMes();
            BuscarReparacionesPorEstado();
        }, 500);
    }, 1000);
});