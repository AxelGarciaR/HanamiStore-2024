// Constante para completar la ruta de la API.
const PRODUCTO_API = 'services/admin/productos.php';

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Constante para obtener el número de horas.
    const HOUR = new Date().getHours();
    // Se define una variable para guardar un saludo.
    let greeting = '';
    // Dependiendo del número de horas transcurridas en el día, se asigna un saludo para el usuario.
    if (HOUR < 12) {
        greeting = 'Buenos días';
    } else if (HOUR < 19) {
        greeting = 'Buenas tardes';
    } else if (HOUR <= 23) {
        greeting = 'Buenas noches';
    }
    
    // Llamada a la funciones que generan los gráficos en la página web.
    graficoBarrasCategorias();
    graficoPastelCategorias();
    graficoProductosVendidos();
    graficoVentasMes();
    graficoEdadesClientes(); // Corrección aquí
});


/*
*   Función asíncrona para mostrar un gráfico de barras con la cantidad de productos por categoría.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const graficoBarrasCategorias = async () => {
    // Petición para obtener los datos del gráfico.
    const DATA = await fetchData(PRODUCTO_API, 'cantidadProductosCategoria');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let Subcategorias = [];
        let cantidades = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
           Subcategorias.push(row.nombre);
            cantidades.push(row.CantidadP);
        });
        // Llamada a la función para generar y mostrar un gráfico de barras. Se encuentra en el archivo components.js
        barGraph('chart1', Subcategorias, cantidades, 'Cantidad de productos', 'Cantidad de productos por Sub categoría');
    } else {
        document.getElementById('chart1').remove();
        console.log(DATA.error);
    }
}
 
/*
*   Función asíncrona para mostrar un gráfico de pastel con el porcentaje de productos por categoría.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const graficoPastelCategorias = async () => {
    // Petición para obtener los datos del gráfico.
    const DATA = await fetchData(PRODUCTO_API, 'porcentajeProductosCategoria');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a gráficar.
        let categorias = [];
        let porcentajes = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            categorias.push(row.nombre);
            porcentajes.push(row.porcentaje);
        });
        // Llamada a la función para generar y mostrar un gráfico de pastel. Se encuentra en el archivo components.js
        pieGraph('chart2', categorias, porcentajes, 'Porcentaje de productos por categoría');
    } else {
        document.getElementById('chart2').remove();
        console.log(DATA.error);
    }
}
 
const graficoProductosVendidos = async () => {
    const DATA = await fetchData(PRODUCTO_API, 'productosMasVendidos');
    if (DATA.status) {
        let productos = [];
        let cantidades = [];
        DATA.dataset.forEach(row => {
            productos.push(row.Nombre_Producto);
            cantidades.push(row.total_vendido);
        });
        renderChartPolar(document.getElementById('chart3').getContext('2d'), productos, cantidades, 'Productos más Vendidos');
    } else {
        document.getElementById('chart3').remove();
        console.log(DATA.error);
    }
}
 
const renderChartPolar = (context, labels, data, title) => {
    const randomColors = generateRandomColors(labels.length); // Generar colores aleatorios
 
    new Chart(context, {
        type: 'polarArea',
        data: {
            labels: labels,
            datasets: [{
                label: title,
                data: data,
                backgroundColor: randomColors
            }]
        },
        options: {
            responsive: true
        }
    });
};
 
// Función para generar colores aleatorios en formato RGB
const generateRandomColors = (numColors) => {
    const colors = [];
    for (let i = 0; i < numColors; i++) {
        const r = Math.floor(Math.random() * 256); // Valor aleatorio para rojo (0-255)
        const g = Math.floor(Math.random() * 256); // Valor aleatorio para verde (0-255)
        const b = Math.floor(Math.random() * 256); // Valor aleatorio para azul (0-255)
        colors.push(`rgb(${r}, ${g}, ${b})`); // Agregar color en formato RGB al arreglo
    }
    return colors;
};
 
const graficoVentasMes = async () => {
    const DATA = await fetchData(PRODUCTO_API, 'ventasPorMes');
    if (DATA.status) {
        let meses = [];
        let ventas = [];
        DATA.dataset.forEach(row => {
            meses.push(row.mes);
            ventas.push(row.cantidad_ventas);
        });
        renderChart(document.getElementById('chartVentasMes').getContext('2d'), 'line', meses, ventas, 'Ventas por Mes');
    } else {
        document.getElementById('chartVentasMes').remove();
        console.log(DATA.error);
    }
}
 
const graficoEdadesClientes = async () => {
    const DATA = await fetchData(CLIENTE_API, 'edadesClientes'); // Usar CLIENTE_API en lugar de PRODUCTO_API
    if (DATA.status) {
        let rangos = [];
        let cantidades = [];
        DATA.dataset.forEach(row => {
            rangos.push(row.rango);
            cantidades.push(row.cantidad);
        });
        renderChart(document.getElementById('chartEdadesClientes').getContext('2d'), 'bar', rangos, cantidades, 'Edades de Clientes');
    } else {
        document.getElementById('chartEdadesClientes').remove();
        console.log(DATA.error);
    }
}
 
// Función para renderizar los gráficos
const renderChart = (context, type, labels, data, title) => {
    new Chart(context, {
        type: type,
        data: {
            labels: labels,
            datasets: [{
                label: title,
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
};

/****LLAMADA PARA ABRIR LAS GRAFICAS****/

const openReportClientes = () => {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/admin/clientes_report.php`);
    // Se abre el reporte en una nueva pestaña.
    window.open(PATH.href);
}

const openReportProductosMarcas = () => {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/admin/productos_marca_report.php`);
    // Se abre el reporte en una nueva pestaña.
    window.open(PATH.href);
}