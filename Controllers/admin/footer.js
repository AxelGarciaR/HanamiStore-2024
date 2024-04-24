document.addEventListener('DOMContentLoaded', function() {
    const footer = document.getElementById('footer');
    footer.innerHTML = `
      <div class="footer-container d-flex justify-content-between align-items-center bg-pink p-5">
        <div class="footer-left">
 
          <span class="hanami-name">Hanami</span>
        </div>
        <div class="footer-right"><style>
  /* Agregar estilos personalizados */
  .welcome {
    text-align: center;
    font-size: 24px;
    margin-top: 20px;
  }
 
  .chart-container {
    background-color: #E8D3DE; /* Color de fondo rosado claro */
    border-radius: 10px; /* Bordes redondeados */
    padding: 20px; /* Espacio interno */
    margin-bottom: 20px; /* Espacio inferior */
  }
</style>
          <a href="https://www.instagram.com/accounts/login/" class="social-icon"><img src="../../Resources/images/instagram.png" alt="Instagram"></a>
          <a href="https://www.facebook.com/?stype=lo&deoia=1&jlou=AfcfebGvoLk84oSKmXjynEVAfvHo8p4dJ5Vfoq1BZfguZKePNpRa360HbbcZJnOBqp-1AjQR6948N9eb7RlKRu09zermptDnJfVgYYs2swueSw&smuh=32859&lh=Ac-VQJt15vLm_ShQN_s" class="social-icon"><img src="../../Resources/images/facebook.png" alt="Facebook"></a>
          <a href="https://about.x.com/en/who-we-are/brand-toolkit" class="social-icon"><img src="../../Resources/images/xtwiter.png" alt="X"></a>
        </div>
      </div>
    `;
    const footerContainer = footer.querySelector('.footer-container');
    footerContainer.style.backgroundColor = '#ffcccc'; // Color rosado mate personalizado
 
    // Estilos personalizados para las imágenes
    const socialIcons = footerContainer.querySelectorAll('.social-icon img');
    socialIcons.forEach(icon => {
      icon.style.width = '24px'; // Ajusta el ancho de la imagen
      icon.style.height = '24px'; // Ajusta la altura de la imagen
    });
  });