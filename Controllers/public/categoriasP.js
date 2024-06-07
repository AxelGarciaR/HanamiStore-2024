// Constante para completar la ruta de la API.
const PRODUCTO_API = 'services/public/productos.php';
// Constante tipo objeto para obtener los parámetros disponibles en la URL.
const PARAMS = new URLSearchParams(location.search);
const PRODUCTOS = document.getElementById('productos');
const MAIN_TITLE = document.getElementById('main-title');

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    // Se define un objeto con los datos de la categoría seleccionada.
    const FORM = new FormData();
    FORM.append('idCategoria', PARAMS.get('id'));
    // Petición para solicitar los productos de la categoría seleccionada.
    const DATA = await fetchData(PRODUCTO_API, 'newProduct', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se inicializa el contenedor de productos.
        PRODUCTOS.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se crean y concatenan las tarjetas con los datos de cada producto.
            PRODUCTOS.innerHTML += `
                <div class="col-sm-12 col-md-6 col-lg-3">
                    <div class="card mb-3">
                        <img src="${SERVER_URL}images/productos/${row.imagen_principal}" class="card-img-top" alt="${row.Nombre_Producto}">
                        <div class="card-body">
                            <h5 class="card-title">${row.Nombre_Producto}</h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Precio unitario (US$) ${row.precio_producto}</li>
                            <li class="list-group-item">Existencias ${row.CantidadP}</li>
                        </ul>
                        <div class="card-body text-center">
                            <a href="DetalleProducto.html?id=${row.id_Producto}" class="btn btn-primary">Ver detalle</a>
                        </div>
                    </div>
                </div>
            `;
        });
    }
});

// Método manejador de eventos para el botón de búsqueda.
document.getElementById('searchButton').addEventListener('click', async () => {
    // Obtener el valor del campo de búsqueda.
    const searchInput = document.getElementById('searchInput').value.trim();

    // Verificar si el campo de búsqueda está vacío.
    if (searchInput !== '') {
        // Crear un FormData con el término de búsqueda.
        const formData = new FormData();
        formData.append('search', searchInput);

        try {
            // Realizar una solicitud al servidor para buscar productos.
            const searchData = await fetchData(PRODUCTO_API, 'searchRows', formData);

            // Verificar si la búsqueda fue exitosa.
            if (searchData.status) {
                // Limpiar el contenedor de productos.
                PRODUCTOS.innerHTML = '';

                // Verificar si se encontraron resultados.
                if (searchData.dataset.length > 0) {
                    // Iterar sobre los resultados y mostrarlos en la vista.
                    searchData.dataset.forEach(row => {
                        PRODUCTOS.innerHTML += `
                            <div class="col-sm-12 col-md-6 col-lg-3">
                                <div class="card mb-3">
                                    <img src="${SERVER_URL}images/productos/${row.imagen_principal}" class="card-img-top" alt="${row.Nombre_Producto}">
                                    <div class="card-body">
                                        <h5 class="card-title">${row.Nombre_Producto}</h5>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Precio unitario (US$) ${row.precio_producto}</li>
                                        <li class="list-group-item">Existencias ${row.CantidadP}</li>
                                    </ul>
                                    <div class="card-body text-center">
                                        <a href="DetalleProducto.html?id=${row.id_Producto}" class="btn btn-primary">Ver detalle</a>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    // Mostrar un mensaje si no se encontraron resultados.
                    PRODUCTOS.innerHTML = '<p>No se encontraron productos.</p>';
                }
            } else {
                // Mostrar un mensaje si ocurrió un error durante la búsqueda.
                console.error('Error al buscar productos:', searchData.error);
                // Puedes mostrar un mensaje de error al usuario si lo deseas.
            }
        } catch (error) {
            console.error('Error al buscar productos:', error);
            // Puedes mostrar un mensaje de error al usuario si lo deseas.
        }
    } else {
        // Mostrar un mensaje si el campo de búsqueda está vacío.
        alert('Por favor ingresa un término de búsqueda.');
    }
});

// Función para cargar las plantillas de encabezado y pie de página.
function loadTemplate() {
    // Implementar la lógica para cargar el encabezado y pie de página según sea necesario.
}
