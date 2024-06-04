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
        const selectedCategories = getSelectedCategories();
        let hasResults = false;
        productCards.forEach(card => {
            const productPrice = parseInt(card.getAttribute('data-price'));
            const productCategory = card.closest('.col-lg-4').getAttribute('data-category');
            if (productPrice <= maxPrice && (selectedCategories.length === 0 || selectedCategories.includes(productCategory))) {
                card.closest('.col-lg-4').style.display = 'block';
                hasResults = true;
            } else {
                card.closest('.col-lg-4').style.display = 'none';
            }
        });
        // Mostrar o ocultar el mensaje de no resultados
        noResults.style.display = hasResults ? 'none' : 'block';
    };

    // Agregar evento de clic al botón de aplicar filtros
    applyFiltersButton.addEventListener('click', applyFilters);

    // Obtener las categorías seleccionadas
    const getSelectedCategories = () => {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        const selectedCategories = [];
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedCategories.push(checkbox.id);
            }
        });
        return selectedCategories;
    };

    // Agregar eventos de cambio a todos los checkboxes
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', applyFilters);
    });
});
