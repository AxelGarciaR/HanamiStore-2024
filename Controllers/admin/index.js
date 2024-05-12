const LOGIN_FORM = document.getElementById('loginForm');

LOGIN_FORM.addEventListener('submit', async (event) => {
    event.preventDefault();
    const formData = new FormData(LOGIN_FORM);

    try {
        const response = await fetch('../../controllers/admin/service.php?action=logIn', {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            throw new Error('Error al iniciar sesión');
        }

        const data = await response.json();

        if (data.status) {
            localStorage.setItem("idadmin", data.idadmin);
            localStorage.setItem("loginClicked", "true");

            // Aquí redireccionamos a la página de gráficas después del inicio de sesión
            window.location.href = '../../Views/admin/Graficas.html';
        } else {
            sweetAlert(2, data.error, false);
        }
    } catch (error) {
        console.error('Error:', error.message);
        sweetAlert(2, 'Error al procesar la solicitud', false);
    }
});
