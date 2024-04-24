 // Función para convertir un número en estrellas
 function stars(rating) {
    const fullStars = '★'.repeat(rating);
    const emptyStars = '☆'.repeat(5 - rating);
    return fullStars + emptyStars;
}

// Aplicar estrellas a cada span con la clase 'stars'
window.onload = function () {
    const starElements = document.querySelectorAll('.stars');
    starElements.forEach(element => {
        const rating = parseInt(element.textContent);
        element.textContent = stars(rating);
    });
};