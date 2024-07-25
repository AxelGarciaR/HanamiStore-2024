// Constante para completar la ruta de la API.
const PEDIDO_API = 'services/public/detalle_ordenes.php';
// Constante para establecer el cuerpo de la tabla.
const TABLE_BODY = document.getElementById('carritoLista');
// Constante para establecer la caja de diálogo de cambiar producto.
const ITEM_MODAL = new bootstrap.Modal('#itemModal');
// Constante para establecer el formulario de cambiar producto.
const ITEM_FORM = document.getElementById('itemForm');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para mostrar los productos del carrito de compras.
    readDetail();
});

// Método del evento para cuando se envía el formulario de cambiar cantidad de producto.
ITEM_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(ITEM_FORM);
    // Petición para actualizar la cantidad de producto.
    const DATA = await fetchData(PEDIDO_API, 'updateDetail', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se actualiza la tabla para visualizar los cambios.
        readDetail();
        // Se cierra la caja de diálogo del formulario.
        ITEM_MODAL.hide();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, DATA.message, true, "Carrito.html");
    } else {
        sweetAlert(2, DATA.error, false);
    }
});

/*
*   Función para obtener el detalle del carrito de compras.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
async function readDetail() {
    try {
        // Petición para obtener los datos del pedido en proceso.
        const DATA = await fetchData(PEDIDO_API, 'readDetail');

        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (DATA.status) {
            // Se inicializa el cuerpo de la tabla.
            TABLE_BODY.innerHTML = '';
            // Se declara e inicializa una variable para calcular el importe por cada producto.
            let subtotal = 0;
            // Se declara e inicializa una variable para sumar cada subtotal y obtener el monto final a pagar.
            let total = 0;
            // Se recorre el conjunto de registros fila por fila a través del objeto row.
            DATA.dataset.forEach(row => {
                subtotal = row.precio_unitario * row.cantidad;
                total += subtotal;
                // Se crean y concatenan las filas de la tabla con los datos de cada registro.
                TABLE_BODY.innerHTML += `
                <div class="card col-12  mb-4 rounded rounded-white">
                <div class="row">
                    <div class="col-md-4">
                        <img src="../../Resources/images/allclean.png" class="img-fluid" alt="Producto 2">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">${row.Nombre_Producto}</h5>
                            <p class="card-text">$${row.precio_unitario}</p>
                            <p class="card-text">Cantidad: ${row.cantidad}</p>
                            <p class="card-text">Total de producto: $${subtotal.toFixed(2)}</p>
                            <button type="button" onclick="openUpdate(${row.id_detalle}, ${row.cantidad})"
                                class="btn btn-danger btn-block btn-pale-pink">Cantidad</button>
                            <button type="button" onclick="openDelete(${row.id_detalle})"
                                class="btn btn-danger btn-block btn-pale-pink">Eliminar</button>
                        </div>
                    </div>
                </div>
                `;
            });
            // Se muestra el total a pagar con dos decimales.
            document.getElementById('pago').textContent = total.toFixed(2);
        } else {
            sweetAlert(4, DATA.error, false);
        }
    } catch (error) {
        console.error('Error al obtener datos del pedido:', error);
    }
}


/*
*   Función para abrir la caja de diálogo con el formulario de cambiar cantidad de producto.
*   Parámetros: id (identificador del producto) y quantity (cantidad actual del producto).
*   Retorno: ninguno.
*/
function openUpdate(id, quantity) {
    // Se abre la caja de diálogo que contiene el formulario.
    ITEM_MODAL.show();
    // Se inicializan los campos del formulario con los datos del registro seleccionado.
    document.getElementById('idDetalle').value = id;
    document.getElementById('cantidadProducto').value = quantity;
}

/*
*   Función asíncrona para mostrar un mensaje de confirmación al momento de finalizar el pedido.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
async function finishOrder() {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Está seguro de finalizar el pedido?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Petición para finalizar el pedido en proceso.
        const DATA = await fetchData(PEDIDO_API, 'finishOrder');
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (DATA.status) {
            //Se abre la factura 
            openFactura();
            //Se mustra la alerta de exito
            sweetAlert(1, DATA.message, true);
            // Recargar la página si la respuesta no es satisfactoria.
            window.location.reload();
        } else {
            sweetAlert(2, DATA.error, false);
        }
    }
}

/*
*   Función asíncrona para mostrar un mensaje de confirmación al momento de eliminar un producto del carrito.
*   Parámetros: id (identificador del producto).
*   Retorno: ninguno.
*/
async function openDelete(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Está seguro de remover el producto?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define un objeto con los datos del producto seleccionado.
        const FORM = new FormData();
        FORM.append('idDetalle', id);
        // Petición para eliminar un producto del carrito de compras.
        const DATA = await fetchData(PEDIDO_API, 'deleteDetail', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (DATA.status) {
            await sweetAlert(1, DATA.message, true);
            // Se carga nuevamente la tabla para visualizar los cambios.
            readDetail();
        } else {
            sweetAlert(2, DATA.error, false);
        }
    }
}

const openFactura = () => {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/public/factura.php`);
    // Se abre el reporte en una nueva pestaña.
    window.open(PATH.href);
}