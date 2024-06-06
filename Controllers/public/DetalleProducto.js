// Constantes para completar la ruta de la API.
const PRODUCTO_API = 'services/public/productos.php';
const PEDIDO_API = 'services/public/detalle_ordenes.php';
// Constante tipo objeto para obtener los parámetros disponibles en la URL.
const PARAMS = new URLSearchParams(location.search);
// Constante para el container de comentarios
const COMENTARIOS = document.getElementById('contenedorComentarios');
// Constante para establecer el formulario de agregar un producto al carrito de compras.
const SHOPPING_FORM = document.getElementById('shoppingForm');

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Se establece el título del contenido principal.
    const MAIN_TITLE = document.getElementById('mainTitle');
    MAIN_TITLE.textContent = 'Detalles del producto';
    // Constante tipo objeto con los datos del producto seleccionado.
    const FORM = new FormData();
    FORM.append('idProducto', PARAMS.get('id'));
    // Petición para solicitar los datos del producto seleccionado.
    const DATA = await fetchData(PRODUCTO_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se colocan los datos en la página web de acuerdo con el producto seleccionado previamente.
        const product = DATA.dataset;
        document.getElementById('imagenProducto').src = SERVER_URL.concat('images/productos/', product.imagen_principal);
        document.getElementById('nombreProducto').textContent = product.Nombre_Producto;
        document.getElementById('descripcionProducto').textContent = product.descripcion_producto;
        document.getElementById('precioProducto').textContent = product.precio_producto;
        document.getElementById('existenciasProducto').textContent = product.CantidadP;
        document.getElementById('idProducto').value = product.id_Producto;

    } else {
        // Se presenta un mensaje de error cuando no existen datos para mostrar.
        MAIN_TITLE.textContent = DATA.error;
        // Se limpia el contenido cuando no hay datos para mostrar.
        document.getElementById('detalle').innerHTML = '';
    }
    readComment();
});

// Método del evento para cuando se envía el formulario de agregar un producto al carrito.
SHOPPING_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SHOPPING_FORM);
    // Petición para guardar los datos del formulario.
    const DATA = await fetchData(PEDIDO_API, 'createDetail', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se constata si el cliente ha iniciado sesión.
    if (DATA.status) {
        sweetAlert(1, DATA.message, false, 'Carrito.html');
    } else if (DATA.session) {
        sweetAlert(2, DATA.error, false);
    } else {
        sweetAlert(3, DATA.error, true, 'index.html');
    }
});

async function readComment() {

    const FORM = new FormData();
    FORM.append('idProducto', PARAMS.get('id'));
    
    const DATA = await fetchData(PEDIDO_API, 'readComment', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {

        // Se inicializa el contenedor de productos.
        COMENTARIOS.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.COMENTARIOS.forEach(row => {
            // Se crean y concatenan las tarjetas con los datos de cada producto.
            COMENTARIOS.innerHTML += `
                <div class="cardComentario">

                    <div class="puntuacion">
                        <p>${row.puntuacion}/5</p>
                        <img src="../../Resources/images/star.png" alt="">
                    </div>
                    
                    <br>
                    
                    <div class="comentario">
                        <p>${row.comentario}</p>
                    </div>
    
                </div>
            `;
        });
    }
}

// Función para cargar las plantillas de encabezado y pie de página.
function loadTemplate() {
    // Implementar la lógica para cargar el encabezado y pie de página según sea necesario.
}
