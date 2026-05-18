<?php
session_start();
require 'conexion.php';
$mensaje_error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = trim($_POST['correo']);
    $password = $_POST['password'];
    if (filter_var($correo, FILTER_VALIDATE_EMAIL) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = :correo");
        $stmt->execute(['correo' => $correo]);
        $usuario = $stmt->fetch();
        if ($usuario && password_verify($password, $usuario['password'])) {
            $_SESSION['usuario_cedula'] = $usuario['cedula'];
            header("Location: perfil.php");
            exit;
        } else {
            $mensaje_error = "Las credenciales ingresadas son incorrectas.";
        }
    } else {
        $mensaje_error = "Por favor, introduce un correo y contraseña válidos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">    
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Iniciar Sesión</h2>
        
        <?php if(!empty($mensaje_error)): ?>
            <div class="mensaje-error"><?php echo $mensaje_error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Ingresar</button>
        </form>
        <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a>.</p>
    </div>
</body>
</html> 