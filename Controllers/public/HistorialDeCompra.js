// Constante para completar la ruta de la API.
const PEDIDO_API = 'services/public/detalle_ordenes.php';
// Constante para establecer el cuerpo de la tabla.
const TABLE_BODY = document.getElementById('cardRow');
// Constante para establecer la caja de diálogo de cambiar producto.
const ITEM_MODAL = new bootstrap.Modal('#itemModal');
// Constante para establecer el formulario de cambiar producto.
const ITEM_FORM = document.getElementById('itemForm');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para mostrar los productos del carrito de compras.
    readRecord();
});

// Método del evento para cuando se envía el formulario de cambiar cantidad de producto.
ITEM_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(ITEM_FORM);
    // Petición para actualizar la cantidad de producto.
    const DATA = await fetchData(PEDIDO_API, 'updateComment', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se actualiza la tabla para visualizar los cambios.
        readRecord();
        // Se cierra la caja de diálogo del formulario.
        ITEM_MODAL.hide();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, DATA.message, true);
    } else {
        sweetAlert(2, DATA.error, false);
    }
});

/*
*   Función para obtener el detalle del carrito de compras.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
async function readRecord() {
    // Petición para obtener los datos del pedido en proceso.
    const DATA = await fetchData(PEDIDO_API, 'readRecord');
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
            <div class="col-md-4">
            <div class="card">
                <img src="../../Resources/images/allclean.png" class="card-img-top" alt="Imagen 1">
                <div class="card-body">
                    <h5 class="card-title">${row.Nombre_Producto}</h5>
                    <hr>
                    <p class="card-text">Precio unitario: $${row.precio_unitario}</p>
                    <p class="card-text">Cantidad: ${row.cantidad}</p>
                    <p class="card-text">Fecha de compra: ${row.Fecha_Orden}</p>
                    <button type="button" onclick="openUpdate(${row.id_detalle}, ${row.comentario}, ${row.puntuacion })"
                        class="btn btn-primary add-review-btn">Agregar reseña</button>
                </div>
            </div>
        </div>
            `;
        });
    } else {
        sweetAlert(4, DATA.error, false);
    }
}

/*
*   Función para abrir la caja de diálogo con el formulario de cambiar cantidad de producto.
*   Parámetros: id (identificador del producto) y quantity (cantidad actual del producto).
*   Retorno: ninguno.
*/
function openUpdate(idDetalle, comentario, puntuacion) {
    // Se abre la caja de diálogo que contiene el formulario.
    ITEM_MODAL.show();
    // Se inicializan los campos del formulario con los datos del registro seleccionado.
    document.getElementById('idDetalle').value = idDetalle; 
    document.getElementById('comentarioProducto').value = comentario; 
    document.getElementById('puntuacionProducto').value = puntuacion; 
}

