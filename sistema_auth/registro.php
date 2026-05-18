<?php
require 'conexion.php';
$mensaje_error = '';
$mensaje_exito = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cedula = trim($_POST['cedula']);
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $password = $_POST['password'];
    if (!empty($cedula) && !empty($nombre) && filter_var($correo, 
FILTER_VALIDATE_EMAIL) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT cedula FROM usuarios WHERE correo = :correo");
        $stmt->execute(['correo' => $correo]);
        if ($stmt->rowCount() > 0) {
            $mensaje_error = "El correo electrónico ya se encuentra registrado.";
        } else {
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO usuarios (cedula, nombre, correo, 
password) VALUES (:cedula, :nombre, :correo, :password)");
            try {
                $stmt->execute([
                    'cedula' => $cedula,
                    'nombre' => $nombre,
                    'correo' => $correo,
                    'password' => $password_hash
                ]);
                $mensaje_exito = "Usuario registrado con éxito. Puede iniciar 
sesión.";
            } catch (PDOException $e) {
                $mensaje_error = "Error interno del sistema al registrar: " . $e
>getMessage();
            }
        }
    } else {
        $mensaje_error = "Por favor, complete todos los campos de forma válida.";
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Crear Cuenta</h2>
        
        <?php if(!empty($mensaje_error)): ?>
            <div class="mensaje-error"><?php echo $mensaje_error; ?></div>
        <?php endif; ?>
        
        <?php if(!empty($mensaje_exito)): ?>
            <div class="mensaje-exito"><?php echo $mensaje_exito; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="cedula">Cédula de Identidad:</label>
            <input type="text" name="cedula" id="cedula" required>

            <label for="nombre">Nombre Completo:</label>
            <input type="text" name="nombre" id="nombre" required>

            <label for="correo">Correo Electrónico:</label>
            <input type="email" name="correo" id="correo" required>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Registrarse</button>
        </form>
        
        <a href="login.php">¿Ya tienes cuenta? Inicia Sesión</a>
    </div>
</body>
</html>