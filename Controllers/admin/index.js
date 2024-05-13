<?php
session_start();
require_once('../../helpers/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta SQL para verificar las credenciales
    $sql = 'SELECT id_usuario, nombre_usuario, clave FROM usuarios WHERE nombre_usuario = ?';
    $params = array($username);
    $user = Database::getRow($sql, $params);

    if ($user && password_verify($password, $user['clave'])) {
        // Inicio de sesión exitoso
        $_SESSION['id_usuario'] = $user['id_usuario'];
        $_SESSION['nombre_usuario'] = $user['nombre_usuario'];
        header('Location: ../../Views/admin/Graficas.html');
        exit();
    } else {
        // Credenciales incorrectas
        header('Location: login.php?error=1');
        exit();
    }
} else {
    // Redireccionar si se accede directamente al script sin datos de formulario
    header('Location: login.php');
    exit();
}
?>
