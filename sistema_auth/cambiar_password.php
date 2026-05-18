<?php
session_start();
require 'conexion.php';

// Validar que el usuario haya iniciado sesión
if (!isset($_SESSION['usuario_cedula'])) {
    header("Location: login.php");
    exit;
}

$mensaje_error = '';
$mensaje_exito = '';

// Procesar el cambio de contraseña al enviar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pass_actual = $_POST['password_actual'];
    $pass_nueva = $_POST['password_nueva'];
    $pass_confirm = $_POST['password_confirm'];
    $cedula = $_SESSION['usuario_cedula'];

    // Verificar que ningún campo esté vacío
    if (!empty($pass_actual) && !empty($pass_nueva) && !empty($pass_confirm)) {
        
        // Comprobar que las contraseñas nuevas coincidan
        if ($pass_nueva === $pass_confirm) {
            
            // Obtener el hash de la contraseña actual desde la base de datos
            $stmt = $pdo->prepare("SELECT password FROM usuarios WHERE cedula = :cedula");
            $stmt->execute(['cedula' => $cedula]);
            $usuario = $stmt->fetch();

            // Verificar si la contraseña actual ingresada coincide con el hash guardado
            if (password_verify($pass_actual, $usuario['password'])) {
                
                // Encriptar la nueva contraseña
                $nuevo_hash = password_hash($pass_nueva, PASSWORD_BCRYPT);
                
                // Actualizar la contraseña en la base de datos
                $stmt_update = $pdo->prepare("UPDATE usuarios SET password = :password WHERE cedula = :cedula");
                $stmt_update->execute(['password' => $nuevo_hash, 'cedula' => $cedula]);
                
                $mensaje_exito = "Tu contraseña ha sido actualizada con éxito.";
            } else {
                $mensaje_error = "La contraseña actual que ingresaste es incorrecta.";
            }
        } else {
            $mensaje_error = "Las contraseñas nuevas no coinciden entre sí.";
        }
    } else {
        $mensaje_error = "Por favor, completa todos los campos solicitados.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambiar Contraseña</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Actualizar Contraseña</h2>
        
        <?php if(!empty($mensaje_error)): ?>
            <div class="mensaje-error"><?php echo $mensaje_error; ?></div>
        <?php endif; ?>
        
        <?php if(!empty($mensaje_exito)): ?>
            <div class="mensaje-exito"><?php echo $mensaje_exito; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="password_actual">Contraseña Actual:</label>
            <input type="password" name="password_actual" id="password_actual" required>

            <label for="password_nueva">Nueva Contraseña:</label>
            <input type="password" name="password_nueva" id="password_nueva" required>

            <label for="password_confirm">Confirmar Nueva Contraseña:</label>
            <input type="password" name="password_confirm" id="password_confirm" required>

            <button type="submit">Actualizar Contraseña</button>
        </form>

        <div style="margin-top: 20px;">
            <a href="perfil.php">← Volver a Mi Perfil</a>
        </div>
    </div>
</body>
</html>