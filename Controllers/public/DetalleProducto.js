
//JS de calficacion de producto
const ratingInputs = document.querySelectorAll('input[name="rating"]');

ratingInputs.forEach(input => {
  input.addEventListener('change', () => {
    console.log('Calificación seleccionada:', input.value);
  });
});

const ratingValue = document.getElementById('ratingValue');

ratingInputs.forEach(input => {
  input.addEventListener('change', () => {
    const selectedRating = input.value;
    ratingValue.textContent = `${selectedRating}/5 estrellas`;
  });
});

//JS de contador de productos
document.addEventListener('DOMContentLoaded', function() {
  const minusButton = document.querySelector('.minus');
  const plusButton = document.querySelector('.plus');
  const numberDisplay = document.querySelector('.number');

  let count = 0;

  // Función para restar
  minusButton.addEventListener('click', function() {
    if (count > 0) { // Verifica si el contador es mayor que 0
      count--;
      numberDisplay.textContent = count;
    }
  });

  // Función para sumar
  plusButton.addEventListener('click', function() {
    count++;
    numberDisplay.textContent = count;
  });
});

//JS de contador de comentarios

// Obtener el número de divs dentro del contenedor de comentarios
var container = document.getElementById('containerComentarios');
var divs = container.getElementsByTagName('div');
var numDivs = divs.length;

// Actualizar el texto del h3 con el número de comentarios
var contador = document.getElementById('contador');
contador.textContent = numDivs.toString();
