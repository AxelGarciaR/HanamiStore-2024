window.addEventListener('DOMContentLoaded', (event) => {
    const priceRange = document.getElementById('price-range');
    const priceValue = document.getElementById('price-value');
    const applyFiltersButton = document.getElementById('apply-filters');
    const productCards = document.querySelectorAll('.card');
    const noResults = document.getElementById('no-results');

    // Actualizar el valor del rango de precios al mover el slider
    priceRange.addEventListener('input', () => {
        priceValue.textContent = priceRange.value;
    });

    // Función para aplicar filtros
    const applyFilters = () => {
        const maxPrice = parseInt(priceRange.value);
        let hasResults = false;
        productCards.forEach(card => {
            const productPrice = parseInt(card.getAttribute('data-price'));
            if (productPrice <= maxPrice) {
                card.parentNode.style.display = 'block';
                hasResults = true;
            } else {
                card.parentNode.style.display = 'none';
            }
        });
        // Mostrar o ocultar el mensaje de no resultados
        noResults.style.display = hasResults ? 'none' : 'block';
    };

    // Agregar evento de clic al botón de aplicar filtros
    applyFiltersButton.addEventListener('click', applyFilters);

    // Seleccionar todos los detalles y resúmenes
    const details = document.querySelectorAll('details');
    const summaries = document.querySelectorAll('summary');

    // Agregar un evento de clic a cada resumen
    summaries.forEach(summary => {
        summary.addEventListener('click', () => {
            // Obtener el detalle asociado al resumen clicado
            const detail = summary.parentNode;

            // Verificar si el detalle está abierto o cerrado
            const isOpen = detail.open;

            // Si el detalle está abierto, aplicar animación de entrada a los productos
            if (isOpen) {
                const products = detail.nextElementSibling;
                products.style.opacity = 0; // Inicialmente, establecer la opacidad en 0 para la animación
                products.style.maxHeight = products.scrollHeight + 'px'; // Establecer la altura máxima para la animación de desplazamiento
                products.style.transition = 'opacity 0.3s ease, max-height 0.3s ease'; // Agregar transición suave

                // Retrasar ligeramente la animación para que la transición tenga tiempo para aplicarse
                setTimeout(() => {
                    products.style.opacity = 1; // Mostrar los productos
                }, 50);
            }
        });
    });
});
